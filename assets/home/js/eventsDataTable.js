$(document).ready(function() {

    var table = $('#events').DataTable({
        columnDefs: [{
            "visible": false,
        }],
        ajax: {
            type: 'get',
            url: globalVariables.baseUrl +"events/get_events",
            dataSrc: '',
        },
        columns: [
            {

                title: 'ID',
                data: 'id'

            },

            {

                title: 'Name',
                data: 'eventname'

            },
            {

                title: 'Description',
                data: 'eventdescript'

            },
            {

                title: 'Venue',
                data: 'eventVenue'

            },
            {

                title: 'Address',
                data: 'eventAddress'

            },
            {

                title: 'City',
                data: 'eventCity'

            },
            {

                title: 'Country',
                data: 'eventCountry'

            },
            {

                title: 'Postal Code',
                data: 'eventZipcode'

            },
            {

                title: 'Start Date',
                data: 'StartDate'

            },
            {

                title: 'End Date',
                data: 'EndDate'

            },
            {

                title: 'Start Time',
                data: 'StartTime'

            },
            {

                title: 'End Time',
                data: 'EndTime'

            },
            {

                title: 'Actions',
                data: null,
                "render": function(data, type, row) {
                    return '<a class="text-dark" href="'+globalVariables.baseUrl+'events/event/'+data.id+'"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>';
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

