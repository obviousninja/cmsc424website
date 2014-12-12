<?php
 require_once('scraperV3.php');
    
 echo "
   <form method = 'post' action='addRemoveProduct.php'>
   Product ID: <input type='text' name='productid'>
    <br>
    Action To Take: 
    <input type='radio' name='what' value='add'>Add
    <input type='radio' name='what' value='remove' checked>Remove
   
   
   <input type='submit' value='submit'>
   </form>";
   
   if(empty($_POST["productid"]) == true){
     //check for valid customer id
     echo "Please Enter a valid product id";
   }else{
        $pid = intval($_POST['productid']);   //can be number
        $actionz = $_POST['what'];   //can be add or remove
        //do the work here
        addRemoveProduct($pid, $actionz);
     
   }

?>