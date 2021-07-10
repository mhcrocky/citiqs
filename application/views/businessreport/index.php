<div class="main-content-inner ui-sortable">
    <?php /*
    <!--
    <div class="sales-report-area mt-5 mb-5 row-sort ui-sortable" data-rowposition="1" data-rowsort="1">
        <div id="sortable" style="visibility: hidden;" class="row ui-sortable">
            <div class="col-md-3 col-custom ui-sortable mb-3" data-position="1" data-sort="1">
                <div style="height:140px;" class="single-report mb-xs-30">
                    <div style="min-height:500px;position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
                        class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand"
                            style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink"
                            style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                        </div>
                    </div>
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div style="background: #496083;" class="icon">&nbsp</div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="2" data-sort="1">
    <div style="height:140px;" class="single-report mb-xs-30">
        <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="3" data-sort="1">
    <div style="height:140px;" class="single-report mb-xs-30">
        <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="4" data-sort="1">
    <div style="height:140px;" class="single-report">
        <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="5" data-sort="1">
    <div style="height:140px;" class="single-report mb-xs-30">
        <div style="min-height:500px;position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
        <div class="s-report-inner pr--20 pt--30 mb-3">
            <div style="background: #496083;" class="icon">&nbsp</div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="6" data-sort="1">
    <div style="height:140px;" class="single-report mb-xs-30">
        <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="7" data-sort="1">
    <div style="height:140px;" class="single-report mb-xs-30">
        <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="8" data-sort="1">
    <div style="height:140px;" class="single-report">
        <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="9" data-sort="1">
    <div style="height:140px;" class="single-report mb-xs-30">
        <div style="min-height:500px;position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
        <div class="s-report-inner pr--20 pt--30 mb-3">
            <div style="background: #496083;" class="icon">&nbsp</div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="10" data-sort="1">
    <div style="height:140px;" class="single-report mb-xs-30">
        <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="11" data-sort="1">
    <div style="height:140px;" class="single-report mb-xs-30">
        <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="12" data-sort="1">
    <div style="height:140px;" class="single-report">
        <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="13" data-sort="1">
    <div style="height:140px;" class="single-report mb-xs-30">
        <div style="min-height:500px;position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
        <div class="s-report-inner pr--20 pt--30 mb-3">
            <div style="background: #496083;" class="icon">&nbsp</div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="14" data-sort="1">
    <div style="height:140px;" class="single-report mb-xs-30">
        <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="15" data-sort="1">
    <div style="height:140px;" class="single-report mb-xs-30">
        <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
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
<div class="col-md-3 col-custom ui-sortable mb-3" data-position="16" data-sort="1">
    <div style="height:140px;" class="single-report">
        <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
            class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
            </div>
        </div>
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
-->
<?php */
 ?>


