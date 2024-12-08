:: Composer-es csomagok telepítése mindenféle interakció és konzolra írás nélkül
call composer install --no-interaction --quiet

@echo off
(
  echo APP_NAME="Car rental"
  echo APP_ENV=local
  echo APP_KEY=
  echo APP_DEBUG=true
  echo APP_URL=http://localhost
  echo.
  echo DB_CONNECTION=sqlite
) > .env
@echo on

call php artisan key:generate

call npm install --silent

call npm run dev -- build

type nul > database/database.sqlite

call php artisan migrate:fresh --seed

mkdir .\storage\app\public

call php artisan storage:link

call php artisan serve