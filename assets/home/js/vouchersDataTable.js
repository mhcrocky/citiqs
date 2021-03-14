$(document).ready(function () {

  var table = $("#report").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "Api/Voucher/vouchers",
      dataSrc: "",
    },
    columns: [
      {
        title: "ID",
        data: "id",
      },
      {
        title: "Code",
        data: "code",
      },
      {
        title: "Description",
        data: "description",
      },
      {
        title: "Percent",
        data: "percent",
      },
      {
        title: "Amount",
        data: "amount",
      },
      {
        title: "Percent Used",
        data: "percentUsed",
      },
      {
        title: "Active",
        data: null,
        "render": function (data, type, row) {
          if(data.active == 1){
            return 'Yes';
          }
          return 'No';
        }
      },
      {
        title: "Number Of Times",
        data: "numberOfTimes",
      },
      {
        title: "Activated",
        data: null,
        "render": function (data, type, row) {
          if(data.activated == 1){
            return 'Activated';
          }
          return 'Deactivate';
        }
      },
      {
        title: "Product Id",
        data: "productId",
      }
    ],
  });

  $('#report_filter').addClass('text-right');
  $('#report_filter label').addClass('text-left');

});
