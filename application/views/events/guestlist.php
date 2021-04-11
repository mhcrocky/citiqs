
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
                        <label for="guestTicketId" class="col-md-4 col-form-label text-md-left">Agenda
                        </label>
                        <div class="col-md-6">
                            <select id="guestTicketId" name="guestTicketId" class="form-control input-w border-50 field" required>
                                <option value="">Select option</option>
                                <?php foreach($tickets as $ticket): ?>
                                <option value="<?php echo $ticket['ticketId']; ?>">
                                <?php echo $ticket['ticketDescription']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" id="guestTicketId">
                    <input type="hidden" id="eventId" value="<?php echo $eventId; ?>">

                    <input type="reset" id="resetGuestForm" class="d-none" value="Reset">
                    <input type="submit" class="d-none" id="submitGuestlist" value="Submit">

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeGuestModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="addGuestForm()" class="btn btn-primary">Add Guest</button>
            </div>
        </div>
    </div>
</div>

