
$(document).ready(function(){
    $("#logo").css({"top": (screen.height).toString()+"px",
                    "left": (screen.width-100/2).toString()+"px",
                    "backgroundColor":"transparent",
                    "height":"130px", "width":"530px",
                    "position":"absolute"});

    $("#loginBox").css({"top": ((screen.height-400)/2).toString()+"px",
                    "left": ((screen.width-400)/2).toString()+"px",
                    "backgroundColor":"transparent",
                    "height":"130px", "width":"400px",
                    "position":"absolute"});
    
    var h = (((screen.height-400)/2)+120).toString()+"px";
    var h2 = (((screen.height-400)/2)+160).toString()+"px";
    var wid = (((screen.width-400)/2)+320).toString() + "px";
    $("#existingcustomerbutton").css({"height":"20px", "width":"100px", "borderRadius":"10px","border":"groove", "backgroundColor":"#FFFFFF", "top":h, "left":wid, "position":"absolute"});
    $("#regbutton").css({"height":"20px", "width":"100px", "borderRadius":"10px","border":"groove", "backgroundColor":"#FFFFFF", "top":h2, "left":wid, "position":"absolute"});
    
    $("#existingcustomerbutton").click(function(){
        document.getElementById("existingcustomerbutton").style.display='none';
        document.getElementById("loginBox").style.display='';
    });

    $("#regbutton").click(function(){
        window.open("createcustomer.html", "_self"); 
    });
});