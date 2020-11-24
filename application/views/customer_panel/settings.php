<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<style>
span.note-icon-caret{
    display: none;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<div class="w-100 p-5 mt-2">
<textarea id="summernote"><?php echo $termsofuse->body; ?></textarea>
<div class="text-right">
    <button id="save" class="btn btn-primary mt-2">Save</button>
</div>
  <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 100,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
                ]
        });
        $('#save').on('click', function(){
            let content = $('textarea#summernote').val();
            $.post("<?php echo base_url('ajaxdorian/saveTermsofuse');?>",{content:content}, function(data){
                data = JSON.parse(data);
                let status = data['status'];
                if(status == 'success') {
                    alertify.success(data['msg']);
                } else {
                    alertify.error(data['msg']);
                }
                
            });
        });
    });
  </script>