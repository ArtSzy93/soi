<head>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
</head>
<?php
// Zmiana podstawowych informacji o użytkowniku. 
include("panel.php");
if(isset($_FILES['obrazek']) && $_FILES['obrazek']['error'] === UPLOAD_ERR_OK) {
    $id = $_SESSION['userId'];
    $obrazek_tmp = $_FILES['obrazek']['tmp_name'];
    $awatar_folder = "awatars/";
    
    if (!file_exists($awatar_folder)) {
        mkdir($awatar_folder, 0777, true);
    }
  
    // Sprawdź typ pliku
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    $fileType = $_FILES['obrazek']['type'];

    if (in_array($fileType, $allowedTypes)) {
        // Generuj unikalną nazwę pliku, aby uniknąć konfliktów
        $awatar_plik = $awatar_folder . uniqid() . '_' . $_FILES['obrazek']['name'];
        // Zapisz ścieżkę do pliku w bazie
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET image = :img WHERE id = :id");
        $stmt->bindParam(':img', $awatar_plik);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            // Przenieś przesłany plik do docelowego folderu
            if (move_uploaded_file($obrazek_tmp, $awatar_plik)) {
                $_SESSION['awatar'] = $awatar_plik;
                $_SESSION['komunikat'] = "Awatar zapisany";
                header('Location: ustawienia.php');
            } else {
                $_SESSION['komunikat'] = "Awatar NIE zapisany (błąd przesyłania)";
                header('Location: ustawienia.php');
            }
        } else {
            $_SESSION['komunikat'] = "Awatar NIE zapisany (błąd bazy danych)";
            header('Location: ustawienia.php');
        }
    } else {
        $_SESSION['komunikat'] = "Nieprawidłowy typ pliku. Akceptujemy tylko obrazki w formacie .jpg, .jpeg, .png.";
        header('Location: ustawienia.php');
    }
} 
?>
<div class="container">
        <div class="row d-flex justify-content-center">
             <div class="col-5 d-flex justify-content-center bg-danger text-warning">
                <?php 
                if(isset($_SESSION['komunikat']))
                {
                    echo '<p>'.$_SESSION['komunikat'] .'</p>';
                    unset($_SESSION['komunikat']);
                }
                ?>
            </div>
        </div>
        <div class="row mt-2">
                <div class="col-md-4 tlo-divow m-2">
                    <h2 class="text-white" >Zmiana hasła do konta</h2>
                    <form class="text-warning" id="zmien-haslo-form" name="zmien-haslo" method="POST" action="include/funkcje.php">
                        <div class="form-group">
                            <label for="old-pass">Stare hasło</label>
                            <input type="password" class="form-control" id="old-pass" name="old-pass" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="new-pass">Nowe hasło</label>
                            <input type="password" class="form-control" id="new-pass" name="new-pass" placeholder="Podaj nowe hasło..." required>
                        </div>
                        <div class="form-group">
                            <label for="re-new-pass">Powtórz nowe hasło</label>
                            <input type="password" class="form-control" id="re-new-pass" name="re-new-pass" placeholder="Powtórz nowe hasło..." required>
                        </div>
                        <div class="form-group d-flex justify-content-center ">
                             <button type="submit" name="zmien-haslo" id="zmien-haslo-button" class="m-1 p-1 przyciski-strona-glowna">Zmień hasło</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 tlo-divow m-2">
                    <h2>Zmiana nicku postaci</h2>
                    <form class="text-warning" id="zmien-nick-form" name="zmien-nick" method="POST" action="include/funkcje.php">
                        <div class="form-group">
                            <label for="new-nick">Nowa nazwa postaci: </label>
                            <input type="text" class="form-control" id="new-nick" name="new-nick" placeholder="Podaj nowy nick..." required>
                        </div>
                        <div class="form-group d-flex justify-content-center mt-4 ">
                             <button type="submit" name="zmien-nick" id="zmien-nick-button" class="m-1 p-1 przyciski-strona-glowna">Zmień nazwe</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-4 tlo-divow m-2">
                    <h2>Ustaw swój awatar</h2>
                    <form class="text-warning" id="ustaw-awatar" name="ustaw-awatar" method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="awatar">Wgraj obrazek (.jpg, .jpeg, .png)</label>
                            <input type="file" name="obrazek" id="obrazek" accept="image/*" required>
                        </div>
                        <div class="form-group d-flex justify-content-center mt-4 ">
                             <button type="submit" name="ustaw-awatar" class="m-1 p-1 przyciski-strona-glowna">Ustaw awatar</button>
                        </div>
                    </form>
                </div>
                
                <div class="col-md-12 tlo-divow m-2">
                    <h2>Ustaw opis postaci</h2>
                    <form class="text-dark" style="height: auto;" id="ustaw-opis" name="ustaw-opis" method="POST" action="include/funkcje.php" enctype="multipart/form-data">
                        <textarea  name="opis_postaci" id="editor"></textarea>
                        <input type="hidden" name="akcja" value="zmien-opis">
                        <input type="submit" name="ustaw-opis" class="m-1 p-1 przyciski-strona-glowna" value="Zapisz">
                    </form>
                </div>
                <script>
                    ClassicEditor
                    .create( document.querySelector( '#editor' ) )
                    .catch( error => {
                    console.error( error );
                    } );
                </script>
        </div>
    </div>
</div>

