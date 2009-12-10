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
	 * Provides basic cli features
	 * 
	 * @package     Brawler
	 * @subpackage  Console
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
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
		public static function getArguments() {
			if(!self::$_arguments) {
				self::_parseArguments();
			}
			
			return self::$_arguments;
		}
		
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
		 * @return void
		 */
		protected static function _parseArgument($argument) {
			$return = self::_parseNonValuedArgument($argument);
				if($return) return;
			
			$return = self::_parseValuedArgument($argument);
				if($return) return;
		}
		
		/**
		 * Parses an non valued argument or an argument group
		 * 
		 * @param String $argument
		 * @return Bool
		 */
		protected static function _parseNonValuedArgument($argument) {
			if(preg_match('#-([a-zA-Z0-9]+)$#', $argument, $return)) {
				for($i = 0; $i < strlen($return[1]); $i++) {
					$newArgument = new Brawler_Console_Argument($return[1][$i]);
					self::$_arguments->append($newArgument);
				}
				return true;
			}
			return false;
		}
		
		/**
		 * Parses a valued argument
		 * 
		 * @param String $argument
		 * @return Bool
		 */
		protected static function _parseValuedArgument($argument) {
			if(preg_match('#-([a-zA-Z0-9]{1})=(.+)#', $argument, $return)) {
				if(preg_match('#^"(.+)"$#', $return[2], $vReturn)) {
					$value = $vReturn[1];
				} else {
					$value = $return[2];
				}
				
				$newArgument = new Brawler_Console_Argument($return[1], $value);
				self::$_arguments->append($newArgument);
				
				return true;
			}
			
			return false;
		}
	}
?>