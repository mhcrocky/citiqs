<!-- Add Video Description Modal -->
<div class="modal fade" id="addDescriptionModal" tabindex="-1" role="dialog" aria-labelledby="addDescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-dark" id="addDescriptionModalLabel">Add Video Description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <label for="description" class="font-weight-bold">Description</label>
            <textarea id="description" class="form-control" placeholder="Video Description"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
<main class="my-form">
    <div class="w-100 mt-5 p-3">
        <table id="videos" class="mt-5" style="width:100%;background: #fff;">

        </table>
    </div>
</main>