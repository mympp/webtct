<?php defined('IN_DESTOON') or exit('Access Denied');?><iframe src="" name="send" id="send" style="display:none;"></iframe>
<form method="post" id="dform" action="<?php echo $DT['file_my'];?>" target="send" onsubmit="return check();">
    <?php if($_POST['qqitemid']) { ?>
    <?php $title=strip_tags($_POST['title']);?>
    <?php $content=$_POST['content'];?>
    <?php $introduce=$content;?>
    <?php $qqitemid=strip_tags($_POST['qqitemid']);?>
    <input type="hidden" name="qqitemid" value="<?php echo $qqitemid;?>"/>
    <?php } ?>
    <input type="hidden" name="action" value="<?php echo $action;?>"/>
    <input type="hidden" name="mid" value="<?php echo $mid;?>"/>
    <input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
    <input type="hidden" name="forward" value="<?php echo $forward;?>"/>
    <table cellpadding="6" cellspacing="1" class="tb">
        <?php if($status==1 && $action=='edit' && $note) { ?>
        <tr>
            <td class="tl">未通过原因</td>
            <td class="tr f_blue"><?php echo $note;?></td>
        </tr>
        <?php } ?>
        <tr>
            <td class="tl"><span class="f_red">*</span> 产品名称</td>
            <td class="tr f_gray"><input name="post[title]" type="text" id="title" size="50" value="<?php echo $title;?>" <?php if($_groupid == 5) { ?>readonly="readonly"  <?php } ?>
/> （2-30个字）<span id="dtitle" class="f_red"></span></td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span> 生产厂商</td>
            <td class="tr"><input name="post[manufacturer]" type="text" size="10" value="<?php echo $manufacturer;?>" id="manufacturer"/><span id="dmanufacturer" class="f_red"></span></td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span> 批准文号/注册证编号</td>
            <td class="tr"><input name="post[batchnum]" type="text" size="10" value="<?php echo $batchnum;?>" id="batchnum"/><span id="dbatchnum" class="f_red"></span></td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span> 所属分类</td>
            <td class="tr">
                <!-- 高级挑选法开始 -->
                <div class="moresel fl" id="openDialog">
                    <span id="cat68" class="lenstr moretitle" title="" onmouseover="this.title=this.innerText;"><?php if($catidname) { ?><?php echo $catidname;?><?php } else { ?>请选医疗器械分类(68分类)<?php } ?>
</span>
                    <span class="lenstr morecount">共<font id="catcount"></font>个</span>
                </div>
                <input type="hidden" name="post_fields[cates]" id="catessel" value="<?php if($cates) { ?><?php echo $cates;?><?php } else { ?><?php if($catid) { ?>,<?php echo $catid;?><?php } ?>
,<?php } ?>
">
                <input type="hidden" name="post_fields[catidname]"  id="catestitle" value="<?php if($catidname) { ?><?php echo $catidname;?><?php } else { ?>,<?php } ?>
">
                <input type="hidden" name="catcz" id="catcz" value="0"><!-- 判断是否已经选择了，如果已经选择点击立刻打开已选择 -->
                <script type="text/javascript">var catcount=strcount(Dd('catessel').value,",");Dd('catcount').innerText=catcount-1;
                if(catcount-1>0){Dd('catcz').value='1';}
                </script>
                <input type="hidden" name="post[catid]" id="catid" value="<?php echo $catid;?>"><!-- 原始数据库中的CATID保留 -->
                <!-- 高级挑选法结束-->
                <span id="dcatid" class="f_red"></span>
            </td>
        </tr>
        <tr style="display:none">
            <td class="tl">&nbsp;</td>
            <td  class="tr" ><input type="checkbox" name="mores" value=0 onclick="mored(6)" id="mores0">填写更多详细资料</td>
        </tr>
        <tr >
            <td class="tl"><span class="f_red">*</span> 产品价格</td>
            <td class="tr"><input name="post[price]" type="text" size="10" value="<?php echo $price;?>" id="price"/><span id="dprice" class="f_red"></span>&nbsp;&nbsp;0为面议
            </td>
        </tr>
        <tr class="dsn" >
            <td class="tl">优惠价格</td>
            <td class="tr"><input type="text" name="post_fields[bprice]" id="priceb" value="<?php echo $bprice;?>" size="30"/> <span class="f_red" id="dbprice"></span>0为询价
                <input type="radio" name="post[bpriceovert]" value="1"<?php if($bpriceovert) { ?> checked<?php } ?>
