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
                    <?php foreach($queries as $query): 
                        $query_id = $query['id'];
                        if(isset($cronJobs[$query_id])){
                            $cronJob = $cronJobs[$query_id];
                        } else if(isset($cronJob)){
                            unset($cronJob);
                        }
                        ?>
                    <div class="row mx-auto query">
                        <div id="inputGroup<?php echo $query['id']; ?>" class="inputGroup col-lg-8">
                            <input id="radio<?php echo $query['id']; ?>" name="query" type="radio"
                                value="<?php echo htmlspecialchars_decode($query['value']); ?>">
                            <label style="padding-left: 30px;padding-right: 70px;"
                                for="radio<?php echo $query['id']; ?>"><span
                                    id="label<?php echo $query['id']; ?>"><?php echo $query['query']; ?></span>
                                <div class="text-right">

                                </div>

                        </div>
                        <div class="col-lg-4 mt-2 text-right">
                            <button class="btn btn-secondary ml-2 mb-1" onclick="editModal(<?php echo $query['id']; ?>)"
                                data-toggle="modal"
                                data-target="#editQueryModal<?php echo $query['id']; ?>">Edit</button>
                            <button class="btn btn-danger ml-2 mb-1"
                                onclick="deleteQuery(<?php echo $query['id']; ?>)">Delete</button>
                            <button class="btn btn-primary ml-2 mb-1" data-toggle="modal"
                                data-target="#queryOptionsModal<?php echo $query['id']; ?>"><?php echo (isset($cronJob)) ? 'Edit' : 'Add'; ?>
                                CRON</button>
                        </div>
                    </div>
                    <hr class="w-100 fade">
                    <!-- Add Query Options Modal -->
                    <div class="modal fade" id="queryOptionsModal<?php echo $query['id']; ?>" tabindex="-1"
                        role="dialog" aria-labelledby="queryOptionsModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="queryOptionsModalLabel">Add query options</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <label class="font-weight-bold mt-2" for="">
                                        Run:
                                    </label>
                                    <select style="height: 44px" class="form-control"
                                        id="run<?php echo $query['id']; ?>">
                                        <option value="daily"
                                            <?php echo (isset($cronJob) && $cronJob['run'] == 'daily')  ? 'selected' : ''; ?>>
                                            daily</option>
                                        <option value="weekly"
                                            <?php echo (isset($cronJob) && $cronJob['run'] == 'weekly')  ? 'selected' : ''; ?>>
                                            weekly</option>
                                        <option value="monthly"
                                            <?php echo (isset($cronJob) && $cronJob['run'] == 'monthly')  ? 'selected' : ''; ?>>
                                            monthly</option>
                                    </select>

                                    <label class="font-weight-bold mt-3" for="">
                                        Seconds (0-59):
                                    </label>
                                    <input type="text" class="form-control" name="seconds"
                                        id="seconds<?php echo $query['id']; ?>"
                                        value="<?php echo isset($cronJob) ? $cronJob['seconds'] : ''; ?>">

                                    <label class="font-weight-bold mt-3" for="">
                                        Minutes (0-59):
                                    </label>
                                    <input type="text" class="form-control" name="minutes"
                                        id="minutes<?php echo $query['id']; ?>"
                                        value="<?php echo isset($cronJob) ? $cronJob['minutes'] : ''; ?>">

                                    <label class="font-weight-bold mt-3" for="">
                                        Hours (0-59):
                                    </label>
                                    <input type="text" class="form-control" name="hours"
                                        id="hours<?php echo $query['id']; ?>"
                                        value="<?php echo isset($cronJob) ? $cronJob['hours'] : ''; ?>">

                                    <label class="font-weight-bold mt-3" for="">
                                        Day-of-month (optional, 1-31):
                                    </label>
                                    <input type="text" class="form-control" name="dayofmonth"
                                        id="dayofmonth<?php echo $query['id']; ?>"
                                        value="<?php echo isset($cronJob) ? $cronJob['day_of_month'] : ''; ?>">

                                    <label class="font-weight-bold mt-3" for="">
                                        Month (1-12 or JAN-DEC):
                                    </label>
                                    <input type="text" class="form-control" name="month"
                                        id="month<?php echo $query['id']; ?>"
                                        value="<?php echo isset($cronJob) ? $cronJob['month'] : ''; ?>">

                                    <label class="font-weight-bold mt-3" for="">
                                        Day-of-week (1-7 or SUN-SAT):
                                    </label>
                                    <input type="text" class="form-control" name="dayofweek"
                                        id="dayofweek<?php echo $query['id']; ?>"
                                        value="<?php echo isset($cronJob) ? $cronJob['day_of_week'] : ''; ?>">

                                    <label class="font-weight-bold mt-3" for="">
                                        Year (optional):
                                    </label>
                                    <input type="text" class="form-control" name="year"
                                        id="year<?php echo $query['id']; ?>"
                                        value="<?php echo isset($cronJob) ? $cronJob['year'] : ''; ?>">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="saveCRON(<?php echo $query['id']; ?>)"
                                        class="btn btn-primary" data-dismiss="modal">Save
                                        CRON</button>
                                </div>
                            </div>
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
                                    <button type="button" class="close" id="closeEditQueryModal" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-check-label" for="">
                                        Query:
                                    </label>
                                    <textarea class="form-control query-text" id="query-text<?php echo $query['id']; ?>"
                                        placeholder="Add query description..." minlength="3"
                                        required="required"><?php echo $query['query']; ?></textarea>
                                    <div style="margin-top: 10px;" class="w-100 query-error"
                                        id="query-text-error-<?php echo $query['id']; ?>"></div>
                                    <main class="query-main" class="p-3 mt-5 pt-4" role="main">

                                        <div class="mt-5" id="query<?php echo $query['id']; ?>"></div>
                                    </main>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary"
                                        onclick="editQuery(<?php echo $query['id']; ?>)">Save</button>
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
                <button type="button" class="close" id="closeQueryModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="form-check-label" for="">
                    Query:
                </label>
                <textarea class="form-control query-text" id="query-text" minlength="3"
                    placeholder="Add query description..." required="required"></textarea>
                <div style="margin-top: 10px;" class="w-100 query-error" id="query-text-error"></div>
                <main class="query-main" class="p-3 mt-5 pt-4" role="main">

                    <div class="mt-5" id="query"></div>
                </main>
                <div style="margin-top: 10px;" class="w-100" id="empty-query"></div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveQuery()">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js">
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.table2excel.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/query-builder.standalone.js"></script>
    <script src="<?php echo base_url(); ?>assets/home/js/targetingDataTable.js"></script>