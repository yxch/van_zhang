2015-09-18 9:42

//定义并调用一个函数来确定当前脚本运行时是否为严格模式
<script>
    "use strict";
    var strict = (function(){ return !this;}());
    alert(strict);
</script>

/*--------------------可选函数----------------------------*/
function counter(n){
	var n = 0;
	return {
		count:function(){ return n++; },
		reset:function(m){ if( m >= n ){ n = m; }else{ throw Error ("count can only be set to a larger value");} }
	}
}

/*--------------------f.js文件的全部内容------------------*/


//判断是否为空的函数
function empty(x)
{
    var type = typeof(x);
    switch(type)
    {
        case 'undefined': return true;
        case 'object':    for(var p in x){ return false;} return true;
        case 'string':    return x == ' ' || x == '';
        default:          return x.length == 0;
    }
}

//定义去字符串全部空格的函数
function trim(str)
{
    var ar = str.split('');
    var sar = [];
    for(var i=0,len=ar.length;i<len;i++){ if(ar[i] != ' '){ sar.push(ar[i]); } }
    return sar.join('');
}

//检查字符串是否全为中文
function isChinese(str){  var reg=/^[\u0391-\uFFE5]+$/;   return reg.test(str);  };

//通用函数 判定是否是一个数组
function isArray(o)
{
    if (typeof(o) == 'undefined') { return false; }
    return Function.isArray ? isArray(o) : typeof o === 'object' && Object.prototype.toString.call(o) === '[object Array]';
}

//检查数组中是否存在某个元素并返回在数组中出现的位置索引数组
function inArray(e,ar)
{
    var r = [];
    if ( typeof(ar) == 'undefined' || typeof(e) == 'undefined' || !isArray(ar) ) { return r;  }
    for( var i=0,len = ar.length;i<len;i++ ){ if (e == ar[i]){ r.push( i ); }  }
    return r;
}

//有限正整数
function positive(n) { return isFinite(n) && n > 0 && n == Math.round(n); }

//用非正则表达式的方式定义检查手机号码的格式是否正确的函数
function isMobile(str)
{
    var ar = str.split('');
    //第一位必须是1且长度必须是11
    if (ar.length != 11 || ar[0] != '1') { return false;}  
    //检查第二位数字
    var sar = ['3','4','5','7','8'];  //第二位可能的数字
    if (inArray(ar[1],sar).length == 0) { return false;}
    //如果第二位是4,第三位必须是5或7
    if (ar[1] == '4' && inArray(ar[2],['5','7']).length == 0 ) { return false; }      
    //检查剩下的9位数字
    var arr = ['0','1','2','3','4','5','6','7','8','9'];
    for(var i=2; i<11;i++){ if(inArray(ar[i],arr).length == 0 ) return false;}
    return true;
}

//在数据中查找指定值的索引
Array.prototype.indexOf = function(val)
{
    for(var i=0;i<this.length;i++){ if(this[i] == val) return i;}
};

//移除数组中指定值的元素并重复生成索引
Array.prototype.remove = function(val)
{
    var index = this.indexOf(val);
    if (index > -1) { this.splice(index,1);}
};

//定义去除数组重复值的函数
function unique(ar)
{
    if (typeof(ar) == 'undefined' || !isArray(ar)) { return [];}
    var a = {}; 
    for (var i=0,len=ar.length; i<len;i++){ if(typeof(a[ar[i]]) == 'undefined'){ a[ar[i]] = ''; } }
    var arr = [];
    for (var i in a){ arr.push(i); } 
    return arr; 
}

//去除数组的空值
function delArrayNull(ar)
{
    var r = [];
    if (typeof(ar) == 'undefined' || !isArray(ar)) { return [];}
    for(var i=0,len=ar.length;i<len;i++){ if(!empty(ar[i])){ r.push(ar[i]); } }
    return r;
}

//获取一个随机数
function random(min,max)
{
  min = min || 0;  //最小默认值
  max = max || 100; //最大默认值
  return parseInt(Math.random() * (max - min + 1) + min);   
}

//由name操作属性
function byName(name,tag)
{
    //得到对象 结果为对象数组(兼容ie5之后的版本)
    var r = document.getElementsByName(name);
    var my = [];
    if (r.length > 0)
    {
        for (var i = 0; i < r.length; i++){  my[my.length] = r[i]; } 
    }else
    {
        var r = document.getElementsByTagName(tag);
        if (r.length > 0){ for (var i = 0; i < r.length; i++){  if(r[i].getAttribute("name") == name){  my[my.length] = r[i]; }  } }
    }
    var o = new Object();
    
    //得到对象 某一个对象list(i)或者全部对象数组all
    o.list = function(i){ return parseInt(i) < r.length ? my[i] : new Object(); }
    o.all = function (){ return my;}
    
    //获取值 返回的是数组。注意对结果的处理
    o.val = function(attribute)
    {
        var ar = [];
        var attr = attribute || 'value';
        for(var j=0;j<my.length;j++)
        {
            if(my[j].type && (my[j].type == 'radio' || my[j].type == 'checkbox')){  if(my[j].checked) ar.push(my[j][attr]);}
            else if(my[j].type && my[j].type == 'text'){ ar.push(my[j][attr]);}
            else{ if(my[j].getAttribute(attr)) ar.push(my[j].getAttribute(attr));}
        }
        return  my.length == 1 ? ar[0] : ar;
    };
    
    //设置值
    o.set = function(value,attribute,index)
    {
        var attr = attribute || 'value';
        for(var j=0;j<my.length;j++)
        {
            if(my[j].getAttribute(attr))
            {
                var i = index && parseInt(index) ? parseInt(index) : 0;
                if(i < r.length){ if(i == j) my[j].setAttribute(attr,value); }else{ my[j].setAttribute(attr,value); }
            }
        }
    };
    
    //设置选中
    o.checked = function(i){ for(var j=0;j<my.length;j++){ if((my[j].type && my[j].type == 'radio' || my[i].type == 'checkbox') && j == i && !my[j].checked) my[j].checked = true; } };
    
    //checkbox的状态
    o.checkedAll = function(){for(var j=0;j<my.length;j++){ if(my[j].type && my[j].type == 'checkbox' && !my[j].checked) my[j].checked = true; } };
    o.checkedNot = function(){for(var j=0;j<my.length;j++){ if(my[j].type && my[j].type == 'checkbox' && my[j].checked) my[j].checked = false; } };
    o.checkedTog = function(){for(var j=0;j<my.length;j++){ if(my[j].type && my[j].type == 'checkbox') my[j].checked ? my[j].checked = false : my[j].checked = true; } };
    return o;
}

