<?php
require 'vendor/autoload.php';

use Buddy\Config;
use Pimple\Container;
use Buddy\Database;
use Buddy\Tickets;

$container = new Container();

$container['config'] = new Config();
$container['db'] = new Database($container['config']);

$app = new \Slim\Slim();

$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());

$app->get('/api/tickets', function() use ($app, $container) {
    $tickets = new Tickets($container['db'], $container['config']['TABLE_PREFIX']);
    $ticketList = $app->request->get('tickets');
    if (!is_null($ticketList)) {
        $tickets->filterByNumber(explode(',', $ticketList));
    }
    $app->render(200,array(
        'tickets' => $tickets->get(),
    ));
});
$app->run();