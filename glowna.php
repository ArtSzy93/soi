<?php 
include_once("panel.php");

require "vendor/autoload.php";
$player = unserialize($_SESSION['player']);
// Inicjalizacja środowiska Twig
$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);

// Renderowanie szablonu Twig i przekazanie danych do szablonu
echo $twig->render('glowna.twig', [
    'player'          => $player,
    'name'            => $labels["NAME"],
    'hp'              => $labels["HP"],
    'energy'          => $labels["ENERGY"],
    'city'            => $labels["CITY"],
    'adventure'       => $labels["ADVENTURE"],
    'adventure_desc'  => $labels["ADVENTURE_DESC"],
    'inn'             => $labels["INN"],
    'inn_desc'        => $labels["INN_DESC"],
    'healer'          => $labels["HEALER"],
    'healer_desc'     => $labels["HEALER_DESC"],
    'img_src'         => $labels["IMG_SRC"],
    'start'           => $labels["START"],
    'arena'           => $labels["ARENA"],
    'arena_desc'      => $labels["ARENA_DESC"],
    'shop'            => $labels["SHOP"],
    'shop_desc'       => $labels["SHOP_DESC"],
    'work'            => $labels["WORK_DISTRICT"],
    'work_desc'       => $labels["WORK_DISTRICT_DESC"],
    'town_hall'       => $labels["TOWN_HALL"],
    'town_hall_desc'  => $labels["TOWN_HALL_DESC"],
    'character'       => $labels["CHARACTER"],
    'char_stat'       => $labels["CHAR_STAT"],
    'char_stat_desc'  => $labels["CHAR_STAT_DESC"],
    "equipment"       => $labels["EQUIPMENT"],
    "equipment_desc"  => $labels["EQUIPMENT_DESC"],
    "other_func"      => $labels["OTHER_FUNC"],
    "priv_mess"       => $labels["PRIV_MESS"],
    "priv_mess_desc"  => $labels["PRIV_MESS_DESC"],
    "main_chat"       => $labels["MAIN_CHAT"],
    "main_chat_desc"  => $labels["MAIN_CHAT_DESC"],
    "changelog"       => $labels["CHANGELOG"],
    "changelog_desc"  => $labels["CHANGELOG_DESC"],
    "setting"         => $labels["SETTING"],
    "setting_desc"    => $labels["SETTING_DESC"],
]);
?>



