<?php
namespace carsdb;
class Routes implements \entry\Routes {
	public function getPage($route) {
       
		require '../db.php';

        $homeTable = new \entry\DatabaseTable($pdo, 'stories', 'id');
        $showroom = new \entry\DatabaseTable($pdo,'cars','id');
        $careers = new \entry\DatabaseTable($pdo,'careers','id');
        $contacts = new \entry\DatabaseTable($pdo,'contacts','id');
        $manufacturers = new \entry\DatabaseTable($pdo,'manufacturers','id');
        $admins = new \entry\DatabaseTable($pdo,'users','id');
        

        $controllers = [];
        $controllers['stories'] =new \carsdb\controllers\homeController($homeTable);
        $controllers['showroom'] =new \carsdb\controllers\showroom($showroom,$manufacturers);
        $controllers['careers'] =new \carsdb\controllers\careers($careers);
        $controllers['contacts'] =new \carsdb\controllers\contact($contacts);
        $controllers['manus'] =new \carsdb\controllers\manufacturer($manufacturers,$showroom);
        $controllers['admin'] =new \carsdb\controllers\admin($admins);

        if ($route=='') 
        {
        $page = $controllers['stories']->list();    
        }
        else {
        list($controllerName, $functionName) = explode('/', $route);
        $controller = $controllers[$controllerName];
        $page = $controller->$functionName();
        }
        
        return $page;

    }

}