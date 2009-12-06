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
	 * MVC controller class
	 * 
	 * @package		Brawler
	 * @author 		Cem Derin
	 * @copyright	2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Controller {
		/**
		 * Attached view
		 * 
		 * @var Brawler_View
		 */
		protected $_view = null;
		
		/**
		 * Defines wether the controller should render the view
		 * 
		 * @var Boolean
		 */
		protected $_render = true;
		
		/**
		 * Dispatches a controller call
		 * 
		 * @param String $action
		 * @return void
		 */
		public function dispatch($action = 'index') {
			if(method_exists($this, $action.'Action')) {
				call_user_func(array($this, $action.'Action'));
			} else {
				throw new Exception('Could not fond action '. $action);
			}
			
			if($this->_render && $this->_view) {
				$this->_view->render();
			}
		}
		
		/**
		 * Forwards to another controller and/or action
		 * @param String $controller
		 * @param String $action
		 * @return void
		 */
		public function forward($controller, $action = 'index') {
			$controllerClass = 
				'Brawler_Controller_'.
				ucfirst(strtolower($controller));
				
			$controller = new $controllerClass;
				
			call_user_func(array($controller, 'dispatch'), $action);
		}
		
		/**
		 * Sets the actial view
		 * 
		 * @param Brawler_View $view
		 * @return void
		 */
		public function setView(Brawler_View $view) {
			$this->_view = $view;
		}
		
		/**
		 * Returns the current view
		 * 
		 * @return Brawler_View
		 */
		public function getView() {
			return $this->_view;
		}
	}
?>