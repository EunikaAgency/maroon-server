#!/bin/bash

BACKUP_DIR="/mnt/backups/public"
current_ts=$(date +%s)

find "$BACKUP_DIR" -type f \( -iname "*.sql" -o -iname "*.zip" \) | while read -r file; do
    filename=$(basename "$file")
    name="${filename%.*}"

    # Match date pattern: 4-digit year, dash, 2-digit month, dash, 2-digit day
    if [[ "$name" =~ ([0-9]{4}-[0-9]{2}-[0-9]{2}) ]]; then
        datepart="${BASH_REMATCH[1]}"
        if date_ts=$(date -d "$datepart" +%s 2>/dev/null); then
            file_date_fmt=$(date -d "$datepart" +"%Y-%m-%d")
            diff_days=$(( (current_ts - date_ts) / 86400 ))
            echo "$filename => Date: $file_date_fmt ($diff_days days old)"
        else
            echo "$filename => Invalid date format"
        fi
    else
        echo "$filename => No date found"
    fi
done
