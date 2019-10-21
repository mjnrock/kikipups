<?php
	abstract class AController {
		private $model;

		public function __construct($model) {
			$this->model = $model;
		}

		
		public function exampleFunction() {
			$this->model->string = "Updated Data, thanks to MVC and PHP!";
		}
	}
?>