<main class="container" style="text-align:left">
    <h1>Select "<?php echo $vendor->name ?>" spot</h1>
    <div class="container" style='overflow-x:hidden; overflow-y: hidden; margin-top: 20px; margin-bottom: 20px'>
    <?php if (!empty($spots)) { ?>
        <label for="spot">Spots:</label>
        <select id="spot" onchange="redirectToMakeOrder(this)" class="form-control">
            <option value="">Select spot</option>
            <?php foreach ($spots as $spot) { ?>
            <option value="<?php echo base_url() . 'make_order?vendorid=' . $vendor->userId . '&spotid=' . $spot['spotId'] ?>">
                <?php echo $spot['spotName']; ?>
            </option>
            <?php } ?>
        </select>
    <?php } else { ?>
        <p>No available spots</p>
    <?php } ?>
    </div>
</main>
<script>
    function redirectToMakeOrder(element) {
        let link = element.value;
        if (link) {
            window.location.replace(link);
        }
    }

</script>