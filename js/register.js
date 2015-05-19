$(document).ready(function() {
    $("#register").submit(function () {
       var username = $("#username").val(); 
       var password = $("#password").val(); 
       var first = $("#first").val(); 
       var last = $("#last").val(); 
       var email = $("#email").val(); 
       var room = $("#room").val(); 
       var url = "../api/users.php";
       $.ajax(url, {
           method: 'POST', data: {
               "username": username,
               "password": password,
               "first": first,
               "last": last,
               "email": email,
               "room": room
           }
       });
       return false;
    });
});
