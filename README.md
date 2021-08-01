## CRM Test

This project writes the API with laravel using jwt auth and consumes the apis using blade and jquery. 

Setting Up
- 

- Clone the project to your local machine
- open your terminal and navigate to the project root
- run `cp .env.example .env` to make a copy of the environment file
- run `composer install` to install the dependencies for the project.
- run `php artisan key:generate` to setup project key
- fill in other part of the `.env` file
- run `php artisan migrate --seed` to migrate and seed the database, do this after setting up your database credentials in the `.env` file
- run `php artisan jwt:secret` to generate the JWT Secret
- You can proceed to serve the application now via `php artisan serve`.
