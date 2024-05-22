<?php 
include_once("panel.php");
/*
Miejsce uzdrowienia gracza.
*/
// Przyjecie warunku uzdrowienia
if(isset($_GET['uzdrow']))
{
    $wynik = uzdrowienie($_SESSION['userId']);
    if($wynik)
    {
        $_SESSION['info'] = "Zostałeś w pełni uzdrowiony!";    
    } else {
        $_SEESIOn['info'] = "Niestety, nie udało się!";
    }
    header('Location: glowna.php');
    exit();
}
?>
<div class="container">
    <div class="row mt-2 d-flex justify-content-center">
        <div class="col-md-6 bg-dark text-white justify-content-center p-3">
            <p>To miejsce jest znane jako ostatnia nadzieja dla rannych, schorowanych i tych, którzy potrzebują pomocy w walce z chorobami i przeciwnościami losu.
             Otoczone bujnymi drzewami i żywiołem natury, Uzdrowiciel oferuje zarówno leczenie, jak i duchowe wsparcie.</p>
            <p>Uzdrowienie kosztuje <?php echo 100 * $_SESSION['userLevel']; ?> złotych monet</p>
        </div>
        <div class="col-md-6 d-flex justify-content-center">
            <img src="images/szaman.jpg" class="img-fluid" alt="Uzdrowiciel" >
        </div>
    </div>
    <div class="row mt-3 d-flex justify-content-center">
        <div class="col-md-4 justify-content-cente">
        <a href="szpital.php?uzdrow">
            <button class="przyciski-strona-glowna" >Uzdrów mnie!</button>
        </a>
        </div>
    </div>
</div>
