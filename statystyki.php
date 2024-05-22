<?php 
include_once("panel.php");
require "vendor/autoload.php";

// ??
$player = unserialize($_SESSION['player']);
if($_GET['id']) {
    odswiezDane($_GET['id']);
}

// Inicjalizacja środowiska Twig
$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);

// Renderowanie szablonu Twig i przekazanie danych do szablonu
echo $twig->render('statystyki.twig', ['player' => $player]);
?>
