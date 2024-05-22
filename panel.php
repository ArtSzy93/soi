<?php 
include("config/sesja.php");
include("config/config.php");
include("config/lang.php");
include("include/funkcje.php");
odswiezDane($_SESSION['userId']);

$player = unserialize($_SESSION['player']);
// Inicjalizacja środowiska Twig
$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);

// Renderowanie szablonu Twig i przekazanie danych do szablonu
echo $twig->render('panel.twig', [
  'player' => $player, 
  'app_name' => $APP_NAME,
  'lang' => $LANG,
  'dashboard' => $labels["DASHBOARD"],
  'setting' => $labels["SETTING"],
  'logout' => $labels["LOGOUT"],
  'adm_panel' => $labels["ADM_PANEL"],
  'gold' => $labels["GOLD"],
  'time' => $labels["TIME"]
]);
?>
