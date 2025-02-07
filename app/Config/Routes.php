<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// ROUTY PRO VIEWČKA (PŘIHLAŠOVACÍ & REGISTROVACÍ)
$routes->get('login', 'Home::login'); //Přihlašovácí stránka
$routes->get('registration', 'Home::registration'); //stránka pro registraci firmy
$routes->get('next-step-register','Auth::continuationRegister' );
$routes->get('reset-password', 'Auth::resetPassword');
// ROUTY PRO VIEWČKA
$routes->get('/home-student', 'Home::homeStudent', ['filter' => 'role:student']); //routa na hlavní stránku pro studenty
$routes->get('/home-company', 'Home::homeCompany', ['filter' => 'role:company']); //routa na hlavní stránku pro firmy
$routes->get('practise-offer', 'Home::offerView', ['filter' => 'role:student']); //stránka pro nabídky praxe
$routes->get('people','Home::people', ['filter' => 'role:student,teacher,company']); //stránka pro zobrazení lidí z oauh
$routes->get('company','Home::companyView', ['filter' => 'role:student,teacher']); //stránka pro zobrazení firem
$routes->get('profile','Home::profileView', ['filter' => 'role:student']); //stránka pro zobrazení profilu
$routes->get('profile/(:num)','Home::allProfileView/$1', ['filter' => 'role:student,teacher,company']);
$routes->get('company-profil', 'Home::companyProfilView', ['filter' => 'role:company']);
$routes->post('/add-offer-practise', 'Home::addNewOfferPractise', ['filter' => 'role:company,admin,spravce']);
$routes->get('company-add-offer-practise', 'Home::addNewOfferPractiseView', ['filter' => 'role:company,admin,spravce']);
$routes->get('company-profil/(:num)', 'Home::companyProfilAllView/$1', ['filter' => 'role:student,teacher,company']);
$routes->get('edit-company-profile/(:num)', 'Home::editCompanyProfilView/$1', ['filter' => 'role:admin,spravce,company']);
$routes->post('/edit-company-profile', 'Home::editCompanyProfil', ['filter' => 'role:admin,spravce,company']);
$routes->post('/profilAdd-practiseManager', 'Home::profilAddPractiseManager', ['filter' => 'role:admin,spravce,company']);
$routes->post('/profilEdit-practiseManager', 'Home::profilEditPractiseManager', ['filter' => 'role:admin,spravce,company']);
$routes->get('/profilDelete-practiseManager/(:num)', 'Home::profilDeletePractiseManager/$1', ['filter' => 'role:admin,spravce,company']);
$routes->get('edit-profile/(:num)','Home::editProfileView/$1', ['filter' => 'role:student,teacher']);
$routes->post('/edit-profile','Home::editProfile', ['filter' => 'role:student,teacher']);
$routes->get('company-offer-practises', 'Home::companyOfferPractiseView', ['filter' => 'role:company']);

$routes->post('/edit-like-offer', 'Home::editLikeOffer', ['filter', 'role:student']);
$routes->post('/edit-select-offer', 'Home::editSelectOffer', ['filter', 'role:student']);

