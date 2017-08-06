window.fbAsyncInit = function () {
    var root = location.protocol + '//' + location.host;
    if(root=="http://localhost"){
        FB.init({
      appId      : '313394302404659',
      xfbml      : true,
      version    : 'v2.10'
    });
    }
    else{
        FB.init({
         appId: '220547211801669',
         cookie: true,
         xfbml: true,
         version: 'v2.8'
     });
    }
     
     FB.AppEvents.logPageView();

 };


 (function (d, s, id) {
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {
         return;
     }
     js = d.createElement(s);
     js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));

 window.onload = function () {
     username = $("#input_un")[0];
     console.log(username)
     submit = $("input[type='submit']");
     $('form').submit(function () {
        
         if(newFB==false){
             //old fb login can directly submit
             return true;
         }
    
         var msg="";
         
        if($("[name='username']")[0].value==''){
            msg+="請輪入嘎姆帳號\n";
        }
         if($("[name='password']")[0].value==''&&$("[name='method']")[0].value=="gamelet"){
             msg+="請輪入嘎姆密碼\n";
         }
//         if(!$("[name='username']")[0].value.includes($("[name='method']")[0].value)&&$("[name='method']")[0].value!="gamelet"){
//            msg+="嘎姆帳號必須含有 @"+$("[name='method']")[0].value;
//        }
         if(msg!=""){
             alert(msg);
             return false;
         }
        
    });
 }

function remove(str){
    $(str)[0].parentElement.removeChild($(str)[0]);
}
 var newFB = true;
 
 function FBlogin() {
     FB.login(function (response) {

         console.log(response);
         if (response.status === "connected") {
             //connect to FB successfully
             $("[name='third_party_ac']")[0].value = response.authResponse.userID + "@facebook.com";
             $.ajax({url:"../isNewFB.php?fbid="+response.authResponse.userID,success: function(result){
                 console.log(result);
                 newFB = result;
                 
                 if(newFB==false){
                     $("[name='method']")[0].value = "facebook";
                     $('[name="submit"]').click();
                 }
                 else{
                     remove("#rg");remove("#rg");remove("#rg");
                     window.alert("新FB登入者請在嘎姆帳號欄，填寫你用該FB帳登入的嘎姆帳號");
                 }
             }});
         } else {
             $("input[value='gamelet']").click();
         }

     });
 }


    


