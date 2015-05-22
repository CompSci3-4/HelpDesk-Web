$(document).ready(function() {
    var failure = function(XHR, status, error) {
        alert(status+error);
    }
    $("#changePassword").submit(function () {
       var password = $("#newPassword").val(); 
       var url = "api/account.php";
       var promise = $.ajax(url, {method: 'PATCH', data: {"password": password}});
       promise.done(function() {alert("it worked?");});
       promise.fail(failure);
       return false;
    });
});
