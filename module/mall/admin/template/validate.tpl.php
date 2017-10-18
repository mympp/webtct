<?php
include tpl('header');

?>

<table cellpadding="2" cellspacing="1" class="tb">
    <tr>
        <th>证件名</th>
        <th>上传图片</th>
        <th>申请时间</th>
        <th>修改时间</th>
        <th>到期时间</th>
    </tr>
    <?php foreach($lists as $item){ ?>
        <tr align="center">
            <td><?php echo $item['title']; ?></td>
            <td><a href="javascript:_preview('<?php echo $item['thumb']; ?>')">[查看]</a></td>
            <td><?php echo date('Y-m-d H:i',$item['addtime']); ?></td>
            <td><?php echo date('Y-m-d H:i',$item['edittime']); ?></td>
            <td><?php echo date('Y-m-d H:i',$item['expiretime']); ?></td>
        </tr>
    <?php  } ?>

    </table>

<?php include tpl('footer');?>
