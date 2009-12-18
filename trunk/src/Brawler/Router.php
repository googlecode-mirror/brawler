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
				$match = self::_checkFlag($argumentIterator->current());
					if(!$match) break;
					
				$match = self::_checkValue($argumentIterator->current());
					if(!$match) break;
					
				$match = self::_checkSpecificValue($argumentIterator->current());
					if(!$match) break;
				
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
		
		/**
		 * Checks whether a route argument is present in call request
		 * 
		 * @param Brawler_Router_Argument $routeArgument
		 * @return Bool
		 */
		protected static function _checkFlag(Brawler_Router_Argument $routeArgument) {
			return Brawler_Console::getArgument($routeArgument->getFlag());
		}
		
		/**
		 * Checks whether a route arguments value is present
		 * 
		 * @param Brawler_Router_Argument $routeArgument
		 * @return Bool
		 */
		protected static function _checkValue(Brawler_Router_Argument $routeArgument) {
			if($routeArgument->getOnValue()) {
				$argument = Brawler_Console::getArgument($routeArgument->getFlag());
				if(!$argument OR !$argument->getValue()) {
					return false;
				}
			}
			
			return true;
		}
		
		/**
		 * Checks whether a route arguments vakue matches to the required
		 * 
		 * @param Brawler_Router_Argument $routeArgument
		 * @return Bool
		 */
		protected static function _checkSpecificValue(Brawler_Router_Argument $routeArgument) {
			if($routeArgument->getSpecificValue()) {
				if(self::_checkValue($routeArgument)) {
					$argument = Brawler_Console::getArgument($routeArgument->getFlag());
					return ($argument->getValue() == $routeArgument->getSpecificValue());
				}
			}
			
			return true;
		}
	}