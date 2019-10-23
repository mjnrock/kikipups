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
        protected function _select() {
            $query = "SELECT";

            foreach($this->Columns as $i => $col) {
                if($i === 0) {
                    $query .= "\n\t" . $col;
                } else {
                    $query .= "\n\t," . $col;
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
        public function CrossApply($table) {
            $this->_addTable($table, [ "APPLY", "CROSS" ], null, null);

            return $this;
        }
        public function OuterApply($table) {
            $this->_addTable($table, [ "APPLY", "OUTER" ], null, null);

            return $this;
        }
        protected function _from() {
            $query = "FROM";

            foreach($this->From as $i => $table) {
                if($i === 0) {
                    if($table[ 0 ][ "type" ] === "CLASS") {
                        //  TODO
                    } else {
                        $query .= "\n\t" . $table[ 0 ][ "name" ] . " t{$i}";
                    }
                } else {
                    if($table[ 0 ][ "type" ] === "CLASS") {
                        //  TODO
                    } else {
                        if($table[ 1 ][ "type" ][ 0 ] === "JOIN") {
                            $query .= "\n\t" . $table[ 1 ][ "type" ][ 1 ] . " " . $table[ 1 ][ "type" ][ 0 ] . " " . $table[ 0 ][ "name" ] . " t{$i}";
                            $query .= "\n\t\t" . "ON " . $table[ 1 ][ "left" ] . " = " . $table[ 1 ][ "right" ];
                        } else if($table[ 1 ][ "type" ][ 0 ] === "APPLY") {
                            $query .= "\n\t" . $table[ 1 ][ "type" ][ 1 ] . " " . $table[ 1 ][ "type" ][ 0 ] . " " . $table[ 0 ][ "name" ] . " t{$i}";
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
        protected function _where() {
            if(!empty($this->Where)) {
                $query = "WHERE (";
                $query .= "\n\t" . $this->Where[ 0 ];
                $query .= "\n)";
    
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
        protected function _groupBy() {
            if(!empty($this->GroupBy)) {
                $query = "GROUP BY";
    
                foreach($this->GroupBy as $i => $col) {
                    if($i === 0) {
                        $query .= "\n\t" . $col;
                    } else {
                        $query .= "\n\t," . $col;
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
        protected function _having() {
            if(!empty($this->Having)) {
                $query = "HAVING (";
                $query .= "\n\t" . $this->Having[ 0 ];
                $query .= "\n)";
    
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
        protected function _orderBy() {
            if(!empty($this->OrderBy)) {
                $query = "ORDER BY";

                foreach($this->OrderBy as $i => $col) {
                    if($i === 0) {
                        $query .= "\n\t" . $col;
                    } else {
                        $query .= "\n\t," . $col;
                    }
                }

                return $query . "\n";
            }

            return null;
        }
        

        public function Process() {
            $query = $this->_select();
            $query .= $this->_from();
            $query .= $this->_where();
            $query .= $this->_groupBy();
            $query .= $this->_having();
            $query .= $this->_orderBy();

            $this->Query = $query;

            return $query;
        }
        public function Interpolate($params = []) {
            $this->Process();

            if(is_array($params) && !empty($params)) {
                foreach($params as $i => $param) {
                    $this->Query = preg_replace("/\{\{[{$i}]}}/m", $param, $this->Query);
                }
            }
            cout($this->Query);

            return $this;
        }

        
        public static function Start($columns = [ "*" ]) {
            return new Select($columns);
        }
    }
?>