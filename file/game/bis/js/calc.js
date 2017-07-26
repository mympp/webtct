/**
 * Created by hetc on 2017/3/21.
 */
function showResult(){
    var num = 0;
    $.each($(".item-require"),function(){
        if($(this).val() == ""){
            $.toast("请输入金额");
            return false;
        }else{
            num++;
        }
    });
    if(num > 2 ){
        $(".result").show();
    }
}
function changeName(){
    var jxs = $("#jxs").val();
    var scs = $("#scs").val();
    var pts = $("#pts").val();
    if( $("#jxs").val() =="" ){
        $("#jxs").focus();
        alert("请填写经销商名字");
        return false;
    }
    if( $("#scs").val() =="" ){
        $("#scs").focus();
        alert("请填写生产商名字");
        return false;
    }
    if( $("#pts").val() =="" ){
        $("#pts").focus();
        alert("请填写平台商名字");
        return false;
    }
    $(".cl-wrap .jxs").html(jxs);
    $(".cl-wrap .scs").html(scs);
    $(".cl-wrap .pts").html(pts);
    $(".user-info").hide();
    $(".cl-wrap").fadeIn();
}

//
function cashCalc(){
    if( $("#cashShow").val() =="" ){
        $("#cashShow").focus();
        alert("请填写提现金额");
        return false;
    }else{
        $("#cashNum").val($("#cashShow").val());
        cash();
        $(".user-info").hide();
        $(".cl-wrap").fadeIn();
        console.log("aaa");
        $('.buttons-tab-3').click();
    }
}

// 输入类型提示
function isNum(ele){
    if(!isNaN($(ele).val())){
        $(".tip").html("");
        $(".tip").hide();
    }else{
        $(".tip").html("请您输入数字");
        $(".tip").show();
    }
}
//风控提示
function risk(){
    var dSell = $("#distributorSell").val();
    var mSell = $("#midSell").val();
    if( mSell/1.15 > dSell ){
        $(".tip").html("请注意，低于成交价的1.15");
        $(".tip").show();
    }else{
        $(".tip").html("");
        $(".tip").hide();
    }
}
function riskB(){
    var dSell = $("#producerSell").val();
    var mSell = $("#sellerSell").val();
    if( mSell/1.15 > dSell ){
        $(".tip").html("请注意，低于成交价的1.15");
        $(".tip").show();
    }else{
        $(".tip").html("");
        $(".tip").hide();
    }
}
/***
 * 方案A：
 * distributorCost 经销商采购价
 * distributorSell 经销商售价
 * distributorProfit 经销商利润
 * midSell 中间商售价
 * midProfit 中间商利润
 * midMan 中间商管理费
 * midInterest 利息
 */
function calc(){
    var distributorCost   = $("#distributorCost").val();
    var distributorSell   = $("#distributorSell").val();
    var distributorProfit = $("#distributorProfit").html();
    var midSell           = $("#midSell").val();
    var midProfit         = $("#midProfit").html();
    // 经销商利润
    if( distributorCost != "" &&  distributorSell != ""){
        $("#distributorProfit").html(distributorSell-distributorCost);
    }
    // 中间商利润
    if( midSell != "" && distributorSell != ""){
        $("#midProfit").html(midSell-distributorSell);
    }
    // 中间商管理费
    if (midSell != ""){
        $("#midMan").html(midSell*0.02);
    }
    if( $("#distributorProfit").html() != 0){
        $("#distributorProfit").next().fadeIn();
    }
    tax();
    statements();
}
//利息费用
function interest(){
    if( $("#distributorCost").val() != ""){
        $(".distributor-cost").html($("#distributorCost").val());
        $("#midInterest").html(parseFloat($("#distributorCost").val()*$("#midInterestPercent").val()*$("#midInterestMouth").val()).toFixed(2));
        $(".interest-a-count").html($("#midInterest").html());
        statements();
    }
}
// 增值部分国家扣税
function tax(){
    if( $("#midSell").val() != "" && $("#distributorSell").val() != ""){
        $(".mid-sell").html($("#midSell").val());
        $(".distributor-sell").html($("#distributorSell").val());
        $("#taxCount").html(parseFloat(($("#midSell").val()-$("#distributorSell").val())*$("#taxPercent").val()).toFixed(2));
        statements();
    }
}
// 中间商结算
function statements(){
    if( $("#midProfit").html() != "" && $("#midMan").html() != 0 && $("#taxCount").html() != 0){
        $(".mid-profit").html($("#midProfit").html());
        $(".mid-man").html($("#midMan").html());
        $(".tax-count").html($("#taxCount").html());
        $("#statements").html($("#midProfit").html()-$("#midMan").html()-$("#taxCount").html()-$(".interest-a-count").html());
    }
}
// 垫资费用
function dzCount(){
    if($("#dzYes").is(":checked")){
        interest();
    }
}
// 是否垫资
$('.label-checkbox-a .item-media').click(function(){
    if($(this).parent().find("input").val() == "yes"){
        $("#dzBox").show();
        interest();
        $(".interest-a-count").html($("#midInterest").html());
        $(".interestA").show();
    }else{
        console.log("aa");
        $("#dzBox").hide();
        $(".interestA").hide();
        $(".interest-a-count").html(0);
    }
    statements();
});

