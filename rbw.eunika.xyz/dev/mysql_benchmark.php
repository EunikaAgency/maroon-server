<?php
// MySQL credentials
$mysqlUser = 'dbmaster';
$mysqlPass = 'PEivO3N3w03gFkueRioKvhWV';
$mysqlHost = 'localhost';
$testDb = 'mysql_benchmark_test';
$domain = $_SERVER['HTTP_HOST']; // Dynamically captures the domain

try {
    // Create a new PDO connection with query buffering enabled
    $pdo = new PDO("mysql:host=$mysqlHost", $mysqlUser, $mysqlPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true // Enable query buffering
    ]);

    // Drop test database if it exists to start fresh
    $pdo->exec("DROP DATABASE IF EXISTS $testDb");
    $pdo->exec("CREATE DATABASE $testDb");
    $pdo->exec("USE $testDb");

    // Define parameters for tests
    $numRows = 1000;  // Rows for insert tests
    $numThreads = 10; // Simulate 10 concurrent users

    // Hardware metrics
    $cpuLoad = sys_getloadavg()[0]; // 1-minute load average
    $totalRam = intval(shell_exec("grep MemTotal /proc/meminfo | awk '{print $2}'")) / 1024 / 1024; // in GB
    $freeRam = intval(shell_exec("grep MemAvailable /proc/meminfo | awk '{print $2}'")) / 1024 / 1024; // in GB
    
    $startTime = microtime(true);
    $file = fopen('/tmp/tempfile', 'w');
    for ($i = 0; $i < 1024; $i++) { // Write 1 MB chunks 1024 times
        fwrite($file, str_repeat('A', 1024 * 1024));
    }
    fclose($file);
    $endTime = microtime(true);
    $diskWriteSpeedBytesPerSec = (1024 * 1024 * 1024) / ($endTime - $startTime); // Bytes per second

    // Convert to KB, MB, GB, etc.
    $units = ['B/s', 'KB/s', 'MB/s', 'GB/s', 'TB/s'];
    $unitIndex = 0;
    while ($diskWriteSpeedBytesPerSec >= 1024 && $unitIndex < count($units) - 1) {
        $diskWriteSpeedBytesPerSec /= 1024;
        $unitIndex++;
    }

    // Format with 2 decimal places
    $diskWriteSpeed = number_format($diskWriteSpeedBytesPerSec, 2) . ' ' . $units[$unitIndex];

    unlink('/tmp/tempfile'); // Clean up the temporary file


    // Helper functions
    function benchmark($pdo, $query, $isSelect = false) {
        $startTime = microtime(true);
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        if ($isSelect) {
            $stmt->fetchAll();  // Fetch all results if it's a SELECT query to clear the buffer
        }
        
        $endTime = microtime(true);
        return ($endTime - $startTime) * 1000; // Time in ms
    }

    function score($time) {
        if ($time < 5) return [10, "Excellent"];
        elseif ($time < 10) return [9, "Very Good"];
        elseif ($time < 20) return [8, "Good"];
        elseif ($time < 40) return [6, "Acceptable"];
        elseif ($time < 80) return [4, "Fair"];
        elseif ($time < 150) return [3, "Poor"];
        elseif ($time < 300) return [2, "Very Poor"];
        else return [1, "Unusable"];
    }
    

    // Initialize metrics array
    $metrics = [];

    // 1. Table creation with explicit column definitions
    $pdo->exec("
        CREATE TABLE benchmark_table (
            id INT PRIMARY KEY AUTO_INCREMENT,
            value VARCHAR(255),
            indexed_value INT, -- indexed_value column is defined here
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");

    // Check if table and columns exist
    $result = $pdo->query("DESCRIBE benchmark_table")->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_column($result, 'Field');
    
    if (!in_array('indexed_value', $columns)) {
        throw new Exception("Column 'indexed_value' was not created successfully.");
    }

    // 2. Insert test
    $insertTimes = [];
    for ($i = 0; $i < $numRows; $i++) {
        $insertTimes[] = benchmark($pdo, "INSERT INTO benchmark_table (value, indexed_value) VALUES ('dummy data', $i);");
    }
    $metrics['Insert Test'] = [
        'avg' => array_sum($insertTimes) / count($insertTimes),
        'min' => min($insertTimes),
        'max' => max($insertTimes)
    ];

    // 3. Bulk Insert test
    $metrics['Bulk Insert Test'] = benchmark($pdo, "
        INSERT INTO benchmark_table (value)
        SELECT 'bulk data' FROM benchmark_table LIMIT $numRows;
    ");

    // 4. Index Efficiency Test
    $pdo->exec("CREATE INDEX idx_value ON benchmark_table(indexed_value);");
    $metrics['Index Test'] = benchmark($pdo, "
        SELECT * FROM benchmark_table WHERE indexed_value = FLOOR(RAND() * $numRows);
    ", true);

    // 5. Update Test
    $metrics['Update Test'] = benchmark($pdo, "
        UPDATE benchmark_table SET value = 'updated data' WHERE id % 10 = 0;
    ");

    // 6. Complex Join Test
    $metrics['Complex Join Test'] = benchmark($pdo, "
        SELECT a.id, a.value, b.value 
        FROM benchmark_table a 
        JOIN benchmark_table b ON a.indexed_value = b.indexed_value 
        WHERE a.indexed_value < 100;
    ", true);

    // 7. Large Data Handling Test
    $metrics['Large Data Test'] = benchmark($pdo, "
        SELECT COUNT(*), AVG(id), MAX(id) FROM benchmark_table;
    ", true);

    // 8. Table Locking Test
    $metrics['Table Locking Test'] = benchmark($pdo, "
        LOCK TABLES benchmark_table WRITE;
        INSERT INTO benchmark_table (value) VALUES ('locked data');
        UNLOCK TABLES;
    ");

    // 9. Concurrency Test (Simulate multiple threads)
    $concurrentTimes = [];
    for ($i = 0; $i < $numThreads; $i++) {
        $concurrentTimes[] = benchmark($pdo, "INSERT INTO benchmark_table (value) VALUES ('concurrent data');");
    }
    $metrics['Concurrency Test'] = [
        'avg' => array_sum($concurrentTimes) / count($concurrentTimes),
        'min' => min($concurrentTimes),
        'max' => max($concurrentTimes)
    ];

    // 10. Transaction Performance Test
    $metrics['Transaction Test'] = benchmark($pdo, "
        START TRANSACTION;
        INSERT INTO benchmark_table (value) VALUES ('transaction data');
        INSERT INTO benchmark_table (value) VALUES ('transaction data');
        COMMIT;
    ");

    // Clean up - drop the test database
    $pdo->exec("DROP DATABASE $testDb");

    // Calculate hardware proportionality
    $avgCpuLoad = $cpuLoad / 4; // Assuming 4-core CPU
    $ramUsageRatio = ($totalRam - $freeRam) / $totalRam;
    $diskPerformanceComment = ($diskWriteSpeed > 100) ? "Good" : "May limit performance";

    // Generate HTML output with table and Chart.js script
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>MySQL Benchmark Test Results for <?php echo $domain; ?></title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { padding: 8px 12px; border: 1px solid #ccc; text-align: center; }
            th { background-color: #f4f4f4; }
        </style>
    </head>
    <body>
        <h1>MySQL Benchmark Test Results for <?php echo $domain; ?></h1>
        
        <table>
            <tr>
                <th>Test</th>
                <th>Avg Time (ms)</th>
                <th>Min Time (ms)</th>
                <th>Max Time (ms)</th>
                <th>Score</th>
                <th>Comment</th>
            </tr>
            <?php
            $chartLabels = [];
            $chartData = [];
            foreach ($metrics as $test => $result) {
                if (is_array($result)) {
                    $avg = number_format($result['avg'], 2);
                    $min = number_format($result['min'], 2);
                    $max = number_format($result['max'], 2);
                    list($score, $comment) = score($result['avg']);
                } else {
                    $avg = number_format($result, 2);
                    $min = $max = "-";
                    list($score, $comment) = score($result);
                }
                echo "<tr><td>$test</td><td>$avg</td><td>$min</td><td>$max</td><td>$score</td><td>$comment</td></tr>";

                $chartLabels[] = $test;
                $chartData[] = $avg;
            }
            ?>
        </table>

        <h2>Performance Chart</h2>
        <canvas id="performanceChart" style="max-height: 360px;"></canvas>
        <script>
            const ctx = document.getElementById('performanceChart').getContext('2d');
            const performanceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($chartLabels); ?>,
                    datasets: [{
                        label: 'Average Time (ms)',
                        data: <?php echo json_encode($chartData); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    },
                    plugins: {
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            formatter: (value) => `${value} ms`
                        }
                    }
                }
            });
        </script>

        <h3>Hardware Analysis:</h3>
        <p><strong>CPU Load (1-min avg):</strong> <?php echo number_format($cpuLoad, 2); ?> (Load proportionality: <?php echo ($avgCpuLoad < 1 ? "Good" : "High Load"); ?>)</p>
        <p><strong>Total RAM:</strong> <?php echo number_format($totalRam, 2); ?> GB</p>
        <p><strong>Available RAM:</strong> <?php echo number_format($freeRam, 2); ?> GB (Usage: <?php echo number_format($ramUsageRatio * 100, 2); ?>%)</p>
        <p><strong>Disk Write Speed:</strong> <?php echo $diskWriteSpeed; ?> MB/s (Disk performance: <?php echo $diskPerformanceComment; ?>)</p>
        
        <h3>MySQL Configuration</h3>
        <p><a href="mysql_config.php" target="_blank">View MySQL Configuration</a></p>
    </body>
    </html>
    <?php

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
