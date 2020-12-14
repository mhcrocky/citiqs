<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<style>
.custom-file-uploader {
  position: relative;
}

.custom-file-uploader input[type='file'] {
  display: block;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 5;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: default;
}
</style>


<div class="container">
  <header class="page-header">
    <h4 class="text-dark">Compare file with database</h4>
    <h1></h1>
  </header>

  <form id="fileForm" action="" method="post" enctype="multipart/form-data">
    
    <div class="row">
      <div class="col-sm-6 col-md-5 col-lg-4">

        <div class="form-group">
          <label for="file" class="sr-only">File</label>
          <div class="input-group">
            <input type="text" id="filename" name="filename" class="form-control" value="" placeholder="No file selected" readonly="">
            <span class="input-group-btn">
              <div class="btn btn-default  custom-file-uploader">
                <input type="file" id="file" name="userfile" onchange="this.form.filename.value = this.files.length ? this.files[0].name : ''">
                Select a file
              </div>
            </span>
          </div>
          <div class="w-100 mt-2 p-1 text-right">
            <input type="submit" name="submit" class="btn btn-success" value="Compare">
          </div>
        </div>

      </div>
    </div>
  
  </form>

  <?php if(isset($csv_orders)): ?>
  <table style="display:none" id="tbl_data">
  <thead>
    <tr>
      <th>&nbsp</th>
      <th colspan="4"><b>Comparison between CSV and DB</b></th>
    </tr>
    <tr>
      <th>&nbsp</th>
      <th><b>Order ID</b></th>
      <th><b>CSV Price</b></th>
      <th><b>DB Price</b></th>
      <th><b>Difference</b></th>
    </tr>
    </thead>
    <tbody>
   <?php  
      $total_csv_amount = 0;
      $total_db_amount = 0;
      foreach($db_orders as $db_order):
        $total_csv_amount = $total_csv_amount + $db_order['csv_price'];
        $total_db_amount = $total_db_amount + $db_order['db_price'];
    ?>
    <tr>
    <?php /*
        if(count($diff_order_ids) > $key):
          $diff_order_id = $diff_order_ids[$key];
          unset($prices[$diff_order_id]); 
        endif; 
        */
    ?>
      <td>&nbsp</td>
      <td><?php echo $db_order['order_id']; ?></td>
      <td><span>€ </span><?php echo num_format($db_order['csv_price']); ?></td>
      <td><span>€ </span><?php echo num_format($db_order['db_price']); ?></td>
      <td><span>€ </span>
      <?php
        $diff = $db_order['csv_price'] - $db_order['db_price']; 
        echo num_format($diff);
        ?>
      </td>
    </tr>
      <?php endforeach; ?>
    <?php
      $total_csv_amount_2 = 0;
      foreach($csv_orders as $csv_order):
        $total_csv_amount_2 = $total_csv_amount_2 + $csv_order['price'];
      ?>
      <tr>
      <td>&nbsp</td>
      <td><?php echo num_format($csv_order['order_id']); ?></td>
      <td><span>€ </span><?php echo num_format($csv_order['price']); ?></td>
      <td><span>€ </span>-</td>
      <td><span>€ </span>-</td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
      <td>&nbsp</td>
      <td><b>Total:</b></td>
      <?php 

        $total_diff = ($total_csv_amount+$total_csv_amount_2) - $total_db_amount;
      ?>
      <td><span>€ </span><?php echo num_format($total_csv_amount+$total_csv_amount_2); ?> (<span>€ </span><?php echo num_format($total_csv_amount);?>)</td>
      <td><span>€ </span><?php echo num_format($total_db_amount);?></td>
      <td><span>€ </span><?php echo num_format($total_diff);?></td>
    </tr>
    </tfoot>
  </table>
      <div class="col col-md-12">
        <?php foreach($csv_orders as $csv_order): ?>
           <p>Order ID: <?php echo $csv_order['order_id'];?> is missing on database</p>
        <?php endforeach; ?>
        </div>
  <?php endif; ?>
  
</div>
<?php 
function num_format($num){
  if(strpos($num, '.') !== false){
    $num = number_format($num , 2 , "," , "");
  }
  return $num;
}
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.table2excel.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $("#fileForm").on("submit", function(e){
    let filename = $("#filename").val();
    let file = filename.split(".");
    let ext = file[1];
    if(ext != 'csv' && ext != 'CSV'){
      e.preventDefault();
      alertify['error']('The filetype you are attempting to upload is not allowed!');
    }
        
  });

  if($("#tbl_data").html()){
    let thead = '<thead><tr>'+$("#tbl_data thead tr").html() + ' '+ $("#report thead tr").html()+'</tr></thead>';
    let tbody = '<tbody><tr>'+$("#tbl_data tbody tr").html() + ' '+ $("#report tbody tr").html()+'</tr></tbody>';
    let html = '<table>' + $("#tbl_data").html() + '</table>';
    $(html).table2excel({
      exclude: ".noExl",
			name: "Excel Document Name",
			filename: "Difference between CSV file and DB.xls",
			fileext: ".xls",
			exclude_img: true,
			exclude_links: true,
			exclude_inputs: true
		});
    
  }
});
</script>
  
  
  
