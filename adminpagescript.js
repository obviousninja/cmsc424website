
$(document).ready(function(){
  //below are reports, they are unordered list not orderedlist, i made a last min change of mind
  var legend = "<legend'>Reports</legend>";
  var BWSIR = "<li><a href='http://www.google.com'>best or worst selling item</a></li>";
  var ABVR = "<li><a href='http://www.google.com'>average basket value report</a></li>";
  var CR = "<li><a href='http://www.google.com'>customer report</a></li>";
  var DR = "<li><a href='http://www.google.com'>delinquency report</a></li>";
  var SPR = "<li><a href='http://www.google.com'>suggested product report</a></li>";
  var VOR = "<li><a href='http://www.google.com'>view order report</a></li>";
  var PSR = "<li><a href='http://www.google.com'>product search report</a></li>";
  var BR = "<li><a href='http://www.google.com'>balance report</a></li>";
  var THR = "<li><a href='http://www.google.com'>transaction history report</a></li>";
  $("body").css({"background-color":"#D3BDA7"});
  
  $("#olreport").append(legend, BWSIR, ABVR,CR,DR, SPR, VOR, PSR, BR, THR);
 
 // below are quests, they are unordered list not ordered list, i made a last min change of mind
 
 $()
  
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

