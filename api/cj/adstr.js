function ADstr(bm){
	var str;var bumen;var title;var tel;
	var note = document.getElementById("note").value;
if(bm==0){
	bumen='网';
	title='一家专门为医疗机构、生产厂家和经销商提供专业技术和产品服务的电子商务交易平台，关注我们，千千万万个商业机会等着你 ';
	tel='<a href="tel:4006173599">4006173599</a>';
	Dd('author').value='天成医疗网';
}
if(bm==1){
	bumen='-产品服务部';
	title='天成医疗旗下的产品服务平台，一服务客户为核心，从上游采购到下游销售渠道为客户提供优质的品牌推广、产品招商、销售渠道拓展、供应商经销商资源管理等商务服务 ';
	tel='罗经理：13925025926    微信：yoyo350113956<br>全国服务热线：400-9669-717    \    020-22017986<br>秀仪器网：<a href="http://www.xiu17.com" target="_blank">www.xiu17.com</a><br>微信公众号：xiangdaoyixiesuo';
	Dd('author').value='产品服务部';
}
if(bm==2){
	bumen='-天骄技术';
	title='天骄医疗 专为医疗机构、生产厂商、经销商提供设备安装、调试、巡查、保养、维修等技术服务，及整体打包服务等 ';
	tel='<br>整体打包：<br>技术服务：谭先生13922493350<br>市场服务：孙先生18924606411<br>配件服务：朱女士13924084126';
	Dd('author').value='技术服务部';
}
if(bm==3){
	bumen='-科技服务部';
	title=' 为广大医疗类企业、高校、科研机构提供科研成果转化咨询、临床试验咨询、产品注册、质量体系构建、政府扶持资金项目申报、高新技术企业认定、开放实验室等服务 ';
	tel='<br/>医疗器械注册：<br/>邬总监  13714581143  微信  Wu13714581143  <br/>李经理  13538826148  微信  alex986668  <br/><br/>报证服务：<br/>孙总监  13922198688  微信  sunlifeamtf<br/><br/>政府项目申报:<br/>苏总监  13711488775  微信  13711488775   <br/>梁经理  13826477662  微信  1540367629  <br/>杨经理  15920520642  微信  15920520642';
	Dd('author').value='科技服务部';
}
if(bm==4){
	bumen='-天医工程部';
	title='实验室工程设计与施工、GMP洁净厂房设计与施工、手术室及ICU工程设计与施工、清毒供应室设计与施工，按照医院建设标准，手术室规范、ICU建设标准和医学生物实验室安全要求及15189流程，建设科学，安全，环保的医院工程 ';
	tel='<br>彭先生 13450395715<br>赵先生 18820006578';
	Dd('author').value='天医工程部';
}
if(bm==5){
	bumen='-金融服务部';
	title='天成金融服务事业部依托母公司中山大学达安基因股份有限公司和广州天成医疗技术股份有限公司的资源、技术、人才优势，为<span style="color:red;">医疗机构、生产厂商、经销商</span>提供资金结算、财税咨询等服务。<span style="color:red;">高效、快捷、专业、优质</span> ';
	tel='<br>安小姐：13724026821<br>刘小姐：15920471723<br>邮箱：459779403@qq.com';
	Dd('author').value='金融服务部';
}
if(bm==6){
	bumen='-天康信息';
	title='天康信息，专为医疗机构、生产厂商、经销商免费提供信息化解决方案、免费IT技术服务方案、云服务产品解决方案等 ';
	tel='<br>陈经理：13922341110<br>易经理：15915884533';
	Dd('author').value='天康信息';
}
if(bm==7){
	bumen='-进出口服务部';
	title='天成进出口，领先医疗行业外贸综合服务，提供进出口代理、海外低利率融资、协助科研高校及医院办理免税进口等服务，为医疗产业提供进出口整体解决方案。免基础服务费，让代理成本降到0！<br>更多详情请登录：<a href="http://impexp.tecenet.com">impexp.tecenet.com</a> ';
	tel='方小姐 13922267013';
	Dd('author').value='进出口服务部';
}
if(bm==8){
	bumen='-人力资源部';
	title='医疗行业最值得信赖的人力资源服务平台：主要为广大医疗机构、生产厂商、经销商、医疗从业人员提供招聘 、培训、猎头、人事外包、后勤管理等一站式服务解决方案 ';
	tel='<br>王先生：020-22017981<br>邮箱 job@tecenet.com<br>QQ 1248489983 微信 HR520_Alan<br>余先生：020-22017981-8011<br>手机：13719391315<br>邮箱：YUHL332@163.com<br>微信：YUHL213 <br>天成医疗人才网 www.tecejob.com';
	Dd('author').value='人力资源部';
}
if(bm==9){
	bumen='-电子商务部';
	title='一家专门为医疗机构、生产厂家和经销商提供专业技术和产品服务的电子商务交易平台，关注我们，千千万万个商业机会等着你 ';
	tel='<br>张经理 18588655941 微信2300379865';
	Dd('author').value='电子商务部';
}
if(bm==10){
	bumen='-物流服务事业部（医链通物流）';
	title='一家为医疗机构、生产厂家和经销商提供一体化物流服务平台，包含物流配送、供应链金融、进出口、设备安装调试等一系列增值解决方案';
	tel='<br>业务联系 18026219690  杨先生  微信号：sichang71';
	Dd('author').value='物流服务事业部';
}
if(bm==13){
	bumen='-医养健康事业部';
	title='医养健康事业部利用天成医疗及达安生态圈的优势资源，为医疗机构和医养结合养老项目提供一站式的全面解决方案，并运用互联网工具帮助项目向终端需求人群推广，更好的满足大众健康需求';
	tel='<br>王先生：13725375883 <br>陈先生：13632339055';
	Dd('author').value='医养健康事业部';
}
if(bm==14){
	bumen='-投资服务事业部';
	title='投资服务部依托母公司中山大学达安基因股份有限公司和广州天成医疗技术股份有限公司的资源、技术、人才优势，为医疗机构、医疗生产企业、经销商实行资源整合投资业务，提供涉税筹划、财务管理咨询、财税政府补助，公司股权梳理、工商服务、三会运作、资本运作等服务 ';
	tel='<br/>联系电话：<br/>罗小姐：13710604682<br/>刘先生：13427808833 <br/>微信：13710604682 <br/>13427808833 <br/>邮箱：luoweiqing@tecenet.cn';
	Dd('author').value='投资服务部';
}
if(bm==11){
	if (note) {
		bumen=note.substring(note.indexOf(':')+1,note.lastIndexOf('业务范围'));
		title=note.substring(note.indexOf('：')+1,note.lastIndexOf('网址'));
		url = note.substring(note.indexOf('——')+1,note.lastIndexOf('联系方式'));
		tel=note.substring(note.indexOf('式')+1);
		Dd('author').value='自定义';

		str='<p>&nbsp;&nbsp;</p><p>&nbsp;&nbsp;</p><blockquote class="brcolor" style="margin:0; padding:10px; border-top-width: 3px; border-right-width: 3px; border-bottom-width: 3px; border-style: dotted; border-color: rgb(80, 130, 189); font-size: 17.1428565979004px; white-space: normal; border-radius: 5px !important;"><h3 style="color: rgb(89, 89, 89); font-size: 14px; margin: 0px;"><span style="color: rgb(255, 255, 255); padding: 2px 5px; font-size: 16px; margin-right: 15px; border-radius: 5px !important; background-color: rgb(80, 130, 189);">'+bumen+'</span></h3><p><span style="font-size: 16px;"><span style="font-size: 16px; margin: 0px; padding: 0px; max-width: 100%; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;"></span>'+title+'。</span></p><p><span style="font-size: 16px;"><br>更多服务内容请登录<br><strong style="margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important;"><span style="font-size: 16px; margin: 0px; padding: 0px; max-width: 100%; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;">'+url+'</span></strong></span></p><p><span style="font-size: 16px;"><br>服务热线<span style="font-size: 16px; margin: 0px; padding: 0px; max-width: 100%; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;">'+tel+'</span></span></p></blockquote><p>&nbsp;&nbsp;</p><p>&nbsp;&nbsp;</p>';
	}else{
		document.getElementById('note_content').style.cssText='display:block;';

	}
	return str;
}
if (bm==12) {
	var note_ct = document.getElementById('note_ct').value;

	bumen=note_ct.substring(note_ct.indexOf(':')+1,note_ct.lastIndexOf('业务范围'));
	title=note_ct.substring(note_ct.indexOf('：')+1,note_ct.lastIndexOf('网址'));
	url = note_ct.substring(note_ct.indexOf('——')+1,note_ct.lastIndexOf('联系方式'));
	tel=note_ct.substring(note_ct.indexOf('式')+1);
	Dd('author').value='自定义';

	str='<p>&nbsp;&nbsp;</p><p>&nbsp;&nbsp;</p><blockquote class="brcolor" style="margin:0;padding:10px; border-top-width: 3px; border-right-width: 3px; border-bottom-width: 3px; border-style: dotted; border-color: rgb(80, 130, 189); font-size: 17.1428565979004px; white-space: normal; border-radius: 5px !important;"><h3 style="color: rgb(89, 89, 89); font-size: 14px; margin: 0px;"><span style="color: rgb(255, 255, 255); padding: 2px 5px; font-size: 16px; margin-right: 15px; border-radius: 5px !important; background-color: rgb(80, 130, 189);">'+bumen+'</span></h3><p><span style="font-size: 16px;"><span style="font-size: 16px; margin: 0px; padding: 0px; max-width: 100%; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;"></span>'+title+'。</span></p><p><span style="font-size: 16px;">更多服务内容请登录<br><strong style="margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important;"><span style="font-size: 16px; margin: 0px; padding: 0px; max-width: 100%; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;">'+url+'</span></strong></span></p><p><span style="font-size: 16px;">服务热线<span style="font-size: 16px; margin: 0px; padding: 0px; max-width: 100%; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;">'+tel+'</span></span></p></blockquote><p>&nbsp;&nbsp;</p><p>&nbsp;&nbsp;</p>';
	return str;
}
if(bm==-1){
	return '';
}


str='<p>&nbsp;&nbsp;</p><p>&nbsp;&nbsp;</p><blockquote class="brcolor" style="margin:0;padding:10px; border-top-width: 3px; border-right-width: 3px; border-bottom-width: 3px; border-style: dotted; border-color: rgb(80, 130, 189); font-size: 17.1428565979004px; white-space: normal; border-radius: 5px !important;"><h3 style="color: rgb(89, 89, 89); font-size: 14px; margin: 0px;"><span style="color: rgb(255, 255, 255); padding: 2px 5px; font-size: 16px; margin-right: 15px; border-radius: 5px !important; background-color: rgb(80, 130, 189);">天成医疗'+bumen+'</span></h3><p><span style="font-size: 16px;"><span style="font-size: 16px; margin: 0px; padding: 0px; max-width: 100%; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;"></span>'+title+'。</span></p><p><span style="font-size: 16px;">服务热线：<span style="font-size: 16px; margin: 0px; padding: 0px; max-width: 100%; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;">'+tel+'</span></span></p><p><span style="margin: 0px; padding: 0px; max-width: 100%; font-family: 宋体; font-size: 16px; box-sizing: border-box !important; word-wrap: break-word !important;"><p><span style="font-size: 16px;">更多服务内容请登录<br>天成医疗网：<strong style="margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important;"><span style="font-size: 16px; margin: 0px; padding: 0px; max-width: 100%; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;">www.tecenet.com</span></strong></span></p>微信公众号：<strong style="margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important;"><span style="margin: 0px; padding: 0px; max-width: 100%; font-size: 16px; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;">tianchengyiliao</span></strong></span></p></blockquote><p>&nbsp;&nbsp;</p><p>&nbsp;&nbsp;</p>';
return str;
}
