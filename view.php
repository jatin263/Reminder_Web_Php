<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
        table,tr,td{
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <h1>View Your Reminders</h1>
    <form style="display: flex;justify-content: space-between;" action="#" method="post">
        <div><label>Select From Date: </label><input type="date" name="sdate"></div>
        <div><label>Select To Date: </label><input type="date" name="edate"></div>
        <div><input type="submit" value="View" name="view_btn" style="margin: auto;"></div>
    </form><br><label for="subject">Subject</label>
    <select name="subject" id="subject" onchange="filterData()"></select><br><br>
    <div id="pBody">

    </div>
    <script>
        const data =
        <?php
        include 'auth/conn.php' ;
            if(isset($_POST['view_btn'])){
                $sdate=$_POST['sdate'];
                $edate=$_POST['edate'];
                $sql = "SELECT * FROM reminders WHERE date BETWEEN '$sdate' AND '$edate'";
                $result = $conn->query($sql);
                $jsObject = array();
                while($row = $result->fetch_assoc()){
                    array_push($jsObject, $row);
                }
                echo json_encode($jsObject);
            }
            else{
                $sql = "SELECT * FROM reminders";
                $jsObject = array();
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    array_push($jsObject, $row);
                }
                echo json_encode($jsObject);
            }
        ?> ;
        var subjectss = <?php include 'getSubject.php' ?> ;
        var subjectssHTML = '<option value="">Select Option</option>';
        subjectss.forEach(element=>{
            subjectssHTML+='<option value="'+element.name+'">'+element.name+'</option>';
        });
        document.getElementById("subject").innerHTML=subjectssHTML;
        var table = '<table><tr><td>Name</td><td>Subject</td><td>decription</td><td>Email</td><td>Contact No</td><td>SMS No.</td><td>Status</td><td>Recurrence Frequency</td></tr>';
        data.forEach(element => {
            var d = "";
            var recur;
            if(element.day7=="1"){
                d=d+"7,";
            }
            if(element.day5=="5"){
                d=d+"5,";
            }
            if(element.day3=="3"){
                d=d+"3,";
            }
            if(element.day2=="2"){
                d=d+"2,";
            }
            if(d.length>0){
                recur=d.substring(0,d.length-1);
            }
            else{
                recur=0;
            }
            table += `<tr><td>${element.name}</td><td>${element.subject}</td><td>${element.description}</td><td>${element.email}</td><td>${element.contact}</td><td>${element.sms_no}</td><td>${element.active}</td><td>${recur}</td></tr>`;
        });
        document.getElementById("pBody").innerHTML=table;
        function filterData(){
            var subject = document.getElementById("subject").value;
            var table = '<table><tr><td>Name</td><td>Subject</td><td>decription</td><td>Email</td><td>Contact No</td><td>SMS No.</td><td>Status</td><td>Recurrence Frequency</td></tr>';
            data.forEach(element => {
                if(element.subject==subject){
                    var d = "";
                    var recur;
                    if(element.day7=="1"){
                        d=d+"7,";
                    }
                    if(element.day5=="5"){
                        d=d+"5,";
                    }
                    if(element.day3=="3"){
                        d=d+"3,";
                    }
                    if(element.day2=="2"){
                        d=d+"2,";
                    }
                    if(d.length>0){
                        recur=d.substring(0,d.length-1);
                    }
                    else{
                        recur=0;
                    }
                    table += `<tr><td>${element.name}</td><td>${element.subject}</td><td>${element.description}</td><td>${element.email}</td><td>${element.contact}</td><td>${element.sms_no}</td><td>${element.active}</td><td>${recur}</td></tr>`;
                }
            });
            document.getElementById("pBody").innerHTML=table;

        }

    </script>
</body>
</html>