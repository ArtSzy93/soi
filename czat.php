<?php 
include_once("panel.php");
/*
Czat non-climat
*/
?>
<div class="row d-flex justify-content-center">
        <div class="col-5 p-2 mt-3 bg-dark text-white">   
                    <p>Tutaj znajduję się czat ogólny. Prosimy o zachowanie grzeczności wobec siebie i szanowanie odmiennych zdań.</p>
        </div>

</div>
<div class="row d-flex justify-content-center">
    <div class="col-md-6 d-flex justify-content-cente ">
        <div id="czat-glowny">
            <div id="chat-box">   
            </div>
        </div>
    </div>
</div>   
<div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="wiadomosc">
        <input type="text" id="message-input" placeholder="Wpisz wiadomość">
            <button onclick="sendMessage('<?php echo $_SESSION['userName']; ?>(<?php echo $_SESSION['userId']; ?>)')">Wyślij</button>
        </div>
     
    </div>
</div>
<script src="js/czat.js"></script>
<script>
    var userName = "<?php echo $_SESSION['userName']; ?>";
    var userId = "<?php echo $_SESSION['userId']; ?>";
</script>