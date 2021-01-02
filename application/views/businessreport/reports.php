<div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable">
    <div class="float-right text-center pl-3">
        <input style="width: 330px;" class="date form-control-sm mb-2" type="text" name="datetimes" />
        <select style="width: 264px;font-size: 14px;"
            class="custom-select custom-select-sm form-control form-control-sm  mb-1 " id="serviceType">
            <option value="">Choose Service Type</option>
            <?php foreach ($service_types as $service_type): ?>
            <option id="<?php echo $service_type['id']; ?>" value="<?php echo $service_type['type']; ?>">
                <?php echo ucfirst($service_type['type']); ?></option>
            <?php endforeach;?>
        </select>
    </div>
</div>
<div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable">
    <div class="w-100 mt-3 mb-3 mx-auto">
        <div class="col-md-12 mb-4">
            <main class="query-main" class="p-3" role="main">
                <div id="query-builder"></div>
                <div class="w-100 text-right p-3">
                    <button class="btn btn-primary parse-json">Run the query</button>
                </div>
            </main>
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
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <div id="tbl_data">

        </div>

    </div>
    <table style="display: none;" id="total-percentage" class="table table-striped table-bordered mt-3" cellspacing="0"
        width="100%">

    </table>
</div>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.table2excel.js"></script>
<script src="<?php echo base_url(); ?>assets/js/query-builder.standalone.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/dashboardDataTable.js"></script>