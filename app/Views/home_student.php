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
        height: 70px;
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
        position: relative;
        width: 320px;
        height: 340px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .card-selected-label {
        position: absolute;
        top: -14px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #006DBC;
        color: white;
        font-weight: bold;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.7rem;
        white-space: nowrap;
    }
    .card-accepted-label {
        position: absolute;
        top: -14px;
        left: 50%;
        transform: translateX(-50%);
        background-color: green;
        color: white;
        font-weight: bold;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.7rem;
        white-space: nowrap;
    }
    .card-offer-select{
        border: 1px solid #006DBC;
    }
    .card-offer-no-accepted{
        border: 1px solid red;
    }
    .card-offer-accepted{
        border: 1px solid green;
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
    .card-star-active{
        color: yellow;
    }
    .card-star-active:hover{
        color:black;
    }
    .card-star-deactive{
        color:black;
    }
    .card-star-deactive:hover{
        color: #f2e394;
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
    .check-active{
        color: black;
    }
    .check-active:hover{
        color:green;
    }
    .xmark-active{
        color: black;
    }
    .xmark-active:hover{
        color: red;
    }
    .btn-show-offer{
        padding: 5px;
        margin: 5px;
        margin-bottom: 10px;
        border: 0.5px solid #006DBC;
        border-radius: 15px;
    }
    .btn-show-offer:hover{
        background-color: #006DBC;
        color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .container-no-offer{
        padding: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }.card-offer{
        position: relative;
        width: 320px;
        height: 340px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .card-selected-label {
        position: absolute;
        top: -14px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #006DBC;
        color: white;
        font-weight: bold;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.7rem;
        white-space: nowrap;
    }
    .card-accepted-label {
        position: absolute;
        top: -14px;
        left: 50%;
        transform: translateX(-50%);
        background-color: green;
        color: white;
        font-weight: bold;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.7rem;
        white-space: nowrap;
    }
    .card-offer-select{
        border: 1px solid #006DBC;
    }
    .card-offer-no-accepted{
        border: 1px solid red;
    }
    .card-offer-accepted{
        border: 1px solid green;
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
    .card-star-active{
        color: yellow;
    }
    .card-star-active:hover{
        color:black;
    }
    .card-star-deactive{
        color:black;
    }
    .card-star-deactive:hover{
        color: #f2e394;
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
    .check-active{
        color: black;
    }
    .check-active:hover{
        color:green;
    }
    .xmark-active{
        color: black;
    }
    .xmark-active:hover{
        color: red;
    }
    .btn-show-offer{
        padding: 5px;
        margin: 5px;
        margin-bottom: 10px;
        border: 0.5px solid #006DBC;
        border-radius: 15px;
    }
    .btn-show-offer:hover{
        background-color: #006DBC;
        color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .container-no-offer{
        padding: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .container-no-practise{
        padding: 15px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .calendar-icon{
        padding: 50px;
        border-radius: 135px 140px;
        box-shadow: 0px 3px 6px #00000029;
    }
    .show-profile-main-menu:hover{
        color: #006DBC;
    }
    .practise-btn{
        padding: 8px;
        border-radius: 10px;
        box-shadow: 0px 3px 6px #00000029;
    }
    .practise-btn:hover{
        background-color: #006DBC;
        color: white;
    }
    .modal-header{
      background-color: #006DBC;
      color: white;
      box-shadow: 0px 3px 6px #00000029;
    }
    .modal-footer{
      background-color: white;
      color: white;
      box-shadow: 0px 3px 6px #00000029;
      border-top: 1px solid #006DBC;
    }
    .btn-close-modal{
      background-color: #006DBC;
      color: white;
      border: none;
      border-radius: 100%;
    }
    .btn-close-modal:hover{
      color: red;
    }
</style>
<?php 
$role = session()->get('role');
if(in_array('admin', $role)){
    $viewRole = "admin";
}else if(in_array('spravce', $role)){
    $viewRole = "správce";
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-6 p-0">
            <div class="container-user">
                <div class="p-4 container d-flex flex-column" style="min-height: 500px;">
                    <div class="d-md-flex d-block">
                        <div class="d-flex justify-content-center align-items-center"><div class="icon-user d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h1"></i></div></div>
                        <div class="d-flex justify-content-center align-items-center p-0 m-4"><div><div class="h3"><?= $user['user_name'] . ' ' . $user['user_surname']. ', ' . $user['class_class'] . '.' . $user['class_letter_class'] ?></div><div><span class="text-wrap">Žák<?php if(!empty($viewRole)){ echo ' , ' . $viewRole;} ?></span></div></div></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-md-6"><div class="h5 mt-2">Obor</div><div class=""><?= $user['field_name'] ?></div></div>
                        <div class="col-12 col-md-6"><div class="h5 mt-2">Telefonní číslo</div><div class=""><?php if(empty($user['user_phone'])){echo "Není uvedeno";}else{echo $user['user_phone'];} ?></div></div>
                        <div class="col-12 col-md-6"><div class="h5 mt-2">E-mail</div><div class=""><?= $user['user_mail'] ?></div></div>
                    </div>
                    <div class="d-flex justify-content-center mt-auto p-3 "><div><a class="show-profile-main-menu" href="<?= base_url('/profile') ?>"><div>Zobrazit více</div><div class="d-flex justify-content-center"><i class="fa-solid fa-chevron-down"></i></div></a></div></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
                <div class="container-company" style="height: 100%;">
                    <div class="p-5 container d-flex flex-column" style="height: 100%;">
                        <?php if(!empty($practise) && $practise['user_offer_accepted'] == 1){ ?>
                        <div class="d-md-flex d-block">
                            <div class="d-flex justify-content-center align-items-center"><div class="icon-company d-flex align-items-center justify-content-center"><i class="fa-solid fa-building h1"></i></div></div>
                             <div class="d-flex justify-content-center align-items-center p-0 m-4"><div><div class="h4">Název firmy/instituce</div><span><?= $practise['company_name'] ?></span><br><span class="fw-bold">IČO: </span><span><?= $practise['company_ico'] ?></span></div></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6"><div class="h6 mt-2">Název praxe</div><div class=""><?= $practise['offer_name'] ?></div></div>
                            <div class="col-12 col-md-6"><div class="h6 mt-2">Místo praxe</div><div class=""><?= $practise['offer_post_code'] . '  ' . $practise['offer_city'] . ', ' .  $practise['offer_street'] ?></div></div>
                            <div class="col-12 col-md-6"><div class="h6 mt-2">Vedoucí praxe</div><div class=""><?php if(!empty($practise['manager_degree_before'])){echo $practise['manager_degree_before'];} echo ' ' . $practise['manager_name'] . ' ' . $practise['manager_surname'] . ' '; if(!empty($practise['manager_degree_after'])){echo $practise['manager_degree_after'];} ?></div></div>
                            <div class="col-12 col-md-6"><div class="h6 mt-2">E-mail na vedoucí</div><div class=""><?= $practise['manager_mail'] ?></div></div>
                            <?php $count = 1; foreach($dates as $date){ ?>
                                <div class="col-12 col-md-6"><div class="h6 mt-2">Termín <?= $count ?></div><div class=""><?= date('d.m.Y', strtotime($date['date_date_from'])) . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])) ?></div></div>
                            <?php $count++; } ?>
                        </div>
                        <?php }else{if(!empty($practiseDate)){ ?>
                            <div class="d-flex justify-content-center"><i class="fa-regular fa-calendar h1 calendar-icon"></i></div>
                            <div class="d-flex justify-content-center h4"><?= $practiseDate['practise_name'] ?></div>
                            <div class="row mt-2">
                                <?php $countDate = 1; foreach($dates as $date){ ?>
                                    <div class="col-3 fw-bold">Termín <?= $countDate ?></div>
                                    <div class="col-9"><?= date('d.m.Y', strtotime($date['date_date_from'])) . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])) ?></div>
                                <?php $countDate++; } ?>
                            </div>
                            <div class="d-flex flex-wrap mt-auto align-items-end mt-auto justify-content-center">
                                <a class="m-2 practise-btn" data-bs-toggle="modal" data-bs-target="#modalShowInformationPractise" href="">Zobrazit informace</a>
                                <a class="m-2 practise-btn" href="<?= base_url('/practise-offer')?>">Vybrat praxi</a>
                                <a class="m-2 practise-btn" data-bs-toggle="modal" data-bs-target="#modalWriteMyPractise" href="">Zapsat praxi</a>
                            </div>
                       <?php }else{ ?>
                            <!--- Když není zařazen do termínu praxe -->
                            <div class="d-flex align-items-center justify-content-center" style="height: 100%;">
                                <div class="container-no-practise fw-bold">Nemáš žádný termín pro praxi</div>
                            </div>  
                      <?php }}?>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="btn-container d-flex justify-content-center align-items-center"><?php if(!empty($practise) && $practise['user_offer_accepted'] == 1){ ?><a href="" class="btn-document-export d-flex justify-content-center align-items-center p-2 disabled"><i class="fa-solid fa-file p-2"></i> Smlouva k praxi</a> <?php } ?></div>
<?php if(!empty($userOffers)){ ?><div class="d-flex justify-content-center mt-2"><h3>Oblíbené/vybrané nabídky</h3></div><?php } ?>
<div class="d-flex flex-wrap justify-content-center">
<?php 
if(!empty($userOffers)){
        foreach($userOffers as $offer){ ?>
            <div class="card-offer d-flex flex-column <?php if($offer['user_offer_select'] == 1){if($offer['user_offer_accepted'] == 0 && $offer['user_offer_accepted'] !== null){echo 'card-offer-no-accepted';}elseif($offer['user_offer_accepted'] == 1 && $offer['user_offer_accepted'] !== null){echo 'card-offer-accepted';}else{echo 'card-offer-select';}} ?> m-3">
            <?php if($offer['user_offer_select'] == 1){
                if($offer['user_offer_accepted'] == 1){?>
                    <div class="card-accepted-label">Potvrzené</div>
                <?php }else{ ?>
                    <div class="card-selected-label">Vybrané</div>
            <?php }} ?>
            <div class="d-flex flex-column">
                <div class="d-flex m-2">
                    <div class="card-icon-company d-flex justify-content-center align-items-center"><i class="fa-solid fa-building"></i></div>
                    <p class="card-title fw-bold"><?= $offer['company_name'] ?></p>
                    <?php if($offer['user_offer_accepted'] !== 1){ ?>
                    <div class="d-flex flex-column justify-content-center">
                        <form id="form-like-<?= $offer['offer_id'] ?>" action="<?= base_url('/edit-like-offer') ?>" method="POST">
                        <input type="hidden" name="id-offer" value="<?= $offer['offer_id'] ?>">
                        <input type="hidden" name="like-offer" value="<?= $offer['user_offer_like'] ?>">
                        </form>
                        <a class="d-flex justify-content-center" href="#" onclick="document.getElementById('form-like-<?= $offer['offer_id']?>').submit(); return false;"><i class="fa-solid fa-star <?php if($offer['user_offer_like'] == 0 || empty($offer['user_offer_like'])){echo 'card-star-deactive';}else{echo 'card-star-active';} ?> p-1"></i></a>
                        <form id="form-select-<?= $offer['offer_id']?>" action="<?= base_url('/edit-select-offer')?>" method="POST">
                        <input type="hidden" name="id-offer" value="<?= $offer['offer_id'] ?>">
                        <input type="hidden" name="select-offer" value="<?= $offer['user_offer_select'] ?>">
                        </form>
                        <a class="d-flex justify-content-center" href="#" onclick="document.getElementById('form-select-<?= $offer['offer_id']?>').submit(); return false;"><?php if($offer['user_offer_select'] == 0 || empty($offer['user_offer_select'])){ echo '<i class="fa-solid fa-check check-active p-1"></i>' ;} if($offer['user_offer_select'] == 1){echo '<i class="fa-solid fa-xmark xmark-active p-1"></i>';} ?></a>
                    </div>
                    <?php } ?>
                </div>
                <p class="card-text d-flex justify-content-center align-items-center m-1 fw-bold"><?= $offer['offer_name'] ?></p>
                <div class="d-flex">
                    <i class="fa-regular fa-calendar h5 m-3 mb-0 mt-0"></i>
                    <p class="card-text d-flex justify-content-center align-items-center"><?php $count = count($dates); foreach($dates as $date){echo date('d.m.Y', strtotime($date['date_date_from'])) . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])); if($count > 1){echo ' / ';}}?></p>
                </div>
                <div class="d-flex align-items-center mt-2">
                    <i class="fa-solid fa-location-dot h5 m-3 mb-0 mt-0"></i>
                    <p class="card-text d-flex justify-content-center align-items-center"><?= $offer['offer_street'] . ', ' . $offer['offer_post_code'] . '  ' . $offer['offer_city'] ?></p>
                </div>
                <div class="d-flex align-items-center mt-2">
                    <i class="fa-solid fa-user h5 m-3 mb-0 mt-0"></i>
                    <p class="card-text d-flex justify-content-center align-items-center"><?php if(!empty($offer['manager_degree_before'])){echo $offer['manager_degree_before'];} echo ' ' . $offer['manager_name'] . ' ' . $offer['manager_surname'] . ' '; if(!empty($offer['manager_degree_after'])){echo $offer['manager_degree_after'];} ?></p>
                </div>
                <div class="d-flex align-items-center mt-2">
                    <i class="fa-solid fa-envelope h5 m-3 mb-0 mt-0"></i>
                    <p class="card-text d-flex justify-content-center align-items-center"><?= $offer['manager_mail'] ?></p>
                </div>
                <div class="d-flex align-items-center mt-2">
                    <i class="fa-solid fa-phone h5 m-3 mb-0 mt-0"></i>
                    <p class="card-text d-flex justify-content-center align-items-center"><?= $offer['manager_phone'] ?></p>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-auto p-1">
                <a class="card-text btn-show-offer" href="<?= base_url('practise-offer-view/'.$offer['offer_id']) ?>">Zobrazit nabídku</a>
            </div>
        </div>
        <?php } }?>
</div>

<?php if(!empty($practiseDate)){ ?>
<div class="modal modal-lg" id="modalShowInformationPractise">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Informace o praxi</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <?= $practiseDate['practise_description'] ?>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalWriteMyPractise">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Zapsat vlastní praxi</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('')?>" method="POST" enctype="multipart/form-data">
            <div class="container d-flex flex-column">
                <label class="mt-1" for="name">Název pro praxi *</label>
                <input class="m-1" type="text" name="name_offer">
                <label class="mt-1" for="name">Místo konání (město) *</label>
                <input class="m-1" type="text" name="city_offer">
                <label class="mt-1" for="name">Místo konání (ulice) *</label>
                <input class="m-1" type="text" name="street_offer">
                <label class="mt-1" for="name">Místo konání (PSČ) *</label>
                <input class="m-1" type="text" name="post_code_offer">
                <div class="d-flex">
                    <div class="d-flex flex-column" style="width: 30%;">
                    <label class="mt-1" for="name">titul před.</label>
                    <input class="m-1" type="text" name="degree_before_manager">
                    </div>
                    <div class="d-flex flex-column" style="width: 70%;">
                    <label class="mt-1" for="name">Jméno vedoucího praxe *</label>
                    <input class="m-1" type="text" name="name_manager">
                    </div>
                </div>
                <div class="d-flex">
                <div class="d-flex flex-column" style="width: 70%;">
                    <label class="mt-1" for="name">Příjmení vedoucího praxe *</label>
                    <input class="m-1" type="text" name="surname_manager">
                    </div>
                    <div class="d-flex flex-column" style="width: 30%;">
                    <label class="mt-1" for="name">titul za.</label>
                    <input class="m-1" type="text" name="degree_after_manager">
                    </div>
                </div>
                <label class="mt-1" for="name">E-mail vedoucího praxe *</label>
                <input class="m-1" type="text" name="mail_manager">
                <label class="mt-1" for="name">Telefonní č. vedoucího praxe *</label>
                <input class="m-1" type="text" name="phone_manager">
                <label class="mt-1" for="name">Pracovní pozice vedoucího praxe *</label>
                <input class="m-1" type="text" name="position_manager">
                <label class="mt-1" for="name">Název firmy *</label>
                <input class="m-1" type="text" name="name_company">
                <label class="mt-1" for="name">Ičo firmy *</label>
                <input class="m-1" type="text" name="ico_company">
                <label class="mt-1" for="name">Sídlo firmy (město) *</label>
                <input class="m-1" type="text" name="city_company">
                <label class="mt-1" for="name">Sídlo firmy (ulice) *</label>
                <input class="m-1" type="text" name="street_company">
                <label class="mt-1" for="name">Sídlo firmy (PSČ) *</label>
                <input class="m-1" type="text" name="post_code_company">
                <label class="mt-1" for="name">Pravní forma *</label>
                <select name="legar_form_company">
                    <option value="" disabled selected>Vybrat</option>
                    <option value="0">Fyzická osoba</option>
                    <option value="1">Fyzická osoba</option>
                </select>
                <p>( * povinná pole)</p>
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Uložit" value="Zapsat">
      </div>
      </form>
    </div>
  </div>
</div>
<?php } ?>
<?= $this->endSection() ?>