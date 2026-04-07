#!/bin/bash
echo "Startar WordPress..."
docker compose up -d db wordpress

echo "Väntar på att WordPress ska starta (30 sek)..."
sleep 30

echo "Installerar WordPress..."
docker compose run --rm wpcli wp core install \
  --url="http://localhost:8080" \
  --title="PREK Test" \
  --admin_user="admin" \
  --admin_password="admin123" \
  --admin_email="admin@example.com" \
  --skip-email

echo "Aktiverar tema..."
docker compose run --rm wpcli wp theme activate prek

echo "Skapar exempelsidor..."
docker compose run --rm wpcli wp post create \
  --post_type=page \
  --post_title="Hem" \
  --post_status=publish \
  --post_content="Välkommen"

docker compose run --rm wpcli wp option update page_on_front 2
docker compose run --rm wpcli wp option update show_on_front page

echo "Skapar meny..."
docker compose run --rm wpcli wp menu create "Huvudmeny"
docker compose run --rm wpcli wp menu location assign huvudmeny menu-1

echo ""
echo "✓ Klart! Öppna: http://localhost:8080"
echo "✓ Admin:        http://localhost:8080/wp-admin"
echo "✓ Användare:    admin"
echo "✓ Lösenord:     admin123"
echo ""
echo "Ditt tema redigerar du i mappen: ./theme/"
