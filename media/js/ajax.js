/*
 * @package    Random Video Module
 * @version    1.0.1
 * @author     Nerudas  - nerudas.ru
 * @copyright  Copyright (c) 2013 - 2018 Nerudas. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://nerudas.ru
 */

(function ($) {
	$(document).ready(function () {
		$('[data-mod_randomvideo]').each(function () {
			var block = $(this),
				data = $(block).data('mod_randomvideo'),
				page_ready = $(block).find('.page_ready'),
				before_play = $(block).find('.before_play'),
				on_play = $(block).find('.on_play'),
				after_play = $(block).find('.after_play'),
				get_video = $(block).find('.get_video'),
				video = $(block).find('video'),
				stop_video = $(block).find('.stop_video'),
				stop_load = $(block).find('.stop_load');

			$(page_ready).show();

			$(get_video).on('click', function () {
				data.current = $(video).attr('src');
				data.v = Math.floor(Math.random() * 6) + 1;
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: data.root + '/index.php?option=com_ajax&module=randomvideo&format=json',
					data: data,
					beforeSend: function () {
						$(page_ready).hide();
						$(after_play).hide();
						$(on_play).hide();
						$(before_play).show();

						$(stop_load).on('click', function () {
							$(before_play).hide();
							$(after_play).show();
						});
					},
					success: function (response) {
						if (response.success) {
							var data = response.data;
							$(video).attr('src', data.src);
							$(video).attr('type', 'video/' + data.type);
							$(video).get(0).play();
							$(video).on('play', function () {
								$(before_play).hide();
								$(on_play).show();
							});
							$(video).on('pause', function () {
								$(on_play).hide();
								$(after_play).show();
							});
							$(video).on('ended', function () {
								$(on_play).hide();
								$(after_play).show();
							});
							$(stop_video).on('click', function () {
								$(video).get(0).pause();
							});
						}
						else {
							$(before_play).hide();
							$(after_play).show();
							console.error(response.message);
						}
					},
					error: function (response) {
						$(before_play).hide();
						$(after_play).show();
						console.error(response.message);
					}
				});
			});

		});
	});
})(jQuery);