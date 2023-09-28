<?php
    if(isset($_POST['modify_new'])){
        $idd=$_GET['id'];
        session_start();
        $uid = $_SESSION['userId'];
        $date=$_POST['date_new'];
        $subject=$_POST['subject_new'];
        $descpription=$_POST['descpription_new'];
        $email=$_POST['email_new'];
        $contact=$_POST['contact_new'];
        $sms=$_POST['sms_new'];
        $day7=0;
        $day5=0;
        $day3=0;
        $day2=0;
        if(!empty($_POST['recur_new'])) {    
            foreach($_POST['recur_new'] as $value){
                if($value == 7){
                    $day7=1;
                }
                if($value == 5){
                    $day5=1;
                }
                if($value == 3){
                    $day3=1;
                }
                if($value == 2){
                    $day2=1;
                }
            }
        }
        include 'auth/conn.php';
        $_POST=array();
        $sql = "UPDATE `reminders` set `date` ='$date',`subject` ='$subject',`description` ='$descpription',`email` ='$email',`contact` ='$contact',`sms_no` ='$sms',`day7` ='$day7',`day5` ='$day5',`day3` ='$day3',`day2` ='$day2' where id = '$idd'";
        $result = $conn->query($sql);
        echo $sql;
        if($result){
            header("Location: home.php");
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
    <h2>Modify Reminder</h2>
    <form id="modifyForm" action="#" method="post">
        <label for="date_new">Select date</label><input type="date" name="date_new" onchange="setDate()" id="date_new"><br>
        <p class="error">This field is Mandatory</p><br>
        <label for="subject_new">Subject</label><select name="subject_new" id="subject_new" onchange="setDetails()">
        </select> <br>
        <label for="name_new">Name</label><select name="name_new" id="name_new" onchange="setAllDetails()"></select><br>
        <p class="error">This field is Mandatory</p><br>
        <p class="error">This field is Mandatory</p><br>
        <label for="descpription_new">Add Decription</label><textarea name="descpription_new" id="descpription_new" cols="30" rows="10"></textarea><br>
        <p class="error">This field is Mandatory</p><br>
        <label for="email_new">Email Address</label><input type="email" name="email_new" id="email_new"><br>
        <label for="contact_new">Contact No.</label><input type="tel" name="contact_new" id="contact_new"><br>
        <label for="sms_new">SMS No.</label><input type="tel" name="sms_new" id="sms_new"><br>
        <p class="error">Please fill one field from Email Address,Contact No. and Sms No.</p><br>
        <label>Recurrence</label><input type="checkbox" name="recur_new[]" value="7" id="7day"><label for="7day">7 Days</label><input type="checkbox" name="recur_new[]" id="5day" value="5"><label for="5day">5 Days</label><input type="checkbox" name="recur_new[]" id="3day" value="3"><label for="3day">3 Days</label><input type="checkbox" name="recur_new[]" id="2day" value="2"><label for="2day">2 Days</label><br>
        <div id="submitForm">
            <button id="checkbtn" type="button" onclick="check()">Conform</button>
        </div>
    </form>
    <script>
        function check(){
            let e = document.getElementsByClassName("error");
            f=true;
            if(document.getElementById("date_new").value == ""){
                e[0].style.display = "block";
                f=false;
            }
            else{
                e[0].style.display = "none";
            }
            if(document.getElementById("subject_new").value == ""){
                e[1].style.display = "block";
                f=false;
            }
            else{
                e[1].style.display = "none";
            }
            if(document.getElementById("descpription_new").value == ""){
                e[2].style.display = "block";
                f=false;
            }
            else{
                e[2].style.display = "none";
            }
            if(document.getElementById("email_new").value == "" && document.getElementById("contact_new").value == "" && document.getElementById("sms_new").value == ""){
                e[3].style.display = "block";
                f=false;
            }
            else{
                e[3].style.display = "none";
            }
            if(f){
                document.getElementById("submitForm").innerHTML = '<input type="submit" value="Submit" name="modify_new">';
            }
        }

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
                    document.getElementById("email_new").value = element.email;
                    document.getElementById("contact_new").value = element.contact;
                    document.getElementById("sms_new").value = element.sms_no;
                    if(element.day7=="0"){
                        document.getElementById("7day").checked = false;
                    }
                    else{
                        document.getElementById("7day").checked = true;
                    }
                    if(element.day5=="0"){
                        document.getElementById("5day").checked = false;
                    }
                    else{
                        document.getElementById("5day").checked = true;
                    }
                    if(element.day3=="0"){
                        document.getElementById("3day").checked = false;
                    }
                    else{
                        document.getElementById("3day").checked = true;
                    }
                    if(element.day2=="0"){
                        document.getElementById("2day").checked = false;
                    }
                    else{
                        document.getElementById("2day").checked = true;
                    }
                }
            })
                    
        }

    </script>
</body>
</html>