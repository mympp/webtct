<?php
defined('DT_ADMIN') or exit('Access Denied');
$MCFG['module'] = 'job';
$MCFG['name'] = '服务';
$MCFG['author'] = 'Destoon.COM';
$MCFG['homepage'] = 'www.destoon.com';
$MCFG['copy'] = false;
$MCFG['uninstall'] = true;
$MCFG['moduleid'] = 9;

$RT = array();
$RT['file']['index'] = '服务供应管理';
$RT['file']['resume'] = '技术供应管理';
$RT['file']['html'] = '更新网页';

$RT['action']['index']['add'] = '添加需求';
$RT['action']['index']['edit'] = '修改需求';
$RT['action']['index']['delete'] = '删除需求';
$RT['action']['index']['check'] = '审核需求';
$RT['action']['index']['expire'] = '过期需求';
$RT['action']['index']['reject'] = '未通过需求';
$RT['action']['index']['recycle'] = '回收站';
$RT['action']['index']['move'] = '移动需求';
$RT['action']['index']['level'] = '需求推荐级别';

$RT['action']['resume']['add'] = '添加技术供应';
$RT['action']['resume']['edit'] = '修改技术供应';
$RT['action']['resume']['delete'] = '删除技术供应';
$RT['action']['resume']['check'] = '审核技术供应';
$RT['action']['resume']['reject'] = '未通过技术供应';
$RT['action']['resume']['recycle'] = '回收站';
$RT['action']['resume']['move'] = '移动技术供应';
$RT['action']['resume']['level'] = '供应推荐级别';
$CT = 1;
?>