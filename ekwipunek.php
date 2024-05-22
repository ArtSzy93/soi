<?php 
include_once("panel.php");
/*
Panel ekwipunku gracza.
+ Zakładanie/zdejmowanie broni
*/
?>

<body>
<div class="container mt-5">
<div class="row  text-danger bg-succes m-4">
              <!-- okno modalne do informacji o powodzeniu/niepowodzeniu działania -->
              <div id="okno-modalne" class="okno-info">
                    <div class="okno-info-zawartosc">
                        <p id="okno-wiadomosc"></p>
                        <span class="zamknij">&times; Zamknij</span>
                    </div>
              </div>
              
              <div class="col">
              <div >
                <!-- Aktualnie wyposażona broń -->
                <?php $bron = uzywanaBron($_SESSION['userId']); ?>
                <p>Aktualnie używana broń:<p> 
                  <p id="ekwipunek-aktualna-bron"> <?php echo $bron; ?> </p>
                  <p style="color: white; font-size:small;">Nazwa - Pseudonim broni (minimalne obrazenia - maksymalne)</p>
              </div> 
              <?php 
              if(isset($_SESSION['komunikat']))
              {
                echo $_SESSION['komunikat'];
                unset ($_SESSION['komunikat']);
              }

              ?>
              <!-- okno modalne do informacji o powodzeniu/niepowodzeniu działania -->
              <div>
                  <form id="zmienPseudo" action="include/funkcje.php" method="POST">
                      <input type="text" name="pseudo" id="pseudo" placeholder="Wpisz nowy pseudonim broni..">
                      <input type="hidden" name="idBroni" value="<?php if(isset($_SESSION['weaponId'])) echo $_SESSION['weaponId']; ?>">
                      <input type="submit" value="Zmień pseudonim broni">
                  </form>
              </div>

              <span>Dotepne bronie:</span>
              <table class="table table-hover table-dark ml-0">
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
            <tbody>
                  <?php 
                    bronieEkwipunek($_SESSION['userId']);
                  ?>
            </tbody>
            </table>
        </div>
</div>
</div>
<script src="js/ekwipunek.js"></script>
<?php 
// Zakładanie broni 
if (isset($_GET['zaloz'])) {
  $idBroni = $_GET['zaloz'];
  $wynik = zalozBron($_SESSION['userId'], $idBroni);
  echo '<script>';
  echo 'zakladanie(' . $wynik . ');';
  echo '</script>';
}
// Odbieranie komunikatu GET o powodzeniu/niepowodzeniu nadawnia pseudonimu broni
if(isset($_GET['status']))
{
  $wynik = $_GET['status'];
  if($wynik = "success")
  {
    $_SESSION['komunikat'] = "Pseudonim nadany poprawnie!";
  } else {
    $_SESSION['komunikat'] = "Pseudonim NIE nadany poprawnie!";
  }
}
?>
