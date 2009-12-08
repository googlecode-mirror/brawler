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
	 * Represents a single route
	 * 
	 * @package     Brawler
	 * @subpackage  Router
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Router_Route {
		/**
		 * Name of this route
		 * 
		 * @var String
		 */
		protected $_name = null;
		
		/**
		 * Arguments for this route
		 * 
		 * @var Brawler_Router_Argument_List
		 */
		protected $_arguments = null;
		
		/**
		 * Controller to call
		 * 
		 * @var Brawler_Controller
		 */
		protected $_controller = null;
		
		/**
		 * Action to call
		 * 
		 * @var String
		 */
		protected $_action = 'index';
		
		/**
		 * Defines whether the route can dispatch in chain
		 * 
		 * @var Bool
		 */
		protected $_chain = null;
		
		/**
		 * Ctor
		 * 
		 * @param String $name
		 * @param Brawler_Router_Argument_List $arguments
		 * @param Brawler_Controller $controller
		 * @param String $action
		 * @return void
		 */
		public function __construct($name, Brawler_Router_Argument_List $arguments, Brawler_Controller $controller = null, $action = null, $chain = true) {
			$this->_name = $name;
			$this->_arguments = $arguments;
			
			if($controller) {
				$this->_controller = $controller;
			} else {
				$this->_controller = new Brawler_Controller_Index();
			}
			
			if($action) {
				$this->_action = $action;
			}
			
			$this->_chain = $chain;
		}
		
		/**
		 * Returns the arguments attached to this route
		 * 
		 * @return Brawler_Router_Argument_List
		 */
		public function getArguments() {
			return $this->_arguments;
		}
		
		public function getChain() {
			return $this->_chain;
		}
		
		public function getController() {
			return $this->_controller;
		}
		
		public function getAction() {
			return $this->_action;
		}
	}