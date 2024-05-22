<?php 
include_once("panel.php");
require "vendor/autoload.php";
$info  = '';
if(isset($_SESSION['komunikat']))
{
    $info  = '<p>'.$_SESSION['komunikat'] .'</p>';
    unset($_SESSION['komunikat']);
}


$player = unserialize($_SESSION['player']);
// Inicjalizacja środowiska Twig
$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);

echo $twig->render('przygoda.twig', [
   'adventure_desc_2'    => $labels["ADVENTURE_DESC_2"],
   'info'                => $info

 ]);
?>