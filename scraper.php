<?php
 
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
            price FLOAT UNSIGNED,
            categoryid INT(10) unsigned,
            isonsale BOOLEAN,
            saleprice FLOAT,
            taxable BOOLEAN,
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
            isstandingorder BOOLEAN,
            haltstandingorder BOOLEAN,
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

    //print_r($typeArr); //printing the filled associative array
    insertProductTypes($typeArr);  //populate the sql database PRODUCTCATEGORY, THIS IS THE RIGHT CODE
    
    //scanProducts('http://www.harrisfarm.com.au/collections/apples'); //only scan one page
    
    
    
       //geting nav content
     //  $patternnav = '/<nav.*<\/nav>/i';
    //   preg_match_all($patternnav, $subject, $navProc);
     //  print_r($navProc);
     
      
    //$subject = 'collections/fridge/Salmon-&-Trout';
     //$pattern = '/[\w-&]*$/i';
    //preg_match_all($pattern, $subject, $collectionss);
      // print_r($collectionss); 
    


    }
    //
    function scanProducts($webAddress){
         $currentAddress = file_get_contents($webAddress);
         
         echo htmlspecialchars($currentAddress);
         /*
           <div class="imgcont loadingimg">
       
            <a href="/collections/asparagus-broccoli-cauliflower/products/asparagus" class="image-inner-wrap ">
				
				
			  <img src="//cdn.shopify.com/s/files/1/0206/9470/products/asparagus_1_093193e3-a081-4e35-93c6-2a2be62730d5_compact.jpeg?v=1409621749" alt="Asparagus (bunch)" />
			 
              <div class="salecontainer">
				<span class="sale">			
					<small>from</small> $1.69
    				
    				
				</span>
			  </div>
            </a>
    </div>
    <p class="title"><a href="/collections/asparagus-broccoli-cauliflower/products/asparagus">Asparagus (bunch)</a></p>
          */   ##pattern on each page
         
         
         
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
        
        //construct query
        //echo "<p>array keys<p>";
       // print_r(array_keys($associativeArrayArray['fruit'][0])); //sub fruit array starts from ['fruit'][0]
       // category varchar(40) NOT NULL,
        //subcategory varchar(40) not null,
        //$insertion = "INSERT INTO productcategory (category, subcategory) values ('sick', 'monster')";
        
        foreach($associativeArrayArray as $x => $x_value) { //grand type
          //construct query string
          foreach($associativeArrayArray[$x][0] as $y => $y_value){ //subtype $y is the key
             $insertion = "INSERT INTO productcategory (category, subcategory) values ('$x', '$y')";
             
            if ($conn->query($insertion) === TRUE) {
             echo "New record created successfully";
             } else {
              echo "Error: " . $insertion . "<br>" . $conn->error;
              echo "<br>";
             }
          }
        
        }
     
     
     //   if ($conn->query($insertion) === TRUE) {
     //echo "New record created successfully";
    //} else {
     // echo "Error: " . $sql . "<br>" . $conn->error;
   // }
        
        
        
        
        
        
        //close the connection
        $conn->close();
    }

    
    function estabConnect(){
        //main
        //createDatabase();
        //createTables();
        //populate database
        scrapeMasterMarkK();
        
    }
    
    estabConnect();
    
    //creating product category
    
        
?>