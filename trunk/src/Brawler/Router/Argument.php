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
	 * Represents an argument for routes
	 * 
	 * @package     Brawler
	 * @subpackage  Router
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Router_Argument {
		/**
		 * The flag this route is for
		 * 
		 * @var String
		 */
		protected $_flag = null;
		
		/**
		 * Defines whether this route only is for vakued flags
		 * 
		 * @var Bool
		 */
		protected $_onValue = null;
		
		/**
		 * Defines whether this route is only for a valued flag with a specific value
		 * 
		 * @var String
		 */
		protected $_specificValue = null;
		
		public function __construct($flag, $onValue = false, $specificValue = null) {
			$this->_flag = $flag;
			$this->_onValue = $onValue;
			$this->_specificValue = $specificValue;
		}
		
		/**
		 * Returns the setted flag
		 * 
		 * @return String
		 */
		public function getFlag() {
			return $this->_flag;
		}
		
		/**
		 * Returns whether this argument needs a value
		 * 
		 * @return Boolean
		 */
		public function getOnValue() {
			return $this->_onValue;
		}
		
		/**
		 * Returns whether a specific value is needed
		 * 
		 * @return String
		 */
		public function getSpecificValue() {
			return $this->_specificValue;
		}
	}