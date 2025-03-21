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
        height: 340px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
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
    input.checkbox{
      background-color: transparent;
      box-shadow: none;
      height: auto;
      cursor:pointer;
    }
    input{
      border: none;
      height: 40px;
      padding: 8px;
      border-radius: 10px;
      background-color: white;
      box-shadow: 0px 3px 6px #00000029;
    }
    input:focus{
        border:1px solid #006DBC;
        outline: none;
    }
    select{
        border:none;
        max-width: 250px;
        height: 40px;
        padding: 8px;
        border-radius: 10px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    select:focus{
        border: 1px solid #006DBC;
        outline: none;
    }
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
    -moz-appearance: textfield;
    }
    textarea{
      resize: none;
      overflow: auto;
      border-radius: 10px;
      background-color: white;
      border: none;
      box-shadow: 0px 3px 6px #00000029;
      padding: 8px;
    }
    textarea:focus{
        border:1px solid #006DBC;
        outline: none;
    }
    textarea.name-practise-offer{
        width: 80%;
        height: 100px
    }
    textarea.short-description-offer{
        width: 100%;
        height: 200px;
    }
    textarea.full-description{
        width: 100%;
        min-height: 100%;
    }
    input.checkbox{
      background-color: transparent;
      box-shadow: none;
      height: auto;
    }
    .blue-line{
        width: 100%;
        height: 2px;
        background-color: #006DBC
    }
    .view-contract-file{
        padding: 4px;
        box-shadow: 0px 3px 6px #00000029;
        background-color: white;
        border-radius: 10px;
    }
    .view-contract-file:hover{
        background-color: #006DBC;
        color: white;
    }
    .btn-right-display-submit{
        position: fixed;
        bottom: 55px;
        right: 20px;
        z-index: 1;
        padding: 10px 20px;
        background-color: #006DBC; 
        box-shadow: 0px 3px 6px #00000029;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 16px;
    }
    .btn-right-display-submit:hover{
        color: #006DBC;
        background-color: white;
        border: 1px solid #006DBC;
    }
    .short-description{
        height: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .card-date{
        width: 85%;
        box-shadow: 0px 3px 6px #00000029;
        padding: 10px;
        border-radius: 15px;
        border: 1px solid #006DBC;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-6 p-0">
            <div class="container-user">
                <div class="p-4 container">
                    <div class="d-md-flex d-block">
                        <div class="d-flex justify-content-center align-items-center m-2"><div class="icon-user d-flex align-items-center justify-content-center"><i class="fa-solid fa-briefcase h1"></i></div></div>
                        <div class="d-flex justify-content-center align-items-center p-0" style="width: 100%;"><h4><?= $offer['offer_name']?></h4></div>
                    </div>
                    <div class="container mt-3 d-flex flex-column">
                        <?php if(!empty($offer['offer_requirements'])){ ?>
                            <span class="fw-bold">Krátky popis praxe</span>
                            <p class="short-description"><?= $offer['offer_requirements'] ?></p>
                        <?php }else{ ?>
                            <span class="fw-bold">Dovednosti pro praxi</span>
                            <?php if(!empty($skills)){ ?>
                                <p class="short-description"><?php foreach($skills as $category){ foreach($category['skills'] as $skill){echo $skill['skill_name'] . ', ';}} ?></p>
                            <?php }else{ ?>
                                <p class="short-description">Nejsou uvedeny žádné dovednosti pro praxi.</p>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
                <div class="container-company">
                    <div class="p-4 container">
                        <div class="d-md-flex d-block">
                            <div class="d-flex justify-content-center align-items-center"><div class="icon-company d-flex align-items-center justify-content-center"><i class="fa-solid fa-building h1"></i></div></div>
                             <div class="d-flex justify-content-center align-items-center p-0 m-4"><div><div class="h4">Název firmy/instituce</div><span><?= $offer['company_name'] ?></span><br><span class="fw-bold">IČO: </span><span><?= $offer['company_ico'] ?></span></div></div>
                        </div>
                        <div class="d-flex flex-wrap" style="width:100%">
                        <div class="d-flex flex-column" style="min-width: 50%;">
                            <h5 class="mt-2">Lokace praxe</h5>
                            <span class="fw-bold">Město/vesnice</span>
                            <p><?= $offer['offer_city'] ?></p>
                            <span class="fw-bold">Ulice</span>
                            <p><?= $offer['offer_street'] ?></p>
                            <span class="fw-bold">PSČ</span>
                            <p><?= $offer['offer_post_code'] ?></p>
                        </div>
                        <div class="d-flex flex-column"style="min-width: 50%;">
                            <h5 class="mt-2">Vedoucí praxe</h5>
                            <span class="fw-bold">Jméno a příjmení</span>
                            <p><?php if(!empty($offer['manager_degree_before'])){echo $offer['manager_degree_before'];} echo ' ' . $offer['manager_name'] . ' ' . $offer['manager_surname'] . ' '; if(!empty($offer['manager_degree_after'])){echo $offer['manager_degree_after'];}?></p>
                            <span class="fw-bold">E-mail</span>
                            <p><?= $offer['manager_mail'] ?></p>
                            <span class="fw-bold">Telefonní číslo</span>
                            <p><?= $offer['manager_phone'] ?></p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="container-fluid mt-2">
<div class="row">
<?php
$countDateText = count($dates);
$countSkillText = count($skills);
if($countDateText == 1){
    $dateText = 'Termín praxe';
}else{
    $dateText = 'Termíny praxí';
}
if($countSkillText <= 1){
    $skillText = 'Dovednost pro praxi';
}else{
    $skillText = 'Dovednosti pro praxi';
}
?>
    <div class="col-12 col-md-4">
        <h4 class="text-center mt-2"><?= $dateText ?></h4>
        <div class="m-2 d-flex justify-content-center align-items-center">
            <div class="card-date">
                <div class="d-flex justify-content-center"><i class="fa-regular fa-calendar h3 m-2"></i></div>
                <h6 class="text-center"><?= $offer['practise_name'] ?></h6>
                <div>
                    <span class="fw-bold">Pro třídy:</span> <?php foreach($classes as $class){ echo $class['class_class'] . '.' . $class['class_letter_class'] . ' (' . $class['field_shortcut'] . '), '; } ?>
                </div>
                <div>
                    <?php $countDate = 1; foreach($dates as $date){echo '<span class="fw-bold">Termín ' . $countDate . ': </span>' .  date('d.m.Y', strtotime($date['date_date_from']))  . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])) . '<br>'; $countDate++;} ?>
                </div>
            </div>
        </div>
        <?php if(!empty($offer['offer_requirements'])){ ?>
        <h4 class="text-center mt-4"><?= $skillText ?></h4>
        <?php if(!empty($skills)){ foreach($skills as $category){ ?>
        <div class="h5 fw-bold"><?= $category['category_name'] ?></div>
        <div class="m-1">
            <ul>
            <?php foreach($category['skills'] as $skill){ ?>
                <li><?= $skill['skill_name'] ?></li>
            <?php } ?>
            </ul>
        </div>
        <?php }}else{ echo 'Není uvedena žádná dovednost';}} ?>
    </div>
    <div class="col-12 col-md-8">
        <h4 class="mt-2">Popis praxe</h4>
        <div class="container" style="height: 100%;">
            <?php if(empty($offer['offer_description'])){echo 'Není uveden žádný popis praxe';} ?><?= $offer['offer_description'] ?>
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>