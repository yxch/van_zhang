<?php
/*
if($node->field_category[und][0][value]&&$node->field_platform[und][0][value]==2){
	header("http/1.1 301 moved permanently");
	header("location: /error");
	exit();
}*/
// 预约表单放正文

$block55 = <<<s
<div class="cont-form" style="margin-top: 10px;">
<link href="/include_form/form_comm/css/add.css" rel="stylesheet" type="text/css" />
<div class="m_form  m_form2"><div class="m_top">&nbsp;</div><div class="m_c_2" style="border-bottom:0"><div class="c_des_2">我们的客服人员将尽快致电，为您提供产品咨询、答疑等服务。</div><form action="" id="myform" method="post" name="myform" onsubmit="return checkFormInfo();" target="submitiframe"><input id="url" name="url" type="hidden" /> <input id="product" name="product" type="hidden" value="DTCRW" /> <input id="campaignCode" name="campaignCode" type="hidden" value="SEOZHBDJD1" /> <input id="urlFlag" name="urlFlag" type="hidden" value="dtczx" /> <input id="iqId" name="iqId" type="hidden" /> <input id="searchWords" name="searchWords" type="hidden" /><table border="0" cellpadding="0" cellspacing="0" id="frmtableid"><tbody><tr><td><input class="xntext" id="name" maxlength="12" name="name" onblur="checkName(this.id)" placeholder="姓名（必填）" type="text" /></td></tr><tr><td><input class="xntext" id="mobile" maxlength="11" name="mobile" onafterpaste="this.value=this.value.replace(/\D/g,'')" onblur="checkMobile(this.id)" onkeyup="this.value=this.value.replace(/\D/g,'')" placeholder="手机（必填）" type="text" /></td></tr><input type="hidden" name="remark" value="官网软文页面表单，用户可能关注产品教育金、重疾险等" /><tr><td class="cen"><input class="btn" type="submit" value="" /></td></tr></tbody></table></form></div><div class="new0402con" style="display:none;"><strong class="s_1">您也可以拨打热线咨询：</strong> <strong class="s_2">400-880-3633</strong> <span>周一至周日 9:00-23:00</span><div class="tipsxinxi"><div class="txx_old">用户信息安全保护声明</div><div class="txx_new">您提供的个人信息我们不会泄露给任何第三方或其他用途。</div></div></div><iframe id="submitiframe" name="submitiframe" style="line-height: 1px; width: 1px; display: none; height: 1px; overflow: hidden"></iframe></div><script language="javascript" src="/include_form/form_comm/js/form6.js"></script><script src="/include_form/form_comm/js/placeholder.js"></script><script>
			  	$(function(){
					$('input[placeholder], textarea[placeholder]').each(function(){
						$(this).is('input')?$(this).iePlaceholder():$(this).iePlaceholder({onInput: false});});
					$(".txx_old").mouseover(function(){
						$(".txx_new").show();
						$(this).css({color:"#87c691"})
					}).mouseout(function(){
						$(".txx_new").hide();	
						$(this).css({color:"#999"})
					})
				})
			  </script>
</div>
s;
?>

<script type="text/javascript">
    var system = {
        win: false,
        mac: false,
        xll: false
    };
    var p = navigator.platform;
    system.win = p.indexOf("Win") == 0;
    system.mac = p.indexOf("Mac") == 0;
    system.x11 = (p == "X11") || (p.indexOf("Linux") == 0);
    if (system.win || system.mac || system.xll) {} else {
        var path = window.location.pathname;
        var subFloder = path.split("/")[1];
        if (subFloder.indexOf("baoxianzhishi") == 0 || subFloder.indexOf("baoxiananli") == 0|| subFloder.indexOf("faq") == 0) {
            var params = window.location.search;
            if (params == "" || params == undefined) {
                params = "?WT.mc_id=DMDPC"
            } else {
                params = params + "&WT.mc_id=DMDPC"
            }
            //for test
            //window.location.href = "http://10.140.130.35:8001" + path + params;
            window.location.href = "http://m.cignacmb.com"+ path + params;
        }
    }
</script>
<?php
drupal_add_css ( (path_to_theme () . '/css/zhishi.css'), 'theme', 'all' );
?>
<div id="page" class="container clearfix">
	<script type="text/javascript"
		src="<?php print $base_path . $directory; ?>/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript"
		src="<?php print $base_path . $directory; ?>/js/TrackingCodeIQID.js"></script>
	<script type="text/javascript"
		src="<?php print $base_path . $directory; ?>/js/TrackingCode.js"></script>
	<!-- Header region -->
