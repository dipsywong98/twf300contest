window.fbAsyncInit = function () {
     FB.init({
         appId: '220547211801669',
         cookie: true,
         xfbml: true,
         version: 'v2.8'
     });
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


