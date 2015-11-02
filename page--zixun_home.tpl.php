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
        if (subFloder.indexOf("baoxianzhishi") == 0 || subFloder.indexOf("baoxiananli") == 0) {
            var params = window.location.search;
            if (params == "" || params == undefined) {
                params = "?WT.mc_id=DMDPC"
            } else {
                params = params + "&WT.mc_id=DMDPC"
            }
            //for test
            //window.location.href = "http://10.140.130.35:8001" + "/"+subFloder + "/" + params;
            window.location.href = "http://m.cignacmb.com"+ "/"+subFloder + "/" + params;
        }
    }
</script>
<?php
drupal_add_css ( (path_to_theme () . '/css/zs.css'), 'theme', 'all' );
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
<?php render($page['content']);?>
<!-- End header region -->
<?php
$hdpid = 0;
$hdpmc = "保险问答";
$brgz = '1|4|5|8';//保险问答
$link = 'baoxianzhishi/';
if (stripos(request_path(), 'baoxianzhishi') !== false) {
	$brgz = '9|5|8|4';//9458;
	$hdpid = 1;
	$hdpmc = "保险知识";
	$zx_type = 100;
	$link = 'baoxianzhishi/';
	$parr = array (
		'10011' => array (
				'v1' => 'title_icon_3',
				'v2' => '健康医疗险知识',
				'v3' => '/baoxianzhishi/yiliao/',
				'v4' => 'zs1_pic1.jpg',
				'v5' => 'float: left;'
		),
		'10021' => array (
				'v1' => 'title_icon_4',
				'v2' => '少儿险知识',
				'v3' => '/baoxianzhishi/shaoer/',
				'v4' => 'zs1_pic2.jpg',
				'v5' => 'float: right;'
		),
		'10031' => array (
				'v1' => 'title_icon_1',
				'v2' => '意外险知识',
				'v3' => '/baoxianzhishi/yiwai/',
				'v4' => 'zs1_pic3.jpg',
				'v5' => 'float: left;'
		),
		'10041' => array (
				'v1' => 'title_icon_2',
				'v2' => '旅游险知识',
				'v3' => '/baoxianzhishi/lvyou/',
				'v4' => 'zs1_pic4.jpg',
				'v5' => 'float: right;'
		),
		'10051' => array (
				'v1' => 'zs_icon_1',
				'v2' => '投资分红险知识',
				'v3' => '/baoxianzhishi/toulianxian/',
				'v4' => 'zs1_pic5.jpg',
				'v5' => 'float: left;'
		),
		'10061' => array (
				'v1' => 'zs_icon_2',
				'v2' => '高端医疗险知识',
				'v3' => '/baoxianzhishi/shouxian/',
				'v4' => 'zs1_pic6.jpg',
				'v5' => 'float: right;'
		),
		'10071' => array (
				'v1' => 'zs_icon_3',
				'v2' => '养老险知识',
				'v3' => '/baoxianzhishi/yanglao/',
				'v4' => 'zs1_pic7.jpg',
				'v5' => 'float: left;'
		),
		'10081'  => array (
				'v1' => 'zs_icon_4',
				'v2' => '其他知识',
				'v3' => '/baoxianzhishi/qita/',
				'v4' => 'zs1_pic8.jpg',
				'v5' => 'float: right;'
		)
	);
} 
if (stripos(request_path(), 'baoxiananli') !== false) {
	$brgz = '9|5|8|4';//9458;
	$hdpid = 2;
	$hdpmc = "保险案例";
	$zx_type = 110;
	$link = 'baoxiananli/';
	$parr = array (
		'11011' => array (
				'v1' => 'title_icon_3',
				'v2' => '健康医疗险案例',
				'v3' => '/baoxiananli/yiliao/',
				'v4' => 'zs1_pic1.jpg',
				'v5' => 'float: left;'
		),
		'11021' => array (
				'v1' => 'title_icon_4',
				'v2' => '少儿险案例',
				'v3' => '/baoxiananli/shaoer/',
				'v4' => 'zs1_pic2.jpg',
				'v5' => 'float: right;'
		),
		'11031' => array (
				'v1' => 'title_icon_1',
				'v2' => '意外险案例',
				'v3' => '/baoxiananli/yiwai/',
				'v4' => 'zs1_pic3.jpg',
				'v5' => 'float: left;'
		),
		'11041' => array (
				'v1' => 'title_icon_2',
				'v2' => '旅游险案例',
				'v3' => '/baoxiananli/lvyou/',
				'v4' => 'zs1_pic4.jpg',
				'v5' => 'float: right;'
		),
		'11051' => array (
				'v1' => 'zs_icon_1',
				'v2' => '投资分红险案例',
				'v3' => '/baoxiananli/toulianxian/',
				'v4' => 'zs1_pic5.jpg',
				'v5' => 'float: left;'
		),
		'11061' => array (
				'v1' => 'zs_icon_2',
				'v2' => '高端医疗险案例',
				'v3' => '/baoxiananli/shouxian/',
				'v4' => 'zs1_pic6.jpg',
				'v5' => 'float: right;'
		),
		'11071' => array (
				'v1' => 'zs_icon_3',
				'v2' => '养老险案例',
				'v3' => '/baoxiananli/yanglao/',
				'v4' => 'zs1_pic7.jpg',
				'v5' => 'float: left;'
		),
		'11081'  => array (
				'v1' => 'zs_icon_4',
				'v2' => '其他案例',
				'v3' => '/baoxiananli/qita/',
				'v4' => 'zs1_pic8.jpg',
				'v5' => 'float: right;'
		)
	);
}
// new 保险问答 faq
$is_faq = false;
if (stripos(request_path(), 'faq') !== false) {
	$brgz = '';//'1|4|5|8';
	$hdpid = 4;
	$hdpmc = "保险问答";
	$zx_type = 120;
	$link = 'faq/';
	$is_faq = true;
	$parr = array ();
}

