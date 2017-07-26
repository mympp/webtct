function onload(){
    var vieType = localStorage.getItem("vieType");
    if (vieType!=null && vieType!=""){
        if(vieType == "list"){
            $(".post-card-list").removeClass("post-card-list-img");
            $(".post-show-switch>a").removeClass("current");
            $("#listSwitch").addClass("current");
        }
        else if(vieType == "card"){
            $(".post-card-list").addClass("post-card-list-img");
            $(".post-show-switch>a").removeClass("current");
            $("#cardSwitch").addClass("current");
        }
    }
}
onload();

$('#listSwitch').click(function(){
    localStorage.setItem("vieType","list");
    $(".post-card-list").removeClass("post-card-list-img");
    $(".post-show-switch>a").removeClass("current");
    $(this).addClass("current");
});
$('#cardSwitch').click(function(){
    localStorage.setItem("vieType","card");
    $(".post-card-list").addClass("post-card-list-img");
    $(".post-show-switch>a").removeClass("current");
    $(this).addClass("current");
});



