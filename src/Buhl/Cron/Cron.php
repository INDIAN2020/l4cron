<?php namespace Buhl\Cron;

use Closure;
use Cron\CronExpression;

class Cron {

  public static function run( $expression, Closure $callback)
  {
    $cron = CronExpression::factory($expression);
    if($cron->isDue())
    {
      return call_user_func($callback,$cron);
    }
  }
}
