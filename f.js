2015-09-18 9:42

 <script type="text/javascript">
        window.onbeforeunload = closed;
        function closed()
        {
            if(document.all){
                if(event.clientY<0)
                {
                    $.post('index.php',{"username":'aaa'},function(r){console.log(r);});
                    return '';
                }
            }else
            {
                $.post('index.php',{"username":'aaa'},function(r){console.log(r);});
                return '';                
            }
        }
</script>

===============================验证IDC==================================================

//检验身份证
    function isIdCard(idnumber)
    {
        var isRight = 0;
        if (idnumber == "" || idnumber == "undefined")
        {
            isRight = 1;
        }else
        { 
            var flag=true;
            var iSum=0 ;
            var aCity={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"};
            if(!/^\d{17}(\d|x)$/i.test(idnumber)) flag=false; 
            idnumber=idnumber.replace(/x$/i,"a"); 
            if(aCity[parseInt(idnumber.substr(0,2),10)]==null) flag=false; 
            var sBirthday=idnumber.substr(6,4)+"-"+Number(idnumber.substr(10,2))+"-"+Number(idnumber.substr(12,2)); 
            var d=new Date(sBirthday.replace(/-/g,"/")) ;
            if(sBirthday!=(d.getFullYear()+"-"+ (d.getMonth()+1) + "-" + d.getDate()))flag=false; 
            for(var i = 17;i>=0;i --) iSum += (Math.pow(2,i) % 11) * parseInt(idnumber.charAt(17 - i),11) ;
            if(iSum%11!=1) flag=false; 
            if(!flag){
                isRight = 2;
            }
        }
        return isRight;
    }

===============================验证IDC==================================================

 
 ===============================时间对象==================================================  
    
    /**
    * 时间对象的格式化;
    */
    
    Date.prototype.format = function(format){
     /*
      * eg:format="YYYY-MM-dd hh:mm:ss";
      */
        var o = {
            "M+": this.getMonth()+1,  //month
            "d+": this.getDate(),     //day
            "h+": this.getHours(),    //hour
            "m+": this.getMinutes(),  //minute
            "s+": this.getSeconds(), //second
            "q+": Math.floor((this.getMonth()+3)/3),  //quarter
            "S" : this.getMilliseconds() //millisecond
        };
        if(/(y+)/.test(format)){ format = format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length)); }
        for(var k in o)
        {
            if(new RegExp("("+ k +")").test(format)){  format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));}
        }
        return format;
    }
    
    /* 
    * 获得时间差,时间格式为 年-月-日 小时:分钟:秒 或者 年/月/日 小时：分钟：秒 
    * 其中，年月日为全格式，例如 ： 2010-10-12 01:00:00 
    * 返回精度为：秒，分，小时，天
    */
    function GetDateDiff(startTime, endTime, diffType)
    {
        //将xxxx-xx-xx的时间格式，转换为 xxxx/xx/xx的格式 
        startTime = startTime.replace(/\-/g, "/");
        endTime = endTime.replace(/\-/g, "/");
        //将计算间隔类性字符转换为小写
        diffType = diffType.toLowerCase();
        var sTime = new Date(startTime);      //开始时间
        var eTime = new Date(endTime);  //结束时间
        //作为除数的数字
        var divNum = 1;
        switch (diffType) {
            case "second":
                divNum = 1000;           break;
            case "minute":
                divNum = 1000 * 60;      break;
            case "hour":
                divNum = 1000 * 3600;    break;
            case "day":
                divNum = 1000 * 3600 * 24;  break;
            default: break;    
        }
        return parseInt((eTime.getTime() - sTime.getTime()) / parseInt(divNum));
    }
    
  ===============================时间对象==================================================     

//javascript中定义类的步骤
1.先定义一个构造函数，并设置初始化新对象的实例属性。
2.给构造函数的prototype对象定义实例的方法
3.给构造定义类字段和类属性
比如定义一个复数类，像下面这个样式的.
复数类
	function Complex(real,imaginary)
        {
            if(isNaN(real) || isNaN(imaginary)) throw new TypeError();
            this.r = real;
            this.i = imaginary;
        }
        Complex.prototype.add = function(that)
        {
            return new Complex(this.r + that.r,this.i + that.i);
        };
        Complex.prototype.mul = function(that)
        {
            return new Complex(this.r * that.r - this.i * that.i,this.r * that.i + this.i * that.r);
        };
        Complex.prototype.mag = function(that)
        {
            return Math.sqrt(this.r * this.r + this.i * this.i);
        };
        Complex.prototype.neg = function()
        {
            return new Complex(-this.r,-this.i);
        };
        Complex.prototype.toString = function()
        {
            return "{" + this.r + "," + this.i + "}";
        };
        Complex.prototype.equals = function(that)
        {
            return that != null && that.constructor === Complex && this.r === that.r && this.i === that.i;
        };
        Complex.ZERO = new Complex(0,0);
        Complex.ONE = new Complex(1,0);
        Complex.I = new Complex(0,1);

        Complex.parse = function(s)
        {
            try
            {
                var m = Complex._format.exec(s);
                return new Complex(parseFloat(m[1]),parseFloat((m[2])));
            }catch(x)
            {
                throw new TypeError("Can't parse'" + s + "' as a complex number.");
            }
        };
        Complex._format = /^{([^,]+),([^}]+)\}$/;

        var c = new Complex(2,3);
        var d = new Complex(c.i,c.r);
        alert(c.add(d).toString());
        alert(Complex.parse(c.toString()).add(c.neg()).equals(Complex.ZERO));
        
