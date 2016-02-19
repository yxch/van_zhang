/**
 * 来源检测js
 * 请在</body>前加载此文件
 * 必须保证文档中存在如下元素 <input type="hidden" name="searchWords" id="searchWords" />
 */

$(document).ready(function(){
	var searchwords = document.getElementsByName('searchWords');
	//获取来源
    var surl = document.referrer;
    //var surl = 'https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=0&rsv_idx=1&tn=baidu&wd=%E6%8B%9B%E5%95%86%E4%BF%A1%E8%AF%BA%E9%87%8D%E7%96%BE%E5%88%86%E7%BA%A2%E9%99%A9';
    var key = '';
    if( surl.indexOf("m.baidu.com") != -1 ){		  key = 'word';
    }else if(surl.indexOf("www.baidu.com")) {		  key = 'wd';
    }else if(surl.indexOf("google.com.hk") != -1){    key = "q";
    }else if(surl.indexOf("one.cn.yahoo.com") != -1){ key = "q";
    }else if(surl.indexOf("haosou.com") != -1){       key = "q";
    }else if(surl.indexOf("cn.bing.com") != -1){      key = "q";
    }else if(surl.indexOf("sogou.com") != -1){        key = "query";
    }else if(surl.indexOf("youdao.com") != -1){       key = "q"; 		}

    var obj = new Object();
    if(surl.indexOf('?') != -1)
    {
    	obj.search = surl.split('?')[1]; //获取?后的部分 其实就是查询字符串部分
    	var strs = obj.search.split("&"); //将查询字符串拆分成数组
    	for(var i=0; i<strs.length; i++)
    	{
    		//给对象obj的相关属性赋值
    		obj[strs[i].split("=")[0]] = decodeURIComponent(strs[i].split("=")[1]);
    	}
    }
    //解决页面有多个<input type="hidden" name="searchWords" />的赋值问题
    for(var j=0;j<searchwords.length;j++)
    {
    	searchwords[j].value = obj[key] ? obj[key] : '';
    }
});