<?php include 'include-header.tpl.php';?>
<?php print render($page['cacheFlush']); ?>
<!-- End header region -->

	<!-- Lower level page content --> 
<?php
$ctid = $node->field_category['und'][0]['value'];
if(substr($ctid, 0, 2)=='12'||stripos ( request_path (), 'faq/' ) !== false){
	drupal_add_css( (path_to_theme () . '/css/style.css'), 'theme', 'all' );
}
$ktit = '';
$brgz = empty($brgz)?'':$brgz;
$link = 'baoxianzhishi/';
switch ($ctid) {
	case 10011:
		$brgz = '5|8|6|3';
		$ktit = '健康与医疗保险知识软文';
		$link = 'baoxianzhishi/yiliao';
		break;
	case 11011:
		$brgz = '5|8|6|3';
		$ktit = '健康与医疗保险案例软文';
		$link = 'baoxiananli/yiliao';
		break;

	case 10021:
		$brgz = '9|4|5|8';
		$ktit = '少儿险知识软文';
		$link = 'baoxianzhishi/shaoer';
		break;
	case 11021:
		$brgz = '9|4|5|8';
		$ktit = '少儿险案例软文';
		$link = 'baoxiananli/shaoer';
		break;

	case 10031:
		$brgz = '4|9|5|8';
		$ktit = '意外险知识软文';
		$link = 'baoxianzhishi/yiwai';
		break;
	case 11031:
		$brgz = '4|9|5|8';
		$ktit = '意外险案例软文';
		$link = 'baoxiananli/yiwai';
		break;

	case 10041:
		$brgz = '4|7|9|8';
		$ktit = '旅游险知识软文';
		$link = 'baoxianzhishi/lvyou';
		break;
	case 11041:
		$brgz = '4|7|9|8';
		$ktit = '旅游险案例软文';
		$link = 'baoxiananli/lvyou';
		break;

	case 10051:
		$brgz = '3|4|5|6';
		$ktit = '投资分红险知识软文';
		$link = 'baoxianzhishi/toulianxian';
		break;
	case 11051:
		$brgz = '3|4|5|6';
		$ktit = '投资分红险案例软文';
		$link = 'baoxiananli/toulianxian';
		break;

	case 10061:
		$brgz = '10|9|11|12';
		$ktit = '高端医疗险知识软文';
		$link = 'baoxianzhishi/shouxian';
		break;
	case 11061:
		$brgz = '10|9|11|12';
		$ktit = '高端医疗险案例软文';
		$link = 'baoxiananli/shouxian';
		break;

	case 10071:
		$brgz = '2|8|5|9';
		$ktit = '养老险知识软文';
		$link = 'baoxianzhishi/yanglao';
		break;
	case 11071:
		$brgz = '2|8|5|9';
		$ktit = '养老险案例软文';
		$link = 'baoxiananli/yanglao';
		break;

	case 10081:
		$brgz = '9|5|8|4';
		$ktit = '其他知识软文';
		$link = 'baoxianzhishi/qita';
		break;
	case 11081:
		$brgz = '9|5|8|4';
		$ktit = '其他案例软文';
		$link = 'baoxiananli/qita';
		break;
	case 12010:
		$ktit = '给孩子买保险';
		//$brgz = '9|5|8|4';
		$link = 'faq/baby';
		break;
	case 12011:
		$ktit = '给自己和爱人买保险';
		//$brgz = '9|5|8|4';
		$link = 'faq/honey';
		break;
	case 12012:
		$ktit = '给父母买保险';
		//$brgz = '9|5|8|4';
		$link = 'faq/parents';
		break;
	case 12013:
		$ktit = '保险百科';
		//$brgz = '9|5|8|4';
		$link = 'faq/baike';
		break;
	case 12014:
		$ktit = '保险理赔';
		//$brgz = '9|5|8|4';
		$link = 'faq/lipei';
		break;
	case 12015:
		$ktit = '保险增值';
		//$brgz = '9|5|8|4';
		$link = 'faq/zengzhi';
		break;
}
//获取热门
$hot_arr = array();
if(!empty($ctid)){
	$sql = "SELECT a.nid, a.title, d.alias FROM cigna_cmc_node AS a LEFT JOIN cigna_cmc_field_data_field_category AS b ON a.nid=b.entity_id LEFT JOIN cigna_cmc_field_data_field_psort AS c ON a.nid=c.entity_id LEFT JOIN cigna_cmc_url_alias AS d ON d.source=CONCAT('node/',a.nid) WHERE a.status=1 AND b.field_category_value = $ctid  AND c.field_psort_value>0 ORDER BY c.field_psort_value DESC, a.nid DESC LIMIT 0 , 6";
	$result = db_query ( $sql );
	$title = '';
	$turl = '';
	$hot_arr = array();
	foreach ( $result as $row ) {
		$title = $row->title;	
		$alias = $row->alias;
		if ($alias) {
			$turl = CMCURL . $alias;
		} else {
			$turl = CMCURL . "node/" . $row->nid;
		}
		$hot_arr[] = array (
				'url' => $turl,
				'title' => addslashes($title),
				'stitle' =>  addslashes(mb_substr($title, 0,15))
		);
	}
}
// 获取栏目的18条记录 如果热门文章有不去重
$all_arr = array();
if(!empty($ctid)){
	$sql = "SELECT b.nid, b.title,b.created,c.alias FROM cigna_cmc_field_data_field_category AS a LEFT JOIN cigna_cmc_node AS b ON a.entity_id = b.nid LEFT JOIN cigna_cmc_url_alias AS c ON c.source =CONCAT('node/',b.nid) WHERE b.status = 1 AND a.field_category_value = $ctid ORDER BY b.nid DESC LIMIT 0 , 18";
	$result = db_query ( $sql );
	$title = '';
	$turl = '';
	foreach ( $result as $row ) {
		$title = $row->title;
		$alias = $row->alias;
		if ($alias) {
			$turl = CMCURL . $alias;
		} else {
			$turl = CMCURL . "node/" . $row->nid;
		}
		$all_arr[] = array (
				'url' => $turl,
				'title' => addslashes($title),
				'stitle' =>  addslashes(mb_substr($title, 0,15))
		);
	}
}
if(count($hot_arr)==0){
	$hot_arr = array_slice($all_arr, 12, 6);
}else{
	for($i = 0;$i<(6-count($hot_arr));$i++){
		$key = 13+$i;
		$hot_arr[] = $all_arr[$key];
	}
}
// $hot_arr = json_encode($hot_arr);
//获取最新资讯
$new_arr = array_slice($all_arr, 0, 6);
// $new_arr = json_encode($new_arr);
//获取推荐文章
$rec_arr = array_slice($all_arr, 6, 6);
// $rec_arr = json_encode($rec_arr);
$link = CMCURL.$link;

