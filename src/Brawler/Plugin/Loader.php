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
	 * Plugin Loader
	 * 
	 * @package     Brawler
	 * @subpackage  Plugin
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Plugin_Loader {
		/**
		 * Returns a plugin list
		 * 
		 * @return Brawler_Plugin_List
		 */
		public static function getPlugins() {
			return self::_getPlugins();
		}
		
		/**
		 * Reads the plugin depending on configuration
		 * 
		 * @return Brawler_Plugin_List
		 */
		protected static function _getPlugins() {
			if(!Brawler_Console::getArgument('p')) {
				$directory = realpath('src/Plugins/');
			} else {
				$directory = Brawler_Console::getArgument('p')->getValue();
			}
			
			if(Brawler_Console::getArgument('P')) {
				$directory.= 
					PATH_SEPARATOR. 
					Brawler_Console::getArgument('P')->getValue();
			}
			
			// Append Plugin Directorys to include Path
			set_include_path(get_include_path(). PATH_SEPARATOR. $directory);
			
			$dirs = split(PATH_SEPARATOR, $directory);
			
			$list = new Brawler_Plugin_List();
			foreach($dirs as $dir) {
				self::scanPlugins($dir, $list);
			}
			
			return $list;
		}
		
		/**
		 * Scans a path for plugins
		 * 
		 * @param String $dir String
		 * @param Brawler_Plugin_List $list
		 * @return Brawler_Plugin_List
		 */
		protected static function scanPlugins($dir, Brawler_Plugin_List $list) {
			$dir = 
				$dir. DIRECTORY_SEPARATOR.
				'Brawler'. DIRECTORY_SEPARATOR.
				'Plugin'. DIRECTORY_SEPARATOR;
				
			if(!file_exists($dir)) {
				return $list;
			}

			$files = scandir($dir);
			
			foreach($files as $file) {
				// excludes .svn stuff as well ;)
				if(substr($file, 0, 1) != '.') {
					if(is_dir($dir. DIRECTORY_SEPARATOR. $file)) {
						// determine classname
						$parts = array(
							'Brawler',
							'Plugin',
							$file,
							$file
						);
						
						$classname = implode('_', $parts);
						$list->append(new $classname);
					}
				}
			}
			
			return $list;
		}
	}
?>