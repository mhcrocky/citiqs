$(document).ready(function() { 

    var table = $('#videos').DataTable({
        columnDefs: [{
            "visible": false,
        }],
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
                title: 'Action',
                data: null,
                "render": function (data, type, row) {
                    let html = '<a href="#" title="Delete" class="text-danger" onclick="deleteVideo(\''+data.filename+'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    return html;
              }
            }


            
        ],
       
        displayLength: 25,
        createdRow: function(row, data, dataIndex){
            $(row).attr('id', 'row-' + dataIndex);
        }
    });

    table.rowReordering();


});

function deleteVideo(filename){
    confirm('Are you sure?');
    $.post(globalVariables.baseUrl + "video/delete_video", {filename: filename}, function(data){
        $('#videos').DataTable().ajax.reload();
        $('#videos').DataTable().draw();
        alertify['success']('File is deleted successfully!');
    });
}

function addDescription(id){
    $("#video_id").val(id);
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

