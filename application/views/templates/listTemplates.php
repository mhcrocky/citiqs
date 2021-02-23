<div style="margin-left:20px">
    <?php if (empty($templates)) { ?>
        <p>No templates. <a href="<?php echo base_url() . 'add_template'; ?>">Add</a>
    <?php } else {  ?>
        <div class="table-responsive col-sm-12" style="margin-top:20px">
            <table id="listTemplates" class="table table-hover table-striped display" style="width:100%">
        
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Template</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($templates as $template) { ?>
                        <tr>
                            <td><?php echo $template['id']; ?></td>
                            <td><?php echo $template['template_name']; ?></td>
                            <td>
                                <a href="<?php echo $updateTemplate . $template['id']; ?>">Update</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>