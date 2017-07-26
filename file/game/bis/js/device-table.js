var original_url = 'http://device.tecenet.com/index.php';
var list_url = original_url+'?r=api/list';
var count_url = original_url+'?r=api/count';

var regKw = '';
var dchecked = 'checked';
var fchecked = '';

var lock = true;

var selectorTable = function(kw,dc,fc){
    selecter_table = '<div class="card">' +
        '<div class="card-header">企业信息</div>' +
        '<div class="card-content">' +
            '<div class="card-content-inner row">' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="reg_id">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>注册证编号</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="reg_person">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>注册人名称</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="reg_address">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>注册人住所</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="company_address">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>生产地址</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="agent_person">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>代理人名称</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="agent_address">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>代理人住所</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="postcode">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>邮编</span>' +
                '</label>' +
            '</div>' +
        '</div>' +
    '</div>' +
    '<div class="card">' +
        '<div class="card-header">产品信息</div>' +
        '<div class="card-content">' +
            '<div class="card-content-inner row">' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="product_name">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>产品名称</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="product_model">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>型号、规格</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="product_form">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>结构及组成</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="product_range">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>使用范围</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="product_other">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>其他内容</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="product_remark">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>备注</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="product_options">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>附件</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="product_standard">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>产品标准</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="product_element">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>主要组成成分</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="product_use">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>预期用途</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-80">' +
                    '<input type="checkbox" name="fw_check[]" value="product_storage">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>产品存储条件及有效期</span>' +
                '</label>' +
            '</div>' +
        '</div>' +
    '</div>'+
    '<div class="card">' +
        '<div class="card-header">审批信息</div>' +
        '<div class="card-content">' +
            '<div class="card-content-inner row">' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="examine_department">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>审批部门</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="examine_change">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>变更情况</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="examine_startdate">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>批准日期</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="examine_enddate">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>有效期至</span>' +
                '</label>' +
                '<label class="label-checkbox item-content col-50">' +
                    '<input type="checkbox" name="fw_check[]" value="examine_changedate">' +
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>变更日期</span>' +
                '</label>' +
            '</div>' +
        '</div>' +
    '</div>' +
    '<div class="card">'+
        '<div class="card-header">国产/进口</div>'+
        '<div class="card-content">'+
            '<div class="card-content-inner row">'+
                '<label class="label-checkbox item-content col-50">'+
                    '<input type="radio" name="from" value="domestic" checked="">'+
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>国产器械</span>'+
                '</label>'+
                '<label class="label-checkbox item-content col-50">'+
                    '<input type="radio" name="from" value="import">'+
                    '<span class="item-media"><i class="icon icon-form-checkbox"></i>进口器械</span>'+
                '</label>'+
            '</div>'+
        '</div>'+
    '</div>';
    return selecter_table;
};


var simple = function(){
    $('#simple-input').css('display','block');
    $('input[name^="fw_input"]').each(function(){$(this).remove();});
    $('input[name="fw_check[]"]').each(function(){$(this).attr('checked',false);});
};

var high = function(){
    $('#simple-input').css('display','none');
    $('input[name="fw_check[]"]').each(function(){$(this).attr('checked',false);});
};

var subWord = function(str){
    if(str == null ){
        return '-';
    }else{
        return str;
    }
};
//
//var all_check = function(){
//    $('.sticky-col').find("input[name='data_check[]']").each(function(){
//        if($(this).is(':checked')){
//            $(this).attr("checked", false);
//        }else{
//            $(this).attr("checked", true);
//        }
//    });
//};

var datalist = function(data){
    $('#productWrap').empty();
    if(data[0] != undefined && data[0]['ID'] == 'no data'){
        //查询无数据
        $('#productWrap').empty();
        $.toast("抱歉，查无数据");
        $.hidePreloader();
        return '';
    }
    //json = JSON.parse(data);
    json = data;
    $.each(json,function(index,item){
        item_url = original_url+'?r=api/item&itemid='+item.itemid;
        str = '';
        str += '<a href="javascript:msgdiv(\''+item.product_name+'\',\'\',\''+item_url+'\');" class="product-item open-detail">';
        str += '<div class="product-title">'+subWord(item.product_name)+'</div>';
        str += '<ul class="product-info">';
        str += '<li><i class="p-i p-i-cmp"></i>'+subWord(item.reg_person)+'</li>';
        str += '<li><i class="p-i p-i-num"></i>'+subWord(item.reg_id)+'</li>';
        str += '</ul>';
        str += '</a>';
        $('#productWrap').append(str);
        $.hidePreloader();
    });

    highlight();
    //$('#productWrap').removeClass('loading');
};

var isEmptyObj =  function(obj){
    for(var key in obj){
        return false;
    }
    return true;
};

var getCheckBoxParams = function(){
    back = {};
    //select_type = $('#select-type').val();
    $('#table-selector').find("input[name='fw_check[]']").each(function(){
        if($(this).is(':checked')) {
            val = $(this).val();
            if(select_type == '1'){
                input_val = $('input[name="fw_input['+val+']"]').val();
                if(input_val != '') back[val] = input_val;
            }else{
                back[val] = $('#simple-input').val();
            }
        }
    });
    if(isEmptyObj(back)) back['ID'] = $('#simple-input').val();
    $('#table-selector').find("input[name='from']").each(function(){
        if($(this).is(':checked')){
            back['from'] = $(this).val();
        }
    });

    return back;
};

