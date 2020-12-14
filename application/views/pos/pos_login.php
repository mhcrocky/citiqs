<main style="height: 100vh;">
	<div class="container">
		<div class="row">
            <form method="post" action="<?php echo base_url(); ?>pos/posLoginAction">
                <legend>Employee check in</legend>
                <div class="form-group">
                    <select id="employeeId"  name="employeeId" class="form-control">
                        <option value="">Select</option>
                        <?php foreach ($employees as $employee) { ?>
                            <option value="<?php echo $employee['id']; ?>">
                                <?php echo $employee['username']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" value="CHECK IN" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>
</main>