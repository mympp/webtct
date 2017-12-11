var tmpl = {
    director: function (a) {
        return {
            title: "小编提示",
            cxt: "您获得了" + a + "分<br />去天成医疗网游戏中心参与游戏吧~",
            btnHtml: '<span class="btn2 btn-goapp">去玩</span><span class="btn2 btn-visitor">继续游戏</span>'
        }
    }, noplay: {title: "小编提示", cxt: "请在竖屏模式玩噢~"}, wrong: {title: "小编提示", cxt: "提交失败"}
};
var imgRoot = "./img";
var wechatShareTitle = "保福安六一儿童节邀你来摘蘑菇赢奖品";
var preImgArr = [imgRoot + "/sky_bg.jpg?cachevers=1", imgRoot + "/control_box.jpg?cachevers=1", imgRoot + "/line_box1.jpg?cachevers=1", imgRoot + "/line_box2.jpg?cachevers=1", imgRoot + "/line_box3.jpg?cachevers=1", imgRoot + "/line_box4.jpg?cachevers=1", imgRoot + "/wood.png?cachevers=1", imgRoot + "/hole.png?cachevers=1", imgRoot + "/s_mouse.png?cachevers=1", imgRoot + "/star_mouse.gif?cachevers=2", imgRoot + "/score_frame.gif?cachevers=1", imgRoot + "/show_frame.png?cachevers=1", imgRoot + "/time_frame.png?cachevers=1", imgRoot + "/icon_left.png?cachevers=1", imgRoot + "/icon_plus.png?cachevers=1", imgRoot + "/icon_right.png?cachevers=1", imgRoot + "/sound.png?cachevers=1", imgRoot + "/no_sound.png?cachevers=1", imgRoot + "/dialog_bg.png?cachevers=1", imgRoot + "/dialog_btn.png?cachevers=1", imgRoot + "/dialog_title.png?cachevers=1", imgRoot + "/dialog_close.png?cachevers=1"];
function loading() {
    var e = 0, d = 0, a = preImgArr.length, f = document.getElementById("sourInit");
    for (var c = 0; c < a; c++) {
        var b = new Image();
        b.src = preImgArr[c];
        (function (g) {
            b.onload = function () {
                d++;
                e = Math.floor(d * 100 / a);
                f.innerHTML = e + "%"
            }
        })(c)
    }
}
function heng() {
    var a = "onorientationchange" in window ? "orientationchange" : "resize";
    $(window).on(a, function (g) {
        var f = Math.abs(window.orientation);
        var d = $("body").find(".noplay-tips");
        var c = $(".cover");
        if (f == 90) {
            if (d.length == 0) {
                var b = '<div class="noplay-tips" >请竖屏模式玩噢~</div>';
                $("body").append(b)
            }
            d.show();
            c.show()
        } else {
            d.hide();
            c.hide()
        }
    })
}
$(function () {
    heng();
    var a = screen.height;
    if (a <= 480) {
        $("html").addClass("min-page")
    }
    loading()
});
window.onload = function () {
    var a = new Game({gap: 1000, fastGap: 600, rangeTime: 42, gameTime: 80, showTime: 1000, fastShowTime: 800});
    $(".init-show").hide();
    var b = $(".start-box");
    b.show();
    pageEvent(a);
    $(".game-start").on("click", function () {
        var d = $(this);
        var c = d.data("send") == "yes";
        if (!c) {
            d.data("send", "yes");
            b.hide();
            setTimeout(function () {
                a.init();
                d.data("send", "")
            }, "1000")
        }
    });
    ling()
};
function MathFloor(c, a) {
    var a = a > 0 ? a : 0;
    var b = Math.floor(Math.random() * c + a);
    return b
}
function ling() {
    var a = $(".bg-sound")[0];
    a.pause();
    scope.soundFlag = false;
    $(".sound")[0].className = "sound no-sound"
}
var scope = {score: 0, rScore: $(".score"), rHighScore: $(".highscore .inside"), soundFlag: true};
var tips = {notWifi: "", breaks: "当前网络不太好，休息一会吧~"};
function Game(a) {
    this.score = 0;
    this.highScore = 0;
    this.time = a.gameTime || 30;
    this.totalTime = this.time;
    this.rangeTime = a.rangeTime || 20;
    this.showTime = a.showTime || 1500;
    this.fastShowTime = a.fastShowTime || 1000;
    this.pNum = a.pNum || 5;
    this.pFNum = a.pFNum || 6;
    this.gap = a.gap || 2000;
    this.fastGap = a.fastGap || 1000;
    this.percent = "100%";
    this.bufferTime = this.rangeTime - 2
}
Game.prototype = {
    init: function () {
        scope.rScore.html(0);
        scope.score = 0;
        this.timeBox = $(".time");
        this.hit = $(".hit-sound")[0];
        this.mouse = $(".mouse");
        this.supportWebkit = this.timeBox[0].style.WebkitTransitionProperty !== undefined;
        this.clickTimes = 0;
        this.status = "slow";
        this.preFn();
        this.timeCount();
        this.setMaxScore();
        this.events()
    }, preFn: function () {
        this.start()
    }, randomMouse: function () {
        var e = [];
        var a = [];
        var g = this;
        var b = g.status == "fast";
        var c = b ? Math.floor(Math.random() * 2 + 6) : Math.floor(Math.random() * 3 + 3);
        for (var d = 0; e.length < c; d++) {
            f()
        }
        function f() {
            var h = Math.floor(Math.random() * 9);
            ($(".mouse").eq(h).hasClass("s-mouse")) && (a[h] = true);
            if (a[h]) {
                return
            }
            e.push(h);
            a[h] = true
        }

        return e
    }, mouseUp: function () {
        var d = this;
        var b = d.randomMouse();
        a();
        if (d.status == "slow") {
            setTimeout(function () {
                c(d.gap)
            }, d.showTime)
        } else {
            setTimeout(function () {
                c(d.fastGap)
            }, d.fastShowTime)
        }
        function a() {
            for (var g = 0; g < b.length; g++) {
                var e = b[g], f = $(".mouse").get(e);
                if (g < b.length - 1) {
                    f.className = "mouse s-mouse"
                } else {
                    f.className = "mouse s-mouse b-mouse"
                }
            }
        }

        function c(k) {
            for (var j = 0; j < b.length; j++) {
                var g = b[j];
                var h = $(".mouse").get(g), e = $(".mouse").eq(g), f = e.hasClass("star-mouse");
                if (f) {
                    if (e.hasClass("b-mouse")) {
                        h.className = "mouse e-mouse-star b-e-mouse-star"
                    } else {
                        h.className = "mouse e-mouse-star"
                    }
                } else {
                    if (e.hasClass("b-mouse")) {
                        h.className = "mouse e-mouse b-mouse"
                    } else {
                        h.className = "mouse e-mouse"
                    }
                }
                e.data("over", "");
                e.parents(".hole-box").removeClass("shake-ani")
            }
            if (d.status == "timeout") {
                return
            }
            setTimeout(function () {
                d.mouseUp()
            }, k)
        }
    }, start: function () {
        this.mouseUp()
    }, setScore: function (b) {
        var a = $(".score");
        a.html(b)
    }, events: function () {
        var a = this;
        $(".mouse").on("touchstart", function (g) {
            if (g.touches.length > 1) {
                return
            }
            var f = $(this), b = f.hasClass("s-mouse") && (f.data("over") != "y");
            if (b) {
                var d = f.parents(".hole-box").find(".icon-plus"), c = scope.rScore, h = parseInt(c.html());
                if (f.hasClass("b-mouse")) {
                    d.addClass("icon-minus");
                    h = h - 10
                } else {
                    h = h + 10
                }
                d.show();
                scope.soundFlag && a.hit.play();
                f.addClass("star-mouse").data("over", "y");
                f.parents(".hole-box").addClass("shake-ani");
                a.showPlusAni(d);
                a.setScore(h);
                scope.score = h
            }
        });
        $(".dialog .close").on("click", function () {
            hideDialog(".dialog")
        })
    }, setMaxScore: function () {
        var b = parseInt(localStorage.getItem("mouseMaxScore"));
        var a = b ? b : 0;
        $(".highscore .inside").html(a)
    }, maxScore: function () {
        var b = parseInt(localStorage.getItem("mouseMaxScore"));
        var a = parseInt(scope.rScore.html());
        if (b && b >= a) {
            return
        }
        localStorage.setItem("mouseMaxScore", a);
        $(".highscore .inside").html(a)
    }, showPlusAni: function (b) {
        var c = b[0], a = b.hasClass("icon-plus-ani");
        flag = false;
        if (!a) {
            clearTimeout(d);
            var d = setTimeout(function () {
                c.className += " icon-plus-ani"
            }, 100);
            if (this.supportWebkit) {
                c.addEventListener("webkitTransitionEnd", function () {
                    c.style.display = "none";
                    c.className = "icon-plus"
                }, false)
            } else {
                c.addEventListener("transitionend", function () {
                    c.style.display = "none";
                    c.className = "icon-plus"
                }, false)
            }
        }
    }, gameover: function () {
        var b = this;
        var a = scope.rHighScore.html();
        setTimeout(function () {
            b.maxScore();
            showResult();
            submitData()
        }, 1000)
    }, timeBar: function (d) {
        var c = this;
        var a = $(".progress-bar");
        c.percent = Math.floor(d * 100 / c.totalTime) + "%";
        a[0].style.width = c.percent;
        var b = "00:" + (d >= 10 ? d : "0" + d);
        c.timeBox.html(b)
    }, timeCount: function () {
        var d = this, a = d.rangeTime, c = d.time, b = d.bufferTime;
        clearInterval(d.timeInterval);
        d.timeInterval = setInterval(function () {
            c--;
            d.timeBar(c);
            if (c == a) {
                $(".attention").show()
            }
            if (c == b) {
                $(".attention").hide();
                d.status = "fast"
            }
            if (c == 0) {
                d.status = "timeout";
                clearInterval(d.timeInterval);
                setTimeout(function () {
                    d.gameover()
                }, 1200)
            }
        }, 1000)
    }
};
function personHtml() {
    var b = "";
    var a = $("#personRank").val();
    b = '<div class="game-rank-num">' + a + '</div><div class="game-rank-name">' + localStorage.getItem("mouseUserName") + '</div><div class="game-rank-tel">' + localStorage.getItem("mouseUserTel") + '</div><div class="game-rank-score">' + localStorage.getItem("mouseMaxScore") + "颗</div></div>";
    $(".game-rank-my").html(b)
}
var personRank = function () {
    var a = new gameDataSender(localStorage.getItem("mouseUserTel"), localStorage.getItem("mouseUserName"), localStorage.getItem("mouseMaxScore"));
    a.getPersonRank();
    personHtml();
    var b = $("#personRank").val();
    wechatShareTitle = "六一儿童节6翻天，宝宝摘了" + localStorage.getItem("mouseMaxScore") + "颗蘑菇，获得第" + b + "名，邀你一起摘蘑菇赢奖品！";
    wechatShare()
};
function showResult() {
    var b = $("[data-remodal-id=gameUserInfo]").remodal();
    if (!localStorage.getItem("mouseUserTel")) {
        b.open()
    } else {
        console.log("获取排行");
        personRank()
    }
    $(".page-game").hide();
    $(".page-result").show();
    $(".progress-bar")[0].style.width = "100%";
    $(".page-result-txt").html("恭喜您，成功摘得" + scope.score + "颗蘑菇，您的最高记录是" + parseInt(localStorage.getItem("mouseMaxScore")) + "颗蘑菇，加油哦！摘的蘑菇越多，奖品越大，告诉好朋友，一起分享奖品。");
    $(".page-result-btn").html('<a href="#wechatShareGuide" onclick="gameShareEvent();" class="game-btn game-share-btn"></a><br/><a href="javascript:;" onclick="gameAgain();" class="game-btn game-again-btn"></a><a onclick="getRank();" href="javascript:;" class="game-btn game-rank-btn"></a>');
    var a = '<ul class="slider-list"><li class="slider-item"><a onclick="gameAdLink1();" href="http://item.jd.com/12732584054.html" target="_blank"><img src="http://tc08.tecenet.com/game/mogu/img/ad-img-1.jpg" alt=""></a></li><li class="slider-item"><a onclick="gameAdLink2();" href="https://item.jd.com/12698445326.html" target="_blank"><img src="http://tc08.tecenet.com/game/mogu/img/ad-img-2.jpg" alt=""></a></li><li class="slider-item"><a onclick="gameAdLink3();" href="http://mp.weixin.qq.com/bizmall/mallshelf?id=&t=mall/list&biz=MzIyOTQ2MTg3OQ==&shelf_id=2&showwxpaytitle=1#wechat_redirect" target="_blank"><img src="http://tc08.tecenet.com/game/mogu/img/ad-img-3.jpg" alt=""></a></li></ul>';
    $(".page-result-ad").html(a);
    $(".page-result-ad").slider({autoScroll: true, infinite: true})
}
function gameShareEvent() {
    _hmt.push(["_trackEvent", "game", "click", "moguGameShare"])
}
function gameAdLink1() {
    _hmt.push(["_trackEvent", "game", "click", "moguGameToAd1"])
}
function gameAdLink2() {
    _hmt.push(["_trackEvent", "game", "click", "moguGameToAd2"])
}
function gameAdLink3() {
    _hmt.push(["_trackEvent", "game", "click", "moguGameToAd3"])
}
function gameAgain() {
    _hmt.push(["_trackEvent", "game", "click", "moguGameAgain"]);
    $(".page-result").hide();
    $(".page-game").show();
    $(".start-box").show()
}
function submitData() {
    var a = new gameDataSender(localStorage.getItem("mouseUserTel"), localStorage.getItem("mouseUserName"), scope.score);
    a.sendData()
}
function formSubmit() {
    var d = $("[data-remodal-id=gameUserInfo]").remodal();
    var c = $("[data-remodal-id=loading]").remodal();
    var b = $("#userName").val();
    var a = $("#userTel").val();
    if (b == "") {
        alert("请填写您的姓名");
        $("#userName").focus();
        return false
    }
    if (a == "") {
        alert("请填写您的电话");
        $("#userTel").focus();
        return false
    }
    if (!(/^1(3|4|5|7|8)\d{9}$/.test(a))) {
        alert("亲，离奖品仅差一个正确的手机号码了哦");
        $("#userTel").focus();
        return false
    }
    localStorage.setItem("mouseUserName", b);
    localStorage.setItem("mouseUserTel", a);
    submitData();
    personRank();
    d.close()
}
function getRank() {
    _hmt.push(["_trackEvent", "game", "click", "moguGameRank"]);
    var a = $("[data-remodal-id=gameRank]").remodal();
    a.open();
    var b = new gameDataSender(localStorage.getItem("mouseUserTel"), localStorage.getItem("mouseUserName"), scope.score);
    b.getRankList();
    personRank()
}
function pageEvent(a) {
    if (localStorage.getItem('mouseUserTel')) {
        $(".page-index .game-rank-btn").show();
    }
    $(".game-index-start").on("click", function () {
        $(".page-index").hide();
        $(".page-game").show()
    });
    var b = $(".dialog");
    $(".dialog .close").on("click", function () {
        hideDialog(".dialog");
        $(".start-box").show()
    });
    $(".dialog").on("touchend", ".btn-visitor", function () {
        hideDialog(".dialog");
        setTimeout(function () {
            a.init()
        }, 1000)
    });
    $("body").on("touchmove", function (c) {
        c.preventDefault()
    });
    $(".sound").on("click", function () {
        var c = $(".bg-sound");
        if (c[0].paused) {
            c[0].src = "http://tc08.tecenet.com/game/mogu/sound/Fever.mp3";
            c[0].play();
            this.className = "sound";
            scope.soundFlag = true
        } else {
            scope.soundFlag = false;
            c[0].pause();
            this.className = "sound no-sound"
        }
    })
}
function createDialog(c) {
    var e = c.title || "", b = c.cxt || "", a = c.btnHtml || "", d = c.imgHtml || "";
    $(".title").html(e);
    $(".dia-img").html(d);
    $(".cxt").html(b);
    $(".btn-box").html(a)
}
function showDialog(b, a) {
    var c = $(".start-box");
    c.hide();
    $(".progress-bar")[0].style.width = "100%";
    createDialog(a);
    $(b).show();
    $(".cover").show()
}
function hideDialog(a) {
    $(a).hide();
    $(".cover").hide()
}
function getCookie(a) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(a + "=");
        if (c_start != -1) {
            c_start = c_start + a.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length
            }
            return unescape(document.cookie.substring(c_start, c_end))
        }
    }
    return ""
}
var gameTicket = Math.random().toString(36).substr(2);
var localUrl = encodeURIComponent(window.location.href.split("#")[0]);
var game_file = new Array("mogu.game.r1.html", "mogu.game.r2.html", "mogu.game.r3.html", "mogu.game.r4.html", "mogu.game.r5.html", "mogu.game.r6.html");
var game_file_i = getRandom(0, 5);
var r_game = game_file[game_file_i];
var LastNum = 0;
function getRandom(a, c) {
    var b = Math.round(Math.random() * (c - a)) + a;
    if (b == LastNum) {
        getRandom(a, c)
    }
    LastNum = b;
    return b
}
function wechatShare() {
    $.ajax({
        url: "http://www.tecenet.com/api/weixin/jssdk.php?callback=cb&url=" + localUrl,
        dataType: "jsonp",
        error: function () {
            console.log("weixinAPI error")
        },
        success: function (a) {
            if (typeof a.timestamp != "undefined" && typeof a.nonceStr != "undefined" && typeof a.signature != "undefined") {
                wx.config({
                    debug: false,
                    appId: a.appId,
                    timestamp: a.timestamp,
                    nonceStr: a.nonceStr,
                    signature: a.signature,
                    jsApiList: ["onMenuShareTimeline", "onMenuShareAppMessage", "onMenuShareQQ", "onMenuShareWeibo"]
                });
                wx.ready(function () {
                    wx.onMenuShareTimeline({
                        title: wechatShareTitle,
                        link: "http://tc08.tecenet.com/game/mogu/" + r_game + "?gameTicket=" + gameTicket + "",
                        imgUrl: "http://tc08.tecenet.com/game/mogu/img/wechat-share-icon.jpg"
                    });
                    wx.onMenuShareAppMessage({
                        title: wechatShareTitle,
                        desc: $("[name=description]").attr("content"),
                        link: "http://tc08.tecenet.com/game/mogu/" + r_game + "?gameTicket=" + gameTicket + "",
                        imgUrl: "http://tc08.tecenet.com/game/mogu/img/wechat-share-icon.jpg",
                        type: "",
                        dataUrl: ""
                    });
                    wx.onMenuShareQQ({
                        title: wechatShareTitle,
                        desc: $("[name=description]").attr("content"),
                        link: "http://tc08.tecenet.com/game/mogu/" + r_game + "?gameTicket=" + gameTicket + "",
                        imgUrl: "http://tc08.tecenet.com/game/mogu/img/wechat-share-icon.jpg"
                    });
                    wx.onMenuShareWeibo({
                        title: wechatShareTitle,
                        desc: $("[name=description]").attr("content"),
                        link: "http://tc08.tecenet.com/game/mogu/" + r_game + "?gameTicket=" + gameTicket + "",
                        imgUrl: "http://tc08.tecenet.com/game/mogu/img/wechat-share-icon.jpg"
                    })
                })
            }
        }
    })
}
wechatShare();
function isTouchDevice() {
    try {
        document.createEvent("TouchEvent");
        return true
    } catch (a) {
        return false
    }
}
function touchScroll(c) {
    if (isTouchDevice()) {
        var a = document.getElementById(c);
        var b = 0;
        document.getElementById(c).addEventListener("touchstart", function (d) {
            b = this.scrollTop + d.touches[0].pageY;
            d.preventDefault()
        }, false);
        document.getElementById(c).addEventListener("touchmove", function (d) {
            this.scrollTop = b - d.touches[0].pageY;
            d.preventDefault()
        }, false)
    }
}
touchScroll("scroll1");
touchScroll("scroll2");
var gameDataSender = function (a, d, c) {
    var b = this;
    this.phone = a;
    this.username = d;
    this.score = c;
    this.t = Date.parse(new Date()) / 1000;
    this.saveUrl = "http://www.tecenet.com/api/games/web/index.php?r=moguu/api/save-score";
    this.rankUrl = "http://www.tecenet.com/api/games/web/index.php?r=moguu/api/rank";
    this.personRankUrl = "http://www.tecenet.com/api/games/web/index.php?r=moguu/api/person-rank";
    this.getSaveData = function () {
        var e = {
            phone: b.phone.toString(),
            score: b.score.toString(),
            username: b.username.toString(),
            t: b.t.toString()
        };
        return b.ksort(e)
    };
    this.getRankParam = function () {
        var e = {t: b.t.toString()};
        return b.ksort(e)
    };
    this.getPersonRankParam = function () {
        var e = {phone: b.phone.toString(), t: b.t.toString()};
        return b.ksort(e)
    };
    this.ksort = function (h) {
        var g = Object.keys(h).sort(), e = {};
        for (var f in g) {
            e[g[f]] = h[g[f]]
        }
        return e
    };
    this.getToken = function (j) {
        var f = this;
        var e = {alg: "HS256", typ: "JWT"};
        var k = j;
        var g = JSON.stringify(e);
        var h = JSON.stringify(k);
        return KJUR.jws.JWS.sign("HS256", g, h, "5928d87ee2b4e" + f.t)
    };
    this.sendData = function () {
        var f = this;
        var e = f.getSaveData();
        e.token = f.getToken(e);
        $.ajax({
            url: f.saveUrl, async: false, type: "post", dataType: "json", data: e, success: function (g) {
                if (g.error_code) {
                    console.log(g.error_message)
                } else {
                    console.log("保存成功")
                }
            }, error: function () {
                console.log("服务器错误")
            }
        })
    };
    this.getRankList = function () {
        var f = this;
        var e = f.getRankParam();
        e.token = f.getToken(e);
        $.ajax({
            url: f.rankUrl, async: false, type: "post", dataType: "json", data: e, success: function (g) {
                if (g.error_code) {
                    alert(g.error_message)
                } else {
                    var j = "";
                    for (i in g.data) {
                        var h = parseInt(i) + 1;
                        j += '<div class="game-rank-item"><div class="game-rank-num">' + h + '</div><div class="game-rank-name">' + g.data[i].username + '</div><div class="game-rank-tel">' + g.data[i].phone + '</div><div class="game-rank-score">' + g.data[i].max_score + "颗</div></div>"
                    }
                    $(".game-rank-list").html(j)
                }
            }, error: function () {
                console.log("服务器错误")
            }
        })
    };
    this.getPersonRank = function () {
        var f = this;
        var e = f.getPersonRankParam();
        e.token = f.getToken(e);
        $.ajax({
            url: f.personRankUrl, async: false, type: "post", dataType: "json", data: e, success: function (g) {
                if (g.error_code) {
                    console.log(g.error_message)
                } else {
                    $("#personRank").val(g.data.rank)
                }
            }, error: function () {
                console.log("服务器错误")
            }
        })
    }
};