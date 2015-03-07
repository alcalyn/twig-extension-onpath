Silex integration
=================


For Silex applications, just register OnPath extension:

For **Symfony >= 2.4**:

``` php
<?php

use Alcalyn\Extension\Twig\OnPath;

$onPath = new OnPath();
$onPath->setRequestStack($app['request_stack']);

$app['twig']->addExtension($onPath);
```


For **Symfony < 2.4**:

``` php
<?php

use Alcalyn\Extension\Twig\OnPath;

$onPath = new OnPath();
$onPath->setRequest($app['request']);

$app['twig']->addExtension($onPath);
```

> **Note**: For Symfony **< 2.4**,
> I'm not sure how to use scope with Silex,
> so correct me if I'm wrong when accessing `request` service
> (normally in `request` scope)
