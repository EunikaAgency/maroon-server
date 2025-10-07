#!/bin/bash

# Toggles for resizing and compression
ENABLE_JPG_RESIZE=true
ENABLE_JPG_COMPRESSION=true
ENABLE_PNG_RESIZE=false
ENABLE_PNG_COMPRESSION=false

# Function to resize .jpg images
resize_jpg() {
  local img="$1"
  echo "Resizing JPG: $img (Size: ${filesize_kb}KB, Resolution: ${width}x${height})"
  
  # Resize image if resolution exceeds 1920x1080
  if [[ "$width" -gt 1920 || "$height" -gt 1080 ]]; then
    echo "Resizing $img to fit within 1920x1080"
    mogrify -resize 1920x1080\> "$img"
  fi
}

# Function to compress .jpg images
compress_jpg() {
  local img="$1"
  echo "Compressing JPG: $img"
  jpegoptim --max=30 "$img"
}

# Function to resize .png images
resize_png() {
  local img="$1"
  echo "Resizing PNG: $img (Size: ${filesize_kb}KB, Resolution: ${width}x${height})"
  
  # Resize image if resolution exceeds 1920x1080
  if [[ "$width" -gt 1920 || "$height" -gt 1080 ]]; then
    echo "Resizing $img to fit within 1920x1080"
    mogrify -resize 1920x1080\> "$img"
  fi
}

# Function to compress .png images
compress_png() {
  local img="$1"
  echo "Compressing PNG: $img"
  optipng -o7 "$img"
}

# Find all .jpg and .png files larger than 100KB
find ./ -type f \( -name '*.jpg' -o -name '*.png' \) -size +100k | while read -r img; do
  # Get the file size in KB
  filesize=$(stat -c%s "$img")
  filesize_kb=$((filesize / 1024))

  # Get the image resolution (width and height)
  resolution=$(identify -format "%wx%h" "$img")
  width=$(echo "$resolution" | cut -d'x' -f1)
  height=$(echo "$resolution" | cut -d'x' -f2)

  # Determine if the file size is too big for its resolution
  # This is a rough heuristic: for every 1 megapixel, we assume a file size of 500KB is acceptable.
  megapixels=$((width * height / 1000000))
  expected_size=$((megapixels * 500))

  if [[ "$filesize_kb" -gt "$expected_size" ]]; then
    # Handle JPG images
    if [[ "$img" == *.jpg ]]; then
      # Resize first, if enabled
      if [[ "$ENABLE_JPG_RESIZE" == true ]]; then
        resize_jpg "$img"
      fi
      # Compress after resize, if enabled
      if [[ "$ENABLE_JPG_COMPRESSION" == true ]]; then
        compress_jpg "$img"
      fi

    # Handle PNG images
    elif [[ "$img" == *.png ]]; then
      # Resize first, if enabled
      if [[ "$ENABLE_PNG_RESIZE" == true ]]; then
        resize_png "$img"
      fi
      # Compress after resize, if enabled
      if [[ "$ENABLE_PNG_COMPRESSION" == true ]]; then
        compress_png "$img"
      fi
    fi
  else
    echo "$img is fine (Size: ${filesize_kb}KB, Resolution: ${width}x${height})"
  fi
done