/***
 * 方案B：
 * producerCost 生产商底价
 * producerCostSell 生产商售价
 * sellerSell 卖家售价
 * sellerProfit 卖家利润
 */
function calcB(){
    var producerCost  = $("#producerCost").val();
    var producerSell  = $("#producerSell").val();
    var sellerSell    = $("#sellerSell").val();
    // 卖家利润
    if(sellerSell != "" && producerSell != ""){
        $("#sellerProfit").html(sellerSell-producerSell);
    }
    // 卖家管理费
    if(sellerSell != ""){
        $("#sellerMan").html(sellerSell*0.02);
    }
    // 生产商结算
    if(producerCost !="" && producerSell != ""){
        $(".producer-sell").html($("#producerSell").val());
        $(".producer-cost").html($("#producerCost").val());
        $("#producerToDistributor").html($("#producerSell").val()-$("#producerCost").val());
    }

    if( $("#sellerProfit").html() != 0){
        $("#sellerProfit").next().fadeIn();
    }
    taxB();
    statementsB();
}
//利息费用
function interestB(){
    if( $("#producerCost").val() != ""){
        $(".producer-cost").html($("#producerCost").val());
        $("#sellerInterest").html(parseFloat($("#producerCost").val()*$("#sellerInterestPercent").val()*$("#sellerInterestMouth").val()).toFixed(2));
        $(".interest-b-count").html($("#sellerInterest").html());
        statementsB();
    }
}
function taxB(){
    if( $("#producerSell").val() != "" && $("#sellerSell").val() != ""){
        $(".producer-sell").html($("#producerSell").val());
        $(".seller-sell").html($("#sellerSell").val());
        $("#taxCountB").html(parseFloat(($("#sellerSell").val()-$("#producerSell").val())*$("#taxPercentB").val()).toFixed(2));
        statementsB();
    }
}
function statementsB(){
    if( $("#sellerProfit").html() != "" && $("#sellerMan").html() != 0 && $("#taxCountB").html() != 0){
        $(".seller-profit").html($("#sellerProfit").html());
        $(".seller-man").html($("#sellerMan").html());
        $(".tax-count-b").html($("#taxCountB").html());
        $("#sellerToDistributor").html(parseFloat($("#sellerProfit").html()-$("#sellerMan").html()-$("#taxCountB").html()-$(".interest-b-count").html()).toFixed(2));
    }
}
// 垫资费用
function dzBCount(){
    if($("#dzBYes").is(":checked")){
        interestB();
    }
}
// 是否垫资
$('.label-checkbox-b .item-media').click(function(){
    if($(this).parent().find("input").val() == "yes"){
        $("#dzBBox").show();
        interestB();
        $(".interest-b-count").html($("#sellerInterest").html());
        $(".interestB").show();
    }else{
        $("#dzBBox").hide();
        $(".interestB").hide();
        $(".interest-b-count").html(0);
    }
    statementsB();
});


function mobile(){
    var sUserAgent = navigator.userAgent.toLowerCase();
    var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
    var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
    var bIsMidp = sUserAgent.match(/midp/i) == "midp";
    var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
    var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
    var bIsAndroid = sUserAgent.match(/android/i) == "android";
    var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
    var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
    if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {
//            $(".plan-wrap input[type='text']").each(function () {
//                $(this).attr("type","number")
//            });
    } else {

    }
}
mobile();


/***
 * 业务提现：
 */
function cash(){
    var cashNum =  parseFloat($("#cashNum").val());
    var cashSl  =  parseFloat($("#cashSl").val());
    var cashSx  =  $("#cashSx").val()*0.01 || 0;
    var cashCount = parseFloat($("#cashCount").html()) || 0;
    if(cashNum != ""){
        $("#cashCount").html(parseFloat(cashNum/(1-(cashSl+cashSx))).toFixed(2));
        $(".cash-num").html(cashNum);
        $(".cash-sx").html(parseFloat($("#cashCount").html()*cashSx).toFixed(2));
        $(".cash-sl").html(parseFloat($("#cashCount").html()*cashSl).toFixed(2));
    }
}
//$('[data-toggle="tooltip"]').tooltip();

//利润金额直接提现
function flowCash(ele){
    var cashNum = $(ele).prev().html();
    $("#cashNum").val(cashNum);
    cash();
    $('.buttons-tab-3').click();
    //$('.nav-tabs li:eq(2) a').tab('show');
}