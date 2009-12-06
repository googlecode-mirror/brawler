<?php
	abstract class Brawler_Console_Input {
		public static function get($msg, $stripEnter = true) {
			Brawler_Console_Output::output($msg);
			
			do {
				$return = fgets(self::_getStream());
			} while(!self::_validate($return));
			
			if($stripEnter) {
				$return = substr($return, 0, strlen($return) - 1);
			}
			
			return $return;
		}
		
		protected static function _getStream() {
			return fopen('php://stdin', 'w');
		}
		
		protected static function _validate($value) {
			return true;
		}
	}
?>