$data = '';
if($is_faq){
	$sql = "SELECT COUNT(*) num FROM cigna_cmc_node AS a LEFT JOIN cigna_cmc_field_data_field_category AS b ON a.nid=b.entity_id LEFT JOIN cigna_cmc_field_data_field_psort AS c ON a.nid=c.entity_id LEFT JOIN cigna_cmc_url_alias AS d ON d.source=CONCAT('node/',a.nid) LEFT JOIN cigna_cmc_metatag e ON a.nid=e.entity_id WHERE a.status=1 AND SUBSTR(b.field_category_value,1,3) = $zx_type and (not exists(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.entity_id= p.entity_id) or(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.entity_id=p.entity_id)=1) ORDER BY a.nid DESC";
	$num = db_query($sql)->fetch()->num;
	$url = CMCURL.request_path ();
	$pg = isset($_GET['page'])?htmlspecialchars(trim($_GET['page'])):1;
	$pg = is_numeric ( $pg ) ? intval ( $pg ) : 1;
	$pg = empty($pg)?1:$pg;
	$limit = 10;
	$offset = ($pg-1)*$limit;
	$total = ceil($num/$limit);
	$total = ($total>0)?$total:1;
	$pagehtml = pagination(array('page'=>$pg, 'total'=>$total, 'url'=>$url));
	$sql = "SELECT a.nid, a.title, d.alias, e.data FROM cigna_cmc_node AS a LEFT JOIN cigna_cmc_field_data_field_category AS b ON a.nid=b.entity_id LEFT JOIN cigna_cmc_field_data_field_psort AS c ON a.nid=c.entity_id LEFT JOIN cigna_cmc_url_alias AS d ON d.source=CONCAT('node/',a.nid) LEFT JOIN cigna_cmc_metatag e ON a.nid=e.entity_id WHERE a.status=1 AND SUBSTR(b.field_category_value,1,3) = $zx_type and (not exists(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.entity_id= p.entity_id) or(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.entity_id=p.entity_id)=1) ORDER BY a.nid DESC LIMIT $offset , $limit";
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
		$desc = unserialize($row->data);
		$desc = $desc['description']['value'];
		$data_arr[] = array (
				'url' => $turl,
				'title' => mb_substr($title, 0, 32),
				'desc' => mb_substr($desc, 0, 45).(strlen($desc)==strlen(mb_substr($desc, 0, 45))?'':' ...')
		);
	}
}
foreach ( $parr as $key => $val ) {
	$keyid = intval($key);
	$sql = "SELECT b.nid, b.title,b.created,c.alias FROM cigna_cmc_field_data_field_category AS a LEFT JOIN cigna_cmc_node AS b ON a.entity_id = b.nid LEFT JOIN cigna_cmc_url_alias AS c ON c.source =CONCAT('node/',b.nid) WHERE b.status = 1 AND a.field_category_value = $keyid and (not exists(select p.field_platform_value from cigna_cmc_field_data_field_platform p where a.entity_id= p.entity_id) or(select p.field_platform_value from cigna_cmc_field_data_field_platform p where a.entity_id=p.entity_id)=1)  ORDER BY b.nid DESC LIMIT 0 , 5";
	$result = db_query ( $sql );
	$title = '';
	$turl = '';
	$res = '';
	foreach ( $result as $row ) {
		$id = $row->nid;
		$title = $row->title;
		$time = date("Y-m-d",$row->created);
		/*$pnid = "node/" . $row->nid;
		$plsqla = "SELECT alias FROM cigna_cmc_url_alias WHERE source = '$pnid' LIMIT 0,1";
		$resulta = db_query ( $plsqla );
		$alias = '';
		if (! empty ( $result )) {
			foreach ( $resulta as $rowa ) {
				$alias = $rowa->alias;
				break;
			}
		}*/
		$alias = $row->alias;
		if ($alias) {
			$turl = CMCURL . $alias;
		} else {
			$turl = CMCURL . "node/" . $row->nid;
		}
		$res[] = array (
				'id' => $id,
				'time' => $time,
				'url' => $turl,
				'title' => mb_substr($title, 0,18)
		);
	}
	if (is_array($res)) {
		$data[] = array (
			'v1' => $parr["$keyid"]['v1'],
			'v2' => $parr["$keyid"]['v2'],
			'v3' => $parr["$keyid"]['v3'],
			'v4' => $parr["$keyid"]['v4'],
			'v5' => $parr["$keyid"]['v5'],
			'rows' => $res
		);
	}
}

