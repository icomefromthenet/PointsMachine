<?php
namespace IComeFromTheNet\PointsMachine\DB;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Column;
use DBALGateway\Table\AbstractTable;
use DBALGateway\Table\TableInterface;
use DBALGateway\Table\TableEvent;
use DBALGateway\Table\TableEvents;
use DBALGateway\Exception as GatewayException;

/**
 * Table gateway pt_system
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
abstract class CommonTable extends AbstractTable implements TableInterface
{
    
    /**
     * Proxy the bound query builder to DBAL::fetchColumn
     * 
     * @return mixed
     * @access public
     * @param integer $iColumn the column number to return
     */ 
    public function fetchColumn($iColumn)
    {
        $this->event_dispatcher->dispatch(TableEvents::PRE_SELECT,new TableEvent($this));
        $result = null;
        
        try {
            
            $result = $this->head->getQuery()->fetchColumn($iColumn);

        } catch(DBALException $e) {
            throw new GatewayException($e->getMessage());
        }
        
        $this->event_dispatcher->dispatch(TableEvents::POST_SELECT,new TableEvent($this,$result));
        
        $this->clear();
        
        return $result;  
    }
    
    
}
/* End of Class */