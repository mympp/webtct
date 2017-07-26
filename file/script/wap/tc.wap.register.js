/**
 * Created by teague on 2017/6/21.
 */
var DTPath = "http://"+window.location.host+"/";
var DMURL = document.location.protocol+'//'+location.hostname+(location.port ? ':'+location.port : '')+'/';
if(DTPath.indexOf(DMURL) != -1) DMURL = DTPath;
var AJPath = DMURL+'ajax.php';

// 步骤1验证
$('#regFormStep1').validator({
    timely: 0,
    rules: {
        username:[/^[a-z0-9][a-z0-9-]{3,18}[a-z0-9]$/, '请输入正确的会员账号'],
        va_username: function(element){
            return $.ajax({
                url: AJPath,
                type: 'post',
                data: 'action=member_check&job=username_or_mobile_exists&from=username&value='+element.value
            });
        },
        va_captcha: function(element){
            return $.ajax({
                url: AJPath,
                type: 'post',
                data: 'action=captcha&result=string&captcha='+element.value
            });
        },
        va_mobile: function(element){
            return $.ajax({
                url: AJPath,
                type: 'post',
                data: 'action=member_check&job=username_or_mobile_exists&from=mobile&value='+element.value
            });
        }
    },
    msgWrapper: 'div',
    msgMaker: function(opt){
        return '<p class="'+ opt.type +'">' + opt.msg + '</p>';
    }
});

// 步骤2验证
$("#regFormStep2").validator({
    timely: 0,
    rules: {
        // 验证真是姓名
        va_name:[/^[A-z]+$|^[\u4E00-\u9FA5]+$/,"请输入您的真实姓名"],
        // 验证地区
        va_area:[/[0-9]*[1-9][0-9]*/,"请选择您所在地区"],
        //验证电子邮箱是否存在
        va_email: function(element){
            return $.ajax({
                url: AJPath,
                type: 'post',
                data: 'action=member_check&job=email_exists&value='+element.value
            });
        },
        // 验证公司名是否存在
        va_company: function(element){
            return $.ajax({
                url: AJPath,
                type: 'post',
                data: 'action=member_check&job=company_exists&value='+element.value
            });
        },
        // 验证域名是否被注册
        va_domain: function(element){
            return $.ajax({
                url: AJPath,
                type: 'post',
                data: 'action=member_check&job=linkurl_exists&value='+element.value
            });
        }

    },
    fields: {
        "post[truename]": "required;va_name;length[2~, true]",
        "post[areaid]" :"va_area",
        "post[email]": "required;email;va_email",
        "company[company]": "required(#isCompany:checked);va_company",
        "company[domain]": "required(#isCompany:checked)",
        "company[type]": "required(#isCompany:checked)",
        "company[telephone]": "required(#isCompany:checked);numeric;length[7~, true]"
    },
    msgWrapper: 'div',
    msgMaker: function(opt){
        return '<p class="'+ opt.type +'">' + opt.msg + '</p>';
    }
});


// 短信验证码倒计时
var wait = 120;
function settime(o) {
    if (wait == 0) {
        o.removeAttribute("disabled");
        o.value="获取短信验证码";
        wait = 120;
        $(".msg-verify-btn").removeClass("msg-verify-btn-dis");
    } else {
        o.setAttribute("disabled", true);
        o.value="重新发送(" + wait + ")";
        wait--;
        setTimeout(function() {settime(o);},1000);
    }
}
// 发送验证码
function  sendSMS(ele){
    var btnEle = ele;
    if($("#frmUserName,#frmMobile,#frmCaptcha").isValid()){
        $(btnEle).attr("disabled", true);
        $(btnEle).addClass("msg-verify-btn-dis");
        $(btnEle).val("正在发送中...");
        $.ajax({
            url: AJPath,
            type: 'post',
            data: 'action=sms&mobile='+$("#frmMobile").val()+'&username='+$("#frmUserName").val()+'&captcha='+$("#frmCaptcha").val(),
            success: function(d){
                if(d == 6){
                    $('#regFormStep1').validator('showMsg', '#SMSCaptcha', {
                        type: "tip",
                        msg: "抱歉，短信验证码发送失败，请您稍后再试。"
                    });
                }
                if(d == 7){
                    $(btnEle).removeAttr("disabled");
                    $(btnEle).removeClass("msg-verify-btn-dis");
                    $(btnEle).val("获取短信验证码");
                    $('#regFormStep1').validator('showMsg', '#SMSCaptcha', {
                        type: "tip",
                        msg: "短信已发送到您的手机中，请留意接收。"
                    });
                }
                if(d == 0){
                    settime(btnEle);
                }
            }
        });
    }
}

