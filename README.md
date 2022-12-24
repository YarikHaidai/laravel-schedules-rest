## Installation
    1. composer install
    2. cp .env.example .env
    3. php artisan key:generate
    4. php artisan jwt:secret

## Run
### Docker Compose
    docker-compose up -d
#### Sail
    ./vendor/bin/sail up
#### Migration && Seeders
    docker exec -it laravel-schedules-rest_laravel.test_1 bash // Enter the container
    php artisan migrate
    php artisan db:seed

