<?php
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Response;

$routes = new Routing\RouteCollection();

$routes->add(
    'to_index_route',
    new Routing\Route(
        '/{_controller}',
        array('_action' => 'index')
    )
);

$routes->add(
    'complete_route',
    new Routing\Route(
        '/{_controller}/{_action}'
    )
);

return $routes;
