<?php
/**
 * 引入外部方法（外来的和尚会念经）
 */

/** 
* Converts bytes into human readable file size. 
* 
* @param string $bytes 
* @return string human readable file size (2,87)
* @author Mogilev Arseny 
*/  
function FileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}

/**
 * The main logging function
 *
 * @uses error_log
 * @param string $type type of the error. e.g: debug, error, info
 * @param string $msg
 */
function new_log( $msg, $type = '' ) {
    if ( WP_DEBUG == true ) {
	    if ( ! is_string( $msg ) ) {
	        $msg = print_r( $msg, true );
	    }
        $msg = sprintf( "[%s][%s] %s\n", date( 'd.m.Y h:i:s' ), $type, $msg );
        
        error_log( $msg, 3, new_template . '/logs/log.' . date( 'Y.m.d' ) . '.txt' );
    }
}

/**
 * 面包屑脚本
 *
 * @author 胡倡萌
 * @url http://www.cmhello.com/wordpress-breadcrumbs.html
 * @editor kbdsbx
 */
function new_breadcrumbs() {
    global $post;
    global $wp_query;
    global $author;
 
    $delimiter = '&nbsp;&raquo;&nbsp;';
    $home = sprintf( '<a href="%s" >%s</a>', get_bloginfo( 'url' ), __( '主页', 'new' ) ); //text for the 'Home' link
    $breadcrumb_html = '';

    if ( ! is_home() && ! is_front_page() || is_paged() ) {
            $breadcrumb_html .= $home . $delimiter;
        if ( is_category() ) {
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ( $thisCat->parent != 0 )
                $breadcrumb_html .= get_category_parents( $parentCat, TRUE, $delimiter );
            $breadcrumb_html .= single_cat_title( '', false );
        } elseif ( is_day() ) {
            $breadcrumb_html .= get_the_time('Y') . $delimiter;
            $breadcrumb_html .= get_the_time('F') . $delimiter;
            $breadcrumb_html .= get_the_time('d');
        } elseif ( is_month() ) {
            $breadcrumb_html .= get_the_time('Y') . $delimiter;
            $breadcrumb_html .= get_the_time('F');
        } elseif ( is_year() ) {
            $breadcrumb_html .= get_the_time('Y');
        } elseif ( is_single() ) {
            $cat = get_the_category();
            $cat = $cat[0];
            $breadcrumb_html .= get_category_parents($cat, TRUE, $delimiter);
            $breadcrumb_html .= get_the_title();
        } elseif ( is_page() && ! $post->post_parent ) {
            $breadcrumb_html .= get_the_title();
        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ( $parent_id ) {
                $page = get_page( $parent_id );
                $breadcrumbs[] = '' . get_the_title($page->ID) . '';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ( $breadcrumbs as $crumb ) 
                $breadcrumb_html .= $crumb . $delimiter;
            $breadcrumb_html .= get_the_title();
        } elseif ( is_search() ) {
            $breadcrumb_html .= sprintf( __( '搜索“%s’的结果', 'new' ), get_search_query() );
        } elseif ( is_tag() ) {
            $breadcrumb_html .= single_tag_title( '', false );
        } elseif ( is_author() ) {
            $userdata = get_userdata( $author );
            $breadcrumb_html .= $userdata->display_name;
        } elseif ( is_404() ) {
            $breadcrumb_html .= 'Error 404';
        }
     
        if ( get_query_var('paged') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
                $breadcrumb_html .= sprintf( __( '（第%s页）', 'new' ), get_query_var( 'paged' ) );
            }
        }
    }
    return $breadcrumb_html;
}

/**
 * 分页脚本Pagenavi 
 * 
 * @author 王思捷
 * @url http://ilovetile.com/2410
 * @editor kbdsbx
 * @param numeric $p 中间显示页数
 * @param array $params 其他参数
 *              ul_class        分页样式
 *              active_class    当前页链接样式
 */
