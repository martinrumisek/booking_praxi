<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ROUTY PRO VIEWČKA
$routes->get('/home', 'Home::index'); //routa na hlavní stránku
$routes->get('login', 'Home::login'); //Přihlašovácí stránka
$routes->get('registration', 'Home::registration'); //stránka pro registraci firmy
$routes->get('practise_offer', 'Home::offerView'); //stránka pro nabídky praxe
$routes->get('people','Home::people'); //stránka pro zobrazení lidí z oauh
$routes->get('company','Home::companyView'); //stránka pro zobrazení firem
$routes->get('profile','Home::profileView'); //stránka pro zobrazení profilu
//ROUTY PRO BTN - SCRIPT
//ROUTY PRO AUTH

//ZKUŠEBNÍ ROUTY - PŘI VÝVOJI
$routes->get('logAD', 'Auth::loginOAUH'); //routa pro tlačítko pro přesměrování na login Microsoft office - OAUH      
$routes->get('/', 'Auth::callback'); // Routa pro zpracování údajů po přihlášení (Microsoft office - OAUH)   
$routes->get('azure-users', 'UserAzureSync::index'); //routa pro btn - pro script (načtení všech uživatelů z db - azure)