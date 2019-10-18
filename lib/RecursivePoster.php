<?php
    //* This class requires associative keys for the mapping array to work predictably
    //*  and will find its partials in ./partials/ by default
    class RecursivePoster {
        function __construct($dataset, $mapping = null, $partialURI = "./partials/") {
            $this->DataSet = [];
            $this->Mapping = $mapping;
            $this->PartialURI = $partialURI;
            $this->Functions = [];

            $this->Seed($dataset);
        }

        public function AddHelper($key, $fn) {
            $this->Functions[ $key ] = $fn;

            return $this;
        }

        public function Seed($dataset) {
            $this->DataSet = RecursivePoster::ProcessDataSet($dataset, $this->Mapping);

            return $this;
        }

        public function Create($id, $partial) {
            RecursivePoster::CreatePartial($this->PartialURI . $partial, $id, $this);

            return $this;
        }



        public static function CreatePartial($partial, $id, $scope) {
            $ViewBag = $scope->DataSet[ (int)$id ];
            $ViewBag[ "@partial" ] = $partial;
            $ViewBag[ "@id" ] = $id;
            $ViewBag[ "@scope" ] = $scope;
            $ViewBag[ "@fn" ] = $scope->Functions;
    
            include $partial . ".php";

            return RecursivePoster;
        }

        public static function ProcessRow($id, $key, $payload, $children = [], $order = null) {
            return [
                "id" => $id,
                "key" => $key,
                "payload" => $payload,
                "children" => $children,
                "order" => $order
            ];
        }

        public static function ProcessDataSet($dataset, $mapping = null) {
            $return = [];

            if(isset($mapping)) {
                foreach($dataset as $i => $item) {
                    $row = RecursivePoster::ProcessRow(
                        $item[ (int)$mapping[ "id" ] ],
                        $item[ $mapping[ "key" ] ],
                        $item[ $mapping[ "payload" ] ],
                        $item[ $mapping[ "children" ] ],
                        $item[ $mapping[ "order" ] ]
                    );

                    array_push($return, $row);
                }
            } else {
                foreach($dataset as $i => $item) {
                    $row = RecursivePoster::ProcessRow(
                        null,
                        null,
                        $item,
                        [],
                        null
                    );

                    array_push($return, $row);
                }
            }

            return $return;
        }
    }
?>