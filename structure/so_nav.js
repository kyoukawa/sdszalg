$(".mainmenu").show();//v1.0.6新开功能 20230119

var txt = `
<span id="app"></span>
<span id="appnav">
<div class="row" style="justify-content:flex-start">
<a href="/" class="bigLogo"><img src="http://sdszalg.cn/files/logo_tiny.png" style="width:5rem;height:3rem;object-fit:contain;margin: 0 1rem 0 1rem;"></img></a>
<a href="/" class="bigLogoPH" style="display:none"><img src="http://sdszalg.cn/files/logo_tiny.png" style="width:2rem;height:2rem;object-fit:contain;margin: 0 0.1rem 0 0.5rem;"></img></a>

<el-menu style="width:100%" :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect" background-color="#F0F8FF">
  <!--<el-menu-item index="0"><span style="display:inline" class="navtitle center">首页</span></el-menu-item>-->
  

  
  <!--适配移动端！只改工el-menu这一个，加span就行-->
  <el-submenu index="101" class="PH1">
    <template slot="title" ><span style="display:inline" class="navtitle center toLoginTitle"><i class="el-icon-loading" style="line-height:3rem;"></i></span></template>
    <el-menu-item index="101-2"><a href="/login/signIn" class="navcontent center toLogin">登录</a></el-menu-item>
    <el-menu-item index="101-3"><a href="/login/signUp" class="navcontent center toReg">注册</a></el-menu-item>
  </el-submenu>
  <el-submenu index="102" class="PH2" style="display:none">
    <template slot="title" ><i class="el-icon-user-solid"></i><span style="display:inline" class="navtitle center username"></span></template>
    <el-menu-item index="102-1"><a href="/user/" class="navcontent center userCenter" style="display:none">个人中心</a></el-menu-item>
    <el-menu-item index="102-3"><a href="/mail/" class="navcontent center">信件</a></el-menu-item>
    <!--<el-menu-item index="102-2"><a href="javascript:void(0);" class="navcontent center exitLogin" onclick="exitL()" style="display:none">退出登录</a></el-menu-item>-->
  </el-submenu>

</el-menu>

<!--PC端-->
<span class="loginPC">
<el-menu style="width:auto" :default-active="activeIndex" class="el-menu-demo PC1" mode="horizontal" @select="handleSelect" background-color="#F0F8FF" text-color="#000000">
  <el-submenu index="101">
    <template slot="title" ><span style="display:inline" class="navtitle center toLoginTitle"><i class="el-icon-loading" style="line-height:3rem;"></i></span></template>
    <el-menu-item index="101-2"><a href="/login/signIn" class="navcontent center toLogin">登录</a></el-menu-item>
    <el-menu-item index="101-3"><a href="/login/signUp" class="navcontent center toReg">注册</a></el-menu-item>
  </el-submenu>
</el-menu>
<el-menu style="width:auto;display:none" :default-active="activeIndex" class="el-menu-demo PC2" mode="horizontal" @select="handleSelect" background-color="#F0F8FF" text-color="#000000">
  <el-submenu index="102">
    <template slot="title" ><i class="el-icon-user-solid"></i><span style="display:inline" class="navtitle center username" style="display:none"></span></template>
    <el-menu-item index="102-4"><a href="/user/" class="navcontent center" >个人中心</a></el-menu-item>
    <el-menu-item index="102-3"><a href="/mail/" class="navcontent center" >信件</a></el-menu-item>
    <!--<el-menu-item index="102-1"><a href="javascript:void(0);" class="navcontent center exitLogin" onclick="exitL()" style="display:none">退出登录</a></el-menu-item>-->
  </el-submenu>
</el-menu>
</span>

</div>
</span>
`;

function exitL() {
  localStorage.removeItem("userInfo");
  window.location.reload();
}
function createip() {
  var ip = localStorage.getItem("soip")
  if ((typeof ip) == 'string') {
    return ip;
  }
  var s = ''
  for (var i = 1; i <= 6; i++) {
    s += String.fromCharCode(97 + Math.floor(Math.random() * 26));
  }
  localStorage.setItem("soip", s)
  console.log(s)
  return s;
}

