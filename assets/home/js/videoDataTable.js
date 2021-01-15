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
                title: 'Action',
                data: null,
                "render": function (data, type, row) {
                return '<a href="#" title="Delete" class="text-danger" onclick="deleteVideo(\''+data.filename+'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
              }
            }


            
        ],
       
        displayLength: 25,
        createdRow: function(row, data, dataIndex){
            $(row).attr('id', 'row-' + dataIndex);
        }
    });

    table.rowReordering();



    /*Order by the grouping
    $('#tickets tbody').on('click', 'tr.group', function() {
        var currentOrder = table.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
            table.order([groupColumn, 'desc']).draw();
        } else {
            table.order([groupColumn, 'asc']).draw();
        }
    });
    */
});

function deleteVideo(filename){
    confirm('Are you sure?');
    $.post(globalVariables.baseUrl + "video/delete_video", {filename: filename}, function(data){
        $('#videos').DataTable().ajax.reload();
        $('#videos').DataTable().draw();
        alertify['success']('File is deleted successfully!');
    });
}

