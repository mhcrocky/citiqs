<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

<div class="w-100 pr-4 mt-5 table-responsive">
  <div class="float-right mt-3">
    <select style="width: 180px;" class="custom-select custom-select-sm form-control form-control-sm" id="myselect">
        <option value="">Choose Service Type</option>
        <?php foreach ($service_types as $service_type): ?>
        <option id="<?php echo $service_type['id']; ?>" value="<?php echo $service_type['type']; ?>"><?php echo ucfirst($service_type['type']); ?></option>
        <?php endforeach;?>
    </select>
  </div>
</div>

<div class="w-100 p-4 table-responsive">
  <table id="report" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  $(document).ready( function () {
      var table = $('#report').DataTable({
        processing: true,
        lengthMenu: [5, 10, 20, 50, 100, 200, 500],
        pageLength: 5,
        ajax: {
          type: 'get',
          url: '<?php echo base_url("businessreport/get_report"); ?>',
          dataSrc: '',
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
          data: 'EXVAT'
        },
        {
          title: 'VAT',
          data: 'VAT'
        }
        ],
      });

      $('select').change(function() {
        var category = this.value;
        table
        .columns( 5 )
        .search( category )
        .draw();
      });

});
</script>