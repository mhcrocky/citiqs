<!-- Ticket Options Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editModalLabel">Edit Ticket - <span id="ticketOptionTitle"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editTicketOptions" name="editTicketOptions" action="#"
                    onsubmit="return saveTicketOptions(event)" method="POST">
                    <ul class="d-none">
                        <li>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="guestTicketCheck" type="checkbox"
                                    checked="checked">
                                <label class="custom-control-label font-weight-bold text-dark" for="guestTicketCheck">
                                    Can be used as guest ticket
                                </label>
                            </div>
                        </li>
                        <!--
                    <li>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="ticketSwapCheck" type="checkbox" checked="checked">
                            <label class="custom-control-label font-weight-bold text-dark" for="ticketSwapCheck">
                                Ticket can be swapped on Ticketswap
                            </label>
                        </div>
                    </li>
                    
                    <li>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="partialAccessCheck" type="checkbox"
                                checked="checked">
                            <label class="custom-control-label font-weight-bold text-dark" for="partialAccessCheck">
                                Partial access during event
                            </label>
                        </div>
                    </li>
                    -->
                    </ul>

                    <hr class="w-100 mt-3 mb-3 d-none">
                    <div style="flex-wrap: nowrap" class="row">
                        <div class="col-md-3 text-dark">
                            <h3 class="font-weight-bold text-dark">Ticketfee per ticket</h3>
                        </div>
                        <div class="col-md-3">
                            <select id="ticketCurrency" style="height: 35px !important;padding-top: 6px;"
                                class="form-control input-w mt-2">
                                <option value="euro" selected>€ - EUR</option>
                                <option value="usd">$ - USD</option>
                            </select>
                            <input type="hidden" id="ticketCurrencyVal" name="ticketCurrency" value="euro">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 text-dark">Fee to your customer</div>
                        <div class="col-md-3">
                            <input type="text" id="nonSharedTicketFee" name="nonSharedTicketFee"
                                class="form-control inp-height" min="0" step="0.01" value="<?php echo number_format(floatval($vendorTicketFee), 2); ?>">
                        </div>
                        <!--
                    <div class="col-md-3">Shared ( Min 0.00 )</div>
                    <div class="col-md-3">
                        <input type="number" id="sharedTicketFee" name="sharedTicketFee" class="form-control inp-height" min="1" value="1">
                    </div>
                    -->
                    </div>
                    <!--
                <div class="row">
                    <div class="col-md-3 text-dark">Max Discount</div>
                    <div class="col-md-3">
                        <input type="number" id="maxDiscount" name="maxDiscount" class="form-control inp-height" min="1"
                            value="1">
                    </div>
                </div>
                -->
                    <div class="row mb-2">
                        <div class="col-md-3 text-dark">
                            Voucher
                        </div>
                        <div class="col-md-3">
                            <select id="voucherId" name="voucherId" style="height: 35px !important;padding-top: 6px;"
                                class="form-control input-w">
                                <option value="0">Select option</option>
                                <?php if(!empty($vouchers) && count($vouchers) > 0): ?>
                                <?php foreach($vouchers as $voucher): ?>
                                <option value="<?php echo $voucher['id']; ?>">
                                    <?php echo $voucher['template_name'] .' ('. $voucher['description'] . ')'; ?>
                                </option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>


                    <div class="row mb-2">
                        <div class="col-md-3 text-dark">Description Title</div>
                        <div class="col-md-3">
                            <input type="text" id="descriptionTitle" name="descriptionTitle" class="form-control inp-height" value="description">
                        </div>
                    </div>


                    <div class="row mb-2">
                        <div class="col-md-3 text-dark">Max Booking</div>
                        <div class="col-md-3">
                            <input type="number" id="maxBooking" name="maxBooking" class="form-control inp-height"
                                min="1" value="10">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-3 text-dark">Number of scans</div>
                        <div class="col-md-3">
                            <input type="number" id="numberofpersons" name="numberofpersons" class="form-control inp-height"
                                min="1" value="1">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-3 text-dark">Number of persons</div>
                        <div class="col-md-3">
                            <input type="number" id="nopti" name="nopti" class="form-control inp-height"
                                min="1" value="10">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-3 d-flex align-items-center text-dark">Required Extra Info</div>
                        <div class="col-md-3">
                            <select id="requiredInfo" name="requiredInfo" style="height: 35px !important;padding-top: 6px;"
                                class="form-control input-w mt-2">
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>

                    <hr class="w-100 mt-3 mb-3">
                    <h3 class="font-weight-bold text-dark">Ticket sales</h3>
                    <div style="flex-wrap: nowrap" class="row">

                        <!--Grid column-->
                        <div class="col-md-6 mb-4">


                            <!-- Default checked -->
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="automatically"
                                    value="automatically" name="ticketExpired">
                                <label class="custom-control-label text-dark" for="automatically">
                                    Automatically when ticket is almost sold out
                                </label>
                            </div>



                        </div>
                        <div class="col-md-3">
                            <select id="previousFaseId" name="previousFaseId"
                                style="height: 35px !important; padding: 0px !important;padding-left: 8px !important;"
                                class="form-control input-w">
                                <option value="0">Select option</option>
                                <?php if(!empty($tickets) && count($tickets) > 0): ?>
                                <?php foreach($tickets as $ticket): ?>
                                <option value="<?php echo $ticket['ticketId']; ?>">
                                    <?php echo $ticket['ticketDescription']; ?>
                                </option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="my-2"></div>
                    <div class="row">

                        <div class="col-md-6 mb-4">
                            <!-- Default unchecked -->
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="manually" value="manually"
                                    name="ticketExpired" checked="">
                                <label class="custom-control-label text-dark" for="manually">On date and time</label>
                            </div>




                            </section>
                        </div>
                    </div>

                    <div class="row mb-3 timestamp-row">
                        <div class="col-md-3 mt-1">
                            From Date
                        </div>
                        <div class="col-md-3 mt-1">
                            <div class="input-group date">
                                <input type="text" class="form-control inp-height timestamp" id="startDate"
                                    name="startDate" required>
                                <span style="padding-top: 5px;" class="input-group-addon fa-input pl-2 pr-2">
                                    <i style="color: #fff;font-size: 18px;" class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-3 mt-1">
                            From Time
                        </div>
                        <div class="col-md-3 mt-1">
                            <div class="input-group">
                                <input style="padding-top: 5px !important;" type="time" step="any"
                                    class="form-control inp-height timestamp" id="startTime" name="startTime">
                                <span style="padding-top: 5px;" class="input-group-addon fa-input pl-2 pr-2">
                                    <i style="color: #fff;font-size: 20px;" class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 timestamp-row">
                        <div class="col-md-3 mt-1">
                            To Date
                        </div>
                        <div class="col-md-3 mt-1">
                            <div class="input-group date">
                                <input type="text" onchange="checkTicketTimestamp()" onfocus="timestampTicketOnFocus()"
                                    class="form-control inp-height timestamp" id="endDate" name="endDate" required>
                                <span style="padding-top: 5px;" class="input-group-addon fa-input pl-2 pr-2">
                                    <i style="color: #fff;font-size: 18px;" class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-3 mt-1">
                            To Time
                        </div>
                        <div class="col col-md-3 mt-1">
                            <div class="input-group">
                                <input style="padding-top: 5px !important;" type="time" step="any"
                                    onchange="checkTicketTimestamp()" onfocus="checkTicketTimestamp()"
                                    oninput="checkTicketTimestamp()" onkeyup="checkTicketTimestamp()"
                                    class="form-control inp-height timestamp" id="endTime" name="endTime">
                                <span style="padding-top: 5px;" class="input-group-addon fa-input pl-2 pr-2">
                                    <i style="color: #fff;font-size: 20px;" class="fa fa-clock-o"></i></span>
                            </div>
                        </div>


                    </div>

                    <div class="row mb-3 timestamp-row">
                        <div class="col col-md-3">
                            Sold out when expired
                        </div>
                        <div style="display: flex;" class="col col-md-9">
                            <ul>
                                <li>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" id="soldout" type="checkbox">
                                        <label class="custom-control-label font-weight-bold text-dark" for="soldout">

                                        </label>
                                    </div>
                                </li>
                            </ul>
                            <input type="text" id="soldOutWhenExpired" name="soldOutWhenExpired"
                                class="form-control inp-height">
                        </div>


                    </div>



                    <div class="row d-none">
                        <div class="col col-md-3">
                            Make invisible when sold out
                        </div>
                        <div style="display: flex;" class="col col-md-9">
                            <ul>
                                <li>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" id="soldoutVisibility" type="checkbox">
                                        <label class="custom-control-label font-weight-bold text-dark"
                                            for="soldoutVisibility">

                                        </label>
                                    </div>
                                </li>
                            </ul>

                        </div>


                    </div>

                    <hr class="w-100 mt-3 mb-3 d-none">
                    <h3 class="font-weight-bold text-dark d-none">Mail per amount of ticket sold</h3>
                    <div class="row mb-3 d-none">
                        <div class="col col-md-3">Get email per</div>
                        <div class="col col-md-3">
                            <input type="number" id="mailPerAmount" name="mailPerAmount" class="form-control inp-height"
                                min="1" value="1">
                        </div>
                        <div class="col col-md-3">ticket sold</div>
                    </div>
                    <div class="row mb-3 d-none">
                        <div class="col col-md-3">On email address</div>
                        <div class="col col-md-6">
                            <input type="text" id="emailAddress" name="emailAddress" class="form-control inp-height">
                        </div>
                    </div>

                    <!--
                    <div class="row mb-5">
                        <div class="col col-md-3">Email Body</div>
                        <div class="col col-md-6 mb-5">
                            <div id="editor"></div>
                            <div id="log"></div>
                            <input id="eventdescript" type="hidden" name="emailBody">
                        </div>
                    </div>

                    -->
                    <div style="display: none" id="editor"></div>
                    <div style="display: none" id="log"></div>

                    <input type="hidden" id="guestTicket" name="guestTicket" value="1">
                    <input type="hidden" id="ticketSwap" name="ticketSwap" value="1">
                    <input type="hidden" id="partialAccess" name="partialAccess" value="1">
                    <input type="hidden" id="soldoutExpired" name="soldoutExpired" value="0">
                    <input type="hidden" id="soldoutVisible" name="soldoutVisible" value="1">
                    <input type="hidden" id="ticketId" name="ticketId">



            </div>
            <div class="modal-footer">
                <button type="button" id="ticketOptionsClose" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="submit" id="submitEventForm" class="btn btn-primary">Save changes</button>
                <button style="display: none;" type="reset" id="resetTicketOptions"
                    class="btn btn-primary">Reset</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- Add Ticket Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editModalLabel">Add Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form id="ticketForm" name="ticketForm" action="#" onsubmit="return saveTicket(event)"
                        method="POST">
                        <div class="form-group row">
                            <label for="ticket-name" class="col-md-4 col-form-label text-md-left">Ticket Name</label>
                            <div class="col-md-6">

                                <input type="text" id="ticketDescription" class="input-w form-control"
                                    name="ticketDescription" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ticketType" class="col-md-4 col-form-label text-md-left">Ticket type</label>
                            <div class="col-md-6">
                                <select id="ticketType" class="form-control input-w" required>
                                    <option selected disabled>Select option</option>
                                    <option value="ticket">Ticket</option>
                                    <option value="group">Bundle</option>
                                </select>
                                <input type="hidden" id="ticketTypeVal" name="ticketType">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ticketEmailTemplate" class="col-md-4 col-form-label text-md-left">Email
                                Template</label>
                            <div class="col-md-6">
                                <select id="ticketEmailTemplate" class="form-control input-w">
                                    <option selected disabled>Select option</option>
                                    <?php if(!empty($emails) && count($emails) > 0): ?>
                                    <?php foreach($emails as $email): ?>
                                    <option value="<?php echo $email->id; ?>">
                                        <?php echo str_replace('ticketing_', '', $email->template_name); ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <input type="hidden" id="ticketEmailTemplateId" name="emailId">
                            </div>
                        </div>

                        <!--
                        <div class="form-group row">
                            <label for="ticket-name" class="col-md-4 col-form-label text-md-left">Ticket Design</label>
                            <div class="col-md-6">

                                <input type="" id="ticketDesign" class="input-w form-control jscolor"
                                    name="ticketDesign">

                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label for="ticketEvent" class="col-md-4 col-form-label text-md-left">Ticket event</label>
                            <div class="col-md-6">
                                <select id="ticketEvent" class="form-control input-w">
                                    <option selected disabled>Select option</option>
                                    <?php //foreach($events as $event): ?>
                                    <option value="<?php //echo $event['id']; ?>"><?php //echo $event['eventname']; ?>
                                    </option>
                                    <?php //endforeach; ?>
                                </select>
                                
                            </div>
                        </div>
                        -->
                        <input type="hidden" id="eventId" name="eventId" value="<?php echo $eventId; ?>">


                        <div class="form-group row">
                            <label for="group" class="col-md-4 col-form-label text-md-left">Bundle</label>
                            <div class="col-md-6">
                                <select id="group" class="form-control input-w">
                                    <option selected disabled>Select option</option>
                                    <?php if(!empty($groups) && count($groups) > 0): ?>
                                    <?php foreach($groups as $group): ?>
                                    <option id="group_<?php echo $group['id']; ?>" value="<?php echo $group['id']; ?>">
                                        <?php echo $group['groupname']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <input type="hidden" id="ticketGroup" name="ticketGroupId">
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label for="quantity" class="col-md-4 col-form-label text-md-left">Ticket quantity</label>
                            <div class="col-md-6">
                                <input type="number" id="quantity" class="form-control input-w" name="ticketQuantity"
                                    required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-left">Ticket price</label>
                            <div class="col-md-6">
                                <input type="number" step="0.01" id="price" class="form-control input-w"
                                    name="ticketPrice" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4 col-form-label text-md-left">
                                Ticket Visible
                            </div>
                            <div class="col-md-4">
                                <ul>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" id="visible" type="checkbox" checked>
                                            <label class="custom-control-label font-weight-bold text-dark"
                                                for="visible">

                                            </label>
                                            <input type="hidden" id="ticketVisible" name="ticketVisible" value="1">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="ticketClose" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Ticket</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Template Modal -->
