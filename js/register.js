$(document).ready(function() {
    var success = function(data, status, XHR) {
        window.location = "tickets/list.php";
    }
    var failure = function(XHR, status, error) {
        window.location.reload();
    }
    $("#register").submit(function () {
       var username = $("#username").val(); 
       var password = $("#password").val(); 
       var first = $("#first").val(); 
       var last = $("#last").val(); 
       var email = $("#email").val(); 
       var room = $("#room").val(); 
       var url = "api/users.php";
       var promise = $.ajax(url, {
           method: 'POST', data: {
               "username": username,
               "password": password,
               "first": first,
               "last": last,
               "email": email,
               "room": room
           }
       });
       promise.done(success);
       promise.fail(failure);
       return false;
    });
});
