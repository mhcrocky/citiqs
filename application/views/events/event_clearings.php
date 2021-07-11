<div class="row mt-5 p-4">

    <div class="col-md-4 mb-3">
        <div class="input-group">
            <input type="button"  value="<?php echo $this->language->tLine('Create Event Clearing'); ?>"
                style="background: #10b981 !important;border-radius:0;height:45px;"
                class="btn btn-primary form-control mb-3 text-left" data-toggle="modal" data-target="#createEventClearingModal">
            <span style="background: #275C5D; padding-top: 14px;"
                class="input-group-addon pl-2 pr-2 mb-3" data-toggle="modal" data-target="#createEventClearingModal">
                <i style="color: #fff;font-size: 18px;" class="fa fa-list"></i>
            </span>
        </div>
    </div>

</div>

<div class="w-100 mt-3 table-responsive p-4">
    <table id="eventClearings" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
    </table>
</div>
<input type="hidden" id="eventId" value="0">




<!-- Create Event Clearings Modal -->
<div class="modal fade" id="createEventClearingModal" tabindex="-1" role="dialog" aria-labelledby="createEventClearingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <form id="eventClearing-form" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="createEventClearingtModalLabel"><?php echo $this->language->tLine('Create Event Clearing'); ?></h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-left m">
                            Description
                        </label>
                        <div class="col-md-6">
                            <input type="text" name="description" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-left">
                            Event
                        </label>
                        <div class="col-md-6">

                            <select name="eventId" onchange="getPromoterAmount(this, 'addAmount')"
                                class="form-control input-w" required>
                                <option value="">Select option</option>
                                <?php if(is_countable($events) && count($events) > 0): ?>
                                    <?php foreach($events as $event): ?>
                                    <option value="<?php echo $event['id']; ?>"><?php echo $event['eventname']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-left m">
                            Amount
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="promoterAmount form-control" name="amount" id="addAmount">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-left m">
                            Date
                        </label>
                        <div class="col-md-6">
                            <input type="date" name="date" class="form-control" required>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeEmailModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
    </div>
</div>
<!-- End Create Event Clearings Modal -->


<!-- Edit Event Clearings Modal -->
<div class="modal fade" id="editEventClearingModal" tabindex="-1" role="dialog" aria-labelledby="editEventClearingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <form id="editEventClearing-form" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editEventClearingtModalLabel"><?php echo $this->language->tLine('Create Event Clearing'); ?></h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                   <input type="hidden" id="clearingId" name="id">
                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-left m">
                            Description
                        </label>
                        <div class="col-md-6">
                            <input type="text" id="description" name="description" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="selectEventId" class="col-md-4 col-form-label text-md-left">
                            Event
                        </label>
                        <div class="col-md-6">

                            <select id="selectEventId" name="eventId" onchange="getPromoterAmount(this, 'amount')"
                                class="form-control input-w" required>
                                <option value="">Select option</option>
                                <?php if(is_countable($events) && count($events) > 0): ?>
                                    <?php foreach($events as $event): ?>
                                    <option value="<?php echo $event['id']; ?>"><?php echo $event['eventname']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="amount" class="col-md-4 col-form-label text-md-left m">
                            Amount
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="amount form-control" name="amount" id="amount">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="date" class="col-md-4 col-form-label text-md-left m">
                            Date
                        </label>
                        <div class="col-md-6">
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeEmailModal" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
    </div>
</div>
<!-- End Edit Event Clearings Modal -->