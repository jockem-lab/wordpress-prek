#!/bin/bash
for file in theme/*.php theme/*.css theme/js/*.js; do
  [ -f "$file" ] || continue
  filename=$(basename "$file")
  if [[ "$file" == theme/js/* ]]; then
    docker compose cp "$file" wordpress:/var/www/html/wp-content/themes/prek/js/$filename
  else
    docker compose cp "$file" wordpress:/var/www/html/wp-content/themes/prek/$filename
  fi
done
echo "Sync klar"
