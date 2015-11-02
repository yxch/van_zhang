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
        if (subFloder.indexOf("baoxianzhishi") == 0 
				|| subFloder.indexOf("baoxiananli") == 0
					|| subFloder.indexOf("baoxianwenda") == 0) {
            var params = window.location.search;
            if (params == "" || params == undefined) {
                params = "?WT.mc_id=DMDPC"
            } else {
                params = params + "&WT.mc_id=DMDPC"
            }
			
			if(subFloder.indexOf("baoxianwenda") == 0){
				subFloder = "bxwd";
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
<?php

/**
 * 幻灯片显示数组即banner的显示定义
 * 根据不同url，幻灯片的显示顺序可能不同，由变量$imgsort决定，即如果没有定义$imgsort则默认按数组$imgArr的顺序显示
 * 图片的格式都必须是jpg
 * imgsrc 是图片的名称，将与$pathPrefix一起组成完整的路径
 * href 是用户点击图片的跳转地址将与常量 CMCURL  一起组完整的路径
 * alt 是用户在图片上停留时的提示
 * van_zhang 2015/11/02
 */
$pathPrefix = '/sites/default/themes/cigna_cmc/images/'; //图片路径前缀
$imgArr = array(array('imgsrc'=>'zx_banner5.jpg','href'=>'shop/zhongjixian.html','alt'=>'重疾险'),
	            array('imgsrc'=>'zx_banner8.jpg','href'=>'shop/lekangwuyou.html','alt'=>'乐康无忧'),
	            array('imgsrc'=>'zx_banner6.jpg','href'=>'shop/zhouquanbao.html','alt'=>'周全保'),
	            array('imgsrc'=>'zx_banner10.jpg','href'=>'shop/huanqiuzunxiang.html','alt'=>'寰球至尊')	);

$imgsort = '0,1,2,3';  //默认的显示顺序

$tflag = (stripos ( request_path (), 'baoxianwenda' ) !== false) ? 1 : 0;
$link = 'baoxianzhishi/';
$keyid = 0;
$ktit = '';
$brgz = '';
$is_faq = false;

$relations = array('baoxianzhishi/yiliao'=>array('ptype'=>'保险知识','keyid'=>10011,'ktit'=>'健康与医疗保险知识','imgsort'=>'0,1,2,3','link'=>'baoxianzhishi/yiliao'),
				   'baoxianzhishi/shaoer'=>array('ptype'=>'保险知识','keyid'=>10021,'ktit'=>'少儿险知识','imgsort'=>'0,1,2,3','link'=>'baoxianzhishi/shaoer'),
				   'baoxianzhishi/yiwai'=>array('ptype'=>'保险知识','keyid'=>10031,'ktit'=>'意外险知识','imgsort'=>'0,1,2,3','link'=>'baoxianzhishi/yiwai'),
				   'baoxianzhishi/lvyou'=>array('ptype'=>'保险知识','keyid'=>10041,'ktit'=>'旅游险知识','imgsort'=>'0,1,2,3','link'=>'baoxianzhishi/lvyou'),
				   'baoxianzhishi/toulianxian'=>array('ptype'=>'保险知识','keyid'=>10051,'ktit'=>'投资分红险知识','imgsort'=>'0,1,2,3','link'=>'baoxianzhishi/toulianxian'),
				   'baoxianzhishi/shouxian'=>array('ptype'=>'保险知识','keyid'=>10061,'ktit'=>'高端医疗险知识','imgsort'=>'0,1,2,3','link'=>'baoxianzhishi/shouxian'),
				   'baoxianzhishi/yanglao'=>array('ptype'=>'保险知识','keyid'=>10071,'ktit'=>'养老险知识','imgsort'=>'0,1,2,3','link'=>'baoxianzhishi/yanglao'),
				   'baoxianzhishi/qita'=>array('ptype'=>'保险知识','keyid'=>10081,'ktit'=>'其他知识','imgsort'=>'0,1,2,3','link'=>'baoxianzhishi/qita'),
				   'baoxiananli/yiliao'=>array('ptype'=>'保险案例','keyid'=>11011,'ktit'=>'健康医疗险案例','imgsort'=>'0,1,2,3','link'=>'baoxiananli/yiliao'),
				   'baoxiananli/shaoer'=>array('ptype'=>'保险案例','keyid'=>11021,'ktit'=>'少儿险案例','imgsort'=>'0,1,2,3','link'=>'baoxiananli/shaoer'),
				   'baoxiananli/yiwai'=>array('ptype'=>'保险案例','keyid'=>11031,'ktit'=>'意外险案例','imgsort'=>'0,1,2,3','link'=>'baoxiananli/yiwai'),
				   'baoxiananli/lvyou'=>array('ptype'=>'保险案例','keyid'=>11041,'ktit'=>'旅游险案例','imgsort'=>'0,1,2,3','link'=>'baoxiananli/lvyou'),
				   'baoxiananli/toulianxian'=>array('ptype'=>'保险案例','keyid'=>11051,'ktit'=>'投资分红险案例','imgsort'=>'0,1,2,3','link'=>'baoxiananli/toulianxian'),
				   'baoxiananli/shouxian'=>array('ptype'=>'保险案例','keyid'=>11061,'ktit'=>'高端医疗险案例','imgsort'=>'0,1,2,3','link'=>'baoxiananli/shouxian'),
				   'baoxiananli/yanglao'=>array('ptype'=>'保险案例','keyid'=>11071,'ktit'=>'养老险案例','imgsort'=>'0,1,2,3','link'=>'baoxiananli/yanglao'),
				   'baoxiananli/qita'=>array('ptype'=>'保险案例','keyid'=>11081,'ktit'=>'其他案例','imgsort'=>'0,1,2,3','link'=>'baoxiananli/qita'),
				   'faq/baby'=>array('ptype'=>'保险问答','keyid'=>12010,'ktit'=>'给孩子买保险','imgsort'=>'0,1,2,3','link'=>'faq/baby'),
				   'faq/honey'=>array('ptype'=>'保险问答','keyid'=>12011,'ktit'=>'给自己和爱人买保险','imgsort'=>'0,1,2,3','link'=>'faq/honey'),
				   'faq/parents'=>array('ptype'=>'保险问答','keyid'=>12012,'ktit'=>'给父母买保险','imgsort'=>'0,1,2,3','link'=>'faq/parents'),
				   'faq/baike'=>array('ptype'=>'保险问答','keyid'=>12013,'ktit'=>'保险百科','imgsort'=>'0,1,2,3','link'=>'faq/baike'),
				   'faq/lipei'=>array('ptype'=>'保险问答','keyid'=>12014,'ktit'=>'保险理赔','imgsort'=>'0,1,2,3','link'=>'faq/lipei'),
				   'faq/zengzhi'=>array('ptype'=>'保险问答','keyid'=>12015,'ktit'=>'保险增值','imgsort'=>'0,1,2,3','link'=>'faq/zengzhi'),
				   'zhuanti'=>array('ptype'=>'保险专题','keyid'=>30011,'ktit'=>'保险增值','imgsort'=>'0,1,2,3','link'=>'zhuanti')										   );

$ptype = '';
$keyid = 12010;
$ktit = '给孩子买保险';
$link = 'faq/baby';
$is_faq = false;

if(stripos(request_path (), 'faq' ) !== false){ $is_faq = true; }
foreach($relations as $key => $val)
{
	if(stripos(request_path (),$key) !== false)
	{
		$ptype = $val['ptype'];
		$keyid = $val['keyid'];
		$ktit = $val['ktit'];
		$imgsort = $val['imgsort'];
		$link = $val['link'];
		break;
	}
}
// 获取分页
//and (not exists(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.nid= p.entity_id) or(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.nid=p.entity_id)=1)
$sql = "SELECT COUNT(*) num FROM cigna_cmc_field_data_field_category AS a LEFT JOIN cigna_cmc_node AS b ON a.entity_id = b.nid LEFT JOIN cigna_cmc_url_alias AS c ON c.source =CONCAT('node/',b.nid) WHERE b.status = 1 AND c.alias NOT IN('ipmi2/zhuanti/zhifu.html','ipmi2/zhuanti/yakebaoxian.html','ipmi2/zhuanti/gaoduanyiliao.html','ipmi2/zhuanti/xieheyiyuan.html','ipmi2/zhuanti/business.html','ipmi2/zhuanti/babycare.html') AND a.field_category_value = $keyid and (not exists(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.nid= p.entity_id) or(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.nid=p.entity_id)=1) ORDER BY b.nid DESC";
$num = db_query($sql)->fetch()->num;
$url = CMCURL.request_path ();
$pg = isset($_GET['page'])?htmlspecialchars(trim($_GET['page'])):1;
$pg = is_numeric ( $pg ) ? intval ( $pg ) : 1;
$pg = empty($pg)?1:$pg;
$limit = ($is_faq)?10:30;
$offset = ($pg-1)*$limit;
$total = ceil($num/$limit);
$total = ($total>0)?$total:1;
$pagehtml = pagination(array('page'=>$pg, 'total'=>$total, 'url'=>$url));
//获取列表内容
$sql = "SELECT b.nid, b.title,b.created,c.alias,d.data FROM cigna_cmc_field_data_field_category AS a LEFT JOIN cigna_cmc_node AS b ON a.entity_id = b.nid LEFT JOIN cigna_cmc_url_alias AS c ON c.source =CONCAT('node/',b.nid)  LEFT JOIN cigna_cmc_metatag d ON d.entity_id = b.nid WHERE b.status = 1 AND c.alias NOT IN('ipmi2/zhuanti/zhifu.html','ipmi2/zhuanti/yakebaoxian.html','ipmi2/zhuanti/gaoduanyiliao.html','ipmi2/zhuanti/xieheyiyuan.html','ipmi2/zhuanti/business.html','ipmi2/zhuanti/babycare.html') AND a.field_category_value = $keyid and (not exists(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.nid= p.entity_id) or(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.nid=p.entity_id)=1) ORDER BY b.nid DESC LIMIT $offset , $limit";
$result = db_query ( $sql ); 
$title = '';
$turl = '';
$res = array();
foreach ( $result as $row ) {
	$id = $row->nid;
	$title = $row->title; 
	$time = $row->created;
	$alias = $row->alias;
	if ($alias) {
		$turl = CMCURL . $alias;
	} else {
		$turl = CMCURL . "node/" . $row->nid;
	}
	$data = array (
		'id' => $id,
		'time' => date ( "Y-m-d", $time ),
		'url' => $turl,
		'title' => mb_substr($title, 0,32)
	);
	$desc = unserialize($row->data);
	$desc = $desc['description']['value'];
	$data['desc'] = mb_substr($desc, 0, 45).(strlen($desc)==strlen(mb_substr($desc, 0, 45))?'':' ...');
	$res[] = $data;
}

if (stripos ( request_path (), 'zhuanti' ) !== false && $total==$pg ) {
	$res[] = array(
		'id' => 0,
		'time' => '2013-11-28',
		'url' => CMCURL.'campaign/ganenjie/',
		'title' => '2013年感恩节专题',
		'desc' => '招商信诺感恩节专题,专为少儿量身打造,涵盖了教育金,重大疾病,身故保障,并且还特别含有保费...'
	);
	$res[] = array (
			'id' => 0,
			'time' => '2013-05-01',
			'url' => CMCURL.'baoxianzhuanti/zhuyuanyiliao.html',
			'title' => '住院医疗保险专题',
			'desc' => '招商信诺住院医疗保险专题,为您全面解读深圳个人住院医疗保险,专题介绍了关于住院医疗保险的热...'
	);
	$res[] = array(
		'id' => 0,
		'time' => '2013-05-01',
		'url' => CMCURL.'10thbirthday/',
		'title' => '招商信诺“十周年”专题',
		'desc' => '招商信诺十周年庆典系列活动邀您参与,”10”年风雨阳光,感谢有您相伴;”10”周年生日,真心回馈客户.3万意...'
	);
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
$where = 'and (not exists(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.entity_id= p.entity_id) or(select p.field_platform_value from cigna_cmc_field_data_field_platform p where b.entity_id=p.entity_id)=1)';
if(!empty($keyid)){
	$sql = "SELECT a.nid, a.title, d.alias FROM cigna_cmc_node AS a LEFT JOIN cigna_cmc_field_data_field_category AS b ON a.nid=b.entity_id LEFT JOIN cigna_cmc_field_data_field_psort AS c ON a.nid=c.entity_id LEFT JOIN cigna_cmc_url_alias AS d ON d.source=CONCAT('node/',a.nid) WHERE a.status=1  AND b.field_category_value = $keyid AND c.field_psort_value>0 $where ORDER BY c.field_psort_value DESC, a.nid DESC LIMIT 0 , 6";
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
if(!empty($keyid)){
	$sql = "SELECT a.nid, a.title,a.created,c.alias FROM cigna_cmc_node AS a LEFT JOIN cigna_cmc_field_data_field_category AS b ON b.entity_id = a.nid LEFT JOIN cigna_cmc_url_alias AS c ON c.source =CONCAT('node/',a.nid) WHERE a.status = 1 AND b.field_category_value = $keyid $where ORDER BY a.nid DESC LIMIT 0 , 18";
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
$temp_arr = array();
if($keyid==30011){
	$all_arr[] = array('url'=>CMCURL.'campaign/ganenjie/','title'=>'2013年感恩节专题','stitle'=>'2013年感恩节专题');
	$all_arr[] = array('url'=>CMCURL.'baoxianzhuanti/zhuyuanyiliao.html','title'=>'住院医疗保险专题','stitle'=>'住院医疗保险专题');
	$all_arr[] = array('url'=>CMCURL.'10thbirthday/','title'=>'招商信诺“十周年”专题','stitle'=>'招商信诺“十周年”专题');
	$all_arr[] = array('url'=>CMCURL.'10thbirthday/shengrixuyuan.php','title'=>'“生日许愿”专题','stitle'=>'“生日许愿”专题');
	$all_arr[] = array('url'=>CMCURL.'campain/ipmi-qz/?WT.mc_id=HDQZ&iq_id=QZ&campaign=PCHDQZ','title'=>'“亲子关爱”专题','stitle'=>'“亲子关爱”专题');
	$all_arr[] = array('url'=>CMCURL.'birthday/10th/dsj.html','title'=>'招商信诺“十年大事记”','stitle'=>'招商信诺“十年大事记”');
}
if(count($hot_arr)==0){
	$hot_arr = ($keyid==30011&&count($all_arr)<19)?array_slice($all_arr, (count($all_arr)-6), 6):array_slice($all_arr, 12, 6);
}else{
	$num = 6-count($hot_arr);
	for($i = 0;$i<$num;$i++){
		$key = ($keyid==30011&&count($all_arr)<19)?((count($all_arr)-6)+$i):(13+$i);
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
<div id="page" class="container clearfix">
	<script type="text/javascript"
		src="<?php print $base_path . $directory; ?>/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript"
		src="<?php print $base_path . $directory; ?>/js/TrackingCodeIQID.js"></script>
	<script type="text/javascript"
		src="<?php print $base_path . $directory; ?>/js/TrackingCode.js"></script>
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
	<!-- Header region -->
<?php include 'include-header.tpl.php';?>


<!-- End header region -->

<?php print render($page['mainNav']); ?>
	<!-- Main navigation region -->
	<!-- Lower level page content -->
	<div id="PrtContainer">
		<div id="line"></div>
		<div id="PrtContainerInsider">
		<?php print customer_cigna_cmc_breadcrumb(); ?>
		<?php 
		// 再最后一个div前插入block98内容
		$zixun_left = render($page['zixun_left']);
		$zixun_left = preg_replace('#([\s\S]*)</div>#', "$1{$block98}</div>", $zixun_left);
		print $zixun_left;
		?>
		 <!-- shopping mall left region -->
			<div id="ZixunColumn">
				<div class="field-item">
					<div class="block_1 zslist" style="margin-top:0px;">
                    	<div style="margin-bottom:10px;">

                    		<div class="cb_adbox" >
								<ul class="cb_slider" >
								<?php
									$imgsortArr = explode(',',$imgsort); $len = count($imgsortArr);
									for($i=0;$i<$len;$i++){
								<?php } ?>				  							
									<li>
										<a name="<?php echo $imgArr[$i]['imgsrc']; ?>" class="gaq" href="<?php echo CMCURL . $imgArr[$i]['href'];?>" target="_blank">
											<img src="<?php echo $pathPrefix . $imgArr[$i]['imgsrc']; ?>" alt="<?php echo $imgArr[$i]['alt']; ?>"/>
										</a>
									</li>
									<?php }?>
								</ul>
								<ul class="cb_num" ><?php for($j = 0; $j <= $len;$j++){ ?><li> <?php echo $j;?></li> <?php }?> </ul>
							</div>
							<script type="text/javascript">	
								//可能是跟踪代码需要？？
								$('.gaq').click(function(){ var banner = $(this).attr('name'); _gaq.push(['_trackEvent', '<?php echo $hdpmc;?>', 'click', banner]); });

								//图片切换		
								var len  = <?php echo $len; ?>;
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
							
								function showImg(index){
								    var adHeight = $(".cb_adbox").height();
									$(".cb_slider").stop(true,false).animate({top : -adHeight*index},0);
									$(".cb_num li").removeClass("on").eq(index).addClass("on");
								}
							</script>						
						</div>

						
				<?php if (!$tflag) {?>
						<div class="top">
							<span class="title_1 title_icon_0"><?php echo $ktit;?></span>
						</div>
							<ul class="question_list faq">
								<?php foreach ($res as $val) { ?>
								<li>
										<div class="q_ask" <?php  echo ($is_faq)?'':'style="padding:0 0 15px 0;background:none;"';?> >
										<a href="<?php echo $val['url'];?>"><?php echo $val['title'];?></a>
									</div>
									<div class="q_reply" style="background:none;<?php  echo ($is_faq)?'padding-left:30px;':'padding-left:2em;';?>"><?php echo $val['desc'];?><a href="<?php echo $val['url'];?>" style="float:right;">[阅读全文]</a></div>
								</li>
								<?php }?>
							</ul>
						<?php print $pagehtml; ?>
					<?php } else {?>
						<div class="top">
							<span class="title_1 title_icon_0">保险问答</span>
						</div>
						<ul class="question_list">
							<li id="faq_tbr"><div class="q_ask">
									<a name="01"></a>什么是投保人？
								</div>
								<div class="q_reply">投保人指与保险公司订立保险合同，并按照保险合同负有支付保险费义务的人。</div></li>
							<li id="faq_bbr"><div class="q_ask">
									<a name="02"></a>什么是被保人？
								</div>
								<div class="q_reply">指根据保险合同，其身体或生命受保险合同保障，享有保险金请求权的人。
									被保人年龄应为60天-70周岁。18周岁以下未成年人须由父母（包括继父母和养父母）、或其他法定监护人为其投保。</div></li>
							<li id="faq_stb"><div class="q_ask">
									<a name="03"></a>我能为谁投保？
								</div>
								<div class="q_reply">投保人与被保险人之间必须存在保险利益关系，投保人对以下人员具有保险利益：①本人、配偶、子女、父母。
									②有抚养、赡养或者有扶养关系的家庭其他成员、近亲属。</div></li>
							<li id="faq_bxd"><div class="q_ask">
									<a name="04"></a>什么是保险单？
								</div>
								<div class="q_reply">简称保单，指保险公司给投保人的凭证，证明保险合同的成立及内容。保单上载有参加保险的种类、保险金额、保险费、保险期限等保险合同的主要内容，保险单是一种具有法律效力的文件。</div></li>
							<li id="faq_bxje"><div class="q_ask">
									<a name="05"></a>什么是保险金额？
								</div>
								<div class="q_reply">简称保额，指保险公司承担赔偿或者给付保险金责任的最高限额。</div></li>
							<li id="faq_bfkm"><div class="q_ask">
									<a name="06"></a>怎样理赔？
								</div>
								<div class="q_reply">招商信诺全国统一客服电话400-888-8288，提供方便快捷的理赔报案服务。</div></li>
							<li id="faq_bfkm"><div class="q_ask">
									<a name="07"></a>什么是保费豁免？
								</div>
								<div class="q_reply">所谓保费豁免，是指在保险合同规定的某些特定情况下导致完全丧失工作能力时，由保险公司获准，同意投保人可以不再缴纳后续保费，保险合同仍然有效。失去工作能力意味着收入锐减，如果保单附加了保费豁免功能，就可在一定程度上避免因为失业而带来的经济困难，保费豁免是保险中一种人性化的功能。</div></li>
							<li id="faq_syr"><div class="q_ask">
									<a name="08"></a>招商信诺的&quot;全球紧急救援服务&quot;提供哪些服务项目？
								</div>
								<div class="q_reply">被保险人在其居住地所属城市行政区域以外因遭受意外伤害或突发性急病需紧急救援的，我方授权的救援机构提供24小时救援热线电话服务，并承担下列保险责任：1．安排就医；2．转院服务；3.
									转运回居住地；4. 儿童住院陪护；5. 安排子女返回居住地；6. 亲属探访；7. 遗体火化；8.骨灰运送回居住地。</div></li>
							<li id="faq_syr"><div class="q_ask">
									<a name="09"></a>招商信诺的&quot;第二医疗意见服务&quot;提供哪些服务项目？
								</div>
								<div class="q_reply">对于被诊断为重大疾病或癌症的客户，为了确认诊断的正确性，可以把相关的病历资料传送给世界权威的医疗机构，由具特别资历的专科医师及病理专家，对患者的病情进行诊断以及治疗方式做出复审；除了降低误诊和错误治疗的概率，更重要的是获得先进有效的治疗方式的建议。目前该项咨询服务提供合作商为成立于美国的全球第二医疗意见咨询服务的领导者MediGuide
									America公司。</div></li>
							<li id="faq_yyq"><div class="q_ask">
									<a name="10"></a>什么是犹豫期？
								</div>
								<div class="q_reply">犹豫期是指投保人签收保单后15个自然日内，可以无条件向保险公司提出退保，该&ldquo;15个自然日&rdquo;即通常所说的&ldquo;犹豫期&rdquo;。在犹豫期内申请解约退保，我公司将全额退还缴纳的保费。客户可以充分利用&ldquo;犹豫期&rdquo;的有关规定，冷静考虑自己投保的险种、期限、费用是否合适，更好地保障自己的利益。</div></li>
							<li id="faq_yyq"><div class="q_ask">
									<a name="11"></a>犹豫期内退保会扣手续费吗？
								</div>
								<div class="q_reply">犹豫期内退保是不收取手续费的，我公司将全额退还缴纳的保费。犹豫期后，投保人仍然有解除合同的权利，但会存在退保损失。</div></li>
							<li id="faq_yyq"><div class="q_ask">
									<a name="12"></a>重大疾病保险保障的30种重疾有哪些？
								</div>
								<div class="q_reply">1.恶性肿瘤 2.急性心肌梗塞 3.脑中风后遗症 4.重大器官移植术或造血干细胞移植术 5.冠状动脉搭桥术 6.终末期肾病 7.多个肢体缺失 8.急性或亚急性重症肝炎 9.良性脑肿瘤 10.慢性肝功能衰竭失代偿期 11.脑炎后遗症或脑膜炎后遗症 12.深度昏迷 13.双耳失聪 14.双目失明 15.瘫痪 16.心脏瓣膜手术 17.经输血导致的人类免疫缺陷病毒感染 18.严重脑损伤 19.严重多发性硬化20.严重Ⅲ度烧伤21.严重原发性肺动脉高压 22.严重运动神经元病 23.语言能力丧失 24.重型再生障碍性贫血25.主动脉手术<br/><font color='red'>以下5种专门针对18周岁及以上成年人</font>26.严重阿尔茨海默病 27.严重帕金森病 28.严重冠心病29.严重类风湿性关节炎30.系统性红斑狼疮<br/><font color='red'>以下5种专门针对18周岁以下未成年人</font>31.严重的1型糖尿病 32.严重心肌炎 33.严重川崎病 34.严重哮喘 35.严重幼年型类风湿性关节炎</div></li>
							<li id="faq_yyq"><div class="q_ask">
									<a name="13"></a>什么是原位癌？为什么招商信诺的重疾险产品多了这项保障？
								</div>
								<div class="q_reply">原位癌是癌的最早期，癌细胞没有发生转移，手术切除即可完全治愈，目前市面上大多数重大疾病保险均将原位癌排除在外，招商信诺重大疾病保险将其纳入责任范围内，提供更多安心保障。</div></li>
							<li id="faq_yyq"><div class="q_ask">
									<a name="14"></a>购买招商信诺的住院医疗保险后，会影响医保和其他商业医疗报销吗？
								</div>
								<div class="q_reply">不影响。招商信诺住院医疗保险，保障的是因意外或疾病住院治疗期间的费用，每日定额给付津贴，可用于补贴住院费、医药费、误工费等，并不影响医保和其他商业医疗保险的报销。</div></li>
							<li id="faq_yyq"><div class="q_ask">
									<a name="16"></a>我已经提交了预约信息，过多久会有保险顾问回呼服务？
								</div>
								<div class="q_reply">在网站成功提交预约信息后，招商信诺的专业保险顾问将于2个工作日内回呼为您提供产品咨询服务，来电号码为400-880-3633，请保持手机通畅，注意接听。</div></li>
							<li id="faq_yyq"><div class="q_ask">
									<a name="17"></a>出险后怎么理赔？需要哪些单证？
								</div>
								<div class="q_reply">招商信诺全国统一客服电话400-888-8288，提供方便快捷的理赔报案服务。详细保险理赔指引请查看：<a href="/service/lipei/liucheng.html" target="_blank">http://www.cignacmb.com/service/lipei/liucheng.html</a>，理赔所需单证：<a href="/service/lipei/wenjian.html" target="_blank">http://www.cignacmb.com/service/lipei/wenjian.html</a>。</div></li>
							<li id="faq_yyq"><div class="q_ask">
									<a name="18"></a>哪里可以查询或修改保单信息？
								</div>
								<div class="q_reply">成功投保后，您可以登录招商信诺网上自助服务系统（首次登录需要先注册），就可以进行保单查询以及修改部分保单信息。</div></li>
							<li id="faq_yyq"><div class="q_ask">
									<a name="19"></a>哪里可以查看投连险账户价值？
								</div>
								<div class="q_reply">招商信诺运筹帷幄终身寿险（投资连结型）单位价格查询：<a href="/service/toulianxian/jiage/evul.html" target="_blank">http://www.cignacmb.com/service/toulianxian/jiage/evul.html</a>。</div></li>
							<li id="faq_yyq"><div class="q_ask">
									<a name="20"></a>投连险网上投保支持哪些银行支付？
								</div>
								<div class="q_reply">招商信诺运筹帷幄终身寿险（投资连结型），网上直接投保并支付，目前支持中国农业银行、中国银行、中国建设银行、中国光大银行、招商银行、民生银行、中国工商银行、平安银行、中国邮政储蓄银行等银行卡在线支付。</div></li>
						</ul>
					<?php }?>
						<div class="clearBoth">&nbsp;</div>
					</div>
				</div>
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
<?php render($page['content']);?>
