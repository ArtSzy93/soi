<?php 
session_start(); // Inicjacja sesji
session_destroy(); // Zniszczenie sesji
header("Location: index.php");