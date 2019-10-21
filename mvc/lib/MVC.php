<?php
	class MVC {
		protected $Model;
		protected $Controller;
		protected $View;
		
		function __construct($model, $controller, $view) {
			$this->Model = $model;
			$this->Controller = $controller;
			$this->View = $view;
		}

		//	return '<p><a href="mvc.php?action=exampleFunction">' . $this->model->string . "</a></p>";
		//	$this->call($_GET['action']);
		public function call($method, $args = []) {
			if(isset($method) && !empty($method)) {
				return $controller->{ $method }( ...$args );
			}

			return null;
		}

		public function render() {
			if(isset($_GET["action"]) && !empty($_GET["action"])) {
				if(isset($_GET["params"]) && !empty($_GET["params"])) {
					$ViewBag = $this->call($_GET["action"], $_GET["params"]);
				} else {
					$ViewBag = $this->call($_GET["action"]);
				}
			}
			
			echo $this->View->output(isset($ViewBag) && !empty($ViewBag) ? $ViewBag : null);
		}

		public static function renderHeader() {
			include "{$_SERVER["DOCUMENT_ROOT"]}/partials/_header.php";
		}
		public static function renderFooter() {
			include "{$_SERVER["DOCUMENT_ROOT"]}/partials/_footer.php";
		}
		public static function renderNavBar() {
			include "{$_SERVER["DOCUMENT_ROOT"]}/partials/_navbar.php";
		}
	}
?>