//  校验表单 
function checkSubmit(){
	 var title=document.getElementById("title").value;
	 var content=myeditor.getContent();
	 if(title=='' || title =='请输入标题'){
	  	alert("标题不能为空！");
	  	return false;
	 }
	 if(content=='' || content=='<p>请输入内容</p>'){
	  	alert("内容不能为空！");
	  	return false;
	 }
	 
	 if( filterSqlStr(title)){
	   alert("标题中包含了敏感字符"+sql_str()+"。请重新输入！");
	   return false;
	 }
	// if( filterSqlStr(content)){
	//   alert("内容中包含了敏感字符"+sql_str()+"。请重新输入！");
	//   return false;
	// }

}


//  过滤一些敏感字符函数 
function filterSqlStr(value){
	
	var sqlStr=sql_str().split(',');
	var flag=false;
	
	for(var i=0;i<sqlStr.length;i++){
		
		if(value.toLowerCase().indexOf(sqlStr[i])!=-1){
			flag=true;
			break;
			
		}
	}
	return flag;
}


function sql_str(){
	var str="delete,exec,insert,select,union,update,count,join,outfile,load_file,into";
	return str;
}