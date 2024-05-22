<?php
session_start();
include("config/lang.php");
include('include/funkcje.php');
require "vendor/autoload.php";

// Inicjalizacja środowiska Twig
$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);
$error = '';
$info  = '';

if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === TRUE) {
    header("Location: glowna.php"); 
    exit();
}
if (isset($_SESSION['blad'])) {
    $error =  $_SESSION['blad'];
    unset($_SESSION['blad']);
}
if(isset($_SESSION['info']))
{
    $info = $_SESSION['info'];
    unset($_SESSION['info']);
}

// Display changelog in start page
$changelog = new \Twig\TwigFunction('changelog', function () {
    wyswietlChangelog();
});
$twig->addFunction($changelog);

// Renderowanie szablonu Twig i przekazanie danych do szablonu
echo $twig->render('index.twig', [
    'lang'      => $LANG,
    'app_name'  => $APP_NAME,
    'error'     => $error,
    'info'      => $info,
    'login'     =>  $labels["LOGIN"],
    'login_btn' =>  $labels["LOGIN_BTN"],
    'email'     => $labels['EMAIL'],
    're_email'  => $labels['RE_EMAIL'],
    'pass'      => $labels['PASS'],
    're_pass'   => $labels['RE_PASS'],
    'register'  => $labels['REGISTER'],
    'register_btn' => $labels['REGISTER_BTN'],
    'name'      => $labels['NAME'],
    'start_1'   => $labels['START_INFO_1'],
    'start_2'   => $labels['START_INFO_2']
]);



