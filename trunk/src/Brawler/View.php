<?php
/**
 * This file is part of brawler
 *
 * Brawler is free software; you can redistribute it and/or modify it
 * under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 2.1 of the License, or
 * (at your option) any later version.
 *
 * Brawler is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this library; if not, write to the Free Software Foundation,
 * Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * Copyright (c) 2009 Cem Derin, <actioncem@gmail.com>
 *
 * @author      Cem Derin, <actioncem@gmail.com>
 * @package     Brawler
 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
 * @license     GNU Lesser General Public License
 *              http://www.gnu.org/licenses/lgpl.html
 */

/**
 * View class
 *
 * @package     Brawler
 * @author      Cem Derin, <actioncem@gmail.com>
 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
 */
class Brawler_View {
	/**
	 * Assigned values
	 *
	 * @var Array
	 */
	protected $_values = array();

	/**
	 * Magic setter
	 *
	 * @param String $name
	 * @param Mixed $value
	 * @return void
	 */
	public function __set($name, $value) {
		$this->_values[$name] = $value;
	}

	/**
	 * Magic getter
	 *
	 * @param String $name
	 * @return Mixed
	 */
	public function __get($name) {
		if(isset($this->_values[$name])) {
			return $this->_values[$name];
		} else {
			return null;
		}
	}

	/**
	 * Renders the view
	 *
	 * @return void
	 */
	public function render() {
		ob_start();
		$this->view();
		$output = ob_get_contents();
		ob_end_clean();
			
		Brawler_Console_Output::output($output);
	}
}
?>