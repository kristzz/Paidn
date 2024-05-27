# Paidn

## Stack

- Laravel
- Node.js
- Vue.js + ts
- MySQL

## Setup

### Laravel backend setup
```
Navigate to the Laravel backend directory:        

cd laravelBackend    
cp .env.example .env
composer install
php artisan key:generate   
php artisan passport:keys    
php artisan passport:client --personal    
php artisan storage:link              
composer require laravel/telescope --dev     
php artisan telescope:install     
php artisan migrate
```

### In the .env file, config the db

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="db_name"
DB_USERNAME="db_user"
DB_PASSWORD=
```

### Vue js frontend setup

```
Navigate to the Vue frontend directory:        

cd frontend        
npm i
```

## Development

### Running in parallel
```
1. Start the frontend development server:

cd frontend    
npm run dev

2. Start the Laravel backend server:

cd laravelBackend    
php artisan serve
```
