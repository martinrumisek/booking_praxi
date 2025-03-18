<?= $this->extend('layout/layout_nav') ?>

<?= $this->section('content') ?>
<style>
    .container-user{
        width: 100%;
        min-height: 500px;
        background: #f0f0f0 0% 0% no-repeat padding-box;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 0px 0px 70px 0px;
        opacity: 1;
    }
    .icon-user{
        width: 150px;
        height: 150px;
        border-radius: 150px;
        background-color: #FFFFFFD6;
        box-shadow: 0px 3px 6px #00000029;
    }

    .btn-container{
        width: 100%;
        min-height: 70px;
        background: #006DBC 0% 0% no-repeat padding-box;
        opacity: 1;
    }
    a{
        text-decoration: none;
        color: black;
    }
    .icon-company{
        width: 150px;
        height: 150px;
        border-radius: 150px;
        background-color: #FFFFFFD6;
        box-shadow: 0px 3px 6px #00000029;
    }
    .btn-document-export{
        background-color: white;
        width: 200px;
        height: 55px;
        border-radius: 20px;
    }
    .next-previously{
        width: 70px;
        height: 70px;
        border-radius: 70px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .card-offer{
        width: 320px;
        height: 300px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .small-text {
        font-size: 10px;
        background-color: #006DBC;
        color: white;
        padding: 3px;
        border-radius: 10px;
        width: 27%;
        margin-left: 10px;
        margin-bottom: 0px;
    }
    .card-icon-company{
        width: 50px;
        height: 50px;
        border-radius: 50px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .card-title{
        width: 70%;
        margin-left: 10px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        -webkit-line-clamp: 2;
    }
    .card-star{
        color: yellow;
    }
    .card-text{
        font-size: 13px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        -webkit-line-clamp: 2;
    }
    .text-praxe{
        font-size: 13px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        -webkit-line-clamp: 5;
    }
    .practise-card{
        width: 22rem;
        height: 140px;
        background-color: white;
        border-radius: 20px;
        box-shadow: 0px 3px 6px #00000029;
    }
    .btn-add-offer{
        padding: 10px;
        border-radius: 15px;
        box-shadow: 0px 3px 6px #00000029;
        border: 1px solid #006DBC;
        background-color: #006DBC;
        color: white;
    }
    .btn-add-offer:hover{
        background-color: white;
        color: black;
    }
    .card-people-offer-practise{
        width: 20rem;
        height: 100px;
        box-shadow: 0px 1px 3px #00000029;
        border-radius: 10px;
    }
    .text-user-practise{
        font-size: 12px;
    }
    .icon-show:hover{
        color: gray;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-6 p-0">
            <div class="container-user">
                <div class="p-5 container">
                    <div class="d-md-flex d-block">
                        <div class="d-flex justify-content-center align-items-center"><div class="icon-user d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h1"></i></div></div>
                        <div class="d-flex justify-content-center align-items-center p-0 m-4"><div><div class="h3"><?php if(!empty($user['representative_degree_before'])){echo $user['representative_degree_before'];} echo ' '; echo $user['representative_name'] . ' ' . $user['representative_surname']; if(!empty($user['representative_degree_after'])){echo $user['representative_degree_after'];}  ?></div><div><span class="text-wrap">Firma</span></div></div></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-md-6"><div class="h5 mt-2">E-mail</div><div class=""></div><?= $user['representative_mail'] ?></div>
                        <div class="col-12 col-md-6"><div class="h5 mt-2">Telefonní číslo</div><div class=""><?= $user['representative_phone'] ?></div></div>
                        <div class="col-12 col-md-6"><div class="h5 mt-2">Funkce</div><div class=""><?= $user['representative_function'] ?></div></div>
                    </div>
                    <div class="d-flex justify-content-center aling-items-center p-3"><div><a href="<?= base_url('/company-profil') ?>"><div>Zobrazit více</div><div class="d-flex justify-content-center"><i class="fa-solid fa-chevron-down"></i></div></a></div></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
                <div class="container-company">
                    <div class="p-5 container">
                        <div class="d-md-flex d-block">
                            <div class="d-flex justify-content-center align-items-center"><div class="icon-company d-flex align-items-center justify-content-center"><i class="fa-solid fa-building h1"></i></div></div>
                             <div class="d-flex justify-content-center align-items-center p-0 m-4"><div><div class="h4">Název firmy/instituce</div><span><?= $company['company_name'] ?></span><br><span class="fw-bold">IČO: </span><span><?= $company['company_ico'] ?></span></div></div>
                        </div>
                        <div class="row">
                            <div class="col-12"><div class="h5 mt-2">Lokalita</div><div class=""><?= $company['company_post_code'] . ' ' . $company['company_city'] . ', ' . $company['company_street'] ?></div></div>
                            <div class="col-12"><div class="h5 mt-2">Právní forma</div><div class=""><?php if($company['company_subject'] == 1){echo 'Fyzická osoba';} if($company['company_subject'] == 2){echo 'Pravnická osoba';} ?></div></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="btn-container d-flex flex-wrap justify-content-center align-items-center"><div class="btn-document-export d-flex flex-column justify-content-center align-items-center p-2 m-1"><div class="fw-bold">Počet žáků</div><div><?= $count['userStudent'] ?></div></div><div class="btn-document-export d-flex flex-column justify-content-center align-items-center p-2 m-1"><div class="fw-bold">Počet termínů praxí</div><div><?= $count['practise'] ?></div></div><div class="btn-document-export d-flex flex-column justify-content-center align-items-center p-2 m-1"><div class="fw-bold">Registrované firmy</div><div><?= $count['companyCount'] ?></div></div></div>
<div class="d-flex flex-column align-items-center justify-content-center mt-2">
    <?php if(!empty($selectStudents)){ ?><h3>Přehled žádostí žáků</h3><?php }?>
    <div class="d-flex flex-wrap">
    <?php if(!empty($selectStudents)){ foreach($selectStudents as $user){ ?>
        <div class="card-people-offer-practise d-flex flex-column m-1">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                        <i class="fa-solid fa-user p-2 h5 m-0"></i>
                        <p class=" m-0 h6"><?= $user['user_name'] . ' ' . $user['user_surname'] ?></p>
                        </div>
                        <a class="icon-show" href="<?= base_url('profile/'.$user['user_id']) ?>"><i class="fa-solid fa-eye p-1"></i></a>
                    </div>
                    <div class="d-flex">
                        <p class="m-0 text-user-practise p-1">Třida: <?= $user['class_class'] . '.' . $user['class_letter_class'] ?></p>
                        <p class="m-0 text-user-practise p-1">Obor: <?= $user['field_name'] ?></p>
                    </div>
                    <div class="d-flex">
                        <p class="m-0 text-user-practise p-1 fw-bold">Název praxe: <?= $user['offer_name'] ?></p>
                    </div>
                </div>
    <?php }}?>
    </div>
    <?php if(!empty($selectStudents)){ ?> <div class="d-flex justify-content-center mt-2"><a class="btn-add-offer" href="<?= base_url('/company-offer-practises')?>">Zobrazit žádosti</a></div><?php }?>
</div>

<div class="d-flex justify-content-center flex-column align-items-center mt-2">
<?php if(!empty($actualPractises)){ ?><h3>Probíhající praxe</h3><?php }?>
<div class="d-flex flex-wrap">
<?php if(!empty($actualPractises)){ foreach($actualPractises as $actual){ ?>
    <div class="card-offer d-flex flex-column m-3">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-center align-items-center m-2">
                    <div class="card-icon-company d-flex justify-content-center align-items-center"><i class="fa-solid fa-user"></i></div>
                    <div class="d-flex flex-column" style="width: 80%;">
                    <p class="small-text text-center">Přijatý žák</p>
                    <p class="card-title fw-bold"><?= $actual['user_name'] . ' ' . $actual['user_surname'] ?></p>
                    </div>
                </div>
                <p class="card-text d-flex justify-content-center align-items-center m-1 fw-bold"><?= $actual['offer_name'] ?></p>
                <div class="d-flex">
                    <i class="fa-regular fa-calendar h5 m-3 mb-0 mt-0"></i>
                    <p class="card-text d-flex justify-content-center align-items-center"><?= date('d.m.Y', strtotime($actual['date_date_from'])) . ' - ' . date('d.m.Y', strtotime($actual['date_date_to']));?></p>
                </div>
                <div class="d-flex align-items-center mt-2">
                    <i class="fa-solid fa-location-dot h5 m-3 mb-0 mt-0"></i>
                    <p class="card-text d-flex justify-content-center align-items-center"><?= $actual['offer_street'] . ', ' . $actual['offer_post_code'] . '  ' . $actual['offer_city'] ?></p>
                </div>
                <div class="d-flex align-items-center mt-2">
                    <i class="fa-solid fa-user h5 m-3 mb-0 mt-0"></i>
                    <p class="card-text d-flex justify-content-center align-items-center"><?php if(!empty($actual['manager_degree_before'])){echo $actual['manager_degree_before'];} echo ' ' . $actual['manager_name'] . ' ' . $actual['manager_surname'] . ' '; if(!empty($actual['manager_degree_after'])){echo $actual['manager_degree_after'];} ?></p>
                </div>
                <div class="d-flex align-items-center mt-2">
                    <i class="fa-solid fa-envelope h5 m-3 mb-0 mt-0"></i>
                    <p class="card-text d-flex justify-content-center align-items-center"><?= $actual['manager_mail'] ?></p>
                </div>
                <div class="d-flex align-items-center mt-2">
                    <i class="fa-solid fa-phone h5 m-3 mb-0 mt-0"></i>
                    <p class="card-text d-flex justify-content-center align-items-center"><?= $actual['manager_phone'] ?></p>
                </div>
            </div>
        </div>
<?php }}?>
</div>
</div>
<div class="d-flex flex-column align-items-center justify-content-center mt-2">
<?php if(!empty($newPractises)){ ?><h3>Nové termíny praxí</h3><?php }?>
<div class="d-flex flex-wrap">
<?php if(!empty($newPractises)){ foreach($newPractises as $practise){ ?>
    <div class="m-2 practise-card d-flex flex-column align-items-center justify-content-center" >
        <div class="text-center fw-bold"><?= $practise['practise_name'] ?></div>
        <div class="d-flex">
        <i class="fa-solid fa-calendar-days p-1 d-flex align-items-center"></i>
        <div class="p-1 d-flex align-items-center"><?php $count = count($practise['dates']); foreach($practise['dates'] as $date){echo date('d.m.Y', strtotime($date['date_date_from'])) . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])); if($count > 1){echo ' / '; $count--;}} ?></div>
        </div>
    </div>
<?php }}?>
</div>
<?php if(!empty($newPractises)){ ?><div class="d-flex justify-content-center mt-2"><a class=" btn-add-offer" href="<?= base_url('/company-add-offer-practise') ?>">Přidat novou nabídku</a></div><?php }?>
</div>
<br>

<!---
 'selectStudents' => $selectStudent,
            'newPractises' => $newPractises,
            'actualPractises' => $actualPractises,
--->
<?= $this->endSection() ?>