<?php

declare(strict_types=1);

namespace WilliamPHP\EventDispatcher\Tests\Stubs;

use WilliamPHP\EventDispatcher\Contracts\EventContract;
use WilliamPHP\EventDispatcher\Contracts\ListenerContract;

class CannotInstantiate implements ListenerContract{
  private function __construct(private string $name)
  {}

  public function handle(EventContract $event): mixed
  {
    return $event->getName();
  }
  // public static function make(string $name): static {
  //   return new static($name);
  // }

  // public function name(): string {
  //   return $this->name;
  // }
}
