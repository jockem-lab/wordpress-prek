#!/bin/bash
echo "Bevakar temafiler... (Ctrl+C för att stoppa)"
while true; do
  sleep 2
  ./sync.sh 2>/dev/null
done
