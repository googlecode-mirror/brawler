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
	 * Represents a plugin argument
	 * 
	 * @package     Brawler
	 * @subpackage  Plugin
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Plugin_Argument {
		/**
		 * Defines wether this is a key=value Argument
		 * 
		 * @var Bool
		 */
		protected $_hasValue = null;
		
		/**
		 * Holds a little description for the user
		 * 
		 * @var String
		 */
		protected $_description = null;
		
		/**
		 * Defines the flagname
		 * 
		 * @var char
		 */
		protected $_name = null;
		
		/**
		 * Ctor
		 * 
		 * @param String $name
		 * @param String $description
		 * @param Bool $hasValue
		 * @return void
		 * @throws Brawler_Plugin_Argument_Exception
		 */
		public function __construct($name, $description, $hasValue = false) {
			if(strlen($name) > 1) {
				throw new Brawler_Plugin_Argument_Exception(
					'Argument name is to long. Max 1 char'
				);
			}
			
			$this->_hasValue = $hasValue;
			$this->_description = $description;
			$this->_name = $name;
		}
		
		/**
		 * Returns the flags name
		 * 
		 * @return String
		 */
		public function getName() {
			return $this->_name;
		}
		
		/**
		 * Returns the flags description
		 * 
		 * @return String
		 */
		public function getDescription() {
			return $this->_description;
		}
		
		/**
		 * Returns wether the argument has a value
		 * 
		 * @return Bool
		 */
		public function hasValue() {
			return $this->_hasValue;
		}
	}
?>