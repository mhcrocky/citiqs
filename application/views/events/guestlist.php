
<div class="row mt-5 p-4">
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" value="<?php echo $this->language->tline('Add Guest'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal" data-target="#guestlistModal">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                data-toggle="modal" data-target="#guestlistModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i>
            </span>
        </div>
    </div>
</div>

<div class="w-100 mt-3 table-responsive p-4">
    <table id="guestlist" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>



<!-- Add Guestlist Modal -->
<!--
<div class="modal fade" id="guestlistModal" tabindex="-1" role="dialog" aria-labelledby="guestlistModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="addVoucherModalLabel">Add Guest</h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div role="tabpanel">
                    
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#addGuestTab" aria-controls="addGuestTab" role="tab"
                                data-toggle="tab">Add Guest</a>

                        </li>
                        <li role="presentation"><a href="#browseTab" aria-controls="browseTab" role="tab"
                                data-toggle="tab">Upload</a>

                        </li>
                    </ul>
                    
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="addGuestTab">
                            <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST"
                                onsubmit="return addGuest(event)" novalidate>


                                <div class="form-group row">
                                    <label for="guestName" class="col-md-4 col-form-label text-md-left">
                                        Name
                                    </label>
                                    <div class="col-md-6">

                                        <input type="text" id="guestName" class="input-w border-50 form-control"
                                            name="guestName" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-left">
                                        Email
                                    </label>
                                    <div class="col-md-6">

                                        <input type="email" id="guestEmail" class="input-w border-50 form-control"
                                            name="guestEmail" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="guestTickets" class="col-md-4 col-form-label text-md-left">
                                        Tickets
                                    </label>
                                    <div class="col-md-6">

                                        <input type="number" id="guestTickets" class="input-w border-50 form-control"
                                            name="guestTickets" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="guestTicketId" class="col-md-4 col-form-label text-md-left">Ticket
                                    </label>
                                    <div class="col-md-6">
                                        <select id="guestTicketId" name="guestTicketId"
                                            class="form-control input-w border-50 field" required>
                                            <option value="">Select option</option>
                                            <?php #foreach($tickets as $ticket): ?>
                                            <option value="<?php #echo $ticket['ticketId']; ?>">
                                                <?php #echo $ticket['ticketDescription']; ?>
                                            </option>
                                            <?php #endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" id="guestTicketId">
                                <input type="hidden" id="eventId" value="<?php #echo $eventId; ?>">

                                <input type="reset" id="resetGuestForm" class="d-none" value="Reset">
                                <input type="submit" class="d-none" id="submitGuestlist" value="Submit">

                            </form>



                        </div>
                        <div role="tabpanel" class="tab-pane" id="browseTab">browseTab</div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeGuestModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="addGuestForm()" class="btn btn-primary">Add Guest</button>
            </div>
        </div>
    </div>
</div>
-->

<!-- Modal -->
<div class="modal fade text-left" id="guestlistModal" tabindex="-1" role="dialog" aria-labelledby="guestlistModalLabel"
    aria-hidden="true">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row d-flex justify-content-left mr-auto mb-0 pb-0 border-0">
                <div class="tabs active" id="tab01">
                    <h6 class="font-weight-bold">Add Guest</h6>
                </div>
                <div class="tabs" id="tab02">
                    <h6 class="text-muted">Import</h6>
                </div>


            </div>
            <div class="line"></div>
            <div class="modal-body p-0">

                <fieldset class="show" id="tab011">
                    <div class="bg-light">
                        <h5 class="text-center mb-4 mt-0 pt-4">Add Guest</h5>
                        <form name="my-form" id="my-form" class="needs-validation" action="#" method="POST"
                            onsubmit="return addGuest(event)" novalidate>
                            <div class="form-group pb-2 px-3">
                                <input type="text" id="guestName" class="form-control" name="guestName"
                                    placeholder="Name" required>
                            </div>
                            <div class="form-group row pb-2 px-3">
                                <div class="col-6">
                                    <input type="email" id="guestEmail" class="form-control" name="guestEmail"
                                        placeholder="Email" required>
                                </div>
                                <div class="col-6">
                                    <input type="number" id="guestTickets" class="form-control" name="guestTickets"
                                        placeholder="Tickets" required>
                                </div>
                            </div>
                            <div class="form-group pb-2 px-3">
                                <select id="guestTicketId" name="guestTicketId" class="form-control" required>
                                    <option value="">Select ticket</option>
                                    <?php foreach($tickets as $ticket): ?>
                                    <option value="<?php echo $ticket['ticketId']; ?>">
                                        <?php echo $ticket['ticketDescription']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>



                            <input type="hidden" id="guestTicketId">
                            <input type="hidden" id="eventId" value="<?php echo $eventId; ?>">

                            <input type="reset" id="resetGuestForm" class="d-none" value="Reset">
                            <input type="submit" class="d-none" id="submitGuestlist" value="Submit">


                        </form>
                    </div>

                </fieldset>

                <fieldset id="tab021">


                    <form id="fileForm" action="" method="post" class="mt-5" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8 mx-auto">
                                <div class="form-group">
                                    <label for="file" class="sr-only">File</label>
                                    <div class="input-group mx-auto">
                                        <input style="height:40px !important;" type="text" id="filename" name="filename"
                                            class="form-control" value="" placeholder="No file selected" readonly="">
                                        <span class="input-group-btn">
                                            <div style="height:40px;border-top-left-radius: 0 !important;border-bottom-left-radius: 0 !important; padding-top: 8px;"
                                                class="btn btn-secondary custom-file-uploader">
                                                <input type="file" id="userfile" name="userfile"
                                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                                    onchange="this.form.filename.value = this.files.length ? this.files[0].name : ''">
                                                Select a file
                                            </div>
                                        </span>
                                    </div>
                                    <div class="w-100 mt-2 p-1 text-right">
                                        <input type="submit" name="submit" id="upload-file"
                                            class="btn btn-success d-none" value="Upload">
                                        <input type="reset" id="resetUpload" class="btn btn-success d-none"
                                            value="Upload">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="w-100 d-none" id="filterFormSection">
                        <form action="#" method="POST" class="w-100" id="filterForm"
                            onsubmit="return import_csv(event)">
                            <div class="w-100 mt-5" id="DrpDwn">
                                <div class="d-flex col-md-10 align-items-center mb-3 mx-auto">
                                    <label class="col-md-3 mr-3" for="importGuestName">Guest Name: </label>
                                    <select id="importGuestName" name="importGuestName"
                                        class="col-md-9 filterSelection form-control">
                                        <option value="">Select Option</option>
                                    </select>
                                </div>
                                <div class="d-flex col-md-10 align-items-center mb-3 mx-auto">
                                    <label class="col-md-3 mr-3" for="importGuestEmail">Guest Email: </label>
                                    <select id="importGuestEmail" name="importGuestEmail"
                                        class="col-md-9 filterSelection form-control">
                                        <option value="">Select Option</option>
                                    </select>
                                </div>
                                <div class="d-flex col-md-10 align-items-center mb-3 mx-auto">
                                    <label class="col-md-3 mr-3" for="importTickets">Tickets: </label>
                                    <select id="importTickets" name="importTickets"
                                        class="col-md-9 filterSelection form-control">
                                        <option value="">Select Option</option>
                                    </select>
                                </div>
                                <div class="d-flex col-md-10 align-items-center mb-3 mx-auto">
                                    <label class="col-md-3 mr-3" for="importTicketId">Ticket: </label>
                                    <select id="importTicketId" name="importTicketId" class="col-md-9 form-control">
                                        <option value="0">Select ticket</option>
                                        <?php foreach($tickets as $ticket): ?>
                                        <option value="<?php echo $ticket['ticketId']; ?>">
                                            <?php echo $ticket['ticketDescription']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>

                        </form>


                    </div>

                    <pre class="d-none" id="jsonData"></pre>


                </fieldset>
            </div>
            <div class="line"></div>
            <div class="modal-footer">
                <fieldset class="show" id="tab012">
                    <button type="button" id="closeGuestModal" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="button" onclick="addGuestForm()" class="btn btn-primary">Add Guest</button>
                </fieldset>
                <fieldset id="tab022">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="uploadExcel" class="btn btn-primary">Upload
                        File</button>
                    <button type="submit" onclick="importExcelFile()" id="importExcelFile"
                        class="btn btn-primary d-none">Import Excel File</button>
                </fieldset>
            </div>
        </div>
    </div>
</div>
