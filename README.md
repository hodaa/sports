## Fleet Management System
bus-booking system

## Installation

* `cp .env.example to .env`

set DB_HOST:db

* If you want to use redis as driver for caching please 
change 
REDIS_HOST:redis

* `docker-compose build`
* `docker-compose up -d`

If you got the problem of file permission ,you should go enter the php image
`docker-compose exec php sh`
then type `chown -R www-data:www-data storage/`

* `php artisan migrate`


## Tools
* PHP7.4
* Laravel
* Mysql 8
* redis


## Testing
```
docker-compose exec php vendor/phpunit/bin
```


## APIs

http://localhost:8081/api/documentation




    

