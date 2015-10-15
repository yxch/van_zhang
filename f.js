2015-09-18 9:42

//定义并调用一个函数来确定当前脚本运行时是否为严格模式
<script>
    "use strict";
    var strict = (function(){ return !this;}());
    alert(strict);
</script>

