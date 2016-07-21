$(document).ready(function() {

/*选项卡*/
var $aLi=$(".tabcard p");
$aLi.click(function(){
$(this).addClass("active").siblings().removeClass("active");
var index=$aLi.index(this);
$(".tabmain .tabm1").eq(index).show().siblings(".tabm1").hide();
});


});




//弹窗效果
var EV_MsgBox_ID="";
function EV_modeAlert(msgID){  
var bgObj=document.createElement("div");  
bgObj.setAttribute('id','EV_bgModeAlertDiv');  
document.body.appendChild(bgObj);  
EV_Show_bgDiv();  
EV_MsgBox_ID=msgID;  
EV_Show_msgDiv();  
}  
//关闭对话窗口  
function EV_closeAlert(){  
    var msgObj=document.getElementById(EV_MsgBox_ID);  
    var bgObj=document.getElementById("EV_bgModeAlertDiv");  
    msgObj.style.display="none";  
    document.body.removeChild(bgObj);  
    EV_MsgBox_ID="";  
}  
  
//窗口大小改变时更正显示大小和位置  
window.onresize=function(){  
    if (EV_MsgBox_ID.length>0){  
        EV_Show_bgDiv();  
        EV_Show_msgDiv();  
    }  
}  
//窗口滚动条拖动时更正显示大小和位置  
window.onscroll=function(){  
    if (EV_MsgBox_ID.length>0){  
        EV_Show_bgDiv();  
        EV_Show_msgDiv();  
    }  
}  
//把要显示的div居中显示  
function EV_Show_msgDiv(){  
    var msgObj   = document.getElementById(EV_MsgBox_ID);  
    msgObj.style.display  = "block";  
    var msgWidth = msgObj.scrollWidth;  
    var msgHeight= msgObj.scrollHeight;  
    var bgTop=EV_myScrollTop();  
    var bgLeft=EV_myScrollLeft();  
    var bgWidth=EV_myClientWidth();  
    var bgHeight=EV_myClientHeight();  
    var msgTop=bgTop+Math.round((bgHeight-msgHeight)/2);  
    var msgLeft=bgLeft+Math.round((bgWidth-msgWidth)/2);  
    msgObj.style.position = "absolute";  
    msgObj.style.top      = msgTop+"px";  
    msgObj.style.left     = msgLeft+"px";  
    msgObj.style.zIndex   = "10001";  
}  
//背景框满窗口显示  
function EV_Show_bgDiv(){  
    var bgObj=document.getElementById("EV_bgModeAlertDiv");  
    var bgWidth=EV_myClientWidth();  
    var bgHeight=EV_myClientHeight();  
    var bgTop=EV_myScrollTop();  
    var bgLeft=EV_myScrollLeft();  
    bgObj.style.position   = "absolute";  
    bgObj.style.top        = bgTop+"px";  
    bgObj.style.left       = bgLeft+"px";  
    bgObj.style.width      = bgWidth + "px";  
    bgObj.style.height     = bgHeight + "px";  
    bgObj.style.zIndex     = "10000";  
    bgObj.style.background = "#000";  
    bgObj.style.filter     = "progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=50,finishOpacity=50);";  
    bgObj.style.opacity    = "0.5";  
}  
//网页被卷去的上高度  
function EV_myScrollTop(){  
    var n=window.pageYOffset   
    || document.documentElement.scrollTop   
    || document.body.scrollTop || 0;  
    return n;  
}  
//网页被卷去的左宽度  
function EV_myScrollLeft(){  
    var n=window.pageXOffset   
    || document.documentElement.scrollLeft   
    || document.body.scrollLeft || 0;  
    return n;  
}  
//网页可见区域宽  
function EV_myClientWidth(){  
    var n=document.documentElement.clientWidth   
    || document.body.clientWidth || 0;  
    return n;  
}  
//网页可见区域高  
function EV_myClientHeight(){  
    var n=document.documentElement.clientHeight   
    || document.body.clientHeight || 0;  
    return n;  
} 