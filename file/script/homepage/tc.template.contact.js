// 百度地图API功能
var address = document.getElementById("tpContactAddress").innerHTML;
var map = new BMap.Map("allmap");
var point = new BMap.Point(116.331398,39.897445);
map.centerAndZoom(point,12);
// 创建地址解析器实例
var myGeo = new BMap.Geocoder();
// 将地址解析结果显示在地图上,并调整地图视野
myGeo.getPoint(address, function(point){
    if (point) {
        document.getElementById("allmap").style.display="block";

        map.centerAndZoom(point, 16);
        map.addOverlay(new BMap.Marker(point));
    }else{
        console.log("您选择地址没有解析到结果!");
    }
}, "北京市");
