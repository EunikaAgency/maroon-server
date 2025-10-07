<?php
// export_db.php

// Ensure that only authorized requests can run this script
$authorized_key = "kamote"; // Replace this with your secret key
if (!isset($_GET['key']) || $_GET['key'] !== $authorized_key) {
    http_response_code(403);
    die("Unauthorized request");
}

// Database credentials
$DB_NAME = 'rbw-live';
$DB_USER = 'root';
$DB_PASS = 'justinianthegreat';
$DB_HOST = 'localhost';

// Check if specific tables are provided, otherwise export all tables
$tables = isset($_GET['tables']) && !empty($_GET['tables']) ? str_replace(',', ' ', escapeshellcmd($_GET['tables'])) : '*';

// Pagination controls for batching
$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10000; // Default to 10,000 rows per batch

// File path for the dump
$sql_dump = '/tmp/remote-db-' . date('Ymd-His') . '-batch-' . $start . '.sql';

// Command to export the specific batch with LIMIT and OFFSET, using REPLACE INTO
$command = $tables === '*' 
    ? "mysqldump --single-transaction --quick --user={$DB_USER} --password={$DB_PASS} --host={$DB_HOST} {$DB_NAME} --skip-add-locks --where='1 LIMIT {$start}, {$limit}' > {$sql_dump} 2> /tmp/mysqldump_error.log"
    : "mysqldump --single-transaction --quick --user={$DB_USER} --password={$DB_PASS} --host={$DB_HOST} {$DB_NAME} {$tables} --skip-add-locks --where='1=1 LIMIT {$start}, {$limit}' > {$sql_dump} 2> /tmp/mysqldump_error.log";


// Execute the dump command
exec($command, $output, $result);

// Check if the command was successful or log error details
if ($result !== 0 || !file_exists($sql_dump) || filesize($sql_dump) == 0) {
    echo "Error: Failed to export database or dump is empty.";
    echo "Error log from mysqldump: <br>";
    echo nl2br(file_get_contents('/tmp/mysqldump_error.log')); // Display the error log
    http_response_code(500);
    die("Database export failed.");
}

// Set headers to serve the SQL file
header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="remote-db.sql"');

// Read the file and serve it to the client
readfile($sql_dump);

// Clean up the dump file
unlink($sql_dump);

exit();
