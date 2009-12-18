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
	 * Scanner controller
	 * 
	 * @package     Brawler
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Controller_Scan extends Brawler_Controller {
		/**
		 * Holds an array with the fetched urls
		 * 
		 * @var Array
		 */
		protected $_urls = array();
		
		/**
		 * Holds the client
		 * 
		 * @var Brawler_Client
		 */
		protected $_client;
		
		/**
		 * Index Action
		 * 
		 * @return void
		 */
		public function indexAction() {
			$this->_client = new Brawler_Client();

			$url = Brawler_Console::getArgument('r')->getValue();
			
			if(Brawler_Console::getArgument('f')) {
				$depth = Brawler_Console::getArgument('f')->getValue();
			} else {
				$depth = '5';
			}
			
			$this->_scanRecursively($url, 0, 5);
			
			/*$grid = new Brawler_View_Grid();
			$grid->setRows(new ArrayObject($this->_urls));
			$this->setView($grid);
			$grid->setLabels(new ArrayObject(array('URL')));*/
			
			Brawler_Console_Output::output(
				'Found '. count($this->_urls). ' recources.'
			);
		}
		
		/**
		 * Recursive method
		 * 
		 * @param String $url
		 * @param Int $level
		 * @param Int $maxlevel
		 * @return void
		 */
		protected function _scanRecursively($url, $level, $maxlevel) {
			Brawler_Console_Output::output('Scanning: '. $url);
			
			// Checking for Vulns
			$this->_checkVulnerabilites($url);
			
			// fetch urls
			$urls = $this->_client->request($url)->getUrls();
			$urls = array_unique($urls);
			$urls = $this->_filterKnownUrls($urls);
			$urls = $this->_filterForeignHostUrls($urls);
			
			Brawler_Console_Output::output('Found '. count($urls). ' new resources.');

			$this->_urls = array_merge($urls, $this->_urls);

			// scan newly found urls
			if($level < $maxlevel) {
				foreach($urls as $newUrl) {
					$this->_scanRecursively($newUrl, $level+1, $maxlevel);
				} 
			}
		}
		
		/**
		 * Filters already known urls
		 * 
		 * @param Array $urls
		 * @return Array
		 */
		protected function _filterKnownUrls($urls) {
			$return = array();
			
			foreach($urls as $url) {
				if(!in_array($url, $this->_urls)) {
					$return[] = $url;
				}
			}
			
			return $return;
		}
		
		/**
		 * Filters foreign host urls
		 * 
		 * @param Array $urls
		 * @return Array
		 */
		protected function _filterForeignHostUrls($urls) {
			$return = array();
			$curl = Brawler_Console::getArgument('r')->getValue();
			foreach($urls as $url) {
				if(parse_url($url, PHP_URL_HOST) == parse_url($curl, PHP_URL_HOST)) {
					$return[] = $url;
				}
			}
			
			return $return;
		}
		
		protected function _checkVulnerabilites($url) {
			$this->preCallNotify('_checkVulnerabilities', array($url));
		}
	}