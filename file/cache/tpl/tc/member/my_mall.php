<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header', 'member');?>
<script type="text/javascript">c(1);</script>
<?php if($_groupid == 5) { ?>
    <?php $authLinkUrl = DT_PATH.'member/grade.php?sj=yes&groupid=6#UP';?>
    <?php $authLinkTitle = '点这进行开店';?>
    <?php $authTip = "尊敬的<em>".$_username."</em>，您属于<strong>['个人会员']</strong>，您还没有网店哦！没有网店是无法添加产品的！";?>
    <?php $authNote = '(开店是完全免费的，个人也可开店哦)！';?>
<?php include template('no-authority','chip');?>
<?php } else { ?>
    <?php include template('member_mall','mall');?>
<?php } ?>
<?php include template('footer', 'member');?>