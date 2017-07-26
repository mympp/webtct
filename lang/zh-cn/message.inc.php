<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
/* ajax.php */
$L['ajax_filepath_exists'] = '文件路径重复，请更换';
$L['ajax_filepath_not_exists'] = '文件路径没有重复';
/* common.inc.php */
$L['common_forbidden'] = '您的用户级别为禁止访问';
$L['common_login'] = '您的帐号在别处(IP:{V0})登录，您被迫下线\n如果不是您操作的，请尽快修改登录密码';
/* upload.php */
$L['upload_refuse'] = '没有权限上传文件';
$L['upload_limit'] = '上传数量超出限制，同一信息最多上传{V0}文件';
$L['upload_credit'] = '上传文件需扣除{V0}'.$DT['credit_name'].'，当前'.$DT['credit_name'].'余额{V1}';
$L['upload_limit_day'] = '24小时内最多上传{V0}文件，当前已经上传{V1}文件';
$L['upload_bad'] = '错误的图片文件格式';
$L['upload_cmyk'] = '浏览器不支持CMYK模式图片，请转换为RGB格式';
$L['upload_jpg'] = '系统不支持GIF格式图片处理，请上传JPG或者PNG格式';
$L['upload_fail'] = '上传失败';
/* .class.php */
$L['pass_areaid'] = '请选择地区';
$L['pass_catid'] = '请选择分类';
$L['pass_cate'] = '请选择行业分类';
$L['pass_title'] = '请填写标题';
$L['pass_linkurl'] = '请填写链接地址';
$L['pass_content'] = '请填写内容';
$L['pass_thumb'] = '请上传标题图片';
$L['pass_logo'] = '请上传LOGO';
$L['pass_date'] = '日期格式错误';
$L['pass_todate'] = '信息过期时间必须在当前时间之后';
$L['pass_max'] = '内容过长，限制为'.DT_MAX_LEN.'字符';
/*
$L['pass_product'] = '请填写产品名称';
$L['pass_product_op_pid'] = '请选择商品类型';
$L['pass_product_op_name'] = '请填写属性名称';
$L['pass_product_op_value'] = '请填写备选值';
$L['pass_product_op_value_min'] = '最少需要设定2个备选值';
*/
$L['pass_truename'] = '请填写联系人';
$L['pass_address'] = '请填写详细地址';
$L['pass_postcode'] = '请填写邮政编码';
$L['pass_telephone'] = '请填写电话号码';
$L['pass_mobile'] = '请填写手机号码';
$L['pass_email'] = '请填写电子邮件';
$L['pass_qq'] = '请填写正确的QQ';
$L['pass_msn'] = '请填写正确的MSN';
$L['pass_down_fileurl'] = '请上传文件或填写地址';
$L['pass_down_badurl'] = '文件地址错误';
$L['pass_down_filesize'] = '请填写文件大小';
$L['pass_exhibit_fromdate'] = '请选择展会开始日期';
$L['pass_exhibit_todate'] = '请选择展会结束日期';
$L['pass_exhibit_baddate'] = '开始日期必须在结束日期之前';
$L['pass_exhibit_city'] = '请填写展出城市';
$L['pass_exhibit_address'] = '请填写展出地址';
$L['pass_exhibit_hallname'] = '请填写展馆名称';
$L['pass_exhibit_sponsor'] = '请填写主办单位';
$L['pass_job_title'] = '请填写一句话概括';
$L['pass_job_areaid'] = '请选择所在地区';
$L['pass_job_content'] = '请填写具体内容';
$L['pass_resume_title'] = '请填写一句话概括';
$L['pass_resume_catid'] = '请选择服务范围';
$L['pass_resume_truename'] = '请填写真实姓名';
$L['pass_resume_areaid'] = '请选择所在地区';
$L['pass_resume_byear'] = '请填写正确的年份';
$L['pass_resume_school'] = '请填写合作单位';
$L['pass_resume_mobile'] = '请填写联系手机';
$L['pass_resume_content'] = '请填写自我推荐';
$L['pass_know_answer'] = '请填写答案内容';
$L['pass_company_username'] = '会员名不能为空';
$L['pass_company_notuser'] = '会员不存在';
$L['pass_company_badgroup'] = '该会员所在会员组不能添加';
$L['pass_company_group'] = '请选择会员组';
$L['pass_company_fromdate'] = '请选择服务开始日期';
$L['pass_company_todate'] = '请选择服务结束日期';
$L['pass_company_baddate'] = '开始日期必须在结束日期之前';
$L['pass_mall_price'] = '请填写商品价格';
$L['pass_mall_amount'] = '请填商品库存';
$L['pass_group_price'] = '请填写团购价';
$L['pass_group_mprice'] = '请填写市场价';
$L['pass_group_eprice'] = '团购价必须低于市场价';
/* list|show|search.inc.php */
$L['without_permission'] = '抱歉，您所在的会员组没有权限访问此页面';
$L['cate_not_exists'] = '抱歉，你要访问的分类不存在';
$L['item_not_exists'] = '抱歉，您要访问的信息不存在或被删除';
$L['without_permission_and_upgrade'] = '您所在的会员组没有权限使用此功能，请升级';
?>