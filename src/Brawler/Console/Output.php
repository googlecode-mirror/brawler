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
	 * CLI Output features
	 * 
	 * @package     Brawler
	 * @subpackage  Console
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Console_Output {
		/**
		 * Standard output stream
		 * 
		 * @var Ressource
		 */
		protected static $_stdout;
		
		/**
		 * Error Output
		 * 
		 * @var Ressource
		 */
		protected static $_stderr;
		
		/**
		 * Inits the output streams
		 * 
		 * @return void
		 */
		protected static function _init() {
			self::$_stdout = fopen('php://stdout', 'w');
			self::$_stderr = fopen('php://stderr', 'w');
		}
		
		/**
		 * Prints a message to the output streams
		 * 
		 * @param String $msg
		 * @param Boolean $error
		 * @return void
		 */
		public static function output($msg, $error = false) {
			if(!self::$_stdout OR !self::$_stderr) {
				self::_init();	
			}
			
			if($error) {
				$stream = self::$_stderr;
			} else {
				$stream = self::$_stdout;
			}
			
			fwrite($stream, $msg.PHP_EOL);
		}
	}
?>