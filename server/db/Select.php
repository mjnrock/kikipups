<?php
    class Select {
        public $Query = "";
        public $Columns = [];
        public $From = [];
        public $Where = [];
        public $GroupBy = [];
        public $Having = [];
        public $Order = [];

        function __construct($columns = [ "*" ]) {
            if(is_array($columns)) {
                $this->Columns = $columns;
            } else {
                $this->Columns = [ "*" ];
            }

            return $this;
        }
        protected function _tabs($indent = 0) {
            $tabs = "";

            for($i = 0; $i < $indent; $i++) {
                $tabs .= "\t";
            }

            return $tabs;
        }
        protected function _select($indent = 0) {
            $tabs = $this->_tabs($indent);
            
            $query = "{$tabs}SELECT";
            foreach($this->Columns as $i => $col) {
                if($i === 0) {
                    $query .= "\n{$tabs}\t" . $col;
                } else {
                    $query .= "\n{$tabs}\t" . $col;
                }
            }

            return $query . "\n";
        }

        protected function _addTable($table, $joinType, $left, $right) {
            if(is_string($table) || $table instanceof Select) {
                array_push($this->From, [
                    [
                        "type" => $table instanceof Select ? "CLASS" : "STRING",
                        "name" => $table
                    ],
                    [
                        "type" => $joinType,
                        "left" => $left,
                        "right" => $right
                    ]
                ]);
            }

            return $this;
        }
        public function From($table) {
            $this->_addTable($table, null, null, null);

            return $this;
        }
        public function InnerJoin($table, $left, $right) {
            $this->_addTable($table, [ "JOIN", "INNER" ], $left, $right);

            return $this;
        }
        public function OuterJoin($table, $left, $right) {
            $this->_addTable($table, [ "JOIN", "OUTER" ], $left, $right);

            return $this;
        }
        public function RightJoin($table, $left, $right) {
            $this->_addTable($table, [ "JOIN", "RIGHT" ], $left, $right);

            return $this;
        }
        public function LeftJoin($table, $left, $right) {
            $this->_addTable($table, [ "JOIN", "LEFT" ], $left, $right);

            return $this;
        }
        public function CrossApply($table, $inputs = []) {
            $this->_addTable($table, [ "APPLY", "CROSS" ], $inputs, null);

            return $this;
        }
        public function OuterApply($table, $inputs = []) {
            $this->_addTable($table, [ "APPLY", "OUTER" ], $inputs, null);

            return $this;
        }
        protected function _from($indent = 0) {
            $tabs = $this->_tabs($indent);

            $query = "{$tabs}FROM";
            foreach($this->From as $i => $table) {
                if($i === 0) {
                    $item = "";
                    if($table[ 0 ][ "type" ] === "CLASS" && $table[ 0 ][ "name" ] instanceof Select) {
                        $item .= "{$tabs}\t(\n"
                            . $table[ 0 ][ "name" ]->Process($indent + 2)
                            . "{$tabs}\t)";
                    } else {
                        $item = "\t" . $table[ 0 ][ "name" ];
                    }

                    $query .= "\n{$tabs}" . $item . " t{$i}";
                } else {
                    if($table[ 0 ][ "type" ] === "CLASS" && $table[ 0 ][ "name" ] instanceof Select) {
                        //  TODO
                    } else {
                        if($table[ 1 ][ "type" ][ 0 ] === "JOIN") {
                            $query .= "\n{$tabs}\t" . $table[ 1 ][ "type" ][ 1 ] . " " . $table[ 1 ][ "type" ][ 0 ] . " " . $table[ 0 ][ "name" ] . " t{$i}";
                            $query .= "\n{$tabs}\t\t" . "ON " . $table[ 1 ][ "left" ] . " = " . $table[ 1 ][ "right" ];
                        } else if($table[ 1 ][ "type" ][ 0 ] === "APPLY") {
                            $query .= "\n{$tabs}\t"
                                . $table[ 1 ][ "type" ][ 1 ] . " "
                                . $table[ 1 ][ "type" ][ 0 ] . " "
                                . $table[ 0 ][ "name" ];

                            if(is_array($table[ 1 ][ "left" ]) && !empty($table[ 1 ][ "left" ])) {
                                $query .= "(";

                                foreach($table[ 1 ][ "left" ] as $i => $param) {
                                    if($i === 0) {
                                        $query .= $param;
                                    } else {
                                        $query .= ", " . $param;
                                    }
                                }
                                
                                $query .= ")";
                            }

                            $query .= " t{$i}";
                        }
                    }
                }
            }

            return $query . "\n";
        }
        


        public function Where($condition = null) {
            if(!is_null($condition)) {
                array_push($this->Where, $condition);
            }

            return $this;
        }
        protected function _where($indent = 0) {
            $tabs = $this->_tabs($indent);

            if(!empty($this->Where)) {
                $query = "{$tabs}WHERE (";
                $query .= "\n{$tabs}\t" . $this->Where[ 0 ];
                $query .= "\n{$tabs})";
    
                return $query . "\n";
            }

            return null;
        }

        public function GroupBy($columns = []) {
            if(is_array($columns) && !empty($columns)) {
                $this->GroupBy = $columns;
            }

            return $this;
        }
        protected function _groupBy($indent = 0) {
            $tabs = $this->_tabs($indent);

            if(!empty($this->GroupBy)) {
                $query = "{$tabs}GROUP BY";
    
                foreach($this->GroupBy as $i => $col) {
                    if($i === 0) {
                        $query .= "\n{$tabs}\t" . $col;
                    } else {
                        $query .= "\n{$tabs}\t," . $col;
                    }
                }
    
                return $query . "\n";
            }

            return null;
        }

        public function Having($condition = null) {
            if(!is_null($condition)) {
                array_push($this->Having, $condition);
            }

            return $this;
        }
        protected function _having($indent = 0) {
            $tabs = $this->_tabs($indent);

            if(!empty($this->Having)) {
                $query = "{$tabs}HAVING (";
                $query .= "\n{$tabs}\t" . $this->Having[ 0 ];
                $query .= "\n{$tabs})";
    
                return $query . "\n";
            }

            return null;
        }

        public function OrderBy($columns = []) {
            if(is_array($columns) && !empty($columns)) {
                $this->OrderBy = $columns;
            }

            return $this;
        }
        protected function _orderBy($indent = 0) {
            $tabs = $this->_tabs($indent);

            if(!empty($this->OrderBy)) {
                $query = "{$tabs}ORDER BY";

                foreach($this->OrderBy as $i => $col) {
                    if($i === 0) {
                        $query .= "\n{$tabs}\t" . $col;
                    } else {
                        $query .= "\n{$tabs}\t," . $col;
                    }
                }

                return $query . "\n";
            }

            return null;
        }
        

        protected function _interpolate($params = []) {
            if(is_array($params) && !empty($params)) {
                foreach($params as $i => $param) {
                    $this->Query = preg_replace("/\{\{[{$i}]}}/m", $param, $this->Query);
                }
            }

            return $this->Query;
        }
        public function Process($indent = 0) {
            $query = $this->_select($indent);
            $query .= $this->_from($indent);
            $query .= $this->_where($indent);
            $query .= $this->_groupBy($indent);
            $query .= $this->_having($indent);
            $query .= $this->_orderBy($indent);

            return $query;
        }
        
        public static function Start($columns = [ "*" ]) {
            return new Select($columns);
        }
        public function End($params = []) {
            $this->Query = $this->Process();

            if(is_array($params) && !empty($params)) {
                $this->_interpolate($params);
            }

            return $this->Query;
        }
    }
?>