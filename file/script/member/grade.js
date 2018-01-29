// 企业会员弹框
$(".enterprise .grade-btn").click(function(){
    $("#enterpriseModal").modal('show');
});
$('#enterpriseModal').on('hidden.bs.modal', function (e) {
    $('#enterpriseModal').validator("cleanUp");
});

// 日期插件
jQuery.datetimepicker.setLocale('ch');
var modal = (function() {
    var initDate = function(startDateTimeId,endDateTimeId) {
        var startDateTimeId="#"+startDateTimeId;
        var endDateTimeId="#"+endDateTimeId;
        jQuery(startDateTimeId).datetimepicker({
            format:'Y-m-d',
            scrollMonth:true,
            scrollInput:false,
            onShow:function( ct ){
                this.setOptions({
                    maxDate:jQuery(endDateTimeId).val()?jQuery(endDateTimeId).val():false
                })
            },
            timepicker:false
        });
        jQuery(endDateTimeId).datetimepicker({
            format:'Y-m-d',
            scrollMonth:true,
            scrollInput:false,
            onShow:function( ct ){
                this.setOptions({
                    minDate:jQuery(startDateTimeId).val()?jQuery(startDateTimeId).val():false
                })
            },
            timepicker:false
        });
    };
    return {
        initDate: initDate
    };
})();
modal.initDate("certDateStart_1","certDateEnd_1");
modal.initDate("certDateStart_2","certDateEnd_2");


// vip会员弹框
$(".vip .grade-btn").click(function(){
    $("#vipModal").modal('show');
});