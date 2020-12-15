<?php
const HOST = "localhost";
const USER = "root";
const PASS = "";
const BASE = "myshop";
const TABLE_USER = "users";
const Phone = "phones";
$db = new mysqli(HOST, USER,PASS,BASE)
    or die ("не удалось подключиться к базе данных");
session_start();
