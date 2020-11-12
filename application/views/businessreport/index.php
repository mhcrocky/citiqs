<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
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
</style>
<div class="main-content-inner">
    <div class="sales-report-area mt-5 mb-5">
                    <div class="row">
                    <div class="col-md-3">
                            <div style="height:160px;" class="single-report mb-xs-30"><div style="min-height:500px;position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
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
                    <div  class="col-md-3"> 
                            <div style="height:160px;" class="single-report mb-xs-30"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background:  #009933;" class="icon"><i class="fa fa-eur"></i></div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Local</h4>
                                        <p>TODAY</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2>€ <?php echo $local_total; ?></h2>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div  style="height:160px;"  class="single-report mb-xs-30"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                <div style="background: #00ff55;" class="icon"><i class="fa fa-eur"></i></div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Delivery</h4>
                                        <p>TODAY</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2>€ <?php echo $delivery_total; ?></h2>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div  style="height:160px;"  class="single-report"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div style="background: #ffc34d;" class="icon"><i class="fa fa-eur"></i></div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Pick Up</h4>
                                        <p>TODAY</p>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2>€ <?php echo $pickup_total; ?></h2>
                                        <span> </span>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                


<div class="w-100 mt-3 mb-3 mx-auto">

  <div class="float-right text-center">
  <input class="date form-control-sm mb-3" style="width: 130px;" type="text" id="min" placeholder="From Date">
  <input class="date form-control-sm mb-3" style="width: 130px;" type="text" id="max" placeholder="To Date">
    <select style="width: 264px;" class="custom-select custom-select-sm form-control form-control-sm  mb-2 " id="serviceType">
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
        </tr>
    </tfoot>
  </table>
</div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">

  $(document).ready( function () {
      var table = $('#report').DataTable({
        processing: true,
        lengthMenu: [[5, 10, 20, 50, 100, 200, 500, -1], [5, 10, 20, 50, 100, 200, 500, 'All']],
        pageLength: 5,
        ajax: {
          type: 'get',
          url: '<?php echo base_url("businessreport/get_report"); ?>',
          dataSrc: '',
        },
        footerCallback: function( tfoot, data, start, end, display ) {
           var api = this.api(), data;
           let allAmountTotal = api
               .column( 6, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                   return parseFloat(a) + parseFloat(b);
               }, 0 );
            let pagePriceTotal = api
               .column( 2, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                   return parseFloat(a) + parseFloat(b);
               }, 0 );
          let pageQuantityTotal = api
               .column( 4, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                   return parseInt(a) + parseInt(b);
               }, 0 );
          let pageAmountTotal = api
               .column( 6, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                   return parseFloat(a) + parseFloat(b);
               }, 0 );
          let pageExvatData = api.column( 7, { page: 'current'} ).cache('search');
          let pageExvatTotal = pageExvatData.length ? 
            pageExvatData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;
          let pageVatData = api.column( 8, { page: 'current'} ).cache('search');
          let pageVatTotal = pageVatData.length ? 
            pageVatData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;

           let priceTotal = api
               .column( 2, { search: 'applied' } )
               .data()
               .reduce( function (a, b) {
                   return parseFloat(a) + parseFloat(b);
               }, 0 );
          let quantityTotal = api
               .column( 4, { search: 'applied' } )
               .data()
               .reduce( function (a, b) {
                   return parseInt(a) + parseInt(b);
               }, 0 );
          let amountTotal = api
               .column( 6, { search: 'applied' } )
               .data()
               .reduce( function (a, b) {
                   return parseFloat(a) + parseFloat(b);
               }, 0 );
          let exvatData = api.column( 7,{ search: 'applied' } ).cache('search');
          let exvatTotal = exvatData.length ? 
            exvatData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;
          let vatData = api.column( 8, { search: 'applied' }).cache('search');
          let vatTotal = vatData.length ? 
            vatData.reduce( function (a, b) {
              return parseFloat(a) + parseFloat(b);
            }) : 0;
           $(tfoot).find('th').eq(1).html(pagePriceTotal.toFixed(2)+'('+priceTotal.toFixed(2)+')');
           $(tfoot).find('th').eq(2).html('-');
           $(tfoot).find('th').eq(3).html(pageQuantityTotal+'('+quantityTotal+')');
           $(tfoot).find('th').eq(4).html('-');
           $(tfoot).find('th').eq(5).html(pageAmountTotal.toFixed(2)+'('+amountTotal.toFixed(2)+')');
           $(tfoot).find('th').eq(6).html(pageExvatTotal.toFixed(2)+'('+exvatTotal.toFixed(2)+')');
           $(tfoot).find('th').eq(7).html(pageVatTotal.toFixed(2)+'('+vatTotal.toFixed(2)+')');
           Orders_today(amountTotal);
        },
        columns:[
        {
          title: 'Order ID',
          data: 'order_id'
        },
        {
          
          data: 'productName'
        },
        {
          title: 'Price',
          data: 'price'
        },
        {
          title: 'Product VAT',
          data: 'productVat'
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
          title: 'AMOUNT',
          data: 'AMOUNT'
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

      var getTodayDate = new Date();
      var month = getTodayDate.getMonth()+1;
      var day = getTodayDate.getDate();
      var todayDate = getTodayDate.getFullYear() + '-' +
      (month<10 ? '0' : '') + month + '-' +
      (day<10 ? '0' : '') + day;

      table.on( 'search.dt', function () {
        if(table['context'][0]['aiDisplay'].length == 0){
          $('#report_length').hide();
        } else {
          $('#report_length').show();
        }
      });


      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = $('#min').datepicker({ dateFormat: 'yy-mm-dd' }).val();
            var max = $('#max').datepicker({ dateFormat: 'yy-mm-dd' }).val();
            var startDate = data[9];
            if (min == '' && max == '') { min = todayDate; }
            if (min == '' && startDate <= max) { return true;}
            if(max == '' && startDate >= min) {return true;}
            if (startDate <= max && startDate >= min) { return true; }
            return false;
        }
        );

            $("#min").datepicker({dateFormat: 'yy-mm-dd',maxDate: '0', onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#max").datepicker({dateFormat: 'yy-mm-dd',maxDate: '0', onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
       

      $('#serviceType').change(function() {
        var category = this.value;
        table
        .columns( 5 )
        .search( category )
        .draw();
      });

});
var i = 0;
function Orders_today(order_today){
  if(i==1){
    $('.order_today').text('€ '+order_today);
  }
  i++;
}
</script>