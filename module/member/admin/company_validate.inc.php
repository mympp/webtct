<?php
use models\module\baseModule;
use models\helpers\query\CompanyValidateQuery;
defined('DT_ADMIN') or exit('Access Denied');

$listUrl = '?moduleid='.$moduleid.'&file=company_validate';     //列表页地址
$menus = array (
    array('资料审核', '?moduleid='.$moduleid.'&file=validate&action=member'),
    array('公司认证', $listUrl),
    array('实名认证', '?moduleid='.$moduleid.'&file=validate&action=truename'),
    array('手机认证', '?moduleid='.$moduleid.'&file=validate&action=mobile'),
    array('邮件认证', '?moduleid='.$moduleid.'&file=validate&action=email'),
);

$companyValidate = new CompanyValidateQuery();
if (!empty($action) && !empty($itemid)) {
    switch ($action) {
        case "check":
            $result = $companyValidate->changeValidateStatus($itemid, ['status' => 3, 'editor' => $_username]);
            if ($result) {
                dmsg('审核成功', $listUrl);
            } else {
                dmsg('审核失败', $listUrl);
            }
            break;
        case 'reject':
            $data['status'] = 4;
            $data['note'] = isset($note) ? $note : '';
            $data['editor'] = $_username;
            $result = $companyValidate->changeValidateStatus($itemid, $data);
            if ($result) {
                dmsg('拒绝成功', $listUrl);
            } else {
                dmsg('拒绝失败', $listUrl);
            }
            break;
    }
}

$page = isset($page) ? $page : 1;
$pagesize = 20;
$companyValidate = new CompanyValidateQuery();
$lists = $companyValidate->getListData();
$pages = pages($companyValidate->getListDataCount(),$page,$pagesize);

include tpl('company_validate','member');

?>