<?php /*
<div style="" class="w-100 mt-4 row-sort ui-sortable mx-auto" data-rowposition="2" data-rowsort="1">
    <div style="flex-wrap: unset;" class="row mx-auto text-center">
        <div class="col-md-4 mt-4 ml-auto ml-1">
            <input style="min-width: 230px;width: 100%;" id="datetimegraph"
                class="date form-control form-control-sm mb-2" type="text" />
        </div>
        <div style="width: 87px;" class="mt-4 mr-1 text-center">
            <select style="min-width: 85px;" class=" custom-select custom-select-sm form-control form-control-sm"
                name="group_by" id="group_by">
                <option value="total" selected><?php echo $this->language->tLine('Total'); ?></option>
                <option value="month"><?php echo $this->language->tLine('Month'); ?></option>
                <option value="quarter"><?php echo $this->language->tLine('Quarter'); ?></option>
                <option value="week"><?php echo $this->language->tLine('Week'); ?></option>
                <option value="day"><?php echo $this->language->tLine('Day'); ?></option>
                <option value="hour"><?php echo $this->language->tLine('Hour'); ?></option>
            </select>
        </div>
    </div>
    <div id="graphs"></div>

    <div class="sales-report-area mt-5 mb-5 row-sort ui-sortable" data-rowposition="1" data-rowsort="1">
        <input style="min-width: 230px;max-width: 300px;" id="datetime"
            class="date w-100 form-control form-control-sm mb-4 ml-auto" type="text" />
        <div id="sortable" class="row ui-sortable">

            <div class="col-md-3 col-custom ui-sortable mb-3" data-position="1" data-sort="1">
                <div style="border-left: 10px solid #3366cc !important;height:140px;" class="single-report mb-xs-30">
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div class="s-report-title d-flex justify-content-between">
                            <h4 class="header-title mb-0"><?php echo $this->language->tLine('Total'); ?></option>
                            </h4>
                            <p><?php echo $this->language->tLine('LOCAL'); ?></p>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <h2>€ <span id="local"></span></h2>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-custom ui-sortable mb-3" data-position="2" data-sort="1">
                <div style="border-left: 10px solid #dc3912 !important;height:140px;" class="single-report mb-xs-30">
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div class="s-report-title d-flex justify-content-between">
                            <h4 class="header-title mb-0"><?php echo $this->language->tLine('Total'); ?></option>
                            </h4>
                            <p><?php echo $this->language->tLine('PICKUP'); ?></p>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <h2>€ <span id="pickup"></span></h2>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-custom ui-sortable mb-3" data-position="3" data-sort="1">
                <div style="border-left: 10px solid #ff9900 !important;height:140px;" class="single-report mb-xs-30">
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div class="s-report-title d-flex justify-content-between">
                            <h4 class="header-title mb-0"><?php echo $this->language->tLine('Total'); ?></h4>
                            <p><?php echo $this->language->tLine('DELIVERY'); ?></p>

                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <h2>€ <span id="delivery"></span></h2>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-custom ui-sortable mb-3" data-position="4" data-sort="1">
                <div style="border-left: 10px solid #6600cc !important;height:140px;" class="single-report mb-xs-30">
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div class="s-report-title d-flex justify-content-between">
                            <h4 class="header-title mb-0"><?php echo $this->language->tLine('Total'); ?></h4>
                            <p><?php echo $this->language->tLine('INVOICES'); ?></p>

                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <h2>€ <span id="invoice"></span></h2>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-custom ui-sortable mb-3" data-position="5" data-sort="1">
                <div style="border-left: 10px solid #375068 !important;height:140px;" class="single-report mb-xs-30">
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div class="s-report-title d-flex justify-content-between">
                            <h4 class="header-title mb-0"><?php echo $this->language->tLine('Total'); ?></h4>
                            <p><?php echo $this->language->tLine('TICKETS'); ?></p>

                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <h2><span id="tickets"></span></h2>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
 */ ?>

