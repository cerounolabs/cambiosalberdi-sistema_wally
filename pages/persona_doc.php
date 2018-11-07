<?php
    $path = $_GET['persona'];
    header('Content-type: application/pdf'); 
    header('Content-Disposition: inline; filename"'.$path.'"'); 
    readfile($path);
?>