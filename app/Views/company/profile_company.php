<?= $this->extend('layout/layout_nav') ?>

<?= $this->section('content') ?>
<style>
    .container-profil{
        width: 100%;
        height: 550px;
        background: #006DBC 0% 0% no-repeat padding-box;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 0px 0px 150px 0px;
        opacity: 1;
    }
    .profile-icon{
        width: 200px;
        height: 200px;
        border-radius: 200px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        margin-top: 15px;
    }
    .profile-name{
        margin-right: 20%;
    }
    .soc-icon{
        height: 27%;
        margin-right: 20%;
    }
    .circle-icon{
        width: 50px;
        height: 50px;
        border-radius: 50px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .circle-icon:hover{
        border: 1px solid black;
    }
    .custom-line{
        height: 7px;
        width: 100%;
        border: none;
        background-color: #006DBC;
        opacity: 1;
        margin-top: 0;
    }
    .card{
        border: none;
        height: 350px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .profile-text{
        width: 100%;
        height: auto;
        padding: 30px;
        border: none;
        border-radius: 30px;
        background-color: white;
        box-shadow:0px 3px 6px #00000029;
    }
    .btn-repair{
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        padding: 14px;
    }
    .btn-repair:hover{
        color:white;
        background-color: #006DBC;
    }
    .edit-profil-company{
        padding: 8px;
        color: white;
        border: 1px solid white;
        border-radius: 10px;
    }
    .edit-profil-company:hover{
        background-color: white;
        color: #006DBC;
        box-shadow: 0px 3px 6px #00000029;
    }
    .card-people{
        width: 280px;
        height: 280px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        border: 1px solid #006DBC;
    }
    .card-icon-people{
        width: 70px;
        height: 70px;
        border-radius: 70px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    
</style>
<?php 
 $role = session()->get('role');
 $userSession = session()->get('user');
 $companySession = session()->get('companyUser');
 $isStudent = in_array('student', $role);
 $isCompany = in_array('company', $role);
 $isAdmin = in_array('admin', $role);
 $isSpravce = in_array('spravce', $role);
 if($isStudent){
     $userId = $userSession['id'];

 }
 if($isCompany){
     $userId = $companySession['idCompany'];
 }
?>
<div class="container-fluid row p-0 m-0">
    <div class="col-12 col-lg-5 p-0">
        <div class="container-profil">
            <div class="d-flex justify-content-center">
                <div class="profile-icon d-flex justify-content-center align-items-center m-0 mt-3"><i class="fa-solid fa-building h1"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-3 profile-name m-3"><h2 class="text-white text-center"><?= $company['company_name'] ?></h2></div>
            <div class="d-flex justify-content-center mt-3 profile-name"><h3 class="text-white"></h3></div>
            <?php if($isAdmin || $isSpravce){ ?>
            <div class="d-flex align-item-end justify-content-center"><a class="edit-profil-company" href="<?= base_url('/edit-company-profile/'. $company['company_id']) ?>">Upravit profil</a></div>
            <?php } ?>
            <?php if($isCompany){if($userId == $company['company_id']) ?>
            <div class="d-flex align-item-end justify-content-center"><a class="edit-profil-company" href="<?= base_url('/edit-company-profile/'. $company['company_id']) ?>">Upravit profil</a></div>
            <?php } ?>
        </div>
    </div>
    <div class="col-12 col-lg-7 d-flex align-items-center p-5">
        <div class="container">
            <h2>Kontaktní údaje</h2>
            <div class="row">
                <div class="col-12 col-lg-6 p-2">
                    <h5>Jméno a příjmení</h5>
                    <p><?= $contact['representative_degree_before'] . ' ' . $contact['representative_name'] . ' ' . $contact['representative_surname'] . ' ' . $contact['representative_degree_after'] ?></p>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <h5>E-mail</h5>
                    <p><?= $contact['representative_mail'] ?></p>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <h5>Telefonní číslo</h5>
                    <p><?= $contact['representative_phone'] ?></p>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <h5>IČO</h5>
                    <p><?= $company['company_ico'] ?></p>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <h5>Sídlo firmy</h5>
                    <p><?= $company['company_post_code'] . '  ' . $company['company_city']. ', ' . $company['company_street'] ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="m-4 d-flex justify-content-center"><h2>O nás</h2></div>
<div class="container profile-text">
    <?php if(empty($company['company_description'])){ ?>
        <div class="text-center mt-2 fw-bold">ŽÁDNÝ POPIS FIRMY</div>
    <?php }else{?>
        <div><?= $company['company_description'] ?></div>
    <?php } ?>
</div>
<div class="m-4 d-flex justify-content-center"><h2>Zástupci firmy</h2></div>
<div class="d-flex flex-wrap justify-content-center">
        <!-- Začátek karty -->
         <?php foreach($representatives as $user){ ?>
            <div class="card-people m-4">
            <div class="d-flex mt-2 justify-content-center">
                <div class="card-icon-people d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h4"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-1"><p class="fw-bold h5"> <?= $user['representative_degree_before'] . ' ' . $user['representative_name'] . ' ' . $user['representative_surname'] . ' ' . $user['representative_degree_after'] ?> </p></div>
            <div class="d-flex flex-column m-2 p-2">
                <div class="d-flex flex-column">
                    <p class="fw-bold m-0">E-mail:</p>
                    <p class="p-1 m-0"> <?= $user['representative_mail'] ?> </p>
                </div>
                <div class="d-flex flex-column">
                    <p class="fw-bold m-0">Tel. číslo:</p>
                    <p class="p-1 m-0"> <?= $user['representative_phone'] ?> </p>
                </div>
            </div>
        </div>
        <?php } ?>
       
        <!-- Konec karty -->
</div>
<div class="m-4 d-flex justify-content-center"><h2>Vedoucí praxí</h2></div>
<div class="d-flex flex-wrap justify-content-center">
        <!-- Začátek karty -->
         <?php if(empty($managers)){ ?>
        <div class="card-people m-4">
            <div class="d-flex justify-content-center align-items-center">
                <div class="fw-bold">ŽÁDNÝ VEDOUCÍ PRAXE</div>
            </div>    
        </div>
         <?php } ?>
         <?php foreach($managers as $user){ ?>
            <div class="card-people m-4">
            <div class="d-flex mt-2 justify-content-center">
                <div class="card-icon-people d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h4"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-1"><p class="fw-bold h5"> <?= $user['manager_degree_before'] . ' ' . $user['manager_name'] . ' ' . $user['manager_surname'] . ' ' . $user['manager_degree_after'] ?> </p></div>
            <div class="d-flex flex-column m-2 p-2">
                <div class="d-flex flex-column">
                    <p class="fw-bold m-0">E-mail:</p>
                    <p class="p-1 m-0"> <?= $user['manager_mail'] ?> </p>
                </div>
                <div class="d-flex flex-column">
                    <p class="fw-bold m-0">Tel. číslo:</p>
                    <p class="p-1 m-0"> <?= $user['manager_phone'] ?> </p>
                </div>
            </div>
        </div>
        <?php } ?>
       
        <!-- Konec karty -->
</div>
<?= $this->endSection() ?>