
/**js上传图片开始**/
function setImagePreview() {
    var docObj=document.getElementById("doc");

    var imgObjPreview=document.getElementById("preview");
    if(docObj.files &&    docObj.files[0]){

        imgObjPreview.style.display = 'block';
        imgObjPreview.style.width = '300px';
        imgObjPreview.style.height = '120px';
        //imgObjPreview.src = docObj.files[0].getAsDataURL();


        imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);

    }else{

        docObj.select();
        var imgSrc = document.selection.createRange().text;
        var localImagId = document.getElementById("localImag");

        localImagId.style.width = "300px";
        localImagId.style.height = "120px";

        try{
            localImagId.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
            localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
        }catch(e){
            alert("您上传的图片格式不正确，请重新选择!");
            return false;
        }
        imgObjPreview.style.display = 'none';
        document.selection.empty();
    }
    return true;
}
/**js上传图片结束**/

$(function () {
    $(" .class_ .thi_").click(function(){
        var aa=$(this).find("input").val();
        if(aa==0){
            $(this).addClass("wancheng_w")
            $(this).find("input").val("1");
        }else{
            $(this).removeClass("wancheng_w")
            $(this).find("input").val("0");
        }
    })
      $(".date_picker").change(function(){
        $(this).addClass("up_1");
        $(this).parent().parent("div").find(".span_1").addClass("span_1_");
    });

    /**µ¼º½hover¿ªÊ¼**/
    //$(".header_ .header_w ul li").hover(function(){
    //    var in_=$(this).index();
    //    $(".header_ .header_w ul li").removeClass("al_0")
    //    $(".header_ .header_w ul li").removeClass("al_1")
    //    $(".header_ .header_w ul li").removeClass("al_2")
    //    $(".header_ .header_w ul li").removeClass("al_3")
    //    $(this).addClass("al_"+in_);
    //
    //})
    /**µ¼º½hover½áÊø**/
    /**header Í·ÏñÐü¸¡¿ªÊ¼**/
    $(".header_ .header_r .div_ .tx_1").hover(function(){
        $(this).find(".hover_").show();
    },function(){
        $(this).find(".hover_").hide();
    })
    /**headerÍ·ÏñÐü¸¡½áÊø**/
    /**ÐÂÔö³ÉÔ±Ñ¡Ôñ½ÇÉ«¿ªÊ¼**/
    $(".bt_in .select_").click(function(){
        var he_= $(this).next(".click_").height();
        var val_=$(this).find("#input_").val();
        if(val_==0){
            $(this).next(".click_").show();
            $(this).find("#input_").val("1");
        }else{
            $(this).next(".click_").hide();
            $(this).find("#input_").val("0");
        }
        if(he_>=210){
            $(this).next(".click_").css("height","210px");
        }else{
            $(this).next(".click_").css("height","auto");
        }



    })
    $(".bt_in .click_ div").click(function(){

        $(".bt_in .select_ .select_l").text($(this).text());
        $(this).parent(".click_").hide();
        $("#input_").val("0");
        var id_=$(this).attr("id");//获取当前点击的ID
        $(".select_l").attr("id",+id_)//为class为select_l添加获取的id
    })

    /**ÐÂÔö³ÉÔ±Ñ¡Ôñ½ÇÉ«½áÊø**/

    /**½ÇÉ«¹ÜÀí¿ªÊ¼**/
    $(".ul_1 .li_").click(function(){
        
        var aa=$(this).find("input").val();
        if(aa==0){
            $(this).find("a").addClass("xuanze_")
            $(this).find("input").val("1");
        }else{
            $(this).find("a").removeClass("xuanze_")
            $(this).find("input").val("0");
        }
       
           
    });
    $(".ul_2 .li_").click(function(){

       var aa=$(this).find("input").val();
        if(aa==0){
            $(this).find("a").addClass("xuanze_")
            $(this).find("input").val("1");
        }else{
            $(this).find("a").removeClass("xuanze_")
            $(this).find("input").val("0");
        }
 var val_22= $(".xuanze_").size();
           

           $("#size_22").val(val_22);
    });
    $("#bag_1_").click(function(){

        var aa=$(this).find("input").val();
        if(aa==0){
            $(this).find("a").removeClass("a_j")

            $(this).find("input").val("1");
            $(this).nextAll("li").show();
        }else{
            $(this).nextAll("li").hide();
            $(this).find("a").addClass("a_j")
            $(this).find("input").val("0");
        }

    });
    $("#bag_1_2").click(function(){

        var aa=$(this).find("input").val();
        if(aa==0){
            $(this).find("a").removeClass("a_j")

            $(this).find("input").val("1");
            $(this).nextAll("li").show();
        }else{
            $(this).nextAll("li").hide();
            $(this).find("a").addClass("a_j")
            $(this).find("input").val("0");
        }

    });
    /**½ÇÉ«¹ÜÀí½áÊø**/
    /**ÏµÍ³ÌáÊ¾µ¯¿ò¿ªÊ¼**/
    $(".delete_").click(function(){
        $(".tmc_1").show();
        $(".tk_1").show();
        var id=$(this).attr("de_id")
        // alert(id);
        $("#delete_").val(id)
    })
    $(".tmc_1").click(function(){
        $(".tmc_1").hide();
        $(".tk_1").hide();
        $(".tk_2").hide();
    })

    $(".quxiao_").click(function(){
        $(".tmc_1").hide();
        $(".tk_1").hide();
        $(".tk_2").hide();
    })
    
    $(".queren_on").click(function(){
        $(".tmc_1").hide();
        $(".tk_1").hide();
        $(".tk_2").hide();
    })
    /**ÏµÍ³ÌáÊ¾µ¯¿ò½áÊø**/
    /**È¨ÏÞ¹ÜÀíÑ¡Ôñ¿ªÊ¼**/
    
    $(".bghzj_629 .div_c .div_select div img").hover(function(){

        $(this).attr("src","/Public/images/lanxiaojia.png")
    },function(){
        $(this).attr("src","/Public/images/xiaojia.png")
    });

    $(".header_ .header_w .header_l ul .a_7").hover(function(){

        $(this).find(".id_div").show();
    },function(){
        $(this).find(".id_div").hide();
    });
    /**È¨ÏÞ¹ÜÀíÑ¡Ôñ½áÊø**/

})
var _val='';
function click_(tt){
_val+=_val!=""?",":"";
    var val_=$(tt).parent().find("input").val();
   var value = $.trim(val_);
    if(val_=="" || value==""){

    }else{
            var aaa=_val+=val_
            $("#input_704").val(aaa);
          
                $(".jiben_xx").append(
                    '<div class="class_gg div_class" onmouseout="hover_1(this)" onmouseover="hover_2(this)">'+

                    '<div class="u_629"> '+val_+'</div>'+
                    '<div class="delect_" >'+
                    '<img src="/Public/images/sc.png" onclick="hover_3(this)">'+
                    '</div>'+
                    ' </div>'
                );

                $(tt).parent().find("input").val("");




    }

}

function hover_1(tt){
    $(tt).find(".delect_").hide();
}
function hover_2(tt){
    $(tt).find(".delect_").show();
}
function hover_3(tt){
    $(tt).parent(".delect_").parent(".div_class").remove();
}

