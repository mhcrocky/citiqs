<div class="main-content-inner ui-sortable">
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

    <div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable mx-auto" data-rowposition="2" data-rowsort="1">
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
                    <div style="border-left: 10px solid #3366cc !important;height:140px;"
                        class="single-report mb-xs-30">
                        <div class="s-report-inner pr--20 pt--30 mb-3">
                            <div class="s-report-title d-flex justify-content-between">
								<h4 class="header-title mb-0"><?php echo $this->language->tLine('Total'); ?></option></h4>
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
                    <div style="border-left: 10px solid #dc3912 !important;height:140px;"
                        class="single-report mb-xs-30">
                        <div class="s-report-inner pr--20 pt--30 mb-3">
                            <div class="s-report-title d-flex justify-content-between">
                                <h4 class="header-title mb-0"><?php echo $this->language->tLine('Total'); ?></option></h4>
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
                    <div style="border-left: 10px solid #ff9900 !important;height:140px;"
                        class="single-report mb-xs-30">
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
                    <div style="border-left: 10px solid #6600cc !important;height:140px;"
                        class="single-report mb-xs-30">
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
                    <div style="border-left: 10px solid #375068 !important;height:140px;"
                        class="single-report mb-xs-30">
                        <div class="s-report-inner pr--20 pt--30 mb-3">
                            <div class="s-report-title d-flex justify-content-between">
                                <h4 class="header-title mb-0"><?php echo $this->language->tLine('Total'); ?></h4>
								<p><?php echo $this->language->tLine('TICKETS'); ?></p>

                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <h2>€ <span id="tickets"></span></h2>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
