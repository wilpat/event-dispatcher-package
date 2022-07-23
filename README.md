# Event Dispather

A simple library for dispatching events in PHP

## Installation

To install this package you can use composer

```bash
composer require  williamphp/event-dispatcher
```

## Usage

```php
 
// Create a new dispatcher

$dispather = new Dispatcher::make(
  listeners: [
    Path\To\Event::class => [
      Path\To\Listener::class,
    ]
  ]
)

$dispather = new Dispatcher(
  listeners: [],
  log: []
)

// Add event with listeners

$dispatcher->add(
  event: Path\To\Event::class,
  listeners: [
    Path\To\Listener::class,
  ]
)

// Append listeners to an event's Listener array

$dispatcher->add(
  event: Path\To\Event::class,
  listeners: [
    Path\To\Another\Listener::class,
  ]
)

// Dispatch
$dispatcher->dispatch(
  event: new Path\To\Event::class,
  debug: true,
)

// Get debug log items
$dispatcher->log(); // []

```