// 不使用js生成html，tony需求
function get_tab_cont($arr, $link){
	$temp = '<ul>';
	if(empty($arr)){
		$temp .= '<li class="list"><a href="javascript:;" target="_self">暂时没有数据！</a></li>';
	}else{
		foreach ($arr as $a) {
			$temp .= "<li class='list'><a href='{$a['url']}' target='_blank' title='{$a['title']}'>{$a['stitle']}</a></li>";
		}
	}
	$temp .= "<li class='nobot'><a href='{$link}' target='_blank'>更多&gt;&gt;</a></li></ul>";

	return $temp;
}
$hot_arr = get_tab_cont($hot_arr, $link);
$new_arr = get_tab_cont($new_arr, $link);
$rec_arr = get_tab_cont($rec_arr, $link);

$block98 = <<<s
<div class="left_2">
		<div class="left_3_top">
			<span class="tqes_title" id="link_tab1" onmouseover="linkTab(this);">热门文章</span>
			<span class="tqes_titles" id="link_tab2" onmouseover="linkTab(this);">推荐文章</span>
			<span class="tqes_titles" id="link_tab3" onmouseover="linkTab(this);">最新资讯</span>
		</div>
		<div class="left_2_c">
			<div class="link_tab_content" id="link_tab1_content">{$hot_arr}</div>
			<div class="link_tab_content" id="link_tab2_content" style="display:none;">{$new_arr}</div>
			<div class="link_tab_content" id="link_tab3_content" style="display:none;">{$rec_arr}</div>
		</div>
	</div>
s;

?>
<script type="text/javascript">
function linkTab(obj){
	$(".left_3_top").find('span').removeClass('tqes_title');
	$(".left_3_top").find('span').removeClass('tqes_titles');
	$(".left_3_top").find('span').addClass('tqes_titles');
	$(obj).removeClass('tqes_titles');
	$(obj).addClass('tqes_title');
	var pix = $(obj).attr('id');
	$(".link_tab_content").hide();
	$("#"+pix+"_content").show();
}
</script>
	<div id="PrtContainer">
		<div id="line"></div>
		<div id="PrtContainerInsider">