<?php foreach($event_orders as $key => $event_order): 
    $sold_tickets =  $event_order['booking_number']; 
    $total_amount = $event_order['amount'];
    unset($event_order['booking_number']);
    unset($event_order['amount']);
    ?>

	<div class="d-flex row w-100 mt-4 mx-auto row-sort ui-sortable" data-rowposition="3" data-rowsort="1">
		<div class="col-md-4 dash-card first b-purple">
			<div class="d-table">
				<div class="w-100 f-16 pr-2 pt-3 font-weight-bold d-table-cell">
					<span class="icon-c">
						<i class="fa fa-ticket" aria-hidden="true"></i>
					</span>
					Total tickets sold
				</div>
				<div class="f-16 pr-2 pt-3 font-weight-bold d-table-cell text-right">
					<?php echo $sold_tickets; ?>
				</div>
			</div>
			<div class="w-100 pt-25 mb-2 ticket-card ticket-info-card">
				<div style="width: 100%" id="firstChart_<?php echo $key; ?>" class="pie-chart"></div>
				<?php foreach($event_order as $ticket): ?>
				<div class="d-table">
					<div class="w-100 f-12 pr-2 d-table-cell">
						<?php echo $ticket['eventname']; ?> - <?php echo $ticket['ticketDescription']; ?>
					</div>
					<div class="f-12 pr-2 d-table-cell text-right">
						<?php echo $bookings_number[$ticket['id']]; ?>
					</div>
				</div>
				<?php endforeach; ?>

			</div>
		</div>

		<div class="col-md-4 dash-card b-red">
			<div class="d-table">
				<div class="w-100 f-16 pr-2 pt-3 font-weight-bold d-table-cell">
					<span style="display: inline-flex;flex-wrap: unset;" class="icon-c">
						<i class="gg-euro"></i>
					</span>
					Total amount
				</div>
				<div class="f-16 pr-2 pt-3 font-weight-bold d-table-cell text-right">
					€<?php echo number_format($total_amount, 2); ?>
				</div>
			</div>

			<div class="w-100 pt-25 mb-2 ticket-card ticket-info-card">
				<div style="width: 100%" id="secondChart_<?php echo $key; ?>" class="pie-chart"></div>
				<?php foreach($event_order as $ticket): ?>
				<div class="d-table">
					<div class="w-100 f-12 pr-2 d-table-cell">
						<?php echo $ticket['eventname']; ?> - <?php echo $ticket['ticketDescription']; ?>
					</div>
					<div class="f-12 pr-2 d-table-cell text-right">
						€<?php echo number_format($amounts[$ticket['id']], 2); ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>


		</div>
		<?php

		$total_male = 0;
		$total_female = 0;
		$tickets = $tickets_gender[$key];
		foreach($tickets as $ticket){
			$total_male += intval($ticket['male']);
			$total_female += intval($ticket['female']);
		}

		?>
		<div class="col-md-4 dash-card b-green">
			<div class="d-table">
				<div class="w-100 f-16 pr-2 pt-3 font-weight-bold d-table-cell">
					<span class="icon-c">
						<i class="fa fa-male" aria-hidden="true"></i>
					</span>
					Male
				</div>
				<div class="f-16 pr-2 pt-3 font-weight-bold d-table-cell text-right">
					<?php echo number_format(($total_male/$sold_tickets) * 100, 2); ?>%
				</div>
			</div>

			<div class="w-100 pt-25 mb-2 ticket-info-card">
				<div class="text-center "style="text-align:center">
					<img src="<?php echo $this->baseUrl; ?>assets/home/images/ageiconsmale.png" alt="tiqs" width="100" height="auto" />
				</div>
				<div style="height: 100px" class="w-100 d-flex justify-content-center align-items-center">
					AGE AVG: <?php echo isset($avg_age['male'][$key]) ? $avg_age['male'][$key] : '-'; ?>
				</div>
				<?php foreach($tickets as $ticket): ?>
				<div class="d-table">
					<div class="w-100 f-12 pr-2 d-table-cell">
						<?php echo $ticket['eventname']; ?> - <?php echo $ticket['ticketDescription']; ?>
					</div>

					<div class="f-12 pr-2 d-table-cell text-right">
						<?php echo intval($ticket['male']) ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>

		</div>


		<div class="col-md-4 dash-card last b-green">
			<div class="d-table">
				<div class="w-100 f-16 pr-2 pt-3 font-weight-bold d-table-cell">
					<span class="icon-c font-weight-bold">
						<i class="fa fa-female" aria-hidden="true"></i>
					</span>
					Female
				</div>
				<div class="f-16 pr-2 pt-3 font-weight-bold d-table-cell text-right">
					<?php echo number_format($total_female/$sold_tickets * 100, 2); ?>%
				</div>
			</div>

			<div class="w-100 pt-25 mb-2 ticket-info-card">
				<div class="text-center" style="text-align:center">
					<img src="<?php echo $this->baseUrl; ?>assets/home/images/agefemale.png" alt="tiqs" width="100" height="auto" />
				</div>
				<div style="height: 100px" class="w-100 d-flex justify-content-center align-items-center">
					AGE AVG: <?php echo isset($avg_age['female'][$key]) ? $avg_age['female'][$key] : '-'; ?>
					</div>
					<?php foreach($tickets as $ticket): ?>
					<div class="d-table">
						<div class="w-100 f-12 pr-2 d-table-cell">
							<?php echo $ticket['eventname']; ?> - <?php echo $ticket['ticketDescription']; ?>
						</div>

						<div class="f-12 pr-2 d-table-cell text-right">
							<?php echo intval($ticket['female']); ?>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
<!--			</div>-->
		</div>
	</div>

<?php endforeach; ?>
</div>

<script type="text/javascript">
window.onload = function() {

    google.load("visualization", "1.1", {

        packages: ["corechart"],

        callback: 'drawChart'

    });


};

