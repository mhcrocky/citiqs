<div style="visibility: hidden;" class="main-content-inner ui-sortable">
<!--
    <div class="sales-report-area mt-5 mb-5 row-sort ui-sortable" data-rowposition="1" data-rowsort="1">
        <div id="sortable" style="visibility: hidden;" class="row ui-sortable">
            <div class="col-md-3 ui-sortable mb-3" data-position="1" data-sort="1">
                <div style="height:160px;" class="single-report mb-xs-30">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="2" data-sort="1">
                <div style="height:160px;" class="single-report mb-xs-30">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="3" data-sort="1">
                <div style="height:160px;" class="single-report mb-xs-30">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="4" data-sort="1">
                <div style="height:160px;" class="single-report">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="5" data-sort="1">
                <div style="height:160px;" class="single-report mb-xs-30">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="6" data-sort="1">
                <div style="height:160px;" class="single-report mb-xs-30">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="7" data-sort="1">
                <div style="height:160px;" class="single-report mb-xs-30">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="8" data-sort="1">
                <div style="height:160px;" class="single-report">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="9" data-sort="1">
                <div style="height:160px;" class="single-report mb-xs-30">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="10" data-sort="1">
                <div style="height:160px;" class="single-report mb-xs-30">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="11" data-sort="1">
                <div style="height:160px;" class="single-report mb-xs-30">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="12" data-sort="1">
                <div style="height:160px;" class="single-report">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="13" data-sort="1">
                <div style="height:160px;" class="single-report mb-xs-30">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="14" data-sort="1">
                <div style="height:160px;" class="single-report mb-xs-30">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="15" data-sort="1">
                <div style="height:160px;" class="single-report mb-xs-30">
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
            <div class="col-md-3 ui-sortable mb-3" data-position="16" data-sort="1">
                <div style="height:160px;" class="single-report">
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

    <div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable mx-auto" data-rowposition="2" data-rowsort="1">
        <div style="row margin: auto;width: 100%;display: flex;justify-content: center;">
            <div style="width: 330px;" class="mt-4 ml-auto ml-1">
                <input style="min-width: 252px;width: 100%;" id="datetime"
                    class="date form-control form-control-sm mb-2" type="text" />
            </div>
            <div class="mt-4 col-md-2 ml-auto mr-1">
                <select style="min-width: 85px;" class=" custom-select custom-select-sm form-control form-control-sm"
                    name="group_by" id="group_by">
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
<script src="<?php echo base_url(); ?>assets/js/query-builder.standalone.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/dashboard.js"></script>