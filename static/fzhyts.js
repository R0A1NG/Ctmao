if(window.name == ""){
    $(function () {
        $.ajax({
        	type: "get",
        	url: "https://api.roaing.com/clientinfo/",
        	async: true,
        	success: function (data) {
        	    window.info = data;
        	    var loccc = window.info.data.location;
                $.message({
                    message: "欢迎来自" + loccc + "的小伙伴<br>您的IP为" + window.info.data.ip,
                    title: "网站加载完成",
                    type: "success",
                    autoHide: !1,
                    time: "5000"
                })
        	}
        })
    })
    window.name = "isReload";
}