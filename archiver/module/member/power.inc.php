<?php 
$MENUMODS2=$MENUMODS;
function models($stype){
global $DT, $db,$DT_TIME,$_userid,$_childusername,$mid,$action,$DT_PRE,$MENUMODS2,$MENUMODS;
$url = $_SERVER['PHP_SELF']; 
$filename=str_replace('.php','',substr( $url , strrpos($url , '/')+1)); 
if($stype=='my.php'){//发布模块权限限制
							if($_childusername)
									{
									$MENUMODS=array();
										$m= $db->get_one("SELECT * FROM {$DT_PRE}member_child WHERE  username='$_childusername' and userid=$_userid");
												if($m){
														 $nactions=$m['modules'];
														 $c=0;
															foreach($MENUMODS2 as $k=>$v) {
																if(strpos('@'.$nactions,'m:['.$v.':')){$MENUMODS[$c]=$v;$c=$c+1;}
															}
															$MYMODS=$MENUMODS;
														 if($nactions){
																		  if(!strpos('@'.$nactions,'m:['.$mid.':')){
																			  if($filename!='my')
																			  message('不具备该模块权限');
																			  }
																		  else
																			{
																			  $actions='@'.getbetween($nactions,'m:['.$mid.':',']');
																			  if($action){
																				  if(!strpos($actions,$action)){message('不具备该模块 '.$action.' 功能 权限');}
																				}
																			  else
																				{
																				  if(!strpos($actions,'read')){message('不具备该模块 处理功能 权限');}
																				}
																		  }
								
															 }
														}
							}
			}
			

if($stype=='member'){//会员中心其他模块权限限制
							if($_childusername)
									{$MENUMODS=array();
										$m= $db->get_one("SELECT * FROM {$DT_PRE}member_child WHERE  username='$_childusername' and userid=$_userid");
										 $nactions=$m['modules'];
										 $nsystems=$m['systems'];
										 $c=0;
											foreach($MENUMODS2 as $k=>$v) {
																if(strpos('@'.$nactions,'m:['.$v.':')){$MENUMODS[$c]=$v;$c=$c+1;}
															}
												if($m){
														 
														 if($nsystems){
																		  if(strpos('@'.$nsystems,';'.$filename.';')){message('不具备该会员系统权限');}
															 }
														}
							}
			}


}
?>