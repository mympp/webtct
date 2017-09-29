<?php defined('IN_DESTOON') or exit('Access Denied');?><div class="menu">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="tab" id="add"><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>&action=add"><span>添加产品/商品</span></a></td>
            <?php if($_userid) { ?>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="s3"><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>"><span>上架<span class="px10">(<?php echo $nums['3'];?>)</span></span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="s2"><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>&status=2"><span>审中<span class="px10">(<?php echo $nums['2'];?>)</span></span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="s1"><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>&status=1"><span>未过<span class="px10">(<?php echo $nums['1'];?>)</span></span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="s0"><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>&status=0"><span>回收站<span class="px10">(<?php echo $nums['0'];?>)</span></span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="s4"><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>&status=4"><span>下架<span class="px10">(<?php echo $nums['4'];?>)</span></span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="type"><a href="<?php echo $MODULE['2']['linkurl'];?>trade.php"><span>订单<span class="px10">(<?php echo $nums['9'];?>)</span></span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="type"><a href="type.php?item=mall"><span>产品分类<span class="px10">(<?php echo $nums['0'];?>)</span></span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="express"><a href="express.php"><span>运费模板</span></a></td>
            <?php } ?>
        </tr>
    </table>
</div>
<?php if($action=='add' || $action=='edit') { ?>
        <?php if($action == 'add' && $isCompanyValidated != true ) { ?>
            <?php $authLinkUrl = DT_PATH.'member/validate.php?action=company';?>
            <?php $authLinkTitle = '资质材料上传';?>
            <?php $authTip = "尊敬的<em>".$_username."</em>，您的商家未通过资质认证！";?>
            <?php $authNote = '（通过资质认证的商家才能上传商品！）';?>
            <?php include template('no-authority','chip');?>
        <?php } else { ?>
            <?php include template('member_mall_edit','mall');?>
        <?php } ?>
<?php } else if($action=='relate') { ?>
<form method="post" action="<?php echo $DT['file_my'];?>" id="dform">
    <input type="hidden" name="mid" value="<?php echo $mid;?>"/>
    <input type="hidden" name="action" value="<?php echo $action;?>"/>
    <input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
    <input type="hidden" name="forward" value="<?php echo $forward;?>"/>
    <table cellpadding="2" cellspacing="1" class="tb">
        <tr>
            <td class="tl">关联名称</td>
            <td class="tr f_gray"><input type="text" size="20" name="relate_name" id="relate_name" value="<?php echo $M['relate_name'];?>"/>&nbsp;&nbsp; 例如“颜色”、“尺寸”、“型号”等</td>
        </tr>
        <tr>
            <td colspan="2" class="tr">
                <?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
                <div style="width:130px;float:left;">
                    <table width="120">
                        <tr align="center" height="110" class="c_p">
                            <td width="120"><a href="<?php echo $MOD['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank"><img src="<?php echo $v['thumb'];?>" width="100" height="100" alt=""/></a></td>
                        </tr>
                        <tr align="center">
                            <td>标题 <input type="text" size="8" name="post[<?php echo $v['itemid'];?>][relate_title]" value="<?php echo $v['relate_title'];?>"/></td>
                        </tr>
                        <tr align="center">
                            <td>排序 <input type="text" size="8" name="post[<?php echo $v['itemid'];?>][listorder]" value="<?php echo $k;?>"/></td>
                        </tr>
                        <tr align="center">
                            <td><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>&action=relate_del&itemid=<?php echo $itemid;?>&id=<?php echo $v['itemid'];?>" onclick="return _delete();" class="t">[移除]</a></td>
                        </tr>
                    </table>
                </div>
                <?php } } ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                &nbsp;<input type="submit" name="submit" value="更 新" class="btn"/>
                &nbsp;<input type="button" value="新增产品" onclick="add();" class="btn"/></td>
        </tr>
    </table>
</form>
<form method="post" action="<?php echo $DT['file_my'];?>" id="dform_add">
    <input type="hidden" name="mid" value="<?php echo $mid;?>"/>
    <input type="hidden" name="action" value="relate_add"/>
    <input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
    <input type="hidden" name="id" id="id" value="0"/>
    <input type="hidden" name="relate_name" id="relate_name_add" value=""/>
