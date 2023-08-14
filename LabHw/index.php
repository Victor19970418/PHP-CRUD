<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    
</head>

<body>
    <div class="login-wrap d-flex align-items-center flex-column mt-5">
        <h2 class="">使用者登入</h2>
        <form method="post" action="login.php" class="">
            帳號：
            <input type="text" name="username"><br /><br />
            密碼：
            <input type="password" name="password">
            <input type="submit" name="submit" value="登入">
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>
    <script>
        var getUrlString = location.href;
        var url = new URL(getUrlString);
        var LoginSituation= url.searchParams.get('login'); 
        if(LoginSituation=="noinput")
        {
            alert("請輸入帳號或密碼!!")
        }
        else if(LoginSituation=="noAccount")
        {
            alert("沒有這個帳號!!")
        }
        else if(LoginSituation=="wrongpassword")
        {
            alert("密碼錯誤!!")
        }
        else if(LoginSituation=="timeout")
        {
            alert("登入時間到!!")
        }

    </script>
</body>

</html>