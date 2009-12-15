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
	 * Generic notification
	 * 
	 * @package     Brawler
	 * @subpackage  Plugin
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Plugin_Notification {
		/**
		 * Holds the method name
		 * 
		 * @var String
		 */
		protected $_method;
		
		/**
		 * Holds an array with the submitted arguments
		 * 
		 * @var Array
		 */
		protected $_arguments;
		
		/**
		 * Ctor
		 * 
		 * @param String $method
		 * @param Array $arguments
		 * @return void
		 */
		public function __construct($method, $arguments) {
			$this->_method = $method;
			$this->_arguments = $arguments;
		}
		
		/**
		 * Returns the attached method name
		 * 
		 * @return String
		 */
		public function getMethod() {
			return $this->_method;
		}
	}