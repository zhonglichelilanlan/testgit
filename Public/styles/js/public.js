$(function () {

    /**导航hover开始**/
    //$(".header_ .header_w ul li").hover(function(){
    //    var in_=$(this).index();
    //    $(".header_ .header_w ul li").removeClass("al_0")
    //    $(".header_ .header_w ul li").removeClass("al_1")
    //    $(".header_ .header_w ul li").removeClass("al_2")
    //    $(".header_ .header_w ul li").removeClass("al_3")
    //    $(this).addClass("al_"+in_);
    //
    //})
    /**导航hover结束**/
    /**header 头像悬浮开始**/
    $(".header_ .header_r .div_ .tx_1").hover(function(){
        $(this).find(".hover_").show();
    },function(){
        $(this).find(".hover_").hide();
    })
    /**header头像悬浮结束**/
    /**新增成员选择角色开始**/
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
    })

    /**新增成员选择角色结束**/
    /**角色管理开始**/
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
    /**角色管理结束**/
    /**系统提示弹框开始**/
    $(".delete_").click(function(){
        $(".tmc_1").show();
        $(".tk_1").show();
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
    /**系统提示弹框结束**/
    /**权限管理选择开始**/
    $(".ul_1 li").click(function(){
             $(".ul_1 li").removeClass("bag_1")
            $(this).addClass("bag_1")

    })
    $(".ul_1 li").click(function(){
        $(".ul_1 li").removeClass("bag_1")
        $(this).addClass("bag_1")

    })
    $(".bghzj_629 .div_c .div_select div img").hover(function(){

        $(this).attr("src","styles/img/lanxiaojia.png")
    },function(){
        $(this).attr("src","styles/img/xiaojia.png")
    });

    $(".header_ .header_w .header_l ul .a_7").hover(function(){

        $(this).find(".id_div").show();
    },function(){
        $(this).find(".id_div").hide();
    });
    /**权限管理选择结束**/

})
function click_(tt){

    var val_=$(tt).parent().find("input").val();
    $(".jiben_xx").append(
        '<div class="class_gg div_class" onmouseout="hover_1(this)" onmouseover="hover_2(this)">'+

            '<div class="u_629"> '+val_+'</div>'+
            '<div class="delect_" >'+
                 '<img src="styles/img/sc.png" onclick="hover_3(this)">'+
            '</div>'+
        ' </div>'
    );
    $(tt).parent().find("input").val("");

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

