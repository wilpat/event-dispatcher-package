<?php

declare(strict_types=1);

namespace WilliamPHP\EventDispatcher;

use WilliamPHP\EventDispatcher\DispatcherContract;

class Dispatcher implements DispatcherContract{

  private function __construct(
    private array $events,
    private array $log
  ){}

  /**
   * Make a new Dispatcher
   * 
   * @param array $events -- Associative array of event and listeners
   * 
   * @return static
   */
  public static function make(array $events = []): static {
    return new static(
      events: $events,
      log: []
    );
  }

	/**
	 * Add an event with it's listeners.
	 *
	 * @param string $eventName
	 * @param array $listeners
	 *
	 * @return void
	 */
	function add(string $eventName, array $listeners): void {
	}
	
	/**
	 * Append a series of listeners to an event.
	 *
	 * @param string $eventName
	 * @param array $listeners
	 *
	 * @return void
	 */
	function appendListeners(string $eventName, array $listeners): void {
	}
	
	/**
	 * Remove a specific listener from an event's array of listeners.
	 *
	 * @param string $eventName
	 * @param array $listeners
	 *
	 * @return void
	 */
	function removeOneListener(string $eventName, array $listeners): void {
	}
	
	/**
	 * Remove all listeners from an event and the event itself
	 *
	 * @param string $eventName
	 *
	 * @return void
	 */
	function removeAll(string $eventName): void {
	}
	
	/**
	 * Return all listeners registered in the Dispatcher
	 *
	 * @return array
	 */
	function listeners(): array {
    return [];
	}
	
	/**
	 * Return all listeners registered for an event in the Dispatcher
	 *
	 * @param string $eventName
	 *
	 * @return array
	 */
	function getListenersForEvent(string $eventName): array {
    return [];
	}
	
	/**
	 * Returns all debug log
	 *
	 * @return array
	 */
	function log(): array {
    return [];
	}
	
	/**
	 * Check if event as been registerd on the dispatcher
	 *
	 * @param string $eventName
	 *
	 * @return bool
	 */
	function hasEvent($eventName): bool {
    return true;
	}
}