<?php require '/template/header.php'; ?>


    <!--product-list-->
    <div class="layout container clearfix">
        <div class="main pull-right">
            <!--crumb-->
            <div class="crumb">
                <span>您当前的位置：</span>
                <a href="index.html">首页</a> »
                <a href="plist.html">所有产品</a> »
                <?php echo $title; ?>
            </div>
            <!--crumb end-->

            <!--product-area-->
            <div class="product-area">
                <div class="product-title">
                    <h1><?php echo $title; ?></h1>
                </div>
                <div class="product-gg">
                    <img src="./images/yjdf.jpg" alt="一件代发">
                </div>
                <div class="product-img">
                   <?php echo $content; ?>
                </div>
            </div>
            <!--product-area end-->
        </div>
<?php require '/template/product-left.php'; ?>
    </div>
    <!--product-list end-->

<?php require '/template/contact.php'; ?>

<?php require '/template/footer.php'; ?>