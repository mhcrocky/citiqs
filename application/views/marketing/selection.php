<div class="main-wrapper">

    <div class="container">
        <div class="w-100 table-responsive pb-4">
            <table id="buyers" class="table table-striped table-bordered" cellspacing="0" width="100%">
            </table>
        </div>

        <hr>

        <p class="text-left"><button type="button" class="btn btn-primary" data-toggle="modal"
                data-target="#messageModal" data-whatever="@mdo">Choose</button>
        </p>
        <hr>

        <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="messageModalLabel">New message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>

                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Message:</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="closeModal" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button id="sendMessage" type="button" class="btn btn-primary">Send message</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="userMessageModal" tabindex="-1" role="dialog"
            aria-labelledby="userMessageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userMessageModalLabel">New message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>

                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Message:</label>
                                <textarea class="form-control" id="usermessage-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <input id="buyerId" type="hidden" value="">
                        <button id="closeUserModal" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button id="sendUserMessage" type="button" class="btn btn-primary">Send message</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<div class="modal fade" id="editOneSignalIdModal" tabindex="-1" role="dialog" aria-labelledby="editOneSignalIdModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="editOneSignalIdModalLabel">Edit OneSignal ID</h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label for="buyerOneSignalId" class="col-md-4 col-form-label text-md-left">
                        OneSignal ID
                    </label>
                    <div class="col-md-6">
                        <input type="hidden" id="editBuyerId">
                        <input type="text" id="buyerOneSignalId" class="input-w border-50 form-control" name="buyerOneSignalId">
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" id="closeOneSignalModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="updateOneSignalId()" class="btn btn-primary">Update OneSignal ID</button>
            </div>
        </div>
    </div>
</div>