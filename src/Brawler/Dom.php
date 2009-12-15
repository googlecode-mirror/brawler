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
	 * DOM class for xhtml files
	 * 
	 * @package     Brawler
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Dom {
		/**
		 * DOMDocument
		 * 
		 * @var DOMDocument
		 */
		protected $_dom;
		
		/**
		 * Holds the URL of this document
		 * 
		 * @var String
		 */
		protected $_currentURL;
		
		/**
		 * Ctor
		 * 
		 * @param String $source
		 * @return void
		 */
		public function __construct($source, $currentURL = null) {
			$this->_dom = new DOMDocument();
			$this->_currentURL = $currentURL;
			
			// unfortunately neccessary until a error handler is implemented
			@$this->_dom->loadHTML($source);
		}
		
		/**
		 * Returns found URLs
		 * @return DOMNodeList
		 */
		public function getUrls() {
			return $this->_dom->getElementsByTagName('a');
		}
	}