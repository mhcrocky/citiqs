<div style="margin-left:20px">
    <ul class="nav nav-tabs" style="border-bottom: none" role="tablist">
        <li class="nav-item">
            <a style="border-radius: 50px" class="nav-link active" data-toggle="tab" href="#templates">Templates</a>
        </li>
        <li class="nav-item">
            <a style="border-radius: 50px" class="nav-link" data-toggle="tab" href="#landingPages">Landing pages</a>
        </li>
	</ul>

    <div class="tab-content" style="border-radius: 50px; margin-left: -10px">
        <div id="templates" class="container tab-pane active" style="background: none;">
            <?php if (empty($templates)) { ?>
                <p>No templates. <a href="<?php echo base_url() . 'add_template'; ?>">Add</a>
            <?php } else {  ?>
                <div class="table-responsive col-sm-12 text-center" style="margin-top:20px">
                    <table id="listTemplates" class="table table-hover table-striped display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Template</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($templates as $template) { 
                                $template = (array) $template;;
                                ?>
                                <tr>
                                    <td><?php echo $template['id']; ?></td>
                                    <td><?php echo $template['template_name']; ?></td>
                                    <td><?php echo $template['template_type']; ?></td>
                                    <td>
                                        <a href="<?php echo $updateTemplate . $template['id']; ?>">Edit</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
        <div id="landingPages" class="container tab-pane" style="background: none;">
        <?php if (empty($landingPages)) { ?>
                <p>No landing pages. <a href="<?php echo base_url() . 'add_template'; ?>">Add</a>
            <?php } else {  ?>
                <div class="table-responsive col-sm-12 text-center" style="margin-top:20px">
                    <table id="listLandingPages" class="table table-hover table-striped display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Product group</th>
                                <th>Landing page</th>
                                <th>Name</th>
                                <th>Landing type</th>
                                <th>Change status</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($landingPages as $page) { ?>
                                <tr>
                                    <td><?php echo $page['id']; ?></td>
                                    <td><?php echo $page['productGroup']; ?></td>
                                    <td><?php echo $page['landingPage']; ?></td>
                                    <td><?php echo $page['name']; ?></td>
                                    <td><?php echo $page['landingType']; ?></td>
                                    <td>
                                        <?php if ($page['active'] === '0') { ?>
                                            <a href="<?php echo $baseUrl . 'templates/updateLandingPageStatus/' . $page['id'] . '/1?group=' . base64_encode($page['productGroup']); ?>">Activate</a>
                                        <?php } else { ?>
                                            <a href="<?php echo $baseUrl . 'templates/updateLandingPageStatus/' . $page['id'] . '/0?group=' . base64_encode($page['productGroup']); ?>">Deactivate</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo $updateTemplate . $page['id'] . DIRECTORY_SEPARATOR . '1' ?>">Update</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    const listTemplates = (function(){
        let globals = {};

        <?php if (!empty($templates)) { ?>
            globals['templates'] = true;
        <?php } ?>
        <?php if (!empty($landingPages)) { ?>
            globals['landingPages'] = true;
        <?php } ?>

        Object.freeze(globals);

        return globals;
    }());
</script>