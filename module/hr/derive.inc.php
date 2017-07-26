<?php
/*
time:2015-11-10
who:周创杰
where:简历导出功能
relation:module\hr\admin\template\resume_index.tpl.php,module\hr\admin\template\derive.tpl.php,,module\hr\admin\resume.inc.php
*/
	defined('IN_DESTOON') or exit('Access Denied');
	//初始化系统
	//require './../../../../common.inc.php';
	//接收前台请求
	$itemid=isset($_GET['itemid'])?$_GET['itemid']:$itemid;
	//简历内容查询
	$sql="select catid,itemid,situation,areaid,gender,skill,minsalary,education,marriage,language,maxsalary,keyword,truename,thumb,birthday,height,weight,school,major,experience,introduce,mobile,email,nplace,education_id,information_id,experience_id,train_id,language_id,politicsstatus,dutytime,hopeplace from {$db->pre}hr_resume where itemid in($itemid)";
	//执行查询语句
	$rourse=$db->query($sql);
	
	//var_dump($rourse);
	//定义空数组
	$arr=array();
	//遍历查询结果.将其赋值到空数组中
	while($row=$db->fetch_array($rourse)){
		$arr[]=$row;
	}
	//查询登录的用户属于哪种会员
	$sql="select groupname from {$db->pre}member_group a inner join (select groupid from {$db->pre}member where username = '$_username') b on a.groupid=b.groupid";
	$member=$db->get_one($sql);
	
	if(!$member){			
	//用户未登陆
		echo "<script>alert('无权限下载简历');history.back();</script>";
		exit;
	}
	
	$length=count($arr);
	//按照用户的会员分组给出可一次性导出简历的份数
	if($length>20&&$member['groupname']!='管理员'){
		echo "<script>alert('由于您不是管理员,所以一次最多只能导出20份简历');history.back();</script>";
		exit;
	}
	if($member['groupname']!='VIP会员'&&$member['groupname']!='管理员'&&$length>10){
		echo "<script>alert('由于您不是VIP会员,所以一次最多只能导出10份简历');history.back();</script>";
		exit;
	}
	$fileNameArr=array();
	//for循环开始
	for($i=0;$i<$length;$i++){
		//文件名
		$filename=DT_ROOT.'/file/temp/'.$arr[$i]['itemid'].".doc";
		//"./temp/".$arr[$i]['itemid'].".doc";	
		//开启缓存
		ob_start();
		//求职状态
		//数组长度
		switch($arr[$i]['situation']){
			case 0:
				$job_state='目前正在找工作';
				break;
			case 1:
				$job_state='观望有好机会再考虑';
				break;
			case 2:
				$job_state='半年内无换工作计划';
				break;
		}
		//性别
		switch($arr[$i]['gender']){
			case 1:
				$gender="男士";
				break;
			case 2:
				$gender="女士";
				break;
		}
		//学历
		switch($arr[$i]['education']){
			case 1:
				$education="初中";
				break;
			case 2:
				$education="高中";
				break;
			case 3:
				$education="中专";
				break;
			case 4:
				$education="大专";
				break;
			case 5:
				$education="本科";
				break;
			case 6:
				$education="硕士";
				break;
			case 7:
				$education="博士";
				break;
		}
		//婚姻状况
		switch($arr[$i]['marriage']){
			case 1:
				$marriage="未婚";
				break;
			case 2:
				$marriage="已婚";
				break;
		}
		//居住地
		//市级地区
		$sql="select areaname,parentid from {$db->pre}area where areaid=".$arr[$i]['areaid'];
		//执行查询语句
		$city_area=$db->get_one($sql);
		//省级地区
		$sql="select areaname from {$db->pre}area where parentid=".$city_area['parentid'];
		$pro_area=$db->get_one($sql);
		//期望职位
		$sql="select catname from {$db->pre}category where catid=".$arr[$i]['catid'];
		$post=$db->get_one($sql);
		//自我鉴定
		$sql="select content from {$db->pre}hr_resume_data where itemid=".$arr[$i]['itemid'];
		$content=$db->get_one($sql);
		//判断期望薪资是否为面议
		if($arr[$i]['minsalary']==0||$arr[$i]['maxsalary']==0){
			$alary="面议";
		}else{
			$alary=$arr[$i]['minsalary'].'-'.$arr[$i]['maxsalary'];
		}
			
?>
	<!--简历内容-->
		<table width="778" cellpadding="0" border="0" align="center">
			<tbody>
				<tr>
					<td>
						<table width="760" cellspacing="0" cellpadding="0" border="0" align="center" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; MARGIN: 0px auto; BORDER-RIGHT-WIDTH: 0px">
							<tbody>
								<tr>
									<td valign="top">
										<table width="760" cellspacing="0" cellpadding="0" border="0" align="center">
												<tr>
													<td align="center"><b><?php echo $arr[$i]['truename'];?>个人简历</b></td>
												<tr>
										</table>
										<table width="760" cellspacing="0" cellpadding="0" border="0" align="center">
											<tbody>
												<tr>
													<td valign="top" style="font-size:12px;">
														<table width="97%" cellspacing="0" cellpadding="0" border="0" align="center" style="PADDING-RIGHT: 0px; PADDING-LEFT: 8px; PADDING-BOTTOM: 0px; MARGIN: 8px auto; LINE-HEIGHT: 22px;">
															<tr>
																<td colspan="5" height="30" width="100%" bgcolor="#F1F1F1" align="left">
																 <b>基础信息</b>
																</td>
															</tr>
															<tr>
																<td colspan="5" width="100%" height="5"></td>
															</tr>
															<tr>
																<td width="10%" height="20" style="font-size:13px;">姓&nbsp;&nbsp;名：</td>
																<td width="42%" height="20" style="font-size:13px;"><?php echo $arr[$i]['truename'];?></td>
																<td width="11%" height="20" style="font-size:13px;">性&nbsp;&nbsp;别：</td>
																<td width="20%" height="20" style="font-size:13px;"><?php echo $gender;?></td>
																<td width="20%" valign="middle" align="center" rowspan="6">
																<img width="90" height="110" src="<?php echo $arr[$i]['thumb'];?>">
																</td>
															</tr>
															<tr>
																<td width="10%" height="20" style="font-size:13px;">生&nbsp;&nbsp;日：</td>
																<td width="42%" height="20" style="font-size:13px;"><?php echo $arr[$i]['birthday'];?></td>
																<td width="11%" height="20" style="font-size:13px;">婚姻状况：</td>
																<td width="20%" height="20" style="font-size:13px;"><?php echo $marriage;?></td>
															</tr>
															<tr>
																<td width="10%" height="20" style="font-size:13px;">身&nbsp;&nbsp;高：</td>
																<td width="42%" height="20" style="font-size:13px;"><?php echo $arr[$i]['height'];?> cm</td>
																<td width="11%" height="20" style="font-size:13px;">体&nbsp;&nbsp;重：</td>
																<td width="20%" height="20" style="font-size:13px;"><?php echo $arr[$i]['weight']?> kg</td>
															</tr>
															<tr>
																<td width="10%" height="20" style="font-size:13px;">居 住 地：</td>
																<td width="42%" height="20" style="font-size:13px;"><?php echo $city_area['areaname'];?></td>
																<td width="11%" height="20" style="font-size:13px;">籍&nbsp;&nbsp;贯：</td>
																<td width="20%" height="20" style="font-size:13px;"><?php echo $arr[$i]['nplace'];?></td>
															</tr>
															<tr>
																<td width="10%" height="20" style="font-size:13px;">毕业院校：</td>
																<td width="42%" height="20" style="font-size:13px;"><?php echo $arr[$i]['school'];?></td>
																<td width="11%" height="20" style="font-size:13px;">专&nbsp;&nbsp;业：</td>
																<td width="20%" height="20" style="font-size:13px;"><?php echo $arr[$i]['major'];?></td>
															</tr>
															<tr>
																<td width="10%" height="20" style="font-size:13px;">学&nbsp;&nbsp;历：</td>
																<td width="42%" height="20" style="font-size:13px;"><?php echo $education;?></td>
																<td width="11%" height="20" style="font-size:13px;">工作经验：</td>
																<td width="20%" height="20" style="font-size:13px;"><?php echo $arr[$i]['experience'];?>年</td>
															</tr>
															<tr>
																<td width="10%" height="20" style="font-size:13px;">行业意向：</td>
																<td width="42%" height="20" style="font-size:13px;"></td>
																<td width="11%" height="20" style="font-size:13px;">职位意向：</td>
																<td colspan="2" width="20%" height="20" style="font-size:13px;"><?php echo $post['catname'];?></td>
															</tr>
															<tr>
																<td width="10%" height="20" style="font-size:13px;">专业技能：</td>
																<td width="42%" height="20" style="font-size:13px;"><?php echo $arr[$i]['skill']?></td>
																<td width="11%" height="20" style="font-size:13px;">政治面貌：</td>
																<td colspan="2" width="20%" height="20" style="font-size:13px;"><?php echo $arr[$i]['politicsstatus'];?></td>
															</tr>
															<tr>
																<td width="10%" height="20" style="font-size:13px;">期望薪资：</td>
																<td width="42%" height="20" style="font-size:13px;"><?php echo $alary;?></td>
																<td width="11%" height="20" style="font-size:13px;">求职状态：</td>
																<td colspan="2" width="20%" height="20" style="font-size:13px;"><?php echo $job_state;?></td>
															</tr>
															<tr>
																<td width="10%" height="20" style="font-size:13px;">到岗时间：</td>
																<td width="42%" height="20" style="font-size:13px;"><?php echo $arr[$i]['dutytime'];?></td>
																<td width="11%" height="20" style="font-size:13px;">期望工作地点：</td>
																<td colspan="2" width="20%" height="20" style="font-size:13px;"><?php echo $arr[$i]['hopeplace'];?></td>
															</tr>
															<tr>
																<td width="10%" height="20" style="font-size:13px;">手&nbsp;&nbsp;机：</td>
																<td width="42%" height="20" style="font-size:13px;"><?php echo $arr[$i]['mobile'];?></td>
																<td width="11%" height="20" style="font-size:13px;">邮&nbsp;&nbsp;箱：</td>
																<td colspan="2" width="20%" height="20" style="font-size:13px;"><?php echo $arr[$i]['email'];?></td>
															</tr>
															<tr>
																<td colspan="5" width="100%" height="5"></td>
															</tr>
														</table>
														<?php if(!empty($arr[$i]['experience_id'])){$experience_arr=explode(',',trim($arr[$i]['experience_id'],','));?>
														<table width="97%" cellspacing="0" cellpadding="0" align="center" border="0" style="PADDING-RIGHT: 0px; PADDING-LEFT: 8px; PADDING-BOTTOM: 0px; MARGIN: 8px auto; LINE-HEIGHT: 22px;">
															<tbody>
															<tr>
																<td colspan="2" height="30" width="100%" bgcolor="#F1F1F1" align="left">
																 <b>工作经历</b>
																</td>
															</tr>
															<tr>
																<td width="100%" height="10"></td>
															</tr>
															<?php foreach($experience_arr as $k=>$v){$exp_data=$db->get_one("select * from {$db->pre}hr_resume_experience where experience_id=".$v);?>
															<tr>
															<td valign="middle" align="left" colspan="2">
																	<table width="100%" cellspacing="0" cellpadding="0" border="0">
																		<tbody>
																			<tr>
																				<td class="text_left" style="font-size:13px;" height="23">
																				<?php echo $exp_data['start_time'];?>至<?php echo $exp_data['stop_time'];?>：
																				<b><?php echo $exp_data['company_name'];?></b>
																				（<?php echo $exp_data['company_nature'];?>） [ 规模：<?php echo $exp_data['scale'];?> ]
																				</td>
																				</tr>
																				<tr>
																				<td width="100%" valign="top" align="left" style="font-size:13px;" height="23">
																				<p class="TextinTable">
																				职位名称：
																				<b><?php echo $exp_data['position']?></b>
																						[ 薪资：<?php echo $exp_data['pay'];?> ]
																				</p>
																				</td>
																				</tr>
																				<tr>
																				<td width="100%" valign="top" align="left" style="font-size:13px;" height="23">
																				<p class="TextinTable"> 行业：<?php echo $exp_data['industry'];?></p>
																				</td>
																				</tr>
																				<tr>
																				<td width="100%" valign="top" align="left" style="font-size:13px;" height="23">
																				<p class="TextinTable"> 描述：</p>
																				</td>
																				</tr>
																				<tr>
																				<td id="Cur_Val" class="TextinTable" width="100%" valign="top" align="left" height="23" style="font-size:13px;line-height:23px;">&nbsp;&nbsp;<?php echo $exp_data['ex_describe']?></td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															<tr>
																<td width="100%"><hr/></td>
															</tr>
															</tr>
															<?php }?>
															</tbody>
														</table>
														<?php }?>
														<?php if(!empty($arr[$i]['education_id'])){$education_arr=explode(',',trim($arr[$i]['education_id'],','));?>
														<table width="97%" cellspacing="0" cellpadding="0" border="0" align="center" style="PADDING-RIGHT: 0px; PADDING-LEFT: 8px; PADDING-BOTTOM: 0px; MARGIN: 8px auto; LINE-HEIGHT: 22px;">
															<tbody>
																<tr>
																	<td colspan="2" height="30" width="100%" bgcolor="#F1F1F1" align="left">
																	<b>教育经历</b>
																	</td>
																</tr>
																<?php foreach($education_arr as $k=>$v){$edu_data=$db->get_one("select * from {$db->pre}hr_resume_education where education_id=".$v);?>
																<tr>
																	<td valign="middle" align="left" colspan="2">
																		<table class="table_set" width="100%" cellspacing="0" cellpadding="0" border="0">
																			<tbody>
																				<tr>
																					<td colspan="4" width="100%" height="10"></td>
																				</tr>
																				<tr>
																					<td class="text_left" width="22%" style="font-size:13px;"><?php echo $edu_data['start_time'];?>至<?php echo $edu_data['stop_time'];?></td>
																					<td class="text TextinTable" width="33%" style="font-size:13px;">
																					<?php echo $edu_data['school_name'];?>
																					</td>
																					<td class="text" width="30%" style="font-size:13px;"><?php echo $edu_data['major'];?></td>
																					<td class="text" width="15%" style="font-size:13px;"><?php echo $edu_data['education'];?></td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
																<?php }?>
															</tbody>
														</table>
														<?php }?>
														<?php if(!empty($arr[$i]['information_id'])){$information_arr=explode(',',trim($arr[$i]['information_id'],','));?>
														<table width="97%" cellspacing="0" cellpadding="0" border="0" align="center" style="PADDING-RIGHT: 0px; PADDING-LEFT: 8px; PADDING-BOTTOM: 0px; MARGIN: 8px auto; LINE-HEIGHT: 22px;">
															<tbody>
																<tr width="100%">
																	<td colspan="4" width="100%" height="10"></td>
																</tr>
																<tr>
																	<td colspan="4" height="30" width="100%" bgcolor="#F1F1F1" align="left">
																	<b>学生信息</b>
																	</td>
																</tr>
																<?php foreach($information_arr as $k=>$v){$inf_data=$db->get_one("select * from {$db->pre}hr_resume_student_information where information_id =".$v);?>
																<tr>
																	<td valign="middle" height="20" align="left" colspan="2">
																		<table class="table_set" width="100%" cellspacing="0" cellpadding="0" border="0">
																			<tbody>
																			<tr>
																				<td colspan="6" width="100%" height="10"></td>
																			</tr>
																			<tr>
																				<td class="text_left" height="23" width="25%" style="font-size:13px;"><?php echo $inf_data['start_time'];?>至<?php echo $inf_data['stop_time'];?></td>
																				<td class="text" height="23" style="font-size:13px;line-height:17px;"><?php if($inf_data['sn_category']==0){echo "获得奖励";}else if($inf_data['sn_category']==1){echo "担任职务";}else{echo "参与实践";}?>：<?php echo $inf_data['value'];?></td>
																			</tr>
																			<?php if(!empty($inf_data['practice'])){?>
																			<tr>
																				<td id="Cur_Val" height="23" valign="top" colspan="6" style="font-size:13px;line-height:23px;">&nbsp;&nbsp;<?php echo $inf_data['practice'];?></td>
																			</tr>
																			<?php }?>
																			</tbody>
																			
																		</table>
																	</td>
																</tr>
																<tr width="100%">
																	<td colspan="4"><hr/></td>
																</tr>
																<?php }?>
															</tbody>
														</table>
														<?php }?>
														<?php if(!empty($arr[$i]['train_id'])){$education_arr=explode(',',trim($arr[$i]['train_id'],','));?>
														<table width="97%" cellspacing="0" cellpadding="0" border="0" align="center" style="PADDING-RIGHT: 0px; PADDING-LEFT: 8px; PADDING-BOTTOM: 0px; MARGIN: 8px auto; LINE-HEIGHT: 22px;">
															<tbody>
																<tr>
																	<td colspan="2" height="30" width="100%" bgcolor="#F1F1F1" align="left">
																	<b>培训经历</b>
																	</td>
																</tr>
																<?php foreach($education_arr as $k=>$v){$edu_data=$db->get_one("select * from {$db->pre}hr_resume_education where education_id=".$v);?>
																<tr>
																	<td valign="middle" align="left" colspan="2">
																		<table class="table_set" width="100%" cellspacing="0" cellpadding="0" border="0">
																			<tbody>
																				<tr>
																					<td colspan="4" width="100%" height="10"></td>
																				</tr>
																				<tr>
																					<td class="text_left" width="22%" style="font-size:13px;"><?php echo $edu_data['start_time'];?>至<?php echo $edu_data['stop_time'];?></td>
																					<td class="text TextinTable" width="33%" style="font-size:13px;">
																					<?php echo $edu_data['school_name'];?>
																					</td>
																					<td class="text" width="30%" style="font-size:13px;"><?php echo $edu_data['major'];?></td>
																					<td class="text" width="15%" style="font-size:13px;"><?php echo $edu_data['education'];?></td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
																<?php }?>
															</tbody>
														</table>
														<?php }?>
														<?php if(!empty($arr[$i]['language_id'])){$language_arr=explode(',',trim($arr[$i]['language_id'],','));?>
														<table width="97%" cellspacing="0" cellpadding="0" border="0" align="center" style="PADDING-RIGHT: 0px; PADDING-LEFT: 8px; PADDING-BOTTOM: 0px; MARGIN: 8px auto; LINE-HEIGHT: 22px;">
															<tbody>
																<tr width="100%">
																	<td colspan="2" width="100%" height="10"></td>
																</tr>
																<tr>
																	<td colspan="2" height="30" width="100%" bgcolor="#F1F1F1" align="left">
																	<b>语言能力</b>
																	</td>
																</tr>
																<tr width="100%">
																	<td colspan="2" width="100%" height="10"></td>
																</tr>
																<?php foreach($language_arr as $k=>$v){$lang_data=$db->get_one("select * from {$db->pre}hr_resume_language where language_id =".$v);?>
																<tr>
																	<td style="width:85%">
																		<table class="table_set" width="100%" cellspacing="0" cellpadding="0" border="0">
																			<tbody>
																				<tr height="25">
																					<td class="text_left" width="127" style="font-size:13px;"><?php echo $lang_data['catetory'];?>（<?php echo $lang_data['grasp'];?>） </td>
																					<td class="text"  width="250" style="font-size:13px;"> 听说（<?php echo $lang_data['l_say'];?>），读写（<?php echo $lang_data['r_write'];?>） </td>
																					<td class="text_left" style="font-size:13px;">英语等级：<?php echo $lang_data['grade'];?></td>
																				</tr>
																				
																			</tbody>
																		</table>
																	</td>
																</tr>
																<?php }?>
															</tbody>
														</table>
														<?php }?>
														<?php if(!empty($content['content'])){?>
														<table width="97%" cellspacing="0" cellpadding="0" border="0" align="center" style="PADDING-RIGHT: 0px; PADDING-LEFT: 8px; PADDING-BOTTOM: 0px; MARGIN: 8px auto; LINE-HEIGHT: 22px;">
															<tbody>
																<tr width="100%">
																	<td colspan="2" width="100%" height="10"></td>
																</tr>
																<tr>
																	<td colspan="2" height="30" width="100%" bgcolor="#F1F1F1" align="left">
																	<b>自我鉴定</b>
																	</td>
																</tr>
																<tr width="100%">
																	<td colspan="2" width="100%" height="10"></td>
																</tr>
																<tr>
																	<td colspan="2" width="100%" style="font-size:13px;line-height:23px;">&nbsp;&nbsp;<?php echo strip_tags($content['content']);?></td>
																</tr>
															</tbody>
														</table>
														<?php }?>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
<?php
	
	//获取缓存内容
	$html_1=ob_get_contents();
	//将缓存内容生成doc文件
	file_put_contents($filename,$html_1);
	//存储文件路径的数组;
	$fileNameArr[$i]=$filename;
	//for循环结束
	}
	
	//判断导出的简历数量是否大于1,判断成立则打包简历文件,输出压缩包,否则直接输出简历文件
	if($length>1){
		$filename_1 =DT_ROOT."/file/temp/".date ( 'YmdH' ) . ".zip"; // 最终生成的压缩包名
		$zip = new ZipArchive ();//实例化压缩文件类
		$zip->open($filename_1, ZIPARCHIVE::CREATE);
		foreach ($fileNameArr as $key=>$val ) {
			$zip->addFile ($val,$arr[$key]['itemid'].'-'.iconv('utf-8', 'gbk', $arr[$key]['truename']).'.doc');
		}
		//$zip->close (); // 关闭
		$close=$zip->close(); // 关闭
		//对压缩文件进行加密
		//system("E:\解压器\rar.exe a -ptecenet {$filename_1}");
		//打开文件
		//$file = fopen($filename_1, "r");
		//返回的文件类型
		//Header("Content-type: application/octet-stream");
		Header("Content-type: application/force-download");
		//按照字节大小返回
		//Header("Accept-Ranges: bytes");
		//返回文件的大小
		//Header("Accept-Length: " . filesize($filename_1));
		//客户端的弹出对话框对应的文件名
		Header("Content-Disposition: attachment; filename=resume.zip");
		//一次只传输1024个字节的数据给客户端
		//向客户端回送数据
		//$buffer = 1024; 
		//判断文件是否读完
		//while (!feof($file)) {
			//将文件读入内存
			//$file_data = fread($file, $buffer);
			//输出文件
			//echo $file_data;
		echo readfile($filename_1);
		//}
		 //关闭文件
		//fclose($file);
		//删除压缩包
		unlink($filename_1);
	}else{
		header("Content-Type:   application/msword");       
		header("Content-Disposition:   attachment;   filename={$arr[0]['truename']}.doc"); //指定文件名称  
		header("Pragma:   no-cache");
		header("Expires:   0");
	}
	//删除doc文件
	for($i=0;$i<count($fileNameArr);$i++){
		unlink($fileNameArr[$i]);
	}
?>