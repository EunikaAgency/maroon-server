<?php
/**
 * flush_memcache.php
 * 
 * This script flushes the entire Memcached cache for the website.
 * Use with caution, as it clears all cached data.
 */

function flushMemcache() {
    // Create a new Memcached instance
    $memcached = new Memcached();
    
    // Connect to the Memcached server (default IP and port)
    $memcached->addServer('127.0.0.1', 11211);

    // Attempt to flush all cached data
    $result = $memcached->flush();

    // Display the result
    if ($result) {
        echo "Memcached flush successful.";
    } else {
        echo "Failed to flush Memcached.";
    }
}

// Call the function to flush Memcached
flushMemcache();
?>