function new_pagenavi( $p = 5, $params = array() ) {   
    if ( is_singular() && ! is_page() )
        return;

    global $wp_query, $paged;
    $paged_html = '';

    $max_page = $wp_query->max_num_pages;
    $paged = empty( $paged ) ? 1 : $paged;

    if ( $max_page <= 1 ) return;

    $paged_html .= sprintf( '<ul class="%s">', _filter_array_empty( $params, 'ul_class' ) );
    $paged_html .= '<li><span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span></li>';

    if ( $paged > 1 )
        $paged_html .= p_link( $paged - 1, __( '上一页', 'new' ), '«' );   

    if ( $paged > $p + 1 )
        $paged_html .= p_link( 1, __( '首页', 'new' ) );

    if ( $paged > $p + 2 )
        $paged_html .= '<li><span>...</span><li>';

    for ( $i = $paged - $p; $i <= $paged + $p; $i++ ) {
        if ( $i > 0 && $i <= $max_page ) 
            $paged_html .= ( $i == $paged ? p_link( $i, '', '', true, $params ) : p_link( $i ) );   
    }   

    if ( $paged < $max_page - $p - 1 )
        $paged_html .= '<li><span>...</span><li>';

    if ( $paged < $max_page - $p )
        $paged_html .= p_link( $max_page, __( '尾页', 'new' ) );

    if ( $paged < $max_page )
        $paged_html .= p_link( $paged + 1, __( '下一页' ), '»' );

    $paged_html .= '</ul>';

    return $paged_html;
}   

/**
 * 分页脚本Pagenavi辅助方法
 * 
 * @author 王思捷
 * @url http://ilovetile.com/2410
 * @editor kbdsbx
 */
function p_link( $i, $title = '', $linktype = '', $current = false, $params = array() ) {   
    $title = $title != '' ? $title : sprintf( __( '第%s页', 'new' ), $i );
    $linktext = $linktype != '' ? $linktype : $i;
    return '<li class="' . ( $current ? _filter_array_empty( $params, 'active_class' ) : '' ) . '"><a class="' . ( $current ? 'active' : '' ) . '" href="' . esc_html( get_pagenum_link( $i ) ) . '" title="' . $title . '">' . $linktext . '</a></li>';   
}  


/**
 * PHP 汉字转拼音
 * @author Jerryli(hzjerry@gmail.com)
 * @version V0.20140715
 * @package SPFW.core.lib.final
 * @global SEA_PHP_FW_VAR_ENV
 * @example
 *	echo CUtf8_PY::encode('阿里巴巴科技有限公司'); //编码为拼音首字母
 *	echo CUtf8_PY::encode('阿里巴巴科技有限公司', 'all'); //编码为全拼音
 */