<div class="modal fade" id="emailTemplateModal" tabindex="-1" role="dialog" aria-labelledby="emailTemplateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="emailTemplateModalLabel">Choose Email Template
                </h5>
                <button type="button" class="close" id="closeEmailTemplate" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select style="display: none;" id="selectTemplateName" class="form-control">
                    <option value="">Select template</option>
                </select>
                <label for="customTemplateName">Template Name</label>
                <input type="text" id="customTemplateName" name="customTemplateName" class="form-control" />
                <br />
                <label for="customTemplateSubject">Subject</label>
                <input type="text" id="customTemplateSubject" name="templateSubject" class="form-control" />
                <br />
                <label for="templateType">Template Type</label>
                <select class="form-control w-100" id="templateType" name="templateType">
                    <option value="" disabled>Select type</option>
                    <option value="general">General</option>
                    <option value="reservations">Reservations</option>
                    <option value="tickets">Tickets</option>
                    <option value="vouchers">Vouchers</option>
                </select>
                <br />
                <label for="templateHtml">Edit template</label>
                <textarea id="templateHtml" name="templateHtml"></textarea>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="updateEmailTemplate" class="btn btn-primary">Save changes</button>
            </div>

        </div>
    </div>
</div>



<!-- Choose Email Modal -->
<div class="modal fade" id="chooseEmailModal" tabindex="-1" role="dialog" aria-labelledby="chooseEmailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editModalLabel">Choose Email Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">

                    <div class="form-group row">
                        <label for="group" class="col-md-4 col-form-label text-md-left">Email Template</label>
                        <div id="selectEmailTemplate" class="col-md-6">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="saveEmailTemplates" class="btn btn-primary">Save changes</button>
            </div>

        </div>
    </div>
