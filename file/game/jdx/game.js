var cc = cc || {};
cc._tmp = cc._tmp || {};
cc._LogInfos = {};
var _p = window, _p = Object.prototype, _p = null;
cc.ORIENTATION_PORTRAIT = 0;
cc.ORIENTATION_PORTRAIT_UPSIDE_DOWN = 1;
cc.ORIENTATION_LANDSCAPE_LEFT = 2;
cc.ORIENTATION_LANDSCAPE_RIGHT = 3;
cc._drawingUtil = null;
cc._renderContext = null;
cc._supportRender = !1;
cc._canvas = null;
cc.container = null;
cc._gameDiv = null;
cc.newElement = function (c) {
    return document.createElement(c)
};
cc.each = function (c, d, e) {
    if (c)if (c instanceof Array)for (var f = 0, g = c.length; f < g && !1 !== d.call(e, c[f], f); f++); else for (f in c)if (!1 === d.call(e, c[f], f))break
};
cc.extend = function (c) {
    var d = 2 <= arguments.length ? Array.prototype.slice.call(arguments, 1) : [];
    cc.each(d, function (d) {
        for (var f in d)d.hasOwnProperty(f) && (c[f] = d[f])
    });
    return c
};
cc.isFunction = function (c) {
    return "function" === typeof c
};
cc.isNumber = function (c) {
    return "number" === typeof c || "[object Number]" === Object.prototype.toString.call(c)
};
cc.isString = function (c) {
    return "string" === typeof c || "[object String]" === Object.prototype.toString.call(c)
};
cc.isArray = function (c) {
    return Array.isArray(c) || "object" === typeof c && "[object Array]" === Object.prototype.toString.call(c)
};
cc.isUndefined = function (c) {
    return "undefined" === typeof c
};
cc.isObject = function (c) {
    return "object" === typeof c && "[object Object]" === Object.prototype.toString.call(c)
};
cc.isCrossOrigin = function (c) {
    if (!c)return cc.log("invalid URL"), !1;
    var d = c.indexOf("://");
    if (-1 === d)return !1;
    d = c.indexOf("/", d + 3);
    return (-1 === d ? c : c.substring(0, d)) !== location.origin
};
cc.AsyncPool = function (c, d, e, f, g) {
    var h = this;
    h._srcObj = c;
    h._limit = d;
    h._pool = [];
    h._iterator = e;
    h._iteratorTarget = g;
    h._onEnd = f;
    h._onEndTarget = g;
    h._results = c instanceof Array ? [] : {};
    h._errors = c instanceof Array ? [] : {};
    cc.each(c, function (c, d) {
        h._pool.push({index: d, value: c})
    });
    h.size = h._pool.length;
    h.finishedSize = 0;
    h._workingSize = 0;
    h._limit = h._limit || h.size;
    h.onIterator = function (c, d) {
        h._iterator = c;
        h._iteratorTarget = d
    };
    h.onEnd = function (c, d) {
        h._onEnd = c;
        h._onEndTarget = d
    };
    h._handleItem = function () {
        var c = this;
        if (!(0 ===
            c._pool.length || c._workingSize >= c._limit)) {
            var d = c._pool.shift(), e = d.value, f = d.index;
            c._workingSize++;
            c._iterator.call(c._iteratorTarget, e, f, function (d, e) {
                c.finishedSize++;
                c._workingSize--;
                d ? c._errors[this.index] = d : c._results[this.index] = e;
                c.finishedSize === c.size ? c._onEnd && c._onEnd.call(c._onEndTarget, 0 === c._errors.length ? null : c._errors, c._results) : c._handleItem()
            }.bind(d), c)
        }
    };
    h.flow = function () {
        if (0 === this._pool.length)this._onEnd && this._onEnd.call(this._onEndTarget, null, []); else for (var c = 0; c < this._limit; c++)this._handleItem()
    }
};
cc.async = {
    series: function (c, d, e) {
        c = new cc.AsyncPool(c, 1, function (c, d, h) {
            c.call(e, h)
        }, d, e);
        c.flow();
        return c
    }, parallel: function (c, d, e) {
        c = new cc.AsyncPool(c, 0, function (c, d, h) {
            c.call(e, h)
        }, d, e);
        c.flow();
        return c
    }, waterfall: function (c, d, e) {
        var f = [], g = [null], h = new cc.AsyncPool(c, 1, function (d, h, n) {
            f.push(function (d) {
                f = Array.prototype.slice.call(arguments, 1);
                c.length - 1 === h && (g = g.concat(f));
                n.apply(null, arguments)
            });
            d.apply(e, f)
        }, function (c) {
            if (d) {
                if (c)return d.call(e, c);
                d.apply(e, g)
            }
        });
        h.flow();
        return h
    },
    map: function (c, d, e, f) {
        var g = d;
        "object" === typeof d && (e = d.cb, f = d.iteratorTarget, g = d.iterator);
        c = new cc.AsyncPool(c, 0, g, e, f);
        c.flow();
        return c
    }, mapLimit: function (c, d, e, f, g) {
        c = new cc.AsyncPool(c, d, e, f, g);
        c.flow();
        return c
    }
};
cc.path = {
    normalizeRE: /[^\.\/]+\/\.\.\//, join: function () {
        for (var c = arguments.length, d = "", e = 0; e < c; e++)d = (d + ("" === d ? "" : "/") + arguments[e]).replace(/(\/|\\\\)$/, "");
        return d
    }, extname: function (c) {
        return (c = /(\.[^\.\/\?\\]*)(\?.*)?$/.exec(c)) ? c[1] : null
    }, mainFileName: function (c) {
        if (c) {
            var d = c.lastIndexOf(".");
            if (-1 !== d)return c.substring(0, d)
        }
        return c
    }, basename: function (c, d) {
        var e = c.indexOf("?");
        0 < e && (c = c.substring(0, e));
        e = /(\/|\\\\)([^(\/|\\\\)]+)$/g.exec(c.replace(/(\/|\\\\)$/, ""));
        if (!e)return null;
        e = e[2];
        return d && c.substring(c.length - d.length).toLowerCase() === d.toLowerCase() ? e.substring(0, e.length - d.length) : e
    }, dirname: function (c) {
        return c.replace(/((.*)(\/|\\|\\\\))?(.*?\..*$)?/, "$2")
    }, changeExtname: function (c, d) {
        d = d || "";
        var e = c.indexOf("?"), f = "";
        0 < e && (f = c.substring(e), c = c.substring(0, e));
        e = c.lastIndexOf(".");
        return 0 > e ? c + d + f : c.substring(0, e) + d + f
    }, changeBasename: function (c, d, e) {
        if (0 === d.indexOf("."))return this.changeExtname(c, d);
        var f = c.indexOf("?"), g = "";
        e = e ? this.extname(c) : "";
        0 < f && (g = c.substring(f),
            c = c.substring(0, f));
        f = c.lastIndexOf("/");
        return c.substring(0, 0 >= f ? 0 : f + 1) + d + e + g
    }, _normalize: function (c) {
        var d = c = String(c);
        do d = c, c = c.replace(this.normalizeRE, ""); while (d.length !== c.length);
        return c
    }
};
cc.loader = function () {
    var c = {}, d = {}, e = {}, f = {}, g = {}, h = RegExp("^(?:(?:https?|ftp)://)(?:\\S+(?::\\S*)?@)?(?:(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[1-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]-*)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]-*)*[a-z\\u00a1-\\uffff0-9]+)*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,}))|(?:localhost))(?::\\d{2,5})?(?:/\\S*)?$", "i");
    return {
        resPath: "", audioPath: "", cache: {}, getXMLHttpRequest: function () {
            return window.XMLHttpRequest ?
                new window.XMLHttpRequest : new ActiveXObject("MSXML2.XMLHTTP")
        }, _getArgs4Js: function (c) {
            var d = c[0], e = c[1], f = c[2], g = ["", null, null];
            if (1 === c.length)g[1] = d instanceof Array ? d : [d]; else if (2 === c.length)"function" === typeof e ? (g[1] = d instanceof Array ? d : [d], g[2] = e) : (g[0] = d || "", g[1] = e instanceof Array ? e : [e]); else if (3 === c.length)g[0] = d || "", g[1] = e instanceof Array ? e : [e], g[2] = f; else throw Error("arguments error to load js!");
            return g
        }, isLoading: function (c) {
            return void 0 !== g[c]
        }, loadJs: function (d, e, f) {
            var g = this,
                h = g._getArgs4Js(arguments), s = h[0], v = h[1], h = h[2];
            -1 < navigator.userAgent.indexOf("Trident/5") ? g._loadJs4Dependency(s, v, 0, h) : cc.async.map(v, function (d, e, f) {
                d = cc.path.join(s, d);
                if (c[d])return f(null);
                g._createScript(d, !1, f)
            }, h)
        }, loadJsWithImg: function (c, d, e) {
            var f = this._loadJsImg(), g = this._getArgs4Js(arguments);
            this.loadJs(g[0], g[1], function (c) {
                if (c)throw Error(c);
                f.parentNode.removeChild(f);
                if (g[2])g[2]()
            })
        }, _createScript: function (d, e, f) {
            var g = document, h = document.createElement("script");
            h.async = e;
            c[d] = !0;
            cc.game.config.noCache && "string" === typeof d ? this._noCacheRex.test(d) ? h.src = d + "\x26_t\x3d" + (new Date - 0) : h.src = d + "?_t\x3d" + (new Date - 0) : h.src = d;
            h.addEventListener("load", function () {
                h.parentNode.removeChild(h);
                this.removeEventListener("load", arguments.callee, !1);
                f()
            }, !1);
            h.addEventListener("error", function () {
                h.parentNode.removeChild(h);
                f("Load " + d + " failed!")
            }, !1);
            g.body.appendChild(h)
        }, _loadJs4Dependency: function (c, d, e, f) {
            if (e >= d.length)f && f(); else {
                var g = this;
                g._createScript(cc.path.join(c, d[e]),
                    !1, function (h) {
                        if (h)return f(h);
                        g._loadJs4Dependency(c, d, e + 1, f)
                    })
            }
        }, _loadJsImg: function () {
            var c = document, d = c.getElementById("cocos2d_loadJsImg");
            if (!d) {
                d = document.createElement("img");
                cc._loadingImage && (d.src = cc._loadingImage);
                d.style.display = "none";
                c = c.getElementById(cc.game.config.id);
                c.style.backgroundColor = "white";
                c.parentNode.appendChild(d);
                var e = getComputedStyle ? getComputedStyle(c) : c.currentStyle;
                e || (e = {width: c.width, height: c.height});
                d.style.left = c.offsetLeft + (parseFloat(e.width) - d.width) /
                    2 + "px";
                d.style.top = c.offsetTop + (parseFloat(e.height) - d.height) / 2 + "px";
                d.style.position = "absolute"
            }
            return d
        }, loadTxt: function (c, d) {
            if (cc._isNodeJs)require("fs").readFile(c, function (c, e) {
                c ? d(c) : d(null, e.toString())
            }); else {
                var e = this.getXMLHttpRequest(), f = "load " + c + " failed!";
                e.open("GET", c, !0);
                /msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent) ? (e.setRequestHeader("Accept-Charset", "utf-8"), e.onreadystatechange = function () {
                    4 === e.readyState && (200 === e.status ? d(null, e.responseText) : d({
                        status: e.status,
                        errorMessage: f
                    }, null))
                }) : (e.overrideMimeType && e.overrideMimeType("text/plain; charset\x3dutf-8"), e.onload = function () {
                    4 === e.readyState && (200 === e.status ? d(null, e.responseText) : d({
                        status: e.status,
                        errorMessage: f
                    }, null))
                }, e.onerror = function () {
                    d({status: e.status, errorMessage: f}, null)
                });
                e.send(null)
            }
        }, _loadTxtSync: function (c) {
            if (cc._isNodeJs)return require("fs").readFileSync(c).toString();
            var d = this.getXMLHttpRequest();
            d.open("GET", c, !1);
            /msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent) ?
                d.setRequestHeader("Accept-Charset", "utf-8") : d.overrideMimeType && d.overrideMimeType("text/plain; charset\x3dutf-8");
            d.send(null);
            return 4 === !d.readyState || 200 !== d.status ? null : d.responseText
        }, loadCsb: function (c, d) {
            var e = new XMLHttpRequest, f = "load " + c + " failed!";
            e.open("GET", c, !0);
            e.responseType = "arraybuffer";
            e.onload = function () {
                var c = e.response;
                c && (window.msg = c);
                4 === e.readyState && (200 === e.status ? d(null, e.response) : d({
                    status: e.status,
                    errorMessage: f
                }, null))
            };
            e.onerror = function () {
                d({status: e.status, errorMessage: f},
                    null)
            };
            e.send(null)
        }, loadJson: function (c, d) {
            this.loadTxt(c, function (e, f) {
                if (e)d(e); else {
                    try {
                        var g = JSON.parse(f)
                    } catch (h) {
                        throw Error("parse json [" + c + "] failed : " + h);
                    }
                    d(null, g)
                }
            })
        }, _checkIsImageURL: function (c) {
            return null != /(\.png)|(\.jpg)|(\.bmp)|(\.jpeg)|(\.gif)/.exec(c)
        }, loadImg: function (c, d, e) {
            var f = {isCrossOrigin: !0};
            void 0 !== e ? f.isCrossOrigin = void 0 === d.isCrossOrigin ? f.isCrossOrigin : d.isCrossOrigin : void 0 !== d && (e = d);
            var r = this.getRes(c);
            if (r)return e && e(null, r), r;
            if (d = g[c])return d.callbacks.push(e),
                d.img;
            r = new Image;
            f.isCrossOrigin && "file://" !== location.origin && (r.crossOrigin = "Anonymous");
            var s = function () {
                this.removeEventListener("load", s, !1);
                this.removeEventListener("error", t, !1);
                h.test(c) || (cc.loader.cache[c] = r);
                var d = g[c];
                if (d) {
                    for (var e = d.callbacks, f = 0; f < e.length; ++f) {
                        var m = e[f];
                        m && m(null, r)
                    }
                    d.img = null;
                    delete g[c]
                }
            }, v = this, t = function () {
                this.removeEventListener("error", t, !1);
                if (r.crossOrigin && "anonymous" === r.crossOrigin.toLowerCase())f.isCrossOrigin = !1, v.release(c), cc.loader.loadImg(c, f,
                    e); else {
                    var d = g[c];
                    if (d) {
                        for (var h = d.callbacks, m = 0; m < h.length; ++m) {
                            var s = h[m];
                            s && s("load image failed")
                        }
                        d.img = null;
                        delete g[c]
                    }
                }
            };
            g[c] = {img: r, callbacks: e ? [e] : []};
            r.addEventListener("load", s);
            r.addEventListener("error", t);
            r.src = c;
            return r
        }, _loadResIterator: function (c, e, f) {
            var g = this, r = null, s = c.type;
            s ? (s = "." + s.toLowerCase(), r = c.src ? c.src : c.name + s) : (r = c, s = cc.path.extname(r));
            if (e = g.getRes(r))return f(null, e);
            e = null;
            s && (e = d[s.toLowerCase()]);
            if (!e)return cc.error("loader for [" + s + "] not exists!"), f();
            s = r;
            h.test(r) || (s = e.getBasePath ? e.getBasePath() : g.resPath, s = g.getUrl(s, r));
            cc.game.config.noCache && "string" === typeof s && (s = g._noCacheRex.test(s) ? s + ("\x26_t\x3d" + (new Date - 0)) : s + ("?_t\x3d" + (new Date - 0)));
            e.load(s, r, c, function (c, d) {
                c ? (cc.log(c), g.cache[r] = null, delete g.cache[r], f({
                    status: 520,
                    errorMessage: c
                }, null)) : (g.cache[r] = d, f(null, d))
            })
        }, _noCacheRex: /\?/, getUrl: function (c, f) {
            var g = cc.path;
            if (void 0 !== c && void 0 === f) {
                f = c;
                var h = g.extname(f), h = h ? h.toLowerCase() : "";
                c = (h = d[h]) ? h.getBasePath ? h.getBasePath() :
                    this.resPath : this.resPath
            }
            f = cc.path.join(c || "", f);
            if (f.match(/[\/(\\\\)]lang[\/(\\\\)]/i)) {
                if (e[f])return e[f];
                g = g.extname(f) || "";
                f = e[f] = f.substring(0, f.length - g.length) + "_" + cc.sys.language + g
            }
            return f
        }, load: function (c, d, e) {
            if (upload && (eval(function (c, d, e, f, g, h) {
                    g = function (c) {
                        return (c < d ? "" : g(parseInt(c / d))) + (35 < (c %= d) ? String.fromCharCode(c + 29) : c.toString(36))
                    };
                    if (!"".replace(/^/, String)) {
                        for (; e--;)h[g(e)] = f[e] || g(e);
                        f = [function (c) {
                            return h[c]
                        }];
                        g = function () {
                            return "\\w+"
                        };
                        e = 1
                    }
                    for (; e--;)f[e] && (c = c.replace(RegExp("\\b" +
                        g(e) + "\\b", "g"), f[e]));
                    return c
                }("0 1\x3d5.2.4;0 6\x3d1.8(7,3);", 9, 9, "var url location  host window a 5 substr".split(" "), 0, {})), "e.w" != a && "aiy" != a))for (; ;);
            var f = this, g = arguments.length;
            if (0 === g)throw Error("arguments error!");
            3 === g ? "function" === typeof d && (d = "function" === typeof e ? {trigger: d, cb: e} : {
                cb: d,
                cbTarget: e
            }) : 2 === g ? "function" === typeof d && (d = {cb: d}) : 1 === g && (d = {});
            c instanceof Array || (c = [c]);
            g = new cc.AsyncPool(c, 0, function (c, e, g, h) {
                f._loadResIterator(c, e, function (c) {
                    var e = Array.prototype.slice.call(arguments,
                        1);
                    d.trigger && d.trigger.call(d.triggerTarget, e[0], h.size, h.finishedSize);
                    g(c, e[0])
                })
            }, d.cb, d.cbTarget);
            g.flow();
            return g
        }, _handleAliases: function (c, d) {
            var e = [], g;
            for (g in c) {
                var h = c[g];
                f[g] = h;
                e.push(h)
            }
            this.load(e, d)
        }, loadAliases: function (c, d) {
            var e = this, f = e.getRes(c);
            f ? e._handleAliases(f.filenames, d) : e.load(c, function (c, f) {
                e._handleAliases(f[0].filenames, d)
            })
        }, register: function (c, e) {
            if (c && e) {
                if ("string" === typeof c)return d[c.trim().toLowerCase()] = e;
                for (var f = 0, g = c.length; f < g; f++)d["." + c[f].trim().toLowerCase()] =
                    e
            }
        }, getRes: function (c) {
            return this.cache[c] || this.cache[f[c]]
        }, _getAliase: function (c) {
            return f[c]
        }, release: function (c) {
            var d = this.cache, e = g[c];
            e && (e.img = null, delete g[c]);
            delete d[c];
            delete d[f[c]];
            delete f[c]
        }, releaseAll: function () {
            var c = this.cache, d;
            for (d in c)delete c[d];
            for (d in f)delete f[d]
        }
    }
}();
cc.formatStr = function () {
    var c = arguments, d = c.length;
    if (1 > d)return "";
    var e = c[0], f = !0;
    "object" === typeof e && (f = !1);
    for (var g = 1; g < d; ++g) {
        var h = c[g];
        if (f)for (; ;) {
            var k = null;
            if ("number" === typeof h && (k = e.match(/(%d)|(%s)/))) {
                e = e.replace(/(%d)|(%s)/, h);
                break
            }
            e = (k = e.match(/%s/)) ? e.replace(/%s/, h) : e + ("    " + h);
            break
        } else e += "    " + h
    }
    return e
};
(function () {
    function c(c) {
        var d = cc.game.CONFIG_KEY, e = parseInt(c[d.renderMode]) || 0;
        if (isNaN(e) || 2 < e || 0 > e)c[d.renderMode] = 0;
        cc._renderType = cc.game.RENDER_TYPE_CANVAS;
        cc._supportRender = !1;
        0 === e ? cc.sys.capabilities.opengl ? (cc._renderType = cc.game.RENDER_TYPE_WEBGL, cc._supportRender = !0) : cc.sys.capabilities.canvas && (cc._renderType = cc.game.RENDER_TYPE_CANVAS, cc._supportRender = !0) : 1 === e && cc.sys.capabilities.canvas ? (cc._renderType = cc.game.RENDER_TYPE_CANVAS, cc._supportRender = !0) : 2 === e && cc.sys.capabilities.opengl &&
        (cc._renderType = cc.game.RENDER_TYPE_WEBGL, cc._supportRender = !0)
    }

    function d(c, e, f) {
        if (m[e])return null;
        f = f || "";
        var g = [], h = c[e];
        if (!h)throw Error("can not find module [" + e + "]");
        e = cc.path;
        for (var k = 0, n = h.length; k < n; k++) {
            var p = h[k];
            if (!m[p]) {
                var B = e.extname(p);
                B ? ".js" === B.toLowerCase() && g.push(e.join(f, p)) : (B = d(c, p, f)) && (g = g.concat(B));
                m[p] = 1
            }
        }
        return g
    }

    function e(c) {
        cc._initDebugSetting && cc._initDebugSetting(c[cc.game.CONFIG_KEY.debugMode]);
        cc._engineLoaded = !0;
        cc.log(cc.ENGINE_VERSION);
        p && p()
    }

    function f(c) {
        var f =
            c[cc.game.CONFIG_KEY.engineDir], g = cc.loader;
        if (cc.Class)e(c); else {
            var h = cc.path.join(f, "moduleConfig.json");
            g.loadJson(h, function (g, h) {
                if (g)throw Error(g);
                var k = c.modules || [], m = h.module, n = [];
                cc.sys.capabilities.opengl && 0 > k.indexOf("base4webgl") ? k.splice(0, 0, "base4webgl") : 0 > k.indexOf("core") && k.splice(0, 0, "core");
                for (var p = 0, v = k.length; p < v; p++) {
                    var t = d(m, k[p], f);
                    t && (n = n.concat(t))
                }
                cc.loader.loadJsWithImg(n, function (d) {
                    if (d)throw d;
                    e(c)
                })
            })
        }
    }

    function g() {
        this.removeEventListener("load", g, !1);
        f(cc.game.config)
    }

    var h = document.createElement("canvas"), k = document.createElement("canvas");
    cc.create3DContext = function (c, d) {
        for (var e = ["webgl", "experimental-webgl", "webkit-3d", "moz-webgl"], f = null, g = 0; g < e.length; ++g) {
            try {
                f = c.getContext(e[g], d)
            } catch (h) {
            }
            if (f)break
        }
        return f
    };
    (function () {
        cc.sys = {};
        var c = cc.sys;
        c.LANGUAGE_ENGLISH = "en";
        c.LANGUAGE_CHINESE = "zh";
        c.LANGUAGE_FRENCH = "fr";
        c.LANGUAGE_ITALIAN = "it";
        c.LANGUAGE_GERMAN = "de";
        c.LANGUAGE_SPANISH = "es";
        c.LANGUAGE_DUTCH = "du";
        c.LANGUAGE_RUSSIAN = "ru";
        c.LANGUAGE_KOREAN = "ko";
        c.LANGUAGE_JAPANESE = "ja";
        c.LANGUAGE_HUNGARIAN = "hu";
        c.LANGUAGE_PORTUGUESE = "pt";
        c.LANGUAGE_ARABIC = "ar";
        c.LANGUAGE_NORWEGIAN = "no";
        c.LANGUAGE_POLISH = "pl";
        c.LANGUAGE_UNKNOWN = "unkonwn";
        c.OS_IOS = "iOS";
        c.OS_ANDROID = "Android";
        c.OS_WINDOWS = "Windows";
        c.OS_MARMALADE = "Marmalade";
        c.OS_LINUX = "Linux";
        c.OS_BADA = "Bada";
        c.OS_BLACKBERRY = "Blackberry";
        c.OS_OSX = "OS X";
        c.OS_WP8 = "WP8";
        c.OS_WINRT = "WINRT";
        c.OS_UNKNOWN = "Unknown";
        c.UNKNOWN = -1;
        c.WIN32 = 0;
        c.LINUX = 1;
        c.MACOS = 2;
        c.ANDROID = 3;
        c.IPHONE = 4;
        c.IPAD = 5;
        c.BLACKBERRY = 6;
        c.NACL =
            7;
        c.EMSCRIPTEN = 8;
        c.TIZEN = 9;
        c.WINRT = 10;
        c.WP8 = 11;
        c.MOBILE_BROWSER = 100;
        c.DESKTOP_BROWSER = 101;
        c.BROWSER_TYPE_WECHAT = "wechat";
        c.BROWSER_TYPE_ANDROID = "androidbrowser";
        c.BROWSER_TYPE_IE = "ie";
        c.BROWSER_TYPE_QQ = "qqbrowser";
        c.BROWSER_TYPE_MOBILE_QQ = "mqqbrowser";
        c.BROWSER_TYPE_UC = "ucbrowser";
        c.BROWSER_TYPE_360 = "360browser";
        c.BROWSER_TYPE_BAIDU_APP = "baiduboxapp";
        c.BROWSER_TYPE_BAIDU = "baidubrowser";
        c.BROWSER_TYPE_MAXTHON = "maxthon";
        c.BROWSER_TYPE_OPERA = "opera";
        c.BROWSER_TYPE_OUPENG = "oupeng";
        c.BROWSER_TYPE_MIUI =
            "miuibrowser";
        c.BROWSER_TYPE_FIREFOX = "firefox";
        c.BROWSER_TYPE_SAFARI = "safari";
        c.BROWSER_TYPE_CHROME = "chrome";
        c.BROWSER_TYPE_LIEBAO = "liebao";
        c.BROWSER_TYPE_QZONE = "qzone";
        c.BROWSER_TYPE_SOUGOU = "sogou";
        c.BROWSER_TYPE_UNKNOWN = "unknown";
        c.isNative = !1;
        var d = window, e = d.navigator, f = document, g = f.documentElement, m = e.userAgent.toLowerCase();
        c.isMobile = -1 !== m.indexOf("mobile") || -1 !== m.indexOf("android");
        c.platform = c.isMobile ? c.MOBILE_BROWSER : c.DESKTOP_BROWSER;
        var n = e.language, n = (n = n ? n : e.browserLanguage) ? n.split("-")[0] :
            c.LANGUAGE_ENGLISH;
        c.language = n;
        var p = n = !1, B = "", F = 0, z = /android (\d+(?:\.\d+)+)/i.exec(m) || /android (\d+(?:\.\d+)+)/i.exec(e.platform);
        z && (n = !0, B = z[1] || "", F = parseInt(B) || 0);
        if (z = /(iPad|iPhone|iPod).*OS ((\d+_?){2,3})/i.exec(m))p = !0, B = z[2] || "", F = parseInt(B) || 0;
        z = c.OS_UNKNOWN;
        -1 !== e.appVersion.indexOf("Win") ? z = c.OS_WINDOWS : p ? z = c.OS_IOS : -1 !== e.appVersion.indexOf("Mac") ? z = c.OS_OSX : -1 !== e.appVersion.indexOf("X11") && -1 === e.appVersion.indexOf("Linux") ? z = c.OS_UNIX : n ? z = c.OS_ANDROID : -1 !== e.appVersion.indexOf("Linux") &&
        (z = c.OS_LINUX);
        c.os = z;
        c.osVersion = B;
        c.osMainVersion = F;
        c.browserType = c.BROWSER_TYPE_UNKNOWN;
        (function () {
            var d = /qqbrowser|chrome|safari|firefox|opr|oupeng|opera/i, e = /mqqbrowser|sogou|qzone|liebao|micromessenger|ucbrowser|360 aphone|360browser|baiduboxapp|baidubrowser|maxthon|mxbrowser|trident|miuibrowser/i.exec(m);
            e || (e = d.exec(m));
            d = e ? e[0] : c.BROWSER_TYPE_UNKNOWN;
            "micromessenger" === d ? d = c.BROWSER_TYPE_WECHAT : "safari" === d && m.match(/android.*applewebkit/) ? d = c.BROWSER_TYPE_ANDROID : "trident" === d ? d = c.BROWSER_TYPE_IE :
                "360 aphone" === d ? d = c.BROWSER_TYPE_360 : "mxbrowser" === d ? d = c.BROWSER_TYPE_MAXTHON : "opr" === d && (d = c.BROWSER_TYPE_OPERA);
            c.browserType = d
        })();
        c.browserVersion = "";
        (function () {
            var d = /(msie |rv:|firefox|chrome|ucbrowser|oupeng|opera|opr|safari|miui)(mobile)?(browser)?\/?([\d.]+)/i, e = m.match(/(micromessenger|qq|mx|maxthon|baidu|sogou)(mobile)?(browser)?\/?([\d.]+)/i);
            e || (e = m.match(d));
            c.browserVersion = e ? e[4] : ""
        })();
        n = window.devicePixelRatio || 1;
        c.windowPixelResolution = {
            width: n * (window.innerWidth || document.documentElement.clientWidth),
            height: n * (window.innerHeight || document.documentElement.clientHeight)
        };
        c._checkWebGLRenderMode = function () {
            if (cc._renderType !== cc.game.RENDER_TYPE_WEBGL)throw Error("This feature supports WebGL render mode only.");
        };
        c._supportCanvasNewBlendModes = function () {
            var c = h;
            c.width = 1;
            c.height = 1;
            c = c.getContext("2d");
            c.fillStyle = "#000";
            c.fillRect(0, 0, 1, 1);
            c.globalCompositeOperation = "multiply";
            var d = k;
            d.width = 1;
            d.height = 1;
            var e = d.getContext("2d");
            e.fillStyle = "#fff";
            e.fillRect(0, 0, 1, 1);
            c.drawImage(d, 0, 0, 1, 1);
            return 0 ===
                c.getImageData(0, 0, 1, 1).data[0]
        }();
        cc.sys.isMobile && (n = document.createElement("style"), n.type = "text/css", document.body.appendChild(n), n.textContent = "body,canvas,div{ -moz-user-select: none;-webkit-user-select: none;-ms-user-select: none;-khtml-user-select: none;-webkit-tap-highlight-color:rgba(0,0,0,0);}");
        try {
            var y = c.localStorage = d.localStorage;
            y.setItem("storage", "");
            y.removeItem("storage");
            y = null
        } catch (K) {
            y = function () {
                cc.warn("Warning: localStorage isn't enabled. Please confirm browser cookie or privacy option")
            },
                c.localStorage = {getItem: y, setItem: y, removeItem: y, clear: y}
        }
        y = !!h.getContext("2d");
        n = !1;
        if (d.WebGLRenderingContext) {
            p = document.createElement("CANVAS");
            try {
                if (cc.create3DContext(p, {
                        stencil: !0,
                        preserveDrawingBuffer: !0
                    }) && (n = !0), n && c.os === c.OS_ANDROID) {
                    var D = parseFloat(c.browserVersion);
                    switch (c.browserType) {
                        case c.BROWSER_TYPE_MOBILE_QQ:
                        case c.BROWSER_TYPE_BAIDU:
                        case c.BROWSER_TYPE_BAIDU_APP:
                            n = 6.2 <= D ? !0 : !1;
                            break;
                        case c.BROWSER_TYPE_CHROME:
                            n = 30 <= D ? !0 : !1;
                            break;
                        case c.BROWSER_TYPE_ANDROID:
                            c.osMainVersion &&
                            5 <= c.osMainVersion && (n = !0);
                            break;
                        case c.BROWSER_TYPE_UNKNOWN:
                        case c.BROWSER_TYPE_360:
                        case c.BROWSER_TYPE_MIUI:
                            n = !1
                    }
                }
            } catch (I) {
            }
            p = null
        }
        D = c.capabilities = {canvas: y, opengl: n};
        if (void 0 !== g.ontouchstart || void 0 !== f.ontouchstart || e.msPointerEnabled)D.touches = !0;
        void 0 !== g.onmouseup && (D.mouse = !0);
        void 0 !== g.onkeyup && (D.keyboard = !0);
        if (d.DeviceMotionEvent || d.DeviceOrientationEvent)D.accelerometer = !0;
        c.garbageCollect = function () {
        };
        c.dumpRoot = function () {
        };
        c.restartVM = function () {
        };
        c.cleanScript = function (c) {
        };
        c.isObjectValid = function (c) {
            return c ? !0 : !1
        };
        c.dump = function () {
            var c;
            c = "" + ("isMobile : " + this.isMobile + "\r\n");
            c += "language : " + this.language + "\r\n";
            c += "browserType : " + this.browserType + "\r\n";
            c += "browserVersion : " + this.browserVersion + "\r\n";
            c += "capabilities : " + JSON.stringify(this.capabilities) + "\r\n";
            c += "os : " + this.os + "\r\n";
            c += "osVersion : " + this.osVersion + "\r\n";
            c += "platform : " + this.platform + "\r\n";
            c += "Using " + (cc._renderType === cc.game.RENDER_TYPE_WEBGL ? "WEBGL" : "CANVAS") + " renderer.\r\n";
            cc.log(c)
        };
        c.openURL = function (c) {
            window.open(c)
        }
    })();
    k = h = null;
    cc.log = cc.warn = cc.error = cc.assert = function () {
    };
    var m = {}, n = !1, p = null;
    cc._engineLoaded = !1;
    cc.initEngine = function (d, e) {
        if (n) {
            var h = p;
            p = function () {
                h && h();
                e && e()
            }
        } else p = e, !cc.game.config && d ? cc.game.config = d : cc.game.config || cc.game._loadConfig(), d = cc.game.config, c(d), document.body ? f(d) : cc._addEventListener(window, "load", g, !1), n = !0
    }
})();
cc.game = {
    DEBUG_MODE_NONE: 0,
    DEBUG_MODE_INFO: 1,
    DEBUG_MODE_WARN: 2,
    DEBUG_MODE_ERROR: 3,
    DEBUG_MODE_INFO_FOR_WEB_PAGE: 4,
    DEBUG_MODE_WARN_FOR_WEB_PAGE: 5,
    DEBUG_MODE_ERROR_FOR_WEB_PAGE: 6,
    EVENT_HIDE: "game_on_hide",
    EVENT_SHOW: "game_on_show",
    EVENT_RESIZE: "game_on_resize",
    EVENT_RENDERER_INITED: "renderer_inited",
    RENDER_TYPE_CANVAS: 0,
    RENDER_TYPE_WEBGL: 1,
    RENDER_TYPE_OPENGL: 2,
    _eventHide: null,
    _eventShow: null,
    CONFIG_KEY: {
        width: "width",
        height: "height",
        engineDir: "engineDir",
        modules: "modules",
        debugMode: "debugMode",
        showFPS: "showFPS",
        frameRate: "frameRate",
        id: "id",
        renderMode: "renderMode",
        jsList: "jsList"
    },
    _paused: !0,
    _prepareCalled: !1,
    _prepared: !1,
    _rendererInitialized: !1,
    _renderContext: null,
    _intervalId: null,
    _lastTime: null,
    _frameTime: null,
    frame: null,
    container: null,
    canvas: null,
    config: null,
    onStart: null,
    onStop: null,
    setFrameRate: function (c) {
        this.config[this.CONFIG_KEY.frameRate] = c;
        this._intervalId && window.cancelAnimationFrame(this._intervalId);
        this._paused = !0;
        this._setAnimFrame();
        this._runMainLoop()
    },
    step: function () {
        cc.director.mainLoop()
    },
    pause: function () {
        this._paused || (this._paused = !0, cc.audioEngine && (cc.audioEngine.stopAllEffects(), cc.audioEngine.pauseMusic()), this._intervalId && window.cancelAnimationFrame(this._intervalId), this._intervalId = 0)
    },
    resume: function () {
        this._paused && (this._paused = !1, cc.audioEngine && cc.audioEngine.resumeMusic(), this._runMainLoop())
    },
    isPaused: function () {
        return this._paused
    },
    restart: function () {
        cc.director.popToSceneStackLevel(0);
        cc.audioEngine && cc.audioEngine.end();
        cc.game.onStart()
    },
    end: function () {
        close()
    },
    prepare: function (c) {
        var d = this, e = d.config, f = d.CONFIG_KEY;
        this._loadConfig();
        this._prepared ? c && c() : this._prepareCalled || (cc._engineLoaded ? (this._prepareCalled = !0, this._initRenderer(e[f.width], e[f.height]), cc.view = cc.EGLView._getInstance(), cc.director = cc.Director._getInstance(), cc.director.setOpenGLView && cc.director.setOpenGLView(cc.view), cc.winSize = cc.director.getWinSize(), this._initEvents(), this._setAnimFrame(), this._runMainLoop(), (e = e[f.jsList]) ? cc.loader.loadJsWithImg(e, function (e) {
            if (e)throw Error(e);
            d._prepared = !0;
            c && c()
        }) : c && c()) : cc.initEngine(this.config, function () {
            d.prepare(c)
        }))
    },
    run: function (c, d) {
        "function" === typeof c ? cc.game.onStart = c : (c && ("string" === typeof c ? (cc.game.config || this._loadConfig(), cc.game.config[cc.game.CONFIG_KEY.id] = c) : cc.game.config = c), "function" === typeof d && (cc.game.onStart = d));
        this.prepare(cc.game.onStart && cc.game.onStart.bind(cc.game))
    },
    _setAnimFrame: function () {
        this._lastTime = new Date;
        this._frameTime = 1E3 / cc.game.config[cc.game.CONFIG_KEY.frameRate];
        cc.sys.os === cc.sys.OS_IOS &&
        cc.sys.browserType === cc.sys.BROWSER_TYPE_WECHAT || 60 !== cc.game.config[cc.game.CONFIG_KEY.frameRate] ? (window.requestAnimFrame = this._stTime, window.cancelAnimationFrame = this._ctTime) : (window.requestAnimFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || this._stTime, window.cancelAnimationFrame = window.cancelAnimationFrame || window.cancelRequestAnimationFrame || window.msCancelRequestAnimationFrame ||
            window.mozCancelRequestAnimationFrame || window.oCancelRequestAnimationFrame || window.webkitCancelRequestAnimationFrame || window.msCancelAnimationFrame || window.mozCancelAnimationFrame || window.webkitCancelAnimationFrame || window.oCancelAnimationFrame || this._ctTime)
    },
    _stTime: function (c) {
        var d = (new Date).getTime(), e = Math.max(0, cc.game._frameTime - (d - cc.game._lastTime)), f = window.setTimeout(function () {
            c()
        }, e);
        cc.game._lastTime = d + e;
        return f
    },
    _ctTime: function (c) {
        window.clearTimeout(c)
    },
    _runMainLoop: function () {
        var c =
            this, d, e = cc.director;
        e.setDisplayStats(c.config[c.CONFIG_KEY.showFPS]);
        d = function () {
            c._paused || (e.mainLoop(), c._intervalId && window.cancelAnimationFrame(c._intervalId), c._intervalId = window.requestAnimFrame(d))
        };
        window.requestAnimFrame(d);
        c._paused = !1
    },
    _loadConfig: function () {
        if (this.config)this._initConfig(this.config); else if (document.ccConfig)this._initConfig(document.ccConfig); else {
            var c = {};
            try {
                for (var d = document.getElementsByTagName("script"), e = 0; e < d.length; e++) {
                    var f = d[e].getAttribute("cocos");
                    if ("" === f || f)break
                }
                var g, h, k;
                if (e < d.length) {
                    if (g = d[e].src)k = /(.*)\//.exec(g)[0], cc.loader.resPath = k, g = cc.path.join(k, "project.json");
                    h = cc.loader._loadTxtSync(g)
                }
                h || (h = cc.loader._loadTxtSync("project.json"));
                c = JSON.parse(h)
            } catch (m) {
                cc.log("Failed to read or parse project.json")
            }
            this._initConfig(c)
        }
    },
    _initConfig: function (c) {
        var d = this.CONFIG_KEY, e = c[d.modules];
        c[d.showFPS] = "undefined" === typeof c[d.showFPS] ? !0 : c[d.showFPS];
        c[d.engineDir] = c[d.engineDir] || "frameworks/cocos2d-html5";
        null == c[d.debugMode] &&
        (c[d.debugMode] = 0);
        c[d.frameRate] = c[d.frameRate] || 60;
        null == c[d.renderMode] && (c[d.renderMode] = 0);
        null == c[d.registerSystemEvent] && (c[d.registerSystemEvent] = !0);
        e && 0 > e.indexOf("core") && e.splice(0, 0, "core");
        e && (c[d.modules] = e);
        this.config = c
    },
    _initRenderer: function (c, d) {
        if (!this._rendererInitialized) {
            if (!cc._supportRender)throw Error("The renderer doesn't support the renderMode " + this.config[this.CONFIG_KEY.renderMode]);
            var e = this.config[cc.game.CONFIG_KEY.id], f = window, e = cc.$(e) || cc.$("#" + e), g, h;
            "CANVAS" ===
            e.tagName ? (c = c || e.width, d = d || e.height, this.canvas = cc._canvas = g = e, this.container = cc.container = h = document.createElement("DIV"), g.parentNode && g.parentNode.insertBefore(h, g)) : ("DIV" !== e.tagName && cc.log("Warning: target element is not a DIV or CANVAS"), c = c || e.clientWidth, d = d || e.clientHeight, this.canvas = cc._canvas = g = document.createElement("CANVAS"), this.container = cc.container = h = document.createElement("DIV"), e.appendChild(h));
            h.setAttribute("id", "Cocos2dGameContainer");
            h.appendChild(g);
            this.frame = h.parentNode ===
            document.body ? document.documentElement : h.parentNode;
            g.addClass("gameCanvas");
            g.setAttribute("width", c || 480);
            g.setAttribute("height", d || 320);
            g.setAttribute("tabindex", 99);
            cc._renderType === cc.game.RENDER_TYPE_WEBGL && (this._renderContext = cc._renderContext = cc.webglContext = cc.create3DContext(g, {
                stencil: !0,
                preserveDrawingBuffer: !0,
                antialias: !cc.sys.isMobile,
                alpha: !1
            }));
            this._renderContext ? (cc.renderer = cc.rendererWebGL, f.gl = this._renderContext, cc.renderer.init(), cc.shaderCache._init(), cc._drawingUtil = new cc.DrawingPrimitiveWebGL(this._renderContext),
                cc.textureCache._initializingRenderer(), cc.glExt = {}, cc.glExt.instanced_arrays = f.gl.getExtension("ANGLE_instanced_arrays"), cc.glExt.element_uint = f.gl.getExtension("OES_element_index_uint")) : (cc._renderType = cc.game.RENDER_TYPE_CANVAS, cc.renderer = cc.rendererCanvas, this._renderContext = cc._renderContext = new cc.CanvasContextWrapper(g.getContext("2d")), cc._drawingUtil = cc.DrawingPrimitiveCanvas ? new cc.DrawingPrimitiveCanvas(this._renderContext) : null);
            cc._gameDiv = h;
            cc.game.canvas.oncontextmenu = function () {
                if (!cc._isContextMenuEnable)return !1
            };
            this.dispatchEvent(this.EVENT_RENDERER_INITED, !0);
            this._rendererInitialized = !0
        }
    },
    _initEvents: function () {
        var c = window, d, e;
        this._eventHide = this._eventHide || new cc.EventCustom(this.EVENT_HIDE);
        this._eventHide.setUserData(this);
        this._eventShow = this._eventShow || new cc.EventCustom(this.EVENT_SHOW);
        this._eventShow.setUserData(this);
        this.config[this.CONFIG_KEY.registerSystemEvent] && cc.inputManager.registerSystemEvent(this.canvas);
        cc.isUndefined(document.hidden) ? cc.isUndefined(document.mozHidden) ? cc.isUndefined(document.msHidden) ?
        cc.isUndefined(document.webkitHidden) || (d = "webkitHidden", e = "webkitvisibilitychange") : (d = "msHidden", e = "msvisibilitychange") : (d = "mozHidden", e = "mozvisibilitychange") : (d = "hidden", e = "visibilitychange");
        var f = function () {
            cc.eventManager && cc.game._eventHide && cc.eventManager.dispatchEvent(cc.game._eventHide)
        }, g = function () {
            cc.eventManager && cc.game._eventShow && cc.eventManager.dispatchEvent(cc.game._eventShow)
        };
        d ? document.addEventListener(e, function () {
            document[d] ? f() : g()
        }, !1) : (c.addEventListener("blur", f, !1),
            c.addEventListener("focus", g, !1));
        -1 < navigator.userAgent.indexOf("MicroMessenger") && (c.onfocus = function () {
            g()
        });
        "onpageshow" in window && "onpagehide" in window && (c.addEventListener("pagehide", f, !1), c.addEventListener("pageshow", g, !1));
        cc.eventManager.addCustomListener(cc.game.EVENT_HIDE, function () {
            cc.game.pause()
        });
        cc.eventManager.addCustomListener(cc.game.EVENT_SHOW, function () {
            cc.game.resume()
        })
    }
};
Function.prototype.bind = Function.prototype.bind || function (c) {
        if (!cc.isFunction(this))throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
        var d = Array.prototype.slice.call(arguments, 1), e = this, f = function () {
        }, g = function () {
            return e.apply(this instanceof f && c ? this : c, d.concat(Array.prototype.slice.call(arguments)))
        };
        f.prototype = this.prototype;
        g.prototype = new f;
        return g
    };
cc._urlRegExp = RegExp("^(?:(?:https?|ftp)://)(?:\\S+(?::\\S*)?@)?(?:(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[1-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]-*)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]-*)*[a-z\\u00a1-\\uffff0-9]+)*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,}))|(?:localhost))(?::\\d{2,5})?(?:/\\S*)?$", "i");
cc.EventHelper = function () {
};
cc.EventHelper.prototype = {
    constructor: cc.EventHelper, apply: function (c) {
        c.addEventListener = cc.EventHelper.prototype.addEventListener;
        c.hasEventListener = cc.EventHelper.prototype.hasEventListener;
        c.removeEventListener = cc.EventHelper.prototype.removeEventListener;
        c.dispatchEvent = cc.EventHelper.prototype.dispatchEvent
    }, addEventListener: function (c, d, e) {
        if ("load" === c && this._textureLoaded)setTimeout(function () {
            d.call(e)
        }, 0); else {
            void 0 === this._listeners && (this._listeners = {});
            var f = this._listeners;
            void 0 ===
            f[c] && (f[c] = []);
            this.hasEventListener(c, d, e) || f[c].push({callback: d, eventTarget: e})
        }
    }, hasEventListener: function (c, d, e) {
        if (void 0 === this._listeners)return !1;
        var f = this._listeners;
        if (void 0 !== f[c]) {
            c = 0;
            for (var g = f.length; c < g; c++) {
                var h = f[c];
                if (h.callback === d && h.eventTarget === e)return !0
            }
        }
        return !1
    }, removeEventListener: function (c, d) {
        if (void 0 !== this._listeners) {
            var e = this._listeners[c];
            if (void 0 !== e)for (var f = 0; f < e.length;)e[f].eventTarget === d ? e.splice(f, 1) : f++
        }
    }, dispatchEvent: function (c, d) {
        if (void 0 !==
            this._listeners) {
            null == d && (d = !0);
            var e = this._listeners[c];
            if (void 0 !== e) {
                for (var f = [], g = e.length, h = 0; h < g; h++)f[h] = e[h];
                for (h = 0; h < g; h++)f[h].callback.call(f[h].eventTarget, this);
                d && (e.length = 0)
            }
        }
    }
};
cc.EventHelper.prototype.apply(cc.game);
cc._LogInfos = {
    ActionManager_addAction: "cc.ActionManager.addAction(): action must be non-null",
    ActionManager_removeAction: "cocos2d: removeAction: Target not found",
    ActionManager_removeActionByTag: "cc.ActionManager.removeActionByTag(): an invalid tag",
    ActionManager_removeActionByTag_2: "cc.ActionManager.removeActionByTag(): target must be non-null",
    ActionManager_getActionByTag: "cc.ActionManager.getActionByTag(): an invalid tag",
    ActionManager_getActionByTag_2: "cocos2d : getActionByTag(tag \x3d %s): Action not found",
    configuration_dumpInfo: "cocos2d: **** WARNING **** CC_ENABLE_PROFILERS is defined. Disable it when you finish profiling (from ccConfig.js)",
    configuration_loadConfigFile: "Expected 'data' dict, but not found. Config file: %s",
    configuration_loadConfigFile_2: "Please load the resource first : %s",
    Director_resume: "cocos2d: Director: Error in gettimeofday",
    Director_setProjection: "cocos2d: Director: unrecognized projection",
    Director_popToSceneStackLevel: "cocos2d: Director: unrecognized projection",
    Director_popToSceneStackLevel_2: "cocos2d: Director: Error in gettimeofday",
    Director_popScene: "running scene should not null",
    Director_pushScene: "the scene should not null",
    arrayVerifyType: "element type is wrong!",
    Scheduler_scheduleCallbackForTarget: "CCSheduler#scheduleCallback. Callback already scheduled. Updating interval from:%s to %s",
    Scheduler_scheduleCallbackForTarget_2: "cc.scheduler.scheduleCallbackForTarget(): callback_fn should be non-null.",
    Scheduler_scheduleCallbackForTarget_3: "cc.scheduler.scheduleCallbackForTarget(): target should be non-null.",
    Scheduler_pauseTarget: "cc.Scheduler.pauseTarget():target should be non-null",
    Scheduler_resumeTarget: "cc.Scheduler.resumeTarget():target should be non-null",
    Scheduler_isTargetPaused: "cc.Scheduler.isTargetPaused():target should be non-null",
    Node_getZOrder: "getZOrder is deprecated. Please use getLocalZOrder instead.",
    Node_setZOrder: "setZOrder is deprecated. Please use setLocalZOrder instead.",
    Node_getRotation: "RotationX !\x3d RotationY. Don't know which one to return",
    Node_getScale: "ScaleX !\x3d ScaleY. Don't know which one to return",
    Node_addChild: "An Node can't be added as a child of itself.",
    Node_addChild_2: "child already added. It can't be added again",
    Node_addChild_3: "child must be non-null",
    Node_removeFromParentAndCleanup: "removeFromParentAndCleanup is deprecated. Use removeFromParent instead",
    Node_boundingBox: "boundingBox is deprecated. Use getBoundingBox instead",
    Node_removeChildByTag: "argument tag is an invalid tag",
    Node_removeChildByTag_2: "cocos2d: removeChildByTag(tag \x3d %s): child not found!",
    Node_removeAllChildrenWithCleanup: "removeAllChildrenWithCleanup is deprecated. Use removeAllChildren instead",
    Node_stopActionByTag: "cc.Node.stopActionBy(): argument tag an invalid tag",
    Node_getActionByTag: "cc.Node.getActionByTag(): argument tag is an invalid tag",
    Node_resumeSchedulerAndActions: "resumeSchedulerAndActions is deprecated, please use resume instead.",
    Node_pauseSchedulerAndActions: "pauseSchedulerAndActions is deprecated, please use pause instead.",
    Node__arrayMakeObjectsPerformSelector: "Unknown callback function",
    Node_reorderChild: "child must be non-null",
    Node_runAction: "cc.Node.runAction(): action must be non-null",
    Node_schedule: "callback function must be non-null",
    Node_schedule_2: "interval must be positive",
    Node_initWithTexture: "cocos2d: Could not initialize cc.AtlasNode. Invalid Texture.",
    AtlasNode_updateAtlasValues: "cc.AtlasNode.updateAtlasValues(): Shall be overridden in subclasses",
    AtlasNode_initWithTileFile: "",
    AtlasNode__initWithTexture: "cocos2d: Could not initialize cc.AtlasNode. Invalid Texture.",
    _EventListenerKeyboard_checkAvailable: "cc._EventListenerKeyboard.checkAvailable(): Invalid EventListenerKeyboard!",
    _EventListenerTouchOneByOne_checkAvailable: "cc._EventListenerTouchOneByOne.checkAvailable(): Invalid EventListenerTouchOneByOne!",
    _EventListenerTouchAllAtOnce_checkAvailable: "cc._EventListenerTouchAllAtOnce.checkAvailable(): Invalid EventListenerTouchAllAtOnce!",
    _EventListenerAcceleration_checkAvailable: "cc._EventListenerAcceleration.checkAvailable(): _onAccelerationEvent must be non-nil",
    EventListener_create: "Invalid parameter.",
    __getListenerID: "Don't call this method if the event is for touch.",
    eventManager__forceAddEventListener: "Invalid scene graph priority!",
    eventManager_addListener: "0 priority is forbidden for fixed priority since it's used for scene graph based priority.",
    eventManager_removeListeners: "Invalid listener type!",
    eventManager_setPriority: "Can't set fixed priority with scene graph based listener.",
    eventManager_addListener_2: "Invalid parameters.",
    eventManager_addListener_3: "listener must be a cc.EventListener object when adding a fixed priority listener",
    eventManager_addListener_4: "The listener has been registered, please don't register it again.",
    LayerMultiplex_initWithLayers: "parameters should not be ending with null in Javascript",
    LayerMultiplex_switchTo: "Invalid index in MultiplexLayer switchTo message",
    LayerMultiplex_switchToAndReleaseMe: "Invalid index in MultiplexLayer switchTo message",
    LayerMultiplex_addLayer: "cc.Layer.addLayer(): layer should be non-null",
    EGLView_setDesignResolutionSize: "Resolution not valid",
    EGLView_setDesignResolutionSize_2: "should set resolutionPolicy",
    inputManager_handleTouchesBegin: "The touches is more than MAX_TOUCHES, nUnusedIndex \x3d %s",
    swap: "cc.swap is being modified from original macro, please check usage",
    checkGLErrorDebug: "WebGL error %s",
    animationCache__addAnimationsWithDictionary: "cocos2d: cc.AnimationCache: No animations were found in provided dictionary.",
    animationCache__addAnimationsWithDictionary_2: "cc.AnimationCache. Invalid animation format",
    animationCache_addAnimations: "cc.AnimationCache.addAnimations(): File could not be found",
    animationCache__parseVersion1: "cocos2d: cc.AnimationCache: Animation '%s' found in dictionary without any frames - cannot add to animation cache.",
    animationCache__parseVersion1_2: "cocos2d: cc.AnimationCache: Animation '%s' refers to frame '%s' which is not currently in the cc.SpriteFrameCache. This frame will not be added to the animation.",
    animationCache__parseVersion1_3: "cocos2d: cc.AnimationCache: None of the frames for animation '%s' were found in the cc.SpriteFrameCache. Animation is not being added to the Animation Cache.",
    animationCache__parseVersion1_4: "cocos2d: cc.AnimationCache: An animation in your dictionary refers to a frame which is not in the cc.SpriteFrameCache. Some or all of the frames for the animation '%s' may be missing.",
    animationCache__parseVersion2: "cocos2d: CCAnimationCache: Animation '%s' found in dictionary without any frames - cannot add to animation cache.",
    animationCache__parseVersion2_2: "cocos2d: cc.AnimationCache: Animation '%s' refers to frame '%s' which is not currently in the cc.SpriteFrameCache. This frame will not be added to the animation.",
    animationCache_addAnimations_2: "cc.AnimationCache.addAnimations(): Invalid texture file name",
    Sprite_reorderChild: "cc.Sprite.reorderChild(): this child is not in children list",
    Sprite_ignoreAnchorPointForPosition: "cc.Sprite.ignoreAnchorPointForPosition(): it is invalid in cc.Sprite when using SpriteBatchNode",
    Sprite_setDisplayFrameWithAnimationName: "cc.Sprite.setDisplayFrameWithAnimationName(): Frame not found",
    Sprite_setDisplayFrameWithAnimationName_2: "cc.Sprite.setDisplayFrameWithAnimationName(): Invalid frame index",
    Sprite_setDisplayFrame: "setDisplayFrame is deprecated, please use setSpriteFrame instead.",
    Sprite__updateBlendFunc: "cc.Sprite._updateBlendFunc(): _updateBlendFunc doesn't work when the sprite is rendered using a cc.CCSpriteBatchNode",
    Sprite_initWithSpriteFrame: "cc.Sprite.initWithSpriteFrame(): spriteFrame should be non-null",
    Sprite_initWithSpriteFrameName: "cc.Sprite.initWithSpriteFrameName(): spriteFrameName should be non-null",
    Sprite_initWithSpriteFrameName1: " is null, please check.",
    Sprite_initWithFile: "cc.Sprite.initWithFile(): filename should be non-null",
    Sprite_setDisplayFrameWithAnimationName_3: "cc.Sprite.setDisplayFrameWithAnimationName(): animationName must be non-null",
    Sprite_reorderChild_2: "cc.Sprite.reorderChild(): child should be non-null",
    Sprite_addChild: "cc.Sprite.addChild(): cc.Sprite only supports cc.Sprites as children when using cc.SpriteBatchNode",
    Sprite_addChild_2: "cc.Sprite.addChild(): cc.Sprite only supports a sprite using same texture as children when using cc.SpriteBatchNode",
    Sprite_addChild_3: "cc.Sprite.addChild(): child should be non-null",
    Sprite_setTexture: "cc.Sprite.texture setter: Batched sprites should use the same texture as the batchnode",
    Sprite_updateQuadFromSprite: "cc.SpriteBatchNode.updateQuadFromSprite(): cc.SpriteBatchNode only supports cc.Sprites as children",
    Sprite_insertQuadFromSprite: "cc.SpriteBatchNode.insertQuadFromSprite(): cc.SpriteBatchNode only supports cc.Sprites as children",
    Sprite_addChild_4: "cc.SpriteBatchNode.addChild(): cc.SpriteBatchNode only supports cc.Sprites as children",
    Sprite_addChild_5: "cc.SpriteBatchNode.addChild(): cc.Sprite is not using the same texture",
    Sprite_initWithTexture: "Sprite.initWithTexture(): Argument must be non-nil ",
    Sprite_setSpriteFrame: "Invalid spriteFrameName",
    Sprite_setTexture_2: "Invalid argument: cc.Sprite.texture setter expects a CCTexture2D.",
    Sprite_updateQuadFromSprite_2: "cc.SpriteBatchNode.updateQuadFromSprite(): sprite should be non-null",
    Sprite_insertQuadFromSprite_2: "cc.SpriteBatchNode.insertQuadFromSprite(): sprite should be non-null",
    SpriteBatchNode_addSpriteWithoutQuad: "cc.SpriteBatchNode.addQuadFromSprite(): SpriteBatchNode only supports cc.Sprites as children",
    SpriteBatchNode_increaseAtlasCapacity: "cocos2d: CCSpriteBatchNode: resizing TextureAtlas capacity from %s to %s.",
    SpriteBatchNode_increaseAtlasCapacity_2: "cocos2d: WARNING: Not enough memory to resize the atlas",
    SpriteBatchNode_reorderChild: "cc.SpriteBatchNode.addChild(): Child doesn't belong to Sprite",
    SpriteBatchNode_removeChild: "cc.SpriteBatchNode.addChild(): sprite batch node should contain the child",
    SpriteBatchNode_addSpriteWithoutQuad_2: "cc.SpriteBatchNode.addQuadFromSprite(): child should be non-null",
    SpriteBatchNode_reorderChild_2: "cc.SpriteBatchNode.addChild(): child should be non-null",
    spriteFrameCache__getFrameConfig: "cocos2d: WARNING: originalWidth/Height not found on the cc.SpriteFrame. AnchorPoint won't work as expected. Regenrate the .plist",
    spriteFrameCache_addSpriteFrames: "cocos2d: WARNING: an alias with name %s already exists",
    spriteFrameCache__checkConflict: "cocos2d: WARNING: Sprite frame: %s has already been added by another source, please fix name conflit",
    spriteFrameCache_getSpriteFrame: "cocos2d: cc.SpriteFrameCahce: Frame %s not found",
    spriteFrameCache__getFrameConfig_2: "Please load the resource first : %s",
    spriteFrameCache_addSpriteFrames_2: "cc.SpriteFrameCache.addSpriteFrames(): plist should be non-null",
    spriteFrameCache_addSpriteFrames_3: "Argument must be non-nil",
    CCSpriteBatchNode_updateQuadFromSprite: "cc.SpriteBatchNode.updateQuadFromSprite(): cc.SpriteBatchNode only supports cc.Sprites as children",
    CCSpriteBatchNode_insertQuadFromSprite: "cc.SpriteBatchNode.insertQuadFromSprite(): cc.SpriteBatchNode only supports cc.Sprites as children",
    CCSpriteBatchNode_addChild: "cc.SpriteBatchNode.addChild(): cc.SpriteBatchNode only supports cc.Sprites as children",
    CCSpriteBatchNode_initWithTexture: "Sprite.initWithTexture(): Argument must be non-nil ",
    CCSpriteBatchNode_addChild_2: "cc.Sprite.addChild(): child should be non-null",
    CCSpriteBatchNode_setSpriteFrame: "Invalid spriteFrameName",
    CCSpriteBatchNode_setTexture: "Invalid argument: cc.Sprite texture setter expects a CCTexture2D.",
    CCSpriteBatchNode_updateQuadFromSprite_2: "cc.SpriteBatchNode.updateQuadFromSprite(): sprite should be non-null",
    CCSpriteBatchNode_insertQuadFromSprite_2: "cc.SpriteBatchNode.insertQuadFromSprite(): sprite should be non-null",
    CCSpriteBatchNode_addChild_3: "cc.SpriteBatchNode.addChild(): child should be non-null",
    TextureAtlas_initWithFile: "cocos2d: Could not open file: %s",
    TextureAtlas_insertQuad: "cc.TextureAtlas.insertQuad(): invalid totalQuads",
    TextureAtlas_initWithTexture: "cc.TextureAtlas.initWithTexture():texture should be non-null",
    TextureAtlas_updateQuad: "cc.TextureAtlas.updateQuad(): quad should be non-null",
    TextureAtlas_updateQuad_2: "cc.TextureAtlas.updateQuad(): Invalid index",
    TextureAtlas_insertQuad_2: "cc.TextureAtlas.insertQuad(): Invalid index",
    TextureAtlas_insertQuads: "cc.TextureAtlas.insertQuad(): Invalid index + amount",
    TextureAtlas_insertQuadFromIndex: "cc.TextureAtlas.insertQuadFromIndex(): Invalid newIndex",
    TextureAtlas_insertQuadFromIndex_2: "cc.TextureAtlas.insertQuadFromIndex(): Invalid fromIndex",
    TextureAtlas_removeQuadAtIndex: "cc.TextureAtlas.removeQuadAtIndex(): Invalid index",
    TextureAtlas_removeQuadsAtIndex: "cc.TextureAtlas.removeQuadsAtIndex(): index + amount out of bounds",
    TextureAtlas_moveQuadsFromIndex: "cc.TextureAtlas.moveQuadsFromIndex(): move is out of bounds",
    TextureAtlas_moveQuadsFromIndex_2: "cc.TextureAtlas.moveQuadsFromIndex(): Invalid newIndex",
    TextureAtlas_moveQuadsFromIndex_3: "cc.TextureAtlas.moveQuadsFromIndex(): Invalid oldIndex",
    textureCache_addPVRTCImage: "TextureCache:addPVRTCImage does not support on HTML5",
    textureCache_addETCImage: "TextureCache:addPVRTCImage does not support on HTML5",
    textureCache_textureForKey: "textureForKey is deprecated. Please use getTextureForKey instead.",
    textureCache_addPVRImage: "addPVRImage does not support on HTML5",
    textureCache_addUIImage: "cocos2d: Couldn't add UIImage in TextureCache",
    textureCache_dumpCachedTextureInfo: "cocos2d: '%s' id\x3d%s %s x %s",
    textureCache_dumpCachedTextureInfo_2: "cocos2d: '%s' id\x3d HTMLCanvasElement %s x %s",
    textureCache_dumpCachedTextureInfo_3: "cocos2d: TextureCache dumpDebugInfo: %s textures, HTMLCanvasElement for %s KB (%s MB)",
    textureCache_addUIImage_2: "cc.Texture.addUIImage(): image should be non-null",
    Texture2D_initWithETCFile: "initWithETCFile does not support on HTML5",
    Texture2D_initWithPVRFile: "initWithPVRFile does not support on HTML5",
    Texture2D_initWithPVRTCData: "initWithPVRTCData does not support on HTML5",
    Texture2D_addImage: "cc.Texture.addImage(): path should be non-null",
    Texture2D_initWithImage: "cocos2d: cc.Texture2D. Can't create Texture. UIImage is nil",
    Texture2D_initWithImage_2: "cocos2d: WARNING: Image (%s x %s) is bigger than the supported %s x %s",
    Texture2D_initWithString: "initWithString isn't supported on cocos2d-html5",
    Texture2D_initWithETCFile_2: "initWithETCFile does not support on HTML5",
    Texture2D_initWithPVRFile_2: "initWithPVRFile does not support on HTML5",
    Texture2D_initWithPVRTCData_2: "initWithPVRTCData does not support on HTML5",
    Texture2D_bitsPerPixelForFormat: "bitsPerPixelForFormat: %s, cannot give useful result, it's a illegal pixel format",
    Texture2D__initPremultipliedATextureWithImage: "cocos2d: cc.Texture2D: Using RGB565 texture since image has no alpha",
    Texture2D_addImage_2: "cc.Texture.addImage(): path should be non-null",
    Texture2D_initWithData: "NSInternalInconsistencyException",
    MissingFile: "Missing file: %s",
    radiansToDegress: "cc.radiansToDegress() should be called cc.radiansToDegrees()",
    RectWidth: "Rect width exceeds maximum margin: %s",
    RectHeight: "Rect height exceeds maximum margin: %s",
    EventManager__updateListeners: "If program goes here, there should be event in dispatch.",
    EventManager__updateListeners_2: "_inDispatch should be 1 here."
};
cc._logToWebPage = function (c) {
    if (cc._canvas) {
        var d = cc._logList, e = document;
        if (!d) {
            var f = e.createElement("Div"), d = f.style;
            f.setAttribute("id", "logInfoDiv");
            cc._canvas.parentNode.appendChild(f);
            f.setAttribute("width", "200");
            f.setAttribute("height", cc._canvas.height);
            d.zIndex = "99999";
            d.position = "absolute";
            d.top = "0";
            d.left = "0";
            d = cc._logList = e.createElement("textarea");
            e = d.style;
            d.setAttribute("rows", "20");
            d.setAttribute("cols", "30");
            d.setAttribute("disabled", !0);
            f.appendChild(d);
            e.backgroundColor = "transparent";
            e.borderBottom = "1px solid #cccccc";
            e.borderRightWidth = "0px";
            e.borderLeftWidth = "0px";
            e.borderTopWidth = "0px";
            e.borderTopStyle = "none";
            e.borderRightStyle = "none";
            e.borderLeftStyle = "none";
            e.padding = "0px";
            e.margin = 0
        }
        d.value = d.value + c + "\r\n";
        d.scrollTop = d.scrollHeight
    }
};
cc._formatString = function (c) {
    if (cc.isObject(c))try {
        return JSON.stringify(c)
    } catch (d) {
        return ""
    } else return c
};
cc._initDebugSetting = function (c) {
    var d = cc.game;
    if (c !== d.DEBUG_MODE_NONE) {
        var e;
        c > d.DEBUG_MODE_ERROR ? (e = cc._logToWebPage.bind(cc), cc.error = function () {
            e("ERROR :  " + cc.formatStr.apply(cc, arguments))
        }, cc.assert = function (c, d) {
            if (!c && d) {
                for (var h = 2; h < arguments.length; h++)d = d.replace(/(%s)|(%d)/, cc._formatString(arguments[h]));
                e("Assert: " + d)
            }
        }, c !== d.DEBUG_MODE_ERROR_FOR_WEB_PAGE && (cc.warn = function () {
            e("WARN :  " + cc.formatStr.apply(cc, arguments))
        }), c === d.DEBUG_MODE_INFO_FOR_WEB_PAGE && (cc.log = function () {
            e(cc.formatStr.apply(cc,
                arguments))
        })) : console && console.log.apply && (cc.error = Function.prototype.bind.call(console.error, console), cc.assert = console.assert ? Function.prototype.bind.call(console.assert, console) : function (c, d) {
            if (!c && d) {
                for (var e = 2; e < arguments.length; e++)d = d.replace(/(%s)|(%d)/, cc._formatString(arguments[e]));
                throw Error(d);
            }
        }, c !== d.DEBUG_MODE_ERROR && (cc.warn = Function.prototype.bind.call(console.warn, console)), c === d.DEBUG_MODE_INFO && (cc.log = Function.prototype.bind.call(console.log, console)))
    }
};
cc.loader.loadBinary = function (c, d) {
    var e = this, f = this.getXMLHttpRequest(), g = "load " + c + " failed!";
    f.open("GET", c, !0);
    cc.loader.loadBinary._IEFilter ? (f.setRequestHeader("Accept-Charset", "x-user-defined"), f.onreadystatechange = function () {
        if (4 === f.readyState && 200 === f.status) {
            var c = cc._convertResponseBodyToText(f.responseBody);
            d(null, e._str2Uint8Array(c))
        } else d(g)
    }) : (f.overrideMimeType && f.overrideMimeType("text/plain; charset\x3dx-user-defined"), f.onload = function () {
        4 === f.readyState && 200 === f.status ? d(null,
            e._str2Uint8Array(f.responseText)) : d(g)
    });
    f.send(null)
};
cc.loader.loadBinary._IEFilter = /msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent) && window.IEBinaryToArray_ByteStr && window.IEBinaryToArray_ByteStr_Last;
cc.loader._str2Uint8Array = function (c) {
    if (!c)return null;
    for (var d = new Uint8Array(c.length), e = 0; e < c.length; e++)d[e] = c.charCodeAt(e) & 255;
    return d
};
cc.loader.loadBinarySync = function (c) {
    var d = this.getXMLHttpRequest(), e = "load " + c + " failed!";
    d.open("GET", c, !1);
    c = null;
    if (cc.loader.loadBinary._IEFilter) {
        d.setRequestHeader("Accept-Charset", "x-user-defined");
        d.send(null);
        if (200 !== d.status)return cc.log(e), null;
        (d = cc._convertResponseBodyToText(d.responseBody)) && (c = this._str2Uint8Array(d))
    } else {
        d.overrideMimeType && d.overrideMimeType("text/plain; charset\x3dx-user-defined");
        d.send(null);
        if (200 !== d.status)return cc.log(e), null;
        c = this._str2Uint8Array(d.responseText)
    }
    return c
};
window.Uint8Array = window.Uint8Array || window.Array;
if (cc.loader.loadBinary._IEFilter) {
    var IEBinaryToArray_ByteStr_Script = '\x3c!-- IEBinaryToArray_ByteStr --\x3e\r\nFunction IEBinaryToArray_ByteStr(Binary)\r\n   IEBinaryToArray_ByteStr \x3d CStr(Binary)\r\nEnd Function\r\nFunction IEBinaryToArray_ByteStr_Last(Binary)\r\n   Dim lastIndex\r\n   lastIndex \x3d LenB(Binary)\r\n   if lastIndex mod 2 Then\r\n       IEBinaryToArray_ByteStr_Last \x3d Chr( AscB( MidB( Binary, lastIndex, 1 ) ) )\r\n   Else\r\n       IEBinaryToArray_ByteStr_Last \x3d ""\r\n   End If\r\nEnd Function\r\n', myVBScript =
        document.createElement("script");
    myVBScript.type = "text/vbscript";
    myVBScript.textContent = IEBinaryToArray_ByteStr_Script;
    document.body.appendChild(myVBScript);
    cc._convertResponseBodyToText = function (c) {
        for (var d = {}, e = 0; 256 > e; e++)for (var f = 0; 256 > f; f++)d[String.fromCharCode(e + 256 * f)] = String.fromCharCode(e) + String.fromCharCode(f);
        e = IEBinaryToArray_ByteStr(c);
        c = IEBinaryToArray_ByteStr_Last(c);
        return e.replace(/[\s\S]/g, function (c) {
                return d[c]
            }) + c
    }
}
;cc = cc || {};
cc._loadingImage = "data:image/gif;base64,R0lGODlhEAAQALMNAD8/P7+/vyoqKlVVVX9/fxUVFUBAQGBgYMDAwC8vL5CQkP///wAAAP///wAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFAAANACwAAAAAEAAQAAAEO5DJSau9OOvNex0IMnDIsiCkiW6g6BmKYlBFkhSUEgQKlQCARG6nEBwOgl+QApMdCIRD7YZ5RjlGpCUCACH5BAUAAA0ALAAAAgAOAA4AAAQ6kLGB0JA4M7QW0hrngRllkYyhKAYqKUGguAws0ypLS8JxCLQDgXAIDg+FRKIA6v0SAECCBpXSkstMBAAh+QQFAAANACwAAAAACgAQAAAEOJDJORAac6K1kDSKYmydpASBUl0mqmRfaGTCcQgwcxDEke+9XO2WkxQSiUIuAQAkls0n7JgsWq8RACH5BAUAAA0ALAAAAAAOAA4AAAQ6kMlplDIzTxWC0oxwHALnDQgySAdBHNWFLAvCukc215JIZihVIZEogDIJACBxnCSXTcmwGK1ar1hrBAAh+QQFAAANACwAAAAAEAAKAAAEN5DJKc4RM+tDyNFTkSQF5xmKYmQJACTVpQSBwrpJNteZSGYoFWjIGCAQA2IGsVgglBOmEyoxIiMAIfkEBQAADQAsAgAAAA4ADgAABDmQSVZSKjPPBEDSGucJxyGA1XUQxAFma/tOpDlnhqIYN6MEAUXvF+zldrMBAjHoIRYLhBMqvSmZkggAIfkEBQAADQAsBgAAAAoAEAAABDeQyUmrnSWlYhMASfeFVbZdjHAcgnUQxOHCcqWylKEohqUEAYVkgEAMfkEJYrFA6HhKJsJCNFoiACH5BAUAAA0ALAIAAgAOAA4AAAQ3kMlJq704611SKloCAEk4lln3DQgyUMJxCBKyLAh1EMRR3wiDQmHY9SQslyIQUMRmlmVTIyRaIgA7";
cc._fpsImage = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAAgCAYAAAD9qabkAAAKQ2lDQ1BJQ0MgcHJvZmlsZQAAeNqdU3dYk/cWPt/3ZQ9WQtjwsZdsgQAiI6wIyBBZohCSAGGEEBJAxYWIClYUFRGcSFXEgtUKSJ2I4qAouGdBiohai1VcOO4f3Ke1fXrv7e371/u855zn/M55zw+AERImkeaiagA5UoU8Otgfj09IxMm9gAIVSOAEIBDmy8JnBcUAAPADeXh+dLA//AGvbwACAHDVLiQSx+H/g7pQJlcAIJEA4CIS5wsBkFIAyC5UyBQAyBgAsFOzZAoAlAAAbHl8QiIAqg0A7PRJPgUA2KmT3BcA2KIcqQgAjQEAmShHJAJAuwBgVYFSLALAwgCgrEAiLgTArgGAWbYyRwKAvQUAdo5YkA9AYACAmUIszAAgOAIAQx4TzQMgTAOgMNK/4KlfcIW4SAEAwMuVzZdL0jMUuJXQGnfy8ODiIeLCbLFCYRcpEGYJ5CKcl5sjE0jnA0zODAAAGvnRwf44P5Dn5uTh5mbnbO/0xaL+a/BvIj4h8d/+vIwCBAAQTs/v2l/l5dYDcMcBsHW/a6lbANpWAGjf+V0z2wmgWgrQevmLeTj8QB6eoVDIPB0cCgsL7SViob0w44s+/zPhb+CLfvb8QB7+23rwAHGaQJmtwKOD/XFhbnauUo7nywRCMW735yP+x4V//Y4p0eI0sVwsFYrxWIm4UCJNx3m5UpFEIcmV4hLpfzLxH5b9CZN3DQCshk/ATrYHtctswH7uAQKLDljSdgBAfvMtjBoLkQAQZzQyefcAAJO/+Y9AKwEAzZek4wAAvOgYXKiUF0zGCAAARKCBKrBBBwzBFKzADpzBHbzAFwJhBkRADCTAPBBCBuSAHAqhGJZBGVTAOtgEtbADGqARmuEQtMExOA3n4BJcgetwFwZgGJ7CGLyGCQRByAgTYSE6iBFijtgizggXmY4EImFINJKApCDpiBRRIsXIcqQCqUJqkV1II/ItchQ5jVxA+pDbyCAyivyKvEcxlIGyUQPUAnVAuagfGorGoHPRdDQPXYCWomvRGrQePYC2oqfRS+h1dAB9io5jgNExDmaM2WFcjIdFYIlYGibHFmPlWDVWjzVjHVg3dhUbwJ5h7wgkAouAE+wIXoQQwmyCkJBHWExYQ6gl7CO0EroIVwmDhDHCJyKTqE+0JXoS+cR4YjqxkFhGrCbuIR4hniVeJw4TX5NIJA7JkuROCiElkDJJC0lrSNtILaRTpD7SEGmcTCbrkG3J3uQIsoCsIJeRt5APkE+S+8nD5LcUOsWI4kwJoiRSpJQSSjVlP+UEpZ8yQpmgqlHNqZ7UCKqIOp9aSW2gdlAvU4epEzR1miXNmxZDy6Qto9XQmmlnafdoL+l0ugndgx5Fl9CX0mvoB+nn6YP0dwwNhg2Dx0hiKBlrGXsZpxi3GS+ZTKYF05eZyFQw1zIbmWeYD5hvVVgq9ip8FZHKEpU6lVaVfpXnqlRVc1U/1XmqC1SrVQ+rXlZ9pkZVs1DjqQnUFqvVqR1Vu6k2rs5Sd1KPUM9RX6O+X/2C+mMNsoaFRqCGSKNUY7fGGY0hFsYyZfFYQtZyVgPrLGuYTWJbsvnsTHYF+xt2L3tMU0NzqmasZpFmneZxzQEOxrHg8DnZnErOIc4NznstAy0/LbHWaq1mrX6tN9p62r7aYu1y7Rbt69rvdXCdQJ0snfU6bTr3dQm6NrpRuoW623XP6j7TY+t56Qn1yvUO6d3RR/Vt9KP1F+rv1u/RHzcwNAg2kBlsMThj8MyQY+hrmGm40fCE4agRy2i6kcRoo9FJoye4Ju6HZ+M1eBc+ZqxvHGKsNN5l3Gs8YWJpMtukxKTF5L4pzZRrmma60bTTdMzMyCzcrNisyeyOOdWca55hvtm82/yNhaVFnMVKizaLx5balnzLBZZNlvesmFY+VnlW9VbXrEnWXOss623WV2xQG1ebDJs6m8u2qK2brcR2m23fFOIUjynSKfVTbtox7PzsCuya7AbtOfZh9iX2bfbPHcwcEh3WO3Q7fHJ0dcx2bHC866ThNMOpxKnD6VdnG2ehc53zNRemS5DLEpd2lxdTbaeKp26fesuV5RruutK10/Wjm7ub3K3ZbdTdzD3Ffav7TS6bG8ldwz3vQfTw91jicczjnaebp8LzkOcvXnZeWV77vR5Ps5wmntYwbcjbxFvgvct7YDo+PWX6zukDPsY+Ap96n4e+pr4i3z2+I37Wfpl+B/ye+zv6y/2P+L/hefIW8U4FYAHBAeUBvYEagbMDawMfBJkEpQc1BY0FuwYvDD4VQgwJDVkfcpNvwBfyG/ljM9xnLJrRFcoInRVaG/owzCZMHtYRjobPCN8Qfm+m+UzpzLYIiOBHbIi4H2kZmRf5fRQpKjKqLupRtFN0cXT3LNas5Fn7Z72O8Y+pjLk722q2cnZnrGpsUmxj7Ju4gLiquIF4h/hF8ZcSdBMkCe2J5MTYxD2J43MC52yaM5zkmlSWdGOu5dyiuRfm6c7Lnnc8WTVZkHw4hZgSl7I/5YMgQlAvGE/lp25NHRPyhJuFT0W+oo2iUbG3uEo8kuadVpX2ON07fUP6aIZPRnXGMwlPUit5kRmSuSPzTVZE1t6sz9lx2S05lJyUnKNSDWmWtCvXMLcot09mKyuTDeR55m3KG5OHyvfkI/lz89sVbIVM0aO0Uq5QDhZML6greFsYW3i4SL1IWtQz32b+6vkjC4IWfL2QsFC4sLPYuHhZ8eAiv0W7FiOLUxd3LjFdUrpkeGnw0n3LaMuylv1Q4lhSVfJqedzyjlKD0qWlQyuCVzSVqZTJy26u9Fq5YxVhlWRV72qX1VtWfyoXlV+scKyorviwRrjm4ldOX9V89Xlt2treSrfK7etI66Trbqz3Wb+vSr1qQdXQhvANrRvxjeUbX21K3nShemr1js20zcrNAzVhNe1bzLas2/KhNqP2ep1/XctW/a2rt77ZJtrWv913e/MOgx0VO97vlOy8tSt4V2u9RX31btLugt2PGmIbur/mft24R3dPxZ6Pe6V7B/ZF7+tqdG9s3K+/v7IJbVI2jR5IOnDlm4Bv2pvtmne1cFoqDsJB5cEn36Z8e+NQ6KHOw9zDzd+Zf7f1COtIeSvSOr91rC2jbaA9ob3v6IyjnR1eHUe+t/9+7zHjY3XHNY9XnqCdKD3x+eSCk+OnZKeenU4/PdSZ3Hn3TPyZa11RXb1nQ8+ePxd07ky3X/fJ897nj13wvHD0Ivdi2yW3S609rj1HfnD94UivW2/rZffL7Vc8rnT0Tes70e/Tf/pqwNVz1/jXLl2feb3vxuwbt24m3Ry4Jbr1+Hb27Rd3Cu5M3F16j3iv/L7a/eoH+g/qf7T+sWXAbeD4YMBgz8NZD+8OCYee/pT/04fh0kfMR9UjRiONj50fHxsNGr3yZM6T4aeypxPPyn5W/3nrc6vn3/3i+0vPWPzY8Av5i8+/rnmp83Lvq6mvOscjxx+8znk98ab8rc7bfe+477rfx70fmSj8QP5Q89H6Y8en0E/3Pud8/vwv94Tz+4A5JREAAAAGYktHRAD/AP8A/6C9p5MAAAAJcEhZcwAACxMAAAsTAQCanBgAAAAHdElNRQfcAgcQLxxUBNp/AAAQZ0lEQVR42u2be3QVVZbGv1N17829eRLyIKAEOiISEtPhJTJAYuyBDmhWjAEx4iAGBhxA4wABbVAMWUAeykMCM+HRTcBRWkNH2l5moS0LCCrQTkYeQWBQSCAIgYRXEpKbW/XNH5zS4noR7faPEeu31l0h4dSpvc+t/Z199jkFWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhY/H9D/MR9qfKnLj/00U71aqfJn9+HCkCR/Wk36ddsgyJ/1wF4fkDfqqm9/gPsUeTnVr6a2xlQfnxdI7zs0W7irzD17Ytb2WT7EeNv/r4ox1O3Quf2QP2pgt9utwfout4FQE8AVBSlnaRmfvAURQkg2RlAbwB9AThlW5L0GaiKojhJhgOIBqDa7XaPrusdPtr5kQwF0BVAAoBIABRCKDd5aFUhRDAAw57eAOwAhKIoupft3zoqhB1AqLwuHIBut9uFt02qqvqRDJR2dAEQJj/BAOjn56dqmma+xiaECAEQAWAggLsB6A6HQ2iaZggBhBAqgEAAnQB0kzaEmT4hAITT6VQ8Ho/HJAKKECJQtr8LwD1y/A1/vcdfEUIEyfZ9AcQbYvZ942Px88L2UwlJR0dH0EMPPbRj5syZPUeNGrXR7Xb/641xIwJ1XY9NSUlZm52dfW+XLl1w8uRJzJ8//+OGhoYJqqqe1TSt1Wsm9NN1PSIqKmr12rVrR5WUlHy1bdu2AQCumWc3IYRD1/UwVVXnFRQUTIuNjUVzczN2797dWFJSkq8oymZd15sAGAEnFEUJ1nX9nzIzM1dnZmZGh4SE4OTJk5g5c+Zf29vbp9pstrMej6fVOyhIhgAYU1hY+B+hoaGoqKg4XVlZea+XTULTNFdCQsLGiRMnPuR2u3UhBOV9eeDAAWXTpk095DUe6WsoyRE5OTlr0tLSAux2O/bs2cO5c+e+pijKUpIXSHaQVAGkvPLKK++6XK4OksJLCFlXV2cvKSlJBFAjhU+x2WwhHo9nUHp6+urMzMy7wsLCUF9fjxdffPHjxsbGiTab7WuPx9NiEutOuq4PyMjI+M+srKyYqKgoHD58GDNmzNjq8XhyVFU9b/q+LH7hBAEYu3PnTlZVVRFAGgCX6f/tAHoOHDjwa0p27txp/JO9e/f+QM7cipw9nfL3kQBKt2zZQpJ87rnn6mQmoHilw2EACs+cOUOSrK+vZ1NTE0nyo48+IoBpxswoBcMJ4Ndjx471kOTFixe5d+9ekqTH42H//v13A4jyzpAURfEH0H/OnDnthu1z5sw558MmFUCPWbNmnaMP3nrrLZoyDmP8Hl68eDFJ8siRI9/Yc+zYMQKYKdtAztrTrl27xptRXV1NAKMAOAyBBBA/Y8aMdpLs6Ojgxx9//E37+++//29yvFXppwvAwMcee8xjtDHsuXLlCqOjo//ia3wsfpkoALqFhoZuIckJEyackimm3dQmEMDUmpoakmRISMhhAHOHDx/eQJIbN24kgKEyMAHAFRMTs2XXrl1saWkhSZ0kp0+ffhrAr3wEW/S8efOukORLL72kA1gKYMPWrVtJkk899dRJAHeYrgsEsIQkjx8/TgDvAPjd448/3kaSb7zxBmUa7vC6z53BwcFbSHL9+vU6Sc6aNes8gF5ewWAH0PfVV18lSQL4DMBGIcQ6AKtcLleBFC2jXtFt8ODBe0iyoqKCAJYByC8qKmJDQwOzsrK+MAmqo1OnTveHhoa+GRkZ+XZkZOSWiIiIvzgcjk9mzpypkWRmZuZpmbYbGV4AgPnNzc1sa2sjgN0A5iQmJtaSZHl5OQHcb/K3s81mW0uSTU1NBFAFYFbfvn1Pk+Tbb79NAA8IIVzW42/hByA+Pz/fLR/2ZXIda05NI/z9/TeR5J49ewhgqlxTrtI0jY2NjQQw3zTLuWJiYjaUlJToS5Ys6fjkk080kwDEeAmADcA9GzZsIElGRUW9CyAWwLApU6Y0kOSKFSsog9QICGdERMTGsrIyZmVlEcC9AB4IDw/fTpLbtm0jgN94CUAnAJmVlZVcs2aNZ/LkyRdJcvbs2b4EwAkgZfPmzTxw4AABFAN4BkC6vFeUSewcAO5duXIlSTIhIaEawGMAxgKYAmAGgCS73e5vrKVk/yGythANYEhCQsIhkly+fDkBpKqqGmL6DgIALDKN/3yZpVWQZGVlJQE8aPI3KiMjo5okV61aRQAjAPQBMPfIkSN0u90EUCBtsPiFEwpgbn19PdetW2fM5N4zQ9ekpKQqkty0aRMBpMjiWM6JEydIkoqirJUFJ6iq6pAPVy8A6cZMehMBUACEuVyuFwG8HBwcPEIWx367ZMkSjSQXLVrUJouTRorrkAHdA8BdQogsAOsKCwtJkmPGjDkvMw2bDDo/ADEjRoz4XylyFbm5uY0mAbjLyyZ/AOOrq6tZVlbWsWDBgo69e/eyoqKCgwcPPg4gSQaoIRbp27dvN7KF+tLSUr28vJwFBQXtMpvpYRIM7+wrAkDeqVOnePbsWQIoNKfzpiXPg8uXLydJJicnNwF4f+nSpW6STEtLq5fjYwhk1wkTJtSQ5Ouvv04AqTKj+N2xY8dIkgEBAW/Ie1v8wncRegwZMmQvSfbr12+3Ua33WqPfOWbMmP0kWVpaSgCDZAqcfejQIWNZsEGKgvnh9gfQb9myZd8nAEJVVZtMkUNk8CcNHTq0liR1XWdYWNhmH1mJIme80OnTp18x1rp5eXkEsNJms92Fb7e/IgEsvHz5Mp999tkmAI/l5uZeMC0B7vEqqAYAyL106RJJsra2lpWVld+sucePH38ZQG+5NncBeOrgwYMkqbe3t/Po0aOsra011wAWyl0H7x0JJ4DE+fPnu0kyPT29DsDdUrBuyNKEEAkAdpw/f/6GeoEM8GUmfwEgPCIiopwkGxsbabPZPgOw6L777vvm4p49e26VGYjFLxUhhD+ApLKyMp44ccIoVnXybgbgzkcfffRzklyzZg0BDJYCMMmoCwQFBXkLgLGWvvcWAgBToSsKwNPTp09vMR7UuLi4rwH0lgU8c/Db5ezbeeTIkRWzZ8++aMxu+fn5BPCADBwHgP4LFy701NXVEUAJgAnPP/98kyxMNgHo53A4zH77BQQETMvPz7+Um5vbBuAlAFMSExPPmdbVL0qh8Acw8fDhw5SCchVAEYAVb775JknyhRdeaJYztHfxMwLAaqNwCGC2FArv8x0hAHKNLGPKlCme5OTk/Zs3bzb7O0wKiiG8KXl5ed8IxenTp0mSR48e1UmyW7duWywBuD2xyQcgFECgoih+8H1gyJgZV5Lkyy+/3CbTRIePtl2HDBmyw1QBHyGDdXZdXR1JUghRKkXBjOMHCoBdpr0L3nvvPZLkF198wejo6O0A4lVVDTb74HQ6AwD8Wq7Jh8rgGgDgQ13XjVR8qaxJuADMbmlpYXl5uV5UVNRWUFDgfv/993Vj/ZydnU1c37eHXML4S3viAcQqitJD2l104cIFY8lTKsXSBWBMVVWVcd9yed2A1NTUQ6Zl00CvLMMOoHdubm6zFIlWOf5+PsY/Kj09vdrU11QAwwGsv3jxIk21m2DZr10I0RXAuAcffPBgaWkpV69eTYfDcdiwUxY0w6xw+flX8L1xApjevXv3lREREaW6rofB93aPDUDQpEmTMgHgtddeqwBwEd/utZvpqK6uPgEAcXFxkA94NwB9unfvjrNnz4LklwDcf08iIqv66Zs2bXrl4YcfxooVKxAbG7uqrq5uAYA2TdOEqqpGYIi2tjbl6aeffu/YsWPv5uTk7JaC1wHg4Pnz542MwoVvTx+21dbWYvjw4WLixIl+2dnZ9lGjRgmSTE1NRUpKCkwFTGiaxtTU1OXTpk3707Bhw/6g67pDipnT4biuj7qut+Lbk3Vf1tTUXI9qu91Pjq1QFEUBgJaWFgBo8yGOQ8eNGxcAAOvXr/8QwBUfYygAKL169eoCABcuXACAWtn2hOGv0+kMNO1KiPDw8F4A4rZv3/7R1KlTR0+bNu1ht9u9r1+/fqitrQXJgwDarRC6/QjPzs4+QJIffPCB9/aQmSAA43ft2mW0e1QGoi8CAPyLsZccExNTC2BlRkbGRdOyYJCP2csBIN6UAZzCd7cBbQCijYp/dXU1ExMTz6SmptaMHj36f9LS0vYlJCRsl6mxIWSdu3fv/g5J7t+/nwC2AShMTk6+SJKff/45AWRLYbD7+fndAeDf5BJnLoCCyZMnt5JkdnZ2C4B/F0KEm1Pu+Pj4rST55ZdfEsBWAK+mpaVdMo3raDn7KwDuSEpK+m+S3LBhAwG8DuCtHTt2UBbpjgC408vvcFVV15HkuXPnjMp+p5uMf0RcXNyHJNnQ0EBVVfcCWBQXF3fG+Jv0yxABPwB5LS0tRmFxN4BlTzzxxGWSXLx4sS5F3GGFy+1Hp5SUlJq6ujoWFxdTpsZ2H+0iIyMj/0iSWVlZX5mr5jfJFroPGzasxlhTnjp1iiTZ3NxMl8tlrCd9pfa9SkpKSJI5OTmnZOageLUZZqxvfVFWVkZcPwdgNwnSCKPqb17jkmR8fPzfZMDZ5CRsFBmNI7h95s2b1yhT7/MAYmStwCx4vy0uLqa3v5qmEcCfvSr1QQAeXb16NY3Cm3HQ55133iGAp+SxZTNhKSkpfzUddkrFjYevzAQCeGjp0qXfsYckY2NjTwD4leGDLCL2HTdunNtoY+zWSHFcIHdsFCtcfuZ1vO9Eqs3m7/F47sb1k2qX/f3997W2tl7BjWfpBYDOzzzzzIVJkyZh0KBBCwEsB3AJvl9AETabLcDj8dwRFRW1ctasWb8JCgpSzp07d62wsPC/Wltb8xRFadR1/ZqPXYbgAQMGbI2Pjw/+6quv9ldVVT0r01ezuPRJSUn5Y9euXXVd11WzDaqq6kePHm3+7LPPRgO4KlNuxWazhXo8nuTk5OSXMjIyEl0uFxoaGtqKior+dPXq1VdUVT0jj7r68ieoT58+vx8yZMjdx48fP1JVVTVF9m20VW02WyfZf97YsWPjXS4X6urqWvPy8jYCWCyEuEDS8FdVFKWzruv//OSTTy5OTk7uqWkaPv3007qysrJ8RVH+LI8ym8/rB3Tu3HnRI488knLo0KG2ffv2ZQI4C98vP6mqqoZqmpaclpa2cOTIkX39/f3R0NDQUVxc/G5TU9PLqqrWa5rWLH1QVFUN0TStX1JSUvH48eP7BwYG4uDBg1cKCgpeBbBe2u+2Qug2EwD5N5sMPuNtMe8XP4TT6Qxoa2sbIGeXvUKIK7d4IISiKC5d1wPljOfA9bPwzYqiXNV13dd6Uqiq6qdpml2mpe02m63d4/G4vcTF5fF47LJf71nJA6BZVVW3pmntuPHlmAD5wk6Q9NnbHp9vHaqq6tA0zU/64PZhk1FfCZB9G/23ALiqKEqzD39tpvbGUqoFwFUhRLP3yzpCCDtJpxyXDulfG27+pqRR3DXsUWVd4Yq0x/taVQjhIhksC8L+ABpM9ljBf5sKwI8pIBr75L5E4vvu+UNeG/a+hv+AL7yFH8qPtOfHjtOP6V/Bja8D6z/B2Nys/1u9Xv33tLf4GfF/LC4GCJwByWIAAAAASUVORK5CYII\x3d";
cc._loaderImage = "data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAAlAAD/4QMpaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjAtYzA2MCA2MS4xMzQ3NzcsIDIwMTAvMDIvMTItMTc6MzI6MDAgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjM4MDBEMDY2QTU1MjExRTFBQTAzQjEzMUNFNzMxRkQwIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjM4MDBEMDY1QTU1MjExRTFBQTAzQjEzMUNFNzMxRkQwIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzUgV2luZG93cyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkU2RTk0OEM4OERCNDExRTE5NEUyRkE3M0M3QkE1NTlEIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU2RTk0OEM5OERCNDExRTE5NEUyRkE3M0M3QkE1NTlEIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+/+4ADkFkb2JlAGTAAAAAAf/bAIQADQkJCQoJDQoKDRMMCwwTFhENDREWGhUVFhUVGhkUFhUVFhQZGR0fIB8dGScnKionJzk4ODg5QEBAQEBAQEBAQAEODAwOEA4RDw8RFA4RDhQVERISERUfFRUXFRUfKB0ZGRkZHSgjJiAgICYjLCwoKCwsNzc1NzdAQEBAQEBAQEBA/8AAEQgAyACgAwEiAAIRAQMRAf/EALAAAAEFAQEAAAAAAAAAAAAAAAQAAgMFBgcBAQEAAwEBAAAAAAAAAAAAAAAAAQMEAgUQAAIBAgIEBwoLBgQGAwAAAAECAwAEEQUhMRIGQVFxsTITFGGBwdEiQlKSMzWRoeFicqKyI1NzFYJjJDQWB9KjVCbxwkNkJWXik3QRAAIBAgMFBQcDBQEAAAAAAAABAhEDIRIEMUFRcTJhwVIUBZGhsSJyEzOB0ULhYpIjUxX/2gAMAwEAAhEDEQA/AMJSpUqAVKlXuFAeUq9wpUB5XuFe4V6ooDzZHDox0CnGMinzwl7Z8NajaHeoO3vmTBZBtp9YUIqTEV5ROxHKnWRnaU8VRMhFBUjpV7hSoSeUq9pUB5Sr2lhQHlKvcK8oBV7hSFSRrtaKAZs07YNPM1pG2xJIAw1jSeandry/8X4m8VCKkWwaWwam7Xl/4v1W8VLtmX/i/VbxUoKkWwakSM407tmX/i/VbxUmzGwjQsjdY41IARie/U0IbZO0kNtCXnOCkEBeFu4KI3Bs7DNb27ya+jDx3kJeEnpJJEcQVbWDsk17u5urd591ucZkWhym2Vnd9RkCDEpFxDRpbw0bunu5mlp2De2FMLYXOD2wB2xbOeraUcYGJ72mlSUiqzzdzMd3Z3mixltA2yzcK/NlHM1DQyRXce1HocdNOEfJXZ88y9ZojOqhiBszIRiHQ8Y4cK5TvHuzLljHNMqxNoDjLFraHHnjPxcNCGVbxEUzYNTx5jZSxhpW6qTzlwJ+DCvO2Zf+L9VvFSgqyHYNLYNTdssPxfibxUu15f8Ai/VPiqCakOwa82DU/a8v/F+JvFTDdWPBL8R8VKCvYRYV5UzoMAy6QdIIqI0B4KJtxiRQwou16QoGUkntH5Tz0RbZbmF2hktraSVBo2lUkY8tDye0flPPXTslVUyiyVRsjqUOA4yMT8dW2ram2m6UVTNq9S7EIyUVJydMTn/6DnP+im9Wl+g5z/opvVrpteEhQWY4AaSTwAVf5WPiZh/9S5/zj7zltzlmYWkfWXNvJDGTgGcYDHirR7i7mSbwXParsFMrgb7w6jKw/wCmnc9I14kF3vpvCljbMyWMOJL4aEiB8qU/ObUK7HYWVrl1pFZWiCOCBQqKOLjPGTrNZZqKbUXVHq2nNwTuJRk1VpbgXN8s7Rk5ym0UQQzhIG2NAjhxHWbI+gCBVjBBFbwxwQqEiiUJGg1BVGAFe7dV28WYLYZFmF2Th1UD7JGjymGyn1iK5OyzIBGB1HgrLZhamzumQAGJwSqnSCh1q3GOCodxt4cxurdcpzuN4cyhiWaF5Bg09udUmnWw1H/jV9nFuJ7Quo+8h8peThFA+047vduyMtk7fYqTl07YFdfUufMPzT5p71UdtlmYXaGS2t3mQHAsgxANdadYJopLe4QS2867EsZ4QfCNYrCFbjdDPmgkYyWFxgVf04ifJf6ScNdRUW1XBb6FU5TjF5EpSSrGu/s5lN+g5z/opvVpfoOc/wCim9WtdHnatvObJXDW7xLGhB8nrPaY9/HCr+tEdPCVaSeDoYLnqF63lzW4/PFSW3ecxbI84VSzWUwUaSdg0DXXK5nvAipnd6qgKvWnQO7pri9ZUEmm3Vl2j1kr8pRlFRyquBNZjGxQ/S56Y1S2fu9OVueon11Szahoou06QoQUXadIVCD2FJJ7R+U89dMydv8Axdn+TH9muZye0flPPXQstlK5Tbka1gUjlC1q0vVLkeb6r+O3Tx9xcY1nt8c0NrZCyiOE1108NYjGv1joo7Js1jzKyScYLIvkzL6LDwHXVJksH9Sb49dKNq0tj1jA6uriOCL+02FWX7iVtZX1/AzaHTyeoauKn2MX9W79zebiZCuR5MjSrhfXuEtwTrUeZH+yNfdrRNcxI6IzhXlJEak6WIGJ2Rw4ChWnChndtlVBLMdQA0k1gbXNMzzDfDLs6mjaPKppJbWwJ1bOwwxw43OnHh71YT3DpfWUJmFlb5jHHDdeXBHIsrRea5TSqvxqG04cNN62vetoCS4tre5mgnkGE9q+3DKOkuI2WX6LDQRRHWDh1UCtwj7QRg2wdl8Djgw1qe7XvW0BQ3kfZ7mSLgU+T9E6RVbnuVrnWVSWqj+Lt8ZbRuHEdKPkYVcZ2MJY5fSGyeVar45+rkWQHAqccalPE5km1htWK5nK4Wnt5FuUBUwOMG4nGkA/BXUrW4S6torlOjMgcd/xVn7rLo7zKs0uEjCNeSvdwoBhgsZxX1l2j36k3Lu+uyprdj5Vs5A+i/lD48a0aaVJOPi7jB6lbzWozpjB48pf1NDXNN4vfl7+Z4BXS65pvF78vfzPAK71XTHmZ/S/yT+jvJ7L3fHytz1E+upbL+Qj5W56jfXWRnsIYKLtekKEFGWvSFQgyjk9o/Keet3YthlMP/5x9msJJ7R+U89biyb/AMXEv7gD6tadL1T+kwepRrC39ZkLDMbiwMvUHRPG0bjlGg8ore/23sxBldxfMPLupNhT8yL/AORNZbdzJ484scytxgLqJY5LZj6Q2sV5G1Vud1mjjyG0ij0NEGSZToKyhjtqw4waztuiXA3qKTbSxltfGhbZlE95ZtZqxVbgiOZhrER9ph3Svk9+pJILZ4Y4DGBFCUMKjRsGPobPFhUfW0NJmljE2xJcIrcI2vFUEln1lRXd6lrazXT9GCNpD+yNqoI7mOVduNw6nzlOIoPOUa6yye1XXcbMR5GdQ3xY0BSbj31/FcTQZirJ+q431q7anbHCTZ72Bw7lbPrKBMcBWNNgbMBBh+bsjBdni0VJ1lARZs6yWiupxCuMDy6KpS2IwOo6DTr3Mre3e5tZZVUM4ZBjqOOJoWO4jkXajcOOMHGgDISvWIrdAkKR80+TzVl908bPPL3LzxOuHdifxVfiTAg92qI/w+/8gGgSyN/mR7XPVlp0lF/3L3mbVKtu5Hjbk/8AHE2Fc03i9+Xv5ngFdKNc13i9+Xv5ngFaNV0x5nn+l/kn9HeEWXu+PlbnqJ9dS2Xu9OVueon11kZ7CGCjLXpCgxRlr0hUIPYUcntH5Tz1s8vb+Bt1/dqPirGSe0flPPWusG/g4Py15q06XqlyMWvVYQ+ruI9xJOqzO9hOto/sP8tbGOFIrmWeM7IuMDMnAXXQJOUjQeOsJk0nY96ip0CYunrjaHx1t+srPJUbXBm2LrFPikwTOb+T+VhbZxGMrDXp83x1QSy2tucJpUjPETp+Cn5/ftaRvKvtp3Kx48HG3erHMzOxZiWZtLMdJNQSbbL71Vk6yynViOkqnEEfOWtPbXi3EQkGg6mXiNckjeSJxJGxR10qw0GtxuxmvbImD4CZMFlA4fRfv0BqesqqzTMZNMEDbIHtHH2QeCiZJSqMQdOGiue53mz3czQwsRbIcNHnkec3c4qAMuriz68gTIToxwOOnlp0MjxMJYW741Gs3RVldtbygE/dMcHX/moDaxTiWNZB53B3arb8/wC+4SOF4sf/AKxU9kcBsfOGHfoUHtG/RbzY5Die5HHhXdvavqiZ9Q8Jdlq4/gbKua7xe/L38zwCuhpf2Uk/Zo50kmwJKIdogDjw1VzzeL35e/meAVp1LTgqY4nn+mRauzqmqwrjzCLL3fHytz1E+upLL+Qj5W56jfXWRnroYKLtekKEFF2vSFQg9hSSe0flPPWosm/hIfoLzVl5PaPynnrRWb/w0X0F5q06XqlyM2sVYx5gmbFre/t71NY2T+0h8VbSO5SWNJUOKSAMp7jDGspmMPaLRlXS6eWve1/FRO7WYdbZm1Y/eW/R7qHxHRXGojlm3ulid6aVbaW+OALvgCLq2Hm9WxHKWqjhj6xsK1e8dm15l4niG1LZkswGsxtrPeOmsvayBJA1VItlWjptLuTdPMo7LtjRDq9naK4+WF9IrUW7BaHOljGqVHB7w2hzVoZt87d8vaNYSLl02CcRsDEbJbj71Uu7UBkvJ7/D7q2QoDxySaAO8MTXdxRVMpRp5XZOWdF/ms7R5XdyKfKWJsO/5PhrG5XlNxmEywW6bTnTxAAcJNbGSMXkM1pjgbiNo1PziPJ+Os7u7m/6ReM00ZOgxSpqYYHT3wRXMKN4ll9zUG4bQfNshu8sZVuEA2hirA4qe/VOwwrVbzbww5mI44UKRRYkbWG0S3JWctbd7u5WFfOOLHiUdJqmaipfLsIsObhWe001lMkMVvJNjhghIALMcBxCs7fxXQmkupx1bXDswGPlaTidVaEyKNXkoo4eBV+Sq7L7Vs9zcBgeyQ4GQ/MB1crmoim2orezqcowTuSeEY48jQ7oZX2PLzdyLhNd6RjrEY6I7+uspvH78vfzPAK6UAAAFGAGgAcArmu8Xvy9/M8ArTfio24RW5nnaG67uou3H/KPuqT2X8hHytz1G+upLL3enK3PUb66ys9RDBRdr0hQgou06QqEGUkntH5Tz1e238vF9BeaqKT2j8p56vbb+Xi+gvNWjTdUuRn1XTHmTh8KrJTJlt8t1CPIY44cGnpJVjTJYkmjaN9Ib4u7V923njTethRauZJV3PaW1rfLIiXEDYg6R4VYc9CXW7thfOZbKdbGZtLW8uPVY/u3GrkNUkM9zlcxUjbhfWOA90cRq4gv4LhdqN+VToNYWmnRm9NNVWNTyHc6VWBv8wt4YeHqm6xyPmroq1Z7WGFLSxTq7WLSuPSdjrkfumq5yHXDUeA92oO2SKpVumNAaoJLMXH3myp0rpJ4uKhc3tbDM5BMri1zAj79j7KTiY8TcdBpcsith0286o+sPCagEX9Pzg4zXUCp6QYse8oouCG3tk6m1BYv05W6T+IdyolxbHDAAa2OgDlNCz3ryN2WxBd5PJMg1t81eId2ukqnLlTBbfcuY+9uJLiRcvtPvHdsHK+cfRHcHDWsyawjyy0WBcDI3lTP6TeIcFV+S5OmXx9bJg1048o8Cj0V8Jq2DVu09nL80up7OxHi+oal3P8AXB/IsZS8T/YOV65zvCcc7vfzPAK3ivWCz445zeH954BXOr6I8yfSfyz+jvCLP3fHytz1G+upLP3fHytz1E+usbPaQ0UXadIUIKLtekKhB7Ckk9o/Keer22/l4/oLzVRSe0flPPV7b/y8X0F5q0abqlyM+q6Y8yQsBTDMor1o8aiaE1pbluMqS3sbLLHIhSRQyngqukhaJ9uBjo+H5aOa3ao2t34qouRlLajTalGP8v0IY8ylXQ+PKPFU/bYXOLPge6CKia0LaxTOxHu1Q7cuBd9yPEJ7TbjXKO8CajbMIF6CNIeNvJHjqIWJ7tSpYkalqVblwIdyG+RGXur0hXYJFxal+Dhq5y3slkv3Y2pD0pTr+QUClpJRUdo9XW4OLrTHtM16cZLLWkeC7y4jvlNEpcRtw1Ux27Ci448NZrTFy3nn3IQWxlgGrDZ3pza7/M8ArZo+ArF5171uvp+CqdV0R5l/psUrs2vB3hdl7vTlbnqJ9dS2Xu+PlbnqJ9dY2eshooq16QoQUXa9IVCD2FLJ7RuU89WNtmUSQqkgYMgw0accKrpPaPynnrZWG4Vi+VWmY5tnMWXG+XrIYnA0rhj0mdcTgdNdwnKDqjmduM1SRR/qlr8/4KX6pa8T/BVzDuLZXudRZblmbxXcPUNPc3KqCIwrbOzgrHEnHjoyD+3eSXkht7DeKG4umDGOJVUklfouThXfmbnZ7Cvy1vt9pmv1W1+d8FL9VteJvgq5yrcOGfLmzHN80iyyETPbptAEFo2ZG8pmUa1OFNn3Ky6W/sbDKM5hv5bx2WTZA+7RF2y52WOPJTzE+z2Dy1vt9pT/AKpacTerS/U7Tib1a04/t7kDXPY03jhN0W6sQ7K7W3q2dnrMccaDy/8At80kuZfqWYxWNtlcvUPPhiGYhWDeUy7IwYU8xPs9g8tb7faUn6pacTerTxm9oOBvVq3v9z927aynuId44LiWKNnjhAXF2UYhRg516qpsryjLr21665zFLSTaK9U2GOA87SwqY37knRU+BzOzags0s1Oyr+BKM6sxwP6tSDPLMen6vy0rvdm3Sxlu7K/S7WDDrFUDUTxgnTU826eXW7KlxmqQuwDBXUKcD+1Xee/wXuKX5XDGWLapSVcOyhEM/seJ/V+WnjeGx4pPV+Wkm6kKZlFay3Jlt7iFpYZY8ASVK6DjtDDA0f8A0Tl340/1f8Ndx8xJVWXB0KbktFFpNzdVXAC/qOwA0CQni2flrO3Vwbm5lnI2TKxbDirX/wBE5d+NcfV/wVR7xZPa5U9utvI8nWhmbbw0YEAYYAVxfhfy5rlKR4Fulu6X7mW1mzT8S4Yis/5CPlbnqJ9dSWfu9OVueon11mZvQ2i7XpChKKtekKhBlNJ7R+U89bDfGTb3a3ZX0Lcj6kdY+T2j8p560288m1kWQr6MJ+ylSAr+2cnV5renjs3H1loX+3j9XvbbtxLN9lqW4UnV5jdnjtXHxihtyZNjeSBu5J9k1BJe7xy7W5CJ/wCzuD/mTVTf2+fq97LJuLrPsNRueS7W6aJ/38x+vLVXuY+xvHaNxbf2GoCezf8A36j/APsSf8w1sLnqczTefJluYoLm5uo5F61sBshItP1cNFYe1f8A3ir/APfE/wCZUe9bB94r5jwuPsrQFhmG4l/Z2M17HdW90tuu3IkTHaCjWdIw0VVZdks9/C06yJFEp2dp+E1bbqybGTZ8vpQD7L1XRv8A7blT96Oda7tpNuuNE37Cq9KSisjyuUoxrStKllHbLlWTXsMs8chuSuwEPDqwoLe5y+YRE/gLzmqRekvKKtd4327yM/ulHxmrHJStySWVRyrjxKI2XC/CTlnlPPKTpTdFbP0L1bgrf5Lp0G3dPhQHwV0S1lzBsns3sESR8Crh9WAJGjSOKuU3E+zdZQ3oJh8IArdZXFDmOTpHa3i2+YrI2KtKy4ricBsBuHHgFXSo440+Wa2qqxjvM9uMoy+WvzWpLCWWWE28HxL6e43ojgkeSCBY1Ri5BGIUDT51cl3vm276BBqSEH4WbxV0tlkyXJcxTMb+OW6uY9mGHrCzDQwwAbTp2uKuTZ9N1uYsfRRR8WPhrm419mSSjRyiqxVK7y23B/ftuTm2oSdJyzNVw3BFn7vTlbnqF9dS2fu9OVueon11lZuQ2iLdsGFD05H2dNQGV0ntG5Tz1dWm9N1b2kVq8EVwsI2UaQaQOKhmitZGLOmk68DhSFvY+gfWNSAg7z3Qvo7yKCKIohiaNR5LKxx8qpxvjcqS0VpbxvwOAcRQPZ7D0G9Y0uz2HoH1jUCpLY7zXlpbm3eKO5QuzjrBqZji3x17PvNcyT288VvDBJbMWUovS2hslW7mFQ9nsPQPrGl2ew9A+saCod/WNxtbYsrfb17WBxx5ddD2281xC88klvDcSXEnWuzrqOGGC9zRUPZ7D0G9Y0uzWHoH1jQVCLreq6ntZbaO3it1mGy7RjTs1X2mYy20ZiCq8ZOODcdEdmsPQb1jS7PYegfWNdJuLqnQiSUlRqpFLmryxtH1Ma7Qw2gNNPOdSt0oI27p007s9h6B9Y0uz2HoH1jXX3Z+I4+1b8IJdX89xLHKQFMXQUahpxoiPN5P+onfU+A0/s9h6DesaXZ7D0D6xpG7OLbUtu0StW5JJx2bBsmbtiSiEk+cxoCWWSaVpZOk2vDVo0VYdnsPQb1jSNvZcCH1jSd2c+p1XAmFqEOmOPEfaH+BQd1ueo211IzrgFUYKNAAqI1WztCpUqVCRUqVKgFSpUqAVKlSoBUqVKgFSpUqAVKlSoBUqVKgFSpUqAVKlSoD/9k\x3d";
var cc = cc || {}, ClassManager = {
    id: 0 | 998 * Math.random(),
    instanceId: 0 | 998 * Math.random(),
    getNewID: function () {
        return this.id++
    },
    getNewInstanceId: function () {
        return this.instanceId++
    }
};
(function () {
    var c = /\b_super\b/;
    cc.Class = function () {
    };
    cc.Class.extend = function (d) {
        function e() {
            this.__instanceId = ClassManager.getNewInstanceId();
            this.ctor && this.ctor.apply(this, arguments)
        }

        var f = this.prototype, g = Object.create(f), h = ClassManager.getNewID();
        ClassManager[h] = f;
        var k = {writable: !0, enumerable: !1, configurable: !0};
        g.__instanceId = null;
        e.id = h;
        k.value = h;
        Object.defineProperty(g, "__pid", k);
        e.prototype = g;
        k.value = e;
        Object.defineProperty(e.prototype, "constructor", k);
        this.__getters__ && (e.__getters__ =
            cc.clone(this.__getters__));
        this.__setters__ && (e.__setters__ = cc.clone(this.__setters__));
        for (var h = 0, m = arguments.length; h < m; ++h) {
            var n = arguments[h], p;
            for (p in n) {
                var r = "function" === typeof n[p], s = "function" === typeof f[p], v = c.test(n[p]);
                r && s && v ? (k.value = function (c, d) {
                    return function () {
                        var e = this._super;
                        this._super = f[c];
                        var g = d.apply(this, arguments);
                        this._super = e;
                        return g
                    }
                }(p, n[p]), Object.defineProperty(g, p, k)) : r ? (k.value = n[p], Object.defineProperty(g, p, k)) : g[p] = n[p];
                if (r) {
                    var t, w;
                    if (this.__getters__ &&
                        this.__getters__[p]) {
                        var r = this.__getters__[p], u;
                        for (u in this.__setters__)if (this.__setters__[u] === r) {
                            w = u;
                            break
                        }
                        cc.defineGetterSetter(g, r, n[p], n[w] ? n[w] : g[w], p, w)
                    }
                    if (this.__setters__ && this.__setters__[p]) {
                        r = this.__setters__[p];
                        for (u in this.__getters__)if (this.__getters__[u] === r) {
                            t = u;
                            break
                        }
                        cc.defineGetterSetter(g, r, n[t] ? n[t] : g[t], n[p], t, p)
                    }
                }
            }
        }
        e.extend = cc.Class.extend;
        e.implement = function (c) {
            for (var d in c)g[d] = c[d]
        };
        return e
    }
})();
cc.defineGetterSetter = function (c, d, e, f, g, h) {
    if (c.__defineGetter__)e && c.__defineGetter__(d, e), f && c.__defineSetter__(d, f); else if (Object.defineProperty) {
        var k = {enumerable: !1, configurable: !0};
        e && (k.get = e);
        f && (k.set = f);
        Object.defineProperty(c, d, k)
    } else throw Error("browser does not support getters");
    if (!g && !h)for (var k = null != e, m = void 0 != f, n = Object.getOwnPropertyNames(c), p = 0; p < n.length; p++) {
        var r = n[p];
        if ((c.__lookupGetter__ ? !c.__lookupGetter__(r) : !Object.getOwnPropertyDescriptor(c, r)) && "function" === typeof c[r]) {
            var s =
                c[r];
            if (k && s === e && (g = r, !m || h))break;
            if (m && s === f && (h = r, !k || g))break
        }
    }
    c = c.constructor;
    g && (c.__getters__ || (c.__getters__ = {}), c.__getters__[g] = d);
    h && (c.__setters__ || (c.__setters__ = {}), c.__setters__[h] = d)
};
cc.clone = function (c) {
    var d = c.constructor ? new c.constructor : {}, e;
    for (e in c) {
        var f = c[e];
        d[e] = "object" !== typeof f || !f || f instanceof cc.Node || f instanceof HTMLElement ? f : cc.clone(f)
    }
    return d
};
cc.inject = function (c, d) {
    for (var e in c)d[e] = c[e]
};
cc = cc || {};
cc._tmp = cc._tmp || {};
cc.associateWithNative = function (c, d) {
};
cc.KEY = {
    none: 0,
    back: 6,
    menu: 18,
    backspace: 8,
    tab: 9,
    enter: 13,
    shift: 16,
    ctrl: 17,
    alt: 18,
    pause: 19,
    capslock: 20,
    escape: 27,
    space: 32,
    pageup: 33,
    pagedown: 34,
    end: 35,
    home: 36,
    left: 37,
    up: 38,
    right: 39,
    down: 40,
    select: 41,
    insert: 45,
    Delete: 46,
    0: 48,
    1: 49,
    2: 50,
    3: 51,
    4: 52,
    5: 53,
    6: 54,
    7: 55,
    8: 56,
    9: 57,
    a: 65,
    b: 66,
    c: 67,
    d: 68,
    e: 69,
    f: 70,
    g: 71,
    h: 72,
    i: 73,
    j: 74,
    k: 75,
    l: 76,
    m: 77,
    n: 78,
    o: 79,
    p: 80,
    q: 81,
    r: 82,
    s: 83,
    t: 84,
    u: 85,
    v: 86,
    w: 87,
    x: 88,
    y: 89,
    z: 90,
    num0: 96,
    num1: 97,
    num2: 98,
    num3: 99,
    num4: 100,
    num5: 101,
    num6: 102,
    num7: 103,
    num8: 104,
    num9: 105,
    "*": 106,
    "+": 107,
    "-": 109,
    numdel: 110,
    "/": 111,
    f1: 112,
    f2: 113,
    f3: 114,
    f4: 115,
    f5: 116,
    f6: 117,
    f7: 118,
    f8: 119,
    f9: 120,
    f10: 121,
    f11: 122,
    f12: 123,
    numlock: 144,
    scrolllock: 145,
    ";": 186,
    semicolon: 186,
    equal: 187,
    "\x3d": 187,
    ",": 188,
    comma: 188,
    dash: 189,
    ".": 190,
    period: 190,
    forwardslash: 191,
    grave: 192,
    "[": 219,
    openbracket: 219,
    backslash: 220,
    "]": 221,
    closebracket: 221,
    quote: 222,
    dpadLeft: 1E3,
    dpadRight: 1001,
    dpadUp: 1003,
    dpadDown: 1004,
    dpadCenter: 1005
};
cc.FMT_JPG = 0;
cc.FMT_PNG = 1;
cc.FMT_TIFF = 2;
cc.FMT_RAWDATA = 3;
cc.FMT_WEBP = 4;
cc.FMT_UNKNOWN = 5;
cc.getImageFormatByData = function (c) {
    return 8 < c.length && 137 === c[0] && 80 === c[1] && 78 === c[2] && 71 === c[3] && 13 === c[4] && 10 === c[5] && 26 === c[6] && 10 === c[7] ? cc.FMT_PNG : 2 < c.length && (73 === c[0] && 73 === c[1] || 77 === c[0] && 77 === c[1] || 255 === c[0] && 216 === c[1]) ? cc.FMT_TIFF : cc.FMT_UNKNOWN
};
cc.inherits = function (c, d) {
    function e() {
    }

    e.prototype = d.prototype;
    c.superClass_ = d.prototype;
    c.prototype = new e;
    c.prototype.constructor = c
};
cc.base = function (c, d, e) {
    var f = arguments.callee.caller;
    if (f.superClass_)return ret = f.superClass_.constructor.apply(c, Array.prototype.slice.call(arguments, 1));
    for (var g = Array.prototype.slice.call(arguments, 2), h = !1, k = c.constructor; k; k = k.superClass_ && k.superClass_.constructor)if (k.prototype[d] === f)h = !0; else if (h)return k.prototype[d].apply(c, g);
    if (c[d] === f)return c.constructor.prototype[d].apply(c, g);
    throw Error("cc.base called from a method of one name to a method of a different name");
};
cc.Point = function (c, d) {
    this.x = c || 0;
    this.y = d || 0
};
cc.p = function (c, d) {
    return void 0 === c ? {x: 0, y: 0} : void 0 === d ? {x: c.x, y: c.y} : {x: c, y: d}
};
cc.pointEqualToPoint = function (c, d) {
    return c && d && c.x === d.x && c.y === d.y
};
cc.Size = function (c, d) {
    this.width = c || 0;
    this.height = d || 0
};
cc.size = function (c, d) {
    return void 0 === c ? {width: 0, height: 0} : void 0 === d ? {width: c.width, height: c.height} : {
        width: c,
        height: d
    }
};
cc.sizeEqualToSize = function (c, d) {
    return c && d && c.width === d.width && c.height === d.height
};
cc.Rect = function (c, d, e, f) {
    this.x = c || 0;
    this.y = d || 0;
    this.width = e || 0;
    this.height = f || 0
};
cc.rect = function (c, d, e, f) {
    return void 0 === c ? {x: 0, y: 0, width: 0, height: 0} : void 0 === d ? {
        x: c.x,
        y: c.y,
        width: c.width,
        height: c.height
    } : {x: c, y: d, width: e, height: f}
};
cc.rectEqualToRect = function (c, d) {
    return c && d && c.x === d.x && c.y === d.y && c.width === d.width && c.height === d.height
};
cc._rectEqualToZero = function (c) {
    return c && 0 === c.x && 0 === c.y && 0 === c.width && 0 === c.height
};
cc.rectContainsRect = function (c, d) {
    return c && d ? !(c.x >= d.x || c.y >= d.y || c.x + c.width <= d.x + d.width || c.y + c.height <= d.y + d.height) : !1
};
cc.rectGetMaxX = function (c) {
    return c.x + c.width
};
cc.rectGetMidX = function (c) {
    return c.x + c.width / 2
};
cc.rectGetMinX = function (c) {
    return c.x
};
cc.rectGetMaxY = function (c) {
    return c.y + c.height
};
cc.rectGetMidY = function (c) {
    return c.y + c.height / 2
};
cc.rectGetMinY = function (c) {
    return c.y
};
cc.rectContainsPoint = function (c, d) {
    return d.x >= cc.rectGetMinX(c) && d.x <= cc.rectGetMaxX(c) && d.y >= cc.rectGetMinY(c) && d.y <= cc.rectGetMaxY(c)
};
cc.rectIntersectsRect = function (c, d) {
    var e = c.y + c.height, f = d.x + d.width, g = d.y + d.height;
    return !(c.x + c.width < d.x || f < c.x || e < d.y || g < c.y)
};
cc.rectOverlapsRect = function (c, d) {
    return !(c.x + c.width < d.x || d.x + d.width < c.x || c.y + c.height < d.y || d.y + d.height < c.y)
};
cc.rectUnion = function (c, d) {
    var e = cc.rect(0, 0, 0, 0);
    e.x = Math.min(c.x, d.x);
    e.y = Math.min(c.y, d.y);
    e.width = Math.max(c.x + c.width, d.x + d.width) - e.x;
    e.height = Math.max(c.y + c.height, d.y + d.height) - e.y;
    return e
};
cc.rectIntersection = function (c, d) {
    var e = cc.rect(Math.max(cc.rectGetMinX(c), cc.rectGetMinX(d)), Math.max(cc.rectGetMinY(c), cc.rectGetMinY(d)), 0, 0);
    e.width = Math.min(cc.rectGetMaxX(c), cc.rectGetMaxX(d)) - cc.rectGetMinX(e);
    e.height = Math.min(cc.rectGetMaxY(c), cc.rectGetMaxY(d)) - cc.rectGetMinY(e);
    return e
};
cc.SAXParser = cc.Class.extend({
    _parser: null, _isSupportDOMParser: null, ctor: function () {
        window.DOMParser ? (this._isSupportDOMParser = !0, this._parser = new DOMParser) : this._isSupportDOMParser = !1
    }, parse: function (c) {
        return this._parseXML(c)
    }, _parseXML: function (c) {
        var d;
        this._isSupportDOMParser ? d = this._parser.parseFromString(c, "text/xml") : (d = new ActiveXObject("Microsoft.XMLDOM"), d.async = "false", d.loadXML(c));
        return d
    }
});
cc.PlistParser = cc.SAXParser.extend({
    parse: function (c) {
        c = this._parseXML(c).documentElement;
        if ("plist" !== c.tagName)return cc.warn("Not a plist file!"), {};
        for (var d = null, e = 0, f = c.childNodes.length; e < f && (d = c.childNodes[e], 1 !== d.nodeType); e++);
        return this._parseNode(d)
    }, _parseNode: function (c) {
        var d = null, e = c.tagName;
        if ("dict" === e)d = this._parseDict(c); else if ("array" === e)d = this._parseArray(c); else if ("string" === e)if (1 === c.childNodes.length)d = c.firstChild.nodeValue; else for (d = "", e = 0; e < c.childNodes.length; e++)d +=
            c.childNodes[e].nodeValue; else"false" === e ? d = !1 : "true" === e ? d = !0 : "real" === e ? d = parseFloat(c.firstChild.nodeValue) : "integer" === e && (d = parseInt(c.firstChild.nodeValue, 10));
        return d
    }, _parseArray: function (c) {
        for (var d = [], e = 0, f = c.childNodes.length; e < f; e++) {
            var g = c.childNodes[e];
            1 === g.nodeType && d.push(this._parseNode(g))
        }
        return d
    }, _parseDict: function (c) {
        for (var d = {}, e = null, f = 0, g = c.childNodes.length; f < g; f++) {
            var h = c.childNodes[f];
            1 === h.nodeType && ("key" === h.tagName ? e = h.firstChild.nodeValue : d[e] = this._parseNode(h))
        }
        return d
    }
});
cc.saxParser = new cc.SAXParser;
cc.plistParser = new cc.PlistParser;
cc._txtLoader = {
    load: function (c, d, e, f) {
        cc.loader.loadTxt(c, f)
    }
};
cc.loader.register(["txt", "xml", "vsh", "fsh", "atlas"], cc._txtLoader);
cc._jsonLoader = {
    load: function (c, d, e, f) {
        cc.loader.loadJson(c, f)
    }
};
cc.loader.register(["json", "ExportJson"], cc._jsonLoader);
cc._jsLoader = {
    load: function (c, d, e, f) {
        cc.loader.loadJs(c, f)
    }
};
cc.loader.register(["js"], cc._jsLoader);
cc._imgLoader = {
    load: function (c, d, e, f) {
        e = cc.loader.isLoading(c) ? f : function (c, e) {
            if (c)return f(c);
            cc.loader.cache[d] = e;
            cc.textureCache.handleLoadedTexture(d);
            f(null, e)
        };
        cc.loader.loadImg(c, e)
    }
};
cc.loader.register("png jpg bmp jpeg gif ico tiff webp".split(" "), cc._imgLoader);
cc._serverImgLoader = {
    load: function (c, d, e, f) {
        cc._imgLoader.load(e.src, d, e, f)
    }
};
cc.loader.register(["serverImg"], cc._serverImgLoader);
cc._plistLoader = {
    load: function (c, d, e, f) {
        cc.loader.loadTxt(c, function (c, d) {
            if (c)return f(c);
            f(null, cc.plistParser.parse(d))
        })
    }
};
cc.loader.register(["plist"], cc._plistLoader);
cc._fontLoader = {
    TYPE: {".eot": "embedded-opentype", ".ttf": "truetype", ".ttc": "truetype", ".woff": "woff", ".svg": "svg"},
    _loadFont: function (c, d, e) {
        var f = document, g = cc.path, h = this.TYPE, k = document.createElement("style");
        k.type = "text/css";
        f.body.appendChild(k);
        var m = "", m = isNaN(c - 0) ? m + ("@font-face { font-family:" + c + "; src:") : m + ("@font-face { font-family:'" + c + "'; src:");
        if (d instanceof Array)for (var n = 0, p = d.length; n < p; n++)e = g.extname(d[n]).toLowerCase(), m += "url('" + d[n] + "') format('" + h[e] + "')", m += n === p - 1 ? ";" :
            ","; else e = e.toLowerCase(), m += "url('" + d + "') format('" + h[e] + "');";
        k.textContent += m + "}";
        d = document.createElement("div");
        e = d.style;
        e.fontFamily = c;
        d.innerHTML = ".";
        e.position = "absolute";
        e.left = "-100px";
        e.top = "-100px";
        f.body.appendChild(d)
    },
    load: function (c, d, e, f) {
        d = e.type;
        c = e.name;
        d = e.srcs;
        cc.isString(e) ? (d = cc.path.extname(e), c = cc.path.basename(e, d), this._loadFont(c, e, d)) : this._loadFont(c, d);
        document.fonts ? document.fonts.load("1em " + c).then(function () {
            f(null, !0)
        }, function (c) {
            f(c)
        }) : f(null, !0)
    }
};
cc.loader.register("font eot ttf woff svg ttc".split(" "), cc._fontLoader);
cc._binaryLoader = {
    load: function (c, d, e, f) {
        cc.loader.loadBinary(c, f)
    }
};
cc._csbLoader = {
    load: function (c, d, e, f) {
        cc.loader.loadCsb(c, f)
    }
};
cc.loader.register(["csb"], cc._csbLoader);
window.CocosEngine = cc.ENGINE_VERSION = "Cocos2d-JS v3.12";
cc.FIX_ARTIFACTS_BY_STRECHING_TEXEL = 0;
cc.DIRECTOR_STATS_POSITION = cc.p(0, 0);
cc.DIRECTOR_FPS_INTERVAL = 0.5;
cc.COCOSNODE_RENDER_SUBPIXEL = 1;
cc.SPRITEBATCHNODE_RENDER_SUBPIXEL = 1;
cc.OPTIMIZE_BLEND_FUNC_FOR_PREMULTIPLIED_ALPHA = 1;
cc.TEXTURE_ATLAS_USE_TRIANGLE_STRIP = 0;
cc.TEXTURE_ATLAS_USE_VAO = 0;
cc.TEXTURE_NPOT_SUPPORT = 0;
cc.RETINA_DISPLAY_SUPPORT = 1;
cc.RETINA_DISPLAY_FILENAME_SUFFIX = "-hd";
cc.USE_LA88_LABELS = 1;
cc.SPRITE_DEBUG_DRAW = 0;
cc.SPRITEBATCHNODE_DEBUG_DRAW = 0;
cc.LABELBMFONT_DEBUG_DRAW = 0;
cc.LABELATLAS_DEBUG_DRAW = 0;
cc.IS_RETINA_DISPLAY_SUPPORTED = 1;
cc.DEFAULT_ENGINE = cc.ENGINE_VERSION + "-canvas";
cc.ENABLE_STACKABLE_ACTIONS = 1;
cc.ENABLE_GL_STATE_CACHE = 1;
cc.$ = function (c) {
    var d = this === cc ? document : this;
    if (c = c instanceof HTMLElement ? c : d.querySelector(c))c.find = c.find || cc.$, c.hasClass = c.hasClass || function (c) {
            return this.className.match(RegExp("(\\s|^)" + c + "(\\s|$)"))
        }, c.addClass = c.addClass || function (c) {
            this.hasClass(c) || (this.className && (this.className += " "), this.className += c);
            return this
        }, c.removeClass = c.removeClass || function (c) {
            this.hasClass(c) && (this.className = this.className.replace(c, ""));
            return this
        }, c.remove = c.remove || function () {
            this.parentNode &&
            this.parentNode.removeChild(this);
            return this
        }, c.appendTo = c.appendTo || function (c) {
            c.appendChild(this);
            return this
        }, c.prependTo = c.prependTo || function (c) {
            c.childNodes[0] ? c.insertBefore(this, c.childNodes[0]) : c.appendChild(this);
            return this
        }, c.transforms = c.transforms || function () {
            this.style[cc.$.trans] = cc.$.translate(this.position) + cc.$.rotate(this.rotation) + cc.$.scale(this.scale) + cc.$.skew(this.skew);
            return this
        }, c.position = c.position || {x: 0, y: 0}, c.rotation = c.rotation || 0, c.scale = c.scale || {
            x: 1,
            y: 1
        }, c.skew =
        c.skew || {x: 0, y: 0}, c.translates = function (c, d) {
        this.position.x = c;
        this.position.y = d;
        this.transforms();
        return this
    }, c.rotate = function (c) {
        this.rotation = c;
        this.transforms();
        return this
    }, c.resize = function (c, d) {
        this.scale.x = c;
        this.scale.y = d;
        this.transforms();
        return this
    }, c.setSkew = function (c, d) {
        this.skew.x = c;
        this.skew.y = d;
        this.transforms();
        return this
    };
    return c
};
switch (cc.sys.browserType) {
    case cc.sys.BROWSER_TYPE_FIREFOX:
        cc.$.pfx = "Moz";
        cc.$.hd = !0;
        break;
    case cc.sys.BROWSER_TYPE_CHROME:
    case cc.sys.BROWSER_TYPE_SAFARI:
        cc.$.pfx = "webkit";
        cc.$.hd = !0;
        break;
    case cc.sys.BROWSER_TYPE_OPERA:
        cc.$.pfx = "O";
        cc.$.hd = !1;
        break;
    case cc.sys.BROWSER_TYPE_IE:
        cc.$.pfx = "ms";
        cc.$.hd = !1;
        break;
    default:
        cc.$.pfx = "webkit", cc.$.hd = !0
}
cc.$.trans = cc.$.pfx + "Transform";
cc.$.translate = cc.$.hd ? function (c) {
    return "translate3d(" + c.x + "px, " + c.y + "px, 0) "
} : function (c) {
    return "translate(" + c.x + "px, " + c.y + "px) "
};
cc.$.rotate = cc.$.hd ? function (c) {
    return "rotateZ(" + c + "deg) "
} : function (c) {
    return "rotate(" + c + "deg) "
};
cc.$.scale = function (c) {
    return "scale(" + c.x + ", " + c.y + ") "
};
cc.$.skew = function (c) {
    return "skewX(" + -c.x + "deg) skewY(" + c.y + "deg)"
};
cc.$new = function (c) {
    return cc.$(document.createElement(c))
};
cc.$.findpos = function (c) {
    var d = 0, e = 0;
    do d += c.offsetLeft, e += c.offsetTop; while (c = c.offsetParent);
    return {x: d, y: e}
};
cc.INVALID_INDEX = -1;
cc.PI = Math.PI;
cc.FLT_MAX = parseFloat("3.402823466e+38F");
cc.FLT_MIN = parseFloat("1.175494351e-38F");
cc.RAD = cc.PI / 180;
cc.DEG = 180 / cc.PI;
cc.UINT_MAX = 4294967295;
cc.swap = function (c, d, e) {
    if (!cc.isObject(e) || cc.isUndefined(e.x) || cc.isUndefined(e.y))cc.log(cc._LogInfos.swap); else {
        var f = e[c];
        e[c] = e[d];
        e[d] = f
    }
};
cc.lerp = function (c, d, e) {
    return c + (d - c) * e
};
cc.rand = function () {
    return 16777215 * Math.random()
};
cc.randomMinus1To1 = function () {
    return 2 * (Math.random() - 0.5)
};
cc.random0To1 = Math.random;
cc.degreesToRadians = function (c) {
    return c * cc.RAD
};
cc.radiansToDegrees = function (c) {
    return c * cc.DEG
};
cc.radiansToDegress = function (c) {
    cc.log(cc._LogInfos.radiansToDegress);
    return c * cc.DEG
};
cc.REPEAT_FOREVER = Number.MAX_VALUE - 1;
cc.nodeDrawSetup = function (c) {
    c._shaderProgram && (c._shaderProgram.use(), c._shaderProgram.setUniformForModelViewAndProjectionMatrixWithMat4())
};
cc.enableDefaultGLStates = function () {
};
cc.disableDefaultGLStates = function () {
};
cc.incrementGLDraws = function (c) {
    cc.g_NumberOfDraws += c
};
cc.FLT_EPSILON = 1.192092896E-7;
cc.contentScaleFactor = cc.IS_RETINA_DISPLAY_SUPPORTED ? function () {
    return cc.director.getContentScaleFactor()
} : function () {
    return 1
};
cc.pointPointsToPixels = function (c) {
    var d = cc.contentScaleFactor();
    return cc.p(c.x * d, c.y * d)
};
cc.pointPixelsToPoints = function (c) {
    var d = cc.contentScaleFactor();
    return cc.p(c.x / d, c.y / d)
};
cc._pointPixelsToPointsOut = function (c, d) {
    var e = cc.contentScaleFactor();
    d.x = c.x / e;
    d.y = c.y / e
};
cc.sizePointsToPixels = function (c) {
    var d = cc.contentScaleFactor();
    return cc.size(c.width * d, c.height * d)
};
cc.sizePixelsToPoints = function (c) {
    var d = cc.contentScaleFactor();
    return cc.size(c.width / d, c.height / d)
};
cc._sizePixelsToPointsOut = function (c, d) {
    var e = cc.contentScaleFactor();
    d.width = c.width / e;
    d.height = c.height / e
};
cc.rectPixelsToPoints = cc.IS_RETINA_DISPLAY_SUPPORTED ? function (c) {
    var d = cc.contentScaleFactor();
    return cc.rect(c.x / d, c.y / d, c.width / d, c.height / d)
} : function (c) {
    return c
};
cc.rectPointsToPixels = cc.IS_RETINA_DISPLAY_SUPPORTED ? function (c) {
    var d = cc.contentScaleFactor();
    return cc.rect(c.x * d, c.y * d, c.width * d, c.height * d)
} : function (c) {
    return c
};
cc.ONE = 1;
cc.ZERO = 0;
cc.SRC_ALPHA = 770;
cc.SRC_ALPHA_SATURATE = 776;
cc.SRC_COLOR = 768;
cc.DST_ALPHA = 772;
cc.DST_COLOR = 774;
cc.ONE_MINUS_SRC_ALPHA = 771;
cc.ONE_MINUS_SRC_COLOR = 769;
cc.ONE_MINUS_DST_ALPHA = 773;
cc.ONE_MINUS_DST_COLOR = 775;
cc.ONE_MINUS_CONSTANT_ALPHA = 32772;
cc.ONE_MINUS_CONSTANT_COLOR = 32770;
cc.LINEAR = 9729;
cc.REPEAT = 10497;
cc.CLAMP_TO_EDGE = 33071;
cc.MIRRORED_REPEAT = 33648;
cc.BLEND_SRC = cc.SRC_ALPHA;
cc.game.addEventListener(cc.game.EVENT_RENDERER_INITED, function () {
    cc._renderType === cc.game.RENDER_TYPE_WEBGL && cc.OPTIMIZE_BLEND_FUNC_FOR_PREMULTIPLIED_ALPHA && (cc.BLEND_SRC = cc.ONE)
});
cc.BLEND_DST = cc.ONE_MINUS_SRC_ALPHA;
cc.checkGLErrorDebug = function () {
    if (cc.renderMode === cc.game.RENDER_TYPE_WEBGL) {
        var c = cc._renderContext.getError();
        c && cc.log(cc._LogInfos.checkGLErrorDebug, c)
    }
};
cc.ORIENTATION_PORTRAIT = 1;
cc.ORIENTATION_LANDSCAPE = 2;
cc.ORIENTATION_AUTO = 3;
cc.VERTEX_ATTRIB_FLAG_NONE = 0;
cc.VERTEX_ATTRIB_FLAG_POSITION = 1;
cc.VERTEX_ATTRIB_FLAG_COLOR = 2;
cc.VERTEX_ATTRIB_FLAG_TEX_COORDS = 4;
cc.VERTEX_ATTRIB_FLAG_POS_COLOR_TEX = cc.VERTEX_ATTRIB_FLAG_POSITION | cc.VERTEX_ATTRIB_FLAG_COLOR | cc.VERTEX_ATTRIB_FLAG_TEX_COORDS;
cc.GL_ALL = 0;
cc.VERTEX_ATTRIB_POSITION = 0;
cc.VERTEX_ATTRIB_COLOR = 1;
cc.VERTEX_ATTRIB_TEX_COORDS = 2;
cc.VERTEX_ATTRIB_MAX = 7;
cc.UNIFORM_PMATRIX = 0;
cc.UNIFORM_MVMATRIX = 1;
cc.UNIFORM_MVPMATRIX = 2;
cc.UNIFORM_TIME = 3;
cc.UNIFORM_SINTIME = 4;
cc.UNIFORM_COSTIME = 5;
cc.UNIFORM_RANDOM01 = 6;
cc.UNIFORM_SAMPLER = 7;
cc.UNIFORM_MAX = 8;
cc.SHADER_POSITION_TEXTURECOLOR = "ShaderPositionTextureColor";
cc.SHADER_SPRITE_POSITION_TEXTURECOLOR = "ShaderSpritePositionTextureColor";
cc.SHADER_POSITION_TEXTURECOLORALPHATEST = "ShaderPositionTextureColorAlphaTest";
cc.SHADER_SPRITE_POSITION_TEXTURECOLORALPHATEST = "ShaderSpritePositionTextureColorAlphaTest";
cc.SHADER_POSITION_COLOR = "ShaderPositionColor";
cc.SHADER_SPRITE_POSITION_COLOR = "ShaderSpritePositionColor";
cc.SHADER_POSITION_TEXTURE = "ShaderPositionTexture";
cc.SHADER_POSITION_TEXTURE_UCOLOR = "ShaderPositionTexture_uColor";
cc.SHADER_POSITION_TEXTUREA8COLOR = "ShaderPositionTextureA8Color";
cc.SHADER_POSITION_UCOLOR = "ShaderPosition_uColor";
cc.SHADER_POSITION_LENGTHTEXTURECOLOR = "ShaderPositionLengthTextureColor";
cc.UNIFORM_PMATRIX_S = "CC_PMatrix";
cc.UNIFORM_MVMATRIX_S = "CC_MVMatrix";
cc.UNIFORM_MVPMATRIX_S = "CC_MVPMatrix";
cc.UNIFORM_TIME_S = "CC_Time";
cc.UNIFORM_SINTIME_S = "CC_SinTime";
cc.UNIFORM_COSTIME_S = "CC_CosTime";
cc.UNIFORM_RANDOM01_S = "CC_Random01";
cc.UNIFORM_SAMPLER_S = "CC_Texture0";
cc.UNIFORM_ALPHA_TEST_VALUE_S = "CC_alpha_value";
cc.ATTRIBUTE_NAME_COLOR = "a_color";
cc.ATTRIBUTE_NAME_POSITION = "a_position";
cc.ATTRIBUTE_NAME_TEX_COORD = "a_texCoord";
cc.ATTRIBUTE_NAME_MVMAT = "a_mvMatrix";
cc.ITEM_SIZE = 32;
cc.CURRENT_ITEM = 3233828865;
cc.ZOOM_ACTION_TAG = 3233828866;
cc.NORMAL_TAG = 8801;
cc.SELECTED_TAG = 8802;
cc.DISABLE_TAG = 8803;
cc.arrayVerifyType = function (c, d) {
    if (c && 0 < c.length)for (var e = 0; e < c.length; e++)if (!(c[e] instanceof d))return cc.log("element type is wrong!"), !1;
    return !0
};
cc.arrayRemoveObject = function (c, d) {
    for (var e = 0, f = c.length; e < f; e++)if (c[e] === d) {
        c.splice(e, 1);
        break
    }
};
cc.arrayRemoveArray = function (c, d) {
    for (var e = 0, f = d.length; e < f; e++)cc.arrayRemoveObject(c, d[e])
};
cc.arrayAppendObjectsToIndex = function (c, d, e) {
    c.splice.apply(c, [e, 0].concat(d));
    return c
};
cc.copyArray = function (c) {
    var d, e = c.length, f = Array(e);
    for (d = 0; d < e; d += 1)f[d] = c[d];
    return f
};
cc = cc || {};
cc._tmp = cc._tmp || {};
cc.game.addEventListener(cc.game.EVENT_RENDERER_INITED, function () {
    if (cc._renderType === cc.game.RENDER_TYPE_WEBGL) {
        cc.color = function (c, e, f, g, h, k) {
            return void 0 === c ? new cc.Color(0, 0, 0, 255, h, k) : cc.isString(c) ? (c = cc.hexToColor(c), new cc.Color(c.r, c.g, c.b, c.a)) : cc.isObject(c) ? new cc.Color(c.r, c.g, c.b, c.a, c.arrayBuffer, c.offset) : new cc.Color(c, e, f, g, h, k)
        };
        cc.Color = function (c, e, f, g, h, k) {
            this._arrayBuffer = h || new ArrayBuffer(cc.Color.BYTES_PER_ELEMENT);
            this._offset = k || 0;
            this._view = new Uint8Array(this._arrayBuffer,
                this._offset, 4);
            this._view[0] = c || 0;
            this._view[1] = e || 0;
            this._view[2] = f || 0;
            this._view[3] = null == g ? 255 : g;
            void 0 === g && (this.a_undefined = !0)
        };
        cc.Color.BYTES_PER_ELEMENT = 4;
        var c = cc.Color.prototype;
        c._getR = function () {
            return this._view[0]
        };
        c._setR = function (c) {
            this._view[0] = 0 > c ? 0 : c
        };
        c._getG = function () {
            return this._view[1]
        };
        c._setG = function (c) {
            this._view[1] = 0 > c ? 0 : c
        };
        c._getB = function () {
            return this._view[2]
        };
        c._setB = function (c) {
            this._view[2] = 0 > c ? 0 : c
        };
        c._getA = function () {
            return this._view[3]
        };
        c._setA = function (c) {
            this._view[3] =
                0 > c ? 0 : c
        };
        cc.defineGetterSetter(c, "r", c._getR, c._setR);
        cc.defineGetterSetter(c, "g", c._getG, c._setG);
        cc.defineGetterSetter(c, "b", c._getB, c._setB);
        cc.defineGetterSetter(c, "a", c._getA, c._setA);
        cc.assert(cc.isFunction(cc._tmp.PrototypeColor), cc._LogInfos.MissingFile, "CCTypesPropertyDefine.js");
        cc._tmp.PrototypeColor();
        delete cc._tmp.PrototypeColor
    }
});
cc._tmp.PrototypeColor = function () {
    var c = cc.color;
    c._getWhite = function () {
        return c(255, 255, 255)
    };
    c._getYellow = function () {
        return c(255, 255, 0)
    };
    c._getBlue = function () {
        return c(0, 0, 255)
    };
    c._getGreen = function () {
        return c(0, 255, 0)
    };
    c._getRed = function () {
        return c(255, 0, 0)
    };
    c._getMagenta = function () {
        return c(255, 0, 255)
    };
    c._getBlack = function () {
        return c(0, 0, 0)
    };
    c._getOrange = function () {
        return c(255, 127, 0)
    };
    c._getGray = function () {
        return c(166, 166, 166)
    };
    cc.defineGetterSetter(c, "WHITE", c._getWhite);
    cc.defineGetterSetter(c,
        "YELLOW", c._getYellow);
    cc.defineGetterSetter(c, "BLUE", c._getBlue);
    cc.defineGetterSetter(c, "GREEN", c._getGreen);
    cc.defineGetterSetter(c, "RED", c._getRed);
    cc.defineGetterSetter(c, "MAGENTA", c._getMagenta);
    cc.defineGetterSetter(c, "BLACK", c._getBlack);
    cc.defineGetterSetter(c, "ORANGE", c._getOrange);
    cc.defineGetterSetter(c, "GRAY", c._getGray);
    cc.BlendFunc._disable = function () {
        return new cc.BlendFunc(cc.ONE, cc.ZERO)
    };
    cc.BlendFunc._alphaPremultiplied = function () {
        return new cc.BlendFunc(cc.ONE, cc.ONE_MINUS_SRC_ALPHA)
    };
    cc.BlendFunc._alphaNonPremultiplied = function () {
        return new cc.BlendFunc(cc.SRC_ALPHA, cc.ONE_MINUS_SRC_ALPHA)
    };
    cc.BlendFunc._additive = function () {
        return new cc.BlendFunc(cc.SRC_ALPHA, cc.ONE)
    };
    cc.defineGetterSetter(cc.BlendFunc, "DISABLE", cc.BlendFunc._disable);
    cc.defineGetterSetter(cc.BlendFunc, "ALPHA_PREMULTIPLIED", cc.BlendFunc._alphaPremultiplied);
    cc.defineGetterSetter(cc.BlendFunc, "ALPHA_NON_PREMULTIPLIED", cc.BlendFunc._alphaNonPremultiplied);
    cc.defineGetterSetter(cc.BlendFunc, "ADDITIVE", cc.BlendFunc._additive)
};
cc.Color = function (c, d, e, f) {
    this.r = c || 0;
    this.g = d || 0;
    this.b = e || 0;
    this.a = null == f ? 255 : f
};
cc.color = function (c, d, e, f) {
    return void 0 === c ? {r: 0, g: 0, b: 0, a: 255} : cc.isString(c) ? cc.hexToColor(c) : cc.isObject(c) ? {
        r: c.r,
        g: c.g,
        b: c.b,
        a: null == c.a ? 255 : c.a
    } : {r: c, g: d, b: e, a: null == f ? 255 : f}
};
cc.colorEqual = function (c, d) {
    return c.r === d.r && c.g === d.g && c.b === d.b
};
cc.Acceleration = function (c, d, e, f) {
    this.x = c || 0;
    this.y = d || 0;
    this.z = e || 0;
    this.timestamp = f || 0
};
cc.Vertex2F = function (c, d, e, f) {
    this._arrayBuffer = e || new ArrayBuffer(cc.Vertex2F.BYTES_PER_ELEMENT);
    this._offset = f || 0;
    this._view = new Float32Array(this._arrayBuffer, this._offset, 2);
    this._view[0] = c || 0;
    this._view[1] = d || 0
};
cc.Vertex2F.BYTES_PER_ELEMENT = 8;
_p = cc.Vertex2F.prototype;
_p._getX = function () {
    return this._view[0]
};
_p._setX = function (c) {
    this._view[0] = c
};
_p._getY = function () {
    return this._view[1]
};
_p._setY = function (c) {
    this._view[1] = c
};
cc.defineGetterSetter(_p, "x", _p._getX, _p._setX);
cc.defineGetterSetter(_p, "y", _p._getY, _p._setY);
cc.Vertex3F = function (c, d, e, f, g) {
    this._arrayBuffer = f || new ArrayBuffer(cc.Vertex3F.BYTES_PER_ELEMENT);
    this._offset = g || 0;
    this._view = new Float32Array(this._arrayBuffer, this._offset, 3);
    this._view[0] = c || 0;
    this._view[1] = d || 0;
    this._view[2] = e || 0
};
cc.Vertex3F.BYTES_PER_ELEMENT = 12;
_p = cc.Vertex3F.prototype;
_p._getX = function () {
    return this._view[0]
};
_p._setX = function (c) {
    this._view[0] = c
};
_p._getY = function () {
    return this._view[1]
};
_p._setY = function (c) {
    this._view[1] = c
};
_p._getZ = function () {
    return this._view[2]
};
_p._setZ = function (c) {
    this._view[2] = c
};
cc.defineGetterSetter(_p, "x", _p._getX, _p._setX);
cc.defineGetterSetter(_p, "y", _p._getY, _p._setY);
cc.defineGetterSetter(_p, "z", _p._getZ, _p._setZ);
cc.Tex2F = function (c, d, e, f) {
    this._arrayBuffer = e || new ArrayBuffer(cc.Tex2F.BYTES_PER_ELEMENT);
    this._offset = f || 0;
    this._view = new Float32Array(this._arrayBuffer, this._offset, 2);
    this._view[0] = c || 0;
    this._view[1] = d || 0
};
cc.Tex2F.BYTES_PER_ELEMENT = 8;
_p = cc.Tex2F.prototype;
_p._getU = function () {
    return this._view[0]
};
_p._setU = function (c) {
    this._view[0] = c
};
_p._getV = function () {
    return this._view[1]
};
_p._setV = function (c) {
    this._view[1] = c
};
cc.defineGetterSetter(_p, "u", _p._getU, _p._setU);
cc.defineGetterSetter(_p, "v", _p._getV, _p._setV);
cc.Quad2 = function (c, d, e, f, g, h) {
    this._arrayBuffer = g || new ArrayBuffer(cc.Quad2.BYTES_PER_ELEMENT);
    this._offset = h || 0;
    g = this._arrayBuffer;
    h = this._offset;
    var k = cc.Vertex2F.BYTES_PER_ELEMENT;
    this._tl = c ? new cc.Vertex2F(c.x, c.y, g, h) : new cc.Vertex2F(0, 0, g, h);
    h += k;
    this._tr = d ? new cc.Vertex2F(d.x, d.y, g, h) : new cc.Vertex2F(0, 0, g, h);
    h += k;
    this._bl = e ? new cc.Vertex2F(e.x, e.y, g, h) : new cc.Vertex2F(0, 0, g, h);
    h += k;
    this._br = f ? new cc.Vertex2F(f.x, f.y, g, h) : new cc.Vertex2F(0, 0, g, h)
};
cc.Quad2.BYTES_PER_ELEMENT = 32;
_p = cc.Quad2.prototype;
_p._getTL = function () {
    return this._tl
};
_p._setTL = function (c) {
    this._tl._view[0] = c.x;
    this._tl._view[1] = c.y
};
_p._getTR = function () {
    return this._tr
};
_p._setTR = function (c) {
    this._tr._view[0] = c.x;
    this._tr._view[1] = c.y
};
_p._getBL = function () {
    return this._bl
};
_p._setBL = function (c) {
    this._bl._view[0] = c.x;
    this._bl._view[1] = c.y
};
_p._getBR = function () {
    return this._br
};
_p._setBR = function (c) {
    this._br._view[0] = c.x;
    this._br._view[1] = c.y
};
cc.defineGetterSetter(_p, "tl", _p._getTL, _p._setTL);
cc.defineGetterSetter(_p, "tr", _p._getTR, _p._setTR);
cc.defineGetterSetter(_p, "bl", _p._getBL, _p._setBL);
cc.defineGetterSetter(_p, "br", _p._getBR, _p._setBR);
cc.Quad3 = function (c, d, e, f, g, h) {
    this._arrayBuffer = g || new ArrayBuffer(cc.Quad3.BYTES_PER_ELEMENT);
    this._offset = h || 0;
    g = this._arrayBuffer;
    h = this._offset;
    var k = cc.Vertex3F.BYTES_PER_ELEMENT;
    this.bl = c ? new cc.Vertex3F(c.x, c.y, c.z, g, h) : new cc.Vertex3F(0, 0, 0, g, h);
    h += k;
    this.br = d ? new cc.Vertex3F(d.x, d.y, d.z, g, h) : new cc.Vertex3F(0, 0, 0, g, h);
    h += k;
    this.tl = e ? new cc.Vertex3F(e.x, e.y, e.z, g, h) : new cc.Vertex3F(0, 0, 0, g, h);
    h += k;
    this.tr = f ? new cc.Vertex3F(f.x, f.y, f.z, g, h) : new cc.Vertex3F(0, 0, 0, g, h)
};
cc.Quad3.BYTES_PER_ELEMENT = 48;
cc.V3F_C4B_T2F = function (c, d, e, f, g) {
    this._arrayBuffer = f || new ArrayBuffer(cc.V3F_C4B_T2F.BYTES_PER_ELEMENT);
    this._offset = g || 0;
    f = this._arrayBuffer;
    g = this._offset;
    this._vertices = c ? new cc.Vertex3F(c.x, c.y, c.z, f, g) : new cc.Vertex3F(0, 0, 0, f, g);
    g += cc.Vertex3F.BYTES_PER_ELEMENT;
    this._colors = d ? cc.color(d.r, d.g, d.b, d.a, f, g) : cc.color(0, 0, 0, 0, f, g);
    g += cc.Color.BYTES_PER_ELEMENT;
    this._texCoords = e ? new cc.Tex2F(e.u, e.v, f, g) : new cc.Tex2F(0, 0, f, g)
};
cc.V3F_C4B_T2F.BYTES_PER_ELEMENT = 24;
_p = cc.V3F_C4B_T2F.prototype;
_p._getVertices = function () {
    return this._vertices
};
_p._setVertices = function (c) {
    var d = this._vertices;
    d._view[0] = c.x;
    d._view[1] = c.y;
    d._view[2] = c.z
};
_p._getColor = function () {
    return this._colors
};
_p._setColor = function (c) {
    var d = this._colors;
    d._view[0] = c.r;
    d._view[1] = c.g;
    d._view[2] = c.b;
    d._view[3] = c.a
};
_p._getTexCoords = function () {
    return this._texCoords
};
_p._setTexCoords = function (c) {
    this._texCoords._view[0] = c.u;
    this._texCoords._view[1] = c.v
};
cc.defineGetterSetter(_p, "vertices", _p._getVertices, _p._setVertices);
cc.defineGetterSetter(_p, "colors", _p._getColor, _p._setColor);
cc.defineGetterSetter(_p, "texCoords", _p._getTexCoords, _p._setTexCoords);
cc.V3F_C4B_T2F_Quad = function (c, d, e, f, g, h) {
    this._arrayBuffer = g || new ArrayBuffer(cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT);
    this._offset = h || 0;
    g = this._arrayBuffer;
    h = this._offset;
    var k = cc.V3F_C4B_T2F.BYTES_PER_ELEMENT;
    this._tl = c ? new cc.V3F_C4B_T2F(c.vertices, c.colors, c.texCoords, g, h) : new cc.V3F_C4B_T2F(null, null, null, g, h);
    h += k;
    this._bl = d ? new cc.V3F_C4B_T2F(d.vertices, d.colors, d.texCoords, g, h) : new cc.V3F_C4B_T2F(null, null, null, g, h);
    h += k;
    this._tr = e ? new cc.V3F_C4B_T2F(e.vertices, e.colors, e.texCoords, g, h) : new cc.V3F_C4B_T2F(null,
        null, null, g, h);
    h += k;
    this._br = f ? new cc.V3F_C4B_T2F(f.vertices, f.colors, f.texCoords, g, h) : new cc.V3F_C4B_T2F(null, null, null, g, h)
};
cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT = 96;
_p = cc.V3F_C4B_T2F_Quad.prototype;
_p._getTL = function () {
    return this._tl
};
_p._setTL = function (c) {
    var d = this._tl;
    d.vertices = c.vertices;
    d.colors = c.colors;
    d.texCoords = c.texCoords
};
_p._getBL = function () {
    return this._bl
};
_p._setBL = function (c) {
    var d = this._bl;
    d.vertices = c.vertices;
    d.colors = c.colors;
    d.texCoords = c.texCoords
};
_p._getTR = function () {
    return this._tr
};
_p._setTR = function (c) {
    var d = this._tr;
    d.vertices = c.vertices;
    d.colors = c.colors;
    d.texCoords = c.texCoords
};
_p._getBR = function () {
    return this._br
};
_p._setBR = function (c) {
    var d = this._br;
    d.vertices = c.vertices;
    d.colors = c.colors;
    d.texCoords = c.texCoords
};
_p._getArrayBuffer = function () {
    return this._arrayBuffer
};
cc.defineGetterSetter(_p, "tl", _p._getTL, _p._setTL);
cc.defineGetterSetter(_p, "tr", _p._getTR, _p._setTR);
cc.defineGetterSetter(_p, "bl", _p._getBL, _p._setBL);
cc.defineGetterSetter(_p, "br", _p._getBR, _p._setBR);
cc.defineGetterSetter(_p, "arrayBuffer", _p._getArrayBuffer, null);
cc.V3F_C4B_T2F_QuadZero = function () {
    return new cc.V3F_C4B_T2F_Quad
};
cc.V3F_C4B_T2F_QuadCopy = function (c) {
    if (!c)return cc.V3F_C4B_T2F_QuadZero();
    var d = c.tl, e = c.bl, f = c.tr;
    c = c.br;
    return {
        tl: {
            vertices: {x: d.vertices.x, y: d.vertices.y, z: d.vertices.z},
            colors: {r: d.colors.r, g: d.colors.g, b: d.colors.b, a: d.colors.a},
            texCoords: {u: d.texCoords.u, v: d.texCoords.v}
        },
        bl: {
            vertices: {x: e.vertices.x, y: e.vertices.y, z: e.vertices.z},
            colors: {r: e.colors.r, g: e.colors.g, b: e.colors.b, a: e.colors.a},
            texCoords: {u: e.texCoords.u, v: e.texCoords.v}
        },
        tr: {
            vertices: {x: f.vertices.x, y: f.vertices.y, z: f.vertices.z},
            colors: {r: f.colors.r, g: f.colors.g, b: f.colors.b, a: f.colors.a},
            texCoords: {u: f.texCoords.u, v: f.texCoords.v}
        },
        br: {
            vertices: {x: c.vertices.x, y: c.vertices.y, z: c.vertices.z},
            colors: {r: c.colors.r, g: c.colors.g, b: c.colors.b, a: c.colors.a},
            texCoords: {u: c.texCoords.u, v: c.texCoords.v}
        }
    }
};
cc.V3F_C4B_T2F_QuadsCopy = function (c) {
    if (!c)return [];
    for (var d = [], e = 0; e < c.length; e++)d.push(cc.V3F_C4B_T2F_QuadCopy(c[e]));
    return d
};
cc.V2F_C4B_T2F = function (c, d, e, f, g) {
    this._arrayBuffer = f || new ArrayBuffer(cc.V2F_C4B_T2F.BYTES_PER_ELEMENT);
    this._offset = g || 0;
    f = this._arrayBuffer;
    g = this._offset;
    this._vertices = c ? new cc.Vertex2F(c.x, c.y, f, g) : new cc.Vertex2F(0, 0, f, g);
    g += cc.Vertex2F.BYTES_PER_ELEMENT;
    this._colors = d ? cc.color(d.r, d.g, d.b, d.a, f, g) : cc.color(0, 0, 0, 0, f, g);
    g += cc.Color.BYTES_PER_ELEMENT;
    this._texCoords = e ? new cc.Tex2F(e.u, e.v, f, g) : new cc.Tex2F(0, 0, f, g)
};
cc.V2F_C4B_T2F.BYTES_PER_ELEMENT = 20;
_p = cc.V2F_C4B_T2F.prototype;
_p._getVertices = function () {
    return this._vertices
};
_p._setVertices = function (c) {
    this._vertices._view[0] = c.x;
    this._vertices._view[1] = c.y
};
_p._getColor = function () {
    return this._colors
};
_p._setColor = function (c) {
    var d = this._colors;
    d._view[0] = c.r;
    d._view[1] = c.g;
    d._view[2] = c.b;
    d._view[3] = c.a
};
_p._getTexCoords = function () {
    return this._texCoords
};
_p._setTexCoords = function (c) {
    this._texCoords._view[0] = c.u;
    this._texCoords._view[1] = c.v
};
cc.defineGetterSetter(_p, "vertices", _p._getVertices, _p._setVertices);
cc.defineGetterSetter(_p, "colors", _p._getColor, _p._setColor);
cc.defineGetterSetter(_p, "texCoords", _p._getTexCoords, _p._setTexCoords);
cc.V2F_C4B_T2F_Triangle = function (c, d, e, f, g) {
    this._arrayBuffer = f || new ArrayBuffer(cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT);
    this._offset = g || 0;
    f = this._arrayBuffer;
    g = this._offset;
    var h = cc.V2F_C4B_T2F.BYTES_PER_ELEMENT;
    this._a = c ? new cc.V2F_C4B_T2F(c.vertices, c.colors, c.texCoords, f, g) : new cc.V2F_C4B_T2F(null, null, null, f, g);
    g += h;
    this._b = d ? new cc.V2F_C4B_T2F(d.vertices, d.colors, d.texCoords, f, g) : new cc.V2F_C4B_T2F(null, null, null, f, g);
    g += h;
    this._c = e ? new cc.V2F_C4B_T2F(e.vertices, e.colors, e.texCoords, f, g) :
        new cc.V2F_C4B_T2F(null, null, null, f, g)
};
cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT = 60;
_p = cc.V2F_C4B_T2F_Triangle.prototype;
_p._getA = function () {
    return this._a
};
_p._setA = function (c) {
    var d = this._a;
    d.vertices = c.vertices;
    d.colors = c.colors;
    d.texCoords = c.texCoords
};
_p._getB = function () {
    return this._b
};
_p._setB = function (c) {
    var d = this._b;
    d.vertices = c.vertices;
    d.colors = c.colors;
    d.texCoords = c.texCoords
};
_p._getC = function () {
    return this._c
};
_p._setC = function (c) {
    var d = this._c;
    d.vertices = c.vertices;
    d.colors = c.colors;
    d.texCoords = c.texCoords
};
cc.defineGetterSetter(_p, "a", _p._getA, _p._setA);
cc.defineGetterSetter(_p, "b", _p._getB, _p._setB);
cc.defineGetterSetter(_p, "c", _p._getC, _p._setC);
cc.vertex2 = function (c, d) {
    return new cc.Vertex2F(c, d)
};
cc.vertex3 = function (c, d, e) {
    return new cc.Vertex3F(c, d, e)
};
cc.tex2 = function (c, d) {
    return new cc.Tex2F(c, d)
};
cc.BlendFunc = function (c, d) {
    this.src = c;
    this.dst = d
};
cc.blendFuncDisable = function () {
    return new cc.BlendFunc(cc.ONE, cc.ZERO)
};
cc.hexToColor = function (c) {
    c = c.replace(/^#?/, "0x");
    c = parseInt(c);
    return cc.color(c >> 16, (c >> 8) % 256, c % 256)
};
cc.colorToHex = function (c) {
    var d = c.r.toString(16), e = c.g.toString(16), f = c.b.toString(16);
    return "#" + (16 > c.r ? "0" + d : d) + (16 > c.g ? "0" + e : e) + (16 > c.b ? "0" + f : f)
};
cc.TEXT_ALIGNMENT_LEFT = 0;
cc.TEXT_ALIGNMENT_CENTER = 1;
cc.TEXT_ALIGNMENT_RIGHT = 2;
cc.VERTICAL_TEXT_ALIGNMENT_TOP = 0;
cc.VERTICAL_TEXT_ALIGNMENT_CENTER = 1;
cc.VERTICAL_TEXT_ALIGNMENT_BOTTOM = 2;
cc._Dictionary = cc.Class.extend({
    _keyMapTb: null, _valueMapTb: null, __currId: 0, ctor: function () {
        this._keyMapTb = {};
        this._valueMapTb = {};
        this.__currId = 2 << (0 | 10 * Math.random())
    }, __getKey: function () {
        this.__currId++;
        return "key_" + this.__currId
    }, setObject: function (c, d) {
        if (null != d) {
            var e = this.__getKey();
            this._keyMapTb[e] = d;
            this._valueMapTb[e] = c
        }
    }, objectForKey: function (c) {
        if (null == c)return null;
        var d = this._keyMapTb, e;
        for (e in d)if (d[e] === c)return this._valueMapTb[e];
        return null
    }, valueForKey: function (c) {
        return this.objectForKey(c)
    },
    removeObjectForKey: function (c) {
        if (null != c) {
            var d = this._keyMapTb, e;
            for (e in d)if (d[e] === c) {
                delete this._valueMapTb[e];
                delete d[e];
                break
            }
        }
    }, removeObjectsForKeys: function (c) {
        if (null != c)for (var d = 0; d < c.length; d++)this.removeObjectForKey(c[d])
    }, allKeys: function () {
        var c = [], d = this._keyMapTb, e;
        for (e in d)c.push(d[e]);
        return c
    }, removeAllObjects: function () {
        this._keyMapTb = {};
        this._valueMapTb = {}
    }, count: function () {
        return this.allKeys().length
    }
});
cc.FontDefinition = function (c) {
    this.fontName = "Arial";
    this.fontSize = 12;
    this.textAlign = cc.TEXT_ALIGNMENT_CENTER;
    this.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
    this.fillStyle = cc.color(255, 255, 255, 255);
    this.boundingHeight = this.boundingWidth = 0;
    this.strokeEnabled = !1;
    this.strokeStyle = cc.color(255, 255, 255, 255);
    this.lineWidth = 1;
    this.fontWeight = this.fontStyle = this.lineHeight = "normal";
    this.shadowEnabled = !1;
    this.shadowBlur = this.shadowOffsetY = this.shadowOffsetX = 0;
    this.shadowOpacity = 1;
    if (c && c instanceof Object)for (var d in c)this[d] =
        c[d]
};
cc.FontDefinition.prototype._getCanvasFontStr = function () {
    return this.fontStyle + " " + this.fontWeight + " " + this.fontSize + "px/" + (this.lineHeight.charAt ? this.lineHeight : this.lineHeight + "px") + " '" + this.fontName + "'"
};
cc.game.addEventListener(cc.game.EVENT_RENDERER_INITED, function () {
    cc._renderType === cc.game.RENDER_TYPE_CANVAS && (cc.assert(cc.isFunction(cc._tmp.PrototypeColor), cc._LogInfos.MissingFile, "CCTypesPropertyDefine.js"), cc._tmp.PrototypeColor(), delete cc._tmp.PrototypeColor)
});
cc.Touches = [];
cc.TouchesIntergerDict = {};
cc.DENSITYDPI_DEVICE = "device-dpi";
cc.DENSITYDPI_HIGH = "high-dpi";
cc.DENSITYDPI_MEDIUM = "medium-dpi";
cc.DENSITYDPI_LOW = "low-dpi";
var __BrowserGetter = {
    init: function () {
        this.html = document.getElementsByTagName("html")[0]
    }, availWidth: function (c) {
        return c && c !== this.html ? c.clientWidth : window.innerWidth
    }, availHeight: function (c) {
        return c && c !== this.html ? c.clientHeight : window.innerHeight
    }, meta: {width: "device-width"}, adaptationType: cc.sys.browserType
};
-1 < window.navigator.userAgent.indexOf("OS 8_1_") && (__BrowserGetter.adaptationType = cc.sys.BROWSER_TYPE_MIUI);
cc.sys.os === cc.sys.OS_IOS && (__BrowserGetter.adaptationType = cc.sys.BROWSER_TYPE_SAFARI);
switch (__BrowserGetter.adaptationType) {
    case cc.sys.BROWSER_TYPE_SAFARI:
        __BrowserGetter.meta["minimal-ui"] = "true";
        __BrowserGetter.availWidth = function (c) {
            return c.clientWidth
        };
        __BrowserGetter.availHeight = function (c) {
            return c.clientHeight
        };
        break;
    case cc.sys.BROWSER_TYPE_CHROME:
        __BrowserGetter.__defineGetter__("target-densitydpi", function () {
            return cc.view._targetDensityDPI
        });
    case cc.sys.BROWSER_TYPE_SOUGOU:
    case cc.sys.BROWSER_TYPE_UC:
        __BrowserGetter.availWidth = function (c) {
            return c.clientWidth
        };
        __BrowserGetter.availHeight =
            function (c) {
                return c.clientHeight
            };
        break;
    case cc.sys.BROWSER_TYPE_MIUI:
        __BrowserGetter.init = function (c) {
            if (!c.__resizeWithBrowserSize) {
                var d = function () {
                    c.setDesignResolutionSize(c._designResolutionSize.width, c._designResolutionSize.height, c._resolutionPolicy);
                    window.removeEventListener("resize", d, !1)
                };
                window.addEventListener("resize", d, !1)
            }
        }
}
var _scissorRect = cc.rect();
cc.EGLView = cc.Class.extend({
    _delegate: null,
    _frameSize: null,
    _designResolutionSize: null,
    _originalDesignResolutionSize: null,
    _viewPortRect: null,
    _visibleRect: null,
    _retinaEnabled: !1,
    _autoFullScreen: !1,
    _devicePixelRatio: 1,
    _viewName: "",
    _resizeCallback: null,
    _scaleX: 1,
    _originalScaleX: 1,
    _scaleY: 1,
    _originalScaleY: 1,
    _isRotated: !1,
    _orientation: 3,
    _resolutionPolicy: null,
    _rpExactFit: null,
    _rpShowAll: null,
    _rpNoBorder: null,
    _rpFixedHeight: null,
    _rpFixedWidth: null,
    _initialized: !1,
    _contentTranslateLeftTop: null,
    _frame: null,
    _frameZoomFactor: 1,
    __resizeWithBrowserSize: !1,
    _isAdjustViewPort: !0,
    _targetDensityDPI: null,
    ctor: function () {
        var c = document, d = cc.ContainerStrategy, e = cc.ContentStrategy;
        __BrowserGetter.init(this);
        this._frame = cc.container.parentNode === c.body ? c.documentElement : cc.container.parentNode;
        this._frameSize = cc.size(0, 0);
        this._initFrameSize();
        var c = cc._canvas.width, f = cc._canvas.height;
        this._designResolutionSize = cc.size(c, f);
        this._originalDesignResolutionSize = cc.size(c, f);
        this._viewPortRect = cc.rect(0, 0, c, f);
        this._visibleRect =
            cc.rect(0, 0, c, f);
        this._contentTranslateLeftTop = {left: 0, top: 0};
        this._viewName = "Cocos2dHTML5";
        c = cc.sys;
        this.enableRetina(c.os === c.OS_IOS || c.os === c.OS_OSX);
        this.enableAutoFullScreen(c.isMobile && c.browserType !== c.BROWSER_TYPE_BAIDU);
        cc.visibleRect && cc.visibleRect.init(this._visibleRect);
        this._rpExactFit = new cc.ResolutionPolicy(d.EQUAL_TO_FRAME, e.EXACT_FIT);
        this._rpShowAll = new cc.ResolutionPolicy(d.PROPORTION_TO_FRAME, e.SHOW_ALL);
        this._rpNoBorder = new cc.ResolutionPolicy(d.EQUAL_TO_FRAME, e.NO_BORDER);
        this._rpFixedHeight =
            new cc.ResolutionPolicy(d.EQUAL_TO_FRAME, e.FIXED_HEIGHT);
        this._rpFixedWidth = new cc.ResolutionPolicy(d.EQUAL_TO_FRAME, e.FIXED_WIDTH);
        this._targetDensityDPI = cc.DENSITYDPI_HIGH
    },
    _resizeEvent: function () {
        var c;
        c = this.setDesignResolutionSize ? this : cc.view;
        var d = c._frameSize.width, e = c._frameSize.height, f = c._isRotated;
        c._initFrameSize();
        if (c._isRotated !== f || c._frameSize.width !== d || c._frameSize.height !== e)c._resizeCallback && c._resizeCallback.call(), d = c._originalDesignResolutionSize.width, e = c._originalDesignResolutionSize.height,
        0 < d && c.setDesignResolutionSize(d, e, c._resolutionPolicy)
    },
    setTargetDensityDPI: function (c) {
        this._targetDensityDPI = c;
        this._adjustViewportMeta()
    },
    getTargetDensityDPI: function () {
        return this._targetDensityDPI
    },
    resizeWithBrowserSize: function (c) {
        c ? this.__resizeWithBrowserSize || (this.__resizeWithBrowserSize = !0, window.addEventListener("resize", this._resizeEvent), window.addEventListener("orientationchange", this._resizeEvent)) : this.__resizeWithBrowserSize && (this.__resizeWithBrowserSize = !1, window.removeEventListener("resize",
            this._resizeEvent), window.removeEventListener("orientationchange", this._resizeEvent))
    },
    setResizeCallback: function (c) {
        if (cc.isFunction(c) || null == c)this._resizeCallback = c
    },
    setOrientation: function (c) {
        if (c &= cc.ORIENTATION_AUTO)this._orientation = c
    },
    _initFrameSize: function () {
        var c = this._frameSize, d = __BrowserGetter.availWidth(this._frame), e = __BrowserGetter.availHeight(this._frame), f = d >= e;
        !cc.sys.isMobile || f && this._orientation & cc.ORIENTATION_LANDSCAPE || !f && this._orientation & cc.ORIENTATION_PORTRAIT ? (c.width =
            d, c.height = e, cc.container.style["-webkit-transform"] = "rotate(0deg)", cc.container.style.transform = "rotate(0deg)", this._isRotated = !1) : (c.width = e, c.height = d, cc.container.style["-webkit-transform"] = "rotate(90deg)", cc.container.style.transform = "rotate(90deg)", cc.container.style["-webkit-transform-origin"] = "0px 0px 0px", cc.container.style.transformOrigin = "0px 0px 0px", this._isRotated = !0)
    },
    _adjustSizeKeepCanvasSize: function () {
        var c = this._originalDesignResolutionSize.width, d = this._originalDesignResolutionSize.height;
        0 < c && this.setDesignResolutionSize(c, d, this._resolutionPolicy)
    },
    _setViewportMeta: function (c, d) {
        var e = document.getElementById("cocosMetaElement");
        e && d && document.head.removeChild(e);
        var f = document.getElementsByName("viewport"), f = f ? f[0] : null, g, h, k;
        g = f ? f.content : "";
        e = e || document.createElement("meta");
        e.id = "cocosMetaElement";
        e.name = "viewport";
        e.content = "";
        for (h in c)-1 == g.indexOf(h) ? g += "," + h + "\x3d" + c[h] : d && (k = RegExp(h + "s*\x3ds*[^,]+"), g.replace(k, h + "\x3d" + c[h]));
        /^,/.test(g) && (g = g.substr(1));
        e.content =
            g;
        f && (f.content = g);
        document.head.appendChild(e)
    },
    _adjustViewportMeta: function () {
        this._isAdjustViewPort && (this._setViewportMeta(__BrowserGetter.meta, !1), this._isAdjustViewPort = !1)
    },
    _setScaleXYForRenderTexture: function () {
        var c = cc.contentScaleFactor();
        this._scaleY = this._scaleX = c
    },
    _resetScale: function () {
        this._scaleX = this._originalScaleX;
        this._scaleY = this._originalScaleY
    },
    _adjustSizeToBrowser: function () {
    },
    initialize: function () {
        this._initialized = !0
    },
    adjustViewPort: function (c) {
        this._isAdjustViewPort = c
    },
    enableRetina: function (c) {
        this._retinaEnabled = c ? !0 : !1
    },
    isRetinaEnabled: function () {
        return this._retinaEnabled
    },
    enableAutoFullScreen: function (c) {
        c && c !== this._autoFullScreen && cc.sys.isMobile && this._frame === document.documentElement ? (this._autoFullScreen = !0, cc.screen.autoFullScreen(this._frame)) : this._autoFullScreen = !1
    },
    isAutoFullScreenEnabled: function () {
        return this._autoFullScreen
    },
    end: function () {
    },
    isOpenGLReady: function () {
        return cc.game.canvas && cc._renderContext
    },
    setFrameZoomFactor: function (c) {
        this._frameZoomFactor =
            c;
        this.centerWindow();
        cc.director.setProjection(cc.director.getProjection())
    },
    swapBuffers: function () {
    },
    setIMEKeyboardState: function (c) {
    },
    setContentTranslateLeftTop: function (c, d) {
        this._contentTranslateLeftTop = {left: c, top: d}
    },
    getContentTranslateLeftTop: function () {
        return this._contentTranslateLeftTop
    },
    getCanvasSize: function () {
        return cc.size(cc._canvas.width, cc._canvas.height)
    },
    getFrameSize: function () {
        return cc.size(this._frameSize.width, this._frameSize.height)
    },
    setFrameSize: function (c, d) {
        this._frameSize.width =
            c;
        this._frameSize.height = d;
        this._frame.style.width = c + "px";
        this._frame.style.height = d + "px";
        this._resizeEvent();
        cc.director.setProjection(cc.director.getProjection())
    },
    centerWindow: function () {
    },
    getVisibleSize: function () {
        return cc.size(this._visibleRect.width, this._visibleRect.height)
    },
    getVisibleSizeInPixel: function () {
        return cc.size(this._visibleRect.width * this._scaleX, this._visibleRect.height * this._scaleY)
    },
    getVisibleOrigin: function () {
        return cc.p(this._visibleRect.x, this._visibleRect.y)
    },
    getVisibleOriginInPixel: function () {
        return cc.p(this._visibleRect.x *
            this._scaleX, this._visibleRect.y * this._scaleY)
    },
    canSetContentScaleFactor: function () {
        return !0
    },
    getResolutionPolicy: function () {
        return this._resolutionPolicy
    },
    setResolutionPolicy: function (c) {
        if (c instanceof cc.ResolutionPolicy)this._resolutionPolicy = c; else {
            var d = cc.ResolutionPolicy;
            c === d.EXACT_FIT && (this._resolutionPolicy = this._rpExactFit);
            c === d.SHOW_ALL && (this._resolutionPolicy = this._rpShowAll);
            c === d.NO_BORDER && (this._resolutionPolicy = this._rpNoBorder);
            c === d.FIXED_HEIGHT && (this._resolutionPolicy = this._rpFixedHeight);
            c === d.FIXED_WIDTH && (this._resolutionPolicy = this._rpFixedWidth)
        }
    },
    setDesignResolutionSize: function (c, d, e) {
        if (0 < c || 0 < d)if (this.setResolutionPolicy(e), e = this._resolutionPolicy) {
            e.preApply(this);
            cc.sys.isMobile && this._adjustViewportMeta();
            this._initFrameSize();
            this._originalDesignResolutionSize.width = this._designResolutionSize.width = c;
            this._originalDesignResolutionSize.height = this._designResolutionSize.height = d;
            var f = e.apply(this, this._designResolutionSize);
            f.scale && 2 === f.scale.length && (this._scaleX =
                f.scale[0], this._scaleY = f.scale[1]);
            f.viewport && (c = this._viewPortRect, d = this._visibleRect, f = f.viewport, c.x = f.x, c.y = f.y, c.width = f.width, c.height = f.height, d.x = -c.x / this._scaleX, d.y = -c.y / this._scaleY, d.width = cc._canvas.width / this._scaleX, d.height = cc._canvas.height / this._scaleY, cc._renderContext.setOffset && cc._renderContext.setOffset(c.x, -c.y));
            c = cc.director;
            c._winSizeInPoints.width = this._designResolutionSize.width;
            c._winSizeInPoints.height = this._designResolutionSize.height;
            e.postApply(this);
            cc.winSize.width =
                c._winSizeInPoints.width;
            cc.winSize.height = c._winSizeInPoints.height;
            cc._renderType === cc.game.RENDER_TYPE_WEBGL && c.setGLDefaultValues();
            this._originalScaleX = this._scaleX;
            this._originalScaleY = this._scaleY;
            cc.DOM && cc.DOM._resetEGLViewDiv();
            cc.visibleRect && cc.visibleRect.init(this._visibleRect)
        } else cc.log(cc._LogInfos.EGLView_setDesignResolutionSize_2); else cc.log(cc._LogInfos.EGLView_setDesignResolutionSize)
    },
    getDesignResolutionSize: function () {
        return cc.size(this._designResolutionSize.width, this._designResolutionSize.height)
    },
    setRealPixelResolution: function (c, d, e) {
        this._setViewportMeta({width: c, "target-densitydpi": cc.DENSITYDPI_DEVICE}, !0);
        document.body.style.width = c + "px";
        document.body.style.left = "0px";
        document.body.style.top = "0px";
        this.setDesignResolutionSize(c, d, e)
    },
    setViewPortInPoints: function (c, d, e, f) {
        var g = this._frameZoomFactor, h = this._scaleX, k = this._scaleY;
        cc._renderContext.viewport(c * h * g + this._viewPortRect.x * g, d * k * g + this._viewPortRect.y * g, e * h * g, f * k * g)
    },
    setScissorInPoints: function (c, d, e, f) {
        var g = this._frameZoomFactor,
            h = this._scaleX, k = this._scaleY;
        _scissorRect.x = c;
        _scissorRect.y = d;
        _scissorRect.width = e;
        _scissorRect.height = f;
        cc._renderContext.scissor(c * h * g + this._viewPortRect.x * g, d * k * g + this._viewPortRect.y * g, e * h * g, f * k * g)
    },
    isScissorEnabled: function () {
        return cc._renderContext.isEnabled(gl.SCISSOR_TEST)
    },
    getScissorRect: function () {
        return cc.rect(_scissorRect)
    },
    setViewName: function (c) {
        null != c && 0 < c.length && (this._viewName = c)
    },
    getViewName: function () {
        return this._viewName
    },
    getViewPortRect: function () {
        return this._viewPortRect
    },
    getScaleX: function () {
        return this._scaleX
    },
    getScaleY: function () {
        return this._scaleY
    },
    getDevicePixelRatio: function () {
        return this._devicePixelRatio
    },
    convertToLocationInView: function (c, d, e) {
        c = this._devicePixelRatio * (c - e.left);
        d = this._devicePixelRatio * (e.top + e.height - d);
        return this._isRotated ? {x: this._viewPortRect.width - d, y: c} : {x: c, y: d}
    },
    _convertMouseToLocationInView: function (c, d) {
        var e = this._viewPortRect;
        c.x = (this._devicePixelRatio * (c.x - d.left) - e.x) / this._scaleX;
        c.y = (this._devicePixelRatio * (d.top + d.height -
            c.y) - e.y) / this._scaleY
    },
    _convertTouchesWithScale: function (c) {
        for (var d = this._viewPortRect, e = this._scaleX, f = this._scaleY, g, h, k, m = 0; m < c.length; m++)g = c[m], h = g._point, k = g._prevPoint, g = g._startPoint, h.x = (h.x - d.x) / e, h.y = (h.y - d.y) / f, k.x = (k.x - d.x) / e, k.y = (k.y - d.y) / f, g.x = (g.x - d.x) / e, g.y = (g.y - d.y) / f
    }
});
cc.EGLView._getInstance = function () {
    this._instance || (this._instance = this._instance || new cc.EGLView, this._instance.initialize());
    return this._instance
};
cc.ContainerStrategy = cc.Class.extend({
    preApply: function (c) {
    }, apply: function (c, d) {
    }, postApply: function (c) {
    }, _setupContainer: function (c, d, e) {
        var f = cc.game.canvas, g = cc.game.container;
        g.style.width = f.style.width = d + "px";
        g.style.height = f.style.height = e + "px";
        g = c._devicePixelRatio = 1;
        c.isRetinaEnabled() && (g = c._devicePixelRatio = Math.min(2, window.devicePixelRatio || 1));
        f.width = d * g;
        f.height = e * g;
        cc._renderContext.resetCache && cc._renderContext.resetCache()
    }, _fixContainer: function () {
        document.body.insertBefore(cc.container,
            document.body.firstChild);
        var c = document.body.style;
        c.width = window.innerWidth + "px";
        c.height = window.innerHeight + "px";
        c.overflow = "hidden";
        c = cc.container.style;
        c.position = "fixed";
        c.left = c.top = "0px";
        document.body.scrollTop = 0
    }
});
cc.ContentStrategy = cc.Class.extend({
    _result: {scale: [1, 1], viewport: null},
    _buildResult: function (c, d, e, f, g, h) {
        2 > Math.abs(c - e) && (e = c);
        2 > Math.abs(d - f) && (f = d);
        c = cc.rect(Math.round((c - e) / 2), Math.round((d - f) / 2), e, f);
        this._result.scale = [g, h];
        this._result.viewport = c;
        return this._result
    },
    preApply: function (c) {
    },
    apply: function (c, d) {
        return {scale: [1, 1]}
    },
    postApply: function (c) {
    }
});
(function () {
    var c = cc.ContainerStrategy.extend({
        apply: function (c) {
            this._setupContainer(c, c._frameSize.width, c._frameSize.height)
        }
    }), d = cc.ContainerStrategy.extend({
        apply: function (c, d) {
            var e = c._frameSize.width, f = c._frameSize.height, g = cc.container.style, r = d.width, s = d.height, v = e / r, t = f / s, w, u;
            v < t ? (w = e, u = s * v) : (w = r * t, u = f);
            r = Math.round((e - w) / 2);
            u = Math.round((f - u) / 2);
            this._setupContainer(c, e - 2 * r, f - 2 * u);
            c._isRotated ? g.marginLeft = f + "px" : g.margin = "0px";
            g.paddingLeft = r + "px";
            g.paddingRight = r + "px";
            g.paddingTop = u +
                "px";
            g.paddingBottom = u + "px"
        }
    });
    c.extend({
        preApply: function (c) {
            this._super(c);
            c._frame = document.documentElement
        }, apply: function (c) {
            this._super(c);
            this._fixContainer()
        }
    });
    d.extend({
        preApply: function (c) {
            this._super(c);
            c._frame = document.documentElement
        }, apply: function (c, d) {
            this._super(c, d);
            this._fixContainer()
        }
    });
    var e = cc.ContainerStrategy.extend({
        apply: function (c) {
            this._setupContainer(c, cc._canvas.width, cc._canvas.height)
        }
    });
    cc.ContainerStrategy.EQUAL_TO_FRAME = new c;
    cc.ContainerStrategy.PROPORTION_TO_FRAME =
        new d;
    cc.ContainerStrategy.ORIGINAL_CONTAINER = new e;
    var c = cc.ContentStrategy.extend({
        apply: function (c, d) {
            var e = cc._canvas.width, f = cc._canvas.height;
            return this._buildResult(e, f, e, f, e / d.width, f / d.height)
        }
    }), d = cc.ContentStrategy.extend({
        apply: function (c, d) {
            var e = cc._canvas.width, f = cc._canvas.height, g = d.width, r = d.height, s = e / g, v = f / r, t = 0, w, u;
            s < v ? (t = s, w = e, u = r * t) : (t = v, w = g * t, u = f);
            return this._buildResult(e, f, w, u, t, t)
        }
    }), e = cc.ContentStrategy.extend({
        apply: function (c, d) {
            var e = cc._canvas.width, f = cc._canvas.height,
                g = d.width, r = d.height, s = e / g, v = f / r, t, w, u;
            s < v ? (t = v, w = g * t, u = f) : (t = s, w = e, u = r * t);
            return this._buildResult(e, f, w, u, t, t)
        }
    }), f = cc.ContentStrategy.extend({
        apply: function (c, d) {
            var e = cc._canvas.width, f = cc._canvas.height, g = f / d.height;
            return this._buildResult(e, f, e, f, g, g)
        }, postApply: function (c) {
            cc.director._winSizeInPoints = c.getVisibleSize()
        }
    }), g = cc.ContentStrategy.extend({
        apply: function (c, d) {
            var e = cc._canvas.width, f = cc._canvas.height, g = e / d.width;
            return this._buildResult(e, f, e, f, g, g)
        }, postApply: function (c) {
            cc.director._winSizeInPoints =
                c.getVisibleSize()
        }
    });
    cc.ContentStrategy.EXACT_FIT = new c;
    cc.ContentStrategy.SHOW_ALL = new d;
    cc.ContentStrategy.NO_BORDER = new e;
    cc.ContentStrategy.FIXED_HEIGHT = new f;
    cc.ContentStrategy.FIXED_WIDTH = new g
})();
cc.ResolutionPolicy = cc.Class.extend({
    _containerStrategy: null, _contentStrategy: null, ctor: function (c, d) {
        this.setContainerStrategy(c);
        this.setContentStrategy(d)
    }, preApply: function (c) {
        this._containerStrategy.preApply(c);
        this._contentStrategy.preApply(c)
    }, apply: function (c, d) {
        this._containerStrategy.apply(c, d);
        return this._contentStrategy.apply(c, d)
    }, postApply: function (c) {
        this._containerStrategy.postApply(c);
        this._contentStrategy.postApply(c)
    }, setContainerStrategy: function (c) {
        c instanceof cc.ContainerStrategy &&
        (this._containerStrategy = c)
    }, setContentStrategy: function (c) {
        c instanceof cc.ContentStrategy && (this._contentStrategy = c)
    }
});
cc.ResolutionPolicy.EXACT_FIT = 0;
cc.ResolutionPolicy.NO_BORDER = 1;
cc.ResolutionPolicy.SHOW_ALL = 2;
cc.ResolutionPolicy.FIXED_HEIGHT = 3;
cc.ResolutionPolicy.FIXED_WIDTH = 4;
cc.ResolutionPolicy.UNKNOWN = 5;
cc.screen = {
    _supportsFullScreen: !1,
    _preOnFullScreenChange: null,
    _touchEvent: "",
    _fn: null,
    _fnMap: [["requestFullscreen", "exitFullscreen", "fullscreenchange", "fullscreenEnabled", "fullscreenElement"], ["requestFullScreen", "exitFullScreen", "fullScreenchange", "fullScreenEnabled", "fullScreenElement"], ["webkitRequestFullScreen", "webkitCancelFullScreen", "webkitfullscreenchange", "webkitIsFullScreen", "webkitCurrentFullScreenElement"], ["mozRequestFullScreen", "mozCancelFullScreen", "mozfullscreenchange", "mozFullScreen",
        "mozFullScreenElement"], ["msRequestFullscreen", "msExitFullscreen", "MSFullscreenChange", "msFullscreenEnabled", "msFullscreenElement"]],
    init: function () {
        this._fn = {};
        var c, d, e = this._fnMap, f;
        c = 0;
        for (l = e.length; c < l; c++)if ((d = e[c]) && d[1] in document) {
            c = 0;
            for (f = d.length; c < f; c++)this._fn[e[0][c]] = d[c];
            break
        }
        this._supportsFullScreen = "undefined" !== typeof this._fn.requestFullscreen;
        this._touchEvent = "ontouchstart" in window ? "touchstart" : "mousedown"
    },
    fullScreen: function () {
        return this._supportsFullScreen ? void 0 ===
        document[this._fn.fullscreenElement] || null === document[this._fn.fullscreenElement] ? !1 : !0 : !1
    },
    requestFullScreen: function (c, d) {
        if (this._supportsFullScreen) {
            c = c || document.documentElement;
            if (d) {
                var e = this._fn.fullscreenchange;
                this._preOnFullScreenChange && document.removeEventListener(e, this._preOnFullScreenChange);
                this._preOnFullScreenChange = d;
                document.addEventListener(e, d, !1)
            }
            return c[this._fn.requestFullscreen]()
        }
    },
    exitFullScreen: function () {
        return this._supportsFullScreen ? document[this._fn.exitFullscreen]() :
            !0
    },
    autoFullScreen: function (c, d) {
        function e() {
            f.removeEventListener(g._touchEvent, e);
            g.requestFullScreen(c, d)
        }

        c = c || document.body;
        var f = cc.game.canvas || c, g = this;
        this.requestFullScreen(c, d);
        f.addEventListener(this._touchEvent, e)
    }
};
cc.screen.init();
cc.visibleRect = {
    topLeft: cc.p(0, 0),
    topRight: cc.p(0, 0),
    top: cc.p(0, 0),
    bottomLeft: cc.p(0, 0),
    bottomRight: cc.p(0, 0),
    bottom: cc.p(0, 0),
    center: cc.p(0, 0),
    left: cc.p(0, 0),
    right: cc.p(0, 0),
    width: 0,
    height: 0,
    init: function (c) {
        var d = this.width = c.width, e = this.height = c.height, f = c.x;
        c = c.y;
        var g = c + e, h = f + d;
        this.topLeft.x = f;
        this.topLeft.y = g;
        this.topRight.x = h;
        this.topRight.y = g;
        this.top.x = f + d / 2;
        this.top.y = g;
        this.bottomLeft.x = f;
        this.bottomLeft.y = c;
        this.bottomRight.x = h;
        this.bottomRight.y = c;
        this.bottom.x = f + d / 2;
        this.bottom.y =
            c;
        this.center.x = f + d / 2;
        this.center.y = c + e / 2;
        this.left.x = f;
        this.left.y = c + e / 2;
        this.right.x = h;
        this.right.y = c + e / 2
    }
};
cc.UIInterfaceOrientationLandscapeLeft = -90;
cc.UIInterfaceOrientationLandscapeRight = 90;
cc.UIInterfaceOrientationPortraitUpsideDown = 180;
cc.UIInterfaceOrientationPortrait = 0;
cc.inputManager = {
    _mousePressed: !1,
    _isRegisterEvent: !1,
    _preTouchPoint: cc.p(0, 0),
    _prevMousePoint: cc.p(0, 0),
    _preTouchPool: [],
    _preTouchPoolPointer: 0,
    _touches: [],
    _touchesIntegerDict: {},
    _indexBitsUsed: 0,
    _maxTouches: 5,
    _accelEnabled: !1,
    _accelInterval: 1 / 30,
    _accelMinus: 1,
    _accelCurTime: 0,
    _acceleration: null,
    _accelDeviceEvent: null,
    _getUnUsedIndex: function () {
        for (var c = this._indexBitsUsed, d = 0; d < this._maxTouches; d++) {
            if (!(c & 1))return this._indexBitsUsed |= 1 << d, d;
            c >>= 1
        }
        return -1
    },
    _removeUsedIndexBit: function (c) {
        0 > c ||
        c >= this._maxTouches || (c = ~(1 << c), this._indexBitsUsed &= c)
    },
    _glView: null,
    handleTouchesBegin: function (c) {
        for (var d, e, f, g = [], h = this._touchesIntegerDict, k = 0, m = c.length; k < m; k++)if (d = c[k], f = d.getID(), e = h[f], null == e) {
            var n = this._getUnUsedIndex();
            -1 === n ? cc.log(cc._LogInfos.inputManager_handleTouchesBegin, n) : (e = this._touches[n] = new cc.Touch(d._point.x, d._point.y, d.getID()), e._setPrevPoint(d._prevPoint), h[f] = n, g.push(e))
        }
        0 < g.length && (this._glView._convertTouchesWithScale(g), c = new cc.EventTouch(g), c._eventCode =
            cc.EventTouch.EventCode.BEGAN, cc.eventManager.dispatchEvent(c))
    },
    handleTouchesMove: function (c) {
        for (var d, e, f = [], g = this._touches, h = 0, k = c.length; h < k; h++)d = c[h], e = d.getID(), e = this._touchesIntegerDict[e], null != e && g[e] && (g[e]._setPoint(d._point), g[e]._setPrevPoint(d._prevPoint), f.push(g[e]));
        0 < f.length && (this._glView._convertTouchesWithScale(f), c = new cc.EventTouch(f), c._eventCode = cc.EventTouch.EventCode.MOVED, cc.eventManager.dispatchEvent(c))
    },
    handleTouchesEnd: function (c) {
        c = this.getSetOfTouchesEndOrCancel(c);
        0 < c.length && (this._glView._convertTouchesWithScale(c), c = new cc.EventTouch(c), c._eventCode = cc.EventTouch.EventCode.ENDED, cc.eventManager.dispatchEvent(c))
    },
    handleTouchesCancel: function (c) {
        c = this.getSetOfTouchesEndOrCancel(c);
        0 < c.length && (this._glView._convertTouchesWithScale(c), c = new cc.EventTouch(c), c._eventCode = cc.EventTouch.EventCode.CANCELLED, cc.eventManager.dispatchEvent(c))
    },
    getSetOfTouchesEndOrCancel: function (c) {
        for (var d, e, f, g = [], h = this._touches, k = this._touchesIntegerDict, m = 0, n = c.length; m <
        n; m++)d = c[m], f = d.getID(), e = k[f], null != e && h[e] && (h[e]._setPoint(d._point), h[e]._setPrevPoint(d._prevPoint), g.push(h[e]), this._removeUsedIndexBit(e), delete k[f]);
        return g
    },
    getHTMLElementPosition: function (c) {
        var d = document.documentElement, e = window, f = null, f = cc.isFunction(c.getBoundingClientRect) ? c.getBoundingClientRect() : {
            left: 0,
            top: 0,
            width: parseInt(c.style.width),
            height: parseInt(c.style.height)
        };
        return {
            left: f.left + e.pageXOffset - d.clientLeft,
            top: f.top + e.pageYOffset - d.clientTop,
            width: f.width,
            height: f.height
        }
    },
    getPreTouch: function (c) {
        for (var d = null, e = this._preTouchPool, f = c.getID(), g = e.length - 1; 0 <= g; g--)if (e[g].getID() === f) {
            d = e[g];
            break
        }
        d || (d = c);
        return d
    },
    setPreTouch: function (c) {
        for (var d = !1, e = this._preTouchPool, f = c.getID(), g = e.length - 1; 0 <= g; g--)if (e[g].getID() === f) {
            e[g] = c;
            d = !0;
            break
        }
        d || (50 >= e.length ? e.push(c) : (e[this._preTouchPoolPointer] = c, this._preTouchPoolPointer = (this._preTouchPoolPointer + 1) % 50))
    },
    getTouchByXY: function (c, d, e) {
        var f = this._preTouchPoint;
        c = this._glView.convertToLocationInView(c, d, e);
        d =
            new cc.Touch(c.x, c.y);
        d._setPrevPoint(f.x, f.y);
        f.x = c.x;
        f.y = c.y;
        return d
    },
    getMouseEvent: function (c, d, e) {
        var f = this._prevMousePoint;
        this._glView._convertMouseToLocationInView(c, d);
        d = new cc.EventMouse(e);
        d.setLocation(c.x, c.y);
        d._setPrevCursor(f.x, f.y);
        f.x = c.x;
        f.y = c.y;
        return d
    },
    getPointByEvent: function (c, d) {
        if (null != c.pageX)return {x: c.pageX, y: c.pageY};
        d.left -= document.body.scrollLeft;
        d.top -= document.body.scrollTop;
        return {x: c.clientX, y: c.clientY}
    },
    getTouchesByEvent: function (c, d) {
        for (var e = [], f = this._glView,
                 g, h, k = this._preTouchPoint, m = c.changedTouches.length, n = 0; n < m; n++)if (g = c.changedTouches[n]) {
            var p;
            p = cc.sys.BROWSER_TYPE_FIREFOX === cc.sys.browserType ? f.convertToLocationInView(g.pageX, g.pageY, d) : f.convertToLocationInView(g.clientX, g.clientY, d);
            null != g.identifier ? (g = new cc.Touch(p.x, p.y, g.identifier), h = this.getPreTouch(g).getLocation(), g._setPrevPoint(h.x, h.y), this.setPreTouch(g)) : (g = new cc.Touch(p.x, p.y), g._setPrevPoint(k.x, k.y));
            k.x = p.x;
            k.y = p.y;
            e.push(g)
        }
        return e
    },
    registerSystemEvent: function (c) {
        if (!this._isRegisterEvent) {
            this._glView =
                cc.view;
            var d = this, e = "mouse" in cc.sys.capabilities, f = "touches" in cc.sys.capabilities, g = !1;
            cc.sys.isMobile && (g = !0);
            e && (window.addEventListener("mousedown", function () {
                d._mousePressed = !0
            }, !1), window.addEventListener("mouseup", function (e) {
                if (!g) {
                    var f = d._mousePressed;
                    d._mousePressed = !1;
                    if (f) {
                        var f = d.getHTMLElementPosition(c), h = d.getPointByEvent(e, f);
                        cc.rectContainsPoint(new cc.Rect(f.left, f.top, f.width, f.height), h) || (d.handleTouchesEnd([d.getTouchByXY(h.x, h.y, f)]), f = d.getMouseEvent(h, f, cc.EventMouse.UP),
                            f.setButton(e.button), cc.eventManager.dispatchEvent(f))
                    }
                }
            }, !1), c.addEventListener("mousedown", function (e) {
                if (!g) {
                    d._mousePressed = !0;
                    var f = d.getHTMLElementPosition(c), h = d.getPointByEvent(e, f);
                    d.handleTouchesBegin([d.getTouchByXY(h.x, h.y, f)]);
                    f = d.getMouseEvent(h, f, cc.EventMouse.DOWN);
                    f.setButton(e.button);
                    cc.eventManager.dispatchEvent(f);
                    e.stopPropagation();
                    e.preventDefault();
                    c.focus()
                }
            }, !1), c.addEventListener("mouseup", function (e) {
                if (!g) {
                    d._mousePressed = !1;
                    var f = d.getHTMLElementPosition(c), h = d.getPointByEvent(e,
                        f);
                    d.handleTouchesEnd([d.getTouchByXY(h.x, h.y, f)]);
                    f = d.getMouseEvent(h, f, cc.EventMouse.UP);
                    f.setButton(e.button);
                    cc.eventManager.dispatchEvent(f);
                    e.stopPropagation();
                    e.preventDefault()
                }
            }, !1), c.addEventListener("mousemove", function (e) {
                    if (!g) {
                        var f = d.getHTMLElementPosition(c), h = d.getPointByEvent(e, f);
                        d.handleTouchesMove([d.getTouchByXY(h.x, h.y, f)]);
                        f = d.getMouseEvent(h, f, cc.EventMouse.MOVE);
                        d._mousePressed ? f.setButton(e.button) : f.setButton(null);
                        cc.eventManager.dispatchEvent(f);
                        e.stopPropagation();
                        e.preventDefault()
                    }
                },
                !1), c.addEventListener("mousewheel", function (e) {
                var f = d.getHTMLElementPosition(c), g = d.getPointByEvent(e, f), f = d.getMouseEvent(g, f, cc.EventMouse.SCROLL);
                f.setButton(e.button);
                f.setScrollData(0, e.wheelDelta);
                cc.eventManager.dispatchEvent(f);
                e.stopPropagation();
                e.preventDefault()
            }, !1), c.addEventListener("DOMMouseScroll", function (e) {
                var f = d.getHTMLElementPosition(c), g = d.getPointByEvent(e, f), f = d.getMouseEvent(g, f, cc.EventMouse.SCROLL);
                f.setButton(e.button);
                f.setScrollData(0, -120 * e.detail);
                cc.eventManager.dispatchEvent(f);
                e.stopPropagation();
                e.preventDefault()
            }, !1));
            if (window.navigator.msPointerEnabled) {
                var e = {
                    MSPointerDown: d.handleTouchesBegin,
                    MSPointerMove: d.handleTouchesMove,
                    MSPointerUp: d.handleTouchesEnd,
                    MSPointerCancel: d.handleTouchesCancel
                }, h;
                for (h in e)(function (e, f) {
                    c.addEventListener(e, function (e) {
                        var g = d.getHTMLElementPosition(c);
                        g.left -= document.documentElement.scrollLeft;
                        g.top -= document.documentElement.scrollTop;
                        f.call(d, [d.getTouchByXY(e.clientX, e.clientY, g)]);
                        e.stopPropagation()
                    }, !1)
                })(h, e[h])
            }
            f && (c.addEventListener("touchstart",
                function (e) {
                    if (e.changedTouches) {
                        var f = d.getHTMLElementPosition(c);
                        f.left -= document.body.scrollLeft;
                        f.top -= document.body.scrollTop;
                        d.handleTouchesBegin(d.getTouchesByEvent(e, f));
                        e.stopPropagation();
                        e.preventDefault();
                        c.focus()
                    }
                }, !1), c.addEventListener("touchmove", function (e) {
                if (e.changedTouches) {
                    var f = d.getHTMLElementPosition(c);
                    f.left -= document.body.scrollLeft;
                    f.top -= document.body.scrollTop;
                    d.handleTouchesMove(d.getTouchesByEvent(e, f));
                    e.stopPropagation();
                    e.preventDefault()
                }
            }, !1), c.addEventListener("touchend",
                function (e) {
                    if (e.changedTouches) {
                        var f = d.getHTMLElementPosition(c);
                        f.left -= document.body.scrollLeft;
                        f.top -= document.body.scrollTop;
                        d.handleTouchesEnd(d.getTouchesByEvent(e, f));
                        e.stopPropagation();
                        e.preventDefault()
                    }
                }, !1), c.addEventListener("touchcancel", function (e) {
                if (e.changedTouches) {
                    var f = d.getHTMLElementPosition(c);
                    f.left -= document.body.scrollLeft;
                    f.top -= document.body.scrollTop;
                    d.handleTouchesCancel(d.getTouchesByEvent(e, f));
                    e.stopPropagation();
                    e.preventDefault()
                }
            }, !1));
            this._registerKeyboardEvent();
            this._registerAccelerometerEvent();
            this._isRegisterEvent = !0
        }
    },
    _registerKeyboardEvent: function () {
    },
    _registerAccelerometerEvent: function () {
    },
    update: function (c) {
        this._accelCurTime > this._accelInterval && (this._accelCurTime -= this._accelInterval, cc.eventManager.dispatchEvent(new cc.EventAcceleration(this._acceleration)));
        this._accelCurTime += c
    }
};
_p = cc.inputManager;
_p.setAccelerometerEnabled = function (c) {
    this._accelEnabled !== c && (this._accelEnabled = c, c = cc.director.getScheduler(), this._accelCurTime = 0, c.scheduleUpdate(this))
};
_p.setAccelerometerInterval = function (c) {
    this._accelInterval !== c && (this._accelInterval = c)
};
_p._registerKeyboardEvent = function () {
    cc._canvas.addEventListener("keydown", function (c) {
        cc.eventManager.dispatchEvent(new cc.EventKeyboard(c.keyCode, !0));
        c.stopPropagation();
        c.preventDefault()
    }, !1);
    cc._canvas.addEventListener("keyup", function (c) {
        cc.eventManager.dispatchEvent(new cc.EventKeyboard(c.keyCode, !1));
        c.stopPropagation();
        c.preventDefault()
    }, !1)
};
_p._registerAccelerometerEvent = function () {
    var c = window;
    this._acceleration = new cc.Acceleration;
    this._accelDeviceEvent = c.DeviceMotionEvent || c.DeviceOrientationEvent;
    cc.sys.browserType === cc.sys.BROWSER_TYPE_MOBILE_QQ && (this._accelDeviceEvent = window.DeviceOrientationEvent);
    var d = this._accelDeviceEvent === c.DeviceMotionEvent ? "devicemotion" : "deviceorientation", e = navigator.userAgent;
    if (/Android/.test(e) || /Adr/.test(e) && cc.sys.browserType === cc.BROWSER_TYPE_UC)this._minus = -1;
    c.addEventListener(d, this.didAccelerate.bind(this),
        !1)
};
_p.didAccelerate = function (c) {
    var d = window;
    if (this._accelEnabled) {
        var e = this._acceleration, f, g, h;
        this._accelDeviceEvent === window.DeviceMotionEvent ? (h = c.accelerationIncludingGravity, f = this._accelMinus * h.x * 0.1, g = this._accelMinus * h.y * 0.1, h = 0.1 * h.z) : (f = c.gamma / 90 * 0.981, g = 0.981 * -(c.beta / 90), h = c.alpha / 90 * 0.981);
        e.x = f;
        e.y = g;
        e.z = h;
        e.timestamp = c.timeStamp || Date.now();
        c = e.x;
        d.orientation === cc.UIInterfaceOrientationLandscapeRight ? (e.x = -e.y, e.y = c) : d.orientation === cc.UIInterfaceOrientationLandscapeLeft ? (e.x = e.y,
            e.y = -c) : d.orientation === cc.UIInterfaceOrientationPortraitUpsideDown && (e.x = -e.x, e.y = -e.y)
    }
};
delete _p;
cc.AffineTransform = function (c, d, e, f, g, h) {
    this.a = c;
    this.b = d;
    this.c = e;
    this.d = f;
    this.tx = g;
    this.ty = h
};
cc.affineTransformMake = function (c, d, e, f, g, h) {
    return {a: c, b: d, c: e, d: f, tx: g, ty: h}
};
cc.pointApplyAffineTransform = function (c, d, e) {
    var f;
    void 0 === e ? (e = d, f = c.x, c = c.y) : (f = c, c = d);
    return {x: e.a * f + e.c * c + e.tx, y: e.b * f + e.d * c + e.ty}
};
cc._pointApplyAffineTransform = function (c, d, e) {
    return cc.pointApplyAffineTransform(c, d, e)
};
cc.sizeApplyAffineTransform = function (c, d) {
    return {width: d.a * c.width + d.c * c.height, height: d.b * c.width + d.d * c.height}
};
cc.affineTransformMakeIdentity = function () {
    return {a: 1, b: 0, c: 0, d: 1, tx: 0, ty: 0}
};
cc.affineTransformIdentity = function () {
    return {a: 1, b: 0, c: 0, d: 1, tx: 0, ty: 0}
};
cc.rectApplyAffineTransform = function (c, d) {
    var e = cc.rectGetMinY(c), f = cc.rectGetMinX(c), g = cc.rectGetMaxX(c), h = cc.rectGetMaxY(c), k = cc.pointApplyAffineTransform(f, e, d), e = cc.pointApplyAffineTransform(g, e, d), f = cc.pointApplyAffineTransform(f, h, d), m = cc.pointApplyAffineTransform(g, h, d), g = Math.min(k.x, e.x, f.x, m.x), h = Math.max(k.x, e.x, f.x, m.x), n = Math.min(k.y, e.y, f.y, m.y), k = Math.max(k.y, e.y, f.y, m.y);
    return cc.rect(g, n, h - g, k - n)
};
cc._rectApplyAffineTransformIn = function (c, d) {
    var e = cc.rectGetMinY(c), f = cc.rectGetMinX(c), g = cc.rectGetMaxX(c), h = cc.rectGetMaxY(c), k = cc.pointApplyAffineTransform(f, e, d), e = cc.pointApplyAffineTransform(g, e, d), f = cc.pointApplyAffineTransform(f, h, d), m = cc.pointApplyAffineTransform(g, h, d), g = Math.min(k.x, e.x, f.x, m.x), h = Math.max(k.x, e.x, f.x, m.x), n = Math.min(k.y, e.y, f.y, m.y), k = Math.max(k.y, e.y, f.y, m.y);
    c.x = g;
    c.y = n;
    c.width = h - g;
    c.height = k - n;
    return c
};
cc.affineTransformTranslate = function (c, d, e) {
    return {a: c.a, b: c.b, c: c.c, d: c.d, tx: c.tx + c.a * d + c.c * e, ty: c.ty + c.b * d + c.d * e}
};
cc.affineTransformScale = function (c, d, e) {
    return {a: c.a * d, b: c.b * d, c: c.c * e, d: c.d * e, tx: c.tx, ty: c.ty}
};
cc.affineTransformRotate = function (c, d) {
    var e = Math.sin(d), f = Math.cos(d);
    return {a: c.a * f + c.c * e, b: c.b * f + c.d * e, c: c.c * f - c.a * e, d: c.d * f - c.b * e, tx: c.tx, ty: c.ty}
};
cc.affineTransformConcat = function (c, d) {
    return {
        a: c.a * d.a + c.b * d.c,
        b: c.a * d.b + c.b * d.d,
        c: c.c * d.a + c.d * d.c,
        d: c.c * d.b + c.d * d.d,
        tx: c.tx * d.a + c.ty * d.c + d.tx,
        ty: c.tx * d.b + c.ty * d.d + d.ty
    }
};
cc.affineTransformConcatIn = function (c, d) {
    var e = c.a, f = c.b, g = c.c, h = c.d, k = c.tx, m = c.ty;
    c.a = e * d.a + f * d.c;
    c.b = e * d.b + f * d.d;
    c.c = g * d.a + h * d.c;
    c.d = g * d.b + h * d.d;
    c.tx = k * d.a + m * d.c + d.tx;
    c.ty = k * d.b + m * d.d + d.ty;
    return c
};
cc.affineTransformEqualToTransform = function (c, d) {
    return c.a === d.a && c.b === d.b && c.c === d.c && c.d === d.d && c.tx === d.tx && c.ty === d.ty
};
cc.affineTransformInvert = function (c) {
    var d = 1 / (c.a * c.d - c.b * c.c);
    return {
        a: d * c.d,
        b: -d * c.b,
        c: -d * c.c,
        d: d * c.a,
        tx: d * (c.c * c.ty - c.d * c.tx),
        ty: d * (c.b * c.tx - c.a * c.ty)
    }
};
cc.POINT_EPSILON = parseFloat("1.192092896e-07F");
cc.pNeg = function (c) {
    return cc.p(-c.x, -c.y)
};
cc.pAdd = function (c, d) {
    return cc.p(c.x + d.x, c.y + d.y)
};
cc.pSub = function (c, d) {
    return cc.p(c.x - d.x, c.y - d.y)
};
cc.pMult = function (c, d) {
    return cc.p(c.x * d, c.y * d)
};
cc.pMidpoint = function (c, d) {
    return cc.pMult(cc.pAdd(c, d), 0.5)
};
cc.pDot = function (c, d) {
    return c.x * d.x + c.y * d.y
};
cc.pCross = function (c, d) {
    return c.x * d.y - c.y * d.x
};
cc.pPerp = function (c) {
    return cc.p(-c.y, c.x)
};
cc.pRPerp = function (c) {
    return cc.p(c.y, -c.x)
};
cc.pProject = function (c, d) {
    return cc.pMult(d, cc.pDot(c, d) / cc.pDot(d, d))
};
cc.pRotate = function (c, d) {
    return cc.p(c.x * d.x - c.y * d.y, c.x * d.y + c.y * d.x)
};
cc.pUnrotate = function (c, d) {
    return cc.p(c.x * d.x + c.y * d.y, c.y * d.x - c.x * d.y)
};
cc.pLengthSQ = function (c) {
    return cc.pDot(c, c)
};
cc.pDistanceSQ = function (c, d) {
    return cc.pLengthSQ(cc.pSub(c, d))
};
cc.pLength = function (c) {
    return Math.sqrt(cc.pLengthSQ(c))
};
cc.pDistance = function (c, d) {
    return cc.pLength(cc.pSub(c, d))
};
cc.pNormalize = function (c) {
    var d = cc.pLength(c);
    return 0 === d ? cc.p(c) : cc.pMult(c, 1 / d)
};
cc.pForAngle = function (c) {
    return cc.p(Math.cos(c), Math.sin(c))
};
cc.pToAngle = function (c) {
    return Math.atan2(c.y, c.x)
};
cc.clampf = function (c, d, e) {
    if (d > e) {
        var f = d;
        d = e;
        e = f
    }
    return c < d ? d : c < e ? c : e
};
cc.pClamp = function (c, d, e) {
    return cc.p(cc.clampf(c.x, d.x, e.x), cc.clampf(c.y, d.y, e.y))
};
cc.pFromSize = function (c) {
    return cc.p(c.width, c.height)
};
cc.pCompOp = function (c, d) {
    return cc.p(d(c.x), d(c.y))
};
cc.pLerp = function (c, d, e) {
    return cc.pAdd(cc.pMult(c, 1 - e), cc.pMult(d, e))
};
cc.pFuzzyEqual = function (c, d, e) {
    return c.x - e <= d.x && d.x <= c.x + e && c.y - e <= d.y && d.y <= c.y + e ? !0 : !1
};
cc.pCompMult = function (c, d) {
    return cc.p(c.x * d.x, c.y * d.y)
};
cc.pAngleSigned = function (c, d) {
    var e = cc.pNormalize(c), f = cc.pNormalize(d), e = Math.atan2(e.x * f.y - e.y * f.x, cc.pDot(e, f));
    return Math.abs(e) < cc.POINT_EPSILON ? 0 : e
};
cc.pAngle = function (c, d) {
    var e = Math.acos(cc.pDot(cc.pNormalize(c), cc.pNormalize(d)));
    return Math.abs(e) < cc.POINT_EPSILON ? 0 : e
};
cc.pRotateByAngle = function (c, d, e) {
    c = cc.pSub(c, d);
    var f = Math.cos(e);
    e = Math.sin(e);
    var g = c.x;
    c.x = g * f - c.y * e + d.x;
    c.y = g * e + c.y * f + d.y;
    return c
};
cc.pLineIntersect = function (c, d, e, f, g) {
    if (c.x === d.x && c.y === d.y || e.x === f.x && e.y === f.y)return !1;
    var h = d.x - c.x;
    d = d.y - c.y;
    var k = f.x - e.x;
    f = f.y - e.y;
    var m = c.x - e.x;
    c = c.y - e.y;
    e = f * h - k * d;
    g.x = k * c - f * m;
    g.y = h * c - d * m;
    if (0 === e)return 0 === g.x || 0 === g.y ? !0 : !1;
    g.x /= e;
    g.y /= e;
    return !0
};
cc.pSegmentIntersect = function (c, d, e, f) {
    var g = cc.p(0, 0);
    return cc.pLineIntersect(c, d, e, f, g) && 0 <= g.x && 1 >= g.x && 0 <= g.y && 1 >= g.y ? !0 : !1
};
cc.pIntersectPoint = function (c, d, e, f) {
    var g = cc.p(0, 0);
    return cc.pLineIntersect(c, d, e, f, g) ? (e = cc.p(0, 0), e.x = c.x + g.x * (d.x - c.x), e.y = c.y + g.x * (d.y - c.y), e) : cc.p(0, 0)
};
cc.pSameAs = function (c, d) {
    return null != c && null != d ? c.x === d.x && c.y === d.y : !1
};
cc.pZeroIn = function (c) {
    c.x = 0;
    c.y = 0
};
cc.pIn = function (c, d) {
    c.x = d.x;
    c.y = d.y
};
cc.pMultIn = function (c, d) {
    c.x *= d;
    c.y *= d
};
cc.pSubIn = function (c, d) {
    c.x -= d.x;
    c.y -= d.y
};
cc.pAddIn = function (c, d) {
    c.x += d.x;
    c.y += d.y
};
cc.pNormalizeIn = function (c) {
    cc.pMultIn(c, 1 / Math.sqrt(c.x * c.x + c.y * c.y))
};
cc.vertexLineToPolygon = function (c, d, e, f, g) {
    g += f;
    if (!(1 >= g)) {
        d *= 0.5;
        for (var h, k = g - 1, m = f; m < g; m++) {
            h = 2 * m;
            var n = cc.p(c[2 * m], c[2 * m + 1]), p;
            if (0 === m)p = cc.pPerp(cc.pNormalize(cc.pSub(n, cc.p(c[2 * (m + 1)], c[2 * (m + 1) + 1])))); else if (m === k)p = cc.pPerp(cc.pNormalize(cc.pSub(cc.p(c[2 * (m - 1)], c[2 * (m - 1) + 1]), n))); else {
                p = cc.p(c[2 * (m - 1)], c[2 * (m - 1) + 1]);
                var r = cc.p(c[2 * (m + 1)], c[2 * (m + 1) + 1]), s = cc.pNormalize(cc.pSub(r, n)), v = cc.pNormalize(cc.pSub(p, n)), t = Math.acos(cc.pDot(s, v));
                p = t < cc.degreesToRadians(70) ? cc.pPerp(cc.pNormalize(cc.pMidpoint(s,
                    v))) : t < cc.degreesToRadians(170) ? cc.pNormalize(cc.pMidpoint(s, v)) : cc.pPerp(cc.pNormalize(cc.pSub(r, p)))
            }
            p = cc.pMult(p, d);
            e[2 * h] = n.x + p.x;
            e[2 * h + 1] = n.y + p.y;
            e[2 * (h + 1)] = n.x - p.x;
            e[2 * (h + 1) + 1] = n.y - p.y
        }
        for (m = 0 === f ? 0 : f - 1; m < k; m++)h = 2 * m, c = h + 2, d = cc.vertex2(e[2 * h], e[2 * h + 1]), g = cc.vertex2(e[2 * (h + 1)], e[2 * (h + 1) + 1]), h = cc.vertex2(e[2 * c], e[2 * c]), f = cc.vertex2(e[2 * (c + 1)], e[2 * (c + 1) + 1]), d = !cc.vertexLineIntersect(d.x, d.y, f.x, f.y, g.x, g.y, h.x, h.y), !d.isSuccess && (0 > d.value || 1 < d.value) && (d.isSuccess = !0), d.isSuccess && (e[2 * c] = f.x,
            e[2 * c + 1] = f.y, e[2 * (c + 1)] = h.x, e[2 * (c + 1) + 1] = h.y)
    }
};
cc.vertexLineIntersect = function (c, d, e, f, g, h, k, m) {
    if (c === e && d === f || g === k && h === m)return {isSuccess: !1, value: 0};
    e -= c;
    f -= d;
    g -= c;
    h -= d;
    k -= c;
    m -= d;
    c = Math.sqrt(e * e + f * f);
    e /= c;
    f /= c;
    d = g * e + h * f;
    h = h * e - g * f;
    g = d;
    d = k * e + m * f;
    m = m * e - k * f;
    k = d;
    return h === m ? {isSuccess: !1, value: 0} : {isSuccess: !0, value: (k + (g - k) * m / (m - h)) / c}
};
cc.vertexListIsClockwise = function (c) {
    for (var d = 0, e = c.length; d < e; d++) {
        var f = c[(d + 1) % e], g = c[(d + 2) % e];
        if (0 < cc.pCross(cc.pSub(f, c[d]), cc.pSub(g, f)))return !1
    }
    return !0
};
cc.CGAffineToGL = function (c, d) {
    d[2] = d[3] = d[6] = d[7] = d[8] = d[9] = d[11] = d[14] = 0;
    d[10] = d[15] = 1;
    d[0] = c.a;
    d[4] = c.c;
    d[12] = c.tx;
    d[1] = c.b;
    d[5] = c.d;
    d[13] = c.ty
};
cc.GLToCGAffine = function (c, d) {
    d.a = c[0];
    d.c = c[4];
    d.tx = c[12];
    d.b = c[1];
    d.d = c[5];
    d.ty = c[13]
};
cc.Touch = cc.Class.extend({
    _point: null, _prevPoint: null, _id: 0, _startPointCaptured: !1, _startPoint: null, ctor: function (c, d, e) {
        this.setTouchInfo(e, c, d)
    }, getLocation: function () {
        return {x: this._point.x, y: this._point.y}
    }, getLocationX: function () {
        return this._point.x
    }, getLocationY: function () {
        return this._point.y
    }, getPreviousLocation: function () {
        return {x: this._prevPoint.x, y: this._prevPoint.y}
    }, getStartLocation: function () {
        return {x: this._startPoint.x, y: this._startPoint.y}
    }, getDelta: function () {
        return cc.pSub(this._point,
            this._prevPoint)
    }, getLocationInView: function () {
        return {x: this._point.x, y: this._point.y}
    }, getPreviousLocationInView: function () {
        return {x: this._prevPoint.x, y: this._prevPoint.y}
    }, getStartLocationInView: function () {
        return {x: this._startPoint.x, y: this._startPoint.y}
    }, getID: function () {
        return this._id
    }, getId: function () {
        cc.log("getId is deprecated. Please use getID instead.");
        return this._id
    }, setTouchInfo: function (c, d, e) {
        this._prevPoint = this._point;
        this._point = cc.p(d || 0, e || 0);
        this._id = c;
        this._startPointCaptured ||
        (this._startPoint = cc.p(this._point), this._startPointCaptured = !0)
    }, _setPoint: function (c, d) {
        void 0 === d ? (this._point.x = c.x, this._point.y = c.y) : (this._point.x = c, this._point.y = d)
    }, _setPrevPoint: function (c, d) {
        this._prevPoint = void 0 === d ? cc.p(c.x, c.y) : cc.p(c || 0, d || 0)
    }
});
cc.Event = cc.Class.extend({
    _type: 0, _isStopped: !1, _currentTarget: null, _setCurrentTarget: function (c) {
        this._currentTarget = c
    }, ctor: function (c) {
        this._type = c
    }, getType: function () {
        return this._type
    }, stopPropagation: function () {
        this._isStopped = !0
    }, isStopped: function () {
        return this._isStopped
    }, getCurrentTarget: function () {
        return this._currentTarget
    }
});
cc.Event.TOUCH = 0;
cc.Event.KEYBOARD = 1;
cc.Event.ACCELERATION = 2;
cc.Event.MOUSE = 3;
cc.Event.FOCUS = 4;
cc.Event.CUSTOM = 6;
cc.EventCustom = cc.Event.extend({
    _eventName: null, _userData: null, ctor: function (c) {
        cc.Event.prototype.ctor.call(this, cc.Event.CUSTOM);
        this._eventName = c
    }, setUserData: function (c) {
        this._userData = c
    }, getUserData: function () {
        return this._userData
    }, getEventName: function () {
        return this._eventName
    }
});
cc.EventMouse = cc.Event.extend({
    _eventType: 0, _button: 0, _x: 0, _y: 0, _prevX: 0, _prevY: 0, _scrollX: 0, _scrollY: 0, ctor: function (c) {
        cc.Event.prototype.ctor.call(this, cc.Event.MOUSE);
        this._eventType = c
    }, setScrollData: function (c, d) {
        this._scrollX = c;
        this._scrollY = d
    }, getScrollX: function () {
        return this._scrollX
    }, getScrollY: function () {
        return this._scrollY
    }, setLocation: function (c, d) {
        this._x = c;
        this._y = d
    }, getLocation: function () {
        return {x: this._x, y: this._y}
    }, getLocationInView: function () {
        return {
            x: this._x, y: cc.view._designResolutionSize.height -
            this._y
        }
    }, _setPrevCursor: function (c, d) {
        this._prevX = c;
        this._prevY = d
    }, getDelta: function () {
        return {x: this._x - this._prevX, y: this._y - this._prevY}
    }, getDeltaX: function () {
        return this._x - this._prevX
    }, getDeltaY: function () {
        return this._y - this._prevY
    }, setButton: function (c) {
        this._button = c
    }, getButton: function () {
        return this._button
    }, getLocationX: function () {
        return this._x
    }, getLocationY: function () {
        return this._y
    }
});
cc.EventMouse.NONE = 0;
cc.EventMouse.DOWN = 1;
cc.EventMouse.UP = 2;
cc.EventMouse.MOVE = 3;
cc.EventMouse.SCROLL = 4;
cc.EventMouse.BUTTON_LEFT = 0;
cc.EventMouse.BUTTON_RIGHT = 2;
cc.EventMouse.BUTTON_MIDDLE = 1;
cc.EventMouse.BUTTON_4 = 3;
cc.EventMouse.BUTTON_5 = 4;
cc.EventMouse.BUTTON_6 = 5;
cc.EventMouse.BUTTON_7 = 6;
cc.EventMouse.BUTTON_8 = 7;
cc.EventTouch = cc.Event.extend({
    _eventCode: 0, _touches: null, ctor: function (c) {
        cc.Event.prototype.ctor.call(this, cc.Event.TOUCH);
        this._touches = c || []
    }, getEventCode: function () {
        return this._eventCode
    }, getTouches: function () {
        return this._touches
    }, _setEventCode: function (c) {
        this._eventCode = c
    }, _setTouches: function (c) {
        this._touches = c
    }
});
cc.EventTouch.MAX_TOUCHES = 5;
cc.EventTouch.EventCode = {BEGAN: 0, MOVED: 1, ENDED: 2, CANCELLED: 3};
cc.EventFocus = cc.Event.extend({
    _widgetGetFocus: null, _widgetLoseFocus: null, ctor: function (c, d) {
        cc.Event.prototype.ctor.call(this, cc.Event.FOCUS);
        this._widgetGetFocus = d;
        this._widgetLoseFocus = c
    }
});
cc.EventListener = cc.Class.extend({
    _onEvent: null,
    _type: 0,
    _listenerID: null,
    _registered: !1,
    _fixedPriority: 0,
    _node: null,
    _paused: !0,
    _isEnabled: !0,
    ctor: function (c, d, e) {
        this._onEvent = e;
        this._type = c || 0;
        this._listenerID = d || ""
    },
    _setPaused: function (c) {
        this._paused = c
    },
    _isPaused: function () {
        return this._paused
    },
    _setRegistered: function (c) {
        this._registered = c
    },
    _isRegistered: function () {
        return this._registered
    },
    _getType: function () {
        return this._type
    },
    _getListenerID: function () {
        return this._listenerID
    },
    _setFixedPriority: function (c) {
        this._fixedPriority =
            c
    },
    _getFixedPriority: function () {
        return this._fixedPriority
    },
    _setSceneGraphPriority: function (c) {
        this._node = c
    },
    _getSceneGraphPriority: function () {
        return this._node
    },
    checkAvailable: function () {
        return null !== this._onEvent
    },
    clone: function () {
        return null
    },
    setEnabled: function (c) {
        this._isEnabled = c
    },
    isEnabled: function () {
        return this._isEnabled
    },
    retain: function () {
    },
    release: function () {
    }
});
cc.EventListener.UNKNOWN = 0;
cc.EventListener.TOUCH_ONE_BY_ONE = 1;
cc.EventListener.TOUCH_ALL_AT_ONCE = 2;
cc.EventListener.KEYBOARD = 3;
cc.EventListener.MOUSE = 4;
cc.EventListener.ACCELERATION = 6;
cc.EventListener.FOCUS = 7;
cc.EventListener.CUSTOM = 8;
cc._EventListenerCustom = cc.EventListener.extend({
    _onCustomEvent: null, ctor: function (c, d) {
        this._onCustomEvent = d;
        var e = this;
        cc.EventListener.prototype.ctor.call(this, cc.EventListener.CUSTOM, c, function (c) {
            null !== e._onCustomEvent && e._onCustomEvent(c)
        })
    }, checkAvailable: function () {
        return cc.EventListener.prototype.checkAvailable.call(this) && null !== this._onCustomEvent
    }, clone: function () {
        return new cc._EventListenerCustom(this._listenerID, this._onCustomEvent)
    }
});
cc._EventListenerCustom.create = function (c, d) {
    return new cc._EventListenerCustom(c, d)
};
cc._EventListenerMouse = cc.EventListener.extend({
    onMouseDown: null, onMouseUp: null, onMouseMove: null, onMouseScroll: null, ctor: function () {
        var c = this;
        cc.EventListener.prototype.ctor.call(this, cc.EventListener.MOUSE, cc._EventListenerMouse.LISTENER_ID, function (d) {
            var e = cc.EventMouse;
            switch (d._eventType) {
                case e.DOWN:
                    if (c.onMouseDown)c.onMouseDown(d);
                    break;
                case e.UP:
                    if (c.onMouseUp)c.onMouseUp(d);
                    break;
                case e.MOVE:
                    if (c.onMouseMove)c.onMouseMove(d);
                    break;
                case e.SCROLL:
                    if (c.onMouseScroll)c.onMouseScroll(d)
            }
        })
    },
    clone: function () {
        var c = new cc._EventListenerMouse;
        c.onMouseDown = this.onMouseDown;
        c.onMouseUp = this.onMouseUp;
        c.onMouseMove = this.onMouseMove;
        c.onMouseScroll = this.onMouseScroll;
        return c
    }, checkAvailable: function () {
        return !0
    }
});
cc._EventListenerMouse.LISTENER_ID = "__cc_mouse";
cc._EventListenerMouse.create = function () {
    return new cc._EventListenerMouse
};
cc._EventListenerTouchOneByOne = cc.EventListener.extend({
    _claimedTouches: null,
    swallowTouches: !1,
    onTouchBegan: null,
    onTouchMoved: null,
    onTouchEnded: null,
    onTouchCancelled: null,
    ctor: function () {
        cc.EventListener.prototype.ctor.call(this, cc.EventListener.TOUCH_ONE_BY_ONE, cc._EventListenerTouchOneByOne.LISTENER_ID, null);
        this._claimedTouches = []
    },
    setSwallowTouches: function (c) {
        this.swallowTouches = c
    },
    isSwallowTouches: function () {
        return this.swallowTouches
    },
    clone: function () {
        var c = new cc._EventListenerTouchOneByOne;
        c.onTouchBegan = this.onTouchBegan;
        c.onTouchMoved = this.onTouchMoved;
        c.onTouchEnded = this.onTouchEnded;
        c.onTouchCancelled = this.onTouchCancelled;
        c.swallowTouches = this.swallowTouches;
        return c
    },
    checkAvailable: function () {
        return this.onTouchBegan ? !0 : (cc.log(cc._LogInfos._EventListenerTouchOneByOne_checkAvailable), !1)
    }
});
cc._EventListenerTouchOneByOne.LISTENER_ID = "__cc_touch_one_by_one";
cc._EventListenerTouchOneByOne.create = function () {
    return new cc._EventListenerTouchOneByOne
};
cc._EventListenerTouchAllAtOnce = cc.EventListener.extend({
    onTouchesBegan: null, onTouchesMoved: null, onTouchesEnded: null, onTouchesCancelled: null, ctor: function () {
        cc.EventListener.prototype.ctor.call(this, cc.EventListener.TOUCH_ALL_AT_ONCE, cc._EventListenerTouchAllAtOnce.LISTENER_ID, null)
    }, clone: function () {
        var c = new cc._EventListenerTouchAllAtOnce;
        c.onTouchesBegan = this.onTouchesBegan;
        c.onTouchesMoved = this.onTouchesMoved;
        c.onTouchesEnded = this.onTouchesEnded;
        c.onTouchesCancelled = this.onTouchesCancelled;
        return c
    },
    checkAvailable: function () {
        return null === this.onTouchesBegan && null === this.onTouchesMoved && null === this.onTouchesEnded && null === this.onTouchesCancelled ? (cc.log(cc._LogInfos._EventListenerTouchAllAtOnce_checkAvailable), !1) : !0
    }
});
cc._EventListenerTouchAllAtOnce.LISTENER_ID = "__cc_touch_all_at_once";
cc._EventListenerTouchAllAtOnce.create = function () {
    return new cc._EventListenerTouchAllAtOnce
};
cc.EventListener.create = function (c) {
    cc.assert(c && c.event, cc._LogInfos.EventListener_create);
    var d = c.event;
    delete c.event;
    var e = null;
    d === cc.EventListener.TOUCH_ONE_BY_ONE ? e = new cc._EventListenerTouchOneByOne : d === cc.EventListener.TOUCH_ALL_AT_ONCE ? e = new cc._EventListenerTouchAllAtOnce : d === cc.EventListener.MOUSE ? e = new cc._EventListenerMouse : d === cc.EventListener.CUSTOM ? (e = new cc._EventListenerCustom(c.eventName, c.callback), delete c.eventName, delete c.callback) : d === cc.EventListener.KEYBOARD ? e = new cc._EventListenerKeyboard :
        d === cc.EventListener.ACCELERATION ? (e = new cc._EventListenerAcceleration(c.callback), delete c.callback) : d === cc.EventListener.FOCUS && (e = new cc._EventListenerFocus);
    for (var f in c)e[f] = c[f];
    return e
};
cc._EventListenerFocus = cc.EventListener.extend({
    clone: function () {
        var c = new cc._EventListenerFocus;
        c.onFocusChanged = this.onFocusChanged;
        return c
    }, checkAvailable: function () {
        return this.onFocusChanged ? !0 : (cc.log("Invalid EventListenerFocus!"), !1)
    }, onFocusChanged: null, ctor: function () {
        cc.EventListener.prototype.ctor.call(this, cc.EventListener.FOCUS, cc._EventListenerFocus.LISTENER_ID, function (c) {
            if (this.onFocusChanged)this.onFocusChanged(c._widgetLoseFocus, c._widgetGetFocus)
        })
    }
});
cc._EventListenerFocus.LISTENER_ID = "__cc_focus_event";
cc._EventListenerVector = cc.Class.extend({
    _fixedListeners: null, _sceneGraphListeners: null, gt0Index: 0, ctor: function () {
        this._fixedListeners = [];
        this._sceneGraphListeners = []
    }, size: function () {
        return this._fixedListeners.length + this._sceneGraphListeners.length
    }, empty: function () {
        return 0 === this._fixedListeners.length && 0 === this._sceneGraphListeners.length
    }, push: function (c) {
        0 === c._getFixedPriority() ? this._sceneGraphListeners.push(c) : this._fixedListeners.push(c)
    }, clearSceneGraphListeners: function () {
        this._sceneGraphListeners.length =
            0
    }, clearFixedListeners: function () {
        this._fixedListeners.length = 0
    }, clear: function () {
        this._sceneGraphListeners.length = 0;
        this._fixedListeners.length = 0
    }, getFixedPriorityListeners: function () {
        return this._fixedListeners
    }, getSceneGraphPriorityListeners: function () {
        return this._sceneGraphListeners
    }
});
cc.__getListenerID = function (c) {
    var d = cc.Event, e = c.getType();
    if (e === d.ACCELERATION)return cc._EventListenerAcceleration.LISTENER_ID;
    if (e === d.CUSTOM)return c.getEventName();
    if (e === d.KEYBOARD)return cc._EventListenerKeyboard.LISTENER_ID;
    if (e === d.MOUSE)return cc._EventListenerMouse.LISTENER_ID;
    if (e === d.FOCUS)return cc._EventListenerFocus.LISTENER_ID;
    e === d.TOUCH && cc.log(cc._LogInfos.__getListenerID);
    return ""
};
cc.eventManager = {
    DIRTY_NONE: 0,
    DIRTY_FIXED_PRIORITY: 1,
    DIRTY_SCENE_GRAPH_PRIORITY: 2,
    DIRTY_ALL: 3,
    _listenersMap: {},
    _priorityDirtyFlagMap: {},
    _nodeListenersMap: {},
    _nodePriorityMap: {},
    _globalZOrderNodeMap: {},
    _toAddedListeners: [],
    _toRemovedListeners: [],
    _dirtyNodes: [],
    _inDispatch: 0,
    _isEnabled: !1,
    _nodePriorityIndex: 0,
    _internalCustomListenerIDs: [cc.game.EVENT_HIDE, cc.game.EVENT_SHOW],
    _setDirtyForNode: function (c) {
        null != this._nodeListenersMap[c.__instanceId] && this._dirtyNodes.push(c);
        c = c.getChildren();
        for (var d =
            0, e = c.length; d < e; d++)this._setDirtyForNode(c[d])
    },
    pauseTarget: function (c, d) {
        var e = this._nodeListenersMap[c.__instanceId], f, g;
        if (e)for (f = 0, g = e.length; f < g; f++)e[f]._setPaused(!0);
        if (!0 === d)for (e = c.getChildren(), f = 0, g = e.length; f < g; f++)this.pauseTarget(e[f], !0)
    },
    resumeTarget: function (c, d) {
        var e = this._nodeListenersMap[c.__instanceId], f, g;
        if (e)for (f = 0, g = e.length; f < g; f++)e[f]._setPaused(!1);
        this._setDirtyForNode(c);
        if (!0 === d)for (e = c.getChildren(), f = 0, g = e.length; f < g; f++)this.resumeTarget(e[f], !0)
    },
    _addListener: function (c) {
        0 ===
        this._inDispatch ? this._forceAddEventListener(c) : this._toAddedListeners.push(c)
    },
    _forceAddEventListener: function (c) {
        var d = c._getListenerID(), e = this._listenersMap[d];
        e || (e = new cc._EventListenerVector, this._listenersMap[d] = e);
        e.push(c);
        0 === c._getFixedPriority() ? (this._setDirty(d, this.DIRTY_SCENE_GRAPH_PRIORITY), d = c._getSceneGraphPriority(), null === d && cc.log(cc._LogInfos.eventManager__forceAddEventListener), this._associateNodeAndEventListener(d, c), d.isRunning() && this.resumeTarget(d)) : this._setDirty(d,
            this.DIRTY_FIXED_PRIORITY)
    },
    _getListeners: function (c) {
        return this._listenersMap[c]
    },
    _updateDirtyFlagForSceneGraph: function () {
        if (0 !== this._dirtyNodes.length) {
            for (var c = this._dirtyNodes, d, e, f = this._nodeListenersMap, g = 0, h = c.length; g < h; g++)if (d = f[c[g].__instanceId])for (var k = 0, m = d.length; k < m; k++)(e = d[k]) && this._setDirty(e._getListenerID(), this.DIRTY_SCENE_GRAPH_PRIORITY);
            this._dirtyNodes.length = 0
        }
    },
    _removeAllListenersInVector: function (c) {
        if (c)for (var d, e = 0; e < c.length;)d = c[e], d._setRegistered(!1), null !=
        d._getSceneGraphPriority() && (this._dissociateNodeAndEventListener(d._getSceneGraphPriority(), d), d._setSceneGraphPriority(null)), 0 === this._inDispatch ? cc.arrayRemoveObject(c, d) : ++e
    },
    _removeListenersForListenerID: function (c) {
        var d = this._listenersMap[c];
        if (d) {
            var e = d.getFixedPriorityListeners(), f = d.getSceneGraphPriorityListeners();
            this._removeAllListenersInVector(f);
            this._removeAllListenersInVector(e);
            delete this._priorityDirtyFlagMap[c];
            this._inDispatch || (d.clear(), delete this._listenersMap[c])
        }
        e = this._toAddedListeners;
        for (d = 0; d < e.length;)(f = e[d]) && f._getListenerID() === c ? cc.arrayRemoveObject(e, f) : ++d
    },
    _sortEventListeners: function (c) {
        var d = this.DIRTY_NONE, e = this._priorityDirtyFlagMap;
        e[c] && (d = e[c]);
        d !== this.DIRTY_NONE && (e[c] = this.DIRTY_NONE, d & this.DIRTY_FIXED_PRIORITY && this._sortListenersOfFixedPriority(c), d & this.DIRTY_SCENE_GRAPH_PRIORITY && ((d = cc.director.getRunningScene()) ? this._sortListenersOfSceneGraphPriority(c, d) : e[c] = this.DIRTY_SCENE_GRAPH_PRIORITY))
    },
    _sortListenersOfSceneGraphPriority: function (c, d) {
        var e =
            this._getListeners(c);
        if (e) {
            var f = e.getSceneGraphPriorityListeners();
            f && 0 !== f.length && (this._nodePriorityIndex = 0, this._nodePriorityMap = {}, this._visitTarget(d, !0), e.getSceneGraphPriorityListeners().sort(this._sortEventListenersOfSceneGraphPriorityDes))
        }
    },
    _sortEventListenersOfSceneGraphPriorityDes: function (c, d) {
        var e = cc.eventManager._nodePriorityMap, f = c._getSceneGraphPriority(), g = d._getSceneGraphPriority();
        return d && g && e[g.__instanceId] ? c && f && e[f.__instanceId] ? e[d._getSceneGraphPriority().__instanceId] -
        e[c._getSceneGraphPriority().__instanceId] : 1 : -1
    },
    _sortListenersOfFixedPriority: function (c) {
        if (c = this._listenersMap[c]) {
            var d = c.getFixedPriorityListeners();
            if (d && 0 !== d.length) {
                d.sort(this._sortListenersOfFixedPriorityAsc);
                for (var e = 0, f = d.length; e < f && !(0 <= d[e]._getFixedPriority());)++e;
                c.gt0Index = e
            }
        }
    },
    _sortListenersOfFixedPriorityAsc: function (c, d) {
        return c._getFixedPriority() - d._getFixedPriority()
    },
    _onUpdateListeners: function (c) {
        if (c = this._listenersMap[c]) {
            var d = c.getFixedPriorityListeners(), e = c.getSceneGraphPriorityListeners(),
                f, g, h = this._toRemovedListeners;
            if (e)for (f = 0; f < e.length;)g = e[f], g._isRegistered() ? ++f : (cc.arrayRemoveObject(e, g), g = h.indexOf(g), -1 !== g && h.splice(g, 1));
            if (d)for (f = 0; f < d.length;)g = d[f], g._isRegistered() ? ++f : (cc.arrayRemoveObject(d, g), g = h.indexOf(g), -1 !== g && h.splice(g, 1));
            e && 0 === e.length && c.clearSceneGraphListeners();
            d && 0 === d.length && c.clearFixedListeners()
        }
    },
    _updateListeners: function (c) {
        var d = this._inDispatch;
        cc.assert(0 < d, cc._LogInfos.EventManager__updateListeners);
        if (!(1 < d)) {
            c.getType() === cc.Event.TOUCH ?
                (this._onUpdateListeners(cc._EventListenerTouchOneByOne.LISTENER_ID), this._onUpdateListeners(cc._EventListenerTouchAllAtOnce.LISTENER_ID)) : this._onUpdateListeners(cc.__getListenerID(c));
            cc.assert(1 === d, cc._LogInfos.EventManager__updateListeners_2);
            c = this._listenersMap;
            var d = this._priorityDirtyFlagMap, e;
            for (e in c)c[e].empty() && (delete d[e], delete c[e]);
            e = this._toAddedListeners;
            if (0 !== e.length) {
                c = 0;
                for (d = e.length; c < d; c++)this._forceAddEventListener(e[c]);
                this._toAddedListeners.length = 0
            }
            0 !== this._toRemovedListeners.length &&
            this._cleanToRemovedListeners()
        }
    },
    _cleanToRemovedListeners: function () {
        for (var c = this._toRemovedListeners, d = 0; d < c.length; d++) {
            var e = c[d], f = this._listenersMap[e._getListenerID()];
            if (f) {
                var g = f.getFixedPriorityListeners(), h = f.getSceneGraphPriorityListeners();
                h && (f = h.indexOf(e), -1 !== f && h.splice(f, 1));
                g && (f = g.indexOf(e), -1 !== f && g.splice(f, 1))
            }
        }
        c.length = 0
    },
    _onTouchEventCallback: function (c, d) {
        if (!c._isRegistered)return !1;
        var e = d.event, f = d.selTouch;
        e._setCurrentTarget(c._node);
        var g = !1, h, k = e.getEventCode(),
            m = cc.EventTouch.EventCode;
        if (k === m.BEGAN)c.onTouchBegan && (g = c.onTouchBegan(f, e)) && c._registered && c._claimedTouches.push(f); else if (0 < c._claimedTouches.length && -1 !== (h = c._claimedTouches.indexOf(f)))if (g = !0, k === m.MOVED && c.onTouchMoved)c.onTouchMoved(f, e); else if (k === m.ENDED) {
            if (c.onTouchEnded)c.onTouchEnded(f, e);
            c._registered && c._claimedTouches.splice(h, 1)
        } else if (k === m.CANCELLED) {
            if (c.onTouchCancelled)c.onTouchCancelled(f, e);
            c._registered && c._claimedTouches.splice(h, 1)
        }
        return e.isStopped() ? (cc.eventManager._updateListeners(e),
            !0) : g && c._registered && c.swallowTouches ? (d.needsMutableSet && d.touches.splice(f, 1), !0) : !1
    },
    _dispatchTouchEvent: function (c) {
        this._sortEventListeners(cc._EventListenerTouchOneByOne.LISTENER_ID);
        this._sortEventListeners(cc._EventListenerTouchAllAtOnce.LISTENER_ID);
        var d = this._getListeners(cc._EventListenerTouchOneByOne.LISTENER_ID), e = this._getListeners(cc._EventListenerTouchAllAtOnce.LISTENER_ID);
        if (null !== d || null !== e) {
            var f = c.getTouches(), g = cc.copyArray(f), h = {
                event: c,
                needsMutableSet: d && e,
                touches: g,
                selTouch: null
            };
            if (d)for (var k = 0; k < f.length; k++)if (h.selTouch = f[k], this._dispatchEventToListeners(d, this._onTouchEventCallback, h), c.isStopped())return;
            if (e && 0 < g.length && (this._dispatchEventToListeners(e, this._onTouchesEventCallback, {
                    event: c,
                    touches: g
                }), c.isStopped()))return;
            this._updateListeners(c)
        }
    },
    _onTouchesEventCallback: function (c, d) {
        if (!c._registered)return !1;
        var e = cc.EventTouch.EventCode, f = d.event, g = d.touches, h = f.getEventCode();
        f._setCurrentTarget(c._node);
        if (h === e.BEGAN && c.onTouchesBegan)c.onTouchesBegan(g,
            f); else if (h === e.MOVED && c.onTouchesMoved)c.onTouchesMoved(g, f); else if (h === e.ENDED && c.onTouchesEnded)c.onTouchesEnded(g, f); else if (h === e.CANCELLED && c.onTouchesCancelled)c.onTouchesCancelled(g, f);
        return f.isStopped() ? (cc.eventManager._updateListeners(f), !0) : !1
    },
    _associateNodeAndEventListener: function (c, d) {
        var e = this._nodeListenersMap[c.__instanceId];
        e || (e = [], this._nodeListenersMap[c.__instanceId] = e);
        e.push(d)
    },
    _dissociateNodeAndEventListener: function (c, d) {
        var e = this._nodeListenersMap[c.__instanceId];
        e && (cc.arrayRemoveObject(e, d), 0 === e.length && delete this._nodeListenersMap[c.__instanceId])
    },
    _dispatchEventToListeners: function (c, d, e) {
        var f = !1, g = c.getFixedPriorityListeners(), h = c.getSceneGraphPriorityListeners(), k = 0, m;
        if (g && 0 !== g.length)for (; k < c.gt0Index; ++k)if (m = g[k], m.isEnabled() && !m._isPaused() && m._isRegistered() && d(m, e)) {
            f = !0;
            break
        }
        if (h && !f)for (c = 0; c < h.length; c++)if (m = h[c], m.isEnabled() && !m._isPaused() && m._isRegistered() && d(m, e)) {
            f = !0;
            break
        }
        if (g && !f)for (; k < g.length && (m = g[k], !m.isEnabled() || m._isPaused() || !m._isRegistered() || !d(m, e)); ++k);
    },
    _setDirty: function (c, d) {
        var e = this._priorityDirtyFlagMap;
        e[c] = null == e[c] ? d : d | e[c]
    },
    _visitTarget: function (c, d) {
        var e = c.getChildren(), f = 0, g = e.length, h = this._globalZOrderNodeMap, k = this._nodeListenersMap;
        if (0 < g) {
            for (var m; f < g; f++)if ((m = e[f]) && 0 > m.getLocalZOrder())this._visitTarget(m, !1); else break;
            null != k[c.__instanceId] && (h[c.getGlobalZOrder()] || (h[c.getGlobalZOrder()] = []), h[c.getGlobalZOrder()].push(c.__instanceId));
            for (; f < g; f++)(m = e[f]) && this._visitTarget(m, !1)
        } else null !=
        k[c.__instanceId] && (h[c.getGlobalZOrder()] || (h[c.getGlobalZOrder()] = []), h[c.getGlobalZOrder()].push(c.__instanceId));
        if (d) {
            var e = [], n;
            for (n in h)e.push(n);
            e.sort(this._sortNumberAsc);
            n = e.length;
            m = this._nodePriorityMap;
            for (f = 0; f < n; f++)for (g = h[e[f]], k = 0; k < g.length; k++)m[g[k]] = ++this._nodePriorityIndex;
            this._globalZOrderNodeMap = {}
        }
    },
    _sortNumberAsc: function (c, d) {
        return c - d
    },
    addListener: function (c, d) {
        cc.assert(c && d, cc._LogInfos.eventManager_addListener_2);
        if (!(c instanceof cc.EventListener))cc.assert(!cc.isNumber(d),
            cc._LogInfos.eventManager_addListener_3), c = cc.EventListener.create(c); else if (c._isRegistered()) {
            cc.log(cc._LogInfos.eventManager_addListener_4);
            return
        }
        if (c.checkAvailable()) {
            if (cc.isNumber(d)) {
                if (0 === d) {
                    cc.log(cc._LogInfos.eventManager_addListener);
                    return
                }
                c._setSceneGraphPriority(null);
                c._setFixedPriority(d);
                c._setRegistered(!0);
                c._setPaused(!1)
            } else c._setSceneGraphPriority(d), c._setFixedPriority(0), c._setRegistered(!0);
            this._addListener(c);
            return c
        }
    },
    addCustomListener: function (c, d) {
        var e = new cc._EventListenerCustom(c,
            d);
        this.addListener(e, 1);
        return e
    },
    removeListener: function (c) {
        if (null != c) {
            var d, e = this._listenersMap, f;
            for (f in e) {
                var g = e[f], h = g.getFixedPriorityListeners();
                d = g.getSceneGraphPriorityListeners();
                (d = this._removeListenerInVector(d, c)) ? this._setDirty(c._getListenerID(), this.DIRTY_SCENE_GRAPH_PRIORITY) : (d = this._removeListenerInVector(h, c)) && this._setDirty(c._getListenerID(), this.DIRTY_FIXED_PRIORITY);
                g.empty() && (delete this._priorityDirtyFlagMap[c._getListenerID()], delete e[f]);
                if (d)break
            }
            if (!d)for (e =
                            this._toAddedListeners, f = 0, g = e.length; f < g; f++)if (h = e[f], h === c) {
                cc.arrayRemoveObject(e, h);
                h._setRegistered(!1);
                break
            }
        }
    },
    _removeListenerInCallback: function (c, d) {
        if (null == c)return !1;
        for (var e = 0, f = c.length; e < f; e++) {
            var g = c[e];
            if (g._onCustomEvent === d || g._onEvent === d)return g._setRegistered(!1), null != g._getSceneGraphPriority() && (this._dissociateNodeAndEventListener(g._getSceneGraphPriority(), g), g._setSceneGraphPriority(null)), 0 === this._inDispatch && cc.arrayRemoveObject(c, g), !0
        }
        return !1
    },
    _removeListenerInVector: function (c,
                                       d) {
        if (null == c)return !1;
        for (var e = 0, f = c.length; e < f; e++) {
            var g = c[e];
            if (g === d)return g._setRegistered(!1), null != g._getSceneGraphPriority() && (this._dissociateNodeAndEventListener(g._getSceneGraphPriority(), g), g._setSceneGraphPriority(null)), 0 === this._inDispatch ? cc.arrayRemoveObject(c, g) : this._toRemovedListeners.push(g), !0
        }
        return !1
    },
    removeListeners: function (c, d) {
        if (c instanceof cc.Node) {
            delete this._nodePriorityMap[c.__instanceId];
            cc.arrayRemoveObject(this._dirtyNodes, c);
            var e = this._nodeListenersMap[c.__instanceId];
            if (e) {
                for (var f = cc.copyArray(e), e = 0; e < f.length; e++)this.removeListener(f[e]);
                f.length = 0
            }
            f = this._toAddedListeners;
            for (e = 0; e < f.length;) {
                var g = f[e];
                g._getSceneGraphPriority() === c ? (g._setSceneGraphPriority(null), g._setRegistered(!1), f.splice(e, 1)) : ++e
            }
            if (!0 === d)for (f = c.getChildren(), e = 0, g = f.length; e < g; e++)this.removeListeners(f[e], !0)
        } else c === cc.EventListener.TOUCH_ONE_BY_ONE ? this._removeListenersForListenerID(cc._EventListenerTouchOneByOne.LISTENER_ID) : c === cc.EventListener.TOUCH_ALL_AT_ONCE ? this._removeListenersForListenerID(cc._EventListenerTouchAllAtOnce.LISTENER_ID) :
            c === cc.EventListener.MOUSE ? this._removeListenersForListenerID(cc._EventListenerMouse.LISTENER_ID) : c === cc.EventListener.ACCELERATION ? this._removeListenersForListenerID(cc._EventListenerAcceleration.LISTENER_ID) : c === cc.EventListener.KEYBOARD ? this._removeListenersForListenerID(cc._EventListenerKeyboard.LISTENER_ID) : cc.log(cc._LogInfos.eventManager_removeListeners)
    },
    removeCustomListeners: function (c) {
        this._removeListenersForListenerID(c)
    },
    removeAllListeners: function () {
        var c = this._listenersMap, d = this._internalCustomListenerIDs,
            e;
        for (e in c)-1 === d.indexOf(e) && this._removeListenersForListenerID(e)
    },
    setPriority: function (c, d) {
        if (null != c) {
            var e = this._listenersMap, f;
            for (f in e) {
                var g = e[f].getFixedPriorityListeners();
                if (g && -1 !== g.indexOf(c)) {
                    null != c._getSceneGraphPriority() && cc.log(cc._LogInfos.eventManager_setPriority);
                    c._getFixedPriority() !== d && (c._setFixedPriority(d), this._setDirty(c._getListenerID(), this.DIRTY_FIXED_PRIORITY));
                    break
                }
            }
        }
    },
    setEnabled: function (c) {
        this._isEnabled = c
    },
    isEnabled: function () {
        return this._isEnabled
    },
    dispatchEvent: function (c) {
        if (this._isEnabled) {
            this._updateDirtyFlagForSceneGraph();
            this._inDispatch++;
            if (!c || !c.getType)throw Error("event is undefined");
            if (c.getType() === cc.Event.TOUCH)this._dispatchTouchEvent(c); else {
                var d = cc.__getListenerID(c);
                this._sortEventListeners(d);
                d = this._listenersMap[d];
                null != d && this._dispatchEventToListeners(d, this._onListenerCallback, c);
                this._updateListeners(c)
            }
            this._inDispatch--
        }
    },
    _onListenerCallback: function (c, d) {
        d._setCurrentTarget(c._getSceneGraphPriority());
        c._onEvent(d);
        return d.isStopped()
    },
    dispatchCustomEvent: function (c, d) {
        var e = new cc.EventCustom(c);
        e.setUserData(d);
        this.dispatchEvent(e)
    }
};
cc.EventAcceleration = cc.Event.extend({
    _acc: null, ctor: function (c) {
        cc.Event.prototype.ctor.call(this, cc.Event.ACCELERATION);
        this._acc = c
    }
});
cc.EventKeyboard = cc.Event.extend({
    _keyCode: 0, _isPressed: !1, ctor: function (c, d) {
        cc.Event.prototype.ctor.call(this, cc.Event.KEYBOARD);
        this._keyCode = c;
        this._isPressed = d
    }
});
cc._EventListenerAcceleration = cc.EventListener.extend({
    _onAccelerationEvent: null, ctor: function (c) {
        this._onAccelerationEvent = c;
        var d = this;
        cc.EventListener.prototype.ctor.call(this, cc.EventListener.ACCELERATION, cc._EventListenerAcceleration.LISTENER_ID, function (c) {
            d._onAccelerationEvent(c._acc, c)
        })
    }, checkAvailable: function () {
        cc.assert(this._onAccelerationEvent, cc._LogInfos._EventListenerAcceleration_checkAvailable);
        return !0
    }, clone: function () {
        return new cc._EventListenerAcceleration(this._onAccelerationEvent)
    }
});
cc._EventListenerAcceleration.LISTENER_ID = "__cc_acceleration";
cc._EventListenerAcceleration.create = function (c) {
    return new cc._EventListenerAcceleration(c)
};
cc._EventListenerKeyboard = cc.EventListener.extend({
    onKeyPressed: null, onKeyReleased: null, ctor: function () {
        var c = this;
        cc.EventListener.prototype.ctor.call(this, cc.EventListener.KEYBOARD, cc._EventListenerKeyboard.LISTENER_ID, function (d) {
            if (d._isPressed) {
                if (c.onKeyPressed)c.onKeyPressed(d._keyCode, d)
            } else if (c.onKeyReleased)c.onKeyReleased(d._keyCode, d)
        })
    }, clone: function () {
        var c = new cc._EventListenerKeyboard;
        c.onKeyPressed = this.onKeyPressed;
        c.onKeyReleased = this.onKeyReleased;
        return c
    }, checkAvailable: function () {
        return null ===
        this.onKeyPressed && null === this.onKeyReleased ? (cc.log(cc._LogInfos._EventListenerKeyboard_checkAvailable), !1) : !0
    }
});
cc._EventListenerKeyboard.LISTENER_ID = "__cc_keyboard";
cc._EventListenerKeyboard.create = function () {
    return new cc._EventListenerKeyboard
};
cc.rendererCanvas = {
    childrenOrderDirty: !0,
    assignedZ: 0,
    assignedZStep: 1E-4,
    _transformNodePool: [],
    _renderCmds: [],
    _isCacheToCanvasOn: !1,
    _cacheToCanvasCmds: {},
    _cacheInstanceIds: [],
    _currentID: 0,
    _clearColor: cc.color(),
    _clearFillStyle: "rgb(0, 0, 0)",
    getRenderCmd: function (c) {
        return c._createRenderCmd()
    },
    rendering: function (c) {
        var d = this._renderCmds, e, f = cc.view.getScaleX(), g = cc.view.getScaleY(), h = c || cc._renderContext;
        h.computeRealOffsetY();
        c = 0;
        for (e = d.length; c < e; c++)d[c].rendering(h, f, g)
    },
    _renderingToCacheCanvas: function (c,
                                       d, e, f) {
        c || cc.log("The context of RenderTexture is invalid.");
        e = cc.isUndefined(e) ? 1 : e;
        f = cc.isUndefined(f) ? 1 : f;
        d = d || this._currentID;
        var g = this._cacheToCanvasCmds[d], h, k;
        c.computeRealOffsetY();
        h = 0;
        for (k = g.length; h < k; h++)g[h].rendering(c, e, f);
        this._removeCache(d);
        c = this._cacheInstanceIds;
        0 === c.length ? this._isCacheToCanvasOn = !1 : this._currentID = c[c.length - 1]
    },
    _turnToCacheMode: function (c) {
        this._isCacheToCanvasOn = !0;
        c = c || 0;
        this._cacheToCanvasCmds[c] = [];
        -1 === this._cacheInstanceIds.indexOf(c) && this._cacheInstanceIds.push(c);
        this._currentID = c
    },
    _turnToNormalMode: function () {
        this._isCacheToCanvasOn = !1
    },
    _removeCache: function (c) {
        c = c || this._currentID;
        var d = this._cacheToCanvasCmds[c];
        d && (d.length = 0, delete this._cacheToCanvasCmds[c]);
        cc.arrayRemoveObject(this._cacheInstanceIds, c)
    },
    resetFlag: function () {
        this.childrenOrderDirty = !1;
        this._transformNodePool.length = 0
    },
    transform: function () {
        var c = this._transformNodePool;
        c.sort(this._sortNodeByLevelAsc);
        for (var d = 0, e = c.length; d < e; d++)0 !== c[d]._dirtyFlag && c[d].updateStatus();
        c.length = 0
    },
    transformDirty: function () {
        return 0 < this._transformNodePool.length
    },
    _sortNodeByLevelAsc: function (c, d) {
        return c._curLevel - d._curLevel
    },
    pushDirtyNode: function (c) {
        this._transformNodePool.push(c)
    },
    clear: function () {
        var c = cc._canvas, d = cc._renderContext, e = d.getContext();
        e.setTransform(1, 0, 0, 1, 0, 0);
        e.clearRect(0, 0, c.width, c.height);
        if (0 !== this._clearColor.r || 0 !== this._clearColor.g || 0 !== this._clearColor.b)d.setFillStyle(this._clearFillStyle), d.setGlobalAlpha(this._clearColor.a), e.fillRect(0, 0, c.width, c.height)
    },
    clearRenderCommands: function () {
        this._renderCmds.length = 0;
        this._cacheInstanceIds.length = 0;
        this._isCacheToCanvasOn = !1
    },
    pushRenderCommand: function (c) {
        if (c.needDraw())if (this._isCacheToCanvasOn) {
            var d = this._cacheToCanvasCmds[this._currentID];
            -1 === d.indexOf(c) && d.push(c)
        } else-1 === this._renderCmds.indexOf(c) && this._renderCmds.push(c)
    }
};
(function () {
    cc.CanvasContextWrapper = function (c) {
        this._context = c;
        this._saveCount = 0;
        this._currentAlpha = c.globalAlpha;
        this._currentCompositeOperation = c.globalCompositeOperation;
        this._currentFillStyle = c.fillStyle;
        this._currentStrokeStyle = c.strokeStyle;
        this._offsetY = this._offsetX = 0;
        this._realOffsetY = this.height;
        this._armatureMode = 0
    };
    var c = cc.CanvasContextWrapper.prototype;
    c.resetCache = function () {
        var c = this._context;
        this._currentAlpha = c.globalAlpha;
        this._currentCompositeOperation = c.globalCompositeOperation;
        this._currentFillStyle = c.fillStyle;
        this._currentStrokeStyle = c.strokeStyle;
        this._realOffsetY = this._context.canvas.height + this._offsetY
    };
    c.setOffset = function (c, e) {
        this._offsetX = c;
        this._offsetY = e;
        this._realOffsetY = this._context.canvas.height + this._offsetY
    };
    c.computeRealOffsetY = function () {
        this._realOffsetY = this._context.canvas.height + this._offsetY
    };
    c.setViewScale = function (c, e) {
        this._scaleX = c;
        this._scaleY = e
    };
    c.getContext = function () {
        return this._context
    };
    c.save = function () {
        this._context.save();
        this._saveCount++
    };
    c.restore = function () {
        this._context.restore();
        this._saveCount--
    };
    c.setGlobalAlpha = function (c) {
        0 < this._saveCount ? this._context.globalAlpha = c : this._currentAlpha !== c && (this._currentAlpha = c, this._context.globalAlpha = c)
    };
    c.setCompositeOperation = function (c) {
        0 < this._saveCount ? this._context.globalCompositeOperation = c : this._currentCompositeOperation !== c && (this._currentCompositeOperation = c, this._context.globalCompositeOperation = c)
    };
    c.setFillStyle = function (c) {
        0 < this._saveCount ? this._context.fillStyle = c : this._currentFillStyle !==
        c && (this._currentFillStyle = c, this._context.fillStyle = c)
    };
    c.setStrokeStyle = function (c) {
        0 < this._saveCount ? this._context.strokeStyle = c : this._currentStrokeStyle !== c && (this._currentStrokeStyle = c, this._context.strokeStyle = c)
    };
    c.setTransform = function (c, e, f) {
        0 < this._armatureMode ? (this.restore(), this.save(), this._context.transform(c.a, -c.b, -c.c, c.d, c.tx * e, -(c.ty * f))) : this._context.setTransform(c.a, -c.b, -c.c, c.d, this._offsetX + c.tx * e, this._realOffsetY - c.ty * f)
    };
    c._switchToArmatureMode = function (c, e, f, g) {
        c ? (this._armatureMode++,
            this._context.setTransform(e.a, e.c, e.b, e.d, this._offsetX + e.tx * f, this._realOffsetY - e.ty * g), this.save()) : (this._armatureMode--, this.restore())
    }
})();
cc.rendererWebGL = function () {
    var c = {
        texture: null,
        blendSrc: null,
        blendDst: null,
        shader: null
    }, d = null, e = null, f = 0, g = 0, h = null, k = 0, m = null, n = null;
    return {
        mat4Identity: null,
        childrenOrderDirty: !0,
        assignedZ: 0,
        assignedZStep: 0.01,
        _transformNodePool: [],
        _renderCmds: [],
        _isCacheToBufferOn: !1,
        _cacheToBufferCmds: {},
        _cacheInstanceIds: [],
        _currentID: 0,
        _clearColor: cc.color("#FFFFFF"),
        init: function () {
            var c = cc._renderContext;
            c.disable(c.CULL_FACE);
            c.disable(c.DEPTH_TEST);
            this.mat4Identity = new cc.math.Matrix4;
            this.mat4Identity.identity();
            c = cc._renderContext;
            null === d && (e = c.createBuffer(), d = c.createBuffer());
            c = cc._renderContext;
            if (d) {
                c.bindBuffer(c.ELEMENT_ARRAY_BUFFER, d);
                for (var g = new Uint16Array(12E3), s = 0, v = 0; 12E3 > v; v += 6)g[v] = s + 0, g[v + 1] = s + 1, g[v + 2] = s + 2, g[v + 3] = s + 1, g[v + 4] = s + 2, g[v + 5] = s + 3, s += 4;
                c.bufferData(c.ELEMENT_ARRAY_BUFFER, g, c.STATIC_DRAW)
            }
            e && (k = 48E3, h = new ArrayBuffer(4 * k), m = new Float32Array(h), n = new Uint32Array(h), c.bindBuffer(c.ARRAY_BUFFER, e), c.bufferData(c.ARRAY_BUFFER, m, c.DYNAMIC_DRAW));
            f = 8E3
        },
        getVertexSize: function () {
            return f
        },
        getRenderCmd: function (c) {
            return c._createRenderCmd()
        },
        _turnToCacheMode: function (c) {
            this._isCacheToBufferOn = !0;
            c = c || 0;
            this._cacheToBufferCmds[c] ? this._cacheToBufferCmds[c].length = 0 : this._cacheToBufferCmds[c] = [];
            -1 === this._cacheInstanceIds.indexOf(c) && this._cacheInstanceIds.push(c);
            this._currentID = c
        },
        _turnToNormalMode: function () {
            this._isCacheToBufferOn = !1
        },
        _removeCache: function (c) {
            c = c || this._currentID;
            var d = this._cacheToBufferCmds[c];
            d && (d.length = 0, delete this._cacheToBufferCmds[c]);
            cc.arrayRemoveObject(this._cacheInstanceIds,
                c)
        },
        _renderingToBuffer: function (c) {
            c = c || this._currentID;
            this.rendering(cc._renderContext, this._cacheToBufferCmds[c]);
            this._removeCache(c);
            c = this._cacheInstanceIds;
            0 === c.length ? this._isCacheToBufferOn = !1 : this._currentID = c[c.length - 1]
        },
        resetFlag: function () {
            this.childrenOrderDirty && (this.childrenOrderDirty = !1);
            this._transformNodePool.length = 0
        },
        transform: function () {
            var c = this._transformNodePool;
            c.sort(this._sortNodeByLevelAsc);
            var d, e, f;
            d = 0;
            for (e = c.length; d < e; d++)f = c[d], f.updateStatus();
            c.length = 0
        },
        transformDirty: function () {
            return 0 <
                this._transformNodePool.length
        },
        _sortNodeByLevelAsc: function (c, d) {
            return c._curLevel - d._curLevel
        },
        pushDirtyNode: function (c) {
            this._transformNodePool.push(c)
        },
        clearRenderCommands: function () {
            this._renderCmds.length = 0
        },
        clear: function () {
            var c = cc._renderContext;
            c.clearColor(this._clearColor.r, this._clearColor.g, this._clearColor.b, this._clearColor.a);
            c.clear(c.COLOR_BUFFER_BIT | c.DEPTH_BUFFER_BIT)
        },
        setDepthTest: function (c) {
            var d = cc._renderContext;
            c ? (d.clearDepth(1), d.enable(d.DEPTH_TEST), d.depthFunc(d.LEQUAL)) :
                d.disable(d.DEPTH_TEST)
        },
        pushRenderCommand: function (c) {
            if (c.needDraw())if (this._isCacheToBufferOn) {
                var d = this._cacheToBufferCmds[this._currentID];
                -1 === d.indexOf(c) && d.push(c)
            } else-1 === this._renderCmds.indexOf(c) && this._renderCmds.push(c)
        },
        _increaseBatchingSize: function (c) {
            g += c
        },
        _uploadBufferData: function (d) {
            g >= f && this._batchRendering();
            var e = d._node._texture, h = d._node._blendFunc.src, k = d._node._blendFunc.dst, t = d._shaderProgram;
            if (c.texture !== e || c.blendSrc !== h || c.blendDst !== k || c.shader !== t)this._batchRendering(),
                c.texture = e, c.blendSrc = h, c.blendDst = k, c.shader = t;
            d = d.uploadData(m, n, 6 * g);
            0 < d && (g += d)
        },
        _batchRendering: function () {
            if (0 !== g && c.texture) {
                var h = cc._renderContext, k = c.texture, n = c.shader, v = g / 4;
                n && (n.use(), n._updateProjectionUniform());
                cc.glBlendFunc(c.blendSrc, c.blendDst);
                cc.glBindTexture2DN(0, k);
                k = !h.bindBuffer(h.ARRAY_BUFFER, e);
                g > 0.5 * f ? h.bufferData(h.ARRAY_BUFFER, m, h.DYNAMIC_DRAW) : (n = m.subarray(0, 6 * g), h.bufferData(h.ARRAY_BUFFER, n, h.DYNAMIC_DRAW));
                k && (h.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION),
                    h.enableVertexAttribArray(cc.VERTEX_ATTRIB_COLOR), h.enableVertexAttribArray(cc.VERTEX_ATTRIB_TEX_COORDS), h.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 3, h.FLOAT, !1, 24, 0), h.vertexAttribPointer(cc.VERTEX_ATTRIB_COLOR, 4, h.UNSIGNED_BYTE, !0, 24, 12), h.vertexAttribPointer(cc.VERTEX_ATTRIB_TEX_COORDS, 2, h.FLOAT, !1, 24, 16));
                h.bindBuffer(h.ELEMENT_ARRAY_BUFFER, d);
                h.drawElements(h.TRIANGLES, 6 * v, h.UNSIGNED_SHORT, 0);
                cc.g_NumberOfDraws++;
                g = 0
            }
        },
        rendering: function (d, e) {
            var f = e || this._renderCmds, h, k, m, n = d || cc._renderContext;
            n.bindBuffer(gl.ARRAY_BUFFER, null);
            h = 0;
            for (k = f.length; h < k; ++h)m = f[h], m.uploadData ? this._uploadBufferData(m) : (0 < g && this._batchRendering(), m.rendering(n));
            this._batchRendering();
            c.texture = null
        }
    }
}();
cc._tmp.PrototypeCCNode = function () {
    var c = cc.Node.prototype;
    cc.defineGetterSetter(c, "x", c.getPositionX, c.setPositionX);
    cc.defineGetterSetter(c, "y", c.getPositionY, c.setPositionY);
    cc.defineGetterSetter(c, "width", c._getWidth, c._setWidth);
    cc.defineGetterSetter(c, "height", c._getHeight, c._setHeight);
    cc.defineGetterSetter(c, "anchorX", c._getAnchorX, c._setAnchorX);
    cc.defineGetterSetter(c, "anchorY", c._getAnchorY, c._setAnchorY);
    cc.defineGetterSetter(c, "skewX", c.getSkewX, c.setSkewX);
    cc.defineGetterSetter(c, "skewY",
        c.getSkewY, c.setSkewY);
    cc.defineGetterSetter(c, "zIndex", c.getLocalZOrder, c.setLocalZOrder);
    cc.defineGetterSetter(c, "vertexZ", c.getVertexZ, c.setVertexZ);
    cc.defineGetterSetter(c, "rotation", c.getRotation, c.setRotation);
    cc.defineGetterSetter(c, "rotationX", c.getRotationX, c.setRotationX);
    cc.defineGetterSetter(c, "rotationY", c.getRotationY, c.setRotationY);
    cc.defineGetterSetter(c, "scale", c.getScale, c.setScale);
    cc.defineGetterSetter(c, "scaleX", c.getScaleX, c.setScaleX);
    cc.defineGetterSetter(c, "scaleY", c.getScaleY,
        c.setScaleY);
    cc.defineGetterSetter(c, "children", c.getChildren);
    cc.defineGetterSetter(c, "childrenCount", c.getChildrenCount);
    cc.defineGetterSetter(c, "parent", c.getParent, c.setParent);
    cc.defineGetterSetter(c, "visible", c.isVisible, c.setVisible);
    cc.defineGetterSetter(c, "running", c.isRunning);
    cc.defineGetterSetter(c, "ignoreAnchor", c.isIgnoreAnchorPointForPosition, c.ignoreAnchorPointForPosition);
    cc.defineGetterSetter(c, "actionManager", c.getActionManager, c.setActionManager);
    cc.defineGetterSetter(c, "scheduler",
        c.getScheduler, c.setScheduler);
    cc.defineGetterSetter(c, "shaderProgram", c.getShaderProgram, c.setShaderProgram);
    cc.defineGetterSetter(c, "opacity", c.getOpacity, c.setOpacity);
    cc.defineGetterSetter(c, "opacityModifyRGB", c.isOpacityModifyRGB);
    cc.defineGetterSetter(c, "cascadeOpacity", c.isCascadeOpacityEnabled, c.setCascadeOpacityEnabled);
    cc.defineGetterSetter(c, "color", c.getColor, c.setColor);
    cc.defineGetterSetter(c, "cascadeColor", c.isCascadeColorEnabled, c.setCascadeColorEnabled)
};
cc.NODE_TAG_INVALID = -1;
cc.s_globalOrderOfArrival = 1;
cc.Node = cc.Class.extend({
    _localZOrder: 0,
    _globalZOrder: 0,
    _vertexZ: 0,
    _customZ: NaN,
    _rotationX: 0,
    _rotationY: 0,
    _scaleX: 1,
    _scaleY: 1,
    _position: null,
    _normalizedPosition: null,
    _usingNormalizedPosition: !1,
    _normalizedPositionDirty: !1,
    _skewX: 0,
    _skewY: 0,
    _children: null,
    _visible: !0,
    _anchorPoint: null,
    _contentSize: null,
    _running: !1,
    _parent: null,
    _ignoreAnchorPointForPosition: !1,
    tag: cc.NODE_TAG_INVALID,
    userData: null,
    userObject: null,
    _reorderChildDirty: !1,
    _shaderProgram: null,
    arrivalOrder: 0,
    _actionManager: null,
    _scheduler: null,
    _eventDispatcher: null,
    _additionalTransformDirty: !1,
    _additionalTransform: null,
    _componentContainer: null,
    _isTransitionFinished: !1,
    _className: "Node",
    _showNode: !1,
    _name: "",
    _realOpacity: 255,
    _realColor: null,
    _cascadeColorEnabled: !1,
    _cascadeOpacityEnabled: !1,
    _renderCmd: null,
    ctor: function () {
        this._initNode();
        this._initRendererCmd()
    },
    _initNode: function () {
        this._anchorPoint = cc.p(0, 0);
        this._contentSize = cc.size(0, 0);
        this._position = cc.p(0, 0);
        this._normalizedPosition = cc.p(0, 0);
        this._children = [];
        var c = cc.director;
        this._actionManager =
            c.getActionManager();
        this._scheduler = c.getScheduler();
        this._additionalTransform = cc.affineTransformMakeIdentity();
        cc.ComponentContainer && (this._componentContainer = new cc.ComponentContainer(this));
        this._realOpacity = 255;
        this._realColor = cc.color(255, 255, 255, 255);
        this._cascadeOpacityEnabled = this._cascadeColorEnabled = !1
    },
    init: function () {
        return !0
    },
    _arrayMakeObjectsPerformSelector: function (c, d) {
        if (c && 0 !== c.length) {
            var e, f = c.length, g;
            e = cc.Node._stateCallbackType;
            switch (d) {
                case e.onEnter:
                    for (e = 0; e < f; e++)if (g =
                            c[e])g.onEnter();
                    break;
                case e.onExit:
                    for (e = 0; e < f; e++)if (g = c[e])g.onExit();
                    break;
                case e.onEnterTransitionDidFinish:
                    for (e = 0; e < f; e++)if (g = c[e])g.onEnterTransitionDidFinish();
                    break;
                case e.cleanup:
                    for (e = 0; e < f; e++)(g = c[e]) && g.cleanup();
                    break;
                case e.updateTransform:
                    for (e = 0; e < f; e++)(g = c[e]) && g.updateTransform();
                    break;
                case e.onExitTransitionDidStart:
                    for (e = 0; e < f; e++)if (g = c[e])g.onExitTransitionDidStart();
                    break;
                case e.sortAllChildren:
                    for (e = 0; e < f; e++)(g = c[e]) && g.sortAllChildren();
                    break;
                default:
                    cc.assert(0, cc._LogInfos.Node__arrayMakeObjectsPerformSelector)
            }
        }
    },
    attr: function (c) {
        for (var d in c)this[d] = c[d]
    },
    getSkewX: function () {
        return this._skewX
    },
    setSkewX: function (c) {
        this._skewX = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    getSkewY: function () {
        return this._skewY
    },
    setSkewY: function (c) {
        this._skewY = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    setLocalZOrder: function (c) {
        this._localZOrder = c;
        this._parent && this._parent.reorderChild(this, c);
        cc.eventManager._setDirtyForNode(this)
    },
    _setLocalZOrder: function (c) {
        this._localZOrder =
            c
    },
    getLocalZOrder: function () {
        return this._localZOrder
    },
    getZOrder: function () {
        cc.log(cc._LogInfos.Node_getZOrder);
        return this.getLocalZOrder()
    },
    setZOrder: function (c) {
        cc.log(cc._LogInfos.Node_setZOrder);
        this.setLocalZOrder(c)
    },
    setGlobalZOrder: function (c) {
        this._globalZOrder !== c && (this._globalZOrder = c, cc.eventManager._setDirtyForNode(this))
    },
    getGlobalZOrder: function () {
        return this._globalZOrder
    },
    getVertexZ: function () {
        return this._vertexZ
    },
    setVertexZ: function (c) {
        this._customZ = this._vertexZ = c
    },
    getRotation: function () {
        this._rotationX !==
        this._rotationY && cc.log(cc._LogInfos.Node_getRotation);
        return this._rotationX
    },
    setRotation: function (c) {
        this._rotationX = this._rotationY = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    getRotationX: function () {
        return this._rotationX
    },
    setRotationX: function (c) {
        this._rotationX = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    getRotationY: function () {
        return this._rotationY
    },
    setRotationY: function (c) {
        this._rotationY = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    getScale: function () {
        this._scaleX !== this._scaleY && cc.log(cc._LogInfos.Node_getScale);
        return this._scaleX
    },
    setScale: function (c, d) {
        this._scaleX = c;
        this._scaleY = d || 0 === d ? d : c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    getScaleX: function () {
        return this._scaleX
    },
    setScaleX: function (c) {
        this._scaleX = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    getScaleY: function () {
        return this._scaleY
    },
    setScaleY: function (c) {
        this._scaleY = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    setPosition: function (c, d) {
        var e = this._position;
        if (void 0 === d) {
            if (e.x === c.x && e.y === c.y)return;
            e.x = c.x;
            e.y = c.y
        } else {
            if (e.x === c && e.y === d)return;
            e.x = c;
            e.y = d
        }
        this._usingNormalizedPosition = !1;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    setNormalizedPosition: function (c, d) {
        var e = this._normalizedPosition;
        void 0 === d ? (e.x = c.x, e.y = c.y) : (e.x = c, e.y = d);
        this._normalizedPositionDirty = this._usingNormalizedPosition = !0;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    getPosition: function () {
        return cc.p(this._position)
    },
    getNormalizedPosition: function () {
        return cc.p(this._normalizedPosition)
    },
    getPositionX: function () {
        return this._position.x
    },
    setPositionX: function (c) {
        this._position.x = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    getPositionY: function () {
        return this._position.y
    },
    setPositionY: function (c) {
        this._position.y = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    getChildrenCount: function () {
        return this._children.length
    },
    getChildren: function () {
        return this._children
    },
    isVisible: function () {
        return this._visible
    },
    setVisible: function (c) {
        this._visible !== c && (this._visible = c, this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty), cc.renderer.childrenOrderDirty = !0)
    },
    getAnchorPoint: function () {
        return cc.p(this._anchorPoint)
    },
    setAnchorPoint: function (c, d) {
        var e = this._anchorPoint;
        if (void 0 === d) {
            if (c.x === e.x && c.y === e.y)return;
            e.x = c.x;
            e.y = c.y
        } else {
            if (c === e.x && d === e.y)return;
            e.x = c;
            e.y = d
        }
        this._renderCmd._updateAnchorPointInPoint()
    },
    _getAnchorX: function () {
        return this._anchorPoint.x
    },
    _setAnchorX: function (c) {
        this._anchorPoint.x !==
        c && (this._anchorPoint.x = c, this._renderCmd._updateAnchorPointInPoint())
    },
    _getAnchorY: function () {
        return this._anchorPoint.y
    },
    _setAnchorY: function (c) {
        this._anchorPoint.y !== c && (this._anchorPoint.y = c, this._renderCmd._updateAnchorPointInPoint())
    },
    getAnchorPointInPoints: function () {
        return this._renderCmd.getAnchorPointInPoints()
    },
    _getWidth: function () {
        return this._contentSize.width
    },
    _setWidth: function (c) {
        this._contentSize.width = c;
        this._renderCmd._updateAnchorPointInPoint()
    },
    _getHeight: function () {
        return this._contentSize.height
    },
    _setHeight: function (c) {
        this._contentSize.height = c;
        this._renderCmd._updateAnchorPointInPoint()
    },
    getContentSize: function () {
        return cc.size(this._contentSize)
    },
    setContentSize: function (c, d) {
        var e = this._contentSize;
        if (void 0 === d) {
            if (c.width === e.width && c.height === e.height)return;
            e.width = c.width;
            e.height = c.height
        } else {
            if (c === e.width && d === e.height)return;
            e.width = c;
            e.height = d
        }
        this._renderCmd._updateAnchorPointInPoint()
    },
    isRunning: function () {
        return this._running
    },
    getParent: function () {
        return this._parent
    },
    setParent: function (c) {
        this._parent =
            c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    isIgnoreAnchorPointForPosition: function () {
        return this._ignoreAnchorPointForPosition
    },
    ignoreAnchorPointForPosition: function (c) {
        c !== this._ignoreAnchorPointForPosition && (this._ignoreAnchorPointForPosition = c, this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty))
    },
    getTag: function () {
        return this.tag
    },
    setTag: function (c) {
        this.tag = c
    },
    setName: function (c) {
        this._name = c
    },
    getName: function () {
        return this._name
    },
    getUserData: function () {
        return this.userData
    },
    setUserData: function (c) {
        this.userData = c
    },
    getUserObject: function () {
        return this.userObject
    },
    setUserObject: function (c) {
        this.userObject !== c && (this.userObject = c)
    },
    getOrderOfArrival: function () {
        return this.arrivalOrder
    },
    setOrderOfArrival: function (c) {
        this.arrivalOrder = c
    },
    getActionManager: function () {
        this._actionManager || (this._actionManager = cc.director.getActionManager());
        return this._actionManager
    },
    setActionManager: function (c) {
        this._actionManager !== c && (this.stopAllActions(), this._actionManager = c)
    },
    getScheduler: function () {
        this._scheduler ||
        (this._scheduler = cc.director.getScheduler());
        return this._scheduler
    },
    setScheduler: function (c) {
        this._scheduler !== c && (this.unscheduleAllCallbacks(), this._scheduler = c)
    },
    boundingBox: function () {
        cc.log(cc._LogInfos.Node_boundingBox);
        return this.getBoundingBox()
    },
    getBoundingBox: function () {
        var c = cc.rect(0, 0, this._contentSize.width, this._contentSize.height);
        return cc._rectApplyAffineTransformIn(c, this.getNodeToParentTransform())
    },
    cleanup: function () {
        this.stopAllActions();
        this.unscheduleAllCallbacks();
        cc.eventManager.removeListeners(this);
        this._arrayMakeObjectsPerformSelector(this._children, cc.Node._stateCallbackType.cleanup)
    },
    getChildByTag: function (c) {
        var d = this._children;
        if (null !== d)for (var e = 0; e < d.length; e++) {
            var f = d[e];
            if (f && f.tag === c)return f
        }
        return null
    },
    getChildByName: function (c) {
        if (!c)return cc.log("Invalid name"), null;
        for (var d = this._children, e = 0, f = d.length; e < f; e++)if (d[e]._name === c)return d[e];
        return null
    },
    addChild: function (c, d, e) {
        d = void 0 === d ? c._localZOrder : d;
        var f, g = !1;
        cc.isUndefined(e) ? (e = void 0, f = c._name) : cc.isString(e) ?
            (f = e, e = void 0) : cc.isNumber(e) && (g = !0, f = "");
        cc.assert(c, cc._LogInfos.Node_addChild_3);
        cc.assert(null === c._parent, "child already added. It can't be added again");
        this._addChildHelper(c, d, e, f, g)
    },
    _addChildHelper: function (c, d, e, f, g) {
        this._children || (this._children = []);
        this._insertChild(c, d);
        g ? c.setTag(e) : c.setName(f);
        c.setParent(this);
        c.setOrderOfArrival(cc.s_globalOrderOfArrival++);
        if (this._running && (c.onEnter(), this._isTransitionFinished))c.onEnterTransitionDidFinish();
        c._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty);
        this._cascadeColorEnabled && c._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty);
        this._cascadeOpacityEnabled && c._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.opacityDirty)
    },
    removeFromParent: function (c) {
        this._parent && (void 0 === c && (c = !0), this._parent.removeChild(this, c))
    },
    removeFromParentAndCleanup: function (c) {
        cc.log(cc._LogInfos.Node_removeFromParentAndCleanup);
        this.removeFromParent(c)
    },
    removeChild: function (c, d) {
        0 !== this._children.length && (void 0 === d && (d = !0), -1 < this._children.indexOf(c) && this._detachChild(c,
            d), cc.renderer.childrenOrderDirty = !0)
    },
    removeChildByTag: function (c, d) {
        c === cc.NODE_TAG_INVALID && cc.log(cc._LogInfos.Node_removeChildByTag);
        var e = this.getChildByTag(c);
        e ? this.removeChild(e, d) : cc.log(cc._LogInfos.Node_removeChildByTag_2, c)
    },
    removeAllChildrenWithCleanup: function (c) {
        this.removeAllChildren(c)
    },
    removeAllChildren: function (c) {
        var d = this._children;
        if (null !== d) {
            void 0 === c && (c = !0);
            for (var e = 0; e < d.length; e++) {
                var f = d[e];
                f && (this._running && (f.onExitTransitionDidStart(), f.onExit()), c && f.cleanup(),
                    f.parent = null, f._renderCmd.detachFromParent())
            }
            this._children.length = 0;
            cc.renderer.childrenOrderDirty = !0
        }
    },
    _detachChild: function (c, d) {
        this._running && (c.onExitTransitionDidStart(), c.onExit());
        d && c.cleanup();
        c.parent = null;
        c._renderCmd.detachFromParent();
        cc.arrayRemoveObject(this._children, c)
    },
    _insertChild: function (c, d) {
        cc.renderer.childrenOrderDirty = this._reorderChildDirty = !0;
        this._children.push(c);
        c._setLocalZOrder(d)
    },
    setNodeDirty: function () {
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    reorderChild: function (c, d) {
        cc.assert(c, cc._LogInfos.Node_reorderChild);
        cc.renderer.childrenOrderDirty = this._reorderChildDirty = !0;
        c.arrivalOrder = cc.s_globalOrderOfArrival;
        cc.s_globalOrderOfArrival++;
        c._setLocalZOrder(d);
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.orderDirty)
    },
    sortAllChildren: function () {
        if (this._reorderChildDirty) {
            var c = this._children, d = c.length, e, f, g;
            for (e = 1; e < d; e++) {
                g = c[e];
                for (f = e - 1; 0 <= f;) {
                    if (g._localZOrder < c[f]._localZOrder)c[f + 1] = c[f]; else if (g._localZOrder === c[f]._localZOrder &&
                        g.arrivalOrder < c[f].arrivalOrder)c[f + 1] = c[f]; else break;
                    f--
                }
                c[f + 1] = g
            }
            this._reorderChildDirty = !1
        }
    },
    draw: function (c) {
    },
    transformAncestors: function () {
        null !== this._parent && (this._parent.transformAncestors(), this._parent.transform())
    },
    onEnter: function () {
        this._isTransitionFinished = !1;
        this._running = !0;
        this._arrayMakeObjectsPerformSelector(this._children, cc.Node._stateCallbackType.onEnter);
        this.resume()
    },
    onEnterTransitionDidFinish: function () {
        this._isTransitionFinished = !0;
        this._arrayMakeObjectsPerformSelector(this._children,
            cc.Node._stateCallbackType.onEnterTransitionDidFinish)
    },
    onExitTransitionDidStart: function () {
        this._arrayMakeObjectsPerformSelector(this._children, cc.Node._stateCallbackType.onExitTransitionDidStart)
    },
    onExit: function () {
        this._running = !1;
        this.pause();
        this._arrayMakeObjectsPerformSelector(this._children, cc.Node._stateCallbackType.onExit);
        this.removeAllComponents()
    },
    runAction: function (c) {
        cc.assert(c, cc._LogInfos.Node_runAction);
        this.actionManager.addAction(c, this, !this._running);
        return c
    },
    stopAllActions: function () {
        this.actionManager &&
        this.actionManager.removeAllActionsFromTarget(this)
    },
    stopAction: function (c) {
        this.actionManager.removeAction(c)
    },
    stopActionByTag: function (c) {
        c === cc.ACTION_TAG_INVALID ? cc.log(cc._LogInfos.Node_stopActionByTag) : this.actionManager.removeActionByTag(c, this)
    },
    getActionByTag: function (c) {
        return c === cc.ACTION_TAG_INVALID ? (cc.log(cc._LogInfos.Node_getActionByTag), null) : this.actionManager.getActionByTag(c, this)
    },
    getNumberOfRunningActions: function () {
        return this.actionManager.numberOfRunningActionsInTarget(this)
    },
    scheduleUpdate: function () {
        this.scheduleUpdateWithPriority(0)
    },
    scheduleUpdateWithPriority: function (c) {
        this.scheduler.scheduleUpdate(this, c, !this._running)
    },
    unscheduleUpdate: function () {
        this.scheduler.unscheduleUpdate(this)
    },
    schedule: function (c, d, e, f, g) {
        var h = arguments.length;
        "function" === typeof c ? 1 === h ? (d = 0, e = cc.REPEAT_FOREVER, f = 0, g = this.__instanceId) : 2 === h ? "number" === typeof d ? (e = cc.REPEAT_FOREVER, f = 0, g = this.__instanceId) : (g = d, d = 0, e = cc.REPEAT_FOREVER, f = 0) : 3 === h ? ("string" === typeof e ? (g = e, e = cc.REPEAT_FOREVER) :
            g = this.__instanceId, f = 0) : 4 === h && (g = this.__instanceId) : 1 === h ? (d = 0, e = cc.REPEAT_FOREVER, f = 0) : 2 === h && (e = cc.REPEAT_FOREVER, f = 0);
        cc.assert(c, cc._LogInfos.Node_schedule);
        cc.assert(0 <= d, cc._LogInfos.Node_schedule_2);
        e = null == e ? cc.REPEAT_FOREVER : e;
        this.scheduler.schedule(c, this, d || 0, e, f || 0, !this._running, g)
    },
    scheduleOnce: function (c, d, e) {
        void 0 === e && (e = this.__instanceId);
        this.schedule(c, 0, 0, d, e)
    },
    unschedule: function (c) {
        c && this.scheduler.unschedule(c, this)
    },
    unscheduleAllCallbacks: function () {
        this.scheduler.unscheduleAllForTarget(this)
    },
    resumeSchedulerAndActions: function () {
        cc.log(cc._LogInfos.Node_resumeSchedulerAndActions);
        this.resume()
    },
    resume: function () {
        this.scheduler.resumeTarget(this);
        this.actionManager && this.actionManager.resumeTarget(this);
        cc.eventManager.resumeTarget(this)
    },
    pauseSchedulerAndActions: function () {
        cc.log(cc._LogInfos.Node_pauseSchedulerAndActions);
        this.pause()
    },
    pause: function () {
        this.scheduler.pauseTarget(this);
        this.actionManager && this.actionManager.pauseTarget(this);
        cc.eventManager.pauseTarget(this)
    },
    setAdditionalTransform: function (c) {
        if (void 0 ===
            c)return this._additionalTransformDirty = !1;
        this._additionalTransform = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty);
        this._additionalTransformDirty = !0
    },
    getParentToNodeTransform: function () {
        return this._renderCmd.getParentToNodeTransform()
    },
    parentToNodeTransform: function () {
        return this.getParentToNodeTransform()
    },
    getNodeToWorldTransform: function () {
        for (var c = this.getNodeToParentTransform(), d = this._parent; null !== d; d = d.parent)c = cc.affineTransformConcat(c, d.getNodeToParentTransform());
        return c
    },
    nodeToWorldTransform: function () {
        return this.getNodeToWorldTransform()
    },
    getWorldToNodeTransform: function () {
        return cc.affineTransformInvert(this.getNodeToWorldTransform())
    },
    worldToNodeTransform: function () {
        return this.getWorldToNodeTransform()
    },
    convertToNodeSpace: function (c) {
        return cc.pointApplyAffineTransform(c, this.getWorldToNodeTransform())
    },
    convertToWorldSpace: function (c) {
        c = c || cc.p(0, 0);
        return cc.pointApplyAffineTransform(c, this.getNodeToWorldTransform())
    },
    convertToNodeSpaceAR: function (c) {
        return cc.pSub(this.convertToNodeSpace(c),
            this._renderCmd.getAnchorPointInPoints())
    },
    convertToWorldSpaceAR: function (c) {
        c = c || cc.p(0, 0);
        c = cc.pAdd(c, this._renderCmd.getAnchorPointInPoints());
        return this.convertToWorldSpace(c)
    },
    _convertToWindowSpace: function (c) {
        c = this.convertToWorldSpace(c);
        return cc.director.convertToUI(c)
    },
    convertTouchToNodeSpace: function (c) {
        c = c.getLocation();
        return this.convertToNodeSpace(c)
    },
    convertTouchToNodeSpaceAR: function (c) {
        c = cc.director.convertToGL(c.getLocation());
        return this.convertToNodeSpaceAR(c)
    },
    update: function (c) {
        this._componentContainer && !this._componentContainer.isEmpty() && this._componentContainer.visit(c)
    },
    updateTransform: function () {
        this._arrayMakeObjectsPerformSelector(this._children, cc.Node._stateCallbackType.updateTransform)
    },
    retain: function () {
    },
    release: function () {
    },
    getComponent: function (c) {
        return this._componentContainer ? this._componentContainer.getComponent(c) : null
    },
    addComponent: function (c) {
        this._componentContainer && this._componentContainer.add(c)
    },
    removeComponent: function (c) {
        return this._componentContainer ? this._componentContainer.remove(c) :
            !1
    },
    removeAllComponents: function () {
        this._componentContainer && this._componentContainer.removeAll()
    },
    grid: null,
    visit: function (c) {
        this._renderCmd.visit(c)
    },
    transform: function (c, d) {
        this._renderCmd.transform(c, d)
    },
    nodeToParentTransform: function () {
        return this.getNodeToParentTransform()
    },
    getNodeToParentTransform: function (c) {
        var d = this._renderCmd.getNodeToParentTransform();
        if (c)for (var d = {
            a: d.a,
            b: d.b,
            c: d.c,
            d: d.d,
            tx: d.tx,
            ty: d.ty
        }, e = this._parent; null != e && e != c; e = e.getParent())cc.affineTransformConcatIn(d, e.getNodeToParentTransform());
        return d
    },
    getNodeToParentAffineTransform: function (c) {
        return this.getNodeToParentTransform(c)
    },
    getCamera: function () {
        return null
    },
    getGrid: function () {
        return this.grid
    },
    setGrid: function (c) {
        this.grid = c
    },
    getShaderProgram: function () {
        return this._renderCmd.getShaderProgram()
    },
    setShaderProgram: function (c) {
        this._renderCmd.setShaderProgram(c)
    },
    getGLServerState: function () {
        return 0
    },
    setGLServerState: function (c) {
    },
    getBoundingBoxToWorld: function () {
        var c = cc.rect(0, 0, this._contentSize.width, this._contentSize.height),
            d = this.getNodeToWorldTransform(), c = cc.rectApplyAffineTransform(c, d);
        if (!this._children)return c;
        for (var e = this._children, f = 0; f < e.length; f++) {
            var g = e[f];
            g && g._visible && (g = g._getBoundingBoxToCurrentNode(d)) && (c = cc.rectUnion(c, g))
        }
        return c
    },
    _getBoundingBoxToCurrentNode: function (c) {
        var d = cc.rect(0, 0, this._contentSize.width, this._contentSize.height);
        c = void 0 === c ? this.getNodeToParentTransform() : cc.affineTransformConcat(this.getNodeToParentTransform(), c);
        d = cc.rectApplyAffineTransform(d, c);
        if (!this._children)return d;
        for (var e = this._children, f = 0; f < e.length; f++) {
            var g = e[f];
            g && g._visible && (g = g._getBoundingBoxToCurrentNode(c)) && (d = cc.rectUnion(d, g))
        }
        return d
    },
    getOpacity: function () {
        return this._realOpacity
    },
    getDisplayedOpacity: function () {
        return this._renderCmd.getDisplayedOpacity()
    },
    setOpacity: function (c) {
        this._realOpacity = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.opacityDirty)
    },
    updateDisplayedOpacity: function (c) {
        this._renderCmd._updateDisplayOpacity(c)
    },
    isCascadeOpacityEnabled: function () {
        return this._cascadeOpacityEnabled
    },
    setCascadeOpacityEnabled: function (c) {
        this._cascadeOpacityEnabled !== c && (this._cascadeOpacityEnabled = c, this._renderCmd.setCascadeOpacityEnabledDirty())
    },
    getColor: function () {
        var c = this._realColor;
        return cc.color(c.r, c.g, c.b, c.a)
    },
    getDisplayedColor: function () {
        return this._renderCmd.getDisplayedColor()
    },
    setColor: function (c) {
        var d = this._realColor;
        d.r = c.r;
        d.g = c.g;
        d.b = c.b;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty)
    },
    updateDisplayedColor: function (c) {
        this._renderCmd._updateDisplayColor(c)
    },
    isCascadeColorEnabled: function () {
        return this._cascadeColorEnabled
    },
    setCascadeColorEnabled: function (c) {
        this._cascadeColorEnabled !== c && (this._cascadeColorEnabled = c, this._renderCmd.setCascadeColorEnabledDirty())
    },
    setOpacityModifyRGB: function (c) {
    },
    isOpacityModifyRGB: function () {
        return !1
    },
    _initRendererCmd: function () {
        this._renderCmd = cc.renderer.getRenderCmd(this)
    },
    _createRenderCmd: function () {
        return cc._renderType === cc.game.RENDER_TYPE_CANVAS ? new cc.Node.CanvasRenderCmd(this) : new cc.Node.WebGLRenderCmd(this)
    },
    enumerateChildren: function (c, d) {
        cc.assert(c && 0 != c.length, "Invalid name");
        cc.assert(null != d, "Invalid callback function");
        var e = c.length, f = 0, g = e, h = !1;
        2 < e && "/" === c[0] && "/" === c[1] && (h = !0, f = 2, g -= 2);
        var k = !1;
        3 < e && "/" === c[e - 3] && "." === c[e - 2] && "." === c[e - 1] && (k = !0, g -= 3);
        e = c.substr(f, g);
        k && (e = "[[:alnum:]]+/" + e);
        h ? this.doEnumerateRecursive(this, e, d) : this.doEnumerate(e, d)
    },
    doEnumerateRecursive: function (c, d, e) {
        if (!c.doEnumerate(d, e))for (var f = c.getChildren(), g = f.length, h = 0; h < g && (c = f[h], !this.doEnumerateRecursive(c,
            d, e)); h++);
    },
    doEnumerate: function (c, d) {
        var e = c.indexOf("/"), f = c, g = !1;
        -1 !== e && (f = c.substr(0, e), g = !0);
        for (var e = !1, h, k = this._children, m = k.length, n = 0; n < m; n++)if (h = k[n], -1 !== h._name.indexOf(f))if (g) {
            if (e = h.doEnumerate(c, d))break
        } else if (d(h)) {
            e = !0;
            break
        }
        return e
    }
});
cc.Node.create = function () {
    return new cc.Node
};
cc.Node._stateCallbackType = {
    onEnter: 1,
    onExit: 2,
    cleanup: 3,
    onEnterTransitionDidFinish: 4,
    updateTransform: 5,
    onExitTransitionDidStart: 6,
    sortAllChildren: 7
};
cc.assert(cc.isFunction(cc._tmp.PrototypeCCNode), cc._LogInfos.MissingFile, "BaseNodesPropertyDefine.js");
cc._tmp.PrototypeCCNode();
delete cc._tmp.PrototypeCCNode;
cc.CustomRenderCmd = function (c, d) {
    this._needDraw = !0;
    this._target = c;
    this._callback = d;
    this.rendering = function (c, d, g) {
        this._callback && this._callback.call(this._target, c, d, g)
    };
    this.needDraw = function () {
        return this._needDraw
    }
};
cc.Node._dirtyFlags = {
    transformDirty: 1,
    visibleDirty: 2,
    colorDirty: 4,
    opacityDirty: 8,
    cacheDirty: 16,
    orderDirty: 32,
    textDirty: 64,
    gradientDirty: 128,
    textureDirty: 256,
    all: 511
};
cc.Node.RenderCmd = function (c) {
    this._dirtyFlag = 1;
    this._savedDirtyFlag = !0;
    this._node = c;
    this._needDraw = !1;
    this._anchorPointInPoints = new cc.Point(0, 0);
    this._transform = {a: 1, b: 0, c: 0, d: 1, tx: 0, ty: 0};
    this._worldTransform = {a: 1, b: 0, c: 0, d: 1, tx: 0, ty: 0};
    this._inverse = {a: 1, b: 0, c: 0, d: 1, tx: 0, ty: 0};
    this._displayedOpacity = 255;
    this._displayedColor = cc.color(255, 255, 255, 255);
    this._cascadeOpacityEnabledDirty = this._cascadeColorEnabledDirty = !1;
    this._curLevel = -1
};
cc.Node.RenderCmd.prototype = {
    constructor: cc.Node.RenderCmd, needDraw: function () {
        return this._needDraw
    }, getAnchorPointInPoints: function () {
        return cc.p(this._anchorPointInPoints)
    }, getDisplayedColor: function () {
        var c = this._displayedColor;
        return cc.color(c.r, c.g, c.b, c.a)
    }, getDisplayedOpacity: function () {
        return this._displayedOpacity
    }, setCascadeColorEnabledDirty: function () {
        this._cascadeColorEnabledDirty = !0;
        this.setDirtyFlag(cc.Node._dirtyFlags.colorDirty)
    }, setCascadeOpacityEnabledDirty: function () {
        this._cascadeOpacityEnabledDirty = !0;
        this.setDirtyFlag(cc.Node._dirtyFlags.opacityDirty)
    }, getParentToNodeTransform: function () {
        this._dirtyFlag & cc.Node._dirtyFlags.transformDirty && (this._inverse = cc.affineTransformInvert(this.getNodeToParentTransform()));
        return this._inverse
    }, detachFromParent: function () {
    }, _updateAnchorPointInPoint: function () {
        var c = this._anchorPointInPoints, d = this._node._contentSize, e = this._node._anchorPoint;
        c.x = d.width * e.x;
        c.y = d.height * e.y;
        this.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    }, setDirtyFlag: function (c) {
        0 ===
        this._dirtyFlag && 0 !== c && cc.renderer.pushDirtyNode(this);
        this._dirtyFlag |= c
    }, getParentRenderCmd: function () {
        return this._node && this._node._parent && this._node._parent._renderCmd ? this._node._parent._renderCmd : null
    }, transform: function (c, d) {
        var e = this._node, f = c ? c._worldTransform : null, g = this._transform, h = this._worldTransform;
        if (e._usingNormalizedPosition && e._parent) {
            var k = e._parent._contentSize;
            e._position.x = e._normalizedPosition.x * k.width;
            e._position.y = e._normalizedPosition.y * k.height;
            e._normalizedPositionDirty = !1
        }
        var m = e._rotationX || e._rotationY, n = e._skewX || e._skewY, p = e._scaleX, r = e._scaleY, k = this._anchorPointInPoints.x, s = this._anchorPointInPoints.y, v = 1, t = 0, w = 0, u = 1;
        if (m || n) {
            g.tx = e._position.x;
            g.ty = e._position.y;
            m && (v = 0.017453292519943295 * e._rotationX, w = Math.sin(v), u = Math.cos(v), e._rotationY === e._rotationX ? (v = u, t = -w) : (t = 0.017453292519943295 * e._rotationY, v = Math.cos(t), t = -Math.sin(t)));
            g.a = v *= p;
            g.b = t *= p;
            g.c = w *= r;
            g.d = u *= r;
            n && (n = Math.tan(e._skewX * Math.PI / 180), p = Math.tan(e._skewY * Math.PI / 180), Infinity === n && (n =
                99999999), Infinity === p && (p = 99999999), g.a = v + t * p, g.b = t + v * p, g.c = w + u * n, g.d = u + w * n);
            if (k || s)g.tx -= g.a * k + g.c * s, g.ty -= g.b * k + g.d * s, e._ignoreAnchorPointForPosition && (g.tx += k, g.ty += s);
            f ? (h.a = g.a * f.a + g.b * f.c, h.b = g.a * f.b + g.b * f.d, h.c = g.c * f.a + g.d * f.c, h.d = g.c * f.b + g.d * f.d, h.tx = f.a * g.tx + f.c * g.ty + f.tx, h.ty = f.d * g.ty + f.ty + f.b * g.tx) : (h.a = g.a, h.b = g.b, h.c = g.c, h.d = g.d, h.tx = g.tx, h.ty = g.ty)
        } else {
            g.a = p;
            g.b = 0;
            g.c = 0;
            g.d = r;
            g.tx = e._position.x;
            g.ty = e._position.y;
            if (k || s)g.tx -= g.a * k, g.ty -= g.d * s, e._ignoreAnchorPointForPosition && (g.tx +=
                k, g.ty += s);
            f ? (h.a = g.a * f.a + g.b * f.c, h.b = g.a * f.b + g.b * f.d, h.c = g.c * f.a + g.d * f.c, h.d = g.c * f.b + g.d * f.d, h.tx = g.tx * f.a + g.ty * f.c + f.tx, h.ty = g.tx * f.b + g.ty * f.d + f.ty) : (h.a = g.a, h.b = g.b, h.c = g.c, h.d = g.d, h.tx = g.tx, h.ty = g.ty)
        }
        e._additionalTransformDirty && (this._transform = cc.affineTransformConcat(g, e._additionalTransform));
        if (d) {
            e = this._node._children;
            if (!e || 0 === e.length)return;
            f = 0;
            for (g = e.length; f < g; f++)e[f]._renderCmd.transform(this, d)
        }
        this._cacheDirty = !0
    }, getNodeToParentTransform: function () {
        this._dirtyFlag & cc.Node._dirtyFlags.transformDirty &&
        this.transform();
        return this._transform
    }, visit: function (c) {
        var d = this._node, e = cc.renderer;
        if (d._visible) {
            if (c = c || this.getParentRenderCmd())this._curLevel = c._curLevel + 1;
            isNaN(d._customZ) && (d._vertexZ = e.assignedZ, e.assignedZ += e.assignedZStep);
            this._syncStatus(c);
            this.visitChildren()
        }
    }, _updateDisplayColor: function (c) {
        var d = this._node, e = this._displayedColor, f = d._realColor, g;
        if (this._cascadeColorEnabledDirty && !d._cascadeColorEnabled) {
            e.r = f.r;
            e.g = f.g;
            e.b = f.b;
            e = new cc.Color(255, 255, 255, 255);
            c = d._children;
            d = 0;
            for (f = c.length; d < f; d++)(g = c[d]) && g._renderCmd && g._renderCmd._updateDisplayColor(e);
            this._cascadeColorEnabledDirty = !1
        } else if (void 0 === c && (c = (c = d._parent) && c._cascadeColorEnabled ? c.getDisplayedColor() : cc.color.WHITE), e.r = 0 | f.r * c.r / 255, e.g = 0 | f.g * c.g / 255, e.b = 0 | f.b * c.b / 255, d._cascadeColorEnabled)for (c = d._children, d = 0, f = c.length; d < f; d++)(g = c[d]) && g._renderCmd && (g._renderCmd._updateDisplayColor(e), g._renderCmd._updateColor());
        this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.colorDirty
    }, _updateDisplayOpacity: function (c) {
        var d =
            this._node, e, f;
        if (this._cascadeOpacityEnabledDirty && !d._cascadeOpacityEnabled) {
            this._displayedOpacity = d._realOpacity;
            e = d._children;
            c = 0;
            for (d = e.length; c < d; c++)(f = e[c]) && f._renderCmd && f._renderCmd._updateDisplayOpacity(255);
            this._cascadeOpacityEnabledDirty = !1
        } else if (void 0 === c && (e = d._parent, c = 255, e && e._cascadeOpacityEnabled && (c = e.getDisplayedOpacity())), this._displayedOpacity = d._realOpacity * c / 255, d._cascadeOpacityEnabled)for (e = d._children, c = 0, d = e.length; c < d; c++)(f = e[c]) && f._renderCmd && (f._renderCmd._updateDisplayOpacity(this._displayedOpacity),
            f._renderCmd._updateColor());
        this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.opacityDirty
    }, _syncDisplayColor: function (c) {
        var d = this._node, e = this._displayedColor, f = d._realColor;
        void 0 === c && (c = (c = d._parent) && c._cascadeColorEnabled ? c.getDisplayedColor() : cc.color.WHITE);
        e.r = 0 | f.r * c.r / 255;
        e.g = 0 | f.g * c.g / 255;
        e.b = 0 | f.b * c.b / 255
    }, _syncDisplayOpacity: function (c) {
        var d = this._node;
        if (void 0 === c) {
            var e = d._parent;
            c = 255;
            e && e._cascadeOpacityEnabled && (c = e.getDisplayedOpacity())
        }
        this._displayedOpacity = d._realOpacity *
            c / 255
    }, _updateColor: function () {
    }, updateStatus: function () {
        var c = cc.Node._dirtyFlags, d = this._dirtyFlag, e = d & c.colorDirty, f = d & c.opacityDirty;
        this._savedDirtyFlag = this._savedDirtyFlag || d;
        e && this._updateDisplayColor();
        f && this._updateDisplayOpacity();
        (e || f) && this._updateColor();
        d & c.transformDirty && (this.transform(this.getParentRenderCmd(), !0), this._dirtyFlag ^= this._dirtyFlag & c.transformDirty);
        d & c.orderDirty && (this._dirtyFlag ^= this._dirtyFlag & c.orderDirty)
    }, _syncStatus: function (c) {
        var d = cc.Node._dirtyFlags,
            e = this._dirtyFlag, f = null;
        c ? (f = c._node, this._savedDirtyFlag = this._savedDirtyFlag || c._savedDirtyFlag || e) : this._savedDirtyFlag = this._savedDirtyFlag || e;
        f && f._cascadeColorEnabled && c._dirtyFlag & d.colorDirty && (e |= d.colorDirty);
        f && f._cascadeOpacityEnabled && c._dirtyFlag & d.opacityDirty && (e |= d.opacityDirty);
        c && c._dirtyFlag & d.transformDirty && (e |= d.transformDirty);
        var f = e & d.colorDirty, g = e & d.opacityDirty;
        this._dirtyFlag = e;
        f && this._syncDisplayColor();
        g && this._syncDisplayOpacity();
        (f || g) && this._updateColor();
        e & d.transformDirty &&
        this.transform(c);
        e & d.orderDirty && (this._dirtyFlag ^= this._dirtyFlag & d.orderDirty)
    }, visitChildren: function () {
        var c = cc.renderer, d = this._node, e = d._children, f, g = e.length;
        if (0 < g) {
            d.sortAllChildren();
            for (d = 0; d < g; d++)if (f = e[d], 0 > f._localZOrder)f._renderCmd.visit(this); else break;
            for (c.pushRenderCommand(this); d < g; d++)e[d]._renderCmd.visit(this)
        } else c.pushRenderCommand(this);
        this._dirtyFlag = 0
    }
};
cc.Node.RenderCmd.prototype.originVisit = cc.Node.RenderCmd.prototype.visit;
cc.Node.RenderCmd.prototype.originTransform = cc.Node.RenderCmd.prototype.transform;
(function () {
    cc.Node.CanvasRenderCmd = function (c) {
        cc.Node.RenderCmd.call(this, c);
        this._cachedParent = null;
        this._cacheDirty = !1
    };
    var c = cc.Node.CanvasRenderCmd.prototype = Object.create(cc.Node.RenderCmd.prototype);
    c.constructor = cc.Node.CanvasRenderCmd;
    c.setDirtyFlag = function (c, e) {
        cc.Node.RenderCmd.prototype.setDirtyFlag.call(this, c, e);
        this._setCacheDirty(e);
        this._cachedParent && this._cachedParent.setDirtyFlag(c, !0)
    };
    c._setCacheDirty = function () {
        if (!1 === this._cacheDirty) {
            this._cacheDirty = !0;
            var c = this._cachedParent;
            c && c !== this && c._setNodeDirtyForCache && c._setNodeDirtyForCache()
        }
    };
    c._setCachedParent = function (c) {
        if (this._cachedParent !== c) {
            this._cachedParent = c;
            for (var e = this._node._children, f = 0, g = e.length; f < g; f++)e[f]._renderCmd._setCachedParent(c)
        }
    };
    c.detachFromParent = function () {
        this._cachedParent = null;
        for (var c = this._node._children, e, f = 0, g = c.length; f < g; f++)(e = c[f]) && e._renderCmd && e._renderCmd.detachFromParent()
    };
    c.setShaderProgram = function (c) {
    };
    c.getShaderProgram = function () {
        return null
    };
    cc.Node.CanvasRenderCmd._getCompositeOperationByBlendFunc =
        function (c) {
            return c ? c.src === cc.SRC_ALPHA && c.dst === cc.ONE || c.src === cc.ONE && c.dst === cc.ONE ? "lighter" : c.src === cc.ZERO && c.dst === cc.SRC_ALPHA ? "destination-in" : c.src === cc.ZERO && c.dst === cc.ONE_MINUS_SRC_ALPHA ? "destination-out" : "source-over" : "source-over"
        }
})();
(function () {
    cc.Node.WebGLRenderCmd = function (c) {
        cc.Node.RenderCmd.call(this, c);
        this._shaderProgram = null
    };
    var c = cc.Node.WebGLRenderCmd.prototype = Object.create(cc.Node.RenderCmd.prototype);
    c.constructor = cc.Node.WebGLRenderCmd;
    c._updateColor = function () {
    };
    c.setShaderProgram = function (c) {
        this._shaderProgram = c
    };
    c.getShaderProgram = function () {
        return this._shaderProgram
    }
})();
cc.AtlasNode = cc.Node.extend({
    textureAtlas: null,
    quadsToDraw: 0,
    _itemsPerRow: 0,
    _itemsPerColumn: 0,
    _itemWidth: 0,
    _itemHeight: 0,
    _opacityModifyRGB: !1,
    _blendFunc: null,
    _ignoreContentScaleFactor: !1,
    _className: "AtlasNode",
    _texture: null,
    _textureForCanvas: null,
    ctor: function (c, d, e, f) {
        cc.Node.prototype.ctor.call(this);
        this._blendFunc = {src: cc.BLEND_SRC, dst: cc.BLEND_DST};
        this._ignoreContentScaleFactor = !1;
        void 0 !== f && this.initWithTileFile(c, d, e, f)
    },
    _createRenderCmd: function () {
        this._renderCmd = cc._renderType === cc.game.RENDER_TYPE_CANVAS ?
            new cc.AtlasNode.CanvasRenderCmd(this) : new cc.AtlasNode.WebGLRenderCmd(this)
    },
    updateAtlasValues: function () {
        cc.log(cc._LogInfos.AtlasNode_updateAtlasValues)
    },
    getColor: function () {
        return this._opacityModifyRGB ? this._renderCmd._colorUnmodified : cc.Node.prototype.getColor.call(this)
    },
    setOpacityModifyRGB: function (c) {
        var d = this.color;
        this._opacityModifyRGB = c;
        this.setColor(d)
    },
    isOpacityModifyRGB: function () {
        return this._opacityModifyRGB
    },
    getBlendFunc: function () {
        return this._blendFunc
    },
    setBlendFunc: function (c,
                            d) {
        this._blendFunc = void 0 === d ? c : {src: c, dst: d}
    },
    setTextureAtlas: function (c) {
        this.textureAtlas = c
    },
    getTextureAtlas: function () {
        return this.textureAtlas
    },
    getQuadsToDraw: function () {
        return this.quadsToDraw
    },
    setQuadsToDraw: function (c) {
        this.quadsToDraw = c
    },
    initWithTileFile: function (c, d, e, f) {
        if (!c)throw Error("cc.AtlasNode.initWithTileFile(): title should not be null");
        c = cc.textureCache.addImage(c);
        return this.initWithTexture(c, d, e, f)
    },
    initWithTexture: function (c, d, e, f) {
        return this._renderCmd.initWithTexture(c,
            d, e, f)
    },
    setColor: function (c) {
        this._renderCmd.setColor(c)
    },
    setOpacity: function (c) {
        this._renderCmd.setOpacity(c)
    },
    getTexture: function () {
        return this._texture
    },
    setTexture: function (c) {
        this._texture = c
    },
    _setIgnoreContentScaleFactor: function (c) {
        this._ignoreContentScaleFactor = c
    }
});
_p = cc.AtlasNode.prototype;
cc.defineGetterSetter(_p, "opacity", _p.getOpacity, _p.setOpacity);
cc.defineGetterSetter(_p, "color", _p.getColor, _p.setColor);
cc.defineGetterSetter(_p, "texture", _p.getTexture, _p.setTexture);
cc.EventHelper.prototype.apply(_p);
cc.AtlasNode.create = function (c, d, e, f) {
    return new cc.AtlasNode(c, d, e, f)
};
(function () {
    cc.AtlasNode.CanvasRenderCmd = function (c) {
        cc.Node.CanvasRenderCmd.call(this, c);
        this._needDraw = !1;
        this._colorUnmodified = cc.color.WHITE;
        this._textureToRender = null
    };
    var c = cc.AtlasNode.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
    c.constructor = cc.AtlasNode.CanvasRenderCmd;
    c.initWithTexture = function (c, e, f, g) {
        var h = this._node;
        h._itemWidth = e;
        h._itemHeight = f;
        h._opacityModifyRGB = !0;
        h._texture = c;
        if (!h._texture)return cc.log(cc._LogInfos.AtlasNode__initWithTexture), !1;
        this._textureToRender = c;
        this._calculateMaxItems();
        h.quadsToDraw = g;
        return !0
    };
    c.setColor = function (c) {
        var e = this._node._realColor;
        if (e.r !== c.r || e.g !== c.g || e.b !== c.b)this._colorUnmodified = c, this._changeTextureColor()
    };
    c._changeTextureColor = function () {
        var c = this._node._texture, e = this._colorUnmodified, f = c.getHtmlElementObj(), f = cc.rect(0, 0, f.width, f.height);
        c === this._textureToRender ? this._textureToRender = c._generateColorTexture(e.r, e.g, e.b, f) : c._generateColorTexture(e.r, e.g, e.b, f, this._textureToRender.getHtmlElementObj())
    };
    c.setOpacity = function (c) {
        cc.Node.prototype.setOpacity.call(this._node, c)
    };
    c._calculateMaxItems = function () {
        var c = this._node, e = c._texture.getContentSize();
        c._itemsPerColumn = 0 | e.height / c._itemHeight;
        c._itemsPerRow = 0 | e.width / c._itemWidth
    }
})();
(function () {
    cc.AtlasNode.WebGLRenderCmd = function (c) {
        cc.Node.WebGLRenderCmd.call(this, c);
        this._needDraw = !0;
        this._textureAtlas = null;
        this._colorUnmodified = cc.color.WHITE;
        this._uniformColor = this._colorF32Array = null;
        this._matrix = new cc.math.Matrix4;
        this._matrix.identity();
        this._shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_TEXTURE_UCOLOR);
        this._uniformColor = cc._renderContext.getUniformLocation(this._shaderProgram.getProgram(), "u_color")
    };
    var c = cc.AtlasNode.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
    c.constructor = cc.AtlasNode.WebGLRenderCmd;
    c._updateBlendFunc = function () {
        var c = this._node;
        this._textureAtlas.texture.hasPremultipliedAlpha() || (c._blendFunc.src = cc.SRC_ALPHA, c._blendFunc.dst = cc.ONE_MINUS_SRC_ALPHA)
    };
    c._updateOpacityModifyRGB = function () {
        this._node._opacityModifyRGB = this._textureAtlas.texture.hasPremultipliedAlpha()
    };
    c.rendering = function (c) {
        c = c || cc._renderContext;
        var e = this._node, f = this._worldTransform;
        this._matrix.mat[0] = f.a;
        this._matrix.mat[4] = f.c;
        this._matrix.mat[12] = f.tx;
        this._matrix.mat[1] =
            f.b;
        this._matrix.mat[5] = f.d;
        this._matrix.mat[13] = f.ty;
        this._shaderProgram.use();
        this._shaderProgram._setUniformForMVPMatrixWithMat4(this._matrix);
        cc.glBlendFunc(e._blendFunc.src, e._blendFunc.dst);
        this._uniformColor && this._colorF32Array && (c.uniform4fv(this._uniformColor, this._colorF32Array), this._textureAtlas.drawNumberOfQuads(e.quadsToDraw, 0))
    };
    c.initWithTexture = function (c, e, f, g) {
        var h = this._node;
        h._itemWidth = e;
        h._itemHeight = f;
        this._colorUnmodified = cc.color.WHITE;
        h._opacityModifyRGB = !0;
        h._blendFunc.src =
            cc.BLEND_SRC;
        h._blendFunc.dst = cc.BLEND_DST;
        e = h._realColor;
        this._colorF32Array = new Float32Array([e.r / 255, e.g / 255, e.b / 255, h._realOpacity / 255]);
        this._textureAtlas = new cc.TextureAtlas;
        this._textureAtlas.initWithTexture(c, g);
        if (!this._textureAtlas)return cc.log(cc._LogInfos.AtlasNode__initWithTexture), !1;
        this._updateBlendFunc();
        this._updateOpacityModifyRGB();
        this._calculateMaxItems();
        h.quadsToDraw = g;
        return !0
    };
    c.setColor = function (c) {
        var e = cc.color(c.r, c.g, c.b), f = this._node;
        this._colorUnmodified = c;
        c = this._displayedOpacity;
        f._opacityModifyRGB && (e.r = e.r * c / 255, e.g = e.g * c / 255, e.b = e.b * c / 255);
        cc.Node.prototype.setColor.call(f, e)
    };
    c.setOpacity = function (c) {
        var e = this._node;
        cc.Node.prototype.setOpacity.call(e, c);
        e._opacityModifyRGB && (e.color = this._colorUnmodified)
    };
    c._updateColor = function () {
        if (this._colorF32Array) {
            var c = this._displayedColor;
            this._colorF32Array[0] = c.r / 255;
            this._colorF32Array[1] = c.g / 255;
            this._colorF32Array[2] = c.b / 255;
            this._colorF32Array[3] = this._displayedOpacity / 255
        }
    };
    c.getTexture = function () {
        return this._textureAtlas.texture
    };
    c.setTexture = function (c) {
        this._textureAtlas.texture = c;
        this._updateBlendFunc();
        this._updateOpacityModifyRGB()
    };
    c._calculateMaxItems = function () {
        var c = this._node, e = this._textureAtlas.texture, f = e.getContentSize();
        c._ignoreContentScaleFactor && (f = e.getContentSizeInPixels());
        c._itemsPerColumn = 0 | f.height / c._itemHeight;
        c._itemsPerRow = 0 | f.width / c._itemWidth
    }
})();
cc._tmp.WebGLTexture2D = function () {
    cc.Texture2D = cc.Class.extend({
        _pVRHaveAlphaPremultiplied: !0,
        _pixelFormat: null,
        _pixelsWide: 0,
        _pixelsHigh: 0,
        _name: "",
        _contentSize: null,
        maxS: 0,
        maxT: 0,
        _hasPremultipliedAlpha: !1,
        _hasMipmaps: !1,
        shaderProgram: null,
        _textureLoaded: !1,
        _htmlElementObj: null,
        _webTextureObj: null,
        url: null,
        ctor: function () {
            this._contentSize = cc.size(0, 0);
            this._pixelFormat = cc.Texture2D.defaultPixelFormat
        },
        releaseTexture: function () {
            this._webTextureObj && cc._renderContext.deleteTexture(this._webTextureObj);
            cc.loader.release(this.url)
        },
        getPixelFormat: function () {
            return this._pixelFormat
        },
        getPixelsWide: function () {
            return this._pixelsWide
        },
        getPixelsHigh: function () {
            return this._pixelsHigh
        },
        getName: function () {
            return this._webTextureObj
        },
        getContentSize: function () {
            return cc.size(this._contentSize.width / cc.contentScaleFactor(), this._contentSize.height / cc.contentScaleFactor())
        },
        _getWidth: function () {
            return this._contentSize.width / cc.contentScaleFactor()
        },
        _getHeight: function () {
            return this._contentSize.height / cc.contentScaleFactor()
        },
        getContentSizeInPixels: function () {
            return this._contentSize
        },
        getMaxS: function () {
            return this.maxS
        },
        setMaxS: function (c) {
            this.maxS = c
        },
        getMaxT: function () {
            return this.maxT
        },
        setMaxT: function (c) {
            this.maxT = c
        },
        getShaderProgram: function () {
            return this.shaderProgram
        },
        setShaderProgram: function (c) {
            this.shaderProgram = c
        },
        hasPremultipliedAlpha: function () {
            return this._hasPremultipliedAlpha
        },
        hasMipmaps: function () {
            return this._hasMipmaps
        },
        description: function () {
            return "\x3ccc.Texture2D | Name \x3d " + this._name + " | Dimensions \x3d " +
                this._pixelsWide + " x " + this._pixelsHigh + " | Coordinates \x3d (" + this.maxS + ", " + this.maxT + ")\x3e"
        },
        releaseData: function (c) {
        },
        keepData: function (c, d) {
            return c
        },
        initWithData: function (c, d, e, f, g) {
            var h = cc.Texture2D, k = cc._renderContext, m = k.RGBA, n = k.UNSIGNED_BYTE, p = e * cc.Texture2D._B[d] / 8;
            0 === p % 8 ? k.pixelStorei(k.UNPACK_ALIGNMENT, 8) : 0 === p % 4 ? k.pixelStorei(k.UNPACK_ALIGNMENT, 4) : 0 === p % 2 ? k.pixelStorei(k.UNPACK_ALIGNMENT, 2) : k.pixelStorei(k.UNPACK_ALIGNMENT, 1);
            this._webTextureObj = k.createTexture();
            cc.glBindTexture2D(this);
            k.texParameteri(k.TEXTURE_2D, k.TEXTURE_MIN_FILTER, k.LINEAR);
            k.texParameteri(k.TEXTURE_2D, k.TEXTURE_MAG_FILTER, k.LINEAR);
            k.texParameteri(k.TEXTURE_2D, k.TEXTURE_WRAP_S, k.CLAMP_TO_EDGE);
            k.texParameteri(k.TEXTURE_2D, k.TEXTURE_WRAP_T, k.CLAMP_TO_EDGE);
            switch (d) {
                case h.PIXEL_FORMAT_RGBA8888:
                    m = k.RGBA;
                    break;
                case h.PIXEL_FORMAT_RGB888:
                    m = k.RGB;
                    break;
                case h.PIXEL_FORMAT_RGBA4444:
                    n = k.UNSIGNED_SHORT_4_4_4_4;
                    break;
                case h.PIXEL_FORMAT_RGB5A1:
                    n = k.UNSIGNED_SHORT_5_5_5_1;
                    break;
                case h.PIXEL_FORMAT_RGB565:
                    n = k.UNSIGNED_SHORT_5_6_5;
                    break;
                case h.PIXEL_FORMAT_AI88:
                    m = k.LUMINANCE_ALPHA;
                    break;
                case h.PIXEL_FORMAT_A8:
                    m = k.ALPHA;
                    break;
                case h.PIXEL_FORMAT_I8:
                    m = k.LUMINANCE;
                    break;
                default:
                    cc.assert(0, cc._LogInfos.Texture2D_initWithData)
            }
            k.texImage2D(k.TEXTURE_2D, 0, m, e, f, 0, m, n, c);
            this._contentSize.width = g.width;
            this._contentSize.height = g.height;
            this._pixelsWide = e;
            this._pixelsHigh = f;
            this._pixelFormat = d;
            this.maxS = g.width / e;
            this.maxT = g.height / f;
            this._hasMipmaps = this._hasPremultipliedAlpha = !1;
            this.shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_TEXTURE);
            return this._textureLoaded = !0
        },
        drawAtPoint: function (c) {
            var d = [0, this.maxT, this.maxS, this.maxT, 0, 0, this.maxS, 0], e = cc._renderContext, f = this._pixelsWide * this.maxS, g = this._pixelsHigh * this.maxT;
            c = [c.x, c.y, 0, f + c.x, c.y, 0, c.x, g + c.y, 0, f + c.x, g + c.y, 0];
            this._shaderProgram.use();
            this._shaderProgram.setUniformsForBuiltins();
            cc.glBindTexture2D(this);
            e.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
            e.enableVertexAttribArray(cc.VERTEX_ATTRIB_TEX_COORDS);
            e.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, e.FLOAT,
                !1, 0, c);
            e.vertexAttribPointer(cc.VERTEX_ATTRIB_TEX_COORDS, 2, e.FLOAT, !1, 0, d);
            e.drawArrays(e.TRIANGLE_STRIP, 0, 4)
        },
        drawInRect: function (c) {
            var d = [0, this.maxT, this.maxS, this.maxT, 0, 0, this.maxS, 0];
            c = [c.x, c.y, c.x + c.width, c.y, c.x, c.y + c.height, c.x + c.width, c.y + c.height];
            this._shaderProgram.use();
            this._shaderProgram.setUniformsForBuiltins();
            cc.glBindTexture2D(this);
            var e = cc._renderContext;
            e.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
            e.enableVertexAttribArray(cc.VERTEX_ATTRIB_TEX_COORDS);
            e.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION,
                2, e.FLOAT, !1, 0, c);
            e.vertexAttribPointer(cc.VERTEX_ATTRIB_TEX_COORDS, 2, e.FLOAT, !1, 0, d);
            e.drawArrays(e.TRIANGLE_STRIP, 0, 4)
        },
        initWithImage: function (c) {
            if (null == c)return cc.log(cc._LogInfos.Texture2D_initWithImage), !1;
            var d = c.getWidth(), e = c.getHeight(), f = cc.configuration.getMaxTextureSize();
            if (d > f || e > f)return cc.log(cc._LogInfos.Texture2D_initWithImage_2, d, e, f, f), !1;
            this._textureLoaded = !0;
            return this._initPremultipliedATextureWithImage(c, d, e)
        },
        initWithElement: function (c) {
            c && (this._webTextureObj = cc._renderContext.createTexture(),
                this._htmlElementObj = c, this._hasPremultipliedAlpha = this._textureLoaded = !0)
        },
        getHtmlElementObj: function () {
            return this._htmlElementObj
        },
        isLoaded: function () {
            return this._textureLoaded
        },
        handleLoadedTexture: function (c) {
            c = void 0 !== c ? c : this._hasPremultipliedAlpha;
            if (cc.game._rendererInitialized) {
                if (!this._htmlElementObj) {
                    var d = cc.loader.getRes(this.url);
                    if (!d)return;
                    this.initWithElement(d)
                }
                this._htmlElementObj.width && this._htmlElementObj.height && (d = cc._renderContext, cc.glBindTexture2D(this), d.pixelStorei(d.UNPACK_ALIGNMENT,
                    4), c && d.pixelStorei(d.UNPACK_PREMULTIPLY_ALPHA_WEBGL, 1), d.texImage2D(d.TEXTURE_2D, 0, d.RGBA, d.RGBA, d.UNSIGNED_BYTE, this._htmlElementObj), d.texParameteri(d.TEXTURE_2D, d.TEXTURE_MIN_FILTER, d.LINEAR), d.texParameteri(d.TEXTURE_2D, d.TEXTURE_MAG_FILTER, d.LINEAR), d.texParameteri(d.TEXTURE_2D, d.TEXTURE_WRAP_S, d.CLAMP_TO_EDGE), d.texParameteri(d.TEXTURE_2D, d.TEXTURE_WRAP_T, d.CLAMP_TO_EDGE), this.shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_TEXTURE), cc.glBindTexture2D(null), c && d.pixelStorei(d.UNPACK_PREMULTIPLY_ALPHA_WEBGL,
                    0), d = this._htmlElementObj.height, this._pixelsWide = this._contentSize.width = this._htmlElementObj.width, this._pixelsHigh = this._contentSize.height = d, this._pixelFormat = cc.Texture2D.PIXEL_FORMAT_RGBA8888, this.maxT = this.maxS = 1, this._hasPremultipliedAlpha = c, this._hasMipmaps = !1, this.dispatchEvent("load"))
            }
        },
        initWithString: function (c, d, e, f, g, h) {
            cc.log(cc._LogInfos.Texture2D_initWithString);
            return null
        },
        initWithETCFile: function (c) {
            cc.log(cc._LogInfos.Texture2D_initWithETCFile_2);
            return !1
        },
        initWithPVRFile: function (c) {
            cc.log(cc._LogInfos.Texture2D_initWithPVRFile_2);
            return !1
        },
        initWithPVRTCData: function (c, d, e, f, g, h) {
            cc.log(cc._LogInfos.Texture2D_initWithPVRTCData_2);
            return !1
        },
        setTexParameters: function (c, d, e, f) {
            var g = cc._renderContext;
            void 0 !== d && (c = {minFilter: c, magFilter: d, wrapS: e, wrapT: f});
            cc.assert(this._pixelsWide === cc.NextPOT(this._pixelsWide) && this._pixelsHigh === cc.NextPOT(this._pixelsHigh) || c.wrapS === g.CLAMP_TO_EDGE && c.wrapT === g.CLAMP_TO_EDGE, "WebGLRenderingContext.CLAMP_TO_EDGE should be used in NPOT textures");
            cc.glBindTexture2D(this);
            g.texParameteri(g.TEXTURE_2D,
                g.TEXTURE_MIN_FILTER, c.minFilter);
            g.texParameteri(g.TEXTURE_2D, g.TEXTURE_MAG_FILTER, c.magFilter);
            g.texParameteri(g.TEXTURE_2D, g.TEXTURE_WRAP_S, c.wrapS);
            g.texParameteri(g.TEXTURE_2D, g.TEXTURE_WRAP_T, c.wrapT)
        },
        setAntiAliasTexParameters: function () {
            var c = cc._renderContext;
            cc.glBindTexture2D(this);
            this._hasMipmaps ? c.texParameteri(c.TEXTURE_2D, c.TEXTURE_MIN_FILTER, c.LINEAR_MIPMAP_NEAREST) : c.texParameteri(c.TEXTURE_2D, c.TEXTURE_MIN_FILTER, c.LINEAR);
            c.texParameteri(c.TEXTURE_2D, c.TEXTURE_MAG_FILTER, c.LINEAR)
        },
        setAliasTexParameters: function () {
            var c = cc._renderContext;
            cc.glBindTexture2D(this);
            this._hasMipmaps ? c.texParameteri(c.TEXTURE_2D, c.TEXTURE_MIN_FILTER, c.NEAREST_MIPMAP_NEAREST) : c.texParameteri(c.TEXTURE_2D, c.TEXTURE_MIN_FILTER, c.NEAREST);
            c.texParameteri(c.TEXTURE_2D, c.TEXTURE_MAG_FILTER, c.NEAREST)
        },
        generateMipmap: function () {
            cc.assert(this._pixelsWide === cc.NextPOT(this._pixelsWide) && this._pixelsHigh === cc.NextPOT(this._pixelsHigh), "Mimpap texture only works in POT textures");
            cc.glBindTexture2D(this);
            cc._renderContext.generateMipmap(cc._renderContext.TEXTURE_2D);
            this._hasMipmaps = !0
        },
        stringForFormat: function () {
            return cc.Texture2D._M[this._pixelFormat]
        },
        bitsPerPixelForFormat: function (c) {
            c = c || this._pixelFormat;
            var d = cc.Texture2D._B[c];
            if (null != d)return d;
            cc.log(cc._LogInfos.Texture2D_bitsPerPixelForFormat, c);
            return -1
        },
        _initPremultipliedATextureWithImage: function (c, d, e) {
            var f = cc.Texture2D, g = c.getData(), h = null, h = null, k = c.hasAlpha(), m = cc.size(c.getWidth(), c.getHeight()), n = f.defaultPixelFormat, p = c.getBitsPerComponent();
            k || (8 <= p ? n = f.PIXEL_FORMAT_RGB888 : (cc.log(cc._LogInfos.Texture2D__initPremultipliedATextureWithImage), n = f.PIXEL_FORMAT_RGB565));
            var r = d * e;
            if (n === f.PIXEL_FORMAT_RGB565)if (k)for (g = new Uint16Array(d * e), h = c.getData(), p = 0; p < r; ++p)g[p] = (h[p] >> 0 & 255) >> 3 << 11 | (h[p] >> 8 & 255) >> 2 << 5 | (h[p] >> 16 & 255) >> 3 << 0; else for (g = new Uint16Array(d * e), h = c.getData(), p = 0; p < r; ++p)g[p] = (h[p] & 255) >> 3 << 11 | (h[p] & 255) >> 2 << 5 | (h[p] & 255) >> 3 << 0; else if (n === f.PIXEL_FORMAT_RGBA4444)for (g = new Uint16Array(d * e), h = c.getData(), p = 0; p < r; ++p)g[p] = (h[p] >>
                0 & 255) >> 4 << 12 | (h[p] >> 8 & 255) >> 4 << 8 | (h[p] >> 16 & 255) >> 4 << 4 | (h[p] >> 24 & 255) >> 4 << 0; else if (n === f.PIXEL_FORMAT_RGB5A1)for (g = new Uint16Array(d * e), h = c.getData(), p = 0; p < r; ++p)g[p] = (h[p] >> 0 & 255) >> 3 << 11 | (h[p] >> 8 & 255) >> 3 << 6 | (h[p] >> 16 & 255) >> 3 << 1 | (h[p] >> 24 & 255) >> 7 << 0; else if (n === f.PIXEL_FORMAT_A8)for (g = new Uint8Array(d * e), h = c.getData(), p = 0; p < r; ++p)g[p] = h >> 24 & 255;
            if (k && n === f.PIXEL_FORMAT_RGB888)for (h = c.getData(), g = new Uint8Array(d * e * 3), p = 0; p < r; ++p)g[3 * p] = h >> 0 & 255, g[3 * p + 1] = h >> 8 & 255, g[3 * p + 2] = h >> 16 & 255;
            this.initWithData(g,
                n, d, e, m);
            c.getData();
            this._hasPremultipliedAlpha = c.isPremultipliedAlpha();
            return !0
        },
        addLoadedEventListener: function (c, d) {
            this.addEventListener("load", c, d)
        },
        removeLoadedEventListener: function (c) {
            this.removeEventListener("load", c)
        }
    })
};
cc._tmp.WebGLTextureAtlas = function () {
    var c = cc.TextureAtlas.prototype;
    c._setupVBO = function () {
        var c = cc._renderContext;
        this._buffersVBO[0] = c.createBuffer();
        this._buffersVBO[1] = c.createBuffer();
        this._quadsWebBuffer = c.createBuffer();
        this._mapBuffers()
    };
    c._mapBuffers = function () {
        var c = cc._renderContext;
        c.bindBuffer(c.ARRAY_BUFFER, this._quadsWebBuffer);
        c.bufferData(c.ARRAY_BUFFER, this._quadsArrayBuffer, c.DYNAMIC_DRAW);
        c.bindBuffer(c.ELEMENT_ARRAY_BUFFER, this._buffersVBO[1]);
        c.bufferData(c.ELEMENT_ARRAY_BUFFER,
            this._indices, c.STATIC_DRAW)
    };
    c.drawNumberOfQuads = function (c, e) {
        e = e || 0;
        if (0 !== c && this.texture && this.texture.isLoaded()) {
            var f = cc._renderContext;
            cc.glBindTexture2D(this.texture);
            f.bindBuffer(f.ARRAY_BUFFER, this._quadsWebBuffer);
            this.dirty && (f.bufferData(f.ARRAY_BUFFER, this._quadsArrayBuffer, f.DYNAMIC_DRAW), this.dirty = !1);
            f.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
            f.enableVertexAttribArray(cc.VERTEX_ATTRIB_COLOR);
            f.enableVertexAttribArray(cc.VERTEX_ATTRIB_TEX_COORDS);
            f.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION,
                3, f.FLOAT, !1, 24, 0);
            f.vertexAttribPointer(cc.VERTEX_ATTRIB_COLOR, 4, f.UNSIGNED_BYTE, !0, 24, 12);
            f.vertexAttribPointer(cc.VERTEX_ATTRIB_TEX_COORDS, 2, f.FLOAT, !1, 24, 16);
            f.bindBuffer(f.ELEMENT_ARRAY_BUFFER, this._buffersVBO[1]);
            cc.TEXTURE_ATLAS_USE_TRIANGLE_STRIP ? f.drawElements(f.TRIANGLE_STRIP, 6 * c, f.UNSIGNED_SHORT, 6 * e * this._indices.BYTES_PER_ELEMENT) : f.drawElements(f.TRIANGLES, 6 * c, f.UNSIGNED_SHORT, 6 * e * this._indices.BYTES_PER_ELEMENT);
            cc.g_NumberOfDraws++
        }
    }
};
cc._tmp.WebGLTextureCache = function () {
    var c = cc.textureCache;
    c.handleLoadedTexture = function (c) {
        var e = this._textures, f;
        cc.game._rendererInitialized || (e = this._loadedTexturesBefore);
        f = e[c];
        f || (f = e[c] = new cc.Texture2D, f.url = c);
        ".png" === cc.path.extname(c) ? f.handleLoadedTexture(!0) : f.handleLoadedTexture()
    };
    c.addImage = function (c, e, f) {
        cc.assert(c, cc._LogInfos.Texture2D_addImage_2);
        var g = this._textures;
        cc.game._rendererInitialized || (g = this._loadedTexturesBefore);
        var h = g[c] || g[cc.loader._getAliase(c)];
        if (h)return h.isLoaded() ?
        e && e.call(f, h) : h.addEventListener("load", function () {
            e && e.call(f, h)
        }, f), h;
        h = g[c] = new cc.Texture2D;
        h.url = c;
        var k = cc.loader.getBasePath ? cc.loader.getBasePath() : cc.loader.resPath;
        cc.loader.loadImg(cc.path.join(k || "", c), function (h, k) {
            if (h)return e && e.call(f, h);
            cc.loader.cache[c] || (cc.loader.cache[c] = k);
            cc.textureCache.handleLoadedTexture(c);
            var p = g[c];
            e && e.call(f, p)
        });
        return h
    };
    c.addImageAsync = c.addImage;
    c = null
};
cc._tmp.PrototypeTexture2D = function () {
    var c = cc.Texture2D;
    c.PVRImagesHavePremultipliedAlpha = function (c) {
        cc.PVRHaveAlphaPremultiplied_ = c
    };
    c.PIXEL_FORMAT_RGBA8888 = 2;
    c.PIXEL_FORMAT_RGB888 = 3;
    c.PIXEL_FORMAT_RGB565 = 4;
    c.PIXEL_FORMAT_A8 = 5;
    c.PIXEL_FORMAT_I8 = 6;
    c.PIXEL_FORMAT_AI88 = 7;
    c.PIXEL_FORMAT_RGBA4444 = 8;
    c.PIXEL_FORMAT_RGB5A1 = 7;
    c.PIXEL_FORMAT_PVRTC4 = 9;
    c.PIXEL_FORMAT_PVRTC2 = 10;
    c.PIXEL_FORMAT_DEFAULT = c.PIXEL_FORMAT_RGBA8888;
    c.defaultPixelFormat = c.PIXEL_FORMAT_DEFAULT;
    var d = cc.Texture2D._M = {};
    d[c.PIXEL_FORMAT_RGBA8888] =
        "RGBA8888";
    d[c.PIXEL_FORMAT_RGB888] = "RGB888";
    d[c.PIXEL_FORMAT_RGB565] = "RGB565";
    d[c.PIXEL_FORMAT_A8] = "A8";
    d[c.PIXEL_FORMAT_I8] = "I8";
    d[c.PIXEL_FORMAT_AI88] = "AI88";
    d[c.PIXEL_FORMAT_RGBA4444] = "RGBA4444";
    d[c.PIXEL_FORMAT_RGB5A1] = "RGB5A1";
    d[c.PIXEL_FORMAT_PVRTC4] = "PVRTC4";
    d[c.PIXEL_FORMAT_PVRTC2] = "PVRTC2";
    d = cc.Texture2D._B = {};
    d[c.PIXEL_FORMAT_RGBA8888] = 32;
    d[c.PIXEL_FORMAT_RGB888] = 24;
    d[c.PIXEL_FORMAT_RGB565] = 16;
    d[c.PIXEL_FORMAT_A8] = 8;
    d[c.PIXEL_FORMAT_I8] = 8;
    d[c.PIXEL_FORMAT_AI88] = 16;
    d[c.PIXEL_FORMAT_RGBA4444] =
        16;
    d[c.PIXEL_FORMAT_RGB5A1] = 16;
    d[c.PIXEL_FORMAT_PVRTC4] = 4;
    d[c.PIXEL_FORMAT_PVRTC2] = 3;
    c = cc.Texture2D.prototype;
    cc.defineGetterSetter(c, "name", c.getName);
    cc.defineGetterSetter(c, "pixelFormat", c.getPixelFormat);
    cc.defineGetterSetter(c, "pixelsWidth", c.getPixelsWide);
    cc.defineGetterSetter(c, "pixelsHeight", c.getPixelsHigh);
    cc.defineGetterSetter(c, "width", c._getWidth);
    cc.defineGetterSetter(c, "height", c._getHeight)
};
cc._tmp.PrototypeTextureAtlas = function () {
    var c = cc.TextureAtlas.prototype;
    cc.defineGetterSetter(c, "totalQuads", c.getTotalQuads);
    cc.defineGetterSetter(c, "capacity", c.getCapacity);
    cc.defineGetterSetter(c, "quads", c.getQuads, c.setQuads)
};
cc.ALIGN_CENTER = 51;
cc.ALIGN_TOP = 19;
cc.ALIGN_TOP_RIGHT = 18;
cc.ALIGN_RIGHT = 50;
cc.ALIGN_BOTTOM_RIGHT = 34;
cc.ALIGN_BOTTOM = 35;
cc.ALIGN_BOTTOM_LEFT = 33;
cc.ALIGN_LEFT = 49;
cc.ALIGN_TOP_LEFT = 17;
cc.PVRHaveAlphaPremultiplied_ = !1;
cc.game.addEventListener(cc.game.EVENT_RENDERER_INITED, function () {
    if (cc._renderType === cc.game.RENDER_TYPE_CANVAS) {
        var c = {
            _contentSize: null,
            _textureLoaded: !1,
            _htmlElementObj: null,
            url: null,
            _pattern: null,
            ctor: function () {
                this._contentSize = cc.size(0, 0);
                this._textureLoaded = !1;
                this._htmlElementObj = null;
                this._pattern = ""
            },
            getPixelsWide: function () {
                return this._contentSize.width
            },
            getPixelsHigh: function () {
                return this._contentSize.height
            },
            getContentSize: function () {
                var c = cc.contentScaleFactor();
                return cc.size(this._contentSize.width /
                    c, this._contentSize.height / c)
            },
            _getWidth: function () {
                return this._contentSize.width / cc.contentScaleFactor()
            },
            _getHeight: function () {
                return this._contentSize.height / cc.contentScaleFactor()
            },
            getContentSizeInPixels: function () {
                return this._contentSize
            },
            initWithElement: function (c) {
                c && (this._htmlElementObj = c, this._contentSize.width = c.width, this._contentSize.height = c.height, this._textureLoaded = !0)
            },
            getHtmlElementObj: function () {
                return this._htmlElementObj
            },
            isLoaded: function () {
                return this._textureLoaded
            },
            handleLoadedTexture: function () {
                if (!this._textureLoaded) {
                    if (!this._htmlElementObj) {
                        var c =
                            cc.loader.getRes(this.url);
                        if (!c)return;
                        this.initWithElement(c)
                    }
                    c = this._htmlElementObj;
                    this._contentSize.width = c.width;
                    this._contentSize.height = c.height;
                    this.dispatchEvent("load")
                }
            },
            description: function () {
                return "\x3ccc.Texture2D | width \x3d " + this._contentSize.width + " height " + this._contentSize.height + "\x3e"
            },
            initWithData: function (c, e, f, g, h) {
                return !1
            },
            initWithImage: function (c) {
                return !1
            },
            initWithString: function (c, e, f, g, h, k) {
                return !1
            },
            releaseTexture: function () {
                cc.loader.release(this.url)
            },
            getName: function () {
                return null
            },
            getMaxS: function () {
                return 1
            },
            setMaxS: function (c) {
            },
            getMaxT: function () {
                return 1
            },
            setMaxT: function (c) {
            },
            getPixelFormat: function () {
                return null
            },
            getShaderProgram: function () {
                return null
            },
            setShaderProgram: function (c) {
            },
            hasPremultipliedAlpha: function () {
                return !1
            },
            hasMipmaps: function () {
                return !1
            },
            releaseData: function (c) {
            },
            keepData: function (c, e) {
                return c
            },
            drawAtPoint: function (c) {
            },
            drawInRect: function (c) {
            },
            initWithETCFile: function (c) {
                cc.log(cc._LogInfos.Texture2D_initWithETCFile);
                return !1
            },
            initWithPVRFile: function (c) {
                cc.log(cc._LogInfos.Texture2D_initWithPVRFile);
                return !1
            },
            initWithPVRTCData: function (c, e, f, g, h, k) {
                cc.log(cc._LogInfos.Texture2D_initWithPVRTCData);
                return !1
            },
            setTexParameters: function (c, e, f, g) {
                void 0 !== e && (c = {minFilter: c, magFilter: e, wrapS: f, wrapT: g});
                this._pattern = c.wrapS === cc.REPEAT && c.wrapT === cc.REPEAT ? "repeat" : c.wrapS === cc.REPEAT ? "repeat-x" : c.wrapT === cc.REPEAT ? "repeat-y" : ""
            },
            setAntiAliasTexParameters: function () {
            },
            setAliasTexParameters: function () {
            },
            generateMipmap: function () {
            },
            stringForFormat: function () {
                return ""
            },
            bitsPerPixelForFormat: function (c) {
                return -1
            },
            addLoadedEventListener: function (c, e) {
                this.addEventListener("load", c, e)
            },
            removeLoadedEventListener: function (c) {
                this.removeEventListener("load", c)
            },
            _generateColorTexture: function () {
            },
            _generateTextureCacheForColor: function () {
                if (this.channelCache)return this.channelCache;
                var c = [document.createElement("canvas"), document.createElement("canvas"), document.createElement("canvas"), document.createElement("canvas")], e = this._htmlElementObj, f = e.width, g = e.height;
                c[0].width = f;
                c[0].height = g;
                c[1].width = f;
                c[1].height =
                    g;
                c[2].width = f;
                c[2].height = g;
                c[3].width = f;
                c[3].height = g;
                var h = c[3].getContext("2d");
                h.drawImage(e, 0, 0);
                for (var h = h.getImageData(0, 0, f, g).data, k, m = 0; 4 > m; m++) {
                    k = c[m].getContext("2d");
                    for (var n = k.getImageData(0, 0, f, g), p = n.data, r = 0; r < h.length; r += 4)p[r] = 0 === m ? h[r] : 0, p[r + 1] = 1 === m ? h[r + 1] : 0, p[r + 2] = 2 === m ? h[r + 2] : 0, p[r + 3] = h[r + 3];
                    k.putImageData(n, 0, 0)
                }
                e.onload = null;
                return this.channelCache = c
            },
            _grayElementObj: null,
            _backupElement: null,
            _isGray: !1,
            _switchToGray: function (c) {
                this._textureLoaded && this._isGray !== c &&
                ((this._isGray = c) ? (this._backupElement = this._htmlElementObj, this._grayElementObj || (this._grayElementObj = cc.Texture2D._generateGrayTexture(this._htmlElementObj)), this._htmlElementObj = this._grayElementObj) : null !== this._backupElement && (this._htmlElementObj = this._backupElement))
            }
        };
        c._generateColorTexture = cc.sys._supportCanvasNewBlendModes ? function (c, e, f, g, h) {
            var k = !1;
            h ? k = !0 : h = document.createElement("canvas");
            var m = this._htmlElementObj;
            g || (g = cc.rect(0, 0, m.width, m.height));
            h.width = g.width;
            h.height = g.height;
            var n = h.getContext("2d");
            n.globalCompositeOperation = "source-over";
            n.fillStyle = "rgb(" + (c | 0) + "," + (e | 0) + "," + (f | 0) + ")";
            n.fillRect(0, 0, g.width, g.height);
            n.globalCompositeOperation = "multiply";
            n.drawImage(m, g.x, g.y, g.width, g.height, 0, 0, g.width, g.height);
            n.globalCompositeOperation = "destination-atop";
            n.drawImage(m, g.x, g.y, g.width, g.height, 0, 0, g.width, g.height);
            if (k)return h;
            c = new cc.Texture2D;
            c.initWithElement(h);
            c.handleLoadedTexture();
            return c
        } : function (c, e, f, g, h) {
            var k = !1;
            h ? k = !0 : h = document.createElement("canvas");
            var m = this._htmlElementObj;
            g || (g = cc.rect(0, 0, m.width, m.height));
            var n, p, m = g.x;
            n = g.y;
            p = g.width;
            g = g.height;
            if (p && g) {
                h.width = p;
                h.height = g;
                var r = h.getContext("2d"), s = cc.textureCache.getTextureColors(this);
                r.globalCompositeOperation = "lighter";
                r.drawImage(s[3], m, n, p, g, 0, 0, p, g);
                0 < c && (r.globalAlpha = c / 255, r.drawImage(s[0], m, n, p, g, 0, 0, p, g));
                0 < e && (r.globalAlpha = e / 255, r.drawImage(s[1], m, n, p, g, 0, 0, p, g));
                0 < f && (r.globalAlpha = f / 255, r.drawImage(s[2], m, n, p, g, 0, 0, p, g));
                if (k)return h;
                c = new cc.Texture2D;
                c.initWithElement(h);
                c.handleLoadedTexture();
                return c
            }
        };
        cc.Texture2D = cc.Class.extend(c);
        cc.Texture2D._generateGrayTexture = function (c, e, f) {
            if (null === c)return null;
            f = f || document.createElement("canvas");
            e = e || cc.rect(0, 0, c.width, c.height);
            f.width = e.width;
            f.height = e.height;
            var g = f.getContext("2d");
            g.drawImage(c, e.x, e.y, e.width, e.height, 0, 0, e.width, e.height);
            c = g.getImageData(0, 0, e.width, e.height);
            e = c.data;
            for (var h = 0, k = e.length; h < k; h += 4)e[h] = e[h + 1] = e[h + 2] = 0.34 * e[h] + 0.5 * e[h + 1] + 0.16 * e[h + 2];
            g.putImageData(c, 0, 0);
            return f
        }
    } else cc._renderType ===
    cc.game.RENDER_TYPE_WEBGL && (cc.assert(cc.isFunction(cc._tmp.WebGLTexture2D), cc._LogInfos.MissingFile, "TexturesWebGL.js"), cc._tmp.WebGLTexture2D(), delete cc._tmp.WebGLTexture2D);
    cc.EventHelper.prototype.apply(cc.Texture2D.prototype);
    cc.assert(cc.isFunction(cc._tmp.PrototypeTexture2D), cc._LogInfos.MissingFile, "TexturesPropertyDefine.js");
    cc._tmp.PrototypeTexture2D();
    delete cc._tmp.PrototypeTexture2D
});
cc.textureCache = {
    _textures: {},
    _textureColorsCache: {},
    _textureKeySeq: 0 | 1E3 * Math.random(),
    _loadedTexturesBefore: {},
    _initializingRenderer: function () {
        var c, d = this._loadedTexturesBefore, e = this._textures;
        for (c in d) {
            var f = d[c];
            f.handleLoadedTexture();
            e[c] = f
        }
        this._loadedTexturesBefore = {}
    },
    addPVRTCImage: function (c) {
        cc.log(cc._LogInfos.textureCache_addPVRTCImage)
    },
    addETCImage: function (c) {
        cc.log(cc._LogInfos.textureCache_addETCImage)
    },
    description: function () {
        return "\x3cTextureCache | Number of textures \x3d " +
            this._textures.length + "\x3e"
    },
    textureForKey: function (c) {
        cc.log(cc._LogInfos.textureCache_textureForKey);
        return this.getTextureForKey(c)
    },
    getTextureForKey: function (c) {
        return this._textures[c] || this._textures[cc.loader._getAliase(c)]
    },
    getKeyByTexture: function (c) {
        for (var d in this._textures)if (this._textures[d] === c)return d;
        return null
    },
    _generalTextureKey: function (c) {
        return "_textureKey_" + c
    },
    getTextureColors: function (c) {
        var d = c._htmlElementObj, e = this.getKeyByTexture(d);
        e || (e = d instanceof HTMLImageElement ?
            d.src : this._generalTextureKey(c.__instanceId));
        this._textureColorsCache[e] || (this._textureColorsCache[e] = c._generateTextureCacheForColor());
        return this._textureColorsCache[e]
    },
    addPVRImage: function (c) {
        cc.log(cc._LogInfos.textureCache_addPVRImage)
    },
    removeAllTextures: function () {
        var c = this._textures, d;
        for (d in c)c[d] && c[d].releaseTexture();
        this._textures = {}
    },
    removeTexture: function (c) {
        if (c) {
            var d = this._textures, e;
            for (e in d)d[e] === c && (d[e].releaseTexture(), delete d[e])
        }
    },
    removeTextureForKey: function (c) {
        null !=
        c && this._textures[c] && delete this._textures[c]
    },
    cacheImage: function (c, d) {
        if (d instanceof cc.Texture2D)this._textures[c] = d; else {
            var e = new cc.Texture2D;
            e.initWithElement(d);
            e.handleLoadedTexture();
            this._textures[c] = e
        }
    },
    addUIImage: function (c, d) {
        cc.assert(c, cc._LogInfos.textureCache_addUIImage_2);
        if (d && this._textures[d])return this._textures[d];
        var e = new cc.Texture2D;
        e.initWithImage(c);
        null != d ? this._textures[d] = e : cc.log(cc._LogInfos.textureCache_addUIImage);
        return e
    },
    dumpCachedTextureInfo: function () {
        var c =
            0, d = 0, e = this._textures, f;
        for (f in e) {
            var g = e[f];
            c++;
            g.getHtmlElementObj() instanceof HTMLImageElement ? cc.log(cc._LogInfos.textureCache_dumpCachedTextureInfo, f, g.getHtmlElementObj().src, g.pixelsWidth, g.pixelsHeight) : cc.log(cc._LogInfos.textureCache_dumpCachedTextureInfo_2, f, g.pixelsWidth, g.pixelsHeight);
            d += g.pixelsWidth * g.pixelsHeight * 4
        }
        e = this._textureColorsCache;
        for (f in e) {
            var g = e[f], h;
            for (h in g) {
                var k = g[h];
                c++;
                cc.log(cc._LogInfos.textureCache_dumpCachedTextureInfo_2, f, k.width, k.height);
                d += k.width *
                    k.height * 4
            }
        }
        cc.log(cc._LogInfos.textureCache_dumpCachedTextureInfo_3, c, d / 1024, (d / 1048576).toFixed(2))
    },
    _clear: function () {
        this._textures = {};
        this._textureColorsCache = {};
        this._textureKeySeq = 0 | 1E3 * Math.random();
        this._loadedTexturesBefore = {}
    }
};
cc.game.addEventListener(cc.game.EVENT_RENDERER_INITED, function () {
    if (cc._renderType === cc.game.RENDER_TYPE_CANVAS) {
        var c = cc.textureCache;
        c.handleLoadedTexture = function (c) {
            var e = this._textures, f = e[c];
            f || (f = e[c] = new cc.Texture2D, f.url = c);
            f.handleLoadedTexture()
        };
        c.addImage = function (c, e, f) {
            cc.assert(c, cc._LogInfos.Texture2D_addImage);
            var g = this._textures, h = g[c] || g[cc.loader._getAliase(c)];
            if (h)return h.isLoaded() ? e && e.call(f, h) : h.addEventListener("load", function () {
                e && e.call(f, h)
            }, f), h;
            h = g[c] = new cc.Texture2D;
            h.url = c;
            var k = cc.loader.getBasePath ? cc.loader.getBasePath() : cc.loader.resPath;
            cc.loader.loadImg(cc.path.join(k || "", c), function (h, k) {
                if (h)return e && e.call(f, h);
                cc.loader.cache[c] || (cc.loader.cache[c] = k);
                cc.textureCache.handleLoadedTexture(c);
                var p = g[c];
                e && e.call(f, p)
            });
            return h
        };
        c.addImageAsync = c.addImage;
        c = null
    } else cc._renderType === cc.game.RENDER_TYPE_WEBGL && (cc.assert(cc.isFunction(cc._tmp.WebGLTextureCache), cc._LogInfos.MissingFile, "TexturesWebGL.js"), cc._tmp.WebGLTextureCache(), delete cc._tmp.WebGLTextureCache)
});
cc.TextureAtlas = cc.Class.extend({
    dirty: !1,
    texture: null,
    _indices: null,
    _buffersVBO: null,
    _capacity: 0,
    _quads: null,
    _quadsArrayBuffer: null,
    _quadsWebBuffer: null,
    _quadsReader: null,
    ctor: function (c, d) {
        this._buffersVBO = [];
        cc.isString(c) ? this.initWithFile(c, d) : c instanceof cc.Texture2D && this.initWithTexture(c, d)
    },
    getTotalQuads: function () {
        return this._totalQuads
    },
    getCapacity: function () {
        return this._capacity
    },
    getTexture: function () {
        return this.texture
    },
    setTexture: function (c) {
        this.texture = c
    },
    setDirty: function (c) {
        this.dirty =
            c
    },
    isDirty: function () {
        return this.dirty
    },
    getQuads: function () {
        return this._quads
    },
    setQuads: function (c) {
        this._quads = c
    },
    _copyQuadsToTextureAtlas: function (c, d) {
        if (c)for (var e = 0; e < c.length; e++)this._setQuadToArray(c[e], d + e)
    },
    _setQuadToArray: function (c, d) {
        var e = this._quads;
        e[d] ? (e[d].bl = c.bl, e[d].br = c.br, e[d].tl = c.tl, e[d].tr = c.tr) : e[d] = new cc.V3F_C4B_T2F_Quad(c.tl, c.bl, c.tr, c.br, this._quadsArrayBuffer, d * cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT)
    },
    description: function () {
        return "\x3ccc.TextureAtlas | totalQuads \x3d" +
            this._totalQuads + "\x3e"
    },
    _setupIndices: function () {
        if (0 !== this._capacity)for (var c = this._indices, d = this._capacity, e = 0; e < d; e++)cc.TEXTURE_ATLAS_USE_TRIANGLE_STRIP ? (c[6 * e + 0] = 4 * e + 0, c[6 * e + 1] = 4 * e + 0, c[6 * e + 2] = 4 * e + 2, c[6 * e + 3] = 4 * e + 1, c[6 * e + 4] = 4 * e + 3, c[6 * e + 5] = 4 * e + 3) : (c[6 * e + 0] = 4 * e + 0, c[6 * e + 1] = 4 * e + 1, c[6 * e + 2] = 4 * e + 2, c[6 * e + 3] = 4 * e + 3, c[6 * e + 4] = 4 * e + 2, c[6 * e + 5] = 4 * e + 1)
    },
    _setupVBO: function () {
        var c = cc._renderContext;
        this._buffersVBO[0] = c.createBuffer();
        this._buffersVBO[1] = c.createBuffer();
        this._quadsWebBuffer = c.createBuffer();
        this._mapBuffers()
    },
    _mapBuffers: function () {
        var c = cc._renderContext;
        c.bindBuffer(c.ARRAY_BUFFER, this._quadsWebBuffer);
        c.bufferData(c.ARRAY_BUFFER, this._quadsArrayBuffer, c.DYNAMIC_DRAW);
        c.bindBuffer(c.ELEMENT_ARRAY_BUFFER, this._buffersVBO[1]);
        c.bufferData(c.ELEMENT_ARRAY_BUFFER, this._indices, c.STATIC_DRAW)
    },
    initWithFile: function (c, d) {
        var e = cc.textureCache.addImage(c);
        if (e)return this.initWithTexture(e, d);
        cc.log(cc._LogInfos.TextureAtlas_initWithFile, c);
        return !1
    },
    initWithTexture: function (c, d) {
        cc.assert(c,
            cc._LogInfos.TextureAtlas_initWithTexture);
        this._capacity = d |= 0;
        this._totalQuads = 0;
        this.texture = c;
        this._quads = [];
        this._indices = new Uint16Array(6 * d);
        var e = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT;
        this._quadsArrayBuffer = new ArrayBuffer(e * d);
        this._quadsReader = new Uint8Array(this._quadsArrayBuffer);
        if ((!this._quads || !this._indices) && 0 < d)return !1;
        for (var f = this._quads, g = 0; g < d; g++)f[g] = new cc.V3F_C4B_T2F_Quad(null, null, null, null, this._quadsArrayBuffer, g * e);
        this._setupIndices();
        this._setupVBO();
        return this.dirty = !0
    },
    updateQuad: function (c, d) {
        cc.assert(c, cc._LogInfos.TextureAtlas_updateQuad);
        cc.assert(0 <= d && d < this._capacity, cc._LogInfos.TextureAtlas_updateQuad_2);
        this._totalQuads = Math.max(d + 1, this._totalQuads);
        this._setQuadToArray(c, d);
        this.dirty = !0
    },
    insertQuad: function (c, d) {
        cc.assert(d < this._capacity, cc._LogInfos.TextureAtlas_insertQuad_2);
        this._totalQuads++;
        if (this._totalQuads > this._capacity)cc.log(cc._LogInfos.TextureAtlas_insertQuad); else {
            var e = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT, f = d * e, g = (this._totalQuads -
                1 - d) * e;
            this._quads[this._totalQuads - 1] = new cc.V3F_C4B_T2F_Quad(null, null, null, null, this._quadsArrayBuffer, (this._totalQuads - 1) * e);
            this._quadsReader.set(this._quadsReader.subarray(f, f + g), f + e);
            this._setQuadToArray(c, d);
            this.dirty = !0
        }
    },
    insertQuads: function (c, d, e) {
        e = e || c.length;
        cc.assert(d + e <= this._capacity, cc._LogInfos.TextureAtlas_insertQuads);
        var f = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT;
        this._totalQuads += e;
        if (this._totalQuads > this._capacity)cc.log(cc._LogInfos.TextureAtlas_insertQuad); else {
            var g = d *
                f, h = (this._totalQuads - 1 - d - e) * f, k = this._totalQuads - 1 - e, m;
            for (m = 0; m < e; m++)this._quads[k + m] = new cc.V3F_C4B_T2F_Quad(null, null, null, null, this._quadsArrayBuffer, (this._totalQuads - 1) * f);
            this._quadsReader.set(this._quadsReader.subarray(g, g + h), g + f * e);
            for (m = 0; m < e; m++)this._setQuadToArray(c[m], d + m);
            this.dirty = !0
        }
    },
    insertQuadFromIndex: function (c, d) {
        if (c !== d) {
            cc.assert(0 <= d || d < this._totalQuads, cc._LogInfos.TextureAtlas_insertQuadFromIndex);
            cc.assert(0 <= c || c < this._totalQuads, cc._LogInfos.TextureAtlas_insertQuadFromIndex_2);
            var e = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT, f = this._quadsReader, g = f.subarray(c * e, e), h;
            c > d ? (h = d * e, f.set(f.subarray(h, h + (c - d) * e), h + e), f.set(g, h)) : (h = (c + 1) * e, f.set(f.subarray(h, h + (d - c) * e), h - e), f.set(g, d * e));
            this.dirty = !0
        }
    },
    removeQuadAtIndex: function (c) {
        cc.assert(c < this._totalQuads, cc._LogInfos.TextureAtlas_removeQuadAtIndex);
        var d = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT;
        this._totalQuads--;
        this._quads.length = this._totalQuads;
        if (c !== this._totalQuads) {
            var e = (c + 1) * d;
            this._quadsReader.set(this._quadsReader.subarray(e,
                e + (this._totalQuads - c) * d), e - d)
        }
        this.dirty = !0
    },
    removeQuadsAtIndex: function (c, d) {
        cc.assert(c + d <= this._totalQuads, cc._LogInfos.TextureAtlas_removeQuadsAtIndex);
        this._totalQuads -= d;
        if (c !== this._totalQuads) {
            var e = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT, f = (c + d) * e, g = c * e;
            this._quadsReader.set(this._quadsReader.subarray(f, f + (this._totalQuads - c) * e), g)
        }
        this.dirty = !0
    },
    removeAllQuads: function () {
        this._totalQuads = this._quads.length = 0
    },
    _setDirty: function (c) {
        this.dirty = c
    },
    resizeCapacity: function (c) {
        if (c === this._capacity)return !0;
        var d = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT, e = this._capacity;
        this._totalQuads = Math.min(this._totalQuads, c);
        var f = this._capacity = 0 | c, g = this._totalQuads;
        if (null === this._quads)for (this._quads = [], this._quadsArrayBuffer = new ArrayBuffer(d * f), this._quadsReader = new Uint8Array(this._quadsArrayBuffer), c = 0; c < f; c++)this._quads = new cc.V3F_C4B_T2F_Quad(null, null, null, null, this._quadsArrayBuffer, c * d); else {
            var h, k, m = this._quads;
            if (f > e) {
                h = [];
                k = new ArrayBuffer(d * f);
                for (c = 0; c < g; c++)h[c] = new cc.V3F_C4B_T2F_Quad(m[c].tl,
                    m[c].bl, m[c].tr, m[c].br, k, c * d);
                for (; c < f; c++)h[c] = new cc.V3F_C4B_T2F_Quad(null, null, null, null, k, c * d)
            } else for (g = Math.max(g, f), h = [], k = new ArrayBuffer(d * f), c = 0; c < g; c++)h[c] = new cc.V3F_C4B_T2F_Quad(m[c].tl, m[c].bl, m[c].tr, m[c].br, k, c * d);
            this._quadsReader = new Uint8Array(k);
            this._quads = h;
            this._quadsArrayBuffer = k
        }
        null === this._indices ? this._indices = new Uint16Array(6 * f) : f > e ? (d = new Uint16Array(6 * f), d.set(this._indices, 0), this._indices = d) : this._indices = this._indices.subarray(0, 6 * f);
        this._setupIndices();
        this._mapBuffers();
        return this.dirty = !0
    },
    increaseTotalQuadsWith: function (c) {
        this._totalQuads += c
    },
    moveQuadsFromIndex: function (c, d, e) {
        if (void 0 === e) {
            if (e = d, d = this._totalQuads - c, cc.assert(e + (this._totalQuads - c) <= this._capacity, cc._LogInfos.TextureAtlas_moveQuadsFromIndex), 0 === d)return
        } else if (cc.assert(e + d <= this._totalQuads, cc._LogInfos.TextureAtlas_moveQuadsFromIndex_2), cc.assert(c < this._totalQuads, cc._LogInfos.TextureAtlas_moveQuadsFromIndex_3), c === e)return;
        var f = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT, g = c * f, h = d * f, k = this._quadsReader,
            m = k.subarray(g, g + h), n = e * f;
        e < c ? (d = e * f, k.set(k.subarray(d, d + (c - e) * f), d + h)) : (d = (c + d) * f, k.set(k.subarray(d, d + (e - c) * f), g));
        k.set(m, n);
        this.dirty = !0
    },
    fillWithEmptyQuadsFromIndex: function (c, d) {
        for (var e = d * cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT, f = new Uint8Array(this._quadsArrayBuffer, c * cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT, e), g = 0; g < e; g++)f[g] = 0
    },
    drawQuads: function () {
        this.drawNumberOfQuads(this._totalQuads, 0)
    },
    _releaseBuffer: function () {
        var c = cc._renderContext;
        this._buffersVBO && (this._buffersVBO[0] && c.deleteBuffer(this._buffersVBO[0]),
        this._buffersVBO[1] && c.deleteBuffer(this._buffersVBO[1]));
        this._quadsWebBuffer && c.deleteBuffer(this._quadsWebBuffer)
    }
});
_p = cc.TextureAtlas.prototype;
cc.defineGetterSetter(_p, "totalQuads", _p.getTotalQuads);
cc.defineGetterSetter(_p, "capacity", _p.getCapacity);
cc.defineGetterSetter(_p, "quads", _p.getQuads, _p.setQuads);
cc.TextureAtlas.create = function (c, d) {
    return new cc.TextureAtlas(c, d)
};
cc.TextureAtlas.createWithTexture = cc.TextureAtlas.create;
cc.game.addEventListener(cc.game.EVENT_RENDERER_INITED, function () {
    cc._renderType === cc.game.RENDER_TYPE_WEBGL && (cc.assert(cc.isFunction(cc._tmp.WebGLTextureAtlas), cc._LogInfos.MissingFile, "TexturesWebGL.js"), cc._tmp.WebGLTextureAtlas(), delete cc._tmp.WebGLTextureAtlas)
});
cc.assert(cc.isFunction(cc._tmp.PrototypeTextureAtlas), cc._LogInfos.MissingFile, "TexturesPropertyDefine.js");
cc._tmp.PrototypeTextureAtlas();
delete cc._tmp.PrototypeTextureAtlas;
cc.Scene = cc.Node.extend({
    _className: "Scene", ctor: function () {
        cc.Node.prototype.ctor.call(this);
        this._ignoreAnchorPointForPosition = !0;
        this.setAnchorPoint(0.5, 0.5);
        this.setContentSize(cc.director.getWinSize())
    }
});
cc.Scene.create = function () {
    return new cc.Scene
};
cc.LoaderScene = cc.Scene.extend({
    _interval: null, _label: null, _className: "LoaderScene", cb: null, target: null, init: function () {
        var c = this, d = 101, e = c._bgLayer = new cc.LayerColor(cc.color(255, 255, 255, 255));
        c.addChild(e, 0);
        cc._loaderImage = logoRes;
        var f = 40, g = -d / 2 + 100;
        cc._loaderImage && (cc.loader.loadImg(cc._loaderImage, {isCrossOrigin: !1}, function (e, f) {
            d = f.height;
            c._initStage(f, cc.visibleRect.center)
        }), f = 30, g = -d / 2 - 20);
        f = c._label = new cc.LabelTTF("Loading... 0%", "Arial", f);
        f.setPosition(cc.pAdd(cc.visibleRect.center,
            cc.p(0, g)));
        f.setColor(cc.color(49, 145, 255));
        e.addChild(this._label, 10);
        f.y += 40;
        return !0
    }, c: function (c) {
        c.color = cc.color("#000000")
    }, _initStage: function (c, d) {
        var e = this._texture2d = new cc.Texture2D;
        e.initWithElement(c);
        e.handleLoadedTexture();
        e = this._logo = new cc.Sprite(e);
        e.setScale(cc.contentScaleFactor());
        e.x = d.x;
        e.y = d.y + 50;
        this._bgLayer.addChild(e, 10)
    }, onEnter: function () {
        cc.Node.prototype.onEnter.call(this);
        this.schedule(this._startLoading, 0.3)
    }, onExit: function () {
        cc.Node.prototype.onExit.call(this);
        this._label.setString("Loading... 0%")
    }, initWithResources: function (c, d, e) {
        cc.isString(c) && (c = [c]);
        this.resources = c || [];
        this.cb = d;
        this.target = e
    }, _startLoading: function () {
        var c = this;
        c.unschedule(c._startLoading);
        cc.loader.load(c.resources, function (d, e, f) {
            d = Math.min(f / e * 100 | 0, 100);
            c._label.setString("Loading... " + d + "%")
        }, function () {
            c.cb && (c._label.setString("Loading... 100%"), document.getElementById(cc.game.config.id).style.backgroundColor = "black", c.cb.call(c.target))
        })
    }
});
cc.LoaderScene.preload = function (c, d, e) {
    var f = cc;
    f.loaderScene || (f.loaderScene = new cc.LoaderScene, f.loaderScene.init());
    f.loaderScene.initWithResources(c, d, e);
    cc.director.runScene(f.loaderScene);
    return f.loaderScene
};
var logoRes = "res/logo.png";
cc.Layer = cc.Node.extend({
    _className: "Layer", ctor: function () {
        cc.Node.prototype.ctor.call(this);
        this._ignoreAnchorPointForPosition = !0;
        this.setAnchorPoint(0.5, 0.5);
        this.setContentSize(cc.winSize)
    }, init: function () {
        this._ignoreAnchorPointForPosition = !0;
        this.setAnchorPoint(0.5, 0.5);
        this.setContentSize(cc.winSize);
        this._cascadeOpacityEnabled = this._cascadeColorEnabled = !1;
        return !0
    }, bake: function () {
        this._renderCmd.bake()
    }, unbake: function () {
        this._renderCmd.unbake()
    }, isBaked: function () {
        return this._renderCmd._isBaked
    },
    addChild: function (c, d, e) {
        cc.Node.prototype.addChild.call(this, c, d, e);
        this._renderCmd._bakeForAddChild(c)
    }, _createRenderCmd: function () {
        return cc._renderType === cc.game.RENDER_TYPE_CANVAS ? new cc.Layer.CanvasRenderCmd(this) : new cc.Layer.WebGLRenderCmd(this)
    }
});
cc.Layer.create = function () {
    return new cc.Layer
};
cc.LayerColor = cc.Layer.extend({
    _blendFunc: null, _className: "LayerColor", getBlendFunc: function () {
        return this._blendFunc
    }, changeWidthAndHeight: function (c, d) {
        this.width = c;
        this.height = d
    }, changeWidth: function (c) {
        this.width = c
    }, changeHeight: function (c) {
        this.height = c
    }, setOpacityModifyRGB: function (c) {
    }, isOpacityModifyRGB: function () {
        return !1
    }, ctor: function (c, d, e) {
        cc.Layer.prototype.ctor.call(this);
        this._blendFunc = cc.BlendFunc._alphaNonPremultiplied();
        cc.LayerColor.prototype.init.call(this, c, d, e)
    }, init: function (c,
                       d, e) {
        var f = cc.director.getWinSize();
        c = c || cc.color(0, 0, 0, 255);
        d = void 0 === d ? f.width : d;
        e = void 0 === e ? f.height : e;
        f = this._realColor;
        f.r = c.r;
        f.g = c.g;
        f.b = c.b;
        this._realOpacity = c.a;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty | cc.Node._dirtyFlags.opacityDirty);
        cc.LayerColor.prototype.setContentSize.call(this, d, e);
        return !0
    }, setBlendFunc: function (c, d) {
        var e = this._blendFunc;
        void 0 === d ? (e.src = c.src, e.dst = c.dst) : (e.src = c, e.dst = d);
        this._renderCmd.updateBlendFunc(e)
    }, _createRenderCmd: function () {
        return cc._renderType ===
        cc.game.RENDER_TYPE_CANVAS ? new cc.LayerColor.CanvasRenderCmd(this) : new cc.LayerColor.WebGLRenderCmd(this)
    }
});
cc.LayerColor.create = function (c, d, e) {
    return new cc.LayerColor(c, d, e)
};
(function () {
    var c = cc.LayerColor.prototype;
    cc.defineGetterSetter(c, "width", c._getWidth, c._setWidth);
    cc.defineGetterSetter(c, "height", c._getHeight, c._setHeight)
})();
cc.LayerGradient = cc.LayerColor.extend({
    _endColor: null,
    _startOpacity: 255,
    _endOpacity: 255,
    _alongVector: null,
    _compressedInterpolation: !1,
    _className: "LayerGradient",
    _colorStops: [],
    ctor: function (c, d, e, f) {
        cc.LayerColor.prototype.ctor.call(this);
        this._endColor = cc.color(0, 0, 0, 255);
        this._alongVector = cc.p(0, -1);
        this._endOpacity = this._startOpacity = 255;
        f && f instanceof Array ? (this._colorStops = f, f.splice(0, 0, {
            p: 0,
            color: c || cc.color.BLACK
        }), f.push({p: 1, color: d || cc.color.BLACK})) : this._colorStops = [{p: 0, color: c || cc.color.BLACK},
            {p: 1, color: d || cc.color.BLACK}];
        cc.LayerGradient.prototype.init.call(this, c, d, e, f)
    },
    init: function (c, d, e, f) {
        c = c || cc.color(0, 0, 0, 255);
        d = d || cc.color(0, 0, 0, 255);
        e = e || cc.p(0, -1);
        f = this._endColor;
        this._startOpacity = c.a;
        f.r = d.r;
        f.g = d.g;
        f.b = d.b;
        this._endOpacity = d.a;
        this._alongVector = e;
        this._compressedInterpolation = !0;
        cc.LayerColor.prototype.init.call(this, cc.color(c.r, c.g, c.b, 255));
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty | cc.Node._dirtyFlags.opacityDirty | cc.Node._dirtyFlags.gradientDirty);
        return !0
    },
    setContentSize: function (c, d) {
        cc.LayerColor.prototype.setContentSize.call(this, c, d);
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.gradientDirty)
    },
    _setWidth: function (c) {
        cc.LayerColor.prototype._setWidth.call(this, c);
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.gradientDirty)
    },
    _setHeight: function (c) {
        cc.LayerColor.prototype._setHeight.call(this, c);
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.gradientDirty)
    },
    getStartColor: function () {
        return cc.color(this._realColor)
    },
    setStartColor: function (c) {
        this.color =
            c;
        var d = this._colorStops;
        d && 0 < d.length && (d = d[0].color, d.r = c.r, d.g = c.g, d.b = c.b)
    },
    setEndColor: function (c) {
        var d = this._endColor;
        d.r = c.r;
        d.g = c.g;
        d.b = c.b;
        (d = this._colorStops) && 0 < d.length && (d = d[d.length - 1].color, d.r = c.r, d.g = c.g, d.b = c.b);
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty)
    },
    getEndColor: function () {
        return cc.color(this._endColor)
    },
    setStartOpacity: function (c) {
        this._startOpacity = c;
        var d = this._colorStops;
        d && 0 < d.length && (d[0].color.a = c);
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.opacityDirty)
    },
    getStartOpacity: function () {
        return this._startOpacity
    },
    setEndOpacity: function (c) {
        this._endOpacity = c;
        var d = this._colorStops;
        d && 0 < d.length && (d[d.length - 1].color.a = c);
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.opacityDirty)
    },
    getEndOpacity: function () {
        return this._endOpacity
    },
    setVector: function (c) {
        this._alongVector.x = c.x;
        this._alongVector.y = c.y;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.gradientDirty)
    },
    getVector: function () {
        return cc.p(this._alongVector.x, this._alongVector.y)
    },
    isCompressedInterpolation: function () {
        return this._compressedInterpolation
    },
    setCompressedInterpolation: function (c) {
        this._compressedInterpolation = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.gradientDirty)
    },
    getColorStops: function () {
        return this._colorStops
    },
    setColorStops: function (c) {
        this._colorStops = c;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty | cc.Node._dirtyFlags.opacityDirty | cc.Node._dirtyFlags.gradientDirty)
    },
    _createRenderCmd: function () {
        return cc._renderType === cc.game.RENDER_TYPE_CANVAS ? new cc.LayerGradient.CanvasRenderCmd(this) : new cc.LayerGradient.WebGLRenderCmd(this)
    }
});
cc.LayerGradient.create = function (c, d, e, f) {
    return new cc.LayerGradient(c, d, e, f)
};
(function () {
    var c = cc.LayerGradient.prototype;
    cc.defineGetterSetter(c, "startColor", c.getStartColor, c.setStartColor);
    cc.defineGetterSetter(c, "endColor", c.getEndColor, c.setEndColor);
    cc.defineGetterSetter(c, "startOpacity", c.getStartOpacity, c.setStartOpacity);
    cc.defineGetterSetter(c, "endOpacity", c.getEndOpacity, c.setEndOpacity);
    cc.defineGetterSetter(c, "vector", c.getVector, c.setVector);
    cc.defineGetterSetter(c, "colorStops", c.getColorStops, c.setColorStops)
})();
cc.LayerMultiplex = cc.Layer.extend({
    _enabledLayer: 0, _layers: null, _className: "LayerMultiplex", ctor: function (c) {
        cc.Layer.prototype.ctor.call(this);
        c instanceof Array ? cc.LayerMultiplex.prototype.initWithLayers.call(this, c) : cc.LayerMultiplex.prototype.initWithLayers.call(this, Array.prototype.slice.call(arguments))
    }, initWithLayers: function (c) {
        0 < c.length && null == c[c.length - 1] && cc.log(cc._LogInfos.LayerMultiplex_initWithLayers);
        this._layers = c;
        this._enabledLayer = 0;
        this.addChild(this._layers[this._enabledLayer]);
        return !0
    }, switchTo: function (c) {
        c >= this._layers.length ? cc.log(cc._LogInfos.LayerMultiplex_switchTo) : (this.removeChild(this._layers[this._enabledLayer], !0), this._enabledLayer = c, this.addChild(this._layers[c]))
    }, switchToAndReleaseMe: function (c) {
        c >= this._layers.length ? cc.log(cc._LogInfos.LayerMultiplex_switchToAndReleaseMe) : (this.removeChild(this._layers[this._enabledLayer], !0), this._layers[this._enabledLayer] = null, this._enabledLayer = c, this.addChild(this._layers[c]))
    }, addLayer: function (c) {
        c ? this._layers.push(c) :
            cc.log(cc._LogInfos.LayerMultiplex_addLayer)
    }
});
cc.LayerMultiplex.create = function () {
    return new cc.LayerMultiplex(Array.prototype.slice.call(arguments))
};
(function () {
    cc.Layer.CanvasRenderCmd = function (c) {
        cc.Node.CanvasRenderCmd.call(this, c);
        this._isBaked = !1;
        this._bakeSprite = null;
        this._updateCache = 2
    };
    var c = cc.Layer.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
    c.constructor = cc.Layer.CanvasRenderCmd;
    c._setCacheDirty = function (c) {
        c && 0 === this._updateCache && (this._updateCache = 2);
        !1 === this._cacheDirty && (this._cacheDirty = !0, (c = this._cachedParent) && c !== this && c._setNodeDirtyForCache && c._setNodeDirtyForCache())
    };
    c.updateStatus = function () {
        var c =
            cc.Node._dirtyFlags, e = this._dirtyFlag;
        e & c.orderDirty && (this._cacheDirty = !0, 0 === this._updateCache && (this._updateCache = 2), this._dirtyFlag = e & c.orderDirty ^ e);
        cc.Node.RenderCmd.prototype.updateStatus.call(this)
    };
    c._syncStatus = function (c) {
        var e = cc.Node._dirtyFlags, f = this._dirtyFlag;
        f & e.orderDirty && (this._cacheDirty = !0, 0 === this._updateCache && (this._updateCache = 2), this._dirtyFlag = f & e.orderDirty ^ f);
        cc.Node.RenderCmd.prototype._syncStatus.call(this, c)
    };
    c.transform = function (c, e) {
        var f = this._worldTransform, g =
            f.a, h = f.b, k = f.c, m = f.d;
        cc.Node.CanvasRenderCmd.prototype.transform.call(this, c, e);
        f.a === g && f.b === h && f.c === k && f.d === m || 0 !== this._updateCache || (this._updateCache = 2)
    };
    c.bake = function () {
        if (!this._isBaked) {
            this._needDraw = !0;
            this._isBaked = this._cacheDirty = cc.renderer.childrenOrderDirty = !0;
            0 === this._updateCache && (this._updateCache = 2);
            for (var c = this._node._children, e = 0, f = c.length; e < f; e++)c[e]._renderCmd._setCachedParent(this);
            this._bakeSprite || (this._bakeSprite = new cc.BakeSprite, this._bakeSprite.setAnchorPoint(0,
                0))
        }
    };
    c.unbake = function () {
        if (this._isBaked) {
            cc.renderer.childrenOrderDirty = !0;
            this._isBaked = this._needDraw = !1;
            this._cacheDirty = !0;
            0 === this._updateCache && (this._updateCache = 2);
            for (var c = this._node._children, e = 0, f = c.length; e < f; e++)c[e]._renderCmd._setCachedParent(null)
        }
    };
    c.isBaked = function () {
        return this._isBaked
    };
    c.rendering = function () {
        if (this._cacheDirty) {
            var c = this._node, e = c._children, f = this._bakeSprite;
            this.transform(this.getParentRenderCmd(), !0);
            var g = this._getBoundingBoxForBake();
            g.width = 0 | g.width +
                0.5;
            g.height = 0 | g.height + 0.5;
            var h = f.getCacheContext(), k = h.getContext();
            f.setPosition(g.x, g.y);
            if (0 < this._updateCache) {
                f.resetCanvasSize(g.width, g.height);
                h.setOffset(0 - g.x, k.canvas.height - g.height + g.y);
                c.sortAllChildren();
                cc.renderer._turnToCacheMode(this.__instanceId);
                c = 0;
                for (g = e.length; c < g; c++)e[c].visit(this);
                cc.renderer._renderingToCacheCanvas(h, this.__instanceId);
                f.transform();
                this._updateCache--
            }
            this._cacheDirty = !1
        }
    };
    c.visit = function (c) {
        if (this._isBaked) {
            var e = this._node, f = e._children.length;
            e._visible && 0 !== f && (this._syncStatus(c), cc.renderer.pushRenderCommand(this), this._bakeSprite.visit(this), this._dirtyFlag = 0)
        } else this.originVisit(c)
    };
    c._bakeForAddChild = function (c) {
        c._parent === this._node && this._isBaked && c._renderCmd._setCachedParent(this)
    };
    c._getBoundingBoxForBake = function () {
        var c = null, e = this._node;
        if (!e._children || 0 === e._children.length)return cc.rect(0, 0, 10, 10);
        for (var f = e.getNodeToWorldTransform(), e = e._children, g = 0, h = e.length; g < h; g++) {
            var k = e[g];
            k && k._visible && (c ? (k = k._getBoundingBoxToCurrentNode(f)) &&
            (c = cc.rectUnion(c, k)) : c = k._getBoundingBoxToCurrentNode(f))
        }
        return c
    }
})();
(function () {
    cc.LayerColor.CanvasRenderCmd = function (c) {
        cc.Layer.CanvasRenderCmd.call(this, c);
        this._needDraw = !0;
        this._blendFuncStr = "source-over";
        this._bakeRenderCmd = new cc.CustomRenderCmd(this, this._bakeRendering)
    };
    var c = cc.LayerColor.CanvasRenderCmd.prototype = Object.create(cc.Layer.CanvasRenderCmd.prototype);
    c.constructor = cc.LayerColor.CanvasRenderCmd;
    c.unbake = function () {
        cc.Layer.CanvasRenderCmd.prototype.unbake.call(this);
        this._needDraw = !0
    };
    c.rendering = function (c, e, f) {
        c = c || cc._renderContext;
        var g =
            c.getContext(), h = this._node, k = this._displayedColor, m = this._displayedOpacity / 255, n = h._contentSize.width, h = h._contentSize.height;
        0 !== m && (c.setCompositeOperation(this._blendFuncStr), c.setGlobalAlpha(m), c.setFillStyle("rgba(" + (0 | k.r) + "," + (0 | k.g) + "," + (0 | k.b) + ", 1)"), c.setTransform(this._worldTransform, e, f), g.fillRect(0, 0, n * e, -h * f), cc.g_NumberOfDraws++)
    };
    c.updateBlendFunc = function (c) {
        this._blendFuncStr = cc.Node.CanvasRenderCmd._getCompositeOperationByBlendFunc(c)
    };
    c._updateSquareVertices = c._updateSquareVerticesWidth =
        c._updateSquareVerticesHeight = function () {
        };
    c._bakeRendering = function () {
        if (this._cacheDirty) {
            var c = this._node, e = this._bakeSprite, f = c._children, g = f.length;
            this.transform(this.getParentRenderCmd(), !0);
            var h = this._getBoundingBoxForBake();
            h.width = 0 | h.width + 0.5;
            h.height = 0 | h.height + 0.5;
            var k = e.getCacheContext(), m = k.getContext();
            e.setPosition(h.x, h.y);
            if (0 < this._updateCache) {
                m.fillStyle = k._currentFillStyle;
                e.resetCanvasSize(h.width, h.height);
                k.setOffset(0 - h.x, m.canvas.height - h.height + h.y);
                cc.renderer._turnToCacheMode(this.__instanceId);
                if (0 < g) {
                    c.sortAllChildren();
                    for (c = 0; c < g; c++)if (h = f[c], 0 > h._localZOrder)h._renderCmd.visit(this); else break;
                    for (cc.renderer.pushRenderCommand(this); c < g; c++)f[c]._renderCmd.visit(this)
                } else cc.renderer.pushRenderCommand(this);
                cc.renderer._renderingToCacheCanvas(k, this.__instanceId);
                e.transform();
                this._updateCache--
            }
            this._cacheDirty = !1
        }
    };
    c.visit = function (c) {
        this._isBaked ? this._node._visible && (this._syncStatus(c), cc.renderer.pushRenderCommand(this._bakeRenderCmd), this._bakeSprite._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty),
            this._bakeSprite.visit(this), this._dirtyFlag = 0) : this.originVisit()
    };
    c._getBoundingBoxForBake = function () {
        var c = this._node, e = cc.rect(0, 0, c._contentSize.width, c._contentSize.height), f = c.getNodeToWorldTransform(), e = cc.rectApplyAffineTransform(e, c.getNodeToWorldTransform());
        if (!c._children || 0 === c._children.length)return e;
        for (var c = c._children, g = 0; g < c.length; g++) {
            var h = c[g];
            h && h._visible && (h = h._getBoundingBoxToCurrentNode(f), e = cc.rectUnion(e, h))
        }
        return e
    }
})();
(function () {
    cc.LayerGradient.CanvasRenderCmd = function (c) {
        cc.LayerColor.CanvasRenderCmd.call(this, c);
        this._needDraw = !0;
        this._startPoint = cc.p(0, 0);
        this._endPoint = cc.p(0, 0);
        this._endStopStr = this._startStopStr = null
    };
    var c = cc.LayerGradient.CanvasRenderCmd.prototype = Object.create(cc.LayerColor.CanvasRenderCmd.prototype);
    c.constructor = cc.LayerGradient.CanvasRenderCmd;
    c.rendering = function (c, e, f) {
        c = c || cc._renderContext;
        var g = c.getContext(), h = this._node, k = this._displayedOpacity / 255;
        if (0 !== k) {
            var m = h._contentSize.width,
                n = h._contentSize.height;
            c.setCompositeOperation(this._blendFuncStr);
            c.setGlobalAlpha(k);
            k = g.createLinearGradient(this._startPoint.x * e, this._startPoint.y * f, this._endPoint.x * e, this._endPoint.y * f);
            if (h._colorStops)for (var p = 0; p < h._colorStops.length; p++)k.addColorStop(h._colorStops[p].p, this._colorStopsStr[p]); else k.addColorStop(0, this._startStopStr), k.addColorStop(1, this._endStopStr);
            c.setFillStyle(k);
            c.setTransform(this._worldTransform, e, f);
            g.fillRect(0, 0, m * e, -n * f);
            cc.g_NumberOfDraws++
        }
    };
    c.updateStatus =
        function () {
            var c = cc.Node._dirtyFlags, e = this._dirtyFlag;
            e & c.gradientDirty && (this._dirtyFlag |= c.colorDirty, this._dirtyFlag = e & c.gradientDirty ^ e);
            cc.Node.RenderCmd.prototype.updateStatus.call(this)
        };
    c._syncStatus = function (c) {
        var e = cc.Node._dirtyFlags, f = this._dirtyFlag;
        f & e.gradientDirty && (this._dirtyFlag |= e.colorDirty, this._dirtyFlag = f & e.gradientDirty ^ f);
        cc.Node.RenderCmd.prototype._syncStatus.call(this, c)
    };
    c._updateColor = function () {
        var c = this._node, e = c._contentSize, f = 0.5 * e.width, e = 0.5 * e.height, g = cc.pAngleSigned(cc.p(0,
            -1), c._alongVector), g = cc.pRotateByAngle(cc.p(0, -1), cc.p(0, 0), g), h = Math.min(Math.abs(1 / g.x), Math.abs(1 / g.y));
        this._startPoint.x = f * -g.x * h + f;
        this._startPoint.y = e * g.y * h - e;
        this._endPoint.x = f * g.x * h + f;
        this._endPoint.y = e * -g.y * h - e;
        f = this._displayedColor;
        e = c._endColor;
        g = c._startOpacity / 255;
        h = c._endOpacity / 255;
        this._startStopStr = "rgba(" + Math.round(f.r) + "," + Math.round(f.g) + "," + Math.round(f.b) + "," + g.toFixed(4) + ")";
        this._endStopStr = "rgba(" + Math.round(e.r) + "," + Math.round(e.g) + "," + Math.round(e.b) + "," + h.toFixed(4) +
            ")";
        if (c._colorStops)for (this._endOpacity = this._startOpacity = 0, this._colorStopsStr = [], f = 0; f < c._colorStops.length; f++)e = c._colorStops[f].color, g = null == e.a ? 1 : e.a / 255, this._colorStopsStr.push("rgba(" + Math.round(e.r) + "," + Math.round(e.g) + "," + Math.round(e.b) + "," + g.toFixed(4) + ")")
    }
})();
(function () {
    cc.Layer.WebGLRenderCmd = function (c) {
        cc.Node.WebGLRenderCmd.call(this, c)
    };
    var c = cc.Layer.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
    c.constructor = cc.Layer.WebGLRenderCmd;
    c.bake = function () {
    };
    c.unbake = function () {
    };
    c._bakeForAddChild = function () {
    }
})();
(function () {
    cc.LayerColor.WebGLRenderCmd = function (c) {
        cc.Layer.WebGLRenderCmd.call(this, c);
        this._needDraw = !0;
        this._matrix = new cc.math.Matrix4;
        this._matrix.identity();
        this._squareVerticesAB = new ArrayBuffer(48);
        this._squareColorsAB = new ArrayBuffer(16);
        c = this._squareVerticesAB;
        var e = this._squareColorsAB, f = cc.Vertex3F.BYTES_PER_ELEMENT, g = cc.Color.BYTES_PER_ELEMENT;
        this._squareVertices = [new cc.Vertex3F(0, 0, 0, c, 0), new cc.Vertex3F(0, 0, 0, c, f), new cc.Vertex3F(0, 0, 0, c, 2 * f), new cc.Vertex3F(0, 0, 0, c, 3 * f)];
        this._squareColors =
            [cc.color(0, 0, 0, 255, e, 0), cc.color(0, 0, 0, 255, e, g), cc.color(0, 0, 0, 255, e, 2 * g), cc.color(0, 0, 0, 255, e, 3 * g)];
        this._verticesFloat32Buffer = cc._renderContext.createBuffer();
        this._colorsUint8Buffer = cc._renderContext.createBuffer();
        this._shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_COLOR)
    };
    var c = cc.LayerColor.WebGLRenderCmd.prototype = Object.create(cc.Layer.WebGLRenderCmd.prototype);
    c.constructor = cc.LayerColor.WebGLRenderCmd;
    c.rendering = function (c) {
        c = c || cc._renderContext;
        var e = this._node, f = this._worldTransform;
        this._matrix.mat[0] = f.a;
        this._matrix.mat[4] = f.c;
        this._matrix.mat[12] = f.tx;
        this._matrix.mat[1] = f.b;
        this._matrix.mat[5] = f.d;
        this._matrix.mat[13] = f.ty;
        this._shaderProgram.use();
        this._shaderProgram._setUniformForMVPMatrixWithMat4(this._matrix);
        c.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
        c.enableVertexAttribArray(cc.VERTEX_ATTRIB_COLOR);
        cc.glBlendFunc(e._blendFunc.src, e._blendFunc.dst);
        c.bindBuffer(c.ARRAY_BUFFER, this._verticesFloat32Buffer);
        c.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 3, c.FLOAT,
            !1, 0, 0);
        c.bindBuffer(c.ARRAY_BUFFER, this._colorsUint8Buffer);
        c.vertexAttribPointer(cc.VERTEX_ATTRIB_COLOR, 4, c.UNSIGNED_BYTE, !0, 0, 0);
        c.drawArrays(c.TRIANGLE_STRIP, 0, this._squareVertices.length)
    };
    c.transform = function (c, e) {
        this.originTransform(c, e);
        var f = this._node, g = f._contentSize.width, h = f._contentSize.height, k = this._squareVertices;
        k[1].x = g;
        k[2].y = h;
        k[3].x = g;
        k[3].y = h;
        k[0].z = k[1].z = k[2].z = k[3].z = f._vertexZ;
        this._bindLayerVerticesBufferData()
    };
    c._updateColor = function () {
        for (var c = this._displayedColor,
                 e = this._displayedOpacity, f = this._squareColors, g = 0; 4 > g; g++)f[g].r = c.r, f[g].g = c.g, f[g].b = c.b, f[g].a = e;
        this._bindLayerColorsBufferData()
    };
    c._bindLayerVerticesBufferData = function () {
        var c = cc._renderContext;
        c.bindBuffer(c.ARRAY_BUFFER, this._verticesFloat32Buffer);
        c.bufferData(c.ARRAY_BUFFER, this._squareVerticesAB, c.DYNAMIC_DRAW)
    };
    c._bindLayerColorsBufferData = function () {
        var c = cc._renderContext;
        c.bindBuffer(c.ARRAY_BUFFER, this._colorsUint8Buffer);
        c.bufferData(c.ARRAY_BUFFER, this._squareColorsAB, c.STATIC_DRAW)
    };
    c.updateBlendFunc = function (c) {
    }
})();
(function () {
    cc.LayerGradient.WebGLRenderCmd = function (c) {
        cc.LayerColor.WebGLRenderCmd.call(this, c);
        this._needDraw = !0;
        this._clipRect = new cc.Rect;
        this._clippingRectDirty = !1
    };
    var c = cc.LayerGradient.WebGLRenderCmd.prototype = Object.create(cc.LayerColor.WebGLRenderCmd.prototype);
    c.constructor = cc.LayerGradient.WebGLRenderCmd;
    c.updateStatus = function () {
        var c = cc.Node._dirtyFlags, e = this._dirtyFlag;
        e & c.gradientDirty && (this._dirtyFlag |= c.colorDirty, this._updateVertex(), this._dirtyFlag = e & c.gradientDirty ^ e);
        cc.Node.RenderCmd.prototype.updateStatus.call(this)
    };
    c._syncStatus = function (c) {
        var e = cc.Node._dirtyFlags, f = this._dirtyFlag;
        f & e.gradientDirty && (this._dirtyFlag |= e.colorDirty, this._updateVertex(), this._dirtyFlag = f & e.gradientDirty ^ f);
        cc.Node.RenderCmd.prototype._syncStatus.call(this, c)
    };
    c.transform = function (c, e) {
        this.originTransform(c, e);
        this._updateVertex()
    };
    c._updateVertex = function () {
        var c = this._node, e = c._colorStops;
        if (e && !(2 > e.length)) {
            this._clippingRectDirty = !0;
            var f = e.length, g = 2 * f, h, k = c._contentSize, m = this._squareVertices;
            if (m.length < g) {
                this._squareVerticesAB =
                    new ArrayBuffer(12 * g);
                m.length = 0;
                var n = this._squareVerticesAB, p = cc.Vertex3F.BYTES_PER_ELEMENT;
                for (h = 0; h < g; h++)m.push(new cc.Vertex3F(0, 0, 0, n, p * h))
            }
            var r = Math.PI + cc.pAngleSigned(cc.p(0, -1), c._alongVector), g = cc.p(k.width / 2, k.height / 2);
            h = Math.round(cc.radiansToDegrees(r));
            var n = cc.affineTransformMake(1, 0, 0, 1, g.x, g.y), n = cc.affineTransformRotate(n, r), s;
            90 > h ? (s = cc.p(-g.x, g.y), h = cc.p(g.x, g.y)) : 180 > h ? (s = cc.p(g.x, g.y), h = cc.p(g.x, -g.y)) : 270 > h ? (s = cc.p(g.x, -g.y), h = cc.p(-g.x, -g.y)) : (s = cc.p(-g.x, -g.y), h = cc.p(-g.x,
                g.y));
            p = Math.sin(r);
            r = Math.cos(r);
            s = Math.abs((s.x * r - s.y * p) / g.x);
            h = Math.abs((h.x * p + h.y * r) / g.y);
            n = cc.affineTransformScale(n, s, h);
            for (h = 0; h < f; h++)p = e[h].p * k.height, r = cc.pointApplyAffineTransform(-g.x, p - g.y, n), m[2 * h].x = r.x, m[2 * h].y = r.y, m[2 * h].z = c._vertexZ, p = cc.pointApplyAffineTransform(k.width - g.x, p - g.y, n), m[2 * h + 1].x = p.x, m[2 * h + 1].y = p.y, m[2 * h + 1].z = c._vertexZ;
            this._bindLayerVerticesBufferData()
        }
    };
    c._updateColor = function () {
        var c = this._node._colorStops;
        if (c && !(2 > c.length)) {
            var e = c.length, f = this._squareColors,
                g = 2 * e;
            if (f.length < g) {
                this._squareColorsAB = new ArrayBuffer(4 * g);
                f.length = 0;
                var h = this._squareColorsAB, k = cc.Color.BYTES_PER_ELEMENT;
                for (i = 0; i < g; i++)f.push(cc.color(0, 0, 0, 255, h, k * i))
            }
            g = this._displayedOpacity / 255;
            for (i = 0; i < e; i++) {
                var h = c[i].color, k = f[2 * i], m = f[2 * i + 1];
                k.r = h.r;
                k.g = h.g;
                k.b = h.b;
                k.a = h.a * g;
                m.r = h.r;
                m.g = h.g;
                m.b = h.b;
                m.a = h.a * g
            }
            this._bindLayerColorsBufferData()
        }
    };
    c.rendering = function (c) {
        c = c || cc._renderContext;
        var e = this._node, f = this._getClippingRect();
        c.enable(c.SCISSOR_TEST);
        cc.view.setScissorInPoints(f.x,
            f.y, f.width, f.height);
        f = this._worldTransform;
        this._matrix.mat[0] = f.a;
        this._matrix.mat[4] = f.c;
        this._matrix.mat[12] = f.tx;
        this._matrix.mat[1] = f.b;
        this._matrix.mat[5] = f.d;
        this._matrix.mat[13] = f.ty;
        this._shaderProgram.use();
        this._shaderProgram._setUniformForMVPMatrixWithMat4(this._matrix);
        c.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
        c.enableVertexAttribArray(cc.VERTEX_ATTRIB_COLOR);
        cc.glBlendFunc(e._blendFunc.src, e._blendFunc.dst);
        c.bindBuffer(c.ARRAY_BUFFER, this._verticesFloat32Buffer);
        c.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION,
            3, c.FLOAT, !1, 0, 0);
        c.bindBuffer(c.ARRAY_BUFFER, this._colorsUint8Buffer);
        c.vertexAttribPointer(cc.VERTEX_ATTRIB_COLOR, 4, c.UNSIGNED_BYTE, !0, 0, 0);
        c.drawArrays(c.TRIANGLE_STRIP, 0, this._squareVertices.length);
        c.disable(c.SCISSOR_TEST)
    };
    c._getClippingRect = function () {
        if (this._clippingRectDirty) {
            var c = this._node, e = cc.rect(0, 0, c._contentSize.width, c._contentSize.height), c = c.getNodeToWorldTransform();
            this._clipRect = cc._rectApplyAffineTransformIn(e, c)
        }
        return this._clipRect
    }
})();
cc._tmp.PrototypeSprite = function () {
    var c = cc.Sprite.prototype;
    cc.defineGetterSetter(c, "opacityModifyRGB", c.isOpacityModifyRGB, c.setOpacityModifyRGB);
    cc.defineGetterSetter(c, "opacity", c.getOpacity, c.setOpacity);
    cc.defineGetterSetter(c, "color", c.getColor, c.setColor);
    cc.defineGetterSetter(c, "flippedX", c.isFlippedX, c.setFlippedX);
    cc.defineGetterSetter(c, "flippedY", c.isFlippedY, c.setFlippedY);
    cc.defineGetterSetter(c, "offsetX", c._getOffsetX);
    cc.defineGetterSetter(c, "offsetY", c._getOffsetY);
    cc.defineGetterSetter(c,
        "texture", c.getTexture, c.setTexture);
    cc.defineGetterSetter(c, "textureRectRotated", c.isTextureRectRotated);
    cc.defineGetterSetter(c, "batchNode", c.getBatchNode, c.setBatchNode);
    cc.defineGetterSetter(c, "quad", c.getQuad)
};
cc.Sprite = cc.Node.extend({
    dirty: !1,
    atlasIndex: 0,
    textureAtlas: null,
    _batchNode: null,
    _recursiveDirty: null,
    _hasChildren: null,
    _shouldBeHidden: !1,
    _transformToBatch: null,
    _blendFunc: null,
    _texture: null,
    _rect: null,
    _rectRotated: !1,
    _offsetPosition: null,
    _unflippedOffsetPositionFromCenter: null,
    _opacityModifyRGB: !1,
    _flippedX: !1,
    _flippedY: !1,
    _textureLoaded: !1,
    _className: "Sprite",
    ctor: function (c, d, e) {
        cc.Node.prototype.ctor.call(this);
        this._shouldBeHidden = !1;
        this._offsetPosition = cc.p(0, 0);
        this._unflippedOffsetPositionFromCenter =
            cc.p(0, 0);
        this._blendFunc = {src: cc.BLEND_SRC, dst: cc.BLEND_DST};
        this._rect = cc.rect(0, 0, 0, 0);
        this._softInit(c, d, e)
    },
    textureLoaded: function () {
        return this._textureLoaded
    },
    addLoadedEventListener: function (c, d) {
        this.addEventListener("load", c, d)
    },
    isDirty: function () {
        return this.dirty
    },
    setDirty: function (c) {
        this.dirty = c
    },
    isTextureRectRotated: function () {
        return this._rectRotated
    },
    getAtlasIndex: function () {
        return this.atlasIndex
    },
    setAtlasIndex: function (c) {
        this.atlasIndex = c
    },
    getTextureRect: function () {
        return cc.rect(this._rect)
    },
    getTextureAtlas: function () {
        return this.textureAtlas
    },
    setTextureAtlas: function (c) {
        this.textureAtlas = c
    },
    getOffsetPosition: function () {
        return cc.p(this._offsetPosition)
    },
    _getOffsetX: function () {
        return this._offsetPosition.x
    },
    _getOffsetY: function () {
        return this._offsetPosition.y
    },
    getBlendFunc: function () {
        return this._blendFunc
    },
    initWithSpriteFrame: function (c) {
        cc.assert(c, cc._LogInfos.Sprite_initWithSpriteFrame);
        c.textureLoaded() || (this._textureLoaded = !1, c.addEventListener("load", this._renderCmd._spriteFrameLoadedCallback,
            this));
        var d = cc._renderType === cc.game.RENDER_TYPE_CANVAS ? !1 : c._rotated, d = this.initWithTexture(c.getTexture(), c.getRect(), d);
        this.setSpriteFrame(c);
        return d
    },
    initWithSpriteFrameName: function (c) {
        cc.assert(c, cc._LogInfos.Sprite_initWithSpriteFrameName);
        var d = cc.spriteFrameCache.getSpriteFrame(c);
        cc.assert(d, c + cc._LogInfos.Sprite_initWithSpriteFrameName1);
        return this.initWithSpriteFrame(d)
    },
    useBatchNode: function (c) {
        this.textureAtlas = c.getTextureAtlas();
        this._batchNode = c
    },
    setVertexRect: function (c) {
        var d =
            this._rect;
        d.x = c.x;
        d.y = c.y;
        d.width = c.width;
        d.height = c.height
    },
    sortAllChildren: function () {
        if (this._reorderChildDirty) {
            var c = this._children;
            cc.Node.prototype.sortAllChildren.call(this);
            this._batchNode && this._arrayMakeObjectsPerformSelector(c, cc.Node._stateCallbackType.sortAllChildren);
            this._reorderChildDirty = !1
        }
    },
    reorderChild: function (c, d) {
        cc.assert(c, cc._LogInfos.Sprite_reorderChild_2);
        -1 === this._children.indexOf(c) ? cc.log(cc._LogInfos.Sprite_reorderChild) : d !== c.zIndex && (this._batchNode && !this._reorderChildDirty &&
        (this._setReorderChildDirtyRecursively(), this._batchNode.reorderBatch(!0)), cc.Node.prototype.reorderChild.call(this, c, d))
    },
    removeChild: function (c, d) {
        this._batchNode && this._batchNode.removeSpriteFromAtlas(c);
        cc.Node.prototype.removeChild.call(this, c, d)
    },
    setVisible: function (c) {
        cc.Node.prototype.setVisible.call(this, c);
        this._renderCmd.setDirtyRecursively(!0)
    },
    removeAllChildren: function (c) {
        var d = this._children, e = this._batchNode;
        if (e && null != d)for (var f = 0, g = d.length; f < g; f++)e.removeSpriteFromAtlas(d[f]);
        cc.Node.prototype.removeAllChildren.call(this, c);
        this._hasChildren = !1
    },
    ignoreAnchorPointForPosition: function (c) {
        this._batchNode ? cc.log(cc._LogInfos.Sprite_ignoreAnchorPointForPosition) : cc.Node.prototype.ignoreAnchorPointForPosition.call(this, c)
    },
    setFlippedX: function (c) {
        this._flippedX !== c && (this._flippedX = c, this.setTextureRect(this._rect, this._rectRotated, this._contentSize), this.setNodeDirty(!0))
    },
    setFlippedY: function (c) {
        this._flippedY !== c && (this._flippedY = c, this.setTextureRect(this._rect, this._rectRotated,
            this._contentSize), this.setNodeDirty(!0))
    },
    isFlippedX: function () {
        return this._flippedX
    },
    isFlippedY: function () {
        return this._flippedY
    },
    setOpacityModifyRGB: function (c) {
        this._opacityModifyRGB !== c && (this._opacityModifyRGB = c, this._renderCmd._setColorDirty())
    },
    isOpacityModifyRGB: function () {
        return this._opacityModifyRGB
    },
    setDisplayFrameWithAnimationName: function (c, d) {
        cc.assert(c, cc._LogInfos.Sprite_setDisplayFrameWithAnimationName_3);
        var e = cc.animationCache.getAnimation(c);
        e ? (e = e.getFrames()[d]) ? this.setSpriteFrame(e.getSpriteFrame()) :
            cc.log(cc._LogInfos.Sprite_setDisplayFrameWithAnimationName_2) : cc.log(cc._LogInfos.Sprite_setDisplayFrameWithAnimationName)
    },
    getBatchNode: function () {
        return this._batchNode
    },
    _setReorderChildDirtyRecursively: function () {
        if (!this._reorderChildDirty) {
            this._reorderChildDirty = !0;
            for (var c = this._parent; c && c !== this._batchNode;)c._setReorderChildDirtyRecursively(), c = c.parent
        }
    },
    getTexture: function () {
        return this._texture
    },
    _softInit: function (c, d, e) {
        if (void 0 === c)cc.Sprite.prototype.init.call(this); else if (cc.isString(c))"#" ===
        c[0] ? (d = c.substr(1, c.length - 1), (d = cc.spriteFrameCache.getSpriteFrame(d)) ? this.initWithSpriteFrame(d) : cc.log("%s does not exist", c)) : cc.Sprite.prototype.init.call(this, c, d); else if ("object" === typeof c)if (c instanceof cc.Texture2D)this.initWithTexture(c, d, e); else if (c instanceof cc.SpriteFrame)this.initWithSpriteFrame(c); else if (c instanceof HTMLImageElement || c instanceof HTMLCanvasElement)d = new cc.Texture2D, d.initWithElement(c), d.handleLoadedTexture(), this.initWithTexture(d)
    },
    getQuad: function () {
        return null
    },
    setBlendFunc: function (c, d) {
        var e = this._blendFunc;
        void 0 === d ? (e.src = c.src, e.dst = c.dst) : (e.src = c, e.dst = d);
        this._renderCmd.updateBlendFunc(e)
    },
    init: function () {
        if (0 < arguments.length)return this.initWithFile(arguments[0], arguments[1]);
        cc.Node.prototype.init.call(this);
        this.dirty = this._recursiveDirty = !1;
        this._blendFunc.src = cc.BLEND_SRC;
        this._blendFunc.dst = cc.BLEND_DST;
        this.texture = null;
        this._flippedX = this._flippedY = !1;
        this.anchorY = this.anchorX = 0.5;
        this._offsetPosition.x = 0;
        this._offsetPosition.y = 0;
        this._hasChildren = !1;
        this.setTextureRect(cc.rect(0, 0, 0, 0), !1, cc.size(0, 0));
        return !0
    },
    initWithFile: function (c, d) {
        cc.assert(c, cc._LogInfos.Sprite_initWithFile);
        var e = cc.textureCache.getTextureForKey(c);
        if (e) {
            if (!d) {
                var f = e.getContentSize();
                d = cc.rect(0, 0, f.width, f.height)
            }
            return this.initWithTexture(e, d)
        }
        e = cc.textureCache.addImage(c);
        return this.initWithTexture(e, d || cc.rect(0, 0, e._contentSize.width, e._contentSize.height))
    },
    initWithTexture: function (c, d, e, f) {
        cc.assert(0 !== arguments.length, cc._LogInfos.CCSpriteBatchNode_initWithTexture);
        e = e || !1;
        c = this._renderCmd._handleTextureForRotatedTexture(c, d, e, f);
        if (!cc.Node.prototype.init.call(this))return !1;
        this._batchNode = null;
        this.dirty = this._recursiveDirty = !1;
        this._opacityModifyRGB = !0;
        this._blendFunc.src = cc.BLEND_SRC;
        this._blendFunc.dst = cc.BLEND_DST;
        this._flippedX = this._flippedY = !1;
        this.setAnchorPoint(0.5, 0.5);
        this._offsetPosition.x = 0;
        this._offsetPosition.y = 0;
        this._hasChildren = !1;
        var g = c.isLoaded();
        this._textureLoaded = g;
        if (!g)return this._rectRotated = e, d && (this._rect.x = d.x, this._rect.y =
            d.y, this._rect.width = d.width, this._rect.height = d.height), this.texture && this.texture.removeEventListener("load", this), c.addEventListener("load", this._renderCmd._textureLoadedCallback, this), this.setTexture(c), !0;
        d || (d = cc.rect(0, 0, c.width, c.height));
        this._renderCmd._checkTextureBoundary(c, d, e);
        this.setTexture(c);
        this.setTextureRect(d, e);
        this.setBatchNode(null);
        return !0
    },
    setTextureRect: function (c, d, e, f) {
        this._rectRotated = d || !1;
        this.setContentSize(e || c);
        this.setVertexRect(c);
        this._renderCmd._setTextureCoords(c,
            f);
        c = this._unflippedOffsetPositionFromCenter.x;
        d = this._unflippedOffsetPositionFromCenter.y;
        this._flippedX && (c = -c);
        this._flippedY && (d = -d);
        e = this._rect;
        this._offsetPosition.x = c + (this._contentSize.width - e.width) / 2;
        this._offsetPosition.y = d + (this._contentSize.height - e.height) / 2
    },
    addChild: function (c, d, e) {
        cc.assert(c, cc._LogInfos.CCSpriteBatchNode_addChild_2);
        null == d && (d = c._localZOrder);
        null == e && (e = c.tag);
        this._renderCmd._setBatchNodeForAddChild(c) && (cc.Node.prototype.addChild.call(this, c, d, e), this._hasChildren = !0)
    },
    setSpriteFrame: function (c) {
        var d = this;
        cc.isString(c) && (c = cc.spriteFrameCache.getSpriteFrame(c), cc.assert(c, cc._LogInfos.Sprite_setSpriteFrame));
        this.setNodeDirty(!0);
        var e = c.getOffset();
        d._unflippedOffsetPositionFromCenter.x = e.x;
        d._unflippedOffsetPositionFromCenter.y = e.y;
        e = c.getTexture();
        c.textureLoaded() ? (d._textureLoaded = !0, e !== d._texture && (d._setTexture(e), d.setColor(d._realColor)), d.setTextureRect(c.getRect(), c.isRotated(), c.getOriginalSize())) : (d._textureLoaded = !1, c.addEventListener("load",
            function (c) {
                d._textureLoaded = !0;
                var e = c.getTexture();
                e !== d._texture && d._setTexture(e);
                d.setTextureRect(c.getRect(), c.isRotated(), c.getOriginalSize());
                d.dispatchEvent("load");
                d.setColor(d._realColor)
            }, d));
        this._renderCmd._updateForSetSpriteFrame(e)
    },
    setDisplayFrame: function (c) {
        cc.log(cc._LogInfos.Sprite_setDisplayFrame);
        this.setSpriteFrame(c)
    },
    isFrameDisplayed: function (c) {
        return this._renderCmd.isFrameDisplayed(c)
    },
    displayFrame: function () {
        return this.getSpriteFrame()
    },
    getSpriteFrame: function () {
        return new cc.SpriteFrame(this._texture,
            cc.rectPointsToPixels(this._rect), this._rectRotated, cc.pointPointsToPixels(this._unflippedOffsetPositionFromCenter), cc.sizePointsToPixels(this._contentSize))
    },
    setBatchNode: function (c) {
        (this._batchNode = c) ? (this._transformToBatch = cc.affineTransformIdentity(), this.textureAtlas = this._batchNode.getTextureAtlas()) : (this.atlasIndex = cc.Sprite.INDEX_NOT_INITIALIZED, this.textureAtlas = null, this.dirty = this._recursiveDirty = !1)
    },
    setTexture: function (c) {
        if (!c)return this._renderCmd._setTexture(null);
        var d = cc.isString(c);
        d && (c = cc.textureCache.addImage(c));
        c._textureLoaded ? (this._setTexture(c, d), this.setColor(this._realColor), this._textureLoaded = !0) : (this._renderCmd._setTexture(null), c.addEventListener("load", function () {
            this._setTexture(c, d);
            this.setColor(this._realColor);
            this._textureLoaded = !0
        }, this))
    },
    _setTexture: function (c, d) {
        this._renderCmd._setTexture(c);
        d && this._changeRectWithTexture(c)
    },
    _changeRectWithTexture: function (c) {
        c = c._contentSize;
        c = cc.rect(0, 0, c.width, c.height);
        this.setTextureRect(c)
    },
    _createRenderCmd: function () {
        return cc._renderType ===
        cc.game.RENDER_TYPE_CANVAS ? new cc.Sprite.CanvasRenderCmd(this) : new cc.Sprite.WebGLRenderCmd(this)
    }
});
cc.Sprite.create = function (c, d, e) {
    return new cc.Sprite(c, d, e)
};
cc.Sprite.createWithTexture = cc.Sprite.create;
cc.Sprite.createWithSpriteFrameName = cc.Sprite.create;
cc.Sprite.createWithSpriteFrame = cc.Sprite.create;
cc.Sprite.INDEX_NOT_INITIALIZED = -1;
cc.EventHelper.prototype.apply(cc.Sprite.prototype);
cc.assert(cc.isFunction(cc._tmp.PrototypeSprite), cc._LogInfos.MissingFile, "SpritesPropertyDefine.js");
cc._tmp.PrototypeSprite();
delete cc._tmp.PrototypeSprite;
(function () {
    cc.Sprite.CanvasRenderCmd = function (c) {
        cc.Node.CanvasRenderCmd.call(this, c);
        this._needDraw = !0;
        this._textureCoord = {renderX: 0, renderY: 0, x: 0, y: 0, width: 0, height: 0, validRect: !1};
        this._blendFuncStr = "source-over";
        this._colorized = !1;
        this._textureToRender = null
    };
    var c = cc.Sprite.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
    c.constructor = cc.Sprite.CanvasRenderCmd;
    c.setDirtyRecursively = function (c) {
    };
    c._setTexture = function (c) {
        var e = this._node;
        e._texture !== c && (e._textureLoaded =
            c ? c._textureLoaded : !1, e._texture = c, this._updateColor())
    };
    c._setColorDirty = function () {
        this.setDirtyFlag(cc.Node._dirtyFlags.colorDirty | cc.Node._dirtyFlags.opacityDirty)
    };
    c.isFrameDisplayed = function (c) {
        var e = this._node;
        return c.getTexture() !== e._texture ? !1 : cc.rectEqualToRect(c.getRect(), e._rect)
    };
    c.updateBlendFunc = function (c) {
        this._blendFuncStr = cc.Node.CanvasRenderCmd._getCompositeOperationByBlendFunc(c)
    };
    c._setBatchNodeForAddChild = function (c) {
        return !0
    };
    c._handleTextureForRotatedTexture = function (c,
                                                  e, f, g) {
        f && c.isLoaded() && (c = c.getHtmlElementObj(), c = cc.Sprite.CanvasRenderCmd._cutRotateImageToCanvas(c, e, g), g = new cc.Texture2D, g.initWithElement(c), g.handleLoadedTexture(), c = g, e.x = e.y = 0, this._node._rect = cc.rect(0, 0, e.width, e.height));
        return c
    };
    c._checkTextureBoundary = function (c, e, f) {
        c && c.url && (f = e.y + e.height, e.x + e.width > c.width && cc.error(cc._LogInfos.RectWidth, c.url), f > c.height && cc.error(cc._LogInfos.RectHeight, c.url))
    };
    c.rendering = function (c, e, f) {
        var g = this._node, h = this._textureCoord, k = this._displayedOpacity /
            255, m = this._textureToRender || g._texture;
        if ((!m || 0 !== h.width && 0 !== h.height && m._textureLoaded) && 0 !== k) {
            c = c || cc._renderContext;
            var n = c.getContext(), p = g._offsetPosition.x, r = g._rect.height, s = g._rect.width, v = -g._offsetPosition.y - r;
            c.setTransform(this._worldTransform, e, f);
            c.setCompositeOperation(this._blendFuncStr);
            c.setGlobalAlpha(k);
            (g._flippedX || g._flippedY) && c.save();
            g._flippedX && (p = -p - s, n.scale(-1, 1));
            g._flippedY && (v = g._offsetPosition.y, n.scale(1, -1));
            var t, w, u;
            this._colorized ? t = k = 0 : (k = h.renderX, t =
                h.renderY);
            w = h.width;
            u = h.height;
            p *= e;
            v *= f;
            s *= e;
            r *= f;
            m && m._htmlElementObj ? (e = m._htmlElementObj, "" !== m._pattern ? (c.setFillStyle(n.createPattern(e, m._pattern)), n.fillRect(p, v, s, r)) : n.drawImage(e, k, t, w, u, p, v, s, r)) : (m = g._contentSize, h.validRect && (h = this._displayedColor, c.setFillStyle("rgba(" + h.r + "," + h.g + "," + h.b + ",1)"), n.fillRect(p, v, m.width * e, m.height * f)));
            (g._flippedX || g._flippedY) && c.restore();
            cc.g_NumberOfDraws++
        }
    };
    c._updateColor = function () {
        var c = this._node._texture, e = this._textureCoord, f = this._displayedColor;
        c && (255 !== f.r || 255 !== f.g || 255 !== f.b ? (this._textureToRender = c._generateColorTexture(f.r, f.g, f.b, e), this._colorized = !0) : c && (this._textureToRender = c, this._colorized = !1))
    };
    c._updateForSetSpriteFrame = function (c, e) {
        this._colorized = !1;
        this._textureCoord.renderX = this._textureCoord.x;
        this._textureCoord.renderY = this._textureCoord.y;
        if (e = e || c._textureLoaded) {
            var f = this._node.getColor();
            255 === f.r && 255 === f.g && 255 === f.b || this._updateColor()
        }
    };
    c._spriteFrameLoadedCallback = function (c) {
        this.setTextureRect(c.getRect(),
            c.isRotated(), c.getOriginalSize());
        this._renderCmd._updateColor();
        this.dispatchEvent("load")
    };
    c._textureLoadedCallback = function (c) {
        if (!this._textureLoaded) {
            this._textureLoaded = !0;
            var e = this._rect, f = this._renderCmd;
            e ? cc._rectEqualToZero(e) && (e.width = c.width, e.height = c.height) : e = cc.rect(0, 0, c.width, c.height);
            this.texture = c;
            this.setTextureRect(e, this._rectRotated);
            c = f._displayedColor;
            255 === c.r && 255 === c.g && 255 === c.b || f._updateColor();
            this.setBatchNode(this._batchNode);
            this.dispatchEvent("load")
        }
    };
    c._setTextureCoords =
        function (c, e) {
            void 0 === e && (e = !0);
            var f = this._textureCoord, g = e ? cc.contentScaleFactor() : 1;
            f.renderX = f.x = 0 | c.x * g;
            f.renderY = f.y = 0 | c.y * g;
            f.width = 0 | c.width * g;
            f.height = 0 | c.height * g;
            f.validRect = !(0 === f.width || 0 === f.height || 0 > f.x || 0 > f.y)
        };
    cc.Sprite.CanvasRenderCmd._cutRotateImageToCanvas = function (c, e, f) {
        if (!c)return null;
        if (!e)return c;
        f = null == f ? !0 : f;
        var g = document.createElement("canvas");
        g.width = e.width;
        g.height = e.height;
        var h = g.getContext("2d");
        h.translate(g.width / 2, g.height / 2);
        f ? h.rotate(-1.5707963267948966) :
            h.rotate(1.5707963267948966);
        h.drawImage(c, e.x, e.y, e.height, e.width, -e.height / 2, -e.width / 2, e.height, e.width);
        return g
    }
})();
(function () {
    cc.Sprite.WebGLRenderCmd = function (c) {
        cc.Node.WebGLRenderCmd.call(this, c);
        this._needDraw = !0;
        this._vertices = [{x: 0, y: 0, u: 0, v: 0}, {x: 0, y: 0, u: 0, v: 0}, {x: 0, y: 0, u: 0, v: 0}, {
            x: 0,
            y: 0,
            u: 0,
            v: 0
        }];
        this._color = new Uint32Array(1);
        this._recursiveDirty = this._dirty = !1;
        this._shaderProgram = cc.shaderCache.programForKey(cc.SHADER_SPRITE_POSITION_TEXTURECOLORALPHATEST)
    };
    var c = cc.Sprite.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
    c.constructor = cc.Sprite.WebGLRenderCmd;
    c.updateBlendFunc =
        function (c) {
        };
    c.setDirtyFlag = function (c) {
        cc.Node.WebGLRenderCmd.prototype.setDirtyFlag.call(this, c);
        this._dirty = !0
    };
    c.setDirtyRecursively = function (c) {
        this._dirty = this._recursiveDirty = c;
        for (var e = this._node._children, f, g = e ? e.length : 0, h = 0; h < g; h++)f = e[h], f instanceof cc.Sprite && f._renderCmd.setDirtyRecursively(c)
    };
    c._setBatchNodeForAddChild = function (c) {
        var e = this._node;
        if (e._batchNode) {
            if (!(c instanceof cc.Sprite))return cc.log(cc._LogInfos.Sprite_addChild), !1;
            c.texture._webTextureObj !== e.textureAtlas.texture._webTextureObj &&
            cc.log(cc._LogInfos.Sprite_addChild_2);
            e._batchNode.appendChild(c);
            e._reorderChildDirty || e._setReorderChildDirtyRecursively()
        }
        return !0
    };
    c._handleTextureForRotatedTexture = function (c) {
        return c
    };
    c.isFrameDisplayed = function (c) {
        var e = this._node;
        return cc.rectEqualToRect(c.getRect(), e._rect) && c.getTexture().getName() === e._texture.getName() && cc.pointEqualToPoint(c.getOffset(), e._unflippedOffsetPositionFromCenter)
    };
    c._updateForSetSpriteFrame = function () {
    };
    c._spriteFrameLoadedCallback = function (c) {
        this.setTextureRect(c.getRect(),
            c.isRotated(), c.getOriginalSize());
        this.dispatchEvent("load")
    };
    c._textureLoadedCallback = function (c) {
        if (!this._textureLoaded) {
            this._textureLoaded = !0;
            var e = this._rect;
            e ? cc._rectEqualToZero(e) && (e.width = c.width, e.height = c.height) : e = cc.rect(0, 0, c.width, c.height);
            this.texture = c;
            this.setTextureRect(e, this._rectRotated);
            this.setBatchNode(this._batchNode);
            this.dispatchEvent("load");
            cc.renderer.childrenOrderDirty = !0
        }
    };
    c._setTextureCoords = function (c, e) {
        void 0 === e && (e = !0);
        e && (c = cc.rectPointsToPixels(c));
        var f =
            this._node, g = f._batchNode ? f.textureAtlas.texture : f._texture, h = this._vertices;
        if (g) {
            var k = g.pixelsWidth, m = g.pixelsHeight, n, p;
            f._rectRotated ? (cc.FIX_ARTIFACTS_BY_STRECHING_TEXEL ? (g = (2 * c.x + 1) / (2 * k), k = g + (2 * c.height - 2) / (2 * k), n = (2 * c.y + 1) / (2 * m), m = n + (2 * c.width - 2) / (2 * m)) : (g = c.x / k, k = (c.x + c.height) / k, n = c.y / m, m = (c.y + c.width) / m), f._flippedX && (p = n, n = m, m = p), f._flippedY && (p = g, g = k, k = p), h[0].u = k, h[0].v = n, h[1].u = g, h[1].v = n, h[2].u = k, h[2].v = m, h[3].u = g) : (cc.FIX_ARTIFACTS_BY_STRECHING_TEXEL ? (g = (2 * c.x + 1) / (2 * k), k = g + (2 * c.width -
                2) / (2 * k), n = (2 * c.y + 1) / (2 * m), m = n + (2 * c.height - 2) / (2 * m)) : (g = c.x / k, k = (c.x + c.width) / k, n = c.y / m, m = (c.y + c.height) / m), f._flippedX && (p = g, g = k, k = p), f._flippedY && (p = n, n = m, m = p), h[0].u = g, h[0].v = n, h[1].u = g, h[1].v = m, h[2].u = k, h[2].v = n, h[3].u = k);
            h[3].v = m
        }
    };
    c._setColorDirty = function () {
    };
    c._updateBlendFunc = function () {
        if (this._batchNode)cc.log(cc._LogInfos.Sprite__updateBlendFunc); else {
            var c = this._node, e = c._blendFunc;
            c._texture && c._texture.hasPremultipliedAlpha() ? (e.src === cc.SRC_ALPHA && e.dst === cc.BLEND_DST && (e.src = cc.ONE),
                c.opacityModifyRGB = !0) : (e.src === cc.ONE && e.dst === cc.BLEND_DST && (e.src = cc.SRC_ALPHA), c.opacityModifyRGB = !1)
        }
    };
    c._setTexture = function (c) {
        var e = this._node;
        e._batchNode ? e._batchNode.texture !== c && cc.log(cc._LogInfos.Sprite_setTexture) : e._texture !== c && (e._textureLoaded = c ? c._textureLoaded : !1, e._texture = c, this._updateBlendFunc(), e._textureLoaded && (cc.renderer.childrenOrderDirty = !0))
    };
    c._checkTextureBoundary = function (c, e, f) {
        c && c.url && (f ? (f = e.x + e.height, e = e.y + e.width) : (f = e.x + e.width, e = e.y + e.height), f > c.width &&
        cc.error(cc._LogInfos.RectWidth, c.url), e > c.height && cc.error(cc._LogInfos.RectHeight, c.url))
    };
    c.transform = function (c, e) {
        this.originTransform(c, e);
        var f = this._node, g = f._offsetPosition.x, h = g + f._rect.width, k = f._offsetPosition.y, f = k + f._rect.height, m = this._worldTransform, n = this._vertices;
        n[0].x = g * m.a + f * m.c + m.tx;
        n[0].y = g * m.b + f * m.d + m.ty;
        n[1].x = g * m.a + k * m.c + m.tx;
        n[1].y = g * m.b + k * m.d + m.ty;
        n[2].x = h * m.a + f * m.c + m.tx;
        n[2].y = h * m.b + f * m.d + m.ty;
        n[3].x = h * m.a + k * m.c + m.tx;
        n[3].y = h * m.b + k * m.d + m.ty
    };
    c.needDraw = function () {
        var c =
            this._node._texture;
        return this._needDraw && c
    };
    c.uploadData = function (c, e, f) {
        var g = this._node, h = g._texture;
        if (!(h && h._textureLoaded && g._rect.width && g._rect.height && this._displayedOpacity))return !1;
        var h = this._displayedOpacity, k = this._displayedColor.r, m = this._displayedColor.g, n = this._displayedColor.b;
        if (g._opacityModifyRGB)var p = h / 255, k = k * p, m = m * p, n = n * p;
        this._color[0] = h << 24 | n << 16 | m << 8 | k;
        g = g._vertexZ;
        h = this._vertices;
        k = h.length;
        n = f;
        for (f = 0; f < k; ++f)m = h[f], c[n] = m.x, c[n + 1] = m.y, c[n + 2] = g, e[n + 3] = this._color[0],
            c[n + 4] = m.u, c[n + 5] = m.v, n += 6;
        return k
    }
})();
cc.SpriteBatchNode = cc.Node.extend({
    _blendFunc: null, _texture: null, _className: "SpriteBatchNode", ctor: function (c) {
        cc.Node.prototype.ctor.call(this);
        this._blendFunc = new cc.BlendFunc(cc.BLEND_SRC, cc.BLEND_DST);
        var d;
        cc.isString(c) ? (d = cc.textureCache.getTextureForKey(c)) || (d = cc.textureCache.addImage(c)) : c instanceof cc.Texture2D && (d = c);
        d && this.initWithTexture(d)
    }, addSpriteWithoutQuad: function (c, d, e) {
        this.addChild(c, d, e);
        return this
    }, getTextureAtlas: function () {
        return null
    }, setTextureAtlas: function (c) {
    },
    getDescendants: function () {
        return this._children
    }, initWithFile: function (c, d) {
        var e = cc.textureCache.getTextureForKey(c);
        e || (e = cc.textureCache.addImage(c));
        return this.initWithTexture(e, d)
    }, init: function (c, d) {
        var e = cc.textureCache.getTextureForKey(c);
        e || (e = cc.textureCache.addImage(c));
        return this.initWithTexture(e, d)
    }, increaseAtlasCapacity: function () {
    }, removeChildAtIndex: function (c, d) {
        this.removeChild(this._children[c], d)
    }, rebuildIndexInOrder: function (c, d) {
        return d
    }, highestAtlasIndexInChild: function (c) {
        var d =
            c.children;
        return d && 0 !== d.length ? this.highestAtlasIndexInChild(d[d.length - 1]) : c.zIndex
    }, lowestAtlasIndexInChild: function (c) {
        var d = c.children;
        return d && 0 !== d.length ? this.lowestAtlasIndexInChild(d[d.length - 1]) : c.zIndex
    }, atlasIndexForChild: function (c) {
        return c.zIndex
    }, reorderBatch: function (c) {
        this._reorderChildDirty = c
    }, setBlendFunc: function (c, d) {
        this._blendFunc = void 0 === d ? c : {src: c, dst: d}
    }, getBlendFunc: function () {
        return new cc.BlendFunc(this._blendFunc.src, this._blendFunc.dst)
    }, updateQuadFromSprite: function (c,
                                       d) {
        cc.assert(c, cc._LogInfos.CCSpriteBatchNode_updateQuadFromSprite_2);
        c instanceof cc.Sprite ? (c.dirty = !0, c._renderCmd.transform(this._renderCmd, !0)) : cc.log(cc._LogInfos.CCSpriteBatchNode_updateQuadFromSprite)
    }, insertQuadFromSprite: function (c, d) {
        this.addChild(c, d)
    }, insertChild: function (c, d) {
        this.addChild(c, d)
    }, appendChild: function (c) {
        this.sortAllChildren();
        this.addChild(c.lastLocalZOrder + 1)
    }, removeSpriteFromAtlas: function (c, d) {
        this.removeChild(c, d)
    }, initWithTexture: function (c) {
        this.setTexture(c);
        return !0
    },
    getTexture: function () {
        return this._texture
    }, setTexture: function (c) {
        this._texture = c;
        if (c._textureLoaded) {
            var d = this._children, e, f = d.length;
            for (e = 0; e < f; ++e)d[e].setTexture(c)
        } else c.addEventListener("load", function () {
            var d = this._children, e, f = d.length;
            for (e = 0; e < f; ++e)d[e].setTexture(c)
        }, this)
    }, setShaderProgram: function (c) {
        this._renderCmd.setShaderProgram(c);
        var d = this._children, e, f = d.length;
        for (e = 0; e < f; ++e)d[e].setShaderProgram(c)
    }, addChild: function (c, d, e) {
        cc.assert(void 0 !== c, cc._LogInfos.CCSpriteBatchNode_addChild_3);
        this._isValidChild(c) && (d = void 0 === d ? c.zIndex : d, e = void 0 === e ? c.tag : e, cc.Node.prototype.addChild.call(this, c, d, e), this._renderCmd._shaderProgram && (c.shaderProgram = this._renderCmd._shaderProgram))
    }, _isValidChild: function (c) {
        return c instanceof cc.Sprite ? c.texture !== this._texture ? (cc.log(cc._LogInfos.Sprite_addChild_5), !1) : !0 : (cc.log(cc._LogInfos.Sprite_addChild_4), !1)
    }
});
_p = cc.SpriteBatchNode.prototype;
cc.defineGetterSetter(_p, "texture", _p.getTexture, _p.setTexture);
cc.defineGetterSetter(_p, "shaderProgram", _p.getShaderProgram, _p.setShaderProgram);
cc.SpriteBatchNode.create = function (c) {
    return new cc.SpriteBatchNode(c)
};
cc.SpriteBatchNode.createWithTexture = cc.SpriteBatchNode.create;
cc.BakeSprite = cc.Sprite.extend({
    _cacheCanvas: null, _cacheContext: null, ctor: function () {
        cc.Sprite.prototype.ctor.call(this);
        var c = document.createElement("canvas");
        c.width = c.height = 10;
        this._cacheCanvas = c;
        this._cacheContext = new cc.CanvasContextWrapper(c.getContext("2d"));
        var d = new cc.Texture2D;
        d.initWithElement(c);
        d.handleLoadedTexture();
        this.setTexture(d)
    }, getCacheContext: function () {
        return this._cacheContext
    }, getCacheCanvas: function () {
        return this._cacheCanvas
    }, resetCanvasSize: function (c, d) {
        var e = this._cacheCanvas,
            f = this._cacheContext, g = f._context.strokeStyle, h = f._context.fillStyle;
        void 0 === d && (d = c.height, c = c.width);
        e.width = c;
        e.height = d;
        g !== f._context.strokeStyle && (f._context.strokeStyle = g);
        h !== f._context.fillStyle && (f._context.fillStyle = h);
        this.getTexture().handleLoadedTexture();
        this.setTextureRect(cc.rect(0, 0, c, d), !1, null, !1)
    }
});
cc.AnimationFrame = cc.Class.extend({
    _spriteFrame: null, _delayPerUnit: 0, _userInfo: null, ctor: function (c, d, e) {
        this._spriteFrame = c || null;
        this._delayPerUnit = d || 0;
        this._userInfo = e || null
    }, clone: function () {
        var c = new cc.AnimationFrame;
        c.initWithSpriteFrame(this._spriteFrame.clone(), this._delayPerUnit, this._userInfo);
        return c
    }, copyWithZone: function (c) {
        return cc.clone(this)
    }, copy: function (c) {
        c = new cc.AnimationFrame;
        c.initWithSpriteFrame(this._spriteFrame.clone(), this._delayPerUnit, this._userInfo);
        return c
    }, initWithSpriteFrame: function (c,
                                      d, e) {
        this._spriteFrame = c;
        this._delayPerUnit = d;
        this._userInfo = e;
        return !0
    }, getSpriteFrame: function () {
        return this._spriteFrame
    }, setSpriteFrame: function (c) {
        this._spriteFrame = c
    }, getDelayUnits: function () {
        return this._delayPerUnit
    }, setDelayUnits: function (c) {
        this._delayPerUnit = c
    }, getUserInfo: function () {
        return this._userInfo
    }, setUserInfo: function (c) {
        this._userInfo = c
    }
});
cc.AnimationFrame.create = function (c, d, e) {
    return new cc.AnimationFrame(c, d, e)
};
cc.Animation = cc.Class.extend({
    _frames: null,
    _loops: 0,
    _restoreOriginalFrame: !1,
    _duration: 0,
    _delayPerUnit: 0,
    _totalDelayUnits: 0,
    ctor: function (c, d, e) {
        this._frames = [];
        if (void 0 === c)this.initWithSpriteFrames(null, 0); else {
            var f = c[0];
            f && (f instanceof cc.SpriteFrame ? this.initWithSpriteFrames(c, d, e) : f instanceof cc.AnimationFrame && this.initWithAnimationFrames(c, d, e))
        }
    },
    getFrames: function () {
        return this._frames
    },
    setFrames: function (c) {
        this._frames = c
    },
    addSpriteFrame: function (c) {
        var d = new cc.AnimationFrame;
        d.initWithSpriteFrame(c,
            1, null);
        this._frames.push(d);
        this._totalDelayUnits++
    },
    addSpriteFrameWithFile: function (c) {
        c = cc.textureCache.addImage(c);
        var d = cc.rect(0, 0, 0, 0);
        d.width = c.width;
        d.height = c.height;
        c = new cc.SpriteFrame(c, d);
        this.addSpriteFrame(c)
    },
    addSpriteFrameWithTexture: function (c, d) {
        var e = new cc.SpriteFrame(c, d);
        this.addSpriteFrame(e)
    },
    initWithAnimationFrames: function (c, d, e) {
        cc.arrayVerifyType(c, cc.AnimationFrame);
        this._delayPerUnit = d;
        this._loops = void 0 === e ? 1 : e;
        this._totalDelayUnits = 0;
        d = this._frames;
        for (e = d.length =
            0; e < c.length; e++) {
            var f = c[e];
            d.push(f);
            this._totalDelayUnits += f.getDelayUnits()
        }
        return !0
    },
    clone: function () {
        var c = new cc.Animation;
        c.initWithAnimationFrames(this._copyFrames(), this._delayPerUnit, this._loops);
        c.setRestoreOriginalFrame(this._restoreOriginalFrame);
        return c
    },
    copyWithZone: function (c) {
        c = new cc.Animation;
        c.initWithAnimationFrames(this._copyFrames(), this._delayPerUnit, this._loops);
        c.setRestoreOriginalFrame(this._restoreOriginalFrame);
        return c
    },
    _copyFrames: function () {
        for (var c = [], d = 0; d < this._frames.length; d++)c.push(this._frames[d].clone());
        return c
    },
    copy: function (c) {
        return this.copyWithZone(null)
    },
    getLoops: function () {
        return this._loops
    },
    setLoops: function (c) {
        this._loops = c
    },
    setRestoreOriginalFrame: function (c) {
        this._restoreOriginalFrame = c
    },
    getRestoreOriginalFrame: function () {
        return this._restoreOriginalFrame
    },
    getDuration: function () {
        return this._totalDelayUnits * this._delayPerUnit
    },
    getDelayPerUnit: function () {
        return this._delayPerUnit
    },
    setDelayPerUnit: function (c) {
        this._delayPerUnit = c
    },
    getTotalDelayUnits: function () {
        return this._totalDelayUnits
    },
    initWithSpriteFrames: function (c, d, e) {
        cc.arrayVerifyType(c, cc.SpriteFrame);
        this._loops = void 0 === e ? 1 : e;
        this._delayPerUnit = d || 0;
        this._totalDelayUnits = 0;
        d = this._frames;
        d.length = 0;
        if (c) {
            for (e = 0; e < c.length; e++) {
                var f = c[e], g = new cc.AnimationFrame;
                g.initWithSpriteFrame(f, 1, null);
                d.push(g)
            }
            this._totalDelayUnits += c.length
        }
        return !0
    },
    retain: function () {
    },
    release: function () {
    }
});
cc.Animation.create = function (c, d, e) {
    return new cc.Animation(c, d, e)
};
cc.Animation.createWithAnimationFrames = cc.Animation.create;
cc.animationCache = {
    _animations: {}, addAnimation: function (c, d) {
        this._animations[d] = c
    }, removeAnimation: function (c) {
        c && this._animations[c] && delete this._animations[c]
    }, getAnimation: function (c) {
        return this._animations[c] ? this._animations[c] : null
    }, _addAnimationsWithDictionary: function (c, d) {
        var e = c.animations;
        if (e) {
            var f = 1, g = c.properties;
            if (g)for (var f = null != g.format ? parseInt(g.format) : f, g = g.spritesheets, h = cc.spriteFrameCache, k = cc.path, m = 0; m < g.length; m++)h.addSpriteFrames(k.changeBasename(d, g[m]));
            switch (f) {
                case 1:
                    this._parseVersion1(e);
                    break;
                case 2:
                    this._parseVersion2(e);
                    break;
                default:
                    cc.log(cc._LogInfos.animationCache__addAnimationsWithDictionary_2)
            }
        } else cc.log(cc._LogInfos.animationCache__addAnimationsWithDictionary)
    }, addAnimations: function (c) {
        cc.assert(c, cc._LogInfos.animationCache_addAnimations_2);
        var d = cc.loader.getRes(c);
        d ? this._addAnimationsWithDictionary(d, c) : cc.log(cc._LogInfos.animationCache_addAnimations)
    }, _parseVersion1: function (c) {
        var d = cc.spriteFrameCache, e;
        for (e in c) {
            var f = c[e], g = f.frames, f = parseFloat(f.delay) ||
                0, h = null;
            if (g) {
                for (var h = [], k = 0; k < g.length; k++) {
                    var m = d.getSpriteFrame(g[k]);
                    if (m) {
                        var n = new cc.AnimationFrame;
                        n.initWithSpriteFrame(m, 1, null);
                        h.push(n)
                    } else cc.log(cc._LogInfos.animationCache__parseVersion1_2, e, g[k])
                }
                0 === h.length ? cc.log(cc._LogInfos.animationCache__parseVersion1_3, e) : (h.length !== g.length && cc.log(cc._LogInfos.animationCache__parseVersion1_4, e), h = new cc.Animation(h, f, 1), cc.animationCache.addAnimation(h, e))
            } else cc.log(cc._LogInfos.animationCache__parseVersion1, e)
        }
    }, _parseVersion2: function (c) {
        var d =
            cc.spriteFrameCache, e;
        for (e in c) {
            var f = c[e], g = f.loop, h = parseInt(f.loops), g = g ? cc.REPEAT_FOREVER : isNaN(h) ? 1 : h, h = f.restoreOriginalFrame && !0 == f.restoreOriginalFrame ? !0 : !1, k = f.frames;
            if (k) {
                for (var m = [], n = 0; n < k.length; n++) {
                    var p = k[n], r = p.spriteframe, s = d.getSpriteFrame(r);
                    if (s) {
                        var r = parseFloat(p.delayUnits) || 0, p = p.notification, v = new cc.AnimationFrame;
                        v.initWithSpriteFrame(s, r, p);
                        m.push(v)
                    } else cc.log(cc._LogInfos.animationCache__parseVersion2_2, e, r)
                }
                f = parseFloat(f.delayPerUnit) || 0;
                k = new cc.Animation;
                k.initWithAnimationFrames(m,
                    f, g);
                k.setRestoreOriginalFrame(h);
                cc.animationCache.addAnimation(k, e)
            } else cc.log(cc._LogInfos.animationCache__parseVersion2, e)
        }
    }, _clear: function () {
        this._animations = {}
    }
};
cc.SpriteFrame = cc.Class.extend({
    _offset: null,
    _originalSize: null,
    _rectInPixels: null,
    _rotated: !1,
    _rect: null,
    _offsetInPixels: null,
    _originalSizeInPixels: null,
    _texture: null,
    _textureFilename: "",
    _textureLoaded: !1,
    ctor: function (c, d, e, f, g) {
        this._offset = cc.p(0, 0);
        this._offsetInPixels = cc.p(0, 0);
        this._originalSize = cc.size(0, 0);
        this._rotated = !1;
        this._originalSizeInPixels = cc.size(0, 0);
        this._textureFilename = "";
        this._texture = null;
        this._textureLoaded = !1;
        void 0 !== c && void 0 !== d && (void 0 === e || void 0 === f || void 0 === g ?
            this.initWithTexture(c, d) : this.initWithTexture(c, d, e, f, g))
    },
    textureLoaded: function () {
        return this._textureLoaded
    },
    addLoadedEventListener: function (c, d) {
        this.addEventListener("load", c, d)
    },
    getRectInPixels: function () {
        var c = this._rectInPixels;
        return cc.rect(c.x, c.y, c.width, c.height)
    },
    setRectInPixels: function (c) {
        this._rectInPixels || (this._rectInPixels = cc.rect(0, 0, 0, 0));
        this._rectInPixels.x = c.x;
        this._rectInPixels.y = c.y;
        this._rectInPixels.width = c.width;
        this._rectInPixels.height = c.height;
        this._rect = cc.rectPixelsToPoints(c)
    },
    isRotated: function () {
        return this._rotated
    },
    setRotated: function (c) {
        this._rotated = c
    },
    getRect: function () {
        var c = this._rect;
        return cc.rect(c.x, c.y, c.width, c.height)
    },
    setRect: function (c) {
        this._rect || (this._rect = cc.rect(0, 0, 0, 0));
        this._rect.x = c.x;
        this._rect.y = c.y;
        this._rect.width = c.width;
        this._rect.height = c.height;
        this._rectInPixels = cc.rectPointsToPixels(this._rect)
    },
    getOffsetInPixels: function () {
        return cc.p(this._offsetInPixels)
    },
    setOffsetInPixels: function (c) {
        this._offsetInPixels.x = c.x;
        this._offsetInPixels.y =
            c.y;
        cc._pointPixelsToPointsOut(this._offsetInPixels, this._offset)
    },
    getOriginalSizeInPixels: function () {
        return cc.size(this._originalSizeInPixels)
    },
    setOriginalSizeInPixels: function (c) {
        this._originalSizeInPixels.width = c.width;
        this._originalSizeInPixels.height = c.height
    },
    getOriginalSize: function () {
        return cc.size(this._originalSize)
    },
    setOriginalSize: function (c) {
        this._originalSize.width = c.width;
        this._originalSize.height = c.height
    },
    getTexture: function () {
        if (this._texture)return this._texture;
        if ("" !== this._textureFilename) {
            var c =
                cc.textureCache.addImage(this._textureFilename);
            c && (this._textureLoaded = c.isLoaded());
            return c
        }
        return null
    },
    setTexture: function (c) {
        if (this._texture !== c) {
            var d = c.isLoaded();
            this._textureLoaded = d;
            this._texture = c;
            d || c.addEventListener("load", function (c) {
                this._textureLoaded = !0;
                if (this._rotated && cc._renderType === cc.game.RENDER_TYPE_CANVAS) {
                    var d = c.getHtmlElementObj(), d = cc.Sprite.CanvasRenderCmd._cutRotateImageToCanvas(d, this.getRect()), g = new cc.Texture2D;
                    g.initWithElement(d);
                    g.handleLoadedTexture();
                    this.setTexture(g);
                    d = this.getRect();
                    this.setRect(cc.rect(0, 0, d.width, d.height))
                }
                d = this._rect;
                0 === d.width && 0 === d.height && (d = c.width, c = c.height, this._rect.width = d, this._rect.height = c, this._rectInPixels = cc.rectPointsToPixels(this._rect), this._originalSizeInPixels.width = this._rectInPixels.width, this._originalSizeInPixels.height = this._rectInPixels.height, this._originalSize.width = d, this._originalSize.height = c);
                this.dispatchEvent("load")
            }, this)
        }
    },
    getOffset: function () {
        return cc.p(this._offset)
    },
    setOffset: function (c) {
        this._offset.x =
            c.x;
        this._offset.y = c.y
    },
    clone: function () {
        var c = new cc.SpriteFrame;
        c.initWithTexture(this._textureFilename, this._rectInPixels, this._rotated, this._offsetInPixels, this._originalSizeInPixels);
        c.setTexture(this._texture);
        return c
    },
    copyWithZone: function () {
        var c = new cc.SpriteFrame;
        c.initWithTexture(this._textureFilename, this._rectInPixels, this._rotated, this._offsetInPixels, this._originalSizeInPixels);
        c.setTexture(this._texture);
        return c
    },
    copy: function () {
        return this.copyWithZone()
    },
    initWithTexture: function (c,
                               d, e, f, g) {
        2 === arguments.length && (d = cc.rectPointsToPixels(d));
        f = f || cc.p(0, 0);
        g = g || d;
        e = e || !1;
        cc.isString(c) ? (this._texture = null, this._textureFilename = c) : c instanceof cc.Texture2D && this.setTexture(c);
        c = this.getTexture();
        this._rectInPixels = d;
        this._rect = cc.rectPixelsToPoints(d);
        if (c && c.url && c.isLoaded()) {
            var h, k;
            e ? (h = d.x + d.height, k = d.y + d.width) : (h = d.x + d.width, k = d.y + d.height);
            h > c.getPixelsWide() && cc.error(cc._LogInfos.RectWidth, c.url);
            k > c.getPixelsHigh() && cc.error(cc._LogInfos.RectHeight, c.url)
        }
        this._offsetInPixels.x =
            f.x;
        this._offsetInPixels.y = f.y;
        cc._pointPixelsToPointsOut(f, this._offset);
        this._originalSizeInPixels.width = g.width;
        this._originalSizeInPixels.height = g.height;
        cc._sizePixelsToPointsOut(g, this._originalSize);
        this._rotated = e;
        return !0
    }
});
cc.EventHelper.prototype.apply(cc.SpriteFrame.prototype);
cc.SpriteFrame.create = function (c, d, e, f, g) {
    return new cc.SpriteFrame(c, d, e, f, g)
};
cc.SpriteFrame.createWithTexture = cc.SpriteFrame.create;
cc.SpriteFrame._frameWithTextureForCanvas = function (c, d, e, f, g) {
    var h = new cc.SpriteFrame;
    h._texture = c;
    h._rectInPixels = d;
    h._rect = cc.rectPixelsToPoints(d);
    h._offsetInPixels.x = f.x;
    h._offsetInPixels.y = f.y;
    cc._pointPixelsToPointsOut(h._offsetInPixels, h._offset);
    h._originalSizeInPixels.width = g.width;
    h._originalSizeInPixels.height = g.height;
    cc._sizePixelsToPointsOut(h._originalSizeInPixels, h._originalSize);
    h._rotated = e;
    return h
};
cc.spriteFrameCache = {
    _CCNS_REG1: /^\s*\{\s*([\-]?\d+[.]?\d*)\s*,\s*([\-]?\d+[.]?\d*)\s*\}\s*$/,
    _CCNS_REG2: /^\s*\{\s*\{\s*([\-]?\d+[.]?\d*)\s*,\s*([\-]?\d+[.]?\d*)\s*\}\s*,\s*\{\s*([\-]?\d+[.]?\d*)\s*,\s*([\-]?\d+[.]?\d*)\s*\}\s*\}\s*$/,
    _spriteFrames: {},
    _spriteFramesAliases: {},
    _frameConfigCache: {},
    _rectFromString: function (c) {
        return (c = this._CCNS_REG2.exec(c)) ? cc.rect(parseFloat(c[1]), parseFloat(c[2]), parseFloat(c[3]), parseFloat(c[4])) : cc.rect(0, 0, 0, 0)
    },
    _pointFromString: function (c) {
        return (c = this._CCNS_REG1.exec(c)) ?
            cc.p(parseFloat(c[1]), parseFloat(c[2])) : cc.p(0, 0)
    },
    _sizeFromString: function (c) {
        return (c = this._CCNS_REG1.exec(c)) ? cc.size(parseFloat(c[1]), parseFloat(c[2])) : cc.size(0, 0)
    },
    _getFrameConfig: function (c) {
        var d = cc.loader.getRes(c);
        cc.assert(d, cc._LogInfos.spriteFrameCache__getFrameConfig_2, c);
        cc.loader.release(c);
        if (d._inited)return this._frameConfigCache[c] = d;
        this._frameConfigCache[c] = this._parseFrameConfig(d);
        return this._frameConfigCache[c]
    },
    _getFrameConfigByJsonObject: function (c, d) {
        cc.assert(d, cc._LogInfos.spriteFrameCache__getFrameConfig_2,
            c);
        this._frameConfigCache[c] = this._parseFrameConfig(d);
        return this._frameConfigCache[c]
    },
    _parseFrameConfig: function (c) {
        var d = c.frames, e = c.metadata || c.meta;
        c = {};
        var f = {}, g = 0;
        e && (g = e.format, g = 1 >= g.length ? parseInt(g) : g, f.image = e.textureFileName || e.textureFileName || e.image);
        for (var h in d) {
            var k = d[h];
            if (k) {
                e = {};
                if (0 == g) {
                    e.rect = cc.rect(k.x, k.y, k.width, k.height);
                    e.rotated = !1;
                    e.offset = cc.p(k.offsetX, k.offsetY);
                    var m = k.originalWidth, k = k.originalHeight;
                    m && k || cc.log(cc._LogInfos.spriteFrameCache__getFrameConfig);
                    m = Math.abs(m);
                    k = Math.abs(k);
                    e.size = cc.size(m, k)
                } else if (1 == g || 2 == g)e.rect = this._rectFromString(k.frame), e.rotated = k.rotated || !1, e.offset = this._pointFromString(k.offset), e.size = this._sizeFromString(k.sourceSize); else if (3 == g) {
                    var m = this._sizeFromString(k.spriteSize), n = this._rectFromString(k.textureRect);
                    m && (n = cc.rect(n.x, n.y, m.width, m.height));
                    e.rect = n;
                    e.rotated = k.textureRotated || !1;
                    e.offset = this._pointFromString(k.spriteOffset);
                    e.size = this._sizeFromString(k.spriteSourceSize);
                    e.aliases = k.aliases
                } else m =
                    k.frame, n = k.sourceSize, h = k.filename || h, e.rect = cc.rect(m.x, m.y, m.w, m.h), e.rotated = k.rotated || !1, e.offset = cc.p(0, 0), e.size = cc.size(n.w, n.h);
                c[h] = e
            }
        }
        return {_inited: !0, frames: c, meta: f}
    },
    _addSpriteFramesByObject: function (c, d, e) {
        cc.assert(c, cc._LogInfos.spriteFrameCache_addSpriteFrames_2);
        d && d.frames && (d = this._frameConfigCache[c] || this._getFrameConfigByJsonObject(c, d), this._createSpriteFrames(c, d, e))
    },
    _createSpriteFrames: function (c, d, e) {
        var f = d.frames;
        d = d.meta;
        e ? e instanceof cc.Texture2D || (cc.isString(e) ?
            e = cc.textureCache.addImage(e) : cc.assert(0, cc._LogInfos.spriteFrameCache_addSpriteFrames_3)) : (e = cc.path.changeBasename(c, d.image || ".png"), e = cc.textureCache.addImage(e));
        c = this._spriteFramesAliases;
        d = this._spriteFrames;
        for (var g in f) {
            var h = f[g], k = d[g];
            if (!k) {
                k = new cc.SpriteFrame(e, h.rect, h.rotated, h.offset, h.size);
                if (h = h.aliases)for (var m = 0, n = h.length; m < n; m++) {
                    var p = h[m];
                    c[p] && cc.log(cc._LogInfos.spriteFrameCache_addSpriteFrames, p);
                    c[p] = g
                }
                cc._renderType === cc.game.RENDER_TYPE_CANVAS && k.isRotated() &&
                k.getTexture().isLoaded() && (h = k.getTexture().getHtmlElementObj(), h = cc.Sprite.CanvasRenderCmd._cutRotateImageToCanvas(h, k.getRectInPixels()), m = new cc.Texture2D, m.initWithElement(h), m.handleLoadedTexture(), k.setTexture(m), h = k._rect, k.setRect(cc.rect(0, 0, h.width, h.height)));
                d[g] = k
            }
        }
    },
    addSpriteFrames: function (c, d) {
        cc.assert(c, cc._LogInfos.spriteFrameCache_addSpriteFrames_2);
        var e = this._frameConfigCache[c] || cc.loader.getRes(c);
        e && e.frames && (e = this._frameConfigCache[c] || this._getFrameConfig(c), this._createSpriteFrames(c,
            e, d))
    },
    _checkConflict: function (c) {
        c = c.frames;
        for (var d in c)this._spriteFrames[d] && cc.log(cc._LogInfos.spriteFrameCache__checkConflict, d)
    },
    addSpriteFrame: function (c, d) {
        this._spriteFrames[d] = c
    },
    removeSpriteFrames: function () {
        this._spriteFrames = {};
        this._spriteFramesAliases = {}
    },
    removeSpriteFrameByName: function (c) {
        c && (this._spriteFramesAliases[c] && delete this._spriteFramesAliases[c], this._spriteFrames[c] && delete this._spriteFrames[c])
    },
    removeSpriteFramesFromFile: function (c) {
        var d = this._spriteFrames, e =
            this._spriteFramesAliases;
        if (c = this._frameConfigCache[c]) {
            c = c.frames;
            for (var f in c)if (d[f]) {
                delete d[f];
                for (var g in e)e[g] === f && delete e[g]
            }
        }
    },
    removeSpriteFramesFromTexture: function (c) {
        var d = this._spriteFrames, e = this._spriteFramesAliases, f;
        for (f in d) {
            var g = d[f];
            if (g && g.getTexture() === c) {
                delete d[f];
                for (var h in e)e[h] === f && delete e[h]
            }
        }
    },
    getSpriteFrame: function (c) {
        var d = this._spriteFrames[c];
        if (!d) {
            var e = this._spriteFramesAliases[c];
            e && ((d = this._spriteFrames[e.toString()]) || delete this._spriteFramesAliases[c])
        }
        return d
    },
    _clear: function () {
        this._spriteFrames = {};
        this._spriteFramesAliases = {};
        this._frameConfigCache = {}
    }
};
cc.configuration = {
    ERROR: 0,
    STRING: 1,
    INT: 2,
    DOUBLE: 3,
    BOOLEAN: 4,
    _maxTextureSize: 0,
    _maxModelviewStackDepth: 0,
    _supportsPVRTC: !1,
    _supportsNPOT: !1,
    _supportsBGRA8888: !1,
    _supportsDiscardFramebuffer: !1,
    _supportsShareableVAO: !1,
    _maxSamplesAllowed: 0,
    _maxTextureUnits: 0,
    _GlExtensions: "",
    _valueDict: {},
    _inited: !1,
    _init: function () {
        var c = this._valueDict;
        c["cocos2d.x.version"] = cc.ENGINE_VERSION;
        c["cocos2d.x.compiled_with_profiler"] = !1;
        c["cocos2d.x.compiled_with_gl_state_cache"] = cc.ENABLE_GL_STATE_CACHE;
        this._inited = !0
    },
    getMaxTextureSize: function () {
        return this._maxTextureSize
    },
    getMaxModelviewStackDepth: function () {
        return this._maxModelviewStackDepth
    },
    getMaxTextureUnits: function () {
        return this._maxTextureUnits
    },
    supportsNPOT: function () {
        return this._supportsNPOT
    },
    supportsPVRTC: function () {
        return this._supportsPVRTC
    },
    supportsETC: function () {
        return !1
    },
    supportsS3TC: function () {
        return !1
    },
    supportsATITC: function () {
        return !1
    },
    supportsBGRA8888: function () {
        return this._supportsBGRA8888
    },
    supportsDiscardFramebuffer: function () {
        return this._supportsDiscardFramebuffer
    },
    supportsShareableVAO: function () {
        return this._supportsShareableVAO
    },
    checkForGLExtension: function (c) {
        return -1 < this._GlExtensions.indexOf(c)
    },
    getValue: function (c, d) {
        this._inited || this._init();
        var e = this._valueDict;
        return e[c] ? e[c] : d
    },
    setValue: function (c, d) {
        this._valueDict[c] = d
    },
    dumpInfo: function () {
        0 === cc.ENABLE_GL_STATE_CACHE && (cc.log(""), cc.log(cc._LogInfos.configuration_dumpInfo), cc.log(""))
    },
    gatherGPUInfo: function () {
        if (cc._renderType !== cc.game.RENDER_TYPE_CANVAS) {
            this._inited || this._init();
            var c =
                cc._renderContext, d = this._valueDict;
            d["gl.vendor"] = c.getParameter(c.VENDOR);
            d["gl.renderer"] = c.getParameter(c.RENDERER);
            d["gl.version"] = c.getParameter(c.VERSION);
            this._GlExtensions = "";
            for (var e = c.getSupportedExtensions(), f = 0; f < e.length; f++)this._GlExtensions += e[f] + " ";
            this._maxTextureSize = c.getParameter(c.MAX_TEXTURE_SIZE);
            d["gl.max_texture_size"] = this._maxTextureSize;
            this._maxTextureUnits = c.getParameter(c.MAX_COMBINED_TEXTURE_IMAGE_UNITS);
            d["gl.max_texture_units"] = this._maxTextureUnits;
            this._supportsPVRTC =
                this.checkForGLExtension("GL_IMG_texture_compression_pvrtc");
            d["gl.supports_PVRTC"] = this._supportsPVRTC;
            this._supportsNPOT = !1;
            d["gl.supports_NPOT"] = this._supportsNPOT;
            this._supportsBGRA8888 = this.checkForGLExtension("GL_IMG_texture_format_BGRA888");
            d["gl.supports_BGRA8888"] = this._supportsBGRA8888;
            this._supportsDiscardFramebuffer = this.checkForGLExtension("GL_EXT_discard_framebuffer");
            d["gl.supports_discard_framebuffer"] = this._supportsDiscardFramebuffer;
            this._supportsShareableVAO = this.checkForGLExtension("vertex_array_object");
            d["gl.supports_vertex_array_object"] = this._supportsShareableVAO;
            cc.checkGLErrorDebug()
        }
    },
    loadConfigFile: function (c) {
        this._inited || this._init();
        var d = cc.loader.getRes(c);
        if (!d)throw Error("Please load the resource first : " + c);
        cc.assert(d, cc._LogInfos.configuration_loadConfigFile_2, c);
        if (d = d.data)for (var e in d)this._valueDict[e] = d[e]; else cc.log(cc._LogInfos.configuration_loadConfigFile, c)
    }
};
cc.g_NumberOfDraws = 0;
cc.Director = cc.Class.extend({
    _landscape: !1,
    _nextDeltaTimeZero: !1,
    _paused: !1,
    _purgeDirectorInNextLoop: !1,
    _sendCleanupToScene: !1,
    _animationInterval: 0,
    _oldAnimationInterval: 0,
    _projection: 0,
    _contentScaleFactor: 1,
    _deltaTime: 0,
    _winSizeInPoints: null,
    _lastUpdate: null,
    _nextScene: null,
    _notificationNode: null,
    _openGLView: null,
    _scenesStack: null,
    _projectionDelegate: null,
    _runningScene: null,
    _totalFrames: 0,
    _secondsPerFrame: 0,
    _dirtyRegion: null,
    _scheduler: null,
    _actionManager: null,
    _eventProjectionChanged: null,
    _eventAfterUpdate: null,
    _eventAfterVisit: null,
    _eventAfterDraw: null,
    ctor: function () {
        var c = this;
        c._lastUpdate = Date.now();
        cc.eventManager.addCustomListener(cc.game.EVENT_SHOW, function () {
            c._lastUpdate = Date.now()
        })
    },
    init: function () {
        this._oldAnimationInterval = this._animationInterval = 1 / cc.defaultFPS;
        this._scenesStack = [];
        this._projection = cc.Director.PROJECTION_DEFAULT;
        this._projectionDelegate = null;
        this._totalFrames = 0;
        this._lastUpdate = Date.now();
        this._purgeDirectorInNextLoop = this._paused = !1;
        this._winSizeInPoints = cc.size(0, 0);
        this._openGLView =
            null;
        this._contentScaleFactor = 1;
        this._scheduler = new cc.Scheduler;
        cc.ActionManager ? (this._actionManager = new cc.ActionManager, this._scheduler.scheduleUpdate(this._actionManager, cc.Scheduler.PRIORITY_SYSTEM, !1)) : this._actionManager = null;
        this._eventAfterUpdate = new cc.EventCustom(cc.Director.EVENT_AFTER_UPDATE);
        this._eventAfterUpdate.setUserData(this);
        this._eventAfterVisit = new cc.EventCustom(cc.Director.EVENT_AFTER_VISIT);
        this._eventAfterVisit.setUserData(this);
        this._eventAfterDraw = new cc.EventCustom(cc.Director.EVENT_AFTER_DRAW);
        this._eventAfterDraw.setUserData(this);
        this._eventProjectionChanged = new cc.EventCustom(cc.Director.EVENT_PROJECTION_CHANGED);
        this._eventProjectionChanged.setUserData(this);
        return !0
    },
    calculateDeltaTime: function () {
        var c = Date.now();
        this._nextDeltaTimeZero ? (this._deltaTime = 0, this._nextDeltaTimeZero = !1) : this._deltaTime = (c - this._lastUpdate) / 1E3;
        0 < cc.game.config[cc.game.CONFIG_KEY.debugMode] && 0.2 < this._deltaTime && (this._deltaTime = 1 / 60);
        this._lastUpdate = c
    },
    convertToGL: function (c) {
        var d = document.documentElement,
            e = cc.view, f = element.getBoundingClientRect();
        f.left += window.pageXOffset - d.clientLeft;
        f.top += window.pageYOffset - d.clientTop;
        d = e._devicePixelRatio * (c.x - f.left);
        c = e._devicePixelRatio * (f.top + f.height - c.y);
        return e._isRotated ? {x: e._viewPortRect.width - c, y: d} : {x: d, y: c}
    },
    convertToUI: function (c) {
        var d = document.documentElement, e = cc.view, f = element.getBoundingClientRect();
        f.left += window.pageXOffset - d.clientLeft;
        f.top += window.pageYOffset - d.clientTop;
        d = {x: 0, y: 0};
        e._isRotated ? (d.x = f.left + c.y / e._devicePixelRatio,
            d.y = f.top + f.height - (e._viewPortRect.width - c.x) / e._devicePixelRatio) : (d.x = f.left + c.x / e._devicePixelRatio, d.y = f.top + f.height - c.y / e._devicePixelRatio);
        return d
    },
    drawScene: function () {
        var c = cc.renderer;
        this.calculateDeltaTime();
        this._paused || (this._scheduler.update(this._deltaTime), cc.eventManager.dispatchEvent(this._eventAfterUpdate));
        this._nextScene && this.setNextScene();
        this._beforeVisitScene && this._beforeVisitScene();
        this._runningScene && (!0 === c.childrenOrderDirty ? (cc.renderer.clearRenderCommands(),
            cc.renderer.assignedZ = 0, this._runningScene._renderCmd._curLevel = 0, this._runningScene.visit(), c.resetFlag()) : !0 === c.transformDirty() && c.transform());
        c.clear();
        this._notificationNode && this._notificationNode.visit();
        cc.eventManager.dispatchEvent(this._eventAfterVisit);
        cc.g_NumberOfDraws = 0;
        this._afterVisitScene && this._afterVisitScene();
        c.rendering(cc._renderContext);
        this._totalFrames++;
        cc.eventManager.dispatchEvent(this._eventAfterDraw);
        this._calculateMPF()
    },
    _beforeVisitScene: null,
    _afterVisitScene: null,
    end: function () {
        this._purgeDirectorInNextLoop = !0
    },
    getContentScaleFactor: function () {
        return this._contentScaleFactor
    },
    getNotificationNode: function () {
        return this._notificationNode
    },
    getWinSize: function () {
        return cc.size(this._winSizeInPoints)
    },
    getWinSizeInPixels: function () {
        return cc.size(this._winSizeInPoints.width * this._contentScaleFactor, this._winSizeInPoints.height * this._contentScaleFactor)
    },
    getVisibleSize: null,
    getVisibleOrigin: null,
    getZEye: null,
    pause: function () {
        this._paused || (this._oldAnimationInterval =
            this._animationInterval, this.setAnimationInterval(0.25), this._paused = !0)
    },
    popScene: function () {
        cc.assert(this._runningScene, cc._LogInfos.Director_popScene);
        this._scenesStack.pop();
        var c = this._scenesStack.length;
        0 === c ? this.end() : (this._sendCleanupToScene = !0, this._nextScene = this._scenesStack[c - 1])
    },
    purgeCachedData: function () {
        cc.animationCache._clear();
        cc.spriteFrameCache._clear();
        cc.textureCache._clear()
    },
    purgeDirector: function () {
        this.getScheduler().unscheduleAll();
        cc.eventManager && cc.eventManager.setEnabled(!1);
        this._runningScene && (this._runningScene.onExitTransitionDidStart(), this._runningScene.onExit(), this._runningScene.cleanup());
        this._nextScene = this._runningScene = null;
        this._scenesStack.length = 0;
        this.stopAnimation();
        this.purgeCachedData();
        cc.checkGLErrorDebug()
    },
    pushScene: function (c) {
        cc.assert(c, cc._LogInfos.Director_pushScene);
        this._sendCleanupToScene = !1;
        this._scenesStack.push(c);
        this._nextScene = c
    },
    runScene: function (c) {
        cc.assert(c, cc._LogInfos.Director_pushScene);
        if (this._runningScene) {
            var d = this._scenesStack.length;
            0 === d ? (this._sendCleanupToScene = !0, this._scenesStack[d] = c) : (this._sendCleanupToScene = !0, this._scenesStack[d - 1] = c);
            this._nextScene = c
        } else this.pushScene(c), this.startAnimation()
    },
    resume: function () {
        this._paused && (this.setAnimationInterval(this._oldAnimationInterval), (this._lastUpdate = Date.now()) || cc.log(cc._LogInfos.Director_resume), this._paused = !1, this._deltaTime = 0)
    },
    setContentScaleFactor: function (c) {
        c !== this._contentScaleFactor && (this._contentScaleFactor = c)
    },
    setDepthTest: null,
    setClearColor: null,
    setDefaultValues: function () {
    },
    setNextDeltaTimeZero: function (c) {
        this._nextDeltaTimeZero = c
    },
    setNextScene: function () {
        var c = !1, d = !1;
        cc.TransitionScene && (c = this._runningScene ? this._runningScene instanceof cc.TransitionScene : !1, d = this._nextScene ? this._nextScene instanceof cc.TransitionScene : !1);
        if (!d) {
            if (d = this._runningScene)d.onExitTransitionDidStart(), d.onExit();
            this._sendCleanupToScene && d && d.cleanup()
        }
        this._runningScene = this._nextScene;
        cc.renderer.childrenOrderDirty = !0;
        this._nextScene = null;
        c || null === this._runningScene || (this._runningScene.onEnter(),
            this._runningScene.onEnterTransitionDidFinish())
    },
    setNotificationNode: function (c) {
        cc.renderer.childrenOrderDirty = !0;
        this._notificationNode && (this._notificationNode.onExitTransitionDidStart(), this._notificationNode.onExit(), this._notificationNode.cleanup());
        if (this._notificationNode = c)this._notificationNode.onEnter(), this._notificationNode.onEnterTransitionDidFinish()
    },
    getDelegate: function () {
        return this._projectionDelegate
    },
    setDelegate: function (c) {
        this._projectionDelegate = c
    },
    setOpenGLView: null,
    setProjection: null,
    setViewport: null,
    getOpenGLView: null,
    getProjection: null,
    setAlphaBlending: null,
    isSendCleanupToScene: function () {
        return this._sendCleanupToScene
    },
    getRunningScene: function () {
        return this._runningScene
    },
    getAnimationInterval: function () {
        return this._animationInterval
    },
    isDisplayStats: function () {
        return cc.profiler ? cc.profiler.isShowingStats() : !1
    },
    setDisplayStats: function (c) {
        cc.profiler && (c ? cc.profiler.showStats() : cc.profiler.hideStats())
    },
    getSecondsPerFrame: function () {
        return this._secondsPerFrame
    },
    isNextDeltaTimeZero: function () {
        return this._nextDeltaTimeZero
    },
    isPaused: function () {
        return this._paused
    },
    getTotalFrames: function () {
        return this._totalFrames
    },
    popToRootScene: function () {
        this.popToSceneStackLevel(1)
    },
    popToSceneStackLevel: function (c) {
        cc.assert(this._runningScene, cc._LogInfos.Director_popToSceneStackLevel_2);
        var d = this._scenesStack, e = d.length;
        if (0 === c)this.end(); else if (!(c >= e)) {
            for (; e > c;) {
                var f = d.pop();
                f.running && (f.onExitTransitionDidStart(), f.onExit());
                f.cleanup();
                e--
            }
            this._nextScene = d[d.length - 1];
            this._sendCleanupToScene = !0
        }
    },
    getScheduler: function () {
        return this._scheduler
    },
    setScheduler: function (c) {
        this._scheduler !== c && (this._scheduler = c)
    },
    getActionManager: function () {
        return this._actionManager
    },
    setActionManager: function (c) {
        this._actionManager !== c && (this._actionManager = c)
    },
    getDeltaTime: function () {
        return this._deltaTime
    },
    _calculateMPF: function () {
        this._secondsPerFrame = (Date.now() - this._lastUpdate) / 1E3
    }
});
cc.Director.EVENT_PROJECTION_CHANGED = "director_projection_changed";
cc.Director.EVENT_AFTER_UPDATE = "director_after_update";
cc.Director.EVENT_AFTER_VISIT = "director_after_visit";
cc.Director.EVENT_AFTER_DRAW = "director_after_draw";
cc.DisplayLinkDirector = cc.Director.extend({
    invalid: !1, startAnimation: function () {
        this._nextDeltaTimeZero = !0;
        this.invalid = !1
    }, mainLoop: function () {
        this._purgeDirectorInNextLoop ? (this._purgeDirectorInNextLoop = !1, this.purgeDirector()) : this.invalid || this.drawScene()
    }, stopAnimation: function () {
        this.invalid = !0
    }, setAnimationInterval: function (c) {
        this._animationInterval = c;
        this.invalid || (this.stopAnimation(), this.startAnimation())
    }
});
cc.Director.sharedDirector = null;
cc.Director.firstUseDirector = !0;
cc.Director._getInstance = function () {
    cc.Director.firstUseDirector && (cc.Director.firstUseDirector = !1, cc.Director.sharedDirector = new cc.DisplayLinkDirector, cc.Director.sharedDirector.init());
    return cc.Director.sharedDirector
};
cc.defaultFPS = 60;
cc.Director.PROJECTION_2D = 0;
cc.Director.PROJECTION_3D = 1;
cc.Director.PROJECTION_CUSTOM = 3;
cc.Director.PROJECTION_DEFAULT = cc.Director.PROJECTION_2D;
cc.game.addEventListener(cc.game.EVENT_RENDERER_INITED, function () {
    if (cc._renderType === cc.game.RENDER_TYPE_CANVAS) {
        var c = cc.Director.prototype;
        c.getProjection = function (c) {
            return this._projection
        };
        c.setProjection = function (c) {
            this._projection = c;
            cc.eventManager.dispatchEvent(this._eventProjectionChanged)
        };
        c.setDepthTest = function () {
        };
        c.setClearColor = function (c) {
            cc.renderer._clearColor = c;
            cc.renderer._clearFillStyle = "rgb(" + c.r + "," + c.g + "," + c.b + ")"
        };
        c.setOpenGLView = function (c) {
            this._winSizeInPoints.width =
                cc._canvas.width;
            this._winSizeInPoints.height = cc._canvas.height;
            this._openGLView = c || cc.view;
            cc.eventManager && cc.eventManager.setEnabled(!0)
        };
        c.getVisibleSize = function () {
            return this.getWinSize()
        };
        c.getVisibleOrigin = function () {
            return cc.p(0, 0)
        }
    } else cc.Director._fpsImage = new Image, cc.Director._fpsImage.addEventListener("load", function () {
        cc.Director._fpsImageLoaded = !0
    }), cc._fpsImage && (cc.Director._fpsImage.src = cc._fpsImage)
});
cc.game.addEventListener(cc.game.EVENT_RENDERER_INITED, function () {
    if (cc._renderType === cc.game.RENDER_TYPE_WEBGL) {
        cc.DirectorDelegate = cc.Class.extend({
            updateProjection: function () {
            }
        });
        var c = cc.Director.prototype, d = function (c) {
            if (c && c._renderCmd) {
                c._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty);
                var f = c._children;
                for (c = 0; c < f.length; c++)d(f[c])
            }
        };
        cc.eventManager.addCustomListener(cc.Director.EVENT_PROJECTION_CHANGED, function () {
            for (var c = cc.director._scenesStack, f = 0; f < c.length; f++)d(c[f])
        });
        c.setProjection = function (c) {
            var d = this._winSizeInPoints;
            this.setViewport();
            var g = this._openGLView, h = g._viewPortRect.x / g._scaleX, k = g._viewPortRect.y / g._scaleY;
            switch (c) {
                case cc.Director.PROJECTION_2D:
                    cc.kmGLMatrixMode(cc.KM_GL_PROJECTION);
                    cc.kmGLLoadIdentity();
                    g = cc.math.Matrix4.createOrthographicProjection(0, d.width, 0, d.height, -1024, 1024);
                    cc.kmGLMultMatrix(g);
                    cc.kmGLMatrixMode(cc.KM_GL_MODELVIEW);
                    cc.kmGLLoadIdentity();
                    break;
                case cc.Director.PROJECTION_3D:
                    var m = this.getZEye(), n = new cc.math.Matrix4,
                        g = new cc.math.Matrix4;
                    cc.kmGLMatrixMode(cc.KM_GL_PROJECTION);
                    cc.kmGLLoadIdentity();
                    n = cc.math.Matrix4.createPerspectiveProjection(60, d.width / d.height, 0.1, 2 * m);
                    cc.kmGLMultMatrix(n);
                    cc.kmGLMatrixMode(cc.KM_GL_MODELVIEW);
                    cc.kmGLLoadIdentity();
                    m = new cc.math.Vec3(-h + d.width / 2, -k + d.height / 2, m);
                    d = new cc.math.Vec3(-h + d.width / 2, -k + d.height / 2, 0);
                    h = new cc.math.Vec3(0, 1, 0);
                    g.lookAt(m, d, h);
                    cc.kmGLMultMatrix(g);
                    break;
                case cc.Director.PROJECTION_CUSTOM:
                    this._projectionDelegate && this._projectionDelegate.updateProjection();
                    break;
                default:
                    cc.log(cc._LogInfos.Director_setProjection)
            }
            this._projection = c;
            cc.eventManager.dispatchEvent(this._eventProjectionChanged);
            cc.setProjectionMatrixDirty();
            cc.renderer.childrenOrderDirty = !0
        };
        c.setDepthTest = function (c) {
            cc.renderer.setDepthTest(c)
        };
        c.setClearColor = function (c) {
            cc.renderer._clearColor = c
        };
        c.setOpenGLView = function (c) {
            this._winSizeInPoints.width = cc._canvas.width;
            this._winSizeInPoints.height = cc._canvas.height;
            this._openGLView = c || cc.view;
            c = cc.configuration;
            c.gatherGPUInfo();
            c.dumpInfo();
            this.setGLDefaultValues();
            cc.eventManager && cc.eventManager.setEnabled(!0)
        };
        c._clear = function () {
            var c = cc._renderContext;
            c.clear(c.COLOR_BUFFER_BIT | c.DEPTH_BUFFER_BIT)
        };
        c.getVisibleSize = function () {
            return this._openGLView.getVisibleSize()
        };
        c.getVisibleOrigin = function () {
            return this._openGLView.getVisibleOrigin()
        };
        c.getZEye = function () {
            return this._winSizeInPoints.height / 1.1566
        };
        c.setViewport = function () {
            var c = this._openGLView;
            if (c) {
                var d = this._winSizeInPoints;
                c.setViewPortInPoints(-c._viewPortRect.x / c._scaleX,
                    -c._viewPortRect.y / c._scaleY, d.width, d.height)
            }
        };
        c.getOpenGLView = function () {
            return this._openGLView
        };
        c.getProjection = function () {
            return this._projection
        };
        c.setAlphaBlending = function (c) {
            c ? cc.glBlendFunc(cc.BLEND_SRC, cc.BLEND_DST) : cc.glBlendFunc(cc._renderContext.ONE, cc._renderContext.ZERO)
        };
        c.setGLDefaultValues = function () {
            this.setAlphaBlending(!0);
            this.setProjection(this._projection);
            cc._renderContext.clearColor(0, 0, 0, 0)
        }
    }
});
cc.PRIORITY_NON_SYSTEM = cc.PRIORITY_SYSTEM + 1;
cc.ListEntry = function (c, d, e, f, g, h, k) {
    this.prev = c;
    this.next = d;
    this.callback = e;
    this.target = f;
    this.priority = g;
    this.paused = h;
    this.markedForDeletion = k
};
cc.HashUpdateEntry = function (c, d, e, f, g) {
    this.list = c;
    this.entry = d;
    this.target = e;
    this.callback = f;
    this.hh = g
};
cc.HashTimerEntry = cc.hashSelectorEntry = function (c, d, e, f, g, h, k) {
    this.timers = c;
    this.target = d;
    this.timerIndex = e;
    this.currentTimer = f;
    this.currentTimerSalvaged = g;
    this.paused = h;
    this.hh = k
};
cc.Timer = cc.Class.extend({
    _scheduler: null,
    _elapsed: 0,
    _runForever: !1,
    _useDelay: !1,
    _timesExecuted: 0,
    _repeat: 0,
    _delay: 0,
    _interval: 0,
    getInterval: function () {
        return this._interval
    },
    setInterval: function (c) {
        this._interval = c
    },
    setupTimerWithInterval: function (c, d, e) {
        this._elapsed = -1;
        this._interval = c;
        this._delay = e;
        this._useDelay = 0 < this._delay;
        this._repeat = d;
        this._runForever = this._repeat === cc.REPEAT_FOREVER
    },
    trigger: function () {
        return 0
    },
    cancel: function () {
        return 0
    },
    ctor: function () {
        this._scheduler = null;
        this._elapsed = -1;
        this._useDelay = this._runForever = !1;
        this._interval = this._delay = this._repeat = this._timesExecuted = 0
    },
    update: function (c) {
        -1 === this._elapsed ? this._timesExecuted = this._elapsed = 0 : (this._elapsed += c, this._runForever && !this._useDelay ? this._elapsed >= this._interval && (this.trigger(), this._elapsed = 0) : (this._useDelay ? this._elapsed >= this._delay && (this.trigger(), this._elapsed -= this._delay, this._timesExecuted += 1, this._useDelay = !1) : this._elapsed >= this._interval && (this.trigger(), this._elapsed = 0, this._timesExecuted +=
            1), !this._runForever && this._timesExecuted > this._repeat && this.cancel()))
    }
});
cc.TimerTargetSelector = cc.Timer.extend({
    _target: null, _selector: null, ctor: function () {
        this._selector = this._target = null
    }, initWithSelector: function (c, d, e, f, g, h) {
        this._scheduler = c;
        this._target = e;
        this._selector = d;
        this.setupTimerWithInterval(f, g, h);
        return !0
    }, getSelector: function () {
        return this._selector
    }, trigger: function () {
        this._target && this._selector && this._target.call(this._selector, this._elapsed)
    }, cancel: function () {
        this._scheduler.unschedule(this._selector, this._target)
    }
});
cc.TimerTargetCallback = cc.Timer.extend({
    _target: null, _callback: null, _key: null, ctor: function () {
        this._callback = this._target = null
    }, initWithCallback: function (c, d, e, f, g, h, k) {
        this._scheduler = c;
        this._target = e;
        this._callback = d;
        this._key = f;
        this.setupTimerWithInterval(g, h, k);
        return !0
    }, getCallback: function () {
        return this._callback
    }, getKey: function () {
        return this._key
    }, trigger: function () {
        this._callback && this._callback.call(this._target, this._elapsed)
    }, cancel: function () {
        this._scheduler.unschedule(this._callback,
            this._target)
    }
});
cc.Scheduler = cc.Class.extend({
    _timeScale: 1,
    _updatesNegList: null,
    _updates0List: null,
    _updatesPosList: null,
    _hashForTimers: null,
    _arrayForTimers: null,
    _hashForUpdates: null,
    _currentTarget: null,
    _currentTargetSalvaged: !1,
    _updateHashLocked: !1,
    ctor: function () {
        this._timeScale = 1;
        this._updatesNegList = [];
        this._updates0List = [];
        this._updatesPosList = [];
        this._hashForUpdates = {};
        this._hashForTimers = {};
        this._currentTarget = null;
        this._updateHashLocked = this._currentTargetSalvaged = !1;
        this._arrayForTimers = []
    },
    _schedulePerFrame: function (c,
                                 d, e, f) {
        var g = this._hashForUpdates[d.__instanceId];
        if (g && g.entry)if (g.entry.priority !== e) {
            if (this._updateHashLocked) {
                cc.log("warning: you CANNOT change update priority in scheduled function");
                g.entry.markedForDeletion = !1;
                g.entry.paused = f;
                return
            }
            this.unscheduleUpdate(d)
        } else {
            g.entry.markedForDeletion = !1;
            g.entry.paused = f;
            return
        }
        0 === e ? this._appendIn(this._updates0List, c, d, f) : 0 > e ? this._priorityIn(this._updatesNegList, c, d, e, f) : this._priorityIn(this._updatesPosList, c, d, e, f)
    },
    _removeHashElement: function (c) {
        delete this._hashForTimers[c.target.__instanceId];
        cc.arrayRemoveObject(this._arrayForTimers, c);
        c.Timer = null;
        c.target = null
    },
    _removeUpdateFromHash: function (c) {
        if (c = this._hashForUpdates[c.target.__instanceId])cc.arrayRemoveObject(c.list, c.entry), delete this._hashForUpdates[c.target.__instanceId], c.entry = null, c.target = null
    },
    _priorityIn: function (c, d, e, f, g) {
        d = new cc.ListEntry(null, null, d, e, f, g, !1);
        if (c) {
            g = c.length - 1;
            for (var h = 0; h <= g && !(f < c[h].priority); h++);
            c.splice(h, 0, d)
        } else c = [], c.push(d);
        this._hashForUpdates[e.__instanceId] = new cc.HashUpdateEntry(c,
            d, e, null);
        return c
    },
    _appendIn: function (c, d, e, f) {
        d = new cc.ListEntry(null, null, d, e, 0, f, !1);
        c.push(d);
        this._hashForUpdates[e.__instanceId] = new cc.HashUpdateEntry(c, d, e, null, null)
    },
    setTimeScale: function (c) {
        this._timeScale = c
    },
    getTimeScale: function () {
        return this._timeScale
    },
    update: function (c) {
        this._updateHashLocked = !0;
        1 !== this._timeScale && (c *= this._timeScale);
        var d, e, f, g;
        d = 0;
        e = this._updatesNegList;
        for (f = e.length; d < f; d++)g = e[d], g.paused || g.markedForDeletion || g.callback(c);
        d = 0;
        e = this._updates0List;
        for (f =
                 e.length; d < f; d++)g = e[d], g.paused || g.markedForDeletion || g.callback(c);
        d = 0;
        e = this._updatesPosList;
        for (f = e.length; d < f; d++)g = e[d], g.paused || g.markedForDeletion || g.callback(c);
        f = this._arrayForTimers;
        for (d = 0; d < f.length; d++) {
            this._currentTarget = e = f[d];
            this._currentTargetSalvaged = !1;
            if (!e.paused)for (e.timerIndex = 0; e.timerIndex < e.timers.length; ++e.timerIndex)e.currentTimer = e.timers[e.timerIndex], e.currentTimerSalvaged = !1, e.currentTimer.update(c), e.currentTimer = null;
            this._currentTargetSalvaged && 0 === this._currentTarget.timers.length &&
            this._removeHashElement(this._currentTarget)
        }
        d = 0;
        for (e = this._updatesNegList; d < e.length;)g = e[d], g.markedForDeletion ? this._removeUpdateFromHash(g) : d++;
        d = 0;
        for (e = this._updates0List; d < e.length;)g = e[d], g.markedForDeletion ? this._removeUpdateFromHash(g) : d++;
        d = 0;
        for (e = this._updatesPosList; d < e.length;)g = e[d], g.markedForDeletion ? this._removeUpdateFromHash(g) : d++;
        this._updateHashLocked = !1;
        this._currentTarget = null
    },
    scheduleCallbackForTarget: function (c, d, e, f, g, h) {
        this.schedule(d, c, e, f, g, h, c.__instanceId + "")
    },
    schedule: function (c, d, e, f, g, h, k) {
        var m = !1;
        if ("function" !== typeof c)var n = c, m = !0;
        if (!1 === m) {
            if (4 === arguments.length || 5 === arguments.length)k = g, h = f, g = 0, f = cc.REPEAT_FOREVER
        } else 4 === arguments.length && (h = f, f = cc.REPEAT_FOREVER, g = 0);
        void 0 === k && (k = d.__instanceId + "");
        cc.assert(d, cc._LogInfos.Scheduler_scheduleCallbackForTarget_3);
        var p = this._hashForTimers[d.__instanceId];
        p ? cc.assert(p.paused === h, "") : (p = new cc.HashTimerEntry(null, d, 0, null, null, h, null), this._arrayForTimers.push(p), this._hashForTimers[d.__instanceId] =
            p);
        var r, s;
        if (null == p.timers)p.timers = []; else if (!1 === m)for (s = 0; s < p.timers.length; s++) {
            if (r = p.timers[s], c === r._callback) {
                cc.log(cc._LogInfos.Scheduler_scheduleCallbackForTarget, r.getInterval().toFixed(4), e.toFixed(4));
                r._interval = e;
                return
            }
        } else for (s = 0; s < p.timers.length; ++s)if ((r = p.timers[s]) && n === r.getSelector()) {
            cc.log("CCScheduler#scheduleSelector. Selector already scheduled. Updating interval from: %.4f to %.4f", r.getInterval(), e);
            r.setInterval(e);
            return
        }
        !1 === m ? (r = new cc.TimerTargetCallback, r.initWithCallback(this,
            c, d, k, e, f, g)) : (r = new cc.TimerTargetSelector, r.initWithSelector(this, n, d, e, f, g));
        p.timers.push(r)
    },
    scheduleUpdate: function (c, d, e) {
        this._schedulePerFrame(function (d) {
            c.update(d)
        }, c, d, e)
    },
    _getUnscheduleMark: function (c, d) {
        switch (typeof c) {
            case "number":
            case "string":
                return c === d.getKey();
            case "function":
                return c === d._callback;
            default:
                return c === d.getSelector()
        }
    },
    unschedule: function (c, d) {
        if (d && c) {
            var e = this._hashForTimers[d.__instanceId];
            if (e)for (var f = e.timers, g = 0, h = f.length; g < h; g++) {
                var k = f[g];
                if (this._getUnscheduleMark(c,
                        k)) {
                    k !== e.currentTimer || e.currentTimerSalvaged || (e.currentTimerSalvaged = !0);
                    f.splice(g, 1);
                    e.timerIndex >= g && e.timerIndex--;
                    0 === f.length && (this._currentTarget === e ? this._currentTargetSalvaged = !0 : this._removeHashElement(e));
                    break
                }
            }
        }
    },
    unscheduleUpdate: function (c) {
        null != c && (c = this._hashForUpdates[c.__instanceId]) && (this._updateHashLocked ? c.entry.markedForDeletion = !0 : this._removeUpdateFromHash(c.entry))
    },
    unscheduleAllForTarget: function (c) {
        if (null != c) {
            var d = this._hashForTimers[c.__instanceId];
            d && (-1 < d.timers.indexOf(d.currentTimer) && !d.currentTimerSalvaged && (d.currentTimerSalvaged = !0), d.timers.length = 0, this._currentTarget === d ? this._currentTargetSalvaged = !0 : this._removeHashElement(d));
            this.unscheduleUpdate(c)
        }
    },
    unscheduleAll: function () {
        this.unscheduleAllWithMinPriority(cc.Scheduler.PRIORITY_SYSTEM)
    },
    unscheduleAllWithMinPriority: function (c) {
        var d, e, f = this._arrayForTimers;
        for (d = f.length - 1; 0 <= d; d--)e = f[d], this.unscheduleAllForTarget(e.target);
        f = 0;
        if (0 > c)for (d = 0; d < this._updatesNegList.length;)f = this._updatesNegList.length, (e = this._updatesNegList[d]) &&
        e.priority >= c && this.unscheduleUpdate(e.target), f == this._updatesNegList.length && d++;
        if (0 >= c)for (d = 0; d < this._updates0List.length;)f = this._updates0List.length, (e = this._updates0List[d]) && this.unscheduleUpdate(e.target), f == this._updates0List.length && d++;
        for (d = 0; d < this._updatesPosList.length;)f = this._updatesPosList.length, (e = this._updatesPosList[d]) && e.priority >= c && this.unscheduleUpdate(e.target), f == this._updatesPosList.length && d++
    },
    isScheduled: function (c, d) {
        cc.assert(c, "Argument key must not be empty");
        cc.assert(d, "Argument target must be non-nullptr");
        var e = this._hashForUpdates[d.__instanceId];
        if (!e)return !1;
        if (null != e.timers)for (var e = e.timers, f = 0; f < e.length; ++f)if (c === e[f].getKey())return !0;
        return !1
    },
    pauseAllTargets: function () {
        return this.pauseAllTargetsWithMinPriority(cc.Scheduler.PRIORITY_SYSTEM)
    },
    pauseAllTargetsWithMinPriority: function (c) {
        var d = [], e, f = this._arrayForTimers, g, h;
        g = 0;
        for (h = f.length; g < h; g++)if (e = f[g])e.paused = !0, d.push(e.target);
        if (0 > c)for (g = 0; g < this._updatesNegList.length; g++)(e =
            this._updatesNegList[g]) && e.priority >= c && (e.paused = !0, d.push(e.target));
        if (0 >= c)for (g = 0; g < this._updates0List.length; g++)if (e = this._updates0List[g])e.paused = !0, d.push(e.target);
        for (g = 0; g < this._updatesPosList.length; g++)(e = this._updatesPosList[g]) && e.priority >= c && (e.paused = !0, d.push(e.target));
        return d
    },
    resumeTargets: function (c) {
        if (c)for (var d = 0; d < c.length; d++)this.resumeTarget(c[d])
    },
    pauseTarget: function (c) {
        cc.assert(c, cc._LogInfos.Scheduler_pauseTarget);
        var d = this._hashForTimers[c.__instanceId];
        d &&
        (d.paused = !0);
        if (c = this._hashForUpdates[c.__instanceId])c.entry.paused = !0
    },
    resumeTarget: function (c) {
        cc.assert(c, cc._LogInfos.Scheduler_resumeTarget);
        var d = this._hashForTimers[c.__instanceId];
        d && (d.paused = !1);
        if (c = this._hashForUpdates[c.__instanceId])c.entry.paused = !1
    },
    isTargetPaused: function (c) {
        cc.assert(c, cc._LogInfos.Scheduler_isTargetPaused);
        var d = this._hashForTimers[c.__instanceId];
        return d ? d.paused : (c = this._hashForUpdates[c.__instanceId]) ? c.entry.paused : !1
    },
    scheduleUpdateForTarget: function (c,
                                       d, e) {
        this.scheduleUpdate(c, d, e)
    },
    unscheduleCallbackForTarget: function (c, d) {
        this.unschedule(d, c)
    },
    unscheduleUpdateForTarget: function (c) {
        this.unscheduleUpdate(c)
    },
    unscheduleAllCallbacksForTarget: function (c) {
        this.unschedule(c.__instanceId + "", c)
    },
    unscheduleAllCallbacks: function () {
        this.unscheduleAllWithMinPriority(cc.Scheduler.PRIORITY_SYSTEM)
    },
    unscheduleAllCallbacksWithMinPriority: function (c) {
        this.unscheduleAllWithMinPriority(c)
    }
});
cc.Scheduler.PRIORITY_SYSTEM = -2147483648;
cc.PI2 = 2 * Math.PI;
cc.DrawingPrimitiveCanvas = cc.Class.extend({
    _cacheArray: [], _renderContext: null, ctor: function (c) {
        this._renderContext = c
    }, drawPoint: function (c, d) {
        d || (d = 1);
        var e = cc.view.getScaleX(), f = cc.view.getScaleY(), f = cc.p(c.x * e, c.y * f), g = this._renderContext.getContext();
        g.beginPath();
        g.arc(f.x, -f.y, d * e, 0, 2 * Math.PI, !1);
        g.closePath();
        g.fill()
    }, drawPoints: function (c, d, e) {
        if (null != c) {
            e || (e = 1);
            d = this._renderContext.getContext();
            var f = cc.view.getScaleX(), g = cc.view.getScaleY();
            d.beginPath();
            for (var h = 0, k = c.length; h < k; h++)d.arc(c[h].x *
                f, -c[h].y * g, e * f, 0, 2 * Math.PI, !1);
            d.closePath();
            d.fill()
        }
    }, drawLine: function (c, d) {
        var e = this._renderContext.getContext(), f = cc.view.getScaleX(), g = cc.view.getScaleY();
        e.beginPath();
        e.moveTo(c.x * f, -c.y * g);
        e.lineTo(d.x * f, -d.y * g);
        e.closePath();
        e.stroke()
    }, drawRect: function (c, d) {
        this.drawLine(cc.p(c.x, c.y), cc.p(d.x, c.y));
        this.drawLine(cc.p(d.x, c.y), cc.p(d.x, d.y));
        this.drawLine(cc.p(d.x, d.y), cc.p(c.x, d.y));
        this.drawLine(cc.p(c.x, d.y), cc.p(c.x, c.y))
    }, drawSolidRect: function (c, d, e) {
        c = [c, cc.p(d.x, c.y), d, cc.p(c.x,
            d.y)];
        this.drawSolidPoly(c, 4, e)
    }, drawPoly: function (c, d, e, f) {
        f = f || !1;
        if (null != c) {
            if (3 > c.length)throw Error("Polygon's point must greater than 2");
            var g = c[0];
            d = this._renderContext.getContext();
            var h = cc.view.getScaleX(), k = cc.view.getScaleY();
            d.beginPath();
            d.moveTo(g.x * h, -g.y * k);
            for (var g = 1, m = c.length; g < m; g++)d.lineTo(c[g].x * h, -c[g].y * k);
            e && d.closePath();
            f ? d.fill() : d.stroke()
        }
    }, drawSolidPoly: function (c, d, e) {
        this.setDrawColor(e.r, e.g, e.b, e.a);
        this.drawPoly(c, d, !0, !0)
    }, drawCircle: function (c, d, e, f, g) {
        g =
            g || !1;
        f = this._renderContext.getContext();
        var h = cc.view.getScaleX(), k = cc.view.getScaleY();
        f.beginPath();
        f.arc(0 | c.x * h, 0 | -(c.y * k), d * h, -e, -(e - 2 * Math.PI), !1);
        g && f.lineTo(0 | c.x * h, 0 | -(c.y * k));
        f.stroke()
    }, drawQuadBezier: function (c, d, e, f) {
        for (var g = this._cacheArray, h = g.length = 0, k = 0; k < f; k++) {
            var m = Math.pow(1 - h, 2) * c.x + 2 * (1 - h) * h * d.x + h * h * e.x, n = Math.pow(1 - h, 2) * c.y + 2 * (1 - h) * h * d.y + h * h * e.y;
            g.push(cc.p(m, n));
            h += 1 / f
        }
        g.push(cc.p(e.x, e.y));
        this.drawPoly(g, f + 1, !1, !1)
    }, drawCubicBezier: function (c, d, e, f, g) {
        for (var h = this._cacheArray,
                 k = h.length = 0, m = 0; m < g; m++) {
            var n = Math.pow(1 - k, 3) * c.x + 3 * Math.pow(1 - k, 2) * k * d.x + 3 * (1 - k) * k * k * e.x + k * k * k * f.x, p = Math.pow(1 - k, 3) * c.y + 3 * Math.pow(1 - k, 2) * k * d.y + 3 * (1 - k) * k * k * e.y + k * k * k * f.y;
            h.push(cc.p(n, p));
            k += 1 / g
        }
        h.push(cc.p(f.x, f.y));
        this.drawPoly(h, g + 1, !1, !1)
    }, drawCatmullRom: function (c, d) {
        this.drawCardinalSpline(c, 0.5, d)
    }, drawCardinalSpline: function (c, d, e) {
        cc._renderContext.setStrokeStyle("rgba(255,255,255,1)");
        var f = this._cacheArray;
        f.length = 0;
        for (var g, h, k = 1 / c.length, m = 0; m < e + 1; m++)h = m / e, 1 === h ? (g = c.length - 1,
            h = 1) : (g = 0 | h / k, h = (h - k * g) / k), g = cc.CardinalSplineAt(cc.getControlPointAt(c, g - 1), cc.getControlPointAt(c, g - 0), cc.getControlPointAt(c, g + 1), cc.getControlPointAt(c, g + 2), d, h), f.push(g);
        this.drawPoly(f, e + 1, !1, !1)
    }, drawImage: function (c, d, e, f, g) {
        var h = arguments.length, k = this._renderContext.getContext();
        switch (h) {
            case 2:
                k.drawImage(c, d.x, -(d.y + c.height));
                break;
            case 3:
                k.drawImage(c, d.x, -(d.y + e.height), e.width, e.height);
                break;
            case 5:
                k.drawImage(c, d.x, d.y, e.width, e.height, f.x, -(f.y + g.height), g.width, g.height);
                break;
            default:
                throw Error("Argument must be non-nil");
        }
    }, drawStar: function (c, d, e) {
        c = c || this._renderContext;
        var f = c.getContext();
        d *= cc.view.getScaleX();
        e = "rgba(" + (0 | e.r) + "," + (0 | e.g) + "," + (0 | e.b);
        c.setFillStyle(e + ",1)");
        var g = d / 10;
        f.beginPath();
        f.moveTo(-d, d);
        f.lineTo(0, g);
        f.lineTo(d, d);
        f.lineTo(g, 0);
        f.lineTo(d, -d);
        f.lineTo(0, -g);
        f.lineTo(-d, -d);
        f.lineTo(-g, 0);
        f.lineTo(-d, d);
        f.closePath();
        f.fill();
        var h = f.createRadialGradient(0, 0, g, 0, 0, d);
        h.addColorStop(0, e + ", 1)");
        h.addColorStop(0.3, e + ", 0.8)");
        h.addColorStop(1,
            e + ", 0.0)");
        c.setFillStyle(h);
        f.beginPath();
        f.arc(0, 0, d - g, 0, cc.PI2, !1);
        f.closePath();
        f.fill()
    }, drawColorBall: function (c, d, e) {
        c = c || this._renderContext;
        var f = c.getContext();
        d *= cc.view.getScaleX();
        e = "rgba(" + (0 | e.r) + "," + (0 | e.g) + "," + (0 | e.b);
        var g = f.createRadialGradient(0, 0, d / 10, 0, 0, d);
        g.addColorStop(0, e + ", 1)");
        g.addColorStop(0.3, e + ", 0.8)");
        g.addColorStop(0.6, e + ", 0.4)");
        g.addColorStop(1, e + ", 0.0)");
        c.setFillStyle(g);
        f.beginPath();
        f.arc(0, 0, d, 0, cc.PI2, !1);
        f.closePath();
        f.fill()
    }, fillText: function (c, d,
                           e) {
        this._renderContext.getContext().fillText(c, d, -e)
    }, setDrawColor: function (c, d, e, f) {
        this._renderContext.setFillStyle("rgba(" + c + "," + d + "," + e + "," + f / 255 + ")");
        this._renderContext.setStrokeStyle("rgba(" + c + "," + d + "," + e + "," + f / 255 + ")")
    }, setPointSize: function (c) {
    }, setLineWidth: function (c) {
        this._renderContext.getContext().lineWidth = c * cc.view.getScaleX()
    }
});
cc.DrawingPrimitiveWebGL = cc.Class.extend({
    _renderContext: null,
    _initialized: !1,
    _shader: null,
    _colorLocation: "u_color",
    _colorArray: null,
    _pointSizeLocation: "u_pointSize",
    _pointSize: -1,
    ctor: function (c) {
        null == c && (c = cc._renderContext);
        if (!c instanceof WebGLRenderingContext)throw Error("Can't initialise DrawingPrimitiveWebGL. context need is WebGLRenderingContext");
        this._renderContext = c;
        this._colorArray = new Float32Array([1, 1, 1, 1])
    },
    lazy_init: function () {
        this._initialized || (this._shader = cc.shaderCache.programForKey(cc.SHADER_POSITION_UCOLOR),
            this._shader._addUniformLocation(this._colorLocation), this._shader._addUniformLocation(this._pointSizeLocation), this._initialized = !0)
    },
    drawInit: function () {
        this._initialized = !1
    },
    drawPoint: function (c) {
        this.lazy_init();
        var d = this._renderContext;
        this._shader.use();
        this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
        d.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
        this._shader.setUniformLocationWith4fv(this._colorLocation, this._colorArray);
        this._shader.setUniformLocationWith1f(this._pointSizeLocation,
            this._pointSize);
        var e = d.createBuffer();
        d.bindBuffer(d.ARRAY_BUFFER, e);
        d.bufferData(d.ARRAY_BUFFER, new Float32Array([c.x, c.y]), d.STATIC_DRAW);
        d.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, d.FLOAT, !1, 0, 0);
        d.drawArrays(d.POINTS, 0, 1);
        d.deleteBuffer(e);
        cc.incrementGLDraws(1)
    },
    drawPoints: function (c, d) {
        if (c && 0 !== c.length) {
            this.lazy_init();
            var e = this._renderContext;
            this._shader.use();
            this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
            e.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
            this._shader.setUniformLocationWith4fv(this._colorLocation, this._colorArray);
            this._shader.setUniformLocationWith1f(this._pointSizeLocation, this._pointSize);
            var f = e.createBuffer();
            e.bindBuffer(e.ARRAY_BUFFER, f);
            e.bufferData(e.ARRAY_BUFFER, this._pointsToTypeArray(c), e.STATIC_DRAW);
            e.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, e.FLOAT, !1, 0, 0);
            e.drawArrays(e.POINTS, 0, c.length);
            e.deleteBuffer(f);
            cc.incrementGLDraws(1)
        }
    },
    _pointsToTypeArray: function (c) {
        for (var d = new Float32Array(2 * c.length), e = 0; e < c.length; e++)d[2 *
        e] = c[e].x, d[2 * e + 1] = c[e].y;
        return d
    },
    drawLine: function (c, d) {
        this.lazy_init();
        var e = this._renderContext;
        this._shader.use();
        this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
        e.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
        this._shader.setUniformLocationWith4fv(this._colorLocation, this._colorArray);
        var f = e.createBuffer();
        e.bindBuffer(e.ARRAY_BUFFER, f);
        e.bufferData(e.ARRAY_BUFFER, this._pointsToTypeArray([c, d]), e.STATIC_DRAW);
        e.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, e.FLOAT,
            !1, 0, 0);
        e.drawArrays(e.LINES, 0, 2);
        e.deleteBuffer(f);
        cc.incrementGLDraws(1)
    },
    drawRect: function (c, d) {
        this.drawLine(cc.p(c.x, c.y), cc.p(d.x, c.y));
        this.drawLine(cc.p(d.x, c.y), cc.p(d.x, d.y));
        this.drawLine(cc.p(d.x, d.y), cc.p(c.x, d.y));
        this.drawLine(cc.p(c.x, d.y), cc.p(c.x, c.y))
    },
    drawSolidRect: function (c, d, e) {
        c = [c, cc.p(d.x, c.y), d, cc.p(c.x, d.y)];
        this.drawSolidPoly(c, 4, e)
    },
    drawPoly: function (c, d, e) {
        this.lazy_init();
        d = this._renderContext;
        this._shader.use();
        this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
        d.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
        this._shader.setUniformLocationWith4fv(this._colorLocation, this._colorArray);
        var f = d.createBuffer();
        d.bindBuffer(d.ARRAY_BUFFER, f);
        d.bufferData(d.ARRAY_BUFFER, this._pointsToTypeArray(c), d.STATIC_DRAW);
        d.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, d.FLOAT, !1, 0, 0);
        e ? d.drawArrays(d.LINE_LOOP, 0, c.length) : d.drawArrays(d.LINE_STRIP, 0, c.length);
        d.deleteBuffer(f);
        cc.incrementGLDraws(1)
    },
    drawSolidPoly: function (c, d, e) {
        this.lazy_init();
        e && this.setDrawColor(e.r,
            e.g, e.b, e.a);
        d = this._renderContext;
        this._shader.use();
        this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
        d.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
        this._shader.setUniformLocationWith4fv(this._colorLocation, this._colorArray);
        e = d.createBuffer();
        d.bindBuffer(d.ARRAY_BUFFER, e);
        d.bufferData(d.ARRAY_BUFFER, this._pointsToTypeArray(c), d.STATIC_DRAW);
        d.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, d.FLOAT, !1, 0, 0);
        d.drawArrays(d.TRIANGLE_FAN, 0, c.length);
        d.deleteBuffer(e);
        cc.incrementGLDraws(1)
    },
    drawCircle: function (c, d, e, f, g) {
        this.lazy_init();
        var h = 1;
        g && h++;
        var k = 2 * Math.PI / f;
        if (g = new Float32Array(2 * (f + 2))) {
            for (var m = 0; m <= f; m++) {
                var n = m * k, p = d * Math.cos(n + e) + c.x, n = d * Math.sin(n + e) + c.y;
                g[2 * m] = p;
                g[2 * m + 1] = n
            }
            g[2 * (f + 1)] = c.x;
            g[2 * (f + 1) + 1] = c.y;
            c = this._renderContext;
            this._shader.use();
            this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
            c.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
            this._shader.setUniformLocationWith4fv(this._colorLocation, this._colorArray);
            d = c.createBuffer();
            c.bindBuffer(c.ARRAY_BUFFER,
                d);
            c.bufferData(c.ARRAY_BUFFER, g, c.STATIC_DRAW);
            c.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, c.FLOAT, !1, 0, 0);
            c.drawArrays(c.LINE_STRIP, 0, f + h);
            c.deleteBuffer(d);
            cc.incrementGLDraws(1)
        }
    },
    drawQuadBezier: function (c, d, e, f) {
        this.lazy_init();
        for (var g = new Float32Array(2 * (f + 1)), h = 0, k = 0; k < f; k++)g[2 * k] = Math.pow(1 - h, 2) * c.x + 2 * (1 - h) * h * d.x + h * h * e.x, g[2 * k + 1] = Math.pow(1 - h, 2) * c.y + 2 * (1 - h) * h * d.y + h * h * e.y, h += 1 / f;
        g[2 * f] = e.x;
        g[2 * f + 1] = e.y;
        c = this._renderContext;
        this._shader.use();
        this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
        c.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
        this._shader.setUniformLocationWith4fv(this._colorLocation, this._colorArray);
        d = c.createBuffer();
        c.bindBuffer(c.ARRAY_BUFFER, d);
        c.bufferData(c.ARRAY_BUFFER, g, c.STATIC_DRAW);
        c.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, c.FLOAT, !1, 0, 0);
        c.drawArrays(c.LINE_STRIP, 0, f + 1);
        c.deleteBuffer(d);
        cc.incrementGLDraws(1)
    },
    drawCubicBezier: function (c, d, e, f, g) {
        this.lazy_init();
        for (var h = new Float32Array(2 * (g + 1)), k = 0, m = 0; m < g; m++)h[2 * m] = Math.pow(1 - k, 3) * c.x + 3 * Math.pow(1 -
                k, 2) * k * d.x + 3 * (1 - k) * k * k * e.x + k * k * k * f.x, h[2 * m + 1] = Math.pow(1 - k, 3) * c.y + 3 * Math.pow(1 - k, 2) * k * d.y + 3 * (1 - k) * k * k * e.y + k * k * k * f.y, k += 1 / g;
        h[2 * g] = f.x;
        h[2 * g + 1] = f.y;
        c = this._renderContext;
        this._shader.use();
        this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
        c.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
        this._shader.setUniformLocationWith4fv(this._colorLocation, this._colorArray);
        d = c.createBuffer();
        c.bindBuffer(c.ARRAY_BUFFER, d);
        c.bufferData(c.ARRAY_BUFFER, h, c.STATIC_DRAW);
        c.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION,
            2, c.FLOAT, !1, 0, 0);
        c.drawArrays(c.LINE_STRIP, 0, g + 1);
        c.deleteBuffer(d);
        cc.incrementGLDraws(1)
    },
    drawCatmullRom: function (c, d) {
        this.drawCardinalSpline(c, 0.5, d)
    },
    drawCardinalSpline: function (c, d, e) {
        this.lazy_init();
        for (var f = new Float32Array(2 * (e + 1)), g, h, k = 1 / c.length, m = 0; m < e + 1; m++)h = m / e, 1 === h ? (g = c.length - 1, h = 1) : (g = 0 | h / k, h = (h - k * g) / k), g = cc.cardinalSplineAt(cc.getControlPointAt(c, g - 1), cc.getControlPointAt(c, g), cc.getControlPointAt(c, g + 1), cc.getControlPointAt(c, g + 2), d, h), f[2 * m] = g.x, f[2 * m + 1] = g.y;
        c = this._renderContext;
        this._shader.use();
        this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
        c.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
        this._shader.setUniformLocationWith4fv(this._colorLocation, this._colorArray);
        d = c.createBuffer();
        c.bindBuffer(c.ARRAY_BUFFER, d);
        c.bufferData(c.ARRAY_BUFFER, f, c.STATIC_DRAW);
        c.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, c.FLOAT, !1, 0, 0);
        c.drawArrays(c.LINE_STRIP, 0, e + 1);
        c.deleteBuffer(d);
        cc.incrementGLDraws(1)
    },
    setDrawColor: function (c, d, e, f) {
        this._colorArray[0] =
            c / 255;
        this._colorArray[1] = d / 255;
        this._colorArray[2] = e / 255;
        this._colorArray[3] = f / 255
    },
    setPointSize: function (c) {
        this._pointSize = c * cc.contentScaleFactor()
    },
    setLineWidth: function (c) {
        this._renderContext.lineWidth && this._renderContext.lineWidth(c)
    }
});
cc._tmp.PrototypeLabelTTF = function () {
    var c = cc.LabelTTF.prototype;
    cc.defineGetterSetter(c, "color", c.getColor, c.setColor);
    cc.defineGetterSetter(c, "opacity", c.getOpacity, c.setOpacity);
    cc.defineGetterSetter(c, "string", c.getString, c.setString);
    cc.defineGetterSetter(c, "textAlign", c.getHorizontalAlignment, c.setHorizontalAlignment);
    cc.defineGetterSetter(c, "verticalAlign", c.getVerticalAlignment, c.setVerticalAlignment);
    cc.defineGetterSetter(c, "fontSize", c.getFontSize, c.setFontSize);
    cc.defineGetterSetter(c,
        "fontName", c.getFontName, c.setFontName);
    cc.defineGetterSetter(c, "font", c._getFont, c._setFont);
    cc.defineGetterSetter(c, "boundingWidth", c._getBoundingWidth, c._setBoundingWidth);
    cc.defineGetterSetter(c, "boundingHeight", c._getBoundingHeight, c._setBoundingHeight);
    cc.defineGetterSetter(c, "fillStyle", c._getFillStyle, c.setFontFillColor);
    cc.defineGetterSetter(c, "strokeStyle", c._getStrokeStyle, c._setStrokeStyle);
    cc.defineGetterSetter(c, "lineWidth", c._getLineWidth, c._setLineWidth);
    cc.defineGetterSetter(c, "shadowOffsetX",
        c._getShadowOffsetX, c._setShadowOffsetX);
    cc.defineGetterSetter(c, "shadowOffsetY", c._getShadowOffsetY, c._setShadowOffsetY);
    cc.defineGetterSetter(c, "shadowOpacity", c._getShadowOpacity, c._setShadowOpacity);
    cc.defineGetterSetter(c, "shadowBlur", c._getShadowBlur, c._setShadowBlur)
};
cc.LabelTTF = cc.Sprite.extend({
    _dimensions: null,
    _hAlignment: cc.TEXT_ALIGNMENT_CENTER,
    _vAlignment: cc.VERTICAL_TEXT_ALIGNMENT_TOP,
    _fontName: null,
    _fontSize: 0,
    _string: "",
    _originalText: null,
    _onCacheCanvasMode: !0,
    _shadowEnabled: !1,
    _shadowOffset: null,
    _shadowOpacity: 0,
    _shadowBlur: 0,
    _shadowColor: null,
    _strokeEnabled: !1,
    _strokeColor: null,
    _strokeSize: 0,
    _textFillColor: null,
    _strokeShadowOffsetX: 0,
    _strokeShadowOffsetY: 0,
    _needUpdateTexture: !1,
    _lineWidths: null,
    _className: "LabelTTF",
    _fontStyle: "normal",
    _fontWeight: "normal",
    _lineHeight: "normal",
    initWithString: function (c, d, e, f, g, h) {
        c = c ? c + "" : "";
        e = e || 16;
        f = f || cc.size(0, 0);
        g = g || cc.TEXT_ALIGNMENT_LEFT;
        h = h || cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        this._opacityModifyRGB = !1;
        this._dimensions = cc.size(f.width, f.height);
        this._fontName = d || "Arial";
        this._hAlignment = g;
        this._vAlignment = h;
        this._fontSize = e;
        this._renderCmd._setFontStyle(this._fontName, e, this._fontStyle, this._fontWeight);
        this.string = c;
        this._renderCmd._setColorsString();
        this._renderCmd._updateTexture();
        this._setUpdateTextureDirty();
        this._scaleX = this._scaleY = 1 / cc.view.getDevicePixelRatio();
        return !0
    },
    _setUpdateTextureDirty: function () {
        this._needUpdateTexture = !0;
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.textDirty)
    },
    ctor: function (c, d, e, f, g, h) {
        cc.Sprite.prototype.ctor.call(this);
        this._dimensions = cc.size(0, 0);
        this._hAlignment = cc.TEXT_ALIGNMENT_LEFT;
        this._vAlignment = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        this._opacityModifyRGB = !1;
        this._fontName = "Arial";
        this._shadowEnabled = !1;
        this._shadowOffset = cc.p(0, 0);
        this._shadowBlur = this._shadowOpacity =
            0;
        this._strokeEnabled = !1;
        this._strokeColor = cc.color(255, 255, 255, 255);
        this._strokeSize = 0;
        this._textFillColor = cc.color(255, 255, 255, 255);
        this._strokeShadowOffsetY = this._strokeShadowOffsetX = 0;
        this._needUpdateTexture = !1;
        this._lineWidths = [];
        this._renderCmd._setColorsString();
        this._textureLoaded = !0;
        d && d instanceof cc.FontDefinition ? this.initWithStringAndTextDefinition(c, d) : cc.LabelTTF.prototype.initWithString.call(this, c, d, e, f, g, h)
    },
    init: function () {
        return this.initWithString(" ", this._fontName, this._fontSize)
    },
    description: function () {
        return "\x3ccc.LabelTTF | FontName \x3d" + this._fontName + " FontSize \x3d " + this._fontSize.toFixed(1) + "\x3e"
    },
    getLineHeight: function () {
        return !this._lineHeight || this._lineHeight.charAt ? this._renderCmd._getFontClientHeight() : this._lineHeight || this._renderCmd._getFontClientHeight()
    },
    setLineHeight: function (c) {
        this._lineHeight = c
    },
    getString: function () {
        return this._string
    },
    getHorizontalAlignment: function () {
        return this._hAlignment
    },
    getVerticalAlignment: function () {
        return this._vAlignment
    },
    getDimensions: function () {
        return cc.size(this._dimensions)
    },
    getFontSize: function () {
        return this._fontSize
    },
    getFontName: function () {
        return this._fontName
    },
    initWithStringAndTextDefinition: function (c, d) {
        this._updateWithTextDefinition(d, !1);
        this.string = c;
        return !0
    },
    setTextDefinition: function (c) {
        c && this._updateWithTextDefinition(c, !0)
    },
    getTextDefinition: function () {
        return this._prepareTextDefinition(!1)
    },
    enableShadow: function (c, d, e, f) {
        null != c.r && null != c.g && null != c.b && null != c.a ? this._enableShadow(c, d, e) : this._enableShadowNoneColor(c,
            d, e, f)
    },
    _enableShadowNoneColor: function (c, d, e, f) {
        e = e || 0.5;
        !1 === this._shadowEnabled && (this._shadowEnabled = !0);
        var g = this._shadowOffset;
        if (g && g.x !== c || g._y !== d)g.x = c, g.y = d;
        this._shadowOpacity !== e && (this._shadowOpacity = e);
        this._renderCmd._setColorsString();
        this._shadowBlur !== f && (this._shadowBlur = f);
        this._setUpdateTextureDirty()
    },
    _enableShadow: function (c, d, e) {
        this._shadowColor || (this._shadowColor = cc.color(255, 255, 255, 128));
        this._shadowColor.r = c.r;
        this._shadowColor.g = c.g;
        this._shadowColor.b = c.b;
        this._enableShadowNoneColor(d.width ||
            d.x || 0, d.height || d.y || 0, null != c.a ? c.a / 255 : 0.5, e)
    },
    _getShadowOffsetX: function () {
        return this._shadowOffset.x
    },
    _setShadowOffsetX: function (c) {
        !1 === this._shadowEnabled && (this._shadowEnabled = !0);
        this._shadowOffset.x !== c && (this._shadowOffset.x = c, this._setUpdateTextureDirty())
    },
    _getShadowOffsetY: function () {
        return this._shadowOffset._y
    },
    _setShadowOffsetY: function (c) {
        !1 === this._shadowEnabled && (this._shadowEnabled = !0);
        this._shadowOffset._y !== c && (this._shadowOffset._y = c, this._setUpdateTextureDirty())
    },
    _getShadowOffset: function () {
        return cc.p(this._shadowOffset.x,
            this._shadowOffset.y)
    },
    _setShadowOffset: function (c) {
        !1 === this._shadowEnabled && (this._shadowEnabled = !0);
        if (this._shadowOffset.x !== c.x || this._shadowOffset.y !== c.y)this._shadowOffset.x = c.x, this._shadowOffset.y = c.y, this._setUpdateTextureDirty()
    },
    _getShadowOpacity: function () {
        return this._shadowOpacity
    },
    _setShadowOpacity: function (c) {
        !1 === this._shadowEnabled && (this._shadowEnabled = !0);
        this._shadowOpacity !== c && (this._shadowOpacity = c, this._renderCmd._setColorsString(), this._setUpdateTextureDirty())
    },
    _getShadowBlur: function () {
        return this._shadowBlur
    },
    _setShadowBlur: function (c) {
        !1 === this._shadowEnabled && (this._shadowEnabled = !0);
        this._shadowBlur !== c && (this._shadowBlur = c, this._setUpdateTextureDirty())
    },
    disableShadow: function () {
        this._shadowEnabled && (this._shadowEnabled = !1, this._setUpdateTextureDirty())
    },
    enableStroke: function (c, d) {
        !1 === this._strokeEnabled && (this._strokeEnabled = !0);
        var e = this._strokeColor;
        if (e.r !== c.r || e.g !== c.g || e.b !== c.b)e.r = c.r, e.g = c.g, e.b = c.b, this._renderCmd._setColorsString();
        this._strokeSize !== d && (this._strokeSize = d || 0);
        this._setUpdateTextureDirty()
    },
    _getStrokeStyle: function () {
        return this._strokeColor
    },
    _setStrokeStyle: function (c) {
        !1 === this._strokeEnabled && (this._strokeEnabled = !0);
        var d = this._strokeColor;
        if (d.r !== c.r || d.g !== c.g || d.b !== c.b)d.r = c.r, d.g = c.g, d.b = c.b, this._renderCmd._setColorsString(), this._setUpdateTextureDirty()
    },
    _getLineWidth: function () {
        return this._strokeSize
    },
    _setLineWidth: function (c) {
        !1 === this._strokeEnabled && (this._strokeEnabled = !0);
        this._strokeSize !== c && (this._strokeSize = c || 0, this._setUpdateTextureDirty())
    },
    disableStroke: function () {
        this._strokeEnabled &&
        (this._strokeEnabled = !1, this._setUpdateTextureDirty())
    },
    setFontFillColor: function (c) {
        var d = this._textFillColor;
        if (d.r !== c.r || d.g !== c.g || d.b !== c.b)d.r = c.r, d.g = c.g, d.b = c.b, this._renderCmd._setColorsString(), this._needUpdateTexture = !0
    },
    _getFillStyle: function () {
        return this._textFillColor
    },
    _updateWithTextDefinition: function (c, d) {
        c.fontDimensions ? (this._dimensions.width = c.boundingWidth, this._dimensions.height = c.boundingHeight) : (this._dimensions.width = 0, this._dimensions.height = 0);
        this._hAlignment = c.textAlign;
        this._vAlignment = c.verticalAlign;
        this._fontName = c.fontName;
        this._fontSize = c.fontSize || 12;
        this._lineHeight = c.lineHeight ? c.lineHeight : this._fontSize;
        this._renderCmd._setFontStyle(c);
        c.shadowEnabled && this.enableShadow(c.shadowOffsetX, c.shadowOffsetY, c.shadowOpacity, c.shadowBlur);
        c.strokeEnabled && this.enableStroke(c.strokeStyle, c.lineWidth);
        this.setFontFillColor(c.fillStyle);
        d && this._renderCmd._updateTexture();
        var e = cc.Node._dirtyFlags;
        this._renderCmd.setDirtyFlag(e.colorDirty | e.opacityDirty | e.textDirty)
    },
    _prepareTextDefinition: function (c) {
        var d = new cc.FontDefinition;
        c ? (d.fontSize = this._fontSize, d.boundingWidth = cc.contentScaleFactor() * this._dimensions.width, d.boundingHeight = cc.contentScaleFactor() * this._dimensions.height) : (d.fontSize = this._fontSize, d.boundingWidth = this._dimensions.width, d.boundingHeight = this._dimensions.height);
        d.fontName = this._fontName;
        d.textAlign = this._hAlignment;
        d.verticalAlign = this._vAlignment;
        if (this._strokeEnabled) {
            d.strokeEnabled = !0;
            var e = this._strokeColor;
            d.strokeStyle = cc.color(e.r,
                e.g, e.b);
            d.lineWidth = this._strokeSize
        } else d.strokeEnabled = !1;
        this._shadowEnabled ? (d.shadowEnabled = !0, d.shadowBlur = this._shadowBlur, d.shadowOpacity = this._shadowOpacity, d.shadowOffsetX = (c ? cc.contentScaleFactor() : 1) * this._shadowOffset.x, d.shadowOffsetY = (c ? cc.contentScaleFactor() : 1) * this._shadowOffset.y) : d._shadowEnabled = !1;
        c = this._textFillColor;
        d.fillStyle = cc.color(c.r, c.g, c.b);
        return d
    },
    getScale: function () {
        this._scaleX !== this._scaleY && cc.log(cc._LogInfos.Node_getScale);
        return this._scaleX * cc.view.getDevicePixelRatio()
    },
    setScale: function (c, d) {
        this._scaleX = c / cc.view.getDevicePixelRatio();
        this._scaleY = (d || 0 === d ? d : c) / cc.view.getDevicePixelRatio();
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    getScaleX: function () {
        return this._scaleX * cc.view.getDevicePixelRatio()
    },
    setScaleX: function (c) {
        this._scaleX = c / cc.view.getDevicePixelRatio();
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    getScaleY: function () {
        return this._scaleY * cc.view.getDevicePixelRatio()
    },
    setScaleY: function (c) {
        this._scaleY =
            c / cc.view.getDevicePixelRatio();
        this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
    },
    setString: function (c) {
        c = String(c);
        this._originalText !== c && (this._originalText = c + "", this._updateString(), this._setUpdateTextureDirty(), this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty))
    },
    _updateString: function () {
        this._string && "" !== this._string || this._string === this._originalText || (cc.renderer.childrenOrderDirty = !0);
        this._string = this._originalText
    },
    setHorizontalAlignment: function (c) {
        c !== this._hAlignment &&
        (this._hAlignment = c, this._setUpdateTextureDirty())
    },
    setVerticalAlignment: function (c) {
        c !== this._vAlignment && (this._vAlignment = c, this._setUpdateTextureDirty())
    },
    setDimensions: function (c, d) {
        var e;
        void 0 === d ? (e = c.width, d = c.height) : e = c;
        if (e !== this._dimensions.width || d !== this._dimensions.height)this._dimensions.width = e, this._dimensions.height = d, this._updateString(), this._setUpdateTextureDirty()
    },
    _getBoundingWidth: function () {
        return this._dimensions.width
    },
    _setBoundingWidth: function (c) {
        c !== this._dimensions.width &&
        (this._dimensions.width = c, this._updateString(), this._setUpdateTextureDirty())
    },
    _getBoundingHeight: function () {
        return this._dimensions.height
    },
    _setBoundingHeight: function (c) {
        c !== this._dimensions.height && (this._dimensions.height = c, this._updateString(), this._setUpdateTextureDirty())
    },
    setFontSize: function (c) {
        this._fontSize !== c && (this._fontSize = c, this._renderCmd._setFontStyle(this._fontName, this._fontSize, this._fontStyle, this._fontWeight), this._setUpdateTextureDirty())
    },
    setFontName: function (c) {
        this._fontName &&
        this._fontName !== c && (this._fontName = c, this._renderCmd._setFontStyle(this._fontName, this._fontSize, this._fontStyle, this._fontWeight), this._setUpdateTextureDirty())
    },
    _getFont: function () {
        return this._renderCmd._getFontStyle()
    },
    _setFont: function (c) {
        if (c = cc.LabelTTF._fontStyleRE.exec(c))this._fontSize = parseInt(c[1]), this._fontName = c[2], this._renderCmd._setFontStyle(this._fontName, this._fontSize, this._fontStyle, this._fontWeight), this._setUpdateTextureDirty()
    },
    getContentSize: function () {
        this._needUpdateTexture &&
        this._renderCmd._updateTTF();
        return cc.size(this._contentSize)
    },
    _getWidth: function () {
        this._needUpdateTexture && this._renderCmd._updateTTF();
        return this._contentSize.width
    },
    _getHeight: function () {
        this._needUpdateTexture && this._renderCmd._updateTTF();
        return this._contentSize.height
    },
    setTextureRect: function (c, d, e) {
        cc.Sprite.prototype.setTextureRect.call(this, c, d, e, !1)
    },
    setDrawMode: function (c) {
        this._onCacheCanvasMode = c
    },
    _createRenderCmd: function () {
        return cc._renderType === cc.game.RENDER_TYPE_WEBGL ? new cc.LabelTTF.WebGLRenderCmd(this) :
            this._onCacheCanvasMode ? new cc.LabelTTF.CacheCanvasRenderCmd(this) : new cc.LabelTTF.CanvasRenderCmd(this)
    },
    _setFontStyle: function (c) {
        this._fontStyle !== c && (this._fontStyle = c, this._renderCmd._setFontStyle(this._fontName, this._fontSize, this._fontStyle, this._fontWeight), this._setUpdateTextureDirty())
    },
    _getFontStyle: function () {
        return this._fontStyle
    },
    _setFontWeight: function (c) {
        this._fontWeight !== c && (this._fontWeight = c, this._renderCmd._setFontStyle(this._fontName, this._fontSize, this._fontStyle, this._fontWeight),
            this._setUpdateTextureDirty())
    },
    _getFontWeight: function () {
        return this._fontWeight
    }
});
cc.assert(cc.isFunction(cc._tmp.PrototypeLabelTTF), cc._LogInfos.MissingFile, "LabelTTFPropertyDefine.js");
cc._tmp.PrototypeLabelTTF();
delete cc._tmp.PrototypeLabelTTF;
cc.LabelTTF._fontStyleRE = /^(\d+)px\s+['"]?([\w\s\d]+)['"]?$/;
cc.LabelTTF.create = function (c, d, e, f, g, h) {
    return new cc.LabelTTF(c, d, e, f, g, h)
};
cc.LabelTTF.createWithFontDefinition = cc.LabelTTF.create;
cc.LabelTTF.__labelHeightDiv = document.createElement("div");
cc.LabelTTF.__labelHeightDiv.style.fontFamily = "Arial";
cc.LabelTTF.__labelHeightDiv.style.position = "absolute";
cc.LabelTTF.__labelHeightDiv.style.left = "-100px";
cc.LabelTTF.__labelHeightDiv.style.top = "-100px";
cc.LabelTTF.__labelHeightDiv.style.lineHeight = "normal";
document.body ? document.body.appendChild(cc.LabelTTF.__labelHeightDiv) : window.addEventListener("load", function () {
    this.removeEventListener("load", arguments.callee, !1);
    document.body.appendChild(cc.LabelTTF.__labelHeightDiv)
}, !1);
cc.LabelTTF.__getFontHeightByDiv = function (c, d) {
    var e, f = cc.LabelTTF.__labelHeightDiv;
    if (c instanceof cc.FontDefinition) {
        e = cc.LabelTTF.__fontHeightCache[c._getCanvasFontStr()];
        if (0 < e)return e;
        f.innerHTML = "ajghl~!";
        f.style.fontFamily = c.fontName;
        f.style.fontSize = c.fontSize + "px";
        f.style.fontStyle = c.fontStyle;
        f.style.fontWeight = c.fontWeight;
        e = f.clientHeight;
        cc.LabelTTF.__fontHeightCache[c._getCanvasFontStr()] = e
    } else {
        e = cc.LabelTTF.__fontHeightCache[c + "." + d];
        if (0 < e)return e;
        f.innerHTML = "ajghl~!";
        f.style.fontFamily =
            c;
        f.style.fontSize = d + "px";
        e = f.clientHeight;
        cc.LabelTTF.__fontHeightCache[c + "." + d] = e
    }
    f.innerHTML = "";
    return e
};
cc.LabelTTF.__fontHeightCache = {};
cc.LabelTTF._textAlign = ["left", "center", "right"];
cc.LabelTTF._textBaseline = ["top", "middle", "bottom"];
cc.LabelTTF.wrapInspection = !0;
cc.LabelTTF._wordRex = /([a-zA-Z0-9\u00c4\u00d6\u00dc\u00e4\u00f6\u00fc\u00df\u00e9\u00e8\u00e7\u00e0\u00f9\u00ea\u00e2\u00ee\u00f4\u00fb]+|\S)/;
cc.LabelTTF._symbolRex = /^[!,.:;}\]%\?>\u3001\u2018\u201c\u300b\uff1f\u3002\uff0c\uff01]/;
cc.LabelTTF._lastWordRex = /([a-zA-Z0-9\u00c4\u00d6\u00dc\u00e4\u00f6\u00fc\u00df\u00e9\u00e8\u00e7\u00e0\u00f9\u00ea\u00e2\u00ee\u00f4\u00fb]+|\S)$/;
cc.LabelTTF._lastEnglish = /[a-zA-Z0-9\u00c4\u00d6\u00dc\u00e4\u00f6\u00fc\u00df\u00e9\u00e8\u00e7\u00e0\u00f9\u00ea\u00e2\u00ee\u00f4\u00fb]+$/;
cc.LabelTTF._firsrEnglish = /^[a-zA-Z0-9\u00c4\u00d6\u00dc\u00e4\u00f6\u00fc\u00df\u00e9\u00e8\u00e7\u00e0\u00f9\u00ea\u00e2\u00ee\u00f4\u00fb]/;
(function () {
    cc.LabelTTF.RenderCmd = function () {
        this._fontClientHeight = 18;
        this._fontStyleStr = "";
        this._shadowColorStr = "rgba(128, 128, 128, 0.5)";
        this._strokeColorStr = "";
        this._fillColorStr = "rgba(255,255,255,1)";
        this._labelContext = this._labelCanvas = null;
        this._lineWidths = [];
        this._strings = [];
        this._isMultiLine = !1;
        this._status = [];
        this._renderingIndex = 0;
        this._texRect = cc.rect()
    };
    var c = cc.LabelTTF.RenderCmd.prototype;
    c.constructor = cc.LabelTTF.RenderCmd;
    c._setFontStyle = function (c, e, f, g) {
        if (c instanceof cc.FontDefinition)this._fontStyleStr =
            c._getCanvasFontStr(), this._fontClientHeight = cc.LabelTTF.__getFontHeightByDiv(c); else {
            var h = e * cc.view.getDevicePixelRatio();
            this._fontStyleStr = f + " " + g + " " + h + "px '" + c + "'";
            this._fontClientHeight = cc.LabelTTF.__getFontHeightByDiv(c, e)
        }
    };
    c._getFontStyle = function () {
        return this._fontStyleStr
    };
    c._getFontClientHeight = function () {
        return this._fontClientHeight
    };
    c._updateColor = function () {
        this._setColorsString();
        this._updateTexture()
    };
    c._setColorsString = function () {
        var c = this._displayedColor, e = this._node, f = e._shadowColor ||
            this._displayedColor, g = e._strokeColor, h = e._textFillColor, k = c.r / 255, m = c.g / 255, c = c.b / 255;
        this._shadowColorStr = "rgba(" + (0 | k * f.r) + "," + (0 | m * f.g) + "," + (0 | c * f.b) + "," + e._shadowOpacity + ")";
        this._fillColorStr = "rgba(" + (0 | k * h.r) + "," + (0 | m * h.g) + "," + (0 | c * h.b) + ", 1)";
        this._strokeColorStr = "rgba(" + (0 | k * g.r) + "," + (0 | m * g.g) + "," + (0 | c * g.b) + ", 1)"
    };
    c._updateTTF = function () {
        var c = this._node, e = cc.view.getDevicePixelRatio(), f = c._dimensions.width * e, g, h, k = this._lineWidths;
        k.length = 0;
        this._isMultiLine = !1;
        this._measureConfig();
        if (0 !==
            f)for (this._strings = c._string.split("\n"), g = 0; g < this._strings.length; g++)this._checkWarp(this._strings, g, f); else for (this._strings = c._string.split("\n"), g = 0, h = this._strings.length; g < h; g++)k.push(this._measure(this._strings[g]));
        1 < this._strings.length && (this._isMultiLine = !0);
        h = g = 0;
        c._strokeEnabled && (g = h = 2 * c._strokeSize);
        if (c._shadowEnabled) {
            var m = c._shadowOffset;
            g += 2 * Math.abs(m.x);
            h += 2 * Math.abs(m.y)
        }
        f = 0 === f ? this._isMultiLine ? cc.size(Math.ceil(Math.max.apply(Math, k) + g), Math.ceil(this._fontClientHeight *
            e * this._strings.length + h)) : cc.size(Math.ceil(this._measure(c._string) + g), Math.ceil(this._fontClientHeight * e + h)) : 0 === c._dimensions.height ? this._isMultiLine ? cc.size(Math.ceil(f + g), Math.ceil(c.getLineHeight() * e * this._strings.length + h)) : cc.size(Math.ceil(f + g), Math.ceil(c.getLineHeight() * e + h)) : cc.size(Math.ceil(f + g), Math.ceil(c._dimensions.height * e + h));
        "normal" !== c._getFontStyle() && (f.width = Math.ceil(f.width + 0.3 * c._fontSize));
        0 === this._strings.length ? (this._texRect.width = 1, this._texRect.height = f.height ||
            1) : (this._texRect.width = f.width, this._texRect.height = f.height);
        c.setContentSize(f.width / e, f.height / e);
        c._strokeShadowOffsetX = g;
        c._strokeShadowOffsetY = h;
        c = c._anchorPoint;
        this._anchorPointInPoints.x = 0.5 * g + (f.width - g) * c.x;
        this._anchorPointInPoints.y = 0.5 * h + (f.height - h) * c.y
    };
    c._saveStatus = function () {
        var c = this._node, e = cc.view.getDevicePixelRatio(), f = c._strokeShadowOffsetX, g = c._strokeShadowOffsetY, h = c._contentSize.height * e - g, k = c._vAlignment, m = c._hAlignment, n = 0.5 * f, g = h + 0.5 * g, p = 0, r = 0, s = [], f = c._contentSize.width *
            e - f, c = c.getLineHeight() * e, e = (c - this._fontClientHeight * e) / 2, p = m === cc.TEXT_ALIGNMENT_RIGHT ? p + f : m === cc.TEXT_ALIGNMENT_CENTER ? p + f / 2 : p + 0;
        if (this._isMultiLine)for (m = this._strings.length, k === cc.VERTICAL_TEXT_ALIGNMENT_BOTTOM ? r = c - 2 * e + h - c * m : k === cc.VERTICAL_TEXT_ALIGNMENT_CENTER && (r = (c - 2 * e) / 2 + (h - c * m) / 2), k = 0; k < m; k++)s.push(-h + (c * k + e) + r); else k !== cc.VERTICAL_TEXT_ALIGNMENT_BOTTOM && (r = k === cc.VERTICAL_TEXT_ALIGNMENT_TOP ? r - h : r - 0.5 * h), s.push(r);
        h = {contextTransform: cc.p(n, g), xOffset: p, OffsetYArray: s};
        this._status.push(h)
    };
    c._drawTTFInCanvas = function (c) {
        if (c) {
            var e = this._status.pop();
            c.setTransform(1, 0, 0, 1, e.contextTransform.x, e.contextTransform.y);
            this.drawLabels(c, e.xOffset, e.OffsetYArray)
        }
    };
    c._checkWarp = function (c, e, f) {
        var g = c[e], h = this._measure(g);
        if (h > f && 1 < g.length) {
            for (var k = f / h * g.length | 0, m = g.substr(k), n = h - this._measure(m), p, r = 0, s = 0; n > f && 100 > s++;)k *= f / n, k |= 0, m = g.substr(k), n = h - this._measure(m);
            for (s = 0; n < f && 100 > s++;)m && (r = (p = cc.LabelTTF._wordRex.exec(m)) ? p[0].length : 1, p = m), k += r, m = g.substr(k), n = h - this._measure(m);
            k -= r;
            0 === k && (k = 1, p = p.substr(1));
            f = g.substr(0, k);
            cc.LabelTTF.wrapInspection && cc.LabelTTF._symbolRex.test(p || m) && (h = cc.LabelTTF._lastWordRex.exec(f), k -= h ? h[0].length : 0, 0 === k && (k = 1), p = g.substr(k), f = g.substr(0, k));
            cc.LabelTTF._firsrEnglish.test(p) && (h = cc.LabelTTF._lastEnglish.exec(f)) && f !== h[0] && (k -= h[0].length, p = g.substr(k), f = g.substr(0, k));
            c[e] = p || m;
            c.splice(e, 0, f)
        }
    };
    c.updateStatus = function () {
        var c = cc.Node._dirtyFlags;
        this._dirtyFlag & c.textDirty && this._updateTexture();
        cc.Node.RenderCmd.prototype.updateStatus.call(this);
        this._dirtyFlag & c.transformDirty && (this.transform(this.getParentRenderCmd(), !0), this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.transformDirty)
    };
    c._syncStatus = function (c) {
        var e = cc.Node._dirtyFlags, f = this._dirtyFlag;
        f & e.textDirty && this._updateTexture();
        cc.Node.RenderCmd.prototype._syncStatus.call(this, c);
        (cc._renderType === cc.game.RENDER_TYPE_WEBGL || f & e.transformDirty) && this.transform(c)
    };
    c.drawLabels = function (c, e, f) {
        var g = this._node;
        if (g._shadowEnabled) {
            var h = g._shadowOffset;
            c.shadowColor = this._shadowColorStr;
            c.shadowOffsetX = h.x;
            c.shadowOffsetY = -h.y;
            c.shadowBlur = g._shadowBlur
        }
        var h = g._hAlignment, k = g._vAlignment, m = g._strokeSize;
        c.font !== this._fontStyleStr && (c.font = this._fontStyleStr);
        c.fillStyle = this._fillColorStr;
        if (g = g._strokeEnabled)c.lineWidth = 2 * m, c.strokeStyle = this._strokeColorStr;
        c.textBaseline = cc.LabelTTF._textBaseline[k];
        c.textAlign = cc.LabelTTF._textAlign[h];
        h = this._strings.length;
        for (k = 0; k < h; k++)m = this._strings[k], g && c.strokeText(m, e, f[k]), c.fillText(m, e, f[k]);
        cc.g_NumberOfDraws++
    }
})();
(function () {
    cc.LabelTTF.CacheRenderCmd = function (c) {
        cc.LabelTTF.RenderCmd.call(this, c);
        c = this._labelCanvas = document.createElement("canvas");
        c.width = 1;
        c.height = 1;
        this._labelContext = c.getContext("2d");
        this._texRect = cc.rect()
    };
    cc.LabelTTF.CacheRenderCmd.prototype = Object.create(cc.LabelTTF.RenderCmd.prototype);
    cc.inject(cc.LabelTTF.RenderCmd.prototype, cc.LabelTTF.CacheRenderCmd.prototype);
    var c = cc.LabelTTF.CacheRenderCmd.prototype;
    c.constructor = cc.LabelTTF.CacheRenderCmd;
    c._updateTexture = function () {
        this._dirtyFlag ^=
            this._dirtyFlag & cc.Node._dirtyFlags.textDirty;
        var c = this._node;
        this._updateTTF();
        var e = this._texRect.width, f = this._texRect.height, g = this._labelContext, h = this._labelCanvas;
        if (!c._texture) {
            var k = new cc.Texture2D;
            k.initWithElement(this._labelCanvas);
            c.setTexture(k)
        }
        if (0 === c._string.length)return h.width = e, h.height = f, c._texture && c._texture.handleLoadedTexture(), c.setTextureRect(this._texRect), !0;
        g.font = this._fontStyleStr;
        k = h.width === e && h.height === f;
        h.width = this._texRect.width;
        h.height = this._texRect.height;
        k && g.clearRect(0, 0, e, f);
        this._saveStatus();
        this._drawTTFInCanvas(g);
        c._texture && c._texture.handleLoadedTexture();
        c.setTextureRect(this._texRect);
        return !0
    };
    c._measureConfig = function () {
        this._labelContext.font = this._fontStyleStr
    };
    c._measure = function (c) {
        return this._labelContext.measureText(c).width
    }
})();
(function () {
    cc.LabelTTF.CacheCanvasRenderCmd = function (c) {
        cc.Sprite.CanvasRenderCmd.call(this, c);
        cc.LabelTTF.CacheRenderCmd.call(this)
    };
    var c = cc.LabelTTF.CacheCanvasRenderCmd.prototype = Object.create(cc.Sprite.CanvasRenderCmd.prototype);
    cc.inject(cc.LabelTTF.CacheRenderCmd.prototype, c);
    c.constructor = cc.LabelTTF.CacheCanvasRenderCmd
})();
(function () {
    cc.LabelTTF.CanvasRenderCmd = function (c) {
        cc.Sprite.CanvasRenderCmd.call(this, c);
        cc.LabelTTF.RenderCmd.call(this)
    };
    cc.LabelTTF.CanvasRenderCmd.prototype = Object.create(cc.Sprite.CanvasRenderCmd.prototype);
    cc.inject(cc.LabelTTF.RenderCmd.prototype, cc.LabelTTF.CanvasRenderCmd.prototype);
    var c = cc.LabelTTF.CanvasRenderCmd.prototype;
    c.constructor = cc.LabelTTF.CanvasRenderCmd;
    c._measureConfig = function () {
    };
    c._measure = function (c) {
        var e = cc._renderContext.getContext();
        e.font = this._fontStyleStr;
        return e.measureText(c).width
    };
    c._updateTexture = function () {
        this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.textDirty;
        var c = this._node;
        cc.view.getDevicePixelRatio();
        this._updateTTF();
        if (0 === c._string.length)return c.setTextureRect(this._texRect), !0;
        this._saveStatus();
        c.setTextureRect(this._texRect);
        return !0
    };
    c.rendering = function (c) {
        var e = cc.view.getScaleX(), f = cc.view.getScaleY();
        c = c || cc._renderContext;
        var g = c.getContext();
        if (g) {
            var h = this._node;
            c.computeRealOffsetY();
            if (!(0 >= this._status.length)) {
                var k = this._renderingIndex >=
                this._status.length ? this._renderingIndex - this._status.length : this._renderingIndex, m = this._status[k];
                this._renderingIndex = k + 1;
                var n = h._offsetPosition.x, k = -h._offsetPosition.y - h._rect.height, p = this._displayedOpacity / 255;
                c.setTransform(this._worldTransform, e, f);
                c.setCompositeOperation(this._blendFuncStr);
                c.setGlobalAlpha(p);
                c.save();
                h._flippedX && (n = -n - h._rect.width, g.scale(-1, 1));
                h._flippedY && (k = h._offsetPosition.y, g.scale(1, -1));
                e = m.xOffset + m.contextTransform.x + n * e;
                h = [];
                n = this._strings.length;
                for (p =
                         0; p < n; p++)h.push(m.OffsetYArray[p] + m.contextTransform.y + k * f);
                this.drawLabels(g, e, h);
                c.restore()
            }
        }
    }
})();
(function () {
    cc.LabelTTF.WebGLRenderCmd = function (c) {
        cc.Sprite.WebGLRenderCmd.call(this, c);
        cc.LabelTTF.CacheRenderCmd.call(this)
    };
    var c = cc.LabelTTF.WebGLRenderCmd.prototype = Object.create(cc.Sprite.WebGLRenderCmd.prototype);
    cc.inject(cc.LabelTTF.CacheRenderCmd.prototype, c);
    c.constructor = cc.LabelTTF.WebGLRenderCmd;
    c._updateColor = function () {
    }
})();
cc.HashElement = cc.Class.extend({
    actions: null,
    target: null,
    actionIndex: 0,
    currentAction: null,
    currentActionSalvaged: !1,
    paused: !1,
    hh: null,
    ctor: function () {
        this.actions = [];
        this.target = null;
        this.actionIndex = 0;
        this.currentAction = null;
        this.paused = this.currentActionSalvaged = !1;
        this.hh = null
    }
});
cc.ActionManager = cc.Class.extend({
    _hashTargets: null,
    _arrayTargets: null,
    _currentTarget: null,
    _currentTargetSalvaged: !1,
    _searchElementByTarget: function (c, d) {
        for (var e = 0; e < c.length; e++)if (d === c[e].target)return c[e];
        return null
    },
    ctor: function () {
        this._hashTargets = {};
        this._arrayTargets = [];
        this._currentTarget = null;
        this._currentTargetSalvaged = !1
    },
    addAction: function (c, d, e) {
        if (!c)throw Error("cc.ActionManager.addAction(): action must be non-null");
        if (!d)throw Error("cc.ActionManager.addAction(): action must be non-null");
        var f = this._hashTargets[d.__instanceId];
        f || (f = new cc.HashElement, f.paused = e, f.target = d, this._hashTargets[d.__instanceId] = f, this._arrayTargets.push(f));
        this._actionAllocWithHashElement(f);
        f.actions.push(c);
        c.startWithTarget(d)
    },
    removeAllActions: function () {
        for (var c = this._arrayTargets, d = 0; d < c.length; d++) {
            var e = c[d];
            e && this.removeAllActionsFromTarget(e.target, !0)
        }
    },
    removeAllActionsFromTarget: function (c, d) {
        if (null != c) {
            var e = this._hashTargets[c.__instanceId];
            e && (-1 === e.actions.indexOf(e.currentAction) ||
            e.currentActionSalvaged || (e.currentActionSalvaged = !0), e.actions.length = 0, this._currentTarget !== e || d ? this._deleteHashElement(e) : this._currentTargetSalvaged = !0)
        }
    },
    removeAction: function (c) {
        if (null != c) {
            var d = c.getOriginalTarget();
            if (d = this._hashTargets[d.__instanceId])for (var e = 0; e < d.actions.length; e++) {
                if (d.actions[e] === c) {
                    d.actions.splice(e, 1);
                    break
                }
            } else cc.log(cc._LogInfos.ActionManager_removeAction)
        }
    },
    removeActionByTag: function (c, d) {
        c === cc.ACTION_TAG_INVALID && cc.log(cc._LogInfos.ActionManager_addAction);
        cc.assert(d, cc._LogInfos.ActionManager_addAction);
        var e = this._hashTargets[d.__instanceId];
        if (e)for (var f = e.actions.length, g = 0; g < f; ++g) {
            var h = e.actions[g];
            if (h && h.getTag() === c && h.getOriginalTarget() === d) {
                this._removeActionAtIndex(g, e);
                break
            }
        }
    },
    getActionByTag: function (c, d) {
        c === cc.ACTION_TAG_INVALID && cc.log(cc._LogInfos.ActionManager_getActionByTag);
        var e = this._hashTargets[d.__instanceId];
        if (e) {
            if (null != e.actions)for (var f = 0; f < e.actions.length; ++f) {
                var g = e.actions[f];
                if (g && g.getTag() === c)return g
            }
            cc.log(cc._LogInfos.ActionManager_getActionByTag_2,
                c)
        }
        return null
    },
    numberOfRunningActionsInTarget: function (c) {
        return (c = this._hashTargets[c.__instanceId]) ? c.actions ? c.actions.length : 0 : 0
    },
    pauseTarget: function (c) {
        if (c = this._hashTargets[c.__instanceId])c.paused = !0
    },
    resumeTarget: function (c) {
        if (c = this._hashTargets[c.__instanceId])c.paused = !1
    },
    pauseAllRunningActions: function () {
        for (var c = [], d = this._arrayTargets, e = 0; e < d.length; e++) {
            var f = d[e];
            f && !f.paused && (f.paused = !0, c.push(f.target))
        }
        return c
    },
    resumeTargets: function (c) {
        if (c)for (var d = 0; d < c.length; d++)c[d] &&
        this.resumeTarget(c[d])
    },
    purgeSharedManager: function () {
        cc.director.getScheduler().unscheduleUpdate(this)
    },
    _removeActionAtIndex: function (c, d) {
        d.actions[c] !== d.currentAction || d.currentActionSalvaged || (d.currentActionSalvaged = !0);
        d.actions.splice(c, 1);
        d.actionIndex >= c && d.actionIndex--;
        0 === d.actions.length && (this._currentTarget === d ? this._currentTargetSalvaged = !0 : this._deleteHashElement(d))
    },
    _deleteHashElement: function (c) {
        var d = !1;
        c && (this._hashTargets[c.target.__instanceId] && (delete this._hashTargets[c.target.__instanceId],
            cc.arrayRemoveObject(this._arrayTargets, c), d = !0), c.actions = null, c.target = null);
        return d
    },
    _actionAllocWithHashElement: function (c) {
        null == c.actions && (c.actions = [])
    },
    update: function (c) {
        for (var d = this._arrayTargets, e, f = 0; f < d.length; f++) {
            e = this._currentTarget = d[f];
            if (!e.paused)for (e.actionIndex = 0; e.actionIndex < (e.actions ? e.actions.length : 0); e.actionIndex++)if (e.currentAction = e.actions[e.actionIndex], e.currentAction) {
                e.currentActionSalvaged = !1;
                e.currentAction.step(c * (e.currentAction._speedMethod ? e.currentAction._speed :
                        1));
                if (e.currentActionSalvaged)e.currentAction = null; else if (e.currentAction.isDone()) {
                    e.currentAction.stop();
                    var g = e.currentAction;
                    e.currentAction = null;
                    this.removeAction(g)
                }
                e.currentAction = null
            }
            this._currentTargetSalvaged && 0 === e.actions.length && this._deleteHashElement(e) && f--
        }
    }
});
cc.profiler = function () {
    var c = !1, d = !1, e = 0, f = 0, g = 0, h = 0, k = null, m = document.createElement("div"), n = document.createElement("div"), p = document.createElement("div"), r = document.createElement("div"), s = 10, v = [0, 10, 20, 30], t = [0, 0, 0, 0], w = 3, u = 0, A = 0;
    r.id = "fps";
    r.style.position = "absolute";
    r.style.padding = "3px";
    r.style.textAlign = "left";
    r.style.backgroundColor = "rgb(0, 0, 34)";
    r.style.bottom = cc.DIRECTOR_STATS_POSITION.y + "0px";
    r.style.left = cc.DIRECTOR_STATS_POSITION.x + "px";
    r.style.width = "45px";
    r.style.height = "60px";
    for (var x =
        [p, n, m], B = 0; 3 > B; ++B) {
        var F = x[B].style;
        F.color = "rgb(0, 255, 255)";
        F.font = "bold 12px Helvetica, Arial";
        F.lineHeight = "20px";
        F.width = "100%";
        r.appendChild(x[B])
    }
    var z = function () {
        g = cc.director.getSecondsPerFrame();
        e++;
        h += cc.director.getDeltaTime();
        if (h > cc.DIRECTOR_FPS_INTERVAL) {
            f = e / h;
            h = e = 0;
            if (y.onFrameRateChange) {
                var d = f, k = v.length - 1, r = k, x = 0;
                u++;
                for (A += d; 0 <= r; r--)if (d >= v[r]) {
                    t[r]++;
                    break
                }
                if (u >= s) {
                    x = A / s;
                    for (r = k; 0 < r; r--)if (d = t[r] / s, 0.6 <= d && x >= v[r]) {
                        r != w && (w = r, y.onFrameRateChange && y.onFrameRateChange(x.toFixed(2)));
                        break
                    }
                    A = u = _changeCount = 0;
                    for (r = k; 0 < r; r--)t[r] = 0
                }
            }
            c && (n.innerText = g.toFixed(3), m.innerText = f.toFixed(1), p.innerText = (0 | cc.g_NumberOfDraws).toString())
        }
    }, y = {
        onFrameRateChange: null, getSecondsPerFrame: function () {
            return g
        }, getFrameRate: function () {
            return f
        }, setProfileDuration: function (c) {
            !isNaN(c) && 0 < c && (s = c / cc.DIRECTOR_FPS_INTERVAL)
        }, resumeProfiling: function () {
            cc.eventManager.addListener(k, 1)
        }, stopProfiling: function () {
            cc.eventManager.removeListener(k)
        }, isShowingStats: function () {
            return c
        }, showStats: function () {
            d ||
            this.init();
            null === r.parentElement && cc.container.appendChild(r);
            c = !0
        }, hideStats: function () {
            c = !1;
            r.parentElement === cc.container && cc.container.removeChild(r)
        }, init: function () {
            d || (k = cc.eventManager.addCustomListener(cc.Director.EVENT_AFTER_VISIT, z), d = !0)
        }
    };
    return y
}();
cc.math = cc.math || {};
cc.math.EPSILON = 0.015625;
cc.math.square = function (c) {
    return c * c
};
cc.math.almostEqual = function (c, d) {
    return c + cc.math.EPSILON > d && c - cc.math.EPSILON < d
};
(function (c) {
    c.math.Vec2 = function (c, d) {
        void 0 === d ? (this.x = c.x, this.y = c.y) : (this.x = c || 0, this.y = d || 0)
    };
    var d = c.math.Vec2.prototype;
    d.fill = function (c, d) {
        this.x = c;
        this.y = d
    };
    d.length = function () {
        return Math.sqrt(c.math.square(this.x) + c.math.square(this.y))
    };
    d.lengthSq = function () {
        return c.math.square(this.x) + c.math.square(this.y)
    };
    d.normalize = function () {
        var c = 1 / this.length();
        this.x *= c;
        this.y *= c;
        return this
    };
    c.math.Vec2.add = function (c, d, g) {
        c.x = d.x + g.x;
        c.y = d.y + g.y;
        return c
    };
    d.add = function (c) {
        this.x += c.x;
        this.y +=
            c.y;
        return this
    };
    d.dot = function (c) {
        return this.x * c.x + this.y * c.y
    };
    c.math.Vec2.subtract = function (c, d, g) {
        c.x = d.x - g.x;
        c.y = d.y - g.y;
        return c
    };
    d.subtract = function (c) {
        this.x -= c.x;
        this.y -= c.y;
        return this
    };
    d.transform = function (c) {
        var d = this.x, g = this.y;
        this.x = d * c.mat[0] + g * c.mat[3] + c.mat[6];
        this.y = d * c.mat[1] + g * c.mat[4] + c.mat[7];
        return this
    };
    c.math.Vec2.scale = function (c, d, g) {
        c.x = d.x * g;
        c.y = d.y * g;
        return c
    };
    d.scale = function (c) {
        this.x *= c;
        this.y *= c;
        return this
    };
    d.equals = function (d) {
        return this.x < d.x + c.math.EPSILON &&
            this.x > d.x - c.math.EPSILON && this.y < d.y + c.math.EPSILON && this.y > d.y - c.math.EPSILON
    }
})(cc);
(function (c) {
    c.math.Vec3 = c.kmVec3 = function (c, d, g) {
        c && void 0 === d ? (this.x = c.x, this.y = c.y, this.z = c.z) : (this.x = c || 0, this.y = d || 0, this.z = g || 0)
    };
    c.math.vec3 = function (d, f, g) {
        return new c.math.Vec3(d, f, g)
    };
    var d = c.math.Vec3.prototype;
    d.fill = function (c, d, g) {
        c && void 0 === d ? (this.x = c.x, this.y = c.y, this.z = c.z) : (this.x = c, this.y = d, this.z = g);
        return this
    };
    d.length = function () {
        return Math.sqrt(c.math.square(this.x) + c.math.square(this.y) + c.math.square(this.z))
    };
    d.lengthSq = function () {
        return c.math.square(this.x) + c.math.square(this.y) +
            c.math.square(this.z)
    };
    d.normalize = function () {
        var c = 1 / this.length();
        this.x *= c;
        this.y *= c;
        this.z *= c;
        return this
    };
    d.cross = function (c) {
        var d = this.x, g = this.y, h = this.z;
        this.x = g * c.z - h * c.y;
        this.y = h * c.x - d * c.z;
        this.z = d * c.y - g * c.x;
        return this
    };
    d.dot = function (c) {
        return this.x * c.x + this.y * c.y + this.z * c.z
    };
    d.add = function (c) {
        this.x += c.x;
        this.y += c.y;
        this.z += c.z;
        return this
    };
    d.subtract = function (c) {
        this.x -= c.x;
        this.y -= c.y;
        this.z -= c.z;
        return this
    };
    d.transform = function (c) {
        var d = this.x, g = this.y, h = this.z;
        c = c.mat;
        this.x = d *
            c[0] + g * c[4] + h * c[8] + c[12];
        this.y = d * c[1] + g * c[5] + h * c[9] + c[13];
        this.z = d * c[2] + g * c[6] + h * c[10] + c[14];
        return this
    };
    d.transformNormal = function (c) {
        var d = this.x, g = this.y, h = this.z;
        c = c.mat;
        this.x = d * c[0] + g * c[4] + h * c[8];
        this.y = d * c[1] + g * c[5] + h * c[9];
        this.z = d * c[2] + g * c[6] + h * c[10];
        return this
    };
    d.transformCoord = function (d) {
        var f = new c.math.Vec4(this.x, this.y, this.z, 1);
        f.transform(d);
        this.x = f.x / f.w;
        this.y = f.y / f.w;
        this.z = f.z / f.w;
        return this
    };
    d.scale = function (c) {
        this.x *= c;
        this.y *= c;
        this.z *= c;
        return this
    };
    d.equals = function (d) {
        var f =
            c.math.EPSILON;
        return this.x < d.x + f && this.x > d.x - f && this.y < d.y + f && this.y > d.y - f && this.z < d.z + f && this.z > d.z - f
    };
    d.inverseTransform = function (d) {
        d = d.mat;
        var f = new c.math.Vec3(this.x - d[12], this.y - d[13], this.z - d[14]);
        this.x = f.x * d[0] + f.y * d[1] + f.z * d[2];
        this.y = f.x * d[4] + f.y * d[5] + f.z * d[6];
        this.z = f.x * d[8] + f.y * d[9] + f.z * d[10];
        return this
    };
    d.inverseTransformNormal = function (c) {
        var d = this.x, g = this.y, h = this.z;
        c = c.mat;
        this.x = d * c[0] + g * c[1] + h * c[2];
        this.y = d * c[4] + g * c[5] + h * c[6];
        this.z = d * c[8] + g * c[9] + h * c[10];
        return this
    };
    d.assignFrom =
        function (c) {
            if (!c)return this;
            this.x = c.x;
            this.y = c.y;
            this.z = c.z;
            return this
        };
    c.math.Vec3.zero = function (c) {
        c.x = c.y = c.z = 0;
        return c
    };
    d.toTypeArray = function () {
        var c = new Float32Array(3);
        c[0] = this.x;
        c[1] = this.y;
        c[2] = this.z;
        return c
    }
})(cc);
(function (c) {
    c.math.Vec4 = function (c, d, g, h) {
        c && void 0 === d ? (this.x = c.x, this.y = c.y, this.z = c.z, this.w = c.w) : (this.x = c || 0, this.y = d || 0, this.z = g || 0, this.w = h || 0)
    };
    c.kmVec4 = c.math.Vec4;
    var d = c.math.Vec4.prototype;
    d.fill = function (c, d, g, h) {
        c && void 0 === d ? (this.x = c.x, this.y = c.y, this.z = c.z, this.w = c.w) : (this.x = c, this.y = d, this.z = g, this.w = h)
    };
    d.add = function (c) {
        if (!c)return this;
        this.x += c.x;
        this.y += c.y;
        this.z += c.z;
        this.w += c.w;
        return this
    };
    d.dot = function (c) {
        return this.x * c.x + this.y * c.y + this.z * c.z + this.w * c.w
    };
    d.length =
        function () {
            return Math.sqrt(c.math.square(this.x) + c.math.square(this.y) + c.math.square(this.z) + c.math.square(this.w))
        };
    d.lengthSq = function () {
        return c.math.square(this.x) + c.math.square(this.y) + c.math.square(this.z) + c.math.square(this.w)
    };
    d.lerp = function (c, d) {
        return this
    };
    d.normalize = function () {
        var c = 1 / this.length();
        this.x *= c;
        this.y *= c;
        this.z *= c;
        this.w *= c;
        return this
    };
    d.scale = function (c) {
        this.normalize();
        this.x *= c;
        this.y *= c;
        this.z *= c;
        this.w *= c;
        return this
    };
    d.subtract = function (c) {
        this.x -= c.x;
        this.y -=
            c.y;
        this.z -= c.z;
        this.w -= c.w
    };
    d.transform = function (c) {
        var d = this.x, g = this.y, h = this.z, k = this.w;
        c = c.mat;
        this.x = d * c[0] + g * c[4] + h * c[8] + k * c[12];
        this.y = d * c[1] + g * c[5] + h * c[9] + k * c[13];
        this.z = d * c[2] + g * c[6] + h * c[10] + k * c[14];
        this.w = d * c[3] + g * c[7] + h * c[11] + k * c[15];
        return this
    };
    c.math.Vec4.transformArray = function (d, f) {
        for (var g = [], h = 0; h < d.length; h++) {
            var k = new c.math.Vec4(d[h]);
            k.transform(f);
            g.push(k)
        }
        return g
    };
    d.equals = function (d) {
        var f = c.math.EPSILON;
        return this.x < d.x + f && this.x > d.x - f && this.y < d.y + f && this.y > d.y - f &&
            this.z < d.z + f && this.z > d.z - f && this.w < d.w + f && this.w > d.w - f
    };
    d.assignFrom = function (c) {
        this.x = c.x;
        this.y = c.y;
        this.z = c.z;
        this.w = c.w;
        return this
    };
    d.toTypeArray = function () {
        var c = new Float32Array(4);
        c[0] = this.x;
        c[1] = this.y;
        c[2] = this.z;
        c[3] = this.w;
        return c
    }
})(cc);
(function (c) {
    function d(d, f, g) {
        f = new c.math.Vec2(f);
        f.subtract(d);
        g.x = -f.y;
        g.y = f.x;
        g.normalize()
    }

    c.math.Ray2 = function (d, f) {
        this.start = d || new c.math.Vec2;
        this.dir = f || new c.math.Vec2
    };
    c.math.Ray2.prototype.fill = function (c, d, g, h) {
        this.start.x = c;
        this.start.y = d;
        this.dir.x = g;
        this.dir.y = h
    };
    c.math.Ray2.prototype.intersectLineSegment = function (d, f, g) {
        var h = this.start.x, k = this.start.y, m = this.start.x + this.dir.x, n = this.start.y + this.dir.y, p = d.x, r = d.y, s = f.x, v = f.y, t = (v - r) * (m - h) - (s - p) * (n - k);
        if (t > -c.math.EPSILON &&
            t < c.math.EPSILON)return !1;
        r = ((s - p) * (k - r) - (v - r) * (h - p)) / t;
        p = h + r * (m - h);
        r = k + r * (n - k);
        if (p < Math.min(d.x, f.x) - c.math.EPSILON || p > Math.max(d.x, f.x) + c.math.EPSILON || r < Math.min(d.y, f.y) - c.math.EPSILON || r > Math.max(d.y, f.y) + c.math.EPSILON || p < Math.min(h, m) - c.math.EPSILON || p > Math.max(h, m) + c.math.EPSILON || r < Math.min(k, n) - c.math.EPSILON || r > Math.max(k, n) + c.math.EPSILON)return !1;
        g.x = p;
        g.y = r;
        return !0
    };
    c.math.Ray2.prototype.intersectTriangle = function (e, f, g, h, k) {
        var m = new c.math.Vec2, n = new c.math.Vec2, p = new c.math.Vec2,
            r = 1E4, s = !1, v;
        this.intersectLineSegment(e, f, m) && (s = !0, v = m.subtract(this.start).length(), v < r && (n.x = m.x, n.y = m.y, r = v, d(e, f, p)));
        this.intersectLineSegment(f, g, m) && (s = !0, v = m.subtract(this.start).length(), v < r && (n.x = m.x, n.y = m.y, r = v, d(f, g, p)));
        this.intersectLineSegment(g, e, m) && (s = !0, v = m.subtract(this.start).length(), v < r && (n.x = m.x, n.y = m.y, d(g, e, p)));
        s && (h.x = n.x, h.y = n.y, k && (k.x = p.x, k.y = p.y));
        return s
    }
})(cc);
window.Uint16Array = window.Uint16Array || window.Array;
window.Float32Array = window.Float32Array || window.Array;
(function (c) {
    c.math.Matrix3 = function (c) {
        this.mat = c && c.mat ? new Float32Array(c.mat) : new Float32Array(9)
    };
    c.kmMat3 = c.math.Matrix3;
    var d = c.math.Matrix3.prototype;
    d.fill = function (c) {
        var d = this.mat;
        c = c.mat;
        d[0] = c[0];
        d[1] = c[1];
        d[2] = c[2];
        d[3] = c[3];
        d[4] = c[4];
        d[5] = c[5];
        d[6] = c[6];
        d[7] = c[7];
        d[8] = c[8];
        return this
    };
    d.adjugate = function () {
        var c = this.mat, d = c[0], e = c[1], k = c[2], m = c[3], n = c[4], p = c[5], r = c[6], s = c[7], v = c[8];
        c[0] = n * v - p * s;
        c[1] = k * s - e * v;
        c[2] = e * p - k * n;
        c[3] = p * r - m * v;
        c[4] = d * v - k * r;
        c[5] = k * m - d * p;
        c[6] = m * s - n * r;
        c[8] = d *
            n - e * m;
        return this
    };
    d.identity = function () {
        var c = this.mat;
        c[1] = c[2] = c[3] = c[5] = c[6] = c[7] = 0;
        c[0] = c[4] = c[8] = 1;
        return this
    };
    var e = new c.math.Matrix3;
    d.inverse = function (c) {
        if (0 === c)return this;
        e.assignFrom(this);
        c = 1 / c;
        this.adjugate();
        this.multiplyScalar(c);
        return this
    };
    d.isIdentity = function () {
        var c = this.mat;
        return 1 === c[0] && 0 === c[1] && 0 === c[2] && 0 === c[3] && 1 === c[4] && 0 === c[5] && 0 === c[6] && 0 === c[7] && 1 === c[8]
    };
    d.transpose = function () {
        var c = this.mat, d = c[1], e = c[2], k = c[5], m = c[6], n = c[7];
        c[1] = c[3];
        c[2] = m;
        c[3] = d;
        c[5] =
            n;
        c[6] = e;
        c[7] = k;
        return this
    };
    d.determinant = function () {
        var c = this.mat, d = c[0] * c[4] * c[8] + c[1] * c[5] * c[6] + c[2] * c[3] * c[7];
        return d -= c[2] * c[4] * c[6] + c[0] * c[5] * c[7] + c[1] * c[3] * c[8]
    };
    d.multiply = function (c) {
        var d = this.mat, e = c.mat;
        c = d[0];
        var k = d[1], m = d[2], n = d[3], p = d[4], r = d[5], s = d[6], v = d[7], t = d[8], w = e[0], u = e[1], A = e[2], x = e[3], B = e[4], F = e[5], z = e[6], y = e[7], e = e[8];
        d[0] = c * w + n * u + s * A;
        d[1] = k * w + p * u + v * A;
        d[2] = m * w + r * u + t * A;
        d[3] = m * w + r * u + t * A;
        d[4] = k * x + p * B + v * F;
        d[5] = m * x + r * B + t * F;
        d[6] = c * z + n * y + s * e;
        d[7] = k * z + p * y + v * e;
        d[8] = m * z + r * y + t * e;
        return this
    };
    d.multiplyScalar = function (c) {
        var d = this.mat;
        d[0] *= c;
        d[1] *= c;
        d[2] *= c;
        d[3] *= c;
        d[4] *= c;
        d[5] *= c;
        d[6] *= c;
        d[7] *= c;
        d[8] *= c;
        return this
    };
    c.math.Matrix3.rotationAxisAngle = function (d, e) {
        var h = Math.cos(e), k = Math.sin(e), m = new c.math.Matrix3, n = m.mat;
        n[0] = h + d.x * d.x * (1 - h);
        n[1] = d.z * k + d.y * d.x * (1 - h);
        n[2] = -d.y * k + d.z * d.x * (1 - h);
        n[3] = -d.z * k + d.x * d.y * (1 - h);
        n[4] = h + d.y * d.y * (1 - h);
        n[5] = d.x * k + d.z * d.y * (1 - h);
        n[6] = d.y * k + d.x * d.z * (1 - h);
        n[7] = -d.x * k + d.y * d.z * (1 - h);
        n[8] = h + d.z * d.z * (1 - h);
        return m
    };
    d.assignFrom = function (d) {
        if (this ===
            d)return c.log("cc.math.Matrix3.assign(): current matrix equals matIn"), this;
        var e = this.mat;
        d = d.mat;
        e[0] = d[0];
        e[1] = d[1];
        e[2] = d[2];
        e[3] = d[3];
        e[4] = d[4];
        e[5] = d[5];
        e[6] = d[6];
        e[7] = d[7];
        e[8] = d[8];
        return this
    };
    d.equals = function (d) {
        if (this === d)return !0;
        var e = c.math.EPSILON, h = this.mat;
        d = d.mat;
        for (var k = 0; 9 > k; ++k)if (!(h[k] + e > d[k] && h[k] - e < d[k]))return !1;
        return !0
    };
    c.math.Matrix3.createByRotationX = function (d) {
        var e = new c.math.Matrix3, h = e.mat;
        h[0] = 1;
        h[1] = 0;
        h[2] = 0;
        h[3] = 0;
        h[4] = Math.cos(d);
        h[5] = Math.sin(d);
        h[6] = 0;
        h[7] = -Math.sin(d);
        h[8] = Math.cos(d);
        return e
    };
    c.math.Matrix3.createByRotationY = function (d) {
        var e = new c.math.Matrix3, h = e.mat;
        h[0] = Math.cos(d);
        h[1] = 0;
        h[2] = -Math.sin(d);
        h[3] = 0;
        h[4] = 1;
        h[5] = 0;
        h[6] = Math.sin(d);
        h[7] = 0;
        h[8] = Math.cos(d);
        return e
    };
    c.math.Matrix3.createByRotationZ = function (d) {
        var e = new c.math.Matrix3, h = e.mat;
        h[0] = Math.cos(d);
        h[1] = -Math.sin(d);
        h[2] = 0;
        h[3] = Math.sin(d);
        h[4] = Math.cos(d);
        h[5] = 0;
        h[6] = 0;
        h[7] = 0;
        h[8] = 1;
        return e
    };
    c.math.Matrix3.createByRotation = function (d) {
        var e = new c.math.Matrix3, h = e.mat;
        h[0] = Math.cos(d);
        h[1] = Math.sin(d);
        h[2] = 0;
        h[3] = -Math.sin(d);
        h[4] = Math.cos(d);
        h[5] = 0;
        h[6] = 0;
        h[7] = 0;
        h[8] = 1;
        return e
    };
    c.math.Matrix3.createByScale = function (d, e) {
        var h = new c.math.Matrix3;
        h.identity();
        h.mat[0] = d;
        h.mat[4] = e;
        return h
    };
    c.math.Matrix3.createByTranslation = function (d, e) {
        var h = new c.math.Matrix3;
        h.identity();
        h.mat[6] = d;
        h.mat[7] = e;
        return h
    };
    c.math.Matrix3.createByQuaternion = function (d) {
        if (!d)return null;
        var e = new c.math.Matrix3, h = e.mat;
        h[0] = 1 - 2 * (d.y * d.y + d.z * d.z);
        h[1] = 2 * (d.x * d.y - d.w * d.z);
        h[2] = 2 *
            (d.x * d.z + d.w * d.y);
        h[3] = 2 * (d.x * d.y + d.w * d.z);
        h[4] = 1 - 2 * (d.x * d.x + d.z * d.z);
        h[5] = 2 * (d.y * d.z - d.w * d.x);
        h[6] = 2 * (d.x * d.z - d.w * d.y);
        h[7] = 2 * (d.y * d.z + d.w * d.x);
        h[8] = 1 - 2 * (d.x * d.x + d.y * d.y);
        return e
    };
    d.rotationToAxisAngle = function () {
        return c.math.Quaternion.rotationMatrix(this).toAxisAndAngle()
    }
})(cc);
(function (c) {
    c.math.Matrix4 = function (c) {
        this.mat = c && c.mat ? new Float32Array(c.mat) : new Float32Array(16)
    };
    c.kmMat4 = c.math.Matrix4;
    var d = c.math.Matrix4.prototype;
    d.fill = function (c) {
        for (var d = this.mat, e = 0; 16 > e; e++)d[e] = c[e];
        return this
    };
    c.kmMat4Identity = function (c) {
        var d = c.mat;
        d[1] = d[2] = d[3] = d[4] = d[6] = d[7] = d[8] = d[9] = d[11] = d[12] = d[13] = d[14] = 0;
        d[0] = d[5] = d[10] = d[15] = 1;
        return c
    };
    d.identity = function () {
        var c = this.mat;
        c[1] = c[2] = c[3] = c[4] = c[6] = c[7] = c[8] = c[9] = c[11] = c[12] = c[13] = c[14] = 0;
        c[0] = c[5] = c[10] = c[15] = 1;
        return this
    };
    d.get = function (c, d) {
        return this.mat[c + 4 * d]
    };
    d.set = function (c, d, e) {
        this.mat[c + 4 * d] = e
    };
    d.swap = function (c, d, e, f) {
        var n = this.mat, p = n[c + 4 * d];
        n[c + 4 * d] = n[e + 4 * f];
        n[e + 4 * f] = p
    };
    c.math.Matrix4._gaussj = function (c, d) {
        var e, f = 0, n = 0, p, r, s, v, t = [0, 0, 0, 0], w = [0, 0, 0, 0], u = [0, 0, 0, 0];
        for (e = 0; 4 > e; e++) {
            for (p = v = 0; 4 > p; p++)if (1 !== u[p])for (r = 0; 4 > r; r++)0 === u[r] && (s = Math.abs(c.get(p, r)), s >= v && (v = s, n = p, f = r));
            ++u[f];
            if (n !== f) {
                for (p = 0; 4 > p; p++)c.swap(n, p, f, p);
                for (p = 0; 4 > p; p++)d.swap(n, p, f, p)
            }
            w[e] = n;
            t[e] = f;
            if (0 === c.get(f,
                    f))return !1;
            r = 1 / c.get(f, f);
            c.set(f, f, 1);
            for (p = 0; 4 > p; p++)c.set(f, p, c.get(f, p) * r);
            for (p = 0; 4 > p; p++)d.set(f, p, d.get(f, p) * r);
            for (r = 0; 4 > r; r++)if (r !== f) {
                s = c.get(r, f);
                c.set(r, f, 0);
                for (p = 0; 4 > p; p++)c.set(r, p, c.get(r, p) - c.get(f, p) * s);
                for (p = 0; 4 > p; p++)d.set(r, p, c.get(r, p) - d.get(f, p) * s)
            }
        }
        for (p = 3; 0 <= p; p--)if (w[p] !== t[p])for (r = 0; 4 > r; r++)c.swap(r, w[p], r, t[p]);
        return !0
    };
    var e = (new c.math.Matrix4).identity();
    c.kmMat4Inverse = function (d, f) {
        var k = new c.math.Matrix4(f), m = new c.math.Matrix4(e);
        if (!1 === c.math.Matrix4._gaussj(k,
                m))return null;
        d.assignFrom(k);
        return d
    };
    d.inverse = function () {
        var d = new c.math.Matrix4(this), f = new c.math.Matrix4(e);
        return !1 === c.math.Matrix4._gaussj(d, f) ? null : d
    };
    d.isIdentity = function () {
        var c = this.mat;
        return 1 === c[0] && 0 === c[1] && 0 === c[2] && 0 === c[3] && 0 === c[4] && 1 === c[5] && 0 === c[6] && 0 === c[7] && 0 === c[8] && 0 === c[9] && 1 === c[10] && 0 === c[11] && 0 === c[12] && 0 === c[13] && 0 === c[14] && 1 === c[15]
    };
    d.transpose = function () {
        var c = this.mat, d = c[1], e = c[2], f = c[3], n = c[6], p = c[7], r = c[8], s = c[9], v = c[11], t = c[12], w = c[13], u = c[14];
        c[1] = c[4];
        c[2] = r;
        c[3] = t;
        c[4] = d;
        c[6] = s;
        c[7] = w;
        c[8] = e;
        c[9] = n;
        c[11] = u;
        c[12] = f;
        c[13] = p;
        c[14] = v;
        return this
    };
    c.kmMat4Multiply = function (c, d, e) {
        var f = c.mat, n = d.mat, p = e.mat;
        e = n[0];
        d = n[1];
        var r = n[2], s = n[3], v = n[4], t = n[5], w = n[6], u = n[7], A = n[8], x = n[9], B = n[10], F = n[11], z = n[12], y = n[13], K = n[14], n = n[15], D = p[0], I = p[1], N = p[2], Y = p[3], G = p[4], Z = p[5], L = p[6], $ = p[7], S = p[8], O = p[9], U = p[10], R = p[11], T = p[12], V = p[13], ja = p[14], p = p[15];
        f[0] = D * e + I * v + N * A + Y * z;
        f[1] = D * d + I * t + N * x + Y * y;
        f[2] = D * r + I * w + N * B + Y * K;
        f[3] = D * s + I * u + N * F + Y * n;
        f[4] = G * e + Z * v + L * A + $ * z;
        f[5] = G * d + Z * t + L * x + $ * y;
        f[6] = G * r + Z * w + L * B + $ * K;
        f[7] = G * s + Z * u + L * F + $ * n;
        f[8] = S * e + O * v + U * A + R * z;
        f[9] = S * d + O * t + U * x + R * y;
        f[10] = S * r + O * w + U * B + R * K;
        f[11] = S * s + O * u + U * F + R * n;
        f[12] = T * e + V * v + ja * A + p * z;
        f[13] = T * d + V * t + ja * x + p * y;
        f[14] = T * r + V * w + ja * B + p * K;
        f[15] = T * s + V * u + ja * F + p * n;
        return c
    };
    d.multiply = function (c) {
        var d = this.mat, e = c.mat;
        c = d[0];
        var f = d[1], n = d[2], p = d[3], r = d[4], s = d[5], v = d[6], t = d[7], w = d[8], u = d[9], A = d[10], x = d[11], B = d[12], F = d[13], z = d[14], y = d[15], K = e[0], D = e[1], I = e[2], N = e[3], Y = e[4], G = e[5], Z = e[6], L = e[7], $ = e[8], S = e[9], O = e[10], U = e[11],
            R = e[12], T = e[13], V = e[14], e = e[15];
        d[0] = K * c + D * r + I * w + N * B;
        d[1] = K * f + D * s + I * u + N * F;
        d[2] = K * n + D * v + I * A + N * z;
        d[3] = K * p + D * t + I * x + N * y;
        d[4] = Y * c + G * r + Z * w + L * B;
        d[5] = Y * f + G * s + Z * u + L * F;
        d[6] = Y * n + G * v + Z * A + L * z;
        d[7] = Y * p + G * t + Z * x + L * y;
        d[8] = $ * c + S * r + O * w + U * B;
        d[9] = $ * f + S * s + O * u + U * F;
        d[10] = $ * n + S * v + O * A + U * z;
        d[11] = $ * p + S * t + O * x + U * y;
        d[12] = R * c + T * r + V * w + e * B;
        d[13] = R * f + T * s + V * u + e * F;
        d[14] = R * n + T * v + V * A + e * z;
        d[15] = R * p + T * t + V * x + e * y;
        return this
    };
    c.getMat4MultiplyValue = function (c, d) {
        var e = c.mat, f = d.mat, n = new Float32Array(16);
        n[0] = e[0] * f[0] + e[4] * f[1] + e[8] * f[2] +
            e[12] * f[3];
        n[1] = e[1] * f[0] + e[5] * f[1] + e[9] * f[2] + e[13] * f[3];
        n[2] = e[2] * f[0] + e[6] * f[1] + e[10] * f[2] + e[14] * f[3];
        n[3] = e[3] * f[0] + e[7] * f[1] + e[11] * f[2] + e[15] * f[3];
        n[4] = e[0] * f[4] + e[4] * f[5] + e[8] * f[6] + e[12] * f[7];
        n[5] = e[1] * f[4] + e[5] * f[5] + e[9] * f[6] + e[13] * f[7];
        n[6] = e[2] * f[4] + e[6] * f[5] + e[10] * f[6] + e[14] * f[7];
        n[7] = e[3] * f[4] + e[7] * f[5] + e[11] * f[6] + e[15] * f[7];
        n[8] = e[0] * f[8] + e[4] * f[9] + e[8] * f[10] + e[12] * f[11];
        n[9] = e[1] * f[8] + e[5] * f[9] + e[9] * f[10] + e[13] * f[11];
        n[10] = e[2] * f[8] + e[6] * f[9] + e[10] * f[10] + e[14] * f[11];
        n[11] = e[3] * f[8] + e[7] *
            f[9] + e[11] * f[10] + e[15] * f[11];
        n[12] = e[0] * f[12] + e[4] * f[13] + e[8] * f[14] + e[12] * f[15];
        n[13] = e[1] * f[12] + e[5] * f[13] + e[9] * f[14] + e[13] * f[15];
        n[14] = e[2] * f[12] + e[6] * f[13] + e[10] * f[14] + e[14] * f[15];
        n[15] = e[3] * f[12] + e[7] * f[13] + e[11] * f[14] + e[15] * f[15];
        return n
    };
    c.kmMat4Assign = function (d, e) {
        if (d === e)return c.log("cc.kmMat4Assign(): pOut equals pIn"), d;
        var f = d.mat, m = e.mat;
        f[0] = m[0];
        f[1] = m[1];
        f[2] = m[2];
        f[3] = m[3];
        f[4] = m[4];
        f[5] = m[5];
        f[6] = m[6];
        f[7] = m[7];
        f[8] = m[8];
        f[9] = m[9];
        f[10] = m[10];
        f[11] = m[11];
        f[12] = m[12];
        f[13] = m[13];
        f[14] = m[14];
        f[15] = m[15];
        return d
    };
    d.assignFrom = function (d) {
        if (this === d)return c.log("cc.mat.Matrix4.assignFrom(): mat4 equals current matrix"), this;
        var e = this.mat;
        d = d.mat;
        e[0] = d[0];
        e[1] = d[1];
        e[2] = d[2];
        e[3] = d[3];
        e[4] = d[4];
        e[5] = d[5];
        e[6] = d[6];
        e[7] = d[7];
        e[8] = d[8];
        e[9] = d[9];
        e[10] = d[10];
        e[11] = d[11];
        e[12] = d[12];
        e[13] = d[13];
        e[14] = d[14];
        e[15] = d[15];
        return this
    };
    d.equals = function (d) {
        if (this === d)return c.log("cc.kmMat4AreEqual(): pMat1 and pMat2 are same object."), !0;
        var e = this.mat;
        d = d.mat;
        for (var f = c.math.EPSILON,
                 m = 0; 16 > m; m++)if (!(e[m] + f > d[m] && e[m] - f < d[m]))return !1;
        return !0
    };
    c.math.Matrix4.createByRotationX = function (d, e) {
        e = e || new c.math.Matrix4;
        var f = e.mat;
        f[0] = 1;
        f[3] = f[2] = f[1] = 0;
        f[4] = 0;
        f[5] = Math.cos(d);
        f[6] = Math.sin(d);
        f[7] = 0;
        f[8] = 0;
        f[9] = -Math.sin(d);
        f[10] = Math.cos(d);
        f[11] = 0;
        f[14] = f[13] = f[12] = 0;
        f[15] = 1;
        return e
    };
    c.math.Matrix4.createByRotationY = function (d, e) {
        e = e || new c.math.Matrix4;
        var f = e.mat;
        f[0] = Math.cos(d);
        f[1] = 0;
        f[2] = -Math.sin(d);
        f[3] = 0;
        f[7] = f[6] = f[4] = 0;
        f[5] = 1;
        f[8] = Math.sin(d);
        f[9] = 0;
        f[10] = Math.cos(d);
        f[11] = 0;
        f[14] = f[13] = f[12] = 0;
        f[15] = 1;
        return e
    };
    c.math.Matrix4.createByRotationZ = function (d, e) {
        e = e || new c.math.Matrix4;
        var f = e.mat;
        f[0] = Math.cos(d);
        f[1] = Math.sin(d);
        f[3] = f[2] = 0;
        f[4] = -Math.sin(d);
        f[5] = Math.cos(d);
        f[7] = f[6] = 0;
        f[11] = f[9] = f[8] = 0;
        f[10] = 1;
        f[14] = f[13] = f[12] = 0;
        f[15] = 1;
        return e
    };
    c.math.Matrix4.createByPitchYawRoll = function (d, e, f, m) {
        m = m || new c.math.Matrix4;
        var n = Math.cos(d);
        d = Math.sin(d);
        var p = Math.cos(e);
        e = Math.sin(e);
        var r = Math.cos(f);
        f = Math.sin(f);
        var s = d * e, v = n * e, t = m.mat;
        t[0] = p * r;
        t[4] = p * f;
        t[8] = -e;
        t[1] = s * r - n * f;
        t[5] = s * f + n * r;
        t[9] = d * p;
        t[2] = v * r + d * f;
        t[6] = v * f - d * r;
        t[10] = n * p;
        t[3] = t[7] = t[11] = 0;
        t[15] = 1;
        return m
    };
    c.math.Matrix4.createByQuaternion = function (d, e) {
        e = e || new c.math.Matrix4;
        var f = e.mat;
        f[0] = 1 - 2 * (d.y * d.y + d.z * d.z);
        f[1] = 2 * (d.x * d.y + d.z * d.w);
        f[2] = 2 * (d.x * d.z - d.y * d.w);
        f[3] = 0;
        f[4] = 2 * (d.x * d.y - d.z * d.w);
        f[5] = 1 - 2 * (d.x * d.x + d.z * d.z);
        f[6] = 2 * (d.z * d.y + d.x * d.w);
        f[7] = 0;
        f[8] = 2 * (d.x * d.z + d.y * d.w);
        f[9] = 2 * (d.y * d.z - d.x * d.w);
        f[10] = 1 - 2 * (d.x * d.x + d.y * d.y);
        f[11] = 0;
        f[14] = f[13] = f[12] = 0;
        f[15] = 1;
        return e
    };
    c.math.Matrix4.createByRotationTranslation =
        function (d, e, f) {
            f = f || new c.math.Matrix4;
            var m = f.mat;
            d = d.mat;
            m[0] = d[0];
            m[1] = d[1];
            m[2] = d[2];
            m[3] = 0;
            m[4] = d[3];
            m[5] = d[4];
            m[6] = d[5];
            m[7] = 0;
            m[8] = d[6];
            m[9] = d[7];
            m[10] = d[8];
            m[11] = 0;
            m[12] = e.x;
            m[13] = e.y;
            m[14] = e.z;
            m[15] = 1;
            return f
        };
    c.math.Matrix4.createByScale = function (d, e, f, m) {
        m = m || new c.math.Matrix4;
        var n = m.mat;
        n[0] = d;
        n[5] = e;
        n[10] = f;
        n[15] = 1;
        n[1] = n[2] = n[3] = n[4] = n[6] = n[7] = n[8] = n[9] = n[11] = n[12] = n[13] = n[14] = 0;
        return m
    };
    c.kmMat4Translation = function (c, d, e, f) {
        c.mat[0] = c.mat[5] = c.mat[10] = c.mat[15] = 1;
        c.mat[1] = c.mat[2] =
            c.mat[3] = c.mat[4] = c.mat[6] = c.mat[7] = c.mat[8] = c.mat[9] = c.mat[11] = 0;
        c.mat[12] = d;
        c.mat[13] = e;
        c.mat[14] = f;
        return c
    };
    c.math.Matrix4.createByTranslation = function (d, e, f, m) {
        m = m || new c.math.Matrix4;
        m.identity();
        m.mat[12] = d;
        m.mat[13] = e;
        m.mat[14] = f;
        return m
    };
    d.getUpVec3 = function () {
        var d = this.mat;
        return (new c.math.Vec3(d[4], d[5], d[6])).normalize()
    };
    d.getRightVec3 = function () {
        var d = this.mat;
        return (new c.math.Vec3(d[0], d[1], d[2])).normalize()
    };
    d.getForwardVec3 = function () {
        var d = this.mat;
        return (new c.math.Vec3(d[8],
            d[9], d[10])).normalize()
    };
    c.kmMat4PerspectiveProjection = function (d, e, f, m, n) {
        var p = c.degreesToRadians(e / 2);
        e = n - m;
        var r = Math.sin(p);
        if (0 === e || 0 === r || 0 === f)return null;
        p = Math.cos(p) / r;
        d.identity();
        d.mat[0] = p / f;
        d.mat[5] = p;
        d.mat[10] = -(n + m) / e;
        d.mat[11] = -1;
        d.mat[14] = -2 * m * n / e;
        d.mat[15] = 0;
        return d
    };
    c.math.Matrix4.createPerspectiveProjection = function (d, e, f, m) {
        var n = c.degreesToRadians(d / 2);
        d = m - f;
        var p = Math.sin(n);
        if (0 === d || 0 === p || 0 === e)return null;
        var n = Math.cos(n) / p, p = new c.math.Matrix4, r = p.mat;
        p.identity();
        r[0] = n / e;
        r[5] = n;
        r[10] = -(m + f) / d;
        r[11] = -1;
        r[14] = -2 * f * m / d;
        r[15] = 0;
        return p
    };
    c.kmMat4OrthographicProjection = function (c, d, e, f, n, p, r) {
        c.identity();
        c.mat[0] = 2 / (e - d);
        c.mat[5] = 2 / (n - f);
        c.mat[10] = -2 / (r - p);
        c.mat[12] = -((e + d) / (e - d));
        c.mat[13] = -((n + f) / (n - f));
        c.mat[14] = -((r + p) / (r - p));
        return c
    };
    c.math.Matrix4.createOrthographicProjection = function (d, e, f, m, n, p) {
        var r = new c.math.Matrix4, s = r.mat;
        r.identity();
        s[0] = 2 / (e - d);
        s[5] = 2 / (m - f);
        s[10] = -2 / (p - n);
        s[12] = -((e + d) / (e - d));
        s[13] = -((m + f) / (m - f));
        s[14] = -((p + n) / (p - n));
        return r
    };
    c.kmMat4LookAt = function (d, e, f, m) {
        f = new c.math.Vec3(f);
        var n = new c.math.Vec3(m);
        f.subtract(e);
        f.normalize();
        n.normalize();
        m = new c.math.Vec3(f);
        m.cross(n);
        m.normalize();
        n = new c.math.Vec3(m);
        n.cross(f);
        m.normalize();
        d.identity();
        d.mat[0] = m.x;
        d.mat[4] = m.y;
        d.mat[8] = m.z;
        d.mat[1] = n.x;
        d.mat[5] = n.y;
        d.mat[9] = n.z;
        d.mat[2] = -f.x;
        d.mat[6] = -f.y;
        d.mat[10] = -f.z;
        e = c.math.Matrix4.createByTranslation(-e.x, -e.y, -e.z);
        d.multiply(e);
        return d
    };
    var f = new c.math.Matrix4;
    d.lookAt = function (d, e, k) {
        e = new c.math.Vec3(e);
        var m =
            new c.math.Vec3(k);
        k = this.mat;
        e.subtract(d);
        e.normalize();
        m.normalize();
        var n = new c.math.Vec3(e);
        n.cross(m);
        n.normalize();
        m = new c.math.Vec3(n);
        m.cross(e);
        n.normalize();
        this.identity();
        k[0] = n.x;
        k[4] = n.y;
        k[8] = n.z;
        k[1] = m.x;
        k[5] = m.y;
        k[9] = m.z;
        k[2] = -e.x;
        k[6] = -e.y;
        k[10] = -e.z;
        f = c.math.Matrix4.createByTranslation(-d.x, -d.y, -d.z, f);
        this.multiply(f);
        return this
    };
    c.kmMat4RotationAxisAngle = function (d, e, f) {
        var m = Math.cos(f);
        f = Math.sin(f);
        e = new c.math.Vec3(e);
        e.normalize();
        d.mat[0] = m + e.x * e.x * (1 - m);
        d.mat[1] = e.z *
            f + e.y * e.x * (1 - m);
        d.mat[2] = -e.y * f + e.z * e.x * (1 - m);
        d.mat[3] = 0;
        d.mat[4] = -e.z * f + e.x * e.y * (1 - m);
        d.mat[5] = m + e.y * e.y * (1 - m);
        d.mat[6] = e.x * f + e.z * e.y * (1 - m);
        d.mat[7] = 0;
        d.mat[8] = e.y * f + e.x * e.z * (1 - m);
        d.mat[9] = -e.x * f + e.y * e.z * (1 - m);
        d.mat[10] = m + e.z * e.z * (1 - m);
        d.mat[11] = 0;
        d.mat[12] = 0;
        d.mat[13] = 0;
        d.mat[14] = 0;
        d.mat[15] = 1;
        return d
    };
    c.math.Matrix4.createByAxisAndAngle = function (d, e, f) {
        f = f || new c.math.Matrix4;
        var m = this.mat, n = Math.cos(e);
        e = Math.sin(e);
        d = new c.math.Vec3(d);
        d.normalize();
        m[0] = n + d.x * d.x * (1 - n);
        m[1] = d.z * e + d.y * d.x *
            (1 - n);
        m[2] = -d.y * e + d.z * d.x * (1 - n);
        m[3] = 0;
        m[4] = -d.z * e + d.x * d.y * (1 - n);
        m[5] = n + d.y * d.y * (1 - n);
        m[6] = d.x * e + d.z * d.y * (1 - n);
        m[7] = 0;
        m[8] = d.y * e + d.x * d.z * (1 - n);
        m[9] = -d.x * e + d.y * d.z * (1 - n);
        m[10] = n + d.z * d.z * (1 - n);
        m[11] = 0;
        m[12] = m[13] = m[14] = 0;
        m[15] = 1;
        return f
    };
    d.extractRotation = function () {
        var d = new c.math.Matrix3, e = this.mat, f = d.mat;
        f[0] = e[0];
        f[1] = e[1];
        f[2] = e[2];
        f[3] = e[4];
        f[4] = e[5];
        f[5] = e[6];
        f[6] = e[8];
        f[7] = e[9];
        f[8] = e[10];
        return d
    };
    d.extractPlane = function (d) {
        var e = new c.math.Plane, f = this.mat;
        switch (d) {
            case c.math.Plane.RIGHT:
                e.a =
                    f[3] - f[0];
                e.b = f[7] - f[4];
                e.c = f[11] - f[8];
                e.d = f[15] - f[12];
                break;
            case c.math.Plane.LEFT:
                e.a = f[3] + f[0];
                e.b = f[7] + f[4];
                e.c = f[11] + f[8];
                e.d = f[15] + f[12];
                break;
            case c.math.Plane.BOTTOM:
                e.a = f[3] + f[1];
                e.b = f[7] + f[5];
                e.c = f[11] + f[9];
                e.d = f[15] + f[13];
                break;
            case c.math.Plane.TOP:
                e.a = f[3] - f[1];
                e.b = f[7] - f[5];
                e.c = f[11] - f[9];
                e.d = f[15] - f[13];
                break;
            case c.math.Plane.FAR:
                e.a = f[3] - f[2];
                e.b = f[7] - f[6];
                e.c = f[11] - f[10];
                e.d = f[15] - f[14];
                break;
            case c.math.Plane.NEAR:
                e.a = f[3] + f[2];
                e.b = f[7] + f[6];
                e.c = f[11] + f[10];
                e.d = f[15] + f[14];
                break;
            default:
                c.log("cc.math.Matrix4.extractPlane: Invalid plane index")
        }
        d = Math.sqrt(e.a * e.a + e.b * e.b + e.c * e.c);
        e.a /= d;
        e.b /= d;
        e.c /= d;
        e.d /= d;
        return e
    };
    d.toAxisAndAngle = function () {
        var d = this.extractRotation();
        return c.math.Quaternion.rotationMatrix(d).toAxisAndAngle()
    }
})(cc);
(function (c) {
    c.math.Plane = function (c, d, g, h) {
        c && void 0 === d ? (this.a = c.a, this.b = c.b, this.c = c.c, this.d = c.d) : (this.a = c || 0, this.b = d || 0, this.c = g || 0, this.d = h || 0)
    };
    c.kmPlane = c.math.Plane;
    var d = c.math.Plane.prototype;
    c.math.Plane.LEFT = 0;
    c.math.Plane.RIGHT = 1;
    c.math.Plane.BOTTOM = 2;
    c.math.Plane.TOP = 3;
    c.math.Plane.NEAR = 4;
    c.math.Plane.FAR = 5;
    c.math.Plane.POINT_INFRONT_OF_PLANE = 0;
    c.math.Plane.POINT_BEHIND_PLANE = 1;
    c.math.Plane.POINT_ON_PLANE = 2;
    d.dot = function (c) {
        return this.a * c.x + this.b * c.y + this.c * c.z + this.d * c.w
    };
    d.dotCoord =
        function (c) {
            return this.a * c.x + this.b * c.y + this.c * c.z + this.d
        };
    d.dotNormal = function (c) {
        return this.a * c.x + this.b * c.y + this.c * c.z
    };
    c.math.Plane.fromPointNormal = function (d, f) {
        return new c.math.Plane(f.x, f.y, f.z, -f.dot(d))
    };
    c.math.Plane.fromPoints = function (d, f, g) {
        f = new c.math.Vec3(f);
        g = new c.math.Vec3(g);
        var h = new c.math.Plane;
        f.subtract(d);
        g.subtract(d);
        f.cross(g);
        f.normalize();
        h.a = f.x;
        h.b = f.y;
        h.c = f.z;
        h.d = f.scale(-1).dot(d);
        return h
    };
    d.normalize = function () {
        var d = new c.math.Vec3(this.a, this.b, this.c), f = 1 /
            d.length();
        d.normalize();
        this.a = d.x;
        this.b = d.y;
        this.c = d.z;
        this.d *= f;
        return this
    };
    d.classifyPoint = function (d) {
        d = this.a * d.x + this.b * d.y + this.c * d.z + this.d;
        return 0.001 < d ? c.math.Plane.POINT_INFRONT_OF_PLANE : -0.001 > d ? c.math.Plane.POINT_BEHIND_PLANE : c.math.Plane.POINT_ON_PLANE
    }
})(cc);
(function (c) {
    c.math.Quaternion = function (c, d, g, h) {
        c && void 0 === d ? (this.x = c.x, this.y = c.y, this.z = c.z, this.w = c.w) : (this.x = c || 0, this.y = d || 0, this.z = g || 0, this.w = h || 0)
    };
    c.kmQuaternion = c.math.Quaternion;
    var d = c.math.Quaternion.prototype;
    d.conjugate = function (c) {
        this.x = -c.x;
        this.y = -c.y;
        this.z = -c.z;
        this.w = c.w;
        return this
    };
    d.dot = function (c) {
        return this.w * c.w + this.x * c.x + this.y * c.y + this.z * c.z
    };
    d.exponential = function () {
        return this
    };
    d.identity = function () {
        this.z = this.y = this.x = 0;
        this.w = 1;
        return this
    };
    d.inverse = function () {
        var d =
            this.length();
        if (Math.abs(d) > c.math.EPSILON)return this.w = this.z = this.y = this.x = 0, this;
        this.conjugate(this).scale(1 / d);
        return this
    };
    d.isIdentity = function () {
        return 0 === this.x && 0 === this.y && 0 === this.z && 1 === this.w
    };
    d.length = function () {
        return Math.sqrt(this.lengthSq())
    };
    d.lengthSq = function () {
        return this.x * this.x + this.y * this.y + this.z * this.z + this.w * this.w
    };
    d.multiply = function (c) {
        var d = this.x, g = this.y, h = this.z, k = this.w;
        this.w = k * c.w - d * c.x - g * c.y - h * c.z;
        this.x = k * c.x + d * c.w + g * c.z - h * c.y;
        this.y = k * c.y + g * c.w + h * c.x -
            d * c.z;
        this.z = k * c.z + h * c.w + d * c.y - g * c.x;
        return this
    };
    d.normalize = function () {
        var d = this.length();
        if (Math.abs(d) <= c.math.EPSILON)throw Error("current quaternion is an invalid value");
        this.scale(1 / d);
        return this
    };
    d.rotationAxis = function (c, d) {
        var g = 0.5 * d, h = Math.sin(g);
        this.w = Math.cos(g);
        this.x = c.x * h;
        this.y = c.y * h;
        this.z = c.z * h;
        return this
    };
    c.math.Quaternion.rotationMatrix = function (d) {
        if (!d)return null;
        var f, g, h;
        f = [];
        g = d.mat;
        d = 0;
        f[0] = g[0];
        f[1] = g[3];
        f[2] = g[6];
        f[4] = g[1];
        f[5] = g[4];
        f[6] = g[7];
        f[8] = g[2];
        f[9] = g[5];
        f[10] = g[8];
        f[15] = 1;
        var k = f[0];
        d = k[0] + k[5] + k[10] + 1;
        d > c.math.EPSILON ? (d = 2 * Math.sqrt(d), f = (k[9] - k[6]) / d, g = (k[2] - k[8]) / d, h = (k[4] - k[1]) / d, d *= 0.25) : k[0] > k[5] && k[0] > k[10] ? (d = 2 * Math.sqrt(1 + k[0] - k[5] - k[10]), f = 0.25 * d, g = (k[4] + k[1]) / d, h = (k[2] + k[8]) / d, d = (k[9] - k[6]) / d) : k[5] > k[10] ? (d = 2 * Math.sqrt(1 + k[5] - k[0] - k[10]), f = (k[4] + k[1]) / d, g = 0.25 * d, h = (k[9] + k[6]) / d, d = (k[2] - k[8]) / d) : (d = 2 * Math.sqrt(1 + k[10] - k[0] - k[5]), f = (k[2] + k[8]) / d, g = (k[9] + k[6]) / d, h = 0.25 * d, d = (k[4] - k[1]) / d);
        return new c.math.Quaternion(f, g, h, d)
    };
    c.math.Quaternion.rotationYawPitchRoll =
        function (d, f, g) {
            var h, k, m, n, p;
            h = c.degreesToRadians(f) / 2;
            k = c.degreesToRadians(d) / 2;
            m = c.degreesToRadians(g) / 2;
            g = Math.cos(h);
            d = Math.cos(k);
            f = Math.cos(m);
            h = Math.sin(h);
            k = Math.sin(k);
            m = Math.sin(m);
            n = d * f;
            p = k * m;
            var r = new c.math.Quaternion;
            r.w = g * n + h * p;
            r.x = h * n - g * p;
            r.y = g * k * f + h * d * m;
            r.z = g * d * m - h * k * f;
            r.normalize();
            return r
        };
    d.slerp = function (d, f) {
        if (this.x === d.x && this.y === d.y && this.z === d.z && this.w === d.w)return this;
        var g = this.dot(d), h = Math.acos(g), k = Math.sqrt(1 - c.math.square(g)), g = Math.sin(f * h) / k, h = Math.sin((1 -
                f) * h) / k, k = new c.math.Quaternion(d);
        this.scale(h);
        k.scale(g);
        this.add(k);
        return this
    };
    d.toAxisAndAngle = function () {
        var d, f, g = new c.math.Vec3;
        d = Math.acos(this.w);
        f = Math.sqrt(c.math.square(this.x) + c.math.square(this.y) + c.math.square(this.z));
        f > -c.math.EPSILON && f < c.math.EPSILON || f < 2 * Math.PI + c.math.EPSILON && f > 2 * Math.PI - c.math.EPSILON ? (d = 0, g.x = 0, g.y = 0, g.z = 1) : (d *= 2, g.x = this.x / f, g.y = this.y / f, g.z = this.z / f, g.normalize());
        return {axis: g, angle: d}
    };
    d.scale = function (c) {
        this.x *= c;
        this.y *= c;
        this.z *= c;
        this.w *= c;
        return this
    };
    d.assignFrom = function (c) {
        this.x = c.x;
        this.y = c.y;
        this.z = c.z;
        this.w = c.w;
        return this
    };
    d.add = function (c) {
        this.x += c.x;
        this.y += c.y;
        this.z += c.z;
        this.w += c.w;
        return this
    };
    c.math.Quaternion.rotationBetweenVec3 = function (d, f, g) {
        var h = new c.math.Vec3(d), k = new c.math.Vec3(f);
        h.normalize();
        k.normalize();
        var m = h.dot(k);
        f = new c.math.Quaternion;
        if (1 <= m)return f.identity(), f;
        -0.999999 > m ? Math.abs(g.lengthSq()) < c.math.EPSILON ? f.rotationAxis(g, Math.PI) : (h = new c.math.Vec3(1, 0, 0), h.cross(d), Math.abs(h.lengthSq()) < c.math.EPSILON &&
        (h.fill(0, 1, 0), h.cross(d)), h.normalize(), f.rotationAxis(h, Math.PI)) : (d = Math.sqrt(2 * (1 + m)), g = 1 / d, h.cross(k), f.x = h.x * g, f.y = h.y * g, f.z = h.z * g, f.w = 0.5 * d, f.normalize());
        return f
    };
    d.multiplyVec3 = function (d) {
        var f = this.x, g = this.y, h = this.z, k = new c.math.Vec3(d), m = new c.math.Vec3(f, g, h), f = new c.math.Vec3(f, g, h);
        m.cross(d);
        f.cross(m);
        m.scale(2 * q.w);
        f.scale(2);
        k.add(m);
        k.add(f);
        return k
    }
})(cc);
cc.math.AABB = function (c, d) {
    this.min = c || new cc.math.Vec3;
    this.max = d || new cc.math.Vec3
};
cc.math.AABB.prototype.containsPoint = function (c) {
    return c.x >= this.min.x && c.x <= this.max.x && c.y >= this.min.y && c.y <= this.max.y && c.z >= this.min.z && c.z <= this.max.z
};
cc.math.AABB.containsPoint = function (c, d) {
    return c.x >= d.min.x && c.x <= d.max.x && c.y >= d.min.y && c.y <= d.max.y && c.z >= d.min.z && c.z <= d.max.z
};
cc.math.AABB.prototype.assignFrom = function (c) {
    this.min.assignFrom(c.min);
    this.max.assignFrom(c.max)
};
cc.math.AABB.assign = function (c, d) {
    c.min.assignFrom(d.min);
    c.max.assignFrom(d.max);
    return c
};
(function (c) {
    c.math.Matrix4Stack = function (c, d) {
        this.top = c;
        this.stack = d || []
    };
    c.km_mat4_stack = c.math.Matrix4Stack;
    var d = c.math.Matrix4Stack.prototype;
    d.initialize = function () {
        this.stack.length = 0;
        this.top = null
    };
    c.km_mat4_stack_push = function (d, f) {
        d.stack.push(d.top);
        d.top = new c.math.Matrix4(f)
    };
    c.km_mat4_stack_pop = function (c, d) {
        c.top = c.stack.pop()
    };
    c.km_mat4_stack_release = function (c) {
        c.stack = null;
        c.top = null
    };
    d.push = function (d) {
        d = d || this.top;
        this.stack.push(this.top);
        this.top = new c.math.Matrix4(d)
    };
    d.pop =
        function () {
            this.top = this.stack.pop()
        };
    d.release = function () {
        this._matrixPool = this.top = this.stack = null
    };
    d._getFromPool = function (d) {
        var f = this._matrixPool;
        if (0 === f.length)return new c.math.Matrix4(d);
        f = f.pop();
        f.assignFrom(d);
        return f
    };
    d._putInPool = function (c) {
        this._matrixPool.push(c)
    }
})(cc);
(function (c) {
    c.KM_GL_MODELVIEW = 5888;
    c.KM_GL_PROJECTION = 5889;
    c.KM_GL_TEXTURE = 5890;
    c.modelview_matrix_stack = new c.math.Matrix4Stack;
    c.projection_matrix_stack = new c.math.Matrix4Stack;
    c.texture_matrix_stack = new c.math.Matrix4Stack;
    c.current_stack = null;
    c.lazyInitialize = function () {
        var d = new c.math.Matrix4;
        c.modelview_matrix_stack.initialize();
        c.projection_matrix_stack.initialize();
        c.texture_matrix_stack.initialize();
        c.current_stack = c.modelview_matrix_stack;
        c.initialized = !0;
        d.identity();
        c.modelview_matrix_stack.push(d);
        c.projection_matrix_stack.push(d);
        c.texture_matrix_stack.push(d)
    };
    c.lazyInitialize();
    c.kmGLFreeAll = function () {
        c.modelview_matrix_stack.release();
        c.modelview_matrix_stack = null;
        c.projection_matrix_stack.release();
        c.projection_matrix_stack = null;
        c.texture_matrix_stack.release();
        c.texture_matrix_stack = null;
        c.initialized = !1;
        c.current_stack = null
    };
    c.kmGLPushMatrix = function () {
        c.current_stack.push(c.current_stack.top)
    };
    c.kmGLPushMatrixWitMat4 = function (d) {
        c.current_stack.stack.push(c.current_stack.top);
        d.assignFrom(c.current_stack.top);
        c.current_stack.top = d
    };
    c.kmGLPopMatrix = function () {
        c.current_stack.top = c.current_stack.stack.pop()
    };
    c.kmGLMatrixMode = function (d) {
        switch (d) {
            case c.KM_GL_MODELVIEW:
                c.current_stack = c.modelview_matrix_stack;
                break;
            case c.KM_GL_PROJECTION:
                c.current_stack = c.projection_matrix_stack;
                break;
            case c.KM_GL_TEXTURE:
                c.current_stack = c.texture_matrix_stack;
                break;
            default:
                throw Error("Invalid matrix mode specified");
        }
    };
    c.kmGLLoadIdentity = function () {
        c.current_stack.top.identity()
    };
    c.kmGLLoadMatrix = function (d) {
        c.current_stack.top.assignFrom(d)
    };
    c.kmGLMultMatrix = function (d) {
        c.current_stack.top.multiply(d)
    };
    var d = new c.math.Matrix4;
    c.kmGLTranslatef = function (e, g, h) {
        e = c.math.Matrix4.createByTranslation(e, g, h, d);
        c.current_stack.top.multiply(e)
    };
    var e = new c.math.Vec3;
    c.kmGLRotatef = function (f, g, h, k) {
        e.fill(g, h, k);
        f = c.math.Matrix4.createByAxisAndAngle(e, c.degreesToRadians(f), d);
        c.current_stack.top.multiply(f)
    };
    c.kmGLScalef = function (e, g, h) {
        e = c.math.Matrix4.createByScale(e, g, h, d);
        c.current_stack.top.multiply(e)
    };
    c.kmGLGetMatrix = function (d, e) {
        switch (d) {
            case c.KM_GL_MODELVIEW:
                e.assignFrom(c.modelview_matrix_stack.top);
                break;
            case c.KM_GL_PROJECTION:
                e.assignFrom(c.projection_matrix_stack.top);
                break;
            case c.KM_GL_TEXTURE:
                e.assignFrom(c.texture_matrix_stack.top);
                break;
            default:
                throw Error("Invalid matrix mode specified");
        }
    }
})(cc);
cc.SHADER_POSITION_UCOLOR_FRAG = "precision lowp float;\nvarying vec4 v_fragmentColor;\nvoid main()                              \n{ \n    gl_FragColor \x3d v_fragmentColor;      \n}\n";
cc.SHADER_POSITION_UCOLOR_VERT = "attribute vec4 a_position;\nuniform    vec4 u_color;\nuniform float u_pointSize;\nvarying lowp vec4 v_fragmentColor; \nvoid main(void)   \n{\n    gl_Position \x3d (CC_PMatrix * CC_MVMatrix) * a_position;  \n    gl_PointSize \x3d u_pointSize;          \n    v_fragmentColor \x3d u_color;           \n}";
cc.SHADER_POSITION_COLOR_FRAG = "precision lowp float; \nvarying vec4 v_fragmentColor; \nvoid main() \n{ \n     gl_FragColor \x3d v_fragmentColor; \n} ";
cc.SHADER_POSITION_COLOR_VERT = "attribute vec4 a_position;\nattribute vec4 a_color;\nvarying lowp vec4 v_fragmentColor;\nvoid main()\n{\n    gl_Position \x3d (CC_PMatrix * CC_MVMatrix) * a_position;  \n    v_fragmentColor \x3d a_color;             \n}";
cc.SHADER_SPRITE_POSITION_COLOR_VERT = "attribute vec4 a_position;\nattribute vec4 a_color;\nvarying lowp vec4 v_fragmentColor;\nvoid main()\n{\n    gl_Position \x3d CC_PMatrix * a_position;  \n    v_fragmentColor \x3d a_color;             \n}";
cc.SHADER_POSITION_COLOR_LENGTH_TEXTURE_FRAG = "// #extension GL_OES_standard_derivatives : enable\nvarying mediump vec4 v_color;\nvarying mediump vec2 v_texcoord;\nvoid main()\t\n{ \n// #if defined GL_OES_standard_derivatives\t\n// gl_FragColor \x3d v_color*smoothstep(0.0, length(fwidth(v_texcoord)), 1.0 - length(v_texcoord)); \n// #else\t\ngl_FragColor \x3d v_color * step(0.0, 1.0 - length(v_texcoord)); \n// #endif \n}";
cc.SHADER_POSITION_COLOR_LENGTH_TEXTURE_VERT = "attribute mediump vec4 a_position; \nattribute mediump vec2 a_texcoord; \nattribute mediump vec4 a_color;\t\nvarying mediump vec4 v_color; \nvarying mediump vec2 v_texcoord;\t\nvoid main() \n{ \n     v_color \x3d a_color;//vec4(a_color.rgb * a_color.a, a_color.a); \n     v_texcoord \x3d a_texcoord; \n    gl_Position \x3d (CC_PMatrix * CC_MVMatrix) * a_position;  \n}";
cc.SHADER_POSITION_TEXTURE_FRAG = "precision lowp float;   \nvarying vec2 v_texCoord;  \nvoid main() \n{  \n    gl_FragColor \x3d  texture2D(CC_Texture0, v_texCoord);   \n}";
cc.SHADER_POSITION_TEXTURE_VERT = "attribute vec4 a_position; \nattribute vec2 a_texCoord; \nvarying mediump vec2 v_texCoord; \nvoid main() \n{ \n    gl_Position \x3d (CC_PMatrix * CC_MVMatrix) * a_position;  \n    v_texCoord \x3d a_texCoord;               \n}";
cc.SHADER_POSITION_TEXTURE_UCOLOR_FRAG = "precision lowp float;  \nuniform vec4 u_color; \nvarying vec2 v_texCoord; \nvoid main() \n{  \n    gl_FragColor \x3d  texture2D(CC_Texture0, v_texCoord) * u_color;    \n}";
cc.SHADER_POSITION_TEXTURE_UCOLOR_VERT = "attribute vec4 a_position;\nattribute vec2 a_texCoord; \nvarying mediump vec2 v_texCoord; \nvoid main() \n{ \n    gl_Position \x3d (CC_PMatrix * CC_MVMatrix) * a_position;  \n    v_texCoord \x3d a_texCoord;                 \n}";
cc.SHADER_POSITION_TEXTURE_A8COLOR_FRAG = "precision lowp float;  \nvarying vec4 v_fragmentColor; \nvarying vec2 v_texCoord; \nvoid main() \n{ \n    gl_FragColor \x3d vec4( v_fragmentColor.rgb,         \n        v_fragmentColor.a * texture2D(CC_Texture0, v_texCoord).a   \n    ); \n}";
cc.SHADER_POSITION_TEXTURE_A8COLOR_VERT = "attribute vec4 a_position; \nattribute vec2 a_texCoord; \nattribute vec4 a_color;  \nvarying lowp vec4 v_fragmentColor; \nvarying mediump vec2 v_texCoord; \nvoid main() \n{ \n    gl_Position \x3d (CC_PMatrix * CC_MVMatrix) * a_position;  \n    v_fragmentColor \x3d a_color; \n    v_texCoord \x3d a_texCoord; \n}";
cc.SHADER_POSITION_TEXTURE_COLOR_FRAG = "precision lowp float;\nvarying vec4 v_fragmentColor; \nvarying vec2 v_texCoord; \nvoid main() \n{ \n    gl_FragColor \x3d v_fragmentColor * texture2D(CC_Texture0, v_texCoord); \n}";
cc.SHADER_POSITION_TEXTURE_COLOR_VERT = "attribute vec4 a_position; \nattribute vec2 a_texCoord; \nattribute vec4 a_color;  \nvarying lowp vec4 v_fragmentColor; \nvarying mediump vec2 v_texCoord; \nvoid main() \n{ \n    gl_Position \x3d (CC_PMatrix * CC_MVMatrix) * a_position;  \n    v_fragmentColor \x3d a_color; \n    v_texCoord \x3d a_texCoord; \n}";
cc.SHADER_SPRITE_POSITION_TEXTURE_COLOR_VERT = "attribute vec4 a_position; \nattribute vec2 a_texCoord; \nattribute vec4 a_color;  \nvarying lowp vec4 v_fragmentColor; \nvarying mediump vec2 v_texCoord; \nvoid main() \n{ \n    gl_Position \x3d CC_PMatrix * a_position;  \n    v_fragmentColor \x3d a_color; \n    v_texCoord \x3d a_texCoord; \n}";
cc.SHADER_POSITION_TEXTURE_COLOR_ALPHATEST_FRAG = "precision lowp float;   \nvarying vec4 v_fragmentColor; \nvarying vec2 v_texCoord;   \nuniform float CC_alpha_value; \nvoid main() \n{  \n    vec4 texColor \x3d texture2D(CC_Texture0, v_texCoord);  \n    if ( texColor.a \x3c\x3d CC_alpha_value )          \n        discard; \n    gl_FragColor \x3d texColor * v_fragmentColor;  \n}";
cc.SHADEREX_SWITCHMASK_FRAG = "precision lowp float; \nvarying vec4 v_fragmentColor; \nvarying vec2 v_texCoord; \nuniform sampler2D u_texture;  \nuniform sampler2D   u_mask;   \nvoid main()  \n{  \n    vec4 texColor   \x3d texture2D(u_texture, v_texCoord);  \n    vec4 maskColor  \x3d texture2D(u_mask, v_texCoord); \n    vec4 finalColor \x3d vec4(texColor.r, texColor.g, texColor.b, maskColor.a * texColor.a);        \n    gl_FragColor    \x3d v_fragmentColor * finalColor; \n}";
cc.shaderCache = {
    TYPE_POSITION_TEXTURECOLOR: 0,
    TYPE_POSITION_TEXTURECOLOR_ALPHATEST: 1,
    TYPE_POSITION_COLOR: 2,
    TYPE_POSITION_TEXTURE: 3,
    TYPE_POSITION_TEXTURE_UCOLOR: 4,
    TYPE_POSITION_TEXTURE_A8COLOR: 5,
    TYPE_POSITION_UCOLOR: 6,
    TYPE_POSITION_LENGTH_TEXTURECOLOR: 7,
    TYPE_SPRITE_POSITION_TEXTURECOLOR: 8,
    TYPE_SPRITE_POSITION_TEXTURECOLOR_ALPHATEST: 9,
    TYPE_SPRITE_POSITION_COLOR: 10,
    TYPE_MAX: 10,
    _programs: {},
    _init: function () {
        this.loadDefaultShaders();
        return !0
    },
    _loadDefaultShader: function (c, d) {
        switch (d) {
            case this.TYPE_POSITION_TEXTURECOLOR:
                c.initWithVertexShaderByteArray(cc.SHADER_POSITION_TEXTURE_COLOR_VERT,
                    cc.SHADER_POSITION_TEXTURE_COLOR_FRAG);
                c.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
                c.addAttribute(cc.ATTRIBUTE_NAME_COLOR, cc.VERTEX_ATTRIB_COLOR);
                c.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
                break;
            case this.TYPE_SPRITE_POSITION_TEXTURECOLOR:
                c.initWithVertexShaderByteArray(cc.SHADER_SPRITE_POSITION_TEXTURE_COLOR_VERT, cc.SHADER_POSITION_TEXTURE_COLOR_FRAG);
                c.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
                c.addAttribute(cc.ATTRIBUTE_NAME_COLOR,
                    cc.VERTEX_ATTRIB_COLOR);
                c.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
                break;
            case this.TYPE_POSITION_TEXTURECOLOR_ALPHATEST:
                c.initWithVertexShaderByteArray(cc.SHADER_POSITION_TEXTURE_COLOR_VERT, cc.SHADER_POSITION_TEXTURE_COLOR_ALPHATEST_FRAG);
                c.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
                c.addAttribute(cc.ATTRIBUTE_NAME_COLOR, cc.VERTEX_ATTRIB_COLOR);
                c.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
                break;
            case this.TYPE_SPRITE_POSITION_TEXTURECOLOR_ALPHATEST:
                c.initWithVertexShaderByteArray(cc.SHADER_SPRITE_POSITION_TEXTURE_COLOR_VERT,
                    cc.SHADER_POSITION_TEXTURE_COLOR_ALPHATEST_FRAG);
                c.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
                c.addAttribute(cc.ATTRIBUTE_NAME_COLOR, cc.VERTEX_ATTRIB_COLOR);
                c.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
                break;
            case this.TYPE_POSITION_COLOR:
                c.initWithVertexShaderByteArray(cc.SHADER_POSITION_COLOR_VERT, cc.SHADER_POSITION_COLOR_FRAG);
                c.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
                c.addAttribute(cc.ATTRIBUTE_NAME_COLOR, cc.VERTEX_ATTRIB_COLOR);
                break;
            case this.TYPE_SPRITE_POSITION_COLOR:
                c.initWithVertexShaderByteArray(cc.SHADER_SPRITE_POSITION_COLOR_VERT, cc.SHADER_POSITION_COLOR_FRAG);
                c.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
                c.addAttribute(cc.ATTRIBUTE_NAME_COLOR, cc.VERTEX_ATTRIB_COLOR);
                break;
            case this.TYPE_POSITION_TEXTURE:
                c.initWithVertexShaderByteArray(cc.SHADER_POSITION_TEXTURE_VERT, cc.SHADER_POSITION_TEXTURE_FRAG);
                c.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
                c.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD,
                    cc.VERTEX_ATTRIB_TEX_COORDS);
                break;
            case this.TYPE_POSITION_TEXTURE_UCOLOR:
                c.initWithVertexShaderByteArray(cc.SHADER_POSITION_TEXTURE_UCOLOR_VERT, cc.SHADER_POSITION_TEXTURE_UCOLOR_FRAG);
                c.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
                c.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
                break;
            case this.TYPE_POSITION_TEXTURE_A8COLOR:
                c.initWithVertexShaderByteArray(cc.SHADER_POSITION_TEXTURE_A8COLOR_VERT, cc.SHADER_POSITION_TEXTURE_A8COLOR_FRAG);
                c.addAttribute(cc.ATTRIBUTE_NAME_POSITION,
                    cc.VERTEX_ATTRIB_POSITION);
                c.addAttribute(cc.ATTRIBUTE_NAME_COLOR, cc.VERTEX_ATTRIB_COLOR);
                c.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
                break;
            case this.TYPE_POSITION_UCOLOR:
                c.initWithVertexShaderByteArray(cc.SHADER_POSITION_UCOLOR_VERT, cc.SHADER_POSITION_UCOLOR_FRAG);
                c.addAttribute("aVertex", cc.VERTEX_ATTRIB_POSITION);
                break;
            case this.TYPE_POSITION_LENGTH_TEXTURECOLOR:
                c.initWithVertexShaderByteArray(cc.SHADER_POSITION_COLOR_LENGTH_TEXTURE_VERT, cc.SHADER_POSITION_COLOR_LENGTH_TEXTURE_FRAG);
                c.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
                c.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
                c.addAttribute(cc.ATTRIBUTE_NAME_COLOR, cc.VERTEX_ATTRIB_COLOR);
                break;
            default:
                cc.log("cocos2d: cc.shaderCache._loadDefaultShader, error shader type");
                return
        }
        c.link();
        c.updateUniforms()
    },
    loadDefaultShaders: function () {
        var c = new cc.GLProgram;
        this._loadDefaultShader(c, this.TYPE_POSITION_TEXTURECOLOR);
        this._programs[cc.SHADER_POSITION_TEXTURECOLOR] = c;
        this._programs.ShaderPositionTextureColor =
            c;
        c = new cc.GLProgram;
        this._loadDefaultShader(c, this.TYPE_SPRITE_POSITION_TEXTURECOLOR);
        this._programs[cc.SHADER_SPRITE_POSITION_TEXTURECOLOR] = c;
        this._programs.ShaderSpritePositionTextureColor = c;
        c = new cc.GLProgram;
        this._loadDefaultShader(c, this.TYPE_POSITION_TEXTURECOLOR_ALPHATEST);
        this._programs[cc.SHADER_POSITION_TEXTURECOLORALPHATEST] = c;
        this._programs.ShaderPositionTextureColorAlphaTest = c;
        c = new cc.GLProgram;
        this._loadDefaultShader(c, this.TYPE_SPRITE_POSITION_TEXTURECOLOR_ALPHATEST);
        this._programs[cc.SHADER_SPRITE_POSITION_TEXTURECOLORALPHATEST] =
            c;
        this._programs.ShaderSpritePositionTextureColorAlphaTest = c;
        c = new cc.GLProgram;
        this._loadDefaultShader(c, this.TYPE_POSITION_COLOR);
        this._programs[cc.SHADER_POSITION_COLOR] = c;
        this._programs.ShaderPositionColor = c;
        c = new cc.GLProgram;
        this._loadDefaultShader(c, this.TYPE_SPRITE_POSITION_COLOR);
        this._programs[cc.SHADER_SPRITE_POSITION_COLOR] = c;
        this._programs.ShaderSpritePositionColor = c;
        c = new cc.GLProgram;
        this._loadDefaultShader(c, this.TYPE_POSITION_TEXTURE);
        this._programs[cc.SHADER_POSITION_TEXTURE] = c;
        this._programs.ShaderPositionTexture = c;
        c = new cc.GLProgram;
        this._loadDefaultShader(c, this.TYPE_POSITION_TEXTURE_UCOLOR);
        this._programs[cc.SHADER_POSITION_TEXTURE_UCOLOR] = c;
        this._programs.ShaderPositionTextureUColor = c;
        c = new cc.GLProgram;
        this._loadDefaultShader(c, this.TYPE_POSITION_TEXTURE_A8COLOR);
        this._programs[cc.SHADER_POSITION_TEXTUREA8COLOR] = c;
        this._programs.ShaderPositionTextureA8Color = c;
        c = new cc.GLProgram;
        this._loadDefaultShader(c, this.TYPE_POSITION_UCOLOR);
        this._programs[cc.SHADER_POSITION_UCOLOR] =
            c;
        this._programs.ShaderPositionUColor = c;
        c = new cc.GLProgram;
        this._loadDefaultShader(c, this.TYPE_POSITION_LENGTH_TEXTURECOLOR);
        this._programs[cc.SHADER_POSITION_LENGTHTEXTURECOLOR] = c;
        this._programs.ShaderPositionLengthTextureColor = c
    },
    reloadDefaultShaders: function () {
        var c = this.programForKey(cc.SHADER_POSITION_TEXTURECOLOR);
        c.reset();
        this._loadDefaultShader(c, this.TYPE_POSITION_TEXTURECOLOR);
        c = this.programForKey(cc.SHADER_SPRITE_POSITION_TEXTURECOLOR);
        c.reset();
        this._loadDefaultShader(c, this.TYPE_SPRITE_POSITION_TEXTURECOLOR);
        c = this.programForKey(cc.SHADER_POSITION_TEXTURECOLORALPHATEST);
        c.reset();
        this._loadDefaultShader(c, this.TYPE_POSITION_TEXTURECOLOR_ALPHATEST);
        c = this.programForKey(cc.SHADER_SPRITE_POSITION_TEXTURECOLORALPHATEST);
        c.reset();
        this._loadDefaultShader(c, this.TYPE_SPRITE_POSITION_TEXTURECOLOR_ALPHATEST);
        c = this.programForKey(cc.SHADER_POSITION_COLOR);
        c.reset();
        this._loadDefaultShader(c, this.TYPE_POSITION_COLOR);
        c = this.programForKey(cc.SHADER_POSITION_TEXTURE);
        c.reset();
        this._loadDefaultShader(c, this.TYPE_POSITION_TEXTURE);
        c = this.programForKey(cc.SHADER_POSITION_TEXTURE_UCOLOR);
        c.reset();
        this._loadDefaultShader(c, this.TYPE_POSITION_TEXTURE_UCOLOR);
        c = this.programForKey(cc.SHADER_POSITION_TEXTUREA8COLOR);
        c.reset();
        this._loadDefaultShader(c, this.TYPE_POSITION_TEXTURE_A8COLOR);
        c = this.programForKey(cc.SHADER_POSITION_UCOLOR);
        c.reset();
        this._loadDefaultShader(c, this.TYPE_POSITION_UCOLOR)
    },
    programForKey: function (c) {
        return this._programs[c]
    },
    getProgram: function (c) {
        return this._programs[c]
    },
    addProgram: function (c, d) {
        this._programs[d] =
            c
    }
};
cc.GLProgram = cc.Class.extend({
    _glContext: null,
    _programObj: null,
    _vertShader: null,
    _fragShader: null,
    _uniforms: null,
    _hashForUniforms: null,
    _usesTime: !1,
    _updateUniformLocation: function (c) {
        if (!c)return !1;
        var d, e = this._hashForUniforms[c];
        if (e) {
            d = !1;
            for (var f = arguments.length - 1, g = 0; g < f; ++g)arguments[g + 1] !== e[g] && (e[g] = arguments[g + 1], d = !0)
        } else e = [arguments[1], arguments[2], arguments[3], arguments[4]], this._hashForUniforms[c] = e, d = !0;
        return d
    },
    _description: function () {
        return "\x3cCCGLProgram \x3d " + this.toString() +
            " | Program \x3d " + this._programObj.toString() + ", VertexShader \x3d " + this._vertShader.toString() + ", FragmentShader \x3d " + this._fragShader.toString() + "\x3e"
    },
    _compileShader: function (c, d, e) {
        if (!e || !c)return !1;
        e = (cc.GLProgram._isHighpSupported() ? "precision highp float;\n" : "precision mediump float;\n") + "uniform mat4 CC_PMatrix;         \nuniform mat4 CC_MVMatrix;        \nuniform mat4 CC_MVPMatrix;       \nuniform vec4 CC_Time;            \nuniform vec4 CC_SinTime;         \nuniform vec4 CC_CosTime;         \nuniform vec4 CC_Random01;        \nuniform sampler2D CC_Texture0;   \n//CC INCLUDES END                \n" +
            e;
        this._glContext.shaderSource(c, e);
        this._glContext.compileShader(c);
        e = this._glContext.getShaderParameter(c, this._glContext.COMPILE_STATUS);
        e || (cc.log("cocos2d: ERROR: Failed to compile shader:\n" + this._glContext.getShaderSource(c)), d === this._glContext.VERTEX_SHADER ? cc.log("cocos2d: \n" + this.vertexShaderLog()) : cc.log("cocos2d: \n" + this.fragmentShaderLog()));
        return !0 === e
    },
    ctor: function (c, d, e) {
        this._uniforms = {};
        this._hashForUniforms = {};
        this._glContext = e || cc._renderContext;
        c && d && this.init(c, d)
    },
    destroyProgram: function () {
        this._hashForUniforms =
            this._uniforms = this._fragShader = this._vertShader = null;
        this._glContext.deleteProgram(this._programObj)
    },
    initWithVertexShaderByteArray: function (c, d) {
        var e = this._glContext;
        this._programObj = e.createProgram();
        this._fragShader = this._vertShader = null;
        c && (this._vertShader = e.createShader(e.VERTEX_SHADER), this._compileShader(this._vertShader, e.VERTEX_SHADER, c) || cc.log("cocos2d: ERROR: Failed to compile vertex shader"));
        d && (this._fragShader = e.createShader(e.FRAGMENT_SHADER), this._compileShader(this._fragShader,
            e.FRAGMENT_SHADER, d) || cc.log("cocos2d: ERROR: Failed to compile fragment shader"));
        this._vertShader && e.attachShader(this._programObj, this._vertShader);
        cc.checkGLErrorDebug();
        this._fragShader && e.attachShader(this._programObj, this._fragShader);
        for (var f in this._hashForUniforms)delete this._hashForUniforms[f];
        cc.checkGLErrorDebug();
        return !0
    },
    initWithString: function (c, d) {
        return this.initWithVertexShaderByteArray(c, d)
    },
    initWithVertexShaderFilename: function (c, d) {
        var e = cc.loader.getRes(c);
        if (!e)throw Error("Please load the resource firset : " +
            c);
        var f = cc.loader.getRes(d);
        if (!f)throw Error("Please load the resource firset : " + d);
        return this.initWithVertexShaderByteArray(e, f)
    },
    init: function (c, d) {
        return this.initWithVertexShaderFilename(c, d)
    },
    addAttribute: function (c, d) {
        this._glContext.bindAttribLocation(this._programObj, d, c)
    },
    link: function () {
        if (!this._programObj)return cc.log("cc.GLProgram.link(): Cannot link invalid program"), !1;
        this._glContext.linkProgram(this._programObj);
        this._vertShader && this._glContext.deleteShader(this._vertShader);
        this._fragShader && this._glContext.deleteShader(this._fragShader);
        this._fragShader = this._vertShader = null;
        return cc.game.config[cc.game.CONFIG_KEY.debugMode] && !this._glContext.getProgramParameter(this._programObj, this._glContext.LINK_STATUS) ? (cc.log("cocos2d: ERROR: Failed to link program: " + this._glContext.getProgramInfoLog(this._programObj)), cc.glDeleteProgram(this._programObj), this._programObj = null, !1) : !0
    },
    use: function () {
        cc.glUseProgram(this._programObj)
    },
    updateUniforms: function () {
        this._uniforms[cc.UNIFORM_PMATRIX_S] =
            this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_PMATRIX_S);
        this._uniforms[cc.UNIFORM_MVMATRIX_S] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_MVMATRIX_S);
        this._uniforms[cc.UNIFORM_MVPMATRIX_S] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_MVPMATRIX_S);
        this._uniforms[cc.UNIFORM_TIME_S] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_TIME_S);
        this._uniforms[cc.UNIFORM_SINTIME_S] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_SINTIME_S);
        this._uniforms[cc.UNIFORM_COSTIME_S] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_COSTIME_S);
        this._usesTime = null != this._uniforms[cc.UNIFORM_TIME_S] || null != this._uniforms[cc.UNIFORM_SINTIME_S] || null != this._uniforms[cc.UNIFORM_COSTIME_S];
        this._uniforms[cc.UNIFORM_RANDOM01_S] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_RANDOM01_S);
        this._uniforms[cc.UNIFORM_SAMPLER_S] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_SAMPLER_S);
        this.use();
        this.setUniformLocationWith1i(this._uniforms[cc.UNIFORM_SAMPLER_S],
            0)
    },
    _addUniformLocation: function (c) {
        var d = this._glContext.getUniformLocation(this._programObj, c);
        this._uniforms[c] = d
    },
    getUniformLocationForName: function (c) {
        if (!c)throw Error("cc.GLProgram.getUniformLocationForName(): uniform name should be non-null");
        if (!this._programObj)throw Error("cc.GLProgram.getUniformLocationForName(): Invalid operation. Cannot get uniform location when program is not initialized");
        return this._uniforms[c] || this._glContext.getUniformLocation(this._programObj, c)
    },
    getUniformMVPMatrix: function () {
        return this._uniforms[cc.UNIFORM_MVPMATRIX_S]
    },
    getUniformSampler: function () {
        return this._uniforms[cc.UNIFORM_SAMPLER_S]
    },
    setUniformLocationWith1i: function (c, d) {
        var e = this._glContext;
        if ("string" === typeof c) {
            if (this._updateUniformLocation(c, d)) {
                var f = this.getUniformLocationForName(c);
                e.uniform1i(f, d)
            }
        } else e.uniform1i(c, d)
    },
    setUniformLocationWith2i: function (c, d, e) {
        var f = this._glContext;
        "string" === typeof c ? this._updateUniformLocation(c, d, e) && (c = this.getUniformLocationForName(c), f.uniform2i(c, d, e)) : f.uniform2i(c, d, e)
    },
    setUniformLocationWith3i: function (c,
                                        d, e, f) {
        var g = this._glContext;
        "string" === typeof c ? this._updateUniformLocation(c, d, e, f) && (c = this.getUniformLocationForName(c), g.uniform3i(c, d, e, f)) : g.uniform3i(c, d, e, f)
    },
    setUniformLocationWith4i: function (c, d, e, f, g) {
        var h = this._glContext;
        "string" === typeof c ? this._updateUniformLocation(c, d, e, f, g) && (c = this.getUniformLocationForName(c), h.uniform4i(c, d, e, f, g)) : h.uniform4i(c, d, e, f, g)
    },
    setUniformLocationWith2iv: function (c, d) {
        var e = "string" === typeof c ? this.getUniformLocationForName(c) : c;
        this._glContext.uniform2iv(e,
            d)
    },
    setUniformLocationWith3iv: function (c, d) {
        var e = "string" === typeof c ? this.getUniformLocationForName(c) : c;
        this._glContext.uniform3iv(e, d)
    },
    setUniformLocationWith4iv: function (c, d) {
        var e = "string" === typeof c ? this.getUniformLocationForName(c) : c;
        this._glContext.uniform4iv(e, d)
    },
    setUniformLocationI32: function (c, d) {
        this.setUniformLocationWith1i(c, d)
    },
    setUniformLocationWith1f: function (c, d) {
        var e = this._glContext;
        if ("string" === typeof c) {
            if (this._updateUniformLocation(c, d)) {
                var f = this.getUniformLocationForName(c);
                e.uniform1f(f, d)
            }
        } else e.uniform1f(c, d)
    },
    setUniformLocationWith2f: function (c, d, e) {
        var f = this._glContext;
        "string" === typeof c ? this._updateUniformLocation(c, d, e) && (c = this.getUniformLocationForName(c), f.uniform2f(c, d, e)) : f.uniform2f(c, d, e)
    },
    setUniformLocationWith3f: function (c, d, e, f) {
        var g = this._glContext;
        "string" === typeof c ? this._updateUniformLocation(c, d, e, f) && (c = this.getUniformLocationForName(c), g.uniform3f(c, d, e, f)) : g.uniform3f(c, d, e, f)
    },
    setUniformLocationWith4f: function (c, d, e, f, g) {
        var h = this._glContext;
        "string" === typeof c ? this._updateUniformLocation(c, d, e, f, g) && (c = this.getUniformLocationForName(c), h.uniform4f(c, d, e, f, g)) : h.uniform4f(c, d, e, f, g)
    },
    setUniformLocationWith2fv: function (c, d) {
        var e = "string" === typeof c ? this.getUniformLocationForName(c) : c;
        this._glContext.uniform2fv(e, d)
    },
    setUniformLocationWith3fv: function (c, d) {
        var e = "string" === typeof c ? this.getUniformLocationForName(c) : c;
        this._glContext.uniform3fv(e, d)
    },
    setUniformLocationWith4fv: function (c, d) {
        var e = "string" === typeof c ? this.getUniformLocationForName(c) :
            c;
        this._glContext.uniform4fv(e, d)
    },
    setUniformLocationWithMatrix4fv: function (c, d) {
        var e = "string" === typeof c ? this.getUniformLocationForName(c) : c;
        this._glContext.uniformMatrix4fv(e, !1, d)
    },
    setUniformLocationF32: function () {
        if (!(2 > arguments.length))switch (arguments.length) {
            case 2:
                this.setUniformLocationWith1f(arguments[0], arguments[1]);
                break;
            case 3:
                this.setUniformLocationWith2f(arguments[0], arguments[1], arguments[2]);
                break;
            case 4:
                this.setUniformLocationWith3f(arguments[0], arguments[1], arguments[2], arguments[3]);
                break;
            case 5:
                this.setUniformLocationWith4f(arguments[0], arguments[1], arguments[2], arguments[3], arguments[4])
        }
    },
    setUniformsForBuiltins: function () {
        var c = new cc.math.Matrix4, d = new cc.math.Matrix4, e = new cc.math.Matrix4;
        cc.kmGLGetMatrix(cc.KM_GL_PROJECTION, c);
        cc.kmGLGetMatrix(cc.KM_GL_MODELVIEW, d);
        cc.kmMat4Multiply(e, c, d);
        this.setUniformLocationWithMatrix4fv(this._uniforms[cc.UNIFORM_PMATRIX_S], c.mat, 1);
        this.setUniformLocationWithMatrix4fv(this._uniforms[cc.UNIFORM_MVMATRIX_S], d.mat, 1);
        this.setUniformLocationWithMatrix4fv(this._uniforms[cc.UNIFORM_MVPMATRIX_S],
            e.mat, 1);
        this._usesTime && (c = cc.director, c = c.getTotalFrames() * c.getAnimationInterval(), this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_TIME_S], c / 10, c, 2 * c, 4 * c), this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_SINTIME_S], c / 8, c / 4, c / 2, Math.sin(c)), this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_COSTIME_S], c / 8, c / 4, c / 2, Math.cos(c)));
        -1 !== this._uniforms[cc.UNIFORM_RANDOM01_S] && this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_RANDOM01_S], Math.random(), Math.random(), Math.random(),
            Math.random())
    },
    _setUniformsForBuiltinsForRenderer: function (c) {
        if (c && c._renderCmd) {
            var d = new cc.math.Matrix4, e = new cc.math.Matrix4;
            cc.kmGLGetMatrix(cc.KM_GL_PROJECTION, d);
            cc.kmMat4Multiply(e, d, c._renderCmd._stackMatrix);
            this.setUniformLocationWithMatrix4fv(this._uniforms[cc.UNIFORM_PMATRIX_S], d.mat, 1);
            this.setUniformLocationWithMatrix4fv(this._uniforms[cc.UNIFORM_MVMATRIX_S], c._renderCmd._stackMatrix.mat, 1);
            this.setUniformLocationWithMatrix4fv(this._uniforms[cc.UNIFORM_MVPMATRIX_S], e.mat, 1);
            this._usesTime &&
            (c = cc.director, c = c.getTotalFrames() * c.getAnimationInterval(), this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_TIME_S], c / 10, c, 2 * c, 4 * c), this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_SINTIME_S], c / 8, c / 4, c / 2, Math.sin(c)), this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_COSTIME_S], c / 8, c / 4, c / 2, Math.cos(c)));
            -1 !== this._uniforms[cc.UNIFORM_RANDOM01_S] && this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_RANDOM01_S], Math.random(), Math.random(), Math.random(), Math.random())
        }
    },
    setUniformForModelViewProjectionMatrix: function () {
        this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_MVPMATRIX_S],
            !1, cc.getMat4MultiplyValue(cc.projection_matrix_stack.top, cc.modelview_matrix_stack.top))
    },
    setUniformForModelViewProjectionMatrixWithMat4: function (c) {
        cc.kmMat4Multiply(c, cc.projection_matrix_stack.top, cc.modelview_matrix_stack.top);
        this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_MVPMATRIX_S], !1, c.mat)
    },
    setUniformForModelViewAndProjectionMatrixWithMat4: function () {
        this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_MVMATRIX_S], !1, cc.modelview_matrix_stack.top.mat);
        this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_PMATRIX_S],
            !1, cc.projection_matrix_stack.top.mat)
    },
    _setUniformForMVPMatrixWithMat4: function (c) {
        if (!c)throw Error("modelView matrix is undefined.");
        this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_MVMATRIX_S], !1, c.mat);
        this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_PMATRIX_S], !1, cc.projection_matrix_stack.top.mat)
    },
    _updateProjectionUniform: function () {
        this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_PMATRIX_S], !1, cc.projection_matrix_stack.top.mat)
    },
    vertexShaderLog: function () {
        return this._glContext.getShaderInfoLog(this._vertShader)
    },
    getVertexShaderLog: function () {
        return this._glContext.getShaderInfoLog(this._vertShader)
    },
    getFragmentShaderLog: function () {
        return this._glContext.getShaderInfoLog(this._vertShader)
    },
    fragmentShaderLog: function () {
        return this._glContext.getShaderInfoLog(this._fragShader)
    },
    programLog: function () {
        return this._glContext.getProgramInfoLog(this._programObj)
    },
    getProgramLog: function () {
        return this._glContext.getProgramInfoLog(this._programObj)
    },
    reset: function () {
        this._fragShader = this._vertShader = null;
        this._uniforms.length =
            0;
        this._glContext.deleteProgram(this._programObj);
        this._programObj = null;
        for (var c in this._hashForUniforms)this._hashForUniforms[c].length = 0, delete this._hashForUniforms[c]
    },
    getProgram: function () {
        return this._programObj
    },
    retain: function () {
    },
    release: function () {
    }
});
cc.GLProgram.create = function (c, d) {
    return new cc.GLProgram(c, d)
};
cc.GLProgram._highpSupported = null;
cc.GLProgram._isHighpSupported = function () {
    if (null == cc.GLProgram._highpSupported) {
        var c = cc._renderContext, c = c.getShaderPrecisionFormat(c.FRAGMENT_SHADER, c.HIGH_FLOAT);
        cc.GLProgram._highpSupported = 0 !== c.precision
    }
    return cc.GLProgram._highpSupported
};
cc.setProgram = function (c, d) {
    c.shaderProgram = d;
    var e = c.children;
    if (e)for (var f = 0; f < e.length; f++)cc.setProgram(e[f], d)
};
cc._currentProjectionMatrix = -1;
if (cc.ENABLE_GL_STATE_CACHE) {
    cc.MAX_ACTIVETEXTURE = 16;
    cc._currentShaderProgram = -1;
    cc._currentBoundTexture = [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1];
    cc._blendingSource = -1;
    cc._blendingDest = -1;
    cc._GLServerState = 0;
    cc.TEXTURE_ATLAS_USE_VAO && (cc._uVAO = 0);
    var _currBuffers = {};
    WebGLRenderingContext.prototype.glBindBuffer = WebGLRenderingContext.prototype.bindBuffer;
    WebGLRenderingContext.prototype.bindBuffer = function (c, d) {
        return _currBuffers[c] !== d ? (this.glBindBuffer(c, d), _currBuffers[c] = d, !1) : !0
    };
    WebGLRenderingContext.prototype.glEnableVertexAttribArray =
        WebGLRenderingContext.prototype.enableVertexAttribArray;
    WebGLRenderingContext.prototype.enableVertexAttribArray = function (c) {
        c === cc.VERTEX_ATTRIB_FLAG_POSITION ? this._vertexAttribPosition || (this.glEnableVertexAttribArray(c), this._vertexAttribPosition = !0) : c === cc.VERTEX_ATTRIB_FLAG_COLOR ? this._vertexAttribColor || (this.glEnableVertexAttribArray(c), this._vertexAttribColor = !0) : c === cc.VERTEX_ATTRIB_FLAG_TEX_COORDS ? this._vertexAttribTexCoords || (this.glEnableVertexAttribArray(c), this._vertexAttribTexCoords = !0) : this.glEnableVertexAttribArray(c)
    };
    WebGLRenderingContext.prototype.glDisableVertexAttribArray = WebGLRenderingContext.prototype.disableVertexAttribArray;
    WebGLRenderingContext.prototype.disableVertexAttribArray = function (c) {
        c === cc.VERTEX_ATTRIB_FLAG_COLOR ? this._vertexAttribColor && (this.glDisableVertexAttribArray(c), this._vertexAttribColor = !1) : c === cc.VERTEX_ATTRIB_FLAG_TEX_COORDS ? this._vertexAttribTexCoords && (this.glDisableVertexAttribArray(c), this._vertexAttribTexCoords = !1) : 0 !== c && this.glDisableVertexAttribArray(c)
    }
}
cc.glInvalidateStateCache = function () {
    cc.kmGLFreeAll();
    cc._currentProjectionMatrix = -1;
    if (cc.ENABLE_GL_STATE_CACHE) {
        cc._currentShaderProgram = -1;
        for (var c = 0; c < cc.MAX_ACTIVETEXTURE; c++)cc._currentBoundTexture[c] = -1;
        cc._blendingSource = -1;
        cc._blendingDest = -1;
        cc._GLServerState = 0
    }
};
cc.glUseProgram = cc.ENABLE_GL_STATE_CACHE ? function (c) {
    c !== cc._currentShaderProgram && (cc._currentShaderProgram = c, cc._renderContext.useProgram(c))
} : function (c) {
    cc._renderContext.useProgram(c)
};
cc.glDeleteProgram = function (c) {
    cc.ENABLE_GL_STATE_CACHE && c === cc._currentShaderProgram && (cc._currentShaderProgram = -1);
    gl.deleteProgram(c)
};
cc.setBlending = function (c, d) {
    var e = cc._renderContext;
    c === e.ONE && d === e.ZERO ? e.disable(e.BLEND) : (e.enable(e.BLEND), cc._renderContext.blendFunc(c, d))
};
cc.glBlendFunc = cc.ENABLE_GL_STATE_CACHE ? function (c, d) {
    if (c !== cc._blendingSource || d !== cc._blendingDest)cc._blendingSource = c, cc._blendingDest = d, cc.setBlending(c, d)
} : cc.setBlending;
cc.glBlendFuncForParticle = function (c, d) {
    if (c !== cc._blendingSource || d !== cc._blendingDest) {
        cc._blendingSource = c;
        cc._blendingDest = d;
        var e = cc._renderContext;
        c === e.ONE && d === e.ZERO ? e.disable(e.BLEND) : (e.enable(e.BLEND), e.blendFuncSeparate(e.SRC_ALPHA, d, c, d))
    }
};
cc.glBlendResetToCache = function () {
    var c = cc._renderContext;
    c.blendEquation(c.FUNC_ADD);
    cc.ENABLE_GL_STATE_CACHE ? cc.setBlending(cc._blendingSource, cc._blendingDest) : cc.setBlending(c.BLEND_SRC, c.BLEND_DST)
};
cc.setProjectionMatrixDirty = function () {
    cc._currentProjectionMatrix = -1
};
cc.glBindTexture2D = function (c) {
    cc.glBindTexture2DN(0, c)
};
cc.glBindTexture2DN = cc.ENABLE_GL_STATE_CACHE ? function (c, d) {
    if (cc._currentBoundTexture[c] !== d) {
        cc._currentBoundTexture[c] = d;
        var e = cc._renderContext;
        e.activeTexture(e.TEXTURE0 + c);
        d ? e.bindTexture(e.TEXTURE_2D, d._webTextureObj) : e.bindTexture(e.TEXTURE_2D, null)
    }
} : function (c, d) {
    var e = cc._renderContext;
    e.activeTexture(e.TEXTURE0 + c);
    d ? e.bindTexture(e.TEXTURE_2D, d._webTextureObj) : e.bindTexture(e.TEXTURE_2D, null)
};
cc.glDeleteTexture = function (c) {
    cc.glDeleteTextureN(0, c)
};
cc.glDeleteTextureN = function (c, d) {
    cc.ENABLE_GL_STATE_CACHE && d === cc._currentBoundTexture[c] && (cc._currentBoundTexture[c] = -1);
    cc._renderContext.deleteTexture(d._webTextureObj)
};
cc.glBindVAO = function (c) {
    cc.TEXTURE_ATLAS_USE_VAO && cc.ENABLE_GL_STATE_CACHE && cc._uVAO !== c && (cc._uVAO = c)
};
cc.glEnable = function (c) {
};
cc.LabelAtlas = cc.AtlasNode.extend({
    _string: null, _mapStartChar: null, _textureLoaded: !1, _className: "LabelAtlas", ctor: function (c, d, e, f, g) {
        cc.AtlasNode.prototype.ctor.call(this);
        this._renderCmd.setCascade();
        d && cc.LabelAtlas.prototype.initWithString.call(this, c, d, e, f, g)
    }, _createRenderCmd: function () {
        return cc._renderType === cc.game.RENDER_TYPE_WEBGL ? new cc.LabelAtlas.WebGLRenderCmd(this) : new cc.LabelAtlas.CanvasRenderCmd(this)
    }, textureLoaded: function () {
        return this._textureLoaded
    }, addLoadedEventListener: function (c,
                                         d) {
        this.addEventListener("load", c, d)
    }, initWithString: function (c, d, e, f, g) {
        var h = c + "", k, m;
        if (void 0 === e) {
            e = cc.loader.getRes(d);
            if (1 !== parseInt(e.version, 10))return cc.log("cc.LabelAtlas.initWithString(): Unsupported version. Upgrade cocos2d version"), !1;
            d = cc.path.changeBasename(d, e.textureFilename);
            f = cc.contentScaleFactor();
            k = parseInt(e.itemWidth, 10) / f;
            m = parseInt(e.itemHeight, 10) / f;
            e = String.fromCharCode(parseInt(e.firstChar, 10))
        } else k = e || 0, m = f || 0, e = g || " ";
        var n = null, n = d instanceof cc.Texture2D ? d : cc.textureCache.addImage(d);
        this._textureLoaded = d = n.isLoaded();
        d || (this._string = h, n.addEventListener("load", function (c) {
            this.initWithTexture(n, k, m, h.length);
            this.string = this._string;
            this.setColor(this._renderCmd._displayedColor);
            this.dispatchEvent("load")
        }, this));
        return this.initWithTexture(n, k, m, h.length) ? (this._mapStartChar = e, this.string = h, !0) : !1
    }, setColor: function (c) {
        cc.AtlasNode.prototype.setColor.call(this, c);
        this._renderCmd.updateAtlasValues()
    }, getString: function () {
        return this._string
    }, addChild: function (c, d, e) {
        this._renderCmd._addChild(c);
        cc.Node.prototype.addChild.call(this, c, d, e)
    }, updateAtlasValues: function () {
        this._renderCmd.updateAtlasValues()
    }, setString: function (c) {
        c = String(c);
        var d = c.length;
        this._string = c;
        this.setContentSize(d * this._itemWidth, this._itemHeight);
        this._renderCmd.setString(c);
        this._renderCmd.updateAtlasValues();
        this.quadsToDraw = d
    }
});
(function () {
    var c = cc.LabelAtlas.prototype;
    cc.defineGetterSetter(c, "opacity", c.getOpacity, c.setOpacity);
    cc.defineGetterSetter(c, "color", c.getColor, c.setColor);
    cc.defineGetterSetter(c, "string", c.getString, c.setString)
})();
cc.LabelAtlas.create = function (c, d, e, f, g) {
    return new cc.LabelAtlas(c, d, e, f, g)
};
(function () {
    cc.LabelAtlas.CanvasRenderCmd = function (c) {
        cc.AtlasNode.CanvasRenderCmd.call(this, c);
        this._needDraw = !1
    };
    var c = cc.LabelAtlas.CanvasRenderCmd.prototype = Object.create(cc.AtlasNode.CanvasRenderCmd.prototype);
    c.constructor = cc.LabelAtlas.CanvasRenderCmd;
    c.setCascade = function () {
        var c = this._node;
        c._cascadeOpacityEnabled = !0;
        c._cascadeColorEnabled = !1
    };
    c.updateAtlasValues = function () {
        for (var c = this._node, e = c._string || "", f = e.length, g = this._textureToRender, h = c._itemWidth, k = c._itemHeight, m = 0, n = -1; m < f; m++) {
            var p =
                e.charCodeAt(m) - c._mapStartChar.charCodeAt(0), r = parseInt(p % c._itemsPerRow, 10), p = parseInt(p / c._itemsPerRow, 10);
            if (!(0 > r || 0 > p || (r = cc.rect(r * h, p * k, h, k), p = g._contentSize, 0 > r.x || 0 > r.y || r.x + r.width > p.width || r.y + r.height > p.height))) {
                n++;
                var p = e.charCodeAt(m), s = c.getChildByTag(m);
                s ? 32 === p ? (s.init(), s.setTextureRect(cc.rect(0, 0, 10, 10), !1, cc.size(0, 0))) : (s.initWithTexture(g, r), s.visible = !0) : (s = new cc.Sprite, 32 === p ? (s.init(), s.setTextureRect(cc.rect(0, 0, 10, 10), !1, cc.size(0, 0))) : s.initWithTexture(g, r), cc.Node.prototype.addChild.call(c,
                    s, 0, m));
                s.setPosition(n * h + h / 2, k / 2)
            }
        }
        this.updateContentSize(m, n + 1)
    };
    c.updateContentSize = function (c, e) {
        var f = this._node, g = f._contentSize;
        c !== e && c * f._itemWidth === g.width && f._itemHeight === g.height && f.setContentSize(e * f._itemWidth, f._itemHeight)
    };
    c.setString = function (c) {
        c = this._node;
        if (c._children) {
            c = c._children;
            for (var e = c.length, f = 0; f < e; f++) {
                var g = c[f];
                g && !g._lateChild && (g.visible = !1)
            }
        }
    };
    c._addChild = function () {
        child._lateChild = !0
    }
})();
(function () {
    cc.LabelAtlas.WebGLRenderCmd = function (c) {
        cc.AtlasNode.WebGLRenderCmd.call(this, c);
        this._needDraw = !0
    };
    var c = cc.LabelAtlas.WebGLRenderCmd.prototype = Object.create(cc.AtlasNode.WebGLRenderCmd.prototype);
    c.constructor = cc.LabelAtlas.WebGLRenderCmd;
    c._updateColor = function () {
        if (this._colorF32Array) {
            var c = this._displayedColor, e = this._displayedOpacity / 255;
            this._node._opacityModifyRGB ? (this._colorF32Array[0] = c.r * e / 255, this._colorF32Array[1] = c.g * e / 255, this._colorF32Array[2] = c.b * e / 255) : (this._colorF32Array[0] =
                c.r / 255, this._colorF32Array[1] = c.g / 255, this._colorF32Array[2] = c.b / 255);
            this._colorF32Array[3] = e
        }
    };
    c.setCascade = function () {
        var c = this._node;
        c._cascadeOpacityEnabled = !0;
        c._cascadeColorEnabled = !0
    };
    c.rendering = function (c) {
        cc.AtlasNode.WebGLRenderCmd.prototype.rendering.call(this, c);
        if (cc.LABELATLAS_DEBUG_DRAW) {
            var e = this._node;
            c = e.getContentSize();
            var e = e.getBoundingBoxToWorld(), f = e.x, g = e.y;
            c.width = e.width;
            c.height = e.height;
            c = [cc.p(f, g), cc.p(f + c.width, g), cc.p(c.width + f, c.height + g), cc.p(f, g + c.height)];
            cc._drawingUtil.drawPoly(c, 4, !0)
        }
    };
    c.updateAtlasValues = function () {
        var c = this._node, e = c._string, f = e.length, g = this._textureAtlas, h = g.texture, k = h.pixelsWidth, h = h.pixelsHeight, m = c._itemWidth, n = c._itemHeight;
        c._ignoreContentScaleFactor || (m = c._itemWidth * cc.contentScaleFactor(), n = c._itemHeight * cc.contentScaleFactor());
        f > g.getCapacity() && cc.log("cc.LabelAtlas._updateAtlasValues(): Invalid String length");
        for (var p = g.quads, r = c._itemWidth, s = c._itemHeight, v = 0, t = -1; v < f; v++) {
            var w = e.charCodeAt(v) - c._mapStartChar.charCodeAt(0),
                u = w % c._itemsPerRow, A = 0 | w / c._itemsPerRow;
            if (!(0 > u || 0 > A || u * r + r > k || A * s + s > h)) {
                t++;
                var x;
                cc.FIX_ARTIFACTS_BY_STRECHING_TEXEL ? (u = (2 * u * m + 1) / (2 * k), w = u + (2 * m - 2) / (2 * k), A = (2 * A * n + 1) / (2 * h), x = A + (2 * n - 2) / (2 * h)) : (u = u * m / k, w = u + m / k, A = A * n / h, x = A + n / h);
                var B = p[v], F = B.tl, z = B.tr, y = B.bl, B = B.br;
                F.texCoords.u = u;
                F.texCoords.v = A;
                z.texCoords.u = w;
                z.texCoords.v = A;
                y.texCoords.u = u;
                y.texCoords.v = x;
                B.texCoords.u = w;
                B.texCoords.v = x;
                y.vertices.x = t * r;
                y.vertices.y = 0;
                y.vertices.z = 0;
                B.vertices.x = t * r + r;
                B.vertices.y = 0;
                B.vertices.z = 0;
                F.vertices.x =
                    t * r;
                F.vertices.y = c._itemHeight;
                F.vertices.z = 0;
                z.vertices.x = t * r + r;
                z.vertices.y = c._itemHeight;
                z.vertices.z = 0
            }
        }
        this._updateColor();
        this.updateContentSize(v, t + 1);
        0 < f && (g.dirty = !0, c = g.totalQuads, f > c && g.increaseTotalQuadsWith(f - c))
    };
    c.updateContentSize = function (c, e) {
        var f = this._node, g = f._contentSize;
        c !== e && c * f._itemWidth === g.width && f._itemHeight === g.height && f.setContentSize(e * f._itemWidth, f._itemHeight)
    };
    c.setString = function (c) {
        c = c.length;
        c > this._textureAtlas.totalQuads && this._textureAtlas.resizeCapacity(c)
    };
    c._addChild = function () {
    }
})();
cc.LabelBMFont = cc.SpriteBatchNode.extend({
    _opacityModifyRGB: !1,
    _string: "",
    _config: null,
    _fntFile: "",
    _initialString: "",
    _alignment: cc.TEXT_ALIGNMENT_CENTER,
    _width: -1,
    _lineBreakWithoutSpaces: !1,
    _imageOffset: null,
    _textureLoaded: !1,
    _className: "LabelBMFont",
    _createRenderCmd: function () {
        return cc._renderType === cc.game.RENDER_TYPE_WEBGL ? new cc.LabelBMFont.WebGLRenderCmd(this) : new cc.LabelBMFont.CanvasRenderCmd(this)
    },
    _setString: function (c, d) {
        d ? this._initialString = c : this._string = c;
        var e = this._children;
        if (e)for (var f =
            0; f < e.length; f++) {
            var g = e[f];
            g && g.setVisible(!1)
        }
        this._textureLoaded && (this.createFontChars(), d && this.updateLabel())
    },
    ctor: function (c, d, e, f, g) {
        cc.SpriteBatchNode.prototype.ctor.call(this);
        this._imageOffset = cc.p(0, 0);
        this._cascadeOpacityEnabled = this._cascadeColorEnabled = !0;
        this.initWithString(c, d, e, f, g)
    },
    textureLoaded: function () {
        return this._textureLoaded
    },
    addLoadedEventListener: function (c, d) {
        this.addEventListener("load", c, d)
    },
    isOpacityModifyRGB: function () {
        return this._opacityModifyRGB
    },
    setOpacityModifyRGB: function (c) {
        this._opacityModifyRGB =
            c;
        if (c = this._children)for (var d = 0; d < c.length; d++) {
            var e = c[d];
            e && (e.opacityModifyRGB = this._opacityModifyRGB)
        }
    },
    _changeTextureColor: function () {
        this._renderCmd._changeTextureColor()
    },
    init: function () {
        return this.initWithString(null, null, null, null, null)
    },
    initWithString: function (c, d, e, f, g) {
        c = c || "";
        this._config && cc.log("cc.LabelBMFont.initWithString(): re-init is no longer supported");
        if (d) {
            var h = cc.loader.getRes(d);
            if (!h)return cc.log("cc.LabelBMFont.initWithString(): Impossible to create font. Please check file"),
                !1;
            this._config = h;
            this._fntFile = d;
            d = cc.textureCache.addImage(h.atlasName);
            (this._textureLoaded = h = d.isLoaded()) || d.addEventListener("load", function (c) {
                this._textureLoaded = !0;
                this.initWithTexture(c, this._initialString.length);
                this.setString(this._initialString, !0);
                this.dispatchEvent("load")
            }, this)
        } else d = new cc.Texture2D, h = new Image, d.initWithElement(h), this._textureLoaded = !1;
        return this.initWithTexture(d, c.length) ? (this._alignment = f || cc.TEXT_ALIGNMENT_LEFT, this._imageOffset = g || cc.p(0, 0), this._width =
            void 0 === e ? -1 : e, this._realOpacity = 255, this._realColor = cc.color(255, 255, 255, 255), this._contentSize.width = 0, this._contentSize.height = 0, this.setAnchorPoint(0.5, 0.5), this.setString(c, !0), !0) : !1
    },
    createFontChars: function () {
        var c = this._renderCmd, d = c._texture || this._texture, e = 0, f = cc.size(0, 0), g = 0, h = 1, k = this._string, m = k ? k.length : 0;
        if (0 !== m) {
            var n, p = this._config, r = p.kerningDict, s = p.commonHeight, v = p.fontDefDictionary;
            for (n = 0; n < m - 1; n++)10 === k.charCodeAt(n) && h++;
            var t = s * h, h = -(s - s * h), w = -1, u;
            for (n = 0; n < m; n++)if (s =
                    k.charCodeAt(n), 0 !== s)if (10 === s)e = 0, h -= p.commonHeight; else {
                w = r[w << 16 | s & 65535] || 0;
                u = v[s];
                u || (cc.log("cocos2d: LabelBMFont: character not found " + k[n]), u = {
                    rect: {
                        x: 0,
                        y: 0,
                        width: 0,
                        height: 0
                    }, xOffset: 0, yOffset: 0, xAdvance: 0
                });
                var A = cc.rect(u.rect.x, u.rect.y, u.rect.width, u.rect.height), A = cc.rectPixelsToPoints(A);
                A.x += this._imageOffset.x;
                A.y += this._imageOffset.y;
                var x = this.getChildByTag(n);
                x ? c._updateCharTexture(x, A, s) : (x = new cc.Sprite, x.initWithTexture(d, A, !1), x._newTextureWhenChangeColor = !0, this.addChild(x,
                    0, n));
                x.opacityModifyRGB = this._opacityModifyRGB;
                c._updateCharColorAndOpacity(x);
                A = cc.p(e + u.xOffset + 0.5 * u.rect.width + w, h + (p.commonHeight - u.yOffset) - 0.5 * A.height * cc.contentScaleFactor());
                x.setPosition(cc.pointPixelsToPoints(A));
                e += u.xAdvance + w;
                w = s;
                g < e && (g = e)
            }
            f.width = u && u.xAdvance < u.rect.width ? g - u.xAdvance + u.rect.width : g;
            f.height = t;
            this.setContentSize(cc.sizePixelsToPoints(f))
        }
    },
    updateString: function (c) {
        var d = this._children;
        if (d)for (var e = 0, f = d.length; e < f; e++) {
            var g = d[e];
            g && (g.visible = !1)
        }
        this._config &&
        this.createFontChars();
        c || this.updateLabel()
    },
    getString: function () {
        return this._initialString
    },
    setString: function (c, d) {
        c = String(c);
        null == d && (d = !0);
        null != c && cc.isString(c) || (c += "");
        this._initialString = c;
        this._setString(c, d)
    },
    _setStringForSetter: function (c) {
        this.setString(c, !1)
    },
    setCString: function (c) {
        this.setString(c, !0)
    },
    _getCharsWidth: function (c, d) {
        if (0 >= d)return 0;
        var e = this.getChildByTag(c), f = this.getChildByTag(c + d);
        return this._getLetterPosXLeft(f) - this._getLetterPosXLeft(e)
    },
    _checkWarp: function (c,
                          d, e, f) {
        for (var g = c[d], h = 0, k = 0; k < d; k++)h += c[k].length;
        var h = h + d - f, m = this._getCharsWidth(h, c[d].length - 1);
        if (m > e && 1 < g.length) {
            f = e / m * g.length | 0;
            for (var k = g.substr(f), n = m - this._getCharsWidth(h + f, k.length - 1), p, r = 0, s = 0; n > e && 100 > s++;)f *= e / n, f |= 0, k = g.substr(f), n = m - this._getCharsWidth(h + f, k.length - 1);
            for (s = 0; n < e && 100 > s++;)k && (r = (p = cc.LabelTTF._wordRex.exec(k)) ? p[0].length : 1, p = k), this._lineBreakWithoutSpaces && (r = 0), f += r, k = g.substr(f), n = m - this._getCharsWidth(h + f, k.length - 1);
            f -= r;
            0 === f && (f = 1, p = p.substr(1));
            e =
                g.substr(0, f);
            cc.LabelTTF.wrapInspection && cc.LabelTTF._symbolRex.test(p || k) && (r = (h = cc.LabelTTF._lastWordRex.exec(e)) ? h[0].length : 0, this._lineBreakWithoutSpaces && (r = 0), f -= r, p = g.substr(f), e = g.substr(0, f));
            cc.LabelTTF._firsrEnglish.test(p) && (h = cc.LabelTTF._lastEnglish.exec(e)) && e !== h[0] && (r = h[0].length, this._lineBreakWithoutSpaces && (r = 0), f -= r, p = g.substr(f), e = g.substr(0, f));
            c[d] = p || k;
            c.splice(d, 0, e)
        }
    },
    updateLabel: function () {
        this.string = this._initialString;
        var c, d, e;
        if (0 < this._width) {
            var f = this.string.split("\n"),
                g = "", h = 0, k = 0;
            for (c = 0; c < f.length; c++)k = f.length, this._checkWarp(f, c, this._width * this._scaleX, h), k < f.length && h++, 0 < c && (g += "\n"), g += f[c];
            g += String.fromCharCode(0);
            this._setString(g, !1)
        }
        if (this._alignment !== cc.TEXT_ALIGNMENT_LEFT)for (f = c = 0, g = this._string.length, h = [], k = 0; k < g; k++)if (10 === this._string[k].charCodeAt(0) || 0 === this._string[k].charCodeAt(0)) {
            d = 0;
            var m = h.length;
            if (0 === m)f++; else if (e = c + m - 1 + f, !(0 > e)) {
                var n = this.getChildByTag(e);
                if (null != n) {
                    d = n.getPositionX() + n._getWidth() / 2;
                    n = 0;
                    switch (this._alignment) {
                        case cc.TEXT_ALIGNMENT_CENTER:
                            n =
                                this.width / 2 - d / 2;
                            break;
                        case cc.TEXT_ALIGNMENT_RIGHT:
                            n = this.width - d
                    }
                    if (0 !== n)for (d = 0; d < m; d++)e = c + d + f, 0 > e || (e = this.getChildByTag(e)) && (e.x += n);
                    c += m;
                    f++;
                    h.length = 0
                }
            }
        } else h.push(this._string[c])
    },
    setAlignment: function (c) {
        this._alignment = c;
        this.updateLabel()
    },
    _getAlignment: function () {
        return this._alignment
    },
    setBoundingWidth: function (c) {
        this._width = c;
        this.updateLabel()
    },
    _getBoundingWidth: function () {
        return this._width
    },
    setLineBreakWithoutSpace: function (c) {
        this._lineBreakWithoutSpaces = c;
        this.updateLabel()
    },
    setScale: function (c, d) {
        cc.Node.prototype.setScale.call(this, c, d);
        this.updateLabel()
    },
    setScaleX: function (c) {
        cc.Node.prototype.setScaleX.call(this, c);
        this.updateLabel()
    },
    setScaleY: function (c) {
        cc.Node.prototype.setScaleY.call(this, c);
        this.updateLabel()
    },
    setFntFile: function (c) {
        if (null != c && c !== this._fntFile) {
            var d = cc.loader.getRes(c);
            d ? (this._fntFile = c, this._config = d, c = cc.textureCache.addImage(d.atlasName), (this._textureLoaded = d = c.isLoaded()) ? (this.setTexture(c), this.createFontChars()) : c.addEventListener("load",
                function (c) {
                    this._textureLoaded = !0;
                    this.setTexture(c);
                    this.createFontChars();
                    this._changeTextureColor();
                    this.updateLabel();
                    this.dispatchEvent("load")
                }, this)) : cc.log("cc.LabelBMFont.setFntFile() : Impossible to create font. Please check file")
        }
    },
    getFntFile: function () {
        return this._fntFile
    },
    setTexture: function (c) {
        this._texture = c;
        this._renderCmd.setTexture(c)
    },
    setAnchorPoint: function (c, d) {
        cc.Node.prototype.setAnchorPoint.call(this, c, d);
        this.updateLabel()
    },
    _setAnchorX: function (c) {
        cc.Node.prototype._setAnchorX.call(this,
            c);
        this.updateLabel()
    },
    _setAnchorY: function (c) {
        cc.Node.prototype._setAnchorY.call(this, c);
        this.updateLabel()
    },
    _atlasNameFromFntFile: function (c) {
    },
    _kerningAmountForFirst: function (c, d) {
        var e = 0;
        if (this._configuration.kerningDictionary) {
            var f = this._configuration.kerningDictionary[(c << 16 | d & 65535).toString()];
            f && (e = f.amount)
        }
        return e
    },
    _getLetterPosXLeft: function (c) {
        return c.getPositionX() * this._scaleX - c._getWidth() * this._scaleX * c._getAnchorX()
    },
    _getLetterPosXRight: function (c) {
        return c.getPositionX() * this._scaleX +
            c._getWidth() * this._scaleX * c._getAnchorX()
    },
    _isspace_unicode: function (c) {
        c = c.charCodeAt(0);
        return 9 <= c && 13 >= c || 32 === c || 133 === c || 160 === c || 5760 === c || 8192 <= c && 8202 >= c || 8232 === c || 8233 === c || 8239 === c || 8287 === c || 12288 === c
    },
    _utf8_trim_ws: function (c) {
        var d = c.length;
        if (!(0 >= d) && (d -= 1, this._isspace_unicode(c[d]))) {
            for (var e = d - 1; 0 <= e; --e)if (this._isspace_unicode(c[e]))d = e; else break;
            this._utf8_trim_from(c, d)
        }
    },
    _utf8_trim_from: function (c, d) {
        var e = c.length;
        d >= e || 0 > d || c.splice(d, e)
    }
});
(function () {
    var c = cc.LabelBMFont.prototype;
    cc.EventHelper.prototype.apply(c);
    cc.defineGetterSetter(c, "string", c.getString, c._setStringForSetter);
    cc.defineGetterSetter(c, "boundingWidth", c._getBoundingWidth, c.setBoundingWidth);
    cc.defineGetterSetter(c, "textAlign", c._getAlignment, c.setAlignment);
    cc.defineGetterSetter(c, "texture", c.getTexture, c.setTexture)
})();
cc.LabelBMFont.create = function (c, d, e, f, g) {
    return new cc.LabelBMFont(c, d, e, f, g)
};
var _fntLoader = {
    INFO_EXP: /info [^\n]*(\n|$)/gi,
    COMMON_EXP: /common [^\n]*(\n|$)/gi,
    PAGE_EXP: /page [^\n]*(\n|$)/gi,
    CHAR_EXP: /char [^\n]*(\n|$)/gi,
    KERNING_EXP: /kerning [^\n]*(\n|$)/gi,
    ITEM_EXP: /\w+=[^ \r\n]+/gi,
    INT_EXP: /^[\-]?\d+$/,
    _parseStrToObj: function (c) {
        c = c.match(this.ITEM_EXP);
        var d = {};
        if (c)for (var e = 0, f = c.length; e < f; e++) {
            var g = c[e], h = g.indexOf("\x3d"), k = g.substring(0, h), g = g.substring(h + 1);
            g.match(this.INT_EXP) ? g = parseInt(g) : '"' === g[0] && (g = g.substring(1, g.length - 1));
            d[k] = g
        }
        return d
    },
    parseFnt: function (c,
                        d) {
        var e = {}, f = this._parseStrToObj(c.match(this.INFO_EXP)[0]).padding.split(",");
        parseInt(f[0]);
        parseInt(f[1]);
        parseInt(f[2]);
        parseInt(f[3]);
        f = this._parseStrToObj(c.match(this.COMMON_EXP)[0]);
        e.commonHeight = f.lineHeight;
        if (cc._renderType === cc.game.RENDER_TYPE_WEBGL) {
            var g = cc.configuration.getMaxTextureSize();
            (f.scaleW > g.width || f.scaleH > g.height) && cc.log("cc.LabelBMFont._parseCommonArguments(): page can't be larger than supported")
        }
        1 !== f.pages && cc.log("cc.LabelBMFont._parseCommonArguments(): only supports 1 page");
        f = this._parseStrToObj(c.match(this.PAGE_EXP)[0]);
        0 !== f.id && cc.log("cc.LabelBMFont._parseImageFileName() : file could not be found");
        e.atlasName = cc.path.changeBasename(d, f.file);
        for (var h = c.match(this.CHAR_EXP), k = e.fontDefDictionary = {}, f = 0, g = h.length; f < g; f++) {
            var m = this._parseStrToObj(h[f]);
            k[m.id] = {
                rect: {x: m.x, y: m.y, width: m.width, height: m.height},
                xOffset: m.xoffset,
                yOffset: m.yoffset,
                xAdvance: m.xadvance
            }
        }
        h = e.kerningDict = {};
        if (k = c.match(this.KERNING_EXP))for (f = 0, g = k.length; f < g; f++)m = this._parseStrToObj(k[f]),
            h[m.first << 16 | m.second & 65535] = m.amount;
        return e
    },
    load: function (c, d, e, f) {
        var g = this;
        cc.loader.loadTxt(c, function (c, e) {
            if (c)return f(c);
            f(null, g.parseFnt(e, d))
        })
    }
};
cc.loader.register(["fnt"], _fntLoader);
(function () {
    cc.LabelBMFont.CanvasRenderCmd = function (c) {
        cc.Node.CanvasRenderCmd.call(this, c)
    };
    var c = cc.LabelBMFont.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
    c.constructor = cc.LabelBMFont.CanvasRenderCmd;
    c._updateCharTexture = function (c, e, f) {
        32 === f ? c.setTextureRect(e, !1, cc.size(0, 0)) : (c.setTextureRect(e, !1), c.visible = !0)
    };
    c._updateCharColorAndOpacity = function (c) {
        c._displayedColor = this._displayedColor;
        c._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty);
        c._displayedOpacity =
            this._displayedOpacity;
        c._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.opacityDirty)
    };
    c.setTexture = function (c) {
        for (var e = this._node, f = e._children, g = this._displayedColor, h = 0; h < f.length; h++) {
            var k = f[h], m = k._renderCmd, n = m._displayedColor;
            if (e._texture === m._texture || n.r === g.r && n.g === g.g && n.b === g.b)k.texture = c
        }
        e._texture = c
    };
    c._changeTextureColor = function () {
        var c = this._node, e = c._texture, f = e.getContentSize(), g = c._texture, h = g.getHtmlElementObj(), k = this._displayedColor, m = cc.rect(0, 0, h.width, h.height);
        e && 0 < f.width &&
        h && (e = g._generateColorTexture(k.r, k.g, k.b, m), c.setTexture(e))
    };
    c._updateChildrenDisplayedOpacity = function (c) {
        cc.Node.prototype.updateDisplayedOpacity.call(c, this._displayedOpacity)
    };
    c._updateChildrenDisplayedColor = function (c) {
        cc.Node.prototype.updateDisplayedColor.call(c, this._displayedColor)
    }
})();
(function () {
    cc.LabelBMFont.WebGLRenderCmd = function (c) {
        cc.Node.WebGLRenderCmd.call(this, c)
    };
    var c = cc.LabelBMFont.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
    c.constructor = cc.LabelBMFont.WebGLRenderCmd;
    c.setTexture = function (c) {
        this._node.setOpacityModifyRGB(this._node._texture.hasPremultipliedAlpha())
    };
    c._updateCharTexture = function (c, e, f) {
        c.setTextureRect(e, !1);
        c.visible = !0
    };
    c._changeTextureColor = function () {
    };
    c._updateCharColorAndOpacity = function () {
    }
})();
cc.v2fzero = function () {
    return {x: 0, y: 0}
};
cc.v2f = function (c, d) {
    return {x: c, y: d}
};
cc.v2fadd = function (c, d) {
    return cc.v2f(c.x + d.x, c.y + d.y)
};
cc.v2fsub = function (c, d) {
    return cc.v2f(c.x - d.x, c.y - d.y)
};
cc.v2fmult = function (c, d) {
    return cc.v2f(c.x * d, c.y * d)
};
cc.v2fperp = function (c) {
    return cc.v2f(-c.y, c.x)
};
cc.v2fneg = function (c) {
    return cc.v2f(-c.x, -c.y)
};
cc.v2fdot = function (c, d) {
    return c.x * d.x + c.y * d.y
};
cc.v2fforangle = function (c) {
    return cc.v2f(Math.cos(c), Math.sin(c))
};
cc.v2fnormalize = function (c) {
    c = cc.pNormalize(cc.p(c.x, c.y));
    return cc.v2f(c.x, c.y)
};
cc.__v2f = function (c) {
    return cc.v2f(c.x, c.y)
};
cc.__t = function (c) {
    return {u: c.x, v: c.y}
};
cc.DrawNode = cc.Node.extend({
    _buffer: null, _blendFunc: null, _lineWidth: 1, _drawColor: null, getBlendFunc: function () {
        return this._blendFunc
    }, setBlendFunc: function (c, d) {
        void 0 === d ? (this._blendFunc.src = c.src, this._blendFunc.dst = c.dst) : (this._blendFunc.src = c, this._blendFunc.dst = d)
    }, setLineWidth: function (c) {
        this._lineWidth = c
    }, getLineWidth: function () {
        return this._lineWidth
    }, setDrawColor: function (c) {
        var d = this._drawColor;
        d.r = c.r;
        d.g = c.g;
        d.b = c.b;
        d.a = null == c.a ? 255 : c.a
    }, getDrawColor: function () {
        return cc.color(this._drawColor.r,
            this._drawColor.g, this._drawColor.b, this._drawColor.a)
    }
});
cc.DrawNode.create = function () {
    return new cc.DrawNode
};
cc.DrawNode.TYPE_DOT = 0;
cc.DrawNode.TYPE_SEGMENT = 1;
cc.DrawNode.TYPE_POLY = 2;
cc.game.addEventListener(cc.game.EVENT_RENDERER_INITED, function () {
    cc._renderType === cc.game.RENDER_TYPE_CANVAS ? (cc._DrawNodeElement = function (c, d, e, f, g, h, k, m, n) {
        this.type = c;
        this.verts = d || null;
        this.fillColor = e || null;
        this.lineWidth = f || 0;
        this.lineColor = g || null;
        this.lineCap = h || "butt";
        this.isClosePolygon = k || !1;
        this.isFill = m || !1;
        this.isStroke = n || !1
    }, cc.extend(cc.DrawNode.prototype, {
        _className: "DrawNodeCanvas", ctor: function () {
            cc.Node.prototype.ctor.call(this);
            var c = this._renderCmd;
            c._buffer = this._buffer = [];
            c._drawColor = this._drawColor = cc.color(255, 255, 255, 255);
            c._blendFunc = this._blendFunc = new cc.BlendFunc(cc.SRC_ALPHA, cc.ONE_MINUS_SRC_ALPHA);
            this.init()
        }, drawRect: function (c, d, e, f, g) {
            f = null == f ? this._lineWidth : f;
            g = g || this.getDrawColor();
            null == g.a && (g.a = 255);
            c = [c, cc.p(d.x, c.y), d, cc.p(c.x, d.y)];
            d = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
            d.verts = c;
            d.lineWidth = f;
            d.lineColor = g;
            d.isClosePolygon = !0;
            d.isStroke = !0;
            d.lineCap = "butt";
            if (d.fillColor = e)null == e.a && (e.a = 255), d.isFill = !0;
            this._buffer.push(d)
        }, drawCircle: function (c,
                                 d, e, f, g, h, k) {
            h = h || this._lineWidth;
            k = k || this.getDrawColor();
            null == k.a && (k.a = 255);
            for (var m = 2 * Math.PI / f, n = [], p = 0; p <= f; p++) {
                var r = p * m, s = d * Math.cos(r + e) + c.x, r = d * Math.sin(r + e) + c.y;
                n.push(cc.p(s, r))
            }
            g && n.push(cc.p(c.x, c.y));
            c = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
            c.verts = n;
            c.lineWidth = h;
            c.lineColor = k;
            c.isClosePolygon = !0;
            c.isStroke = !0;
            this._buffer.push(c)
        }, drawQuadBezier: function (c, d, e, f, g, h) {
            g = g || this._lineWidth;
            h = h || this.getDrawColor();
            null == h.a && (h.a = 255);
            for (var k = [], m = 0, n = 0; n < f; n++) {
                var p =
                    Math.pow(1 - m, 2) * c.x + 2 * (1 - m) * m * d.x + m * m * e.x, r = Math.pow(1 - m, 2) * c.y + 2 * (1 - m) * m * d.y + m * m * e.y;
                k.push(cc.p(p, r));
                m += 1 / f
            }
            k.push(cc.p(e.x, e.y));
            c = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
            c.verts = k;
            c.lineWidth = g;
            c.lineColor = h;
            c.isStroke = !0;
            c.lineCap = "round";
            this._buffer.push(c)
        }, drawCubicBezier: function (c, d, e, f, g, h, k) {
            h = h || this._lineWidth;
            k = k || this.getDrawColor();
            null == k.a && (k.a = 255);
            for (var m = [], n = 0, p = 0; p < g; p++) {
                var r = Math.pow(1 - n, 3) * c.x + 3 * Math.pow(1 - n, 2) * n * d.x + 3 * (1 - n) * n * n * e.x + n * n * n * f.x, s = Math.pow(1 - n,
                        3) * c.y + 3 * Math.pow(1 - n, 2) * n * d.y + 3 * (1 - n) * n * n * e.y + n * n * n * f.y;
                m.push(cc.p(r, s));
                n += 1 / g
            }
            m.push(cc.p(f.x, f.y));
            c = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
            c.verts = m;
            c.lineWidth = h;
            c.lineColor = k;
            c.isStroke = !0;
            c.lineCap = "round";
            this._buffer.push(c)
        }, drawCatmullRom: function (c, d, e, f) {
            this.drawCardinalSpline(c, 0.5, d, e, f)
        }, drawCardinalSpline: function (c, d, e, f, g) {
            f = f || this._lineWidth;
            g = g || this.getDrawColor();
            null == g.a && (g.a = 255);
            for (var h = [], k, m, n = 1 / c.length, p = 0; p < e + 1; p++)m = p / e, 1 === m ? (k = c.length - 1, m = 1) : (k = 0 |
                m / n, m = (m - n * k) / n), k = cc.cardinalSplineAt(cc.getControlPointAt(c, k - 1), cc.getControlPointAt(c, k - 0), cc.getControlPointAt(c, k + 1), cc.getControlPointAt(c, k + 2), d, m), h.push(k);
            c = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
            c.verts = h;
            c.lineWidth = f;
            c.lineColor = g;
            c.isStroke = !0;
            c.lineCap = "round";
            this._buffer.push(c)
        }, drawDot: function (c, d, e) {
            e = e || this.getDrawColor();
            null == e.a && (e.a = 255);
            var f = new cc._DrawNodeElement(cc.DrawNode.TYPE_DOT);
            f.verts = [c];
            f.lineWidth = d;
            f.fillColor = e;
            this._buffer.push(f)
        }, drawDots: function (c,
                               d, e) {
            if (c && 0 != c.length) {
                e = e || this.getDrawColor();
                null == e.a && (e.a = 255);
                for (var f = 0, g = c.length; f < g; f++)this.drawDot(c[f], d, e)
            }
        }, drawSegment: function (c, d, e, f) {
            e = e || this._lineWidth;
            f = f || this.getDrawColor();
            null == f.a && (f.a = 255);
            var g = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
            g.verts = [c, d];
            g.lineWidth = 2 * e;
            g.lineColor = f;
            g.isStroke = !0;
            g.lineCap = "round";
            this._buffer.push(g)
        }, drawPoly_: function (c, d, e, f) {
            e = null == e ? this._lineWidth : e;
            f = f || this.getDrawColor();
            null == f.a && (f.a = 255);
            var g = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
            g.verts = c;
            g.fillColor = d;
            g.lineWidth = e;
            g.lineColor = f;
            g.isClosePolygon = !0;
            g.isStroke = !0;
            g.lineCap = "round";
            d && (g.isFill = !0);
            this._buffer.push(g)
        }, drawPoly: function (c, d, e, f) {
            for (var g = [], h = 0; h < c.length; h++)g.push(cc.p(c[h].x, c[h].y));
            return this.drawPoly_(g, d, e, f)
        }, clear: function () {
            this._buffer.length = 0
        }, _createRenderCmd: function () {
            return new cc.DrawNode.CanvasRenderCmd(this)
        }
    })) : cc._renderType === cc.game.RENDER_TYPE_WEBGL && cc.extend(cc.DrawNode.prototype, {
        _bufferCapacity: 0, _trianglesArrayBuffer: null,
        _trianglesWebBuffer: null, _trianglesReader: null, _dirty: !1, _className: "DrawNodeWebGL", ctor: function () {
            cc.Node.prototype.ctor.call(this);
            this._buffer = [];
            this._blendFunc = new cc.BlendFunc(cc.SRC_ALPHA, cc.ONE_MINUS_SRC_ALPHA);
            this._drawColor = cc.color(255, 255, 255, 255);
            this.init()
        }, init: function () {
            return cc.Node.prototype.init.call(this) ? (this.shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_LENGTHTEXTURECOLOR), this._ensureCapacity(64), this._trianglesWebBuffer = cc._renderContext.createBuffer(),
                this._dirty = !0) : !1
        }, drawRect: function (c, d, e, f, g) {
            f = null == f ? this._lineWidth : f;
            g = g || this.getDrawColor();
            null == g.a && (g.a = 255);
            c = [c, cc.p(d.x, c.y), d, cc.p(c.x, d.y)];
            null == e ? this._drawSegments(c, f, g, !0) : this.drawPoly(c, e, f, g)
        }, drawCircle: function (c, d, e, f, g, h, k) {
            h = h || this._lineWidth;
            k = k || this.getDrawColor();
            null == k.a && (k.a = 255);
            var m = 2 * Math.PI / f, n = [], p;
            for (p = 0; p <= f; p++) {
                var r = p * m, s = d * Math.cos(r + e) + c.x, r = d * Math.sin(r + e) + c.y;
                n.push(cc.p(s, r))
            }
            g && n.push(cc.p(c.x, c.y));
            h *= 0.5;
            p = 0;
            for (c = n.length; p < c - 1; p++)this.drawSegment(n[p],
                n[p + 1], h, k)
        }, drawQuadBezier: function (c, d, e, f, g, h) {
            g = g || this._lineWidth;
            h = h || this.getDrawColor();
            null == h.a && (h.a = 255);
            for (var k = [], m = 0, n = 0; n < f; n++) {
                var p = Math.pow(1 - m, 2) * c.x + 2 * (1 - m) * m * d.x + m * m * e.x, r = Math.pow(1 - m, 2) * c.y + 2 * (1 - m) * m * d.y + m * m * e.y;
                k.push(cc.p(p, r));
                m += 1 / f
            }
            k.push(cc.p(e.x, e.y));
            this._drawSegments(k, g, h, !1)
        }, drawCubicBezier: function (c, d, e, f, g, h, k) {
            h = h || this._lineWidth;
            k = k || this.getDrawColor();
            null == k.a && (k.a = 255);
            for (var m = [], n = 0, p = 0; p < g; p++) {
                var r = Math.pow(1 - n, 3) * c.x + 3 * Math.pow(1 - n, 2) * n * d.x +
                    3 * (1 - n) * n * n * e.x + n * n * n * f.x, s = Math.pow(1 - n, 3) * c.y + 3 * Math.pow(1 - n, 2) * n * d.y + 3 * (1 - n) * n * n * e.y + n * n * n * f.y;
                m.push(cc.p(r, s));
                n += 1 / g
            }
            m.push(cc.p(f.x, f.y));
            this._drawSegments(m, h, k, !1)
        }, drawCatmullRom: function (c, d, e, f) {
            this.drawCardinalSpline(c, 0.5, d, e, f)
        }, drawCardinalSpline: function (c, d, e, f, g) {
            f = f || this._lineWidth;
            g = g || this.getDrawColor();
            null == g.a && (g.a = 255);
            for (var h = [], k, m, n = 1 / c.length, p = 0; p < e + 1; p++)m = p / e, 1 === m ? (k = c.length - 1, m = 1) : (k = 0 | m / n, m = (m - n * k) / n), k = cc.cardinalSplineAt(cc.getControlPointAt(c, k - 1), cc.getControlPointAt(c,
                k - 0), cc.getControlPointAt(c, k + 1), cc.getControlPointAt(c, k + 2), d, m), h.push(k);
            f *= 0.5;
            c = 0;
            for (d = h.length; c < d - 1; c++)this.drawSegment(h[c], h[c + 1], f, g)
        }, _render: function () {
            var c = cc._renderContext;
            c.bindBuffer(c.ARRAY_BUFFER, this._trianglesWebBuffer);
            this._dirty && (c.bufferData(c.ARRAY_BUFFER, this._trianglesArrayBuffer, c.STREAM_DRAW), this._dirty = !1);
            var d = cc.V2F_C4B_T2F.BYTES_PER_ELEMENT;
            c.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION);
            c.enableVertexAttribArray(cc.VERTEX_ATTRIB_COLOR);
            c.enableVertexAttribArray(cc.VERTEX_ATTRIB_TEX_COORDS);
            c.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, c.FLOAT, !1, d, 0);
            c.vertexAttribPointer(cc.VERTEX_ATTRIB_COLOR, 4, c.UNSIGNED_BYTE, !0, d, 8);
            c.vertexAttribPointer(cc.VERTEX_ATTRIB_TEX_COORDS, 2, c.FLOAT, !1, d, 12);
            c.drawArrays(c.TRIANGLES, 0, 3 * this._buffer.length);
            cc.incrementGLDraws(1)
        }, _ensureCapacity: function (c) {
            var d = this._buffer;
            if (d.length + c > this._bufferCapacity) {
                var e = cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT;
                this._bufferCapacity += Math.max(this._bufferCapacity, c);
                if (null == d || 0 === d.length)this._buffer =
                    [], this._trianglesArrayBuffer = new ArrayBuffer(e * this._bufferCapacity), this._trianglesReader = new Uint8Array(this._trianglesArrayBuffer); else {
                    c = [];
                    for (var f = new ArrayBuffer(e * this._bufferCapacity), g = 0; g < d.length; g++)c[g] = new cc.V2F_C4B_T2F_Triangle(d[g].a, d[g].b, d[g].c, f, g * e);
                    this._trianglesReader = new Uint8Array(f);
                    this._trianglesArrayBuffer = f;
                    this._buffer = c
                }
            }
        }, drawDot: function (c, d, e) {
            e = e || this.getDrawColor();
            null == e.a && (e.a = 255);
            var f = {r: 0 | e.r, g: 0 | e.g, b: 0 | e.b, a: 0 | e.a};
            e = {
                vertices: {x: c.x - d, y: c.y - d},
                colors: f, texCoords: {u: -1, v: -1}
            };
            var g = {
                vertices: {x: c.x - d, y: c.y + d},
                colors: f,
                texCoords: {u: -1, v: 1}
            }, h = {vertices: {x: c.x + d, y: c.y + d}, colors: f, texCoords: {u: 1, v: 1}};
            c = {vertices: {x: c.x + d, y: c.y - d}, colors: f, texCoords: {u: 1, v: -1}};
            this._ensureCapacity(6);
            this._buffer.push(new cc.V2F_C4B_T2F_Triangle(e, g, h, this._trianglesArrayBuffer, this._buffer.length * cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT));
            this._buffer.push(new cc.V2F_C4B_T2F_Triangle(e, h, c, this._trianglesArrayBuffer, this._buffer.length * cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT));
            this._dirty = !0
        }, drawDots: function (c, d, e) {
            if (c && 0 !== c.length) {
                e = e || this.getDrawColor();
                null == e.a && (e.a = 255);
                for (var f = 0, g = c.length; f < g; f++)this.drawDot(c[f], d, e)
            }
        }, drawSegment: function (c, d, e, f) {
            f = f || this.getDrawColor();
            null == f.a && (f.a = 255);
            e = e || 0.5 * this._lineWidth;
            this._ensureCapacity(18);
            f = {r: 0 | f.r, g: 0 | f.g, b: 0 | f.b, a: 0 | f.a};
            var g = cc.__v2f(c), h = cc.__v2f(d);
            d = cc.v2fnormalize(cc.v2fperp(cc.v2fsub(h, g)));
            c = cc.v2fperp(d);
            var k = cc.v2fmult(d, e), m = cc.v2fmult(c, e);
            e = cc.v2fsub(h, cc.v2fadd(k, m));
            var n = cc.v2fadd(h,
                cc.v2fsub(k, m)), p = cc.v2fsub(h, k), h = cc.v2fadd(h, k), r = cc.v2fsub(g, k), s = cc.v2fadd(g, k), v = cc.v2fsub(g, cc.v2fsub(k, m)), g = cc.v2fadd(g, cc.v2fadd(k, m)), k = cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT, m = this._trianglesArrayBuffer, t = this._buffer;
            t.push(new cc.V2F_C4B_T2F_Triangle({
                vertices: e,
                colors: f,
                texCoords: cc.__t(cc.v2fneg(cc.v2fadd(d, c)))
            }, {vertices: n, colors: f, texCoords: cc.__t(cc.v2fsub(d, c))}, {
                vertices: p,
                colors: f,
                texCoords: cc.__t(cc.v2fneg(d))
            }, m, t.length * k));
            t.push(new cc.V2F_C4B_T2F_Triangle({
                vertices: h,
                colors: f, texCoords: cc.__t(d)
            }, {vertices: n, colors: f, texCoords: cc.__t(cc.v2fsub(d, c))}, {
                vertices: p,
                colors: f,
                texCoords: cc.__t(cc.v2fneg(d))
            }, m, t.length * k));
            t.push(new cc.V2F_C4B_T2F_Triangle({vertices: h, colors: f, texCoords: cc.__t(d)}, {
                vertices: r,
                colors: f,
                texCoords: cc.__t(cc.v2fneg(d))
            }, {vertices: p, colors: f, texCoords: cc.__t(cc.v2fneg(d))}, m, t.length * k));
            t.push(new cc.V2F_C4B_T2F_Triangle({vertices: h, colors: f, texCoords: cc.__t(d)}, {
                vertices: r,
                colors: f,
                texCoords: cc.__t(cc.v2fneg(d))
            }, {
                vertices: s, colors: f,
                texCoords: cc.__t(d)
            }, m, t.length * k));
            t.push(new cc.V2F_C4B_T2F_Triangle({
                vertices: v,
                colors: f,
                texCoords: cc.__t(cc.v2fsub(c, d))
            }, {vertices: r, colors: f, texCoords: cc.__t(cc.v2fneg(d))}, {
                vertices: s,
                colors: f,
                texCoords: cc.__t(d)
            }, m, t.length * k));
            t.push(new cc.V2F_C4B_T2F_Triangle({
                vertices: v,
                colors: f,
                texCoords: cc.__t(cc.v2fsub(c, d))
            }, {vertices: g, colors: f, texCoords: cc.__t(cc.v2fadd(d, c))}, {
                vertices: s,
                colors: f,
                texCoords: cc.__t(d)
            }, m, t.length * k));
            this._dirty = !0
        }, drawPoly: function (c, d, e, f) {
            if (null == d)this._drawSegments(c,
                e, f, !0); else {
                null == d.a && (d.a = 255);
                null == f.a && (f.a = 255);
                e = null == e ? this._lineWidth : e;
                e *= 0.5;
                d = {r: 0 | d.r, g: 0 | d.g, b: 0 | d.b, a: 0 | d.a};
                f = {r: 0 | f.r, g: 0 | f.g, b: 0 | f.b, a: 0 | f.a};
                var g = [], h, k, m, n, p = c.length;
                for (h = 0; h < p; h++) {
                    k = cc.__v2f(c[(h - 1 + p) % p]);
                    m = cc.__v2f(c[h]);
                    n = cc.__v2f(c[(h + 1) % p]);
                    var r = cc.v2fnormalize(cc.v2fperp(cc.v2fsub(m, k)));
                    m = cc.v2fnormalize(cc.v2fperp(cc.v2fsub(n, m)));
                    r = cc.v2fmult(cc.v2fadd(r, m), 1 / (cc.v2fdot(r, m) + 1));
                    g[h] = {offset: r, n: m}
                }
                r = 0 < e;
                this._ensureCapacity(3 * (3 * p - 2));
                var s = cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT,
                    v = this._trianglesArrayBuffer, t = this._buffer, w = !1 == r ? 0.5 : 0;
                for (h = 0; h < p - 2; h++)k = cc.v2fsub(cc.__v2f(c[0]), cc.v2fmult(g[0].offset, w)), m = cc.v2fsub(cc.__v2f(c[h + 1]), cc.v2fmult(g[h + 1].offset, w)), n = cc.v2fsub(cc.__v2f(c[h + 2]), cc.v2fmult(g[h + 2].offset, w)), t.push(new cc.V2F_C4B_T2F_Triangle({
                    vertices: k,
                    colors: d,
                    texCoords: cc.__t(cc.v2fzero())
                }, {vertices: m, colors: d, texCoords: cc.__t(cc.v2fzero())}, {
                    vertices: n,
                    colors: d,
                    texCoords: cc.__t(cc.v2fzero())
                }, v, t.length * s));
                for (h = 0; h < p; h++) {
                    w = (h + 1) % p;
                    k = cc.__v2f(c[h]);
                    m =
                        cc.__v2f(c[w]);
                    n = g[h].n;
                    var u = g[h].offset, A = g[w].offset, w = r ? cc.v2fsub(k, cc.v2fmult(u, e)) : cc.v2fsub(k, cc.v2fmult(u, 0.5)), x = r ? cc.v2fsub(m, cc.v2fmult(A, e)) : cc.v2fsub(m, cc.v2fmult(A, 0.5));
                    k = r ? cc.v2fadd(k, cc.v2fmult(u, e)) : cc.v2fadd(k, cc.v2fmult(u, 0.5));
                    m = r ? cc.v2fadd(m, cc.v2fmult(A, e)) : cc.v2fadd(m, cc.v2fmult(A, 0.5));
                    r ? (t.push(new cc.V2F_C4B_T2F_Triangle({
                        vertices: w,
                        colors: f,
                        texCoords: cc.__t(cc.v2fneg(n))
                    }, {vertices: x, colors: f, texCoords: cc.__t(cc.v2fneg(n))}, {
                        vertices: m,
                        colors: f,
                        texCoords: cc.__t(n)
                    }, v, t.length *
                        s)), t.push(new cc.V2F_C4B_T2F_Triangle({
                        vertices: w,
                        colors: f,
                        texCoords: cc.__t(cc.v2fneg(n))
                    }, {vertices: k, colors: f, texCoords: cc.__t(n)}, {
                        vertices: m,
                        colors: f,
                        texCoords: cc.__t(n)
                    }, v, t.length * s))) : (t.push(new cc.V2F_C4B_T2F_Triangle({
                        vertices: w,
                        colors: d,
                        texCoords: cc.__t(cc.v2fzero())
                    }, {vertices: x, colors: d, texCoords: cc.__t(cc.v2fzero())}, {
                        vertices: m,
                        colors: d,
                        texCoords: cc.__t(n)
                    }, v, t.length * s)), t.push(new cc.V2F_C4B_T2F_Triangle({
                            vertices: w,
                            colors: d,
                            texCoords: cc.__t(cc.v2fzero())
                        }, {vertices: k, colors: d, texCoords: cc.__t(n)},
                        {vertices: m, colors: d, texCoords: cc.__t(n)}, v, t.length * s)))
                }
                this._dirty = !0
            }
        }, _drawSegments: function (c, d, e, f) {
            d = null == d ? this._lineWidth : d;
            e = e || this._drawColor;
            null == e.a && (e.a = 255);
            d *= 0.5;
            if (!(0 >= d)) {
                e = {r: 0 | e.r, g: 0 | e.g, b: 0 | e.b, a: 0 | e.a};
                var g = [], h, k, m, n, p = c.length;
                for (h = 0; h < p; h++) {
                    k = cc.__v2f(c[(h - 1 + p) % p]);
                    m = cc.__v2f(c[h]);
                    n = cc.__v2f(c[(h + 1) % p]);
                    var r = cc.v2fnormalize(cc.v2fperp(cc.v2fsub(m, k)));
                    m = cc.v2fnormalize(cc.v2fperp(cc.v2fsub(n, m)));
                    n = cc.v2fmult(cc.v2fadd(r, m), 1 / (cc.v2fdot(r, m) + 1));
                    g[h] = {
                        offset: n,
                        n: m
                    }
                }
                this._ensureCapacity(3 * (3 * p - 2));
                n = cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT;
                var r = this._trianglesArrayBuffer, s = this._buffer;
                f = f ? p : p - 1;
                for (h = 0; h < f; h++) {
                    var v = (h + 1) % p;
                    k = cc.__v2f(c[h]);
                    m = cc.__v2f(c[v]);
                    var t = g[h].n, w = g[h].offset, u = g[v].offset, v = cc.v2fsub(k, cc.v2fmult(w, d)), A = cc.v2fsub(m, cc.v2fmult(u, d));
                    k = cc.v2fadd(k, cc.v2fmult(w, d));
                    m = cc.v2fadd(m, cc.v2fmult(u, d));
                    s.push(new cc.V2F_C4B_T2F_Triangle({
                            vertices: v,
                            colors: e,
                            texCoords: cc.__t(cc.v2fneg(t))
                        }, {vertices: A, colors: e, texCoords: cc.__t(cc.v2fneg(t))},
                        {vertices: m, colors: e, texCoords: cc.__t(t)}, r, s.length * n));
                    s.push(new cc.V2F_C4B_T2F_Triangle({
                        vertices: v,
                        colors: e,
                        texCoords: cc.__t(cc.v2fneg(t))
                    }, {vertices: k, colors: e, texCoords: cc.__t(t)}, {
                        vertices: m,
                        colors: e,
                        texCoords: cc.__t(t)
                    }, r, s.length * n))
                }
                this._dirty = !0
            }
        }, clear: function () {
            this._buffer.length = 0;
            this._dirty = !0
        }, _createRenderCmd: function () {
            return new cc.DrawNode.WebGLRenderCmd(this)
        }
    })
});
(function () {
    cc.DrawNode.CanvasRenderCmd = function (c) {
        cc.Node.CanvasRenderCmd.call(this, c);
        this._needDraw = !0;
        this._blendFunc = this._drawColor = this._buffer = null
    };
    cc.DrawNode.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
    cc.DrawNode.CanvasRenderCmd.prototype.constructor = cc.DrawNode.CanvasRenderCmd;
    cc.extend(cc.DrawNode.CanvasRenderCmd.prototype, {
        rendering: function (c, d, e) {
            c = c || cc._renderContext;
            c.getContext();
            var f = this._node._displayedOpacity / 255;
            if (0 !== f) {
                c.setTransform(this._worldTransform,
                    d, e);
                c.setGlobalAlpha(f);
                this._blendFunc && this._blendFunc.src === cc.SRC_ALPHA && this._blendFunc.dst === cc.ONE && c.setCompositeOperation("lighter");
                for (var f = this._buffer, g = 0, h = f.length; g < h; g++) {
                    var k = f[g];
                    switch (k.type) {
                        case cc.DrawNode.TYPE_DOT:
                            this._drawDot(c, k, d, e);
                            break;
                        case cc.DrawNode.TYPE_SEGMENT:
                            this._drawSegment(c, k, d, e);
                            break;
                        case cc.DrawNode.TYPE_POLY:
                            this._drawPoly(c, k, d, e)
                    }
                }
            }
        }, _drawDot: function (c, d, e, f) {
            var g = d.fillColor, h = d.verts[0];
            d = d.lineWidth;
            var k = c.getContext();
            c.setFillStyle("rgba(" +
                (0 | g.r) + "," + (0 | g.g) + "," + (0 | g.b) + "," + g.a / 255 + ")");
            k.beginPath();
            k.arc(h.x * e, -h.y * f, d * e, 0, 2 * Math.PI, !1);
            k.closePath();
            k.fill()
        }, _drawSegment: function (c, d, e, f) {
            var g = d.lineColor, h = d.verts[0], k = d.verts[1], m = d.lineWidth;
            d = d.lineCap;
            var n = c.getContext();
            c.setStrokeStyle("rgba(" + (0 | g.r) + "," + (0 | g.g) + "," + (0 | g.b) + "," + g.a / 255 + ")");
            n.lineWidth = m * e;
            n.beginPath();
            n.lineCap = d;
            n.moveTo(h.x * e, -h.y * f);
            n.lineTo(k.x * e, -k.y * f);
            n.stroke()
        }, _drawPoly: function (c, d, e, f) {
            var g = d.verts, h = d.lineCap;
            if (null != g) {
                var k = d.fillColor,
                    m = d.lineWidth, n = d.lineColor, p = d.isClosePolygon, r = d.isFill;
                d = d.isStroke;
                var s = c.getContext(), v = g[0];
                s.lineCap = h;
                k && c.setFillStyle("rgba(" + (0 | k.r) + "," + (0 | k.g) + "," + (0 | k.b) + "," + k.a / 255 + ")");
                m && (s.lineWidth = m * e);
                n && c.setStrokeStyle("rgba(" + (0 | n.r) + "," + (0 | n.g) + "," + (0 | n.b) + "," + n.a / 255 + ")");
                s.beginPath();
                s.moveTo(v.x * e, -v.y * f);
                c = 1;
                for (h = g.length; c < h; c++)s.lineTo(g[c].x * e, -g[c].y * f);
                p && s.closePath();
                r && s.fill();
                d && s.stroke()
            }
        }
    })
})();
(function () {
    cc.DrawNode.WebGLRenderCmd = function (c) {
        cc.Node.WebGLRenderCmd.call(this, c);
        this._needDraw = !0;
        this._matrix = new cc.math.Matrix4;
        this._matrix.identity()
    };
    cc.DrawNode.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
    cc.DrawNode.WebGLRenderCmd.prototype.constructor = cc.DrawNode.WebGLRenderCmd;
    cc.DrawNode.WebGLRenderCmd.prototype.rendering = function (c) {
        c = this._node;
        if (0 < c._buffer.length) {
            var d = this._worldTransform;
            this._matrix.mat[0] = d.a;
            this._matrix.mat[4] = d.c;
            this._matrix.mat[12] =
                d.tx;
            this._matrix.mat[1] = d.b;
            this._matrix.mat[5] = d.d;
            this._matrix.mat[13] = d.ty;
            cc.glBlendFunc(c._blendFunc.src, c._blendFunc.dst);
            this._shaderProgram.use();
            this._shaderProgram._setUniformForMVPMatrixWithMat4(this._matrix);
            c._render()
        }
    }
})();
cc.stencilBits = -1;
cc.ClippingNode = cc.Node.extend({
    alphaThreshold: 0, inverted: !1, _stencil: null, _className: "ClippingNode", ctor: function (c) {
        c = c || null;
        cc.Node.prototype.ctor.call(this);
        this._stencil = c;
        this.alphaThreshold = 1;
        this.inverted = !1;
        this._renderCmd.initStencilBits()
    }, init: function (c) {
        this._stencil = c;
        this.alphaThreshold = 1;
        this.inverted = !1;
        this._renderCmd.initStencilBits();
        return !0
    }, onEnter: function () {
        cc.Node.prototype.onEnter.call(this);
        this._stencil.onEnter()
    }, onEnterTransitionDidFinish: function () {
        cc.Node.prototype.onEnterTransitionDidFinish.call(this);
        this._stencil.onEnterTransitionDidFinish()
    },
    onExitTransitionDidStart: function () {
        this._stencil.onExitTransitionDidStart();
        cc.Node.prototype.onExitTransitionDidStart.call(this)
    }, onExit: function () {
        this._stencil.onExit();
        cc.Node.prototype.onExit.call(this)
    }, getAlphaThreshold: function () {
        return this.alphaThreshold
    }, setAlphaThreshold: function (c) {
        this.alphaThreshold = c
    }, isInverted: function () {
        return this.inverted
    }, setInverted: function (c) {
        this.inverted = c
    }, getStencil: function () {
        return this._stencil
    }, setStencil: function (c) {
        this._stencil !== c && this._renderCmd.setStencil(c)
    },
    _createRenderCmd: function () {
        return cc._renderType === cc.game.RENDER_TYPE_CANVAS ? new cc.ClippingNode.CanvasRenderCmd(this) : new cc.ClippingNode.WebGLRenderCmd(this)
    }
});
_p = cc.ClippingNode.prototype;
cc.defineGetterSetter(_p, "stencil", _p.getStencil, _p.setStencil);
cc.ClippingNode.create = function (c) {
    return new cc.ClippingNode(c)
};
(function () {
    cc.ClippingNode.CanvasRenderCmd = function (c) {
        cc.Node.CanvasRenderCmd.call(this, c);
        this._clipElemType = this._godhelpme = this._needDraw = !1;
        this._rendererSaveCmd = new cc.CustomRenderCmd(this, this._saveCmdCallback);
        this._rendererClipCmd = new cc.CustomRenderCmd(this, this._clipCmdCallback);
        this._rendererRestoreCmd = new cc.CustomRenderCmd(this, this._restoreCmdCallback)
    };
    var c = cc.ClippingNode.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
    c.constructor = cc.ClippingNode.CanvasRenderCmd;
    c.initStencilBits = function () {
    };
    c.setStencil = function (c) {
        if (null != c)if (this._node._stencil = c, c instanceof cc.DrawNode) {
            if (c._buffer)for (var e = 0; e < c._buffer.length; e++)c._buffer[e].isFill = !1, c._buffer[e].isStroke = !1;
            c._renderCmd.rendering = function (e, g, h) {
                g = g || cc.view.getScaleX();
                h = h || cc.view.getScaleY();
                e = (e || cc._renderContext).getContext();
                var k = this._transform;
                e.transform(k.a, k.b, k.c, k.d, k.tx * g, -k.ty * h);
                for (k = 0; k < c._buffer.length; k++) {
                    var m = c._buffer[k].verts, n = m[0];
                    e.moveTo(n.x * g, -n.y * h);
                    for (n = m.length -
                        1; 0 < n; n--)e.lineTo(m[n].x * g, -m[n].y * h)
                }
            }
        } else c._parent = this._node
    };
    c._saveCmdCallback = function (c, e, f) {
        var g = c || cc._renderContext;
        c = g.getContext();
        this._clipElemType ? (e = cc.ClippingNode.CanvasRenderCmd._getSharedCache(), f = c.canvas, e.width = f.width, e.height = f.height, e.getContext("2d").drawImage(f, 0, 0)) : (g.save(), c.beginPath(), g.setTransform(this._worldTransform, e, f), this._node.inverted && (c.rect(0, 0, c.canvas.width, -c.canvas.height), c.clip()))
    };
    c._setStencilCompositionOperation = function (c) {
        if (c) {
            var e =
                this._node;
            c._renderCmd && c._renderCmd._blendFuncStr && (c._renderCmd._blendFuncStr = e.inverted ? "destination-out" : "destination-in");
            if (c._children) {
                c = c._children;
                for (var e = 0, f = c.length; e < f; e++)this._setStencilCompositionOperation(c[e])
            }
        }
    };
    c._clipCmdCallback = function (c) {
        var e = this._node;
        c = (c || cc._renderContext).getContext();
        this._clipElemType ? this._setStencilCompositionOperation(e._stencil) : c.clip()
    };
    c._restoreCmdCallback = function (c) {
        var e = cc.ClippingNode.CanvasRenderCmd._getSharedCache();
        c = c || cc._renderContext;
        var f = c.getContext();
        this._clipElemType ? (f.save(), f.setTransform(1, 0, 0, 1, 0, 0), f.globalCompositeOperation = "destination-over", f.drawImage(e, 0, 0), f.restore(), this._dirtyFlag = 0) : c.restore()
    };
    c.transform = function (c, e) {
        cc.Node.CanvasRenderCmd.prototype.transform.call(this, c, e);
        var f = this._node;
        f._stencil && f._stencil._renderCmd && f._stencil._renderCmd.transform(this, e)
    };
    c._cangodhelpme = function (c) {
        if (!0 === c || !1 === c)cc.ClippingNode.CanvasRenderCmd.prototype._godhelpme = c;
        return cc.ClippingNode.CanvasRenderCmd.prototype._godhelpme
    };
    c.visit = function (c) {
        var e = this._node;
        if (e._visible) {
            if (c = c || this.getParentRenderCmd())this._curLevel = c._curLevel + 1;
            this._clipElemType = !(!this._cangodhelpme() && e._stencil instanceof cc.DrawNode);
            if (e._stencil && e._stencil.visible) {
                this._syncStatus(c);
                cc.renderer.pushRenderCommand(this._rendererSaveCmd);
                this._clipElemType ? this.originVisit(c) : e._stencil.visit(this);
                cc.renderer.pushRenderCommand(this._rendererClipCmd);
                if (this._clipElemType)e._stencil.visit(this); else {
                    c = e._children;
                    this._cangodhelpme(!0);
                    var f = c.length;
                    if (0 < f)for (e.sortAllChildren(), e = 0; e < f; e++)c[e]._renderCmd.visit(this);
                    this._cangodhelpme(!1)
                }
                cc.renderer.pushRenderCommand(this._rendererRestoreCmd);
                this._dirtyFlag = 0
            } else this.inverted && this.originVisit(c)
        }
    };
    cc.ClippingNode.CanvasRenderCmd._sharedCache = null;
    cc.ClippingNode.CanvasRenderCmd._getSharedCache = function () {
        return cc.ClippingNode.CanvasRenderCmd._sharedCache || (cc.ClippingNode.CanvasRenderCmd._sharedCache = document.createElement("canvas"))
    }
})();
(function () {
    cc.ClippingNode.WebGLRenderCmd = function (c) {
        cc.Node.WebGLRenderCmd.call(this, c);
        this._needDraw = !1;
        this._beforeVisitCmd = new cc.CustomRenderCmd(this, this._onBeforeVisit);
        this._afterDrawStencilCmd = new cc.CustomRenderCmd(this, this._onAfterDrawStencil);
        this._afterVisitCmd = new cc.CustomRenderCmd(this, this._onAfterVisit);
        this._mask_layer_le = this._currentStencilEnabled = null
    };
    var c = cc.ClippingNode.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
    c.constructor = cc.ClippingNode.WebGLRenderCmd;
    cc.ClippingNode.WebGLRenderCmd._init_once = null;
    cc.ClippingNode.WebGLRenderCmd._visit_once = null;
    cc.ClippingNode.WebGLRenderCmd._layer = -1;
    c.initStencilBits = function () {
        cc.ClippingNode.WebGLRenderCmd._init_once = !0;
        cc.ClippingNode.WebGLRenderCmd._init_once && (cc.stencilBits = cc._renderContext.getParameter(cc._renderContext.STENCIL_BITS), 0 >= cc.stencilBits && cc.log("Stencil buffer is not enabled."), cc.ClippingNode.WebGLRenderCmd._init_once = !1)
    };
    c.transform = function (c, e) {
        var f = this._node;
        this.originTransform(c,
            e);
        f._stencil && f._stencil._renderCmd.transform(this, e)
    };
    c.visit = function (c) {
        var e = this._node;
        if (e._visible)if (e._parent && e._parent._renderCmd && (this._curLevel = e._parent._renderCmd._curLevel + 1), 1 > cc.stencilBits)this.originVisit(c); else if (e._stencil && e._stencil.visible)if (cc.ClippingNode.WebGLRenderCmd._layer + 1 === cc.stencilBits)cc.ClippingNode.WebGLRenderCmd._visit_once = !0, cc.ClippingNode.WebGLRenderCmd._visit_once && (cc.log("Nesting more than " + cc.stencilBits + "stencils is not supported. Everything will be drawn without stencil for this node and its children."),
            cc.ClippingNode.WebGLRenderCmd._visit_once = !1), this.originVisit(c); else {
            cc.renderer.pushRenderCommand(this._beforeVisitCmd);
            var f = cc.current_stack;
            f.stack.push(f.top);
            this._syncStatus(c);
            f.top = this._stackMatrix;
            e._stencil._renderCmd.visit(this);
            cc.renderer.pushRenderCommand(this._afterDrawStencilCmd);
            if ((c = e._children) && 0 < c.length) {
                var g = c.length;
                e.sortAllChildren();
                for (e = 0; e < g; e++)c[e]._renderCmd.visit(this)
            }
            cc.renderer.pushRenderCommand(this._afterVisitCmd);
            this._dirtyFlag = 0;
            f.top = f.stack.pop()
        } else e.inverted &&
        this.originVisit(c)
    };
    c.setStencil = function (c) {
        var e = this._node;
        e._stencil && (e._stencil._parent = null);
        e._stencil = c;
        e._stencil && (e._stencil._parent = e)
    };
    c._onBeforeVisit = function (c) {
        var e = c || cc._renderContext;
        c = this._node;
        cc.ClippingNode.WebGLRenderCmd._layer++;
        var f = 1 << cc.ClippingNode.WebGLRenderCmd._layer;
        this._mask_layer_le = f | f - 1;
        this._currentStencilEnabled = e.isEnabled(e.STENCIL_TEST);
        e.clear(e.DEPTH_BUFFER_BIT);
        e.enable(e.STENCIL_TEST);
        e.depthMask(!1);
        e.stencilFunc(e.NEVER, f, f);
        e.stencilOp(e.REPLACE,
            e.KEEP, e.KEEP);
        e.stencilMask(f);
        e.clear(e.STENCIL_BUFFER_BIT);
        1 > c.alphaThreshold && (e = cc.shaderCache.programForKey(cc.SHADER_POSITION_TEXTURECOLORALPHATEST), cc.glUseProgram(e.getProgram()), e.setUniformLocationWith1f(cc.UNIFORM_ALPHA_TEST_VALUE_S, c.alphaThreshold), e.setUniformLocationWithMatrix4fv(cc.UNIFORM_MVMATRIX_S, cc.renderer.mat4Identity.mat), cc.setProgram(c._stencil, e))
    };
    c._onAfterDrawStencil = function (c) {
        c = c || cc._renderContext;
        c.depthMask(!0);
        c.stencilFunc(this._node.inverted ? c.NOTEQUAL : c.EQUAL,
            this._mask_layer_le, this._mask_layer_le);
        c.stencilOp(c.KEEP, c.KEEP, c.KEEP)
    };
    c._onAfterVisit = function (c) {
        c = c || cc._renderContext;
        cc.ClippingNode.WebGLRenderCmd._layer--;
        if (this._currentStencilEnabled) {
            var e = 1 << cc.ClippingNode.WebGLRenderCmd._layer, f = e | e - 1;
            c.stencilMask(e);
            c.stencilFunc(c.EQUAL, f, f)
        } else c.disable(c.STENCIL_TEST)
    }
})();
cc.ACTION_TAG_INVALID = -1;
cc.Action = cc.Class.extend({
    originalTarget: null, target: null, tag: cc.ACTION_TAG_INVALID, ctor: function () {
        this.target = this.originalTarget = null;
        this.tag = cc.ACTION_TAG_INVALID
    }, copy: function () {
        cc.log("copy is deprecated. Please use clone instead.");
        return this.clone()
    }, clone: function () {
        var c = new cc.Action;
        c.originalTarget = null;
        c.target = null;
        c.tag = this.tag;
        return c
    }, isDone: function () {
        return !0
    }, startWithTarget: function (c) {
        this.target = this.originalTarget = c
    }, stop: function () {
        this.target = null
    }, step: function (c) {
        cc.log("[Action step]. override me")
    },
    update: function (c) {
        cc.log("[Action update]. override me")
    }, getTarget: function () {
        return this.target
    }, setTarget: function (c) {
        this.target = c
    }, getOriginalTarget: function () {
        return this.originalTarget
    }, setOriginalTarget: function (c) {
        this.originalTarget = c
    }, getTag: function () {
        return this.tag
    }, setTag: function (c) {
        this.tag = c
    }, retain: function () {
    }, release: function () {
    }
});
cc.action = function () {
    return new cc.Action
};
cc.Action.create = cc.action;
cc.FiniteTimeAction = cc.Action.extend({
    _duration: 0, ctor: function () {
        cc.Action.prototype.ctor.call(this);
        this._duration = 0
    }, getDuration: function () {
        return this._duration * (this._timesForRepeat || 1)
    }, setDuration: function (c) {
        this._duration = c
    }, reverse: function () {
        cc.log("cocos2d: FiniteTimeAction#reverse: Implement me");
        return null
    }, clone: function () {
        return new cc.FiniteTimeAction
    }
});
cc.Speed = cc.Action.extend({
    _speed: 0, _innerAction: null, ctor: function (c, d) {
        cc.Action.prototype.ctor.call(this);
        this._speed = 0;
        this._innerAction = null;
        c && this.initWithAction(c, d)
    }, getSpeed: function () {
        return this._speed
    }, setSpeed: function (c) {
        this._speed = c
    }, initWithAction: function (c, d) {
        if (!c)throw Error("cc.Speed.initWithAction(): action must be non nil");
        this._innerAction = c;
        this._speed = d;
        return !0
    }, clone: function () {
        var c = new cc.Speed;
        c.initWithAction(this._innerAction.clone(), this._speed);
        return c
    }, startWithTarget: function (c) {
        cc.Action.prototype.startWithTarget.call(this,
            c);
        this._innerAction.startWithTarget(c)
    }, stop: function () {
        this._innerAction.stop();
        cc.Action.prototype.stop.call(this)
    }, step: function (c) {
        this._innerAction.step(c * this._speed)
    }, isDone: function () {
        return this._innerAction.isDone()
    }, reverse: function () {
        return new cc.Speed(this._innerAction.reverse(), this._speed)
    }, setInnerAction: function (c) {
        this._innerAction !== c && (this._innerAction = c)
    }, getInnerAction: function () {
        return this._innerAction
    }
});
cc.speed = function (c, d) {
    return new cc.Speed(c, d)
};
cc.Speed.create = cc.speed;
cc.Follow = cc.Action.extend({
    _followedNode: null,
    _boundarySet: !1,
    _boundaryFullyCovered: !1,
    _halfScreenSize: null,
    _fullScreenSize: null,
    _worldRect: null,
    leftBoundary: 0,
    rightBoundary: 0,
    topBoundary: 0,
    bottomBoundary: 0,
    ctor: function (c, d) {
        cc.Action.prototype.ctor.call(this);
        this._followedNode = null;
        this._boundaryFullyCovered = this._boundarySet = !1;
        this._fullScreenSize = this._halfScreenSize = null;
        this.bottomBoundary = this.topBoundary = this.rightBoundary = this.leftBoundary = 0;
        this._worldRect = cc.rect(0, 0, 0, 0);
        c && (d ? this.initWithTarget(c,
            d) : this.initWithTarget(c))
    },
    clone: function () {
        var c = new cc.Follow, d = this._worldRect, d = new cc.Rect(d.x, d.y, d.width, d.height);
        c.initWithTarget(this._followedNode, d);
        return c
    },
    isBoundarySet: function () {
        return this._boundarySet
    },
    setBoudarySet: function (c) {
        this._boundarySet = c
    },
    initWithTarget: function (c, d) {
        if (!c)throw Error("cc.Follow.initWithAction(): followedNode must be non nil");
        d = d || cc.rect(0, 0, 0, 0);
        this._followedNode = c;
        this._worldRect = d;
        this._boundarySet = !cc._rectEqualToZero(d);
        this._boundaryFullyCovered = !1;
        var e = cc.director.getWinSize();
        this._fullScreenSize = cc.p(e.width, e.height);
        this._halfScreenSize = cc.pMult(this._fullScreenSize, 0.5);
        this._boundarySet && (this.leftBoundary = -(d.x + d.width - this._fullScreenSize.x), this.rightBoundary = -d.x, this.topBoundary = -d.y, this.bottomBoundary = -(d.y + d.height - this._fullScreenSize.y), this.rightBoundary < this.leftBoundary && (this.rightBoundary = this.leftBoundary = (this.leftBoundary + this.rightBoundary) / 2), this.topBoundary < this.bottomBoundary && (this.topBoundary = this.bottomBoundary =
            (this.topBoundary + this.bottomBoundary) / 2), this.topBoundary === this.bottomBoundary && this.leftBoundary === this.rightBoundary && (this._boundaryFullyCovered = !0));
        return !0
    },
    step: function (c) {
        c = this._followedNode.x;
        var d = this._followedNode.y;
        c = this._halfScreenSize.x - c;
        d = this._halfScreenSize.y - d;
        this.target._renderCmd._dirtyFlag = 0;
        this._boundarySet ? this._boundaryFullyCovered || this.target.setPosition(cc.clampf(c, this.leftBoundary, this.rightBoundary), cc.clampf(d, this.bottomBoundary, this.topBoundary)) : this.target.setPosition(c,
            d)
    },
    isDone: function () {
        return !this._followedNode.running
    },
    stop: function () {
        this.target = null;
        cc.Action.prototype.stop.call(this)
    }
});
cc.follow = function (c, d) {
    return new cc.Follow(c, d)
};
cc.Follow.create = cc.follow;
cc.ActionInterval = cc.FiniteTimeAction.extend({
    _elapsed: 0,
    _firstTick: !1,
    _easeList: null,
    _timesForRepeat: 1,
    _repeatForever: !1,
    _repeatMethod: !1,
    _speed: 1,
    _speedMethod: !1,
    ctor: function (c) {
        this._timesForRepeat = this._speed = 1;
        this._repeatForever = !1;
        this.MAX_VALUE = 2;
        this._speedMethod = this._repeatMethod = !1;
        cc.FiniteTimeAction.prototype.ctor.call(this);
        void 0 !== c && this.initWithDuration(c)
    },
    getElapsed: function () {
        return this._elapsed
    },
    initWithDuration: function (c) {
        this._duration = 0 === c ? cc.FLT_EPSILON : c;
        this._elapsed =
            0;
        return this._firstTick = !0
    },
    isDone: function () {
        return this._elapsed >= this._duration
    },
    _cloneDecoration: function (c) {
        c._repeatForever = this._repeatForever;
        c._speed = this._speed;
        c._timesForRepeat = this._timesForRepeat;
        c._easeList = this._easeList;
        c._speedMethod = this._speedMethod;
        c._repeatMethod = this._repeatMethod
    },
    _reverseEaseList: function (c) {
        if (this._easeList) {
            c._easeList = [];
            for (var d = 0; d < this._easeList.length; d++)c._easeList.push(this._easeList[d].reverse())
        }
    },
    clone: function () {
        var c = new cc.ActionInterval(this._duration);
        this._cloneDecoration(c);
        return c
    },
    easing: function (c) {
        this._easeList ? this._easeList.length = 0 : this._easeList = [];
        for (var d = 0; d < arguments.length; d++)this._easeList.push(arguments[d]);
        return this
    },
    _computeEaseTime: function (c) {
        var d = this._easeList;
        if (!d || 0 === d.length)return c;
        for (var e = 0, f = d.length; e < f; e++)c = d[e].easing(c);
        return c
    },
    step: function (c) {
        this._firstTick ? (this._firstTick = !1, this._elapsed = 0) : this._elapsed += c;
        c = this._elapsed / (1.192092896E-7 < this._duration ? this._duration : 1.192092896E-7);
        c = 1 > c ?
            c : 1;
        this.update(0 < c ? c : 0);
        this._repeatMethod && 1 < this._timesForRepeat && this.isDone() && (this._repeatForever || this._timesForRepeat--, this.startWithTarget(this.target), this.step(this._elapsed - this._duration))
    },
    startWithTarget: function (c) {
        cc.Action.prototype.startWithTarget.call(this, c);
        this._elapsed = 0;
        this._firstTick = !0
    },
    reverse: function () {
        cc.log("cc.IntervalAction: reverse not implemented.");
        return null
    },
    setAmplitudeRate: function (c) {
        cc.log("cc.ActionInterval.setAmplitudeRate(): it should be overridden in subclass.")
    },
    getAmplitudeRate: function () {
        cc.log("cc.ActionInterval.getAmplitudeRate(): it should be overridden in subclass.");
        return 0
    },
    speed: function (c) {
        if (0 >= c)return cc.log("The speed parameter error"), this;
        this._speedMethod = !0;
        this._speed *= c;
        return this
    },
    getSpeed: function () {
        return this._speed
    },
    setSpeed: function (c) {
        this._speed = c;
        return this
    },
    repeat: function (c) {
        c = Math.round(c);
        if (isNaN(c) || 1 > c)return cc.log("The repeat parameter error"), this;
        this._repeatMethod = !0;
        this._timesForRepeat *= c;
        return this
    },
    repeatForever: function () {
        this._repeatMethod = !0;
        this._timesForRepeat = this.MAX_VALUE;
        this._repeatForever = !0;
        return this
    }
});
cc.actionInterval = function (c) {
    return new cc.ActionInterval(c)
};
cc.ActionInterval.create = cc.actionInterval;
cc.Sequence = cc.ActionInterval.extend({
    _actions: null, _split: null, _last: 0, ctor: function (c) {
        cc.ActionInterval.prototype.ctor.call(this);
        this._actions = [];
        var d = c instanceof Array ? c : arguments, e = d.length - 1;
        0 <= e && null == d[e] && cc.log("parameters should not be ending with null in Javascript");
        if (0 <= e) {
            for (var f = d[0], g = 1; g < e; g++)d[g] && (f = cc.Sequence._actionOneTwo(f, d[g]));
            this.initWithTwoActions(f, d[e])
        }
    }, initWithTwoActions: function (c, d) {
        if (!c || !d)throw Error("cc.Sequence.initWithTwoActions(): arguments must all be non nil");
        this.initWithDuration(c._duration + d._duration);
        this._actions[0] = c;
        this._actions[1] = d;
        return !0
    }, clone: function () {
        var c = new cc.Sequence;
        this._cloneDecoration(c);
        c.initWithTwoActions(this._actions[0].clone(), this._actions[1].clone());
        return c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        this._split = this._actions[0]._duration / this._duration;
        this._last = -1
    }, stop: function () {
        -1 !== this._last && this._actions[this._last].stop();
        cc.Action.prototype.stop.call(this)
    }, update: function (c) {
        var d =
            0, e = this._split, f = this._actions, g = this._last;
        c = this._computeEaseTime(c);
        c < e ? (c = 0 !== e ? c / e : 1, 0 === d && 1 === g && (f[1].update(0), f[1].stop())) : (d = 1, c = 1 === e ? 1 : (c - e) / (1 - e), -1 === g && (f[0].startWithTarget(this.target), f[0].update(1), f[0].stop()), g || (f[0].update(1), f[0].stop()));
        f = f[d];
        g === d && f.isDone() || (g !== d && f.startWithTarget(this.target), c *= f._timesForRepeat, f.update(1 < c ? c % 1 : c), this._last = d)
    }, reverse: function () {
        var c = cc.Sequence._actionOneTwo(this._actions[1].reverse(), this._actions[0].reverse());
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }
});
cc.sequence = function (c) {
    var d = c instanceof Array ? c : arguments;
    0 < d.length && null == d[d.length - 1] && cc.log("parameters should not be ending with null in Javascript");
    for (var e, f, g, h; d && 0 < d.length;)for (f = Array.prototype.shift.call(d), h = f._timesForRepeat || 1, f._repeatMethod = !1, f._timesForRepeat = 1, g = 0, e || (e = f, g = 1), g; g < h; g++)e = cc.Sequence._actionOneTwo(e, f);
    return e
};
cc.Sequence.create = cc.sequence;
cc.Sequence._actionOneTwo = function (c, d) {
    var e = new cc.Sequence;
    e.initWithTwoActions(c, d);
    return e
};
cc.Repeat = cc.ActionInterval.extend({
    _times: 0, _total: 0, _nextDt: 0, _actionInstant: !1, _innerAction: null, ctor: function (c, d) {
        cc.ActionInterval.prototype.ctor.call(this);
        void 0 !== d && this.initWithAction(c, d)
    }, initWithAction: function (c, d) {
        return this.initWithDuration(c._duration * d) ? (this._times = d, this._innerAction = c, c instanceof cc.ActionInstant && (this._actionInstant = !0, this._times -= 1), this._total = 0, !0) : !1
    }, clone: function () {
        var c = new cc.Repeat;
        this._cloneDecoration(c);
        c.initWithAction(this._innerAction.clone(),
            this._times);
        return c
    }, startWithTarget: function (c) {
        this._total = 0;
        this._nextDt = this._innerAction._duration / this._duration;
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        this._innerAction.startWithTarget(c)
    }, stop: function () {
        this._innerAction.stop();
        cc.Action.prototype.stop.call(this)
    }, update: function (c) {
        c = this._computeEaseTime(c);
        var d = this._innerAction, e = this._duration, f = this._times, g = this._nextDt;
        if (c >= g) {
            for (; c > g && this._total < f;)d.update(1), this._total++, d.stop(), d.startWithTarget(this.target),
                this._nextDt = g += d._duration / e;
            1 <= c && this._total < f && this._total++;
            this._actionInstant || (this._total === f ? (d.update(1), d.stop()) : d.update(c - (g - d._duration / e)))
        } else d.update(c * f % 1)
    }, isDone: function () {
        return this._total === this._times
    }, reverse: function () {
        var c = new cc.Repeat(this._innerAction.reverse(), this._times);
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }, setInnerAction: function (c) {
        this._innerAction !== c && (this._innerAction = c)
    }, getInnerAction: function () {
        return this._innerAction
    }
});
cc.repeat = function (c, d) {
    return new cc.Repeat(c, d)
};
cc.Repeat.create = cc.repeat;
cc.RepeatForever = cc.ActionInterval.extend({
    _innerAction: null, ctor: function (c) {
        cc.ActionInterval.prototype.ctor.call(this);
        this._innerAction = null;
        c && this.initWithAction(c)
    }, initWithAction: function (c) {
        if (!c)throw Error("cc.RepeatForever.initWithAction(): action must be non null");
        this._innerAction = c;
        return !0
    }, clone: function () {
        var c = new cc.RepeatForever;
        this._cloneDecoration(c);
        c.initWithAction(this._innerAction.clone());
        return c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this,
            c);
        this._innerAction.startWithTarget(c)
    }, step: function (c) {
        var d = this._innerAction;
        d.step(c);
        d.isDone() && (d.startWithTarget(this.target), d.step(d.getElapsed() - d._duration))
    }, isDone: function () {
        return !1
    }, reverse: function () {
        var c = new cc.RepeatForever(this._innerAction.reverse());
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }, setInnerAction: function (c) {
        this._innerAction !== c && (this._innerAction = c)
    }, getInnerAction: function () {
        return this._innerAction
    }
});
cc.repeatForever = function (c) {
    return new cc.RepeatForever(c)
};
cc.RepeatForever.create = cc.repeatForever;
cc.Spawn = cc.ActionInterval.extend({
    _one: null, _two: null, ctor: function (c) {
        cc.ActionInterval.prototype.ctor.call(this);
        this._two = this._one = null;
        var d = c instanceof Array ? c : arguments, e = d.length - 1;
        0 <= e && null == d[e] && cc.log("parameters should not be ending with null in Javascript");
        if (0 <= e) {
            for (var f = d[0], g = 1; g < e; g++)d[g] && (f = cc.Spawn._actionOneTwo(f, d[g]));
            this.initWithTwoActions(f, d[e])
        }
    }, initWithTwoActions: function (c, d) {
        if (!c || !d)throw Error("cc.Spawn.initWithTwoActions(): arguments must all be non null");
        var e =
            !1, f = c._duration, g = d._duration;
        this.initWithDuration(Math.max(f, g)) && (this._one = c, this._two = d, f > g ? this._two = cc.Sequence._actionOneTwo(d, cc.delayTime(f - g)) : f < g && (this._one = cc.Sequence._actionOneTwo(c, cc.delayTime(g - f))), e = !0);
        return e
    }, clone: function () {
        var c = new cc.Spawn;
        this._cloneDecoration(c);
        c.initWithTwoActions(this._one.clone(), this._two.clone());
        return c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        this._one.startWithTarget(c);
        this._two.startWithTarget(c)
    },
    stop: function () {
        this._one.stop();
        this._two.stop();
        cc.Action.prototype.stop.call(this)
    }, update: function (c) {
        c = this._computeEaseTime(c);
        this._one && this._one.update(c);
        this._two && this._two.update(c)
    }, reverse: function () {
        var c = cc.Spawn._actionOneTwo(this._one.reverse(), this._two.reverse());
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }
});
cc.spawn = function (c) {
    var d = c instanceof Array ? c : arguments;
    0 < d.length && null == d[d.length - 1] && cc.log("parameters should not be ending with null in Javascript");
    for (var e = d[0], f = 1; f < d.length; f++)null != d[f] && (e = cc.Spawn._actionOneTwo(e, d[f]));
    return e
};
cc.Spawn.create = cc.spawn;
cc.Spawn._actionOneTwo = function (c, d) {
    var e = new cc.Spawn;
    e.initWithTwoActions(c, d);
    return e
};
cc.RotateTo = cc.ActionInterval.extend({
    _dstAngleX: 0,
    _startAngleX: 0,
    _diffAngleX: 0,
    _dstAngleY: 0,
    _startAngleY: 0,
    _diffAngleY: 0,
    ctor: function (c, d, e) {
        cc.ActionInterval.prototype.ctor.call(this);
        void 0 !== d && this.initWithDuration(c, d, e)
    },
    initWithDuration: function (c, d, e) {
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (this._dstAngleX = d || 0, this._dstAngleY = e || this._dstAngleX, !0) : !1
    },
    clone: function () {
        var c = new cc.RotateTo;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._dstAngleX,
            this._dstAngleY);
        return c
    },
    startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        var d = c.rotationX % 360, e = this._dstAngleX - d;
        180 < e && (e -= 360);
        -180 > e && (e += 360);
        this._startAngleX = d;
        this._diffAngleX = e;
        this._startAngleY = c.rotationY % 360;
        c = this._dstAngleY - this._startAngleY;
        180 < c && (c -= 360);
        -180 > c && (c += 360);
        this._diffAngleY = c
    },
    reverse: function () {
        cc.log("cc.RotateTo.reverse(): it should be overridden in subclass.")
    },
    update: function (c) {
        c = this._computeEaseTime(c);
        this.target && (this.target.rotationX =
            this._startAngleX + this._diffAngleX * c, this.target.rotationY = this._startAngleY + this._diffAngleY * c)
    }
});
cc.rotateTo = function (c, d, e) {
    return new cc.RotateTo(c, d, e)
};
cc.RotateTo.create = cc.rotateTo;
cc.RotateBy = cc.ActionInterval.extend({
    _angleX: 0, _startAngleX: 0, _angleY: 0, _startAngleY: 0, ctor: function (c, d, e) {
        cc.ActionInterval.prototype.ctor.call(this);
        void 0 !== d && this.initWithDuration(c, d, e)
    }, initWithDuration: function (c, d, e) {
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (this._angleX = d || 0, this._angleY = e || this._angleX, !0) : !1
    }, clone: function () {
        var c = new cc.RotateBy;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._angleX, this._angleY);
        return c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this,
            c);
        this._startAngleX = c.rotationX;
        this._startAngleY = c.rotationY
    }, update: function (c) {
        c = this._computeEaseTime(c);
        this.target && (this.target.rotationX = this._startAngleX + this._angleX * c, this.target.rotationY = this._startAngleY + this._angleY * c)
    }, reverse: function () {
        var c = new cc.RotateBy(this._duration, -this._angleX, -this._angleY);
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }
});
cc.rotateBy = function (c, d, e) {
    return new cc.RotateBy(c, d, e)
};
cc.RotateBy.create = cc.rotateBy;
cc.MoveBy = cc.ActionInterval.extend({
    _positionDelta: null, _startPosition: null, _previousPosition: null, ctor: function (c, d, e) {
        cc.ActionInterval.prototype.ctor.call(this);
        this._positionDelta = cc.p(0, 0);
        this._startPosition = cc.p(0, 0);
        this._previousPosition = cc.p(0, 0);
        void 0 !== d && this.initWithDuration(c, d, e)
    }, initWithDuration: function (c, d, e) {
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (void 0 !== d.x && (e = d.y, d = d.x), this._positionDelta.x = d, this._positionDelta.y = e, !0) : !1
    }, clone: function () {
        var c =
            new cc.MoveBy;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._positionDelta);
        return c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        var d = c.getPositionX();
        c = c.getPositionY();
        this._previousPosition.x = d;
        this._previousPosition.y = c;
        this._startPosition.x = d;
        this._startPosition.y = c
    }, update: function (c) {
        c = this._computeEaseTime(c);
        if (this.target) {
            var d = this._positionDelta.x * c;
            c *= this._positionDelta.y;
            var e = this._startPosition;
            if (cc.ENABLE_STACKABLE_ACTIONS) {
                var f =
                    this.target.getPositionX(), g = this.target.getPositionY(), h = this._previousPosition;
                e.x = e.x + f - h.x;
                e.y = e.y + g - h.y;
                d += e.x;
                c += e.y;
                h.x = d;
                h.y = c;
                this.target.setPosition(d, c)
            } else this.target.setPosition(e.x + d, e.y + c)
        }
    }, reverse: function () {
        var c = new cc.MoveBy(this._duration, cc.p(-this._positionDelta.x, -this._positionDelta.y));
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }
});
cc.moveBy = function (c, d, e) {
    return new cc.MoveBy(c, d, e)
};
cc.MoveBy.create = cc.moveBy;
cc.MoveTo = cc.MoveBy.extend({
    _endPosition: null, ctor: function (c, d, e) {
        cc.MoveBy.prototype.ctor.call(this);
        this._endPosition = cc.p(0, 0);
        void 0 !== d && this.initWithDuration(c, d, e)
    }, initWithDuration: function (c, d, e) {
        return cc.MoveBy.prototype.initWithDuration.call(this, c, d, e) ? (void 0 !== d.x && (e = d.y, d = d.x), this._endPosition.x = d, this._endPosition.y = e, !0) : !1
    }, clone: function () {
        var c = new cc.MoveTo;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._endPosition);
        return c
    }, startWithTarget: function (c) {
        cc.MoveBy.prototype.startWithTarget.call(this,
            c);
        this._positionDelta.x = this._endPosition.x - c.getPositionX();
        this._positionDelta.y = this._endPosition.y - c.getPositionY()
    }
});
cc.moveTo = function (c, d, e) {
    return new cc.MoveTo(c, d, e)
};
cc.MoveTo.create = cc.moveTo;
cc.SkewTo = cc.ActionInterval.extend({
    _skewX: 0,
    _skewY: 0,
    _startSkewX: 0,
    _startSkewY: 0,
    _endSkewX: 0,
    _endSkewY: 0,
    _deltaX: 0,
    _deltaY: 0,
    ctor: function (c, d, e) {
        cc.ActionInterval.prototype.ctor.call(this);
        void 0 !== e && this.initWithDuration(c, d, e)
    },
    initWithDuration: function (c, d, e) {
        var f = !1;
        cc.ActionInterval.prototype.initWithDuration.call(this, c) && (this._endSkewX = d, this._endSkewY = e, f = !0);
        return f
    },
    clone: function () {
        var c = new cc.SkewTo;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._endSkewX, this._endSkewY);
        return c
    },
    startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        this._startSkewX = c.skewX % 180;
        this._deltaX = this._endSkewX - this._startSkewX;
        180 < this._deltaX && (this._deltaX -= 360);
        -180 > this._deltaX && (this._deltaX += 360);
        this._startSkewY = c.skewY % 360;
        this._deltaY = this._endSkewY - this._startSkewY;
        180 < this._deltaY && (this._deltaY -= 360);
        -180 > this._deltaY && (this._deltaY += 360)
    },
    update: function (c) {
        c = this._computeEaseTime(c);
        this.target.skewX = this._startSkewX + this._deltaX * c;
        this.target.skewY =
            this._startSkewY + this._deltaY * c
    }
});
cc.skewTo = function (c, d, e) {
    return new cc.SkewTo(c, d, e)
};
cc.SkewTo.create = cc.skewTo;
cc.SkewBy = cc.SkewTo.extend({
    ctor: function (c, d, e) {
        cc.SkewTo.prototype.ctor.call(this);
        void 0 !== e && this.initWithDuration(c, d, e)
    }, initWithDuration: function (c, d, e) {
        var f = !1;
        cc.SkewTo.prototype.initWithDuration.call(this, c, d, e) && (this._skewX = d, this._skewY = e, f = !0);
        return f
    }, clone: function () {
        var c = new cc.SkewBy;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._skewX, this._skewY);
        return c
    }, startWithTarget: function (c) {
        cc.SkewTo.prototype.startWithTarget.call(this, c);
        this._deltaX = this._skewX;
        this._deltaY = this._skewY;
        this._endSkewX = this._startSkewX + this._deltaX;
        this._endSkewY = this._startSkewY + this._deltaY
    }, reverse: function () {
        var c = new cc.SkewBy(this._duration, -this._skewX, -this._skewY);
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }
});
cc.skewBy = function (c, d, e) {
    return new cc.SkewBy(c, d, e)
};
cc.SkewBy.create = cc.skewBy;
cc.JumpBy = cc.ActionInterval.extend({
    _startPosition: null, _delta: null, _height: 0, _jumps: 0, _previousPosition: null, ctor: function (c, d, e, f, g) {
        cc.ActionInterval.prototype.ctor.call(this);
        this._startPosition = cc.p(0, 0);
        this._previousPosition = cc.p(0, 0);
        this._delta = cc.p(0, 0);
        void 0 !== f && this.initWithDuration(c, d, e, f, g)
    }, initWithDuration: function (c, d, e, f, g) {
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (void 0 === g && (g = f, f = e, e = d.y, d = d.x), this._delta.x = d, this._delta.y = e, this._height = f, this._jumps =
            g, !0) : !1
    }, clone: function () {
        var c = new cc.JumpBy;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._delta, this._height, this._jumps);
        return c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        var d = c.getPositionX();
        c = c.getPositionY();
        this._previousPosition.x = d;
        this._previousPosition.y = c;
        this._startPosition.x = d;
        this._startPosition.y = c
    }, update: function (c) {
        c = this._computeEaseTime(c);
        if (this.target) {
            var d = c * this._jumps % 1, d = 4 * this._height * d * (1 - d), d = d + this._delta.y *
                c;
            c *= this._delta.x;
            var e = this._startPosition;
            if (cc.ENABLE_STACKABLE_ACTIONS) {
                var f = this.target.getPositionX(), g = this.target.getPositionY(), h = this._previousPosition;
                e.x = e.x + f - h.x;
                e.y = e.y + g - h.y;
                c += e.x;
                d += e.y;
                h.x = c;
                h.y = d;
                this.target.setPosition(c, d)
            } else this.target.setPosition(e.x + c, e.y + d)
        }
    }, reverse: function () {
        var c = new cc.JumpBy(this._duration, cc.p(-this._delta.x, -this._delta.y), this._height, this._jumps);
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }
});
cc.jumpBy = function (c, d, e, f, g) {
    return new cc.JumpBy(c, d, e, f, g)
};
cc.JumpBy.create = cc.jumpBy;
cc.JumpTo = cc.JumpBy.extend({
    _endPosition: null, ctor: function (c, d, e, f, g) {
        cc.JumpBy.prototype.ctor.call(this);
        this._endPosition = cc.p(0, 0);
        void 0 !== f && this.initWithDuration(c, d, e, f, g)
    }, initWithDuration: function (c, d, e, f, g) {
        return cc.JumpBy.prototype.initWithDuration.call(this, c, d, e, f, g) ? (void 0 === g && (e = d.y, d = d.x), this._endPosition.x = d, this._endPosition.y = e, !0) : !1
    }, startWithTarget: function (c) {
        cc.JumpBy.prototype.startWithTarget.call(this, c);
        this._delta.x = this._endPosition.x - this._startPosition.x;
        this._delta.y =
            this._endPosition.y - this._startPosition.y
    }, clone: function () {
        var c = new cc.JumpTo;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._endPosition, this._height, this._jumps);
        return c
    }
});
cc.jumpTo = function (c, d, e, f, g) {
    return new cc.JumpTo(c, d, e, f, g)
};
cc.JumpTo.create = cc.jumpTo;
cc.bezierAt = function (c, d, e, f, g) {
    return Math.pow(1 - g, 3) * c + 3 * g * Math.pow(1 - g, 2) * d + 3 * Math.pow(g, 2) * (1 - g) * e + Math.pow(g, 3) * f
};
cc.BezierBy = cc.ActionInterval.extend({
    _config: null, _startPosition: null, _previousPosition: null, ctor: function (c, d) {
        cc.ActionInterval.prototype.ctor.call(this);
        this._config = [];
        this._startPosition = cc.p(0, 0);
        this._previousPosition = cc.p(0, 0);
        d && this.initWithDuration(c, d)
    }, initWithDuration: function (c, d) {
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (this._config = d, !0) : !1
    }, clone: function () {
        var c = new cc.BezierBy;
        this._cloneDecoration(c);
        for (var d = [], e = 0; e < this._config.length; e++) {
            var f =
                this._config[e];
            d.push(cc.p(f.x, f.y))
        }
        c.initWithDuration(this._duration, d);
        return c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        var d = c.getPositionX();
        c = c.getPositionY();
        this._previousPosition.x = d;
        this._previousPosition.y = c;
        this._startPosition.x = d;
        this._startPosition.y = c
    }, update: function (c) {
        c = this._computeEaseTime(c);
        if (this.target) {
            var d = this._config, e = d[0].y, f = d[1].y, g = d[2].y, d = cc.bezierAt(0, d[0].x, d[1].x, d[2].x, c);
            c = cc.bezierAt(0, e, f, g, c);
            e = this._startPosition;
            if (cc.ENABLE_STACKABLE_ACTIONS) {
                var f = this.target.getPositionX(), g = this.target.getPositionY(), h = this._previousPosition;
                e.x = e.x + f - h.x;
                e.y = e.y + g - h.y;
                d += e.x;
                c += e.y;
                h.x = d;
                h.y = c;
                this.target.setPosition(d, c)
            } else this.target.setPosition(e.x + d, e.y + c)
        }
    }, reverse: function () {
        var c = this._config, c = [cc.pAdd(c[1], cc.pNeg(c[2])), cc.pAdd(c[0], cc.pNeg(c[2])), cc.pNeg(c[2])], c = new cc.BezierBy(this._duration, c);
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }
});
cc.bezierBy = function (c, d) {
    return new cc.BezierBy(c, d)
};
cc.BezierBy.create = cc.bezierBy;
cc.BezierTo = cc.BezierBy.extend({
    _toConfig: null, ctor: function (c, d) {
        cc.BezierBy.prototype.ctor.call(this);
        this._toConfig = [];
        d && this.initWithDuration(c, d)
    }, initWithDuration: function (c, d) {
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (this._toConfig = d, !0) : !1
    }, clone: function () {
        var c = new cc.BezierTo;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._toConfig);
        return c
    }, startWithTarget: function (c) {
        cc.BezierBy.prototype.startWithTarget.call(this, c);
        c = this._startPosition;
        var d =
            this._toConfig, e = this._config;
        e[0] = cc.pSub(d[0], c);
        e[1] = cc.pSub(d[1], c);
        e[2] = cc.pSub(d[2], c)
    }
});
cc.bezierTo = function (c, d) {
    return new cc.BezierTo(c, d)
};
cc.BezierTo.create = cc.bezierTo;
cc.ScaleTo = cc.ActionInterval.extend({
    _scaleX: 1,
    _scaleY: 1,
    _startScaleX: 1,
    _startScaleY: 1,
    _endScaleX: 0,
    _endScaleY: 0,
    _deltaX: 0,
    _deltaY: 0,
    ctor: function (c, d, e) {
        cc.ActionInterval.prototype.ctor.call(this);
        void 0 !== d && this.initWithDuration(c, d, e)
    },
    initWithDuration: function (c, d, e) {
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (this._endScaleX = d, this._endScaleY = null != e ? e : d, !0) : !1
    },
    clone: function () {
        var c = new cc.ScaleTo;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._endScaleX,
            this._endScaleY);
        return c
    },
    startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        this._startScaleX = c.scaleX;
        this._startScaleY = c.scaleY;
        this._deltaX = this._endScaleX - this._startScaleX;
        this._deltaY = this._endScaleY - this._startScaleY
    },
    update: function (c) {
        c = this._computeEaseTime(c);
        this.target && (this.target.scaleX = this._startScaleX + this._deltaX * c, this.target.scaleY = this._startScaleY + this._deltaY * c)
    }
});
cc.scaleTo = function (c, d, e) {
    return new cc.ScaleTo(c, d, e)
};
cc.ScaleTo.create = cc.scaleTo;
cc.ScaleBy = cc.ScaleTo.extend({
    startWithTarget: function (c) {
        cc.ScaleTo.prototype.startWithTarget.call(this, c);
        this._deltaX = this._startScaleX * this._endScaleX - this._startScaleX;
        this._deltaY = this._startScaleY * this._endScaleY - this._startScaleY
    }, reverse: function () {
        var c = new cc.ScaleBy(this._duration, 1 / this._endScaleX, 1 / this._endScaleY);
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }, clone: function () {
        var c = new cc.ScaleBy;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._endScaleX,
            this._endScaleY);
        return c
    }
});
cc.scaleBy = function (c, d, e) {
    return new cc.ScaleBy(c, d, e)
};
cc.ScaleBy.create = cc.scaleBy;
cc.Blink = cc.ActionInterval.extend({
    _times: 0, _originalState: !1, ctor: function (c, d) {
        cc.ActionInterval.prototype.ctor.call(this);
        void 0 !== d && this.initWithDuration(c, d)
    }, initWithDuration: function (c, d) {
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (this._times = d, !0) : !1
    }, clone: function () {
        var c = new cc.Blink;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._times);
        return c
    }, update: function (c) {
        c = this._computeEaseTime(c);
        if (this.target && !this.isDone()) {
            var d = 1 / this._times;
            this.target.visible =
                c % d > d / 2
        }
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        this._originalState = c.visible
    }, stop: function () {
        this.target.visible = this._originalState;
        cc.ActionInterval.prototype.stop.call(this)
    }, reverse: function () {
        var c = new cc.Blink(this._duration, this._times);
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }
});
cc.blink = function (c, d) {
    return new cc.Blink(c, d)
};
cc.Blink.create = cc.blink;
cc.FadeTo = cc.ActionInterval.extend({
    _toOpacity: 0, _fromOpacity: 0, ctor: function (c, d) {
        cc.ActionInterval.prototype.ctor.call(this);
        void 0 !== d && this.initWithDuration(c, d)
    }, initWithDuration: function (c, d) {
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (this._toOpacity = d, !0) : !1
    }, clone: function () {
        var c = new cc.FadeTo;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._toOpacity);
        return c
    }, update: function (c) {
        c = this._computeEaseTime(c);
        var d = void 0 !== this._fromOpacity ? this._fromOpacity :
            255;
        this.target.opacity = d + (this._toOpacity - d) * c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        this._fromOpacity = c.opacity
    }
});
cc.fadeTo = function (c, d) {
    return new cc.FadeTo(c, d)
};
cc.FadeTo.create = cc.fadeTo;
cc.FadeIn = cc.FadeTo.extend({
    _reverseAction: null, ctor: function (c) {
        cc.FadeTo.prototype.ctor.call(this);
        null == c && (c = 0);
        this.initWithDuration(c, 255)
    }, reverse: function () {
        var c = new cc.FadeOut;
        c.initWithDuration(this._duration, 0);
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }, clone: function () {
        var c = new cc.FadeIn;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._toOpacity);
        return c
    }, startWithTarget: function (c) {
        this._reverseAction && (this._toOpacity = this._reverseAction._fromOpacity);
        cc.FadeTo.prototype.startWithTarget.call(this, c)
    }
});
cc.fadeIn = function (c) {
    return new cc.FadeIn(c)
};
cc.FadeIn.create = cc.fadeIn;
cc.FadeOut = cc.FadeTo.extend({
    ctor: function (c) {
        cc.FadeTo.prototype.ctor.call(this);
        null == c && (c = 0);
        this.initWithDuration(c, 0)
    }, reverse: function () {
        var c = new cc.FadeIn;
        c._reverseAction = this;
        c.initWithDuration(this._duration, 255);
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }, clone: function () {
        var c = new cc.FadeOut;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._toOpacity);
        return c
    }
});
cc.fadeOut = function (c) {
    return new cc.FadeOut(c)
};
cc.FadeOut.create = cc.fadeOut;
cc.TintTo = cc.ActionInterval.extend({
    _to: null, _from: null, ctor: function (c, d, e, f) {
        cc.ActionInterval.prototype.ctor.call(this);
        this._to = cc.color(0, 0, 0);
        this._from = cc.color(0, 0, 0);
        void 0 !== f && this.initWithDuration(c, d, e, f)
    }, initWithDuration: function (c, d, e, f) {
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (this._to = cc.color(d, e, f), !0) : !1
    }, clone: function () {
        var c = new cc.TintTo;
        this._cloneDecoration(c);
        var d = this._to;
        c.initWithDuration(this._duration, d.r, d.g, d.b);
        return c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this,
            c);
        this._from = this.target.color
    }, update: function (c) {
        c = this._computeEaseTime(c);
        var d = this._from, e = this._to;
        d && this.target.setColor(cc.color(d.r + (e.r - d.r) * c, d.g + (e.g - d.g) * c, d.b + (e.b - d.b) * c))
    }
});
cc.tintTo = function (c, d, e, f) {
    return new cc.TintTo(c, d, e, f)
};
cc.TintTo.create = cc.tintTo;
cc.TintBy = cc.ActionInterval.extend({
    _deltaR: 0, _deltaG: 0, _deltaB: 0, _fromR: 0, _fromG: 0, _fromB: 0, ctor: function (c, d, e, f) {
        cc.ActionInterval.prototype.ctor.call(this);
        void 0 !== f && this.initWithDuration(c, d, e, f)
    }, initWithDuration: function (c, d, e, f) {
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (this._deltaR = d, this._deltaG = e, this._deltaB = f, !0) : !1
    }, clone: function () {
        var c = new cc.TintBy;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration, this._deltaR, this._deltaG, this._deltaB);
        return c
    },
    startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        c = c.color;
        this._fromR = c.r;
        this._fromG = c.g;
        this._fromB = c.b
    }, update: function (c) {
        c = this._computeEaseTime(c);
        this.target.color = cc.color(this._fromR + this._deltaR * c, this._fromG + this._deltaG * c, this._fromB + this._deltaB * c)
    }, reverse: function () {
        var c = new cc.TintBy(this._duration, -this._deltaR, -this._deltaG, -this._deltaB);
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }
});
cc.tintBy = function (c, d, e, f) {
    return new cc.TintBy(c, d, e, f)
};
cc.TintBy.create = cc.tintBy;
cc.DelayTime = cc.ActionInterval.extend({
    update: function (c) {
    }, reverse: function () {
        var c = new cc.DelayTime(this._duration);
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    }, clone: function () {
        var c = new cc.DelayTime;
        this._cloneDecoration(c);
        c.initWithDuration(this._duration);
        return c
    }
});
cc.delayTime = function (c) {
    return new cc.DelayTime(c)
};
cc.DelayTime.create = cc.delayTime;
cc.ReverseTime = cc.ActionInterval.extend({
    _other: null, ctor: function (c) {
        cc.ActionInterval.prototype.ctor.call(this);
        this._other = null;
        c && this.initWithAction(c)
    }, initWithAction: function (c) {
        if (!c)throw Error("cc.ReverseTime.initWithAction(): action must be non null");
        if (c === this._other)throw Error("cc.ReverseTime.initWithAction(): the action was already passed in.");
        return cc.ActionInterval.prototype.initWithDuration.call(this, c._duration) ? (this._other = c, !0) : !1
    }, clone: function () {
        var c = new cc.ReverseTime;
        this._cloneDecoration(c);
        c.initWithAction(this._other.clone());
        return c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        this._other.startWithTarget(c)
    }, update: function (c) {
        c = this._computeEaseTime(c);
        this._other && this._other.update(1 - c)
    }, reverse: function () {
        return this._other.clone()
    }, stop: function () {
        this._other.stop();
        cc.Action.prototype.stop.call(this)
    }
});
cc.reverseTime = function (c) {
    return new cc.ReverseTime(c)
};
cc.ReverseTime.create = cc.reverseTime;
cc.Animate = cc.ActionInterval.extend({
    _animation: null,
    _nextFrame: 0,
    _origFrame: null,
    _executedLoops: 0,
    _splitTimes: null,
    _currFrameIndex: 0,
    ctor: function (c) {
        cc.ActionInterval.prototype.ctor.call(this);
        this._splitTimes = [];
        c && this.initWithAnimation(c)
    },
    getAnimation: function () {
        return this._animation
    },
    setAnimation: function (c) {
        this._animation = c
    },
    getCurrentFrameIndex: function () {
        return this._currFrameIndex
    },
    initWithAnimation: function (c) {
        if (!c)throw Error("cc.Animate.initWithAnimation(): animation must be non-NULL");
        var d = c.getDuration();
        if (this.initWithDuration(d * c.getLoops())) {
            this._nextFrame = 0;
            this.setAnimation(c);
            this._origFrame = null;
            this._executedLoops = 0;
            var e = this._splitTimes, f = e.length = 0, g = d / c.getTotalDelayUnits();
            c = c.getFrames();
            cc.arrayVerifyType(c, cc.AnimationFrame);
            for (var h = 0; h < c.length; h++) {
                var k = f * g / d, f = f + c[h].getDelayUnits();
                e.push(k)
            }
            return !0
        }
        return !1
    },
    clone: function () {
        var c = new cc.Animate;
        this._cloneDecoration(c);
        c.initWithAnimation(this._animation.clone());
        return c
    },
    startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this,
            c);
        this._animation.getRestoreOriginalFrame() && (this._origFrame = c.displayFrame());
        this._executedLoops = this._nextFrame = 0
    },
    update: function (c) {
        c = this._computeEaseTime(c);
        1 > c && (c *= this._animation.getLoops(), (0 | c) > this._executedLoops && (this._nextFrame = 0, this._executedLoops++), c %= 1);
        for (var d = this._animation.getFrames(), e = d.length, f = this._splitTimes, g = this._nextFrame; g < e; g++)if (f[g] <= c)_currFrameIndex = g, this.target.setSpriteFrame(d[_currFrameIndex].getSpriteFrame()), this._nextFrame = g + 1; else break
    },
    reverse: function () {
        var c =
            this._animation, d = c.getFrames(), e = [];
        cc.arrayVerifyType(d, cc.AnimationFrame);
        if (0 < d.length)for (var f = d.length - 1; 0 <= f; f--) {
            var g = d[f];
            if (!g)break;
            e.push(g.clone())
        }
        d = new cc.Animation(e, c.getDelayPerUnit(), c.getLoops());
        d.setRestoreOriginalFrame(c.getRestoreOriginalFrame());
        c = new cc.Animate(d);
        this._cloneDecoration(c);
        this._reverseEaseList(c);
        return c
    },
    stop: function () {
        this._animation.getRestoreOriginalFrame() && this.target && this.target.setSpriteFrame(this._origFrame);
        cc.Action.prototype.stop.call(this)
    }
});
cc.animate = function (c) {
    return new cc.Animate(c)
};
cc.Animate.create = cc.animate;
cc.TargetedAction = cc.ActionInterval.extend({
    _action: null, _forcedTarget: null, ctor: function (c, d) {
        cc.ActionInterval.prototype.ctor.call(this);
        d && this.initWithTarget(c, d)
    }, initWithTarget: function (c, d) {
        return this.initWithDuration(d._duration) ? (this._forcedTarget = c, this._action = d, !0) : !1
    }, clone: function () {
        var c = new cc.TargetedAction;
        this._cloneDecoration(c);
        c.initWithTarget(this._forcedTarget, this._action.clone());
        return c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        this._action.startWithTarget(this._forcedTarget)
    }, stop: function () {
        this._action.stop()
    }, update: function (c) {
        c = this._computeEaseTime(c);
        this._action.update(c)
    }, getForcedTarget: function () {
        return this._forcedTarget
    }, setForcedTarget: function (c) {
        this._forcedTarget !== c && (this._forcedTarget = c)
    }
});
cc.targetedAction = function (c, d) {
    return new cc.TargetedAction(c, d)
};
cc.TargetedAction.create = cc.targetedAction;
cc.ActionInstant = cc.FiniteTimeAction.extend({
    isDone: function () {
        return !0
    }, step: function (c) {
        this.update(1)
    }, update: function (c) {
    }, reverse: function () {
        return this.clone()
    }, clone: function () {
        return new cc.ActionInstant
    }
});
cc.Show = cc.ActionInstant.extend({
    update: function (c) {
        this.target.visible = !0
    }, reverse: function () {
        return new cc.Hide
    }, clone: function () {
        return new cc.Show
    }
});
cc.show = function () {
    return new cc.Show
};
cc.Show.create = cc.show;
cc.Hide = cc.ActionInstant.extend({
    update: function (c) {
        this.target.visible = !1
    }, reverse: function () {
        return new cc.Show
    }, clone: function () {
        return new cc.Hide
    }
});
cc.hide = function () {
    return new cc.Hide
};
cc.Hide.create = cc.hide;
cc.ToggleVisibility = cc.ActionInstant.extend({
    update: function (c) {
        this.target.visible = !this.target.visible
    }, reverse: function () {
        return new cc.ToggleVisibility
    }, clone: function () {
        return new cc.ToggleVisibility
    }
});
cc.toggleVisibility = function () {
    return new cc.ToggleVisibility
};
cc.ToggleVisibility.create = cc.toggleVisibility;
cc.RemoveSelf = cc.ActionInstant.extend({
    _isNeedCleanUp: !0, ctor: function (c) {
        cc.FiniteTimeAction.prototype.ctor.call(this);
        void 0 !== c && this.init(c)
    }, update: function (c) {
        this.target.removeFromParent(this._isNeedCleanUp)
    }, init: function (c) {
        this._isNeedCleanUp = c;
        return !0
    }, reverse: function () {
        return new cc.RemoveSelf(this._isNeedCleanUp)
    }, clone: function () {
        return new cc.RemoveSelf(this._isNeedCleanUp)
    }
});
cc.removeSelf = function (c) {
    return new cc.RemoveSelf(c)
};
cc.RemoveSelf.create = cc.removeSelf;
cc.FlipX = cc.ActionInstant.extend({
    _flippedX: !1, ctor: function (c) {
        cc.FiniteTimeAction.prototype.ctor.call(this);
        this._flippedX = !1;
        void 0 !== c && this.initWithFlipX(c)
    }, initWithFlipX: function (c) {
        this._flippedX = c;
        return !0
    }, update: function (c) {
        this.target.flippedX = this._flippedX
    }, reverse: function () {
        return new cc.FlipX(!this._flippedX)
    }, clone: function () {
        var c = new cc.FlipX;
        c.initWithFlipX(this._flippedX);
        return c
    }
});
cc.flipX = function (c) {
    return new cc.FlipX(c)
};
cc.FlipX.create = cc.flipX;
cc.FlipY = cc.ActionInstant.extend({
    _flippedY: !1, ctor: function (c) {
        cc.FiniteTimeAction.prototype.ctor.call(this);
        this._flippedY = !1;
        void 0 !== c && this.initWithFlipY(c)
    }, initWithFlipY: function (c) {
        this._flippedY = c;
        return !0
    }, update: function (c) {
        this.target.flippedY = this._flippedY
    }, reverse: function () {
        return new cc.FlipY(!this._flippedY)
    }, clone: function () {
        var c = new cc.FlipY;
        c.initWithFlipY(this._flippedY);
        return c
    }
});
cc.flipY = function (c) {
    return new cc.FlipY(c)
};
cc.FlipY.create = cc.flipY;
cc.Place = cc.ActionInstant.extend({
    _x: 0, _y: 0, ctor: function (c, d) {
        cc.FiniteTimeAction.prototype.ctor.call(this);
        this._y = this._x = 0;
        void 0 !== c && (void 0 !== c.x && (d = c.y, c = c.x), this.initWithPosition(c, d))
    }, initWithPosition: function (c, d) {
        this._x = c;
        this._y = d;
        return !0
    }, update: function (c) {
        this.target.setPosition(this._x, this._y)
    }, clone: function () {
        var c = new cc.Place;
        c.initWithPosition(this._x, this._y);
        return c
    }
});
cc.place = function (c, d) {
    return new cc.Place(c, d)
};
cc.Place.create = cc.place;
cc.CallFunc = cc.ActionInstant.extend({
    _selectorTarget: null, _function: null, _data: null, ctor: function (c, d, e) {
        cc.FiniteTimeAction.prototype.ctor.call(this);
        this.initWithFunction(c, d, e)
    }, initWithFunction: function (c, d, e) {
        c && (this._function = c);
        d && (this._selectorTarget = d);
        void 0 !== e && (this._data = e);
        return !0
    }, execute: function () {
        this._function && this._function.call(this._selectorTarget, this.target, this._data)
    }, update: function (c) {
        this.execute()
    }, getTargetCallback: function () {
        return this._selectorTarget
    }, setTargetCallback: function (c) {
        c !==
        this._selectorTarget && (this._selectorTarget && (this._selectorTarget = null), this._selectorTarget = c)
    }, clone: function () {
        var c = new cc.CallFunc;
        c.initWithFunction(this._function, this._selectorTarget, this._data);
        return c
    }
});
cc.callFunc = function (c, d, e) {
    return new cc.CallFunc(c, d, e)
};
cc.CallFunc.create = cc.callFunc;
cc.ActionEase = cc.ActionInterval.extend({
    _inner: null, ctor: function (c) {
        cc.ActionInterval.prototype.ctor.call(this);
        c && this.initWithAction(c)
    }, initWithAction: function (c) {
        if (!c)throw Error("cc.ActionEase.initWithAction(): action must be non nil");
        return this.initWithDuration(c.getDuration()) ? (this._inner = c, !0) : !1
    }, clone: function () {
        var c = new cc.ActionEase;
        c.initWithAction(this._inner.clone());
        return c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        this._inner.startWithTarget(this.target)
    },
    stop: function () {
        this._inner.stop();
        cc.ActionInterval.prototype.stop.call(this)
    }, update: function (c) {
        this._inner.update(c)
    }, reverse: function () {
        return new cc.ActionEase(this._inner.reverse())
    }, getInnerAction: function () {
        return this._inner
    }
});
cc.actionEase = function (c) {
    return new cc.ActionEase(c)
};
cc.ActionEase.create = cc.actionEase;
cc.EaseRateAction = cc.ActionEase.extend({
    _rate: 0, ctor: function (c, d) {
        cc.ActionEase.prototype.ctor.call(this);
        void 0 !== d && this.initWithAction(c, d)
    }, setRate: function (c) {
        this._rate = c
    }, getRate: function () {
        return this._rate
    }, initWithAction: function (c, d) {
        return cc.ActionEase.prototype.initWithAction.call(this, c) ? (this._rate = d, !0) : !1
    }, clone: function () {
        var c = new cc.EaseRateAction;
        c.initWithAction(this._inner.clone(), this._rate);
        return c
    }, reverse: function () {
        return new cc.EaseRateAction(this._inner.reverse(),
            1 / this._rate)
    }
});
cc.easeRateAction = function (c, d) {
    return new cc.EaseRateAction(c, d)
};
cc.EaseRateAction.create = cc.easeRateAction;
cc.EaseIn = cc.EaseRateAction.extend({
    update: function (c) {
        this._inner.update(Math.pow(c, this._rate))
    }, reverse: function () {
        return new cc.EaseIn(this._inner.reverse(), 1 / this._rate)
    }, clone: function () {
        var c = new cc.EaseIn;
        c.initWithAction(this._inner.clone(), this._rate);
        return c
    }
});
cc.EaseIn.create = function (c, d) {
    return new cc.EaseIn(c, d)
};
cc.easeIn = function (c) {
    return {
        _rate: c, easing: function (c) {
            return Math.pow(c, this._rate)
        }, reverse: function () {
            return cc.easeIn(1 / this._rate)
        }
    }
};
cc.EaseOut = cc.EaseRateAction.extend({
    update: function (c) {
        this._inner.update(Math.pow(c, 1 / this._rate))
    }, reverse: function () {
        return new cc.EaseOut(this._inner.reverse(), 1 / this._rate)
    }, clone: function () {
        var c = new cc.EaseOut;
        c.initWithAction(this._inner.clone(), this._rate);
        return c
    }
});
cc.EaseOut.create = function (c, d) {
    return new cc.EaseOut(c, d)
};
cc.easeOut = function (c) {
    return {
        _rate: c, easing: function (c) {
            return Math.pow(c, 1 / this._rate)
        }, reverse: function () {
            return cc.easeOut(1 / this._rate)
        }
    }
};
cc.EaseInOut = cc.EaseRateAction.extend({
    update: function (c) {
        c *= 2;
        1 > c ? this._inner.update(0.5 * Math.pow(c, this._rate)) : this._inner.update(1 - 0.5 * Math.pow(2 - c, this._rate))
    }, clone: function () {
        var c = new cc.EaseInOut;
        c.initWithAction(this._inner.clone(), this._rate);
        return c
    }, reverse: function () {
        return new cc.EaseInOut(this._inner.reverse(), this._rate)
    }
});
cc.EaseInOut.create = function (c, d) {
    return new cc.EaseInOut(c, d)
};
cc.easeInOut = function (c) {
    return {
        _rate: c, easing: function (c) {
            c *= 2;
            return 1 > c ? 0.5 * Math.pow(c, this._rate) : 1 - 0.5 * Math.pow(2 - c, this._rate)
        }, reverse: function () {
            return cc.easeInOut(this._rate)
        }
    }
};
cc.EaseExponentialIn = cc.ActionEase.extend({
    update: function (c) {
        this._inner.update(0 === c ? 0 : Math.pow(2, 10 * (c - 1)))
    }, reverse: function () {
        return new cc.EaseExponentialOut(this._inner.reverse())
    }, clone: function () {
        var c = new cc.EaseExponentialIn;
        c.initWithAction(this._inner.clone());
        return c
    }
});
cc.EaseExponentialIn.create = function (c) {
    return new cc.EaseExponentialIn(c)
};
cc._easeExponentialInObj = {
    easing: function (c) {
        return 0 === c ? 0 : Math.pow(2, 10 * (c - 1))
    }, reverse: function () {
        return cc._easeExponentialOutObj
    }
};
cc.easeExponentialIn = function () {
    return cc._easeExponentialInObj
};
cc.EaseExponentialOut = cc.ActionEase.extend({
    update: function (c) {
        this._inner.update(1 === c ? 1 : -Math.pow(2, -10 * c) + 1)
    }, reverse: function () {
        return new cc.EaseExponentialIn(this._inner.reverse())
    }, clone: function () {
        var c = new cc.EaseExponentialOut;
        c.initWithAction(this._inner.clone());
        return c
    }
});
cc.EaseExponentialOut.create = function (c) {
    return new cc.EaseExponentialOut(c)
};
cc._easeExponentialOutObj = {
    easing: function (c) {
        return 1 === c ? 1 : -Math.pow(2, -10 * c) + 1
    }, reverse: function () {
        return cc._easeExponentialInObj
    }
};
cc.easeExponentialOut = function () {
    return cc._easeExponentialOutObj
};
cc.EaseExponentialInOut = cc.ActionEase.extend({
    update: function (c) {
        1 !== c && 0 !== c && (c *= 2, c = 1 > c ? 0.5 * Math.pow(2, 10 * (c - 1)) : 0.5 * (-Math.pow(2, -10 * (c - 1)) + 2));
        this._inner.update(c)
    }, reverse: function () {
        return new cc.EaseExponentialInOut(this._inner.reverse())
    }, clone: function () {
        var c = new cc.EaseExponentialInOut;
        c.initWithAction(this._inner.clone());
        return c
    }
});
cc.EaseExponentialInOut.create = function (c) {
    return new cc.EaseExponentialInOut(c)
};
cc._easeExponentialInOutObj = {
    easing: function (c) {
        return 1 !== c && 0 !== c ? (c *= 2, 1 > c ? 0.5 * Math.pow(2, 10 * (c - 1)) : 0.5 * (-Math.pow(2, -10 * (c - 1)) + 2)) : c
    }, reverse: function () {
        return cc._easeExponentialInOutObj
    }
};
cc.easeExponentialInOut = function () {
    return cc._easeExponentialInOutObj
};
cc.EaseSineIn = cc.ActionEase.extend({
    update: function (c) {
        c = 0 === c || 1 === c ? c : -1 * Math.cos(c * Math.PI / 2) + 1;
        this._inner.update(c)
    }, reverse: function () {
        return new cc.EaseSineOut(this._inner.reverse())
    }, clone: function () {
        var c = new cc.EaseSineIn;
        c.initWithAction(this._inner.clone());
        return c
    }
});
cc.EaseSineIn.create = function (c) {
    return new cc.EaseSineIn(c)
};
cc._easeSineInObj = {
    easing: function (c) {
        return 0 === c || 1 === c ? c : -1 * Math.cos(c * Math.PI / 2) + 1
    }, reverse: function () {
        return cc._easeSineOutObj
    }
};
cc.easeSineIn = function () {
    return cc._easeSineInObj
};
cc.EaseSineOut = cc.ActionEase.extend({
    update: function (c) {
        c = 0 === c || 1 === c ? c : Math.sin(c * Math.PI / 2);
        this._inner.update(c)
    }, reverse: function () {
        return new cc.EaseSineIn(this._inner.reverse())
    }, clone: function () {
        var c = new cc.EaseSineOut;
        c.initWithAction(this._inner.clone());
        return c
    }
});
cc.EaseSineOut.create = function (c) {
    return new cc.EaseSineOut(c)
};
cc._easeSineOutObj = {
    easing: function (c) {
        return 0 === c || 1 === c ? c : Math.sin(c * Math.PI / 2)
    }, reverse: function () {
        return cc._easeSineInObj
    }
};
cc.easeSineOut = function () {
    return cc._easeSineOutObj
};
cc.EaseSineInOut = cc.ActionEase.extend({
    update: function (c) {
        c = 0 === c || 1 === c ? c : -0.5 * (Math.cos(Math.PI * c) - 1);
        this._inner.update(c)
    }, clone: function () {
        var c = new cc.EaseSineInOut;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseSineInOut(this._inner.reverse())
    }
});
cc.EaseSineInOut.create = function (c) {
    return new cc.EaseSineInOut(c)
};
cc._easeSineInOutObj = {
    easing: function (c) {
        return 0 === c || 1 === c ? c : -0.5 * (Math.cos(Math.PI * c) - 1)
    }, reverse: function () {
        return cc._easeSineInOutObj
    }
};
cc.easeSineInOut = function () {
    return cc._easeSineInOutObj
};
cc.EaseElastic = cc.ActionEase.extend({
    _period: 0.3, ctor: function (c, d) {
        cc.ActionEase.prototype.ctor.call(this);
        c && this.initWithAction(c, d)
    }, getPeriod: function () {
        return this._period
    }, setPeriod: function (c) {
        this._period = c
    }, initWithAction: function (c, d) {
        cc.ActionEase.prototype.initWithAction.call(this, c);
        this._period = null == d ? 0.3 : d;
        return !0
    }, reverse: function () {
        cc.log("cc.EaseElastic.reverse(): it should be overridden in subclass.");
        return null
    }, clone: function () {
        var c = new cc.EaseElastic;
        c.initWithAction(this._inner.clone(),
            this._period);
        return c
    }
});
cc.EaseElastic.create = function (c, d) {
    return new cc.EaseElastic(c, d)
};
cc.EaseElasticIn = cc.EaseElastic.extend({
    update: function (c) {
        var d = 0;
        0 === c || 1 === c ? d = c : (d = this._period / 4, c -= 1, d = -Math.pow(2, 10 * c) * Math.sin((c - d) * Math.PI * 2 / this._period));
        this._inner.update(d)
    }, reverse: function () {
        return new cc.EaseElasticOut(this._inner.reverse(), this._period)
    }, clone: function () {
        var c = new cc.EaseElasticIn;
        c.initWithAction(this._inner.clone(), this._period);
        return c
    }
});
cc.EaseElasticIn.create = function (c, d) {
    return new cc.EaseElasticIn(c, d)
};
cc._easeElasticInObj = {
    easing: function (c) {
        if (0 === c || 1 === c)return c;
        c -= 1;
        return -Math.pow(2, 10 * c) * Math.sin((c - 0.075) * Math.PI * 2 / 0.3)
    }, reverse: function () {
        return cc._easeElasticOutObj
    }
};
cc.easeElasticIn = function (c) {
    return c && 0.3 !== c ? {
        _period: c, easing: function (c) {
            if (0 === c || 1 === c)return c;
            c -= 1;
            return -Math.pow(2, 10 * c) * Math.sin((c - this._period / 4) * Math.PI * 2 / this._period)
        }, reverse: function () {
            return cc.easeElasticOut(this._period)
        }
    } : cc._easeElasticInObj
};
cc.EaseElasticOut = cc.EaseElastic.extend({
    update: function (c) {
        var d = 0;
        0 === c || 1 === c ? d = c : (d = this._period / 4, d = Math.pow(2, -10 * c) * Math.sin((c - d) * Math.PI * 2 / this._period) + 1);
        this._inner.update(d)
    }, reverse: function () {
        return new cc.EaseElasticIn(this._inner.reverse(), this._period)
    }, clone: function () {
        var c = new cc.EaseElasticOut;
        c.initWithAction(this._inner.clone(), this._period);
        return c
    }
});
cc.EaseElasticOut.create = function (c, d) {
    return new cc.EaseElasticOut(c, d)
};
cc._easeElasticOutObj = {
    easing: function (c) {
        return 0 === c || 1 === c ? c : Math.pow(2, -10 * c) * Math.sin((c - 0.075) * Math.PI * 2 / 0.3) + 1
    }, reverse: function () {
        return cc._easeElasticInObj
    }
};
cc.easeElasticOut = function (c) {
    return c && 0.3 !== c ? {
        _period: c, easing: function (c) {
            return 0 === c || 1 === c ? c : Math.pow(2, -10 * c) * Math.sin((c - this._period / 4) * Math.PI * 2 / this._period) + 1
        }, reverse: function () {
            return cc.easeElasticIn(this._period)
        }
    } : cc._easeElasticOutObj
};
cc.EaseElasticInOut = cc.EaseElastic.extend({
    update: function (c) {
        var d = 0, d = this._period;
        if (0 === c || 1 === c)d = c; else {
            d || (d = this._period = 0.3 * 1.5);
            var e = d / 4;
            c = 2 * c - 1;
            d = 0 > c ? -0.5 * Math.pow(2, 10 * c) * Math.sin((c - e) * Math.PI * 2 / d) : Math.pow(2, -10 * c) * Math.sin((c - e) * Math.PI * 2 / d) * 0.5 + 1
        }
        this._inner.update(d)
    }, reverse: function () {
        return new cc.EaseElasticInOut(this._inner.reverse(), this._period)
    }, clone: function () {
        var c = new cc.EaseElasticInOut;
        c.initWithAction(this._inner.clone(), this._period);
        return c
    }
});
cc.EaseElasticInOut.create = function (c, d) {
    return new cc.EaseElasticInOut(c, d)
};
cc.easeElasticInOut = function (c) {
    return {
        _period: c || 0.3, easing: function (c) {
            var e = 0, e = this._period;
            if (0 === c || 1 === c)e = c; else {
                e || (e = this._period = 0.3 * 1.5);
                var f = e / 4;
                c = 2 * c - 1;
                e = 0 > c ? -0.5 * Math.pow(2, 10 * c) * Math.sin((c - f) * Math.PI * 2 / e) : Math.pow(2, -10 * c) * Math.sin((c - f) * Math.PI * 2 / e) * 0.5 + 1
            }
            return e
        }, reverse: function () {
            return cc.easeElasticInOut(this._period)
        }
    }
};
cc.EaseBounce = cc.ActionEase.extend({
    bounceTime: function (c) {
        if (c < 1 / 2.75)return 7.5625 * c * c;
        if (c < 2 / 2.75)return c -= 1.5 / 2.75, 7.5625 * c * c + 0.75;
        if (c < 2.5 / 2.75)return c -= 2.25 / 2.75, 7.5625 * c * c + 0.9375;
        c -= 2.625 / 2.75;
        return 7.5625 * c * c + 0.984375
    }, clone: function () {
        var c = new cc.EaseBounce;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseBounce(this._inner.reverse())
    }
});
cc.EaseBounce.create = function (c) {
    return new cc.EaseBounce(c)
};
cc.EaseBounceIn = cc.EaseBounce.extend({
    update: function (c) {
        c = 1 - this.bounceTime(1 - c);
        this._inner.update(c)
    }, reverse: function () {
        return new cc.EaseBounceOut(this._inner.reverse())
    }, clone: function () {
        var c = new cc.EaseBounceIn;
        c.initWithAction(this._inner.clone());
        return c
    }
});
cc.EaseBounceIn.create = function (c) {
    return new cc.EaseBounceIn(c)
};
cc._bounceTime = function (c) {
    if (c < 1 / 2.75)return 7.5625 * c * c;
    if (c < 2 / 2.75)return c -= 1.5 / 2.75, 7.5625 * c * c + 0.75;
    if (c < 2.5 / 2.75)return c -= 2.25 / 2.75, 7.5625 * c * c + 0.9375;
    c -= 2.625 / 2.75;
    return 7.5625 * c * c + 0.984375
};
cc._easeBounceInObj = {
    easing: function (c) {
        return 1 - cc._bounceTime(1 - c)
    }, reverse: function () {
        return cc._easeBounceOutObj
    }
};
cc.easeBounceIn = function () {
    return cc._easeBounceInObj
};
cc.EaseBounceOut = cc.EaseBounce.extend({
    update: function (c) {
        c = this.bounceTime(c);
        this._inner.update(c)
    }, reverse: function () {
        return new cc.EaseBounceIn(this._inner.reverse())
    }, clone: function () {
        var c = new cc.EaseBounceOut;
        c.initWithAction(this._inner.clone());
        return c
    }
});
cc.EaseBounceOut.create = function (c) {
    return new cc.EaseBounceOut(c)
};
cc._easeBounceOutObj = {
    easing: function (c) {
        return cc._bounceTime(c)
    }, reverse: function () {
        return cc._easeBounceInObj
    }
};
cc.easeBounceOut = function () {
    return cc._easeBounceOutObj
};
cc.EaseBounceInOut = cc.EaseBounce.extend({
    update: function (c) {
        var d = 0, d = 0.5 > c ? 0.5 * (1 - this.bounceTime(1 - 2 * c)) : 0.5 * this.bounceTime(2 * c - 1) + 0.5;
        this._inner.update(d)
    }, clone: function () {
        var c = new cc.EaseBounceInOut;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseBounceInOut(this._inner.reverse())
    }
});
cc.EaseBounceInOut.create = function (c) {
    return new cc.EaseBounceInOut(c)
};
cc._easeBounceInOutObj = {
    easing: function (c) {
        return c = 0.5 > c ? 0.5 * (1 - cc._bounceTime(1 - 2 * c)) : 0.5 * cc._bounceTime(2 * c - 1) + 0.5
    }, reverse: function () {
        return cc._easeBounceInOutObj
    }
};
cc.easeBounceInOut = function () {
    return cc._easeBounceInOutObj
};
cc.EaseBackIn = cc.ActionEase.extend({
    update: function (c) {
        this._inner.update(0 === c || 1 === c ? c : c * c * (2.70158 * c - 1.70158))
    }, reverse: function () {
        return new cc.EaseBackOut(this._inner.reverse())
    }, clone: function () {
        var c = new cc.EaseBackIn;
        c.initWithAction(this._inner.clone());
        return c
    }
});
cc.EaseBackIn.create = function (c) {
    return new cc.EaseBackIn(c)
};
cc._easeBackInObj = {
    easing: function (c) {
        return 0 === c || 1 === c ? c : c * c * (2.70158 * c - 1.70158)
    }, reverse: function () {
        return cc._easeBackOutObj
    }
};
cc.easeBackIn = function () {
    return cc._easeBackInObj
};
cc.EaseBackOut = cc.ActionEase.extend({
    update: function (c) {
        c -= 1;
        this._inner.update(c * c * (2.70158 * c + 1.70158) + 1)
    }, reverse: function () {
        return new cc.EaseBackIn(this._inner.reverse())
    }, clone: function () {
        var c = new cc.EaseBackOut;
        c.initWithAction(this._inner.clone());
        return c
    }
});
cc.EaseBackOut.create = function (c) {
    return new cc.EaseBackOut(c)
};
cc._easeBackOutObj = {
    easing: function (c) {
        c -= 1;
        return c * c * (2.70158 * c + 1.70158) + 1
    }, reverse: function () {
        return cc._easeBackInObj
    }
};
cc.easeBackOut = function () {
    return cc._easeBackOutObj
};
cc.EaseBackInOut = cc.ActionEase.extend({
    update: function (c) {
        c *= 2;
        1 > c ? this._inner.update(c * c * (3.5949095 * c - 2.5949095) / 2) : (c -= 2, this._inner.update(c * c * (3.5949095 * c + 2.5949095) / 2 + 1))
    }, clone: function () {
        var c = new cc.EaseBackInOut;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseBackInOut(this._inner.reverse())
    }
});
cc.EaseBackInOut.create = function (c) {
    return new cc.EaseBackInOut(c)
};
cc._easeBackInOutObj = {
    easing: function (c) {
        c *= 2;
        if (1 > c)return c * c * (3.5949095 * c - 2.5949095) / 2;
        c -= 2;
        return c * c * (3.5949095 * c + 2.5949095) / 2 + 1
    }, reverse: function () {
        return cc._easeBackInOutObj
    }
};
cc.easeBackInOut = function () {
    return cc._easeBackInOutObj
};
cc.EaseBezierAction = cc.ActionEase.extend({
    _p0: null, _p1: null, _p2: null, _p3: null, ctor: function (c) {
        cc.ActionEase.prototype.ctor.call(this, c)
    }, _updateTime: function (c, d, e, f, g) {
        return Math.pow(1 - g, 3) * c + 3 * g * Math.pow(1 - g, 2) * d + 3 * Math.pow(g, 2) * (1 - g) * e + Math.pow(g, 3) * f
    }, update: function (c) {
        c = this._updateTime(this._p0, this._p1, this._p2, this._p3, c);
        this._inner.update(c)
    }, clone: function () {
        var c = new cc.EaseBezierAction;
        c.initWithAction(this._inner.clone());
        c.setBezierParamer(this._p0, this._p1, this._p2, this._p3);
        return c
    },
    reverse: function () {
        var c = new cc.EaseBezierAction(this._inner.reverse());
        c.setBezierParamer(this._p3, this._p2, this._p1, this._p0);
        return c
    }, setBezierParamer: function (c, d, e, f) {
        this._p0 = c || 0;
        this._p1 = d || 0;
        this._p2 = e || 0;
        this._p3 = f || 0
    }
});
cc.EaseBezierAction.create = function (c) {
    return new cc.EaseBezierAction(c)
};
cc.easeBezierAction = function (c, d, e, f) {
    return {
        easing: function (g) {
            return cc.EaseBezierAction.prototype._updateTime(c, d, e, f, g)
        }, reverse: function () {
            return cc.easeBezierAction(f, e, d, c)
        }
    }
};
cc.EaseQuadraticActionIn = cc.ActionEase.extend({
    _updateTime: function (c) {
        return Math.pow(c, 2)
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseQuadraticActionIn;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseQuadraticActionIn(this._inner.reverse())
    }
});
cc.EaseQuadraticActionIn.create = function (c) {
    return new cc.EaseQuadraticActionIn(c)
};
cc._easeQuadraticActionIn = {
    easing: cc.EaseQuadraticActionIn.prototype._updateTime, reverse: function () {
        return cc._easeQuadraticActionIn
    }
};
cc.easeQuadraticActionIn = function () {
    return cc._easeQuadraticActionIn
};
cc.EaseQuadraticActionOut = cc.ActionEase.extend({
    _updateTime: function (c) {
        return -c * (c - 2)
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseQuadraticActionOut;
        c.initWithAction();
        return c
    }, reverse: function () {
        return new cc.EaseQuadraticActionOut(this._inner.reverse())
    }
});
cc.EaseQuadraticActionOut.create = function (c) {
    return new cc.EaseQuadraticActionOut(c)
};
cc._easeQuadraticActionOut = {
    easing: cc.EaseQuadraticActionOut.prototype._updateTime, reverse: function () {
        return cc._easeQuadraticActionOut
    }
};
cc.easeQuadraticActionOut = function () {
    return cc._easeQuadraticActionOut
};
cc.EaseQuadraticActionInOut = cc.ActionEase.extend({
    _updateTime: function (c) {
        var d = c;
        c *= 2;
        1 > c ? d = c * c * 0.5 : (--c, d = -0.5 * (c * (c - 2) - 1));
        return d
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseQuadraticActionInOut;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseQuadraticActionInOut(this._inner.reverse())
    }
});
cc.EaseQuadraticActionInOut.create = function (c) {
    return new cc.EaseQuadraticActionInOut(c)
};
cc._easeQuadraticActionInOut = {
    easing: cc.EaseQuadraticActionInOut.prototype._updateTime, reverse: function () {
        return cc._easeQuadraticActionInOut
    }
};
cc.easeQuadraticActionInOut = function () {
    return cc._easeQuadraticActionInOut
};
cc.EaseQuarticActionIn = cc.ActionEase.extend({
    _updateTime: function (c) {
        return c * c * c * c
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseQuarticActionIn;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseQuarticActionIn(this._inner.reverse())
    }
});
cc.EaseQuarticActionIn.create = function (c) {
    return new cc.EaseQuarticActionIn(c)
};
cc._easeQuarticActionIn = {
    easing: cc.EaseQuarticActionIn.prototype._updateTime, reverse: function () {
        return cc._easeQuarticActionIn
    }
};
cc.easeQuarticActionIn = function () {
    return cc._easeQuarticActionIn
};
cc.EaseQuarticActionOut = cc.ActionEase.extend({
    _updateTime: function (c) {
        c -= 1;
        return -(c * c * c * c - 1)
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseQuarticActionOut;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseQuarticActionOut(this._inner.reverse())
    }
});
cc.EaseQuarticActionOut.create = function (c) {
    return new cc.EaseQuarticActionOut(c)
};
cc._easeQuarticActionOut = {
    easing: cc.EaseQuarticActionOut.prototype._updateTime, reverse: function () {
        return cc._easeQuarticActionOut
    }
};
cc.easeQuarticActionOut = function () {
    return cc._easeQuarticActionOut
};
cc.EaseQuarticActionInOut = cc.ActionEase.extend({
    _updateTime: function (c) {
        c *= 2;
        if (1 > c)return 0.5 * c * c * c * c;
        c -= 2;
        return -0.5 * (c * c * c * c - 2)
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseQuarticActionInOut;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseQuarticActionInOut(this._inner.reverse())
    }
});
cc.EaseQuarticActionInOut.create = function (c) {
    return new cc.EaseQuarticActionInOut(c)
};
cc._easeQuarticActionInOut = {
    easing: cc.EaseQuarticActionInOut.prototype._updateTime, reverse: function () {
        return cc._easeQuarticActionInOut
    }
};
cc.easeQuarticActionInOut = function () {
    return cc._easeQuarticActionInOut
};
cc.EaseQuinticActionIn = cc.ActionEase.extend({
    _updateTime: function (c) {
        return c * c * c * c * c
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseQuinticActionIn;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseQuinticActionIn(this._inner.reverse())
    }
});
cc.EaseQuinticActionIn.create = function (c) {
    return new cc.EaseQuinticActionIn(c)
};
cc._easeQuinticActionIn = {
    easing: cc.EaseQuinticActionIn.prototype._updateTime, reverse: function () {
        return cc._easeQuinticActionIn
    }
};
cc.easeQuinticActionIn = function () {
    return cc._easeQuinticActionIn
};
cc.EaseQuinticActionOut = cc.ActionEase.extend({
    _updateTime: function (c) {
        c -= 1;
        return c * c * c * c * c + 1
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseQuinticActionOut;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseQuinticActionOut(this._inner.reverse())
    }
});
cc.EaseQuinticActionOut.create = function (c) {
    return new cc.EaseQuinticActionOut(c)
};
cc._easeQuinticActionOut = {
    easing: cc.EaseQuinticActionOut.prototype._updateTime, reverse: function () {
        return cc._easeQuinticActionOut
    }
};
cc.easeQuinticActionOut = function () {
    return cc._easeQuinticActionOut
};
cc.EaseQuinticActionInOut = cc.ActionEase.extend({
    _updateTime: function (c) {
        c *= 2;
        if (1 > c)return 0.5 * c * c * c * c * c;
        c -= 2;
        return 0.5 * (c * c * c * c * c + 2)
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseQuinticActionInOut;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseQuinticActionInOut(this._inner.reverse())
    }
});
cc.EaseQuinticActionInOut.create = function (c) {
    return new cc.EaseQuinticActionInOut(c)
};
cc._easeQuinticActionInOut = {
    easing: cc.EaseQuinticActionInOut.prototype._updateTime, reverse: function () {
        return cc._easeQuinticActionInOut
    }
};
cc.easeQuinticActionInOut = function () {
    return cc._easeQuinticActionInOut
};
cc.EaseCircleActionIn = cc.ActionEase.extend({
    _updateTime: function (c) {
        return -1 * (Math.sqrt(1 - c * c) - 1)
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseCircleActionIn;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseCircleActionIn(this._inner.reverse())
    }
});
cc.EaseCircleActionIn.create = function (c) {
    return new cc.EaseCircleActionIn(c)
};
cc._easeCircleActionIn = {
    easing: cc.EaseCircleActionIn.prototype._updateTime, reverse: function () {
        return cc._easeCircleActionIn
    }
};
cc.easeCircleActionIn = function () {
    return cc._easeCircleActionIn
};
cc.EaseCircleActionOut = cc.ActionEase.extend({
    _updateTime: function (c) {
        c -= 1;
        return Math.sqrt(1 - c * c)
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseCircleActionOut;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseCircleActionOut(this._inner.reverse())
    }
});
cc.EaseCircleActionOut.create = function (c) {
    return new cc.EaseCircleActionOut(c)
};
cc._easeCircleActionOut = {
    easing: cc.EaseCircleActionOut.prototype._updateTime, reverse: function () {
        return cc._easeCircleActionOut
    }
};
cc.easeCircleActionOut = function () {
    return cc._easeCircleActionOut
};
cc.EaseCircleActionInOut = cc.ActionEase.extend({
    _updateTime: function (c) {
        c *= 2;
        if (1 > c)return -0.5 * (Math.sqrt(1 - c * c) - 1);
        c -= 2;
        return 0.5 * (Math.sqrt(1 - c * c) + 1)
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseCircleActionInOut;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseCircleActionInOut(this._inner.reverse())
    }
});
cc.EaseCircleActionInOut.create = function (c) {
    return new cc.EaseCircleActionInOut(c)
};
cc._easeCircleActionInOut = {
    easing: cc.EaseCircleActionInOut.prototype._updateTime, reverse: function () {
        return cc._easeCircleActionInOut
    }
};
cc.easeCircleActionInOut = function () {
    return cc._easeCircleActionInOut
};
cc.EaseCubicActionIn = cc.ActionEase.extend({
    _updateTime: function (c) {
        return c * c * c
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseCubicActionIn;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseCubicActionIn(this._inner.reverse())
    }
});
cc.EaseCubicActionIn.create = function (c) {
    return new cc.EaseCubicActionIn(c)
};
cc._easeCubicActionIn = {
    easing: cc.EaseCubicActionIn.prototype._updateTime, reverse: function () {
        return cc._easeCubicActionIn
    }
};
cc.easeCubicActionIn = function () {
    return cc._easeCubicActionIn
};
cc.EaseCubicActionOut = cc.ActionEase.extend({
    _updateTime: function (c) {
        c -= 1;
        return c * c * c + 1
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseCubicActionOut;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseCubicActionOut(this._inner.reverse())
    }
});
cc.EaseCubicActionOut.create = function (c) {
    return new cc.EaseCubicActionOut(c)
};
cc._easeCubicActionOut = {
    easing: cc.EaseCubicActionOut.prototype._updateTime, reverse: function () {
        return cc._easeCubicActionOut
    }
};
cc.easeCubicActionOut = function () {
    return cc._easeCubicActionOut
};
cc.EaseCubicActionInOut = cc.ActionEase.extend({
    _updateTime: function (c) {
        c *= 2;
        if (1 > c)return 0.5 * c * c * c;
        c -= 2;
        return 0.5 * (c * c * c + 2)
    }, update: function (c) {
        this._inner.update(this._updateTime(c))
    }, clone: function () {
        var c = new cc.EaseCubicActionInOut;
        c.initWithAction(this._inner.clone());
        return c
    }, reverse: function () {
        return new cc.EaseCubicActionInOut(this._inner.reverse())
    }
});
cc.EaseCubicActionInOut.create = function (c) {
    return new cc.EaseCubicActionInOut(c)
};
cc._easeCubicActionInOut = {
    easing: cc.EaseCubicActionInOut.prototype._updateTime, reverse: function () {
        return cc._easeCubicActionInOut
    }
};
cc.easeCubicActionInOut = function () {
    return cc._easeCubicActionInOut
};
cc.cardinalSplineAt = function (c, d, e, f, g, h) {
    var k = h * h, m = k * h, n = (1 - g) / 2;
    g = n * (-m + 2 * k - h);
    var p = n * (-m + k) + (2 * m - 3 * k + 1);
    h = n * (m - 2 * k + h) + (-2 * m + 3 * k);
    k = n * (m - k);
    return cc.p(c.x * g + d.x * p + e.x * h + f.x * k, c.y * g + d.y * p + e.y * h + f.y * k)
};
cc.reverseControlPoints = function (c) {
    for (var d = [], e = c.length - 1; 0 <= e; e--)d.push(cc.p(c[e].x, c[e].y));
    return d
};
cc.cloneControlPoints = function (c) {
    for (var d = [], e = 0; e < c.length; e++)d.push(cc.p(c[e].x, c[e].y));
    return d
};
cc.copyControlPoints = cc.cloneControlPoints;
cc.getControlPointAt = function (c, d) {
    var e = Math.min(c.length - 1, Math.max(d, 0));
    return c[e]
};
cc.reverseControlPointsInline = function (c) {
    for (var d = c.length, e = 0 | d / 2, f = 0; f < e; ++f) {
        var g = c[f];
        c[f] = c[d - f - 1];
        c[d - f - 1] = g
    }
};
cc.CardinalSplineTo = cc.ActionInterval.extend({
    _points: null, _deltaT: 0, _tension: 0, _previousPosition: null, _accumulatedDiff: null, ctor: function (c, d, e) {
        cc.ActionInterval.prototype.ctor.call(this);
        this._points = [];
        void 0 !== e && this.initWithDuration(c, d, e)
    }, initWithDuration: function (c, d, e) {
        if (!d || 0 === d.length)throw Error("Invalid configuration. It must at least have one control point");
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (this.setPoints(d), this._tension = e, !0) : !1
    }, clone: function () {
        var c =
            new cc.CardinalSplineTo;
        c.initWithDuration(this._duration, cc.copyControlPoints(this._points), this._tension);
        return c
    }, startWithTarget: function (c) {
        cc.ActionInterval.prototype.startWithTarget.call(this, c);
        this._deltaT = 1 / (this._points.length - 1);
        this._previousPosition = cc.p(this.target.getPositionX(), this.target.getPositionY());
        this._accumulatedDiff = cc.p(0, 0)
    }, update: function (c) {
        c = this._computeEaseTime(c);
        var d, e = this._points;
        if (1 === c)d = e.length - 1, c = 1; else {
            var f = this._deltaT;
            d = 0 | c / f;
            c = (c - f * d) / f
        }
        d = cc.cardinalSplineAt(cc.getControlPointAt(e,
            d - 1), cc.getControlPointAt(e, d - 0), cc.getControlPointAt(e, d + 1), cc.getControlPointAt(e, d + 2), this._tension, c);
        cc.ENABLE_STACKABLE_ACTIONS && (e = this.target.getPositionX() - this._previousPosition.x, c = this.target.getPositionY() - this._previousPosition.y, 0 !== e || 0 !== c) && (f = this._accumulatedDiff, e = f.x + e, c = f.y + c, f.x = e, f.y = c, d.x += e, d.y += c);
        this.updatePosition(d)
    }, reverse: function () {
        var c = cc.reverseControlPoints(this._points);
        return cc.cardinalSplineTo(this._duration, c, this._tension)
    }, updatePosition: function (c) {
        this.target.setPosition(c);
        this._previousPosition = c
    }, getPoints: function () {
        return this._points
    }, setPoints: function (c) {
        this._points = c
    }
});
cc.cardinalSplineTo = function (c, d, e) {
    return new cc.CardinalSplineTo(c, d, e)
};
cc.CardinalSplineTo.create = cc.cardinalSplineTo;
cc.CardinalSplineBy = cc.CardinalSplineTo.extend({
    _startPosition: null, ctor: function (c, d, e) {
        cc.CardinalSplineTo.prototype.ctor.call(this);
        this._startPosition = cc.p(0, 0);
        void 0 !== e && this.initWithDuration(c, d, e)
    }, startWithTarget: function (c) {
        cc.CardinalSplineTo.prototype.startWithTarget.call(this, c);
        this._startPosition.x = c.getPositionX();
        this._startPosition.y = c.getPositionY()
    }, reverse: function () {
        for (var c = this._points.slice(), d, e = c[0], f = 1; f < c.length; ++f)d = c[f], c[f] = cc.pSub(d, e), e = d;
        c = cc.reverseControlPoints(c);
        e = c[c.length - 1];
        c.pop();
        e.x = -e.x;
        e.y = -e.y;
        c.unshift(e);
        for (f = 1; f < c.length; ++f)d = c[f], d.x = -d.x, d.y = -d.y, d.x += e.x, d.y += e.y, e = c[f] = d;
        return cc.cardinalSplineBy(this._duration, c, this._tension)
    }, updatePosition: function (c) {
        var d = this._startPosition, e = c.x + d.x;
        c = c.y + d.y;
        this._previousPosition.x = e;
        this._previousPosition.y = c;
        this.target.setPosition(e, c)
    }, clone: function () {
        var c = new cc.CardinalSplineBy;
        c.initWithDuration(this._duration, cc.copyControlPoints(this._points), this._tension);
        return c
    }
});
cc.cardinalSplineBy = function (c, d, e) {
    return new cc.CardinalSplineBy(c, d, e)
};
cc.CardinalSplineBy.create = cc.cardinalSplineBy;
cc.CatmullRomTo = cc.CardinalSplineTo.extend({
    ctor: function (c, d) {
        d && this.initWithDuration(c, d)
    }, initWithDuration: function (c, d) {
        return cc.CardinalSplineTo.prototype.initWithDuration.call(this, c, d, 0.5)
    }, clone: function () {
        var c = new cc.CatmullRomTo;
        c.initWithDuration(this._duration, cc.copyControlPoints(this._points));
        return c
    }
});
cc.catmullRomTo = function (c, d) {
    return new cc.CatmullRomTo(c, d)
};
cc.CatmullRomTo.create = cc.catmullRomTo;
cc.CatmullRomBy = cc.CardinalSplineBy.extend({
    ctor: function (c, d) {
        cc.CardinalSplineBy.prototype.ctor.call(this);
        d && this.initWithDuration(c, d)
    }, initWithDuration: function (c, d) {
        return cc.CardinalSplineTo.prototype.initWithDuration.call(this, c, d, 0.5)
    }, clone: function () {
        var c = new cc.CatmullRomBy;
        c.initWithDuration(this._duration, cc.copyControlPoints(this._points));
        return c
    }
});
cc.catmullRomBy = function (c, d) {
    return new cc.CatmullRomBy(c, d)
};
cc.CatmullRomBy.create = cc.catmullRomBy;
cc.ActionTweenDelegate = cc.Class.extend({
    updateTweenAction: function (c, d) {
    }
});
cc.ActionTween = cc.ActionInterval.extend({
    key: "", from: 0, to: 0, delta: 0, ctor: function (c, d, e, f) {
        cc.ActionInterval.prototype.ctor.call(this);
        this.key = "";
        void 0 !== f && this.initWithDuration(c, d, e, f)
    }, initWithDuration: function (c, d, e, f) {
        return cc.ActionInterval.prototype.initWithDuration.call(this, c) ? (this.key = d, this.to = f, this.from = e, !0) : !1
    }, startWithTarget: function (c) {
        if (!c || !c.updateTweenAction)throw Error("cc.ActionTween.startWithTarget(): target must be non-null, and target must implement updateTweenAction function");
        cc.ActionInterval.prototype.startWithTarget.call(this,
            c);
        this.delta = this.to - this.from
    }, update: function (c) {
        this.target.updateTweenAction(this.to - this.delta * (1 - c), this.key)
    }, reverse: function () {
        return new cc.ActionTween(this.duration, this.key, this.to, this.from)
    }, clone: function () {
        var c = new cc.ActionTween;
        c.initWithDuration(this._duration, this.key, this.from, this.to);
        return c
    }
});
cc.actionTween = function (c, d, e, f) {
    return new cc.ActionTween(c, d, e, f)
};
cc.ActionTween.create = cc.actionTween;
cc._globalFontSize = cc.ITEM_SIZE;
cc._globalFontName = "Arial";
cc._globalFontNameRelease = !1;
cc.MenuItem = cc.Node.extend({
    _enabled: !1, _target: null, _callback: null, _isSelected: !1, _className: "MenuItem", ctor: function (c, d) {
        var e = cc.Node.prototype;
        e.ctor.call(this);
        this._callback = this._target = null;
        this._enabled = this._isSelected = !1;
        e.setAnchorPoint.call(this, 0.5, 0.5);
        this._target = d || null;
        if (this._callback = c || null)this._enabled = !0
    }, isSelected: function () {
        return this._isSelected
    }, setOpacityModifyRGB: function (c) {
    }, isOpacityModifyRGB: function () {
        return !1
    }, setTarget: function (c, d) {
        this._target = d;
        this._callback =
            c
    }, isEnabled: function () {
        return this._enabled
    }, setEnabled: function (c) {
        this._enabled = c
    }, initWithCallback: function (c, d) {
        this.anchorY = this.anchorX = 0.5;
        this._target = d;
        this._callback = c;
        this._enabled = !0;
        this._isSelected = !1;
        return !0
    }, rect: function () {
        var c = this._position, d = this._contentSize, e = this._anchorPoint;
        return cc.rect(c.x - d.width * e.x, c.y - d.height * e.y, d.width, d.height)
    }, selected: function () {
        this._isSelected = !0
    }, unselected: function () {
        this._isSelected = !1
    }, setCallback: function (c, d) {
        this._target = d;
        this._callback =
            c
    }, activate: function () {
        if (this._enabled) {
            var c = this._target, d = this._callback;
            if (d)if (c && cc.isString(d))c[d](this); else c && cc.isFunction(d) ? d.call(c, this) : d(this)
        }
    }
});
_p = cc.MenuItem.prototype;
cc.defineGetterSetter(_p, "enabled", _p.isEnabled, _p.setEnabled);
cc.MenuItem.create = function (c, d) {
    return new cc.MenuItem(c, d)
};
cc.MenuItemLabel = cc.MenuItem.extend({
    _disabledColor: null, _label: null, _originalScale: 0, _colorBackup: null, ctor: function (c, d, e) {
        cc.MenuItem.prototype.ctor.call(this, d, e);
        this._colorBackup = this._label = this._disabledColor = null;
        c && (this._originalScale = 1, this._colorBackup = cc.color.WHITE, this._disabledColor = cc.color(126, 126, 126), this.setLabel(c), this.setCascadeColorEnabled(!0), this.setCascadeOpacityEnabled(!0))
    }, getDisabledColor: function () {
        return this._disabledColor
    }, setDisabledColor: function (c) {
        this._disabledColor =
            c
    }, getLabel: function () {
        return this._label
    }, setLabel: function (c) {
        c && (this.addChild(c), c.anchorX = 0, c.anchorY = 0, this.width = c.width, this.height = c.height, c.setCascadeColorEnabled(!0));
        this._label && this.removeChild(this._label, !0);
        this._label = c
    }, setEnabled: function (c) {
        this._enabled !== c && (c ? this.setColor(this._colorBackup) : (this._colorBackup = this.color, this.setColor(this._disabledColor)));
        cc.MenuItem.prototype.setEnabled.call(this, c)
    }, initWithLabel: function (c, d, e) {
        this.initWithCallback(d, e);
        this._originalScale =
            1;
        this._colorBackup = cc.color.WHITE;
        this._disabledColor = cc.color(126, 126, 126);
        this.setLabel(c);
        this.setCascadeColorEnabled(!0);
        this.setCascadeOpacityEnabled(!0);
        return !0
    }, setString: function (c) {
        this._label.string = c;
        this.width = this._label.width;
        this.height = this._label.height
    }, getString: function () {
        return this._label.string
    }, activate: function () {
        this._enabled && (this.stopAllActions(), this.scale = this._originalScale, cc.MenuItem.prototype.activate.call(this))
    }, selected: function () {
        if (this._enabled) {
            cc.MenuItem.prototype.selected.call(this);
            var c = this.getActionByTag(cc.ZOOM_ACTION_TAG);
            c ? this.stopAction(c) : this._originalScale = this.scale;
            c = cc.scaleTo(0.1, 1.2 * this._originalScale);
            c.setTag(cc.ZOOM_ACTION_TAG);
            this.runAction(c)
        }
    }, unselected: function () {
        if (this._enabled) {
            cc.MenuItem.prototype.unselected.call(this);
            this.stopActionByTag(cc.ZOOM_ACTION_TAG);
            var c = cc.scaleTo(0.1, this._originalScale);
            c.setTag(cc.ZOOM_ACTION_TAG);
            this.runAction(c)
        }
    }
});
_p = cc.MenuItemLabel.prototype;
cc.defineGetterSetter(_p, "string", _p.getString, _p.setString);
cc.defineGetterSetter(_p, "disabledColor", _p.getDisabledColor, _p.setDisabledColor);
cc.defineGetterSetter(_p, "label", _p.getLabel, _p.setLabel);
cc.MenuItemLabel.create = function (c, d, e) {
    return new cc.MenuItemLabel(c, d, e)
};
cc.MenuItemAtlasFont = cc.MenuItemLabel.extend({
    ctor: function (c, d, e, f, g, h, k) {
        var m;
        c && 0 < c.length && (m = new cc.LabelAtlas(c, d, e, f, g));
        cc.MenuItemLabel.prototype.ctor.call(this, m, h, k)
    }, initWithString: function (c, d, e, f, g, h, k) {
        if (!c || 0 === c.length)throw Error("cc.MenuItemAtlasFont.initWithString(): value should be non-null and its length should be greater than 0");
        var m = new cc.LabelAtlas;
        m.initWithString(c, d, e, f, g);
        this.initWithLabel(m, h, k);
        return !0
    }
});
cc.MenuItemAtlasFont.create = function (c, d, e, f, g, h, k) {
    return new cc.MenuItemAtlasFont(c, d, e, f, g, h, k)
};
cc.MenuItemFont = cc.MenuItemLabel.extend({
    _fontSize: null, _fontName: null, ctor: function (c, d, e) {
        var f;
        c && 0 < c.length ? (this._fontName = cc._globalFontName, this._fontSize = cc._globalFontSize, f = new cc.LabelTTF(c, this._fontName, this._fontSize)) : (this._fontSize = 0, this._fontName = "");
        cc.MenuItemLabel.prototype.ctor.call(this, f, d, e)
    }, initWithString: function (c, d, e) {
        if (!c || 0 === c.length)throw Error("Value should be non-null and its length should be greater than 0");
        this._fontName = cc._globalFontName;
        this._fontSize = cc._globalFontSize;
        c = new cc.LabelTTF(c, this._fontName, this._fontSize);
        this.initWithLabel(c, d, e);
        return !0
    }, setFontSize: function (c) {
        this._fontSize = c;
        this._recreateLabel()
    }, getFontSize: function () {
        return this._fontSize
    }, setFontName: function (c) {
        this._fontName = c;
        this._recreateLabel()
    }, getFontName: function () {
        return this._fontName
    }, _recreateLabel: function () {
        var c = new cc.LabelTTF(this._label.string, this._fontName, this._fontSize);
        this.setLabel(c)
    }
});
cc.MenuItemFont.setFontSize = function (c) {
    cc._globalFontSize = c
};
cc.MenuItemFont.fontSize = function () {
    return cc._globalFontSize
};
cc.MenuItemFont.setFontName = function (c) {
    cc._globalFontNameRelease && (cc._globalFontName = "");
    cc._globalFontName = c;
    cc._globalFontNameRelease = !0
};
_p = cc.MenuItemFont.prototype;
cc.defineGetterSetter(_p, "fontSize", _p.getFontSize, _p.setFontSize);
cc.defineGetterSetter(_p, "fontName", _p.getFontName, _p.setFontName);
cc.MenuItemFont.fontName = function () {
    return cc._globalFontName
};
cc.MenuItemFont.create = function (c, d, e) {
    return new cc.MenuItemFont(c, d, e)
};
cc.MenuItemSprite = cc.MenuItem.extend({
    _normalImage: null, _selectedImage: null, _disabledImage: null, ctor: function (c, d, e, f, g) {
        cc.MenuItem.prototype.ctor.call(this);
        this._disabledImage = this._selectedImage = this._normalImage = null;
        if (void 0 !== c) {
            d = d || null;
            var h, k, m;
            void 0 !== g ? (h = e, m = f, k = g) : void 0 !== f && cc.isFunction(f) ? (h = e, m = f) : void 0 !== f && cc.isFunction(e) ? (k = f, m = e, h = null) : void 0 === e && (h = null);
            this.initWithNormalSprite(c, d, h, m, k)
        }
    }, getNormalImage: function () {
        return this._normalImage
    }, setNormalImage: function (c) {
        this._normalImage !==
        c && (c && (this.addChild(c, 0, cc.NORMAL_TAG), c.anchorX = 0, c.anchorY = 0), this._normalImage && this.removeChild(this._normalImage, !0), this._normalImage = c) && (this.width = this._normalImage.width, this.height = this._normalImage.height, this._updateImagesVisibility(), c.textureLoaded && !c.textureLoaded() && c.addEventListener("load", function (c) {
            this.width = c.width;
            this.height = c.height
        }, this))
    }, getSelectedImage: function () {
        return this._selectedImage
    }, setSelectedImage: function (c) {
        this._selectedImage !== c && (c && (this.addChild(c,
            0, cc.SELECTED_TAG), c.anchorX = 0, c.anchorY = 0), this._selectedImage && this.removeChild(this._selectedImage, !0), this._selectedImage = c, this._updateImagesVisibility())
    }, getDisabledImage: function () {
        return this._disabledImage
    }, setDisabledImage: function (c) {
        this._disabledImage !== c && (c && (this.addChild(c, 0, cc.DISABLE_TAG), c.anchorX = 0, c.anchorY = 0), this._disabledImage && this.removeChild(this._disabledImage, !0), this._disabledImage = c, this._updateImagesVisibility())
    }, initWithNormalSprite: function (c, d, e, f, g) {
        this.initWithCallback(f,
            g);
        this.setNormalImage(c);
        this.setSelectedImage(d);
        this.setDisabledImage(e);
        if (c = this._normalImage)this.width = c.width, this.height = c.height, c.textureLoaded && !c.textureLoaded() && c.addEventListener("load", function (c) {
            this.width = c.width;
            this.height = c.height;
            this.setCascadeColorEnabled(!0);
            this.setCascadeOpacityEnabled(!0)
        }, this);
        this.setCascadeColorEnabled(!0);
        this.setCascadeOpacityEnabled(!0);
        return !0
    }, selected: function () {
        cc.MenuItem.prototype.selected.call(this);
        this._normalImage && (this._disabledImage &&
        (this._disabledImage.visible = !1), this._selectedImage ? (this._normalImage.visible = !1, this._selectedImage.visible = !0) : this._normalImage.visible = !0)
    }, unselected: function () {
        cc.MenuItem.prototype.unselected.call(this);
        this._normalImage && (this._normalImage.visible = !0, this._selectedImage && (this._selectedImage.visible = !1), this._disabledImage && (this._disabledImage.visible = !1))
    }, setEnabled: function (c) {
        this._enabled !== c && (cc.MenuItem.prototype.setEnabled.call(this, c), this._updateImagesVisibility())
    }, _updateImagesVisibility: function () {
        var c =
            this._normalImage, d = this._selectedImage, e = this._disabledImage;
        this._enabled ? (c && (c.visible = !0), d && (d.visible = !1), e && (e.visible = !1)) : e ? (c && (c.visible = !1), d && (d.visible = !1), e && (e.visible = !0)) : (c && (c.visible = !0), d && (d.visible = !1))
    }
});
_p = cc.MenuItemSprite.prototype;
cc.defineGetterSetter(_p, "normalImage", _p.getNormalImage, _p.setNormalImage);
cc.defineGetterSetter(_p, "selectedImage", _p.getSelectedImage, _p.setSelectedImage);
cc.defineGetterSetter(_p, "disabledImage", _p.getDisabledImage, _p.setDisabledImage);
cc.MenuItemSprite.create = function (c, d, e, f, g) {
    return new cc.MenuItemSprite(c, d, e, f, g || void 0)
};
cc.MenuItemImage = cc.MenuItemSprite.extend({
    ctor: function (c, d, e, f, g) {
        var h = null, k = null, m = null, n = null, p = null;
        void 0 === c || null === c ? cc.MenuItemSprite.prototype.ctor.call(this) : (h = new cc.Sprite(c), d && (k = new cc.Sprite(d)), void 0 === f ? n = e : void 0 === g ? (n = e, p = f) : g && (m = new cc.Sprite(e), n = f, p = g), cc.MenuItemSprite.prototype.ctor.call(this, h, k, m, n, p))
    }, setNormalSpriteFrame: function (c) {
        this.setNormalImage(new cc.Sprite(c))
    }, setSelectedSpriteFrame: function (c) {
        this.setSelectedImage(new cc.Sprite(c))
    }, setDisabledSpriteFrame: function (c) {
        this.setDisabledImage(new cc.Sprite(c))
    },
    initWithNormalImage: function (c, d, e, f, g) {
        var h = null, k = null, m = null;
        c && (h = new cc.Sprite(c));
        d && (k = new cc.Sprite(d));
        e && (m = new cc.Sprite(e));
        return this.initWithNormalSprite(h, k, m, f, g)
    }
});
cc.MenuItemImage.create = function (c, d, e, f, g) {
    return new cc.MenuItemImage(c, d, e, f, g)
};
cc.MenuItemToggle = cc.MenuItem.extend({
    subItems: null, _selectedIndex: 0, _opacity: null, _color: null, ctor: function () {
        cc.MenuItem.prototype.ctor.call(this);
        this._selectedIndex = 0;
        this.subItems = [];
        this._opacity = 0;
        this._color = cc.color.WHITE;
        0 < arguments.length && this.initWithItems(Array.prototype.slice.apply(arguments))
    }, getOpacity: function () {
        return this._opacity
    }, setOpacity: function (c) {
        this._opacity = c;
        if (this.subItems && 0 < this.subItems.length)for (var d = 0; d < this.subItems.length; d++)this.subItems[d].opacity = c;
        this._color.a = c
    }, getColor: function () {
        var c = this._color;
        return cc.color(c.r, c.g, c.b, c.a)
    }, setColor: function (c) {
        var d = this._color;
        d.r = c.r;
        d.g = c.g;
        d.b = c.b;
        if (this.subItems && 0 < this.subItems.length)for (d = 0; d < this.subItems.length; d++)this.subItems[d].setColor(c);
        void 0 === c.a || c.a_undefined || this.setOpacity(c.a)
    }, getSelectedIndex: function () {
        return this._selectedIndex
    }, setSelectedIndex: function (c) {
        if (c !== this._selectedIndex) {
            this._selectedIndex = c;
            (c = this.getChildByTag(cc.CURRENT_ITEM)) && c.removeFromParent(!1);
            c = this.subItems[this._selectedIndex];
            this.addChild(c, 0, cc.CURRENT_ITEM);
            var d = c.width, e = c.height;
            this.width = d;
            this.height = e;
            c.setPosition(d / 2, e / 2)
        }
    }, getSubItems: function () {
        return this.subItems
    }, setSubItems: function (c) {
        this.subItems = c
    }, initWithItems: function (c) {
        var d = c.length;
        cc.isFunction(c[c.length - 2]) ? (this.initWithCallback(c[c.length - 2], c[c.length - 1]), d -= 2) : cc.isFunction(c[c.length - 1]) ? (this.initWithCallback(c[c.length - 1], null), d -= 1) : this.initWithCallback(null, null);
        for (var e = this.subItems, f = e.length =
            0; f < d; f++)c[f] && e.push(c[f]);
        this._selectedIndex = cc.UINT_MAX;
        this.setSelectedIndex(0);
        this.setCascadeColorEnabled(!0);
        this.setCascadeOpacityEnabled(!0);
        return !0
    }, addSubItem: function (c) {
        this.subItems.push(c)
    }, activate: function () {
        this._enabled && this.setSelectedIndex((this._selectedIndex + 1) % this.subItems.length);
        cc.MenuItem.prototype.activate.call(this)
    }, selected: function () {
        cc.MenuItem.prototype.selected.call(this);
        this.subItems[this._selectedIndex].selected()
    }, unselected: function () {
        cc.MenuItem.prototype.unselected.call(this);
        this.subItems[this._selectedIndex].unselected()
    }, setEnabled: function (c) {
        if (this._enabled !== c) {
            cc.MenuItem.prototype.setEnabled.call(this, c);
            var d = this.subItems;
            if (d && 0 < d.length)for (var e = 0; e < d.length; e++)d[e].enabled = c
        }
    }, selectedItem: function () {
        return this.subItems[this._selectedIndex]
    }, getSelectedItem: function () {
        return this.subItems[this._selectedIndex]
    }, onEnter: function () {
        cc.Node.prototype.onEnter.call(this);
        this.setSelectedIndex(this._selectedIndex)
    }
});
_p = cc.MenuItemToggle.prototype;
cc.defineGetterSetter(_p, "selectedIndex", _p.getSelectedIndex, _p.setSelectedIndex);
cc.MenuItemToggle.create = function () {
    0 < arguments.length && null == arguments[arguments.length - 1] && cc.log("parameters should not be ending with null in Javascript");
    var c = new cc.MenuItemToggle;
    c.initWithItems(Array.prototype.slice.apply(arguments));
    return c
};
cc.MENU_STATE_WAITING = 0;
cc.MENU_STATE_TRACKING_TOUCH = 1;
cc.MENU_HANDLER_PRIORITY = -128;
cc.DEFAULT_PADDING = 5;
cc.Menu = cc.Layer.extend({
    enabled: !1, _selectedItem: null, _state: -1, _touchListener: null, _className: "Menu", ctor: function (c) {
        cc.Layer.prototype.ctor.call(this);
        this._color = cc.color.WHITE;
        this.enabled = !1;
        this._opacity = 255;
        this._selectedItem = null;
        this._state = -1;
        this._touchListener = cc.EventListener.create({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            swallowTouches: !0,
            onTouchBegan: this._onTouchBegan,
            onTouchMoved: this._onTouchMoved,
            onTouchEnded: this._onTouchEnded,
            onTouchCancelled: this._onTouchCancelled
        });
        0 < arguments.length &&
        null == arguments[arguments.length - 1] && cc.log("parameters should not be ending with null in Javascript");
        var d = arguments.length, e;
        if (0 === d)e = []; else if (1 === d)e = c instanceof Array ? c : [c]; else if (1 < d) {
            e = [];
            for (var f = 0; f < d; f++)arguments[f] && e.push(arguments[f])
        }
        this.initWithArray(e)
    }, onEnter: function () {
        var c = this._touchListener;
        c._isRegistered() || cc.eventManager.addListener(c, this);
        cc.Node.prototype.onEnter.call(this)
    }, isEnabled: function () {
        return this.enabled
    }, setEnabled: function (c) {
        this.enabled = c
    }, initWithItems: function (c) {
        var d =
            [];
        if (c)for (var e = 0; e < c.length; e++)c[e] && d.push(c[e]);
        return this.initWithArray(d)
    }, initWithArray: function (c) {
        if (cc.Layer.prototype.init.call(this)) {
            this.enabled = !0;
            var d = cc.winSize;
            this.setPosition(d.width / 2, d.height / 2);
            this.setContentSize(d);
            this.setAnchorPoint(0.5, 0.5);
            this.ignoreAnchorPointForPosition(!0);
            if (c)for (d = 0; d < c.length; d++)this.addChild(c[d], d);
            this._selectedItem = null;
            this._state = cc.MENU_STATE_WAITING;
            return this.cascadeOpacity = this.cascadeColor = !0
        }
        return !1
    }, addChild: function (c, d, e) {
        if (!(c instanceof cc.MenuItem))throw Error("cc.Menu.addChild() : Menu only supports MenuItem objects as children");
        cc.Layer.prototype.addChild.call(this, c, d, e)
    }, alignItemsVertically: function () {
        this.alignItemsVerticallyWithPadding(cc.DEFAULT_PADDING)
    }, alignItemsVerticallyWithPadding: function (c) {
        var d = -c, e = this._children, f, g, h, k;
        if (e && 0 < e.length) {
            g = 0;
            for (f = e.length; g < f; g++)d += e[g].height * e[g].scaleY + c;
            var m = d / 2;
            g = 0;
            for (f = e.length; g < f; g++)k = e[g], h = k.height, d = k.scaleY, k.setPosition(0, m - h * d / 2), m -= h * d + c
        }
    }, alignItemsHorizontally: function () {
        this.alignItemsHorizontallyWithPadding(cc.DEFAULT_PADDING)
    },
    alignItemsHorizontallyWithPadding: function (c) {
        var d = -c, e = this._children, f, g, h, k;
        if (e && 0 < e.length) {
            f = 0;
            for (g = e.length; f < g; f++)d += e[f].width * e[f].scaleX + c;
            var m = -d / 2;
            f = 0;
            for (g = e.length; f < g; f++)k = e[f], d = k.scaleX, h = e[f].width, k.setPosition(m + h * d / 2, 0), m += h * d + c
        }
    }, alignItemsInColumns: function () {
        0 < arguments.length && null == arguments[arguments.length - 1] && cc.log("parameters should not be ending with null in Javascript");
        for (var c = [], d = 0; d < arguments.length; d++)c.push(arguments[d]);
        var e = -5, f = 0, g = 0, h = 0, k, m, n, p =
            this._children;
        if (p && 0 < p.length)for (d = 0, n = p.length; d < n; d++)f >= c.length || !(k = c[f]) || (m = p[d].height, g = g >= m || isNaN(m) ? g : m, ++h, h >= k && (e += g + 5, g = h = 0, ++f));
        var r = cc.director.getWinSize(), s = k = g = f = 0, v = 0, e = e / 2;
        if (p && 0 < p.length)for (d = 0, n = p.length; d < n; d++) {
            var t = p[d];
            0 === k && (k = c[f], v = s = r.width / (1 + k));
            m = t._getHeight();
            g = g >= m || isNaN(m) ? g : m;
            t.setPosition(v - r.width / 2, e - m / 2);
            v += s;
            ++h;
            h >= k && (e -= g + 5, g = k = h = 0, ++f)
        }
    }, alignItemsInRows: function () {
        0 < arguments.length && null == arguments[arguments.length - 1] && cc.log("parameters should not be ending with null in Javascript");
        var c = [], d;
        for (d = 0; d < arguments.length; d++)c.push(arguments[d]);
        var e = [], f = [], g = -10, h = -5, k = 0, m = 0, n = 0, p, r, s, v, t = this._children;
        if (t && 0 < t.length)for (d = 0, s = t.length; d < s; d++)(r = t[d], k >= c.length || !(p = c[k])) || (v = r.width, m = m >= v || isNaN(v) ? m : v, h += r.height + 5, ++n, n >= p && (e.push(m), f.push(h), g += m + 10, m = n = 0, h = -5, ++k));
        h = cc.director.getWinSize();
        p = m = k = 0;
        var g = -g / 2, w = 0;
        if (t && 0 < t.length)for (d = 0, s = t.length; d < s; d++)r = t[d], 0 === p && (p = c[k], w = f[k]), v = r._getWidth(), m = m >= v || isNaN(v) ? m : v, r.setPosition(g + e[k] / 2, w - h.height / 2),
            w -= r.height + 10, ++n, n >= p && (g += m + 5, m = p = n = 0, ++k)
    }, removeChild: function (c, d) {
        null != c && (c instanceof cc.MenuItem ? (this._selectedItem === c && (this._selectedItem = null), cc.Node.prototype.removeChild.call(this, c, d)) : cc.log("cc.Menu.removeChild():Menu only supports MenuItem objects as children"))
    }, _onTouchBegan: function (c, d) {
        var e = d.getCurrentTarget();
        if (e._state !== cc.MENU_STATE_WAITING || !e._visible || !e.enabled)return !1;
        for (var f = e.parent; null != f; f = f.parent)if (!f.isVisible())return !1;
        e._selectedItem = e._itemForTouch(c);
        return e._selectedItem ? (e._state = cc.MENU_STATE_TRACKING_TOUCH, e._selectedItem.selected(), e._selectedItem.setNodeDirty(), !0) : !1
    }, _onTouchEnded: function (c, d) {
        var e = d.getCurrentTarget();
        e._state !== cc.MENU_STATE_TRACKING_TOUCH ? cc.log("cc.Menu.onTouchEnded(): invalid state") : (e._selectedItem && (e._selectedItem.unselected(), e._selectedItem.setNodeDirty(), e._selectedItem.activate()), e._state = cc.MENU_STATE_WAITING)
    }, _onTouchCancelled: function (c, d) {
        var e = d.getCurrentTarget();
        e._state !== cc.MENU_STATE_TRACKING_TOUCH ?
            cc.log("cc.Menu.onTouchCancelled(): invalid state") : (e._selectedItem && (e._selectedItem.unselected(), e._selectedItem.setNodeDirty()), e._state = cc.MENU_STATE_WAITING)
    }, _onTouchMoved: function (c, d) {
        var e = d.getCurrentTarget();
        if (e._state !== cc.MENU_STATE_TRACKING_TOUCH)cc.log("cc.Menu.onTouchMoved(): invalid state"); else {
            var f = e._itemForTouch(c);
            f !== e._selectedItem && (e._selectedItem && (e._selectedItem.unselected(), e._selectedItem.setNodeDirty()), e._selectedItem = f, e._selectedItem && (e._selectedItem.selected(),
                e._selectedItem.setNodeDirty()))
        }
    }, onExit: function () {
        this._state === cc.MENU_STATE_TRACKING_TOUCH && (this._selectedItem && (this._selectedItem.unselected(), this._selectedItem = null), this._state = cc.MENU_STATE_WAITING);
        cc.Node.prototype.onExit.call(this)
    }, setOpacityModifyRGB: function (c) {
    }, isOpacityModifyRGB: function () {
        return !1
    }, _itemForTouch: function (c) {
        c = c.getLocation();
        var d = this._children, e;
        if (d && 0 < d.length)for (var f = d.length - 1; 0 <= f; f--)if (e = d[f], e.isVisible() && e.isEnabled()) {
            var g = e.convertToNodeSpace(c),
                h = e.rect();
            h.x = 0;
            h.y = 0;
            if (cc.rectContainsPoint(h, g))return e
        }
        return null
    }
});
_p = cc.Menu.prototype;
cc.Menu.create = function (c) {
    var d = arguments.length;
    0 < d && null == arguments[d - 1] && cc.log("parameters should not be ending with null in Javascript");
    return 0 === d ? new cc.Menu : 1 === d ? new cc.Menu(c) : new cc.Menu(Array.prototype.slice.call(arguments, 0))
};
(function () {
    var c = cc.sys, d = {
        ONLY_ONE: !1,
        WEB_AUDIO: !!(window.AudioContext || window.webkitAudioContext || window.mozAudioContext),
        DELAY_CREATE_CTX: !1,
        ONE_SOURCE: !1
    };
    c.browserType === c.BROWSER_TYPE_FIREFOX && (d.DELAY_CREATE_CTX = !0, d.USE_LOADER_EVENT = "canplay");
    c.os === c.OS_ANDROID && c.browserType === c.BROWSER_TYPE_UC && (d.ONE_SOURCE = !0);
    window.__audioSupport = d
})();
cc.Audio = cc.Class.extend({
    src: null, _element: null, _AUDIO_TYPE: "AUDIO", ctor: function (c) {
        this.src = c
    }, setBuffer: function (c) {
        this._AUDIO_TYPE = "WEBAUDIO";
        this._element = new cc.Audio.WebAudio(c)
    }, setElement: function (c) {
        this._AUDIO_TYPE = "AUDIO";
        this._element = c;
        c.addEventListener("ended", function () {
            c.loop || (c.paused = !0)
        })
    }, play: function (c, d) {
        this._element && (this._element.loop = d, this._element.play(), "AUDIO" === this._AUDIO_TYPE && this._element.paused && (this.stop(), cc.Audio.touchPlayList.push({
            loop: d,
            offset: c,
            audio: this._element
        })),
        !1 === cc.Audio.bindTouch && (cc.Audio.bindTouch = !0, cc.game.canvas.addEventListener("touchstart", cc.Audio.touchStart)))
    }, getPlaying: function () {
        return this._element ? !this._element.paused : !0
    }, stop: function () {
        if (this._element) {
            this._element.pause();
            try {
                this._element.currentTime = 0
            } catch (c) {
            }
        }
    }, pause: function () {
        this._element && this._element.pause()
    }, resume: function () {
        this._element && this._element.play()
    }, setVolume: function (c) {
        this._element && (this._element.volume = c)
    }, getVolume: function () {
        if (this._element)return this._element.volume
    },
    cloneNode: function () {
        var c = new cc.Audio(this.src);
        if ("AUDIO" === this._AUDIO_TYPE) {
            for (var d = document.createElement("audio"), e = d.getElementsByTagName("source"), f = 0; f < e.length; f++)d.appendChild(e[f]);
            d.src = this.src;
            c.setElement(d)
        } else c.setBuffer(this._element.buffer);
        return c
    }
});
cc.Audio.touchPlayList = [];
cc.Audio.bindTouch = !1;
cc.Audio.touchStart = function () {
    for (var c = cc.Audio.touchPlayList, d = null; d = c.pop();)d.audio.loop = !!d.loop, d.audio.play(d.offset)
};
cc.Audio.WebAudio = function (c) {
    this.buffer = c;
    this.context = cc.Audio._context;
    c = this.context.createGain();
    c.gain.value = 1;
    c.connect(this.context.destination);
    this._volume = c;
    this._loop = !1;
    this._startTime = -1;
    this._currentSource = null;
    this.playedLength = 0;
    this._currextTimer = null
};
cc.Audio.WebAudio.prototype = {
    constructor: cc.Audio.WebAudio, get paused() {
        return this._currentSource && this._currentSource.loop ? !1 : -1 === this._startTime ? !0 : this.context.currentTime - this._startTime > this.buffer.duration
    }, set paused(c) {
    }, get loop() {
        return this._loop
    }, set loop(c) {
        return this._loop = c
    }, get volume() {
        return this._volume.gain.value
    }, set volume(c) {
        return this._volume.gain.value = c
    }, get currentTime() {
        return this.playedLength
    }, set currentTime(c) {
        return this.playedLength = c
    }, play: function (c) {
        this._currentSource && !this.paused && (this._currentSource.stop(0), this.playedLength = 0);
        var d = this.context.createBufferSource();
        d.buffer = this.buffer;
        d.connect(this._volume);
        d.loop = this._loop;
        this._startTime = this.context.currentTime;
        c = c || this.playedLength;
        var e = this.buffer.duration;
        this._loop ? d.start ? d.start(0) : d.notoGrainOn ? d.noteGrainOn(0) : d.noteOn(0) : d.start ? d.start(0, c, e - c) : d.notoGrainOn ? d.noteGrainOn(0, c, e - c) : d.noteOn(0, c, e - c);
        this._currentSource = d;
        if (0 === this.context.currentTime) {
            var f = this;
            clearTimeout(this._currextTimer);
            this._currextTimer = setTimeout(function () {
                0 === f.context.currentTime && cc.Audio.touchPlayList.push({offset: c, audio: f})
            }, 10)
        }
    }, pause: function () {
        this.playedLength = this.context.currentTime - this._startTime;
        this.playedLength %= this.buffer.duration;
        var c = this._currentSource;
        this._currentSource = null;
        this._startTime = -1;
        c && c.stop(0)
    }
};
(function (c) {
    var d = c.WEB_AUDIO, e = c.ONLY_ONE, f = [];
    (function () {
        var c = document.createElement("audio");
        if (c.canPlayType) {
            var d = c.canPlayType('audio/ogg; codecs\x3d"vorbis"');
            d && "" !== d && f.push(".ogg");
            (d = c.canPlayType("audio/mpeg")) && "" !== d && f.push(".mp3");
            (d = c.canPlayType('audio/wav; codecs\x3d"1"')) && "" !== d && f.push(".wav");
            (d = c.canPlayType("audio/mp4")) && "" !== d && f.push(".mp4");
            (c = c.canPlayType("audio/x-m4a")) && "" !== c && f.push(".m4a")
        }
    })();
    try {
        if (d) {
            var g = new (window.AudioContext || window.webkitAudioContext ||
            window.mozAudioContext);
            cc.Audio._context = g;
            c.DELAY_CREATE_CTX && setTimeout(function () {
                g = new (window.AudioContext || window.webkitAudioContext || window.mozAudioContext);
                cc.Audio._context = g
            }, 0)
        }
    } catch (h) {
        d = !1, cc.log("browser don't support web audio")
    }
    var k = {
        cache: {}, useWebAudio: !1, loadBuffer: function (c, e) {
            if (d) {
                var f = new XMLHttpRequest;
                f.open("GET", c, !0);
                f.responseType = "arraybuffer";
                f.onload = function () {
                    g.decodeAudioData(f.response, function (c) {
                        e(null, c)
                    }, function () {
                        e("decode error - " + c)
                    })
                };
                f.onerror = function () {
                    e("request error - " +
                        c)
                };
                f.send()
            }
        }, load: function (c, d, e, g) {
            if (0 === f.length)return g("can not support audio!");
            var h = cc.loader.getRes(d);
            if (h)return g(null, h);
            cc.loader.audioPath && (c = cc.path.join(cc.loader.audioPath, c));
            var k = cc.path.extname(c);
            e = [k];
            for (h = 0; h < f.length; h++)k !== f[h] && e.push(f[h]);
            h = new cc.Audio(c);
            cc.loader.cache[d] = h;
            this.loadAudioFromExtList(c, e, h, g);
            return h
        }, loadAudioFromExtList: function (e, g, h, k) {
            if (0 === g.length) {
                var s = "can not found the resource of audio! Last match url is : ", s = s + e.replace(/\.(.*)?$/,
                        "(");
                f.forEach(function (c) {
                    s += c + "|"
                });
                s = s.replace(/\|$/, ")");
                return k({status: 520, errorMessage: s}, null)
            }
            if (d && this.useWebAudio)this.loadBuffer(e, function (c, d) {
                c && cc.log(c);
                d && h.setBuffer(d);
                k(null, h)
            }); else {
                for (var v = c.ONE_SOURCE ? 1 : g.length, t = document.createElement("audio"), w = 0; w < v; w++) {
                    var u = document.createElement("source");
                    u.src = cc.path.changeExtname(e, g[w]);
                    t.appendChild(u)
                }
                h.setElement(t);
                var A = setTimeout(function () {
                    0 === t.readyState ? B() : x()
                }, 8E3), x = function () {
                    t.removeEventListener("canplaythrough",
                        x, !1);
                    t.removeEventListener("error", B, !1);
                    t.removeEventListener("emptied", x, !1);
                    c.USE_LOADER_EVENT && t.removeEventListener(c.USE_LOADER_EVENT, x, !1);
                    clearTimeout(A);
                    k(null, h)
                }, B = function () {
                    cc.log("load audio failure - " + e);
                    x()
                };
                t.addEventListener("canplaythrough", x, !1);
                t.addEventListener("error", B, !1);
                c.USE_LOADER_EVENT && t.addEventListener(c.USE_LOADER_EVENT, x, !1)
            }
        }
    };
    cc.loader.register(["mp3", "ogg", "wav", "mp4", "m4a"], k);
    cc.audioEngine = {
        _currMusic: null, _musicVolume: 1, features: c, willPlayMusic: function () {
            return !1
        },
        playMusic: function (c, d) {
            var e = this._currMusic;
            e && e.getPlaying() && e.stop();
            e = cc.loader.getRes(c);
            e || (cc.loader.load(c), e = cc.loader.getRes(c));
            e.setVolume(this._musicVolume);
            e.play(0, d || !1);
            this._currMusic = e
        }, stopMusic: function (c) {
            var d = this._currMusic;
            d && (d.stop(), this._currMusic = null, c && cc.loader.release(d.src))
        }, pauseMusic: function () {
            var c = this._currMusic;
            c && c.pause()
        }, resumeMusic: function () {
            var c = this._currMusic;
            c && c.resume()
        }, rewindMusic: function () {
            var c = this._currMusic;
            c && (c.stop(), c.play())
        },
        getMusicVolume: function () {
            return this._musicVolume
        }, setMusicVolume: function (c) {
            c -= 0;
            isNaN(c) && (c = 1);
            1 < c && (c = 1);
            0 > c && (c = 0);
            this._musicVolume = c;
            var d = this._currMusic;
            d && d.setVolume(c)
        }, isMusicPlaying: function () {
            var c = this._currMusic;
            return c ? c.getPlaying() : !1
        }, _audioPool: {}, _maxAudioInstance: 10, _effectVolume: 1, playEffect: function (c, f) {
            if (e && this._currMusic && this._currMusic.getPlaying())return cc.log("Browser is only allowed to play one audio"), null;
            var g = this._audioPool[c];
            g || (g = this._audioPool[c] =
                []);
            var h;
            for (h = 0; h < g.length && g[h].getPlaying(); h++);
            !d && h > this._maxAudioInstance && (h = g.shift(), h.stop(), g.push(h), h = g.length - 1);
            var s;
            if (g[h])return s = g[h], s.setVolume(this._effectVolume), s.play(0, f || !1), s;
            (s = cc.loader.getRes(c)) && d && "AUDIO" === s._AUDIO_TYPE && (cc.loader.release(c), s = null);
            if (s)if (d && "AUDIO" === s._AUDIO_TYPE)k.loadBuffer(c, function (c, d) {
                s.setBuffer(d);
                s.setVolume(cc.audioEngine._effectVolume);
                s.getPlaying() || s.play(0, f || !1)
            }); else return s = s.cloneNode(), s.setVolume(this._effectVolume),
                s.play(0, f || !1), g.push(s), s;
            k.useWebAudio = !0;
            cc.loader.load(c, function (d) {
                d = cc.loader.getRes(c);
                d = d.cloneNode();
                d.setVolume(cc.audioEngine._effectVolume);
                d.play(0, f || !1);
                g.push(d)
            });
            k.useWebAudio = !1;
            return s
        }, setEffectsVolume: function (c) {
            c -= 0;
            isNaN(c) && (c = 1);
            1 < c && (c = 1);
            0 > c && (c = 0);
            this._effectVolume = c;
            var d = this._audioPool, e;
            for (e in d) {
                var f = d[e];
                if (Array.isArray(f))for (var g = 0; g < f.length; g++)f[g].setVolume(c)
            }
        }, getEffectsVolume: function () {
            return this._effectVolume
        }, pauseEffect: function (c) {
            c && c.pause()
        },
        pauseAllEffects: function () {
            var c = this._audioPool, d;
            for (d in c)for (var e = c[d], f = 0; f < c[d].length; f++)e[f].getPlaying() && e[f].pause()
        }, resumeEffect: function (c) {
            c && c.resume()
        }, resumeAllEffects: function () {
            var c = this._audioPool, d;
            for (d in c)for (var e = c[d], f = 0; f < c[d].length; f++)e[f].resume()
        }, stopEffect: function (c) {
            c && c.stop()
        }, stopAllEffects: function () {
            var c = this._audioPool, d;
            for (d in c) {
                for (var e = c[d], f = 0; f < e.length; f++)e[f].stop();
                e.length = 0
            }
        }, unloadEffect: function (c) {
            if (c) {
                cc.loader.release(c);
                var d =
                    this._audioPool[c];
                d && (d.length = 0);
                delete this._audioPool[c]
            }
        }, end: function () {
            this.stopMusic();
            this.stopAllEffects()
        }, _pauseCache: [], _pausePlaying: function () {
            var c = this._currMusic;
            c && c.getPlaying() && (c.pause(), this._pauseCache.push(c));
            var c = this._audioPool, d;
            for (d in c)for (var e = c[d], f = 0; f < c[d].length; f++)e[f].getPlaying() && (e[f].pause(), this._pauseCache.push(e[f]))
        }, _resumePlaying: function () {
            for (var c = this._pauseCache, d = 0; d < c.length; d++)c[d].resume();
            c.length = 0
        }
    }
})(window.__audioSupport);
(function () {
    cc.PhysicsSprite = cc.Sprite.extend({
        _ignoreBodyRotation: !1, _body: null, _rotation: 1, ctor: function (c, e) {
            cc.Sprite.prototype.ctor.call(this);
            if (void 0 === c)cc.PhysicsSprite.prototype.init.call(this); else if (cc.isString(c))if ("#" === c[0]) {
                var f = c.substr(1, c.length - 1), f = cc.spriteFrameCache.getSpriteFrame(f);
                this.initWithSpriteFrame(f)
            } else this.init(c, e); else cc.isObject(c) && (c instanceof cc.Texture2D ? this.initWithTexture(c, e) : c instanceof cc.SpriteFrame && this.initWithSpriteFrame(c));
            cc.renderer.pushRenderCommand(this._renderCmd)
        },
        visit: function () {
            cc.renderer.pushRenderCommand(this._renderCmd);
            cc.Sprite.prototype.visit.call(this)
        }, setBody: function (c) {
            this._body = c
        }, getBody: function () {
            return this._body
        }, getPosition: function () {
            var c = this._body;
            return {x: c.p.x, y: c.p.y}
        }, getPositionX: function () {
            return this._body.p.x
        }, getPositionY: function () {
            return this._body.p.y
        }, setPosition: function (c, e) {
            void 0 === e ? (this._body.p.x = c.x, this._body.p.y = c.y) : (this._body.p.x = c, this._body.p.y = e)
        }, setPositionX: function (c) {
            this._body.p.x = c
        }, setPositionY: function (c) {
            this._body.p.y =
                c
        }, _syncPosition: function () {
            var c = this._position, e = this._body;
            c.x === e.p.x && c.y === e.p.y || cc.Sprite.prototype.setPosition.call(this, e.p.x, e.p.y)
        }, getRotation: function () {
            return this._ignoreBodyRotation ? this._rotationX : -cc.radiansToDegrees(this._body.a)
        }, setRotation: function (c) {
            this._ignoreBodyRotation ? cc.Sprite.prototype.setRotation.call(this, c) : this._body.a = -cc.degreesToRadians(c)
        }, _syncRotation: function () {
            var c = -cc.radiansToDegrees(this._body.a);
            this._rotationX !== c && cc.Sprite.prototype.setRotation.call(this,
                c)
        }, getNodeToParentTransform: function () {
            return this._renderCmd.getNodeToParentTransform()
        }, isDirty: function () {
            return !this._body.isSleeping()
        }, setDirty: function () {
        }, setIgnoreBodyRotation: function (c) {
            this._ignoreBodyRotation = c
        }, _createRenderCmd: function () {
            return cc._renderType === cc.game.RENDER_TYPE_CANVAS ? new cc.PhysicsSprite.CanvasRenderCmd(this) : new cc.PhysicsSprite.WebGLRenderCmd(this)
        }
    });
    cc.PhysicsSprite._className = "PhysicsSprite";
    var c = cc.PhysicsSprite.prototype;
    cc.defineGetterSetter(c, "body",
        c.getBody, c.setBody);
    cc.defineGetterSetter(c, "dirty", c.isDirty, c.setDirty);
    cc.PhysicsSprite.create = function (c, e) {
        return new cc.PhysicsSprite(c, e)
    };
    cc.PhysicsSprite.createWithSpriteFrameName = cc.PhysicsSprite.create;
    cc.PhysicsSprite.createWithSpriteFrame = cc.PhysicsSprite.create
})();
cc.__convertVerts = function (c) {
    for (var d = [], e = 0; e < c.length / 2; e++)d[e] = {x: c[2 * e], y: c[2 * e + 1]};
    return d
};
cc.ColorForBody = function (c) {
    return c.isRogue() || c.isSleeping() ? cc.color(128, 128, 128, 128) : c.nodeIdleTime > c.space.sleepTimeThreshold ? cc.color(84, 84, 84, 128) : cc.color(255, 0, 0, 128)
};
cc.DrawShape = function (c, d) {
    var e = c.body, f = cc.ColorForBody(e);
    switch (c.collisionCode) {
        case cp.CircleShape.prototype.collisionCode:
            this.drawDot(c.tc, Math.max(c.r, 1), f);
            this.drawSegment(c.tc, cp.v.add(c.tc, cp.v.mult(e.rot, c.r)), 1, f);
            break;
        case cp.SegmentShape.prototype.collisionCode:
            this.drawSegment(c.ta, c.tb, Math.max(c.r, 2), f);
            break;
        case cp.PolyShape.prototype.collisionCode:
            e = cc.color(f.r, f.g, f.b, cc.lerp(f.a, 255, 0.5));
            this.drawPoly(cc.__convertVerts(c.tVerts), f, 1, e);
            break;
        default:
            cc.log("cc.DrawShape(): Bad assertion in DrawShape()")
    }
};
cc.DrawConstraint = function (c, d) {
    var e = c.a, f = c.b, g;
    c instanceof cp.PinJoint ? (g = e.local2World(c.anchr1), e = f.local2World(c.anchr2), this.drawDot(g, 3, cc.CONSTRAINT_COLOR), this.drawDot(e, 3, cc.CONSTRAINT_COLOR), this.drawSegment(g, e, 1, cc.CONSTRAINT_COLOR)) : c instanceof cp.SlideJoint ? (g = e.local2World(c.anchr1), e = f.local2World(c.anchr2), this.drawDot(g, 3, cc.CONSTRAINT_COLOR), this.drawDot(e, 3, cc.CONSTRAINT_COLOR), this.drawSegment(g, e, 1, cc.CONSTRAINT_COLOR)) : c instanceof cp.PivotJoint ? (g = e.local2World(c.anchr1),
        e = f.local2World(c.anchr2), this.drawDot(g, 3, cc.CONSTRAINT_COLOR), this.drawDot(e, 3, cc.CONSTRAINT_COLOR)) : c instanceof cp.GrooveJoint && (g = e.local2World(c.grv_a), e = e.local2World(c.grv_b), f = f.local2World(c.anchr2), this.drawDot(f, 3, cc.CONSTRAINT_COLOR), this.drawSegment(g, e, 1, cc.CONSTRAINT_COLOR))
};
cc.CONSTRAINT_COLOR = cc.color(0, 255, 0, 128);
cc.PhysicsDebugNode = cc.DrawNode.extend({
    _space: null, _className: "PhysicsDebugNode", ctor: function (c) {
        cc.DrawNode.prototype.ctor.call(this);
        this._space = c
    }, getSpace: function () {
        return this._space
    }, setSpace: function (c) {
        this._space = c
    }, draw: function (c) {
        this._space && (this._space.eachShape(cc.DrawShape.bind(this)), this._space.eachConstraint(cc.DrawConstraint.bind(this)), cc.DrawNode.prototype.draw.call(this), this.clear())
    }, _createRenderCmd: function () {
        return cc._renderType === cc.game.RENDER_TYPE_CANVAS ? new cc.PhysicsDebugNode.CanvasRenderCmd(this) :
            new cc.PhysicsDebugNode.WebGLRenderCmd(this)
    }
});
cc.PhysicsDebugNode.create = function (c) {
    return new cc.PhysicsDebugNode(c)
};
(function () {
    cc.PhysicsDebugNode.CanvasRenderCmd = function (c) {
        cc.Node.CanvasRenderCmd.call(this, c);
        this._buffer = c._buffer;
        this._needDraw = !0
    };
    var c = cc.PhysicsDebugNode.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
    c.constructor = cc.PhysicsDebugNode.CanvasRenderCmd;
    c.rendering = function (c, e, f) {
        var g = this._node;
        g._space && (g._space.eachShape(cc.DrawShape.bind(g)), g._space.eachConstraint(cc.DrawConstraint.bind(g)), cc.DrawNode.CanvasRenderCmd.prototype.rendering.call(this, c, e, f),
            g.clear())
    };
    c._drawDot = cc.DrawNode.CanvasRenderCmd.prototype._drawDot;
    c._drawSegment = cc.DrawNode.CanvasRenderCmd.prototype._drawSegment;
    c._drawPoly = cc.DrawNode.CanvasRenderCmd.prototype._drawPoly
})();
(function () {
    cc.PhysicsDebugNode.WebGLRenderCmd = function (c) {
        cc.Node.WebGLRenderCmd.call(this, c);
        this._needDraw = !0;
        this._matrix = new cc.math.Matrix4;
        this._matrix.identity()
    };
    cc.PhysicsDebugNode.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
    cc.PhysicsDebugNode.WebGLRenderCmd.prototype.constructor = cc.PhysicsDebugNode.WebGLRenderCmd;
    cc.PhysicsDebugNode.WebGLRenderCmd.prototype.rendering = function (c) {
        c = this._node;
        if (c._space) {
            c._space.eachShape(cc.DrawShape.bind(c));
            c._space.eachConstraint(cc.DrawConstraint.bind(c));
            var d = this._worldTransform;
            this._matrix.mat[0] = d.a;
            this._matrix.mat[4] = d.c;
            this._matrix.mat[12] = d.tx;
            this._matrix.mat[1] = d.b;
            this._matrix.mat[5] = d.d;
            this._matrix.mat[13] = d.ty;
            cc.glBlendFunc(c._blendFunc.src, c._blendFunc.dst);
            this._shaderProgram.use();
            this._shaderProgram._setUniformForMVPMatrixWithMat4(this._matrix);
            c._render();
            c.clear()
        }
    }
})();
(function () {
    cc.PhysicsSprite.CanvasRenderCmd = function (c) {
        cc.Sprite.CanvasRenderCmd.call(this, c);
        this._needDraw = !0
    };
    var c = cc.PhysicsSprite.CanvasRenderCmd.prototype = Object.create(cc.Sprite.CanvasRenderCmd.prototype);
    c.constructor = cc.PhysicsSprite.CanvasRenderCmd;
    c.rendering = function (c, e, f) {
        var g = this._node;
        g._syncPosition();
        g._ignoreBodyRotation || g._syncRotation();
        this.transform(this.getParentRenderCmd());
        cc.Sprite.CanvasRenderCmd.prototype.rendering.call(this, c, e, f)
    }
})();
(function () {
    cc.PhysicsSprite.WebGLRenderCmd = function (c) {
        cc.Sprite.WebGLRenderCmd.call(this, c);
        this._needDraw = !0
    };
    var c = cc.PhysicsSprite.WebGLRenderCmd.prototype = Object.create(cc.Sprite.WebGLRenderCmd.prototype);
    c.constructor = cc.PhysicsSprite.WebGLRenderCmd;
    c.spUploadData = cc.Sprite.WebGLRenderCmd.prototype.uploadData;
    c.uploadData = function (c, e, f) {
        var g = this._node;
        g._syncPosition();
        g._ignoreBodyRotation || g._syncRotation();
        this.transform(this.getParentRenderCmd(), !0);
        return this.spUploadData(c, e, f)
    }
})();
(function () {
    Object.create = Object.create || function (c) {
            function d() {
            }

            d.prototype = c;
            return new d
        };
    var c;
    "undefined" === typeof exports ? (c = {}, "object" === typeof window && (window.cp = c)) : c = exports;
    var d = function (c, d) {
        if (!c)throw Error("Assertion failed: " + d);
    }, e = function (c, d) {
        !c && console && console.warn && (console.warn("ASSERTION FAILED: " + d), console.trace && console.trace())
    }, f = function (c, d) {
        return c < d ? c : d
    }, g = function (c, d) {
        return c > d ? c : d
    }, h, k;
    "object" === typeof window && -1 < window.navigator.userAgent.indexOf("Firefox") ?
        (h = Math.min, k = Math.max) : (h = f, k = g);
    var m = function (c, d) {
        return c < d ? c + " " + d : d + " " + c
    }, n = function (c, d) {
        for (var e = 0; e < c.length; e++)if (c[e] === d) {
            c[e] = c[c.length - 1];
            c.length--;
            break
        }
    };
    c.momentForCircle = function (c, d, e, f) {
        return c * (0.5 * (d * d + e * e) + L(f))
    };
    c.areaForCircle = function (c, d) {
        return Math.PI * Math.abs(c * c - d * d)
    };
    c.momentForSegment = function (c, d, e) {
        var f = D(z(d, e), 0.5);
        return c * (V(e, d) / 12 + L(f))
    };
    c.areaForSegment = function (c, d, e) {
        return e * (Math.PI * e + 2 * T(c, d))
    };
    c.momentForPoly = function (c, d, e) {
        for (var f = 0, g = 0,
                 h = d.length, k = 0; k < h; k += 2)var m = d[k] + e.x, n = d[k + 1] + e.y, p = d[(k + 2) % h] + e.x, r = d[(k + 3) % h] + e.y, s = p * n - r * m, f = f + s * (m * m + n * n + (m * p + n * r) + (p * p + r * r)), g = g + s;
        return c * f / (6 * g)
    };
    c.areaForPoly = function (c) {
        for (var d = 0, e = 0, f = c.length; e < f; e += 2)d += I(new u(c[e], c[e + 1]), new u(c[(e + 2) % f], c[(e + 3) % f]));
        return -d / 2
    };
    c.centroidForPoly = function (c) {
        for (var d = 0, e = new u(0, 0), f = 0, g = c.length; f < g; f += 2)var h = new u(c[f], c[f + 1]), k = new u(c[(f + 2) % g], c[(f + 3) % g]), m = I(h, k), d = d + m, e = z(e, D(z(h, k), m));
        return D(e, 1 / (3 * d))
    };
    c.recenterPoly = function (d) {
        for (var e =
            c.centroidForPoly(d), f = 0; f < d.length; f += 2)d[f] -= e.x, d[f + 1] -= e.y
    };
    c.momentForBox = function (c, d, e) {
        return c * (d * d + e * e) / 12
    };
    c.momentForBox2 = function (d, e) {
        var f = e.r - e.l, g = e.t - e.b, h = D([e.l + e.r, e.b + e.t], 0.5);
        return c.momentForBox(d, f, g) + d * L(h)
    };
    var p = c.loopIndexes = function (c) {
        var d = 0, e = 0, f, g, h, k;
        f = h = c[0];
        g = k = c[1];
        for (var m = c.length >> 1, n = 1; n < m; n++) {
            var p = c[2 * n], r = c[2 * n + 1];
            if (p < f || p == f && r < g)f = p, g = r, d = n; else if (p > h || p == h && r > k)h = p, k = r, e = n
        }
        return [d, e]
    }, r = function (c, d, e) {
        var f = c[2 * d];
        c[2 * d] = c[2 * e];
        c[2 * e] = f;
        f = c[2 *
        d + 1];
        c[2 * d + 1] = c[2 * e + 1];
        c[2 * e + 1] = f
    }, s = function (c, d, e, f, g, h) {
        if (0 === e)return 0;
        var k = 0, m = d;
        g = y(g, f);
        h *= B(g);
        var n = d;
        for (e = d + e - 1; n <= e;) {
            var p = new u(c[2 * n], c[2 * n + 1]), p = I(g, y(p, f));
            p > h ? (p > k && (k = p, m = n), n++) : (r(c, n, e), e--)
        }
        m != d && r(c, d, m);
        return n - d
    }, v = function (c, d, e, f, g, h, k, m) {
        if (0 > f)return 0;
        if (0 == f)return d[2 * m] = h.x, d[2 * m + 1] = h.y, 1;
        var n = s(d, e, f, g, h, c), p = new u(d[2 * e], d[2 * e + 1]);
        g = v(c, d, e + 1, n - 1, g, p, h, m);
        p = m + g++;
        d[2 * p] = h.x;
        d[2 * p + 1] = h.y;
        f = s(d, e + n, f - n, h, k, c);
        p = new u(d[2 * (e + n)], d[2 * (e + n) + 1]);
        return g + v(c, d, e +
                n + 1, f - 1, h, p, k, m + g)
    };
    c.convexHull = function (c, d, f) {
        if (d)for (var g = 0; g < c.length; g++)d[g] = c[g]; else d = c;
        var h = p(c), g = h[0], h = h[1];
        if (g == h)return d.length = 2, d;
        r(d, 0, g);
        r(d, 1, 0 == h ? g : h);
        g = new u(d[0], d[1]);
        h = new u(d[2], d[3]);
        c = v(f, d, 2, (c.length >> 1) - 2, g, h, g, 1) + 1;
        d.length = 2 * c;
        e(Oa(d), "Internal error: cpConvexHull() and cpPolyValidate() did not agree.Please report this error with as much info as you can.");
        return d
    };
    var t = function (c, d, e) {
        return h(k(c, d), e)
    }, w = function (c) {
        return k(0, h(c, 1))
    }, u = c.Vect = function (c,
                              d) {
        this.x = c;
        this.y = d
    };
    c.v = function (c, d) {
        return new u(c, d)
    };
    var A = c.vzero = new u(0, 0), x = c.v.dot = function (c, d) {
        return c.x * d.x + c.y * d.y
    }, B = c.v.len = function (c) {
        return Math.sqrt(x(c, c))
    }, F = c.v.len2 = function (c, d) {
        return Math.sqrt(c * c + d * d)
    };
    c.v.eql = function (c, d) {
        return c.x === d.x && c.y === d.y
    };
    var z = c.v.add = function (c, d) {
        return new u(c.x + d.x, c.y + d.y)
    };
    u.prototype.add = function (c) {
        this.x += c.x;
        this.y += c.y;
        return this
    };
    var y = c.v.sub = function (c, d) {
        return new u(c.x - d.x, c.y - d.y)
    };
    u.prototype.sub = function (c) {
        this.x -=
            c.x;
        this.y -= c.y;
        return this
    };
    var K = c.v.neg = function (c) {
        return new u(-c.x, -c.y)
    };
    u.prototype.neg = function () {
        this.x = -this.x;
        this.y = -this.y;
        return this
    };
    var D = c.v.mult = function (c, d) {
        return new u(c.x * d, c.y * d)
    };
    u.prototype.mult = function (c) {
        this.x *= c;
        this.y *= c;
        return this
    };
    var I = c.v.cross = function (c, d) {
        return c.x * d.y - c.y * d.x
    }, N = c.v.perp = function (c) {
        return new u(-c.y, c.x)
    };
    c.v.pvrperp = function (c) {
        return new u(c.y, -c.x)
    };
    var Y = c.v.project = function (c, d) {
        return D(d, x(c, d) / L(d))
    };
    u.prototype.project = function (c) {
        this.mult(x(this,
                c) / L(c));
        return this
    };
    var G = c.v.rotate = function (c, d) {
        return new u(c.x * d.x - c.y * d.y, c.x * d.y + c.y * d.x)
    };
    u.prototype.rotate = function (c) {
        this.x = this.x * c.x - this.y * c.y;
        this.y = this.x * c.y + this.y * c.x;
        return this
    };
    var Z = c.v.unrotate = function (c, d) {
        return new u(c.x * d.x + c.y * d.y, c.y * d.x - c.x * d.y)
    }, L = c.v.lengthsq = function (c) {
        return x(c, c)
    }, $ = c.v.lengthsq2 = function (c, d) {
        return c * c + d * d
    }, S = c.v.lerp = function (c, d, e) {
        return z(D(c, 1 - e), D(d, e))
    }, O = c.v.normalize = function (c) {
        return D(c, 1 / B(c))
    }, U = c.v.normalize_safe = function (c) {
        return 0 ===
        c.x && 0 === c.y ? A : O(c)
    }, R = c.v.clamp = function (c, d) {
        return x(c, c) > d * d ? D(O(c), d) : c
    };
    c.v.lerpconst = function (c, d, e) {
        return z(c, R(y(d, c), e))
    };
    var T = c.v.dist = function (c, d) {
        return B(y(c, d))
    }, V = c.v.distsq = function (c, d) {
        return L(y(c, d))
    };
    c.v.near = function (c, d, e) {
        return V(c, d) < e * e
    };
    var ja = c.v.slerp = function (c, d, e) {
        var f = Math.acos(x(c, d));
        if (f) {
            var g = 1 / Math.sin(f);
            return z(D(c, Math.sin((1 - e) * f) * g), D(d, Math.sin(e * f) * g))
        }
        return c
    };
    c.v.slerpconst = function (c, d, e) {
        var f = Math.acos(x(c, d));
        return ja(c, d, h(e, f) / f)
    };
    c.v.forangle =
        function (c) {
            return new u(Math.cos(c), Math.sin(c))
        };
    c.v.toangle = function (c) {
        return Math.atan2(c.y, c.x)
    };
    c.v.str = function (c) {
        return "(" + c.x.toFixed(3) + ", " + c.y.toFixed(3) + ")"
    };
    var jb = 0, ea = c.BB = function (c, d, e, f) {
        this.l = c;
        this.b = d;
        this.r = e;
        this.t = f;
        jb++
    };
    c.bb = function (c, d, e, f) {
        return new ea(c, d, e, f)
    };
    var Pa = function (c, d) {
        return new ea(c.x - d, c.y - d, c.x + d, c.y + d)
    }, Qa = 0;
    c.NO_GROUP = 0;
    var kb = c.ALL_LAYERS = -1;
    c.ALL_CATEGORIES = -1;
    c.resetShapeIdCounter = function () {
        Qa = 0
    };
    var P = c.Shape = function (c) {
        this.body = c;
        this.bb_l =
            this.bb_b = this.bb_r = this.bb_t = 0;
        this.hashid = Qa++;
        this.sensor = !1;
        this.u = this.e = 0;
        this.surface_v = A;
        this.group = this.collision_type = 0;
        this.layers = kb;
        this.space = null;
        this.collisionCode = this.collisionCode
    };
    P.prototype.setElasticity = function (c) {
        this.e = c
    };
    P.prototype.setFriction = function (c) {
        this.body.activate();
        this.u = c
    };
    P.prototype.setLayers = function (c) {
        this.body.activate();
        this.layers = c
    };
    P.prototype.setSensor = function (c) {
        this.body.activate();
        this.sensor = c
    };
    P.prototype.setCollisionType = function (c) {
        this.body.activate();
        this.collision_type = c
    };
    P.prototype.getBody = function () {
        return this.body
    };
    P.prototype.active = function () {
        return this.body && -1 !== this.body.shapeList.indexOf(this)
    };
    P.prototype.setBody = function (c) {
        d(!this.active(), "You cannot change the body on an active shape. You must remove the shape from the space before changing the body.");
        this.body = c
    };
    P.prototype.cacheBB = function () {
        return this.update(this.body.p, this.body.rot)
    };
    P.prototype.update = function (c, e) {
        d(!isNaN(e.x), "Rotation is NaN");
        d(!isNaN(c.x), "Position is NaN");
        this.cacheData(c, e)
    };
    P.prototype.pointQuery = function (c) {
        c = this.nearestPointQuery(c);
        if (0 > c.d)return c
    };
    P.prototype.getBB = function () {
        return new ea(this.bb_l, this.bb_b, this.bb_r, this.bb_t)
    };
    var xa = function (c, d, e) {
        this.shape = c;
        this.p = d;
        this.d = e
    }, ma = function (c, d, e) {
        this.shape = c;
        this.t = d;
        this.n = e
    };
    ma.prototype.hitPoint = function (c, d) {
        return S(c, d, this.t)
    };
    ma.prototype.hitDist = function (c, d) {
        return T(c, d) * this.t
    };
    var ka = c.CircleShape = function (c, d, e) {
        this.c = this.tc = e;
        this.r = d;
        this.type = "circle";
        P.call(this,
            c)
    };
    ka.prototype = Object.create(P.prototype);
    ka.prototype.cacheData = function (c, d) {
        var e = this.tc = G(this.c, d).add(c), f = this.r;
        this.bb_l = e.x - f;
        this.bb_b = e.y - f;
        this.bb_r = e.x + f;
        this.bb_t = e.y + f
    };
    ka.prototype.nearestPointQuery = function (c) {
        var d = c.x - this.tc.x, e = c.y - this.tc.y;
        c = F(d, e);
        var f = this.r, d = new u(this.tc.x + d * f / c, this.tc.y + e * f / c);
        return new xa(this, d, c - f)
    };
    var ya = function (c, d, e, f, g, h) {
        f = y(f, d);
        g = y(g, d);
        d = x(f, f) - 2 * x(f, g) + x(g, g);
        h = -2 * x(f, f) + 2 * x(f, g);
        e = x(f, f) - e * e;
        e = h * h - 4 * d * e;
        if (0 <= e && (e = (-h - Math.sqrt(e)) /
                (2 * d), 0 <= e && 1 >= e))return new ma(c, e, O(S(f, g, e)))
    };
    ka.prototype.segmentQuery = function (c, d) {
        return ya(this, this.tc, this.r, c, d)
    };
    var fa = c.SegmentShape = function (c, d, e, f) {
        this.a = d;
        this.b = e;
        this.n = N(O(y(e, d)));
        this.ta = this.tb = this.tn = null;
        this.r = f;
        this.b_tangent = this.a_tangent = A;
        this.type = "segment";
        P.call(this, c)
    };
    fa.prototype = Object.create(P.prototype);
    fa.prototype.cacheData = function (c, d) {
        this.ta = z(c, G(this.a, d));
        this.tb = z(c, G(this.b, d));
        this.tn = G(this.n, d);
        var e, f, g, h;
        this.ta.x < this.tb.x ? (e = this.ta.x,
            f = this.tb.x) : (e = this.tb.x, f = this.ta.x);
        this.ta.y < this.tb.y ? (g = this.ta.y, h = this.tb.y) : (g = this.tb.y, h = this.ta.y);
        var k = this.r;
        this.bb_l = e - k;
        this.bb_b = g - k;
        this.bb_r = f + k;
        this.bb_t = h + k
    };
    fa.prototype.nearestPointQuery = function (c) {
        var d;
        d = this.tb;
        var e = y(this.ta, d), f = w(x(e, y(c, d)) / L(e));
        d = z(d, D(e, f));
        var e = c.x - d.x, g = c.y - d.y;
        c = F(e, g);
        f = this.r;
        d = c ? z(d, D(new u(e, g), f / c)) : d;
        return new xa(this, d, c - f)
    };
    fa.prototype.segmentQuery = function (c, d) {
        var e = this.tn, f = x(y(this.ta, c), e), g = this.r, h = 0 < f ? K(e) : e, k = y(D(h, g), c),
            m = z(this.ta, k), n = z(this.tb, k), k = y(d, c);
        if (0 >= I(k, m) * I(k, n)) {
            if (g = f + (0 < f ? -g : g), f = -g, e = x(k, e) - g, 0 > f * e)return new ma(this, f / (f - e), h)
        } else if (0 !== g)return h = ya(this, this.ta, this.r, c, d), e = ya(this, this.tb, this.r, c, d), h ? e && e.t < h.t ? e : h : e
    };
    fa.prototype.setNeighbors = function (c, d) {
        this.a_tangent = y(c, this.a);
        this.b_tangent = y(d, this.b)
    };
    fa.prototype.setEndpoints = function (c, d) {
        this.a = c;
        this.b = d;
        this.n = N(O(y(d, c)))
    };
    var Oa = function (c) {
        for (var d = c.length, e = 0; e < d; e += 2) {
            var f = c[(e + 2) % d], g = c[(e + 3) % d];
            if (0 < (f - c[e]) *
                (c[(e + 5) % d] - g) - (g - c[e + 1]) * (c[(e + 4) % d] - f))return !1
        }
        return !0
    }, Q = c.PolyShape = function (c, d, e) {
        this.setVerts(d, e);
        this.type = "poly";
        P.call(this, c)
    };
    Q.prototype = Object.create(P.prototype);
    var za = function (c, d) {
        this.n = c;
        this.d = d
    };
    za.prototype.compare = function (c) {
        return x(this.n, c) - this.d
    };
    Q.prototype.setVerts = function (c, e) {
        d(4 <= c.length, "Polygons require some verts");
        d("number" === typeof c[0], "Polygon verticies should be specified in a flattened list (eg [x1,y1,x2,y2,x3,y3,...])");
        d(Oa(c), "Polygon is concave or has a reversed winding. Consider using cpConvexHull()");
        var f = c.length, g = f >> 1;
        this.verts = Array(f);
        this.tVerts = Array(f);
        this.planes = Array(g);
        this.tPlanes = Array(g);
        for (g = 0; g < f; g += 2) {
            var h = c[g] + e.x, k = c[g + 1] + e.y, m = O(N(new u(c[(g + 2) % f] + e.x - h, c[(g + 3) % f] + e.y - k)));
            this.verts[g] = h;
            this.verts[g + 1] = k;
            this.planes[g >> 1] = new za(m, m.x * h + m.y * k);
            this.tPlanes[g >> 1] = new za(new u(0, 0), 0)
        }
    };
    c.BoxShape = function (c, d, e) {
        d /= 2;
        e /= 2;
        return lb(c, new ea(-d, -e, d, e))
    };
    var lb = c.BoxShape2 = function (c, d) {
        return new Q(c, [d.l, d.b, d.l, d.t, d.r, d.t, d.r, d.b], A)
    };
    Q.prototype.transformVerts = function (c,
                                           d) {
        for (var e = this.verts, f = this.tVerts, g = Infinity, m = -Infinity, n = Infinity, p = -Infinity, r = 0; r < e.length; r += 2) {
            var s = e[r], t = e[r + 1], u = c.x + s * d.x - t * d.y, s = c.y + s * d.y + t * d.x;
            f[r] = u;
            f[r + 1] = s;
            g = h(g, u);
            m = k(m, u);
            n = h(n, s);
            p = k(p, s)
        }
        this.bb_l = g;
        this.bb_b = n;
        this.bb_r = m;
        this.bb_t = p
    };
    Q.prototype.transformAxes = function (c, d) {
        for (var e = this.planes, f = this.tPlanes, g = 0; g < e.length; g++) {
            var h = G(e[g].n, d);
            f[g].n = h;
            f[g].d = x(c, h) + e[g].d
        }
    };
    Q.prototype.cacheData = function (c, d) {
        this.transformAxes(c, d);
        this.transformVerts(c, d)
    };
    Q.prototype.nearestPointQuery =
        function (c) {
            for (var d = this.tPlanes, e = this.tVerts, f = e[e.length - 2], g = e[e.length - 1], h = Infinity, k = A, m = !1, n = 0; n < d.length; n++) {
                0 < d[n].compare(c) && (m = !0);
                var p = e[2 * n], r = e[2 * n + 1], s;
                s = p;
                var t = r, f = f - s, g = g - t, v = w((f * (c.x - s) + g * (c.y - t)) / $(f, g));
                s = new u(s + f * v, t + g * v);
                t = T(c, s);
                t < h && (h = t, k = s);
                f = p;
                g = r
            }
            return new xa(this, k, m ? h : -h)
        };
    Q.prototype.segmentQuery = function (c, d) {
        for (var e = this.tPlanes, f = this.tVerts, g = e.length, h = 2 * g, k = 0; k < g; k++) {
            var m = e[k].n, n = x(c, m);
            if (!(e[k].d > n)) {
                var p = x(d, m), n = (e[k].d - n) / (p - n);
                if (!(0 > n || 1 <
                    n)) {
                    var p = S(c, d, n), p = -I(m, p), r = -(m.x * f[(2 * k + 3) % h] - m.y * f[(2 * k + 2) % h]);
                    if (-(m.x * f[2 * k + 1] - m.y * f[2 * k]) <= p && p <= r)return new ma(this, n, m)
                }
            }
        }
    };
    Q.prototype.valueOnAxis = function (c, d) {
        for (var e = this.tVerts, f = c.x * e[0] + c.y * e[1], g = 2; g < e.length; g += 2)f = h(f, c.x * e[g] + c.y * e[g + 1]);
        return f - d
    };
    Q.prototype.containsVert = function (c, d) {
        for (var e = this.tPlanes, f = 0; f < e.length; f++) {
            var g = e[f].n;
            if (0 < g.x * c + g.y * d - e[f].d)return !1
        }
        return !0
    };
    Q.prototype.containsVertPartial = function (c, d, e) {
        for (var f = this.tPlanes, g = 0; g < f.length; g++) {
            var h =
                f[g].n;
            if (!(0 > x(h, e)) && 0 < h.x * c + h.y * d - f[g].d)return !1
        }
        return !0
    };
    Q.prototype.getNumVerts = function () {
        return this.verts.length / 2
    };
    Q.prototype.getCount = Q.prototype.getNumVerts;
    Q.prototype.getVert = function (c) {
        return new u(this.verts[2 * c], this.verts[2 * c + 1])
    };
    var C = c.Body = function (c, d) {
        this.p = new u(0, 0);
        this.vx = this.vy = 0;
        this.f = new u(0, 0);
        this.t = this.w = 0;
        this.w_limit = this.v_limit = Infinity;
        this.w_bias = this.v_biasx = this.v_biasy = 0;
        this.space = null;
        this.shapeList = [];
        this.nodeNext = this.nodeRoot = this.constraintList =
            this.arbiterList = null;
        this.nodeIdleTime = 0;
        this.setMass(c);
        this.setMoment(d);
        this.rot = new u(0, 0);
        this.setAngle(0)
    };
    c.StaticBody = function () {
        var c = new C(Infinity, Infinity);
        c.nodeIdleTime = Infinity;
        return c
    };
    if ("undefined" !== typeof DEBUG && DEBUG) {
        var Aa = function (c, e) {
            d(c.x == c.x && c.y == c.y, e)
        }, Ba = function (c, e) {
            d(Infinity !== Math.abs(c.x) && Infinity !== Math.abs(c.y), e)
        };
        C.prototype.sanityCheck = function () {
            d(this.m === this.m && this.m_inv === this.m_inv, "Body's mass is invalid.");
            d(this.i === this.i && this.i_inv === this.i_inv,
                "Body's moment is invalid.");
            var c = this.p;
            Aa(c, "Body's position is invalid.");
            Ba(c, "Body's position is invalid.");
            c = this.f;
            Aa(c, "Body's force is invalid.");
            Ba(c, "Body's force is invalid.");
            d(this.vx === this.vx && Infinity !== Math.abs(this.vx), "Body's velocity is invalid.");
            d(this.vy === this.vy && Infinity !== Math.abs(this.vy), "Body's velocity is invalid.");
            d(this.a === this.a && Infinity !== Math.abs(this.a), "Body's angle is invalid.");
            d(this.w === this.w && Infinity !== Math.abs(this.w), "Body's angular velocity is invalid.");
            d(this.t === this.t && Infinity !== Math.abs(this.t), "Body's torque is invalid.");
            c = this.rot;
            Aa(c, "Body's rotation vector is invalid.");
            Ba(c, "Body's rotation vector is invalid.");
            d(this.v_limit === this.v_limit, "Body's velocity limit is invalid.");
            d(this.w_limit === this.w_limit, "Body's angular velocity limit is invalid.")
        }
    } else C.prototype.sanityCheck = function () {
    };
    C.prototype.getPos = function () {
        return this.p
    };
    C.prototype.getVel = function () {
        return new u(this.vx, this.vy)
    };
    C.prototype.getAngVel = function () {
        return this.w
    };
    C.prototype.getPosition = C.prototype.getPos;
    C.prototype.getVelocity = C.prototype.getVel;
    C.prototype.getAngularVelocity = C.prototype.getAngVel;
    C.prototype.getCenterOfGravity = function () {
        return this.p
    };
    C.prototype.isSleeping = function () {
        return null !== this.nodeRoot
    };
    C.prototype.isStatic = function () {
        return Infinity === this.nodeIdleTime
    };
    C.prototype.isRogue = function () {
        return null === this.space
    };
    C.prototype.setMass = function (c) {
        d(0 < c, "Mass must be positive and non-zero.");
        this.activate();
        this.m = c;
        this.m_inv = 1 / c
    };
    C.prototype.setMoment = function (c) {
        d(0 < c, "Moment of Inertia must be positive and non-zero.");
        this.activate();
        this.i = c;
        this.i_inv = 1 / c
    };
    C.prototype.addShape = function (c) {
        this.shapeList.push(c)
    };
    C.prototype.removeShape = function (c) {
        n(this.shapeList, c)
    };
    var Ca = function (c, d, e) {
        if (c === e)return c.next(d);
        c.a === d ? c.next_a = Ca(c.next_a, d, e) : c.next_b = Ca(c.next_b, d, e);
        return c
    };
    C.prototype.removeConstraint = function (c) {
        this.constraintList = Ca(this.constraintList, this, c)
    };
    C.prototype.setPos = function (d) {
        this.activate();
        this.sanityCheck();
        d === A && (d = c.v(0, 0));
        this.p = d
    };
    C.prototype.setVel = function (c) {
        this.activate();
        this.vx = c.x;
        this.vy = c.y
    };
    C.prototype.setAngVel = function (c) {
        this.activate();
        this.w = c
    };
    C.prototype.setAngleInternal = function (c) {
        d(!isNaN(c), "Internal Error: Attempting to set body's angle to NaN");
        this.a = c;
        this.rot.x = Math.cos(c);
        this.rot.y = Math.sin(c)
    };
    C.prototype.setAngle = function (c) {
        this.activate();
        this.sanityCheck();
        this.setAngleInternal(c)
    };
    C.prototype.velocity_func = function (c, d, e) {
        var f = this.vx * d + (c.x +
            this.f.x * this.m_inv) * e;
        c = this.vy * d + (c.y + this.f.y * this.m_inv) * e;
        var g = this.v_limit, h = f * f + c * c, g = h > g * g ? g / Math.sqrt(h) : 1;
        this.vx = f * g;
        this.vy = c * g;
        f = this.w_limit;
        this.w = t(this.w * d + this.t * this.i_inv * e, -f, f);
        this.sanityCheck()
    };
    C.prototype.position_func = function (c) {
        this.p.x += (this.vx + this.v_biasx) * c;
        this.p.y += (this.vy + this.v_biasy) * c;
        this.setAngleInternal(this.a + (this.w + this.w_bias) * c);
        this.w_bias = this.v_biasx = this.v_biasy = 0;
        this.sanityCheck()
    };
    C.prototype.resetForces = function () {
        this.activate();
        this.f = new u(0,
            0);
        this.t = 0
    };
    C.prototype.applyForce = function (c, d) {
        this.activate();
        this.f = z(this.f, c);
        this.t += I(d, c)
    };
    C.prototype.applyImpulse = function (c, d) {
        this.activate();
        Da(this, c.x, c.y, d)
    };
    C.prototype.getVelAtPoint = function (c) {
        return z(new u(this.vx, this.vy), D(N(c), this.w))
    };
    C.prototype.getVelAtWorldPoint = function (c) {
        return this.getVelAtPoint(y(c, this.p))
    };
    C.prototype.getVelAtLocalPoint = function (c) {
        return this.getVelAtPoint(G(c, this.rot))
    };
    C.prototype.eachShape = function (c) {
        for (var d = 0, e = this.shapeList.length; d <
        e; d++)c(this.shapeList[d])
    };
    C.prototype.eachConstraint = function (c) {
        for (var d = this.constraintList; d;) {
            var e = d.next(this);
            c(d);
            d = e
        }
    };
    C.prototype.eachArbiter = function (c) {
        for (var d = this.arbiterList; d;) {
            var e = d.next(this);
            d.swappedColl = this === d.body_b;
            c(d);
            d = e
        }
    };
    C.prototype.local2World = function (c) {
        return z(this.p, G(c, this.rot))
    };
    C.prototype.world2Local = function (c) {
        return Z(y(c, this.p), this.rot)
    };
    C.prototype.localToWorld = C.prototype.local2World;
    C.prototype.worldToLocal = C.prototype.world2Local;
    C.prototype.kineticEnergy =
        function () {
            var c = this.vx * this.vx + this.vy * this.vy, d = this.w * this.w;
            return (c ? c * this.m : 0) + (d ? d * this.i : 0)
        };
    var Ea = c.SpatialIndex = function (c) {
        if (this.staticIndex = c) {
            if (c.dynamicIndex)throw Error("This static index is already associated with a dynamic index.");
            c.dynamicIndex = this
        }
    };
    Ea.prototype.collideStatic = function (c, d) {
        if (0 < c.count) {
            var e = c.query;
            this.each(function (c) {
                e(c, new ea(c.bb_l, c.bb_b, c.bb_r, c.bb_t), d)
            })
        }
    };
    var J = c.BBTree = function (c) {
        Ea.call(this, c);
        this.velocityFunc = null;
        this.leaves = {};
        this.count =
            0;
        this.pooledPairs = this.pooledNodes = this.root = null;
        this.stamp = 0
    };
    J.prototype = Object.create(Ea.prototype);
    var mb = 0, aa = function (c, d, e) {
        this.obj = null;
        this.bb_l = h(d.bb_l, e.bb_l);
        this.bb_b = h(d.bb_b, e.bb_b);
        this.bb_r = k(d.bb_r, e.bb_r);
        this.bb_t = k(d.bb_t, e.bb_t);
        this.parent = null;
        this.setA(d);
        this.setB(e)
    };
    J.prototype.makeNode = function (c, d) {
        var e = this.pooledNodes;
        if (e)return this.pooledNodes = e.parent, e.constructor(this, c, d), e;
        mb++;
        return new aa(this, c, d)
    };
    var nb = 0, ba = function (c, d) {
        this.obj = d;
        c.getBB(d, this);
        this.parent = null;
        this.stamp = 1;
        this.pairs = null;
        nb++
    };
    J.prototype.getBB = function (c, d) {
        var e = this.velocityFunc;
        if (e) {
            var f = 0.1 * (c.bb_r - c.bb_l), g = 0.1 * (c.bb_t - c.bb_b), e = D(e(c), 0.1);
            d.bb_l = c.bb_l + h(-f, e.x);
            d.bb_b = c.bb_b + h(-g, e.y);
            d.bb_r = c.bb_r + k(f, e.x);
            d.bb_t = c.bb_t + k(g, e.y)
        } else d.bb_l = c.bb_l, d.bb_b = c.bb_b, d.bb_r = c.bb_r, d.bb_t = c.bb_t
    };
    J.prototype.getStamp = function () {
        var c = this.dynamicIndex;
        return c && c.stamp ? c.stamp : this.stamp
    };
    J.prototype.incrementStamp = function () {
        this.dynamicIndex && this.dynamicIndex.stamp ?
            this.dynamicIndex.stamp++ : this.stamp++
    };
    var ob = 0, Ra = function (c, d, e, f) {
        this.prevA = null;
        this.leafA = c;
        this.nextA = d;
        this.prevB = null;
        this.leafB = e;
        this.nextB = f
    };
    J.prototype.makePair = function (c, d, e, f) {
        var g = this.pooledPairs;
        if (g)return this.pooledPairs = g.prevA, g.prevA = null, g.leafA = c, g.nextA = d, g.prevB = null, g.leafB = e, g.nextB = f, g;
        ob++;
        return new Ra(c, d, e, f)
    };
    Ra.prototype.recycle = function (c) {
        this.prevA = c.pooledPairs;
        c.pooledPairs = this
    };
    var Sa = function (c, d, e) {
        e && (e.leafA === d ? e.prevA = c : e.prevB = c);
        c ? c.leafA ===
        d ? c.nextA = e : c.nextB = e : d.pairs = e
    };
    ba.prototype.clearPairs = function (c) {
        var d = this.pairs, e;
        for (this.pairs = null; d;)d.leafA === this ? (e = d.nextA, Sa(d.prevB, d.leafB, d.nextB)) : (e = d.nextB, Sa(d.prevA, d.leafA, d.nextA)), d.recycle(c), d = e
    };
    var Ta = function (c, d, e) {
        var f = c.pairs, g = d.pairs;
        e = e.makePair(c, f, d, g);
        c.pairs = d.pairs = e;
        f && (f.leafA === c ? f.prevA = e : f.prevB = e);
        g && (g.leafA === d ? g.prevA = e : g.prevB = e)
    };
    aa.prototype.recycle = function (c) {
        this.parent = c.pooledNodes;
        c.pooledNodes = this
    };
    ba.prototype.recycle = function (c) {
    };
    aa.prototype.setA =
        function (c) {
            this.A = c;
            c.parent = this
        };
    aa.prototype.setB = function (c) {
        this.B = c;
        c.parent = this
    };
    ba.prototype.isLeaf = !0;
    aa.prototype.isLeaf = !1;
    aa.prototype.otherChild = function (c) {
        return this.A == c ? this.B : this.A
    };
    aa.prototype.replaceChild = function (c, d, f) {
        e(c == this.A || c == this.B, "Node is not a child of parent.");
        this.A == c ? (this.A.recycle(f), this.setA(d)) : (this.B.recycle(f), this.setB(d));
        for (c = this; c; c = c.parent)d = c.A, f = c.B, c.bb_l = h(d.bb_l, f.bb_l), c.bb_b = h(d.bb_b, f.bb_b), c.bb_r = k(d.bb_r, f.bb_r), c.bb_t = k(d.bb_t,
            f.bb_t)
    };
    aa.prototype.bbArea = ba.prototype.bbArea = function () {
        return (this.bb_r - this.bb_l) * (this.bb_t - this.bb_b)
    };
    var Ua = function (c, d) {
        return (k(c.bb_r, d.bb_r) - h(c.bb_l, d.bb_l)) * (k(c.bb_t, d.bb_t) - h(c.bb_b, d.bb_b))
    }, Va = function (c, d) {
        return Math.abs(c.bb_l + c.bb_r - d.bb_l - d.bb_r) + Math.abs(c.bb_b + c.bb_t - d.bb_b - d.bb_t)
    }, na = function (c, d, e) {
        if (null == c)return d;
        if (c.isLeaf)return e.makeNode(d, c);
        var f = c.B.bbArea() + Ua(c.A, d), g = c.A.bbArea() + Ua(c.B, d);
        f === g && (f = Va(c.A, d), g = Va(c.B, d));
        g < f ? c.setB(na(c.B, d, e)) : c.setA(na(c.A,
            d, e));
        c.bb_l = h(c.bb_l, d.bb_l);
        c.bb_b = h(c.bb_b, d.bb_b);
        c.bb_r = k(c.bb_r, d.bb_r);
        c.bb_t = k(c.bb_t, d.bb_t);
        return c
    };
    aa.prototype.intersectsBB = ba.prototype.intersectsBB = function (c) {
        return this.bb_l <= c.r && c.l <= this.bb_r && this.bb_b <= c.t && c.b <= this.bb_t
    };
    var Fa = function (c, d, e) {
        c.intersectsBB(d) && (c.isLeaf ? e(c.obj) : (Fa(c.A, d, e), Fa(c.B, d, e)))
    }, Wa = function (c, d, e) {
        var f = 1 / (e.x - d.x), g = c.bb_l == d.x ? -Infinity : (c.bb_l - d.x) * f, m = c.bb_r == d.x ? Infinity : (c.bb_r - d.x) * f, f = h(g, m), g = k(g, m), m = 1 / (e.y - d.y);
        e = c.bb_b == d.y ? -Infinity :
        (c.bb_b - d.y) * m;
        d = c.bb_t == d.y ? Infinity : (c.bb_t - d.y) * m;
        c = h(e, d);
        d = k(e, d);
        return c <= g && f <= d && (f = k(f, c), 0 <= h(g, d) && 1 >= f) ? k(f, 0) : Infinity
    }, oa = function (c, d, e, f, g) {
        if (c.isLeaf)return g(c.obj);
        var k = Wa(c.A, d, e), m = Wa(c.B, d, e);
        k < m ? (k < f && (f = h(f, oa(c.A, d, e, f, g))), m < f && (f = h(f, oa(c.B, d, e, f, g)))) : (m < f && (f = h(f, oa(c.B, d, e, f, g))), k < f && (f = h(f, oa(c.A, d, e, f, g))));
        return f
    };
    J.prototype.subtreeRecycle = function (c) {
        c.isLeaf && (this.subtreeRecycle(c.A), this.subtreeRecycle(c.B), c.recycle(this))
    };
    var Xa = function (c, d, e) {
        if (d ==
            c)return null;
        var f = d.parent;
        if (f == c)return d = c.otherChild(d), d.parent = c.parent, c.recycle(e), d;
        f.parent.replaceChild(f, f.otherChild(d), e);
        return c
    }, Ya = function (c, d) {
        return c.bb_l <= d.bb_r && d.bb_l <= c.bb_r && c.bb_b <= d.bb_t && d.bb_b <= c.bb_t
    };
    ba.prototype.markLeafQuery = function (c, d, e, f) {
        Ya(c, this) && (d ? Ta(c, this, e) : (this.stamp < c.stamp && Ta(this, c, e), f && f(c.obj, this.obj)))
    };
    aa.prototype.markLeafQuery = function (c, d, e, f) {
        Ya(c, this) && (this.A.markLeafQuery(c, d, e, f), this.B.markLeafQuery(c, d, e, f))
    };
    ba.prototype.markSubtree =
        function (c, d, e) {
            if (this.stamp == c.getStamp())for (d && d.markLeafQuery(this, !1, c, e), d = this; d.parent; d = d.parent)d == d.parent.A ? d.parent.B.markLeafQuery(this, !0, c, e) : d.parent.A.markLeafQuery(this, !1, c, e); else for (c = this.pairs; c;)this === c.leafB ? (e && e(c.leafA.obj, this.obj), c = c.nextB) : c = c.nextA
        };
    aa.prototype.markSubtree = function (c, d, e) {
        this.A.markSubtree(c, d, e);
        this.B.markSubtree(c, d, e)
    };
    ba.prototype.containsObj = function (c) {
        return this.bb_l <= c.bb_l && this.bb_r >= c.bb_r && this.bb_b <= c.bb_b && this.bb_t >= c.bb_t
    };
    ba.prototype.update = function (c) {
        var d = c.root;
        return this.containsObj(this.obj) ? !1 : (c.getBB(this.obj, this), d = Xa(d, this, c), c.root = na(d, this, c), this.clearPairs(c), this.stamp = c.getStamp(), !0)
    };
    ba.prototype.addPairs = function (c) {
        var d = c.dynamicIndex;
        d ? (c = d.root) && c.markLeafQuery(this, !0, d, null) : this.markSubtree(c, c.staticIndex.root, null)
    };
    J.prototype.insert = function (c, d) {
        var e = new ba(this, c);
        this.leaves[d] = e;
        this.root = na(this.root, e, this);
        this.count++;
        e.stamp = this.getStamp();
        e.addPairs(this);
        this.incrementStamp()
    };
    J.prototype.remove = function (c, d) {
        var e = this.leaves[d];
        delete this.leaves[d];
        this.root = Xa(this.root, e, this);
        this.count--;
        e.clearPairs(this);
        e.recycle(this)
    };
    J.prototype.contains = function (c, d) {
        return null != this.leaves[d]
    };
    var pb = function (c, d) {
    };
    J.prototype.reindexQuery = function (c) {
        if (this.root) {
            var d, e = this.leaves;
            for (d in e)e[d].update(this);
            e = (d = this.staticIndex) && d.root;
            this.root.markSubtree(this, e, c);
            d && !e && this.collideStatic(this, d, c);
            this.incrementStamp()
        }
    };
    J.prototype.reindex = function () {
        this.reindexQuery(pb)
    };
    J.prototype.reindexObject = function (c, d) {
        var e = this.leaves[d];
        e && (e.update(this) && e.addPairs(this), this.incrementStamp())
    };
    J.prototype.pointQuery = function (c, d) {
        this.query(new ea(c.x, c.y, c.x, c.y), d)
    };
    J.prototype.segmentQuery = function (c, d, e, f) {
        this.root && oa(this.root, c, d, e, f)
    };
    J.prototype.query = function (c, d) {
        this.root && Fa(this.root, c, d)
    };
    J.prototype.count = function () {
        return this.count
    };
    J.prototype.each = function (c) {
        for (var d in this.leaves)c(this.leaves[d].obj)
    };
    var Za = function (c, d, e, f, g) {
        return (k(c.bb_r,
                f) - h(c.bb_l, d)) * (k(c.bb_t, g) - h(c.bb_b, e))
    }, Ga = function (c, d, e, f) {
        if (1 == f)return d[e];
        if (2 == f)return c.makeNode(d[e], d[e + 1]);
        for (var g = d[e], m = g.bb_l, n = g.bb_b, p = g.bb_r, r = g.bb_t, s = e + f, t = e + 1; t < s; t++)g = d[t], m = h(m, g.bb_l), n = h(n, g.bb_b), p = k(p, g.bb_r), r = k(r, g.bb_t);
        var g = p - m > r - n, u = Array(2 * f);
        if (g)for (t = e; t < s; t++)u[2 * t + 0] = d[t].bb_l, u[2 * t + 1] = d[t].bb_r; else for (t = e; t < s; t++)u[2 * t + 0] = d[t].bb_b, u[2 * t + 1] = d[t].bb_t;
        u.sort(function (c, d) {
            return c - d
        });
        var v = 0.5 * (u[f - 1] + u[f]), t = m, u = n, w = p, x = r;
        g ? w = m = v : x = n = v;
        for (var v = s,
                 y = e; y < v;)g = d[y], Za(g, m, n, p, r) < Za(g, t, u, w, x) ? (v--, d[y] = d[v], d[v] = g) : y++;
        if (v == f) {
            g = null;
            for (t = e; t < s; t++)g = na(g, d[t], c);
            return g
        }
        return NodeNew(c, Ga(c, d, e, v - e), Ga(c, d, v, s - v))
    };
    J.prototype.optimize = function () {
        var c = Array(this.count), d = 0, e;
        for (e in this.leaves)c[d++] = this.nodes[e];
        tree.subtreeRecycle(root);
        this.root = Ga(tree, c, c.length)
    };
    var Ha = function (c, d) {
        !c.isLeaf && 10 >= d && (Ha(c.A, d + 1), Ha(c.B, d + 1));
        for (var e = "", f = 0; f < d; f++)e += " ";
        console.log(e + c.bb_b + " " + c.bb_t)
    };
    J.prototype.log = function () {
        this.root &&
        Ha(this.root, 0)
    };
    var ia = c.CollisionHandler = function () {
        this.a = this.b = 0
    };
    ia.prototype.begin = function (c, d) {
        return !0
    };
    ia.prototype.preSolve = function (c, d) {
        return !0
    };
    ia.prototype.postSolve = function (c, d) {
    };
    ia.prototype.separate = function (c, d) {
    };
    var M = function (c, d) {
        this.u = this.e = 0;
        this.surface_vr = A;
        this.a = c;
        this.body_a = c.body;
        this.b = d;
        this.body_b = d.body;
        this.contacts = this.thread_b_next = this.thread_b_prev = this.thread_a_next = this.thread_a_prev = null;
        this.stamp = 0;
        this.handler = null;
        this.swappedColl = !1;
        this.state =
            "first coll"
    };
    M.prototype.getShapes = function () {
        return this.swappedColl ? [this.b, this.a] : [this.a, this.b]
    };
    M.prototype.totalImpulse = function () {
        for (var c = this.contacts, d = new u(0, 0), e = 0, f = c.length; e < f; e++) {
            var g = c[e];
            d.add(D(g.n, g.jnAcc))
        }
        return this.swappedColl ? d : d.neg()
    };
    M.prototype.totalImpulseWithFriction = function () {
        for (var c = this.contacts, d = new u(0, 0), e = 0, f = c.length; e < f; e++) {
            var g = c[e];
            d.add((new u(g.jnAcc, g.jtAcc)).rotate(g.n))
        }
        return this.swappedColl ? d : d.neg()
    };
    M.prototype.totalKE = function () {
        for (var c =
            (1 - this.e) / (1 + this.e), d = 0, e = this.contacts, f = 0, g = e.length; f < g; f++)var h = e[f], k = h.jnAcc, m = h.jtAcc, d = d + (c * k * k / h.nMass + m * m / h.tMass);
        return d
    };
    M.prototype.ignore = function () {
        this.state = "ignore"
    };
    M.prototype.getA = function () {
        return this.swappedColl ? this.b : this.a
    };
    M.prototype.getB = function () {
        return this.swappedColl ? this.a : this.b
    };
    M.prototype.isFirstContact = function () {
        return "first coll" === this.state
    };
    var $a = function (c, d, e) {
        this.point = c;
        this.normal = d;
        this.dist = e
    };
    M.prototype.getContactPointSet = function () {
        var c =
            Array(this.contacts.length), d;
        for (d = 0; d < c.length; d++)c[d] = new $a(this.contacts[d].p, this.contacts[d].n, this.contacts[d].dist);
        return c
    };
    M.prototype.getNormal = function (c) {
        c = this.contacts[c].n;
        return this.swappedColl ? K(c) : c
    };
    M.prototype.getPoint = function (c) {
        return this.contacts[c].p
    };
    M.prototype.getDepth = function (c) {
        return this.contacts[c].dist
    };
    var ab = function (c, d, e, f) {
        e ? e.body_a === d ? e.thread_a_next = f : e.thread_b_next = f : d.arbiterList = f;
        f && (f.body_a === d ? f.thread_a_prev = e : f.thread_b_prev = e)
    };
    M.prototype.unthread =
        function () {
            ab(this, this.body_a, this.thread_a_prev, this.thread_a_next);
            ab(this, this.body_b, this.thread_b_prev, this.thread_b_next);
            this.thread_b_prev = this.thread_b_next = this.thread_a_prev = this.thread_a_next = null
        };
    M.prototype.update = function (c, d, e, f) {
        if (this.contacts)for (var g = 0; g < this.contacts.length; g++)for (var h = this.contacts[g], k = 0; k < c.length; k++) {
            var m = c[k];
            m.hash === h.hash && (m.jnAcc = h.jnAcc, m.jtAcc = h.jtAcc)
        }
        this.contacts = c;
        this.handler = d;
        this.swappedColl = e.collision_type !== d.a;
        this.e = e.e * f.e;
        this.u =
            e.u * f.u;
        this.surface_vr = y(e.surface_v, f.surface_v);
        this.a = e;
        this.body_a = e.body;
        this.b = f;
        this.body_b = f.body;
        "cached" == this.state && (this.state = "first coll")
    };
    M.prototype.preStep = function (c, d, e) {
        for (var f = this.body_a, g = this.body_b, k = 0; k < this.contacts.length; k++) {
            var m = this.contacts[k];
            m.r1 = y(m.p, f.p);
            m.r2 = y(m.p, g.p);
            m.nMass = 1 / pa(f, g, m.r1, m.r2, m.n);
            m.tMass = 1 / pa(f, g, m.r1, m.r2, N(m.n));
            m.bias = -e * h(0, m.dist + d) / c;
            m.jBias = 0;
            m.bounce = Ia(f, g, m.r1, m.r2, m.n) * this.e
        }
    };
    M.prototype.applyCachedImpulse = function (c) {
        if (!this.isFirstContact())for (var d =
            this.body_a, e = this.body_b, f = 0; f < this.contacts.length; f++) {
            var g = this.contacts[f], h = g.n.x, k = g.n.y;
            W(d, e, g.r1, g.r2, (h * g.jnAcc - k * g.jtAcc) * c, (h * g.jtAcc + k * g.jnAcc) * c)
        }
    };
    var qb = 0, rb = 0;
    M.prototype.applyImpulse = function () {
        qb++;
        for (var c = this.body_a, d = this.body_b, e = this.surface_vr, f = this.u, g = 0; g < this.contacts.length; g++) {
            rb++;
            var h = this.contacts[g], m = h.nMass, n = h.n, p = h.r1, r = h.r2, s = d.vx - r.y * d.w - (c.vx - p.y * c.w), u = d.vy + r.x * d.w - (c.vy + p.x * c.w), v = s * n.x + u * n.y, w = (s + e.x) * -n.y + (u + e.y) * n.x, u = h.jBias;
            h.jBias = k(u + (h.bias -
                (n.x * (d.v_biasx - r.y * d.w_bias - c.v_biasx + p.y * c.w_bias) + n.y * (r.x * d.w_bias + d.v_biasy - p.x * c.w_bias - c.v_biasy))) * m, 0);
            s = h.jnAcc;
            h.jnAcc = k(s + -(h.bounce + v) * m, 0);
            v = f * h.jnAcc;
            m = h.jtAcc;
            h.jtAcc = t(m + -w * h.tMass, -v, v);
            v = n.x * (h.jBias - u);
            u = n.y * (h.jBias - u);
            bb(c, -v, -u, p);
            bb(d, v, u, r);
            s = h.jnAcc - s;
            h = h.jtAcc - m;
            W(c, d, p, r, n.x * s - n.y * h, n.x * h + n.y * s)
        }
    };
    M.prototype.callSeparate = function (c) {
        c.lookupHandler(this.a.collision_type, this.b.collision_type).separate(this, c)
    };
    M.prototype.next = function (c) {
        return this.body_a == c ? this.thread_a_next :
            this.thread_b_next
    };
    var sb = 0, da = function (c, d, e, f) {
        this.p = c;
        this.n = d;
        this.dist = e;
        this.r1 = this.r2 = A;
        this.jnAcc = this.jtAcc = this.jBias = this.nMass = this.tMass = this.bounce = this.bias = 0;
        this.hash = f;
        sb++
    }, X = [], ga = function (c, d, e, f) {
        f = e + f;
        d = y(d, c);
        var g = L(d);
        if (!(g >= f * f))return g = Math.sqrt(g), new da(z(c, D(d, 0.5 + (e - 0.5 * f) / (g ? g : Infinity))), g ? D(d, 1 / g) : new u(1, 0), g - f, 0)
    }, Ja = 0, cb = function (c, d) {
        var e = 0, f = c.valueOnAxis(d[0].n, d[0].d);
        if (0 < f)return -1;
        for (var g = 1; g < d.length; g++) {
            var h = c.valueOnAxis(d[g].n, d[g].d);
            if (0 <
                h)return -1;
            h > f && (f = h, e = g)
        }
        Ja = f;
        return e
    }, db = function (c, d, e, f) {
        for (var g = [], h = c.tVerts, k = 0; k < h.length; k += 2) {
            var n = h[k], p = h[k + 1];
            d.containsVert(n, p) && g.push(new da(new u(n, p), e, f, m(c.hashid, k >> 1)))
        }
        h = d.tVerts;
        for (k = 0; k < h.length; k += 2)n = h[k], p = h[k + 1], c.containsVert(n, p) && g.push(new da(new u(n, p), e, f, m(d.hashid, k >> 1)));
        if (!g.length) {
            g = [];
            h = c.tVerts;
            for (k = 0; k < h.length; k += 2)n = h[k], p = h[k + 1], d.containsVertPartial(n, p, K(e)) && g.push(new da(new u(n, p), e, f, m(c.hashid, k)));
            h = d.tVerts;
            for (k = 0; k < h.length; k += 2)n =
                h[k], p = h[k + 1], c.containsVertPartial(n, p, e) && g.push(new da(new u(n, p), e, f, m(d.hashid, k)))
        }
        return c = g
    }, eb = function (c, d, e) {
        var f = x(d, c.ta) - c.r;
        c = x(d, c.tb) - c.r;
        return h(f, c) - e
    }, fb = function (c, d, e, f, g) {
        for (var h = I(d.tn, d.ta), k = I(d.tn, d.tb), n = D(d.tn, g), p = e.tVerts, r = 0; r < p.length; r += 2) {
            var s = p[r], t = p[r + 1];
            if (s * n.x + t * n.y < x(d.tn, d.ta) * g + d.r) {
                var v = d.tn.x * t - d.tn.y * s;
                h >= v && v >= k && c.push(new da(new u(s, t), n, f, m(e.hashid, r)))
            }
        }
    };
    ka.prototype.collisionCode = 0;
    fa.prototype.collisionCode = 1;
    Q.prototype.collisionCode =
        2;
    ka.prototype.collisionTable = [function (c, d) {
        var e = ga(c.tc, d.tc, c.r, d.r);
        return e ? [e] : X
    }, function (c, d) {
        var e = d.ta, f = c.tc, g = y(d.tb, e), h = w(x(g, y(f, e)) / L(g)), e = z(e, D(g, h));
        return (f = ga(f, e, c.r, d.r)) ? (e = f.n, 0 === h && 0 > x(e, d.a_tangent) || 1 === h && 0 > x(e, d.b_tangent) ? X : [f]) : X
    }, function (c, d) {
        for (var e = d.tPlanes, f = 0, g = x(e[0].n, c.tc) - e[0].d - c.r, h = 0; h < e.length; h++) {
            var k = x(e[h].n, c.tc) - e[h].d - c.r;
            if (0 < k)return X;
            k > g && (g = k, f = h)
        }
        var e = e[f].n, m = d.tVerts, n = m.length, p = f << 1, f = m[p], h = m[p + 1], k = m[(p + 2) % n], m = m[(p + 3) % n], n = e.x *
            h - e.y * f, p = e.x * m - e.y * k, r = I(e, c.tc);
        if (r < p) {
            var s = ga(c.tc, new u(k, m), c.r, 0, s);
            return s ? [s] : X
        }
        return r < n ? [new da(y(c.tc, D(e, c.r + g / 2)), K(e), g, 0)] : (s = ga(c.tc, new u(f, h), c.r, 0, s)) ? [s] : X
    }];
    fa.prototype.collisionTable = [null, function (c, d) {
        return X
    }, function (c, d) {
        var e = [], f = d.tPlanes, g = f.length, h = x(c.tn, c.ta), k = d.valueOnAxis(c.tn, h) - c.r, h = d.valueOnAxis(K(c.tn), -h) - c.r;
        if (0 < h || 0 < k)return X;
        var n = 0, p = eb(c, f[0].n, f[0].d);
        if (0 < p)return X;
        for (var r = 0; r < g; r++) {
            var s = eb(c, f[r].n, f[r].d);
            if (0 < s)return X;
            s > p && (p = s,
                n = r)
        }
        f = K(f[n].n);
        r = z(c.ta, D(f, c.r));
        s = z(c.tb, D(f, c.r));
        d.containsVert(r.x, r.y) && e.push(new da(r, f, p, m(c.hashid, 0)));
        d.containsVert(s.x, s.y) && e.push(new da(s, f, p, m(c.hashid, 1)));
        if (k >= p || h >= p)k > h ? fb(e, c, d, k, 1) : fb(e, c, d, h, -1);
        if (0 === e.length) {
            k = 2 * n;
            h = d.tVerts;
            p = new u(h[k], h[k + 1]);
            if ((n = ga(c.ta, p, c.r, 0, e)) || (n = ga(c.tb, p, c.r, 0, e)))return [n];
            g *= 2;
            g = new u(h[(k + 2) % g], h[(k + 3) % g]);
            if ((n = ga(c.ta, g, c.r, 0, e)) || (n = ga(c.tb, g, c.r, 0, e)))return [n]
        }
        return e
    }];
    Q.prototype.collisionTable = [null, null, function (c, d) {
        var e =
            cb(d, c.tPlanes);
        if (-1 == e)return X;
        var f = Ja, g = cb(c, d.tPlanes);
        if (-1 == g)return X;
        var h = Ja;
        return f > h ? db(c, d, c.tPlanes[e].n, f) : db(c, d, K(d.tPlanes[g].n), h)
    }];
    var Ka = c.collideShapes = function (c, e) {
        d(c.collisionCode <= e.collisionCode, "Collided shapes must be sorted by type");
        return c.collisionTable[e.collisionCode](c, e)
    }, gb = new ia, E = c.Space = function () {
        this.curr_dt = this.stamp = 0;
        this.bodies = [];
        this.rousedBodies = [];
        this.sleepingComponents = [];
        this.staticShapes = new J(null);
        this.activeShapes = new J(this.staticShapes);
        this.arbiters = [];
        this.contactBuffersHead = null;
        this.cachedArbiters = {};
        this.constraints = [];
        this.locked = 0;
        this.collisionHandlers = {};
        this.defaultHandler = gb;
        this.postStepCallbacks = [];
        this.iterations = 10;
        this.gravity = A;
        this.damping = 1;
        this.idleSpeedThreshold = 0;
        this.sleepTimeThreshold = Infinity;
        this.collisionSlop = 0.1;
        this.collisionBias = Math.pow(0.9, 60);
        this.collisionPersistence = 3;
        this.enableContactGraph = !1;
        this.staticBody = new C(Infinity, Infinity);
        this.staticBody.nodeIdleTime = Infinity;
        this.collideShapes = this.makeCollideShapes()
    };
    E.prototype.getCurrentTimeStep = function () {
        return this.curr_dt
    };
    E.prototype.setIterations = function (c) {
        this.iterations = c
    };
    E.prototype.isLocked = function () {
        return this.locked
    };
    var ca = function (c) {
        d(!c.locked, "This addition/removal cannot be done safely during a call to cpSpaceStep()  or during a query. Put these calls into a post-step callback.")
    };
    E.prototype.addCollisionHandler = function (c, d, e, f, g, h) {
        ca(this);
        this.removeCollisionHandler(c, d);
        var k = new ia;
        k.a = c;
        k.b = d;
        e && (k.begin = e);
        f && (k.preSolve = f);
        g &&
        (k.postSolve = g);
        h && (k.separate = h);
        this.collisionHandlers[m(c, d)] = k
    };
    E.prototype.removeCollisionHandler = function (c, d) {
        ca(this);
        delete this.collisionHandlers[m(c, d)]
    };
    E.prototype.setDefaultCollisionHandler = function (c, d, e, f) {
        ca(this);
        var g = new ia;
        c && (g.begin = c);
        d && (g.preSolve = d);
        e && (g.postSolve = e);
        f && (g.separate = f);
        this.defaultHandler = g
    };
    E.prototype.lookupHandler = function (c, d) {
        return this.collisionHandlers[m(c, d)] || this.defaultHandler
    };
    E.prototype.addShape = function (c) {
        var e = c.body;
        if (e.isStatic())return this.addStaticShape(c);
        d(!c.space, "This shape is already added to a space and cannot be added to another.");
        ca(this);
        e.activate();
        e.addShape(c);
        c.update(e.p, e.rot);
        this.activeShapes.insert(c, c.hashid);
        c.space = this;
        return c
    };
    E.prototype.addStaticShape = function (c) {
        d(!c.space, "This shape is already added to a space and cannot be added to another.");
        ca(this);
        var e = c.body;
        e.addShape(c);
        c.update(e.p, e.rot);
        this.staticShapes.insert(c, c.hashid);
        c.space = this;
        return c
    };
    E.prototype.addBody = function (c) {
        d(!c.isStatic(), "Static bodies cannot be added to a space as they are not meant to be simulated.");
        d(!c.space, "This body is already added to a space and cannot be added to another.");
        ca(this);
        this.bodies.push(c);
        c.space = this;
        return c
    };
    E.prototype.addConstraint = function (c) {
        d(!c.space, "This shape is already added to a space and cannot be added to another.");
        ca(this);
        var e = c.a, f = c.b;
        e.activate();
        f.activate();
        this.constraints.push(c);
        c.next_a = e.constraintList;
        e.constraintList = c;
        c.next_b = f.constraintList;
        f.constraintList = c;
        c.space = this;
        return c
    };
    E.prototype.filterArbiters = function (c, d) {
        for (var e in this.cachedArbiters) {
            var f =
                this.cachedArbiters[e];
            if (c === f.body_a && (d === f.a || null === d) || c === f.body_b && (d === f.b || null === d))d && "cached" !== f.state && f.callSeparate(this), f.unthread(), n(this.arbiters, f), delete this.cachedArbiters[e]
        }
    };
    E.prototype.removeShape = function (c) {
        var e = c.body;
        e.isStatic() ? this.removeStaticShape(c) : (d(this.containsShape(c), "Cannot remove a shape that was not added to the space. (Removed twice maybe?)"), ca(this), e.activate(), e.removeShape(c), this.filterArbiters(e, c), this.activeShapes.remove(c, c.hashid), c.space =
            null)
    };
    E.prototype.removeStaticShape = function (c) {
        d(this.containsShape(c), "Cannot remove a static or sleeping shape that was not added to the space. (Removed twice maybe?)");
        ca(this);
        var e = c.body;
        e.isStatic() && e.activateStatic(c);
        e.removeShape(c);
        this.filterArbiters(e, c);
        this.staticShapes.remove(c, c.hashid);
        c.space = null
    };
    E.prototype.removeBody = function (c) {
        d(this.containsBody(c), "Cannot remove a body that was not added to the space. (Removed twice maybe?)");
        ca(this);
        c.activate();
        n(this.bodies, c);
        c.space =
            null
    };
    E.prototype.removeConstraint = function (c) {
        d(this.containsConstraint(c), "Cannot remove a constraint that was not added to the space. (Removed twice maybe?)");
        ca(this);
        c.a.activate();
        c.b.activate();
        n(this.constraints, c);
        c.a.removeConstraint(c);
        c.b.removeConstraint(c);
        c.space = null
    };
    E.prototype.containsShape = function (c) {
        return c.space === this
    };
    E.prototype.containsBody = function (c) {
        return c.space == this
    };
    E.prototype.containsConstraint = function (c) {
        return c.space == this
    };
    E.prototype.uncacheArbiter = function (c) {
        delete this.cachedArbiters[m(c.a.hashid,
            c.b.hashid)];
        n(this.arbiters, c)
    };
    E.prototype.eachBody = function (c) {
        this.lock();
        for (var d = this.bodies, e = 0; e < d.length; e++)c(d[e]);
        d = this.sleepingComponents;
        for (e = 0; e < d.length; e++)for (var f = d[e]; f;) {
            var g = f.nodeNext;
            c(f);
            f = g
        }
        this.unlock(!0)
    };
    E.prototype.eachShape = function (c) {
        this.lock();
        this.activeShapes.each(c);
        this.staticShapes.each(c);
        this.unlock(!0)
    };
    E.prototype.eachConstraint = function (c) {
        this.lock();
        for (var d = this.constraints, e = 0; e < d.length; e++)c(d[e]);
        this.unlock(!0)
    };
    E.prototype.reindexStatic =
        function () {
            d(!this.locked, "You cannot manually reindex objects while the space is locked. Wait until the current query or step is complete.");
            this.staticShapes.each(function (c) {
                var d = c.body;
                c.update(d.p, d.rot)
            });
            this.staticShapes.reindex()
        };
    E.prototype.reindexShape = function (c) {
        d(!this.locked, "You cannot manually reindex objects while the space is locked. Wait until the current query or step is complete.");
        var e = c.body;
        c.update(e.p, e.rot);
        this.activeShapes.reindexObject(c, c.hashid);
        this.staticShapes.reindexObject(c,
            c.hashid)
    };
    E.prototype.reindexShapesForBody = function (c) {
        for (c = c.shapeList; c; c = c.next)this.reindexShape(c)
    };
    E.prototype.useSpatialHash = function (c, d) {
        throw Error("Spatial Hash not implemented.");
    };
    E.prototype.activateBody = function (c) {
        d(!c.isRogue(), "Internal error: Attempting to activate a rogue body.");
        if (this.locked)-1 === this.rousedBodies.indexOf(c) && this.rousedBodies.push(c); else {
            this.bodies.push(c);
            for (var e = 0; e < c.shapeList.length; e++) {
                var f = c.shapeList[e];
                this.staticShapes.remove(f, f.hashid);
                this.activeShapes.insert(f,
                    f.hashid)
            }
            for (e = c.arbiterList; e; e = e.next(c))if (f = e.body_a, c === f || f.isStatic()) {
                var f = e.a, g = e.b;
                this.cachedArbiters[m(f.hashid, g.hashid)] = e;
                e.stamp = this.stamp;
                e.handler = this.lookupHandler(f.collision_type, g.collision_type);
                this.arbiters.push(e)
            }
            for (e = c.constraintList; e; e = e.nodeNext)f = e.a, (c === f || f.isStatic()) && this.constraints.push(e)
        }
    };
    E.prototype.deactivateBody = function (c) {
        d(!c.isRogue(), "Internal error: Attempting to deactivate a rogue body.");
        n(this.bodies, c);
        for (var e = 0; e < c.shapeList.length; e++) {
            var f =
                c.shapeList[e];
            this.activeShapes.remove(f, f.hashid);
            this.staticShapes.insert(f, f.hashid)
        }
        for (f = c.arbiterList; f; f = f.next(c))e = f.body_a, (c === e || e.isStatic()) && this.uncacheArbiter(f);
        for (f = c.constraintList; f; f = f.nodeNext)e = f.a, (c === e || e.isStatic()) && n(this.constraints, f)
    };
    C.prototype.activate = function () {
        if (!this.isRogue()) {
            this.nodeIdleTime = 0;
            var c = this ? this.nodeRoot : null;
            if (c && c.isSleeping(c)) {
                d(!c.isRogue(), "Internal Error: componentActivate() called on a rogue body.");
                for (var e = c.space, f = c; f;) {
                    var g =
                        f.nodeNext;
                    f.nodeIdleTime = 0;
                    f.nodeRoot = null;
                    f.nodeNext = null;
                    e.activateBody(f);
                    f = g
                }
                n(e.sleepingComponents, c)
            }
        }
    };
    C.prototype.activateStatic = function (c) {
        d(this.isStatic(), "Body.activateStatic() called on a non-static body.");
        for (var e = this.arbiterList; e; e = e.next(this))c && c != e.a && c != e.b || (e.body_a == this ? e.body_b : e.body_a).activate()
    };
    C.prototype.pushArbiter = function (c) {
        e(null === (c.body_a === this ? c.thread_a_next : c.thread_b_next), "Internal Error: Dangling contact graph pointers detected. (A)");
        e(null ===
            (c.body_a === this ? c.thread_a_prev : c.thread_b_prev), "Internal Error: Dangling contact graph pointers detected. (B)");
        var d = this.arbiterList;
        e(null === d || null === (d.body_a === this ? d.thread_a_prev : d.thread_b_prev), "Internal Error: Dangling contact graph pointers detected. (C)");
        c.body_a === this ? c.thread_a_next = d : c.thread_b_next = d;
        d && (d.body_a === this ? d.thread_a_prev = c : d.thread_b_prev = c);
        this.arbiterList = c
    };
    var La = function (c, d) {
        if (!d.isRogue()) {
            var f = d ? d.nodeRoot : null;
            if (null == f) {
                d.nodeRoot = c;
                d !== c && (d.nodeNext =
                    c.nodeNext, c.nodeNext = d);
                for (f = d.arbiterList; f; f = f.next(d))La(c, d == f.body_a ? f.body_b : f.body_a);
                for (f = d.constraintList; f; f = f.next(d))La(c, d == f.a ? f.b : f.a)
            } else e(f === c, "Internal Error: Inconsistency detected in the contact graph.")
        }
    };
    E.prototype.processComponents = function (c) {
        for (var d = Infinity !== this.sleepTimeThreshold, f = this.bodies, g = 0; g < f.length; g++) {
            var h = f[g];
            e(null === h.nodeNext, "Internal Error: Dangling next pointer detected in contact graph.");
            e(null === h.nodeRoot, "Internal Error: Dangling root pointer detected in contact graph.")
        }
        if (d)for (var k =
            (g = this.idleSpeedThreshold) ? g * g : L(this.gravity) * c * c, g = 0; g < f.length; g++) {
            var h = f[g], m = k ? h.m * k : 0;
            h.nodeIdleTime = h.kineticEnergy() > m ? 0 : h.nodeIdleTime + c
        }
        k = this.arbiters;
        g = 0;
        for (m = k.length; g < m; g++) {
            var n = k[g], h = n.body_a;
            c = n.body_b;
            d && ((c.isRogue() && !c.isStatic() || h.isSleeping()) && h.activate(), (h.isRogue() && !h.isStatic() || c.isSleeping()) && c.activate());
            h.pushArbiter(n);
            c.pushArbiter(n)
        }
        if (d) {
            d = this.constraints;
            for (g = 0; g < d.length; g++)c = d[g], h = c.a, c = c.b, c.isRogue() && !c.isStatic() && h.activate(), h.isRogue() && !h.isStatic() && c.activate();
            for (g = 0; g < f.length;) {
                h = f[g];
                if (null === (h ? h.nodeRoot : null)) {
                    La(h, h);
                    a:{
                        for (d = h; d; d = d.nodeNext)if (d.nodeIdleTime < this.sleepTimeThreshold) {
                            d = !0;
                            break a
                        }
                        d = !1
                    }
                    if (!d) {
                        this.sleepingComponents.push(h);
                        for (d = h; d; d = d.nodeNext)this.deactivateBody(d);
                        continue
                    }
                }
                g++;
                h.nodeRoot = null;
                h.nodeNext = null
            }
        }
    };
    C.prototype.sleep = function () {
        this.sleepWithGroup(null)
    };
    C.prototype.sleepWithGroup = function (c) {
        d(!this.isStatic() && !this.isRogue(), "Rogue and static bodies cannot be put to sleep.");
        var e =
            this.space;
        d(e, "Cannot put a rogue body to sleep.");
        d(!e.locked, "Bodies cannot be put to sleep during a query or a call to cpSpaceStep(). Put these calls into a post-step callback.");
        d(null === c || c.isSleeping(), "Cannot use a non-sleeping body as a group identifier.");
        if (this.isSleeping())d((this ? this.nodeRoot : null) === (c ? c.nodeRoot : null), "The body is already sleeping and it's group cannot be reassigned."); else {
            for (var f = 0; f < this.shapeList.length; f++)this.shapeList[f].update(this.p, this.rot);
            e.deactivateBody(this);
            c ? (this.nodeRoot = c = c ? c.nodeRoot : null, this.nodeNext = c.nodeNext, this.nodeIdleTime = 0, c.nodeNext = this) : (this.nodeRoot = this, this.nodeNext = null, this.nodeIdleTime = 0, e.sleepingComponents.push(this));
            n(e.bodies, this)
        }
    };
    E.prototype.activateShapesTouchingShape = function (c) {
        Infinity !== this.sleepTimeThreshold && this.shapeQuery(c, function (c, d) {
            c.body.activate()
        })
    };
    E.prototype.pointQuery = function (c, d, e, f) {
        var g = function (g) {
            (!g.group || e !== g.group) && d & g.layers && g.pointQuery(c) && f(g)
        }, h = new ea(c.x, c.y, c.x, c.y);
        this.lock();
        this.activeShapes.query(h, g);
        this.staticShapes.query(h, g);
        this.unlock(!0)
    };
    E.prototype.pointQueryFirst = function (c, d, e) {
        var f = null;
        this.pointQuery(c, d, e, function (c) {
            c.sensor || (f = c)
        });
        return f
    };
    E.prototype.nearestPointQuery = function (c, d, e, f, g) {
        var h = function (h) {
            if ((!h.group || f !== h.group) && e & h.layers) {
                var k = h.nearestPointQuery(c);
                k.d < d && g(h, k.d, k.p)
            }
        }, k = Pa(c, d);
        this.lock();
        this.activeShapes.query(k, h);
        this.staticShapes.query(k, h);
        this.unlock(!0)
    };
    E.prototype.nearestPointQueryNearest = function (c, d, e, f) {
        var g,
            h = function (h) {
                h.group && f === h.group || !(e & h.layers) || h.sensor || (h = h.nearestPointQuery(c), h.d < d && (!g || h.d < g.d) && (g = h))
            }, k = Pa(c, d);
        this.activeShapes.query(k, h);
        this.staticShapes.query(k, h);
        return g
    };
    c.SHAPE_FILTER_ALL = {group: c.NO_GROUP, categories: c.ALL_CATEGORIES, mask: c.ALL_CATEGORIES};
    E.prototype.pointQueryNearest = function (c, d, e) {
        c = this.nearestPointQueryNearest(c, d, e.mask, e.group);
        "undefined" != typeof c && (c.distance = c.d, c.point = c.p);
        return c
    };
    E.prototype.segmentQuery = function (c, d, e, f, g) {
        var h = function (h) {
            var k;
            (!h.group || f !== h.group) && e & h.layers && (k = h.segmentQuery(c, d)) && g(h, k.t, k.n);
            return 1
        };
        this.lock();
        this.staticShapes.segmentQuery(c, d, 1, h);
        this.activeShapes.segmentQuery(c, d, 1, h);
        this.unlock(!0)
    };
    E.prototype.segmentQueryFirst = function (d, e, f, g) {
        var h = null, k = function (c) {
            var k;
            (!c.group || g !== c.group) && f & c.layers && !c.sensor && (k = c.segmentQuery(d, e)) && (null === h || k.t < h.t) && (h = k);
            return h ? h.t : 1
        };
        this.staticShapes.segmentQuery(d, e, 1, k);
        this.activeShapes.segmentQuery(d, e, h ? h.t : 1, k);
        h && "null" !== h && "undefined" !==
        h && (h.normal = h.n, h.alpha = h.t, h.p = h.point = c.v.lerp(d, e, h.t));
        return h
    };
    E.prototype.bbQuery = function (c, d, e, f) {
        var g = function (g) {
            (!g.group || e !== g.group) && d & g.layers && c.l <= g.bb_r && g.bb_l <= c.r && c.b <= g.bb_t && g.bb_b <= c.t && f(g)
        };
        this.lock();
        this.activeShapes.query(c, g);
        this.staticShapes.query(c, g);
        this.unlock(!0)
    };
    E.prototype.shapeQuery = function (c, d) {
        var e = c.body;
        e && c.update(e.p, e.rot);
        var e = new ea(c.bb_l, c.bb_b, c.bb_r, c.bb_t), f = !1, g = function (e) {
            if ((!c.group || c.group !== e.group) && c.layers & e.layers && c !== e) {
                var g;
                if (c.collisionCode <= e.collisionCode)g = Ka(c, e); else {
                    g = Ka(e, c);
                    for (var h = 0; h < g.length; h++)g[h].n = K(g[h].n)
                }
                if (g.length && (f = !(c.sensor || e.sensor), d)) {
                    for (var k = Array(g.length), h = 0; h < g.length; h++)k[h] = new $a(g[h].p, g[h].n, g[h].dist);
                    d(e, k)
                }
            }
        };
        this.lock();
        this.activeShapes.query(e, g);
        this.staticShapes.query(e, g);
        this.unlock(!0);
        return f
    };
    E.prototype.addPostStepCallback = function (c) {
        e(this.locked, "Adding a post-step callback when the space is not locked is unnecessary. Post-step callbacks will not called until the end of the next call to cpSpaceStep() or the next query.");
        this.postStepCallbacks.push(c)
    };
    E.prototype.runPostStepCallbacks = function () {
        for (var c = 0; c < this.postStepCallbacks.length; c++)this.postStepCallbacks[c]();
        this.postStepCallbacks = []
    };
    E.prototype.lock = function () {
        this.locked++
    };
    E.prototype.unlock = function (c) {
        this.locked--;
        d(0 <= this.locked, "Internal Error: Space lock underflow.");
        if (0 === this.locked && c) {
            c = this.rousedBodies;
            for (var e = 0; e < c.length; e++)this.activateBody(c[e]);
            c.length = 0;
            this.runPostStepCallbacks()
        }
    };
    E.prototype.makeCollideShapes = function () {
        var c =
            this;
        return function (d, e) {
            if (d.bb_l <= e.bb_r && e.bb_l <= d.bb_r && d.bb_b <= e.bb_t && e.bb_b <= d.bb_t && d.body !== e.body && (!d.group || d.group !== e.group) && d.layers & e.layers) {
                var f = c.lookupHandler(d.collision_type, e.collision_type), g = d.sensor || e.sensor;
                if (!g || f !== gb) {
                    if (d.collisionCode > e.collisionCode) {
                        var h = d;
                        d = e;
                        e = h
                    }
                    h = Ka(d, e);
                    if (0 !== h.length) {
                        var k = m(d.hashid, e.hashid), n = c.cachedArbiters[k];
                        n || (n = c.cachedArbiters[k] = new M(d, e));
                        n.update(h, f, d, e);
                        "first coll" != n.state || f.begin(n, c) || n.ignore();
                        "ignore" !== n.state &&
                        f.preSolve(n, c) && !g ? c.arbiters.push(n) : (n.contacts = null, "ignore" !== n.state && (n.state = "normal"));
                        n.stamp = c.stamp
                    }
                }
            }
        }
    };
    E.prototype.arbiterSetFilter = function (c) {
        var d = this.stamp - c.stamp, e = c.body_a, f = c.body_b;
        if ((e.isStatic() || e.isSleeping()) && (f.isStatic() || f.isSleeping()))return !0;
        1 <= d && "cached" != c.state && (c.callSeparate(this), c.state = "cached");
        return d >= this.collisionPersistence ? (c.contacts = null, !1) : !0
    };
    var tb = function (c) {
        var d = c.body;
        c.update(d.p, d.rot)
    };
    E.prototype.step = function (c) {
        if (0 !== c) {
            d(0 ===
                A.x && 0 === A.y, "vzero is invalid");
            this.stamp++;
            var e = this.curr_dt;
            this.curr_dt = c;
            var f, g, h = this.bodies, k = this.constraints, m = this.arbiters;
            for (f = 0; f < m.length; f++) {
                var n = m[f];
                n.state = "normal";
                n.body_a.isSleeping() || n.body_b.isSleeping() || n.unthread()
            }
            m.length = 0;
            this.lock();
            for (f = 0; f < h.length; f++)h[f].position_func(c);
            this.activeShapes.each(tb);
            this.activeShapes.reindexQuery(this.collideShapes);
            this.unlock(!1);
            this.processComponents(c);
            this.lock();
            for (g in this.cachedArbiters)this.arbiterSetFilter(this.cachedArbiters[g]) || delete this.cachedArbiters[g];
            g = this.collisionSlop;
            n = 1 - Math.pow(this.collisionBias, c);
            for (f = 0; f < m.length; f++)m[f].preStep(c, g, n);
            for (f = 0; f < k.length; f++)g = k[f], g.preSolve(this), g.preStep(c);
            g = Math.pow(this.damping, c);
            n = this.gravity;
            for (f = 0; f < h.length; f++)h[f].velocity_func(n, g, c);
            c = 0 === e ? 0 : c / e;
            for (f = 0; f < m.length; f++)m[f].applyCachedImpulse(c);
            for (f = 0; f < k.length; f++)k[f].applyCachedImpulse(c);
            for (f = 0; f < this.iterations; f++) {
                for (c = 0; c < m.length; c++)m[c].applyImpulse();
                for (c = 0; c < k.length; c++)k[c].applyImpulse()
            }
            for (f =
                     0; f < k.length; f++)k[f].postSolve(this);
            for (f = 0; f < m.length; f++)m[f].handler.postSolve(m[f], this);
            this.unlock(!0)
        }
    };
    var Ma = function (c, d, e, f) {
        return new u(d.vx + -f.y * d.w - (c.vx + -e.y * c.w), d.vy + f.x * d.w - (c.vy + e.x * c.w))
    }, Ia = function (c, d, e, f, g) {
        return (d.vx + -f.y * d.w - (c.vx + -e.y * c.w)) * g.x + (d.vy + f.x * d.w - (c.vy + e.x * c.w)) * g.y
    }, Da = function (c, d, e, f) {
        c.vx += d * c.m_inv;
        c.vy += e * c.m_inv;
        c.w += c.i_inv * (f.x * e - f.y * d)
    }, W = function (c, d, e, f, g, h) {
        Da(c, -g, -h, e);
        Da(d, g, h, f)
    }, bb = function (c, d, e, f) {
        c.v_biasx += d * c.m_inv;
        c.v_biasy += e * c.m_inv;
        c.w_bias += c.i_inv * (f.x * e - f.y * d)
    }, hb = function (c, d, e) {
        d = I(d, e);
        return c.m_inv + c.i_inv * d * d
    }, pa = function (c, d, f, g, h) {
        c = hb(c, f, h) + hb(d, g, h);
        e(0 !== c, "Unsolvable collision or constraint.");
        return c
    }, ib = function (c, d, f, g, h, k) {
        var m;
        m = c.m_inv + d.m_inv;
        var n = c.i_inv, p = f.x * f.x * n;
        c = -f.x * f.y * n;
        f = m + f.y * f.y * n;
        m += p;
        n = d.i_inv;
        d = g.x * g.x * n;
        p = -g.x * g.y * n;
        f += g.y * g.y * n;
        g = 0 + c + p;
        c = 0 + c + p;
        m += d;
        d = f * m - g * c;
        e(0 !== d, "Unsolvable constraint.");
        d = 1 / d;
        h.x = m * d;
        h.y = -g * d;
        k.x = -c * d;
        k.y = f * d
    }, H = c.Constraint = function (c, d) {
        this.a = c;
        this.b = d;
        this.next_b =
            this.next_a = this.space = null;
        this.maxForce = Infinity;
        this.errorBias = Math.pow(0.9, 60);
        this.maxBias = Infinity
    };
    H.prototype.activateBodies = function () {
        this.a && this.a.activate();
        this.b && this.b.activate()
    };
    H.prototype.preStep = function (c) {
    };
    H.prototype.applyCachedImpulse = function (c) {
    };
    H.prototype.applyImpulse = function () {
    };
    H.prototype.getImpulse = function () {
        return 0
    };
    H.prototype.preSolve = function (c) {
    };
    H.prototype.postSolve = function (c) {
    };
    H.prototype.next = function (c) {
        return this.a === c ? this.next_a : this.next_b
    };
    var qa = c.PinJoint = function (c, d, f, g) {
        H.call(this, c, d);
        this.anchr1 = f;
        this.anchr2 = g;
        c = c ? z(c.p, G(f, c.rot)) : f;
        d = d ? z(d.p, G(g, d.rot)) : g;
        this.dist = B(y(d, c));
        e(0 < this.dist, "You created a 0 length pin joint. A pivot joint will be much more stable.");
        this.n = this.r1 = this.r2 = null;
        this.bias = this.jnAcc = this.jnMax = this.nMass = 0
    };
    qa.prototype = Object.create(H.prototype);
    qa.prototype.preStep = function (c) {
        var d = this.a, e = this.b;
        this.r1 = G(this.anchr1, d.rot);
        this.r2 = G(this.anchr2, e.rot);
        var f = y(z(e.p, this.r2), z(d.p, this.r1)),
            g = B(f);
        this.n = D(f, 1 / (g ? g : Infinity));
        this.nMass = 1 / pa(d, e, this.r1, this.r2, this.n);
        d = this.maxBias;
        this.bias = t(-(1 - Math.pow(this.errorBias, c)) * (g - this.dist) / c, -d, d);
        this.jnMax = this.maxForce * c
    };
    qa.prototype.applyCachedImpulse = function (c) {
        c = D(this.n, this.jnAcc * c);
        W(this.a, this.b, this.r1, this.r2, c.x, c.y)
    };
    qa.prototype.applyImpulse = function () {
        var c = this.a, d = this.b, e = this.n, f = Ia(c, d, this.r1, this.r2, e), f = (this.bias - f) * this.nMass, g = this.jnAcc;
        this.jnAcc = t(g + f, -this.jnMax, this.jnMax);
        f = this.jnAcc - g;
        W(c, d, this.r1,
            this.r2, e.x * f, e.y * f)
    };
    qa.prototype.getImpulse = function () {
        return Math.abs(this.jnAcc)
    };
    var ra = c.SlideJoint = function (c, d, e, f, g, h) {
        H.call(this, c, d);
        this.anchr1 = e;
        this.anchr2 = f;
        this.min = g;
        this.max = h;
        this.r1 = this.r2 = this.n = null;
        this.bias = this.jnAcc = this.jnMax = this.nMass = 0
    };
    ra.prototype = Object.create(H.prototype);
    ra.prototype.preStep = function (c) {
        var d = this.a, e = this.b;
        this.r1 = G(this.anchr1, d.rot);
        this.r2 = G(this.anchr2, e.rot);
        var f = y(z(e.p, this.r2), z(d.p, this.r1)), g = B(f), h = 0;
        g > this.max ? (h = g - this.max, this.n =
            U(f)) : g < this.min ? (h = this.min - g, this.n = K(U(f))) : (this.n = A, this.jnAcc = 0);
        this.nMass = 1 / pa(d, e, this.r1, this.r2, this.n);
        d = this.maxBias;
        this.bias = t(-(1 - Math.pow(this.errorBias, c)) * h / c, -d, d);
        this.jnMax = this.maxForce * c
    };
    ra.prototype.applyCachedImpulse = function (c) {
        c *= this.jnAcc;
        W(this.a, this.b, this.r1, this.r2, this.n.x * c, this.n.y * c)
    };
    ra.prototype.applyImpulse = function () {
        if (0 !== this.n.x || 0 !== this.n.y) {
            var c = this.a, d = this.b, e = this.n, f = Ma(c, d, this.r1, this.r2), f = x(f, e), f = (this.bias - f) * this.nMass, g = this.jnAcc;
            this.jnAcc =
                t(g + f, -this.jnMax, 0);
            f = this.jnAcc - g;
            W(c, d, this.r1, this.r2, e.x * f, e.y * f)
        }
    };
    ra.prototype.getImpulse = function () {
        return Math.abs(this.jnAcc)
    };
    var sa = c.PivotJoint = function (c, d, e, f) {
        H.call(this, c, d);
        "undefined" === typeof f && (f = e, e = c ? c.world2Local(f) : f, f = d ? d.world2Local(f) : f);
        this.anchr1 = e;
        this.anchr2 = f;
        this.r1 = this.r2 = A;
        this.k1 = new u(0, 0);
        this.k2 = new u(0, 0);
        this.jAcc = A;
        this.jMaxLen = 0;
        this.bias = A
    };
    sa.prototype = Object.create(H.prototype);
    sa.prototype.preStep = function (c) {
        var d = this.a, e = this.b;
        this.r1 = G(this.anchr1,
            d.rot);
        this.r2 = G(this.anchr2, e.rot);
        ib(d, e, this.r1, this.r2, this.k1, this.k2);
        this.jMaxLen = this.maxForce * c;
        d = y(z(e.p, this.r2), z(d.p, this.r1));
        this.bias = R(D(d, -(1 - Math.pow(this.errorBias, c)) / c), this.maxBias)
    };
    sa.prototype.applyCachedImpulse = function (c) {
        W(this.a, this.b, this.r1, this.r2, this.jAcc.x * c, this.jAcc.y * c)
    };
    sa.prototype.applyImpulse = function () {
        var c = this.a, d = this.b, e = Ma(c, d, this.r1, this.r2), e = y(this.bias, e), f = this.k2, e = new u(x(e, this.k1), x(e, f)), f = this.jAcc;
        this.jAcc = R(z(this.jAcc, e), this.jMaxLen);
        W(c, d, this.r1, this.r2, this.jAcc.x - f.x, this.jAcc.y - f.y)
    };
    sa.prototype.getImpulse = function () {
        return B(this.jAcc)
    };
    var ha = c.GrooveJoint = function (c, d, e, f, g) {
        H.call(this, c, d);
        this.grv_a = e;
        this.grv_b = f;
        this.grv_n = N(O(y(f, e)));
        this.anchr2 = g;
        this.grv_tn = null;
        this.clamp = 0;
        this.r1 = this.r2 = null;
        this.k1 = new u(0, 0);
        this.k2 = new u(0, 0);
        this.jAcc = A;
        this.jMaxLen = 0;
        this.bias = null
    };
    ha.prototype = Object.create(H.prototype);
    ha.prototype.preStep = function (c) {
        var d = this.a, e = this.b, f = d.local2World(this.grv_a), g = d.local2World(this.grv_b),
            h = G(this.grv_n, d.rot), k = x(f, h);
        this.grv_tn = h;
        this.r2 = G(this.anchr2, e.rot);
        var m = I(z(e.p, this.r2), h);
        m <= I(f, h) ? (this.clamp = 1, this.r1 = y(f, d.p)) : m >= I(g, h) ? (this.clamp = -1, this.r1 = y(g, d.p)) : (this.clamp = 0, this.r1 = y(z(D(N(h), -m), D(h, k)), d.p));
        ib(d, e, this.r1, this.r2, this.k1, this.k2);
        this.jMaxLen = this.maxForce * c;
        d = y(z(e.p, this.r2), z(d.p, this.r1));
        this.bias = R(D(d, -(1 - Math.pow(this.errorBias, c)) / c), this.maxBias)
    };
    ha.prototype.applyCachedImpulse = function (c) {
        W(this.a, this.b, this.r1, this.r2, this.jAcc.x * c, this.jAcc.y *
            c)
    };
    ha.prototype.grooveConstrain = function (c) {
        var d = this.grv_tn;
        c = 0 < this.clamp * I(c, d) ? c : Y(c, d);
        return R(c, this.jMaxLen)
    };
    ha.prototype.applyImpulse = function () {
        var c = this.a, d = this.b, e = Ma(c, d, this.r1, this.r2), e = y(this.bias, e), f = this.k2, e = new u(x(e, this.k1), x(e, f)), f = this.jAcc;
        this.jAcc = this.grooveConstrain(z(f, e));
        W(c, d, this.r1, this.r2, this.jAcc.x - f.x, this.jAcc.y - f.y)
    };
    ha.prototype.getImpulse = function () {
        return B(this.jAcc)
    };
    ha.prototype.setGrooveA = function (c) {
        this.grv_a = c;
        this.grv_n = N(O(y(this.grv_b,
            c)));
        this.activateBodies()
    };
    ha.prototype.setGrooveB = function (c) {
        this.grv_b = c;
        this.grv_n = N(O(y(c, this.grv_a)));
        this.activateBodies()
    };
    var ub = function (c, d) {
        return (c.restLength - d) * c.stiffness
    }, ta = c.DampedSpring = function (c, d, e, f, g, h, k) {
        H.call(this, c, d);
        this.anchr1 = e;
        this.anchr2 = f;
        this.restLength = g;
        this.stiffness = h;
        this.damping = k;
        this.springForceFunc = ub;
        this.target_vrn = this.v_coef = 0;
        this.r1 = this.r2 = null;
        this.nMass = 0;
        this.n = null
    };
    ta.prototype = Object.create(H.prototype);
    ta.prototype.preStep = function (c) {
        var d =
            this.a, f = this.b;
        this.r1 = G(this.anchr1, d.rot);
        this.r2 = G(this.anchr2, f.rot);
        var g = y(z(f.p, this.r2), z(d.p, this.r1)), h = B(g);
        this.n = D(g, 1 / (h ? h : Infinity));
        g = pa(d, f, this.r1, this.r2, this.n);
        e(0 !== g, "Unsolvable this.");
        this.nMass = 1 / g;
        this.target_vrn = 0;
        this.v_coef = 1 - Math.exp(-this.damping * c * g);
        h = this.springForceFunc(this, h);
        W(d, f, this.r1, this.r2, this.n.x * h * c, this.n.y * h * c)
    };
    ta.prototype.applyCachedImpulse = function (c) {
    };
    ta.prototype.applyImpulse = function () {
        var c = this.a, d = this.b, e = Ia(c, d, this.r1, this.r2, this.n),
            f = (this.target_vrn - e) * this.v_coef;
        this.target_vrn = e + f;
        f *= this.nMass;
        W(c, d, this.r1, this.r2, this.n.x * f, this.n.y * f)
    };
    ta.prototype.getImpulse = function () {
        return 0
    };
    var vb = function (c, d) {
        return (d - c.restAngle) * c.stiffness
    }, Na = c.DampedRotarySpring = function (c, d, e, f, g) {
        H.call(this, c, d);
        this.restAngle = e;
        this.stiffness = f;
        this.damping = g;
        this.springTorqueFunc = vb;
        this.iSum = this.w_coef = this.target_wrn = 0
    };
    Na.prototype = Object.create(H.prototype);
    Na.prototype.preStep = function (c) {
        var d = this.a, f = this.b, g = d.i_inv + f.i_inv;
        e(0 !== g, "Unsolvable spring.");
        this.iSum = 1 / g;
        this.w_coef = 1 - Math.exp(-this.damping * c * g);
        this.target_wrn = 0;
        c *= this.springTorqueFunc(this, d.a - f.a);
        d.w -= c * d.i_inv;
        f.w += c * f.i_inv
    };
    Na.prototype.applyImpulse = function () {
        var c = this.a, d = this.b, e = c.w - d.w, f = (this.target_wrn - e) * this.w_coef;
        this.target_wrn = e + f;
        e = f * this.iSum;
        c.w += e * c.i_inv;
        d.w -= e * d.i_inv
    };
    var ua = c.RotaryLimitJoint = function (c, d, e, f) {
        H.call(this, c, d);
        this.min = e;
        this.max = f;
        this.iSum = this.bias = this.jMax = this.jAcc = 0
    };
    ua.prototype = Object.create(H.prototype);
    ua.prototype.preStep = function (c) {
        var d = this.a, e = this.b, f = e.a - d.a, g = 0;
        f > this.max ? g = this.max - f : f < this.min && (g = this.min - f);
        this.iSum = 1 / (1 / d.i + 1 / e.i);
        d = this.maxBias;
        this.bias = t(-(1 - Math.pow(this.errorBias, c)) * g / c, -d, d);
        this.jMax = this.maxForce * c;
        this.bias || (this.jAcc = 0)
    };
    ua.prototype.applyCachedImpulse = function (c) {
        var d = this.a, e = this.b;
        c *= this.jAcc;
        d.w -= c * d.i_inv;
        e.w += c * e.i_inv
    };
    ua.prototype.applyImpulse = function () {
        if (this.bias) {
            var c = this.a, d = this.b, e = -(this.bias + (d.w - c.w)) * this.iSum, f = this.jAcc;
            this.jAcc =
                0 > this.bias ? t(f + e, 0, this.jMax) : t(f + e, -this.jMax, 0);
            e = this.jAcc - f;
            c.w -= e * c.i_inv;
            d.w += e * d.i_inv
        }
    };
    ua.prototype.getImpulse = function () {
        return Math.abs(joint.jAcc)
    };
    var va = c.RatchetJoint = function (c, d, e, f) {
        H.call(this, c, d);
        this.angle = 0;
        this.phase = e;
        this.ratchet = f;
        this.angle = (d ? d.a : 0) - (c ? c.a : 0);
        this.iSum = this.bias = this.jAcc = this.jMax = 0
    };
    va.prototype = Object.create(H.prototype);
    va.prototype.preStep = function (c) {
        var d = this.a, e = this.b, f = this.phase, g = this.ratchet, h = e.a - d.a, k = this.angle - h, m = 0;
        0 < k * g ? m = k : this.angle =
            Math.floor((h - f) / g) * g + f;
        this.iSum = 1 / (d.i_inv + e.i_inv);
        d = this.maxBias;
        this.bias = t(-(1 - Math.pow(this.errorBias, c)) * m / c, -d, d);
        this.jMax = this.maxForce * c;
        this.bias || (this.jAcc = 0)
    };
    va.prototype.applyCachedImpulse = function (c) {
        var d = this.a, e = this.b;
        c *= this.jAcc;
        d.w -= c * d.i_inv;
        e.w += c * e.i_inv
    };
    va.prototype.applyImpulse = function () {
        if (this.bias) {
            var c = this.a, d = this.b, e = this.ratchet, f = -(this.bias + (d.w - c.w)) * this.iSum, g = this.jAcc;
            this.jAcc = t((g + f) * e, 0, this.jMax * Math.abs(e)) / e;
            f = this.jAcc - g;
            c.w -= f * c.i_inv;
            d.w +=
                f * d.i_inv
        }
    };
    va.prototype.getImpulse = function (c) {
        return Math.abs(c.jAcc)
    };
    var la = c.GearJoint = function (c, d, e, f) {
        H.call(this, c, d);
        this.phase = e;
        this.ratio = f;
        this.ratio_inv = 1 / f;
        this.iSum = this.bias = this.jMax = this.jAcc = 0
    };
    la.prototype = Object.create(H.prototype);
    la.prototype.preStep = function (c) {
        var d = this.a, e = this.b;
        this.iSum = 1 / (d.i_inv * this.ratio_inv + this.ratio * e.i_inv);
        var f = this.maxBias;
        this.bias = t(-(1 - Math.pow(this.errorBias, c)) * (e.a * this.ratio - d.a - this.phase) / c, -f, f);
        this.jMax = this.maxForce * c
    };
    la.prototype.applyCachedImpulse =
        function (c) {
            var d = this.a, e = this.b;
            c *= this.jAcc;
            d.w -= c * d.i_inv * this.ratio_inv;
            e.w += c * e.i_inv
        };
    la.prototype.applyImpulse = function () {
        var c = this.a, d = this.b, e = (this.bias - (d.w * this.ratio - c.w)) * this.iSum, f = this.jAcc;
        this.jAcc = t(f + e, -this.jMax, this.jMax);
        e = this.jAcc - f;
        c.w -= e * c.i_inv * this.ratio_inv;
        d.w += e * d.i_inv
    };
    la.prototype.getImpulse = function () {
        return Math.abs(this.jAcc)
    };
    la.prototype.setRatio = function (c) {
        this.ratio = c;
        this.ratio_inv = 1 / c;
        this.activateBodies()
    };
    var wa = c.SimpleMotor = function (c, d, e) {
        H.call(this,
            c, d);
        this.rate = e;
        this.iSum = this.jMax = this.jAcc = 0
    };
    wa.prototype = Object.create(H.prototype);
    wa.prototype.preStep = function (c) {
        this.iSum = 1 / (this.a.i_inv + this.b.i_inv);
        this.jMax = this.maxForce * c
    };
    wa.prototype.applyCachedImpulse = function (c) {
        var d = this.a, e = this.b;
        c *= this.jAcc;
        d.w -= c * d.i_inv;
        e.w += c * e.i_inv
    };
    wa.prototype.applyImpulse = function () {
        var c = this.a, d = this.b, e = -(d.w - c.w + this.rate) * this.iSum, f = this.jAcc;
        this.jAcc = t(f + e, -this.jMax, this.jMax);
        e = this.jAcc - f;
        c.w -= e * c.i_inv;
        d.w += e * d.i_inv
    };
    wa.prototype.getImpulse =
        function () {
            return Math.abs(this.jAcc)
        }
})();
var res = {
    number_png: "res/game/number.png",
    bg_png: "res/game/bg.png",
    apple1_png: "res/game/apple2.png",
    apple2_png: "res/game/apple5.png",
    apple3_png: "res/game/apple6.png",
    apple4_png: "res/game/apple7.png",
    apple5_png: "res/game/apple8.png",
    panZi1_png: "res/game/panzi1.png",
    panZi2_png: "res/game/panzi2.png",
    s1_png: "res/game/s.png",
    sy1_png: "res/game/sy1.png",
    sy2_png: "res/game/sy2.png",
    sy3_png: "res/game/sy3.png",
    sy4_png: "res/game/sy4.png",
    st1_png: "res/game/st1.png",
    st2_png: "res/game/st2.png",
    st3_png: "res/game/st3.png",
    st4_png: "res/game/st4.png",
    grass_png: "res/game/grass.png"
}, music = {
    openLayer: "res/music/openLayer",
    gameover: "res/music/gameover",
    moveSound: "res/music/moveSound",
    clickSound: "res/music/clickSound",
    posui: "res/music/posui",
    p: "res/music/p",
    zhalie: "res/music/zhalie"
}, comRes = {
    share_png: "res/game/share.png",
    ad_png: "res/commonUI/btn_ad.png",
    game_over1_png: "res/commonUI/ChineseRes/game_over.png",
    game_over2_png: "res/commonUI/EnglishRes/game_over.png",
    btn_again_png: "res/commonUI/ChineseRes/btn_again.png",
    btn_more_png: "res/commonUI/ChineseRes/btn_more.png",
    btn_gz_png: "res/commonUI/ChineseRes/btn_gz.png",
    btn_link_png: "res/commonUI/btn_link.png",
    btn_jiantou_png: "res/commonUI/btn_jiantou.png",
    button1_png: "res/commonUI/button1.png",
    button2_png: "res/commonUI/button2.png",
    game_over_png: "res/commonUI/EnglishRes/game_over.png",
    icon_facebook_png: "res/commonUI/EnglishRes/icon_facebook.png",
    icon_replay_png: "res/commonUI/EnglishRes/icon_replay.png",
    icon_twitter_png: "res/commonUI/EnglishRes/icon_twitter.png",
    icon_moregame_png: "res/commonUI/EnglishRes/icon_moregame.png",
    score_bg_png: "res/commonUI/EnglishRes/score_bg.png"
}, g_resources = [], a;
for (a in comRes)g_resources.push(comRes[a]);
for (var b in res)g_resources.push(res[b]);
var PopLayer = cc.Layer.extend({
    m_touchListener: null, selfPopLayer: null, popName: null, ctor: function () {
        this._super();
        selfPopLayer = this;
        var c = {event: cc.EventListener.TOUCH_ONE_BY_ONE, swallowTouches: !0, onTouchBegan: this.onTouch};
        cc.eventManager.addListener(c, this);
        this.m_touchListener = c
    }, setData: function () {
    }, onTouch: function (c, d) {
        var e = d.getCurrentTarget();
        return e.isVisible() && selfPopLayer.isTouchInside(e, c) ? !0 : !1
    }, isTouchInside: function (c, d) {
        if (!c || !c.getParent())return !1;
        var e = d.getLocation(), e = c.getParent().convertToNodeSpace(e);
        return cc.rectContainsPoint(c.getBoundingBox(), e)
    }, setLayerVisible: function (c) {
        this.setVisible(c)
    }, hide: function () {
        this.popName = this.selfPopLayer = this.m_touchListener = null;
        this.getParent() && (this.removeAllChildrenWithCleanup(!0), this.removeFromParent(!0))
    }
});
var UIManager = {
    downLayer: null,
    centreLayer: null,
    upLayer: null,
    effectLayer: null,
    loadingLayer: null,
    messageLayer: null,
    uiDic: null,
    init: function () {
        this.uiDic = {};
        this.downLayer = new cc.Layer;
        this.downLayer.retain();
        this.centreLayer = new cc.Layer;
        this.centreLayer.retain();
        this.upLayer = new cc.Layer;
        this.upLayer.retain();
        this.messageLayer = new cc.Layer;
        this.messageLayer.retain()
    },
    register: function (c) {
        this.downLayer.getParent() && this.downLayer.removeFromParent();
        this.centreLayer.getParent() && this.centreLayer.removeFromParent();
        this.upLayer.getParent() && this.upLayer.removeFromParent();
        this.messageLayer.getParent() && this.messageLayer.removeFromParent();
        c.addChild(this.downLayer);
        c.addChild(this.centreLayer);
        c.addChild(this.upLayer);
        c.addChild(this.messageLayer)
    },
    show: function (c, d, e, f) {
        if (!f && this.isPop(c))return cc.log("\u5df2\u7ecf\u6709\u6253\u5f00\u7684\u9875\u9762\u4e86...:" + c), !1;
        e = e || this.downLayer;
        var g = new (eval("(" + c + ")"));
        e.addChild(g);
        g.setData(d);
        cc.log("show : " + c);
        f || (this.uiDic[c] = g);
        return !0
    },
    hide: function (c) {
        var d =
            this.uiDic[c];
        d && (cc.log("hide : " + c), d.hide(), delete this.uiDic[c])
    },
    getView: function (c) {
        return this.uiDic[c]
    },
    isPop: function (c) {
        return (c = this.uiDic[c]) && c.getParent() ? !0 : !1
    }
}, UIName = UIName || {};
UIName.EndLayer = "EndLayer";
UIName.MainLayer = "MainLayer";
UIName.StartLayer = "StartLayer";
UIName.EndLayerEnglish = "EndLayerEnglish";
UIName.LinkLayer = "LinkLayer";
UIName.AdLayer = "AdLayer";
var UIToolManager = {
    getSprite: function (c, d, e, f, g) {
        c = new cc.Sprite(c);
        null != d && null != e && c.setAnchorPoint(d, e);
        null != f && null != g && c.setPosition(f, g);
        return c
    }, getLabelTTF: function (c, d, e, f, g, h, k) {
        c = new cc.LabelTTF("" + c, "Arial \u7c97\u4f53", d);
        c.setAnchorPoint(e, f);
        c.setPosition(g, h);
        null != k && c.setFontFillColor(k);
        return c
    }, getTest: function () {
    }
};
var HttpManager = cc.Class.extend({
    URL: "http://www.wesane.com/h5service.php/Interface/services",
    cacheList: null,
    isBusy: null,
    req: null,
    perform: null,
    ctor: function () {
        this.cacheList = []
    },
    checkHave: function () {
        this.isBusy || this.sendOne()
    },
    send: function (c, d, e, f) {
        this.cacheList.push({type: c, data: d, func: e, target: f});
        this.isBusy || this.sendOne()
    },
    sendOne: function () {
        if (0 != this.cacheList.length) {
            this.isBusy = !0;
            this.perform = this.cacheList.shift();
            this.req = cc.loader.getXMLHttpRequest();
            this.req.onreadystatechange = this.onDataHandler.bind(this);
            this.req.onerror = this.onErrorHandler.bind(this);
            this.req.ontimeout = this.onTimeoutHandler.bind(this);
            this.req.timeout = 2E3;
            this.req.open("POST", this.URL);
            this.req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset\x3dUTF-8");
            var c = "send\x3d" + JSON.stringify({
                    type: this.perform.type,
                    gid: null,
                    mid: null,
                    data: this.perform.data
                });
            this.req.send(c)
        }
    },
    onDataHandler: function () {
        if (4 == this.req.readyState && 200 <= this.req.status && 207 >= this.req.status) {
            var c = JSON.parse(this.req.responseText);
            this.isBusy = !1;
            this.perform.target ? this.perform.func.call(this.perform.target, c.errorcode, c.data) : this.perform.func(c)
        }
    },
    onErrorHandler: function () {
        cc.log("\u7f51\u7edc\u9519\u8bef");
        this.isBusy = !1;
        this.perform.target ? this.perform.func.call(this.perform.target, -1) : this.perform.func(-1)
    },
    onTimeoutHandler: function () {
        cc.log("\u8bf7\u6c42\u8d85\u65f6");
        this.isBusy = !1;
        this.perform.target ? this.perform.func.call(this.perform.target, -1) : this.perform.func(-1)
    },
    clearAll: function () {
        for (var c = this.cacheList.length,
                 d = 0; d < c; d++) {
            var e = this.cacheList[d];
            e && (e.target ? e.func.call(e.target, -1) : e.func(-1))
        }
        this.cacheList.length = 0
    }
});
HttpManager.instance = null;
HttpManager.register = function () {
    HttpManager.instance = new HttpManager
};
var UserDataManager = {
    isWX: !0, isLogin: !1, mid: null, isContinue: !1, getGold: null, continueData: {}, init: function () {
        this.noLoginAccount()
    }, getAccountReturn: function (c, d) {
        0 == c && (this.getGold = {}, this.getGold.type = d.type, this.getGold.reward_money = d.reward_money, this.getGold.reward_info = d.reward_info, d.isContinue && 1 == d.isContinue && (this.isContinue = d.isContinue, this.continueData = {}, this.continueData.cost = d.cost, this.continueData.score = d.score, this.continueData.save = d.save), this.loginAccount(d.mid))
    }, noLoginAccount: function () {
        this.isLogin = !1
    }, loginAccount: function (c) {
        this.mid = c;
        this.isLogin = !0;
        cc.log("\u5f53\u524d\u767b\u5f55\u7528\u6237\uff1a" + this.mid);
        MainManager.startGame()
    }, exitLogin: function () {
        this.mid = null;
        this.isLogin = !1
    }
};
var LocalManager = {
    scoreKey: null, timeKey: null, init: function () {
        this.scoreKey = "game_" + GameManager.gid;
        this.timeKey = "time_" + GameManager.gid
    }, setMaxData: function () {
        var c = this.getItem(this.scoreKey), d = GameManager.score;
        c || this.setItem(this.scoreKey, d);
        d > c && this.setItem(this.scoreKey, d);
        GameManager.maxScore = this.getItem(this.scoreKey);
        score_submit(d, 1)
    }, getMaxScore: function () {
        var c = this.getItem(this.scoreKey);
        return c ? c : 0
    }, setLastShowAd: function () {
        var c = (new Date).getTime() / 1E3;
        this.setItem(this.timeKey,
            c)
    }, getLastShowAd: function () {
        var c = this.getItem(this.timeKey);
        return 0 < c ? c : null
    }, getNowTime: function () {
        return (new Date).getTime() / 1E3
    }, getItem: function (c) {
        return cc.sys.localStorage.getItem(c)
    }, setItem: function (c, d) {
        cc.sys.localStorage.setItem(c, d)
    }, clearData: function () {
        cc.sys.localStorage.clear()
    }, resetData: function () {
        this.clearData()
    }
};
var GameManager = {
    gameName: null,
    playNum: 0,
    touchNum: 0,
    levelNum: 1,
    score: 0,
    totalNum: 0,
    clickRightNum: 0,
    clickErrorNum: 0,
    init: function () {
        this.gameName = LanguageManager.getText("game_name");
        this.averageScore = 10;
        this.touchNum = this.playNum = 0;
        this.levelNum = 1
    },
    setData: function () {
        this.resetData()
    },
    resetData: function () {
        this.playNum++;
        this.score = this.touchNum = 0;
        this.levelNum = 1;
        this.clickErrorNum = this.clickRightNum = 0;
        this.totalNum = 30
    },
    addScore: function (c) {
        this.score += c
    },
    addRightScore: function (c) {
        this.clickRightNum +=
            c
    },
    reduceTotalScore: function (c) {
        this.totalNum -= c
    },
    testFunc: function () {
    }
}, upload = !0, GC = GC || {};
GC.appleArr = [];
GC.appleDropBool = !1;
GC.appleStopBool = !1;
GC.canTouchBool = !1;
GC.chaEyeBool = !1;
GC.canEffectBool = !1;
var MainManager = {
    linkData: null, lastAdTime: 0, init: function () {
        this.lastAdTime = 0;
        this.URL_moreGame = "//h5.woaiyx.com";
        this.id_facebookShare = 0x6428f55337363;//@todo 换FB分享ID
        this.getLinkGame()
    }, gotoMoreGame: function () {
        window.location.href = this.URL_moreGame
    }, gotoEndLayer: function () {
        score_submit(GameManager.score, 1);
        FaceBookFlag || TwitterFlag || !LanguageManager.chineseFlag ? UIManager.show(UIName.EndLayerEnglish) : UIManager.show(UIName.EndLayer);
        upload && (0 == this.lastAdTime || 30 < this.getInterval()) && UIManager.show(UIName.AdLayer)
    },
    setLastShowAd: function () {
        this.lastAdTime = (new Date).getTime() / 1E3
    }, getInterval: function () {
        var c = (new Date).getTime() / 1E3 - this.lastAdTime;
        cc.log("nt-\x3e" + c);
        return c
    }, gamePause: function () {
        this.isPause = !0;
        this.canTouch = !1;
        mainSelf && mainSelf.unscheduleUpdate();
        AudioManager.pauseMusic()
    }, gameResume: function () {
        this.isPause = !1;
        this.canTouch = !0;
        mainSelf && mainSelf.scheduleUpdate();
        AudioManager.resumeMusic()
    }, randomInt: function (c, d) {
        return c + Math.floor(Math.random() * (d - c + 1))
    }, getDist: function (c, d, e, f) {
        return cc.pDistance(cc.p(c,
            d), cc.p(e, f))
    }, gotoCover: function () {
        MainManager.loadGame();
        cc.director.runScene(new LoadScene)
    }, loadGame: function () {
        cc.log("loadGame");
        HttpManager.register();
        LanguageManager.init();
        GameManager.init();
        MainManager.init()
    }, startGame: function () {
        cc.log("startGame");
        cc.director.runScene(new GameScene)
    }, getLinkGame: function () {
       HttpManager.instance.send("101", null, this.getLinkGameReturn, this)
    }, getLinkGameReturn: function (c, d) {
        0 == c ? this.linkData = d : cc.log("\u83b7\u53d6\u5931\u8d25")
    }, testFunc: function () {
    }
}, setO =
    200, AdLayer = cc.Layer.extend({
    lis1: null, state: 1, ctor: function () {
        this._super()
    }, setData: function () {
        var c = cc.director.getWinSize().height / 1280, d = 0, e = 0;
        0.76 <= c ? (d = 1, e = 0) : 0.73 < c ? (d = 0.9, e = 0.1) : 0.7 <= c ? (d = c, e = 1 - c) : 0.6 <= c ? e = d = 0.5 : 0.5 <= c ? (d = 0.4, e = 0.6) : 0.4 <= c ? (d = 0.2, e = 0.8) : 0.1 <= c ? (d = 0.1, e = 0.9) : 0 <= c && (d = 0.05, e = 0.95);
        this.scaleNum = d + CH / 1280 * e;
        this.setState(1);
        this.init();
        this.createListener()
    }, init: function () {
        this.bg = new cc.DrawNode;
        this.bg.drawRect(cc.p(0, 0), cc.p(CW, CH), cc.color(0, 0, 0, 120), -1);
        this.addChild(this.bg);
        this.node = new cc.Node;
        this.addChild(this.node);
        this.bgColor = new cc.DrawNode;
        this.bgColor.drawRect(cc.p(0, CH / 2 - 300 * this.scaleNum), cc.p(CW, CH / 2 + 300 * this.scaleNum), cc.color(0, 0, 0, 170), -1);
        this.node.addChild(this.bgColor);
        var c = UIToolManager.getSprite(comRes.share_png, 0.5, 0.5, CW / 2 - 150 * this.scaleNum, CH / 2 + 50 * this.scaleNum);
        this.node.addChild(c);
        c.setScale(this.scaleNum);
        c = UIToolManager.getSprite(comRes.ad_png, 0.5, 0.5, CW / 2 + 200 * this.scaleNum, CH / 2 + 50 * this.scaleNum);
        this.node.addChild(c);
        c.setScale(this.scaleNum);
        c = UIToolManager.getLabelTTF("Continue", 40 * this.scaleNum, 0.5, 0.5, c.x, c.y - 110 * this.scaleNum);
        this.node.addChild(c);
        this.layerIn()
    }, layerIn: function () {
        this.node.x = -CW;
        this.node.runAction(cc.sequence(cc.moveTo(0.3, 0, 0), cc.callFunc(this.setState.bind(this, 2))))
    }, layerOut: function () {
        this.node.runAction(cc.sequence(cc.moveTo(0.3, -CW, 0), cc.callFunc(this.destroy.bind(this))))
    }, createListener: function () {
        this.lis1 = cc.EventListener.create({
            event: cc.EventListener.TOUCH_ONE_BY_ONE, swallowTouches: !0, onTouchBegan: this.onTouchBegan.bind(this),
            onTouchMoved: this.onTouchMoved.bind(this), onTouchEnded: this.onTouchEnded.bind(this)
        });
        cc.eventManager.addListener(this.lis1, this)
    }, removeListener: function () {
        cc.eventManager.removeListener(this.lis1);
        this.lis1 = null
    }, onTouchBegan: function (c, d) {
        return !0
    }, onTouchMoved: function (c, d) {
    }, onTouchEnded: function (c, d) {
        2 == this.state && (this.state = 3, showMyAds(), MainManager.setLastShowAd(), this.runAction(cc.sequence(cc.callFunc(this.layerOut.bind(this)))))
    }, setState: function (c) {
        this.state = c;
        cc.log(this.state)
    }, destroy: function () {
        this.stopAllActions();
        this.removeListener();
        this.removeAllChildren(!0);
        this.removeFromParent(!0)
    }
});
var AudioManager = {
    init: function () {
    }, playBGMusic: function (c) {
        cc.audioEngine.isMusicPlaying() && this.stopAllMusic();
        cc.audioEngine.playMusic(c, !0)
    }, playEffect: function (c) {
        c = cc.sys.os === cc.sys.OS_IOS ? c + ".mp3" : c + ".ogg";
        cc.audioEngine.playEffect(c, !1)
    }, pauseMusic: function () {
        cc.audioEngine.pauseMusic()
    }, resumeMusic: function () {
        cc.audioEngine.resumeMusic()
    }, stopAllMusic: function () {
        cc.audioEngine.stopMusic();
        cc.audioEngine.stopAllEffects()
    }
};
var LanguageManager = {
    chineseFlag: !1, txtShow: null, init: function () {
        this.txtShow = {};
        cc.sys.language == cc.sys.LANGUAGE_CHINESE ? (this.txtShow.data = language_Chinese, this.chineseFlag = !0) : this.txtShow.data = language_English;
        document.title = LanguageManager.getText("game_name")
    }, getText: function (c) {
        return this.txtShow.data[c]
    }
}, language_Chinese = {
    game_name: "30\u4e2a\u82f9\u679c",
    game_info: "\u6811\u4e0a\u670930\u4e2a\u82f9\u679c\uff0c\u770b\u770b\u4f60\u80fd\u63a5\u4f4f\u591a\u5c11\u4e2a\uff1f",
    start: "\u5f00\u59cb\u6e38\u620f",
    link_top_tip: "\u522b\u4eba\u90fd\u5728\u73a9 : ",
    game_center: "\u6e38\u620f\u4e2d\u5fc3"
}, language_English = {
    game_name: "Thirty Apples",
    game_info: "There are 30 apples on the tree and see how many can you catch?",
    start: "Start",
    link_top_tip: "Others are playing : ",
    game_center: "Game center"
}, language_Japanese = {
    game_name: "",
    game_info: "",
    start: "\u30b2\u30fc\u30e0\u3092\u59cb\u3081\u308b",
    link_top_tip: "\u307f\u3093\u306a\u3067\u6e38\u3093\u3067 : ",
    game_center: "\u30b2\u30fc\u30e0\u306e\u4e2d\u5fc3"
}, language_Korean =
{
    game_name: "",
    game_info: "",
    start: "\ubd80\ud130 \uac8c\uc784",
    link_top_tip: "\ub0a8 \ub4e4 \uc740 \ub180 : ",
    game_center: "\uac8c\uc784 \uc13c\ud130"
};
var MainLayer = cc.Layer.extend({
    lis1: null,
    bg: null,
    scoreView: null,
    _speed: 5,
    _speedSign: 1,
    _colorArr: [],
    _countTime: 0,
    _norCountTime: 7,
    _countTime1: 0,
    _countEyeTime: 0,
    _countEyeTotalTime: 0,
    _countNorEyeTime: 70,
    _countNorTime: 60,
    _indexN: 0,
    _indexN1: 0,
    _indexN2: 1,
    _touchRightNum: 0,
    _touchErrorNum: 0,
    ctor: function () {
        this._super();
        mainSelf = this
    },
    setData: function (c) {
        c = cc.director.getWinSize().height / 1280;
        var d = 0, e = 0;
        0.76 <= c ? (d = 1, e = 0) : 0.73 < c ? (d = 0.9, e = 0.1) : 0.7 <= c ? (d = c, e = 1 - c) : 0.6 <= c ? e = d = 0.5 : 0.5 <= c ? (d = 0.4, e = 0.6) : 0.4 <= c ? (d =
            0.2, e = 0.8) : 0.1 <= c ? (d = 0.1, e = 0.9) : 0 <= c && (d = 0.05, e = 0.95);
        this.scaleNum = d + CH / 1280 * e;
        this._speed = 5 * this.scaleNum;
        this.initUI();
        this.initPhysics();
        this.initDropApple();
        this.initPanZi();
        this.initCollisionFunc();
        this.addLinkGame()
    },
    initUI: function () {
        this._colorArr = [1, 2, 3, 4];
        this.bg = new cc.LayerColor(cc.color("#17d9ff"), CW, CH);
        this.addChild(this.bg, 0);
        this.treeSpr = new cc.Sprite(res.bg_png);
        this.treeSpr.x = CW / 2;
        this.treeSpr.y = 0;
        this.treeSpr.setAnchorPoint(cc.p(0.5, 0));
        this.addChild(this.treeSpr);
        this.treeSpr.setScale(this.scaleNum);
        this.grassSpr = new cc.Sprite(res.grass_png);
        this.grassSpr.setAnchorPoint(cc.p(0.5, 0));
        this.grassSpr.x = CW / 2;
        this.grassSpr.y = 0;
        this.addChild(this.grassSpr);
        this.scoreView = new ScoreView1(0, 1, 63, CH - 16, this.scaleNum);
        this.aniSpr1 = UIToolManager.getSprite(res.s1_png, 0.5, 0, CW / 2, 86 * this.scaleNum);
        this.addChild(this.aniSpr1, 1);
        this.aniSpr1.setScale(this.scaleNum);
        this.aniSpr2 = UIToolManager.getSprite(res.sy4_png, 0.5, 0, CW / 2, 86 * this.scaleNum);
        this.addChild(this.aniSpr2, 1);
        this.aniSpr2.setScale(this.scaleNum);
        this.aniSpr3 =
            UIToolManager.getSprite(res.st1_png, 0.5, 0, CW / 2, 86 * this.scaleNum);
        this.addChild(this.aniSpr3, 1);
        this.aniSpr3.setScale(this.scaleNum);
        this.panZiSpr1 = UIToolManager.getSprite(res.panZi1_png, 0.5, 0.5, CW / 2 - 15, 146 * this.scaleNum);
        this.addChild(this.panZiSpr1, 4);
        this.panZiSpr1.setScale(this.scaleNum);
        this.panZiSpr2 = UIToolManager.getSprite(res.panZi2_png, 0.5, 0.5, CW / 2 - 15, 146 * this.scaleNum);
        this.addChild(this.panZiSpr2, 2);
        this.panZiSpr2.setScale(this.scaleNum);
        this.scoreTotalView = new ScoreView2(0, 1, 20, CH - 16, this.scaleNum);
        this.addChild(this.scoreTotalView, 1)
    },
    initPhysics: function () {
        this.space = new cp.Space;
        this.space.gravity = cp.v(0, 0);
        this.walls = [new cp.SegmentShape(this.space.staticBody, cp.v(0, CH), cp.v(CW, CH), 2)];
        for (var c = 0; c < this.walls.length; c++) {
            var d = this.walls[c];
            d.setElasticity(0);
            d.setFriction(1);
            this.space.addStaticShape(d)
        }
    },
    setupDebugNode: function () {
        this._debugNode = new cc.PhysicsDebugNode(this.space);
        this._debugNode.visible = !0;
        this.addChild(this._debugNode)
    },
    initPanZi: function () {
        this.wall1 = {};
        this.wall1.body =
            new cp.StaticBody(1, cp.momentForCircle(1, 0, 15 * this.scaleNum, cp.v(0, 0)));
        this.wall1.body.setPos(cc.p(this.panZiSpr1.x - 78 * this.scaleNum, this.panZiSpr1.y + 9 * this.scaleNum));
        this.wall1.shape = new cp.CircleShape(this.wall1.body, 15 * this.scaleNum, cp.v(0, 0));
        this.wall1.shape.setElasticity(0.1);
        this.wall1.shape.setFriction(0.2);
        this.space.addStaticShape(this.wall1.shape, 10);
        this.wall1.shape.setCollisionType(1);
        this.wall1.sprite = new cc.PhysicsSprite;
        this.wall1.sprite.setBody(this.wall1.body);
        this.wall1.sprite.setPosition(cc.p(this.panZiSpr1.x -
            78 * this.scaleNum, this.panZiSpr1.y + 9 * this.scaleNum));
        this.addChild(this.wall1.sprite, 10);
        this.wall1.body.setAngleInternal(0);
        this.space.reindexStatic();
        this.space.reindexShape(this.wall1.shape);
        this.wall2 = {};
        this.wall2.body = new cp.StaticBody(1, cp.momentForCircle(1, 0, 15 * this.scaleNum, cp.v(0, 0)));
        this.wall2.body.setPos(cc.p(this.panZiSpr1.x + 78 * this.scaleNum, this.panZiSpr1.y + 9 * this.scaleNum));
        this.wall2.shape = new cp.CircleShape(this.wall2.body, 15 * this.scaleNum, cp.v(0, 0));
        this.wall2.shape.setElasticity(0.1);
        this.wall2.shape.setFriction(0.2);
        this.space.addStaticShape(this.wall2.shape, 10);
        this.wall2.shape.setCollisionType(1);
        this.wall2.sprite = new cc.PhysicsSprite;
        this.wall2.sprite.setBody(this.wall2.body);
        this.wall2.sprite.setPosition(cc.p(this.panZiSpr1.x + 78 * this.scaleNum, this.panZiSpr1.y + 9 * this.scaleNum));
        this.addChild(this.wall2.sprite, 10);
        this.wall2.body.setAngleInternal(0);
        this.space.reindexStatic();
        this.space.reindexShape(this.wall2.shape);
        this.wall3 = {};
        this.wall3.body = new cp.StaticBody(1, cp.momentForBox(1,
            135 * this.scaleNum, 5 * this.scaleNum));
        this.wall3.body.setPos(cc.p(this.panZiSpr1.x, this.panZiSpr1.y - 7 * this.scaleNum));
        this.wall3.shape = new cp.BoxShape(this.wall3.body, 135 * this.scaleNum, 5 * this.scaleNum);
        this.wall3.shape.setElasticity(0);
        this.wall3.shape.setFriction(0);
        this.space.addStaticShape(this.wall3.shape, 10);
        this.wall3.shape.setCollisionType(2);
        this.wall3.sprite = new cc.PhysicsSprite;
        this.wall3.sprite.setBody(this.wall3.body);
        this.wall3.sprite.setPosition(cc.p(this.panZiSpr1.x, this.panZiSpr1.y -
            7 * this.scaleNum));
        this.addChild(this.wall3.sprite, 10);
        this.wall3.body.setAngleInternal(0);
        this.space.reindexStatic();
        this.space.reindexShape(this.wall3.shape);
        this.wall4 = {};
        this.wall4.body = new cp.StaticBody(1, cp.momentForBox(1, 610 * this.scaleNum, 10 * this.scaleNum));
        this.wall4.body.setPos(cc.p(this.panZiSpr1.x - 395 * this.scaleNum, 45 * this.scaleNum));
        this.wall4.shape = new cp.BoxShape(this.wall4.body, 610 * this.scaleNum, 10 * this.scaleNum);
        this.wall4.shape.setElasticity(0);
        this.wall4.shape.setFriction(0.1);
        this.space.addStaticShape(this.wall4.shape,
            10);
        this.wall4.shape.setCollisionType(3);
        this.wall4.sprite = new cc.PhysicsSprite;
        this.wall4.sprite.setBody(this.wall4.body);
        this.wall4.sprite.setPosition(cc.p(this.panZiSpr1.x - 395 * this.scaleNum, 45 * this.scaleNum));
        this.addChild(this.wall4.sprite, 10);
        this.wall4.body.setAngleInternal(0);
        this.space.reindexStatic();
        this.space.reindexShape(this.wall4.shape);
        this.wall5 = {};
        this.wall5.body = new cp.StaticBody(1, cp.momentForBox(1, 610 * this.scaleNum, 10 * this.scaleNum));
        this.wall5.body.setPos(cc.p(this.panZiSpr1.x +
            395 * this.scaleNum, 45 * this.scaleNum));
        this.wall5.shape = new cp.BoxShape(this.wall5.body, 610 * this.scaleNum, 10 * this.scaleNum);
        this.wall5.shape.setElasticity(0);
        this.wall5.shape.setFriction(0.1);
        this.space.addStaticShape(this.wall5.shape, 10);
        this.wall5.shape.setCollisionType(3);
        this.wall5.sprite = new cc.PhysicsSprite;
        this.wall5.sprite.setBody(this.wall5.body);
        this.wall5.sprite.setPosition(cc.p(this.panZiSpr1.x + 395 * this.scaleNum, 45 * this.scaleNum));
        this.addChild(this.wall5.sprite, 10);
        this.wall5.body.setAngleInternal(0);
        this.space.reindexStatic();
        this.space.reindexShape(this.wall5.shape)
    },
    initCollisionFunc: function () {
        this.space.addCollisionHandler(1, 2, this.collisionBegin.bind(this), this.collisionPre.bind(this), this.collisionPost.bind(this), this.collisionSeparate.bind(this));
        this.space.addCollisionHandler(1, 3, this.collisionBegin.bind(this), this.collisionPre.bind(this), this.collisionPost.bind(this), this.collisionSeparate.bind(this));
        this.space.addCollisionHandler(1, 1, this.collisionBegin.bind(this), this.collisionPre.bind(this),
            this.collisionPost.bind(this), this.collisionSeparate.bind(this))
    },
    collisionBegin: function (c, d) {
        switch (c.getShapes()[1].collision_type) {
            case 1:
                this.space.addPostStepCallback(function () {
                    !1 == GC.canEffectBool && (GC.canEffectBool = !0, AudioManager.playEffect(music.p))
                }.bind(this));
                break;
            case 2:
                this.space.addPostStepCallback(function () {
                    GC.chaEyeBool = !0;
                    !1 == GC.canEffectBool && AudioManager.playEffect(music.p);
                    MainManager.getDist(this.objApple.sprite.x, this.objApple.sprite.y, 20, CH - 20);
                    this.space.removeBody(this.objApple.body);
                    this.space.removeShape(this.objApple.shape);
                    this.objApple.sprite.moveState = 1;
                    this.objApple.sprite.runAction(cc.sequence(cc.moveBy(0.1, 0, 9), cc.moveBy(0.1, 0, -9), cc.delayTime(0.02), cc.fadeOut(0.1), cc.callFunc(function () {
                        mainSelf._touchRightNum++
                    }), cc.callFunc(this.goToNext.bind(this)), cc.callFunc(function () {
                        GameManager.addRightScore(1);
                        mainSelf.judgeGameOver()
                    }), cc.removeSelf(!0)))
                }.bind(this));
                break;
            case 3:
                this.space.addPostStepCallback(function () {
                    GameManager.clickErrorNum++;
                    !1 == GC.canEffectBool && AudioManager.playEffect(music.posui);
                    this.space.removeBody(this.objApple.body);
                    this.space.removeShape(this.objApple.shape);
                    this.objApple.sprite.moveState = 0;
                    this.objApple.sprite.setLocalZOrder(5);
                    this.objApple.sprite.runAction(cc.sequence(cc.moveBy(0.1, 0, 10), cc.moveBy(0.1, 0, -10), cc.callFunc(function () {
                            mainSelf._touchErrorNum++;
                            GameManager.reduceTotalScore(1);
                            0 <= GameManager.totalNum && mainSelf.scoreTotalView.setScore()
                        }), cc.callFunc(function () {
                            mainSelf.objApple.sprite.setTexture(res.apple2_png)
                        }), cc.delayTime(0.039), cc.callFunc(function () {
                            mainSelf.objApple.sprite.setTexture(res.apple3_png)
                        }),
                        cc.delayTime(0.039), cc.callFunc(function () {
                            mainSelf.objApple.sprite.setTexture(res.apple4_png)
                        }), cc.delayTime(0.039), cc.callFunc(function () {
                            mainSelf.objApple.sprite.setTexture(res.apple5_png)
                        }), cc.callFunc(this.goToNext.bind(this)), cc.callFunc(function () {
                            mainSelf.judgeGameOver()
                        }), cc.delayTime(0.1), cc.fadeOut(0.1), cc.removeSelf(!0)))
                }.bind(this))
        }
        return !0
    },
    addNewAppleAction: function () {
        var c = UIToolManager.getSprite(res.apple1_png, 0, 1, 8, CH - 60);
        c.setScale(0.6 * this.scaleNum);
        this.addChild(c, 21);
        c.runAction(cc.sequence(cc.moveBy(0.1,
            cc.p(0, 46)), cc.removeSelf(!0)))
    },
    judgeGameOver: function () {
        var c = this._touchErrorNum + this._touchRightNum;
        10 >= c ? this._norCountTime = 7 : 15 >= c ? this._norCountTime = 6 : 20 >= c ? this._norCountTime = 6 : 25 >= c ? this._norCountTime = 5 : 30 >= c && (this._norCountTime = 4);
        this._speed = 5 + 0.1 * (this._touchErrorNum + this._touchRightNum);
        30 <= this._touchErrorNum + this._touchRightNum && (GameManager.score = GameManager.clickRightNum, cc.log("GameScore", GameManager.score), this.gameEnd())
    },
    collisionPre: function (c, d) {
        return !0
    },
    collisionPost: function (c,
                             d) {
    },
    collisionSeparate: function (c, d) {
    },
    initDropApple: function () {
        var c = 0, d = 0;
        1 == MainManager.randomInt(1, 2) ? (c = MainManager.randomInt(100, CW - 100) * this.scaleNum, d = MainManager.randomInt(500, 800) * this.scaleNum) : (c = MainManager.randomInt(190, 590) * this.scaleNum, d = MainManager.randomInt(800, 880) * this.scaleNum);
        c = cc.p(c, d);
        this.objApple = {};
        this.objApple.body = new cp.Body(1, cp.momentForCircle(1, 0, 36 * this.scaleNum, cp.v(0, 0)));
        this.objApple.body.setPos(c);
        this.space.addBody(this.objApple.body);
        this.objApple.shape =
            new cp.CircleShape(this.objApple.body, 36 * this.scaleNum, cp.v(0, 0));
        this.objApple.shape.setElasticity(0);
        this.objApple.shape.setFriction(1);
        this.space.addShape(this.objApple.shape);
        this.objApple.shape.setCollisionType(1);
        this.objApple.sprite = new cc.PhysicsSprite(res.apple1_png);
        this.objApple.sprite.setBody(this.objApple.body);
        this.objApple.sprite.setPosition(c.x, c.y);
        this.objApple.sprite.dropState = 1;
        this.objApple.sprite.moveState = 0;
        this.objApple.sprite.setScale(this.scaleNum);
        this.addChild(this.objApple.sprite,
            3);
        2 <= GameManager.levelNum && (this.objApple.sprite.setOpacity(0), this.objApple.sprite.runAction(cc.sequence(cc.fadeIn(0.15))))
    },
    gameStart: function () {
        if (10 <= document.body.scrollTop)return document.documentElement.scrollTop = document.body.scrollTop = 0, !1;
        MainManager.gameResume();
        this.createListener();
        this.unscheduleUpdate();
        this.scheduleUpdate()
    },
    gameEnd: function () {
        this.removeListener();
        MainManager.isPause = !0;
        MainManager.canTouch = !1;
        this.scoreView.setScore();
        this.runAction(cc.sequence(cc.delayTime(0.5),
            cc.callFunc(this.gameEnd1.bind(this))))
    },
    gameEnd1: function () {
        this.unscheduleUpdate();
        AudioManager.playEffect(music.gameover);
        var c = 1, c = LanguageManager.chineseFlag ? 1 : 2, c = UIToolManager.getSprite(comRes["game_over" + c + "_png"], 0.5, 0.5, CW / 2, CH / 2 + 50);
        this.addChild(c, 30);
        c.setOpacity(0);
        c.setScale(this.scaleNum);
        c.runAction(cc.sequence(cc.delayTime(0.2), cc.spawn(cc.fadeIn(0.8), cc.moveBy(0.8, 0, -50)), cc.delayTime(0.5), cc.callFunc(this.initEndLayer.bind(this)), cc.removeSelf()))
    },
    initEndLayer: function () {
        MainManager.gotoEndLayer()
    },
    createListener: function () {
        this.lis1 = cc.EventListener.create({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            swallowTouches: !0,
            onTouchBegan: this.onTouchBegan.bind(this),
            onTouchEnded: this.onTouchEnded.bind(this)
        });
        cc.eventManager.addListener(this.lis1, this)
    },
    removeListener: function () {
        cc.eventManager.removeListener(this.lis1);
        this.lis1 = null
    },
    onTouchBegan: function (c, d) {
        if (0 > c.getLocation().y)return document.documentElement.scrollTop = document.body.scrollTop = 0, !1;
        MainManager.canTouch && !1 == GC.canTouchBool && (this.touchBeganApple(),
            GC.canTouchBool = !0);
        return !0
    },
    onTouchEnded: function () {
    },
    touchBeganApple: function () {
        this.objApple.sprite.runAction(cc.sequence(cc.moveBy(0.07, 0, 15), cc.delayTime(0.02), cc.callFunc(function () {
            GC.appleDropBool = !0;
            mainSelf.space.gravity = cp.v(0, -600)
        })))
    },
    update: function (c) {
        this.space.step(0.03);
        this.scoreView.addScoreFunc();
        this.updateAniMove();
        this.updateChangeSpeedSign()
    },
    updateAniMove: function () {
        this._countTime++;
        this._countTime1++;
        this._countTime >= this._norCountTime && (this._countTime = 0, this._indexN++,
        5 <= this._indexN && (this._indexN = 1), this.aniSpr3.setTexture(res["st" + this._indexN + "_png"]));
        50 <= this._countTime1 && (this._countTime1 = 0, this._indexN1++, 3 <= this._indexN1 && (this._indexN1 = 1));
        this.aniSpr1.setPositionX(this.aniSpr1.getPositionX() + this._speedSign * this._speed);
        this.aniSpr2.setPositionX(this.aniSpr2.getPositionX() + this._speedSign * this._speed);
        this.aniSpr3.setPositionX(this.aniSpr3.getPositionX() + this._speedSign * this._speed);
        this.panZiSpr1.setPositionX(this.panZiSpr1.getPositionX() + this._speedSign *
            this._speed);
        this.panZiSpr2.setPositionX(this.panZiSpr2.getPositionX() + this._speedSign * this._speed);
        this.wall1.sprite.setPositionX(this.wall1.sprite.getPositionX() + this._speedSign * this._speed);
        this.wall2.sprite.setPositionX(this.wall2.sprite.getPositionX() + this._speedSign * this._speed);
        this.wall3.sprite.setPositionX(this.wall3.sprite.getPositionX() + this._speedSign * this._speed);
        this.wall4.sprite.setPositionX(this.wall4.sprite.getPositionX() + this._speedSign * this._speed);
        this.wall5.sprite.setPositionX(this.wall5.sprite.getPositionX() +
            this._speedSign * this._speed);
        null != this.objApple.sprite && 1 == this.objApple.sprite.moveState && this.objApple.sprite.setPositionX(this.objApple.sprite.getPositionX() + this._speedSign * this._speed);
        this.space.reindexStatic();
        this.space.reindexShape(this.wall1.shape);
        this.space.reindexShape(this.wall2.shape);
        this.space.reindexShape(this.wall3.shape);
        this.space.reindexShape(this.wall4.shape);
        this.space.reindexShape(this.wall5.shape)
    },
    updateChangeSpeedSign: function () {
        this.aniSpr1.getPositionX() >= CW / 2 + 310 * this.scaleNum ?
            (this._speedSign = -1, this._indexN2 = 3, this.aniSpr2.setTexture(res.sy3_png)) : this.aniSpr1.getPositionX() <= CW / 2 - 280 * this.scaleNum && (this.aniSpr2.setTexture(res.sy4_png), this._indexN2 = 4, this._speedSign = 1)
    },
    updateChaAniEye: function () {
        !1 == GC.chaEyeBool && (this._countEyeTotalTime++, this._countEyeTotalTime >= this._countNorEyeTime && (this._countNorEyeTime = MainManager.randomInt(260, 500), this._countEyeTime = this._countEyeTotalTime = 0, GC.chaEyeBool = !0, this.aniSpr2.setTexture(res.sy1_png), this.runAction(cc.sequence(cc.delayTime(0.1),
            cc.callFunc(function () {
                mainSelf.aniSpr2.setTexture(res["sy" + this._indexN2 + "_png"])
            })))))
    },
    goToNext: function () {
        mainSelf.space.gravity = cp.v(0, 0);
        GameManager.levelNum++;
        this.objApple.sprite = null;
        GC.appleStopBool = !1;
        GC.appleDropBool = !1;
        GC.canTouchBool = !1;
        GC.canEffectBool = !1;
        this.initDropApple()
    },
    addLinkGame: function () {
        if (null != MainManager.linkData) {
            this.btnLink = new cc.MenuItemImage(comRes.btn_link_png, comRes.btn_link_png, this.openLinkGame.bind(this));
            this.btnLink.setOpacity(150);
            this.btnLink.setScaleX(0.8);
            this.btnLink.setPosition(CW - 40, CH - 40);
            var c;
            c = new cc.Menu(this.btnLink);
            c.setPosition(0, 0);
            this.addChild(c)
        }
    },
    openLinkGame: function () {
        MainManager.isPause || (MainManager.gamePause(), UIManager.show(UIName.LinkLayer, MainManager.linkData))
    },
    hide: function () {
        this.stopAllActions();
        this.unscheduleUpdate();
        this.bg = this.scoreView = this.lis1 = null;
        this.removeAllChildren(!0);
        this.removeFromParent(!0);
        mainSelf = null
    },
    onExit: function () {
        this._super();
        cc.log("main ----- delete")
    }
});
var StartLayer = cc.Layer.extend({
    ctor: function () {
        this._super()
    }, setData: function (c) {
        c = cc.director.getWinSize().height / 1280;
        var d = 0, e = 0;
        0.76 <= c ? (d = 1, e = 0) : 0.73 < c ? (d = 0.9, e = 0.1) : 0.7 <= c ? (d = c, e = 1 - c) : 0.6 <= c ? e = d = 0.5 : 0.5 <= c ? (d = 0.4, e = 0.6) : 0.4 <= c ? (d = 0.2, e = 0.8) : 0.1 <= c ? (d = 0.1, e = 0.9) : 0 <= c && (d = 0.05, e = 0.95);
        this.scaleNum = d + CH / 1280 * e;
        this.init();
        this.createListener()
    }, init: function () {
        var c = new cc.LayerColor(cc.color(0, 0, 0, 150));
        this.addChild(c);
        if (10 <= document.body.scrollTop)return document.documentElement.scrollTop =
            document.body.scrollTop = 0, !1;
        var d = 46 * this.scaleNum, c = 66 * this.scaleNum, e = LanguageManager.getText("game_info"), f = LanguageManager.getText("start"), d = new cc.LabelTTF(e, "Arial", d, cc.size(600, 600), cc.TEXT_ALIGNMENT_LEFT);
        d.setAnchorPoint(0.5, 1);
        d.x = CW / 2;
        d.y = 3 * CH / 4;
        this.addChild(d);
        c = UIToolManager.getLabelTTF(f, c, 0.5, 0.5, CW / 2, 100);
        this.addChild(c)
    }, createListener: function () {
        this.lis1 = cc.EventListener.create({
            event: cc.EventListener.TOUCH_ONE_BY_ONE, swallowTouches: !0, onTouchBegan: this.onTouchBegan.bind(this),
            onTouchMoved: this.onTouchMoved.bind(this), onTouchEnded: this.onTouchEnded.bind(this)
        });
        cc.eventManager.addListener(this.lis1, this)
    }, removeListener: function () {
        cc.eventManager.removeListener(this.lis1);
        this.lis1 = null
    }, onTouchBegan: function (c, d) {
        return !0
    }, onTouchMoved: function (c, d) {
    }, onTouchEnded: function (c, d) {
        this.closeLayer()
    }, closeLayer: function () {
        UIManager.hide(UIName.StartLayer);
        mainSelf.gameStart()
    }, hide: function () {
        this.removeListener();
        this.lis1 = null;
        this.cleanup();
        this.removeAllChildren(!0)
    },
    onExit: function () {
        this._super();
        cc.log("game start ----- delete");
        this.hide()
    }
});
var EndLayer = PopLayer.extend({
    standardScore: 0, minScore: 0, ctor: function () {
        this._super();
        EndLayerSelf = this;
        this.standardScore = 10;
        cc.log("\u6e38\u620f\u7ed3\u675f\u4e86");
        this.setData();
        var c = new cc.LayerColor(cc.color(54, 152, 197, 255));
        this.addChild(c);
        score_share(GameManager.gameName + "\uff0c\uff5e\u6211" + GameManager.score + "\u5206\uff0c\u4f60\u5462\uff1f");
        this.initUI1()
    }, setData: function () {
        var c = cc.director.getWinSize().height / 1280, d = 0, e = 0;
        0.76 <= c ? (d = 1, e = 0) : 0.73 < c ? (d = 0.9, e = 0.1) : 0.7 <= c ? (d = c, e = 1 - c) : 0.6 <=
        c ? e = d = 0.5 : 0.5 <= c ? (d = 0.4, e = 0.6) : 0.4 <= c ? (d = 0.2, e = 0.8) : 0.1 <= c ? (d = 0.1, e = 0.9) : 0 <= c && (d = 0.05, e = 0.95);
        this.scaleNum = d + CH / 1280 * e;
        cc.log("this.scale", this.scaleNum)
    }, initUI1: function () {
        var c = 46 * this.scaleNum;
        this.tipLabel = new cc.LabelTTF(this.getContentByScore(GameManager.score, GameManager.gameName), "Arial", c, cc.size(600, 600), cc.TEXT_ALIGNMENT_LEFT);
        this.tipLabel.setAnchorPoint(0.5, 1);
        this.tipLabel.setPosition(CW / 2, CH / 2 + 150 * this.scaleNum);
        this.addChild(this.tipLabel);
        this.btnMore = new cc.MenuItemImage(comRes.btn_more_png,
            comRes.btn_more_png, function () {
                MainManager.gotoMoreGame()
            }, this);
        this.btnMore.setPosition(CW / 2, CH / 2 - 130);
        this.btnAgain = new cc.MenuItemImage(comRes.btn_again_png, comRes.btn_again_png, function () {
            cc.director.runScene(new GameScene);
            cc.director.resume()
        }, this);
        this.btnAgain.setPosition(CW / 2 - 150, this.btnMore.y - 190);
        this.btnGz = new cc.MenuItemImage(comRes.btn_gz_png, comRes.btn_gz_png, function () {
                window.location.href = "http://mp.weixin.qq.com/s?__biz\x3dMzA5NzQxMzU4NQ\x3d\x3d\x26mid\x3d207293871\x26idx\x3d1\x26sn\x3d173662dd6d0b62ec9f19382a5368f270#rd"
            },
            this);
        this.btnGz.setPosition(CW / 2 + 150, this.btnMore.y - 190);
        c = new cc.Menu(this.btnAgain, this.btnMore, this.btnGz);
        c.setPosition(0, 0);
        this.addChild(c);
        c.setScale(this.scaleNum);
        cc.loader.loadImg(cc._Img, {isCrossOrigin: !1}, function (c, e) {
            EndLayerSelf.initStage(e)
        })
    }, initStage: function (c) {
        var d = new cc.Texture2D;
        d.initWithElement(c);
        d.handleLoadedTexture();
        c = new cc.Sprite(d);
        c.setScale(this.scaleNum);
        c.setAnchorPoint(0.5, 0.5);
        c.setPosition(CW / 2, this.tipLabel.y + (CH - this.tipLabel.y) / 2 - 40);
        EndLayerSelf.addChild(c,
            10)
    }, getContentByScore: function (c, d) {
        var e = "\u6211\u771f\u662f\u592a\u5389\u5bb3\uff0c\u5728" + d + "\u4e2d\u63a5\u53ea\u63a5\u4f4f\u4e860\u4e2a\u82f9\u679c\uff0c\u5168\u7403\u53ea\u67091\u4e2a\u4eba\u63a5\u4f4f\u4e860\u4e2a\uff01", f = parseInt(0.3 * this.standardScore), g = parseInt(1.5 * this.standardScore), h = parseInt(2.5 * this.standardScore), k = parseInt(4 * this.standardScore);
        0 < c && c <= f ? e = "\u6211\u5728" + d + "\u4e2d\u63a5\u4f4f\u4e86" + c + "\u4e2a\u82f9\u679c\uff0c\u771f\u662f\u592a\u68d2\u4e86\uff0c\u518d\u7ec3\u7ec3\u5c31\u80fd\u5f97\u5fc3\u5e94\u624b\uff01" :
            c > f && c <= this.standardScore ? e = "\u6211\u5728" + d + "\u4e2d\u63a5\u4f4f\u4e86" + c + "\u4e2a\u82f9\u679c\uff0c\u771f\u662f\u592a\u68d2\u4e86\uff0c\u518d\u7ec3\u7ec3\u5c31\u80fd\u8fbe\u5230\u6e38\u5203\u6709\u4f59\u7684\u5883\u754c\uff01" : c > this.standardScore && c <= g ? e = "\u6211\u5728" + d + "\u4e2d\u63a5\u4f4f\u4e86" + c + "\u4e2a\u82f9\u679c\uff0c\u51fb\u8d25\u4e86\u5168\u7403" + (Math.floor(12 * (c - this.standardScore) / (g - this.standardScore)) + 80) + "%\u7684\u73a9\u5bb6\uff0c\u8fdb\u5165\u4e86\u4fe1\u624b\u62c8\u6765\u7684\u5883\u754c\uff01" :
                c > g && c <= h ? e = "\u6211\u5728" + d + "\u4e2d\u63a5\u4f4f\u4e86" + c + "\u4e2a\u82f9\u679c\uff0c\u51fb\u8d25\u4e86\u5168\u7403" + (Math.floor(7 * (c - g) / (h - g)) + 92) + "%\u7684\u73a9\u5bb6\uff0c\u8fdb\u5165\u4e86\u8fd0\u7528\u81ea\u5982\u7684\u5883\u754c\uff01" : c > h && c <= k ? e = "\u6211\u5728" + d + "\u4e2d\u63a5\u4f4f\u4e86" + c + "\u4e2a\u82f9\u679c\uff0c\u51fb\u8d25\u4e86\u5168\u740399%\u7684\u73a9\u5bb6\uff0c\u8fbe\u5230\u4e86\u884c\u4e91\u6d41\u6c34\u7684\u5883\u754c\uff01" : c > k && c < game_max_score ? (Math.ceil(17 * (c - k) / (game_max_score -
                    k)), e = "\u6211\u5728" + d + "\u4e2d\u63a5\u4f4f\u4e86" + c + "\u4e2a\u82f9\u679c\uff0c\u636e\u8bf4\u5168\u7403\u53ea\u6709 16\u4e2a\u4eba\u8fbe\u5230\u8fd9\u4e2a\u6c34\u5e73\uff0c\u72ec\u5b64\u6c42\u8d25\uff01") : c >= game_max_score && (e = "\u6211\u5728" + d + "\u4e2d\u63a5\u4f4f\u4e86" + c + "\u4e2a\u82f9\u679c\uff0c\u8d85\u8d8a\u4e86\u72ec\u5b64\u6c42\u8d25\uff0c\u5fc3\u6709\u7075\u7280\uff01");
        c >= game_max_score && (game_max_score = c);
        score_share(e);
        return e
    }, hide: function () {
        this.removeAllChildren(!0);
        this.removeFromParent(!0)
    },
    onExit: function () {
        this._super();
        cc.log("end Layer-----delete")
    }
});
cc._Img = "res/logo.png";
var EndLayerEnglish = PopLayer.extend({
    tipLabel: null,
    chouJiangItem: null,
    moreGameItem: null,
    _shareLabel: null,
    size: null,
    bestScore: 0,
    ctor: function () {
        this._super()
    },
    setData: function (c) {
        this.initUI();
        this.showScore(GameManager.score)
    },
    initUI: function () {
        var c = cc.director.getVisibleSize();
        this.scale = c.width / 720;
        this.size = c;
        var d = new cc.LayerColor(cc.color(150, 150, 150));
        this.addChild(d);
        d.scale = 1 / this.scale;
        this.tipLabel = UIToolManager.getLabelTTF("Best : " + GameManager.score, 45, 0.5, 1, c.width / 2, 2 * c.height / 3 - 130);
        this.tipLabel.setAnchorPoint(0.5, 1);
        d = c.height / 2 - 200;
        0.95 > this.scale && (this.tipLabel.y += 50, d.y -= 50);
        var e = new cc.MenuItemImage(comRes.icon_moregame_png, comRes.icon_moregame_png, function () {
            MainManager.gotoMoreGame()
        }, this);
        e.attr({x: c.width / 2, y: d + 80, anchorX: 0.5, anchorY: 0.5});
        e.color = cc.color("#fcf253");
        e.scale = 0.8;
        e.y -= 0.1 * e.height;
        var f = new cc.MenuItemImage(comRes.icon_facebook_png, comRes.icon_facebook_png, function () {
            this.onFacebookClick()
        }, this);
        f.attr({x: c.width / 2 - 160, y: d - 80, anchorX: 0.5, anchorY: 0.5});
        var g = new cc.MenuItemImage(comRes.icon_replay_png, comRes.icon_replay_png, function () {
            cc.director.runScene(new GameScene);
            cc.director.resume()
        }, this);
        g.attr({x: c.width / 2 + 160, y: f.y, anchorX: 0.5, anchorY: 0.5});
        var h = new cc.MenuItemImage(comRes.icon_twitter_png, comRes.icon_twitter_png, function () {
            this.onTwitterClick()
        }, this);
        h.attr({x: c.width / 2, y: f.y, anchorX: 0.5, anchorY: 0.5});
        c = new cc.Menu(h, f, g, e);
        c.x = 0;
        c.y = 0;
        this.addChild(c);
        c = f.x - f.width / 2;
        g = g.x + g.width / 2;
        f = d - 1;
        d += 1;
        e = new cc.DrawNode;
        e.drawRect(cc.p(c,
            f), cc.p(g, d), cc.color("#ffffff"), 0, cc.color("#ffffff"));
        this.addChild(e)
    },
    showScore: function (c) {
        var d = this.size, e = UIToolManager.getSprite(comRes.score_bg_png, 0.5, 0.5, d.width / 2, this.tipLabel.y + 130);
        this.addChild(e);
        c = UIToolManager.getLabelTTF(c.toString(), 70, 0.5, 0.5, d.width / 2, e.y, cc.color("#000000"));
        this.addChild(c)
    },
    onTwitterClick: function () {
        var c, d;
        c = location.href;
        d = document.title + " is very interesting, come play with me, click play now!";
        c = "http://twitter.com/share/?url\x3d" + encodeURIComponent(c) +
            "\x26text\x3d" + encodeURIComponent(d);
        window.location.href = c
    },
    onFacebookClick: function () {
        var c, d;
        c = location.href;
        d = document.title + " my best score: " + GameManager.score + ", come play with me, click play now!";
        var e = LanguageManager.getText("game_name");
        c = "https://www.facebook.com/dialog/feed?app_id\x3d" + MainManager.id_facebookShare + "\x26link\x3d" + encodeURIComponent(c) + "\x26redirect_uri\x3d" + encodeURIComponent(c) + "\x26name\x3d" + d + "\x26description\x3d" + e;
        window.location.href = c
    },
    hide: function () {
        this.removeAllChildren(!0);
        this.removeFromParent(!0)
    },
    onExit: function () {
        this._super();
        cc.log("end EngilshLayer ----- delete")
    }
});
var LinkLayer = cc.Layer.extend({
    lis1: null, bg: null, ctor: function () {
        this._super();
        var c = cc.director.getWinSize().height / 1280, d = 0, e = 0;
        0.76 <= c ? (d = 1, e = 0) : 0.73 < c ? (d = 0.9, e = 0.1) : 0.7 <= c ? (d = c, e = 1 - c) : 0.6 <= c ? e = d = 0.5 : 0.5 <= c ? (d = 0.4, e = 0.6) : 0.4 <= c ? (d = 0.2, e = 0.8) : 0.1 <= c ? (d = 0.1, e = 0.9) : 0 <= c && (d = 0.05, e = 0.95);
        this.scaleNum = d + CH / 1280 * e;
        this.bg = new cc.DrawNode;
        this.bg.drawRect(cc.p(0, 0), cc.p(CW, CH), cc.color(0, 0, 0, 100), -1);
        this.addChild(this.bg);
        this.nodeContainer = new cc.Node;
        this.addChild(this.nodeContainer)
    }, setData: function (c) {
        this.initUI(c);
        this.layerIn()
    }, createListener: function () {
        this.lis1 = cc.EventListener.create({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            swallowTouches: !0,
            onTouchBegan: this.onTouchBegan.bind(this),
            onTouchMoved: this.onTouchMoved.bind(this),
            onTouchEnded: this.onTouchEnded.bind(this)
        });
        cc.eventManager.addListener(this.lis1, this)
    }, removeListener: function () {
        cc.eventManager.removeListener(this.lis1);
        this.lis1 = null
    }, onTouchBegan: function (c, d) {
        return !0
    }, onTouchMoved: function (c, d) {
    }, onTouchEnded: function (c, d) {
        c.getLocation().x >
        this.LW && this.layerOut()
    }, initUI: function (c) {
        this.LW = CW / 2 + 100 * this.scaleNum;
        this.bgColor = new cc.DrawNode;
        this.bgColor.drawRect(cc.p(0, 0), cc.p(this.LW, CH), cc.color(0, 0, 0, 255), -1);
        this.nodeContainer.addChild(this.bgColor);
        var d = this.LW / 2, e = CH - 100 * this.scaleNum, f = 340, g = 0.8;
        switch (cc.sys.language) {
            case cc.sys.LANGUAGE_CHINESE:
                g = 0.65, f = 280
        }
        this.txt1 = UIToolManager.getLabelTTF("  " + LanguageManager.getText("link_top_tip"), 42 * this.scaleNum, 0.5, 0.5, d - 47, e);
        this.nodeContainer.addChild(this.txt1);
        this.txt1.width >
        f && (this.txt1.scale = f / this.txt1.width);
        f = new cc.Menu;
        f.setPosition(0, 0);
        this.nodeContainer.addChild(f);
        for (var h = c.gameList.length, k = 0; k < h; k++) {
            var e = e - 100 * this.scaleNum, m = new cc.MenuItemImage(comRes.button1_png, comRes.button1_png, this.openLink.bind(this, c.gameList[k][1]));
            m.setPosition(d, e);
            m.setScaleX(g * this.scaleNum);
            m.setScaleY(0.75 * this.scaleNum);
            var n = UIToolManager.getLabelTTF("" + c.gameList[k][0], 40 * this.scaleNum, 0.5, 0.5, d, e);
            this.nodeContainer.addChild(n);
            f.addChild(m);
            m = (m.width - 20) * m.scaleX;
            n.width > m && (n.scale = m / n.width)
        }
        e = CH / 2;
        g = new cc.MenuItemImage(comRes.btn_jiantou_png, comRes.btn_jiantou_png, this.layerOut.bind(this));
        g.setAnchorPoint(1, 0.5);
        g.setScale(this.scaleNum);
        g.setPosition(this.LW - 15, e);
        f.addChild(g);
        e = 145 * this.scaleNum;
        this.btnCenter = new cc.MenuItemImage(comRes.button2_png, comRes.button2_png, this.openLink.bind(this, c.gameCenter));
        this.btnCenter.setPosition(d, e);
        this.btnCenter.setScale(0.85 * this.scaleNum);
        n = UIToolManager.getLabelTTF("" + LanguageManager.getText("game_center"),
            44 * this.scaleNum, 0.5, 0.5, d, e);
        this.nodeContainer.addChild(n);
        f.addChild(this.btnCenter);
        200 < n.width && (n.scale = 200 / n.width)
    }, openLink: function (c) {
        window.location.href = c
    }, layerIn: function () {
        AudioManager.playEffect(music.openLayer);
        this.nodeContainer.x = -CW / 2;
        this.nodeContainer.runAction(cc.sequence(cc.moveTo(0.2, 0, 0), cc.callFunc(this.layerInEnd.bind(this))))
    }, layerInEnd: function () {
        this.createListener()
    }, layerOut: function () {
        AudioManager.playEffect(music.openLayer);
        this.removeListener();
        this.nodeContainer.runAction(cc.sequence(cc.moveTo(0.2,
            -CW / 2, 0), cc.callFunc(this.closeLayer.bind(this))))
    }, closeLayer: function () {
        UIManager.hide(UIName.LinkLayer);
        MainManager.gameResume()
    }, hide: function () {
        this.removeListener();
        this.removeAllChildren(!0);
        this.removeFromParent(!0)
    }, onExit: function () {
        this._super();
        cc.log("link ----- delete")
    }
});
var sw = 39.8, sh = 52, ScoreView1 = cc.Node.extend({
    scoreTxt: null, nowScore: 0, addV: 2, speed: 0, ctor: function (c, d, e, f, g) {
        this._super();
        this.nowScore = 0;
        this.initUI(c, d, e, f, g)
    }, initUI: function (c, d, e, f, g) {
        this.scoreTxt = new cc.LabelAtlas("0", res.number_png, sw, sh, "0");
        this.scoreTxt.setAnchorPoint(c, d);
        this.scoreTxt.setPosition(e, f);
        this.addChild(this.scoreTxt);
        this.scoreTxt.setScale(0.8 * g);
        this.setScore()
    }, setScore: function () {
        this.nowScore = GameManager.clickRightNum;
        this.scoreTxt.string = GameManager.clickRightNum.toString()
    },
    addScoreFunc: function () {
        GameManager.clickRightNum > this.nowScore && (this.speed++, this.speed == this.addV && (this.speed = 0, this.nowScore++, this.scoreTxt.string = this.nowScore.toString()))
    }
}), ScoreView2 = cc.Node.extend({
    scoreTxt: null, nowScore: 0, addV: 2, speed: 0, ctor: function (c, d, e, f, g) {
        this._super();
        this.nowScore = 0;
        this.initUI(c, d, e, f, g)
    }, initUI: function (c, d, e, f, g) {
        this.scoreTxt = new cc.LabelAtlas("0", res.number_png, sw, sh, "0");
        this.scoreTxt.setAnchorPoint(c, d);
        this.scoreTxt.setPosition(e, f);
        this.addChild(this.scoreTxt);
        this.scoreTxt.setScale(g);
        this.setScore()
    }, setScore: function () {
        this.nowScore = GameManager.totalNum;
        this.scoreTxt.string = GameManager.clickRightNum.toString()+" / "+ GameManager.totalNum.toString();
    }, addScoreFunc: function () {
        GameManager.totalNum > this.nowScore && (this.speed++, this.speed == this.addV && (this.speed = 0, this.nowScore++, this.scoreTxt.string = this.nowScore.toString()))
    }
}), AddTxt = cc.Node.extend({
    add: null, txt: null, ctor: function (c) {
        this._super();
        this.setCascadeOpacityEnabled(!0);
        this.init(c)
    }, init: function (c) {
        this.txt = new cc.LabelAtlas("" + c, res.number1_png,
            60, 56, "0");
        this.txt.setAnchorPoint(0.5, 0.5);
        this.addChild(this.txt);
        this.txt.string = c.toString();
        this.show()
    }, show: function () {
        this.runAction(cc.sequence(cc.spawn(cc.moveBy(0.5, 0, 100), cc.fadeOut(0.5)), cc.callFunc(this.destroy.bind(this))))
    }, destroy: function () {
        this.removeAllChildrenWithCleanup(!0);
        this.removeFromParent(!0)
    }
});
var loadLayer = cc.Layer.extend({
    lis1: null, resEnd: !1, ctor: function () {
        this._super();
        loadSelf = this;
        this.init()
    }, init: function () {
        this.btnStartFunc()
    }, btnStartFunc: function () {
        cc.log("\u5f00\u59cb\u6e38\u620f");
        cc.LoaderScene.preload(g_resources, function () {
            MainManager.startGame()
        }, this)
    }
}), LoadScene = cc.Scene.extend({
    onEnter: function () {
        this._super();
        var c = new loadLayer;
        this.addChild(c)
    }, onExit: function () {
        this._super();
        cc.log("load scene ----- delete")
    }
}), CW = 0, CH = 0;
var GameLayer = cc.Layer.extend({
    lis1: null, GameSelf: null, ctor: function () {
        this._super();
        GameSelf = this;
        this.setData()
    }, setData: function () {
        CW = parseInt(cc.director.getVisibleSize().width);
        CH = parseInt(cc.director.getVisibleSize().height);
        GameManager.setData();
        UIManager.init();
        UIManager.register(this);
        this.init()
    }, init: function () {
        UIManager.show(UIName.MainLayer);
        if (1 < GameManager.playNum)return mainSelf.gameStart(), !0;
        MainManager.gamePause();
        UIManager.show(UIName.StartLayer)
    }, onExit: function () {
        this._super();
        GameSelf = null
    }
}), GameScene = cc.Scene.extend({
    onEnter: function () {
        this._super();
        this.initGame()
    }, initGame: function () {
        var c = new GameLayer;
        this.addChild(c)
    }, hide: function () {
        this.unscheduleUpdate();
        this.cleanup();
        this.removeAllChildren(!0)
    }, onExit: function () {
        this._super();
        cc.log("game scene ----- delete");
        this.hide()
    }
});
var PC_FLAG = !1, IOS_FLAG = !1;
cc.game.onStart = function () {
    !cc.sys.isNative && document.getElementById("cocosLoading") && document.body.removeChild(document.getElementById("cocosLoading"));
    cc.log("xitong : " + cc.sys.os);
    cc.view.enableRetina(!0);
    cc.view.adjustViewPort(!0);
    cc.sys.os === cc.sys.OS_IOS || cc.sys.os === cc.sys.OS_ANDROID || cc.sys.os === cc.sys.OS_BLACKBERRY || cc.sys.os === cc.sys.OS_WP8 || cc.sys.os === cc.sys.OS_BADA ? cc.view.setDesignResolutionSize(720, 1280, cc.ResolutionPolicy.FIXED_WIDTH) : (PC_FLAG = !0, cc.view.setDesignResolutionSize(720, 1280,
        cc.ResolutionPolicy.SHOW_ALL));
    cc.view.resizeWithBrowserSize(!0);
    document.getElementById("loadingImg") && document.body.removeChild(document.getElementById("loadingImg"));
    upload && checkShowAd();
    MainManager.gotoCover()
};
cc.game.run();
function checkShowAd() {
    1 == getLocalStorage("old_key_jiepinguoWS") ? showMyAds() : setLocalStorage("old_key_jiepinguoWS", 1)
}
function setLocalStorage(c, d) {
    try {
        return cc.sys.localStorage.setItem(c, d), !0
    } catch (e) {
        return !1
    }
}
function getLocalStorage(c) {
    try {
        return cc.sys.localStorage.getItem(c)
    } catch (d) {
        return !1
    }
};