<?php print customer_cigna_cmc_breadcrumb(); ?>
 <!-- shopping mall left region -->
			<div id="ZixunColumn">
				<?php if($brgz!=''){?>
				<script type="text/javascript" >
						$(function(){
						     var len  = $(".cb_num > li").length;
							 var index = 0;
							 var adTimer;
							 $(".cb_num li").mouseover(function(){
								index  =   $(".cb_num li").index(this);
								showImg(index);
							 }).eq(0).mouseover();
							 $('.cb_adbox').hover(function(){
									 clearInterval(adTimer);
								 },function(){
									 adTimer = setInterval(function(){
									    showImg(index)
										index++;
										if(index==len){index=0;}
									  } , 5000);
							 }).trigger("mouseleave");
						})
						function showImg(index){
						        var adHeight = $(".cb_adbox").height();
								$(".cb_slider").stop(true,false).animate({top : -adHeight*index},0);
								$(".cb_num li").removeClass("on")
									.eq(index).addClass("on");
						}
					</script>
					<div class="cb_adbox" >
						<?php 
							$hdpimgs = 4;//幻灯片图片数量;
							//去掉 乐享睿健产品链接
							if(strpos($_SERVER['REQUEST_URI'],'/baoxiananli/shouxian/') !== false){ $hdpimgs = 3;}
							$imgpfx = "zx_banner";//图片名称前缀，图片的格式都必须是jpg
							//以下是图片的链接url，链接url的数量要和幻灯片图片的数量一致
							$hdpurl8 = CMCURL . "shop/lekangwuyou.html";
							$hdpurl1 = CMCURL . "shop/chengzhangzhinuo.html";
							$hdpurl2 = CMCURL . "shop/changqingshou.html";
							$hdpurl3 = CMCURL . "shop/lirenyounuo.html";
							$hdpurl4 = CMCURL . "shop/xinyunwuyou.html";
							$hdpurl5 = CMCURL . "shop/zhongjixian.html";
							$hdpurl6 = CMCURL . "shop/zhouquanbao.html";
							$hdpurl7 = CMCURL . "shop/p/jingneilvyou.html ";
							$hdpurl8 = CMCURL . "shop/lekangwuyou.html";
							$hdpurl9 = CMCURL . "shop/shaoerxian.html";
							$hdpurl10 = CMCURL ."shop/huanqiuzunxiang.html";// "shop/huanqiuzhizun.html";
							$hdpurl11 = CMCURL . "shop/lexiangruijian.html";
							if(strpos($_SERVER['REQUEST_URI'],'/baoxiananli/shouxian/') === false) { $hdpurl12 = CMCURL . "shop/zhixiangruijian.html"; }
							$alt1 = "成长之诺";
							$alt2 = "长青寿险";
							$alt3 = "丽人优诺";
							$alt4 = "信运无忧";
							$alt5 = "重疾险";
							$alt6 = "周全保";
							$alt7 = "境内旅游";
							$alt8 = "乐康无忧";
							$alt9 = "少儿险";
							$alt10 = "寰球至尊";
							$alt11 = "乐享睿健";
							if(strpos($_SERVER['REQUEST_URI'],'/baoxiananli/shouxian/') === false) { $alt12 = "智享睿健"; }
							$brgz = strval($brgz);
							$splvals = explode('|', $brgz);
							$splval = '';
							if (stripos ( request_path (), 'baoxianzhishi' ) !== false) {
								$ptype='保险知识';
							}elseif (stripos ( request_path (), 'baoxiananli' ) !== false) {
								$ptype='保险案例';
							}elseif (stripos ( request_path (), 'zhuanti' ) !== false) {
								$ptype='保险专题';
							}elseif (stripos ( request_path (), 'faq' ) !== false) {
								$ptype='保险问答';
							}
						?>
						 <ul class="cb_slider" >
							<?php if(!empty($brgz)){for ($hdi = 1; $hdi <= $hdpimgs;$hdi++) {$splval = $splvals[$hdi - 1];
							?>
							<li><a onclick="_gaq.push(['_trackEvent', '<?php echo $ktit;?>', 'click', 'banner<?php echo $hdi;?>']);" href="<?php echo ${"hdpurl" . $splval};?>" target="_blank" otype="<?php echo $ptype;?>" otitle="<?php echo ${"alt" . $splval};?>" oarea="banner"><img src="/sites/default/themes/cigna_cmc/images/<?php echo $imgpfx;?><?php echo $splval;?>.jpg" alt="<?php echo ${"alt" . $splval};?>"/></a></li>
							<?php }}?>
						  </ul>
						  <ul class="cb_num" >
						  	<?php for ($hdj = 1; $hdj <= $hdpimgs;$hdj++) {?>
							<li><?php echo $hdj;?></li>
							<?php }?>
						  </ul>
					</div>
					<?php } ?>
				<!-- shopping mall left region -->
				<div class="clearLeft"></div>
