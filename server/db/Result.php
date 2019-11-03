<?php
	abstract class BasicEnum {
		private static $constCacheArray = NULL;
	
		private static function getConstants() {
			if (self::$constCacheArray == NULL) {
				self::$constCacheArray = [];
			}
			$calledClass = get_called_class();
			if (!array_key_exists($calledClass, self::$constCacheArray)) {
				$reflect = new ReflectionClass($calledClass);
				self::$constCacheArray[$calledClass] = $reflect->getConstants();
			}
			return self::$constCacheArray[$calledClass];
		}
	
		public static function isValidName($name, $strict = false) {
			$constants = self::getConstants();
	
			if ($strict) {
				return array_key_exists($name, $constants);
			}
	
			$keys = array_map('strtolower', array_keys($constants));
			return in_array(strtolower($name), $keys);
		}
	
		public static function isValidValue($value, $strict = true) {
			$values = array_values(self::getConstants());
			return in_array($value, $values, $strict);
		}
	}

	class Result {
		public $Data = [];

		function __construct($data) {
			$this->set($data);
		}

		function __call($name, $args) {
			if(isset($this->Data[ $name ])) {
				if(isset($args[0])) {
					return $this->Data[ $name ] = $args[0];
				}

				return $this->Data[ $name ];
			}

			return false;
		}

		function get() {
			return $this->Data;
		}
		function set($data = []) {
			return $this->Data = $data;
		}
	}

	class ResultSet {
		public $Columns = [];
		public $Results = [];

		function __construct($results, $columns = []) {
			$this->Results = $results;
			$this->Columns = $columns;
		}

		function Row($i = 0) {
			return $this->Results[ $i ];
		}
		function Cell($i, $col) {
			return $this->Results[ $i ]->{$col}();
		}

		function get() {
			return $this->Results;
		}
		function set($results = []) {
			return $this->Results = $results;
		}

		function getColumns() {
			return $this->Columns;
		}
		function setColumns($columns = []) {
			return $this->Columns = $columns;
		}
	}
?>