class CUtf8_PY {
	/**
	 * 拼音字符转换图
	 * @var array
	 */
	private static $_aMaps = array(
		'a'=>-20319,'ai'=>-20317,'an'=>-20304,'ang'=>-20295,'ao'=>-20292,
		'ba'=>-20283,'bai'=>-20265,'ban'=>-20257,'bang'=>-20242,'bao'=>-20230,'bei'=>-20051,'ben'=>-20036,'beng'=>-20032,'bi'=>-20026,'bian'=>-20002,'biao'=>-19990,'bie'=>-19986,'bin'=>-19982,'bing'=>-19976,'bo'=>-19805,'bu'=>-19784,
		'ca'=>-19775,'cai'=>-19774,'can'=>-19763,'cang'=>-19756,'cao'=>-19751,'ce'=>-19746,'ceng'=>-19741,'cha'=>-19739,'chai'=>-19728,'chan'=>-19725,'chang'=>-19715,'chao'=>-19540,'che'=>-19531,'chen'=>-19525,'cheng'=>-19515,'chi'=>-19500,'chong'=>-19484,'chou'=>-19479,'chu'=>-19467,'chuai'=>-19289,'chuan'=>-19288,'chuang'=>-19281,'chui'=>-19275,'chun'=>-19270,'chuo'=>-19263,'ci'=>-19261,'cong'=>-19249,'cou'=>-19243,'cu'=>-19242,'cuan'=>-19238,'cui'=>-19235,'cun'=>-19227,'cuo'=>-19224,
		'da'=>-19218,'dai'=>-19212,'dan'=>-19038,'dang'=>-19023,'dao'=>-19018,'de'=>-19006,'deng'=>-19003,'di'=>-18996,'dian'=>-18977,'diao'=>-18961,'die'=>-18952,'ding'=>-18783,'diu'=>-18774,'dong'=>-18773,'dou'=>-18763,'du'=>-18756,'duan'=>-18741,'dui'=>-18735,'dun'=>-18731,'duo'=>-18722,
		'e'=>-18710,'en'=>-18697,'er'=>-18696,
		'fa'=>-18526,'fan'=>-18518,'fang'=>-18501,'fei'=>-18490,'fen'=>-18478,'feng'=>-18463,'fo'=>-18448,'fou'=>-18447,'fu'=>-18446,
		'ga'=>-18239,'gai'=>-18237,'gan'=>-18231,'gang'=>-18220,'gao'=>-18211,'ge'=>-18201,'gei'=>-18184,'gen'=>-18183,'geng'=>-18181,'gong'=>-18012,'gou'=>-17997,'gu'=>-17988,'gua'=>-17970,'guai'=>-17964,'guan'=>-17961,'guang'=>-17950,'gui'=>-17947,'gun'=>-17931,'guo'=>-17928,
		'ha'=>-17922,'hai'=>-17759,'han'=>-17752,'hang'=>-17733,'hao'=>-17730,'he'=>-17721,'hei'=>-17703,'hen'=>-17701,'heng'=>-17697,'hong'=>-17692,'hou'=>-17683,'hu'=>-17676,'hua'=>-17496,'huai'=>-17487,'huan'=>-17482,'huang'=>-17468,'hui'=>-17454,'hun'=>-17433,'huo'=>-17427,
		'ji'=>-17417,'jia'=>-17202,'jian'=>-17185,'jiang'=>-16983,'jiao'=>-16970,'jie'=>-16942,'jin'=>-16915,'jing'=>-16733,'jiong'=>-16708,'jiu'=>-16706,'ju'=>-16689,'juan'=>-16664,'jue'=>-16657,'jun'=>-16647,
		'ka'=>-16474,'kai'=>-16470,'kan'=>-16465,'kang'=>-16459,'kao'=>-16452,'ke'=>-16448,'ken'=>-16433,'keng'=>-16429,'kong'=>-16427,'kou'=>-16423,'ku'=>-16419,'kua'=>-16412,'kuai'=>-16407,'kuan'=>-16403,'kuang'=>-16401,'kui'=>-16393,'kun'=>-16220,'kuo'=>-16216,
		'la'=>-16212,'lai'=>-16205,'lan'=>-16202,'lang'=>-16187,'lao'=>-16180,'le'=>-16171,'lei'=>-16169,'leng'=>-16158,'li'=>-16155,'lia'=>-15959,'lian'=>-15958,'liang'=>-15944,'liao'=>-15933,'lie'=>-15920,'lin'=>-15915,'ling'=>-15903,'liu'=>-15889,'long'=>-15878,'lou'=>-15707,'lu'=>-15701,'lv'=>-15681,'luan'=>-15667,'lue'=>-15661,'lun'=>-15659,'luo'=>-15652,
		'ma'=>-15640,'mai'=>-15631,'man'=>-15625,'mang'=>-15454,'mao'=>-15448,'me'=>-15436,'mei'=>-15435,'men'=>-15419,'meng'=>-15416,'mi'=>-15408,'mian'=>-15394,'miao'=>-15385,'mie'=>-15377,'min'=>-15375,'ming'=>-15369,'miu'=>-15363,'mo'=>-15362,'mou'=>-15183,'mu'=>-15180,
		'na'=>-15165,'nai'=>-15158,'nan'=>-15153,'nang'=>-15150,'nao'=>-15149,'ne'=>-15144,'nei'=>-15143,'nen'=>-15141,'neng'=>-15140,'ni'=>-15139,'nian'=>-15128,'niang'=>-15121,'niao'=>-15119,'nie'=>-15117,'nin'=>-15110,'ning'=>-15109,'niu'=>-14941,'nong'=>-14937,'nu'=>-14933,'nv'=>-14930,'nuan'=>-14929,'nue'=>-14928,'nuo'=>-14926,
		'o'=>-14922,'ou'=>-14921,
		'pa'=>-14914,'pai'=>-14908,'pan'=>-14902,'pang'=>-14894,'pao'=>-14889,'pei'=>-14882,'pen'=>-14873,'peng'=>-14871,'pi'=>-14857,'pian'=>-14678,'piao'=>-14674,'pie'=>-14670,'pin'=>-14668,'ping'=>-14663,'po'=>-14654,'pu'=>-14645,
		'qi'=>-14630,'qia'=>-14594,'qian'=>-14429,'qiang'=>-14407,'qiao'=>-14399,'qie'=>-14384,'qin'=>-14379,'qing'=>-14368,'qiong'=>-14355,'qiu'=>-14353,'qu'=>-14345,'quan'=>-14170,'que'=>-14159,'qun'=>-14151,
		'ran'=>-14149,'rang'=>-14145,'rao'=>-14140,'re'=>-14137,'ren'=>-14135,'reng'=>-14125,'ri'=>-14123,'rong'=>-14122,'rou'=>-14112,'ru'=>-14109,'ruan'=>-14099,'rui'=>-14097,'run'=>-14094,'ruo'=>-14092,
		'sa'=>-14090,'sai'=>-14087,'san'=>-14083,'sang'=>-13917,'sao'=>-13914,'se'=>-13910,'sen'=>-13907,'seng'=>-13906,'sha'=>-13905,'shai'=>-13896,'shan'=>-13894,'shang'=>-13878,'shao'=>-13870,'she'=>-13859,'shen'=>-13847,'sheng'=>-13831,'shi'=>-13658,'shou'=>-13611,'shu'=>-13601,'shua'=>-13406,'shuai'=>-13404,'shuan'=>-13400,'shuang'=>-13398,'shui'=>-13395,'shun'=>-13391,'shuo'=>-13387,'si'=>-13383,'song'=>-13367,'sou'=>-13359,'su'=>-13356,'suan'=>-13343,'sui'=>-13340,'sun'=>-13329,'suo'=>-13326,
		'ta'=>-13318,'tai'=>-13147,'tan'=>-13138,'tang'=>-13120,'tao'=>-13107,'te'=>-13096,'teng'=>-13095,'ti'=>-13091,'tian'=>-13076,'tiao'=>-13068,'tie'=>-13063,'ting'=>-13060,'tong'=>-12888,'tou'=>-12875,'tu'=>-12871,'tuan'=>-12860,'tui'=>-12858,'tun'=>-12852,'tuo'=>-12849,
		'wa'=>-12838,'wai'=>-12831,'wan'=>-12829,'wang'=>-12812,'wei'=>-12802,'wen'=>-12607,'weng'=>-12597,'wo'=>-12594,'wu'=>-12585,
		'xi'=>-12556,'xia'=>-12359,'xian'=>-12346,'xiang'=>-12320,'xiao'=>-12300,'xie'=>-12120,'xin'=>-12099,'xing'=>-12089,'xiong'=>-12074,'xiu'=>-12067,'xu'=>-12058,'xuan'=>-12039,'xue'=>-11867,'xun'=>-11861,
		'ya'=>-11847,'yan'=>-11831,'yang'=>-11798,'yao'=>-11781,'ye'=>-11604,'yi'=>-11589,'yin'=>-11536,'ying'=>-11358,'yo'=>-11340,'yong'=>-11339,'you'=>-11324,'yu'=>-11303,'yuan'=>-11097,'yue'=>-11077,'yun'=>-11067,
		'za'=>-11055,'zai'=>-11052,'zan'=>-11045,'zang'=>-11041,'zao'=>-11038,'ze'=>-11024,'zei'=>-11020,'zen'=>-11019,'zeng'=>-11018,'zha'=>-11014,'zhai'=>-10838,'zhan'=>-10832,'zhang'=>-10815,'zhao'=>-10800,'zhe'=>-10790,'zhen'=>-10780,'zheng'=>-10764,'zhi'=>-10587,'zhong'=>-10544,'zhou'=>-10533,'zhu'=>-10519,'zhua'=>-10331,'zhuai'=>-10329,'zhuan'=>-10328,'zhuang'=>-10322,'zhui'=>-10315,'zhun'=>-10309,'zhuo'=>-10307,'zi'=>-10296,'zong'=>-10281,'zou'=>-10274,'zu'=>-10270,'zuan'=>-10262,'zui'=>-10260,'zun'=>-10256,'zuo'=>-10254
	);

