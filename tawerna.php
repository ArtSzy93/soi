<?php 
include_once("panel.php");
/*
Tawerna publiczna
*/
?>
<div class="row d-flex justify-content-center">
    <div class="col-md-5 m-2">
        <img class="card-img-top" src="images/karczma.jpg" alt="Karczma">
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-md-6 d-flex justify-content-cente ">
        <div id="tawerna-glowny">
            <div id="tawerna-chat-box">   
            </div>
        </div>
    </div>
</div>   
<div class="row d-flex justify-content-center">
    <div class="col-md-7 ">
        <div class="wiadomosc">
        <input style="width: 100%;" type="text" id="message-input" placeholder="Wpisz wiadomość">
            <button style="width: 100%; margin-top: 10px;" onclick="sendMessage('<?php echo $_SESSION['userName']; ?>(<?php echo $_SESSION['userId']; ?>)')">Wyślij</button>
        </div>
    </div>
</div>
<div class="row d-flex justify-content-center">
        <div class="col-md-5 p-2 m-2 bg-dark text-white text-left">   
        <p>Karczma to miejsce pełne tajemniczej atmosfery i niesamowitych wydarzeń. 
        Wypełniona gęstym dymem od płonących świec i kominków, ta karczma jest schronieniem dla podróżników, awanturników i stworzeń z innych światów.</p>
        <p>Ściany karczmy wykonane są z grubych, spękanych belek drewna, a posadzka pokryta jest warstwą siana i gliny. 
        Mroczne, wytarte meble otaczają długie stoły, a na ścianach wiszą skóry bestii, stare sztandary i broń, której nie można znaleźć nigdzie indziej.
        W jednym z kątów pali się ogień w wielkim kominku, który rzuciłby strach w serce każdego człowieka, gdyby nie towarzyszyła mu przyjemna ciepłość.</p>
        <p>
        Na scenie wykonanej z desek często pojawiają się bardowie, którzy opowiadają opowieści o bohaterach i potworach,
        śpiewają pieśni o straconych miłościach i starożytnych legendach. 
        Tło dźwiękowe stanowią tajemnicze odgłosy zza drzwi prowadzących do niezbadanych zakamarków karczmy.
        </p>
        <p>
        Karczma to miejsce, gdzie można znaleźć sojuszników i wrogów, ukrywać tajemnice i knuć spiski, 
        a wszystko to przy aromatycznych zapachach gotujących się potraw i w nieustającym świetle płonących świec. 
        To serce mrocznego świata, gdzie granice między światami są cienkie, a przygoda czyha za każdym rogiem.
        </p>
        </div>
        <div class="col-md-3 p-2 m-2 bg-dark text-white text-center">
            <p>
            W głębi karczmy, poza główną salą, ukrywają się prywatne pokoje, dostępne tylko dla wybrańców i tych, którzy dostąpili zaproszenia.
            To w tych ukrytych zakamarkach odbywają się tajne spotkania, negocjacje między frakcjami, a także rozmowy między skrytobójcami i ich tajemniczymi pracodawcami.
            Drewniane drzwi prowadzące do tych pokoi są zdobione mistycznymi symbolami, które strzegą tajemnic, jakie skrywają.
            </p>
            <a href="pokoje.php"><button class="btn btn-success">Lista prywatnych pokoi</button></a>
        </div>
</div>
<script src="js/tawerna.js"></script>
<script>
    var userName = "<?php echo $_SESSION['userName']; ?>";
    var userId = "<?php echo $_SESSION['userId']; ?>";

</script>