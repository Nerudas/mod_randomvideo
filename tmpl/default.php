<?php
/**
 * @package    Random Video Module
 * @version    1.0.0
 * @author     Nerudas  - nerudas.ru
 * @copyright  Copyright (c) 2013 - 2018 Nerudas. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://nerudas.ru
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('jquery.framework');
HTMLHelper::_('script', 'media/mod_randomvideo/js/ajax.min.js', array('version' => 'auto'));

?>
<div id="<?php echo $module->module . '_' . $module->id; ?>" data-mod_randomvideo='<?php echo $ajax_data; ?>'>
	<div class="before_play" style="display: none;">
		<div><strong>before_play</strong></div>
		<div>
			<a class="stop_load">stop_load</a>
		</div>
	</div>
	<div class="on_play" style="display: none;">
		<div><strong>on_play</strong></div>
		<video src="" width="320" height="640"></video>
		<div>
			<a class="stop_video">stop_video</a>
		</div>
	</div>
	<div class="after_play" style="display: none;">
		<div><strong>after_play</strong></div>
		<div>
			<a class="get_video">get_video</a>
		</div>
	</div>
	<div class="page_ready" style="display: none">
		<div><strong>page_ready</strong></div>
		<a class="get_video">get_video</a>
	</div>
</div>
