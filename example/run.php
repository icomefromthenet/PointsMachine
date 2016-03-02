<?php


if(php_sapi_name() !== 'cli') {
    echo 'must be run via the cli';
    exit(1);
}


require __DIR__ .'/../app.php';


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
 
 
 
  