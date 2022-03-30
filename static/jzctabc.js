window.addEventListener('keydown', function (e) {
    if(e.keyCode == 83 && (navigator.platform.match('Mac') ? e.metaKey : e.ctrlKey)){
        e.preventDefault();
        $.message({
            message: "不让你Ctrl+s，你该怎么保存",
            title: "R0A1NG's Blog",
            type: "warning",
            autoHide: !1,
            time: "3000"
        });
    }
})