2015-09-18 9:42


1、checkbox日常jquery操作。
<input id="checkAll" type="checkbox" />全选
        <input name="subBox" type="checkbox" />项1
        <input name="subBox" type="checkbox" />项2
        <input name="subBox" type="checkbox" />项3
        <input name="subBox" type="checkbox" />项4
 全选和全部选代码：
 <script type="text/javascript">
        $(function() {
           $("#checkAll").click(function() {
                $('input[name="subBox"]').attr("checked",this.checked); 
            });
            var $subBox = $("input[name='subBox']");
            $subBox.click(function(){
                $("#checkAll").attr("checked",$subBox.length == $("input[name='subBox']:checked").length ? true : false);
            });
        });
</script>
checkbox属性：
var val = $("#checkAll").val();// 获取指定id的复选框的值  
var isSelected = $("#checkAll").attr("checked"); // 判断id=checkAll的那个复选框是否处于选中状态，选中则isSelected=true;否则isSelected=false;  
$("#checkAll").attr("checked", true);// or  
$("#checkAll").attr("checked", 'checked');// 将id=checkbox_id3的那个复选框选中，即打勾  
$("#checkAll").attr("checked", false);// or  
$("#checkAll").attr("checked", '');// 将id=checkbox_id3的那个复选框不选中，即不打勾  
$("input[name=subBox][value=3]").attr("checked", 'checked');// 将name=subBox, value=3 的那个复选框选中，即打勾  
$("input[name=subBox][value=3]").attr("checked", '');// 将name=subBox, value=3 的那个复选框不选中，即不打勾  
$("input[type=checkbox][name=subBox]").get(2).checked = true;// 设置index = 2，即第三项为选中状态  
$("input[type=checkbox]:checked").each(function(){ //由于复选框一般选中的是多个,所以可以循环输出选中的值  
    alert($(this).val());  
});
另一个checkbox的例子：
 <input type="checkbox" class="group" value="AAA" />AAA
 <input type="checkbox" class="group" value="BBB" />BBB
 <input type="checkbox" class="group" value="CCC" />CCC
 <input type="button" id="button" value="处理" />
 
<script type="text/javascript">
        $('#button').click(function(){
            var group = $('.group');
            for(var i=0;i<group.length;i++)
            {
                if(group[i].checked) {  alert(group[i].value);  }
            }
        });
</script>

2、radio的jquery日常操作及属性
<input type="radio" name="radio" id="radio1" value="1" />1  
<input type="radio" name="radio" id="radio2" value="2" />2  
<input type="radio" name="radio" id="radio3" value="3" />3  
<input type="radio" name="radio" id="radio4" value="4" />4 
radio操作如下：
$("input[name=radio]:eq(0)").attr("checked",'checked'); //这样就是第一个选中咯。
  //jquery中，radio的选中与否和checkbox是一样的。
$("#radio1").attr("checked","checked");
$("#radio1").removeAttr("checked");
$("input[type='radio'][name='radio']:checked").length == 0 ? "没有任何单选框被选中" : "已经有选中";  
$('input[type="radio"][name="radio"]:checked').val(); // 获取一组radio被选中项的值  
$("input[type='radio'][name='radio'][value='2']").attr("checked", "checked");// 设置value = 2的一项为选中  
$("#radio2").attr("checked", "checked"); // 设置id=radio2的一项为选中  
$("input[type='radio'][name='radio']").get(1).checked = true; // 设置index = 1，即第二项为当前选中  
var isChecked = $("#radio2").attr("checked");// id=radio2的一项处于选中状态则isChecked = true, 否则isChecked = false;  
var isChecked = $("input[type='radio'][name='radio'][value='2']").attr("checked");// value=2的一项处于选中状态则isChecked = true, 否则isChecked = false;  

3、select下拉框的日常jquery操作
<select name="select" id="select_id" style="width: 100px;">  
    <option value="1">11</option>  
    <option value="2">22</option>  
    <option value="3">33</option>  
    <option value="4">44</option>  
    <option value="5">55</option>  
    <option value="6">66</option>  
</select>

    $("#select_id").change(function(){                         // 1.为Select添加事件，当选择其中一项时触发   
        //code...  
    });  
    var checkValue = $("#select_id").val();                    // 2.获取Select选中项的Value  
    var checkText = $("#select_id :selected").text();          // 3.获取Select选中项的Text   
    var checkIndex = $("#select_id").attr("selectedIndex");    // 4.获取Select选中项的索引值,或者：$("#select_id").get(0).selectedIndex;  
    var maxIndex =$("#select_id :last").get(0).index;        // 5.获取Select最大的索引值
    /** 
     * jQuery设置Select的选中项 
     */  
    $("#select_id").get(0).selectedIndex = 1;                  // 1.设置Select索引值为1的项选中  
    $("#select_id").val(4);                                    // 2.设置Select的Value值为4的项选中  
    /** 
     * jQuery添加/删除Select的Option项 
     */  
    $("#select_id").append("<option value='新增'>新增option</option>");    // 1.为Select追加一个Option(下拉项)   
    $("#select_id").prepend("<option value='请选择'>请选择</option>");   // 2.为Select插入一个Option(第一个位置)  
    $("#select_id").get(0).remove(1);                                      // 3.删除Select中索引值为1的Option(第二个)  
    $("#select_id :last").remove();                                        // 4.删除Select中索引值最大Option(最后一个)   
    $("#select_id [value='3']").remove();                                  // 5.删除Select中Value='3'的Option   
    $("#select_id").empty();           

   $("#select_id").find("option:selected").text(); // 获取select 选中的 text :
   $("#select_id").val(); // 获取select选中的 value:
   $("#select_id").get(0).selectedIndex; // 获取select选中的索引:

 //设置select 选中的value：
    $("#select_id").attr("value","Normal");
    $("#select_id").val("Normal");
    $("#select_id").get(0).value = value;

 //设置select 选中的text，通常可以在select回填中使用
var numId=33 //设置text==33的选中！
var count=$("#select_id  option").length;
  for(var i=0;i<count;i++)  
     {           if($("#select_id").get(0).options[i].text == numId)  
        {  
            $("#select_id").get(0).options[i].selected = true;  
            break;  
        }  
    }


//定义并调用一个函数来确定当前脚本运行时是否为严格模式
<script>
    "use strict";
    var strict = (function(){ return !this;}());
    alert(strict);
</script>

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


/*--------------------可选函数----------------------------*/
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
