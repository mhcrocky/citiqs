$(document).ready(function() {
 
    var eventTable = $('#events').DataTable({
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
                    let arrow_svg = '<svg aria-hidden="true" data-prefix="fas" data-icon="arrow-square-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24px" height="auto" class="svg-inline--fa fa-arrow-square-right fa-w-14 fa-7x"><path fill="currentColor" d="M48 32h352c26.5 0 48 21.5 48 48v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48zm147.1 119.6l75.5 72.4H88c-13.3 0-24 10.7-24 24v16c0 13.3 10.7 24 24 24h182.6l-75.5 72.4c-9.7 9.3-9.9 24.8-.4 34.3l11 10.9c9.4 9.4 24.6 9.4 33.9 0L372.3 273c9.4-9.4 9.4-24.6 0-33.9L239.6 106.3c-9.4-9.4-24.6-9.4-33.9 0l-11 10.9c-9.5 9.6-9.3 25.1.4 34.4z" class=""></path></svg>';
                    let edit_svg = '<svg aria-hidden="true" data-prefix="fas" data-icon="pen-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24px" fill="blue" class="svg-inline--fa fa-pen-square fa-w-14 fa-7x"><path fill="currentColor" d="M400 480H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48v352c0 26.5-21.5 48-48 48zM238.1 177.9L102.4 313.6l-6.3 57.1c-.8 7.6 5.6 14.1 13.3 13.3l57.1-6.3L302.2 242c2.3-2.3 2.3-6.1 0-8.5L246.7 178c-2.5-2.4-6.3-2.4-8.6-.1zM345 165.1L314.9 135c-9.4-9.4-24.6-9.4-33.9 0l-23.1 23.1c-2.3 2.3-2.3 6.1 0 8.5l55.5 55.5c2.3 2.3 6.1 2.3 8.5 0L345 199c9.3-9.3 9.3-24.5 0-33.9z" class=""></path></svg>';
                    var edit_btn = '<div style="display: inline-block; width: 80px;"><a class="text-primary" href="'+globalVariables.baseUrl+'events/edit/'+data.id+'">'+edit_svg+'</a>';
                    var arrow_right = '<a class="ml-3 text-dark" href="'+globalVariables.baseUrl+'events/event/'+data.id+'">'+arrow_svg+'</i></a></div>';
                    return edit_btn + ' ' + arrow_right;
                }

            }
        ],
       
        displayLength: 25,
        createdRow: function(row, data, dataIndex){
            $(row).attr('id', 'row-' + dataIndex);
        }
    });
    
    $('#selectTime').on('change',function () {
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                let val = $('#selectTime option:selected').val();
                let current_timestamp = dayjs();
                console.log(current_timestamp)
                let end_str_timestamp = data[8] + ' ' + data[10];
                let end_timestamp = dayjs(end_str_timestamp);
                let start_str_timestamp = data[7] + ' ' + data[9];
                let start_timestamp = dayjs(start_str_timestamp);

                if (val == 'past' && current_timestamp >= end_timestamp) { return true;}
                if(val == 'future' && current_timestamp <= start_timestamp) {return true;}
                if(val == 'all') { return true; }
                return false;
                
            });
            setTimeout(() => {
                eventTable.draw();
            }, 2);
            
        });
        
});

