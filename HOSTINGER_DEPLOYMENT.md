# Hostinger Cloud Deployment

This project should stay in its current Laravel structure. Upload or deploy the repository contents into `public_html` so the root `index.php`, `.htaccess`, `public/`, `resources/`, `vendor/`, and `admin/` paths remain together.

## hPanel Settings

- PHP version: 8.2 or newer.
- Database: MySQL.
- Document root / deploy path: `public_html`.
- Build command for the root site assets: `npm install && npm run build`.
- Vite output directory: `public/build`.

Enable these PHP extensions if they are available in hPanel:

`bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `gd`, `intl`, `json`, `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `zip`, `ionCube Loader`.

The admin application may require `ionCube Loader`; enable it before running admin Artisan commands.

## Root Website Setup

From SSH inside `public_html`:

```bash
composer2 install --no-dev --optimize-autoloader
npm install
npm run build
cp .env.example .env
php artisan key:generate --force
php artisan storage:link
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Edit `.env` with the real Hostinger MySQL database values:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your_hostinger_mysql_host
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

## Admin Setup

The `admin/` folder is a second Laravel application. From SSH:

```bash
cd public_html/admin
composer2 install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate --force
php artisan storage:link
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

For `admin/.env`, use the same MySQL database if the admin tables are in the same database, and set:

```env
APP_URL=https://your-domain.com/admin
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
```

## Database

The root website now includes additive migrations for the public-site/admin tables such as banners, gallery, classes, students, teachers, services, notices, settings, and website menus. They create missing tables only and skip existing imported tables.

If your live data is already in a SQL backup, import it from hPanel/phpMyAdmin first, then run the migration commands. For the admin ERP seed database, check `admin/config/db/data.sql` if you need the packaged default admin data. Do not upload local `.env` files to GitHub; create them on Hostinger only.

## Security Notes

- Public maintenance routes have been removed from the root app.
- `.htaccess` blocks direct access to `.env`, logs, SQL/ZIP backups, Composer files, package files, and `artisan`.
- Keep backup ZIP/SQL files outside `public_html` whenever possible.
