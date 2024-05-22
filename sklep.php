<?php 
include_once("panel.php");
/*
Sklep. 
+ Zakup broni przez gracza
*/
?>
<body>
    <div class="container">
    <div id="okno-modalne" class="okno-info">
                    <div class="okno-info-zawartosc">
                        <p id="okno-wiadomosc"></p>
                        <span class="zamknij">&times; Zamknij</span>
                    </div>
                </div>
            <div class="row text-white bg-succes m-4">
                <div class="col-lg-6 tlo-divow">
                <h2>Sklep z bronią</h2>
                <span>
                  <p> 
                    Pomieszczenie to emanuje duchem starożytności i tajemnicy, a atmosfera jest nasycona zapachem stęchlizny, drewna i metalu.
                    Światło pochodzi z nielicznych płomieni świec, które rzucają falujące cienie na ściany pokryte ciemnym drewnem i tkaninami wytartymi przez czas.
                  </p>
                  <p>
                    Półki wzdłuż ścian są obładowane różnorodnymi brońmi, każda z nich posiada swoją własną historię i siłę. 
                    Na tych półkach znajdziesz tępe miecze, masywne topory, długie włócznie oraz egzotyczne i zdobione krótkie miecze. 
                    Wszystkie są pokryte lekką warstwą kurzu i zardzewiałego brudu, dając do zrozumienia, że w rękach wielu wojowników przeszły przez długi szlak walk i krwi.
                  </p>
                  <p>
                    Na środku pomieszczenia stoi stara drewniana lada, na której wyeksponowane są nieliczne skarby i artefakty.
                    Rękojeści zdobione są runami, a niektóre ostrza wydają się pulsować lekkim światłem, dając do zrozumienia, że posiadają w sobie niezwykłą moc.
                    Za ladą stoi tajemnicza postać w ciemnym kapturze, która czuwa nad skarbami i gotowa jest odpowiedzieć na pytania wojowników w poszukiwaniu właściwej broni.
                  </p>
                  <p>
                    W powietrzu unosi się zapach olejów smarujących broń oraz specjalnych ziół otrzymywanych od kapłanów, które mają chronić i wzmacniać broń przed przeciwnikami.
                    Żelazne, ciche odgłosy ruchu broni, gdy ktoś przemieszcza się po sklepie, dodają mu dodatkowej tajemnicy i niepokojącej atmosfery.
                  </p>
                  <p>
                    Sklep ten to miejsce, w którym granica między światem żywych a umarłych jest niejasna, a przedmioty wystawione na widok publiczny mogą przemawiać
                    do dusz odwiecznych bohaterów i skrywają w sobie potężne, niezrozumiane siły. To idealne miejsce dla tych, którzy szukają narzędzi do walki w mroku
                    i chcą napełnić swoje serca siłą, którą przynoszą ze sobą starożytne artefakty.
                  </p>
                </span>
                </div>
                <div class="col-lg-5 mt-1">
                    <img src="images/sklep.jpg" class="img-fluid" alt="Mroczne pomieszczenie z kowadłem na środku, najpewniej jest to kużnia">
                    <span>Żródło: <a href="https://pl.pinterest.com/pin/763078730628239355/" target="_blank" rel="nofollow"> Javos Ironworks</a>
                </div>
            <div class="row">
            <table class="table table-hover table-dark">
              <thead>
               <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nazwa broni</th>
                  <th scope="col">Minimalne obrażenia</th>
                  <th scope="col">Maksymalne obrażenia</th>
                  <th scope="col">Cena</th>
                  <th scope="col">Akcja</th>
                </tr>
              </thead>
            <tbody class="sklep-tabelka">
                  <?php 
                    wyswietlBronieSklep();
                  ?>
            </tbody>
            </table>
            </div>   
    </div>
</div>
<script src="js/sklep.js"></script>
<?php 
if (isset($_GET['kup'])) {
  $idBroni = $_GET['kup'];
  $wynik = zakupBron($_SESSION['userId'], $idBroni);
  echo '<script>';
  echo 'obslugaZakupu(' . $wynik . ');';
  echo '</script>';
}
?>
