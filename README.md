Welcome to Syntax Squad Capstone Project Titled:

**Requirements Before Installation:**
PHP (8.2 +)
Composer
Laragon WAMP/ Herd for MAC with DBngin
Node

**Installation Guide**
1. Run composer install
2. $ cp .env.example .env
3. go to .env and change APP_URL, DB_USERNAME, DB_PASSWORD and DB_DATABASE
4. Generate App key  $ php artisan key:generate
5. Run Database Migration $ php artisan migrate
6. Run Filament Shield $ php artisan shield:install --fresh
7. Create a symlink to the storage $ php artisan storage:link
8. Install Node modules $ npm install
9. Run Seeders $ php artisan db:seed


You're ready to go! Goto to browser URL and login Enjoy! 😃
