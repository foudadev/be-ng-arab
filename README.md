<p align="center"><img src="public/images/ng.jpg" width="300"></p>


## Installation
- Clone repository
```
$ git clone https://github.com/NgArab/ngarab-be.git
```
- Run in your terminal
```
$ composer install
$ php artisan key:generate
```
- Setup database connection in .env file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

## Do not forget the following steps:


- Migrate tables and seed with demo data
```
$ php artisan migrate --seed
```
- Setup Laravel Passport
```
$ php artisan passport:install
```
- Access it on using
```
User:admin@ng.com
Password:123456
```



