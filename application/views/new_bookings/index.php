<div class="row w-100 mt-2">
<a class="ml-auto" href="javascript:;" onclick="displayView('tableView')"><i style="font-size: 26px" class="fa fa-bars text-dark mr-2"></i></a>
<a href="javascript:;" onclick="displayView('calendarView')"><i style="font-size: 22px" class="fa fa-calendar text-dark mr-2"></i></a>
</div>
<div id="tableView" class="row w-100 mt-3 table-responsive agenda d-none">
    <table style="background: none !important;" class="table table-striped w-100 text-center">
        <tr>
            <th><?php echo $this->language->tLine('Reservation Name'); ?></th>
            <th><?php echo $this->language->tLine('Date'); ?></th>
        </tr>
        <?php foreach($agendas_calendar as $agenda): ?>
            <tr>
                <td>
                    <a style="text-decoration: none;" class="text-dark" href="<?php echo $agenda['spotLink']; ?>"><?php echo $agenda['eventName']; ?><a>
                </td>
                <td><?php echo date('Y-m-d', strtotime($agenda['dateTime'])); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div id="calendarView" class="row w-100 mt-2 agenda">
    <div id="calendar"></div>
</div>

<script>
const agendas_calendar = '<?php echo json_encode($agendas_calendar); ?>';
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/agendaCalendar.js"></script>