<?php
    if(isset($_POST['login_btn'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        include 'auth/conn.php' ;
        $_POST=array();
        $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            session_start();
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $username;
            $_SESSION['userId']=$row['id'];
            $_SESSION['name']=$row['name'];
            header("Location: home.php");
        }
        else{
            echo "Invalid username or password";
        }
        $conn->close();
    }

?>