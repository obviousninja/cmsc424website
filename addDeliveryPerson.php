<?php
require_once('scraperV3.php');

echo "
   <form method = 'post' action='addDeliveryPerson.php'>
   Delivery Person Name: <input type='text' name='name'>
   
   <br>
   Address: <input type='text' name='address' required>
   <br>
   workstart: <input type='text' name='ws' required>
   <br>
   workends: <input type='text' name='we' required>
   <br>
   salary: <input type='number' name='salary' required>
   <br>
   current location: <input type='text' name='curlocation' required>
   <br>
   current route: <input type='text' name='curroute' required>
   
   <input type='submit' value='submit'>
   </form>";
   
   if(empty($_POST['name']) || empty($_POST['address']) || empty($_POST['ws']) || empty($_POST['we']) || empty($_POST['salary']) || empty($_POST['curlocation']) || empty($_POST['curroute'])){
     //if anyone of them are empty, then something wrong hapened
     echo "Please Enter Delivery Guy Information Above";
   }else{
     $floatSalary = floatval($_POST['salary']);
     addDeliveryPerson($_POST['name'],$_POST['address'], $_POST['ws'], $_POST['we'], $floatSalary, $_POST['curlocation'], $_POST['curroute']);
   }
?>