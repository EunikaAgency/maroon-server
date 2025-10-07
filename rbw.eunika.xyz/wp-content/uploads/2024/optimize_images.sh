#!/bin/bash

# Function to compress .jpg images
compress_jpg() {
  local img="$1"
  echo "Compressing JPG: $img (Size: ${filesize_kb}KB, Resolution: ${width}x${height})"
  jpegoptim --max=40 "$img"
}

# Function to compress .png images
compress_png() {
  local img="$1"
  echo "Compressing PNG: $img (Size: ${filesize_kb}KB, Resolution: ${width}x${height})"
  optipng -o7 "$img"  # Alternatively, you can use pngquant
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
    # Check if the image is a .jpg or .png and apply appropriate compression
    if [[ "$img" == *.jpg ]]; then
      compress_jpg "$img"
    elif [[ "$img" == *.png ]]; then
      compress_png "$img"
    fi
  else
    echo "$img is fine (Size: ${filesize_kb}KB, Resolution: ${width}x${height})"
  fi
done
