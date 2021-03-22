<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editModalLabel">Edit Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editTicketOptions" name="editTicketOptions"
                    action="#" onsubmit="return saveTicketOptions(event)" method="POST">
                    <ul>
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

                    <hr class="w-100 mt-3 mb-3">
                    <div class="row">
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
                        <div class="col-md-3 text-dark">Min 0.00</div>
                        <div class="col-md-3">
                            <input type="number" id="nonSharedTicketFee" name="nonSharedTicketFee"
                                class="form-control inp-height" min="0" step="0.01" value="1">
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
                    <div class="row">
                        <div class="col-md-3 text-dark">
                            <h3 style="font-size: 14px;" class="text-dark">Voucher</h3>
                        </div>
                        <div class="col-md-3">
                            <select id="voucherId" name="voucherId" style="height: 35px !important;padding-top: 6px;"
                                class="form-control input-w mt-2">
                                <option value="0">Select option</option>
                                <?php foreach($vouchers as $voucher): ?>
                                <option value="<?php echo $voucher['id']; ?>"><?php echo $voucher['template_name'] .' ('. $voucher['description'] . ')'; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <hr class="w-100 mt-3 mb-3">
                    <h3 class="font-weight-bold text-dark">Ticket sales</h3>
                    <div class="row">

                        <!--Grid column-->
                        <div class="col-md-6 mb-4">



                            <!-- Default unchecked -->
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="manually" value="manually"
                                    name="ticketExpired" checked="">
                                <label class="custom-control-label text-dark" for="manually">On date and time</label>
                            </div>

                            <div class="my-2"></div>

                            <!-- Default checked -->
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="automatically"
                                    value="automatically" name="ticketExpired">
                                <label class="custom-control-label text-dark" for="automatically">
                                    Automatically when ticket is almost sold out
                                </label>
                            </div>
                            </section>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col col-md-3">
                            From Date
                        </div>
                        <div class="col col-md-3">
                            <div class="input-group date">
                                <input type="text" class="form-control inp-height timestamp" id="startDate" name="startDate" required>
                                <span style="padding-top: 5px;" class="input-group-addon fa-input pl-2 pr-2">
                                    <i style="color: #fff;font-size: 18px;" class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col col-md-3">
                            From Time
                        </div>
                        <div class="col col-md-3">
                            <div class="input-group">
                                <input type="time" class="form-control inp-height timestamp" id="startTime" name="startTime">
                                <span style="padding-top: 5px;" class="input-group-addon fa-input pl-2 pr-2">
                                    <i style="color: #fff;font-size: 20px;" class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col col-md-3">
                            To Date
                        </div>
                        <div class="col col-md-3">
                            <div class="input-group date">
                                <input type="text" onchange="checkTicketTimestamp()" onfocus="timestampTicketOnFocus()" class="form-control inp-height timestamp" id="endDate" name="endDate" required>
                                <span style="padding-top: 5px;" class="input-group-addon fa-input pl-2 pr-2">
                                    <i style="color: #fff;font-size: 18px;" class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col col-md-3">
                            To Time
                        </div> 
                        <div class="col col-md-3">
                            <div class="input-group">
                                <input type="time" onchange="checkTimestamp()" onfocus="checkTimestamp()"
                                oninput="checkTimestamp()" onkeyup="checkTimestamp()" class="form-control inp-height timestamp" id="endTime" name="endTime">
                                <span style="padding-top: 5px;" class="input-group-addon fa-input pl-2 pr-2">
                                    <i style="color: #fff;font-size: 20px;" class="fa fa-clock-o"></i></span>
                            </div>
                        </div>


                    </div>

                    <div class="row">
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
                            <input type="text" id="soldOutWhenExpired" name="soldOutWhenExpired" class="form-control inp-height">
                        </div>


                    </div>

                    <hr class="w-100 mt-3 mb-3">
                    <h3 class="font-weight-bold text-dark">Mail per amount of ticket sold</h3>
                    <div class="row mb-3">
                        <div class="col col-md-3">Get email per</div>
                        <div class="col col-md-3">
                            <input type="number" id="mailPerAmount" name="mailPerAmount" class="form-control inp-height"
                                min="1" value="1">
                        </div>
                        <div class="col col-md-3">ticket sold</div>
                    </div>
                    <div class="row mb-3">
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
                    <input type="hidden" id="ticketId" name="ticketId">



            </div>
            <div class="modal-footer">
                <button type="button" id="ticketOptionsClose" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="submitEventForm" class="btn btn-primary">Save changes</button>
                <button style="display: none;" type="reset" id="resetTicketOptions" class="btn btn-primary">Reset</button>
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
                    <form id="ticketForm" name="ticketForm" action="#" onsubmit="return saveTicket(event)" method="POST">
                        <div class="form-group row">
                            <label for="ticket-name" class="col-md-4 col-form-label text-md-left">Ticket Name</label>
                            <div class="col-md-6">

                                <input type="text" id="ticketDescription" class="input-w form-control"
                                    name="ticketDescription" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ticketEmailTemplate" class="col-md-4 col-form-label text-md-left">Email
                                Template</label>
                            <div class="col-md-6">
                                <select id="ticketEmailTemplate" class="form-control input-w">
                                    <option selected disabled>Select option</option>
                                    <?php foreach($emails as $email): ?>
                                    <option value="<?php echo $email->id; ?>">
                                        <?php echo str_replace('ticketing_', '', $email->template_name); ?>
                                    </option>
                                    <?php endforeach; ?>
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
                            <label for="ticketType" class="col-md-4 col-form-label text-md-left">Ticket type</label>
                            <div class="col-md-6">
                                <select id="ticketType" class="form-control input-w" required>
                                    <option selected disabled>Select option</option>
                                    <option value="ticket">Ticket</option>
                                    <option value="group">Group</option>
                                </select>
                                <input type="hidden" id="ticketTypeVal" name="ticketType">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="quantity" class="col-md-4 col-form-label text-md-left">Ticket quantity</label>
                            <div class="col-md-6">
                                <input type="number" id="quantity" class="form-control input-w" name="ticketQuantity" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-left">Ticket price</label>
                            <div class="col-md-6">
                                <input type="number" step="0.01" id="price" class="form-control input-w" name="ticketPrice" required>
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

                        <div class="form-group row">
                            <label for="group" class="col-md-4 col-form-label text-md-left">Ticket group</label>
                            <div class="col-md-6">
                                <select id="group" class="form-control input-w" required>
                                    <option selected disabled>Select option</option>
                                    <?php foreach($groups as $group): ?>
                                    <option id="group_<?php echo $group['id']; ?>" value="<?php echo $group['id']; ?>"><?php echo $group['groupname']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" id="ticketGroup" name="ticketGroupId">
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

