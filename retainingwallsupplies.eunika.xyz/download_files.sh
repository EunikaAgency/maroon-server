#!/bin/bash

# Config
RemoteHost="67.219.109.247"
RemoteUser="root"
RemotePemPath="/home/eunika-maroon/Downloads/ivan-master-key.pem"  # Leave empty to use password
RemotePath="/home/retainingwallsupplies/htdocs/retainingwallsupplies.eunika.xyz"
RemotePort="22"

# List of files or folders to exclude (relative to RemotePath)
EXCLUDES=(
  ".git/"
  "*.log"
  "*.zip"
  "*.tar"
  "*.tar.gz"
  "*.gz"
  "*.rar"
  "*.7z"
  "*.bak"
  "*.tmp"
  "*.swp"
  "*.old"
  "*.wpress"
  ".DS_Store"
)


# Destination dir: same as script location
LOCAL_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Rsync base options
RSYNC_OPTS="-azvh --progress"

# Add exclude rules
for pattern in "${EXCLUDES[@]}"; do
  RSYNC_OPTS+=" --exclude=$pattern"
done

# SSH options
SSH_OPTS="-p $RemotePort -o StrictHostKeyChecking=no"

# Auth handling
if [[ -f "$RemotePemPath" ]]; then
    echo "Using PEM file authentication..."
    rsync $RSYNC_OPTS -e "ssh -i $RemotePemPath $SSH_OPTS" "$RemoteUser@$RemoteHost:$RemotePath" "$LOCAL_DIR/"
else
    echo "Using SSH password prompt (interactive)..."
    rsync $RSYNC_OPTS -e "ssh $SSH_OPTS" "$RemoteUser@$RemoteHost:$RemotePath" "$LOCAL_DIR/"
fi
