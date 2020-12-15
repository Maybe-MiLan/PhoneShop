<?php
require_once "db.php";
    if (!empty($_POST['img'])) {
        $photo = $_POST['img'];
        $title = $_POST['Title'];
        $model = $_POST['model'];
        $price = $_POST['price'];
        $ops = $_POST['ops'];

        $query = " INSERT INTO " . Phone . "(`Title`,`Model`,`Price`,`Photo`,`description`)
         VALUES('$title','$model','$price','$photo','$ops')";
        $db->query($query) or die ("такой телефон уже есть");
        header('Location: main.php');

    }





