$(document).ready(function() {
    $("#showStatus").click(function () {
        $("#setStatus").show();
        $("#showStatus").hide();
    });
    $("#setStatus").submit(function () {
       var status = $("#status").val(); 
       var search = document.location.search;
       var ticket = search.substring(search.indexOf("=") + 1);
       var url = "../api/tickets.php?id=" + ticket;
       $.ajax(url, {method: 'PATCH', data: {"status": status}});
       $("#statusName").html($("#status :selected").text());
       $("#setStatus").hide();
        $("#showStatus").show();
       return false;
    });
    $("#showConsultant").click(function () {
        $("#setConsultant").show();
        $("#showConsultant").hide();
    });
    $("#setConsultant").submit(function () {
       var consultant = $("#consultant").val(); 
       var search = document.location.search;
       var ticket = search.substring(search.indexOf("=") + 1);
       var url = "../api/tickets.php?id=" + ticket;
       $.ajax(url, {method: 'PATCH', data: {"consultant": consultant}});
       $("#consultantName").html($("#consultant :selected").text());
       $("#setConsultant").hide();
        $("#showConsultant").show();
       return false;
    });
    $("#showManager").click(function () {
        $("#setManager").show();
        $("#showManager").hide();
    });
    $("#setManager").submit(function () {
       var manager = $("#manager").val(); 
       var search = document.location.search;
       var ticket = search.substring(search.indexOf("=") + 1);
       var url = "../api/tickets.php?id=" + ticket;
       $.ajax(url, {method: 'PATCH', data: {"manager": manager}});
       $("#managerName").html($("#manager :selected").text());
       $("#setManager").hide();
        $("#showManager").show();
       return false;
    })
});
