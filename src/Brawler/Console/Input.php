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
	 * Abstract cli input class
	 * 
	 * @package     Brawler
	 * @subpackage  Console
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	abstract class Brawler_Console_Input {
		/**
		 * Retrieves input
		 * 
		 * @param $msg Query message
		 * @param $stripEnter Strip trailing Linebreak
		 * @return String
		 */
		public static function get($msg, $stripEnter = true) {
			Brawler_Console_Output::output($msg);
			
			do {
				$return = fgets(self::_getStream());
			} while(!self::_validate($return));
			
			if($stripEnter) {
				$return = substr($return, 0, strlen($return) - 1);
			}
			
			return $return;
		}
		
		/**
		 * Returns the input stream
		 * 
		 * @return Ressource
		 */
		protected static function _getStream() {
			return fopen('php://stdin', 'w');
		}
		
		/**
		 * Validates the user input
		 * 
		 * @param $value
		 * @return Boolean
		 */
		protected static function _validate($value) {
			return true;
		}
	}
?>