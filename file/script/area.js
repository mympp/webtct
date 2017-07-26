/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt
*/
/*
date:2015-5-25
who:chentao
what:添加load_area_count函数
*/
var area_id;
function load_area(areaid, id) {
	area_id = id; area_areaid[id] = areaid;
	$.post(AJPath, 'action=area&area_title='+area_title[id]+'&area_extend='+area_extend[id]+'&area_id='+area_id+'&areaid='+areaid, function(data) {
		$('#areaid_'+area_id).val(area_areaid[area_id]);
		if(data) $('#load_area_'+area_id).html(data);
	});
}
/*V5.0 升级 V6.0 移除
function into_area() {   
	if(xmlHttp.readyState==4 && xmlHttp.status==200) {
		Dd('areaid_'+area_id).value = area_areaid[area_id];
		if(xmlHttp.responseText) Dd('load_area_'+area_id).innerHTML = xmlHttp.responseText;
	}
}
*/

function load_area_count(areaid,id){
	area_id = id; area_areaid[id] = areaid;
	//makeRequest('action=areacount&area_title='+area_title[id]+'&area_extend='+area_extend[id]+'&area_id='+area_id+'&areaid='+areaid, AJPath, 'into_area');
	$.post(AJPath, 'action=areacount&area_title='+area_title[id]+'&area_extend='+area_extend[id]+'&area_id='+area_id+'&areaid='+areaid, function(data) {
		$('#areaid_'+area_id).val(area_areaid[area_id]);
		$('#areaid_1').val(area_areaid[area_id]);
		if(data) $('#load_area_'+area_id).html(data);
	});
}