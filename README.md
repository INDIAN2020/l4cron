# l4cron


A simple Cron job solution for Laravel 4

## Installation
**NB!** This package is not on composer yet. If you want to try it clone it into a workbench folder.

add the service provider in `app/config/app.php` 
```php
//...
  'providers' => array(
  //...
    'Buhl\Cron\CronServiceProvider',
  ),
//...
```
`src/config/config.php` constains the following settings
```php
array(
  'route' => 'buhl/cron', //the route cron can be call through
  'key' => null, //when set. cron will only run when the route has the key in it /buhl/cront/<key>
);
```
##Using
When the cron route is hit _l4cron_ issues an `cron.run` event. you can listen to it and have it run you cron job if its due like so
```php
    $this->app['events']->listen('cron.run',function($event)
    {
      $event->cron->run('*/2 * * * *',function($cron)
      {
        //I run every other minute
      });
      $event->cron->run('@daily',function($cron)
      {
        //I run daily
      });
    });
```
_l4cron_ uses [cron-expression](https://github.com/mtdowling/cron-expression) to validate the cron expression and passes the object to the callback.


enjoy!
