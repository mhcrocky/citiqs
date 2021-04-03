<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    const paymentMethodsGlobals = (function(){
        let globals = {
            tableIds : [],
        }
        return globals;
    }());
</script>
<main class="main-content w-100 container" style="margin-top:20px; border-width: 0px">
    <ul class="nav nav-tabs" style="border-bottom: none" role="tablist">
        <?php foreach ($productGroups as $key => $group) { ?>
            <li class="nav-item">
                <a
                    style="border-radius: 50px"
                    class="nav-link <?php if ($productGroups[array_key_first($productGroups)] === $group) echo 'active'; ?>"
                    data-toggle="tab" href="#<?php echo 'tab_' . $key; ?>"
                >
                    <?php echo $group; ?>
                </a>
            </li>
        <?php } ?>
	</ul>
    <div class="tab-content" style="border-radius: 50px; margin-left: -10px">
        <?php foreach ($productGroups as $key => $group) { ?>
            <div
                id="<?php echo 'tab_' . $key; ?>"
                class="container tab-pane <?php if ($productGroups[array_key_first($productGroups)] === $group) echo 'active'; ?>"
            >
                <br/>
                <h3><?php echo $group; ?></h3>
                <br/>
                <table
                    id="<?php echo 'table_' . $key; ?>"
                    class="table table-striped table-bordered"
                    style="width:100%"
                >
                    <thead>
                        <th>ID</th>
                        <th>Product group</th>
                        <th>Payment method</th>
                        <th>Active</th>
                        <th>Vendor cost</th>
                        <th>Percent (cost)</th>
                        <th>Amount (cost)</th>
                    </thead>
                    <tbody>
                    </tbody>

                </table>
            </div>
            <script>
                paymentMethodsGlobals.tableIds['<?php echo 'table_' . $key; ?>'] = '<?php echo base64_encode($group); ?>'
            </script>
        <?php } ?>
    </div>
</main>
