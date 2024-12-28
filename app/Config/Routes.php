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
$routes->get('/home-student', 'Home::index', ['filter' => 'role:student']); //routa na hlavní stránku
$routes->get('practise_offer', 'Home::offerView'); //stránka pro nabídky praxe
$routes->get('people','Home::people'); //stránka pro zobrazení lidí z oauh
$routes->get('company','Home::companyView'); //stránka pro zobrazení firem
$routes->get('profile','Home::profileView'); //stránka pro zobrazení profilu
//ROUTY PRO BTN - SCRIPT
$routes->get('azure-users', 'UserAzureSync::getAllUsers'); //routa pro btn - pro script (načtení všech uživatelů z db - azure)
$routes->get('plus-graduationClass', 'UserAzureSync::updateClassYearGraduation'); //Routa pro přidání jednoho roku pro rok ukončení maturity "mělo by se to dělat jedenkrát za rok o prázninách, takže přes cron" !!! //!!Routa pro cron
//ROUTY PRO DASHBOARD
$routes->get('dashboard-home','Dashboard::homeView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-calendar','Dashboard::deadlinesView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-add-date','Dashboard::formDateView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-people','Dashboard::peopleView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-skill','Dashboard::skillView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-company','Dashboard::companyView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-log','Dashboard::logView', ['filter' => 'role:admin,spravce']);
//ZPRACOVÁNÍ (EDITACE) V DASHBOARDU
$routes->post('/sent-date-practise','Dashboard::addNewDate', ['filter' => 'role:admin,spravce']);
$routes->post('/sent-new-role-user','Dashboard::editUserRole', ['filter' => 'role:admin,spravce']);
$routes->post('/add-new-category', 'Dashboard::addCategorySkill', ['filter' => 'role:admin,spravce']);
$routes->post('/add-new-skill', 'Dashboard::addSkill', ['filter' => 'role:admin,spravce']);
$routes->get('/delete-category-skill/(:num)', 'Dashboard::deleteCategorySkill/$1', ['filter' => 'role:admin,spravce']);//! Je potřeba udělat změna kvůli bezpečnosti, bude se muset přidat fetch přes javascript!! -- zatím provyzorně
$routes->get('/delete-skill/(:num)', 'Dashboard::deleteSkill/$1', ['filter' => 'role:admin,spravce']); //! Je potřeba udělat změna kvůli bezpečnosti, bude se muset přidat fetch přes javascript!! -- zatím provyzorně

//ROUTY PRO AUTH
$routes->get('logAD', 'Auth::loginOAUH'); //routa pro tlačítko pro přesměrování na login Microsoft office - OAUH      
$routes->get('logout','Auth::logOut', ['filter' => 'role:student,teacher']); //Odhlášení pro uživetele přihlášených přes microsoft office = OAUH uživatel
$routes->post('/registerCompany','Auth::registerCompany'); //Routa, která zpracovává první formulář při registraci firmy.
$routes->post('/confirmRegister','Auth::completionRegister'); //Routa, která zpracovává data drhého formuláře a zároveň data odesílá do db.
$routes->post('/loginCompany','Auth::loginCompany'); //Přihlašovací routa pro firmy.
$routes->get('/logOutCompany', 'Auth::logOutCompany', ['filter' => 'role:company']); //Odhlášení firmy. //! Je potřeba změnit odhlašování na metodu POST.
$routes->get('/', 'Auth::callback'); // Routa pro zpracování údajů po přihlášení (Microsoft office - OAUH)   //!Změnit routu, ale je potřeba změnit v microsoft Azure zpětnou url
//ZKUŠEBNÍ ROUTY - PŘI VÝVOJI

