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
	 * Abstract Pluggable class
	 * 
	 * @package     Brawler
	 * @subpackage  Plugin
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	abstract class Brawler_Plugin_Pluggable_Abstract {
		/**
		 * Holds the plugins
		 * 
		 * @var Brawler_Array_Object
		 */
		protected $_plugins;
		
		/**
		 * Ctor ÐÊloads the plugins
		 * 
		 * @return void
		 */
		public function __construct() {
			$this->_plugins = new Brawler_Array_Object();
			
			// fetching plugins
			foreach(Brawler_Plugin_Loader::getPlugins() as $plugin) {
				// get plug name
				$pluginClass = $this->getPluginClassName($plugin);
				if(class_exists($pluginClass)) {
					$this->registerPlugin(new $pluginClass);
				}
			}
		}
		
		/**
		 * Registers a plugin
		 * 
		 * @param Brawler_Plugin_Plugin $plugin
		 * @return void
		 */
		public function registerPlugin(Brawler_Plugin_Plug_Abstract $plugin) {
			$this->_plugins->append($plugin);
		}
		
		/**
		 * Notifies the Plugins before method starts to act
		 * 
		 * @param String $method
		 * @param Array $arguments
		 * @return void
		 */
		public function preCallNotify($method, $arguments) {
			$notification = new Brawler_Plugin_Notification_Pre($method, $arguments);
			return $this->_notify($notification);
		}
		
		/**
		 * Notifies the Plugins after a method has acted
		 * 
		 * @param String $method
		 * @param Array $arguments
		 * @param mixed $return
		 * @return mixed
		 */
		public function postCallNotify($method, $arguments, $return) {
			$notification = new Brawler_Plugin_Notification_Post($method, $arguments, $return);
			return $this->_notify($notification);
		}
		
		/**
		 * General notofication
		 * 
		 * @param Brawler_Plugin_Notification $notification
		 * @return unknown_type
		 */
		protected function _notify(Brawler_Plugin_Notification $notification) {
			$i = $this->_plugins->getIterator();
			while($i->valid()) {
				$i->current()->notify($notification);
				$i->next();
			}
			
			return $notification;
		}
		
		/**
		 * Returns the name of the plugin class depending on a given plugin
		 * 
		 * @param Brawler_Plugin $plugin
		 * @return String
		 */
		public function getPluginClassName($plugin) {
			$return = split('_', get_class($this));
			array_shift($return);
			return $plugin->getBaseName(). '_'. implode('_', $return);
		}
	}