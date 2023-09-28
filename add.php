<?php
    if(isset($_POST['add_new'])){
        session_start();
        $uid = $_SESSION['userId'];
        $name = $_POST['name_new'];
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
        print_r($_POST['recur_new']);
        if(!empty($_POST['recur_new'])) {    
            foreach($_POST['recur_new'] as $value){
                if($value == "7"){
                    $day7=1;
                }
                if($value == "5"){
                    $day5=1;
                }
                if($value == "3"){
                    $day3=1;
                }
                if($value == "2"){
                    $day2=1;
                }
            }
        }
        include 'auth/conn.php';
        $_POST=array();
        $sql = "INSERT INTO `reminders`(`user_id`, `date`,`name`, `subject`, `description`, `email`, `contact`, `sms_no`, `day7`, `day5`, `day3`, `day2`, `active`) VALUES ('$uid','$date','$name','$subject','$descpription','$email','$contact','$sms','$day7','$day5','$day3','$day2',1)";
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
    <h2>Set a new Reminder</h2>
    <form action="#" method="post">
        <label for="date_new">Select date</label><input type="date" name="date_new" id="date_new"><br>
        <p class="error">This field is Mandatory</p><br>
        <label for="name_new">Name</label><input type="text" name="name_new" id="name_new"><br>
        <p class="error">This field is Mandatory</p><br>
        <label for="subject_new">Subject</label><select name="subject_new" id="subject_new">
            <?php
                include 'auth/conn.php';
                $sql = "SELECT * FROM `subject`";
                $result = $conn->query($sql);
                echo '<option value="">Select Subject</option>';
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                    }
                }
            ?> 
        </select> <br>
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
            if(document.getElementById("name_new").value == ""){
                e[1].style.display = "block";
            }
            else{
                e[1].style.display = "none";
            }
            if(document.getElementById("subject_new").value == ""){
                e[2].style.display = "block";
                f=false;
            }
            else{
                e[2].style.display = "none";
            }
            if(document.getElementById("descpription_new").value == ""){
                e[3].style.display = "block";
                f=false;
            }
            else{
                e[3].style.display = "none";
            }
            if(document.getElementById("email_new").value == "" && document.getElementById("contact_new").value == "" && document.getElementById("sms_new").value == ""){
                e[4].style.display = "block";
                f=false;
            }
            else{
                e[4].style.display = "none";
            }
            if(f){
                document.getElementById("submitForm").innerHTML = '<input type="submit" value="Submit" name="add_new">';
            }
        }
    </script>
</body>
</html>