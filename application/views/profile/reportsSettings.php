<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<main style="margin-left:20px">
    <form method="post" onsubmit="return saveReport(this)">
        <p style="font-size:20px">
            Send&nbsp;&nbsp;
            <label for="xReport">
                <input
                    type="checkbox"
                    value="1"
                    id ="xReport"
                    name="reportSettings[xReport]"
                    <?php if (isset($report['xReport']) && $report['xReport'] === '1') { ?>
                        checked
                    <?php } ?>
                />
                <?php echo ucfirst(str_replace('_', ' ', $xReport));?>
            </label>
            &nbsp;&nbsp;and/or&nbsp;&nbsp;
            <label for="zReport">
                <input
                    type="checkbox"
                    value="1"
                    id ="zReport"
                    name="reportSettings[zReport]"
                    <?php if (isset($report['zReport']) && $report['zReport'] === '1') { ?>
                        checked
                    <?php } ?>
                />
                <?php echo ucfirst(str_replace('_', ' ', $zReport));?>
            </label>
            &nbsp;&nbsp;for last&nbsp;&nbsp;
            <select name="reportSettings[sendPeriod]" onchange="togglePeriod(this.value)">
                <option value="">Select period</option>
                <?php foreach ($reportPeriods as $period) { ?>
                    <option
                        value="<?php echo $period; ?>"
                        <?php if (isset($report['sendPeriod']) && $report['sendPeriod'] === $period) { ?>
                            selected
                        <?php } ?>
                    >
                        <?php echo $period; ?>
                    </option>
                <?php } ?>
            </select>
            <span
                id="week"
                <?php if (is_null($report) || $report['sendPeriod'] !== $weekPeriod) { ?>
                    style="display:none"
                <?php } ?>
            >
                &nbsp;&nbsp;on&nbsp;&nbsp;
                <select name="reportSettings[sendDay]">
                    <option value="">Select day of week</option>
                    <?php foreach ($weekDays as $day) { ?>
                        <option
                            value="<?php echo $day; ?>"
                            <?php if (isset($report['sendDay']) && $report['sendDay'] === $day) { ?>
                                selected
                            <?php } ?>
                        >
                            <?php echo $day; ?>
                        </option>
                    <?php } ?>
                </select>
            </span>
            <span
                id="month"
                <?php if (is_null($report) || $report['sendPeriod'] !== $monthPeriod) { ?>
                    style="display:none"
                <?php } ?>
            >
                &nbsp;&nbsp;on&nbsp;&nbsp;
                <select name="reportSettings[sendDate]">
                    <option value="">Select date of month</option>
                    <?php for ($i = 1; $i < 32; $i++) { ?>
                        <option
                            value="<?php echo $i; ?>"
                            <?php if (isset($report['sendDate']) && $report['sendDate'] === $i) { ?>
                                selected
                            <?php } ?>
                        >
                            <?php echo $i; ?>
                        </option>
                    <?php } ?>
                </select>
            </span>
            &nbsp;&nbsp;at&nbsp;&nbsp;
            <select name="reportSettings[sendTime]">
                <option value="">Select hour</option>
                <option value="00:00:00">00</option>
                <?php
                    for ($i = 1; $i < 24; $i++) {
                        $value = ($i < 10) ? '0' . $i . ':00:00' : $i . ':00:00';
                        ?>
                            <option
                                value="<?php echo $value; ?>"
                                <?php if (isset($report['sendTime']) && $report['sendTime'] === $value) { ?>
                                    selected
                                <?php } ?>
                            >
                                <?php echo ($i < 10) ? '0' . $i : $i; ?>
                            </option>
                        <?php
                    }
                ?>
            </select>
            &nbsp;&nbsp;o' clock.
        </p>
        <p style="font-size:20px">
            Send report(s) on this email(s) address(es) (emails MUST be separated with ";" )
            <textarea
                name="reportEmails[emails]"
                rows="<?php echo isset($report['reportEmails']) ? count($report['reportEmails']) : '1'; ?>"
            ><?php
                if (!empty($report['reportEmails'])) {
                    echo implode('; ', $report['reportEmails']);
                }
            ?></textarea>
        </p>
        <br/>
        <input class="btn btn-primary" type="submit" value="Submit" />
    </form>
</main>
<script>
    var reportsGlobals = (function(){
        let globals = {
            <?php if (is_null($report)) { ?>
            'updateUrl' : globalVariables['ajax'] + 'saveReportsSettings'
            <?php } else { ?>
            'updateUrl' : globalVariables['ajax'] + 'saveReportsSettings/' + <?php echo $report['id']; ?>
            <?php } ?>
        }
        return globals;
    })();
</script>