//分页
function pagination($params = array()) {
	$sl = 6;
	$page = is_numeric ( $params ['page'] ) ? intval ( $params ['page'] ) : 1;
	$total = is_numeric ( $params ['total'] ) ? intval ( $params ['total'] ) : 1;
	$url = ! empty ( $params ['url'] ) ? trim ( $params ['url'] ) : '';
	if (stripos($url,"?") !== false) {
		$urls = explode ( "&page=", $url );
		$url = $urls [0];
		//$a = $url . '&page=';
		$a = $url . '/page-';
	} else {
		$urls = explode ( "?page=", $url );
		$url = $urls [0];
		//$a = $url . '?page=';
		$a = $url . '/page-';
	}
	
	$fy = '';
	$fto = 0;
	$fi = 0;
	if ($total > $sl) {
		$fi = ($page > $sl) ? ($page - $sl) : 1;
		$fto = ($total > ($page + $sl)) ? $page + $sl : $total;
	} else {
		$fi = 1;
		$fto = $total;
	}
	for($i = $fi; $i <= $fto; $i ++) {
		//$fora = $a . $i;
		$fora = $a . $i . '.html';
		if ($page == $i) {
			$fy .= "<a href='javascript:;' class='c_fycur'>$i</a>";
		} else {
			$fy .= "<a href='$fora'>$i</a>";
		}
	}
	if ($page == 1 || $total == 1) {
		$homepg = "<a href='javascript:;'>第一页</a>";
	} else {
		//$homepga = $a . 1;
		$homepga = $a . '1.html';
		$homepg = "<a href='$homepga'>第一页</a>";
	}
	if ($page == 1 || $total == 1) {
		$prepg = "<a href='javascript:;'>上页</a>";
	} else {
		//$prepga = $a . ($page - 1);
		$prepga = $a . ($page - 1) . '.html';
		$prepg = "<a href='$prepga'>上页</a>";
	}
	if ($page == $total || $total == 1) {
		$netpg = "<a href='javascript:;'>下页</a>";
	} else {
		//$netpga = $a . ($page + 1);
		$netpga = $a . ($page + 1) . '.html';
		$netpg = "<a href='$netpga'>下页</a>";
	}
	
	if ($page == $total || $total == 1) {
		$lastpg = "<a href='javascript:;'>尾页</a>";
	} else {
		//$lastpga = $a . $total;
		$lastpga = $a . $total . '.html';
		$lastpg = "<a href='$lastpga'>尾页</a>";
	}
	$lastpg .= "<span>共". $total."页</span>";
	return "<div class='listPage'>" . $homepg . $prepg . $fy . $netpg . $lastpg . "</div>";
}

