$(document).ready( function () {
  $('.query-text').on('keyup', function(){
    $('.query-error').empty();
    $('.query-text').removeClass('border-danger');
    $('.query-error').removeClass('alert').removeClass('alert-danger');
  });
  //Collapse of Saved Query
  var coll = document.getElementsByClassName("collapsible");
  var i;
  for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
            content.style.display = "none";
        } else {
            content.style.display = "block";
        }
    });
  }
  //End Collapse

  //Query Builder
      var options = {
        allow_empty: true,
        filters: [
          {
            id: 'tbl_shop_orders.id',
            label: 'Order Id',
            type: 'integer',
            class: 'id',
            // optgroup: 'core',
            default_value: '',
            size: 30,
            unique: true
          },
          {
            id: 'tbl_shop_products_extended.price',
            label: 'Price',
            type: 'integer',
            class: 'price',
            // optgroup: 'core',
            default_value: '',
            size: 30,
            unique: true
          },
          {
            id: 'tbl_shop_products_extended.name',
            label: 'Product Name',
            type: 'string',
            class: 'name',
            // optgroup: 'core',
            default_value: '',
            size: 30,
            unique: true
          },
          {
            id: 'tbl_user.username',
            label: 'Buyer Name',
            type: 'string',
            class: 'username',
            // optgroup: 'core',
            default_value: '',
            size: 30,
            unique: true
          },
          {
            id: 'tbl_user.email',
            label: 'Buyer Email',
            type: 'string',
            class: 'email',
            // optgroup: 'core',
            default_value: '',
            size: 30,
            unique: true
          },
          {
            id: 'AMOUNT',
            label: 'Amount',
            type: 'integer',
            class: 'amount',
            // optgroup: 'core',
            default_value: '',
            size: 30,
            unique: true
          },
          {
            id: 'tbl_shop_orders.old_order',
            label: 'Old Order',
            type: 'integer',
            class: 'old_order',
            // optgroup: 'core',
            default_value: '',
            size: 30,
            unique: true
          },
          {
            id: 'tbl_shop_orders.waiterTip',
            label: 'WaiterTip',
            type: 'integer',
            class: 'waitertip',
            // optgroup: 'core',
            default_value: '',
            size: 30,
            unique: true
          },
          {
            id: 'tbl_shop_orders.serviceFee',
            label: 'ServiceFee',
            type: 'integer',
            class: 'servicefee',
            // optgroup: 'core',
            default_value: '',
            size: 30,
            unique: true
          },
          {
            id: 'tbl_shop_order_extended.quantity',
            label: 'Quantity',
            type: 'integer',
            class: 'quantity',
            // optgroup: 'core',
            default_value: '',
            size: 30,
            unique: true
           },
			{
				id: 'tbl_shop_orders.paymentType',
				label: 'Payment type',
				type: 'string',
				class: 'paymenttype',
				// optgroup: 'core',
				default_value: '',
				size: 30,
				unique: true
			},
        ]
      };
      
      $('#query-builder').queryBuilder(options);
      $('#query').queryBuilder(options);
      //console.log($('#query'));
      var sql;
      $('.parse-json').on('click', function() {
        table.ajax.reload();
        table.clear().draw();
      });
      $('input[type=radio][name=query]').change(function() {
        table.ajax.reload();
        table.clear().draw();
    });
      $('#saveResults').on('click', function() {
        let tbl_datas = table.rows({ search: 'applied'}).data();
       
        var description = $("#description").val();
        var data = [];
        $.each(tbl_datas, function( index, tbl_data ) {
          data[index] = {
            vendor_id: tbl_data.vendor_id,
            description: description,
            user_id:tbl_data.user_id,
          };
          
          //results[index] = d;
        });
        $.ajax({
          type: "POST",
          url: globalVariables.baseUrl + "marketing/targeting/save_results",
          data: {results: data},
          success: function(data){
            //console.log(data);
          }
        });
        
       
      });

      //End Query Builder


      //DateTime Picker
      var getTodayDate = new Date();
      var month = getTodayDate.getMonth()+1;
      var day = getTodayDate.getDate();
      var todayDate = getTodayDate.getFullYear() + '-' +
      (month<10 ? '0' : '') + month + '-' +
      (day<10 ? '0' : '') + day;

      $(function() {
        var time = moment().hours(0).minutes(0).seconds(0);
        $('input[name="datetimes"]').daterangepicker({
          timePicker: true,
          timePicker24Hour: true,
          startDate: todayDate+' 00:00:00',
          locale: {
            format: 'YYYY-MM-DD HH:mm:ss'
          },
          ranges: {
           'Today': [time, moment()],
           'Yesterday': [moment().startOf("day").subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().startOf("day").subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().startOf("day").subtract(29, 'days'), moment()],
           'This Month': [moment().startOf("day").startOf('month'), moment().endOf('month')],
           'Last Month': [moment().startOf("day").subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'This Quarter': [moment().startOf("day").subtract(1, 'quarter'), moment()],
           'Last Quarter': [moment().startOf("day").subtract(2, 'quarter'), moment().subtract(1, 'quarter')],
           'This Year': [moment().startOf("day").startOf('year'), moment().endOf('year')],
           'Last Year': [moment().startOf("day").subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
           }
        });
      });

      //End DateTime Picker


      //Targeting Datatable
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
        html += '<th>Date</th>';
        html += '<th>Name</th>';
		html += '<th>email</th>';
        html += '<th>Order ID</th>';
        html += '<th>Product Name</th>';
        html += '<th>Product VAT</th>';
        html += '<th>Price</th>';
        html += '<th>Quantity</th>';
        // html += '<th>EXVAT</th>';
        // html += '<th>VAT</th>';
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
				  html += '<td>' + val.order_date + '</td>';
				  html += '<td>' + val.username + '</td>';
				  html += '<td>' + val.email + '</td>' ;
                  html += '<td>' + val.order_id + '</td>';
                  html += '<td>' + val.productName + '</td>' ;
                  html += '<td>' + num_percentage(val.productVat) + '</td>' ;
                  html += '<td>' + round_up(val.price) + '</td>' ;
                  html += '<td>' + val.quantity + '</td>' ;
                  // html += '<td>' + round_up(val.EXVAT) + '</td>' ;
                  // html += '<td>' + round_up(val.VAT) + '</td>';
                html += '</tr>';
                
                //var array_values = Object.keys(val).map(i => val[i]);

              });
            }
          });
          html += '</tbody>';
          
        });
        html += '<tfoot>';
        for (var key in productsVat) {
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
          type: 'post',
          url: globalVariables.baseUrl + "marketing/targeting/get_report",
          data: function(data) {
            let query = $('#query-builder').queryBuilder('getSQL', false, true).sql;
            var sql1 = query.replace(/\n/g, " ");
            sql1 = "AND ("+sql1+")";
            var sql2 = $("input[name='query']:checked").val();
            if(query == ""){
              data.sql1 = "";
              data.sql1 = encodeURI(sql1);
              data.sql2 = encodeURI(sql2);
            } else {
              data.sql1 = encodeURI(sql1);
              data.sql2 = encodeURI(sql2);
            }
            $('.has-error').removeClass('has-error');
          },
          dataSrc: '',
        },
        footerCallback: function( tfoot, data, start, end, display ) {
           var api = this.api(), data;
          //Totals For Current Page

          let pageAmountTotalData = api.column( 4, { page: 'current'}  ).cache('search');
          let pageAmountTotal = pageAmountTotalData.length ? 
          pageAmountTotalData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let pageServiceFeeData = api.column( 6,  { page: 'current'} ).cache('search');
          let pageServiceFeeTotal = pageServiceFeeData.length ? 
          pageServiceFeeData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let pageVatServiceData = api.column( 8,  { page: 'current'} ).cache('search');
          let pageVatServiceTotal = pageVatServiceData.length ? 
          pageVatServiceData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let pageExvatServiceData = api.column( 9,  { page: 'current'} ).cache('search');
          let pageExvatServiceTotal = pageExvatServiceData.length ? 
          pageExvatServiceData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let pageWaiterTipData = api.column( 10, { page: 'current'}  ).cache('search');
          let pageWaiterTipTotal = pageWaiterTipData.length ? 
          pageWaiterTipData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let pageAmountData = api.column( 11, { page: 'current'}  ).cache('search');
          let pageAmount = pageAmountData.length ? 
          pageAmountData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          // let pageExvatData = api.column( 12, { page: 'current'} ).cache('search');
          // let pageExvatTotal = pageExvatData.length ?
          //   pageExvatData.reduce( function (a, b) {
          //     return parseFloat(a) + parseFloat(b);
          //   }) : 0;
          // let pageVatData = api.column( 13, { page: 'current'} ).cache('search');
          // let pageVatTotal = pageVatData.length ?
          //   pageVatData.reduce( function (a, b) {
          //     return parseFloat(a) + parseFloat(b);
          //   }) : 0;
          //Totals For All Pages

          let amountTotalData = api.column( 4,{ search: 'applied' } ).cache('search');
          let amountTotal = amountTotalData.length ? 
          amountTotalData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let vatServiceData = api.column( 8,  { search: 'applied' } ).cache('search');
          let vatServiceTotal = vatServiceData.length ? 
          vatServiceData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let exvatServiceData = api.column( 9, { search: 'applied' }).cache('search');
          let exvatServiceTotal = exvatServiceData.length ? 
          exvatServiceData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let waiterTipData = api.column( 10,{ search: 'applied' } ).cache('search');
          let waiterTipTotal = waiterTipData.length ? 
          waiterTipData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          let amountData = api.column( 11,{ search: 'applied' } ).cache('search');
          let amount = amountData.length ? 
          amountData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

          // let exvatData = api.column( 12,{ search: 'applied' } ).cache('search');
          // let exvatTotal = exvatData.length ?
          //   exvatData.reduce( function (a, b) {
          //     return parseFloat(a) + parseFloat(b);
          //   }) : 0;
		  //
          // let vatData = api.column( 13, { search: 'applied' }).cache('search');
          // let vatTotal = vatData.length ?
          //   vatData.reduce( function (a, b) {
          //     return parseFloat(a) + parseFloat(b);
          //   }) : 0;

          let serviceFeeData = api.column( 6,  { search: 'applied' } ).cache('search');
          let serviceFeeTotal = serviceFeeData.length ? 
          serviceFeeData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

           $(tfoot).find('th').eq(3).html(round_up(pageAmountTotal)+'('+round_up(amountTotal)+')');
           $(tfoot).find('th').eq(4).html('-');
           $(tfoot).find('th').eq(5).html(round_up(pageServiceFeeTotal)+'('+round_up(serviceFeeTotal)+')');
           $(tfoot).find('th').eq(6).html('-');
           $(tfoot).find('th').eq(7).html(round_up(pageVatServiceTotal)+'('+round_up(vatServiceTotal)+')');
           $(tfoot).find('th').eq(8).html(round_up(pageExvatServiceTotal)+'('+round_up(exvatServiceTotal)+')');
           $(tfoot).find('th').eq(9).html(round_up(pageWaiterTipTotal)+'('+round_up(waiterTipTotal)+')');
           $(tfoot).find('th').eq(10).html(round_up(pageAmount)+'('+round_up(amount)+')');
           // $(tfoot).find('th').eq(11).html(round_up(pageExvatTotal)+'('+round_up(exvatTotal)+')');
           // $(tfoot).find('th').eq(12).html(round_up(pageVatTotal)+'('+round_up(vatTotal)+')');
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
          title: 'Buyer Name',
          data: 'username'
        },
        {
          title: 'Buyer Email',
          data: 'email'
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
            let serviceFeeTax = num_format(data.serviceFeeTax)+"%";
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
          title: 'Date',
          data: 'order_date'
        },
        {
          title: 'Payment Type',
          data: 'paymenttype'
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

        row += '<tr>' +
					'<td class="text-right" colspan="4"><b>Total for ' + num_percentage(key) + '</b></td>' +
					'<td>' + productsVat[key][0].toFixed(2) + '</td>' +
          '<td>' + productsVat[key][1].toFixed(2) + '</td>' +
					// '<td>' + val.AMOUNT + '</td>' +
			'</tr>';
      }
      $.each(productsVat, function(index, val) {

      row += '<tr>' +
					'<td colspan="2">' + index + '</td>' +
					'<td colspan="4">' + val + '</td>' +
					// '<td>' + val.AMOUNT + '</td>' +
			'</tr>';
      });
      
			if(d.export_ID==null){
				button = '';
			}else{
				button = '';
			}
			var child_table =
				'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%;background:#d0a17a91;" class="table table-bordered table-hover" >' + row +
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

    
      //table.on( 'search.dt', function () {
        //null
      //});
      

      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          let full_timestamp = $('input[name="datetimes"]').val();
          var date = full_timestamp.split(" - ");
          var min = moment(date[0]);
          var max = moment(date[1]);
          var startDate = moment(data[12]); // data['Position of date's column -1']
   
          if (min == '' && max == '') { min = todayDate; }
          if (min == '' && startDate <= max) { return true;}
          if(max == '' && startDate >= min) {return true;}
          if (startDate <= max && startDate >= min) { return true; }
            return false;
        });
        
        $('input[name="datetimes"]').change(function () {
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

function round_up(val){
  val = parseFloat(val);
  return val.toFixed(2);
}

function total_number(number){
  if(number == 0){
   return '€ '+number;
  }
  return '€ '+number.toFixed(2);
}

function num_percentage(number){
  number = num_format(number);
  return number + "%";
}

function addZero(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
}

function editModal(id) {
  var options = {
      allow_empty: true,
      filters: [{
              id: 'tbl_shop_products_extended.price',
              label: 'Price',
              type: 'integer',
              class: 'price',
              // optgroup: 'core',
              default_value: '',
              size: 30,
              unique: true
          },
          {
              id: 'AMOUNT',
              label: 'Amount',
              type: 'integer',
              class: 'amount',
              // optgroup: 'core',
              default_value: '',
              size: 30,
              unique: true
          },
          {
              id: 'tbl_shop_orders.old_order',
              label: 'Old Order',
              type: 'integer',
              class: 'old_order',
              // optgroup: 'core',
              default_value: '',
              size: 30,
              unique: true
          },
          {
              id: 'tbl_shop_orders.waiterTip',
              label: 'WaiterTip',
              type: 'integer',
              class: 'waitertip',
              // optgroup: 'core',
              default_value: '',
              size: 30,
              unique: true
          },
          {
              id: 'tbl_shop_orders.serviceFee',
              label: 'ServiceFee',
              type: 'integer',
              class: 'servicefee',
              // optgroup: 'core',
              default_value: '',
              size: 30,
              unique: true
          },
          {
              id: 'tbl_shop_order_extended.quantity',
              label: 'Quantity',
              type: 'integer',
              class: 'quantity',
              // optgroup: 'core',
              default_value: '',
              size: 30,
              unique: true
          },
      ]
  };

  $('#query' + id).queryBuilder(options);

}

function editQuery(id) {
  var query_text = $("#query-text" + id).val();

  if(query_text.length < 3){
    $("#query-text" + id).addClass('border-danger');
    $('#query-text-error-'+id).addClass('alert').addClass('alert-danger');
    $("#query-text-error-"+id).text('The description cannot be shorter than 3 characters!');
    return false;
  }
  var query = $('#query'+id).queryBuilder('getSQL', false, true).sql;
  var sql;
  var data;
  if (query == "") {
      data = {
          id: id,
          query: query_text,
      };
  } else {
      sql = query.replace(/\n/g, " ");
      sql = "AND (" + sql + ")";
      data = {
          id: id,
          query: query_text,
          value: sql
      };
  }

  $.ajax({
      type: 'post',
      url: globalVariables.baseUrl + 'marketing/targeting/edit_query',
      data: data,
      success: function() {
        $('#closeEditQueryModal').click();
        $("#label"+id).text(query_text);
      }
  });

  $('#closeEditQueryModal').click();

}

function saveQuery() {
  var query_text = $("#query-text").val();
  if(query_text.length < 3){
    $('#query-text').addClass('border-danger');
    $('#query-text-error').addClass('alert').addClass('alert-danger');
    $('#query-text-error').text('The description cannot be shorter than 3 characters!');
    return false;
  }
  var query = $('#query').queryBuilder('getSQL', false, true).sql;
  var sql = query.replace(/\n/g, " ");
  if(sql.length < 3){
    return false;
  }
  sql = "AND (" + sql + ")";
  var data = {
      query: query_text,
      value: sql
  };
  $.ajax({
      type: 'post',
      url: globalVariables.baseUrl + 'marketing/targeting/save_query',
      data: data,
      success: function() {
          $('#closeQueryModal').click();
          location.reload();
      }
  });

  $('#closeQueryModal').click();

}

function deleteQuery(id) {
  if (window.confirm("Are you sure?")) {
      var data = {
          id: id
      };
      $.ajax({
          type: 'post',
          url: globalVariables.baseUrl + 'marketing/targeting/delete_query',
          data: data,
          success: function() {
              $("#inputGroup"+id).fadeOut();
          }
      });
      //location.reload();
  }
}

function saveCRON(id) {
  let data = {
      query_id: id,
      run: $('#run' + id + ' option:selected').val(),
      seconds: $('#seconds' + id).val(),
      minutes: $('#minutes' + id).val(),
      hours: $('#hours' + id).val(),
      day_of_month: $('#dayofmonth' + id).val(),
      month: $('#month' + id).val(),
      day_of_week: $('#dayofweek' + id).val(),
      year: $('#year' + id).val()
  }
  $.post(globalVariables.baseUrl + 'marketing/targeting/save_cron_job', data, function(data) {
      console.log('success');
  });
  console.log(data);
}

function num_format(num){
  var num1 = parseInt(num);
  var num2 = parseFloat(num) - parseFloat(num1);
  if(num2 == '0'){
      num2 = '00';
  } else {
      num2 = Math.round(num2 * 100);
  }
  
  var full_num = addZero(num1) + "." + num2;
  return full_num;
}
