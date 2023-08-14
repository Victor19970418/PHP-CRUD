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
$now = date('Y/m/d H:i:s');

// Create connection
$conn = new mysqli($servername, $username, $password, "login");


if (isset($_GET["MessageId"])) {
    $_SESSION['messageid'] = $_GET["MessageId"];
}
if ($userid != $_GET["UserId"] && !isset($_POST["edit-submit"])) {
    header("Location:Message_board.php?Message=no");
}
if (isset($_POST["edit-submit"])) {
    $now =  date("Y-m-d H:i:s", mktime(date('H') + 8, date('i'), date('s'), date('m'), date('d'), date('Y')));
    $content = $_POST["content"];
    $message = $_SESSION['messageid'];
    $sql = "UPDATE `messagebox` SET `Content`='$content',`Time`='$now'  WHERE MessageId= $message";
    mysqli_query($conn, $sql);



    

    //檢查上傳幾項檔案
    $fileCount = count($_FILES['my_file']['name']);
    for ($i = 0; $i < $fileCount; $i++) {
        # 檢查檔案是否上傳成功
        if ($_FILES['my_file']['error'][$i] === UPLOAD_ERR_OK) {
            echo '檔案名稱: ' . $_FILES['my_file']['name'][$i] . '<br/>';
            echo '檔案類型: ' . $_FILES['my_file']['type'][$i] . '<br/>';
            echo '檔案大小: ' . ($_FILES['my_file']['size'][$i] / 1024) . ' KB<br/>';
            echo '暫存名稱: ' . $_FILES['my_file']['tmp_name'][$i] . '<br/>';

            # 檢查檔案是否已經存在
            if (file_exists('upload/' . $_FILES['my_file']['name'][$i])) {
                $filename = $_FILES['my_file']['name'][$i];
                $sql = "INSERT INTO `file`(`MessageId`, `FileName`) VALUES ('$message','$filename')";
                mysqli_query($conn, $sql);
                // echo '檔案已存在。<br/>';
            } else {
                $file = $_FILES['my_file']['tmp_name'][$i];
                $dest = 'upload/' . $_FILES['my_file']['name'][$i];

                # 將檔案移至指定位置
                move_uploaded_file($file, $dest);
                $filename = $_FILES['my_file']['name'][$i];
                $sql = "INSERT INTO `file`(`MessageId`, `FileName`) VALUES ('$message','$filename')";
                mysqli_query($conn, $sql);
            }
        } else {
            echo '錯誤代碼：' . $_FILES['my_file']['error'] . '<br/>';
        }
    }




    mysqli_close($conn);
    header("Location:Message_board.php");
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>

<body>
    <div class="login-wrap d-flex align-items-center flex-column mt-5">
        <h2 class="">修改留言</h2>
        <form method="post" action="Edit.php" class="" enctype="multipart/form-data">
            <label for="Message" style="vertical-align:top">留言:</label>
            <?php
            //資料庫連線
            $servername = "localhost";
            $username = "root";
            $password = "";
            $userid = $_SESSION['session_name'];
            $messageid = $_SESSION['messageid'];

            // Create connection
            $conn = new mysqli($servername, $username, $password, "login");
            $sql = "SELECT * FROM `messagebox` WHERE MessageId = $messageid";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);


            echo'
            <textarea type="text"  name="content" id="Message" cols="50" rows="4" style="width:90%;">'.$row["Content"].'</textarea>
            <span class="d-block">已附加檔案:</span>';
    
            
            
            //找出以附加檔案
           
            $findfile = "SELECT * FROM `file` WHERE MessageId = ".$messageid;
            $result = mysqli_query($conn, $findfile);
            
            while($row = mysqli_fetch_assoc($result))
            {
                echo ' <div class="file-wrap">
                            <span>'.$row["FileName"].'</span><input class="del-file" type="button" value ="刪除" FileName="'.$row["FileName"].'" /> 
                        </div>';
            }
            
            ?>
            
            <input type="file" name="my_file[]" multiple class="d-block">

            <button type="submit" name="edit-submit" class="btn btn-primary">修改留言</button>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script>
        var allfile = document.getElementsByClassName("del-file");
        console.warn(allfile)
        for(const item of allfile)
        {
            item.addEventListener("click",function(){
                var filename = item.getAttribute("FileName");
                $.post("Deletefile.php",{FileName:filename},function(res){
                    console.warn(res);
                    location.reload();
                });
            });
        }
    </script>
</body>

</html>