<?php
// Logger
$app->add(new Middlewares\Logger(
    $container->get('logger'),
    $container
));