//操作cookie 设置cookie
function setCookie(name,value,days)
{
    var date = new Date();
	var d = days || 1;
    date.setDate(date.getDate() + d);
    document.cookie = name + "=" + escape(value) + "; expires=" + date.toGMTString();// + "; path="+location.pathname
}

//删除cookie
function delCookie (name){  document.cookie = name + "=;expires=" + (new Date(0)).toGMTString(); }

//获取cookie的值
function getCookie(name)
{
    var value = '';
    var search = name + '=';
    if (document.cookie.length > 0)
    {
       offset = document.cookie.indexOf(search);
       if (offset != -1)
       {
            offset += search.length;
            end = document.cookie.indexOf(';',offset);
            if (end == -1) { end = document.cookie.length;}
            value = unescape(document.cookie.substring(offset,end))
       }
    }
    return value;
    //另外一种方法
    //ar cookieArray = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
    //return cookieArray != null ? unescape(cookieArray[2]) : null;
}

//定义身份证验证及相关信息获取的函数
function IDC(id)
{
    var ck = 1;
    if (!id){ ck = 0; }  //如果没有提供id
    var cities = {11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"};
    var ar = id.split('');
    if (ar.length != 18) { ck = 0; } //第二代身份证长度为18位
    //检查第18位 第18位要么是数字要么是x|X
    var bits = ['0','1','2','3','4','5','6','7','8','9','x','X'];
    var isInBits = false;
    for(var i=0,len=bits.length;i<len;i++){ if(ar[17] == bits[i]){ isInBits = true; }}
    if (!isInBits) { ck = 0; }
    //检查身份证所在区域是否合法
    var region = parseInt(id.substr(0,2),10); 
    if (cities[region] == null || cities[region] == 'undefined') { ck = 0; }
    //检查出生日期
    var sBirthday = id.substr(6,4)+"/" + Number(id.substr(10,2)) + "/" + Number(id.substr(12,2));
    var d = new Date(sBirthday);
    if(sBirthday != (d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate())){ ck = 0; }
    //校验规则 如果第18位是X|x则替换成a
    var iSum = 0;
    if (ar[17] == 'x' || ar[17] == 'X' ){ id = id.substr(0,17) + 'a'; }
    for(var i=17;i>=0;i--){ iSum += (Math.pow(2,i) % 11) * parseInt(id.charAt(17 - i),11); }
    if(iSum % 11 != 1){ ck = 0; }
    
    //返回结果
    var obj = new Object();
    //校验是否通过 返回真或者假
    obj.verified = function (){ return ck == 1; }
    //返回出生日期
    obj.birthday = function(){ return ck == 1 ? sBirthday : null;}
    //获取性别 返回 F(女) 或者M(男) (第二代身份证的倒数第二位数表示性别，单数为男性，双数为女性。)
    obj.gender = function(){  if(ck ==1){ return ar[16] % 2 == 0 ? 'F' : 'M'; }else{ return null; } }
    //返回省份名称
    obj.province = function(){ return ck ==1 ? cities[region] : null; }
    //返回年龄 非精确
    obj.ages = function(){ return ck == 1 ? parseInt(new Date().getFullYear()) - parseInt(d.getFullYear()) : null; }
    //返回出生日期距离现在的天数
    obj.days = function()
    {
        if (ck == 1)
        {
            var time = parseInt(new Date().getTime() / 1000);
            var iTime = parseInt(new Date(sBirthday).getTime() / 1000);
            return parseInt((time - iTime) / (24 * 60 * 60));
        
        }else{ return null; }        
    }
    return obj;
}

//使用对象的方式获取URL参数的值返回一个对象
var href = (function()
{
    var obj = new Object();
    obj.search = window.location.search; //查询（参数）部分
    var pathname = window.location.pathname.substring(1); 
    //取得短路径
    var pathAr = pathname.split('/'); pathAr.length =  pathAr.length - 1;
    obj.dir = pathAr.join('/'); 
    //取得文件名
    obj.filename = obj.dir ? pathname.substring(obj.dir.length + 1) : pathname;
    //主机名称包括协议部分
    obj.phost = window.location.protocol + '//' + window.location.host + '/';
    //路径部分
    obj.path = obj.phost + (obj.dir ? obj.dir + '/' : '');       
    if (obj.search.indexOf("?") != -1)
    {
      var str = obj.search.substr(1);
      strs = str.split("&");
      for(var i=0; i<strs.length; i++) { obj[strs[i].split("=")[0]] = decodeURIComponent(strs[i].split("=")[1]); }
    }
    return obj;
})();
