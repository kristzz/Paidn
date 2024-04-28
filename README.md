# Paidn

## Stack

Laravel, Node js, Vue js, MySql

## Setup

cd laravelBackend
cp .env.example .env
composer install
php artisan passport:keys
php artisan migrate

cd frontend
npm i

## Development

### Running in paralel
cd frontend
npm run dev

cd laravelBackend
php artisan serve
