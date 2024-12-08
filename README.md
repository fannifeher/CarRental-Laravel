## Technológiák
- **Backend**: PHP, Laravel
- **Frontend**: HTML, Bootstrap, Blade
- **Adatbázis**: SQLite
- **Egyéb**: Composer, npm

## Telepítési Útmutató
**Composer csomagok telepítése**
```bash
   composer install --no-interaction --quiet
```

**.env fájl beállítása**
```bash
    APP_NAME="Car Rental"
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://localhost

    DB_CONNECTION=sqlite
```
**Encryption key generálása**
```bash
   php artisan key:generate
```

**Node Package Manager-es csomagok telepítése**
```bash
   npm install --silent
```

**Frontend oldali asset-ek kigenerálása**
```bash
   npm run dev -- build
```

**Frontend oldali asset-ek kigenerálása**
```bash
   npm run dev -- build
```

**Üres database/database.sqlite fájl előállítása**
```bash
   type nul > database/database.sqlite
```

**Táblák létrehozása, seed-elés**
```bash
   php artisan migrate:fresh --seed
```

**Egy üres könyvtár a szimbolikus link elkészítéséhez**
```bash
   mkdir .\storage\app\public
```

**Symlink készítése**
```bash
   php artisan storage:link
```

**Alkalmazás indítása**
```bash
   php artisan serve
```
