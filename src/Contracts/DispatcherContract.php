<?php

declare(strict_types=1);

namespace WilliamPHP\EventDispatcher\Contracts;

use WilliamPHP\EventDispatcher\Contracts\EventContract;

interface DispatcherContract {
  /**
   * Make a new Dispatcher
   * 
   * @param array $events -- Associative array of event and listeners
   * 
   * @return static
   */
  public static function make(array $events = []): static;

  /**
   * Add an event with it's listeners.
   * 
   * @param string $event
   * @param array $listeners
   * 
   * @return void
   */
  public function add(string $event, array $listeners): void;

  /**
   * Append a series of listeners to an event.
   * 
   * @param string $event
   * @param array $listeners
   * 
   * @return void
   */
  public function appendListeners(string $event, array $listeners): void;

  /**
   * Remove a specific listener from an event's array of listeners.
   * 
   * @param string $event
   * @param string $listeners
   * 
   * @return void
   */
  public function removeEventListener(string $event, string $listener): void;

  /**
   * Remove all listeners from an event and the event itself
   * 
   * @param string $event
   * 
   * @return void
   */
  public function removeEvent(string $event): void;

  /**
   * Return all listeners registered in the Dispatcher
   * 
   * @return array
   */
  public function listeners(): array;

  /**
   * Return all listeners registered for an event in the Dispatcher
   * 
   * @return array
   */
  public function getListenersForEvent(string $event): array;


  /**
   * Returns all debug log
   * 
   * @return array
   */
  public function log(): array;

  /**
   * Check if event as been registered on the dispatcher
   * 
   * @param string $event
   * 
   * @return bool
   */
  public function hasEvent(string $event): bool;

  /**
   * Dispatch a registered event to it's registered listeners on the dispatcher
   * 
   * @param EventContract $event
   * @param bool $debug
   * 
   * @return void
   */
  public function dispatch(EventContract $event, bool $debug = false): void;

}