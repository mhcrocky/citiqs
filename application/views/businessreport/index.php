<?php 
    $this->config->load('custom', true);  
    $custom = $this->config->item('custom'); 
    $colors = $custom['typeColors'];
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
.date {
  width: 100%;
  height: 32px;
  padding: .375rem .75rem;
  font-size: 14px;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: .25rem;
}
.hidden {
  display: none;
}

.btn-refund {
  background: #ff704d !important;
  color: #fff !important;
  border-color: #ff5c33 !important;
}

.single-report {
  border-radius: 20px !important;
}

td.details-control {
		background: url("<?php echo base_url('assets/images/datatables/details_open.png') ?>") no-repeat center center;
		cursor: pointer;
	}

	tr.shown td.details-control {
		background: url("<?php echo base_url('assets/images/datatables/details_close.png') ?>") no-repeat center center;
	}
</style>
<div style="visibility: hidden;" class="main-content-inner ui-sortable">
    <div class="sales-report-area mt-5 mb-5 row-sort ui-sortable" data-rowposition="1" data-rowsort="1">
                <div id="sortable" style="visibility: hidden;" class="row ui-sortable">
                    <div class="col-md-3 ui-sortable mb-3" data-position="1" data-sort="1">
                            <div style="height:160px;" class="single-report mb-xs-30"><div style="min-height:500px;position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background: #0066ff;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Total</h4>
                                        <p>TODAY</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2>€ <?php echo intval($day_total['total']*100)/100; ?></h2>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div  class="col-md-3 ui-sortable mb-3" data-position="2" data-sort="1"> 
                            <div style="height:160px;" class="single-report mb-xs-30"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background:  <?php echo $colors['local']; ?>;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Local</h4>
                                        <p>TODAY</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2>€ <?php echo intval($day_total['local']*100)/100; ?></h2>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ui-sortable mb-3" data-position="3" data-sort="1">
                            <div  style="height:160px;"  class="single-report mb-xs-30"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background: <?php echo $colors['delivery']; ?>;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Delivery</h4>
                                        <p>TODAY</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2>€ <?php echo intval($day_total['delivery']*100)/100; ?></h2>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ui-sortable mb-3" data-position="4" data-sort="1">
                            <div  style="height:160px;"  class="single-report"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div style="background: <?php echo $colors['pickup']; ?>;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Pick Up</h4>
                                        <p>TODAY</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2>€ <?php echo intval($day_total['pickup']*100)/100; ?></h2>
                                        <span> </span>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-3 ui-sortable mb-3" data-position="5" data-sort="1">
                            <div style="height:160px;" class="single-report mb-xs-30"><div style="min-height:500px;position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background: #0066ff;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Total</h4>
                                        <p>THIS WEEK</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2>€ <?php echo intval($last_week_total['total']*100)/100; ?></h2>
                                        <span>
                                        <?php echo $compare['total']; ?>% 
                                        <?php if($compare['total']>0) : ?>
                                        <i class="fa fa-long-arrow-up text-success" aria-hidden="true"></i>
                                        <?php elseif($compare['total']<0): ?>
                                        <i class="fa fa-long-arrow-down text-danger" aria-hidden="true"></i>
                                        <?php endif; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div  class="col-md-3 ui-sortable mb-3" data-position="6" data-sort="1"> 
                            <div style="height:160px;" class="single-report mb-xs-30"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background:  <?php echo $colors['local']; ?>;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Local</h4>
                                        <p>THIS WEEK</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2>€ <?php echo intval($last_week_total['local']*100)/100; ?></h2>
                                        <span>
                                        <?php echo $compare['local']; ?>% 
                                        <?php if($compare['local']>0) : ?>
                                        <i class="fa fa-long-arrow-up text-success" aria-hidden="true"></i>
                                        <?php elseif($compare['local']<0): ?>
                                        <i class="fa fa-long-arrow-down text-danger" aria-hidden="true"></i>
                                        <?php endif; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ui-sortable mb-3" data-position="7" data-sort="1">
                            <div  style="height:160px;"  class="single-report mb-xs-30"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background: <?php echo $colors['delivery']; ?>;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Delivery</h4>
                                        <p>THIS WEEK</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2>€ <?php echo intval($last_week_total['delivery']*100)/100; ?></h2>
                                        <span>
                                        <?php echo $compare['delivery']; ?>% 
                                        <?php if($compare['delivery']>0) : ?>
                                        <i class="fa fa-long-arrow-up text-success" aria-hidden="true"></i>
                                        <?php elseif($compare['delivery']<0): ?>
                                        <i class="fa fa-long-arrow-down text-danger" aria-hidden="true"></i>
                                        <?php endif; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ui-sortable mb-3" data-position="8" data-sort="1">
                            <div  style="height:160px;"  class="single-report"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div style="background: <?php echo $colors['pickup']; ?>;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Pick Up</h4>
                                        <p>THIS WEEK</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2>€ <?php echo intval($last_week_total['pickup']*100)/100; ?></h2>
                                        <span>
                                        <?php echo $compare['pickup']; ?>% 
                                        <?php if($compare['pickup']>0) : ?>
                                        <i class="fa fa-long-arrow-up text-success" aria-hidden="true"></i>
                                        <?php elseif($compare['pickup']<0): ?>
                                        <i class="fa fa-long-arrow-down text-danger" aria-hidden="true"></i>
                                        <?php endif; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ui-sortable mb-3" data-position="9" data-sort="1">
                            <div style="height:160px;" class="single-report mb-xs-30"><div style="min-height:500px;position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background: #0066ff;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Total</h4>
                                        <p>TIMESTAMP</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2 id="total"></h2>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div  class="col-md-3 ui-sortable mb-3" data-position="10" data-sort="1"> 
                            <div style="height:160px;" class="single-report mb-xs-30"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background:  <?php echo $colors['local']; ?>;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Local</h4>
                                        <p>TIMESTAMP</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2 id="local"></h2>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ui-sortable mb-3" data-position="11" data-sort="1">
                            <div  style="height:160px;"  class="single-report mb-xs-30"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background: <?php echo $colors['delivery']; ?>;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Delivery</h4>
                                        <p>TIMESTAMP</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2 id="delivery"></h2>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ui-sortable mb-3" data-position="12" data-sort="1">
                            <div  style="height:160px;"  class="single-report"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div style="background: <?php echo $colors['pickup']; ?>;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Pick Up</h4>
                                        <p>TIMESTAMP</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2 id="pickup"></h2>
                                        <span> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ui-sortable mb-3" data-position="13" data-sort="1">
                            <div style="height:160px;" class="single-report mb-xs-30"><div style="min-height:500px;position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background: #0066ff;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Orders</h4>
                                        <p>TODAY</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2><?php echo $day_orders; ?></h2>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div  class="col-md-3 ui-sortable mb-3" data-position="14" data-sort="1"> 
                            <div style="height:160px;" class="single-report mb-xs-30"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background:  <?php echo $colors['local']; ?>;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Orders</h4>
                                        <p>WEEK</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2><?php echo $week_orders; ?></h2>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ui-sortable mb-3" data-position="15" data-sort="1">
                            <div  style="height:160px;"  class="single-report mb-xs-30"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background: <?php echo $colors['delivery']; ?>;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Orders</h4>
                                        <p>LAST WEEK</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2><?php echo $last_week_orders; ?></h2>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ui-sortable mb-3" data-position="16" data-sort="1">
                            <div  style="height:160px;"  class="single-report"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div style="background: <?php echo $colors['pickup']; ?>;" class="icon">&nbsp</div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Orders</h4>
                                        <p>TIMESTAMP</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2 id="orders"></h2>
                                        <span> </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
              </div>

