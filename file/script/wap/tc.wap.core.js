;(function (win, lib) {
    var doc = win.document;
    var docEl = doc.documentElement;
    var metaEl = doc.querySelector('meta[name="viewport"]');
    var flexibleEl = doc.querySelector('meta[name="flexible"]');
    var dpr = 0;
    var scale = 0;
    var tid;
    var flexible = lib.flexible || (lib.flexible = {});

    if (metaEl) {
        console.warn('将根据已有的meta标签来设置缩放比例');
        var match = metaEl.getAttribute('content').match(/initial\-scale=([\d\.]+)/);
        if (match) {
            scale = parseFloat(match[1]);
            dpr = parseInt(1 / scale);
        }
    } else if (flexibleEl) {
        var content = flexibleEl.getAttribute('content');
        if (content) {
            var initialDpr = content.match(/initial\-dpr=([\d\.]+)/);
            var maximumDpr = content.match(/maximum\-dpr=([\d\.]+)/);
            if (initialDpr) {
                dpr = parseFloat(initialDpr[1]);
                scale = parseFloat((1 / dpr).toFixed(2));
            }
            if (maximumDpr) {
                dpr = parseFloat(maximumDpr[1]);
                scale = parseFloat((1 / dpr).toFixed(2));
            }
        }
    }

    if (!dpr && !scale) {
        var isAndroid = win.navigator.appVersion.match(/android/gi);
        var isIPhone = win.navigator.appVersion.match(/iphone/gi);
        var devicePixelRatio = win.devicePixelRatio;
        if (isIPhone) {
            // iOS下，对于2和3的屏，用2倍的方案，其余的用1倍方案
            if (devicePixelRatio >= 3 && (!dpr || dpr >= 3)) {
                dpr = 3;
            } else if (devicePixelRatio >= 2 && (!dpr || dpr >= 2)) {
                dpr = 2;
            } else {
                dpr = 1;
            }
        } else {
            // 其他设备下，仍旧使用1倍的方案
            dpr = 1;
        }
        scale = 1 / dpr;
    }

    docEl.setAttribute('data-dpr', dpr);
    if (!metaEl) {
        metaEl = doc.createElement('meta');
        metaEl.setAttribute('name', 'viewport');
        metaEl.setAttribute('content', 'initial-scale=' + scale + ', maximum-scale=' + scale + ', minimum-scale=' + scale + ', user-scalable=no');
        if (docEl.firstElementChild) {
            docEl.firstElementChild.appendChild(metaEl);
        } else {
            var wrap = doc.createElement('div');
            wrap.appendChild(metaEl);
            doc.write(wrap.innerHTML);
        }
    }

    function refreshRem() {
        var width = docEl.getBoundingClientRect().width;
        if (width / dpr > 540) {
            width = 540 * dpr;
        }
        var rem = width / 10;
        docEl.style.fontSize = rem + 'px';
        flexible.rem = win.rem = rem;
    }

    win.addEventListener('resize', function () {
        clearTimeout(tid);
        tid = setTimeout(refreshRem, 300);
    }, false);
    win.addEventListener('pageshow', function (e) {
        if (e.persisted) {
            clearTimeout(tid);
            tid = setTimeout(refreshRem, 300);
        }
    }, false);

    if (doc.readyState === 'complete') {
        doc.body.style.fontSize = 12 * dpr + 'px';
    } else {
        doc.addEventListener('DOMContentLoaded', function (e) {
            doc.body.style.fontSize = 12 * dpr + 'px';
        }, false);
    }


    refreshRem();

    flexible.dpr = win.dpr = dpr;
    flexible.refreshRem = refreshRem;
    flexible.rem2px = function (d) {
        var val = parseFloat(d) * this.rem;
        if (typeof d === 'string' && d.match(/rem$/)) {
            val += 'px';
        }
        return val;
    }
    flexible.px2rem = function (d) {
        var val = parseFloat(d) / this.rem;
        if (typeof d === 'string' && d.match(/px$/)) {
            val += 'rem';
        }
        return val;
    }

})(window, window['lib'] || (window['lib'] = {}));


// header 更多按钮
var display = function (btn, el) {
    $(btn).click(function () {
        $(el).fadeIn(100);
    });
    $(document).on("touchend", ".tc-frame", function (e) {
        var _target = $(e.target);
        if (_target.closest(el).length == 0) {
            $(el).fadeOut(100);
        }
    });
};
display(".header-nav__more", ".header-more__list");

// header过滤器
$('.filter-wrap__title').on('click', function () {
    var $this = $(this),
        $inner = $this.next('.filter-wrap__content'),
        $arrow = $this.find(".filter-arrow");
    if ($arrow.hasClass('filter-arrow__down')) {
        $arrow.removeClass('filter-arrow__down');
        $arrow.addClass('filter-arrow__up');
        $inner.css("height", "auto");
    } else {
        $arrow.removeClass('filter-arrow__up');
        $arrow.addClass('filter-arrow__down');
        $inner.removeAttr('style');
    }
});

/**
 * 动态加载外部脚本
 * @param  {String}   url   [脚本地址]
 * @param  {Function} done  [脚本完毕回调函数]
 */
function loadScript(url, done) {
    var script = document.createElement('script');
    script.src = url;
    script.onload = onreadystatechange = function () {
        if (!this.readyState ||
            this.readyState === 'load' ||
            this.readyState === 'complete') {
            done && done();
            script.onload = onreadystatechange;
            script.parentNode.removeChild(script);
        }
    };
    document.getElementsByTagName("head")[0].appendChild(script);
}


// 滚动至顶部
$("body").append('<div class="go-to-top" style="display: none;"><i class="iconfont icon-top"></i><span>顶部</span></div>');
$( ".tc-frame" ).scroll(function() {
    if ($(this).scrollTop() >= 250) {
        $('.go-to-top').fadeIn(300);
    } else {
        $('.go-to-top').fadeOut(300);
    }
});
$(document).on('click', '.go-to-top', function () {
    $('.tc-frame').animate({scrollTop: '0'}, 300);
});


var topNav = function () {
    var container = $('.topnav-list')
    var scrollTo = $('.topnav-item__active');
    if( container.length > 0 && scrollTo.length > 0 ){
        var scrrollOffset = $(window).width()/2 - scrollTo.width()/2;
        container.animate({ scrollLeft: scrollTo.offset().left - container.offset().left - scrrollOffset +"px"}, 100);
        container.scroll(function() {
            if (container.scrollLeft() > 10) {
                $(".topnav-main").addClass("topnav-main__on");
            }else{
                $(".topnav-main").removeClass("topnav-main__on");
            }
        });

        $(document).on('click', '.topnav-btn', function () {
            if( $(this).hasClass("topnav-btn__open")){
                $(".topnav-panel").fadeOut(300);
                $(this).removeClass("topnav-btn__open");
            }else{
                $(".topnav-panel").fadeIn(300);
                $(this).addClass("topnav-btn__open");
            }
        });
    }else{
        return;
    }
};
topNav();







