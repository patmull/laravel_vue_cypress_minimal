Assuming installed PHP 8.3.14 and NPM 10.9.0, my tested OS is: Fedora Linux 41 KDE Plasa 6.2.4.:

cd user_interface
npm install
npm run predeploy
npm run dev

cd ..
composer update
composer install
php artisan serve


ENV VUE/VITE:
```
VITE_APP_URL=http://localhost:5173
VITE_APP_API_URL=http://localhost:8000
```
ENV LARAVEL:
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:gh7mnK7fJFVEW9V485vguP8d9uyPHzIryyWkLSIcEVs=
APP_DEBUG=true
APP_TIMEZONE=UTC

APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:5173
SESSION_DOMAIN=localhost
SANCTUM_STATEFUL_DOMAINS=localhost:5173

APP_LOCALE=cs
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=# FILL OWN
DB_PORT=# FILL OWN
DB_DATABASE=# FILL OWN
DB_USERNAME=# FILL OWN
DB_PASSWORD=# FILL OWN

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/

SESSION_HTTP_ONLY=false
SESSION_SAME_SITE=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

VITE_APP_NAME="${APP_NAME}"
```
