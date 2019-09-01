1. clone project: git clone -b develop https://github.com/dcnhat-0805/StoreProduct.git

2. cd StoreProduct

3. clone laradock: git clone https://github.com/Laradock/laradock.git

4. cd laradock

5. cp env-example .env

6. Config file .env of laradock

    DATA_PATH_HOST=~/.laradock/data_store_online

    PHP_VERSION=7.2

    ##=====Config mysql=====##
    MYSQL_VERSION=5.7

    MYSQL_PORT=3306

    MYSQL_DATABASE=storeonline

    MYSQL_USER=root

    MYSQL_PASSWORD=root

    MYSQL_ROOT_PASSWORD=root
7. (sudo) docker-compose build nginx mysql phpmyadmin

8. (sudo) docker-compose up -d nginx mysql phpmyadmin

9. (sudo) docker ps

10. (sudo) docker-composer exec workspace bash

11. composer update

12. cp .env.example .env

13. php artisan key:generate

14. Setting info connect DB in file .env of laravel

    DB_CONNECTION=mysql

    DB_HOST=mysql

    DB_PORT=3306

    DB_DATABASE=db_store_online

    DB_USERNAME=root

    DB_PASSWORD=root
15. php artisan migrate

16. composer dump-autoload

17. php artisan db:seed

