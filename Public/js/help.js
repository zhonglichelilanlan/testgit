

/*打开更多帮助信息*/
function openes(id){
document.getElementById("open"+id).style.display="none";
document.getElementById("clos"+id).style.display="block";	
var a=document.getElementById("tr"+id).style.display;
if(a=='none'){
document.getElementById("tr"+id).style.display="block";
}
else{
	document.getElementById("tr"+id).style.display="none";
	}
}


/*收起帮助信息*/
function closed(id){
document.getElementById("open"+id).style.display="block";
document.getElementById("clos"+id).style.display="none";
var b=document.getElementById("tr"+id).style.display;
if(b=='none'){
document.getElementById("tr"+id).style.display="block";
}
else{
	document.getElementById("tr"+id).style.display="none";
	}
}
