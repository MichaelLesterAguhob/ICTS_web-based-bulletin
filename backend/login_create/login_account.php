<?php 
include_once('connection.php');
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$response = "";

try 
{
    $result1 = mysqli_query($con, "SELECT username FROM user_account WHERE `username`='$username' AND `password`='$password'");

    if(mysqli_num_rows($result1) > 0)
    {
        $_SESSION['username'] = $username;
        $_SESSION['user_type'] = 'user';
        $response = json_encode(['status'=>'success', 'location'=>"Home Page.php"]);

        $date = date("Y/m/d");
        $timeZone = date_default_timezone_set("Asia/Manila");
        $time = date("h:i:sa");
        $dt = $date ." - ".$time;

        $insert_logs = mysqli_query($con, "INSERT INTO logs VALUES('','$username','$dt','')");
    }
    else    
    {
        $result2 = mysqli_query($con, "SELECT username FROM admin_account WHERE `username`='$username' AND `password`='$password'");

        if(mysqli_num_rows($result2) > 0)
        {
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = 'admin';

            $response = json_encode(['status'=>'success', 'location'=>"admin_page.php"]);
        }
        else
        {
            $response = json_encode(['status'=>'failed', 'msg'=>"Account not found!"]);
        }
    }

}
catch(Exception $ex)
{
    $response = "Error Occurred" . $ex;
}
echo $response;
?>