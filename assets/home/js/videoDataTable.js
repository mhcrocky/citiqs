$(document).ready(function() { 

    var table = $('#videos').DataTable({
        columnDefs: [{
            "visible": false,
        }],
        ordering:true,
        ajax: {
            type: 'get',
            url: globalVariables.baseUrl +"video/get_videos",
            dataSrc: '',
        },
        columns: [
            {

                title: 'ID',
                data: 'id'

            },

            {

                title: 'Filename',
                data: 'filename'

            },
            {
                title: 'Description',
                data: null,
                "render": function (data, type, row) {
                    if(data.description != ""){
                        return data.description;
                    }
                    let html = '<a href="#" title="Add Description" onclick="addDescription(\''+data.id+'\')" class="text-primary" data-toggle="modal" data-target="#addDescriptionModal"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp Add Description</a>';
                    return html;
              }
            },
            {
                title: 'Created At',
                data: 'date_created',
            },
            {
                title: 'Video',
                data: null,
                "render": function (data, type, row) {
                    let html = '<a href="#" title="Play Video" onclick="playVideo(\''+data.filename+'\',\''+data.userId+'\')" class="text-primary" data-toggle="modal" data-target="#playVideoModal"><i class="fa fa-youtube-play" aria-hidden="true"></i> &nbsp Watch Video</a>';
                    return html;
              }
            },
            {
                title: 'Action',
                data: null,
                "render": function (data, type, row) {
                    let html = '<a href="#" title="Delete" class="text-danger" onclick="deleteVideo(\''+data.filename+'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    return html;
              }
            },
            {
                title: '',
                data: null,
                "render": function (data, type, row) {
                    return '<a class="btn btn-success" href="'+globalVariables.baseUrl+'uploads/video/'+data.userId+'/'+data.filename+'" download>Download Video</a>';
              }
            }


            
        ],
       
        displayLength: 25,
        createdRow: function(row, data, dataIndex){
            $(row).attr('id', 'row-' + dataIndex);
        }
    });

    $('#playVideoModal').on('hidden.bs.modal', function () {
        $('#video').empty();
    });

    $('#uploadVideo').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append('vendor_id', $("#vendor_id").val());
        formData.append('userfile', $("#userfile")[0].files[0]);

        $.ajax({
            url: globalVariables.baseUrl + "api/video/upload_post",
            data:formData,
            type:'POST',
            contentType: false,
            processData: false,
            success: function(data){
                alertify['success'](data.text);
                $('#closeUploader').click();
                setTimeout(function(){ window.location.href = globalVariables.baseUrl+"video"; }, 2000);
            },
            error: function(data){
                let error = data.responseJSON;
                alertify['error'](error.text);
            }
        });
    });

});

function deleteVideo(filename){
    var r = confirm('Are you sure?');
    if(r != true){
        return ;
    }
    $.post(globalVariables.baseUrl + "video/delete_video", {filename: filename}, function(data){
        $('#videos').DataTable().ajax.reload();
        $('#videos').DataTable().draw();
        alertify['success']('File is deleted successfully!');
    });
}

function addDescription(id){
    $("#video_id").val(id);
}

function playVideo(filename, userId){
    let html = '<video controls="" preload="metadata" width="100%" height="auto">'+
    '<source src="'+globalVariables.baseUrl+'uploads/video/'+userId+'/'+filename+'">'+
    '</video>';
    $("#video").html(html);

}

function saveDescription(id){
    let data = {
        id: $("#video_id").val(),
        description: $("textarea#description").val()
    }
    $.post(globalVariables.baseUrl + "video/add_video_description", data, function(data){
        $('#videos').DataTable().ajax.reload();
        $('#videos').DataTable().draw();
        $('#closeModal').click();
        alertify['success']('Description is deleted successfully!');
    });
}

