<?php
 require_once "Mail.php";
 
    function createDatabase(){
        $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        
        $conn = new mysqli($servername, $username, $password);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "CREATE DATABASE if not exists myDB";
        if ($conn->query($sql) === TRUE) {
              echo "Database created successfully";
        } else{
            echo "query error";
        }
        
      
        
        $conn->close();    
    }
    function createTables(){
        $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //create category
         $createProductCategory="create table productcategory(
        categoryid int(10) UNSIGNED AUTO_INCREMENT,
        category varchar(40) NOT NULL,
        subcategory varchar(40) not null,
        PRIMARY KEY(categoryid)
        )ENGINE=INNODB";
         //create product Table
        $createProduct = "create table product(
            productid INT(10) UNSIGNED AUTO_INCREMENT,
            productname varchar(50),
            imageurl varchar(255),
            price FLOAT UNSIGNED,
            categoryid INT(10) unsigned,
            isonsale BOOLEAN,
            saleprice FLOAT unsigned,
            taxable BOOLEAN,
            beginsaledate datetime,
            soldcount int(10) unsigned DEFAULT 0,
            PRIMARY KEY (productid),
            FOREIGN KEY (categoryid) references productcategory(categoryid)
        )ENGINE=INNODB";
//FOREIGN KEY (categoryid) references productcategory(categoryid)
            
 $createCustomer="create table customer(
         customerid int(10) unsigned auto_increment,
         name varchar(30),
         age int(3),
         sex varchar(1),
         password varchar(80),
         balance float,
         paymentflag boolean,
         paymentmade datetime,
         state varchar(10),
         creditcardnumber varchar(10),
         ccexpiration datetime,
         bankaccountnumber varchar(20),
         bankroutingnumber varchar(20),
         address varchar(50),
         phonenumber varchar(10),
         email varchar(40),
         status varchar(10),
         currentbasket int(10),
         primary key(customerid)   
        )ENGINE=INNODB";
        //create basket
        $createBasket = "create table basket(
            basketid INT(10) UNSIGNED AUTO_INCREMENT,
            customerid INT(10) UNSIGNED,
            isstandingorder BOOLEAN default false,
            haltstandingorder BOOLEAN default false,
            standingordertype varchar(10),
            basketdate DATETIME,
            PRIMARY KEY (basketid),
            FOREIGN KEY (customerid) references customer(customerid)
            
        )ENGINE=INNODB";
        
        $createBasketItem="create table basketitem(
            basketid INT UNSIGNED,
            productid INT UNSIGNED,
            productquantity INT UNSIGNED,
            FOREIGN KEY (basketid) references basket(basketid),
            FOREIGN KEY (productid) references product(productid)
        )ENGINE=INNODB";
       
        $createAdministrator="create table administrator(
        adminid int(10) unsigned auto_increment,
        name varchar(30),
        password varchar(30),
        address varchar(50),
        phonenumber varchar(10),
        email varchar(40),
        primary key(adminid)
        )ENGINE=INNODB";
        
        $createTransaction="create table transaction(
            transactionid int(10) unsigned auto_increment,
            basketid int(10) unsigned,
            customerid int(10) unsigned,
            transactiontotal float,
            acceptflag boolean,
            ordertime DATETIME,
            estimatetimeofarrival datetime,
            deliverydate DATETIME,
            primary key(transactionid, basketid),
            foreign key(basketid) references basket(basketid),
            foreign key(customerid) references customer(customerid)
        )ENGINE=INNODB";
        
        $createDeliveryPricing="create table deliverypricing(
            rangestart int(10),
            rangeend int(10),
            price float,
            primary key(rangestart, rangeend)
        )ENGINE=INNODB";
        
        $createBill="create table bill(
            billid int(10) unsigned auto_increment,
            transactionid int(10) unsigned,
            totalitemcost float,
            costwithtax float,
            deliverycharge float,
            tip float,
            paidflag boolean,
            primary key(billid),
            foreign key(transactionid) references transaction(transactionid)
        )ENGINE=INNODB";
        
        $createDeliveryPerson="create table deliveryperson(
            dpid int(10) unsigned auto_increment,
            name varchar(30),
            address varchar(50),
            workstart varchar(20),
            workend varchar(20),
            salary float,
            curlocation varchar(50),
            curroute varchar(40),
            primary key(dpid)
        )ENGINE=INNODB";
       
       //correct so far
        $createDispatchTicket="create table dispatchticket(
         transactionid int(10) unsigned,
         customerid int(10) unsigned,
         basketid int(10) unsigned,
         dpid int(10) unsigned,
         customeraddress varchar(50),
         dateandtime DATETIME,
         primary key(transactionid, dateandtime),
         foreign key(transactionid) references transaction(transactionid),
         foreign key(customerid) references customer(customerid),
         foreign key(basketid) references basket(basketid),
         foreign key(dpid) references deliveryperson(dpid)
        )ENGINE=INNODB";
        
    /* if ($conn->query($createTestTable) === TRUE) {
      echo "Table MyGuests created successfully";
    }
     
     $insertThing = "insert into testTable (firstname, lastname) values ('sick', 'hobo')";
     if ($conn->query($insertThing) === TRUE) {
      echo "Table MyGuests created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }   */
    
        queryCreate($conn, $createProductCategory, "productcategory");
        queryCreate($conn, $createProduct ,"product");
        queryCreate($conn, $createCustomer, "customer");
        queryCreate($conn, $createBasket, "basket");
        queryCreate($conn, $createBasketItem, "basketitem"); 
        queryCreate($conn, $createAdministrator, "administrator");
        queryCreate($conn, $createTransaction, "transaction");
        queryCreate($conn, $createDeliveryPricing, "deliverypricing");
        queryCreate($conn, $createBill, "bill");
        queryCreate($conn, $createDeliveryPerson, "deliverypricing");
        queryCreate($conn, $createDispatchTicket, "dispatchticket");
   
        $conn->close();
    }
    
    //helper for creating table
    function queryCreate($conn, $query, $name){
        if ($conn->query($query) === TRUE) {
         echo "Table $name created successfully\n";
        }else{
            echo "Table $name not created successfully\n";
        }
        
    }
    
    //main scraper function
    function scrapeMasterMarkK(){
         $homepage = file_get_contents('http://www.harrisfarm.com.au/');
    
        //$processedHomePage =  htmlspecialchars($homepage, ENT_COMPAT, "UTF-8", false);
        //$reverseProc = htmlspecialchars_decode($processedHomePage);
        //echo $processedHomePage;
        
        //get the navigator bar
       
       // $pattern = '/collections(\/[\w-]*)*/i';//'/collections\/[\w-]*/i';
        $pattern = '/collections([\w\-&\/]*)/i';
        
       preg_match_all($pattern, $homepage, $collections);
      array_pop($collections); // taking off the second part of the array which doesn't contain collection and with "/"
      print_r($collections); //everything scraped only 2-10 is needed for our purpose
     
       $patterntype = '/[\w-&]*$/i';
    
     
       $subSiteName = array(); //containing subsite names
       $typeArr = array(); //containing type names
       for($x=2; $x<10; $x++){
         array_push($subSiteName, $collections[0][$x] ); //push subsite name
         
         preg_match_all($patterntype, $collections[0][$x], $type);
         
         $typeArr[$type[0][0]] = array();//associative, empty array
         
       }
       echo "<p>subsite name: </p>";
      print_r($subSiteName);
       echo "<p>type names: </p>";
      print_r($typeArr);
       echo "<p> </p>";
       
       //populate subcategories here
       //
       //reserved for code populating subcategories
       //, $type[0][0] are the subtypes
       //fruit subcategory
       
       
       
       $subsubsite=array(); //containing site address for the fruit
       for($x=15; $x<=28; $x++){
        preg_match_all($patterntype, $collections[0][$x], $type); //getting te name of the type, it will be under $type[0][0] #NOT THE SUBSITE ADDRESS
        //name of the subsite address is $collections[0][$x]
        //create an associate array with name of the type and it points to the subsite address
        $subsubsite[$type[0][0]] = $collections[0][$x];
         
        //array_push($typeArr['fruit'], $type[0][0]);
        //array_push($typeArr['fruit'], array());
        //$typeArr['fruit'] = ""
        //array_push($typeArr['fruit'])
       }
       array_push($typeArr['fruit'], $subsubsite); //populate fruit and its subtype
       
       
       //veggies subcategory
       $subsubsite = array();
       for($x=31; $x<=48; $x++){
        preg_match_all($patterntype, $collections[0][$x], $type);
      
         $subsubsite[$type[0][0]] = $collections[0][$x];
       }
      array_push($typeArr['vegies'], $subsubsite); //populate vegies and its subtypes
       //print_r($typeArr);
       //groceries subcategory
       $subsubsite = array();
       for($x=51; $x<=70; $x++){
        preg_match_all($patterntype, $collections[0][$x], $type);
      
         $subsubsite[$type[0][0]] = $collections[0][$x];
       }
             array_push($typeArr['groceries'], $subsubsite); //groceries population
       //fridge subcategory
              $subsubsite = array();
       for($x=73; $x<=84; $x++){
                   preg_match_all($patterntype, $collections[0][$x], $type);
      
         $subsubsite[$type[0][0]] = $collections[0][$x];
       }
       array_push($typeArr['fridge'], $subsubsite); //fridges
        //butcher subcategory
               $subsubsite = array();
        for($x=87; $x<=96; $x++){
        preg_match_all($patterntype, $collections[0][$x], $type);
      
         $subsubsite[$type[0][0]] = $collections[0][$x];
       }
       array_push($typeArr['butcher'], $subsubsite); //
        //seafood subcategory
               $subsubsite = array();
        for($x=99; $x<=107; $x++){
        preg_match_all($patterntype, $collections[0][$x], $type);
      
         $subsubsite[$type[0][0]] = $collections[0][$x];
       }
       array_push($typeArr['seafood'], $subsubsite); //
        //organic subcategory
               $subsubsite = array();
         for($x=109; $x<=113; $x++){
        preg_match_all($patterntype, $collections[0][$x], $type);
      
         $subsubsite[$type[0][0]] = $collections[0][$x];
       }
       array_push($typeArr['organic'], $subsubsite); //
        //wholesale subcategory
               $subsubsite = array();
        for($x=116; $x<=120; $x++){
        preg_match_all($patterntype, $collections[0][$x], $type);
      
         $subsubsite[$type[0][0]] = $collections[0][$x];
       }
    array_push($typeArr['wholesale'], $subsubsite); //

    print_r($typeArr); //printing the filled associative array
     insertProductTypes($typeArr);  //populate the sql database PRODUCTCATEGORY, THIS IS THE RIGHT CODE
    
    //scanning through the associative array and find the category id of each combinations
    echo "<p></p>";
    foreach($typeArr as $gk => $gk_value){
        //echo " " . $gk . " ";  //$gk is the grandkey
        //print_r($gk_value); echo "<p></p>";
        foreach($gk_value[0] as $sk => $sk_value){
            //echo " " . $sk . " "; //$sub key is the subtype
            //gk and sk are grandkey and subkey
           // echo "subvalue " . $sk_value;
           // echo "<br>";
          
            $address = 'http://www.harrisfarm.com.au/'.$sk_value;
            //echo $address;
            //echo "<br>";
            //TODO find category id and scan and insert the products
            
            if(intval(cidGetter($gk, $sk)) != -1){
                scanProducts(intval(cidGetter($gk, $sk)), $address);  //insert the individual product
            }
            
            
            
        }
      //  echo "<p></p>";
    }
    
    
    //scanProducts(intval(cidGetter('fruit', 'apples')), 'http://www.harrisfarm.com.au/collections/apples'); //only scan one page
    }
    
    //returns categoryid based on the grandkey and subkey, return -1 if no such item exist
    function cidGetter($grandkey, $subkey){
        $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
       
        // Check connection
        $sql = "SELECT categoryid, category, subcategory FROM productcategory where category='$grandkey' and subcategory='$subkey'";
        
        $result = $conn->query($sql);

        //
   if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         //echo "<br> id: ". $row["categoryid"]. " - Name: ". $row["category"]. " subcategory" . $row["subcategory"] . "<br>";
         $conn->close();
         return $row["categoryid"];
     }
} else {
     
     $conn->close();
     return -1;
}
        //
        
        
    }
    //take product type and webaddress
    //one page ONLY! returns nothing
    function scanProducts($categoryid, $webAddress){
        //open connection
        $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        
         $currentAddress = file_get_contents($webAddress);
        // echo "<p>this is web address:" . $webAddress . "this is categoryid" . $categoryid. "</p>";
     
         $pattern = '{<div\sclass=\"imgcont\sloadingimg\">\s*<a\shref=\"[\w\-\/]*\"\sclass=\"image-inner-wrap\s*\">\s*<img\s*src=\"[\w\.\/\?=\-]*\"\s*alt=\"[\w\s\(\-\)]*\"\s*\/>\s*<div\sclass=\"salecontainer\">\s*<span\sclass=\"sale\">\s*(<small>from<\/small>\s*|)\$\d*\.\d*}i';  //work on this pattern
         preg_match_all($pattern, $currentAddress, $chunk);
        //chunk[0][index] has all the contents
          //get product name and the product price for each name
          $patternProductName = '{alt=\"[\w\s\(\-\)]*}i';
         // $patternProductPrice = '{\$\d*\.\d*$}i';  //with dollar sign
          $patternProductPrice = '{\d*\.\d*$}i';  //without dollar sign
          $patternProductImageurl = '{img\s*src=\"[\w\.\/\?=\-]*}i';
          for($x = 0; $x< 1; $x++){
            for($y=0; $y< count($chunk[$x]); $y++){
                
               // echo "Index x: " . $x . "subIndex: ". $y . "</p>";
                //echo "<p> </p>";
                //echo htmlspecialchars($chunk[$x][$y]);
                //get the name chunk
                preg_match_all($patternProductName, $chunk[$x][$y], $nameChunk); //should match a name string
                //echo "<p> </p> nameString: ";
                //print_r( substr($nameChunk[0][0], 5)); //name string under substr($nameChunk[0][0], 5)
                $namestring1 = substr($nameChunk[0][0], 5);
                //get the price chunk
                preg_match($patternProductPrice, $chunk[$x][$y], $priceChunk); //should match a price chunk
                //echo "<p> </p> priceString: ";
                //print_r(floatval($priceChunk[0])); //price string under $priceChunk[0]
                $pricestring1 = floatval($priceChunk[0]);
                //get the image url, source is from shopify
               //echo "<p> </p>imageURL: ";
               preg_match_all($patternProductImageurl, $chunk[$x][$y], $imageUrl); //should match the image url
               //print_r(substr($imageUrl[0][0], 9)); //imageurl is in substr($imageUrl[0][0], 9)
               $urlstring = substr($imageUrl[0][0], 9); 
               //TODO insert the product into the product category 
               //construct sqlcommand for insertion
               
               $singleProductInsert = "INSERT INTO product (productname, imageurl, price, categoryid, isonsale, saleprice, taxable ) VALUES ('$namestring1','$urlstring', '$pricestring1', '$categoryid' ,false,'$pricestring1',true)";
               //insertion
               insertProduct($conn, $singleProductInsert);
               
            }
          }
          
          
           $conn->close();
    }
    function insertProduct($conn, $sqlcommand){
        
        
        if ($conn->query($sqlcommand) === TRUE) {
             echo "New product record created successfully";
             } else {
              echo "Error: " . $sqlcommand . "<br>" . $conn->error;
              echo "<br>";
            }
    
       
    }
    
    function insertProductTypes($associativeArrayArray){
        //open connection
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        
        foreach($associativeArrayArray as $x => $x_value) { //grand type
          //construct query string
          foreach($associativeArrayArray[$x][0] as $y => $y_value){ //subtype $y is the key
             $insertion = "INSERT INTO productcategory (category, subcategory) values ('$x', '$y')";
             
            if ($conn->query($insertion) === TRUE) {
             echo "New producttype record created successfully";
             } else {
              echo "Error: " . $insertion . "<br>" . $conn->error;
              echo "<br>";
             }
          }
        
        }
        //close the connection
        $conn->close();
    }
    //populate the items
    function display(){
        echo "<p>i am a monster</p>";
    }
    
    
    
    
    function insert($sql){
         //open connection
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        if ($conn->query($sql) === TRUE) {
             echo "New record created successfully";
             } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
              echo "<br>";
             }
    }
    
    //takes productid and the number of sold
    function updateProductCount($pid, $num){
            //open connection
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        //retrieve the product with product id, and get the soldcount
        $sqlcommand = "SELECT productid, soldcount from product where productid='$pid'";
        $result = $conn->query($sqlcommand);
        if ($result->num_rows > 0) {
             while($row = $result->fetch_assoc()) {
            echo "<br> pid: ". $row["productid"]. " - soldcount: ". $row["soldcount"] . "<br>";
            if(is_int(intval($row["soldcount"]))=== true){
                echo "sold count is an int";
            }else{
                echo "sold count is not an int";
            }
            //increment the sold count base on the $num
            $newCount = intval($row["soldcount"])+$num;
            echo "newCount" . $newCount;
            
              //update the new sold count associated with the product id
              
            $updatecommand = "update product set soldcount= '$newCount' where productid = '$pid'";
            if ($conn->query($updatecommand) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
           
     }
            
        }else{
            echo "no such product exist";
        }
        
        $conn->close();
        
        
        
      
        
        
        
    }
    //going through the categoryids in the grandcategoryname and output the total sold count
    function validcateidoutput($categoryname ,$conn){
     // $sql = "select categoryid from productcategory where category = '$grandtype'";
     $sql = "select categoryid from productcategory where category='$categoryname'";
     $arr = array();  //this will be the returnable array
     $result = $conn->query($sql);
     $counter = 0;
     if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
       //array_push($arr, $row['categoryid']);
        //going through every single category id and add their sold count to counter

        $catid = intval($row['categoryid']);
        $sql = "select soldcount from product where categoryid = '$catid'";
        $result1 = $conn->query($sql);
        if($result1->num_rows > 0){
         while($row1 = $result1->fetch_assoc()){
        //  echo $row1['soldcount'];
          $cc = intval($row1['soldcount']);
          $counter = $counter + $cc; 
         }
        }
        
      }
     }else{
      echo "fatal error no such category name";
      return -1;
     }
     
     echo " ::soldcount = " . $counter . "]";
     
     //return $arr;
    }

    //this function displays each grandcategory with their respective sold count
    function grandSoldCountDisplay(){
     
      //open connection
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        
     //find the grand types
      $sql= "select distinct category from productcategory";
      $result = $conn->query($sql);
      if($result->num_rows > 0){
       while($row = $result->fetch_assoc()){
        echo " [" . $row['category'];
        $cataName = $row['category'];
        
        $procArr = validcateidoutput($cataName, $conn);  //array of category id
        if($procArr == -1){
          echo "fatal error at grandsoldcountdisplay()";
        }
        
       }
      }
     $conn->close();
    }
    function correctBestWorstReport($lb, $ub, $grandtype){
     
      //open connection
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
      //echo "<br>lowerbound: " . $lb . "<br>upper bound" . $ub;
      
      if($lb > $ub){
       //lower bound cannot be greater than the upper bound
       echo "<br>Error. Lower bound cannot be greater than the upper bound";
       return;
      }
      
      //echo "grandtype is: " . $grandtype;
      //getting the grandtype, type array
      $validTypeArray = array(); // this is the array that stores the type that needs to be
      //another word this is the category id
      $sql = "select categoryid from productcategory where category = '$grandtype'";
      $result = $conn->query($sql);
      if($result->num_rows > 0){
       while($row = $result->fetch_assoc()){
         //numeric returns of category ids
         //echo "cataid:  " . $row['categoryid'];
         $curid = intval($row['categoryid']);
         array_push($validTypeArray, $curid);
         
       }
      }
      echo "<br>";
      //print_r($validTypeArray);
      
      //display the grandcategory with their respective total sold count
      grandSoldCountDisplay($conn); //this might be invalid
      
      //retrieve every single basket that is within the date range
      /*$sql = "";
      $result = $conn->query($sql);
      if($result->num_rows > 0){
       while($row = $result->fetch_assoc()){
        //echo "cataid:  " . $row['categoryid'];
       
       }
      }*/
      $bestArray = array();
      $curbestnum = -1;
      
      $worstArray = array();
      $curworstnum = 100000;
      
      $sql = "select basketid from basket where basketdate >= '$lb' and basketdate <= '$ub'";
      $result = $conn->query($sql);
      if($result->num_rows > 0){
       while($row = $result->fetch_assoc()){
        //echo "<br>basket:  " . $row['basketid'];
        //find basketitems in one basket
        $curBid = intval($row['basketid']);
        $sql = "select basketid, productid, productquantity from basketitem where basketid = '$curBid'";
        $resultItem = $conn->query($sql);
        if($result->num_rows > 0){
         while($rowrow = $resultItem->fetch_assoc()){
          //echo "<br>basketid is: " . $rowrow['basketid'];
           //does this product id belong to grandtype's categoryid array?
           //find categoryid this product id belong to, and check if this item
           //is in the $validTypeArray, then increase the count otherwise don't
           $curpid = intval($rowrow['productid']);
           if(findpidContain($curpid, $validTypeArray,$conn) == 1){
            //find the sold count of current productid
             $cursold = findpidSoldcount($curpid, $conn); // the sold count of curpid
             
             if($cursold == -1){
              echo "<br>Invalid Product";
             }else{
              //echo "<br>cur sold count: " . $cursold; 
              //normal
              /*begin */
              if($curworstnum > $cursold ){
                 //   echo "<br>soldcount" . intval($row["soldcount"]) . " ";
                    $curworstnum = $cursold; // current worst number if now the  intval number
                   // echo "worstnum now:  " . $curworstnum . "<br>";
                    //discard the curworst array accumulated so far
                    //echo "<br>changed for worst: worstnum" . $curworstnum . "pid: " . $curpid;
                    //echo "<br>worst array before clearing";
                    //print_r($worstArray);
                    $worstArray = array();
                    //echo "<br>worst array after clearing";
                    //print_r($worstArray);
                    //put the recent name into the curworst array
                    //findpidname($curpid,$conn)
                    array_push($worstArray, findpidname($curpid,$conn));
                    
                    
                }else if($curworstnum == $cursold){
                    //echo "<br>curworstnum: " . $curworstnum . "cursold: " . $cursold;
                    array_push($worstArray, findpidname($curpid,$conn));
                }
                
                if($curbestnum < $cursold ){
                    //curbestnum is lesser than the cur num, thus replace
                   
                    $curbestnum = $cursold;
                     //echo "<br>change for best: bestnum" . $curbestnum . "pid: " . $curpid;
                    //clear the curbest num array
                    $bestArray = array();
                    array_push($bestArray, findpidname($curpid,$conn));
                }else if($curbestnum == $cursold){
                    array_push($bestArray, findpidname($curpid,$conn));
                    
                }
              /*end */
             }
           }
           
        
         }
        }
        
        
       
       }
      }
      
      //find each basketitems in the basket that has the type specified
      echo "<br>Current worst array<br>";
      print_r($worstArray);
      echo "<br>Sold Count Number: " . $curworstnum;
      
      echo "<br>Current best array<br>";
      print_r($bestArray);
      echo "<br>Sold Count Number: " . $curbestnum;
      
      $conn->close();
    }
    //simply takes a product id and return the name of the product, return -1 if the product does not exist
    function findpidname($pid, $conn){
     $sql = "select productname from product where productid='$pid'";
     $result = $conn->query($sql);
     if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
       $nameret = $row['productname'];
       return $nameret;
      }
     }else{
      return -1;
     }
     
    }
    //simply takes a product id and return the sold count, return -1 if the product does not exist
    function findpidSoldcount($pid, $conn){
     $sql = "select soldcount from product where productid='$pid'";
     $result = $conn->query($sql);
     if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
       //return sold cout
       $soldcount = intval($row['soldcount']);
       return $soldcount;
      }
     }else{
      //no such product return -1
      return -1;
     }
     
    }
    //returns 1 if product id belong to the category ids in the array, else it return -1
    function findpidContain($productid, $cidarray, $conn){
      //find the categoryid of the product given product id
      $sql = "select productid, categoryid from product where productid='$productid'";
      $result = $conn->query($sql);
      if($result->num_rows > 0){
       while($row = $result->fetch_assoc()){
        //echo $row['categoryid']
        $pcateid = intval($row['categoryid']); //categoryid of product id
        
       }
      }
      
      for($x=0; $x<count($cidarray); $x++){
       if($cidarray[$x] == $pcateid){
        //matches
        return 1;
       }
       //next
      }
      
      return -1;
    }
    
    //generates average basket value report, take a param base on how many days. so for example 1 day or 200 days. upper range is not restricted
    function generateTest(){
        //open connection
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sqlArray = array();
        //insert 3 customers
        $sqlcommand = "insert into customer (name, password, email) values ('jing', 'allies', 'infinityarc@gmail.com')";
         array_push($sqlArray, $sqlcommand);
        $sqlcommand = "insert into customer (name, password, email) values ('sam', 'wintchester', 'samwinchester@gmail.com')";
         array_push($sqlArray, $sqlcommand);
        $sqlcommand = "insert into customer (name, password, email) values ('dean', 'winchester', 'deanwinchester@gmail.com')";
         array_push($sqlArray, $sqlcommand);
        /*if ($conn->query($insCustomer1) === TRUE && $conn->query($insCustomer2) === true &&  $conn->query($insCustomer3)) {
             echo "Table Customer1 Customer2 Customer3 created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        } */  
        //insert 3 baskets
        
        $sqlcommand = "insert into basket (customerid, basketdate) values ('1', '2012-11-11 00:20:21')";
         array_push($sqlArray, $sqlcommand);
        $sqlcommand = "insert into basket (customerid, basketdate) values ('1', '2010-11-30 00:10:31')";
         array_push($sqlArray, $sqlcommand);
        
        $curTime = date("Y-m-d H:i:s");
        $sqlcommand = "insert into basket (customerid, basketdate) values ('2', '$curTime')";
         array_push($sqlArray, $sqlcommand);
        $sqlcommand = "insert into basket (customerid, basketdate) values ('3', '2012-02-12')";
         array_push($sqlArray, $sqlcommand);
        
        
        
        /*if($conn->query($ins4)){
            echo "basket table created successfully";
        }else{
            echo "error creating table: " . $conn->error;
        }*/
          
        //inserting basketitems
        //first item
        $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('1', '1', '1')";
        array_push($sqlArray, $sqlcommand);
        //second item
        $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('1', '2', '1')";
        array_push($sqlArray, $sqlcommand);
        //third item
        $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('1', '3', '1')";
        array_push($sqlArray, $sqlcommand);
        
        //first item of second basket
        $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('2', '2', '1')";
        array_push($sqlArray, $sqlcommand);
        $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('2', '3', '1')";
        array_push($sqlArray, $sqlcommand);
        $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('2', '4', '1')";
        array_push($sqlArray, $sqlcommand);

        
        
        
      
        //looping through the array of sqlcommands
        for($x=0; $x < count($sqlArray); $x++){
            if($conn->query($sqlArray[$x])){
                echo "item $x inserted successfully";
            }else{
                echo "item $x inserted failed" . $conn->error;
            }
        }
        
        $conn->close();
    }
    function generateBasketItem(){
        //open connection
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sqlArray = array();
        //inserting basketitems
        //first item
       /* $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('1', '1', '1')";
        array_push($sqlArray, $sqlcommand);
        //second item
        $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('1', '2', '1')";
        array_push($sqlArray, $sqlcommand);
        //third item
        $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('1', '3', '1')";
        array_push($sqlArray, $sqlcommand);
        
        //first item of second basket
        $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('2', '2', '1')";
        array_push($sqlArray, $sqlcommand);
        $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('2', '3', '1')";
        array_push($sqlArray, $sqlcommand);
        $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('2', '4', '1')";
        array_push($sqlArray, $sqlcommand);
       
       
$sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('2', '5', '4')";
        array_push($sqlArray, $sqlcommand);
        
        $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('2', '11', '7')";
        array_push($sqlArray, $sqlcommand);*/
       
       $sqlcommand = "insert into basketitem (basketid, productid, productquantity) values ('2', '20', '2')";
        array_push($sqlArray, $sqlcommand);
        
      
        //looping through the array of sqlcommands
        for($x=0; $x < count($sqlArray); $x++){
            if($conn->query($sqlArray[$x])){
                echo "item $x inserted successfully";
            }else{
                echo "item $x inserted failed" . $conn->error;
            }
        }
        $conn->close();
    }
    
    //grab all the basket within the start and the end date and display their average over the days
    function averageBasketValueReport($mDay, $mHour){
        //pre-work, generate baskets assigning default timezone
          date_default_timezone_set('America/New_York');
           //open connection
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
          //generateTestBaskets();
        /* example of date interval 
        P = YMD
            Y = Year
            M = Month
            D = Day
        T = HIS
            H = hour
            I = minute
            S = second
            
        number infront of suffix
        P and T must be before the specific time closure
$date = new DateTime('2000-01-20');
$date->sub(new DateInterval('PT10H30S'));
echo $date->format('Y-m-d H:i:s') . "\n";

$date = new DateTime('2000-01-20');
$date->sub(new DateInterval('P7Y5M4DT4H3M2S'));
echo $date->format('Y-m-d H:i:s') . "\n";

         */
          
        //TODO calculate currentdate-mday
      //date("Y-m-d H:i:s")   //current date and time, mysql insertable
        echo "Current DateTime " . date("Y-m-d H:i:s") . "<br>";
        $startDate = date("Y-m-d H:i:s");
        $newdate = new DateTime($startDate);  //as end date
        
        $subtractString = "P" . $mDay . "D" . "T" . $mHour . "H";  //formating the substraction
        //echo $subtractString;
        
        $resultDate = $newdate->sub(new DateInterval($subtractString));
        echo "Lower End DateTime: " . $resultDate->format("Y-m-d H:i:s") . "<br>"; //as start date
        
    
        
       /* if(is_string($startDate) === true){
            echo "this is a string";
        }*/
        //formating date and time into strings
        $endDateString = $startDate;  //datetime when admin pressed the report button
        $beginDateString = $resultDate->format("Y-m-d H:i:s");  //datetime that goes back to the lower bound
        
        //"SELECT categoryid, category, subcategory FROM productcategory where category='$grandkey' and subcategory='$subkey'";
        //TODO retrieve the basketid that has lesser than current day, but greater than currentdate-mDay
        
        
        $sqlcommand = "select distinct basketid, basketdate from basket where basketdate < '$endDateString' and basketdate > '$beginDateString'";


        //selects baskets within date
        $result = $conn->query($sqlcommand);

        //
        $totalSum = 0;  //total price currently accumulated
        $totalRow = 0;
      //  echo "did i get here";
   if ($result->num_rows > 0) {
     // output data of each row
  //   echo "i got here i hope";
     while($row = $result->fetch_assoc()) {
        // echo "<br> BasketId: ". $row["basketid"]. " Basket Date: ". $row["basketdate"]. "<br>";
         
         //find the basketitems that has the associated basketid and return their price and quantity
         $bid = $row["basketid"];
         $sqlcommand = "select productid, productquantity from basketitem where basketid = '$bid'";
         //select basketitems that has items and quanity
         $basketItemResult = $conn->query($sqlcommand);
         if($basketItemResult->num_rows > 0){
            //store things table $brow
            
            while($brow = $basketItemResult->fetch_assoc()){
              //  echo "<br> productid: " . $brow["productid"] . "- productquanitty: " . $brow["productquantity"]."<br>";
                //store productid
                $pid = $brow["productid"];
                $curQuan = $brow["productquantity"];
                //use the productid here to retrieve the product price then multiply the price by product quantity
                $sqlcommand = "select productid, productname, price from product where productid = '$pid'";
                
                
                $priceResult = $conn->query($sqlcommand);
                if($priceResult->num_rows > 0){
                    while($prow= $priceResult->fetch_assoc()){
                    //    echo "<br>-------- PID: " . $prow["productid"] . " Product Name: " . $prow["productname"] . " Price: " . $prow["price"]. " Product Quantity: " . $brow["productquantity"]."<br>";
                        //getting price
                        $pricy = floatval($prow["price"]);
                        //totalproduct multiply by quanity
                        $mul = $pricy*$curQuan;
                        //added it to total sum
                        $totalSum = $totalSum + $mul;
                    }
                }
                
                
            }
          
         }
         
         $totalRow++; //count the baskets so far
      }
     }else{
        echo "<br> No Result Found!";
     }
     if($totalRow == 0){ //correction
      $finalResult = 0;
     }else{
     $finalResult = $totalSum/$totalRow;}
     echo "<br>Total Basket: $totalRow<br> Total Sum: $totalSum <br>Average Basket Value: " . $finalResult . "<br>";
       
        $conn->close();
    }
    //just return the customer table i guess.
    function customerReport(){
             //open connection
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sqlCommand = "select customerid, name, age, sex, balance, paymentflag, address, phonenumber, email, status from customer";
        
        echo "Customer Report<br>";
        $customerResults = $conn->query($sqlCommand);
        if($customerResults->num_rows > 0){
             while($row= $customerResults->fetch_assoc()){
                echo "<br> Customer Id: " . $row['customerid'];
                echo " Customer Name: " . $row["name"] . " Age: " . $row["age"] . " Sex: " . $row["sex"] . " balance: " . $row["balance"];
                echo " address: " . $row["address"] . " phonenumber: " . $row["phonenumber"] . " email: " . $row["email"] . " status: " . $row["status"] . "<br>";
                
             }
        }else{
            echo "No Customer Exists";
        }
        
        $conn->close();
    }
   // estabConnect();  //this is the correct code. REENABLE for database repopulation
    
    //mark delinquent customer if they didn't make payment in 30 days, deactivate a customer if he is delinquent
    function markCustomer(){
         date_default_timezone_set('America/New_York');
        $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        //get the customer that has no null value as the payment made, if a customer has null as paymentmade
        //then he is new and there is no way he will be owing anyway.
        $sqlCommand = "select customerid, name, paymentmade, balance from customer";
        
        $result = $conn->query($sqlCommand);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
               // echo "<br>customerid: " . $row['customerid'] . " name: "  . $row['name'] . " paymentmade: " . $row['paymentmade'];
              //  echo " balance: " . $row['balance'];
               // echo "<br>Current DateTime " . date("Y-m-d H:i:s") . "<br>";
                $startDate = new DateTime(date("Y-m-d H:i:s")); //current date and time
                $givenDate = new DateTime($row['paymentmade']); //date and time that they have
                
                $storeDate = $startDate->diff($givenDate);
                $diffdate = $storeDate->format('%a');
                $curBalance = floatval($row['balance']); //need
                $cid = $row['customerid'];
                //$didate = $startDate->diff($givenDate);
                //$didate = $didate->format("Y-m-d H:i:s");
               // print_r($storeDate);
                //$storeDate->format('%R%a');
                //$storeDate->format("d");
                //echo "<br>" . $diffdate . "<br>";
                //echo "<br>$startDate<br>";
                //if the last payment is greater than 30, we mark this person as delinq
                if(intval($diffdate) > 60 &&  $curBalance > 0){
                    //delinquent
                   // echo " Delinquent name: "  . $row['name'];
                    $sqlCommand = "update customer set status='delinq', state='deact' where customerid='$cid'";
                    if ($conn->query($sqlCommand) !== TRUE) {
             
            echo "Error updating record: " . $conn->error;
         }
                    
                }else if(intval($diffdate) > 30 && intval($diffdate) <= 60 &&  $curBalance > 0){
                    //late
                   // echo "late";
                     $sqlCommand = "update customer set status='late' where customerid='$cid'";
                     if ($conn->query($sqlCommand) !== TRUE) {
             
            echo "Error updating record: " . $conn->error;
         }
                    
                }else{
                    //ontime
                    $sqlCommand = "update customer set status='ontime' where customerid='$cid'";
                    
                }
                //execute the command
                
                
                
            }
        }
        
        $conn->close();
        
    }
    //output the delinquent customer and email them
    function delinqReport(){
        $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sqlCommand = "select customerid, name, email, status from customer where status = 'delinq'";
        echo "<br>Delinquent Customer Report<br>";
        $delinqResult = $conn->query($sqlCommand);
        if($delinqResult->num_rows > 0){
            while($row = $delinqResult->fetch_assoc()){
                echo "<br> Customer Id: " . $row['customerid'];
                echo " Customer Name: " . $row["name"];
                echo " email: " . $row["email"] . " status: " . $row["status"] . "<br>";
                
                
                $cname = $row['name'];
                $mailadd = $row["email"];
                
                //send email to the customer
                $from = 'smallfry9000@yahoo.com';
                $to = $mailadd;
                $subject = "Pay Up $cname , You are a bad customer";
                $body = "Hi,\n\nYou are delinquent on payment! what payment you ask?! the \"Payment\". I am sending my homies after you, you will be REKTed. REKTed i tell ya!";

                $headers = array(
                    'From' => $from,
                    'To' => $to,
                    'Subject' => $subject
                );

                $smtp = Mail::factory('smtp', array(
                    'host' => 'ssl://smtp.mail.yahoo.com',
                    'port' => '465',
                    'auth' => true,
                    'username' => 'smallfry9000@yahoo.com',
                    'password' => 'insaneAsylum1'
                ));

                $mail = $smtp->send($to, $headers, $body);

                if (PEAR::isError($mail)) {
                    echo('<p>' . $mail->getMessage() . '</p>');
                } else {
                    echo('<p>Message successfully sent!</p>');
                }
                
                //end of sending mail
                
            }
        }
        
        $conn->close();
    }
    
    //suggest things base all their basketitems
    //returns -1 or an integer, this number cannot possibly be 0.
    //returns a productid in integer, if -1 is returned, then the customer has no history of buying anything
    function suggestProduct($customerid){
            $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $assocArray = array();  //this is the associative array that keeps track of counts
                                //head will be the name, and the tail will be the count
                                //head will be the categoryid
                                //tail will be the count number so far
        //get all the stuff associated with the customerid
        $sql = "select basketid, customerid from basket where customerid = '$customerid'";
           
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
          //      echo "<br>basketid: " . $row['basketid'] . " customerid " . $row['customerid'];
                
                //now get basketitems
                $bid = $row['basketid'];
                $sql = "select productid, productquantity from basketitem where basketid = '$bid'";
                
                $bitemResult = $conn->query($sql);
                
                if($bitemResult->num_rows > 0){
                
                    while($bitemRow = $bitemResult->fetch_assoc()){
                    
                 //       echo "<br>------- productid: " . $bitemRow['productid'] . " productquantity " . $bitemRow['productquantity'];
                        $headName = $bitemRow['productid'];
                        $numToAdd = intval($bitemRow['productquantity']);
                        
                        $sql = "select productid, categoryid from product where productid = '$headName'";    
                    
                        $presult = $conn->query($sql);
                        if($presult->num_rows > 0){
                            while($prow = $presult->fetch_assoc()){
                //                echo "<br>################## productid: " . $prow['productid'] . " categoryid " . $prow['categoryid'];
                                $cheadName = $prow['categoryid'];
                               // array_key_exists($cheadName, $assocArray)
                              //  if(is_null($assocArray[$cheadName]) === true){
                                    if(array_key_exists($cheadName, $assocArray) == false){
                            $assocArray[$cheadName] = $numToAdd;
                            }else{
                            $assocArray[$cheadName] = $assocArray[$cheadName] + $numToAdd; }
                                
                            }
                        }
                        //add things to the assoc array
                        /*if(is_null($assocArray[$headName]) === true){
                            $assocArray[$headName] = $numToAdd;
                        }else
                            $assocArray[$headName] = $assocArray[$headName] + $numToAdd; 
                        }*/
                    }
                    
                }
                
                
            }
        }else{
            return -1;
        }
        
       // print_r($assocArray);
        //find the subtype with highest category
        $curbest = -1;
        $categoryidBest;
        
        foreach($assocArray as $x => $x_value) {
      //   echo "Key=" . $x . ", Value=" . $x_value;
       // echo "<br>";
            if($curbest < $x_value){
                $curbest = $x_value;
                $categoryidBest = $x; //giving it the best categoryid
            }
        }
        if(isset($categoryidBest) == false){
            return -1;
        }
      //  echo "highest num: " . $curbest . " best categoryid " . $categoryidBest;
        
        //now the categoryidbest is the best
       //count the total number of product under that best category
      // $sql = "select categoryid, productid, productname from product where categoryid = '$categoryidBest'";
      $sql = "select count(*) as total from product where categoryid = '$categoryidBest'";
       $result = $conn->query($sql);
       if($result->num_rows >0){
        while($newRow = $result->fetch_assoc()){
          // echo "<br>################## productid: " . $newRow['productid'] . " categoryid " . $newRow['categoryid'] . " name " . $newRow['productname'];
        //   echo "<br> count: ". $newRow['total'];
            $total = intval($newRow['total']);  //where to stop
        }
       }
       

       $stopNum = rand(1, $total);  // number to stop
       $curStopNum = 0;
       $retId=-1;
       //return the product at certain count
       $sql = "select productid from product where categoryid = '$categoryidBest'";
       $finalResult = $conn->query($sql);
       if($finalResult->num_rows > 0){
        while($finalRows = $finalResult->fetch_assoc()  ){
            if($curStopNum >= $stopNum){
                break;
            }
         //   echo "<br>finalrow productid " . $finalRows['productid'];
            $retId = intval($finalRows['productid']);
       //     echo "<br> " . $retId;
            $curStopNum = $curStopNum + 1;
            
        }
       }
       
       
       
    //   echo "<br>" . $stopNum . " retid: " . $retId;
            
       
        
        $conn->close();
        return intval($retId);  //the randomly generated product id
        //returning the pr
    }
 
    //return the product name and id base on the product id
    function toStringProduct($pid){
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
      //  echo "<br> pid is : " . $pid;
        $sql = "select productid, productname from product where productid = '$pid'";
        $result = $conn->query($sql);
         if($result->num_rows >0){
       //     echo "<br> result num row is: " . $result->num_rows;
        while($row = $result->fetch_assoc()){
               // print_r($row);
                echo "<br>Base on your past purchase your recommended product is: ". $row['productname'];
        
            }
         }else{
            echo "no result";
         }
        
        $conn->close();
    }
   
    //reactivate the customer if the customer is deactivated or vice versa
    function reDeActivateCustomer($customerid){
        //find out if a customer if deactivated, if so, reactivate or vice versa
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //select the customer state given the customerid
        $sqlcommand = "select customerid, state from customer where customerid ='$customerid'";
        $result = $conn->query($sqlcommand);
        if($result->num_rows >0){
            while($row = $result->fetch_assoc()){
             //   echo "cur state of customer: " . $row['state'];
                if(strcasecmp($row['state'], 'act') == 0){
                    //deactivate the customer
                    $sqlcommand = "update customer set state='deact' where customerid = '$customerid'";
                }else if(strcasecmp($row['state'], 'deact') == 0){
                    //reactivate the customer
                    $sqlcommand = "update customer set state='act' where customerid = '$customerid'";
                }else{
                    //doesn't match either, by default it is set to active state
                    $sqlcommand = "update customer set state='act' where customerid = '$customerid'";
                }
                
                if ($conn->query($sqlcommand) === TRUE) {
      echo "Customer State Successfully Changed";
} else {
    echo "Error Update Customer State: " . $conn->error;
}
            }
            
        }else{
            echo "No Such Customer Exist";
        }
        
        
        $conn->close();
    }
     function addRemoveProduct($pid, $what){

        //find out if a customer if deactivated, if so, reactivate or vice versa

           $servername = "localhost";

        $username = "jchen127";

        $password = "KbZFqBcZCy29b3Lx";

        $dbname = "mydb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection

        if ($conn->connect_error) {

            die("Connection failed: " . $conn->connect_error);

        }

        

        //  $sql = "DELETE FROM MyGuests WHERE id=3";

        if(strcasecmp($what, 'add') == 0){

            //open a new webpage that allows adding products

            

            echo "<script language='javascript'> window.open('addProduct.php','_blank') </script>";       

            

        }else if(strcasecmp($what, 'remove') == 0){

            //remove the product from the database

            $sql = "delete from product where productid='$pid'";

            if ($conn->query($sql) === TRUE) {

    echo "Record deleted successfully";

} else {

    echo "Error deleting record: " . $conn->error;

}



            

        }else if(strcasecmp($what, 'modify') == 0){
            echo "<script language='javascript'> window.open('modifyProduct.php','_blank') </script>";
        }
    
        

        $conn->close();

        

    }
     function modifyProduct( $productid, $productName, $imageurl, $price, $cid, $salestate , $saleprice, $taxable){

               $servername = "localhost";

        $username = "jchen127";

        $password = "KbZFqBcZCy29b3Lx";

        $dbname = "mydb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection

        if ($conn->connect_error) {

            die("Connection failed: " . $conn->connect_error);

        }
        /*
                 $updatecommand = "update product set soldcount= '$newCount' where productid = '$pid'";

            if ($conn->query($updatecommand) === TRUE) {

    echo "Record updated successfully";

} else {

    echo "Error updating record: " . $conn->error;

}
         */
        $conproductid = intval($productid);
         
         $conprice = floatval($price);

         $concid = intval($cid);

         $consaleprice = floatval($saleprice);



         

      //  $sql = "insert into product (productname, imageurl, price, categoryid, isonsale, saleprice, taxable) values ('$productName', '$imageurl', '$conprice', '$concid', '$salestate' , '$consaleprice', '$taxable')";
        $sql = "update product set productname='$productName', imageurl='$imageurl', price='$conprice', categoryid='$cid', isonsale='$salestate', saleprice='$saleprice', taxable='$taxable' where productid='$conproductid'";
        
     if ($conn->query($sql) === TRUE) {

      echo "updated product table successfully";

    } else {

      echo "Error updating into table: " . $conn->error;

    }   

        

        

        $conn->close();

    

   }
    //must make sure the cid agrees with the product categoryid from the productcategory table
    function addProduct( $productName, $imageurl, $price, $cid, $salestate , $saleprice, $taxable){
               $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
         /* if ($conn->query($createTestTable) === TRUE) {
      echo "Table MyGuests created successfully";
    }
     
     $insertThing = "insert into testTable (firstname, lastname) values ('sick', 'hobo')";
     if ($conn->query($insertThing) === TRUE) {
      echo "Table MyGuests created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }   */
         $conprice = floatval($price);
         $concid = intval($cid);
         $consaleprice = floatval($saleprice);

         
        $sql = "insert into product (productname, imageurl, price, categoryid, isonsale, saleprice, taxable) values ('$productName', '$imageurl', '$conprice', '$concid', '$salestate' , '$consaleprice', '$taxable')";
     if ($conn->query($sql) === TRUE) {
      echo "inserted into product table successfully";
    } else {
      echo "Error inserting into table: " . $conn->error;
    }   
        
        
        $conn->close();
    
   }
   
   //update delivery person, if exist
   //if delivery person do not exist, then prompt insertion
   function removeDeliveryPerson($personid){
             $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
         
            //remove the delivery person from the database
            $sql = "delete from deliveryperson where dpid='$personid'";
            if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
        
        
        
       $conn->close();
   }
   
   function addDeliveryPerson($name, $address, $ws, $we, $salary, $curlocation, $curroute){
          $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        /* if ($conn->query($createTestTable) === TRUE) {
      echo "Table MyGuests created successfully";
    }
     
     $insertThing = "insert into testTable (firstname, lastname) values ('sick', 'hobo')";
     if ($conn->query($insertThing) === TRUE) {
      echo "Table MyGuests created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }   */
        $sqlcommand = "insert into deliveryperson (name, address, workstart, workend, salary, curlocation, curroute) values ('$name', '$address', '$ws', '$we', '$salary', '$curlocation', '$curroute')";
     if ($conn->query($sqlcommand) === TRUE) {
      echo "Delivery Person Created Successfully";
    } else {
      echo "Error creating Delivery Person: " . $conn->error;
    } 
        
        $conn->close();
    
   }
   
   function modifyDeliveryPerson($did, $name, $address, $ws, $we, $salary, $curlocation, $curroute){
      $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        /*
                 $updatecommand = "update product set soldcount= '$newCount' where productid = '$pid'";
            if ($conn->query($updatecommand) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
         */
       //check if the delivery person exist if not quit, otherwise modify
       $sqlcommand = "select name from deliveryperson where dpid = '$did'";
       $result = $conn->query($sqlcommand);
       if($result->num_rows > 0){
        //exist
        //echo "person exist yikes";
        //updating the delivery person
        $sqlcommand = "update deliveryperson set name= '$name', address= '$address', workstart= '$ws', workend='$we', salary= '$salary', curlocation= '$curlocation', curroute= '$curroute' where dpid = '$did'";
      //execute
                if ($conn->query($sqlcommand) === TRUE) {
    echo "Delivery Person Profile updated successfully";
} else {
    echo "Error Updating Profile: " . $conn->error;
}
       }else{
        //doesn't exist
        echo "No Such Delivery Person Exist Please Enter a Proper Delivery Person";
        
       }
       
        
        $conn->close();
   }
   
   //returns one random item to go on sale, it will return a product id
   //it is entirely possble to return identical product to go on sale, but
   //but since no matter how many times the onsale flag is modified
   //there can only be one result, thus all we need to worry about is the
   //
   function findItemToGoSale(){
    //find total number of products that are on in the table
    $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        /*
         $sql = "select count(*) as total from product where categoryid = '$categoryidBest'";
       $result = $conn->query($sql);
       if($result->num_rows >0){
        while($newRow = $result->fetch_assoc()){
          // echo "<br>################## productid: " . $newRow['productid'] . " categoryid " . $newRow['categoryid'] . " name " . $newRow['productname'];
        //   echo "<br> count: ". $newRow['total'];
            $total = intval($newRow['total']);  //where to stop
        }
       }
        */
        //finding upper bound
        $sql = "select count(*) as total from product";
        $result = $conn->query($sql);
       if($result->num_rows >0){
        while($newRow = $result->fetch_assoc()){
         
            $total = intval($newRow['total']);  //where to stop
        }
       }else{
        echo "Fatal Error, the product table is not populated, Application crashing...";
       }
        //$total is the upper bound
        $randProductId = rand(1, $total);
        
        $conn->close();
        return $randProductId;
   }
   //set onsale flag of  product with $pid
   //also set their prices
   
   function setProductToSale($pid){
    date_default_timezone_set('America/New_York');
     $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        //product has to exist, it is impossible it will not be
        //product flag will be updated
        /*
            //updating the delivery person
        $sqlcommand = "update deliveryperson set name= '$name', address= '$address', workstart= '$ws', workend='$we', salary= '$salary', curlocation= '$curlocation', curroute= '$curroute' where dpid = '$did'";
      //execute
                if ($conn->query($sqlcommand) === TRUE) {
    echo "Delivery Person Profile updated successfully";
} else {
    echo "Error Updating Profile: " . $conn->error;
}
        */
        //get the current price
        $sqlcommand = "select price, productname, beginsaledate from product where productid = '$pid'";
        $result = $conn->query($sqlcommand);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                //retrieve the price
               
                
                $curPrice = floatval($row['price']);
                $calcSalePrice = $curPrice/2;
                $startDate = date("Y-m-d H:i:s");
           //     echo "<br> currentbeginsaledate: " . $row['beginsaledate'] . " unstored date: " . $startDate;
           //      echo "<br>the current price is: " . $row['price'] . " for " . $row['productname'] . " new price: " . $calcSalePrice;
                //set the onsaleflag and set the sale price, also set the date of it being on sale 
                $sqlcommand = "update product set isonsale=1, saleprice='$calcSalePrice', beginsaledate='$startDate' where productid = '$pid'";
                if ($conn->query($sqlcommand) === TRUE) {
    echo "<br>onsale status updated successfully";
} else {
    echo "<br>Error Updating onsale status: " . $conn->error;
}
                
            }
        }else{
            echo "Fatal Error, an error occurred while searching for the product, Application terminating...";
        }
        
        $conn->close();
   }
   
   //param: customerid and the array of product that are on sale, customer has to exist as it will definitely be
   //if this customer have any of those products in their basket, then email him with the items on the array
   function isbrought($customerid, $productArray, $conn){
       /*  $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }*/
        $arrayThatGoesEmail = array();
        //find baskets with the customer id
        $sqlcommand = "select distinct basketid from basket where customerid ='$customerid'";
        $result = $conn->query($sqlcommand);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
           //     echo "<br> basketid is: " . $row['basketid'];
                //check the basket items of basket id
                $curBid = intval($row['basketid']);
            //    echo "<br> basketid curbid: " . $curBid;
                $sqlcommand = "select distinct basketid, productid from basketitem where basketid = '$curBid'";
                $resultOne = $conn->query($sqlcommand);
                if($resultOne->num_rows > 0){
                    while($rowOne = $resultOne->fetch_assoc()){
                 //       echo "<br> Basketid: " . $rowOne['basketid'] . " productid:  " . $rowOne['productid'];
                        $pid = intval($rowOne['productid']);
                        if(contain($pid, $productArray) == 1){
                            //it is contained in product array
                            array_push($arrayThatGoesEmail, $pid);
                        }else{
                            //do nothing
                        }
                        
                    }
                }
                
            }
        }else{
            echo ".";
        }
        //check if array is empty, if not send email to the customer
        if(count($arrayThatGoesEmail) != 0){
            $uniquefyArr = array_values(array_unique($arrayThatGoesEmail));
          //  echo "<br>riginal array <br>";
         //   print_r($productArray);
          //  echo "<br>something matched. output array: <br>";
          //  print_r($uniquefyArr);
             //find the email of this guy
        $sqlcommand = "select name, customerid, email from customer where customerid ='$customerid'";
        //should return exactly one result
        $emailresult = $conn->query($sqlcommand);
        if($emailresult->num_rows > 0){
            while($emailRow = $emailresult->fetch_assoc()){
          //      echo "<br>this guy's email is: " . $emailRow['email'] . " his customerid and name is: " . $emailRow['customerid'] . $emailRow['name'];
            
            $emailName = $emailRow['name'];
            $emailemail = $emailRow['email'];
            $emailString = implode($uniquefyArr);
            //send email to the customer
            $from = 'smallfry9000@yahoo.com';
            $to = $emailemail;
            $subject = "Your bought Item is on Sale $emailName";
            $body = "Hi,\n\n the following items/item that you bought are on sale. don't miss out! item number: $emailString";
            
            $headers = array(
             'From' => $from,
            'To' => $to,
         'Subject' => $subject
            );

        $smtp = Mail::factory('smtp', array(
        'host' => 'ssl://smtp.mail.yahoo.com',
        'port' => '465',
        'auth' => true,
        'username' => 'smallfry9000@yahoo.com',
        'password' => 'insaneAsylum1'
    ));

        $mail = $smtp->send($to, $headers, $body);

        if (PEAR::isError($mail)) {
      echo('<p>' . $mail->getMessage() . '</p>');
        } else {
      echo('<p>Message successfully sent!</p>');
        }
                
                
            }
        }
        //end of sending mail
        echo "<br>this customer with similar product interest are emailed";
        }
        
       
        
        echo "<br>this customer with customerid of $customerid is not emailed";
        
      /*  $conn->close();*/
    
   }
  
   //returns 1 if true element in the array, -1 if not
   function contain($element, $array){
    for($x=0; $x<count($array); $x++){
        if($element == $array[$x]){
            return 1;
        }
    }
    return -1;
   }
   //go through every single customer and execute isbrought
   function customerloop($arrToPass){
          $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //going through every single customer
        $sqlcommand = "select customerid from customer";
        $result = $conn->query($sqlcommand);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
          //   echo '<br>customer id' . $row['customerid'];
             $cid = intval($row['customerid']);

             isbrought($cid, $arrToPass, $conn);
            }
        }
        
    $conn->close(); //close connection before doing this as the new connection will be made       
   }
   function placeOnSale(){
        
     //echo "swoop down and ate your heart";
     //at least 1 item will go on sale and at max 7 items will go on sale
     $saleItemNum = rand(1, 7);
     //find the items that will go on sale and update their onsale price and turn their onsale flag to true
     //echo "<br>current on sale item num: " . $saleItemNum . "<br>";
     
     $onSaleArray = array(); //productids of the items that will go on sale
     //push however many times of the random product into the array
     for($x=0; $x < $saleItemNum; $x++){
        array_push($onSaleArray, findItemToGoSale());
     }
     //uniquefy the array so there will be no duplicate
     $uniqueOnSaleArray = array_unique($onSaleArray); //array of product id that will go on sale
     echo "<br>following are the items that are set to be onsale: <br>";
     print_r($uniqueOnSaleArray);
     
     //find the items in $uniqueOnSaleArray in product and update their flag and price
     for($x=0; $x< count($uniqueOnSaleArray); $x++){
        setProductToSale($uniqueOnSaleArray[$x]);
      }
     //send emails to the customer that bought this item
        //check if one customer bought any of those items
        //$testArray = array(1, 2, 3, 4, 5, 20);
        //print_r($testArray);
      // isbrought(1, $testArray);
        
        //echo "<br> this could be true: " . count(array());
     //go through every single customers
     customerloop($uniqueOnSaleArray);
     
     //revert the item onsale back to not on sale after a week time
     revertItSeven();
     

   }
   //generate xx amount of customer base on count
    function generateCustomer($count){
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $curTime = date("Y-m-d H:i:s");
         //bonus person with valid email
        $sql = "insert into customer (name, age, sex, password, balance, paymentflag , state, creditcardnumber, ccexpiration, bankaccountnumber, bankroutingnumber, address, phonenumber, email, status, currentbasket)
            values ( 'Chen, Jing', '1', 'm', '111', '0', '1', 'act', '11111111', '2222', '33333', '444444', 'Hornbake Library, College Park, MD 20742', '4442225555', 'infinityarc@gmail.com', 'delinq', '1');";
        $sqlA = "insert into basket (customerid, isstandingorder, standingordertype, basketdate) values (LAST_INSERT_ID(), 1, 'daily' ,'$curTime')";

        $sql1 = "insert into customer (name, age, sex, password, balance, paymentflag , state, creditcardnumber, ccexpiration, bankaccountnumber, bankroutingnumber, address, phonenumber, email, status, currentbasket)
            values ( 'Samelson, Joel', '1', 'm', '111', '0', '1', 'act', '11111111', '2222', '33333', '444444', '4310 Knox Road, College Park, MD 20740', '4442225555', 'jsamel@terpmail.umd.edu', 'delinq', '2' );";
        $sqlB = "insert into basket (customerid, isstandingorder, standingordertype, basketdate) values (LAST_INSERT_ID(), 1, 'daily' ,'$curTime')";
        
        if ($conn->query($sql) === TRUE) {
           echo "customer jing created successfully";
           $conn->query($sqlA);
        } else {
               echo "Error creating customer: " . $conn->error;
        }
        if ($conn->query($sql1) === TRUE) {
               echo "customer joel created successfully";
               $conn->query($sqlB);
        } else {
               echo "Error creating customer: " . $conn->error;
        }
        
        
     
     
     //end of bonu person with email

          /* if ($conn->query($createTestTable) === TRUE) {
      echo "Table MyGuests created successfully";
    }
     
     $insertThing = "insert into testTable (firstname, lastname) values ('sick', 'hobo')";
     
     if ($conn->query($insertThing) === TRUE) {
      echo "Table MyGuests created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }   */
        
        for($x=0; $x<$count; $x++ ){
            $name = "person" . $x;
            $emailz = "person" . $x . "@gmail.com";
            $sql = "insert into customer (name, age, sex, password, balance, paymentflag , state, creditcardnumber, ccexpiration, bankaccountnumber, bankroutingnumber, address, phonenumber, email, status)
            values ( '$name', '1', 'm', '111', '0', '1', 'act', '11111111', '2222', '33333', '444444', 'Hornbake Library, College Park, MD 20742', '4442225555', '$emailz', 'ontime' )";
            //echo "<br>" . $sql;
        
     if ($conn->query($sql) === TRUE) {
           echo "customer person $x created successfully";
     } else {
           echo "Error creating customer: " . $conn->error;
     }  
            
        }

        $sql = "insert into administrator (name, password, address, phonenumber, email) values ('jing', '111', 'wailing cavern', '1112223333', 'infinityarc@gmail.com')";
         if ($conn->query($sql) === TRUE) {
           echo "administrator jing created successfully";
     } else {
           echo "Error creating customer: " . $conn->error;
     }
        
        $conn->close();
    }
        function generateDeliveryGuy($count){
           $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        for($x=0; $x<$count; $x++ ){
             $name = "deliveryguy" . $x;
             $sql = "insert into deliveryperson (name, address, workstart, workend, salary, curlocation, curroute)
             values ('$name', '123 ebola street', '1:00', '1:00', '10.00', 'home', 'zNation')";
             
              if ($conn->query($sql) === TRUE) {
           echo "Delivery person $x created successfully";
     } else {
           echo "Error creating delivery person: " . $conn->error;
     }  
             
        }
        $sql = "insert into deliverypricing (rangestart, rangeend, price) values ('0', '10', '5'), ('10', '20', '10')";

         if ($conn->query($sql) === TRUE) {
           echo "Delivery person $x created successfully";
     } else {
           echo "Error creating delivery person: " . $conn->error;
     }  
       
        
                
        $conn->close();
    }
    
    function generateBasket(){
        date_default_timezone_set('America/New_York');
        set_time_limit(0);
        $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $maxAmount = rand(200, 10000);
        //echo $maxAmount;
        
        for($i=0;$i<$maxAmount;$i++) {
            $customerNum = rand(1, 50);
            $curTime = date("Y-m-d H:i:s");
            echo "customernum is: " . $customerNum . " curTime " . $curTime . "<br>";
            $sql = "insert into basket (customerid, isstandingorder, standingordertype, basketdate) values ('$customerNum', '1', 'Daily' ,'$curTime')";        
           
            if ($conn->query($sql) === TRUE) {
                echo "Basket $i generated successfully";
            }else{
                echo "Error generating basket: " . $conn->error;
            }
            //insert basketid into the customer's currentbasketid
            //find the max basket t the moment
            $sql = "select count(*) as total from basket";
            $result1 = $conn->query($sql);
            if($result1->num_rows >0){
                while($newRow = $result1->fetch_assoc()){
                    // echo "<br>################## productid: " . $newRow['productid'] . " categoryid " . $newRow['categoryid'] . " name " . $newRow['productname'];
                    //   echo "<br> count: ". $newRow['total'];
                    $maxBasketid = intval($newRow['total']);  // will be the id that we are looking for
                }
            }
    
            //update the customer's current basket with the latest basket as the customer's most current basket
          
            /*   $updatecommand = "update product set soldcount= '$newCount' where productid = '$pid'";
            if ($conn->query($updatecommand) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }*/
            $sql = "update customer set currentbasket= '$maxBasketid' where customerid='$customerNum'";
            if ($conn->query($sql) === TRUE) {
                echo "Customer record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }

            generateBaskeItems($maxBasketid, $conn);

            //calculate costs, etc.
            $sql = "SELECT * FROM basket b, basketitem bi, product p, customer c WHERE c.customerid = $customerNum AND c.currentbasket = b.basketid AND c.currentbasket = bi.basketid AND bi.productid = p.productid";
            $result = mysqli_query($conn, $sql);
            
            $totalPrice = 0;
            $priceWithTax = 0;
            $tax = 0;
            $deliveryCost = 0;
            $isCheck = false;
            $custAddress = "";

            if ($result && mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    //echo "Customer name: " . $row["name"]. " - basketid: " . $row["basketid"] . " - productname: " . $row["productname"] . " - quantity: " . $row["productquantity"] . "<br>";
                    $tempPrice = 0;
                    if ($row["isonsale"]) {
                        $tempPrice = $row["saleprice"] * $row["productquantity"];
                    } else {
                        $tempPrice = $row["price"] * $row["productquantity"];
                    }
                    $totalPrice = $totalPrice + $tempPrice;

                    if ($row["taxable"]) {
                        $tax = $tax + ($tempPrice * 0.06);
                        $priceWithTax = $priceWithTax + ($tempPrice * 1.06);
                    } else {
                        $priceWithTax = $priceWithTax + $tempPrice;
                    }

                    if ($row["paymentflag"]) {
                        $isCheck = true;
                    }
                    $custAddress = $row["address"];
                    $_SESSION["basketid"] = $row["basketid"];
                }
                $priceWithTax = round($priceWithTax, 2);
                

                /* FIND DELIVERY TIME AND DISTANCE */
                $url = 'http://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=Computer+Science+Instructional+Center&';
                $url = $url . 'destinations=' . urlencode($custAddress);
                //echo "URL: " . $url . "<br>";
                $data = file_get_contents($url);

                if(!$data) echo "FAILED DISTANCE!!!!<br>";
                //echo $data . "<br>";

                $data = json_decode($data);
                
                $time = 0;
                $distance = 0;
                foreach($data->rows[0]->elements as $road) {
                    $time += $road->duration->value;
                    $distance += $road->distance->value;
                }

                $drivingDistMeters = $distance;
                echo "Driving distance: " . $drivingDistMeters . "<br>";
                $drivingDistMiles = $drivingDistMeters/1000 * 0.621371;
                echo "Driving distance in miles: " . $drivingDistMiles . "<br>";

                $sqlDist = "SELECT price FROM deliverypricing WHERE $drivingDistMiles >= rangestart AND $drivingDistMiles < rangeend";
                $resultDist = mysqli_query($conn, $sqlDist);

                if ($resultDist && mysqli_num_rows($resultDist) > 0) {
                    $price = 0;
                    // output data of each row
                    while($row = mysqli_fetch_assoc($resultDist)) {
                        $price = $row["price"];

                    }
                    $totaltransactioncost = $priceWithTax + $price;
                    $date = date("Y-m-d H:i:s", time());
                    $timeofarrival = date("Y-m-d H:i:s", time() + $time);

                    $sqlTrans = "INSERT INTO transaction VALUES (NULL, $maxBasketid, $customerNum, $totaltransactioncost, 1, '$date', '$timeofarrival', NULL)";
                    $resultTrans = mysqli_query($conn, $sqlTrans);

                    if ($resultTrans) {
                        echo "Transaction inserted<br>";

                        $sqlBill = "INSERT INTO bill VALUES (NULL, LAST_INSERT_ID(), $totalPrice, $priceWithTax, $price, NULL, 1)";
                        $resultBill = mysqli_query($conn, $sqlBill);

                        if (!$resultBill) {
                            echo "Insertion of bill failed!<br>";
                        } else {
                            echo "Bill insertion success!<br>";

                            $sqlDispatch = "INSERT INTO dispatchticket VALUES ((SELECT transactionid FROM transaction WHERE basketid = $maxBasketid), $customerNum, $maxBasketid, NULL, (SELECT address FROM customer WHERE customerid = $customerNum), '$date')";
                            $resultDispatch = mysqli_query($conn, $sqlDispatch);

                            if (!$resultDispatch) {
                                echo "Dispatch ticket creation failed!<br>";
                            } else {
                                echo "Dispatch ticket creation success!<br>";
                            }
                        }
                    } else {
                        echo "FAILED transaction<br>";
                    }

                } else {
                    echo "Error getting distance<br>";
                }
            } else {
                echo "Error getting basket/customer/product info<br>";
            }




            //$sql = "INSERT INTO $database.transaction VALUES (NULL, $maxBasketid, $customerNum, $totaltransactioncost, 1, '$date', '$timeofarrival', NULL)";
            assignDeliveryPeople();   
            deliverOrders();
            checkStandingOrders();
            
            echo "<hr>";
            
            ob_flush();
            flush();
            sleep(4);
        }
     
        
        $conn->close();
    }
    

    function generateBaskeItems($bid, $conn){
           
        
        //get current count of products
        //$sql = "select count(*) as total from product where categoryid = '$categoryidBest'";
        $sql = "select count(*) as total from product";
        $result1 = $conn->query($sql);
        if($result1->num_rows >0){
            while($newRow = $result1->fetch_assoc()){
                // echo "<br>################## productid: " . $newRow['productid'] . " categoryid " . $newRow['categoryid'] . " name " . $newRow['productname'];
                //   echo "<br> count: ". $newRow['total'];
                $totalProduct = intval($newRow['total']);  //where to stop
            }
        }
        echo "<br>total product is: " . $totalProduct;
       
        
          
        $maxAmount1 = rand(1, 10);
        for($i=0;$i<$maxAmount1;$i++) {
            //get current count of baskets
            $sql = "select count(*) as total from basket";
            $result1 = $conn->query($sql);
           if($result1->num_rows >0){
                while($newRow = $result1->fetch_assoc()){
                    // echo "<br>################## productid: " . $newRow['productid'] . " categoryid " . $newRow['categoryid'] . " name " . $newRow['productname'];
                    //   echo "<br> count: ". $newRow['total'];
                    $totalBasket = intval($newRow['total']);  //where to stop
                }
            }
            echo "<br>total basket is: " . $totalBasket;
            if($totalBasket < 5){
                return -1;
            }
              
              
            //$bid = rand(1, $totalBasket);
            $pid = rand(1, $totalProduct);
            $quan = rand(1, 10);
            $sql = "insert into basketitem (basketid, productid, productquantity) values ('$bid', '$pid', '$quan')";        
               
            if ($conn->query($sql) === TRUE) {
                   echo "Basket item $i generated successfully";
            }else{
                 echo "Error generating basket item: " . $conn->error;
            }    

            updateProductCount($pid, $quan);
            
        }     
        
    }


    function assignDeliveryPeople() {
        $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $database = "myDB";
        $conn = new mysqli($servername, $username, $password, $database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "<br>";

        $sqlWaitingOrders = "SELECT * FROM $database.dispatchticket  WHERE ISNULL(dpid)";
        $resultWaitingOrders = mysqli_query($conn, $sqlWaitingOrders);

        if ($resultWaitingOrders) {

            if (mysqli_num_rows($resultWaitingOrders) > 0) {
                echo "Found " . mysqli_num_rows($resultWaitingOrders) . " unassigned dispatch tickets <br>";
                while ($row = mysqli_fetch_assoc($resultWaitingOrders)) {
                    $ticketid = $row["transactionid"];
                    $customeraddress = $row["customeraddress"];
                    echo $ticketid . "\tDPID: " . $row["dpid"] . "<br>";

                    $sql = "SELECT * FROM $database.deliveryperson WHERE curlocation = 'home'";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        echo "Found " . mysqli_num_rows($result) . " free delivery people<br>";
                        $counter = 0;
                        while($counter < 1 && $row2 = mysqli_fetch_assoc($result)) {
                            $counter += 1;
                            $dpid = $row2["dpid"];
                            $sqlTicket = "UPDATE $database.dispatchticket SET dpid = $dpid WHERE transactionid = $ticketid";
                            $resultTicket = mysqli_query($conn, $sqlTicket);

                            if ($resultTicket) {
                                echo "Updated ticket " . $ticketid . " with dpid " . $dpid . "<br>";

                                $sqlDP = "UPDATE $database.deliveryperson SET curlocation = '$customeraddress' WHERE dpid = $dpid";
                                $resultDP = mysqli_query($conn, $sqlDP);

                                if ($resultDP) {
                                    echo "Updated dpid " . $dpid . " with new location " . $customeraddress . "<br>";
                                } else {
                                    echo "FAILED to update DP location!<br>";
                                }
                            } else {
                                echo "Failed to update ticket with dpid!<br>";
                            }
                        }
                    } else {
                        echo "FAILED to find any free delivery people<br>";
                    }
                }
            } else {
                echo "FAILED to find any undelivered or not enroute orders!<br>";
            }
        } else {
            echo "QUERY FAILED to find any undelivered or not enroute orders!<br>";
        }

        
    }


    function deliverOrders() {
        $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $database = "myDB";
        $conn = new mysqli($servername, $username, $password, $database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM $database.deliveryperson WHERE curlocation != 'home'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "There are " . mysqli_num_rows($result) . " people currently delivering orders.<br>";

            while ($row = mysqli_fetch_assoc($result)) {
                $dpid = $row["dpid"];
                $sqlTicket = "SELECT * FROM $database.dispatchticket d, $database.transaction t WHERE d.dpid = $dpid AND d.transactionid = t.transactionid";
                $resultTicket = mysqli_query($conn, $sqlTicket);

                if ($resultTicket) { 
                    if(mysqli_num_rows($resultTicket) > 0) {
                        while ($row = mysqli_fetch_assoc($resultTicket)) {
                            $tid = $row["transactionid"];
                            $arrivalTime = $row["estimatetimeofarrival"];
                            echo "Estimated arrival: " . $arrivalTime . "<br>";

                            $date = date("Y-m-d H:i:s", time());

                            if ($date >= $arrivalTime) {
                                echo "ARRIVAL TIME PASSED<br>";
                                $sqlDelivered = "UPDATE $database.transaction SET deliverydate = '$date' WHERE transactionid = $tid";
                                $resultDelivered = mysqli_query($conn, $sqlDelivered);

                                if ($resultDelivered) {
                                    echo "SUCCESS updating transaction deliverydate<br>";
                                    $sqlDPDelivered = "UPDATE $database.deliveryperson SET curlocation = 'home' WHERE dpid = $dpid";
                                    $resultDPDelivered = mysqli_query($conn, $sqlDPDelivered);

                                    if ($resultDPDelivered) {
                                        echo "SUCCESS updating dp location<br>";
                                    } else {
                                        echo "FAILURE updating dp location!<br>";
                                    }
                                } else {
                                    echo "FAILURE updating transaction deliverydate!<br>";
                                }                                

                            } else {
                                echo "Still delivering...<br>";
                            }
                        }
                    }
                } else {
                    echo "FAILED to find dispatch ticket/transaction<br>";
                }
            }
        } else {
            echo "NO delivering delivery people found!<br>";
        }
        echo "<br>";
    }


    function checkStandingOrders() {
        $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $database = "mydb";
        $conn = new mysqli($servername, $username, $password, $database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM $database.basket b, $database.customer c WHERE b.isstandingorder = 1 AND b.haltstandingorder = 0 AND b.customerid = c.customerid";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $bid = $row["basketid"];
                $type = $row["standingordertype"];
                $custAddress = $row["address"];
                $date = date("Y-m-d H:i:s");
                $sqlLastDate = "SELECT * FROM $database.transaction WHERE basketid = $bid ORDER BY ordertime";
                $resultLastDate = mysqli_query($conn, $sqlLastDate);
                $lastDate = NULL;
                $needsOrder = false;
                $transid = NULL;

                if ($resultLastDate) {
                    if (mysqli_num_rows($resultLastDate) > 0) {
                        while ($row = mysqli_fetch_assoc($resultLastDate)) {
                            $transid = $row["transactionid"];
                            $lastDate = $row["ordertime"];
                        }
                        echo "Last order date for basket " . $bid . ": " . $lastDate . "\t";
                        if ($type == "Daily") {
                            $nextOrderTime = date("Y-m-d H:i:s", strtotime($lastDate . " +1 days"));
                            echo "Next Daily Order Time: " . $nextOrderTime . "\t";
                            if (strtotime($nextOrderTime) <= strtotime($date)) {
                                echo "TIME TO RE-ORDER!";
                                $needsOrder = true;
                            }
                        } else if ($type == "Weekly") {
                            $nextOrderTime = date("Y-m-d H:i:s", strtotime($lastDate . " +7 days"));
                            echo "Next Weekly Order Time: " . $nextOrderTime . "\t";
                            if (strtotime($nextOrderTime) <= strtotime($date)) {
                                echo "TIME TO RE-ORDER!";
                                $needsOrder = true;
                            }
                        } else if ($type == "Monthly") {
                            $nextOrderTime = date("Y-m-d H:i:s", strtotime($lastDate . " +1 months"));
                            echo "Next Monthly Order Time: " . $nextOrderTime . "\t";
                            if (strtotime($nextOrderTime) <= strtotime($date)) {
                                echo "TIME TO RE-ORDER!";
                                $needsOrder = true;
                            }
                        } else {
                            echo "INVALID STANDING ORDER TYPE";
                        }
                        echo "<br>";

                        if ($needsOrder) {
                            /* FIND DELIVERY TIME AND DISTANCE */
                            $url = 'http://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=Computer+Science+Instructional+Center&';
                            $url = $url . 'destinations=' . urlencode($custAddress);
                            //echo "URL: " . $url . "<br>";
                            $data = file_get_contents($url);

                            if(!$data) echo "FAILED DISTANCE!!!!<br>";
                            //echo $data . "<br>";

                            $data = json_decode($data);
                            
                            $time = 0;
                            $distance = 0;
                            foreach($data->rows[0]->elements as $road) {
                                $time += $road->duration->value;
                                $distance += $road->distance->value;
                            }
                            $timeofarrival = date("Y-m-d H:i:s", time() + $time);
                            echo "TOA: " . $timeofarrival . "TransID: " . $transid . "\n";

                            $cid = NULL;
                            $transactiontotal = NULL;
                            $sqlTest = "SELECT * FROM $database.transaction WHERE transactionid = $transid";
                            $resultTest = mysqli_query($conn, $sqlTest);
                            if($resultTest) {
                                if (mysqli_num_rows($resultTest) > 0) {
                                    while ($row = mysqli_fetch_assoc($resultTest)) {
                                        $cid = $row["customerid"];
                                        $transactiontotal = $row["transactiontotal"];
                                        echo "CID: " . $cid;
                                    }
                                } else {
                                    echo "NO RESULTS";
                                }
                            } else {
                                echo "FAIL :(";
                            }

                            $deliverycharge = NULL;
                            $totalitemcost = NULL;
                            $costwithtax = NULL;
                            $sqlTest = "SELECT * FROM bill WHERE transactionid = $transid";
                            $resultTest = mysqli_query($conn, $sqlTest);
                            if($resultTest) {
                                if (mysqli_num_rows($resultTest) > 0) {
                                    while ($row = mysqli_fetch_assoc($resultTest)) {
                                        $deliverycharge = $row["deliverycharge"];
                                        $totalitemcost = $row["totalitemcost"];
                                        $costwithtax = $row["costwithtax"];
                                    }
                                } else {
                                    echo "NO RESULTS";
                                }
                            } else {
                                echo "FAIL :(";
                            }
                         
                            $sqlTrans = "INSERT INTO $database.transaction VALUES (NULL, $bid, $cid, $transactiontotal, 1, '$date', '$timeofarrival', NULL)";
                            $resultTrans = mysqli_query($conn, $sqlTrans);

                            if ($resultTrans) {
                                echo "NEW transaction inserted<br>";

                                $newTID = NULL;
                                $sqlTest = "SELECT LAST_INSERT_ID() as transactionid";
                                $resultTest = mysqli_query($conn, $sqlTest);
                                if($resultTest) {
                                    if (mysqli_num_rows($resultTest) > 0) {
                                        while ($row = mysqli_fetch_assoc($resultTest)) {
                                            $newTID = $row["transactionid"];
                                            echo "New TransID: " . $newTID . "\t";
                                        }
                                    } else {
                                        echo "NO RESULTS";
                                    }
                                } else {
                                    echo "FAIL :(";
                                }

                                $sqlBill = "INSERT INTO bill VALUES (NULL, LAST_INSERT_ID(), $totalitemcost, $costwithtax, $deliverycharge, NULL, 1)";
                                $resultBill = mysqli_query($conn, $sqlBill);

                                if (!$resultBill) {
                                    echo "Insertion of bill failed!<br>";
                                } else {
                                    echo "Bill insertion success!<br>";

                                    $sqlDispatch = "INSERT INTO dispatchticket VALUES ($newTID, $cid, $bid, NULL, '$custAddress', '$date')";
                                    $resultDispatch = mysqli_query($conn, $sqlDispatch);

                                    if (!$resultDispatch) {
                                        echo "Dispatch ticket creation failed!<br>";
                                    } else {
                                        echo "Dispatch ticket creation success!<br>";
                                    }
                                }
                            } else {
                                echo "FAILED transaction<br>";
                            }
                        }
                    } else {
                        //echo "NO transactions found for basket " . $bid . "!<br>";
                    }
                } else {
                    echo "Query failed!<br>";
                }

            }
        } else {
            echo "No Standing Orders<br>";
        }
    }


    
    //if we assume administrator put 1-7 items on sale every week on time, then there will be no need for timer
    function revertItSeven(){
        $servername = "localhost";
        $username = "jchen127";
        $password = "KbZFqBcZCy29b3Lx";
        $dbname = "mydb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        /*
             $startDate = date("Y-m-d H:i:s");
        $newdate = new DateTime($row['beginsaledate']);  //as end date
        
        $addString = "P" . $mDay . "D" . "T" . $mHour . "H";  //formating the substraction
        //echo $subtractString;
        
        $resultDate = $newdate->add(new DateInterval($addString));
        echo "Lower End DateTime: " . $resultDate->format("Y-m-d H:i:s") . "<br>"; //as start date
         */
        //find the items that are on sale
        $sql = "select productname, productid, beginsaledate from product where isonsale = 1";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<br>productname: " . $row['productname'] ." productid: " . $row['productid'] . " beginsaledate: " . $row['beginsaledate'];
                $pid = intval($row['productid']);
                echo "<br> pid is $pid";
                $storedTime = new DateTime($row['beginsaledate']);
                //add the current date and time by 7
                 $newdate = new DateTime($row['beginsaledate']);  //as end date
        
           $addString = "P7D";  //formating the substraction
        //echo $subtractString;
        
               $resultDate = $newdate->add(new DateInterval($addString));
              echo "<br>----------upper End Sale DateTime: " . $resultDate->format("Y-m-d H:i:s") . "<br>"; //as start date
                
                
                //get current time
                $startDate = new DateTime(date("Y-m-d H:i:s")); //current date and time
                
                //if the current date is greater than the sumdate, then the onsale item needs to be reverted
                if($startDate > $resultDate ){
                    echo "<br>##onsale expired, thus reverting";
                    
                    
                    $sql = "update product set isonsale= '0' where productid = '$pid'";
                     if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
                    
                    
                }else{
                    echo "<br>##Still sometime left before this product is reverted back";
                }
                
            }
        }
        
        $conn->close();
    }
   //function for creating the database and populating the products
    function estabConnect(){
        
        
        header( 'Content-type: text/html; charset=utf-8' );
        //main
        /**/createDatabase();  //temporarily offline  THIS IS THE RIGHT CODE
        createTables();    //temporarily offline  THIS IS THE RIGHT CODE
 
        generateCustomer(50); //temporarily offline THIS IS THE RIGHT CODE
        
        generateDeliveryGuy(20); //temporarily offline THIS IS THE RIGHT CODE

        scrapeMasterMarkK();  //temporarily offline until other database items are generated  THIS IS THE RIGHT CODE
        
        generateBasket();  //this generates basket and basket items
      
    
        
        
        

    }
    
    //estabConnect(); //start the scraper
?>