//ROUTY PRO BTN - SCRIPT
$routes->get('azure-users', 'UserAzureSync::getAllUsers', ['filter' => 'role:admin, spravce']); //routa pro btn - pro script (načtení všech uživatelů z db - azure)
$routes->get('plus-graduationClass', 'UserAzureSync::upUsersClass', ['filter' => 'role:admin, spravce']); //Routa pro přidání jednoho roku pro rok ukončení maturity "mělo by se to dělat jedenkrát za rok o prázninách, takže přes cron" !!! //!!Routa pro cron
$routes->get('minus-graduationClass', 'UserAzureSync::downUsersClass', ['filter' => 'role:admin, spravce']);
//ROUTY PRO DASHBOARD
$routes->get('dashboard-home','Dashboard::homeView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-calendar','Dashboard::deadlinesView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-add-date','Dashboard::formDateView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-people','Dashboard::peopleView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-skill','Dashboard::skillView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-company','Dashboard::companyView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-log','Dashboard::logView', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-log-company','Dashboard::logViewCompany', ['filter' => 'role:admin,spravce']);
$routes->get('dashboard-class', 'Dashboard::viewClass', ['filter' => 'role:admin,spravce']);
//ZPRACOVÁNÍ (EDITACE) V DASHBOARDU
$routes->post('/sent-date-practise','Dashboard::addNewDate', ['filter' => 'role:admin,spravce']);
$routes->post('/edit-practise','Dashboard::editPractise', ['filter' => 'role:admin,spravce']);
$routes->post('/edit-date-practise','Dashboard::editDatePractise', ['filter' => 'role:admin,spravce']);
$routes->post('/add-next-date','Dashboard::addNextDate', ['filter' => 'role:admin,spravce']);
$routes->get('/delete-date-practise/(:num)','Dashboard::deleteDatePractise/$1', ['filter' => 'role:admin,spravce']);
$routes->get('/delete-practise/(:num)','Dashboard::deletePractise/$1', ['filter' => 'role:admin,spravce']);

$routes->post('/sent-new-role-user','Dashboard::editUserRole', ['filter' => 'role:admin,spravce']);
$routes->post('/add-new-category', 'Dashboard::addCategorySkill', ['filter' => 'role:admin,spravce']);
$routes->post('/add-new-skill', 'Dashboard::addSkill', ['filter' => 'role:admin,spravce']);
$routes->post('/edit-category', 'Dashboard::editCategorySkill', ['filter' => 'role:admin,spravce']);
$routes->post('/edit-skill', 'Dashboard::editSkill', ['filter' => 'role:admin,spravce']);
$routes->get('/delete-category-skill/(:num)', 'Dashboard::deleteCategorySkill/$1', ['filter' => 'role:admin,spravce']);//! Je potřeba udělat změna kvůli bezpečnosti, bude se muset přidat fetch přes javascript!! -- zatím provyzorně
$routes->get('/delete-skill/(:num)', 'Dashboard::deleteSkill/$1', ['filter' => 'role:admin,spravce']); //! Je potřeba udělat změna kvůli bezpečnosti, bude se muset přidat fetch přes javascript!! -- zatím provyzorně
$routes->post('/add-practiseManager', 'Dashboard::addPractiseManager' , ['filter' => 'role:admin,spravce']);
$routes->post('/edit-practiseManager', 'Dashboard::editPractiseManager', ['filter' => 'role:admin,spravce']);
$routes->post('/edit-representativeCompany', 'Dashboard::editRepresentativeCompany', ['filter' => 'role:admin,spravce']);
$routes->post('/add-representativeCompany', 'Dashboard::addRepresentativeCompany', ['filter' => 'role:admin,spravce']);
$routes->post('/edit-company', 'Dashboard::editCompany', ['filter' => 'role:admin,spravce']);
$routes->post('/add-new-company', 'Dashboard::addNewCompany', ['filter' => 'role:admin,spravce']);
$routes->post('/edit-user-password', 'Dashboard::editUserPassword', ['filter' => 'role:admin,spravce']);
$routes->get('/delete-company/(:num)', 'Dashboard::deleteCompany/$1', ['filter' => 'role:admin,spravce']);
$routes->get('/delete-representativeCompany/(:num)', 'Dashboard::deleteRepresentativeCompany/$1', ['filter' => 'role:admin,spravce']);
$routes->get('/delete-practiseManager/(:num)', 'Dashboard::deletePractiseManager/$1', ['filter' => 'role:admin,spravce']);
$routes->get('/delete-social-link/(:num)', 'Dashboard::deleteSocialLink/$1', ['filter' => 'role:admin,spravce']);
$routes->post('/new-social-link', 'Dashboard::newSocialLink', ['filter' => 'role:admin,spravce']);
$routes->post('/new-class-school', 'Dashboard::newClassSchool', ['filter' => 'role:admin,spravce']);
$routes->post('/new-type-school', 'Dashboard::newTypeSchool', ['filter' => 'role:admin,spravce']);
$routes->post('/new-field-school', 'Dashboard::newFieldSchool', ['filter' => 'role:admin,spravce']);
$routes->get('/delete-class/(:num)', 'Dashboard::deleteClass/$1', ['filter' => 'role:admin,spravce']);
$routes->get('/delete-field-study/(:num)', 'Dashboard::deleteFieldStudy/$1', ['filter' => 'role:admin,spravce']);
$routes->get('/delete-type-school/(:num)', 'Dashboard::deleteTypeSchool/$1', ['filter' => 'role:admin,spravce']);
$routes->post('/edit-class-school', 'Dashboard::editClassSchool', ['filter' => 'role:admin,spravce']);
$routes->post('/edit-type-school', 'Dashboard::editTypeSchool', ['filter' => 'role:admin,spravce']);
$routes->post('/edit-field-school', 'Dashboard::editFieldSchool', ['filter' => 'role:admin,spravce']);


//$routes->get('/postEmail', 'Dashboard::sentEmail');

//ROUTY PRO AUTH
$routes->get('logAD', 'Auth::loginOAUH'); //routa pro tlačítko pro přesměrování na login Microsoft office - OAUH      
$routes->get('logout','Auth::logOut', ['filter' => 'role:student,teacher']); //Odhlášení pro uživetele přihlášených přes microsoft office = OAUH uživatel
$routes->post('/registerCompany','Auth::registerCompany'); //Routa, která zpracovává první formulář při registraci firmy.
$routes->post('/confirmRegister','Auth::completionRegister'); //Routa, která zpracovává data drhého formuláře a zároveň data odesílá do db.
$routes->post('/loginCompany','Auth::loginCompany'); //Přihlašovací routa pro firmy.
$routes->get('/logOutCompany', 'Auth::logOutCompany', ['filter' => 'role:company']); //Odhlášení firmy. //! Je potřeba změnit odhlašování na metodu POST.
$routes->get('/', 'Auth::callback'); // Routa pro zpracování údajů po přihlášení (Microsoft office - OAUH)   //!Změnit routu, ale je potřeba změnit v microsoft Azure zpětnou url
$routes->post('/new-password', 'Auth::newPassword');
$routes->post('/forgot-password', 'Auth::forgotPassword');
//ZKUŠEBNÍ ROUTY - PŘI VÝVOJI
//$routes->get('sentMoreMails', 'Dashboard::sentMoreEmail');

