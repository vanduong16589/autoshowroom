<?php
/**
 * JComments plugin for TZ Portfolio support
 *
 * @version 3.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2013 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

class jc_com_tz_portfolio_plus extends JCommentsPlugin
{
	function getObjectInfo($id, $language = null)
	{
		$info = new JCommentsObjectInfo();

		$routerHelper = JPATH_ROOT.'/components/com_tz_portfolio_plus/helpers/route.php';
		if (is_file($routerHelper)) {
			require_once($routerHelper);

			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			$query->select('a.id, a.title, a.created_by, a.access, a.alias, a.catid');
			$query->from('#__tz_portfolio_plus_content AS a');

			$query->select('c.alias AS category_alias');
			$query -> join('INNER', '#__tz_portfolio_plus_content_category_map AS m ON m.contentid = a.id');
			$query->join('LEFT', '#__tz_portfolio_plus_categories AS c ON c.id = m.catid');

			$query -> where('m.main = 1');
			
			$query->where('a.id = ' . (int) $id);

			$db->setQuery($query);
			$row = $db->loadObject();

			if (!empty($row)) {
				$row->slug = $row->alias ? ($row->id.':'.$row->alias) : $row->id;
				$row->catslug = $row->category_alias ? ($row->catid.':'.$row->category_alias) : $row->catid;

				$info->category_id = $row->category_id;
				$info->title = $row->title;
				$info->userid = $row->created_by;
				$info->link = JRoute::_(TZ_Portfolio_PlusHelperRoute::getArticleRoute($row->slug, $row->catslug));
			}
		}

		return $info;
	}
}