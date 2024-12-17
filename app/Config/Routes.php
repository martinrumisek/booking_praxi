<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// ROUTY PRO VIEWČKA (PŘIHLAŠOVACÍ & REGISTROVACÍ)
$routes->get('login', 'Home::login'); //Přihlašovácí stránka
$routes->get('registration', 'Home::registration'); //stránka pro registraci firmy
$routes->get('next-step-register','Home::continuationRegister' );
// ROUTY PRO VIEWČKA
$routes->get('/home', 'Home::index'/*, ['filter' => 'role:student']*/); //routa na hlavní stránku
$routes->get('practise_offer', 'Home::offerView'); //stránka pro nabídky praxe
$routes->get('people','Home::people'); //stránka pro zobrazení lidí z oauh
$routes->get('company','Home::companyView'); //stránka pro zobrazení firem
$routes->get('profile','Home::profileView'); //stránka pro zobrazení profilu
//ROUTY PRO BTN - SCRIPT
$routes->get('azure-users', 'UserAzureSync::getAllUsers'); //routa pro btn - pro script (načtení všech uživatelů z db - azure)
$routes->get('plus-graduationClass', 'UserAzureSync::updateClassYearGraduation'); //Routa pro přidání jednoho roku pro rok ukončení maturity "mělo by se to dělat jedenkrát za rok o prázninách, takže přes cron" !!! //!!Routa pro cron
//ROUTY PRO DASHBOARD
$routes->get('dashboard-home','Dashboard::homeView');
$routes->get('dashboard-calendar','Dashboard::deadlinesView');
$routes->get('dashboard-add-date','Dashboard::formDateView');
$routes->get('dashboard-people','Dashboard::peopleView');
$routes->get('dashboard-skill','Dashboard::skillView');
$routes->get('dashboard-company','Dashboard::companyView');
$routes->get('dashboard-log','Dashboard::logView');
//ZPRACOVÁNÍ (EDITACE) V DASHBOARDU
$routes->post('/sent-date-practise','Dashboard::addNewDate');
$routes->post('/sent-new-role-user','Dashboard::editUserRole');

//ROUTY PRO AUTH
$routes->get('logAD', 'Auth::loginOAUH'); //routa pro tlačítko pro přesměrování na login Microsoft office - OAUH      
$routes->get('logout','Auth::logOut'); //Odhlášení pro uživetele přihlášených přes microsoft office = OAUH uživatel
$routes->post('/registerCompany','Auth::registerCompany'); //Routa, která zpracovává první formulář při registraci firmy.
$routes->post('/confirmRegister','Auth::completionRegister'); //Routa, která zpracovává data drhého formuláře a zároveň data odesílá do db.
$routes->post('/loginCompany','Auth::loginCompany'); //Přihlašovací routa pro firmy.
$routes->get('/', 'Auth::callback'); // Routa pro zpracování údajů po přihlášení (Microsoft office - OAUH)   //!Změnit routu, ale je potřeba změnit v microsoft Azure zpětnou url
//ZKUŠEBNÍ ROUTY - PŘI VÝVOJI