/> 公开
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="post[bpriceovert]" value="0"<?php if(!$bpriceovert) { ?> checked<?php } ?>
/> 不公开
            </td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span> 产品库存</td>
            <td class="tr"><input name="post[amount]" type="text" size="10" value="<?php echo $amount;?>" id="amount"/><span id="damount" class="f_red"></span></td>
        </tr>
        <?php if($action=='add') { ?>
        <script type="text/javascript">
            Dd('price').value="0";
            Dd('amount').value="9999";
        </script>
        <?php } ?>
        <?php if($CP) { ?>
        <script type="text/javascript">
            var property_catid = <?php echo $catid;?>;
            var property_itemid = <?php echo $itemid;?>;
            var property_admin = 0;
        </script>
        <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/property.js"></script>
        <?php if($itemid) { ?><script type="text/javascript">setTimeout("load_property()", 1000);</script><?php } ?>
        <tbody id="load_property" style="display:none;">
        <tr><td></td><td></td></tr>
        </tbody>
        <?php } ?>
        <script type="text/javascript">
            function msgbox(title,href){
                $.dialog({
                    id: 'boxdd',
                    fixed: true,
                    drag: true,
                    resize:true,
                    height:350,
                    width:880,
                    title:title,
                    focus:true,
                    max: false,
                    min: false,
                    content:'url:'+href+''
                });
            }
        </script>
        <td class="tl">产品品牌</td>
        <td class="tr"><input name="post[brand]" type="text" size="30" value="<?php echo $brand;?>" id="pbrand"/></td>
        </tr>
        <tbody id="mores6" class="dsn">
        <?php if($FD) { ?><?php echo fields_html('<td class="tl">', '<td class="tr">', $item);?><?php } ?>
        </tbody>
        <?php if($_REQUEST['stype']) { ?>
        <script type="text/javascript">
            Dd('stype_<?php echo $_REQUEST['stype'];?>').checked=true;
        </script>
        <?php } ?>
        <tr>
            <td class="tl">产品图片</td>
            <td class="tr">
                <input type="hidden" name="post[thumb]" id="thumb" value="<?php echo $thumb;?>"/>
                <?php if($IMVIP || !$MG['uploadpt']) { ?>
                <input type="hidden" name="post[thumb1]" id="thumb1" value="<?php echo $thumb1;?>"/>
                <input type="hidden" name="post[thumb2]" id="thumb2" value="<?php echo $thumb2;?>"/>
                <?php } ?>
                <table width="360">
                    <tr align="center" height="120" class="c_p">
                        <td width="120"><img src="<?php if($thumb) { ?><?php echo $thumb;?><?php } else { ?><?php echo DT_SKIN;?>image/waitpic.gif<?php } ?>
