<?php
namespace entry;
class EntryPoint {
	private $routes;

	public function __construct(Routes $routes) {
		$this->routes = $routes;
	}
    public function run() {
		$route = ltrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');
		$page = $this->routes->getPage($route);
		$output = $this->loadTemplate('../templates/' . $page['template'],
		$page['variables']);
		$title = $page['title'];
		$left = $page['left'];

		require '../templates/layout.html.php';
    }
        public function loadTemplate($fileName, $templateVars) {
            extract($templateVars);
            ob_start();
            require $fileName;
            $contents = ob_get_clean();
            return $contents;
        }

		function load($fileName) {
			ob_start();
			require $fileName;
			$contents = ob_get_clean();
			return $contents;       
	}
}