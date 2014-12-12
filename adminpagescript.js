
$(document).ready(function(){
  //below are reports, they are unordered list not orderedlist, i made a last min change of mind
   var legend = "<legend>Administrator Reports</legend>";
  var BWSIR = "<br><li><a href='bwreport.php' target='ActionFrame'>best and worst selling item</a></li><br>";
  var ABVR = "<li><a href='averageBasketValueReport.php' target='ActionFrame'>average basket value report</a></li><br>";
  var CR = "<li><a href='customerreport.php' target='ActionFrame'>customer report </a></li><br>";
  var DR = "<li><a href='delinquentreport.php' target='ActionFrame'>delinquency report </a></li><br>";
  var SPR = "<li><a href='suggestProductReport.php' target='ActionFrame'>suggested product report</a></li><br>";
  //var VOR = "<li><a href='http://www.google.com' target='ActionFrame'>view order report <b>X</b></a></li><br>";
  //var PSR = "<li><a href='http://www.google.com' target='ActionFrame'>product search report <b>X</b></a></li><br>";
  //var BR = "<li><a href='http://www.google.com' target='ActionFrame'>balance report <b>X</b></a></li><br>";
  //var THR = "<li><a href='http://www.google.com' target='ActionFrame'>transaction history report <b>X</b></a></li><br>";
  $("body").css({"background-color":"#D3BDA7"});
  
  $("#olreport").append(legend, BWSIR, ABVR,CR,DR, SPR);
 
 // below are quests, they are unordered list not ordered list, i made a last min change of mind
 
 var requestLegend = "<legend>Administrator Request</legend>";
 //var RCRQ = "<br><li><a href='http://www.google.com' target='ActionFrame'>remove customer request <b>X</b></a></li><br>";
 var DRCRQ = "<li><a href='toggleActivateCustomer.php' target='ActionFrame'>reactivate or deactivate customer request</a></li><br>";
 var ARPRQ = "<li><a href='addRemoveProduct.php' target='ActionFrame'>add or remove or modify product request </a></li><br>";
 var POSRQ = "<li><a href='placeOnSale.php' target='ActionFrame'>place on sale request </a></li><br>";
 var UDPRQ = "<li><a href='updateDeliveryPerson.php' target='ActionFrame'>update delivery person request </a></li><br>";
 //var CRPQ = "<li><a href='http://www.google.com' target='ActionFrame'>create report request <b>X</b></a></li><br>";
 //var RCRQ = "<li><a href='http://www.google.com' target='ActionFrame'>register customer request <b>X</b></a></li><br>";
 //var UCPRQ = "<li><a href='http://www.google.com' target='ActionFrame'>update customer profile request <b>X</b></a></li><br>";
 //var HORQ = "<li><a href='http://www.google.com' target='ActionFrame'>hold order request <b>X</b></a></li><br>";
 //var ABRQ = "<li><a href='http://www.google.com' target='ActionFrame'>add to basket request <b>X</b></a></li><br>";
 //var MPRQ = "<li><a href='http://www.google.com' target='ActionFrame'>make payment request <b>X</b></a></li><br>";
 //var PORQ = "<li><a href='http://www.google.com' target='ActionFrame'>place order request <b>X</b></a></li><br>";
 //var VORQ = "<li><a href='http://www.google.com' target='ActionFrame'>view order request <b>X</b></a></li><br>";
 //var PSRQ = "<li><a href='http://www.google.com' target='ActionFrame'>product search request <b>X</b></a></li><br>";
 //var BRQ = "<li><a href='http://www.google.com' target='ActionFrame'>balance request <b>X</b></a></li><br>";
 //var THRQ = "<li><a href='http://www.google.com' target='ActionFrame'>transaction history request <b>X</b></a></li><br>";
 
 $("#olrequest").append(requestLegend, DRCRQ, ARPRQ, POSRQ, UDPRQ);
  
  
  //setting up the layout
  var screenwidth = screen.width-40;
  var screenheight = screen.height-40;
  var reportMountTop = "40px";
  var reportMountLeft = "40px";
  var reportHeight = (screenheight-300).toString()+"px";
  var reportWidth = (screenwidth/6).toString()+"px";
  $("#Reports").css({"top": "40px", "left":"40px", "height": reportHeight, "width": reportWidth, "background-color":"red", "z-index":"1", "position":"absolute" ,"borderRadius":"25px", "border":"solid", "opacity": "0.5", "overflow":"auto"});
  var requestMountLeft = (50+(screenwidth/6)).toString()+"px";
  var requestMountTop = "40px";
  
  $("#Requests").css({"top": "40px", "left": requestMountLeft, "height": reportHeight, "width": reportWidth, "background-color":"pink", "z-index":"1", "position":"absolute" ,"borderRadius":"25px", "border":"solid", "opacity": "0.5", "overflow":"auto"});
  
   var displayMountLeft = (80+(screenwidth/3)).toString()+"px";
  var displayWidth = (screenwidth/2);
  
  $("#displayContent").css({"top": "40px", "left": displayMountLeft, "height": reportHeight, "width": displayWidth, "background-color":"grey", "z-index":"1", "position":"absolute" ,"borderRadius":"25px", "border":"solid", "opacity": "0.5", "overflow":"auto"});
  var curActionTop = (screenheight-245).toString()+"px";
  var curActionLeft = "40px";
  $("#CurrentAction").css({"top": curActionTop, "left": curActionLeft, "height": "100px", "width": displayWidth, "background-color":"#009933", "z-index":"1", "position":"absolute" ,"borderRadius":"25px", "border":"solid", "opacity": "0.5", "overflow":"auto"});
  


});