" width="100" height="100" id="showthumb" title="预览图片" alt="" onclick="if(this.src.indexOf('waitpic.gif') == -1){_preview(Dd('showthumb').src, 1);}else{Dalbum('',<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb').value, true);}"/></td>
                        <?php if($IMVIP || !$MG['uploadpt']) { ?>
                        <td width="120"><img src="<?php if($thumb1) { ?><?php echo $thumb1;?><?php } else { ?><?php echo DT_SKIN;?>image/waitpic.gif<?php } ?>
" width="100" height="100" id="showthumb1" title="预览图片" alt="" onclick="if(this.src.indexOf('waitpic.gif') == -1){_preview(Dd('showthumb1').src, 1);}else{Dalbum(1,<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb1').value, true);}"/></td>
                        <td width="120"><img src="<?php if($thumb2) { ?><?php echo $thumb2;?><?php } else { ?><?php echo DT_SKIN;?>image/waitpic.gif<?php } ?>
" width="100" height="100" id="showthumb2" title="预览图片" alt="" onclick="if(this.src.indexOf('waitpic.gif') == -1){_preview(Dd('showthumb2').src, 1);}else{Dalbum(2,<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb2').value, true);}"/></td>
                        <?php } else { ?>
                        <td width="120"><a href="grade.php" target="_blank"><img src="<?php echo DT_SKIN;?>image/vippic.gif" width="100" height="100"/></a></td>
                        <td width="120"><a href="grade.php" target="_blank"><img src="<?php echo DT_SKIN;?>image/vippic.gif" width="100" height="100"/></a></td>
                        <?php } ?>
                    </tr>
                    <tr align="center" class="c_p">
                        <td><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_upload.gif" width="12" height="12" title="上传" onclick="Dalbum('',<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb').value, true);"/>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_select.gif" width="12" height="12" title="选择" onclick="selAlbum('');"/>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_delete.gif" width="12" height="12" title="删除" onclick="delAlbum('','wait');"/></td>
                        <?php if($IMVIP || !$MG['uploadpt']) { ?>
                        <td><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_upload.gif" width="12" height="12" title="上传" onclick="Dalbum(1,<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb1').value, true);"/>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_select.gif" width="12" height="12" title="选择" onclick="selAlbum(1);"/>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_delete.gif" width="12" height="12" title="删除" onclick="delAlbum(1,'wait');"/></td>
                        <td><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_upload.gif" width="12" height="12" title="上传" onclick="Dalbum(2,<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb2').value, true);"/>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_select.gif" width="12" height="12" title="选择" onclick="selAlbum(2);"/>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_delete.gif" width="12" height="12" title="删除" onclick="delAlbum(2,'wait');"/></td>
                        <?php } else { ?>
                        <td onclick="if(confirm('此操作仅限<?php echo VIP;?>会员，是否现在申请？')) Go('grade.php');"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_upload.gif" width="12" height="12" title="上传"/>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_select.gif" width="12" height="12" title="选择"/>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_delete.gif" width="12" height="12" title="删除"/></td>
                        <td onclick="if(confirm('此操作仅限<?php echo VIP;?>会员，是否现在申请？')) Go('grade.php');"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_upload.gif" width="12" height="12" title="上传"/>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_select.gif" width="12" height="12" title="选择"/>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/img_delete.gif" width="12" height="12" title="删除"/></td>
                        <?php } ?>
                    </tr>
                </table>
                <span>为了更好的展示效果，推荐图片尺寸在800*600以上，最低尺寸为400*300</span>
                <span id="dthumb" class="f_red"></span>
            </td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span> 产品详情</td>
            <td class="tr f_gray">
                <span>为了增加产品的可信度，可以上传产品的销售授权书，品牌授权证书，进口品牌商品请上传报关单证书，正规部门提供的质检检疫报告等。 </span>
                <textarea name="post[content]" id="content" class="dsn"><?php echo $content;?></textarea>
                <?php echo deditor($moduleid, 'content', $group_editor, '98%', 350);?><span id="dcontent" class="f_red"></span>
                <script type="text/javascript">
                    //fck_stop();
                </script>
            </td>
        </tr>
        <tbody id="mores6" class="dsn">
        <?php if($MOD['swfu'] == 1) { ?>
        <?php include DT_ROOT.'/api/swfupload/editor.inc.php';?>
        <?php } ?>
        </tbody>
        <tr id="mores4" class="dsn">
            <td class="tl">可选属性</td>
            <td class="tr">
                <table cellpadding="4" cellspacing="1" bgcolor="#E3EEF5">
                    <tr bgcolor="#EFF5FB" align="center">
                        <td>属性名称</td>
                        <td>属性值</td>
                    </tr>
                    <tr bgcolor="#FFFFFF" align="center">
                        <td><input name="post[n1]" type="text" size="10" value="<?php echo $n1;?>" id="n1"/></td>
                        <td><input name="post[v1]" type="text" size="40" value="<?php echo $v1;?>" id="v1"/></td>
                    </tr>
                    <tr bgcolor="#FFFFFF" align="center">
                        <td><input name="post[n2]" type="text" size="10" value="<?php echo $n2;?>" id="n2"/></td>
                        <td><input name="post[v2]" type="text" size="40" value="<?php echo $v2;?>" id="v2"/></td>
                    </tr>
                    <tr bgcolor="#FFFFFF" align="center">
                        <td><input name="post[n3]" type="text" size="10" value="<?php echo $n3;?>" id="n3"/></td>
                        <td><input name="post[v3]" type="text" size="40" value="<?php echo $v3;?>" id="v3"/></td>
                    </tr>
                    <tr bgcolor="#FFFFFF" align="center">
                        <td class="f_gray">例如：颜色</td>
                        <td class="f_gray">例如：红色|蓝色|黑色|白色 多个属性用|分割</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr id="mores5" class="dsn">
            <td class="tl">运费设置</td>
            <td class="tr">
                <table cellpadding="4" cellspacing="1" bgcolor="#E3EEF5">
                    <tr bgcolor="#EFF5FB" align="center">
                        <td>快递</td>
                        <td>默认运费</td>
                        <td>增加一件产品增加</td>
                        <td>选择模板 | <a href="express.php" class="t" target="_blank">管理模板</a></td>
                    </tr>
                    <tr bgcolor="#FFFFFF" align="center">
                        <td><input name="post[express_name_1]" type="text" id="express_name_1" size="10" value="<?php echo $express_name_1;?>" /></td>
                        <td><input name="post[fee_start_1]" type="text" id="fee_start_1" size="5" value="<?php echo $fee_start_1;?>" /></td>
                        <td><input name="post[fee_step_1]" type="text" id="fee_step_1" size="5" value="<?php echo $fee_step_1;?>" /></td>
                        <td>
                            <select name="post[express_1]" id="express_1" onchange="Dexpress(1, this.options[selectedIndex].innerHTML);">
                                <option value="0">选择模板</option>
                                <?php if(is_array($EXP)) { foreach($EXP as $v) { ?>
                                <option value="<?php echo $v['itemid'];?>"<?php if($express_1==$v['itemid']) { ?> selected<?php } ?>
><?php echo $v['title'];?>[<?php echo $v['express'];?>,<?php echo $v['fee_start'];?>,<?php echo $v['fee_step'];?>,<?php echo $v['note'];?>]</option>
                                <?php } } ?>
                            </select>
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF" align="center"  id="mores3">
                        <td><input name="post[express_name_2]" type="text" id="express_name_2" size="10" value="<?php echo $express_name_2;?>" /></td>
                        <td><input name="post[fee_start_2]" type="text" id="fee_start_2" size="5" value="<?php echo $fee_start_2;?>" /></td>
                        <td><input name="post[fee_step_2]" type="text" id="fee_step_2" size="5" value="<?php echo $fee_step_2;?>" /></td>
                        <td >
                            <select name="post[express_2]" id="express_2" onchange="Dexpress(2, this.options[selectedIndex].innerHTML);">
                                <option value="0">选择模板</option>
                                <?php if(is_array($EXP)) { foreach($EXP as $v) { ?>
                                <option value="<?php echo $v['itemid'];?>"<?php if($express_2==$v['itemid']) { ?> selected<?php } ?>
><?php echo $v['title'];?>[<?php echo $v['express'];?>,<?php echo $v['fee_start'];?>,<?php echo $v['fee_step'];?>,<?php echo $v['note'];?>]</option>
                                <?php } } ?>
                            </select>
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF" align="center">
                        <td><input name="post[express_name_3]" type="text" id="express_name_3" size="10" value="<?php echo $express_name_3;?>" /></td>
                        <td><input name="post[fee_start_3]" type="text" id="fee_start_3" size="5" value="<?php echo $fee_start_3;?>" /></td>
                        <td><input name="post[fee_step_3]" type="text" id="fee_step_3" size="5" value="<?php echo $fee_step_3;?>" /></td>
                        <td>
                            <select name="post[express_3]" id="express_3" onchange="Dexpress(3, this.options[selectedIndex].innerHTML);">
                                <option value="0">选择模板</option>
                                <?php if(is_array($EXP)) { foreach($EXP as $v) { ?>
                                <option value="<?php echo $v['itemid'];?>"<?php if($express_3==$v['itemid']) { ?> selected<?php } ?>
><?php echo $v['title'];?>[<?php echo $v['express'];?>,<?php echo $v['fee_start'];?>,<?php echo $v['fee_step'];?>,<?php echo $v['note'];?>]</option>
                                <?php } } ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span>所在地区</td>
            <td class="tr"><?php echo ajax_area_select('post[areaid]', '请选择', $areaid);?>&nbsp;<span id="dareaid" class="f_red"></span></td>
        </tr>
        <tr<?php if(!$_userid) { ?> style="display:none;"<?php } ?>
 id="mores2">
        <td class="tl">自定义分类</td>
        <td class="tr"><?php echo $mycatid_select;?>&nbsp; <a href="type.php?item=mall" class="t">[管理分类]</a></td>
        </tr>
        <tr<?php if(!$_userid) { ?> style="display:none;"<?php } ?>
 id="mores1" >
        <td class="tl">我的推荐</td>
        <td class="tr">
            <input type="radio" name="post[elite]" value="1"<?php if($elite) { ?> checked<?php } ?>
/> 是
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="post[elite]" value="0"<?php if(!$elite) { ?> checked<?php } ?>
/> 否
        </td>
        </tr>
        <?php if($action=='edit') { ?>
        <script type="text/javascript">
            Dd('mores0').checked=true;
            mored(6);
        </script>
        <?php } ?>
        <?php if($fee_add) { ?>
        <tr>
            <td class="tl">发布此信息需消费</td>
            <td class="tr"><span class="f_b f_red"><?php echo $fee_add;?></span> <?php echo $fee_unit;?></td>
        </tr>
        <?php if($fee_currency == 'money') { ?>
        <tr>
            <td class="tl"><?php echo $DT['money_name'];?>余额</td>
            <td class="tr"><span class="f_blue f_b"><?php echo $_money;?><?php echo $fee_unit;?></span> <a href="charge.php?action=pay" target="_blank" class="t">[充值]</a></td>
        </tr>
        <?php } else { ?>
        <tr>
            <td class="tl"><?php echo $DT['credit_name'];?>余额</td>
            <td class="tr"><span class="f_blue f_b"><?php echo $_credit;?><?php echo $fee_unit;?></span> <a href="credit.php?action=buy" target="_blank" class="t">[购买]</a></td>
        </tr>
        <?php } ?>
        <?php } ?>
        <?php if($need_password) { ?>
        <tr>
            <td class="tl"><span class="f_red">*</span> 支付密码</td>
            <td class="tr"><?php include template('password', 'chip');?> <span id="dpassword" class="f_red"></span></td>
        </tr>
        <?php } ?>
        <?php if($need_question) { ?>
        <tr>
            <td class="tl"><span class="f_red">*</span> 验证问题</td>
            <td class="tr"><?php include template('question', 'chip');?> <span id="danswer" class="f_red"></span></td>
        </tr>
        <?php } ?>
        <?php if($need_captcha) { ?>
        <tr>
            <td class="tl"><span class="f_red">*</span> 验证码</td>
            <td class="tr"><?php include template('captcha', 'chip');?> <span id="dcaptcha" class="f_red"></span></td>
        </tr>
        <?php } ?>
        <?php if($action=='add') { ?>
        <tr style="display:none;" id="weibo_sync">
            <td class="tl">同步主题</td>
            <td class="tr" id="weibo_show"></td>
        </tr>
        <?php } ?>
        <tr>
            <td class="tl">&nbsp;</td>
            <td class="tr" height="50"><input type="submit" name="submit" value=" 提 交 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/></td>
        </tr>
    </table>
</form>
<?php echo load('clear.js');?>
<?php if($action=='add') { ?>
<script type="text/javascript">s('mid_<?php echo $mid;?>');m('<?php echo $action;?>');</script>
<?php } else { ?>
<script type="text/javascript">s('mid_<?php echo $mid;?>');m('s<?php echo $status;?>');</script>
<?php } ?>
