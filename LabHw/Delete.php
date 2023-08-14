<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$userid = $_SESSION['session_name'];



// Create connection
$conn = new mysqli($servername, $username, $password, "login");
$messageid = $_POST["MessageId"];

$sqluserid = "SELECT * FROM `messagebox` WHERE MessageId = $messageid";
$result =  mysqli_query($conn,$sqluserid);
$row = mysqli_fetch_assoc($result);
if($row["UserId"] != $userid)
{
    echo '{"success": "false"}';
}
else
{
$sql = "SELECT * FROM `file` WHERE MessageId =" .$messageid;
$result = mysqli_query($conn,$sql); 
while($row = mysqli_fetch_assoc($result))
{
    unlink('upload/'.$row["FileName"]);
}


$sql ="DELETE FROM `messagebox` WHERE MessageId=".$messageid;  //刪除資料
mysqli_query($conn,$sql);
$sql ="DELETE FROM `file` WHERE MessageId =".$messageid;  //刪除資料
mysqli_query($conn,$sql);
mysqli_close($conn);


echo '{"success": "success"}';
}
?>