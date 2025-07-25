<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');



if(file_exists(APPPATH.'Modules')) {

	$modulesPath=APPPATH.'Modules/';
	$modules=scandir($modulesPath);
	
	foreach($modules as $module){
		if($module ==='.' || $module === '..') continue;
		if(is_dir($modulesPath). '/'.$module){
			$routesPath=$modulesPath . $module . '/Config/Routes.php';
			if(file_exists($routesPath)) {
				require($routesPath);
			} else {
				continue;
			}
		}
	}
 } 