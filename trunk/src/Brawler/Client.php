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
	 * Client implementation
	 * 
	 * @package     Brawler
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Client 
		extends Brawler_Plugin_Pluggable_Abstract 
		implements Brawler_Client_Interface {
		/**
		 * Holds the cURL resource
		 * 
		 * @var Resource
		 */
		protected $_curlResource;
		
		/**
		 * Holds the last raw response
		 * 
		 * @var String
		 */
		protected $_response;
		
		/**
		 * Ctor
		 * 
		 * @return void
		 */
		public function __construct() {
			parent::__construct();
			$this->_initCurl();
		}
		
		/**
		 * Requests a resource
		 * 
		 * @param String $url
		 * @return Brawler_Client_Response
		 */
		public function request($url) {
			$this->_setOption(CURLOPT_URL, $url);
			$this->_result = curl_exec($this->_curlResource);
			return new Brawler_Client_Response($this->_result, curl_getinfo($this->_curlResource));
		}
		
		/**
		 * Inits the curl resource
		 * 
		 * @return void
		 */
		protected function _initCurl() {
			$this->preCallNotify('_initCurl', array());
			
			$this->_curlResource = curl_init();
			$this->_setOption(CURLOPT_RETURNTRANSFER, true);
			$this->_setOption(CURLOPT_HEADER, true);
			$this->_setOption(CURLOPT_USERAGENT, 'brawler '. Brawler_Application::getVersion());
			
			$this->postCallNotify('_initCurl', array(), $this->_curlResource);
		}
		
		/**
		 * Sets an curl option
		 * 
		 * @param String $option
		 * @param String $value
		 * @return void
		 */
		protected function _setOption($option, $value) {
			curl_setopt($this->_curlResource, $option, $value);
		}
	}