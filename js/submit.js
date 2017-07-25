var submit_btn;
var file;
onload=function(){
    $("#twf_photo").on("change",function(){
//        $("#photo_preview")[0].src = $("#twf_photo")[0].value;
        
        if ($("#twf_photo")[0].files && $("#twf_photo")[0].files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#photo_preview').attr('src', e.target.result);
                }

                reader.readAsDataURL($("#twf_photo")[0].files[0]);
            }
    })
}

function previewPhoto(){
    
}