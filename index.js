var nowpageid = "0"
var vm = new Vue({
    el: '#app',
    data: function () {
        return {
            visible: false,
            pics: [
                "https://oss.sunorange.cn/SO_D_2.png",
                "https://oss.sunorange.cn/SO_D_1.png",
                "https://oss.sunorange.cn/SO_D_3.png",
            ],
            dialogVisible1: false,
            windowHeight80p: document.documentElement.clientHeight * 0.3 + 'px',
        }
    },
    methods: {

        roadmapRowClassName({ row, rowIndex }) {
            if (row.status == "Done") {
                return 'success-row';
            }
            else if (row.status == "Waiting") {
                return '';
            }
            else if (row.status == "Delay") {
                return 'error-row';
            }
            return 'warning-row';
        }
    }
})
function allReady() {
    if (typeof getUrlParam("wjid") == 'string') {
        var wjid = getUrlParam("wjid");
        window.location.href = "/wj/a.html?wjid=" + wjid;
    }
    /*
    console.log(Date.now())
    $("#form").on("submit",function(){
      var vc = document.getElementById("subbtn");
      vc.setAttribute("disabled","disabled");
      var userName=$("#form").find("input.userName").val();
      var password=$("#form").find("input.password").val();
      var email=$("#form").find("input.email").val();
      $.post("/back/loginVeri.php",{'userName':userName,'password':password,'email':email},function(res){
          var ret = JSON.parse(res);
          
          if(ret['status'] != 'success'){
              alert(ret['msg']);
              //alert(ret);
          }
          else
          {
            alert('登录成功')
            //alert(ret['msg']);
            localStorage.setItem("userInfo", ret['msg']);
            window.location.href='/'
          }
          vc.removeAttribute("disabled");
      })
      return false;
    })
    */
}