<div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable mx-auto" data-rowposition="2" data-rowsort="1">
  <div style="row margin: auto;width: 100%;display: flex;justify-content: center;" >
    <div style="width: 330px;" class="mt-4 ml-auto ml-1">
      <input style="min-width: 252px;width: 100%;" id="datetime" class="date form-control form-control-sm mb-2" type="text" />
    </div>
    <div class="mt-4 col-md-2 ml-auto mr-1">
      <select style="min-width: 85px;" class=" custom-select custom-select-sm form-control form-control-sm" name="group_by" id="group_by">
        <option value="total" selected>Total</option>
        <option value="month">Month</option>
        <option value="quarter">Quarter</option>
        <option value="week">Week</option>
        <option value="day">Day</option>
        <option value="hour">Hour</option>
      </select>
    </div>
  </div>
  <div id="graphs"></div>
 
</div>

<div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable" data-rowposition="3" data-rowsort="1">
<div class="w-100 mt-3 mb-3 mx-auto">

  <div class="float-right text-center">
  <input style="width: 330px;"  class="date form-control-sm mb-2" type="text" name="datetimes" />
    <select style="width: 264px;font-size: 14px;" class="custom-select custom-select-sm form-control form-control-sm  mb-1 " id="serviceType">
        <option value="">Choose Service Type</option>
        <?php foreach ($service_types as $service_type): ?>
        <option id="<?php echo $service_type['id']; ?>" value="<?php echo $service_type['type']; ?>"><?php echo ucfirst($service_type['type']); ?></option>
        <?php endforeach;?>
    </select>
    </div>
