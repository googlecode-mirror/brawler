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
	 * Router class
	 * 
	 * @package     Brawler
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Router {
		/**
		 * Holds the registered routes
		 * 
		 * @var Brawler_Router_Route_List
		 */
		protected static $_routes = null;
		
		/**
		 * Registers a given route
		 * 
		 * @param Brawler_Router_Route $route
		 * @return void
		 */
		public static function registerRoute(Brawler_Router_Route $route) {
			if(!self::$_routes) {
				self::_initRouteArray();
			}
			
			self::$_routes->append($route);
		}
		
		/**
		 * Inits the Route List
		 * 
		 * @return void
		 */
		protected static function _initRouteArray() {
			self::$_routes = new ArrayObject();
		}
		
		/**
		 * More or less the dispatcher ;)
		 * 
		 * @return void
		 */
		public static function route() {
			$i = self::$_routes->getIterator();
			while($i->valid()) {
				if(!self::_checkRoute($i->current())) {
					break;
				}
				$i->next();
			}
		}
		
		/**
		 * Checks a route for matching conditions
		 * 
		 * @param Brawler_Router_Route $route
		 * @return Bool
		 */
		protected static function _checkRoute(Brawler_Router_Route $route) {
			// check arguments
			$argumentIterator = $route->getArguments()->getIterator();
			$match = true;
			while($argumentIterator->valid()) {
				if(!Brawler_Console::getArgument($argumentIterator->current()->getFlag())) {
					// flag is missing break;
					$match = false;
					break;
				}
				
				if($argumentIterator->current()->getOnValue()) {
					if(!Brawler_Console::getArgument($argumentIterator->current()->getFlag())->getValue()) {
						// value is missing, break
						$match = false;
						break;
					}
					
					if($argumentIterator->current()->getSpecificValue()) {
						$specValue = $argumentIterator->current()->getSpecificValue();
						if(Brawler_Console::getArgument($argumentIterator->current()->getFlag())->getValue() != $specValue) {
							// value does not match, break
							$match = false;
							break;
						}
					}
				}
				$argumentIterator->next();
			}
			
			// dispatch
			if($match) {
				$route->getController()->dispatch($route->getAction());
			} else {
				return true;
			}
			
			// check chain
			return $route->getChain();
		}
	}