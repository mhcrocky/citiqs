<div style="justify-content: space-between;" class="row mt-5 p-4">
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
    <div class="col-md-2 mb-3">
        <a href="<?php echo base_url(); ?>events">
            <div class="input-group">
                <input type="button" value="<?php echo $this->language->tline('Go Back'); ?>"
                    style="background: #10b981 !important;border-radius:0;height:45px;"
                    class="btn btn-primary form-control mb-3 text-left" data-toggle="modal"
                    data-target="#guestlistModal">
                <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                    data-toggle="modal" data-target="#guestlistModal">
                    <i style="color: #fff;font-size: 18px;" class="ti ti-arrow-left"></i>
                </span>

            </div>
        </a>
    </div>
</div>

<div class="w-100 mt-3 table-responsive p-4">
    <table id="guestlist" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>

<div class="row mt-5 p-4">
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" onclick="saveMultipleTicketsPdf()"
                value="<?php echo $this->language->tLine('Download Multiple Emails'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left">
            <span onclick="saveMultipleTicketsPdf()" style="background: #275C5D; padding-top: 14px;"
                class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-envelope"></i>
            </span>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button" onclick="confirmDelete(0, true)"
                value="<?php echo $this->language->tline('Delete Selected Guests'); ?>"
                style="background: #d9534f !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left">
            <span onclick="confirmDelete(0, true)" style="background: #6b1d18; padding-top: 14px;"
                class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-trash"></i>
            </span>
        </div>
    </div>

</div>




<!-- Add Guest Modal -->
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
                                    <?php if(!empty($tickets)) : ?>
                                    <?php foreach($tickets as $ticket): ?>
                                    <option value="<?php echo $ticket['ticketId']; ?>">
                                        <?php echo $ticket['ticketDescription']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
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


                    <form id="fileForm" action="" method="post" class="mt-5 upload-excel-file" enctype="multipart/form-data">
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


                    <div class="w-100 filterFormSection d-none" id="filterFormSection">
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
                    <button type="button" id="uploadExcel" class="btn btn-primary upload-excel-file">Upload
                        File</button>
                    <button type="button" onclick="goBackToUpload()" class="btn btn-warning filterFormSection d-none">Go Back</button>
                    <button type="submit" onclick="importExcelFile()" id="importExcelFile"
                        class="btn btn-primary filterFormSection d-none">Import Excel File</button>
                </fieldset>
            </div>
        </div>
    </div>
</div>



<!-- Generate PDF -->
<div style="opacity: 0; position: fixed; top:0; z-index: -1;">
    <div id="HTMLtoPDF">
	    <div class="pages">
		    <p>Page 1</p>
		</div>
		<div class="pages">
		    <p>Page 2</p>
		</div>
    </div>

</div>
<!-- End Generate PDF -->