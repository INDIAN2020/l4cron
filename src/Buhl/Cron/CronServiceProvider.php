<?php namespace Buhl\Cron;

use Illuminate\Support\ServiceProvider;


class CronServiceProvider extends ServiceProvider {

  public function boot()
  {
    $this->package('buhl/cron');
    $this->registerRoutes();
  }

  public function provides()
  {
    return array('command.cron');
  }

  public function register()
  {
    $this->registerCronCommands();
  }

  protected function registerRoutes()
  {
    $app = $this->app;
    $route = $this->app['config']->get('cron::route');
    $callback = function ($key = null) use ($app)
    {
      $config_key = $app['config']->get('cron::key',null);
      if(!$config_key or $key === $config_key) {
        $event = $app['events']->fire('cron.run',array('cron' => new Cron()));
      }
    };

    $app['router']->get($route, $callback);
    $app['router']->get($route.'/{key?}', $callback);
  }

  protected function registerCronCommands()
  {
    $this->app['command.cron'] = $this->app->share(function($app)
    {
      return new Console\CronCommand($app['config'], $app['events']);
    });
    $this->commands('command.cron');
  }
}
