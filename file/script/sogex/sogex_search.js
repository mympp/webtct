$(document).ready(function(){
	$.ajax({
		type : 'GET',
		url: 'http://'+window.location.host+'/ajax.php',
		cache : true,
		data : 'action=sogex_related&keyword='+$('#keyword').val()+'&type='+$('#type').val(),
		success:function(data,status){
			if(data != ''){
				var kw = $('#keyword').val();
				var type = $('#type').val();
				$("#rs").css("display","inherit");
				//$("#related").empty();
				//$("#related").append(data);
				var keyword = data.split('|');
				var keyword_str = '<tr>';
				for(var i in keyword){
					if(i == 0) keyword_str += '<th rowspan="3" class="tt">相关搜索</th>';
					
					keyword_str += '<th><a href="search.php?keyword='+keyword[i]+'&type='+type+'" data-type="0">'+keyword[i]+'</a></th><td></td>';
					if(i == 4 || i== 9 || i == 14) keyword_str += '</tr><tr>';
				}
				keyword_str += '</tr>';
				$('#related').html(keyword_str);
			}else{
				$('.mod-relation').css('display','none');
			}
		},
		error:function(XMLHttpRequest, textStatus, errorThrown) {
                    
                }		
	});
});