var simple_search = function(page){
    kw = $('#simple-input').val();
    send_data = {};
    send_data.type = 'simple';
    send_data.pagesize = $('#pagesize').val();
    send_data.page = page;
    //if(kw != ''){
    send_data.kw = kw;
    send_data.params = getCheckBoxParams();
    send_data.r = 'api/select';
    getAjax(original_url,datalist,send_data);
    showpage(0);
    //send_data.r = 'api/count';
    //getAjax(original_url,pagebutton,send_data);
    //}else{
    //	alert('请输入搜索关键词');
    //}
};

var high_search = function(page){
    send_data = {};
    send_data.type = 'high';
    send_data.pagesize = $('#pagesize').val();
    send_data.page = page;
    send_data.params = getCheckBoxParams();
    send_data.r = 'api/select';
    getAjax(original_url,datalist,send_data);
    showpage(0);
    //send_data.r = 'api/count';
    //getAjax(original_url,pagebutton,send_data);
};

var highlight = function(){
    high_str = '';
    select_type = $('#select-type').val();
    if(select_type == '1'){
        $('#table-selector').find("input[name='fw_check[]']").each(function(){
            if($(this).is(':checked')) {
                val = $(this).val();
                input_val = $('input[name="fw_input['+val+']"]').val();
                $('#productWrap').highlight(input_val);
            }
        });
    }else{
        high_str = $('#simple-input').val();
        $('#productWrap').highlight(high_str);
    }

};


var pagebutton = function(data){
    $('#pagebutton').empty();
    $('#pagebutton').append(data.button);
};

var getAjax = function(get_url,func,send_data){
    $.showPreloader();
    if(typeof(send_data) != "undefined") {
        param = $.param(send_data);
        get_url += '?'+param;
    }
    $.ajax({
        type:'GET',
        url:get_url,
        dataType:"jsonp",
        jsonp: "callbackparam",
        success:function(data,status){
            func(data);
            setTimeout(function () {
                $.hideIndicator();
            }, 2000);
            $('.content').scrollTop(0);
            lock = true;
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $.toast("加载出错，请稍后再试");
            $.hidePreloader();
            lock = true;
        }
    });
};

var showpage = function(page){
    new_page = parseInt(page) + 1;
    cb_params = getCheckBoxParams();
    send_data = {};
    send_data.type = $('#select-type').val() == '1' ? 'high' : 'simple';
    send_data.page = new_page;
    send_data.pagesize = $('#pagesize').val();
    if($.isEmptyObject(cb_params)){
        send_data.r = 'api/list';
    }else{
        send_data.r = 'api/select';
        send_data.params = cb_params;
    }
    if(lock){
        lock = false;//更新开始前关闭锁
        getAjax(original_url,datalist,send_data);
        send_data.r = 'api/count';
        setTimeout(getAjax(original_url,pagebutton,send_data), 1000);

    }


};

var gotoPage = function(){
    page = $('#go_input_id').val();
    if(isNaN(page)) page = 1;
    showpage(page - 1);
};



//获取地址上的参数
var getRequestPar = function(name){
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return decodeURI(r[2]);
    return null;
};

$(function(){
    if(getRequestPar('kw') !== null){
        regKw = getRequestPar('kw');
    }
    if(getRequestPar('type') !== null && getRequestPar('type') == '1'){
        dchecked = '';
        fchecked = 'checked';
    }
    $('.category-layout').append(selectorTable(regKw,dchecked,fchecked));

    if(regKw != ''){
        regSelector = getRequestPar('selector');
        if(regSelector != null){
            selector_arr = regSelector.split(',');
            for(var i in selector_arr){
                $('input[value="'+selector_arr[i]+'"]').attr("checked", true);
            }
        }
        simple_search(1);
    }else{
        getAjax(list_url+'&page=1&pagesize=20',datalist);
        getAjax(count_url+'&type=simple',pagebutton);
    }

    $('#search').click(function(){
        $('#select-type').val() == '1' ? high_search(1) : simple_search(1);
    });

    $("#select-type").change(function(){
        $('#select-type').val() == '1' ? high() : simple();
    });

    $("input[name='fw_check[]']").change(function(){
        if($('#select-type').val() == '1' ){
            name = $(this).val();
            //增加输入控件
            if($(this).is(':checked') ){
                $(this).parent().append('<input type="text" name="fw_input['+name+']" />');
            }else{	//删除输入控件
                $(this).parent().find("input[type='text']").each(function(){$(this).remove();});
            }
        }
    });
});

var msgdiv = function(title,id,href){
    $.showPreloader();
    $(".popup-detail-title").html(title);
    var iframe = document.createElement("iframe");
    iframe.src = href;
    if (iframe.attachEvent){
        iframe.attachEvent("onload", function(){
            $.hidePreloader();
        });
    } else {
        iframe.onload = function(){
            $.hidePreloader();
        };
    }
    $(".popup-detail-content").html(iframe);
};



