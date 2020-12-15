<?php
require_once "db.php";
$query = "CREATE TABLE IF NOT EXISTS " . TABLE_USER . "(
`id` int(11) PRIMARY KEY AUTO_INCREMENT,
`email` varchar(64),
`password` varchar(64),
`nickname` varchar(64),
`birthday` date,
`ferstname` varchar(64),
`lastname` varchar(64),
`Role` int(1)
)";
$db->query($query) or die ("немагу СОЗДАТЬ ТАБЛИЦУ USERS");
if (isset($_GET['logout'])){
    header('Location: index.php');
    logout();

}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $query = " SELECT * FROM " . TABLE_USER . " WHERE `email` = '$email' AND `password` = '$password'";
        $result = $db->query($query) or die ("немагу получить данные");
        if ($result->num_rows == 1) {
            echo "вы успешно авторизовались";
            $row = $result->fetch_array();
            $_SESSION['id'] = $row['id'];
            $_SESSION['nickname'] = $row['nickname'];
            $_SESSION['Role'] = $row['Role'];
            header('Location: index.php');
        } else
            echo "пользователь не найден";
    } else
        echo "не все поля заполены";
}





?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Интернет магазин телефонов</title>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark ml-5 mr-5">
        <a class="navbar-brand" href="#">
            <img class="img-responsive img-res" id="go-top" name="go-top" src="https://jobinja.ir/files/uploads/images/98b15ee8-1083-11e8-bce7-06a874001fea_01c410c1-7a3a-4755-ae26-87e64feafe9a/companies_logo_128x128.png" alt="" style="width:40px;">
        </a>
        <div class="col-md-4 col-sm-8 col-xs-12">
            <h3>Milan & Phone</h3>
        </div>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="?main">Все телефоны</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?messages">Поддержанные телефоны</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    Каталог
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="?Nokia">Nokia</a>
                    <a class="dropdown-item" href="?Samsung">Samsung</a>
                    <a class="dropdown-item" href="?Sony">Sony</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?Contactus">Контакты</a>
            </li>
            <?php
            if (isset($_SESSION['id'])){
                echo "
                <li class=\"nav-item\">
               <a href='?edit' class='nav-link'>Вы вошли как {$_SESSION['nickname']} </a> <a href='?logout' class='nav-link'> Выйти</a>
            </li>
                ";
            }else
                echo "
                <li class=\"nav-item\">
                <a class=\"nav-link\" href=\"#\" data-toggle=\"modal\" data-target=\"#exampleModal\">Вход/Авторизация</a>
            </li>
                ";
            ?>

        </ul>
    </nav>
    <div style="display: block; bottom: 0px; right: 10px; position: fixed; cursor: pointer; z-index: 99;">
        <a href="#go-top">
        <img src="https://phone855.com/assets/adminsite/images/icon/top.png"  alt="top">
        </a>
    </div>
</head>
<body>

<?php
if (isset($_GET['edit'])){
    edit();
}
elseif (!isset($_GET['Contactus']))
{
    if (isset($_GET['messages']))
    {
        byphone();
    }
    else
    main_content();
    if (isset($_SESSION['id'])){
        if ($_SESSION['Role'] == 1){
        admin();
        }

    }
?>
<div class="row row-cols-1 row-cols-md-6 p-5 m-5">
    <?php
    if (isset($_GET['Nokia'])) {
        filtorNokia();
    }
    elseif(isset($_GET['Sony'])) {
        filtorSony();
    }
    elseif (isset($_GET['Samsung'])){
        filtorSamsung();

    }else{
        if (!isset($_GET['messages']))
        {
            catalog();

        }
}
    ?>
</div>
    <?php
}else
    echo " <div class='m-5 p-5'>
 <h1>Контакты</h1>
    <div>
    <h3>Наши телефоны:</h3><br>
    8 800 555 35 35
</div>
<div>
    <h3>Наши салоны на карте</h3><br>
    
