[![Build Status](https://travis-ci.org/michaelesmith/EventData.svg)](http://secure.travis-ci.org/michaelesmith/EventData)

README
======

What is it?
-------------------

This is a library that allows for easy abstraction of event data collection and storage, allowing it to be stored locally or external service..

Installation
------------

### Use Composer (*recommended*)

Get Composer at http://getcomposer.org

    php composer.phar require "michaelesmith/event-data" "dev-master"

Examples
--------

This isn't very useful in production to store the events in a local file but might be useful during configuration. You can also configure loggers.

```php
$edm = new \MS\EventData\EventDataManager(new \MS\EventData\Storage\File('/tmp/events.txt'));
$edm->addLogger(new \MS\EventData\Logger\GenericLogger());
$edm->store(new \MS\EventData\Event\Event('collection', ['field1' => 'val1']));
```

By default it will send the event immediately but this can be configured.

```php
$edm->setDelayed(true);

$edm->store(new \MS\EventData\Event\Event('collection', ['field1' => 'val1']));
...
$edm->store(new \MS\EventData\Event\Event('collection', ['field1' => 'val1']));
...

$edm->flush();
```

In this example the events are not sent to the storage until flush is called.

You can also put it in debug mode so events are logged but never sent to storage.

```php
$edm->setDebug(true);

$edm->store(new \MS\EventData\Event\Event('collection', ['field1' => 'val1']));
```

Finally a useful example. Here we send the event data to KeenIO and log with PSR logger like Monolog.

```php
$edm = new \MS\EventData\EventDataManager(new \MS\EventData\Storage\KeenIO($keenClient));
$edm->addLogger(new \MS\EventData\Logger\PSRLogger($monolog, $edm));
$edm->setDebug(DEBUG_MODE);
$edm->setDelayed(true);

...
$edm->store(new \MS\EventData\Event\Event('collection', ['field1' => 'val1']));
...

$edm->flush(); //after the response has been returned to the user
```
