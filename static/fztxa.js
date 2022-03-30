kaygb_copy();
function kaygb_copy(){
    $(document).ready(function(){
        $("body").bind('copy',function(e){
            "" == (window.getSelection ? window.getSelection() : document.selection.createRange().text) ? 
        $.message({
            message: "请选择需要复制的内容！",
            title: "R0A1NG's Blog",
            type: "warning",
            autoHide: !1,
            time: "3000"
        }) : $.message({
                message: "本文作者：R0A1NG<br>原文链接：" + window.location.href,
                title: "复制成功",
                type: "success",
                autoHide: !1,
                time: "3000"
            })
        })
    });
}