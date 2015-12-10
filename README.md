# Objective PHP / Eloquent Package

## Project topic

This package add seamless integration for Eloquent ORM (native Laravel ORM). 
 
It mainly allows configuring a connection to the database and registering the capsule as global, which is enough for creating and using Eloquent's style models in the application.

## How to make it work

### Install the package

Use composer to import the package in your application:

```
# cd to your project root, where is the composer.json file stored
composer require objective-php/eloquent-package dev-master 
```

### Activate it

You have to plug the package Middleware to your application to activate it:
 
```php

use ObjectivePHP\Application\ApplicationInterface;
use ObjectivePHP\EloquentPackage\EloquentPackage;

class Application extends ApplicationInterface
{
    public function init()
    {
        // ...
        
        // plug Eloquent package to any requests
        //
        // add some filter as extra plug() parameters to condition package actual activation 
        $this->on('bootstrap')->plug(new EloquentPackage());
        
        // ...
    }
}
```


### Configure it

In order to make Eloquent fully functional, you have to define a database connection. This configuration has to be done
in the application configuration. When using Objective PHP starter kit, all you have to do is to create a config file in 
the ```app/config``` folder, name it whathever you want (but eloquent.php seems to be a decent name for this purpose :))
and then return a config array like the following:
 
 ```php
 return
     [
         'eloquent.driver'          => 'mysql',
         'eloquent.host'            => '127.0.0.1',
         'eloquent.username'        => /* user name */,
         'eloquent.password'        => /* plain text password */,
         'eloquent.database'        => /* database name */
         // 'eloquent.charset'      => /* defaults to 'utf8' */,
         // 'eloquent.collation'    => /* defaults to 'utf8_unicode_ci' */
     ]; 
 ```
