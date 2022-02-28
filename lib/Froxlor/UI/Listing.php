<?php

namespace Froxlor\UI;

use Froxlor\UI\Panel\UI;
use Exception;

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
 * @author     Maurice Preuß <hello@envoyr.com>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Listing
 *
 */
class Listing
{
	public static function format(Collection $collection, array $tabellisting): array
	{
		$collection = $collection->get();

		return [
			'title' => $tabellisting['title'],
			'icon' => $tabellisting['icon'],
			'table' => [
				'th' => self::generateTableHeadings($tabellisting),
				'tr' => self::generateTableRows($collection['data']['list'], $tabellisting),
			],
			'pagination' => $collection['pagination'],
			'empty_msg' => $tabellisting['empty_msg'] ?? null
		];
	}

	private static function generateTableHeadings(array $tabellisting): array
	{
		$heading = [];

		// Table headings for columns
		foreach ($tabellisting['visible_columns'] as $visible_column) {
			if (isset($tabellisting['columns'][$visible_column]['visible']) && !$tabellisting['columns'][$visible_column]['visible']) {
				continue;
			}

			$heading[$visible_column] = [
				'text' => $tabellisting['columns'][$visible_column]['label'],
				'class' => $tabellisting['columns'][$visible_column]['class'] ?? null,
			];
		}

		// Table headings for actions
		if (isset($tabellisting['actions'])) {
			$heading['actions'] = [
				'text' => UI::getLng('panel.options'),
				'class' => 'text-end',
			];
		}

		return $heading;
	}

	private static function generateTableRows(array $list, array $tabellisting): array
	{
		$rows = [];

		// Create new row from item
		foreach ($list as $row => $item) {
			// Generate columns from item
			foreach ($tabellisting['visible_columns'] as $col => $visible_column) {
				if (isset($tabellisting['columns'][$visible_column]['visible']) && !$tabellisting['columns'][$visible_column]['visible']) {
					continue;
				}

				$format_callback = $tabellisting['columns'][$visible_column]['format_callback'] ?? null;
				$column = $tabellisting['columns'][$visible_column]['field'] ?? null;
				if (empty($column)) {
					throw new Exception('Column in "visible columns" specified that is not defined in "fields"');
				}
				$data = self::getMultiArrayFromString($item, $column);

				if ($format_callback) {
					$rows[$row]['td'][$col]['data'] = call_user_func($format_callback, ['data' => $data, 'fields' => $item]);
				} else {
					$rows[$row]['td'][$col]['data'] = $data;
				}

				$rows[$row]['td'][$col]['class'] = $tabellisting['columns'][$visible_column]['class'] ?? null;
			}

			// Set row classes from format_callback
			if (isset($tabellisting['format_callback'])) {
				$class = [];
				foreach ($tabellisting['format_callback'] as $format_callback) {
					$class[] = call_user_func($format_callback, ['fields' => $item]);
				}
				$rows[$row]['class'] = implode(' ', $class);
			}

			// Set all actions for row
			if (isset($tabellisting['actions'])) {
				$actions = self::setLinks($tabellisting['actions'], $item);

				$rows[$row]['td'][] = [
					'class' => 'text-end',
					'data' => [
						'type' => 'actions',
						'data' => $actions
					]
				];
			}
		}

		return $rows;
	}

	private static function setLinks(array $actions, array $item): array
	{
		$linker = UI::getLinker();

		// Check each action for a href
		foreach ($actions as $key => $action) {
			// Call user function if visible is an array
			if (isset($action['visible']) && is_array($action['visible'])) {
				$actions[$key]['visible'] = call_user_func($action['visible'], ['fields' => $item]);
			}

			// Set link if href is an array
			if (isset($action['href']) && is_array($action['href'])) {
				// Search for "columns" in our href array
				foreach ($action['href'] as $href_key => $href_value) {
					$length = strlen(':');
					if (substr($href_value, 0, $length) === ':') {
						$column = ltrim($href_value, ':');
						$action['href'][$href_key] = $item[$column];
					}
				}

				// Set actual link from linker
				$actions[$key]['href'] = $linker->getLink($action['href']);
			}
		}

		return $actions;
	}

	public static function getVisibleColumnsForListing(string $listing, array $default_columns): array
	{
		// Hier käme dann die Logik, die das aus der DB zieht ...
		// alternativ nimmt er die $default_columns, wenn kein Eintrag
		// in der DB definiert ist

		return $default_columns;
	}

	public static function getMultiArrayFromString(array $arr, string $str)
	{
		foreach (explode('.', $str) as $key) {
			if (!array_key_exists($key, $arr)) {
				return null;
			}
			$arr = $arr[$key];
		}

		return $arr;
	}
}
