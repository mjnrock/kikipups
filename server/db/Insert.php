<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/server/db/Select.php";

    class Insert extends Select {
        public $Table = "";
        public $Values = [];

        function __construct($table, $columns = []) {
            $this->Table = $table;
			
            if(is_array($columns)) {
                $this->Columns = $columns;
            } else {
                $this->Columns = [];
            }

            return $this;
        }
        protected function _insert($indent = 0) {
            $tabs = $this->_tabs($indent);
			
			$query = "{$tabs}INSERT INTO " . $this->Table;
			
			if(!empty($this->Columns)) {
				$query .= " (";

				foreach($this->Columns as $i => $col) {
					if($i === 0) {
						$query .= "\n{$tabs}\t" . $col;
					} else {
						$query .= "\n{$tabs}\t," . $col;
					}
				}
				
				$query .= "\n{$tabs})";
			}

            return $query . "\n";
        }
		

        public function Values($values = []) {
            if(is_array($values) && !empty($values)) {
                $this->Values = $values;
            }

            return $this;
		}
		
        protected function _valuesReducer($row) {
			return array_reduce($row, function($p, $n) {
				if(!empty($p)) {
					return $p . ", " . $n;
				}

				return $n;
			}, "");
		}
        protected function _values($indent = 0) {
            $tabs = $this->_tabs($indent);

            if(!empty($this->Values)) {
                $query = "{$tabs}VALUES (";

				if(is_array($this->Values[ 0 ])) {
					foreach($this->Values as $i => $row) {
						if($i === 0) {
							$query .= "\n{$tabs}\t( " . $this->_valuesReducer($row) . " )";
						}
						 else {
							$query .= "\n{$tabs}\t,( " . $this->_valuesReducer($row) . " )";
						}
					}
				} else {
					foreach($this->Values as $i => $col) {
						if($i === 0) {
							$query .= "\n{$tabs}\t" . $col;
						} else {
							$query .= "\n{$tabs}\t," . $col;
						}
					}
				}

				$query .= "\n{$tabs})";
	
				return $query . "\n";
            }

            return null;
        }     

        public function Process($indent = 0) {
			$query = $this->_insert($indent);
			
			if(!empty($this->From)) {
				$query .= $this->_from($indent);
				$query .= $this->_where($indent);
				$query .= $this->_groupBy($indent);
				$query .= $this->_having($indent);
			} else {
				$query .= $this->_values($indent);
			}

            return $query;
        }
        
        public static function Start($table, $columns = []) {
            return new Insert($table, $columns);
        }
    }
?>