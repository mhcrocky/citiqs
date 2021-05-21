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
                />
                <?php echo ucfirst(str_replace('_', ' ', $zReport));?>
            </label>
            &nbsp;&nbsp;for last&nbsp;&nbsp;
            <select name="reportSettings[sendPeriod]" onchange="togglePeriod(this.value)">
                <option value="">Select period</option>
                <?php foreach ($reportPeriods as $peirod) { ?>
                    <option value="<?php echo $peirod; ?>"><?php echo $peirod; ?></option>
                <?php } ?>
            </select>
            <span id="week" style="display:none">
                &nbsp;&nbsp;on&nbsp;&nbsp;
                <select name="reportSettings[sendDay]">
                    <option value="">Select day of week</option>
                    <?php foreach ($weekDays as $day) { ?>
                        <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                    <?php } ?>
                </select>
            </span>
            <span id="month" style="display:none">
                &nbsp;&nbsp;on&nbsp;&nbsp;
                <select name="reportSettings[sendDate]">
                    <option value="">Select date of month</option>
                    <?php for ($i = 1; $i < 32; $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
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
                            <option value="<?php echo $value; ?>"><?php echo ($i < 10) ? '0' . $i : $i; ?></option>
                        <?php
                    }
                ?>
            </select>
            &nbsp;&nbsp;o' clock.
        </p>
        <p style="font-size:20px">
            Send report(s) on this emails address (emails MUST be separated with empty space)
            <textarea name="reportEmails[emails]" rows="1"></textarea>
        </p>
        <br/>
        <input class="btn btn-primary" type="submit" value="Submit" />
    </form>
</main>
