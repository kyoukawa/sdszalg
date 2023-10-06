var nowpageid = "100-3"
vmn = new Vue({
    el: '#appnew',
    data: function () {
        return { isloading: false }
    },
    methods: {

    }
})
function allReady() {
    $("#form").on("submit", function () {
        var userName = $("#form").find("input.userName").val();
        var password = $("#form").find("input.password").val();
        // setLoading(".subLogin", "正在登录……")
        vmn.isloading = true;
        //alert("login.js")
        $.post("signUp.php", { 'userName': userName, 'password': password }, function (res) {
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
                vm.$alert('注册成功, 请登录', {
                    type: 'success'
                }).then(() => {
                    //alert('登录成功')
                    //alert(ret['msg']);
                    //localStorage.setItem("userInfo", ret['msg']);
                    var tolink = '/login/signIn'
                    if (typeof getUrlParam("redir") == 'string')
                        tolink = getUrlParam("redir")
                    window.location.href = tolink
                })

            }
        })
        return false;
    })
}
