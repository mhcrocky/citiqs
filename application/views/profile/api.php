<div class="main-wrapper" style="text-align:center">
    <div class="row">
        <div class="col-lg-12 col-sm-12" style="margin-left:30px; text-align:left">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNew">
                Add new
            </button>
        </div>
        <?php foreach ($apiUsers as $apiUser) { ?>
            <div class="col-lg-12 col-sm-12" style="text-align:left; margin-left:10px">
                <form
                    method="post"
                    class="form-inline"
                    <?php if ($apiUser['access'] === '0') { ?>
                        onsubmit="return actviateApiRequest(this)"
                    <?php } ?>
                >
                    <?php if ($apiUser['access'] === '0') { ?>
                        <input type="number" name="userId" value="<?php echo $apiUser['userid']; ?>" readonly hidden />
                    <?php } ?>
                    <div class="form-group">
                        <label>
                            API key:&nbsp;
                            <input
                                type="text"
                                name="apikey"
                                class="form-control"
                                value="<?php echo $apiUser['apikey']; ?>"
                                readonly
                                <?php if ($apiUser['access'] === '1') { ?>
                                    disabled
                                <?php } ?>
                            />
                        </label>
                    </div>
                    <div class="form-group"  style="margin-left:10px">
                        <label>
                            Name:&nbsp;
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="<?php echo $apiUser['name']; ?>"
                                <?php if ($apiUser['access'] === '1') { ?>
                                    readonly
                                    disabled
                                <?php } else { ?>
                                    data-id="<?php echo $apiUser['id']; ?>"
                                    data-name="<?php echo $apiUser['name']; ?>"
                                    onblur="updateApiName(this)"
                                <?php } ?>
                            />
                        </label>
                    </div>
                    <div class="form-group" style="margin-left:10px">
                        <?php if ($apiUser['access'] === '0') { ?>
                            <input type="submit" class="btn btn-primary" value="Send activation request" />
                        <?php } else { ?>
                            <p>Key is active</p>
                        <?php } ?>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</div>

<div  class="modal" id="addNew" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" action="<?php echo base_url(); ?>profile/addNewApiUser">
        <input type="number" value="<?php echo $userId; ?>" name="userId" readonly required hidden />
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="apiUserName">Api user name: </label>                        
                        <input
                            type="text"
                            id="apiUserName"
                            name="name"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Add" />
                </div>
            </div>
        </div>
    </form>
</div>