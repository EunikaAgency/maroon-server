#!/bin/bash

# Set the current directory as the WordPress directory
WP_DIR="$(pwd)"

# Set the default ACL for directories and files
# Give www-data full access to everything, but restrict other users
echo "Setting ACLs for all files and directories in $WP_DIR..."

# Set ACL for directories (rwx for owner, rx for others)
find $WP_DIR -type d -exec setfacl -m u:www-data:rwx {} \;
find $WP_DIR -type d -exec setfacl -m u:$(whoami):rwx {} \;
find $WP_DIR -type d -exec setfacl -m d:u:www-data:rwx {} \;
find $WP_DIR -type d -exec setfacl -m d:u:$(whoami):rwx {} \;

# Set ACL for files (rw for owner, r for others)
find $WP_DIR -type f -exec setfacl -m u:www-data:rw {} \;
find $WP_DIR -type f -exec setfacl -m u:$(whoami):rw {} \;

# Apply stricter ACL to wp-config.php (only readable/writable by owner)
if [ -f "$WP_DIR/wp-config.php" ]; then
    echo "Setting restrictive ACL for wp-config.php..."
    setfacl -m u:www-data:rw $WP_DIR/wp-config.php
    setfacl -m u:$(whoami):rw $WP_DIR/wp-config.php
else
    echo "wp-config.php not found, skipping..."
fi

# Allow uploads and plugin/theme installations by setting ACL for wp-content, plugins, and uploads directories
if [ -d "$WP_DIR/wp-content" ]; then
    echo "Setting ACL for wp-content, plugins, and uploads directories to allow writing..."
    setfacl -R -m u:www-data:rwx $WP_DIR/wp-content
    setfacl -R -m d:u:www-data:rwx $WP_DIR/wp-content
    setfacl -R -m u:www-data:rwx $WP_DIR/wp-content/uploads
    setfacl -R -m d:u:www-data:rwx $WP_DIR/wp-content/uploads
    setfacl -R -m u:www-data:rwx $WP_DIR/wp-content/plugins
    setfacl -R -m d:u:www-data:rwx $WP_DIR/wp-content/plugins
    setfacl -R -m u:www-data:rwx $WP_DIR/wp-content/themes
    setfacl -R -m d:u:www-data:rwx $WP_DIR/wp-content/themes
else
    echo "wp-content directory not found, skipping..."
fi

echo "ACLs successfully set!"
