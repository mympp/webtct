<?php exit;?>2015-07-06 14:03:44<p style="line-height: 21px;"><span style="font-size: 16px;"><span style="line-height: 0px;">﻿</span>互联网上有很多关于网站架构的各种分享，有些主要是从运维和基础架构的角度去分析的（堆机器，做集群），太关注技术细节实现，普通的开发人员基本看不太懂。</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><br />
</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;">本文上篇将主要介绍大型网站基础架构的扩展，下篇则重点从应用程序的角度去介绍网站架构的扩展和演变。</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><br />
</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;">草根时期，快速开发网站并上线。当然，通常只是先试水，用户规模也没有形成，经济能力和投入也非常有限。</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><br />
</span></p>
<p><img width="320" widthd="874" height="auto" heightd="576" style="width: 810px !important; height: auto !important; visibility: visible !important;" src="http://www.tecenet.com/file/upload/weixin/image/KqJwozCG9MdbhiccbiaKuhG7vSgyxia3XM3OZSEB7iarAfNR5V3NT2jvE5uZjF6hDOscSe7uKibHAr7xupxSvF2dvDA.png#" data-w="" data-ratio="0.6594488188976378" data-type="png" alt="" /></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">有一定的业务量和用户规模了，想提升网站速度，于是，缓存出场了。</span></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;"><br />
</span></p>
<p style="line-height: 1.5em;"><img width="320" widthd="810" style="width: 810px !important; height: auto !important; visibility: visible !important;" src="http://www.tecenet.com/file/upload/weixin/image/KqJwozCG9MdbhiccbiaKuhG7vSgyxia3XM3mUTQkeo63cWyl2ul2HyRe2WrdVePiaoPxo6FQaaVicmhcMrKvbRwDLWQ.png#" data-w="" data-ratio="0.051181102362204724" data-type="png" alt="" /></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">市场反响还不错，用户量每天在增长，数据库疯狂读写，逐渐发现一台服务器快撑不住了。于是，决定把DB和APP做分离。</span></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;"><br />
</span></p>
<p style="line-height: 1.5em;"><img width="320" widthd="810" style="width: 810px !important; height: auto !important; visibility: visible !important;" src="http://www.tecenet.com/file/upload/weixin/image/KqJwozCG9MdbhiccbiaKuhG7vSgyxia3XM3jMibeLs5XZQLuDBN9rZudyv1DHXiaAZPB43Ihic8j9XJKFxb5HpEMyycg.jpeg#" data-w="" data-ratio="0.051181102362204724" data-type="jpeg" alt="" /></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">单台数据库也感觉快撑不住了，一般都会尝试做&ldquo;读写分离&rdquo;。由于大部分互联网&ldquo;读多写少&rdquo;的特性所决定的。Salve的台数，取决于按业务评估的读写比例。</span></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;"><br />
</span></p>
<p style="line-height: 1.5em;"><img width="320" widthd="810" style="width: 810px !important; height: auto !important; visibility: visible !important;" src="http://www.tecenet.com/file/upload/weixin/image/KqJwozCG9MdbhiccbiaKuhG7vSgyxia3XM3pSnXoiavyQqfY9Llpc7auJwdLdCRtxD9hIbSem0z1YhicTNLPCxUHuBQ.jpeg#" data-w="" data-ratio="0.051181102362204724" data-type="jpeg" alt="" /></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">数据库层面是缓解了，但是应用程序层面也出现了瓶颈，由于访问量增大，加上早期程序员水平有限写的代码也很烂，人员流动性也大，很难去维护和优化。所以，很常用的办法还是&ldquo;堆机器&rdquo;。</span></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;"><br />
</span></p>
<p style="line-height: 1.5em;"><img width="320" widthd="810" style="width: 810px !important; height: auto !important; visibility: visible !important;" src="http://www.tecenet.com/file/upload/weixin/image/KqJwozCG9MdbhiccbiaKuhG7vSgyxia3XM3icVeoSia0WBoMA2pUHk18TErUvic51zgjQLnyIiaicDJ66145OG5EUotWyQ.jpeg#" data-w="" data-ratio="0.051181102362204724" data-type="jpeg" alt="" /></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">加机器谁都会加，关键是加完之后得有效果，加完之后可能会引发一些问题。例如非常常见的：页面输出缓存和本地缓存的问题，Session保存的问题......</span></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;"><br />
</span></p>
<p style="line-height: 1.5em;"><img width="320" widthd="810" style="width: 810px !important; height: auto !important; visibility: visible !important;" src="http://www.tecenet.com/file/upload/weixin/image/KqJwozCG9MdbhiccbiaKuhG7vSgyxia3XM3xo57f1icODz0&#120;nOiaicmSicBXEaoI58zyahnUmG4EsxlCjbpCLRudPiaBjg.png#" data-w="" data-ratio="0.051181102362204724" data-type="png" alt="" /></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">到这里，已经基本做到了<span style="font-family: Times New Roman;">DB</span><span style="font-family: 宋体;">层面和应用层面的横向扩展了，可以开始关注一些其它方面，例如：站内搜索的精准度，对</span><span style="font-family: Times New Roman;">DB</span><span style="font-family: 宋体;">的依赖，开始引入全文索引。</span></span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><span style="font-family: 宋体;"><br />
</span></span><span style="font-size: 16px;">Java<span style="font-family: 宋体;">领域用的较多的是</span><span style="font-family: Times New Roman;">Lucene</span><span style="font-family: 宋体;">、</span><span style="font-family: Times New Roman;">Solr</span><span style="font-family: 宋体;">等，而</span><span style="font-family: Times New Roman;">php</span><span style="font-family: 宋体;">领域用的比较多的是</span><span style="font-family: Times New Roman;">sphinx/coreseek</span><span style="font-family: 宋体;">。</span></span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><span style="font-family: 宋体;"><br />
</span></span></p>
<p><img width="320" widthd="810" style="width: 810px !important; height: auto !important; visibility: visible !important;" src="http://www.tecenet.com/file/upload/weixin/image/KqJwozCG9MdbhiccbiaKuhG7vSgyxia3XM3SK3twLqPCjfgfpBpY7ic3hpHXIAiaqCAnFmpyAppHImiajBicmq2Wt2qFQ.jpeg#" data-w="" data-ratio="0.04330708661417323" data-type="jpeg" alt="" /></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">到目前为止，一个能够承载日均百万级访问量的中型网站架构基本介绍完了。当然，每一步扩展里面都会有很多技术实现的细节，后续有时间会写文章单独去剖析那些细节。</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">在做扩展满足了基本的性能需求后，我们会逐渐关注<span style="font-family: Times New Roman;">&ldquo;</span><span style="font-family: 宋体;">可用性</span><span style="font-family: Times New Roman;">&rdquo;</span><span style="font-family: 宋体;">（也就是我们通常听别人吹牛时说的</span><span style="font-family: Times New Roman;">SLA</span><span style="font-family: 宋体;">、几个</span><span style="font-family: Times New Roman;">9</span><span style="font-family: 宋体;">）。如何保证真正</span><span style="font-family: Times New Roman;">&ldquo;</span><span style="font-family: 宋体;">高可用</span><span style="font-family: Times New Roman;">&rdquo;</span><span style="font-family: 宋体;">，也是个难题。</span></span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><span style="font-family: 宋体;"><br />
</span></span></p>
<p style="line-height: 1.5em;"><img width="320" widthd="810" style="width: 810px !important; height: auto !important; visibility: visible !important;" src="http://www.tecenet.com/file/upload/weixin/image/KqJwozCG9MdbhiccbiaKuhG7vSgyxia3XM3zoJLdZfy7wCIqY1usczYLpLCXmF4R2Rn1pqeAUPsrWsuIfgcVK1r0w.jpeg#" data-w="" data-ratio="0.051181102362204724" data-type="jpeg" alt="" /></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">几乎主流的大中型互联网公司，都会有用到类似的架构，只是节点数不同而已。</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">还有一招用的比较多的，那就是动静分离。可以需要开发人员配合（把静态资源放独立站点下），也可以不需要开发人员配合（利用<span style="font-family: Times New Roman;">7</span><span style="font-family: 宋体;">层反向代理来处理，根据后缀名 等信息来判断资源类型）。有了单独的静态文件服务器之后，存储也是个问题，也需要扩展。多台服务器的文件怎么保持一致，买不起共享存储怎么办？分布式文件 系统也派上用场了。</span></span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><span style="font-family: 宋体;"><br />
</span></span></p>
<p style="line-height: 1.5em;"><img width="320" widthd="810" style="width: 810px !important; height: auto !important; visibility: visible !important;" src="http://www.tecenet.com/file/upload/weixin/image/KqJwozCG9MdbhiccbiaKuhG7vSgyxia3XM3nUlOG5xymicht1M5NiavOelBQ9CQeb5yqmecNBu6xA6ABY9wYTOTaxJQ.jpeg#" data-w="" data-ratio="0.051181102362204724" data-type="jpeg" alt="" /></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;">还有一项目前国内外用的非常普遍的技术<span style="font-family: Times New Roman;">CDN</span><span style="font-family: 宋体;">加速。目前该领域竞争激烈，也已经比较便宜了。国内南北互联网问题比较严重，使用</span><span style="font-family: Times New Roman;">CDN</span><span style="font-family: 宋体;">可以有效解决这个问题。</span></span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><span style="font-family: 宋体;"><br />
</span></span><span style="font-size: 16px;">CDN<span style="font-family: 宋体;">的基本原理并不复杂，可以理解为智能</span><span style="font-family: Times New Roman;">DNS+Squid</span><span style="font-family: 宋体;">反向代理缓存 ，然后需要有很多机房节点提供访问。</span></span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><span style="font-family: 宋体;"><br />
</span></span></p>
<p>&nbsp;</p>
<p style="line-height: 1.5em;"><img width="320" widthd="810" style="width: 810px !important; height: auto !important; visibility: visible !important;" src="http://www.tecenet.com/file/upload/weixin/image/KqJwozCG9MdbhiccbiaKuhG7vSgyxia3XM3Z7icU6VlyEw10yUrWmzVM3IVkWVBWBEktRq2PLWZnpfU4bfeFMWjTYw.jpeg#" data-w="" data-ratio="0.051181102362204724" data-type="jpeg" alt="" /><span style="font-size: 16px;">截止目前为止，都没有怎么去改动应用程序的架构，或者说通俗点，都不怎么需要大面积的修改代码。</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">如果上面那些手段都用光了，还是支撑不住怎么办？不停的加机器也不是办法啊？</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><br />
</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;">随着业务越来越复杂，网站的功能越来越多，虽然部署层面是采用的集群，但是应用程序架构层面还是<span style="font-family: Times New Roman;">&ldquo;</span><span style="font-family: 宋体;">集中式</span><span style="font-family: Times New Roman;">&rdquo;</span><span style="font-family: 宋体;">的，这样会导致很多耦合，不便于开发、维护，而且容易</span><span style="font-family: Times New Roman;">&ldquo;</span><span style="font-family: 宋体;">一荣俱损</span><span style="font-family: Times New Roman;">&rdquo;</span><span style="font-family: 宋体;">。所以，通常会把网站拆分出不同的子站点来单独宿主。</span></span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><span style="font-family: 宋体;"><br />
</span></span><span style="font-size: 16px;">应用都拆了，由于单个数据库的连接，<span style="font-family: Times New Roman;">QPS</span><span style="font-family: 宋体;">，</span><span style="font-family: Times New Roman;">TPS</span><span style="font-family: 宋体;">，</span><span style="font-family: Times New Roman;">I/O</span><span style="font-family: 宋体;">处理能力都非常有限，</span><span style="font-family: Times New Roman;">DB</span><span style="font-family: 宋体;">层面也可以去做垂直分库操作拆分应用和</span><span style="font-family: Times New Roman;">DB</span><span style="font-family: 宋体;">之后，其实还是会有很多问题。不同的站点，里面可能会有相同逻辑和功能的代码。当然，对于一些基础的功能我们可以封装</span><span style="font-family: Times New Roman;">DLL</span><span style="font-family: 宋体;">或者</span><span style="font-family: Times New Roman;">Jar</span><span style="font-family: 宋体;">包去到 处提供引用，但是这种强依赖也很容易造成一些问题（版本问题、依赖关系等处理起来非常麻烦）。这样，传说中的</span><span style="font-family: Times New Roman;">SOA</span><span style="font-family: 宋体;">的价值就得到体现了。</span></span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><br />
</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;">应用、服务之间还是会出现一些依赖问题，这时候，高吞吐量的解耦利</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;">器出现了</span></p>
<p style="line-height: 21px;"><span style="font-size: 16px;"><br />
</span></p>
<p><img width="320" widthd="810" style="width: 810px !important; height: auto !important; visibility: visible !important;" src="http://www.tecenet.com/file/upload/weixin/image/KqJwozCG9MdbhiccbiaKuhG7vSgyxia3XM3l4UKUwQcyGcvD1UV1XI30WVcGmIU4I1kibrvibZBiaiaZ00W6hYuxmaQ5g.png#" data-w="" data-ratio="0.04330708661417323" data-type="png" alt="" /></p>
<p style="line-height: 1.5em;"><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">最后，还介绍一个大型互联网公司都用的绝技--分库分表。个人经验，不是业务发站和各方面非常迫切，不要轻易走这一步。</span></p>
<p style="line-height: 1.5em; "><span style="font-size: 16px;"><br />
</span><span style="font-size: 16px;">因为分库分表谁都会干，关键是拆完之后怎么办。目前，市面上还没有完全开源免费的方案，能让你一劳永逸地解决数据库拆分问题。</span></p>
<blockquote class="brcolor" style="padding:10px; border-top-width: 3px; border-right-width: 3px; border-bottom-width: 3px; border-style: dotted; border-color: rgb(80, 130, 189); font-size: 17.1428565979004px; white-space: normal; border-radius: 5px !important;">
<h3 style="color: rgb(89, 89, 89); font-size: 14px; margin: 0px;"><span style="color: rgb(255, 255, 255); padding: 2px 5px; font-size: 16px; margin-right: 15px; border-radius: 5px !important; background-color: rgb(80, 130, 189);">天成医疗-电子商务部</span></h3>
<p><span style="font-size: 16px;">一家专门为医疗机构、生产厂家和经销商提供专业技术和产品服务的电子商务交易平台，关注我们，千千万万个商业机会等着你。</span></p>
<p><span style="font-size: 16px;">更多服务内容请登录<br />
<strong style="margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important;"><span style="font-size: 16px; margin: 0px; padding: 0px; max-width: 100%; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;">www.tecenet.com</span></strong></span></p>
<p><span style="font-size: 16px;">服务热线：<span style="font-size: 16px; margin: 0px; padding: 0px; max-width: 100%; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;">40000521617</span></span></p>
<p><span style="margin: 0px; padding: 0px; max-width: 100%; font-family: 宋体; font-size: 16px; box-sizing: border-box !important; word-wrap: break-word !important;">微信号：<strong style="margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important;"><span style="margin: 0px; padding: 0px; max-width: 100%; font-size: 16px; color: rgb(0, 176, 240); box-sizing: border-box !important; word-wrap: break-word !important;">tianchengyiliao</span></strong></span></p>
</blockquote>
<p>&nbsp;</p>