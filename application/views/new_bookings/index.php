<div class="row w-100 mt-5">
    <div id="calendar"></div>
</div>

<script>
const agendas_calendar = '<?php echo json_encode($agendas_calendar); ?>';
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/agendaCalendar.js"></script>