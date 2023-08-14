<?php
session_start();
$test = $_SESSION['session_name'];

if (isset($_SESSION['session_name']) == false) {
    header("Location:start.php?login=timeout");
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
    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-dark justify-content-start">
        <a class="navbar-brand" href="start.php">
            <i class="fas fa-home color-white" id="home-logo"></i>
        </a>
        <a href="Message_board.php" id="Mb-tag">
            <span class="color-white">留言板</span>
        </a>
    </nav>

    <div class="login-wrap d-flex align-items-center flex-column mt-5">
        <h2 class="">新增留言</h2>
        <form method="post" action="Message_board.php" class="" enctype="multipart/form-data">
            <label for="Message" style="vertical-align:top">留言:</label>
            <textarea type="text" name="content" id="Message" cols="50" rows="4" style="width:90%;"></textarea>
            <input type="file" name="my_file[]" multiple class="d-block">
            <button type="submit" name="create-submit" class="btn btn-primary">新增留言</button>
        </form>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

</html>