//获取热门
$hot_arr = array();
if(!empty($zx_type)){
	$sql = "SELECT a.nid, a.title, d.alias FROM cigna_cmc_node AS a LEFT JOIN cigna_cmc_field_data_field_category AS b ON a.nid=b.entity_id LEFT JOIN cigna_cmc_field_data_field_psort AS c ON a.nid=c.entity_id LEFT JOIN cigna_cmc_url_alias AS d ON d.source=CONCAT('node/',a.nid) WHERE a.status=1 AND SUBSTR(b.field_category_value,1,3) = $zx_type AND c.field_psort_value>0 and (not exists(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.entity_id= p.entity_id) or(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.entity_id=p.entity_id)=1)  ORDER BY c.field_psort_value DESC, a.nid DESC LIMIT 0 , 6";
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
		$hot_arr[] = array (
				'url' => $turl,
				'title' => addslashes($title),
				'stitle' =>  addslashes(mb_substr($title, 0,15))
		);
	}
}
// 获取栏目的18条记录 如果热门文章有不去重
$all_arr = array();
if(!empty($zx_type)){
	$sql = "SELECT d.alias, a.nid, a.title,c.field_psort_value FROM cigna_cmc_node AS a LEFT JOIN cigna_cmc_field_data_field_category AS b ON a.nid = b.entity_id LEFT JOIN cigna_cmc_field_data_field_psort AS c ON b.entity_id = c.entity_id LEFT JOIN cigna_cmc_url_alias AS d ON d.source =CONCAT('node/',a.nid) WHERE a.status = 1 AND SUBSTR(b.field_category_value,1,3) = $zx_type and (not exists(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.entity_id= p.entity_id) or(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.entity_id=p.entity_id)=1)  ORDER BY a.nid DESC LIMIT 0 , 18";
	$result = db_query ( $sql );
	$title = '';
	$turl = '';
	$ret = array();
	foreach ( $result as $row ) {
		$alias = $row->alias;
		$title = mb_substr ( $row->title, 0, 21 );
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
	<!-- Lower level page content -->
	<div id="PrtContainer">
		<div id="line"></div>
		<div id="PrtContainerInsider">
		<?php print $breadcrumb; ?>
		<?php 
		// 再最后一个div前插入block98内容
		$zixun_left = render($page['zixun_left']);
		$zixun_left = preg_replace('#([\s\S]*)</div>#', "$1{$block98}</div>", $zixun_left);
		print $zixun_left;
		?>
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
						$imgpfx = "zx_banner";//图片名称前缀，图片的格式都必须是jpg
						//以下是图片的链接url，链接url的数量要和幻灯片图片的数量一致
						$hdpurl1 = CMCURL . "shop/chengzhangzhinuo.html";
						$hdpurl2 = CMCURL . "shop/changqingshou.html";
						$hdpurl3 = CMCURL . "shop/lirenyounuo.html";
						$hdpurl4 = CMCURL . "shop/huodong/yiwaixian.html";
						$hdpurl5 = CMCURL . "shop/zhongjixian.html";
						$hdpurl6 = CMCURL . "shop/zhouquanbao.html";
						$hdpurl7 = "http://member.cigna-cmc.com/es/cigna-cmc-esales/DomesticAction.do";
						$hdpurl8 = CMCURL . "shop/lekangwuyou.html";
						$hdpurl9 = CMCURL . "shop/shaoerxian.html";
						$hdpurl10 = CMCURL . "campaign/ipmi/zftongyong/index.php";//"shop/huanqiuzhizun.html";
						$hdpurl11 = CMCURL . "shop/lexiangruijian.html";
						$hdpurl12 = CMCURL . "shop/zhixiangruijian.html";
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
						$alt12 = "智享睿健";
						$brgz = strval($brgz);
						$splvals = explode('|', $brgz);
						$splval = '';
					?>
					  <ul class="cb_slider" >
							<?php for ($hdi = 1; $hdi <= $hdpimgs;$hdi++) {$splval = $splvals[$hdi - 1];?>
							<li><a onclick="_gaq.push(['_trackEvent', '<?php echo $hdpmc;?>', 'click', 'banner<?php echo $hdi;?>']);" href="<?php echo ${"hdpurl" . $splval};?>" target="_blank" otype="<?php echo $hdpmc;?>" otitle="<?php echo ${"alt" . $splval};?>" oarea="banner"><img src="/sites/default/themes/cigna_cmc/images/<?php echo $imgpfx;?><?php echo $splval;?>.jpg" alt="<?php echo ${"alt" . $splval};?>"/></a></li>
							<?php }?>
						  </ul>
					  <ul class="cb_num" >
					  	<?php for ($hdj = 1; $hdj <= $hdpimgs;$hdj++) {?>
						<li><?php echo $hdj;?></li>
						<?php }?>
					  </ul>
				</div>
				<?php } if($is_faq){?>
				<div class="block_1 zslist" style="margin-top:0px;">
				<div class="top">
					<span class="title_1 title_icon_0">保险问答</span>
				</div>
				<ul class="question_list">
					<?php foreach ($data_arr as $dk => $dv) { ?>
					<li id="faq_tbr">
						<div class="q_ask">
							<a href="<?php echo $dv['url'];?>"><?php echo $dv['title'];?></a>
						</div>
						<div class="q_reply" style="background:none;padding-left:30px;"><?php echo $dv['desc'];?><a href="<?php echo $dv['url'];?>" style="float:right;">[阅读全文]</a></div>
					</li>
					<?php }?>
				</ul>
				<?php print $pagehtml;?>
				</div>
				<?php }else{ foreach ($data as $kk => $vv) {?>
				<div class="block_1 zs_1" style="width: 340px; <?php echo $vv['v5'];?>">
					<div class="ex">
						<div class="top" style="width: 320px">
							<span class="title_1 <?php echo $vv['v1'];?> zs_icon"><span
								class="zs_b_title"><a href="<?php echo $vv['v3'];?>" target="_blank"><?php echo $vv['v2'];?></a></span><a class="zs_more_link"
								href="<?php echo $vv['v3'];?>" target="_blank" style="float: right;">更多<img
									src="/sites/default/themes/cigna_cmc/images/more_ico.jpg" /></a></span>
						</div>
						<div class="content">
							<img height="78"
								src="/sites/default/themes/cigna_cmc/images/<?php echo $vv['v4'];?>"
								width="310" />
							<ul>
								<?php foreach ($vv['rows'] as $vval) {?>
								<li><a href="<?php echo $vval['url'];?>" target="_blank" ><?php echo $vval['title'];?></a><span><?php echo $vval['time'];?></span></li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
				<?php }}?>
				<div class="content clearfix">&nbsp;</div>
			</div>
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
