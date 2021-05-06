<div style="margin-top: 20px !important;" class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <div class="col-xs-12" style="text-align:left; margin-bottom: 20px;">
                    <a href="<?php echo base_url('events/emaildesigner/ticketing'); ?>" class="btn btn-primary" role="button">Add New Template</a>
                </div>
                    <table class="table table-striped" style="margin-top: 100px;">
                        <thead>
                        <tr>
                            <th style="text-align: center;">#</th>
                            <th style="text-align: center;">Template Name</th>
                            <th style="text-align: center;">File Name</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(count($emails) > 0): ?>
                        <?php foreach ($emails as $email): ?>
                            <tr>
                                <th scope="row"><?php echo $email->id; ?></th>
                                <td><?php echo str_replace('ticketing_', '', $email->template_name); ?></td>
                                <td><?php echo $email->template_file; ?></td>
                                <td class="action">
                                    <a href="<?php echo base_url(); ?>events/emaildesigner/ticketing/<?php echo $email->id; ?>">
                                        <i class="fa fa-pencil text-primary" aria-hidden="true"></i>
                                    </a>
                                    <a href="#" onclick="confirmDelete(<?php echo $email->id; ?>)">
                                        <i class="fa fa-trash text-danger" aria-hidden="true" ></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>


<div class="modal" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="delete_confirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="delete_confirmLabel">Delete Email Template</h4>
            </div>
            <div class="modal-body">
                Are you sure ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="modal_delete_btn" onclick="deleteEmail(this)" data-email_id="" class="btn btn-primary">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>

    function confirmDelete (email_id) {
        $('#modal_delete_btn').data('email_id', email_id);
        $('#delete_confirm').modal('show');
    }

    function deleteEmail (el) {
        console.log(el);
        var email_id = $(el).data('email_id');

        $.ajax({
            type: "POST",
            url: "ajaxdorian/delete_email_template",
            data: { email_id: email_id }
        }).done(function( response ) {
            $(el).data('email_id', '');
            response = $.parseJSON(response)
            alertify[response.status](response.msg);
            document.location.reload(true);
            $('#delete_confirm').modal('hide');
        });

    }
</script>