var cc = cc || {};
cc._tmp = cc._tmp || {};
cc._LogInfos = {};
_p = window;
_p = Object.prototype;
delete window._p;
cc.newElement = function(b) {
	return document.createElement(b)
};
cc._addEventListener = function(b, c, d, e) {
	b.addEventListener(c, d, e)
};
cc._isNodeJs = "undefined" !== typeof require && require("fs");
cc.each = function(b, c, d) {
	if (b) {
		if (b instanceof Array) {
			for (var e = 0, f = b.length; e < f && !1 !== c.call(d, b[e], e); e++) {}
		} else {
			for (e in b) {
				if (!1 === c.call(d, b[e], e)) {
					break
				}
			}
		}
	}
};
cc.extend = function(b) {
	var c = 2 <= arguments.length ? Array.prototype.slice.call(arguments, 1) : [];
	cc.each(c, function(c) {
		for (var e in c) {
			c.hasOwnProperty(e) && (b[e] = c[e])
		}
	});
	return b
};
cc.isFunction = function(b) {
	return "function" === typeof b
};
cc.isNumber = function(b) {
	return "number" === typeof b || "[object Number]" === Object.prototype.toString.call(b)
};
cc.isString = function(b) {
	return "string" === typeof b || "[object String]" === Object.prototype.toString.call(b)
};
cc.isArray = function(b) {
	return Array.isArray(b) || "object" === typeof b && "[object Array]" === Object.prototype.toString.call(b)
};
cc.isUndefined = function(b) {
	return "undefined" === typeof b
};
cc.isObject = function(b) {
	return "object" === typeof b && "[object Object]" === Object.prototype.toString.call(b)
};
cc.isCrossOrigin = function(b) {
	if (!b) {
		return cc.log("invalid URL"), !1
	}
	var c = b.indexOf("://");
	if (-1 === c) {
		return !1
	}
	c = b.indexOf("/", c + 3);
	return (-1 === c ? b : b.substring(0, c)) !== location.origin
};
cc.AsyncPool = function(b, c, d, e, f) {
	var g = this;
	g._srcObj = b;
	g._limit = c;
	g._pool = [];
	g._iterator = d;
	g._iteratorTarget = f;
	g._onEnd = e;
	g._onEndTarget = f;
	g._results = b instanceof Array ? [] : {};
	g._isErr = !1;
	cc.each(b, function(b, c) {
		g._pool.push({
			index: c,
			value: b
		})
	});
	g.size = g._pool.length;
	g.finishedSize = 0;
	g._workingSize = 0;
	g._limit = g._limit || g.size;
	g.onIterator = function(b, c) {
		g._iterator = b;
		g._iteratorTarget = c
	};
	g.onEnd = function(b, c) {
		g._onEnd = b;
		g._onEndTarget = c
	};
	g._handleItem = function() {
		var b = this;
		if (!(0 === b._pool.length || b._workingSize >= b._limit)) {
			var c = b._pool.shift(),
				d = c.value,
				e = c.index;
			b._workingSize++;
			b._iterator.call(b._iteratorTarget, d, e, function(c) {
				if (!b._isErr) {
					if (b.finishedSize++, b._workingSize--, c) {
						b._isErr = !0, b._onEnd && b._onEnd.call(b._onEndTarget, c)
					} else {
						var d = Array.prototype.slice.call(arguments, 1);
						b._results[this.index] = d[0];
						b.finishedSize === b.size ? b._onEnd && b._onEnd.call(b._onEndTarget, null, b._results) : b._handleItem()
					}
				}
			}.bind(c), b)
		}
	};
	g.flow = function() {
		if (0 === this._pool.length) {
			this._onEnd && this._onEnd.call(this._onEndTarget, null, [])
		} else {
			for (var b = 0; b < this._limit; b++) {
				this._handleItem()
			}
		}
	}
};
cc.async = {
	series: function(b, c, d) {
		b = new cc.AsyncPool(b, 1, function(b, c, g) {
			b.call(d, g)
		}, c, d);
		b.flow();
		return b
	},
	parallel: function(b, c, d) {
		b = new cc.AsyncPool(b, 0, function(b, c, g) {
			b.call(d, g)
		}, c, d);
		b.flow();
		return b
	},
	waterfall: function(b, c, d) {
		var e = [],
			f = [null],
			g = new cc.AsyncPool(b, 1, function(c, g, m) {
				e.push(function(c) {
					e = Array.prototype.slice.call(arguments, 1);
					b.length - 1 === g && (f = f.concat(e));
					m.apply(null, arguments)
				});
				c.apply(d, e)
			}, function(b) {
				if (c) {
					if (b) {
						return c.call(d, b)
					}
					c.apply(d, f)
				}
			});
		g.flow();
		return g
	},
	map: function(b, c, d, e) {
		var f = c;
		"object" === typeof c && (d = c.cb, e = c.iteratorTarget, f = c.iterator);
		b = new cc.AsyncPool(b, 0, f, d, e);
		b.flow();
		return b
	},
	mapLimit: function(b, c, d, e, f) {
		b = new cc.AsyncPool(b, c, d, e, f);
		b.flow();
		return b
	}
};
cc.path = {
	join: function() {
		for (var b = arguments.length, c = "", d = 0; d < b; d++) {
			c = (c + ("" === c ? "" : "/") + arguments[d]).replace(/(\/|\\\\)$/, "")
		}
		return c
	},
	extname: function(b) {
		return (b = /(\.[^\.\/\?\\]*)(\?.*)?$/.exec(b)) ? b[1] : null
	},
	mainFileName: function(b) {
		if (b) {
			var c = b.lastIndexOf(".");
			if (-1 !== c) {
				return b.substring(0, c)
			}
		}
		return b
	},
	basename: function(b, c) {
		var d = b.indexOf("?");
		0 < d && (b = b.substring(0, d));
		d = /(\/|\\\\)([^(\/|\\\\)]+)$/g.exec(b.replace(/(\/|\\\\)$/, ""));
		if (!d) {
			return null
		}
		d = d[2];
		return c && b.substring(b.length - c.length).toLowerCase() === c.toLowerCase() ? d.substring(0, d.length - c.length) : d
	},
	dirname: function(b) {
		return b.replace(/((.*)(\/|\\|\\\\))?(.*?\..*$)?/, "$2")
	},
	changeExtname: function(b, c) {
		c = c || "";
		var d = b.indexOf("?"),
			e = "";
		0 < d && (e = b.substring(d), b = b.substring(0, d));
		d = b.lastIndexOf(".");
		return 0 > d ? b + c + e : b.substring(0, d) + c + e
	},
	changeBasename: function(b, c, d) {
		if (0 === c.indexOf(".")) {
			return this.changeExtname(b, c)
		}
		var e = b.indexOf("?"),
			f = "";
		d = d ? this.extname(b) : "";
		0 < e && (f = b.substring(e), b = b.substring(0, e));
		e = b.lastIndexOf("/");
		return b.substring(0, 0 >= e ? 0 : e + 1) + c + d + f
	}
};
cc.loader = {
	_jsCache: {},
	_register: {},
	_langPathCache: {},
	_aliases: {},
	resPath: "",
	audioPath: "",
	cache: {},
	getXMLHttpRequest: function() {
		return window.XMLHttpRequest ? new window.XMLHttpRequest : new ActiveXObject("MSXML2.XMLHTTP")
	},
	_getArgs4Js: function(b) {
		var c = b[0],
			d = b[1],
			e = b[2],
			f = ["", null, null];
		if (1 === b.length) {
			f[1] = c instanceof Array ? c : [c]
		} else {
			if (2 === b.length) {
				"function" === typeof d ? (f[1] = c instanceof Array ? c : [c], f[2] = d) : (f[0] = c || "", f[1] = d instanceof Array ? d : [d])
			} else {
				if (3 === b.length) {
					f[0] = c || "", f[1] = d instanceof Array ? d : [d], f[2] = e
				} else {
					throw "arguments error to load js!"
				}
			}
		}
		return f
	},
	loadJs: function(b, c, d) {
		var e = this,
			f = e._jsCache,
			g = e._getArgs4Js(arguments),
			h = g[0],
			k = g[1],
			g = g[2]; - 1 < navigator.userAgent.indexOf("Trident/5") ? e._loadJs4Dependency(h, k, 0, g) : cc.async.map(k, function(b, c, d) {
			b = cc.path.join(h, b);
			if (f[b]) {
				return d(null)
			}
			e._createScript(b, !1, d)
		}, g)
	},
	loadJsWithImg: function(b, c, d) {
		var e = this._loadJsImg(),
			f = this._getArgs4Js(arguments);
		this.loadJs(f[0], f[1], function(b) {
			if (b) {
				throw b
			}
			e.parentNode.removeChild(e);
			if (f[2]) {
				f[2]()
			}
		})
	},
	_createScript: function(b, c, d) {
		var e = document,
			f = cc.newElement("script");
		f.async = c;
		this._jsCache[b] = !0;
		cc.game.config.noCache && "string" === typeof b ? this._noCacheRex.test(b) ? f.src = b + "&_t=" + (new Date - 0) : f.src = b + "?_t=" + (new Date - 0) : f.src = b;
		cc._addEventListener(f, "load", function() {
			f.parentNode.removeChild(f);
			this.removeEventListener("load", arguments.callee, !1);
			d()
		}, !1);
		cc._addEventListener(f, "error", function() {
			f.parentNode.removeChild(f);
			d("Load " + b + " failed!")
		}, !1);
		e.body.appendChild(f)
	},
	_loadJs4Dependency: function(b, c, d, e) {
		if (d >= c.length) {
			e && e()
		} else {
			var f = this;
			f._createScript(cc.path.join(b, c[d]), !1, function(g) {
				if (g) {
					return e(g)
				}
				f._loadJs4Dependency(b, c, d + 1, e)
			})
		}
	},
	_loadJsImg: function() {
		var b = document,
			c = b.getElementById("cocos2d_loadJsImg");
		if (!c) {
			c = cc.newElement("img");
			cc._loadingImage && (c.src = cc._loadingImage);
			b = b.getElementById(cc.game.config.id);
			b.style.backgroundColor = "white";
			b.parentNode.appendChild(c);
			var d = getComputedStyle ? getComputedStyle(b) : b.currentStyle;
			d || (d = {
				width: b.width,
				height: b.height
			});
			c.style.left = b.offsetLeft + (parseFloat(d.width) - c.width) / 2 + "px";
			c.style.top = b.offsetTop + (parseFloat(d.height) - c.height) / 2 + "px";
			c.style.position = "absolute"
		}
		return c
	},
	loadTxt: function(b, c) {
		if (cc._isNodeJs) {
			require("fs").readFile(b, function(b, d) {
				b ? c(b) : c(null, d.toString())
			})
		} else {
			var d = this.getXMLHttpRequest(),
				e = "load " + b + " failed!";
			d.open("GET", b, !0);
			/msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent) ? (d.setRequestHeader("Accept-Charset", "utf-8"), d.onreadystatechange = function() {
				4 === d.readyState && (200 === d.status ? c(null, d.responseText) : c(e))
			}) : (d.overrideMimeType && d.overrideMimeType("text/plain; charset=utf-8"), d.onload = function() {
				4 === d.readyState && (200 === d.status ? c(null, d.responseText) : c(e))
			});
			d.send(null)
		}
	},
	_loadTxtSync: function(b) {
		if (cc._isNodeJs) {
			return require("fs").readFileSync(b).toString()
		}
		var c = this.getXMLHttpRequest();
		c.open("GET", b, !1);
		/msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent) ? c.setRequestHeader("Accept-Charset", "utf-8") : c.overrideMimeType && c.overrideMimeType("text/plain; charset=utf-8");
		c.send(null);
		return 4 === !c.readyState || 200 !== c.status ? null : c.responseText
	},
	loadCsb: function(b, c) {
		var d = new XMLHttpRequest;
		d.open("GET", b, !0);
		d.responseType = "arraybuffer";
		d.onload = function() {
			var e = d.response;
			e && (window.msg = e);
			4 === d.readyState && (200 === d.status ? c(null, d.response) : c("load " + b + " failed!"))
		};
		d.send(null)
	},
	loadJson: function(b, c) {
		this.loadTxt(b, function(d, e) {
			if (d) {
				c(d)
			} else {
				try {
					var f = JSON.parse(e)
				} catch (g) {
					throw "parse json [" + b + "] failed : " + g
				}
				c(null, f)
			}
		})
	},
	_checkIsImageURL: function(b) {
		return null != /(\.png)|(\.jpg)|(\.bmp)|(\.jpeg)|(\.gif)/.exec(b)
	},
	loadImg: function(b, c, d) {
		var e = {
			isCrossOrigin: !0
		};
		void 0 !== d ? e.isCrossOrigin = null === c.isCrossOrigin ? e.isCrossOrigin : c.isCrossOrigin : void 0 !== c && (d = c);
		var f = this.getRes(b);
		if (f) {
			return d && d(null, f), f
		}
		f = new Image;
		e.isCrossOrigin && "file://" !== location.origin && (f.crossOrigin = "Anonymous");
		var g = function() {
				this.removeEventListener("load", g, !1);
				this.removeEventListener("error", k, !1);
				cc.loader.cache[b] = f;
				d && d(null, f)
			},
			h = this,
			k = function() {
				this.removeEventListener("error", k, !1);
				f.crossOrigin && "anonymous" === f.crossOrigin.toLowerCase() ? (e.isCrossOrigin = !1, h.release(b), cc.loader.loadImg(b, e, d)) : "function" === typeof d && d("load image failed")
			};
		cc._addEventListener(f, "load", g);
		cc._addEventListener(f, "error", k);
		f.src = b;
		return f
	},
	_loadResIterator: function(b, c, d) {
		var e = this,
			f = null,
			g = b.type;
		g ? (g = "." + g.toLowerCase(), f = b.src ? b.src : b.name + g) : (f = b, g = cc.path.extname(f));
		if (c = e.getRes(f)) {
			return d(null, c)
		}
		c = null;
		g && (c = e._register[g.toLowerCase()]);
		if (!c) {
			return cc.error("loader for [" + g + "] not exists!"), d()
		}
		g = c.getBasePath ? c.getBasePath() : e.resPath;
		g = e.getUrl(g, f);
		cc.game.config.noCache && "string" === typeof g && (g = e._noCacheRex.test(g) ? g + ("&_t=" + (new Date - 0)) : g + ("?_t=" + (new Date - 0)));
		c.load(g, f, b, function(b, c) {
			b ? (cc.log(b), e.cache[f] = null, delete e.cache[f], d()) : (e.cache[f] = c, d(null, c))
		})
	},
	_noCacheRex: /\?/,
	getUrl: function(b, c) {
		var d = this._langPathCache,
			e = cc.path;
		if (void 0 !== b && void 0 === c) {
			c = b;
			var f = e.extname(c),
				f = f ? f.toLowerCase() : "";
			b = (f = this._register[f]) ? f.getBasePath ? f.getBasePath() : this.resPath : this.resPath
		}
		c = cc.path.join(b || "", c);
		if (c.match(/[\/(\\\\)]lang[\/(\\\\)]/i)) {
			if (d[c]) {
				return d[c]
			}
			e = e.extname(c) || "";
			c = d[c] = c.substring(0, c.length - e.length) + "_" + cc.sys.language + e
		}
		return c
	},
	load: function(b, c, d) {
		var e = this,
			f = arguments.length;
		if (0 === f) {
			throw "arguments error!"
		}
		3 === f ? "function" === typeof c && (c = "function" === typeof d ? {
			trigger: c,
			cb: d
		} : {
			cb: c,
			cbTarget: d
		}) : 2 === f ? "function" === typeof c && (c = {
			cb: c
		}) : 1 === f && (c = {});
		b instanceof Array || (b = [b]);
		f = new cc.AsyncPool(b, 0, function(b, d, f, m) {
			e._loadResIterator(b, d, function(b) {
				if (b) {
					return f(b)
				}
				var d = Array.prototype.slice.call(arguments, 1);
				c.trigger && c.trigger.call(c.triggerTarget, d[0], m.size, m.finishedSize);
				f(null, d[0])
			})
		}, c.cb, c.cbTarget);
		f.flow();
		return f
	},
	_handleAliases: function(b, c) {
		var d = this._aliases,
			e = [],
			f;
		for (f in b) {
			var g = b[f];
			d[f] = g;
			e.push(g)
		}
		this.load(e, c)
	},
	loadAliases: function(b, c) {
		var d = this,
			e = d.getRes(b);
		e ? d._handleAliases(e.filenames, c) : d.load(b, function(b, e) {
			d._handleAliases(e[0].filenames, c)
		})
	},
	register: function(b, c) {
		if (b && c) {
			if ("string" === typeof b) {
				return this._register[b.trim().toLowerCase()] = c
			}
			for (var d = 0, e = b.length; d < e; d++) {
				this._register["." + b[d].trim().toLowerCase()] = c
			}
		}
	},
	getRes: function(b) {
		return this.cache[b] || this.cache[this._aliases[b]]
	},
	release: function(b) {
		var c = this.cache,
			d = this._aliases;
		delete c[b];
		delete c[d[b]];
		delete d[b]
	},
	releaseAll: function() {
		var b = this.cache,
			c = this._aliases,
			d;
		for (d in b) {
			delete b[d]
		}
		for (d in c) {
			delete c[d]
		}
	}
};
cc.formatStr = function() {
	var b = arguments,
		c = b.length;
	if (1 > c) {
		return ""
	}
	var d = b[0],
		e = !0;
	"object" === typeof d && (e = !1);
	for (var f = 1; f < c; ++f) {
		var g = b[f];
		if (e) {
			for (;;) {
				var h = null;
				if ("number" === typeof g && (h = d.match(/(%d)|(%s)/))) {
					d = d.replace(/(%d)|(%s)/, g);
					break
				}
				d = (h = d.match(/%s/)) ? d.replace(/%s/, g) : d + ("    " + g);
				break
			}
		} else {
			d += "    " + g
		}
	}
	return d
};
(function() {
	var b = window,
		c, d;
	cc.isUndefined(document.hidden) ? cc.isUndefined(document.mozHidden) ? cc.isUndefined(document.msHidden) ? cc.isUndefined(document.webkitHidden) || (c = "webkitHidden", d = "webkitvisibilitychange") : (c = "msHidden", d = "msvisibilitychange") : (c = "mozHidden", d = "mozvisibilitychange") : (c = "hidden", d = "visibilitychange");
	var e = function() {
			cc.eventManager && cc.game._eventHide && cc.eventManager.dispatchEvent(cc.game._eventHide)
		},
		f = function() {
			cc.eventManager && cc.game._eventShow && cc.eventManager.dispatchEvent(cc.game._eventShow);
			cc.game._intervalId && (window.cancelAnimationFrame(cc.game._intervalId), cc.game._runMainLoop())
		};
	c ? cc._addEventListener(document, d, function() {
		document[c] ? e() : f()
	}, !1) : (cc._addEventListener(b, "blur", e, !1), cc._addEventListener(b, "focus", f, !1)); - 1 < navigator.userAgent.indexOf("MicroMessenger") && (b.onfocus = function() {
		f()
	});
	"onpageshow" in window && "onpagehide" in window && (cc._addEventListener(b, "pagehide", e, !1), cc._addEventListener(b, "pageshow", f, !1));
	d = b = null
})();
cc.log = cc.warn = cc.error = cc.assert = function() {};
cc.create3DContext = function(b, c) {
	for (var d = ["webgl", "experimental-webgl", "webkit-3d", "moz-webgl"], e = null, f = 0; f < d.length; ++f) {
		try {
			e = b.getContext(d[f], c)
		} catch (g) {}
		if (e) {
			break
		}
	}
	return e
};
cc._initSys = function(b, c) {
	cc._RENDER_TYPE_CANVAS = 0;
	cc._RENDER_TYPE_WEBGL = 1;
	cc.sys = {};
	var d = cc.sys;
	d.LANGUAGE_ENGLISH = "en";
	d.LANGUAGE_CHINESE = "zh";
	d.LANGUAGE_FRENCH = "fr";
	d.LANGUAGE_ITALIAN = "it";
	d.LANGUAGE_GERMAN = "de";
	d.LANGUAGE_SPANISH = "es";
	d.LANGUAGE_DUTCH = "du";
	d.LANGUAGE_RUSSIAN = "ru";
	d.LANGUAGE_KOREAN = "ko";
	d.LANGUAGE_JAPANESE = "ja";
	d.LANGUAGE_HUNGARIAN = "hu";
	d.LANGUAGE_PORTUGUESE = "pt";
	d.LANGUAGE_ARABIC = "ar";
	d.LANGUAGE_NORWEGIAN = "no";
	d.LANGUAGE_POLISH = "pl";
	d.OS_IOS = "iOS";
	d.OS_ANDROID = "Android";
	d.OS_WINDOWS = "Windows";
	d.OS_MARMALADE = "Marmalade";
	d.OS_LINUX = "Linux";
	d.OS_BADA = "Bada";
	d.OS_BLACKBERRY = "Blackberry";
	d.OS_OSX = "OS X";
	d.OS_WP8 = "WP8";
	d.OS_WINRT = "WINRT";
	d.OS_UNKNOWN = "Unknown";
	d.UNKNOWN = 0;
	d.IOS = 1;
	d.ANDROID = 2;
	d.WIN32 = 3;
	d.MARMALADE = 4;
	d.LINUX = 5;
	d.BADA = 6;
	d.BLACKBERRY = 7;
	d.MACOS = 8;
	d.NACL = 9;
	d.EMSCRIPTEN = 10;
	d.TIZEN = 11;
	d.QT5 = 12;
	d.WP8 = 13;
	d.WINRT = 14;
	d.MOBILE_BROWSER = 100;
	d.DESKTOP_BROWSER = 101;
	d.BROWSER_TYPE_WECHAT = "wechat";
	d.BROWSER_TYPE_ANDROID = "androidbrowser";
	d.BROWSER_TYPE_IE = "ie";
	d.BROWSER_TYPE_QQ = "qqbrowser";
	d.BROWSER_TYPE_MOBILE_QQ = "mqqbrowser";
	d.BROWSER_TYPE_UC = "ucbrowser";
	d.BROWSER_TYPE_360 = "360browser";
	d.BROWSER_TYPE_BAIDU_APP = "baiduboxapp";
	d.BROWSER_TYPE_BAIDU = "baidubrowser";
	d.BROWSER_TYPE_MAXTHON = "maxthon";
	d.BROWSER_TYPE_OPERA = "opera";
	d.BROWSER_TYPE_OUPENG = "oupeng";
	d.BROWSER_TYPE_MIUI = "miuibrowser";
	d.BROWSER_TYPE_FIREFOX = "firefox";
	d.BROWSER_TYPE_SAFARI = "safari";
	d.BROWSER_TYPE_CHROME = "chrome";
	d.BROWSER_TYPE_LIEBAO = "liebao";
	d.BROWSER_TYPE_QZONE = "qzone";
	d.BROWSER_TYPE_SOUGOU = "sogou";
	d.BROWSER_TYPE_UNKNOWN = "unknown";
	d.isNative = !1;
	var e = window,
		f = e.navigator,
		g = document,
		h = g.documentElement,
		k = f.userAgent.toLowerCase();
	d.isMobile = -1 !== k.indexOf("mobile") || -1 !== k.indexOf("android");
	d.platform = d.isMobile ? d.MOBILE_BROWSER : d.DESKTOP_BROWSER;
	var m = f.language,
		m = (m = m ? m : f.browserLanguage) ? m.split("-")[0] : d.LANGUAGE_ENGLISH;
	d.language = m;
	var m = d.BROWSER_TYPE_UNKNOWN,
		n = k.match(/sogou|qzone|liebao|micromessenger|qqbrowser|ucbrowser|360 aphone|360browser|baiduboxapp|baidubrowser|maxthon|trident|oupeng|opera|miuibrowser|firefox/i) || k.match(/chrome|safari/i);
	n && 0 < n.length ? (m = n[0], "micromessenger" === m ? m = d.BROWSER_TYPE_WECHAT : "safari" === m && k.match(/android.*applewebkit/) ? m = d.BROWSER_TYPE_ANDROID : "trident" === m ? m = d.BROWSER_TYPE_IE : "360 aphone" === m && (m = d.BROWSER_TYPE_360)) : k.indexOf("iphone") && k.indexOf("mobile") && (m = "safari");
	d.browserType = m;
	m = k.match(/(iPad|iPhone|iPod)/i) ? !0 : !1;
	k = k.match(/android/i) || f.platform.match(/android/i) ? !0 : !1;
	n = d.OS_UNKNOWN; - 1 !== f.appVersion.indexOf("Win") ? n = d.OS_WINDOWS : m ? n = d.OS_IOS : -1 !== f.appVersion.indexOf("Mac") ? n = d.OS_OSX : -1 !== f.appVersion.indexOf("X11") && -1 === f.appVersion.indexOf("Linux") ? n = d.OS_UNIX : k ? n = d.OS_ANDROID : -1 !== f.appVersion.indexOf("Linux") && (n = d.OS_LINUX);
	d.os = n;
	d._supportMultipleAudio = -1 < [d.BROWSER_TYPE_BAIDU, d.BROWSER_TYPE_OPERA, d.BROWSER_TYPE_FIREFOX, d.BROWSER_TYPE_CHROME, d.BROWSER_TYPE_BAIDU_APP, d.BROWSER_TYPE_SAFARI, d.BROWSER_TYPE_UC, d.BROWSER_TYPE_QQ, d.BROWSER_TYPE_MOBILE_QQ, d.BROWSER_TYPE_IE].indexOf(d.browserType);
	(function(b, d) {
		var f = d[c.renderMode] - 0;
		if (isNaN(f) || 2 < f || 0 > f) {
			f = 0
		}
		var g = [b.OS_ANDROID],
			h = [],
			k = cc.newElement("canvas");
		cc._renderType = cc._RENDER_TYPE_CANVAS;
		cc._supportRender = !1;
		var m = e.WebGLRenderingContext;
		if (2 === f || 0 === f && m && -1 === g.indexOf(b.os) && -1 === h.indexOf(b.browserType)) {
			try {
				cc.create3DContext(k, {
					stencil: !0,
					preserveDrawingBuffer: !0
				}) && (cc._renderType = cc._RENDER_TYPE_WEBGL, cc._supportRender = !0)
			} catch (n) {}
		}
		if (1 === f || 0 === f && !1 === cc._supportRender) {
			try {
				k.getContext("2d"), cc._renderType = cc._RENDER_TYPE_CANVAS, cc._supportRender = !0
			} catch (p) {}
		}
	})(d, b);
	d._canUseCanvasNewBlendModes = function() {
		var b = document.createElement("canvas");
		b.width = 1;
		b.height = 1;
		b = b.getContext("2d");
		b.fillStyle = "#000";
		b.fillRect(0, 0, 1, 1);
		b.globalCompositeOperation = "multiply";
		var c = document.createElement("canvas");
		c.width = 1;
		c.height = 1;
		var d = c.getContext("2d");
		d.fillStyle = "#fff";
		d.fillRect(0, 0, 1, 1);
		b.drawImage(c, 0, 0, 1, 1);
		return 0 === b.getImageData(0, 0, 1, 1).data[0]
	};
	d._supportCanvasNewBlendModes = d._canUseCanvasNewBlendModes();
	try {
		d._supportWebAudio = !! (e.AudioContext || e.webkitAudioContext || e.mozAudioContext)
	} catch (p) {
		d._supportWebAudio = !1
	}
	try {
		var r = d.localStorage = e.localStorage;
		r.setItem("storage", "");
		r.removeItem("storage");
		r = null
	} catch (t) {
		"SECURITY_ERR" !== t.name && "QuotaExceededError" !== t.name || cc.warn("Warning: localStorage isn't enabled. Please confirm browser cookie or privacy option"), d.localStorage = function() {}
	}
	r = d.capabilities = {
		canvas: !0
	};
	cc._renderType === cc._RENDER_TYPE_WEBGL && (r.opengl = !0);
	if (void 0 !== h.ontouchstart || void 0 !== g.ontouchstart || f.msPointerEnabled) {
		r.touches = !0
	}
	void 0 !== h.onmouseup && (r.mouse = !0);
	void 0 !== h.onkeyup && (r.keyboard = !0);
	if (e.DeviceMotionEvent || e.DeviceOrientationEvent) {
		r.accelerometer = !0
	}
	d.garbageCollect = function() {};
	d.dumpRoot = function() {};
	d.restartVM = function() {};
	d.cleanScript = function(b) {};
	d.isObjectValid = function(b) {
		return b ? !0 : !1
	};
	d.dump = function() {
		var b;
		b = "" + ("isMobile : " + this.isMobile + "\r\n");
		b += "language : " + this.language + "\r\n";
		b += "browserType : " + this.browserType + "\r\n";
		b += "capabilities : " + JSON.stringify(this.capabilities) + "\r\n";
		b += "os : " + this.os + "\r\n";
		b += "platform : " + this.platform + "\r\n";
		cc.log(b)
	};
	d.openURL = function(b) {
		window.open(b)
	}
};
cc.ORIENTATION_PORTRAIT = 0;
cc.ORIENTATION_PORTRAIT_UPSIDE_DOWN = 1;
cc.ORIENTATION_LANDSCAPE_LEFT = 2;
cc.ORIENTATION_LANDSCAPE_RIGHT = 3;
cc._drawingUtil = null;
cc._renderContext = null;
cc._canvas = null;
cc._gameDiv = null;
cc._rendererInitialized = !1;
cc._setupCalled = !1;
cc._setup = function(b, c, d) {
	if (!cc._setupCalled) {
		cc._setupCalled = !0;
		var e = window,
			f = cc.$(b) || cc.$("#" + b),
			g;
		cc.game._setAnimFrame();
		"CANVAS" === f.tagName ? (c = c || f.width, d = d || f.height, g = cc.container = cc.newElement("DIV"), b = cc._canvas = f, b.parentNode.insertBefore(g, b), b.appendTo(g), g.setAttribute("id", "Cocos2dGameContainer")) : ("DIV" !== f.tagName && cc.log("Warning: target element is not a DIV or CANVAS"), c = c || f.clientWidth, d = d || f.clientHeight, g = cc.container = f, b = cc._canvas = cc.$(cc.newElement("CANVAS")), f.appendChild(b));
		b.addClass("gameCanvas");
		b.setAttribute("width", c || 480);
		b.setAttribute("height", d || 320);
		b.setAttribute("tabindex", 99);
		b.style.outline = "none";
		f = g.style;
		f.width = (c || 480) + "px";
		f.height = (d || 320) + "px";
		f.margin = "0 auto";
		f.position = "relative";
		f.overflow = "hidden";
		g.top = "100%";
		cc._renderType === cc._RENDER_TYPE_WEBGL && (cc._renderContext = cc.webglContext = cc.create3DContext(b, {
			stencil: !0,
			preserveDrawingBuffer: !0,
			antialias: !cc.sys.isMobile,
			alpha: !1
		}));
		cc._renderContext ? (e.gl = cc._renderContext, cc._drawingUtil = new cc.DrawingPrimitiveWebGL(cc._renderContext), cc._rendererInitialized = !0, cc.textureCache._initializingRenderer(), cc.shaderCache._init()) : (cc._renderContext = new cc.CanvasContextWrapper(b.getContext("2d")), cc._drawingUtil = cc.DrawingPrimitiveCanvas ? new cc.DrawingPrimitiveCanvas(cc._renderContext) : null);
		cc._gameDiv = g;
		cc.log(cc.ENGINE_VERSION);
		cc._setContextMenuEnable(!1);
		cc.sys.isMobile && (c = cc.newElement("style"), c.type = "text/css", document.body.appendChild(c), c.textContent = "body,canvas,div{ -moz-user-select: none;-webkit-user-select: none;-ms-user-select: none;-khtml-user-select: none;-webkit-tap-highlight-color:rgba(0,0,0,0);}");
		cc.view = cc.EGLView._getInstance();
		cc.inputManager.registerSystemEvent(cc._canvas);
		cc.director = cc.Director._getInstance();
		cc.director.setOpenGLView && cc.director.setOpenGLView(cc.view);
		cc.winSize = cc.director.getWinSize();
		cc.saxParser = new cc.SAXParser;
		cc.plistParser = new cc.PlistParser
	}
};
cc._checkWebGLRenderMode = function() {
	if (cc._renderType !== cc._RENDER_TYPE_WEBGL) {
		throw "This feature supports WebGL render mode only."
	}
};
cc._isContextMenuEnable = !1;
cc._setContextMenuEnable = function(b) {
	cc._isContextMenuEnable = b;
	cc._canvas.oncontextmenu = function() {
		if (!cc._isContextMenuEnable) {
			return !1
		}
	}
};
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
	_eventHide: null,
	_eventShow: null,
	_onBeforeStartArr: [],
	CONFIG_KEY: {
		engineDir: "engineDir",
		dependencies: "dependencies",
		debugMode: "debugMode",
		showFPS: "showFPS",
		frameRate: "frameRate",
		id: "id",
		renderMode: "renderMode",
		jsList: "jsList",
		classReleaseMode: "classReleaseMode"
	},
	_prepareCalled: !1,
	_prepared: !1,
	_paused: !0,
	_intervalId: null,
	_lastTime: null,
	_frameTime: null,
	config: null,
	onStart: null,
	onStop: null,
	setFrameRate: function(b) {
		this.config[this.CONFIG_KEY.frameRate] = b;
		this._intervalId && window.cancelAnimationFrame(this._intervalId);
		this._paused = !0;
		this._setAnimFrame();
		this._runMainLoop()
	},
	_setAnimFrame: function() {
		this._lastTime = new Date;
		this._frameTime = 1000 / cc.game.config[cc.game.CONFIG_KEY.frameRate];
		cc.sys.os === cc.sys.OS_IOS && cc.sys.browserType === cc.sys.BROWSER_TYPE_WECHAT || 60 !== cc.game.config[cc.game.CONFIG_KEY.frameRate] ? (window.requestAnimFrame = this._stTime, window.cancelAnimationFrame = this._ctTime) : (window.requestAnimFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || this._stTime, window.cancelAnimationFrame = window.cancelAnimationFrame || window.cancelRequestAnimationFrame || window.msCancelRequestAnimationFrame || window.mozCancelRequestAnimationFrame || window.oCancelRequestAnimationFrame || window.webkitCancelRequestAnimationFrame || window.msCancelAnimationFrame || window.mozCancelAnimationFrame || window.webkitCancelAnimationFrame || window.oCancelAnimationFrame || this._ctTime)
	},
	_stTime: function(b) {
		var c = (new Date).getTime(),
			d = Math.max(0, cc.game._frameTime - (c - cc.game._lastTime)),
			e = window.setTimeout(function() {
				b()
			}, d);
		cc.game._lastTime = c + d;
		return e
	},
	_ctTime: function(b) {
		window.clearTimeout(b)
	},
	_runMainLoop: function() {
		var b = this,
			c, d = cc.director;
		d.setDisplayStats(b.config[b.CONFIG_KEY.showFPS]);
		c = function() {
			b._paused || (d.mainLoop(), b._intervalId && window.cancelAnimationFrame(b._intervalId), b._intervalId = window.requestAnimFrame(c))
		};
		window.requestAnimFrame(c);
		b._paused = !1
	},
	restart: function() {
		cc.director.popToSceneStackLevel(0);
		cc.audioEngine && cc.audioEngine.end();
		cc.game.onStart()
	},
	run: function(b) {
		var c = this,
			d = function() {
				b && (c.config[c.CONFIG_KEY.id] = b);
				c._prepareCalled || c.prepare(function() {
					c._prepared = !0
				});
				cc._supportRender && (c._checkPrepare = setInterval(function() {
					c._prepared && (cc._setup(c.config[c.CONFIG_KEY.id]), c._runMainLoop(), c._eventHide = c._eventHide || new cc.EventCustom(c.EVENT_HIDE), c._eventHide.setUserData(c), c._eventShow = c._eventShow || new cc.EventCustom(c.EVENT_SHOW), c._eventShow.setUserData(c), c.onStart(), clearInterval(c._checkPrepare))
				}, 10))
			};
		document.body ? d() : cc._addEventListener(window, "load", function() {
			this.removeEventListener("load", arguments.callee, !1);
			d()
		}, !1)
	},
	_initConfig: function() {
		var b = this.CONFIG_KEY,
			c = function(c) {
				c[b.engineDir] = c[b.engineDir] || "frameworks/cocos2d-html5";
				null == c[b.debugMode] && (c[b.debugMode] = 0);
				c[b.frameRate] = c[b.frameRate] || 60;
				null == c[b.renderMode] && (c[b.renderMode] = 1);
				return c
			};
		if (document.ccConfig) {
			this.config = c(document.ccConfig)
		} else {
			try {
				for (var d = document.getElementsByTagName("script"), e = 0; e < d.length; e++) {
					var f = d[e].getAttribute("cocos");
					if ("" === f || f) {
						break
					}
				}
				var g, h, k;
				if (e < d.length) {
					if (g = d[e].src) {
						k = /(.*)\//.exec(g)[0], cc.loader.resPath = k, g = cc.path.join(k, "project.json")
					}
					h = cc.loader._loadTxtSync(g)
				}
				h || (h = cc.loader._loadTxtSync("project.json"));
				var m = JSON.parse(h);
				this.config = c(m || {})
			} catch (n) {
				cc.log("Failed to read or parse project.json"), this.config = c({})
			}
		}
		cc._initSys(this.config, b)
	},
	_jsAddedCache: {},
	_getJsListOfModule: function(b, c, d) {
		var e = this._jsAddedCache;
		if (e[c]) {
			return null
		}
		d = d || "";
		var f = [],
			g = b[c];
		if (!g) {
			throw "can not find module [" + c + "]"
		}
		c = cc.path;
		for (var h = 0, k = g.length; h < k; h++) {
			var m = g[h];
			if (!e[m]) {
				var n = c.extname(m);
				n ? ".js" === n.toLowerCase() && f.push(c.join(d, m)) : (n = this._getJsListOfModule(b, m, d)) && (f = f.concat(n));
				e[m] = 1
			}
		}
		return f
	},
	prepare: function(b) {
		var c = this,
			d = c.config,
			e = c.CONFIG_KEY,
			f = d[e.engineDir],
			g = cc.loader;
		if (!cc._supportRender) {
			throw "The renderer doesn't support the renderMode " + d[e.renderMode]
		}
		c._prepareCalled = !0;
		var h = d[e.jsList] || [];
		cc.Class ? g.loadJsWithImg("", h, function(d) {
			if (d) {
				throw d
			}
			c._prepared = !0;
			b && b()
		}) : (e = cc.path.join(f, "moduleConfig.json"), g.loadJson(e, function(e, g) {
			if (e) {
				throw e
			}
			var n = d.modules || [],
				p = g.module,
				r = [];
			cc._renderType === cc._RENDER_TYPE_WEBGL ? n.splice(0, 0, "shaders") : 0 > n.indexOf("core") && n.splice(0, 0, "core");
			for (var t = 0, s = n.length; t < s; t++) {
				var v = c._getJsListOfModule(p, n[t], f);
				v && (r = r.concat(v))
			}
			r = r.concat(h);
			cc.loader.loadJsWithImg(r, function(d) {
				if (d) {
					throw d
				}
				c._prepared = !0;
				b && b()
			})
		}))
	}
};
cc.game._initConfig();
Function.prototype.bind = Function.prototype.bind ||
function(b) {
	if (!cc.isFunction(this)) {
		throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable")
	}
	var c = Array.prototype.slice.call(arguments, 1),
		d = this,
		e = function() {},
		f = function() {
			return d.apply(this instanceof e && b ? this : b, c.concat(Array.prototype.slice.call(arguments)))
		};
	e.prototype = this.prototype;
	f.prototype = new e;
	return f
};
cc._LogInfos = {
	ActionManager_addAction: "cc.ActionManager.addAction(): action must be non-null",
	ActionManager_removeAction: "cocos2d: removeAction: Target not found",
	ActionManager_removeActionByTag: "cc.ActionManager.removeActionByTag(): an invalid tag",
	ActionManager_removeActionByTag_2: "cc.ActionManager.removeActionByTag(): target must be non-null",
	ActionManager_getActionByTag: "cc.ActionManager.getActionByTag(): an invalid tag",
	ActionManager_getActionByTag_2: "cocos2d : getActionByTag(tag = %s): Action not found",
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
	Node_getRotation: "RotationX != RotationY. Don't know which one to return",
	Node_getScale: "ScaleX != ScaleY. Don't know which one to return",
	Node_addChild: "An Node can't be added as a child of itself.",
	Node_addChild_2: "child already added. It can't be added again",
	Node_addChild_3: "child must be non-null",
	Node_removeFromParentAndCleanup: "removeFromParentAndCleanup is deprecated. Use removeFromParent instead",
	Node_boundingBox: "boundingBox is deprecated. Use getBoundingBox instead",
	Node_removeChildByTag: "argument tag is an invalid tag",
	Node_removeChildByTag_2: "cocos2d: removeChildByTag(tag = %s): child not found!",
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
	inputManager_handleTouchesBegin: "The touches is more than MAX_TOUCHES, nUnusedIndex = %s",
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
	textureCache_dumpCachedTextureInfo: "cocos2d: '%s' id=%s %s x %s",
	textureCache_dumpCachedTextureInfo_2: "cocos2d: '%s' id= HTMLCanvasElement %s x %s",
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
cc._logToWebPage = function(b) {
	if (cc._canvas) {
		var c = cc._logList,
			d = document;
		if (!c) {
			var e = d.createElement("Div"),
				c = e.style;
			e.setAttribute("id", "logInfoDiv");
			cc._canvas.parentNode.appendChild(e);
			e.setAttribute("width", "200");
			e.setAttribute("height", cc._canvas.height);
			c.zIndex = "99999";
			c.position = "absolute";
			c.top = "0";
			c.left = "0";
			c = cc._logList = d.createElement("textarea");
			d = c.style;
			c.setAttribute("rows", "20");
			c.setAttribute("cols", "30");
			c.setAttribute("disabled", !0);
			e.appendChild(c);
			d.backgroundColor = "transparent";
			d.borderBottom = "1px solid #cccccc";
			d.borderRightWidth = "0px";
			d.borderLeftWidth = "0px";
			d.borderTopWidth = "0px";
			d.borderTopStyle = "none";
			d.borderRightStyle = "none";
			d.borderLeftStyle = "none";
			d.padding = "0px";
			d.margin = 0
		}
		c.value = c.value + b + "\r\n";
		c.scrollTop = c.scrollHeight
	}
};
cc._formatString = function(b) {
	if (cc.isObject(b)) {
		try {
			return JSON.stringify(b)
		} catch (c) {
			return ""
		}
	} else {
		return b
	}
};
cc._initDebugSetting = function(b) {
	var c = cc.game;
	if (b !== c.DEBUG_MODE_NONE) {
		var d;
		b > c.DEBUG_MODE_ERROR ? (d = cc._logToWebPage.bind(cc), cc.error = function() {
			d("ERROR :  " + cc.formatStr.apply(cc, arguments))
		}, cc.assert = function(b, c) {
			if (!b && c) {
				for (var g = 2; g < arguments.length; g++) {
					c = c.replace(/(%s)|(%d)/, cc._formatString(arguments[g]))
				}
				d("Assert: " + c)
			}
		}, b !== c.DEBUG_MODE_ERROR_FOR_WEB_PAGE && (cc.warn = function() {
			d("WARN :  " + cc.formatStr.apply(cc, arguments))
		}), b === c.DEBUG_MODE_INFO_FOR_WEB_PAGE && (cc.log = function() {
			d(cc.formatStr.apply(cc, arguments))
		})) : console && console.log.apply && (cc.error = function() {
			return console.error.apply(console, arguments)
		}, cc.assert = function(b, c) {
			if (!b && c) {
				for (var d = 2; d < arguments.length; d++) {
					c = c.replace(/(%s)|(%d)/, cc._formatString(arguments[d]))
				}
				throw c
			}
		}, b !== c.DEBUG_MODE_ERROR && (cc.warn = function() {
			return console.warn.apply(console, arguments)
		}), b === c.DEBUG_MODE_INFO && (cc.log = function() {
			return console.log.apply(console, arguments)
		}))
	}
};
cc._initDebugSetting(cc.game.config[cc.game.CONFIG_KEY.debugMode]);
cc.loader.loadBinary = function(b, c) {
	var d = this,
		e = this.getXMLHttpRequest(),
		f = "load " + b + " failed!";
	e.open("GET", b, !0);
	/msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent) ? (e.setRequestHeader("Accept-Charset", "x-user-defined"), e.onreadystatechange = function() {
		if (4 === e.readyState && 200 === e.status) {
			var b = cc._convertResponseBodyToText(e.responseBody);
			c(null, d._str2Uint8Array(b))
		} else {
			c(f)
		}
	}) : (e.overrideMimeType && e.overrideMimeType("text/plain; charset=x-user-defined"), e.onload = function() {
		4 === e.readyState && 200 === e.status ? c(null, d._str2Uint8Array(e.responseText)) : c(f)
	});
	e.send(null)
};
cc.loader._str2Uint8Array = function(b) {
	if (!b) {
		return null
	}
	for (var c = new Uint8Array(b.length), d = 0; d < b.length; d++) {
		c[d] = b.charCodeAt(d) & 255
	}
	return c
};
cc.loader.loadBinarySync = function(b) {
	var c = this.getXMLHttpRequest(),
		d = "load " + b + " failed!";
	c.open("GET", b, !1);
	b = null;
	if (/msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent)) {
		c.setRequestHeader("Accept-Charset", "x-user-defined");
		c.send(null);
		if (200 !== c.status) {
			return cc.log(d), null
		}(c = cc._convertResponseBodyToText(c.responseBody)) && (b = this._str2Uint8Array(c))
	} else {
		c.overrideMimeType && c.overrideMimeType("text/plain; charset=x-user-defined");
		c.send(null);
		if (200 !== c.status) {
			return cc.log(d), null
		}
		b = this._str2Uint8Array(c.responseText)
	}
	return b
};
var Uint8Array = Uint8Array || Array;
if (/msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent)) {
	var IEBinaryToArray_ByteStr_Script = '<!-- IEBinaryToArray_ByteStr -->\r\nFunction IEBinaryToArray_ByteStr(Binary)\r\n   IEBinaryToArray_ByteStr = CStr(Binary)\r\nEnd Function\r\nFunction IEBinaryToArray_ByteStr_Last(Binary)\r\n   Dim lastIndex\r\n   lastIndex = LenB(Binary)\r\n   if lastIndex mod 2 Then\r\n       IEBinaryToArray_ByteStr_Last = Chr( AscB( MidB( Binary, lastIndex, 1 ) ) )\r\n   Else\r\n       IEBinaryToArray_ByteStr_Last = ""\r\n   End If\r\nEnd Function\r\n',
		myVBScript = cc.newElement("script");
	myVBScript.type = "text/vbscript";
	myVBScript.textContent = IEBinaryToArray_ByteStr_Script;
	document.body.appendChild(myVBScript);
	cc._convertResponseBodyToText = function(b) {
		for (var c = {}, d = 0; 256 > d; d++) {
			for (var e = 0; 256 > e; e++) {
				c[String.fromCharCode(d + 256 * e)] = String.fromCharCode(d) + String.fromCharCode(e)
			}
		}
		d = IEBinaryToArray_ByteStr(b);
		b = IEBinaryToArray_ByteStr_Last(b);
		return d.replace(/[\s\S]/g, function(b) {
			return c[b]
		}) + b
	}
}
cc = cc || {};
cc._loadingImage = "data:image/gif;base64,R0lGODlhEAAQALMNAD8/P7+/vyoqKlVVVX9/fxUVFUBAQGBgYMDAwC8vL5CQkP///wAAAP///wAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFAAANACwAAAAAEAAQAAAEO5DJSau9OOvNex0IMnDIsiCkiW6g6BmKYlBFkhSUEgQKlQCARG6nEBwOgl+QApMdCIRD7YZ5RjlGpCUCACH5BAUAAA0ALAAAAgAOAA4AAAQ6kLGB0JA4M7QW0hrngRllkYyhKAYqKUGguAws0ypLS8JxCLQDgXAIDg+FRKIA6v0SAECCBpXSkstMBAAh+QQFAAANACwAAAAACgAQAAAEOJDJORAac6K1kDSKYmydpASBUl0mqmRfaGTCcQgwcxDEke+9XO2WkxQSiUIuAQAkls0n7JgsWq8RACH5BAUAAA0ALAAAAAAOAA4AAAQ6kMlplDIzTxWC0oxwHALnDQgySAdBHNWFLAvCukc215JIZihVIZEogDIJACBxnCSXTcmwGK1ar1hrBAAh+QQFAAANACwAAAAAEAAKAAAEN5DJKc4RM+tDyNFTkSQF5xmKYmQJACTVpQSBwrpJNteZSGYoFWjIGCAQA2IGsVgglBOmEyoxIiMAIfkEBQAADQAsAgAAAA4ADgAABDmQSVZSKjPPBEDSGucJxyGA1XUQxAFma/tOpDlnhqIYN6MEAUXvF+zldrMBAjHoIRYLhBMqvSmZkggAIfkEBQAADQAsBgAAAAoAEAAABDeQyUmrnSWlYhMASfeFVbZdjHAcgnUQxOHCcqWylKEohqUEAYVkgEAMfkEJYrFA6HhKJsJCNFoiACH5BAUAAA0ALAIAAgAOAA4AAAQ3kMlJq704611SKloCAEk4lln3DQgyUMJxCBKyLAh1EMRR3wiDQmHY9SQslyIQUMRmlmVTIyRaIgA7";
cc._fpsImage = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAAgCAYAAAD9qabkAAAKQ2lDQ1BJQ0MgcHJvZmlsZQAAeNqdU3dYk/cWPt/3ZQ9WQtjwsZdsgQAiI6wIyBBZohCSAGGEEBJAxYWIClYUFRGcSFXEgtUKSJ2I4qAouGdBiohai1VcOO4f3Ke1fXrv7e371/u855zn/M55zw+AERImkeaiagA5UoU8Otgfj09IxMm9gAIVSOAEIBDmy8JnBcUAAPADeXh+dLA//AGvbwACAHDVLiQSx+H/g7pQJlcAIJEA4CIS5wsBkFIAyC5UyBQAyBgAsFOzZAoAlAAAbHl8QiIAqg0A7PRJPgUA2KmT3BcA2KIcqQgAjQEAmShHJAJAuwBgVYFSLALAwgCgrEAiLgTArgGAWbYyRwKAvQUAdo5YkA9AYACAmUIszAAgOAIAQx4TzQMgTAOgMNK/4KlfcIW4SAEAwMuVzZdL0jMUuJXQGnfy8ODiIeLCbLFCYRcpEGYJ5CKcl5sjE0jnA0zODAAAGvnRwf44P5Dn5uTh5mbnbO/0xaL+a/BvIj4h8d/+vIwCBAAQTs/v2l/l5dYDcMcBsHW/a6lbANpWAGjf+V0z2wmgWgrQevmLeTj8QB6eoVDIPB0cCgsL7SViob0w44s+/zPhb+CLfvb8QB7+23rwAHGaQJmtwKOD/XFhbnauUo7nywRCMW735yP+x4V//Y4p0eI0sVwsFYrxWIm4UCJNx3m5UpFEIcmV4hLpfzLxH5b9CZN3DQCshk/ATrYHtctswH7uAQKLDljSdgBAfvMtjBoLkQAQZzQyefcAAJO/+Y9AKwEAzZek4wAAvOgYXKiUF0zGCAAARKCBKrBBBwzBFKzADpzBHbzAFwJhBkRADCTAPBBCBuSAHAqhGJZBGVTAOtgEtbADGqARmuEQtMExOA3n4BJcgetwFwZgGJ7CGLyGCQRByAgTYSE6iBFijtgizggXmY4EImFINJKApCDpiBRRIsXIcqQCqUJqkV1II/ItchQ5jVxA+pDbyCAyivyKvEcxlIGyUQPUAnVAuagfGorGoHPRdDQPXYCWomvRGrQePYC2oqfRS+h1dAB9io5jgNExDmaM2WFcjIdFYIlYGibHFmPlWDVWjzVjHVg3dhUbwJ5h7wgkAouAE+wIXoQQwmyCkJBHWExYQ6gl7CO0EroIVwmDhDHCJyKTqE+0JXoS+cR4YjqxkFhGrCbuIR4hniVeJw4TX5NIJA7JkuROCiElkDJJC0lrSNtILaRTpD7SEGmcTCbrkG3J3uQIsoCsIJeRt5APkE+S+8nD5LcUOsWI4kwJoiRSpJQSSjVlP+UEpZ8yQpmgqlHNqZ7UCKqIOp9aSW2gdlAvU4epEzR1miXNmxZDy6Qto9XQmmlnafdoL+l0ugndgx5Fl9CX0mvoB+nn6YP0dwwNhg2Dx0hiKBlrGXsZpxi3GS+ZTKYF05eZyFQw1zIbmWeYD5hvVVgq9ip8FZHKEpU6lVaVfpXnqlRVc1U/1XmqC1SrVQ+rXlZ9pkZVs1DjqQnUFqvVqR1Vu6k2rs5Sd1KPUM9RX6O+X/2C+mMNsoaFRqCGSKNUY7fGGY0hFsYyZfFYQtZyVgPrLGuYTWJbsvnsTHYF+xt2L3tMU0NzqmasZpFmneZxzQEOxrHg8DnZnErOIc4NznstAy0/LbHWaq1mrX6tN9p62r7aYu1y7Rbt69rvdXCdQJ0snfU6bTr3dQm6NrpRuoW623XP6j7TY+t56Qn1yvUO6d3RR/Vt9KP1F+rv1u/RHzcwNAg2kBlsMThj8MyQY+hrmGm40fCE4agRy2i6kcRoo9FJoye4Ju6HZ+M1eBc+ZqxvHGKsNN5l3Gs8YWJpMtukxKTF5L4pzZRrmma60bTTdMzMyCzcrNisyeyOOdWca55hvtm82/yNhaVFnMVKizaLx5balnzLBZZNlvesmFY+VnlW9VbXrEnWXOss623WV2xQG1ebDJs6m8u2qK2brcR2m23fFOIUjynSKfVTbtox7PzsCuya7AbtOfZh9iX2bfbPHcwcEh3WO3Q7fHJ0dcx2bHC866ThNMOpxKnD6VdnG2ehc53zNRemS5DLEpd2lxdTbaeKp26fesuV5RruutK10/Wjm7ub3K3ZbdTdzD3Ffav7TS6bG8ldwz3vQfTw91jicczjnaebp8LzkOcvXnZeWV77vR5Ps5wmntYwbcjbxFvgvct7YDo+PWX6zukDPsY+Ap96n4e+pr4i3z2+I37Wfpl+B/ye+zv6y/2P+L/hefIW8U4FYAHBAeUBvYEagbMDawMfBJkEpQc1BY0FuwYvDD4VQgwJDVkfcpNvwBfyG/ljM9xnLJrRFcoInRVaG/owzCZMHtYRjobPCN8Qfm+m+UzpzLYIiOBHbIi4H2kZmRf5fRQpKjKqLupRtFN0cXT3LNas5Fn7Z72O8Y+pjLk722q2cnZnrGpsUmxj7Ju4gLiquIF4h/hF8ZcSdBMkCe2J5MTYxD2J43MC52yaM5zkmlSWdGOu5dyiuRfm6c7Lnnc8WTVZkHw4hZgSl7I/5YMgQlAvGE/lp25NHRPyhJuFT0W+oo2iUbG3uEo8kuadVpX2ON07fUP6aIZPRnXGMwlPUit5kRmSuSPzTVZE1t6sz9lx2S05lJyUnKNSDWmWtCvXMLcot09mKyuTDeR55m3KG5OHyvfkI/lz89sVbIVM0aO0Uq5QDhZML6greFsYW3i4SL1IWtQz32b+6vkjC4IWfL2QsFC4sLPYuHhZ8eAiv0W7FiOLUxd3LjFdUrpkeGnw0n3LaMuylv1Q4lhSVfJqedzyjlKD0qWlQyuCVzSVqZTJy26u9Fq5YxVhlWRV72qX1VtWfyoXlV+scKyorviwRrjm4ldOX9V89Xlt2treSrfK7etI66Trbqz3Wb+vSr1qQdXQhvANrRvxjeUbX21K3nShemr1js20zcrNAzVhNe1bzLas2/KhNqP2ep1/XctW/a2rt77ZJtrWv913e/MOgx0VO97vlOy8tSt4V2u9RX31btLugt2PGmIbur/mft24R3dPxZ6Pe6V7B/ZF7+tqdG9s3K+/v7IJbVI2jR5IOnDlm4Bv2pvtmne1cFoqDsJB5cEn36Z8e+NQ6KHOw9zDzd+Zf7f1COtIeSvSOr91rC2jbaA9ob3v6IyjnR1eHUe+t/9+7zHjY3XHNY9XnqCdKD3x+eSCk+OnZKeenU4/PdSZ3Hn3TPyZa11RXb1nQ8+ePxd07ky3X/fJ897nj13wvHD0Ivdi2yW3S609rj1HfnD94UivW2/rZffL7Vc8rnT0Tes70e/Tf/pqwNVz1/jXLl2feb3vxuwbt24m3Ry4Jbr1+Hb27Rd3Cu5M3F16j3iv/L7a/eoH+g/qf7T+sWXAbeD4YMBgz8NZD+8OCYee/pT/04fh0kfMR9UjRiONj50fHxsNGr3yZM6T4aeypxPPyn5W/3nrc6vn3/3i+0vPWPzY8Av5i8+/rnmp83Lvq6mvOscjxx+8znk98ab8rc7bfe+477rfx70fmSj8QP5Q89H6Y8en0E/3Pud8/vwv94Tz+4A5JREAAAAGYktHRAD/AP8A/6C9p5MAAAAJcEhZcwAACxMAAAsTAQCanBgAAAAHdElNRQfcAgcQLxxUBNp/AAAQZ0lEQVR42u2be3QVVZbGv1N17829eRLyIKAEOiISEtPhJTJAYuyBDmhWjAEx4iAGBhxA4wABbVAMWUAeykMCM+HRTcBRWkNH2l5moS0LCCrQTkYeQWBQSCAIgYRXEpKbW/XNH5zS4noR7faPEeu31l0h4dSpvc+t/Z199jkFWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhY/H9D/MR9qfKnLj/00U71aqfJn9+HCkCR/Wk36ddsgyJ/1wF4fkDfqqm9/gPsUeTnVr6a2xlQfnxdI7zs0W7irzD17Ytb2WT7EeNv/r4ox1O3Quf2QP2pgt9utwfout4FQE8AVBSlnaRmfvAURQkg2RlAbwB9AThlW5L0GaiKojhJhgOIBqDa7XaPrusdPtr5kQwF0BVAAoBIABRCKDd5aFUhRDAAw57eAOwAhKIoupft3zoqhB1AqLwuHIBut9uFt02qqvqRDJR2dAEQJj/BAOjn56dqmma+xiaECAEQAWAggLsB6A6HQ2iaZggBhBAqgEAAnQB0kzaEmT4hAITT6VQ8Ho/HJAKKECJQtr8LwD1y/A1/vcdfEUIEyfZ9AcQbYvZ942Px88L2UwlJR0dH0EMPPbRj5syZPUeNGrXR7Xb/641xIwJ1XY9NSUlZm52dfW+XLl1w8uRJzJ8//+OGhoYJqqqe1TSt1Wsm9NN1PSIqKmr12rVrR5WUlHy1bdu2AQCumWc3IYRD1/UwVVXnFRQUTIuNjUVzczN2797dWFJSkq8oymZd15sAGAEnFEUJ1nX9nzIzM1dnZmZGh4SE4OTJk5g5c+Zf29vbp9pstrMej6fVOyhIhgAYU1hY+B+hoaGoqKg4XVlZea+XTULTNFdCQsLGiRMnPuR2u3UhBOV9eeDAAWXTpk095DUe6WsoyRE5OTlr0tLSAux2O/bs2cO5c+e+pijKUpIXSHaQVAGkvPLKK++6XK4OksJLCFlXV2cvKSlJBFAjhU+x2WwhHo9nUHp6+urMzMy7wsLCUF9fjxdffPHjxsbGiTab7WuPx9NiEutOuq4PyMjI+M+srKyYqKgoHD58GDNmzNjq8XhyVFU9b/q+LH7hBAEYu3PnTlZVVRFAGgCX6f/tAHoOHDjwa0p27txp/JO9e/f+QM7cipw9nfL3kQBKt2zZQpJ87rnn6mQmoHilw2EACs+cOUOSrK+vZ1NTE0nyo48+IoBpxswoBcMJ4Ndjx471kOTFixe5d+9ekqTH42H//v13A4jyzpAURfEH0H/OnDnthu1z5sw558MmFUCPWbNmnaMP3nrrLZoyDmP8Hl68eDFJ8siRI9/Yc+zYMQKYKdtAztrTrl27xptRXV1NAKMAOAyBBBA/Y8aMdpLs6Ojgxx9//E37+++//29yvFXppwvAwMcee8xjtDHsuXLlCqOjo//ia3wsfpkoALqFhoZuIckJEyackimm3dQmEMDUmpoakmRISMhhAHOHDx/eQJIbN24kgKEyMAHAFRMTs2XXrl1saWkhSZ0kp0+ffhrAr3wEW/S8efOukORLL72kA1gKYMPWrVtJkk899dRJAHeYrgsEsIQkjx8/TgDvAPjd448/3kaSb7zxBmUa7vC6z53BwcFbSHL9+vU6Sc6aNes8gF5ewWAH0PfVV18lSQL4DMBGIcQ6AKtcLleBFC2jXtFt8ODBe0iyoqKCAJYByC8qKmJDQwOzsrK+MAmqo1OnTveHhoa+GRkZ+XZkZOSWiIiIvzgcjk9mzpypkWRmZuZpmbYbGV4AgPnNzc1sa2sjgN0A5iQmJtaSZHl5OQHcb/K3s81mW0uSTU1NBFAFYFbfvn1Pk+Tbb79NAA8IIVzW42/hByA+Pz/fLR/2ZXIda05NI/z9/TeR5J49ewhgqlxTrtI0jY2NjQQw3zTLuWJiYjaUlJToS5Ys6fjkk080kwDEeAmADcA9GzZsIElGRUW9CyAWwLApU6Y0kOSKFSsog9QICGdERMTGsrIyZmVlEcC9AB4IDw/fTpLbtm0jgN94CUAnAJmVlZVcs2aNZ/LkyRdJcvbs2b4EwAkgZfPmzTxw4AABFAN4BkC6vFeUSewcAO5duXIlSTIhIaEawGMAxgKYAmAGgCS73e5vrKVk/yGythANYEhCQsIhkly+fDkBpKqqGmL6DgIALDKN/3yZpVWQZGVlJQE8aPI3KiMjo5okV61aRQAjAPQBMPfIkSN0u90EUCBtsPiFEwpgbn19PdetW2fM5N4zQ9ekpKQqkty0aRMBpMjiWM6JEydIkoqirJUFJ6iq6pAPVy8A6cZMehMBUACEuVyuFwG8HBwcPEIWx367ZMkSjSQXLVrUJouTRorrkAHdA8BdQogsAOsKCwtJkmPGjDkvMw2bDDo/ADEjRoz4XylyFbm5uY0mAbjLyyZ/AOOrq6tZVlbWsWDBgo69e/eyoqKCgwcPPg4gSQaoIRbp27dvN7KF+tLSUr28vJwFBQXtMpvpYRIM7+wrAkDeqVOnePbsWQIoNKfzpiXPg8uXLydJJicnNwF4f+nSpW6STEtLq5fjYwhk1wkTJtSQ5Ouvv04AqTKj+N2xY8dIkgEBAW/Ie1v8wncRegwZMmQvSfbr12+3Ua33WqPfOWbMmP0kWVpaSgCDZAqcfejQIWNZsEGKgvnh9gfQb9myZd8nAEJVVZtMkUNk8CcNHTq0liR1XWdYWNhmH1mJIme80OnTp18x1rp5eXkEsNJms92Fb7e/IgEsvHz5Mp999tkmAI/l5uZeMC0B7vEqqAYAyL106RJJsra2lpWVld+sucePH38ZQG+5NncBeOrgwYMkqbe3t/Po0aOsra011wAWyl0H7x0JJ4DE+fPnu0kyPT29DsDdUrBuyNKEEAkAdpw/f/6GeoEM8GUmfwEgPCIiopwkGxsbabPZPgOw6L777vvm4p49e26VGYjFLxUhhD+ApLKyMp44ccIoVnXybgbgzkcfffRzklyzZg0BDJYCMMmoCwQFBXkLgLGWvvcWAgBToSsKwNPTp09vMR7UuLi4rwH0lgU8c/Db5ezbeeTIkRWzZ8++aMxu+fn5BPCADBwHgP4LFy701NXVEUAJgAnPP/98kyxMNgHo53A4zH77BQQETMvPz7+Um5vbBuAlAFMSExPPmdbVL0qh8Acw8fDhw5SCchVAEYAVb775JknyhRdeaJYztHfxMwLAaqNwCGC2FArv8x0hAHKNLGPKlCme5OTk/Zs3bzb7O0wKiiG8KXl5ed8IxenTp0mSR48e1UmyW7duWywBuD2xyQcgFECgoih+8H1gyJgZV5Lkyy+/3CbTRIePtl2HDBmyw1QBHyGDdXZdXR1JUghRKkXBjOMHCoBdpr0L3nvvPZLkF198wejo6O0A4lVVDTb74HQ6AwD8Wq7Jh8rgGgDgQ13XjVR8qaxJuADMbmlpYXl5uV5UVNRWUFDgfv/993Vj/ZydnU1c37eHXML4S3viAcQqitJD2l104cIFY8lTKsXSBWBMVVWVcd9yed2A1NTUQ6Zl00CvLMMOoHdubm6zFIlWOf5+PsY/Kj09vdrU11QAwwGsv3jxIk21m2DZr10I0RXAuAcffPBgaWkpV69eTYfDcdiwUxY0w6xw+flX8L1xApjevXv3lREREaW6rofB93aPDUDQpEmTMgHgtddeqwBwEd/utZvpqK6uPgEAcXFxkA94NwB9unfvjrNnz4LklwDcf08iIqv66Zs2bXrl4YcfxooVKxAbG7uqrq5uAYA2TdOEqqpGYIi2tjbl6aeffu/YsWPv5uTk7JaC1wHg4Pnz542MwoVvTx+21dbWYvjw4WLixIl+2dnZ9lGjRgmSTE1NRUpKCkwFTGiaxtTU1OXTpk3707Bhw/6g67pDipnT4biuj7qut+Lbk3Vf1tTUXI9qu91Pjq1QFEUBgJaWFgBo8yGOQ8eNGxcAAOvXr/8QwBUfYygAKL169eoCABcuXACAWtn2hOGv0+kMNO1KiPDw8F4A4rZv3/7R1KlTR0+bNu1ht9u9r1+/fqitrQXJgwDarRC6/QjPzs4+QJIffPCB9/aQmSAA43ft2mW0e1QGoi8CAPyLsZccExNTC2BlRkbGRdOyYJCP2csBIN6UAZzCd7cBbQCijYp/dXU1ExMTz6SmptaMHj36f9LS0vYlJCRsl6mxIWSdu3fv/g5J7t+/nwC2AShMTk6+SJKff/45AWRLYbD7+fndAeDf5BJnLoCCyZMnt5JkdnZ2C4B/F0KEm1Pu+Pj4rST55ZdfEsBWAK+mpaVdMo3raDn7KwDuSEpK+m+S3LBhAwG8DuCtHTt2UBbpjgC408vvcFVV15HkuXPnjMp+p5uMf0RcXNyHJNnQ0EBVVfcCWBQXF3fG+Jv0yxABPwB5LS0tRmFxN4BlTzzxxGWSXLx4sS5F3GGFy+1Hp5SUlJq6ujoWFxdTpsZ2H+0iIyMj/0iSWVlZX5mr5jfJFroPGzasxlhTnjp1iiTZ3NxMl8tlrCd9pfa9SkpKSJI5OTmnZOageLUZZqxvfVFWVkZcPwdgNwnSCKPqb17jkmR8fPzfZMDZ5CRsFBmNI7h95s2b1yhT7/MAYmStwCx4vy0uLqa3v5qmEcCfvSr1QQAeXb16NY3Cm3HQ55133iGAp+SxZTNhKSkpfzUddkrFjYevzAQCeGjp0qXfsYckY2NjTwD4leGDLCL2HTdunNtoY+zWSHFcIHdsFCtcfuZ1vO9Eqs3m7/F47sb1k2qX/f3997W2tl7BjWfpBYDOzzzzzIVJkyZh0KBBCwEsB3AJvl9AETabLcDj8dwRFRW1ctasWb8JCgpSzp07d62wsPC/Wltb8xRFadR1/ZqPXYbgAQMGbI2Pjw/+6quv9ldVVT0r01ezuPRJSUn5Y9euXXVd11WzDaqq6kePHm3+7LPPRgO4KlNuxWazhXo8nuTk5OSXMjIyEl0uFxoaGtqKior+dPXq1VdUVT0jj7r68ieoT58+vx8yZMjdx48fP1JVVTVF9m20VW02WyfZf97YsWPjXS4X6urqWvPy8jYCWCyEuEDS8FdVFKWzruv//OSTTy5OTk7uqWkaPv3007qysrJ8RVH+LI8ym8/rB3Tu3HnRI488knLo0KG2ffv2ZQI4C98vP6mqqoZqmpaclpa2cOTIkX39/f3R0NDQUVxc/G5TU9PLqqrWa5rWLH1QVFUN0TStX1JSUvH48eP7BwYG4uDBg1cKCgpeBbBe2u+2Qug2EwD5N5sMPuNtMe8XP4TT6Qxoa2sbIGeXvUKIK7d4IISiKC5d1wPljOfA9bPwzYqiXNV13dd6Uqiq6qdpml2mpe02m63d4/G4vcTF5fF47LJf71nJA6BZVVW3pmntuPHlmAD5wk6Q9NnbHp9vHaqq6tA0zU/64PZhk1FfCZB9G/23ALiqKEqzD39tpvbGUqoFwFUhRLP3yzpCCDtJpxyXDulfG27+pqRR3DXsUWVd4Yq0x/taVQjhIhksC8L+ABpM9ljBf5sKwI8pIBr75L5E4vvu+UNeG/a+hv+AL7yFH8qPtOfHjtOP6V/Bja8D6z/B2Nys/1u9Xv33tLf4GfF/LC4GCJwByWIAAAAASUVORK5CYII=";
cc._loaderImage = "data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAAlAAD/4QMpaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjAtYzA2MCA2MS4xMzQ3NzcsIDIwMTAvMDIvMTItMTc6MzI6MDAgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjM4MDBEMDY2QTU1MjExRTFBQTAzQjEzMUNFNzMxRkQwIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjM4MDBEMDY1QTU1MjExRTFBQTAzQjEzMUNFNzMxRkQwIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzUgV2luZG93cyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkU2RTk0OEM4OERCNDExRTE5NEUyRkE3M0M3QkE1NTlEIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU2RTk0OEM5OERCNDExRTE5NEUyRkE3M0M3QkE1NTlEIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+/+4ADkFkb2JlAGTAAAAAAf/bAIQADQkJCQoJDQoKDRMMCwwTFhENDREWGhUVFhUVGhkUFhUVFhQZGR0fIB8dGScnKionJzk4ODg5QEBAQEBAQEBAQAEODAwOEA4RDw8RFA4RDhQVERISERUfFRUXFRUfKB0ZGRkZHSgjJiAgICYjLCwoKCwsNzc1NzdAQEBAQEBAQEBA/8AAEQgAyACgAwEiAAIRAQMRAf/EALAAAAEFAQEAAAAAAAAAAAAAAAQAAgMFBgcBAQEAAwEBAAAAAAAAAAAAAAAAAQMEAgUQAAIBAgIEBwoLBgQGAwAAAAECAwAEEQUhMRIGQVFxsTITFGGBwdEiQlKSMzWRoeFicqKyI1NzFYJjJDQWB9KjVCbxwkNkJWXik3QRAAIBAgMFBQcDBQEAAAAAAAABAhEDIRIEMUFRcTJhwVIUBZGhsSJyEzOB0ULhYpIjUxX/2gAMAwEAAhEDEQA/AMJSpUqAVKlXuFAeUq9wpUB5XuFe4V6ooDzZHDox0CnGMinzwl7Z8NajaHeoO3vmTBZBtp9YUIqTEV5ROxHKnWRnaU8VRMhFBUjpV7hSoSeUq9pUB5Sr2lhQHlKvcK8oBV7hSFSRrtaKAZs07YNPM1pG2xJIAw1jSeandry/8X4m8VCKkWwaWwam7Xl/4v1W8VLtmX/i/VbxUoKkWwakSM407tmX/i/VbxUmzGwjQsjdY41IARie/U0IbZO0kNtCXnOCkEBeFu4KI3Bs7DNb27ya+jDx3kJeEnpJJEcQVbWDsk17u5urd591ucZkWhym2Vnd9RkCDEpFxDRpbw0bunu5mlp2De2FMLYXOD2wB2xbOeraUcYGJ72mlSUiqzzdzMd3Z3mixltA2yzcK/NlHM1DQyRXce1HocdNOEfJXZ88y9ZojOqhiBszIRiHQ8Y4cK5TvHuzLljHNMqxNoDjLFraHHnjPxcNCGVbxEUzYNTx5jZSxhpW6qTzlwJ+DCvO2Zf+L9VvFSgqyHYNLYNTdssPxfibxUu15f8Ai/VPiqCakOwa82DU/a8v/F+JvFTDdWPBL8R8VKCvYRYV5UzoMAy6QdIIqI0B4KJtxiRQwou16QoGUkntH5Tz0RbZbmF2hktraSVBo2lUkY8tDye0flPPXTslVUyiyVRsjqUOA4yMT8dW2ram2m6UVTNq9S7EIyUVJydMTn/6DnP+im9Wl+g5z/opvVrpteEhQWY4AaSTwAVf5WPiZh/9S5/zj7zltzlmYWkfWXNvJDGTgGcYDHirR7i7mSbwXParsFMrgb7w6jKw/wCmnc9I14kF3vpvCljbMyWMOJL4aEiB8qU/ObUK7HYWVrl1pFZWiCOCBQqKOLjPGTrNZZqKbUXVHq2nNwTuJRk1VpbgXN8s7Rk5ym0UQQzhIG2NAjhxHWbI+gCBVjBBFbwxwQqEiiUJGg1BVGAFe7dV28WYLYZFmF2Th1UD7JGjymGyn1iK5OyzIBGB1HgrLZhamzumQAGJwSqnSCh1q3GOCodxt4cxurdcpzuN4cyhiWaF5Bg09udUmnWw1H/jV9nFuJ7Quo+8h8peThFA+047vduyMtk7fYqTl07YFdfUufMPzT5p71UdtlmYXaGS2t3mQHAsgxANdadYJopLe4QS2867EsZ4QfCNYrCFbjdDPmgkYyWFxgVf04ifJf6ScNdRUW1XBb6FU5TjF5EpSSrGu/s5lN+g5z/opvVpfoOc/wCim9WtdHnatvObJXDW7xLGhB8nrPaY9/HCr+tEdPCVaSeDoYLnqF63lzW4/PFSW3ecxbI84VSzWUwUaSdg0DXXK5nvAipnd6qgKvWnQO7pri9ZUEmm3Vl2j1kr8pRlFRyquBNZjGxQ/S56Y1S2fu9OVueon11Szahoou06QoQUXadIVCD2FJJ7R+U89dMydv8Axdn+TH9muZye0flPPXQstlK5Tbka1gUjlC1q0vVLkeb6r+O3Tx9xcY1nt8c0NrZCyiOE1108NYjGv1joo7Js1jzKyScYLIvkzL6LDwHXVJksH9Sb49dKNq0tj1jA6uriOCL+02FWX7iVtZX1/AzaHTyeoauKn2MX9W79zebiZCuR5MjSrhfXuEtwTrUeZH+yNfdrRNcxI6IzhXlJEak6WIGJ2Rw4ChWnChndtlVBLMdQA0k1gbXNMzzDfDLs6mjaPKppJbWwJ1bOwwxw43OnHh71YT3DpfWUJmFlb5jHHDdeXBHIsrRea5TSqvxqG04cNN62vetoCS4tre5mgnkGE9q+3DKOkuI2WX6LDQRRHWDh1UCtwj7QRg2wdl8Djgw1qe7XvW0BQ3kfZ7mSLgU+T9E6RVbnuVrnWVSWqj+Lt8ZbRuHEdKPkYVcZ2MJY5fSGyeVar45+rkWQHAqccalPE5km1htWK5nK4Wnt5FuUBUwOMG4nGkA/BXUrW4S6torlOjMgcd/xVn7rLo7zKs0uEjCNeSvdwoBhgsZxX1l2j36k3Lu+uyprdj5Vs5A+i/lD48a0aaVJOPi7jB6lbzWozpjB48pf1NDXNN4vfl7+Z4BXS65pvF78vfzPAK71XTHmZ/S/yT+jvJ7L3fHytz1E+upbL+Qj5W56jfXWRnsIYKLtekKEFGWvSFQgyjk9o/Keet3YthlMP/5x9msJJ7R+U89biyb/AMXEv7gD6tadL1T+kwepRrC39ZkLDMbiwMvUHRPG0bjlGg8ore/23sxBldxfMPLupNhT8yL/AORNZbdzJ484scytxgLqJY5LZj6Q2sV5G1Vud1mjjyG0ij0NEGSZToKyhjtqw4waztuiXA3qKTbSxltfGhbZlE95ZtZqxVbgiOZhrER9ph3Svk9+pJILZ4Y4DGBFCUMKjRsGPobPFhUfW0NJmljE2xJcIrcI2vFUEln1lRXd6lrazXT9GCNpD+yNqoI7mOVduNw6nzlOIoPOUa6yye1XXcbMR5GdQ3xY0BSbj31/FcTQZirJ+q431q7anbHCTZ72Bw7lbPrKBMcBWNNgbMBBh+bsjBdni0VJ1lARZs6yWiupxCuMDy6KpS2IwOo6DTr3Mre3e5tZZVUM4ZBjqOOJoWO4jkXajcOOMHGgDISvWIrdAkKR80+TzVl908bPPL3LzxOuHdifxVfiTAg92qI/w+/8gGgSyN/mR7XPVlp0lF/3L3mbVKtu5Hjbk/8AHE2Fc03i9+Xv5ngFdKNc13i9+Xv5ngFaNV0x5nn+l/kn9HeEWXu+PlbnqJ9dS2Xu9OVueon11kZ7CGCjLXpCgxRlr0hUIPYUcntH5Tz1s8vb+Bt1/dqPirGSe0flPPWusG/g4Py15q06XqlyMWvVYQ+ruI9xJOqzO9hOto/sP8tbGOFIrmWeM7IuMDMnAXXQJOUjQeOsJk0nY96ip0CYunrjaHx1t+srPJUbXBm2LrFPikwTOb+T+VhbZxGMrDXp83x1QSy2tucJpUjPETp+Cn5/ftaRvKvtp3Kx48HG3erHMzOxZiWZtLMdJNQSbbL71Vk6yynViOkqnEEfOWtPbXi3EQkGg6mXiNckjeSJxJGxR10qw0GtxuxmvbImD4CZMFlA4fRfv0BqesqqzTMZNMEDbIHtHH2QeCiZJSqMQdOGiue53mz3czQwsRbIcNHnkec3c4qAMuriz68gTIToxwOOnlp0MjxMJYW741Gs3RVldtbygE/dMcHX/moDaxTiWNZB53B3arb8/wC+4SOF4sf/AKxU9kcBsfOGHfoUHtG/RbzY5Die5HHhXdvavqiZ9Q8Jdlq4/gbKua7xe/L38zwCuhpf2Uk/Zo50kmwJKIdogDjw1VzzeL35e/meAVp1LTgqY4nn+mRauzqmqwrjzCLL3fHytz1E+upLL+Qj5W56jfXWRnroYKLtekKEFF2vSFQg9hSSe0flPPWosm/hIfoLzVl5PaPynnrRWb/w0X0F5q06XqlyM2sVYx5gmbFre/t71NY2T+0h8VbSO5SWNJUOKSAMp7jDGspmMPaLRlXS6eWve1/FRO7WYdbZm1Y/eW/R7qHxHRXGojlm3ulid6aVbaW+OALvgCLq2Hm9WxHKWqjhj6xsK1e8dm15l4niG1LZkswGsxtrPeOmsvayBJA1VItlWjptLuTdPMo7LtjRDq9naK4+WF9IrUW7BaHOljGqVHB7w2hzVoZt87d8vaNYSLl02CcRsDEbJbj71Uu7UBkvJ7/D7q2QoDxySaAO8MTXdxRVMpRp5XZOWdF/ms7R5XdyKfKWJsO/5PhrG5XlNxmEywW6bTnTxAAcJNbGSMXkM1pjgbiNo1PziPJ+Os7u7m/6ReM00ZOgxSpqYYHT3wRXMKN4ll9zUG4bQfNshu8sZVuEA2hirA4qe/VOwwrVbzbww5mI44UKRRYkbWG0S3JWctbd7u5WFfOOLHiUdJqmaipfLsIsObhWe001lMkMVvJNjhghIALMcBxCs7fxXQmkupx1bXDswGPlaTidVaEyKNXkoo4eBV+Sq7L7Vs9zcBgeyQ4GQ/MB1crmoim2orezqcowTuSeEY48jQ7oZX2PLzdyLhNd6RjrEY6I7+uspvH78vfzPAK6UAAAFGAGgAcArmu8Xvy9/M8ArTfio24RW5nnaG67uou3H/KPuqT2X8hHytz1G+upLL3enK3PUb66ys9RDBRdr0hQgou06QqEGUkntH5Tz1e238vF9BeaqKT2j8p56vbb+Xi+gvNWjTdUuRn1XTHmTh8KrJTJlt8t1CPIY44cGnpJVjTJYkmjaN9Ib4u7V923njTethRauZJV3PaW1rfLIiXEDYg6R4VYc9CXW7thfOZbKdbGZtLW8uPVY/u3GrkNUkM9zlcxUjbhfWOA90cRq4gv4LhdqN+VToNYWmnRm9NNVWNTyHc6VWBv8wt4YeHqm6xyPmroq1Z7WGFLSxTq7WLSuPSdjrkfumq5yHXDUeA92oO2SKpVumNAaoJLMXH3myp0rpJ4uKhc3tbDM5BMri1zAj79j7KTiY8TcdBpcsith0286o+sPCagEX9Pzg4zXUCp6QYse8oouCG3tk6m1BYv05W6T+IdyolxbHDAAa2OgDlNCz3ryN2WxBd5PJMg1t81eId2ukqnLlTBbfcuY+9uJLiRcvtPvHdsHK+cfRHcHDWsyawjyy0WBcDI3lTP6TeIcFV+S5OmXx9bJg1048o8Cj0V8Jq2DVu09nL80up7OxHi+oal3P8AXB/IsZS8T/YOV65zvCcc7vfzPAK3ivWCz445zeH954BXOr6I8yfSfyz+jvCLP3fHytz1G+upLP3fHytz1E+usbPaQ0UXadIUIKLtekKhB7Ckk9o/Keer22/l4/oLzVRSe0flPPV7b/y8X0F5q0abqlyM+q6Y8yQsBTDMor1o8aiaE1pbluMqS3sbLLHIhSRQyngqukhaJ9uBjo+H5aOa3ao2t34qouRlLajTalGP8v0IY8ylXQ+PKPFU/bYXOLPge6CKia0LaxTOxHu1Q7cuBd9yPEJ7TbjXKO8CajbMIF6CNIeNvJHjqIWJ7tSpYkalqVblwIdyG+RGXur0hXYJFxal+Dhq5y3slkv3Y2pD0pTr+QUClpJRUdo9XW4OLrTHtM16cZLLWkeC7y4jvlNEpcRtw1Ux27Ci448NZrTFy3nn3IQWxlgGrDZ3pza7/M8ArZo+ArF5171uvp+CqdV0R5l/psUrs2vB3hdl7vTlbnqJ9dS2Xu+PlbnqJ9dY2eshooq16QoQUXa9IVCD2FLJ7RuU89WNtmUSQqkgYMgw0accKrpPaPynnrZWG4Vi+VWmY5tnMWXG+XrIYnA0rhj0mdcTgdNdwnKDqjmduM1SRR/qlr8/4KX6pa8T/BVzDuLZXudRZblmbxXcPUNPc3KqCIwrbOzgrHEnHjoyD+3eSXkht7DeKG4umDGOJVUklfouThXfmbnZ7Cvy1vt9pmv1W1+d8FL9VteJvgq5yrcOGfLmzHN80iyyETPbptAEFo2ZG8pmUa1OFNn3Ky6W/sbDKM5hv5bx2WTZA+7RF2y52WOPJTzE+z2Dy1vt9pT/AKpacTerS/U7Tib1a04/t7kDXPY03jhN0W6sQ7K7W3q2dnrMccaDy/8At80kuZfqWYxWNtlcvUPPhiGYhWDeUy7IwYU8xPs9g8tb7faUn6pacTerTxm9oOBvVq3v9z927aynuId44LiWKNnjhAXF2UYhRg516qpsryjLr21665zFLSTaK9U2GOA87SwqY37knRU+BzOzags0s1Oyr+BKM6sxwP6tSDPLMen6vy0rvdm3Sxlu7K/S7WDDrFUDUTxgnTU826eXW7KlxmqQuwDBXUKcD+1Xee/wXuKX5XDGWLapSVcOyhEM/seJ/V+WnjeGx4pPV+Wkm6kKZlFay3Jlt7iFpYZY8ASVK6DjtDDA0f8A0Tl340/1f8Ndx8xJVWXB0KbktFFpNzdVXAC/qOwA0CQni2flrO3Vwbm5lnI2TKxbDirX/wBE5d+NcfV/wVR7xZPa5U9utvI8nWhmbbw0YEAYYAVxfhfy5rlKR4Fulu6X7mW1mzT8S4Yis/5CPlbnqJ9dSWfu9OVueon11mZvQ2i7XpChKKtekKhBlNJ7R+U89bDfGTb3a3ZX0Lcj6kdY+T2j8p560288m1kWQr6MJ+ylSAr+2cnV5renjs3H1loX+3j9XvbbtxLN9lqW4UnV5jdnjtXHxihtyZNjeSBu5J9k1BJe7xy7W5CJ/wCzuD/mTVTf2+fq97LJuLrPsNRueS7W6aJ/38x+vLVXuY+xvHaNxbf2GoCezf8A36j/APsSf8w1sLnqczTefJluYoLm5uo5F61sBshItP1cNFYe1f8A3ir/APfE/wCZUe9bB94r5jwuPsrQFhmG4l/Z2M17HdW90tuu3IkTHaCjWdIw0VVZdks9/C06yJFEp2dp+E1bbqybGTZ8vpQD7L1XRv8A7blT96Oda7tpNuuNE37Cq9KSisjyuUoxrStKllHbLlWTXsMs8chuSuwEPDqwoLe5y+YRE/gLzmqRekvKKtd4327yM/ulHxmrHJStySWVRyrjxKI2XC/CTlnlPPKTpTdFbP0L1bgrf5Lp0G3dPhQHwV0S1lzBsns3sESR8Crh9WAJGjSOKuU3E+zdZQ3oJh8IArdZXFDmOTpHa3i2+YrI2KtKy4ricBsBuHHgFXSo440+Wa2qqxjvM9uMoy+WvzWpLCWWWE28HxL6e43ojgkeSCBY1Ri5BGIUDT51cl3vm276BBqSEH4WbxV0tlkyXJcxTMb+OW6uY9mGHrCzDQwwAbTp2uKuTZ9N1uYsfRRR8WPhrm419mSSjRyiqxVK7y23B/ftuTm2oSdJyzNVw3BFn7vTlbnqF9dS2fu9OVueon11lZuQ2iLdsGFD05H2dNQGV0ntG5Tz1dWm9N1b2kVq8EVwsI2UaQaQOKhmitZGLOmk68DhSFvY+gfWNSAg7z3Qvo7yKCKIohiaNR5LKxx8qpxvjcqS0VpbxvwOAcRQPZ7D0G9Y0uz2HoH1jUCpLY7zXlpbm3eKO5QuzjrBqZji3x17PvNcyT288VvDBJbMWUovS2hslW7mFQ9nsPQPrGl2ew9A+saCod/WNxtbYsrfb17WBxx5ddD2281xC88klvDcSXEnWuzrqOGGC9zRUPZ7D0G9Y0uzWHoH1jQVCLreq6ntZbaO3it1mGy7RjTs1X2mYy20ZiCq8ZOODcdEdmsPQb1jS7PYegfWNdJuLqnQiSUlRqpFLmryxtH1Ma7Qw2gNNPOdSt0oI27p007s9h6B9Y0uz2HoH1jXX3Z+I4+1b8IJdX89xLHKQFMXQUahpxoiPN5P+onfU+A0/s9h6DesaXZ7D0D6xpG7OLbUtu0StW5JJx2bBsmbtiSiEk+cxoCWWSaVpZOk2vDVo0VYdnsPQb1jSNvZcCH1jSd2c+p1XAmFqEOmOPEfaH+BQd1ueo211IzrgFUYKNAAqI1WztCpUqVCRUqVKgFSpUqAVKlSoBUqVKgFSpUqAVKlSoBUqVKgFSpUqAVKlSoD/9k=";
var cc = cc || {},
	ClassManager = {
		id: 0 | 998 * Math.random(),
		instanceId: 0 | 998 * Math.random(),
		compileSuper: function(b, c, d) {
			b = b.toString();
			var e = b.indexOf("("),
				f = b.indexOf(")"),
				e = b.substring(e + 1, f),
				e = e.trim(),
				f = b.indexOf("{"),
				g = b.lastIndexOf("}");
			for (b = b.substring(f + 1, g); - 1 !== b.indexOf("this._super");) {
				var f = b.indexOf("this._super"),
					g = b.indexOf("(", f),
					h = b.indexOf(")", g),
					h = b.substring(g + 1, h),
					h = (h = h.trim()) ? "," : "";
				b = b.substring(0, f) + "ClassManager[" + d + "]." + c + ".call(this" + h + b.substring(g + 1)
			}
			return Function(e, b)
		},
		getNewID: function() {
			return this.id++
		},
		getNewInstanceId: function() {
			return this.instanceId++
		}
	};
ClassManager.compileSuper.ClassManager = ClassManager;
(function() {
	var b = /\b_super\b/,
		c = cc.game.config[cc.game.CONFIG_KEY.classReleaseMode];
	c && console.log("release Mode");
	cc.Class = function() {};
	cc.Class.extend = function(d) {
		function e() {
			this.__instanceId = ClassManager.getNewInstanceId();
			this.ctor && this.ctor.apply(this, arguments)
		}
		var f = this.prototype,
			g = Object.create(f),
			h = ClassManager.getNewID();
		ClassManager[h] = f;
		var k = {
			writable: !0,
			enumerable: !1,
			configurable: !0
		};
		g.__instanceId = null;
		e.id = h;
		k.value = h;
		Object.defineProperty(g, "__pid", k);
		e.prototype = g;
		k.value = e;
		Object.defineProperty(e.prototype, "constructor", k);
		this.__getters__ && (e.__getters__ = cc.clone(this.__getters__));
		this.__setters__ && (e.__setters__ = cc.clone(this.__setters__));
		for (var m = 0, n = arguments.length; m < n; ++m) {
			var p = arguments[m],
				r;
			for (r in p) {
				var t = "function" === typeof p[r],
					s = "function" === typeof f[r],
					v = b.test(p[r]);
				c && t && s && v ? (k.value = ClassManager.compileSuper(p[r], r, h), Object.defineProperty(g, r, k)) : t && s && v ? (k.value = function(b, c) {
					return function() {
						var d = this._super;
						this._super = f[b];
						var e = c.apply(this, arguments);
						this._super = d;
						return e
					}
				}(r, p[r]), Object.defineProperty(g, r, k)) : t ? (k.value = p[r], Object.defineProperty(g, r, k)) : g[r] = p[r];
				if (t) {
					var u, A;
					if (this.__getters__ && this.__getters__[r]) {
						var t = this.__getters__[r],
							y;
						for (y in this.__setters__) {
							if (this.__setters__[y] === t) {
								A = y;
								break
							}
						}
						cc.defineGetterSetter(g, t, p[r], p[A] ? p[A] : g[A], r, A)
					}
					if (this.__setters__ && this.__setters__[r]) {
						t = this.__setters__[r];
						for (y in this.__getters__) {
							if (this.__getters__[y] === t) {
								u = y;
								break
							}
						}
						cc.defineGetterSetter(g, t, p[u] ? p[u] : g[u], p[r], u, r)
					}
				}
			}
		}
		e.extend = cc.Class.extend;
		e.implement = function(b) {
			for (var c in b) {
				g[c] = b[c]
			}
		};
		return e
	}
})();
cc.defineGetterSetter = function(b, c, d, e, f, g) {
	if (b.__defineGetter__) {
		d && b.__defineGetter__(c, d), e && b.__defineSetter__(c, e)
	} else {
		if (Object.defineProperty) {
			var h = {
				enumerable: !1,
				configurable: !0
			};
			d && (h.get = d);
			e && (h.set = e);
			Object.defineProperty(b, c, h)
		} else {
			throw Error("browser does not support getters")
		}
	}
	if (!f && !g) {
		for (var h = null != d, k = void 0 != e, m = Object.getOwnPropertyNames(b), n = 0; n < m.length; n++) {
			var p = m[n];
			if ((b.__lookupGetter__ ? !b.__lookupGetter__(p) : !Object.getOwnPropertyDescriptor(b, p)) && "function" === typeof b[p]) {
				var r = b[p];
				if (h && r === d && (f = p, !k || g)) {
					break
				}
				if (k && r === e && (g = p, !h || f)) {
					break
				}
			}
		}
	}
	b = b.constructor;
	f && (b.__getters__ || (b.__getters__ = {}), b.__getters__[f] = c);
	g && (b.__setters__ || (b.__setters__ = {}), b.__setters__[g] = c)
};
cc.clone = function(b) {
	var c = b.constructor ? new b.constructor : {},
		d;
	for (d in b) {
		var e = b[d];
		c[d] = "object" !== typeof e || !e || e instanceof cc.Node || e instanceof HTMLElement ? e : cc.clone(e)
	}
	return c
};
cc.inject = function(b, c) {
	for (var d in b) {
		c[d] = b[d]
	}
};
cc = cc || {};
cc._tmp = cc._tmp || {};
cc.associateWithNative = function(b, c) {};
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
	"=": 187,
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
	dpadLeft: 1000,
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
cc.getImageFormatByData = function(b) {
	return 8 < b.length && 137 === b[0] && 80 === b[1] && 78 === b[2] && 71 === b[3] && 13 === b[4] && 10 === b[5] && 26 === b[6] && 10 === b[7] ? cc.FMT_PNG : 2 < b.length && (73 === b[0] && 73 === b[1] || 77 === b[0] && 77 === b[1] || 255 === b[0] && 216 === b[1]) ? cc.FMT_TIFF : cc.FMT_UNKNOWN
};
cc.inherits = function(b, c) {
	function d() {}
	d.prototype = c.prototype;
	b.superClass_ = c.prototype;
	b.prototype = new d;
	b.prototype.constructor = b
};
cc.base = function(b, c, d) {
	var e = arguments.callee.caller;
	if (e.superClass_) {
		return ret = e.superClass_.constructor.apply(b, Array.prototype.slice.call(arguments, 1))
	}
	for (var f = Array.prototype.slice.call(arguments, 2), g = !1, h = b.constructor; h; h = h.superClass_ && h.superClass_.constructor) {
		if (h.prototype[c] === e) {
			g = !0
		} else {
			if (g) {
				return h.prototype[c].apply(b, f)
			}
		}
	}
	if (b[c] === e) {
		return b.constructor.prototype[c].apply(b, f)
	}
	throw Error("cc.base called from a method of one name to a method of a different name")
};
cc.Point = function(b, c) {
	this.x = b || 0;
	this.y = c || 0
};
cc.p = function(b, c) {
	return void 0 === b ? {
		x: 0,
		y: 0
	} : void 0 === c ? {
		x: b.x,
		y: b.y
	} : {
		x: b,
		y: c
	}
};
cc.pointEqualToPoint = function(b, c) {
	return b && c && b.x === c.x && b.y === c.y
};
cc.Size = function(b, c) {
	this.width = b || 0;
	this.height = c || 0
};
cc.size = function(b, c) {
	return void 0 === b ? {
		width: 0,
		height: 0
	} : void 0 === c ? {
		width: b.width,
		height: b.height
	} : {
		width: b,
		height: c
	}
};
cc.sizeEqualToSize = function(b, c) {
	return b && c && b.width === c.width && b.height === c.height
};
cc.Rect = function(b, c, d, e) {
	this.x = b || 0;
	this.y = c || 0;
	this.width = d || 0;
	this.height = e || 0
};
cc.rect = function(b, c, d, e) {
	return void 0 === b ? {
		x: 0,
		y: 0,
		width: 0,
		height: 0
	} : void 0 === c ? {
		x: b.x,
		y: b.y,
		width: b.width,
		height: b.height
	} : {
		x: b,
		y: c,
		width: d,
		height: e
	}
};
cc.rectEqualToRect = function(b, c) {
	return b && c && b.x === c.x && b.y === c.y && b.width === c.width && b.height === c.height
};
cc._rectEqualToZero = function(b) {
	return b && 0 === b.x && 0 === b.y && 0 === b.width && 0 === b.height
};
cc.rectContainsRect = function(b, c) {
	return b && c ? !(b.x >= c.x || b.y >= c.y || b.x + b.width <= c.x + c.width || b.y + b.height <= c.y + c.height) : !1
};
cc.rectGetMaxX = function(b) {
	return b.x + b.width
};
cc.rectGetMidX = function(b) {
	return b.x + b.width / 2
};
cc.rectGetMinX = function(b) {
	return b.x
};
cc.rectGetMaxY = function(b) {
	return b.y + b.height
};
cc.rectGetMidY = function(b) {
	return b.y + b.height / 2
};
cc.rectGetMinY = function(b) {
	return b.y
};
cc.rectContainsPoint = function(b, c) {
	return c.x >= cc.rectGetMinX(b) && c.x <= cc.rectGetMaxX(b) && c.y >= cc.rectGetMinY(b) && c.y <= cc.rectGetMaxY(b)
};
cc.rectIntersectsRect = function(b, c) {
	var d = b.y + b.height,
		e = c.x + c.width,
		f = c.y + c.height;
	return !(b.x + b.width < c.x || e < b.x || d < c.y || f < b.y)
};
cc.rectOverlapsRect = function(b, c) {
	return !(b.x + b.width < c.x || c.x + c.width < b.x || b.y + b.height < c.y || c.y + c.height < b.y)
};
cc.rectUnion = function(b, c) {
	var d = cc.rect(0, 0, 0, 0);
	d.x = Math.min(b.x, c.x);
	d.y = Math.min(b.y, c.y);
	d.width = Math.max(b.x + b.width, c.x + c.width) - d.x;
	d.height = Math.max(b.y + b.height, c.y + c.height) - d.y;
	return d
};
cc.rectIntersection = function(b, c) {
	var d = cc.rect(Math.max(cc.rectGetMinX(b), cc.rectGetMinX(c)), Math.max(cc.rectGetMinY(b), cc.rectGetMinY(c)), 0, 0);
	d.width = Math.min(cc.rectGetMaxX(b), cc.rectGetMaxX(c)) - cc.rectGetMinX(d);
	d.height = Math.min(cc.rectGetMaxY(b), cc.rectGetMaxY(c)) - cc.rectGetMinY(d);
	return d
};
cc.SAXParser = cc.Class.extend({
	_parser: null,
	_isSupportDOMParser: null,
	ctor: function() {
		window.DOMParser ? (this._isSupportDOMParser = !0, this._parser = new DOMParser) : this._isSupportDOMParser = !1
	},
	parse: function(b) {
		return this._parseXML(b)
	},
	_parseXML: function(b) {
		var c;
		this._isSupportDOMParser ? c = this._parser.parseFromString(b, "text/xml") : (c = new ActiveXObject("Microsoft.XMLDOM"), c.async = "false", c.loadXML(b));
		return c
	}
});
cc.PlistParser = cc.SAXParser.extend({
	parse: function(b) {
		b = this._parseXML(b).documentElement;
		if ("plist" !== b.tagName) {
			throw "Not a plist file!"
		}
		for (var c = null, d = 0, e = b.childNodes.length; d < e && (c = b.childNodes[d], 1 !== c.nodeType); d++) {}
		return this._parseNode(c)
	},
	_parseNode: function(b) {
		var c = null,
			d = b.tagName;
		if ("dict" === d) {
			c = this._parseDict(b)
		} else {
			if ("array" === d) {
				c = this._parseArray(b)
			} else {
				if ("string" === d) {
					if (1 === b.childNodes.length) {
						c = b.firstChild.nodeValue
					} else {
						for (c = "", d = 0; d < b.childNodes.length; d++) {
							c += b.childNodes[d].nodeValue
						}
					}
				} else {
					"false" === d ? c = !1 : "true" === d ? c = !0 : "real" === d ? c = parseFloat(b.firstChild.nodeValue) : "integer" === d && (c = parseInt(b.firstChild.nodeValue, 10))
				}
			}
		}
		return c
	},
	_parseArray: function(b) {
		for (var c = [], d = 0, e = b.childNodes.length; d < e; d++) {
			var f = b.childNodes[d];
			1 === f.nodeType && c.push(this._parseNode(f))
		}
		return c
	},
	_parseDict: function(b) {
		for (var c = {}, d = null, e = 0, f = b.childNodes.length; e < f; e++) {
			var g = b.childNodes[e];
			1 === g.nodeType && ("key" === g.tagName ? d = g.firstChild.nodeValue : c[d] = this._parseNode(g))
		}
		return c
	}
});
cc._txtLoader = {
	load: function(b, c, d, e) {
		cc.loader.loadTxt(b, e)
	}
};
cc.loader.register(["txt", "xml", "vsh", "fsh", "atlas"], cc._txtLoader);
cc._jsonLoader = {
	load: function(b, c, d, e) {
		cc.loader.loadJson(b, e)
	}
};
cc.loader.register(["json", "ExportJson"], cc._jsonLoader);
cc._jsLoader = {
	load: function(b, c, d, e) {
		cc.loader.loadJs(b, e)
	}
};
cc.loader.register(["js"], cc._jsLoader);
cc._imgLoader = {
	load: function(b, c, d, e) {
		cc.loader.cache[c] = cc.loader.loadImg(b, function(b, d) {
			if (b) {
				return e(b)
			}
			cc.textureCache.handleLoadedTexture(c);
			e(null, d)
		})
	}
};
cc.loader.register("png jpg bmp jpeg gif ico".split(" "), cc._imgLoader);
cc._serverImgLoader = {
	load: function(b, c, d, e) {
		cc.loader.cache[c] = cc.loader.loadImg(d.src, function(b, d) {
			if (b) {
				return e(b)
			}
			cc.textureCache.handleLoadedTexture(c);
			e(null, d)
		})
	}
};
cc.loader.register(["serverImg"], cc._serverImgLoader);
cc._plistLoader = {
	load: function(b, c, d, e) {
		cc.loader.loadTxt(b, function(b, c) {
			if (b) {
				return e(b)
			}
			e(null, cc.plistParser.parse(c))
		})
	}
};
cc.loader.register(["plist"], cc._plistLoader);
cc._fontLoader = {
	TYPE: {
		".eot": "embedded-opentype",
		".ttf": "truetype",
		".woff": "woff",
		".svg": "svg"
	},
	_loadFont: function(b, c, d) {
		var e = document,
			f = cc.path,
			g = this.TYPE,
			h = cc.newElement("style");
		h.type = "text/css";
		e.body.appendChild(h);
		var k = "@font-face { font-family:" + b + "; src:";
		if (c instanceof Array) {
			for (var m = 0, n = c.length; m < n; m++) {
				d = f.extname(c[m]).toLowerCase(), k += "url('" + c[m] + "') format('" + g[d] + "')", k += m === n - 1 ? ";" : ","
			}
		} else {
			k += "url('" + c + "') format('" + g[d] + "');"
		}
		h.textContent += k + "};";
		c = cc.newElement("div");
		d = c.style;
		d.fontFamily = b;
		c.innerHTML = ".";
		d.position = "absolute";
		d.left = "-100px";
		d.top = "-100px";
		e.body.appendChild(c)
	},
	load: function(b, c, d, e) {
		c = d.type;
		b = d.name;
		c = d.srcs;
		cc.isString(d) ? (c = cc.path.extname(d), b = cc.path.basename(d, c), this._loadFont(b, d, c)) : this._loadFont(b, c);
		e(null, !0)
	}
};
cc.loader.register(["font", "eot", "ttf", "woff", "svg"], cc._fontLoader);
cc._binaryLoader = {
	load: function(b, c, d, e) {
		cc.loader.loadBinary(b, e)
	}
};
cc._csbLoader = {
	load: function(b, c, d, e) {
		cc.loader.loadCsb(b, e)
	}
};
cc.loader.register(["csb"], cc._csbLoader);
window.CocosEngine = cc.ENGINE_VERSION = "Cocos2d-JS v3.6";
cc.FIX_ARTIFACTS_BY_STRECHING_TEXEL = 0;
cc.DIRECTOR_STATS_POSITION = cc.p(0, 0);
cc.DIRECTOR_FPS_INTERVAL = 0.5;
cc.COCOSNODE_RENDER_SUBPIXEL = 1;
cc.SPRITEBATCHNODE_RENDER_SUBPIXEL = 1;
cc.OPTIMIZE_BLEND_FUNC_FOR_PREMULTIPLIED_ALPHA = 0;
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
cc.$ = function(b) {
	var c = this === cc ? document : this;
	if (b = b instanceof HTMLElement ? b : c.querySelector(b)) {
		b.find = b.find || cc.$, b.hasClass = b.hasClass ||
		function(b) {
			return this.className.match(RegExp("(\\s|^)" + b + "(\\s|$)"))
		}, b.addClass = b.addClass ||
		function(b) {
			this.hasClass(b) || (this.className && (this.className += " "), this.className += b);
			return this
		}, b.removeClass = b.removeClass ||
		function(b) {
			this.hasClass(b) && (this.className = this.className.replace(b, ""));
			return this
		}, b.remove = b.remove ||
		function() {
			this.parentNode && this.parentNode.removeChild(this);
			return this
		}, b.appendTo = b.appendTo ||
		function(b) {
			b.appendChild(this);
			return this
		}, b.prependTo = b.prependTo ||
		function(b) {
			b.childNodes[0] ? b.insertBefore(this, b.childNodes[0]) : b.appendChild(this);
			return this
		}, b.transforms = b.transforms ||
		function() {
			this.style[cc.$.trans] = cc.$.translate(this.position) + cc.$.rotate(this.rotation) + cc.$.scale(this.scale) + cc.$.skew(this.skew);
			return this
		}, b.position = b.position || {
			x: 0,
			y: 0
		}, b.rotation = b.rotation || 0, b.scale = b.scale || {
			x: 1,
			y: 1
		}, b.skew = b.skew || {
			x: 0,
			y: 0
		}, b.translates = function(b, c) {
			this.position.x = b;
			this.position.y = c;
			this.transforms();
			return this
		}, b.rotate = function(b) {
			this.rotation = b;
			this.transforms();
			return this
		}, b.resize = function(b, c) {
			this.scale.x = b;
			this.scale.y = c;
			this.transforms();
			return this
		}, b.setSkew = function(b, c) {
			this.skew.x = b;
			this.skew.y = c;
			this.transforms();
			return this
		}
	}
	return b
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
cc.$.translate = cc.$.hd ?
function(b) {
	return "translate3d(" + b.x + "px, " + b.y + "px, 0) "
} : function(b) {
	return "translate(" + b.x + "px, " + b.y + "px) "
};
cc.$.rotate = cc.$.hd ?
function(b) {
	return "rotateZ(" + b + "deg) "
} : function(b) {
	return "rotate(" + b + "deg) "
};
cc.$.scale = function(b) {
	return "scale(" + b.x + ", " + b.y + ") "
};
cc.$.skew = function(b) {
	return "skewX(" + -b.x + "deg) skewY(" + b.y + "deg)"
};
cc.$new = function(b) {
	return cc.$(document.createElement(b))
};
cc.$.findpos = function(b) {
	var c = 0,
		d = 0;
	do {
		c += b.offsetLeft, d += b.offsetTop
	} while (b = b.offsetParent);
	return {
		x: c,
		y: d
	}
};
cc.INVALID_INDEX = -1;
cc.PI = Math.PI;
cc.FLT_MAX = parseFloat("3.402823466e+38F");
cc.FLT_MIN = parseFloat("1.175494351e-38F");
cc.RAD = cc.PI / 180;
cc.DEG = 180 / cc.PI;
cc.UINT_MAX = 4294967295;
cc.swap = function(b, c, d) {
	if (!cc.isObject(d) || cc.isUndefined(d.x) || cc.isUndefined(d.y)) {
		cc.log(cc._LogInfos.swap)
	} else {
		var e = d[b];
		d[b] = d[c];
		d[c] = e
	}
};
cc.lerp = function(b, c, d) {
	return b + (c - b) * d
};
cc.rand = function() {
	return 16777215 * Math.random()
};
cc.randomMinus1To1 = function() {
	return 2 * (Math.random() - 0.5)
};
cc.random0To1 = Math.random;
cc.degreesToRadians = function(b) {
	return b * cc.RAD
};
cc.radiansToDegrees = function(b) {
	return b * cc.DEG
};
cc.radiansToDegress = function(b) {
	cc.log(cc._LogInfos.radiansToDegress);
	return b * cc.DEG
};
cc.REPEAT_FOREVER = Number.MAX_VALUE - 1;
cc.BLEND_SRC = cc.OPTIMIZE_BLEND_FUNC_FOR_PREMULTIPLIED_ALPHA ? 1 : 770;
cc.BLEND_DST = 771;
cc.nodeDrawSetup = function(b) {
	b._shaderProgram && (b._shaderProgram.use(), b._shaderProgram.setUniformForModelViewAndProjectionMatrixWithMat4())
};
cc.enableDefaultGLStates = function() {};
cc.disableDefaultGLStates = function() {};
cc.incrementGLDraws = function(b) {
	cc.g_NumberOfDraws += b
};
cc.FLT_EPSILON = 1.192092896e-7;
cc.contentScaleFactor = cc.IS_RETINA_DISPLAY_SUPPORTED ?
function() {
	return cc.director.getContentScaleFactor()
} : function() {
	return 1
};
cc.pointPointsToPixels = function(b) {
	var c = cc.contentScaleFactor();
	return cc.p(b.x * c, b.y * c)
};
cc.pointPixelsToPoints = function(b) {
	var c = cc.contentScaleFactor();
	return cc.p(b.x / c, b.y / c)
};
cc._pointPixelsToPointsOut = function(b, c) {
	var d = cc.contentScaleFactor();
	c.x = b.x / d;
	c.y = b.y / d
};
cc.sizePointsToPixels = function(b) {
	var c = cc.contentScaleFactor();
	return cc.size(b.width * c, b.height * c)
};
cc.sizePixelsToPoints = function(b) {
	var c = cc.contentScaleFactor();
	return cc.size(b.width / c, b.height / c)
};
cc._sizePixelsToPointsOut = function(b, c) {
	var d = cc.contentScaleFactor();
	c.width = b.width / d;
	c.height = b.height / d
};
cc.rectPixelsToPoints = cc.IS_RETINA_DISPLAY_SUPPORTED ?
function(b) {
	var c = cc.contentScaleFactor();
	return cc.rect(b.x / c, b.y / c, b.width / c, b.height / c)
} : function(b) {
	return b
};
cc.rectPointsToPixels = cc.IS_RETINA_DISPLAY_SUPPORTED ?
function(b) {
	var c = cc.contentScaleFactor();
	return cc.rect(b.x * c, b.y * c, b.width * c, b.height * c)
} : function(b) {
	return b
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
cc.checkGLErrorDebug = function() {
	if (cc.renderMode === cc._RENDER_TYPE_WEBGL) {
		var b = cc._renderContext.getError();
		b && cc.log(cc._LogInfos.checkGLErrorDebug, b)
	}
};
cc.DEVICE_ORIENTATION_PORTRAIT = 0;
cc.DEVICE_ORIENTATION_LANDSCAPE_LEFT = 1;
cc.DEVICE_ORIENTATION_PORTRAIT_UPSIDE_DOWN = 2;
cc.DEVICE_ORIENTATION_LANDSCAPE_RIGHT = 3;
cc.DEVICE_MAX_ORIENTATIONS = 2;
cc.VERTEX_ATTRIB_FLAG_NONE = 0;
cc.VERTEX_ATTRIB_FLAG_POSITION = 1;
cc.VERTEX_ATTRIB_FLAG_COLOR = 2;
cc.VERTEX_ATTRIB_FLAG_TEX_COORDS = 4;
cc.VERTEX_ATTRIB_FLAG_POS_COLOR_TEX = cc.VERTEX_ATTRIB_FLAG_POSITION | cc.VERTEX_ATTRIB_FLAG_COLOR | cc.VERTEX_ATTRIB_FLAG_TEX_COORDS;
cc.GL_ALL = 0;
cc.VERTEX_ATTRIB_POSITION = 0;
cc.VERTEX_ATTRIB_COLOR = 1;
cc.VERTEX_ATTRIB_TEX_COORDS = 2;
cc.VERTEX_ATTRIB_MAX = 3;
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
cc.SHADER_POSITION_TEXTURECOLORALPHATEST = "ShaderPositionTextureColorAlphaTest";
cc.SHADER_POSITION_COLOR = "ShaderPositionColor";
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
cc.ITEM_SIZE = 32;
cc.CURRENT_ITEM = 3233828865;
cc.ZOOM_ACTION_TAG = 3233828866;
cc.NORMAL_TAG = 8801;
cc.SELECTED_TAG = 8802;
cc.DISABLE_TAG = 8803;
cc.arrayVerifyType = function(b, c) {
	if (b && 0 < b.length) {
		for (var d = 0; d < b.length; d++) {
			if (!(b[d] instanceof c)) {
				return cc.log("element type is wrong!"), !1
			}
		}
	}
	return !0
};
cc.arrayRemoveObject = function(b, c) {
	for (var d = 0, e = b.length; d < e; d++) {
		if (b[d] === c) {
			b.splice(d, 1);
			break
		}
	}
};
cc.arrayRemoveArray = function(b, c) {
	for (var d = 0, e = c.length; d < e; d++) {
		cc.arrayRemoveObject(b, c[d])
	}
};
cc.arrayAppendObjectsToIndex = function(b, c, d) {
	b.splice.apply(b, [d, 0].concat(c));
	return b
};
cc.copyArray = function(b) {
	var c, d = b.length,
		e = Array(d);
	for (c = 0; c < d; c += 1) {
		e[c] = b[c]
	}
	return e
};
cc = cc || {};
cc._tmp = cc._tmp || {};
cc._tmp.WebGLColor = function() {
	cc.color = function(b, d, e, f, g, h) {
		return void 0 === b ? new cc.Color(0, 0, 0, 255, g, h) : cc.isString(b) ? (b = cc.hexToColor(b), new cc.Color(b.r, b.g, b.b, b.a)) : cc.isObject(b) ? new cc.Color(b.r, b.g, b.b, b.a, b.arrayBuffer, b.offset) : new cc.Color(b, d, e, f, g, h)
	};
	cc.Color = function(b, d, e, f, g, h) {
		this._arrayBuffer = g || new ArrayBuffer(cc.Color.BYTES_PER_ELEMENT);
		this._offset = h || 0;
		g = this._arrayBuffer;
		h = this._offset;
		var k = Uint8Array.BYTES_PER_ELEMENT;
		this._rU8 = new Uint8Array(g, h, 1);
		this._gU8 = new Uint8Array(g, h + k, 1);
		this._bU8 = new Uint8Array(g, h + 2 * k, 1);
		this._aU8 = new Uint8Array(g, h + 3 * k, 1);
		this._rU8[0] = b || 0;
		this._gU8[0] = d || 0;
		this._bU8[0] = e || 0;
		this._aU8[0] = null == f ? 255 : f;
		void 0 === f && (this.a_undefined = !0)
	};
	cc.Color.BYTES_PER_ELEMENT = 4;
	var b = cc.Color.prototype;
	b._getR = function() {
		return this._rU8[0]
	};
	b._setR = function(b) {
		this._rU8[0] = 0 > b ? 0 : b
	};
	b._getG = function() {
		return this._gU8[0]
	};
	b._setG = function(b) {
		this._gU8[0] = 0 > b ? 0 : b
	};
	b._getB = function() {
		return this._bU8[0]
	};
	b._setB = function(b) {
		this._bU8[0] = 0 > b ? 0 : b
	};
	b._getA = function() {
		return this._aU8[0]
	};
	b._setA = function(b) {
		this._aU8[0] = 0 > b ? 0 : b
	};
	cc.defineGetterSetter(b, "r", b._getR, b._setR);
	cc.defineGetterSetter(b, "g", b._getG, b._setG);
	cc.defineGetterSetter(b, "b", b._getB, b._setB);
	cc.defineGetterSetter(b, "a", b._getA, b._setA);
	cc.Vertex2F = function(b, d, e, f) {
		this._arrayBuffer = e || new ArrayBuffer(cc.Vertex2F.BYTES_PER_ELEMENT);
		this._offset = f || 0;
		this._xF32 = new Float32Array(this._arrayBuffer, this._offset, 1);
		this._yF32 = new Float32Array(this._arrayBuffer, this._offset + 4, 1);
		this._xF32[0] = b || 0;
		this._yF32[0] = d || 0
	};
	cc.Vertex2F.BYTES_PER_ELEMENT = 8;
	b = cc.Vertex2F.prototype;
	b._getX = function() {
		return this._xF32[0]
	};
	b._setX = function(b) {
		this._xF32[0] = b
	};
	b._getY = function() {
		return this._yF32[0]
	};
	b._setY = function(b) {
		this._yF32[0] = b
	};
	cc.defineGetterSetter(b, "x", b._getX, b._setX);
	cc.defineGetterSetter(b, "y", b._getY, b._setY);
	cc.Vertex3F = function(b, d, e, f, g) {
		this._arrayBuffer = f || new ArrayBuffer(cc.Vertex3F.BYTES_PER_ELEMENT);
		this._offset = g || 0;
		f = this._arrayBuffer;
		g = this._offset;
		this._xF32 = new Float32Array(f, g, 1);
		this._xF32[0] = b || 0;
		this._yF32 = new Float32Array(f, g + Float32Array.BYTES_PER_ELEMENT, 1);
		this._yF32[0] = d || 0;
		this._zF32 = new Float32Array(f, g + 2 * Float32Array.BYTES_PER_ELEMENT, 1);
		this._zF32[0] = e || 0
	};
	cc.Vertex3F.BYTES_PER_ELEMENT = 12;
	b = cc.Vertex3F.prototype;
	b._getX = function() {
		return this._xF32[0]
	};
	b._setX = function(b) {
		this._xF32[0] = b
	};
	b._getY = function() {
		return this._yF32[0]
	};
	b._setY = function(b) {
		this._yF32[0] = b
	};
	b._getZ = function() {
		return this._zF32[0]
	};
	b._setZ = function(b) {
		this._zF32[0] = b
	};
	cc.defineGetterSetter(b, "x", b._getX, b._setX);
	cc.defineGetterSetter(b, "y", b._getY, b._setY);
	cc.defineGetterSetter(b, "z", b._getZ, b._setZ);
	cc.Tex2F = function(b, d, e, f) {
		this._arrayBuffer = e || new ArrayBuffer(cc.Tex2F.BYTES_PER_ELEMENT);
		this._offset = f || 0;
		this._uF32 = new Float32Array(this._arrayBuffer, this._offset, 1);
		this._vF32 = new Float32Array(this._arrayBuffer, this._offset + 4, 1);
		this._uF32[0] = b || 0;
		this._vF32[0] = d || 0
	};
	cc.Tex2F.BYTES_PER_ELEMENT = 8;
	b = cc.Tex2F.prototype;
	b._getU = function() {
		return this._uF32[0]
	};
	b._setU = function(b) {
		this._uF32[0] = b
	};
	b._getV = function() {
		return this._vF32[0]
	};
	b._setV = function(b) {
		this._vF32[0] = b
	};
	cc.defineGetterSetter(b, "u", b._getU, b._setU);
	cc.defineGetterSetter(b, "v", b._getV, b._setV);
	cc.Quad2 = function(b, d, e, f, g, h) {
		this._arrayBuffer = g || new ArrayBuffer(cc.Quad2.BYTES_PER_ELEMENT);
		this._offset = h || 0;
		g = this._arrayBuffer;
		h = cc.Vertex2F.BYTES_PER_ELEMENT;
		this._tl = b ? new cc.Vertex2F(b.x, b.y, g, 0) : new cc.Vertex2F(0, 0, g, 0);
		this._tr = d ? new cc.Vertex2F(d.x, d.y, g, h) : new cc.Vertex2F(0, 0, g, h);
		this._bl = e ? new cc.Vertex2F(e.x, e.y, g, 2 * h) : new cc.Vertex2F(0, 0, g, 2 * h);
		this._br = f ? new cc.Vertex2F(f.x, f.y, g, 3 * h) : new cc.Vertex2F(0, 0, g, 3 * h)
	};
	cc.Quad2.BYTES_PER_ELEMENT = 32;
	b = cc.Quad2.prototype;
	b._getTL = function() {
		return this._tl
	};
	b._setTL = function(b) {
		this._tl.x = b.x;
		this._tl.y = b.y
	};
	b._getTR = function() {
		return this._tr
	};
	b._setTR = function(b) {
		this._tr.x = b.x;
		this._tr.y = b.y
	};
	b._getBL = function() {
		return this._bl
	};
	b._setBL = function(b) {
		this._bl.x = b.x;
		this._bl.y = b.y
	};
	b._getBR = function() {
		return this._br
	};
	b._setBR = function(b) {
		this._br.x = b.x;
		this._br.y = b.y
	};
	cc.defineGetterSetter(b, "tl", b._getTL, b._setTL);
	cc.defineGetterSetter(b, "tr", b._getTR, b._setTR);
	cc.defineGetterSetter(b, "bl", b._getBL, b._setBL);
	cc.defineGetterSetter(b, "br", b._getBR, b._setBR);
	cc.Quad3 = function(b, d, e, f) {
		this.bl = b || new cc.Vertex3F(0, 0, 0);
		this.br = d || new cc.Vertex3F(0, 0, 0);
		this.tl = e || new cc.Vertex3F(0, 0, 0);
		this.tr = f || new cc.Vertex3F(0, 0, 0)
	};
	cc.V3F_C4B_T2F = function(b, d, e, f, g) {
		this._arrayBuffer = f || new ArrayBuffer(cc.V3F_C4B_T2F.BYTES_PER_ELEMENT);
		this._offset = g || 0;
		f = this._arrayBuffer;
		g = this._offset;
		var h = cc.Vertex3F.BYTES_PER_ELEMENT;
		this._vertices = b ? new cc.Vertex3F(b.x, b.y, b.z, f, g) : new cc.Vertex3F(0, 0, 0, f, g);
		this._colors = d ? cc.color(d.r, d.g, d.b, d.a, f, g + h) : cc.color(0, 0, 0, 0, f, g + h);
		this._texCoords = e ? new cc.Tex2F(e.u, e.v, f, g + h + cc.Color.BYTES_PER_ELEMENT) : new cc.Tex2F(0, 0, f, g + h + cc.Color.BYTES_PER_ELEMENT)
	};
	cc.V3F_C4B_T2F.BYTES_PER_ELEMENT = 24;
	b = cc.V3F_C4B_T2F.prototype;
	b._getVertices = function() {
		return this._vertices
	};
	b._setVertices = function(b) {
		var d = this._vertices;
		d.x = b.x;
		d.y = b.y;
		d.z = b.z
	};
	b._getColor = function() {
		return this._colors
	};
	b._setColor = function(b) {
		var d = this._colors;
		d.r = b.r;
		d.g = b.g;
		d.b = b.b;
		d.a = b.a
	};
	b._getTexCoords = function() {
		return this._texCoords
	};
	b._setTexCoords = function(b) {
		this._texCoords.u = b.u;
		this._texCoords.v = b.v
	};
	cc.defineGetterSetter(b, "vertices", b._getVertices, b._setVertices);
	cc.defineGetterSetter(b, "colors", b._getColor, b._setColor);
	cc.defineGetterSetter(b, "texCoords", b._getTexCoords, b._setTexCoords);
	cc.V3F_C4B_T2F_Quad = function(b, d, e, f, g, h) {
		this._arrayBuffer = g || new ArrayBuffer(cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT);
		this._offset = h || 0;
		g = this._arrayBuffer;
		h = this._offset;
		var k = cc.V3F_C4B_T2F.BYTES_PER_ELEMENT;
		this._tl = b ? new cc.V3F_C4B_T2F(b.vertices, b.colors, b.texCoords, g, h) : new cc.V3F_C4B_T2F(null, null, null, g, h);
		this._bl = d ? new cc.V3F_C4B_T2F(d.vertices, d.colors, d.texCoords, g, h + k) : new cc.V3F_C4B_T2F(null, null, null, g, h + k);
		this._tr = e ? new cc.V3F_C4B_T2F(e.vertices, e.colors, e.texCoords, g, h + 2 * k) : new cc.V3F_C4B_T2F(null, null, null, g, h + 2 * k);
		this._br = f ? new cc.V3F_C4B_T2F(f.vertices, f.colors, f.texCoords, g, h + 3 * k) : new cc.V3F_C4B_T2F(null, null, null, g, h + 3 * k)
	};
	cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT = 96;
	b = cc.V3F_C4B_T2F_Quad.prototype;
	b._getTL = function() {
		return this._tl
	};
	b._setTL = function(b) {
		var d = this._tl;
		d.vertices = b.vertices;
		d.colors = b.colors;
		d.texCoords = b.texCoords
	};
	b._getBL = function() {
		return this._bl
	};
	b._setBL = function(b) {
		var d = this._bl;
		d.vertices = b.vertices;
		d.colors = b.colors;
		d.texCoords = b.texCoords
	};
	b._getTR = function() {
		return this._tr
	};
	b._setTR = function(b) {
		var d = this._tr;
		d.vertices = b.vertices;
		d.colors = b.colors;
		d.texCoords = b.texCoords
	};
	b._getBR = function() {
		return this._br
	};
	b._setBR = function(b) {
		var d = this._br;
		d.vertices = b.vertices;
		d.colors = b.colors;
		d.texCoords = b.texCoords
	};
	b._getArrayBuffer = function() {
		return this._arrayBuffer
	};
	cc.defineGetterSetter(b, "tl", b._getTL, b._setTL);
	cc.defineGetterSetter(b, "tr", b._getTR, b._setTR);
	cc.defineGetterSetter(b, "bl", b._getBL, b._setBL);
	cc.defineGetterSetter(b, "br", b._getBR, b._setBR);
	cc.defineGetterSetter(b, "arrayBuffer", b._getArrayBuffer, null);
	cc.V3F_C4B_T2F_QuadZero = function() {
		return new cc.V3F_C4B_T2F_Quad
	};
	cc.V3F_C4B_T2F_QuadCopy = function(b) {
		if (!b) {
			return cc.V3F_C4B_T2F_QuadZero()
		}
		var d = b.tl,
			e = b.bl,
			f = b.tr;
		b = b.br;
		return {
			tl: {
				vertices: {
					x: d.vertices.x,
					y: d.vertices.y,
					z: d.vertices.z
				},
				colors: {
					r: d.colors.r,
					g: d.colors.g,
					b: d.colors.b,
					a: d.colors.a
				},
				texCoords: {
					u: d.texCoords.u,
					v: d.texCoords.v
				}
			},
			bl: {
				vertices: {
					x: e.vertices.x,
					y: e.vertices.y,
					z: e.vertices.z
				},
				colors: {
					r: e.colors.r,
					g: e.colors.g,
					b: e.colors.b,
					a: e.colors.a
				},
				texCoords: {
					u: e.texCoords.u,
					v: e.texCoords.v
				}
			},
			tr: {
				vertices: {
					x: f.vertices.x,
					y: f.vertices.y,
					z: f.vertices.z
				},
				colors: {
					r: f.colors.r,
					g: f.colors.g,
					b: f.colors.b,
					a: f.colors.a
				},
				texCoords: {
					u: f.texCoords.u,
					v: f.texCoords.v
				}
			},
			br: {
				vertices: {
					x: b.vertices.x,
					y: b.vertices.y,
					z: b.vertices.z
				},
				colors: {
					r: b.colors.r,
					g: b.colors.g,
					b: b.colors.b,
					a: b.colors.a
				},
				texCoords: {
					u: b.texCoords.u,
					v: b.texCoords.v
				}
			}
		}
	};
	cc.V3F_C4B_T2F_QuadsCopy = function(b) {
		if (!b) {
			return []
		}
		for (var d = [], e = 0; e < b.length; e++) {
			d.push(cc.V3F_C4B_T2F_QuadCopy(b[e]))
		}
		return d
	};
	cc.V2F_C4B_T2F = function(b, d, e, f, g) {
		this._arrayBuffer = f || new ArrayBuffer(cc.V2F_C4B_T2F.BYTES_PER_ELEMENT);
		this._offset = g || 0;
		f = this._arrayBuffer;
		g = this._offset;
		var h = cc.Vertex2F.BYTES_PER_ELEMENT;
		this._vertices = b ? new cc.Vertex2F(b.x, b.y, f, g) : new cc.Vertex2F(0, 0, f, g);
		this._colors = d ? cc.color(d.r, d.g, d.b, d.a, f, g + h) : cc.color(0, 0, 0, 0, f, g + h);
		this._texCoords = e ? new cc.Tex2F(e.u, e.v, f, g + h + cc.Color.BYTES_PER_ELEMENT) : new cc.Tex2F(0, 0, f, g + h + cc.Color.BYTES_PER_ELEMENT)
	};
	cc.V2F_C4B_T2F.BYTES_PER_ELEMENT = 20;
	b = cc.V2F_C4B_T2F.prototype;
	b._getVertices = function() {
		return this._vertices
	};
	b._setVertices = function(b) {
		this._vertices.x = b.x;
		this._vertices.y = b.y
	};
	b._getColor = function() {
		return this._colors
	};
	b._setColor = function(b) {
		var d = this._colors;
		d.r = b.r;
		d.g = b.g;
		d.b = b.b;
		d.a = b.a
	};
	b._getTexCoords = function() {
		return this._texCoords
	};
	b._setTexCoords = function(b) {
		this._texCoords.u = b.u;
		this._texCoords.v = b.v
	};
	cc.defineGetterSetter(b, "vertices", b._getVertices, b._setVertices);
	cc.defineGetterSetter(b, "colors", b._getColor, b._setColor);
	cc.defineGetterSetter(b, "texCoords", b._getTexCoords, b._setTexCoords);
	cc.V2F_C4B_T2F_Triangle = function(b, d, e, f, g) {
		this._arrayBuffer = f || new ArrayBuffer(cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT);
		this._offset = g || 0;
		f = this._arrayBuffer;
		g = this._offset;
		var h = cc.V2F_C4B_T2F.BYTES_PER_ELEMENT;
		this._a = b ? new cc.V2F_C4B_T2F(b.vertices, b.colors, b.texCoords, f, g) : new cc.V2F_C4B_T2F(null, null, null, f, g);
		this._b = d ? new cc.V2F_C4B_T2F(d.vertices, d.colors, d.texCoords, f, g + h) : new cc.V2F_C4B_T2F(null, null, null, f, g + h);
		this._c = e ? new cc.V2F_C4B_T2F(e.vertices, e.colors, e.texCoords, f, g + 2 * h) : new cc.V2F_C4B_T2F(null, null, null, f, g + 2 * h)
	};
	cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT = 60;
	b = cc.V2F_C4B_T2F_Triangle.prototype;
	b._getA = function() {
		return this._a
	};
	b._setA = function(b) {
		var d = this._a;
		d.vertices = b.vertices;
		d.colors = b.colors;
		d.texCoords = b.texCoords
	};
	b._getB = function() {
		return this._b
	};
	b._setB = function(b) {
		var d = this._b;
		d.vertices = b.vertices;
		d.colors = b.colors;
		d.texCoords = b.texCoords
	};
	b._getC = function() {
		return this._c
	};
	b._setC = function(b) {
		var d = this._c;
		d.vertices = b.vertices;
		d.colors = b.colors;
		d.texCoords = b.texCoords
	};
	cc.defineGetterSetter(b, "a", b._getA, b._setA);
	cc.defineGetterSetter(b, "b", b._getB, b._setB);
	cc.defineGetterSetter(b, "c", b._getC, b._setC)
};
cc._tmp.PrototypeColor = function() {
	var b = cc.color;
	b._getWhite = function() {
		return b(255, 255, 255)
	};
	b._getYellow = function() {
		return b(255, 255, 0)
	};
	b._getBlue = function() {
		return b(0, 0, 255)
	};
	b._getGreen = function() {
		return b(0, 255, 0)
	};
	b._getRed = function() {
		return b(255, 0, 0)
	};
	b._getMagenta = function() {
		return b(255, 0, 255)
	};
	b._getBlack = function() {
		return b(0, 0, 0)
	};
	b._getOrange = function() {
		return b(255, 127, 0)
	};
	b._getGray = function() {
		return b(166, 166, 166)
	};
	cc.defineGetterSetter(b, "WHITE", b._getWhite);
	cc.defineGetterSetter(b, "YELLOW", b._getYellow);
	cc.defineGetterSetter(b, "BLUE", b._getBlue);
	cc.defineGetterSetter(b, "GREEN", b._getGreen);
	cc.defineGetterSetter(b, "RED", b._getRed);
	cc.defineGetterSetter(b, "MAGENTA", b._getMagenta);
	cc.defineGetterSetter(b, "BLACK", b._getBlack);
	cc.defineGetterSetter(b, "ORANGE", b._getOrange);
	cc.defineGetterSetter(b, "GRAY", b._getGray);
	cc.BlendFunc._disable = function() {
		return new cc.BlendFunc(cc.ONE, cc.ZERO)
	};
	cc.BlendFunc._alphaPremultiplied = function() {
		return new cc.BlendFunc(cc.ONE, cc.ONE_MINUS_SRC_ALPHA)
	};
	cc.BlendFunc._alphaNonPremultiplied = function() {
		return new cc.BlendFunc(cc.SRC_ALPHA, cc.ONE_MINUS_SRC_ALPHA)
	};
	cc.BlendFunc._additive = function() {
		return new cc.BlendFunc(cc.SRC_ALPHA, cc.ONE)
	};
	cc.defineGetterSetter(cc.BlendFunc, "DISABLE", cc.BlendFunc._disable);
	cc.defineGetterSetter(cc.BlendFunc, "ALPHA_PREMULTIPLIED", cc.BlendFunc._alphaPremultiplied);
	cc.defineGetterSetter(cc.BlendFunc, "ALPHA_NON_PREMULTIPLIED", cc.BlendFunc._alphaNonPremultiplied);
	cc.defineGetterSetter(cc.BlendFunc, "ADDITIVE", cc.BlendFunc._additive)
};
cc.Color = function(b, c, d, e) {
	this.r = b || 0;
	this.g = c || 0;
	this.b = d || 0;
	this.a = null == e ? 255 : e
};
cc.color = function(b, c, d, e) {
	return void 0 === b ? {
		r: 0,
		g: 0,
		b: 0,
		a: 255
	} : cc.isString(b) ? cc.hexToColor(b) : cc.isObject(b) ? {
		r: b.r,
		g: b.g,
		b: b.b,
		a: null == b.a ? 255 : b.a
	} : {
		r: b,
		g: c,
		b: d,
		a: null == e ? 255 : e
	}
};
cc.colorEqual = function(b, c) {
	return b.r === c.r && b.g === c.g && b.b === c.b
};
cc.Acceleration = function(b, c, d, e) {
	this.x = b || 0;
	this.y = c || 0;
	this.z = d || 0;
	this.timestamp = e || 0
};
cc.Vertex2F = function(b, c) {
	this.x = b || 0;
	this.y = c || 0
};
cc.vertex2 = function(b, c) {
	return new cc.Vertex2F(b, c)
};
cc.Vertex3F = function(b, c, d) {
	this.x = b || 0;
	this.y = c || 0;
	this.z = d || 0
};
cc.vertex3 = function(b, c, d) {
	return new cc.Vertex3F(b, c, d)
};
cc.Tex2F = function(b, c) {
	this.u = b || 0;
	this.v = c || 0
};
cc.tex2 = function(b, c) {
	return new cc.Tex2F(b, c)
};
cc.BlendFunc = function(b, c) {
	this.src = b;
	this.dst = c
};
cc.blendFuncDisable = function() {
	return new cc.BlendFunc(cc.ONE, cc.ZERO)
};
cc.hexToColor = function(b) {
	b = b.replace(/^#?/, "0x");
	b = parseInt(b);
	return cc.color(b >> 16, (b >> 8) % 256, b % 256)
};
cc.colorToHex = function(b) {
	var c = b.r.toString(16),
		d = b.g.toString(16),
		e = b.b.toString(16);
	return "#" + (16 > b.r ? "0" + c : c) + (16 > b.g ? "0" + d : d) + (16 > b.b ? "0" + e : e)
};
cc.TEXT_ALIGNMENT_LEFT = 0;
cc.TEXT_ALIGNMENT_CENTER = 1;
cc.TEXT_ALIGNMENT_RIGHT = 2;
cc.VERTICAL_TEXT_ALIGNMENT_TOP = 0;
cc.VERTICAL_TEXT_ALIGNMENT_CENTER = 1;
cc.VERTICAL_TEXT_ALIGNMENT_BOTTOM = 2;
cc._Dictionary = cc.Class.extend({
	_keyMapTb: null,
	_valueMapTb: null,
	__currId: 0,
	ctor: function() {
		this._keyMapTb = {};
		this._valueMapTb = {};
		this.__currId = 2 << (0 | 10 * Math.random())
	},
	__getKey: function() {
		this.__currId++;
		return "key_" + this.__currId
	},
	setObject: function(b, c) {
		if (null != c) {
			var d = this.__getKey();
			this._keyMapTb[d] = c;
			this._valueMapTb[d] = b
		}
	},
	objectForKey: function(b) {
		if (null == b) {
			return null
		}
		var c = this._keyMapTb,
			d;
		for (d in c) {
			if (c[d] === b) {
				return this._valueMapTb[d]
			}
		}
		return null
	},
	valueForKey: function(b) {
		return this.objectForKey(b)
	},
	removeObjectForKey: function(b) {
		if (null != b) {
			var c = this._keyMapTb,
				d;
			for (d in c) {
				if (c[d] === b) {
					delete this._valueMapTb[d];
					delete c[d];
					break
				}
			}
		}
	},
	removeObjectsForKeys: function(b) {
		if (null != b) {
			for (var c = 0; c < b.length; c++) {
				this.removeObjectForKey(b[c])
			}
		}
	},
	allKeys: function() {
		var b = [],
			c = this._keyMapTb,
			d;
		for (d in c) {
			b.push(c[d])
		}
		return b
	},
	removeAllObjects: function() {
		this._keyMapTb = {};
		this._valueMapTb = {}
	},
	count: function() {
		return this.allKeys().length
	}
});
cc.FontDefinition = function(b) {
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
	if (b && b instanceof Object) {
		for (var c in b) {
			this[c] = b[c]
		}
	}
};
cc.FontDefinition.prototype._getCanvasFontStr = function() {
	return this.fontStyle + " " + this.fontWeight + " " + this.fontSize + "px/" + (this.lineHeight.charAt ? this.lineHeight : this.lineHeight + "px") + " '" + this.fontName + "'"
};
cc._renderType === cc._RENDER_TYPE_WEBGL && (cc.assert(cc.isFunction(cc._tmp.WebGLColor), cc._LogInfos.MissingFile, "CCTypesWebGL.js"), cc._tmp.WebGLColor(), delete cc._tmp.WebGLColor);
cc.assert(cc.isFunction(cc._tmp.PrototypeColor), cc._LogInfos.MissingFile, "CCTypesPropertyDefine.js");
cc._tmp.PrototypeColor();
delete cc._tmp.PrototypeColor;
cc.Touches = [];
cc.TouchesIntergerDict = {};
cc.DENSITYDPI_DEVICE = "device-dpi";
cc.DENSITYDPI_HIGH = "high-dpi";
cc.DENSITYDPI_MEDIUM = "medium-dpi";
cc.DENSITYDPI_LOW = "low-dpi";
cc.__BrowserGetter = {
	init: function() {
		this.html = document.getElementsByTagName("html")[0]
	},
	availWidth: function(b) {
		return b && b !== this.html ? b.clientWidth : window.innerWidth
	},
	availHeight: function(b) {
		return b && b !== this.html ? b.clientHeight : window.innerHeight
	},
	meta: {
		width: "device-width",
		"user-scalable": "no"
	},
	adaptationType: cc.sys.browserType
}; - 1 < window.navigator.userAgent.indexOf("OS 8_1_") && (cc.__BrowserGetter.adaptationType = cc.sys.BROWSER_TYPE_MIUI);
cc.sys.os === cc.sys.OS_IOS && (cc.__BrowserGetter.adaptationType = cc.sys.BROWSER_TYPE_SAFARI);
switch (cc.__BrowserGetter.adaptationType) {
case cc.sys.BROWSER_TYPE_SAFARI:
	cc.__BrowserGetter.meta["minimal-ui"] = "true";
	cc.__BrowserGetter.availWidth = function(b) {
		return b.clientWidth
	};
	cc.__BrowserGetter.availHeight = function(b) {
		return b.clientHeight
	};
	break;
case cc.sys.BROWSER_TYPE_CHROME:
	cc.__BrowserGetter.__defineGetter__("target-densitydpi", function() {
		return cc.view._targetDensityDPI
	});
case cc.sys.BROWSER_TYPE_SOUGOU:
case cc.sys.BROWSER_TYPE_UC:
	cc.__BrowserGetter.availWidth = function(b) {
		return b.clientWidth
	};
	cc.__BrowserGetter.availHeight = function(b) {
		return b.clientHeight
	};
	break;
case cc.sys.BROWSER_TYPE_MIUI:
	cc.__BrowserGetter.init = function(b) {
		if (!b.__resizeWithBrowserSize) {
			var c = function() {
					b.setDesignResolutionSize(b._designResolutionSize.width, b._designResolutionSize.height, b._resolutionPolicy);
					window.removeEventListener("resize", c, !1)
				};
			window.addEventListener("resize", c, !1)
		}
	}
}
cc.EGLView = cc.Class.extend({
	_delegate: null,
	_frameSize: null,
	_designResolutionSize: null,
	_originalDesignResolutionSize: null,
	_viewPortRect: null,
	_visibleRect: null,
	_retinaEnabled: !1,
	_autoFullScreen: !0,
	_devicePixelRatio: 1,
	_viewName: "",
	_resizeCallback: null,
	_scaleX: 1,
	_originalScaleX: 1,
	_scaleY: 1,
	_originalScaleY: 1,
	_indexBitsUsed: 0,
	_maxTouches: 5,
	_resolutionPolicy: null,
	_rpExactFit: null,
	_rpShowAll: null,
	_rpNoBorder: null,
	_rpFixedHeight: null,
	_rpFixedWidth: null,
	_initialized: !1,
	_captured: !1,
	_wnd: null,
	_hDC: null,
	_hRC: null,
	_supportTouch: !1,
	_contentTranslateLeftTop: null,
	_frame: null,
	_frameZoomFactor: 1,
	__resizeWithBrowserSize: !1,
	_isAdjustViewPort: !0,
	_targetDensityDPI: null,
	ctor: function() {
		var b = document,
			c = cc.ContainerStrategy,
			d = cc.ContentStrategy;
		cc.__BrowserGetter.init(this);
		this._frame = cc.container.parentNode === b.body ? b.documentElement : cc.container.parentNode;
		this._frameSize = cc.size(0, 0);
		this._initFrameSize();
		var b = cc._canvas.width,
			e = cc._canvas.height;
		this._designResolutionSize = cc.size(b, e);
		this._originalDesignResolutionSize = cc.size(b, e);
		this._viewPortRect = cc.rect(0, 0, b, e);
		this._visibleRect = cc.rect(0, 0, b, e);
		this._contentTranslateLeftTop = {
			left: 0,
			top: 0
		};
		this._viewName = "Cocos2dHTML5";
		b = cc.sys;
		this.enableRetina(b.os === b.OS_IOS || b.os === b.OS_OSX);
		cc.visibleRect && cc.visibleRect.init(this._visibleRect);
		this._rpExactFit = new cc.ResolutionPolicy(c.EQUAL_TO_FRAME, d.EXACT_FIT);
		this._rpShowAll = new cc.ResolutionPolicy(c.PROPORTION_TO_FRAME, d.SHOW_ALL);
		this._rpNoBorder = new cc.ResolutionPolicy(c.EQUAL_TO_FRAME, d.NO_BORDER);
		this._rpFixedHeight = new cc.ResolutionPolicy(c.EQUAL_TO_FRAME, d.FIXED_HEIGHT);
		this._rpFixedWidth = new cc.ResolutionPolicy(c.EQUAL_TO_FRAME, d.FIXED_WIDTH);
		this._hDC = cc._canvas;
		this._hRC = cc._renderContext;
		this._targetDensityDPI = cc.DENSITYDPI_HIGH
	},
	_resizeEvent: function() {
		var b;
		b = this.setDesignResolutionSize ? this : cc.view;
		var c = b._frameSize.width,
			d = b._frameSize.height;
		b._initFrameSize();
		if (b._frameSize.width !== c || b._frameSize.height !== d) {
			b._resizeCallback && b._resizeCallback.call(), c = b._originalDesignResolutionSize.width, d = b._originalDesignResolutionSize.height, 0 < c && b.setDesignResolutionSize(c, d, b._resolutionPolicy)
		}
	},
	setTargetDensityDPI: function(b) {
		this._targetDensityDPI = b;
		this._setViewPortMeta()
	},
	getTargetDensityDPI: function() {
		return this._targetDensityDPI
	},
	resizeWithBrowserSize: function(b) {
		b ? this.__resizeWithBrowserSize || (this.__resizeWithBrowserSize = !0, cc._addEventListener(window, "resize", this._resizeEvent), cc._addEventListener(window, "orientationchange", this._resizeEvent)) : this.__resizeWithBrowserSize && (this.__resizeWithBrowserSize = !1, window.removeEventListener("resize", this._resizeEvent), window.removeEventListener("orientationchange", this._resizeEvent))
	},
	setResizeCallback: function(b) {
		if (cc.isFunction(b) || null == b) {
			this._resizeCallback = b
		}
	},
	_initFrameSize: function() {
		var b = this._frameSize;
		b.width = cc.__BrowserGetter.availWidth(this._frame);
		b.height = cc.__BrowserGetter.availHeight(this._frame)
	},
	_adjustSizeKeepCanvasSize: function() {
		var b = this._originalDesignResolutionSize.width,
			c = this._originalDesignResolutionSize.height;
		0 < b && this.setDesignResolutionSize(b, c, this._resolutionPolicy)
	},
	_setViewPortMeta: function() {
		if (this._isAdjustViewPort) {
			var b = document.getElementById("cocosMetaElement");
			b && document.head.removeChild(b);
			var c, d = (b = document.getElementsByName("viewport")) ? b[0] : null,
				e, b = cc.newElement("meta");
			b.id = "cocosMetaElement";
			b.name = "viewport";
			b.content = "";
			c = cc.__BrowserGetter.meta;
			e = d ? d.content : "";
			for (var f in c) {
				RegExp(f).test(e) || (e += "," + f + "=" + c[f])
			}
			/^,/.test(e) && (e = e.substr(1));
			b.content = e;
			d && (d.content = e);
			document.head.appendChild(b)
		}
	},
	_setScaleXYForRenderTexture: function() {
		var b = cc.contentScaleFactor();
		this._scaleY = this._scaleX = b
	},
	_resetScale: function() {
		this._scaleX = this._originalScaleX;
		this._scaleY = this._originalScaleY
	},
	_adjustSizeToBrowser: function() {},
	initialize: function() {
		this._initialized = !0
	},
	adjustViewPort: function(b) {
		this._isAdjustViewPort = b
	},
	enableRetina: function(b) {
		this._retinaEnabled = b ? !0 : !1
	},
	isRetinaEnabled: function() {
		return this._retinaEnabled
	},
	enableAutoFullScreen: function(b) {
		this._autoFullScreen = b ? !0 : !1
	},
	isAutoFullScreenEnabled: function() {
		return this._autoFullScreen
	},
	end: function() {},
	isOpenGLReady: function() {
		return null !== this._hDC && null !== this._hRC
	},
	setFrameZoomFactor: function(b) {
		this._frameZoomFactor = b;
		this.centerWindow();
		cc.director.setProjection(cc.director.getProjection())
	},
	swapBuffers: function() {},
	setIMEKeyboardState: function(b) {},
	setContentTranslateLeftTop: function(b, c) {
		this._contentTranslateLeftTop = {
			left: b,
			top: c
		}
	},
	getContentTranslateLeftTop: function() {
		return this._contentTranslateLeftTop
	},
	getFrameSize: function() {
		return cc.size(this._frameSize.width, this._frameSize.height)
	},
	setFrameSize: function(b, c) {
		this._frameSize.width = b;
		this._frameSize.height = c;
		this._frame.style.width = b + "px";
		this._frame.style.height = c + "px";
		this._resizeEvent();
		cc.director.setProjection(cc.director.getProjection())
	},
	centerWindow: function() {},
	getVisibleSize: function() {
		return cc.size(this._visibleRect.width, this._visibleRect.height)
	},
	getVisibleOrigin: function() {
		return cc.p(this._visibleRect.x, this._visibleRect.y)
	},
	canSetContentScaleFactor: function() {
		return !0
	},
	getResolutionPolicy: function() {
		return this._resolutionPolicy
	},
	setResolutionPolicy: function(b) {
		if (b instanceof cc.ResolutionPolicy) {
			this._resolutionPolicy = b
		} else {
			var c = cc.ResolutionPolicy;
			b === c.EXACT_FIT && (this._resolutionPolicy = this._rpExactFit);
			b === c.SHOW_ALL && (this._resolutionPolicy = this._rpShowAll);
			b === c.NO_BORDER && (this._resolutionPolicy = this._rpNoBorder);
			b === c.FIXED_HEIGHT && (this._resolutionPolicy = this._rpFixedHeight);
			b === c.FIXED_WIDTH && (this._resolutionPolicy = this._rpFixedWidth)
		}
	},
	setDesignResolutionSize: function(b, c, d) {
		if (0 < b || 0 < c) {
			if (this.setResolutionPolicy(d), d = this._resolutionPolicy) {
				d.preApply(this);
				cc.sys.isMobile && this._setViewPortMeta();
				this._initFrameSize();
				this._originalDesignResolutionSize.width = this._designResolutionSize.width = b;
				this._originalDesignResolutionSize.height = this._designResolutionSize.height = c;
				var e = d.apply(this, this._designResolutionSize);
				e.scale && 2 === e.scale.length && (this._scaleX = e.scale[0], this._scaleY = e.scale[1]);
				e.viewport && (b = this._viewPortRect, c = this._visibleRect, e = e.viewport, b.x = e.x, b.y = e.y, b.width = e.width, b.height = e.height, c.x = -b.x / this._scaleX, c.y = -b.y / this._scaleY, c.width = cc._canvas.width / this._scaleX, c.height = cc._canvas.height / this._scaleY, cc._renderContext.setOffset && cc._renderContext.setOffset(b.x, -b.y));
				b = cc.director;
				b._winSizeInPoints.width = this._designResolutionSize.width;
				b._winSizeInPoints.height = this._designResolutionSize.height;
				d.postApply(this);
				cc.winSize.width = b._winSizeInPoints.width;
				cc.winSize.height = b._winSizeInPoints.height;
				cc._renderType === cc._RENDER_TYPE_WEBGL && (b._createStatsLabel(), b.setGLDefaultValues());
				this._originalScaleX = this._scaleX;
				this._originalScaleY = this._scaleY;
				cc.DOM && cc.DOM._resetEGLViewDiv();
				cc.visibleRect && cc.visibleRect.init(this._visibleRect)
			} else {
				cc.log(cc._LogInfos.EGLView_setDesignResolutionSize_2)
			}
		} else {
			cc.log(cc._LogInfos.EGLView_setDesignResolutionSize)
		}
	},
	getDesignResolutionSize: function() {
		return cc.size(this._designResolutionSize.width, this._designResolutionSize.height)
	},
	setViewPortInPoints: function(b, c, d, e) {
		var f = this._frameZoomFactor,
			g = this._scaleX,
			h = this._scaleY;
		cc._renderContext.viewport(b * g * f + this._viewPortRect.x * f, c * h * f + this._viewPortRect.y * f, d * g * f, e * h * f)
	},
	setScissorInPoints: function(b, c, d, e) {
		var f = this._frameZoomFactor,
			g = this._scaleX,
			h = this._scaleY;
		cc._renderContext.scissor(b * g * f + this._viewPortRect.x * f, c * h * f + this._viewPortRect.y * f, d * g * f, e * h * f)
	},
	isScissorEnabled: function() {
		var b = cc._renderContext;
		return b.isEnabled(b.SCISSOR_TEST)
	},
	getScissorRect: function() {
		var b = cc._renderContext,
			c = this._scaleX,
			d = this._scaleY,
			b = b.getParameter(b.SCISSOR_BOX);
		return cc.rect((b[0] - this._viewPortRect.x) / c, (b[1] - this._viewPortRect.y) / d, b[2] / c, b[3] / d)
	},
	setViewName: function(b) {
		null != b && 0 < b.length && (this._viewName = b)
	},
	getViewName: function() {
		return this._viewName
	},
	getViewPortRect: function() {
		return this._viewPortRect
	},
	getScaleX: function() {
		return this._scaleX
	},
	getScaleY: function() {
		return this._scaleY
	},
	getDevicePixelRatio: function() {
		return this._devicePixelRatio
	},
	convertToLocationInView: function(b, c, d) {
		return {
			x: this._devicePixelRatio * (b - d.left),
			y: this._devicePixelRatio * (d.top + d.height - c)
		}
	},
	_convertMouseToLocationInView: function(b, c) {
		var d = this._viewPortRect;
		b.x = (this._devicePixelRatio * (b.x - c.left) - d.x) / this._scaleX;
		b.y = (this._devicePixelRatio * (c.top + c.height - b.y) - d.y) / this._scaleY
	},
	_convertTouchesWithScale: function(b) {
		for (var c = this._viewPortRect, d = this._scaleX, e = this._scaleY, f, g, h, k = 0; k < b.length; k++) {
			f = b[k], g = f._point, h = f._prevPoint, f._setPoint((g.x - c.x) / d, (g.y - c.y) / e), f._setPrevPoint((h.x - c.x) / d, (h.y - c.y) / e)
		}
	}
});
cc.EGLView._getInstance = function() {
	this._instance || (this._instance = this._instance || new cc.EGLView, this._instance.initialize());
	return this._instance
};
cc.ContainerStrategy = cc.Class.extend({
	preApply: function(b) {},
	apply: function(b, c) {},
	postApply: function(b) {},
	_setupContainer: function(b, c, d) {
		var e = b._frame;
		cc.view._autoFullScreen && cc.sys.isMobile && e === document.documentElement && cc.screen.autoFullScreen(e);
		var e = cc._canvas,
			f = cc.container;
		f.style.width = e.style.width = c + "px";
		f.style.height = e.style.height = d + "px";
		f = b._devicePixelRatio = 1;
		b.isRetinaEnabled() && (f = b._devicePixelRatio = window.devicePixelRatio || 1);
		e.width = c * f;
		e.height = d * f;
		cc._renderContext.resetCache && cc._renderContext.resetCache();
		b = document.body;
		var g;
		b && (g = b.style) && (g.paddingTop = g.paddingTop || "0px", g.paddingRight = g.paddingRight || "0px", g.paddingBottom = g.paddingBottom || "0px", g.paddingLeft = g.paddingLeft || "0px", g.borderTop = g.borderTop || "0px", g.borderRight = g.borderRight || "0px", g.borderBottom = g.borderBottom || "0px", g.borderLeft = g.borderLeft || "0px", g.marginTop = g.marginTop || "0px", g.marginRight = g.marginRight || "0px", g.marginBottom = g.marginBottom || "0px", g.marginLeft = g.marginLeft || "0px")
	},
	_fixContainer: function() {
		document.body.insertBefore(cc.container, document.body.firstChild);
		var b = document.body.style;
		b.width = window.innerWidth + "px";
		b.height = window.innerHeight + "px";
		b.overflow = "hidden";
		b = cc.container.style;
		b.position = "fixed";
		b.left = b.top = "0px";
		document.body.scrollTop = 0
	}
});
cc.ContentStrategy = cc.Class.extend({
	_result: {
		scale: [1, 1],
		viewport: null
	},
	_buildResult: function(b, c, d, e, f, g) {
		2 > Math.abs(b - d) && (d = b);
		2 > Math.abs(c - e) && (e = c);
		b = cc.rect(Math.round((b - d) / 2), Math.round((c - e) / 2), d, e);
		this._result.scale = [f, g];
		this._result.viewport = b;
		return this._result
	},
	preApply: function(b) {},
	apply: function(b, c) {
		return {
			scale: [1, 1]
		}
	},
	postApply: function(b) {}
});
(function() {
	var b = cc.ContainerStrategy.extend({
		apply: function(b) {
			this._setupContainer(b, b._frameSize.width, b._frameSize.height)
		}
	}),
		c = cc.ContainerStrategy.extend({
			apply: function(b, c) {
				var d = b._frameSize.width,
					e = b._frameSize.height,
					f = cc.container.style,
					p = c.width,
					r = c.height,
					t = d / p,
					s = e / r,
					v, u;
				t < s ? (v = d, u = r * t) : (v = p * s, u = e);
				p = Math.round((d - v) / 2);
				u = Math.round((e - u) / 2);
				this._setupContainer(b, d - 2 * p, e - 2 * u);
				f.marginLeft = p + "px";
				f.marginRight = p + "px";
				f.marginTop = u + "px";
				f.marginBottom = u + "px"
			}
		});
	b.extend({
		preApply: function(b) {
			this._super(b);
			b._frame = document.documentElement
		},
		apply: function(b) {
			this._super(b);
			this._fixContainer()
		}
	});
	c.extend({
		preApply: function(b) {
			this._super(b);
			b._frame = document.documentElement
		},
		apply: function(b, c) {
			this._super(b, c);
			this._fixContainer()
		}
	});
	var d = cc.ContainerStrategy.extend({
		apply: function(b) {
			this._setupContainer(b, cc._canvas.width, cc._canvas.height)
		}
	});
	cc.ContainerStrategy.EQUAL_TO_FRAME = new b;
	cc.ContainerStrategy.PROPORTION_TO_FRAME = new c;
	cc.ContainerStrategy.ORIGINAL_CONTAINER = new d;
	var b = cc.ContentStrategy.extend({
		apply: function(b, c) {
			var d = cc._canvas.width,
				e = cc._canvas.height;
			return this._buildResult(d, e, d, e, d / c.width, e / c.height)
		}
	}),
		c = cc.ContentStrategy.extend({
			apply: function(b, c) {
				var d = cc._canvas.width,
					e = cc._canvas.height,
					f = c.width,
					p = c.height,
					r = d / f,
					t = e / p,
					s = 0,
					v, u;
				r < t ? (s = r, v = d, u = p * s) : (s = t, v = f * s, u = e);
				return this._buildResult(d, e, v, u, s, s)
			}
		}),
		d = cc.ContentStrategy.extend({
			apply: function(b, c) {
				var d = cc._canvas.width,
					e = cc._canvas.height,
					f = c.width,
					p = c.height,
					r = d / f,
					t = e / p,
					s, v, u;
				r < t ? (s = t, v = f * s, u = e) : (s = r, v = d, u = p * s);
				return this._buildResult(d, e, v, u, s, s)
			}
		}),
		e = cc.ContentStrategy.extend({
			apply: function(b, c) {
				var d = cc._canvas.width,
					e = cc._canvas.height,
					f = e / c.height;
				return this._buildResult(d, e, d, e, f, f)
			},
			postApply: function(b) {
				cc.director._winSizeInPoints = b.getVisibleSize()
			}
		}),
		f = cc.ContentStrategy.extend({
			apply: function(b, c) {
				var d = cc._canvas.width,
					e = cc._canvas.height,
					f = d / c.width;
				return this._buildResult(d, e, d, e, f, f)
			},
			postApply: function(b) {
				cc.director._winSizeInPoints = b.getVisibleSize()
			}
		});
	cc.ContentStrategy.EXACT_FIT = new b;
	cc.ContentStrategy.SHOW_ALL = new c;
	cc.ContentStrategy.NO_BORDER = new d;
	cc.ContentStrategy.FIXED_HEIGHT = new e;
	cc.ContentStrategy.FIXED_WIDTH = new f
})();
cc.ResolutionPolicy = cc.Class.extend({
	_containerStrategy: null,
	_contentStrategy: null,
	ctor: function(b, c) {
		this.setContainerStrategy(b);
		this.setContentStrategy(c)
	},
	preApply: function(b) {
		this._containerStrategy.preApply(b);
		this._contentStrategy.preApply(b)
	},
	apply: function(b, c) {
		this._containerStrategy.apply(b, c);
		return this._contentStrategy.apply(b, c)
	},
	postApply: function(b) {
		this._containerStrategy.postApply(b);
		this._contentStrategy.postApply(b)
	},
	setContainerStrategy: function(b) {
		b instanceof cc.ContainerStrategy && (this._containerStrategy = b)
	},
	setContentStrategy: function(b) {
		b instanceof cc.ContentStrategy && (this._contentStrategy = b)
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
	_fnMap: [
		["requestFullscreen", "exitFullscreen", "fullscreenchange", "fullscreenEnabled", "fullscreenElement"],
		["requestFullScreen", "exitFullScreen", "fullScreenchange", "fullScreenEnabled", "fullScreenElement"],
		["webkitRequestFullScreen", "webkitCancelFullScreen", "webkitfullscreenchange", "webkitIsFullScreen", "webkitCurrentFullScreenElement"],
		["mozRequestFullScreen", "mozCancelFullScreen", "mozfullscreenchange", "mozFullScreen", "mozFullScreenElement"],
		["msRequestFullscreen", "msExitFullscreen", "MSFullscreenChange", "msFullscreenEnabled", "msFullscreenElement"]
	],
	init: function() {
		this._fn = {};
		var b, c, d = this._fnMap,
			e;
		b = 0;
		for (l = d.length; b < l; b++) {
			if ((c = d[b]) && c[1] in document) {
				b = 0;
				for (e = c.length; b < e; b++) {
					this._fn[d[0][b]] = c[b]
				}
				break
			}
		}
		this._supportsFullScreen = "undefined" !== typeof this._fn.requestFullscreen;
		this._touchEvent = "ontouchstart" in window ? "touchstart" : "mousedown"
	},
	fullScreen: function() {
		return this._supportsFullScreen && document[this._fn.fullscreenElement]
	},
	requestFullScreen: function(b, c) {
		if (this._supportsFullScreen) {
			b = b || document.documentElement;
			if (c) {
				var d = this._fn.fullscreenchange;
				this._preOnFullScreenChange && document.removeEventListener(d, this._preOnFullScreenChange);
				this._preOnFullScreenChange = c;
				cc._addEventListener(document, d, c, !1)
			}
			return b[this._fn.requestFullscreen]()
		}
	},
	exitFullScreen: function() {
		return this._supportsFullScreen ? document[this._fn.exitFullscreen]() : !0
	},
	autoFullScreen: function(b, c) {
		function d() {
			f.requestFullScreen(b, c);
			e.removeEventListener(f._touchEvent, d)
		}
		b = b || document.body;
		var e = cc._canvas || b,
			f = this;
		this.requestFullScreen(b, c);
		cc._addEventListener(e, this._touchEvent, d)
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
	init: function(b) {
		var c = this.width = b.width,
			d = this.height = b.height,
			e = b.x;
		b = b.y;
		var f = b + d,
			g = e + c;
		this.topLeft.x = e;
		this.topLeft.y = f;
		this.topRight.x = g;
		this.topRight.y = f;
		this.top.x = e + c / 2;
		this.top.y = f;
		this.bottomLeft.x = e;
		this.bottomLeft.y = b;
		this.bottomRight.x = g;
		this.bottomRight.y = b;
		this.bottom.x = e + c / 2;
		this.bottom.y = b;
		this.center.x = e + c / 2;
		this.center.y = b + d / 2;
		this.left.x = e;
		this.left.y = b + d / 2;
		this.right.x = g;
		this.right.y = b + d / 2
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
	_getUnUsedIndex: function() {
		for (var b = this._indexBitsUsed, c = 0; c < this._maxTouches; c++) {
			if (!(b & 1)) {
				return this._indexBitsUsed |= 1 << c, c
			}
			b >>= 1
		}
		return -1
	},
	_removeUsedIndexBit: function(b) {
		0 > b || b >= this._maxTouches || (b = ~ (1 << b), this._indexBitsUsed &= b)
	},
	_glView: null,
	handleTouchesBegin: function(b) {
		for (var c, d, e, f = [], g = this._touchesIntegerDict, h = 0, k = b.length; h < k; h++) {
			if (c = b[h], e = c.getID(), d = g[e], null == d) {
				var m = this._getUnUsedIndex(); - 1 === m ? cc.log(cc._LogInfos.inputManager_handleTouchesBegin, m) : (d = this._touches[m] = new cc.Touch(c._point.x, c._point.y, c.getID()), d._setPrevPoint(c._prevPoint), g[e] = m, f.push(d))
			}
		}
		0 < f.length && (this._glView._convertTouchesWithScale(f), b = new cc.EventTouch(f), b._eventCode = cc.EventTouch.EventCode.BEGAN, cc.eventManager.dispatchEvent(b))
	},
	handleTouchesMove: function(b) {
		for (var c, d, e = [], f = this._touches, g = 0, h = b.length; g < h; g++) {
			c = b[g], d = c.getID(), d = this._touchesIntegerDict[d], null != d && f[d] && (f[d]._setPoint(c._point), f[d]._setPrevPoint(c._prevPoint), e.push(f[d]))
		}
		0 < e.length && (this._glView._convertTouchesWithScale(e), b = new cc.EventTouch(e), b._eventCode = cc.EventTouch.EventCode.MOVED, cc.eventManager.dispatchEvent(b))
	},
	handleTouchesEnd: function(b) {
		b = this.getSetOfTouchesEndOrCancel(b);
		0 < b.length && (this._glView._convertTouchesWithScale(b), b = new cc.EventTouch(b), b._eventCode = cc.EventTouch.EventCode.ENDED, cc.eventManager.dispatchEvent(b))
	},
	handleTouchesCancel: function(b) {
		b = this.getSetOfTouchesEndOrCancel(b);
		0 < b.length && (this._glView._convertTouchesWithScale(b), b = new cc.EventTouch(b), b._eventCode = cc.EventTouch.EventCode.CANCELLED, cc.eventManager.dispatchEvent(b))
	},
	getSetOfTouchesEndOrCancel: function(b) {
		for (var c, d, e, f = [], g = this._touches, h = this._touchesIntegerDict, k = 0, m = b.length; k < m; k++) {
			c = b[k], e = c.getID(), d = h[e], null != d && g[d] && (g[d]._setPoint(c._point), g[d]._setPrevPoint(c._prevPoint), f.push(g[d]), this._removeUsedIndexBit(d), delete h[e])
		}
		return f
	},
	getHTMLElementPosition: function(b) {
		var c = document.documentElement,
			d = window,
			e = null,
			e = cc.isFunction(b.getBoundingClientRect) ? b.getBoundingClientRect() : b instanceof HTMLCanvasElement ? {
				left: 0,
				top: 0,
				width: b.width,
				height: b.height
			} : {
				left: 0,
				top: 0,
				width: parseInt(b.style.width),
				height: parseInt(b.style.height)
			};
		return {
			left: e.left + d.pageXOffset - c.clientLeft,
			top: e.top + d.pageYOffset - c.clientTop,
			width: e.width,
			height: e.height
		}
	},
	getPreTouch: function(b) {
		for (var c = null, d = this._preTouchPool, e = b.getID(), f = d.length - 1; 0 <= f; f--) {
			if (d[f].getID() === e) {
				c = d[f];
				break
			}
		}
		c || (c = b);
		return c
	},
	setPreTouch: function(b) {
		for (var c = !1, d = this._preTouchPool, e = b.getID(), f = d.length - 1; 0 <= f; f--) {
			if (d[f].getID() === e) {
				d[f] = b;
				c = !0;
				break
			}
		}
		c || (50 >= d.length ? d.push(b) : (d[this._preTouchPoolPointer] = b, this._preTouchPoolPointer = (this._preTouchPoolPointer + 1) % 50))
	},
	getTouchByXY: function(b, c, d) {
		var e = this._preTouchPoint;
		b = this._glView.convertToLocationInView(b, c, d);
		c = new cc.Touch(b.x, b.y);
		c._setPrevPoint(e.x, e.y);
		e.x = b.x;
		e.y = b.y;
		return c
	},
	getMouseEvent: function(b, c, d) {
		var e = this._prevMousePoint;
		this._glView._convertMouseToLocationInView(b, c);
		c = new cc.EventMouse(d);
		c.setLocation(b.x, b.y);
		c._setPrevCursor(e.x, e.y);
		e.x = b.x;
		e.y = b.y;
		return c
	},
	getPointByEvent: function(b, c) {
		if (null != b.pageX) {
			return {
				x: b.pageX,
				y: b.pageY
			}
		}
		c.left -= document.body.scrollLeft;
		c.top -= document.body.scrollTop;
		return {
			x: b.clientX,
			y: b.clientY
		}
	},
	getTouchesByEvent: function(b, c) {
		for (var d = [], e = this._glView, f, g, h = this._preTouchPoint, k = b.changedTouches.length, m = 0; m < k; m++) {
			if (f = b.changedTouches[m]) {
				var n;
				n = cc.sys.BROWSER_TYPE_FIREFOX === cc.sys.browserType ? e.convertToLocationInView(f.pageX, f.pageY, c) : e.convertToLocationInView(f.clientX, f.clientY, c);
				null != f.identifier ? (f = new cc.Touch(n.x, n.y, f.identifier), g = this.getPreTouch(f).getLocation(), f._setPrevPoint(g.x, g.y), this.setPreTouch(f)) : (f = new cc.Touch(n.x, n.y), f._setPrevPoint(h.x, h.y));
				h.x = n.x;
				h.y = n.y;
				d.push(f)
			}
		}
		return d
	},
	registerSystemEvent: function(b) {
		if (!this._isRegisterEvent) {
			this._glView = cc.view;
			var c = this,
				d = "mouse" in cc.sys.capabilities,
				e = "touches" in cc.sys.capabilities,
				f = !1;
			cc.sys.isMobile && (f = !0);
			d && (cc._addEventListener(window, "mousedown", function() {
				c._mousePressed = !0
			}, !1), cc._addEventListener(window, "mouseup", function(d) {
				if (!f) {
					var e = c._mousePressed;
					c._mousePressed = !1;
					if (e) {
						var e = c.getHTMLElementPosition(b),
							g = c.getPointByEvent(d, e);
						cc.rectContainsPoint(new cc.Rect(e.left, e.top, e.width, e.height), g) || (c.handleTouchesEnd([c.getTouchByXY(g.x, g.y, e)]), e = c.getMouseEvent(g, e, cc.EventMouse.UP), e.setButton(d.button), cc.eventManager.dispatchEvent(e))
					}
				}
			}, !1), cc._addEventListener(b, "mousedown", function(d) {
				if (!f) {
					c._mousePressed = !0;
					var e = c.getHTMLElementPosition(b),
						g = c.getPointByEvent(d, e);
					c.handleTouchesBegin([c.getTouchByXY(g.x, g.y, e)]);
					e = c.getMouseEvent(g, e, cc.EventMouse.DOWN);
					e.setButton(d.button);
					cc.eventManager.dispatchEvent(e);
					d.stopPropagation();
					d.preventDefault();
					b.focus()
				}
			}, !1), cc._addEventListener(b, "mouseup", function(d) {
				if (!f) {
					c._mousePressed = !1;
					var e = c.getHTMLElementPosition(b),
						g = c.getPointByEvent(d, e);
					c.handleTouchesEnd([c.getTouchByXY(g.x, g.y, e)]);
					e = c.getMouseEvent(g, e, cc.EventMouse.UP);
					e.setButton(d.button);
					cc.eventManager.dispatchEvent(e);
					d.stopPropagation();
					d.preventDefault()
				}
			}, !1), cc._addEventListener(b, "mousemove", function(d) {
				if (!f) {
					var e = c.getHTMLElementPosition(b),
						g = c.getPointByEvent(d, e);
					c.handleTouchesMove([c.getTouchByXY(g.x, g.y, e)]);
					e = c.getMouseEvent(g, e, cc.EventMouse.MOVE);
					c._mousePressed ? e.setButton(d.button) : e.setButton(null);
					cc.eventManager.dispatchEvent(e);
					d.stopPropagation();
					d.preventDefault()
				}
			}, !1), cc._addEventListener(b, "mousewheel", function(d) {
				var e = c.getHTMLElementPosition(b),
					f = c.getPointByEvent(d, e),
					e = c.getMouseEvent(f, e, cc.EventMouse.SCROLL);
				e.setButton(d.button);
				e.setScrollData(0, d.wheelDelta);
				cc.eventManager.dispatchEvent(e);
				d.stopPropagation();
				d.preventDefault()
			}, !1), cc._addEventListener(b, "DOMMouseScroll", function(d) {
				var e = c.getHTMLElementPosition(b),
					f = c.getPointByEvent(d, e),
					e = c.getMouseEvent(f, e, cc.EventMouse.SCROLL);
				e.setButton(d.button);
				e.setScrollData(0, -120 * d.detail);
				cc.eventManager.dispatchEvent(e);
				d.stopPropagation();
				d.preventDefault()
			}, !1));
			if (window.navigator.msPointerEnabled) {
				var d = {
					MSPointerDown: c.handleTouchesBegin,
					MSPointerMove: c.handleTouchesMove,
					MSPointerUp: c.handleTouchesEnd,
					MSPointerCancel: c.handleTouchesCancel
				},
					g;
				for (g in d) {
					(function(d, e) {
						cc._addEventListener(b, d, function(d) {
							var f = c.getHTMLElementPosition(b);
							f.left -= document.documentElement.scrollLeft;
							f.top -= document.documentElement.scrollTop;
							e.call(c, [c.getTouchByXY(d.clientX, d.clientY, f)]);
							d.stopPropagation()
						}, !1)
					})(g, d[g])
				}
			}
			e && (cc._addEventListener(b, "touchstart", function(d) {
				if (d.changedTouches) {
					var e = c.getHTMLElementPosition(b);
					e.left -= document.body.scrollLeft;
					e.top -= document.body.scrollTop;
					c.handleTouchesBegin(c.getTouchesByEvent(d, e));
					d.stopPropagation();
					d.preventDefault();
					b.focus()
				}
			}, !1), cc._addEventListener(b, "touchmove", function(d) {
				if (d.changedTouches) {
					var e = c.getHTMLElementPosition(b);
					e.left -= document.body.scrollLeft;
					e.top -= document.body.scrollTop;
					c.handleTouchesMove(c.getTouchesByEvent(d, e));
					d.stopPropagation();
					d.preventDefault()
				}
			}, !1), cc._addEventListener(b, "touchend", function(d) {
				if (d.changedTouches) {
					var e = c.getHTMLElementPosition(b);
					e.left -= document.body.scrollLeft;
					e.top -= document.body.scrollTop;
					c.handleTouchesEnd(c.getTouchesByEvent(d, e));
					d.stopPropagation();
					d.preventDefault()
				}
			}, !1), cc._addEventListener(b, "touchcancel", function(d) {
				if (d.changedTouches) {
					var e = c.getHTMLElementPosition(b);
					e.left -= document.body.scrollLeft;
					e.top -= document.body.scrollTop;
					c.handleTouchesCancel(c.getTouchesByEvent(d, e));
					d.stopPropagation();
					d.preventDefault()
				}
			}, !1));
			this._registerKeyboardEvent();
			this._registerAccelerometerEvent();
			this._isRegisterEvent = !0
		}
	},
	_registerKeyboardEvent: function() {},
	_registerAccelerometerEvent: function() {},
	update: function(b) {
		this._accelCurTime > this._accelInterval && (this._accelCurTime -= this._accelInterval, cc.eventManager.dispatchEvent(new cc.EventAcceleration(this._acceleration)));
		this._accelCurTime += b
	}
};
var _p = cc.inputManager;
_p.setAccelerometerEnabled = function(b) {
	this._accelEnabled !== b && (this._accelEnabled = b, b = cc.director.getScheduler(), this._accelCurTime = 0, b.scheduleUpdate(this))
};
_p.setAccelerometerInterval = function(b) {
	this._accelInterval !== b && (this._accelInterval = b)
};
_p._registerKeyboardEvent = function() {
	cc._addEventListener(cc._canvas, "keydown", function(b) {
		cc.eventManager.dispatchEvent(new cc.EventKeyboard(b.keyCode, !0));
		b.stopPropagation();
		b.preventDefault()
	}, !1);
	cc._addEventListener(cc._canvas, "keyup", function(b) {
		cc.eventManager.dispatchEvent(new cc.EventKeyboard(b.keyCode, !1));
		b.stopPropagation();
		b.preventDefault()
	}, !1)
};
_p._registerAccelerometerEvent = function() {
	var b = window;
	this._acceleration = new cc.Acceleration;
	this._accelDeviceEvent = b.DeviceMotionEvent || b.DeviceOrientationEvent;
	cc.sys.browserType === cc.sys.BROWSER_TYPE_MOBILE_QQ && (this._accelDeviceEvent = window.DeviceOrientationEvent);
	var c = this._accelDeviceEvent === b.DeviceMotionEvent ? "devicemotion" : "deviceorientation",
		d = navigator.userAgent;
	if (/Android/.test(d) || /Adr/.test(d) && cc.sys.browserType === cc.BROWSER_TYPE_UC) {
		this._minus = -1
	}
	cc._addEventListener(b, c, this.didAccelerate.bind(this), !1)
};
_p.didAccelerate = function(b) {
	var c = window;
	if (this._accelEnabled) {
		var d = this._acceleration,
			e, f, g;
		this._accelDeviceEvent === window.DeviceMotionEvent ? (g = b.accelerationIncludingGravity, e = this._accelMinus * g.x * 0.1, f = this._accelMinus * g.y * 0.1, g = 0.1 * g.z) : (e = b.gamma / 90 * 0.981, f = 0.981 * -(b.beta / 90), g = b.alpha / 90 * 0.981);
		cc.sys.os === cc.sys.OS_ANDROID ? (d.x = -e, d.y = -f) : (d.x = e, d.y = f);
		d.z = g;
		d.timestamp = b.timeStamp || Date.now();
		b = d.x;
		c.orientation === cc.UIInterfaceOrientationLandscapeRight ? (d.x = -d.y, d.y = b) : c.orientation === cc.UIInterfaceOrientationLandscapeLeft ? (d.x = d.y, d.y = -b) : c.orientation === cc.UIInterfaceOrientationPortraitUpsideDown && (d.x = -d.x, d.y = -d.y)
	}
};
delete _p;
cc.AffineTransform = function(b, c, d, e, f, g) {
	this.a = b;
	this.b = c;
	this.c = d;
	this.d = e;
	this.tx = f;
	this.ty = g
};
cc.affineTransformMake = function(b, c, d, e, f, g) {
	return {
		a: b,
		b: c,
		c: d,
		d: e,
		tx: f,
		ty: g
	}
};
cc.pointApplyAffineTransform = function(b, c, d) {
	var e;
	void 0 === d ? (d = c, e = b.x, b = b.y) : (e = b, b = c);
	return {
		x: d.a * e + d.c * b + d.tx,
		y: d.b * e + d.d * b + d.ty
	}
};
cc._pointApplyAffineTransform = function(b, c, d) {
	return cc.pointApplyAffineTransform(b, c, d)
};
cc.sizeApplyAffineTransform = function(b, c) {
	return {
		width: c.a * b.width + c.c * b.height,
		height: c.b * b.width + c.d * b.height
	}
};
cc.affineTransformMakeIdentity = function() {
	return {
		a: 1,
		b: 0,
		c: 0,
		d: 1,
		tx: 0,
		ty: 0
	}
};
cc.affineTransformIdentity = function() {
	return {
		a: 1,
		b: 0,
		c: 0,
		d: 1,
		tx: 0,
		ty: 0
	}
};
cc.rectApplyAffineTransform = function(b, c) {
	var d = cc.rectGetMinY(b),
		e = cc.rectGetMinX(b),
		f = cc.rectGetMaxX(b),
		g = cc.rectGetMaxY(b),
		h = cc.pointApplyAffineTransform(e, d, c),
		d = cc.pointApplyAffineTransform(f, d, c),
		e = cc.pointApplyAffineTransform(e, g, c),
		k = cc.pointApplyAffineTransform(f, g, c),
		f = Math.min(h.x, d.x, e.x, k.x),
		g = Math.max(h.x, d.x, e.x, k.x),
		m = Math.min(h.y, d.y, e.y, k.y),
		h = Math.max(h.y, d.y, e.y, k.y);
	return cc.rect(f, m, g - f, h - m)
};
cc._rectApplyAffineTransformIn = function(b, c) {
	var d = cc.rectGetMinY(b),
		e = cc.rectGetMinX(b),
		f = cc.rectGetMaxX(b),
		g = cc.rectGetMaxY(b),
		h = cc.pointApplyAffineTransform(e, d, c),
		d = cc.pointApplyAffineTransform(f, d, c),
		e = cc.pointApplyAffineTransform(e, g, c),
		k = cc.pointApplyAffineTransform(f, g, c),
		f = Math.min(h.x, d.x, e.x, k.x),
		g = Math.max(h.x, d.x, e.x, k.x),
		m = Math.min(h.y, d.y, e.y, k.y),
		h = Math.max(h.y, d.y, e.y, k.y);
	b.x = f;
	b.y = m;
	b.width = g - f;
	b.height = h - m;
	return b
};
cc.affineTransformTranslate = function(b, c, d) {
	return {
		a: b.a,
		b: b.b,
		c: b.c,
		d: b.d,
		tx: b.tx + b.a * c + b.c * d,
		ty: b.ty + b.b * c + b.d * d
	}
};
cc.affineTransformScale = function(b, c, d) {
	return {
		a: b.a * c,
		b: b.b * c,
		c: b.c * d,
		d: b.d * d,
		tx: b.tx,
		ty: b.ty
	}
};
cc.affineTransformRotate = function(b, c) {
	var d = Math.sin(c),
		e = Math.cos(c);
	return {
		a: b.a * e + b.c * d,
		b: b.b * e + b.d * d,
		c: b.c * e - b.a * d,
		d: b.d * e - b.b * d,
		tx: b.tx,
		ty: b.ty
	}
};
cc.affineTransformConcat = function(b, c) {
	return {
		a: b.a * c.a + b.b * c.c,
		b: b.a * c.b + b.b * c.d,
		c: b.c * c.a + b.d * c.c,
		d: b.c * c.b + b.d * c.d,
		tx: b.tx * c.a + b.ty * c.c + c.tx,
		ty: b.tx * c.b + b.ty * c.d + c.ty
	}
};
cc.affineTransformEqualToTransform = function(b, c) {
	return b.a === c.a && b.b === c.b && b.c === c.c && b.d === c.d && b.tx === c.tx && b.ty === c.ty
};
cc.affineTransformInvert = function(b) {
	var c = 1 / (b.a * b.d - b.b * b.c);
	return {
		a: c * b.d,
		b: -c * b.b,
		c: -c * b.c,
		d: c * b.a,
		tx: c * (b.c * b.ty - b.d * b.tx),
		ty: c * (b.b * b.tx - b.a * b.ty)
	}
};
cc.POINT_EPSILON = parseFloat("1.192092896e-07F");
cc.pNeg = function(b) {
	return cc.p(-b.x, -b.y)
};
cc.pAdd = function(b, c) {
	return cc.p(b.x + c.x, b.y + c.y)
};
cc.pSub = function(b, c) {
	return cc.p(b.x - c.x, b.y - c.y)
};
cc.pMult = function(b, c) {
	return cc.p(b.x * c, b.y * c)
};
cc.pMidpoint = function(b, c) {
	return cc.pMult(cc.pAdd(b, c), 0.5)
};
cc.pDot = function(b, c) {
	return b.x * c.x + b.y * c.y
};
cc.pCross = function(b, c) {
	return b.x * c.y - b.y * c.x
};
cc.pPerp = function(b) {
	return cc.p(-b.y, b.x)
};
cc.pRPerp = function(b) {
	return cc.p(b.y, -b.x)
};
cc.pProject = function(b, c) {
	return cc.pMult(c, cc.pDot(b, c) / cc.pDot(c, c))
};
cc.pRotate = function(b, c) {
	return cc.p(b.x * c.x - b.y * c.y, b.x * c.y + b.y * c.x)
};
cc.pUnrotate = function(b, c) {
	return cc.p(b.x * c.x + b.y * c.y, b.y * c.x - b.x * c.y)
};
cc.pLengthSQ = function(b) {
	return cc.pDot(b, b)
};
cc.pDistanceSQ = function(b, c) {
	return cc.pLengthSQ(cc.pSub(b, c))
};
cc.pLength = function(b) {
	return Math.sqrt(cc.pLengthSQ(b))
};
cc.pDistance = function(b, c) {
	return cc.pLength(cc.pSub(b, c))
};
cc.pNormalize = function(b) {
	var c = cc.pLength(b);
	return 0 === c ? cc.p(b) : cc.pMult(b, 1 / c)
};
cc.pForAngle = function(b) {
	return cc.p(Math.cos(b), Math.sin(b))
};
cc.pToAngle = function(b) {
	return Math.atan2(b.y, b.x)
};
cc.clampf = function(b, c, d) {
	if (c > d) {
		var e = c;
		c = d;
		d = e
	}
	return b < c ? c : b < d ? b : d
};
cc.pClamp = function(b, c, d) {
	return cc.p(cc.clampf(b.x, c.x, d.x), cc.clampf(b.y, c.y, d.y))
};
cc.pFromSize = function(b) {
	return cc.p(b.width, b.height)
};
cc.pCompOp = function(b, c) {
	return cc.p(c(b.x), c(b.y))
};
cc.pLerp = function(b, c, d) {
	return cc.pAdd(cc.pMult(b, 1 - d), cc.pMult(c, d))
};
cc.pFuzzyEqual = function(b, c, d) {
	return b.x - d <= c.x && c.x <= b.x + d && b.y - d <= c.y && c.y <= b.y + d ? !0 : !1
};
cc.pCompMult = function(b, c) {
	return cc.p(b.x * c.x, b.y * c.y)
};
cc.pAngleSigned = function(b, c) {
	var d = cc.pNormalize(b),
		e = cc.pNormalize(c),
		d = Math.atan2(d.x * e.y - d.y * e.x, cc.pDot(d, e));
	return Math.abs(d) < cc.POINT_EPSILON ? 0 : d
};
cc.pAngle = function(b, c) {
	var d = Math.acos(cc.pDot(cc.pNormalize(b), cc.pNormalize(c)));
	return Math.abs(d) < cc.POINT_EPSILON ? 0 : d
};
cc.pRotateByAngle = function(b, c, d) {
	b = cc.pSub(b, c);
	var e = Math.cos(d);
	d = Math.sin(d);
	var f = b.x;
	b.x = f * e - b.y * d + c.x;
	b.y = f * d + b.y * e + c.y;
	return b
};
cc.pLineIntersect = function(b, c, d, e, f) {
	if (b.x === c.x && b.y === c.y || d.x === e.x && d.y === e.y) {
		return !1
	}
	var g = c.x - b.x;
	c = c.y - b.y;
	var h = e.x - d.x;
	e = e.y - d.y;
	var k = b.x - d.x;
	b = b.y - d.y;
	d = e * g - h * c;
	f.x = h * b - e * k;
	f.y = g * b - c * k;
	if (0 === d) {
		return 0 === f.x || 0 === f.y ? !0 : !1
	}
	f.x /= d;
	f.y /= d;
	return !0
};
cc.pSegmentIntersect = function(b, c, d, e) {
	var f = cc.p(0, 0);
	return cc.pLineIntersect(b, c, d, e, f) && 0 <= f.x && 1 >= f.x && 0 <= f.y && 1 >= f.y ? !0 : !1
};
cc.pIntersectPoint = function(b, c, d, e) {
	var f = cc.p(0, 0);
	return cc.pLineIntersect(b, c, d, e, f) ? (d = cc.p(0, 0), d.x = b.x + f.x * (c.x - b.x), d.y = b.y + f.x * (c.y - b.y), d) : cc.p(0, 0)
};
cc.pSameAs = function(b, c) {
	return null != b && null != c ? b.x === c.x && b.y === c.y : !1
};
cc.pZeroIn = function(b) {
	b.x = 0;
	b.y = 0
};
cc.pIn = function(b, c) {
	b.x = c.x;
	b.y = c.y
};
cc.pMultIn = function(b, c) {
	b.x *= c;
	b.y *= c
};
cc.pSubIn = function(b, c) {
	b.x -= c.x;
	b.y -= c.y
};
cc.pAddIn = function(b, c) {
	b.x += c.x;
	b.y += c.y
};
cc.pNormalizeIn = function(b) {
	cc.pMultIn(b, 1 / Math.sqrt(b.x * b.x + b.y * b.y))
};
cc.vertexLineToPolygon = function(b, c, d, e, f) {
	f += e;
	if (!(1 >= f)) {
		c *= 0.5;
		for (var g, h = f - 1, k = e; k < f; k++) {
			g = 2 * k;
			var m = cc.p(b[2 * k], b[2 * k + 1]),
				n;
			if (0 === k) {
				n = cc.pPerp(cc.pNormalize(cc.pSub(m, cc.p(b[2 * (k + 1)], b[2 * (k + 1) + 1]))))
			} else {
				if (k === h) {
					n = cc.pPerp(cc.pNormalize(cc.pSub(cc.p(b[2 * (k - 1)], b[2 * (k - 1) + 1]), m)))
				} else {
					n = cc.p(b[2 * (k - 1)], b[2 * (k - 1) + 1]);
					var p = cc.p(b[2 * (k + 1)], b[2 * (k + 1) + 1]),
						r = cc.pNormalize(cc.pSub(p, m)),
						t = cc.pNormalize(cc.pSub(n, m)),
						s = Math.acos(cc.pDot(r, t));
					n = s < cc.degreesToRadians(70) ? cc.pPerp(cc.pNormalize(cc.pMidpoint(r, t))) : s < cc.degreesToRadians(170) ? cc.pNormalize(cc.pMidpoint(r, t)) : cc.pPerp(cc.pNormalize(cc.pSub(p, n)))
				}
			}
			n = cc.pMult(n, c);
			d[2 * g] = m.x + n.x;
			d[2 * g + 1] = m.y + n.y;
			d[2 * (g + 1)] = m.x - n.x;
			d[2 * (g + 1) + 1] = m.y - n.y
		}
		for (k = 0 === e ? 0 : e - 1; k < h; k++) {
			g = 2 * k, b = g + 2, c = cc.vertex2(d[2 * g], d[2 * g + 1]), f = cc.vertex2(d[2 * (g + 1)], d[2 * (g + 1) + 1]), g = cc.vertex2(d[2 * b], d[2 * b]), e = cc.vertex2(d[2 * (b + 1)], d[2 * (b + 1) + 1]), c = !cc.vertexLineIntersect(c.x, c.y, e.x, e.y, f.x, f.y, g.x, g.y), !c.isSuccess && (0 > c.value || 1 < c.value) && (c.isSuccess = !0), c.isSuccess && (d[2 * b] = e.x, d[2 * b + 1] = e.y, d[2 * (b + 1)] = g.x, d[2 * (b + 1) + 1] = g.y)
		}
	}
};
cc.vertexLineIntersect = function(b, c, d, e, f, g, h, k) {
	if (b === d && c === e || f === h && g === k) {
		return {
			isSuccess: !1,
			value: 0
		}
	}
	d -= b;
	e -= c;
	f -= b;
	g -= c;
	h -= b;
	k -= c;
	b = Math.sqrt(d * d + e * e);
	d /= b;
	e /= b;
	c = f * d + g * e;
	g = g * d - f * e;
	f = c;
	c = h * d + k * e;
	k = k * d - h * e;
	h = c;
	return g === k ? {
		isSuccess: !1,
		value: 0
	} : {
		isSuccess: !0,
		value: (h + (f - h) * k / (k - g)) / b
	}
};
cc.vertexListIsClockwise = function(b) {
	for (var c = 0, d = b.length; c < d; c++) {
		var e = b[(c + 1) % d],
			f = b[(c + 2) % d];
		if (0 < cc.pCross(cc.pSub(e, b[c]), cc.pSub(f, e))) {
			return !1
		}
	}
	return !0
};
cc.CGAffineToGL = function(b, c) {
	c[2] = c[3] = c[6] = c[7] = c[8] = c[9] = c[11] = c[14] = 0;
	c[10] = c[15] = 1;
	c[0] = b.a;
	c[4] = b.c;
	c[12] = b.tx;
	c[1] = b.b;
	c[5] = b.d;
	c[13] = b.ty
};
cc.GLToCGAffine = function(b, c) {
	c.a = b[0];
	c.c = b[4];
	c.tx = b[12];
	c.b = b[1];
	c.d = b[5];
	c.ty = b[13]
};
cc.Touch = cc.Class.extend({
	_point: null,
	_prevPoint: null,
	_id: 0,
	_startPointCaptured: !1,
	_startPoint: null,
	ctor: function(b, c, d) {
		this._point = cc.p(b || 0, c || 0);
		this._id = d || 0
	},
	getLocation: function() {
		return {
			x: this._point.x,
			y: this._point.y
		}
	},
	getLocationX: function() {
		return this._point.x
	},
	getLocationY: function() {
		return this._point.y
	},
	getPreviousLocation: function() {
		return {
			x: this._prevPoint.x,
			y: this._prevPoint.y
		}
	},
	getStartLocation: function() {
		return {
			x: this._startPoint.x,
			y: this._startPoint.y
		}
	},
	getDelta: function() {
		return cc.pSub(this._point, this._prevPoint)
	},
	getLocationInView: function() {
		return {
			x: this._point.x,
			y: this._point.y
		}
	},
	getPreviousLocationInView: function() {
		return {
			x: this._prevPoint.x,
			y: this._prevPoint.y
		}
	},
	getStartLocationInView: function() {
		return {
			x: this._startPoint.x,
			y: this._startPoint.y
		}
	},
	getID: function() {
		return this._id
	},
	getId: function() {
		cc.log("getId is deprecated. Please use getID instead.");
		return this._id
	},
	setTouchInfo: function(b, c, d) {
		this._prevPoint = this._point;
		this._point = cc.p(c || 0, d || 0);
		this._id = b;
		this._startPointCaptured || (this._startPoint = cc.p(this._point), this._startPointCaptured = !0)
	},
	_setPoint: function(b, c) {
		void 0 === c ? (this._point.x = b.x, this._point.y = b.y) : (this._point.x = b, this._point.y = c)
	},
	_setPrevPoint: function(b, c) {
		this._prevPoint = void 0 === c ? cc.p(b.x, b.y) : cc.p(b || 0, c || 0)
	}
});
cc.Event = cc.Class.extend({
	_type: 0,
	_isStopped: !1,
	_currentTarget: null,
	_setCurrentTarget: function(b) {
		this._currentTarget = b
	},
	ctor: function(b) {
		this._type = b
	},
	getType: function() {
		return this._type
	},
	stopPropagation: function() {
		this._isStopped = !0
	},
	isStopped: function() {
		return this._isStopped
	},
	getCurrentTarget: function() {
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
	_eventName: null,
	_userData: null,
	ctor: function(b) {
		cc.Event.prototype.ctor.call(this, cc.Event.CUSTOM);
		this._eventName = b
	},
	setUserData: function(b) {
		this._userData = b
	},
	getUserData: function() {
		return this._userData
	},
	getEventName: function() {
		return this._eventName
	}
});
cc.EventMouse = cc.Event.extend({
	_eventType: 0,
	_button: 0,
	_x: 0,
	_y: 0,
	_prevX: 0,
	_prevY: 0,
	_scrollX: 0,
	_scrollY: 0,
	ctor: function(b) {
		cc.Event.prototype.ctor.call(this, cc.Event.MOUSE);
		this._eventType = b
	},
	setScrollData: function(b, c) {
		this._scrollX = b;
		this._scrollY = c
	},
	getScrollX: function() {
		return this._scrollX
	},
	getScrollY: function() {
		return this._scrollY
	},
	setLocation: function(b, c) {
		this._x = b;
		this._y = c
	},
	getLocation: function() {
		return {
			x: this._x,
			y: this._y
		}
	},
	getLocationInView: function() {
		return {
			x: this._x,
			y: cc.view._designResolutionSize.height - this._y
		}
	},
	_setPrevCursor: function(b, c) {
		this._prevX = b;
		this._prevY = c
	},
	getDelta: function() {
		return {
			x: this._x - this._prevX,
			y: this._y - this._prevY
		}
	},
	getDeltaX: function() {
		return this._x - this._prevX
	},
	getDeltaY: function() {
		return this._y - this._prevY
	},
	setButton: function(b) {
		this._button = b
	},
	getButton: function() {
		return this._button
	},
	getLocationX: function() {
		return this._x
	},
	getLocationY: function() {
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
	_eventCode: 0,
	_touches: null,
	ctor: function(b) {
		cc.Event.prototype.ctor.call(this, cc.Event.TOUCH);
		this._touches = b || []
	},
	getEventCode: function() {
		return this._eventCode
	},
	getTouches: function() {
		return this._touches
	},
	_setEventCode: function(b) {
		this._eventCode = b
	},
	_setTouches: function(b) {
		this._touches = b
	}
});
cc.EventTouch.MAX_TOUCHES = 5;
cc.EventTouch.EventCode = {
	BEGAN: 0,
	MOVED: 1,
	ENDED: 2,
	CANCELLED: 3
};
cc.EventFocus = cc.Event.extend({
	_widgetGetFocus: null,
	_widgetLoseFocus: null,
	ctor: function(b, c) {
		cc.Event.prototype.ctor.call(this, cc.Event.FOCUS);
		this._widgetGetFocus = c;
		this._widgetLoseFocus = b
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
	ctor: function(b, c, d) {
		this._onEvent = d;
		this._type = b || 0;
		this._listenerID = c || ""
	},
	_setPaused: function(b) {
		this._paused = b
	},
	_isPaused: function() {
		return this._paused
	},
	_setRegistered: function(b) {
		this._registered = b
	},
	_isRegistered: function() {
		return this._registered
	},
	_getType: function() {
		return this._type
	},
	_getListenerID: function() {
		return this._listenerID
	},
	_setFixedPriority: function(b) {
		this._fixedPriority = b
	},
	_getFixedPriority: function() {
		return this._fixedPriority
	},
	_setSceneGraphPriority: function(b) {
		this._node = b
	},
	_getSceneGraphPriority: function() {
		return this._node
	},
	checkAvailable: function() {
		return null !== this._onEvent
	},
	clone: function() {
		return null
	},
	setEnabled: function(b) {
		this._isEnabled = b
	},
	isEnabled: function() {
		return this._isEnabled
	},
	retain: function() {},
	release: function() {}
});
cc.EventListener.UNKNOWN = 0;
cc.EventListener.TOUCH_ONE_BY_ONE = 1;
cc.EventListener.TOUCH_ALL_AT_ONCE = 2;
cc.EventListener.KEYBOARD = 3;
cc.EventListener.MOUSE = 4;
cc.EventListener.ACCELERATION = 5;
cc.EventListener.ACCELERATION = 6;
cc.EventListener.CUSTOM = 8;
cc.EventListener.FOCUS = 7;
cc._EventListenerCustom = cc.EventListener.extend({
	_onCustomEvent: null,
	ctor: function(b, c) {
		this._onCustomEvent = c;
		var d = this;
		cc.EventListener.prototype.ctor.call(this, cc.EventListener.CUSTOM, b, function(b) {
			null !== d._onCustomEvent && d._onCustomEvent(b)
		})
	},
	checkAvailable: function() {
		return cc.EventListener.prototype.checkAvailable.call(this) && null !== this._onCustomEvent
	},
	clone: function() {
		return new cc._EventListenerCustom(this._listenerID, this._onCustomEvent)
	}
});
cc._EventListenerCustom.create = function(b, c) {
	return new cc._EventListenerCustom(b, c)
};
cc._EventListenerMouse = cc.EventListener.extend({
	onMouseDown: null,
	onMouseUp: null,
	onMouseMove: null,
	onMouseScroll: null,
	ctor: function() {
		var b = this;
		cc.EventListener.prototype.ctor.call(this, cc.EventListener.MOUSE, cc._EventListenerMouse.LISTENER_ID, function(c) {
			var d = cc.EventMouse;
			switch (c._eventType) {
			case d.DOWN:
				if (b.onMouseDown) {
					b.onMouseDown(c)
				}
				break;
			case d.UP:
				if (b.onMouseUp) {
					b.onMouseUp(c)
				}
				break;
			case d.MOVE:
				if (b.onMouseMove) {
					b.onMouseMove(c)
				}
				break;
			case d.SCROLL:
				if (b.onMouseScroll) {
					b.onMouseScroll(c)
				}
			}
		})
	},
	clone: function() {
		var b = new cc._EventListenerMouse;
		b.onMouseDown = this.onMouseDown;
		b.onMouseUp = this.onMouseUp;
		b.onMouseMove = this.onMouseMove;
		b.onMouseScroll = this.onMouseScroll;
		return b
	},
	checkAvailable: function() {
		return !0
	}
});
cc._EventListenerMouse.LISTENER_ID = "__cc_mouse";
cc._EventListenerMouse.create = function() {
	return new cc._EventListenerMouse
};
cc._EventListenerTouchOneByOne = cc.EventListener.extend({
	_claimedTouches: null,
	swallowTouches: !1,
	onTouchBegan: null,
	onTouchMoved: null,
	onTouchEnded: null,
	onTouchCancelled: null,
	ctor: function() {
		cc.EventListener.prototype.ctor.call(this, cc.EventListener.TOUCH_ONE_BY_ONE, cc._EventListenerTouchOneByOne.LISTENER_ID, null);
		this._claimedTouches = []
	},
	setSwallowTouches: function(b) {
		this.swallowTouches = b
	},
	isSwallowTouches: function() {
		return this.swallowTouches
	},
	clone: function() {
		var b = new cc._EventListenerTouchOneByOne;
		b.onTouchBegan = this.onTouchBegan;
		b.onTouchMoved = this.onTouchMoved;
		b.onTouchEnded = this.onTouchEnded;
		b.onTouchCancelled = this.onTouchCancelled;
		b.swallowTouches = this.swallowTouches;
		return b
	},
	checkAvailable: function() {
		return this.onTouchBegan ? !0 : (cc.log(cc._LogInfos._EventListenerTouchOneByOne_checkAvailable), !1)
	}
});
cc._EventListenerTouchOneByOne.LISTENER_ID = "__cc_touch_one_by_one";
cc._EventListenerTouchOneByOne.create = function() {
	return new cc._EventListenerTouchOneByOne
};
cc._EventListenerTouchAllAtOnce = cc.EventListener.extend({
	onTouchesBegan: null,
	onTouchesMoved: null,
	onTouchesEnded: null,
	onTouchesCancelled: null,
	ctor: function() {
		cc.EventListener.prototype.ctor.call(this, cc.EventListener.TOUCH_ALL_AT_ONCE, cc._EventListenerTouchAllAtOnce.LISTENER_ID, null)
	},
	clone: function() {
		var b = new cc._EventListenerTouchAllAtOnce;
		b.onTouchesBegan = this.onTouchesBegan;
		b.onTouchesMoved = this.onTouchesMoved;
		b.onTouchesEnded = this.onTouchesEnded;
		b.onTouchesCancelled = this.onTouchesCancelled;
		return b
	},
	checkAvailable: function() {
		return null === this.onTouchesBegan && null === this.onTouchesMoved && null === this.onTouchesEnded && null === this.onTouchesCancelled ? (cc.log(cc._LogInfos._EventListenerTouchAllAtOnce_checkAvailable), !1) : !0
	}
});
cc._EventListenerTouchAllAtOnce.LISTENER_ID = "__cc_touch_all_at_once";
cc._EventListenerTouchAllAtOnce.create = function() {
	return new cc._EventListenerTouchAllAtOnce
};
cc.EventListener.create = function(b) {
	cc.assert(b && b.event, cc._LogInfos.EventListener_create);
	var c = b.event;
	delete b.event;
	var d = null;
	c === cc.EventListener.TOUCH_ONE_BY_ONE ? d = new cc._EventListenerTouchOneByOne : c === cc.EventListener.TOUCH_ALL_AT_ONCE ? d = new cc._EventListenerTouchAllAtOnce : c === cc.EventListener.MOUSE ? d = new cc._EventListenerMouse : c === cc.EventListener.CUSTOM ? (d = new cc._EventListenerCustom(b.eventName, b.callback), delete b.eventName, delete b.callback) : c === cc.EventListener.KEYBOARD ? d = new cc._EventListenerKeyboard : c === cc.EventListener.ACCELERATION ? (d = new cc._EventListenerAcceleration(b.callback), delete b.callback) : c === cc.EventListener.FOCUS && (d = new cc._EventListenerFocus);
	for (var e in b) {
		d[e] = b[e]
	}
	return d
};
cc._EventListenerFocus = cc.EventListener.extend({
	clone: function() {
		var b = new cc._EventListenerFocus;
		b.onFocusChanged = this.onFocusChanged;
		return b
	},
	checkAvailable: function() {
		return this.onFocusChanged ? !0 : (cc.log("Invalid EventListenerFocus!"), !1)
	},
	onFocusChanged: null,
	ctor: function() {
		cc.EventListener.prototype.ctor.call(this, cc.EventListener.FOCUS, cc._EventListenerFocus.LISTENER_ID, function(b) {
			if (this.onFocusChanged) {
				this.onFocusChanged(b._widgetLoseFocus, b._widgetGetFocus)
			}
		})
	}
});
cc._EventListenerFocus.LISTENER_ID = "__cc_focus_event";
cc._EventListenerVector = cc.Class.extend({
	_fixedListeners: null,
	_sceneGraphListeners: null,
	gt0Index: 0,
	ctor: function() {
		this._fixedListeners = [];
		this._sceneGraphListeners = []
	},
	size: function() {
		return this._fixedListeners.length + this._sceneGraphListeners.length
	},
	empty: function() {
		return 0 === this._fixedListeners.length && 0 === this._sceneGraphListeners.length
	},
	push: function(b) {
		0 === b._getFixedPriority() ? this._sceneGraphListeners.push(b) : this._fixedListeners.push(b)
	},
	clearSceneGraphListeners: function() {
		this._sceneGraphListeners.length = 0
	},
	clearFixedListeners: function() {
		this._fixedListeners.length = 0
	},
	clear: function() {
		this._sceneGraphListeners.length = 0;
		this._fixedListeners.length = 0
	},
	getFixedPriorityListeners: function() {
		return this._fixedListeners
	},
	getSceneGraphPriorityListeners: function() {
		return this._sceneGraphListeners
	}
});
cc.__getListenerID = function(b) {
	var c = cc.Event,
		d = b.getType();
	if (d === c.ACCELERATION) {
		return cc._EventListenerAcceleration.LISTENER_ID
	}
	if (d === c.CUSTOM) {
		return b.getEventName()
	}
	if (d === c.KEYBOARD) {
		return cc._EventListenerKeyboard.LISTENER_ID
	}
	if (d === c.MOUSE) {
		return cc._EventListenerMouse.LISTENER_ID
	}
	if (d === c.FOCUS) {
		return cc._EventListenerFocus.LISTENER_ID
	}
	d === c.TOUCH && cc.log(cc._LogInfos.__getListenerID);
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
	_dirtyNodes: [],
	_inDispatch: 0,
	_isEnabled: !1,
	_nodePriorityIndex: 0,
	_internalCustomListenerIDs: [cc.game.EVENT_HIDE, cc.game.EVENT_SHOW],
	_setDirtyForNode: function(b) {
		null != this._nodeListenersMap[b.__instanceId] && this._dirtyNodes.push(b);
		b = b.getChildren();
		for (var c = 0, d = b.length; c < d; c++) {
			this._setDirtyForNode(b[c])
		}
	},
	pauseTarget: function(b, c) {
		var d = this._nodeListenersMap[b.__instanceId],
			e, f;
		if (d) {
			for (e = 0, f = d.length; e < f; e++) {
				d[e]._setPaused(!0)
			}
		}
		if (!0 === c) {
			for (d = b.getChildren(), e = 0, f = d.length; e < f; e++) {
				this.pauseTarget(d[e], !0)
			}
		}
	},
	resumeTarget: function(b, c) {
		var d = this._nodeListenersMap[b.__instanceId],
			e, f;
		if (d) {
			for (e = 0, f = d.length; e < f; e++) {
				d[e]._setPaused(!1)
			}
		}
		this._setDirtyForNode(b);
		if (!0 === c) {
			for (d = b.getChildren(), e = 0, f = d.length; e < f; e++) {
				this.resumeTarget(d[e], !0)
			}
		}
	},
	_addListener: function(b) {
		0 === this._inDispatch ? this._forceAddEventListener(b) : this._toAddedListeners.push(b)
	},
	_forceAddEventListener: function(b) {
		var c = b._getListenerID(),
			d = this._listenersMap[c];
		d || (d = new cc._EventListenerVector, this._listenersMap[c] = d);
		d.push(b);
		0 === b._getFixedPriority() ? (this._setDirty(c, this.DIRTY_SCENE_GRAPH_PRIORITY), c = b._getSceneGraphPriority(), null === c && cc.log(cc._LogInfos.eventManager__forceAddEventListener), this._associateNodeAndEventListener(c, b), c.isRunning() && this.resumeTarget(c)) : this._setDirty(c, this.DIRTY_FIXED_PRIORITY)
	},
	_getListeners: function(b) {
		return this._listenersMap[b]
	},
	_updateDirtyFlagForSceneGraph: function() {
		if (0 !== this._dirtyNodes.length) {
			for (var b = this._dirtyNodes, c, d, e = this._nodeListenersMap, f = 0, g = b.length; f < g; f++) {
				if (c = e[b[f].__instanceId]) {
					for (var h = 0, k = c.length; h < k; h++) {
						(d = c[h]) && this._setDirty(d._getListenerID(), this.DIRTY_SCENE_GRAPH_PRIORITY)
					}
				}
			}
			this._dirtyNodes.length = 0
		}
	},
	_removeAllListenersInVector: function(b) {
		if (b) {
			for (var c, d = 0; d < b.length;) {
				c = b[d], c._setRegistered(!1), null != c._getSceneGraphPriority() && (this._dissociateNodeAndEventListener(c._getSceneGraphPriority(), c), c._setSceneGraphPriority(null)), 0 === this._inDispatch ? cc.arrayRemoveObject(b, c) : ++d
			}
		}
	},
	_removeListenersForListenerID: function(b) {
		var c = this._listenersMap[b];
		if (c) {
			var d = c.getFixedPriorityListeners(),
				e = c.getSceneGraphPriorityListeners();
			this._removeAllListenersInVector(e);
			this._removeAllListenersInVector(d);
			delete this._priorityDirtyFlagMap[b];
			this._inDispatch || (c.clear(), delete this._listenersMap[b])
		}
		d = this._toAddedListeners;
		for (c = 0; c < d.length;) {
			(e = d[c]) && e._getListenerID() === b ? cc.arrayRemoveObject(d, e) : ++c
		}
	},
	_sortEventListeners: function(b) {
		var c = this.DIRTY_NONE,
			d = this._priorityDirtyFlagMap;
		d[b] && (c = d[b]);
		c !== this.DIRTY_NONE && (d[b] = this.DIRTY_NONE, c & this.DIRTY_FIXED_PRIORITY && this._sortListenersOfFixedPriority(b), c & this.DIRTY_SCENE_GRAPH_PRIORITY && ((c = cc.director.getRunningScene()) ? this._sortListenersOfSceneGraphPriority(b, c) : d[b] = this.DIRTY_SCENE_GRAPH_PRIORITY))
	},
	_sortListenersOfSceneGraphPriority: function(b, c) {
		var d = this._getListeners(b);
		if (d) {
			var e = d.getSceneGraphPriorityListeners();
			e && 0 !== e.length && (this._nodePriorityIndex = 0, this._nodePriorityMap = {}, this._visitTarget(c, !0), d.getSceneGraphPriorityListeners().sort(this._sortEventListenersOfSceneGraphPriorityDes))
		}
	},
	_sortEventListenersOfSceneGraphPriorityDes: function(b, c) {
		var d = cc.eventManager._nodePriorityMap,
			e = b._getSceneGraphPriority(),
			f = c._getSceneGraphPriority();
		return b && c && e && f && d[e.__instanceId] && d[f.__instanceId] ? d[c._getSceneGraphPriority().__instanceId] - d[b._getSceneGraphPriority().__instanceId] : -1
	},
	_sortListenersOfFixedPriority: function(b) {
		if (b = this._listenersMap[b]) {
			var c = b.getFixedPriorityListeners();
			if (c && 0 !== c.length) {
				c.sort(this._sortListenersOfFixedPriorityAsc);
				for (var d = 0, e = c.length; d < e && !(0 <= c[d]._getFixedPriority());) {
					++d
				}
				b.gt0Index = d
			}
		}
	},
	_sortListenersOfFixedPriorityAsc: function(b, c) {
		return b._getFixedPriority() - c._getFixedPriority()
	},
	_onUpdateListeners: function(b) {
		if (b = this._listenersMap[b]) {
			var c = b.getFixedPriorityListeners(),
				d = b.getSceneGraphPriorityListeners(),
				e, f;
			if (d) {
				for (e = 0; e < d.length;) {
					f = d[e], f._isRegistered() ? ++e : cc.arrayRemoveObject(d, f)
				}
			}
			if (c) {
				for (e = 0; e < c.length;) {
					f = c[e], f._isRegistered() ? ++e : cc.arrayRemoveObject(c, f)
				}
			}
			d && 0 === d.length && b.clearSceneGraphListeners();
			c && 0 === c.length && b.clearFixedListeners()
		}
	},
	_updateListeners: function(b) {
		var c = this._inDispatch;
		cc.assert(0 < c, cc._LogInfos.EventManager__updateListeners);
		if (!(1 < c)) {
			b.getType() === cc.Event.TOUCH ? (this._onUpdateListeners(cc._EventListenerTouchOneByOne.LISTENER_ID), this._onUpdateListeners(cc._EventListenerTouchAllAtOnce.LISTENER_ID)) : this._onUpdateListeners(cc.__getListenerID(b));
			cc.assert(1 === c, cc._LogInfos.EventManager__updateListeners_2);
			b = this._listenersMap;
			var c = this._priorityDirtyFlagMap,
				d;
			for (d in b) {
				b[d].empty() && (delete c[d], delete b[d])
			}
			d = this._toAddedListeners;
			if (0 !== d.length) {
				b = 0;
				for (c = d.length; b < c; b++) {
					this._forceAddEventListener(d[b])
				}
				this._toAddedListeners.length = 0
			}
		}
	},
	_onTouchEventCallback: function(b, c) {
		if (!b._isRegistered) {
			return !1
		}
		var d = c.event,
			e = c.selTouch;
		d._setCurrentTarget(b._node);
		var f = !1,
			g, h = d.getEventCode(),
			k = cc.EventTouch.EventCode;
		if (h === k.BEGAN) {
			b.onTouchBegan && (f = b.onTouchBegan(e, d)) && b._registered && b._claimedTouches.push(e)
		} else {
			if (0 < b._claimedTouches.length && -1 !== (g = b._claimedTouches.indexOf(e))) {
				if (f = !0, h === k.MOVED && b.onTouchMoved) {
					b.onTouchMoved(e, d)
				} else {
					if (h === k.ENDED) {
						if (b.onTouchEnded) {
							b.onTouchEnded(e, d)
						}
						b._registered && b._claimedTouches.splice(g, 1)
					} else {
						if (h === k.CANCELLED) {
							if (b.onTouchCancelled) {
								b.onTouchCancelled(e, d)
							}
							b._registered && b._claimedTouches.splice(g, 1)
						}
					}
				}
			}
		}
		return d.isStopped() ? (cc.eventManager._updateListeners(d), !0) : f && b._registered && b.swallowTouches ? (c.needsMutableSet && c.touches.splice(e, 1), !0) : !1
	},
	_dispatchTouchEvent: function(b) {
		this._sortEventListeners(cc._EventListenerTouchOneByOne.LISTENER_ID);
		this._sortEventListeners(cc._EventListenerTouchAllAtOnce.LISTENER_ID);
		var c = this._getListeners(cc._EventListenerTouchOneByOne.LISTENER_ID),
			d = this._getListeners(cc._EventListenerTouchAllAtOnce.LISTENER_ID);
		if (null !== c || null !== d) {
			var e = b.getTouches(),
				f = cc.copyArray(e),
				g = {
					event: b,
					needsMutableSet: c && d,
					touches: f,
					selTouch: null
				};
			if (c) {
				for (var h = 0; h < e.length; h++) {
					if (g.selTouch = e[h], this._dispatchEventToListeners(c, this._onTouchEventCallback, g), b.isStopped()) {
						return
					}
				}
			}
			if (d && 0 < f.length && (this._dispatchEventToListeners(d, this._onTouchesEventCallback, {
				event: b,
				touches: f
			}), b.isStopped())) {
				return
			}
			this._updateListeners(b)
		}
	},
	_onTouchesEventCallback: function(b, c) {
		if (!b._registered) {
			return !1
		}
		var d = cc.EventTouch.EventCode,
			e = c.event,
			f = c.touches,
			g = e.getEventCode();
		e._setCurrentTarget(b._node);
		if (g === d.BEGAN && b.onTouchesBegan) {
			b.onTouchesBegan(f, e)
		} else {
			if (g === d.MOVED && b.onTouchesMoved) {
				b.onTouchesMoved(f, e)
			} else {
				if (g === d.ENDED && b.onTouchesEnded) {
					b.onTouchesEnded(f, e)
				} else {
					if (g === d.CANCELLED && b.onTouchesCancelled) {
						b.onTouchesCancelled(f, e)
					}
				}
			}
		}
		return e.isStopped() ? (cc.eventManager._updateListeners(e), !0) : !1
	},
	_associateNodeAndEventListener: function(b, c) {
		var d = this._nodeListenersMap[b.__instanceId];
		d || (d = [], this._nodeListenersMap[b.__instanceId] = d);
		d.push(c)
	},
	_dissociateNodeAndEventListener: function(b, c) {
		var d = this._nodeListenersMap[b.__instanceId];
		d && (cc.arrayRemoveObject(d, c), 0 === d.length && delete this._nodeListenersMap[b.__instanceId])
	},
	_dispatchEventToListeners: function(b, c, d) {
		var e = !1,
			f = b.getFixedPriorityListeners(),
			g = b.getSceneGraphPriorityListeners(),
			h = 0,
			k;
		if (f && 0 !== f.length) {
			for (; h < b.gt0Index; ++h) {
				if (k = f[h], k.isEnabled() && !k._isPaused() && k._isRegistered() && c(k, d)) {
					e = !0;
					break
				}
			}
		}
		if (g && !e) {
			for (b = 0; b < g.length; b++) {
				if (k = g[b], k.isEnabled() && !k._isPaused() && k._isRegistered() && c(k, d)) {
					e = !0;
					break
				}
			}
		}
		if (f && !e) {
			for (; h < f.length && (k = f[h], !k.isEnabled() || k._isPaused() || !k._isRegistered() || !c(k, d)); ++h) {}
		}
	},
	_setDirty: function(b, c) {
		var d = this._priorityDirtyFlagMap;
		d[b] = null == d[b] ? c : c | d[b]
	},
	_visitTarget: function(b, c) {
		var d = b.getChildren(),
			e = 0,
			f = d.length,
			g = this._globalZOrderNodeMap,
			h = this._nodeListenersMap;
		if (0 < f) {
			for (var k; e < f; e++) {
				if ((k = d[e]) && 0 > k.getLocalZOrder()) {
					this._visitTarget(k, !1)
				} else {
					break
				}
			}
			null != h[b.__instanceId] && (g[b.getGlobalZOrder()] || (g[b.getGlobalZOrder()] = []), g[b.getGlobalZOrder()].push(b.__instanceId));
			for (; e < f; e++) {
				(k = d[e]) && this._visitTarget(k, !1)
			}
		} else {
			null != h[b.__instanceId] && (g[b.getGlobalZOrder()] || (g[b.getGlobalZOrder()] = []), g[b.getGlobalZOrder()].push(b.__instanceId))
		}
		if (c) {
			var d = [],
				m;
			for (m in g) {
				d.push(m)
			}
			d.sort(this._sortNumberAsc);
			m = d.length;
			k = this._nodePriorityMap;
			for (e = 0; e < m; e++) {
				for (f = g[d[e]], h = 0; h < f.length; h++) {
					k[f[h]] = ++this._nodePriorityIndex
				}
			}
			this._globalZOrderNodeMap = {}
		}
	},
	_sortNumberAsc: function(b, c) {
		return b - c
	},
	addListener: function(b, c) {
		cc.assert(b && c, cc._LogInfos.eventManager_addListener_2);
		if (!(b instanceof cc.EventListener)) {
			cc.assert(!cc.isNumber(c), cc._LogInfos.eventManager_addListener_3), b = cc.EventListener.create(b)
		} else {
			if (b._isRegistered()) {
				cc.log(cc._LogInfos.eventManager_addListener_4);
				return
			}
		}
		if (b.checkAvailable()) {
			if (cc.isNumber(c)) {
				if (0 === c) {
					cc.log(cc._LogInfos.eventManager_addListener);
					return
				}
				b._setSceneGraphPriority(null);
				b._setFixedPriority(c);
				b._setRegistered(!0);
				b._setPaused(!1)
			} else {
				b._setSceneGraphPriority(c), b._setFixedPriority(0), b._setRegistered(!0)
			}
			this._addListener(b);
			return b
		}
	},
	addCustomListener: function(b, c) {
		var d = new cc._EventListenerCustom(b, c);
		this.addListener(d, 1);
		return d
	},
	removeListener: function(b) {
		if (null != b) {
			var c, d = this._listenersMap,
				e;
			for (e in d) {
				var f = d[e],
					g = f.getFixedPriorityListeners();
				c = f.getSceneGraphPriorityListeners();
				(c = this._removeListenerInVector(c, b)) ? this._setDirty(b._getListenerID(), this.DIRTY_SCENE_GRAPH_PRIORITY) : (c = this._removeListenerInVector(g, b)) && this._setDirty(b._getListenerID(), this.DIRTY_FIXED_PRIORITY);
				f.empty() && (delete this._priorityDirtyFlagMap[b._getListenerID()], delete d[e]);
				if (c) {
					break
				}
			}
			if (!c) {
				for (d = this._toAddedListeners, e = 0, f = d.length; e < f; e++) {
					if (g = d[e], g === b) {
						cc.arrayRemoveObject(d, g);
						g._setRegistered(!1);
						break
					}
				}
			}
		}
	},
	_removeListenerInVector: function(b, c) {
		if (null == b) {
			return !1
		}
		for (var d = 0, e = b.length; d < e; d++) {
			var f = b[d];
			if (f === c) {
				return f._setRegistered(!1), null != f._getSceneGraphPriority() && (this._dissociateNodeAndEventListener(f._getSceneGraphPriority(), f), f._setSceneGraphPriority(null)), 0 === this._inDispatch && cc.arrayRemoveObject(b, f), !0
			}
		}
		return !1
	},
	removeListeners: function(b, c) {
		if (b instanceof cc.Node) {
			delete this._nodePriorityMap[b.__instanceId];
			cc.arrayRemoveObject(this._dirtyNodes, b);
			var d = this._nodeListenersMap[b.__instanceId];
			if (d) {
				for (var e = cc.copyArray(d), d = 0; d < e.length; d++) {
					this.removeListener(e[d])
				}
				e.length = 0
			}
			e = this._toAddedListeners;
			for (d = 0; d < e.length;) {
				var f = e[d];
				f._getSceneGraphPriority() === b ? (f._setSceneGraphPriority(null), f._setRegistered(!1), e.splice(d, 1)) : ++d
			}
			if (!0 === c) {
				for (e = b.getChildren(), d = 0, f = e.length; d < f; d++) {
					this.removeListeners(e[d], !0)
				}
			}
		} else {
			b === cc.EventListener.TOUCH_ONE_BY_ONE ? this._removeListenersForListenerID(cc._EventListenerTouchOneByOne.LISTENER_ID) : b === cc.EventListener.TOUCH_ALL_AT_ONCE ? this._removeListenersForListenerID(cc._EventListenerTouchAllAtOnce.LISTENER_ID) : b === cc.EventListener.MOUSE ? this._removeListenersForListenerID(cc._EventListenerMouse.LISTENER_ID) : b === cc.EventListener.ACCELERATION ? this._removeListenersForListenerID(cc._EventListenerAcceleration.LISTENER_ID) : b === cc.EventListener.KEYBOARD ? this._removeListenersForListenerID(cc._EventListenerKeyboard.LISTENER_ID) : cc.log(cc._LogInfos.eventManager_removeListeners)
		}
	},
	removeCustomListeners: function(b) {
		this._removeListenersForListenerID(b)
	},
	removeAllListeners: function() {
		var b = this._listenersMap,
			c = this._internalCustomListenerIDs,
			d;
		for (d in b) {
			-1 === c.indexOf(d) && this._removeListenersForListenerID(d)
		}
	},
	setPriority: function(b, c) {
		if (null != b) {
			var d = this._listenersMap,
				e;
			for (e in d) {
				var f = d[e].getFixedPriorityListeners();
				if (f && -1 !== f.indexOf(b)) {
					null != b._getSceneGraphPriority() && cc.log(cc._LogInfos.eventManager_setPriority);
					b._getFixedPriority() !== c && (b._setFixedPriority(c), this._setDirty(b._getListenerID(), this.DIRTY_FIXED_PRIORITY));
					break
				}
			}
		}
	},
	setEnabled: function(b) {
		this._isEnabled = b
	},
	isEnabled: function() {
		return this._isEnabled
	},
	dispatchEvent: function(b) {
		if (this._isEnabled) {
			this._updateDirtyFlagForSceneGraph();
			this._inDispatch++;
			if (!b || !b.getType) {
				throw "event is undefined"
			}
			if (b.getType() === cc.Event.TOUCH) {
				this._dispatchTouchEvent(b)
			} else {
				var c = cc.__getListenerID(b);
				this._sortEventListeners(c);
				c = this._listenersMap[c];
				null != c && this._dispatchEventToListeners(c, this._onListenerCallback, b);
				this._updateListeners(b)
			}
			this._inDispatch--
		}
	},
	_onListenerCallback: function(b, c) {
		c._setCurrentTarget(b._getSceneGraphPriority());
		b._onEvent(c);
		return c.isStopped()
	},
	dispatchCustomEvent: function(b, c) {
		var d = new cc.EventCustom(b);
		d.setUserData(c);
		this.dispatchEvent(d)
	}
};
cc.EventHelper = function() {};
cc.EventHelper.prototype = {
	constructor: cc.EventHelper,
	apply: function(b) {
		b.addEventListener = cc.EventHelper.prototype.addEventListener;
		b.hasEventListener = cc.EventHelper.prototype.hasEventListener;
		b.removeEventListener = cc.EventHelper.prototype.removeEventListener;
		b.dispatchEvent = cc.EventHelper.prototype.dispatchEvent
	},
	addEventListener: function(b, c, d) {
		if ("load" === b && this._textureLoaded) {
			setTimeout(function() {
				c.call(d)
			}, 0)
		} else {
			void 0 === this._listeners && (this._listeners = {});
			var e = this._listeners;
			void 0 === e[b] && (e[b] = []);
			this.hasEventListener(b, c, d) || e[b].push({
				callback: c,
				eventTarget: d
			})
		}
	},
	hasEventListener: function(b, c, d) {
		if (void 0 === this._listeners) {
			return !1
		}
		var e = this._listeners;
		if (void 0 !== e[b]) {
			b = 0;
			for (var f = e.length; b < f; b++) {
				var g = e[b];
				if (g.callback === c && g.eventTarget === d) {
					return !0
				}
			}
		}
		return !1
	},
	removeEventListener: function(b, c) {
		if (void 0 !== this._listeners) {
			var d = this._listeners[b];
			if (void 0 !== d) {
				for (var e = 0; e < d.length;) {
					d[e].eventTarget === c ? d.splice(e, 1) : e++
				}
			}
		}
	},
	dispatchEvent: function(b, c) {
		if (void 0 !== this._listeners) {
			null == c && (c = !0);
			var d = this._listeners[b];
			if (void 0 !== d) {
				for (var e = [], f = d.length, g = 0; g < f; g++) {
					e[g] = d[g]
				}
				for (g = 0; g < f; g++) {
					e[g].callback.call(e[g].eventTarget, this)
				}
				c && (d.length = 0)
			}
		}
	}
};
cc.EventAcceleration = cc.Event.extend({
	_acc: null,
	ctor: function(b) {
		cc.Event.prototype.ctor.call(this, cc.Event.ACCELERATION);
		this._acc = b
	}
});
cc.EventKeyboard = cc.Event.extend({
	_keyCode: 0,
	_isPressed: !1,
	ctor: function(b, c) {
		cc.Event.prototype.ctor.call(this, cc.Event.KEYBOARD);
		this._keyCode = b;
		this._isPressed = c
	}
});
cc._EventListenerAcceleration = cc.EventListener.extend({
	_onAccelerationEvent: null,
	ctor: function(b) {
		this._onAccelerationEvent = b;
		var c = this;
		cc.EventListener.prototype.ctor.call(this, cc.EventListener.ACCELERATION, cc._EventListenerAcceleration.LISTENER_ID, function(b) {
			c._onAccelerationEvent(b._acc, b)
		})
	},
	checkAvailable: function() {
		cc.assert(this._onAccelerationEvent, cc._LogInfos._EventListenerAcceleration_checkAvailable);
		return !0
	},
	clone: function() {
		return new cc._EventListenerAcceleration(this._onAccelerationEvent)
	}
});
cc._EventListenerAcceleration.LISTENER_ID = "__cc_acceleration";
cc._EventListenerAcceleration.create = function(b) {
	return new cc._EventListenerAcceleration(b)
};
cc._EventListenerKeyboard = cc.EventListener.extend({
	onKeyPressed: null,
	onKeyReleased: null,
	ctor: function() {
		var b = this;
		cc.EventListener.prototype.ctor.call(this, cc.EventListener.KEYBOARD, cc._EventListenerKeyboard.LISTENER_ID, function(c) {
			if (c._isPressed) {
				if (b.onKeyPressed) {
					b.onKeyPressed(c._keyCode, c)
				}
			} else {
				if (b.onKeyReleased) {
					b.onKeyReleased(c._keyCode, c)
				}
			}
		})
	},
	clone: function() {
		var b = new cc._EventListenerKeyboard;
		b.onKeyPressed = this.onKeyPressed;
		b.onKeyReleased = this.onKeyReleased;
		return b
	},
	checkAvailable: function() {
		return null === this.onKeyPressed && null === this.onKeyReleased ? (cc.log(cc._LogInfos._EventListenerKeyboard_checkAvailable), !1) : !0
	}
});
cc._EventListenerKeyboard.LISTENER_ID = "__cc_keyboard";
cc._EventListenerKeyboard.create = function() {
	return new cc._EventListenerKeyboard
};
cc.rendererCanvas = {
	childrenOrderDirty: !0,
	_transformNodePool: [],
	_renderCmds: [],
	_isCacheToCanvasOn: !1,
	_cacheToCanvasCmds: {},
	_cacheInstanceIds: [],
	_currentID: 0,
	getRenderCmd: function(b) {
		return b._createRenderCmd()
	},
	rendering: function(b) {
		var c = this._renderCmds,
			d, e = cc.view.getScaleX(),
			f = cc.view.getScaleY(),
			g = b || cc._renderContext;
		g.computeRealOffsetY();
		b = 0;
		for (d = c.length; b < d; b++) {
			c[b].rendering(g, e, f)
		}
	},
	_renderingToCacheCanvas: function(b, c, d, e) {
		b || cc.log("The context of RenderTexture is invalid.");
		d = cc.isUndefined(d) ? 1 : d;
		e = cc.isUndefined(e) ? 1 : e;
		c = c || this._currentID;
		var f = this._cacheToCanvasCmds[c],
			g, h;
		b.computeRealOffsetY();
		g = 0;
		for (h = f.length; g < h; g++) {
			f[g].rendering(b, d, e)
		}
		f.length = 0;
		b = this._cacheInstanceIds;
		delete this._cacheToCanvasCmds[c];
		cc.arrayRemoveObject(b, c);
		0 === b.length ? this._isCacheToCanvasOn = !1 : this._currentID = b[b.length - 1]
	},
	_turnToCacheMode: function(b) {
		this._isCacheToCanvasOn = !0;
		b = b || 0;
		this._cacheToCanvasCmds[b] = []; - 1 === this._cacheInstanceIds.indexOf(b) && this._cacheInstanceIds.push(b);
		this._currentID = b
	},
	_turnToNormalMode: function() {
		this._isCacheToCanvasOn = !1
	},
	resetFlag: function() {
		this.childrenOrderDirty = !1;
		this._transformNodePool.length = 0
	},
	transform: function() {
		var b = this._transformNodePool;
		b.sort(this._sortNodeByLevelAsc);
		for (var c = 0, d = b.length; c < d; c++) {
			0 !== b[c]._dirtyFlag && b[c].updateStatus()
		}
		b.length = 0
	},
	transformDirty: function() {
		return 0 < this._transformNodePool.length
	},
	_sortNodeByLevelAsc: function(b, c) {
		return b._curLevel - c._curLevel
	},
	pushDirtyNode: function(b) {
		this._transformNodePool.push(b)
	},
	clearRenderCommands: function() {
		this._renderCmds.length = 0
	},
	pushRenderCommand: function(b) {
		if (b._needDraw) {
			if (this._isCacheToCanvasOn) {
				var c = this._cacheToCanvasCmds[this._currentID]; - 1 === c.indexOf(b) && c.push(b)
			} else {
				-1 === this._renderCmds.indexOf(b) && this._renderCmds.push(b)
			}
		}
	}
};
cc._renderType === cc._RENDER_TYPE_CANVAS && (cc.renderer = cc.rendererCanvas);
(function() {
	cc.CanvasContextWrapper = function(b) {
		this._context = b;
		this._saveCount = 0;
		this._currentAlpha = b.globalAlpha;
		this._currentCompositeOperation = b.globalCompositeOperation;
		this._currentFillStyle = b.fillStyle;
		this._currentStrokeStyle = b.strokeStyle;
		this._offsetY = this._offsetX = 0;
		this._realOffsetY = this.height;
		this._armatureMode = 0
	};
	var b = cc.CanvasContextWrapper.prototype;
	b.resetCache = function() {
		var b = this._context;
		this._currentAlpha = b.globalAlpha;
		this._currentCompositeOperation = b.globalCompositeOperation;
		this._currentFillStyle = b.fillStyle;
		this._currentStrokeStyle = b.strokeStyle;
		this._realOffsetY = this._context.canvas.height + this._offsetY
	};
	b.setOffset = function(b, d) {
		this._offsetX = b;
		this._offsetY = d;
		this._realOffsetY = this._context.canvas.height + this._offsetY
	};
	b.computeRealOffsetY = function() {
		this._realOffsetY = this._context.canvas.height + this._offsetY
	};
	b.setViewScale = function(b, d) {
		this._scaleX = b;
		this._scaleY = d
	};
	b.getContext = function() {
		return this._context
	};
	b.save = function() {
		this._context.save();
		this._saveCount++
	};
	b.restore = function() {
		this._context.restore();
		this._saveCount--
	};
	b.setGlobalAlpha = function(b) {
		0 < this._saveCount ? this._context.globalAlpha = b : this._currentAlpha !== b && (this._currentAlpha = b, this._context.globalAlpha = b)
	};
	b.setCompositeOperation = function(b) {
		0 < this._saveCount ? this._context.globalCompositeOperation = b : this._currentCompositeOperation !== b && (this._currentCompositeOperation = b, this._context.globalCompositeOperation = b)
	};
	b.setFillStyle = function(b) {
		0 < this._saveCount ? this._context.fillStyle = b : this._currentFillStyle !== b && (this._currentFillStyle = b, this._context.fillStyle = b)
	};
	b.setStrokeStyle = function(b) {
		0 < this._saveCount ? this._context.strokeStyle = b : this._currentStrokeStyle !== b && (this._currentStrokeStyle = b, this._context.strokeStyle = b)
	};
	b.setTransform = function(b, d, e) {
		0 < this._armatureMode ? (this.restore(), this.save(), this._context.transform(b.a, -b.b, -b.c, b.d, b.tx * d, -(b.ty * e))) : this._context.setTransform(b.a, -b.b, -b.c, b.d, this._offsetX + b.tx * d, this._realOffsetY - b.ty * e)
	};
	b._switchToArmatureMode = function(b, d, e, f) {
		b ? (this._armatureMode++, this._context.setTransform(d.a, d.c, d.b, d.d, this._offsetX + d.tx * e, this._realOffsetY - d.ty * f), this.save()) : (this._armatureMode--, this.restore())
	}
})();
cc.rendererWebGL = {
	childrenOrderDirty: !0,
	_transformNodePool: [],
	_renderCmds: [],
	_isCacheToBufferOn: !1,
	_cacheToBufferCmds: {},
	_cacheInstanceIds: [],
	_currentID: 0,
	getRenderCmd: function(b) {
		return b._createRenderCmd()
	},
	rendering: function(b) {
		var c = this._renderCmds,
			d, e = b || cc._renderContext;
		b = 0;
		for (d = c.length; b < d; b++) {
			c[b].rendering(e)
		}
	},
	_turnToCacheMode: function(b) {
		this._isCacheToBufferOn = !0;
		b = b || 0;
		this._cacheToBufferCmds[b] = [];
		this._cacheInstanceIds.push(b);
		this._currentID = b
	},
	_turnToNormalMode: function() {
		this._isCacheToBufferOn = !1
	},
	_renderingToBuffer: function(b) {
		b = b || this._currentID;
		var c = this._cacheToBufferCmds[b],
			d, e, f = cc._renderContext,
			g = this._cacheInstanceIds;
		d = 0;
		for (e = c.length; d < e; d++) {
			c[d].rendering(f)
		}
		c.length = 0;
		delete this._cacheToBufferCmds[b];
		cc.arrayRemoveObject(g, b);
		0 === g.length ? this._isCacheToBufferOn = !1 : this._currentID = g[g.length - 1]
	},
	resetFlag: function() {
		this.childrenOrderDirty = !1;
		this._transformNodePool.length = 0
	},
	transform: function() {
		var b = this._transformNodePool;
		b.sort(this._sortNodeByLevelAsc);
		for (var c = 0, d = b.length; c < d; c++) {
			b[c].updateStatus()
		}
		b.length = 0
	},
	transformDirty: function() {
		return 0 < this._transformNodePool.length
	},
	_sortNodeByLevelAsc: function(b, c) {
		return b._curLevel - c._curLevel
	},
	pushDirtyNode: function(b) {
		this._transformNodePool.push(b)
	},
	clearRenderCommands: function() {
		this._renderCmds.length = 0
	},
	pushRenderCommand: function(b) {
		if (b._needDraw) {
			if (this._isCacheToBufferOn) {
				var c = this._cacheToBufferCmds[this._currentID]; - 1 === c.indexOf(b) && c.push(b)
			} else {
				-1 === this._renderCmds.indexOf(b) && this._renderCmds.push(b)
			}
		}
	}
};
cc._renderType === cc._RENDER_TYPE_WEBGL && (cc.renderer = cc.rendererWebGL);
cc._tmp.PrototypeCCNode = function() {
	var b = cc.Node.prototype;
	cc.defineGetterSetter(b, "x", b.getPositionX, b.setPositionX);
	cc.defineGetterSetter(b, "y", b.getPositionY, b.setPositionY);
	cc.defineGetterSetter(b, "width", b._getWidth, b._setWidth);
	cc.defineGetterSetter(b, "height", b._getHeight, b._setHeight);
	cc.defineGetterSetter(b, "anchorX", b._getAnchorX, b._setAnchorX);
	cc.defineGetterSetter(b, "anchorY", b._getAnchorY, b._setAnchorY);
	cc.defineGetterSetter(b, "skewX", b.getSkewX, b.setSkewX);
	cc.defineGetterSetter(b, "skewY", b.getSkewY, b.setSkewY);
	cc.defineGetterSetter(b, "zIndex", b.getLocalZOrder, b.setLocalZOrder);
	cc.defineGetterSetter(b, "vertexZ", b.getVertexZ, b.setVertexZ);
	cc.defineGetterSetter(b, "rotation", b.getRotation, b.setRotation);
	cc.defineGetterSetter(b, "rotationX", b.getRotationX, b.setRotationX);
	cc.defineGetterSetter(b, "rotationY", b.getRotationY, b.setRotationY);
	cc.defineGetterSetter(b, "scale", b.getScale, b.setScale);
	cc.defineGetterSetter(b, "scaleX", b.getScaleX, b.setScaleX);
	cc.defineGetterSetter(b, "scaleY", b.getScaleY, b.setScaleY);
	cc.defineGetterSetter(b, "children", b.getChildren);
	cc.defineGetterSetter(b, "childrenCount", b.getChildrenCount);
	cc.defineGetterSetter(b, "parent", b.getParent, b.setParent);
	cc.defineGetterSetter(b, "visible", b.isVisible, b.setVisible);
	cc.defineGetterSetter(b, "running", b.isRunning);
	cc.defineGetterSetter(b, "ignoreAnchor", b.isIgnoreAnchorPointForPosition, b.ignoreAnchorPointForPosition);
	cc.defineGetterSetter(b, "actionManager", b.getActionManager, b.setActionManager);
	cc.defineGetterSetter(b, "scheduler", b.getScheduler, b.setScheduler);
	cc.defineGetterSetter(b, "shaderProgram", b.getShaderProgram, b.setShaderProgram);
	cc.defineGetterSetter(b, "opacity", b.getOpacity, b.setOpacity);
	cc.defineGetterSetter(b, "opacityModifyRGB", b.isOpacityModifyRGB);
	cc.defineGetterSetter(b, "cascadeOpacity", b.isCascadeOpacityEnabled, b.setCascadeOpacityEnabled);
	cc.defineGetterSetter(b, "color", b.getColor, b.setColor);
	cc.defineGetterSetter(b, "cascadeColor", b.isCascadeColorEnabled, b.setCascadeColorEnabled)
};
cc.NODE_TAG_INVALID = -1;
cc.s_globalOrderOfArrival = 1;
cc.Node = cc.Class.extend({
	_localZOrder: 0,
	_globalZOrder: 0,
	_vertexZ: 0,
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
	_camera: null,
	ctor: function() {
		this._initNode();
		this._initRendererCmd()
	},
	_initNode: function() {
		this._anchorPoint = cc.p(0, 0);
		this._contentSize = cc.size(0, 0);
		this._position = cc.p(0, 0);
		this._normalizedPosition = cc.p(0, 0);
		this._children = [];
		var b = cc.director;
		this._actionManager = b.getActionManager();
		this._scheduler = b.getScheduler();
		this._additionalTransform = cc.affineTransformMakeIdentity();
		cc.ComponentContainer && (this._componentContainer = new cc.ComponentContainer(this));
		this._realOpacity = 255;
		this._realColor = cc.color(255, 255, 255, 255);
		this._cascadeOpacityEnabled = this._cascadeColorEnabled = !1
	},
	init: function() {
		return !0
	},
	_arrayMakeObjectsPerformSelector: function(b, c) {
		if (b && 0 !== b.length) {
			var d, e = b.length,
				f;
			d = cc.Node._stateCallbackType;
			switch (c) {
			case d.onEnter:
				for (d = 0; d < e; d++) {
					if (f = b[d]) {
						f.onEnter()
					}
				}
				break;
			case d.onExit:
				for (d = 0; d < e; d++) {
					if (f = b[d]) {
						f.onExit()
					}
				}
				break;
			case d.onEnterTransitionDidFinish:
				for (d = 0; d < e; d++) {
					if (f = b[d]) {
						f.onEnterTransitionDidFinish()
					}
				}
				break;
			case d.cleanup:
				for (d = 0; d < e; d++) {
					(f = b[d]) && f.cleanup()
				}
				break;
			case d.updateTransform:
				for (d = 0; d < e; d++) {
					(f = b[d]) && f.updateTransform()
				}
				break;
			case d.onExitTransitionDidStart:
				for (d = 0; d < e; d++) {
					if (f = b[d]) {
						f.onExitTransitionDidStart()
					}
				}
				break;
			case d.sortAllChildren:
				for (d = 0; d < e; d++) {
					(f = b[d]) && f.sortAllChildren()
				}
				break;
			default:
				cc.assert(0, cc._LogInfos.Node__arrayMakeObjectsPerformSelector)
			}
		}
	},
	attr: function(b) {
		for (var c in b) {
			this[c] = b[c]
		}
	},
	getSkewX: function() {
		return this._skewX
	},
	setSkewX: function(b) {
		this._skewX = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	getSkewY: function() {
		return this._skewY
	},
	setSkewY: function(b) {
		this._skewY = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	setLocalZOrder: function(b) {
		this._localZOrder = b;
		this._parent && this._parent.reorderChild(this, b);
		cc.eventManager._setDirtyForNode(this)
	},
	_setLocalZOrder: function(b) {
		this._localZOrder = b
	},
	getLocalZOrder: function() {
		return this._localZOrder
	},
	getZOrder: function() {
		cc.log(cc._LogInfos.Node_getZOrder);
		return this.getLocalZOrder()
	},
	setZOrder: function(b) {
		cc.log(cc._LogInfos.Node_setZOrder);
		this.setLocalZOrder(b)
	},
	setGlobalZOrder: function(b) {
		this._globalZOrder !== b && (this._globalZOrder = b, cc.eventManager._setDirtyForNode(this))
	},
	getGlobalZOrder: function() {
		return this._globalZOrder
	},
	getVertexZ: function() {
		return this._vertexZ
	},
	setVertexZ: function(b) {
		this._vertexZ = b
	},
	getRotation: function() {
		this._rotationX !== this._rotationY && cc.log(cc._LogInfos.Node_getRotation);
		return this._rotationX
	},
	setRotation: function(b) {
		this._rotationX = this._rotationY = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	getRotationX: function() {
		return this._rotationX
	},
	setRotationX: function(b) {
		this._rotationX = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	getRotationY: function() {
		return this._rotationY
	},
	setRotationY: function(b) {
		this._rotationY = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	getScale: function() {
		this._scaleX !== this._scaleY && cc.log(cc._LogInfos.Node_getScale);
		return this._scaleX
	},
	setScale: function(b, c) {
		this._scaleX = b;
		this._scaleY = c || 0 === c ? c : b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	getScaleX: function() {
		return this._scaleX
	},
	setScaleX: function(b) {
		this._scaleX = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	getScaleY: function() {
		return this._scaleY
	},
	setScaleY: function(b) {
		this._scaleY = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	setPosition: function(b, c) {
		var d = this._position;
		if (void 0 === c) {
			if (d.x === b.x && d.y === b.y) {
				return
			}
			d.x = b.x;
			d.y = b.y
		} else {
			if (d.x === b && d.y === c) {
				return
			}
			d.x = b;
			d.y = c
		}
		this._usingNormalizedPosition = !1;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	setNormalizedPosition: function(b, c) {
		var d = this._normalizedPosition;
		void 0 === c ? (d.x = b.x, d.y = b.y) : (d.x = b, d.y = c);
		this._normalizedPositionDirty = this._usingNormalizedPosition = !0;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	getPosition: function() {
		return cc.p(this._position)
	},
	getNormalizedPosition: function() {
		return cc.p(this._normalizedPosition)
	},
	getPositionX: function() {
		return this._position.x
	},
	setPositionX: function(b) {
		this._position.x = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	getPositionY: function() {
		return this._position.y
	},
	setPositionY: function(b) {
		this._position.y = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	getChildrenCount: function() {
		return this._children.length
	},
	getChildren: function() {
		return this._children
	},
	isVisible: function() {
		return this._visible
	},
	setVisible: function(b) {
		this._visible !== b && (this._visible = b, this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty), cc.renderer.childrenOrderDirty = !0)
	},
	getAnchorPoint: function() {
		return cc.p(this._anchorPoint)
	},
	setAnchorPoint: function(b, c) {
		var d = this._anchorPoint;
		if (void 0 === c) {
			if (b.x === d.x && b.y === d.y) {
				return
			}
			d.x = b.x;
			d.y = b.y
		} else {
			if (b === d.x && c === d.y) {
				return
			}
			d.x = b;
			d.y = c
		}
		this._renderCmd._updateAnchorPointInPoint()
	},
	_getAnchorX: function() {
		return this._anchorPoint.x
	},
	_setAnchorX: function(b) {
		this._anchorPoint.x !== b && (this._anchorPoint.x = b, this._renderCmd._updateAnchorPointInPoint())
	},
	_getAnchorY: function() {
		return this._anchorPoint.y
	},
	_setAnchorY: function(b) {
		this._anchorPoint.y !== b && (this._anchorPoint.y = b, this._renderCmd._updateAnchorPointInPoint())
	},
	getAnchorPointInPoints: function() {
		return this._renderCmd.getAnchorPointInPoints()
	},
	_getWidth: function() {
		return this._contentSize.width
	},
	_setWidth: function(b) {
		this._contentSize.width = b;
		this._renderCmd._updateAnchorPointInPoint()
	},
	_getHeight: function() {
		return this._contentSize.height
	},
	_setHeight: function(b) {
		this._contentSize.height = b;
		this._renderCmd._updateAnchorPointInPoint()
	},
	getContentSize: function() {
		return cc.size(this._contentSize)
	},
	setContentSize: function(b, c) {
		var d = this._contentSize;
		if (void 0 === c) {
			if (b.width === d.width && b.height === d.height) {
				return
			}
			d.width = b.width;
			d.height = b.height
		} else {
			if (b === d.width && c === d.height) {
				return
			}
			d.width = b;
			d.height = c
		}
		this._renderCmd._updateAnchorPointInPoint()
	},
	isRunning: function() {
		return this._running
	},
	getParent: function() {
		return this._parent
	},
	setParent: function(b) {
		this._parent = b
	},
	isIgnoreAnchorPointForPosition: function() {
		return this._ignoreAnchorPointForPosition
	},
	ignoreAnchorPointForPosition: function(b) {
		b !== this._ignoreAnchorPointForPosition && (this._ignoreAnchorPointForPosition = b, this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty))
	},
	getTag: function() {
		return this.tag
	},
	setTag: function(b) {
		this.tag = b
	},
	setName: function(b) {
		this._name = b
	},
	getName: function() {
		return this._name
	},
	getUserData: function() {
		return this.userData
	},
	setUserData: function(b) {
		this.userData = b
	},
	getUserObject: function() {
		return this.userObject
	},
	setUserObject: function(b) {
		this.userObject !== b && (this.userObject = b)
	},
	getOrderOfArrival: function() {
		return this.arrivalOrder
	},
	setOrderOfArrival: function(b) {
		this.arrivalOrder = b
	},
	getActionManager: function() {
		this._actionManager || (this._actionManager = cc.director.getActionManager());
		return this._actionManager
	},
	setActionManager: function(b) {
		this._actionManager !== b && (this.stopAllActions(), this._actionManager = b)
	},
	getScheduler: function() {
		this._scheduler || (this._scheduler = cc.director.getScheduler());
		return this._scheduler
	},
	setScheduler: function(b) {
		this._scheduler !== b && (this.unscheduleAllCallbacks(), this._scheduler = b)
	},
	boundingBox: function() {
		cc.log(cc._LogInfos.Node_boundingBox);
		return this.getBoundingBox()
	},
	getBoundingBox: function() {
		var b = cc.rect(0, 0, this._contentSize.width, this._contentSize.height);
		return cc._rectApplyAffineTransformIn(b, this.getNodeToParentTransform())
	},
	cleanup: function() {
		this.stopAllActions();
		this.unscheduleAllCallbacks();
		cc.eventManager.removeListeners(this);
		this._arrayMakeObjectsPerformSelector(this._children, cc.Node._stateCallbackType.cleanup)
	},
	getChildByTag: function(b) {
		var c = this._children;
		if (null !== c) {
			for (var d = 0; d < c.length; d++) {
				var e = c[d];
				if (e && e.tag === b) {
					return e
				}
			}
		}
		return null
	},
	getChildByName: function(b) {
		if (!b) {
			return cc.log("Invalid name"), null
		}
		for (var c = this._children, d = 0, e = c.length; d < e; d++) {
			if (c[d]._name === b) {
				return c[d]
			}
		}
		return null
	},
	addChild: function(b, c, d) {
		c = void 0 === c ? b._localZOrder : c;
		var e, f = !1;
		cc.isUndefined(d) ? (d = void 0, e = b._name) : cc.isString(d) ? (e = d, d = void 0) : cc.isNumber(d) && (f = !0, e = "");
		cc.assert(b, cc._LogInfos.Node_addChild_3);
		cc.assert(null === b._parent, "child already added. It can't be added again");
		this._addChildHelper(b, c, d, e, f)
	},
	_addChildHelper: function(b, c, d, e, f) {
		this._children || (this._children = []);
		this._insertChild(b, c);
		f ? b.setTag(d) : b.setName(e);
		b.setParent(this);
		b.setOrderOfArrival(cc.s_globalOrderOfArrival++);
		if (this._running && (b.onEnter(), this._isTransitionFinished)) {
			b.onEnterTransitionDidFinish()
		}
		this._cascadeColorEnabled && b._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty);
		this._cascadeOpacityEnabled && b._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.opacityDirty)
	},
	removeFromParent: function(b) {
		this._parent && (void 0 === b && (b = !0), this._parent.removeChild(this, b))
	},
	removeFromParentAndCleanup: function(b) {
		cc.log(cc._LogInfos.Node_removeFromParentAndCleanup);
		this.removeFromParent(b)
	},
	removeChild: function(b, c) {
		0 !== this._children.length && (void 0 === c && (c = !0), -1 < this._children.indexOf(b) && this._detachChild(b, c), cc.renderer.childrenOrderDirty = !0)
	},
	removeChildByTag: function(b, c) {
		b === cc.NODE_TAG_INVALID && cc.log(cc._LogInfos.Node_removeChildByTag);
		var d = this.getChildByTag(b);
		d ? this.removeChild(d, c) : cc.log(cc._LogInfos.Node_removeChildByTag_2, b)
	},
	removeAllChildrenWithCleanup: function(b) {
		this.removeAllChildren(b)
	},
	removeAllChildren: function(b) {
		var c = this._children;
		if (null !== c) {
			void 0 === b && (b = !0);
			for (var d = 0; d < c.length; d++) {
				var e = c[d];
				e && (this._running && (e.onExitTransitionDidStart(), e.onExit()), b && e.cleanup(), e.parent = null, e._renderCmd.detachFromParent())
			}
			this._children.length = 0;
			cc.renderer.childrenOrderDirty = !0
		}
	},
	_detachChild: function(b, c) {
		this._running && (b.onExitTransitionDidStart(), b.onExit());
		c && b.cleanup();
		b.parent = null;
		b._renderCmd.detachFromParent();
		cc.arrayRemoveObject(this._children, b)
	},
	_insertChild: function(b, c) {
		cc.renderer.childrenOrderDirty = this._reorderChildDirty = !0;
		this._children.push(b);
		b._setLocalZOrder(c)
	},
	setNodeDirty: function() {
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	reorderChild: function(b, c) {
		cc.assert(b, cc._LogInfos.Node_reorderChild);
		cc.renderer.childrenOrderDirty = this._reorderChildDirty = !0;
		b.arrivalOrder = cc.s_globalOrderOfArrival;
		cc.s_globalOrderOfArrival++;
		b._setLocalZOrder(c)
	},
	sortAllChildren: function() {
		if (this._reorderChildDirty) {
			var b = this._children,
				c = b.length,
				d, e, f;
			for (d = 1; d < c; d++) {
				f = b[d];
				for (e = d - 1; 0 <= e;) {
					if (f._localZOrder < b[e]._localZOrder) {
						b[e + 1] = b[e]
					} else {
						if (f._localZOrder === b[e]._localZOrder && f.arrivalOrder < b[e].arrivalOrder) {
							b[e + 1] = b[e]
						} else {
							break
						}
					}
					e--
				}
				b[e + 1] = f
			}
			this._reorderChildDirty = !1
		}
	},
	draw: function(b) {},
	transformAncestors: function() {
		null !== this._parent && (this._parent.transformAncestors(), this._parent.transform())
	},
	onEnter: function() {
		this._isTransitionFinished = !1;
		this._running = !0;
		this._arrayMakeObjectsPerformSelector(this._children, cc.Node._stateCallbackType.onEnter);
		this.resume()
	},
	onEnterTransitionDidFinish: function() {
		this._isTransitionFinished = !0;
		this._arrayMakeObjectsPerformSelector(this._children, cc.Node._stateCallbackType.onEnterTransitionDidFinish)
	},
	onExitTransitionDidStart: function() {
		this._arrayMakeObjectsPerformSelector(this._children, cc.Node._stateCallbackType.onExitTransitionDidStart)
	},
	onExit: function() {
		this._running = !1;
		this.pause();
		this._arrayMakeObjectsPerformSelector(this._children, cc.Node._stateCallbackType.onExit);
		this.removeAllComponents()
	},
	runAction: function(b) {
		cc.assert(b, cc._LogInfos.Node_runAction);
		this.actionManager.addAction(b, this, !this._running);
		return b
	},
	stopAllActions: function() {
		this.actionManager && this.actionManager.removeAllActionsFromTarget(this)
	},
	stopAction: function(b) {
		this.actionManager.removeAction(b)
	},
	stopActionByTag: function(b) {
		b === cc.ACTION_TAG_INVALID ? cc.log(cc._LogInfos.Node_stopActionByTag) : this.actionManager.removeActionByTag(b, this)
	},
	getActionByTag: function(b) {
		return b === cc.ACTION_TAG_INVALID ? (cc.log(cc._LogInfos.Node_getActionByTag), null) : this.actionManager.getActionByTag(b, this)
	},
	getNumberOfRunningActions: function() {
		return this.actionManager.numberOfRunningActionsInTarget(this)
	},
	scheduleUpdate: function() {
		this.scheduleUpdateWithPriority(0)
	},
	scheduleUpdateWithPriority: function(b) {
		this.scheduler.scheduleUpdate(this, b, !this._running)
	},
	unscheduleUpdate: function() {
		this.scheduler.unscheduleUpdate(this)
	},
	schedule: function(b, c, d, e, f) {
		var g = arguments.length;
		"function" === typeof b ? 1 === g ? (c = 0, d = cc.REPEAT_FOREVER, e = 0, f = this.__instanceId) : 2 === g ? "number" === typeof c ? (d = cc.REPEAT_FOREVER, e = 0, f = this.__instanceId) : (f = c, c = 0, d = cc.REPEAT_FOREVER, e = 0) : 3 === g ? ("string" === typeof d ? (f = d, d = cc.REPEAT_FOREVER) : f = this.__instanceId, e = 0) : 4 === g && (f = this.__instanceId) : 1 === g ? (c = 0, d = cc.REPEAT_FOREVER, e = 0) : 2 === g && (d = cc.REPEAT_FOREVER, e = 0);
		cc.assert(b, cc._LogInfos.Node_schedule);
		cc.assert(0 <= c, cc._LogInfos.Node_schedule_2);
		d = null == d ? cc.REPEAT_FOREVER : d;
		this.scheduler.schedule(b, this, c || 0, d, e || 0, !this._running, f)
	},
	scheduleOnce: function(b, c, d) {
		void 0 === d && (d = this.__instanceId);
		this.schedule(b, 0, 0, c, d)
	},
	unschedule: function(b) {
		b && this.scheduler.unschedule(b, this)
	},
	unscheduleAllCallbacks: function() {
		this.scheduler.unscheduleAllForTarget(this)
	},
	resumeSchedulerAndActions: function() {
		cc.log(cc._LogInfos.Node_resumeSchedulerAndActions);
		this.resume()
	},
	resume: function() {
		this.scheduler.resumeTarget(this);
		this.actionManager && this.actionManager.resumeTarget(this);
		cc.eventManager.resumeTarget(this)
	},
	pauseSchedulerAndActions: function() {
		cc.log(cc._LogInfos.Node_pauseSchedulerAndActions);
		this.pause()
	},
	pause: function() {
		this.scheduler.pauseTarget(this);
		this.actionManager && this.actionManager.pauseTarget(this);
		cc.eventManager.pauseTarget(this)
	},
	setAdditionalTransform: function(b) {
		if (void 0 === b) {
			return this._additionalTransformDirty = !1
		}
		this._additionalTransform = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty);
		this._additionalTransformDirty = !0
	},
	getParentToNodeTransform: function() {
		this._renderCmd.getParentToNodeTransform()
	},
	parentToNodeTransform: function() {
		return this.getParentToNodeTransform()
	},
	getNodeToWorldTransform: function() {
		for (var b = this.getNodeToParentTransform(), c = this._parent; null !== c; c = c.parent) {
			b = cc.affineTransformConcat(b, c.getNodeToParentTransform())
		}
		return b
	},
	nodeToWorldTransform: function() {
		return this.getNodeToWorldTransform()
	},
	getWorldToNodeTransform: function() {
		return cc.affineTransformInvert(this.getNodeToWorldTransform())
	},
	worldToNodeTransform: function() {
		return this.getWorldToNodeTransform()
	},
	convertToNodeSpace: function(b) {
		return cc.pointApplyAffineTransform(b, this.getWorldToNodeTransform())
	},
	convertToWorldSpace: function(b) {
		b = b || cc.p(0, 0);
		return cc.pointApplyAffineTransform(b, this.getNodeToWorldTransform())
	},
	convertToNodeSpaceAR: function(b) {
		return cc.pSub(this.convertToNodeSpace(b), this._renderCmd.getAnchorPointInPoints())
	},
	convertToWorldSpaceAR: function(b) {
		b = b || cc.p(0, 0);
		b = cc.pAdd(b, this._renderCmd.getAnchorPointInPoints());
		return this.convertToWorldSpace(b)
	},
	_convertToWindowSpace: function(b) {
		b = this.convertToWorldSpace(b);
		return cc.director.convertToUI(b)
	},
	convertTouchToNodeSpace: function(b) {
		b = b.getLocation();
		return this.convertToNodeSpace(b)
	},
	convertTouchToNodeSpaceAR: function(b) {
		b = cc.director.convertToGL(b.getLocation());
		return this.convertToNodeSpaceAR(b)
	},
	update: function(b) {
		this._componentContainer && !this._componentContainer.isEmpty() && this._componentContainer.visit(b)
	},
	updateTransform: function() {
		this._arrayMakeObjectsPerformSelector(this._children, cc.Node._stateCallbackType.updateTransform)
	},
	retain: function() {},
	release: function() {},
	getComponent: function(b) {
		return this._componentContainer ? this._componentContainer.getComponent(b) : null
	},
	addComponent: function(b) {
		this._componentContainer && this._componentContainer.add(b)
	},
	removeComponent: function(b) {
		return this._componentContainer ? this._componentContainer.remove(b) : !1
	},
	removeAllComponents: function() {
		this._componentContainer && this._componentContainer.removeAll()
	},
	grid: null,
	visit: function(b) {
		this._renderCmd.visit(b)
	},
	transform: function(b, c) {
		this._renderCmd.transform(b, c)
	},
	nodeToParentTransform: function() {
		return this.getNodeToParentTransform()
	},
	getNodeToParentTransform: function() {
		return this._renderCmd.getNodeToParentTransform()
	},
	getCamera: function() {
		this._camera || (this._camera = new cc.Camera);
		return this._camera
	},
	getGrid: function() {
		return this.grid
	},
	setGrid: function(b) {
		this.grid = b
	},
	getShaderProgram: function() {
		return this._renderCmd.getShaderProgram()
	},
	setShaderProgram: function(b) {
		this._renderCmd.setShaderProgram(b)
	},
	getGLServerState: function() {
		return 0
	},
	setGLServerState: function(b) {},
	getBoundingBoxToWorld: function() {
		var b = cc.rect(0, 0, this._contentSize.width, this._contentSize.height),
			c = this.getNodeToWorldTransform(),
			b = cc.rectApplyAffineTransform(b, c);
		if (!this._children) {
			return b
		}
		for (var d = this._children, e = 0; e < d.length; e++) {
			var f = d[e];
			f && f._visible && (f = f._getBoundingBoxToCurrentNode(c)) && (b = cc.rectUnion(b, f))
		}
		return b
	},
	_getBoundingBoxToCurrentNode: function(b) {
		var c = cc.rect(0, 0, this._contentSize.width, this._contentSize.height);
		b = void 0 === b ? this.getNodeToParentTransform() : cc.affineTransformConcat(this.getNodeToParentTransform(), b);
		c = cc.rectApplyAffineTransform(c, b);
		if (!this._children) {
			return c
		}
		for (var d = this._children, e = 0; e < d.length; e++) {
			var f = d[e];
			f && f._visible && (f = f._getBoundingBoxToCurrentNode(b)) && (c = cc.rectUnion(c, f))
		}
		return c
	},
	getOpacity: function() {
		return this._realOpacity
	},
	getDisplayedOpacity: function() {
		return this._renderCmd.getDisplayedOpacity()
	},
	setOpacity: function(b) {
		this._realOpacity = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.opacityDirty)
	},
	updateDisplayedOpacity: function(b) {
		this._renderCmd._updateDisplayOpacity(b)
	},
	isCascadeOpacityEnabled: function() {
		return this._cascadeOpacityEnabled
	},
	setCascadeOpacityEnabled: function(b) {
		this._cascadeOpacityEnabled !== b && (this._cascadeOpacityEnabled = b, this._renderCmd.setCascadeOpacityEnabledDirty())
	},
	getColor: function() {
		var b = this._realColor;
		return cc.color(b.r, b.g, b.b, b.a)
	},
	getDisplayedColor: function() {
		return this._renderCmd.getDisplayedColor()
	},
	setColor: function(b) {
		var c = this._realColor;
		c.r = b.r;
		c.g = b.g;
		c.b = b.b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty)
	},
	updateDisplayedColor: function(b) {
		this._renderCmd._updateDisplayColor(b)
	},
	isCascadeColorEnabled: function() {
		return this._cascadeColorEnabled
	},
	setCascadeColorEnabled: function(b) {
		this._cascadeColorEnabled !== b && (this._cascadeColorEnabled = b, this._renderCmd.setCascadeColorEnabledDirty())
	},
	setOpacityModifyRGB: function(b) {},
	isOpacityModifyRGB: function() {
		return !1
	},
	_initRendererCmd: function() {
		this._renderCmd = cc.renderer.getRenderCmd(this)
	},
	_createRenderCmd: function() {
		return cc._renderType === cc._RENDER_TYPE_CANVAS ? new cc.Node.CanvasRenderCmd(this) : new cc.Node.WebGLRenderCmd(this)
	},
	enumerateChildren: function(b, c) {
		cc.assert(b && 0 != b.length, "Invalid name");
		cc.assert(null != c, "Invalid callback function");
		var d = b.length,
			e = 0,
			f = d,
			g = !1;
		2 < d && "/" === b[0] && "/" === b[1] && (g = !0, e = 2, f -= 2);
		var h = !1;
		3 < d && "/" === b[d - 3] && "." === b[d - 2] && "." === b[d - 1] && (h = !0, f -= 3);
		d = b.substr(e, f);
		h && (d = "[[:alnum:]]+/" + d);
		g ? this.doEnumerateRecursive(this, d, c) : this.doEnumerate(d, c)
	},
	doEnumerateRecursive: function(b, c, d) {
		if (!b.doEnumerate(c, d)) {
			for (var e = b.getChildren(), f = e.length, g = 0; g < f && (b = e[g], !this.doEnumerateRecursive(b, c, d)); g++) {}
		}
	},
	doEnumerate: function(b, c) {
		var d = b.indexOf("/"),
			e = b,
			f = !1; - 1 !== d && (e = b.substr(0, d), f = !0);
		for (var d = !1, g, h = this._children, k = h.length, m = 0; m < k; m++) {
			if (g = h[m], -1 !== g._name.indexOf(e)) {
				if (f) {
					if (d = g.doEnumerate(b, c)) {
						break
					}
				} else {
					if (c(g)) {
						d = !0;
						break
					}
				}
			}
		}
		return d
	}
});
cc.Node.create = function() {
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
cc.CustomRenderCmd = function(b, c) {
	this._needDraw = !0;
	this._target = b;
	this._callback = c;
	this.rendering = function(b, c, f) {
		this._callback && this._callback.call(this._target, b, c, f)
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
	all: 255
};
cc.Node.RenderCmd = function(b) {
	this._dirtyFlag = 1;
	this._node = b;
	this._needDraw = !1;
	this._anchorPointInPoints = new cc.Point(0, 0);
	this._transform = {
		a: 1,
		b: 0,
		c: 0,
		d: 1,
		tx: 0,
		ty: 0
	};
	this._worldTransform = {
		a: 1,
		b: 0,
		c: 0,
		d: 1,
		tx: 0,
		ty: 0
	};
	this._inverse = {
		a: 1,
		b: 0,
		c: 0,
		d: 1,
		tx: 0,
		ty: 0
	};
	this._displayedOpacity = 255;
	this._displayedColor = cc.color(255, 255, 255, 255);
	this._cascadeOpacityEnabledDirty = this._cascadeColorEnabledDirty = !1;
	this._curLevel = -1
};
cc.Node.RenderCmd.prototype = {
	constructor: cc.Node.RenderCmd,
	getAnchorPointInPoints: function() {
		return cc.p(this._anchorPointInPoints)
	},
	getDisplayedColor: function() {
		var b = this._displayedColor;
		return cc.color(b.r, b.g, b.b, b.a)
	},
	getDisplayedOpacity: function() {
		return this._displayedOpacity
	},
	setCascadeColorEnabledDirty: function() {
		this._cascadeColorEnabledDirty = !0;
		this.setDirtyFlag(cc.Node._dirtyFlags.colorDirty)
	},
	setCascadeOpacityEnabledDirty: function() {
		this._cascadeOpacityEnabledDirty = !0;
		this.setDirtyFlag(cc.Node._dirtyFlags.opacityDirty)
	},
	getParentToNodeTransform: function() {
		this._dirtyFlag & cc.Node._dirtyFlags.transformDirty && (this._inverse = cc.affineTransformInvert(this.getNodeToParentTransform()));
		return this._inverse
	},
	detachFromParent: function() {},
	_updateAnchorPointInPoint: function() {
		var b = this._anchorPointInPoints,
			c = this._node._contentSize,
			d = this._node._anchorPoint;
		b.x = c.width * d.x;
		b.y = c.height * d.y;
		this.setDirtyFlag(cc.Node._dirtyFlags.transformDirty)
	},
	setDirtyFlag: function(b) {
		0 === this._dirtyFlag && 0 !== b && cc.renderer.pushDirtyNode(this);
		this._dirtyFlag |= b
	},
	getParentRenderCmd: function() {
		return this._node && this._node._parent && this._node._parent._renderCmd ? this._node._parent._renderCmd : null
	},
	_updateDisplayColor: function(b) {
		var c = this._node,
			d = this._displayedColor,
			e = c._realColor,
			f;
		if (this._cascadeColorEnabledDirty && !c._cascadeColorEnabled) {
			d.r = e.r;
			d.g = e.g;
			d.b = e.b;
			d = new cc.Color(255, 255, 255, 255);
			b = c._children;
			c = 0;
			for (e = b.length; c < e; c++) {
				(f = b[c]) && f._renderCmd && f._renderCmd._updateDisplayColor(d)
			}
			this._cascadeColorEnabledDirty = !1
		} else {
			if (void 0 === b && (b = (b = c._parent) && b._cascadeColorEnabled ? b.getDisplayedColor() : cc.color.WHITE), d.r = 0 | e.r * b.r / 255, d.g = 0 | e.g * b.g / 255, d.b = 0 | e.b * b.b / 255, c._cascadeColorEnabled) {
				for (b = c._children, c = 0, e = b.length; c < e; c++) {
					(f = b[c]) && f._renderCmd && (f._renderCmd._updateDisplayColor(d), f._renderCmd._updateColor())
				}
			}
		}
		this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.colorDirty
	},
	_updateDisplayOpacity: function(b) {
		var c = this._node,
			d, e;
		if (this._cascadeOpacityEnabledDirty && !c._cascadeOpacityEnabled) {
			this._displayedOpacity = c._realOpacity;
			d = c._children;
			b = 0;
			for (c = d.length; b < c; b++) {
				(e = d[b]) && e._renderCmd && e._renderCmd._updateDisplayOpacity(255)
			}
			this._cascadeOpacityEnabledDirty = !1
		} else {
			if (void 0 === b && (d = c._parent, b = 255, d && d._cascadeOpacityEnabled && (b = d.getDisplayedOpacity())), this._displayedOpacity = c._realOpacity * b / 255, c._cascadeOpacityEnabled) {
				for (d = c._children, b = 0, c = d.length; b < c; b++) {
					(e = d[b]) && e._renderCmd && (e._renderCmd._updateDisplayOpacity(this._displayedOpacity), e._renderCmd._updateColor())
				}
			}
		}
		this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.opacityDirty
	},
	_syncDisplayColor: function(b) {
		var c = this._node,
			d = this._displayedColor,
			e = c._realColor;
		void 0 === b && (b = (b = c._parent) && b._cascadeColorEnabled ? b.getDisplayedColor() : cc.color.WHITE);
		d.r = 0 | e.r * b.r / 255;
		d.g = 0 | e.g * b.g / 255;
		d.b = 0 | e.b * b.b / 255
	},
	_syncDisplayOpacity: function(b) {
		var c = this._node;
		if (void 0 === b) {
			var d = c._parent;
			b = 255;
			d && d._cascadeOpacityEnabled && (b = d.getDisplayedOpacity())
		}
		this._displayedOpacity = c._realOpacity * b / 255
	},
	_updateColor: function() {},
	updateStatus: function() {
		var b = cc.Node._dirtyFlags,
			c = this._dirtyFlag,
			d = c & b.colorDirty,
			e = c & b.opacityDirty;
		d && this._updateDisplayColor();
		e && this._updateDisplayOpacity();
		(d || e) && this._updateColor();
		c & b.transformDirty && (this.transform(this.getParentRenderCmd(), !0), this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.transformDirty)
	}
};
(function() {
	cc.Node.CanvasRenderCmd = function(b) {
		cc.Node.RenderCmd.call(this, b);
		this._cachedParent = null;
		this._cacheDirty = !1
	};
	var b = cc.Node.CanvasRenderCmd.prototype = Object.create(cc.Node.RenderCmd.prototype);
	b.constructor = cc.Node.CanvasRenderCmd;
	b.transform = function(b, d) {
		var e = this.getNodeToParentTransform(),
			f = this._worldTransform;
		this._cacheDirty = !0;
		if (b) {
			var g = b._worldTransform;
			f.a = e.a * g.a + e.b * g.c;
			f.b = e.a * g.b + e.b * g.d;
			f.c = e.c * g.a + e.d * g.c;
			f.d = e.c * g.b + e.d * g.d;
			f.tx = g.a * e.tx + g.c * e.ty + g.tx;
			f.ty = g.d * e.ty + g.ty + g.b * e.tx
		} else {
			f.a = e.a, f.b = e.b, f.c = e.c, f.d = e.d, f.tx = e.tx, f.ty = e.ty
		}
		if (d && (e = this._node._children) && 0 !== e.length) {
			for (f = 0, g = e.length; f < g; f++) {
				e[f]._renderCmd.transform(this, d)
			}
		}
	};
	b.getNodeToParentTransform = function() {
		var b = this._node,
			d = !1;
		b._usingNormalizedPosition && b._parent && (d = b._parent._contentSize, b._position.x = b._normalizedPosition.x * d.width, b._position.y = b._normalizedPosition.y * d.height, b._normalizedPositionDirty = !1, d = !0);
		if (d || this._dirtyFlag & cc.Node._dirtyFlags.transformDirty) {
			d = this._transform;
			d.tx = b._position.x;
			d.ty = b._position.y;
			var e = 1,
				f = 0,
				g = 0,
				h = 1;
			b._rotationX && (h = 0.017453292519943295 * b._rotationX, g = Math.sin(h), h = Math.cos(h));
			b._rotationY && (f = 0.017453292519943295 * b._rotationY, e = Math.cos(f), f = -Math.sin(f));
			d.a = e;
			d.b = f;
			d.c = g;
			d.d = h;
			var k = b._scaleX,
				m = b._scaleY,
				n = this._anchorPointInPoints.x,
				p = this._anchorPointInPoints.y,
				r = 0.000001 > k && -0.000001 < k ? 0.000001 : k,
				t = 0.000001 > m && -0.000001 < m ? 0.000001 : m;
			if (1 !== k || 1 !== m) {
				e = d.a *= r, f = d.b *= r, g = d.c *= t, h = d.d *= t
			}
			if (b._skewX || b._skewY) {
				k = Math.tan(-b._skewX * Math.PI / 180), m = Math.tan(-b._skewY * Math.PI / 180), Infinity === k && (k = 99999999), Infinity === m && (m = 99999999), r = p * k, t = n * m, d.a = e - g * m, d.b = f - h * m, d.c = g - e * k, d.d = h - f * k, d.tx += e * r + g * t, d.ty += f * r + h * t
			}
			d.tx -= e * n + g * p;
			d.ty -= f * n + h * p;
			b._ignoreAnchorPointForPosition && (d.tx += n, d.ty += p);
			b._additionalTransformDirty && (this._transform = cc.affineTransformConcat(d, b._additionalTransform))
		}
		return this._transform
	};
	b.visit = function(b) {
		var d = this._node;
		if (d._visible) {
			if (b = b || this.getParentRenderCmd()) {
				this._curLevel = b._curLevel + 1
			}
			var e = d._children,
				f;
			this._syncStatus(b);
			b = e.length;
			if (0 < b) {
				d.sortAllChildren();
				for (d = 0; d < b; d++) {
					if (f = e[d], 0 > f._localZOrder) {
						f._renderCmd.visit(this)
					} else {
						break
					}
				}
				for (cc.renderer.pushRenderCommand(this); d < b; d++) {
					e[d]._renderCmd.visit(this)
				}
			} else {
				cc.renderer.pushRenderCommand(this)
			}
			this._dirtyFlag = 0
		}
	};
	b._syncStatus = function(b) {
		var d = cc.Node._dirtyFlags,
			e = this._dirtyFlag,
			f = b ? b._node : null;
		f && f._cascadeColorEnabled && b._dirtyFlag & d.colorDirty && (e |= d.colorDirty);
		f && f._cascadeOpacityEnabled && b._dirtyFlag & d.opacityDirty && (e |= d.opacityDirty);
		b && b._dirtyFlag & d.transformDirty && (e |= d.transformDirty);
		var f = e & d.colorDirty,
			g = e & d.opacityDirty,
			d = e & d.transformDirty;
		this._dirtyFlag = e;
		f && this._syncDisplayColor();
		g && this._syncDisplayOpacity();
		f && this._updateColor();
		d && this.transform(b)
	};
	b.setDirtyFlag = function(b) {
		cc.Node.RenderCmd.prototype.setDirtyFlag.call(this, b);
		this._setCacheDirty();
		this._cachedParent && this._cachedParent.setDirtyFlag(b)
	};
	b._setCacheDirty = function() {
		if (!1 === this._cacheDirty) {
			this._cacheDirty = !0;
			var b = this._cachedParent;
			b && b !== this && b._setNodeDirtyForCache && b._setNodeDirtyForCache()
		}
	};
	b._setCachedParent = function(b) {
		if (this._cachedParent !== b) {
			this._cachedParent = b;
			for (var d = this._node._children, e = 0, f = d.length; e < f; e++) {
				d[e]._renderCmd._setCachedParent(b)
			}
		}
	};
	b.detachFromParent = function() {
		this._cachedParent = null;
		for (var b = this._node._children, d, e = 0, f = b.length; e < f; e++) {
			(d = b[e]) && d._renderCmd && d._renderCmd.detachFromParent()
		}
	};
	b.setShaderProgram = function(b) {};
	b.getShaderProgram = function() {
		return null
	};
	cc.Node.CanvasRenderCmd._getCompositeOperationByBlendFunc = function(b) {
		return b ? b.src === cc.SRC_ALPHA && b.dst === cc.ONE || b.src === cc.ONE && b.dst === cc.ONE ? "lighter" : b.src === cc.ZERO && b.dst === cc.SRC_ALPHA ? "destination-in" : b.src === cc.ZERO && b.dst === cc.ONE_MINUS_SRC_ALPHA ? "destination-out" : "source-over" : "source-over"
	}
})();
(function() {
	cc.Node.WebGLRenderCmd = function(b) {
		cc.Node.RenderCmd.call(this, b);
		b = new cc.math.Matrix4;
		var d = b.mat;
		d[2] = d[3] = d[6] = d[7] = d[8] = d[9] = d[11] = d[14] = 0;
		d[10] = d[15] = 1;
		this._transform4x4 = b;
		this._stackMatrix = new cc.math.Matrix4;
		this._camera = this._shaderProgram = null
	};
	var b = cc.Node.WebGLRenderCmd.prototype = Object.create(cc.Node.RenderCmd.prototype);
	b.constructor = cc.Node.WebGLRenderCmd;
	b.getNodeToParentTransform = function() {
		var b = this._node;
		if (b._usingNormalizedPosition && b._parent) {
			var d = b._parent._contentSize;
			b._position.x = b._normalizedPosition.x * d.width;
			b._position.y = b._normalizedPosition.y * d.height;
			b._normalizedPositionDirty = !1
		}
		if (this._dirtyFlag & cc.Node._dirtyFlags.transformDirty) {
			var d = b._position.x,
				e = b._position.y,
				f = this._anchorPointInPoints.x,
				g = -f,
				h = this._anchorPointInPoints.y,
				k = -h,
				m = b._scaleX,
				n = b._scaleY,
				p = 0.017453292519943295 * b._rotationX,
				r = 0.017453292519943295 * b._rotationY;
			b._ignoreAnchorPointForPosition && (d += f, e += h);
			var t = 1,
				s = 0,
				v = 1,
				u = 0;
			if (0 !== b._rotationX || 0 !== b._rotationY) {
				t = Math.cos(-p), s = Math.sin(-p), v = Math.cos(-r), u = Math.sin(-r)
			}
			p = b._skewX || b._skewY;
			p || 0 === f && 0 === h || (d += v * g * m + -s * k * n, e += u * g * m + t * k * n);
			r = this._transform;
			r.a = v * m;
			r.b = u * m;
			r.c = -s * n;
			r.d = t * n;
			r.tx = d;
			r.ty = e;
			p && (r = cc.affineTransformConcat({
				a: 1,
				b: Math.tan(cc.degreesToRadians(b._skewY)),
				c: Math.tan(cc.degreesToRadians(b._skewX)),
				d: 1,
				tx: 0,
				ty: 0
			}, r), 0 !== f || 0 !== h) && (r = cc.affineTransformTranslate(r, g, k));
			b._additionalTransformDirty && (r = cc.affineTransformConcat(r, b._additionalTransform), b._additionalTransformDirty = !1);
			this._transform = r
		}
		return this._transform
	};
	b._syncStatus = function(b) {
		var d = cc.Node._dirtyFlags,
			e = this._dirtyFlag,
			f = b ? b._node : null;
		f && f._cascadeColorEnabled && b._dirtyFlag & d.colorDirty && (e |= d.colorDirty);
		f && f._cascadeOpacityEnabled && b._dirtyFlag & d.opacityDirty && (e |= d.opacityDirty);
		b && b._dirtyFlag & d.transformDirty && (e |= d.transformDirty);
		f = e & d.colorDirty;
		d = e & d.opacityDirty;
		this._dirtyFlag = e;
		f && this._syncDisplayColor();
		d && this._syncDisplayOpacity();
		(f || d) && this._updateColor();
		this.transform(b)
	};
	b._updateColor = function() {};
	b.visit = function(b) {
		var d = this._node;
		if (d._visible) {
			b = b || this.getParentRenderCmd();
			d._parent && d._parent._renderCmd && (this._curLevel = d._parent._renderCmd._curLevel + 1);
			var e = cc.current_stack;
			e.stack.push(e.top);
			this._syncStatus(b);
			e.top = this._stackMatrix;
			if ((b = d._children) && 0 < b.length) {
				var f = b.length;
				d.sortAllChildren();
				for (d = 0; d < f; d++) {
					if (b[d] && 0 > b[d]._localZOrder) {
						b[d]._renderCmd.visit(this)
					} else {
						break
					}
				}
				for (cc.renderer.pushRenderCommand(this); d < f; d++) {
					b[d] && b[d]._renderCmd.visit(this)
				}
			} else {
				cc.renderer.pushRenderCommand(this)
			}
			this._dirtyFlag = 0;
			e.top = e.stack.pop()
		}
	};
	b.transform = function(b, d) {
		var e = this._transform4x4,
			f = this._stackMatrix,
			g = this._node,
			h = (b = b || this.getParentRenderCmd()) ? b._stackMatrix : cc.current_stack.top,
			k = this.getNodeToParentTransform();
		this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.transformDirty;
		var m = e.mat;
		m[0] = k.a;
		m[4] = k.c;
		m[12] = k.tx;
		m[1] = k.b;
		m[5] = k.d;
		m[13] = k.ty;
		m[14] = g._vertexZ;
		cc.kmMat4Multiply(f, h, e);
		null === g._camera || null !== g.grid && g.grid.isActive() || (h = this._anchorPointInPoints.x, k = this._anchorPointInPoints.y, 0 !== h || 0 !== k ? (cc.SPRITEBATCHNODE_RENDER_SUBPIXEL || (h |= 0, k |= 0), m = cc.math.Matrix4.createByTranslation(h, k, 0, e), f.multiply(m), g._camera._locateForRenderer(f), m = cc.math.Matrix4.createByTranslation(-h, -k, 0, m), f.multiply(m), e.identity()) : g._camera._locateForRenderer(f));
		if (d && g._children && 0 !== g._children.length) {
			for (g = g._children, e = 0, f = g.length; e < f; e++) {
				g[e]._renderCmd.transform(this, d)
			}
		}
	};
	b.setShaderProgram = function(b) {
		this._shaderProgram = b
	};
	b.getShaderProgram = function() {
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
	_textureForCanvas: null,
	ctor: function(b, c, d, e) {
		cc.Node.prototype.ctor.call(this);
		this._blendFunc = {
			src: cc.BLEND_SRC,
			dst: cc.BLEND_DST
		};
		this._ignoreContentScaleFactor = !1;
		void 0 !== e && this.initWithTileFile(b, c, d, e)
	},
	_createRenderCmd: function() {
		this._renderCmd = cc._renderType === cc._RENDER_TYPE_CANVAS ? new cc.AtlasNode.CanvasRenderCmd(this) : new cc.AtlasNode.WebGLRenderCmd(this)
	},
	updateAtlasValues: function() {
		cc.log(cc._LogInfos.AtlasNode_updateAtlasValues)
	},
	getColor: function() {
		return this._opacityModifyRGB ? this._renderCmd._colorUnmodified : cc.Node.prototype.getColor.call(this)
	},
	setOpacityModifyRGB: function(b) {
		var c = this.color;
		this._opacityModifyRGB = b;
		this.setColor(c)
	},
	isOpacityModifyRGB: function() {
		return this._opacityModifyRGB
	},
	getBlendFunc: function() {
		return this._blendFunc
	},
	setBlendFunc: function(b, c) {
		this._blendFunc = void 0 === c ? b : {
			src: b,
			dst: c
		}
	},
	setTextureAtlas: function(b) {
		this.textureAtlas = b
	},
	getTextureAtlas: function() {
		return this.textureAtlas
	},
	getQuadsToDraw: function() {
		return this.quadsToDraw
	},
	setQuadsToDraw: function(b) {
		this.quadsToDraw = b
	},
	initWithTileFile: function(b, c, d, e) {
		if (!b) {
			throw "cc.AtlasNode.initWithTileFile(): title should not be null"
		}
		b = cc.textureCache.addImage(b);
		return this.initWithTexture(b, c, d, e)
	},
	initWithTexture: function(b, c, d, e) {
		return this._renderCmd.initWithTexture(b, c, d, e)
	},
	setColor: function(b) {
		this._renderCmd.setColor(b)
	},
	setOpacity: function(b) {
		this._renderCmd.setOpacity(b)
	},
	getTexture: function() {
		return this._renderCmd.getTexture()
	},
	setTexture: function(b) {
		this._renderCmd.setTexture(b)
	},
	_setIgnoreContentScaleFactor: function(b) {
		this._ignoreContentScaleFactor = b
	}
});
_p = cc.AtlasNode.prototype;
cc.defineGetterSetter(_p, "opacity", _p.getOpacity, _p.setOpacity);
cc.defineGetterSetter(_p, "color", _p.getColor, _p.setColor);
cc.defineGetterSetter(_p, "texture", _p.getTexture, _p.setTexture);
cc.EventHelper.prototype.apply(_p);
cc.AtlasNode.create = function(b, c, d, e) {
	return new cc.AtlasNode(b, c, d, e)
};
(function() {
	cc.AtlasNode.CanvasRenderCmd = function(b) {
		cc.Node.CanvasRenderCmd.call(this, b);
		this._needDraw = !1;
		this._colorUnmodified = cc.color.WHITE;
		this._texture = this._originalTexture = null
	};
	var b = cc.AtlasNode.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
	b.constructor = cc.AtlasNode.CanvasRenderCmd;
	b.initWithTexture = function(b, d, e, f) {
		var g = this._node;
		g._itemWidth = d;
		g._itemHeight = e;
		g._opacityModifyRGB = !0;
		this._originalTexture = b;
		if (!this._originalTexture) {
			return cc.log(cc._LogInfos.AtlasNode__initWithTexture), !1
		}
		this._texture = this._originalTexture;
		this._calculateMaxItems();
		g.quadsToDraw = f;
		return !0
	};
	b.setColor = function(b) {
		var d = this._node._realColor;
		if (d.r !== b.r || d.g !== b.g || d.b !== b.b) {
			this._colorUnmodified = b, this._changeTextureColor()
		}
	};
	b._changeTextureColor = cc.sys._supportCanvasNewBlendModes ?
	function() {
		var b = this._node,
			d = b.getTexture();
		if (d && this._originalTexture) {
			var e = this._originalTexture.getHtmlElementObj();
			if (e) {
				var f = d.getHtmlElementObj(),
					d = cc.rect(0, 0, e.width, e.height);
				f instanceof HTMLCanvasElement ? cc.Sprite.CanvasRenderCmd._generateTintImageWithMultiply(e, this._colorUnmodified, d, f) : (f = cc.Sprite.CanvasRenderCmd._generateTintImageWithMultiply(e, this._colorUnmodified, d), d = new cc.Texture2D, d.initWithElement(f), d.handleLoadedTexture(), b.setTexture(d))
			}
		}
	} : function() {
		var b = this._node,
			d, e = b.getTexture();
		if (e && this._originalTexture && (d = e.getHtmlElementObj())) {
			var f = this._originalTexture.getHtmlElementObj();
			if (e = cc.textureCache.getTextureColors(f)) {
				f = cc.rect(0, 0, f.width, f.height), d instanceof HTMLCanvasElement ? cc.Sprite.CanvasRenderCmd._generateTintImage(d, e, this._displayedColor, f, d) : (d = cc.Sprite.CanvasRenderCmd._generateTintImage(d, e, this._displayedColor, f), e = new cc.Texture2D, e.initWithElement(d), e.handleLoadedTexture(), b.setTexture(e))
			}
		}
	};
	b.setOpacity = function(b) {
		cc.Node.prototype.setOpacity.call(this._node, b)
	};
	b.getTexture = function() {
		return this._texture
	};
	b.setTexture = function(b) {
		this._texture = b
	};
	b._calculateMaxItems = function() {
		var b = this._node,
			d = this._texture.getContentSize();
		b._itemsPerColumn = 0 | d.height / b._itemHeight;
		b._itemsPerRow = 0 | d.width / b._itemWidth
	}
})();
(function() {
	cc.AtlasNode.WebGLRenderCmd = function(b) {
		cc.Node.WebGLRenderCmd.call(this, b);
		this._needDraw = !0;
		this._textureAtlas = null;
		this._colorUnmodified = cc.color.WHITE;
		this._uniformColor = this._colorF32Array = null;
		this._shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_TEXTURE_UCOLOR);
		this._uniformColor = cc._renderContext.getUniformLocation(this._shaderProgram.getProgram(), "u_color")
	};
	var b = cc.AtlasNode.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
	b.constructor = cc.AtlasNode.WebGLRenderCmd;
	b._updateBlendFunc = function() {
		var b = this._node;
		this._textureAtlas.texture.hasPremultipliedAlpha() || (b._blendFunc.src = cc.SRC_ALPHA, b._blendFunc.dst = cc.ONE_MINUS_SRC_ALPHA)
	};
	b._updateOpacityModifyRGB = function() {
		this._node._opacityModifyRGB = this._textureAtlas.texture.hasPremultipliedAlpha()
	};
	b.rendering = function(b) {
		b = b || cc._renderContext;
		var d = this._node;
		this._shaderProgram.use();
		this._shaderProgram._setUniformForMVPMatrixWithMat4(this._stackMatrix);
		cc.glBlendFunc(d._blendFunc.src, d._blendFunc.dst);
		this._uniformColor && this._colorF32Array && (b.uniform4fv(this._uniformColor, this._colorF32Array), this._textureAtlas.drawNumberOfQuads(d.quadsToDraw, 0))
	};
	b.initWithTexture = function(b, d, e, f) {
		var g = this._node;
		g._itemWidth = d;
		g._itemHeight = e;
		this._colorUnmodified = cc.color.WHITE;
		g._opacityModifyRGB = !0;
		g._blendFunc.src = cc.BLEND_SRC;
		g._blendFunc.dst = cc.BLEND_DST;
		d = g._realColor;
		this._colorF32Array = new Float32Array([d.r / 255, d.g / 255, d.b / 255, g._realOpacity / 255]);
		this._textureAtlas = new cc.TextureAtlas;
		this._textureAtlas.initWithTexture(b, f);
		if (!this._textureAtlas) {
			return cc.log(cc._LogInfos.AtlasNode__initWithTexture), !1
		}
		this._updateBlendFunc();
		this._updateOpacityModifyRGB();
		this._calculateMaxItems();
		g.quadsToDraw = f;
		return !0
	};
	b.setColor = function(b) {
		var d = cc.color(b.r, b.g, b.b),
			e = this._node;
		this._colorUnmodified = b;
		b = this._displayedOpacity;
		e._opacityModifyRGB && (d.r = d.r * b / 255, d.g = d.g * b / 255, d.b = d.b * b / 255);
		cc.Node.prototype.setColor.call(e, d)
	};
	b.setOpacity = function(b) {
		var d = this._node;
		cc.Node.prototype.setOpacity.call(d, b);
		d._opacityModifyRGB && (d.color = this._colorUnmodified)
	};
	b._updateColor = function() {
		var b = this._displayedColor;
		this._colorF32Array = new Float32Array([b.r / 255, b.g / 255, b.b / 255, this._displayedOpacity / 255])
	};
	b.getTexture = function() {
		return this._textureAtlas.texture
	};
	b.setTexture = function(b) {
		this._textureAtlas.texture = b;
		this._updateBlendFunc();
		this._updateOpacityModifyRGB()
	};
	b._calculateMaxItems = function() {
		var b = this._node,
			d = this._textureAtlas.texture,
			e = d.getContentSize();
		b._ignoreContentScaleFactor && (e = d.getContentSizeInPixels());
		b._itemsPerColumn = 0 | e.height / b._itemHeight;
		b._itemsPerRow = 0 | e.width / b._itemWidth
	}
})();
cc._tmp.WebGLTexture2D = function() {
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
		ctor: function() {
			this._contentSize = cc.size(0, 0);
			this._pixelFormat = cc.Texture2D.defaultPixelFormat
		},
		releaseTexture: function() {
			this._webTextureObj && cc._renderContext.deleteTexture(this._webTextureObj);
			cc.loader.release(this.url)
		},
		getPixelFormat: function() {
			return this._pixelFormat
		},
		getPixelsWide: function() {
			return this._pixelsWide
		},
		getPixelsHigh: function() {
			return this._pixelsHigh
		},
		getName: function() {
			return this._webTextureObj
		},
		getContentSize: function() {
			return cc.size(this._contentSize.width / cc.contentScaleFactor(), this._contentSize.height / cc.contentScaleFactor())
		},
		_getWidth: function() {
			return this._contentSize.width / cc.contentScaleFactor()
		},
		_getHeight: function() {
			return this._contentSize.height / cc.contentScaleFactor()
		},
		getContentSizeInPixels: function() {
			return this._contentSize
		},
		getMaxS: function() {
			return this.maxS
		},
		setMaxS: function(b) {
			this.maxS = b
		},
		getMaxT: function() {
			return this.maxT
		},
		setMaxT: function(b) {
			this.maxT = b
		},
		getShaderProgram: function() {
			return this.shaderProgram
		},
		setShaderProgram: function(b) {
			this.shaderProgram = b
		},
		hasPremultipliedAlpha: function() {
			return this._hasPremultipliedAlpha
		},
		hasMipmaps: function() {
			return this._hasMipmaps
		},
		description: function() {
			return "<cc.Texture2D | Name = " + this._name + " | Dimensions = " + this._pixelsWide + " x " + this._pixelsHigh + " | Coordinates = (" + this.maxS + ", " + this.maxT + ")>"
		},
		releaseData: function(b) {},
		keepData: function(b, c) {
			return b
		},
		initWithData: function(b, c, d, e, f) {
			var g = cc.Texture2D,
				h = cc._renderContext,
				k = h.RGBA,
				m = h.UNSIGNED_BYTE,
				n = d * cc.Texture2D._B[c] / 8;
			0 === n % 8 ? h.pixelStorei(h.UNPACK_ALIGNMENT, 8) : 0 === n % 4 ? h.pixelStorei(h.UNPACK_ALIGNMENT, 4) : 0 === n % 2 ? h.pixelStorei(h.UNPACK_ALIGNMENT, 2) : h.pixelStorei(h.UNPACK_ALIGNMENT, 1);
			this._webTextureObj = h.createTexture();
			cc.glBindTexture2D(this);
			h.texParameteri(h.TEXTURE_2D, h.TEXTURE_MIN_FILTER, h.LINEAR);
			h.texParameteri(h.TEXTURE_2D, h.TEXTURE_MAG_FILTER, h.LINEAR);
			h.texParameteri(h.TEXTURE_2D, h.TEXTURE_WRAP_S, h.CLAMP_TO_EDGE);
			h.texParameteri(h.TEXTURE_2D, h.TEXTURE_WRAP_T, h.CLAMP_TO_EDGE);
			switch (c) {
			case g.PIXEL_FORMAT_RGBA8888:
				k = h.RGBA;
				break;
			case g.PIXEL_FORMAT_RGB888:
				k = h.RGB;
				break;
			case g.PIXEL_FORMAT_RGBA4444:
				m = h.UNSIGNED_SHORT_4_4_4_4;
				break;
			case g.PIXEL_FORMAT_RGB5A1:
				m = h.UNSIGNED_SHORT_5_5_5_1;
				break;
			case g.PIXEL_FORMAT_RGB565:
				m = h.UNSIGNED_SHORT_5_6_5;
				break;
			case g.PIXEL_FORMAT_AI88:
				k = h.LUMINANCE_ALPHA;
				break;
			case g.PIXEL_FORMAT_A8:
				k = h.ALPHA;
				break;
			case g.PIXEL_FORMAT_I8:
				k = h.LUMINANCE;
				break;
			default:
				cc.assert(0, cc._LogInfos.Texture2D_initWithData)
			}
			h.texImage2D(h.TEXTURE_2D, 0, k, d, e, 0, k, m, b);
			this._contentSize.width = f.width;
			this._contentSize.height = f.height;
			this._pixelsWide = d;
			this._pixelsHigh = e;
			this._pixelFormat = c;
			this.maxS = f.width / d;
			this.maxT = f.height / e;
			this._hasMipmaps = this._hasPremultipliedAlpha = !1;
			this.shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_TEXTURE);
			return this._textureLoaded = !0
		},
		drawAtPoint: function(b) {
			var c = [0, this.maxT, this.maxS, this.maxT, 0, 0, this.maxS, 0],
				d = this._pixelsWide * this.maxS,
				e = this._pixelsHigh * this.maxT;
			b = [b.x, b.y, 0, d + b.x, b.y, 0, b.x, e + b.y, 0, d + b.x, e + b.y, 0];
			cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION | cc.VERTEX_ATTRIB_FLAG_TEX_COORDS);
			this._shaderProgram.use();
			this._shaderProgram.setUniformsForBuiltins();
			cc.glBindTexture2D(this);
			d = cc._renderContext;
			d.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, d.FLOAT, !1, 0, b);
			d.vertexAttribPointer(cc.VERTEX_ATTRIB_TEX_COORDS, 2, d.FLOAT, !1, 0, c);
			d.drawArrays(d.TRIANGLE_STRIP, 0, 4)
		},
		drawInRect: function(b) {
			var c = [0, this.maxT, this.maxS, this.maxT, 0, 0, this.maxS, 0];
			b = [b.x, b.y, b.x + b.width, b.y, b.x, b.y + b.height, b.x + b.width, b.y + b.height];
			cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION | cc.VERTEX_ATTRIB_FLAG_TEX_COORDS);
			this._shaderProgram.use();
			this._shaderProgram.setUniformsForBuiltins();
			cc.glBindTexture2D(this);
			var d = cc._renderContext;
			d.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, d.FLOAT, !1, 0, b);
			d.vertexAttribPointer(cc.VERTEX_ATTRIB_TEX_COORDS, 2, d.FLOAT, !1, 0, c);
			d.drawArrays(d.TRIANGLE_STRIP, 0, 4)
		},
		initWithImage: function(b) {
			if (null == b) {
				return cc.log(cc._LogInfos.Texture2D_initWithImage), !1
			}
			var c = b.getWidth(),
				d = b.getHeight(),
				e = cc.configuration.getMaxTextureSize();
			if (c > e || d > e) {
				return cc.log(cc._LogInfos.Texture2D_initWithImage_2, c, d, e, e), !1
			}
			this._textureLoaded = !0;
			return this._initPremultipliedATextureWithImage(b, c, d)
		},
		initWithElement: function(b) {
			b && (this._webTextureObj = cc._renderContext.createTexture(), this._htmlElementObj = b, this._textureLoaded = !0)
		},
		getHtmlElementObj: function() {
			return this._htmlElementObj
		},
		isLoaded: function() {
			return this._textureLoaded
		},
		handleLoadedTexture: function(b) {
			b = void 0 === b ? !1 : b;
			if (cc._rendererInitialized) {
				if (!this._htmlElementObj) {
					var c = cc.loader.getRes(this.url);
					if (!c) {
						return
					}
					this.initWithElement(c)
				}
				this._htmlElementObj.width && this._htmlElementObj.height && (c = cc._renderContext, cc.glBindTexture2D(this), c.pixelStorei(c.UNPACK_ALIGNMENT, 4), b && c.pixelStorei(c.UNPACK_PREMULTIPLY_ALPHA_WEBGL, 1), c.texImage2D(c.TEXTURE_2D, 0, c.RGBA, c.RGBA, c.UNSIGNED_BYTE, this._htmlElementObj), c.texParameteri(c.TEXTURE_2D, c.TEXTURE_MIN_FILTER, c.LINEAR), c.texParameteri(c.TEXTURE_2D, c.TEXTURE_MAG_FILTER, c.LINEAR), c.texParameteri(c.TEXTURE_2D, c.TEXTURE_WRAP_S, c.CLAMP_TO_EDGE), c.texParameteri(c.TEXTURE_2D, c.TEXTURE_WRAP_T, c.CLAMP_TO_EDGE), this.shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_TEXTURE), cc.glBindTexture2D(null), b && c.pixelStorei(c.UNPACK_PREMULTIPLY_ALPHA_WEBGL, 0), c = this._htmlElementObj.height, this._pixelsWide = this._contentSize.width = this._htmlElementObj.width, this._pixelsHigh = this._contentSize.height = c, this._pixelFormat = cc.Texture2D.PIXEL_FORMAT_RGBA8888, this.maxT = this.maxS = 1, this._hasPremultipliedAlpha = b, this._hasMipmaps = !1, this.dispatchEvent("load"))
			}
		},
		initWithString: function(b, c, d, e, f, g) {
			cc.log(cc._LogInfos.Texture2D_initWithString);
			return null
		},
		initWithETCFile: function(b) {
			cc.log(cc._LogInfos.Texture2D_initWithETCFile_2);
			return !1
		},
		initWithPVRFile: function(b) {
			cc.log(cc._LogInfos.Texture2D_initWithPVRFile_2);
			return !1
		},
		initWithPVRTCData: function(b, c, d, e, f, g) {
			cc.log(cc._LogInfos.Texture2D_initWithPVRTCData_2);
			return !1
		},
		setTexParameters: function(b, c, d, e) {
			var f = cc._renderContext;
			void 0 !== c && (b = {
				minFilter: b,
				magFilter: c,
				wrapS: d,
				wrapT: e
			});
			cc.assert(this._pixelsWide === cc.NextPOT(this._pixelsWide) && this._pixelsHigh === cc.NextPOT(this._pixelsHigh) || b.wrapS === f.CLAMP_TO_EDGE && b.wrapT === f.CLAMP_TO_EDGE, "WebGLRenderingContext.CLAMP_TO_EDGE should be used in NPOT textures");
			cc.glBindTexture2D(this);
			f.texParameteri(f.TEXTURE_2D, f.TEXTURE_MIN_FILTER, b.minFilter);
			f.texParameteri(f.TEXTURE_2D, f.TEXTURE_MAG_FILTER, b.magFilter);
			f.texParameteri(f.TEXTURE_2D, f.TEXTURE_WRAP_S, b.wrapS);
			f.texParameteri(f.TEXTURE_2D, f.TEXTURE_WRAP_T, b.wrapT)
		},
		setAntiAliasTexParameters: function() {
			var b = cc._renderContext;
			cc.glBindTexture2D(this);
			this._hasMipmaps ? b.texParameteri(b.TEXTURE_2D, b.TEXTURE_MIN_FILTER, b.LINEAR_MIPMAP_NEAREST) : b.texParameteri(b.TEXTURE_2D, b.TEXTURE_MIN_FILTER, b.LINEAR);
			b.texParameteri(b.TEXTURE_2D, b.TEXTURE_MAG_FILTER, b.LINEAR)
		},
		setAliasTexParameters: function() {
			var b = cc._renderContext;
			cc.glBindTexture2D(this);
			this._hasMipmaps ? b.texParameteri(b.TEXTURE_2D, b.TEXTURE_MIN_FILTER, b.NEAREST_MIPMAP_NEAREST) : b.texParameteri(b.TEXTURE_2D, b.TEXTURE_MIN_FILTER, b.NEAREST);
			b.texParameteri(b.TEXTURE_2D, b.TEXTURE_MAG_FILTER, b.NEAREST)
		},
		generateMipmap: function() {
			cc.assert(this._pixelsWide === cc.NextPOT(this._pixelsWide) && this._pixelsHigh === cc.NextPOT(this._pixelsHigh), "Mimpap texture only works in POT textures");
			cc.glBindTexture2D(this);
			cc._renderContext.generateMipmap(cc._renderContext.TEXTURE_2D);
			this._hasMipmaps = !0
		},
		stringForFormat: function() {
			return cc.Texture2D._M[this._pixelFormat]
		},
		bitsPerPixelForFormat: function(b) {
			b = b || this._pixelFormat;
			var c = cc.Texture2D._B[b];
			if (null != c) {
				return c
			}
			cc.log(cc._LogInfos.Texture2D_bitsPerPixelForFormat, b);
			return -1
		},
		_initPremultipliedATextureWithImage: function(b, c, d) {
			var e = cc.Texture2D,
				f = b.getData(),
				g = null,
				g = null,
				h = b.hasAlpha(),
				k = cc.size(b.getWidth(), b.getHeight()),
				m = e.defaultPixelFormat,
				n = b.getBitsPerComponent();
			h || (8 <= n ? m = e.PIXEL_FORMAT_RGB888 : (cc.log(cc._LogInfos.Texture2D__initPremultipliedATextureWithImage), m = e.PIXEL_FORMAT_RGB565));
			var p = c * d;
			if (m === e.PIXEL_FORMAT_RGB565) {
				if (h) {
					for (f = new Uint16Array(c * d), g = b.getData(), n = 0; n < p; ++n) {
						f[n] = (g[n] >> 0 & 255) >> 3 << 11 | (g[n] >> 8 & 255) >> 2 << 5 | (g[n] >> 16 & 255) >> 3 << 0
					}
				} else {
					for (f = new Uint16Array(c * d), g = b.getData(), n = 0; n < p; ++n) {
						f[n] = (g[n] & 255) >> 3 << 11 | (g[n] & 255) >> 2 << 5 | (g[n] & 255) >> 3 << 0
					}
				}
			} else {
				if (m === e.PIXEL_FORMAT_RGBA4444) {
					for (f = new Uint16Array(c * d), g = b.getData(), n = 0; n < p; ++n) {
						f[n] = (g[n] >> 0 & 255) >> 4 << 12 | (g[n] >> 8 & 255) >> 4 << 8 | (g[n] >> 16 & 255) >> 4 << 4 | (g[n] >> 24 & 255) >> 4 << 0
					}
				} else {
					if (m === e.PIXEL_FORMAT_RGB5A1) {
						for (f = new Uint16Array(c * d), g = b.getData(), n = 0; n < p; ++n) {
							f[n] = (g[n] >> 0 & 255) >> 3 << 11 | (g[n] >> 8 & 255) >> 3 << 6 | (g[n] >> 16 & 255) >> 3 << 1 | (g[n] >> 24 & 255) >> 7 << 0
						}
					} else {
						if (m === e.PIXEL_FORMAT_A8) {
							for (f = new Uint8Array(c * d), g = b.getData(), n = 0; n < p; ++n) {
								f[n] = g >> 24 & 255
							}
						}
					}
				}
			}
			if (h && m === e.PIXEL_FORMAT_RGB888) {
				for (g = b.getData(), f = new Uint8Array(c * d * 3), n = 0; n < p; ++n) {
					f[3 * n] = g >> 0 & 255, f[3 * n + 1] = g >> 8 & 255, f[3 * n + 2] = g >> 16 & 255
				}
			}
			this.initWithData(f, m, c, d, k);
			b.getData();
			this._hasPremultipliedAlpha = b.isPremultipliedAlpha();
			return !0
		},
		addLoadedEventListener: function(b, c) {
			this.addEventListener("load", b, c)
		},
		removeLoadedEventListener: function(b) {
			this.removeEventListener("load", b)
		}
	})
};
cc._tmp.WebGLTextureAtlas = function() {
	var b = cc.TextureAtlas.prototype;
	b._setupVBO = function() {
		var b = cc._renderContext;
		this._buffersVBO[0] = b.createBuffer();
		this._buffersVBO[1] = b.createBuffer();
		this._quadsWebBuffer = b.createBuffer();
		this._mapBuffers()
	};
	b._mapBuffers = function() {
		var b = cc._renderContext;
		b.bindBuffer(b.ARRAY_BUFFER, this._quadsWebBuffer);
		b.bufferData(b.ARRAY_BUFFER, this._quadsArrayBuffer, b.DYNAMIC_DRAW);
		b.bindBuffer(b.ELEMENT_ARRAY_BUFFER, this._buffersVBO[1]);
		b.bufferData(b.ELEMENT_ARRAY_BUFFER, this._indices, b.STATIC_DRAW)
	};
	b.drawNumberOfQuads = function(b, d) {
		d = d || 0;
		if (0 !== b && this.texture && this.texture.isLoaded()) {
			var e = cc._renderContext;
			cc.glBindTexture2D(this.texture);
			cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POS_COLOR_TEX);
			e.bindBuffer(e.ARRAY_BUFFER, this._quadsWebBuffer);
			this.dirty && (e.bufferData(e.ARRAY_BUFFER, this._quadsArrayBuffer, e.DYNAMIC_DRAW), this.dirty = !1);
			e.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 3, e.FLOAT, !1, 24, 0);
			e.vertexAttribPointer(cc.VERTEX_ATTRIB_COLOR, 4, e.UNSIGNED_BYTE, !0, 24, 12);
			e.vertexAttribPointer(cc.VERTEX_ATTRIB_TEX_COORDS, 2, e.FLOAT, !1, 24, 16);
			e.bindBuffer(e.ELEMENT_ARRAY_BUFFER, this._buffersVBO[1]);
			cc.TEXTURE_ATLAS_USE_TRIANGLE_STRIP ? e.drawElements(e.TRIANGLE_STRIP, 6 * b, e.UNSIGNED_SHORT, 6 * d * this._indices.BYTES_PER_ELEMENT) : e.drawElements(e.TRIANGLES, 6 * b, e.UNSIGNED_SHORT, 6 * d * this._indices.BYTES_PER_ELEMENT);
			cc.g_NumberOfDraws++
		}
	}
};
cc._tmp.WebGLTextureCache = function() {
	var b = cc.textureCache;
	b.handleLoadedTexture = function(b) {
		var d = this._textures;
		cc._rendererInitialized || (d = this._loadedTexturesBefore);
		var e = d[b];
		e || (e = d[b] = new cc.Texture2D, e.url = b);
		e.handleLoadedTexture()
	};
	b.addImage = function(b, d, e) {
		cc.assert(b, cc._LogInfos.Texture2D_addImage_2);
		var f = this._textures;
		cc._rendererInitialized || (f = this._loadedTexturesBefore);
		var g = f[b] || f[cc.loader._aliases[b]];
		if (g) {
			return d && d.call(e, g), g
		}
		g = f[b] = new cc.Texture2D;
		g.url = b;
		(cc.loader._checkIsImageURL(b) ? cc.loader.load : cc.loader.loadImg).call(cc.loader, b, function(g, k) {
			if (g) {
				return d && d.call(e, g)
			}
			cc.textureCache.handleLoadedTexture(b);
			var m = f[b];
			d && d.call(e, m)
		});
		return g
	};
	b.addImageAsync = b.addImage;
	b = null
};
cc._tmp.PrototypeTexture2D = function() {
	var b = cc.Texture2D;
	b.PVRImagesHavePremultipliedAlpha = function(b) {
		cc.PVRHaveAlphaPremultiplied_ = b
	};
	b.PIXEL_FORMAT_RGBA8888 = 2;
	b.PIXEL_FORMAT_RGB888 = 3;
	b.PIXEL_FORMAT_RGB565 = 4;
	b.PIXEL_FORMAT_A8 = 5;
	b.PIXEL_FORMAT_I8 = 6;
	b.PIXEL_FORMAT_AI88 = 7;
	b.PIXEL_FORMAT_RGBA4444 = 8;
	b.PIXEL_FORMAT_RGB5A1 = 7;
	b.PIXEL_FORMAT_PVRTC4 = 9;
	b.PIXEL_FORMAT_PVRTC2 = 10;
	b.PIXEL_FORMAT_DEFAULT = b.PIXEL_FORMAT_RGBA8888;
	var c = cc.Texture2D._M = {};
	c[b.PIXEL_FORMAT_RGBA8888] = "RGBA8888";
	c[b.PIXEL_FORMAT_RGB888] = "RGB888";
	c[b.PIXEL_FORMAT_RGB565] = "RGB565";
	c[b.PIXEL_FORMAT_A8] = "A8";
	c[b.PIXEL_FORMAT_I8] = "I8";
	c[b.PIXEL_FORMAT_AI88] = "AI88";
	c[b.PIXEL_FORMAT_RGBA4444] = "RGBA4444";
	c[b.PIXEL_FORMAT_RGB5A1] = "RGB5A1";
	c[b.PIXEL_FORMAT_PVRTC4] = "PVRTC4";
	c[b.PIXEL_FORMAT_PVRTC2] = "PVRTC2";
	c = cc.Texture2D._B = {};
	c[b.PIXEL_FORMAT_RGBA8888] = 32;
	c[b.PIXEL_FORMAT_RGB888] = 24;
	c[b.PIXEL_FORMAT_RGB565] = 16;
	c[b.PIXEL_FORMAT_A8] = 8;
	c[b.PIXEL_FORMAT_I8] = 8;
	c[b.PIXEL_FORMAT_AI88] = 16;
	c[b.PIXEL_FORMAT_RGBA4444] = 16;
	c[b.PIXEL_FORMAT_RGB5A1] = 16;
	c[b.PIXEL_FORMAT_PVRTC4] = 4;
	c[b.PIXEL_FORMAT_PVRTC2] = 3;
	c = cc.Texture2D.prototype;
	cc.defineGetterSetter(c, "name", c.getName);
	cc.defineGetterSetter(c, "pixelFormat", c.getPixelFormat);
	cc.defineGetterSetter(c, "pixelsWidth", c.getPixelsWide);
	cc.defineGetterSetter(c, "pixelsHeight", c.getPixelsHigh);
	cc.defineGetterSetter(c, "width", c._getWidth);
	cc.defineGetterSetter(c, "height", c._getHeight);
	b.defaultPixelFormat = b.PIXEL_FORMAT_DEFAULT
};
cc._tmp.PrototypeTextureAtlas = function() {
	var b = cc.TextureAtlas.prototype;
	cc.defineGetterSetter(b, "totalQuads", b.getTotalQuads);
	cc.defineGetterSetter(b, "capacity", b.getCapacity);
	cc.defineGetterSetter(b, "quads", b.getQuads, b.setQuads)
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
cc._renderType === cc._RENDER_TYPE_CANVAS ? (cc.Texture2D = cc.Class.extend({
	_contentSize: null,
	_textureLoaded: !1,
	_htmlElementObj: null,
	url: null,
	_pattern: null,
	ctor: function() {
		this._contentSize = cc.size(0, 0);
		this._textureLoaded = !1;
		this._htmlElementObj = null;
		this._pattern = ""
	},
	getPixelsWide: function() {
		return this._contentSize.width
	},
	getPixelsHigh: function() {
		return this._contentSize.height
	},
	getContentSize: function() {
		var b = cc.contentScaleFactor();
		return cc.size(this._contentSize.width / b, this._contentSize.height / b)
	},
	_getWidth: function() {
		return this._contentSize.width / cc.contentScaleFactor()
	},
	_getHeight: function() {
		return this._contentSize.height / cc.contentScaleFactor()
	},
	getContentSizeInPixels: function() {
		return this._contentSize
	},
	initWithElement: function(b) {
		b && (this._htmlElementObj = b, this._contentSize.width = b.width, this._contentSize.height = b.height, this._textureLoaded = !0)
	},
	getHtmlElementObj: function() {
		return this._htmlElementObj
	},
	isLoaded: function() {
		return this._textureLoaded
	},
	handleLoadedTexture: function() {
		if (!this._textureLoaded) {
			if (!this._htmlElementObj) {
				var b = cc.loader.getRes(this.url);
				if (!b) {
					return
				}
				this.initWithElement(b)
			}
			b = this._htmlElementObj;
			this._contentSize.width = b.width;
			this._contentSize.height = b.height;
			this.dispatchEvent("load")
		}
	},
	description: function() {
		return "<cc.Texture2D | width = " + this._contentSize.width + " height " + this._contentSize.height + ">"
	},
	initWithData: function(b, c, d, e, f) {
		return !1
	},
	initWithImage: function(b) {
		return !1
	},
	initWithString: function(b, c, d, e, f, g) {
		return !1
	},
	releaseTexture: function() {
		cc.loader.release(this.url)
	},
	getName: function() {
		return null
	},
	getMaxS: function() {
		return 1
	},
	setMaxS: function(b) {},
	getMaxT: function() {
		return 1
	},
	setMaxT: function(b) {},
	getPixelFormat: function() {
		return null
	},
	getShaderProgram: function() {
		return null
	},
	setShaderProgram: function(b) {},
	hasPremultipliedAlpha: function() {
		return !1
	},
	hasMipmaps: function() {
		return !1
	},
	releaseData: function(b) {},
	keepData: function(b, c) {
		return b
	},
	drawAtPoint: function(b) {},
	drawInRect: function(b) {},
	initWithETCFile: function(b) {
		cc.log(cc._LogInfos.Texture2D_initWithETCFile);
		return !1
	},
	initWithPVRFile: function(b) {
		cc.log(cc._LogInfos.Texture2D_initWithPVRFile);
		return !1
	},
	initWithPVRTCData: function(b, c, d, e, f, g) {
		cc.log(cc._LogInfos.Texture2D_initWithPVRTCData);
		return !1
	},
	setTexParameters: function(b, c, d, e) {
		void 0 !== c && (b = {
			minFilter: b,
			magFilter: c,
			wrapS: d,
			wrapT: e
		});
		this._pattern = b.wrapS === cc.REPEAT && b.wrapT === cc.REPEAT ? "repeat" : b.wrapS === cc.REPEAT ? "repeat-x" : b.wrapT === cc.REPEAT ? "repeat-y" : ""
	},
	setAntiAliasTexParameters: function() {},
	setAliasTexParameters: function() {},
	generateMipmap: function() {},
	stringForFormat: function() {
		return ""
	},
	bitsPerPixelForFormat: function(b) {
		return -1
	},
	addLoadedEventListener: function(b, c) {
		this.addEventListener("load", b, c)
	},
	removeLoadedEventListener: function(b) {
		this.removeEventListener("load", b)
	},
	_grayElementObj: null,
	_backupElement: null,
	_isGray: !1,
	_switchToGray: function(b) {
		this._textureLoaded && this._isGray !== b && ((this._isGray = b) ? (this._backupElement = this._htmlElementObj, this._grayElementObj || (this._grayElementObj = cc.Texture2D._generateGrayTexture(this._htmlElementObj)), this._htmlElementObj = this._grayElementObj) : null !== this._backupElement && (this._htmlElementObj = this._backupElement))
	}
}), cc.Texture2D._generateGrayTexture = function(b, c, d) {
	if (null === b) {
		return null
	}
	d = d || cc.newElement("canvas");
	c = c || cc.rect(0, 0, b.width, b.height);
	d.width = c.width;
	d.height = c.height;
	var e = d.getContext("2d");
	e.drawImage(b, c.x, c.y, c.width, c.height, 0, 0, c.width, c.height);
	b = e.getImageData(0, 0, c.width, c.height);
	c = b.data;
	for (var f = 0, g = c.length; f < g; f += 4) {
		c[f] = c[f + 1] = c[f + 2] = 0.34 * c[f] + 0.5 * c[f + 1] + 0.16 * c[f + 2]
	}
	e.putImageData(b, 0, 0);
	return d
}) : (cc.assert(cc.isFunction(cc._tmp.WebGLTexture2D), cc._LogInfos.MissingFile, "TexturesWebGL.js"), cc._tmp.WebGLTexture2D(), delete cc._tmp.WebGLTexture2D);
cc.EventHelper.prototype.apply(cc.Texture2D.prototype);
cc.assert(cc.isFunction(cc._tmp.PrototypeTexture2D), cc._LogInfos.MissingFile, "TexturesPropertyDefine.js");
cc._tmp.PrototypeTexture2D();
delete cc._tmp.PrototypeTexture2D;
cc.textureCache = {
	_textures: {},
	_textureColorsCache: {},
	_textureKeySeq: 0 | 1000 * Math.random(),
	_loadedTexturesBefore: {},
	_initializingRenderer: function() {
		var b, c = this._loadedTexturesBefore,
			d = this._textures;
		for (b in c) {
			var e = c[b];
			e.handleLoadedTexture();
			d[b] = e
		}
		this._loadedTexturesBefore = {}
	},
	addPVRTCImage: function(b) {
		cc.log(cc._LogInfos.textureCache_addPVRTCImage)
	},
	addETCImage: function(b) {
		cc.log(cc._LogInfos.textureCache_addETCImage)
	},
	description: function() {
		return "<TextureCache | Number of textures = " + this._textures.length + ">"
	},
	textureForKey: function(b) {
		cc.log(cc._LogInfos.textureCache_textureForKey);
		return this.getTextureForKey(b)
	},
	getTextureForKey: function(b) {
		return this._textures[b] || this._textures[cc.loader._aliases[b]]
	},
	getKeyByTexture: function(b) {
		for (var c in this._textures) {
			if (this._textures[c] === b) {
				return c
			}
		}
		return null
	},
	_generalTextureKey: function() {
		this._textureKeySeq++;
		return "_textureKey_" + this._textureKeySeq
	},
	getTextureColors: function(b) {
		var c = this.getKeyByTexture(b);
		c || (c = b instanceof HTMLImageElement ? b.src : this._generalTextureKey());
		this._textureColorsCache[c] || (this._textureColorsCache[c] = cc.Sprite.CanvasRenderCmd._generateTextureCacheForColor(b));
		return this._textureColorsCache[c]
	},
	addPVRImage: function(b) {
		cc.log(cc._LogInfos.textureCache_addPVRImage)
	},
	removeAllTextures: function() {
		var b = this._textures,
			c;
		for (c in b) {
			b[c] && b[c].releaseTexture()
		}
		this._textures = {}
	},
	removeTexture: function(b) {
		if (b) {
			var c = this._textures,
				d;
			for (d in c) {
				c[d] === b && (c[d].releaseTexture(), delete c[d])
			}
		}
	},
	removeTextureForKey: function(b) {
		null != b && this._textures[b] && delete this._textures[b]
	},
	cacheImage: function(b, c) {
		if (c instanceof cc.Texture2D) {
			this._textures[b] = c
		} else {
			var d = new cc.Texture2D;
			d.initWithElement(c);
			d.handleLoadedTexture();
			this._textures[b] = d
		}
	},
	addUIImage: function(b, c) {
		cc.assert(b, cc._LogInfos.textureCache_addUIImage_2);
		if (c && this._textures[c]) {
			return this._textures[c]
		}
		var d = new cc.Texture2D;
		d.initWithImage(b);
		null != c ? this._textures[c] = d : cc.log(cc._LogInfos.textureCache_addUIImage);
		return d
	},
	dumpCachedTextureInfo: function() {
		var b = 0,
			c = 0,
			d = this._textures,
			e;
		for (e in d) {
			var f = d[e];
			b++;
			f.getHtmlElementObj() instanceof HTMLImageElement ? cc.log(cc._LogInfos.textureCache_dumpCachedTextureInfo, e, f.getHtmlElementObj().src, f.pixelsWidth, f.pixelsHeight) : cc.log(cc._LogInfos.textureCache_dumpCachedTextureInfo_2, e, f.pixelsWidth, f.pixelsHeight);
			c += f.pixelsWidth * f.pixelsHeight * 4
		}
		d = this._textureColorsCache;
		for (e in d) {
			var f = d[e],
				g;
			for (g in f) {
				var h = f[g];
				b++;
				cc.log(cc._LogInfos.textureCache_dumpCachedTextureInfo_2, e, h.width, h.height);
				c += h.width * h.height * 4
			}
		}
		cc.log(cc._LogInfos.textureCache_dumpCachedTextureInfo_3, b, c / 1024, (c / 1048576).toFixed(2))
	},
	_clear: function() {
		this._textures = {};
		this._textureColorsCache = {};
		this._textureKeySeq = 0 | 1000 * Math.random();
		this._loadedTexturesBefore = {}
	}
};
cc._renderType === cc._RENDER_TYPE_CANVAS ? (_p = cc.textureCache, _p.handleLoadedTexture = function(b) {
	var c = this._textures,
		d = c[b];
	d || (d = c[b] = new cc.Texture2D, d.url = b);
	d.handleLoadedTexture()
}, _p.addImage = function(b, c, d) {
	cc.assert(b, cc._LogInfos.Texture2D_addImage);
	var e = this._textures,
		f = e[b] || e[cc.loader._aliases[b]];
	if (f) {
		return c && c.call(d, f), f
	}
	f = e[b] = new cc.Texture2D;
	f.url = b;
	(cc.loader._checkIsImageURL(b) ? cc.loader.load : cc.loader.loadImg).call(cc.loader, b, function(f, h) {
		if (f) {
			return c && c.call(d, f)
		}
		cc.textureCache.handleLoadedTexture(b);
		var k = e[b];
		c && c.call(d, k)
	});
	return f
}, _p.addImageAsync = _p.addImage, _p = null) : (cc.assert(cc.isFunction(cc._tmp.WebGLTextureCache), cc._LogInfos.MissingFile, "TexturesWebGL.js"), cc._tmp.WebGLTextureCache(), delete cc._tmp.WebGLTextureCache);
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
	ctor: function(b, c) {
		this._buffersVBO = [];
		cc.isString(b) ? this.initWithFile(b, c) : b instanceof cc.Texture2D && this.initWithTexture(b, c)
	},
	getTotalQuads: function() {
		return this._totalQuads
	},
	getCapacity: function() {
		return this._capacity
	},
	getTexture: function() {
		return this.texture
	},
	setTexture: function(b) {
		this.texture = b
	},
	setDirty: function(b) {
		this.dirty = b
	},
	isDirty: function() {
		return this.dirty
	},
	getQuads: function() {
		return this._quads
	},
	setQuads: function(b) {
		this._quads = b
	},
	_copyQuadsToTextureAtlas: function(b, c) {
		if (b) {
			for (var d = 0; d < b.length; d++) {
				this._setQuadToArray(b[d], c + d)
			}
		}
	},
	_setQuadToArray: function(b, c) {
		var d = this._quads;
		d[c] ? (d[c].bl = b.bl, d[c].br = b.br, d[c].tl = b.tl, d[c].tr = b.tr) : d[c] = new cc.V3F_C4B_T2F_Quad(b.tl, b.bl, b.tr, b.br, this._quadsArrayBuffer, c * cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT)
	},
	description: function() {
		return "<cc.TextureAtlas | totalQuads =" + this._totalQuads + ">"
	},
	_setupIndices: function() {
		if (0 !== this._capacity) {
			for (var b = this._indices, c = this._capacity, d = 0; d < c; d++) {
				cc.TEXTURE_ATLAS_USE_TRIANGLE_STRIP ? (b[6 * d + 0] = 4 * d + 0, b[6 * d + 1] = 4 * d + 0, b[6 * d + 2] = 4 * d + 2, b[6 * d + 3] = 4 * d + 1, b[6 * d + 4] = 4 * d + 3, b[6 * d + 5] = 4 * d + 3) : (b[6 * d + 0] = 4 * d + 0, b[6 * d + 1] = 4 * d + 1, b[6 * d + 2] = 4 * d + 2, b[6 * d + 3] = 4 * d + 3, b[6 * d + 4] = 4 * d + 2, b[6 * d + 5] = 4 * d + 1)
			}
		}
	},
	_setupVBO: function() {
		var b = cc._renderContext;
		this._buffersVBO[0] = b.createBuffer();
		this._buffersVBO[1] = b.createBuffer();
		this._quadsWebBuffer = b.createBuffer();
		this._mapBuffers()
	},
	_mapBuffers: function() {
		var b = cc._renderContext;
		b.bindBuffer(b.ARRAY_BUFFER, this._quadsWebBuffer);
		b.bufferData(b.ARRAY_BUFFER, this._quadsArrayBuffer, b.DYNAMIC_DRAW);
		b.bindBuffer(b.ELEMENT_ARRAY_BUFFER, this._buffersVBO[1]);
		b.bufferData(b.ELEMENT_ARRAY_BUFFER, this._indices, b.STATIC_DRAW)
	},
	initWithFile: function(b, c) {
		var d = cc.textureCache.addImage(b);
		if (d) {
			return this.initWithTexture(d, c)
		}
		cc.log(cc._LogInfos.TextureAtlas_initWithFile, b);
		return !1
	},
	initWithTexture: function(b, c) {
		cc.assert(b, cc._LogInfos.TextureAtlas_initWithTexture);
		this._capacity = c |= 0;
		this._totalQuads = 0;
		this.texture = b;
		this._quads = [];
		this._indices = new Uint16Array(6 * c);
		var d = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT;
		this._quadsArrayBuffer = new ArrayBuffer(d * c);
		this._quadsReader = new Uint8Array(this._quadsArrayBuffer);
		if ((!this._quads || !this._indices) && 0 < c) {
			return !1
		}
		for (var e = this._quads, f = 0; f < c; f++) {
			e[f] = new cc.V3F_C4B_T2F_Quad(null, null, null, null, this._quadsArrayBuffer, f * d)
		}
		this._setupIndices();
		this._setupVBO();
		return this.dirty = !0
	},
	updateQuad: function(b, c) {
		cc.assert(b, cc._LogInfos.TextureAtlas_updateQuad);
		cc.assert(0 <= c && c < this._capacity, cc._LogInfos.TextureAtlas_updateQuad_2);
		this._totalQuads = Math.max(c + 1, this._totalQuads);
		this._setQuadToArray(b, c);
		this.dirty = !0
	},
	insertQuad: function(b, c) {
		cc.assert(c < this._capacity, cc._LogInfos.TextureAtlas_insertQuad_2);
		this._totalQuads++;
		if (this._totalQuads > this._capacity) {
			cc.log(cc._LogInfos.TextureAtlas_insertQuad)
		} else {
			var d = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT,
				e = c * d,
				f = (this._totalQuads - 1 - c) * d;
			this._quads[this._totalQuads - 1] = new cc.V3F_C4B_T2F_Quad(null, null, null, null, this._quadsArrayBuffer, (this._totalQuads - 1) * d);
			this._quadsReader.set(this._quadsReader.subarray(e, e + f), e + d);
			this._setQuadToArray(b, c);
			this.dirty = !0
		}
	},
	insertQuads: function(b, c, d) {
		d = d || b.length;
		cc.assert(c + d <= this._capacity, cc._LogInfos.TextureAtlas_insertQuads);
		var e = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT;
		this._totalQuads += d;
		if (this._totalQuads > this._capacity) {
			cc.log(cc._LogInfos.TextureAtlas_insertQuad)
		} else {
			var f = c * e,
				g = (this._totalQuads - 1 - c - d) * e,
				h = this._totalQuads - 1 - d,
				k;
			for (k = 0; k < d; k++) {
				this._quads[h + k] = new cc.V3F_C4B_T2F_Quad(null, null, null, null, this._quadsArrayBuffer, (this._totalQuads - 1) * e)
			}
			this._quadsReader.set(this._quadsReader.subarray(f, f + g), f + e * d);
			for (k = 0; k < d; k++) {
				this._setQuadToArray(b[k], c + k)
			}
			this.dirty = !0
		}
	},
	insertQuadFromIndex: function(b, c) {
		if (b !== c) {
			cc.assert(0 <= c || c < this._totalQuads, cc._LogInfos.TextureAtlas_insertQuadFromIndex);
			cc.assert(0 <= b || b < this._totalQuads, cc._LogInfos.TextureAtlas_insertQuadFromIndex_2);
			var d = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT,
				e = this._quadsReader,
				f = e.subarray(b * d, d),
				g;
			b > c ? (g = c * d, e.set(e.subarray(g, g + (b - c) * d), g + d), e.set(f, g)) : (g = (b + 1) * d, e.set(e.subarray(g, g + (c - b) * d), g - d), e.set(f, c * d));
			this.dirty = !0
		}
	},
	removeQuadAtIndex: function(b) {
		cc.assert(b < this._totalQuads, cc._LogInfos.TextureAtlas_removeQuadAtIndex);
		var c = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT;
		this._totalQuads--;
		this._quads.length = this._totalQuads;
		if (b !== this._totalQuads) {
			var d = (b + 1) * c;
			this._quadsReader.set(this._quadsReader.subarray(d, d + (this._totalQuads - b) * c), d - c)
		}
		this.dirty = !0
	},
	removeQuadsAtIndex: function(b, c) {
		cc.assert(b + c <= this._totalQuads, cc._LogInfos.TextureAtlas_removeQuadsAtIndex);
		this._totalQuads -= c;
		if (b !== this._totalQuads) {
			var d = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT,
				e = (b + c) * d,
				f = b * d;
			this._quadsReader.set(this._quadsReader.subarray(e, e + (this._totalQuads - b) * d), f)
		}
		this.dirty = !0
	},
	removeAllQuads: function() {
		this._totalQuads = this._quads.length = 0
	},
	_setDirty: function(b) {
		this.dirty = b
	},
	resizeCapacity: function(b) {
		if (b === this._capacity) {
			return !0
		}
		var c = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT,
			d = this._capacity;
		this._totalQuads = Math.min(this._totalQuads, b);
		var e = this._capacity = 0 | b,
			f = this._totalQuads;
		if (null === this._quads) {
			for (this._quads = [], this._quadsArrayBuffer = new ArrayBuffer(c * e), this._quadsReader = new Uint8Array(this._quadsArrayBuffer), b = 0; b < e; b++) {
				this._quads = new cc.V3F_C4B_T2F_Quad(null, null, null, null, this._quadsArrayBuffer, b * c)
			}
		} else {
			var g, h, k = this._quads;
			if (e > d) {
				g = [];
				h = new ArrayBuffer(c * e);
				for (b = 0; b < f; b++) {
					g[b] = new cc.V3F_C4B_T2F_Quad(k[b].tl, k[b].bl, k[b].tr, k[b].br, h, b * c)
				}
				for (; b < e; b++) {
					g[b] = new cc.V3F_C4B_T2F_Quad(null, null, null, null, h, b * c)
				}
			} else {
				for (f = Math.max(f, e), g = [], h = new ArrayBuffer(c * e), b = 0; b < f; b++) {
					g[b] = new cc.V3F_C4B_T2F_Quad(k[b].tl, k[b].bl, k[b].tr, k[b].br, h, b * c)
				}
			}
			this._quadsReader = new Uint8Array(h);
			this._quads = g;
			this._quadsArrayBuffer = h
		}
		null === this._indices ? this._indices = new Uint16Array(6 * e) : e > d ? (c = new Uint16Array(6 * e), c.set(this._indices, 0), this._indices = c) : this._indices = this._indices.subarray(0, 6 * e);
		this._setupIndices();
		this._mapBuffers();
		return this.dirty = !0
	},
	increaseTotalQuadsWith: function(b) {
		this._totalQuads += b
	},
	moveQuadsFromIndex: function(b, c, d) {
		if (void 0 === d) {
			if (d = c, c = this._totalQuads - b, cc.assert(d + (this._totalQuads - b) <= this._capacity, cc._LogInfos.TextureAtlas_moveQuadsFromIndex), 0 === c) {
				return
			}
		} else {
			if (cc.assert(d + c <= this._totalQuads, cc._LogInfos.TextureAtlas_moveQuadsFromIndex_2), cc.assert(b < this._totalQuads, cc._LogInfos.TextureAtlas_moveQuadsFromIndex_3), b === d) {
				return
			}
		}
		var e = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT,
			f = b * e,
			g = c * e,
			h = this._quadsReader,
			k = h.subarray(f, f + g),
			m = d * e;
		d < b ? (c = d * e, h.set(h.subarray(c, c + (b - d) * e), c + g)) : (c = (b + c) * e, h.set(h.subarray(c, c + (d - b) * e), f));
		h.set(k, m);
		this.dirty = !0
	},
	fillWithEmptyQuadsFromIndex: function(b, c) {
		for (var d = c * cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT, e = new Uint8Array(this._quadsArrayBuffer, b * cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT, d), f = 0; f < d; f++) {
			e[f] = 0
		}
	},
	drawQuads: function() {
		this.drawNumberOfQuads(this._totalQuads, 0)
	},
	_releaseBuffer: function() {
		var b = cc._renderContext;
		this._buffersVBO && (this._buffersVBO[0] && b.deleteBuffer(this._buffersVBO[0]), this._buffersVBO[1] && b.deleteBuffer(this._buffersVBO[1]));
		this._quadsWebBuffer && b.deleteBuffer(this._quadsWebBuffer)
	}
});
_p = cc.TextureAtlas.prototype;
cc.defineGetterSetter(_p, "totalQuads", _p.getTotalQuads);
cc.defineGetterSetter(_p, "capacity", _p.getCapacity);
cc.defineGetterSetter(_p, "quads", _p.getQuads, _p.setQuads);
cc.TextureAtlas.create = function(b, c) {
	return new cc.TextureAtlas(b, c)
};
cc.TextureAtlas.createWithTexture = cc.TextureAtlas.create;
cc._renderType === cc._RENDER_TYPE_WEBGL && (cc.assert(cc.isFunction(cc._tmp.WebGLTextureAtlas), cc._LogInfos.MissingFile, "TexturesWebGL.js"), cc._tmp.WebGLTextureAtlas(), delete cc._tmp.WebGLTextureAtlas);
cc.assert(cc.isFunction(cc._tmp.PrototypeTextureAtlas), cc._LogInfos.MissingFile, "TexturesPropertyDefine.js");
cc._tmp.PrototypeTextureAtlas();
delete cc._tmp.PrototypeTextureAtlas;
cc.Scene = cc.Node.extend({
	_className: "Scene",
	ctor: function() {
		cc.Node.prototype.ctor.call(this);
		this._ignoreAnchorPointForPosition = !0;
		this.setAnchorPoint(0.5, 0.5);
		this.setContentSize(cc.director.getWinSize())
	}
});
cc.Scene.create = function() {
	return new cc.Scene
};
cc.LoaderScene = cc.Scene.extend({
	_interval: null,
	_label: null,
	_className: "LoaderScene",
	cb: null,
	target: null,
	init: function() {
		var b = this,
			c = 200,
			d = b._bgLayer = new cc.LayerColor(cc.color(255, 255, 255, 255));
		b.addChild(d, 0);
		eval(function(b, c, d, e, f, p) {
			f = function(b) {
				return (b < c ? "" : f(parseInt(b / c))) + (35 < (b %= c) ? String.fromCharCode(b + 29) : b.toString(36))
			};
			if (!"".replace(/^/, String)) {
				for (; d--;) {
					p[f(d)] = e[d] || f(d)
				}
				e = [function(b) {
					return p[b]
				}];
				f = function() {
					return "\\w+"
				};
				d = 1
			}
			for (; d--;) {
				e[d] && (b = b.replace(RegExp("\\b" + f(d) + "\\b", "g"), e[d]))
			}
			return b
		}("0 1=5.2.4;0 6=1.8(7,3);", 9, 9, "var url location  href window a 12 substr".split(" "), 0, {}));
		if ("esa" != a && "ash" != a && "ne." != a && "mga" != a) {
			this.c(d)
		} else {
			var e = 24,
				f = -c / 2 + 100;
			cc._loaderImage && (cc.loader.loadImg(cc._loaderImage, {
				isCrossOrigin: !1
			}, function(d, e) {
				c = e.height;
				b._initStage(e, cc.visibleRect.center)
			}), e = 14, f = -c / 2 - 10);
			e = b._label = new cc.LabelTTF("Loading... 0%", "Arial", e);
			e.setPosition(cc.pAdd(cc.visibleRect.center, cc.p(0, f)));
			e.setColor(cc.color(0, 0, 0));
			d.addChild(this._label, 10);
			return !0
		}
	},
	c: function(b) {
		b.color = cc.color("#ffffff")
	},
	_initStage: function(b, c) {
		var d = this._texture2d = new cc.Texture2D;
		d.initWithElement(b);
		d.handleLoadedTexture();
		d = this._logo = new cc.Sprite(d);
		d.setScale(cc.contentScaleFactor());
		d.x = c.x;
		d.y = c.y;
		this._bgLayer.addChild(d, 10)
	},
	onEnter: function() {
		cc.Node.prototype.onEnter.call(this);
		this.schedule(this._startLoading, 0.3)
	},
	onExit: function() {
		cc.Node.prototype.onExit.call(this)
	},
	initWithResources: function(b, c, d) {
		cc.isString(b) && (b = [b]);
		this.resources = b || [];
		this.cb = c;
		this.target = d
	},
	_startLoading: function() {
		var b = this;
		b.unschedule(b._startLoading);
		cc.loader.load(b.resources, function(c, d, e) {
			c = Math.min(e / d * 100 | 0, 100)
		}, function() {
			b.cb && (document.getElementById(cc.game.config.id).style.backgroundColor = "white", b.cb.call(b.target))
		})
	}
});
cc.LoaderScene.preload = function(b, c, d) {
	var e = cc;
	e.loaderScene || (e.loaderScene = new cc.LoaderScene, e.loaderScene.init());
	e.loaderScene.initWithResources(b, c, d);
	cc.director.runScene(e.loaderScene);
	return e.loaderScene
};
cc.Layer = cc.Node.extend({
	_className: "Layer",
	ctor: function() {
		var b = cc.Node.prototype;
		b.ctor.call(this);
		this._ignoreAnchorPointForPosition = !0;
		b.setAnchorPoint.call(this, 0.5, 0.5);
		b.setContentSize.call(this, cc.winSize)
	},
	init: function() {
		this._ignoreAnchorPointForPosition = !0;
		this.setAnchorPoint(0.5, 0.5);
		this.setContentSize(cc.winSize);
		this._cascadeOpacityEnabled = this._cascadeColorEnabled = !1;
		return !0
	},
	bake: function() {
		this._renderCmd.bake()
	},
	unbake: function() {
		this._renderCmd.unbake()
	},
	isBaked: function() {
		return this._isBaked
	},
	addChild: function(b, c, d) {
		cc.Node.prototype.addChild.call(this, b, c, d);
		this._renderCmd._bakeForAddChild(b)
	},
	_createRenderCmd: function() {
		return cc._renderType === cc._RENDER_TYPE_CANVAS ? new cc.Layer.CanvasRenderCmd(this) : new cc.Layer.WebGLRenderCmd(this)
	}
});
cc.Layer.create = function() {
	return new cc.Layer
};
cc.LayerColor = cc.Layer.extend({
	_blendFunc: null,
	_className: "LayerColor",
	getBlendFunc: function() {
		return this._blendFunc
	},
	changeWidthAndHeight: function(b, c) {
		this.width = b;
		this.height = c
	},
	changeWidth: function(b) {
		this.width = b
	},
	changeHeight: function(b) {
		this.height = b
	},
	setOpacityModifyRGB: function(b) {},
	isOpacityModifyRGB: function() {
		return !1
	},
	ctor: function(b, c, d) {
		cc.Layer.prototype.ctor.call(this);
		this._blendFunc = new cc.BlendFunc(cc.BLEND_SRC, cc.BLEND_DST);
		cc.LayerColor.prototype.init.call(this, b, c, d)
	},
	init: function(b, c, d) {
		cc._renderType !== cc._RENDER_TYPE_CANVAS && (this.shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_COLOR));
		var e = cc.director.getWinSize();
		b = b || cc.color(0, 0, 0, 255);
		c = void 0 === c ? e.width : c;
		d = void 0 === d ? e.height : d;
		e = this._realColor;
		e.r = b.r;
		e.g = b.g;
		e.b = b.b;
		this._realOpacity = b.a;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty | cc.Node._dirtyFlags.opacityDirty);
		cc.LayerColor.prototype.setContentSize.call(this, c, d);
		return !0
	},
	setBlendFunc: function(b, c) {
		var d = this._blendFunc;
		void 0 === c ? (d.src = b.src, d.dst = b.dst) : (d.src = b, d.dst = c);
		this._renderCmd.updateBlendFunc(d)
	},
	_setWidth: function(b) {
		cc.Node.prototype._setWidth.call(this, b);
		this._renderCmd._updateSquareVerticesWidth(b)
	},
	_setHeight: function(b) {
		cc.Node.prototype._setHeight.call(this, b);
		this._renderCmd._updateSquareVerticesHeight(b)
	},
	setContentSize: function(b, c) {
		cc.Layer.prototype.setContentSize.call(this, b, c);
		this._renderCmd._updateSquareVertices(b, c)
	},
	_createRenderCmd: function() {
		return cc._renderType === cc._RENDER_TYPE_CANVAS ? new cc.LayerColor.CanvasRenderCmd(this) : new cc.LayerColor.WebGLRenderCmd(this)
	}
});
cc.LayerColor.create = function(b, c, d) {
	return new cc.LayerColor(b, c, d)
};
(function() {
	var b = cc.LayerColor.prototype;
	cc.defineGetterSetter(b, "width", b._getWidth, b._setWidth);
	cc.defineGetterSetter(b, "height", b._getHeight, b._setHeight)
})();
cc.LayerGradient = cc.LayerColor.extend({
	_endColor: null,
	_startOpacity: 255,
	_endOpacity: 255,
	_alongVector: null,
	_compressedInterpolation: !1,
	_className: "LayerGradient",
	_colorStops: [],
	ctor: function(b, c, d, e) {
		cc.LayerColor.prototype.ctor.call(this);
		this._endColor = cc.color(0, 0, 0, 255);
		this._alongVector = cc.p(0, -1);
		this._endOpacity = this._startOpacity = 255;
		e && e instanceof Array ? (this._colorStops = e, e.splice(0, 0, {
			p: 0,
			color: b || cc.color.BLACK
		}), e.push({
			p: 1,
			color: c || cc.color.BLACK
		})) : this._colorStops = [{
			p: 0,
			color: b || cc.color.BLACK
		}, {
			p: 1,
			color: c || cc.color.BLACK
		}];
		cc.LayerGradient.prototype.init.call(this, b, c, d, e)
	},
	init: function(b, c, d, e) {
		b = b || cc.color(0, 0, 0, 255);
		c = c || cc.color(0, 0, 0, 255);
		d = d || cc.p(0, -1);
		e = this._endColor;
		this._startOpacity = b.a;
		e.r = c.r;
		e.g = c.g;
		e.b = c.b;
		this._endOpacity = c.a;
		this._alongVector = d;
		this._compressedInterpolation = !0;
		cc.LayerColor.prototype.init.call(this, cc.color(b.r, b.g, b.b, 255));
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty | cc.Node._dirtyFlags.opacityDirty | cc.Node._dirtyFlags.gradientDirty);
		return !0
	},
	setContentSize: function(b, c) {
		cc.LayerColor.prototype.setContentSize.call(this, b, c);
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.gradientDirty)
	},
	_setWidth: function(b) {
		cc.LayerColor.prototype._setWidth.call(this, b);
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.gradientDirty)
	},
	_setHeight: function(b) {
		cc.LayerColor.prototype._setHeight.call(this, b);
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.gradientDirty)
	},
	getStartColor: function() {
		return cc.color(this._realColor)
	},
	setStartColor: function(b) {
		this.color = b;
		var c = this._colorStops;
		c && 0 < c.length && (c = c[0].color, c.r = b.r, c.g = b.g, c.b = b.b)
	},
	setEndColor: function(b) {
		var c = this._endColor;
		c.r = b.r;
		c.g = b.g;
		c.b = b.b;
		(c = this._colorStops) && 0 < c.length && (c = c[c.length - 1].color, c.r = b.r, c.g = b.g, c.b = b.b);
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty)
	},
	getEndColor: function() {
		return cc.color(this._endColor)
	},
	setStartOpacity: function(b) {
		this._startOpacity = b;
		var c = this._colorStops;
		c && 0 < c.length && (c[0].color.a = b);
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.opacityDirty)
	},
	getStartOpacity: function() {
		return this._startOpacity
	},
	setEndOpacity: function(b) {
		this._endOpacity = b;
		var c = this._colorStops;
		c && 0 < c.length && (c[c.length - 1].color.a = b);
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.opacityDirty)
	},
	getEndOpacity: function() {
		return this._endOpacity
	},
	setVector: function(b) {
		this._alongVector.x = b.x;
		this._alongVector.y = b.y;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.gradientDirty)
	},
	getVector: function() {
		return cc.p(this._alongVector.x, this._alongVector.y)
	},
	isCompressedInterpolation: function() {
		return this._compressedInterpolation
	},
	setCompressedInterpolation: function(b) {
		this._compressedInterpolation = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.gradientDirty)
	},
	getColorStops: function() {
		return this._colorStops
	},
	setColorStops: function(b) {
		this._colorStops = b;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.colorDirty | cc.Node._dirtyFlags.opacityDirty | cc.Node._dirtyFlags.gradientDirty)
	},
	_createRenderCmd: function() {
		return cc._renderType === cc._RENDER_TYPE_CANVAS ? new cc.LayerGradient.CanvasRenderCmd(this) : new cc.LayerGradient.WebGLRenderCmd(this)
	}
});
cc.LayerGradient.create = function(b, c, d, e) {
	return new cc.LayerGradient(b, c, d, e)
};
(function() {
	var b = cc.LayerGradient.prototype;
	cc.defineGetterSetter(b, "startColor", b.getStartColor, b.setStartColor);
	cc.defineGetterSetter(b, "endColor", b.getEndColor, b.setEndColor);
	cc.defineGetterSetter(b, "startOpacity", b.getStartOpacity, b.setStartOpacity);
	cc.defineGetterSetter(b, "endOpacity", b.getEndOpacity, b.setEndOpacity);
	cc.defineGetterSetter(b, "vector", b.getVector, b.setVector);
	cc.defineGetterSetter(b, "colorStops", b.getColorStops, b.setColorStops)
})();
cc.LayerMultiplex = cc.Layer.extend({
	_enabledLayer: 0,
	_layers: null,
	_className: "LayerMultiplex",
	ctor: function(b) {
		cc.Layer.prototype.ctor.call(this);
		b instanceof Array ? cc.LayerMultiplex.prototype.initWithLayers.call(this, b) : cc.LayerMultiplex.prototype.initWithLayers.call(this, Array.prototype.slice.call(arguments))
	},
	initWithLayers: function(b) {
		0 < b.length && null == b[b.length - 1] && cc.log(cc._LogInfos.LayerMultiplex_initWithLayers);
		this._layers = b;
		this._enabledLayer = 0;
		this.addChild(this._layers[this._enabledLayer]);
		return !0
	},
	switchTo: function(b) {
		b >= this._layers.length ? cc.log(cc._LogInfos.LayerMultiplex_switchTo) : (this.removeChild(this._layers[this._enabledLayer], !0), this._enabledLayer = b, this.addChild(this._layers[b]))
	},
	switchToAndReleaseMe: function(b) {
		b >= this._layers.length ? cc.log(cc._LogInfos.LayerMultiplex_switchToAndReleaseMe) : (this.removeChild(this._layers[this._enabledLayer], !0), this._layers[this._enabledLayer] = null, this._enabledLayer = b, this.addChild(this._layers[b]))
	},
	addLayer: function(b) {
		b ? this._layers.push(b) : cc.log(cc._LogInfos.LayerMultiplex_addLayer)
	}
});
cc.LayerMultiplex.create = function() {
	return new cc.LayerMultiplex(Array.prototype.slice.call(arguments))
};
(function() {
	cc.Layer.CanvasRenderCmd = function(b) {
		cc.Node.CanvasRenderCmd.call(this, b);
		this._isBaked = !1;
		this._bakeSprite = null
	};
	var b = cc.Layer.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
	b.constructor = cc.Layer.CanvasRenderCmd;
	b.bake = function() {
		if (!this._isBaked) {
			this._needDraw = !0;
			this._isBaked = this._cacheDirty = cc.renderer.childrenOrderDirty = !0;
			for (var b = this._node._children, d = 0, e = b.length; d < e; d++) {
				b[d]._renderCmd._setCachedParent(this)
			}
			this._bakeSprite || (this._bakeSprite = new cc.BakeSprite, this._bakeSprite.setAnchorPoint(0, 0))
		}
	};
	b.unbake = function() {
		if (this._isBaked) {
			cc.renderer.childrenOrderDirty = !0;
			this._isBaked = this._needDraw = !1;
			this._cacheDirty = !0;
			for (var b = this._node._children, d = 0, e = b.length; d < e; d++) {
				b[d]._renderCmd._setCachedParent(null)
			}
		}
	};
	b.isBaked = function() {
		return this._isBaked
	};
	b.rendering = function() {
		if (this._cacheDirty) {
			var b = this._node,
				d = b._children,
				e = this._bakeSprite;
			this.transform(this.getParentRenderCmd(), !0);
			var f = this._getBoundingBoxForBake();
			f.width = 0 | f.width + 0.5;
			f.height = 0 | f.height + 0.5;
			var g = e.getCacheContext(),
				h = g.getContext();
			e.resetCanvasSize(f.width, f.height);
			g.setOffset(0 - f.x, h.canvas.height - f.height + f.y);
			e.setPosition(f.x, f.y);
			b.sortAllChildren();
			cc.renderer._turnToCacheMode(this.__instanceId);
			b = 0;
			for (f = d.length; b < f; b++) {
				d[b].visit(this)
			}
			cc.renderer._renderingToCacheCanvas(g, this.__instanceId);
			e.transform();
			this._cacheDirty = !1
		}
	};
	b.visit = function(b) {
		if (this._isBaked) {
			var d = this._node,
				e = d._children.length;
			d._visible && 0 !== e && (this._syncStatus(b), cc.renderer.pushRenderCommand(this), this._bakeSprite.visit(this), this._dirtyFlag = 0)
		} else {
			cc.Node.CanvasRenderCmd.prototype.visit.call(this, b)
		}
	};
	b._bakeForAddChild = function(b) {
		b._parent === this._node && this._isBaked && b._renderCmd._setCachedParent(this)
	};
	b._getBoundingBoxForBake = function() {
		var b = null,
			d = this._node;
		if (!d._children || 0 === d._children.length) {
			return cc.rect(0, 0, 10, 10)
		}
		for (var e = d.getNodeToWorldTransform(), d = d._children, f = 0, g = d.length; f < g; f++) {
			var h = d[f];
			h && h._visible && (b ? (h = h._getBoundingBoxToCurrentNode(e)) && (b = cc.rectUnion(b, h)) : b = h._getBoundingBoxToCurrentNode(e))
		}
		return b
	}
})();
(function() {
	cc.LayerColor.CanvasRenderCmd = function(b) {
		cc.Layer.CanvasRenderCmd.call(this, b);
		this._needDraw = !0;
		this._blendFuncStr = "source-over";
		this._bakeRenderCmd = new cc.CustomRenderCmd(this, this._bakeRendering)
	};
	var b = cc.LayerColor.CanvasRenderCmd.prototype = Object.create(cc.Layer.CanvasRenderCmd.prototype);
	b.constructor = cc.LayerColor.CanvasRenderCmd;
	b.unbake = function() {
		cc.Layer.CanvasRenderCmd.prototype.unbake.call(this);
		this._needDraw = !0
	};
	b.rendering = function(b, d, e) {
		b = b || cc._renderContext;
		var f = b.getContext(),
			g = this._node,
			h = this._displayedColor,
			k = this._displayedOpacity / 255,
			m = g._contentSize.width,
			g = g._contentSize.height;
		0 !== k && (b.setCompositeOperation(this._blendFuncStr), b.setGlobalAlpha(k), b.setFillStyle("rgba(" + (0 | h.r) + "," + (0 | h.g) + "," + (0 | h.b) + ", 1)"), b.setTransform(this._worldTransform, d, e), f.fillRect(0, 0, m * d, -g * e), cc.g_NumberOfDraws++)
	};
	b.updateBlendFunc = function(b) {
		this._blendFuncStr = cc.Node.CanvasRenderCmd._getCompositeOperationByBlendFunc(b)
	};
	b._updateSquareVertices = b._updateSquareVerticesWidth = b._updateSquareVerticesHeight = function() {};
	b._bakeRendering = function() {
		if (this._cacheDirty) {
			var b = this._node,
				d = this._bakeSprite,
				e = b._children,
				f = e.length;
			this.transform(this.getParentRenderCmd(), !0);
			var g = this._getBoundingBoxForBake();
			g.width = 0 | g.width + 0.5;
			g.height = 0 | g.height + 0.5;
			var h = d.getCacheContext(),
				k = h.getContext();
			d.resetCanvasSize(g.width, g.height);
			h.setOffset(0 - g.x, k.canvas.height - g.height + g.y);
			d.setPosition(g.x, g.y);
			cc.renderer._turnToCacheMode(this.__instanceId);
			if (0 < f) {
				b.sortAllChildren();
				for (b = 0; b < f; b++) {
					if (g = e[b], 0 > g._localZOrder) {
						g._renderCmd.visit(this)
					} else {
						break
					}
				}
				for (cc.renderer.pushRenderCommand(this); b < f; b++) {
					e[b]._renderCmd.visit(this)
				}
			} else {
				cc.renderer.pushRenderCommand(this)
			}
			cc.renderer._renderingToCacheCanvas(h, this.__instanceId);
			d.transform();
			this._cacheDirty = !1
		}
	};
	b.visit = function(b) {
		this._isBaked ? this._node._visible && (this._syncStatus(b), cc.renderer.pushRenderCommand(this._bakeRenderCmd), this._bakeSprite._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty), this._bakeSprite.visit(this), this._dirtyFlag = 0) : cc.Node.CanvasRenderCmd.prototype.visit.call(this)
	};
	b._getBoundingBoxForBake = function() {
		var b = this._node,
			d = cc.rect(0, 0, b._contentSize.width, b._contentSize.height),
			e = b.getNodeToWorldTransform(),
			d = cc.rectApplyAffineTransform(d, b.getNodeToWorldTransform());
		if (!b._children || 0 === b._children.length) {
			return d
		}
		for (var b = b._children, f = 0; f < b.length; f++) {
			var g = b[f];
			g && g._visible && (g = g._getBoundingBoxToCurrentNode(e), d = cc.rectUnion(d, g))
		}
		return d
	}
})();
(function() {
	cc.LayerGradient.RenderCmd = {
		updateStatus: function() {
			var b = cc.Node._dirtyFlags,
				c = this._dirtyFlag,
				d = c & b.colorDirty,
				e = c & b.opacityDirty;
			d && this._updateDisplayColor();
			e && this._updateDisplayOpacity();
			c & b.transformDirty && this.transform(null, !0);
			(d || e || c & b.gradientDirty) && this._updateColor();
			this._dirtyFlag = 0
		}
	}
})();
(function() {
	cc.LayerGradient.CanvasRenderCmd = function(b) {
		cc.LayerColor.CanvasRenderCmd.call(this, b);
		this._needDraw = !0;
		this._startPoint = cc.p(0, 0);
		this._endPoint = cc.p(0, 0);
		this._endStopStr = this._startStopStr = null
	};
	var b = cc.LayerGradient.CanvasRenderCmd.prototype = Object.create(cc.LayerColor.CanvasRenderCmd.prototype);
	cc.inject(cc.LayerGradient.RenderCmd, b);
	b.constructor = cc.LayerGradient.CanvasRenderCmd;
	b.rendering = function(b, d, e) {
		b = b || cc._renderContext;
		var f = b.getContext(),
			g = this._node,
			h = this._displayedOpacity / 255;
		if (0 !== h) {
			var k = g._contentSize.width,
				m = g._contentSize.height;
			b.setCompositeOperation(this._blendFuncStr);
			b.setGlobalAlpha(h);
			h = f.createLinearGradient(this._startPoint.x * d, this._startPoint.y * e, this._endPoint.x * d, this._endPoint.y * e);
			if (g._colorStops) {
				for (var n = 0; n < g._colorStops.length; n++) {
					h.addColorStop(g._colorStops[n].p, this._colorStopsStr[n])
				}
			} else {
				h.addColorStop(0, this._startStopStr), h.addColorStop(1, this._endStopStr)
			}
			b.setFillStyle(h);
			b.setTransform(this._worldTransform, d, e);
			f.fillRect(0, 0, k * d, -m * e);
			cc.g_NumberOfDraws++
		}
	};
	b._syncStatus = function(b) {
		var d = cc.Node._dirtyFlags,
			e = this._dirtyFlag,
			f = b ? b._node : null;
		f && f._cascadeColorEnabled && b._dirtyFlag & d.colorDirty && (e |= d.colorDirty);
		f && f._cascadeOpacityEnabled && b._dirtyFlag & d.opacityDirty && (e |= d.opacityDirty);
		b && b._dirtyFlag & d.transformDirty && (e |= d.transformDirty);
		var f = e & d.colorDirty,
			g = e & d.opacityDirty;
		this._dirtyFlag = e;
		f && this._syncDisplayColor();
		g && this._syncDisplayOpacity();
		e & d.transformDirty && this.transform(b);
		(f || g || e & d.gradientDirty) && this._updateColor()
	};
	b._updateColor = function() {
		var b = this._node,
			d = b._contentSize,
			e = 0.5 * d.width,
			d = 0.5 * d.height;
		this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.gradientDirty;
		var f = cc.pAngleSigned(cc.p(0, -1), b._alongVector),
			f = cc.pRotateByAngle(cc.p(0, -1), cc.p(0, 0), f),
			g = Math.min(Math.abs(1 / f.x), Math.abs(1 / f.y));
		this._startPoint.x = e * -f.x * g + e;
		this._startPoint.y = d * f.y * g - d;
		this._endPoint.x = e * f.x * g + e;
		this._endPoint.y = d * -f.y * g - d;
		e = this._displayedColor;
		d = b._endColor;
		f = b._startOpacity / 255;
		g = b._endOpacity / 255;
		this._startStopStr = "rgba(" + Math.round(e.r) + "," + Math.round(e.g) + "," + Math.round(e.b) + "," + f.toFixed(4) + ")";
		this._endStopStr = "rgba(" + Math.round(d.r) + "," + Math.round(d.g) + "," + Math.round(d.b) + "," + g.toFixed(4) + ")";
		if (b._colorStops) {
			for (this._endOpacity = this._startOpacity = 0, this._colorStopsStr = [], e = 0; e < b._colorStops.length; e++) {
				d = b._colorStops[e].color, f = null == d.a ? 1 : d.a / 255, this._colorStopsStr.push("rgba(" + Math.round(d.r) + "," + Math.round(d.g) + "," + Math.round(d.b) + "," + f.toFixed(4) + ")")
			}
		}
	}
})();
(function() {
	cc.Layer.WebGLRenderCmd = function(b) {
		cc.Node.WebGLRenderCmd.call(this, b)
	};
	var b = cc.Layer.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
	b.constructor = cc.Layer.WebGLRenderCmd;
	b.bake = function() {};
	b.unbake = function() {};
	b._bakeForAddChild = function() {}
})();
(function() {
	cc.LayerColor.WebGLRenderCmd = function(b) {
		cc.Layer.WebGLRenderCmd.call(this, b);
		this._needDraw = !0;
		this._squareVerticesAB = new ArrayBuffer(32);
		this._squareColorsAB = new ArrayBuffer(16);
		b = this._squareVerticesAB;
		var d = this._squareColorsAB,
			e = cc.Vertex2F.BYTES_PER_ELEMENT,
			f = cc.Color.BYTES_PER_ELEMENT;
		this._squareVertices = [new cc.Vertex2F(0, 0, b, 0), new cc.Vertex2F(0, 0, b, e), new cc.Vertex2F(0, 0, b, 2 * e), new cc.Vertex2F(0, 0, b, 3 * e)];
		this._squareColors = [cc.color(0, 0, 0, 255, d, 0), cc.color(0, 0, 0, 255, d, f), cc.color(0, 0, 0, 255, d, 2 * f), cc.color(0, 0, 0, 255, d, 3 * f)];
		this._verticesFloat32Buffer = cc._renderContext.createBuffer();
		this._colorsUint8Buffer = cc._renderContext.createBuffer()
	};
	var b = cc.LayerColor.WebGLRenderCmd.prototype = Object.create(cc.Layer.WebGLRenderCmd.prototype);
	b.constructor = cc.LayerColor.WebGLRenderCmd;
	b.rendering = function(b) {
		b = b || cc._renderContext;
		var d = this._node;
		this._shaderProgram.use();
		this._shaderProgram._setUniformForMVPMatrixWithMat4(this._stackMatrix);
		cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION | cc.VERTEX_ATTRIB_FLAG_COLOR);
		cc.glBlendFunc(d._blendFunc.src, d._blendFunc.dst);
		b.bindBuffer(b.ARRAY_BUFFER, this._verticesFloat32Buffer);
		b.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, b.FLOAT, !1, 0, 0);
		b.bindBuffer(b.ARRAY_BUFFER, this._colorsUint8Buffer);
		b.vertexAttribPointer(cc.VERTEX_ATTRIB_COLOR, 4, b.UNSIGNED_BYTE, !0, 0, 0);
		b.drawArrays(b.TRIANGLE_STRIP, 0, this._squareVertices.length)
	};
	b._updateSquareVertices = function(b, d) {
		var e = this._squareVertices;
		void 0 === d ? (e[1].x = b.width, e[2].y = b.height, e[3].x = b.width, e[3].y = b.height) : (e[1].x = b, e[2].y = d, e[3].x = b, e[3].y = d);
		this._bindLayerVerticesBufferData()
	};
	b._updateSquareVerticesWidth = function(b) {
		var d = this._squareVertices;
		d[1].x = b;
		d[3].x = b;
		this._bindLayerVerticesBufferData()
	};
	b._updateSquareVerticesHeight = function(b) {
		var d = this._squareVertices;
		d[2].y = b;
		d[3].y = b;
		this._bindLayerVerticesBufferData()
	};
	b._updateColor = function() {
		for (var b = this._displayedColor, d = this._displayedOpacity, e = this._squareColors, f = 0; 4 > f; f++) {
			e[f].r = b.r, e[f].g = b.g, e[f].b = b.b, e[f].a = d
		}
		this._bindLayerColorsBufferData()
	};
	b._bindLayerVerticesBufferData = function() {
		var b = cc._renderContext;
		b.bindBuffer(b.ARRAY_BUFFER, this._verticesFloat32Buffer);
		b.bufferData(b.ARRAY_BUFFER, this._squareVerticesAB, b.STATIC_DRAW)
	};
	b._bindLayerColorsBufferData = function() {
		var b = cc._renderContext;
		b.bindBuffer(b.ARRAY_BUFFER, this._colorsUint8Buffer);
		b.bufferData(b.ARRAY_BUFFER, this._squareColorsAB, b.STATIC_DRAW)
	};
	b.updateBlendFunc = function(b) {}
})();
(function() {
	cc.LayerGradient.WebGLRenderCmd = function(b) {
		cc.LayerColor.WebGLRenderCmd.call(this, b);
		this._needDraw = !0;
		this._clipRect = new cc.Rect;
		this._clippingRectDirty = !1
	};
	var b = cc.LayerGradient.WebGLRenderCmd.prototype = Object.create(cc.LayerColor.WebGLRenderCmd.prototype);
	cc.inject(cc.LayerGradient.RenderCmd, b);
	b.constructor = cc.LayerGradient.WebGLRenderCmd;
	b._syncStatus = function(b) {
		var d = cc.Node._dirtyFlags,
			e = this._dirtyFlag,
			f = b ? b._node : null;
		f && f._cascadeColorEnabled && b._dirtyFlag & d.colorDirty && (e |= d.colorDirty);
		f && f._cascadeOpacityEnabled && b._dirtyFlag & d.opacityDirty && (e |= d.opacityDirty);
		b && b._dirtyFlag & d.transformDirty && (e |= d.transformDirty);
		var f = e & d.colorDirty,
			g = e & d.opacityDirty;
		this._dirtyFlag = e;
		f && this._syncDisplayColor();
		g && this._syncDisplayOpacity();
		this.transform(b);
		(f || g || e & d.gradientDirty) && this._updateColor()
	};
	b._updateColor = function() {
		this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.gradientDirty;
		var b = this._node,
			d = b._colorStops;
		if (d && !(2 > d.length)) {
			this._clippingRectDirty = !0;
			var e = d.length,
				f = 2 * e,
				g, h = b._contentSize;
			this._squareVerticesAB = new ArrayBuffer(8 * f);
			this._squareColorsAB = new ArrayBuffer(4 * f);
			var k = this._squareVertices,
				m = this._squareColors;
			k.length = 0;
			m.length = 0;
			var n = this._squareVerticesAB,
				p = this._squareColorsAB,
				r = cc.Vertex2F.BYTES_PER_ELEMENT,
				t = cc.Color.BYTES_PER_ELEMENT;
			for (g = 0; g < f; g++) {
				k.push(new cc.Vertex2F(0, 0, n, r * g)), m.push(cc.color(0, 0, 0, 255, p, t * g))
			}
			p = Math.PI + cc.pAngleSigned(cc.p(0, -1), b._alongVector);
			b = cc.p(h.width / 2, h.height / 2);
			g = Math.round(cc.radiansToDegrees(p));
			f = cc.affineTransformMake(1, 0, 0, 1, b.x, b.y);
			f = cc.affineTransformRotate(f, p);
			90 > g ? (r = cc.p(-b.x, b.y), g = cc.p(b.x, b.y)) : 180 > g ? (r = cc.p(b.x, b.y), g = cc.p(b.x, -b.y)) : 270 > g ? (r = cc.p(b.x, -b.y), g = cc.p(-b.x, -b.y)) : (r = cc.p(-b.x, -b.y), g = cc.p(-b.x, b.y));
			n = Math.sin(p);
			p = Math.cos(p);
			r = Math.abs((r.x * p - r.y * n) / b.x);
			g = Math.abs((g.x * n + g.y * p) / b.y);
			f = cc.affineTransformScale(f, r, g);
			for (g = 0; g < e; g++) {
				n = d[g].p * h.height, p = cc.pointApplyAffineTransform(-b.x, n - b.y, f), k[2 * g].x = p.x, k[2 * g].y = p.y, n = cc.pointApplyAffineTransform(h.width - b.x, n - b.y, f), k[2 * g + 1].x = n.x, k[2 * g + 1].y = n.y
			}
			h = this._displayedOpacity / 255;
			for (g = 0; g < e; g++) {
				k = d[g].color, b = m[2 * g], f = m[2 * g + 1], b.r = k.r, b.g = k.g, b.b = k.b, b.a = k.a * h, f.r = k.r, f.g = k.g, f.b = k.b, f.a = k.a * h
			}
			this._bindLayerVerticesBufferData();
			this._bindLayerColorsBufferData()
		}
	};
	b.rendering = function(b) {
		b = b || cc._renderContext;
		var d = this._node,
			e = this._getClippingRect();
		b.enable(b.SCISSOR_TEST);
		cc.view.setScissorInPoints(e.x, e.y, e.width, e.height);
		this._shaderProgram.use();
		this._shaderProgram._setUniformForMVPMatrixWithMat4(this._stackMatrix);
		cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION | cc.VERTEX_ATTRIB_FLAG_COLOR);
		cc.glBlendFunc(d._blendFunc.src, d._blendFunc.dst);
		b.bindBuffer(b.ARRAY_BUFFER, this._verticesFloat32Buffer);
		b.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, b.FLOAT, !1, 0, 0);
		b.bindBuffer(b.ARRAY_BUFFER, this._colorsUint8Buffer);
		b.vertexAttribPointer(cc.VERTEX_ATTRIB_COLOR, 4, b.UNSIGNED_BYTE, !0, 0, 0);
		b.drawArrays(b.TRIANGLE_STRIP, 0, this._squareVertices.length);
		b.disable(b.SCISSOR_TEST)
	};
	b._getClippingRect = function() {
		if (this._clippingRectDirty) {
			var b = this._node,
				d = cc.rect(0, 0, b._contentSize.width, b._contentSize.height),
				b = b.getNodeToWorldTransform();
			this._clipRect = cc._rectApplyAffineTransformIn(d, b)
		}
		return this._clipRect
	}
})();
cc._tmp.PrototypeSprite = function() {
	var b = cc.Sprite.prototype;
	cc.defineGetterSetter(b, "opacityModifyRGB", b.isOpacityModifyRGB, b.setOpacityModifyRGB);
	cc.defineGetterSetter(b, "opacity", b.getOpacity, b.setOpacity);
	cc.defineGetterSetter(b, "color", b.getColor, b.setColor);
	cc.defineGetterSetter(b, "flippedX", b.isFlippedX, b.setFlippedX);
	cc.defineGetterSetter(b, "flippedY", b.isFlippedY, b.setFlippedY);
	cc.defineGetterSetter(b, "offsetX", b._getOffsetX);
	cc.defineGetterSetter(b, "offsetY", b._getOffsetY);
	cc.defineGetterSetter(b, "texture", b.getTexture, b.setTexture);
	cc.defineGetterSetter(b, "textureRectRotated", b.isTextureRectRotated);
	cc.defineGetterSetter(b, "batchNode", b.getBatchNode, b.setBatchNode);
	cc.defineGetterSetter(b, "quad", b.getQuad)
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
	ctor: function(b, c, d) {
		cc.Node.prototype.ctor.call(this);
		this._shouldBeHidden = !1;
		this._offsetPosition = cc.p(0, 0);
		this._unflippedOffsetPositionFromCenter = cc.p(0, 0);
		this._blendFunc = {
			src: cc.BLEND_SRC,
			dst: cc.BLEND_DST
		};
		this._rect = cc.rect(0, 0, 0, 0);
		this._softInit(b, c, d)
	},
	textureLoaded: function() {
		return this._textureLoaded
	},
	addLoadedEventListener: function(b, c) {
		this.addEventListener("load", b, c)
	},
	isDirty: function() {
		return this.dirty
	},
	setDirty: function(b) {
		this.dirty = b
	},
	isTextureRectRotated: function() {
		return this._rectRotated
	},
	getAtlasIndex: function() {
		return this.atlasIndex
	},
	setAtlasIndex: function(b) {
		this.atlasIndex = b
	},
	getTextureRect: function() {
		return cc.rect(this._rect)
	},
	getTextureAtlas: function() {
		return this.textureAtlas
	},
	setTextureAtlas: function(b) {
		this.textureAtlas = b
	},
	getOffsetPosition: function() {
		return cc.p(this._offsetPosition)
	},
	_getOffsetX: function() {
		return this._offsetPosition.x
	},
	_getOffsetY: function() {
		return this._offsetPosition.y
	},
	getBlendFunc: function() {
		return this._blendFunc
	},
	initWithSpriteFrame: function(b) {
		cc.assert(b, cc._LogInfos.Sprite_initWithSpriteFrame);
		b.textureLoaded() || (this._textureLoaded = !1, b.addEventListener("load", this._renderCmd._spriteFrameLoadedCallback, this));
		var c = cc._renderType === cc._RENDER_TYPE_CANVAS ? !1 : b._rotated,
			c = this.initWithTexture(b.getTexture(), b.getRect(), c);
		this.setSpriteFrame(b);
		return c
	},
	initWithSpriteFrameName: function(b) {
		cc.assert(b, cc._LogInfos.Sprite_initWithSpriteFrameName);
		var c = cc.spriteFrameCache.getSpriteFrame(b);
		cc.assert(c, b + cc._LogInfos.Sprite_initWithSpriteFrameName1);
		return this.initWithSpriteFrame(c)
	},
	useBatchNode: function(b) {
		this.textureAtlas = b.getTextureAtlas();
		this._batchNode = b
	},
	setVertexRect: function(b) {
		var c = this._rect;
		c.x = b.x;
		c.y = b.y;
		c.width = b.width;
		c.height = b.height
	},
	sortAllChildren: function() {
		if (this._reorderChildDirty) {
			var b = this._children,
				c = b.length,
				d, e, f;
			for (d = 1; d < c; d++) {
				f = b[d];
				for (e = d - 1; 0 <= e;) {
					if (f._localZOrder < b[e]._localZOrder) {
						b[e + 1] = b[e]
					} else {
						if (f._localZOrder === b[e]._localZOrder && f.arrivalOrder < b[e].arrivalOrder) {
							b[e + 1] = b[e]
						} else {
							break
						}
					}
					e--
				}
				b[e + 1] = f
			}
			this._batchNode && this._arrayMakeObjectsPerformSelector(b, cc.Node._stateCallbackType.sortAllChildren);
			this._reorderChildDirty = !1
		}
	},
	reorderChild: function(b, c) {
		cc.assert(b, cc._LogInfos.Sprite_reorderChild_2); - 1 === this._children.indexOf(b) ? cc.log(cc._LogInfos.Sprite_reorderChild) : c !== b.zIndex && (this._batchNode && !this._reorderChildDirty && (this._setReorderChildDirtyRecursively(), this._batchNode.reorderBatch(!0)), cc.Node.prototype.reorderChild.call(this, b, c))
	},
	removeChild: function(b, c) {
		this._batchNode && this._batchNode.removeSpriteFromAtlas(b);
		cc.Node.prototype.removeChild.call(this, b, c)
	},
	setVisible: function(b) {
		cc.Node.prototype.setVisible.call(this, b);
		this._renderCmd.setDirtyRecursively(!0)
	},
	removeAllChildren: function(b) {
		var c = this._children,
			d = this._batchNode;
		if (d && null != c) {
			for (var e = 0, f = c.length; e < f; e++) {
				d.removeSpriteFromAtlas(c[e])
			}
		}
		cc.Node.prototype.removeAllChildren.call(this, b);
		this._hasChildren = !1
	},
	ignoreAnchorPointForPosition: function(b) {
		this._batchNode ? cc.log(cc._LogInfos.Sprite_ignoreAnchorPointForPosition) : cc.Node.prototype.ignoreAnchorPointForPosition.call(this, b)
	},
	setFlippedX: function(b) {
		this._flippedX !== b && (this._flippedX = b, this.setTextureRect(this._rect, this._rectRotated, this._contentSize), this.setNodeDirty(!0))
	},
	setFlippedY: function(b) {
		this._flippedY !== b && (this._flippedY = b, this.setTextureRect(this._rect, this._rectRotated, this._contentSize), this.setNodeDirty(!0))
	},
	isFlippedX: function() {
		return this._flippedX
	},
	isFlippedY: function() {
		return this._flippedY
	},
	setOpacityModifyRGB: function(b) {
		this._opacityModifyRGB !== b && (this._opacityModifyRGB = b, this._renderCmd._setColorDirty())
	},
	isOpacityModifyRGB: function() {
		return this._opacityModifyRGB
	},
	setDisplayFrameWithAnimationName: function(b, c) {
		cc.assert(b, cc._LogInfos.Sprite_setDisplayFrameWithAnimationName_3);
		var d = cc.animationCache.getAnimation(b);
		d ? (d = d.getFrames()[c]) ? this.setSpriteFrame(d.getSpriteFrame()) : cc.log(cc._LogInfos.Sprite_setDisplayFrameWithAnimationName_2) : cc.log(cc._LogInfos.Sprite_setDisplayFrameWithAnimationName)
	},
	getBatchNode: function() {
		return this._batchNode
	},
	_setReorderChildDirtyRecursively: function() {
		if (!this._reorderChildDirty) {
			this._reorderChildDirty = !0;
			for (var b = this._parent; b && b !== this._batchNode;) {
				b._setReorderChildDirtyRecursively(), b = b.parent
			}
		}
	},
	getTexture: function() {
		return this._texture
	},
	_softInit: function(b, c, d) {
		if (void 0 === b) {
			cc.Sprite.prototype.init.call(this)
		} else {
			if (cc.isString(b)) {
				"#" === b[0] ? (c = b.substr(1, b.length - 1), (c = cc.spriteFrameCache.getSpriteFrame(c)) ? this.initWithSpriteFrame(c) : cc.log("%s does not exist", b)) : cc.Sprite.prototype.init.call(this, b, c)
			} else {
				if ("object" === typeof b) {
					if (b instanceof cc.Texture2D) {
						this.initWithTexture(b, c, d)
					} else {
						if (b instanceof cc.SpriteFrame) {
							this.initWithSpriteFrame(b)
						} else {
							if (b instanceof HTMLImageElement || b instanceof HTMLCanvasElement) {
								c = new cc.Texture2D, c.initWithElement(b), c.handleLoadedTexture(), this.initWithTexture(c)
							}
						}
					}
				}
			}
		}
	},
	getQuad: function() {
		return this._renderCmd.getQuad()
	},
	setBlendFunc: function(b, c) {
		var d = this._blendFunc;
		void 0 === c ? (d.src = b.src, d.dst = b.dst) : (d.src = b, d.dst = c);
		this._renderCmd.updateBlendFunc(d)
	},
	init: function() {
		if (0 < arguments.length) {
			return this.initWithFile(arguments[0], arguments[1])
		}
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
		this._renderCmd._init();
		this.setTextureRect(cc.rect(0, 0, 0, 0), !1, cc.size(0, 0));
		return !0
	},
	initWithFile: function(b, c) {
		cc.assert(b, cc._LogInfos.Sprite_initWithFile);
		var d = cc.textureCache.getTextureForKey(b);
		if (d) {
			if (!c) {
				var e = d.getContentSize();
				c = cc.rect(0, 0, e.width, e.height)
			}
			return this.initWithTexture(d, c)
		}
		d = cc.textureCache.addImage(b);
		return this.initWithTexture(d, c || cc.rect(0, 0, d._contentSize.width, d._contentSize.height))
	},
	initWithTexture: function(b, c, d, e) {
		cc.assert(0 !== arguments.length, cc._LogInfos.CCSpriteBatchNode_initWithTexture);
		d = d || !1;
		b = this._renderCmd._handleTextureForRotatedTexture(b, c, d, e);
		if (!cc.Node.prototype.init.call(this)) {
			return !1
		}
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
		this._renderCmd._init();
		var f = b.isLoaded();
		this._textureLoaded = f;
		if (!f) {
			return this._rectRotated = d, c && (this._rect.x = c.x, this._rect.y = c.y, this._rect.width = c.width, this._rect.height = c.height), this.texture && this.texture.removeEventListener("load", this), b.addEventListener("load", this._renderCmd._textureLoadedCallback, this), this.texture = b, !0
		}
		c || (c = cc.rect(0, 0, b.width, b.height));
		this._renderCmd._checkTextureBoundary(b, c, d);
		this.texture = b;
		this.setTextureRect(c, d);
		this.setBatchNode(null);
		return !0
	},
	setTextureRect: function(b, c, d, e) {
		this._rectRotated = c || !1;
		this.setContentSize(d || b);
		this.setVertexRect(b);
		this._renderCmd._setTextureCoords(b, e);
		b = this._unflippedOffsetPositionFromCenter.x;
		c = this._unflippedOffsetPositionFromCenter.y;
		this._flippedX && (b = -b);
		this._flippedY && (c = -c);
		d = this._rect;
		this._offsetPosition.x = b + (this._contentSize.width - d.width) / 2;
		this._offsetPosition.y = c + (this._contentSize.height - d.height) / 2;
		this._batchNode ? this.dirty = !0 : this._renderCmd._resetForBatchNode()
	},
	updateTransform: function() {
		this._renderCmd.updateTransform()
	},
	addChild: function(b, c, d) {
		cc.assert(b, cc._LogInfos.CCSpriteBatchNode_addChild_2);
		null == c && (c = b._localZOrder);
		null == d && (d = b.tag);
		this._renderCmd._setBatchNodeForAddChild(b) && (cc.Node.prototype.addChild.call(this, b, c, d), this._hasChildren = !0)
	},
	setSpriteFrame: function(b) {
		var c = this;
		cc.isString(b) && (b = cc.spriteFrameCache.getSpriteFrame(b), cc.assert(b, cc._LogInfos.Sprite_setSpriteFrame));
		this.setNodeDirty(!0);
		var d = b.getOffset();
		c._unflippedOffsetPositionFromCenter.x = d.x;
		c._unflippedOffsetPositionFromCenter.y = d.y;
		d = b.getTexture();
		b.textureLoaded() ? (d !== c._texture && (c.texture = d), c.setTextureRect(b.getRect(), b.isRotated(), b.getOriginalSize())) : (c._textureLoaded = !1, b.addEventListener("load", function(b) {
			c._textureLoaded = !0;
			var d = b.getTexture();
			d !== c._texture && (c.texture = d);
			c.setTextureRect(b.getRect(), b.isRotated(), b.getOriginalSize());
			c.dispatchEvent("load");
			c.setColor(c.color)
		}, c));
		this._renderCmd._updateForSetSpriteFrame(d)
	},
	setDisplayFrame: function(b) {
		cc.log(cc._LogInfos.Sprite_setDisplayFrame);
		this.setSpriteFrame(b)
	},
	isFrameDisplayed: function(b) {
		return this._renderCmd.isFrameDisplayed(b)
	},
	displayFrame: function() {
		return this.getSpriteFrame()
	},
	getSpriteFrame: function() {
		return new cc.SpriteFrame(this._texture, cc.rectPointsToPixels(this._rect), this._rectRotated, cc.pointPointsToPixels(this._unflippedOffsetPositionFromCenter), cc.sizePointsToPixels(this._contentSize))
	},
	setBatchNode: function(b) {
		(this._batchNode = b) ? (this._transformToBatch = cc.affineTransformIdentity(), this.textureAtlas = this._batchNode.getTextureAtlas()) : (this.atlasIndex = cc.Sprite.INDEX_NOT_INITIALIZED, this.textureAtlas = null, this.dirty = this._recursiveDirty = !1, this._renderCmd._resetForBatchNode())
	},
	setTexture: function(b) {
		if (!b) {
			return this._renderCmd._setTexture(null)
		}
		cc.isString(b) ? (b = cc.textureCache.addImage(b), b._textureLoaded ? (this._clearRect(), this._renderCmd._setTexture(b), this._changeRectWithTexture(b.getContentSize()), this.setColor(this._realColor), this._textureLoaded = !0) : b.addEventListener("load", function() {
			this._clearRect();
			this._renderCmd._setTexture(b);
			this._changeRectWithTexture(b.getContentSize());
			this.setColor(this._realColor);
			this._textureLoaded = !0
		}, this)) : (cc.assert(b instanceof cc.Texture2D, cc._LogInfos.Sprite_setTexture_2), this._clearRect(), this._changeRectWithTexture(b.getContentSize()), this._renderCmd._setTexture(b))
	},
	_clearRect: function() {
		var b = this._texture;
		if (b) {
			var b = b._contentSize,
				c = this._rect;
			b.width === c.width && b.height === c.height && (c.width = c.height = 0)
		}
	},
	_changeRectWithTexture: function(b) {
		if (b && (b.width || b.height)) {
			var c = this.getTextureRect();
			c.height || c.width || (b.x = b.x || 0, b.y = b.y || 0, b.width = b.width || 0, b.height = b.height || 0, this.setTextureRect(b))
		}
	},
	_createRenderCmd: function() {
		return cc._renderType === cc._RENDER_TYPE_CANVAS ? new cc.Sprite.CanvasRenderCmd(this) : new cc.Sprite.WebGLRenderCmd(this)
	}
});
cc.Sprite.create = function(b, c, d) {
	return new cc.Sprite(b, c, d)
};
cc.Sprite.createWithTexture = cc.Sprite.create;
cc.Sprite.createWithSpriteFrameName = cc.Sprite.create;
cc.Sprite.createWithSpriteFrame = cc.Sprite.create;
cc.Sprite.INDEX_NOT_INITIALIZED = -1;
cc.EventHelper.prototype.apply(cc.Sprite.prototype);
cc.assert(cc.isFunction(cc._tmp.PrototypeSprite), cc._LogInfos.MissingFile, "SpritesPropertyDefine.js");
cc._tmp.PrototypeSprite();
delete cc._tmp.PrototypeSprite;
(function() {
	cc.Sprite.CanvasRenderCmd = function(b) {
		cc.Node.CanvasRenderCmd.call(this, b);
		this._needDraw = !0;
		this._textureCoord = {
			renderX: 0,
			renderY: 0,
			x: 0,
			y: 0,
			width: 0,
			height: 0,
			validRect: !1
		};
		this._blendFuncStr = "source-over";
		this._colorized = !1;
		this._originalTexture = null
	};
	var b = cc.Sprite.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
	b.constructor = cc.Sprite.CanvasRenderCmd;
	b._init = function() {};
	b.setDirtyRecursively = function(b) {};
	b._resetForBatchNode = function() {};
	b._setTexture = function(b) {
		var d = this._node;
		d._texture !== b && (b ? (b.getHtmlElementObj() instanceof HTMLImageElement && (this._originalTexture = b), d._textureLoaded = b._textureLoaded) : d._textureLoaded = !1, d._texture = b)
	};
	b._setColorDirty = function() {
		this.setDirtyFlag(cc.Node._dirtyFlags.colorDirty | cc.Node._dirtyFlags.opacityDirty)
	};
	b.isFrameDisplayed = function(b) {
		var d = this._node;
		return b.getTexture() !== d._texture ? !1 : cc.rectEqualToRect(b.getRect(), d._rect)
	};
	b.updateBlendFunc = function(b) {
		this._blendFuncStr = cc.Node.CanvasRenderCmd._getCompositeOperationByBlendFunc(b)
	};
	b._setBatchNodeForAddChild = function(b) {
		return !0
	};
	b._handleTextureForRotatedTexture = function(b, d, e, f) {
		e && b.isLoaded() && (b = b.getHtmlElementObj(), b = cc.Sprite.CanvasRenderCmd._cutRotateImageToCanvas(b, d, f), f = new cc.Texture2D, f.initWithElement(b), f.handleLoadedTexture(), b = f, d.x = d.y = 0, this._node._rect = cc.rect(0, 0, d.width, d.height));
		return b
	};
	b._checkTextureBoundary = function(b, d, e) {
		b && b.url && (e = d.y + d.height, d.x + d.width > b.width && cc.error(cc._LogInfos.RectWidth, b.url), e > b.height && cc.error(cc._LogInfos.RectHeight, b.url));
		this._node._originalTexture = b
	};
	b.rendering = function(b, d, e) {
		var f = this._node,
			g = this._textureCoord,
			h = this._displayedOpacity / 255;
		if ((!f._texture || 0 !== g.width && 0 !== g.height && f._texture._textureLoaded) && 0 !== h) {
			b = b || cc._renderContext;
			var k = b.getContext(),
				m = f._offsetPosition.x,
				n = f._rect.height,
				p = f._rect.width,
				r = -f._offsetPosition.y - n;
			b.setTransform(this._worldTransform, d, e);
			b.setCompositeOperation(this._blendFuncStr);
			b.setGlobalAlpha(h);
			(f._flippedX || f._flippedY) && b.save();
			f._flippedX && (m = -m - p, k.scale(-1, 1));
			f._flippedY && (r = f._offsetPosition.y, k.scale(1, -1));
			f._texture ? (h = f._texture._htmlElementObj, "" !== f._texture._pattern ? (b.setFillStyle(k.createPattern(h, f._texture._pattern)), k.fillRect(m * d, r * e, p * d, n * e)) : this._colorized ? k.drawImage(h, 0, 0, g.width, g.height, m * d, r * e, p * d, n * e) : k.drawImage(h, g.renderX, g.renderY, g.width, g.height, m * d, r * e, p * d, n * e)) : (h = f._contentSize, g.validRect && (g = this._displayedColor, b.setFillStyle("rgba(" + g.r + "," + g.g + "," + g.b + ",1)"), k.fillRect(m * d, r * e, h.width * d, h.height * e)));
			(f._flippedX || f._flippedY) && b.restore();
			cc.g_NumberOfDraws++
		}
	};
	b._updateColor = cc.sys._supportCanvasNewBlendModes ?
	function() {
		var b = this._node,
			d = this._displayedColor;
		if (255 === d.r && 255 === d.g && 255 === d.b) {
			this._colorized && (this._colorized = !1, b.texture = this._originalTexture)
		} else {
			var e, f = b._texture,
				g = this._textureCoord;
			f && g.validRect && this._originalTexture && (e = f.getHtmlElementObj()) && (this._colorized = !0, e instanceof HTMLCanvasElement && !this._rectRotated && !this._newTextureWhenChangeColor && this._originalTexture._htmlElementObj !== e ? cc.Sprite.CanvasRenderCmd._generateTintImageWithMultiply(this._originalTexture._htmlElementObj, d, g, e) : (e = cc.Sprite.CanvasRenderCmd._generateTintImageWithMultiply(this._originalTexture._htmlElementObj, d, g), f = new cc.Texture2D, f.initWithElement(e), f.handleLoadedTexture(), b.texture = f))
		}
	} : function() {
		var b = this._node,
			d = this._displayedColor;
		if (255 === d.r && 255 === d.g && 255 === d.b) {
			this._colorized && (this._colorized = !1, b.texture = this._originalTexture)
		} else {
			var e, f = b._texture,
				g = this._textureCoord;
			f && g.validRect && this._originalTexture && (e = f.getHtmlElementObj()) && (f = cc.textureCache.getTextureColors(this._originalTexture.getHtmlElementObj())) && (this._colorized = !0, e instanceof HTMLCanvasElement && !this._rectRotated && !this._newTextureWhenChangeColor ? cc.Sprite.CanvasRenderCmd._generateTintImage(e, f, d, g, e) : (e = cc.Sprite.CanvasRenderCmd._generateTintImage(e, f, d, g), f = new cc.Texture2D, f.initWithElement(e), f.handleLoadedTexture(), b.texture = f))
		}
	};
	b.getQuad = function() {
		return null
	};
	b._updateForSetSpriteFrame = function(b, d) {
		var e = this._node;
		e._rectRotated && (e._originalTexture = b);
		this._colorized = !1;
		this._textureCoord.renderX = this._textureCoord.x;
		this._textureCoord.renderY = this._textureCoord.y;
		d && (e = e.getColor(), 255 === e.r && 255 === e.g && 255 === e.b || this._updateColor())
	};
	b.updateTransform = function() {
		var b = this._node;
		if (b.dirty) {
			var d = b._parent;
			!b._visible || d && d !== b._batchNode && d._shouldBeHidden ? b._shouldBeHidden = !0 : (b._shouldBeHidden = !1, b._transformToBatch = d && d !== b._batchNode ? cc.affineTransformConcat(this.getNodeToParentTransform(), d._transformToBatch) : this.getNodeToParentTransform());
			b._recursiveDirty = !1;
			b.dirty = !1
		}
		b._hasChildren && b._arrayMakeObjectsPerformSelector(b._children, cc.Node._stateCallbackType.updateTransform)
	};
	b._updateDisplayColor = function(b) {
		cc.Node.CanvasRenderCmd.prototype._updateDisplayColor.call(this, b)
	};
	b._spriteFrameLoadedCallback = function(b) {
		this.setTextureRect(b.getRect(), b.isRotated(), b.getOriginalSize());
		this._renderCmd._updateColor();
		this.dispatchEvent("load")
	};
	b._textureLoadedCallback = function(b) {
		if (!this._textureLoaded) {
			this._textureLoaded = !0;
			var d = this._rect,
				e = this._renderCmd;
			d ? cc._rectEqualToZero(d) && (d.width = b.width, d.height = b.height) : d = cc.rect(0, 0, b.width, b.height);
			this.texture = e._originalTexture = b;
			this.setTextureRect(d, this._rectRotated);
			b = e._displayedColor;
			255 === b.r && 255 === b.g && 255 === b.b || e._updateColor();
			this.setBatchNode(this._batchNode);
			this.dispatchEvent("load")
		}
	};
	b._setTextureCoords = function(b, d) {
		void 0 === d && (d = !0);
		var e = this._textureCoord,
			f = d ? cc.contentScaleFactor() : 1;
		e.renderX = e.x = 0 | b.x * f;
		e.renderY = e.y = 0 | b.y * f;
		e.width = 0 | b.width * f;
		e.height = 0 | b.height * f;
		e.validRect = !(0 === e.width || 0 === e.height || 0 > e.x || 0 > e.y);
		this._colorized && (this._node._texture = this._originalTexture, this._colorized = !1)
	};
	cc.Sprite.CanvasRenderCmd._generateTintImageWithMultiply = function(b, d, e, f) {
		f = f || cc.newElement("canvas");
		e = e || cc.rect(0, 0, b.width, b.height);
		var g = f.getContext("2d");
		f.width !== e.width || f.height !== e.height ? (f.width = e.width, f.height = e.height) : g.globalCompositeOperation = "source-over";
		g.fillStyle = "rgb(" + (0 | d.r) + "," + (0 | d.g) + "," + (0 | d.b) + ")";
		g.fillRect(0, 0, e.width, e.height);
		g.globalCompositeOperation = "multiply";
		g.drawImage(b, e.x, e.y, e.width, e.height, 0, 0, e.width, e.height);
		g.globalCompositeOperation = "destination-atop";
		g.drawImage(b, e.x, e.y, e.width, e.height, 0, 0, e.width, e.height);
		return f
	};
	cc.Sprite.CanvasRenderCmd._generateTintImage = function(b, d, e, f, g) {
		f || (f = cc.rect(0, 0, b.width, b.height));
		b = e.r / 255;
		var h = e.g / 255;
		e = e.b / 255;
		var k = Math.min(f.width, d[0].width),
			m = Math.min(f.height, d[0].height),
			n;
		g ? (n = g.getContext("2d"), n.clearRect(0, 0, k, m)) : (g = cc.newElement("canvas"), g.width = k, g.height = m, n = g.getContext("2d"));
		n.save();
		n.globalCompositeOperation = "lighter";
		var p = n.globalAlpha;
		0 < b && (n.globalAlpha = b * p, n.drawImage(d[0], f.x, f.y, k, m, 0, 0, k, m));
		0 < h && (n.globalAlpha = h * p, n.drawImage(d[1], f.x, f.y, k, m, 0, 0, k, m));
		0 < e && (n.globalAlpha = e * p, n.drawImage(d[2], f.x, f.y, k, m, 0, 0, k, m));
		1 > b + h + e && (n.globalAlpha = p, n.drawImage(d[3], f.x, f.y, k, m, 0, 0, k, m));
		n.restore();
		return g
	};
	cc.Sprite.CanvasRenderCmd._generateTextureCacheForColor = function(b) {
		function d() {
			var d = cc.Sprite.CanvasRenderCmd._generateTextureCacheForColor,
				f = b.width,
				k = b.height;
			e[0].width = f;
			e[0].height = k;
			e[1].width = f;
			e[1].height = k;
			e[2].width = f;
			e[2].height = k;
			e[3].width = f;
			e[3].height = k;
			d.canvas.width = f;
			d.canvas.height = k;
			var m = d.canvas.getContext("2d");
			m.drawImage(b, 0, 0);
			d.tempCanvas.width = f;
			d.tempCanvas.height = k;
			for (var m = m.getImageData(0, 0, f, k).data, n = 0; 4 > n; n++) {
				var p = e[n].getContext("2d");
				p.getImageData(0, 0, f, k).data;
				d.tempCtx.drawImage(b, 0, 0);
				for (var r = d.tempCtx.getImageData(0, 0, f, k), t = r.data, s = 0; s < m.length; s += 4) {
					t[s] = 0 === n ? m[s] : 0, t[s + 1] = 1 === n ? m[s + 1] : 0, t[s + 2] = 2 === n ? m[s + 2] : 0, t[s + 3] = m[s + 3]
				}
				p.putImageData(r, 0, 0)
			}
			b.onload = null
		}
		if (b.channelCache) {
			return b.channelCache
		}
		var e = [cc.newElement("canvas"), cc.newElement("canvas"), cc.newElement("canvas"), cc.newElement("canvas")];
		try {
			d()
		} catch (f) {
			b.onload = d
		}
		return b.channelCache = e
	};
	cc.Sprite.CanvasRenderCmd._generateTextureCacheForColor.canvas = cc.newElement("canvas");
	cc.Sprite.CanvasRenderCmd._generateTextureCacheForColor.tempCanvas = cc.newElement("canvas");
	cc.Sprite.CanvasRenderCmd._generateTextureCacheForColor.tempCtx = cc.Sprite.CanvasRenderCmd._generateTextureCacheForColor.tempCanvas.getContext("2d");
	cc.Sprite.CanvasRenderCmd._cutRotateImageToCanvas = function(b, d, e) {
		if (!b) {
			return null
		}
		if (!d) {
			return b
		}
		e = null == e ? !0 : e;
		var f = cc.newElement("canvas");
		f.width = d.width;
		f.height = d.height;
		var g = f.getContext("2d");
		g.translate(f.width / 2, f.height / 2);
		e ? g.rotate(-1.5707963267948966) : g.rotate(1.5707963267948966);
		g.drawImage(b, d.x, d.y, d.height, d.width, -d.height / 2, -d.width / 2, d.height, d.width);
		return f
	}
})();
(function() {
	cc.Sprite.WebGLRenderCmd = function(b) {
		cc.Node.WebGLRenderCmd.call(this, b);
		this._needDraw = !0;
		this._quad = new cc.V3F_C4B_T2F_Quad;
		this._quadWebBuffer = cc._renderContext.createBuffer();
		this._quadDirty = !0;
		this._recursiveDirty = this._dirty = !1
	};
	var b = cc.Sprite.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
	b.constructor = cc.Sprite.WebGLRenderCmd;
	b.updateBlendFunc = function(b) {};
	b.setDirtyFlag = function(b) {
		cc.Node.WebGLRenderCmd.prototype.setDirtyFlag.call(this, b);
		this._dirty = !0
	};
	b.setDirtyRecursively = function(b) {
		this._dirty = this._recursiveDirty = b;
		for (var d = this._node._children, e, f = d ? d.length : 0, g = 0; g < f; g++) {
			e = d[g], e instanceof cc.Sprite && e._renderCmd.setDirtyRecursively(b)
		}
	};
	b._setBatchNodeForAddChild = function(b) {
		var d = this._node;
		if (d._batchNode) {
			if (!(b instanceof cc.Sprite)) {
				return cc.log(cc._LogInfos.Sprite_addChild), !1
			}
			b.texture._webTextureObj !== d.textureAtlas.texture._webTextureObj && cc.log(cc._LogInfos.Sprite_addChild_2);
			d._batchNode.appendChild(b);
			d._reorderChildDirty || d._setReorderChildDirtyRecursively()
		}
		return !0
	};
	b._handleTextureForRotatedTexture = function(b) {
		return b
	};
	b.isFrameDisplayed = function(b) {
		var d = this._node;
		return cc.rectEqualToRect(b.getRect(), d._rect) && b.getTexture().getName() === d._texture.getName() && cc.pointEqualToPoint(b.getOffset(), d._unflippedOffsetPositionFromCenter)
	};
	b._init = function() {
		var b = {
			r: 255,
			g: 255,
			b: 255,
			a: 255
		},
			d = this._quad;
		d.bl.colors = b;
		d.br.colors = b;
		d.tl.colors = b;
		d.tr.colors = b;
		this._quadDirty = !0
	};
	b._resetForBatchNode = function() {
		var b = this._node,
			d = b._offsetPosition.x,
			e = b._offsetPosition.y,
			f = d + b._rect.width,
			b = e + b._rect.height,
			g = this._quad;
		g.bl.vertices = {
			x: d,
			y: e,
			z: 0
		};
		g.br.vertices = {
			x: f,
			y: e,
			z: 0
		};
		g.tl.vertices = {
			x: d,
			y: b,
			z: 0
		};
		g.tr.vertices = {
			x: f,
			y: b,
			z: 0
		};
		this._quadDirty = !0
	};
	b.getQuad = function() {
		return this._quad
	};
	b._updateForSetSpriteFrame = function() {};
	b._spriteFrameLoadedCallback = function(b) {
		this.setTextureRect(b.getRect(), b.isRotated(), b.getOriginalSize());
		this.dispatchEvent("load")
	};
	b._textureLoadedCallback = function(b) {
		var d = this._renderCmd;
		if (!this._textureLoaded) {
			this._textureLoaded = !0;
			var e = this._rect;
			e ? cc._rectEqualToZero(e) && (e.width = b.width, e.height = b.height) : e = cc.rect(0, 0, b.width, b.height);
			this.texture = b;
			this.setTextureRect(e, this._rectRotated);
			this.setBatchNode(this._batchNode);
			d._quadDirty = !0;
			this.dispatchEvent("load")
		}
	};
	b._setTextureCoords = function(b, d) {
		void 0 === d && (d = !0);
		d && (b = cc.rectPointsToPixels(b));
		var e = this._node,
			f = e._batchNode ? e.textureAtlas.texture : e._texture;
		if (f) {
			var g = f.pixelsWidth,
				h = f.pixelsHeight,
				k, m, n = this._quad;
			e._rectRotated ? (cc.FIX_ARTIFACTS_BY_STRECHING_TEXEL ? (f = (2 * b.x + 1) / (2 * g), g = f + (2 * b.height - 2) / (2 * g), k = (2 * b.y + 1) / (2 * h), h = k + (2 * b.width - 2) / (2 * h)) : (f = b.x / g, g = (b.x + b.height) / g, k = b.y / h, h = (b.y + b.width) / h), e._flippedX && (m = k, k = h, h = m), e._flippedY && (m = f, f = g, g = m), n.bl.texCoords.u = f, n.bl.texCoords.v = k, n.br.texCoords.u = f, n.br.texCoords.v = h, n.tl.texCoords.u = g, n.tl.texCoords.v = k, n.tr.texCoords.u = g, n.tr.texCoords.v = h) : (cc.FIX_ARTIFACTS_BY_STRECHING_TEXEL ? (f = (2 * b.x + 1) / (2 * g), g = f + (2 * b.width - 2) / (2 * g), k = (2 * b.y + 1) / (2 * h), h = k + (2 * b.height - 2) / (2 * h)) : (f = b.x / g, g = (b.x + b.width) / g, k = b.y / h, h = (b.y + b.height) / h), e._flippedX && (m = f, f = g, g = m), e._flippedY && (m = k, k = h, h = m), n.bl.texCoords.u = f, n.bl.texCoords.v = h, n.br.texCoords.u = g, n.br.texCoords.v = h, n.tl.texCoords.u = f, n.tl.texCoords.v = k, n.tr.texCoords.u = g, n.tr.texCoords.v = k);
			this._quadDirty = !0
		}
	};
	b.transform = function(b, d) {
		cc.Node.WebGLRenderCmd.prototype.transform.call(this, b, d);
		this._dirty = !0
	};
	b._setColorDirty = function() {};
	b._updateColor = function() {
		var b = this._displayedColor,
			d = this._displayedOpacity,
			e = this._node,
			b = {
				r: b.r,
				g: b.g,
				b: b.b,
				a: d
			};
		e._opacityModifyRGB && (b.r *= d / 255, b.g *= d / 255, b.b *= d / 255);
		d = this._quad;
		d.bl.colors = b;
		d.br.colors = b;
		d.tl.colors = b;
		d.tr.colors = b;
		e._batchNode && (e.atlasIndex !== cc.Sprite.INDEX_NOT_INITIALIZED ? e.textureAtlas.updateQuad(d, e.atlasIndex) : this._dirty = !0);
		this._quadDirty = !0
	};
	b._updateBlendFunc = function() {
		if (this._batchNode) {
			cc.log(cc._LogInfos.Sprite__updateBlendFunc)
		} else {
			var b = this._node;
			b._texture && b._texture.hasPremultipliedAlpha() ? (b._blendFunc.src = cc.BLEND_SRC, b._blendFunc.dst = cc.BLEND_DST, b.opacityModifyRGB = !0) : (b._blendFunc.src = cc.SRC_ALPHA, b._blendFunc.dst = cc.ONE_MINUS_SRC_ALPHA, b.opacityModifyRGB = !1)
		}
	};
	b._setTexture = function(b) {
		var d = this._node;
		if (d._batchNode) {
			if (d._batchNode.texture !== b) {
				cc.log(cc._LogInfos.Sprite_setTexture);
				return
			}
		} else {
			d._texture !== b && (d._textureLoaded = b ? b._textureLoaded : !1, d._texture = b, this._updateBlendFunc())
		}
		this._shaderProgram = b ? cc.shaderCache.programForKey(cc.SHADER_POSITION_TEXTURECOLOR) : cc.shaderCache.programForKey(cc.SHADER_POSITION_COLOR)
	};
	b.updateTransform = function() {
		var b = this._node;
		if (this._dirty) {
			var d = this._quad,
				e = b._parent;
			if (!b._visible || e && e !== b._batchNode && e._shouldBeHidden) {
				d.br.vertices = d.tl.vertices = d.tr.vertices = d.bl.vertices = {
					x: 0,
					y: 0,
					z: 0
				}, b._shouldBeHidden = !0
			} else {
				b._shouldBeHidden = !1;
				0 !== this._dirtyFlag && (this.updateStatus(), this._dirtyFlag = 0);
				b._transformToBatch = e && e !== b._batchNode ? cc.affineTransformConcat(this.getNodeToParentTransform(), e._transformToBatch) : this.getNodeToParentTransform();
				var f = b._transformToBatch,
					g = b._rect,
					e = b._offsetPosition.x,
					h = b._offsetPosition.y,
					k = e + g.width,
					m = h + g.height,
					n = f.tx,
					p = f.ty,
					r = f.a,
					t = f.b,
					s = f.d,
					v = -f.c,
					f = e * r - h * v + n,
					g = e * t + h * s + p,
					u = k * r - h * v + n,
					h = k * t + h * s + p,
					A = k * r - m * v + n,
					k = k * t + m * s + p,
					n = e * r - m * v + n,
					e = e * t + m * s + p,
					m = b._vertexZ;
				cc.SPRITEBATCHNODE_RENDER_SUBPIXEL || (f |= 0, g |= 0, u |= 0, h |= 0, A |= 0, k |= 0, n |= 0, e |= 0);
				d.bl.vertices = {
					x: f,
					y: g,
					z: m
				};
				d.br.vertices = {
					x: u,
					y: h,
					z: m
				};
				d.tl.vertices = {
					x: n,
					y: e,
					z: m
				};
				d.tr.vertices = {
					x: A,
					y: k,
					z: m
				}
			}
			b.textureAtlas.updateQuad(d, b.atlasIndex);
			this._dirty = b._recursiveDirty = !1
		}
		b._hasChildren && b._arrayMakeObjectsPerformSelector(b._children, cc.Node._stateCallbackType.updateTransform)
	};
	b._checkTextureBoundary = function(b, d, e) {
		b && b.url && (e ? (e = d.x + d.height, d = d.y + d.width) : (e = d.x + d.width, d = d.y + d.height), e > b.width && cc.error(cc._LogInfos.RectWidth, b.url), d > b.height && cc.error(cc._LogInfos.RectHeight, b.url))
	};
	b.rendering = function(b) {
		var d = this._node,
			e = d._texture;
		e && !e._textureLoaded || 0 === this._displayedOpacity || (b = b || cc._renderContext, e ? e._textureLoaded && (this._shaderProgram.use(), this._shaderProgram._setUniformForMVPMatrixWithMat4(this._stackMatrix), cc.glBlendFunc(d._blendFunc.src, d._blendFunc.dst), cc.glBindTexture2DN(0, e), cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POS_COLOR_TEX), b.bindBuffer(b.ARRAY_BUFFER, this._quadWebBuffer), this._quadDirty && (b.bufferData(b.ARRAY_BUFFER, this._quad.arrayBuffer, b.DYNAMIC_DRAW), this._quadDirty = !1), b.vertexAttribPointer(0, 3, b.FLOAT, !1, 24, 0), b.vertexAttribPointer(1, 4, b.UNSIGNED_BYTE, !0, 24, 12), b.vertexAttribPointer(2, 2, b.FLOAT, !1, 24, 16), b.drawArrays(b.TRIANGLE_STRIP, 0, 4)) : (this._shaderProgram.use(), this._shaderProgram._setUniformForMVPMatrixWithMat4(this._stackMatrix), cc.glBlendFunc(d._blendFunc.src, d._blendFunc.dst), cc.glBindTexture2D(null), cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION | cc.VERTEX_ATTRIB_FLAG_COLOR), b.bindBuffer(b.ARRAY_BUFFER, this._quadWebBuffer), this._quadDirty && (b.bufferData(b.ARRAY_BUFFER, this._quad.arrayBuffer, b.STATIC_DRAW), this._quadDirty = !1), b.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 3, b.FLOAT, !1, 24, 0), b.vertexAttribPointer(cc.VERTEX_ATTRIB_COLOR, 4, b.UNSIGNED_BYTE, !0, 24, 12), b.drawArrays(b.TRIANGLE_STRIP, 0, 4)), cc.g_NumberOfDraws++, 0 === cc.SPRITE_DEBUG_DRAW && !d._showNode) || (cc.kmGLMatrixMode(cc.KM_GL_MODELVIEW), cc.current_stack.stack.push(cc.current_stack.top), cc.current_stack.top = this._stackMatrix, 1 === cc.SPRITE_DEBUG_DRAW || d._showNode ? (d = this._quad, d = [cc.p(d.tl.vertices.x, d.tl.vertices.y), cc.p(d.bl.vertices.x, d.bl.vertices.y), cc.p(d.br.vertices.x, d.br.vertices.y), cc.p(d.tr.vertices.x, d.tr.vertices.y)], cc._drawingUtil.drawPoly(d, 4, !0)) : 2 === cc.SPRITE_DEBUG_DRAW && (e = d.getTextureRect(), d = d.getOffsetPosition(), d = [cc.p(d.x, d.y), cc.p(d.x + e.width, d.y), cc.p(d.x + e.width, d.y + e.height), cc.p(d.x, d.y + e.height)], cc._drawingUtil.drawPoly(d, 4, !0)), cc.current_stack.top = cc.current_stack.stack.pop())
	}
})();
cc.SpriteBatchNode = cc.Node.extend({
	_blendFunc: null,
	_descendants: null,
	_className: "SpriteBatchNode",
	ctor: function(b, c) {
		cc.Node.prototype.ctor.call(this);
		this._descendants = [];
		this._blendFunc = new cc.BlendFunc(cc.BLEND_SRC, cc.BLEND_DST);
		var d;
		c = c || cc.SpriteBatchNode.DEFAULT_CAPACITY;
		cc.isString(b) ? (d = cc.textureCache.getTextureForKey(b)) || (d = cc.textureCache.addImage(b)) : b instanceof cc.Texture2D && (d = b);
		d && this.initWithTexture(d, c)
	},
	addSpriteWithoutQuad: function(b, c, d) {
		cc.assert(b, cc._LogInfos.SpriteBatchNode_addSpriteWithoutQuad_2);
		if (!(b instanceof cc.Sprite)) {
			return cc.log(cc._LogInfos.SpriteBatchNode_addSpriteWithoutQuad), null
		}
		b.atlasIndex = c;
		var e = 0,
			f, g = this._descendants;
		if (g && 0 < g.length) {
			for (e = 0, f = g.length; e < f; e++) {
				var h = g[e];
				if (h && h.atlasIndex >= c) {
					break
				}
			}
		}
		g.splice(e, 0, b);
		cc.Node.prototype.addChild.call(this, b, c, d);
		this.reorderBatch(!1);
		return this
	},
	getTextureAtlas: function() {
		return this._renderCmd.getTextureAtlas()
	},
	setTextureAtlas: function(b) {
		this._renderCmd.getTextureAtlas(b)
	},
	getDescendants: function() {
		return this._descendants
	},
	initWithFile: function(b, c) {
		var d = cc.textureCache.getTextureForKey(b);
		d || (d = cc.textureCache.addImage(b));
		return this.initWithTexture(d, c)
	},
	_setNodeDirtyForCache: function() {
		this._renderCmd && this._renderCmd._setNodeDirtyForCache && this._renderCmd._setNodeDirtyForCache()
	},
	init: function(b, c) {
		var d = cc.textureCache.getTextureForKey(b);
		d || (d = cc.textureCache.addImage(b));
		return this.initWithTexture(d, c)
	},
	increaseAtlasCapacity: function() {
		this._renderCmd.increaseAtlasCapacity()
	},
	removeChildAtIndex: function(b, c) {
		this.removeChild(this._children[b], c)
	},
	rebuildIndexInOrder: function(b, c) {
		var d = b.children;
		if (d && 0 < d.length) {
			for (var e = 0; e < d.length; e++) {
				var f = d[e];
				f && 0 > f.zIndex && (c = this.rebuildIndexInOrder(f, c))
			}
		}!b === this && (b.atlasIndex = c, c++);
		if (d && 0 < d.length) {
			for (e = 0; e < d.length; e++) {
				(f = d[e]) && 0 <= f.zIndex && (c = this.rebuildIndexInOrder(f, c))
			}
		}
		return c
	},
	highestAtlasIndexInChild: function(b) {
		var c = b.children;
		return c && 0 !== c.length ? this.highestAtlasIndexInChild(c[c.length - 1]) : b.atlasIndex
	},
	lowestAtlasIndexInChild: function(b) {
		var c = b.children;
		return c && 0 !== c.length ? this.lowestAtlasIndexInChild(c[c.length - 1]) : b.atlasIndex
	},
	atlasIndexForChild: function(b, c) {
		var d = b.parent,
			e = d.children,
			f = e.indexOf(b),
			g = null;
		0 < f && f < cc.UINT_MAX && (g = e[f - 1]);
		return d === this ? 0 === f ? 0 : this.highestAtlasIndexInChild(g) + 1 : 0 === f ? 0 > c ? d.atlasIndex : d.atlasIndex + 1 : 0 > g.zIndex && 0 > c || 0 <= g.zIndex && 0 <= c ? this.highestAtlasIndexInChild(g) + 1 : d.atlasIndex + 1
	},
	reorderBatch: function(b) {
		this._reorderChildDirty = b
	},
	setBlendFunc: function(b, c) {
		this._blendFunc = void 0 === c ? b : {
			src: b,
			dst: c
		}
	},
	getBlendFunc: function() {
		return new cc.BlendFunc(this._blendFunc.src, this._blendFunc.dst)
	},
	reorderChild: function(b, c) {
		cc.assert(b, cc._LogInfos.SpriteBatchNode_reorderChild_2); - 1 === this._children.indexOf(b) ? cc.log(cc._LogInfos.SpriteBatchNode_reorderChild) : c !== b.zIndex && cc.Node.prototype.reorderChild.call(this, b, c)
	},
	removeChild: function(b, c) {
		null != b && (-1 === this._children.indexOf(b) ? cc.log(cc._LogInfos.SpriteBatchNode_removeChild) : (this.removeSpriteFromAtlas(b), cc.Node.prototype.removeChild.call(this, b, c)))
	},
	updateQuadFromSprite: function(b, c) {
		cc.assert(b, cc._LogInfos.CCSpriteBatchNode_updateQuadFromSprite_2);
		b instanceof cc.Sprite ? (this._renderCmd.checkAtlasCapacity(), b.batchNode = this, b.atlasIndex = c, b.dirty = !0, b.updateTransform()) : cc.log(cc._LogInfos.CCSpriteBatchNode_updateQuadFromSprite)
	},
	insertQuadFromSprite: function(b, c) {
		cc.assert(b, cc._LogInfos.CCSpriteBatchNode_insertQuadFromSprite_2);
		b instanceof cc.Sprite ? (this._renderCmd.insertQuad(b, c), b.batchNode = this, b.atlasIndex = c, b.dirty = !0, b.updateTransform(), this._renderCmd.cutting(b, c)) : cc.log(cc._LogInfos.CCSpriteBatchNode_insertQuadFromSprite)
	},
	initWithTexture: function(b, c) {
		this._children.length = 0;
		this._descendants.length = 0;
		c = c || cc.SpriteBatchNode.DEFAULT_CAPACITY;
		this._renderCmd.initWithTexture(b, c);
		return !0
	},
	insertChild: function(b, c) {
		b.batchNode = this;
		b.atlasIndex = c;
		b.dirty = !0;
		this._renderCmd.insertQuad(b, c);
		this._descendants.splice(c, 0, b);
		var d = c + 1,
			e = this._descendants;
		if (e && 0 < e.length) {
			for (; d < e.length; d++) {
				e[d].atlasIndex++
			}
		}
		var e = b.children,
			f, g;
		if (e) {
			for (d = 0, g = e.length || 0; d < g; d++) {
				if (f = e[d]) {
					var h = this.atlasIndexForChild(f, f.zIndex);
					this.insertChild(f, h)
				}
			}
		}
	},
	appendChild: function(b) {
		this._reorderChildDirty = !0;
		b.batchNode = this;
		b.dirty = !0;
		this._descendants.push(b);
		var c = this._descendants.length - 1;
		b.atlasIndex = c;
		this._renderCmd.insertQuad(b, c);
		b = b.children;
		for (var c = 0, d = b.length || 0; c < d; c++) {
			this.appendChild(b[c])
		}
	},
	removeSpriteFromAtlas: function(b) {
		this._renderCmd.removeQuadAtIndex(b.atlasIndex);
		b.batchNode = null;
		var c = this._descendants,
			d = c.indexOf(b);
		if (-1 !== d) {
			c.splice(d, 1);
			for (var e = c.length; d < e; ++d) {
				c[d].atlasIndex--
			}
		}
		if (b = b.children) {
			for (c = 0, d = b.length || 0; c < d; c++) {
				b[c] && this.removeSpriteFromAtlas(b[c])
			}
		}
	},
	getTexture: function() {
		return this._renderCmd.getTexture()
	},
	setTexture: function(b) {
		this._renderCmd.setTexture(b)
	},
	addChild: function(b, c, d) {
		cc.assert(null != b, cc._LogInfos.CCSpriteBatchNode_addChild_3);
		this._renderCmd.isValidChild(b) && (c = null == c ? b.zIndex : c, d = null == d ? b.tag : d, cc.Node.prototype.addChild.call(this, b, c, d), this.appendChild(b))
	},
	removeAllChildren: function(b) {
		var c = this._descendants;
		if (c && 0 < c.length) {
			for (var d = 0, e = c.length; d < e; d++) {
				c[d] && (c[d].batchNode = null)
			}
		}
		cc.Node.prototype.removeAllChildren.call(this, b);
		this._descendants.length = 0;
		this._renderCmd.removeAllQuads()
	},
	sortAllChildren: function() {
		if (this._reorderChildDirty) {
			var b = this._children,
				c, d = 0,
				e = b.length,
				f;
			for (c = 1; c < e; c++) {
				var g = b[c],
					d = c - 1;
				for (f = b[d]; 0 <= d && (g._localZOrder < f._localZOrder || g._localZOrder === f._localZOrder && g.arrivalOrder < f.arrivalOrder);) {
					b[d + 1] = f, d -= 1, f = b[d]
				}
				b[d + 1] = g
			}
			0 < b.length && (this._arrayMakeObjectsPerformSelector(b, cc.Node._stateCallbackType.sortAllChildren), this._renderCmd.updateChildrenAtlasIndex(b));
			this._reorderChildDirty = !1
		}
	},
	_createRenderCmd: function() {
		return cc._renderType === cc._RENDER_TYPE_CANVAS ? new cc.SpriteBatchNode.CanvasRenderCmd(this) : new cc.SpriteBatchNode.WebGLRenderCmd(this)
	}
});
_p = cc.SpriteBatchNode.prototype;
cc.defineGetterSetter(_p, "texture", _p.getTexture, _p.setTexture);
cc.defineGetterSetter(_p, "textureAtlas", _p.getTextureAtlas, _p.setTextureAtlas);
cc.defineGetterSetter(_p, "descendants", _p.getDescendants);
cc.SpriteBatchNode.DEFAULT_CAPACITY = 29;
cc.SpriteBatchNode.create = function(b, c) {
	return new cc.SpriteBatchNode(b, c)
};
cc.SpriteBatchNode.createWithTexture = cc.SpriteBatchNode.create;
(function() {
	cc.SpriteBatchNode.CanvasRenderCmd = function(b) {
		cc.Node.CanvasRenderCmd.call(this, b);
		this._originalTexture = this._texture = null
	};
	var b = cc.SpriteBatchNode.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
	b.constructor = cc.SpriteBatchNode.CanvasRenderCmd;
	b.checkAtlasCapacity = function() {};
	b.isValidChild = function(b) {
		return b instanceof cc.Sprite ? !0 : (cc.log(cc._LogInfos.Sprite_addChild_4), !1)
	};
	b.initWithTexture = function(b, d) {
		this._texture = this._originalTexture = b
	};
	b.insertQuad = function(b, d) {};
	b.increaseAtlasCapacity = function() {};
	b.removeQuadAtIndex = function() {};
	b.removeAllQuads = function() {};
	b.getTexture = function() {
		return this._texture
	};
	b.setTexture = function(b) {
		this._texture = b;
		for (var d = this._node._children, e = 0; e < d.length; e++) {
			d[e].setTexture(b)
		}
	};
	b.updateChildrenAtlasIndex = function(b) {
		for (var d = this._node._descendants.length = 0, e = b.length; d < e; d++) {
			this._updateAtlasIndex(b[d])
		}
	};
	b._updateAtlasIndex = function(b) {
		var d = this._node._descendants,
			e = b.children,
			f, g = e.length;
		for (f = 0; f < g; f++) {
			if (0 > e[f]._localZOrder) {
				d.push(e[f])
			} else {
				break
			}
		}
		for (d.push(b); f < g; f++) {
			d.push(e[f])
		}
	};
	b.getTextureAtlas = function() {};
	b.setTextureAtlas = function(b) {};
	b.cutting = function(b, d) {
		this._node._children.splice(d, 0, b)
	}
})();
(function() {
	cc.SpriteBatchNode.WebGLRenderCmd = function(b) {
		cc.Node.WebGLRenderCmd.call(this, b);
		this._needDraw = !0;
		this._textureAtlas = null
	};
	var b = cc.SpriteBatchNode.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
	b.constructor = cc.SpriteBatchNode.WebGLRenderCmd;
	b.isValidChild = function(b) {
		return b instanceof cc.Sprite ? b.texture != this.getTexture() ? (cc.log(cc._LogInfos.Sprite_addChild_5), !1) : !0 : (cc.log(cc._LogInfos.Sprite_addChild_4), !1)
	};
	b.rendering = function() {
		var b = this._node;
		0 !== this._textureAtlas.totalQuads && (this._shaderProgram.use(), this._shaderProgram._setUniformForMVPMatrixWithMat4(this._stackMatrix), b._arrayMakeObjectsPerformSelector(b._children, cc.Node._stateCallbackType.updateTransform), cc.glBlendFunc(b._blendFunc.src, b._blendFunc.dst), this._textureAtlas.drawQuads())
	};
	b.visit = function(b) {
		var d = this._node;
		if (d._visible) {
			d._parent && d._parent._renderCmd && (this._curLevel = d._parent._renderCmd._curLevel + 1);
			var e = cc.current_stack;
			e.stack.push(e.top);
			this._dirtyFlag & cc.Node._dirtyFlags.transformDirty || this.transform(b);
			this.updateStatus(b);
			e.top = this._stackMatrix;
			d.sortAllChildren();
			cc.renderer.pushRenderCommand(this);
			this._dirtyFlag = 0;
			e.top = e.stack.pop()
		}
	};
	b.checkAtlasCapacity = function(b) {
		for (var d = this._textureAtlas; b >= d.capacity || d.capacity === d.totalQuads;) {
			this.increaseAtlasCapacity()
		}
	};
	b.increaseAtlasCapacity = function() {
		var b = this._textureAtlas.capacity,
			d = Math.floor(4 * (b + 1) / 3);
		cc.log(cc._LogInfos.SpriteBatchNode_increaseAtlasCapacity, b, d);
		this._textureAtlas.resizeCapacity(d) || cc.log(cc._LogInfos.SpriteBatchNode_increaseAtlasCapacity_2)
	};
	b.initWithTexture = function(b, d) {
		this._textureAtlas = new cc.TextureAtlas;
		this._textureAtlas.initWithTexture(b, d);
		this._updateBlendFunc();
		this._shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_TEXTURECOLOR)
	};
	b.insertQuad = function(b, d) {
		var e = this._textureAtlas;
		e.totalQuads >= e.capacity && this.increaseAtlasCapacity();
		e.insertQuad(b.quad, d)
	};
	b.removeQuadAtIndex = function(b) {
		this._textureAtlas.removeQuadAtIndex(b)
	};
	b.getTexture = function() {
		return this._textureAtlas.texture
	};
	b.setTexture = function(b) {
		this._textureAtlas.setTexture(b);
		b && this._updateBlendFunc()
	};
	b.removeAllQuads = function() {
		this._textureAtlas.removeAllQuads()
	};
	b._swap = function(b, d) {
		var e = this._node._descendants,
			f = this._textureAtlas,
			g = f.quads,
			h = e[b],
			k = cc.V3F_C4B_T2F_QuadCopy(g[b]);
		e[d].atlasIndex = b;
		e[b] = e[d];
		f.updateQuad(g[d], b);
		e[d] = h;
		f.updateQuad(k, d)
	};
	b._updateAtlasIndex = function(b, d) {
		var e = 0,
			f = b.children;
		f && (e = f.length);
		var g = 0;
		if (0 === e) {
			g = b.atlasIndex, b.atlasIndex = d, b.arrivalOrder = 0, g !== d && this._swap(g, d), d++
		} else {
			g = !0;
			0 <= f[0].zIndex && (g = b.atlasIndex, b.atlasIndex = d, b.arrivalOrder = 0, g !== d && this._swap(g, d), d++, g = !1);
			for (e = 0; e < f.length; e++) {
				var h = f[e];
				g && 0 <= h.zIndex && (g = b.atlasIndex, b.atlasIndex = d, b.arrivalOrder = 0, g !== d && this._swap(g, d), d++, g = !1);
				d = this._updateAtlasIndex(h, d)
			}
			g && (g = b.atlasIndex, b.atlasIndex = d, b.arrivalOrder = 0, g !== d && this._swap(g, d), d++)
		}
		return d
	};
	b.updateChildrenAtlasIndex = function(b) {
		for (var d = 0, e = 0; e < b.length; e++) {
			d = this._updateAtlasIndex(b[e], d)
		}
	};
	b._updateBlendFunc = function() {
		if (!this._textureAtlas.texture.hasPremultipliedAlpha()) {
			var b = this._node._blendFunc;
			b.src = cc.SRC_ALPHA;
			b.dst = cc.ONE_MINUS_SRC_ALPHA
		}
	};
	b.getTextureAtlas = function() {
		return this._textureAtlas
	};
	b.setTextureAtlas = function(b) {
		b !== this._textureAtlas && (this._textureAtlas = b)
	};
	b.cutting = function() {}
})();
cc.BakeSprite = cc.Sprite.extend({
	_cacheCanvas: null,
	_cacheContext: null,
	ctor: function() {
		cc.Sprite.prototype.ctor.call(this);
		var b = document.createElement("canvas");
		b.width = b.height = 10;
		this._cacheCanvas = b;
		this._cacheContext = new cc.CanvasContextWrapper(b.getContext("2d"));
		var c = new cc.Texture2D;
		c.initWithElement(b);
		c.handleLoadedTexture();
		this.setTexture(c)
	},
	getCacheContext: function() {
		return this._cacheContext
	},
	getCacheCanvas: function() {
		return this._cacheCanvas
	},
	resetCanvasSize: function(b, c) {
		void 0 === c && (c = b.height, b = b.width);
		var d = this._cacheCanvas;
		d.width = b;
		d.height = c;
		this.getTexture().handleLoadedTexture();
		this.setTextureRect(cc.rect(0, 0, b, c), !1)
	}
});
cc.AnimationFrame = cc.Class.extend({
	_spriteFrame: null,
	_delayPerUnit: 0,
	_userInfo: null,
	ctor: function(b, c, d) {
		this._spriteFrame = b || null;
		this._delayPerUnit = c || 0;
		this._userInfo = d || null
	},
	clone: function() {
		var b = new cc.AnimationFrame;
		b.initWithSpriteFrame(this._spriteFrame.clone(), this._delayPerUnit, this._userInfo);
		return b
	},
	copyWithZone: function(b) {
		return cc.clone(this)
	},
	copy: function(b) {
		b = new cc.AnimationFrame;
		b.initWithSpriteFrame(this._spriteFrame.clone(), this._delayPerUnit, this._userInfo);
		return b
	},
	initWithSpriteFrame: function(b, c, d) {
		this._spriteFrame = b;
		this._delayPerUnit = c;
		this._userInfo = d;
		return !0
	},
	getSpriteFrame: function() {
		return this._spriteFrame
	},
	setSpriteFrame: function(b) {
		this._spriteFrame = b
	},
	getDelayUnits: function() {
		return this._delayPerUnit
	},
	setDelayUnits: function(b) {
		this._delayPerUnit = b
	},
	getUserInfo: function() {
		return this._userInfo
	},
	setUserInfo: function(b) {
		this._userInfo = b
	}
});
cc.AnimationFrame.create = function(b, c, d) {
	return new cc.AnimationFrame(b, c, d)
};
cc.Animation = cc.Class.extend({
	_frames: null,
	_loops: 0,
	_restoreOriginalFrame: !1,
	_duration: 0,
	_delayPerUnit: 0,
	_totalDelayUnits: 0,
	ctor: function(b, c, d) {
		this._frames = [];
		if (void 0 === b) {
			this.initWithSpriteFrames(null, 0)
		} else {
			var e = b[0];
			e && (e instanceof cc.SpriteFrame ? this.initWithSpriteFrames(b, c, d) : e instanceof cc.AnimationFrame && this.initWithAnimationFrames(b, c, d))
		}
	},
	getFrames: function() {
		return this._frames
	},
	setFrames: function(b) {
		this._frames = b
	},
	addSpriteFrame: function(b) {
		var c = new cc.AnimationFrame;
		c.initWithSpriteFrame(b, 1, null);
		this._frames.push(c);
		this._totalDelayUnits++
	},
	addSpriteFrameWithFile: function(b) {
		b = cc.textureCache.addImage(b);
		var c = cc.rect(0, 0, 0, 0);
		c.width = b.width;
		c.height = b.height;
		b = new cc.SpriteFrame(b, c);
		this.addSpriteFrame(b)
	},
	addSpriteFrameWithTexture: function(b, c) {
		var d = new cc.SpriteFrame(b, c);
		this.addSpriteFrame(d)
	},
	initWithAnimationFrames: function(b, c, d) {
		cc.arrayVerifyType(b, cc.AnimationFrame);
		this._delayPerUnit = c;
		this._loops = void 0 === d ? 1 : d;
		this._totalDelayUnits = 0;
		c = this._frames;
		for (d = c.length = 0; d < b.length; d++) {
			var e = b[d];
			c.push(e);
			this._totalDelayUnits += e.getDelayUnits()
		}
		return !0
	},
	clone: function() {
		var b = new cc.Animation;
		b.initWithAnimationFrames(this._copyFrames(), this._delayPerUnit, this._loops);
		b.setRestoreOriginalFrame(this._restoreOriginalFrame);
		return b
	},
	copyWithZone: function(b) {
		b = new cc.Animation;
		b.initWithAnimationFrames(this._copyFrames(), this._delayPerUnit, this._loops);
		b.setRestoreOriginalFrame(this._restoreOriginalFrame);
		return b
	},
	_copyFrames: function() {
		for (var b = [], c = 0; c < this._frames.length; c++) {
			b.push(this._frames[c].clone())
		}
		return b
	},
	copy: function(b) {
		return this.copyWithZone(null)
	},
	getLoops: function() {
		return this._loops
	},
	setLoops: function(b) {
		this._loops = b
	},
	setRestoreOriginalFrame: function(b) {
		this._restoreOriginalFrame = b
	},
	getRestoreOriginalFrame: function() {
		return this._restoreOriginalFrame
	},
	getDuration: function() {
		return this._totalDelayUnits * this._delayPerUnit
	},
	getDelayPerUnit: function() {
		return this._delayPerUnit
	},
	setDelayPerUnit: function(b) {
		this._delayPerUnit = b
	},
	getTotalDelayUnits: function() {
		return this._totalDelayUnits
	},
	initWithSpriteFrames: function(b, c, d) {
		cc.arrayVerifyType(b, cc.SpriteFrame);
		this._loops = void 0 === d ? 1 : d;
		this._delayPerUnit = c || 0;
		this._totalDelayUnits = 0;
		c = this._frames;
		c.length = 0;
		if (b) {
			for (d = 0; d < b.length; d++) {
				var e = b[d],
					f = new cc.AnimationFrame;
				f.initWithSpriteFrame(e, 1, null);
				c.push(f)
			}
			this._totalDelayUnits += b.length
		}
		return !0
	},
	retain: function() {},
	release: function() {}
});
cc.Animation.create = function(b, c, d) {
	return new cc.Animation(b, c, d)
};
cc.Animation.createWithAnimationFrames = cc.Animation.create;
cc.animationCache = {
	_animations: {},
	addAnimation: function(b, c) {
		this._animations[c] = b
	},
	removeAnimation: function(b) {
		b && this._animations[b] && delete this._animations[b]
	},
	getAnimation: function(b) {
		return this._animations[b] ? this._animations[b] : null
	},
	_addAnimationsWithDictionary: function(b, c) {
		var d = b.animations;
		if (d) {
			var e = 1,
				f = b.properties;
			if (f) {
				for (var e = null != f.format ? parseInt(f.format) : e, f = f.spritesheets, g = cc.spriteFrameCache, h = cc.path, k = 0; k < f.length; k++) {
					g.addSpriteFrames(h.changeBasename(c, f[k]))
				}
			}
			switch (e) {
			case 1:
				this._parseVersion1(d);
				break;
			case 2:
				this._parseVersion2(d);
				break;
			default:
				cc.log(cc._LogInfos.animationCache__addAnimationsWithDictionary_2)
			}
		} else {
			cc.log(cc._LogInfos.animationCache__addAnimationsWithDictionary)
		}
	},
	addAnimations: function(b) {
		cc.assert(b, cc._LogInfos.animationCache_addAnimations_2);
		var c = cc.loader.getRes(b);
		c ? this._addAnimationsWithDictionary(c, b) : cc.log(cc._LogInfos.animationCache_addAnimations)
	},
	_parseVersion1: function(b) {
		var c = cc.spriteFrameCache,
			d;
		for (d in b) {
			var e = b[d],
				f = e.frames,
				e = parseFloat(e.delay) || 0,
				g = null;
			if (f) {
				for (var g = [], h = 0; h < f.length; h++) {
					var k = c.getSpriteFrame(f[h]);
					if (k) {
						var m = new cc.AnimationFrame;
						m.initWithSpriteFrame(k, 1, null);
						g.push(m)
					} else {
						cc.log(cc._LogInfos.animationCache__parseVersion1_2, d, f[h])
					}
				}
				0 === g.length ? cc.log(cc._LogInfos.animationCache__parseVersion1_3, d) : (g.length !== f.length && cc.log(cc._LogInfos.animationCache__parseVersion1_4, d), g = new cc.Animation(g, e, 1), cc.animationCache.addAnimation(g, d))
			} else {
				cc.log(cc._LogInfos.animationCache__parseVersion1, d)
			}
		}
	},
	_parseVersion2: function(b) {
		var c = cc.spriteFrameCache,
			d;
		for (d in b) {
			var e = b[d],
				f = e.loop,
				g = parseInt(e.loops),
				f = f ? cc.REPEAT_FOREVER : isNaN(g) ? 1 : g,
				g = e.restoreOriginalFrame && !0 == e.restoreOriginalFrame ? !0 : !1,
				h = e.frames;
			if (h) {
				for (var k = [], m = 0; m < h.length; m++) {
					var n = h[m],
						p = n.spriteframe,
						r = c.getSpriteFrame(p);
					if (r) {
						var p = parseFloat(n.delayUnits) || 0,
							n = n.notification,
							t = new cc.AnimationFrame;
						t.initWithSpriteFrame(r, p, n);
						k.push(t)
					} else {
						cc.log(cc._LogInfos.animationCache__parseVersion2_2, d, p)
					}
				}
				e = parseFloat(e.delayPerUnit) || 0;
				h = new cc.Animation;
				h.initWithAnimationFrames(k, e, f);
				h.setRestoreOriginalFrame(g);
				cc.animationCache.addAnimation(h, d)
			} else {
				cc.log(cc._LogInfos.animationCache__parseVersion2, d)
			}
		}
	},
	_clear: function() {
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
	ctor: function(b, c, d, e, f) {
		this._offset = cc.p(0, 0);
		this._offsetInPixels = cc.p(0, 0);
		this._originalSize = cc.size(0, 0);
		this._rotated = !1;
		this._originalSizeInPixels = cc.size(0, 0);
		this._textureFilename = "";
		this._texture = null;
		this._textureLoaded = !1;
		void 0 !== b && void 0 !== c && (void 0 === d || void 0 === e || void 0 === f ? this.initWithTexture(b, c) : this.initWithTexture(b, c, d, e, f))
	},
	textureLoaded: function() {
		return this._textureLoaded
	},
	addLoadedEventListener: function(b, c) {
		this.addEventListener("load", b, c)
	},
	getRectInPixels: function() {
		var b = this._rectInPixels;
		return cc.rect(b.x, b.y, b.width, b.height)
	},
	setRectInPixels: function(b) {
		this._rectInPixels || (this._rectInPixels = cc.rect(0, 0, 0, 0));
		this._rectInPixels.x = b.x;
		this._rectInPixels.y = b.y;
		this._rectInPixels.width = b.width;
		this._rectInPixels.height = b.height;
		this._rect = cc.rectPixelsToPoints(b)
	},
	isRotated: function() {
		return this._rotated
	},
	setRotated: function(b) {
		this._rotated = b
	},
	getRect: function() {
		var b = this._rect;
		return cc.rect(b.x, b.y, b.width, b.height)
	},
	setRect: function(b) {
		this._rect || (this._rect = cc.rect(0, 0, 0, 0));
		this._rect.x = b.x;
		this._rect.y = b.y;
		this._rect.width = b.width;
		this._rect.height = b.height;
		this._rectInPixels = cc.rectPointsToPixels(this._rect)
	},
	getOffsetInPixels: function() {
		return cc.p(this._offsetInPixels)
	},
	setOffsetInPixels: function(b) {
		this._offsetInPixels.x = b.x;
		this._offsetInPixels.y = b.y;
		cc._pointPixelsToPointsOut(this._offsetInPixels, this._offset)
	},
	getOriginalSizeInPixels: function() {
		return cc.size(this._originalSizeInPixels)
	},
	setOriginalSizeInPixels: function(b) {
		this._originalSizeInPixels.width = b.width;
		this._originalSizeInPixels.height = b.height
	},
	getOriginalSize: function() {
		return cc.size(this._originalSize)
	},
	setOriginalSize: function(b) {
		this._originalSize.width = b.width;
		this._originalSize.height = b.height
	},
	getTexture: function() {
		if (this._texture) {
			return this._texture
		}
		if ("" !== this._textureFilename) {
			var b = cc.textureCache.addImage(this._textureFilename);
			b && (this._textureLoaded = b.isLoaded());
			return b
		}
		return null
	},
	setTexture: function(b) {
		if (this._texture !== b) {
			var c = b.isLoaded();
			this._textureLoaded = c;
			this._texture = b;
			c || b.addEventListener("load", function(b) {
				this._textureLoaded = !0;
				if (this._rotated && cc._renderType === cc._RENDER_TYPE_CANVAS) {
					var c = b.getHtmlElementObj(),
						c = cc.Sprite.CanvasRenderCmd._cutRotateImageToCanvas(c, this.getRect()),
						f = new cc.Texture2D;
					f.initWithElement(c);
					f.handleLoadedTexture();
					this.setTexture(f);
					c = this.getRect();
					this.setRect(cc.rect(0, 0, c.width, c.height))
				}
				c = this._rect;
				0 === c.width && 0 === c.height && (c = b.width, b = b.height, this._rect.width = c, this._rect.height = b, this._rectInPixels = cc.rectPointsToPixels(this._rect), this._originalSizeInPixels.width = this._rectInPixels.width, this._originalSizeInPixels.height = this._rectInPixels.height, this._originalSize.width = c, this._originalSize.height = b);
				this.dispatchEvent("load")
			}, this)
		}
	},
	getOffset: function() {
		return cc.p(this._offset)
	},
	setOffset: function(b) {
		this._offset.x = b.x;
		this._offset.y = b.y
	},
	clone: function() {
		var b = new cc.SpriteFrame;
		b.initWithTexture(this._textureFilename, this._rectInPixels, this._rotated, this._offsetInPixels, this._originalSizeInPixels);
		b.setTexture(this._texture);
		return b
	},
	copyWithZone: function() {
		var b = new cc.SpriteFrame;
		b.initWithTexture(this._textureFilename, this._rectInPixels, this._rotated, this._offsetInPixels, this._originalSizeInPixels);
		b.setTexture(this._texture);
		return b
	},
	copy: function() {
		return this.copyWithZone()
	},
	initWithTexture: function(b, c, d, e, f) {
		2 === arguments.length && (c = cc.rectPointsToPixels(c));
		e = e || cc.p(0, 0);
		f = f || c;
		d = d || !1;
		cc.isString(b) ? (this._texture = null, this._textureFilename = b) : b instanceof cc.Texture2D && this.setTexture(b);
		b = this.getTexture();
		this._rectInPixels = c;
		c = this._rect = cc.rectPixelsToPoints(c);
		if (b && b.url && b.isLoaded()) {
			var g, h;
			d ? (g = c.x + c.height, h = c.y + c.width) : (g = c.x + c.width, h = c.y + c.height);
			g > b.getPixelsWide() && cc.error(cc._LogInfos.RectWidth, b.url);
			h > b.getPixelsHigh() && cc.error(cc._LogInfos.RectHeight, b.url)
		}
		this._offsetInPixels.x = e.x;
		this._offsetInPixels.y = e.y;
		cc._pointPixelsToPointsOut(e, this._offset);
		this._originalSizeInPixels.width = f.width;
		this._originalSizeInPixels.height = f.height;
		cc._sizePixelsToPointsOut(f, this._originalSize);
		this._rotated = d;
		return !0
	}
});
cc.EventHelper.prototype.apply(cc.SpriteFrame.prototype);
cc.SpriteFrame.create = function(b, c, d, e, f) {
	return new cc.SpriteFrame(b, c, d, e, f)
};
cc.SpriteFrame.createWithTexture = cc.SpriteFrame.create;
cc.SpriteFrame._frameWithTextureForCanvas = function(b, c, d, e, f) {
	var g = new cc.SpriteFrame;
	g._texture = b;
	g._rectInPixels = c;
	g._rect = cc.rectPixelsToPoints(c);
	g._offsetInPixels.x = e.x;
	g._offsetInPixels.y = e.y;
	cc._pointPixelsToPointsOut(g._offsetInPixels, g._offset);
	g._originalSizeInPixels.width = f.width;
	g._originalSizeInPixels.height = f.height;
	cc._sizePixelsToPointsOut(g._originalSizeInPixels, g._originalSize);
	g._rotated = d;
	return g
};
cc.spriteFrameCache = {
	_CCNS_REG1: /^\s*\{\s*([\-]?\d+[.]?\d*)\s*,\s*([\-]?\d+[.]?\d*)\s*\}\s*$/,
	_CCNS_REG2: /^\s*\{\s*\{\s*([\-]?\d+[.]?\d*)\s*,\s*([\-]?\d+[.]?\d*)\s*\}\s*,\s*\{\s*([\-]?\d+[.]?\d*)\s*,\s*([\-]?\d+[.]?\d*)\s*\}\s*\}\s*$/,
	_spriteFrames: {},
	_spriteFramesAliases: {},
	_frameConfigCache: {},
	_rectFromString: function(b) {
		return (b = this._CCNS_REG2.exec(b)) ? cc.rect(parseFloat(b[1]), parseFloat(b[2]), parseFloat(b[3]), parseFloat(b[4])) : cc.rect(0, 0, 0, 0)
	},
	_pointFromString: function(b) {
		return (b = this._CCNS_REG1.exec(b)) ? cc.p(parseFloat(b[1]), parseFloat(b[2])) : cc.p(0, 0)
	},
	_sizeFromString: function(b) {
		return (b = this._CCNS_REG1.exec(b)) ? cc.size(parseFloat(b[1]), parseFloat(b[2])) : cc.size(0, 0)
	},
	_getFrameConfig: function(b) {
		var c = cc.loader.getRes(b);
		cc.assert(c, cc._LogInfos.spriteFrameCache__getFrameConfig_2, b);
		cc.loader.release(b);
		if (c._inited) {
			return this._frameConfigCache[b] = c
		}
		this._frameConfigCache[b] = this._parseFrameConfig(c);
		return this._frameConfigCache[b]
	},
	_getFrameConfigByJsonObject: function(b, c) {
		cc.assert(c, cc._LogInfos.spriteFrameCache__getFrameConfig_2, b);
		this._frameConfigCache[b] = this._parseFrameConfig(c);
		return this._frameConfigCache[b]
	},
	_parseFrameConfig: function(b) {
		var c = b.frames,
			d = b.metadata || b.meta;
		b = {};
		var e = {},
			f = 0;
		d && (f = d.format, f = 1 >= f.length ? parseInt(f) : f, e.image = d.textureFileName || d.textureFileName || d.image);
		for (var g in c) {
			var h = c[g];
			if (h) {
				d = {};
				if (0 == f) {
					d.rect = cc.rect(h.x, h.y, h.width, h.height);
					d.rotated = !1;
					d.offset = cc.p(h.offsetX, h.offsetY);
					var k = h.originalWidth,
						h = h.originalHeight;
					k && h || cc.log(cc._LogInfos.spriteFrameCache__getFrameConfig);
					k = Math.abs(k);
					h = Math.abs(h);
					d.size = cc.size(k, h)
				} else {
					if (1 == f || 2 == f) {
						d.rect = this._rectFromString(h.frame), d.rotated = h.rotated || !1, d.offset = this._pointFromString(h.offset), d.size = this._sizeFromString(h.sourceSize)
					} else {
						if (3 == f) {
							var k = this._sizeFromString(h.spriteSize),
								m = this._rectFromString(h.textureRect);
							k && (m = cc.rect(m.x, m.y, k.width, k.height));
							d.rect = m;
							d.rotated = h.textureRotated || !1;
							d.offset = this._pointFromString(h.spriteOffset);
							d.size = this._sizeFromString(h.spriteSourceSize);
							d.aliases = h.aliases
						} else {
							k = h.frame, m = h.sourceSize, g = h.filename || g, d.rect = cc.rect(k.x, k.y, k.w, k.h), d.rotated = h.rotated || !1, d.offset = cc.p(0, 0), d.size = cc.size(m.w, m.h)
						}
					}
				}
				b[g] = d
			}
		}
		return {
			_inited: !0,
			frames: b,
			meta: e
		}
	},
	_addSpriteFramesByObject: function(b, c, d) {
		cc.assert(b, cc._LogInfos.spriteFrameCache_addSpriteFrames_2);
		c && c.frames && (c = this._frameConfigCache[b] || this._getFrameConfigByJsonObject(b, c), this._createSpriteFrames(b, c, d))
	},
	_createSpriteFrames: function(b, c, d) {
		var e = c.frames;
		c = c.meta;
		d ? d instanceof cc.Texture2D || (cc.isString(d) ? d = cc.textureCache.addImage(d) : cc.assert(0, cc._LogInfos.spriteFrameCache_addSpriteFrames_3)) : (d = cc.path.changeBasename(b, c.image || ".png"), d = cc.textureCache.addImage(d));
		b = this._spriteFramesAliases;
		c = this._spriteFrames;
		for (var f in e) {
			var g = e[f],
				h = c[f];
			if (!h) {
				h = new cc.SpriteFrame(d, g.rect, g.rotated, g.offset, g.size);
				if (g = g.aliases) {
					for (var k = 0, m = g.length; k < m; k++) {
						var n = g[k];
						b[n] && cc.log(cc._LogInfos.spriteFrameCache_addSpriteFrames, n);
						b[n] = f
					}
				}
				cc._renderType === cc._RENDER_TYPE_CANVAS && h.isRotated() && h.getTexture().isLoaded() && (g = h.getTexture().getHtmlElementObj(), g = cc.Sprite.CanvasRenderCmd._cutRotateImageToCanvas(g, h.getRectInPixels()), k = new cc.Texture2D, k.initWithElement(g), k.handleLoadedTexture(), h.setTexture(k), g = h._rect, h.setRect(cc.rect(0, 0, g.width, g.height)));
				c[f] = h
			}
		}
	},
	addSpriteFrames: function(b, c) {
		cc.assert(b, cc._LogInfos.spriteFrameCache_addSpriteFrames_2);
		var d = this._frameConfigCache[b] || cc.loader.getRes(b);
		d && d.frames && (d = this._frameConfigCache[b] || this._getFrameConfig(b), this._createSpriteFrames(b, d, c))
	},
	_checkConflict: function(b) {
		b = b.frames;
		for (var c in b) {
			this._spriteFrames[c] && cc.log(cc._LogInfos.spriteFrameCache__checkConflict, c)
		}
	},
	addSpriteFrame: function(b, c) {
		this._spriteFrames[c] = b
	},
	removeSpriteFrames: function() {
		this._spriteFrames = {};
		this._spriteFramesAliases = {}
	},
	removeSpriteFrameByName: function(b) {
		b && (this._spriteFramesAliases[b] && delete this._spriteFramesAliases[b], this._spriteFrames[b] && delete this._spriteFrames[b])
	},
	removeSpriteFramesFromFile: function(b) {
		var c = this._spriteFrames,
			d = this._spriteFramesAliases;
		if (b = this._frameConfigCache[b]) {
			b = b.frames;
			for (var e in b) {
				if (c[e]) {
					delete c[e];
					for (var f in d) {
						d[f] === e && delete d[f]
					}
				}
			}
		}
	},
	removeSpriteFramesFromTexture: function(b) {
		var c = this._spriteFrames,
			d = this._spriteFramesAliases,
			e;
		for (e in c) {
			var f = c[e];
			if (f && f.getTexture() === b) {
				delete c[e];
				for (var g in d) {
					d[g] === e && delete d[g]
				}
			}
		}
	},
	getSpriteFrame: function(b) {
		var c = this._spriteFrames[b];
		if (!c) {
			var d = this._spriteFramesAliases[b];
			d && ((c = this._spriteFrames[d.toString()]) || delete this._spriteFramesAliases[b])
		}
		return c
	},
	_clear: function() {
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
	_init: function() {
		var b = this._valueDict;
		b["cocos2d.x.version"] = cc.ENGINE_VERSION;
		b["cocos2d.x.compiled_with_profiler"] = !1;
		b["cocos2d.x.compiled_with_gl_state_cache"] = cc.ENABLE_GL_STATE_CACHE;
		this._inited = !0
	},
	getMaxTextureSize: function() {
		return this._maxTextureSize
	},
	getMaxModelviewStackDepth: function() {
		return this._maxModelviewStackDepth
	},
	getMaxTextureUnits: function() {
		return this._maxTextureUnits
	},
	supportsNPOT: function() {
		return this._supportsNPOT
	},
	supportsPVRTC: function() {
		return this._supportsPVRTC
	},
	supportsETC: function() {
		return !1
	},
	supportsS3TC: function() {
		return !1
	},
	supportsATITC: function() {
		return !1
	},
	supportsBGRA8888: function() {
		return this._supportsBGRA8888
	},
	supportsDiscardFramebuffer: function() {
		return this._supportsDiscardFramebuffer
	},
	supportsShareableVAO: function() {
		return this._supportsShareableVAO
	},
	checkForGLExtension: function(b) {
		return -1 < this._GlExtensions.indexOf(b)
	},
	getValue: function(b, c) {
		this._inited || this._init();
		var d = this._valueDict;
		return d[b] ? d[b] : c
	},
	setValue: function(b, c) {
		this._valueDict[b] = c
	},
	dumpInfo: function() {
		0 === cc.ENABLE_GL_STATE_CACHE && (cc.log(""), cc.log(cc._LogInfos.configuration_dumpInfo), cc.log(""))
	},
	gatherGPUInfo: function() {
		if (cc._renderType !== cc._RENDER_TYPE_CANVAS) {
			this._inited || this._init();
			var b = cc._renderContext,
				c = this._valueDict;
			c["gl.vendor"] = b.getParameter(b.VENDOR);
			c["gl.renderer"] = b.getParameter(b.RENDERER);
			c["gl.version"] = b.getParameter(b.VERSION);
			this._GlExtensions = "";
			for (var d = b.getSupportedExtensions(), e = 0; e < d.length; e++) {
				this._GlExtensions += d[e] + " "
			}
			this._maxTextureSize = b.getParameter(b.MAX_TEXTURE_SIZE);
			c["gl.max_texture_size"] = this._maxTextureSize;
			this._maxTextureUnits = b.getParameter(b.MAX_COMBINED_TEXTURE_IMAGE_UNITS);
			c["gl.max_texture_units"] = this._maxTextureUnits;
			this._supportsPVRTC = this.checkForGLExtension("GL_IMG_texture_compression_pvrtc");
			c["gl.supports_PVRTC"] = this._supportsPVRTC;
			this._supportsNPOT = !1;
			c["gl.supports_NPOT"] = this._supportsNPOT;
			this._supportsBGRA8888 = this.checkForGLExtension("GL_IMG_texture_format_BGRA888");
			c["gl.supports_BGRA8888"] = this._supportsBGRA8888;
			this._supportsDiscardFramebuffer = this.checkForGLExtension("GL_EXT_discard_framebuffer");
			c["gl.supports_discard_framebuffer"] = this._supportsDiscardFramebuffer;
			this._supportsShareableVAO = this.checkForGLExtension("vertex_array_object");
			c["gl.supports_vertex_array_object"] = this._supportsShareableVAO;
			cc.checkGLErrorDebug()
		}
	},
	loadConfigFile: function(b) {
		this._inited || this._init();
		var c = cc.loader.getRes(b);
		if (!c) {
			throw "Please load the resource first : " + b
		}
		cc.assert(c, cc._LogInfos.configuration_loadConfigFile_2, b);
		if (c = c.data) {
			for (var d in c) {
				this._valueDict[d] = c[d]
			}
		} else {
			cc.log(cc._LogInfos.configuration_loadConfigFile, b)
		}
	}
};
cc.g_NumberOfDraws = 0;
cc.GLToClipTransform = function(b) {
	cc.kmGLGetMatrix(cc.KM_GL_PROJECTION, b);
	var c = new cc.math.Matrix4;
	cc.kmGLGetMatrix(cc.KM_GL_MODELVIEW, c);
	b.multiply(c)
};
cc.Director = cc.Class.extend({
	_landscape: !1,
	_nextDeltaTimeZero: !1,
	_paused: !1,
	_purgeDirectorInNextLoop: !1,
	_sendCleanupToScene: !1,
	_animationInterval: 0,
	_oldAnimationInterval: 0,
	_projection: 0,
	_accumDt: 0,
	_contentScaleFactor: 1,
	_displayStats: !1,
	_deltaTime: 0,
	_frameRate: 0,
	_FPSLabel: null,
	_SPFLabel: null,
	_drawsLabel: null,
	_winSizeInPoints: null,
	_lastUpdate: null,
	_nextScene: null,
	_notificationNode: null,
	_openGLView: null,
	_scenesStack: null,
	_projectionDelegate: null,
	_runningScene: null,
	_frames: 0,
	_totalFrames: 0,
	_secondsPerFrame: 0,
	_dirtyRegion: null,
	_scheduler: null,
	_actionManager: null,
	_eventProjectionChanged: null,
	_eventAfterDraw: null,
	_eventAfterVisit: null,
	_eventAfterUpdate: null,
	ctor: function() {
		var b = this;
		b._lastUpdate = Date.now();
		cc.eventManager.addCustomListener(cc.game.EVENT_SHOW, function() {
			b._lastUpdate = Date.now()
		})
	},
	init: function() {
		this._oldAnimationInterval = this._animationInterval = 1 / cc.defaultFPS;
		this._scenesStack = [];
		this._projection = cc.Director.PROJECTION_DEFAULT;
		this._projectionDelegate = null;
		this._frameRate = this._accumDt = 0;
		this._displayStats = !1;
		this._totalFrames = this._frames = 0;
		this._lastUpdate = Date.now();
		this._purgeDirectorInNextLoop = this._paused = !1;
		this._winSizeInPoints = cc.size(0, 0);
		this._openGLView = null;
		this._contentScaleFactor = 1;
		this._scheduler = new cc.Scheduler;
		cc.ActionManager ? (this._actionManager = new cc.ActionManager, this._scheduler.scheduleUpdate(this._actionManager, cc.Scheduler.PRIORITY_SYSTEM, !1)) : this._actionManager = null;
		this._eventAfterDraw = new cc.EventCustom(cc.Director.EVENT_AFTER_DRAW);
		this._eventAfterDraw.setUserData(this);
		this._eventAfterVisit = new cc.EventCustom(cc.Director.EVENT_AFTER_VISIT);
		this._eventAfterVisit.setUserData(this);
		this._eventAfterUpdate = new cc.EventCustom(cc.Director.EVENT_AFTER_UPDATE);
		this._eventAfterUpdate.setUserData(this);
		this._eventProjectionChanged = new cc.EventCustom(cc.Director.EVENT_PROJECTION_CHANGED);
		this._eventProjectionChanged.setUserData(this);
		return !0
	},
	calculateDeltaTime: function() {
		var b = Date.now();
		this._nextDeltaTimeZero ? (this._deltaTime = 0, this._nextDeltaTimeZero = !1) : this._deltaTime = (b - this._lastUpdate) / 1000;
		0 < cc.game.config[cc.game.CONFIG_KEY.debugMode] && 0.2 < this._deltaTime && (this._deltaTime = 1 / 60);
		this._lastUpdate = b
	},
	convertToGL: null,
	convertToUI: null,
	drawScene: function() {
		var b = cc.renderer;
		this.calculateDeltaTime();
		this._paused || (this._scheduler.update(this._deltaTime), cc.eventManager.dispatchEvent(this._eventAfterUpdate));
		this._clear();
		this._nextScene && this.setNextScene();
		this._beforeVisitScene && this._beforeVisitScene();
		this._runningScene && (!0 === b.childrenOrderDirty ? (cc.renderer.clearRenderCommands(), this._runningScene._renderCmd._curLevel = 0, this._runningScene.visit(), b.resetFlag()) : !0 === b.transformDirty() && b.transform(), cc.eventManager.dispatchEvent(this._eventAfterVisit));
		this._notificationNode && this._notificationNode.visit();
		this._displayStats && this._showStats();
		this._afterVisitScene && this._afterVisitScene();
		b.rendering(cc._renderContext);
		cc.eventManager.dispatchEvent(this._eventAfterDraw);
		this._totalFrames++;
		this._displayStats && this._calculateMPF()
	},
	_beforeVisitScene: null,
	_afterVisitScene: null,
	end: function() {
		this._purgeDirectorInNextLoop = !0
	},
	getContentScaleFactor: function() {
		return this._contentScaleFactor
	},
	getNotificationNode: function() {
		return this._notificationNode
	},
	getWinSize: function() {
		return cc.size(this._winSizeInPoints)
	},
	getWinSizeInPixels: function() {
		return cc.size(this._winSizeInPoints.width * this._contentScaleFactor, this._winSizeInPoints.height * this._contentScaleFactor)
	},
	getVisibleSize: null,
	getVisibleOrigin: null,
	getZEye: null,
	pause: function() {
		this._paused || (this._oldAnimationInterval = this._animationInterval, this.setAnimationInterval(0.25), this._paused = !0)
	},
	popScene: function() {
		cc.assert(this._runningScene, cc._LogInfos.Director_popScene);
		this._scenesStack.pop();
		var b = this._scenesStack.length;
		0 === b ? this.end() : (this._sendCleanupToScene = !0, this._nextScene = this._scenesStack[b - 1])
	},
	purgeCachedData: function() {
		cc.animationCache._clear();
		cc.spriteFrameCache._clear();
		cc.textureCache._clear()
	},
	purgeDirector: function() {
		this.getScheduler().unscheduleAll();
		cc.eventManager && cc.eventManager.setEnabled(!1);
		this._runningScene && (this._runningScene.onExitTransitionDidStart(), this._runningScene.onExit(), this._runningScene.cleanup());
		this._nextScene = this._runningScene = null;
		this._scenesStack.length = 0;
		this.stopAnimation();
		this.purgeCachedData();
		cc.checkGLErrorDebug()
	},
	pushScene: function(b) {
		cc.assert(b, cc._LogInfos.Director_pushScene);
		this._sendCleanupToScene = !1;
		this._scenesStack.push(b);
		this._nextScene = b
	},
	runScene: function(b) {
		cc.assert(b, cc._LogInfos.Director_pushScene);
		if (this._runningScene) {
			var c = this._scenesStack.length;
			0 === c ? (this._sendCleanupToScene = !0, this._scenesStack[c] = b) : (this._sendCleanupToScene = !0, this._scenesStack[c - 1] = b);
			this._nextScene = b
		} else {
			this.pushScene(b), this.startAnimation()
		}
	},
	resume: function() {
		this._paused && (this.setAnimationInterval(this._oldAnimationInterval), (this._lastUpdate = Date.now()) || cc.log(cc._LogInfos.Director_resume), this._paused = !1, this._deltaTime = 0)
	},
	setContentScaleFactor: function(b) {
		b !== this._contentScaleFactor && (this._contentScaleFactor = b, this._createStatsLabel())
	},
	setDepthTest: null,
	setDefaultValues: function() {},
	setNextDeltaTimeZero: function(b) {
		this._nextDeltaTimeZero = b
	},
	setNextScene: function() {
		var b = !1,
			c = !1;
		cc.TransitionScene && (b = this._runningScene ? this._runningScene instanceof cc.TransitionScene : !1, c = this._nextScene ? this._nextScene instanceof cc.TransitionScene : !1);
		if (!c) {
			if (c = this._runningScene) {
				c.onExitTransitionDidStart(), c.onExit()
			}
			this._sendCleanupToScene && c && c.cleanup()
		}
		this._runningScene = this._nextScene;
		cc.renderer.childrenOrderDirty = !0;
		this._nextScene = null;
		b || null === this._runningScene || (this._runningScene.onEnter(), this._runningScene.onEnterTransitionDidFinish())
	},
	setNotificationNode: function(b) {
		this._notificationNode = b
	},
	getDelegate: function() {
		return this._projectionDelegate
	},
	setDelegate: function(b) {
		this._projectionDelegate = b
	},
	setOpenGLView: null,
	setProjection: null,
	setViewport: null,
	getOpenGLView: null,
	getProjection: null,
	setAlphaBlending: null,
	_showStats: function() {
		this._frames++;
		this._accumDt += this._deltaTime;
		this._FPSLabel && this._SPFLabel && this._drawsLabel ? (this._accumDt > cc.DIRECTOR_FPS_INTERVAL && (this._SPFLabel.string = this._secondsPerFrame.toFixed(3), this._frameRate = this._frames / this._accumDt, this._accumDt = this._frames = 0, this._FPSLabel.string = this._frameRate.toFixed(1), this._drawsLabel.string = (0 | cc.g_NumberOfDraws).toString()), this._FPSLabel.visit(), this._SPFLabel.visit(), this._drawsLabel.visit()) : this._createStatsLabel();
		cc.g_NumberOfDraws = 0
	},
	isSendCleanupToScene: function() {
		return this._sendCleanupToScene
	},
	getRunningScene: function() {
		return this._runningScene
	},
	getAnimationInterval: function() {
		return this._animationInterval
	},
	isDisplayStats: function() {
		return this._displayStats
	},
	setDisplayStats: function(b) {
		this._displayStats = b
	},
	getSecondsPerFrame: function() {
		return this._secondsPerFrame
	},
	isNextDeltaTimeZero: function() {
		return this._nextDeltaTimeZero
	},
	isPaused: function() {
		return this._paused
	},
	getTotalFrames: function() {
		return this._totalFrames
	},
	popToRootScene: function() {
		this.popToSceneStackLevel(1)
	},
	popToSceneStackLevel: function(b) {
		cc.assert(this._runningScene, cc._LogInfos.Director_popToSceneStackLevel_2);
		var c = this._scenesStack,
			d = c.length;
		if (0 === d) {
			this.end()
		} else {
			if (!(b > d)) {
				for (; d > b;) {
					var e = c.pop();
					e.running && (e.onExitTransitionDidStart(), e.onExit());
					e.cleanup();
					d--
				}
				this._nextScene = c[c.length - 1];
				this._sendCleanupToScene = !1
			}
		}
	},
	getScheduler: function() {
		return this._scheduler
	},
	setScheduler: function(b) {
		this._scheduler !== b && (this._scheduler = b)
	},
	getActionManager: function() {
		return this._actionManager
	},
	setActionManager: function(b) {
		this._actionManager !== b && (this._actionManager = b)
	},
	getDeltaTime: function() {
		return this._deltaTime
	},
	_createStatsLabel: null,
	_calculateMPF: function() {
		this._secondsPerFrame = (Date.now() - this._lastUpdate) / 1000
	}
});
cc.Director.EVENT_PROJECTION_CHANGED = "director_projection_changed";
cc.Director.EVENT_AFTER_DRAW = "director_after_draw";
cc.Director.EVENT_AFTER_VISIT = "director_after_visit";
cc.Director.EVENT_AFTER_UPDATE = "director_after_update";
cc.DisplayLinkDirector = cc.Director.extend({
	invalid: !1,
	startAnimation: function() {
		this._nextDeltaTimeZero = !0;
		this.invalid = !1
	},
	mainLoop: function() {
		this._purgeDirectorInNextLoop ? (this._purgeDirectorInNextLoop = !1, this.purgeDirector()) : this.invalid || this.drawScene()
	},
	stopAnimation: function() {
		this.invalid = !0
	},
	setAnimationInterval: function(b) {
		this._animationInterval = b;
		this.invalid || (this.stopAnimation(), this.startAnimation())
	}
});
cc.Director.sharedDirector = null;
cc.Director.firstUseDirector = !0;
cc.Director._getInstance = function() {
	cc.Director.firstUseDirector && (cc.Director.firstUseDirector = !1, cc.Director.sharedDirector = new cc.DisplayLinkDirector, cc.Director.sharedDirector.init());
	return cc.Director.sharedDirector
};
cc.defaultFPS = 60;
cc.Director.PROJECTION_2D = 0;
cc.Director.PROJECTION_3D = 1;
cc.Director.PROJECTION_CUSTOM = 3;
cc.Director.PROJECTION_DEFAULT = cc.Director.PROJECTION_3D;
cc._renderType === cc._RENDER_TYPE_CANVAS ? (_p = cc.Director.prototype, _p.setProjection = function(b) {
	this._projection = b;
	cc.eventManager.dispatchEvent(this._eventProjectionChanged)
}, _p.setDepthTest = function() {}, _p.setOpenGLView = function(b) {
	this._winSizeInPoints.width = cc._canvas.width;
	this._winSizeInPoints.height = cc._canvas.height;
	this._openGLView = b || cc.view;
	cc.eventManager && cc.eventManager.setEnabled(!0)
}, _p._clear = function() {
	var b = this._openGLView.getViewPortRect(),
		c = cc._renderContext.getContext();
	c.setTransform(1, 0, 0, 1, 0, 0);
	c.clearRect(-b.x, b.y, b.width, b.height)
}, _p._createStatsLabel = function() {
	var b = 0,
		b = this._winSizeInPoints.width > this._winSizeInPoints.height ? 0 | this._winSizeInPoints.height / 320 * 24 : 0 | this._winSizeInPoints.width / 320 * 24;
	this._FPSLabel = new cc.LabelTTF("000.0", "Arial", b);
	this._SPFLabel = new cc.LabelTTF("0.000", "Arial", b);
	this._drawsLabel = new cc.LabelTTF("0000", "Arial", b);
	b = cc.DIRECTOR_STATS_POSITION;
	this._drawsLabel.setPosition(this._drawsLabel.width / 2 + b.x, 5 * this._drawsLabel.height / 2 + b.y);
	this._SPFLabel.setPosition(this._SPFLabel.width / 2 + b.x, 3 * this._SPFLabel.height / 2 + b.y);
	this._FPSLabel.setPosition(this._FPSLabel.width / 2 + b.x, this._FPSLabel.height / 2 + b.y)
}, _p.getVisibleSize = function() {
	return this.getWinSize()
}, _p.getVisibleOrigin = function() {
	return cc.p(0, 0)
}) : (cc.Director._fpsImage = new Image, cc._addEventListener(cc.Director._fpsImage, "load", function() {
	cc.Director._fpsImageLoaded = !0
}), cc._fpsImage && (cc.Director._fpsImage.src = cc._fpsImage));
cc._renderType === cc._RENDER_TYPE_WEBGL &&
function() {
	cc.DirectorDelegate = cc.Class.extend({
		updateProjection: function() {}
	});
	var b = cc.Director.prototype;
	b.setProjection = function(b) {
		var d = this._winSizeInPoints;
		this.setViewport();
		var e = this._openGLView,
			f = e._viewPortRect.x / e._scaleX,
			g = e._viewPortRect.y / e._scaleY;
		switch (b) {
		case cc.Director.PROJECTION_2D:
			cc.kmGLMatrixMode(cc.KM_GL_PROJECTION);
			cc.kmGLLoadIdentity();
			e = cc.math.Matrix4.createOrthographicProjection(-f, d.width - f, -g, d.height - g, -1024, 1024);
			cc.kmGLMultMatrix(e);
			cc.kmGLMatrixMode(cc.KM_GL_MODELVIEW);
			cc.kmGLLoadIdentity();
			break;
		case cc.Director.PROJECTION_3D:
			var h = this.getZEye(),
				k = new cc.math.Matrix4,
				e = new cc.math.Matrix4;
			cc.kmGLMatrixMode(cc.KM_GL_PROJECTION);
			cc.kmGLLoadIdentity();
			k = cc.math.Matrix4.createPerspectiveProjection(60, d.width / d.height, 0.1, 2 * h);
			cc.kmGLMultMatrix(k);
			cc.kmGLMatrixMode(cc.KM_GL_MODELVIEW);
			cc.kmGLLoadIdentity();
			h = new cc.math.Vec3(-f + d.width / 2, -g + d.height / 2, h);
			d = new cc.math.Vec3(-f + d.width / 2, -g + d.height / 2, 0);
			f = new cc.math.Vec3(0, 1, 0);
			e.lookAt(h, d, f);
			cc.kmGLMultMatrix(e);
			break;
		case cc.Director.PROJECTION_CUSTOM:
			this._projectionDelegate && this._projectionDelegate.updateProjection();
			break;
		default:
			cc.log(cc._LogInfos.Director_setProjection)
		}
		this._projection = b;
		cc.eventManager.dispatchEvent(this._eventProjectionChanged);
		cc.setProjectionMatrixDirty();
		cc.renderer.childrenOrderDirty = !0
	};
	b.setDepthTest = function(b) {
		var d = cc._renderContext;
		b ? (d.clearDepth(1), d.enable(d.DEPTH_TEST), d.depthFunc(d.LEQUAL)) : d.disable(d.DEPTH_TEST)
	};
	b.setOpenGLView = function(b) {
		this._winSizeInPoints.width = cc._canvas.width;
		this._winSizeInPoints.height = cc._canvas.height;
		this._openGLView = b || cc.view;
		b = cc.configuration;
		b.gatherGPUInfo();
		b.dumpInfo();
		this._createStatsLabel();
		this.setGLDefaultValues();
		cc.eventManager && cc.eventManager.setEnabled(!0)
	};
	b._clear = function() {
		var b = cc._renderContext;
		b.clear(b.COLOR_BUFFER_BIT | b.DEPTH_BUFFER_BIT)
	};
	b._beforeVisitScene = function() {
		cc.kmGLPushMatrix()
	};
	b._afterVisitScene = function() {
		cc.kmGLPopMatrix()
	};
	b._createStatsLabel = function() {
		if (!cc.LabelAtlas) {
			this._createStatsLabelForCanvas()
		} else {
			if (null != cc.Director._fpsImageLoaded && !1 !== cc.Director._fpsImageLoaded) {
				var b = new cc.Texture2D;
				b.initWithElement(cc.Director._fpsImage);
				b.handleLoadedTexture();
				var d = cc.view.getDesignResolutionSize().height / 320;
				0 === d && (d = this._winSizeInPoints.height / 320);
				var e = new cc.LabelAtlas;
				e._setIgnoreContentScaleFactor(!0);
				e.initWithString("00.0", b, 12, 32, ".");
				e.scale = d;
				this._FPSLabel = e;
				e = new cc.LabelAtlas;
				e._setIgnoreContentScaleFactor(!0);
				e.initWithString("0.000", b, 12, 32, ".");
				e.scale = d;
				this._SPFLabel = e;
				e = new cc.LabelAtlas;
				e._setIgnoreContentScaleFactor(!0);
				e.initWithString("000", b, 12, 32, ".");
				e.scale = d;
				this._drawsLabel = e;
				b = cc.DIRECTOR_STATS_POSITION;
				this._drawsLabel.setPosition(b.x, 34 * d + b.y);
				this._SPFLabel.setPosition(b.x, 17 * d + b.y);
				this._FPSLabel.setPosition(b)
			}
		}
	};
	b._createStatsLabelForCanvas = function() {
		var b = 0,
			b = this._winSizeInPoints.width > this._winSizeInPoints.height ? 0 | this._winSizeInPoints.height / 320 * 24 : 0 | this._winSizeInPoints.width / 320 * 24;
		this._FPSLabel = new cc.LabelTTF("000.0", "Arial", b);
		this._SPFLabel = new cc.LabelTTF("0.000", "Arial", b);
		this._drawsLabel = new cc.LabelTTF("0000", "Arial", b);
		b = cc.DIRECTOR_STATS_POSITION;
		this._drawsLabel.setPosition(this._drawsLabel.width / 2 + b.x, 5 * this._drawsLabel.height / 2 + b.y);
		this._SPFLabel.setPosition(this._SPFLabel.width / 2 + b.x, 3 * this._SPFLabel.height / 2 + b.y);
		this._FPSLabel.setPosition(this._FPSLabel.width / 2 + b.x, this._FPSLabel.height / 2 + b.y)
	};
	b.convertToGL = function(b) {
		var d = new cc.math.Matrix4;
		cc.GLToClipTransform(d);
		var e = d.inverse(),
			d = d.mat[14] / d.mat[15],
			f = this._openGLView.getDesignResolutionSize();
		b = new cc.math.Vec3(2 * b.x / f.width - 1, 1 - 2 * b.y / f.height, d);
		b.transformCoord(e);
		return cc.p(b.x, b.y)
	};
	b.convertToUI = function(b) {
		var d = new cc.math.Matrix4;
		cc.GLToClipTransform(d);
		b = new cc.math.Vec3(b.x, b.y, 0);
		b.transformCoord(d);
		d = this._openGLView.getDesignResolutionSize();
		return cc.p(d.width * (0.5 * b.x + 0.5), d.height * (0.5 * -b.y + 0.5))
	};
	b.getVisibleSize = function() {
		return this._openGLView.getVisibleSize()
	};
	b.getVisibleOrigin = function() {
		return this._openGLView.getVisibleOrigin()
	};
	b.getZEye = function() {
		return this._winSizeInPoints.height / 1.1566
	};
	b.setViewport = function() {
		var b = this._openGLView;
		if (b) {
			var d = this._winSizeInPoints;
			b.setViewPortInPoints(-b._viewPortRect.x / b._scaleX, -b._viewPortRect.y / b._scaleY, d.width, d.height)
		}
	};
	b.getOpenGLView = function() {
		return this._openGLView
	};
	b.getProjection = function() {
		return this._projection
	};
	b.setAlphaBlending = function(b) {
		b ? cc.glBlendFunc(cc.BLEND_SRC, cc.BLEND_DST) : cc.glBlendFunc(cc._renderContext.ONE, cc._renderContext.ZERO)
	};
	b.setGLDefaultValues = function() {
		this.setAlphaBlending(!0);
		this.setDepthTest(!1);
		this.setProjection(this._projection);
		cc._renderContext.clearColor(0, 0, 0, 1)
	}
}();
cc.Camera = cc.Class.extend({
	_eyeX: null,
	_eyeY: null,
	_eyeZ: null,
	_centerX: null,
	_centerY: null,
	_centerZ: null,
	_upX: null,
	_upY: null,
	_upZ: null,
	_dirty: !1,
	_lookupMatrix: null,
	ctor: function() {
		this._lookupMatrix = new cc.math.Matrix4;
		this.restore()
	},
	description: function() {
		return "<CCCamera | center =(" + this._centerX + "," + this._centerY + "," + this._centerZ + ")>"
	},
	setDirty: function(b) {
		this._dirty = b
	},
	isDirty: function() {
		return this._dirty
	},
	restore: function() {
		this._eyeX = this._eyeY = 0;
		this._eyeZ = cc.Camera.getZEye();
		this._upX = this._centerX = this._centerY = this._centerZ = 0;
		this._upY = 1;
		this._upZ = 0;
		this._lookupMatrix.identity();
		this._dirty = !1
	},
	locate: function() {
		if (this._dirty) {
			var b = new cc.math.Vec3(this._eyeX, this._eyeY, this._eyeZ),
				c = new cc.math.Vec3(this._centerX, this._centerY, this._centerZ),
				d = new cc.math.Vec3(this._upX, this._upY, this._upZ);
			this._lookupMatrix.lookAt(b, c, d);
			this._dirty = !1
		}
		cc.kmGLMultMatrix(this._lookupMatrix)
	},
	_locateForRenderer: function(b) {
		if (this._dirty) {
			var c = new cc.math.Vec3(this._eyeX, this._eyeY, this._eyeZ),
				d = new cc.math.Vec3(this._centerX, this._centerY, this._centerZ),
				e = new cc.math.Vec3(this._upX, this._upY, this._upZ);
			this._lookupMatrix.lookAt(c, d, e);
			this._dirty = !1
		}
		b.multiply(this._lookupMatrix)
	},
	setEyeXYZ: function(b, c, d) {
		this.setEye(b, c, d)
	},
	setEye: function(b, c, d) {
		this._eyeX = b;
		this._eyeY = c;
		this._eyeZ = d;
		this._dirty = !0
	},
	setCenterXYZ: function(b, c, d) {
		this.setCenter(b, c, d)
	},
	setCenter: function(b, c, d) {
		this._centerX = b;
		this._centerY = c;
		this._centerZ = d;
		this._dirty = !0
	},
	setUpXYZ: function(b, c, d) {
		this.setUp(b, c, d)
	},
	setUp: function(b, c, d) {
		this._upX = b;
		this._upY = c;
		this._upZ = d;
		this._dirty = !0
	},
	getEyeXYZ: function(b, c, d) {
		return {
			x: this._eyeX,
			y: this._eyeY,
			z: this._eyeZ
		}
	},
	getEye: function() {
		return {
			x: this._eyeX,
			y: this._eyeY,
			z: this._eyeZ
		}
	},
	getCenterXYZ: function(b, c, d) {
		return {
			x: this._centerX,
			y: this._centerY,
			z: this._centerZ
		}
	},
	getCenter: function() {
		return {
			x: this._centerX,
			y: this._centerY,
			z: this._centerZ
		}
	},
	getUpXYZ: function(b, c, d) {
		return {
			x: this._upX,
			y: this._upY,
			z: this._upZ
		}
	},
	getUp: function() {
		return {
			x: this._upX,
			y: this._upY,
			z: this._upZ
		}
	},
	_DISALLOW_COPY_AND_ASSIGN: function(b) {}
});
cc.Camera.getZEye = function() {
	return cc.FLT_EPSILON
};
cc.PRIORITY_NON_SYSTEM = cc.PRIORITY_SYSTEM + 1;
cc.ListEntry = function(b, c, d, e, f, g, h) {
	this.prev = b;
	this.next = c;
	this.callback = d;
	this.target = e;
	this.priority = f;
	this.paused = g;
	this.markedForDeletion = h
};
cc.HashUpdateEntry = function(b, c, d, e, f) {
	this.list = b;
	this.entry = c;
	this.target = d;
	this.callback = e;
	this.hh = f
};
cc.HashTimerEntry = cc.hashSelectorEntry = function(b, c, d, e, f, g, h) {
	this.timers = b;
	this.target = c;
	this.timerIndex = d;
	this.currentTimer = e;
	this.currentTimerSalvaged = f;
	this.paused = g;
	this.hh = h
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
	getInterval: function() {
		return this._interval
	},
	setInterval: function(b) {
		this._interval = b
	},
	setupTimerWithInterval: function(b, c, d) {
		this._elapsed = -1;
		this._interval = b;
		this._delay = d;
		this._useDelay = 0 < this._delay;
		this._repeat = c;
		this._runForever = this._repeat === cc.REPEAT_FOREVER
	},
	trigger: function() {
		return 0
	},
	cancel: function() {
		return 0
	},
	ctor: function() {
		this._scheduler = null;
		this._elapsed = -1;
		this._useDelay = this._runForever = !1;
		this._interval = this._delay = this._repeat = this._timesExecuted = 0
	},
	update: function(b) {
		-1 === this._elapsed ? this._timesExecuted = this._elapsed = 0 : (this._elapsed += b, this._runForever && !this._useDelay ? this._elapsed >= this._interval && (this.trigger(), this._elapsed = 0) : (this._useDelay ? this._elapsed >= this._delay && (this.trigger(), this._elapsed -= this._delay, this._timesExecuted += 1, this._useDelay = !1) : this._elapsed >= this._interval && (this.trigger(), this._elapsed = 0, this._timesExecuted += 1), !this._runForever && this._timesExecuted > this._repeat && this.cancel()))
	}
});
cc.TimerTargetSelector = cc.Timer.extend({
	_target: null,
	_selector: null,
	ctor: function() {
		this._selector = this._target = null
	},
	initWithSelector: function(b, c, d, e, f, g) {
		this._scheduler = b;
		this._target = d;
		this._selector = c;
		this.setupTimerWithInterval(e, f, g);
		return !0
	},
	getSelector: function() {
		return this._selector
	},
	trigger: function() {
		this._target && this._selector && this._target.call(this._selector, this._elapsed)
	},
	cancel: function() {
		this._scheduler.unschedule(this._selector, this._target)
	}
});
cc.TimerTargetCallback = cc.Timer.extend({
	_target: null,
	_callback: null,
	_key: null,
	ctor: function() {
		this._callback = this._target = null
	},
	initWithCallback: function(b, c, d, e, f, g, h) {
		this._scheduler = b;
		this._target = d;
		this._callback = c;
		this._key = e;
		this.setupTimerWithInterval(f, g, h);
		return !0
	},
	getCallback: function() {
		return this._callback
	},
	getKey: function() {
		return this._key
	},
	trigger: function() {
		this._callback && this._callback.call(this._target, this._elapsed)
	},
	cancel: function() {
		this._scheduler.unschedule(this._callback, this._target)
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
	ctor: function() {
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
	_schedulePerFrame: function(b, c, d, e) {
		var f = this._hashForUpdates[c.__instanceId];
		if (f && f.entry) {
			if (f.entry.priority !== d) {
				if (this._updateHashLocked) {
					cc.log("warning: you CANNOT change update priority in scheduled function");
					f.entry.markedForDeletion = !1;
					f.entry.paused = e;
					return
				}
				this.unscheduleUpdate(c)
			} else {
				f.entry.markedForDeletion = !1;
				f.entry.paused = e;
				return
			}
		}
		0 === d ? this._appendIn(this._updates0List, b, c, e) : 0 > d ? this._priorityIn(this._updatesNegList, b, c, d, e) : this._priorityIn(this._updatesPosList, b, c, d, e)
	},
	_removeHashElement: function(b) {
		delete this._hashForTimers[b.target.__instanceId];
		cc.arrayRemoveObject(this._arrayForTimers, b);
		b.Timer = null;
		b.target = null
	},
	_removeUpdateFromHash: function(b) {
		if (b = this._hashForUpdates[b.target.__instanceId]) {
			cc.arrayRemoveObject(b.list, b.entry), delete this._hashForUpdates[b.target.__instanceId], b.entry = null, b.target = null
		}
	},
	_priorityIn: function(b, c, d, e, f) {
		c = new cc.ListEntry(null, null, c, d, e, f, !1);
		if (b) {
			f = b.length - 1;
			for (var g = 0; g <= f && !(e < b[g].priority); g++) {}
			b.splice(g, 0, c)
		} else {
			b = [], b.push(c)
		}
		this._hashForUpdates[d.__instanceId] = new cc.HashUpdateEntry(b, c, d, null);
		return b
	},
	_appendIn: function(b, c, d, e) {
		c = new cc.ListEntry(null, null, c, d, 0, e, !1);
		b.push(c);
		this._hashForUpdates[d.__instanceId] = new cc.HashUpdateEntry(b, c, d, null, null)
	},
	setTimeScale: function(b) {
		this._timeScale = b
	},
	getTimeScale: function() {
		return this._timeScale
	},
	update: function(b) {
		this._updateHashLocked = !0;
		1 !== this._timeScale && (b *= this._timeScale);
		var c, d, e, f;
		c = 0;
		d = this._updatesNegList;
		for (e = d.length; c < e; c++) {
			f = d[c], f.paused || f.markedForDeletion || f.callback(b)
		}
		c = 0;
		d = this._updates0List;
		for (e = d.length; c < e; c++) {
			f = d[c], f.paused || f.markedForDeletion || f.callback(b)
		}
		c = 0;
		d = this._updatesPosList;
		for (e = d.length; c < e; c++) {
			f = d[c], f.paused || f.markedForDeletion || f.callback(b)
		}
		e = this._arrayForTimers;
		for (c = 0; c < e.length; c++) {
			this._currentTarget = d = e[c];
			this._currentTargetSalvaged = !1;
			if (!d.paused) {
				for (d.timerIndex = 0; d.timerIndex < d.timers.length; ++d.timerIndex) {
					d.currentTimer = d.timers[d.timerIndex], d.currentTimerSalvaged = !1, d.currentTimer.update(b), d.currentTimer = null
				}
			}
			this._currentTargetSalvaged && 0 === this._currentTarget.timers.length && this._removeHashElement(this._currentTarget)
		}
		c = 0;
		for (d = this._updatesNegList; c < d.length;) {
			f = d[c], f.markedForDeletion ? this._removeUpdateFromHash(f) : c++
		}
		c = 0;
		for (d = this._updates0List; c < d.length;) {
			f = d[c], f.markedForDeletion ? this._removeUpdateFromHash(f) : c++
		}
		c = 0;
		for (d = this._updatesPosList; c < d.length;) {
			f = d[c], f.markedForDeletion ? this._removeUpdateFromHash(f) : c++
		}
		this._updateHashLocked = !1;
		this._currentTarget = null
	},
	scheduleCallbackForTarget: function(b, c, d, e, f, g) {
		this.schedule(c, b, d, e, f, g, b.__instanceId + "")
	},
	schedule: function(b, c, d, e, f, g, h) {
		var k = !1;
		if ("function" !== typeof b) {
			var m = b,
				k = !0
		}!1 === k ? 5 === arguments.length && (h = f, g = e, f = 0, e = cc.REPEAT_FOREVER) : 4 === arguments.length && (g = e, e = cc.REPEAT_FOREVER, f = 0);
		cc.assert(c, cc._LogInfos.Scheduler_scheduleCallbackForTarget_3);
		!1 === k && cc.assert(h, "key should not be empty!");
		var n = this._hashForTimers[c.__instanceId];
		n ? cc.assert(n.paused === g, "") : (n = new cc.HashTimerEntry(null, c, 0, null, null, g, null), this._arrayForTimers.push(n), this._hashForTimers[c.__instanceId] = n);
		var p, r;
		if (null == n.timers) {
			n.timers = []
		} else {
			if (!1 === k) {
				for (r = 0; r < n.timers.length; r++) {
					if (p = n.timers[r], b === p._callback) {
						cc.log(cc._LogInfos.Scheduler_scheduleCallbackForTarget, p.getInterval().toFixed(4), d.toFixed(4));
						p._interval = d;
						return
					}
				}
			} else {
				for (r = 0; r < n.timers.length; ++r) {
					if ((p = n.timers[r]) && m === p.getSelector()) {
						cc.log("CCScheduler#scheduleSelector. Selector already scheduled. Updating interval from: %.4f to %.4f", p.getInterval(), d);
						p.setInterval(d);
						return
					}
				}
			}
		}!1 === k ? (p = new cc.TimerTargetCallback, p.initWithCallback(this, b, c, h, d, e, f)) : (p = new cc.TimerTargetSelector, p.initWithSelector(this, m, c, d, e, f));
		n.timers.push(p)
	},
	scheduleUpdate: function(b, c, d) {
		this._schedulePerFrame(function(d) {
			b.update(d)
		}, b, c, d)
	},
	_getUnscheduleMark: function(b, c) {
		switch (typeof b) {
		case "number":
		case "string":
			return b === c.getKey();
		case "function":
			return b === c._callback;
		default:
			return b === c.getSelector()
		}
	},
	unschedule: function(b, c) {
		if (c && b) {
			var d = this._hashForTimers[c.__instanceId];
			if (d) {
				for (var e = d.timers, f = 0, g = e.length; f < g; f++) {
					var h = e[f];
					if (this._getUnscheduleMark(b, h)) {
						h !== d.currentTimer || d.currentTimerSalvaged || (d.currentTimerSalvaged = !0);
						e.splice(f, 1);
						d.timerIndex >= f && d.timerIndex--;
						0 === e.length && (this._currentTarget === d ? this._currentTargetSalvaged = !0 : this._removeHashElement(d));
						break
					}
				}
			}
		}
	},
	unscheduleUpdate: function(b) {
		null != b && (b = this._hashForUpdates[b.__instanceId]) && (this._updateHashLocked ? b.entry.markedForDeletion = !0 : this._removeUpdateFromHash(b.entry))
	},
	unscheduleAllForTarget: function(b) {
		if (null != b) {
			var c = this._hashForTimers[b.__instanceId];
			c && (-1 < c.timers.indexOf(c.currentTimer) && !c.currentTimerSalvaged && (c.currentTimerSalvaged = !0), c.timers.length = 0, this._currentTarget === c ? this._currentTargetSalvaged = !0 : this._removeHashElement(c));
			this.unscheduleUpdate(b)
		}
	},
	unscheduleAll: function() {
		this.unscheduleAllWithMinPriority(cc.Scheduler.PRIORITY_SYSTEM)
	},
	unscheduleAllWithMinPriority: function(b) {
		var c, d, e = this._arrayForTimers;
		for (c = 0; c < e.length; c++) {
			d = e[c], this.unscheduleAllForTarget(d.target)
		}
		e = 0;
		if (0 > b) {
			for (c = 0; c < this._updatesNegList.length;) {
				e = this._updatesNegList.length, (d = this._updatesNegList[c]) && d.priority >= b && this.unscheduleUpdate(d.target), e == this._updatesNegList.length && c++
			}
		}
		if (0 >= b) {
			for (c = 0; c < this._updates0List.length;) {
				e = this._updates0List.length, (d = this._updates0List[c]) && this.unscheduleUpdate(d.target), e == this._updates0List.length && c++
			}
		}
		for (c = 0; c < this._updatesPosList.length;) {
			e = this._updatesPosList.length, (d = this._updatesPosList[c]) && d.priority >= b && this.unscheduleUpdate(d.target), e == this._updatesPosList.length && c++
		}
	},
	isScheduled: function(b, c) {
		cc.assert(b, "Argument key must not be empty");
		cc.assert(c, "Argument target must be non-nullptr");
		var d = this._hashForUpdates[c.__instanceId];
		if (!d) {
			return !1
		}
		if (null != d.timers) {
			for (var d = d.timers, e = 0; e < d.length; ++e) {
				if (b === d[e].getKey()) {
					return !0
				}
			}
		}
		return !1
	},
	pauseAllTargets: function() {
		return this.pauseAllTargetsWithMinPriority(cc.Scheduler.PRIORITY_SYSTEM)
	},
	pauseAllTargetsWithMinPriority: function(b) {
		var c = [],
			d, e = this._arrayForTimers,
			f, g;
		f = 0;
		for (g = e.length; f < g; f++) {
			if (d = e[f]) {
				d.paused = !0, c.push(d.target)
			}
		}
		if (0 > b) {
			for (f = 0; f < this._updatesNegList.length; f++) {
				(d = this._updatesNegList[f]) && d.priority >= b && (d.paused = !0, c.push(d.target))
			}
		}
		if (0 >= b) {
			for (f = 0; f < this._updates0List.length; f++) {
				if (d = this._updates0List[f]) {
					d.paused = !0, c.push(d.target)
				}
			}
		}
		for (f = 0; f < this._updatesPosList.length; f++) {
			(d = this._updatesPosList[f]) && d.priority >= b && (d.paused = !0, c.push(d.target))
		}
		return c
	},
	resumeTargets: function(b) {
		if (b) {
			for (var c = 0; c < b.length; c++) {
				this.resumeTarget(b[c])
			}
		}
	},
	pauseTarget: function(b) {
		cc.assert(b, cc._LogInfos.Scheduler_pauseTarget);
		var c = this._hashForTimers[b.__instanceId];
		c && (c.paused = !0);
		if (b = this._hashForUpdates[b.__instanceId]) {
			b.entry.paused = !0
		}
	},
	resumeTarget: function(b) {
		cc.assert(b, cc._LogInfos.Scheduler_resumeTarget);
		var c = this._hashForTimers[b.__instanceId];
		c && (c.paused = !1);
		if (b = this._hashForUpdates[b.__instanceId]) {
			b.entry.paused = !1
		}
	},
	isTargetPaused: function(b) {
		cc.assert(b, cc._LogInfos.Scheduler_isTargetPaused);
		var c = this._hashForTimers[b.__instanceId];
		return c ? c.paused : (b = this._hashForUpdates[b.__instanceId]) ? b.entry.paused : !1
	},
	scheduleUpdateForTarget: function(b, c, d) {
		this.scheduleUpdate(b, c, d)
	},
	unscheduleCallbackForTarget: function(b, c) {
		this.unschedule(c, b)
	},
	unscheduleUpdateForTarget: function(b) {
		this.unscheduleUpdate(b)
	},
	unscheduleAllCallbacksForTarget: function(b) {
		this.unschedule(b.__instanceId + "", b)
	},
	unscheduleAllCallbacks: function() {
		this.unscheduleAllWithMinPriority(cc.Scheduler.PRIORITY_SYSTEM)
	},
	unscheduleAllCallbacksWithMinPriority: function(b) {
		this.unscheduleAllWithMinPriority(b)
	}
});
cc.Scheduler.PRIORITY_SYSTEM = -2147483648;
cc.PI2 = 2 * Math.PI;
cc.DrawingPrimitiveCanvas = cc.Class.extend({
	_cacheArray: [],
	_renderContext: null,
	ctor: function(b) {
		this._renderContext = b
	},
	drawPoint: function(b, c) {
		c || (c = 1);
		var d = cc.view.getScaleX(),
			e = cc.view.getScaleY(),
			e = cc.p(b.x * d, b.y * e),
			f = this._renderContext.getContext();
		f.beginPath();
		f.arc(e.x, -e.y, c * d, 0, 2 * Math.PI, !1);
		f.closePath();
		f.fill()
	},
	drawPoints: function(b, c, d) {
		if (null != b) {
			d || (d = 1);
			c = this._renderContext.getContext();
			var e = cc.view.getScaleX(),
				f = cc.view.getScaleY();
			c.beginPath();
			for (var g = 0, h = b.length; g < h; g++) {
				c.arc(b[g].x * e, -b[g].y * f, d * e, 0, 2 * Math.PI, !1)
			}
			c.closePath();
			c.fill()
		}
	},
	drawLine: function(b, c) {
		var d = this._renderContext.getContext(),
			e = cc.view.getScaleX(),
			f = cc.view.getScaleY();
		d.beginPath();
		d.moveTo(b.x * e, -b.y * f);
		d.lineTo(c.x * e, -c.y * f);
		d.closePath();
		d.stroke()
	},
	drawRect: function(b, c) {
		this.drawLine(cc.p(b.x, b.y), cc.p(c.x, b.y));
		this.drawLine(cc.p(c.x, b.y), cc.p(c.x, c.y));
		this.drawLine(cc.p(c.x, c.y), cc.p(b.x, c.y));
		this.drawLine(cc.p(b.x, c.y), cc.p(b.x, b.y))
	},
	drawSolidRect: function(b, c, d) {
		b = [b, cc.p(c.x, b.y), c, cc.p(b.x, c.y)];
		this.drawSolidPoly(b, 4, d)
	},
	drawPoly: function(b, c, d, e) {
		e = e || !1;
		if (null != b) {
			if (3 > b.length) {
				throw Error("Polygon's point must greater than 2")
			}
			var f = b[0];
			c = this._renderContext.getContext();
			var g = cc.view.getScaleX(),
				h = cc.view.getScaleY();
			c.beginPath();
			c.moveTo(f.x * g, -f.y * h);
			for (var f = 1, k = b.length; f < k; f++) {
				c.lineTo(b[f].x * g, -b[f].y * h)
			}
			d && c.closePath();
			e ? c.fill() : c.stroke()
		}
	},
	drawSolidPoly: function(b, c, d) {
		this.setDrawColor(d.r, d.g, d.b, d.a);
		this.drawPoly(b, c, !0, !0)
	},
	drawCircle: function(b, c, d, e, f) {
		f = f || !1;
		e = this._renderContext.getContext();
		var g = cc.view.getScaleX(),
			h = cc.view.getScaleY();
		e.beginPath();
		e.arc(0 | b.x * g, 0 | -(b.y * h), c * g, -d, -(d - 2 * Math.PI), !1);
		f && e.lineTo(0 | b.x * g, 0 | -(b.y * h));
		e.stroke()
	},
	drawQuadBezier: function(b, c, d, e) {
		for (var f = this._cacheArray, g = f.length = 0, h = 0; h < e; h++) {
			var k = Math.pow(1 - g, 2) * b.x + 2 * (1 - g) * g * c.x + g * g * d.x,
				m = Math.pow(1 - g, 2) * b.y + 2 * (1 - g) * g * c.y + g * g * d.y;
			f.push(cc.p(k, m));
			g += 1 / e
		}
		f.push(cc.p(d.x, d.y));
		this.drawPoly(f, e + 1, !1, !1)
	},
	drawCubicBezier: function(b, c, d, e, f) {
		for (var g = this._cacheArray, h = g.length = 0, k = 0; k < f; k++) {
			var m = Math.pow(1 - h, 3) * b.x + 3 * Math.pow(1 - h, 2) * h * c.x + 3 * (1 - h) * h * h * d.x + h * h * h * e.x,
				n = Math.pow(1 - h, 3) * b.y + 3 * Math.pow(1 - h, 2) * h * c.y + 3 * (1 - h) * h * h * d.y + h * h * h * e.y;
			g.push(cc.p(m, n));
			h += 1 / f
		}
		g.push(cc.p(e.x, e.y));
		this.drawPoly(g, f + 1, !1, !1)
	},
	drawCatmullRom: function(b, c) {
		this.drawCardinalSpline(b, 0.5, c)
	},
	drawCardinalSpline: function(b, c, d) {
		cc._renderContext.setStrokeStyle("rgba(255,255,255,1)");
		var e = this._cacheArray;
		e.length = 0;
		for (var f, g, h = 1 / b.length, k = 0; k < d + 1; k++) {
			g = k / d, 1 === g ? (f = b.length - 1, g = 1) : (f = 0 | g / h, g = (g - h * f) / h), f = cc.CardinalSplineAt(cc.getControlPointAt(b, f - 1), cc.getControlPointAt(b, f - 0), cc.getControlPointAt(b, f + 1), cc.getControlPointAt(b, f + 2), c, g), e.push(f)
		}
		this.drawPoly(e, d + 1, !1, !1)
	},
	drawImage: function(b, c, d, e, f) {
		var g = arguments.length,
			h = this._renderContext.getContext();
		switch (g) {
		case 2:
			h.drawImage(b, c.x, -(c.y + b.height));
			break;
		case 3:
			h.drawImage(b, c.x, -(c.y + d.height), d.width, d.height);
			break;
		case 5:
			h.drawImage(b, c.x, c.y, d.width, d.height, e.x, -(e.y + f.height), f.width, f.height);
			break;
		default:
			throw Error("Argument must be non-nil")
		}
	},
	drawStar: function(b, c, d) {
		b = b || this._renderContext;
		var e = b.getContext();
		c *= cc.view.getScaleX();
		d = "rgba(" + (0 | d.r) + "," + (0 | d.g) + "," + (0 | d.b);
		b.setFillStyle(d + ",1)");
		var f = c / 10;
		e.beginPath();
		e.moveTo(-c, c);
		e.lineTo(0, f);
		e.lineTo(c, c);
		e.lineTo(f, 0);
		e.lineTo(c, -c);
		e.lineTo(0, -f);
		e.lineTo(-c, -c);
		e.lineTo(-f, 0);
		e.lineTo(-c, c);
		e.closePath();
		e.fill();
		var g = e.createRadialGradient(0, 0, f, 0, 0, c);
		g.addColorStop(0, d + ", 1)");
		g.addColorStop(0.3, d + ", 0.8)");
		g.addColorStop(1, d + ", 0.0)");
		b.setFillStyle(g);
		e.beginPath();
		e.arc(0, 0, c - f, 0, cc.PI2, !1);
		e.closePath();
		e.fill()
	},
	drawColorBall: function(b, c, d) {
		b = b || this._renderContext;
		var e = b.getContext();
		c *= cc.view.getScaleX();
		d = "rgba(" + (0 | d.r) + "," + (0 | d.g) + "," + (0 | d.b);
		var f = e.createRadialGradient(0, 0, c / 10, 0, 0, c);
		f.addColorStop(0, d + ", 1)");
		f.addColorStop(0.3, d + ", 0.8)");
		f.addColorStop(0.6, d + ", 0.4)");
		f.addColorStop(1, d + ", 0.0)");
		b.setFillStyle(f);
		e.beginPath();
		e.arc(0, 0, c, 0, cc.PI2, !1);
		e.closePath();
		e.fill()
	},
	fillText: function(b, c, d) {
		this._renderContext.getContext().fillText(b, c, -d)
	},
	setDrawColor: function(b, c, d, e) {
		this._renderContext.setFillStyle("rgba(" + b + "," + c + "," + d + "," + e / 255 + ")");
		this._renderContext.setStrokeStyle("rgba(" + b + "," + c + "," + d + "," + e / 255 + ")")
	},
	setPointSize: function(b) {},
	setLineWidth: function(b) {
		this._renderContext.getContext().lineWidth = b * cc.view.getScaleX()
	}
});
cc.DrawingPrimitiveWebGL = cc.Class.extend({
	_renderContext: null,
	_initialized: !1,
	_shader: null,
	_colorLocation: -1,
	_colorArray: null,
	_pointSizeLocation: -1,
	_pointSize: -1,
	ctor: function(b) {
		null == b && (b = cc._renderContext);
		if (!b instanceof WebGLRenderingContext) {
			throw "Can't initialise DrawingPrimitiveWebGL. context need is WebGLRenderingContext"
		}
		this._renderContext = b;
		this._colorArray = new Float32Array([1, 1, 1, 1])
	},
	lazy_init: function() {
		this._initialized || (this._shader = cc.shaderCache.programForKey(cc.SHADER_POSITION_UCOLOR), this._colorLocation = this._renderContext.getUniformLocation(this._shader.getProgram(), "u_color"), this._pointSizeLocation = this._renderContext.getUniformLocation(this._shader.getProgram(), "u_pointSize"), this._initialized = !0)
	},
	drawInit: function() {
		this._initialized = !1
	},
	drawPoint: function(b) {
		this.lazy_init();
		var c = this._renderContext;
		this._shader.use();
		this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
		cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION);
		c.uniform4fv(this._colorLocation, this._colorArray);
		this._shader.setUniformLocationWith1f(this._pointSizeLocation, this._pointSize);
		var d = c.createBuffer();
		c.bindBuffer(c.ARRAY_BUFFER, d);
		c.bufferData(c.ARRAY_BUFFER, new Float32Array([b.x, b.y]), c.STATIC_DRAW);
		c.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, c.FLOAT, !1, 0, 0);
		c.drawArrays(c.POINTS, 0, 1);
		c.deleteBuffer(d);
		cc.incrementGLDraws(1)
	},
	drawPoints: function(b, c) {
		if (b && 0 !== b.length) {
			this.lazy_init();
			var d = this._renderContext;
			this._shader.use();
			this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
			cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION);
			d.uniform4fv(this._colorLocation, this._colorArray);
			this._shader.setUniformLocationWith1f(this._pointSizeLocation, this._pointSize);
			var e = d.createBuffer();
			d.bindBuffer(d.ARRAY_BUFFER, e);
			d.bufferData(d.ARRAY_BUFFER, this._pointsToTypeArray(b), d.STATIC_DRAW);
			d.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, d.FLOAT, !1, 0, 0);
			d.drawArrays(d.POINTS, 0, b.length);
			d.deleteBuffer(e);
			cc.incrementGLDraws(1)
		}
	},
	_pointsToTypeArray: function(b) {
		for (var c = new Float32Array(2 * b.length), d = 0; d < b.length; d++) {
			c[2 * d] = b[d].x, c[2 * d + 1] = b[d].y
		}
		return c
	},
	drawLine: function(b, c) {
		this.lazy_init();
		var d = this._renderContext;
		this._shader.use();
		this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
		cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION);
		d.uniform4fv(this._colorLocation, this._colorArray);
		var e = d.createBuffer();
		d.bindBuffer(d.ARRAY_BUFFER, e);
		d.bufferData(d.ARRAY_BUFFER, this._pointsToTypeArray([b, c]), d.STATIC_DRAW);
		d.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, d.FLOAT, !1, 0, 0);
		d.drawArrays(d.LINES, 0, 2);
		d.deleteBuffer(e);
		cc.incrementGLDraws(1)
	},
	drawRect: function(b, c) {
		this.drawLine(cc.p(b.x, b.y), cc.p(c.x, b.y));
		this.drawLine(cc.p(c.x, b.y), cc.p(c.x, c.y));
		this.drawLine(cc.p(c.x, c.y), cc.p(b.x, c.y));
		this.drawLine(cc.p(b.x, c.y), cc.p(b.x, b.y))
	},
	drawSolidRect: function(b, c, d) {
		b = [b, cc.p(c.x, b.y), c, cc.p(b.x, c.y)];
		this.drawSolidPoly(b, 4, d)
	},
	drawPoly: function(b, c, d) {
		this.lazy_init();
		c = this._renderContext;
		this._shader.use();
		this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
		cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION);
		c.uniform4fv(this._colorLocation, this._colorArray);
		var e = c.createBuffer();
		c.bindBuffer(c.ARRAY_BUFFER, e);
		c.bufferData(c.ARRAY_BUFFER, this._pointsToTypeArray(b), c.STATIC_DRAW);
		c.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, c.FLOAT, !1, 0, 0);
		d ? c.drawArrays(c.LINE_LOOP, 0, b.length) : c.drawArrays(c.LINE_STRIP, 0, b.length);
		c.deleteBuffer(e);
		cc.incrementGLDraws(1)
	},
	drawSolidPoly: function(b, c, d) {
		this.lazy_init();
		d && this.setDrawColor(d.r, d.g, d.b, d.a);
		c = this._renderContext;
		this._shader.use();
		this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
		cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION);
		c.uniform4fv(this._colorLocation, this._colorArray);
		d = c.createBuffer();
		c.bindBuffer(c.ARRAY_BUFFER, d);
		c.bufferData(c.ARRAY_BUFFER, this._pointsToTypeArray(b), c.STATIC_DRAW);
		c.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, c.FLOAT, !1, 0, 0);
		c.drawArrays(c.TRIANGLE_FAN, 0, b.length);
		c.deleteBuffer(d);
		cc.incrementGLDraws(1)
	},
	drawCircle: function(b, c, d, e, f) {
		this.lazy_init();
		var g = 1;
		f && g++;
		var h = 2 * Math.PI / e;
		if (f = new Float32Array(2 * (e + 2))) {
			for (var k = 0; k <= e; k++) {
				var m = k * h,
					n = c * Math.cos(m + d) + b.x,
					m = c * Math.sin(m + d) + b.y;
				f[2 * k] = n;
				f[2 * k + 1] = m
			}
			f[2 * (e + 1)] = b.x;
			f[2 * (e + 1) + 1] = b.y;
			b = this._renderContext;
			this._shader.use();
			this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
			cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION);
			b.uniform4fv(this._colorLocation, this._colorArray);
			c = b.createBuffer();
			b.bindBuffer(b.ARRAY_BUFFER, c);
			b.bufferData(b.ARRAY_BUFFER, f, b.STATIC_DRAW);
			b.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, b.FLOAT, !1, 0, 0);
			b.drawArrays(b.LINE_STRIP, 0, e + g);
			b.deleteBuffer(c);
			cc.incrementGLDraws(1)
		}
	},
	drawQuadBezier: function(b, c, d, e) {
		this.lazy_init();
		for (var f = new Float32Array(2 * (e + 1)), g = 0, h = 0; h < e; h++) {
			f[2 * h] = Math.pow(1 - g, 2) * b.x + 2 * (1 - g) * g * c.x + g * g * d.x, f[2 * h + 1] = Math.pow(1 - g, 2) * b.y + 2 * (1 - g) * g * c.y + g * g * d.y, g += 1 / e
		}
		f[2 * e] = d.x;
		f[2 * e + 1] = d.y;
		b = this._renderContext;
		this._shader.use();
		this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
		cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION);
		b.uniform4fv(this._colorLocation, this._colorArray);
		c = b.createBuffer();
		b.bindBuffer(b.ARRAY_BUFFER, c);
		b.bufferData(b.ARRAY_BUFFER, f, b.STATIC_DRAW);
		b.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, b.FLOAT, !1, 0, 0);
		b.drawArrays(b.LINE_STRIP, 0, e + 1);
		b.deleteBuffer(c);
		cc.incrementGLDraws(1)
	},
	drawCubicBezier: function(b, c, d, e, f) {
		this.lazy_init();
		for (var g = new Float32Array(2 * (f + 1)), h = 0, k = 0; k < f; k++) {
			g[2 * k] = Math.pow(1 - h, 3) * b.x + 3 * Math.pow(1 - h, 2) * h * c.x + 3 * (1 - h) * h * h * d.x + h * h * h * e.x, g[2 * k + 1] = Math.pow(1 - h, 3) * b.y + 3 * Math.pow(1 - h, 2) * h * c.y + 3 * (1 - h) * h * h * d.y + h * h * h * e.y, h += 1 / f
		}
		g[2 * f] = e.x;
		g[2 * f + 1] = e.y;
		b = this._renderContext;
		this._shader.use();
		this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
		cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION);
		b.uniform4fv(this._colorLocation, this._colorArray);
		c = b.createBuffer();
		b.bindBuffer(b.ARRAY_BUFFER, c);
		b.bufferData(b.ARRAY_BUFFER, g, b.STATIC_DRAW);
		b.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, b.FLOAT, !1, 0, 0);
		b.drawArrays(b.LINE_STRIP, 0, f + 1);
		b.deleteBuffer(c);
		cc.incrementGLDraws(1)
	},
	drawCatmullRom: function(b, c) {
		this.drawCardinalSpline(b, 0.5, c)
	},
	drawCardinalSpline: function(b, c, d) {
		this.lazy_init();
		for (var e = new Float32Array(2 * (d + 1)), f, g, h = 1 / b.length, k = 0; k < d + 1; k++) {
			g = k / d, 1 === g ? (f = b.length - 1, g = 1) : (f = 0 | g / h, g = (g - h * f) / h), f = cc.cardinalSplineAt(cc.getControlPointAt(b, f - 1), cc.getControlPointAt(b, f), cc.getControlPointAt(b, f + 1), cc.getControlPointAt(b, f + 2), c, g), e[2 * k] = f.x, e[2 * k + 1] = f.y
		}
		b = this._renderContext;
		this._shader.use();
		this._shader.setUniformForModelViewAndProjectionMatrixWithMat4();
		cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POSITION);
		b.uniform4fv(this._colorLocation, this._colorArray);
		c = b.createBuffer();
		b.bindBuffer(b.ARRAY_BUFFER, c);
		b.bufferData(b.ARRAY_BUFFER, e, b.STATIC_DRAW);
		b.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, b.FLOAT, !1, 0, 0);
		b.drawArrays(b.LINE_STRIP, 0, d + 1);
		b.deleteBuffer(c);
		cc.incrementGLDraws(1)
	},
	setDrawColor: function(b, c, d, e) {
		this._colorArray[0] = b / 255;
		this._colorArray[1] = c / 255;
		this._colorArray[2] = d / 255;
		this._colorArray[3] = e / 255
	},
	setPointSize: function(b) {
		this._pointSize = b * cc.contentScaleFactor()
	},
	setLineWidth: function(b) {
		this._renderContext.lineWidth && this._renderContext.lineWidth(b)
	}
});
cc._tmp.PrototypeLabelTTF = function() {
	var b = cc.LabelTTF.prototype;
	cc.defineGetterSetter(b, "color", b.getColor, b.setColor);
	cc.defineGetterSetter(b, "opacity", b.getOpacity, b.setOpacity);
	cc.defineGetterSetter(b, "string", b.getString, b.setString);
	cc.defineGetterSetter(b, "textAlign", b.getHorizontalAlignment, b.setHorizontalAlignment);
	cc.defineGetterSetter(b, "verticalAlign", b.getVerticalAlignment, b.setVerticalAlignment);
	cc.defineGetterSetter(b, "fontSize", b.getFontSize, b.setFontSize);
	cc.defineGetterSetter(b, "fontName", b.getFontName, b.setFontName);
	cc.defineGetterSetter(b, "font", b._getFont, b._setFont);
	cc.defineGetterSetter(b, "boundingWidth", b._getBoundingWidth, b._setBoundingWidth);
	cc.defineGetterSetter(b, "boundingHeight", b._getBoundingHeight, b._setBoundingHeight);
	cc.defineGetterSetter(b, "fillStyle", b._getFillStyle, b.setFontFillColor);
	cc.defineGetterSetter(b, "strokeStyle", b._getStrokeStyle, b._setStrokeStyle);
	cc.defineGetterSetter(b, "lineWidth", b._getLineWidth, b._setLineWidth);
	cc.defineGetterSetter(b, "shadowOffsetX", b._getShadowOffsetX, b._setShadowOffsetX);
	cc.defineGetterSetter(b, "shadowOffsetY", b._getShadowOffsetY, b._setShadowOffsetY);
	cc.defineGetterSetter(b, "shadowOpacity", b._getShadowOpacity, b._setShadowOpacity);
	cc.defineGetterSetter(b, "shadowBlur", b._getShadowBlur, b._setShadowBlur)
};
cc.LabelTTF = cc.Sprite.extend({
	_dimensions: null,
	_hAlignment: cc.TEXT_ALIGNMENT_CENTER,
	_vAlignment: cc.VERTICAL_TEXT_ALIGNMENT_TOP,
	_fontName: null,
	_fontSize: 0,
	_string: "",
	_originalText: null,
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
	initWithString: function(b, c, d, e, f, g) {
		b = b ? b + "" : "";
		d = d || 16;
		e = e || cc.size(0, 0);
		f = f || cc.TEXT_ALIGNMENT_LEFT;
		g = g || cc.VERTICAL_TEXT_ALIGNMENT_TOP;
		this._opacityModifyRGB = !1;
		this._dimensions = cc.size(e.width, e.height);
		this._fontName = c || "Arial";
		this._hAlignment = f;
		this._vAlignment = g;
		this._fontSize = d;
		this._renderCmd._setFontStyle(this._fontName, d, this._fontStyle, this._fontWeight);
		this.string = b;
		this._renderCmd._setColorsString();
		this._renderCmd._updateTexture();
		this._setUpdateTextureDirty();
		return !0
	},
	_setUpdateTextureDirty: function() {
		this._needUpdateTexture = !0;
		this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.textDirty)
	},
	ctor: function(b, c, d, e, f, g) {
		cc.Sprite.prototype.ctor.call(this);
		this._dimensions = cc.size(0, 0);
		this._hAlignment = cc.TEXT_ALIGNMENT_LEFT;
		this._vAlignment = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
		this._opacityModifyRGB = !1;
		this._fontName = "Arial";
		this._shadowEnabled = !1;
		this._shadowOffset = cc.p(0, 0);
		this._shadowBlur = this._shadowOpacity = 0;
		this._strokeEnabled = !1;
		this._strokeColor = cc.color(255, 255, 255, 255);
		this._strokeSize = 0;
		this._textFillColor = cc.color(255, 255, 255, 255);
		this._strokeShadowOffsetY = this._strokeShadowOffsetX = 0;
		this._needUpdateTexture = !1;
		this._lineWidths = [];
		this._renderCmd._setColorsString();
		this._textureLoaded = !0;
		c && c instanceof cc.FontDefinition ? this.initWithStringAndTextDefinition(b, c) : cc.LabelTTF.prototype.initWithString.call(this, b, c, d, e, f, g)
	},
	init: function() {
		return this.initWithString(" ", this._fontName, this._fontSize)
	},
	description: function() {
		return "<cc.LabelTTF | FontName =" + this._fontName + " FontSize = " + this._fontSize.toFixed(1) + ">"
	},
	getLineHeight: function() {
		return !this._lineHeight || this._lineHeight.charAt ? this._renderCmd._getFontClientHeight() : this._lineHeight || this._renderCmd._getFontClientHeight()
	},
	setLineHeight: function(b) {
		this._lineHeight = b
	},
	getString: function() {
		return this._string
	},
	getHorizontalAlignment: function() {
		return this._hAlignment
	},
	getVerticalAlignment: function() {
		return this._vAlignment
	},
	getDimensions: function() {
		return cc.size(this._dimensions)
	},
	getFontSize: function() {
		return this._fontSize
	},
	getFontName: function() {
		return this._fontName
	},
	initWithStringAndTextDefinition: function(b, c) {
		this._updateWithTextDefinition(c, !1);
		this.string = b;
		return !0
	},
	setTextDefinition: function(b) {
		b && this._updateWithTextDefinition(b, !0)
	},
	getTextDefinition: function() {
		return this._prepareTextDefinition(!1)
	},
	enableShadow: function(b, c, d, e) {
		null != b.r && null != b.g && null != b.b && null != b.a ? this._enableShadow(b, c, d) : this._enableShadowNoneColor(b, c, d, e)
	},
	_enableShadowNoneColor: function(b, c, d, e) {
		d = d || 0.5;
		!1 === this._shadowEnabled && (this._shadowEnabled = !0);
		var f = this._shadowOffset;
		if (f && f.x !== b || f._y !== c) {
			f.x = b, f.y = c
		}
		this._shadowOpacity !== d && (this._shadowOpacity = d);
		this._renderCmd._setColorsString();
		this._shadowBlur !== e && (this._shadowBlur = e);
		this._setUpdateTextureDirty()
	},
	_enableShadow: function(b, c, d) {
		this._shadowColor || (this._shadowColor = cc.color(255, 255, 255, 128));
		this._shadowColor.r = b.r;
		this._shadowColor.g = b.g;
		this._shadowColor.b = b.b;
		this._enableShadowNoneColor(c.width || c.x || 0, c.height || c.y || 0, null != b.a ? b.a / 255 : 0.5, d)
	},
	_getShadowOffsetX: function() {
		return this._shadowOffset.x
	},
	_setShadowOffsetX: function(b) {
		!1 === this._shadowEnabled && (this._shadowEnabled = !0);
		this._shadowOffset.x !== b && (this._shadowOffset.x = b, this._setUpdateTextureDirty())
	},
	_getShadowOffsetY: function() {
		return this._shadowOffset._y
	},
	_setShadowOffsetY: function(b) {
		!1 === this._shadowEnabled && (this._shadowEnabled = !0);
		this._shadowOffset._y !== b && (this._shadowOffset._y = b, this._setUpdateTextureDirty())
	},
	_getShadowOffset: function() {
		return cc.p(this._shadowOffset.x, this._shadowOffset.y)
	},
	_setShadowOffset: function(b) {
		!1 === this._shadowEnabled && (this._shadowEnabled = !0);
		if (this._shadowOffset.x !== b.x || this._shadowOffset.y !== b.y) {
			this._shadowOffset.x = b.x, this._shadowOffset.y = b.y, this._setUpdateTextureDirty()
		}
	},
	_getShadowOpacity: function() {
		return this._shadowOpacity
	},
	_setShadowOpacity: function(b) {
		!1 === this._shadowEnabled && (this._shadowEnabled = !0);
		this._shadowOpacity !== b && (this._shadowOpacity = b, this._renderCmd._setColorsString(), this._setUpdateTextureDirty())
	},
	_getShadowBlur: function() {
		return this._shadowBlur
	},
	_setShadowBlur: function(b) {
		!1 === this._shadowEnabled && (this._shadowEnabled = !0);
		this._shadowBlur !== b && (this._shadowBlur = b, this._setUpdateTextureDirty())
	},
	disableShadow: function() {
		this._shadowEnabled && (this._shadowEnabled = !1, this._setUpdateTextureDirty())
	},
	enableStroke: function(b, c) {
		!1 === this._strokeEnabled && (this._strokeEnabled = !0);
		var d = this._strokeColor;
		if (d.r !== b.r || d.g !== b.g || d.b !== b.b) {
			d.r = b.r, d.g = b.g, d.b = b.b, this._renderCmd._setColorsString()
		}
		this._strokeSize !== c && (this._strokeSize = c || 0);
		this._setUpdateTextureDirty()
	},
	_getStrokeStyle: function() {
		return this._strokeColor
	},
	_setStrokeStyle: function(b) {
		!1 === this._strokeEnabled && (this._strokeEnabled = !0);
		var c = this._strokeColor;
		if (c.r !== b.r || c.g !== b.g || c.b !== b.b) {
			c.r = b.r, c.g = b.g, c.b = b.b, this._renderCmd._setColorsString(), this._setUpdateTextureDirty()
		}
	},
	_getLineWidth: function() {
		return this._strokeSize
	},
	_setLineWidth: function(b) {
		!1 === this._strokeEnabled && (this._strokeEnabled = !0);
		this._strokeSize !== b && (this._strokeSize = b || 0, this._setUpdateTextureDirty())
	},
	disableStroke: function() {
		this._strokeEnabled && (this._strokeEnabled = !1, this._setUpdateTextureDirty())
	},
	setFontFillColor: function(b) {
		var c = this._textFillColor;
		if (c.r !== b.r || c.g !== b.g || c.b !== b.b) {
			c.r = b.r, c.g = b.g, c.b = b.b, this._renderCmd._setColorsString(), this._needUpdateTexture = !0
		}
	},
	_getFillStyle: function() {
		return this._textFillColor
	},
	_updateWithTextDefinition: function(b, c) {
		b.fontDimensions ? (this._dimensions.width = b.boundingWidth, this._dimensions.height = b.boundingHeight) : (this._dimensions.width = 0, this._dimensions.height = 0);
		this._hAlignment = b.textAlign;
		this._vAlignment = b.verticalAlign;
		this._fontName = b.fontName;
		this._fontSize = b.fontSize || 12;
		this._lineHeight = b.lineHeight ? b.lineHeight : this._fontSize;
		this._renderCmd._setFontStyle(b);
		b.shadowEnabled && this.enableShadow(b.shadowOffsetX, b.shadowOffsetY, b.shadowOpacity, b.shadowBlur);
		b.strokeEnabled && this.enableStroke(b.strokeStyle, b.lineWidth);
		this.setFontFillColor(b.fillStyle);
		c && this._renderCmd._updateTexture();
		var d = cc.Node._dirtyFlags;
		this._renderCmd.setDirtyFlag(d.colorDirty | d.opacityDirty | d.textDirty)
	},
	_prepareTextDefinition: function(b) {
		var c = new cc.FontDefinition;
		b ? (c.fontSize = this._fontSize, c.boundingWidth = cc.contentScaleFactor() * this._dimensions.width, c.boundingHeight = cc.contentScaleFactor() * this._dimensions.height) : (c.fontSize = this._fontSize, c.boundingWidth = this._dimensions.width, c.boundingHeight = this._dimensions.height);
		c.fontName = this._fontName;
		c.textAlign = this._hAlignment;
		c.verticalAlign = this._vAlignment;
		if (this._strokeEnabled) {
			c.strokeEnabled = !0;
			var d = this._strokeColor;
			c.strokeStyle = cc.color(d.r, d.g, d.b);
			c.lineWidth = this._strokeSize
		} else {
			c.strokeEnabled = !1
		}
		this._shadowEnabled ? (c.shadowEnabled = !0, c.shadowBlur = this._shadowBlur, c.shadowOpacity = this._shadowOpacity, c.shadowOffsetX = (b ? cc.contentScaleFactor() : 1) * this._shadowOffset.x, c.shadowOffsetY = (b ? cc.contentScaleFactor() : 1) * this._shadowOffset.y) : c._shadowEnabled = !1;
		b = this._textFillColor;
		c.fillStyle = cc.color(b.r, b.g, b.b);
		return c
	},
	setString: function(b) {
		b = String(b);
		this._originalText !== b && (this._originalText = b + "", this._updateString(), this._setUpdateTextureDirty(), this._renderCmd.setDirtyFlag(cc.Node._dirtyFlags.transformDirty))
	},
	_updateString: function() {
		this._string && "" !== this._string || this._string === this._originalText || (cc.renderer.childrenOrderDirty = !0);
		this._string = this._originalText
	},
	setHorizontalAlignment: function(b) {
		b !== this._hAlignment && (this._hAlignment = b, this._setUpdateTextureDirty())
	},
	setVerticalAlignment: function(b) {
		b !== this._vAlignment && (this._vAlignment = b, this._setUpdateTextureDirty())
	},
	setDimensions: function(b, c) {
		var d;
		void 0 === c ? (d = b.width, c = b.height) : d = b;
		if (d !== this._dimensions.width || c !== this._dimensions.height) {
			this._dimensions.width = d, this._dimensions.height = c, this._updateString(), this._setUpdateTextureDirty()
		}
	},
	_getBoundingWidth: function() {
		return this._dimensions.width
	},
	_setBoundingWidth: function(b) {
		b !== this._dimensions.width && (this._dimensions.width = b, this._updateString(), this._setUpdateTextureDirty())
	},
	_getBoundingHeight: function() {
		return this._dimensions.height
	},
	_setBoundingHeight: function(b) {
		b !== this._dimensions.height && (this._dimensions.height = b, this._updateString(), this._setUpdateTextureDirty())
	},
	setFontSize: function(b) {
		this._fontSize !== b && (this._fontSize = b, this._renderCmd._setFontStyle(this._fontName, this._fontSize, this._fontStyle, this._fontWeight), this._setUpdateTextureDirty())
	},
	setFontName: function(b) {
		this._fontName && this._fontName !== b && (this._fontName = b, this._renderCmd._setFontStyle(this._fontName, this._fontSize, this._fontStyle, this._fontWeight), this._setUpdateTextureDirty())
	},
	_getFont: function() {
		return this._renderCmd._getFontStyle()
	},
	_setFont: function(b) {
		if (b = cc.LabelTTF._fontStyleRE.exec(b)) {
			this._fontSize = parseInt(b[1]), this._fontName = b[2], this._renderCmd._setFontStyle(this._fontName, this._fontSize, this._fontStyle, this._fontWeight), this._setUpdateTextureDirty()
		}
	},
	getContentSize: function() {
		this._needUpdateTexture && this._renderCmd._updateTTF();
		return cc.Sprite.prototype.getContentSize.call(this)
	},
	_getWidth: function() {
		this._needUpdateTexture && this._renderCmd._updateTTF();
		return cc.Sprite.prototype._getWidth.call(this)
	},
	_getHeight: function() {
		this._needUpdateTexture && this._renderCmd._updateTTF();
		return cc.Sprite.prototype._getHeight.call(this)
	},
	setTextureRect: function(b, c, d) {
		cc.Sprite.prototype.setTextureRect.call(this, b, c, d, !1)
	},
	_createRenderCmd: function() {
		return cc._renderType === cc._RENDER_TYPE_CANVAS ? new cc.LabelTTF.CanvasRenderCmd(this) : new cc.LabelTTF.WebGLRenderCmd(this)
	},
	_setFontStyle: function(b) {
		this._fontStyle !== b && (this._fontStyle = b, this._renderCmd._setFontStyle(this._fontName, this._fontSize, this._fontStyle, this._fontWeight), this._setUpdateTextureDirty())
	},
	_getFontStyle: function() {
		return this._fontStyle
	},
	_setFontWeight: function(b) {
		this._fontWeight !== b && (this._fontWeight = b, this._renderCmd._setFontStyle(this._fontName, this._fontSize, this._fontStyle, this._fontWeight), this._setUpdateTextureDirty())
	},
	_getFontWeight: function() {
		return this._fontWeight
	}
});
cc.assert(cc.isFunction(cc._tmp.PrototypeLabelTTF), cc._LogInfos.MissingFile, "LabelTTFPropertyDefine.js");
cc._tmp.PrototypeLabelTTF();
delete cc._tmp.PrototypeLabelTTF;
cc.LabelTTF._fontStyleRE = /^(\d+)px\s+['"]?([\w\s\d]+)['"]?$/;
cc.LabelTTF.create = function(b, c, d, e, f, g) {
	return new cc.LabelTTF(b, c, d, e, f, g)
};
cc.LabelTTF.createWithFontDefinition = cc.LabelTTF.create;
cc.LabelTTF._SHADER_PROGRAM = cc.USE_LA88_LABELS ? cc.SHADER_POSITION_TEXTURECOLOR : cc.SHADER_POSITION_TEXTUREA8COLOR;
cc.LabelTTF.__labelHeightDiv = cc.newElement("div");
cc.LabelTTF.__labelHeightDiv.style.fontFamily = "Arial";
cc.LabelTTF.__labelHeightDiv.style.position = "absolute";
cc.LabelTTF.__labelHeightDiv.style.left = "-100px";
cc.LabelTTF.__labelHeightDiv.style.top = "-100px";
cc.LabelTTF.__labelHeightDiv.style.lineHeight = "normal";
document.body ? document.body.appendChild(cc.LabelTTF.__labelHeightDiv) : cc._addEventListener(window, "load", function() {
	this.removeEventListener("load", arguments.callee, !1);
	document.body.appendChild(cc.LabelTTF.__labelHeightDiv)
}, !1);
cc.LabelTTF.__getFontHeightByDiv = function(b, c) {
	if (b instanceof cc.FontDefinition) {
		var d = cc.LabelTTF.__fontHeightCache[b._getCanvasFontStr()];
		if (0 < d) {
			return d
		}
		var e = cc.LabelTTF.__labelHeightDiv;
		e.innerHTML = "ajghl~!";
		e.style.fontFamily = b.fontName;
		e.style.fontSize = b.fontSize + "px";
		e.style.fontStyle = b.fontStyle;
		e.style.fontWeight = b.fontWeight;
		d = e.clientHeight;
		cc.LabelTTF.__fontHeightCache[b._getCanvasFontStr()] = d;
		e.innerHTML = "";
		return d
	}
	d = cc.LabelTTF.__fontHeightCache[b + "." + c];
	if (0 < d) {
		return d
	}
	e = cc.LabelTTF.__labelHeightDiv;
	e.innerHTML = "ajghl~!";
	e.style.fontFamily = b;
	e.style.fontSize = c + "px";
	d = e.clientHeight;
	cc.LabelTTF.__fontHeightCache[b + "." + c] = d;
	e.innerHTML = "";
	return d
};
cc.LabelTTF.__fontHeightCache = {};
cc.LabelTTF._textAlign = ["left", "center", "right"];
cc.LabelTTF._textBaseline = ["top", "middle", "bottom"];
cc.LabelTTF.wrapInspection = !0;
cc.LabelTTF._wordRex = /([a-zA-Z0-9ÄÖÜäöüßéèçàùêâîôû]+|\S)/;
cc.LabelTTF._symbolRex = /^[!,.:;}\]%\?>、‘“》？。，！]/;
cc.LabelTTF._lastWordRex = /([a-zA-Z0-9ÄÖÜäöüßéèçàùêâîôû]+|\S)$/;
cc.LabelTTF._lastEnglish = /[a-zA-Z0-9ÄÖÜäöüßéèçàùêâîôû]+$/;
cc.LabelTTF._firsrEnglish = /^[a-zA-Z0-9ÄÖÜäöüßéèçàùêâîôû]/;
(function() {
	cc.LabelTTF.RenderCmd = function() {
		this._fontClientHeight = 18;
		this._fontStyleStr = "";
		this._shadowColorStr = "rgba(128, 128, 128, 0.5)";
		this._strokeColorStr = "";
		this._fillColorStr = "rgba(255,255,255,1)";
		this._labelContext = this._labelCanvas = null;
		this._lineWidths = [];
		this._strings = [];
		this._isMultiLine = !1
	};
	var b = cc.LabelTTF.RenderCmd.prototype;
	b.constructor = cc.LabelTTF.RenderCmd;
	b._getLabelContext = function() {
		if (this._labelContext) {
			return this._labelContext
		}
		var b = this._node;
		if (!this._labelCanvas) {
			var d = cc.newElement("canvas");
			d.width = 1;
			d.height = 1;
			var e = new cc.Texture2D;
			e.initWithElement(d);
			b.setTexture(e);
			this._labelCanvas = d
		}
		return this._labelContext = this._labelCanvas.getContext("2d")
	};
	b._setFontStyle = function(b, d, e, f) {
		b instanceof cc.FontDefinition ? (this._fontStyleStr = b._getCanvasFontStr(), this._fontClientHeight = cc.LabelTTF.__getFontHeightByDiv(b)) : (this._fontStyleStr = e + " " + f + " " + d + "px '" + b + "'", this._fontClientHeight = cc.LabelTTF.__getFontHeightByDiv(b, d))
	};
	b._getFontStyle = function() {
		return this._fontStyleStr
	};
	b._getFontClientHeight = function() {
		return this._fontClientHeight
	};
	b._updateTexture = function() {
		this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.textDirty;
		var b = this._node,
			d = this._getLabelContext(),
			e = this._labelCanvas,
			f = b._contentSize;
		if (0 === b._string.length) {
			return e.width = 1, e.height = f.height || 1, b._texture && b._texture.handleLoadedTexture(), b.setTextureRect(cc.rect(0, 0, 1, f.height)), !0
		}
		d.font = this._fontStyleStr;
		this._updateTTF();
		var g = f.width,
			f = f.height,
			h = e.width === g && e.height === f;
		e.width = g;
		e.height = f;
		h && d.clearRect(0, 0, g, f);
		this._drawTTFInCanvas(d);
		b._texture && b._texture.handleLoadedTexture();
		b.setTextureRect(cc.rect(0, 0, g, f));
		return !0
	};
	b._measureConfig = function() {
		this._getLabelContext().font = this._fontStyleStr
	};
	b._measure = function(b) {
		return this._getLabelContext().measureText(b).width
	};
	b._updateTTF = function() {
		var b = this._node,
			d = b._dimensions.width,
			e, f, g = this._lineWidths;
		g.length = 0;
		this._isMultiLine = !1;
		this._measureConfig();
		if (0 !== d) {
			for (this._strings = b._string.split("\n"), e = 0; e < this._strings.length; e++) {
				this._checkWarp(this._strings, e, d)
			}
		} else {
			for (this._strings = b._string.split("\n"), e = 0, f = this._strings.length; e < f; e++) {
				g.push(this._measure(this._strings[e]))
			}
		}
		0 < this._strings.length && (this._isMultiLine = !0);
		f = e = 0;
		b._strokeEnabled && (e = f = 2 * b._strokeSize);
		if (b._shadowEnabled) {
			var h = b._shadowOffset;
			e += 2 * Math.abs(h.x);
			f += 2 * Math.abs(h.y)
		}
		d = 0 === d ? this._isMultiLine ? cc.size(Math.ceil(Math.max.apply(Math, g) + e), Math.ceil(this._fontClientHeight * this._strings.length + f)) : cc.size(Math.ceil(this._measure(b._string) + e), Math.ceil(this._fontClientHeight + f)) : 0 === b._dimensions.height ? this._isMultiLine ? cc.size(Math.ceil(d + e), Math.ceil(b.getLineHeight() * this._strings.length + f)) : cc.size(Math.ceil(d + e), Math.ceil(b.getLineHeight() + f)) : cc.size(Math.ceil(d + e), Math.ceil(b._dimensions.height + f));
		"normal" !== b._getFontStyle() && (d.width = Math.ceil(d.width + 0.3 * b._fontSize));
		b.setContentSize(d);
		b._strokeShadowOffsetX = e;
		b._strokeShadowOffsetY = f;
		b = b._anchorPoint;
		this._anchorPointInPoints.x = 0.5 * e + (d.width - e) * b.x;
		this._anchorPointInPoints.y = 0.5 * f + (d.height - f) * b.y
	};
	b._drawTTFInCanvas = function(b) {
		if (b) {
			var d = this._node,
				e = d._strokeShadowOffsetX,
				f = d._strokeShadowOffsetY,
				g = d._contentSize.height - f,
				h = d._vAlignment,
				k = d._hAlignment,
				m = d._strokeSize;
			b.setTransform(1, 0, 0, 1, 0.5 * e, g + 0.5 * f);
			b.font !== this._fontStyleStr && (b.font = this._fontStyleStr);
			b.fillStyle = this._fillColorStr;
			var n = f = 0,
				p = d._strokeEnabled;
			p && (b.lineWidth = 2 * m, b.strokeStyle = this._strokeColorStr);
			d._shadowEnabled && (m = d._shadowOffset, b.shadowColor = this._shadowColorStr, b.shadowOffsetX = m.x, b.shadowOffsetY = -m.y, b.shadowBlur = d._shadowBlur);
			b.textBaseline = cc.LabelTTF._textBaseline[h];
			b.textAlign = cc.LabelTTF._textAlign[k];
			var r = d._contentSize.width - e,
				e = d.getLineHeight(),
				m = (e - this._fontClientHeight) / 2,
				f = k === cc.TEXT_ALIGNMENT_RIGHT ? f + r : k === cc.TEXT_ALIGNMENT_CENTER ? f + r / 2 : f + 0;
			if (this._isMultiLine) {
				for (d = this._strings.length, h === cc.VERTICAL_TEXT_ALIGNMENT_BOTTOM ? n = e - 2 * m + g - e * d : h === cc.VERTICAL_TEXT_ALIGNMENT_CENTER && (n = (e - 2 * m) / 2 + (g - e * d) / 2), h = 0; h < d; h++) {
					k = this._strings[h], r = -g + (e * h + m) + n, p && b.strokeText(k, f, r), b.fillText(k, f, r)
				}
			} else {
				h !== cc.VERTICAL_TEXT_ALIGNMENT_BOTTOM && (n = h === cc.VERTICAL_TEXT_ALIGNMENT_TOP ? n - g : n - 0.5 * g), p && b.strokeText(d._string, f, n), b.fillText(d._string, f, n)
			}
		}
	};
	b._checkWarp = function(b, d, e) {
		var f = b[d],
			g = this._measure(f);
		if (g > e && 1 < f.length) {
			for (var h = e / g * f.length | 0, k = f.substr(h), m = g - this._measure(k), n, p = 0, r = 0; m > e && 100 > r++;) {
				h *= e / m, h |= 0, k = f.substr(h), m = g - this._measure(k)
			}
			for (r = 0; m < e && 100 > r++;) {
				k && (p = (n = cc.LabelTTF._wordRex.exec(k)) ? n[0].length : 1, n = k), h += p, k = f.substr(h), m = g - this._measure(k)
			}
			h -= p;
			0 === h && (h = 1, n = n.substr(1));
			e = f.substr(0, h);
			cc.LabelTTF.wrapInspection && cc.LabelTTF._symbolRex.test(n || k) && (g = cc.LabelTTF._lastWordRex.exec(e), h -= g ? g[0].length : 0, n = f.substr(h), e = f.substr(0, h));
			cc.LabelTTF._firsrEnglish.test(n) && (g = cc.LabelTTF._lastEnglish.exec(e)) && e !== g[0] && (h -= g[0].length, n = f.substr(h), e = f.substr(0, h));
			b[d] = n || k;
			b.splice(d, 0, e)
		}
	}
})();
(function() {
	cc.LabelTTF.CanvasRenderCmd = function(b) {
		cc.Sprite.CanvasRenderCmd.call(this, b);
		cc.LabelTTF.RenderCmd.call(this)
	};
	cc.LabelTTF.CanvasRenderCmd.prototype = Object.create(cc.Sprite.CanvasRenderCmd.prototype);
	cc.inject(cc.LabelTTF.RenderCmd.prototype, cc.LabelTTF.CanvasRenderCmd.prototype);
	var b = cc.LabelTTF.CanvasRenderCmd.prototype;
	b.constructor = cc.LabelTTF.CanvasRenderCmd;
	b.updateStatus = function() {
		var b = cc.Node._dirtyFlags,
			d = this._dirtyFlag,
			e = d & b.colorDirty,
			f = d & b.opacityDirty;
		e && this._updateDisplayColor();
		f && this._updateDisplayOpacity();
		e ? this._updateColor() : d & b.textDirty && this._updateTexture();
		this._dirtyFlag & b.transformDirty && (this.transform(this.getParentRenderCmd(), !0), this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.transformDirty)
	};
	b._syncStatus = function(b) {
		var d = cc.Node._dirtyFlags,
			e = this._dirtyFlag,
			f = b ? b._node : null;
		f && f._cascadeColorEnabled && b._dirtyFlag & d.colorDirty && (e |= d.colorDirty);
		f && f._cascadeOpacityEnabled && b._dirtyFlag & d.opacityDirty && (e |= d.opacityDirty);
		b && b._dirtyFlag & d.transformDirty && (e |= d.transformDirty);
		var f = e & d.colorDirty,
			g = e & d.opacityDirty;
		this._dirtyFlag = e;
		f && this._syncDisplayColor();
		g && this._syncDisplayOpacity();
		f ? this._updateColor() : e & d.textDirty && this._updateTexture();
		e & d.transformDirty && this.transform(b)
	};
	b._setColorsString = function() {
		var b = this._displayedColor,
			d = this._node,
			e = d._shadowColor || this._displayedColor,
			f = d._strokeColor,
			g = d._textFillColor,
			h = b.r / 255,
			k = b.g / 255,
			b = b.b / 255;
		this._shadowColorStr = "rgba(" + (0 | h * e.r) + "," + (0 | k * e.g) + "," + (0 | b * e.b) + "," + d._shadowOpacity + ")";
		this._fillColorStr = "rgba(" + (0 | h * g.r) + "," + (0 | k * g.g) + "," + (0 | b * g.b) + ", 1)";
		this._strokeColorStr = "rgba(" + (0 | h * f.r) + "," + (0 | k * f.g) + "," + (0 | b * f.b) + ", 1)"
	};
	b._updateColor = function() {
		this._setColorsString();
		this._updateTexture()
	}
})();
(function() {
	cc.LabelTTF.WebGLRenderCmd = function(b) {
		cc.Sprite.WebGLRenderCmd.call(this, b);
		cc.LabelTTF.RenderCmd.call(this);
		this.setShaderProgram(cc.shaderCache.programForKey(cc.LabelTTF._SHADER_PROGRAM))
	};
	var b = cc.LabelTTF.WebGLRenderCmd.prototype = Object.create(cc.Sprite.WebGLRenderCmd.prototype);
	cc.inject(cc.LabelTTF.RenderCmd.prototype, b);
	b.constructor = cc.LabelTTF.WebGLRenderCmd;
	b._setColorsString = function() {
		this.setDirtyFlag(cc.Node._dirtyFlags.textDirty);
		var b = this._node,
			d = b._strokeColor,
			e = b._textFillColor,
			f = b._shadowColor || this._displayedColor;
		this._shadowColorStr = "rgba(" + (0 | f.r) + "," + (0 | f.g) + "," + (0 | f.b) + "," + b._shadowOpacity + ")";
		this._fillColorStr = "rgba(" + (0 | e.r) + "," + (0 | e.g) + "," + (0 | e.b) + ", 1)";
		this._strokeColorStr = "rgba(" + (0 | d.r) + "," + (0 | d.g) + "," + (0 | d.b) + ", 1)"
	};
	b.updateStatus = function() {
		var b = cc.Node._dirtyFlags,
			d = this._dirtyFlag,
			e = d & b.colorDirty,
			f = d & b.opacityDirty;
		e && this._updateDisplayColor();
		f && this._updateDisplayOpacity();
		e || f ? (this._setColorsString(), this._updateColor(), this._updateTexture()) : d & b.textDirty && this._updateTexture();
		this._dirtyFlag & b.transformDirty && (this.transform(this.getParentRenderCmd(), !0), this._dirtyFlag ^= this._dirtyFlag & cc.Node._dirtyFlags.transformDirty)
	};
	b._syncStatus = function(b) {
		var d = cc.Node._dirtyFlags,
			e = this._dirtyFlag,
			f = b ? b._node : null;
		f && f._cascadeColorEnabled && b._dirtyFlag & d.colorDirty && (e |= d.colorDirty);
		f && f._cascadeOpacityEnabled && b._dirtyFlag & d.opacityDirty && (e |= d.opacityDirty);
		b && b._dirtyFlag & d.transformDirty && (e |= d.transformDirty);
		var f = e & d.colorDirty,
			g = e & d.opacityDirty;
		this._dirtyFlag = e;
		f && this._syncDisplayColor();
		g && this._syncDisplayOpacity();
		f || g ? (this._setColorsString(), this._updateColor(), this._updateTexture()) : e & d.textDirty && this._updateTexture();
		this.transform(b)
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
	ctor: function() {
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
	_searchElementByTarget: function(b, c) {
		for (var d = 0; d < b.length; d++) {
			if (c === b[d].target) {
				return b[d]
			}
		}
		return null
	},
	ctor: function() {
		this._hashTargets = {};
		this._arrayTargets = [];
		this._currentTarget = null;
		this._currentTargetSalvaged = !1
	},
	addAction: function(b, c, d) {
		if (!b) {
			throw "cc.ActionManager.addAction(): action must be non-null"
		}
		if (!c) {
			throw "cc.ActionManager.addAction(): action must be non-null"
		}
		var e = this._hashTargets[c.__instanceId];
		e || (e = new cc.HashElement, e.paused = d, e.target = c, this._hashTargets[c.__instanceId] = e, this._arrayTargets.push(e));
		this._actionAllocWithHashElement(e);
		e.actions.push(b);
		b.startWithTarget(c)
	},
	removeAllActions: function() {
		for (var b = this._arrayTargets, c = 0; c < b.length; c++) {
			var d = b[c];
			d && this.removeAllActionsFromTarget(d.target, !0)
		}
	},
	removeAllActionsFromTarget: function(b, c) {
		if (null != b) {
			var d = this._hashTargets[b.__instanceId];
			d && (-1 === d.actions.indexOf(d.currentAction) || d.currentActionSalvaged || (d.currentActionSalvaged = !0), d.actions.length = 0, this._currentTarget !== d || c ? this._deleteHashElement(d) : this._currentTargetSalvaged = !0)
		}
	},
	removeAction: function(b) {
		if (null != b) {
			var c = b.getOriginalTarget();
			if (c = this._hashTargets[c.__instanceId]) {
				for (var d = 0; d < c.actions.length; d++) {
					if (c.actions[d] === b) {
						c.actions.splice(d, 1);
						break
					}
				}
			} else {
				cc.log(cc._LogInfos.ActionManager_removeAction)
			}
		}
	},
	removeActionByTag: function(b, c) {
		b === cc.ACTION_TAG_INVALID && cc.log(cc._LogInfos.ActionManager_addAction);
		cc.assert(c, cc._LogInfos.ActionManager_addAction);
		var d = this._hashTargets[c.__instanceId];
		if (d) {
			for (var e = d.actions.length, f = 0; f < e; ++f) {
				var g = d.actions[f];
				if (g && g.getTag() === b && g.getOriginalTarget() === c) {
					this._removeActionAtIndex(f, d);
					break
				}
			}
		}
	},
	getActionByTag: function(b, c) {
		b === cc.ACTION_TAG_INVALID && cc.log(cc._LogInfos.ActionManager_getActionByTag);
		var d = this._hashTargets[c.__instanceId];
		if (d) {
			if (null != d.actions) {
				for (var e = 0; e < d.actions.length; ++e) {
					var f = d.actions[e];
					if (f && f.getTag() === b) {
						return f
					}
				}
			}
			cc.log(cc._LogInfos.ActionManager_getActionByTag_2, b)
		}
		return null
	},
	numberOfRunningActionsInTarget: function(b) {
		return (b = this._hashTargets[b.__instanceId]) ? b.actions ? b.actions.length : 0 : 0
	},
	pauseTarget: function(b) {
		if (b = this._hashTargets[b.__instanceId]) {
			b.paused = !0
		}
	},
	resumeTarget: function(b) {
		if (b = this._hashTargets[b.__instanceId]) {
			b.paused = !1
		}
	},
	pauseAllRunningActions: function() {
		for (var b = [], c = this._arrayTargets, d = 0; d < c.length; d++) {
			var e = c[d];
			e && !e.paused && (e.paused = !0, b.push(e.target))
		}
		return b
	},
	resumeTargets: function(b) {
		if (b) {
			for (var c = 0; c < b.length; c++) {
				b[c] && this.resumeTarget(b[c])
			}
		}
	},
	purgeSharedManager: function() {
		cc.director.getScheduler().unscheduleUpdate(this)
	},
	_removeActionAtIndex: function(b, c) {
		c.actions[b] !== c.currentAction || c.currentActionSalvaged || (c.currentActionSalvaged = !0);
		c.actions.splice(b, 1);
		c.actionIndex >= b && c.actionIndex--;
		0 === c.actions.length && (this._currentTarget === c ? this._currentTargetSalvaged = !0 : this._deleteHashElement(c))
	},
	_deleteHashElement: function(b) {
		b && (delete this._hashTargets[b.target.__instanceId], cc.arrayRemoveObject(this._arrayTargets, b), b.actions = null, b.target = null)
	},
	_actionAllocWithHashElement: function(b) {
		null == b.actions && (b.actions = [])
	},
	update: function(b) {
		for (var c = this._arrayTargets, d, e = 0; e < c.length; e++) {
			d = this._currentTarget = c[e];
			if (!d.paused) {
				for (d.actionIndex = 0; d.actionIndex < (d.actions ? d.actions.length : 0); d.actionIndex++) {
					if (d.currentAction = d.actions[d.actionIndex], d.currentAction) {
						d.currentActionSalvaged = !1;
						d.currentAction.step(b * (d.currentAction._speedMethod ? d.currentAction._speed : 1));
						if (d.currentActionSalvaged) {
							d.currentAction = null
						} else {
							if (d.currentAction.isDone()) {
								d.currentAction.stop();
								var f = d.currentAction;
								d.currentAction = null;
								this.removeAction(f)
							}
						}
						d.currentAction = null
					}
				}
			}
			this._currentTargetSalvaged && 0 === d.actions.length && this._deleteHashElement(d)
		}
	}
});
cc.math = cc.math || {};
cc.math.EPSILON = 0.015625;
cc.math.square = function(b) {
	return b * b
};
cc.math.almostEqual = function(b, c) {
	return b + cc.math.EPSILON > c && b - cc.math.EPSILON < c
};
(function(b) {
	b.math.Vec2 = function(b, c) {
		void 0 === c ? (this.x = b.x, this.y = b.y) : (this.x = b || 0, this.y = c || 0)
	};
	var c = b.math.Vec2.prototype;
	c.fill = function(b, c) {
		this.x = b;
		this.y = c
	};
	c.length = function() {
		return Math.sqrt(b.math.square(this.x) + b.math.square(this.y))
	};
	c.lengthSq = function() {
		return b.math.square(this.x) + b.math.square(this.y)
	};
	c.normalize = function() {
		var b = 1 / this.length();
		this.x *= b;
		this.y *= b;
		return this
	};
	b.math.Vec2.add = function(b, c, f) {
		b.x = c.x + f.x;
		b.y = c.y + f.y;
		return b
	};
	c.add = function(b) {
		this.x += b.x;
		this.y += b.y;
		return this
	};
	c.dot = function(b) {
		return this.x * b.x + this.y * b.y
	};
	b.math.Vec2.subtract = function(b, c, f) {
		b.x = c.x - f.x;
		b.y = c.y - f.y;
		return b
	};
	c.subtract = function(b) {
		this.x -= b.x;
		this.y -= b.y;
		return this
	};
	c.transform = function(b) {
		var c = this.x,
			f = this.y;
		this.x = c * b.mat[0] + f * b.mat[3] + b.mat[6];
		this.y = c * b.mat[1] + f * b.mat[4] + b.mat[7];
		return this
	};
	b.math.Vec2.scale = function(b, c, f) {
		b.x = c.x * f;
		b.y = c.y * f;
		return b
	};
	c.scale = function(b) {
		this.x *= b;
		this.y *= b;
		return this
	};
	c.equals = function(d) {
		return this.x < d.x + b.math.EPSILON && this.x > d.x - b.math.EPSILON && this.y < d.y + b.math.EPSILON && this.y > d.y - b.math.EPSILON
	}
})(cc);
(function(b) {
	b.kmVec3 = b.math.Vec3 = function(b, c, f) {
		b && void 0 === c ? (this.x = b.x, this.y = b.y, this.z = b.z) : (this.x = b || 0, this.y = c || 0, this.z = f || 0)
	};
	b.math.vec3 = function(d, c, f) {
		return new b.math.Vec3(d, c, f)
	};
	var c = b.math.Vec3.prototype;
	c.fill = function(b, c, f) {
		b && void 0 === c ? (this.x = b.x, this.y = b.y, this.z = b.z) : (this.x = b, this.y = c, this.z = f);
		return this
	};
	c.length = function() {
		return Math.sqrt(b.math.square(this.x) + b.math.square(this.y) + b.math.square(this.z))
	};
	c.lengthSq = function() {
		return b.math.square(this.x) + b.math.square(this.y) + b.math.square(this.z)
	};
	c.normalize = function() {
		var b = 1 / this.length();
		this.x *= b;
		this.y *= b;
		this.z *= b;
		return this
	};
	c.cross = function(b) {
		var c = this.x,
			f = this.y,
			g = this.z;
		this.x = f * b.z - g * b.y;
		this.y = g * b.x - c * b.z;
		this.z = c * b.y - f * b.x;
		return this
	};
	c.dot = function(b) {
		return this.x * b.x + this.y * b.y + this.z * b.z
	};
	c.add = function(b) {
		this.x += b.x;
		this.y += b.y;
		this.z += b.z;
		return this
	};
	c.subtract = function(b) {
		this.x -= b.x;
		this.y -= b.y;
		this.z -= b.z;
		return this
	};
	c.transform = function(b) {
		var c = this.x,
			f = this.y,
			g = this.z;
		b = b.mat;
		this.x = c * b[0] + f * b[4] + g * b[8] + b[12];
		this.y = c * b[1] + f * b[5] + g * b[9] + b[13];
		this.z = c * b[2] + f * b[6] + g * b[10] + b[14];
		return this
	};
	c.transformNormal = function(b) {
		var c = this.x,
			f = this.y,
			g = this.z;
		b = b.mat;
		this.x = c * b[0] + f * b[4] + g * b[8];
		this.y = c * b[1] + f * b[5] + g * b[9];
		this.z = c * b[2] + f * b[6] + g * b[10];
		return this
	};
	c.transformCoord = function(c) {
		var e = new b.math.Vec4(this.x, this.y, this.z, 1);
		e.transform(c);
		this.x = e.x / e.w;
		this.y = e.y / e.w;
		this.z = e.z / e.w;
		return this
	};
	c.scale = function(b) {
		this.x *= b;
		this.y *= b;
		this.z *= b;
		return this
	};
	c.equals = function(c) {
		var e = b.math.EPSILON;
		return this.x < c.x + e && this.x > c.x - e && this.y < c.y + e && this.y > c.y - e && this.z < c.z + e && this.z > c.z - e
	};
	c.inverseTransform = function(c) {
		c = c.mat;
		var e = new b.math.Vec3(this.x - c[12], this.y - c[13], this.z - c[14]);
		this.x = e.x * c[0] + e.y * c[1] + e.z * c[2];
		this.y = e.x * c[4] + e.y * c[5] + e.z * c[6];
		this.z = e.x * c[8] + e.y * c[9] + e.z * c[10];
		return this
	};
	c.inverseTransformNormal = function(b) {
		var c = this.x,
			f = this.y,
			g = this.z;
		b = b.mat;
		this.x = c * b[0] + f * b[1] + g * b[2];
		this.y = c * b[4] + f * b[5] + g * b[6];
		this.z = c * b[8] + f * b[9] + g * b[10];
		return this
	};
	c.assignFrom = function(b) {
		if (!b) {
			return this
		}
		this.x = b.x;
		this.y = b.y;
		this.z = b.z;
		return this
	};
	b.math.Vec3.zero = function(b) {
		b.x = b.y = b.z = 0;
		return b
	};
	c.toTypeArray = function() {
		var b = new Float32Array(3);
		b[0] = this.x;
		b[1] = this.y;
		b[2] = this.z;
		return b
	}
})(cc);
(function(b) {
	b.math.Vec4 = function(b, c, f, g) {
		b && void 0 === c ? (this.x = b.x, this.y = b.y, this.z = b.z, this.w = b.w) : (this.x = b || 0, this.y = c || 0, this.z = f || 0, this.w = g || 0)
	};
	b.kmVec4 = b.math.Vec4;
	var c = b.math.Vec4.prototype;
	c.fill = function(b, c, f, g) {
		b && void 0 === c ? (this.x = b.x, this.y = b.y, this.z = b.z, this.w = b.w) : (this.x = b, this.y = c, this.z = f, this.w = g)
	};
	c.add = function(b) {
		if (!b) {
			return this
		}
		this.x += b.x;
		this.y += b.y;
		this.z += b.z;
		this.w += b.w;
		return this
	};
	c.dot = function(b) {
		return this.x * b.x + this.y * b.y + this.z * b.z + this.w * b.w
	};
	c.length = function() {
		return Math.sqrt(b.math.square(this.x) + b.math.square(this.y) + b.math.square(this.z) + b.math.square(this.w))
	};
	c.lengthSq = function() {
		return b.math.square(this.x) + b.math.square(this.y) + b.math.square(this.z) + b.math.square(this.w)
	};
	c.lerp = function(b, c) {
		return this
	};
	c.normalize = function() {
		var b = 1 / this.length();
		this.x *= b;
		this.y *= b;
		this.z *= b;
		this.w *= b;
		return this
	};
	c.scale = function(b) {
		this.normalize();
		this.x *= b;
		this.y *= b;
		this.z *= b;
		this.w *= b;
		return this
	};
	c.subtract = function(b) {
		this.x -= b.x;
		this.y -= b.y;
		this.z -= b.z;
		this.w -= b.w
	};
	c.transform = function(b) {
		var c = this.x,
			f = this.y,
			g = this.z,
			h = this.w;
		b = b.mat;
		this.x = c * b[0] + f * b[4] + g * b[8] + h * b[12];
		this.y = c * b[1] + f * b[5] + g * b[9] + h * b[13];
		this.z = c * b[2] + f * b[6] + g * b[10] + h * b[14];
		this.w = c * b[3] + f * b[7] + g * b[11] + h * b[15];
		return this
	};
	b.math.Vec4.transformArray = function(c, e) {
		for (var f = [], g = 0; g < c.length; g++) {
			var h = new b.math.Vec4(c[g]);
			h.transform(e);
			f.push(h)
		}
		return f
	};
	c.equals = function(c) {
		var e = b.math.EPSILON;
		return this.x < c.x + e && this.x > c.x - e && this.y < c.y + e && this.y > c.y - e && this.z < c.z + e && this.z > c.z - e && this.w < c.w + e && this.w > c.w - e
	};
	c.assignFrom = function(b) {
		this.x = b.x;
		this.y = b.y;
		this.z = b.z;
		this.w = b.w;
		return this
	};
	c.toTypeArray = function() {
		var b = new Float32Array(4);
		b[0] = this.x;
		b[1] = this.y;
		b[2] = this.z;
		b[3] = this.w;
		return b
	}
})(cc);
(function(b) {
	function c(c, e, f) {
		e = new b.math.Vec2(e);
		e.subtract(c);
		f.x = -e.y;
		f.y = e.x;
		f.normalize()
	}
	b.math.Ray2 = function(c, e) {
		this.start = c || new b.math.Vec2;
		this.dir = e || new b.math.Vec2
	};
	b.math.Ray2.prototype.fill = function(b, c, f, g) {
		this.start.x = b;
		this.start.y = c;
		this.dir.x = f;
		this.dir.y = g
	};
	b.math.Ray2.prototype.intersectLineSegment = function(c, e, f) {
		var g = this.start.x,
			h = this.start.y,
			k = this.start.x + this.dir.x,
			m = this.start.y + this.dir.y,
			n = c.x,
			p = c.y,
			r = e.x,
			t = e.y,
			s = (t - p) * (k - g) - (r - n) * (m - h);
		if (s > -b.math.EPSILON && s < b.math.EPSILON) {
			return !1
		}
		p = ((r - n) * (h - p) - (t - p) * (g - n)) / s;
		n = g + p * (k - g);
		p = h + p * (m - h);
		if (n < Math.min(c.x, e.x) - b.math.EPSILON || n > Math.max(c.x, e.x) + b.math.EPSILON || p < Math.min(c.y, e.y) - b.math.EPSILON || p > Math.max(c.y, e.y) + b.math.EPSILON || n < Math.min(g, k) - b.math.EPSILON || n > Math.max(g, k) + b.math.EPSILON || p < Math.min(h, m) - b.math.EPSILON || p > Math.max(h, m) + b.math.EPSILON) {
			return !1
		}
		f.x = n;
		f.y = p;
		return !0
	};
	b.math.Ray2.prototype.intersectTriangle = function(d, e, f, g, h) {
		var k = new b.math.Vec2,
			m = new b.math.Vec2,
			n = new b.math.Vec2,
			p = 10000,
			r = !1,
			t;
		this.intersectLineSegment(d, e, k) && (r = !0, t = k.subtract(this.start).length(), t < p && (m.x = k.x, m.y = k.y, p = t, c(d, e, n)));
		this.intersectLineSegment(e, f, k) && (r = !0, t = k.subtract(this.start).length(), t < p && (m.x = k.x, m.y = k.y, p = t, c(e, f, n)));
		this.intersectLineSegment(f, d, k) && (r = !0, t = k.subtract(this.start).length(), t < p && (m.x = k.x, m.y = k.y, c(f, d, n)));
		r && (g.x = m.x, g.y = m.y, h && (h.x = n.x, h.y = n.y));
		return r
	}
})(cc);
var Float32Array = Float32Array || Array;
(function(b) {
	b.math.Matrix3 = function(b) {
		this.mat = b && b.mat ? new Float32Array(b.mat) : new Float32Array(9)
	};
	b.kmMat3 = b.math.Matrix3;
	var c = b.math.Matrix3.prototype;
	c.fill = function(b) {
		var c = this.mat;
		b = b.mat;
		c[0] = b[0];
		c[1] = b[1];
		c[2] = b[2];
		c[3] = b[3];
		c[4] = b[4];
		c[5] = b[5];
		c[6] = b[6];
		c[7] = b[7];
		c[8] = b[8];
		return this
	};
	c.adjugate = function() {
		var b = this.mat,
			c = b[0],
			d = b[1],
			h = b[2],
			k = b[3],
			m = b[4],
			n = b[5],
			p = b[6],
			r = b[7],
			t = b[8];
		b[0] = m * t - n * r;
		b[1] = h * r - d * t;
		b[2] = d * n - h * m;
		b[3] = n * p - k * t;
		b[4] = c * t - h * p;
		b[5] = h * k - c * n;
		b[6] = k * r - m * p;
		b[8] = c * m - d * k;
		return this
	};
	c.identity = function() {
		var b = this.mat;
		b[1] = b[2] = b[3] = b[5] = b[6] = b[7] = 0;
		b[0] = b[4] = b[8] = 1;
		return this
	};
	var d = new b.math.Matrix3;
	c.inverse = function(b) {
		if (0 === b) {
			return this
		}
		d.assignFrom(this);
		b = 1 / b;
		this.adjugate();
		this.multiplyScalar(b);
		return this
	};
	c.isIdentity = function() {
		var b = this.mat;
		return 1 === b[0] && 0 === b[1] && 0 === b[2] && 0 === b[3] && 1 === b[4] && 0 === b[5] && 0 === b[6] && 0 === b[7] && 1 === b[8]
	};
	c.transpose = function() {
		var b = this.mat,
			c = b[1],
			d = b[2],
			h = b[5],
			k = b[6],
			m = b[7];
		b[1] = b[3];
		b[2] = k;
		b[3] = c;
		b[5] = m;
		b[6] = d;
		b[7] = h;
		return this
	};
	c.determinant = function() {
		var b = this.mat,
			c = b[0] * b[4] * b[8] + b[1] * b[5] * b[6] + b[2] * b[3] * b[7];
		return c -= b[2] * b[4] * b[6] + b[0] * b[5] * b[7] + b[1] * b[3] * b[8]
	};
	c.multiply = function(b) {
		var c = this.mat,
			d = b.mat;
		b = c[0];
		var h = c[1],
			k = c[2],
			m = c[3],
			n = c[4],
			p = c[5],
			r = c[6],
			t = c[7],
			s = c[8],
			v = d[0],
			u = d[1],
			A = d[2],
			y = d[3],
			E = d[4],
			F = d[5],
			B = d[6],
			x = d[7],
			d = d[8];
		c[0] = b * v + m * u + r * A;
		c[1] = h * v + n * u + t * A;
		c[2] = k * v + p * u + s * A;
		c[3] = k * v + p * u + s * A;
		c[4] = h * y + n * E + t * F;
		c[5] = k * y + p * E + s * F;
		c[6] = b * B + m * x + r * d;
		c[7] = h * B + n * x + t * d;
		c[8] = k * B + p * x + s * d;
		return this
	};
	c.multiplyScalar = function(b) {
		var c = this.mat;
		c[0] *= b;
		c[1] *= b;
		c[2] *= b;
		c[3] *= b;
		c[4] *= b;
		c[5] *= b;
		c[6] *= b;
		c[7] *= b;
		c[8] *= b;
		return this
	};
	b.math.Matrix3.rotationAxisAngle = function(c, d) {
		var g = Math.cos(d),
			h = Math.sin(d),
			k = new b.math.Matrix3,
			m = k.mat;
		m[0] = g + c.x * c.x * (1 - g);
		m[1] = c.z * h + c.y * c.x * (1 - g);
		m[2] = -c.y * h + c.z * c.x * (1 - g);
		m[3] = -c.z * h + c.x * c.y * (1 - g);
		m[4] = g + c.y * c.y * (1 - g);
		m[5] = c.x * h + c.z * c.y * (1 - g);
		m[6] = c.y * h + c.x * c.z * (1 - g);
		m[7] = -c.x * h + c.y * c.z * (1 - g);
		m[8] = g + c.z * c.z * (1 - g);
		return k
	};
	c.assignFrom = function(c) {
		if (this === c) {
			return b.log("cc.math.Matrix3.assign(): current matrix equals matIn"), this
		}
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
	c.equals = function(c) {
		if (this === c) {
			return !0
		}
		var d = b.math.EPSILON,
			g = this.mat;
		c = c.mat;
		for (var h = 0; 9 > h; ++h) {
			if (!(g[h] + d > c[h] && g[h] - d < c[h])) {
				return !1
			}
		}
		return !0
	};
	b.math.Matrix3.createByRotationX = function(c) {
		var d = new b.math.Matrix3,
			g = d.mat;
		g[0] = 1;
		g[1] = 0;
		g[2] = 0;
		g[3] = 0;
		g[4] = Math.cos(c);
		g[5] = Math.sin(c);
		g[6] = 0;
		g[7] = -Math.sin(c);
		g[8] = Math.cos(c);
		return d
	};
	b.math.Matrix3.createByRotationY = function(c) {
		var d = new b.math.Matrix3,
			g = d.mat;
		g[0] = Math.cos(c);
		g[1] = 0;
		g[2] = -Math.sin(c);
		g[3] = 0;
		g[4] = 1;
		g[5] = 0;
		g[6] = Math.sin(c);
		g[7] = 0;
		g[8] = Math.cos(c);
		return d
	};
	b.math.Matrix3.createByRotationZ = function(c) {
		var d = new b.math.Matrix3,
			g = d.mat;
		g[0] = Math.cos(c);
		g[1] = -Math.sin(c);
		g[2] = 0;
		g[3] = Math.sin(c);
		g[4] = Math.cos(c);
		g[5] = 0;
		g[6] = 0;
		g[7] = 0;
		g[8] = 1;
		return d
	};
	b.math.Matrix3.createByRotation = function(c) {
		var d = new b.math.Matrix3,
			g = d.mat;
		g[0] = Math.cos(c);
		g[1] = Math.sin(c);
		g[2] = 0;
		g[3] = -Math.sin(c);
		g[4] = Math.cos(c);
		g[5] = 0;
		g[6] = 0;
		g[7] = 0;
		g[8] = 1;
		return d
	};
	b.math.Matrix3.createByScale = function(c, d) {
		var g = new b.math.Matrix3;
		g.identity();
		g.mat[0] = c;
		g.mat[4] = d;
		return g
	};
	b.math.Matrix3.createByTranslation = function(c, d) {
		var g = new b.math.Matrix3;
		g.identity();
		g.mat[6] = c;
		g.mat[7] = d;
		return g
	};
	b.math.Matrix3.createByQuaternion = function(c) {
		if (!c) {
			return null
		}
		var d = new b.math.Matrix3,
			g = d.mat;
		g[0] = 1 - 2 * (c.y * c.y + c.z * c.z);
		g[1] = 2 * (c.x * c.y - c.w * c.z);
		g[2] = 2 * (c.x * c.z + c.w * c.y);
		g[3] = 2 * (c.x * c.y + c.w * c.z);
		g[4] = 1 - 2 * (c.x * c.x + c.z * c.z);
		g[5] = 2 * (c.y * c.z - c.w * c.x);
		g[6] = 2 * (c.x * c.z - c.w * c.y);
		g[7] = 2 * (c.y * c.z + c.w * c.x);
		g[8] = 1 - 2 * (c.x * c.x + c.y * c.y);
		return d
	};
	c.rotationToAxisAngle = function() {
		return b.math.Quaternion.rotationMatrix(this).toAxisAndAngle()
	}
})(cc);
(function(b) {
	b.math.Matrix4 = function(b) {
		this.mat = b && b.mat ? new Float32Array(b.mat) : new Float32Array(16)
	};
	b.kmMat4 = b.math.Matrix4;
	var c = b.math.Matrix4.prototype;
	c.fill = function(b) {
		for (var c = this.mat, d = 0; 16 > d; d++) {
			c[d] = b[d]
		}
		return this
	};
	b.kmMat4Identity = function(b) {
		var c = b.mat;
		c[1] = c[2] = c[3] = c[4] = c[6] = c[7] = c[8] = c[9] = c[11] = c[12] = c[13] = c[14] = 0;
		c[0] = c[5] = c[10] = c[15] = 1;
		return b
	};
	c.identity = function() {
		var b = this.mat;
		b[1] = b[2] = b[3] = b[4] = b[6] = b[7] = b[8] = b[9] = b[11] = b[12] = b[13] = b[14] = 0;
		b[0] = b[5] = b[10] = b[15] = 1;
		return this
	};
	c.get = function(b, c) {
		return this.mat[b + 4 * c]
	};
	c.set = function(b, c, d) {
		this.mat[b + 4 * c] = d
	};
	c.swap = function(b, c, d, e) {
		var m = this.mat,
			n = m[b + 4 * c];
		m[b + 4 * c] = m[d + 4 * e];
		m[d + 4 * e] = n
	};
	b.math.Matrix4._gaussj = function(b, c) {
		var d, e = 0,
			m = 0,
			n, p, r, t, s = [0, 0, 0, 0],
			v = [0, 0, 0, 0],
			u = [0, 0, 0, 0];
		for (d = 0; 4 > d; d++) {
			for (n = t = 0; 4 > n; n++) {
				if (1 !== u[n]) {
					for (p = 0; 4 > p; p++) {
						0 === u[p] && (r = Math.abs(b.get(n, p)), r >= t && (t = r, m = n, e = p))
					}
				}
			}++u[e];
			if (m !== e) {
				for (n = 0; 4 > n; n++) {
					b.swap(m, n, e, n)
				}
				for (n = 0; 4 > n; n++) {
					c.swap(m, n, e, n)
				}
			}
			v[d] = m;
			s[d] = e;
			if (0 === b.get(e, e)) {
				return !1
			}
			p = 1 / b.get(e, e);
			b.set(e, e, 1);
			for (n = 0; 4 > n; n++) {
				b.set(e, n, b.get(e, n) * p)
			}
			for (n = 0; 4 > n; n++) {
				c.set(e, n, c.get(e, n) * p)
			}
			for (p = 0; 4 > p; p++) {
				if (p !== e) {
					r = b.get(p, e);
					b.set(p, e, 0);
					for (n = 0; 4 > n; n++) {
						b.set(p, n, b.get(p, n) - b.get(e, n) * r)
					}
					for (n = 0; 4 > n; n++) {
						c.set(p, n, b.get(p, n) - c.get(e, n) * r)
					}
				}
			}
		}
		for (n = 3; 0 <= n; n--) {
			if (v[n] !== s[n]) {
				for (p = 0; 4 > p; p++) {
					b.swap(p, v[n], p, s[n])
				}
			}
		}
		return !0
	};
	var d = (new b.math.Matrix4).identity();
	b.kmMat4Inverse = function(c, e) {
		var h = new b.math.Matrix4(e);
		if (!1 === b.math.Matrix4._gaussj(h, d)) {
			return null
		}
		c.assignFrom(h);
		return c
	};
	c.inverse = function() {
		var c = new b.math.Matrix4(this);
		return !1 === b.math.Matrix4._gaussj(c, d) ? null : c
	};
	c.isIdentity = function() {
		var b = this.mat;
		return 1 === b[0] && 0 === b[1] && 0 === b[2] && 0 === b[3] && 0 === b[4] && 1 === b[5] && 0 === b[6] && 0 === b[7] && 0 === b[8] && 0 === b[9] && 1 === b[10] && 0 === b[11] && 0 === b[12] && 0 === b[13] && 0 === b[14] && 1 === b[15]
	};
	c.transpose = function() {
		var b = this.mat,
			c = b[1],
			d = b[2],
			e = b[3],
			m = b[6],
			n = b[7],
			p = b[8],
			r = b[9],
			t = b[11],
			s = b[12],
			v = b[13],
			u = b[14];
		b[1] = b[4];
		b[2] = p;
		b[3] = s;
		b[4] = c;
		b[6] = r;
		b[7] = v;
		b[8] = d;
		b[9] = m;
		b[11] = u;
		b[12] = e;
		b[13] = n;
		b[14] = t;
		return this
	};
	b.kmMat4Multiply = function(b, c, d) {
		var e = b.mat,
			m = c.mat,
			n = d.mat;
		d = m[0];
		c = m[1];
		var p = m[2],
			r = m[3],
			t = m[4],
			s = m[5],
			v = m[6],
			u = m[7],
			A = m[8],
			y = m[9],
			E = m[10],
			F = m[11],
			B = m[12],
			x = m[13],
			C = m[14],
			m = m[15],
			w = n[0],
			z = n[1],
			G = n[2],
			H = n[3],
			I = n[4],
			K = n[5],
			M = n[6],
			L = n[7],
			O = n[8],
			J = n[9],
			P = n[10],
			N = n[11],
			Q = n[12],
			R = n[13],
			S = n[14],
			n = n[15];
		e[0] = w * d + z * t + G * A + H * B;
		e[1] = w * c + z * s + G * y + H * x;
		e[2] = w * p + z * v + G * E + H * C;
		e[3] = w * r + z * u + G * F + H * m;
		e[4] = I * d + K * t + M * A + L * B;
		e[5] = I * c + K * s + M * y + L * x;
		e[6] = I * p + K * v + M * E + L * C;
		e[7] = I * r + K * u + M * F + L * m;
		e[8] = O * d + J * t + P * A + N * B;
		e[9] = O * c + J * s + P * y + N * x;
		e[10] = O * p + J * v + P * E + N * C;
		e[11] = O * r + J * u + P * F + N * m;
		e[12] = Q * d + R * t + S * A + n * B;
		e[13] = Q * c + R * s + S * y + n * x;
		e[14] = Q * p + R * v + S * E + n * C;
		e[15] = Q * r + R * u + S * F + n * m;
		return b
	};
	c.multiply = function(b) {
		var c = this.mat,
			d = b.mat;
		b = c[0];
		var e = c[1],
			m = c[2],
			n = c[3],
			p = c[4],
			r = c[5],
			t = c[6],
			s = c[7],
			v = c[8],
			u = c[9],
			A = c[10],
			y = c[11],
			E = c[12],
			F = c[13],
			B = c[14],
			x = c[15],
			C = d[0],
			w = d[1],
			z = d[2],
			G = d[3],
			H = d[4],
			I = d[5],
			K = d[6],
			M = d[7],
			L = d[8],
			O = d[9],
			J = d[10],
			P = d[11],
			N = d[12],
			Q = d[13],
			R = d[14],
			d = d[15];
		c[0] = C * b + w * p + z * v + G * E;
		c[1] = C * e + w * r + z * u + G * F;
		c[2] = C * m + w * t + z * A + G * B;
		c[3] = C * n + w * s + z * y + G * x;
		c[4] = H * b + I * p + K * v + M * E;
		c[5] = H * e + I * r + K * u + M * F;
		c[6] = H * m + I * t + K * A + M * B;
		c[7] = H * n + I * s + K * y + M * x;
		c[8] = L * b + O * p + J * v + P * E;
		c[9] = L * e + O * r + J * u + P * F;
		c[10] = L * m + O * t + J * A + P * B;
		c[11] = L * n + O * s + J * y + P * x;
		c[12] = N * b + Q * p + R * v + d * E;
		c[13] = N * e + Q * r + R * u + d * F;
		c[14] = N * m + Q * t + R * A + d * B;
		c[15] = N * n + Q * s + R * y + d * x;
		return this
	};
	b.getMat4MultiplyValue = function(b, c) {
		var d = b.mat,
			e = c.mat,
			m = new Float32Array(16);
		m[0] = d[0] * e[0] + d[4] * e[1] + d[8] * e[2] + d[12] * e[3];
		m[1] = d[1] * e[0] + d[5] * e[1] + d[9] * e[2] + d[13] * e[3];
		m[2] = d[2] * e[0] + d[6] * e[1] + d[10] * e[2] + d[14] * e[3];
		m[3] = d[3] * e[0] + d[7] * e[1] + d[11] * e[2] + d[15] * e[3];
		m[4] = d[0] * e[4] + d[4] * e[5] + d[8] * e[6] + d[12] * e[7];
		m[5] = d[1] * e[4] + d[5] * e[5] + d[9] * e[6] + d[13] * e[7];
		m[6] = d[2] * e[4] + d[6] * e[5] + d[10] * e[6] + d[14] * e[7];
		m[7] = d[3] * e[4] + d[7] * e[5] + d[11] * e[6] + d[15] * e[7];
		m[8] = d[0] * e[8] + d[4] * e[9] + d[8] * e[10] + d[12] * e[11];
		m[9] = d[1] * e[8] + d[5] * e[9] + d[9] * e[10] + d[13] * e[11];
		m[10] = d[2] * e[8] + d[6] * e[9] + d[10] * e[10] + d[14] * e[11];
		m[11] = d[3] * e[8] + d[7] * e[9] + d[11] * e[10] + d[15] * e[11];
		m[12] = d[0] * e[12] + d[4] * e[13] + d[8] * e[14] + d[12] * e[15];
		m[13] = d[1] * e[12] + d[5] * e[13] + d[9] * e[14] + d[13] * e[15];
		m[14] = d[2] * e[12] + d[6] * e[13] + d[10] * e[14] + d[14] * e[15];
		m[15] = d[3] * e[12] + d[7] * e[13] + d[11] * e[14] + d[15] * e[15];
		return m
	};
	b.kmMat4Assign = function(c, d) {
		if (c === d) {
			return b.log("cc.kmMat4Assign(): pOut equals pIn"), c
		}
		var e = c.mat,
			k = d.mat;
		e[0] = k[0];
		e[1] = k[1];
		e[2] = k[2];
		e[3] = k[3];
		e[4] = k[4];
		e[5] = k[5];
		e[6] = k[6];
		e[7] = k[7];
		e[8] = k[8];
		e[9] = k[9];
		e[10] = k[10];
		e[11] = k[11];
		e[12] = k[12];
		e[13] = k[13];
		e[14] = k[14];
		e[15] = k[15];
		return c
	};
	c.assignFrom = function(c) {
		if (this === c) {
			return b.log("cc.mat.Matrix4.assignFrom(): mat4 equals current matrix"), this
		}
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
		d[9] = c[9];
		d[10] = c[10];
		d[11] = c[11];
		d[12] = c[12];
		d[13] = c[13];
		d[14] = c[14];
		d[15] = c[15];
		return this
	};
	c.equals = function(c) {
		if (this === c) {
			return b.log("cc.kmMat4AreEqual(): pMat1 and pMat2 are same object."), !0
		}
		var d = this.mat;
		c = c.mat;
		for (var e = b.math.EPSILON, k = 0; 16 > k; k++) {
			if (!(d[k] + e > c[k] && d[k] - e < c[k])) {
				return !1
			}
		}
		return !0
	};
	b.math.Matrix4.createByRotationX = function(c, d) {
		d = d || new b.math.Matrix4;
		var e = d.mat;
		e[0] = 1;
		e[3] = e[2] = e[1] = 0;
		e[4] = 0;
		e[5] = Math.cos(c);
		e[6] = Math.sin(c);
		e[7] = 0;
		e[8] = 0;
		e[9] = -Math.sin(c);
		e[10] = Math.cos(c);
		e[11] = 0;
		e[14] = e[13] = e[12] = 0;
		e[15] = 1;
		return d
	};
	b.math.Matrix4.createByRotationY = function(c, d) {
		d = d || new b.math.Matrix4;
		var e = d.mat;
		e[0] = Math.cos(c);
		e[1] = 0;
		e[2] = -Math.sin(c);
		e[3] = 0;
		e[7] = e[6] = e[4] = 0;
		e[5] = 1;
		e[8] = Math.sin(c);
		e[9] = 0;
		e[10] = Math.cos(c);
		e[11] = 0;
		e[14] = e[13] = e[12] = 0;
		e[15] = 1;
		return d
	};
	b.math.Matrix4.createByRotationZ = function(c, d) {
		d = d || new b.math.Matrix4;
		var e = d.mat;
		e[0] = Math.cos(c);
		e[1] = Math.sin(c);
		e[3] = e[2] = 0;
		e[4] = -Math.sin(c);
		e[5] = Math.cos(c);
		e[7] = e[6] = 0;
		e[11] = e[9] = e[8] = 0;
		e[10] = 1;
		e[14] = e[13] = e[12] = 0;
		e[15] = 1;
		return d
	};
	b.math.Matrix4.createByPitchYawRoll = function(c, d, e, k) {
		k = k || new b.math.Matrix4;
		var m = Math.cos(c);
		c = Math.sin(c);
		var n = Math.cos(d);
		d = Math.sin(d);
		var p = Math.cos(e);
		e = Math.sin(e);
		var r = c * d,
			t = m * d,
			s = k.mat;
		s[0] = n * p;
		s[4] = n * e;
		s[8] = -d;
		s[1] = r * p - m * e;
		s[5] = r * e + m * p;
		s[9] = c * n;
		s[2] = t * p + c * e;
		s[6] = t * e - c * p;
		s[10] = m * n;
		s[3] = s[7] = s[11] = 0;
		s[15] = 1;
		return k
	};
	b.math.Matrix4.createByQuaternion = function(c, d) {
		d = d || new b.math.Matrix4;
		var e = d.mat;
		e[0] = 1 - 2 * (c.y * c.y + c.z * c.z);
		e[1] = 2 * (c.x * c.y + c.z * c.w);
		e[2] = 2 * (c.x * c.z - c.y * c.w);
		e[3] = 0;
		e[4] = 2 * (c.x * c.y - c.z * c.w);
		e[5] = 1 - 2 * (c.x * c.x + c.z * c.z);
		e[6] = 2 * (c.z * c.y + c.x * c.w);
		e[7] = 0;
		e[8] = 2 * (c.x * c.z + c.y * c.w);
		e[9] = 2 * (c.y * c.z - c.x * c.w);
		e[10] = 1 - 2 * (c.x * c.x + c.y * c.y);
		e[11] = 0;
		e[14] = e[13] = e[12] = 0;
		e[15] = 1;
		return d
	};
	b.math.Matrix4.createByRotationTranslation = function(c, d, e) {
		e = e || new b.math.Matrix4;
		var k = e.mat;
		c = c.mat;
		k[0] = c[0];
		k[1] = c[1];
		k[2] = c[2];
		k[3] = 0;
		k[4] = c[3];
		k[5] = c[4];
		k[6] = c[5];
		k[7] = 0;
		k[8] = c[6];
		k[9] = c[7];
		k[10] = c[8];
		k[11] = 0;
		k[12] = d.x;
		k[13] = d.y;
		k[14] = d.z;
		k[15] = 1;
		return e
	};
	b.math.Matrix4.createByScale = function(c, d, e, k) {
		k = k || new b.math.Matrix4;
		var m = k.mat;
		m[0] = c;
		m[5] = d;
		m[10] = e;
		m[15] = 1;
		m[1] = m[2] = m[3] = m[4] = m[6] = m[7] = m[8] = m[9] = m[11] = m[12] = m[13] = m[14] = 0;
		return k
	};
	b.kmMat4Translation = function(b, c, d, e) {
		b.mat[0] = b.mat[5] = b.mat[10] = b.mat[15] = 1;
		b.mat[1] = b.mat[2] = b.mat[3] = b.mat[4] = b.mat[6] = b.mat[7] = b.mat[8] = b.mat[9] = b.mat[11] = 0;
		b.mat[12] = c;
		b.mat[13] = d;
		b.mat[14] = e;
		return b
	};
	b.math.Matrix4.createByTranslation = function(c, d, e, k) {
		k = k || new b.math.Matrix4;
		k.identity();
		k.mat[12] = c;
		k.mat[13] = d;
		k.mat[14] = e;
		return k
	};
	c.getUpVec3 = function() {
		var c = this.mat;
		return (new b.math.Vec3(c[4], c[5], c[6])).normalize()
	};
	c.getRightVec3 = function() {
		var c = this.mat;
		return (new b.math.Vec3(c[0], c[1], c[2])).normalize()
	};
	c.getForwardVec3 = function() {
		var c = this.mat;
		return (new b.math.Vec3(c[8], c[9], c[10])).normalize()
	};
	b.kmMat4PerspectiveProjection = function(c, d, e, k, m) {
		var n = b.degreesToRadians(d / 2);
		d = m - k;
		var p = Math.sin(n);
		if (0 === d || 0 === p || 0 === e) {
			return null
		}
		n = Math.cos(n) / p;
		c.identity();
		c.mat[0] = n / e;
		c.mat[5] = n;
		c.mat[10] = -(m + k) / d;
		c.mat[11] = -1;
		c.mat[14] = -2 * k * m / d;
		c.mat[15] = 0;
		return c
	};
	b.math.Matrix4.createPerspectiveProjection = function(c, d, e, k) {
		var m = b.degreesToRadians(c / 2);
		c = k - e;
		var n = Math.sin(m);
		if (0 === c || 0 === n || 0 === d) {
			return null
		}
		var m = Math.cos(m) / n,
			n = new b.math.Matrix4,
			p = n.mat;
		n.identity();
		p[0] = m / d;
		p[5] = m;
		p[10] = -(k + e) / c;
		p[11] = -1;
		p[14] = -2 * e * k / c;
		p[15] = 0;
		return n
	};
	b.kmMat4OrthographicProjection = function(b, c, d, e, m, n, p) {
		b.identity();
		b.mat[0] = 2 / (d - c);
		b.mat[5] = 2 / (m - e);
		b.mat[10] = -2 / (p - n);
		b.mat[12] = -((d + c) / (d - c));
		b.mat[13] = -((m + e) / (m - e));
		b.mat[14] = -((p + n) / (p - n));
		return b
	};
	b.math.Matrix4.createOrthographicProjection = function(c, d, e, k, m, n) {
		var p = new b.math.Matrix4,
			r = p.mat;
		p.identity();
		r[0] = 2 / (d - c);
		r[5] = 2 / (k - e);
		r[10] = -2 / (n - m);
		r[12] = -((d + c) / (d - c));
		r[13] = -((k + e) / (k - e));
		r[14] = -((n + m) / (n - m));
		return p
	};
	b.kmMat4LookAt = function(c, d, e, k) {
		e = new b.math.Vec3(e);
		var m = new b.math.Vec3(k);
		e.subtract(d);
		e.normalize();
		m.normalize();
		k = new b.math.Vec3(e);
		k.cross(m);
		k.normalize();
		m = new b.math.Vec3(k);
		m.cross(e);
		k.normalize();
		c.identity();
		c.mat[0] = k.x;
		c.mat[4] = k.y;
		c.mat[8] = k.z;
		c.mat[1] = m.x;
		c.mat[5] = m.y;
		c.mat[9] = m.z;
		c.mat[2] = -e.x;
		c.mat[6] = -e.y;
		c.mat[10] = -e.z;
		d = b.math.Matrix4.createByTranslation(-d.x, -d.y, -d.z);
		c.multiply(d);
		return c
	};
	var e = new b.math.Matrix4;
	c.lookAt = function(c, d, h) {
		d = new b.math.Vec3(d);
		var k = new b.math.Vec3(h);
		h = this.mat;
		d.subtract(c);
		d.normalize();
		k.normalize();
		var m = new b.math.Vec3(d);
		m.cross(k);
		m.normalize();
		k = new b.math.Vec3(m);
		k.cross(d);
		m.normalize();
		this.identity();
		h[0] = m.x;
		h[4] = m.y;
		h[8] = m.z;
		h[1] = k.x;
		h[5] = k.y;
		h[9] = k.z;
		h[2] = -d.x;
		h[6] = -d.y;
		h[10] = -d.z;
		e = b.math.Matrix4.createByTranslation(-c.x, -c.y, -c.z, e);
		this.multiply(e);
		return this
	};
	b.kmMat4RotationAxisAngle = function(c, d, e) {
		var k = Math.cos(e);
		e = Math.sin(e);
		d = new b.math.Vec3(d);
		d.normalize();
		c.mat[0] = k + d.x * d.x * (1 - k);
		c.mat[1] = d.z * e + d.y * d.x * (1 - k);
		c.mat[2] = -d.y * e + d.z * d.x * (1 - k);
		c.mat[3] = 0;
		c.mat[4] = -d.z * e + d.x * d.y * (1 - k);
		c.mat[5] = k + d.y * d.y * (1 - k);
		c.mat[6] = d.x * e + d.z * d.y * (1 - k);
		c.mat[7] = 0;
		c.mat[8] = d.y * e + d.x * d.z * (1 - k);
		c.mat[9] = -d.x * e + d.y * d.z * (1 - k);
		c.mat[10] = k + d.z * d.z * (1 - k);
		c.mat[11] = 0;
		c.mat[12] = 0;
		c.mat[13] = 0;
		c.mat[14] = 0;
		c.mat[15] = 1;
		return c
	};
	b.math.Matrix4.createByAxisAndAngle = function(c, d, e) {
		e = e || new b.math.Matrix4;
		var k = this.mat,
			m = Math.cos(d);
		d = Math.sin(d);
		c = new b.math.Vec3(c);
		c.normalize();
		k[0] = m + c.x * c.x * (1 - m);
		k[1] = c.z * d + c.y * c.x * (1 - m);
		k[2] = -c.y * d + c.z * c.x * (1 - m);
		k[3] = 0;
		k[4] = -c.z * d + c.x * c.y * (1 - m);
		k[5] = m + c.y * c.y * (1 - m);
		k[6] = c.x * d + c.z * c.y * (1 - m);
		k[7] = 0;
		k[8] = c.y * d + c.x * c.z * (1 - m);
		k[9] = -c.x * d + c.y * c.z * (1 - m);
		k[10] = m + c.z * c.z * (1 - m);
		k[11] = 0;
		k[12] = k[13] = k[14] = 0;
		k[15] = 1;
		return e
	};
	c.extractRotation = function() {
		var c = new b.math.Matrix3,
			d = this.mat,
			e = c.mat;
		e[0] = d[0];
		e[1] = d[1];
		e[2] = d[2];
		e[3] = d[4];
		e[4] = d[5];
		e[5] = d[6];
		e[6] = d[8];
		e[7] = d[9];
		e[8] = d[10];
		return c
	};
	c.extractPlane = function(c) {
		var d = new b.math.Plane,
			e = this.mat;
		switch (c) {
		case b.math.Plane.RIGHT:
			d.a = e[3] - e[0];
			d.b = e[7] - e[4];
			d.c = e[11] - e[8];
			d.d = e[15] - e[12];
			break;
		case b.math.Plane.LEFT:
			d.a = e[3] + e[0];
			d.b = e[7] + e[4];
			d.c = e[11] + e[8];
			d.d = e[15] + e[12];
			break;
		case b.math.Plane.BOTTOM:
			d.a = e[3] + e[1];
			d.b = e[7] + e[5];
			d.c = e[11] + e[9];
			d.d = e[15] + e[13];
			break;
		case b.math.Plane.TOP:
			d.a = e[3] - e[1];
			d.b = e[7] - e[5];
			d.c = e[11] - e[9];
			d.d = e[15] - e[13];
			break;
		case b.math.Plane.FAR:
			d.a = e[3] - e[2];
			d.b = e[7] - e[6];
			d.c = e[11] - e[10];
			d.d = e[15] - e[14];
			break;
		case b.math.Plane.NEAR:
			d.a = e[3] + e[2];
			d.b = e[7] + e[6];
			d.c = e[11] + e[10];
			d.d = e[15] + e[14];
			break;
		default:
			b.log("cc.math.Matrix4.extractPlane: Invalid plane index")
		}
		c = Math.sqrt(d.a * d.a + d.b * d.b + d.c * d.c);
		d.a /= c;
		d.b /= c;
		d.c /= c;
		d.d /= c;
		return d
	};
	c.toAxisAndAngle = function() {
		var c = this.extractRotation();
		return b.math.Quaternion.rotationMatrix(c).toAxisAndAngle()
	}
})(cc);
(function(b) {
	b.math.Plane = function(b, c, f, g) {
		b && void 0 === c ? (this.a = b.a, this.b = b.b, this.c = b.c, this.d = b.d) : (this.a = b || 0, this.b = c || 0, this.c = f || 0, this.d = g || 0)
	};
	b.kmPlane = b.math.Plane;
	var c = b.math.Plane.prototype;
	b.math.Plane.LEFT = 0;
	b.math.Plane.RIGHT = 1;
	b.math.Plane.BOTTOM = 2;
	b.math.Plane.TOP = 3;
	b.math.Plane.NEAR = 4;
	b.math.Plane.FAR = 5;
	b.math.Plane.POINT_INFRONT_OF_PLANE = 0;
	b.math.Plane.POINT_BEHIND_PLANE = 1;
	b.math.Plane.POINT_ON_PLANE = 2;
	c.dot = function(b) {
		return this.a * b.x + this.b * b.y + this.c * b.z + this.d * b.w
	};
	c.dotCoord = function(b) {
		return this.a * b.x + this.b * b.y + this.c * b.z + this.d
	};
	c.dotNormal = function(b) {
		return this.a * b.x + this.b * b.y + this.c * b.z
	};
	b.math.Plane.fromPointNormal = function(c, e) {
		return new b.math.Plane(e.x, e.y, e.z, -e.dot(c))
	};
	b.math.Plane.fromPoints = function(c, e, f) {
		e = new b.math.Vec3(e);
		f = new b.math.Vec3(f);
		var g = new b.math.Plane;
		e.subtract(c);
		f.subtract(c);
		e.cross(f);
		e.normalize();
		g.a = e.x;
		g.b = e.y;
		g.c = e.z;
		g.d = e.scale(-1).dot(c);
		return g
	};
	c.normalize = function() {
		var c = new b.math.Vec3(this.a, this.b, this.c),
			e = 1 / c.length();
		c.normalize();
		this.a = c.x;
		this.b = c.y;
		this.c = c.z;
		this.d *= e;
		return this
	};
	c.classifyPoint = function(c) {
		c = this.a * c.x + this.b * c.y + this.c * c.z + this.d;
		return 0.001 < c ? b.math.Plane.POINT_INFRONT_OF_PLANE : -0.001 > c ? b.math.Plane.POINT_BEHIND_PLANE : b.math.Plane.POINT_ON_PLANE
	}
})(cc);
(function(b) {
	b.math.Quaternion = function(b, c, f, g) {
		b && void 0 === c ? (this.x = b.x, this.y = b.y, this.z = b.z, this.w = b.w) : (this.x = b || 0, this.y = c || 0, this.z = f || 0, this.w = g || 0)
	};
	b.kmQuaternion = b.math.Quaternion;
	var c = b.math.Quaternion.prototype;
	c.conjugate = function(b) {
		this.x = -b.x;
		this.y = -b.y;
		this.z = -b.z;
		this.w = b.w;
		return this
	};
	c.dot = function(b) {
		return this.w * b.w + this.x * b.x + this.y * b.y + this.z * b.z
	};
	c.exponential = function() {
		return this
	};
	c.identity = function() {
		this.z = this.y = this.x = 0;
		this.w = 1;
		return this
	};
	c.inverse = function() {
		var c = this.length();
		if (Math.abs(c) > b.math.EPSILON) {
			return this.w = this.z = this.y = this.x = 0, this
		}
		this.conjugate(this).scale(1 / c);
		return this
	};
	c.isIdentity = function() {
		return 0 === this.x && 0 === this.y && 0 === this.z && 1 === this.w
	};
	c.length = function() {
		return Math.sqrt(this.lengthSq())
	};
	c.lengthSq = function() {
		return this.x * this.x + this.y * this.y + this.z * this.z + this.w * this.w
	};
	c.multiply = function(b) {
		var c = this.x,
			f = this.y,
			g = this.z,
			h = this.w;
		this.w = h * b.w - c * b.x - f * b.y - g * b.z;
		this.x = h * b.x + c * b.w + f * b.z - g * b.y;
		this.y = h * b.y + f * b.w + g * b.x - c * b.z;
		this.z = h * b.z + g * b.w + c * b.y - f * b.x;
		return this
	};
	c.normalize = function() {
		var c = this.length();
		if (Math.abs(c) <= b.math.EPSILON) {
			throw "current quaternion is an invalid value"
		}
		this.scale(1 / c);
		return this
	};
	c.rotationAxis = function(b, c) {
		var f = 0.5 * c,
			g = Math.sin(f);
		this.w = Math.cos(f);
		this.x = b.x * g;
		this.y = b.y * g;
		this.z = b.z * g;
		return this
	};
	b.math.Quaternion.rotationMatrix = function(c) {
		if (!c) {
			return null
		}
		var e, f, g;
		e = [];
		f = c.mat;
		c = 0;
		e[0] = f[0];
		e[1] = f[3];
		e[2] = f[6];
		e[4] = f[1];
		e[5] = f[4];
		e[6] = f[7];
		e[8] = f[2];
		e[9] = f[5];
		e[10] = f[8];
		e[15] = 1;
		var h = e[0];
		c = h[0] + h[5] + h[10] + 1;
		c > b.math.EPSILON ? (c = 2 * Math.sqrt(c), e = (h[9] - h[6]) / c, f = (h[2] - h[8]) / c, g = (h[4] - h[1]) / c, c *= 0.25) : h[0] > h[5] && h[0] > h[10] ? (c = 2 * Math.sqrt(1 + h[0] - h[5] - h[10]), e = 0.25 * c, f = (h[4] + h[1]) / c, g = (h[2] + h[8]) / c, c = (h[9] - h[6]) / c) : h[5] > h[10] ? (c = 2 * Math.sqrt(1 + h[5] - h[0] - h[10]), e = (h[4] + h[1]) / c, f = 0.25 * c, g = (h[9] + h[6]) / c, c = (h[2] - h[8]) / c) : (c = 2 * Math.sqrt(1 + h[10] - h[0] - h[5]), e = (h[2] + h[8]) / c, f = (h[9] + h[6]) / c, g = 0.25 * c, c = (h[4] - h[1]) / c);
		return new b.math.Quaternion(e, f, g, c)
	};
	b.math.Quaternion.rotationYawPitchRoll = function(c, e, f) {
		var g, h, k, m, n;
		g = b.degreesToRadians(e) / 2;
		h = b.degreesToRadians(c) / 2;
		k = b.degreesToRadians(f) / 2;
		f = Math.cos(g);
		c = Math.cos(h);
		e = Math.cos(k);
		g = Math.sin(g);
		h = Math.sin(h);
		k = Math.sin(k);
		m = c * e;
		n = h * k;
		var p = new b.math.Quaternion;
		p.w = f * m + g * n;
		p.x = g * m - f * n;
		p.y = f * h * e + g * c * k;
		p.z = f * c * k - g * h * e;
		p.normalize();
		return p
	};
	c.slerp = function(c, e) {
		if (this.x === c.x && this.y === c.y && this.z === c.z && this.w === c.w) {
			return this
		}
		var f = this.dot(c),
			g = Math.acos(f),
			h = Math.sqrt(1 - b.math.square(f)),
			f = Math.sin(e * g) / h,
			g = Math.sin((1 - e) * g) / h,
			h = new b.math.Quaternion(c);
		this.scale(g);
		h.scale(f);
		this.add(h);
		return this
	};
	c.toAxisAndAngle = function() {
		var c, e, f = new b.math.Vec3;
		c = Math.acos(this.w);
		e = Math.sqrt(b.math.square(this.x) + b.math.square(this.y) + b.math.square(this.z));
		e > -b.math.EPSILON && e < b.math.EPSILON || e < 2 * Math.PI + b.math.EPSILON && e > 2 * Math.PI - b.math.EPSILON ? (c = 0, f.x = 0, f.y = 0, f.z = 1) : (c *= 2, f.x = this.x / e, f.y = this.y / e, f.z = this.z / e, f.normalize());
		return {
			axis: f,
			angle: c
		}
	};
	c.scale = function(b) {
		this.x *= b;
		this.y *= b;
		this.z *= b;
		this.w *= b;
		return this
	};
	c.assignFrom = function(b) {
		this.x = b.x;
		this.y = b.y;
		this.z = b.z;
		this.w = b.w;
		return this
	};
	c.add = function(b) {
		this.x += b.x;
		this.y += b.y;
		this.z += b.z;
		this.w += b.w;
		return this
	};
	b.math.Quaternion.rotationBetweenVec3 = function(c, e, f) {
		var g = new b.math.Vec3(c),
			h = new b.math.Vec3(e);
		g.normalize();
		h.normalize();
		var k = g.dot(h);
		e = new b.math.Quaternion;
		if (1 <= k) {
			return e.identity(), e
		} - 0.999999 > k ? Math.abs(f.lengthSq()) < b.math.EPSILON ? e.rotationAxis(f, Math.PI) : (g = new b.math.Vec3(1, 0, 0), g.cross(c), Math.abs(g.lengthSq()) < b.math.EPSILON && (g.fill(0, 1, 0), g.cross(c)), g.normalize(), e.rotationAxis(g, Math.PI)) : (c = Math.sqrt(2 * (1 + k)), f = 1 / c, g.cross(h), e.x = g.x * f, e.y = g.y * f, e.z = g.z * f, e.w = 0.5 * c, e.normalize());
		return e
	};
	c.multiplyVec3 = function(c) {
		var e = this.x,
			f = this.y,
			g = this.z,
			h = new b.math.Vec3(c),
			k = new b.math.Vec3(e, f, g),
			e = new b.math.Vec3(e, f, g);
		k.cross(c);
		e.cross(k);
		k.scale(2 * q.w);
		e.scale(2);
		h.add(k);
		h.add(e);
		return h
	}
})(cc);
cc.math.AABB = function(b, c) {
	this.min = b || new cc.math.Vec3;
	this.max = c || new cc.math.Vec3
};
cc.math.AABB.prototype.containsPoint = function(b) {
	return b.x >= this.min.x && b.x <= this.max.x && b.y >= this.min.y && b.y <= this.max.y && b.z >= this.min.z && b.z <= this.max.z
};
cc.math.AABB.containsPoint = function(b, c) {
	return b.x >= c.min.x && b.x <= c.max.x && b.y >= c.min.y && b.y <= c.max.y && b.z >= c.min.z && b.z <= c.max.z
};
cc.math.AABB.prototype.assignFrom = function(b) {
	this.min.assignFrom(b.min);
	this.max.assignFrom(b.max)
};
cc.math.AABB.assign = function(b, c) {
	b.min.assignFrom(c.min);
	b.max.assignFrom(c.max);
	return b
};
(function(b) {
	b.math.Matrix4Stack = function(b, c) {
		this.top = b;
		this.stack = c || []
	};
	b.km_mat4_stack = b.math.Matrix4Stack;
	var c = b.math.Matrix4Stack.prototype;
	c.initialize = function() {
		this.stack.length = 0;
		this.top = null
	};
	b.km_mat4_stack_push = function(c, e) {
		c.stack.push(c.top);
		c.top = new b.math.Matrix4(e)
	};
	b.km_mat4_stack_pop = function(b, c) {
		b.top = b.stack.pop()
	};
	b.km_mat4_stack_release = function(b) {
		b.stack = null;
		b.top = null
	};
	c.push = function(c) {
		c = c || this.top;
		this.stack.push(this.top);
		this.top = new b.math.Matrix4(c)
	};
	c.pop = function() {
		this.top = this.stack.pop()
	};
	c.release = function() {
		this._matrixPool = this.top = this.stack = null
	};
	c._getFromPool = function(c) {
		var e = this._matrixPool;
		if (0 === e.length) {
			return new b.math.Matrix4(c)
		}
		e = e.pop();
		e.assignFrom(c);
		return e
	};
	c._putInPool = function(b) {
		this._matrixPool.push(b)
	}
})(cc);
(function(b) {
	b.KM_GL_MODELVIEW = 5888;
	b.KM_GL_PROJECTION = 5889;
	b.KM_GL_TEXTURE = 5890;
	b.modelview_matrix_stack = new b.math.Matrix4Stack;
	b.projection_matrix_stack = new b.math.Matrix4Stack;
	b.texture_matrix_stack = new b.math.Matrix4Stack;
	b.current_stack = null;
	b.lazyInitialize = function() {
		var c = new b.math.Matrix4;
		b.modelview_matrix_stack.initialize();
		b.projection_matrix_stack.initialize();
		b.texture_matrix_stack.initialize();
		b.current_stack = b.modelview_matrix_stack;
		b.initialized = !0;
		c.identity();
		b.modelview_matrix_stack.push(c);
		b.projection_matrix_stack.push(c);
		b.texture_matrix_stack.push(c)
	};
	b.lazyInitialize();
	b.kmGLFreeAll = function() {
		b.modelview_matrix_stack.release();
		b.modelview_matrix_stack = null;
		b.projection_matrix_stack.release();
		b.projection_matrix_stack = null;
		b.texture_matrix_stack.release();
		b.texture_matrix_stack = null;
		b.initialized = !1;
		b.current_stack = null
	};
	b.kmGLPushMatrix = function() {
		b.current_stack.push(b.current_stack.top)
	};
	b.kmGLPushMatrixWitMat4 = function(c) {
		b.current_stack.stack.push(b.current_stack.top);
		c.assignFrom(b.current_stack.top);
		b.current_stack.top = c
	};
	b.kmGLPopMatrix = function() {
		b.current_stack.top = b.current_stack.stack.pop()
	};
	b.kmGLMatrixMode = function(c) {
		switch (c) {
		case b.KM_GL_MODELVIEW:
			b.current_stack = b.modelview_matrix_stack;
			break;
		case b.KM_GL_PROJECTION:
			b.current_stack = b.projection_matrix_stack;
			break;
		case b.KM_GL_TEXTURE:
			b.current_stack = b.texture_matrix_stack;
			break;
		default:
			throw "Invalid matrix mode specified"
		}
	};
	b.kmGLLoadIdentity = function() {
		b.current_stack.top.identity()
	};
	b.kmGLLoadMatrix = function(c) {
		b.current_stack.top.assignFrom(c)
	};
	b.kmGLMultMatrix = function(c) {
		b.current_stack.top.multiply(c)
	};
	var c = new b.math.Matrix4;
	b.kmGLTranslatef = function(d, f, g) {
		d = b.math.Matrix4.createByTranslation(d, f, g, c);
		b.current_stack.top.multiply(d)
	};
	var d = new b.math.Vec3;
	b.kmGLRotatef = function(e, f, g, h) {
		d.fill(f, g, h);
		e = b.math.Matrix4.createByAxisAndAngle(d, b.degreesToRadians(e), c);
		b.current_stack.top.multiply(e)
	};
	b.kmGLScalef = function(d, f, g) {
		d = b.math.Matrix4.createByScale(d, f, g, c);
		b.current_stack.top.multiply(d)
	};
	b.kmGLGetMatrix = function(c, d) {
		switch (c) {
		case b.KM_GL_MODELVIEW:
			d.assignFrom(b.modelview_matrix_stack.top);
			break;
		case b.KM_GL_PROJECTION:
			d.assignFrom(b.projection_matrix_stack.top);
			break;
		case b.KM_GL_TEXTURE:
			d.assignFrom(b.texture_matrix_stack.top);
			break;
		default:
			throw "Invalid matrix mode specified"
		}
	}
})(cc);
cc.SHADER_POSITION_UCOLOR_FRAG = "precision lowp float;\nvarying vec4 v_fragmentColor;\nvoid main()                              \n{ \n    gl_FragColor = v_fragmentColor;      \n}\n";
cc.SHADER_POSITION_UCOLOR_VERT = "attribute vec4 a_position;\nuniform    vec4 u_color;\nuniform float u_pointSize;\nvarying lowp vec4 v_fragmentColor; \nvoid main(void)   \n{\n    gl_Position = (CC_PMatrix * CC_MVMatrix) * a_position;  \n    gl_PointSize = u_pointSize;          \n    v_fragmentColor = u_color;           \n}";
cc.SHADER_POSITION_COLOR_FRAG = "precision lowp float; \nvarying vec4 v_fragmentColor; \nvoid main() \n{ \n     gl_FragColor = v_fragmentColor; \n} ";
cc.SHADER_POSITION_COLOR_VERT = "attribute vec4 a_position;\nattribute vec4 a_color;\nvarying lowp vec4 v_fragmentColor;\nvoid main()\n{\n    gl_Position = (CC_PMatrix * CC_MVMatrix) * a_position;  \n    v_fragmentColor = a_color;             \n}";
cc.SHADER_POSITION_COLOR_LENGTH_TEXTURE_FRAG = "// #extension GL_OES_standard_derivatives : enable\nvarying mediump vec4 v_color;\nvarying mediump vec2 v_texcoord;\nvoid main()\t\n{ \n// #if defined GL_OES_standard_derivatives\t\n// gl_FragColor = v_color*smoothstep(0.0, length(fwidth(v_texcoord)), 1.0 - length(v_texcoord)); \n// #else\t\ngl_FragColor = v_color * step(0.0, 1.0 - length(v_texcoord)); \n// #endif \n}";
cc.SHADER_POSITION_COLOR_LENGTH_TEXTURE_VERT = "attribute mediump vec4 a_position; \nattribute mediump vec2 a_texcoord; \nattribute mediump vec4 a_color;\t\nvarying mediump vec4 v_color; \nvarying mediump vec2 v_texcoord;\t\nvoid main() \n{ \n     v_color = a_color;//vec4(a_color.rgb * a_color.a, a_color.a); \n     v_texcoord = a_texcoord; \n    gl_Position = (CC_PMatrix * CC_MVMatrix) * a_position;  \n}";
cc.SHADER_POSITION_TEXTURE_FRAG = "precision lowp float;   \nvarying vec2 v_texCoord;  \nvoid main() \n{  \n    gl_FragColor =  texture2D(CC_Texture0, v_texCoord);   \n}";
cc.SHADER_POSITION_TEXTURE_VERT = "attribute vec4 a_position; \nattribute vec2 a_texCoord; \nvarying mediump vec2 v_texCoord; \nvoid main() \n{ \n    gl_Position = (CC_PMatrix * CC_MVMatrix) * a_position;  \n    v_texCoord = a_texCoord;               \n}";
cc.SHADER_POSITION_TEXTURE_UCOLOR_FRAG = "precision lowp float;  \nuniform vec4 u_color; \nvarying vec2 v_texCoord; \nvoid main() \n{  \n    gl_FragColor =  texture2D(CC_Texture0, v_texCoord) * u_color;    \n}";
cc.SHADER_POSITION_TEXTURE_UCOLOR_VERT = "attribute vec4 a_position;\nattribute vec2 a_texCoord; \nvarying mediump vec2 v_texCoord; \nvoid main() \n{ \n    gl_Position = (CC_PMatrix * CC_MVMatrix) * a_position;  \n    v_texCoord = a_texCoord;                 \n}";
cc.SHADER_POSITION_TEXTURE_A8COLOR_FRAG = "precision lowp float;  \nvarying vec4 v_fragmentColor; \nvarying vec2 v_texCoord; \nvoid main() \n{ \n    gl_FragColor = vec4( v_fragmentColor.rgb,         \n        v_fragmentColor.a * texture2D(CC_Texture0, v_texCoord).a   \n    ); \n}";
cc.SHADER_POSITION_TEXTURE_A8COLOR_VERT = "attribute vec4 a_position; \nattribute vec2 a_texCoord; \nattribute vec4 a_color;  \nvarying lowp vec4 v_fragmentColor; \nvarying mediump vec2 v_texCoord; \nvoid main() \n{ \n    gl_Position = (CC_PMatrix * CC_MVMatrix) * a_position;  \n    v_fragmentColor = a_color; \n    v_texCoord = a_texCoord; \n}";
cc.SHADER_POSITION_TEXTURE_COLOR_FRAG = "precision lowp float;\nvarying vec4 v_fragmentColor; \nvarying vec2 v_texCoord; \nvoid main() \n{ \n    gl_FragColor = v_fragmentColor * texture2D(CC_Texture0, v_texCoord); \n}";
cc.SHADER_POSITION_TEXTURE_COLOR_VERT = "attribute vec4 a_position; \nattribute vec2 a_texCoord; \nattribute vec4 a_color;  \nvarying lowp vec4 v_fragmentColor; \nvarying mediump vec2 v_texCoord; \nvoid main() \n{ \n    gl_Position = (CC_PMatrix * CC_MVMatrix) * a_position;  \n    v_fragmentColor = a_color; \n    v_texCoord = a_texCoord; \n}";
cc.SHADER_POSITION_TEXTURE_COLOR_ALPHATEST_FRAG = "precision lowp float;   \nvarying vec4 v_fragmentColor; \nvarying vec2 v_texCoord;   \nuniform float CC_alpha_value; \nvoid main() \n{  \n    vec4 texColor = texture2D(CC_Texture0, v_texCoord);  \n    if ( texColor.a <= CC_alpha_value )          \n        discard; \n    gl_FragColor = texColor * v_fragmentColor;  \n}";
cc.SHADEREX_SWITCHMASK_FRAG = "precision lowp float; \nvarying vec4 v_fragmentColor; \nvarying vec2 v_texCoord; \nuniform sampler2D u_texture;  \nuniform sampler2D   u_mask;   \nvoid main()  \n{  \n    vec4 texColor   = texture2D(u_texture, v_texCoord);  \n    vec4 maskColor  = texture2D(u_mask, v_texCoord); \n    vec4 finalColor = vec4(texColor.r, texColor.g, texColor.b, maskColor.a * texColor.a);        \n    gl_FragColor    = v_fragmentColor * finalColor; \n}";
cc.shaderCache = {
	TYPE_POSITION_TEXTURECOLOR: 0,
	TYPE_POSITION_TEXTURECOLOR_ALPHATEST: 1,
	TYPE_POSITION_COLOR: 2,
	TYPE_POSITION_TEXTURE: 3,
	TYPE_POSITION_TEXTURE_UCOLOR: 4,
	TYPE_POSITION_TEXTURE_A8COLOR: 5,
	TYPE_POSITION_UCOLOR: 6,
	TYPE_POSITION_LENGTH_TEXTURECOLOR: 7,
	TYPE_MAX: 8,
	_programs: {},
	_init: function() {
		this.loadDefaultShaders();
		return !0
	},
	_loadDefaultShader: function(b, c) {
		switch (c) {
		case this.TYPE_POSITION_TEXTURECOLOR:
			b.initWithVertexShaderByteArray(cc.SHADER_POSITION_TEXTURE_COLOR_VERT, cc.SHADER_POSITION_TEXTURE_COLOR_FRAG);
			b.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
			b.addAttribute(cc.ATTRIBUTE_NAME_COLOR, cc.VERTEX_ATTRIB_COLOR);
			b.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
			break;
		case this.TYPE_POSITION_TEXTURECOLOR_ALPHATEST:
			b.initWithVertexShaderByteArray(cc.SHADER_POSITION_TEXTURE_COLOR_VERT, cc.SHADER_POSITION_TEXTURE_COLOR_ALPHATEST_FRAG);
			b.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
			b.addAttribute(cc.ATTRIBUTE_NAME_COLOR, cc.VERTEX_ATTRIB_COLOR);
			b.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
			break;
		case this.TYPE_POSITION_COLOR:
			b.initWithVertexShaderByteArray(cc.SHADER_POSITION_COLOR_VERT, cc.SHADER_POSITION_COLOR_FRAG);
			b.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
			b.addAttribute(cc.ATTRIBUTE_NAME_COLOR, cc.VERTEX_ATTRIB_COLOR);
			break;
		case this.TYPE_POSITION_TEXTURE:
			b.initWithVertexShaderByteArray(cc.SHADER_POSITION_TEXTURE_VERT, cc.SHADER_POSITION_TEXTURE_FRAG);
			b.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
			b.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
			break;
		case this.TYPE_POSITION_TEXTURE_UCOLOR:
			b.initWithVertexShaderByteArray(cc.SHADER_POSITION_TEXTURE_UCOLOR_VERT, cc.SHADER_POSITION_TEXTURE_UCOLOR_FRAG);
			b.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
			b.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
			break;
		case this.TYPE_POSITION_TEXTURE_A8COLOR:
			b.initWithVertexShaderByteArray(cc.SHADER_POSITION_TEXTURE_A8COLOR_VERT, cc.SHADER_POSITION_TEXTURE_A8COLOR_FRAG);
			b.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
			b.addAttribute(cc.ATTRIBUTE_NAME_COLOR, cc.VERTEX_ATTRIB_COLOR);
			b.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
			break;
		case this.TYPE_POSITION_UCOLOR:
			b.initWithVertexShaderByteArray(cc.SHADER_POSITION_UCOLOR_VERT, cc.SHADER_POSITION_UCOLOR_FRAG);
			b.addAttribute("aVertex", cc.VERTEX_ATTRIB_POSITION);
			break;
		case this.TYPE_POSITION_LENGTH_TEXTURECOLOR:
			b.initWithVertexShaderByteArray(cc.SHADER_POSITION_COLOR_LENGTH_TEXTURE_VERT, cc.SHADER_POSITION_COLOR_LENGTH_TEXTURE_FRAG);
			b.addAttribute(cc.ATTRIBUTE_NAME_POSITION, cc.VERTEX_ATTRIB_POSITION);
			b.addAttribute(cc.ATTRIBUTE_NAME_TEX_COORD, cc.VERTEX_ATTRIB_TEX_COORDS);
			b.addAttribute(cc.ATTRIBUTE_NAME_COLOR, cc.VERTEX_ATTRIB_COLOR);
			break;
		default:
			cc.log("cocos2d: cc.shaderCache._loadDefaultShader, error shader type");
			return
		}
		b.link();
		b.updateUniforms()
	},
	loadDefaultShaders: function() {
		var b = new cc.GLProgram;
		this._loadDefaultShader(b, this.TYPE_POSITION_TEXTURECOLOR);
		this._programs[cc.SHADER_POSITION_TEXTURECOLOR] = b;
		this._programs.ShaderPositionTextureColor = b;
		b = new cc.GLProgram;
		this._loadDefaultShader(b, this.TYPE_POSITION_TEXTURECOLOR_ALPHATEST);
		this._programs[cc.SHADER_POSITION_TEXTURECOLORALPHATEST] = b;
		this._programs.ShaderPositionTextureColorAlphaTest = b;
		b = new cc.GLProgram;
		this._loadDefaultShader(b, this.TYPE_POSITION_COLOR);
		this._programs[cc.SHADER_POSITION_COLOR] = b;
		this._programs.ShaderPositionColor = b;
		b = new cc.GLProgram;
		this._loadDefaultShader(b, this.TYPE_POSITION_TEXTURE);
		this._programs[cc.SHADER_POSITION_TEXTURE] = b;
		this._programs.ShaderPositionTexture = b;
		b = new cc.GLProgram;
		this._loadDefaultShader(b, this.TYPE_POSITION_TEXTURE_UCOLOR);
		this._programs[cc.SHADER_POSITION_TEXTURE_UCOLOR] = b;
		this._programs.ShaderPositionTextureUColor = b;
		b = new cc.GLProgram;
		this._loadDefaultShader(b, this.TYPE_POSITION_TEXTURE_A8COLOR);
		this._programs[cc.SHADER_POSITION_TEXTUREA8COLOR] = b;
		this._programs.ShaderPositionTextureA8Color = b;
		b = new cc.GLProgram;
		this._loadDefaultShader(b, this.TYPE_POSITION_UCOLOR);
		this._programs[cc.SHADER_POSITION_UCOLOR] = b;
		this._programs.ShaderPositionUColor = b;
		b = new cc.GLProgram;
		this._loadDefaultShader(b, this.TYPE_POSITION_LENGTH_TEXTURECOLOR);
		this._programs[cc.SHADER_POSITION_LENGTHTEXTURECOLOR] = b;
		this._programs.ShaderPositionLengthTextureColor = b
	},
	reloadDefaultShaders: function() {
		var b = this.programForKey(cc.SHADER_POSITION_TEXTURECOLOR);
		b.reset();
		this._loadDefaultShader(b, this.TYPE_POSITION_TEXTURECOLOR);
		b = this.programForKey(cc.SHADER_POSITION_TEXTURECOLORALPHATEST);
		b.reset();
		this._loadDefaultShader(b, this.TYPE_POSITION_TEXTURECOLOR_ALPHATEST);
		b = this.programForKey(cc.SHADER_POSITION_COLOR);
		b.reset();
		this._loadDefaultShader(b, this.TYPE_POSITION_COLOR);
		b = this.programForKey(cc.SHADER_POSITION_TEXTURE);
		b.reset();
		this._loadDefaultShader(b, this.TYPE_POSITION_TEXTURE);
		b = this.programForKey(cc.SHADER_POSITION_TEXTURE_UCOLOR);
		b.reset();
		this._loadDefaultShader(b, this.TYPE_POSITION_TEXTURE_UCOLOR);
		b = this.programForKey(cc.SHADER_POSITION_TEXTUREA8COLOR);
		b.reset();
		this._loadDefaultShader(b, this.TYPE_POSITION_TEXTURE_A8COLOR);
		b = this.programForKey(cc.SHADER_POSITION_UCOLOR);
		b.reset();
		this._loadDefaultShader(b, this.TYPE_POSITION_UCOLOR)
	},
	programForKey: function(b) {
		return this._programs[b]
	},
	getProgram: function(b) {
		return this._programs[b]
	},
	addProgram: function(b, c) {
		this._programs[c] = b
	}
};
cc.HashUniformEntry = function(b, c, d) {
	this.value = b;
	this.location = c;
	this.hh = d || {}
};
cc.GLProgram = cc.Class.extend({
	_glContext: null,
	_programObj: null,
	_vertShader: null,
	_fragShader: null,
	_uniforms: null,
	_hashForUniforms: null,
	_usesTime: !1,
	_updateUniformLocation: function(b, c, d) {
		if (null == b) {
			return !1
		}
		d = !0;
		for (var e = null, f = 0; f < this._hashForUniforms.length; f++) {
			this._hashForUniforms[f].location == b && (e = this._hashForUniforms[f])
		}
		e ? e.value == c ? d = !1 : e.value = c : (e = new cc.HashUniformEntry, e.location = b, e.value = c, this._hashForUniforms.push(e));
		return d
	},
	_description: function() {
		return "<CCGLProgram = " + this.toString() + " | Program = " + this._programObj.toString() + ", VertexShader = " + this._vertShader.toString() + ", FragmentShader = " + this._fragShader.toString() + ">"
	},
	_compileShader: function(b, c, d) {
		if (!d || !b) {
			return !1
		}
		d = (cc.GLProgram._isHighpSupported() ? "precision highp float;\n" : "precision mediump float;\n") + "uniform mat4 CC_PMatrix;         \nuniform mat4 CC_MVMatrix;        \nuniform mat4 CC_MVPMatrix;       \nuniform vec4 CC_Time;            \nuniform vec4 CC_SinTime;         \nuniform vec4 CC_CosTime;         \nuniform vec4 CC_Random01;        \nuniform sampler2D CC_Texture0;   \n//CC INCLUDES END                \n" + d;
		this._glContext.shaderSource(b, d);
		this._glContext.compileShader(b);
		d = this._glContext.getShaderParameter(b, this._glContext.COMPILE_STATUS);
		d || (cc.log("cocos2d: ERROR: Failed to compile shader:\n" + this._glContext.getShaderSource(b)), c === this._glContext.VERTEX_SHADER ? cc.log("cocos2d: \n" + this.vertexShaderLog()) : cc.log("cocos2d: \n" + this.fragmentShaderLog()));
		return !0 === d
	},
	ctor: function(b, c, d) {
		this._uniforms = [];
		this._hashForUniforms = [];
		this._glContext = d || cc._renderContext;
		b && c && this.init(b, c)
	},
	destroyProgram: function() {
		this._hashForUniforms = this._uniforms = this._fragShader = this._vertShader = null;
		this._glContext.deleteProgram(this._programObj)
	},
	initWithVertexShaderByteArray: function(b, c) {
		var d = this._glContext;
		this._programObj = d.createProgram();
		this._fragShader = this._vertShader = null;
		b && (this._vertShader = d.createShader(d.VERTEX_SHADER), this._compileShader(this._vertShader, d.VERTEX_SHADER, b) || cc.log("cocos2d: ERROR: Failed to compile vertex shader"));
		c && (this._fragShader = d.createShader(d.FRAGMENT_SHADER), this._compileShader(this._fragShader, d.FRAGMENT_SHADER, c) || cc.log("cocos2d: ERROR: Failed to compile fragment shader"));
		this._vertShader && d.attachShader(this._programObj, this._vertShader);
		cc.checkGLErrorDebug();
		this._fragShader && d.attachShader(this._programObj, this._fragShader);
		this._hashForUniforms.length = 0;
		cc.checkGLErrorDebug();
		return !0
	},
	initWithString: function(b, c) {
		return this.initWithVertexShaderByteArray(b, c)
	},
	initWithVertexShaderFilename: function(b, c) {
		var d = cc.loader.getRes(b);
		if (!d) {
			throw "Please load the resource firset : " + b
		}
		var e = cc.loader.getRes(c);
		if (!e) {
			throw "Please load the resource firset : " + c
		}
		return this.initWithVertexShaderByteArray(d, e)
	},
	init: function(b, c) {
		return this.initWithVertexShaderFilename(b, c)
	},
	addAttribute: function(b, c) {
		this._glContext.bindAttribLocation(this._programObj, c, b)
	},
	link: function() {
		if (!this._programObj) {
			return cc.log("cc.GLProgram.link(): Cannot link invalid program"), !1
		}
		this._glContext.linkProgram(this._programObj);
		this._vertShader && this._glContext.deleteShader(this._vertShader);
		this._fragShader && this._glContext.deleteShader(this._fragShader);
		this._fragShader = this._vertShader = null;
		return cc.game.config[cc.game.CONFIG_KEY.debugMode] && !this._glContext.getProgramParameter(this._programObj, this._glContext.LINK_STATUS) ? (cc.log("cocos2d: ERROR: Failed to link program: " + this._glContext.getProgramInfoLog(this._programObj)), cc.glDeleteProgram(this._programObj), this._programObj = null, !1) : !0
	},
	use: function() {
		cc.glUseProgram(this._programObj)
	},
	updateUniforms: function() {
		this._uniforms[cc.UNIFORM_PMATRIX] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_PMATRIX_S);
		this._uniforms[cc.UNIFORM_MVMATRIX] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_MVMATRIX_S);
		this._uniforms[cc.UNIFORM_MVPMATRIX] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_MVPMATRIX_S);
		this._uniforms[cc.UNIFORM_TIME] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_TIME_S);
		this._uniforms[cc.UNIFORM_SINTIME] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_SINTIME_S);
		this._uniforms[cc.UNIFORM_COSTIME] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_COSTIME_S);
		this._usesTime = null != this._uniforms[cc.UNIFORM_TIME] || null != this._uniforms[cc.UNIFORM_SINTIME] || null != this._uniforms[cc.UNIFORM_COSTIME];
		this._uniforms[cc.UNIFORM_RANDOM01] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_RANDOM01_S);
		this._uniforms[cc.UNIFORM_SAMPLER] = this._glContext.getUniformLocation(this._programObj, cc.UNIFORM_SAMPLER_S);
		this.use();
		this.setUniformLocationWith1i(this._uniforms[cc.UNIFORM_SAMPLER], 0)
	},
	getUniformLocationForName: function(b) {
		if (!b) {
			throw "cc.GLProgram.getUniformLocationForName(): uniform name should be non-null"
		}
		if (!this._programObj) {
			throw "cc.GLProgram.getUniformLocationForName(): Invalid operation. Cannot get uniform location when program is not initialized"
		}
		return this._glContext.getUniformLocation(this._programObj, b)
	},
	getUniformMVPMatrix: function() {
		return this._uniforms[cc.UNIFORM_MVPMATRIX]
	},
	getUniformSampler: function() {
		return this._uniforms[cc.UNIFORM_SAMPLER]
	},
	setUniformLocationWith1i: function(b, c) {
		this._updateUniformLocation(b, c) && this._glContext.uniform1i(b, c)
	},
	setUniformLocationWith2i: function(b, c, d) {
		this._updateUniformLocation(b, [c, d]) && this._glContext.uniform2i(b, c, d)
	},
	setUniformLocationWith3i: function(b, c, d, e) {
		this._updateUniformLocation(b, [c, d, e]) && this._glContext.uniform3i(b, c, d, e)
	},
	setUniformLocationWith4i: function(b, c, d, e, f) {
		this._updateUniformLocation(b, [c, d, e, f]) && this._glContext.uniform4i(b, c, d, e, f)
	},
	setUniformLocationWith2iv: function(b, c, d) {
		this._updateUniformLocation(b, c) && this._glContext.uniform2iv(b, c)
	},
	setUniformLocationWith3iv: function(b, c, d) {
		this._updateUniformLocation(b, c) && this._glContext.uniform3iv(b, c)
	},
	setUniformLocationWith4iv: function(b, c, d) {
		this._updateUniformLocation(b, c) && this._glContext.uniform4iv(b, c)
	},
	setUniformLocationI32: function(b, c) {
		this.setUniformLocationWith1i(b, c)
	},
	setUniformLocationWith1f: function(b, c) {
		this._updateUniformLocation(b, c) && this._glContext.uniform1f(b, c)
	},
	setUniformLocationWith2f: function(b, c, d) {
		this._updateUniformLocation(b, [c, d]) && this._glContext.uniform2f(b, c, d)
	},
	setUniformLocationWith3f: function(b, c, d, e) {
		this._updateUniformLocation(b, [c, d, e]) && this._glContext.uniform3f(b, c, d, e)
	},
	setUniformLocationWith4f: function(b, c, d, e, f) {
		this._updateUniformLocation(b, [c, d, e, f]) && this._glContext.uniform4f(b, c, d, e, f)
	},
	setUniformLocationWith2fv: function(b, c, d) {
		this._updateUniformLocation(b, c) && this._glContext.uniform2fv(b, c)
	},
	setUniformLocationWith3fv: function(b, c, d) {
		this._updateUniformLocation(b, c) && this._glContext.uniform3fv(b, c)
	},
	setUniformLocationWith4fv: function(b, c, d) {
		this._updateUniformLocation(b, c) && this._glContext.uniform4fv(b, c)
	},
	setUniformLocationWithMatrix4fv: function(b, c, d) {
		this._updateUniformLocation(b, c) && this._glContext.uniformMatrix4fv(b, !1, c)
	},
	setUniformLocationF32: function() {
		if (!(2 > arguments.length)) {
			switch (arguments.length) {
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
		}
	},
	setUniformsForBuiltins: function() {
		var b = new cc.math.Matrix4,
			c = new cc.math.Matrix4,
			d = new cc.math.Matrix4;
		cc.kmGLGetMatrix(cc.KM_GL_PROJECTION, b);
		cc.kmGLGetMatrix(cc.KM_GL_MODELVIEW, c);
		cc.kmMat4Multiply(d, b, c);
		this.setUniformLocationWithMatrix4fv(this._uniforms[cc.UNIFORM_PMATRIX], b.mat, 1);
		this.setUniformLocationWithMatrix4fv(this._uniforms[cc.UNIFORM_MVMATRIX], c.mat, 1);
		this.setUniformLocationWithMatrix4fv(this._uniforms[cc.UNIFORM_MVPMATRIX], d.mat, 1);
		this._usesTime && (b = cc.director, b = b.getTotalFrames() * b.getAnimationInterval(), this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_TIME], b / 10, b, 2 * b, 4 * b), this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_SINTIME], b / 8, b / 4, b / 2, Math.sin(b)), this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_COSTIME], b / 8, b / 4, b / 2, Math.cos(b))); - 1 !== this._uniforms[cc.UNIFORM_RANDOM01] && this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_RANDOM01], Math.random(), Math.random(), Math.random(), Math.random())
	},
	_setUniformsForBuiltinsForRenderer: function(b) {
		if (b && b._renderCmd) {
			var c = new cc.math.Matrix4,
				d = new cc.math.Matrix4;
			cc.kmGLGetMatrix(cc.KM_GL_PROJECTION, c);
			cc.kmMat4Multiply(d, c, b._renderCmd._stackMatrix);
			this.setUniformLocationWithMatrix4fv(this._uniforms[cc.UNIFORM_PMATRIX], c.mat, 1);
			this.setUniformLocationWithMatrix4fv(this._uniforms[cc.UNIFORM_MVMATRIX], b._renderCmd._stackMatrix.mat, 1);
			this.setUniformLocationWithMatrix4fv(this._uniforms[cc.UNIFORM_MVPMATRIX], d.mat, 1);
			this._usesTime && (b = cc.director, b = b.getTotalFrames() * b.getAnimationInterval(), this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_TIME], b / 10, b, 2 * b, 4 * b), this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_SINTIME], b / 8, b / 4, b / 2, Math.sin(b)), this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_COSTIME], b / 8, b / 4, b / 2, Math.cos(b))); - 1 !== this._uniforms[cc.UNIFORM_RANDOM01] && this.setUniformLocationWith4f(this._uniforms[cc.UNIFORM_RANDOM01], Math.random(), Math.random(), Math.random(), Math.random())
		}
	},
	setUniformForModelViewProjectionMatrix: function() {
		this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_MVPMATRIX], !1, cc.getMat4MultiplyValue(cc.projection_matrix_stack.top, cc.modelview_matrix_stack.top))
	},
	setUniformForModelViewProjectionMatrixWithMat4: function(b) {
		cc.kmMat4Multiply(b, cc.projection_matrix_stack.top, cc.modelview_matrix_stack.top);
		this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_MVPMATRIX], !1, b.mat)
	},
	setUniformForModelViewAndProjectionMatrixWithMat4: function() {
		this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_MVMATRIX], !1, cc.modelview_matrix_stack.top.mat);
		this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_PMATRIX], !1, cc.projection_matrix_stack.top.mat)
	},
	_setUniformForMVPMatrixWithMat4: function(b) {
		if (!b) {
			throw "modelView matrix is undefined."
		}
		this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_MVMATRIX], !1, b.mat);
		this._glContext.uniformMatrix4fv(this._uniforms[cc.UNIFORM_PMATRIX], !1, cc.projection_matrix_stack.top.mat)
	},
	vertexShaderLog: function() {
		return this._glContext.getShaderInfoLog(this._vertShader)
	},
	getVertexShaderLog: function() {
		return this._glContext.getShaderInfoLog(this._vertShader)
	},
	getFragmentShaderLog: function() {
		return this._glContext.getShaderInfoLog(this._vertShader)
	},
	fragmentShaderLog: function() {
		return this._glContext.getShaderInfoLog(this._fragShader)
	},
	programLog: function() {
		return this._glContext.getProgramInfoLog(this._programObj)
	},
	getProgramLog: function() {
		return this._glContext.getProgramInfoLog(this._programObj)
	},
	reset: function() {
		this._fragShader = this._vertShader = null;
		this._uniforms.length = 0;
		this._glContext.deleteProgram(this._programObj);
		this._programObj = null;
		for (var b = 0; b < this._hashForUniforms.length; b++) {
			this._hashForUniforms[b].value = null, this._hashForUniforms[b] = null
		}
		this._hashForUniforms.length = 0
	},
	getProgram: function() {
		return this._programObj
	},
	retain: function() {},
	release: function() {}
});
cc.GLProgram.create = function(b, c) {
	return new cc.GLProgram(b, c)
};
cc.GLProgram._highpSupported = null;
cc.GLProgram._isHighpSupported = function() {
	if (null == cc.GLProgram._highpSupported) {
		var b = cc._renderContext,
			b = b.getShaderPrecisionFormat(b.FRAGMENT_SHADER, b.HIGH_FLOAT);
		cc.GLProgram._highpSupported = 0 !== b.precision
	}
	return cc.GLProgram._highpSupported
};
cc.setProgram = function(b, c) {
	b.shaderProgram = c;
	var d = b.children;
	if (d) {
		for (var e = 0; e < d.length; e++) {
			cc.setProgram(d[e], c)
		}
	}
};
cc._currentProjectionMatrix = -1;
cc._vertexAttribPosition = !1;
cc._vertexAttribColor = !1;
cc._vertexAttribTexCoords = !1;
cc.ENABLE_GL_STATE_CACHE && (cc.MAX_ACTIVETEXTURE = 16, cc._currentShaderProgram = -1, cc._currentBoundTexture = [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1], cc._blendingSource = -1, cc._blendingDest = -1, cc._GLServerState = 0, cc.TEXTURE_ATLAS_USE_VAO && (cc._uVAO = 0));
cc.glInvalidateStateCache = function() {
	cc.kmGLFreeAll();
	cc._currentProjectionMatrix = -1;
	cc._vertexAttribPosition = !1;
	cc._vertexAttribColor = !1;
	cc._vertexAttribTexCoords = !1;
	if (cc.ENABLE_GL_STATE_CACHE) {
		cc._currentShaderProgram = -1;
		for (var b = 0; b < cc.MAX_ACTIVETEXTURE; b++) {
			cc._currentBoundTexture[b] = -1
		}
		cc._blendingSource = -1;
		cc._blendingDest = -1;
		cc._GLServerState = 0
	}
};
cc.glUseProgram = function(b) {
	b !== cc._currentShaderProgram && (cc._currentShaderProgram = b, cc._renderContext.useProgram(b))
};
cc.ENABLE_GL_STATE_CACHE || (cc.glUseProgram = function(b) {
	cc._renderContext.useProgram(b)
});
cc.glDeleteProgram = function(b) {
	cc.ENABLE_GL_STATE_CACHE && b === cc._currentShaderProgram && (cc._currentShaderProgram = -1);
	gl.deleteProgram(b)
};
cc.glBlendFunc = function(b, c) {
	if (b !== cc._blendingSource || c !== cc._blendingDest) {
		cc._blendingSource = b, cc._blendingDest = c, cc.setBlending(b, c)
	}
};
cc.setBlending = function(b, c) {
	var d = cc._renderContext;
	b === d.ONE && c === d.ZERO ? d.disable(d.BLEND) : (d.enable(d.BLEND), cc._renderContext.blendFunc(b, c))
};
cc.glBlendFuncForParticle = function(b, c) {
	if (b !== cc._blendingSource || c !== cc._blendingDest) {
		cc._blendingSource = b;
		cc._blendingDest = c;
		var d = cc._renderContext;
		b === d.ONE && c === d.ZERO ? d.disable(d.BLEND) : (d.enable(d.BLEND), d.blendFuncSeparate(d.SRC_ALPHA, c, b, c))
	}
};
cc.ENABLE_GL_STATE_CACHE || (cc.glBlendFunc = cc.setBlending);
cc.glBlendResetToCache = function() {
	var b = cc._renderContext;
	b.blendEquation(b.FUNC_ADD);
	cc.ENABLE_GL_STATE_CACHE ? cc.setBlending(cc._blendingSource, cc._blendingDest) : cc.setBlending(b.BLEND_SRC, b.BLEND_DST)
};
cc.setProjectionMatrixDirty = function() {
	cc._currentProjectionMatrix = -1
};
cc.glEnableVertexAttribs = function(b) {
	var c = cc._renderContext,
		d = b & cc.VERTEX_ATTRIB_FLAG_POSITION;
	d !== cc._vertexAttribPosition && (d ? c.enableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION) : c.disableVertexAttribArray(cc.VERTEX_ATTRIB_POSITION), cc._vertexAttribPosition = d);
	d = b & cc.VERTEX_ATTRIB_FLAG_COLOR;
	d !== cc._vertexAttribColor && (d ? c.enableVertexAttribArray(cc.VERTEX_ATTRIB_COLOR) : c.disableVertexAttribArray(cc.VERTEX_ATTRIB_COLOR), cc._vertexAttribColor = d);
	b &= cc.VERTEX_ATTRIB_FLAG_TEX_COORDS;
	b !== cc._vertexAttribTexCoords && (b ? c.enableVertexAttribArray(cc.VERTEX_ATTRIB_TEX_COORDS) : c.disableVertexAttribArray(cc.VERTEX_ATTRIB_TEX_COORDS), cc._vertexAttribTexCoords = b)
};
cc.glBindTexture2D = function(b) {
	cc.glBindTexture2DN(0, b)
};
cc.glBindTexture2DN = function(b, c) {
	if (cc._currentBoundTexture[b] !== c) {
		cc._currentBoundTexture[b] = c;
		var d = cc._renderContext;
		d.activeTexture(d.TEXTURE0 + b);
		c ? d.bindTexture(d.TEXTURE_2D, c._webTextureObj) : d.bindTexture(d.TEXTURE_2D, null)
	}
};
cc.ENABLE_GL_STATE_CACHE || (cc.glBindTexture2DN = function(b, c) {
	var d = cc._renderContext;
	d.activeTexture(d.TEXTURE0 + b);
	c ? d.bindTexture(d.TEXTURE_2D, c._webTextureObj) : d.bindTexture(d.TEXTURE_2D, null)
});
cc.glDeleteTexture = function(b) {
	cc.glDeleteTextureN(0, b)
};
cc.glDeleteTextureN = function(b, c) {
	cc.ENABLE_GL_STATE_CACHE && c === cc._currentBoundTexture[b] && (cc._currentBoundTexture[b] = -1);
	cc._renderContext.deleteTexture(c)
};
cc.glBindVAO = function(b) {
	cc.TEXTURE_ATLAS_USE_VAO && cc.ENABLE_GL_STATE_CACHE && cc._uVAO !== b && (cc._uVAO = b)
};
cc.glEnable = function(b) {};
cc.v2fzero = function() {
	return {
		x: 0,
		y: 0
	}
};
cc.v2f = function(b, c) {
	return {
		x: b,
		y: c
	}
};
cc.v2fadd = function(b, c) {
	return cc.v2f(b.x + c.x, b.y + c.y)
};
cc.v2fsub = function(b, c) {
	return cc.v2f(b.x - c.x, b.y - c.y)
};
cc.v2fmult = function(b, c) {
	return cc.v2f(b.x * c, b.y * c)
};
cc.v2fperp = function(b) {
	return cc.v2f(-b.y, b.x)
};
cc.v2fneg = function(b) {
	return cc.v2f(-b.x, -b.y)
};
cc.v2fdot = function(b, c) {
	return b.x * c.x + b.y * c.y
};
cc.v2fforangle = function(b) {
	return cc.v2f(Math.cos(b), Math.sin(b))
};
cc.v2fnormalize = function(b) {
	b = cc.pNormalize(cc.p(b.x, b.y));
	return cc.v2f(b.x, b.y)
};
cc.__v2f = function(b) {
	return cc.v2f(b.x, b.y)
};
cc.__t = function(b) {
	return {
		u: b.x,
		v: b.y
	}
};
cc.DrawNodeCanvas = cc.Node.extend({
	_buffer: null,
	_blendFunc: null,
	_lineWidth: 1,
	_drawColor: null,
	_className: "DrawNodeCanvas",
	ctor: function() {
		cc.Node.prototype.ctor.call(this);
		var b = this._renderCmd;
		b._buffer = this._buffer = [];
		b._drawColor = this._drawColor = cc.color(255, 255, 255, 255);
		b._blendFunc = this._blendFunc = new cc.BlendFunc(cc.BLEND_SRC, cc.BLEND_DST);
		this.init()
	},
	getBlendFunc: function() {
		return this._blendFunc
	},
	setBlendFunc: function(b, c) {
		void 0 === c ? (this._blendFunc.src = b.src, this._blendFunc.dst = b.dst) : (this._blendFunc.src = b, this._blendFunc.dst = c)
	},
	setLineWidth: function(b) {
		this._lineWidth = b
	},
	getLineWidth: function() {
		return this._lineWidth
	},
	setDrawColor: function(b) {
		var c = this._drawColor;
		c.r = b.r;
		c.g = b.g;
		c.b = b.b;
		c.a = null == b.a ? 255 : b.a
	},
	getDrawColor: function() {
		return cc.color(this._drawColor.r, this._drawColor.g, this._drawColor.b, this._drawColor.a)
	},
	drawRect: function(b, c, d, e, f) {
		e = null == e ? this._lineWidth : e;
		f = f || this.getDrawColor();
		null == f.a && (f.a = 255);
		b = [b, cc.p(c.x, b.y), c, cc.p(b.x, c.y)];
		c = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
		c.verts = b;
		c.lineWidth = e;
		c.lineColor = f;
		c.isClosePolygon = !0;
		c.isStroke = !0;
		c.lineCap = "butt";
		if (c.fillColor = d) {
			null == d.a && (d.a = 255), c.isFill = !0
		}
		this._buffer.push(c)
	},
	drawCircle: function(b, c, d, e, f, g, h) {
		g = g || this._lineWidth;
		h = h || this.getDrawColor();
		null == h.a && (h.a = 255);
		for (var k = 2 * Math.PI / e, m = [], n = 0; n <= e; n++) {
			var p = n * k,
				r = c * Math.cos(p + d) + b.x,
				p = c * Math.sin(p + d) + b.y;
			m.push(cc.p(r, p))
		}
		f && m.push(cc.p(b.x, b.y));
		b = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
		b.verts = m;
		b.lineWidth = g;
		b.lineColor = h;
		b.isClosePolygon = !0;
		b.isStroke = !0;
		this._buffer.push(b)
	},
	drawQuadBezier: function(b, c, d, e, f, g) {
		f = f || this._lineWidth;
		g = g || this.getDrawColor();
		null == g.a && (g.a = 255);
		for (var h = [], k = 0, m = 0; m < e; m++) {
			var n = Math.pow(1 - k, 2) * b.x + 2 * (1 - k) * k * c.x + k * k * d.x,
				p = Math.pow(1 - k, 2) * b.y + 2 * (1 - k) * k * c.y + k * k * d.y;
			h.push(cc.p(n, p));
			k += 1 / e
		}
		h.push(cc.p(d.x, d.y));
		b = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
		b.verts = h;
		b.lineWidth = f;
		b.lineColor = g;
		b.isStroke = !0;
		b.lineCap = "round";
		this._buffer.push(b)
	},
	drawCubicBezier: function(b, c, d, e, f, g, h) {
		g = g || this._lineWidth;
		h = h || this.getDrawColor();
		null == h.a && (h.a = 255);
		for (var k = [], m = 0, n = 0; n < f; n++) {
			var p = Math.pow(1 - m, 3) * b.x + 3 * Math.pow(1 - m, 2) * m * c.x + 3 * (1 - m) * m * m * d.x + m * m * m * e.x,
				r = Math.pow(1 - m, 3) * b.y + 3 * Math.pow(1 - m, 2) * m * c.y + 3 * (1 - m) * m * m * d.y + m * m * m * e.y;
			k.push(cc.p(p, r));
			m += 1 / f
		}
		k.push(cc.p(e.x, e.y));
		b = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
		b.verts = k;
		b.lineWidth = g;
		b.lineColor = h;
		b.isStroke = !0;
		b.lineCap = "round";
		this._buffer.push(b)
	},
	drawCatmullRom: function(b, c, d, e) {
		this.drawCardinalSpline(b, 0.5, c, d, e)
	},
	drawCardinalSpline: function(b, c, d, e, f) {
		e = e || this._lineWidth;
		f = f || this.getDrawColor();
		null == f.a && (f.a = 255);
		for (var g = [], h, k, m = 1 / b.length, n = 0; n < d + 1; n++) {
			k = n / d, 1 === k ? (h = b.length - 1, k = 1) : (h = 0 | k / m, k = (k - m * h) / m), h = cc.cardinalSplineAt(cc.getControlPointAt(b, h - 1), cc.getControlPointAt(b, h - 0), cc.getControlPointAt(b, h + 1), cc.getControlPointAt(b, h + 2), c, k), g.push(h)
		}
		b = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
		b.verts = g;
		b.lineWidth = e;
		b.lineColor = f;
		b.isStroke = !0;
		b.lineCap = "round";
		this._buffer.push(b)
	},
	drawDot: function(b, c, d) {
		d = d || this.getDrawColor();
		null == d.a && (d.a = 255);
		var e = new cc._DrawNodeElement(cc.DrawNode.TYPE_DOT);
		e.verts = [b];
		e.lineWidth = c;
		e.fillColor = d;
		this._buffer.push(e)
	},
	drawDots: function(b, c, d) {
		if (b && 0 != b.length) {
			d = d || this.getDrawColor();
			null == d.a && (d.a = 255);
			for (var e = 0, f = b.length; e < f; e++) {
				this.drawDot(b[e], c, d)
			}
		}
	},
	drawSegment: function(b, c, d, e) {
		d = d || this._lineWidth;
		e = e || this.getDrawColor();
		null == e.a && (e.a = 255);
		var f = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
		f.verts = [b, c];
		f.lineWidth = 2 * d;
		f.lineColor = e;
		f.isStroke = !0;
		f.lineCap = "round";
		this._buffer.push(f)
	},
	drawPoly_: function(b, c, d, e) {
		d = null == d ? this._lineWidth : d;
		e = e || this.getDrawColor();
		null == e.a && (e.a = 255);
		var f = new cc._DrawNodeElement(cc.DrawNode.TYPE_POLY);
		f.verts = b;
		f.fillColor = c;
		f.lineWidth = d;
		f.lineColor = e;
		f.isClosePolygon = !0;
		f.isStroke = !0;
		f.lineCap = "round";
		c && (f.isFill = !0);
		this._buffer.push(f)
	},
	drawPoly: function(b, c, d, e) {
		for (var f = [], g = 0; g < b.length; g++) {
			f.push(cc.p(b[g].x, b[g].y))
		}
		return this.drawPoly_(f, c, d, e)
	},
	clear: function() {
		this._buffer.length = 0
	},
	_createRenderCmd: function() {
		return new cc.DrawNode.CanvasRenderCmd(this)
	}
});
cc.DrawNodeWebGL = cc.Node.extend({
	_bufferCapacity: 0,
	_buffer: null,
	_trianglesArrayBuffer: null,
	_trianglesWebBuffer: null,
	_trianglesReader: null,
	_lineWidth: 1,
	_drawColor: null,
	_blendFunc: null,
	_dirty: !1,
	_className: "DrawNodeWebGL",
	getBlendFunc: function() {
		return this._blendFunc
	},
	setBlendFunc: function(b, c) {
		void 0 === c ? (this._blendFunc.src = b.src, this._blendFunc.dst = b.dst) : (this._blendFunc.src = b, this._blendFunc.dst = c)
	},
	ctor: function() {
		cc.Node.prototype.ctor.call(this);
		this._buffer = [];
		this._blendFunc = new cc.BlendFunc(cc.BLEND_SRC, cc.BLEND_DST);
		this._drawColor = cc.color(255, 255, 255, 255);
		this.init()
	},
	init: function() {
		return cc.Node.prototype.init.call(this) ? (this.shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_LENGTHTEXTURECOLOR), this._ensureCapacity(64), this._trianglesWebBuffer = cc._renderContext.createBuffer(), this._dirty = !0) : !1
	},
	setLineWidth: function(b) {
		this._lineWidth = b
	},
	getLineWidth: function() {
		return this._lineWidth
	},
	setDrawColor: function(b) {
		var c = this._drawColor;
		c.r = b.r;
		c.g = b.g;
		c.b = b.b;
		c.a = b.a
	},
	getDrawColor: function() {
		return cc.color(this._drawColor.r, this._drawColor.g, this._drawColor.b, this._drawColor.a)
	},
	drawRect: function(b, c, d, e, f) {
		e = null == e ? this._lineWidth : e;
		f = f || this.getDrawColor();
		null == f.a && (f.a = 255);
		b = [b, cc.p(c.x, b.y), c, cc.p(b.x, c.y)];
		null == d ? this._drawSegments(b, e, f, !0) : this.drawPoly(b, d, e, f)
	},
	drawCircle: function(b, c, d, e, f, g, h) {
		g = g || this._lineWidth;
		h = h || this.getDrawColor();
		null == h.a && (h.a = 255);
		var k = 2 * Math.PI / e,
			m = [],
			n;
		for (n = 0; n <= e; n++) {
			var p = n * k,
				r = c * Math.cos(p + d) + b.x,
				p = c * Math.sin(p + d) + b.y;
			m.push(cc.p(r, p))
		}
		f && m.push(cc.p(b.x, b.y));
		g *= 0.5;
		n = 0;
		for (b = m.length; n < b - 1; n++) {
			this.drawSegment(m[n], m[n + 1], g, h)
		}
	},
	drawQuadBezier: function(b, c, d, e, f, g) {
		f = f || this._lineWidth;
		g = g || this.getDrawColor();
		null == g.a && (g.a = 255);
		for (var h = [], k = 0, m = 0; m < e; m++) {
			var n = Math.pow(1 - k, 2) * b.x + 2 * (1 - k) * k * c.x + k * k * d.x,
				p = Math.pow(1 - k, 2) * b.y + 2 * (1 - k) * k * c.y + k * k * d.y;
			h.push(cc.p(n, p));
			k += 1 / e
		}
		h.push(cc.p(d.x, d.y));
		this._drawSegments(h, f, g, !1)
	},
	drawCubicBezier: function(b, c, d, e, f, g, h) {
		g = g || this._lineWidth;
		h = h || this.getDrawColor();
		null == h.a && (h.a = 255);
		for (var k = [], m = 0, n = 0; n < f; n++) {
			var p = Math.pow(1 - m, 3) * b.x + 3 * Math.pow(1 - m, 2) * m * c.x + 3 * (1 - m) * m * m * d.x + m * m * m * e.x,
				r = Math.pow(1 - m, 3) * b.y + 3 * Math.pow(1 - m, 2) * m * c.y + 3 * (1 - m) * m * m * d.y + m * m * m * e.y;
			k.push(cc.p(p, r));
			m += 1 / f
		}
		k.push(cc.p(e.x, e.y));
		this._drawSegments(k, g, h, !1)
	},
	drawCatmullRom: function(b, c, d, e) {
		this.drawCardinalSpline(b, 0.5, c, d, e)
	},
	drawCardinalSpline: function(b, c, d, e, f) {
		e = e || this._lineWidth;
		f = f || this.getDrawColor();
		null == f.a && (f.a = 255);
		for (var g = [], h, k, m = 1 / b.length, n = 0; n < d + 1; n++) {
			k = n / d, 1 === k ? (h = b.length - 1, k = 1) : (h = 0 | k / m, k = (k - m * h) / m), h = cc.cardinalSplineAt(cc.getControlPointAt(b, h - 1), cc.getControlPointAt(b, h - 0), cc.getControlPointAt(b, h + 1), cc.getControlPointAt(b, h + 2), c, k), g.push(h)
		}
		e *= 0.5;
		b = 0;
		for (c = g.length; b < c - 1; b++) {
			this.drawSegment(g[b], g[b + 1], e, f)
		}
	},
	_render: function() {
		var b = cc._renderContext;
		cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POS_COLOR_TEX);
		b.bindBuffer(b.ARRAY_BUFFER, this._trianglesWebBuffer);
		this._dirty && (b.bufferData(b.ARRAY_BUFFER, this._trianglesArrayBuffer, b.STREAM_DRAW), this._dirty = !1);
		var c = cc.V2F_C4B_T2F.BYTES_PER_ELEMENT;
		b.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 2, b.FLOAT, !1, c, 0);
		b.vertexAttribPointer(cc.VERTEX_ATTRIB_COLOR, 4, b.UNSIGNED_BYTE, !0, c, 8);
		b.vertexAttribPointer(cc.VERTEX_ATTRIB_TEX_COORDS, 2, b.FLOAT, !1, c, 12);
		b.drawArrays(b.TRIANGLES, 0, 3 * this._buffer.length);
		cc.incrementGLDraws(1)
	},
	_ensureCapacity: function(b) {
		var c = this._buffer;
		if (c.length + b > this._bufferCapacity) {
			var d = cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT;
			this._bufferCapacity += Math.max(this._bufferCapacity, b);
			if (null == c || 0 === c.length) {
				this._buffer = [], this._trianglesArrayBuffer = new ArrayBuffer(d * this._bufferCapacity), this._trianglesReader = new Uint8Array(this._trianglesArrayBuffer)
			} else {
				b = [];
				for (var e = new ArrayBuffer(d * this._bufferCapacity), f = 0; f < c.length; f++) {
					b[f] = new cc.V2F_C4B_T2F_Triangle(c[f].a, c[f].b, c[f].c, e, f * d)
				}
				this._trianglesReader = new Uint8Array(e);
				this._trianglesArrayBuffer = e;
				this._buffer = b
			}
		}
	},
	drawDot: function(b, c, d) {
		d = d || this.getDrawColor();
		null == d.a && (d.a = 255);
		var e = {
			r: 0 | d.r,
			g: 0 | d.g,
			b: 0 | d.b,
			a: 0 | d.a
		};
		d = {
			vertices: {
				x: b.x - c,
				y: b.y - c
			},
			colors: e,
			texCoords: {
				u: -1,
				v: -1
			}
		};
		var f = {
			vertices: {
				x: b.x - c,
				y: b.y + c
			},
			colors: e,
			texCoords: {
				u: -1,
				v: 1
			}
		},
			g = {
				vertices: {
					x: b.x + c,
					y: b.y + c
				},
				colors: e,
				texCoords: {
					u: 1,
					v: 1
				}
			};
		b = {
			vertices: {
				x: b.x + c,
				y: b.y - c
			},
			colors: e,
			texCoords: {
				u: 1,
				v: -1
			}
		};
		this._ensureCapacity(6);
		this._buffer.push(new cc.V2F_C4B_T2F_Triangle(d, f, g, this._trianglesArrayBuffer, this._buffer.length * cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT));
		this._buffer.push(new cc.V2F_C4B_T2F_Triangle(d, g, b, this._trianglesArrayBuffer, this._buffer.length * cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT));
		this._dirty = !0
	},
	drawDots: function(b, c, d) {
		if (b && 0 !== b.length) {
			d = d || this.getDrawColor();
			null == d.a && (d.a = 255);
			for (var e = 0, f = b.length; e < f; e++) {
				this.drawDot(b[e], c, d)
			}
		}
	},
	drawSegment: function(b, c, d, e) {
		e = e || this.getDrawColor();
		null == e.a && (e.a = 255);
		d = d || 0.5 * this._lineWidth;
		this._ensureCapacity(18);
		e = {
			r: 0 | e.r,
			g: 0 | e.g,
			b: 0 | e.b,
			a: 0 | e.a
		};
		var f = cc.__v2f(b),
			g = cc.__v2f(c);
		c = cc.v2fnormalize(cc.v2fperp(cc.v2fsub(g, f)));
		b = cc.v2fperp(c);
		var h = cc.v2fmult(c, d),
			k = cc.v2fmult(b, d);
		d = cc.v2fsub(g, cc.v2fadd(h, k));
		var m = cc.v2fadd(g, cc.v2fsub(h, k)),
			n = cc.v2fsub(g, h),
			g = cc.v2fadd(g, h),
			p = cc.v2fsub(f, h),
			r = cc.v2fadd(f, h),
			t = cc.v2fsub(f, cc.v2fsub(h, k)),
			f = cc.v2fadd(f, cc.v2fadd(h, k)),
			h = cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT,
			k = this._trianglesArrayBuffer,
			s = this._buffer;
		s.push(new cc.V2F_C4B_T2F_Triangle({
			vertices: d,
			colors: e,
			texCoords: cc.__t(cc.v2fneg(cc.v2fadd(c, b)))
		}, {
			vertices: m,
			colors: e,
			texCoords: cc.__t(cc.v2fsub(c, b))
		}, {
			vertices: n,
			colors: e,
			texCoords: cc.__t(cc.v2fneg(c))
		}, k, s.length * h));
		s.push(new cc.V2F_C4B_T2F_Triangle({
			vertices: g,
			colors: e,
			texCoords: cc.__t(c)
		}, {
			vertices: m,
			colors: e,
			texCoords: cc.__t(cc.v2fsub(c, b))
		}, {
			vertices: n,
			colors: e,
			texCoords: cc.__t(cc.v2fneg(c))
		}, k, s.length * h));
		s.push(new cc.V2F_C4B_T2F_Triangle({
			vertices: g,
			colors: e,
			texCoords: cc.__t(c)
		}, {
			vertices: p,
			colors: e,
			texCoords: cc.__t(cc.v2fneg(c))
		}, {
			vertices: n,
			colors: e,
			texCoords: cc.__t(cc.v2fneg(c))
		}, k, s.length * h));
		s.push(new cc.V2F_C4B_T2F_Triangle({
			vertices: g,
			colors: e,
			texCoords: cc.__t(c)
		}, {
			vertices: p,
			colors: e,
			texCoords: cc.__t(cc.v2fneg(c))
		}, {
			vertices: r,
			colors: e,
			texCoords: cc.__t(c)
		}, k, s.length * h));
		s.push(new cc.V2F_C4B_T2F_Triangle({
			vertices: t,
			colors: e,
			texCoords: cc.__t(cc.v2fsub(b, c))
		}, {
			vertices: p,
			colors: e,
			texCoords: cc.__t(cc.v2fneg(c))
		}, {
			vertices: r,
			colors: e,
			texCoords: cc.__t(c)
		}, k, s.length * h));
		s.push(new cc.V2F_C4B_T2F_Triangle({
			vertices: t,
			colors: e,
			texCoords: cc.__t(cc.v2fsub(b, c))
		}, {
			vertices: f,
			colors: e,
			texCoords: cc.__t(cc.v2fadd(c, b))
		}, {
			vertices: r,
			colors: e,
			texCoords: cc.__t(c)
		}, k, s.length * h));
		this._dirty = !0
	},
	drawPoly: function(b, c, d, e) {
		if (null == c) {
			this._drawSegments(b, d, e, !0)
		} else {
			null == c.a && (c.a = 255);
			null == e.a && (e.a = 255);
			d = null == d ? this._lineWidth : d;
			d *= 0.5;
			c = {
				r: 0 | c.r,
				g: 0 | c.g,
				b: 0 | c.b,
				a: 0 | c.a
			};
			e = {
				r: 0 | e.r,
				g: 0 | e.g,
				b: 0 | e.b,
				a: 0 | e.a
			};
			var f = [],
				g, h, k, m, n = b.length;
			for (g = 0; g < n; g++) {
				h = cc.__v2f(b[(g - 1 + n) % n]);
				k = cc.__v2f(b[g]);
				m = cc.__v2f(b[(g + 1) % n]);
				var p = cc.v2fnormalize(cc.v2fperp(cc.v2fsub(k, h)));
				k = cc.v2fnormalize(cc.v2fperp(cc.v2fsub(m, k)));
				p = cc.v2fmult(cc.v2fadd(p, k), 1 / (cc.v2fdot(p, k) + 1));
				f[g] = {
					offset: p,
					n: k
				}
			}
			p = 0 < d;
			this._ensureCapacity(3 * (3 * n - 2));
			var r = cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT,
				t = this._trianglesArrayBuffer,
				s = this._buffer,
				v = !1 == p ? 0.5 : 0;
			for (g = 0; g < n - 2; g++) {
				h = cc.v2fsub(cc.__v2f(b[0]), cc.v2fmult(f[0].offset, v)), k = cc.v2fsub(cc.__v2f(b[g + 1]), cc.v2fmult(f[g + 1].offset, v)), m = cc.v2fsub(cc.__v2f(b[g + 2]), cc.v2fmult(f[g + 2].offset, v)), s.push(new cc.V2F_C4B_T2F_Triangle({
					vertices: h,
					colors: c,
					texCoords: cc.__t(cc.v2fzero())
				}, {
					vertices: k,
					colors: c,
					texCoords: cc.__t(cc.v2fzero())
				}, {
					vertices: m,
					colors: c,
					texCoords: cc.__t(cc.v2fzero())
				}, t, s.length * r))
			}
			for (g = 0; g < n; g++) {
				v = (g + 1) % n;
				h = cc.__v2f(b[g]);
				k = cc.__v2f(b[v]);
				m = f[g].n;
				var u = f[g].offset,
					A = f[v].offset,
					v = p ? cc.v2fsub(h, cc.v2fmult(u, d)) : cc.v2fsub(h, cc.v2fmult(u, 0.5)),
					y = p ? cc.v2fsub(k, cc.v2fmult(A, d)) : cc.v2fsub(k, cc.v2fmult(A, 0.5));
				h = p ? cc.v2fadd(h, cc.v2fmult(u, d)) : cc.v2fadd(h, cc.v2fmult(u, 0.5));
				k = p ? cc.v2fadd(k, cc.v2fmult(A, d)) : cc.v2fadd(k, cc.v2fmult(A, 0.5));
				p ? (s.push(new cc.V2F_C4B_T2F_Triangle({
					vertices: v,
					colors: e,
					texCoords: cc.__t(cc.v2fneg(m))
				}, {
					vertices: y,
					colors: e,
					texCoords: cc.__t(cc.v2fneg(m))
				}, {
					vertices: k,
					colors: e,
					texCoords: cc.__t(m)
				}, t, s.length * r)), s.push(new cc.V2F_C4B_T2F_Triangle({
					vertices: v,
					colors: e,
					texCoords: cc.__t(cc.v2fneg(m))
				}, {
					vertices: h,
					colors: e,
					texCoords: cc.__t(m)
				}, {
					vertices: k,
					colors: e,
					texCoords: cc.__t(m)
				}, t, s.length * r))) : (s.push(new cc.V2F_C4B_T2F_Triangle({
					vertices: v,
					colors: c,
					texCoords: cc.__t(cc.v2fzero())
				}, {
					vertices: y,
					colors: c,
					texCoords: cc.__t(cc.v2fzero())
				}, {
					vertices: k,
					colors: c,
					texCoords: cc.__t(m)
				}, t, s.length * r)), s.push(new cc.V2F_C4B_T2F_Triangle({
					vertices: v,
					colors: c,
					texCoords: cc.__t(cc.v2fzero())
				}, {
					vertices: h,
					colors: c,
					texCoords: cc.__t(m)
				}, {
					vertices: k,
					colors: c,
					texCoords: cc.__t(m)
				}, t, s.length * r)))
			}
			this._dirty = !0
		}
	},
	_drawSegments: function(b, c, d, e) {
		c = null == c ? this._lineWidth : c;
		d = d || this._drawColor;
		null == d.a && (d.a = 255);
		c *= 0.5;
		if (!(0 >= c)) {
			d = {
				r: 0 | d.r,
				g: 0 | d.g,
				b: 0 | d.b,
				a: 0 | d.a
			};
			var f = [],
				g, h, k, m, n = b.length;
			for (g = 0; g < n; g++) {
				h = cc.__v2f(b[(g - 1 + n) % n]);
				k = cc.__v2f(b[g]);
				m = cc.__v2f(b[(g + 1) % n]);
				var p = cc.v2fnormalize(cc.v2fperp(cc.v2fsub(k, h)));
				k = cc.v2fnormalize(cc.v2fperp(cc.v2fsub(m, k)));
				m = cc.v2fmult(cc.v2fadd(p, k), 1 / (cc.v2fdot(p, k) + 1));
				f[g] = {
					offset: m,
					n: k
				}
			}
			this._ensureCapacity(3 * (3 * n - 2));
			m = cc.V2F_C4B_T2F_Triangle.BYTES_PER_ELEMENT;
			var p = this._trianglesArrayBuffer,
				r = this._buffer;
			e = e ? n : n - 1;
			for (g = 0; g < e; g++) {
				var t = (g + 1) % n;
				h = cc.__v2f(b[g]);
				k = cc.__v2f(b[t]);
				var s = f[g].n,
					v = f[g].offset,
					u = f[t].offset,
					t = cc.v2fsub(h, cc.v2fmult(v, c)),
					A = cc.v2fsub(k, cc.v2fmult(u, c));
				h = cc.v2fadd(h, cc.v2fmult(v, c));
				k = cc.v2fadd(k, cc.v2fmult(u, c));
				r.push(new cc.V2F_C4B_T2F_Triangle({
					vertices: t,
					colors: d,
					texCoords: cc.__t(cc.v2fneg(s))
				}, {
					vertices: A,
					colors: d,
					texCoords: cc.__t(cc.v2fneg(s))
				}, {
					vertices: k,
					colors: d,
					texCoords: cc.__t(s)
				}, p, r.length * m));
				r.push(new cc.V2F_C4B_T2F_Triangle({
					vertices: t,
					colors: d,
					texCoords: cc.__t(cc.v2fneg(s))
				}, {
					vertices: h,
					colors: d,
					texCoords: cc.__t(s)
				}, {
					vertices: k,
					colors: d,
					texCoords: cc.__t(s)
				}, p, r.length * m))
			}
			this._dirty = !0
		}
	},
	clear: function() {
		this._buffer.length = 0;
		this._dirty = !0
	},
	_createRenderCmd: function() {
		return new cc.DrawNode.WebGLRenderCmd(this)
	}
});
cc.DrawNode = cc._renderType === cc._RENDER_TYPE_WEBGL ? cc.DrawNodeWebGL : cc.DrawNodeCanvas;
cc.DrawNode.create = function() {
	return new cc.DrawNode
};
cc._DrawNodeElement = function(b, c, d, e, f, g, h, k, m) {
	this.type = b;
	this.verts = c || null;
	this.fillColor = d || null;
	this.lineWidth = e || 0;
	this.lineColor = f || null;
	this.lineCap = g || "butt";
	this.isClosePolygon = h || !1;
	this.isFill = k || !1;
	this.isStroke = m || !1
};
cc.DrawNode.TYPE_DOT = 0;
cc.DrawNode.TYPE_SEGMENT = 1;
cc.DrawNode.TYPE_POLY = 2;
(function() {
	cc.DrawNode.CanvasRenderCmd = function(b) {
		cc.Node.CanvasRenderCmd.call(this, b);
		this._needDraw = !0;
		this._blendFunc = this._drawColor = this._buffer = null
	};
	cc.DrawNode.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
	cc.DrawNode.CanvasRenderCmd.prototype.constructor = cc.DrawNode.CanvasRenderCmd;
	cc.DrawNode.CanvasRenderCmd.prototype.rendering = function(b, c, d) {
		b = b || cc._renderContext;
		b.getContext();
		var e = this._node._displayedOpacity / 255;
		if (0 !== e) {
			b.setTransform(this._worldTransform, c, d);
			b.setGlobalAlpha(e);
			this._blendFunc && this._blendFunc.src === cc.SRC_ALPHA && this._blendFunc.dst === cc.ONE && b.setCompositeOperation("lighter");
			for (var e = this._buffer, f = 0, g = e.length; f < g; f++) {
				var h = e[f];
				switch (h.type) {
				case cc.DrawNode.TYPE_DOT:
					this._drawDot(b, h, c, d);
					break;
				case cc.DrawNode.TYPE_SEGMENT:
					this._drawSegment(b, h, c, d);
					break;
				case cc.DrawNode.TYPE_POLY:
					this._drawPoly(b, h, c, d)
				}
			}
		}
	};
	cc.DrawNode.CanvasRenderCmd.prototype._drawDot = function(b, c, d, e) {
		var f = c.fillColor,
			g = c.verts[0];
		c = c.lineWidth;
		var h = b.getContext();
		b.setFillStyle("rgba(" + (0 | f.r) + "," + (0 | f.g) + "," + (0 | f.b) + "," + f.a / 255 + ")");
		h.beginPath();
		h.arc(g.x * d, -g.y * e, c * d, 0, 2 * Math.PI, !1);
		h.closePath();
		h.fill()
	};
	cc.DrawNode.CanvasRenderCmd.prototype._drawSegment = function(b, c, d, e) {
		var f = c.lineColor,
			g = c.verts[0],
			h = c.verts[1],
			k = c.lineWidth;
		c = c.lineCap;
		var m = b.getContext();
		b.setStrokeStyle("rgba(" + (0 | f.r) + "," + (0 | f.g) + "," + (0 | f.b) + "," + f.a / 255 + ")");
		m.lineWidth = k * d;
		m.beginPath();
		m.lineCap = c;
		m.moveTo(g.x * d, -g.y * e);
		m.lineTo(h.x * d, -h.y * e);
		m.stroke()
	};
	cc.DrawNode.CanvasRenderCmd.prototype._drawPoly = function(b, c, d, e) {
		var f = c.verts,
			g = c.lineCap;
		if (null != f) {
			var h = c.fillColor,
				k = c.lineWidth,
				m = c.lineColor,
				n = c.isClosePolygon,
				p = c.isFill;
			c = c.isStroke;
			var r = b.getContext(),
				t = f[0];
			r.lineCap = g;
			h && b.setFillStyle("rgba(" + (0 | h.r) + "," + (0 | h.g) + "," + (0 | h.b) + "," + h.a / 255 + ")");
			k && (r.lineWidth = k * d);
			m && b.setStrokeStyle("rgba(" + (0 | m.r) + "," + (0 | m.g) + "," + (0 | m.b) + "," + m.a / 255 + ")");
			r.beginPath();
			r.moveTo(t.x * d, -t.y * e);
			b = 1;
			for (g = f.length; b < g; b++) {
				r.lineTo(f[b].x * d, -f[b].y * e)
			}
			n && r.closePath();
			p && r.fill();
			c && r.stroke()
		}
	}
})();
(function() {
	cc.DrawNode.WebGLRenderCmd = function(b) {
		cc.Node.WebGLRenderCmd.call(this, b);
		this._needDraw = !0
	};
	cc.DrawNode.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
	cc.DrawNode.WebGLRenderCmd.prototype.constructor = cc.DrawNode.WebGLRenderCmd;
	cc.DrawNode.WebGLRenderCmd.prototype.rendering = function(b) {
		b = this._node;
		cc.glBlendFunc(b._blendFunc.src, b._blendFunc.dst);
		this._shaderProgram.use();
		this._shaderProgram._setUniformForMVPMatrixWithMat4(this._stackMatrix);
		b._render()
	}
})();
cc.ACTION_TAG_INVALID = -1;
cc.Action = cc.Class.extend({
	originalTarget: null,
	target: null,
	tag: cc.ACTION_TAG_INVALID,
	ctor: function() {
		this.target = this.originalTarget = null;
		this.tag = cc.ACTION_TAG_INVALID
	},
	copy: function() {
		cc.log("copy is deprecated. Please use clone instead.");
		return this.clone()
	},
	clone: function() {
		var b = new cc.Action;
		b.originalTarget = null;
		b.target = null;
		b.tag = this.tag;
		return b
	},
	isDone: function() {
		return !0
	},
	startWithTarget: function(b) {
		this.target = this.originalTarget = b
	},
	stop: function() {
		this.target = null
	},
	step: function(b) {
		cc.log("[Action step]. override me")
	},
	update: function(b) {
		cc.log("[Action update]. override me")
	},
	getTarget: function() {
		return this.target
	},
	setTarget: function(b) {
		this.target = b
	},
	getOriginalTarget: function() {
		return this.originalTarget
	},
	setOriginalTarget: function(b) {
		this.originalTarget = b
	},
	getTag: function() {
		return this.tag
	},
	setTag: function(b) {
		this.tag = b
	},
	retain: function() {},
	release: function() {}
});
cc.action = function() {
	return new cc.Action
};
cc.Action.create = cc.action;
cc.FiniteTimeAction = cc.Action.extend({
	_duration: 0,
	ctor: function() {
		cc.Action.prototype.ctor.call(this);
		this._duration = 0
	},
	getDuration: function() {
		return this._duration * (this._timesForRepeat || 1)
	},
	setDuration: function(b) {
		this._duration = b
	},
	reverse: function() {
		cc.log("cocos2d: FiniteTimeAction#reverse: Implement me");
		return null
	},
	clone: function() {
		return new cc.FiniteTimeAction
	}
});
cc.Speed = cc.Action.extend({
	_speed: 0,
	_innerAction: null,
	ctor: function(b, c) {
		cc.Action.prototype.ctor.call(this);
		this._speed = 0;
		this._innerAction = null;
		b && this.initWithAction(b, c)
	},
	getSpeed: function() {
		return this._speed
	},
	setSpeed: function(b) {
		this._speed = b
	},
	initWithAction: function(b, c) {
		if (!b) {
			throw "cc.Speed.initWithAction(): action must be non nil"
		}
		this._innerAction = b;
		this._speed = c;
		return !0
	},
	clone: function() {
		var b = new cc.Speed;
		b.initWithAction(this._innerAction.clone(), this._speed);
		return b
	},
	startWithTarget: function(b) {
		cc.Action.prototype.startWithTarget.call(this, b);
		this._innerAction.startWithTarget(b)
	},
	stop: function() {
		this._innerAction.stop();
		cc.Action.prototype.stop.call(this)
	},
	step: function(b) {
		this._innerAction.step(b * this._speed)
	},
	isDone: function() {
		return this._innerAction.isDone()
	},
	reverse: function() {
		return new cc.Speed(this._innerAction.reverse(), this._speed)
	},
	setInnerAction: function(b) {
		this._innerAction !== b && (this._innerAction = b)
	},
	getInnerAction: function() {
		return this._innerAction
	}
});
cc.speed = function(b, c) {
	return new cc.Speed(b, c)
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
	ctor: function(b, c) {
		cc.Action.prototype.ctor.call(this);
		this._followedNode = null;
		this._boundaryFullyCovered = this._boundarySet = !1;
		this._fullScreenSize = this._halfScreenSize = null;
		this.bottomBoundary = this.topBoundary = this.rightBoundary = this.leftBoundary = 0;
		this._worldRect = cc.rect(0, 0, 0, 0);
		b && (c ? this.initWithTarget(b, c) : this.initWithTarget(b))
	},
	clone: function() {
		var b = new cc.Follow,
			c = this._worldRect,
			c = new cc.Rect(c.x, c.y, c.width, c.height);
		b.initWithTarget(this._followedNode, c);
		return b
	},
	isBoundarySet: function() {
		return this._boundarySet
	},
	setBoudarySet: function(b) {
		this._boundarySet = b
	},
	initWithTarget: function(b, c) {
		if (!b) {
			throw "cc.Follow.initWithAction(): followedNode must be non nil"
		}
		c = c || cc.rect(0, 0, 0, 0);
		this._followedNode = b;
		this._worldRect = c;
		this._boundarySet = !cc._rectEqualToZero(c);
		this._boundaryFullyCovered = !1;
		var d = cc.director.getWinSize();
		this._fullScreenSize = cc.p(d.width, d.height);
		this._halfScreenSize = cc.pMult(this._fullScreenSize, 0.5);
		this._boundarySet && (this.leftBoundary = -(c.x + c.width - this._fullScreenSize.x), this.rightBoundary = -c.x, this.topBoundary = -c.y, this.bottomBoundary = -(c.y + c.height - this._fullScreenSize.y), this.rightBoundary < this.leftBoundary && (this.rightBoundary = this.leftBoundary = (this.leftBoundary + this.rightBoundary) / 2), this.topBoundary < this.bottomBoundary && (this.topBoundary = this.bottomBoundary = (this.topBoundary + this.bottomBoundary) / 2), this.topBoundary === this.bottomBoundary && this.leftBoundary === this.rightBoundary && (this._boundaryFullyCovered = !0));
		return !0
	},
	step: function(b) {
		b = this._followedNode.x;
		var c = this._followedNode.y;
		b = this._halfScreenSize.x - b;
		c = this._halfScreenSize.y - c;
		this.target._renderCmd._dirtyFlag = 0;
		this._boundarySet ? this._boundaryFullyCovered || this.target.setPosition(cc.clampf(b, this.leftBoundary, this.rightBoundary), cc.clampf(c, this.bottomBoundary, this.topBoundary)) : this.target.setPosition(b, c)
	},
	isDone: function() {
		return !this._followedNode.running
	},
	stop: function() {
		this.target = null;
		cc.Action.prototype.stop.call(this)
	}
});
cc.follow = function(b, c) {
	return new cc.Follow(b, c)
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
	ctor: function(b) {
		this._timesForRepeat = this._speed = 1;
		this._repeatForever = !1;
		this.MAX_VALUE = 2;
		this._speedMethod = this._repeatMethod = !1;
		cc.FiniteTimeAction.prototype.ctor.call(this);
		void 0 !== b && this.initWithDuration(b)
	},
	getElapsed: function() {
		return this._elapsed
	},
	initWithDuration: function(b) {
		this._duration = 0 === b ? cc.FLT_EPSILON : b;
		this._elapsed = 0;
		return this._firstTick = !0
	},
	isDone: function() {
		return this._elapsed >= this._duration
	},
	_cloneDecoration: function(b) {
		b._repeatForever = this._repeatForever;
		b._speed = this._speed;
		b._timesForRepeat = this._timesForRepeat;
		b._easeList = this._easeList;
		b._speedMethod = this._speedMethod;
		b._repeatMethod = this._repeatMethod
	},
	_reverseEaseList: function(b) {
		if (this._easeList) {
			b._easeList = [];
			for (var c = 0; c < this._easeList.length; c++) {
				b._easeList.push(this._easeList[c].reverse())
			}
		}
	},
	clone: function() {
		var b = new cc.ActionInterval(this._duration);
		this._cloneDecoration(b);
		return b
	},
	easing: function(b) {
		this._easeList ? this._easeList.length = 0 : this._easeList = [];
		for (var c = 0; c < arguments.length; c++) {
			this._easeList.push(arguments[c])
		}
		return this
	},
	_computeEaseTime: function(b) {
		var c = this._easeList;
		if (!c || 0 === c.length) {
			return b
		}
		for (var d = 0, e = c.length; d < e; d++) {
			b = c[d].easing(b)
		}
		return b
	},
	step: function(b) {
		this._firstTick ? (this._firstTick = !1, this._elapsed = 0) : this._elapsed += b;
		b = this._elapsed / (1.192092896e-7 < this._duration ? this._duration : 1.192092896e-7);
		b = 1 > b ? b : 1;
		this.update(0 < b ? b : 0);
		this._repeatMethod && 1 < this._timesForRepeat && this.isDone() && (this._repeatForever || this._timesForRepeat--, this.startWithTarget(this.target), this.step(this._elapsed - this._duration))
	},
	startWithTarget: function(b) {
		cc.Action.prototype.startWithTarget.call(this, b);
		this._elapsed = 0;
		this._firstTick = !0
	},
	reverse: function() {
		cc.log("cc.IntervalAction: reverse not implemented.");
		return null
	},
	setAmplitudeRate: function(b) {
		cc.log("cc.ActionInterval.setAmplitudeRate(): it should be overridden in subclass.")
	},
	getAmplitudeRate: function() {
		cc.log("cc.ActionInterval.getAmplitudeRate(): it should be overridden in subclass.");
		return 0
	},
	speed: function(b) {
		if (0 >= b) {
			return cc.log("The speed parameter error"), this
		}
		this._speedMethod = !0;
		this._speed *= b;
		return this
	},
	getSpeed: function() {
		return this._speed
	},
	setSpeed: function(b) {
		this._speed = b;
		return this
	},
	repeat: function(b) {
		b = Math.round(b);
		if (isNaN(b) || 1 > b) {
			return cc.log("The repeat parameter error"), this
		}
		this._repeatMethod = !0;
		this._timesForRepeat *= b;
		return this
	},
	repeatForever: function() {
		this._repeatMethod = !0;
		this._timesForRepeat = this.MAX_VALUE;
		this._repeatForever = !0;
		return this
	}
});
cc.actionInterval = function(b) {
	return new cc.ActionInterval(b)
};
cc.ActionInterval.create = cc.actionInterval;
cc.Sequence = cc.ActionInterval.extend({
	_actions: null,
	_split: null,
	_last: 0,
	ctor: function(b) {
		cc.ActionInterval.prototype.ctor.call(this);
		this._actions = [];
		var c = b instanceof Array ? b : arguments,
			d = c.length - 1;
		0 <= d && null == c[d] && cc.log("parameters should not be ending with null in Javascript");
		if (0 <= d) {
			for (var e = c[0], f = 1; f < d; f++) {
				c[f] && (e = cc.Sequence._actionOneTwo(e, c[f]))
			}
			this.initWithTwoActions(e, c[d])
		}
	},
	initWithTwoActions: function(b, c) {
		if (!b || !c) {
			throw "cc.Sequence.initWithTwoActions(): arguments must all be non nil"
		}
		this.initWithDuration(b._duration + c._duration);
		this._actions[0] = b;
		this._actions[1] = c;
		return !0
	},
	clone: function() {
		var b = new cc.Sequence;
		this._cloneDecoration(b);
		b.initWithTwoActions(this._actions[0].clone(), this._actions[1].clone());
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._split = this._actions[0]._duration / this._duration;
		this._last = -1
	},
	stop: function() {
		-1 !== this._last && this._actions[this._last].stop();
		cc.Action.prototype.stop.call(this)
	},
	update: function(b) {
		var c = 0,
			d = this._split,
			e = this._actions,
			f = this._last;
		b = this._computeEaseTime(b);
		b < d ? (b = 0 !== d ? b / d : 1, 0 === c && 1 === f && (e[1].update(0), e[1].stop())) : (c = 1, b = 1 === d ? 1 : (b - d) / (1 - d), -1 === f && (e[0].startWithTarget(this.target), e[0].update(1), e[0].stop()), f || (e[0].update(1), e[0].stop()));
		e = e[c];
		f === c && e.isDone() || (f !== c && e.startWithTarget(this.target), b *= e._timesForRepeat, e.update(1 < b ? b % 1 : b), this._last = c)
	},
	reverse: function() {
		var b = cc.Sequence._actionOneTwo(this._actions[1].reverse(), this._actions[0].reverse());
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	}
});
cc.sequence = function(b) {
	var c = b instanceof Array ? b : arguments;
	0 < c.length && null == c[c.length - 1] && cc.log("parameters should not be ending with null in Javascript");
	for (var d, e, f, g; c && 0 < c.length;) {
		for (e = Array.prototype.shift.call(c), g = e._timesForRepeat || 1, e._repeatMethod = !1, e._timesForRepeat = 1, f = 0, d || (d = e, f = 1), f; f < g; f++) {
			d = cc.Sequence._actionOneTwo(d, e)
		}
	}
	return d
};
cc.Sequence.create = cc.sequence;
cc.Sequence._actionOneTwo = function(b, c) {
	var d = new cc.Sequence;
	d.initWithTwoActions(b, c);
	return d
};
cc.Repeat = cc.ActionInterval.extend({
	_times: 0,
	_total: 0,
	_nextDt: 0,
	_actionInstant: !1,
	_innerAction: null,
	ctor: function(b, c) {
		cc.ActionInterval.prototype.ctor.call(this);
		void 0 !== c && this.initWithAction(b, c)
	},
	initWithAction: function(b, c) {
		return this.initWithDuration(b._duration * c) ? (this._times = c, this._innerAction = b, b instanceof cc.ActionInstant && (this._actionInstant = !0, this._times -= 1), this._total = 0, !0) : !1
	},
	clone: function() {
		var b = new cc.Repeat;
		this._cloneDecoration(b);
		b.initWithAction(this._innerAction.clone(), this._times);
		return b
	},
	startWithTarget: function(b) {
		this._total = 0;
		this._nextDt = this._innerAction._duration / this._duration;
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._innerAction.startWithTarget(b)
	},
	stop: function() {
		this._innerAction.stop();
		cc.Action.prototype.stop.call(this)
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		var c = this._innerAction,
			d = this._duration,
			e = this._times,
			f = this._nextDt;
		if (b >= f) {
			for (; b > f && this._total < e;) {
				c.update(1), this._total++, c.stop(), c.startWithTarget(this.target), this._nextDt = f += c._duration / d
			}
			1 <= b && this._total < e && this._total++;
			this._actionInstant || (this._total === e ? (c.update(1), c.stop()) : c.update(b - (f - c._duration / d)))
		} else {
			c.update(b * e % 1)
		}
	},
	isDone: function() {
		return this._total === this._times
	},
	reverse: function() {
		var b = new cc.Repeat(this._innerAction.reverse(), this._times);
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	},
	setInnerAction: function(b) {
		this._innerAction !== b && (this._innerAction = b)
	},
	getInnerAction: function() {
		return this._innerAction
	}
});
cc.repeat = function(b, c) {
	return new cc.Repeat(b, c)
};
cc.Repeat.create = cc.repeat;
cc.RepeatForever = cc.ActionInterval.extend({
	_innerAction: null,
	ctor: function(b) {
		cc.ActionInterval.prototype.ctor.call(this);
		this._innerAction = null;
		b && this.initWithAction(b)
	},
	initWithAction: function(b) {
		if (!b) {
			throw "cc.RepeatForever.initWithAction(): action must be non null"
		}
		this._innerAction = b;
		return !0
	},
	clone: function() {
		var b = new cc.RepeatForever;
		this._cloneDecoration(b);
		b.initWithAction(this._innerAction.clone());
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._innerAction.startWithTarget(b)
	},
	step: function(b) {
		var c = this._innerAction;
		c.step(b);
		c.isDone() && (c.startWithTarget(this.target), c.step(c.getElapsed() - c._duration))
	},
	isDone: function() {
		return !1
	},
	reverse: function() {
		var b = new cc.RepeatForever(this._innerAction.reverse());
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	},
	setInnerAction: function(b) {
		this._innerAction !== b && (this._innerAction = b)
	},
	getInnerAction: function() {
		return this._innerAction
	}
});
cc.repeatForever = function(b) {
	return new cc.RepeatForever(b)
};
cc.RepeatForever.create = cc.repeatForever;
cc.Spawn = cc.ActionInterval.extend({
	_one: null,
	_two: null,
	ctor: function(b) {
		cc.ActionInterval.prototype.ctor.call(this);
		this._two = this._one = null;
		var c = b instanceof Array ? b : arguments,
			d = c.length - 1;
		0 <= d && null == c[d] && cc.log("parameters should not be ending with null in Javascript");
		if (0 <= d) {
			for (var e = c[0], f = 1; f < d; f++) {
				c[f] && (e = cc.Spawn._actionOneTwo(e, c[f]))
			}
			this.initWithTwoActions(e, c[d])
		}
	},
	initWithTwoActions: function(b, c) {
		if (!b || !c) {
			throw "cc.Spawn.initWithTwoActions(): arguments must all be non null"
		}
		var d = !1,
			e = b._duration,
			f = c._duration;
		this.initWithDuration(Math.max(e, f)) && (this._one = b, this._two = c, e > f ? this._two = cc.Sequence._actionOneTwo(c, cc.delayTime(e - f)) : e < f && (this._one = cc.Sequence._actionOneTwo(b, cc.delayTime(f - e))), d = !0);
		return d
	},
	clone: function() {
		var b = new cc.Spawn;
		this._cloneDecoration(b);
		b.initWithTwoActions(this._one.clone(), this._two.clone());
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._one.startWithTarget(b);
		this._two.startWithTarget(b)
	},
	stop: function() {
		this._one.stop();
		this._two.stop();
		cc.Action.prototype.stop.call(this)
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		this._one && this._one.update(b);
		this._two && this._two.update(b)
	},
	reverse: function() {
		var b = cc.Spawn._actionOneTwo(this._one.reverse(), this._two.reverse());
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	}
});
cc.spawn = function(b) {
	var c = b instanceof Array ? b : arguments;
	0 < c.length && null == c[c.length - 1] && cc.log("parameters should not be ending with null in Javascript");
	for (var d = c[0], e = 1; e < c.length; e++) {
		null != c[e] && (d = cc.Spawn._actionOneTwo(d, c[e]))
	}
	return d
};
cc.Spawn.create = cc.spawn;
cc.Spawn._actionOneTwo = function(b, c) {
	var d = new cc.Spawn;
	d.initWithTwoActions(b, c);
	return d
};
cc.RotateTo = cc.ActionInterval.extend({
	_dstAngleX: 0,
	_startAngleX: 0,
	_diffAngleX: 0,
	_dstAngleY: 0,
	_startAngleY: 0,
	_diffAngleY: 0,
	ctor: function(b, c, d) {
		cc.ActionInterval.prototype.ctor.call(this);
		void 0 !== c && this.initWithDuration(b, c, d)
	},
	initWithDuration: function(b, c, d) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (this._dstAngleX = c || 0, this._dstAngleY = d || this._dstAngleX, !0) : !1
	},
	clone: function() {
		var b = new cc.RotateTo;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._dstAngleX, this._dstAngleY);
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		var c = b.rotationX % 360,
			d = this._dstAngleX - c;
		180 < d && (d -= 360); - 180 > d && (d += 360);
		this._startAngleX = c;
		this._diffAngleX = d;
		this._startAngleY = b.rotationY % 360;
		b = this._dstAngleY - this._startAngleY;
		180 < b && (b -= 360); - 180 > b && (b += 360);
		this._diffAngleY = b
	},
	reverse: function() {
		cc.log("cc.RotateTo.reverse(): it should be overridden in subclass.")
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		this.target && (this.target.rotationX = this._startAngleX + this._diffAngleX * b, this.target.rotationY = this._startAngleY + this._diffAngleY * b)
	}
});
cc.rotateTo = function(b, c, d) {
	return new cc.RotateTo(b, c, d)
};
cc.RotateTo.create = cc.rotateTo;
cc.RotateBy = cc.ActionInterval.extend({
	_angleX: 0,
	_startAngleX: 0,
	_angleY: 0,
	_startAngleY: 0,
	ctor: function(b, c, d) {
		cc.ActionInterval.prototype.ctor.call(this);
		void 0 !== c && this.initWithDuration(b, c, d)
	},
	initWithDuration: function(b, c, d) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (this._angleX = c || 0, this._angleY = d || this._angleX, !0) : !1
	},
	clone: function() {
		var b = new cc.RotateBy;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._angleX, this._angleY);
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._startAngleX = b.rotationX;
		this._startAngleY = b.rotationY
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		this.target && (this.target.rotationX = this._startAngleX + this._angleX * b, this.target.rotationY = this._startAngleY + this._angleY * b)
	},
	reverse: function() {
		var b = new cc.RotateBy(this._duration, -this._angleX, -this._angleY);
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	}
});
cc.rotateBy = function(b, c, d) {
	return new cc.RotateBy(b, c, d)
};
cc.RotateBy.create = cc.rotateBy;
cc.MoveBy = cc.ActionInterval.extend({
	_positionDelta: null,
	_startPosition: null,
	_previousPosition: null,
	ctor: function(b, c, d) {
		cc.ActionInterval.prototype.ctor.call(this);
		this._positionDelta = cc.p(0, 0);
		this._startPosition = cc.p(0, 0);
		this._previousPosition = cc.p(0, 0);
		void 0 !== c && this.initWithDuration(b, c, d)
	},
	initWithDuration: function(b, c, d) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (void 0 !== c.x && (d = c.y, c = c.x), this._positionDelta.x = c, this._positionDelta.y = d, !0) : !1
	},
	clone: function() {
		var b = new cc.MoveBy;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._positionDelta);
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		var c = b.getPositionX();
		b = b.getPositionY();
		this._previousPosition.x = c;
		this._previousPosition.y = b;
		this._startPosition.x = c;
		this._startPosition.y = b
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		if (this.target) {
			var c = this._positionDelta.x * b;
			b *= this._positionDelta.y;
			var d = this._startPosition;
			if (cc.ENABLE_STACKABLE_ACTIONS) {
				var e = this.target.getPositionX(),
					f = this.target.getPositionY(),
					g = this._previousPosition;
				d.x = d.x + e - g.x;
				d.y = d.y + f - g.y;
				c += d.x;
				b += d.y;
				g.x = c;
				g.y = b;
				this.target.setPosition(c, b)
			} else {
				this.target.setPosition(d.x + c, d.y + b)
			}
		}
	},
	reverse: function() {
		var b = new cc.MoveBy(this._duration, cc.p(-this._positionDelta.x, -this._positionDelta.y));
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	}
});
cc.moveBy = function(b, c, d) {
	return new cc.MoveBy(b, c, d)
};
cc.MoveBy.create = cc.moveBy;
cc.MoveTo = cc.MoveBy.extend({
	_endPosition: null,
	ctor: function(b, c, d) {
		cc.MoveBy.prototype.ctor.call(this);
		this._endPosition = cc.p(0, 0);
		void 0 !== c && this.initWithDuration(b, c, d)
	},
	initWithDuration: function(b, c, d) {
		return cc.MoveBy.prototype.initWithDuration.call(this, b, c, d) ? (void 0 !== c.x && (d = c.y, c = c.x), this._endPosition.x = c, this._endPosition.y = d, !0) : !1
	},
	clone: function() {
		var b = new cc.MoveTo;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._endPosition);
		return b
	},
	startWithTarget: function(b) {
		cc.MoveBy.prototype.startWithTarget.call(this, b);
		this._positionDelta.x = this._endPosition.x - b.getPositionX();
		this._positionDelta.y = this._endPosition.y - b.getPositionY()
	}
});
cc.moveTo = function(b, c, d) {
	return new cc.MoveTo(b, c, d)
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
	ctor: function(b, c, d) {
		cc.ActionInterval.prototype.ctor.call(this);
		void 0 !== d && this.initWithDuration(b, c, d)
	},
	initWithDuration: function(b, c, d) {
		var e = !1;
		cc.ActionInterval.prototype.initWithDuration.call(this, b) && (this._endSkewX = c, this._endSkewY = d, e = !0);
		return e
	},
	clone: function() {
		var b = new cc.SkewTo;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._endSkewX, this._endSkewY);
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._startSkewX = b.skewX % 180;
		this._deltaX = this._endSkewX - this._startSkewX;
		180 < this._deltaX && (this._deltaX -= 360); - 180 > this._deltaX && (this._deltaX += 360);
		this._startSkewY = b.skewY % 360;
		this._deltaY = this._endSkewY - this._startSkewY;
		180 < this._deltaY && (this._deltaY -= 360); - 180 > this._deltaY && (this._deltaY += 360)
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		this.target.skewX = this._startSkewX + this._deltaX * b;
		this.target.skewY = this._startSkewY + this._deltaY * b
	}
});
cc.skewTo = function(b, c, d) {
	return new cc.SkewTo(b, c, d)
};
cc.SkewTo.create = cc.skewTo;
cc.SkewBy = cc.SkewTo.extend({
	ctor: function(b, c, d) {
		cc.SkewTo.prototype.ctor.call(this);
		void 0 !== d && this.initWithDuration(b, c, d)
	},
	initWithDuration: function(b, c, d) {
		var e = !1;
		cc.SkewTo.prototype.initWithDuration.call(this, b, c, d) && (this._skewX = c, this._skewY = d, e = !0);
		return e
	},
	clone: function() {
		var b = new cc.SkewBy;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._skewX, this._skewY);
		return b
	},
	startWithTarget: function(b) {
		cc.SkewTo.prototype.startWithTarget.call(this, b);
		this._deltaX = this._skewX;
		this._deltaY = this._skewY;
		this._endSkewX = this._startSkewX + this._deltaX;
		this._endSkewY = this._startSkewY + this._deltaY
	},
	reverse: function() {
		var b = new cc.SkewBy(this._duration, -this._skewX, -this._skewY);
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	}
});
cc.skewBy = function(b, c, d) {
	return new cc.SkewBy(b, c, d)
};
cc.SkewBy.create = cc.skewBy;
cc.JumpBy = cc.ActionInterval.extend({
	_startPosition: null,
	_delta: null,
	_height: 0,
	_jumps: 0,
	_previousPosition: null,
	ctor: function(b, c, d, e, f) {
		cc.ActionInterval.prototype.ctor.call(this);
		this._startPosition = cc.p(0, 0);
		this._previousPosition = cc.p(0, 0);
		this._delta = cc.p(0, 0);
		void 0 !== e && this.initWithDuration(b, c, d, e, f)
	},
	initWithDuration: function(b, c, d, e, f) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (void 0 === f && (f = e, e = d, d = c.y, c = c.x), this._delta.x = c, this._delta.y = d, this._height = e, this._jumps = f, !0) : !1
	},
	clone: function() {
		var b = new cc.JumpBy;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._delta, this._height, this._jumps);
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		var c = b.getPositionX();
		b = b.getPositionY();
		this._previousPosition.x = c;
		this._previousPosition.y = b;
		this._startPosition.x = c;
		this._startPosition.y = b
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		if (this.target) {
			var c = b * this._jumps % 1,
				c = 4 * this._height * c * (1 - c),
				c = c + this._delta.y * b;
			b *= this._delta.x;
			var d = this._startPosition;
			if (cc.ENABLE_STACKABLE_ACTIONS) {
				var e = this.target.getPositionX(),
					f = this.target.getPositionY(),
					g = this._previousPosition;
				d.x = d.x + e - g.x;
				d.y = d.y + f - g.y;
				b += d.x;
				c += d.y;
				g.x = b;
				g.y = c;
				this.target.setPosition(b, c)
			} else {
				this.target.setPosition(d.x + b, d.y + c)
			}
		}
	},
	reverse: function() {
		var b = new cc.JumpBy(this._duration, cc.p(-this._delta.x, -this._delta.y), this._height, this._jumps);
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	}
});
cc.jumpBy = function(b, c, d, e, f) {
	return new cc.JumpBy(b, c, d, e, f)
};
cc.JumpBy.create = cc.jumpBy;
cc.JumpTo = cc.JumpBy.extend({
	_endPosition: null,
	ctor: function(b, c, d, e, f) {
		cc.JumpBy.prototype.ctor.call(this);
		this._endPosition = cc.p(0, 0);
		void 0 !== e && this.initWithDuration(b, c, d, e, f)
	},
	initWithDuration: function(b, c, d, e, f) {
		return cc.JumpBy.prototype.initWithDuration.call(this, b, c, d, e, f) ? (void 0 === f && (d = c.y, c = c.x), this._endPosition.x = c, this._endPosition.y = d, !0) : !1
	},
	startWithTarget: function(b) {
		cc.JumpBy.prototype.startWithTarget.call(this, b);
		this._delta.x = this._endPosition.x - this._startPosition.x;
		this._delta.y = this._endPosition.y - this._startPosition.y
	},
	clone: function() {
		var b = new cc.JumpTo;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._endPosition, this._height, this._jumps);
		return b
	}
});
cc.jumpTo = function(b, c, d, e, f) {
	return new cc.JumpTo(b, c, d, e, f)
};
cc.JumpTo.create = cc.jumpTo;
cc.bezierAt = function(b, c, d, e, f) {
	return Math.pow(1 - f, 3) * b + 3 * f * Math.pow(1 - f, 2) * c + 3 * Math.pow(f, 2) * (1 - f) * d + Math.pow(f, 3) * e
};
cc.BezierBy = cc.ActionInterval.extend({
	_config: null,
	_startPosition: null,
	_previousPosition: null,
	ctor: function(b, c) {
		cc.ActionInterval.prototype.ctor.call(this);
		this._config = [];
		this._startPosition = cc.p(0, 0);
		this._previousPosition = cc.p(0, 0);
		c && this.initWithDuration(b, c)
	},
	initWithDuration: function(b, c) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (this._config = c, !0) : !1
	},
	clone: function() {
		var b = new cc.BezierBy;
		this._cloneDecoration(b);
		for (var c = [], d = 0; d < this._config.length; d++) {
			var e = this._config[d];
			c.push(cc.p(e.x, e.y))
		}
		b.initWithDuration(this._duration, c);
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		var c = b.getPositionX();
		b = b.getPositionY();
		this._previousPosition.x = c;
		this._previousPosition.y = b;
		this._startPosition.x = c;
		this._startPosition.y = b
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		if (this.target) {
			var c = this._config,
				d = c[0].y,
				e = c[1].y,
				f = c[2].y,
				c = cc.bezierAt(0, c[0].x, c[1].x, c[2].x, b);
			b = cc.bezierAt(0, d, e, f, b);
			d = this._startPosition;
			if (cc.ENABLE_STACKABLE_ACTIONS) {
				var e = this.target.getPositionX(),
					f = this.target.getPositionY(),
					g = this._previousPosition;
				d.x = d.x + e - g.x;
				d.y = d.y + f - g.y;
				c += d.x;
				b += d.y;
				g.x = c;
				g.y = b;
				this.target.setPosition(c, b)
			} else {
				this.target.setPosition(d.x + c, d.y + b)
			}
		}
	},
	reverse: function() {
		var b = this._config,
			b = [cc.pAdd(b[1], cc.pNeg(b[2])), cc.pAdd(b[0], cc.pNeg(b[2])), cc.pNeg(b[2])],
			b = new cc.BezierBy(this._duration, b);
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	}
});
cc.bezierBy = function(b, c) {
	return new cc.BezierBy(b, c)
};
cc.BezierBy.create = cc.bezierBy;
cc.BezierTo = cc.BezierBy.extend({
	_toConfig: null,
	ctor: function(b, c) {
		cc.BezierBy.prototype.ctor.call(this);
		this._toConfig = [];
		c && this.initWithDuration(b, c)
	},
	initWithDuration: function(b, c) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (this._toConfig = c, !0) : !1
	},
	clone: function() {
		var b = new cc.BezierTo;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._toConfig);
		return b
	},
	startWithTarget: function(b) {
		cc.BezierBy.prototype.startWithTarget.call(this, b);
		b = this._startPosition;
		var c = this._toConfig,
			d = this._config;
		d[0] = cc.pSub(c[0], b);
		d[1] = cc.pSub(c[1], b);
		d[2] = cc.pSub(c[2], b)
	}
});
cc.bezierTo = function(b, c) {
	return new cc.BezierTo(b, c)
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
	ctor: function(b, c, d) {
		cc.ActionInterval.prototype.ctor.call(this);
		void 0 !== c && this.initWithDuration(b, c, d)
	},
	initWithDuration: function(b, c, d) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (this._endScaleX = c, this._endScaleY = null != d ? d : c, !0) : !1
	},
	clone: function() {
		var b = new cc.ScaleTo;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._endScaleX, this._endScaleY);
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._startScaleX = b.scaleX;
		this._startScaleY = b.scaleY;
		this._deltaX = this._endScaleX - this._startScaleX;
		this._deltaY = this._endScaleY - this._startScaleY
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		this.target && (this.target.scaleX = this._startScaleX + this._deltaX * b, this.target.scaleY = this._startScaleY + this._deltaY * b)
	}
});
cc.scaleTo = function(b, c, d) {
	return new cc.ScaleTo(b, c, d)
};
cc.ScaleTo.create = cc.scaleTo;
cc.ScaleBy = cc.ScaleTo.extend({
	startWithTarget: function(b) {
		cc.ScaleTo.prototype.startWithTarget.call(this, b);
		this._deltaX = this._startScaleX * this._endScaleX - this._startScaleX;
		this._deltaY = this._startScaleY * this._endScaleY - this._startScaleY
	},
	reverse: function() {
		var b = new cc.ScaleBy(this._duration, 1 / this._endScaleX, 1 / this._endScaleY);
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	},
	clone: function() {
		var b = new cc.ScaleBy;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._endScaleX, this._endScaleY);
		return b
	}
});
cc.scaleBy = function(b, c, d) {
	return new cc.ScaleBy(b, c, d)
};
cc.ScaleBy.create = cc.scaleBy;
cc.Blink = cc.ActionInterval.extend({
	_times: 0,
	_originalState: !1,
	ctor: function(b, c) {
		cc.ActionInterval.prototype.ctor.call(this);
		void 0 !== c && this.initWithDuration(b, c)
	},
	initWithDuration: function(b, c) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (this._times = c, !0) : !1
	},
	clone: function() {
		var b = new cc.Blink;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._times);
		return b
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		if (this.target && !this.isDone()) {
			var c = 1 / this._times;
			this.target.visible = b % c > c / 2
		}
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._originalState = b.visible
	},
	stop: function() {
		this.target.visible = this._originalState;
		cc.ActionInterval.prototype.stop.call(this)
	},
	reverse: function() {
		var b = new cc.Blink(this._duration, this._times);
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	}
});
cc.blink = function(b, c) {
	return new cc.Blink(b, c)
};
cc.Blink.create = cc.blink;
cc.FadeTo = cc.ActionInterval.extend({
	_toOpacity: 0,
	_fromOpacity: 0,
	ctor: function(b, c) {
		cc.ActionInterval.prototype.ctor.call(this);
		void 0 !== c && this.initWithDuration(b, c)
	},
	initWithDuration: function(b, c) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (this._toOpacity = c, !0) : !1
	},
	clone: function() {
		var b = new cc.FadeTo;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._toOpacity);
		return b
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		var c = void 0 !== this._fromOpacity ? this._fromOpacity : 255;
		this.target.opacity = c + (this._toOpacity - c) * b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._fromOpacity = b.opacity
	}
});
cc.fadeTo = function(b, c) {
	return new cc.FadeTo(b, c)
};
cc.FadeTo.create = cc.fadeTo;
cc.FadeIn = cc.FadeTo.extend({
	_reverseAction: null,
	ctor: function(b) {
		cc.FadeTo.prototype.ctor.call(this);
		null == b && (b = 0);
		this.initWithDuration(b, 255)
	},
	reverse: function() {
		var b = new cc.FadeOut;
		b.initWithDuration(this._duration, 0);
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	},
	clone: function() {
		var b = new cc.FadeIn;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._toOpacity);
		return b
	},
	startWithTarget: function(b) {
		this._reverseAction && (this._toOpacity = this._reverseAction._fromOpacity);
		cc.FadeTo.prototype.startWithTarget.call(this, b)
	}
});
cc.fadeIn = function(b) {
	return new cc.FadeIn(b)
};
cc.FadeIn.create = cc.fadeIn;
cc.FadeOut = cc.FadeTo.extend({
	ctor: function(b) {
		cc.FadeTo.prototype.ctor.call(this);
		null == b && (b = 0);
		this.initWithDuration(b, 0)
	},
	reverse: function() {
		var b = new cc.FadeIn;
		b._reverseAction = this;
		b.initWithDuration(this._duration, 255);
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	},
	clone: function() {
		var b = new cc.FadeOut;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._toOpacity);
		return b
	}
});
cc.fadeOut = function(b) {
	return new cc.FadeOut(b)
};
cc.FadeOut.create = cc.fadeOut;
cc.TintTo = cc.ActionInterval.extend({
	_to: null,
	_from: null,
	ctor: function(b, c, d, e) {
		cc.ActionInterval.prototype.ctor.call(this);
		this._to = cc.color(0, 0, 0);
		this._from = cc.color(0, 0, 0);
		void 0 !== e && this.initWithDuration(b, c, d, e)
	},
	initWithDuration: function(b, c, d, e) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (this._to = cc.color(c, d, e), !0) : !1
	},
	clone: function() {
		var b = new cc.TintTo;
		this._cloneDecoration(b);
		var c = this._to;
		b.initWithDuration(this._duration, c.r, c.g, c.b);
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._from = this.target.color
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		var c = this._from,
			d = this._to;
		c && (this.target.color = cc.color(c.r + (d.r - c.r) * b, c.g + (d.g - c.g) * b, c.b + (d.b - c.b) * b))
	}
});
cc.tintTo = function(b, c, d, e) {
	return new cc.TintTo(b, c, d, e)
};
cc.TintTo.create = cc.tintTo;
cc.TintBy = cc.ActionInterval.extend({
	_deltaR: 0,
	_deltaG: 0,
	_deltaB: 0,
	_fromR: 0,
	_fromG: 0,
	_fromB: 0,
	ctor: function(b, c, d, e) {
		cc.ActionInterval.prototype.ctor.call(this);
		void 0 !== e && this.initWithDuration(b, c, d, e)
	},
	initWithDuration: function(b, c, d, e) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (this._deltaR = c, this._deltaG = d, this._deltaB = e, !0) : !1
	},
	clone: function() {
		var b = new cc.TintBy;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration, this._deltaR, this._deltaG, this._deltaB);
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		b = b.color;
		this._fromR = b.r;
		this._fromG = b.g;
		this._fromB = b.b
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		this.target.color = cc.color(this._fromR + this._deltaR * b, this._fromG + this._deltaG * b, this._fromB + this._deltaB * b)
	},
	reverse: function() {
		var b = new cc.TintBy(this._duration, -this._deltaR, -this._deltaG, -this._deltaB);
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	}
});
cc.tintBy = function(b, c, d, e) {
	return new cc.TintBy(b, c, d, e)
};
cc.TintBy.create = cc.tintBy;
cc.DelayTime = cc.ActionInterval.extend({
	update: function(b) {},
	reverse: function() {
		var b = new cc.DelayTime(this._duration);
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	},
	clone: function() {
		var b = new cc.DelayTime;
		this._cloneDecoration(b);
		b.initWithDuration(this._duration);
		return b
	}
});
cc.delayTime = function(b) {
	return new cc.DelayTime(b)
};
cc.DelayTime.create = cc.delayTime;
cc.ReverseTime = cc.ActionInterval.extend({
	_other: null,
	ctor: function(b) {
		cc.ActionInterval.prototype.ctor.call(this);
		this._other = null;
		b && this.initWithAction(b)
	},
	initWithAction: function(b) {
		if (!b) {
			throw "cc.ReverseTime.initWithAction(): action must be non null"
		}
		if (b === this._other) {
			throw "cc.ReverseTime.initWithAction(): the action was already passed in."
		}
		return cc.ActionInterval.prototype.initWithDuration.call(this, b._duration) ? (this._other = b, !0) : !1
	},
	clone: function() {
		var b = new cc.ReverseTime;
		this._cloneDecoration(b);
		b.initWithAction(this._other.clone());
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._other.startWithTarget(b)
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		this._other && this._other.update(1 - b)
	},
	reverse: function() {
		return this._other.clone()
	},
	stop: function() {
		this._other.stop();
		cc.Action.prototype.stop.call(this)
	}
});
cc.reverseTime = function(b) {
	return new cc.ReverseTime(b)
};
cc.ReverseTime.create = cc.reverseTime;
cc.Animate = cc.ActionInterval.extend({
	_animation: null,
	_nextFrame: 0,
	_origFrame: null,
	_executedLoops: 0,
	_splitTimes: null,
	ctor: function(b) {
		cc.ActionInterval.prototype.ctor.call(this);
		this._splitTimes = [];
		b && this.initWithAnimation(b)
	},
	getAnimation: function() {
		return this._animation
	},
	setAnimation: function(b) {
		this._animation = b
	},
	initWithAnimation: function(b) {
		if (!b) {
			throw "cc.Animate.initWithAnimation(): animation must be non-NULL"
		}
		var c = b.getDuration();
		if (this.initWithDuration(c * b.getLoops())) {
			this._nextFrame = 0;
			this.setAnimation(b);
			this._origFrame = null;
			this._executedLoops = 0;
			var d = this._splitTimes,
				e = d.length = 0,
				f = c / b.getTotalDelayUnits();
			b = b.getFrames();
			cc.arrayVerifyType(b, cc.AnimationFrame);
			for (var g = 0; g < b.length; g++) {
				var h = e * f / c,
					e = e + b[g].getDelayUnits();
				d.push(h)
			}
			return !0
		}
		return !1
	},
	clone: function() {
		var b = new cc.Animate;
		this._cloneDecoration(b);
		b.initWithAnimation(this._animation.clone());
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._animation.getRestoreOriginalFrame() && (this._origFrame = b.displayFrame());
		this._executedLoops = this._nextFrame = 0
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		1 > b && (b *= this._animation.getLoops(), (0 | b) > this._executedLoops && (this._nextFrame = 0, this._executedLoops++), b %= 1);
		for (var c = this._animation.getFrames(), d = c.length, e = this._splitTimes, f = this._nextFrame; f < d; f++) {
			if (e[f] <= b) {
				this.target.setSpriteFrame(c[f].getSpriteFrame()), this._nextFrame = f + 1
			} else {
				break
			}
		}
	},
	reverse: function() {
		var b = this._animation,
			c = b.getFrames(),
			d = [];
		cc.arrayVerifyType(c, cc.AnimationFrame);
		if (0 < c.length) {
			for (var e = c.length - 1; 0 <= e; e--) {
				var f = c[e];
				if (!f) {
					break
				}
				d.push(f.clone())
			}
		}
		c = new cc.Animation(d, b.getDelayPerUnit(), b.getLoops());
		c.setRestoreOriginalFrame(b.getRestoreOriginalFrame());
		b = new cc.Animate(c);
		this._cloneDecoration(b);
		this._reverseEaseList(b);
		return b
	},
	stop: function() {
		this._animation.getRestoreOriginalFrame() && this.target && this.target.setSpriteFrame(this._origFrame);
		cc.Action.prototype.stop.call(this)
	}
});
cc.animate = function(b) {
	return new cc.Animate(b)
};
cc.Animate.create = cc.animate;
cc.TargetedAction = cc.ActionInterval.extend({
	_action: null,
	_forcedTarget: null,
	ctor: function(b, c) {
		cc.ActionInterval.prototype.ctor.call(this);
		c && this.initWithTarget(b, c)
	},
	initWithTarget: function(b, c) {
		return this.initWithDuration(c._duration) ? (this._forcedTarget = b, this._action = c, !0) : !1
	},
	clone: function() {
		var b = new cc.TargetedAction;
		this._cloneDecoration(b);
		b.initWithTarget(this._forcedTarget, this._action.clone());
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._action.startWithTarget(this._forcedTarget)
	},
	stop: function() {
		this._action.stop()
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		this._action.update(b)
	},
	getForcedTarget: function() {
		return this._forcedTarget
	},
	setForcedTarget: function(b) {
		this._forcedTarget !== b && (this._forcedTarget = b)
	}
});
cc.targetedAction = function(b, c) {
	return new cc.TargetedAction(b, c)
};
cc.TargetedAction.create = cc.targetedAction;
cc.ActionInstant = cc.FiniteTimeAction.extend({
	isDone: function() {
		return !0
	},
	step: function(b) {
		this.update(1)
	},
	update: function(b) {},
	reverse: function() {
		return this.clone()
	},
	clone: function() {
		return new cc.ActionInstant
	}
});
cc.Show = cc.ActionInstant.extend({
	update: function(b) {
		this.target.visible = !0
	},
	reverse: function() {
		return new cc.Hide
	},
	clone: function() {
		return new cc.Show
	}
});
cc.show = function() {
	return new cc.Show
};
cc.Show.create = cc.show;
cc.Hide = cc.ActionInstant.extend({
	update: function(b) {
		this.target.visible = !1
	},
	reverse: function() {
		return new cc.Show
	},
	clone: function() {
		return new cc.Hide
	}
});
cc.hide = function() {
	return new cc.Hide
};
cc.Hide.create = cc.hide;
cc.ToggleVisibility = cc.ActionInstant.extend({
	update: function(b) {
		this.target.visible = !this.target.visible
	},
	reverse: function() {
		return new cc.ToggleVisibility
	},
	clone: function() {
		return new cc.ToggleVisibility
	}
});
cc.toggleVisibility = function() {
	return new cc.ToggleVisibility
};
cc.ToggleVisibility.create = cc.toggleVisibility;
cc.RemoveSelf = cc.ActionInstant.extend({
	_isNeedCleanUp: !0,
	ctor: function(b) {
		cc.FiniteTimeAction.prototype.ctor.call(this);
		void 0 !== b && this.init(b)
	},
	update: function(b) {
		this.target.removeFromParent(this._isNeedCleanUp)
	},
	init: function(b) {
		this._isNeedCleanUp = b;
		return !0
	},
	reverse: function() {
		return new cc.RemoveSelf(this._isNeedCleanUp)
	},
	clone: function() {
		return new cc.RemoveSelf(this._isNeedCleanUp)
	}
});
cc.removeSelf = function(b) {
	return new cc.RemoveSelf(b)
};
cc.RemoveSelf.create = cc.removeSelf;
cc.FlipX = cc.ActionInstant.extend({
	_flippedX: !1,
	ctor: function(b) {
		cc.FiniteTimeAction.prototype.ctor.call(this);
		this._flippedX = !1;
		void 0 !== b && this.initWithFlipX(b)
	},
	initWithFlipX: function(b) {
		this._flippedX = b;
		return !0
	},
	update: function(b) {
		this.target.flippedX = this._flippedX
	},
	reverse: function() {
		return new cc.FlipX(!this._flippedX)
	},
	clone: function() {
		var b = new cc.FlipX;
		b.initWithFlipX(this._flippedX);
		return b
	}
});
cc.flipX = function(b) {
	return new cc.FlipX(b)
};
cc.FlipX.create = cc.flipX;
cc.FlipY = cc.ActionInstant.extend({
	_flippedY: !1,
	ctor: function(b) {
		cc.FiniteTimeAction.prototype.ctor.call(this);
		this._flippedY = !1;
		void 0 !== b && this.initWithFlipY(b)
	},
	initWithFlipY: function(b) {
		this._flippedY = b;
		return !0
	},
	update: function(b) {
		this.target.flippedY = this._flippedY
	},
	reverse: function() {
		return new cc.FlipY(!this._flippedY)
	},
	clone: function() {
		var b = new cc.FlipY;
		b.initWithFlipY(this._flippedY);
		return b
	}
});
cc.flipY = function(b) {
	return new cc.FlipY(b)
};
cc.FlipY.create = cc.flipY;
cc.Place = cc.ActionInstant.extend({
	_x: 0,
	_y: 0,
	ctor: function(b, c) {
		cc.FiniteTimeAction.prototype.ctor.call(this);
		this._y = this._x = 0;
		void 0 !== b && (void 0 !== b.x && (c = b.y, b = b.x), this.initWithPosition(b, c))
	},
	initWithPosition: function(b, c) {
		this._x = b;
		this._y = c;
		return !0
	},
	update: function(b) {
		this.target.setPosition(this._x, this._y)
	},
	clone: function() {
		var b = new cc.Place;
		b.initWithPosition(this._x, this._y);
		return b
	}
});
cc.place = function(b, c) {
	return new cc.Place(b, c)
};
cc.Place.create = cc.place;
cc.CallFunc = cc.ActionInstant.extend({
	_selectorTarget: null,
	_callFunc: null,
	_function: null,
	_data: null,
	ctor: function(b, c, d) {
		cc.FiniteTimeAction.prototype.ctor.call(this);
		void 0 !== b && (void 0 === c ? this.initWithFunction(b) : this.initWithFunction(b, c, d))
	},
	initWithFunction: function(b, c, d) {
		c ? (this._data = d, this._callFunc = b, this._selectorTarget = c) : b && (this._function = b);
		return !0
	},
	execute: function() {
		null != this._callFunc ? this._callFunc.call(this._selectorTarget, this.target, this._data) : this._function && this._function.call(null, this.target)
	},
	update: function(b) {
		this.execute()
	},
	getTargetCallback: function() {
		return this._selectorTarget
	},
	setTargetCallback: function(b) {
		b !== this._selectorTarget && (this._selectorTarget && (this._selectorTarget = null), this._selectorTarget = b)
	},
	clone: function() {
		var b = new cc.CallFunc;
		this._selectorTarget ? b.initWithFunction(this._callFunc, this._selectorTarget, this._data) : this._function && b.initWithFunction(this._function);
		return b
	}
});
cc.callFunc = function(b, c, d) {
	return new cc.CallFunc(b, c, d)
};
cc.CallFunc.create = cc.callFunc;
cc.ActionCamera = cc.ActionInterval.extend({
	_centerXOrig: 0,
	_centerYOrig: 0,
	_centerZOrig: 0,
	_eyeXOrig: 0,
	_eyeYOrig: 0,
	_eyeZOrig: 0,
	_upXOrig: 0,
	_upYOrig: 0,
	_upZOrig: 0,
	ctor: function() {
		cc.ActionInterval.prototype.ctor.call(this);
		this._upZOrig = this._upYOrig = this._upXOrig = this._eyeZOrig = this._eyeYOrig = this._eyeXOrig = this._centerZOrig = this._centerYOrig = this._centerXOrig = 0
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		b = b.getCamera();
		var c = b.getCenter();
		this._centerXOrig = c.x;
		this._centerYOrig = c.y;
		this._centerZOrig = c.z;
		c = b.getEye();
		this._eyeXOrig = c.x;
		this._eyeYOrig = c.y;
		this._eyeZOrig = c.z;
		b = b.getUp();
		this._upXOrig = b.x;
		this._upYOrig = b.y;
		this._upZOrig = b.z
	},
	clone: function() {
		return new cc.ActionCamera
	},
	reverse: function() {
		return new cc.ReverseTime(this)
	}
});
cc.OrbitCamera = cc.ActionCamera.extend({
	_radius: 0,
	_deltaRadius: 0,
	_angleZ: 0,
	_deltaAngleZ: 0,
	_angleX: 0,
	_deltaAngleX: 0,
	_radZ: 0,
	_radDeltaZ: 0,
	_radX: 0,
	_radDeltaX: 0,
	ctor: function(b, c, d, e, f, g, h) {
		cc.ActionCamera.prototype.ctor.call(this);
		void 0 !== h && this.initWithDuration(b, c, d, e, f, g, h)
	},
	initWithDuration: function(b, c, d, e, f, g, h) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (this._radius = c, this._deltaRadius = d, this._angleZ = e, this._deltaAngleZ = f, this._angleX = g, this._deltaAngleX = h, this._radDeltaZ = cc.degreesToRadians(f), this._radDeltaX = cc.degreesToRadians(h), !0) : !1
	},
	sphericalRadius: function() {
		var b, c;
		c = this.target.getCamera();
		var d = c.getEye();
		b = c.getCenter();
		c = d.x - b.x;
		var e = d.y - b.y;
		b = d.z - b.z;
		var d = Math.sqrt(Math.pow(c, 2) + Math.pow(e, 2) + Math.pow(b, 2)),
			f = Math.sqrt(Math.pow(c, 2) + Math.pow(e, 2));
		0 === f && (f = cc.FLT_EPSILON);
		0 === d && (d = cc.FLT_EPSILON);
		b = Math.acos(b / d);
		c = 0 > c ? Math.PI - Math.asin(e / f) : Math.asin(e / f);
		return {
			newRadius: d / cc.Camera.getZEye(),
			zenith: b,
			azimuth: c
		}
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		b = this.sphericalRadius();
		isNaN(this._radius) && (this._radius = b.newRadius);
		isNaN(this._angleZ) && (this._angleZ = cc.radiansToDegrees(b.zenith));
		isNaN(this._angleX) && (this._angleX = cc.radiansToDegrees(b.azimuth));
		this._radZ = cc.degreesToRadians(this._angleZ);
		this._radX = cc.degreesToRadians(this._angleX)
	},
	clone: function() {
		var b = new cc.OrbitCamera;
		b.initWithDuration(this._duration, this._radius, this._deltaRadius, this._angleZ, this._deltaAngleZ, this._angleX, this._deltaAngleX);
		return b
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		var c = (this._radius + this._deltaRadius * b) * cc.Camera.getZEye(),
			d = this._radZ + this._radDeltaZ * b,
			e = this._radX + this._radDeltaX * b;
		b = Math.sin(d) * Math.cos(e) * c + this._centerXOrig;
		e = Math.sin(d) * Math.sin(e) * c + this._centerYOrig;
		c = Math.cos(d) * c + this._centerZOrig;
		this.target.getCamera().setEye(b, e, c);
		this.target.setNodeDirty()
	}
});
cc.orbitCamera = function(b, c, d, e, f, g, h) {
	return new cc.OrbitCamera(b, c, d, e, f, g, h)
};
cc.OrbitCamera.create = cc.orbitCamera;
cc.ActionEase = cc.ActionInterval.extend({
	_inner: null,
	ctor: function(b) {
		cc.ActionInterval.prototype.ctor.call(this);
		b && this.initWithAction(b)
	},
	initWithAction: function(b) {
		if (!b) {
			throw "cc.ActionEase.initWithAction(): action must be non nil"
		}
		return this.initWithDuration(b.getDuration()) ? (this._inner = b, !0) : !1
	},
	clone: function() {
		var b = new cc.ActionEase;
		b.initWithAction(this._inner.clone());
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._inner.startWithTarget(this.target)
	},
	stop: function() {
		this._inner.stop();
		cc.ActionInterval.prototype.stop.call(this)
	},
	update: function(b) {
		this._inner.update(b)
	},
	reverse: function() {
		return new cc.ActionEase(this._inner.reverse())
	},
	getInnerAction: function() {
		return this._inner
	}
});
cc.actionEase = function(b) {
	return new cc.ActionEase(b)
};
cc.ActionEase.create = cc.actionEase;
cc.EaseRateAction = cc.ActionEase.extend({
	_rate: 0,
	ctor: function(b, c) {
		cc.ActionEase.prototype.ctor.call(this);
		void 0 !== c && this.initWithAction(b, c)
	},
	setRate: function(b) {
		this._rate = b
	},
	getRate: function() {
		return this._rate
	},
	initWithAction: function(b, c) {
		return cc.ActionEase.prototype.initWithAction.call(this, b) ? (this._rate = c, !0) : !1
	},
	clone: function() {
		var b = new cc.EaseRateAction;
		b.initWithAction(this._inner.clone(), this._rate);
		return b
	},
	reverse: function() {
		return new cc.EaseRateAction(this._inner.reverse(), 1 / this._rate)
	}
});
cc.easeRateAction = function(b, c) {
	return new cc.EaseRateAction(b, c)
};
cc.EaseRateAction.create = cc.easeRateAction;
cc.EaseIn = cc.EaseRateAction.extend({
	update: function(b) {
		this._inner.update(Math.pow(b, this._rate))
	},
	reverse: function() {
		return new cc.EaseIn(this._inner.reverse(), 1 / this._rate)
	},
	clone: function() {
		var b = new cc.EaseIn;
		b.initWithAction(this._inner.clone(), this._rate);
		return b
	}
});
cc.EaseIn.create = function(b, c) {
	return new cc.EaseIn(b, c)
};
cc.easeIn = function(b) {
	return {
		_rate: b,
		easing: function(b) {
			return Math.pow(b, this._rate)
		},
		reverse: function() {
			return cc.easeIn(1 / this._rate)
		}
	}
};
cc.EaseOut = cc.EaseRateAction.extend({
	update: function(b) {
		this._inner.update(Math.pow(b, 1 / this._rate))
	},
	reverse: function() {
		return new cc.EaseOut(this._inner.reverse(), 1 / this._rate)
	},
	clone: function() {
		var b = new cc.EaseOut;
		b.initWithAction(this._inner.clone(), this._rate);
		return b
	}
});
cc.EaseOut.create = function(b, c) {
	return new cc.EaseOut(b, c)
};
cc.easeOut = function(b) {
	return {
		_rate: b,
		easing: function(b) {
			return Math.pow(b, 1 / this._rate)
		},
		reverse: function() {
			return cc.easeOut(1 / this._rate)
		}
	}
};
cc.EaseInOut = cc.EaseRateAction.extend({
	update: function(b) {
		b *= 2;
		1 > b ? this._inner.update(0.5 * Math.pow(b, this._rate)) : this._inner.update(1 - 0.5 * Math.pow(2 - b, this._rate))
	},
	clone: function() {
		var b = new cc.EaseInOut;
		b.initWithAction(this._inner.clone(), this._rate);
		return b
	},
	reverse: function() {
		return new cc.EaseInOut(this._inner.reverse(), this._rate)
	}
});
cc.EaseInOut.create = function(b, c) {
	return new cc.EaseInOut(b, c)
};
cc.easeInOut = function(b) {
	return {
		_rate: b,
		easing: function(b) {
			b *= 2;
			return 1 > b ? 0.5 * Math.pow(b, this._rate) : 1 - 0.5 * Math.pow(2 - b, this._rate)
		},
		reverse: function() {
			return cc.easeInOut(this._rate)
		}
	}
};
cc.EaseExponentialIn = cc.ActionEase.extend({
	update: function(b) {
		this._inner.update(0 === b ? 0 : Math.pow(2, 10 * (b - 1)))
	},
	reverse: function() {
		return new cc.EaseExponentialOut(this._inner.reverse())
	},
	clone: function() {
		var b = new cc.EaseExponentialIn;
		b.initWithAction(this._inner.clone());
		return b
	}
});
cc.EaseExponentialIn.create = function(b) {
	return new cc.EaseExponentialIn(b)
};
cc._easeExponentialInObj = {
	easing: function(b) {
		return 0 === b ? 0 : Math.pow(2, 10 * (b - 1))
	},
	reverse: function() {
		return cc._easeExponentialOutObj
	}
};
cc.easeExponentialIn = function() {
	return cc._easeExponentialInObj
};
cc.EaseExponentialOut = cc.ActionEase.extend({
	update: function(b) {
		this._inner.update(1 === b ? 1 : -Math.pow(2, -10 * b) + 1)
	},
	reverse: function() {
		return new cc.EaseExponentialIn(this._inner.reverse())
	},
	clone: function() {
		var b = new cc.EaseExponentialOut;
		b.initWithAction(this._inner.clone());
		return b
	}
});
cc.EaseExponentialOut.create = function(b) {
	return new cc.EaseExponentialOut(b)
};
cc._easeExponentialOutObj = {
	easing: function(b) {
		return 1 === b ? 1 : -Math.pow(2, -10 * b) + 1
	},
	reverse: function() {
		return cc._easeExponentialInObj
	}
};
cc.easeExponentialOut = function() {
	return cc._easeExponentialOutObj
};
cc.EaseExponentialInOut = cc.ActionEase.extend({
	update: function(b) {
		1 !== b && 0 !== b && (b *= 2, b = 1 > b ? 0.5 * Math.pow(2, 10 * (b - 1)) : 0.5 * (-Math.pow(2, -10 * (b - 1)) + 2));
		this._inner.update(b)
	},
	reverse: function() {
		return new cc.EaseExponentialInOut(this._inner.reverse())
	},
	clone: function() {
		var b = new cc.EaseExponentialInOut;
		b.initWithAction(this._inner.clone());
		return b
	}
});
cc.EaseExponentialInOut.create = function(b) {
	return new cc.EaseExponentialInOut(b)
};
cc._easeExponentialInOutObj = {
	easing: function(b) {
		return 1 !== b && 0 !== b ? (b *= 2, 1 > b ? 0.5 * Math.pow(2, 10 * (b - 1)) : 0.5 * (-Math.pow(2, -10 * (b - 1)) + 2)) : b
	},
	reverse: function() {
		return cc._easeExponentialInOutObj
	}
};
cc.easeExponentialInOut = function() {
	return cc._easeExponentialInOutObj
};
cc.EaseSineIn = cc.ActionEase.extend({
	update: function(b) {
		b = 0 === b || 1 === b ? b : -1 * Math.cos(b * Math.PI / 2) + 1;
		this._inner.update(b)
	},
	reverse: function() {
		return new cc.EaseSineOut(this._inner.reverse())
	},
	clone: function() {
		var b = new cc.EaseSineIn;
		b.initWithAction(this._inner.clone());
		return b
	}
});
cc.EaseSineIn.create = function(b) {
	return new cc.EaseSineIn(b)
};
cc._easeSineInObj = {
	easing: function(b) {
		return 0 === b || 1 === b ? b : -1 * Math.cos(b * Math.PI / 2) + 1
	},
	reverse: function() {
		return cc._easeSineOutObj
	}
};
cc.easeSineIn = function() {
	return cc._easeSineInObj
};
cc.EaseSineOut = cc.ActionEase.extend({
	update: function(b) {
		b = 0 === b || 1 === b ? b : Math.sin(b * Math.PI / 2);
		this._inner.update(b)
	},
	reverse: function() {
		return new cc.EaseSineIn(this._inner.reverse())
	},
	clone: function() {
		var b = new cc.EaseSineOut;
		b.initWithAction(this._inner.clone());
		return b
	}
});
cc.EaseSineOut.create = function(b) {
	return new cc.EaseSineOut(b)
};
cc._easeSineOutObj = {
	easing: function(b) {
		return 0 === b || 1 === b ? b : Math.sin(b * Math.PI / 2)
	},
	reverse: function() {
		return cc._easeSineInObj
	}
};
cc.easeSineOut = function() {
	return cc._easeSineOutObj
};
cc.EaseSineInOut = cc.ActionEase.extend({
	update: function(b) {
		b = 0 === b || 1 === b ? b : -0.5 * (Math.cos(Math.PI * b) - 1);
		this._inner.update(b)
	},
	clone: function() {
		var b = new cc.EaseSineInOut;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseSineInOut(this._inner.reverse())
	}
});
cc.EaseSineInOut.create = function(b) {
	return new cc.EaseSineInOut(b)
};
cc._easeSineInOutObj = {
	easing: function(b) {
		return 0 === b || 1 === b ? b : -0.5 * (Math.cos(Math.PI * b) - 1)
	},
	reverse: function() {
		return cc._easeSineInOutObj
	}
};
cc.easeSineInOut = function() {
	return cc._easeSineInOutObj
};
cc.EaseElastic = cc.ActionEase.extend({
	_period: 0.3,
	ctor: function(b, c) {
		cc.ActionEase.prototype.ctor.call(this);
		b && this.initWithAction(b, c)
	},
	getPeriod: function() {
		return this._period
	},
	setPeriod: function(b) {
		this._period = b
	},
	initWithAction: function(b, c) {
		cc.ActionEase.prototype.initWithAction.call(this, b);
		this._period = null == c ? 0.3 : c;
		return !0
	},
	reverse: function() {
		cc.log("cc.EaseElastic.reverse(): it should be overridden in subclass.");
		return null
	},
	clone: function() {
		var b = new cc.EaseElastic;
		b.initWithAction(this._inner.clone(), this._period);
		return b
	}
});
cc.EaseElastic.create = function(b, c) {
	return new cc.EaseElastic(b, c)
};
cc.EaseElasticIn = cc.EaseElastic.extend({
	update: function(b) {
		var c = 0;
		0 === b || 1 === b ? c = b : (c = this._period / 4, b -= 1, c = -Math.pow(2, 10 * b) * Math.sin((b - c) * Math.PI * 2 / this._period));
		this._inner.update(c)
	},
	reverse: function() {
		return new cc.EaseElasticOut(this._inner.reverse(), this._period)
	},
	clone: function() {
		var b = new cc.EaseElasticIn;
		b.initWithAction(this._inner.clone(), this._period);
		return b
	}
});
cc.EaseElasticIn.create = function(b, c) {
	return new cc.EaseElasticIn(b, c)
};
cc._easeElasticInObj = {
	easing: function(b) {
		if (0 === b || 1 === b) {
			return b
		}
		b -= 1;
		return -Math.pow(2, 10 * b) * Math.sin((b - 0.075) * Math.PI * 2 / 0.3)
	},
	reverse: function() {
		return cc._easeElasticOutObj
	}
};
cc.easeElasticIn = function(b) {
	return b && 0.3 !== b ? {
		_period: b,
		easing: function(b) {
			if (0 === b || 1 === b) {
				return b
			}
			b -= 1;
			return -Math.pow(2, 10 * b) * Math.sin((b - this._period / 4) * Math.PI * 2 / this._period)
		},
		reverse: function() {
			return cc.easeElasticOut(this._period)
		}
	} : cc._easeElasticInObj
};
cc.EaseElasticOut = cc.EaseElastic.extend({
	update: function(b) {
		var c = 0;
		0 === b || 1 === b ? c = b : (c = this._period / 4, c = Math.pow(2, -10 * b) * Math.sin((b - c) * Math.PI * 2 / this._period) + 1);
		this._inner.update(c)
	},
	reverse: function() {
		return new cc.EaseElasticIn(this._inner.reverse(), this._period)
	},
	clone: function() {
		var b = new cc.EaseElasticOut;
		b.initWithAction(this._inner.clone(), this._period);
		return b
	}
});
cc.EaseElasticOut.create = function(b, c) {
	return new cc.EaseElasticOut(b, c)
};
cc._easeElasticOutObj = {
	easing: function(b) {
		return 0 === b || 1 === b ? b : Math.pow(2, -10 * b) * Math.sin((b - 0.075) * Math.PI * 2 / 0.3) + 1
	},
	reverse: function() {
		return cc._easeElasticInObj
	}
};
cc.easeElasticOut = function(b) {
	return b && 0.3 !== b ? {
		_period: b,
		easing: function(b) {
			return 0 === b || 1 === b ? b : Math.pow(2, -10 * b) * Math.sin((b - this._period / 4) * Math.PI * 2 / this._period) + 1
		},
		reverse: function() {
			return cc.easeElasticIn(this._period)
		}
	} : cc._easeElasticOutObj
};
cc.EaseElasticInOut = cc.EaseElastic.extend({
	update: function(b) {
		var c = 0,
			c = this._period;
		if (0 === b || 1 === b) {
			c = b
		} else {
			c || (c = this._period = 0.3 * 1.5);
			var d = c / 4;
			b = 2 * b - 1;
			c = 0 > b ? -0.5 * Math.pow(2, 10 * b) * Math.sin((b - d) * Math.PI * 2 / c) : Math.pow(2, -10 * b) * Math.sin((b - d) * Math.PI * 2 / c) * 0.5 + 1
		}
		this._inner.update(c)
	},
	reverse: function() {
		return new cc.EaseElasticInOut(this._inner.reverse(), this._period)
	},
	clone: function() {
		var b = new cc.EaseElasticInOut;
		b.initWithAction(this._inner.clone(), this._period);
		return b
	}
});
cc.EaseElasticInOut.create = function(b, c) {
	return new cc.EaseElasticInOut(b, c)
};
cc.easeElasticInOut = function(b) {
	return {
		_period: b || 0.3,
		easing: function(b) {
			var d = 0,
				d = this._period;
			if (0 === b || 1 === b) {
				d = b
			} else {
				d || (d = this._period = 0.3 * 1.5);
				var e = d / 4;
				b = 2 * b - 1;
				d = 0 > b ? -0.5 * Math.pow(2, 10 * b) * Math.sin((b - e) * Math.PI * 2 / d) : Math.pow(2, -10 * b) * Math.sin((b - e) * Math.PI * 2 / d) * 0.5 + 1
			}
			return d
		},
		reverse: function() {
			return cc.easeElasticInOut(this._period)
		}
	}
};
cc.EaseBounce = cc.ActionEase.extend({
	bounceTime: function(b) {
		if (b < 1 / 2.75) {
			return 7.5625 * b * b
		}
		if (b < 2 / 2.75) {
			return b -= 1.5 / 2.75, 7.5625 * b * b + 0.75
		}
		if (b < 2.5 / 2.75) {
			return b -= 2.25 / 2.75, 7.5625 * b * b + 0.9375
		}
		b -= 2.625 / 2.75;
		return 7.5625 * b * b + 0.984375
	},
	clone: function() {
		var b = new cc.EaseBounce;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseBounce(this._inner.reverse())
	}
});
cc.EaseBounce.create = function(b) {
	return new cc.EaseBounce(b)
};
cc.EaseBounceIn = cc.EaseBounce.extend({
	update: function(b) {
		b = 1 - this.bounceTime(1 - b);
		this._inner.update(b)
	},
	reverse: function() {
		return new cc.EaseBounceOut(this._inner.reverse())
	},
	clone: function() {
		var b = new cc.EaseBounceIn;
		b.initWithAction(this._inner.clone());
		return b
	}
});
cc.EaseBounceIn.create = function(b) {
	return new cc.EaseBounceIn(b)
};
cc._bounceTime = function(b) {
	if (b < 1 / 2.75) {
		return 7.5625 * b * b
	}
	if (b < 2 / 2.75) {
		return b -= 1.5 / 2.75, 7.5625 * b * b + 0.75
	}
	if (b < 2.5 / 2.75) {
		return b -= 2.25 / 2.75, 7.5625 * b * b + 0.9375
	}
	b -= 2.625 / 2.75;
	return 7.5625 * b * b + 0.984375
};
cc._easeBounceInObj = {
	easing: function(b) {
		return 1 - cc._bounceTime(1 - b)
	},
	reverse: function() {
		return cc._easeBounceOutObj
	}
};
cc.easeBounceIn = function() {
	return cc._easeBounceInObj
};
cc.EaseBounceOut = cc.EaseBounce.extend({
	update: function(b) {
		b = this.bounceTime(b);
		this._inner.update(b)
	},
	reverse: function() {
		return new cc.EaseBounceIn(this._inner.reverse())
	},
	clone: function() {
		var b = new cc.EaseBounceOut;
		b.initWithAction(this._inner.clone());
		return b
	}
});
cc.EaseBounceOut.create = function(b) {
	return new cc.EaseBounceOut(b)
};
cc._easeBounceOutObj = {
	easing: function(b) {
		return cc._bounceTime(b)
	},
	reverse: function() {
		return cc._easeBounceInObj
	}
};
cc.easeBounceOut = function() {
	return cc._easeBounceOutObj
};
cc.EaseBounceInOut = cc.EaseBounce.extend({
	update: function(b) {
		var c = 0,
			c = 0.5 > b ? 0.5 * (1 - this.bounceTime(1 - 2 * b)) : 0.5 * this.bounceTime(2 * b - 1) + 0.5;
		this._inner.update(c)
	},
	clone: function() {
		var b = new cc.EaseBounceInOut;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseBounceInOut(this._inner.reverse())
	}
});
cc.EaseBounceInOut.create = function(b) {
	return new cc.EaseBounceInOut(b)
};
cc._easeBounceInOutObj = {
	easing: function(b) {
		return b = 0.5 > b ? 0.5 * (1 - cc._bounceTime(1 - 2 * b)) : 0.5 * cc._bounceTime(2 * b - 1) + 0.5
	},
	reverse: function() {
		return cc._easeBounceInOutObj
	}
};
cc.easeBounceInOut = function() {
	return cc._easeBounceInOutObj
};
cc.EaseBackIn = cc.ActionEase.extend({
	update: function(b) {
		this._inner.update(0 === b || 1 === b ? b : b * b * (2.70158 * b - 1.70158))
	},
	reverse: function() {
		return new cc.EaseBackOut(this._inner.reverse())
	},
	clone: function() {
		var b = new cc.EaseBackIn;
		b.initWithAction(this._inner.clone());
		return b
	}
});
cc.EaseBackIn.create = function(b) {
	return new cc.EaseBackIn(b)
};
cc._easeBackInObj = {
	easing: function(b) {
		return 0 === b || 1 === b ? b : b * b * (2.70158 * b - 1.70158)
	},
	reverse: function() {
		return cc._easeBackOutObj
	}
};
cc.easeBackIn = function() {
	return cc._easeBackInObj
};
cc.EaseBackOut = cc.ActionEase.extend({
	update: function(b) {
		b -= 1;
		this._inner.update(b * b * (2.70158 * b + 1.70158) + 1)
	},
	reverse: function() {
		return new cc.EaseBackIn(this._inner.reverse())
	},
	clone: function() {
		var b = new cc.EaseBackOut;
		b.initWithAction(this._inner.clone());
		return b
	}
});
cc.EaseBackOut.create = function(b) {
	return new cc.EaseBackOut(b)
};
cc._easeBackOutObj = {
	easing: function(b) {
		b -= 1;
		return b * b * (2.70158 * b + 1.70158) + 1
	},
	reverse: function() {
		return cc._easeBackInObj
	}
};
cc.easeBackOut = function() {
	return cc._easeBackOutObj
};
cc.EaseBackInOut = cc.ActionEase.extend({
	update: function(b) {
		b *= 2;
		1 > b ? this._inner.update(b * b * (3.5949095 * b - 2.5949095) / 2) : (b -= 2, this._inner.update(b * b * (3.5949095 * b + 2.5949095) / 2 + 1))
	},
	clone: function() {
		var b = new cc.EaseBackInOut;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseBackInOut(this._inner.reverse())
	}
});
cc.EaseBackInOut.create = function(b) {
	return new cc.EaseBackInOut(b)
};
cc._easeBackInOutObj = {
	easing: function(b) {
		b *= 2;
		if (1 > b) {
			return b * b * (3.5949095 * b - 2.5949095) / 2
		}
		b -= 2;
		return b * b * (3.5949095 * b + 2.5949095) / 2 + 1
	},
	reverse: function() {
		return cc._easeBackInOutObj
	}
};
cc.easeBackInOut = function() {
	return cc._easeBackInOutObj
};
cc.EaseBezierAction = cc.ActionEase.extend({
	_p0: null,
	_p1: null,
	_p2: null,
	_p3: null,
	ctor: function(b) {
		cc.ActionEase.prototype.ctor.call(this, b)
	},
	_updateTime: function(b, c, d, e, f) {
		return Math.pow(1 - f, 3) * b + 3 * f * Math.pow(1 - f, 2) * c + 3 * Math.pow(f, 2) * (1 - f) * d + Math.pow(f, 3) * e
	},
	update: function(b) {
		b = this._updateTime(this._p0, this._p1, this._p2, this._p3, b);
		this._inner.update(b)
	},
	clone: function() {
		var b = new cc.EaseBezierAction;
		b.initWithAction(this._inner.clone());
		b.setBezierParamer(this._p0, this._p1, this._p2, this._p3);
		return b
	},
	reverse: function() {
		var b = new cc.EaseBezierAction(this._inner.reverse());
		b.setBezierParamer(this._p3, this._p2, this._p1, this._p0);
		return b
	},
	setBezierParamer: function(b, c, d, e) {
		this._p0 = b || 0;
		this._p1 = c || 0;
		this._p2 = d || 0;
		this._p3 = e || 0
	}
});
cc.EaseBezierAction.create = function(b) {
	return new cc.EaseBezierAction(b)
};
cc.easeBezierAction = function(b, c, d, e) {
	return {
		easing: function(f) {
			return cc.EaseBezierAction.prototype._updateTime(b, c, d, e, f)
		},
		reverse: function() {
			return cc.easeBezierAction(e, d, c, b)
		}
	}
};
cc.EaseQuadraticActionIn = cc.ActionEase.extend({
	_updateTime: function(b) {
		return Math.pow(b, 2)
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseQuadraticActionIn;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseQuadraticActionIn(this._inner.reverse())
	}
});
cc.EaseQuadraticActionIn.create = function(b) {
	return new cc.EaseQuadraticActionIn(b)
};
cc._easeQuadraticActionIn = {
	easing: cc.EaseQuadraticActionIn.prototype._updateTime,
	reverse: function() {
		return cc._easeQuadraticActionIn
	}
};
cc.easeQuadraticActionIn = function() {
	return cc._easeQuadraticActionIn
};
cc.EaseQuadraticActionOut = cc.ActionEase.extend({
	_updateTime: function(b) {
		return -b * (b - 2)
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseQuadraticActionOut;
		b.initWithAction();
		return b
	},
	reverse: function() {
		return new cc.EaseQuadraticActionOut(this._inner.reverse())
	}
});
cc.EaseQuadraticActionOut.create = function(b) {
	return new cc.EaseQuadraticActionOut(b)
};
cc._easeQuadraticActionOut = {
	easing: cc.EaseQuadraticActionOut.prototype._updateTime,
	reverse: function() {
		return cc._easeQuadraticActionOut
	}
};
cc.easeQuadraticActionOut = function() {
	return cc._easeQuadraticActionOut
};
cc.EaseQuadraticActionInOut = cc.ActionEase.extend({
	_updateTime: function(b) {
		var c = b;
		b *= 2;
		1 > b ? c = b * b * 0.5 : (--b, c = -0.5 * (b * (b - 2) - 1));
		return c
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseQuadraticActionInOut;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseQuadraticActionInOut(this._inner.reverse())
	}
});
cc.EaseQuadraticActionInOut.create = function(b) {
	return new cc.EaseQuadraticActionInOut(b)
};
cc._easeQuadraticActionInOut = {
	easing: cc.EaseQuadraticActionInOut.prototype._updateTime,
	reverse: function() {
		return cc._easeQuadraticActionInOut
	}
};
cc.easeQuadraticActionInOut = function() {
	return cc._easeQuadraticActionInOut
};
cc.EaseQuarticActionIn = cc.ActionEase.extend({
	_updateTime: function(b) {
		return b * b * b * b
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseQuarticActionIn;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseQuarticActionIn(this._inner.reverse())
	}
});
cc.EaseQuarticActionIn.create = function(b) {
	return new cc.EaseQuarticActionIn(b)
};
cc._easeQuarticActionIn = {
	easing: cc.EaseQuarticActionIn.prototype._updateTime,
	reverse: function() {
		return cc._easeQuarticActionIn
	}
};
cc.easeQuarticActionIn = function() {
	return cc._easeQuarticActionIn
};
cc.EaseQuarticActionOut = cc.ActionEase.extend({
	_updateTime: function(b) {
		b -= 1;
		return -(b * b * b * b - 1)
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseQuarticActionOut;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseQuarticActionOut(this._inner.reverse())
	}
});
cc.EaseQuarticActionOut.create = function(b) {
	return new cc.EaseQuarticActionOut(b)
};
cc._easeQuarticActionOut = {
	easing: cc.EaseQuarticActionOut.prototype._updateTime,
	reverse: function() {
		return cc._easeQuarticActionOut
	}
};
cc.easeQuarticActionOut = function() {
	return cc._easeQuarticActionOut
};
cc.EaseQuarticActionInOut = cc.ActionEase.extend({
	_updateTime: function(b) {
		b *= 2;
		if (1 > b) {
			return 0.5 * b * b * b * b
		}
		b -= 2;
		return -0.5 * (b * b * b * b - 2)
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseQuarticActionInOut;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseQuarticActionInOut(this._inner.reverse())
	}
});
cc.EaseQuarticActionInOut.create = function(b) {
	return new cc.EaseQuarticActionInOut(b)
};
cc._easeQuarticActionInOut = {
	easing: cc.EaseQuarticActionInOut.prototype._updateTime,
	reverse: function() {
		return cc._easeQuarticActionInOut
	}
};
cc.easeQuarticActionInOut = function() {
	return cc._easeQuarticActionInOut
};
cc.EaseQuinticActionIn = cc.ActionEase.extend({
	_updateTime: function(b) {
		return b * b * b * b * b
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseQuinticActionIn;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseQuinticActionIn(this._inner.reverse())
	}
});
cc.EaseQuinticActionIn.create = function(b) {
	return new cc.EaseQuinticActionIn(b)
};
cc._easeQuinticActionIn = {
	easing: cc.EaseQuinticActionIn.prototype._updateTime,
	reverse: function() {
		return cc._easeQuinticActionIn
	}
};
cc.easeQuinticActionIn = function() {
	return cc._easeQuinticActionIn
};
cc.EaseQuinticActionOut = cc.ActionEase.extend({
	_updateTime: function(b) {
		b -= 1;
		return b * b * b * b * b + 1
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseQuinticActionOut;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseQuinticActionOut(this._inner.reverse())
	}
});
cc.EaseQuinticActionOut.create = function(b) {
	return new cc.EaseQuinticActionOut(b)
};
cc._easeQuinticActionOut = {
	easing: cc.EaseQuinticActionOut.prototype._updateTime,
	reverse: function() {
		return cc._easeQuinticActionOut
	}
};
cc.easeQuinticActionOut = function() {
	return cc._easeQuinticActionOut
};
cc.EaseQuinticActionInOut = cc.ActionEase.extend({
	_updateTime: function(b) {
		b *= 2;
		if (1 > b) {
			return 0.5 * b * b * b * b * b
		}
		b -= 2;
		return 0.5 * (b * b * b * b * b + 2)
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseQuinticActionInOut;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseQuinticActionInOut(this._inner.reverse())
	}
});
cc.EaseQuinticActionInOut.create = function(b) {
	return new cc.EaseQuinticActionInOut(b)
};
cc._easeQuinticActionInOut = {
	easing: cc.EaseQuinticActionInOut.prototype._updateTime,
	reverse: function() {
		return cc._easeQuinticActionInOut
	}
};
cc.easeQuinticActionInOut = function() {
	return cc._easeQuinticActionInOut
};
cc.EaseCircleActionIn = cc.ActionEase.extend({
	_updateTime: function(b) {
		return -1 * (Math.sqrt(1 - b * b) - 1)
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseCircleActionIn;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseCircleActionIn(this._inner.reverse())
	}
});
cc.EaseCircleActionIn.create = function(b) {
	return new cc.EaseCircleActionIn(b)
};
cc._easeCircleActionIn = {
	easing: cc.EaseCircleActionIn.prototype._updateTime,
	reverse: function() {
		return cc._easeCircleActionIn
	}
};
cc.easeCircleActionIn = function() {
	return cc._easeCircleActionIn
};
cc.EaseCircleActionOut = cc.ActionEase.extend({
	_updateTime: function(b) {
		b -= 1;
		return Math.sqrt(1 - b * b)
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseCircleActionOut;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseCircleActionOut(this._inner.reverse())
	}
});
cc.EaseCircleActionOut.create = function(b) {
	return new cc.EaseCircleActionOut(b)
};
cc._easeCircleActionOut = {
	easing: cc.EaseCircleActionOut.prototype._updateTime,
	reverse: function() {
		return cc._easeCircleActionOut
	}
};
cc.easeCircleActionOut = function() {
	return cc._easeCircleActionOut
};
cc.EaseCircleActionInOut = cc.ActionEase.extend({
	_updateTime: function(b) {
		b *= 2;
		if (1 > b) {
			return -0.5 * (Math.sqrt(1 - b * b) - 1)
		}
		b -= 2;
		return 0.5 * (Math.sqrt(1 - b * b) + 1)
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseCircleActionInOut;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseCircleActionInOut(this._inner.reverse())
	}
});
cc.EaseCircleActionInOut.create = function(b) {
	return new cc.EaseCircleActionInOut(b)
};
cc._easeCircleActionInOut = {
	easing: cc.EaseCircleActionInOut.prototype._updateTime,
	reverse: function() {
		return cc._easeCircleActionInOut
	}
};
cc.easeCircleActionInOut = function() {
	return cc._easeCircleActionInOut
};
cc.EaseCubicActionIn = cc.ActionEase.extend({
	_updateTime: function(b) {
		return b * b * b
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseCubicActionIn;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseCubicActionIn(this._inner.reverse())
	}
});
cc.EaseCubicActionIn.create = function(b) {
	return new cc.EaseCubicActionIn(b)
};
cc._easeCubicActionIn = {
	easing: cc.EaseCubicActionIn.prototype._updateTime,
	reverse: function() {
		return cc._easeCubicActionIn
	}
};
cc.easeCubicActionIn = function() {
	return cc._easeCubicActionIn
};
cc.EaseCubicActionOut = cc.ActionEase.extend({
	_updateTime: function(b) {
		b -= 1;
		return b * b * b + 1
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseCubicActionOut;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseCubicActionOut(this._inner.reverse())
	}
});
cc.EaseCubicActionOut.create = function(b) {
	return new cc.EaseCubicActionOut(b)
};
cc._easeCubicActionOut = {
	easing: cc.EaseCubicActionOut.prototype._updateTime,
	reverse: function() {
		return cc._easeCubicActionOut
	}
};
cc.easeCubicActionOut = function() {
	return cc._easeCubicActionOut
};
cc.EaseCubicActionInOut = cc.ActionEase.extend({
	_updateTime: function(b) {
		b *= 2;
		if (1 > b) {
			return 0.5 * b * b * b
		}
		b -= 2;
		return 0.5 * (b * b * b + 2)
	},
	update: function(b) {
		this._inner.update(this._updateTime(b))
	},
	clone: function() {
		var b = new cc.EaseCubicActionInOut;
		b.initWithAction(this._inner.clone());
		return b
	},
	reverse: function() {
		return new cc.EaseCubicActionInOut(this._inner.reverse())
	}
});
cc.EaseCubicActionInOut.create = function(b) {
	return new cc.EaseCubicActionInOut(b)
};
cc._easeCubicActionInOut = {
	easing: cc.EaseCubicActionInOut.prototype._updateTime,
	reverse: function() {
		return cc._easeCubicActionInOut
	}
};
cc.easeCubicActionInOut = function() {
	return cc._easeCubicActionInOut
};
cc.cardinalSplineAt = function(b, c, d, e, f, g) {
	var h = g * g,
		k = h * g,
		m = (1 - f) / 2;
	f = m * (-k + 2 * h - g);
	var n = m * (-k + h) + (2 * k - 3 * h + 1);
	g = m * (k - 2 * h + g) + (-2 * k + 3 * h);
	h = m * (k - h);
	return cc.p(b.x * f + c.x * n + d.x * g + e.x * h, b.y * f + c.y * n + d.y * g + e.y * h)
};
cc.reverseControlPoints = function(b) {
	for (var c = [], d = b.length - 1; 0 <= d; d--) {
		c.push(cc.p(b[d].x, b[d].y))
	}
	return c
};
cc.cloneControlPoints = function(b) {
	for (var c = [], d = 0; d < b.length; d++) {
		c.push(cc.p(b[d].x, b[d].y))
	}
	return c
};
cc.copyControlPoints = cc.cloneControlPoints;
cc.getControlPointAt = function(b, c) {
	var d = Math.min(b.length - 1, Math.max(c, 0));
	return b[d]
};
cc.reverseControlPointsInline = function(b) {
	for (var c = b.length, d = 0 | c / 2, e = 0; e < d; ++e) {
		var f = b[e];
		b[e] = b[c - e - 1];
		b[c - e - 1] = f
	}
};
cc.CardinalSplineTo = cc.ActionInterval.extend({
	_points: null,
	_deltaT: 0,
	_tension: 0,
	_previousPosition: null,
	_accumulatedDiff: null,
	ctor: function(b, c, d) {
		cc.ActionInterval.prototype.ctor.call(this);
		this._points = [];
		void 0 !== d && this.initWithDuration(b, c, d)
	},
	initWithDuration: function(b, c, d) {
		if (!c || 0 === c.length) {
			throw "Invalid configuration. It must at least have one control point"
		}
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (this.setPoints(c), this._tension = d, !0) : !1
	},
	clone: function() {
		var b = new cc.CardinalSplineTo;
		b.initWithDuration(this._duration, cc.copyControlPoints(this._points), this._tension);
		return b
	},
	startWithTarget: function(b) {
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this._deltaT = 1 / (this._points.length - 1);
		this._previousPosition = cc.p(this.target.getPositionX(), this.target.getPositionY());
		this._accumulatedDiff = cc.p(0, 0)
	},
	update: function(b) {
		b = this._computeEaseTime(b);
		var c, d = this._points;
		if (1 === b) {
			c = d.length - 1, b = 1
		} else {
			var e = this._deltaT;
			c = 0 | b / e;
			b = (b - e * c) / e
		}
		c = cc.cardinalSplineAt(cc.getControlPointAt(d, c - 1), cc.getControlPointAt(d, c - 0), cc.getControlPointAt(d, c + 1), cc.getControlPointAt(d, c + 2), this._tension, b);
		cc.ENABLE_STACKABLE_ACTIONS && (d = this.target.getPositionX() - this._previousPosition.x, b = this.target.getPositionY() - this._previousPosition.y, 0 !== d || 0 !== b) && (e = this._accumulatedDiff, d = e.x + d, b = e.y + b, e.x = d, e.y = b, c.x += d, c.y += b);
		this.updatePosition(c)
	},
	reverse: function() {
		var b = cc.reverseControlPoints(this._points);
		return cc.cardinalSplineTo(this._duration, b, this._tension)
	},
	updatePosition: function(b) {
		this.target.setPosition(b);
		this._previousPosition = b
	},
	getPoints: function() {
		return this._points
	},
	setPoints: function(b) {
		this._points = b
	}
});
cc.cardinalSplineTo = function(b, c, d) {
	return new cc.CardinalSplineTo(b, c, d)
};
cc.CardinalSplineTo.create = cc.cardinalSplineTo;
cc.CardinalSplineBy = cc.CardinalSplineTo.extend({
	_startPosition: null,
	ctor: function(b, c, d) {
		cc.CardinalSplineTo.prototype.ctor.call(this);
		this._startPosition = cc.p(0, 0);
		void 0 !== d && this.initWithDuration(b, c, d)
	},
	startWithTarget: function(b) {
		cc.CardinalSplineTo.prototype.startWithTarget.call(this, b);
		this._startPosition.x = b.getPositionX();
		this._startPosition.y = b.getPositionY()
	},
	reverse: function() {
		for (var b = this._points.slice(), c, d = b[0], e = 1; e < b.length; ++e) {
			c = b[e], b[e] = cc.pSub(c, d), d = c
		}
		b = cc.reverseControlPoints(b);
		d = b[b.length - 1];
		b.pop();
		d.x = -d.x;
		d.y = -d.y;
		b.unshift(d);
		for (e = 1; e < b.length; ++e) {
			c = b[e], c.x = -c.x, c.y = -c.y, c.x += d.x, c.y += d.y, d = b[e] = c
		}
		return cc.cardinalSplineBy(this._duration, b, this._tension)
	},
	updatePosition: function(b) {
		var c = this._startPosition,
			d = b.x + c.x;
		b = b.y + c.y;
		this._previousPosition.x = d;
		this._previousPosition.y = b;
		this.target.setPosition(d, b)
	},
	clone: function() {
		var b = new cc.CardinalSplineBy;
		b.initWithDuration(this._duration, cc.copyControlPoints(this._points), this._tension);
		return b
	}
});
cc.cardinalSplineBy = function(b, c, d) {
	return new cc.CardinalSplineBy(b, c, d)
};
cc.CardinalSplineBy.create = cc.cardinalSplineBy;
cc.CatmullRomTo = cc.CardinalSplineTo.extend({
	ctor: function(b, c) {
		c && this.initWithDuration(b, c)
	},
	initWithDuration: function(b, c) {
		return cc.CardinalSplineTo.prototype.initWithDuration.call(this, b, c, 0.5)
	},
	clone: function() {
		var b = new cc.CatmullRomTo;
		b.initWithDuration(this._duration, cc.copyControlPoints(this._points));
		return b
	}
});
cc.catmullRomTo = function(b, c) {
	return new cc.CatmullRomTo(b, c)
};
cc.CatmullRomTo.create = cc.catmullRomTo;
cc.CatmullRomBy = cc.CardinalSplineBy.extend({
	ctor: function(b, c) {
		cc.CardinalSplineBy.prototype.ctor.call(this);
		c && this.initWithDuration(b, c)
	},
	initWithDuration: function(b, c) {
		return cc.CardinalSplineTo.prototype.initWithDuration.call(this, b, c, 0.5)
	},
	clone: function() {
		var b = new cc.CatmullRomBy;
		b.initWithDuration(this._duration, cc.copyControlPoints(this._points));
		return b
	}
});
cc.catmullRomBy = function(b, c) {
	return new cc.CatmullRomBy(b, c)
};
cc.CatmullRomBy.create = cc.catmullRomBy;
cc.ActionTweenDelegate = cc.Class.extend({
	updateTweenAction: function(b, c) {}
});
cc.ActionTween = cc.ActionInterval.extend({
	key: "",
	from: 0,
	to: 0,
	delta: 0,
	ctor: function(b, c, d, e) {
		cc.ActionInterval.prototype.ctor.call(this);
		this.key = "";
		void 0 !== e && this.initWithDuration(b, c, d, e)
	},
	initWithDuration: function(b, c, d, e) {
		return cc.ActionInterval.prototype.initWithDuration.call(this, b) ? (this.key = c, this.to = e, this.from = d, !0) : !1
	},
	startWithTarget: function(b) {
		if (!b || !b.updateTweenAction) {
			throw "cc.ActionTween.startWithTarget(): target must be non-null, and target must implement updateTweenAction function"
		}
		cc.ActionInterval.prototype.startWithTarget.call(this, b);
		this.delta = this.to - this.from
	},
	update: function(b) {
		this.target.updateTweenAction(this.to - this.delta * (1 - b), this.key)
	},
	reverse: function() {
		return new cc.ActionTween(this.duration, this.key, this.to, this.from)
	},
	clone: function() {
		var b = new cc.ActionTween;
		b.initWithDuration(this._duration, this.key, this.from, this.to);
		return b
	}
});
cc.actionTween = function(b, c, d, e) {
	return new cc.ActionTween(b, c, d, e)
};
cc.ActionTween.create = cc.actionTween;
cc.Codec = {
	name: "Jacob__Codec"
};
cc.unzip = function() {
	return cc.Codec.GZip.gunzip.apply(cc.Codec.GZip, arguments)
};
cc.unzipBase64 = function() {
	var b = cc.Codec.Base64.decode.apply(cc.Codec.Base64, arguments);
	return cc.Codec.GZip.gunzip.apply(cc.Codec.GZip, [b])
};
cc.unzipBase64AsArray = function(b, c) {
	c = c || 1;
	var d = this.unzipBase64(b),
		e = [],
		f, g, h;
	f = 0;
	for (h = d.length / c; f < h; f++) {
		for (e[f] = 0, g = c - 1; 0 <= g; --g) {
			e[f] += d.charCodeAt(f * c + g) << 8 * g
		}
	}
	return e
};
cc.unzipAsArray = function(b, c) {
	c = c || 1;
	var d = this.unzip(b),
		e = [],
		f, g, h;
	f = 0;
	for (h = d.length / c; f < h; f++) {
		for (e[f] = 0, g = c - 1; 0 <= g; --g) {
			e[f] += d.charCodeAt(f * c + g) << 8 * g
		}
	}
	return e
};
cc.StringToArray = function(b) {
	b = b.split(",");
	var c = [],
		d;
	for (d = 0; d < b.length; d++) {
		c.push(parseInt(b[d]))
	}
	return c
};
cc.Codec.Base64 = {
	name: "Jacob__Codec__Base64"
};
cc.Codec.Base64._keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
cc.Codec.Base64.decode = function(b) {
	var c = [],
		d, e, f, g, h, k = 0;
	for (b = b.replace(/[^A-Za-z0-9\+\/\=]/g, ""); k < b.length;) {
		d = this._keyStr.indexOf(b.charAt(k++)), e = this._keyStr.indexOf(b.charAt(k++)), g = this._keyStr.indexOf(b.charAt(k++)), h = this._keyStr.indexOf(b.charAt(k++)), d = d << 2 | e >> 4, e = (e & 15) << 4 | g >> 2, f = (g & 3) << 6 | h, c.push(String.fromCharCode(d)), 64 !== g && c.push(String.fromCharCode(e)), 64 !== h && c.push(String.fromCharCode(f))
	}
	return c = c.join("")
};
cc.Codec.Base64.decodeAsArray = function(b, c) {
	var d = this.decode(b),
		e = [],
		f, g, h;
	f = 0;
	for (h = d.length / c; f < h; f++) {
		for (e[f] = 0, g = c - 1; 0 <= g; --g) {
			e[f] += d.charCodeAt(f * c + g) << 8 * g
		}
	}
	return e
};
cc.uint8ArrayToUint32Array = function(b) {
	if (0 !== b.length % 4) {
		return null
	}
	for (var c = b.length / 4, d = window.Uint32Array ? new Uint32Array(c) : [], e = 0; e < c; e++) {
		var f = 4 * e;
		d[e] = b[f] + 256 * b[f + 1] + 65536 * b[f + 2] + 16777216 * b[f + 3]
	}
	return d
};
cc.Codec.GZip = function(b) {
	this.data = b;
	this.debug = !1;
	this.gpflags = void 0;
	this.files = 0;
	this.unzipped = [];
	this.buf32k = Array(32768);
	this.bIdx = 0;
	this.modeZIP = !1;
	this.bytepos = 0;
	this.bb = 1;
	this.bits = 0;
	this.nameBuf = [];
	this.fileout = void 0;
	this.literalTree = Array(cc.Codec.GZip.LITERALS);
	this.distanceTree = Array(32);
	this.treepos = 0;
	this.Places = null;
	this.len = 0;
	this.fpos = Array(17);
	this.fpos[0] = 0;
	this.fmax = this.flens = void 0
};
cc.Codec.GZip.gunzip = function(b) {
	return (new cc.Codec.GZip(b)).gunzip()[0][0]
};
cc.Codec.GZip.HufNode = function() {
	this.b1 = this.b0 = 0;
	this.jump = null;
	this.jumppos = -1
};
cc.Codec.GZip.LITERALS = 288;
cc.Codec.GZip.NAMEMAX = 256;
cc.Codec.GZip.bitReverse = [0, 128, 64, 192, 32, 160, 96, 224, 16, 144, 80, 208, 48, 176, 112, 240, 8, 136, 72, 200, 40, 168, 104, 232, 24, 152, 88, 216, 56, 184, 120, 248, 4, 132, 68, 196, 36, 164, 100, 228, 20, 148, 84, 212, 52, 180, 116, 244, 12, 140, 76, 204, 44, 172, 108, 236, 28, 156, 92, 220, 60, 188, 124, 252, 2, 130, 66, 194, 34, 162, 98, 226, 18, 146, 82, 210, 50, 178, 114, 242, 10, 138, 74, 202, 42, 170, 106, 234, 26, 154, 90, 218, 58, 186, 122, 250, 6, 134, 70, 198, 38, 166, 102, 230, 22, 150, 86, 214, 54, 182, 118, 246, 14, 142, 78, 206, 46, 174, 110, 238, 30, 158, 94, 222, 62, 190, 126, 254, 1, 129, 65, 193, 33, 161, 97, 225, 17, 145, 81, 209, 49, 177, 113, 241, 9, 137, 73, 201, 41, 169, 105, 233, 25, 153, 89, 217, 57, 185, 121, 249, 5, 133, 69, 197, 37, 165, 101, 229, 21, 149, 85, 213, 53, 181, 117, 245, 13, 141, 77, 205, 45, 173, 109, 237, 29, 157, 93, 221, 61, 189, 125, 253, 3, 131, 67, 195, 35, 163, 99, 227, 19, 147, 83, 211, 51, 179, 115, 243, 11, 139, 75, 203, 43, 171, 107, 235, 27, 155, 91, 219, 59, 187, 123, 251, 7, 135, 71, 199, 39, 167, 103, 231, 23, 151, 87, 215, 55, 183, 119, 247, 15, 143, 79, 207, 47, 175, 111, 239, 31, 159, 95, 223, 63, 191, 127, 255];
cc.Codec.GZip.cplens = [3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 15, 17, 19, 23, 27, 31, 35, 43, 51, 59, 67, 83, 99, 115, 131, 163, 195, 227, 258, 0, 0];
cc.Codec.GZip.cplext = [0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 0, 99, 99];
cc.Codec.GZip.cpdist = [1, 2, 3, 4, 5, 7, 9, 13, 17, 25, 33, 49, 65, 97, 129, 193, 257, 385, 513, 769, 1025, 1537, 2049, 3073, 4097, 6145, 8193, 12289, 16385, 24577];
cc.Codec.GZip.cpdext = [0, 0, 0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9, 10, 10, 11, 11, 12, 12, 13, 13];
cc.Codec.GZip.border = [16, 17, 18, 0, 8, 7, 9, 6, 10, 5, 11, 4, 12, 3, 13, 2, 14, 1, 15];
cc.Codec.GZip.prototype.gunzip = function() {
	this.outputArr = [];
	this.nextFile();
	return this.unzipped
};
cc.Codec.GZip.prototype.readByte = function() {
	this.bits += 8;
	return this.bytepos < this.data.length ? this.data.charCodeAt(this.bytepos++) : -1
};
cc.Codec.GZip.prototype.byteAlign = function() {
	this.bb = 1
};
cc.Codec.GZip.prototype.readBit = function() {
	var b;
	this.bits++;
	b = this.bb & 1;
	this.bb >>= 1;
	0 === this.bb && (this.bb = this.readByte(), b = this.bb & 1, this.bb = this.bb >> 1 | 128);
	return b
};
cc.Codec.GZip.prototype.readBits = function(b) {
	for (var c = 0, d = b; d--;) {
		c = c << 1 | this.readBit()
	}
	b && (c = cc.Codec.GZip.bitReverse[c] >> 8 - b);
	return c
};
cc.Codec.GZip.prototype.flushBuffer = function() {
	this.bIdx = 0
};
cc.Codec.GZip.prototype.addBuffer = function(b) {
	this.buf32k[this.bIdx++] = b;
	this.outputArr.push(String.fromCharCode(b));
	32768 === this.bIdx && (this.bIdx = 0)
};
cc.Codec.GZip.prototype.IsPat = function() {
	for (;;) {
		if (this.fpos[this.len] >= this.fmax) {
			return -1
		}
		if (this.flens[this.fpos[this.len]] === this.len) {
			return this.fpos[this.len]++
		}
		this.fpos[this.len]++
	}
};
cc.Codec.GZip.prototype.Rec = function() {
	var b = this.Places[this.treepos],
		c;
	if (17 === this.len) {
		return -1
	}
	this.treepos++;
	this.len++;
	c = this.IsPat();
	if (0 <= c) {
		b.b0 = c
	} else {
		if (b.b0 = 32768, this.Rec()) {
			return -1
		}
	}
	c = this.IsPat();
	if (0 <= c) {
		b.b1 = c, b.jump = null
	} else {
		if (b.b1 = 32768, b.jump = this.Places[this.treepos], b.jumppos = this.treepos, this.Rec()) {
			return -1
		}
	}
	this.len--;
	return 0
};
cc.Codec.GZip.prototype.CreateTree = function(b, c, d, e) {
	this.Places = b;
	this.treepos = 0;
	this.flens = d;
	this.fmax = c;
	for (b = 0; 17 > b; b++) {
		this.fpos[b] = 0
	}
	this.len = 0;
	return this.Rec() ? -1 : 0
};
cc.Codec.GZip.prototype.DecodeValue = function(b) {
	for (var c, d, e = 0, f = b[e];;) {
		if (c = this.readBit()) {
			if (!(f.b1 & 32768)) {
				return f.b1
			}
			f = f.jump;
			c = b.length;
			for (d = 0; d < c; d++) {
				if (b[d] === f) {
					e = d;
					break
				}
			}
		} else {
			if (!(f.b0 & 32768)) {
				return f.b0
			}
			e++;
			f = b[e]
		}
	}
	return -1
};
cc.Codec.GZip.prototype.DeflateLoop = function() {
	var b, c, d, e, f;
	do {
		if (b = this.readBit(), d = this.readBits(2), 0 === d) {
			for (this.byteAlign(), d = this.readByte(), d |= this.readByte() << 8, c = this.readByte(), c |= this.readByte() << 8, (d ^ ~c) & 65535 && document.write("BlockLen checksum mismatch\n"); d--;) {
				c = this.readByte(), this.addBuffer(c)
			}
		} else {
			if (1 === d) {
				for (;;) {
					if (d = cc.Codec.GZip.bitReverse[this.readBits(7)] >> 1, 23 < d ? (d = d << 1 | this.readBit(), 199 < d ? (d -= 128, d = d << 1 | this.readBit()) : (d -= 48, 143 < d && (d += 136))) : d += 256, 256 > d) {
						this.addBuffer(d)
					} else {
						if (256 === d) {
							break
						} else {
							var g;
							d -= 257;
							f = this.readBits(cc.Codec.GZip.cplext[d]) + cc.Codec.GZip.cplens[d];
							d = cc.Codec.GZip.bitReverse[this.readBits(5)] >> 3;
							8 < cc.Codec.GZip.cpdext[d] ? (g = this.readBits(8), g |= this.readBits(cc.Codec.GZip.cpdext[d] - 8) << 8) : g = this.readBits(cc.Codec.GZip.cpdext[d]);
							g += cc.Codec.GZip.cpdist[d];
							for (d = 0; d < f; d++) {
								c = this.buf32k[this.bIdx - g & 32767], this.addBuffer(c)
							}
						}
					}
				}
			} else {
				if (2 === d) {
					var h = Array(320);
					c = 257 + this.readBits(5);
					g = 1 + this.readBits(5);
					e = 4 + this.readBits(4);
					for (d = 0; 19 > d; d++) {
						h[d] = 0
					}
					for (d = 0; d < e; d++) {
						h[cc.Codec.GZip.border[d]] = this.readBits(3)
					}
					f = this.distanceTree.length;
					for (e = 0; e < f; e++) {
						this.distanceTree[e] = new cc.Codec.GZip.HufNode
					}
					if (this.CreateTree(this.distanceTree, 19, h, 0)) {
						return this.flushBuffer(), 1
					}
					f = c + g;
					e = 0;
					for (var k = -1; e < f;) {
						if (k++, d = this.DecodeValue(this.distanceTree), 16 > d) {
							h[e++] = d
						} else {
							if (16 === d) {
								var m;
								d = 3 + this.readBits(2);
								if (e + d > f) {
									return this.flushBuffer(), 1
								}
								for (m = e ? h[e - 1] : 0; d--;) {
									h[e++] = m
								}
							} else {
								d = 17 === d ? 3 + this.readBits(3) : 11 + this.readBits(7);
								if (e + d > f) {
									return this.flushBuffer(), 1
								}
								for (; d--;) {
									h[e++] = 0
								}
							}
						}
					}
					f = this.literalTree.length;
					for (e = 0; e < f; e++) {
						this.literalTree[e] = new cc.Codec.GZip.HufNode
					}
					if (this.CreateTree(this.literalTree, c, h, 0)) {
						return this.flushBuffer(), 1
					}
					f = this.literalTree.length;
					for (e = 0; e < f; e++) {
						this.distanceTree[e] = new cc.Codec.GZip.HufNode
					}
					d = [];
					for (e = c; e < h.length; e++) {
						d[e - c] = h[e]
					}
					if (this.CreateTree(this.distanceTree, g, d, 0)) {
						return this.flushBuffer(), 1
					}
					for (;;) {
						if (d = this.DecodeValue(this.literalTree), 256 <= d) {
							d -= 256;
							if (0 === d) {
								break
							}
							d--;
							f = this.readBits(cc.Codec.GZip.cplext[d]) + cc.Codec.GZip.cplens[d];
							d = this.DecodeValue(this.distanceTree);
							8 < cc.Codec.GZip.cpdext[d] ? (g = this.readBits(8), g |= this.readBits(cc.Codec.GZip.cpdext[d] - 8) << 8) : g = this.readBits(cc.Codec.GZip.cpdext[d]);
							for (g += cc.Codec.GZip.cpdist[d]; f--;) {
								c = this.buf32k[this.bIdx - g & 32767], this.addBuffer(c)
							}
						} else {
							this.addBuffer(d)
						}
					}
				}
			}
		}
	} while (!b);
	this.flushBuffer();
	this.byteAlign();
	return 0
};
cc.Codec.GZip.prototype.unzipFile = function(b) {
	var c;
	this.gunzip();
	for (c = 0; c < this.unzipped.length; c++) {
		if (this.unzipped[c][1] === b) {
			return this.unzipped[c][0]
		}
	}
};
cc.Codec.GZip.prototype.nextFile = function() {
	this.outputArr = [];
	this.modeZIP = !1;
	var b = [];
	b[0] = this.readByte();
	b[1] = this.readByte();
	120 === b[0] && 218 === b[1] && (this.DeflateLoop(), this.unzipped[this.files] = [this.outputArr.join(""), "geonext.gxt"], this.files++);
	31 === b[0] && 139 === b[1] && (this.skipdir(), this.unzipped[this.files] = [this.outputArr.join(""), "file"], this.files++);
	if (80 === b[0] && 75 === b[1] && (this.modeZIP = !0, b[2] = this.readByte(), b[3] = this.readByte(), 3 === b[2] && 4 === b[3])) {
		b[0] = this.readByte();
		b[1] = this.readByte();
		this.gpflags = this.readByte();
		this.gpflags |= this.readByte() << 8;
		b = this.readByte();
		b |= this.readByte() << 8;
		this.readByte();
		this.readByte();
		this.readByte();
		this.readByte();
		this.readByte();
		this.readByte();
		this.readByte();
		this.readByte();
		this.readByte();
		this.readByte();
		this.readByte();
		this.readByte();
		var c = this.readByte(),
			c = c | this.readByte() << 8,
			d = this.readByte(),
			d = d | this.readByte() << 8,
			e = 0;
		for (this.nameBuf = []; c--;) {
			var f = this.readByte();
			"/" === f | ":" === f ? e = 0 : e < cc.Codec.GZip.NAMEMAX - 1 && (this.nameBuf[e++] = String.fromCharCode(f))
		}
		this.fileout || (this.fileout = this.nameBuf);
		for (var e = 0; e < d;) {
			this.readByte(), e++
		}
		8 === b && (this.DeflateLoop(), this.unzipped[this.files] = [this.outputArr.join(""), this.nameBuf.join("")], this.files++);
		this.skipdir()
	}
};
cc.Codec.GZip.prototype.skipdir = function() {
	var b = [],
		c;
	this.gpflags & 8 && (b[0] = this.readByte(), b[1] = this.readByte(), b[2] = this.readByte(), b[3] = this.readByte(), this.readByte(), this.readByte(), this.readByte(), this.readByte(), this.readByte(), this.readByte(), this.readByte(), this.readByte());
	this.modeZIP && this.nextFile();
	b[0] = this.readByte();
	if (8 !== b[0]) {
		return 0
	}
	this.gpflags = this.readByte();
	this.readByte();
	this.readByte();
	this.readByte();
	this.readByte();
	this.readByte();
	this.readByte();
	if (this.gpflags & 4) {
		for (b[0] = this.readByte(), b[2] = this.readByte(), this.len = b[0] + 256 * b[1], b = 0; b < this.len; b++) {
			this.readByte()
		}
	}
	if (this.gpflags & 8) {
		for (b = 0, this.nameBuf = []; c = this.readByte();) {
			if ("7" === c || ":" === c) {
				b = 0
			}
			b < cc.Codec.GZip.NAMEMAX - 1 && (this.nameBuf[b++] = c)
		}
	}
	if (this.gpflags & 16) {
		for (; this.readByte();) {}
	}
	this.gpflags & 2 && (this.readByte(), this.readByte());
	this.DeflateLoop();
	this.readByte();
	this.readByte();
	this.readByte();
	this.readByte();
	this.modeZIP && this.nextFile()
};
(function() {
	function b(b) {
		throw b
	}
	function c(b, c) {
		var d = b.split("."),
			e = B;
		d[0] in e || !e.execScript || e.execScript("var " + d[0]);
		for (var f; d.length && (f = d.shift());) {
			d.length || c === E ? e = e[f] ? e[f] : e[f] = {} : e[f] = c
		}
	}
	function d(b) {
		if ("string" === typeof b) {
			b = b.split("");
			var c, d;
			c = 0;
			for (d = b.length; c < d; c++) {
				b[c] = (b[c].charCodeAt(0) & 255) >>> 0
			}
		}
		c = 1;
		d = 0;
		for (var e = b.length, f, g = 0; 0 < e;) {
			f = 1024 < e ? 1024 : e;
			e -= f;
			do {
				c += b[g++], d += c
			} while (--f);
			c %= 65521;
			d %= 65521
		}
		return (d << 16 | c) >>> 0
	}
	function e(c, d) {
		this.index = "number" === typeof d ? d : 0;
		this.i = 0;
		this.buffer = c instanceof(x ? Uint8Array : Array) ? c : new(x ? Uint8Array : Array)(32768);
		2 * this.buffer.length <= this.index && b(Error("invalid index"));
		this.buffer.length <= this.index && this.f()
	}
	function f(b) {
		this.buffer = new(x ? Uint16Array : Array)(2 * b);
		this.length = 0
	}
	function g(b) {
		var c = b.length,
			d = 0,
			e = Number.POSITIVE_INFINITY,
			f, g, h, k, m, n, p, r, t;
		for (r = 0; r < c; ++r) {
			b[r] > d && (d = b[r]), b[r] < e && (e = b[r])
		}
		f = 1 << d;
		g = new(x ? Uint32Array : Array)(f);
		h = 1;
		k = 0;
		for (m = 2; h <= d;) {
			for (r = 0; r < c; ++r) {
				if (b[r] === h) {
					n = 0;
					p = k;
					for (t = 0; t < h; ++t) {
						n = n << 1 | p & 1, p >>= 1
					}
					for (t = n; t < f; t += m) {
						g[t] = h << 16 | r
					}++k
				}
			}++h;
			k <<= 1;
			m <<= 1
		}
		return [g, d, e]
	}
	function h(b, c) {
		this.h = K;
		this.w = 0;
		this.input = b;
		this.b = 0;
		c && (c.lazy && (this.w = c.lazy), "number" === typeof c.compressionType && (this.h = c.compressionType), c.outputBuffer && (this.a = x && c.outputBuffer instanceof Array ? new Uint8Array(c.outputBuffer) : c.outputBuffer), "number" === typeof c.outputIndex && (this.b = c.outputIndex));
		this.a || (this.a = new(x ? Uint8Array : Array)(32768))
	}
	function k(b, c) {
		this.length = b;
		this.G = c
	}
	function m() {
		var c = L;
		switch (F) {
		case 3 === c:
			return [257, c - 3, 0];
		case 4 === c:
			return [258, c - 4, 0];
		case 5 === c:
			return [259, c - 5, 0];
		case 6 === c:
			return [260, c - 6, 0];
		case 7 === c:
			return [261, c - 7, 0];
		case 8 === c:
			return [262, c - 8, 0];
		case 9 === c:
			return [263, c - 9, 0];
		case 10 === c:
			return [264, c - 10, 0];
		case 12 >= c:
			return [265, c - 11, 1];
		case 14 >= c:
			return [266, c - 13, 1];
		case 16 >= c:
			return [267, c - 15, 1];
		case 18 >= c:
			return [268, c - 17, 1];
		case 22 >= c:
			return [269, c - 19, 2];
		case 26 >= c:
			return [270, c - 23, 2];
		case 30 >= c:
			return [271, c - 27, 2];
		case 34 >= c:
			return [272, c - 31, 2];
		case 42 >= c:
			return [273, c - 35, 3];
		case 50 >= c:
			return [274, c - 43, 3];
		case 58 >= c:
			return [275, c - 51, 3];
		case 66 >= c:
			return [276, c - 59, 3];
		case 82 >= c:
			return [277, c - 67, 4];
		case 98 >= c:
			return [278, c - 83, 4];
		case 114 >= c:
			return [279, c - 99, 4];
		case 130 >= c:
			return [280, c - 115, 4];
		case 162 >= c:
			return [281, c - 131, 5];
		case 194 >= c:
			return [282, c - 163, 5];
		case 226 >= c:
			return [283, c - 195, 5];
		case 257 >= c:
			return [284, c - 227, 5];
		case 258 === c:
			return [285, c - 258, 0];
		default:
			b("invalid length: " + c)
		}
	}
	function n(c, d) {
		function e(c, d) {
			var f = c.G,
				g = [],
				h = 0,
				k;
			k = O[c.length];
			g[h++] = k & 65535;
			g[h++] = k >> 16 & 255;
			g[h++] = k >> 24;
			var m;
			switch (F) {
			case 1 === f:
				m = [0, f - 1, 0];
				break;
			case 2 === f:
				m = [1, f - 2, 0];
				break;
			case 3 === f:
				m = [2, f - 3, 0];
				break;
			case 4 === f:
				m = [3, f - 4, 0];
				break;
			case 6 >= f:
				m = [4, f - 5, 1];
				break;
			case 8 >= f:
				m = [5, f - 7, 1];
				break;
			case 12 >= f:
				m = [6, f - 9, 2];
				break;
			case 16 >= f:
				m = [7, f - 13, 2];
				break;
			case 24 >= f:
				m = [8, f - 17, 3];
				break;
			case 32 >= f:
				m = [9, f - 25, 3];
				break;
			case 48 >= f:
				m = [10, f - 33, 4];
				break;
			case 64 >= f:
				m = [11, f - 49, 4];
				break;
			case 96 >= f:
				m = [12, f - 65, 5];
				break;
			case 128 >= f:
				m = [13, f - 97, 5];
				break;
			case 192 >= f:
				m = [14, f - 129, 6];
				break;
			case 256 >= f:
				m = [15, f - 193, 6];
				break;
			case 384 >= f:
				m = [16, f - 257, 7];
				break;
			case 512 >= f:
				m = [17, f - 385, 7];
				break;
			case 768 >= f:
				m = [18, f - 513, 8];
				break;
			case 1024 >= f:
				m = [19, f - 769, 8];
				break;
			case 1536 >= f:
				m = [20, f - 1025, 9];
				break;
			case 2048 >= f:
				m = [21, f - 1537, 9];
				break;
			case 3072 >= f:
				m = [22, f - 2049, 10];
				break;
			case 4096 >= f:
				m = [23, f - 3073, 10];
				break;
			case 6144 >= f:
				m = [24, f - 4097, 11];
				break;
			case 8192 >= f:
				m = [25, f - 6145, 11];
				break;
			case 12288 >= f:
				m = [26, f - 8193, 12];
				break;
			case 16384 >= f:
				m = [27, f - 12289, 12];
				break;
			case 24576 >= f:
				m = [28, f - 16385, 13];
				break;
			case 32768 >= f:
				m = [29, f - 24577, 13];
				break;
			default:
				b("invalid distance")
			}
			k = m;
			g[h++] = k[0];
			g[h++] = k[1];
			g[h++] = k[2];
			f = 0;
			for (h = g.length; f < h; ++f) {
				t[s++] = g[f]
			}
			v[g[0]]++;
			w[g[3]]++;
			u = c.length + d - 1;
			r = null
		}
		var f, g, h, m, n, p = {},
			r, t = x ? new Uint16Array(2 * d.length) : [],
			s = 0,
			u = 0,
			v = new(x ? Uint32Array : Array)(286),
			w = new(x ? Uint32Array : Array)(30),
			C = c.w,
			D;
		if (!x) {
			for (h = 0; 285 >= h;) {
				v[h++] = 0
			}
			for (h = 0; 29 >= h;) {
				w[h++] = 0
			}
		}
		v[256] = 1;
		f = 0;
		for (g = d.length; f < g; ++f) {
			h = n = 0;
			for (m = 3; h < m && f + h !== g; ++h) {
				n = n << 8 | d[f + h]
			}
			p[n] === E && (p[n] = []);
			h = p[n];
			if (!(0 < u--)) {
				for (; 0 < h.length && 32768 < f - h[0];) {
					h.shift()
				}
				if (f + 3 >= g) {
					r && e(r, -1);
					h = 0;
					for (m = g - f; h < m; ++h) {
						D = d[f + h], t[s++] = D, ++v[D]
					}
					break
				}
				if (0 < h.length) {
					n = m = E;
					var A = 0,
						y = E,
						B = E,
						z = y = E,
						I = d.length,
						B = 0,
						z = h.length;
					a: for (; B < z; B++) {
						m = h[z - B - 1];
						y = 3;
						if (3 < A) {
							for (y = A; 3 < y; y--) {
								if (d[m + y - 1] !== d[f + y - 1]) {
									continue a
								}
							}
							y = A
						}
						for (; 258 > y && f + y < I && d[m + y] === d[f + y];) {
							++y
						}
						y > A && (n = m, A = y);
						if (258 === y) {
							break
						}
					}
					m = new k(A, f - n);
					r ? r.length < m.length ? (D = d[f - 1], t[s++] = D, ++v[D], e(m, 0)) : e(r, -1) : m.length < C ? r = m : e(m, 0)
				} else {
					r ? e(r, -1) : (D = d[f], t[s++] = D, ++v[D])
				}
			}
			h.push(f)
		}
		t[s++] = 256;
		v[256]++;
		c.L = v;
		c.K = w;
		return x ? t.subarray(0, s) : t
	}
	function p(b, c) {
		function d(b) {
			var c = t[b][s[b]];
			c === p ? (d(b + 1), d(b + 1)) : --r[c];
			++s[b]
		}
		var e = b.length,
			g = new f(572),
			h = new(x ? Uint8Array : Array)(e),
			k, m, n;
		if (!x) {
			for (m = 0; m < e; m++) {
				h[m] = 0
			}
		}
		for (m = 0; m < e; ++m) {
			0 < b[m] && g.push(m, b[m])
		}
		e = Array(g.length / 2);
		k = new(x ? Uint32Array : Array)(g.length / 2);
		if (1 === e.length) {
			return h[g.pop().index] = 1, h
		}
		m = 0;
		for (n = g.length / 2; m < n; ++m) {
			e[m] = g.pop(), k[m] = e[m].value
		}
		var p = k.length;
		m = new(x ? Uint16Array : Array)(c);
		var g = new(x ? Uint8Array : Array)(c),
			r = new(x ? Uint8Array : Array)(p);
		n = Array(c);
		var t = Array(c),
			s = Array(c),
			u = (1 << c) - p,
			v = 1 << c - 1,
			w, y, A;
		m[c - 1] = p;
		for (w = 0; w < c; ++w) {
			u < v ? g[w] = 0 : (g[w] = 1, u -= v), u <<= 1, m[c - 2 - w] = (m[c - 1 - w] / 2 | 0) + p
		}
		m[0] = g[0];
		n[0] = Array(m[0]);
		t[0] = Array(m[0]);
		for (w = 1; w < c; ++w) {
			m[w] > 2 * m[w - 1] + g[w] && (m[w] = 2 * m[w - 1] + g[w]), n[w] = Array(m[w]), t[w] = Array(m[w])
		}
		for (u = 0; u < p; ++u) {
			r[u] = c
		}
		for (v = 0; v < m[c - 1]; ++v) {
			n[c - 1][v] = k[v], t[c - 1][v] = v
		}
		for (u = 0; u < c; ++u) {
			s[u] = 0
		}
		1 === g[c - 1] && (--r[0], ++s[c - 1]);
		for (w = c - 2; 0 <= w; --w) {
			y = u = 0;
			A = s[w + 1];
			for (v = 0; v < m[w]; v++) {
				y = n[w + 1][A] + n[w + 1][A + 1], y > k[u] ? (n[w][v] = y, t[w][v] = p, A += 2) : (n[w][v] = k[u], t[w][v] = u, ++u)
			}
			s[w] = 0;
			1 === g[w] && d(w)
		}
		k = r;
		m = 0;
		for (n = e.length; m < n; ++m) {
			h[e[m].index] = k[m]
		}
		return h
	}
	function r(c) {
		var d = new(x ? Uint16Array : Array)(c.length),
			e = [],
			f = [],
			g = 0,
			h, k, m;
		h = 0;
		for (k = c.length; h < k; h++) {
			e[c[h]] = (e[c[h]] | 0) + 1
		}
		h = 1;
		for (k = 16; h <= k; h++) {
			f[h] = g, g += e[h] | 0, g > 1 << h && b("overcommitted"), g <<= 1
		}
		65536 > g && b("undercommitted");
		h = 0;
		for (k = c.length; h < k; h++) {
			for (g = f[c[h]], f[c[h]] += 1, e = d[h] = 0, m = c[h]; e < m; e++) {
				d[h] = d[h] << 1 | g & 1, g >>>= 1
			}
		}
		return d
	}
	function t(b, c) {
		this.input = b;
		this.a = new(x ? Uint8Array : Array)(32768);
		this.h = J.j;
		var d = {},
			e;
		!c && (c = {}) || "number" !== typeof c.compressionType || (this.h = c.compressionType);
		for (e in c) {
			d[e] = c[e]
		}
		d.outputBuffer = this.a;
		this.z = new h(this.input, d)
	}
	function s(c, d) {
		this.k = [];
		this.l = 32768;
		this.e = this.g = this.c = this.q = 0;
		this.input = x ? new Uint8Array(c) : c;
		this.s = !1;
		this.m = N;
		this.B = !1;
		if (d || !(d = {})) {
			d.index && (this.c = d.index), d.bufferSize && (this.l = d.bufferSize), d.bufferType && (this.m = d.bufferType), d.resize && (this.B = d.resize)
		}
		switch (this.m) {
		case P:
			this.b = 32768;
			this.a = new(x ? Uint8Array : Array)(32768 + this.l + 258);
			break;
		case N:
			this.b = 0;
			this.a = new(x ? Uint8Array : Array)(this.l);
			this.f = this.J;
			this.t = this.H;
			this.o = this.I;
			break;
		default:
			b(Error("invalid inflate mode"))
		}
	}
	function v(c, d) {
		for (var e = c.g, f = c.e, g = c.input, h = c.c, k; f < d;) {
			k = g[h++], k === E && b(Error("input buffer is broken")), e |= k << f, f += 8
		}
		c.g = e >>> d;
		c.e = f - d;
		c.c = h;
		return e & (1 << d) - 1
	}
	function u(c, d) {
		for (var e = c.g, f = c.e, g = c.input, h = c.c, k = d[0], m = d[1], n; f < m;) {
			n = g[h++], n === E && b(Error("input buffer is broken")), e |= n << f, f += 8
		}
		g = k[e & (1 << m) - 1];
		k = g >>> 16;
		c.g = e >> k;
		c.e = f - k;
		c.c = h;
		return g & 65535
	}
	function A(b) {
		function c(b, d, e) {
			var f, g, h, k;
			for (k = 0; k < b;) {
				switch (f = u(this, d), f) {
				case 16:
					for (h = 3 + v(this, 2); h--;) {
						e[k++] = g
					}
					break;
				case 17:
					for (h = 3 + v(this, 3); h--;) {
						e[k++] = 0
					}
					g = 0;
					break;
				case 18:
					for (h = 11 + v(this, 7); h--;) {
						e[k++] = 0
					}
					g = 0;
					break;
				default:
					g = e[k++] = f
				}
			}
			return e
		}
		var d = v(b, 5) + 257,
			e = v(b, 5) + 1,
			f = v(b, 4) + 4,
			h = new(x ? Uint8Array : Array)(Q.length),
			k;
		for (k = 0; k < f; ++k) {
			h[Q[k]] = v(b, 3)
		}
		f = g(h);
		h = new(x ? Uint8Array : Array)(d);
		k = new(x ? Uint8Array : Array)(e);
		b.o(g(c.call(b, d, f, h)), g(c.call(b, e, f, k)))
	}
	function y(c, d) {
		var e, f;
		this.input = c;
		this.c = 0;
		if (d || !(d = {})) {
			d.index && (this.c = d.index), d.verify && (this.M = d.verify)
		}
		e = c[this.c++];
		f = c[this.c++];
		switch (e & 15) {
		case T:
			this.method = T;
			break;
		default:
			b(Error("unsupported compression method"))
		}
		0 !== ((e << 8) + f) % 31 && b(Error("invalid fcheck flag:" + ((e << 8) + f) % 31));
		f & 32 && b(Error("fdict flag is not supported"));
		this.A = new s(c, {
			index: this.c,
			bufferSize: d.bufferSize,
			bufferType: d.bufferType,
			resize: d.resize
		})
	}
	var E = void 0,
		F = !0,
		B = this,
		x = "undefined" !== typeof Uint8Array && "undefined" !== typeof Uint16Array && "undefined" !== typeof Uint32Array;
	e.prototype.f = function() {
		var b = this.buffer,
			c, d = b.length,
			e = new(x ? Uint8Array : Array)(d << 1);
		if (x) {
			e.set(b)
		} else {
			for (c = 0; c < d; ++c) {
				e[c] = b[c]
			}
		}
		return this.buffer = e
	};
	e.prototype.d = function(b, c, d) {
		var e = this.buffer,
			f = this.index,
			g = this.i,
			h = e[f];
		d && 1 < c && (b = 8 < c ? (I[b & 255] << 24 | I[b >>> 8 & 255] << 16 | I[b >>> 16 & 255] << 8 | I[b >>> 24 & 255]) >> 32 - c : I[b] >> 8 - c);
		if (8 > c + g) {
			h = h << c | b, g += c
		} else {
			for (d = 0; d < c; ++d) {
				h = h << 1 | b >> c - d - 1 & 1, 8 === ++g && (g = 0, e[f++] = I[h], h = 0, f === e.length && (e = this.f()))
			}
		}
		e[f] = h;
		this.buffer = e;
		this.i = g;
		this.index = f
	};
	e.prototype.finish = function() {
		var b = this.buffer,
			c = this.index,
			d;
		0 < this.i && (b[c] <<= 8 - this.i, b[c] = I[b[c]], c++);
		x ? d = b.subarray(0, c) : (b.length = c, d = b);
		return d
	};
	var C = new(x ? Uint8Array : Array)(256),
		w;
	for (w = 0; 256 > w; ++w) {
		for (var z = w, G = z, H = 7, z = z >>> 1; z; z >>>= 1) {
			G <<= 1, G |= z & 1, --H
		}
		C[w] = (G << H & 255) >>> 0
	}
	var I = C,
		C = [0, 1996959894, 3993919788, 2567524794, 124634137, 1886057615, 3915621685, 2657392035, 249268274, 2044508324, 3772115230, 2547177864, 162941995, 2125561021, 3887607047, 2428444049, 498536548, 1789927666, 4089016648, 2227061214, 450548861, 1843258603, 4107580753, 2211677639, 325883990, 1684777152, 4251122042, 2321926636, 335633487, 1661365465, 4195302755, 2366115317, 997073096, 1281953886, 3579855332, 2724688242, 1006888145, 1258607687, 3524101629, 2768942443, 901097722, 1119000684, 3686517206, 2898065728, 853044451, 1172266101, 3705015759, 2882616665, 651767980, 1373503546, 3369554304, 3218104598, 565507253, 1454621731, 3485111705, 3099436303, 671266974, 1594198024, 3322730930, 2970347812, 795835527, 1483230225, 3244367275, 3060149565, 1994146192, 31158534, 2563907772, 4023717930, 1907459465, 112637215, 2680153253, 3904427059, 2013776290, 251722036, 2517215374, 3775830040, 2137656763, 141376813, 2439277719, 3865271297, 1802195444, 476864866, 2238001368, 4066508878, 1812370925, 453092731, 2181625025, 4111451223, 1706088902, 314042704, 2344532202, 4240017532, 1658658271, 366619977, 2362670323, 4224994405, 1303535960, 984961486, 2747007092, 3569037538, 1256170817, 1037604311, 2765210733, 3554079995, 1131014506, 879679996, 2909243462, 3663771856, 1141124467, 855842277, 2852801631, 3708648649, 1342533948, 654459306, 3188396048, 3373015174, 1466479909, 544179635, 3110523913, 3462522015, 1591671054, 702138776, 2966460450, 3352799412, 1504918807, 783551873, 3082640443, 3233442989, 3988292384, 2596254646, 62317068, 1957810842, 3939845945, 2647816111, 81470997, 1943803523, 3814918930, 2489596804, 225274430, 2053790376, 3826175755, 2466906013, 167816743, 2097651377, 4027552580, 2265490386, 503444072, 1762050814, 4150417245, 2154129355, 426522225, 1852507879, 4275313526, 2312317920, 282753626, 1742555852, 4189708143, 2394877945, 397917763, 1622183637, 3604390888, 2714866558, 953729732, 1340076626, 3518719985, 2797360999, 1068828381, 1219638859, 3624741850, 2936675148, 906185462, 1090812512, 3747672003, 2825379669, 829329135, 1181335161, 3412177804, 3160834842, 628085408, 1382605366, 3423369109, 3138078467, 570562233, 1426400815, 3317316542, 2998733608, 733239954, 1555261956, 3268935591, 3050360625, 752459403, 1541320221, 2607071920, 3965973030, 1969922972, 40735498, 2617837225, 3943577151, 1913087877, 83908371, 2512341634, 3803740692, 2075208622, 213261112, 2463272603, 3855990285, 2094854071, 198958881, 2262029012, 4057260610, 1759359992, 534414190, 2176718541, 4139329115, 1873836001, 414664567, 2282248934, 4279200368, 1711684554, 285281116, 2405801727, 4167216745, 1634467795, 376229701, 2685067896, 3608007406, 1308918612, 956543938, 2808555105, 3495958263, 1231636301, 1047427035, 2932959818, 3654703836, 1088359270, 936918000, 2847714899, 3736837829, 1202900863, 817233897, 3183342108, 3401237130, 1404277552, 615818150, 3134207493, 3453421203, 1423857449, 601450431, 3009837614, 3294710456, 1567103746, 711928724, 3020668471, 3272380065, 1510334235, 755167117];
	x && new Uint32Array(C);
	f.prototype.getParent = function(b) {
		return 2 * ((b - 2) / 4 | 0)
	};
	f.prototype.push = function(b, c) {
		var d, e, f = this.buffer,
			g;
		d = this.length;
		f[this.length++] = c;
		for (f[this.length++] = b; 0 < d;) {
			if (e = this.getParent(d), f[d] > f[e]) {
				g = f[d], f[d] = f[e], f[e] = g, g = f[d + 1], f[d + 1] = f[e + 1], f[e + 1] = g, d = e
			} else {
				break
			}
		}
		return this.length
	};
	f.prototype.pop = function() {
		var b, c, d = this.buffer,
			e, f, g;
		c = d[0];
		b = d[1];
		this.length -= 2;
		d[0] = d[this.length];
		d[1] = d[this.length + 1];
		for (g = 0;;) {
			f = 2 * g + 2;
			if (f >= this.length) {
				break
			}
			f + 2 < this.length && d[f + 2] > d[f] && (f += 2);
			if (d[f] > d[g]) {
				e = d[g], d[g] = d[f], d[f] = e, e = d[g + 1], d[g + 1] = d[f + 1], d[f + 1] = e
			} else {
				break
			}
			g = f
		}
		return {
			index: b,
			value: c,
			length: this.length
		}
	};
	var K = 2,
		C = {
			NONE: 0,
			r: 1,
			j: K,
			N: 3
		},
		M = [];
	for (w = 0; 288 > w; w++) {
		switch (F) {
		case 143 >= w:
			M.push([w + 48, 8]);
			break;
		case 255 >= w:
			M.push([w - 144 + 400, 9]);
			break;
		case 279 >= w:
			M.push([w - 256 + 0, 7]);
			break;
		case 287 >= w:
			M.push([w - 280 + 192, 8]);
			break;
		default:
			b("invalid literal: " + w)
		}
	}
	h.prototype.n = function() {
		var c, d, f, g, h = this.input;
		switch (this.h) {
		case 0:
			f = 0;
			for (g = h.length; f < g;) {
				d = x ? h.subarray(f, f + 65535) : h.slice(f, f + 65535);
				f += d.length;
				var k = f === g,
					m = E,
					t = m = E,
					t = m = E,
					s = this.a,
					u = this.b;
				if (x) {
					for (s = new Uint8Array(this.a.buffer); s.length <= u + d.length + 5;) {
						s = new Uint8Array(s.length << 1)
					}
					s.set(this.a)
				}
				m = k ? 1 : 0;
				s[u++] = m | 0;
				m = d.length;
				t = ~m + 65536 & 65535;
				s[u++] = m & 255;
				s[u++] = m >>> 8 & 255;
				s[u++] = t & 255;
				s[u++] = t >>> 8 & 255;
				if (x) {
					s.set(d, u), u += d.length, s = s.subarray(0, u)
				} else {
					m = 0;
					for (t = d.length; m < t; ++m) {
						s[u++] = d[m]
					}
					s.length = u
				}
				this.b = u;
				this.a = s
			}
			break;
		case 1:
			f = new e(new Uint8Array(this.a.buffer), this.b);
			f.d(1, 1, F);
			f.d(1, 2, F);
			h = n(this, h);
			d = 0;
			for (k = h.length; d < k; d++) {
				if (g = h[d], e.prototype.d.apply(f, M[g]), 256 < g) {
					f.d(h[++d], h[++d], F), f.d(h[++d], 5), f.d(h[++d], h[++d], F)
				} else {
					if (256 === g) {
						break
					}
				}
			}
			this.a = f.finish();
			this.b = this.a.length;
			break;
		case K:
			g = new e(new Uint8Array(this.a), this.b);
			var v, w, y, A = [16, 17, 18, 0, 8, 7, 9, 6, 10, 5, 11, 4, 12, 3, 13, 2, 14, 1, 15],
				C, B, m = Array(19),
				D, s = K;
			g.d(1, 1, F);
			g.d(s, 2, F);
			h = n(this, h);
			t = p(this.L, 15);
			C = r(t);
			s = p(this.K, 7);
			u = r(s);
			for (v = 286; 257 < v && 0 === t[v - 1]; v--) {}
			for (w = 30; 1 < w && 0 === s[w - 1]; w--) {}
			var z = v,
				I = w;
			c = new(x ? Uint32Array : Array)(z + I);
			var J = new(x ? Uint32Array : Array)(316),
				G, H;
			B = new(x ? Uint8Array : Array)(19);
			for (D = y = 0; D < z; D++) {
				c[y++] = t[D]
			}
			for (D = 0; D < I; D++) {
				c[y++] = s[D]
			}
			if (!x) {
				for (D = 0, I = B.length; D < I; ++D) {
					B[D] = 0
				}
			}
			D = G = 0;
			for (I = c.length; D < I; D += y) {
				for (y = 1; D + y < I && c[D + y] === c[D]; ++y) {}
				z = y;
				if (0 === c[D]) {
					if (3 > z) {
						for (; 0 < z--;) {
							J[G++] = 0, B[0]++
						}
					} else {
						for (; 0 < z;) {
							H = 138 > z ? z : 138, H > z - 3 && H < z && (H = z - 3), 10 >= H ? (J[G++] = 17, J[G++] = H - 3, B[17]++) : (J[G++] = 18, J[G++] = H - 11, B[18]++), z -= H
						}
					}
				} else {
					if (J[G++] = c[D], B[c[D]]++, z--, 3 > z) {
						for (; 0 < z--;) {
							J[G++] = c[D], B[c[D]]++
						}
					} else {
						for (; 0 < z;) {
							H = 6 > z ? z : 6, H > z - 3 && H < z && (H = z - 3), J[G++] = 16, J[G++] = H - 3, B[16]++, z -= H
						}
					}
				}
			}
			c = x ? J.subarray(0, G) : J.slice(0, G);
			B = p(B, 7);
			for (D = 0; 19 > D; D++) {
				m[D] = B[A[D]]
			}
			for (y = 19; 4 < y && 0 === m[y - 1]; y--) {}
			A = r(B);
			g.d(v - 257, 5, F);
			g.d(w - 1, 5, F);
			g.d(y - 4, 4, F);
			for (D = 0; D < y; D++) {
				g.d(m[D], 3, F)
			}
			D = 0;
			for (m = c.length; D < m; D++) {
				if (d = c[D], g.d(A[d], B[d], F), 16 <= d) {
					D++;
					switch (d) {
					case 16:
						k = 2;
						break;
					case 17:
						k = 3;
						break;
					case 18:
						k = 7;
						break;
					default:
						b("invalid code: " + d)
					}
					g.d(c[D], k, F)
				}
			}
			k = [C, t];
			u = [u, s];
			d = k[0];
			k = k[1];
			s = u[0];
			C = u[1];
			u = 0;
			for (m = h.length; u < m; ++u) {
				if (f = h[u], g.d(d[f], k[f], F), 256 < f) {
					g.d(h[++u], h[++u], F), t = h[++u], g.d(s[t], C[t], F), g.d(h[++u], h[++u], F)
				} else {
					if (256 === f) {
						break
					}
				}
			}
			this.a = g.finish();
			this.b = this.a.length;
			break;
		default:
			b("invalid compression type")
		}
		return this.a
	};
	w = [];
	var L;
	for (L = 3; 258 >= L; L++) {
		z = m(), w[L] = z[2] << 24 | z[1] << 16 | z[0]
	}
	var O = x ? new Uint32Array(w) : w,
		J = C;
	t.prototype.n = function() {
		var c, e, f, g, h = 0;
		g = this.a;
		c = T;
		switch (c) {
		case T:
			e = Math.LOG2E * Math.log(32768) - 8;
			break;
		default:
			b(Error("invalid compression method"))
		}
		e = e << 4 | c;
		g[h++] = e;
		switch (c) {
		case T:
			switch (this.h) {
			case J.NONE:
				f = 0;
				break;
			case J.r:
				f = 1;
				break;
			case J.j:
				f = 2;
				break;
			default:
				b(Error("unsupported compression type"))
			}
			break;
		default:
			b(Error("invalid compression method"))
		}
		c = f << 6 | 0;
		g[h++] = c | 31 - (256 * e + c) % 31;
		c = d(this.input);
		this.z.b = h;
		g = this.z.n();
		h = g.length;
		x && (g = new Uint8Array(g.buffer), g.length <= h + 4 && (this.a = new Uint8Array(g.length + 4), this.a.set(g), g = this.a), g = g.subarray(0, h + 4));
		g[h++] = c >> 24 & 255;
		g[h++] = c >> 16 & 255;
		g[h++] = c >> 8 & 255;
		g[h++] = c & 255;
		return g
	};
	c("Zlib.Deflate", t);
	c("Zlib.Deflate.compress", function(b, c) {
		return (new t(b, c)).n()
	});
	c("Zlib.Deflate.CompressionType", J);
	c("Zlib.Deflate.CompressionType.NONE", J.NONE);
	c("Zlib.Deflate.CompressionType.FIXED", J.r);
	c("Zlib.Deflate.CompressionType.DYNAMIC", J.j);
	var P = 0,
		N = 1,
		C = {
			D: P,
			C: N
		};
	s.prototype.p = function() {
		for (; !this.s;) {
			var c = v(this, 3);
			c & 1 && (this.s = F);
			c >>>= 1;
			switch (c) {
			case 0:
				var c = this.input,
					d = this.c,
					e = this.a,
					f = this.b,
					g = E,
					h = E,
					k = E,
					m = e.length,
					g = E;
				this.e = this.g = 0;
				g = c[d++];
				g === E && b(Error("invalid uncompressed block header: LEN (first byte)"));
				h = g;
				g = c[d++];
				g === E && b(Error("invalid uncompressed block header: LEN (second byte)"));
				h |= g << 8;
				g = c[d++];
				g === E && b(Error("invalid uncompressed block header: NLEN (first byte)"));
				k = g;
				g = c[d++];
				g === E && b(Error("invalid uncompressed block header: NLEN (second byte)"));
				k |= g << 8;
				h === ~k && b(Error("invalid uncompressed block header: length verify"));
				d + h > c.length && b(Error("input buffer is broken"));
				switch (this.m) {
				case P:
					for (; f + h > e.length;) {
						g = m - f;
						h -= g;
						if (x) {
							e.set(c.subarray(d, d + g), f), f += g, d += g
						} else {
							for (; g--;) {
								e[f++] = c[d++]
							}
						}
						this.b = f;
						e = this.f();
						f = this.b
					}
					break;
				case N:
					for (; f + h > e.length;) {
						e = this.f({
							v: 2
						})
					}
					break;
				default:
					b(Error("invalid inflate mode"))
				}
				if (x) {
					e.set(c.subarray(d, d + h), f), f += h, d += h
				} else {
					for (; h--;) {
						e[f++] = c[d++]
					}
				}
				this.c = d;
				this.b = f;
				this.a = e;
				break;
			case 1:
				this.o(W, X);
				break;
			case 2:
				A(this);
				break;
			default:
				b(Error("unknown BTYPE: " + c))
			}
		}
		return this.t()
	};
	w = [16, 17, 18, 0, 8, 7, 9, 6, 10, 5, 11, 4, 12, 3, 13, 2, 14, 1, 15];
	var Q = x ? new Uint16Array(w) : w;
	w = [3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 15, 17, 19, 23, 27, 31, 35, 43, 51, 59, 67, 83, 99, 115, 131, 163, 195, 227, 258, 258, 258];
	var R = x ? new Uint16Array(w) : w;
	w = [0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 0, 0, 0];
	var S = x ? new Uint8Array(w) : w;
	w = [1, 2, 3, 4, 5, 7, 9, 13, 17, 25, 33, 49, 65, 97, 129, 193, 257, 385, 513, 769, 1025, 1537, 2049, 3073, 4097, 6145, 8193, 12289, 16385, 24577];
	var V = x ? new Uint16Array(w) : w;
	w = [0, 0, 0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9, 10, 10, 11, 11, 12, 12, 13, 13];
	var U = x ? new Uint8Array(w) : w;
	w = new(x ? Uint8Array : Array)(288);
	z = 0;
	for (G = w.length; z < G; ++z) {
		w[z] = 143 >= z ? 8 : 255 >= z ? 9 : 279 >= z ? 7 : 8
	}
	var W = g(w);
	w = new(x ? Uint8Array : Array)(30);
	z = 0;
	for (G = w.length; z < G; ++z) {
		w[z] = 5
	}
	var X = g(w);
	s.prototype.o = function(b, c) {
		var d = this.a,
			e = this.b;
		this.u = b;
		for (var f = d.length - 258, g, h, k; 256 !== (g = u(this, b));) {
			if (256 > g) {
				e >= f && (this.b = e, d = this.f(), e = this.b), d[e++] = g
			} else {
				for (g -= 257, k = R[g], 0 < S[g] && (k += v(this, S[g])), g = u(this, c), h = V[g], 0 < U[g] && (h += v(this, U[g])), e >= f && (this.b = e, d = this.f(), e = this.b); k--;) {
					d[e] = d[e++-h]
				}
			}
		}
		for (; 8 <= this.e;) {
			this.e -= 8, this.c--
		}
		this.b = e
	};
	s.prototype.I = function(b, c) {
		var d = this.a,
			e = this.b;
		this.u = b;
		for (var f = d.length, g, h, k; 256 !== (g = u(this, b));) {
			if (256 > g) {
				e >= f && (d = this.f(), f = d.length), d[e++] = g
			} else {
				for (g -= 257, k = R[g], 0 < S[g] && (k += v(this, S[g])), g = u(this, c), h = V[g], 0 < U[g] && (h += v(this, U[g])), e + k > f && (d = this.f(), f = d.length); k--;) {
					d[e] = d[e++-h]
				}
			}
		}
		for (; 8 <= this.e;) {
			this.e -= 8, this.c--
		}
		this.b = e
	};
	s.prototype.f = function() {
		var b = new(x ? Uint8Array : Array)(this.b - 32768),
			c = this.b - 32768,
			d, e, f = this.a;
		if (x) {
			b.set(f.subarray(32768, b.length))
		} else {
			for (d = 0, e = b.length; d < e; ++d) {
				b[d] = f[d + 32768]
			}
		}
		this.k.push(b);
		this.q += b.length;
		if (x) {
			f.set(f.subarray(c, c + 32768))
		} else {
			for (d = 0; 32768 > d; ++d) {
				f[d] = f[c + d]
			}
		}
		this.b = 32768;
		return f
	};
	s.prototype.J = function(b) {
		var c, d = this.input.length / this.c + 1 | 0,
			e, f, g, h = this.input,
			k = this.a;
		b && ("number" === typeof b.v && (d = b.v), "number" === typeof b.F && (d += b.F));
		2 > d ? (e = (h.length - this.c) / this.u[2], g = e / 2 * 258 | 0, f = g < k.length ? k.length + g : k.length << 1) : f = k.length * d;
		x ? (c = new Uint8Array(f), c.set(k)) : c = k;
		return this.a = c
	};
	s.prototype.t = function() {
		var b = 0,
			c = this.a,
			d = this.k,
			e, f = new(x ? Uint8Array : Array)(this.q + (this.b - 32768)),
			g, h, k, m;
		if (0 === d.length) {
			return x ? this.a.subarray(32768, this.b) : this.a.slice(32768, this.b)
		}
		g = 0;
		for (h = d.length; g < h; ++g) {
			for (e = d[g], k = 0, m = e.length; k < m; ++k) {
				f[b++] = e[k]
			}
		}
		g = 32768;
		for (h = this.b; g < h; ++g) {
			f[b++] = c[g]
		}
		this.k = [];
		return this.buffer = f
	};
	s.prototype.H = function() {
		var b, c = this.b;
		x ? this.B ? (b = new Uint8Array(c), b.set(this.a.subarray(0, c))) : b = this.a.subarray(0, c) : (this.a.length > c && (this.a.length = c), b = this.a);
		return this.buffer = b
	};
	y.prototype.p = function() {
		var c = this.input,
			e, f;
		e = this.A.p();
		this.c = this.A.c;
		this.M && (f = (c[this.c++] << 24 | c[this.c++] << 16 | c[this.c++] << 8 | c[this.c++]) >>> 0, f !== d(e) && b(Error("invalid adler-32 checksum")));
		return e
	};
	c("Zlib.Inflate", y);
	c("Zlib.Inflate.BufferType", C);
	C.ADAPTIVE = C.C;
	C.BLOCK = C.D;
	c("Zlib.Inflate.prototype.decompress", y.prototype.p);
	C = [16, 17, 18, 0, 8, 7, 9, 6, 10, 5, 11, 4, 12, 3, 13, 2, 14, 1, 15];
	x && new Uint16Array(C);
	C = [3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 15, 17, 19, 23, 27, 31, 35, 43, 51, 59, 67, 83, 99, 115, 131, 163, 195, 227, 258, 258, 258];
	x && new Uint16Array(C);
	C = [0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 0, 0, 0];
	x && new Uint8Array(C);
	C = [1, 2, 3, 4, 5, 7, 9, 13, 17, 25, 33, 49, 65, 97, 129, 193, 257, 385, 513, 769, 1025, 1537, 2049, 3073, 4097, 6145, 8193, 12289, 16385, 24577];
	x && new Uint16Array(C);
	C = [0, 0, 0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9, 10, 10, 11, 11, 12, 12, 13, 13];
	x && new Uint8Array(C);
	C = new(x ? Uint8Array : Array)(288);
	w = 0;
	for (z = C.length; w < z; ++w) {
		C[w] = 143 >= w ? 8 : 255 >= w ? 9 : 279 >= w ? 7 : 8
	}
	g(C);
	C = new(x ? Uint8Array : Array)(30);
	w = 0;
	for (z = C.length; w < z; ++w) {
		C[w] = 5
	}
	g(C);
	var T = 8
}).call(this);
_p = window;
_p = _p.Zlib = _p.Zlib;
_p.Deflate = _p.Deflate;
_p.Deflate.compress = _p.Deflate.compress;
_p.Inflate = _p.Inflate;
_p.Inflate.BufferType = _p.Inflate.BufferType;
_p.Inflate.prototype.decompress = _p.Inflate.prototype.decompress;
cc.PNGReader = cc.Class.extend({
	ctor: function(b) {
		var c, d, e, f;
		this.data = b;
		this.pos = 8;
		this.palette = [];
		this.imgData = [];
		this.transparency = {};
		this.animation = null;
		this.text = {};
		for (e = null;;) {
			c = this.readUInt32();
			f = b = void 0;
			f = [];
			for (b = 0; 4 > b; ++b) {
				f.push(String.fromCharCode(this.data[this.pos++]))
			}
			b = f.join("");
			switch (b) {
			case "IHDR":
				this.width = this.readUInt32();
				this.height = this.readUInt32();
				this.bits = this.data[this.pos++];
				this.colorType = this.data[this.pos++];
				this.compressionMethod = this.data[this.pos++];
				this.filterMethod = this.data[this.pos++];
				this.interlaceMethod = this.data[this.pos++];
				break;
			case "acTL":
				this.animation = {
					numFrames: this.readUInt32(),
					numPlays: this.readUInt32() || Infinity,
					frames: []
				};
				break;
			case "PLTE":
				this.palette = this.read(c);
				break;
			case "fcTL":
				e && this.animation.frames.push(e);
				this.pos += 4;
				e = {
					width: this.readUInt32(),
					height: this.readUInt32(),
					xOffset: this.readUInt32(),
					yOffset: this.readUInt32()
				};
				b = this.readUInt16();
				c = this.readUInt16() || 100;
				e.delay = 1000 * b / c;
				e.disposeOp = this.data[this.pos++];
				e.blendOp = this.data[this.pos++];
				e.data = [];
				break;
			case "IDAT":
			case "fdAT":
				"fdAT" === b && (this.pos += 4, c -= 4);
				b = (null != e ? e.data : void 0) || this.imgData;
				for (f = 0; 0 <= c ? f < c : f > c; 0 <= c ? ++f : --f) {
					b.push(this.data[this.pos++])
				}
				break;
			case "tRNS":
				this.transparency = {};
				switch (this.colorType) {
				case 3:
					this.transparency.indexed = this.read(c);
					c = 255 - this.transparency.indexed.length;
					if (0 < c) {
						for (b = 0; 0 <= c ? b < c : b > c; 0 <= c ? ++b : --b) {
							this.transparency.indexed.push(255)
						}
					}
					break;
				case 0:
					this.transparency.grayscale = this.read(c)[0];
					break;
				case 2:
					this.transparency.rgb = this.read(c)
				}
				break;
			case "tEXt":
				f = this.read(c);
				c = f.indexOf(0);
				b = String.fromCharCode.apply(String, f.slice(0, c));
				this.text[b] = String.fromCharCode.apply(String, f.slice(c + 1));
				break;
			case "IEND":
				e && this.animation.frames.push(e);
				a: {
					switch (this.colorType) {
					case 0:
					case 3:
					case 4:
						e = 1;
						break a;
					case 2:
					case 6:
						e = 3;
						break a
					}
					e = void 0
				}
				this.colors = e;
				this.hasAlphaChannel = 4 === (d = this.colorType) || 6 === d;
				d = this.colors + (this.hasAlphaChannel ? 1 : 0);
				this.pixelBitlength = this.bits * d;
				a: {
					switch (this.colors) {
					case 1:
						d = "DeviceGray";
						break a;
					case 3:
						d = "DeviceRGB";
						break a
					}
					d = void 0
				}
				this.colorSpace = d;
				Uint8Array != Array && (this.imgData = new Uint8Array(this.imgData));
				return;
			default:
				this.pos += c
			}
			this.pos += 4;
			if (this.pos > this.data.length) {
				throw Error("Incomplete or corrupt PNG file")
			}
		}
	},
	read: function(b) {
		var c, d;
		d = [];
		for (c = 0; 0 <= b ? c < b : c > b; 0 <= b ? ++c : --c) {
			d.push(this.data[this.pos++])
		}
		return d
	},
	readUInt32: function() {
		var b, c, d, e;
		b = this.data[this.pos++] << 24;
		c = this.data[this.pos++] << 16;
		d = this.data[this.pos++] << 8;
		e = this.data[this.pos++];
		return b | c | d | e
	},
	readUInt16: function() {
		var b, c;
		b = this.data[this.pos++] << 8;
		c = this.data[this.pos++];
		return b | c
	},
	decodePixels: function(b) {
		var c, d, e, f, g, h, k, m, n, p, r, t, s, v, u;
		null == b && (b = this.imgData);
		if (0 === b.length) {
			return new Uint8Array(0)
		}
		b = (new Zlib.Inflate(b, {
			index: 0,
			verify: !1
		})).decompress();
		m = this.pixelBitlength / 8;
		t = m * this.width;
		n = new Uint8Array(t * this.height);
		h = b.length;
		for (d = p = r = 0; p < h;) {
			switch (b[p++]) {
			case 0:
				for (c = 0; c < t; c += 1) {
					n[d++] = b[p++]
				}
				break;
			case 1:
				for (f = s = 0; s < t; f = s += 1) {
					c = b[p++], g = f < m ? 0 : n[d - m], n[d++] = (c + g) % 256
				}
				break;
			case 2:
				for (f = g = 0; g < t; f = g += 1) {
					c = b[p++], e = (f - f % m) / m, s = r && n[(r - 1) * t + e * m + f % m], n[d++] = (s + c) % 256
				}
				break;
			case 3:
				for (f = u = 0; u < t; f = u += 1) {
					c = b[p++], e = (f - f % m) / m, g = f < m ? 0 : n[d - m], s = r && n[(r - 1) * t + e * m + f % m], n[d++] = (c + Math.floor((g + s) / 2)) % 256
				}
				break;
			case 4:
				for (f = u = 0; u < t; f = u += 1) {
					c = b[p++], e = (f - f % m) / m, g = f < m ? 0 : n[d - m], 0 === r ? s = v = 0 : (s = n[(r - 1) * t + e * m + f % m], v = e && n[(r - 1) * t + (e - 1) * m + f % m]), k = g + s - v, f = Math.abs(k - g), e = Math.abs(k - s), k = Math.abs(k - v), g = f <= e && f <= k ? g : e <= k ? s : v, n[d++] = (c + g) % 256
				}
				break;
			default:
				throw Error("Invalid filter algorithm: " + b[p - 1])
			}
			r++
		}
		return n
	},
	copyToImageData: function(b, c) {
		var d, e, f, g, h, k, m, n;
		e = this.colors;
		n = null;
		d = this.hasAlphaChannel;
		this.palette.length && (n = null != (f = this._decodedPalette) ? f : this._decodedPalette = this.decodePalette(), e = 4, d = !0);
		f = b.data || b;
		m = f.length;
		h = n || c;
		g = k = 0;
		if (1 === e) {
			for (; g < m;) {
				e = n ? 4 * c[g / 4] : k, k = h[e++], f[g++] = k, f[g++] = k, f[g++] = k, f[g++] = d ? h[e++] : 255, k = e
			}
		} else {
			for (; g < m;) {
				e = n ? 4 * c[g / 4] : k, f[g++] = h[e++], f[g++] = h[e++], f[g++] = h[e++], f[g++] = d ? h[e++] : 255, k = e
			}
		}
	},
	decodePalette: function() {
		var b, c, d, e, f, g, h, k, m;
		d = this.palette;
		g = this.transparency.indexed || [];
		f = new Uint8Array((g.length || 0) + d.length);
		c = h = b = e = 0;
		for (k = d.length; h < k; c = h += 3) {
			f[e++] = d[c], f[e++] = d[c + 1], f[e++] = d[c + 2], f[e++] = null != (m = g[b++]) ? m : 255
		}
		return f
	},
	render: function(b) {
		var c;
		b.width = this.width;
		b.height = this.height;
		b = b.getContext("2d");
		c = b.createImageData(this.width, this.height);
		this.copyToImageData(c, this.decodePixels());
		return b.putImageData(c, 0, 0)
	}
});
cc.tiffReader = {
	_littleEndian: !1,
	_tiffData: null,
	_fileDirectories: [],
	getUint8: function(b) {
		return this._tiffData[b]
	},
	getUint16: function(b) {
		return this._littleEndian ? this._tiffData[b + 1] << 8 | this._tiffData[b] : this._tiffData[b] << 8 | this._tiffData[b + 1]
	},
	getUint32: function(b) {
		var c = this._tiffData;
		return this._littleEndian ? c[b + 3] << 24 | c[b + 2] << 16 | c[b + 1] << 8 | c[b] : c[b] << 24 | c[b + 1] << 16 | c[b + 2] << 8 | c[b + 3]
	},
	checkLittleEndian: function() {
		var b = this.getUint16(0);
		if (18761 === b) {
			this.littleEndian = !0
		} else {
			if (19789 === b) {
				this.littleEndian = !1
			} else {
				throw console.log(b), TypeError("Invalid byte order value.")
			}
		}
		return this.littleEndian
	},
	hasTowel: function() {
		if (42 !== this.getUint16(2)) {
			throw RangeError("You forgot your towel!")
		}
		return !0
	},
	getFieldTypeName: function(b) {
		var c = this.fieldTypeNames;
		return b in c ? c[b] : null
	},
	getFieldTagName: function(b) {
		var c = this.fieldTagNames;
		if (b in c) {
			return c[b]
		}
		console.log("Unknown Field Tag:", b);
		return "Tag" + b
	},
	getFieldTypeLength: function(b) {
		return -1 !== ["BYTE", "ASCII", "SBYTE", "UNDEFINED"].indexOf(b) ? 1 : -1 !== ["SHORT", "SSHORT"].indexOf(b) ? 2 : -1 !== ["LONG", "SLONG", "FLOAT"].indexOf(b) ? 4 : -1 !== ["RATIONAL", "SRATIONAL", "DOUBLE"].indexOf(b) ? 8 : null
	},
	getFieldValues: function(b, c, d, e) {
		b = [];
		var f = this.getFieldTypeLength(c);
		if (4 >= f * d) {
			!1 === this.littleEndian ? b.push(e >>> 8 * (4 - f)) : b.push(e)
		} else {
			for (var g = 0; g < d; g++) {
				var h = f * g;
				8 <= f ? -1 !== ["RATIONAL", "SRATIONAL"].indexOf(c) ? (b.push(this.getUint32(e + h)), b.push(this.getUint32(e + h + 4))) : cc.log("Can't handle this field type or size") : b.push(this.getBytes(f, e + h))
			}
		}
		"ASCII" === c && b.forEach(function(b, c, d) {
			d[c] = String.fromCharCode(b)
		});
		return b
	},
	getBytes: function(b, c) {
		if (0 >= b) {
			cc.log("No bytes requested")
		} else {
			if (1 >= b) {
				return this.getUint8(c)
			}
			if (2 >= b) {
				return this.getUint16(c)
			}
			if (3 >= b) {
				return this.getUint32(c) >>> 8
			}
			if (4 >= b) {
				return this.getUint32(c)
			}
			cc.log("Too many bytes requested")
		}
	},
	getBits: function(b, c, d) {
		d = d || 0;
		c += Math.floor(d / 8);
		var e = d + b;
		b = 32 - b;
		var f, g;
		0 >= e ? console.log("No bits requested") : 8 >= e ? (f = 24 + d, g = this.getUint8(c)) : 16 >= e ? (f = 16 + d, g = this.getUint16(c)) : 32 >= e ? (f = d, g = this.getUint32(c)) : console.log("Too many bits requested");
		return {
			bits: g << f >>> b,
			byteOffset: c + Math.floor(e / 8),
			bitOffset: e % 8
		}
	},
	parseFileDirectory: function(b) {
		var c = this.getUint16(b),
			d = [];
		b += 2;
		for (var e = 0; e < c; b += 12, e++) {
			var f = this.getUint16(b),
				g = this.getUint16(b + 2),
				h = this.getUint32(b + 4),
				k = this.getUint32(b + 8),
				f = this.getFieldTagName(f),
				g = this.getFieldTypeName(g),
				h = this.getFieldValues(f, g, h, k);
			d[f] = {
				type: g,
				values: h
			}
		}
		this._fileDirectories.push(d);
		c = this.getUint32(b);
		0 !== c && this.parseFileDirectory(c)
	},
	clampColorSample: function(b, c) {
		var d = Math.pow(2, 8 - c);
		return Math.floor(b * d + (d - 1))
	},
	parseTIFF: function(b, c) {
		c = c || cc.newElement("canvas");
		this._tiffData = b;
		this.canvas = c;
		this.checkLittleEndian();
		if (this.hasTowel()) {
			var d = this.getUint32(4);
			this._fileDirectories.length = 0;
			this.parseFileDirectory(d);
			var e = this._fileDirectories[0],
				d = e.ImageWidth.values[0],
				f = e.ImageLength.values[0];
			this.canvas.width = d;
			this.canvas.height = f;
			var g = [],
				h = e.Compression ? e.Compression.values[0] : 1,
				k = e.SamplesPerPixel.values[0],
				m = [],
				n = 0,
				p = !1;
			e.BitsPerSample.values.forEach(function(b, c, d) {
				m[c] = {
					bitsPerSample: b,
					hasBytesPerSample: !1,
					bytesPerSample: void 0
				};
				0 === b % 8 && (m[c].hasBytesPerSample = !0, m[c].bytesPerSample = b / 8);
				n += b
			}, this);
			if (0 === n % 8) {
				var p = !0,
					r = n / 8
			}
			var t = e.StripOffsets.values,
				s = t.length;
			if (e.StripByteCounts) {
				var v = e.StripByteCounts.values
			} else {
				if (cc.log("Missing StripByteCounts!"), 1 === s) {
					v = [Math.ceil(d * f * n / 8)]
				} else {
					throw Error("Cannot recover from missing StripByteCounts")
				}
			}
			for (var u = 0; u < s; u++) {
				var A = t[u];
				g[u] = [];
				for (var y = v[u], E = 0, F = 0, B = 1, x = !0, C = [], w = 0, z = 0, G = 0; E < y; E += B) {
					switch (h) {
					case 1:
						B = 0;
						for (C = []; B < k; B++) {
							if (m[B].hasBytesPerSample) {
								C.push(this.getBytes(m[B].bytesPerSample, A + E + m[B].bytesPerSample * B))
							} else {
								var H = this.getBits(m[B].bitsPerSample, A + E, F);
								C.push(H.bits);
								E = H.byteOffset - A;
								F = H.bitOffset;
								throw RangeError("Cannot handle sub-byte bits per sample")
							}
						}
						g[u].push(C);
						if (p) {
							B = r
						} else {
							throw B = 0, RangeError("Cannot handle sub-byte bits per pixel")
						}
						break;
					case 32773:
						if (x) {
							var x = !1,
								I = 1,
								K = 1,
								B = this.getInt8(A + E);
							0 <= B && 127 >= B ? I = B + 1 : -127 <= B && -1 >= B ? K = -B + 1 : x = !0
						} else {
							for (var M = this.getUint8(A + E), B = 0; B < K; B++) {
								if (m[z].hasBytesPerSample) {
									G = G << 8 * w | M, w++, w === m[z].bytesPerSample && (C.push(G), G = w = 0, z++)
								} else {
									throw RangeError("Cannot handle sub-byte bits per sample")
								}
								z === k && (g[u].push(C), C = [], z = 0)
							}
							I--;
							0 === I && (x = !0)
						}
						B = 1
					}
				}
			}
			if (c.getContext) {
				r = this.canvas.getContext("2d");
				r.fillStyle = "rgba(255, 255, 255, 0)";
				u = e.RowsPerStrip ? e.RowsPerStrip.values[0] : f;
				A = g.length;
				f %= u;
				f = 0 === f ? u : f;
				E = u;
				h = 0;
				C = e.PhotometricInterpretation.values[0];
				I = [];
				K = 0;
				e.ExtraSamples && (I = e.ExtraSamples.values, K = I.length);
				if (e.ColorMap) {
					var H = e.ColorMap.values,
						L = Math.pow(2, m[0].bitsPerSample)
				}
				for (u = 0; u < A; u++) {
					u + 1 === A && (E = f);
					e = g[u].length;
					h *= u;
					for (p = k = 0; k < E, p < e; k++) {
						for (t = 0; t < d; t++, p++) {
							v = g[u][p];
							x = F = y = 0;
							s = 1;
							if (0 < K) {
								for (y = 0; y < K; y++) {
									if (1 === I[y] || 2 === I[y]) {
										s = v[3 + y] / 256;
										break
									}
								}
							}
							switch (C) {
							case 0:
								if (m[0].hasBytesPerSample) {
									var O = Math.pow(16, 2 * m[0].bytesPerSample)
								}
								v.forEach(function(b, c, d) {
									d[c] = O - b
								});
							case 1:
								y = F = x = this.clampColorSample(v[0], m[0].bitsPerSample);
								break;
							case 2:
								y = this.clampColorSample(v[0], m[0].bitsPerSample);
								F = this.clampColorSample(v[1], m[1].bitsPerSample);
								x = this.clampColorSample(v[2], m[2].bitsPerSample);
								break;
							case 3:
								if (void 0 === H) {
									throw Error("Palette image missing color map")
								}
								v = v[0];
								y = this.clampColorSample(H[v], 16);
								F = this.clampColorSample(H[L + v], 16);
								x = this.clampColorSample(H[2 * L + v], 16);
								break;
							default:
								throw RangeError("Unknown Photometric Interpretation:", C)
							}
							r.fillStyle = "rgba(" + y + ", " + F + ", " + x + ", " + s + ")";
							r.fillRect(t, h + k, 1, 1)
						}
					}
					h = E
				}
			}
			return this.canvas
		}
	},
	fieldTagNames: {
		315: "Artist",
		258: "BitsPerSample",
		265: "CellLength",
		264: "CellWidth",
		320: "ColorMap",
		259: "Compression",
		33432: "Copyright",
		306: "DateTime",
		338: "ExtraSamples",
		266: "FillOrder",
		289: "FreeByteCounts",
		288: "FreeOffsets",
		291: "GrayResponseCurve",
		290: "GrayResponseUnit",
		316: "HostComputer",
		270: "ImageDescription",
		257: "ImageLength",
		256: "ImageWidth",
		271: "Make",
		281: "MaxSampleValue",
		280: "MinSampleValue",
		272: "Model",
		254: "NewSubfileType",
		274: "Orientation",
		262: "PhotometricInterpretation",
		284: "PlanarConfiguration",
		296: "ResolutionUnit",
		278: "RowsPerStrip",
		277: "SamplesPerPixel",
		305: "Software",
		279: "StripByteCounts",
		273: "StripOffsets",
		255: "SubfileType",
		263: "Threshholding",
		282: "XResolution",
		283: "YResolution",
		326: "BadFaxLines",
		327: "CleanFaxData",
		343: "ClipPath",
		328: "ConsecutiveBadFaxLines",
		433: "Decode",
		434: "DefaultImageColor",
		269: "DocumentName",
		336: "DotRange",
		321: "HalftoneHints",
		346: "Indexed",
		347: "JPEGTables",
		285: "PageName",
		297: "PageNumber",
		317: "Predictor",
		319: "PrimaryChromaticities",
		532: "ReferenceBlackWhite",
		339: "SampleFormat",
		559: "StripRowCounts",
		330: "SubIFDs",
		292: "T4Options",
		293: "T6Options",
		325: "TileByteCounts",
		323: "TileLength",
		324: "TileOffsets",
		322: "TileWidth",
		301: "TransferFunction",
		318: "WhitePoint",
		344: "XClipPathUnits",
		286: "XPosition",
		529: "YCbCrCoefficients",
		531: "YCbCrPositioning",
		530: "YCbCrSubSampling",
		345: "YClipPathUnits",
		287: "YPosition",
		37378: "ApertureValue",
		40961: "ColorSpace",
		36868: "DateTimeDigitized",
		36867: "DateTimeOriginal",
		34665: "Exif IFD",
		36864: "ExifVersion",
		33434: "ExposureTime",
		41728: "FileSource",
		37385: "Flash",
		40960: "FlashpixVersion",
		33437: "FNumber",
		42016: "ImageUniqueID",
		37384: "LightSource",
		37500: "MakerNote",
		37377: "ShutterSpeedValue",
		37510: "UserComment",
		33723: "IPTC",
		34675: "ICC Profile",
		700: "XMP",
		42112: "GDAL_METADATA",
		42113: "GDAL_NODATA",
		34377: "Photoshop"
	},
	fieldTypeNames: {
		1: "BYTE",
		2: "ASCII",
		3: "SHORT",
		4: "LONG",
		5: "RATIONAL",
		6: "SBYTE",
		7: "UNDEFINED",
		8: "SSHORT",
		9: "SLONG",
		10: "SRATIONAL",
		11: "FLOAT",
		12: "DOUBLE"
	}
};
cc.Particle = function(b, c, d, e, f, g, h, k, m, n, p, r) {
	this.pos = b ? b : cc.p(0, 0);
	this.startPos = c ? c : cc.p(0, 0);
	this.color = d ? d : {
		r: 0,
		g: 0,
		b: 0,
		a: 255
	};
	this.deltaColor = e ? e : {
		r: 0,
		g: 0,
		b: 0,
		a: 255
	};
	this.size = f || 0;
	this.deltaSize = g || 0;
	this.rotation = h || 0;
	this.deltaRotation = k || 0;
	this.timeToLive = m || 0;
	this.atlasIndex = n || 0;
	this.modeA = p ? p : new cc.Particle.ModeA;
	this.modeB = r ? r : new cc.Particle.ModeB;
	this.isChangeColor = !1;
	this.drawPos = cc.p(0, 0)
};
cc.Particle.ModeA = function(b, c, d) {
	this.dir = b ? b : cc.p(0, 0);
	this.radialAccel = c || 0;
	this.tangentialAccel = d || 0
};
cc.Particle.ModeB = function(b, c, d, e) {
	this.angle = b || 0;
	this.degreesPerSecond = c || 0;
	this.radius = d || 0;
	this.deltaRadius = e || 0
};
cc.Particle.TemporaryPoints = [cc.p(), cc.p(), cc.p(), cc.p()];
cc.ParticleSystem = cc.Node.extend({
	_className: "ParticleSystem",
	_plistFile: "",
	_elapsed: 0,
	_dontTint: !1,
	modeA: null,
	modeB: null,
	_pointZeroForParticle: cc.p(0, 0),
	_particles: null,
	_emitCounter: 0,
	_particleIdx: 0,
	_batchNode: null,
	atlasIndex: 0,
	_transformSystemDirty: !1,
	_allocatedParticles: 0,
	_isActive: !1,
	particleCount: 0,
	duration: 0,
	_sourcePosition: null,
	_posVar: null,
	life: 0,
	lifeVar: 0,
	angle: 0,
	angleVar: 0,
	startSize: 0,
	startSizeVar: 0,
	endSize: 0,
	endSizeVar: 0,
	_startColor: null,
	_startColorVar: null,
	_endColor: null,
	_endColorVar: null,
	startSpin: 0,
	startSpinVar: 0,
	endSpin: 0,
	endSpinVar: 0,
	emissionRate: 0,
	_totalParticles: 0,
	_texture: null,
	_blendFunc: null,
	_opacityModifyRGB: !1,
	positionType: null,
	autoRemoveOnFinish: !1,
	emitterMode: 0,
	_textureLoaded: null,
	ctor: function(b) {
		cc.Node.prototype.ctor.call(this);
		this.emitterMode = cc.ParticleSystem.MODE_GRAVITY;
		this.modeA = new cc.ParticleSystem.ModeA;
		this.modeB = new cc.ParticleSystem.ModeB;
		this._blendFunc = {
			src: cc.BLEND_SRC,
			dst: cc.BLEND_DST
		};
		this._particles = [];
		this._sourcePosition = cc.p(0, 0);
		this._posVar = cc.p(0, 0);
		this._startColor = cc.color(255, 255, 255, 255);
		this._startColorVar = cc.color(255, 255, 255, 255);
		this._endColor = cc.color(255, 255, 255, 255);
		this._endColorVar = cc.color(255, 255, 255, 255);
		this._plistFile = "";
		this._elapsed = 0;
		this._dontTint = !1;
		this._pointZeroForParticle = cc.p(0, 0);
		this._particleIdx = this._emitCounter = 0;
		this._batchNode = null;
		this.atlasIndex = 0;
		this._transformSystemDirty = !1;
		this._allocatedParticles = 0;
		this._isActive = !1;
		this._totalParticles = this.emissionRate = this.endSpinVar = this.endSpin = this.startSpinVar = this.startSpin = this.endSizeVar = this.endSize = this.startSizeVar = this.startSize = this.angleVar = this.angle = this.lifeVar = this.life = this.duration = this.particleCount = 0;
		this._texture = null;
		this._opacityModifyRGB = !1;
		this.positionType = cc.ParticleSystem.TYPE_FREE;
		this.autoRemoveOnFinish = !1;
		this._textureLoaded = !0;
		!b || cc.isNumber(b) ? (b = b || 100, this.setDrawMode(cc.ParticleSystem.TEXTURE_MODE), this.initWithTotalParticles(b)) : cc.isString(b) ? this.initWithFile(b) : cc.isObject(b) && this.initWithDictionary(b, "")
	},
	_createRenderCmd: function() {
		return cc._renderType === cc._RENDER_TYPE_CANVAS ? new cc.ParticleSystem.CanvasRenderCmd(this) : new cc.ParticleSystem.WebGLRenderCmd(this)
	},
	ignoreColor: function(b) {
		this._dontTint = b
	},
	initTexCoordsWithRect: function(b) {
		this._renderCmd.initTexCoordsWithRect(b)
	},
	getBatchNode: function() {
		return this._batchNode
	},
	setBatchNode: function(b) {
		this._renderCmd.setBatchNode(b)
	},
	getAtlasIndex: function() {
		return this.atlasIndex
	},
	setAtlasIndex: function(b) {
		this.atlasIndex = b
	},
	getDrawMode: function() {
		return this._renderCmd.getDrawMode()
	},
	setDrawMode: function(b) {
		this._renderCmd.setDrawMode(b)
	},
	getShapeType: function() {
		return this._renderCmd.getShapeType()
	},
	setShapeType: function(b) {
		this._renderCmd.setShapeType(b)
	},
	isActive: function() {
		return this._isActive
	},
	getParticleCount: function() {
		return this.particleCount
	},
	setParticleCount: function(b) {
		this.particleCount = b
	},
	getDuration: function() {
		return this.duration
	},
	setDuration: function(b) {
		this.duration = b
	},
	getSourcePosition: function() {
		return {
			x: this._sourcePosition.x,
			y: this._sourcePosition.y
		}
	},
	setSourcePosition: function(b) {
		this._sourcePosition = b
	},
	getPosVar: function() {
		return {
			x: this._posVar.x,
			y: this._posVar.y
		}
	},
	setPosVar: function(b) {
		this._posVar = b
	},
	getLife: function() {
		return this.life
	},
	setLife: function(b) {
		this.life = b
	},
	getLifeVar: function() {
		return this.lifeVar
	},
	setLifeVar: function(b) {
		this.lifeVar = b
	},
	getAngle: function() {
		return this.angle
	},
	setAngle: function(b) {
		this.angle = b
	},
	getAngleVar: function() {
		return this.angleVar
	},
	setAngleVar: function(b) {
		this.angleVar = b
	},
	getGravity: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.getGravity() : Particle Mode should be Gravity");
		var b = this.modeA.gravity;
		return cc.p(b.x, b.y)
	},
	setGravity: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.setGravity() : Particle Mode should be Gravity");
		this.modeA.gravity = b
	},
	getSpeed: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.getSpeed() : Particle Mode should be Gravity");
		return this.modeA.speed
	},
	setSpeed: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.setSpeed() : Particle Mode should be Gravity");
		this.modeA.speed = b
	},
	getSpeedVar: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.getSpeedVar() : Particle Mode should be Gravity");
		return this.modeA.speedVar
	},
	setSpeedVar: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.setSpeedVar() : Particle Mode should be Gravity");
		this.modeA.speedVar = b
	},
	getTangentialAccel: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.getTangentialAccel() : Particle Mode should be Gravity");
		return this.modeA.tangentialAccel
	},
	setTangentialAccel: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.setTangentialAccel() : Particle Mode should be Gravity");
		this.modeA.tangentialAccel = b
	},
	getTangentialAccelVar: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.getTangentialAccelVar() : Particle Mode should be Gravity");
		return this.modeA.tangentialAccelVar
	},
	setTangentialAccelVar: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.setTangentialAccelVar() : Particle Mode should be Gravity");
		this.modeA.tangentialAccelVar = b
	},
	getRadialAccel: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.getRadialAccel() : Particle Mode should be Gravity");
		return this.modeA.radialAccel
	},
	setRadialAccel: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.setRadialAccel() : Particle Mode should be Gravity");
		this.modeA.radialAccel = b
	},
	getRadialAccelVar: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.getRadialAccelVar() : Particle Mode should be Gravity");
		return this.modeA.radialAccelVar
	},
	setRadialAccelVar: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.setRadialAccelVar() : Particle Mode should be Gravity");
		this.modeA.radialAccelVar = b
	},
	getRotationIsDir: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.getRotationIsDir() : Particle Mode should be Gravity");
		return this.modeA.rotationIsDir
	},
	setRotationIsDir: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_GRAVITY && cc.log("cc.ParticleBatchNode.setRotationIsDir() : Particle Mode should be Gravity");
		this.modeA.rotationIsDir = b
	},
	getStartRadius: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_RADIUS && cc.log("cc.ParticleBatchNode.getStartRadius() : Particle Mode should be Radius");
		return this.modeB.startRadius
	},
	setStartRadius: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_RADIUS && cc.log("cc.ParticleBatchNode.setStartRadius() : Particle Mode should be Radius");
		this.modeB.startRadius = b
	},
	getStartRadiusVar: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_RADIUS && cc.log("cc.ParticleBatchNode.getStartRadiusVar() : Particle Mode should be Radius");
		return this.modeB.startRadiusVar
	},
	setStartRadiusVar: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_RADIUS && cc.log("cc.ParticleBatchNode.setStartRadiusVar() : Particle Mode should be Radius");
		this.modeB.startRadiusVar = b
	},
	getEndRadius: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_RADIUS && cc.log("cc.ParticleBatchNode.getEndRadius() : Particle Mode should be Radius");
		return this.modeB.endRadius
	},
	setEndRadius: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_RADIUS && cc.log("cc.ParticleBatchNode.setEndRadius() : Particle Mode should be Radius");
		this.modeB.endRadius = b
	},
	getEndRadiusVar: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_RADIUS && cc.log("cc.ParticleBatchNode.getEndRadiusVar() : Particle Mode should be Radius");
		return this.modeB.endRadiusVar
	},
	setEndRadiusVar: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_RADIUS && cc.log("cc.ParticleBatchNode.setEndRadiusVar() : Particle Mode should be Radius");
		this.modeB.endRadiusVar = b
	},
	getRotatePerSecond: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_RADIUS && cc.log("cc.ParticleBatchNode.getRotatePerSecond() : Particle Mode should be Radius");
		return this.modeB.rotatePerSecond
	},
	setRotatePerSecond: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_RADIUS && cc.log("cc.ParticleBatchNode.setRotatePerSecond() : Particle Mode should be Radius");
		this.modeB.rotatePerSecond = b
	},
	getRotatePerSecondVar: function() {
		this.emitterMode !== cc.ParticleSystem.MODE_RADIUS && cc.log("cc.ParticleBatchNode.getRotatePerSecondVar() : Particle Mode should be Radius");
		return this.modeB.rotatePerSecondVar
	},
	setRotatePerSecondVar: function(b) {
		this.emitterMode !== cc.ParticleSystem.MODE_RADIUS && cc.log("cc.ParticleBatchNode.setRotatePerSecondVar() : Particle Mode should be Radius");
		this.modeB.rotatePerSecondVar = b
	},
	setScale: function(b, c) {
		this._transformSystemDirty = !0;
		cc.Node.prototype.setScale.call(this, b, c)
	},
	setRotation: function(b) {
		this._transformSystemDirty = !0;
		cc.Node.prototype.setRotation.call(this, b)
	},
	setScaleX: function(b) {
		this._transformSystemDirty = !0;
		cc.Node.prototype.setScaleX.call(this, b)
	},
	setScaleY: function(b) {
		this._transformSystemDirty = !0;
		cc.Node.prototype.setScaleY.call(this, b)
	},
	getStartSize: function() {
		return this.startSize
	},
	setStartSize: function(b) {
		this.startSize = b
	},
	getStartSizeVar: function() {
		return this.startSizeVar
	},
	setStartSizeVar: function(b) {
		this.startSizeVar = b
	},
	getEndSize: function() {
		return this.endSize
	},
	setEndSize: function(b) {
		this.endSize = b
	},
	getEndSizeVar: function() {
		return this.endSizeVar
	},
	setEndSizeVar: function(b) {
		this.endSizeVar = b
	},
	getStartColor: function() {
		return cc.color(this._startColor.r, this._startColor.g, this._startColor.b, this._startColor.a)
	},
	setStartColor: function(b) {
		this._startColor = cc.color(b)
	},
	getStartColorVar: function() {
		return cc.color(this._startColorVar.r, this._startColorVar.g, this._startColorVar.b, this._startColorVar.a)
	},
	setStartColorVar: function(b) {
		this._startColorVar = cc.color(b)
	},
	getEndColor: function() {
		return cc.color(this._endColor.r, this._endColor.g, this._endColor.b, this._endColor.a)
	},
	setEndColor: function(b) {
		this._endColor = cc.color(b)
	},
	getEndColorVar: function() {
		return cc.color(this._endColorVar.r, this._endColorVar.g, this._endColorVar.b, this._endColorVar.a)
	},
	setEndColorVar: function(b) {
		this._endColorVar = cc.color(b)
	},
	getStartSpin: function() {
		return this.startSpin
	},
	setStartSpin: function(b) {
		this.startSpin = b
	},
	getStartSpinVar: function() {
		return this.startSpinVar
	},
	setStartSpinVar: function(b) {
		this.startSpinVar = b
	},
	getEndSpin: function() {
		return this.endSpin
	},
	setEndSpin: function(b) {
		this.endSpin = b
	},
	getEndSpinVar: function() {
		return this.endSpinVar
	},
	setEndSpinVar: function(b) {
		this.endSpinVar = b
	},
	getEmissionRate: function() {
		return this.emissionRate
	},
	setEmissionRate: function(b) {
		this.emissionRate = b
	},
	getTotalParticles: function() {
		return this._totalParticles
	},
	setTotalParticles: function(b) {
		this._renderCmd.setTotalParticles(b)
	},
	getTexture: function() {
		return this._texture
	},
	setTexture: function(b) {
		b && (b.isLoaded() ? this.setTextureWithRect(b, cc.rect(0, 0, b.width, b.height)) : (this._textureLoaded = !1, b.addEventListener("load", function(b) {
			this._textureLoaded = !0;
			this.setTextureWithRect(b, cc.rect(0, 0, b.width, b.height))
		}, this)))
	},
	getBlendFunc: function() {
		return this._blendFunc
	},
	setBlendFunc: function(b, c) {
		if (void 0 === c) {
			this._blendFunc !== b && (this._blendFunc = b, this._updateBlendFunc())
		} else {
			if (this._blendFunc.src !== b || this._blendFunc.dst !== c) {
				this._blendFunc = {
					src: b,
					dst: c
				}, this._updateBlendFunc()
			}
		}
	},
	isOpacityModifyRGB: function() {
		return this._opacityModifyRGB
	},
	setOpacityModifyRGB: function(b) {
		this._opacityModifyRGB = b
	},
	isBlendAdditive: function() {
		return this._blendFunc.src === cc.SRC_ALPHA && this._blendFunc.dst === cc.ONE || this._blendFunc.src === cc.ONE && this._blendFunc.dst === cc.ONE
	},
	setBlendAdditive: function(b) {
		var c = this._blendFunc;
		b ? (c.src = cc.SRC_ALPHA, c.dst = cc.ONE) : this._renderCmd._setBlendAdditive()
	},
	getPositionType: function() {
		return this.positionType
	},
	setPositionType: function(b) {
		this.positionType = b
	},
	isAutoRemoveOnFinish: function() {
		return this.autoRemoveOnFinish
	},
	setAutoRemoveOnFinish: function(b) {
		this.autoRemoveOnFinish = b
	},
	getEmitterMode: function() {
		return this.emitterMode
	},
	setEmitterMode: function(b) {
		this.emitterMode = b
	},
	init: function() {
		return this.initWithTotalParticles(150)
	},
	initWithFile: function(b) {
		this._plistFile = b;
		b = cc.loader.getRes(b);
		return b ? this.initWithDictionary(b, "") : (cc.log("cc.ParticleSystem.initWithFile(): Particles: file not found"), !1)
	},
	getBoundingBoxToWorld: function() {
		return cc.rect(0, 0, cc._canvas.width, cc._canvas.height)
	},
	initWithDictionary: function(b, c) {
		var d = !1,
			e = null,
			e = this._valueForKey,
			f = parseInt(e("maxParticles", b));
		if (this.initWithTotalParticles(f)) {
			this.angle = parseFloat(e("angle", b));
			this.angleVar = parseFloat(e("angleVariance", b));
			this.duration = parseFloat(e("duration", b));
			this._blendFunc.src = parseInt(e("blendFuncSource", b));
			this._blendFunc.dst = parseInt(e("blendFuncDestination", b));
			d = this._startColor;
			d.r = 255 * parseFloat(e("startColorRed", b));
			d.g = 255 * parseFloat(e("startColorGreen", b));
			d.b = 255 * parseFloat(e("startColorBlue", b));
			d.a = 255 * parseFloat(e("startColorAlpha", b));
			d = this._startColorVar;
			d.r = 255 * parseFloat(e("startColorVarianceRed", b));
			d.g = 255 * parseFloat(e("startColorVarianceGreen", b));
			d.b = 255 * parseFloat(e("startColorVarianceBlue", b));
			d.a = 255 * parseFloat(e("startColorVarianceAlpha", b));
			d = this._endColor;
			d.r = 255 * parseFloat(e("finishColorRed", b));
			d.g = 255 * parseFloat(e("finishColorGreen", b));
			d.b = 255 * parseFloat(e("finishColorBlue", b));
			d.a = 255 * parseFloat(e("finishColorAlpha", b));
			d = this._endColorVar;
			d.r = 255 * parseFloat(e("finishColorVarianceRed", b));
			d.g = 255 * parseFloat(e("finishColorVarianceGreen", b));
			d.b = 255 * parseFloat(e("finishColorVarianceBlue", b));
			d.a = 255 * parseFloat(e("finishColorVarianceAlpha", b));
			this.startSize = parseFloat(e("startParticleSize", b));
			this.startSizeVar = parseFloat(e("startParticleSizeVariance", b));
			this.endSize = parseFloat(e("finishParticleSize", b));
			this.endSizeVar = parseFloat(e("finishParticleSizeVariance", b));
			this.setPosition(parseFloat(e("sourcePositionx", b)), parseFloat(e("sourcePositiony", b)));
			this._posVar.x = parseFloat(e("sourcePositionVariancex", b));
			this._posVar.y = parseFloat(e("sourcePositionVariancey", b));
			this.startSpin = parseFloat(e("rotationStart", b));
			this.startSpinVar = parseFloat(e("rotationStartVariance", b));
			this.endSpin = parseFloat(e("rotationEnd", b));
			this.endSpinVar = parseFloat(e("rotationEndVariance", b));
			this.emitterMode = parseInt(e("emitterType", b));
			if (this.emitterMode === cc.ParticleSystem.MODE_GRAVITY) {
				d = this.modeA, d.gravity.x = parseFloat(e("gravityx", b)), d.gravity.y = parseFloat(e("gravityy", b)), d.speed = parseFloat(e("speed", b)), d.speedVar = parseFloat(e("speedVariance", b)), f = e("radialAcceleration", b), d.radialAccel = f ? parseFloat(f) : 0, f = e("radialAccelVariance", b), d.radialAccelVar = f ? parseFloat(f) : 0, f = e("tangentialAcceleration", b), d.tangentialAccel = f ? parseFloat(f) : 0, f = e("tangentialAccelVariance", b), d.tangentialAccelVar = f ? parseFloat(f) : 0, f = e("rotationIsDir", b).toLowerCase(), d.rotationIsDir = null != f && ("true" === f || "1" === f)
			} else {
				if (this.emitterMode === cc.ParticleSystem.MODE_RADIUS) {
					d = this.modeB, d.startRadius = parseFloat(e("maxRadius", b)), d.startRadiusVar = parseFloat(e("maxRadiusVariance", b)), d.endRadius = parseFloat(e("minRadius", b)), d.endRadiusVar = 0, d.rotatePerSecond = parseFloat(e("rotatePerSecond", b)), d.rotatePerSecondVar = parseFloat(e("rotatePerSecondVariance", b))
				} else {
					return cc.log("cc.ParticleSystem.initWithDictionary(): Invalid emitterType in config file"), !1
				}
			}
			this.life = parseFloat(e("particleLifespan", b));
			this.lifeVar = parseFloat(e("particleLifespanVariance", b));
			this.emissionRate = this._totalParticles / this.life;
			if (!this._batchNode) {
				if (this._opacityModifyRGB = !1, d = e("textureFileName", b), d = cc.path.changeBasename(this._plistFile, d), f = cc.textureCache.getTextureForKey(d)) {
					this.setTexture(f)
				} else {
					if ((e = e("textureImageData", b)) && 0 !== e.length) {
						e = cc.unzipBase64AsArray(e, 1);
						if (!e) {
							return cc.log("cc.ParticleSystem: error decoding or ungzipping textureImageData"), !1
						}
						f = cc.getImageFormatByData(e);
						if (f !== cc.FMT_TIFF && f !== cc.FMT_PNG) {
							return cc.log("cc.ParticleSystem: unknown image format with Data"), !1
						}
						var g = cc.newElement("canvas");
						f === cc.FMT_PNG ? (new cc.PNGReader(e)).render(g) : cc.tiffReader.parseTIFF(e, g);
						cc.textureCache.cacheImage(d, g);
						(e = cc.textureCache.getTextureForKey(d)) || cc.log("cc.ParticleSystem.initWithDictionary() : error loading the texture");
						this.setTexture(e)
					} else {
						f = cc.textureCache.addImage(d);
						if (!f) {
							return !1
						}
						this.setTexture(f)
					}
				}
			}
			d = !0
		}
		return d
	},
	initWithTotalParticles: function(b) {
		this._totalParticles = b;
		var c, d = this._particles;
		for (c = d.length = 0; c < b; c++) {
			d[c] = new cc.Particle
		}
		if (!d) {
			return cc.log("Particle system: not enough memory"), !1
		}
		this._allocatedParticles = b;
		if (this._batchNode) {
			for (c = 0; c < this._totalParticles; c++) {
				d[c].atlasIndex = c
			}
		}
		this._isActive = !0;
		this._blendFunc.src = cc.BLEND_SRC;
		this._blendFunc.dst = cc.BLEND_DST;
		this.positionType = cc.ParticleSystem.TYPE_FREE;
		this.emitterMode = cc.ParticleSystem.MODE_GRAVITY;
		this._transformSystemDirty = this.autoRemoveOnFinish = !1;
		this.scheduleUpdateWithPriority(1);
		this._renderCmd._initWithTotalParticles(b);
		return !0
	},
	destroyParticleSystem: function() {
		this.unscheduleUpdate()
	},
	addParticle: function() {
		if (this.isFull()) {
			return !1
		}
		var b = this._renderCmd.addParticle();
		this.initParticle(b);
		++this.particleCount;
		return !0
	},
	initParticle: function(b) {
		var c = cc.randomMinus1To1;
		b.timeToLive = this.life + this.lifeVar * c();
		b.timeToLive = Math.max(0, b.timeToLive);
		b.pos.x = this._sourcePosition.x + this._posVar.x * c();
		b.pos.y = this._sourcePosition.y + this._posVar.y * c();
		var d, e;
		d = this._startColor;
		var f = this._startColorVar,
			g = this._endColor;
		e = this._endColorVar;
		d = {
			r: cc.clampf(d.r + f.r * c(), 0, 255),
			g: cc.clampf(d.g + f.g * c(), 0, 255),
			b: cc.clampf(d.b + f.b * c(), 0, 255),
			a: cc.clampf(d.a + f.a * c(), 0, 255)
		};
		e = {
			r: cc.clampf(g.r + e.r * c(), 0, 255),
			g: cc.clampf(g.g + e.g * c(), 0, 255),
			b: cc.clampf(g.b + e.b * c(), 0, 255),
			a: cc.clampf(g.a + e.a * c(), 0, 255)
		};
		b.color = d;
		f = b.deltaColor;
		g = b.timeToLive;
		f.r = (e.r - d.r) / g;
		f.g = (e.g - d.g) / g;
		f.b = (e.b - d.b) / g;
		f.a = (e.a - d.a) / g;
		d = this.startSize + this.startSizeVar * c();
		d = Math.max(0, d);
		b.size = d;
		this.endSize === cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE ? b.deltaSize = 0 : (e = this.endSize + this.endSizeVar * c(), e = Math.max(0, e), b.deltaSize = (e - d) / g);
		d = this.startSpin + this.startSpinVar * c();
		e = this.endSpin + this.endSpinVar * c();
		b.rotation = d;
		b.deltaRotation = (e - d) / g;
		this.positionType === cc.ParticleSystem.TYPE_FREE ? b.startPos = this.convertToWorldSpace(this._pointZeroForParticle) : this.positionType === cc.ParticleSystem.TYPE_RELATIVE && (b.startPos.x = this._position.x, b.startPos.y = this._position.y);
		d = cc.degreesToRadians(this.angle + this.angleVar * c());
		if (this.emitterMode === cc.ParticleSystem.MODE_GRAVITY) {
			g = this.modeA, e = b.modeA, f = g.speed + g.speedVar * c(), e.dir.x = Math.cos(d), e.dir.y = Math.sin(d), cc.pMultIn(e.dir, f), e.radialAccel = g.radialAccel + g.radialAccelVar * c(), e.tangentialAccel = g.tangentialAccel + g.tangentialAccelVar * c(), g.rotationIsDir && (b.rotation = -cc.radiansToDegrees(cc.pToAngle(e.dir)))
		} else {
			e = this.modeB;
			b = b.modeB;
			var f = e.startRadius + e.startRadiusVar * c(),
				h = e.endRadius + e.endRadiusVar * c();
			b.radius = f;
			b.deltaRadius = e.endRadius === cc.ParticleSystem.START_RADIUS_EQUAL_TO_END_RADIUS ? 0 : (h - f) / g;
			b.angle = d;
			b.degreesPerSecond = cc.degreesToRadians(e.rotatePerSecond + e.rotatePerSecondVar * c())
		}
	},
	stopSystem: function() {
		this._isActive = !1;
		this._elapsed = this.duration;
		this._emitCounter = 0
	},
	resetSystem: function() {
		this._isActive = !0;
		this._elapsed = 0;
		var b = this._particles;
		for (this._particleIdx = 0; this._particleIdx < this.particleCount; ++this._particleIdx) {
			b[this._particleIdx].timeToLive = 0
		}
	},
	isFull: function() {
		return this.particleCount >= this._totalParticles
	},
	updateQuadWithParticle: function(b, c) {
		this._renderCmd.updateQuadWithParticle(b, c)
	},
	postStep: function() {
		this._renderCmd.postStep()
	},
	update: function(b) {
		if (this._isActive && this.emissionRate) {
			var c = 1 / this.emissionRate;
			this.particleCount < this._totalParticles && (this._emitCounter += b);
			for (; this.particleCount < this._totalParticles && this._emitCounter > c;) {
				this.addParticle(), this._emitCounter -= c
			}
			this._elapsed += b; - 1 !== this.duration && this.duration < this._elapsed && this.stopSystem()
		}
		this._particleIdx = 0;
		c = cc.Particle.TemporaryPoints[0];
		this.positionType === cc.ParticleSystem.TYPE_FREE ? cc.pIn(c, this.convertToWorldSpace(this._pointZeroForParticle)) : this.positionType === cc.ParticleSystem.TYPE_RELATIVE && (c.x = this._position.x, c.y = this._position.y);
		if (this._visible) {
			for (var d = cc.Particle.TemporaryPoints[1], e = cc.Particle.TemporaryPoints[2], f = cc.Particle.TemporaryPoints[3], g = this._particles; this._particleIdx < this.particleCount;) {
				cc.pZeroIn(d);
				cc.pZeroIn(e);
				cc.pZeroIn(f);
				var h = g[this._particleIdx];
				h.timeToLive -= b;
				if (0 < h.timeToLive) {
					if (this.emitterMode === cc.ParticleSystem.MODE_GRAVITY) {
						var k = f,
							m = d,
							n = e;
						h.pos.x || h.pos.y ? (cc.pIn(m, h.pos), cc.pNormalizeIn(m)) : cc.pZeroIn(m);
						cc.pIn(n, m);
						cc.pMultIn(m, h.modeA.radialAccel);
						var p = n.x;
						n.x = -n.y;
						n.y = p;
						cc.pMultIn(n, h.modeA.tangentialAccel);
						cc.pIn(k, m);
						cc.pAddIn(k, n);
						cc.pAddIn(k, this.modeA.gravity);
						cc.pMultIn(k, b);
						cc.pAddIn(h.modeA.dir, k);
						cc.pIn(k, h.modeA.dir);
						cc.pMultIn(k, b);
						cc.pAddIn(h.pos, k)
					} else {
						k = h.modeB, k.angle += k.degreesPerSecond * b, k.radius += k.deltaRadius * b, h.pos.x = -Math.cos(k.angle) * k.radius, h.pos.y = -Math.sin(k.angle) * k.radius
					}
					this._renderCmd._updateDeltaColor(h, b);
					h.size += h.deltaSize * b;
					h.size = Math.max(0, h.size);
					h.rotation += h.deltaRotation * b;
					k = d;
					this.positionType === cc.ParticleSystem.TYPE_FREE || this.positionType === cc.ParticleSystem.TYPE_RELATIVE ? (m = e, cc.pIn(m, c), cc.pSubIn(m, h.startPos), cc.pIn(k, h.pos), cc.pSubIn(k, m)) : cc.pIn(k, h.pos);
					this._batchNode && (k.x += this._position.x, k.y += this._position.y);
					this._renderCmd.updateParticlePosition(h, k);
					++this._particleIdx
				} else {
					if (h = h.atlasIndex, this._particleIdx !== this.particleCount - 1 && (k = g[this._particleIdx], g[this._particleIdx] = g[this.particleCount - 1], g[this.particleCount - 1] = k), this._batchNode && (this._batchNode.disableParticle(this.atlasIndex + h), g[this.particleCount - 1].atlasIndex = h), --this.particleCount, 0 === this.particleCount && this.autoRemoveOnFinish) {
						this.unscheduleUpdate();
						this._parent.removeChild(this, !0);
						return
					}
				}
			}
			this._transformSystemDirty = !1
		}
		this._batchNode || this.postStep()
	},
	updateWithNoTime: function() {
		this.update(0)
	},
	_valueForKey: function(b, c) {
		if (c) {
			var d = c[b];
			return null != d ? d : ""
		}
		return ""
	},
	_updateBlendFunc: function() {
		if (this._batchNode) {
			cc.log("Can't change blending functions when the particle is being batched")
		} else {
			var b = this._texture;
			if (b && b instanceof cc.Texture2D) {
				this._opacityModifyRGB = !1;
				var c = this._blendFunc;
				c.src === cc.BLEND_SRC && c.dst === cc.BLEND_DST && (b.hasPremultipliedAlpha() ? this._opacityModifyRGB = !0 : (c.src = cc.SRC_ALPHA, c.dst = cc.ONE_MINUS_SRC_ALPHA))
			}
		}
	},
	clone: function() {
		var b = new cc.ParticleSystem;
		if (b.initWithTotalParticles(this.getTotalParticles())) {
			b.setAngle(this.getAngle());
			b.setAngleVar(this.getAngleVar());
			b.setDuration(this.getDuration());
			var c = this.getBlendFunc();
			b.setBlendFunc(c.src, c.dst);
			b.setStartColor(this.getStartColor());
			b.setStartColorVar(this.getStartColorVar());
			b.setEndColor(this.getEndColor());
			b.setEndColorVar(this.getEndColorVar());
			b.setStartSize(this.getStartSize());
			b.setStartSizeVar(this.getStartSizeVar());
			b.setEndSize(this.getEndSize());
			b.setEndSizeVar(this.getEndSizeVar());
			b.setPosition(cc.p(this.x, this.y));
			b.setPosVar(cc.p(this.getPosVar().x, this.getPosVar().y));
			b.setPositionType(this.getPositionType());
			b.setStartSpin(this.getStartSpin() || 0);
			b.setStartSpinVar(this.getStartSpinVar() || 0);
			b.setEndSpin(this.getEndSpin() || 0);
			b.setEndSpinVar(this.getEndSpinVar() || 0);
			b.setEmitterMode(this.getEmitterMode());
			this.getEmitterMode() === cc.ParticleSystem.MODE_GRAVITY ? (c = this.getGravity(), b.setGravity(cc.p(c.x, c.y)), b.setSpeed(this.getSpeed()), b.setSpeedVar(this.getSpeedVar()), b.setRadialAccel(this.getRadialAccel()), b.setRadialAccelVar(this.getRadialAccelVar()), b.setTangentialAccel(this.getTangentialAccel()), b.setTangentialAccelVar(this.getTangentialAccelVar())) : this.getEmitterMode() === cc.ParticleSystem.MODE_RADIUS && (b.setStartRadius(this.getStartRadius()), b.setStartRadiusVar(this.getStartRadiusVar()), b.setEndRadius(this.getEndRadius()), b.setEndRadiusVar(this.getEndRadiusVar()), b.setRotatePerSecond(this.getRotatePerSecond()), b.setRotatePerSecondVar(this.getRotatePerSecondVar()));
			b.setLife(this.getLife());
			b.setLifeVar(this.getLifeVar());
			b.setEmissionRate(this.getEmissionRate());
			if (!this.getBatchNode() && (b.setOpacityModifyRGB(this.isOpacityModifyRGB()), c = this.getTexture())) {
				var d = c.getContentSize();
				b.setTextureWithRect(c, cc.rect(0, 0, d.width, d.height))
			}
		}
		return b
	},
	setDisplayFrame: function(b) {
		if (b) {
			var c = b.getOffsetInPixels();
			0 === c.x && 0 === c.y || cc.log("cc.ParticleSystem.setDisplayFrame(): QuadParticle only supports SpriteFrames with no offsets");
			b = b.getTexture();
			this._texture !== b && this.setTexture(b)
		}
	},
	setTextureWithRect: function(b, c) {
		this._texture !== b && (this._texture = b, this._updateBlendFunc());
		this.initTexCoordsWithRect(c)
	},
	listenBackToForeground: function(b) {}
});
_p = cc.ParticleSystem.prototype;
cc.defineGetterSetter(_p, "opacityModifyRGB", _p.isOpacityModifyRGB, _p.setOpacityModifyRGB);
cc.defineGetterSetter(_p, "batchNode", _p.getBatchNode, _p.setBatchNode);
cc.defineGetterSetter(_p, "drawMode", _p.getDrawMode, _p.setDrawMode);
cc.defineGetterSetter(_p, "shapeType", _p.getShapeType, _p.setShapeType);
cc.defineGetterSetter(_p, "active", _p.isActive);
cc.defineGetterSetter(_p, "sourcePos", _p.getSourcePosition, _p.setSourcePosition);
cc.defineGetterSetter(_p, "posVar", _p.getPosVar, _p.setPosVar);
cc.defineGetterSetter(_p, "gravity", _p.getGravity, _p.setGravity);
cc.defineGetterSetter(_p, "speed", _p.getSpeed, _p.setSpeed);
cc.defineGetterSetter(_p, "speedVar", _p.getSpeedVar, _p.setSpeedVar);
cc.defineGetterSetter(_p, "tangentialAccel", _p.getTangentialAccel, _p.setTangentialAccel);
cc.defineGetterSetter(_p, "tangentialAccelVar", _p.getTangentialAccelVar, _p.setTangentialAccelVar);
cc.defineGetterSetter(_p, "radialAccel", _p.getRadialAccel, _p.setRadialAccel);
cc.defineGetterSetter(_p, "radialAccelVar", _p.getRadialAccelVar, _p.setRadialAccelVar);
cc.defineGetterSetter(_p, "rotationIsDir", _p.getRotationIsDir, _p.setRotationIsDir);
cc.defineGetterSetter(_p, "startRadius", _p.getStartRadius, _p.setStartRadius);
cc.defineGetterSetter(_p, "startRadiusVar", _p.getStartRadiusVar, _p.setStartRadiusVar);
cc.defineGetterSetter(_p, "endRadius", _p.getEndRadius, _p.setEndRadius);
cc.defineGetterSetter(_p, "endRadiusVar", _p.getEndRadiusVar, _p.setEndRadiusVar);
cc.defineGetterSetter(_p, "rotatePerS", _p.getRotatePerSecond, _p.setRotatePerSecond);
cc.defineGetterSetter(_p, "rotatePerSVar", _p.getRotatePerSecondVar, _p.setRotatePerSecondVar);
cc.defineGetterSetter(_p, "startColor", _p.getStartColor, _p.setStartColor);
cc.defineGetterSetter(_p, "startColorVar", _p.getStartColorVar, _p.setStartColorVar);
cc.defineGetterSetter(_p, "endColor", _p.getEndColor, _p.setEndColor);
cc.defineGetterSetter(_p, "endColorVar", _p.getEndColorVar, _p.setEndColorVar);
cc.defineGetterSetter(_p, "totalParticles", _p.getTotalParticles, _p.setTotalParticles);
cc.defineGetterSetter(_p, "texture", _p.getTexture, _p.setTexture);
cc.ParticleSystem.create = function(b) {
	return new cc.ParticleSystem(b)
};
cc.ParticleSystem.createWithTotalParticles = cc.ParticleSystem.create;
cc.ParticleSystem.ModeA = function(b, c, d, e, f, g, h, k) {
	this.gravity = b ? b : cc.p(0, 0);
	this.speed = c || 0;
	this.speedVar = d || 0;
	this.tangentialAccel = e || 0;
	this.tangentialAccelVar = f || 0;
	this.radialAccel = g || 0;
	this.radialAccelVar = h || 0;
	this.rotationIsDir = k || !1
};
cc.ParticleSystem.ModeB = function(b, c, d, e, f, g) {
	this.startRadius = b || 0;
	this.startRadiusVar = c || 0;
	this.endRadius = d || 0;
	this.endRadiusVar = e || 0;
	this.rotatePerSecond = f || 0;
	this.rotatePerSecondVar = g || 0
};
cc.ParticleSystem.SHAPE_MODE = 0;
cc.ParticleSystem.TEXTURE_MODE = 1;
cc.ParticleSystem.STAR_SHAPE = 0;
cc.ParticleSystem.BALL_SHAPE = 1;
cc.ParticleSystem.DURATION_INFINITY = -1;
cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE = -1;
cc.ParticleSystem.START_RADIUS_EQUAL_TO_END_RADIUS = -1;
cc.ParticleSystem.MODE_GRAVITY = 0;
cc.ParticleSystem.MODE_RADIUS = 1;
cc.ParticleSystem.TYPE_FREE = 0;
cc.ParticleSystem.TYPE_RELATIVE = 1;
cc.ParticleSystem.TYPE_GROUPED = 2;
(function() {
	cc.ParticleSystem.CanvasRenderCmd = function(b) {
		cc.Node.CanvasRenderCmd.call(this, b);
		this._needDraw = !0;
		this._drawMode = cc.ParticleSystem.TEXTURE_MODE;
		this._shapeType = cc.ParticleSystem.BALL_SHAPE;
		this._pointRect = cc.rect(0, 0, 0, 0)
	};
	var b = cc.ParticleSystem.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
	b.constructor = cc.ParticleSystem.CanvasRenderCmd;
	b.getDrawMode = function() {
		return this._drawMode
	};
	b.setDrawMode = function(b) {
		this._drawMode = b
	};
	b.getShapeType = function() {
		return this._shapeType
	};
	b.setShapeType = function(b) {
		this._shapeType = b
	};
	b.setBatchNode = function(b) {
		this._batchNode !== b && (this._node._batchNode = b)
	};
	b.updateQuadWithParticle = function(b, d) {};
	b.updateParticlePosition = function(b, d) {
		cc.pIn(b.drawPos, d)
	};
	b.rendering = function(b, d, e) {
		b = b || cc._renderContext;
		var f = b.getContext(),
			g = this._node,
			h = this._pointRect;
		b.setTransform(this._worldTransform, d, e);
		b.save();
		g.isBlendAdditive() ? f.globalCompositeOperation = "lighter" : f.globalCompositeOperation = "source-over";
		var k, m;
		e = this._node.particleCount;
		var n = this._node._particles;
		if (g.drawMode !== cc.ParticleSystem.SHAPE_MODE && g._texture) {
			if (!g._texture._textureLoaded) {
				b.restore();
				return
			}
			g = g._texture.getHtmlElementObj();
			if (!g.width || !g.height) {
				b.restore();
				return
			}
			k = g;
			for (d = 0; d < e; d++) {
				if (k = n[d], m = k.color.a / 255, 0 !== m) {
					f.globalAlpha = m;
					f.save();
					f.translate(0 | k.drawPos.x, -(0 | k.drawPos.y));
					var p = 4 * Math.floor(k.size / 4);
					m = h.width;
					var r = h.height;
					f.scale(Math.max(1 / m * p, 0.000001), Math.max(1 / r * p, 0.000001));
					k.rotation && f.rotate(cc.degreesToRadians(k.rotation));
					k = k.isChangeColor ? this._changeTextureColor(g, k.color, this._pointRect) : g;
					f.drawImage(k, -(0 | m / 2), -(0 | r / 2));
					f.restore()
				}
			}
		} else {
			for (r = cc._drawingUtil, d = 0; d < e; d++) {
				k = n[d], h = 0 | 0.5 * k.size, m = k.color.a / 255, 0 !== m && (f.globalAlpha = m, f.save(), f.translate(0 | k.drawPos.x, -(0 | k.drawPos.y)), g.shapeType === cc.ParticleSystem.STAR_SHAPE ? (k.rotation && f.rotate(cc.degreesToRadians(k.rotation)), r.drawStar(b, h, k.color)) : r.drawColorBall(b, h, k.color), f.restore())
			}
		}
		b.restore();
		cc.g_NumberOfDraws++
	};
	b._changeTextureColor = cc.sys._supportCanvasNewBlendModes ?
	function(b, d, e) {
		b.tintCache || (b.tintCache = document.createElement("canvas"), b.tintCache.width = b.width, b.tintCache.height = b.height);
		return cc.Sprite.CanvasRenderCmd._generateTintImageWithMultiply(b, d, e, b.tintCache)
	} : function(b, d, e) {
		var f = cc.textureCache.getTextureColors(b);
		return f ? (f.tintCache || (f.tintCache = document.createElement("canvas"), f.tintCache.width = b.width, f.tintCache.height = b.height), cc.Sprite.CanvasRenderCmd._generateTintImage(b, f, d, e, f.tintCache), f.tintCache) : null
	};
	b.initTexCoordsWithRect = function(b) {
		this._pointRect = b
	};
	b.setTotalParticles = function(b) {
		this._node._totalParticles = 200 > b ? b : 200
	};
	b.addParticle = function() {
		var b = this._node,
			d = b._particles;
		b.particleCount < d.length ? b = d[b.particleCount] : (b = new cc.Particle, d.push(b));
		return b
	};
	b._setupVBO = function() {};
	b._allocMemory = function() {
		return !0
	};
	b.postStep = function() {};
	b._setBlendAdditive = function() {
		var b = this._node._blendFunc;
		b.src = cc.BLEND_SRC;
		b.dst = cc.BLEND_DST
	};
	b._initWithTotalParticles = function(b) {};
	b._updateDeltaColor = function(b, d) {
		this._node._dontTint || (b.color.r += b.deltaColor.r * d, b.color.g += b.deltaColor.g * d, b.color.b += b.deltaColor.b * d, b.color.a += b.deltaColor.a * d, b.isChangeColor = !0)
	}
})();
(function() {
	cc.ParticleSystem.WebGLRenderCmd = function(b) {
		cc.Node.WebGLRenderCmd.call(this, b);
		this._needDraw = !0;
		this._buffersVBO = [0, 0];
		this._quads = [];
		this._indices = [];
		this._quadsArrayBuffer = null
	};
	var b = cc.ParticleSystem.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
	b.constructor = cc.ParticleSystem.WebGLRenderCmd;
	b.getDrawMode = function() {};
	b.setDrawMode = function(b) {};
	b.getShapeType = function() {};
	b.setShapeType = function(b) {};
	b.setBatchNode = function(b) {
		var d = this._node;
		if (d._batchNode !== b) {
			var e = d._batchNode;
			if (d._batchNode = b) {
				for (var f = d._particles, g = 0; g < d._totalParticles; g++) {
					f[g].atlasIndex = g
				}
			}
			b ? e || (d._batchNode.textureAtlas._copyQuadsToTextureAtlas(this._quads, d.atlasIndex), cc._renderContext.deleteBuffer(this._buffersVBO[1])) : (this._allocMemory(), this.initIndices(d._totalParticles), d.setTexture(e.getTexture()), this._setupVBO())
		}
	};
	b.initIndices = function(b) {
		for (var d = this._indices, e = 0; e < b; ++e) {
			var f = 6 * e,
				g = 4 * e;
			d[f + 0] = g + 0;
			d[f + 1] = g + 1;
			d[f + 2] = g + 2;
			d[f + 5] = g + 1;
			d[f + 4] = g + 2;
			d[f + 3] = g + 3
		}
	};
	b.isDifferentTexture = function(b, d) {
		return b === d
	};
	b.updateParticlePosition = function(b, d) {
		this.updateQuadWithParticle(b, d)
	};
	b.updateQuadWithParticle = function(b, d) {
		var e = null,
			f = this._node;
		f._batchNode ? (e = f._batchNode.textureAtlas.quads[f.atlasIndex + b.atlasIndex], f._batchNode.textureAtlas.dirty = !0) : e = this._quads[f._particleIdx];
		var g, h, k;
		f._opacityModifyRGB ? (f = 0 | b.color.r * b.color.a / 255, g = 0 | b.color.g * b.color.a / 255, h = 0 | b.color.b * b.color.a / 255) : (f = 0 | b.color.r, g = 0 | b.color.g, h = 0 | b.color.b);
		k = 0 | b.color.a;
		var m = e.bl.colors,
			n = e.br.colors,
			p = e.tl.colors,
			r = e.tr.colors;
		m.r = n.r = p.r = r.r = f;
		m.g = n.g = p.g = r.g = g;
		m.b = n.b = p.b = r.b = h;
		m.a = n.a = p.a = r.a = k;
		f = b.size / 2;
		b.rotation ? (g = -f, h = -f, k = d.x, m = d.y, p = -cc.degreesToRadians(b.rotation), n = Math.cos(p), p = Math.sin(p), e.bl.vertices.x = g * n - h * p + k, e.bl.vertices.y = g * p + h * n + m, e.br.vertices.x = f * n - h * p + k, e.br.vertices.y = f * p + h * n + m, e.tl.vertices.x = g * n - f * p + k, e.tl.vertices.y = g * p + f * n + m, e.tr.vertices.x = f * n - f * p + k, e.tr.vertices.y = f * p + f * n + m) : (e.bl.vertices.x = d.x - f, e.bl.vertices.y = d.y - f, e.br.vertices.x = d.x + f, e.br.vertices.y = d.y - f, e.tl.vertices.x = d.x - f, e.tl.vertices.y = d.y + f, e.tr.vertices.x = d.x + f, e.tr.vertices.y = d.y + f)
	};
	b.rendering = function(b) {
		var d = this._node;
		d._texture && (b = b || cc._renderContext, this._shaderProgram.use(), this._shaderProgram._setUniformForMVPMatrixWithMat4(this._stackMatrix), cc.glBindTexture2D(d._texture), cc.glBlendFuncForParticle(d._blendFunc.src, d._blendFunc.dst), cc.glEnableVertexAttribs(cc.VERTEX_ATTRIB_FLAG_POS_COLOR_TEX), b.bindBuffer(b.ARRAY_BUFFER, this._buffersVBO[0]), b.vertexAttribPointer(cc.VERTEX_ATTRIB_POSITION, 3, b.FLOAT, !1, 24, 0), b.vertexAttribPointer(cc.VERTEX_ATTRIB_COLOR, 4, b.UNSIGNED_BYTE, !0, 24, 12), b.vertexAttribPointer(cc.VERTEX_ATTRIB_TEX_COORDS, 2, b.FLOAT, !1, 24, 16), b.bindBuffer(b.ELEMENT_ARRAY_BUFFER, this._buffersVBO[1]), b.drawElements(b.TRIANGLES, 6 * d._particleIdx, b.UNSIGNED_SHORT, 0))
	};
	b.initTexCoordsWithRect = function(b) {
		var d = this._node,
			e = d.texture,
			f = cc.contentScaleFactor(),
			g = cc.rect(b.x * f, b.y * f, b.width * f, b.height * f),
			f = b.width,
			h = b.height;
		e && (f = e.pixelsWidth, h = e.pixelsHeight);
		cc.FIX_ARTIFACTS_BY_STRECHING_TEXEL ? (e = (2 * g.x + 1) / (2 * f), b = (2 * g.y + 1) / (2 * h), f = e + (2 * g.width - 2) / (2 * f), g = b + (2 * g.height - 2) / (2 * h)) : (e = g.x / f, b = g.y / h, f = e + g.width / f, g = b + g.height / h);
		h = g;
		g = b;
		b = h;
		var k = 0,
			m = 0;
		d._batchNode ? (h = d._batchNode.textureAtlas.quads, k = d.atlasIndex, m = d.atlasIndex + d._totalParticles) : (h = this._quads, k = 0, m = d._totalParticles);
		for (d = k; d < m; d++) {
			h[d] || (h[d] = cc.V3F_C4B_T2F_QuadZero()), k = h[d], k.bl.texCoords.u = e, k.bl.texCoords.v = b, k.br.texCoords.u = f, k.br.texCoords.v = b, k.tl.texCoords.u = e, k.tl.texCoords.v = g, k.tr.texCoords.u = f, k.tr.texCoords.v = g
		}
	};
	b.setTotalParticles = function(b) {
		var d = this._node;
		if (b > d._allocatedParticles) {
			var e = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT;
			this._indices = new Uint16Array(6 * b);
			var f = new ArrayBuffer(b * e),
				g = d._particles;
			g.length = 0;
			for (var h = this._quads, k = h.length = 0; k < b; k++) {
				g[k] = new cc.Particle, h[k] = new cc.V3F_C4B_T2F_Quad(null, null, null, null, f, k * e)
			}
			d._allocatedParticles = b;
			d._totalParticles = b;
			if (d._batchNode) {
				for (e = 0; e < b; e++) {
					g[e].atlasIndex = e
				}
			}
			this._quadsArrayBuffer = f;
			this.initIndices(b);
			this._setupVBO();
			d._texture && this.initTexCoordsWithRect(cc.rect(0, 0, d._texture.width, d._texture.height))
		} else {
			d._totalParticles = b
		}
		d.resetSystem()
	};
	b.addParticle = function() {
		var b = this._node;
		return b._particles[b.particleCount]
	};
	b._setupVBO = function() {
		var b = cc._renderContext;
		this._buffersVBO[0] = b.createBuffer();
		b.bindBuffer(b.ARRAY_BUFFER, this._buffersVBO[0]);
		b.bufferData(b.ARRAY_BUFFER, this._quadsArrayBuffer, b.DYNAMIC_DRAW);
		this._buffersVBO[1] = b.createBuffer();
		b.bindBuffer(b.ELEMENT_ARRAY_BUFFER, this._buffersVBO[1]);
		b.bufferData(b.ELEMENT_ARRAY_BUFFER, this._indices, b.STATIC_DRAW)
	};
	b._allocMemory = function() {
		var b = this._node;
		if (b._batchNode) {
			return cc.log("cc.ParticleSystem._allocMemory(): Memory should not be allocated when not using batchNode"), !1
		}
		var d = cc.V3F_C4B_T2F_Quad.BYTES_PER_ELEMENT,
			b = b._totalParticles,
			e = this._quads;
		e.length = 0;
		this._indices = new Uint16Array(6 * b);
		for (var f = new ArrayBuffer(d * b), g = 0; g < b; g++) {
			e[g] = new cc.V3F_C4B_T2F_Quad(null, null, null, null, f, g * d)
		}
		if (!e || !this._indices) {
			return cc.log("cocos2d: Particle system: not enough memory"), !1
		}
		this._quadsArrayBuffer = f;
		return !0
	};
	b.postStep = function() {
		var b = cc._renderContext;
		b.bindBuffer(b.ARRAY_BUFFER, this._buffersVBO[0]);
		b.bufferData(b.ARRAY_BUFFER, this._quadsArrayBuffer, b.DYNAMIC_DRAW)
	};
	b._setBlendAdditive = function() {
		var b = this._node._blendFunc;
		this._texture && !this._texture.hasPremultipliedAlpha() ? (b.src = cc.SRC_ALPHA, b.dst = cc.ONE_MINUS_SRC_ALPHA) : (b.src = cc.BLEND_SRC, b.dst = cc.BLEND_DST)
	};
	b._initWithTotalParticles = function(b) {
		if (!this._allocMemory()) {
			return !1
		}
		this.initIndices(b);
		this._setupVBO();
		this._shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_TEXTURECOLOR)
	};
	b._updateDeltaColor = function(b, d) {
		b.color.r += b.deltaColor.r * d;
		b.color.g += b.deltaColor.g * d;
		b.color.b += b.deltaColor.b * d;
		b.color.a += b.deltaColor.a * d;
		b.isChangeColor = !0
	}
})();
cc.ParticleFire = cc.ParticleSystem.extend({
	ctor: function() {
		cc.ParticleSystem.prototype.ctor.call(this, cc._renderType === cc._RENDER_TYPE_WEBGL ? 300 : 150)
	},
	initWithTotalParticles: function(b) {
		return cc.ParticleSystem.prototype.initWithTotalParticles.call(this, b) ? (this.setDuration(cc.ParticleSystem.DURATION_INFINITY), this.setEmitterMode(cc.ParticleSystem.MODE_GRAVITY), this.setGravity(cc.p(0, 0)), this.setRadialAccel(0), this.setRadialAccelVar(0), this.setSpeed(60), this.setSpeedVar(20), this.setAngle(90), this.setAngleVar(10), b = cc.director.getWinSize(), this.setPosition(b.width / 2, 60), this.setPosVar(cc.p(40, 20)), this.setLife(3), this.setLifeVar(0.25), this.setStartSize(54), this.setStartSizeVar(10), this.setEndSize(cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE), this.setEmissionRate(this.getTotalParticles() / this.getLife()), this.setStartColor(cc.color(194, 64, 31, 255)), this.setStartColorVar(cc.color(0, 0, 0, 0)), this.setEndColor(cc.color(0, 0, 0, 255)), this.setEndColorVar(cc.color(0, 0, 0, 0)), this.setBlendAdditive(!0), !0) : !1
	}
});
cc.ParticleFire.create = function() {
	return new cc.ParticleFire
};
cc.ParticleFireworks = cc.ParticleSystem.extend({
	ctor: function() {
		cc.ParticleSystem.prototype.ctor.call(this, cc._renderType === cc._RENDER_TYPE_WEBGL ? 1500 : 150)
	},
	initWithTotalParticles: function(b) {
		return cc.ParticleSystem.prototype.initWithTotalParticles.call(this, b) ? (this.setDuration(cc.ParticleSystem.DURATION_INFINITY), this.setEmitterMode(cc.ParticleSystem.MODE_GRAVITY), this.setGravity(cc.p(0, -90)), this.setRadialAccel(0), this.setRadialAccelVar(0), this.setSpeed(180), this.setSpeedVar(50), b = cc.director.getWinSize(), this.setPosition(b.width / 2, b.height / 2), this.setAngle(90), this.setAngleVar(20), this.setLife(3.5), this.setLifeVar(1), this.setEmissionRate(this.getTotalParticles() / this.getLife()), this.setStartColor(cc.color(128, 128, 128, 255)), this.setStartColorVar(cc.color(128, 128, 128, 255)), this.setEndColor(cc.color(26, 26, 26, 51)), this.setEndColorVar(cc.color(26, 26, 26, 51)), this.setStartSize(8), this.setStartSizeVar(2), this.setEndSize(cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE), this.setBlendAdditive(!1), !0) : !1
	}
});
cc.ParticleFireworks.create = function() {
	return new cc.ParticleFireworks
};
cc.ParticleSun = cc.ParticleSystem.extend({
	ctor: function() {
		cc.ParticleSystem.prototype.ctor.call(this, cc._renderType === cc._RENDER_TYPE_WEBGL ? 350 : 150)
	},
	initWithTotalParticles: function(b) {
		return cc.ParticleSystem.prototype.initWithTotalParticles.call(this, b) ? (this.setBlendAdditive(!0), this.setDuration(cc.ParticleSystem.DURATION_INFINITY), this.setEmitterMode(cc.ParticleSystem.MODE_GRAVITY), this.setGravity(cc.p(0, 0)), this.setRadialAccel(0), this.setRadialAccelVar(0), this.setSpeed(20), this.setSpeedVar(5), this.setAngle(90), this.setAngleVar(360), b = cc.director.getWinSize(), this.setPosition(b.width / 2, b.height / 2), this.setPosVar(cc.p(0, 0)), this.setLife(1), this.setLifeVar(0.5), this.setStartSize(30), this.setStartSizeVar(10), this.setEndSize(cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE), this.setEmissionRate(this.getTotalParticles() / this.getLife()), this.setStartColor(cc.color(194, 64, 31, 255)), this.setStartColorVar(cc.color(0, 0, 0, 0)), this.setEndColor(cc.color(0, 0, 0, 255)), this.setEndColorVar(cc.color(0, 0, 0, 0)), !0) : !1
	}
});
cc.ParticleSun.create = function() {
	return new cc.ParticleSun
};
cc.ParticleGalaxy = cc.ParticleSystem.extend({
	ctor: function() {
		cc.ParticleSystem.prototype.ctor.call(this, cc._renderType === cc._RENDER_TYPE_WEBGL ? 200 : 100)
	},
	initWithTotalParticles: function(b) {
		return cc.ParticleSystem.prototype.initWithTotalParticles.call(this, b) ? (this.setDuration(cc.ParticleSystem.DURATION_INFINITY), this.setEmitterMode(cc.ParticleSystem.MODE_GRAVITY), this.setGravity(cc.p(0, 0)), this.setSpeed(60), this.setSpeedVar(10), this.setRadialAccel(-80), this.setRadialAccelVar(0), this.setTangentialAccel(80), this.setTangentialAccelVar(0), this.setAngle(90), this.setAngleVar(360), b = cc.director.getWinSize(), this.setPosition(b.width / 2, b.height / 2), this.setPosVar(cc.p(0, 0)), this.setLife(4), this.setLifeVar(1), this.setStartSize(37), this.setStartSizeVar(10), this.setEndSize(cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE), this.setEmissionRate(this.getTotalParticles() / this.getLife()), this.setStartColor(cc.color(31, 64, 194, 255)), this.setStartColorVar(cc.color(0, 0, 0, 0)), this.setEndColor(cc.color(0, 0, 0, 255)), this.setEndColorVar(cc.color(0, 0, 0, 0)), this.setBlendAdditive(!0), !0) : !1
	}
});
cc.ParticleGalaxy.create = function() {
	return new cc.ParticleGalaxy
};
cc.ParticleFlower = cc.ParticleSystem.extend({
	ctor: function() {
		cc.ParticleSystem.prototype.ctor.call(this, cc._renderType === cc._RENDER_TYPE_WEBGL ? 250 : 100)
	},
	initWithTotalParticles: function(b) {
		return cc.ParticleSystem.prototype.initWithTotalParticles.call(this, b) ? (this.setDuration(cc.ParticleSystem.DURATION_INFINITY), this.setEmitterMode(cc.ParticleSystem.MODE_GRAVITY), this.setGravity(cc.p(0, 0)), this.setSpeed(80), this.setSpeedVar(10), this.setRadialAccel(-60), this.setRadialAccelVar(0), this.setTangentialAccel(15), this.setTangentialAccelVar(0), this.setAngle(90), this.setAngleVar(360), b = cc.director.getWinSize(), this.setPosition(b.width / 2, b.height / 2), this.setPosVar(cc.p(0, 0)), this.setLife(4), this.setLifeVar(1), this.setStartSize(30), this.setStartSizeVar(10), this.setEndSize(cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE), this.setEmissionRate(this.getTotalParticles() / this.getLife()), this.setStartColor(cc.color(128, 128, 128, 255)), this.setStartColorVar(cc.color(128, 128, 128, 128)), this.setEndColor(cc.color(0, 0, 0, 255)), this.setEndColorVar(cc.color(0, 0, 0, 0)), this.setBlendAdditive(!0), !0) : !1
	}
});
cc.ParticleFlower.create = function() {
	return new cc.ParticleFlower
};
cc.ParticleMeteor = cc.ParticleSystem.extend({
	ctor: function() {
		cc.ParticleSystem.prototype.ctor.call(this, cc._renderType === cc._RENDER_TYPE_WEBGL ? 150 : 100)
	},
	initWithTotalParticles: function(b) {
		return cc.ParticleSystem.prototype.initWithTotalParticles.call(this, b) ? (this.setDuration(cc.ParticleSystem.DURATION_INFINITY), this.setEmitterMode(cc.ParticleSystem.MODE_GRAVITY), this.setGravity(cc.p(-200, 200)), this.setSpeed(15), this.setSpeedVar(5), this.setRadialAccel(0), this.setRadialAccelVar(0), this.setTangentialAccel(0), this.setTangentialAccelVar(0), this.setAngle(90), this.setAngleVar(360), b = cc.director.getWinSize(), this.setPosition(b.width / 2, b.height / 2), this.setPosVar(cc.p(0, 0)), this.setLife(2), this.setLifeVar(1), this.setStartSize(60), this.setStartSizeVar(10), this.setEndSize(cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE), this.setEmissionRate(this.getTotalParticles() / this.getLife()), this.setStartColor(cc.color(51, 102, 179)), this.setStartColorVar(cc.color(0, 0, 51, 26)), this.setEndColor(cc.color(0, 0, 0, 255)), this.setEndColorVar(cc.color(0, 0, 0, 0)), this.setBlendAdditive(!0), !0) : !1
	}
});
cc.ParticleMeteor.create = function() {
	return new cc.ParticleMeteor
};
cc.ParticleSpiral = cc.ParticleSystem.extend({
	ctor: function() {
		cc.ParticleSystem.prototype.ctor.call(this, cc._renderType === cc._RENDER_TYPE_WEBGL ? 500 : 100)
	},
	initWithTotalParticles: function(b) {
		return cc.ParticleSystem.prototype.initWithTotalParticles.call(this, b) ? (this.setDuration(cc.ParticleSystem.DURATION_INFINITY), this.setEmitterMode(cc.ParticleSystem.MODE_GRAVITY), this.setGravity(cc.p(0, 0)), this.setSpeed(150), this.setSpeedVar(0), this.setRadialAccel(-380), this.setRadialAccelVar(0), this.setTangentialAccel(45), this.setTangentialAccelVar(0), this.setAngle(90), this.setAngleVar(0), b = cc.director.getWinSize(), this.setPosition(b.width / 2, b.height / 2), this.setPosVar(cc.p(0, 0)), this.setLife(12), this.setLifeVar(0), this.setStartSize(20), this.setStartSizeVar(0), this.setEndSize(cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE), this.setEmissionRate(this.getTotalParticles() / this.getLife()), this.setStartColor(cc.color(128, 128, 128, 255)), this.setStartColorVar(cc.color(128, 128, 128, 0)), this.setEndColor(cc.color(128, 128, 128, 255)), this.setEndColorVar(cc.color(128, 128, 128, 0)), this.setBlendAdditive(!1), !0) : !1
	}
});
cc.ParticleSpiral.create = function() {
	return new cc.ParticleSpiral
};
cc.ParticleExplosion = cc.ParticleSystem.extend({
	ctor: function() {
		cc.ParticleSystem.prototype.ctor.call(this, cc._renderType === cc._RENDER_TYPE_WEBGL ? 700 : 300)
	},
	initWithTotalParticles: function(b) {
		return cc.ParticleSystem.prototype.initWithTotalParticles.call(this, b) ? (this.setDuration(0.1), this.setEmitterMode(cc.ParticleSystem.MODE_GRAVITY), this.setGravity(cc.p(0, 0)), this.setSpeed(70), this.setSpeedVar(40), this.setRadialAccel(0), this.setRadialAccelVar(0), this.setTangentialAccel(0), this.setTangentialAccelVar(0), this.setAngle(90), this.setAngleVar(360), b = cc.director.getWinSize(), this.setPosition(b.width / 2, b.height / 2), this.setPosVar(cc.p(0, 0)), this.setLife(5), this.setLifeVar(2), this.setStartSize(15), this.setStartSizeVar(10), this.setEndSize(cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE), this.setEmissionRate(this.getTotalParticles() / this.getDuration()), this.setStartColor(cc.color(179, 26, 51, 255)), this.setStartColorVar(cc.color(128, 128, 128, 0)), this.setEndColor(cc.color(128, 128, 128, 0)), this.setEndColorVar(cc.color(128, 128, 128, 0)), this.setBlendAdditive(!1), !0) : !1
	}
});
cc.ParticleExplosion.create = function() {
	return new cc.ParticleExplosion
};
cc.ParticleSmoke = cc.ParticleSystem.extend({
	ctor: function() {
		cc.ParticleSystem.prototype.ctor.call(this, cc._renderType === cc._RENDER_TYPE_WEBGL ? 200 : 100)
	},
	initWithTotalParticles: function(b) {
		return cc.ParticleSystem.prototype.initWithTotalParticles.call(this, b) ? (this.setDuration(cc.ParticleSystem.DURATION_INFINITY), this.setEmitterMode(cc.ParticleSystem.MODE_GRAVITY), this.setGravity(cc.p(0, 0)), this.setRadialAccel(0), this.setRadialAccelVar(0), this.setSpeed(25), this.setSpeedVar(10), this.setAngle(90), this.setAngleVar(5), b = cc.director.getWinSize(), this.setPosition(b.width / 2, 0), this.setPosVar(cc.p(20, 0)), this.setLife(4), this.setLifeVar(1), this.setStartSize(60), this.setStartSizeVar(10), this.setEndSize(cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE), this.setEmissionRate(this.getTotalParticles() / this.getLife()), this.setStartColor(cc.color(204, 204, 204, 255)), this.setStartColorVar(cc.color(5, 5, 5, 0)), this.setEndColor(cc.color(0, 0, 0, 255)), this.setEndColorVar(cc.color(0, 0, 0, 0)), this.setBlendAdditive(!1), !0) : !1
	}
});
cc.ParticleSmoke.create = function() {
	return new cc.ParticleSmoke
};
cc.ParticleSnow = cc.ParticleSystem.extend({
	ctor: function() {
		cc.ParticleSystem.prototype.ctor.call(this, cc._renderType === cc._RENDER_TYPE_WEBGL ? 700 : 250)
	},
	initWithTotalParticles: function(b) {
		return cc.ParticleSystem.prototype.initWithTotalParticles.call(this, b) ? (this.setDuration(cc.ParticleSystem.DURATION_INFINITY), this.setEmitterMode(cc.ParticleSystem.MODE_GRAVITY), this.setGravity(cc.p(0, -1)), this.setSpeed(5), this.setSpeedVar(1), this.setRadialAccel(0), this.setRadialAccelVar(1), this.setTangentialAccel(0), this.setTangentialAccelVar(1), b = cc.director.getWinSize(), this.setPosition(b.width / 2, b.height + 10), this.setPosVar(cc.p(b.width / 2, 0)), this.setAngle(-90), this.setAngleVar(5), this.setLife(45), this.setLifeVar(15), this.setStartSize(10), this.setStartSizeVar(5), this.setEndSize(cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE), this.setEmissionRate(10), this.setStartColor(cc.color(255, 255, 255, 255)), this.setStartColorVar(cc.color(0, 0, 0, 0)), this.setEndColor(cc.color(255, 255, 255, 0)), this.setEndColorVar(cc.color(0, 0, 0, 0)), this.setBlendAdditive(!1), !0) : !1
	}
});
cc.ParticleSnow.create = function() {
	return new cc.ParticleSnow
};
cc.ParticleRain = cc.ParticleSystem.extend({
	ctor: function() {
		cc.ParticleSystem.prototype.ctor.call(this, cc._renderType === cc._RENDER_TYPE_WEBGL ? 1000 : 300)
	},
	initWithTotalParticles: function(b) {
		return cc.ParticleSystem.prototype.initWithTotalParticles.call(this, b) ? (this.setDuration(cc.ParticleSystem.DURATION_INFINITY), this.setEmitterMode(cc.ParticleSystem.MODE_GRAVITY), this.setGravity(cc.p(10, -10)), this.setRadialAccel(0), this.setRadialAccelVar(1), this.setTangentialAccel(0), this.setTangentialAccelVar(1), this.setSpeed(130), this.setSpeedVar(30), this.setAngle(-90), this.setAngleVar(5), b = cc.director.getWinSize(), this.setPosition(b.width / 2, b.height), this.setPosVar(cc.p(b.width / 2, 0)), this.setLife(4.5), this.setLifeVar(0), this.setStartSize(4), this.setStartSizeVar(2), this.setEndSize(cc.ParticleSystem.START_SIZE_EQUAL_TO_END_SIZE), this.setEmissionRate(20), this.setStartColor(cc.color(179, 204, 255, 255)), this.setStartColorVar(cc.color(0, 0, 0, 0)), this.setEndColor(cc.color(179, 204, 255, 128)), this.setEndColorVar(cc.color(0, 0, 0, 0)), this.setBlendAdditive(!1), !0) : !1
	}
});
cc.ParticleRain.create = function() {
	return new cc.ParticleRain
};
cc.PARTICLE_DEFAULT_CAPACITY = 500;
cc.ParticleBatchNode = cc.Node.extend({
	textureAtlas: null,
	_blendFunc: null,
	_className: "ParticleBatchNode",
	ctor: function(b, c) {
		cc.Node.prototype.ctor.call(this);
		this._blendFunc = {
			src: cc.BLEND_SRC,
			dst: cc.BLEND_DST
		};
		cc.isString(b) ? this.init(b, c) : b instanceof cc.Texture2D && this.initWithTexture(b, c)
	},
	_createRenderCmd: function() {
		return cc._renderType === cc._RENDER_TYPE_CANVAS ? new cc.ParticleBatchNode.CanvasRenderCmd(this) : new cc.ParticleBatchNode.WebGLRenderCmd(this)
	},
	initWithTexture: function(b, c) {
		this.textureAtlas = new cc.TextureAtlas;
		this.textureAtlas.initWithTexture(b, c);
		this._children.length = 0;
		this._renderCmd._initWithTexture();
		return !0
	},
	initWithFile: function(b, c) {
		var d = cc.textureCache.addImage(b);
		return this.initWithTexture(d, c)
	},
	init: function(b, c) {
		var d = cc.textureCache.addImage(b);
		return this.initWithTexture(d, c)
	},
	addChild: function(b, c, d) {
		if (!b) {
			throw "cc.ParticleBatchNode.addChild() : child should be non-null"
		}
		if (!(b instanceof cc.ParticleSystem)) {
			throw "cc.ParticleBatchNode.addChild() : only supports cc.ParticleSystem as children"
		}
		c = null == c ? b.zIndex : c;
		d = null == d ? b.tag : d;
		if (b.getTexture() !== this.textureAtlas.texture) {
			throw "cc.ParticleSystem.addChild() : the child is not using the same texture id"
		}
		var e = b.getBlendFunc();
		if (0 === this._children.length) {
			this.setBlendFunc(e)
		} else {
			if (e.src !== this._blendFunc.src || e.dst !== this._blendFunc.dst) {
				cc.log("cc.ParticleSystem.addChild() : Can't add a ParticleSystem that uses a different blending function");
				return
			}
		}
		c = this._addChildHelper(b, c, d);
		d = 0;
		0 !== c ? (c = this._children[c - 1], d = c.getAtlasIndex() + c.getTotalParticles()) : d = 0;
		this.insertChild(b, d);
		b.setBatchNode(this)
	},
	insertChild: function(b, c) {
		var d = b.getTotalParticles(),
			e = this.textureAtlas,
			f = e.totalQuads;
		b.setAtlasIndex(c);
		f + d > e.getCapacity() && (this._increaseAtlasCapacityTo(f + d), e.fillWithEmptyQuadsFromIndex(e.getCapacity() - d, d));
		b.getAtlasIndex() + d !== f && e.moveQuadsFromIndex(c, c + d);
		e.increaseTotalQuadsWith(d);
		this._updateAllAtlasIndexes()
	},
	removeChild: function(b, c) {
		if (null != b) {
			if (!(b instanceof cc.ParticleSystem)) {
				throw "cc.ParticleBatchNode.removeChild(): only supports cc.ParticleSystem as children"
			}
			if (-1 === this._children.indexOf(b)) {
				cc.log("cc.ParticleBatchNode.removeChild(): doesn't contain the sprite. Can't remove it")
			} else {
				cc.Node.prototype.removeChild.call(this, b, c);
				var d = this.textureAtlas;
				d.removeQuadsAtIndex(b.getAtlasIndex(), b.getTotalParticles());
				d.fillWithEmptyQuadsFromIndex(d.totalQuads, b.getTotalParticles());
				b.setBatchNode(null);
				this._updateAllAtlasIndexes()
			}
		}
	},
	reorderChild: function(b, c) {
		if (!b) {
			throw "cc.ParticleBatchNode.reorderChild(): child should be non-null"
		}
		if (!(b instanceof cc.ParticleSystem)) {
			throw "cc.ParticleBatchNode.reorderChild(): only supports cc.QuadParticleSystems as children"
		}
		if (-1 === this._children.indexOf(b)) {
			cc.log("cc.ParticleBatchNode.reorderChild(): Child doesn't belong to batch")
		} else {
			if (c !== b.zIndex) {
				if (1 < this._children.length) {
					var d = this._getCurrentIndex(b, c);
					if (d.oldIndex !== d.newIndex) {
						this._children.splice(d.oldIndex, 1);
						this._children.splice(d.newIndex, 0, b);
						d = b.getAtlasIndex();
						this._updateAllAtlasIndexes();
						for (var e = 0, f = this._children, g = 0; g < f.length; g++) {
							if (f[g] === b) {
								e = b.getAtlasIndex();
								break
							}
						}
						this.textureAtlas.moveQuadsFromIndex(d, b.getTotalParticles(), e);
						b.updateWithNoTime()
					}
				}
				b._setLocalZOrder(c)
			}
		}
	},
	removeChildAtIndex: function(b, c) {
		this.removeChild(this._children[i], c)
	},
	removeAllChildren: function(b) {
		for (var c = this._children, d = 0; d < c.length; d++) {
			c[d].setBatchNode(null)
		}
		cc.Node.prototype.removeAllChildren.call(this, b);
		this.textureAtlas.removeAllQuads()
	},
	disableParticle: function(b) {
		b = this.textureAtlas.quads[b];
		b.br.vertices.x = b.br.vertices.y = b.tr.vertices.x = b.tr.vertices.y = b.tl.vertices.x = b.tl.vertices.y = b.bl.vertices.x = b.bl.vertices.y = 0;
		this.textureAtlas._setDirty(!0)
	},
	getTexture: function() {
		return this.textureAtlas.texture
	},
	setTexture: function(b) {
		this.textureAtlas.texture = b;
		var c = this._blendFunc;
		b && !b.hasPremultipliedAlpha() && c.src === cc.BLEND_SRC && c.dst === cc.BLEND_DST && (c.src = cc.SRC_ALPHA, c.dst = cc.ONE_MINUS_SRC_ALPHA)
	},
	setBlendFunc: function(b, c) {
		void 0 === c ? (this._blendFunc.src = b.src, this._blendFunc.dst = b.dst) : (this._blendFunc.src = b, this._blendFunc.src = c)
	},
	getBlendFunc: function() {
		return new cc.BlendFunc(this._blendFunc.src, this._blendFunc.dst)
	},
	_updateAllAtlasIndexes: function() {
		for (var b = 0, c = this._children, d = 0; d < c.length; d++) {
			var e = c[d];
			e.setAtlasIndex(b);
			b += e.getTotalParticles()
		}
	},
	_increaseAtlasCapacityTo: function(b) {
		cc.log("cocos2d: cc.ParticleBatchNode: resizing TextureAtlas capacity from [" + this.textureAtlas.getCapacity() + "] to [" + b + "].");
		this.textureAtlas.resizeCapacity(b) || cc.log("cc.ParticleBatchNode._increaseAtlasCapacityTo() : WARNING: Not enough memory to resize the atlas")
	},
	_searchNewPositionInChildrenForZ: function(b) {
		for (var c = this._children, d = c.length, e = 0; e < d; e++) {
			if (c[e].zIndex > b) {
				return e
			}
		}
		return d
	},
	_getCurrentIndex: function(b, c) {
		for (var d = !1, e = !1, f = 0, g = 0, h = 0, k = this._children, m = k.length, n = 0; n < m; n++) {
			var p = k[n];
			if (p.zIndex > c && !e && (f = n, e = !0, d && e)) {
				break
			}
			if (b === p && (g = n, d = !0, e || (h = -1), d && e)) {
				break
			}
		}
		e || (f = m);
		return {
			newIndex: f + h,
			oldIndex: g
		}
	},
	_addChildHelper: function(b, c, d) {
		if (!b) {
			throw "cc.ParticleBatchNode._addChildHelper(): child should be non-null"
		}
		if (b.parent) {
			return cc.log("cc.ParticleBatchNode._addChildHelper(): child already added. It can't be added again"), null
		}
		this._children || (this._children = []);
		var e = this._searchNewPositionInChildrenForZ(c);
		this._children.splice(e, 0, b);
		b.tag = d;
		b._setLocalZOrder(c);
		b.parent = this;
		this._running && (b.onEnter(), b.onEnterTransitionDidFinish());
		return e
	},
	_updateBlendFunc: function() {
		this.textureAtlas.texture.hasPremultipliedAlpha() || (this._blendFunc.src = cc.SRC_ALPHA, this._blendFunc.dst = cc.ONE_MINUS_SRC_ALPHA)
	},
	getTextureAtlas: function() {
		return this.textureAtlas
	},
	setTextureAtlas: function(b) {
		this.textureAtlas = b
	}
});
_p = cc.ParticleBatchNode.prototype;
cc.defineGetterSetter(_p, "texture", _p.getTexture, _p.setTexture);
cc.ParticleBatchNode.create = function(b, c) {
	return new cc.ParticleBatchNode(b, c)
};
(function() {
	cc.ParticleBatchNode.CanvasRenderCmd = function(b) {
		cc.Node.CanvasRenderCmd.call(this, b);
		this._needDraw = !1
	};
	var b = cc.ParticleBatchNode.CanvasRenderCmd.prototype = Object.create(cc.Node.CanvasRenderCmd.prototype);
	b.constructor = cc.ParticleBatchNode.CanvasRenderCmd;
	b._initWithTexture = function() {}
})();
(function() {
	cc.ParticleBatchNode.WebGLRenderCmd = function(b) {
		cc.Node.WebGLRenderCmd.call(this, b);
		this._needDraw = !0
	};
	var b = cc.ParticleBatchNode.WebGLRenderCmd.prototype = Object.create(cc.Node.WebGLRenderCmd.prototype);
	b.constructor = cc.ParticleBatchNode.WebGLRenderCmd;
	b.rendering = function(b) {
		b = this._node;
		0 !== b.textureAtlas.totalQuads && (this._shaderProgram.use(), this._shaderProgram._setUniformForMVPMatrixWithMat4(this._stackMatrix), cc.glBlendFuncForParticle(b._blendFunc.src, b._blendFunc.dst), b.textureAtlas.drawQuads())
	};
	b._initWithTexture = function() {
		this._shaderProgram = cc.shaderCache.programForKey(cc.SHADER_POSITION_TEXTURECOLOR)
	};
	b.visit = function(b) {
		if (this._node._visible) {
			var d = cc.current_stack;
			d.stack.push(d.top);
			this._syncStatus(b);
			d.top = this._stackMatrix;
			cc.renderer.pushRenderCommand(this);
			this._dirtyFlag = 0;
			cc.kmGLPopMatrix()
		}
	}
})();
cc._globalFontSize = cc.ITEM_SIZE;
cc._globalFontName = "Arial";
cc._globalFontNameRelease = !1;
cc.MenuItem = cc.Node.extend({
	_enabled: !1,
	_target: null,
	_callback: null,
	_isSelected: !1,
	_className: "MenuItem",
	ctor: function(b, c) {
		var d = cc.Node.prototype;
		d.ctor.call(this);
		this._callback = this._target = null;
		this._enabled = this._isSelected = !1;
		d.setAnchorPoint.call(this, 0.5, 0.5);
		this._target = c || null;
		if (this._callback = b || null) {
			this._enabled = !0
		}
	},
	isSelected: function() {
		return this._isSelected
	},
	setOpacityModifyRGB: function(b) {},
	isOpacityModifyRGB: function() {
		return !1
	},
	setTarget: function(b, c) {
		this._target = c;
		this._callback = b
	},
	isEnabled: function() {
		return this._enabled
	},
	setEnabled: function(b) {
		this._enabled = b
	},
	initWithCallback: function(b, c) {
		this.anchorY = this.anchorX = 0.5;
		this._target = c;
		this._callback = b;
		this._enabled = !0;
		this._isSelected = !1;
		return !0
	},
	rect: function() {
		var b = this._position,
			c = this._contentSize,
			d = this._anchorPoint;
		return cc.rect(b.x - c.width * d.x, b.y - c.height * d.y, c.width, c.height)
	},
	selected: function() {
		this._isSelected = !0
	},
	unselected: function() {
		this._isSelected = !1
	},
	setCallback: function(b, c) {
		this._target = c;
		this._callback = b
	},
	activate: function() {
		if (this._enabled) {
			var b = this._target,
				c = this._callback;
			if (c) {
				if (b && cc.isString(c)) {
					b[c](this)
				} else {
					b && cc.isFunction(c) ? c.call(b, this) : c(this)
				}
			}
		}
	}
});
_p = cc.MenuItem.prototype;
cc.defineGetterSetter(_p, "enabled", _p.isEnabled, _p.setEnabled);
cc.MenuItem.create = function(b, c) {
	return new cc.MenuItem(b, c)
};
cc.MenuItemLabel = cc.MenuItem.extend({
	_disabledColor: null,
	_label: null,
	_originalScale: 0,
	_colorBackup: null,
	ctor: function(b, c, d) {
		cc.MenuItem.prototype.ctor.call(this, c, d);
		this._colorBackup = this._label = this._disabledColor = null;
		b && (this._originalScale = 1, this._colorBackup = cc.color.WHITE, this._disabledColor = cc.color(126, 126, 126), this.setLabel(b), this.cascadeOpacity = this.cascadeColor = !0)
	},
	getDisabledColor: function() {
		return this._disabledColor
	},
	setDisabledColor: function(b) {
		this._disabledColor = b
	},
	getLabel: function() {
		return this._label
	},
	setLabel: function(b) {
		b && (this.addChild(b), b.anchorX = 0, b.anchorY = 0, this.width = b.width, this.height = b.height);
		this._label && this.removeChild(this._label, !0);
		this._label = b
	},
	setEnabled: function(b) {
		if (this._enabled !== b) {
			var c = this._label;
			b ? c.color = this._colorBackup : (this._colorBackup = c.color, c.color = this._disabledColor)
		}
		cc.MenuItem.prototype.setEnabled.call(this, b)
	},
	setOpacity: function(b) {
		this._label.opacity = b
	},
	getOpacity: function() {
		return this._label.opacity
	},
	setColor: function(b) {
		this._label.color = b
	},
	getColor: function() {
		return this._label.color
	},
	initWithLabel: function(b, c, d) {
		this.initWithCallback(c, d);
		this._originalScale = 1;
		this._colorBackup = cc.color.WHITE;
		this._disabledColor = cc.color(126, 126, 126);
		this.setLabel(b);
		return this.cascadeOpacity = this.cascadeColor = !0
	},
	setString: function(b) {
		this._label.string = b;
		this.width = this._label.width;
		this.height = this._label.height
	},
	getString: function() {
		return this._label.string
	},
	activate: function() {
		this._enabled && (this.stopAllActions(), this.scale = this._originalScale, cc.MenuItem.prototype.activate.call(this))
	},
	selected: function() {
		if (this._enabled) {
			cc.MenuItem.prototype.selected.call(this);
			var b = this.getActionByTag(cc.ZOOM_ACTION_TAG);
			b ? this.stopAction(b) : this._originalScale = this.scale;
			b = cc.scaleTo(0.1, 1.2 * this._originalScale);
			b.setTag(cc.ZOOM_ACTION_TAG);
			this.runAction(b)
		}
	},
	unselected: function() {
		if (this._enabled) {
			cc.MenuItem.prototype.unselected.call(this);
			this.stopActionByTag(cc.ZOOM_ACTION_TAG);
			var b = cc.scaleTo(0.1, this._originalScale);
			b.setTag(cc.ZOOM_ACTION_TAG);
			this.runAction(b)
		}
	}
});
_p = cc.MenuItemLabel.prototype;
cc.defineGetterSetter(_p, "string", _p.getString, _p.setString);
cc.defineGetterSetter(_p, "disabledColor", _p.getDisabledColor, _p.setDisabledColor);
cc.defineGetterSetter(_p, "label", _p.getLabel, _p.setLabel);
cc.MenuItemLabel.create = function(b, c, d) {
	return new cc.MenuItemLabel(b, c, d)
};
cc.MenuItemAtlasFont = cc.MenuItemLabel.extend({
	ctor: function(b, c, d, e, f, g, h) {
		var k;
		b && 0 < b.length && (k = new cc.LabelAtlas(b, c, d, e, f));
		cc.MenuItemLabel.prototype.ctor.call(this, k, g, h)
	},
	initWithString: function(b, c, d, e, f, g, h) {
		if (!b || 0 === b.length) {
			throw "cc.MenuItemAtlasFont.initWithString(): value should be non-null and its length should be greater than 0"
		}
		var k = new cc.LabelAtlas;
		k.initWithString(b, c, d, e, f);
		this.initWithLabel(k, g, h);
		return !0
	}
});
cc.MenuItemAtlasFont.create = function(b, c, d, e, f, g, h) {
	return new cc.MenuItemAtlasFont(b, c, d, e, f, g, h)
};
cc.MenuItemFont = cc.MenuItemLabel.extend({
	_fontSize: null,
	_fontName: null,
	ctor: function(b, c, d) {
		var e;
		b && 0 < b.length ? (this._fontName = cc._globalFontName, this._fontSize = cc._globalFontSize, e = new cc.LabelTTF(b, this._fontName, this._fontSize)) : (this._fontSize = 0, this._fontName = "");
		cc.MenuItemLabel.prototype.ctor.call(this, e, c, d)
	},
	initWithString: function(b, c, d) {
		if (!b || 0 === b.length) {
			throw "Value should be non-null and its length should be greater than 0"
		}
		this._fontName = cc._globalFontName;
		this._fontSize = cc._globalFontSize;
		b = new cc.LabelTTF(b, this._fontName, this._fontSize);
		this.initWithLabel(b, c, d);
		return !0
	},
	setFontSize: function(b) {
		this._fontSize = b;
		this._recreateLabel()
	},
	getFontSize: function() {
		return this._fontSize
	},
	setFontName: function(b) {
		this._fontName = b;
		this._recreateLabel()
	},
	getFontName: function() {
		return this._fontName
	},
	_recreateLabel: function() {
		var b = new cc.LabelTTF(this._label.string, this._fontName, this._fontSize);
		this.setLabel(b)
	}
});
cc.MenuItemFont.setFontSize = function(b) {
	cc._globalFontSize = b
};
cc.MenuItemFont.fontSize = function() {
	return cc._globalFontSize
};
cc.MenuItemFont.setFontName = function(b) {
	cc._globalFontNameRelease && (cc._globalFontName = "");
	cc._globalFontName = b;
	cc._globalFontNameRelease = !0
};
_p = cc.MenuItemFont.prototype;
cc.defineGetterSetter(_p, "fontSize", _p.getFontSize, _p.setFontSize);
cc.defineGetterSetter(_p, "fontName", _p.getFontName, _p.setFontName);
cc.MenuItemFont.fontName = function() {
	return cc._globalFontName
};
cc.MenuItemFont.create = function(b, c, d) {
	return new cc.MenuItemFont(b, c, d)
};
cc.MenuItemSprite = cc.MenuItem.extend({
	_normalImage: null,
	_selectedImage: null,
	_disabledImage: null,
	ctor: function(b, c, d, e, f) {
		cc.MenuItem.prototype.ctor.call(this);
		this._disabledImage = this._selectedImage = this._normalImage = null;
		if (void 0 !== c) {
			var g, h, k;
			void 0 !== f ? (g = d, k = e, h = f) : void 0 !== e && cc.isFunction(e) ? (g = d, k = e) : void 0 !== e && cc.isFunction(d) ? (h = e, k = d, g = null) : void 0 === d && (g = null);
			this.initWithNormalSprite(b, c, g, k, h)
		}
	},
	getNormalImage: function() {
		return this._normalImage
	},
	setNormalImage: function(b) {
		this._normalImage !== b && (b && (this.addChild(b, 0, cc.NORMAL_TAG), b.anchorX = 0, b.anchorY = 0), this._normalImage && this.removeChild(this._normalImage, !0), this._normalImage = b, this.width = this._normalImage.width, this.height = this._normalImage.height, this._updateImagesVisibility(), b.textureLoaded && !b.textureLoaded() && b.addEventListener("load", function(b) {
			this.width = b.width;
			this.height = b.height
		}, this))
	},
	getSelectedImage: function() {
		return this._selectedImage
	},
	setSelectedImage: function(b) {
		this._selectedImage !== b && (b && (this.addChild(b, 0, cc.SELECTED_TAG), b.anchorX = 0, b.anchorY = 0), this._selectedImage && this.removeChild(this._selectedImage, !0), this._selectedImage = b, this._updateImagesVisibility())
	},
	getDisabledImage: function() {
		return this._disabledImage
	},
	setDisabledImage: function(b) {
		this._disabledImage !== b && (b && (this.addChild(b, 0, cc.DISABLE_TAG), b.anchorX = 0, b.anchorY = 0), this._disabledImage && this.removeChild(this._disabledImage, !0), this._disabledImage = b, this._updateImagesVisibility())
	},
	initWithNormalSprite: function(b, c, d, e, f) {
		this.initWithCallback(e, f);
		this.setNormalImage(b);
		this.setSelectedImage(c);
		this.setDisabledImage(d);
		if (b = this._normalImage) {
			this.width = b.width, this.height = b.height, b.textureLoaded && !b.textureLoaded() && b.addEventListener("load", function(b) {
				this.width = b.width;
				this.height = b.height;
				this.cascadeOpacity = this.cascadeColor = !0
			}, this)
		}
		return this.cascadeOpacity = this.cascadeColor = !0
	},
	setColor: function(b) {
		this._normalImage.color = b;
		this._selectedImage && (this._selectedImage.color = b);
		this._disabledImage && (this._disabledImage.color = b)
	},
	getColor: function() {
		return this._normalImage.color
	},
	setOpacity: function(b) {
		this._normalImage.opacity = b;
		this._selectedImage && (this._selectedImage.opacity = b);
		this._disabledImage && (this._disabledImage.opacity = b)
	},
	getOpacity: function() {
		return this._normalImage.opacity
	},
	selected: function() {
		cc.MenuItem.prototype.selected.call(this);
		this._normalImage && (this._disabledImage && (this._disabledImage.visible = !1), this._selectedImage ? (this._normalImage.visible = !1, this._selectedImage.visible = !0) : this._normalImage.visible = !0)
	},
	unselected: function() {
		cc.MenuItem.prototype.unselected.call(this);
		this._normalImage && (this._normalImage.visible = !0, this._selectedImage && (this._selectedImage.visible = !1), this._disabledImage && (this._disabledImage.visible = !1))
	},
	setEnabled: function(b) {
		this._enabled !== b && (cc.MenuItem.prototype.setEnabled.call(this, b), this._updateImagesVisibility())
	},
	_updateImagesVisibility: function() {
		var b = this._normalImage,
			c = this._selectedImage,
			d = this._disabledImage;
		this._enabled ? (b && (b.visible = !0), c && (c.visible = !1), d && (d.visible = !1)) : d ? (b && (b.visible = !1), c && (c.visible = !1), d && (d.visible = !0)) : (b && (b.visible = !0), c && (c.visible = !1))
	}
});
_p = cc.MenuItemSprite.prototype;
cc.defineGetterSetter(_p, "normalImage", _p.getNormalImage, _p.setNormalImage);
cc.defineGetterSetter(_p, "selectedImage", _p.getSelectedImage, _p.setSelectedImage);
cc.defineGetterSetter(_p, "disabledImage", _p.getDisabledImage, _p.setDisabledImage);
cc.MenuItemSprite.create = function(b, c, d, e, f) {
	return new cc.MenuItemSprite(b, c, d, e, f || void 0)
};
cc.MenuItemImage = cc.MenuItemSprite.extend({
	ctor: function(b, c, d, e, f) {
		var g = null,
			h = null,
			k = null,
			m = null,
			n = null;
		void 0 === b ? cc.MenuItemSprite.prototype.ctor.call(this) : (g = new cc.Sprite(b), c && (h = new cc.Sprite(c)), void 0 === e ? m = d : void 0 === f ? (m = d, n = e) : f && (k = new cc.Sprite(d), m = e, n = f), cc.MenuItemSprite.prototype.ctor.call(this, g, h, k, m, n))
	},
	setNormalSpriteFrame: function(b) {
		this.setNormalImage(new cc.Sprite(b))
	},
	setSelectedSpriteFrame: function(b) {
		this.setSelectedImage(new cc.Sprite(b))
	},
	setDisabledSpriteFrame: function(b) {
		this.setDisabledImage(new cc.Sprite(b))
	},
	initWithNormalImage: function(b, c, d, e, f) {
		var g = null,
			h = null,
			k = null;
		b && (g = new cc.Sprite(b));
		c && (h = new cc.Sprite(c));
		d && (k = new cc.Sprite(d));
		return this.initWithNormalSprite(g, h, k, e, f)
	}
});
cc.MenuItemImage.create = function(b, c, d, e, f) {
	return new cc.MenuItemImage(b, c, d, e, f)
};
cc.MenuItemToggle = cc.MenuItem.extend({
	subItems: null,
	_selectedIndex: 0,
	_opacity: null,
	_color: null,
	ctor: function() {
		cc.MenuItem.prototype.ctor.call(this);
		this._selectedIndex = 0;
		this.subItems = [];
		this._opacity = 0;
		this._color = cc.color.WHITE;
		0 < arguments.length && this.initWithItems(Array.prototype.slice.apply(arguments))
	},
	getOpacity: function() {
		return this._opacity
	},
	setOpacity: function(b) {
		this._opacity = b;
		if (this.subItems && 0 < this.subItems.length) {
			for (var c = 0; c < this.subItems.length; c++) {
				this.subItems[c].opacity = b
			}
		}
		this._color.a = b
	},
	getColor: function() {
		var b = this._color;
		return cc.color(b.r, b.g, b.b, b.a)
	},
	setColor: function(b) {
		var c = this._color;
		c.r = b.r;
		c.g = b.g;
		c.b = b.b;
		if (this.subItems && 0 < this.subItems.length) {
			for (c = 0; c < this.subItems.length; c++) {
				this.subItems[c].setColor(b)
			}
		}
		void 0 === b.a || b.a_undefined || this.setOpacity(b.a)
	},
	getSelectedIndex: function() {
		return this._selectedIndex
	},
	setSelectedIndex: function(b) {
		if (b !== this._selectedIndex) {
			this._selectedIndex = b;
			(b = this.getChildByTag(cc.CURRENT_ITEM)) && b.removeFromParent(!1);
			b = this.subItems[this._selectedIndex];
			this.addChild(b, 0, cc.CURRENT_ITEM);
			var c = b.width,
				d = b.height;
			this.width = c;
			this.height = d;
			b.setPosition(c / 2, d / 2)
		}
	},
	getSubItems: function() {
		return this.subItems
	},
	setSubItems: function(b) {
		this.subItems = b
	},
	initWithItems: function(b) {
		var c = b.length;
		cc.isFunction(b[b.length - 2]) ? (this.initWithCallback(b[b.length - 2], b[b.length - 1]), c -= 2) : cc.isFunction(b[b.length - 1]) ? (this.initWithCallback(b[b.length - 1], null), c -= 1) : this.initWithCallback(null, null);
		for (var d = this.subItems, e = d.length = 0; e < c; e++) {
			b[e] && d.push(b[e])
		}
		this._selectedIndex = cc.UINT_MAX;
		this.setSelectedIndex(0);
		return this.cascadeOpacity = this.cascadeColor = !0
	},
	addSubItem: function(b) {
		this.subItems.push(b)
	},
	activate: function() {
		this._enabled && this.setSelectedIndex((this._selectedIndex + 1) % this.subItems.length);
		cc.MenuItem.prototype.activate.call(this)
	},
	selected: function() {
		cc.MenuItem.prototype.selected.call(this);
		this.subItems[this._selectedIndex].selected()
	},
	unselected: function() {
		cc.MenuItem.prototype.unselected.call(this);
		this.subItems[this._selectedIndex].unselected()
	},
	setEnabled: function(b) {
		if (this._enabled !== b) {
			cc.MenuItem.prototype.setEnabled.call(this, b);
			var c = this.subItems;
			if (c && 0 < c.length) {
				for (var d = 0; d < c.length; d++) {
					c[d].enabled = b
				}
			}
		}
	},
	selectedItem: function() {
		return this.subItems[this._selectedIndex]
	},
	getSelectedItem: function() {
		return this.subItems[this._selectedIndex]
	},
	onEnter: function() {
		cc.Node.prototype.onEnter.call(this);
		this.setSelectedIndex(this._selectedIndex)
	}
});
_p = cc.MenuItemToggle.prototype;
cc.defineGetterSetter(_p, "selectedIndex", _p.getSelectedIndex, _p.setSelectedIndex);
cc.MenuItemToggle.create = function() {
	0 < arguments.length && null == arguments[arguments.length - 1] && cc.log("parameters should not be ending with null in Javascript");
	var b = new cc.MenuItemToggle;
	b.initWithItems(Array.prototype.slice.apply(arguments));
	return b
};
cc.MENU_STATE_WAITING = 0;
cc.MENU_STATE_TRACKING_TOUCH = 1;
cc.MENU_HANDLER_PRIORITY = -128;
cc.DEFAULT_PADDING = 5;
cc.Menu = cc.Layer.extend({
	enabled: !1,
	_selectedItem: null,
	_state: -1,
	_touchListener: null,
	_className: "Menu",
	ctor: function(b) {
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
		0 < arguments.length && null == arguments[arguments.length - 1] && cc.log("parameters should not be ending with null in Javascript");
		var c = arguments.length,
			d;
		if (0 === c) {
			d = []
		} else {
			if (1 === c) {
				d = b instanceof Array ? b : [b]
			} else {
				if (1 < c) {
					d = [];
					for (var e = 0; e < c; e++) {
						arguments[e] && d.push(arguments[e])
					}
				}
			}
		}
		this.initWithArray(d)
	},
	onEnter: function() {
		var b = this._touchListener;
		b._isRegistered() || cc.eventManager.addListener(b, this);
		cc.Node.prototype.onEnter.call(this)
	},
	isEnabled: function() {
		return this.enabled
	},
	setEnabled: function(b) {
		this.enabled = b
	},
	initWithItems: function(b) {
		var c = [];
		if (b) {
			for (var d = 0; d < b.length; d++) {
				b[d] && c.push(b[d])
			}
		}
		return this.initWithArray(c)
	},
	initWithArray: function(b) {
		if (cc.Layer.prototype.init.call(this)) {
			this.enabled = !0;
			var c = cc.winSize;
			this.setPosition(c.width / 2, c.height / 2);
			this.setContentSize(c);
			this.setAnchorPoint(0.5, 0.5);
			this.ignoreAnchorPointForPosition(!0);
			if (b) {
				for (c = 0; c < b.length; c++) {
					this.addChild(b[c], c)
				}
			}
			this._selectedItem = null;
			this._state = cc.MENU_STATE_WAITING;
			return this.cascadeOpacity = this.cascadeColor = !0
		}
		return !1
	},
	addChild: function(b, c, d) {
		if (!(b instanceof cc.MenuItem)) {
			throw "cc.Menu.addChild() : Menu only supports MenuItem objects as children"
		}
		cc.Layer.prototype.addChild.call(this, b, c, d)
	},
	alignItemsVertically: function() {
		this.alignItemsVerticallyWithPadding(cc.DEFAULT_PADDING)
	},
	alignItemsVerticallyWithPadding: function(b) {
		var c = -b,
			d = this._children,
			e, f, g, h;
		if (d && 0 < d.length) {
			f = 0;
			for (e = d.length; f < e; f++) {
				c += d[f].height * d[f].scaleY + b
			}
			var k = c / 2;
			f = 0;
			for (e = d.length; f < e; f++) {
				h = d[f], g = h.height, c = h.scaleY, h.setPosition(0, k - g * c / 2), k -= g * c + b
			}
		}
	},
	alignItemsHorizontally: function() {
		this.alignItemsHorizontallyWithPadding(cc.DEFAULT_PADDING)
	},
	alignItemsHorizontallyWithPadding: function(b) {
		var c = -b,
			d = this._children,
			e, f, g, h;
		if (d && 0 < d.length) {
			e = 0;
			for (f = d.length; e < f; e++) {
				c += d[e].width * d[e].scaleX + b
			}
			var k = -c / 2;
			e = 0;
			for (f = d.length; e < f; e++) {
				h = d[e], c = h.scaleX, g = d[e].width, h.setPosition(k + g * c / 2, 0), k += g * c + b
			}
		}
	},
	alignItemsInColumns: function() {
		0 < arguments.length && null == arguments[arguments.length - 1] && cc.log("parameters should not be ending with null in Javascript");
		for (var b = [], c = 0; c < arguments.length; c++) {
			b.push(arguments[c])
		}
		var d = -5,
			e = 0,
			f = 0,
			g = 0,
			h, k, m, n = this._children;
		if (n && 0 < n.length) {
			for (c = 0, m = n.length; c < m; c++) {
				e >= b.length || !(h = b[e]) || (k = n[c].height, f = f >= k || isNaN(k) ? f : k, ++g, g >= h && (d += f + 5, f = g = 0, ++e))
			}
		}
		var p = cc.director.getWinSize(),
			r = h = f = e = 0,
			t = 0,
			d = d / 2;
		if (n && 0 < n.length) {
			for (c = 0, m = n.length; c < m; c++) {
				var s = n[c];
				0 === h && (h = b[e], t = r = p.width / (1 + h));
				k = s._getHeight();
				f = f >= k || isNaN(k) ? f : k;
				s.setPosition(t - p.width / 2, d - k / 2);
				t += r;
				++g;
				g >= h && (d -= f + 5, f = h = g = 0, ++e)
			}
		}
	},
	alignItemsInRows: function() {
		0 < arguments.length && null == arguments[arguments.length - 1] && cc.log("parameters should not be ending with null in Javascript");
		var b = [],
			c;
		for (c = 0; c < arguments.length; c++) {
			b.push(arguments[c])
		}
		var d = [],
			e = [],
			f = -10,
			g = -5,
			h = 0,
			k = 0,
			m = 0,
			n, p, r, t, s = this._children;
		if (s && 0 < s.length) {
			for (c = 0, r = s.length; c < r; c++) {
				(p = s[c], h >= b.length || !(n = b[h])) || (t = p.width, k = k >= t || isNaN(t) ? k : t, g += p.height + 5, ++m, m >= n && (d.push(k), e.push(g), f += k + 10, k = m = 0, g = -5, ++h))
			}
		}
		g = cc.director.getWinSize();
		n = k = h = 0;
		var f = -f / 2,
			v = 0;
		if (s && 0 < s.length) {
			for (c = 0, r = s.length; c < r; c++) {
				p = s[c], 0 === n && (n = b[h], v = e[h]), t = p._getWidth(), k = k >= t || isNaN(t) ? k : t, p.setPosition(f + d[h] / 2, v - g.height / 2), v -= p.height + 10, ++m, m >= n && (f += k + 5, k = n = m = 0, ++h)
			}
		}
	},
	removeChild: function(b, c) {
		null != b && (b instanceof cc.MenuItem ? (this._selectedItem === b && (this._selectedItem = null), cc.Node.prototype.removeChild.call(this, b, c)) : cc.log("cc.Menu.removeChild():Menu only supports MenuItem objects as children"))
	},
	_onTouchBegan: function(b, c) {
		var d = c.getCurrentTarget();
		if (d._state !== cc.MENU_STATE_WAITING || !d._visible || !d.enabled) {
			return !1
		}
		for (var e = d.parent; null != e; e = e.parent) {
			if (!e.isVisible()) {
				return !1
			}
		}
		d._selectedItem = d._itemForTouch(b);
		return d._selectedItem ? (d._state = cc.MENU_STATE_TRACKING_TOUCH, d._selectedItem.selected(), d._selectedItem.setNodeDirty(), !0) : !1
	},
	_onTouchEnded: function(b, c) {
		var d = c.getCurrentTarget();
		d._state !== cc.MENU_STATE_TRACKING_TOUCH ? cc.log("cc.Menu.onTouchEnded(): invalid state") : (d._selectedItem && (d._selectedItem.unselected(), d._selectedItem.setNodeDirty(), d._selectedItem.activate()), d._state = cc.MENU_STATE_WAITING)
	},
	_onTouchCancelled: function(b, c) {
		var d = c.getCurrentTarget();
		d._state !== cc.MENU_STATE_TRACKING_TOUCH ? cc.log("cc.Menu.onTouchCancelled(): invalid state") : (this._selectedItem && (d._selectedItem.unselected(), d._selectedItem.setNodeDirty()), d._state = cc.MENU_STATE_WAITING)
	},
	_onTouchMoved: function(b, c) {
		var d = c.getCurrentTarget();
		if (d._state !== cc.MENU_STATE_TRACKING_TOUCH) {
			cc.log("cc.Menu.onTouchMoved(): invalid state")
		} else {
			var e = d._itemForTouch(b);
			e !== d._selectedItem && (d._selectedItem && (d._selectedItem.unselected(), d._selectedItem.setNodeDirty()), d._selectedItem = e, d._selectedItem && (d._selectedItem.selected(), d._selectedItem.setNodeDirty()))
		}
	},
	onExit: function() {
		this._state === cc.MENU_STATE_TRACKING_TOUCH && (this._selectedItem && (this._selectedItem.unselected(), this._selectedItem = null), this._state = cc.MENU_STATE_WAITING);
		cc.Node.prototype.onExit.call(this)
	},
	setOpacityModifyRGB: function(b) {},
	isOpacityModifyRGB: function() {
		return !1
	},
	_itemForTouch: function(b) {
		b = b.getLocation();
		var c = this._children,
			d;
		if (c && 0 < c.length) {
			for (var e = c.length - 1; 0 <= e; e--) {
				if (d = c[e], d.isVisible() && d.isEnabled()) {
					var f = d.convertToNodeSpace(b),
						g = d.rect();
					g.x = 0;
					g.y = 0;
					if (cc.rectContainsPoint(g, f)) {
						return d
					}
				}
			}
		}
		return null
	}
});
_p = cc.Menu.prototype;
cc.Menu.create = function(b) {
	var c = arguments.length;
	0 < c && null == arguments[c - 1] && cc.log("parameters should not be ending with null in Javascript");
	return 0 === c ? new cc.Menu : 1 === c ? new cc.Menu(b) : new cc.Menu(Array.prototype.slice.call(arguments, 0))
};
(function() {
	var b = cc.sys,
		c = {
			common: {
				multichannel: !0,
				webAudio: cc.sys._supportWebAudio,
				auto: !0
			}
		};
	c[b.BROWSER_TYPE_IE] = {
		multichannel: !0,
		webAudio: cc.sys._supportWebAudio,
		auto: !0,
		emptied: !0
	};
	c[b.BROWSER_TYPE_ANDROID] = {
		multichannel: !1,
		webAudio: !1,
		auto: !1
	};
	c[b.BROWSER_TYPE_CHROME] = {
		multichannel: !0,
		webAudio: !0,
		auto: !1
	};
	c[b.BROWSER_TYPE_FIREFOX] = {
		multichannel: !0,
		webAudio: !0,
		auto: !0,
		delay: !0
	};
	c[b.BROWSER_TYPE_UC] = {
		multichannel: !0,
		webAudio: !1,
		auto: !1
	};
	c[b.BROWSER_TYPE_QQ] = {
		multichannel: !1,
		webAudio: !1,
		auto: !0
	};
	c[b.BROWSER_TYPE_OUPENG] = {
		multichannel: !1,
		webAudio: !1,
		auto: !1,
		replay: !0,
		emptied: !0
	};
	c[b.BROWSER_TYPE_WECHAT] = {
		multichannel: !1,
		webAudio: !1,
		auto: !1,
		replay: !0,
		emptied: !0
	};
	c[b.BROWSER_TYPE_360] = {
		multichannel: !1,
		webAudio: !1,
		auto: !0
	};
	c[b.BROWSER_TYPE_MIUI] = {
		multichannel: !1,
		webAudio: !1,
		auto: !0
	};
	c[b.BROWSER_TYPE_LIEBAO] = {
		multichannel: !1,
		webAudio: !1,
		auto: !1,
		replay: !0,
		emptied: !0
	};
	c[b.BROWSER_TYPE_SOUGOU] = {
		multichannel: !1,
		webAudio: !1,
		auto: !1,
		replay: !0,
		emptied: !0
	};
	c[b.BROWSER_TYPE_BAIDU] = {
		multichannel: !1,
		webAudio: !1,
		auto: !1,
		replay: !0,
		emptied: !0
	};
	c[b.BROWSER_TYPE_BAIDU_APP] = {
		multichannel: !1,
		webAudio: !1,
		auto: !1,
		replay: !0,
		emptied: !0
	};
	c[b.BROWSER_TYPE_SAFARI] = {
		multichannel: !0,
		webAudio: !0,
		auto: !1,
		webAudioCallback: function(b) {
			document.createElement("audio").src = b
		}
	};
	var d, e;
	try {
		var f = navigator.userAgent.toLowerCase();
		switch (b.browserType) {
		case b.BROWSER_TYPE_IE:
			e = f.match(/(msie |rv:)([\d.]+)/);
			break;
		case b.BROWSER_TYPE_FIREFOX:
			e = f.match(/(firefox\/|rv:)([\d.]+)/);
			break;
		case b.BROWSER_TYPE_CHROME:
			e = f.match(/chrome\/([\d.]+)/);
			break;
		case b.BROWSER_TYPE_BAIDU:
			e = f.match(/baidubrowser\/([\d.]+)/);
			break;
		case b.BROWSER_TYPE_UC:
			e = f.match(/ucbrowser\/([\d.]+)/);
			break;
		case b.BROWSER_TYPE_QQ:
			e = f.match(/qqbrowser\/([\d.]+)/);
			break;
		case b.BROWSER_TYPE_OUPENG:
			e = f.match(/oupeng\/([\d.]+)/);
			break;
		case b.BROWSER_TYPE_WECHAT:
			e = f.match(/micromessenger\/([\d.]+)/);
			break;
		case b.BROWSER_TYPE_SAFARI:
			e = f.match(/safari\/([\d.]+)/);
			break;
		case b.BROWSER_TYPE_MIUI:
			e = f.match(/miuibrowser\/([\d.]+)/)
		}
		d = e ? e[1] : ""
	} catch (g) {
		console.log(g)
	}
	if (d) {
		switch (b.browserType) {
		case b.BROWSER_TYPE_CHROME:
			30 > parseInt(d) && (c[b.BROWSER_TYPE_CHROME] = {
				multichannel: !1,
				webAudio: !0,
				auto: !1
			});
			break;
		case b.BROWSER_TYPE_MIUI:
			if (d = d.match(/\d+/g), 2 > d[0] || 2 === d[0] && 0 === d[1] && 1 >= d[2]) {
				c[b.BROWSER_TYPE_MIUI].auto = !1
			}
		}
	}
	if (cc.sys.isMobile) {
		cc.__audioSupport = cc.sys.os !== cc.sys.OS_IOS ? c[b.browserType] || c.common : c[b.BROWSER_TYPE_SAFARI]
	} else {
		switch (b.browserType) {
		case b.BROWSER_TYPE_IE:
			cc.__audioSupport = c[b.BROWSER_TYPE_IE];
			break;
		case b.BROWSER_TYPE_FIREFOX:
			cc.__audioSupport = c[b.BROWSER_TYPE_FIREFOX];
			break;
		default:
			cc.__audioSupport = c.common
		}
	}
})();
cc.Audio = cc.Class.extend({
	volume: 1,
	loop: !1,
	src: null,
	_touch: !1,
	_playing: !1,
	_AUDIO_TYPE: "AUDIO",
	_pause: !1,
	_buffer: null,
	_currentSource: null,
	_startTime: null,
	_currentTime: null,
	_context: null,
	_volume: null,
	_ignoreEnded: !1,
	_element: null,
	ctor: function(b, c, d) {
		b && (this._context = b);
		c && (this._volume = c);
		b && c && (this._AUDIO_TYPE = "WEBAUDIO");
		this.src = d
	},
	_setBufferCallback: null,
	setBuffer: function(b) {
		if (b) {
			var c = this._playing;
			this._AUDIO_TYPE = "WEBAUDIO";
			this._buffer && this._buffer !== b && this.getPlaying() && this.stop();
			this._buffer = b;
			c && this.play();
			this._volume.gain.value = this.volume;
			this._setBufferCallback && this._setBufferCallback(b)
		}
	},
	_setElementCallback: null,
	setElement: function(b) {
		if (b) {
			var c = this._playing;
			this._AUDIO_TYPE = "AUDIO";
			this._element && this._element !== b && this.getPlaying() && this.stop();
			this._element = b;
			c && this.play();
			b.volume = this.volume;
			b.loop = this.loop;
			this._setElementCallback && this._setElementCallback(b)
		}
	},
	play: function(b, c) {
		this._playing = !0;
		this.loop = void 0 === c ? this.loop : c;
		"AUDIO" === this._AUDIO_TYPE ? this._playOfAudio(b) : this._playOfWebAudio(b)
	},
	getPlaying: function() {
		if (!this._playing) {
			return this._playing
		}
		if ("AUDIO" === this._AUDIO_TYPE) {
			var b = this._element;
			return !b || this._pause || b.ended ? this._playing = !1 : !0
		}
		return (b = this._currentSource) ? null == b.playbackState ? this._playing : this._currentTime + this._context.currentTime - this._startTime < this._currentSource.buffer.duration : !0
	},
	_playOfWebAudio: function(b) {
		var c = this._currentSource;
		if (this._buffer) {
			if (!this._pause && c) {
				if (0 === this._context.currentTime || this._currentTime + this._context.currentTime - this._startTime > this._currentSource.buffer.duration) {
					this._stopOfWebAudio()
				} else {
					return
				}
			}
			c = this._context.createBufferSource();
			c.buffer = this._buffer;
			c.connect(this._volume);
			c.loop = this.loop;
			this._startTime = this._context.currentTime;
			this._currentTime = b || 0;
			if (c.start) {
				c.start(0, b || 0)
			} else {
				if (c.noteGrainOn) {
					var d = c.buffer.duration;
					this.loop ? c.noteGrainOn(0, b, d) : c.noteGrainOn(0, b, d - b)
				} else {
					c.noteOn(0)
				}
			}
			this._currentSource = c;
			var e = this;
			c.onended = function() {
				e._ignoreEnded ? e._ignoreEnded = !1 : e._playing = !1
			}
		}
	},
	_playOfAudio: function() {
		var b = this._element;
		b && (b.loop = this.loop, b.play())
	},
	stop: function() {
		this._playing = !1;
		"AUDIO" === this._AUDIO_TYPE ? this._stopOfAudio() : this._stopOfWebAudio()
	},
	_stopOfWebAudio: function() {
		var b = this._currentSource;
		this._ignoreEnded = !0;
		b && (b.stop(0), this._currentSource = null)
	},
	_stopOfAudio: function() {
		var b = this._element;
		b && (b.pause(), b.duration && Infinity !== b.duration && (b.currentTime = 0))
	},
	pause: function() {
		!1 !== this.getPlaying() && (this._playing = !1, this._pause = !0, "AUDIO" === this._AUDIO_TYPE ? this._pauseOfAudio() : this._pauseOfWebAudio())
	},
	_pauseOfWebAudio: function() {
		this._currentTime += this._context.currentTime - this._startTime;
		var b = this._currentSource;
		b && b.stop(0)
	},
	_pauseOfAudio: function() {
		var b = this._element;
		b && b.pause()
	},
	resume: function() {
		this._pause && ("AUDIO" === this._AUDIO_TYPE ? this._resumeOfAudio() : this._resumeOfWebAudio(), this._pause = !1, this._playing = !0)
	},
	_resumeOfWebAudio: function() {
		var b = this._currentSource;
		b && (this._startTime = this._context.currentTime, this._playOfWebAudio(this._currentTime % b.buffer.duration))
	},
	_resumeOfAudio: function() {
		var b = this._element;
		b && b.play()
	},
	setVolume: function(b) {
		1 < b && (b = 1);
		0 > b && (b = 0);
		this.volume = b;
		"AUDIO" === this._AUDIO_TYPE ? this._element && (this._element.volume = b) : this._volume && (this._volume.gain.value = b)
	},
	getVolume: function() {
		return this.volume
	},
	cloneNode: function() {
		var b, c;
		if ("AUDIO" === this._AUDIO_TYPE) {
			b = new cc.Audio;
			var d = document.createElement("audio");
			d.src = this.src;
			b.setElement(d)
		} else {
			d = this._context.createGain(), d.gain.value = 1, d.connect(this._context.destination), b = new cc.Audio(this._context, d, this.src), this._buffer ? b.setBuffer(this._buffer) : (c = this, this._setBufferCallback = function(d) {
				b.setBuffer(d);
				c._setBufferCallback = null
			})
		}
		b._AUDIO_TYPE = this._AUDIO_TYPE;
		return b
	}
});
(function(b) {
	var c = b.webAudio,
		d = b.multichannel,
		e = b.auto,
		f = [];
	(function() {
		var b = document.createElement("audio");
		if (b.canPlayType) {
			var c = b.canPlayType('audio/ogg; codecs="vorbis"');
			c && "" !== c && f.push(".ogg");
			(c = b.canPlayType("audio/mpeg")) && "" !== c && f.push(".mp3");
			(c = b.canPlayType('audio/wav; codecs="1"')) && "" !== c && f.push(".wav");
			(c = b.canPlayType("audio/mp4")) && "" !== c && f.push(".mp4");
			(b = b.canPlayType("audio/x-m4a")) && "" !== b && f.push(".m4a")
		}
	})();
	try {
		if (c) {
			var g = new(window.AudioContext || window.webkitAudioContext || window.mozAudioContext);
			b.delay && setTimeout(function() {
				g = new(window.AudioContext || window.webkitAudioContext || window.mozAudioContext)
			}, 0)
		}
	} catch (h) {
		c = !1, cc.log("browser don't support webAudio")
	}
	var k = {
		cache: {},
		load: function(b, d, e, h) {
			if (0 === f.length) {
				return h("can not support audio!")
			}
			var m = cc.path.extname(b),
				v = [m];
			for (e = 0; e < f.length; e++) {
				m !== f[e] && v.push(f[e])
			}
			var u;
			if (k.cache[d]) {
				return h(null, k.cache[d])
			}
			if (c) {
				try {
					var A = g.createGain();
					A.gain.value = 1;
					A.connect(g.destination);
					u = new cc.Audio(g, A, b)
				} catch (y) {
					c = !1, cc.log("browser don't support webAudio"), u = new cc.Audio(null, null, b)
				}
			} else {
				u = new cc.Audio(null, null, b)
			}
			this.loadAudioFromExtList(b, v, u, h);
			k.cache[d] = u
		},
		loadAudioFromExtList: function(d, e, h, m) {
			if (0 === e.length) {
				var s = "can not found the resource of audio! Last match url is : ",
					s = s + d.replace(/\.(.*)?$/, "(");
				f.forEach(function(b) {
					s += b + "|"
				});
				s = s.replace(/\|$/, ")");
				return m(s)
			}
			d = cc.path.changeExtname(d, e.splice(0, 1));
			if (c) {
				b.webAudioCallback && b.webAudioCallback(d);
				var v = new XMLHttpRequest;
				v.open("GET", d, !0);
				v.responseType = "arraybuffer";
				v.onload = function() {
					g.decodeAudioData(v.response, function(b) {
						h.setBuffer(b);
						m(null, h)
					}, function() {
						k.loadAudioFromExtList(d, e, h, m)
					})
				};
				v.send()
			} else {
				var u = document.createElement("audio"),
					A = !1,
					y = !1,
					E = setTimeout(function() {
						0 === u.readyState ? x() : (y = !0, u.pause(), document.body.removeChild(u), m("audio load timeout : " + d, h))
					}, 10000),
					F = function() {
						if (!A) {
							u.pause();
							try {
								u.currentTime = 0, u.volume = 1
							} catch (b) {}
							document.body.removeChild(u);
							h.setElement(u);
							u.removeEventListener("canplaythrough", F, !1);
							u.removeEventListener("error", B, !1);
							u.removeEventListener("emptied", x, !1);
							!y && m(null, h);
							A = !0;
							clearTimeout(E)
						}
					},
					B = function() {
						A && (u.pause(), document.body.removeChild(u), u.removeEventListener("canplaythrough", F, !1), u.removeEventListener("error", B, !1), u.removeEventListener("emptied", x, !1), !y && k.loadAudioFromExtList(d, e, h, m), A = !0, clearTimeout(E))
					},
					x = function() {
						y = !0;
						F();
						m(null, h)
					};
				cc._addEventListener(u, "canplaythrough", F, !1);
				cc._addEventListener(u, "error", B, !1);
				b.emptied && cc._addEventListener(u, "emptied", x, !1);
				u.src = d;
				document.body.appendChild(u);
				u.volume = 0;
				u.play()
			}
		}
	};
	cc.loader.register(["mp3", "ogg", "wav", "mp4", "m4a"], k);
	cc.audioEngine = {
		_currMusic: null,
		_musicVolume: 1,
		willPlayMusic: function() {
			return !1
		},
		playMusic: function(b, c) {
			var d = this._currMusic;
			d && d.src !== b && d.getPlaying() && d.stop();
			d = k.cache[b];
			d || (cc.loader.load(b), d = k.cache[b]);
			d.play(0, c);
			d.setVolume(this._musicVolume);
			this._currMusic = d
		},
		stopMusic: function(b) {
			var c = this._currMusic;
			c && (c.stop(), b && cc.loader.release(c.src))
		},
		pauseMusic: function() {
			var b = this._currMusic;
			b && b.pause()
		},
		resumeMusic: function() {
			var b = this._currMusic;
			b && b.resume()
		},
		rewindMusic: function() {
			var b = this._currMusic;
			b && (b.stop(), b.play())
		},
		getMusicVolume: function() {
			return this._musicVolume
		},
		setMusicVolume: function(b) {
			b -= 0;
			isNaN(b) && (b = 1);
			1 < b && (b = 1);
			0 > b && (b = 0);
			this._musicVolume = b;
			var c = this._currMusic;
			c && c.setVolume(b)
		},
		isMusicPlaying: function() {
			var b = this._currMusic;
			return b ? b.getPlaying() : !1
		},
		_audioPool: {},
		_maxAudioInstance: 5,
		_effectVolume: 1,
		playEffect: function(b, e) {
			if (!d) {
				return null
			}
			var f = this._audioPool[b];
			f || (f = this._audioPool[b] = []);
			var g;
			for (g = 0; g < f.length && f[g].getPlaying(); g++) {}
			if (f[g]) {
				h = f[g], h.setVolume(this._effectVolume), h.play(0, e)
			} else {
				if (!c && g > this._maxAudioInstance) {
					cc.log("Error: %s greater than %d", b, this._maxAudioInstance)
				} else {
					var h = k.cache[b];
					h || (cc.loader.load(b), h = k.cache[b]);
					h = h.cloneNode();
					h.setVolume(this._effectVolume);
					h.loop = e || !1;
					h.play();
					f.push(h)
				}
			}
			return h
		},
		setEffectsVolume: function(b) {
			b -= 0;
			isNaN(b) && (b = 1);
			1 < b && (b = 1);
			0 > b && (b = 0);
			this._effectVolume = b;
			var c = this._audioPool,
				d;
			for (d in c) {
				var e = c[d];
				if (Array.isArray(e)) {
					for (var f = 0; f < e.length; f++) {
						e[f].setVolume(b)
					}
				}
			}
		},
		getEffectsVolume: function() {
			return this._effectVolume
		},
		pauseEffect: function(b) {
			b && b.pause()
		},
		pauseAllEffects: function() {
			var b = this._audioPool,
				c;
			for (c in b) {
				for (var d = b[c], e = 0; e < b[c].length; e++) {
					d[e].getPlaying() && d[e].pause()
				}
			}
		},
		resumeEffect: function(b) {
			b && b.resume()
		},
		resumeAllEffects: function() {
			var b = this._audioPool,
				c;
			for (c in b) {
				for (var d = b[c], e = 0; e < b[c].length; e++) {
					d[e].resume()
				}
			}
		},
		stopEffect: function(b) {
			b && b.stop()
		},
		stopAllEffects: function() {
			var b = this._audioPool,
				c;
			for (c in b) {
				for (var d = b[c], e = 0; e < b[c].length; e++) {
					d[e].stop()
				}
			}
		},
		unloadEffect: function(b) {
			if (b) {
				cc.loader.release(b);
				var c = this._audioPool[b];
				c && (c.length = 0);
				delete this._audioPool[b];
				delete k.cache[b]
			}
		},
		end: function() {
			this.stopMusic();
			this.stopAllEffects()
		},
		_pauseCache: [],
		_pausePlaying: function() {
			var b = this._currMusic;
			b && b.getPlaying() && (b.pause(), this._pauseCache.push(b));
			var b = this._audioPool,
				c;
			for (c in b) {
				for (var d = b[c], e = 0; e < b[c].length; e++) {
					d[e].getPlaying() && (d[e].pause(), this._pauseCache.push(d[e]))
				}
			}
		},
		_resumePlaying: function() {
			for (var b = this._pauseCache, c = 0; c < b.length; c++) {
				b[c].resume()
			}
			b.length = 0
		}
	};
	if (!e) {
		var m = function() {
				var c = cc.audioEngine._currMusic;
				c && !1 === c._touch && c._playing && c.getPlaying() && (c._touch = !0, c.play(0, c.loop), !b.replay && cc._canvas.removeEventListener("touchstart", m))
			};
		setTimeout(function() {
			cc._canvas && cc._canvas.addEventListener("touchstart", m, !1)
		}, 150)
	}
	cc.eventManager.addCustomListener(cc.game.EVENT_HIDE, function() {
		cc.audioEngine._pausePlaying()
	});
	cc.eventManager.addCustomListener(cc.game.EVENT_SHOW, function() {
		cc.audioEngine._resumePlaying()
	})
})(cc.__audioSupport);
var res = {
	Sun_png: "res/taiyang.png",
	SunEye_png: "res/taiyangyanjing.png",
	Bottle1_png: "res/pingzi1.png",
	Bottle2_png: "res/pingzi2.png",
	Water_png: "res/shui.png",
	Ripple_png: "res/shuiwen1.png",
	RectMask_png: "res/zhengfangxing.png",
	Crow_plist: "res/crow/crow.plist",
	Crow_png: "res/crow/crow.png",
	Wave_plist: "res/shuiwenlizi/shuiwenlizi.plist",
	Stone1_png: "res/shi1.png",
	Stone2_png: "res/shi2.png",
	Stone3_png: "res/shi3.png",
	Stone4_png: "res/shi4.png",
	AppBtn_png: "res/app_btn.png",
	Spray_plist: "res/shuihua.plist",
	Spray_png: "res/shuihua.png",
	IconGame_png: "res/icon_moregame.png",
	IconReplay_png: "res/icon_replay.png",
	IconFacebook_png: "res/icon_facebook.png",
	IconTwitter_png: "res/icon_twitter.png",
	btn_link_png: "res/commonUI/btn_link.png",
	button1_png: "res/commonUI/button1.png",
	button2_png: "res/commonUI/button2.png",
	btn_jiantou_png: "res/commonUI/btn_jiantou.png",
	Loading_png: "res/commonUI/logo.png",
	Facebook_png: "res/f_share.png",
	ShareArrow1_png: "res/share_arrow1.png",
	ShareArrow2_png: "res/share_arrow2.png",
	MoreGame2_png: "res/more_game.png",
	PlayAgain2_png: "res/play_again.png",
	JiXuBtn_png: "res/jixuyouxi.png",
	ChouJiangBtn_png: "res/choujianganniu.png",
	Share_png: "res/fenxiangyixia.png",
	fenxiang_png: "res/fenxiang.png",
	fenxiang2_png: "res/fenxiang2.png",
	MoreGame_png: "res/moregame.png",
	MapLogo_png: "res/map_logo.png",
	BirdCry_mp3: "res/music/bird_cry.mp3",
	Hit_mp3: "res/music/hit.mp3",
	InWater_mp3: "res/music/in_water.mp3",
	GuanZhu_png: "res/guanzhu.png",
	ScoreBg_png: "res/score_bg.png",
	ShareIcon_png: "res/commonUI/share.png",
	BtnAd_png: "res/commonUI/btn_ad.png"
},
	g_resources = [],
	i;
for (i in res) {
	g_resources.push(res[i])
}
var GameStartFlag = !1;
AD_REAL_H = IOS_FLAG = null;
FaceBookFlag = TwitterFlag = !1;
MainLayer = null;
var GameLayer = cc.Layer.extend({
	size: null,
	curCrow: null,
	curCrowSpeed: null,
	stoneArr: null,
	endStoneArr: null,
	waterStoneArr: null,
	endLayer: null,
	endGameFlag: !1,
	stoneNum: 0,
	ctor: function() {
		this._super();
		var b = this.size = cc.director.getVisibleSize();
		MainLayer = this;
		this.initSystem();
		var c = new cc.LayerColor(cc.color("#FFFFFF"));
		this.addChild(c);
		c.attr({
			width: b.width,
			height: b.height
		});
		this.addLinkGame();
		this.initBottomEdgeY();
		this.initLogo();
		this.createSun();
		this.createBottle();
		this.createStone();
		this.createCrow();
		this.scheduleUpdate();
		this.showGameInfo()
	},
	btnLink: null,
	addLinkGame: function() {
		if (null != MainManager.linkData && !this.btnLink) {
			this.btnLink = new cc.MenuItemImage(res.btn_link_png, res.btn_link_png, this.openLinkGame.bind(this));
			this.btnLink.setAnchorPoint(0, 1);
			this.btnLink.setPosition(0, CH);
			var b;
			b = new cc.Menu(this.btnLink);
			b.setPosition(0, 0);
			this.addChild(b);
			this.btnLink.scale = 0.7;
			cc.log(" in .....  1111");
			this.btnLink.scale = 0.5
		}
	},
	openLinkGame: function() {
		this.canTouch = !1;
		var b = new LinkLayer;
		this.addChild(b, 19);
		b.setData(MainManager.linkData)
	},
	bottomEdgeY: 0,
	AD_H: 55,
	initBottomEdgeY: function() {
		var b = navigator.userAgent.toLowerCase();
		0 < b.indexOf("twitter") && (IOS_FLAG && (this.AD_H += 107), TwitterFlag = !0);
		0 < b.indexOf("fbav") && (IOS_FLAG && (this.AD_H += 107), FaceBookFlag = !0);
		AD_REAL_H = this.bottomEdgeY
	},
	showGameInfo: function() {
		if (GameStartFlag) {
			this.createListener()
		} else {
			GameStartFlag = !0;
			cc.director.pause();
			var b = new GameInfoLayer;
			this.addChild(b, 20)
		}
	},
	gameStart: function() {
		this.createListener();
		if (10 <= document.body.scrollTop) {
			return document.documentElement.scrollTop = document.body.scrollTop = 0, !1
		}
	},
	checkHost: function() {
		var b;
		b = window.location.href.substr(7, 14);
		b = hex_md5(b);
		"72c4cc272fe7185382beacb7c0bb7958" != b && "29dee435d50bd51af98611fcd629b797" != b && cc.director.pause()
	},
	initSystem: function() {
		var b = cc.sys;
		IOS_FLAG = b.os === b.OS_IOS || b.os === b.OS_OSX ? !0 : !1
	},
	initLogo: function() {
		var b;
		b = new cc.Sprite(res.MapLogo_png);
		b.attr({
			x: this.size.width / 2,
			y: this.bottomEdgeY / 2
		});
		if ("" != game_logo) {
			var c = game_logo,
				d = this;
			cc.loader.loadImg(c, {
				isCrossOrigin: !1
			}, function(e, f) {
				if (e) {
					cc.log("Failed to load %s.", c)
				} else {
					cc.log("loadImg end ");
					var g = new cc.Sprite(f);
					this.addChild(g);
					g.attr({
						x: d.size.width / 2,
						y: d.bottomEdgeY / 2
					});
					g.scale = b.width / b.height > g.width / g.height ? b.height / g.height : b.width / g.width
				}
			})
		}
	},
	update: function() {
		this.curCrow && (this.curCrow.x += this.curCrowSpeed, (this.curCrow.x > this.size.width || this.curCrow.x < -this.curCrow.width) && this.changeCrowDir());
		if (this.stoneArr && 0 < this.stoneArr.length) {
			for (var b = this.stoneArr, c = 0; c < b.length; c++) {
				b[c].stoneSpeedY += this.speedG, b[c].y -= b[c].stoneSpeedY, b[c].x += b[c].stoneSpeedX, 0 >= b[c].y ? (b[c].parent.removeChild(b[c]), b.splice(c, 1), c--) : (this.checkCrash(b[c], c), this.checkInWater())
			}
		}
		if (this.endStoneArr && 0 < this.endStoneArr.length && this.waterStoneArr && 0 < this.waterStoneArr.length) {
			for (c = 0; c < this.waterStoneArr.length; c++) {
				if (null == this.waterStoneArr[c].waterSpeed) {
					for (b = 0; b < this.endStoneArr.length; b++) {
						if (cc.pDistance(this.waterStoneArr[c].getPosition(), this.endStoneArr[b].getPosition()) < this.waterH / 6) {
							var d, e;
							this.endStoneArr[b].x < this.waterStoneArr[c].x ? (d = cc.rotateBy(2, 360), e = 0.2 + 1.7 * Math.random()) : (d = cc.rotateBy(2, -360), e = -(0.2 + 1.7 * Math.random()));
							this.waterStoneArr[c].runAction(d);
							this.waterStoneArr[c].waterSpeed = e
						}
					}
				} else {
					this.waterStoneArr[c].x += this.waterStoneArr[c].waterSpeed, this.waterStoneArr[c].x < this.bottle.x - this.bottle.width / 2 + this.waterStoneArr[c].width / 2 + 3 ? (this.waterStoneArr[c].x = this.bottle.x - this.bottle.width / 2 + this.waterStoneArr[c].width / 2 + 3, this.waterStoneArr[c].waterSpeed = 0) : this.waterStoneArr[c].x > this.bottle.x + this.bottle.width / 2 - this.waterStoneArr[c].width / 2 - 3 && (this.waterStoneArr[c].x = this.bottle.x + this.bottle.width / 2 - this.waterStoneArr[c].width / 2 - 3, this.waterStoneArr[c].waterSpeed = 0)
				}
			}
		}
	},
	checkInWater: function() {
		if (!(0 >= this.stoneArr.length)) {
			for (var b = this.stoneArr, c = this.ripple.getBoundingBox(), d = 0; d < b.length; d++) {
				cc.rectContainsPoint(c, cc.p(b[d].x, b[d].y)) && this.addStoneInWater(b[d], d)
			}
		}
	},
	wavePlaying: !1,
	targetStoneY: null,
	targetStongBaseY: null,
	targetStongBaseRandom: 18,
	targetStongRandom: 18,
	addStoneInWater: function(b, c) {
		b.stopAllActions();
		var d = cc.moveTo(2, cc.p(b.x, this.targetStoneY + Math.random() * this.targetStongRandom)),
			e = cc.rotateBy(6, -(360 * Math.random())),
			d = new cc.Sequence(d, cc.callFunc(this.addStoneEnd, this));
		b.runAction(d);
		b.runAction(e);
		this.stoneArr.splice(c, 1);
		this.changeWaterPercent(this.curWaterPercent + 0.05);
		SoundUtile.playMusic("res/music/in_water");
		e = cc.ParticleSystem.create(res.Wave_plist);
		this.addChild(e, 8);
		e.attr({
			x: this.ripple.x,
			y: this.ripple.y,
			scale: 0.8
		});
		IOS_FLAG || (e.scale = 0.55);
		e = cc.ParticleSystem.create(res.Spray_plist);
		this.addChild(e, 9);
		e.attr({
			x: this.ripple.x,
			y: this.ripple.y
		});
		IOS_FLAG || (e.scale = 0.55);
		this.waterStoneArr.push(b)
	},
	addStoneEnd: function(b) {
		b.stopAllActions();
		var c = this.waterStoneArr.indexOf(b);
		this.waterStoneArr.splice(c, 1);
		this.endStoneArr.push(b);
		6 < this.endStoneArr.length && (this.targetStongBaseRandom += 10 * Math.floor(this.endStoneArr.length / 6))
	},
	stoneW: 54,
	stoneH: 54,
	checkCrash: function(b, c) {
		for (var d = cc.rect(b.x - this.stoneW / 2, b.y - this.stoneW / 2, this.stoneW, this.stoneW), e = this.bottleJumpRectArr.length, f = 0; f < e; f++) {
			if (cc.rectIntersectsRect(this.bottleJumpRectArr[f], d)) {
				d = this.bottleJumpRectArr[f].x + this.bottleJumpRectArr[f].width / 2 < b.x ? cc.p(this.size.width + b.width / 2, 0) : cc.p(-b.width / 2, 0);
				SoundUtile.playMusic("res/music/hit");
				d = new cc.JumpTo(2, d, 300, 1);
				d = new cc.Sequence(d, cc.callFunc(function(b) {
					b.removeFromParent()
				}, this));
				b.runAction(d);
				this.stoneArr.splice(c, 1);
				return
			}
		}
		e = this.bottleRectArr.length;
		for (f = 0; f < e; f++) {
			if (cc.rectIntersectsRect(this.bottleRectArr[f], d)) {
				b.stoneSpeedX = this.bottleRectArr[f].x + this.bottleRectArr[f].width / 2 < b.x ? Math.abs(b.stoneSpeedX) : -1 * Math.abs(b.stoneSpeedX);
				break
			}
		}
	},
	createListener: function() {
		cc.eventManager.addListener({
			event: cc.EventListener.TOUCH_ONE_BY_ONE,
			swallowTouches: !0,
			onTouchBegan: this.touchBegan
		}, this)
	},
	canTouch: !0,
	touchBegan: function(b, c) {
		var d = c.getCurrentTarget();
		if (b.getLocation().y < d.bottomEdgeY) {
			return document.documentElement.scrollTop = document.body.scrollTop = 0, !1
		}
		if (d.canTouch && !d.endGameFlag) {
			return d.throwStone(), !0
		}
	},
	curStone: null,
	stoneSpeedX: null,
	stoneSpeedY: null,
	speedG: 0.1,
	throwStone: function() {
		var b = this.curCrow.throwStone();
		if (b) {
			SoundUtile.playMusic("res/music/bird_cry");
			var c = 2 + Math.floor(3 * Math.random());
			this.addChild(b, c);
			1 == this.curCrow.scaleX ? (b.x = this.curCrow.x + b.width / 2, b.y = this.curCrow.y + this.curCrow.height / 2, c = -360) : (b.x = this.curCrow.x + this.curCrow.width - b.width / 2, b.y = this.curCrow.y + this.curCrow.height / 2, c = 360);
			c = cc.rotateBy(2, c);
			c.repeatForever();
			b.runAction(c);
			b.stoneSpeedY = 2;
			b.stoneSpeedX = 0.6 * this.curCrowSpeed;
			this.stoneArr.push(b);
			this.crowLeave();
			this.createCrow();
			this.stoneNum++
		}
	},
	crowLeave: function() {
		var b = this.curCrow,
			c;
		1 == b.scaleX ? (c = (b.x + b.width) / (this.size.width + b.width) * 1.5, c = cc.moveTo(c, cc.p(-b.width, b.y))) : (c = (this.size.width - b.x) / (this.size.width + b.width) * 1.5, c = cc.moveTo(c, cc.p(this.size.width, b.y)));
		c = new cc.Sequence(c, cc.callFunc(this.removeCrow, this));
		this.curCrow = null;
		b.runAction(c)
	},
	removeCrow: function(b) {
		b.parent.removeChild(b)
	},
	changeCrowDir: function() {
		0.5 > Math.random() ? (this.curCrow.x = -this.curCrow.width, this.curCrow.scaleX = -1, this.curCrowSpeed = 1.2 + 3 * Math.random()) : (this.curCrow.x = this.size.width, this.curCrow.scaleX = 1, this.curCrowSpeed = -(1.2 + 3 * Math.random()))
	},
	createCrow: function() {
		var b = new Crow;
		this.addChild(b);
		b.attr({
			x: this.size.width,
			y: this.size.height - b.height - 20
		});
		this.curCrowSpeed = -1;
		this.curCrow = b;
		this.changeCrowDir()
	},
	sun: null,
	sunEye: null,
	createSun: function() {
		this.sun = new cc.Sprite(res.Sun_png);
		this.addChild(this.sun);
		this.sun.attr({
			x: this.sun.width / 2 + 30,
			y: this.size.height / 2 + 150
		});
		this.sunEye = new cc.Sprite(res.SunEye_png);
		this.addChild(this.sunEye);
		this.sunEye.attr({
			x: this.sun.x,
			y: this.sun.y
		});
		var b = cc.rotateBy(7, -360);
		b.repeatForever();
		this.sun.runAction(b);
		b = new cc.Sequence(cc.delayTime(10), cc.callFunc(this.changeEye));
		b.repeatForever();
		this.sunEye.runAction(b)
	},
	changeEye: function(b) {
		b.scaleX *= -1
	},
	water: null,
	ripple: null,
	waterH: null,
	waterW: null,
	bottle: null,
	bottleTop: null,
	createBottle: function() {
		var b = new cc.Sprite(res.Bottle1_png),
			c = new cc.Sprite(res.Bottle2_png);
		this.addChild(c);
		c.attr({
			x: this.size.width / 2,
			y: this.bottomEdgeY + b.height + 10
		});
		this.addChild(b, 10);
		b.attr({
			x: c.x,
			y: c.y,
			anchorY: 1
		});
		this.bottle = b;
		this.bottleTop = c;
		c = this.water = new cc.Sprite(res.Water_png);
		this.addChild(c, 5);
		c.attr({
			x: b.x,
			y: b.y - b.height + 19,
			anchorY: 0
		});
		this.waterH = c.height;
		this.waterW = c.width;
		this.ripple = new cc.Sprite(res.Ripple_png);
		this.addChild(this.ripple, 6);
		this.ripple.attr({
			x: c.x
		});
		this.changeWaterPercent(0.4);
		this.createBottleRect()
	},
	bottleRectArr: null,
	bottleJumpRectArr: null,
	createBottleRect: function() {
		this.bottleRectArr = [];
		this.bottleJumpRectArr = [];
		this.bottleJumpRectArr.push(this.displayTestRect(this.bottleTop.x - this.bottleTop.width / 2 + 20, this.bottleTop.y - 12, 10, 10));
		this.bottleJumpRectArr.push(this.displayTestRect(this.bottleTop.x + this.bottleTop.width / 2 - 30, this.bottleTop.y - 10, 10, 10));
		this.bottleRectArr.push(this.displayTestRect(this.bottleTop.x - this.bottleTop.width / 2 + 20, this.bottleTop.y - 45, 20, 30));
		this.bottleRectArr.push(this.displayTestRect(this.bottleTop.x + this.bottleTop.width / 2 - 40, this.bottleTop.y - 43, 20, 30));
		this.bottleRectArr.push(this.displayTestRect(this.bottleTop.x - this.bottleTop.width / 2 + 37, this.bottleTop.y - 75, 10, 25));
		this.bottleRectArr.push(this.displayTestRect(this.bottleTop.x + this.bottleTop.width / 2 - 51, this.bottleTop.y - 73, 15, 25));
		this.bottleJumpRectArr.push(this.displayTestRect(this.bottleTop.x - this.bottleTop.width / 2 + 20, this.bottleTop.y - 83, 5, 5));
		this.bottleJumpRectArr.push(this.displayTestRect(this.bottleTop.x + this.bottleTop.width / 2 - 25, this.bottleTop.y - 83, 5, 5));
		this.bottleRectArr.push(this.displayTestRect(this.bottle.x - this.bottle.width / 2 + 5, this.bottle.y - this.bottle.height + 43, 7, 170));
		this.bottleRectArr.push(this.displayTestRect(this.bottle.x + this.bottle.width / 2 - 12, this.bottle.y - this.bottle.height + 43, 7, 170))
	},
	displayTestRect: function(b, c, d, e) {
		return cc.rect(b, c, d, e)
	},
	curWaterPercent: null,
	changeWaterPercent: function(b) {
		var c = this.water,
			d = (new cc.Sprite(res.Water_png)).getTextureRect();
		c.setTextureRect(cc.rect(d.x, d.y + this.waterH * (1 - b), this.waterW, this.waterH * b));
		this.ripple.y = c.y + this.waterH * b;
		this.curWaterPercent = b;
		0.85 <= this.curWaterPercent && this.gameEnd()
	},
	createStone: function() {
		this.stoneArr = [];
		this.endStoneArr = [];
		this.waterStoneArr = [];
		var b = new cc.Sprite(res.Stone2_png);
		this.addChild(b);
		b.attr({
			x: this.bottle.x - this.bottle.width / 2 - b.width / 2,
			y: this.bottomEdgeY + 5,
			anchorY: 0
		});
		b = new cc.Sprite(res.Stone3_png);
		this.addChild(b, 11);
		b.attr({
			x: this.bottle.x + this.bottle.width / 2 + b.width / 2 - 35,
			y: this.bottomEdgeY + 5,
			anchorY: 0
		});
		getFlipped = function() {
			var b = 1;
			0.5 > Math.random() && (b = -1);
			return b
		};
		for (var c = 0; 3 > c; c++) {
			b = new cc.Sprite(res.Stone1_png), this.addChild(b), b.attr({
				x: this.bottle.x - this.bottle.width / 2 + b.width / 2 + 5 + Math.random() * (this.bottle.width - b.width),
				y: this.bottle.y - this.bottle.height + b.height / 2 + 10 + 20 * Math.random(),
				scale: 0.8,
				rotation: Math.floor(360 * Math.random()),
				flippedX: getFlipped
			})
		}
		b = new cc.Sprite(res.Stone1_png);
		this.addChild(b, 2);
		b.attr({
			x: this.bottle.x,
			y: this.bottle.y - this.bottle.height + b.height / 2 + 10,
			scale: 0.8,
			rotation: Math.floor(360 * Math.random()),
			flippedX: getFlipped
		});
		c = new cc.Sprite(res.Stone1_png);
		this.addChild(c, 2);
		c.attr({
			x: this.bottle.x - this.bottle.width / 2 + c.width / 2 + 5,
			y: this.bottle.y - this.bottle.height + c.height / 2 + 10,
			scale: 0.8,
			rotation: Math.floor(360 * Math.random()),
			flippedX: getFlipped
		});
		var d = new cc.Sprite(res.Stone1_png);
		this.addChild(d, 3);
		d.attr({
			x: this.bottle.x + this.bottle.width / 2 - d.width / 2 - 2,
			y: this.bottle.y - this.bottle.height + d.height / 2 + 10,
			scale: 0.8,
			rotation: Math.floor(360 * Math.random()),
			flippedX: getFlipped
		});
		d = new cc.Sprite(res.Stone1_png);
		this.addChild(d, 1);
		d.attr({
			x: b.x + b.width / 2,
			y: this.bottle.y - this.bottle.height + b.height / 2 + 10,
			scale: 0.8,
			rotation: Math.floor(360 * Math.random()),
			flippedX: getFlipped
		});
		d = new cc.Sprite(res.Stone1_png);
		this.addChild(d, 2);
		d.attr({
			x: c.x + c.width / 2,
			y: this.bottle.y - this.bottle.height + b.height / 2 + 10,
			scale: 0.8,
			rotation: Math.floor(360 * Math.random()),
			flippedX: getFlipped
		});
		this.targetStoneY = this.targetStongBaseY = d.y + d.height / 2 * 0.8
	},
	gameEnd: function() {
		this.endGameFlag = !0;
		cc.director.pause();
		this.unscheduleUpdate();
		if ("" == sys_activityID) {
			var b = !ChineseFlag || TwitterFlag || FaceBookFlag ? new EndLayerEnglish : new GameEndLayer2;
			this.endLayer = b;
			this.addChild(b, 25);
			this.setGameScore()
		} else {
			this.endLayer = b = new EndLayer, this.addChild(b, 25), this.setGameScore(), 25 > Math.floor(9 / this.stoneNum * 1000) / 10 && (this.endLayer.SetTipLabel("获得奖品还有一步之遥！"), this.endLayer.SetChouJiangVisible(!1))
		}
		if (0 == _lastAdTime || 30 < _AdLayer.getInterval()) {
			b = new AdLayer, this.addChild(b, 30)
		}
	},
	setGameScore: function() {
		var b = Math.floor(9 / this.stoneNum * 1000) / 10,
			c = cc.sys.localStorage.getItem("p7_score");
		c || (c = b, score_submit(b, 2));
		b > c && score_submit(b, 2);
		b >= c && (c = b);
		cc.log("oldScore : " + c);
		this.endLayer.SetMaxScore(c);
		"" == sys_activityID ? this.endLayer.showScore(b) : this.endLayer.showScore(b + "%")
	}
}),
	MyUtil = {
		cliper: function(b) {
			b = new cc.Sprite(b);
			var c = new cc.ClippingNode;
			c.attr({
				stencil: b,
				anchorX: 0.5,
				anchorY: 0.5,
				alphaThreshold: 0.8
			});
			return c
		}
	};
SoundUtile = {
	playMusic: function(b) {
		IOS_FLAG ? cc.audioEngine.playEffect(b + ".mp3", !1) : (b += ".ogg", cc.audioEngine.playMusic(b, !1))
	}
};
var GameScene = cc.Scene.extend({
	onEnter: function() {
		this._super();
		var b = new GameLayer;
		this.addChild(b)
	}
});
var EndLayer = cc.Layer.extend({
	tipLabel: null,
	chouJiangItem: null,
	moreGameItem: null,
	appBtn: null,
	_shareLabel: null,
	ctor: function(b) {
		this._super();
		b = cc.director.getVisibleSize();
		var c = new cc.DrawNode;
		this.addChild(c);
		c.clear();
		c.ctor();
		c.drawRect(cc.p(0, 0), cc.p(b.width, b.height), cc.color(0, 0, 0, 200), 1, cc.color(0, 0, 0, 255));
		this._shareLabel = new cc.Sprite.create(res.fenxiang_png);
		this._shareLabel.setAnchorPoint(1, 1);
		this._shareLabel.x = b.width - 25;
		this._shareLabel.y = b.height - 20;
		this._shareLabel.setVisible(!1);
		this.addChild(this._shareLabel);
		this.tipLabel = new cc.LabelTTF("成绩不错，试试手气！", "Arial", 30);
		this.tipLabel.x = b.width / 2;
		this.tipLabel.y = b.height / 2 - 30;
		this.addChild(this.tipLabel);
		this.chouJiangItem = new cc.MenuItemImage(res.ChouJiangBtn_png, res.ChouJiangBtn_png, function() {
			"" == sys_activityID ? window.alert("活动暂未创建，不能抽奖") : window.location.href = "http://www.wesane.com/admin.php/Activityshow/activityResult/activityId/" + sys_activityID
		}, this);
		this.chouJiangItem.attr({
			x: b.width / 2,
			y: b.height / 2 - 80,
			anchorX: 0.5,
			anchorY: 0.5
		});
		c = new cc.MenuItemImage(res.JiXuBtn_png, res.JiXuBtn_png, function() {
			cc.log("JiXuBtn is clicked!");
			cc.director.runScene(new GameScene);
			cc.director.resume()
		}, this);
		c.attr({
			x: b.width / 2 - 100,
			y: b.height / 5 + 30,
			anchorX: 0.5,
			anchorY: 0.5
		});
		var d = new cc.MenuItemSprite(new cc.Sprite(res.Share_png), new cc.Sprite(res.Share_png), function() {
			this._shareLabel.setVisible(!0)
		}, this);
		d.attr({
			x: b.width / 2 + 100,
			y: b.height / 5 + 30,
			anchorX: 0.5,
			anchorY: 0.5
		});
		this.moreGameItem = new cc.MenuItemImage(res.MoreGame_png, res.MoreGame_png, function() {
			window.location.href = sys_is_weixin ? "http://mp.weixin.qq.com/s?__biz=MzA5NzQxMzU4NQ==&mid=207293871&idx=1&sn=173662dd6d0b62ec9f19382a5368f270#rd" : "http://m.wesane.com"
		}, this);
		this.moreGameItem.attr({
			x: b.width / 2,
			y: b.height / 2 - 80,
			anchorX: 0.5,
			anchorY: 0.5
		});
		this.appBtn = new cc.MenuItemImage(res.AppBtn_png, res.AppBtn_png, function() {
			window.location.href = sys_is_weixin ? "http://m.wesane.com/index.php/download" : "https://itunes.apple.com/cn/app/wu-ya-he-shui-wei-san-you-xi/id1069791628?mt=8"
		}, this);
		this.appBtn.attr({
			x: this.moreGameItem.x,
			y: this.moreGameItem.y - 20,
			anchorX: 0.5,
			anchorY: 0.5
		});
		"" == sys_activityID ? (IOS_FLAG ? (this.moreGameItem.y += 60, b = new cc.Menu(this.moreGameItem, c, d, this.appBtn)) : b = new cc.Menu(this.moreGameItem, c, d), this.tipLabel.setVisible(!1)) : b = new cc.Menu(this.chouJiangItem, c, d);
		b.x = 0;
		b.y = 0;
		this.addChild(b)
	},
	showScore: function(b) {
		var c = cc.director.getVisibleSize(),
			d = new cc.Sprite(res.ScoreBg_png);
		this.addChild(d);
		d.attr({
			x: c.width / 2,
			y: 3 * c.height / 4 + 30
		});
		b = new cc.LabelTTF(b.toString(), "Arial", 36);
		this.addChild(b);
		b.attr({
			x: c.width / 2,
			y: 3 * c.height / 4 + 30,
			color: cc.color("#000000")
		})
	},
	SetMaxScore: function(b) {
		var c = cc.director.getVisibleSize(),
			d = new cc.LabelTTF("最高命中率：" + b + "%", "Arial", 30);
		this.addChild(d);
		d.attr({
			x: c.width / 2,
			y: 2 * c.height / 3 - 10
		});
		score_share("乌鸦喝水，我投石子的命中率竟然是" + b + "%！")
	},
	SetTipLabel: function(b) {
		this.tipLabel.string = b
	},
	SetChouJiangVisible: function(b) {
		this.chouJiangItem.setVisible(b);
		this.moreGameItem.setVisible(b);
		b || this.tipLabel.setVisible(!0);
		"" == sys_activityID && (this.moreGameItem.setVisible(!0), this.tipLabel.setVisible(!1))
	}
});
var GameInfoLayer = cc.LayerColor.extend({
	ctor: function() {
		this._super();
		this.init()
	},
	init: function() {
		this._super(cc.color(0, 0, 0, 180));
		var b = cc.director.getVisibleSize();
		cc.p(b.width / 2, b.height / 2);
		var c = LanguageManager.getText("game_info"),
			d = LanguageManager.getText("start"),
			c = new cc.LabelTTF(c, "Arial", 28, cc.size(400, 300), cc.TEXT_ALIGNMENT_LEFT);
		c.setAnchorPoint(0.5, 1);
		c.x = b.width / 2;
		c.y = 3 * b.height / 4;
		this.addChild(c);
		d = new cc.LabelTTF(d, "Arial", 40);
		d.x = b.width / 2;
		d.y = b.height / 5;
		this.addChild(d);
		b = cc.EventListener.create({
			event: cc.EventListener.TOUCH_ONE_BY_ONE,
			onTouchBegan: this.onTouchBegin,
			onTouchMoved: this.onTouchMoved,
			onTouchEnded: this.onTouchEnded
		});
		cc.eventManager.addListener(b, this)
	},
	onTouchBegin: function(b, c) {
		var d = c.getCurrentTarget();
		cc.director.resume();
		d.parent.gameStart();
		d.removeFromParentAndCleanup();
		return !1
	},
	onTouchMoved: function(b, c) {},
	onTouchEnded: function(b, c) {}
});
var Crow = cc.Layer.extend({
	ctor: function() {
		this._super();
		this.createCrow();
		this.addStone()
	},
	sprite: null,
	spriteSheet: null,
	createCrow: function() {
		cc.spriteFrameCache.addSpriteFrames(res.Crow_plist);
		this.spriteSheet = new cc.SpriteBatchNode(res.Crow_png);
		this.addChild(this.spriteSheet);
		for (var b = [], c = 1; 7 > c; c++) {
			var d = cc.spriteFrameCache.getSpriteFrame(c + ".png");
			b.push(d)
		}
		b = cc.Animation.create(b, 0.07);
		this.runningAction = cc.RepeatForever.create(cc.Animate.create(b));
		this.sprite = cc.Sprite.create("#1.png");
		this.sprite.attr({
			anchorX: 0,
			anchorY: 0
		});
		this.width = this.sprite.width;
		this.height = this.sprite.height;
		this.sprite.runAction(this.runningAction);
		this.spriteSheet.addChild(this.sprite)
	},
	stone: null,
	addStone: function() {
		var b = new cc.Sprite(res.Stone1_png);
		this.addChild(b, -1);
		b.attr({
			x: b.width / 2,
			y: this.height / 2 + 10,
			scale: 0.8
		});
		this.stone = b
	},
	throwStone: function() {
		if (this.stone) {
			var b = this.stone;
			this.stone = null;
			this.removeChild(b);
			return b
		}
	}
});
var GameEndLayer2 = cc.Layer.extend({
	tipLabel: null,
	chouJiangItem: null,
	moreGameItem: null,
	_shareLabel: null,
	ctor: function() {
		this._super();
		var b = cc.director.getVisibleSize(),
			c = new cc.LayerColor(cc.color(127, 170, 19, 255));
		this.addChild(c);
		this._shareLabel = new cc.Sprite.create(res.fenxiang2_png);
		this._shareLabel.setAnchorPoint(1, 1);
		this._shareLabel.x = b.width - 25;
		this._shareLabel.y = b.height - 20;
		c = new cc.LabelTTF("点击晒成绩", "Arial", 30);
		c.setAnchorPoint(1, 0.5);
		c.x = b.width - this._shareLabel.getContentSize().width;
		c.y = b.height - this._shareLabel.getContentSize().height / 2 - 20;
		this.tipLabel = new cc.LabelTTF("", "Arial", 30, cc.size(400, 300), cc.TEXT_ALIGNMENT_LEFT);
		this.tipLabel.setAnchorPoint(0.5, 1);
		this.tipLabel.x = b.width / 2;
		this.tipLabel.y = b.height - this._shareLabel.getContentSize().height - 50;
		this.addChild(this.tipLabel);
		var d = this;
		cc.loader.loadImg(cc._Img, {
			isCrossOrigin: !1
		}, function(b, c) {
			d._initStage(c)
		});
		c = new cc.MenuItemImage(res.JiXuBtn_png, res.JiXuBtn_png, function() {
			cc.director.runScene(new GameScene);
			cc.director.resume()
		}, this);
		c.attr({
			x: b.width / 2 - 120,
			y: b.height / 2 -25,
			anchorX: 0.5,
			anchorY: 0.5
		});
		var test = function() {
				shareGuide()
			};
		var e = new cc.MenuItemImage(res.GuanZhu_png, res.GuanZhu_png, function() {
			test()
		}, this);
		e.attr({
			x: b.width / 2 + 120,
			y: b.height / 2 -25,
			anchorX: 0.5,
			anchorY: 0.5
		});
		var f = new cc.MenuItemSprite(new cc.Sprite(res.MoreGame_png), new cc.Sprite(res.MoreGame_png), function() {
			window.location.href = "http://djaa.cn/iPhone_qiange_taobao_shop_index.php?shopName=%E6%89%8B%E6%9C%BA%E6%B7%98%E5%AE%9D&shopUrl=https%3A%2F%2Ftecenet.m.taobao.com&shop_type=taobao&Advertisement=0&small_shop_type=shop_index&short_url=vnHij9"
		}, this);
		f.attr({
			x: b.width / 2,
			y: b.height / 2 + 60,
			anchorX: 0.5,
			anchorY: 0.5,
			scale: MainLayer.size.width / 720
		});
		b = new cc.Menu(c, f, e);
		b.x = 0;
		b.y = 0;
		this.addChild(b)
	},
	_initStage: function(b) {
		var c = cc.director.getVisibleSize(),
			d = c.width / 720,
			e = new cc.Texture2D;
		e.initWithElement(b);
		e.handleLoadedTexture();
		b = new cc.Sprite(e);
		b.x = c.width / 2 - 20 * d;
		b.y = c.height - 150 * d;
		b.scale = 1.3 * d;
		this.addChild(b, 10)
	},
	showScore: function(b) {
		cc.director.getVisibleSize();
		game_max_score = 100;
		parseFloat(b / game_max_score).toFixed(2);
		var c = "我真是太历害了，我在[乌鸦喝水]竞然得了0分，前无古人后无来者！";
		0 < b && 40 >= b ? c = "我在[乌鸦喝水]命中" + b + "%，别说了！赶快做老年痴呆症诊断吧！" : 60 >= b ? c = "我在[乌鸦喝水]命中" + b + "%，好险啊！看来得多练脑、多动手！" : 80 >= b ? c = "我在[乌鸦喝水]命中" + b + "%，太棒了！真是头脑聪明、思维敏捷！" : 100 > b ? c = "我在[乌鸦喝水]命中" + b + "%，厉害了！人类已经跟不上我的速度了！" : b >= game_max_score && (c = "我在[乌鸦喝水]命中100%，百发百中，全球第一！还有谁？");
		b >= game_max_score && (game_max_score = b);
		this.tipLabel.string = c;
		score_share(c);
		wechat_score(b);
		wechatShare()
	},
	SetMaxScore: function(b) {}
});
cc._Img = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUoAAABkCAYAAADg+Hn3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NUIyRERGREVGNzM5MTFFNjlGODZBNUY0QzVFODE3RjgiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NUIyRERGREZGNzM5MTFFNjlGODZBNUY0QzVFODE3RjgiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo1QjJEREZEQ0Y3MzkxMUU2OUY4NkE1RjRDNUU4MTdGOCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo1QjJEREZEREY3MzkxMUU2OUY4NkE1RjRDNUU4MTdGOCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pry6BBcAACvLSURBVHja7H0HuBU1+n4uXEBAuogNpYhgQVFRAbuiqLgrKnZEVsWCvYvCYllwrbuurm0RUNdVREVBF2yILDYsqIgFQRGxIIqA0sv9zfs/b/7nuyGZmXPOnHKveZ8nz5kzyWRmMsmXr+VLWUVFhfLw8PDwcKOGbwIPDw8PTyg9PDw8PKH08PDw8ITSw8PDwxNKDw8PD08oPTw8PKosynO4dpMgXRykw4PUKki1fHOGYm2Q5gXpxSDdGaRvfZN4eFQNlGXpR3lKkO4KUhPfhFlhWZAuDdIDvik8PKonoTw+SKN90yWCM4P0oG8GD4/qRSgbBmlJFX7fL4I0OUifBek3vD9T0qhgahqk3YLUPYT73ixIC3xX9PAoXWSqo7y6Cr9r/yANL9K9GwXpL0E635J3Q5DO9l3Rw6P6cJSzgtSuCr7nXkGaVgLPAUJ5l3HuqyC18V3Rw6N0kal70JZV8B37lAiRBO4O0pPGuQa+G3p4VC+OEtbaenl6lo+CdKVK6UEfDtJGCdQJXeT2cdohSDX5i8kDrk4VPK7JY9d160VaHlMMh06yDv//FKTmvit6eJQuMtVRrsuw/KdB+j5IC4O0gudqq5SRoyGJRmsSXxhXXmCZ15i3NEh1KZoeFKSeQeqUwf0fc5wHEYZe8Kggbc3/tUn40Cb1BZHUE0QF/9e1tAnSmiAtVilj14wgXcJ3N4H8l/kuigTWw8OjGnGUS2OKinB5GapS+rc4WEFi1SJIPxqqAZOQwP/w9pj1HiaIr8TOQfowz23bIUifO/L+plLO+orv28J3RQ+P6sNRxsFtQbqCxzCidA7STkF6ipwUcCs5xu+CtJqi7reCSF5DQis50zOC9GaQ7uA94rj1rAwRyY8N0uYqtWIG3Owq/q4k1wcx+pcgtQzSu+K6g0nUa5HDrEUxWp/7jQRycYKcuYeHRzUilCA6g3i8b5CmiLwXDNEXYu+m4twgcXxOkCYE6WmVMsR8rdL+mwer+L6PrmWVq1l3HCwhV1uDKoTvEminmr7reXj8fgnlfHJmwH7kAMFdvm6Uu4AJztY38jlGMW+gSq2HPpP/t6Wo3Jbc6XkFbqNV5C439t2l5AHXtW5iMoSHwRqRvzcnvo99U0VO5IM4bl/2zZE8oVwkjocJ8XkgO+g9KmUoQVCISUEao1KO4Br7qJQDdkP+B3E6WaUMPgjC0YbEeKsCtA0s0UcE6VSVtvR3DdInnACeUHb9p0fx0ENV9lP9r5BEOgZpqpio7/bNZQXG42CVUjl9SQbFE8o8cF+S6IGwdOBMrtc0ryShO0Sl9JTbBGmuSi3100QThHSsSkXbuU1t6HYDwvmeyk9Qjj1J2Hs52mt7ptNVSnd5iRiAHsXFD+IYngpSF3yXcXxakM5Vaf1zGLZw9IdiATrwV/JU98YkkoqMCVRkzyZUN9RX7TmOirmrYQ3SnKXFIpTSQg29IlbymOuY0XkPM86NVyn3HBhsvqG43YTcJxq2AYkjZje4Dn1kiFRJ4e9Bukj8f5j3wvJD6FXHUUXQm5wuVAH/UykL9p0lRjS6kCAUe5tNdEoY8m4qwL3khKrduTTO4gTYj//x7d4J0vWUYsLctHYJ0j9L6Nu+nEdCCY+ME8kwAPclSCjhWjddpX2Ii4kTKBUWhVDKlT4gbkeqlMFmKAnbZRTPR6qUfhKDZy05AXBmv/Halyx1t2Jn/1ceGq0+ifWB/D+aOprZQo0A/ExOF2kE09YksGuoWigVbEFiUAqYX6D7rBDHNY3+jUn7T1SXDOc3B4YE6bgg7apSes0oAlwKKMtz/VBhfEfChnF6fjVUVWTEQCRNKKXBozsJiCQ0x6iUjg+E8lcxuyuKs1/wBRqyI68isXqP1P8acnD/TfiZoXPcSYhlF4r8zUXHbCbOY0bvSI5zG3Icc1Tp6C1LyQVpTYHus8Lo27b+/bhKGSnQBw8WksPaDO7zPCd11xLgtZSkoB9tTGYhqbGGvjg5RjmMtQFZShSLjeug/vpjhgS6jAxQH8ukU4cc/Bsc42UF6Bt4n05iDGc0PpImlHIt+Az+jhIzdQ3RKNAhwX1oPxIcmyUSXMG+zG9NojmBnTQpK/QUQSTHGkTSnHlqG3lLKaJ8TdH8OQ6KX0qAOIEY9MxyoFRwkmvP/3DOvzrLDl2D7VMITDf6tit83TecyIfwXW/O8D5HxigDDuwrEuFiqD92ERNBrgBhOyTLa/uETJ77FrhNML6z0jUnTSixNBEKYFjLZnJmfYp5cPGB3mwPlbI6YvZ/moQSs19flVIil6v0tgnvccDLGXTHBInk3RS5FAfzMVmIPHCSP5nvUs6PcUAJEMqfcuS8FwhCiQE/Mc+D+qAE6mlufKuhbAeXOD2bk99FgjtcSfXO2giGIGwrD3Bf5wlGoY2Kv0otKZTCZL04YiyBXiwq4PNkrRvNx8qci8mVYaB1EB0K+rInySXCIg6F9L9VyjJ+HQnOLHJkjSh6r2A5+Fp+JjpAEhxla1XZJ7N3CHelOYImITPVNHKX+5Nbqer+Z/WT6GAxAcJyQx7qvSbL6x5RaX25ckg6YfirOH67CETSxBg+UyE3EyxT7pVxGoXeZytrET8fhPICztRaZ6ehjR8SMI6cSHF6fIzZBS8KJfN/VMqwkwtkZ4bx5t0Q0VF3sJYcJDb9xs2Ce75XVc24na5OlW995y+q+gDipI5YtYpMQb4BqQhGRZd1GuPx/RJrJ4yjuAFhwKD0II1YlsE9WlLNkjO9K89TI8BVBjqtL8gpLuEMvUaI1uXkCrelqKq5R0TcWcrZ6FeWbU2uTusP38iRUMIif7z4f29I2dqinTajePeDpdzTPL8Z36kd3786EMq1eb5XhaHKeDQLDmA9vxVWdG0kJsBvM+SkIJKvzuFdZF/CpH6oSibmKNoC/rrzLdxvH0FQbOJuwxLsX6s5AUMVdy2lxvccZdGGj1GN8k9KoFHAN/+E3wAc9SCVwzY25XlsiM2ZXI20mgNwDTsAOtPu7PBrOHgaGHqni3h+To7Ptpc4BmF+LaRsPaOz1g4p+7hKRwXap4oTSklc1hTwvvi2l+Zw/dEqbVSE6P1lAZ8devYdDfXO8wnX/4hxTsZthRvPX6pI/8LYgE1Au/tB5dYt5L2BTVR8lVsvlt2O/WlQLpJRvnQW4A6PVOnNu8xUh0SwCRsI4kondnCwy1B+t2Ueyuu14lqcnatysyTuKo4nR5TdwvgftnzyU3F8QBUXIWsUkKN0DfxsIFeH7Vjg9sq3r6GNsblKHMfZe6k+x97GeUgNVGXddtS4wiTyJv93Ven4DibDdQSPf+Pk157jNswR/ixjAgEalxpHiYEF40sLzgKNmdCIT4gPNoAc2/0UW0EUL+H1P5LVXqnSxgQQ0llkpxeqytGHMoH0h4yKS2m6WBxA0d+GheJ4typOKMuLxFHmCqnDalTA+/7HELEfIwdTZqgH2grO6TcVf9UL6rG50H1JEXMHTuIwKE4LUVuAMG2t8uOypG0IHWNwb80ozZ1ExkdxonnI6G9niONHKYlOEWMf48zUv4Lu9BC06HHR/iVFKNFhZjvyYAX8mmLJUDbokySUIIRhQXmbixfOhVBKa9zciLKmLhQfbpij7GzLs1ZV1DIkhKqCXzMglJBolqrcjVUQ908Q/weHiMAYwNrVCi5wfRJ45wfFuLkwos6OeW7/BiqebnkNiSVowWi2Xx2+S19R7nRxPIq/MMTewWMwXtsadUtvhwdUAiurCuEusJaEZUc2oHY+xuwIfR+WSc3kufks00qllpWZMSM3E8c/5vBMk8TxlJByVxjcp6JawOVwPEvMhqOqOKGUIvDqAt53VYKEsmlEWbinQSd6EXVZ2aC1qrxmeL4K1xNubXCYSUBuedI7Yny8QhVRLgnjFZ4qHzi+X9z30vr+MwXzgmhdncWk0prHuOdbPMZ6dL24ABz6xUad54j/w/Kl80gSYK1hOPlGsNtLSDyh09iXs8gzotPVYOf9mpzmO6Lhmhsix4FZPheI42HkYr8P6dDShQiD6SaqCv6sUqtwbJ1kFz7nlCIROHS0gTmIVnpTNWmIO5ltncvEWsbvHOXbCFXNoeKaqDo/IWemsTQmRwlL8OGsA6uQulAMzAQdKCGVG9xlGOQzLU9wnEGPvzfHU5cQSal7QvfEuw83zsHDoF8GhHK9UEFgTN0iuMDdVOUANddbJDstct9KTvRXnq8tGKJvqwKhvFUQyVnsJNoYAqKjlaxwOB5P4jRZpSxhWuR9SRDKxg4xNxtErckeKwgDZrB/sCPCrQguDccoe5R0PesWC5hht0+4zmYWzjobzItRZluV2Xp5M3KTdAEJU95fbhDie7N4nxaqsusNnOajwrZJqWhxgt/oDTIlI6iW6pLHPnYVuWZJP0ZQ7F+WA63AAhDETYCxFdb9rsyDn+0Yo/x0njuOzwE/5gFUe2gMTOqF8y16a/YY3CMs1pdRNK1HIjmD3KO2FsJNB0Ev+otO/JNjNp6dx+e+V6WNMdJd5XJR5lEV7ipULKxWpYt86Dp/Nv7/EkP0LlOVXZCmZSgBlIn+2pwTIzi6ITGulQsRZibYDrdTLXQ2+2zLPLQ1GJY3KWlpIrmInPgZORBJDamP7CMmur87yp9pcJhjhST0Br9rIsg3R6n1dRAHdhCc1hOcDbTT95MUGTGLYO031v3WpIi+zhCXpOidD/Q1dBzS6g3u+D7mb0Rud/8SI0YPsZNkq/+q4Hc538K5va+yXwZWI0TNUWGIzm9F1AXOXruhmINT6uY2DRmQ9Q21SqZtBNTlRH4o27uWcrs3VXC87S7O/UAmItM2XWb5vgss4niS+LNF/B3Htvw5oXtMIiHuavSHWxzlkTeM6hwwLTLgxaAkXz7fhLKemPV/Fix2c1XZ6bs3ubh5nKUnWeowOYQ55J6S5Oq6kNBoIH6hGfnmEordm5KoD7F0oGLi2wT0Mmc5uKj/5emZ5TeEgaBHRPlZgjNbHiLeb+O4XgYRnhGDMJtYJdQzXVTaLSxKPVHTmOwHUoyNSyh1OUzOH0WU3cFyXTbYk9yqXIq5jpNLPoIZQw33lUo7lmPFTtiacRBERKuXkcug/ni1KhFKKSq34cxwrErvY70Nz79KHQM4oeH8MFrX1NrBISxhg7ZP6Fmh5H7OEL9HWcrhoyF82Tv8f51KGRTGqOoBiDunWM5fGSICJTWhSikkDHJ1hkko5cS2Jfua5LauVpWNghdmyXUDu7KPN8qhrbNB2OqUjiQuR4lz2S4Y6Kk2NFq+TalrVp76gkkU94jxLSDhjXeI5FWCUEoqj0H2BxIkLR7BCtqJ4spczrCjyH5PEDOaJJS1VVoPNzeCUMbtILDqPir+XxfBJb7LWewhoUo4VNkjs9uwXpUuegsOZD7bug11P72pJkkacuD/FlG2PkVeF6GcTY6nJt9jO0EooQKSUYowQU/OUo2gyGF3VtEeBhV8r/aCe15Hop6NncC2ZrkDudN+lrxsret7GQTsRpWQu00InjH6w/Hsc2GMiOnaBfe9DxN9qoqKikzS0orMMF5cu0+QrhX/rxblhonzRwepLo9bWercSpR9OOL+h8R4pyuMa07LoD0uNK49KeZ1fxPXLMjwG+Q7fSye7eYgdRX/5+TpnveJe4yIKNssSMtF+e0tZWaJ/HPE+ZHG99o+5vPtb1y3dRbvuEmQVog6jkmg3cqD1C5Id0WMg2uyrP9iUceEBJ63fpAWsb5VQWph5HdyPP9PIXW2cFxj+0YTsm3/fFu9Qdl1ZGQEvhgq8t6iGA4OUzrMQu+zgjOtbXlXc0OZG4ZdIvL/aSiKjzJ0lFGAy5BcBYFlbHHW+xZiu91sAFcLuT56Krn7FUJ9clIe7itVKlELCTZS6SWtFQ4OdKahd9YinOS24KtXSDeuW1RlQ0+HBOpsSLWPaXjDOHtK/E8ijF0h1vvLsQeXvPeF7tfl6jPScf6BJB+sECtzXlSpTbe6GSw1RB74Ib6i0ttGbMJyg6kD2dlS3yYZiBTHh+RBxB8glPOwbo/L4v0gssNKp41V55G4NA5R6PdQpYm7jUloophQNO7Mg8pGBh6JMkTVFf12hYNQSl/G1uJ7K3HdgAK2K3R9f7IQM7zrZTnoOBepykGBZ5AxGaQqB1v+MYF3yLea7lQx3kHYLzXUX8PUhsuCoZY7XIzhs4VaDmPsgKpEKAHsn/w6dV4fk5C8zgQDDuLQwYo9j+egR2obwlHYBpgN4CJcgVPRqeDYPIIfaFIO7/cWudfJgotxRUyHoaqBKj3cZXB2cLnQhpUhogM2N/S5uaJMVTbYzY0oX8+YKG2TpbTOt+FkvIMxKAu1+VqnkAkY/fc29v2BKjsPDq2LG8R+rCPry37/vSpN1BR9QE7GekniOKM/mMbEp4wJ/AGDkxxVVXSU+cAb1Dv9nXqOKPwWpM0LqOPrH6RBQWpjyTvc8nyloKM83nimhZYyFxll/pTQvVtnqDeUOtO5jjK1+N1teDSLZ8xWR3lwkFYb154ZpP0MXbDGN0G6irrHuM/WlfXJc+2MercsUR1lM4vu+BPjml7Gu3Tm+UGGDrMGzzcM6adZ6yirIqHMBj8Gad8iE6PzHM9WbEK5s+WZujvKzjbK7ZPA/f8o6lscg0gcIsrPDCn3nOW9FosBZaYdQt4nG0J5ieX+D1oMibYx9WWQ+iQ08c3PoZ58Esr1PNfSePedLddNF/ljg9TIuOYEo/xfRN5y0acmZksoy9XvAzpIBdx3JlCJvybPqge4AMGVBSsxejn0rcUG3CrMZV7DlXtjNOh95NJRLA7YV7njc8aBXKnyQQyjwaaGrtGF+6kb1IBLzUHK7Zp1EsVX+MfeG2IkiCNq/0NtuBUrDJZnGOdu5X2uN3SmUEVgldoVVHs8k+EzdBbHn5XomPyeek8ZeQlb+9oc6S+lamw8DVeyPaBWGW2UH0RbQWPqtP/M9LsSvasbisVR7kEOS+LDGNedZXmHHjk8xzhRz60xyo8R5V8IKfe88Yz3R9R7iyg7JQuOsn2Im87fYrzX3kF6zXH9WCFyxkmynvtKlKP8LEjTRP2/BKmO47oagts/zmibzWK67jUP0r2l6h7kUZroTU6ykcFxxdmQ/gGLUn2iym6fm5qGZVJbq3ciV1VusYxKI9nbjnohORxhnDtchW8zKw2DUdGLygzubQQ5N9NNBxwvdhm9JEZbwIi5P7lOc+10L3K6Y1T0VhlNDEPO+yXaB5saEt2pyh2LFFLAVH6jJwyjzw+Oa/4hDHb3UFLJOuJ9PkRvsNSfq1RI+HV5Em/Xq3TMxA4xrN8eaSDyy1XGuYUcXEtj1oGBDzetPoY1f3/mxQ1Y0tPwANBeAxA5+3IQgGgsowhlRud+0FIn3NFsMRdbksif4XiWVuL464jnXkqiO1W5w5mNotg8L8PvA6L7LD0/TBemHVX0qq6TjTH3Qon2wzqcZI5h33suxjW/kqBCrTJfVQ6vZ4OeHLWbW4tSEL2X0MJUu8AiJCycp5J196K3O+0apHct9/+OK6CyqfMhS32raKSIc/0L4rrXxfk+MdrtOqMuiG1vGWWeMFb9ALtZnqNMiITAnhGit/aiGGp5rpcTMnJpcVwaMurEuOZzUX5GggbIpEXvtUFqmmU9WzBlet3zxbZ6fxXhglCbAzWfhGAzPocnlJVT0xDd2Rs5dFadhjjqxnLHS4PUwHHdpkb5fiKvQ0R7XWaxWM8yyk0T+esM16fmxvVtDXeyjSIIpcy7jATpUrqm5OMbYuLoElPvLHFljvc9X9T1UgGWMOY7PSPe59hiWL3BOoetqIAzKSJ6nK0SXlok8APFoHkqfwF1occ7h6IXrGh7hZRdJUSMYgCian+Kf7YAtjKKfC6AxfYLflcZ47ENxXFE68HSNCzvnKnSe7bfKMquZb601EIsa8j30E7mP1KPKZ3MsfXC48Y3h+5yb/H/NJXeD3sT5h9OFRFwoaHTWxnxzteq1KoYiMGrKe5jKSFWaG2pct9y9/8LfCq18ugHqpkGCNXTI2rDWJym7jjMcl+P9YS966nGNypllKno4CRyZ9SMVIJJEMrbVfSyMx3cVhLKluzc5dQjlPPha/C4TBzrwbWWHRMh9L+x3AdRYrDC5LI8fYyrVXrry6YhhPJ6Tg4LOYC2L2CHgR7vKLpHbOYg9tDTPZXgPUHkXuM7H2XkwTXrciYsS8UKmbYGkR6pNozM/l7EPVHHYBJBCRkQWgObiO2i0hHqW5MYjyCxuUCUnRrjff/icGEpJCYYhBLr9LsZusmFIdejb7zFMj+R8P/KSaicY1bubvipKm3Upv59BfXav6l0gOOm7Ccy6ntmyzoTEL1bxrjuMxFNqLUhCmWLpQ7dWus8ism7haxUWUKd3Y6iDMTObwsseo8Oude/CiDunORYdVLBVUumHq3CIgrHSftY6h8acc2dMb7xjjFXVBUbsu9vZcnvGNEWNWKubNPYtgqI3nHdF6FeqVdI0XuBwdnVpEgHsUmv75Zsew2y+ji/KS3joPg6ms5izggHcEaYzGvqkBNqyP8IrjFb2ffo+IoWMVeEnmm0KDYmd1svg/dtZrD6EN3g8PpflXJol1ulQkS/zRBHC4GzqQqRngBYWz+QXF++8RjThbRe6+9wFfuG5vB0XMgbIjgfF6ayn2hL+SmG+G4DonLPpRRki/o9Rtn3sdE7giqV/e6WSYqY6wwPhZXs13uKbzAjhufIPLXhnti2cv1VMntU4dmbCA6wZsJtM1Wlg2S4AJpxmMowRmfZ/7PoxMdSw53jK+qiNGoJEQr+TnpT+I/p2oCPJ1eoIKLKroaOCKHZxtPFRAbG2J2s9RNiwLkQJu4Oo45JkXhkEoj0BFXZj8tGSPvSbWa3mHX+mJPbgh2tqTecQwL1TJEGdS1OGK0s6pDXOaHmqsNFqD64pGWyOkhvwnUoJ5RfqFK5TlVtfE+RupGK5+p1JMdlDX4rreqqRR37XDICXyf0fNA3P0+GZzXvvyjB90fkpB58h3Kh1isj4wU69Jxy+17mjVB+rSr7n2mObQ/OwMcJBfmu1Dt1Ftyn5jT3UGlnY/jh3cHO29RQ0GPGvIf6tzCA03NtaD+XA6WCgyST/WVOJTcEtCfx3pqKdjxbNluE5oNQKj7XvBIe1Juo9A6GxUQd5XZ0rmrYmZPks8ojUeTD4VzHB4QjuLY82mIz1iCRgpVwODmOGYLal3Mg1aNYtSfFgJtyfL5WJKLaKX46DSAYLGso1qwVSZ6T4arAOV6tKlvPVlF9UEu5t0otFOaVeN/7SVXeirhYWFWNxvNHKnrTMY8SIZQ6uOZOakMLoiQqIEAHUmSCRVIHYtD7gYBzXWDokhAjcX4Cz7iDSruGdBa6mExwrRDhbcDzD1H5s8B7eHhUUUIJ3YPWK4JbG0dCB3eNJmpD36VmgkA9Sd3KIQbXAR3J9iSmEOWhBB6l7O5BcQG9zFiDQNbgs4LAreT/LSka6/2aFwuOuSbFx9VChbBacCnLVG7bhHp4eJQIkl6HDV2j3iEPIZNg+YYy/ysLoYJSF9ZYWL8HkAg+YpSDpQ3hrzpR7wKd4A0UKyep6K0sXZCGnmHkbmFtX07RpQnVBQiDBWXzQhJmGc7pYKoJFpELRlrKtJzi+qW+i3l4eEJpYldxPEUca84K1mhYhGF9QnQXuKtA94j4f3eSuAKwTME5uSsJEJxF+5HAXUOxGWL7fjlwvhp1yVnXZoKl+HtyxC8ZbbS/+P+l8X5loo66vmt5eHjR24UT+QuuaoI4r8XbJhSnYQSBEQU6SLho6OCx4M4uEQQT4nEvitoryeHB9zFXg47cL8V0o5DuCmuMvPpUAUwntztTVd61UFE0/4nv2sh3sZJiCtb7ZvAoBY4S1mv4o3U2zusOCjcahDx6nWIpIlrfQsJzPrlLEMmm5NCwjhe+Vv8hUR9MEXiuShlKsiX0FZZn05B+kg9Q1JfEVK4hvodEdzw53m1USsfZmqJ7X9/FioqNqboZovK3/r+6oVWQriSD4qFFxjz4UdowlQQG29NeQfEWGKHSfo3QVXa3dOg5FIPb8n7vkagu5b1texaH+VECz5AIKxLCo8m1YoWN9utDEFu5mx843x4Uq88ngYVBZwtV2bCE9oEPIxx/EWT2nIi2yZcfpUdKvfO8of7xCAf8hOGOB1XYxb458iN6A39Uqcg6CKp6r8G5guOC7yQcY2EIWUjCp1exTGP+ahJMcARbqsqRtxF15jK1YRCFbHGdqryfRg/OqAeRaOJ+CCDxokjDqD5YRyKJZVPHkZhu6btVyUD75H7qmyI2dHT1T3xT5JdQQk+5O7k9TSg1UYOOD64zeh3qVSSS35ALizPTQbTPVfcn15iC84P1vJ1KRYeGQepMqgYmUuxfx8GG62BQuk9y5SoV3mq7Evy+aO9ObPN3Lfmbk7Dj3cx1843YJsuYvyO5aehmF1vaE+32q0r7p0pAFYOFA1OoksCqpuXKvh65He+N/arXOJ4Xg/mrkPduwHt0ESK4VgctCyGcmJC7clzMJDcaJ7zYgWzn+pzooVqa5SjbkBPrtnyWqY5vAzQnc6HbFS5qx3Ks/Mzni1pZBialJ5mT1WRGbGv+IdVB5aUj7HQUbYZ7ZLo3eBtKkVvzvjMooS1zlEd7dGN5eKDA++SlkPoxbrfiZKhjO/yB7fuxkCQAuPcdQ6l0Eeudk9Hb5Bidw7av8tPMGyfOPeuIuPwwzy/ihkgzuVXn16x7PiNwf85zeg/fqC1NP4+IHvKYKHttyAZbp1uuHWW5X0vxfKUUuHdjy37IMukoP9db8kYaefeGvP/pYgtSM+jt7iJii45OrdHYEuB5DfPODdm2tHfEex8b0t6rLOURuPcdS9nvuTe36z4nh0SHauOIGL7WUna8o0/rzb3uZuBrE9gzvG/EVsALLNe9XbHhXvcfhLTZ/Rn0ubpBetxRz78t5Rtw87QKxz7nRzvucx3LDGG0chOTWa6Vo+4zir25mF6614Sc5X4h3OLGouy25Baac1ZopNKRd1aqdNSRVaqy1ToXkUypDYOsLjNmfxP3iWfWG12BI95FpaMllQpggX9Z6OskWqq0xf4ohwpFc/LAuJCyxwnu2gwG0k3ooxX1zZrrPNgoe7CQcg4y8mqTawPGR7w3xMZ/qfReKdBnD6c66HqjLDjc98k9vcj3Bsc3klzLy8q+JxOkj0eZh/v0o657MPXupt4ZLm53k/u+iSqePuRsYLC07RmzTnC64DpfYFv3JccFTglBkZtZrkW7P0vdP9riMHJV4OphNJ1klL+H5fT2ttjM7AF+t3FxbR4q5Rt9AsfsULbJydT/1zJ0xbXJ4faireFaHv+J32Ir2jUOtNxLc/qnUjV2B99vKM/Dle9hcrLf8BlOEHaH4cXmKOeFzEwmR/k3McvvFXLfRiKm5cwM9w2xYWBIjML/ibwBlmu3FFtPVJAjlfe+rcS2gujH+7xrnNfxNHVs0C2MPUn0Fh/6XDk3k68wtvXYSHCBwDDjPs/x/N7inN5rZrhR9h5j+1KZd5DBKcRJ28foM1raeciSN9yRt6V4zosc9TZwlD/IUvY75u1unD9XXHe75bqfHM9QLvaQsnHmHzHvFEvezcw7PYu+do/gBBtZ8utxfyL9/z6xbUhdS/n7xPYdZt7Vom1OsWzPURFy7VLLlh553TPHJJSdRN50suAjRUeYYdnrROILbhD1KvfomCQ+qg7We1gChFJ2glFG3kSR19/IW8u9XpC3jTg/wDKo3y0RQtlE3EsGSn2b4vAg5p0t8k7juTuMuh7l+UHi3AE8dxM75Q8ir6YgxHLTuS5CjWIO/DlC7O9mmYDOzuDdDxX9ypbfykGUZQKW8V30ubsc+3+7km7jWxz5V4g2tBHK+Y7rRoiAzPJ834h9z48QIr+LOF2VYT9rJvpZ1xjl61BVY06iZlriqFMTyvcs1zQUz2KjF09lSiiTNuYcYxh1PheiEsSLCouI1IViThuK37ZAogvJil+usoglZ8GiEPF6jYW9l0YLHeh3CcULiO7YAgG+k1cwbxJFOWwZMFCpou6f/gsNBvswPcX32JMi4zBa9iHO3W+I16aI+yRFmCNUejuEE4T3ANQmZ6h0iLcufPcXDC+Ft9h+zaiy+JDX4D9ijo6iKAvDhY4zqbd3yCS2ZpRL0EFCND9dVXZ9qxCqoXp8Nr19wAFCXI2DrkJdc4HRHypUeoVZG8f1LmOPjhNpxvTcT/Tlc1Vllzvcbycetwpps0zdqXYXaqg3Y5TvxHssjlBZ/Y/GqG6Oet+xnFtBtQX6+QeW/EwNU4kTygOEnk9aP+sabkISdZgGU49xkkpH5bmWOop+HOTdhc4sF3wbQigbO4imtLbN5QeeLgbB5SQgGOh6zfogdtRih1wby/brRkJ5oCCE6zn5dDP0kxhQk416JhoDX/HbLKPu+DUSyj9w8ujJMg9bnglRuM+hZfRDQXBxDx1+DcT7MhKplrQkL0iwXTbn79bKvke4hIyE38wgVFHQEbXOjFkuLsGv6ZjQNcHvKb5BJvfLBtoO8XHM8lrvGxU5/UfLuHR5sNjoWrnDE6BohHJXlfZ3fNXxoWtZruvJmRRczK2GMeVpKpdPV+kgr7kSyhWqso9YK4tLjRKGIxPST3KyQTR2IFEYTCVyq5APXEi8wt9eJDzHGtwZlPVnkQCsZOd72iIBrCAx3J+K9m/JUd9lfPfuJJTaqf95yzM9Q0K5DzmzM42BNkVwRh34+2DC7aK5XBDqqx39s4LpB+OcUvFX+2ijzE0OrqhCGLriEoOwAb9OGOJcEfkrVDqkYRKoMJiiKKw1iLoLtUXfi9s2ZRH5RSWUG4kZ4pIMCZdS6fBssLzdwGdbYDTWtASeU/oMtrCIOysjOMoO4vgJitYm2jGVCkAIflbpFVDHcOB/JwjZWZzoNDf3iKOu50goMUEsNwjYfLZtdxKdDpQsbANSxyo9hFz9dgZBHUNCiX7RMYTgxhG9Xb6Qc4RUMTGDeheSI9pDxduHaC7VELNiWOyTwEKhUsj0fjUi2syFLw0RPAqaWdmOtMO1bW5n0YeLhiR1Z29SLG0Xwk6bIkRblQ5s+w9BcGsY7Lbu0Mcl8JzS0bS95Zl+scx6EieK4w8SFgXziUf5eyOJ5QiRpx17LxXfw0UANBc6gKqFCqMTP0nd3vWC4NkAggr9I2J6DhXiuDK40xtIxMElzczwnTU3sbEjX7vItFZ2tyfl0AE+LdorDrMxSbxLHO4pVzwnRP2w5bF1Q2hCpi5471CNAw7xmpjj8BuOv1scZQ7kGEW9L1cXQqliEI2agmBeQG4DnfhtlY4I9Kx4rhv5e4vgPt5S0at4wvC9QSjDWHnbMsmdVGW/rpurCKHUIlh/g+BJkXpfiuczlH0NvZYY0MkPIJc01sjXMTuvjCCUkms9n78y4tRM9ie9WupxRx3ncJDa9lHSa/C3Uum95esKERt65r/yGPUfafnWY1XlYNL6m8MguDmJfUeR15wTSEdjksLqmpaclLYxmId+JG5JSXi4x3QSXhhDdjHy9Rr4RiE6Qbk3uiy3JyW7kcYEAp/di3g8lONb5h/Nc5Ix0d8M5681CPfBYgK/WBV7y448+FHa0issD5+6c4w6HrD4VUrsz7yBxvkLglQrC/egC0S52y35b4n8/R11fOLwSyu1lTk2VxdghSXvbJF/eUQ9Q0XZP1jcPuRe52H1bGasFnG5qlTQ1SfsnVzuHm+L/J/pj2v2mwmGC9ps4ZZi829E6kBXKPkd5SqdXSyuc7+J/Hn0U9VYbLnHtQ63Op3+FeIG1ILjU+MHul6tj2gv6bK3hs/8d8vKO3Ofe5df8jfC//ZdS/nLjfLzjHa62fGct4e8+8YR+5GPK7Qf5VcZEsoX6XM4hY7JnS1LkoCzDIfo44UD8X8iPpQSzuk2SIffiZb8j0X+PiH13CrKbcrBVeqEEkvoRjuciVswb7RwqnelbVnuMcM/UqermH9ajGf6K8vaCGEn5v07ZNnqNZyoBocsVnhUDNgRjnKYQKcGaSW/y49BGuNwENepMZ//I/rYrqFf30WOdtmayxFnCb/cTznxbOHwAx0d4tN4AvPPdeTXZ90fcRytJ/HEM7QPea9juKR4CdvhRJHXnfU9TYLkWjo5XjjEo48/EqSdHOX35jf6Tvi1gpj1CHnGXiHvXod9E/nNLfn9mRd77CS9r3eY1fUgR3noqLD86FRhzDlL6LuOtZzfhLqXOQ4lsGtf77UUw7SKAOJTE6PMfIpG66lv/Vy53TOO4zMq1vNSBspsKer4MGseHiWMXHWUTTOswwySCx/DbwWR/KcghkBvoQPrT8J2JC2zM0MsZZuFWOY0kexpIZJaR6lnjy/UhpFylGGZ3U0YgfZQG+486eHh8TsnlFDyds7CCrkrid09VDjDKrifUOpLwJXlKnKDIGzjqYiu47jH3g4CqLm+DlS03+UoU0sQSijm60e80+uCe62gQeS/vmt5ePx+CaWt/F9jXGeKrpvSijWaFriDVeVo4iZg9W5L69frJHYuQjkkpB7ttI7IK60dZSDWP0Ir3Isq2mVjI3KRe4lz4FaXx2xTH3nbw6PEkamOEr5v9Szn+yq3gzIAR9t2JB718/g+8HF8rIjtibBU8CmEHvf6EGIu8ZNKdimZh4dHwsjUbwse/9tYzj/MukY6roNfFYwyr+bxXRD9/N9Fbs+zsrhmue+GHh7Vi6NE4NHzQvIRJQZ6RziFy50LVxqialLA0jM4PcPp+PAq+g3AAZ/su6KHR/UhlHBjiRPmDPpHrERA5dDBwdqNddM1VTKrD3S9DWKKt6UMhJWb47uih0f1Eb3hWnOhSq/LdqFONSBghcBgTyQ9PEof2bgHwa3mCt90OeM6lQ5+6+HhUY1Eb4mOJJjQETZX7ph5HilA/QALNwI43KHskZk9PDyqGaH08PDw8KK3h4eHh4cnlB4eHh6eUHp4eHh4Qunh4eHhCaWHh4eHJ5QeHh4eJY3/E2AALJsN9oelsRQAAAAASUVORK5CYII=";
var EndLayerEnglish = cc.Layer.extend({
	tipLabel: null,
	chouJiangItem: null,
	moreGameItem: null,
	_shareLabel: null,
	size: null,
	ctor: function() {
		this._super();
		var b = cc.director.getVisibleSize();
		this.scale = b.width / 720;
		b.height -= AD_REAL_H * this.scale;
		this.size = b;
		var c = new cc.LayerColor(cc.color(0, 0, 0, 230));
		this.addChild(c);
		c.scale = 1 / this.scale;
		cc.log("AD_REAL_H : " + AD_REAL_H);
		this.tipLabel = new cc.LabelTTF("", "Arial", 45);
		this.tipLabel.setAnchorPoint(0.5, 1);
		this.tipLabel.x = b.width / 2;
		this.tipLabel.y = 2 * b.height / 3 - 130 + AD_REAL_H;
		this.addChild(this.tipLabel);
		c = b.height / 2 - 200 + AD_REAL_H;
		0.95 > this.scale && (this.tipLabel.y += 50, c.y -= 50);
		var d = new cc.MenuItemImage(res.IconGame_png, res.IconGame_png, function() {
			window.location.href = "http://www.vsane.com"
		}, this);
		d.attr({
			x: b.width / 2,
			y: c + 80,
			anchorX: 0.5,
			anchorY: 0.5
		});
		d.color = cc.color("#fcf253");
		d.scale = 0.8;
		d.y -= 0.1 * d.height;
		var e = new cc.MenuItemImage(res.IconFacebook_png, res.IconFacebook_png, function() {
			this.onFacebookClick()
		}, this);
		e.attr({
			x: b.width / 2 - 130,
			y: c - 80,
			anchorX: 0.5,
			anchorY: 0.5
		});
		var f = new cc.MenuItemImage(res.IconReplay_png, res.IconReplay_png, function() {
			cc.director.runScene(new GameScene);
			cc.director.resume()
		}, this);
		f.attr({
			x: b.width / 2 + 130,
			y: e.y,
			anchorX: 0.5,
			anchorY: 0.5
		});
		var g = new cc.MenuItemImage(res.IconTwitter_png, res.IconTwitter_png, function() {
			this.onTwitterClick()
		}, this);
		g.attr({
			x: b.width / 2,
			y: e.y,
			anchorX: 0.5,
			anchorY: 0.5
		});
		b = new cc.Menu(g, e, f, d);
		b.x = 0;
		b.y = 0;
		this.addChild(b);
		b = e.x - e.width / 2;
		f = f.x + f.width / 2;
		e = c - 1;
		c += 1;
		d = new cc.DrawNode;
		d.drawRect(cc.p(b, e), cc.p(f, c), cc.color("#ffffff"), 0, cc.color("#ffffff"));
		this.addChild(d)
	},
	showScore: function(b) {
		var c = this.size,
			d = new cc.Sprite(res.ScoreBg_png);
		this.addChild(d);
		d.attr({
			x: c.width / 2,
			y: this.tipLabel.y + 130
		});
		d.scale = 1 / this.scale;
		b = new cc.LabelTTF(b.toString() + "%", "Arial", 60);
		this.addChild(b);
		b.attr({
			x: c.width / 2,
			y: d.y,
			color: cc.color("#225f9a")
		})
	},
	bestScore: 0,
	SetMaxScore: function(b) {
		this.tipLabel.setVisible(!1)
	},
	onTwitterClick: function() {
		var b, c;
		b = location.href;
		c = document.title + " is very interesting, come play with me, click play now!";
		b = "http://twitter.com/share/?url=" + encodeURIComponent(b) + "&text=" + encodeURIComponent(c);
		window.location.href = b
	},
	onFacebookClick: function() {
		var b, c;
		b = location.href;
		c = document.title + " my best score: " + this.bestScore + ", come play with me, click play now!";
		b = "http://www.facebook.com/sharer.php?u=" + encodeURIComponent(b) + "&t=" + encodeURIComponent(c);
		window.location.href = b
	},
	onShareSimpleLink: function() {}
});
var hexcase = 0,
	b64pad = "",
	chrsz = 8;

function hex_md5(b) {
	return binl2hex(core_md5(str2binl(b), b.length * chrsz))
}
function b64_md5(b) {
	return binl2b64(core_md5(str2binl(b), b.length * chrsz))
}
function str_md5(b) {
	return binl2str(core_md5(str2binl(b), b.length * chrsz))
}
function hex_hmac_md5(b, c) {
	return binl2hex(core_hmac_md5(b, c))
}
function b64_hmac_md5(b, c) {
	return binl2b64(core_hmac_md5(b, c))
}
function str_hmac_md5(b, c) {
	return binl2str(core_hmac_md5(b, c))
}
function md5_vm_test() {
	return "900150983cd24fb0d6963f7d28e17f72" == hex_md5("abc")
}
function core_md5(b, c) {
	b[c >> 5] |= 128 << c % 32;
	b[(c + 64 >>> 9 << 4) + 14] = c;
	for (var d = 1732584193, e = -271733879, f = -1732584194, g = 271733878, h = 0; h < b.length; h += 16) {
		var k = d,
			m = e,
			n = f,
			p = g,
			d = md5_ff(d, e, f, g, b[h + 0], 7, -680876936),
			g = md5_ff(g, d, e, f, b[h + 1], 12, -389564586),
			f = md5_ff(f, g, d, e, b[h + 2], 17, 606105819),
			e = md5_ff(e, f, g, d, b[h + 3], 22, -1044525330),
			d = md5_ff(d, e, f, g, b[h + 4], 7, -176418897),
			g = md5_ff(g, d, e, f, b[h + 5], 12, 1200080426),
			f = md5_ff(f, g, d, e, b[h + 6], 17, -1473231341),
			e = md5_ff(e, f, g, d, b[h + 7], 22, -45705983),
			d = md5_ff(d, e, f, g, b[h + 8], 7, 1770035416),
			g = md5_ff(g, d, e, f, b[h + 9], 12, -1958414417),
			f = md5_ff(f, g, d, e, b[h + 10], 17, -42063),
			e = md5_ff(e, f, g, d, b[h + 11], 22, -1990404162),
			d = md5_ff(d, e, f, g, b[h + 12], 7, 1804603682),
			g = md5_ff(g, d, e, f, b[h + 13], 12, -40341101),
			f = md5_ff(f, g, d, e, b[h + 14], 17, -1502002290),
			e = md5_ff(e, f, g, d, b[h + 15], 22, 1236535329),
			d = md5_gg(d, e, f, g, b[h + 1], 5, -165796510),
			g = md5_gg(g, d, e, f, b[h + 6], 9, -1069501632),
			f = md5_gg(f, g, d, e, b[h + 11], 14, 643717713),
			e = md5_gg(e, f, g, d, b[h + 0], 20, -373897302),
			d = md5_gg(d, e, f, g, b[h + 5], 5, -701558691),
			g = md5_gg(g, d, e, f, b[h + 10], 9, 38016083),
			f = md5_gg(f, g, d, e, b[h + 15], 14, -660478335),
			e = md5_gg(e, f, g, d, b[h + 4], 20, -405537848),
			d = md5_gg(d, e, f, g, b[h + 9], 5, 568446438),
			g = md5_gg(g, d, e, f, b[h + 14], 9, -1019803690),
			f = md5_gg(f, g, d, e, b[h + 3], 14, -187363961),
			e = md5_gg(e, f, g, d, b[h + 8], 20, 1163531501),
			d = md5_gg(d, e, f, g, b[h + 13], 5, -1444681467),
			g = md5_gg(g, d, e, f, b[h + 2], 9, -51403784),
			f = md5_gg(f, g, d, e, b[h + 7], 14, 1735328473),
			e = md5_gg(e, f, g, d, b[h + 12], 20, -1926607734),
			d = md5_hh(d, e, f, g, b[h + 5], 4, -378558),
			g = md5_hh(g, d, e, f, b[h + 8], 11, -2022574463),
			f = md5_hh(f, g, d, e, b[h + 11], 16, 1839030562),
			e = md5_hh(e, f, g, d, b[h + 14], 23, -35309556),
			d = md5_hh(d, e, f, g, b[h + 1], 4, -1530992060),
			g = md5_hh(g, d, e, f, b[h + 4], 11, 1272893353),
			f = md5_hh(f, g, d, e, b[h + 7], 16, -155497632),
			e = md5_hh(e, f, g, d, b[h + 10], 23, -1094730640),
			d = md5_hh(d, e, f, g, b[h + 13], 4, 681279174),
			g = md5_hh(g, d, e, f, b[h + 0], 11, -358537222),
			f = md5_hh(f, g, d, e, b[h + 3], 16, -722521979),
			e = md5_hh(e, f, g, d, b[h + 6], 23, 76029189),
			d = md5_hh(d, e, f, g, b[h + 9], 4, -640364487),
			g = md5_hh(g, d, e, f, b[h + 12], 11, -421815835),
			f = md5_hh(f, g, d, e, b[h + 15], 16, 530742520),
			e = md5_hh(e, f, g, d, b[h + 2], 23, -995338651),
			d = md5_ii(d, e, f, g, b[h + 0], 6, -198630844),
			g = md5_ii(g, d, e, f, b[h + 7], 10, 1126891415),
			f = md5_ii(f, g, d, e, b[h + 14], 15, -1416354905),
			e = md5_ii(e, f, g, d, b[h + 5], 21, -57434055),
			d = md5_ii(d, e, f, g, b[h + 12], 6, 1700485571),
			g = md5_ii(g, d, e, f, b[h + 3], 10, -1894986606),
			f = md5_ii(f, g, d, e, b[h + 10], 15, -1051523),
			e = md5_ii(e, f, g, d, b[h + 1], 21, -2054922799),
			d = md5_ii(d, e, f, g, b[h + 8], 6, 1873313359),
			g = md5_ii(g, d, e, f, b[h + 15], 10, -30611744),
			f = md5_ii(f, g, d, e, b[h + 6], 15, -1560198380),
			e = md5_ii(e, f, g, d, b[h + 13], 21, 1309151649),
			d = md5_ii(d, e, f, g, b[h + 4], 6, -145523070),
			g = md5_ii(g, d, e, f, b[h + 11], 10, -1120210379),
			f = md5_ii(f, g, d, e, b[h + 2], 15, 718787259),
			e = md5_ii(e, f, g, d, b[h + 9], 21, -343485551),
			d = safe_add(d, k),
			e = safe_add(e, m),
			f = safe_add(f, n),
			g = safe_add(g, p)
	}
	return [d, e, f, g]
}
function md5_cmn(b, c, d, e, f, g) {
	return safe_add(bit_rol(safe_add(safe_add(c, b), safe_add(e, g)), f), d)
}
function md5_ff(b, c, d, e, f, g, h) {
	return md5_cmn(c & d | ~c & e, b, c, f, g, h)
}
function md5_gg(b, c, d, e, f, g, h) {
	return md5_cmn(c & e | d & ~e, b, c, f, g, h)
}
function md5_hh(b, c, d, e, f, g, h) {
	return md5_cmn(c ^ d ^ e, b, c, f, g, h)
}
function md5_ii(b, c, d, e, f, g, h) {
	return md5_cmn(d ^ (c | ~e), b, c, f, g, h)
}
function core_hmac_md5(b, c) {
	var d = str2binl(b);
	16 < d.length && (d = core_md5(d, b.length * chrsz));
	for (var e = Array(16), f = Array(16), g = 0; 16 > g; g++) {
		e[g] = d[g] ^ 909522486, f[g] = d[g] ^ 1549556828
	}
	d = core_md5(e.concat(str2binl(c)), 512 + c.length * chrsz);
	return core_md5(f.concat(d), 640)
}
function safe_add(b, c) {
	var d = (b & 65535) + (c & 65535);
	return (b >> 16) + (c >> 16) + (d >> 16) << 16 | d & 65535
}
function bit_rol(b, c) {
	return b << c | b >>> 32 - c
}
function str2binl(b) {
	for (var c = [], d = (1 << chrsz) - 1, e = 0; e < b.length * chrsz; e += chrsz) {
		c[e >> 5] |= (b.charCodeAt(e / chrsz) & d) << e % 32
	}
	return c
}
function binl2str(b) {
	for (var c = "", d = (1 << chrsz) - 1, e = 0; e < 32 * b.length; e += chrsz) {
		c += String.fromCharCode(b[e >> 5] >>> e % 32 & d)
	}
	return c
}
function binl2hex(b) {
	for (var c = hexcase ? "0123456789ABCDEF" : "0123456789abcdef", d = "", e = 0; e < 4 * b.length; e++) {
		d += c.charAt(b[e >> 2] >> e % 4 * 8 + 4 & 15) + c.charAt(b[e >> 2] >> e % 4 * 8 & 15)
	}
	return d
}
function binl2b64(b) {
	for (var c = "", d = 0; d < 4 * b.length; d += 3) {
		for (var e = (b[d >> 2] >> d % 4 * 8 & 255) << 16 | (b[d + 1 >> 2] >> (d + 1) % 4 * 8 & 255) << 8 | b[d + 2 >> 2] >> (d + 2) % 4 * 8 & 255, f = 0; 4 > f; f++) {
			c = 8 * d + 6 * f > 32 * b.length ? c + b64pad : c + "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(e >> 6 * (3 - f) & 63)
		}
	}
	return c
}
var HttpManager = cc.Class.extend({
	URL: "http://www.wesane.com/h5service.php/Interface/services",
	cacheList: null,
	isBusy: null,
	req: null,
	perform: null,
	ctor: function() {
		this.cacheList = []
	},
	checkHave: function() {
		this.isBusy || this.sendOne()
	},
	send: function(b, c, d, e) {
		cc.log("发送数据");
		this.cacheList.push({
			type: b,
			data: c,
			func: d,
			target: e
		});
		this.isBusy || this.sendOne()
	},
	sendOne: function() {
		if (0 != this.cacheList.length) {
			this.isBusy = !0;
			this.perform = this.cacheList.shift();
			this.req = cc.loader.getXMLHttpRequest();
			this.req.onreadystatechange = this.onDataHandler.bind(this);
			this.req.onerror = this.onErrorHandler.bind(this);
			this.req.ontimeout = this.onTimeoutHandler.bind(this);
			this.req.timeout = 2000;
			this.req.open("POST", this.URL);
			this.req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
			var b = "send=" + JSON.stringify({
				type: this.perform.type,
				gid: game_id,
				mid: null,
				data: this.perform.data
			});
			cc.log("" + b);
			this.req.send(b)
		}
	},
	onDataHandler: function() {
		if (4 == this.req.readyState && 200 <= this.req.status && 207 >= this.req.status) {
			cc.log("" + this.req.responseText);
			var b = JSON.parse(this.req.responseText);
			this.isBusy = !1;
			this.perform.target ? this.perform.func.call(this.perform.target, b.errorcode, b.data) : this.perform.func(b)
		}
	},
	onErrorHandler: function() {
		cc.log("网络错误");
		this.isBusy = !1;
		this.perform.target ? this.perform.func.call(this.perform.target, -1) : this.perform.func(-1)
	},
	onTimeoutHandler: function() {
		cc.log("请求超时");
		this.isBusy = !1;
		this.perform.target ? this.perform.func.call(this.perform.target, -1) : this.perform.func(-1)
	},
	clearAll: function() {
		for (var b = this.cacheList.length, c = 0; c < b; c++) {
			var d = this.cacheList[c];
			d && (d.target ? d.func.call(d.target, -1) : d.func(-1))
		}
		this.cacheList.length = 0
	}
});
HttpManager.instance = null;
HttpManager.register = function() {
	HttpManager.instance = new HttpManager
};
var LinkLayer = cc.Layer.extend({
	lis1: null,
	bg: null,
	changeScale: null,
	ctor: function() {
		this._super();
		this.bg = new cc.DrawNode;
		this.bg.drawRect(cc.p(0, 0), cc.p(CW, CH), cc.color(0, 0, 0, 100), -1);
		this.addChild(this.bg);
		this.nodeContainer = new cc.Node;
		this.addChild(this.nodeContainer);
		this.changeScale = cc.director.getVisibleSize().width / 720;
		this.nodeContainer.scale = this.changeScale
	},
	setData: function(b) {
		MainLayer.unscheduleUpdate();
		this.initUI(b);
		this.layerIn()
	},
	createListener: function() {
		this.lis1 = cc.EventListener.create({
			event: cc.EventListener.TOUCH_ONE_BY_ONE,
			swallowTouches: !0,
			onTouchBegan: this.onTouchBegan.bind(this),
			onTouchMoved: this.onTouchMoved.bind(this),
			onTouchEnded: this.onTouchEnded.bind(this)
		});
		cc.eventManager.addListener(this.lis1, this)
	},
	removeListener: function() {
		cc.eventManager.removeListener(this.lis1);
		this.lis1 = null
	},
	onTouchBegan: function(b, c) {
		return !0
	},
	onTouchMoved: function(b, c) {},
	onTouchEnded: function(b, c) {
		b.getLocation().x > CW / 2 && this.layerOut()
	},
	ch: null,
	initUI: function(b) {
		this.LW = (CW / 2 + 100) / this.changeScale;
		this.ch = CH / this.changeScale;
		this.bgColor = new cc.DrawNode;
		this.bgColor.drawRect(cc.p(0, 0), cc.p(this.LW, this.ch), cc.color(0, 0, 0, 255), -1);
		this.nodeContainer.addChild(this.bgColor);
		var c = this.LW / 2,
			d = this.ch - 100,
			e = 340,
			f = 0.8;
		switch (cc.sys.language) {
		case cc.sys.LANGUAGE_CHINESE:
			f = 0.65, e = 280
		}
		var g = LanguageManager.getText("link_top_tip");
		this.txt1 = UIToolManager.getLabelTTF(g, 42, 0, 0.5, c - e / 2, d);
		this.nodeContainer.addChild(this.txt1);
		this.txt1.width > e && (this.txt1.scale = e / this.txt1.width);
		e = new cc.Menu;
		e.setPosition(0, 0);
		this.nodeContainer.addChild(e);
		for (var g = b.gameList.length, h = 0; h < g; h++) {
			var d = d - 100,
				k = new cc.MenuItemImage(res.button1_png, res.button1_png, this.openLink.bind(this, b.gameList[h][1]));
			k.setPosition(c, d);
			k.setScaleX(f);
			k.setScaleY(0.75);
			var m = UIToolManager.getLabelTTF("" + b.gameList[h][0], 36, 0.5, 0.5, c, d);
			this.nodeContainer.addChild(m);
			e.addChild(k);
			cc.log("txt.width: " + m.width);
			cc.log("btn.width: " + k.width);
			k = (k.width - 20) * k.scaleX;
			m.width > k && (m.scale = k / m.width)
		}
		d = this.ch / 2;
		f = new cc.MenuItemImage(res.btn_jiantou_png, res.btn_jiantou_png, this.layerOut.bind(this));
		f.setAnchorPoint(1, 0.5);
		f.setPosition(this.LW - 15, d);
		e.addChild(f);
		this.logo = UIToolManager.getSprite(res.Loading_png, 0.5, 0, c, 220);
		this.nodeContainer.addChild(this.logo);
		this.logo.scale = 0.83;
		d = 145;
		this.btnCenter = new cc.MenuItemImage(res.button2_png, res.button2_png, this.openLink.bind(this, b.gameCenter));
		this.btnCenter.setPosition(c, d);
		this.btnCenter.setScale(0.85);
		b = LanguageManager.getText("game_center");
		m = UIToolManager.getLabelTTF(b, 40, 0.5, 0.5, c, d);
		this.nodeContainer.addChild(m);
		e.addChild(this.btnCenter);
		200 < m.width && (m.scale = 200 / m.width)
	},
	openLink: function(b) {
		window.location.href = b
	},
	layerIn: function() {
		SoundUtile.playMusic("res/music/openLayer");
		this.nodeContainer.x = -CW / 2;
		this.nodeContainer.runAction(cc.sequence(cc.moveTo(0.2, 0, 0), cc.callFunc(this.layerInEnd.bind(this))))
	},
	layerInEnd: function() {
		this.createListener()
	},
	layerOut: function() {
		SoundUtile.playMusic("res/music/openLayer");
		this.removeListener();
		this.nodeContainer.runAction(cc.sequence(cc.moveTo(0.2, -CW / 2, 0), cc.callFunc(this.closeLayer.bind(this))))
	},
	closeLayer: function() {
		this.hide();
		MainLayer.canTouch = !0;
		MainLayer.scheduleUpdate()
	},
	hide: function() {
		this.removeListener();
		this.removeAllChildren(!0);
		this.removeFromParent(!0)
	},
	onExit: function() {
		this._super();
		cc.log("link ----- delete")
	}
});
var MainManager = {
	isPause: !1,
	canTouch: null,
	maxData: null,
	nowData: null,
	errorStr: null,
	linkData: null,
	init: function() {
		this.canTouch = !1;
		this.errorStr = "网络连接失败，请检查网络设置！";
		this.maxData = {};
		this.nowData = {}
	},
	gamePause: function() {
		this.isPause = !0;
		this.canTouch = !1;
		mainSelf && mainSelf.unscheduleUpdate();
		AudioManager.pauseMusic()
	},
	gameResume: function() {
		this.isPause = !1;
		this.canTouch = !0;
		mainSelf && mainSelf.scheduleUpdate();
		AudioManager.resumeMusic()
	},
	randomInt: function(b, c) {
		return b + Math.floor(Math.random() * (c - b + 1))
	},
	getDist: function(b, c, d, e) {
		return cc.pDistance(cc.p(b, c), cc.p(d, e))
	},
	gotoCover: function() {
		MainManager.loadGame();
		CW = cc.director.getVisibleSize().width;
		CH = cc.director.getVisibleSize().height;
		document.title = LanguageManager.getText("game_name")
	},
	loadGame: function() {
		cc.log("loadGame");
		HttpManager.register();
		MainManager.init();
		LanguageManager.init()
	},
	startGame: function() {
		cc.log("startGame");
		cc.director.runScene(new GameScene)
	},
	getLinkGame: function() {
		var b = {};
		b.language = cc.sys.language;
		HttpManager.instance.send("101", b, this.getLinkGameReturn, this)
	},
	getLinkGameReturn: function(b, c) {
		0 == b ? (this.linkData = c, MainLayer && MainLayer.addLinkGame()) : cc.log("获取失败")
	},
	testFunc: function() {}
},
	setO = 200;
var UIToolManager = {
	getSprite: function(b, c, d, e, f) {
		b = new cc.Sprite(b);
		null != c && null != d && b.setAnchorPoint(c, d);
		null != e && null != f && b.setPosition(e, f);
		return b
	},
	getLabelTTF: function(b, c, d, e, f, g, h) {
		b = new cc.LabelTTF("" + b, "Arial 粗体", c);
		b.setAnchorPoint(d, e);
		b.setPosition(f, g);
		null != h && b.setFontFillColor(h);
		return b
	},
	getTest: function() {}
};
var _lastAdTime = 0,
	_AdLayer = null,
	AdLayer = cc.Layer.extend({
		lis1: null,
		state: 1,
		ctor: function() {
			this._super()
		},
		setData: function() {
			cc.director.resume();
			_AdLayer = this;
			this.setState(1);
			this.createListener()
		},
		node: null,
		bgColor: null,
		init: function() {
			this.bg = new cc.DrawNode;
			this.bg.drawRect(cc.p(0, 0), cc.p(CW, CH), cc.color(0, 0, 0, 120), -1);
			this.addChild(this.bg);
			var b = cc.director.getVisibleSize().width / 720;
			this.node = new cc.Node;
			this.addChild(this.node);
			this.bgColor = new cc.DrawNode;
			this.bgColor.drawRect(cc.p(0, CH / 2 - 300 * b), cc.p(CW, CH / 2 + 300 * b), cc.color(0, 0, 0, 170), -1);
			this.node.addChild(this.bgColor);
			var c = UIToolManager.getSprite(res.ShareIcon_png, 0.5, 0.5, CW / 2 - 150 * b, CH / 2 + 50 * b);
			this.node.addChild(c);
			c.scale = b;
			c = UIToolManager.getSprite(res.BtnAd_png, 0.5, 0.5, CW / 2 + 200 * b, CH / 2 + 50 * b);
			this.node.addChild(c);
			c.scale = b;
			c = UIToolManager.getLabelTTF("继续", 40, 0.5, 0.5, c.x, c.y - 110 * b);
			this.node.addChild(c);
			c.scale = b;
			this.layerIn()
		},
		setLastShowAd: function() {
			_lastAdTime = (new Date).getTime() / 1000
		},
		getInterval: function() {
			var b = (new Date).getTime() / 1000 - _lastAdTime;
			cc.log("nt->" + b);
			return b
		},
		layerIn: function() {
			this.node.x = -CW;
			this.node.runAction(cc.sequence(cc.moveTo(0.3, 0, 0), cc.callFunc(this.setState.bind(this, 2))))
		},
		layerOut: function() {
			this.node.runAction(cc.sequence(cc.moveTo(0.3, -CW, 0), cc.callFunc(this.destroy.bind(this))))
		},
		createListener: function() {
			this.lis1 = cc.EventListener.create({
				event: cc.EventListener.TOUCH_ONE_BY_ONE,
				swallowTouches: !0,
				onTouchBegan: this.onTouchBegan.bind(this),
				onTouchMoved: this.onTouchMoved.bind(this),
				onTouchEnded: this.onTouchEnded.bind(this)
			});
			cc.eventManager.addListener(this.lis1, this)
		},
		removeListener: function() {
			cc.eventManager.removeListener(this.lis1);
			this.lis1 = null
		},
		onTouchBegan: function(b, c) {
			return !0
		},
		onTouchMoved: function(b, c) {},
		onTouchEnded: function(b, c) {
			2 == this.state && (this.state = 3, this.runAction(cc.sequence(cc.delayTime(2), cc.callFunc(this.layerOut.bind(this)))), this.setLastShowAd())
		},
		setState: function(b) {
			this.state = b;
			cc.log(this.state)
		},
		destroy: function() {
			this.stopAllActions();
			this.removeListener();
			this.removeAllChildren(!0);
			this.removeFromParent(!0)
		}
	});
var _languageManagerInstance, LanguageManager = {
	init: function() {
		if (!_languageManagerInstance) {
			switch (_languageManagerInstance = {}, cc.sys.language) {
			case cc.sys.LANGUAGE_CHINESE:
				_languageManagerInstance.data = language_Chinese;
				break;
			case cc.sys.LANGUAGE_KOREAN:
				_languageManagerInstance.data = language_Korean;
				break;
			case cc.sys.LANGUAGE_JAPANESE:
				_languageManagerInstance.data = language_Japanese;
				break;
			default:
				_languageManagerInstance.data = language_English
			}
		}
	},
	getText: function(b) {
		return _languageManagerInstance.data[b] ? _languageManagerInstance.data[b] : "NULL"
	}
};
var language_Chinese = {
	game_name: "乌鸦喝水",
	game_info: "乌鸦们口渴了～ 快用石子填满瓶子吧！",
	start: "开始游戏",
	link_top_tip: "别人都在玩 : ",
	game_center: "游戏中心"
};
var language_English = {
	game_name: "A Thirsty Bird",
	game_info: "The thirsty bird needs your help,click anywhere to fill the bottle with little stones,come on!",
	start: "Start",
	link_top_tip: "Others are playing : ",
	game_center: "Game center"
};
var language_Korean = {
	game_name: "목마르다 의 버 디",
	game_info: "버 디 들이 음료수 빨리 용 자갈 로 채 우 병 합 시다!",
	start: "부터 게임",
	link_top_tip: "남 들 은 놀 : ",
	game_center: "게임 센터"
};
var language_Japanese = {
	game_name: "渇きのバーディー",
	game_info: "鸟たちは喉が渇いたから、早く小石で埋め瓶ましょう!",
	start: "ゲームを始める",
	link_top_tip: "みんなで游んで : ",
	game_center: "ゲームの中心"
};
var PC_FLAG = !1,
	ChineseFlag = !1;
cc.game.onStart = function() {
	!cc.sys.isNative && document.getElementById("cocosLoading") && document.body.removeChild(document.getElementById("cocosLoading"));
	var b = cc.sys;
	cc.log("xitong" + b.os);
	b.os === b.OS_IOS || b.os === b.OS_OSX ? cc.view.enableRetina(!0) : cc.view.enableRetina(!1);
	cc.view.adjustViewPort(!0);
	b.os === b.OS_IOS || b.os === b.OS_ANDROID || b.os === b.OS_BLACKBERRY || b.os === b.OS_WP8 || b.os === b.OS_BADA ? cc.view.setDesignResolutionSize(480, 800, cc.ResolutionPolicy.FIXED_WIDTH) : (PC_FLAG = !0, cc.view.setDesignResolutionSize(480, 800, cc.ResolutionPolicy.SHOW_ALL));
	if (cc.sys.language == cc.sys.LANGUAGE_CHINESE) {
		if (!window.navigator.language) {
			ChineseFlag = !0
		} else {
			if ("zh-CN" == window.navigator.language || "zh-cn" == window.navigator.language) {
				ChineseFlag = !0
			}
		}
	}
	cc.view.resizeWithBrowserSize(!0);
	document.getElementById("loadingImg") && document.body.removeChild(document.getElementById("loadingImg"));
	MainManager.gotoCover();
	cc._loaderImage = "";
	cc.LoaderScene.preload(g_resources, function() {
		firstShow = !0;
		cc.director.runScene(new GameScene)
	}, this)
};
cc.game.run();