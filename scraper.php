<?php
    $homepage = file_get_contents('http://www.harrisfarm.com.au/');
    
    echo htmlspecialchars($homepage);
    
?>