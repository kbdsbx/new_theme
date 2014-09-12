<?php
/*
Plugin Name: RSS Importer
Plugin URI: http://wordpress.org/extend/plugins/rss-importer/
Description: Import posts from an RSS feed.
Author: wordpressdotorg
Author URI: http://wordpress.org/
Version: 0.2
Stable tag: 0.2
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

if ( !defined('WP_LOAD_IMPORTERS') )
	return;

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( !class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require_once $class_wp_importer;
}

/**
 * RSS Importer
 *
 * @package WordPress
 * @subpackage Importer
 */

/**
 * RSS Importer
 *
 * Will process a RSS feed for importing posts into WordPress. This is a very
 * limited importer and should only be used as the last resort, when no other
 * importer is available.
 *
 * @since unknown
 */
if ( class_exists( 'WP_Importer' ) ) {
class RSS_Import extends WP_Importer {

	var $posts = array ();
	var $file;

	function header() {
		echo '<div class="wrap">';
		screen_icon();
		echo '<h2>'.__('Import RSS', 'rss-importer').'</h2>';
	}

	function footer() {
		echo '</div>';
	}

	function greet() {
		echo '<div class="narrow">';
		echo '<p>'.__('Howdy! This importer allows you to extract posts from an RSS 2.0 file into your WordPress site. This is useful if you want to import your posts from a system that is not handled by a custom import tool. Pick an RSS file to upload and click Import.', 'rss-importer').'</p>';
		wp_import_upload_form("admin.php?import=rss&amp;step=1");
		echo '</div>';
	}

	function _normalize_tag( $matches ) {
		return '<' . strtolower( $matches[1] );
	}

	function get_posts() {
		global $wpdb;

		// set_magic_quotes_runtime(0);
		$datalines = file($this->file); // Read the file into an array
		$importdata = implode('', $datalines); // squish it
		$importdata = str_replace(array ("\r\n", "\r"), "\n", $importdata);

        // 获取并设置文章类型from dede channel type
        preg_match( '|<category>(.*?)</category>|is', $importdata, $post_type );
        $post_type = esc_sql( trim( $post_type[1] ) );

        switch ( $post_type ) {
        default:
            $post_type = 'post';
            break;
        case 'image':
            $post_type = 'gallery';
            break;
        case 'shop':
            $post_type = 'ware';
            break;
        case 'download':
            $post_type = 'resource';
            break;
        }

        preg_match_all('|<item>(.*?)</item>|is', $importdata, $this->posts);

		$this->posts = $this->posts[1];
		$index = 0;
		foreach ($this->posts as $post) {
			preg_match('|<title>(.*?)</title>|is', $post, $post_title);
			$post_title = str_replace(array('<![CDATA[', ']]>'), '', esc_sql( trim($post_title[1]) ));
            $post_name = new_filter_permalink( $post_title );


			preg_match('|<pubdate>(.*?)</pubdate>|is', $post, $post_date_gmt);

			if ($post_date_gmt) {
				$post_date_gmt = strtotime($post_date_gmt[1]);
			} else {
				// if we don't already have something from pubDate
				preg_match('|<dc:date>(.*?)</dc:date>|is', $post, $post_date_gmt);
				$post_date_gmt = preg_replace('|([-+])([0-9]+):([0-9]+)$|', '\1\2\3', $post_date_gmt[1]);
				$post_date_gmt = str_replace('T', ' ', $post_date_gmt);
				$post_date_gmt = strtotime($post_date_gmt);
			}

            preg_match( '|<enclosure>(.*?)</enclosure>|is', $post, $thumbnail );
            if ( $thumbnail ) {
                $new_thumbnail = preg_replace( '|/uploads(.*?)|is', wp_upload_dir()['baseurl'] . '$1', esc_sql(trim($thumbnail[1])) ); 
                $thumbnail = ( $thumbnail == $new_thumbnail ? '' : $new_thumbnail );
            }

            preg_match( '|<new:resource>(.*?)</new:resource>|is', $post, $resource );
            if ( $resource )
                $resource = preg_replace( '|/uploads(.*?)|is', wp_upload_dir()['baseurl'] . '$1', esc_sql( trim( $resource[1] ) ) );

			$post_date_gmt = gmdate('Y-m-d H:i:s', $post_date_gmt);
			$post_date = get_date_from_gmt( $post_date_gmt );

			preg_match_all('|<category>(.*?)</category>|is', $post, $categories);
			$categories = $categories[1];

            preg_match( '|<new:tags>(.*?)</new:tags>|is', $post, $tags_input );
            if ( $tags_input ) {
                $tags_input = str_replace(array('<![CDATA[', ']]>'), '', esc_sql( trim($tags_input[1]) ));
            }

            preg_match( '|<source>(.*?)</source>|is', $post, $source );
            if ( $source ) {
                $source = str_replace( array( '<![CDATA[', ']]>' ), '', esc_sql( trim( $source[1] ) ) );
            }

			if (!$categories) {
				preg_match_all('|<dc:subject>(.*?)</dc:subject>|is', $post, $categories);
				$categories = $categories[1];
			}

			$cat_index = 0;
			foreach ($categories as $category) {
				$categories[$cat_index] = esc_sql( html_entity_decode( $category ) );
				$cat_index++;
			}

			preg_match('|<guid.*?>(.*?)</guid>|is', $post, $guid);
			if ($guid)
				$guid = esc_sql(trim($guid[1]));
			else
				$guid = '';

			preg_match('|<content:encoded>(.*?)</content:encoded>|is', $post, $post_content);
            if ($post_content) {
                $post_content = str_replace(array ('<![CDATA[', ']]>'), '', esc_sql(trim($post_content[1])));
            } else {
				// This is for feeds that put content in description
				preg_match('|<description>(.*?)</description>|is', $post, $post_content);
                $post_content = preg_replace( '|src="/uploads(.*?)"|is', 'src="' . wp_upload_dir()['baseurl'] . '$1"', $post_content[1] ); 
				$post_content = esc_sql( ( trim( $post_content ) ) );
                $post_content = str_replace(array ('<![CDATA[', ']]>'), '', $post_content);
			}

            if ( $post_type == 'gallery' ) {
                preg_match_all( '|{dede:img.*?}(.*?){/dede:img}|is', $post_content, $gallery );
                $gallery = $gallery[1];
                $attachment_ids = array();
                foreach ( $gallery as $key => $img ) {
                    $gallery[$key] = preg_replace( '|/uploads(.*?)|is', wp_upload_dir()['baseurl'] . '$1', esc_sql(trim($gallery[$key])) ); 
                    $attachment_filename = str_replace( wp_upload_dir()['baseurl'], wp_upload_dir()['basedir'], $gallery[$key] );
                    $attachment_args = array(
                        'guid'          => $gallery[$key],
                        'post_mime_type'=> wp_check_filetype( basename( $attachment_filename ), null )['type'],
                        'post_title'    => preg_replace( '/\.[^.]+$/', '', basename( $attachment_filename ) ),
                        'post_content'  => '',
	                    'post_status'   => 'inherit'
                    );
                    $attachment_id = wp_insert_attachment( $attachment_args, $attachment_filename );
                    if ( 0 != $attachment_id ) {
                        wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $attachment_filename ) );
                        $attachment_ids[] = $attachment_id;
                    }
                }
                $post_content = '[gallery ids="' . implode( ',', $attachment_ids ) . '"]';
            } else {
                // Clean up content
                $post_content = preg_replace_callback('|<(/?[A-Z]+)|', array( &$this, '_normalize_tag' ), $post_content);
                $post_content = str_replace('<br>', '<br />', $post_content);
                $post_content = str_replace('<hr>', '<hr />', $post_content);
                $post_content = str_replace(array('\\n', '\n'), '', $post_content);
            }
			$post_author = 1;
			$post_status = 'publish';
			$this->posts[$index] = compact('post_author', 'post_type', 'post_name', 'thumbnail', 'source', 'resource', 'tags_input', 'post_date', 'post_date_gmt', 'post_content', 'post_title', 'post_status', 'guid', 'categories');
			$index++;
		}
	}

	function import_posts() {
		echo '<ol>';

		foreach ($this->posts as $post) {
			echo "<li>".__('Importing post...', 'rss-importer');

			extract($post);

			if ($post_id = post_exists($post_title, $post_content, $post_date)) {
				_e('Post already imported', 'rss-importer');
			} else {
				$post_id = wp_insert_post($post);
				if ( is_wp_error( $post_id ) )
					return $post_id;
				if (!$post_id) {
					_e('Couldn&#8217;t get post ID', 'rss-importer');
					return;
				}
                // 保存缩略图
                if ('' != $thumbnail){
                    $attachment_filename = str_replace( wp_upload_dir()['baseurl'], wp_upload_dir()['basedir'], $thumbnail );
                    $attachment_args = array(
                        'guid'          => $thumbnail,
                        'post_mime_type'=> wp_check_filetype( basename( $attachment_filename ), null )['type'],
                        'post_title'    => preg_replace( '/\.[^.]+$/', '', basename( $attachment_filename ) ),
                        'post_content'  => '',
	                    'post_status'   => 'inherit'
                    );
                    $attachment_id = wp_insert_attachment( $attachment_args, $attachment_filename, $post_id );
                    if ( 0 != $attachment_id ) {
                        wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $attachment_filename ) );
                        set_post_thumbnail( $post_id, $attachment_id );
                    }
                }

                // 存在资源则保存资源
                if ( '' != $resource ) {
                    $attachment_filename = str_replace( wp_upload_dir()['baseurl'], wp_upload_dir()['basedir'], $resource );
                    $attachment_args = array(
                        'guid'          => $resource,
                        'post_mime_type'=> wp_check_filetype( basename( $attachment_filename ), null )['type'],
                        'post_title'    => preg_replace( '/\.[^.]+$/', '', basename( $attachment_filename ) ),
                        'post_content'  => '',
	                    'post_status'   => 'inherit'
                    );
                    $attachment_id = wp_insert_attachment( $attachment_args, false, $post_id );
                    if ( function_exists( 'update_field' ) && $attachment_id ) {
                        update_field( 'file', $attachment_id, $post_id );
                        update_field( 'field_53e181558dd22', 'other', $post_id );
                        update_field( 'field_54115caef80b2', 'other', $post_id );
                        $file_size = FileSizeConvert( filesize( iconv( 'utf-8', 'gb2312', $attachment_filename ) ) );
                        update_field( 'field_53e2e24507824', $file_size, $post_id );
                    }
                }
                
                // 保存栏目并更新栏目字段
				if (0 != count($categories)) {
                    $category_ids = wp_create_categories($categories, $post_id);
                    if ( function_exists( 'update_field' ) && $category_ids )
                        foreach ( $category_ids as $cid )
                            update_field( 'field_53e19dd6d5ccb', $post_type, $cid );
                }

                if ( function_exists( 'update_field' ) )
                    update_field( 'field_53df244673d32', rand( 0, get_option( 'new_theme_heat_limit' ) ), $post_id );

                if ( '' != $source && function_exists( 'update_field' ) ) {
                    update_field( 'field_53df3aadae5b3', $source, $post_id );
                }

				_e('Done!', 'rss-importer');
			}
			echo '</li>';
		}

		echo '</ol>';

	}

	function import() {
		$file = wp_import_handle_upload();
		if ( isset($file['error']) ) {
			echo $file['error'];
			return;
		}

		$this->file = $file['file'];
		$this->get_posts();
		$result = $this->import_posts();
		if ( is_wp_error( $result ) )
			return $result;
		wp_import_cleanup($file['id']);
		do_action('import_done', 'rss');

		echo '<h3>';
		printf(__('All done. <a href="%s">Have fun!</a>', 'rss-importer'), get_option('home'));
		echo '</h3>';
	}

	function dispatch() {
		if (empty ($_GET['step']))
			$step = 0;
		else
			$step = (int) $_GET['step'];

		$this->header();

		switch ($step) {
			case 0 :
				$this->greet();
				break;
			case 1 :
				check_admin_referer('import-upload');
				$result = $this->import();
				if ( is_wp_error( $result ) )
					echo $result->get_error_message();
				break;
		}

		$this->footer();
	}

	function RSS_Import() {
		// Nothing.
	}
}

$rss_import = new RSS_Import();

register_importer('rss', __('RSS', 'rss-importer'), __('Import posts from an RSS feed.', 'rss-importer'), array ($rss_import, 'dispatch'));

} // class_exists( 'WP_Importer' )

function rss_importer_init() {
    load_plugin_textdomain( 'rss-importer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'rss_importer_init' );
