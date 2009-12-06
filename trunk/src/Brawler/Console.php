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
	 * Provides basic cli application features
	 * 
	 * @package		Brawler
	 * @author 		Cem Derin
	 * @copyright	2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Console {
		/**
		 * Holds the parsed arguments
		 * 
		 * @var Brawler_Console_Argument_List
		 */
		protected static $_arguments = null;
		
		/**
		 * Returns a single argument
		 * 
		 * @param String $argument
		 * @return Brawler_Console_Argument
		 */
		public static function getArgument($argument) {
			if(!self::$_arguments) {
				self::_parseArguments();
			}
			
			$i = self::$_arguments->getIterator();
			while($i->valid()) {
				if($i->current()->getName() == $argument) {
					return $i->current();
				}
				$i->next();
			}
			
			return null;
		}
		
		/**
		 * Returns all arguments
		 * 
		 * @return Brawler_Console_Argument_List
		 */
		public static function getArguments() {}
		
		/**
		 * Parses the given arguments
		 * 
		 * @return void
		 */
		public static function _parseArguments() {
			self::$_arguments = new Brawler_Console_Argument_List();
			
			$args = new ArrayObject($_SERVER['argv']);
			$args->offsetUnset(0);
			$i = $args->getIterator();
			while($i->valid()) {
				if(substr($i->current(), 0, 1) == '-') {
					// parse argument
					self::_parseArgument($i->current());
				} else {
					// invalid call
					throw new Exception('Invalid call');
				}
				
				$i->next();
			}
		}
		
		/**
		 * Parses a single argument
		 * 
		 * @param $argument
		 * @return unknown_type
		 */
		protected static function _parseArgument($argument) {
			if(strstr($argument, '=')) {
				// definition
				$name = substr($argument, 1, 1);
				
				$parts = split('=', $argument);
				if(substr($parts[1], 0, 1) == '"') {
					$value = substr($parts[1], 1, strlen($parts[1] - 2));
				} else {
					$value = $parts[1];
				}
				
				self::$_arguments->append(new Brawler_Console_Argument($name, $value));
			} else {
				// option or optiongroup
				for($i = 1; $i < strlen($argument); $i++) {
					self::$_arguments->append(new Brawler_Console_Argument(substr($argument, $i, 1)));
				}
			}
		}
	}
?>