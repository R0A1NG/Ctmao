function checkDebugger(){
    var d=new Date();debugger;
    var dur=Date.now()-d;
    if(dur<5){
        return false
    }else{
        return true
    }
}
function breakDebugger(){
    if(checkDebugger()){
        breakDebugger()
    }
};
breakDebugger();
document.onkeydown = function() {
    if (window.event && window.event.keyCode == 123) {
        $.message({
            message: "啊这，要干啥？",
            title: "R0A1NG's Blog",
            type: "warning",
            autoHide: !1,
            time: "3000"
        });
        event.keyCode = 0;
        event.returnValue = false
    }
    var e = window.event || arguments[0];
    if(e.ctrlKey && e.shiftKey && e.keyCode == 73){    //屏蔽Ctrl+Shift+I，等同于F12
        $.message({
            message: "啊这，要干啥？",
            title: "R0A1NG's Blog",
            type: "warning",
            autoHide: !1,
            time: "3000"
        });
        event.keyCode = 0;
        event.returnValue = false
    }
};