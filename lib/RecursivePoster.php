<?php
    class RecursivePoster {
        function __construct($dataset, $partialURI = "./partials/") {
            $this->DataSet = [];;
            $this->PartialURI = $dataset;

            $this->Seed($dataset);
        }

        public function Seed($dataset, $mapping) {
            RecursivePoster::ProcessDataSet($dataset, $mapping);

            return $this;
        }

        public function Create($partial, $id, $lookup) {
            RecursivePoster::CreatePartial($this->PartialURI . $partial, $id, $lookup);

            return $this;
        }



        public static function CreatePartial($partial, $id, $lookup) {
            $ViewBag = $lookup[ $id ];
    
            include $partial . ".php";

            return RecursivePoster;
        }

        public static function ProcessRow($id, $key, $payload, $children = [], $order = null) {
            return json_encode([
                "id" => $id,
                "key" => $key,
                "payload" => $payload,
                "children" => $children,
                "order" => $order
            ]);
        }

        public static function ProcessDataSet($dataset, $mapping) {
            $return = [];

            foreach($dataset as $i => $item) {
                $row = RecursivePoster::ProcessRow(
                    $item[ $mapping[ "id" ] ],
                    $item[ $mapping[ "key" ] ],
                    $item[ $mapping[ "payload" ] ],
                    $item[ $mapping[ "children" ] ],
                    $item[ $mapping[ "order" ] ]
                );

                array_push($return, $row);
            }

            return $return;
        }
    }
?>