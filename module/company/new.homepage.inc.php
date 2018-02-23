<?php
//新版模版厂商处理流程

require_once 'new.init.inc.php';

$companyAnnounce = $homepageModule->getAnnounce();

$mallList = $homepageModule->getMalls(6,1);
$newsList = $homepageModule->getNews(1,4,'title,itemid,introduce,addtime');
$content = $homepageModule->getContent();
$memberInfo = $homepageModule->getMemberInfo();

$links = $homepageModule->getLinks();
$recommendCompany = $homepageModule->getRecommendCompany();

//seo设置
$head_title = $companyInfo['company'];

?>