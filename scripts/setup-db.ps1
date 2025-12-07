# Run migrations and seed database (PowerShell helper)
# Usage: .\scripts\setup-db.ps1

php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder --force
