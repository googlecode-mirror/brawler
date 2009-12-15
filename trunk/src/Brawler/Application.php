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
	 * Application class - entry point
	 * 
	 * @package     Brawler
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Application {
		/**
		 * Starts the application
		 * 
		 * @return int
		 */
		public static function run() {
			self::_registerDefaultRoutes();
			
			$front = new Brawler_Controller_Front();
			$front->dispatch();
			return 0;
		}
		
		/**
		 * Returns an argument list
		 * 
		 * @return Brawler_Plugin_Argument_List
		 */
		public static function getArguments() {
			// Application arguments
			// Argument List
			$list = new Brawler_Plugin_Argument_List();
			
			// define plugin directory
			$list->append(new Brawler_Plugin_Argument(
				'p', 
				'Defines a plugin directory (default ./Plugins)', 
				true
			));
			
			// append plugin directory
			$list->append(new Brawler_Plugin_Argument(
				'P',
				'Appends a plugin directory',
				true
			));
			
			$list->append(new Brawler_Plugin_Argument(
				'h',
				'Prints command list',
				false
			));
			
			$list->append(new Brawler_Plugin_Argument(
				'r',
				'Resource URL to scan',
				true
			));
			
			// Plugin arguments
			// @TODO find a better way to merge ArrayObjects
			$plugins = Brawler_Plugin_Loader::getPlugins();
			$i = $plugins->getIterator();
			while($i->valid()) {
				$pluginArguments = $i->current()->getArguments();
				$list->merge($pluginArguments);
				$i->next();
			}
			
			// Return list
			return $list;
		}
		
		/**
		 * Registers the applications default routes
		 * 
		 * @return void
		 */
		protected static function _registerDefaultRoutes() {
			$route = new Brawler_Router_Route(
				'help',
				new Brawler_Router_Argument_List(
					array(
						new Brawler_Router_Argument(
							'h', false, false
						)
					)
				),
				new Brawler_Controller_Help()
			);
			Brawler_Router::registerRoute($route);
			
			$route = new Brawler_Router_Route(
				'scan',
				new Brawler_Router_Argument_List(
					array(
						new Brawler_Router_Argument(
							'r', true, false
						)
					)
				),
				new Brawler_Controller_Scan()
			);
			
			Brawler_Router::registerRoute($route);
		}
		
		/**
		 * Returns the current version
		 * 
		 * @return String
		 */
		public static function getVersion() {
			return '0.0.1';
		}
	}
?>