</form>
<script type="text/javascript">
    function add() {
        if(Dd('relate_name').value.length < 2) {
            alert('请填写关联名称');
            Dd('relate_name').focus();
            return;
        }
        Dd('relate_name_add').value = Dd('relate_name').value;
        select_item('<?php echo $mid;?>&username=<?php echo $M['username'];?>', 'relate');
    }
</script>
<script type="text/javascript">s('mid_<?php echo $mid;?>');m('s3');</script>
<?php } else { ?>
<div class="tt">
    <form action="<?php echo $DT['file_my'];?>">
        <input type="hidden" name="mid" value="<?php echo $mid;?>"/>
        <input type="hidden" name="status" value="<?php echo $status;?>"/>
        &nbsp;<?php echo category_select('catid', '产品分类', $catid, $moduleid);?>&nbsp;
        <?php echo $mycat_select;?>&nbsp;
        <input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
        <?php echo $order_select;?>&nbsp;
        <input type="submit" value=" 搜 索 " class="btn"/>
        <input type="button" value=" 重 置 " class="btn" onclick="Go('<?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>&status=<?php echo $status;?>');"/>
        <div class="b10"></div>
        &nbsp;单价：<input type="text" size="3" name="minprice" value="<?php echo $minprice;?>"/> ~ <input type="text" size="3" name="maxprice" value="<?php echo $maxprice;?>"/>&nbsp;
        订单：<input type="text" size="3" name="minorders" value="<?php echo $minorders;?>"/> ~ <input type="text" size="3" name="maxorders" value="<?php echo $maxorders;?>"/>&nbsp;
        销量：<input type="text" size="3" name="minsales" value="<?php echo $minsales;?>"/> ~ <input type="text" size="3" name="maxsales" value="<?php echo $maxsales;?>"/>&nbsp;
        库存：<input type="text" size="3" name="minamount" value="<?php echo $minamount;?>"/> ~ <input type="text" size="3" name="maxamount" value="<?php echo $maxamount;?>"/>&nbsp;
        评论：<input type="text" size="3" name="mincomments" value="<?php echo $mincomments;?>"/> ~ <input type="text" size="3" name="maxcomments" value="<?php echo $maxcomments;?>"/>&nbsp;
    </form>
</div>
<div class="ls">
    <form method="post">
        <table cellpadding="0" cellspacing="0" class="tb">
            <tr>
                <th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>
                <th width="60">图片</th>
                <th>产品</th>
                <th>价格</th>
                <th>订单</th>
                <th>销量</th>
                <th>库存</th>
                <th>评论</th>
                <th>人气</th>
                <th width="100">管理</th>
            </tr>
            <?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
            <tr  align="center">
                <td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
                <td><a href="javascript:_preview('<?php echo $v['thumb'];?>');"><img src="<?php if($v['thumb']) { ?><?php echo $v['thumb'];?><?php } else { ?><?php echo DT_SKIN;?>image/nopic50.gif<?php } ?>
" width="50" class="thumb"/></a></td>
                <td align="left" title="<?php echo $v['alt'];?>"><ul><li>&nbsp;<?php if($v['elite']) { ?><span class="f_red" title="公司主页推荐">[荐]</span> <?php } ?>
<?php if($v['status']>2) { ?><a href="<?php echo $v['linkurl'];?>" target="_blank" class="t"><?php } else { ?><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>&action=edit&itemid=<?php echo $v['itemid'];?>" class="t"><?php } ?>
<?php echo $v['title'];?></a><?php if($v['status']==1 && $v['note']) { ?> <a href="javascript:" onclick="alert('<?php echo $v['note'];?>');"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/why.gif" title="未通过原因"/></a><?php } ?>
</li><li title="更新时间 <?php echo timetodate($v['edittime'], 5);?> 添加时间 <?php echo timetodate($v['addtime'], 5);?>" class="px11 f_gray">&nbsp;<?php if($timetype=='add') { ?><?php echo timetodate($v['addtime'], 5);?><?php } else { ?><?php echo timetodate($v['edittime'], 5);?><?php } ?>
</li></ul></td>
                <td class="f_price"><?php echo $v['price'];?></td>
                <td class="px11 c_p<?php if($v['orders']>0) { ?> f_blue f_b<?php } ?>
" title="查看订单" onclick="Go('trade.php?mallid=<?php echo $v['itemid'];?>');"><?php echo $v['orders'];?></td>
                <td class="px11"><?php echo $v['sales'];?></td>
                <td class="px11<?php if($v['amount']<5) { ?> f_red f_b" title="库存不足<?php } ?>
"><?php echo $v['amount'];?></td>
                <td class="px11"><?php echo $v['comments'];?></td>
                <td class="px11"><?php echo $v['hits'];?></td>
                <td>
                    <a href="<?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>&action=relate&itemid=<?php echo $v['itemid'];?>"><img width="16" height="16" src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/child.png" title="关联产品" alt=""/></a>
                    <a href="<?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>&action=edit&itemid=<?php echo $v['itemid'];?>"><img width="16" height="16" src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/edit.png" title="修改" alt=""/></a>
                    <?php if($MG['copy']) { ?>&nbsp;<a href="<?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>&action=add&itemid=<?php echo $v['itemid'];?>&catid=<?php echo $v['catid'];?>"><img width="16" height="16" src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/new.png" title="复制信息" alt=""/></a><?php } ?>
                    <?php if($MG['delete']) { ?>&nbsp;<a href="<?php echo $DT['file_my'];?>?mid=<?php echo $mid;?>&action=delete&itemid=<?php echo $v['itemid'];?>" onclick="return confirm('确定要删除吗？此操作将不可撤销');"><img width="16" height="16" src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/delete.png" title="删除" alt=""/></a><?php } ?>
                </td>
            </tr>
            <?php } } ?>
        </table>
</div>
<?php if($MG['delete'] || $timetype!='add') { ?>
<div class="btns">
    <?php if($MG['delete']) { ?>
    <span class="f_r"><input type="submit" value=" 删除选中 " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'"  onclick="if(confirm('确定要删除选中<?php echo $MOD['name'];?>吗？')){this.form.action='?mid=<?php echo $mid;?>&status=<?php echo $status;?>&action=delete'}else{return false;}"/></span>
    <?php } ?>
    <?php if($status==3) { ?><input type="submit" value=" 批量下架 " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'"  onclick="this.form.action='?mid=<?php echo $mid;?>&status=<?php echo $status;?>&action=unsale';"/>&nbsp;<?php } ?>
    <?php if($status==4) { ?><input type="submit" value=" 批量上架 " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'"  onclick="this.form.action='?mid=<?php echo $mid;?>&status=<?php echo $status;?>&action=onsale';"/>&nbsp;<?php } ?>
    <?php echo $mycatid_select;?>
    <input type="submit" value=" 移动分类 " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'"  onclick="this.form.action='?mid=<?php echo $mid;?>&status=<?php echo $status;?>&action=move&mycatid='+Dd('post[mycatid]').value;"/>
    <?php if($timetype!='add') { ?>
    <input type="submit" value=" 刷新选中 " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'"  onclick="this.form.action='?mid=<?php echo $mid;?>&status=<?php echo $status;?>&action=refresh';"/>
    <?php if($MOD['credit_refresh']) { ?>
    刷新一条信息一次需消费 <strong class="f_red"><?php echo $MOD['credit_refresh'];?></strong> <?php echo $DT['credit_name'];?>，当<?php echo $DT['credit_name'];?>不足时将不可刷新
    <?php } ?>
    <?php } ?>
    <?php if($CFG['tag_expires']) { ?>
    注意：发布或修改经过本站通过审核后，在<?php $dt_addtime=$CFG['tag_expires']/60;echo round($dt_addtime);?>
    <?php } ?>
    <?php if($DT['cache_search']) { ?>
    分钟后才在本站前台显示结果，搜索要<?php $dt_sqltime=$DT['cache_search']/60;echo round($dt_sqltime);?>分钟后才在显示出来！
    <?php } ?>
</div>
<?php } ?>
</form>
<?php if($MG['mall_limit'] || (!$MG['fee_mode'] && $MOD['fee_add'])) { ?>
<div class="limit">
    <?php if($MG['mall_limit']) { ?>
    总共可发 <span class="f_b f_red"><?php echo $MG['mall_limit'];?></span> 条&nbsp;&nbsp;&nbsp;
    当前已发 <span class="f_b"><?php echo $limit_used;?></span> 条&nbsp;&nbsp;&nbsp;
    还可以发 <span class="f_b f_blue"><?php echo $limit_free;?></span> 条&nbsp;&nbsp;&nbsp;
    <?php } ?>
    <?php if(!$MG['fee_mode'] && $MOD['fee_add']) { ?>
    发布信息收费 <span class="f_b f_red"><?php echo $MOD['fee_add'];?></span> <?php if($MOD['fee_currency'] == 'money') { ?><?php echo $DT['money_unit'];?><?php } else { ?><?php echo $DT['credit_unit'];?><?php } ?>
/条&nbsp;&nbsp;&nbsp;
    可免费发布 <span class="f_b"><?php if($MG['mall_free_limit']<0) { ?>无限<?php } else { ?><?php echo $MG['mall_free_limit'];?><?php } ?>
</span> 条&nbsp;&nbsp;&nbsp;
    <?php } ?>
</div>
<?php } ?>
<div class="pages"><?php echo $pages;?></div>
<script type="text/javascript">s('mid_<?php echo $mid;?>');m('s<?php echo $status;?>');</script>
<?php } ?>
<?php if($action == 'add' || $action == 'edit') { ?>
<script type="text/javascript" src="<?php echo DT_PATH;?>file/script/popwin.js"></script>
<script>
    $("#openDialog").on('click' , function(){
        var catessel = Dd('catessel').value;
        var catcount = Dd('catcount').value;
        var catcz    = Dd('catcz').value;
        var url      = 'catselect.php?moduleid=16&catessel='+catessel+'&catcount='+catcount+'&catcz='+catcz;
        popWin.showWin("860","540","产品涉及的医疗器械分类",url);
    });
    function closedialog(){
        $("#popWinClose").click();
    }
</script>
<script type="text/javascript">
    function _p() {
        if(Dd('tag').value) {
            Ds('reccate');
        }
    }
    function d(){
    }
    function check() {
        var l;
        var f;
        var k;
        f = 'catcz';
        if(Dd(f).value == 0) {
            Dmsg('请选择产品分类', 'catid', 1);
            return false;
        }
        f = 'title';
        l = Dd(f).value.length;
        if(l < 2) {
            Dmsg('产品名称最少2字，当前已输入'+l+'字', f);
            return false;
        }
        f = 'price';
        l = Dd(f).value;
        if(l < 0) {
            Dmsg('请填写产品价格', f);
            return false;
        }
        f = 'amount';
        l = Dd(f).value;
        if(l < 1) {
            Dmsg('请填写库存', f);
            return false;
        }
        f = 'manufacturer';
        l = Dd(f).value.length;
        if(l < 1){
            Dmsg('请填写生成厂家',f);
            return false;
        }
        f = 'batchnum';
        l = Dd(f).value.length;
        if(l < 1){
            Dmsg('请填写批准文号',f);
            return false;
        }
        f = 'thumb';
        l = Dd(f).value.length;
        if(l < 0) {
            Dmsg('请上传第一张产品图片', f);
            return false;
        }
        f = 'content';
        l = FCKLen();
        if(l < 25 || l > 50000) {
            Dmsg('详细说明应为25-50000字，当前已输入'+l+'字', f);
            return false;
        }
        if(Dd('v1').value) {
            if(!Dd('n1').value) {
                alert('请填写属性名称');
                Dd('n1').focus();
                return false;
            }
            if(Dd('v1').value.indexOf('|') == -1) {
                alert(Dd('n1').value+'至少需要两个属性');
                Dd('v1').focus();
                return false;
            }
        }
        if(Dd('v2').value) {
            if(!Dd('n2').value) {
                alert('请填写属性名称');
                Dd('n2').focus();
                return false;
            }
            if(Dd('v2').value.indexOf('|') == -1) {
                alert(Dd('n2').value+'至少需要两个属性');
                Dd('v2').focus();
                return false;
            }
        }
        if(Dd('v3').value) {
            if(!Dd('n3').value) {
                alert('请填写属性名称');
                Dd('n3').focus();
                return false;
            }
            if(Dd('v3').value.indexOf('|') == -1) {
                alert(Dd('n3').value+'至少需要两个属性');
                Dd('v3').focus();
                return false;
            }
        }
        if(Dd('n1').value && (Dd('n1').value == Dd('n2').value || Dd('n1').value == Dd('n3').value)) {
            alert('属性名称不能重复');
            return false;
        }
        if(Dd('n2').value && (Dd('n2').value == Dd('n1').value || Dd('n2').value == Dd('n3').value)) {
            alert('属性名称不能重复');
            return false;
        }
        if(Dd('n3').value && (Dd('n3').value == Dd('n1').value || Dd('n3').value == Dd('n2').value)) {
            alert('属性名称不能重复');
            return false;
        }
        if(Dd('express_name_1').value && (Dd('express_name_1').value == Dd('express_name_2').value || Dd('express_name_1').value == Dd('express_name_3').value)) {
            alert('快递名称不能重复');
            return false;
        }
        if(Dd('express_name_2').value && (Dd('express_name_2').value == Dd('express_name_1').value || Dd('express_name_2').value == Dd('express_name_3').value)) {
            alert('快递名称不能重复');
            return false;
        }
        if(Dd('express_name_3').value && (Dd('express_name_3').value == Dd('express_name_1').value || Dd('express_name_3').value == Dd('express_name_2').value)) {
            alert('快递名称不能重复');
            return false;
        }
        <?php if($FD) { ?><?php echo fields_js();?><?php } ?>
        if(Dd('property_require') != null) {
            var ptrs = Dd('property_require').getElementsByTagName('option');
            for(var i = 0; i < ptrs.length; i++) {
                f = 'property-'+ptrs[i].value;
                if(Dd(f).value == 0 || Dd(f).value == '') {
                    Dmsg('请填写或选择'+ptrs[i].innerHTML, f);
                    return false;
                }
            }
        }
        <?php if($need_password) { ?>
        f = 'password';
        l = Dd(f).value.length;
        if(l < 6) {
            Dmsg('请填写支付密码', f);
            return false;
        }
        <?php } ?>
        <?php if($need_question) { ?>
        f = 'answer';
        l = Dd(f).value.length;
        if(l < 1) {
            Dmsg('请填写验证问题', f);
            return false;
        }
        if(Dd('c'+f).innerHTML.indexOf('error') != -1) {
            Dd(f).focus();
            return false;
        }
        <?php } ?>
        <?php if($need_captcha) { ?>
        f = 'captcha';
        l = Dd(f).value;
        if(!is_captcha(l)) {
            Dmsg('请填写正确的验证码', f);
            return false;
        }
        if(Dd('c'+f).innerHTML.indexOf('error') != -1) {
            Dd(f).focus();
            return false;
        }
        <?php } ?>
        <?php if($is_dingzhi) { ?>
        var section=[];
        var price=[];
        $("*[name='post_fields[sp_section][]']").each(function(i,o){
            section[i]=$(o).val();
        });
        $("*[name='post_fields[sp_price][]']").each(function(i,o){
            price[i]=$(o).val();
        });
        var price_wrong=[];
        j=0;
        al_str='';
        for(var i=0;i<price.length;i++){
            if(isNaN(price[i])&&price[i]!=''){
                al_str+=price[i];
            }else if(price[i]<0.01&&price[i]!=''){
                al_str+=price[i];
            }
        }
        if(al_str!=''){
            alert("区间价格'"+al_str+"'不是正确的价格");
            return false;
        }
        var str='{';
        for(var i=0;i<section.length;i++){
            if(section[i]!=''&&price[i]!=''){
                str+='"'+section[i]+'":'+price[i]+',';
            }
        }
        var s=str.substr(0,(str.length-1));
        s+='}';
        $('#sectionprice').val(s);
        <?php } ?>
        return true;
        //return false;
    }
    function Dexpress(i, s) {
        if(Dd('express_'+i).value > 0) {
            var t1 = s.split('[');
            var t2 = t1[1].split(',');
            Dd('express_name_'+i).value = t2[0];
            Dd('fee_start_'+i).value = t2[1];
            Dd('fee_step_'+i).value = t2[2];
        } else {
            Dd('express_name_'+i).value = '';
            Dd('fee_start_'+i).value = '';
            Dd('fee_step_'+i).value = '';
        }
    }
    var destoon_oauth = '<?php echo $EXT['oauth'];?>';
</script>
<?php } ?>
<?php if($action=='add' && strlen($EXT['oauth']) > 1) { ?><?php echo load('weibo.js');?><?php } ?>
