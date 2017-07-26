/**
 * Created by 邓锦龙 on 2017/4/7.
 */
function showImgDelay(imgObj, imgSrc, maxErrorNum) {
    if (maxErrorNum > 0) {
        imgObj.onerror = function () {
            showImgDelay(imgObj, imgSrc, maxErrorNum - 1);
        };

        setTimeout(function () {
            imgObj.src = imgSrc;
        }, 500);
        maxErrorNum = parseInt(maxErrorNum) - parseInt(1);
    }
}