<?php if ($tabs): ?>
        <div class="tabs">
          <?php print render($tabs); ?>
        </div>
				<div class="clearLeft"></div>
      <?php endif; ?>
<?php
$nodeid = $node->nid;
if (!empty($node->field_category['und'][0]['value'])) {
	$ctid = $node->field_category['und'][0]['value'];
}
$ctid = !empty($ctid) ? intval($ctid) : 0;
unset ( $page ['content'] ['system_main'] ['nodes'] [$nodeid] ['field_psort'] );
unset ( $page ['content'] ['system_main'] ['nodes'] [$nodeid] ['field_category'] );
// 在第一个p结束后插入预约表单
$temp = render ( $page ['content'] );
$temp = preg_replace('#<div class="zs_detail_content">.*?</p>#is', "\\0{$block55}", $temp);

print $temp;
//================================上一篇    下一篇=====================================
$sql = "SELECT b.nid, b.title FROM cigna_cmc_field_data_field_category AS a LEFT JOIN cigna_cmc_node AS b ON a.entity_id = b.nid WHERE b.status = 1 AND b.nid < $nodeid AND a.field_category_value = $ctid ORDER BY b.nid DESC LIMIT 0 , 1";
$result = db_query ( $sql );
$pretit = '';
$prenid = 0;
$nextit = '';
$nexnid = 0;
foreach ( $result as $row ) {
	if ($row->nid) {
		$prenid = $row->nid;
		$title = $row->title;
		$pnid = "node/" . $row->nid;
		$plsqla = "SELECT alias FROM cigna_cmc_url_alias WHERE source = '$pnid' LIMIT 0,1";
		$resulta = db_query ( $plsqla );
		$alias = '';
		foreach ( $resulta as $rowa ) {
			$alias = $rowa->alias;
			break;
		}
		$turl = '';
		if ($alias) {
			$turl = CMCURL . $alias;
		} else {
			$turl = CMCURL . "node/" . $row->nid;
		}
		$pretit = "上一篇：<a href='$turl'>" . $row->title . "</a>";
	}
}
$sql = "SELECT b.nid, b.title FROM cigna_cmc_field_data_field_category AS a LEFT JOIN cigna_cmc_node AS b ON a.entity_id = b.nid WHERE b.status = 1 AND b.nid > $nodeid AND a.field_category_value = $ctid ORDER BY b.nid ASC LIMIT 0 , 1";
$result = db_query ( $sql );
foreach ( $result as $row ) {
	if ($row->nid) {
		$nexnid = $row->nid;
		$title = $row->title;
		$pnid = "node/" . $row->nid;
		$plsqla = "SELECT alias FROM cigna_cmc_url_alias WHERE source = '$pnid' LIMIT 0,1";
		$resulta = db_query ( $plsqla );
		$alias = '';
		foreach ( $resulta as $rowa ) {
			$alias = $rowa->alias;
			break;
		}
		$turl = '';
		if ($alias) {
			$turl = CMCURL . $alias;
		} else {
			$turl = CMCURL . "node/" . $row->nid;
		}
		$nextit = "下一篇：<a href='$turl'>" . $row->title . "</a>";
	}
}

