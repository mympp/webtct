<?php defined('IN_DESTOON') or exit('Access Denied');?><?php 
if($moduleid == 16){
$head_css = [DT_SKIN.'tc.chanpin.base.css'];
}
?>
<?php $sitemenu=$module;$listpage='list';?>
<?php dhttp(404, $DT_BOT);?>
<?php include template('module-header');?>
<style>
    .webmenu{position: relative;height: 40px;background-color: #e56639;border-top: 1px solid #C76834;}
    .webmenu a{color: #fff;font-size: 16px;}
    .webmenu .youcan{position: absolute;left:50%;margin-left:-600px;}
    .webmenu .youcan h1>a{float: left;line-height:39px;padding:0 20px;}
    .webmenulist{position: absolute;top:0;left: 50%;margin-left:-538px;width:800px;float: left;line-height:39px;}
    .webmenulist .menun{float: left;padding: 0 20px;}
    .webmenulist .menun:hover,.webmenu .youcan h1>a:hover{background-color: #cc5429;}
    #mstatus{position: absolute;right:50%;margin-right:-600px;}
    .webw{margin:60px auto !important;color: #666;line-height:1.5;}
    .webw h1{font-size: 20px;}
    .webw a,#second{color: #e56639;}
    .webw form{margin-top: 20px;}
    .webw form input {height:24px;padding:5px 10px;line-height:24px;border:1px solid #eaeaea;float: left;outline:none;}
    .webw form input[type="text"]{border-right: none;}
    .webw form input[type="submit"] {box-sizing: content-box;background-color: #e56639;color: #fff;}
</style>
<script type="text/javascript">var i=30;</script>
<div class="webw" style="margin: 30px auto;width: 800px;">
<div class="center" >
<div style="background:url('<?php echo DT_SKIN;?>image/error.png') left center no-repeat; padding-left:150px;">
<h1><?php echo $head_title;?></h1><br/>
&nbsp;&nbsp;<span id="second" class="f_red f_b"><script type="text/javascript">document.write(i);</script></span> 秒后将自动跳转到<a href="<?php echo $MOD['linkurl'];?>"><?php echo $MOD['name'];?>首页</a>
<br/><br/>
&nbsp;&nbsp;1、请检查输入的网址是否正确。 <br/>
&nbsp;&nbsp;2、如果不能确认输入的网址，请浏览<a href="<?php echo $MOD['linkurl'];?>"><?php echo $MOD['name'];?>首页</a>来查看所要访问的网址。 <br/>
&nbsp;&nbsp;3、直接输入要访问的内容进行搜索： <br/>
<form action="<?php echo $MOD['linkurl'];?>search.php">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="25" name="kw" /> 
<input type="submit" value="搜索" class="btn" onmouseover="this.clasName='btny'" onmouseout="this.clasName='btn'"/>
</form>
</div>
</div>
</div>
<script type="text/javascript">
function Go(u) {window.location = u;}
var interval=window.setInterval(
function() {
if(i==0) {
Go('<?php echo $MOD['linkurl'];?>');
clearInterval(interval);
} else {
document.getElementById('second').innerHTML=i;
i--;
}
}, 
1000);
</script>
<?php include template('footer2017');?>