    /**
     * 将中文编码成拼音
     * @param string $utf8Data utf8字符集数据
     * @param char $separator 分隔符
     * @param string $sRetFormat 返回格式 [head:首字母|all:全拼音]
     * @return string
     */
	public static function encode($utf8Data, $separator=' ', $sRetFormat='all'){
		$sGBK = iconv('UTF-8', 'GBK', $utf8Data);
		$aBuf = array();
		for ($i=0, $iLoop=strlen($sGBK); $i<$iLoop; $i++) {
			$iChr = ord($sGBK{$i});
			if ($iChr>160)
				$iChr = ($iChr<<8) + ord($sGBK{++$i}) - 65536;
			if ('head' === $sRetFormat)
				$aBuf[] = substr(self::zh2py($iChr),0,1);
			else
				$aBuf[] = self::zh2py($iChr);
		}
		if ('head' === $sRetFormat)
			return implode('', $aBuf);
		else
			return implode($separator, $aBuf);
	}

	/**
	 * 中文转换到拼音(每次处理一个字符)
	 * @param number $iWORD 待处理字符双字节
	 * @return string 拼音
	 */
	private static function zh2py($iWORD) {
		if($iWORD>0 && $iWORD<160 ) {
			return chr($iWORD);
		} elseif ($iWORD<-20319||$iWORD>-10247) {
			return '';
		} else {
			foreach (self::$_aMaps as $py => $code) {
				if($code > $iWORD) break;
				$result = $py;
			}
			return $result;
		}
	}
}
