<?php
// Skrypt odpowiedzialny za tworzenie pokoi oraz przechodzenie do poszczególnych pokoi. 
require_once('panel.php');
// Jeżeli zapytanie POST, nowy pokój.
if(isset($_POST['new-room']))
{
    nowyPokoj($_POST['room-name'], $_POST['user-id']);
}
?>
<div class="container">
    <!---Formularz tworzenia nowego pokoju -->
    <div class="row d-flex">
        <div class="col-lg-5 p-2 m-2 bg-dark text-white">
            <p class="text-left">W ciasnym zakamarku karczmy, w odległej części, gdzie korytarze były równie ciemne, co dusze mieszkańców, znajduje się niepozorne dzwi.
Drzwi te są zawsze uchylone, ukryte przed wzrokiem nieostorożnych, a jedyną wskazówką na temat ich istnienia jest ledwo widoczna, wyszlifowana tabliczka z napisem 
"Prywatne Kwatery - Zapytaj o Jenniego".Gdy odważysz się wejść, znajdziesz się w pokoju z drewnianymi belkami, które wydają stłumione skrzypienie pod twoim ciężarem.
Zapach starożytnego drewna i przypalonego kadzidła unosi się w powietrzu. Ściany zdobią obrazy nieznanych krain i zapomnianych czasów, a słaba poświata lampy mieni
się w zamszowym zasłonie na oknie. Od wejścia czujesz na sobie wrogie spojrzenie, lecz początkowo nic nie widzisz. <br>
W półmroku stoi postać, odziana w ciemny płaszcz. Jej oczy, ukryte w cieniach, świecą niczym dwa białe księżyce na niebie. Postać pstryka palcami, a przygotowany pergamin,
równie czysty jak pióro, pojawia się przed Tobą, a tajemniczy nieznajomy uśmiecha się złowrogo.<br><br>
"Pragniesz schronienia?" - szepcze, a jego głos brzmi jak szept wiatru między liśćmi drzew.<br>
"Mam dla ciebie pokój, gdzie cienie tańczą i dźwięki wymykają się pamięci. Wypełnij pergamin, a klucz do przeszłości zostanie ujawniony."<br><br>
Pergamin ten jest niemal magiczny, odbijając twoje najskrytsze myśli i marzenia. Chwytasz pióro, a strzępy twojej przeszłości układają się w słowa.
Gdy zakończysz, podnosisz wzrok, ale postać już zniknęła. Na stole leży klucz do prywatnego pokoju, a jedyny ślad nieznajomego to dźwięk kroków w oddali.
Jego słowa rozbrzmiewają w twoich myślach, gdy zastanawiasz się, czy to miejsce jest błogosławieństwem czy przekleństwem.</p>
<hr>
                <h2>Zakładanie nowego pokoju:</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="room-name">Nazwa pokoju</label>
                        <input type="text" class="form-control" id="room-name" name="room-name" placeholder="Wprowadż nazwę">
                    </div>
                    <div class="form-check">
                        <input type="hidden" class="form-control" id="user-id" name="user-id" value="<?php echo $_SESSION['userId']; ?>">
                    </div>
                    <div class="form-check">
                        <input type="hidden" class="form-control" id="new-room" name="new-room" value="new-room">
                    </div>
                    <button type="submit" class="mt-1 przyciski-strona-glowna">Załóż</button>
                </form>
        </div>
        <div class="col-lg-5 p-2 m-2 bg-dark text-white">
            <h2>Lista pokoi, do których należysz:</h2>
            <?php listaPokoi($_SESSION['userId']); ?>
        </div>
    </div>
 </div>
