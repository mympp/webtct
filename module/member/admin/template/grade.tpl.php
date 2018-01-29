<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
    <form action="?">
        <div class="tt">记录搜索</div>
        <input type="hidden" name="moduleid" value="<?php echo $moduleid; ?>"/>
        <input type="hidden" name="file" value="<?php echo $file; ?>"/>
        <input type="hidden" name="action" value="<?php echo $action; ?>"/>
        <table cellpadding="2" cellspacing="1" class="tb">
            <tr>
                <td>
                    &nbsp;<?php echo $fields_select; ?>&nbsp;
                    <input type="text" size="50" name="kw" value="<?php echo $kw; ?>" title="关键词"/>&nbsp;
                    <?php echo $order_select; ?>
                    &nbsp;
                    <input type="text" name="psize" value="<?php echo $pagesize; ?>" size="2" class="t_c" title="条/页"/>
                    <input type="submit" value="搜 索" class="btn"/>&nbsp;
                    <input type="button" value="重 置" class="btn"
                           onclick="Go('?moduleid=<?php echo $moduleid; ?>&file=<?php echo $file; ?>&action=<?php echo $action; ?>');"/>
                </td>
            </tr>
        </table>
    </form>
    <form method="post">
        <div class="tt">管理记录</div>
        <table cellpadding="2" cellspacing="1" class="tb">
            <tr>
                <th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
                <th>公司名</th>
                <th>会员</th>
                <th width="130">申请时间</th>
                <th>营业执照</th>
                <th>有效时间</th>
                <th>证件号</th>
                <th width="50">状态</th>
            </tr>
            <?php foreach ($lists as $k => $v) { ?>
                <tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
                    <td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid']; ?>"/></td>
                    <td align="left"><?php echo $v['company']; ?></td>
                    <td>
                        <a href="javascript:_user('<?php echo $v['username']; ?>');"><?php echo $v['username']; ?></a>
                    </td>
                    <td class="px11"><?php echo date('Y-m-d',$v['addtime']); ?></td>
                    <td><a href="javascript:_preview('<?php echo $v['business_license']; ?>')">[查看]</a></td>
                    <td>
                        <?php echo date('Y-m-d',$v['business_license_starttime']); ?>
                        至
                        <?php echo date('Y-m-d',$v['business_license_totime']); ?>
                    </td>
                    <td><?php echo $v['business_license_code']; ?></td>
                    <td>
                        <?php
                            if($v['status'] == '2'){
                                echo '待审核';
                            }elseif($v['status'] == 3){
                                echo '已通过';
                            }else{
                                echo '已拒绝';
                            }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <div class="btns">
            <input type="submit" value=" 删除记录 " class="btn"
                   onclick="if(confirm('确定要删除选中记录吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid; ?>&file=<?php echo $file; ?>&action=delete'}else{return false;}"/>
            &nbsp;&nbsp;
            <input type="submit" value="通过" class="btn"
                onclick="this.form.action='?moduleid=<?php echo $moduleid; ?>&file=<?php echo $file; ?>&action=allow'"/>
            &nbsp;&nbsp;
            <input type="submit" value="拒绝" class="btn"
                onclick="this.form.action='?moduleid=<?php echo $moduleid; ?>&file=<?php echo $file; ?>&action=reject&rejectMove=1'"/>
            &nbsp;&nbsp;
            <input type="text" width="320px" placeholder="拒绝理由" name="reason" />
        </div>
    </form>
    <div class="pages"><?php echo $pages; ?></div>
    <br/>
    <script type="text/javascript">Menuon(<?php echo $menuon[$status];?>);</script>
<?php include tpl('footer'); ?>