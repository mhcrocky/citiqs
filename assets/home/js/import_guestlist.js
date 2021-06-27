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

                });
            };
            fileReader.readAsBinaryString(selectedFile);
        }
    });


function goBackToUpload() {
    $('.upload-excel-file').show();
    $('.filterFormSection').hide();

}