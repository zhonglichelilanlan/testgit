var target=[] 
var time_id=[] 
function show_date_time_0(){ 
    setTimeout("show_date_time_0()", 1000); 
for (var i=0,j=target.length;i<j;i++){ 
    today=new Date(); 
    timeold=target[i]-today.getTime(); 
    sectimeold=timeold/1000; 
    secondsold=Math.floor(sectimeold); 
    msPerDay=24*60*60*1000; 
    e_daysold=timeold/msPerDay; 
    daysold=Math.floor(e_daysold); 
    e_hrsold=(e_daysold-daysold)*24; 
    hrsold=Math.floor(e_hrsold); 
    e_minsold=(e_hrsold-hrsold)*60; 
    minsold=Math.floor((e_hrsold-hrsold)*60); 
    seconds=Math.floor((e_minsold-minsold)*60); 
    if (daysold<0) { 
        document.getElementById(time_id[i]).innerHTML="抱歉！暂时没有新的项目发布计划！"; 
    }  
    else { 
        if (hrsold<10) {hrsold="0"+hrsold} 
        if (minsold<10) {minsold="0"+minsold} 
        if (seconds<10) {seconds="0"+seconds} 
        document.getElementById(time_id[i]).innerHTML="<b>"+hrsold+"</b>"+"时"+"<b>"+minsold+"</b>"+"分"+"<b>"+seconds+"</b>"+"秒"; 
    } 
} 
} 
setTimeout("show_date_time_0()", 100); 
