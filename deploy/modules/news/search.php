<?php
/**
 *
 * @category        modules
 * @package         news
 * @author          WebsiteBaker Project
 * @copyright       2004-2009, Ryan Djurovich
 * @copyright       2009-2010, Website Baker Org. e.V.
 * @link			http://www.websitebaker2.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.x
 * @requirements    PHP 4.3.4 and higher
 * @version         $Id: search.php 1280 2010-01-29 02:59:35Z Luisehahne $
 * @filesource		$HeadURL: http://svn.websitebaker2.org/branches/2.8.x/wb/modules/news/search.php $
 * @lastmodified    $Date: 2010-01-29 03:59:35 +0100 (Fr, 29. Jan 2010) $
 *
 */

function news_search($func_vars) {
	extract($func_vars, EXTR_PREFIX_ALL, 'func');

	// how many lines of excerpt we want to have at most
	$max_excerpt_num = $func_default_max_excerpt;
	// do we want excerpt from comments?
	$excerpt_from_comments = true; // TODO: make this configurable
	$divider = ".";
	$result = false;

	// fetch all active news-posts (from active groups) in this section.
	$t = time();
	$table_posts = TABLE_PREFIX."mod_news_posts";
	$table_groups = TABLE_PREFIX."mod_news_groups";
	$query = $func_database->query("
		SELECT p.post_id, p.title, p.content_short, p.content_long, p.link, p.posted_when, p.posted_by
		FROM $table_posts AS p LEFT OUTER JOIN $table_groups AS g ON p.group_id = g.group_id
		WHERE p.section_id='$func_section_id' AND p.active = '1' AND ( g.active IS NULL OR g.active = '1' )
		AND (published_when = '0' OR published_when <= $t) AND (published_until = 0 OR published_until >= $t)
		ORDER BY p.post_id DESC
	");
	// now call print_excerpt() for every single post
	if($query->numRows() > 0) {
		while($res = $query->fetchRow()) {
			$text = $res['title'].$divider.$res['content_short'].$divider.$res['content_long'].$divider;
			// fetch comments and add to $text
			if($excerpt_from_comments) {
				$table = TABLE_PREFIX."mod_news_comments";
				$commentquery = $func_database->query("
					SELECT title, comment
					FROM $table
					WHERE post_id='{$res['post_id']}'
					ORDER BY commented_when ASC
				");
				if($commentquery->numRows() > 0) {
					while($c_res = $commentquery->fetchRow()) {
						$text .= $c_res['title'].$divider.$c_res['comment'].$divider;
					}
				}
			}
			$mod_vars = array(
				'page_link' => $res['link'], // use direct link to news-item
				'page_link_target' => "",
				'page_title' => $func_page_title,
				'page_description' => $res['title'], // use news-title as description
				'page_modified_when' => $res['posted_when'],
				'page_modified_by' => $res['posted_by'],
				'text' => $text,
				'max_excerpt_num' => $max_excerpt_num
			);
			if(print_excerpt2($mod_vars, $func_vars)) {
				$result = true;
			}
		}
	}
	
	// now fetch group-titles - ignore those without (active) postings
	$table_groups = TABLE_PREFIX."mod_news_groups";
	$table_posts = TABLE_PREFIX."mod_news_posts";
	$query = $func_database->query("
		SELECT DISTINCT g.title, g.group_id
		FROM $table_groups AS g INNER JOIN $table_posts AS p ON g.group_id = p.group_id
		WHERE g.section_id='$func_section_id' AND g.active = '1' AND p.active = '1'
	");
	// now call print_excerpt() for every single group, too
	if($query->numRows() > 0) {
		while($res = $query->fetchRow()) {
			$mod_vars = array(
				'page_link' => $func_page_link,
				'page_link_target' => "&g=".$res['group_id'],
				'page_title' => $func_page_title,
				'page_description' => $func_page_description,
				'page_modified_when' => $func_page_modified_when,
				'page_modified_by' => $func_page_modified_by,
				'text' => $res['title'].$divider,
				'max_excerpt_num' => $max_excerpt_num
			);
			if(print_excerpt2($mod_vars, $func_vars)) {
				$result = true;
			}
		}
	}
	return $result;
}

?>
