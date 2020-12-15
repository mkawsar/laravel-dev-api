## Backend



### System requirements
* PHP 7.3 or higher (We have used PHP 7.4 for development)
* [Composer](https://getcomposer.org/Composer)development)
* [Git](https://git-scm.com/)

### Installation
* Clone the repository [Repo](https://github.com/mkawsar/laravel-dev-api)
* Checkout the `main` branch
* Make sure `PHP` and `Composer` is installed in system
* Run `composer install` to install the dependencies
* Make copy `.env.example` to `.env` and setup all configurations

### Project Structure
* Our solution have one part
    * REST Api
* REST Api parts are include `Controllers`, `Models` and `Routes` directory
## Run the Solutions
* Setup the database information in `.env` file
* Run the migration for create database tables `php artisan migrate`
* Run the following command for JWT passport install `php artisan passport:install`
* Run the following command for insert initial user `php artisan db:seed`
* Finally run the backend server `php artisan serve`

## URL list
```bash
# login (method=POST)
api/v1/auth/login

# logout (method=GET)
api/v1/auth/user/logout

# product list (method=GET)
api/v1/product 

# create new product (method=POST)
api/v1/product

# update product infomation (method=POST)
api/v1/product/{productID}

# product details information show (method=GET)
api/v1/product/{productID}

# delete product (method=DELETE)
api/v1/product/{productID}
```

## Support

If you have any questions or confusion please email me at **kawsar.diu888@gmail.com** or open an issue in the repository.