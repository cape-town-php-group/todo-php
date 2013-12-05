# Laravel 4 TodoPHP Example

## Running

### Requirements

-   >= PHP 5.4
-   Composer
-   MySQL (optional)


### Database

The app is setup to use a MySQL database by default (see `app/config/database.php` for more details). 
If using the default database config then a database with the name `todophp` needs to be created.

To override this: add a database.php config under config/local/ (i.e. `app/config/local/database.php`).
See [the docs](http://four.laravel.com/docs/configuration) for more info on how to do this.


### Start up

-   open a terminal/command prompt and `cd` to the root directory `todo-php/laravel4/m-nel`
-   run `composer install`
-   run `php artisan migrate --seed` (if overriding with local config use `php artisan migrate --seed --env=local`)
-   run `php artisan serve` and visit http://localhost:8000/tasks


### Considerations

I only started looking into Laravel a month ago, so this most likely is not the best representation of the framework. 
Tests still needs a LOT of love (I'm a testing noob)


## Issues
Please [create an issue](https://github.com/cape-town-php-group/todo-php/issues) if there is anything I missed/overlooked.