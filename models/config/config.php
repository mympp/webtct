<?php
return [

    'baseUrl' => 'http://www.tecenet.com/',
    'wapUrl' => 'http://wap.tecenet.com/',

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
];

?>