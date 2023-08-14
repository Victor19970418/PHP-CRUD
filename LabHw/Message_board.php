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

if (isset($_POST["create-submit"])) {
    $content = $_POST["content"];
    // sql語法存在變數中
    $sql = "INSERT INTO  `messagebox` (`UserId`, `Content`,`Time`) VALUE ('$userid','$content','$now') ";
    // 用mysqli_query方法執行(sql語法)將結果存在變數中
    $result = mysqli_query($conn, $sql);
    
    header("Location:Message_board.php");

    //檔案上傳部分
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
                $sql = "SELECT * FROM `messagebox` ORDER BY MessageId DESC LIMIT 1";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $messageid = $row["MessageId"];
                $filename = $_FILES['my_file']['name'][$i];
                $sql = "INSERT INTO `file`(`MessageId`, `FileName`) VALUES ('$messageid','$filename')";
                mysqli_query($conn, $sql);

                // echo '檔案已存在。<br/>';
            } else {
                $file = $_FILES['my_file']['tmp_name'][$i];
                $dest = 'upload/' . $_FILES['my_file']['name'][$i];

                # 將檔案移至指定位置
                move_uploaded_file($file, $dest);
                //找出最後一筆留言
                $sql = "SELECT * FROM `messagebox` ORDER BY MessageId DESC LIMIT 1";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $messageid = $row["MessageId"];
                $filename = $_FILES['my_file']['name'][$i];
                $sql = "INSERT INTO `file`(`MessageId`, `FileName`) VALUES ('$messageid','$filename')";
                mysqli_query($conn, $sql);
                

            }
        } else {
            echo '錯誤代碼：' . $_FILES['my_file']['error'] . '<br/>';
        }
    }
    mysqli_close($conn);
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <style>
        * {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .color-white {
            color: white;
        }

        #home-logo {
            width: 30px;
            height: 30px;
        }

        #home-logo:hover {
            color: yellow;
        }

        #Mb-tag:hover {
            text-decoration: none;
            color: yellow;
        }

        #Mb-tag:hover>span {
            color: yellow;
        }

        .box-wrap {
            margin: auto;
            width: 50%;
            background-color: pink;
        }

        .messagebox {

            width: 100%;
        }

        .content-box {
            border: 1px solid black;
            width: 100%;
            height: 200px;
        }

        .file-box {
            width: 100%;
            height: 25px;

        }

        .border-1 {
            border: 1px solid black;
        }

        .bg-btn {
            background-color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-dark justify-space-around">
        <div class="nav-wrap">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-home color-white" id="home-logo"></i>
            </a>
            <a href="Message_board.php" id="Mb-tag">
                <span class="color-white">留言板</span>
            </a>
        </div>
        <button class="btn btn-primary" id="btn-create">新增留言</button>
    </nav>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";


    // Create connection
    $conn = new mysqli($servername, $username, $password, "login");
    $sql = "SELECT * FROM messagebox";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="box-wrap mt-3">
        <div class="message-box row m-0 ">
            <div class="col-6  p-0 w-100 border-1">使用者ID:' . $row["UserId"] . '</div>
            <div class="col-6  p-0 w-100 border-1">留言時間:' . $row["Time"] . '</div>
        </div>
        <div class="content-box">
            <span>' . $row["Content"] . '</span>
        </div>
        <div class="file-box border-1">
            <span>附加檔案:</span>';
        $messageid = $row["MessageId"];
        $sql = "SELECT * FROM `file` WHERE MessageId = $messageid";
        $findfilename = mysqli_query($conn, $sql);
        while($file = mysqli_fetch_assoc($findfilename))
        {
            echo '<a href="Download.php?filename=upload/'.$file["FileName"].'">下載</a>';
        } 
        
        echo '
        </div>
        <div class="message-box row m-0" >
            <button class="col-6 border-1 p-0 w-100 bg-btn btn-delete" value=' . $row["MessageId"] . '>刪除</button>
            <button class="col-6 border-1 p-0 w-100 bg-btn btn-edit" value=' . $row["MessageId"] . ' userid=' . $row["UserId"] . '>修改</button>
        </div>
     </div>';
    }
    ?>





    <!-- <div class="box-wrap mt-2">
        <div class="message-box row m-0 ">
            <div class="col-6  p-0 w-100 border-1">使用者ID:</div>
            <div class="col-6  p-0 w-100 border-1">留言時間:</div>
        </div>
        <div class="content-box">

        </div>
        <div class="file-box border-1">
            <span>附加檔案:</span>
        </div>
        <div class="message-box row m-0 ">
            <button class="col-6 border-1 p-0 w-100 bg-btn">刪除</button>
            <button class="col-6 border-1 p-0 w-100 bg-btn">修改</button>
        </div>
    </div> -->







    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script>
        let btn_create = document.getElementById("btn-create");
        btn_create.addEventListener("click", function() {
            location.href = 'http://localhost:8787/lab_hw/Create.php';
        })

        var btn_delete = document.getElementsByClassName("btn-delete");
        for (const item of btn_delete) {
            item.addEventListener("click", function() {
                var messageid = item.getAttribute("value");
                $.post("Delete.php", {
                    MessageId: messageid
                }, function(data) {
                    var test = data;
                   
                    var res = JSON.parse(data);
                    if(res.success == "success")
                    {
                        location.reload();
                    }
                    else{
                        alert("無法刪除資料")
                    }
                });
            });
        }

        var btn_edit = document.getElementsByClassName("btn-edit");
        for (const item of btn_edit) {
            item.addEventListener("click", function() {
                var messageid = item.getAttribute("value");
                var userid = item.getAttribute("userid");
                var url = "Edit.php?MessageId=" + messageid + "&UserId=" + userid
                window.location.assign(url)
            });
        }

        var getUrlString = location.href;
        var url = new URL(getUrlString);
        var LoginSituation = url.searchParams.get('Message');
        if (LoginSituation == "no") {
            alert("無法修改此流言!!")
        }
      
    </script>
</body>

</html>