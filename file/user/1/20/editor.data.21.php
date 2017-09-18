<?php exit;?>2016-06-20 16:38:48<span style="line-height:1.5;">我院现有三台飞利浦单板的DR，型号为DigitalDiagnostVS，高压发生器最大功率是65KW，球管小焦点为0．6mm，大焦点为1．2mm，探测器尺寸为43cm×43cm，像素大小为143微米。探测器安装在胸片架上，探测器立起来时可以很方便的进行胸部、劲椎等部位的检查，也可以把探测器放平，将简易检查床置于探测器之上，进行腹部，盆腔等部位的检查。 机器已使用多年，其间出现一些故障，在此与同行共同探讨。<br />
<img src="http://www.tecenet.com/file/upload/201606/20/1635571220.jpg" alt="" /></span><br />
<span style="line-height:1.5;"><strong>故障现象1：</strong><br />
开机后操作台上准备指示灯不亮，并显示故障 代码03HJ，按下曝光手闸，不能进行曝光。查资料故障代码 03HJ指实际的球管灯丝电流不在范围内。此机器球管的灯丝工作原理是：高压发生器内的灯丝控制板把交流电压220伏整流成直流电压，并根据CPU板发出的灯丝预热指令，把低频直流电压逆变为高频的交流电压输送到高压油箱的灯丝变压器初级，经变压器变压后通过高压电缆输送到球管的大小灯丝。在灯丝控制板同时有灯丝反馈电路，实时监测灯丝的加热情况。 故障判断：查资料故障代码03HJ是指实际的球管灯丝电流不在范围内，其原因可能有以下几种：<br />
A：交流电压220伏未输到灯丝控制板。<br />
B：灯丝控制板故障导致没有电压输出。<br />
C：高压油箱内的变压器故障。<br />
D：阴极高压电缆断开。 <br />
E：球管的大或小焦点灯丝断开。<br />
<strong></strong><strong> 故障排除：</strong><br />
在高压油箱的灯丝变压器初级没有测到电压，故可能故障在高压油箱之前，灯丝控制板上测得有220伏交流电压输入，并测到有直流电压＋5V，＋26V，＋15V，－15V。故可能是灯丝控制板故障。拔出灯丝控制板测得板上的MOS场效应管V22，V23击穿断路，此管型号是IXFH15N60，于市场上购买此管安装 之后，机器可以正常使用。<br />
<img src="http://www.tecenet.com/file/upload/201606/20/1636159920.jpg" alt="" /></span><br />
<span style="line-height:1.5;"><strong>故障现象2：</strong><br />
机器开机正常，但在按下曝光手闸后，机器过 载指示灯亮，显示故障代码是02HG，查代码02HG（kVactual valueoutofrange），指实际的千伏值超出范围。 球管高压的工作原理是：千伏控制板接收到CPU控制板的处理指令信号后，把控制信号输到逆变器（由于高压发生器最大功率是65千瓦，故有两个逆变器），逆变器在此信号控制下把三相交流380伏整流为直流560伏，并把它逆变为高频信号输到高压油箱的高压变压器初级，高压变压器次级电压经整流成高压通过高压电缆输到球管。 故障判断：根据其工作原理分析可能故障原因为以下几点：</span><br />
<span style="line-height:1.5;">A：CPU控制板故障。<br />
B：千伏控制板故障。<br />
C：逆变器故障。 <br />
D：高压油箱及高压电缆故障。<br />
E：球管故障。<br />
<strong></strong><strong> 故障排除：</strong><br />
为观察曝光的实际情况，我们在曝光时用示波器测量实际千伏值，测量到阴极0千伏，阳极是0.39千伏，阳极实际千伏值高于阴极。我们分析可能是阴极故障引起曝光未完成，于是把两个逆变器互换，如果是逆变器故障，互换逆变器应该会是阳极实际千伏值低于阴极。但曝光用示波器测量到阳极实际千伏值仍高于阴极，故推断两个逆变器应该都是好的。互换阴极和阳极高压电缆，曝光用示波器测量到阳极实际千伏值还是高于阴极，故阴极和阳极高压电缆也都是好的。后把CPU控制板和千伏控制板拿去测试也是好的（同样机型），故问题部分就是球管，更换球管后就可以正常使用。<br />
<img src="http://www.tecenet.com/file/upload/201606/20/1636353320.jpg" alt="" /></span><br />
<span style="line-height:1.5;"><strong>故障现象3:</strong><br />
机器开机后在主机工作站的监视器右下角显 示：Walldetectornotconnected（胸片架探测器未连接上），按下曝光手闸，不能进行曝光，开关机器多次故障还是依旧。<br />
<strong></strong><strong> 故障判断：</strong>经分析是探测器与主机工作站通讯没有建立上。</span><br />
<span style="line-height:1.5;">可能原因是：</span><br />
<span style="line-height:1.5;">A：探测器本身故障。</span><br />
<span style="line-height:1.5;">B：探测器接口板故障。<br />
C：探测器与主机工作站之间的通讯线断路。<br />
D:主机工作站接口板故障。 <br />
<strong></strong><strong>故障排除：</strong><br />
我们首先查看探测器的自检和指示灯都是正常，故探测器应该是正常。探测器与主机工作站之间的通讯线有两条：一条是用于传输图像数据的光纤，把光纤两端都拆掉，一端用手电照着，可以在光纤的另一端能看到光，证明光纤是好的。另一条是用于探测器与主机工作站之间的通讯用RS232数据线，用万用表测量到RS232数据线是好的，但是发现数据线在主机工作站端的针脚有些氧化，用酒精处理后，重新开机，探测器和工作站通讯正常，机器可以正常使用。</span><br />
<span style="line-height:1.5;"><strong>小结:</strong><br />
维修前了解机器的工作原理，分析故障的可能原因，以及可能的故障部分，采取合适的维修方法，如由易而难，分段判断等方法，即可能达到事半功倍的效果。<br />
<img src="http://www.tecenet.com/file/upload/201606/20/1638204520.jpg" alt="" /><br />
</span><strong><span class="bfcolor" style="color:#00BBEC;">天骄医疗<br />
</span></strong><span style="font-family:微软雅黑;color:#C00000;"><strong>天骄医疗</strong></span><span style="font-family:微软雅黑;">专为医疗机构、生产厂商、经销商提供设备安装、调试、巡查、保养、维修等技术服务，及整体打包服务等。</span><strong>整体打包服务：</strong><span style="font-family:微软雅黑;">石小姐13600073722</span><strong>技术服务：</strong><span style="font-family:微软雅黑;">谭先生13922493350</span><strong>市场服务：</strong><span style="font-family:微软雅黑;">彭先生13660792045</span><strong>配件服务：</strong><span style="font-family:微软雅黑;">夏先生18689306099</span><strong>网络平台运营：</strong><span style="font-family:微软雅黑;">杨小姐15920140064<br />
</span><strong><span style="color:#000000;">服务微信号：</span></strong><span style="font-family:微软雅黑;">yangbing0064<br />
</span><span style="color:#3E3E3E;font-family:微软雅黑;"><strong><span style="color:#000000;">QQ：</span></strong><span style="color:#000000;">2012195250</span></span><span style="color:#3E3E3E;"></span>