//================================上相关资讯=====================================
$ctid1=$ctid2=0;
$w = '1=1';
if (substr($ctid, 0,2) == 10) {
	$ctid1 = '10' . substr($ctid, 2);
	$ctid2 = '11' . substr($ctid, 2);
	$w = "a.field_category_value = $ctid1 OR a.field_category_value = $ctid2";
} else if (substr($ctid, 0,2) == 11) {
	$ctid1 = '11' . substr($ctid, 2);
	$ctid2 = '10' . substr($ctid, 2);
	$w = "a.field_category_value = $ctid1 OR a.field_category_value = $ctid2";
} else if (substr($ctid, 0,2) == 12) {
	$w = "a.field_category_value IN (12010, 12011, 12012, 12013, 12014, 12015)";
}
$sql = "SELECT b.nid, b.title FROM cigna_cmc_field_data_field_category AS a LEFT JOIN cigna_cmc_node AS b ON a.entity_id = b.nid WHERE b.status = 1 AND b.nid < $nodeid AND ($w) AND b.nid NOT IN($prenid,$nexnid) ORDER BY b.nid DESC LIMIT 0 , 10";
$result = db_query ( $sql );
$i = 0;
$res1 = array();
$res2 = array();
$tnums = 0;
foreach ( $result as $row ) {
	++$tnums;
	if ($row->nid) {
		$pnid = "node/" . $row->nid;
		$plsqla = "SELECT alias FROM cigna_cmc_url_alias WHERE source = '$pnid' LIMIT 0,1";
		$resulta = db_query ( $plsqla );
		$alias = '';
		foreach ( $resulta as $rowa ) {
			$alias = $rowa->alias;
			break;
		}
		$turl = '';
		if ($alias) {
			$turl = CMCURL . $alias;
		} else {
			$turl = CMCURL . "node/" . $row->nid;
		}
		if ($i < 5) {
			$res1[] = array('id' => $row->nid,'title' => $row->title,'url' => $turl);
		} else {
			$res2[] = array('id' => $row->nid,'title' => $row->title,'url' => $turl);
		}
		++$i;
	}
}
function SubTitle($String,$Length) {
	if (mb_strwidth($String, 'UTF8') <= $Length ){
		return $String;
	}else{
		$I = 0;
		$len_word = 0;
		while ($len_word < $Length){
			$StringTMP = substr($String,$I,1);
			if ( ord($StringTMP) >=224 ){
				$StringTMP = substr($String,$I,3);
				$I = $I + 3;
				$len_word = $len_word + 2;
			}elseif( ord($StringTMP) >=192 ){
				$StringTMP = substr($String,$I,2);
				$I = $I + 2;
				$len_word = $len_word + 2;
			}else{
				$I = $I + 1;
				$len_word = $len_word + 1;
			}
			$StringLast[] = $StringTMP;
		}
		if (is_array($StringLast) && !empty($StringLast)){
			$StringLast = implode("",$StringLast);
			$StringLast .= "...";
		}
		return $StringLast;
	}
}
?>


				<!--field_category field_psort Main content region -->
				<?php if ($tnums >= 10) {?>
				<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>

				<div class="c_fy">
					<?php echo $pretit;?>　　　<?php echo $nextit;?>
				</div>
				<div class="c_xgzx">
					<div class="c_xgzx_t">相关资讯</div>
					<div class="c_xgzx_ct">
						<ul>
							<?php foreach ($res1 as $val) {?>
							<li class="list"><span><a target="_blank"
								href="<?php echo $val['url'];?>"><?php echo SubTitle($val['title'],36);?></a></span></li>
							<?php }?>
						</ul>
						<ul>
							<?php foreach ($res2 as $val2) {?>
							<li class="list"><span><a target="_blank"
								href="<?php echo $val2['url'];?>"><?php echo SubTitle($val2['title'],36);?></a></span></li>
							<?php }?>
						</ul>
						<div class="clearBoth">&nbsp;</div>
					</div>
				</div>
				<script>document.write(unescape('%3Cdiv id="hm_t_66513"%3E%3C/div%3E%3Cscript charset="utf-8" src="http://crs.baidu.com/t.js?siteId=0c22f0a7786b64f31e59b2d3ce5b7a8e&planId=66513&async=0&referer=') + encodeURIComponent(document.referrer) + '&title=' + encodeURIComponent(document.title) + '&rnd=' + (+new Date) + unescape('"%3E%3C/script%3E'));</script>
				<?php }?>
				<div class="clearLeft">&nbsp;</div>
			</div>
		<?php 
		// 再最后一个div前插入block98内容
		$zixun_left = render($page['zixun_left']);
		$zixun_left = preg_replace('#([\s\S]*)</div>#', "$1{$block98}</div>", $zixun_left);
		print $zixun_left;
		?>
		</div>
		<div class="clearLeft"></div>
	</div>
	<!-- Copyright region -->
	<div id="copyright" class="clearfix">
<?php include 'include-footer.tpl.php';?>
</div>
	<!-- End copyright region -->
</div>
<?php include_once("analyticstracking.php") ?>
