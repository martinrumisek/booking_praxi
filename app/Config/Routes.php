<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/home', 'Home::index');
$routes->get('login', 'Home::login');
$routes->get('registration', 'Home::registration');
$routes->get('practise_offer', 'Home::offerView');
$routes->get('people','Home::people');
$routes->get('company','Home::companyView');
$routes->get('profile','Home::profileView');


//Zkoušky
$routes->get('logAD', 'Auth::loginOAUH');      
$routes->get('/', 'Auth::callback');   
$routes->get('azure-users', 'UserAzureSync::index');