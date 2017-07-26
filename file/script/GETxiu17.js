$(document).ready(function(){
    $.ajax({
        url: "http://www.sharedour.com/api/all_message.php?action=num",
        type: 'get',
        dataType: "jsonp",
        jsonp: 'callbacknum',
        timeout: 3000
    }).done(function (num) {
        //document.getElementById('span_num').innerHTML = num;
        console.log(num);
        $("#span_num").append(num);
    }).fail(function () {
    	$(".span_num_link").show();
    });

    $.ajax({
        url: "http://www.sharedour.com/api/all_message.php?action=buy",
        type: 'get',
        dataType: "jsonp",
        jsonp: 'callbackbuy',
        timeout: 3000
    }).done( function (buy) {
        $("#span_buy").append(buy);
        //document.getElementById('span_buy').innerHTML = buy;
    }).fail(function () {
    	$(".span_buy_link").show();
    });;

    $.ajax({
        url: "http://www.sharedour.com/api/all_message.php?action=company",
        type: 'get',
        dataType: "jsonp",
        jsonp: 'callbackcompany',
        timeout: 3000
    }).done( function (company) {
        //document.getElementById('span_company').innerHTML = company;
        $("#span_company").append(company);
    }).fail(function(){
    	$(".span_company_link").show();
    });

    $.ajax({
        url: "http://www.sharedour.com/api/all_message.php?action=product",
        type: 'get',
        dataType: "jsonp",
        jsonp: 'callbackproduct',
        timeout: 3000
    }).done( function (product) {
        //document.getElementById('span_product').innerHTML = product;
        $("#span_product").append(product);
    }).fail(function(){
    	$(".span_product_link").show();
    });

});


function getSpanNum() {
    $(".span_num_link").html("加载中……");
	$.ajax({
        url: "http://www.sharedour.com/api/all_message.php?action=num",
        type: 'get',
        dataType: "jsonp",
        jsonp: 'callbacknum',
        timeout: 3000
    }).done(function (num) {
        $(".span_num_link").hide();
        $("#span_num").append(num);
    }).fail(function () {
    	$(".span_num_link").html("点击显示");
    });
}

function getSpanBuy() {
    $(".span_buy_link").html("加载中……");
	$.ajax({
        url: "http://www.sharedour.com/api/all_message.php?action=buy",
        type: 'get',
        dataType: "jsonp",
        jsonp: 'callbacknum',
        timeout: 3000
    }).done(function (buy) {
        $(".span_buy_link").hide();
        $("#span_buy").append(num);
    }).fail(function () {
    	$(".span_buy_link").html("点击显示");
    });
}

function getSpanCompany(){
    $(".span_company_link").html("加载中……");
	$.ajax({
        url: "http://www.sharedour.com/api/all_message.php?action=company",
        type: 'get',
        dataType: "jsonp",
        jsonp: 'callbackcompany',
        timeout: 3000
    }).done( function (company) {
    	$(".span_company_link").hide();
        $("#span_company").append(company);
    }).fail(function(){
    	$(".span_company_link").html("点击显示");
    });
}

function getSpanProduct(){
    $(".span_product_link").html("加载中……");
	$.ajax({
        url: "http://www.sharedour.com/api/all_message.php?action=product",
        type: 'get',
        dataType: "jsonp",
        jsonp: 'callbackproduct',
        timeout: 3000
    }).done( function (product) {
        $(".span_product_link").hide();
        $("#span_product").append(product);
    }).fail(function(){
    	$(".span_product_link").html("点击显示");
    });
}