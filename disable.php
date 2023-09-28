<?php
    if(isset($_POST['disable_btn'])){
        $idd=$_GET['id'];
        echo $idd;
        include 'auth/conn.php';
        $_POST=array();
        $sql = "UPDATE `reminders` set active='0' where id = '$idd'";
        $result = $conn->query($sql);
        echo $sql;
        if($result){
            echo '<script>alert("Reminder Disabled");
            window.location.href = "home.php";</script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Reminder</title>
</head>
<body>
    <style>
        .error{
            color: red;
            display: none;
        }
    </style>
    <h2>Disable a new Reminder</h2>
    <form id="modifyForm" action="#" method="post">
        <label for="date_new">Select date</label><input type="date" name="date_new" onchange="setDate()" id="date_new"><br>
        <label for="subject_new">Subject</label><select name="subject_new" id="subject_new" onchange="setDetails()"></select><br>
        <label for="name_new">Name</label><select name="name_new" id="name_new" onchange="setAllDetails()"></select><br>
        <label for="descpription_new">Add Decription</label><textarea name="descpription_new" id="descpription_new" readonly cols="30" rows="10"></textarea><br>
        <div id="submitForm">
        <input type="submit" value="Submit" name="disable_btn">
        </div>
    </form>
    <script>
        const data = <?php include "activeReminder.php" ?> ;
        let dateWise=[];
        if(data.length==0){
            alert("No Reminders");
            window.location.href = "home.php";
        }
        let dateSubjects=[];
        function setDate() {
            var dateSelect = document.getElementById("date_new").value;
            var subjectsHTML = '<option value="">Select Subject</option>';
            data.forEach(element => {
                if(element.date==dateSelect){
                    dateWise.push(element);
                    subjectsHTML += '<option value="'+element.subject+'">'+element.subject+'</option>';
                }
            });
            var subjects = document.getElementById("subject_new");
            subjects.innerHTML = subjectsHTML;
          }
        function setDetails(){
            var subject = document.getElementById("subject_new").value;
            var dateNameHtml = '<option value="">Select Name</option>';
            dateWise.forEach(element => {
                if(element.subject==subject){
                    dateSubjects.push(element);
                    dateNameHtml += '<option value="'+element.name+'">'+element.name+'</option>';
                }
            });
            document.getElementById("name_new").innerHTML = dateNameHtml;
        }

        function setAllDetails(){
            var name = document.getElementById("name_new").value;
            dateSubjects.forEach(element => {
                if(element.name==name){
                    document.getElementById("modifyForm").action = "?id="+element.id;
                    document.getElementById("descpription_new").value = element.description;
                }
            })
                    
        }

    </script>
</body>
</html>