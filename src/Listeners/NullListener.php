<?php

declare(strict_types=1);

namespace WilliamPHP\EventDispatcher\Listeners;

use WilliamPHP\EventDispatcher\Contracts\EventContract;
use WilliamPHP\EventDispatcher\Contracts\ListenerContract;

class NullListener implements ListenerContract {
  public function handle(EventContract $event): mixed
  {
    return $event->getName(); 
  }
}