</div>

<div class="w-100 mt-3 table-responsive">
  <table id="report" class="table table-striped table-bordered" cellspacing="0" width="100%">
 
  <tfoot>
        <tr>
            <th colspan="2" style="text-align:center">Total:</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
  </table>
  <div id="tbl_data">
      
  </div>

</div>
<table style="display: none;" id="total-percentage" class="table table-striped table-bordered mt-3" cellspacing="0" width="100%">

</table>
</div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.table2excel.js"></script>

<script type="text/javascript">
$(function() {
    var getTodayDate = new Date();
      var month = getTodayDate.getMonth()+1;
      var day = getTodayDate.getDate();
      var todayDate = getTodayDate.getFullYear() + '-' +
      (month<10 ? '0' : '') + month + '-' +
      (day<10 ? '0' : '') + day;
        $('#datetime').daterangepicker({
          timePicker: true,
          timePicker24Hour: true,
          startDate: todayDate+' 00:00:00',
          locale: {
            format: 'YYYY-MM-DD HH:mm:ss'
          },
          ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
           }
        },
        function(start, end, label) {
        let min_fulldate = start._d;
        let min_month = min_fulldate.getMonth()+1;
        let min_day = min_fulldate.getDate();
        let min_year = min_fulldate.getFullYear();
        var min_time = addZero(min_fulldate.getHours()) + ':' + addZero(min_fulldate.getMinutes()) + ':' + addZero(min_fulldate.getSeconds());
        
        let max_fulldate = end._d;
        let max_month = max_fulldate.getMonth()+1;
        let max_day = max_fulldate.getDate();
        let max_year = max_fulldate.getFullYear();
        var max_time = addZero(max_fulldate.getHours()) + ':' + addZero(max_fulldate.getMinutes()) + ':' + addZero(max_fulldate.getSeconds());

        var min = min_year + '-' + min_month + '-' + min_day + ' ' + min_time;
        var max = max_year + '-' + max_month + '-' + max_day + ' ' + max_time;
        var selected = $('#group_by option:selected').val();

        $.ajax({
            method: "POST",
            url: "<?php echo base_url() ;?>businessreport/get_graphs",
            data: {min:"'"+min+"'",max:"'"+max+"'",selected: selected},
            success: function(data){
                $("#graphs").html(JSON.parse(data.replaceAll("btnBack", "fade")));
                //$(".panel-heading").hide();
            }
        });
    });
  });

  $(document).ready( function () {
        var sort = '';
        $.ajax({
            url: "<?php echo base_url(); ?>businessreport/sortedWidgets",
            method: "GET",
            dataType: "JSON",
            success: function(data){
                sort = data['sort'];
                row_sort = data['row_sort'];
            },
            async:false
        });
        sort = sort.split(',').reverse();
        row_sort = row_sort.split(',').reverse();
        
        $("div[data-position]").each(function(index,value){
            
            for(var i = 0; i < sort.length; i++){
                if ($(this).data('position') == sort[i]){
                    $(this).attr( "data-sort", i );
                }

            }
            
        });
        $(".row-sort").each(function(index,value){
            for(var i = 0; i < row_sort.length; i++){
                if ($(this).data('rowposition') == row_sort[i]){
                    $(this).attr( "data-rowsort", i );
                }
            }
            
        });


        setTimeout(function(){ 
            $('#sortable .col-md-3').sort(function(a, b) {
                return $(b).data('sort') - $(a).data('sort');
            }).appendTo('#sortable');
        }, 0);

        setTimeout(function(){ 
            $('.main-content-inner .row-sort').sort(function(a, b) {
                return $(b).data('rowsort') - $(a).data('rowsort');
            }).appendTo('.main-content-inner');
        }, 0);
      $('.main-content-inner').css('visibility', 'visible');
      $('#sortable').css('visibility', 'visible');
      var getTodayDate = new Date();
      var month = getTodayDate.getMonth()+1;
      var day = getTodayDate.getDate();
      var todayDate = getTodayDate.getFullYear() + '-' +
      (month<10 ? '0' : '') + month + '-' +
      (day<10 ? '0' : '') + day;

      $(function() {
        $('input[name="datetimes"]').daterangepicker({
          timePicker: true,
          timePicker24Hour: true,
          startDate: todayDate+' 00:00:00',
          locale: {
            format: 'YYYY-MM-DD HH:mm:ss'
          },
          ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
           }
        });
      });

      let full_timestamp = $('#datetime').val();
      var selected = $('#group_by option:selected').val();
      var date = full_timestamp.split(" - ");
      var min = date[0];
      var max = date[1];
      $.ajax({
        method: "POST",
        url: "<?php echo base_url() ;?>businessreport/get_graphs",
        data: {min:"'"+min+"'",max:"'"+max+"'",selected:selected},
        success: function(data){
          $("#graphs").html(JSON.parse(data.replaceAll("btnBack", "hidden")));
          }
        });
        
        $('select#group_by').on('change', function() {
          let full_timestamp = $('#datetime').val();
          var selected = this.value;
          var date = full_timestamp.split(" - ");
          var min = date[0];
          var max = date[1];
          $.ajax({
            method: "POST",
            url: "<?php echo base_url() ;?>businessreport/get_graphs",
            data: {min:"'"+min+"'",max:"'"+max+"'",selected:selected},
            success: function(data){
              $("#graphs").html(JSON.parse(data.replaceAll("btnBack", "hidden")));
            }
          });
        });


      var table = $('#report').DataTable({
        processing: true,
        colReorder: true,
        fixedHeader: true,
        deferRender: true,
        scroller: true,
        lengthMenu: [[5, 10, 20, 50, 100, 200, 500, -1], [5, 10, 20, 50, 100, 200, 500, 'All']],
        pageLength: 5,
        dom: 'Blfrtip',
        buttons: [  {
            extend: 'excelHtml5',
            autoFilter: true,
            footer: true,
            sheetName: 'Exported data'
        },
        {
          text: 'Export All Table as Excel',
          className: "btn btn-primary mb-3 ml-1",
          action: function ( e, dt, node, config ) {
            let tbl_datas = table.rows({ search: 'applied'}).data();
        var html = '<table>';
        html += '<thead>';
        html += '<tr>';
        html += '<th>Order ID</th>';
        html += '<th>Product Name</th>';
        html += '<th>Product VAT</th>';
        html += '<th>Price</th>';
        html += '<th>Quantity</th>';
        html += '<th>EXVAT</th>';
        html += '<th>VAT</th>';
        html += '</tr>';
        html += '</thead>';
        var productsVat = [];
        $.each(tbl_datas, function( index, tbl_data ) {

          html += '<tbody>';
          $.each(tbl_data, function( index, value ) {
            if(index != 'child'){
            } else {
              $.each(value, function( index, val ) {
                let len = value.length - 1;
                if(productsVat[String(val.productVat)] !== undefined){
                  productsVat[String(val.productVat)][0] = parseFloat(productsVat[String(val.productVat)][0]) + parseFloat(val.EXVAT);
                  productsVat[String(val.productVat)][1] = parseFloat(productsVat[String(val.productVat)][1]) + parseFloat(val.VAT);
                } else {
                  productsVat[String(val.productVat)] = [];
                  productsVat[String(val.productVat)][0] = parseFloat(val.EXVAT);
                  productsVat[String(val.productVat)][1] = parseFloat(val.VAT);
                }
                html += '<tr>';
                  html += '<td>' + val.order_id + '</td>';
                  html += '<td>' + val.productName + '</td>' ;
                  html += '<td>' + num_percentage(val.productVat) + '</td>' ;
                  html += '<td>' + round_up(val.price) + '</td>' ;
                  html += '<td>' + val.quantity + '</td>' ;
                  html += '<td>' + round_up(val.EXVAT) + '</td>' ;
                  html += '<td>' + round_up(val.VAT) + '</td>';
                html += '</tr>';
                
                //console.log(val);
                //var array_values = Object.keys(val).map(i => val[i]);
                //console.log(array_values.length);
                
                
              });
            }
          });
          html += '</tbody>';
          
        });
        html += '<tfoot>';
        for (var key in productsVat) {
        //console.log("key " + key + " has value " + productsVat[key][0]);
        html += '<tr>' +
					'<td class="text-right" colspan="5"><b>Total for ' + num_percentage(key) + '</b></td>' +
					'<td>' + productsVat[key][0].toFixed(2) + '</td>' +
          '<td>' + productsVat[key][1].toFixed(2) + '</td>' +
					// '<td>' + val.AMOUNT + '</td>' +
			    '</tr>';
        }
        html += '</tfoot>';
        html += '</table>';
        
        $(html).table2excel({
							exclude: ".noExl",
							name: "Excel Document Name",
							filename: "TIQS Business Reports Full.xls",
							fileext: ".xls",
							exclude_img: true,
							exclude_links: true,
							exclude_inputs: true
						});

          }
        } ],
        ajax: {
          type: 'get',
          url: '<?php echo base_url("businessreport/get_report"); ?>',
          dataSrc: '',
        },
        footerCallback: function( tfoot, data, start, end, display ) {
           var api = this.api(), data;
          //Totals For Current Page

          let pageAmountTotalData = api.column( 2, { page: 'current'}  ).cache('search');
          let pageAmountTotal = pageAmountTotalData.length ? 
          pageAmountTotalData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let pageServiceFeeData = api.column( 5,  { page: 'current'} ).cache('search');
          let pageServiceFeeTotal = pageServiceFeeData.length ? 
          pageServiceFeeData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let pageVatServiceData = api.column( 7,  { page: 'current'} ).cache('search');
          let pageVatServiceTotal = pageVatServiceData.length ? 
          pageVatServiceData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let pageExvatServiceData = api.column( 8,  { page: 'current'} ).cache('search');
          let pageExvatServiceTotal = pageExvatServiceData.length ? 
          pageExvatServiceData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let pageWaiterTipData = api.column( 9, { page: 'current'}  ).cache('search');
          let pageWaiterTipTotal = pageWaiterTipData.length ? 
          pageWaiterTipData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let pageAmountData = api.column( 10, { page: 'current'}  ).cache('search');
          let pageAmount = pageAmountData.length ? 
          pageAmountData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;
          let pageExvatData = api.column( 11, { page: 'current'} ).cache('search');
          let pageExvatTotal = pageExvatData.length ? 
            pageExvatData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;
          let pageVatData = api.column( 12, { page: 'current'} ).cache('search');
          let pageVatTotal = pageVatData.length ? 
            pageVatData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;


          //Totals For All Pages

          let amountTotalData = api.column( 2,{ search: 'applied' } ).cache('search');
          let amountTotal = amountTotalData.length ? 
          amountTotalData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let vatServiceData = api.column( 7,  { search: 'applied' } ).cache('search');
          let vatServiceTotal = vatServiceData.length ? 
          vatServiceData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let exvatServiceData = api.column( 8, { search: 'applied' }).cache('search');
          let exvatServiceTotal = exvatServiceData.length ? 
          exvatServiceData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let waiterTipData = api.column( 9,{ search: 'applied' } ).cache('search');
          let waiterTipTotal = waiterTipData.length ? 
          waiterTipData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let amountData = api.column( 10,{ search: 'applied' } ).cache('search');
          let amount = amountData.length ? 
          amountData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let exvatData = api.column( 11,{ search: 'applied' } ).cache('search');
          let exvatTotal = exvatData.length ? 
            exvatData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0; 

          let vatData = api.column( 12, { search: 'applied' }).cache('search');
          let vatTotal = vatData.length ? 
            vatData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let serviceFeeData = api.column( 5,  { search: 'applied' } ).cache('search');
          let serviceFeeTotal = serviceFeeData.length ? 
          serviceFeeData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

           $(tfoot).find('th').eq(1).html(round_up(pageAmountTotal)+'('+round_up(amountTotal)+')');
           $(tfoot).find('th').eq(2).html('-');
           $(tfoot).find('th').eq(3).html('-');
           $(tfoot).find('th').eq(4).html(round_up(pageServiceFeeTotal)+'('+round_up(serviceFeeTotal)+')');
           $(tfoot).find('th').eq(5).html('-');
           $(tfoot).find('th').eq(6).html(round_up(pageVatServiceTotal)+'('+round_up(vatServiceTotal)+')');
           $(tfoot).find('th').eq(7).html(round_up(pageExvatServiceTotal)+'('+round_up(exvatServiceTotal)+')');
           $(tfoot).find('th').eq(8).html(round_up(pageWaiterTipTotal)+'('+round_up(waiterTipTotal)+')');
           $(tfoot).find('th').eq(9).html(round_up(pageAmount)+'('+round_up(amount)+')');
           $(tfoot).find('th').eq(10).html(round_up(pageExvatTotal)+'('+round_up(exvatTotal)+')');
           $(tfoot).find('th').eq(11).html(round_up(pageVatTotal)+'('+round_up(vatTotal)+')');
           $('.buttons-excel').addClass('btn').addClass('btn-success').addClass('mb-3');
           $('.buttons-excel').text('Export as Excel');
          
        },
        rowId: function(a) {
          return 'row_id_' + a.order_id;
        },
        initComplete: function(settings, json) {
				  child_data = json;
        },
        columns:[
          {
          title: '&nbsp',
					className: 'details-control',
					orderable: false,
					data: null,
          "render": function (data, type, row) {
            return '';
          }
				},
        {
          title: 'Order ID',
          data: 'order_id'
        },
        {
          title: 'Total Amount',
          data: null,
          "render": function (data, type, row) {
            let amount = parseFloat(data.total_AMOUNT);
            return amount.toFixed(2);
          }
        },
        {
          title: 'Quantity',
          data: 'quantity'
        },
        {
          title: 'Service Type',
          data: 'service_type'
        },
        {
          title: 'Service Fee',
          data: null,
          "render": function (data, type, row) {
            let serviceFee = parseFloat(data.serviceFee);
            return serviceFee.toFixed(2);
          }
        },
        {
          title: 'Service Fee Tax',
          data: null,
          "render": function (data, type, row) {
            let serviceFeeTax = parseInt(data.serviceFeeTax)+"%";
            return serviceFeeTax;
          }
        },
        {
          title: 'Service VAT',
          data: null,
          "render": function (data, type, row) {
            let vatService = parseFloat(data.VATSERVICE);
            return vatService.toFixed(2);
          }
        },
        {
          title: 'Service EXVAT',
          data: null,
          "render": function (data, type, row) {
            let exvatService = parseFloat(data.EXVATSERVICE);
            return exvatService.toFixed(2);
          }
        },
        {
          title: 'Waiter Tip',
          data: null,
          "render": function (data, type, row) {
            let waiterTip = parseFloat(data.waiterTip);
            return waiterTip.toFixed(2);
          }
        },
        {
          title: 'AMOUNT',
          data: null,
          "render": function (data, type, row) {
            let amount = parseFloat(data.AMOUNT);
            return amount.toFixed(2);
          }
        },
        {
          title: 'EXVAT',
          data: null,
          "render": function (data, type, row) {
            let exvat = parseFloat(data.EXVAT);
            return exvat.toFixed(2);
          }
        },
        {
          title: 'VAT',
          data: null,
          "render": function (data, type, row) {
            let vat = parseFloat(data.VAT);
            return vat.toFixed(2);
          }
        },
        {
          title: 'Date',
          data: 'order_date'
        }
        ],
      });



function format(d) {
			var row = '<tr>' +
				'<td><strong>Product Name</strong></td>' +
				'<td><strong>Product VAT</strong></td>' +
				'<td><strong>Price</strong></td>' +
				'<td><strong>Quantity</strong></td>' +
				'<td><strong>Ex VAT</strong></td>' +
				'<td><strong>VAT</strong></td>' +
				// '<td><strong>Amount</strong></td>' +

				'</tr>';
      var productsVat = [];
			$.each(d.child, function(indexInArray, val) {
        //console.log(indexInArray);
        
        if(productsVat[String(val.productVat)] !== undefined){
          productsVat[String(val.productVat)][0] = parseFloat(productsVat[String(val.productVat)][0]) + parseFloat(val.EXVAT);
          productsVat[String(val.productVat)][1] = parseFloat(productsVat[String(val.productVat)][1]) + parseFloat(val.VAT);
        } else {
          productsVat[String(val.productVat)] = [];
          productsVat[String(val.productVat)][0] = parseFloat(val.EXVAT);
          productsVat[String(val.productVat)][1] = parseFloat(val.VAT);

        }
      
				row += '<tr>' +
					'<td>' + val.productName + '</td>' +
					'<td>' + num_percentage(val.productVat) + '</td>' +
					'<td>' + round_up(val.price) + '</td>' +
					'<td>' + val.quantity + '</td>' +
					'<td>' + round_up(val.EXVAT) + '</td>' +
					'<td>' + round_up(val.VAT) + '</td>' +
					// '<td>' + val.AMOUNT + '</td>' +
					'</tr>';
			});

      for (var key in productsVat) {
        console.log("key " + key + " has value " + productsVat[key][0]);
        row += '<tr>' +
					'<td class="text-right" colspan="4"><b>Total for ' + num_percentage(key) + '</b></td>' +
					'<td>' + productsVat[key][0].toFixed(2) + '</td>' +
          '<td>' + productsVat[key][1].toFixed(2) + '</td>' +
					// '<td>' + val.AMOUNT + '</td>' +
			'</tr>';
      }
      $.each(productsVat, function(index, val) {
        console.log(index);
      row += '<tr>' +
					'<td colspan="2">' + index + '</td>' +
					'<td colspan="4">' + val + '</td>' +
					// '<td>' + val.AMOUNT + '</td>' +
			'</tr>';
      });
      console.log(productsVat);
      
			if(d.export_ID==null){
				button = '<button type="button" onclick="" class="btn btn-warning btn-refund btn-sm export-'+d.order_id+'">REFUND</button>';
			}else{
				button = '<button type="button" onclick="" class="btn btn-warning btn-refund btn-sm export-'+d.order_id+'">REFUND</button>';
			}
			var child_table =
				'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%;background:#d0a17a91;" class="table table-bordered table-hover" >' + row +
				'<tr><td><strong>Action</strong></td><td>'+button+'</td></tr>'
				'</table>';

			return child_table;
		}

		// Add event listener for opening and closing details
		$('#report tbody').on('click', 'td', function() {
			var tr = $(this).closest('tr');
			var row = table.row(tr);
			if (row.child.isShown()) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
				$('.DTFC_LeftHeadWrapper').show();
				$('.DTFC_LeftBodyWrapper').show();
			} else {
				// Open this row
				row.child(format(row.data())).show();
				tr.addClass('shown');
				$('.DTFC_LeftHeadWrapper').hide();
				$('.DTFC_LeftBodyWrapper').hide();
			}
		});

	
      var getTodayDate = new Date();
      var month = getTodayDate.getMonth()+1;
      var day = getTodayDate.getDate();
      var todayDate = getTodayDate.getFullYear() + '-' +
      (month<10 ? '0' : '') + month + '-' +
      (day<10 ? '0' : '') + day;

    
      table.on( 'search.dt', function () {
        if(table['context'][0]['aiDisplay'].length == 0){
          //console.log(table.rows({ search: 'applied'}).data());
          //$('#report_length').hide();
          $("#total-percentage").hide();
        } else {
          //$('#report_length').show();
        let tbl_datas = table.rows({ search: 'applied'}).data();
        var productsVat = [];
        var html = '';
        $.each(tbl_datas, function( index, tbl_data ) {

          $.each(tbl_data, function( index, value ) {
            if(index != 'child'){
            } else {
              $.each(value, function( index, val ) {
                let len = value.length - 1;
                if(productsVat[String(val.productVat)] !== undefined){
                  productsVat[String(val.productVat)][0] = parseFloat(productsVat[String(val.productVat)][0]) + parseFloat(val.EXVAT);
                  productsVat[String(val.productVat)][1] = parseFloat(productsVat[String(val.productVat)][1]) + parseFloat(val.VAT);
                } else {
                  productsVat[String(val.productVat)] = [];
                  productsVat[String(val.productVat)][0] = parseFloat(val.EXVAT);
                  productsVat[String(val.productVat)][1] = parseFloat(val.VAT);
                }
                
                
              });
            }
          });
          
        });
        var totalExvat = 0;
        var totalVat = 0;
        for (var key in productsVat) {
        //console.log("key " + key + " has value " + productsVat[key][0]);
        html += '<tr id="tr-totals">' +
					'<td class="text-right" colspan="5"><b>Total for ' + num_percentage(key) + '</b></td>' +
					'<td>' + productsVat[key][0].toFixed(2) + '</td>' +
          '<td>' + productsVat[key][1].toFixed(2) + '</td>' +
					// '<td>' + val.AMOUNT + '</td>' +
			    '</tr>';
          totalExvat = totalExvat + parseFloat(productsVat[key][0]);
          totalVat = totalVat + parseFloat(productsVat[key][1]);
        }
        $("#total-percentage").show();
        $("#total-percentage").empty();
        $("#total-percentage").html(html);

        }
      });
      

      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          let full_timestamp = $('input[name="datetimes"]').val();
          var date = full_timestamp.split(" - ");
          var min = new Date(date[0]);
          var max = new Date(date[1]);
          var startDate = new Date(data[13]);
          if (min == '' && max == '') { min = todayDate; }
          if (min == '' && startDate <= max) { return true;}
          if(max == '' && startDate >= min) {return true;}
          if (startDate <= max && startDate >= min) { return true; }
            return false;
        });
        
        $('input[name="datetimes"]').change(function () {
          let full_timestamp = $('input[name="datetimes"]').val();
          var date = full_timestamp.split(" - ");
          var min = date[0];
          var max = date[1];
          $.post("<?php echo base_url('businessreport/get_timestamp_totals');?>",{min:"'"+min+"'",max:"'"+max+"'"}, function(data){
            let totals = JSON.parse(data);
            let total = totals['total'];
            let local = totals['local'];
            let delivery = totals['delivery'];
            let pickup = totals['pickup'];
            $('#total').text( total_number(total) );
            $('#local').text( total_number(local) );
            $('#delivery').text( total_number(delivery) );
            $('#pickup').text( total_number(pickup) );
          });

          $.post("<?php echo base_url('businessreport/get_timestamp_orders');?>",{min:"'"+min+"'",max:"'"+max+"'"}, function(data){
            let orders = JSON.parse(data);
            $('#orders').text( orders );
          });

          table.draw();
        });
       

      $('#serviceType').change(function() {
        var category = this.value;
        table
        .columns( 4 )
        .search( category )
        .draw();
      });

});
$(function () {
        $('.row').sortable({
            connectWith: ".row",
            items: ".col-md-3",
            update: function (event, ui) {
                var myTable = $(this).index();
                var positions = [];
                $("div[data-position]").each(function(index,value){
                    var data = $(this).data('position');
                    positions.push(data);
                });
                positions = positions.toString();
                $.post('<?php echo base_url(); ?>businessreport/sortWidgets', {sort: positions});
                setTimeout(function(){
                    
                    //toastr["success"]("Widget positions are updated successfully!");
                }, 0);
            }
        });
});

$(function () {
  $('.main-content-inner').sortable({
    connectWith: ".main-content-inner",
    items: ".row-sort",
    update: function (event, ui) {
      var myTable = $(this).index();
      var positions = [];
      $("div[data-rowposition]").each(function(index,value){
        var data = $(this).data('rowposition');
        positions.push(data);
      });

      positions = positions.toString();
      $.post('<?php echo base_url(); ?>businessreport/sortWidgets', {row_sort: positions});
      }
  });
});

    function round_up(val){
      val = parseFloat(val);
      return val.toFixed(2);
	}

function total_number(number){
  if(number==0){
   return '€ '+number;
  }
  return '€ '+number.toFixed(2);
}

function num_percentage(number){
  number = parseInt(number*100);
  number = number/100;
  return number + "%";
}

function addZero(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
}
</script>
