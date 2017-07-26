<?php defined('IN_DESTOON') or exit('Access Denied');?><?php $CSS = array('catalog');?>
<?php include template('header');?>
<div class="header-banner">
    <div>
        <img src="/skin/default/image/banner.jpg">
    </div>
</div>
<div class="m">
    <form method="post" action="?" onsubmit="return Dcheck();" id="dform">
        <div class="search-div">
            <ul>
                <?php echo $area_select;?>
                <li class="sel-cat">
                    经营范围
                </li>
                <li class="sel-input">
                    <input type="text" name="" value="" placeholder="请输入商家关键字" class="ser-input"/>
                    <button  type="submit" name="submit" class="searchbtn"></button>
                </li>
            </ul>
        </div>
    </form>
    <script>
        $(function(){
            $(".good-cat-more").click(function(){
                var h = $(this).parent().parent().children(".cat-com").height();
                if(h == 310){
                    $(this).children().html('收起');
                    $(this).removeClass('down');
                    $(this).addClass('up');
                    var el = $(this).parent().parent().children(".cat-com"),
                            curHeight = el.height(),
                            autoHeight = el.css('height', 'auto').height();
                    el.height(curHeight).animate({height: autoHeight}, "slow");
                }else{
                    $(this).children().html('更多');
                    $(this).removeClass('up');
                    $(this).addClass('down');
                    $(this).parent().parent().children(".cat-com").animate({height:'310px'},"slow");
                }
            });
        });
    </script>
    <div class="goods">
        <div class="cat-detail">
            <?php $companys=tag("moduleid=4&condition=FIND_IN_SET(3,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");?>
            <div class="cat-title-bak">
                <div class="good-cat-title">
                    <span>装修主材</span>
                </div>
                <?php if(count($companys) > 3) { ?>
                <div class="good-cat-more down">
                    <span>更多</span>
                </div>
                <?php } ?>
            </div>
            <div class="c_b"></div>
            <div class="cat-com">
                <div class="com-list">
                    <?php if(is_array($companys)) { foreach($companys as $k => $t) { ?>
                    <?php if(in_array($k,array(0,3,6))) { ?>
                    <div class="com-show">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <?php $malls=tag("moduleid=16&condition=username='".$t['username']."' and elite=1&order=itemid desc&pagesize=2&template=null&debug=0");?>
                                <?php if(is_array($malls)) { foreach($malls as $k1 => $t1) { ?>
                                <li><a href="<?php echo $t1['linkurl'];?>" target="_blank"><img src="<?php echo $t1['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/pro2.png',2);"/></a></li>
                                <?php } } ?>
                            </ul>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="com-show com-show-m">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <?php $malls=tag("moduleid=16&condition=username='".$t['username']."' and elite=1&order=itemid desc&pagesize=2&template=null&debug=0");?>
                                <?php if(is_array($malls)) { foreach($malls as $k1 => $t1) { ?>
                                <li><a href="<?php echo $t1['linkurl'];?>" target="_blank"><img src="<?php echo $t1['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/pro2.png',2);"/></a></li>
                                <?php } } ?>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } } ?>
                </div>
            </div>
        </div>
        <div class="cat-detail">
            <?php $companys=tag("moduleid=4&condition=FIND_IN_SET(44,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");?>
            <div class="cat-title-bak">
                <div class="good-cat-title">
                    <span>通风空调</span>
                </div>
                <?php if(count($companys) > 3) { ?>
                <div class="good-cat-more down">
                    <span>更多</span>
                </div>
                <?php } ?>
            </div>
            <div class="c_b"></div>
            <div class="cat-com">
                <div class="com-list">
                    <?php if(is_array($companys)) { foreach($companys as $k => $t) { ?>
                    <?php if(in_array($k,array(0,3,6))) { ?>
                    <div class="com-show">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <?php $malls=tag("moduleid=16&condition=username='".$t['username']."' and elite=1&order=itemid desc&pagesize=2&template=null&debug=0");?>
                                <?php if(is_array($malls)) { foreach($malls as $k1 => $t1) { ?>
                                <li><a href="<?php echo $t1['linkurl'];?>" target="_blank"><img src="<?php echo $t1['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/pro2.png',2);"/></a></li>
                                <?php } } ?>
                            </ul>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="com-show com-show-m">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <?php $malls=tag("moduleid=16&condition=username='".$t['username']."' and elite=1&order=itemid desc&pagesize=2&template=null&debug=0");?>
                                <?php if(is_array($malls)) { foreach($malls as $k1 => $t1) { ?>
                                <li><a href="<?php echo $t1['linkurl'];?>" target="_blank"><img src="<?php echo $t1['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/pro2.png',2);"/></a></li>
                                <?php } } ?>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } } ?>
                </div>
            </div>
        </div>
        <div class="cat-detail">
            <?php $companys=tag("moduleid=4&condition=FIND_IN_SET(45,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");?>
            <div class="cat-title-bak">
                <div class="good-cat-title">
                    <span>电工电气/安防</span>
                </div>
                <?php if(count($companys) > 3) { ?>
                <div class="good-cat-more down">
                    <span>更多</span>
                </div>
                <?php } ?>
            </div>
            <div class="c_b"></div>
            <div class="cat-com">
                <div class="com-list">
                    <?php if(is_array($companys)) { foreach($companys as $k => $t) { ?>
                    <?php if(in_array($k,array(0,3,6))) { ?>
                    <div class="com-show">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <li><img src="/skin/default/image/pro1.png"/></li>
                                <li><img src="/skin/default/image/pro2.png"/></li>
                            </ul>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="com-show com-show-m">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <li><img src="/skin/default/image/pro1.png"/></li>
                                <li><img src="/skin/default/image/pro2.png"/></li>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } } ?>
                </div>
            </div>
        </div>
        <div class="cat-detail">
            <?php $companys=tag("moduleid=4&condition=FIND_IN_SET(46,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");?>
            <div class="cat-title-bak">
                <div class="good-cat-title">
                    <span>管材管件</span>
                </div>
                <?php if(count($companys) > 3) { ?>
                <div class="good-cat-more down">
                    <span>更多</span>
                </div>
                <?php } ?>
            </div>
            <div class="c_b"></div>
            <div class="cat-com">
                <div class="com-list">
                    <?php if(is_array($companys)) { foreach($companys as $k => $t) { ?>
                    <?php if(in_array($k,array(0,3,6))) { ?>
                    <div class="com-show">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);" /></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <li><img src="/skin/default/image/pro1.png"/></li>
                                <li><img src="/skin/default/image/pro2.png"/></li>
                            </ul>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="com-show com-show-m">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <li><img src="/skin/default/image/pro1.png"/></li>
                                <li><img src="/skin/default/image/pro2.png"/></li>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } } ?>
                </div>
            </div>
        </div>
        <div class="cat-detail">
            <?php $companys=tag("moduleid=4&condition=FIND_IN_SET(47,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");?>
            <div class="cat-title-bak">
                <div class="good-cat-title">
                    <span>实验室家具</span>
                </div>
                <?php if(count($companys) > 3) { ?>
                <div class="good-cat-more down">
                    <span>更多</span>
                </div>
                <?php } ?>
            </div>
            <div class="c_b"></div>
            <div class="cat-com">
                <div class="com-list">
                    <?php if(is_array($companys)) { foreach($companys as $k => $t) { ?>
                    <?php if(in_array($k,array(0,3,6))) { ?>
                    <div class="com-show">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <li><img src="/skin/default/image/pro1.png"/></li>
                                <li><img src="/skin/default/image/pro2.png"/></li>
                            </ul>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="com-show com-show-m">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <li><img src="/skin/default/image/pro1.png"/></li>
                                <li><img src="/skin/default/image/pro2.png"/></li>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } } ?>
                </div>
            </div>
        </div>
        <div class="cat-detail">
            <?php $companys=tag("moduleid=4&condition=FIND_IN_SET(48,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");?>
            <div class="cat-title-bak">
                <div class="good-cat-title">
                    <span>仪器设备</span>
                </div>
                <?php if(count($companys) > 3) { ?>
                <div class="good-cat-more down">
                    <span>更多</span>
                </div>
                <?php } ?>
            </div>
            <div class="c_b"></div>
            <div class="cat-com">
                <div class="com-list">
                    <?php if(is_array($companys)) { foreach($companys as $k => $t) { ?>
                    <?php if(in_array($k,array(0,3,6))) { ?>
                    <div class="com-show">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <li><img src="/skin/default/image/pro1.png"/></li>
                                <li><img src="/skin/default/image/pro2.png"/></li>
                            </ul>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="com-show com-show-m">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <li><img src="/skin/default/image/pro1.png"/></li>
                                <li><img src="/skin/default/image/pro2.png"/></li>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } } ?>
                </div>
            </div>
        </div>
        <div class="cat-detail">
            <?php $companys=tag("moduleid=4&condition=FIND_IN_SET(49,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");?>
            <div class="cat-title-bak">
                <div class="good-cat-title">
                    <span>采暖/热泵</span>
                </div>
                <?php if(count($companys) > 3) { ?>
                <div class="good-cat-more down">
                    <span>更多</span>
                </div>
                <?php } ?>
            </div>
            <div class="c_b"></div>
            <div class="cat-com">
                <div class="com-list">
                    <?php if(is_array($companys)) { foreach($companys as $k => $t) { ?>
                    <?php if(in_array($k,array(0,3,6))) { ?>
                    <div class="com-show">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <li><img src="/skin/default/image/pro1.png"/></li>
                                <li><img src="/skin/default/image/pro2.png"/></li>
                            </ul>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="com-show com-show-m">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <li><img src="/skin/default/image/pro1.png"/></li>
                                <li><img src="/skin/default/image/pro2.png"/></li>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } } ?>
                </div>
            </div>
        </div>
        <div class="cat-detail">
            <?php $companys=tag("moduleid=4&condition=FIND_IN_SET(50,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");?>
            <div class="cat-title-bak">
                <div class="good-cat-title">
                    <span>辅材/工具</span>
                </div>
                <?php if(count($companys) > 3) { ?>
                <div class="good-cat-more down">
                    <span>更多</span>
                </div>
                <?php } ?>
            </div>
            <div class="c_b"></div>
            <div class="cat-com">
                <div class="com-list">
                    <?php if(is_array($companys)) { foreach($companys as $k => $t) { ?>
                    <?php if(in_array($k,array(0,3,6))) { ?>
                    <div class="com-show">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <li><img src="/skin/default/image/pro1.png"/></li>
                                <li><img src="/skin/default/image/pro2.png"/></li>
                            </ul>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="com-show com-show-m">
                        <div class="com-show-left">
                            <div class="com-img">
                                <a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
                            </div>
                            <div class="com-name"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['company'];?></a></div>
                            <div>
                                <button class="com-concern">关注</button>
                                <button class="com-ask">立即咨询</button>
                            </div>
                        </div>
                        <div class="com-show-right">
                            <ul>
                                <li><img src="/skin/default/image/pro1.png"/></li>
                                <li><img src="/skin/default/image/pro2.png"/></li>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } } ?>
                </div>
            </div>
        </div>
        <div class="c_b"></div>
    </div>
    <div class="c_b"></div>
</div>
<?php include template('footer');?>