$(document).ready(function(){
    var x = window.matchMedia("(max-width: 770px)");
    checkIfDisableSortable(x);
});



function drawChart() {

    var i = 0;
    var event_orders = '<?php echo (isset($tags) && is_array($tags)) ? json_encode($tags) : ''; ?>';
    //var tickets_gender = '<?php //echo is_array($gender_tags) ? json_encode($gender_tags) : ''; ?>';
    event_orders = (event_orders == '') ? '' : JSON.parse(event_orders);
    //tickets_gender = (tickets_gender == '') ? '' : JSON.parse(tickets_gender);

    if (typeof event_orders === 'object') {
        for (const [key1, tickets] of Object.entries(event_orders)) {
            var key = i;
            i++;

            var id = key1.replaceAll(' ', '');

            window['firstArr' + key] = [];
            window['secondArr' + key] = [];
            window['thirdArr' + key] = [];
            window['fourthArr' + key] = [];
            window['firstArr' + key].push(['Country', 'Popularity']);
            window['secondArr' + key].push(['Country', 'Popularity']);
            window['thirdArr' + key].push(['Country', 'Popularity']);
            window['fourthArr' + key].push(['Country', 'Popularity']);
            var firstTotal = 0;
            var secondTotal = 0;
            var thirdTotal = 0;
            var fourthTotal = 0;
            $.each(tickets, function(index, ticket) {
                if (!isNaN(ticket.booking_number)) {
                    firstTotal = firstTotal + parseFloat(ticket.booking_number);
                }

                if (!isNaN(ticket.amount)) {
                    secondTotal = secondTotal + parseFloat(ticket.amount);
                }





            });


            $.each(tickets, function(index, ticket) {
                if (!isNaN(ticket.booking_number)) {
                    let bookingTotal = parseFloat(parseFloat(ticket.booking_number) / firstTotal) * 100;
                    window['firstArr' + key].push([index, bookingTotal]);
                }

                if (!isNaN(ticket.amount)) {
                    let amountTotal = parseFloat(parseFloat(ticket.amount) / secondTotal) * 100;
                    window['secondArr' + key].push([index, amountTotal]);
                }

            });


            /*

            $.each(tickets_gender[key1], function(index, ticket) {

                thirdTotal = thirdTotal + ticket.male_tag;
                fourthTotal = fourthTotal + ticket.female_tag;

            });

            
            $.each(tickets_gender[key1], function(index, ticket) {
                
                    let maleTotal = parseFloat(parseFloat(ticket.male_tag) / thirdTotal) * 100;
                    let femaleTotal = parseFloat(parseFloat(ticket.female_tag) / fourthTotal) * 100;
                    window['thirdArr' + key].push([index, maleTotal]);
                    window['fourthArr' + key].push([index, femaleTotal]);
                

            });
            */


            window['data' + key] = google.visualization.arrayToDataTable(window['firstArr' + key]);


            var options = {

                pieHole: 0.4,

                title: '',

            };


            window['chart' + key] = new google.visualization.PieChart(document.getElementById('firstChart_' + id));

            window['chart' + key].draw(window['data' + key], options);

            window['secondData' + key] = google.visualization.arrayToDataTable(window['secondArr' + key]);

            window['secondChart' + key] = new google.visualization.PieChart(document.getElementById('secondChart_' +
                id));

            window['secondChart' + key].draw(window['secondData' + key], options);


            //third chart
            /*

            window['thirdData' + key] = google.visualization.arrayToDataTable(window['thirdArr' + key]);


            window['thirdChart' + key] = new google.visualization.PieChart(document.getElementById('thirdChart_' + id));

            window['thirdChart' + key].draw(window['thirdData' + key], options);

            //fourth chart

            window['fourthData' + key] = google.visualization.arrayToDataTable(window['fourthArr' + key]);


            window['fourthChart' + key] = new google.visualization.PieChart(document.getElementById('fourthChart_' +
                id));

            window['fourthChart' + key].draw(window['fourthData' + key], options);

            */

        }
    }




}

function checkIfDisableSortable(x) {
  if (x.matches) { // If media query matches
    $('.main-content-inner').sortable("disable");
    $('.row').sortable("disable");
  }

  return ;
}


</script>
