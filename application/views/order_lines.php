<script src='https://code.jquery.com/jquery-1.12.3.js'></script>
<script src='https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js'></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js" charset="utf-8"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />

<script type="text/javascript" src="DataTables/datatables.min.js"></script>
<style>
    #ordersList_wrapper > div:nth-child(3){
        width:100%;
    }
    #ordersList td, #ordersList th {
        text-align: center;
    }
    .swal-wide{
        width:850px !important;
    }
</style>
<?php #echo 'here'; exit;?>
<main class="row" style="margin:0px 20px">
    <h1 style="margin:70px 0px 20px 0px">Invoices list</h1>
    <!-- <div style="margin:140px 0px 20px 0px">
        <label for="orderStatus">Filter orders by printer:</label>
        <?php if (!empty($printers)) { ?>
        <select id="selectedPrinter" class="custom-select" onchange="destroyAndFetch()">
            <option value="">All</option>
            <?php foreach ($printers as $printer) { ?>
                <option value="<?php echo $printer['id']; ?>"><?php echo $printer['printer']; ?></option>
            <?php } ?>
        </select>
        <?php } ?>
    </div>
    <div style="margin:140px 0px 20px 0px">
        <label for="orderStatus">Filter orders by status:</label>
        <select id="orderStatus" class="custom-select" onchange="destroyAndFetch()">
            <option value="">All (incl finished)</option>
            <?php foreach ($ordersStatuses as $status) { ?>
                <option value="<?php echo $status; ?>"><?php echo ucfirst($status); ?></option>
            <?php } ?>
        </select>
    </div>
    <div style="margin:173px 0px 20px 10px">
        <button type="button" class="btn btn-primary" onclick="destroyAndFetch()">Reload page</button>
    </div> -->
    <div class="table-responsive col-sm-12" style="margin-top:20px">
        <table id="ordersList" class="display table table-hover table-striped datatables" style="width:100%">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Products</th>
                    <th>Products Total</th>
                    <th>Products Vat</th>
                    <th>Products ExVat</th>
                    <th>Service Fee</th>
                    <th>Amount</th>
                    <th>Order status</th>
                    <th>Created</th>
                    <th>Buyer</th>
                    <th>Buyer Email</th>
                    <th>Buyer ID</th>
                    <th>Export</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($invoices as $invoice){?>
                    <tr>
                        <td>
                            <?php echo $invoice->orderId; ?>
                        </td>
                        <td>
                            <?php echo $invoice->productName; ?>
                        </td>
                        <td>
                            <?php echo $invoice->productlinetotal; ?>
                        </td>
                        <td>
                            <?php echo $invoice->productVat; ?>
                        </td>
                        <td>
                            <?php echo $invoice->EXVAT; ?>
                        </td>
                        <td>
                            <?php echo $invoice->servicefee; ?>
                        </td>
                        <td>
                            <?php echo $invoice->orderAmount; ?>
                        </td>
                        <td>
                            <?php
                                if($invoice->orderPaidStatus == 1){
                                    echo 'Paid';
                                }else{
                                    echo 'Pending';
                                }
                                ?>
                        </td>
                        <td>
                            <?php echo $invoice->createdAt; ?>
                        </td>
                        <td>
                            <?php echo $invoice->buyerUserName; ?>
                        </td>
                        <td>
                            <?php echo $invoice->buyerEmail; ?>
                        </td>
                        <td>
                            <?php echo $invoice->buyerEmail; ?>
                        </td>
                        <td>
                            <button type="button" onclick="export_invoice(<?php echo $invoice->orderId; ?>)" class="btn <?php if($invoice->export_ID!=''){echo 'btn-warning';}else{echo 'btn-primary';}?> btn-primary export-<?php echo $invoice->orderId; ?>" <?php if($invoice->export_ID!=''){echo 'disabled';}?>><?php if($invoice->export_ID!=''){echo 'Exported';}else{echo 'Export';}?></button>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</main>
<script>
    var base_url = '<?php echo base_url()?>';
    function export_invoice(id){
        $('.export-'+id).text('Processing...');
        $.get(base_url+'visma/export/'+id,
           function (data, textStatus, jqXHR) {
                response = JSON.parse(data);
                console.log(response);
                if(response.status=='200'){
                    $('.export-'+id).text('Exported');
                    $('.export-'+id).removeClass('btn-primary');
                    $('.export-'+id).addClass('btn-warning');
                    $('.export-'+id).attr( "disabled", "disabled" );
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
    $(document).ready(function () {
        $('#ordersList').DataTable();

    });
    var orderGlobals = (function(){
        let getRemarks = '<?php echo $getRemarks; ?>' === '1' ? true : false;
        let globals = {
            'orderStatuses' : JSON.parse('<?php echo json_encode($orderStatuses) ?>'),
            'tableId' : 'orders',
            'vendorName' : '<?php echo $vendor; ?>',
            'getRemarks' : getRemarks,
        }
        Object.freeze(globals);
        return globals;
    }());
</script>
