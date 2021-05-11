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
