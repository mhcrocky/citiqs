<div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable">
    <div class="table-responsive mb-2">
        <table class="table bg-white">
            <tr>
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
    <div class="float-right text-center pl-3">
        <input style="width: 330px;" class="date form-control-sm mb-2" type="text" name="datetimes"
            id="reportDateTime" />
        <input type="hidden" id="eventId" value="<?php echo $eventId; ?>">

    </div>
    <div class="w-100 mt-3 table-responsive">
        <table id="report" class="table table-striped table-bordered" cellspacing="0" width="100%">


        </table>


    </div>

</div>