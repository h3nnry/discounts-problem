# Discounts Problem
We need you to build us a small (micro)service that calculates discounts for orders.

## How discounts work
For now, there are three possible ways of getting a discount:

- A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.
- For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.
- If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.

By the way: there may become more ways of granting customers discounts in the future.

## Project setup
- Build & Run (docker-compose up --build -d)
- Composer install in www directory
- In www directory run: php artisan migrate:fresh && php artisan db:seed
- Change db host in .env to be same like in docker 
- Microservice endpoint - /discount 

## Added unit tests