//集合类     
    function Set()  //构造函数
    {
        this.values = {}; //集合数据保存在对象的属性里
        this.n = 0; //集合中值的个数
        this.add.apply(this,arguments); //把所有参数都添加进这个集合
    };
    //将每个参数都添加至集合中
    Set.prototype.add = function()
    {
        for(var i = 0;i < arguments.length;i++) //遍历每个参数
        {
            var val = arguments[i]; //待添加到集合中的值
            var str = Set._v2s(val); //把它转为字符串
            if(!this.values.hasOwnProperty(str))//如果不在集合中
            {
                this.values[str] = val;//将字符串与值对应起来
                this.n++;//集合中值的计数加一
            }
        }
        return this;  //支持链式方法调用
    };
    //从集合删除元素，这些元素由参数指定
    Set.prototype.remove = function()
    {
        for(var i = 0;i < arguments.length;i++) //遍历每个参数
        {
            var str = Set._v2s(arguments[i]);  //将字符串和值对应起来
            if(this.values.hasOwnProperty(str)) //如果它在集合中
            {
                delete this.values[str]; //删除它
                this.n--;   //集合中值的计数减一
            }
        }
        return this; //支持链式方法调用
    };
    //如果集合包含这个值，则返回true;否则返回false
    Set.prototype.contains = function (value)
    {
        return this.values.hasOwnProperty(Set._v2s(value));
    };
    //返回集合的大小
    Set.prototype.size = function(){ return this.n; };
    //遍历集合中的所有元素，在指定的上下文中调用f
    Set.prototype.foreach = function (f,context) 
    {
        for(var s in this.values){ if(this.values.hasOwnProperty(s)) f.call(context,this.values[s]); }
    };
    //这是一个内部函数，用以将做生意javascript值和唯一的字符串对应起来
    Set._v2s = function(val)
    {
        switch(val)
        {
            case undefined: return 'u'; //特殊的原始值
            case null: return 'n'; //值只有一个字母
            case true: return 't'; //代码
            case false: return 'f';
            default:
            switch(typeof val)
            {
                case 'number': return '#' + val;
                case 'string': return '"' + val;
                default:return '@' + objectId(val);
            }
        }
        //对任意的对象来说，都会返回一个字符串
        //针对不同的对象，这个函数会返回不同的字符串
        //对于同一个对象的多次调用，总是返回相同的字符串
        //为了做这一点，它给o创建了一个属性，在ES5中，这个属性是不可枚举且是只读的
        function objectId(o)
        {
            var prop = "|**objectId**|";  //私有属性，用以存放id
            if(!o.hasOwnProperty(prop)) //如果对象没有id
            {
                o[prop] = Set._v2s.next++; //将下一个值赋给它
            }       
            return o[prop];//返回这个id
        }
    };
    Set._v2s.next = 100;

    var a = new Set();
    a.add('45','30','aaa','ccc');
    alert(a.remove('aaa','45','ccc'));
    alert(a.size());
    
//基础知识
isNaN()    如果参数是NaN或者是一个非数字值（比如字符串和对象），则返回true.
isFinite() 参数不是NaN Infinity 或 -Infinity的时候返回true


/*--------------------可选函数----------------------------*/

//定义并调用一个函数来确定当前脚本运行时是否为严格模式
<script>
    "use strict";
    var strict = (function(){ return !this;}());
    alert(strict);
</script>


function counter(n){
	n = n || 0;
	//if(!(isFinite(n) && n > 0 && n == Math.round(n))) return null;
	return {
		count:function(){ return n++; },
		reset:function(m){ if( m >= n ){ n = m; }else{ throw Error ("count can only be set to a larger value");} }
	}
}

//检查对象是否是一个函数
function isFunction(f){ return Object.prototype.toString.call(x) === "[object Function]"; }

//返回数组的一部分或全部
function sliceArr(a,n){ return Array.prototype.slice.call(a,n||0); }

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
String.prototype.trim = String.prototype.trim || function(){
    if(!this) return this;  //空字符串不做处理
    return this.replace(/^\s+|\s+$/g,''); //使用正则表达式进行空空格替换
};
 String.prototype.empty = function(){
    return this == '' || this == ' ' || typeof(this) == 'undefined';
 };

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

Array.prototype.random = function(start)
{
   var min = parseInt(start) || 0;
   if (min > this.length - 1) { return ''; }
   var max = this.length - 1;
   return this[parseInt(Math.random() * (max - min + 1) + min)];
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
