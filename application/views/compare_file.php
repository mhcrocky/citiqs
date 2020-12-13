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

  <?php if(isset($diff_order_ids)): ?>
  <table style="display:none" id="tbl_data">
  <thead>
    <tr>
      <th colspan="2"><b style="text-align: center;">Missing on database</b></th>
      <th>&nbsp</th>
      <th>&nbsp</th>
      <th>&nbsp</td>
      <th>&nbsp</th>
      <th>&nbsp</th>
      <th>&nbsp</th>
      <th colspan="3"><b style="text-align: center;">Found on database</b></th>
    </tr>
    <tr>
      <th><b>Order ID</b></th>
      <th><b>Price</b></th>
      <th>&nbsp</th>
      <th>&nbsp</th>
      <th>&nbsp</td>
      <th>&nbsp</th>
      <th>&nbsp</th>
      <th>&nbsp</th>
      <th><b>Order ID</b></th>
      <th><b>Old Price</b></th>
      <th><b>New Price</b></th>
      <th><b>Difference</b></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($diff_order_ids as $diff_order_id): ?>
    <tr>
      <td><?php echo $diff_order_id; ?></td>
      <td><?php echo $prices[$diff_order_id]; ?></td>
      <?php $prices[$diff_order_id] = 0; ?>
    <?php endforeach; ?>
    <?php foreach($order_ids as $key => $order_id): ?>
      <?php if($key >= count($diff_order_ids) ): ?>
        <td>&nbsp</td>
        <td>&nbsp</td>
      <?php endif; ?>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td><?php echo $order_id; ?></td>
      <td><?php echo $prices[$order_id]; ?></td>
      <td><?php echo $new_prices[$order_id]; ?></td>
      <td>
      <?php
        $diff = $prices[$order_id] - $new_prices[$order_id]; 
        echo $diff;
        ?>
      </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td>&nbsp</td>
      <td><b>Total:</b></td>
      <td><?php echo array_sum(array_values($prices));?></td>
      <td><?php echo array_sum(array_values($new_prices));?></td>
      <td><?php echo (array_sum(array_values($prices)) - array_sum(array_values($new_prices)));?></td>
    </tr>
    </tfoot>
  </table>
      <div class="col col-md-12">
        <?php foreach($diff_order_ids as $diff_order_id): ?>
           <p>Order ID: <?php echo $diff_order_id;?> is missing on database</p>
        <?php endforeach; ?>
        </div>
  <?php endif; ?>
  
</div>
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
			filename: "Missing on database.xls",
			fileext: ".xls",
			exclude_img: true,
			exclude_links: true,
			exclude_inputs: true
		});
    
  }
});
</script>
  
  
  