</div>
<div style=\"overflow:hidden;width: 700px;position: relative;\"><iframe width=\"700\" height=\"440\" src=\"https://maps.google.com/maps?width=700&amp;height=440&amp;hl=en&amp;q=Moscow%2C%20Russia+(%D0%9D%D0%B0%D0%B7%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5)&amp;ie=UTF8&amp;t=&amp;z=10&amp;iwloc=B&amp;output=embed\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\"></iframe><div style=\"position: absolute;width: 80%;bottom: 10px;left: 0;right: 0;margin-left: auto;margin-right: auto;color: #000;text-align: center;\"><small style=\"line-height: 1.8;font-size: 2px;background: #fff;\">Powered by <a href=\"https://embedgooglemaps.com/de/\">embedgooglemaps DE</a> & <a href=\"https://iamsterdamcard.it\">iamsterdam card.it</a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><br />
 </div>
 <div class='btn-dark'>
  <h3 align='center'>Форма обратной связи</h3>
 <form class='p-5'>
  <div class=\"form - group\">
    <label for=\"exampleFormControlInput1\">Имя</label>
    <input type=\"text\" class=\"form - control\" id=\"exampleFormControlInput1\">
  </div>
  <div class=\"form - group\">
    <label for=\"exampleFormControlInput2\">Email</label>
    <input type=\"email\" class=\"form - control\" id=\"exampleFormControlInput2\">
  </div>
  <div class=\"form - group\">
    <label for=\"exampleFormControlInput3\">Телефон</label>
    <input type=\"text\" class=\"form - control\" id=\"exampleFormControlInput3\">
  </div>
  <div class=\"form-group\">
    <label for=\"exampleFormControlTextarea1\">Введите текст вашего сообщения</label>
    <textarea class=\"form-control\" id=\"exampleFormControlTextarea1\" rows=\"3\"></textarea>
  </div>
  <input type='submit' name='callback'>
</form>
</div>
    ";



function admin(){
    echo $content = "
    <h3>Добавить товар</h3>
    <div class=\"col-md-offset-3 col-md-6\">
     <form method='post' action='up.php'>
  <div class=\"form-group\">
    <label for=\"formGroupExampleInput\">Марка Телефона</label>
    <input type=\"text\" name='Title' class=\"form-control-sm\" id=\"formGroupExampleInput\" placeholder=\"Example input\">
  </div>
  <div class=\"form-group\">
    <label for=\"formGroupExampleInput2\">Модель</label>
    <input type=\"text\" name='model' class=\"form-control-sm\" id=\"formGroupExampleInput2\" placeholder=\"Another input\">
  </div>
  <div class=\"form - group\">
    <label for=\"formGroupExampleInput2\">Описаине к телефону</label>
    <input type=\"text\" name='ops' class=\"form - control - sm\" id=\"formGroupExampleInput2\" placeholder=\"Another input\">
  </div>
  <div class=\"form - group\">
    <label for=\"formGroupExampleInput2\">Цена</label>
    <input type=\"text\" name='price' class=\"form - control - sm\" id=\"formGroupExampleInput2\" placeholder=\"Another input\">
  </div>
  <div class=\"form-group\">
        <label for=\"exampleFormControlFile1\">Фото</label>
        <input type=\"file\" name=\"img\" class=\"form-control-file\" id=\"exampleFormControlFile1\">
    </div>
  <input type='submit' name='up' value='добавить' class='btn btn-small'>
</form>
</div>
   ";
}
?>

<!--  -->
<?php
function main_content(){
    echo $content = "
    <div class=\"container text-center\">
    <h1 class=\"h3 mt-5 mb-1\">Главный каталог</h1>
    <h2 class=\"lead mt-0 mb-5\">предварительный просмотр товаров</h2>

</div>
    <div class=\"container\" style='width: 800px; height: auto'>
<div id=\"carouselExampleIndicators\" class=\"carousel slide\" data-ride=\"carousel\">
    <ol class=\"carousel-indicators\">
        <li data-target=\"#carouselExampleIndicators\" data-slide-to=\"0\" class=\"active\"></li>
        <li data-target=\"#carouselExampleIndicators\" data-slide-to=\"1\"></li>
        <li data-target=\"#carouselExampleIndicators\" data-slide-to=\"2\"></li>
    </ol>
    <div class=\"carousel-inner\">
        <div class=\"carousel-item active\">
            <img class=\"d-block w-100\" src=\"https://www.barahla.net/images/photo/1/20120929/5573344/big/134889052077846200_big.jpg\"\" alt=\"Первый слайд\">
        </div>
        <div class=\"carousel-item\">
            <img class=\"d-block w-100\" src=\"https://i.gadgets360cdn.com/large/samsung_galaxy_j1_4g_black_1483713024989.jpg?output-quality=80&amp;output-format=jpg\" alt=\"Второй слайд\">
        </div>
        <div class=\"carousel-item\">
            <img class=\"d-block w-100\" src=\"https://teloji.com/wp-content/uploads/2017/02/xa1-ultra.jpeg\" alt=\"Третий слайд\">
        </div>
    </div>
    <a class=\"carousel-control-prev\" href=\"#carouselExampleIndicators\" role=\"button\" data-slide=\"prev\">
        <span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>
        <span class=\"sr-only\">Previous</span>
    </a>
    <a class=\"carousel-control-next\" href=\"#carouselExampleIndicators\" role=\"button\" data-slide=\"next\">
        <span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>
        <span class=\"sr-only\">Next</span>
    </a>
</div>
        <hr>
</div>
    ";
}
$query="CREATE TABLE IF NOT EXISTS " . Phone . "(
`id` int(11) PRIMARY KEY AUTO_INCREMENT,
`Photo` varchar(64),
`Title` varchar(64),
`Model` varchar(64),
`description` varchar(64),
`Price` decimal(10,2)
)";
$db->query($query) or die ("не могу СОЗДАТЬ ТАБЛИЦУ Рhone");

