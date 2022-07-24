<?php

declare(strict_types=1);

namespace WilliamPHP\EventDispatcher\Events;

use WilliamPHP\EventDispatcher\Contracts\EventContract;

class NullEvent implements EventContract{
	public function getName(): string
  {
     return "null-event";
  }
} 