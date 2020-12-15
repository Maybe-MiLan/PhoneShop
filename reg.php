<?php

if (isset($_POST['send'])) {
    if (!isset($_SESSION['id'])) {

        reg($db);
    } else
        echo "вы не можите авторизоваться повторно";
    header('Location: index.php');
}
function reg($db){
    require_once "db.php";
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nickname = $_POST['nickname'];
    $birthday = $_POST['birthday'];
    $ferstname = $_POST['ferstname'];
    $lastname = $_POST['lastname'];

    $status = "";

    if (!empty($email) && !empty($password) && !empty($nickname) && !empty($birthday) && !empty($ferstname) && !empty($lastname)){
        $query = " SELECT * FROM " . TABLE_USER . " WHERE `email` = '{$email}'";
        $result = $db->query($query) or die (" не могу получить данные");

        if ($result->num_rows == 1){
            echo "такой емаил уже есть";
        }else {
            $query = " INSERT INTO " . TABLE_USER . "(`email`,`password`,`nickname`,`ferstname`,`lastname`,`birthday`,`Role`) 
        VALUES('$email','$password','$nickname','$ferstname','$lastname','$birthday','2')";
            $db->query($query) or die ("нмагу внести данные");
            $status = true;
        }
    }else
        echo "не все данные заполнены";
    echo "вы успешно авторизовались";
    header("Refresh 1; index.php");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация в интернет магазине Milan & Phone</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="row">

        <div class="col-md-offset-3 col-md-6">
            <form class="form-horizontal" method="post">
                <span class="heading">Регистрация</span>


                <div class="form-group help">
                    <input type="text" name="ferstname" class="form-control" id="inputPassword" placeholder="Имя">
                    <i class="fa fa-lock"></i>
                    <a href="#" class="fa fa-question-circle"></a>
                </div>
                <div class="form-group help">
                    <input type="text" name="lastname" class="form-control" id="inputPassword" placeholder="Фамилия">
                    <i class="fa fa-lock"></i>
                    <a href="#" class="fa fa-question-circle"></a>
                </div>
                <div class="form-group help">
                    <input type="text" name="nickname" class="form-control" id="inputPassword" placeholder="Логин">
                    <i class="fa fa-lock"></i>
                    <a href="#" class="fa fa-question-circle"></a>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="E-mail">
                    <i class="fa fa-user"></i>
                </div>
                <div class="form-group help">
                    <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Пароль">
                    <i class="fa fa-lock"></i>
                    <a href="#" class="fa fa-question-circle"></a>
                </div>
                <div class="form-group help">
                    <input type="password" name="rpassword" class="form-control" id="inputPassword" placeholder="Повторите Пароль">
                    <i class="fa fa-lock"></i>
                    <a href="#" class="fa fa-question-circle"></a>
                </div>
                <div class="form-group help">
                    <input type="date" name="birthday" class="form-control">
                    <i class="fa fa-lock"></i>
                    <a href="#" class="fa fa-question-circle"></a>
                </div>
                <div class="form-group">
                    <div class="main-checkbox">
                        <input type="checkbox" value="none" id="checkbox1" name="check"/>
                        <label for="checkbox1"></label>
                    </div>
                    <span class="text">Я согласен с данными условиями </span>
                    <button type="submit" name="send" class="btn btn-default">Зарегистрироваться</button>
                </div>


            </form>
        </div>

    </div>
</div>
</body>
</html>