<main class="my-form">
    <div class="w-100 mt-5 p-3">
        <div class="input-group col-md-2">
            <input type="button" value="Add Ticket" style="background: #009933 !important;border-radius:0"
                class="btn btn-success form-control mb-3 text-left" id="event-time2" name="event-time2"
                data-toggle="modal" data-target="#addModal">
            <a style="background: #004d1a;padding-top: 14px;" class="input-group-addon pl-2 pr-2 mb-3"
                data-toggle="modal" data-target="#addModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-plus"></i></a>
        </div>

        <p class="mt-2"><strong style="font-size: 16px;" class="ml-1">Tickets</strong></p>
        <table id="tickets" class="mt-2 mb-1" style="width:100%">

        </table>
        <div class="table-responsive mt-5">
            <table style="background: none !important;" class="table">
                <tr style="border-bottom: 3px solid #9333ea">
                    <td><?php echo $event->eventname; ?></td>
                    <td><?php echo $event->eventdescript; ?></td>
                    <td><?php echo $event->eventVenue; ?></td>
                    <td><?php echo $event->eventAddress; ?></td>
                    <td><?php echo $event->eventCity; ?></td>
                    <td><?php echo $event->eventZipcode; ?></td>
                    <td><?php echo $event->eventCountry; ?></td>
                    <td><?php echo $event->StartDate; ?></td>
                    <td><?php echo $event->EndDate; ?></td>
                    <td><?php echo $event->StartTime; ?></td>
                    <td><?php echo $event->EndTime; ?></td>
                    <td>
                        <a href="<?php echo base_url(); ?>events/shop/<?php echo $this->session->userdata('userShortUrl'); ?>"
                            class="btn btn-primary" style="background: #10b981;">Go to Shop</a>
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
<script>
const emailsTemplates = '<?php echo json_encode($emails); ?>';

const templateGlobals = (function() {
    let globals = {
        'templateHtmlId': 'templateHtml',
    }



    Object.freeze(globals);

    return globals;
}());
</script>