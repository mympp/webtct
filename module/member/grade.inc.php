<?php
use models\helpers\query\MemberQuery;
use models\module\baseModule;

defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT . '/module/' . $module . '/common.inc.php';
require DT_ROOT . '/include/post.func.php';
require_once DT_ROOT.'/models/autoload.php';

if ($submit) {
    //企业会员升级
    $memberModule = baseModule::moduleInstance('member');
    $licenseInfo['business_license_starttime'] = strtotime($licenseInfo['business_license_starttime']);
    $licenseInfo['business_license_totime'] = strtotime($licenseInfo['business_license_totime']);
    $result = $memberModule->upgradeToCompany($_userid,$_username,$company,$memberInfo,$licenseInfo);
    if($result == true){
        message('申请成功，请等待审核',$MODULE[2]['linkurl']);
    }else{
        message($memberModule->getErrorMessage());
    }

} else {
    $isCompanyGroup = ($_groupid > MemberQuery::NORMAL_GROUPID) ? true : false;
    $isVipGroup = ($_groupid == MemberQuery::VIP_GROUPID) ? true : false;
    $head_title = $L['grade_title'];
    include template('grade', $module);
}
?>