</div>


<!-- Edit Group Modal -->
<div class="modal fade" id="chooseEmailModal" tabindex="-1" role="dialog" aria-labelledby="chooseEmailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editModalLabel">Choose Email Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <input type="hidden" id="editGroupId" name="editGroupId">

                    <div class="form-group row">
                        <label for="group" class="col-md-4 col-form-label text-md-left">Group Name</label>
                        <div class="col-md-6">
                            <input type="text" id="groupName" class="form-control input-w" name="groupName">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="group" class="col-md-4 col-form-label text-md-left">Capacity</label>
                        <div class="col-md-6">
                            <input type="text" id="groupCapacity" class="form-control input-w" name="groupCapacity">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="saveEmailTemplates" class="btn btn-primary">Save changes</button>
            </div>

        </div>
    </div>
</div>



<!-- Guestlist Modal -->
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

                    <input type="hidden" id="guestTicketId">

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
-->



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
                <div class="tabs" id="tab03">
                    <h6 class="text-muted">Guests List</h6>
                </div>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="line"></div>
            <div class="modal-body p-0">

                <fieldset class="show" id="tab011">
                    <div class="bg-light">
                        <h5 class="text-center mb-4 mt-0 pt-4">Add Guest</h5>
                        <form class="needs-validation" action="#" method="POST"
                            onsubmit="return addGuestTicket(event)" novalidate>
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

                            </div>

                        </form>


                    </div>

                    <pre class="d-none" id="jsonData"></pre>


                </fieldset>

                <fieldset style="max-height: 400px; overflow-y: auto;" id="tab031">
                    <div class="w-100 mt-3 p-3 mt-5 table-responsive">
                        <table id="guestlist" class="table table-striped table-bordered text-center" cellspacing="0"
                            width="100%">
                        </table>
                    </div>
                </fieldset>
            </div>
            <div class="line"></div>
            <div class="modal-footer">
                <fieldset class="show" id="tab012">
                    <button type="button" id="closeGuestModal" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="button" onclick="addGuestTicketForm()" class="btn btn-primary">Add Guest</button>
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





