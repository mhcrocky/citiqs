<?php 
    use \koolreport\pivot\widgets\PivotTable;
?>

<div class="text-center">
    <h1>Visitors</h1>
</div>
<hr/>
<?php
    $dataStore = $this->dataStore('visitors_report');
    PivotTable::create([
        'dataStore' => $dataStore, // $this->dataStore('visitors_report'),
        'rowDimension' => 'row',
        
        'rowCollapseLevels' => array(1),
        'width' => '100%',


        'cssClass' => [
            'table' => 'table table-hover table-bordered'
        ]
    ]);



                // $dataStore = $this->dataStore('sales');
                // PivotTable::create(array(
                //     'dataStore'=>$dataStore,
                //     'rowDimension'=>'row',
                //     'measures'=>array(
                //     'dollar_sales - sum', 
                //     'dollar_sales - count',
                //     ),
                //     'rowSort' => array(
                //     'dollar_sales - sum' => 'desc',
                //     ),
                //     'rowCollapseLevels' => array(1),
                //     'totalName' => 'All',
                //     'width' => '100%',
                //     'nameMap' => array(
                //     'dollar_sales - sum' => 'Sales (in USD)',
                //     'dollar_sales - count' => 'Number of Sales',
                //     ),
                // ));
?>