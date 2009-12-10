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
	 * View for grids
	 * 
	 * @package     Brawler
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_View_Grid extends Brawler_View {
		/**
		 * Holds possible Labels
		 * 
		 * @var ArrayObject
		 */
		protected $_labels = null;
		
		/**
		 * Appended rows
		 * 
		 * @var ArrayObject
		 */
		protected $_rows = null;
		
		/**
		 * Holds the calculated column widths
		 * 
		 * @var Array
		 */
		protected $_columnwidth = array();
		
		/**
		 * Holds the column padding
		 * 
		 * @var Int
		 */
		protected $_padding = 2;
		
		/**
		 * Sets labels for the header row
		 * 
		 * @param $labels ArrayObject
		 * @return void
		 */
		public function setLabels(ArrayObject $labels) {
			$this->_labels = $labels;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see trunk/src/Brawler/Brawler_View#render()
		 */
		public function render() {
			if($this->_labels) {
				$this->_renderline($this->_labels);
			}
			
			if($this->_rows) {
				$i = $this->_rows->getIterator();
				while($i->valid()) {
					$this->_renderline($i->current());
					$i->next();
				}
			}
		}
		
		/**
		 * Sets the rows
		 * @param $rows ArrayObject
		 * @return void
		 */
		public function setRows(ArrayObject $rows) {
			$this->_rows = $rows;
		}
		
		/**
		 * Renders a single line
		 * 
		 * @param $row
		 * @return void
		 */
		protected function _renderline($row) {
			if(!$this->_columnwidth) {
				$this->_determineColumnWidth();
			}
			
			$row = (array) $row;
			
			$i = 0;
			$print = '';
			foreach($row as $value) {
				$fillcount = 
							$this->_columnwidth[$i] - 
							strlen($value) + 
							$this->_padding;
							
				$print.= $value. str_repeat(' ', $fillcount);
				$i++;
			}
			
			Brawler_Console_Output::output($print);
		}
		
		/**
		 * Determines the columns width
		 * 
		 * @return void
		 */
		protected function _determineColumnWidth() {
			$i = $this->_rows->getIterator();
			while($i->valid()) {
				$r = (array) $i->current();
				
				$k = 0;
				foreach($r as $value) {
					if(!isset($this->_columnwidth[$k])) {
						// not set yet
						$this->_columnwidth[$k] = strlen($value);
					} else {
						// set only if greater
						if(strlen($value) > $this->_columnwidth[$k]) {
							$this->_columnwidth[$k] = strlen($value);
						}
					}
					
					$k++;
				}
				
				$i->next();
			}
		}
	}
?>