// 更换图片验证码
function reloadCaptcha(){
    $(".verify-code-img").attr("src","http://"+window.location.host+"/api/captcha.png.php?action=image&height=30&refresh="+Math.random());
}

// 查看明文密码
$(document).on("click", ".see-password", function(e) {
    if($(this).hasClass('on')){
        e.preventDefault();
        $(this).removeClass('on');
        $(this).parent().parent().find("input").attr('type', 'password');
    }else{
        e.preventDefault();
        $(this).addClass('on');
        $(this).parent().parent().find("input").attr('type', 'text');
    }
});


// 地区选择
$(document).on("click", "#frmArea", function(e) {
    $("#frmArea").cityPicker({
        showDistrict: false
    });
});




// 企业会员展开项
$("#isCompany").click(function () {
    if($(this).is(":checked")){
        $(this).parent().addClass("checked");
        $(".cpy-frm-wrp").slideDown();
    }else{
        $(this).parent().removeClass("checked");
        $(".cpy-frm-wrp").slideUp(100);
        if( !$('#frmCompany,#frmDomain').isValid()){
            $('#regFormStep2').validator({
                ignore: '#frmCompany,#frmDomain'
            });
        }
    }
});

// 注册条款
var agreePopupHtml = '<div id="agreePopup" class="weui-popup__container"> <div class="weui-popup__overlay"></div> <a class="close-popup" href="javascript:;" >×</a> <div class="weui-popup__modal agree-popup__modal pd-20"> <p>欢迎阅读天成医疗网服务条款协议(下称“本协议”)。本协议阐述之条款和条件适用于您使用天成医疗网所提供的在企业间(B-TO-B)电子市场中进行贸易和交流的各种工具和服务(下称“服务”)。</p> <p>1. 接受条款。</p> <p>以任何方式进入天成医疗网网站即表示您同意自己已经与天成医疗网订立本协议，且您将受本协议的条款和条件(“条款”) 约束。天成医疗网可随时自行全权决定更改“条款”。如“条款”有任何变更，天成医疗网将在其网站上刊载公告，通知予您。如您不同意相关变更，必须停止使用“服务”。经修订的“条款”一经在天成医疗网网站的公布后，立即自动生效。您应在第一次登录后仔细阅读修订后的“条款”，并有权选择停止继续使用“服务”；一旦您继续使用“服务”，则表示您已接受经修订的“条款”，当您与天成医疗网发生争议时，应以最新的服务协议为准。除另行明确声明外，任何使“服务”范围扩大或功能增强的新内容均受本协议约束。除非经天成医疗网的授权高层管理人员签订书面协议，本协议不得另行作出修订。</p> <p>2.谁可使用天成医疗网网站？</p> <p>“服务”仅供能够根据相关法律订立具有法律约束力的合约的个人或公司使用。因此，您的年龄必须在十八周岁或以上，才可使用本公司服务。如不符合本项条件，请勿使用“服务”。天成医疗网可随时自行全权决定拒绝向任何人士提供“服务”。“服务”不会提供给被暂时或永久中止资格的天成医疗网会员。</p> <p>3. 收费。</p> <p>本公司保留在根据第1条通知您后，收取“服务”费用的权利。您因进行交易、向本公司获取有偿服务或接触本公司服务器而发生的所有应纳税赋，以及相关硬件、软件、通讯、网络服务及其他方面的费用均由您自行承担。本公司保留在无须发出书面通知，仅在天成医疗网网站公示的情况下，暂时或永久地更改或停止部分或全部“服务”的权利。</p> <p>4.天成医疗网网站仅作为交易地点。</p> <p>本公司网站仅作为用户物色交易对象，就货物和服务的交易进行协商，以及获取各类与贸易相关的服务的地点。但是，本公司不能控制交易所涉及的物品的质量、安全或合法性，商贸信息的真实性或准确性，以及交易方履行其在贸易协议项下的各项义务的能力。本公司不能也不会控制交易各方能否履行协议义务。此外，您应注意到，与外国国民、未成年人或以欺诈手段行事的人进行交易的风险是客观存在的。</p> <p>5.您的资料和供买卖的物品。</p> <p>“您的资料”包括您在注册、交易或列举物品过程中、在任何公开信息场合或通过任何电子邮件形式，向本公司或其他用户提供的任何资料，包括数据、文本、软件、音乐、声响、照片、图画、影像、词句或其他材料。您应对“您的资料”负全部责任，而本公司仅作为您在网上发布和刊登“您的资料”的被动渠道。但是，倘若本公司认为“您的资料”可能使本公司承担任何法律或道义上的责任，或可能使本公司 (全部或部分地) 失去本公司的互联网技术工程师或其他供应商的服务，或您未在天成医疗网规定的期限内登录或再次登录网站，则本公司可自行全权决定对“您的资料”采取本公司认为必要或适当的任何行动，包括但不限于删除该类资料。您特此保证，您对提交给天成医疗网的“您的资料”拥有全部权利，包括全部版权。您确认，天成医疗网没有责任去认定或决定您提交给本公司的资料哪些是应当受到保护的，对享有“服务”的其他用户使用“您的资料”，本公司也不必负责。</p> <p>5.1 注册义务。</p> <p> 如您在天成医疗网网站注册，您同意：</p> <p>(a) 根根据天成医疗网网站刊载的会员资料表格的要求，提供关于您或贵公司的真实、准确、完整和反映当前情况的资料；</p> <p>(b) 维持并及时更新会员资料，使其保持真实、准确、完整和反映当前情况。倘若您提供任何不真实、不准确、不完整或不能反映当前情况的资料，或天成医疗网有合理理由怀疑该等资料不真实、不准确、不完整或不能反映当前情况，天成医疗网有权暂停或终止您的注册身份及资料，并拒绝您在目前或将来对“服务”(或其任何部份) 以任何形式使用。如您代表一家公司或其他法律主体在本公司登记，则您声明和保证，您有权使该公司或其他法律主体受本协议“条款”约束。</p> <p>5.2 会员注册名、密码和保密。</p> <p>在登记过程中，您将选择会员注册名和密码。您须自行负责对您的会员注册名和密码保密，且须对您在会员注册名和密码下发生的所有活动承担责任。您同意：</p> <p>(a) 如发现任何人未经授权使用您的会员注册名或密码，或发生违反保密规定的任何其他情况，您会立即通知天成医疗网；</p> <p>(b) 确保您在每个上网时段结束时，以正确步骤离开网站。天成医疗网不能也不会对因您未能遵守本款规定而发生的任何损失或损毁负责。</p> <p>5.3 关于您的资料的规则。</p> <p>您同意，“您的资料”和您供在天成医疗网网站上交易的任何“物品”（泛指一切可供依法交易的、有形的或无形的、以各种形态存在的某种具体的物品，或某种权利或利益，或某种票据或证券，或某种服务或行为。本协议中“物品”一词均含此义）</p> <p>a. 不会有欺诈成份，与售卖伪造或盗窃无涉；</p> <p>b. 不会侵犯任何第三者对该物品享有的物权，或版权、专利、商标、商业秘密或其他知识产权，或隐私权、名誉权；</p> <p>c. 不会违反任何法律、法规、条例或规章 (包括但不限于关于规范出口管理、贸易配额、保护消费者、不正当竞争或虚假广告的法律、法规、条例或规章)；</p> <p>d. 不会含有诽谤（包括商业诽谤）、非法恐吓或非法骚扰的内容；</p> <p>e. 不会含有淫秽、或包含任何儿童色情内容；</p> <p>f. 不会含有蓄意毁坏、恶意干扰、秘密地截取或侵占任何系统、数据或个人资料的任何病毒、伪装破坏程序、电脑蠕虫、定时程序炸弹或其他电脑程序；</p> <p>g. 不会直接或间接与下述各项货物或服务连接，或包含对下述各项货物或服务的描述：</p> <p>(i) 本协议项下禁止的货物或服务；或</p> <p>(ii) 您无权连接或包含的货物或服务。</p> <p>此外，您同意不会：</p> <p>(h) 在与任何连锁信件、大量胡乱邮寄的电子邮件、滥发电子邮件或任何复制或多余的信息有关的方面使用“服务”；</p> <p>(i) 未经其他人士同意，利用“服务”收集其他人士的电子邮件地址及其他资料；或</p> <p>(j) 利用“服务”制作虚假的电子邮件地址，或以其他形式试图在发送人的身份或信息的来源方面误导其他人士。</p> <p>5.4 被禁止物品。</p> <p>您不得在本公司网站公布或通过本公司网站买卖：</p> <p>(a) 可能使本公司违反任何相关法律、法规、条例或规章的任何物品；或</p> <p>(b) 天成医疗网认为应禁止或不适合通过本网站买卖的任何物品。</p> <p>6. 您授予本公司的许可使用权。</p> <p>您授予本公司独家的、全球通用的、永久的、免费的许可使用权利 (并有权在多个层面对该权利进行再授权)，使本公司有权(全部或部份地) 使用、复制、修订、改写、发布、翻译、分发、执行和展示"您的资料"或制作其派生作品，和/或以现在已知或日后开发的任何形式、媒体或技术，将"您的资料"纳入其他作品内。</p> <p>7.隐私。</p> <p>尽管有第6条所规定的许可使用权，天成医疗网将仅根据本公司的隐私声明使用“您的资料”。本公司隐私声明的全部条款属于本协议的一部份，因此，您必须仔细阅读。请注意，您一旦自愿地在天成医疗网交易地点披露“您的资料”，该等资料即可能被其他人士获取和使用。</p> <p>8.交易程序。</p> <p>8.1 添加产品描述条目。</p> <p>产品描述是由您提供的在天成医疗网网站上展示的文字描述、图画和/或照片，可以是</p> <p>(a) 对您拥有而您希望出售的产品的描述；或</p> <p>(b) 对您正寻找的产品的描述。您可在天成医疗网网站发布任一类产品描述，或两种类型同时发布，条件是，您必须将该等产品描述归入正确的类目内。</p> <p>天成医疗网不对产品描述的准确性或内容负责。</p> <p>8.2 就交易进行协商。</p> <p>交易各方通过在天成医疗网网站上明确描述报盘和回盘，进行相互协商。所有各方接纳报盘或回盘将使所涉及的天成医疗网用户有义务完成交易。除非在特殊情况下，诸如用户在您提出报盘后实质性地更改对物品的描述或澄清任何文字输入错误，或您未能证实交易所涉及的用户的身份等，报盘和承诺均不得撤回。</p> <p>8.3 处理交易争议。</p> <p>本公司不会且不能牵涉进交易各方的交易当中。倘若您与一名或一名以上用户，或与您通过本公司网站获取其服务的第三者技术工程师发生争议，您免除天成医疗网 (及本公司代理人和雇员) 在因该等争议而引起的，或在任何方面与该等争议有关的不同种类和性质的任何 (实际和后果性的) 权利主张、要求和损害赔偿等方面的责任。</p> <p>8.4 运用常识。</p> <p>本公司不能亦不试图对其他用户通过“服务”提供的资料进行控制。就其本质而言，其他用户的资料，可能是令人反感的、有害的或不准确的，且在某些情况下可能带有错误的标识说明或以欺诈方式加上标识说明。本公司希望您在使用本公司网站时，小心谨慎并运用常识。</p> <p>9.交易系统。</p> <p>9.1 不得操纵交易。</p> <p>您同意不利用帮助实现蒙蔽或欺骗意图的同伙(下属的客户或第三方)，操纵与另一交易方所进行的商业谈判的结果。</p> <p>9.2 系统完整性。</p> <p>您同意，您不得使用任何装置、软件或例行程序干预或试图干预天成医疗网网站网站的正常运作或正在本公司网站上进行的任何交易。您不得采取对任何将不合理或不合比例的庞大负载加诸本公司网络结构的行动。您不得向任何第三者披露您的密码，或与任何第三者共用您的密码，或为任何未经批准的目的使用您的密码。</p> <p>9.3 反馈。</p> <p>您不得采取任何可能损害信息反馈系统的完整性的行动，诸如：利用第二会员身份标识或第三者为您本身留下正面反馈；利用第二会员身份标识或第三者为其他用户留下负面反馈 (反馈数据轰炸)；或在用户未能履行交易范围以外的某些行动时，留下负面的反馈 (反馈恶意强加)。</p> <p>9.4 不作商业性利用。</p> <p>您同意，您不得对任何资料作商业性利用，包括但不限于在未经天成医疗网授权高层管理人员事先书面批准的情况下，复制在天成医疗网网站上展示的任何资料并用于商业用途。</p> <p>10. 终止或访问限制。</p> <p>您同意，在天成医疗网未向您收费的情况下，天成医疗网可自行全权决定以任何理由 (包括但不限于天成医疗网认为您已违反本协议的字面意义和精神，或您以不符合本协议的字面意义和精神的方式行事，或您在超过90天的时间内未以您的帐号及密码登录网站) 终止您的“服务”密码、帐户 (或其任何部份) 或您对“服务”的使用，并删除和丢弃您在使用“服务”中提交的 “您的资料”。您同意，在天成医疗网向您收费的情况下，天成医疗网应基于合理的怀疑且经电子邮件通知的情况下实施上述终止服务的行为。天成医疗网同时可自行全权决定，在发出通知或不发出通知的情况下，随时停止提供“服务”或其任何部份。您同意，根据本协议的任何规定终止您使用“服务”之措施可在不发出事先通知的情况下实施，并承认和同意，天成医疗网可立即使您的帐户无效，或撤销您的帐户以及在您的帐户内的所有相关资料和档案，和/或禁止您进一步接入该等档案或“服务”。帐号终止后，天成医疗网没有义务为您保留原帐号中或与之相关的任何信息，或转发任何未曾阅读或发送的信息给您或第三方。此外，您同意，天成医疗网不会就终止您接入“服务”而对您或任何第三者承担任何责任。第12、13、14和22各条应在本协议终止后继续有效。</p> <p>11. 违反规则会有什么后果？</p> <p>在不限制其他补救措施的前提下，发生下述任一情况，本公司可立即发出警告，暂时中止、永久中止或终止您的会员资格，删除您的任何现有产品信息，以及您在网站上展示的任何其他资料：</p> <p>(i) 您违反本协议；</p> <p>(ii) 本公司无法核实或鉴定您向本公司提供的任何资料；或</p> <p>(iii) 本公司相信您的行为可能会使您、本公司用户或通过本公司或本公司网站提供服务的第三者技术工程师发生任何法律责任。在不限制任何其他补救措施的前提下，倘若发现您从事涉及本公司网站的诈骗活动，天成医疗网可暂停或终止您的帐户。</p> <p>12. 服务“按现状”提供。</p> <p>本公司会尽一切努力使您在使用天成医疗网网站的过程中得到乐趣。遗憾的是，本公司不能随时预见到任何技术上的问题或其他困难。该等困难可能会导致数据损失或其他服务中断。为此，您明确理解和同意，您使用“服务”的风险由您自行承担。“服务”以“按现状”和“按可得到”的基础提供。天成医疗网明确声明不作出任何种类的所有明示或暗示的保证，包括但不限于关于适销性、适用于某一特定用途和无侵权行为等方面的保证。天成医疗网对下述内容不作保证：</p> <p>(i)“服务”会符合您的要求；</p> <p>(ii)“服务”不会中断，且适时、安全和不带任何错误；</p> <p>(iii) 通过使用“服务”而可能获取的结果将是准确或可信赖的；</p> <p>(iv) 您通过“服务”而购买或获取的任何产品、服务、资料或其他材料的质量将符合您的预期。通过使用“服务”而下载或以其他形式获取任何材料是由您自行全权决定进行的，且与此有关的风险由您自行承担，对于因您下载任何该等材料而发生的您的电脑系统的任何损毁或任何数据损失，您将自行承担责任。您从天成医疗网或通过或从“服务”获取的任何口头或书面意见或资料，均不产生未在本协议内明确载明的任何保证。</p> <p>13. 责任范围。</p> <p> 您明确理解和同意，天成医疗网不对因下述任一情况而发生的任何损害赔偿承担责任，包括但不限于利润、商誉、使用、数据等方面的损失或其他无形损失的损害赔偿 (无论天成医疗网是否已被告知该等损害赔偿的可能性)：</p> <p>(i) 使用或未能使用“服务”；</p> <p>(ii) 因通过或从“服务”购买或获取任何货物、样品、数据、资料或服务，或通过或从“服务”接收任何信息或缔结任何交易所产生的获取替代货物和服务的费用；</p> <p>(iii) 未经批准接入或更改您的传输资料或数据；</p> <p>(iv) 任何第三者对“服务”的声明或关于“服务”的行为；或因任何原因而引起的与“服务”有关的任何其他事宜，包括疏忽。</p> <p>14. 赔偿。</p> <p>您同意，因您违反本协议或经在此提及而纳入本协议的其他文件，或因您违反了法律或侵害了第三方的权利，而使第三方对天成医疗网及其子公司、分公司、董事、职员、代理人提出索赔要求（包括司法费用和其他专业人士的费用），您必须赔偿给天成医疗网及其子公司、分公司、董事、职员、代理人，使其等免遭损失。</p> <p>15. 遵守法律。</p> <p>您应遵守与您使用“服务”，以及与您竞买、购买和销售任何物品以及提供商贸信息有关的所有相关的法律、法规、条例和规章。</p> <p>16. 无代理关系。</p> <p>您与天成医疗网仅为独立订约人关系。本协议无意结成或创设任何代理、合伙、合营、雇用与被雇用或特许权授予与被授予关系。</p> <p>17. 广告和金融服务。</p> <p>您与在“服务”上或通过“服务”物色的刊登广告人士通讯或进行业务往来或参与其推广活动，包括就相关货物或服务付款和交付相关货物或服务，以及与该等业务往来相关的任何其他条款、条件、保证或声明，仅限于在您和该刊登广告人士之间发生。您同意，对于因任何该等业务往来或因在“服务”上出现该等刊登广告人士而发生的任何种类的任何损失或损毁，天成医疗网无需负责或承担任何责任。您如打算通过“服务”创设或参与与任何公司、股票行情、投资或证券有关的任何服务，或通过“服务”收取或要求与任何公司、股票行情、投资或证券有关的任何新闻信息、警戒性信息或其他资料，敬请注意，天成医疗网不会就通过“服务”传送的任何该等资料的准确性、有用性或可用性、可获利性负责或承担任何责任，且不会对根据该等资料而作出的任何交易或投资决策负责或承担任何责任。</p> <p>18. 链接。</p> <p>“服务”或第三者均可提供与其他万维网网站或资源的链接。由于天成医疗网并不控制该等网站和资源，您承认并同意，天成医疗网并不对该等外在网站或资源的可用性负责，且不认可该等网站或资源上或可从该等网站或资源获取的任何内容、宣传、产品、服务或其他材料，也不对其等负责或承担任何责任。您进一步承认和同意，对于任何因使用或信赖从此类网站或资源上获取的此类内容、宣传、产品、服务或其他材料而造成（或声称造成）的任何直接或间接损失，天成医疗网均不承担责任。</p> <p>19. 通知。</p> <p>除非另有明确规定，任何通知应以电子邮件形式发送，(就天成医疗网而言) 电子邮件地址为以本站域名后缀之地址，或 (就您而言) 发送到您在登记过程中向天成医疗网提供的电子邮件地址，或有关方指明的该等其他地址。在电子邮件发出二十四 (24) 小时后，通知应被视为已送达，除非发送人被告知相关电子邮件地址已作废。或者，本公司可通过邮资预付挂号邮件并要求回执的方式，将通知发到您在登记过程中向天成医疗网提供的地址。在该情况下，在付邮当日三 (3) 天后通知被视为已送达。</p> <p>20. 不可抗力。</p> <p>对于因本公司合理控制范围以外的原因，包括但不限于自然灾害、罢工或骚乱、物质短缺或定量配给、暴动、战争行为、政府行为、通讯或其他设施故障或严重伤亡事故等，致使本公司延迟或未能履约的，天成医疗网不对您承担任何责任。</p> <p>21. 转让。</p> <p>天成医疗网转让本协议无需经您同意。</p> <p>22. 其他规定。</p> <p>本协议取代您和天成医疗网先前就相同事项订立的任何书面或口头协议。本协议各方面应受中华人民共和国大陆地区法律的管辖。倘若本协议任何规定被裁定为无效或不可强制执行，该项规定应被撤销，而其余规定应予执行。条款标题仅为方便参阅而设，并不以任何方式界定、限制、解释或描述该条款的范围或限度。本公司未就您或其他人士的某项违约行为采取行动，并不表明本公司撤回就任何继后或类似的违约事件采取行动的权利。</p> <p>23. 诉讼。</p> <p>因本协议或本公司服务所引起或与其有关的任何争议应向人民法院提起诉讼，并以中华人民共和国法律为管辖法律。</p> </div> </div>';
$(document).on("click", ".agreement-tip a", function() {
    $("body").append(agreePopupHtml);
    $("#agreePopup").popup();
});
$(document).on("click", "#agreePopup .close-popup", function() {
    $("#agreePopup").remove();
});


