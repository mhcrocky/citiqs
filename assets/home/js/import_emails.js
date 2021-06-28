$(document).ready(function() {

    $(".tabs").click(function() {

        $(".tabs").removeClass("active");
        $(".tabs h6").removeClass("font-weight-bold");
        $(".tabs h6").addClass("text-muted");
        $(this).children("h6").removeClass("text-muted");
        $(this).children("h6").addClass("font-weight-bold");
        $(this).addClass("active");

        current_fs = $(".active");

        next_fs = $(this).attr('id');
        next_fs = "#" + next_fs + "1";
        let footer = "#" + $(this).attr('id') + "2";

        $("fieldset").removeClass("show");
        $(next_fs).addClass("show");
        $(footer).addClass("show");

        current_fs.animate({}, {
            step: function() {
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({
                    'display': 'block'
                });
            }
        });
    });

});

var selectedFile;
document
    .getElementById("userfile")
    .addEventListener("change", function(event) {
        selectedFile = event.target.files[0];
    });
document
    .getElementById("uploadExcel")
    .addEventListener("click", function() {
        let filename = $("#filename").val();
        let file = filename.split(".");
        let ext = file[1];
        if (ext != 'xls' && ext != 'xlsx') {
            alertify['error']('The filetype you are attempting to upload is not allowed!');
            return;
        }
        if (selectedFile) {
            var fileReader = new FileReader();
            fileReader.onload = function(event) {
                var data = event.target.result;

                var workbook = XLSX.read(data, {
                    type: "binary"
                });
                const sheet_name_list = workbook.SheetNames;
                var sheet_names = XLSX.utils.sheet_to_json(workbook.Sheets[sheet_name_list[0]])
                var row_keys = Object.keys(sheet_names[0]);
                workbook.SheetNames.forEach(sheet => {
                    let rowObject = XLSX.utils.sheet_to_row_object_array(
                        workbook.Sheets[sheet]
                    );
                    let jsonObject = JSON.stringify(rowObject);
                    document.getElementById("jsonData").innerHTML = jsonObject;
                    var html = '<option value="">Select Option</option>';
                    for(var i=0; i < row_keys.length; i++){
                            html += '<option value="'+row_keys[i]+'">'+row_keys[i]+'</option>';
                    }
                    
                    $('.filterSelection').html(html);

                    $(".filterSelection").each(function(index){
                        $(this).val(row_keys[index]);
                    });


                    $('.upload-excel-file').hide();
                    $('.filterFormSection').removeClass('d-none');
                    $('.filterFormSection').show();
                    //console.log(jsonObject);
                });
            };
            fileReader.readAsBinaryString(selectedFile);
        }
    });



function importExcelFile(){

    let emailCol = $('#importEmail option:selected').val();
    let nameCol = $('#importName option:selected').val();
    let jsonData = JSON.parse($('#jsonData').text());
    let customers = [];

    if(nameCol == '' || emailCol == ''){
        alertify['error']('All fields are required!');
        return ;
    }

    $.each(jsonData, function(index, data) {
        
        if(!validEmail(data[emailCol])){ return; }
        customers.push(
            {
                name: data[nameCol],
                email: encodeURI(data[emailCol])
            }
        );
    });

    if(customers.length < 1){
        alertify['error']('Please select a column with emails!');
        return ;
    }

    customers = JSON.stringify(customers);
    $.post(globalVariables.baseUrl + 'customeremail/import_customers', {customers: customers}, function (data) {
        $('#customeremail').DataTable().ajax.reload();
        $('#importEmailsModal').modal('hide');
        goBackToUpload();
        data = JSON.parse(data);
        alertify[data.status](data.message);
    })

    

}


function validEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function goBackToUpload() {
    $('.upload-excel-file').show();
    $('.filterFormSection').hide();

}