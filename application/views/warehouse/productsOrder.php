<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">


<div class="w-100 mt-3 p-5 table-responsive">
  <table id="products" class="table table-striped table-bordered" cellspacing="0" width="100%">
  </table>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>


<script type="text/javascript">


  $(document).ready( function () {
      var table = $('#products').DataTable({
        processing: true,
        colReorder: true,
        rowReorder: true,
        fixedHeader: true,
        deferRender: true,
        scroller: true,
        ordering: true,
        lengthMenu: [[5, 10, 20, 50, 100, 200, 500, -1], [5, 10, 20, 50, 100, 200, 500, 'All']],
        pageLength: 5,
        ajax: {
          type: 'get',
          url: '<?php echo base_url("getproducts"); ?>',
          dataSrc: '',
        },
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
      
      table.on( 'row-reordered', function ( e, diff, edit ) {
        var products = [];
        table.one( 'draw', function () {
          console.log( 'Redraw occurred at: '+new Date().getTime() );
          table.rows().every(function (rowIdx, tableLoop, rowLoop) {
            console.log(rowIdx, this.data());
            //products.push(array(this.data().id,this.data().position));
            var data = {
              productId: this.data().id,
              orderNo: this.data().position
            }
            $.post('<?php echo base_url("updateproductorderno") ?>',data)
          });
          if (products.length > 0) {
          console.log(products);
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
