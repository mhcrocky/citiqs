<style>
tr:nth-of-type(even) {
    background-color: #fffff2 !important;
}

tr:nth-of-type(odd) {
    background-color: #f2f2f2 !important;
}

.table-striped thead tr:nth-of-type(odd) {
    background-color: #fffff2 !important;
}
.table-striped tfoot tr:nth-of-type(odd) {
    background-color: #fffff2 !important;
}
</style>
<div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable">
    <div class="float-right text-center pl-3">
        <input style="width: 330px;" class="date form-control-sm mb-2" type="text" name="datetimes" />
        <select style="width: 264px;font-size: 14px;"
            class="custom-select custom-select-sm form-control form-control-sm  mb-1 " id="serviceType">
            <option value="">Choose Service Type</option>
            <option value="local">Local</option>
            <option value="delivery">Delivery</option>
            <option value="pickup">Pickup</option>

        </select>
    </div>
    <div class="w-100 mt-5 mx-auto">
        <div class="col-md-12 mt-5 pt-5 mb-2">
            <main class="query-main" class="p-3 mt-5" role="main">
                <div class="w-100 text-right p-3 mt-1">
                    <button class="btn btn-success" data-toggle="modal" data-target="#queryModal">Set a
                        query</button>
                    <button class="btn btn-success ml-3" data-toggle="modal" data-target="#descriptModal"><i
                            style="font-size: 12px;" class="ti-plus"></i> Add descript</button>
                </div>
                <div id="query-builder"></div>
                <div class="w-100 text-right p-3">
                    <button class="btn btn-primary parse-json">Run the query</button>
                    <button id="saveResults" class="btn btn-primary ml-2">Save Results</button>
                </div>
                <button type="button" class="collapsible">Open Saved Queries</button>
                <div class="content form">
                    <?php foreach($queries as $query): ?>
                    <div id="inputGroup<?php echo $query['id']; ?>" class="inputGroup">
                        <input id="radio<?php echo $query['id']; ?>" name="query" type="radio"
                            value="<?php echo htmlspecialchars_decode($query['value']); ?>">
                        <label style="padding-left: 30px;padding-right: 70px;"
                            for="radio<?php echo $query['id']; ?>"><span
                                id="label<?php echo $query['id']; ?>"><?php echo $query['query']; ?></span>
                            <div class="text-right p-3">
                                <button class="btn btn-secondary ml-2" onclick="editModal(<?php echo $query['id']; ?>)"
                                    data-toggle="modal"
                                    data-target="#editQueryModal<?php echo $query['id']; ?>">Edit</button>
                                <button class="btn btn-danger ml-2"
                                    onclick="deleteQuery(<?php echo $query['id']; ?>)">Delete</button>
                            </div>
                    </div>
                    <!-- Edit query -->
                    <div class="modal fade" id="editQueryModal<?php echo $query['id']; ?>" tabindex="-1" role="dialog"
                        aria-labelledby="editQueryModal<?php echo $query['id']; ?>Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editQueryModal<?php echo $query['id']; ?>Label">Edit
                                        query</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-check-label" for="">
                                        Query:
                                    </label>
                                    <textarea class="form-control" id="query-text<?php echo $query['id']; ?>"
                                        placeholder="Add query description..."><?php echo $query['query']; ?></textarea>
                                    <main class="query-main" class="p-3 mt-5 pt-4" role="main">

                                        <div class="mt-5" id="query<?php echo $query['id']; ?>"></div>
                                    </main>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary"
                                        onclick="editQuery(<?php echo $query['id']; ?>)"
                                        data-dismiss="modal">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="query" id="<?php echo $query['id']; ?>"
                            value="<?php echo htmlspecialchars_decode($query['value']); ?>">
                        <label style="font-size: 14px;" class="form-check-label" for="">
                            <?php echo $query['query']; ?>
                        </label>
                    </div> -->
                    <?php endforeach; ?>


                </div>
            </main>
        </div>

    </div>
</div>

<div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable">
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


<!-- Add Description Modal -->
<div class="modal fade" id="descriptModal" tabindex="-1" role="dialog" aria-labelledby="descriptModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="descriptModalLabel">Add description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="description" placeholder="Add description..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Save description</button>
            </div>
        </div>
    </div>
</div>

<!-- Set a query -->
<div class="modal fade" id="queryModal" tabindex="-1" role="dialog" aria-labelledby="queryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="queryModalLabel">Set a query</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="form-check-label" for="">
                    Query:
                </label>
                <textarea class="form-control" id="query-text" placeholder="Add query description..."></textarea>
                <main class="query-main" class="p-3 mt-5 pt-4" role="main">

                    <div class="mt-5" id="query"></div>
                </main>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveQuery()" data-dismiss="modal">Save</button>
            </div>
        </div>
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
<script src="<?php echo base_url(); ?>assets/home/js/targetingDataTable.js"></script>