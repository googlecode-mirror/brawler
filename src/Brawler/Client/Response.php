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
	 * A URL request response
	 * 
	 * @package     Brawler
	 * @subpackage  Client
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Client_Response {
		/**
		 * The raw result
		 * 
		 * @var String
		 */
		protected $_rawResult;
		
		/**
		 * The raw curl info array
		 * 
		 * @var Array
		 */
		protected $_rawInfo;

		/**
		 * Ctor 
		 * 
		 * @param String $dom
		 * @param Array $info
		 * @return void
		 */
		public function __construct($dom, $info) {
			$this->_rawResult = $dom;
			$this->_rawInfo = $info;
		}
		
		/**
		 * Returns a DOM representation of the returned document
		 * @return Brawler_Dom
		 */
		public function getDom() {
			if(strstr($this->getContentType(), 'html')) {
				return new Brawler_Dom($this->getRawContent(), $this->_rawInfo['url']);
			} else {
				throw new Brawler_Client_Response_Exception('Invalid content type');
			}
		}
		
		/**
		 * Returns the content type
		 * 
		 * @return String
		 */
		public function getContentType() {
			$return = split(';', $this->_rawInfo['content_type']);
			return trim($return[0]);
		}
		
		/**
		 * Returns the raw content (wo header)
		 * 
		 * @return String
		 */
		public function getRawContent() {
			return substr($this->_rawResult, $this->_rawInfo['header_size']);
		}
		
		/**
		 * Returns fetched urls
		 * 
		 * @return Array
		 */
		public function getUrls() {
			$return = array();
			
			$nodeList = $this->getDom()->getUrls();
			foreach($nodeList as $node) {
				$return[] = $node->attributes->getNamedItem('href')->value;
			}
			
			return $return;
		}
	}