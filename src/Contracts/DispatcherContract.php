<?php

declare(strict_types=1);

namespace WilliamPHP\EventDispatcher;

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
   * @param string $eventName
   * @param array $listeners
   * 
   * @return void
   */
  public function add(string $eventName, array $listeners): void;

  /**
   * Append a series of listeners to an event.
   * 
   * @param string $eventName
   * @param array $listeners
   * 
   * @return void
   */
  public function appendListeners(string $eventName, array $listeners): void;

  /**
   * Remove a specific listener from an event's array of listeners.
   * 
   * @param string $eventName
   * @param array $listeners
   * 
   * @return void
   */
  public function removeOneListener(string $eventName, array $listeners): void;

  /**
   * Remove all listeners from an event and the event itself
   * 
   * @param string $eventName
   * 
   * @return void
   */
  public function removeAll(string $eventName): void;

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
  public function getListenersForEvent(string $eventName): array;


  /**
   * Returns all debug log
   * 
   * @return array
   */
  public function log(): array;

  /**
   * Check if event as been registerd on the dispatcher
   * 
   * @param string $eventName
   * 
   * @return bool
   */
  public function hasEvent($eventName): bool;

}