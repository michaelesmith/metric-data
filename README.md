[![Build Status](https://travis-ci.org/michaelesmith/EventData.svg)](http://secure.travis-ci.org/michaelesmith/EventData)

# What is it?
This is a library that allows for easy abstraction of metric data collection and storage, allowing it to be stored locally or via external API.

# Installation
`composer require "michaelesmith/metric-data"`

# All About Metrics
For this library all data points are referred to as metrics and used via `MetricData\Metric\MetricInterface` which defines 3 required methods `getDateTime()`, `getType()` and `getData()`. You can implement the interface to define your own metrics based on your specific business logic but a few basic implementations are provided in:
* `MetricData\Metric\Metric`: Data can be any type
* `MetricData\Metric\IntegerMetric`: Data is typed to an integer
* `MetricData\Metric\FloatMetric`: Data is typed to an float
* `MetricData\Metric\ArrayMetric`: Data is an array

# Basic Storage Examples
This section will walk through examples for each of the storage types. In these examples when a child sotrage is needed a `NullStorage` is generally used for illustration.

## Closure
This storage allows you to quickly integrate virtually any backend via a closure. It is till recommend in most case to create a full blown extension class once you prototype the system and are ready for production.
```php
use MetricData\Metric\Metric;
use MetricData\Storage\ClosureStorage;

$storage = new ClosureStorage(
    function (MetricInterface $metric) use ($someAPI){
        $someAPI->send($metric->getType(), $metric->getData());
    }
);

$storage->store(
    new Metric(
        new \DateTime(),
        'metric_collection_type',
        7
    )
);
```

## Delayed
This storage allows you to queue up metric data during a request and the flush them to another storage, which will allow you to delay the possibly long processing time until after the response has been sent to the user.
```php
use MetricData\Metric\Metric;
use MetricData\Storage\DelayedStorage;
use MetricData\Storage\NullStorage;

$storage = new DelayedStorage(new NullStorage());

$storage->store(
    new Metric(
        new \DateTime(),
        'metric_collection_type',
        7
    )
);
$storage->store(
    new Metric(
        new \DateTime(),
        'metric_collection_type',
        5
    )
);
$storage->store(
    new Metric(
        new \DateTime(),
        'another_collection_type',
        1
    )
);

$storage->flush();
```

## File
This storage will store the metrics in a JOSN encoded file. This can be usefully for testing or if you want to process the events in mass with some other tool out of band of the user request / response cycle.
```php
use MetricData\Metric\Metric;
use MetricData\Storage\FileStorage;

$storage = new FileStorage('var/metrics.json');

$storage->store(
    new Metric(
        new \DateTime(),
        'metric_collection_type',
        7
    )
);
```

## KeenIO
This storage allows you to send metric data to the [KeenIO API](https://keen.io).
```php
use KeenIO\Client\KeenIOClient;
use MetricData\Metric\Metric;
use MetricData\Storage\KeenIOStorage;

$client = KeenIOClient::factory([
    'projectId' => $projectId,
    'writeKey'  => $writeKey,
]);

$storage = new KeenIOStorage($client);

$storage->store(
    new Metric(
        new \DateTime(),
        'metric_collection_type',
        7
    )
);
```

## Logging
This storage will log to a PSR-3 logger before passing the metric to a child storage.
```php
use MetricData\Metric\Metric;
use MetricData\Storage\LoggingStorage;
use MetricData\Storage\NullStorage;

$logger = // Some PSR-3 compatible logger sucha as [monolog](https://github.com/Seldaek/monolog)

$storage = new LoggingStorage($logger, 'info', new NullStorage());

$storage->store(
    new Metric(
        new \DateTime(),
        'metric_collection_type',
        7
    )
);
```

## Memory
This storage is not particularly useful in production but is very fast when used in a testing environment while still allowing for the storing of events to be tested. 
```php
use MetricData\Metric\Metric;
use MetricData\Storage\MemoryStorage;

$storage = new MemoryStorage();

$storage->store(
    new Metric(
        new \DateTime(),
        'metric_collection_type',
        7
    )
);

$storage->getMetrics(); // retrieves all metrics stored
$storage->count(); // gets the number of metrics stored in this request
$storage->first(); // gets only the first metric stored
$storage->last(); // gets only the last metrics stored
```

## Multiple
This storage allows metrics to be sent to multiple child storages.
```php
use MetricData\Metric\Metric;
use MetricData\Storage\MulitpleStorage;
use MetricData\Storage\NullStorage;

$storage = new MulitpleStorage([
    new NullStorage(),
    new NullStorage(),
    new NullStorage(),
]);

$storage->store(
    new Metric(
        new \DateTime(),
        'metric_collection_type',
        7
    )
);
```

## Null
This storage is the equivalent of `/dev/null`, any metric stored here will simple disappear into the ether. Not useful for production but can be used in scenarios where you don't need to store metrics like unit tests.
```php
use MetricData\Metric\Metric;
use MetricData\Storage\NullStorage;

$storage = new NullStorage();

$storage->store(
    new Metric(
        new \DateTime(),
        'metric_collection_type',
        7
    )
);
```

# Advanced Storage Examples
While these storages can be used individually, their power comes from the ability to combine them to build powerful functionality specific to the needs of different application environments but which can easily interchange allowing the application to be unaware of the particular configuration.

## Development
```php
use MetricData\Metric\Metric;
use MetricData\Storage\FileStorage;
use MetricData\Storage\LoggingStorage;
use MetricData\Storage\MemoryStorage;
use MetricData\Storage\MultipleStorage;

$storage = new LoggingStorage($logger, 'info', // will log all metrics to the application log
    new MultipleStorage([
       new FileStorage('var/metrics.json'), // provides a record of each metric stored
       $memoryStorage = new MemoryStorage(), // can be retrieved by profiling tools like the Symfony toolbar
   ])
);

$storage->store(
    new Metric(
        new \DateTime(),
        'metric_collection_type',
        7
    )
);
```

## Testing
```php
use MetricData\Metric\Metric;
use MetricData\Storage\NullStorage;

$storage = new NullStorage();

$storage->store(
    new Metric(
        new \DateTime(),
        'metric_collection_type',
        7
    )
);
```

## Production
```php
use KeenIO\Client\KeenIOClient;
use MetricData\Metric\Metric;
use MetricData\Storage\KeenIOStorage;
use MetricData\Storage\LoggingStorage;

$client = KeenIOClient::factory([
    'projectId' => $projectId,
    'writeKey'  => $writeKey,
]);

$storage = new LoggingStorage($logger, 'info', // will log all metrics to the application log
    $delayedStorage = new DelayedStorage( // allow the user response to be sent before performing the expensive API calls
        new KeenIOStorage($client) // production metrics will be sent to an external api
    )
);

$storage->store(
    new Metric(
        new \DateTime(),
        'metric_collection_type',
        7
    )
);

// send user response

if (isset($delayedStorage)) {
    $delayedStorage->flush();
}
```

# Contributing
Have an idea to make something better? Submit a pull request. Need integration of some other backend service? Build it. I would be happy to add a link here. PR's make the open source world turn. :earth_americas: :earth_asia: :earth_africa: :octocat: Happy Coding!
