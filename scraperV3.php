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
    
    
    //function for creating the database and populating the products
    function estabConnect(){
        //main
        createDatabase();
        createTables();
        generateTest();
        //populate database
        scrapeMasterMarkK();
        
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
    //generates best and worst report
    function populateBestWorstReport(){
        //get the current
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
        
        $curworstnum = 100000; //default is -1 so it can be receptive to every other numbers
        $worstArray = array();  //array that contains the names of the worst selling item
        
        $curbestnum = -1;
        $bestArray = array();
        $iterStop = 11;
        $iterNow = 1;
        //sql command for getting the product id, name and sold count
        $sqlcommand = "select distinct productid, soldcount, productname from product";
         $result = $conn->query($sqlcommand);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            
                
                //echo "<br> pid: ". $row["productid"]. " - soldcount: ". $row["soldcount"] . "<br>";
                //intval($row["soldcount"]) // sold count, type int
                //$row['productid']  // type string
                //$row['productname'] // type string
                
               // echo "product name: " . $row['productname'] . " productid: " . $row['productid'] . "sold count: " . $row["soldcount"] . "<br>";
                $tempVal = $curworstnum;  //store the current worst number
                    
                if($curworstnum > intval($row["soldcount"])){
                 //   echo "<br>soldcount" . intval($row["soldcount"]) . " ";
                    $curworstnum = intval($row["soldcount"]); // current worst number if now the  intval number
                   // echo "worstnum now:  " . $curworstnum . "<br>";
                    //discard the curworst array accumulated so far
                    $worstArray = array();
                    
                    //put the recent name into the curworst array
                    array_push($worstArray, $row['productname']);
                    
                }else if($curworstnum == intval($row["soldcount"])){
                    array_push($worstArray, $row['productname']);
                }
                
                if($curbestnum < intval($row["soldcount"]) ){
                    //curbestnum is lesser than the cur num, thus replace
                    $curbestnum = intval($row["soldcount"]);
                    
                    //clear the curbest num array
                    $bestArray = array();
                    array_push($bestArray, $row["productname"]);
                }else if($curbestnum == intval($row["soldcount"])){
                    array_push($bestArray, $row["productname"]);
                    
                }
                
                
                
                //stop pre-emptively for my case because i want it to stop and not going forever
                /*$iterNow +=1;
                if($iterStop == $iterNow){
                    break;
                }*/
                
            }
           
            //this cannot be allowed, if the best num and the worst num are the same, then
            //worstarray are erased.
            if($curbestnum = $curworstnum){
                $worstArray = array();
            }
            
            echo "<h2>The Following Are The Best Selling and the Worst Selling Items: </h2>";
             echo "<br>Worst Selling:";
             for($x = 0; $x< count($worstArray); $x++){
                
                echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;" . $worstArray[$x] . " ";
             }
             echo "<br>Best Selling";
             for($x = 0; $x < count($bestArray); $x++){
                 echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;" . $bestArray[$x] . " ";
             }
           
          }
        
        
        
        
        $conn->close();
        
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
   if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<br> BasketId: ". $row["basketid"]. " Basket Date: ". $row["basketdate"]. "<br>";
         
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
                        echo "<br>-------- PID: " . $prow["productid"] . " Product Name: " . $prow["productname"] . " Price: " . $prow["price"]. " Product Quantity: " . $brow["productquantity"]."<br>";
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
    
    //mark delinquent customer if they didn't make payment in 30 days
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
                    $sqlCommand = "update customer set status='delinq' where customerid='$cid'";
                    
                    
                }else if(intval($diffdate) > 30 && intval($diffdate) <= 60 &&  $curBalance > 0){
                    //late
                   // echo "late";
                     $sqlCommand = "update customer set status='late' where customerid='$cid'";
                    
                }else{
                    //ontime
                    $sqlCommand = "update customer set status='ontime' where customerid='$cid'";
                    
                }
                //execute the command
                if ($conn->query($sqlCommand) !== TRUE) {
             
            echo "Error updating record: " . $conn->error;
         }
                
                
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
    //find highest subtype of product this customer buy most often
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
        return intval($retId);
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
    
?>