function catalog(){

    $db = new mysqli(HOST, USER,PASS,BASE);

    $query = " SELECT * FROM " . Phone;
    $result = $db->query($query) or die ("не могу получить данные о телефонах");
    while ($row = $result->fetch_assoc()){
        echo $content = " 
        <div class=\"card\" style=\"width: 18rem;\">
  <img src=\"img/{$row['Photo']}\" class=\"card-img-top\" width='auto' height='200px' alt=\"...\">
  <div class=\"card-body\">
    <h5 class=\"card-title\">{$row['Title']}-{$row['Model']}</h5>
    <p class=\"card-text\">{$row['description']}</p>
        <p class=\"card-text\">{$row['Price']}</p>
<form name='form4' method='post'action='order.php'>
    <a href='order.php' class='btn btn-primary'>Купить</a>
     
   </form>
  </div>
</div>
        ";
    }

}
function filtorSamsung(){

    $db = new mysqli(HOST, USER,PASS,BASE);
    $query = "SELECT * FROM " . Phone . " where `Title` = 'Samsung'";
    $result = $db->query($query) or die ("немагу получить данные");

    while ($row = $result->fetch_assoc()){
        echo $content = " 
        <div class=\"card\" style=\"width: 18rem;\">
  <img src=\"img/{$row['Photo']}\" class=\"card-img-top\" width='auto' height='200px' alt=\"...\">
  <div class=\"card-body\">
    <h5 class=\"card-title\">{$row['Title']}-{$row['Model']}</h5>
    <p class=\"card-text\">{$row['description']}</p>
        <p class=\"card-text\">{$row['Price']}</p>
<form name='form4' method='post'action=''>
    <input type='submit' name='by' class=\"btn btn-primary\" value='Купить'>
     
   </form>
  </div>
</div>
        ";
    }

}
function filtorSony(){

    $db = new mysqli(HOST, USER,PASS,BASE);
    $query = "SELECT * FROM " . Phone . " where `Title` = 'Sony'";
    $result = $db->query($query) or die ("немагу получить данные");

    while ($row = $result->fetch_assoc()){
        echo $content = " 
        <div class=\"card\" style=\"width: 18rem;\">
  <img src=\"img/{$row['Photo']}\" class=\"card-img-top\" width='auto' height='200px' alt=\"...\">
  <div class=\"card-body\">
    <h5 class=\"card-title\">{$row['Title']}-{$row['Model']}</h5>
    <p class=\"card-text\">{$row['description']}</p>
        <p class=\"card-text\">{$row['Price']}</p>
<form name='form4' method='post'action=''>
    <input type='submit' name='by' class=\"btn btn-primary\" value='Купить'>
     
   </form>
  </div>
</div>
        ";
    }

}
function filtorNokia(){

    $db = new mysqli(HOST, USER,PASS,BASE);
        $query = "SELECT * FROM " . Phone . " where `Title` = 'Nokia'";
        $result = $db->query($query) or die ("немагу получить данные");

    while ($row = $result->fetch_assoc()){
        echo $content = " 
        <div class=\"card\" style=\"width: 18rem;\">
  <img src=\"img/{$row['Photo']}\" class=\"card-img-top\" width='auto' height='200px' alt=\"...\">
  <div class=\"card-body\">
    <h5 class=\"card-title\">{$row['Title']}-{$row['Model']}</h5>
    <p class=\"card-text\">{$row['description']}</p>
        <p class=\"card-text\">{$row['Price']}</p>
<form name='form4' method='post'action=''>
    <input type='submit' name='by' class=\"btn btn-primary\" value='Купить'>
     
   </form>
  </div>
</div>
        ";
    }

}
function byphone(){
    echo "Тут будут телефоны которые принесли владельцы по причине поломки и были отремонтированы";
}

