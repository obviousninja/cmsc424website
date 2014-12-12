
$(document).ready(function(){
    /*$("#wrapper").css({"width": (screen.width).toString()+"px",
                    "margin-left": "auto",
                    "margin-right": "auto",
                    "position": "relative",
                    "min-height": "99%"});*/

    $("#suggestedproduct").css({"top": ((screen.height-300)/2).toString()+"px",
                    "left": ((screen.width-400)/2).toString()+"px",
                    "background-color":"#EFFAB4",
                    "height":"200px", "width":"400px",
                    "position":"absolute"});

    $("#footer").css({"top": "height": "50px", 
    "position": "absolute", //tells the browser to position #footer relative to #wrapper
    "bottom": "3", //sticks the footer 3px above the bottom edges of the #wrapper div
    "width": "inherit",
    "text-align": "center",
    "background-color": "#FF9F80"});
    
    /*var h = (((screen.height-400)/2)+120).toString()+"px";
    var h2 = (((screen.height-400)/2)+160).toString()+"px";
    var wid = (((screen.width-400)/2)+320).toString() + "px";
    $("#suggestedproduct").css({"height":"20px", "width":"100px", "borderRadius":"10px","border":"groove", "backgroundColor":"#FFFFFF", "top":h, "left":wid, "position":"absolute"});
    /*$("#regbutton").css({"height":"20px", "width":"100px", "borderRadius":"10px","border":"groove", "backgroundColor":"#FFFFFF", "top":h2, "left":wid, "position":"absolute"});
    
    $("#existingcustomerbutton").click(function(){
        document.getElementById("existingcustomerbutton").style.display='none';
        document.getElementById("loginBox").style.display='';
    });

    $("#regbutton").click(function(){
        window.open("createcustomer.html", "_self"); 
    });*/

});