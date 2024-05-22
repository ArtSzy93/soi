<?php
include_once("panel.php"); // Panel górny, nawigacja
// Wyśwuietlanie ostatnich zmian

?>
<div class="row d-flex justify-content-center m-2">
    <div class="col-7 zmiany">
    <?php 
      wyswietlChangelog();
    ?>
    </div>
</div>