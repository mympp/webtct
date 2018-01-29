// 获取工商信息
var getCompanyInfo = function(){
    var $name = $.trim($(".tp-header-name").text());
    var $wrap  = $(".tp-archives-info");
    var $box = $wrap.find(".tp-archives-table tbody");

    $.ajax({
        url:"https://wapbaike.baidu.com/api/wapui/getcertifyinfo",
        dataType:'jsonp',
        data:{
            lemmaTitle:$name
        },
        success:function(data) {
            $wrap.show();
            var $template = "";
            if(data['qixinbao'].length != 0){
                $template = '<tr><td width="20%" class="bg-warning">统一社会信用代码：</td><td width="30%">'+data['qixinbao'].creditNo+'</td> <td width="20%" class="bg-warning">组织机构代码：</td><td width="30%">'+data['qixinbao'].orgCode+'</td> </tr>'+
                    '<tr><td width="20%" class="bg-warning">工商注册号：</td><td width="30%">'+data['qixinbao'].orgRegisterNum+'</td> <td width="20%" class="bg-warning">公司类型：</td><td width="30%">'+data['qixinbao'].level+'</td> </tr>'+
                    '<tr><td width="20%" class="bg-warning">法定代表人：</td><td width="30%">'+data['qixinbao'].legalPerson+'</td> <td width="20%" class="bg-warning">注册资本：</td><td width="30%">'+data['qixinbao'].regCapital+'</td> </tr>'+
                    '<tr><td width="20%" class="bg-warning">经营状态：</td><td width="30%">'+data['qixinbao'].certStatus+'</td> <td width="20%" class="bg-warning">成立日期：</td><td width="30%">'+data['qixinbao'].foundTime+'</td> </tr>'+
                    '<td width="20%" class="bg-warning">发照日期：</td><td width="30%">'+data['qixinbao'].checkDate+'</td><td width="20%" class="bg-warning">登记机关：</td><td width="30%">'+data['qixinbao'].belongOrg+'</td> </tr>'+
                    '<tr><td class="bg-warning">营业期限：</td><td colspan="3">'+data['qixinbao'].termTime+'</td></tr>'+
                    '<tr><td class="bg-warning">企业地址：</td><td colspan="3">'+data['qixinbao'].location+'</td></tr>'+
                    '<tr><td class="bg-warning">经营范围：</td><td colspan="3">'+data['qixinbao'].scope+'</td></tr>';
                $box.html($template);
            }else{
                $wrap.hide();
            }
        }
    });
};
getCompanyInfo();