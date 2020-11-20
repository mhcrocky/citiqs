<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<style>
.drilldown-level {
    background: #fff;
}
</style>
<div style="margin-top: 3%;" class="main-content-inner">
    <div class="report-content">
        <div class="text-center">
        </div>
        <form method="get" action="<?php echo base_url(); ?>customer_panel/report">
            <div class="text-center">
                <div class="row ">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <b>Select ID:</b>

                            <select class="form-control jsslect2" name="ids">
                                <option value="">--</option>
                                <?php
                                $selectedids = !empty($this->input->get('ids')) ? $this->input->get('ids') : "";

                                $ids = [];
                                foreach ($bookandpay as $value) {
                                    if(!isset($ids[$value['id']])) {
                                        $ids[$value['id']] = 1;
                                        echo "<option value='" . $value['id'] . "' " . ($value['id'] == $selectedids ? " selected" : "") . ">" . $value['id'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <b>Select Name:</b>
                            <select class="form-control jsslect2" name="names">
                                <option value="">--</option>
                                <?php
                                $selectedids = !empty($this->input->get('names')) ? $this->input->get('names') : "";

                                $names = [];
                                foreach ($bookandpay as $value) {
                                    if(!isset($names[$value['name']])) {
                                        $names[$value['name']] = 1;
                                        echo "<option value='" . $value['name'] . "' " . ($value['name'] == $selectedids ? " selected" : "") . ">" . $value['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- foreach -->
                    <?php
                    foreach ($allcolumnarray as $valkey) {
                        ?>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <b>Select <?php echo $columnItem = $valkey[1] ?>:</b>
                                <select class="form-control jsslect2" name="<?php echo $valkey[0] ?>">
                                    <option value="">--</option>
                                    <?php
                                    $selectedids = !empty($this->input->get($valkey[0])) ? $this->input->get($valkey[0]) : "";

                                    $$columnItem = [];
                                    foreach ($bookandpay as $value) {
                                        if(!isset($$columnItem[$value[$valkey[0]]])) {
                                            $$columnItem[$value[$valkey[0]]] = 1;
                                            echo "<option value='" . $value[$valkey[0]] . "' " . ($value[$valkey[0]] == $selectedids ? " selected" : "") . ">" . $value[$valkey[0]] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <b>Select date:</b>
                            <select class="form-control jsslect2" name="eventdates[]" multiple="multiple">
                                <option value="">--</option>
                                <?php
                                $selectedids = !empty($this->input->get('eventdates')) ? $this->input->get('eventdates') : array();

                                $eventdates = [];
                                foreach ($bookandpay as $value) {
                                    if(!isset($eventdates[$value['eventdate']])) {
                                        $eventdates[$value['eventdate']] = 1;
                                        echo "<option value='" . $value['eventdate'] . "' " . (in_array($value['eventdate'], $selectedids) ? " selected" : "") . ">" . $value['eventdate'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <b>Select Spot Label:</b>
                            <select class="form-control jsslect2" name="Spotlabels[]" multiple="multiple">
                                <option value="">--</option>
                                <?php
                                $selectedids = !empty($this->input->get('Spotlabels')) ? $this->input->get('Spotlabels') : array();

                                $Spotlabels = [];
                                foreach ($bookandpay as $value) {
                                    if(!isset($Spotlabels[$value['Spotlabel']])) {
                                        $Spotlabels[$value['Spotlabel']] = 1;
                                        echo "<option value='" . $value['Spotlabel'] . "' " . (in_array($value['Spotlabel'], $selectedids) ? " selected" : "") . ">" . $value['Spotlabel'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                    <div style="margin-right:3%;" class="form-group text-right">
                        <button style="width:170px;text-center;" class="btn btn-primary">Submit</button>
                    </div>
                
            </div>
        </form>
        <div style="margin: 30px;background:#ddd;">
            <?php echo $graphs; ?>
        </div>
    </div>
</div>

    