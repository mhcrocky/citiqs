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

                title: 'Archived',
                data: null,
                "render": function(data, type, row) {
                    if(data.archived == 1){
                        return 'Yes';
                    }
                    return 'No';
                }

            },
            {

                title: 'Actions',
                data: null,
                "render": function(data, type, row) {
                    
                    let html = '<div style="display: inline-flex; width: 180px;justify-content: center;"><a class="event-icons mr-1" href="'+globalVariables.baseUrl+'events/edit/'+data.id+'"><i class="gg-pen mx-auto"></i></a>';
                    html += '<a class="event-icons ml-3" style="font-size: 19px;color: #3c4859" href="'+globalVariables.baseUrl+'events/guestlist/'+data.id+'"><i class="gg-user-list"></i></a>'
                    html += '<a class="event-icons ml-3" style="color: #3c4859" href="'+globalVariables.baseUrl+'events/event/'+data.id+'"><i class="ti-ticket ticket-icon"></i></a></div>';
                    return html;
                }

            },
            {

                title: 'Shop',
                data: null,
                "render": function(data, type, row) {
                    return '<a href="'+globalVariables.baseUrl+'events/shop/'+data.id+'" style="background: #10b981;" class="btn btn-primary">Go To Shop</a>'
                }

            }
        ],
       
        displayLength: 25,
        createdRow: function(row, data, dataIndex){
            $(row).attr('id', 'row-' + dataIndex);
        }
    });
    
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            if(settings.nTable.id == 'events'){
                let val = $('#selectTime option:selected').val();
                let current_timestamp = dayjs();
                let end_str_timestamp = data[8] + ' ' + data[10];
                let end_timestamp = dayjs(end_str_timestamp);
                let start_str_timestamp = data[7] + ' ' + data[9];
                let start_timestamp = dayjs(start_str_timestamp);
                
                if (val == 'past' && current_timestamp >= end_timestamp) { return true;}
                if(val == 'future' && current_timestamp <= start_timestamp) {return true;}
                if(val == 'archived' && data[11] == 'Yes') { return true; }
                if(val == 'all') { return true; }
                return false;
            }
            return true;
            
    });

    $('#selectTime').change(function () {
        setTimeout(() => {
            eventTable.draw();
        }, 2);
            
    });


    var guestlistTable = $("#guestlist").DataTable({
        processing: true,
        lengthMenu: [
          [5, 10, 20, 50, 100, 200, 500, -1],
          [5, 10, 20, 50, 100, 200, 500, "All"],
        ],
        pageLength: 5,
        ajax: {
          type: "get",
          url: globalVariables.baseUrl + "events/get_guestlists",
          dataSrc: "",
        },
        columns: [
          {
            title: "ID",
            data: "id",
          },
          {
            title: "Guest Name",
            data: "guestName",
          },
          {
            title: "Guest Email",
            data: "guestEmail",
          },
          {
            title: "Ticket Quantity",
            data: "ticketQuantity",
          },
          {
            title: "Ticket ID",
            data: "ticketId",
          },
          {
            title: "Reservation ID",
            data: "reservationId",
          },
          {
              title: 'Resend',
              data: null,
              "render": function(data, type, row) {
                return '<button class="btn btn-primary" onclick="resendReservation(\''+data.reservationId+'\')">Resend</button>';
            }
           }
          
        ],
        order: [[1, 'asc']]
      });
        
});


function resendReservation(reservationId){
    $.post(globalVariables.baseUrl + "events/resend_reservation", {reservationId: reservationId}, function(data){
        alertify['success']('Resent Successfully!');
    });
}