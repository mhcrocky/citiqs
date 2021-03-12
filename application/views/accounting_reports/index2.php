<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

	.btn-refund {
		background: #ff704d !important;
		color: #fff !important;
		border-color: #ff5c33 !important;
	}

	td.details-control {
		background: url("<?php echo base_url('assets/details_open.png') ?>") no-repeat center center;
		cursor: pointer;
	}

	tr.shown td.details-control {
		background: url("<?php echo base_url('assets/details_close.png') ?>") no-repeat center center;
	}

	#report td,
	#report th {
		/* padding: 0.15rem; */
		vertical-align: center !important;
	}
</style>
<div style="visibility: hidden;" class="main-content-inner ui-sortable">
	<div class="sales-report-area mt-5 mb-5 row-sort ui-sortable" data-rowposition="1" data-rowsort="1">
		<div id="sortable" style="visibility: hidden;" class="row ui-sortable">
			<div class="col-md-3 ui-sortable mb-3" data-position="1" data-sort="1">
				<div style="height:160px;" class="single-report mb-xs-30">
					<div style="min-height:500px;position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<div class="s-report-inner pr--20 pt--30 mb-3">
						<div style="background: #0066ff;" class="icon">&nbsp</div>
						<div class="s-report-title d-flex justify-content-between">
							<h4 class="header-title mb-0">Total</h4>
							<p>TODAY</p>
						</div>
						<div class="d-flex justify-content-between pb-2">
							<h2>€ <?php echo intval($day_total['total'] * 100) / 100; ?></h2>
							<span></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 ui-sortable mb-3" data-position="2" data-sort="1">
				<div style="height:160px;" class="single-report mb-xs-30">
					<div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<div class="s-report-inner pr--20 pt--30 mb-3">
						<div style="background:  #009933;" class="icon">&nbsp</div>
						<div class="s-report-title d-flex justify-content-between">
							<h4 class="header-title mb-0">Local</h4>
							<p>TODAY</p>
						</div>
						<div class="d-flex justify-content-between pb-2">
							<h2>€ <?php echo intval($day_total['local'] * 100) / 100; ?></h2>
							<span></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 ui-sortable mb-3" data-position="3" data-sort="1">
				<div style="height:160px;" class="single-report mb-xs-30">
					<div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<div class="s-report-inner pr--20 pt--30 mb-3">
						<div style="background: #00ff55;" class="icon">&nbsp</div>
						<div class="s-report-title d-flex justify-content-between">
							<h4 class="header-title mb-0">Delivery</h4>
							<p>TODAY</p>
						</div>
						<div class="d-flex justify-content-between pb-2">
							<h2>€ <?php echo intval($day_total['delivery'] * 100) / 100; ?></h2>
							<span></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 ui-sortable mb-3" data-position="4" data-sort="1">
				<div style="height:160px;" class="single-report">
					<div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<div class="s-report-inner pr--20 pt--30 mb-3">
						<div style="background: #ffc34d;" class="icon">&nbsp</div>
						<div class="s-report-title d-flex justify-content-between">
							<h4 class="header-title mb-0">Pick Up</h4>
							<p>TODAY</p>
						</div>
						<div class="d-flex justify-content-between pb-2">
							<h2>€ <?php echo intval($day_total['pickup'] * 100) / 100; ?></h2>
							<span> </span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 ui-sortable mb-3" data-position="5" data-sort="1">
				<div style="height:160px;" class="single-report mb-xs-30">
					<div style="min-height:500px;position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<div class="s-report-inner pr--20 pt--30 mb-3">
						<div style="background: #0066ff;" class="icon">&nbsp</div>
						<div class="s-report-title d-flex justify-content-between">
							<h4 class="header-title mb-0">Total</h4>
							<p>THIS WEEK</p>
						</div>
						<div class="d-flex justify-content-between pb-2">
							<h2>€ <?php echo intval($last_week_total['total'] * 100) / 100; ?></h2>
							<span>
								<?php echo $compare['total']; ?>%
								<?php if ($compare['total'] > 0) : ?>
									<i class="fa fa-long-arrow-up text-success" aria-hidden="true"></i>
								<?php elseif ($compare['total'] < 0) : ?>
									<i class="fa fa-long-arrow-down text-danger" aria-hidden="true"></i>
								<?php endif; ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 ui-sortable mb-3" data-position="6" data-sort="1">
				<div style="height:160px;" class="single-report mb-xs-30">
					<div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<div class="s-report-inner pr--20 pt--30 mb-3">
						<div style="background:  #009933;" class="icon">&nbsp</div>
						<div class="s-report-title d-flex justify-content-between">
							<h4 class="header-title mb-0">Local</h4>
							<p>THIS WEEK</p>
						</div>
						<div class="d-flex justify-content-between pb-2">
							<h2>€ <?php echo intval($last_week_total['local'] * 100) / 100; ?></h2>
							<span>
								<?php echo $compare['local']; ?>%
								<?php if ($compare['local'] > 0) : ?>
									<i class="fa fa-long-arrow-up text-success" aria-hidden="true"></i>
								<?php elseif ($compare['local'] < 0) : ?>
									<i class="fa fa-long-arrow-down text-danger" aria-hidden="true"></i>
								<?php endif; ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 ui-sortable mb-3" data-position="7" data-sort="1">
				<div style="height:160px;" class="single-report mb-xs-30">
					<div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<div class="s-report-inner pr--20 pt--30 mb-3">
						<div style="background: #00ff55;" class="icon">&nbsp</div>
						<div class="s-report-title d-flex justify-content-between">
							<h4 class="header-title mb-0">Delivery</h4>
							<p>THIS WEEK</p>
						</div>
						<div class="d-flex justify-content-between pb-2">
							<h2>€ <?php echo intval($last_week_total['delivery'] * 100) / 100; ?></h2>
							<span>
								<?php echo $compare['delivery']; ?>%
								<?php if ($compare['delivery'] > 0) : ?>
									<i class="fa fa-long-arrow-up text-success" aria-hidden="true"></i>
								<?php elseif ($compare['delivery'] < 0) : ?>
									<i class="fa fa-long-arrow-down text-danger" aria-hidden="true"></i>
								<?php endif; ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 ui-sortable mb-3" data-position="8" data-sort="1">
				<div style="height:160px;" class="single-report">
					<div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<div class="s-report-inner pr--20 pt--30 mb-3">
						<div style="background: #ffc34d;" class="icon">&nbsp</div>
						<div class="s-report-title d-flex justify-content-between">
							<h4 class="header-title mb-0">Pick Up</h4>
							<p>THIS WEEK</p>
						</div>
						<div class="d-flex justify-content-between pb-2">
							<h2>€ <?php echo intval($last_week_total['pickup'] * 100) / 100; ?></h2>
							<span>
								<?php echo $compare['pickup']; ?>%
								<?php if ($compare['pickup'] > 0) : ?>
									<i class="fa fa-long-arrow-up text-success" aria-hidden="true"></i>
								<?php elseif ($compare['pickup'] < 0) : ?>
									<i class="fa fa-long-arrow-down text-danger" aria-hidden="true"></i>
								<?php endif; ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 ui-sortable mb-3" data-position="9" data-sort="1">
				<div style="height:160px;" class="single-report mb-xs-30">
					<div style="min-height:500px;position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
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
			<div class="col-md-3 ui-sortable mb-3" data-position="10" data-sort="1">
				<div style="height:160px;" class="single-report mb-xs-30">
					<div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<div class="s-report-inner pr--20 pt--30 mb-3">
						<div style="background:  #009933;" class="icon">&nbsp</div>
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
					<div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<div class="s-report-inner pr--20 pt--30 mb-3">
						<div style="background: #00ff55;" class="icon">&nbsp</div>
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
					<div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<div class="s-report-inner pr--20 pt--30 mb-3">
						<div style="background: #ffc34d;" class="icon">&nbsp</div>
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

		</div>
	</div>


	<div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable" data-rowposition="2" data-rowsort="1">
		<div class="w-100 mt-3 mb-3 mx-auto">

			<div class="float-right text-center">
				<input style="width: 330px;" class="date form-control-sm mb-2" type="text" name="datetimes" id="reportrange"/>
				<select style="width: 264px;font-size: 14px;" class="custom-select custom-select-sm form-control form-control-sm  mb-1 " id="serviceType">
					<option value="">Choose Service Type</option>
					<?php foreach ($service_types as $service_type) : ?>
						<option id="<?php echo $service_type['id']; ?>" value="<?php echo $service_type['type']; ?>"><?php echo ucfirst($service_type['type']); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="w-100 mt-3 table-responsive">
			<table id="report" class="table table-striped table-bordered" cellspacing="0" width="100%">

				<!-- <tfoot>
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
				</tfoot> -->
			</table>
		</div>
	</div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url()?>';
	$(document).ready(function() {
		var sort = '';
		$.ajax({
			url: "<?php echo base_url(); ?>accountingreport/sortedWidgets",
			method: "GET",
			dataType: "JSON",
			success: function(data) {
				sort = data['sort'];
				row_sort = data['row_sort'];
			},
			async: false
		});
		sort = sort.split(',').reverse();
		row_sort = row_sort.split(',').reverse();

		$("div[data-position]").each(function(index, value) {

			for (var i = 0; i < sort.length; i++) {
				if ($(this).data('position') == sort[i]) {
					console.log()
					$(this).attr("data-sort", i);
				}

			}

		});
		$(".row-sort").each(function(index, value) {
			for (var i = 0; i < row_sort.length; i++) {
				if ($(this).data('rowposition') == row_sort[i]) {
					$(this).attr("data-rowsort", i);
				}
			}

		});


		setTimeout(function() {
			$('#sortable .col-md-3').sort(function(a, b) {
				return $(b).data('sort') - $(a).data('sort');
			}).appendTo('#sortable');
		}, 0);

		setTimeout(function() {
			$('.main-content-inner .row-sort').sort(function(a, b) {
				return $(b).data('rowsort') - $(a).data('rowsort');
			}).appendTo('.main-content-inner');
		}, 0);
		$('.main-content-inner').css('visibility', 'visible');
		$('#sortable').css('visibility', 'visible');
		var getTodayDate = new Date();
		var month = getTodayDate.getMonth() + 1;
		var day = getTodayDate.getDate();
		var todayDate = getTodayDate.getFullYear() + '-' +
			(month < 10 ? '0' : '') + month + '-' +
			(day < 10 ? '0' : '') + day;

		$(function() {
			var start = moment().subtract(90, 'days');
			var end = moment();

			function cb(start, end) {
				$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			}

			$('#reportrange').daterangepicker({
				startDate: start,
        		endDate: end,
				timePicker: true,
				timePicker24Hour: true,
				// startDate: todayDate + ' 00:00:00',
				locale: {
					format: 'YYYY-MM-DD HH:mm:ss'
				}
			},cb);
			cb(start, end);
		});


		var table = $('#report').DataTable({
			processing: true,
			colReorder: true,
			fixedHeader: true,
			deferRender: true,
			scroller: true,
			lengthMenu: [
				[5, 10, 20, 50, 100, 200, 500, -1],
				[5, 10, 20, 50, 100, 200, 500, 'All']
			],
			pageLength: 20,
			ajax: {
				type: 'get',
				url: '<?php echo base_url("accountingreport/get_report"); ?>',
				dataSrc: '',
			},
			// footerCallback: function(tfoot, data, start, end, display) {
			// 	var api = this.api(),
			// 		data;

			// 	//Totals For Current Page

			// 	let pageAmountTotalData = api.column(2, {
			// 		page: 'current'
			// 	}).cache('search');
			// 	let pageAmountTotal = pageAmountTotalData.length ?
			// 		pageAmountTotalData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	let pageServiceFeeData = api.column(5, {
			// 		page: 'current'
			// 	}).cache('search');
			// 	let pageServiceFeeTotal = pageServiceFeeData.length ?
			// 		pageServiceFeeData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	let pageVatServiceData = api.column(7, {
			// 		page: 'current'
			// 	}).cache('search');
			// 	let pageVatServiceTotal = pageVatServiceData.length ?
			// 		pageVatServiceData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	let pageExvatServiceData = api.column(8, {
			// 		page: 'current'
			// 	}).cache('search');
			// 	let pageExvatServiceTotal = pageExvatServiceData.length ?
			// 		pageExvatServiceData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	let pageWaiterTipData = api.column(9, {
			// 		page: 'current'
			// 	}).cache('search');
			// 	let pageWaiterTipTotal = pageWaiterTipData.length ?
			// 		pageWaiterTipData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	let pageAmountData = api.column(10, {
			// 		page: 'current'
			// 	}).cache('search');
			// 	let pageAmount = pageAmountData.length ?
			// 		pageAmountData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;
			// 	let pageExvatData = api.column(11, {
			// 		page: 'current'
			// 	}).cache('search');
			// 	let pageExvatTotal = pageExvatData.length ?
			// 		pageExvatData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;
			// 	let pageVatData = api.column(12, {
			// 		page: 'current'
			// 	}).cache('search');
			// 	let pageVatTotal = pageVatData.length ?
			// 		pageVatData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;


			// 	//Totals For All Pages

			// 	let amountTotalData = api.column(2, {
			// 		search: 'applied'
			// 	}).cache('search');
			// 	let amountTotal = amountTotalData.length ?
			// 		amountTotalData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	let vatServiceData = api.column(7, {
			// 		search: 'applied'
			// 	}).cache('search');
			// 	let vatServiceTotal = vatServiceData.length ?
			// 		vatServiceData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	let exvatServiceData = api.column(8, {
			// 		search: 'applied'
			// 	}).cache('search');
			// 	let exvatServiceTotal = exvatServiceData.length ?
			// 		exvatServiceData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	let waiterTipData = api.column(9, {
			// 		search: 'applied'
			// 	}).cache('search');
			// 	let waiterTipTotal = waiterTipData.length ?
			// 		waiterTipData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	let amountData = api.column(10, {
			// 		search: 'applied'
			// 	}).cache('search');
			// 	let amount = amountData.length ?
			// 		amountData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	let exvatData = api.column(11, {
			// 		search: 'applied'
			// 	}).cache('search');
			// 	let exvatTotal = exvatData.length ?
			// 		exvatData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	let vatData = api.column(12, {
			// 		search: 'applied'
			// 	}).cache('search');
			// 	let vatTotal = vatData.length ?
			// 		vatData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	let serviceFeeData = api.column(5, {
			// 		search: 'applied'
			// 	}).cache('search');
			// 	let serviceFeeTotal = serviceFeeData.length ?
			// 		serviceFeeData.reduce(function(a, b) {
			// 			return parseFloat(a) + parseFloat(b);
			// 		}) : 0;

			// 	$(tfoot).find('th').eq(1).html(pageAmountTotal.toFixed(2) + '(' + amountTotal.toFixed(2) + ')');
			// 	$(tfoot).find('th').eq(2).html('-');
			// 	$(tfoot).find('th').eq(3).html('-');
			// 	$(tfoot).find('th').eq(4).html(pageServiceFeeTotal.toFixed(2) + '(' + serviceFeeTotal.toFixed(2) + ')');
			// 	$(tfoot).find('th').eq(5).html('-');
			// 	$(tfoot).find('th').eq(6).html(pageVatServiceTotal.toFixed(2) + '(' + vatServiceTotal.toFixed(2) + ')');
			// 	$(tfoot).find('th').eq(7).html(pageExvatServiceTotal.toFixed(2) + '(' + exvatServiceTotal.toFixed(2) + ')');
			// 	$(tfoot).find('th').eq(8).html(pageWaiterTipTotal.toFixed(2) + '(' + waiterTipTotal.toFixed(2) + ')');
			// 	$(tfoot).find('th').eq(9).html(pageAmount.toFixed(2) + '(' + amount.toFixed(2) + ')');
			// 	$(tfoot).find('th').eq(10).html(pageExvatTotal.toFixed(2) + '(' + exvatTotal.toFixed(2) + ')');
			// 	$(tfoot).find('th').eq(11).html(pageVatTotal.toFixed(2) + '(' + vatTotal.toFixed(2) + ')');
			// },
			rowId: function(a) {
				return 'row_id_' + a.order_id;
			},
			initComplete: function(settings, json) {
				child_data = json;
			},
			columns: [{
					title: '&nbsp',
					className: 'details-control',
					orderable: false,
					data: null,
					"render": function(data, type, row) {
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
					"render": function(data, type, row) {
						let amount = parseFloat(data.total_AMOUNT);
						return '€ ' + amount.toFixed(2);
					}
				},
				{
					title: 'Qty',
					data: 'quantity'
				},
				{
					title: 'Service Type',
					data: 'service_type'
				},
				{
					title: 'Service Fee',
					data: null,
					"render": function(data, type, row) {
						let serviceFee = parseFloat(data.serviceFee);
						return '€ '+serviceFee.toFixed(2);
					}
				},
				{
					title: 'Service Fee Tax',
					data: null,
					"render": function(data, type, row) {
						let serviceFeeTax = parseInt(data.serviceFeeTax) + "%";
						return '€ '+serviceFeeTax;
					}
				},
				{
					title: 'Service VAT',
					data: null,
					"render": function(data, type, row) {
						let vatService = parseFloat(data.VATSERVICE);
						return '€ '+vatService.toFixed(2);
					}
				},
				{
					title: 'Service EXVAT',
					data: null,
					"render": function(data, type, row) {
						let exvatService = parseFloat(data.EXVATSERVICE);
						return '€ '+exvatService.toFixed(2);
					}
				},
				{
					title: 'Waiter Tip',
					data: null,
					"render": function(data, type, row) {
						let waiterTip = parseFloat(data.waiterTip);
						return '€ '+waiterTip.toFixed(2);
					}
				},
				{
					title: 'AMOUNT',
					data: null,
					"render": function(data, type, row) {
						let amount = parseFloat(data.AMOUNT);
						return '€ '+amount.toFixed(2);
					}
				},
				{
					title: 'EXVAT',
					data: null,
					"render": function(data, type, row) {
						let exvat = parseFloat(data.EXVAT);
						return '€ '+exvat.toFixed(2);
					}
				},
				{
					title: 'VAT',
					data: null,
					"render": function(data, type, row) {
						let vat = parseFloat(data.VAT);
						return '€ '+vat.toFixed(2);
					}
				},
				{
					title: 'Date',
					data: 'order_date'
				},
				{
					"className": 'export-column',
					data : 'status'
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

			$.each(d.child, function(indexInArray, val) {

				row += '<tr>' +
					'<td>' + val.productName + '</td>' +
					'<td>' + val.productVat + '%</td>' +
					'<td>' + '€ ' + round_up(val.price) + '</td>' +
					'<td>' + val.quantity + '</td>' +
					'<td>' + '€ ' + round_up(val.EXVAT) + '</td>' +
					'<td>' + '€ ' + round_up(val.VAT) + '</td>' +
					// '<td>' + val.AMOUNT + '</td>' +
					'</tr>';
			});
			//console.log(d);
			if(d.export_ID==null){
				button = '<button type="button" onclick="export_invoice('+d.order_id+')" class="btn btn-info btn-sm export-'+d.order_id+'">Export</button>';
			}else{
				button = '<button type="button" onclick="export_invoice('+d.order_id+')" class="btn btn-warning btn-sm export-'+d.order_id+'">Exported</button>';
			}
			var child_table =
				'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%;background:#d0a17a91;" class="table table-bordered table-hover" >' + row +
				'<tr><td><strong>Action</strong></td><td>' + button + '</td></tr>'
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
		var month = getTodayDate.getMonth() + 1;
		var day = getTodayDate.getDate();
		var todayDate = getTodayDate.getFullYear() + '-' +
			(month < 10 ? '0' : '') + month + '-' +
			(day < 10 ? '0' : '') + day;

		table.on('search.dt', function() {
			if (table['context'][0]['aiDisplay'].length == 0) {
				$('#report_length').hide();
			} else {
				$('#report_length').show();
			}
		});

		$.fn.dataTable.ext.search.push(
			function(settings, data, dataIndex) {
				let full_timestamp = $('#reportrange').val();
				var date = full_timestamp.split(" - ");
				var min = new Date(date[0]);
				var max = new Date(date[1]);
				var startDate = new Date(data[13]);
				console.log(min);
				console.log(max);
				console.log(startDate);
				if (min == '' && max == '') {
					min = todayDate;
				}
				if (min == '' && startDate <= max) {
					return true;
				}
				if (max == '' && startDate >= min) {
					return true;
				}
				if (startDate <= max && startDate >= min) {
					return true;
				}
				return false;
			});

		$('input[name="datetimes"]').change(function() {
			let full_timestamp = $('input[name="datetimes"]').val();
			var date = full_timestamp.split(" - ");
			var min = date[0];
			var max = date[1];
			$.post("<?php echo base_url('accountingreport/get_timestamp_totals'); ?>", {
				min: "'" + min + "'",
				max: "'" + max + "'"
			}, function(data) {
				let totals = JSON.parse(data);
				let total = totals['total'];
				let local = totals['local'];
				let delivery = totals['delivery'];
				let pickup = totals['pickup'];
				$('#total').text(total_number(total));
				$('#local').text(total_number(local));
				$('#delivery').text(total_number(delivery));
				$('#pickup').text(total_number(pickup));
			});

			table.draw();
		});


		$('#serviceType').change(function() {
			var category = this.value;
			table
				.columns(5)
				.search(category)
				.draw();
		});

	});
	$(function() {
		$('.row').sortable({
			connectWith: ".row",
			items: ".col-md-3",
			update: function(event, ui) {
				var myTable = $(this).index();
				var positions = [];
				$("div[data-position]").each(function(index, value) {
					var data = $(this).data('position');
					positions.push(data);
				});
				positions = positions.toString();
				$.post('<?php echo base_url(); ?>accountingreport/sortWidgets', {
					sort: positions
				});
				setTimeout(function() {

					//toastr["success"]("Widget positions are updated successfully!");
				}, 0);
			}
		});
	});

	$(function() {
		$('.main-content-inner').sortable({
			connectWith: ".main-content-inner",
			items: ".row-sort",
			update: function(event, ui) {
				var myTable = $(this).index();
				var positions = [];
				$("div[data-rowposition]").each(function(index, value) {
					var data = $(this).data('rowposition');
					positions.push(data);
				});

				positions = positions.toString();
				$.post('<?php echo base_url(); ?>accountingreport/sortWidgets', {
					row_sort: positions
				});
			}
		});
	});
	function export_invoice(id){
        $('.export-'+id).text('Exporting...');
        $.get(base_url+'visma/export/'+id,
           function (data, textStatus, jqXHR) {
                response = JSON.parse(data);
                console.log(response);
                if(response.status=='200'){
                    $('.export-'+id).text('Exported');
                    $('.export-'+id).removeClass('btn-primary');
                    $('.export-'+id).addClass('btn-warning');
                    $('.export-'+id).attr( "disabled", "disabled" );
					$('#row_id_'+id+' .export-column').text('Exported');
                    console.log(response.response);
                }else if(response.status=='402'){
                    window.location.replace(base_url+'visma');
                }else{
                    swal({
                        html: true,
                        type: "warning",
                        title: response.ledger+" Ledger Not Linked",
                        text: response.response,
                        icon: "warning",
                        customClass: 'swal-wide'
                    }).then(function() {
                        window.location = base_url+'visma/config';
                    });
                    // alert(response.response);
                }
           }
        );
    }
	function round_up(val) {
		val = parseFloat(val);
		return val.toFixed(2);
	}

	function total_number(number) {
		if (number == 0) {
			return '€ ' + number;
		}
		return '€ ' + number.toFixed(2);
	}
</script>
