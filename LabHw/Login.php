<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password,"login");

// Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";
//

//$_SESSION['login_ok'] = 1;//宣告session
$uid = mysqli_real_escape_string($conn, $_POST['username']);//把特殊符號轉乘sql看得懂
$pwd = mysqli_real_escape_string($conn, $_POST['password']);

$sql = "SELECT * FROM login WHERE Account ='$uid'";
$result = mysqli_query($conn, $sql);//查詢資料
$resultCheck = mysqli_num_rows($result);//判斷查出來資料有幾筆符合指令
$cookieexpiry = (time() + 60);//設定session時間
//判斷使用者有沒有輸入
if($_POST["username"]==""||$_POST["password"]=="")
{
    header("Location:index.php?login=noinput");
    exit();
}
//判斷有沒有這個帳號
elseif($row = mysqli_fetch_assoc($result))
{
    
    if($pwd!=$row['Password'])
    {
        header("Location:index.php?login=wrongpassword");
    }
    else
    {
        // $lifetime = 60;
        // session_set_cookie_params($lifetime);
        session_start();//宣告開始使用session
        $_SESSION['session_name'] = $row['UserId'];
        $test = $_SESSION['session_name'];
        header("Location:success.php?");
    }
}
else
{
    header("Location:index.php?login=noAccount");
}
