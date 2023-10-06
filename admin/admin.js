var nowpageid = "admin"
wjArr = []
var vmn = new Vue({
    el: '#app',
    data: function () {
        return {
            userData: {
                name: 'loading...'
            },
            centerDialogVisible: false,
            form: { userName: "", userTag: "" },
            isloading: false,
        }
    },
    methods: {
        exitL() {
            localStorage.removeItem("userInfo");
            window.location.href = "/"
        }
        ,

        changeTag() {
            var userInfo = localStorage.getItem("userInfo");
            console.log(userInfo)
            var userName = vmn.form.userName;
            var userTag = vmn.form.userTag;
            $.post("changeTag.php", { 'userName': userName, 'userTag': userTag }, function (res) {
                console.log(res)
                var ret = JSON.parse(res);
                //removeLoading(".subLogin")
                vmn.isloading = false;
                if (ret['status'] != 'success') {
                    vm.$alert(ret['msg'], {
                        type: 'error',
                    })
                    //alert(ret['msg']);
                }
                else {
                    alert("修改成功")
                }
            })
        }
    }

})

var clipboard = new ClipboardJS('.btn');
clipboard.on('success', function (e) {
    vm.$alert("复制成功", {
        type: 'success',
    })
});
clipboard.on('error', function (e) {
    vm.$alert("复制失败", {
        type: 'error',
    })
});
function allReady() {
    var userInfo = localStorage.getItem("userInfo");

    console.log(userInfo)
    if ((typeof userInfo) == 'string') {
        var wjid = getUrlParam("wjid");
        $.post("/back/user/getUserData.php", { "token": userInfo, "type": "r" }, function (res) {
            console.log(res)
            var ret = JSON.parse(res);
            if (ret['status'] != 'success' || ret['msg'].tag != 'admin') {
                alert("请登录管理员账号")
                window.location.href = '/login/signIn/?redir=/admin/'
            }
            else {
                console.log(ret['msg'])
                vmn.userData = ret['msg']
            }
        })
    }
    else {
        alert("请登录后查看个人中心")
        window.location.href = '/login/?redir=/user/'
    }

}
