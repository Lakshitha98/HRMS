<?php require_once("include/connection.php"); ?>
<?php session_start(); 
    $_SESSION['user_name'] = "";
    $_SESSION['password'] = "";
    #$s=password_hash("lakshitha", PASSWORD_DEFAULT);
    ?>
<?php
    if(isset($_POST['submit'])){
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        $q= "select password,emp_id from user where user_name = '$user_name';";
        $result=mysqli_query($connection,$q);
        $r=mysqli_fetch_assoc($result);
        if(!is_null($r)){
            $valid_password=$r['password'];
            $query_user = "SELECT job_id FROM employment INNER JOIN user ON employment.emp_id=user.emp_id WHERE binary user.user_name='$user_name' AND user.password='$valid_password' AND acc_status='active'";
            $result_set = mysqli_query($connection,$query_user);
            $record = mysqli_fetch_assoc($result_set);
            if(!password_verify($password, $valid_password) or is_null($record) ){
                $inval_or_not="Invalid username or password";
            }
            else{
                $_SESSION['user_name']=$user_name;
                $_SESSION['password']=$password;
                switch($record['job_id']){
                    case 0:
                        header("Location: include/interfaces/admin.php");
                        break;
                    case 1:
                        header("Location: include/interfaces/hr_manager.php");
                        break;
                    default;
                        header("Location: include/interfaces/employee.php");
                        break;
                }
            }
        }
        else{
            $inval_or_not="Invalid Username or Password";
        }
        
        //$quert_test = "SELECT * FROM employee WHERE emp_id=1";


    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index_style.css">
    <title>Jupyter Company</title>
</head>
<body>
    <div class="loginbox">
        <img src="img/avatar.png" class="avatar" >
        <h1>Login Here</h1>
        <form action="index.php" method="post">
            <p>User Name</p>
            <div><input type="text" placeholder="Enter User Name" name="user_name" id=""></div>
            <p>Password</p>
            <div><input type="password" placeholder="Enter Password" name="password" id=""></div>
            <div class="inval"><?php
            if(isset($_POST['submit'])){
                echo $inval_or_not;
            }
            else{
                echo " .    ";
            }
        ?>  </div>
            
            <div><input type="submit" value="Log In" name="submit"></div>
        </form>        
        <div><a href="include/forgot_password_part_1.php">Forgot Password ?</a></div>
        <div><a href="include/signup.php">Don't have an account ?</a></div>
        
    </div>
</body>
</html>
