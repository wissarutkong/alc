<?php 
    session_start();
    if( $_SESSION['AD_PERMISSION'] != 1 ){
        header('Location: ../dashboard/');  
    }
?>