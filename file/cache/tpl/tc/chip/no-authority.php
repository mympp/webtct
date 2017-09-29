<?php defined('IN_DESTOON') or exit('Access Denied');?>
<?php if(!empty($authTip)) { ?>
<style>
    .no-authority{margin-top:60px;text-align: center;}
    .no-authority p{font-size: 14px;margin: 25px 0;}
    .no-authority em{font-style: normal;color: #666;}
    .no-authority strong{color: #e56639;}
    .no-authority p:last-child{color: #888;}
    .no-authority .btn{padding: 10px 20px;font-size: 16px;color: #e56639;background-color: #fff;border: 1px solid #e56639;border-radius: 2px;letter-spacing: 0.05em;cursor: pointer;-webkit-transition: all 0.2s ease;-moz-transition: all 0.2s ease;transition: all 0.2s ease;}
    .no-authority .btn:hover{background-color: #e56639;color: #fff;   }
</style>     
<div class="no-authority">
    <img src="<?php echo DT_SKIN;?>image/member/noAuthorityImg.png" alt="提示" />
    <p><?php echo $authTip;?></p>
    <p><a href="<?php echo $authLinkUrl;?>" target="_blank" class="btn"><?php echo $authLinkTitle;?></a></p>
    <?php if($authNote) { ?><p><?php echo $authNote;?></p><?php } ?>
</div>
<?php } ?>
