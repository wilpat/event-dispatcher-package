<?php

declare(strict_types=1);

namespace WilliamPHP\EventDispatcher\Tests\Stubs;

use WilliamPHP\EventDispatcher\Contracts\EventContract;

class FailableClass {
  public function handle(EventContract $event): mixed
  {
    return $event->getName(); 
  }
}
