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
    
    $view = new \Slim\Views\Twig(__DIR__.'/template', [
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
            'sName' => 'Points Systems',
            'sDescription' => 'Mange Points Systems'
        ]);
        
        
    })->setName('setup_system');



    $app->get('/systemzones',function(ServerRequestInterface $request, ResponseInterface $response, $args){
        
        
        return $this->view->render($response, 'setup_zone.html.twig', [
            'sName' => 'Point System Zones',
            'sDescription' => 'Mange Points Systems Zones'
        ]);
        
        
    })->setName('setup_zone');


    $app->get('/eventtype',function(ServerRequestInterface $request, ResponseInterface $response, $args){
        
        
        return $this->view->render($response, 'setup_event.html.twig', [
            'sName' => 'Event Types',
            'sDescription' => 'Mange Event Types'
        ]);
        
        
        
    })->setName('setup_event');

    
    
    $app->get('/score',function(ServerRequestInterface $request, ResponseInterface $response, $args){
        
        
        return $this->view->render($response, 'setup_score.html.twig', [
            'sName' => 'Scores',
            'sDescription' => 'Mange Scores'
        ]);
        
        
        
    })->setName('setup_score');

    
    $app->get('/scoregroup',function(ServerRequestInterface $request, ResponseInterface $response, $args){
        
        
        return $this->view->render($response, 'setup_score_group.html.twig', [
            'sName' => 'Score Groups',
            'sDescription' => 'Mange Score Groups'
        ]);
        
        
        
    })->setName('setup_scoregroup');
    
    
    $app->get('/rulechain',function(ServerRequestInterface $request, ResponseInterface $response, $args){
        
        
        return $this->view->render($response, 'setup_rulechain.html.twig', [
            'sName' => 'Rule Chains',
            'sDescription' => 'Mange Rule Chains'
        ]);
        
        
        
    })->setName('setup_rulechain');
    
    
    $app->get('/chainmember',function(ServerRequestInterface $request, ResponseInterface $response, $args){
        
        
        return $this->view->render($response, 'setup_chainmember.html.twig', [
            'sName' => 'Rule Chain Members',
            'sDescription' => 'Mange Rule Chain Members'
        ]);
        
        
        
    })->setName('setup_chainmember');
    
    
    $app->get('/adjgroup',function(ServerRequestInterface $request, ResponseInterface $response, $args){
        
        
        return $this->view->render($response, 'setup_adjgroup.html.twig', [
            'sName' => 'Adjustment Rule Groups',
            'sDescription' => 'Mange Rule Rule Groups'
        ]);
        
        
        
    })->setName('setup_adjgroup');
    
    
    $app->get('/adjrule',function(ServerRequestInterface $request, ResponseInterface $response, $args){
        
        
        return $this->view->render($response, 'setup_adjrule.html.twig', [
            'sName' => 'Adjustment Rules',
            'sDescription' => 'Mange Rule Rules'
        ]);
        
        
        
    })->setName('setup_adjrule');
    

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
            ->withSystem('s',$oDate)
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
            ->withScoreGroup('sg',$oDate)
            ->filterCurrentOrValidityPeriod($oDate)
            ->ifThen( false === empty($sScoreGroupId),function($oQuery) use ($sScoreGroupId){
        
                $oQuery->filterByScoreGroup($sScoreGroupId);
                
            })
            ->end()         
        ->find();
        
        
        $response->withJson($aResult->toArray(),200);
   
        return $response;
  
  
    })->setName('get_score');
    
    
    /**
     * List all adjustment rule groups assinged at date x
     * 
     * @return JSON array of adjustment group entities
     */ 
    $app->get('/adjgroup/{odate}',function(ServerRequestInterface $request, ResponseInterface $response, $args) use($app){
   
        $oDate             = $args['odate'];
        $oPointsContainer  = $this->get('PointsMachine');
        $oAdjGroupGateway= $oPointsContainer->getGatewayCollection()->getGateway('pt_rule_group'); 
     
   
        $aResult = $oAdjGroupGateway->selectQuery()
            ->start()
            ->filterCurrentOrValidityPeriod($oDate)
            ->end()         
        ->find();
        
        
        $response->withJson($aResult->toArray(),200);
      
        return $response;
  
    
     })->setName('get_adj_group');
     
     
     /**
     * List all adj rules s assinged at date x and as an option filter by a adj group
     * 
     * @return JSON array of adjustment rule group entities
     */  
    $app->get('/adjrule/{odate}',function(ServerRequestInterface $request, ResponseInterface $response, $args) use($app){
  
        $oDate             = $args['odate'];
        $oPointsContainer  = $this->get('PointsMachine');
        $oRuleGateway     = $oPointsContainer->getGatewayCollection()->getGateway('pt_rule'); 
        
        $aQueryParam       = $request->getQueryParams();
        $sRuleGroupId     = null;
        
        if(true === isset($aQueryParam['sAdjustmentGroupId']) &&  false === empty($aQueryParam['sAdjustmentGroupId'])) {
            $sRuleGroupId = $aQueryParam['sAdjustmentGroupId'];
        }
        
        
        $aResult = $oRuleGateway->selectQuery()
            ->start()
            ->addSelect('rg.rule_group_name AS rule_group_name')
            ->withAdjustmentGroup('rg',$oDate)
            ->filterCurrentOrValidityPeriod($oDate)
            ->ifThen( false === empty($sRuleGroupId),function($oQuery) use ($sRuleGroupId){
        
                $oQuery->filterByAdjustmentGroup($sRuleGroupId);
                
            })
            ->end()         
        ->find();
        
        
        $response->withJson($aResult->toArray(),200);
   
        return $response;
  
  
    })->setName('get_rule');
    
    
     /**
     * List all adj rules assinged at date x and as an option filter by a system zone
     * 
     * @return JSON array of adjustment rule entities
     */  
    $app->get('/adjzone/{odate}',function(ServerRequestInterface $request, ResponseInterface $response, $args) use($app){
  
        $oDate             = $args['odate'];
        $oPointsContainer  = $this->get('PointsMachine');
        $oRuleGateway     = $oPointsContainer->getGatewayCollection()->getGateway('pt_rule_sys_zone'); 
        
        $aQueryParam       = $request->getQueryParams();
        $sZoneId     = null;
        
        if(true === isset($aQueryParam['sZoneId']) &&  false === empty($aQueryParam['sZoneId'])) {
            $sZoneId = $aQueryParam['sZoneId'];
        }
        
        
        $aResult = $oRuleGateway->selectQuery()
            ->start()
            ->addSelect('sz.zone_name AS zone_name', 'r.rule_name AS rule_name')
            ->withAdjustmentRule('r',$oDate)
            ->withSystemZone('sz',$oDate)
            ->filterCurrentOrValidityPeriod($oDate)
            ->ifThen( false === empty($sZoneId),function($oQuery) use ($sZoneId){
        
                $oQuery->filterBySystemZone($sZoneId);
                
            })
            ->end()         
        ->find();
        
        
        $response->withJson($aResult->toArray(),200);
   
        return $response;
  
  
    })->setName('get_adjzone');
    
    
    /**
     * List all adj group limits assinged at date x and as an option filter by a system or score group
     * 
     * @return JSON array of adjustment rule entities
     */  
    $app->get('/adjgrouplimit/{odate}',function(ServerRequestInterface $request, ResponseInterface $response, $args) use($app){
  
        $oDate             = $args['odate'];
        $oPointsContainer  = $this->get('PointsMachine');
        $oAdjLimitGateway  = $oPointsContainer->getGatewayCollection()->getGateway('pt_rule_group_limits'); 
        
        $aQueryParam       = $request->getQueryParams();
        $sSystemId         = null;
        $sScoreGroupId     = null;
        
        if(true === isset($aQueryParam['sScoreGroupId']) &&  false === empty($aQueryParam['sScoreGroupId'])) {
            $sScoreGroupId = $aQueryParam['sScoreGroupId'];
        }
        
        if(true === isset($aQueryParam['sSystemId']) &&  false === empty($aQueryParam['sSystemId'])) {
            $sSystemId = $aQueryParam['sSystemId'];
        }
        
        $aResult = $oAdjLimitGateway->selectQuery()
            ->start()
            ->addSelect('ag.rule_group_name AS rule_group_name', 'r.system_name AS system_name',' ag.group_name AS score_group_name')
            ->withAdjustmentGroup('ag',$oDate)
            ->withSystem('s',$oDate)
            ->withScoreGroup('sg',$oDate)
            ->filterCurrentOrValidityPeriod($oDate)
            ->ifThen( false === empty($sScoreGroupId),function($oQuery) use ($sScoreGroupId){
        
                $oQuery->filterByScoreGroup($sScoreGroupId);
                
            })
            ->ifThen( false === empty($sSystemId),function($oQuery) use ($sSystemId){
        
                $oQuery->filterBySystem($sSystemId);
                
            })
            ->end()         
        ->find();
        
        
        $response->withJson($aResult->toArray(),200);
   
        return $response;
  
  
    })->setName('get_adjgrouplimit');
    
    
    
    /**
     * List all Event Types assinged at date x 
     * 
     * @return JSON array of adjustment rule entities
     */  
    $app->get('/eventtype/{odate}',function(ServerRequestInterface $request, ResponseInterface $response, $args) use($app){
  
        $oDate             = $args['odate'];
        $oPointsContainer  = $this->get('PointsMachine');
        $oEventTypeGateway = $oPointsContainer->getGatewayCollection()->getGateway('pt_event_type'); 
        
        
        
        $aResult = $oEventTypeGateway->selectQuery()
            ->start()
            ->filterCurrentOrValidityPeriod($oDate)
            ->end()         
        ->find();
        
        
        $response->withJson($aResult->toArray(),200);
   
        return $response;
  
    
    })->setName('get_event');
    
    
    
    /**
     * List all Rule Chains assinged at date x and as an option filter by an event type
     * 
     * @return JSON array of adjustment rule entities
     */  
    $app->get('/rulechain/{odate}',function(ServerRequestInterface $request, ResponseInterface $response, $args) use($app){
  
        $oDate             = $args['odate'];
        $oPointsContainer  = $this->get('PointsMachine');
        $oRuleChainGateway     = $oPointsContainer->getGatewayCollection()->getGateway('pt_rule_chain'); 
        
        $aQueryParam       = $request->getQueryParams();
        $sEventTypeId     = null;
        
        if(true === isset($aQueryParam['sEventTypeId']) &&  false === empty($aQueryParam['sEventTypeId'])) {
            $sEventTypeId = $aQueryParam['sEventTypeId'];
        }
        
        
        $aResult = $oRuleChainGateway->selectQuery()
            ->start()
            ->addSelect('et.event_name','s.system_name')
            ->withEventType('et',$oDate)
            ->withSystem('s',$oDate)
            ->filterCurrentOrValidityPeriod($oDate)
            ->ifThen( false === empty($sEventTypeId),function($oQuery) use ($sEventTypeId){
        
                $oQuery->filterByEventType($sEventTypeId);
                
            })
            ->end()         
        ->find();
        
        
        $response->withJson($aResult->toArray(),200);
   
        return $response;
  
  
    
    })->setName('get_chain');
    
     /**
     * List all Rule Chains Members assinged at date x and as an option filter by a rule chain or adj group
     * 
     * @return JSON array of adjustment rule entities
     */  
    $app->get('/chainmember/{odate}',function(ServerRequestInterface $request, ResponseInterface $response, $args) use($app){
  
        $oDate                  = $args['odate'];
        $oPointsContainer       = $this->get('PointsMachine');
        $oChainMemberGateway    = $oPointsContainer->getGatewayCollection()->getGateway('pt_chain_member'); 
        
        $aQueryParam       = $request->getQueryParams();
        $sAdjRuleId        = null;
        $sRuleChainId      = null;
        
        if(true === isset($aQueryParam['sAdjustmentGroupId']) &&  false === empty($aQueryParam['sAdjustmentGroupId'])) {
            $sAdjRuleId = $aQueryParam['sAdjustmentGroupId'];
        }
        
        if(true === isset($aQueryParam['sRuleChainId']) &&  false === empty($aQueryParam['sRuleChainId'])) {
            $sRuleChainId = $aQueryParam['sRuleChainId'];
        }
        
        $aResult = $oChainMemberGateway->selectQuery()
            ->start()
            ->addSelect('ag.rule_group_name','rc.chain_name')
            ->withAjustmentGroup('ag',$oDate)
            ->withRuleChain('rc',$oDate)
            ->filterCurrentOrValidityPeriod($oDate)
            ->ifThen( false === empty($sAdjRuleId),function($oQuery) use ($sAdjRuleId){
        
                $oQuery->filterByAdjustmentGroup($sAdjRuleId);
                
            })
             ->ifThen( false === empty($sRuleChainId),function($oQuery) use ($sRuleChainId){
        
                $oQuery->filterByRuleChain($sRuleChainId);
                
            })
            ->end()         
        ->find();
        
        
        $response->withJson($aResult->toArray(),200);
   
        return $response;
  
  
    
    })->setName('get_chainmember');
    

})->add($oDateConvertMiddleware)->add($oQueryLogMiddleware);


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