<main class="my-form">
    <div class="w-100 mt-5 p-3">
        <div style="justify-content: space-between;" class="row mt-5 p-4">
            <div class="input-group col-md-4 mb-3">
                <input type="button" value="Add Ticket" style="background: #009933 !important;border-radius:0"
                    class="btn btn-success form-control mb-3 text-left" id="event-time2" name="event-time2"
                    data-toggle="modal" data-target="#addModal">
                <a style="background: #004d1a;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                    data-toggle="modal" data-target="#addModal">
                    <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></a>
                <a href="<?php echo base_url(); ?>events/inputs/<?php echo $eventId; ?>">
                    <input type="button" value="Set custom inputs"
                        style="background: #10b96d !important;border-radius:0;height:45px;"
                        class="btn btn-primary form-control mb-3 text-left ml-2">
                </a>
                <a href="<?php echo base_url(); ?>events/inputs/<?php echo $eventId; ?>"
                    style="background: #0a6635;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                    <i style="color: #fff;font-size: 18px;" class="fa fa-file-text-o"></i></a>
            </div>
            
            <div class="col-md-2 mb-3">
                <a href="<?php echo base_url(); ?>events">
                    <div class="input-group">
                        <input type="button" value="<?php echo $this->language->tline('Go Back'); ?>"
                            style="background: #10b981 !important;border-radius:0;height:45px;"
                            class="btn btn-primary form-control mb-3 text-left">
                        <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                            <i style="color: #fff;font-size: 18px;" class="ti ti-arrow-left"></i>
                        </span>

                    </div>
                </a>
            </div>
        </div>

        <p class="mt-2"><strong style="font-size: 16px;" class="ml-1">Tickets</strong></p>
        <div class="table-responsive mt-2 mb-1">
            <table id="tickets" style="width:100%">

            </table>
        </div>
        <div class="table-responsive mt-5">
            <table style="background: none !important;" class="table">
                <tr style="border-bottom: 3px solid #9333ea">
                    <td><?php echo $event->eventname; ?></td>
                    <td><?php echo substr(strip_tags($event->eventdescript), 0, 20) . '...'; ?></td>
                    <td><?php echo $event->eventVenue; ?></td>
                    <td><?php echo $event->eventAddress; ?></td>
                    <td><?php echo $event->eventCity; ?></td>
                    <td><?php echo $event->eventZipcode; ?></td>
                    <td><?php echo $event->eventCountry; ?></td>
                    <td><?php echo $event->StartDate; ?></td>
                    <td id="eventEndDate" data-endDate="<?php echo $event->EndDate; ?>"><?php echo $event->EndDate; ?></td>
                    <td><?php echo $event->StartTime; ?></td>
                    <td id="eventEndTime" data-endTime="<?php echo $event->EndTime; ?>"><?php echo $event->EndTime; ?></td>
                    <td>
                        <a href="<?php echo base_url(); ?>events/shop/<?php echo $this->session->userdata('userShortUrl'); ?>"
                            class="btn btn-primary" style="background: #10b981;" target="_blank">meta link</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="w-100 mt-1 mb-4 text-right">
            <a href="<?php echo base_url(); ?>events/report/<?php echo $event->id; ?>" class="btn btn-primary mr-2"
                style="background: #10b981;">Go to Buyers</a>
        </div>
    </div>