?>
<!-- modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Быстрая авторизация</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" class="form-control" id="staticEmail" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Пароль</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
                        </div>
                    </div>


            <div class="modal-footer">
                <input type="submit" name="login" class="btn btn-primary" value="Войти">
                <a href="reg.php" name="reg" class="btn btn-primary">Перейти к регистрации</a>
                <a href="">Забыли пароль?</a>                <a href="">Забыли логин?</a>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>
<?php

function logout(){
    session_destroy();
    header('Location: index.php');
}

function edit(){
    $db = new mysqli(HOST, USER,PASS,BASE)
    or die ("не удалось подключиться к базе данных");
    if (isset($_POST['edit'])){
        $nemail = $_POST['email'];
        $npassword = $_POST['password'];
        $nlogin = $_POST['login'];
        $nphone = $_POST['phone'];
        $nfirstname = $_POST['ferstname'];
        $nlastname = $_POST['lastname'];

        $query = "SELECT * FROM " . TABLE_USER . " WHERE `id`= {$_SESSION['id']}";
        $result = $db->query($query) or die('не нашел такого пользователя');
        $row = $result->fetch_assoc();
        var_dump($_SESSION['id']);
    }
echo "
<div class=\"container\">

 <div class=\"row\">

 <div class=\"col-lg-8 col-lg-offset-2\">
 <h3>Здесь Вы можете изменить Вашу контактную информацию.</h3>
    <form id=\"contact-form\" method=\"post\" action=\"\" role=\"form\">

 <div class=\"messages\"></div>

 <div class=\"controls\">

 <div class=\"row\">
 <div class=\"col-md-6\">
 <div class=\"form-group\">
 <label for=\"form_name\">Имя *</label>
 <input id=\"form_name\" type=\"text\"  name=\"name\" class=\"form-control\"  required=\"required\" data-error=\"Firstname is required.\">
 <div class=\"help-block with-errors\"></div>
 </div>
 </div>
 <div class=\"col-md-6\">
 <div class=\"form-group\">
 <label for=\"form_lastname\">Фамилия *</label>
 <input id=\"form_lastname\" type=\"text\"  name=\"surname\" class=\"form-control\"  required=\"required\" data-error=\"Lastname is required.\">
 <div class=\"help-block with-errors\"></div>
 </div>
 </div>
 </div>

 <div class=\"row\">

 <div class=\"col-md-6\">
 <div class=\"form-group\">
 <label for=\"form_email\">Email *</label>
 <input id=\"form_email\" type=\"email\"  name=\"email\" class=\"form-control\"  required=\"required\" data-error=\"Valid email is required.\">
 <div class=\"help-block with-errors\"></div>
 </div>
 </div>

 <div class=\"col-md-6\">
 <div class=\"form-group\">
 <label for=\"form_phone\">Телефон</label>
 <input id=\"form_phone\" type=\"tel\" name=\"phone\" class=\"form-control\" >
 <div class=\"help-block with-errors\"></div>
 </div>
 </div>
 </div>
 
 <div class=\"row\">
 
 <div class=\"col-md-6\">
 <div class=\"form-group\">
 <label for=\"form_phone\">Адрес для отправки</label>
 <input id=\"form_phone\" type=\"text\" name=\"address\" class=\"form-control\" >
 <div class=\"help-block with-errors\"></div>
 </div>
 </div>
 
 <div class=\"col - md - 6\">
 <div class=\"form - group\">
 <label for=\"form_email\">Пароль</label>
 <input id=\"form_email\" type=\"text\" name=\"email\" class=\"form-control\"  required=\"required\" data-error=\"Valid email is required . \">
 <div class=\"help - block with - errors\"></div>
 </div>
 </div>
 </div>
 
 <div class=\"row\">
 
 <div class=\"col - md - 6\">
 <div class=\"form - group\">
 <label for=\"form_phone\">Логин</label>
 <input id=\"form_phone\" type=\"text\" name=\"address\" class=\"form-control\" >
 <div class=\"help - block with - errors\"></div>
 </div>
 </div>
 
 <div class=\"col-md-6\">
 <div class=\"form-group\">
 <label for=\"form_phone\">Cпособ оплаты</label>
 <select class=\"form-control form-control-sm\">
  <option>Наличными на месте</option>
    <option>Оплата через онлайн кассу</option>
  <option>Оплата Электронным кошельком </option>
</select>
 <div class=\"help-block with-errors\"></div>
 </div>
 </div>
 </div>
  
 <div class=\"col-md-12\">
 <input type=\"submit\" name='edit' class=\"btn btn-success btn-send\" value=\"Сохранить изменения\">
 </div>

 </div>

 </div>

 </form>
 </div>
 </div>
 </div>
";
}
