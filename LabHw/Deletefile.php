<?php

session_start();


if (isset($_SESSION['session_name']) == false) {
    header("Location:start.php?login=timeout");
}
//資料庫連線
$servername = "localhost";
$username = "root";
$password = "";
$userid = $_SESSION['session_name'];
$messageid  = $_SESSION['messageid'];
$conn = new mysqli($servername, $username, $password, "login");
$filename = $_POST["FileName"];
// 先確認有沒有一樣的檔案
$countfilesql = "SELECT  * FROM `file` WHERE FileName ='$filename'";
$countfile = mysqli_num_rows(mysqli_query($conn, $countfilesql));
//表示有兩筆資料用到這個檔案
if($countfile > 1)
{
    //刪除資料庫資料
    $delfilesql  =  "DELETE FROM `file` WHERE FileName = '$filename' AND MessageId = $messageid";
    mysqli_query($conn, $delfilesql);
}
//只有一筆還要刪除本地端存放庫
else
{
    //刪除資料夾裡的資料
    unlink('upload/'.$filename);
    //刪除資料庫裡的資料
    $delfilesql  =  "DELETE FROM `file` WHERE FileName = '$filename' AND MessageId = $messageid";
    mysqli_query($conn, $delfilesql);
}


mysqli_close($conn);






?>