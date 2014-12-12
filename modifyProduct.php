<?php
require_once('scraperV3.php');
echo "
   <form method = 'post' action='modifyProduct.php'>
   Product ID: <input type='number' name='productid' required>
   <br>
   Product Name: <input type='text' name='productname' required>
   <br>
   imageurl: <input type='text' name='imageurl' required>
   <br>
   Price: <input type='number' name='price' required>
   <br>
   Categoryid: <input type='number' name='categoryid' required>
   
   
    <br>
    Is This Item on Sale? 
    <input type='radio' name='saleState' value='yes'>Yes
    <input type='radio' name='saleState' value='' checked>No
    <br>
    Sale Price: <input type='number' name='saleprice' required>
    <br>
    Is this item taxable? 
    <input type='radio' name='tax' value='yes'>Yes
    <input type='radio' name='tax' value='' checked>No
    
    
   
   <br>
   <input type='submit' value='submit'>
   
   </form>";

    if(empty($_POST['productname']) || empty($_POST['imageurl']) || empty($_POST['price']) || empty($_POST["categoryid"]) ){
    // if even one is empty, then perform no action
    //echo "i got here again";
   }else{
    //echo "i got here 3";
    $productid = $_POST['productid'];
   $productName = $_POST['productname'];
   $imageurl = $_POST['imageurl'];
    $price = $_POST['price'];
    $cid = $_POST["categoryid"];
    $salestate = $_POST['saleState'];
   $saleprice = $_POST['saleprice'];
   $taxable = $_POST['tax'];
   //echo "<br>" . $productName . " " . $imageurl . " " . $price . " " . $cid . " " . $salestate . " " . $saleprice . " " . $taxable;
    modifyProduct( $productid, $productName, $imageurl, $price, $cid, $salestate , $saleprice, $taxable);
   
   
   }
?>