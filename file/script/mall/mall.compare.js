// 删除对比项
    function compareRemoveItem(id){
        var compareAmount =  $(".compare-table .product-remove").length;
        compareAmount < 3 ? alert("最少需要保留两条产品信息") : $("td[id*="+id+"]").remove();
    }