<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
<style>
.custom-select {
  width: 65px !important;
}
</style>

<div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable" data-rowposition="2" data-rowsort="1">
<div class="w-100 mt-3 mb-3 mx-auto">

  <div class="float-right text-center">
  <label for="category">Choose Category</label>
    <select style="width: 264px  !important;font-size: 14px;" class="custom-select custom-select-sm form-control form-control-sm  mb-1 " id="category">
       
        <?php foreach ($categories as $category): ?>
        <option  value="<?php echo strtolower($category['category']); ?>"><?php echo ucfirst($category['category']); ?></option>
        <?php endforeach;?>
    </select>
    </div>
</div>

<div class="w-100 mt-3 p-5 table-responsive">
  <table id="products" class="table table-striped table-bordered" cellspacing="0" width="100%">
  </table>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>


<script type="text/javascript">


  $(document).ready( function () {
    $("select option:nth-child(1)").attr("selected", true);
      var table = $('#products').DataTable({
        processing: true,
        colReorder: true,
        rowReorder: true,
        fixedHeader: true,
        deferRender: true,
        scroller: true,
        ordering: true,
        lengthMenu: [[200, 500, -1], [200, 500, 'All']],
        pageLength: 200,
        ajax: {
          type: 'get',
          url: '<?php echo base_url("getproducts"); ?>',
          dataSrc: '',
        },
        // order: [[ 1, "desc" ]],
        rowReorder: {
          selector: 'tr',
          dataSrc: 'position'
        },
        columnDefs: [
            {orderable: false, targets: 0, visible: false }
        ],
        columns:[
        {
          title: 'Order',
					data: 'position',
        },
        {
          title: 'ID',
          data: 'id'
        },
        {
          title: 'Name',
          data: 'name'
        },
        {
          title: 'Category',
          data: 'category'
        }
        ],
      });

      var category = $('#category').val();
        table
        .columns( 3 )
        .search( category )
        .draw();

      $('#category').change(function() {
        var category = this.value;
        table
        .columns( 3 )
        .search( category )
        .draw();
      });
      
      table.on( 'row-reordered', function ( e, diff, edit ) {
        var products = [];
        var i = 1;
        table.one( 'draw', function () {
          console.log( 'Redraw occurred at: '+new Date().getTime() );
          table.rows({search:'applied'}).every(function (rowIdx, tableLoop, rowLoop) {
            console.log(rowIdx, this.data());
            products.push([this.data().id,i]);
            var data = {
              productId: this.data().id,
              orderNo: this.data().position
            }
            i++;
            //$.post('<?php #echo base_url("updateproductorderno") ?>',data)
          });
          if (products.length > 0) {
          console.log(products);
          // $.post('<?php #echo base_url("updateproductorderno") ?>',{products:products});
        }
        });

        
        
} );

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
</script>
