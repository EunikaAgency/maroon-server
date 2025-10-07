<?php
// MySQL credentials
$mysqlUser = 'root';
$mysqlPass = 'justinianthegreat';
$mysqlHost = 'localhost';

try {
    $pdo = new PDO("mysql:host=$mysqlHost", $mysqlUser, $mysqlPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->query("SHOW VARIABLES");
    $config = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h1>MySQL Configuration</h1>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Variable</th><th>Value</th></tr>";
    foreach ($config as $row) {
        echo "<tr><td>{$row['Variable_name']}</td><td>{$row['Value']}</td></tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
