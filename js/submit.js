var submit_btn;
var file;
onload=function(){
    $("#twf_photo").on("change",function(){
//        $("#photo_preview")[0].src = $("#twf_photo")[0].value;
        document.getElementById("twf_uploadPhoto").value = this.files[0].name;
        
        if ($("#twf_photo")[0].files && $("#twf_photo")[0].files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#photo_preview').attr('src', e.target.result);
                }
                
                reader.readAsDataURL($("#twf_photo")[0].files[0]);
            }
    })
}


    function download(url){
        var link = document.createElement('a');
        link.href = url;
        link.setAttribute('download','<?php echo $hash?>.'+url.split(".")[3]);
        link.click();
    }