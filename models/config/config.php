<?php
return [

    'baseUrl' => 'http://www.ltecenet.com/',
    'wapUrl' => 'http://wap.tecenet.com/',
    'oldWapUrl' => 'http://wap2.tecenet.com/',  //旧版移动端地址
    'apiUrl' => 'http://api.tecenet.com',      //接口网站地址

    'cdn' => [
        'watermarkPic' => 'http://www.tecenet.com/skin/teceskin/images/watermark.JPG',
        'Qiniu' => [
            'baseUrl' => 'http://img.tecenet.com/', //图片代理域名
            'watermark' => [
                'gravity' => 'SouthEast',       //水印位置
                'dx' => 2,                        //水印横向据边距距离
                'dy' => 2,                        //水印竖向据边距距离
            ],
        ],

    ],

    'customerServer' => [
        'baidu' => "javascript:window.open('http://p.qiao.baidu.com/cps/chat?siteId=3215492&userId=6452136&s=tecenet.com','newwindow','height=530,width=600,top=100,left=200,toolbar=no,menubar=no,scrollbars=no,resizeable=no,lacation=no,status=no');_hmt.push(['_trackPageview', '/im/qiao']);",
    ],
];

?>