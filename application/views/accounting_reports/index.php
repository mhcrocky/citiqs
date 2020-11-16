<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<style>
	.date {
		width: 100%;
		height: 29px;
		padding: .375rem .75rem;
		font-size: 1rem;
		font-weight: 400;
		line-height: 1.5;
		color: #495057;
		background-color: #fff;
		background-clip: padding-box;
		border: 1px solid #ced4da;
		border-radius: .25rem;
	}


	td.details-control {
		background: url("<?php echo base_url('assets/details_open.png') ?>") no-repeat center center;
		cursor: pointer;
	}

	tr.shown td.details-control {
		background: url("<?php echo base_url('assets/details_close.png') ?>") no-repeat center center;
	}
</style>
<div class="main-content-inner">
	<div class="sales-report-area mt-5 mb-5">
		<!-- <div class="row">
			<div class="col-md-3">
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
						<div style="background: #0066ff;" class="icon"><i class="fa fa-eur"></i></div>
						<div class="s-report-title d-flex justify-content-between">
							<h4 class="header-title mb-0">Total</h4>
							<p>TODAY</p>
						</div>
						<div class="d-flex justify-content-between pb-2">
							<h2 class="order_today"></h2>
							<span></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
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
						<div style="background:  #009933;" class="icon"><i class="fa fa-eur"></i></div>
						<div class="s-report-title d-flex justify-content-between">
							<h4 class="header-title mb-0">Local</h4>
							<p>TODAY</p>
						</div>
						<div class="d-flex justify-content-between pb-2">
							<h2>€ <?php echo intval($local_total * 100) / 100; ?></h2>
							<span></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
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
						<div style="background: #00ff55;" class="icon"><i class="fa fa-eur"></i></div>
						<div class="s-report-title d-flex justify-content-between">
							<h4 class="header-title mb-0">Delivery</h4>
							<p>TODAY</p>
						</div>
						<div class="d-flex justify-content-between pb-2">
							<h2>€ <?php echo intval($delivery_total * 100) / 100; ?></h2>
							<span></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
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
						<div style="background: #ffc34d;" class="icon"><i class="fa fa-eur"></i></div>
						<div class="s-report-title d-flex justify-content-between">
							<h4 class="header-title mb-0">Pick Up</h4>
							<p>TODAY</p>
						</div>
						<div class="d-flex justify-content-between pb-2">
							<h2>€ <?php echo intval($pickup_total * 100) / 100; ?></h2>
							<span> </span>
						</div>
					</div>
					<br>
					<br>
					<br>
				</div>
			</div>
		</div>
	</div> -->



	<div class="w-100 mt-3 mb-3 mx-auto">

		<div class="float-right text-center">
			<input class="date form-control-sm mb-3" style="width: 130px;" type="text" id="min" placeholder="From Date">
			<input class="date form-control-sm mb-3" style="width: 130px;" type="text" id="max" placeholder="To Date">
			<select style="width: 264px;" class="custom-select custom-select-sm form-control form-control-sm  mb-2 " id="serviceType">
				<option value="">Choose Service Type</option>
				<?php foreach ($service_types as $service_type) : ?>
					<option id="<?php echo $service_type['id']; ?>" value="<?php echo $service_type['type']; ?>"><?php echo ucfirst($service_type['type']); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<div class="w-100 mt-3 table-responsive">
		<table id="report" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="10px"></th>
					<th>Order ID</th>
					<th>Total Amount</th>
					<th>Quantity</th>
					<th>Service Type</th>
					<th>Service Fee</th>
					<th>Service EXVAT</th>
					<th>Service VAT</th>
					<th>AMOUNT</th>
					<th>EXVAT</th>
					<th>VAT</th>
					<th>DATE</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
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
				</tr>
			</tfoot> -->
		</table>
	</div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url()?>';
	$(document).ready(function() {
		var table = $('#report').DataTable({
			destroy: true,
			colReorder: true,
			fixedHeader: true,
			scrollX: true,
			pageLength: 50,

			"ajax": {
				url: '<?php echo base_url("accountingreport/get_report"); ?>',
				cache: true,
			},
			rowId: function(a) {
				return 'row_id_' + a.order_id;
			},
			"initComplete": function(settings, json) {
				child_data = json;
				console.log(child_data)
			},
			columns: [{
					"className": 'details-control',
					"orderable": false,
					"data": null,
					"defaultContent": ''
				},
				{
					data: 'order_id'
				},
				{
					data: null,
					"render": function(data, type, row) {
						let vat = parseFloat(data.AMOUNT);
						return '€ '+vat.toFixed(2);
					}
				},
				{
					data: 'quantity'
				},
				{
					data: 'service_type'
				},
				{
					data: null,
					"render": function(data, type, row) {
						let serviceFee = parseFloat(data.serviceFee);
						return '€ '+serviceFee.toFixed(2);
					}
				},
				{
					data: null,
					"render": function(data, type, row) {
						let EXServiceFee = parseFloat(data.EXServiceFee);
						return '€ '+EXServiceFee.toFixed(2);
					}
				},
				{
					data: null,
					"render": function(data, type, row) {
						let VATSERVICE = parseFloat(data.VATSERVICE);
						return '€ '+VATSERVICE.toFixed(2);
					}
				},
				{
					data: null,
					"render": function(data, type, row) {
						let exvat = parseFloat(data.price);
						return '€ '+exvat.toFixed(2);
					}
				},
				{
					data: null,
					"render": function(data, type, row) {
						let exvat = parseFloat(data.EXVAT);
						return '€ '+exvat.toFixed(2);
					}
				},
				{
					data: null,
					"render": function(data, type, row) {
						let vat = parseFloat(data.VAT);
						return '€ '+vat.toFixed(2);
					}
				},
				{
					data: 'order_date'
				},
				{
					"className": 'export-column',
					data : 'status'
				}
			]
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


		// $.fn.dataTable.ext.search.push(
		// 	function(settings, data, dataIndex) {
		// 		var min = $('#min').datepicker({
		// 			dateFormat: 'yy-mm-dd'
		// 		}).val();
		// 		var max = $('#max').datepicker({
		// 			dateFormat: 'yy-mm-dd'
		// 		}).val();
		// 		var startDate = data[9];
		// 		if (min == '' && max == '') {
		// 			min = todayDate;
		// 		}
		// 		if (min == '' && startDate <= max) {
		// 			return true;
		// 		}
		// 		if (max == '' && startDate >= min) {
		// 			return true;
		// 		}
		// 		if (startDate <= max && startDate >= min) {
		// 			return true;
		// 		}
		// 		return false;
		// 	}
		// );

		$("#min").datepicker({
			dateFormat: 'yy-mm-dd',
			maxDate: '0',
			onSelect: function() {
				console.log('here');
				table.draw();
			},
			changeMonth: true,
			changeYear: true
		});
		$("#max").datepicker({
			dateFormat: 'yy-mm-dd',
			maxDate: '0',
			onSelect: function() {
				table.draw();
			},
			changeMonth: true,
			changeYear: true
		});

		// Event listener to the two range filtering inputs to redraw on input
		$('#min, #max').change(function() {
			table.draw();
		});


		$('#serviceType').change(function() {
			var category = this.value;
			table
				.columns(5)
				.search(category)
				.draw();
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
					'<td>' + '€ '+round_up(val.price) + '</td>' +
					'<td>' + val.quantity + '</td>' +
					'<td>' + '€ '+round_up(val.EXVAT) + '</td>' +
					'<td>' + '€ '+round_up(val.VAT) + '</td>' +
					// '<td>' + val.AMOUNT + '</td>' +
					'</tr>';
			});
			console.log(d);
			if(d.export_ID==null){
				button = '<button type="button" onclick="export_invoice('+d.order_id+')" class="btn btn-info btn-sm export-'+d.order_id+'">Export</button>';
			}else{
				button = '<button type="button" onclick="export_invoice('+d.order_id+')" class="btn btn-warning btn-sm export-'+d.order_id+'">Exported</button>';
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
	var i = 0;
	function round_up(val){
		val = parseFloat(val);
		return val.toFixed(2);
	}
	function Orders_today(order_today) {
		if (i == 1) {
			$('.order_today').text('€ ' + order_today);
		}
		i++;
	}
</script>