function showNav() {
  $(".toLoginTitle").html("登录/注册");
  var ip = createip()
  console.log('ip:', ip)
  $(".mainmenu").show();
  var userInfo = localStorage.getItem("userInfo");
  if ((typeof userInfo) != 'string') {
    $.post("/back/getIPToken.php", { 'type': 'e', 'ip': ip, 'location': 'unknown' }, function (res2) {
      console.log(res2)
      var ret2 = JSON.parse(res2);
      if (ret2['status'] != 'success') {
        alert(ret2['msg']);
        allReady();
      }
      else {
        localStorage.setItem("userInfo", ret2['msg']);
        allReady();
        userInfo = localStorage.getItem("userInfo")
        console.log("newuserinfo:", userInfo)
      }
    })
  }
  else {
    $.post("/back/updateToken.php", { 'token': userInfo }, function (res2) {//20230116添加
      console.log("updateToken:" + res2)
      var ret2 = JSON.parse(res2);
      if (ret2['status'] != 'success') {
        alert(ret2['msg']);
        console.log("cs")
      }
      else {
        localStorage.setItem("userInfo", ret2['msg']);
      }
      allReady();
    })
  }

  $.post("/back/getIPToken.php", { 'type': 'e', 'ip': ip, 'location': 'unknown' }, function (res2) {
    console.log(res2)
    var ret2 = JSON.parse(res2);
    if (ret2['status'] != 'success') {
      alert(ret2['msg']);
    }
    else {
      localStorage.setItem("ipToken", ret2['msg']);
    }
  })

}
function setUserName(name) {
  var innerWidth = $(window).width();		//获得浏览器宽度
  if (innerWidth <= 750) {					//判断浏览器宽度小于750跳转到移动端页面
    $(".PH1").hide(); $(".PH2").show();
    $(".PC1").hide(); $(".PC2").hide();
  }
  else {
    $(".PC1").hide(); $(".PC2").show();
    $(".PH1").hide(); $(".PH2").hide();
  }
  $(".exitLogin").show();
  $(".userCenter").show();
  $(".username").show();
  $(".username").html("" + name);
  $(".toLogin").hide();
  $(".toReg").hide();
}
var namecache = [];
function setLoading(name, title) {
  namecache[name] = $(name).html();
  var addh = '<span class="loader-1"></span>'
  $(name).html(addh + title)
  $(name).attr("disabled", "disabled")
  console.log(namecache)
}
function removeLoading(name) {
  $(name).html(namecache[name])
  $(name).removeAttr("disabled")
}
function getUrlParam(name) {
  var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
  var r = window.location.search.substr(1).match(reg);  //匹配目标参数
  if (r != null) return unescape(r[2]); return null; //返回参数值
}
function myDecodeURI(q) {
  return decodeURIComponent(q.replace(/\+/g, '%20'))
}
$(document).ready(function () {
  console.log('onload!')

  var userInfo = localStorage.getItem("userInfo");
  console.log(userInfo)
  var ip = createip()
  if ((typeof userInfo) == 'string') {
    $.post("/back/getRealInfo.php", { 'token': userInfo, 'type': 'e', 'ip': ip, 'location': 'unknown' }, function (resi) {
      console.log(resi)
      var ret = JSON.parse(resi);
      console.log('ds' + typeof ret)
      if (ret['status'] != 'success') {
        alert(ret['msg']);
        exitL()
        showNav()
      }
      else {
        var realinfo = JSON.parse(ret['msg']);
        if ((typeof ret['isip']) != 'string') {
          console.log(realinfo)
          setUserName(realinfo['name'])
          showNav()
        }
        else {
          $.post("/back/getIPToken.php", { 'type': 'e', 'ip': ip, 'location': 'unknown' }, function (res2) {
            console.log(res2)
            var ret2 = JSON.parse(res2);
            if (ret2['status'] != 'success') {

              alert(ret2['msg']);
              console.log("cs")
            }
            else {
              localStorage.setItem("userInfo", ret2['msg']);
            }
            showNav()
          })
        }
      }
    })
  }
  else {
    showNav()
  }
})
$(".mainmenu").html(txt);

$(".navchoose").hover(
  function (event) {
    var tg = event.currentTarget;
    console.log(tg)
    var nxt = tg.getElementsByTagName("ul")[0].getElementsByTagName("div")[0];
    nxt.style.display = "block"
  },
  function () {
    var tg = event.currentTarget;
    var nxt = tg.getElementsByTagName("ul")[0].getElementsByTagName("div")[0];
    nxt.style.display = "none"
  }
);

// Hide logo
var innerWidth = $(window).width();		//获得浏览器宽度
if (innerWidth <= 750) {					//判断浏览器宽度小于750跳转到移动端页面
  $(".bigLogo").hide();
  $(".bigLogoPH").show();
  /*$(".loginPC").hide();
  $(".PhoneA").show()
  $(".PhoneB").show()
  $(".exitLogin").hide()*/
}
//设置初始未登录
if (innerWidth <= 750) {
  $(".PH1").show(); $(".PH2").hide();
  $(".PC1").hide(); $(".PC2").hide();
}
else {
  $(".PC1").show(); $(".PC2").hide();
  $(".PH1").hide(); $(".PH2").hide();
}
var vm = new Vue({
  el: '#appnav',
  data: function () {
    return { activeIndex: nowpageid }
  },
  methods: {
    handleSelect(key, keyPath) {
      console.log(typeof key, keyPath);
      if (key == '0') {
        window.location.href = '/'
      }
      else if (key == '1') {
        window.location.href = '/ai/'
      }
    }
  }
})
