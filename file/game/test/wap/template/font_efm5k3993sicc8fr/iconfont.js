(function(window){var svgSprite="<svg>"+""+'<symbol id="icon-back" viewBox="0 0 1024 1024">'+""+'<path d="M671.968 912c-12.288 0-24.576-4.672-33.952-14.048L286.048 545.984c-18.752-18.72-18.752-49.12 0-67.872l351.968-352c18.752-18.752 49.12-18.752 67.872 0 18.752 18.72 18.752 49.12 0 67.872l-318.016 318.048 318.016 318.016c18.752 18.752 18.752 49.12 0 67.872C696.544 907.328 684.256 912 671.968 912z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-discover" viewBox="0 0 1024 1024">'+""+'<path d="M544 288c0-52.928-43.072-96-96-96s-96 43.072-96 96 43.072 96 96 96S544 340.928 544 288zM416 288c0-17.632 14.368-32 32-32s32 14.368 32 32-14.368 32-32 32S416 305.632 416 288z"  ></path>'+""+'<path d="M304 448C259.904 448 224 483.904 224 528 224 572.128 259.904 608 304 608s80-35.872 80-80C384 483.904 348.096 448 304 448zM304 544C295.168 544 288 536.832 288 528S295.168 512 304 512s16 7.168 16 16S312.832 544 304 544z"  ></path>'+""+'<path d="M640 736m-64 0a2 2 0 1 0 128 0 2 2 0 1 0-128 0Z"  ></path>'+""+'<path d="M887.84 268.672c39.744-60.672 64.256-113.184 64.224-148.96 0-22.976-9.312-36.928-17.12-44.576-38.08-37.376-110.016-3.2-160.768 25.664-15.328 8.736-20.704 28.288-11.968 43.648 8.736 15.36 28.32 20.704 43.648 11.968 49.408-28.16 73.248-33.088 82.496-33.696-1.504 41.376-95.328 202.432-330.208 433.504-226.368 222.72-398.656 324.672-442.24 325.376 0.96-11.36 8.768-44.448 58.528-118.688 1.312-1.888 2.4-3.968 3.232-6.144l2.304-5.92c0.256-0.64 0.288-1.344 0.512-2.016 8.8-10.24 10.816-25.088 3.392-37.248C147.328 651.616 128 582.592 128 512 128 300.256 300.256 128 512 128c59.296 0 116.096 13.12 168.864 39.04 15.936 7.776 35.04 1.184 42.816-14.656 7.776-15.84 1.248-35.008-14.624-42.816C647.424 79.328 581.12 64 512 64 264.96 64 64 264.96 64 512c0 76.064 19.488 150.496 56.064 216.64-0.192 0.576-0.64 1.056-0.8 1.632C51.168 832.608 35.2 895.68 68.928 928.768c11.008 10.784 25.632 15.584 43.072 15.584 39.328 0 92.864-24.928 150.08-60.896C336.096 933.408 421.952 960 512 960c247.04 0 448-200.96 448-448C960 424.864 934.912 341.248 887.84 268.672zM512 896c-68.288 0-133.728-17.888-191.84-51.552 128.288-92.256 258.432-218.56 282.848-242.624 89.152-87.712 178.56-187.04 244.64-275.968C879.2 382.592 896 446.112 896 512 896 723.744 723.744 896 512 896z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-list" viewBox="0 0 1024 1024">'+""+'<path d="M896 256l-288 0c-17.696 0-32-14.336-32-32s14.304-32 32-32l288 0c17.696 0 32 14.336 32 32S913.696 256 896 256z"  ></path>'+""+'<path d="M896 416l-288 0c-17.696 0-32-14.336-32-32s14.304-32 32-32l288 0c17.696 0 32 14.336 32 32S913.696 416 896 416z"  ></path>'+""+'<path d="M896 672l-288 0c-17.696 0-32-14.304-32-32s14.304-32 32-32l288 0c17.696 0 32 14.304 32 32S913.696 672 896 672z"  ></path>'+""+'<path d="M896 832l-288 0c-17.696 0-32-14.304-32-32s14.304-32 32-32l288 0c17.696 0 32 14.304 32 32S913.696 832 896 832z"  ></path>'+""+'<path d="M384 480 192 480c-52.928 0-96-43.072-96-96L96 192c0-52.928 43.072-96 96-96l192 0c52.928 0 96 43.072 96 96l0 192C480 436.928 436.928 480 384 480zM192 160C174.368 160 160 174.368 160 192l0 192c0 17.632 14.368 32 32 32l192 0c17.632 0 32-14.368 32-32L416 192c0-17.632-14.368-32-32-32L192 160z"  ></path>'+""+'<path d="M384 928 192 928c-52.928 0-96-43.072-96-96l0-192c0-52.928 43.072-96 96-96l192 0c52.928 0 96 43.072 96 96l0 192C480 884.928 436.928 928 384 928zM192 608c-17.632 0-32 14.336-32 32l0 192c0 17.664 14.368 32 32 32l192 0c17.632 0 32-14.336 32-32l0-192c0-17.664-14.368-32-32-32L192 608z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-more" viewBox="0 0 1024 1024">'+""+'<path d="M224 608c-52.928 0-96-43.072-96-96s43.072-96 96-96c52.928 0 96 43.072 96 96S276.928 608 224 608z"  ></path>'+""+'<path d="M512 608c-52.928 0-96-43.072-96-96s43.072-96 96-96c52.928 0 96 43.072 96 96S564.928 608 512 608z"  ></path>'+""+'<path d="M800 608c-52.928 0-96-43.072-96-96s43.072-96 96-96c52.928 0 96 43.072 96 96S852.928 608 800 608z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-home" viewBox="0 0 1024 1024">'+""+'<path d="M96 480c-9.6 0-19.2-3.2-25.6-12.8-12.8-12.8-9.6-35.2 3.2-44.8l377.6-310.4c35.2-25.6 86.4-25.6 118.4 0l377.6 307.2c12.8 9.6 16 32 3.2 44.8-12.8 12.8-32 16-44.8 3.2L531.2 166.4c-9.6-6.4-28.8-6.4-38.4 0L115.2 473.6c-6.4 6.4-12.8 6.4-19.2 6.4zM816 928H608c-19.2 0-32-12.8-32-32v-150.4c0-22.4-38.4-44.8-67.2-44.8-28.8 0-64 19.2-64 44.8V896c0 19.2-12.8 32-32 32H211.2C163.2 928 128 892.8 128 848V544c0-19.2 12.8-32 32-32s32 12.8 32 32v304c0 9.6 6.4 16 19.2 16H384v-118.4c0-64 67.2-108.8 128-108.8s131.2 44.8 131.2 108.8V864h176c9.6 0 16 0 16-19.2V544c0-19.2 12.8-32 32-32s32 12.8 32 32v304C896 896 864 928 816 928z" fill="#666666" ></path>'+""+"</symbol>"+""+'<symbol id="icon-choiceness" viewBox="0 0 1024 1024">'+""+'<path d="M960.192 361.152l-104.288-246.048c-5.024-11.84-16.64-19.52-29.472-19.52L232.032 95.584c-11.68 0-22.4 6.368-28.032 16.576l-133.44 242.592c-6.24 11.328-5.056 25.248 2.976 35.328l417.952 525.376c6.08 7.648 15.296 12.096 25.056 12.096l0 0c9.76 0 18.976-4.48 25.056-12.096l414.176-521.952C963.072 384.352 964.736 371.936 960.192 361.152zM741.92 159.552l-226.336 182.592L308.256 159.552 741.92 159.552zM238.048 183.008 429.92 352 224 352c-17.664 0-32 14.336-32 32s14.336 32 32 32l256 0 0 382.24L136.896 366.912 238.048 183.008zM544 809.472 544 416l256 0c17.696 0 32-14.336 32-32s-14.304-32-32-32l-194.72 0 209.824-169.248 78.752 185.856L544 809.472z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-focus" viewBox="0 0 1024 1024">'+""+'<path d="M512 384c-70.592 0-128 57.408-128 128 0 70.592 57.408 128 128 128 70.592 0 128-57.408 128-128C640 441.408 582.592 384 512 384zM512 576c-35.296 0-64-28.704-64-64 0-35.296 28.704-64 64-64 35.296 0 64 28.704 64 64C576 547.296 547.296 576 512 576z"  ></path>'+""+'<path d="M928 480l-0.928 0C911.424 275.776 748.224 112.576 544 96.928L544 96c0-17.664-14.336-32-32-32s-32 14.336-32 32l0 0.928C275.776 112.576 112.576 275.776 96.928 480L96 480c-17.664 0-32 14.336-32 32s14.336 32 32 32l0.928 0C112.576 748.224 275.776 911.424 480 927.072L480 928c0 17.696 14.336 32 32 32s32-14.304 32-32l0-0.928C748.224 911.424 911.424 748.224 927.072 544L928 544c17.696 0 32-14.336 32-32S945.696 480 928 480zM544 863.072 544 800c0-17.696-14.336-32-32-32s-32 14.304-32 32l0 63.072C311.04 847.776 176.224 712.928 160.928 544L224 544c17.664 0 32-14.336 32-32s-14.336-32-32-32L160.928 480C176.224 311.04 311.04 176.224 480 160.928L480 224c0 17.664 14.336 32 32 32s32-14.336 32-32L544 160.928C712.928 176.224 847.776 311.04 863.072 480L800 480c-17.696 0-32 14.336-32 32s14.304 32 32 32l63.072 0C847.776 712.928 712.928 847.776 544 863.072z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-people" viewBox="0 0 1024 1024">'+""+'<path d="M800 384c0-160-128-288-288-288s-288 128-288 288c0 108.8 57.6 201.6 147.2 249.6-121.6 48-214.4 153.6-240 288-3.2 16 6.4 35.2 25.6 38.4h6.4c16 0 28.8-9.6 32-25.6 28.8-150.4 160-259.2 313.6-262.4h6.4c156.8 0 284.8-128 284.8-288zM288 384c0-124.8 99.2-224 224-224s224 99.2 224 224c0 121.6-99.2 220.8-220.8 224H505.6C384 604.8 288 505.6 288 384zM723.2 675.2c-16-9.6-35.2-6.4-44.8 9.6-9.6 16-6.4 35.2 9.6 44.8 73.6 51.2 124.8 121.6 140.8 204.8 3.2 16 16 25.6 32 25.6h6.4c16-3.2 28.8-19.2 25.6-38.4-19.2-99.2-80-185.6-169.6-246.4z" fill="#666666" ></path>'+""+"</symbol>"+""+'<symbol id="icon-zhinan" viewBox="0 0 1024 1024">'+""+'<path d="M128.576 490.666667H192c11.776 0 21.333333 9.472 21.333333 21.333333 0 11.776-9.472 21.333333-21.333333 21.333333H128.576C139.264 728.426667 295.573333 884.736 490.666667 895.424V832c0-11.861333 9.557333-21.333333 21.333333-21.333333 11.861333 0 21.333333 9.557333 21.333333 21.333333v63.424c195.093333-10.688 351.402667-166.997333 362.090667-362.090667H832c-11.776 0-21.333333-9.472-21.333333-21.333333 0-11.776 9.472-21.333333 21.333333-21.333333h63.424C884.736 295.573333 728.426667 139.264 533.333333 128.576V192c0 11.776-9.472 21.333333-21.333333 21.333333-11.776 0-21.333333-9.472-21.333333-21.333333V128.576C295.573333 139.264 139.264 295.573333 128.576 490.666667zM512 938.666667C276.352 938.666667 85.333333 747.648 85.333333 512S276.352 85.333333 512 85.333333s426.666667 191.018667 426.666667 426.666667-191.018667 426.666667-426.666667 426.666667z m185.621333-632.32a14.464 14.464 0 0 1 20.053334 20.053333l-154.666667 232.533333a14.72 14.72 0 0 1-4.053333 4.053334l-232.597334 154.709333a14.485333 14.485333 0 0 1-20.053333-20.053333l154.709333-232.597334a14.4 14.4 0 0 1 4.053334-4.032L697.6 306.346667zM370.218667 653.781333l170.304-113.28-57.024-57.002666-113.28 170.282666z" fill="#3D3D3D" ></path>'+""+"</symbol>"+""+"</svg>";var script=function(){var scripts=document.getElementsByTagName("script");return scripts[scripts.length-1]}();var shouldInjectCss=script.getAttribute("data-injectcss");var ready=function(fn){if(document.addEventListener){if(~["complete","loaded","interactive"].indexOf(document.readyState)){setTimeout(fn,0)}else{var loadFn=function(){document.removeEventListener("DOMContentLoaded",loadFn,false);fn()};document.addEventListener("DOMContentLoaded",loadFn,false)}}else if(document.attachEvent){IEContentLoaded(window,fn)}function IEContentLoaded(w,fn){var d=w.document,done=false,init=function(){if(!done){done=true;fn()}};var polling=function(){try{d.documentElement.doScroll("left")}catch(e){setTimeout(polling,50);return}init()};polling();d.onreadystatechange=function(){if(d.readyState=="complete"){d.onreadystatechange=null;init()}}}};var before=function(el,target){target.parentNode.insertBefore(el,target)};var prepend=function(el,target){if(target.firstChild){before(el,target.firstChild)}else{target.appendChild(el)}};function appendSvg(){var div,svg;div=document.createElement("div");div.innerHTML=svgSprite;svgSprite=null;svg=div.getElementsByTagName("svg")[0];if(svg){svg.setAttribute("aria-hidden","true");svg.style.position="absolute";svg.style.width=0;svg.style.height=0;svg.style.overflow="hidden";prepend(svg,document.body)}}if(shouldInjectCss&&!window.__iconfont__svg__cssinject__){window.__iconfont__svg__cssinject__=true;try{document.write("<style>.svgfont {display: inline-block;width: 1em;height: 1em;fill: currentColor;vertical-align: -0.1em;font-size:16px;}</style>")}catch(e){console&&console.log(e)}}ready(appendSvg)})(window)