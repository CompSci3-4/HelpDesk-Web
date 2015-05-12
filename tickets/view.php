<?php
    require_once("../start_session.php");
    require_once("../database/ticket.php");
    require_once("../database/status.php");
    $consultantDropdown = "<button id='showConsultant'>edit</button><form class='hidden-form' id='setConsultant'><select id='consultant'>";
    $managerDropdown = '<button id="showManager">edit</button><form class="hidden-form" id="setManager"><select id="manager">';
    $statusDropdown = '<button id="showStatus">edit</button><form class="hidden-form" id="setStatus"><select id="status">';
    foreach(User::allConsultants() as $consultant) {
        $consultantDropdown .= "<option value = {$consultant->getUsername()}>{$consultant->getName()}</option>";
    }
    foreach(User::allManagers() as $manager) {
        $managerDropdown .= "<option value = {$manager->getUsername()}>{$manager->getName()}</option>";
    }
    foreach(Status::allStatuses() as $status) {
        $name = Status::toString($status);
        $statusDropdown .= "<option value = {$status}>{$name}</option>";
    }
    $consultantDropdown .= '<input type ="submit" value="set"></select></form>';
    $managerDropdown .= '<input type ="submit" value="set"></select></form>';
    $statusDropdown .= '<input type ="submit" value="set"></select></form>';
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" >
    $( document ).ready(function() {
        $("#showStatus").click(function () {
            $("#setStatus").show();
            $("#showStatus").hide();
        });
        $("#setStatus").submit(function () {
           var status = $("#status").val(); 
           var ticket = <?php echo $_GET['id'];?>;
           var url = "<?php echo $config['root_directory'] . '/api/tickets.php?id='?>" + ticket;
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
           var ticket = <?php echo $_GET['id'];?>;
           var url = "<?php echo $config['root_directory'] . '/api/tickets.php?id='?>" + ticket;
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
           var ticket = <?php echo $_GET['id'];?>;
           var url = "<?php echo $config['root_directory'] . '/api/tickets.php?id='?>" + ticket;
           $.ajax(url, {method: 'PATCH', data: {"manager": manager}});
           $("#managerName").html($("#manager :selected").text());
           $("#setManager").hide();
            $("#showManager").show();
           return false;
        })});
           </script>
    </head>
    <body>
    <?php include("../header.php") ?>
        <form action=<?php echo 'list.php?user=' . $_SESSION['id']; ?> method="get"> 
            <button class="submit" type="submit" >Back</button>
        </form>
        <table>
            <tr>
                <td>User</td>
                <td>Description</td>
                <td>Consultant</td>
                <td>Manager</td>
                <td>Status</td>
                <td>Date</td>
            </tr>
        <?php $ticket = new Ticket($_GET['id']);
              $user = new User($_SESSION['id']);?>
            <tr>
                <td><a href=<?php echo $ticket->getUser()->getHTML(); ?>>
                             <?php echo $ticket->getUser()->getName(); ?></a></td>
                <td><?php echo $ticket->getDescription(); ?></td>
                <td><a id="consultantName" href=<?php echo $ticket->getConsultant()->getHTML(); ?>>
                    <?php echo $ticket->getConsultant()->getName(); ?></a><?php if($user->getPositionID() >= Position::Manager) echo $consultantDropdown;?></td>
                <td><a id="managerName" href=<?php echo $ticket->getManager()->getHTML(); ?>>
                    <?php echo $ticket->getManager()->getName(); ?></a><?php if($user->getPositionID() >= Position::Admin) echo $managerDropdown;?></td>
                <td><span id="statusName"><?php echo $ticket->getStatus(); ?></span><?php if($user->getPositionID() >= Position::Consultant) echo $statusDropdown;?></td>
                <td><?php echo $ticket->getDate(); ?></td>
            </tr>
        </table>
    </body>
</html>
