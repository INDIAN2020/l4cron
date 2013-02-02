<?php namespace Buhl\Cron\Console;

use BuhlCron\Cron;
use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Illuminate\Events\Dispatcher;
use Symfony\Component\Console\Input\InputOption;


class CronCommand extends Command {
  protected $name = 'cron:run';

  protected $description = 'Run cron jobs';

	/**
	 * The event dispatcher instance.
	 *
	 * @var Illuminate\Events\Dispatcher
	 */
  protected $events;

	/**
	 * Create a new crun.run command instance.
	 *
	 * @param  Illuminate\Events\Dispatcher  $events
	 * @return void
	 */
  public function __construct(Repository $config, Dispatcher $events)
  {
    parent::__construct();
    $this->events = $events;
    $this->config = $config;

  }

  public function fire()
  {
    $key = $this->input->getOption('key');
    $config_key = $this->config->get('cron::key',null);
    if(!$config_key or $key === $config_key) {
      $event = $this->events->fire('cron.run',array('cron' => new Cron()));
    }
  }

  /**
   * Get the console command options.
   *
   * @return array
   */
  protected function getOptions()
  {
    return array(
      array('key', null, InputOption::VALUE_OPTIONAL, 'The secret key, used for protecting cron jobs from being run by an unpriviledge'),
    );
  }
}
