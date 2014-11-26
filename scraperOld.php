<?php
   // $homepage = file_get_contents('http://www.harrisfarm.com.au/');
    
    //echo htmlspecialchars($homepage);
    function createDatabase(){
        $servername = "localhost";
        //$username = "jchen127";
        //$password = "KbZFqBcZCy29b3Lx";
        //$dbname = "mydb";
        $username = "jsamelson";
        $password = "database";
        $dbname = "GroceryDelivery";
        
        $conn = new mysqli($servername, $username, $password);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "CREATE DATABASE if not exists GroceryDelivery";
        if ($conn->query($sql) === TRUE) {
              echo "Database created successfully";
        } else{
            echo "query error";
        }
        
      
        
        $conn->close();    
    }
    function createTables(){
        $servername = "localhost";
        //$username = "jchen127";
        //$password = "KbZFqBcZCy29b3Lx";
        //$dbname = "mydb";
        $username = "jsamelson";
        $password = "database";
        $dbname = "GroceryDelivery";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //create category
         $createProductCategory="create table productcategory(
        categoryid int(10) UNSIGNED AUTO_INCREMENT,
        category varchar(40) NOT NULL,
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
         ccexpiration date,
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
   
    }
    
    function queryCreate($conn, $query, $name){
        if ($conn->query($query) === TRUE) {
         echo "Table $name created successfully\n";
        }else{
            echo "Table $name not created successfully\n";
        }    
    }
    
    function estabConnect(){
        createDatabase();
        createTables();
        
    }
    
    estabConnect();
    
    //creating product category
    
        
?>