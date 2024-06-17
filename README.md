### Laravel implementation of RealWorld app

This Laravel app is part of the [RealWorld](https://github.com/gothinkster/realworld) project and implementation of the [Laravel best practices](https://github.com/alexeymezenin/laravel-best-practices).

You might also check [Ruby on Rails version](https://github.com/alexeymezenin/ruby-on-rails-realworld-example-app) of this app.

See how the exact same Medium.com clone (called [Conduit](https://demo.realworld.io)) is built using different [frontends](https://codebase.show/projects/realworld?category=frontend) and [backends](https://codebase.show/projects/realworld?category=backend). Yes, you can mix and match them, because **they all adhere to the same [API spec](https://gothinkster.github.io/realworld/docs/specs/backend-specs/introduction)**

### How to run the API

Make sure you have PHP and Composer installed globally on your computer.

Clone the repo and enter the project folder

```bash
git clone https://github.com/alexeymezenin/laravel-realworld-example-app.git
cd laravel-realworld-example-app
```

Install the app

```bash
composer update
composer install
composer require fakerphp/faker --dev
cp .env.example .env
```

Run the web server

```bash
php artisan serve
```

That's it. Now you can use the api, i.e.

```bash
http://127.0.0.1:8000/api/articles
```

You might need y to install the pdo_sqlite extension :
```bash
sudo apt-get install php-sqlite3
```
and un-comment this line in your php.ini
```bash
;extension=pdo_sqlite # original
extension=pdo_sqlite # necessary
```
### set up a test environnement
#### install php-unit
```bash
sudo apt install php-cli \
                 php-json \
                 php-mbstring \
                 php-xml \
                 php-pcov \
                 php-xdebug
```

install with composer
```bash
composer require --dev phpunit/phpunit ^11 -w
./vendor/bin/phpunit --version
```
#### configuration
un-comment // add // fill this line in your php.ini
```bash
error_reporting=-1
xdebug.show_exception_trace=0
xdebug.mode=coverage
```

you can't run test just like that.
you have to downgrade your phpunit version in the composer.json :

```bash
    "require-dev": {
        # other stuff
        "phpunit/phpunit": "^9.0"
    },
```
always end with a 
```bash
composer update
```
#### create a test

```bash
php artisan make:test UserTest --unit
```

#### run tests
run one of this
```bash
./vendor/bin/phpunit
php artisan test
php artisan test --stop-on-failure # nice one
```

