# PREK WordPress - Lokal Docker-miljö

## Kom igång

### Krav
- Docker Desktop installerat (https://www.docker.com/products/docker-desktop/)
- Terminal / kommandotolk

### Starta miljön första gången
```bash
cd prek-wordpress
./setup.sh
```

### Starta miljön (efter första gången)
```bash
docker compose up -d
```

### Stoppa miljön
```bash
docker compose down
```

### Öppna webbplatsen
- Frontend: http://localhost:8080
- WordPress admin: http://localhost:8080/wp-admin
- Användare: admin
- Lösenord: admin123

## Redigera temat

Alla temafiler finns i mappen `./theme/`. Du kan redigera dem direkt i VS Code eller valfri editor – ändringarna syns direkt i webbläsaren utan att du behöver starta om något.

```
theme/
├── style.css          ← All CSS
├── functions.php      ← WordPress-inställningar
├── header.php         ← Header och navigation
├── footer.php         ← Footer
├── index.php          ← Standardmall
├── front-page.php     ← Startsidan
└── js/
    └── navigation.js  ← Hamburgaremeny-JavaScript
```

## Vanliga kommandon

### Kör WP-CLI kommandon
```bash
docker compose run --rm wpcli wp [kommando]
```

### Se loggar
```bash
docker compose logs -f wordpress
```

### Återställ allt (varning: raderar databasen)
```bash
docker compose down -v
./setup.sh
```
