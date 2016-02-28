<?php
 include '../vendor/autoload.php';

 use Monolog\Logger;
 use Monolog\Handler\StreamHandler;
 use DBALGateway\Feature\BufferedQueryLogger;
 use IComeFromTheNet\PointsMachine\PointsMachineContainer;
 use Symfony\Component\EventDispatcher\EventDispatcher;


if(php_sapi_name() !== 'cli') {
    echo 'must be run via the cli';
    exit(1);
}

/*
* Start The Database
*/
$config = new \Doctrine\DBAL\Configuration();
$DEMO_DATABASE_USER ="pointsmachine";
$DEMO_DATABASE_PASSWORD ="pointsmachinepwis?";
$DEMO_DATABASE_SCHEMA = "pointsmachine";
$DEMO_DATABASE_PORT = "3306";
$DEMO_DATABASE_HOST = "127.0.0.1";
$DEMO_DATABASE_TYPE ="pdo_mysql";

$connectionParams = array(
    'dbname' => $DEMO_DATABASE_SCHEMA,
    'user' => $DEMO_DATABASE_USER,
    'password' => $DEMO_DATABASE_PASSWORD,
    'host' => $DEMO_DATABASE_HOST,
    'driver' => $DEMO_DATABASE_TYPE,
);

$oConn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);


/**
 * Start the Logger
 */ 
$oLog = new BufferedQueryLogger();
$oLog->setMaxBuffer(100);
$oConn->getConfiguration()->setSQLLogger($oLog);

// create a log channel
$ologger = new Logger('runner');
$ologger->pushHandler(new StreamHandler(__DIR__.'/out.log', Logger::DEBUG));

/**
 * Start Event Dispatcher
 */

$oEvent = new EventDispatcher();

/**
 * Build the container
 */ 
 
 $oPointsContainer = new PointsMachineContainer($oEvent,$oConn,$ologger);
 
 $oPointsContainer->boot(new \DateTime('now'));
 
 /*
 * Run the example file
 */
 
 if(false === isset($argv[1])) {
     echo 'Please provide an example to run'. PHP_EOL;
     exit(1);
 }
 
 $oConn->beginTransaction();
 
 try{
    
    $oExample = include($argv[1].'.php');
  
  
    if(false === is_object($oExample) || false === ($oExample instanceof Closure)) {
     echo 'Example not return as expected' . PHP_EOL;
     exit(1);
    }
   
   echo $oExample($oPointsContainer);

    $oConn->commit();
 } catch(Exception $e) {
    $oConn->rollBack();
    throw $e;
 }
 
 
 
  