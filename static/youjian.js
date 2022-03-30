(function(a) {
        a.extend({
            mouseMoveShow: function(b) {
                var d = 0,
                    c = 0,
                    h = 0,
                    k = 0,
                    e = 0,
                    f = 0;
                a(window).mousemove(function(g) {
            d = a(window).width();
            c = a(window).height();
            h = g.clientX;
            k = g.clientY;
            e = g.pageX;
            f = g.pageY;
            h + a(b).width() >= d && (e = e - a(b).width() - 5);
            k + a(b).height() >= c && (f = f - a(b).height() - 5);
            a("html").on({
                contextmenu: function(c) {
                    3 == c.which && a(b).css({
                        left: e,
                        top: f
                    }).show()
                },
                click: function() {
                    a(b).hide()
                }
            })
        })
    },
            disabledContextMenu: function() {
                window.oncontextmenu = function() {
                    return !1
                }
            }
        })
    })(jQuery);
  
    function getSelect() {
        "" == (window.getSelection ? window.getSelection() : document.selection.createRange().text) ? 
        $.message({
            message: "请选择需要复制的内容！",
            title: "R0A1NG's Blog",
            type: "warning",
            autoHide: !1,
            time: "3000"
        }) : ($.message({
                message: "尊重原创，转载请注明出处！<br> 本文作者：R0A1NG<br>原文链接：" + window.location.href,
                title: "复制成功",
                type: "success",
                autoHide: !1,
                time: "3000"
            }),document.execCommand("Copy"))
        
    }
    function baiduSearch() {
        var a = window.getSelection ? window.getSelection() : document.selection.createRange().text;
        "" == a ? $.message({
            message: "请选择需要百度的内容！",
            title: "R0A1NG's Blog",
            type: "warning",
            autoHide: !1,
            time: "15000"
        }) : window.open("https://www.baidu.com/s?wd=" + a)
    }
    function googleSearch() {
        var a = window.getSelection ? window.getSelection() : document.selection.createRange().text;
        "" == a ? $.message({
            message: "请选择需要谷歌的内容！",
            title: "R0A1NG's Blog",
            type: "warning",
            autoHide: !1,
            time: "15000"
        }) : window.open("https://www.google.com/search?q=" + a)
    }
    $(function() {
        for (var a = navigator.userAgent, b = "Android;iPhone;SymbianOS;Windows Phone;iPad;iPod".split(";"), d = !0, c = 0; c < b.length; c++) if (0 < a.indexOf(b[c])) {
            d = !1;
            break;
        }
        d && ($.mouseMoveShow(".usercm"), $.disabledContextMenu())
    });

// 禁止右键
document.oncontextmenu=function(){ 
    return false;
};