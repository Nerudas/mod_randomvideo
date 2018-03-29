<?php
/**
 * @package    Random Video Module
 * @version    1.0.1
 * @author     Nerudas  - nerudas.ru
 * @copyright  Copyright (c) 2013 - 2018 Nerudas. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://nerudas.ru
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Uri\Uri;

jimport('joomla.filesystem.file');

class modRandomVideoHelper
{
	/**
	 * Module params object
	 *
	 * @var    Registry
	 *
	 * @since 1.0.0
	 */
	protected static $_params = null;

	/**
	 * Form submit method
	 *
	 * @return bool|object
	 *
	 * @since 1.0.0
	 */
	public static function getAjax()
	{
		$params = self::getParams();
		if (!$params)
		{
			throw new Exception(Text::_('MOD_JFORM_ERROR_MODULE_NOT_FOUND'), 404);

			return false;
		}

		if (!$videos = $params->get('videos', 0))
		{
			throw new Exception(Text::_('MOD_JFORM_ERROR_VIDEOS_NOT_FOUND'), 404);

			return false;
		}

		$current = trim(Factory::getApplication()->input->get('current', '', 'raw'), '/\/');
		$videos  = ArrayHelper::fromObject($videos, false);
		$count   = count($videos);
		$keys    = array_keys($videos);


		$key        = $keys[rand(0, ($count - 1))];
		$video      = $videos[$key];
		$video->src = trim($video->src, '/\/');
		$try        = 1;
		while ($video->src == $current || !JFile::exists(JPATH_ROOT . '/' . $video->src) || $try <= $count || empty($video->src))
		{
			$key        = $keys[rand(0, ($count - 1))];
			$video      = $videos[$key];
			$video->src = trim($video->src, '/\/');
			$try++;
		}
		if ($try > $count && $video->src == $current || !JFile::exists(JPATH_ROOT . '/' . $video->src) || empty($video->src))
		{

			throw new Exception(Text::_('MOD_JFORM_ERROR_VIDEO_NOT_FOUND'), 404);

			return false;

		}

		$video->type = JFile::getExt(JPATH_ROOT . '/' . $video->src);
		$video->src  = Uri::root(true) . '/' . $video->src;

		return $video;
	}


	/**
	 *  Method to get Module object
	 *
	 * @param int $pk Module id
	 *
	 * @return bool|Registry  Module params object on success, false on failure
	 *
	 * @since 1.0.0
	 */
	protected static function getParams($pk = null)
	{
		$pk = (empty($pk)) ? Factory::getApplication()->input->get('module_id', 0) : $pk;

		if (empty(self::$_params))
		{
			try
			{
				$db    = Factory::getDbo();
				$query = $db->getQuery(true)
					->select('params')
					->from('#__modules')
					->where('id =' . $pk)
					->where('module = ' . $db->quote('mod_randomvideo'));
				$db->setQuery($query);
				$params = $db->loadResult();

				self::$_params = (!empty($params)) ? new Registry($params) : false;
			}
			catch (Exception $e)
			{
				self::$_params = false;
			}
		}

		return self::$_params;
	}
}