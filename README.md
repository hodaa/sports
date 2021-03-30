## Fleet Management System
bus-booking system

## Installation

* `cp .env.example to .env`
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


## Usage

 2. Import collection directly: https://www.getpostman.com/collections/b7dd975e95031cf62429 


    

    

