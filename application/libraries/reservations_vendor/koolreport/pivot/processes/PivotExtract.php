<?php
/* Usage
 * ->pipe(new PivotExtract(array(
        "row" => array(
            // "dimension" => "row",
            "parent" => array(
                "customerName" => "AV Stores, Co."
            ),
            "sort" => array(
                'dollar_sales - sum' => 'desc',
            ),
        ),
        "column" => array(
            // "dimension" => "column",
            "parent" => array(
                "orderYear" => "2004"
            ),
            "sort" => array(
                'orderMonth' => function($a, $b) {
                    return (int)$a < (int)$b;
                },
            ),
        ),
    )))
 * */
namespace koolreport\pivot\processes;
use \koolreport\pivot\PivotReader;

class PivotExtract extends \koolreport\core\Process
{
    public function onInit() 
    {
        $this->srcData = array();
    }

    public function onInput($row)
    {
        array_push($this->srcData, $row);
	}
    
    public function finalize() {
        $dataStore = new \koolreport\core\DataStore();
        $dataStore->meta($this->srcMeta);
        $dataStore->data($this->srcData);
        $pivotReader = new PivotReader($dataStore);
        if (! isset($this->params['includeAll']))
            $this->params['includeAll'] = true;
        $this->extractDatastore = $pivotReader->getDataStore($this->params);
    }
    
    public function receiveMeta($metaData, $source) 
    {
        $this->srcMeta = $metaData;
    }
    
    public function onInputEnd()
    {
        $this->finalize();
            
        $this->sendMeta($this->extractDatastore->meta());
        
        $data = $this->extractDatastore->data();
        foreach($data as $row)
        {
            $this->next($row);
        }		
    }
}