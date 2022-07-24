<?php

use WilliamPHP\EventDispatcher\Dispatcher;
use WilliamPHP\EventDispatcher\Events\NullEvent;
use WilliamPHP\EventDispatcher\Contracts\DispatcherContract;
use WilliamPHP\EventDispatcher\Listeners\NullListener;
use WilliamPHP\EventDispatcher\Tests\Stubs\CannotInstantiate;
use WilliamPHP\EventDispatcher\Tests\Stubs\FailableClass;

it('can create a dispatcher without event-listeners', function() {
    $dispatcher = Dispatcher::make(listeners: []);

    expect($dispatcher)->toBeInstanceOf(DispatcherContract::class);
    expect($dispatcher->listeners())->toBeEmpty()->toEqual([]);
});

it('can register event-listeners when creating a dispatcher', function() {
    $dispatcher = Dispatcher::make([
        NullEvent::class => [
            NullListener::class
        ]
    ]);
    expect($dispatcher->listeners())
        ->toHaveCount(1)
        ->toEqual([
            NullEvent::class => [
                NullListener::class
            ]
        ]);
});

it('can add events and its listeners to dispatcher after creation', function(){
    $dispatcher = Dispatcher::make();
    $dispatcher->add(
        NullEvent::class,
        [ NullListener::class ]
    );
    expect($dispatcher->listeners())
        ->toHaveCount(1)
        ->toEqual([
            NullEvent::class => [
                NullListener::class
            ]
        ]);
    expect($dispatcher->hasEvent(NullEvent::class))->toBe(true);
});

it('can append listeners to a registered event', function() {
    $dispatcher = Dispatcher::make([
        NullEvent::class => []
    ]);

    expect($dispatcher->hasEvent(NullEvent::class))
        ->toBeTrue();

    expect($dispatcher->getListenersForEvent(NullEvent::class))
        ->toBeEmpty();

    $dispatcher->appendListeners(NullEvent::class, [ NullListener::class ]);

    expect($dispatcher->listeners())
        ->toEqual([
            NullEvent::class => [
                NullListener::class
            ]
            ]);
});

it('can remove a listener from an event', function() {
    $dispatcher = Dispatcher::make([
        NullEvent::class => [
            NullListener::class
        ]
    ]);
    expect($dispatcher->hasEvent(NullEvent::class))
        ->toBeTrue();

    expect($dispatcher->getListenersForEvent(NullEvent::class))
        ->toHaveCount(1);

    $dispatcher->removeEventListener(NullEvent::class, NullListener::class);

    expect($dispatcher->getListenersForEvent(NullEvent::class))
        ->toHaveCount(0);
    expect($dispatcher->listeners())
        ->toHaveCount(1)
        ->toEqual([
            NullEvent::class => []
        ]);
});

it('can remove an event with all its listeners from dispatcher.', function () {
    $dispatcher = Dispatcher::make([
        NullEvent::class => [
            NullListener::class
        ]
    ]);
    expect($dispatcher->listeners())
        ->toHaveCount(1)
        ->toEqual([
            NullEvent::class => [
                NullListener::class
            ]
        ]);
    $dispatcher->removeEvent(NullEvent::class);
    expect($dispatcher->listeners())
        ->toBeEmpty()
        ->toEqual([]);
});

it('can check if event has a listener.', function() {
    $dispatcher = Dispatcher::make([
        NullEvent::class => [
            NullListener::class
        ]
    ]);
    expect($dispatcher->hasListener(NullEvent::class, NullListener::class))
        ->toBeTrue();
    expect($dispatcher->hasListener(NullEvent::class, FailableClass::class))
        ->toBeFalse();
});

it('can dispatch an event', function() {
    $dispatcher = Dispatcher::make([
        NullEvent::class => [
            NullListener::class
        ]
    ]);
    $dispatcher->dispatch(new NullEvent(), true);
    expect($dispatcher->log())
        ->toHaveCount(1)
        ->toEqual([NullEvent::class => ['null-event']]);
});

it('can fetch dispatcher logs', function() {
    $dispatcher = Dispatcher::make([
        NullEvent::class => [
            NullListener::class
        ]
    ]);
    expect($dispatcher->log())
        ->toHaveCount(0)
        ->toEqual([]);
});


it('should throw an InvalidArgumentException when trying to retrieve listeners for non-existent event', function () {
    $dispatcher = Dispatcher::make();
    $dispatcher->getListenersForEvent(NullEvent::class);
})->throws(InvalidArgumentException::class);

it('should throw an InvalidArgumentException when trying to remove non-existent event', function () {
    $dispatcher = Dispatcher::make();
    $dispatcher->removeEvent(NullEvent::class);
})->throws(InvalidArgumentException::class);

it('should throw an InvalidArgumentException when trying to remove listener that does not exist for event', function () {
    $dispatcher = Dispatcher::make([
        NullEvent::class => []
    ]);
    $dispatcher->removeEventListener(NullEvent::class, NullListener::class);
})->throws(InvalidArgumentException::class);

it('should throw an InvalidArgumentException when adding listener that does not implement Listener Contract', function () {
    $dispatcher = Dispatcher::make([
        NullEvent::class => [
        ]
    ]);
    $dispatcher->appendListeners(NullEvent::class, [ FailableClass::class ]);
})->throws(InvalidArgumentException::class);

it('should throw an InvalidArgumentException when dispatching event with uninstantiable listener', function () {
    $dispatcher = Dispatcher::make([
        NullEvent::class => [ CannotInstantiate::class ]
    ]);
    $dispatcher->dispatch(new NullEvent(), true);
})->throws(InvalidArgumentException::class);

it('should throw a ReflectionException when dispatching event with non-existent listener class reference', function () {
    $dispatcher = Dispatcher::make([
        NullEvent::class => [ 'NonExistentClass' ]
    ]);
    $dispatcher->dispatch(new NullEvent(), true);
})->throws(ReflectionException::class);

it('should throw an ReflectionException when adding listener that does not implement Listener Contract', function () {
    $dispatcher = Dispatcher::make([
        NullEvent::class => []
    ]);
    $dispatcher->appendListeners(NullEvent::class, [ 'NonExistentClass' ]);
})->throws(ReflectionException::class);