<?php

declare(strict_types=1);

namespace WilliamPHP\EventDispatcher;

use Throwable;
use ReflectionClass;
use InvalidArgumentException;
use WilliamPHP\EventDispatcher\Contracts\EventContract;
use WilliamPHP\EventDispatcher\Contracts\ListenerContract;
use WilliamPHP\EventDispatcher\Contracts\DispatcherContract;

class Dispatcher implements DispatcherContract{

  private function __construct(
    private array $listeners,
    private array $log
  ){}

  /**
   * Make a new Dispatcher
   * 
   * @param array $listeners -- Associative array of event and listeners
   * 
   * @return static
   */
  public static function make(array $listeners = []): static {
    return new static($listeners,[]);
  }

	/**
	 * Add an event with it's listeners.
	 *
	 * @param string $event
	 * @param array $listeners
	 * 
	 * @throws InvalidArgumentException
	 *
	 * @return void
	 */
	public function add(string $event, array $listeners): void {
		foreach ($listeners as $listener) {
			$this->isValidListener($listener);
		}
		$this->listeners[$event] = $listeners;
	}
	
	/**
	 * Append a series of listeners to an event.
	 *
	 * @param string $event
	 * @param array $listeners
	 * 
	 * @throws InvalidArgumentException
	 *
	 * @return void
	 */
	public function appendListeners(string $event, array $listeners): void {
		$this->validateEvent($event);
		foreach ($listeners as $listener) {
			$this->isValidListener($listener);
			$this->listeners[$event][] = $listener;
		}
	}
	
	/**
	 * Remove a specific listeners from an event's array of listeners.
	 *
	 * @throws InvalidArgumentException
	 * 
	 * @return void
	 */
	public function removeEventListener(string $event, string $listener): void {
		$this->validateEvent($event);
		if(! $this->hasListener($event, $listener)) {
			throw new InvalidArgumentException("Listener [$listener] has not been registered with event [$event");
		}
		foreach ($this->listeners[$event] as $key => $value) {
			if($listener == $value) {
				unset($this->listeners[$event][$key]);
			}
		}
	}
	
	/**
	 * Remove all listeners from an event and the event reference itself from the dispatcher
	 *
	 * @param string $event
	 *
	 * @throws InvalidArgumentException
	 * 
	 * @return void
	 */
	public function removeEvent(string $event): void {
		$this->validateEvent($event);
		unset($this->listeners[$event]);
	}
	
	/**
	 * Return all event-listeners registered in the Dispatcher
	 *
	 * @return array
	 */
	public function listeners(): array {
    return $this->listeners;
	}
	
	/**
	 * Return all listeners registered for an event in the Dispatcher
	 *
	 * @param string $event
	 *
	 * @throws InvalidArgumentException
	 * 
	 * @return array
	 */
	public function getListenersForEvent(string $event): array {
		$this->validateEvent($event);
		return $this->listeners[$event];
	}

	/**
	 * Dispatches a new event and triggers all it's listeners
	 * 
	 * @param EventContract $event
	 * @param bool $debug - Control whether listeners log their results
	 * 
	 * @throws InvalidArgumentException
	 * 
	 * @return void
	 */
	public function dispatch(EventContract $event, bool $debug = false): void
	{
		$this->validateEvent($event::class);
		foreach ($this->getListenersForEvent($event::class) as $listener) {
			$this->isInstantiable($listener);
			$result = (new $listener)->handle(
				$event
			);

			if($debug) {
				$this->log[$event::class][] = $result;
			}
		}
	}
	
	/**
	 * Returns all debug log
	 *
	 * @return array
	 */
	public function log(): array {
    return $this->log;
	}
	
	/**
	 * Check if event has been registerd on the dispatcher
	 *
	 * @param $event
	 *
	 * @return bool
	 */
	public function hasEvent(string $event): bool {
		return array_key_exists($event, $this->listeners);
	}

	/**
	 * Check if event has a listener 
	 *
	 * @param $event
	 *
	 * @throws InvalidArgumentException
	 * 
	 * @return bool
	 */
	public function hasListener(string $event, string $listener): bool {
		$this->validateEvent($event);
		return in_array($listener, $this->listeners[$event]);
	}

	/**
	 * Internal: Check if event exists on the dispatcher
	 *
	 * @param string $event
	 *
	 * @throws InvalidArgumentException
	 * 
	 * @return void
	 */
	private function validateEvent($event): void {
		if (! $this->hasEvent($event)) {
			throw new InvalidArgumentException(
				"No event has been registered under [$event]. Please check your config."
			);
		}
	}

	/**
	 * Internal: Check if listener implements the Listener contract
	 *
	 * @param string $listenerStringReference
	 *
	 * @throws InvalidArgumentException
	 * @throws \ReflectionException
	 * 
	 * @return void
	 */
	private function isValidListener($listenerStringReference): void{
		try {
			$listener = new ReflectionClass($listenerStringReference);
		} catch (Throwable $th) {
			throw $th;
		}
		if(! $listener->implementsInterface(ListenerContract::class)) {
			throw new InvalidArgumentException(
				"Listener must implement the ListenerContract."
			);
		}
	}

	/**
	 * Internal: Check if class is instantiable
	 *
	 * @param string $classStringReference
	 *
	 * @throws InvalidArgumentException
	 * @throws \ReflectionException
	 * 
	 * @return void
	 */
	private function isInstantiable($classStringReference) {
		try {
			$class = new ReflectionClass($classStringReference);
		} catch (Throwable $th) {
			throw $th;
		}
		if(! $class->isInstantiable()) {
			throw new InvalidArgumentException(
				"Passed in class must be instantiable."
			);
		}
	}
}