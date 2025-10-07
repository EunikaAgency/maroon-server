#!/bin/bash

# Prompt for database credentials
read -p "Enter database username: " DB_USER
read -s -p "Enter database password: " DB_PASS
echo
read -p "Enter database name: " DB_NAME

# Generate timestamp for filename
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
FILENAME="${DB_NAME}_backup_${TIMESTAMP}.sql"

# Export database with more secure method and skip tablespace info
echo "Exporting database..."
MYSQL_PWD=$DB_PASS mysqldump --no-tablespaces -u $DB_USER $DB_NAME > $FILENAME

# Check if export was successful
if [ $? -eq 0 ]; then
    echo "Database exported successfully to: $(pwd)/$FILENAME"
else
    echo "Database export failed"
    rm -f $FILENAME  # Remove empty file if export failed
fi
