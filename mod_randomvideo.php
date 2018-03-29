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

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Registry\Registry;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$registry = new Registry();
$registry->set('module_id', $module->id);
$registry->set('Itemid', Factory::getApplication()->input->get('Itemid'));
$registry->set('root', Uri::root(true));
$ajax_data = $registry->toString();

require ModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default'));