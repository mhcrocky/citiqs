<style>
.collapsible {
    background-color: #2d92cc;
    color: white;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
}

.active,
.collapsible:hover {
    background-color: #3c94c7;
}

.content {
    padding: 0 18px;
    display: none;
    overflow: hidden;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">



<style>
.inputGroup {
    background-color: #fff;
    display: block;
    margin: 10px 0;
    position: relative;
}

.inputGroup label {
    padding: 12px 30px;
    width: 100%;
    display: block;
    text-align: left;
    color: #3C454C;
    cursor: pointer;
    position: relative;
    z-index: 2;
    transition: color 200ms ease-in;
    overflow: hidden;
}

.inputGroup label:before {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    content: "";
    background-color: #5562eb;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%) scale3d(1, 1, 1);
    transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    z-index: -1;
}

.inputGroup label:after {
    width: 32px;
    height: 32px;
    content: "";
    border: 2px solid #D1D7DC;
    background-color: #fff;
    background-image: url("data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E ");
    background-repeat: no-repeat;
    background-position: 2px 3px;
    border-radius: 50%;
    z-index: 2;
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    transition: all 200ms ease-in;
}

.inputGroup input:checked~label {
    color: #fff;
}

.inputGroup input:checked~label:before {
    transform: translate(-50%, -50%) scale3d(56, 56, 1);
    opacity: 1;
}

.inputGroup input:checked~label:after {
    background-color: #54E0C7;
    border-color: #54E0C7;
}

.inputGroup input {
    width: 32px;
    height: 32px;
    order: 1;
    z-index: 2;
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    visibility: hidden;
}

.form {
    padding: 0 16px;
    max-width: 550px;
    margin: 50px auto;
    font-size: 18px;
    font-weight: 600;
    line-height: 36px;
}

body {
    background-color: #D1D7DC;
    font-family: "Fira Sans", sans-serif;
}

*,
*::before,
*::after {
    box-sizing: inherit;
}

html {
    box-sizing: border-box;
}

code {
    background-color: #9AA3AC;
    padding: 0 8px;
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
                    <div class="inputGroup">
                        <input id="radio<?php echo $query['id']; ?>" name="query" type="radio"
                            value="<?php echo htmlspecialchars_decode($query['value']); ?>">
                        <label style="padding-left: 30px;padding-right: 70px;"
                            for="radio<?php echo $query['id']; ?>"><?php echo $query['query']; ?>
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
<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
            content.style.display = "none";
        } else {
            content.style.display = "block";
        }
    });
}

function editModal(id) {
    var options = {
        allow_empty: true,
        filters: [{
                id: 'tbl_shop_products_extended.price',
                label: 'Price',
                type: 'integer',
                class: 'price',
                // optgroup: 'core',
                default_value: '',
                size: 30,
                unique: true
            },
            {
                id: 'AMOUNT',
                label: 'Amount',
                type: 'integer',
                class: 'amount',
                // optgroup: 'core',
                default_value: '',
                size: 30,
                unique: true
            },
            {
                id: 'tbl_shop_orders.old_order',
                label: 'Old Order',
                type: 'integer',
                class: 'old_order',
                // optgroup: 'core',
                default_value: '',
                size: 30,
                unique: true
            },
            {
                id: 'tbl_shop_orders.waiterTip',
                label: 'WaiterTip',
                type: 'integer',
                class: 'waitertip',
                // optgroup: 'core',
                default_value: '',
                size: 30,
                unique: true
            },
            {
                id: 'tbl_shop_orders.serviceFee',
                label: 'ServiceFee',
                type: 'integer',
                class: 'servicefee',
                // optgroup: 'core',
                default_value: '',
                size: 30,
                unique: true
            },
            {
                id: 'tbl_shop_order_extended.quantity',
                label: 'Quantity',
                type: 'integer',
                class: 'quantity',
                // optgroup: 'core',
                default_value: '',
                size: 30,
                unique: true
            },
        ]
    };

    $('#query' + id).queryBuilder(options);

}

function editQuery(id) {
    var query_text = $("#query-text" + id).val();
    var query = $('#query').queryBuilder('getSQL', false, true).sql;
    var sql;
    var data;
    if (query == "") {
        data = {
            id: id,
            query: query_text,
        };
    } else {
        sql = query.replace(/\n/g, " ");
        sql = "AND (" + sql + ")";
        data = {
            id: id,
            query: query_text,
            value: sql
        };
    }

    $.ajax({
        type: 'post',
        url: '<?php echo base_url(); ?>marketing/targeting/edit_query',
        data: data,
        success: function() {
            location.reload();
        }
    });

}

function saveQuery() {
    var query_text = $("#query-text").val();
    var query = $('#query').queryBuilder('getSQL', false, true).sql;
    sql = query.replace(/\n/g, " ");
    sql = "AND (" + sql + ")";
    var data = {
        query: query_text,
        value: sql
    };
    $.ajax({
        type: 'post',
        url: '<?php echo base_url(); ?>marketing/targeting/save_query',
        data: data,
        success: function() {
            location.reload();
        }
    });

}

function deleteQuery(id) {
    if (window.confirm("Are you sure?")) {
        var data = {
            id: id
        };
        $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>marketing/targeting/delete_query',
            data: data,
            success: function() {
                location.reload();
            }
        });
        //location.reload();
    }
}

function deleteQuer(id) {
    var data = {
        id: id
    };
    $.ajax({
        type: 'post',
        url: '<?php echo base_url(); ?>marketing/targeting/delete_query',
        data: data,
        success: function() {
            location.reload();
        }
    });

}
</script>