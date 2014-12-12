<?php

require_once('scraperV3.php');

echo "
   <form method = 'post' action='updateDeliveryPerson.php'>
   Delivery Person ID: <input type='text' name='did'>
   
     Action To Take: 
    <input type='radio' name='what' value='add'>Add
    <input type='radio' name='what' value = 'modify'>Modify
    <input type='radio' name='what' value='remove' checked>Remove
    
   
   
   <input type='submit' value='submit'>
   </form>";


    if(empty($_POST['did'])){
        echo "Please enter a valid Delivery Person ID";
    }else{
        
        
        $did = intval($_POST['did']);
        $action = $_POST['what'];
        
        //if action is add
        if(strcasecmp($action, 'add') == 0){
            //launch windows with respective form to fill
           // addDeliveryPerson();
            echo "<script language='javascript'> window.open('addDeliveryPerson.php','_blank') </script>";    
        }else if(strcasecmp($action, 'modify') == 0){
            //launch windows with respective form to fill
            
           //modifyDeliveryPerson();
           echo "<script language='javascript'> window.open('modifyDeliveryP.php','_blank') </script>";    
        }else if(strcasecmp($action, 'remove') == 0){
            removeDeliveryPerson($did);
        }else{
            echo "error invalid entry";
        }
        
    }
?>