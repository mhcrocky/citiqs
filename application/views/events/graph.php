<div style="padding:25px;" class="w-100 mt-3 row-sort ui-sortable">
    <div class="table-responsive mb-2">
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

    <div class="w-100 mt-1 mb-2 text-right">
        <a href="<?php echo base_url(); ?>events/report/<?php echo $eventId; ?>" class="btn btn-primary mr-2"
            style="background: #10b981;">Go to Buyers</a>
        <a href="<?php echo base_url(); ?>events/event/<?php echo $eventId; ?>" class="btn btn-primary mr-2"
            style="background: #10b981;">Go to Tickets</a>
    </div>
    <div class="w-100 mt-3 mb-4">
        <div id="graphs">
            <?php echo $graphs; ?>
        </div>

    </div>
</div>

<script>
(function() {
    $('.drilldown-body .breadcrumb').remove();
    $('.panel-heading .pull-right').remove();
}());
</script>