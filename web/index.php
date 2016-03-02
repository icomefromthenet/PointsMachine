<?php

$app = new \Slim\App();

$app['PointsMachine'] = $oPointsContainer;




$app->get('/books/{id}', function ($request, $response, $args) {
    // Show book identified by $args['id']
});