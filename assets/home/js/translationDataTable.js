


$(document).ready(function () {


  var table = $("#translation").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "post",
      url: baseUrl + "translate/get_languages",
      data: function(data) {
        data.language = $("#language option:selected").val();
    },
      dataSrc: "",
    },
    columns: [
      {
        title: "ID",
        data: "id"
      },
      {
        title: "Text",
        data: "key"
      },
      {
        title: "Lang ID",
        data: "langID",
      },
      {
        title: "Translation",
        data: null, 
        "render": function(data, type, row ){
          let html = `<textarea class="edit-translation disabled" id="textarea_`+data.id+`" rows="4" cols="100" onchange="saveTranslation(this, `+data.id+`)" type="text" form="translationsForm" >`+data.text.replace(/(<([^>]+)>)/gi, "").replace(/\s\s+/g, ' ').trim()+`</textarea>`;
          return html;
        }
      },
      {
        title: "Action",
        data: null, 
        "render": function(data, type, row ){
          let html = `<button class="btn btn-danger" onclick="deleteTranslation(this, `+data.id+`)">Delete</button>`;
          return html;
        }
      },
      
    ],
    order: [[1, 'asc']]
  });


});

function saveTranslation(el,id){
  let correctedTranslation = $(el).val();
  $.ajax({
    type: "POST",
    url: baseUrl+"translate/editTranslation/" + id,
    data: {
      correctedTranslation: correctedTranslation
    },
    success: function (response) {
      $("#text_" + id).text(correctedTranslation);
      // alert(response);
    },
    error: function (response) {
      alert(response);
    }
  });
}

function deleteTranslation(el,id){
  let correctedTranslation = $("textarea_"+id).val();
  if (window.confirm("Are you sure?")) {
    if (correctedTranslation === "") {
      $.ajax({
        type: "POST",
        url: baseUrl+"translate/deleteTranslation/" + id,
        data: {
          correctedTranslation: correctedTranslation
        },
        success: function (response) {
          $("#text_" + id).text("deleted");
          $("#translation").DataTable().ajax.reload();
        },
        error: function (response) {
          alert(response);
        }
      });
    } else {
      alert("Text needs to be empty." );
      
    }
    return ;
  }
}