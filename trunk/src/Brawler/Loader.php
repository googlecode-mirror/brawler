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
	 * Autoloader
	 * 
	 * @package     Brawler
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Loader {
		/**
		 * Tries to load a class by name
		 * 
		 * @param String $classname
		 * @return Boolean
		 */
		public static function load($classname) {
			$filename = str_replace('_', DIRECTORY_SEPARATOR, $classname). '.php';
			
			if(self::checkForFile($filename)) {
				return require_once $filename;
			}
			
			return false;
			
		}
		
		/**
		 * Searches for a canonical file in every include path
		 * @param String $filename
		 * @return Bool
		 */
		protected static function checkForFile($filename) {
			$includes = split(PATH_SEPARATOR, get_include_path());
			
			$return = false;
			
			foreach($includes as $include) {
				if(file_exists($include. DIRECTORY_SEPARATOR. $filename)) {
					$return = true;
				}
			}
			
			return $return;
		}
	}

	
?>