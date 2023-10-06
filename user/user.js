var nowpageid = "user"
wjArr = []
var vmn = new Vue({
    el: '#app',
    data: function () {
        return {
            userData: {
                name: 'loading...'
            },
            centerDialogVisible: false,
            form: { oldPassword: "", newPassword: "", confirmPassword: "" },
            isloading: false,
        }
    },
    methods: {
        exitL() {
            localStorage.removeItem("userInfo");
            window.location.href = "/"
        }
        ,
        changePassword() {
            var userInfo = localStorage.getItem("userInfo");
            console.log(userInfo)
            var oldPassword = vmn.form.oldPassword;
            var newPassword = vmn.form.newPassword;
            var confirmPassword = vmn.form.confirmPassword;
            var userName = vmn.userData.name;
            var correctOldPassword = vmn.userData.password;
            if (newPassword == '') {
                alert("密码不能为空")
                return;
            }
            if (newPassword != confirmPassword) {
                alert("确认密码与新密码不一致")
                return;
            }
            if (oldPassword != correctOldPassword) {
                alert("密码错误")
                return;
            }
            $.post("changePassword.php", { 'userName': userName, 'oldPassword': oldPassword, 'password': newPassword }, function (res) {
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
                    alert("修改成功, 请重新登录")
                    localStorage.removeItem("userInfo");
                    window.location.href = '/login/signIn'
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
            if (ret['status'] != 'success') {
                alert("请登录后查看个人中心")
                window.location.href = '/login/signIn/?redir=/user/'
            }
            else if (ret['status'] != 'success') {
                vm.$alert(ret['msg'], {
                    type: 'error',
                })
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
