<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<script type="text/javascript">var module_id= <?php echo $moduleid;?>,item_id=<?php echo $itemid;?>,content_id='content',img_max_width=<?php echo $MOD['max_width'];?>;</script>
<div class="m">
    <div class="mall_top">
        <div class="pos"><a href="<?php echo $MODULE['1']['linkurl'];?>">首页</a> &gt;<?php echo cat_pos($CAT, ' &gt; ');?>  &gt;</div>
        <div class="b10 c_b"></div>
        <div class="m">
            <div class="s_content_top">
                <div class="s_content_left f_l">
                    <div id="mid_pos"></div>
                    <div id="mid_div" onmouseover="SAlbum();" onmouseout="HAlbum();" onclick="PAlbum(Dd('mid_pic'));">
                        <img src="<?php echo $albums['0'];?>" id="mid_pic"/><span id="zoomer"></span>
                        <div id="big_div" style="display:none;"><img src="" id="big_pic"/></div>
                    </div>
                    <div style="margin-top: 10px;">
                        <?php if(is_array($thumbs)) { foreach($thumbs as $k => $v) { ?><img src="<?php echo $v;?>" width="60" height="60" onmouseover="if(this.src.indexOf('nopic60.gif')==-1)Album(<?php echo $k;?>, '<?php echo $albums[$k];?>');" class="<?php if($k) { ?><?php if($k==3) { ?>lastab_im<?php } else { ?>ab_im<?php } ?>
<?php } else { ?><?php if($k==3) { ?>lastab_on<?php } else { ?>ab_on<?php } ?>
<?php } ?>
" id="t_<?php echo $k;?>"/><?php } } ?>
                    </div>
                </div>
                <div class="s_content_middle f_l">
                    <div class="s_middle_title"><?php echo $title;?></div>
                    <div class="s_middle_nr">
                        <ul>
                            <li>市场价：<span style="text-decoration:line-through;">￥<?php echo $p1;?></span></li>
                            <li>售　价：<span style="font-size: 20px;color: #ff6b33">￥<?php echo $p1;?></span></li>
                            <li>产　地：<?php echo $mfrs;?></li>
                            <li><span class="f_l" style="margin-right: 45px;">已　售：<?php echo $sales;?></span><span class="f_l">库　存：<?php echo $amount;?></span><div class="c_b"></div></li>
                            <li>运　费：<?php echo $express['fee_start'];?>元</li>
                            <li>快递说明：<?php echo $express['note'];?></li>
                        </ul>
                    </div>
                    <div class="s_middle_sum">
                        <span class="f_l" style="padding: 7px 7px 0 10px">购买数量：</span>
                        <div class="sumit_minus f_l" onclick="Malter('-', <?php echo $a1;?>, <?php echo $amount;?>);">-</div>
                        <input type="text" value="<?php echo $a1;?>" size="4" class="cc_inp f_l" id="amount" onkeyup="Malter('', <?php echo $a1;?>, <?php echo $amount;?>);"/>
                        <div class="sumit_minus f_l"  onclick="Malter('+', <?php echo $a1;?>, <?php echo $amount;?>);">+</div>
                    </div>
                    <button  class="BuyNow mall_botton" onclick="BuyNow();">立即购买</button>
                    &nbsp;
                    <button  class="AddCart mall_botton" onclick="AddCart();">加入进货单</button>
                </div>
                <div class="s_content_right f_l">
                    <div class="s_right_title">
                        <span class="f_l">猜你喜欢</span>
                        <div class="mall_up mall_icon f_l"></div>
                        <div class="mall_down mall_icon f_l"></div>
                        <div class="c_b"></div>
                    </div>
                    <div class="s_img">
                        <ul>
                            <li>
                                <a href="">
                                    <img src="" alt="" style="background: #bad8f2;width: 120px; height: 120px;"/>
                                    <span>安普AMP 超五类非屏蔽电缆...</span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="" alt="" style="background: #bad8f2;width: 120px; height: 120px;"/>
                                    <span>安普AMP 超五类非屏蔽电缆...</span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="" alt="" style="background: #bad8f2;width: 120px; height: 120px;"/>
                                    <span>安普AMP 超五类非屏蔽电缆...</span>
                                </a>
                            </li>
                            <div class="c_b"></div>
                        </ul>
                    </div>
                </div>
                <div class="c_b"></div>
            </div>
            <div class="s_content_bottom">
                <div class="s_bottom_left f_l">
                    <div class="hot_mall">
                        <div class="hot_title">
                            <li><span>热门推荐</span></li>
                        </div>
                        <div class="hot_img">
                            <ul>
                                <li>
                                    <a href="">
                                        <img src="" alt="" style="background: #000;"/>
                                        <div class="hot_mall_title">安普AMP 超五类非屏蔽电缆6-219586-4 305米每箱</div>
                                        <div class="hot_mall_money">¥178.00</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="" alt="" style="background: #000;"/>
                                        <div class="hot_mall_title">安普AMP 超五类非屏蔽电缆6-219586-4 305米每箱</div>
                                        <div class="hot_mall_money">¥178.00</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="" alt="" style="background: #000;"/>
                                        <div class="hot_mall_title">安普AMP 超五类非屏蔽电缆6-219586-4 305米每箱</div>
                                        <div class="hot_mall_money">¥178.00</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="" alt="" style="background: #000;"/>
                                        <div class="hot_mall_title">安普AMP 超五类非屏蔽电缆6-219586-4 305米每箱</div>
                                        <div class="hot_mall_money">¥178.00</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="" alt="" style="background: #000;"/>
                                        <div class="hot_mall_title">安普AMP 超五类非屏蔽电缆6-219586-4 305米每箱</div>
                                        <div class="hot_mall_money">¥178.00</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="Advertising">
                        <img src="../../../skin/default/image/Advertising.jpg" alt=""/>
                        <img src="../../../skin/default/image/Advertising.jpg" alt=""/>
                        <img src="../../../skin/default/image/Advertising.jpg" alt=""/>
                    </div>
                </div>
                <div class="s_bottom_right f_l">
                    <div class="mall_tab">
                        <ul>
                            <li class="mall_tab_2" id="t_detail"><a href="#detail" name="detail" onclick="Mshow('detail');">商品详情</a></li>
                            <li class="mall_tab_1" id="t_type"><a href="#type" name="type" onclick="Mshow('type');">规格参数</a></li>
                            <li class="mall_tab_1" id="t_comment"><a href="#comment" name="comment" onclick="Mshow('comment');">商品问答(<?php echo $comments;?>)</a></li>
                            <li class="mall_tab_1" id="t_order"><a href="#order" name="order" onclick="Mshow('order');">售后保障(<?php echo $orders;?>)</a></li>
                        </ul>
                    </div>
                    <div id="detail" class="mall_detail mall_border no_bortop" name="detail">
                        <div class="max_title">品牌：AMP NETCONNECT</div>
                        <div class="min_title">商品名称：<?php echo $title;?></div>
                        <div class="min_title">商品编号：<?php echo $mallid;?></div>
                        <?php if($type1) { ?><div class="min_title"><?php echo $type1;?>：<?php echo $value1;?></div><?php } ?>
                        <?php if($type2) { ?><div class="min_title"><?php echo $type2;?>：<?php echo $value2;?></div><?php } ?>
                        <?php if($type3) { ?><div class="min_title"><?php echo $type3;?>：<?php echo $value3;?></div><?php } ?>
                        <?php if($type4) { ?><div class="min_title"><?php echo $type4;?>：<?php echo $value4;?></div><?php } ?>
                        <?php if($type5) { ?><div class="min_title"><?php echo $type5;?>：<?php echo $value5;?></div><?php } ?>
                        <div class="f_r"><a href="#type">更多参数&gt;&gt;</a></div>
                        <div class="c_b"></div>
                    </div >
                    <div class="mall_content margin_bottom20"><?php echo $content;?></div>
                    <div id="type" name="type" class="mall_type ">
                        <div class="mall_title">
                            规格参数
                        </div>
                        <div class="mall_border">
                            <ul>
                                <li class="">商品名称：<?php echo $title;?></li>
                                <li class="">商品编号：<?php echo $mallid;?></li>
                                <?php if($type1) { ?><li class=""><?php echo $type1;?>：<?php echo $value1;?></li><?php } ?>
                                <?php if($type2) { ?><li class=""><?php echo $type2;?>：<?php echo $value2;?></li><?php } ?>
                                <?php if($type3) { ?><li class=""><?php echo $type3;?>：<?php echo $value3;?></li><?php } ?>
                                <?php if($type4) { ?><li class=""><?php echo $type4;?>：<?php echo $value4;?></li><?php } ?>
                                <?php if($type5) { ?><li class=""><?php echo $type5;?>：<?php echo $value5;?></li><?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div id="comment" name="comment" class="mall_comment">
                        <div class="mall_title">
                            商品问答
                        </div>
                        <div class="mall_border">
                            <div class="comment_div">
                                <div class="user_time"><div class="f_l user_left"> 会员 ：<span>定***司</span></div><div class="f_l time">2017-02-11 09:46:22</div><div class="c_b"></div></div>
                                <div class="">Q：这个线的线径是多少？0.5的吗？</div>
                                <div class="business"><div class="f_l">A：您好！此款商品的线径是0.5的。感谢您的支持，若还有疑问可咨询我们在线客服或客服热线。</div><div class="f_r time">2017-02-11 09:46:22</div><div class="c_b"></div></div>
                            </div>
                            <div class="comment_div">
                                <div class="user_time"><div class="f_l user_left"> 会员 ：<span>定***司</span></div><div class="f_l time">2017-02-11 09:46:22</div><div class="c_b"></div></div>
                                <div class="">Q：这个线的线径是多少？0.5的吗？</div>
                                <div class="business"><div class="f_l">A：您好！此款商品的线径是0.5的。感谢您的支持，若还有疑问可咨询我们在线客服或客服热线。</div><div class="f_r time">2017-02-11 09:46:22</div><div class="c_b"></div></div>
                            </div>
                            <div class="comment_div">
                                <div class="user_time"><div class="f_l user_left"> 会员 ：<span>定***司</span></div><div class="f_l time">2017-02-11 09:46:22</div><div class="c_b"></div></div>
                                <div class="">Q：这个线的线径是多少？0.5的吗？</div>
                                <div class="business"><div class="f_l">A：您好！此款商品的线径是0.5的。感谢您的支持，若还有疑问可咨询我们在线客服或客服热线。</div><div class="f_r time">2017-02-11 09:46:22</div><div class="c_b"></div></div>
                            </div>
                            <div class="comment_div">
                                <div class="user_time"><div class="f_l user_left"> 会员 ：<span>定***司</span></div><div class="f_l time">2017-02-11 09:46:22</div><div class="c_b"></div></div>
                                <div class="">Q：这个线的线径是多少？0.5的吗？</div>
                                <div class="business"><div class="f_l">A：您好！此款商品的线径是0.5的。感谢您的支持，若还有疑问可咨询我们在线客服或客服热线。</div><div class="f_r time">2017-02-11 09:46:22</div><div class="c_b"></div></div>
                            </div>
                            <div class="comment_div">
                                <div class="user_time"><div class="f_l user_left"> 会员 ：<span>定***司</span></div><div class="f_l time">2017-02-11 09:46:22</div><div class="c_b"></div></div>
                                <div class="">Q：这个线的线径是多少？0.5的吗？</div>
                                <div class="business"><div class="f_l">A：您好！此款商品的线径是0.5的。感谢您的支持，若还有疑问可咨询我们在线客服或客服热线。</div><div class="f_r time">2017-02-11 09:46:22</div><div class="c_b"></div></div>
                            </div>
                            page
                        </div>
                    </div>
                    <div id="order" name="order" class="mall_order">
                        <div class="mall_title">
                            售后保障
                        </div>
                        <div class="mall_border">
                            关于退换货：<br>
                            1、当您收到商品有任何问题需要退回时，请在会员中心先提交申请, 保留原盒包装并联系我们客服人员，待收到原盒包装的退货后为您处理；<br>
                            2、退回商品运费请勿采用“到付”形式，会拒收到付，如涉及需河姆渡承担运费事宜我们将在收货后2-5个工作日内将运费返还到您账户的余额。<br>
                            3、定制机、项目配单中的项目机在无质量问题的情况下不支持退换货，若只退一部分商品，报价需要重新调整。<br>
                            关于签收：<br>
                            1、所有商品烦请当面进行验收，如签字确认后出现的破损不能做退换处理；<br>
                            2、若送货员拒绝验货，请拒绝签收并及时联系我们客服人员为您处理。<br>
                            关于发票：<br>
                            1、常规情况下发票将在发货后的三个工作日寄出；<br>
                            2、发票分为增值税普通发票和增值税专用发票两种，开具增值税专用发票需满足税务局规定的三证与税务登记信息与打款公司一致的条件（事先申请）。
                        </div>
                    </div>
                    <div class="mall_c" style="display:none;" id="c_comment">
                    </div>
                    <div class="mall_c" style="display:none;" id="c_order">
                    </div>
                    <div class="c_b"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/album.js"></script>
<?php if($content) { ?><script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/content.js"></script><?php } ?>
<script type="text/javascript">
    var mallurl = '<?php echo $MOD['linkurl'];?>';
    var mallid = <?php echo $itemid;?>;
    var n_c = <?php echo $comments;?>;
    var n_o = <?php echo $orders;?>;
    var c_c = Dd('c_comment').innerHTML;
    var c_o = Dd('c_order').innerHTML;
    var s_s = {'1':0,'2':0,'3':0};
    var m_l = {
        no_comment:'暂无评论',
        no_order:'暂无交易',
        no_goods:'商品不存在或已下架',
        no_self:'不能添加自己的商品',
        lastone:''
    };
</script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/mall.js"></script>
<script type="text/javascript">
    <?php if($P1) { ?>addE(1);<?php } ?>
    <?php if($P2) { ?>addE(2);<?php } ?>
    <?php if($P3) { ?>addE(3);<?php } ?>
    if(window.location.href.indexOf('#') != -1) {
        var t = window.location.href.split('#');
        try {Mshow(t[1]);} catch(e) {}
    }
</script>
<?php include template('footer');?>