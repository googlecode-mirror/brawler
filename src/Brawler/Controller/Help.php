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
	 * Help Controller
	 * 
	 * @package     Brawler
	 * @subpackage  Help
	 * @author      Cem Derin, <actioncem@gmail.com>
	 * @copyright   2009 Cem Derin, <actioncem@gmail.com>
	 */
	class Brawler_Controller_Help extends Brawler_Controller {
		/**
		 * Index action
		 * @return void
		 */
		public function indexAction() {
			$this->setView(new Brawler_View_Help_Index());
			$this->forward('help', 'showArguments');
		}
		
		/**
		 * Displays the argument list
		 * 
		 * @return void
		 */
		public function showArgumentsAction() {
			$this->setView(new Brawler_View_Grid());
			
			// assemble rows
			$rows = new ArrayObject();
			$arguments = Brawler_Application::getArguments();
			$i = $arguments->getIterator();
			while($i->valid()) {
				$put = array();
				
				if($i->current()->hasValue()) {
					$put[] = '-'. $i->current()->getName().'=<value>';
				} else {
					$put[] = '-'. $i->current()->getName();
				}
				
				$put[] = $i->current()->getDescription();
				
				$rows->append($put);
				
				$i->next();
			}
			
			$this->getView()->setRows($rows);
		}
	}
?>