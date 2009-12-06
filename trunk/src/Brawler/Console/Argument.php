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
	 * Copyright (c) 2009 Cem Derin <actioncem@gmail.com>
	 * 
	 * @author		Cem Derin, <actioncem@gmail.com>
	 * @package		Brawler
	 * @copyright	2009 Cem Derin <actioncem@gmail.com>
	 * @license		GNU Lesser General Public License 
	 * 				http://www.gnu.org/licenses/lgpl.html
	 */

	/**
	 * Represents a single console argument
	 * 
	 * @package		Brawler
	 * @subpackage	Console
	 * @author 		Cem Derin
	 * @copyright	2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Console_Argument {
		/**
		 * Name of this argument
		 * 
		 * @var String
		 */
		protected $_name;
		
		/**
		 * Value of this argument
		 * 
		 * @var String
		 */
		protected $_value;
		
		/**
		 * Ctor
		 * 
		 * @param String $name
		 * @param String $value
		 * @return void
		 */
		public function __construct($name, $value = null) {
			$this->_name = $name;
			$this->_value = $value;
		}
		
		/**
		 * Returns the name of the argument
		 * 
		 * @return String
		 */
		public function getName() {
			return $this->_name;
		}
		
		/**
		 * Returns the value of this argument
		 * 
		 * @return String
		 */
		public function getValue() {
			return $this->_value;
		}
	}
?>