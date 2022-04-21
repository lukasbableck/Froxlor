<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Formfields
 *
 */
return array(
	'fpmconfig_add' => array(
		'title' => $lng['admin']['phpsettings']['addsettings'],
		'image' => 'fa-solid fa-plus',
		'self_overview' => ['section' => 'phpsettings', 'page' => 'fpmdaemons'],
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['phpsettings']['addsettings'],
				'image' => 'icons/phpsettings_add.png',
				'fields' => array(
					'description' => array(
						'label' => $lng['admin']['phpsettings']['description'],
						'type' => 'text',
						'maxlength' => 50
					),
					'reload_cmd' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['reload'],
						'type' => 'text',
						'maxlength' => 255,
						'value' => 'service php7.4-fpm restart'
					),
					'config_dir' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['configdir'],
						'type' => 'text',
						'maxlength' => 255,
						'value' => '/etc/php/7.4/fpm/pool.d/'
					),
					'pm' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['pm'],
						'type' => 'select',
						'select_var' => [
							'static' => 'static',
							'dynamic' => 'dynamic',
							'ondemand' => 'ondemand'
						]
					),
					'max_children' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['max_children']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_children']['description'],
						'type' => 'number',
						'value' => 5,
						'min' => 1
					),
					'start_servers' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['start_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['start_servers']['description'],
						'type' => 'number',
						'value' => 2,
						'min' => 1
					),
					'min_spare_servers' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['min_spare_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['min_spare_servers']['description'],
						'type' => 'number',
						'value' => 1
					),
					'max_spare_servers' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['max_spare_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_spare_servers']['description'],
						'type' => 'number',
						'value' => 3
					),
					'max_requests' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['max_requests']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_requests']['description'],
						'type' => 'number',
						'value' => 0
					),
					'idle_timeout' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['idle_timeout']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['idle_timeout']['description'],
						'type' => 'number',
						'value' => 10
					),
					'limit_extensions' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['limit_extensions']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['limit_extensions']['description'],
						'type' => 'text',
						'value' => '.php'
					),
					'custom_config' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['custom_config']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['custom_config']['description'],
						'type' => 'textarea',
						'cols' => 50,
						'rows' => 7
					)
				)
			)
		)
	)
);
