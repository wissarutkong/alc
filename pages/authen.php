<?php 
    session_start();
    if( !isset($_SESSION['AD_ID']) ){
        header('Location: ../../login.php');  
    }
?>