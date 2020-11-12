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


<div class="w-100 pr-4 mt-5">

  <div class="float-right mt-5">
  <input class="date form-control-sm" style="width: 130px;" type="text" id="datepicker" placeholder="Date">
    <select style="width: 180px;" class="custom-select custom-select-sm form-control form-control-sm" id="serviceType">
        <option value="">Choose Service Type</option>
        <?php foreach ($service_types as $service_type): ?>
        <option id="<?php echo $service_type['id']; ?>" value="<?php echo $service_type['type']; ?>"><?php echo ucfirst($service_type['type']); ?></option>
        <?php endforeach;?>
    </select>
    </div>
</div>

<div class="w-100 p-4 table-responsive">
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  $( function() {
    $( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd',maxDate: '0'});
  } );
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
        },
        columns:[
        {
          title: 'Order ID',
          data: 'order_id'
        },
        {
          title: 'Name',
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


      table.on( 'search.dt', function () {
        if(table['context'][0]['aiDisplay'].length == 0){
          $('#report_length').hide();
        } else {
          $('#report_length').show();
        }
      });

      $('#datepicker').on('change',function() {
        var date = this.value;
        table
        .columns( 9 )
        .search( date )
        .draw();
      });
      $('#serviceType').change(function() {
        var category = this.value;
        table
        .columns( 5 )
        .search( category )
        .draw();
      });

});
</script>