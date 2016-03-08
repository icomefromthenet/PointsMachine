<?php
require __DIR__.'/../app.php';



use Slim\App;
use DBALGateway\Feature\StreamQueryLogger;


$app = new App();


// Get container
$container = $app->getContainer();

$container['PointsMachine'] = $oPointsContainer;

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
            ->addSelect('s.score_name','ss.group_name')
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
            ->addSelect('ae.rule_name','ag.rule_group_name')
            ->withAdjustmentRule('ar')
            ->withAdjustmentGroup('ag')
            ->filterByScoringEvent($args['eventId'])
        ->end()         
    ->find();
    
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode(array('success'=>true, 'data' =>$aResult)));  
    
    return $response;
    
    
});


// Run app
$app->run();