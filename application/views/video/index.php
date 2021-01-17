<!-- Add Video Description Modal -->
<div class="modal fade" id="addDescriptionModal" tabindex="-1" role="dialog" aria-labelledby="addDescriptionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="addDescriptionModalLabel">Add Video Description
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="description" class="font-weight-bold">Description</label>
                <input type="hidden" id="video_id" name="id">
                <textarea id="description" class="form-control" placeholder="Video Description"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="saveDescription()" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
<input type="hidden" name="vendor_id" id="vendor_id" value="<?php echo $userId; ?>">
<!-- Video Description Modal -->
<div class="modal fade" id="uploadVideoModal" tabindex="-1" role="dialog" aria-labelledby="uploadVideoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="uploadVideoLabel">Video Uploader</h5>
                <button type="button" class="close" id="closeUploader" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadVideo" action="<?php echo base_url(); ?>api/video/upload_post" method="POST"
                enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="file" name="userfile" id="userfile">

                </div>
                <div class="modal-footer">
                    <button type="button" id="closeModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i>
                        &nbsp Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Play Video Modal -->
<div class="modal fade" id="playVideoModal" tabindex="-1" role="dialog" aria-labelledby="playVideoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="video" class="modal-body">

            </div>
        </div>
    </div>
</div>


<main class="my-form">
    <div class="w-100 mt-5 p-3">
        <a class="btn btn-primary mb-3" href="#" data-toggle="modal" data-target="#uploadVideoModal">
            <i class="fa fa-upload" aria-hidden="true"></i>
            &nbsp Upload Video
        </a>
        <div class="w-100 table-responsive">
            <table id="videos" class="mt-5" style="width:100%;background: #fff;">

            </table>
        </div>
    </div>
</main>