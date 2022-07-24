<?php

declare(strict_types=1);

namespace WilliamPHP\EventDispatcher\Contracts;

interface ListenerContract {
  public function handle(EventContract $event): mixed; 
} 