


$(document).ready(function () {


  var table = $("#vouchersend").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "Api/Voucher/vouchersend",
      dataSrc: "",
    },
    columns: [
      {
        title: "ID",
        data: "id",
      },
      {
        title: "Name",
        data: "name",
      },
      {
        title: "Email",
        data: "email",
      },
      {
        title: "Number Of Times",
        data: "numberOfTimes",
      },
      {
        title: "Send",
        data: null,
        "render": function (data, type, row) {
          if(data.send == 1){
            return 'Yes';
          }
          return 'No';
        }
      },
      {
        title: "Voucher Description",
        data: "description",
      },
      {
        title: "Date Created",
        data: "datecreated",
      }
      
    ],
    order: [[1, 'asc']]
  });

  $('#report_filter').addClass('text-right');
  $('#report_filter label').addClass('text-left');

});

