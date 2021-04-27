


$(document).ready(function () {


  var table = $("#qrcode").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "qrcode/get_qrcodes",
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
        title: "Spot",
        data: "spot",
      },
      {
        title: "Spot Name",
        data: "spotName",
      },
      {
        title: "Affiliate",
        data: "affiliate",
      },
      {
        title: "Date Created",
        data: "timestamp",
      },
      {
        title: "Action",
        data: null,
        "render": function (data, type, row) {
          let html = '<input type="hidden" id="spot_'+data.id+'" value="'+data.spot+'">';
          html += '<button class="btn btn-success" onclick="editSpot('+data.id+')" data-toggle="modal" data-target="#editQRCodeModal">Edit</button>';
          return html;

        }
      },

      
    ],
    order: [[1, 'asc']]
  });



});


function qrcodeForm() {
  $('#submitQrcode').click();
}

function save_qrcode(e){
  e.preventDefault();
  $('.form-control').removeClass('input-clear');
  if ($('.form-control:invalid').length > 0) {
    return;
  }
  
  let data = {
      qrcodeId: $('#qr_codeId').val(),
      spot: $('#spot option:selected').val(),
      affiliate: $('#affiliate').val()
  }

  //console.log(data);

  $('#submitQrcode').prop('disabled', true);

  $.post(globalVariables.baseUrl + "qrcode/save_qrcode", data, function(data){
      $('#submitQrcode').prop('disabled', false);
      data = JSON.parse(data);
      if(data.status == 'success'){
        $('#qrcode').DataTable().ajax.reload();
        $('#resetForm').click();
        $('#closeModal').click();
        $('.form-control').addClass('input-clear');
        alertify['success']('Saved Successfully!');
        return;
      }

      alertify[data.status](data.message);

      

  });

}

function editSpot(id){
  let spot = $('#spot_'+id).val();
  $('#editspot').val(spot);
  $('#qrcodeId').val(id);
}

function update_qrcode() {
  let data = {
    qrcodeId: $('#qrcodeId').val(),
    spot: $('#editspot option:selected').val(),
  }
  
  $.post(globalVariables.baseUrl + "qrcode/update_qrcode", data, function(data){
    $('#closeEditModal').click();
    $('#qrcode').DataTable().ajax.reload();
    alertify['success']('Updated Successfully!');

});
}