#!/bin/bash

# Get passed directory and optional filename
WP_DIR="$1"
FILENAME="${2:-db_backup}"  # default to "db_backup" if none provided

# Get script directory and set backup dir
# SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
BACKUP_DIR="/mnt/backups/public"

# Ensure backup directory exists
mkdir -p "$BACKUP_DIR"

# Get timestamp
# TIMESTAMP=$(date +"%Y%m%d_%H%M%S")

# Export DB using WP-CLI
cd "$WP_DIR" || { echo "Failed to cd to $WP_DIR"; exit 1; }
EXPORT_OUTPUT=$(wp db export "$BACKUP_DIR/${FILENAME}.sql" --allow-root 2>&1)

# Output result
echo "$EXPORT_OUTPUT"

if [[ "$EXPORT_OUTPUT" == *"Success:"* ]]; then
    echo "Database backup saved to: $BACKUP_DIR/${FILENAME}.sql"
else
    echo "Backup failed."
fi

# Create ZIP of entire WP_DIR
ZIP_OUTPUT="$BACKUP_DIR/${FILENAME}.zip"
(cd "$WP_DIR" && find . -type d -name ".git" -prune -o -type f \( -size -10M ! -iname "*.zip" ! -iname "*.rar" ! -iname "*.7z" ! -iname "*.tar" ! -iname "*.gz" ! -iname "*.tgz" \) -print | zip -r "$ZIP_OUTPUT" -@ > /dev/null 2>&1)

# Check ZIP result
if [[ -f "$ZIP_OUTPUT" ]]; then
    echo "Site files zipped to: $ZIP_OUTPUT"
else
    echo "Zipping site files failed."
fi