</main>
<hr class="w-100 mt-5 mb-5">
<!--
<strong style="font-size: 16px;" class="ml-1">Add tickets</strong>
<div class="row mt-2">
    <div class="col-md-4 ml-1">
        <div class="input-group">
            <input type="submit" value="Ticket" style="background: #377E7F !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 ml-1">
        <div class="input-group">
            <input type="submit" value="Guest ticket" style="background: #C84746 !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #B23938;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 ml-1">
        <div class="input-group">
            <input type="submit" value="Additional item" style="background: #E3A847 !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #F1993F;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 ml-1">
        <div class="input-group">
            <input type="submit" value="Divider" style="background: #39495C !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #2D3A4C;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 ml-1">
        <div class="input-group">
            <input type="submit" value="External ticket link" style="background: #39495C !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #2D3A4C;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></span>
        </div>
    </div>
</div>
<hr class="w-100 mt-5 mb-5">

<div class="row">
    <div class="col-md-3 ml-1">
        <div class="input-group">
            <span style="background: #030F16;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-arrow-left"></i></span>
            <input type="submit" value="Next Step" style="background: #111B22 !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">

        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <input type="submit" value="Save changes" style="background: #377E7F !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #275C5D;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-check"></i></span>
        </div>
    </div>
    <div class="col-md-3 ml-1">
        <div class="input-group">
            <input type="submit" value="Next Step" style="background: #111B22 !important;border-radius:0"
                class="btn btn-primary form-control mb-3 text-left" id="event-time2" name="event-time2">
            <span style="background: #030F16;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3">
                <i style="color: #fff;font-size: 18px;" class="fa fa-arrow-right"></i></span>
        </div>
    </div>
</div>
-->
<div id="result"></div>





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



<script>
const emailsTemplates = `<?php echo json_encode($emails); ?>`;

const templateGlobals = (function() {
    let globals = {
        'templateHtmlId': 'templateHtml',
    }



    Object.freeze(globals);

    return globals;
}());

$(document).ready(function() {
    setTimeout(() => {
        $('#guestlist').DataTable().column( 0 ).visible( false );
    }, 2000);
    
});
</script>
