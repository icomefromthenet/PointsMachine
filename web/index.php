<?php
require __DIR__.'/../app.php';


use DateTime;
use Slim\App;
use DBALGateway\Feature\StreamQueryLogger;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;


$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new App($configuration);


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


// Middleware

/**
 * Converts date route param into a PHP DateTime
 * 
 * The api will pass a date in the format of yyyy-mm-dd or word 'current'
 * which must be translated into '3000-01-01'
 *
 * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
 * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
 * @param  callable                                 $next     Next middleware
 *
 * @return \Psr\Http\Message\ResponseInterface
 */
$oDateConvertMiddleware = function ($request, $response, $next) {
    
    $oRoute = $request->getAttribute('route');
    $mDateOption = $oRoute->getArgument('odate');

    $oDate = '';

    if('current' === $mDateOption) {
        
        $oDate = new DateTime('3000-01-01');
        
    } else {
    
        $oDate = DateTime::createFromFormat('Ymd',$mDateOption);
    }

    
    if(!$oDate instanceof DateTime) {
        throw new \RuntimeException('The odate route param is in invalid value');
    }
    
    $oRoute->setArgument('odate',$oDate);

    // invoke the next middle ware or APP Route Handler
    $response = $next($request, $response);


    return $response;
};

/**
 * Attach a Query Logger to the Request
 * 
 *
 * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
 * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
 * @param  callable                                 $next     Next middleware
 *
 * @return \Psr\Http\Message\ResponseInterface
 */
$oQueryLogMiddleware = function ($request, $response, $next) use ($app) {
    
    $oPointsContainer = $app->getContainer()->get('PointsMachine');

    $oPointsContainer->getDatabaseAdaper()
                     ->getConfiguration()
                     ->setSQLLogger(new StreamQueryLogger($oPointsContainer->getAppLogger()));
    

    // invoke the next middle ware or APP Route Handler
    $response = $next($request, $response);


    return $response;
};

  



// Home Routes

$app->get('/',function(ServerRequestInterface $request, ResponseInterface $response, $args){
    
    
    return $this->view->render($response, 'index.html.twig', [
        'sName' => 'Home',
        'sDescription' => 'Test Center for Points Machine'
    ]);
    
    
})->setName('home');



// Routes - Form Pages

$app->group('/setup', function () use ($app) {


    $app->get('/pointsystem',function(ServerRequestInterface $request, ResponseInterface $response, $args){
        
        
        return $this->view->render($response, 'setup_system.html.twig', [
            'sName' => 'Home',
            'sDescription' => 'Mange Points Systems'
        ]);
        
        
    })->setName('setup_system');






})->add($oQueryLogMiddleware);


// Routes - CRUD API

$app->group('/api', function () use ($app) {

    
    /**
     * List all points system valid at the assigned date
     *  
     * @return JSON
     */ 
    $app->get('/pointsystem/{odate}', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
        
        
        $oDate             = $args['odate'];
        $oPointsContainer  = $this->get('PointsMachine');
        $oSystemGateway    = $oPointsContainer->getGatewayCollection()->getGateway('pt_system');    
    
        
        $aResult = $oSystemGateway->selectQuery()
            ->start()
            ->filterCurrentOrValidityPeriod($oDate)
            ->end()         
        ->find();
        
        
        $response->withJson($aResult->toArray(),200);
        
        return $response;
        
        
    })->setName('get_system');
    
    
    
    /**
     * List a system zones at the assigned date and as an option limit to zones that 
     * are childen of a system x
     * 
     * @return json array of system zone entities
     */ 
    $app->get('/systemzone/{odate}',function(ServerRequestInterface $request, ResponseInterface $response, $args) use($app){
        
        $oDate             = $args['odate'];
        $oPointsContainer  = $this->get('PointsMachine');
        $oSystemZoneGateway= $oPointsContainer->getGatewayCollection()->getGateway('pt_system_zone'); 
        
        $aQueryParam       = $request->getQueryParams();
        $sSystemId         = null;
        
        if(isset($aQueryParam['sSystemId']) &&  false === empty($aQueryParam['sSystemId'])) {
            $sSystemId = $aQueryParam['sSystemId'];
        }
        
        
        $aResult = $oSystemZoneGateway->selectQuery()
            ->start()
            ->addSelect('s.system_name')
            ->withSystem('s')
            ->filterCurrentOrValidityPeriod($oDate)
            ->ifThen( false === empty($sSystemId),function($oQuery) use ($sSystemId){
        
                $oQuery->filterBySystem($sSystemId);
                
            })
            ->end()         
        ->find();
        
        
        $response->withJson($aResult->toArray(),200);
         
        return $response;
  
      
        
    })->setName('get_zone');
    
    
    
    /**
     * List all score groups assinged at date x
     * 
     * @return JSON array of score group entities
     */ 
    $app->get('/scoregroup/{odate}',function(ServerRequestInterface $request, ResponseInterface $response, $args) use($app){
   
        $oDate             = $args['odate'];
        $oPointsContainer  = $this->get('PointsMachine');
        $oScoreGroupGateway= $oPointsContainer->getGatewayCollection()->getGateway('pt_score_group'); 
     
   
        $aResult = $oScoreGroupGateway->selectQuery()
            ->start()
            ->filterCurrentOrValidityPeriod($oDate)
            ->end()         
        ->find();
        
        
        $response->withJson($aResult->toArray(),200);
      
        return $response;
  
    
     })->setName('get_score_group');
     
     
     
     /**
     * List all score s assinged at date x and as an option filter by a score group
     * 
     * @return JSON array of score group entities
     */  
    $app->get('/score/{odate}',function(ServerRequestInterface $request, ResponseInterface $response, $args) use($app){
  
        $oDate             = $args['odate'];
        $oPointsContainer  = $this->get('PointsMachine');
        $oScoreGateway     = $oPointsContainer->getGatewayCollection()->getGateway('pt_score'); 
        
        $aQueryParam       = $request->getQueryParams();
        $sScoreGroupId     = null;
        
        if(true === isset($aQueryParam['sScoreGroupId']) &&  false === empty($aQueryParam['sScoreGroupId'])) {
            $sScoreGroupId = $aQueryParam['sScoreGroupId'];
        }
        
        
        $aResult = $oScoreGateway->selectQuery()
            ->start()
            ->addSelect('sg.group_name as score_group_name')
            ->withScoreGroup('sg')
            ->filterCurrentOrValidityPeriod($oDate)
            ->ifThen( false === empty($sScoreGroupId),function($oQuery) use ($sScoreGroupId){
        
                $oQuery->filterByScoreGroup($sScoreGroupId);
                
            })
            ->end()         
        ->find();
        
        
        $response->withJson($aResult->toArray(),200);
   
        return $response;
  
  
    })->setName('get_score');
    
    
    
    

})->add($oDateConvertMiddleware,$oQueryLogMiddleware);


// Routes - Results JSON API

$app->group('/transactions', function () use ($app) {

    $app->get('/event', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    
        
        $oPointsContainer = $this->get('PointsMachine');
    
        $oEventGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_transaction_header');    
          
        
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
    
    
    $app->get('/score/{eventId}', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    
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
    
    $app->get('/adjgroup/{eventId}', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
        
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
    
    $app->get('/adjrule/{eventId}', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    
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



})->add($oQueryLogMiddleware);



// Run app
$app->run();