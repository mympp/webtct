<?php defined('IN_DESTOON') or exit('Access Denied');?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo DT_CHARSET;?>"/>
<title><?php if($ztitle=='') { ?><?php if($seo_title) { ?><?php echo $seo_title;?><?php } else { ?><?php if($head_title) { ?><?php echo $head_title;?><?php echo $DT['seo_delimiter'];?><?php } ?>
<?php if($city_sitename) { ?><?php echo $city_sitename;?><?php } else { ?><?php echo $DT['sitename'];?><?php } ?>
<?php } ?>
<?php } else { ?><?php echo $ztitle;?><?php } ?>
</title>
<?php if($head_keywords||$zkeywords) { ?>
<meta name="keywords" content="<?php if($zkeywords) { ?><?php echo $zkeywords;?><?php } else { ?><?php echo $head_keywords;?><?php } ?>
"/>
<?php } ?>
<?php if($head_description||$zdescription) { ?>
<meta name="description" content="<?php if($zdescription) { ?><?php echo $zdescription;?><?php } else { ?><?php echo $head_description;?><?php } ?>
"/>
<?php } ?>
<?php if($head_mobile) { ?>
<meta http-equiv="mobile-agent" content="format=xhtml; url=<?php echo $head_mobile;?>"> 
<meta http-equiv="mobile-agent" content="format=html5; url=<?php echo $head_mobile;?>">
<?php } ?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo DT_PATH;?>favicon.ico"/>
<link rel="bookmark" type="image/x-icon" href="<?php echo DT_PATH;?>favicon.ico"/>
<?php if($head_canonical) { ?>
<link rel="canonical" href="<?php echo $head_canonical;?>"/>
<?php } else if($itemid&&$linkurl&$title) { ?>
<link rel="canonical" href="<?php echo $linkurl;?>"/>
<?php } ?>
<?php if($EXT['archiver_enable']) { ?>
<link rel="archives" title="<?php echo $DT['sitename'];?>" href="<?php echo $EXT['archiver_url'];?>"/>
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo DT_SKIN;?>style.css?v20161216"/>
<?php if($moduleid>3) { ?><link rel="stylesheet" type="text/css" href="<?php echo DT_SKIN;?><?php echo $module;?>.css?v20161208"/><?php } ?>
<?php if($CSS) { ?>
<?php if(is_array($CSS)) { foreach($CSS as $css) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo DT_SKIN;?><?php echo $css;?>.css?v20161208"/>
<?php } } ?>
<?php } ?>
<meta name="wumiiVerification" content="8f76d11a-00e5-409f-8ae1-57cc06024247" />
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="<?php echo DT_SKIN;?>ie6.css"/>
<![endif]-->
<?php if($itemid && $DT['anticopy']) { ?>
<script type="text/javascript">
document.oncontextmenu=function(e){return false;};
//document.onselectstart=function(e){return false;};
</script>
<?php } ?>
<script type="text/javascript" src="<?php echo DT_PATH;?>lang/<?php echo DT_LANG;?>/lang.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/config.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/common.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/page.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jsfunction.js"></script>
<?php if($lazy) { ?><script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery.lazyload.js"></script><?php } ?>
<?php if($head_mobile||$head_link) { ?>
<script type="text/javascript">
<?php if($head_link) { ?>GoMobile('<?php echo $head_link;?>');<?php } else { ?>GoMobile('<?php echo $head_mobile;?>');<?php } ?>
</script>
<?php } ?>
<!-- <?php if($EXT['wap_enable'] && $EXT['wap_goto']&&$head_mobile) { ?>
<script type="text/javascript">
var u = navigator.userAgent.toLowerCase();
if(u.match(/MicroMessenger/i) == "micromessenger") {
GoMobile('<?php echo $head_mobile;?>');
}
</script>
<?php } ?>
-->
<?php if($JS) { ?>
<?php if(is_array($JS)) { foreach($JS as $js) { ?>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/<?php echo $js;?>.js"></script>
<?php } } ?>
<?php } ?>
</head>
