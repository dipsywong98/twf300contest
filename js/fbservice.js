 $.getScript( "fbservice_init.js" );

 window.onload = function () {
     username = $("#input_un")[0];
     console.log(username)
     submit = $("input[type='submit']");
 }


 function FBlogin() {
     FB.login(function (response) {

         console.log(response);
         if (response.status === "connected") {
             //connect to FB successfully
             username.value = response.authResponse.userID + "@facebook.com";
         } else {
             $("input[value='gamelet']").click();
         }

     });
 }


