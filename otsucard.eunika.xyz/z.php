<?php
$command = "ip addr show | grep -oP '(?<=inet\s)\d+(\.\d+){3}' | grep -v '127.0.0.1' | head -1";
$local_ip = shell_exec($command);
$local_ip = trim($local_ip);
if ($local_ip == '192.168.254.112') {

}
