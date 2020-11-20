<?php
    include("./vendor/autoload.php");
    use \koolreport\drilldown\DrillDown;
    use \koolreport\processes\CopyColumn;
    use \koolreport\processes\DateTimeFormat;
    use \koolreport\widgets\google\ColumnChart;
    $this->load->model('Bookandpayagenda_model');
    // $this->load->model('spotmanage_model');
?>
<!-- <hr> -->
<!-- <br> -->
<div style="margin-top:5%; ">
    <div class="report-content">
        <div class="text-center">
            <!-- <h1>Sale By Time</h1>
            <p class="lead">
                This example shows how to setup a drill down report to see sale report
                by time.
                <br/>
                Please click on the column of chart to go further down on details. 
            </p> -->
        </div>

        <?php
        DrillDown::create(array(
            "name"=>"saleDrillDown",
            "title"=>"Sale Report",
            "levels"=>array(
                array(
                    "title"=>"Agenda",
                    "content"=>function($params,$scope)
                    {
                        ColumnChart::create(array(
                            "dataSource"=>($this->Bookandpayagenda_model->get_agenda_for_chart()),
                                // (
                                // $this->src("automaker")->query("
                                //     SELECT YEAR(paymentDate) as year,sum(amount) as sale_amount 
                                //     FROM payments
                                //     GROUP BY year
                                // ")
                            //),
                            "columns"=>array(
                                "date"=>array(
                                    "type"=>"string",
                                    "label"=>"Date",
                                ),
                                "numberofpersons"=>array(
                                    "label"=>"Vistor",
                                    // "prefix"=>"€",
                                )
                            ),
                            "clientEvents"=>array(
                                "itemSelect"=>"function(params){
                                    saleDrillDown.next({date:params.selectedRow[0]});
                                }",
                            )
                        ));
                    }
                ),
                
                array(
                    "title"=>function($params,$scope)
                    {
                        return "Spot ".$params["date"];
                    },
                    "content"=>function($params,$scope)
                    {
                        ColumnChart::create(array(
                            "dataSource"=>($this->Bookandpayagenda_model->get_spot_bydate($params["date"])),
                            "columns"=>array(
                                "spot_id"=>array(
                                    "type"=>"string",
                                    "label"=>"Spot",
                                    "formatValue"=>function($value,$row){
                                        return $row["image"];
                                    },
                                ),
                                "numberofpersons"=>array(
                                    "label"=>"Vistor",
                                    // "prefix"=>"€",
                                )
                            ),
                            "clientEvents"=>array(
                                "itemSelect"=>"function(params){
                                    saleDrillDown.next({spot_id:params.selectedRow[0]});
                                }",
                            )
                        ));
                    }        
                ),
                array(
                    "title"=>function($params,$scope)
                    {
                        return "Slot ".$params["spot_id"];
                    },
                    "content"=>function($params,$scope)
                    {
                        ColumnChart::create(array(
                            "dataSource"=>($this->Bookandpayagenda_model->get_slot_byspotid($params["spot_id"])),
                            "columns"=>array(
                                "timediff"=>array(
                                    "type"=>"string",
                                    "label"=>"Time",
                                ),
                                "numberofpersons"=>array(
                                    "label"=>"Vistor",
                                    // "prefix"=>"€",
                                )
                            ),
                            // "clientEvents"=>array(
                            //     "itemSelect"=>"function(params){
                            //         saleDrillDown.next({month:params.selectedRow[0]});
                            //     }",
                            // )
                        ));
                    }
                ),
            
            ),
            "themeBase" => "bs4",
        ));
        ?> 
    </div>
</div>
    