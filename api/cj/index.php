<?php
require '../../common.inc.php';
require '../../include/post.func.php';
require 'downloadImageFromQzone.php';
$moduleid='29';
$module='weixin';
$files='index.php';
require 'datactrl.php';
require 'rule.php';
$catid=2162;
global $DT_TIME;
$url='';
if(@$_REQUEST['urls'])$url = @$_REQUEST['urls'];
if(@$_REQUEST['action'])$action = @$_REQUEST['action'];
if(@$_REQUEST['password'])$password = @$_REQUEST['password'];
if(@$_REQUEST['itemid'])$itemid =@intval($_REQUEST['itemid']);

if($password=='tece1108'){set_cookie('pwd',$password,time);echo "<script>location.href='index.php';</script>";exit;}
if($password=='no'){set_cookie('pwd','0',time-3600);echo "<script>location.href='index.php';</script>";exit;}

include 'template/header.html';
if($action==''){
	include 'template/caiji.html';include 'template/main.html';include 'template/foot.html';
	//默认页面显示
}else{//有动作的开始
			if($action=='caiji'&&$url){//提交了采集网址
				$note = DT_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/note.php';
				$note = file_get($note);
				if($note) {
					$note = substr($note, 13);
				} else {
					$note = $MOD['usernote'];
				}
				$d=gethttpcode($url);
				$title=$d['title'];
				$content=$d['content'];
				$url=$d['url'];
				$itemid=$d['itemid'];
				if ($d['isQQ']) {
					$isQQ = $d['isQQ'];
				} else {
					$isQQ = 0;
				}
				include 'template/add.html';
			}//提交了采集网址
			elseif($action=='addnew'){//手动添加内容
				$note = DT_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/note.php';
				$note = file_get($note);
				if($note) {
					$note = substr($note, 13);
				} else {
					$note = $MOD['usernote'];
				}
				//var_dump($note);
				if ($_GET['itemid']) {
					$j = infoedit($module,$moduleid,$itemid);
					$title=$j['title'];
					$content=$j['content'];
					$catid = $j['catid'];
					$itemid = $_GET['itemid'];
					$thumb=$j['thumb'];
				}else{
					$title='请输入标题';
					$content='请输入内容';
					$url='';
					$itemid='';
				}
				include 'template/add.html';

			}elseif ($action=='addsave') {
				$itemid = $_POST['itemid'];
				$thumb = $_POST['thumb'];
				$title = $_POST['title'];
				$fromurl = $_POST['fromurl'];
				$content = $_POST['content'];
				$author = $_POST['author'];
				$catid = $_POST['catid'];

				$note = $_POST['note'];
				$note = '<?php exit;?>'.htmlspecialchars(stripslashes($note));
				file_put(DT_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/note.php', $note);

				if(!$catid)$catid=2162;
				if($_username){$username=$_username;}else{$username='bluewolf';}
				$status=2;
				if ($_POST['isQQ'] && ($_POST['isQQ'] == 1)) {
					$status=3;
				}
				if($_groupid==1||$_groupid==8||get_cookie('pwd')){$status=3;}
				infoadd($module,$moduleid,$title,$catid,$content,$username,$status,$thumb,$fromurl,$itemid,$author);

				//添加到资讯
	            if (!empty($zixun)){
	                $zsql = $db->query("SELECT 'itemid' FROM `tc_article_21` WHERE title='$title'");
	                if (mysql_num_rows($zsql) < 1) {
	                    $res = $db->query("INSERT INTO `tc_article_21` (`catid`, `title`, `author`, `fromurl`, `thumb`, `username`, `addtime`, `status`, `note`) VALUES ('".$zixun."','".$title."','".$author."','".$fromurl."','".$thumb."','".$username."','".$addtime."','".$status."','".$note."')");
	                    $last_id = $db->query("SELECT LAST_INSERT_ID()");
	                    $row=mysql_fetch_array($last_id);
	                    /*print_r($row['LAST_INSERT_ID()']);
	                    exit();*/

	                    $linkurl = "show-".$row['LAST_INSERT_ID()'].".html";
	                    $db->query("UPDATE `tc_article_21` SET linkurl='".$linkurl."' WHERE itemid=".$row['LAST_INSERT_ID()']);

	                    $db->query("INSERT INTO `tc_article_data_21` (`itemid`, `content`) VALUES ('".$row['LAST_INSERT_ID()']."','".$content."')");
	                    if (!empty($row['LAST_INSERT_ID()'])) {
	                        echo "<br />文章转载成功！itemid:".$row['LAST_INSERT_ID()'];
	                    }
	                }else{
	                    echo "<br />数据已经存在！";
	                }
	            }

			}elseif ($action=='del') {
				echo delinfo($module,$moduleid,$_GET['itemid']);
			}elseif ($action=='login') {
				include 'template/login.html';
			}


}

?>
