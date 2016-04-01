

=========================================================时间对象开始====================================================
    
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
            if(new RegExp("("+ k +")").test(format))
            {  
            	format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
            }
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
    
=========================================================时间对象结束====================================================  

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



=========================================================常用函数开始====================================================
    

isNaN()    	如果参数是NaN或者是一个非数字值（比如字符串和对象），则返回true.
isFinite() 	参数不是NaN Infinity 或 -Infinity的时候返回true

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

// 解释url 以对象的形式返回
String.prototype.parseURL = function()
{
	if(this.empty()){ return null; }
	var o = new Object();
	if(this.indexOf('?') != -1)
	{
		var splits = this.split('?'); 
		o.href = splits[0];
		var ar = splits[1].split('&');
		for(var i=0; i<ar.length; i++) 
		{ 
			o[ar[i].split("=")[0]] = decodeURIComponent(ar[i].split("=")[1]);
		}
	}
	return o;
};

//验证身 份 证
String.prototype.IDC = function()
{
	var O = {"status":0,"province":'',"age":0,"days":0,"birthday":'',"gender":''};
	if(this == '' || this == ' '){ return O; }
	var ar = this.split('');
	if(ar.length != 18) { return O; } //第二代身份证长度为18位
	//检查第18位 第18位要么是数字要么是x|X
	var bits = ['0','1','2','3','4','5','6','7','8','9','x','X'];
	var bit18 = 0;
	for(var i=0,len=bits.length;i<len;i++){ if(ar[17] == bits[i]){ bit18 = 1; }}
	if (bit18 == 0) { return O; }
	//检查身份证所在区域是否合法
	var cities = {11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",
                  23:"黑龙江",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",
                  37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",
                  50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",
                  63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"		};
	var region = parseInt(this.substr(0,2),10); 
	O.province = cities[region];
	if (O.province == null || O.province == 'undefined') { return O; }
	//检查出生日期
	var birthday = Number(this.substr(6,4)) + "/" + Number(this.substr(10,2)) + "/" + Number(this.substr(12,2));
	var d = new Date(birthday);
	if(birthday != (d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate())){ O.province = '';	return O;	}
	O.birthday = birthday;
	//校验规则 如果第18位是X|x则替换成a
	var iSum = 0,id = this;
	if (ar[17] == 'x' || ar[17] == 'X' ){ id = id.substr(0,17) + 'a'; }
	for(var i=17;i>=0;i--){ iSum += (Math.pow(2,i) % 11) * parseInt(id.charAt(17 - i),11); }
	if(iSum % 11 != 1){	O.province = '';	O.birthday = '';	return O; }
	O.status = 1;
	O.gender = ar[16] % 2 == 0 ? '女' : '男';
	O.age = parseInt(new Date().getFullYear()) - parseInt(d.getFullYear());  //计算年龄 非精确
	//计算出生日期距离现在的天数
	O.days = parseInt(((parseInt(new Date().getTime() / 1000)) - (parseInt(new Date(birthday).getTime() / 1000))) / (24 * 60 * 60));
	return O;//返回结果集				
};
//示 例：console.log('22010120050801215X'.IDC());

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
Array.prototype.indexOf = function(val){ for(var i=0;i<this.length;i++){ if(this[i] == val) return i;} };

//移除数组中指定值的元素并重复生成索引
Array.prototype.remove = function(val){ var index = this.indexOf(val); if (index > -1) { this.splice(index,1);} };

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
   var min = parseInt(start) || 0, max = this.length - 1;
   if (min > max) { return ''; }
   return this[parseInt(Math.random() * (max - min + 1) + min)];
}

=========================================================常用函数结束====================================================

=========================================================操作cookie开始==================================================
//设置cookie
function setCookie(c_name, value, expiredays,path)
{
 	var exdate=new Date();
　　exdate.setDate(exdate.getDate() + expiredays);
	var p = path || '/';
　　document.cookie = c_name + "=" + escape(value) + ((expiredays==null) ? "" : ";expires=" + exdate.toGMTString()) + ';path=' + p; 　　
}
//按照天数来设置cookie的有效时间，如果想以其他单位（如：小时）来设置，改变第三行代码即可
exdate.setHours(exdate.getHours() + expiredays);

//路径能解决在同一个域下访问 cookie 的问题
//"www.qq.com" 与 "sports.qq.com" 公用一个关联的域名"qq.com"，
//如果想让 "sports.qq.com" 下的cookie被 "www.qq.com" 访问，就需要用到 cookie 的domain属性，并且需要把path属性设置为 "/"
document.cookie = "name=value;path=path;domain=domain"
document.cookie = "username=Darren;path=/;domain=qq.com"

//读取cookie
function getCookie(name)
{
	var reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg)){
		return unescape(arr[2]);
	}else{return null;	}
}

//删除cookie
function delCookie(name)
{
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval = getCookie(name);
	if(cval){ document.cookie = name + "=" + cval +";expires="+exp.toGMTString(); }
}
=========================================================操作cookie结束==================================================
