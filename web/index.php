<?php
require __DIR__.'/../app.php';



use Slim\App;
use DBALGateway\Feature\StreamQueryLogger;


$app = new App();


// Get container
$container = $app->getContainer();


// Register component on container


$container['PointsMachine'] = $oPointsContainer;



$container['view'] = function ($container) {
    
    $view = new \Slim\Views\Twig(__DIR__, [
        'cache' => false
    ]);
    
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};





// Home Routes

$app->get('/',function($request, $response, $args){
    
    
    return $this->view->render($response, 'index.html.twig', [
        'sName' => 'Home',
        'sDescription' => 'Test Center for Points Machine'
    ]);
    
    
})->setName('home');



// Routes - Form Pages

$app->get('/setup/pointsystem',function($request, $response, $args){
    
    
    return $this->view->render($response, 'setup_system.html.twig', [
        'sName' => 'Home',
        'sDescription' => 'Mange Points Systems'
    ]);
    
    
})->setName('setup_system');






// Routes - Results JSON API


$app->get('/transactions/event', function ($request, $response, $args) {

    
    $oPointsContainer = $this->get('PointsMachine');

    $oEventGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_transaction_header');    
    
    $oQueryLogger = new StreamQueryLogger($oPointsContainer->getAppLogger()); 
    $oEventGateway->getAdapater()->getConfiguration()->setSQLLogger($oQueryLogger);
      
    
    $aResult = $oEventGateway->selectQuery()
        ->start()
            ->addSelect('s.system_name','sz.zone_name','ev.event_name')
            ->withSystem('s')
            ->withSystemZone('sz')
            ->withEventType('ev')
            ->setMaxResults(100)
        ->end()         
    ->find();
    
    
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode(array('success'=>true, 'data' =>$aResult->toArray())));
    
    return $response;
    
    
});


$app->get('/transactions/score/{eventId}', function ($request, $response, $args) {

    $oPointsContainer =  $this->get('PointsMachine');

    $oEventGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_transaction_score');    
    
    $aResult = $oEventGateway->selectQuery()
        ->start()
            ->addSelect('s.score_name','ss.group_name as score_group_name')
            ->withScore('s')
            ->withScoreGroup('sg')
            ->filterByScoringEvent($args['eventId'])
        ->end()         
    ->find();
    
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode(array('success'=>true, 'data' =>$aResult))); 
    
    return $response;
    
    
});

$app->get('/transactions/adjgroup/{eventId}', function ($request, $response, $args) {
    
    $oPointsContainer =  $this->get('PointsMachine');

   
    $oEventGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_transaction_group');    
    
    
    $aResult = $oEventGateway->selectQuery()
        ->start()
            ->addSelect('ag.rule_group_name')
            ->withAdjustmentGroup('ag')
            ->filterByScoringEvent($args['eventId'])
        ->end()         
    ->find();
    
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode(array('success'=>true, 'data' =>$aResult))); 
    
    return $response;
    
});

$app->get('/transactions/adjrule/{eventId}', function ($request, $response, $args) {

     $oPointsContainer =  $this->get('PointsMachine');

    
    $oEventGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_transaction_rule');    


    $aResult = $oEventGateway->selectQuery()
        ->start()
            ->addSelect('ae.rule_name','ag.rule_group_name','s.score_name')
            ->withAdjustmentRule('ar')
            ->withAdjustmentGroup('ag')
            ->withScore('s')
            ->filterByScoringEvent($args['eventId'])
        ->end()         
    ->find();
    
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode(array('success'=>true, 'data' =>$aResult)));  
    
    return $response;
    
    
});


// Run app
$app->run();