//注册表单验证
//function validateRegister() {
//    var DTPath = "http://www.tecenet.com/";
//    var DMURL = document.location.protocol+'//'+location.hostname+(location.port ? ':'+location.port : '')+'/';
//    if(DTPath.indexOf(DMURL) != -1) DMURL = DTPath;
//    var AJPath = DMURL+'ajax.php';
//
//    var el = document.querySelector('.tc-register-form');
//    var userNameEm = el.querySelector('input[name="username"]');
//    var passWordEm = el.querySelector('input[name="password"]');
//    var emailEm = el.querySelector('input[name="email"]');
//    var companyEm = el.querySelector('input[name="company"]');
//    var trueNameEm = el.querySelector('input[name="truename"]');
//    var mobileEm = el.querySelector('input[name="mobile"]');
//    var captchaEm = el.querySelector('input[name="captcha"]');
//    // 用户名
//
//
//
//
//    if (userNameEm.value == "") {
//        $.toast('请您填写会员名称','text');
//        userNameEm.focus();
//        return false;
//    }
//    if (userNameEm.value.length < 5 || userNameEm.value.length > 20) {
//        $.toast('会员名长度限制为5-20','text');
//        userNameEm.focus();
//        return false;
//    }
//    $.post(AJPath,{action:"member_check", job:"username_or_mobile_exists", from:"username", value:userNameEm.value},
//        function(data){
//            if(data != ""){
//                $.toast(data,'text');
//                userNameEm.focus();
//                return false;
//            }
//        }
//    );
//    if (userNameEm.value.indexOf('__') != -1 || userNameEm.value.indexOf('--') != -1) {
//        $.toast('会员名中划线和下划线不能连续出现','text');
//        userNameEm.focus();
//        return false;
//    }
//    if (!userNameEm.value.match(/^[a-z0-9]{1}[a-z0-9_\-]{0,}[a-z0-9]{1}$/)) {
//        $.toast('会员名限制为小写字母、数字组合','text');
//        userNameEm.focus();
//        return false;
//    }
//
//    // 密码
//    if (passWordEm.value == "") {
//        $.toast('请您设置登录密码','text');
//        passWordEm.focus();
//        return false;
//    }
//    if (passWordEm.value.length < 6 || passWordEm.value.length > 20) {
//        $.toast('密码长度限制为6-20位','text');
//        passWordEm.focus();
//        return false;
//    }
//    // 电子邮箱
//    if (emailEm.value.length < 7 || !emailEm.value.match(/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/)) {
//        $.toast('请填写正确的电子邮箱','text');
//        emailEm.focus();
//        return false;
//    }
//    $.post(AJPath,{action:"member_check", job:"email_exists",value:emailEm.value},
//        function(data){
//            if(data != ""){
//                $.toast(data,'text');
//                emailEm.focus();
//                return false;
//            }
//        }
//    );
//    // 公司名称
//    if($(".company-cell").is(":visible")){
//        if (companyEm.value.length < 4) {
//            $.toast('请填写公司全称','text');
//            companyEm.focus();
//            return false;
//        }
//        $.post(AJPath,{action:"member_check", job:"company_exists",value:companyEm.value},
//            function(data){
//                if(data != ""){
//                    $.toast(data,'text');
//                    companyEm.focus();
//                    return false;
//                }
//            }
//        );
//    }
//    // 真实姓名
//    if (trueNameEm.value.length < 2) {
//        $.toast('请填写真实姓名','text');
//        trueNameEm.focus();
//        return false;
//    }
//
//    // 手机号码
//    if (!mobileEm.value.match(/^1(3|4|5|7|8)\d{9}$/)) {
//        $.toast('请填写正确的手机号码','text');
//        mobileEm.focus();
//        return false;
//    }
//
//    // 验证码
//    if (captchaEm.value.length < 2) {
//        $.toast('请填写验证码','text');
//        captchaEm.focus();
//        return false;
//    }
//    $.post(AJPath,{action:"captcha", result:"string",captcha:captchaEm.value},
//        function(data){
//            if(data != ""){
//                $.toast(data,'text');
//                captchaEm.focus();
//                return false;
//            }
//        }
//    );
//
//
//    alert("注册通过");
//    //el.submit();
//
//
//}
//// 刷新验证码
//function reloadCaptcha() {
//    $('.captcha-img').attr("src","http://www.tecenet.com/api/captcha.png.php?action=image&height=30&refresh="+Math.random().toString(36).substr(6) );
//}
//// 查看明文密码
//$(document).on("click", ".see-password", function(e) {
//    if($(this).hasClass('on')){
//        e.preventDefault();
//        $(this).removeClass('on');
//        $(this).parent().parent().find("input").attr('type', 'password');
//    }else{
//        e.preventDefault();
//        $(this).addClass('on');
//        $(this).parent().parent().find("input").attr('type', 'text');
//    }
//});
//

//
//
//// 企业/个人用户切换
//$(document).on("click", ".register-navbar__item", function() {
//    $(this).addClass("register-navbar__item--on").siblings().removeClass("register-navbar__item--on");
//    if($(this).hasClass("register-navbar__enterprise register-navbar__item--on")){
//        $(".company-cell").show();
//    }else{
//        $(".company-cell").hide();
//    }
//});



