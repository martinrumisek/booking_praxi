<?= $this->extend('layout/layout_nav') ?>

<?= $this->section('content') ?>
<style>
    .search-input{
        width: 280px;
        height: 40px;
        border: none;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .search-input:focus{
        border:1px solid #006DBC;
        outline: none;
    }
    .btn-search{
        margin-left: 10px;
        border-radius: 100%;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .btn-search:hover{
        color:white;
        background-color: #006DBC;
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
    }
</style>
<div class="container-fluid" style="min-height: 90vh;">
<form action="" method="GET">
    <div class="d-flex flex-wrap justify-content-between m-3">
            <div class="d-flex">
                <input class="search-input p-2 mt-2" name="search" id="search-input" type="text" placeholder="Vyhledat uživatele" <?php if(!empty($search)){?> value="<?= $search ?>" <?php } ?>>
                <button class="btn btn-search mt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>
    <div class="d-flex flex-wrap justify-content-center" style="min-height: 80vh">
        <?php 
        if(empty($offers)){?>
            <div class="d-flex justify-content-center align-items-center">
                <div class="container-no-offer fw-bold">Nejsou žádné praxe</div>
            </div>
        <?php }
        foreach($offers as $offer){ ?>
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
                    <?php if($accepted == 0){ ?>
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
                    <p class="card-text d-flex justify-content-center align-items-center"><?php $count = count($offer['dates']); foreach($offer['dates'] as $date){echo date('d.m.Y', strtotime($date['date_date_from'])) . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])); if($count > 1){echo ' / ';}}?></p>
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
        <?php } ?>
        <?php for ($i=0; $i < 20; $i++) { ?>
        <!---<div class="card-offer m-3">
            <div class="d-flex m-3">
                <div class="card-icon-company d-flex justify-content-center align-items-center"><i class="fa-solid fa-building"></i></div>
                <p class="card-title fw-bold">Obchodní akademie, Vyšší odborná škola a Jazyková škola s právem státní jazykové zkoušky Uherské Hradiště</p>
                <a href="#"><i class="fa-solid fa-star card-star p-1"></i></a>
            </div>
            <div class="d-flex">
                <i class="fa-regular fa-calendar h5 m-3 mb-0 mt-0"></i>
                <p class="card-text d-flex justify-content-center align-items-center">20.03 - 21.03.2024 / 20.05 - 21.05.2024</p>
            </div>
            <div class="d-flex align-items-center mt-2">
                <i class="fa-solid fa-location-dot h5 m-3 mb-0 mt-0"></i>
                <p class="card-text d-flex justify-content-center align-items-center">Nádražní 22/22, 686 01 Uherské Hradiště 1</p>
            </div>
            <div class="d-flex mt-2">
                <p class="fw-bold m-3 mb-0 mt-0">Pro obor: </p>
                <p>IT, OA, VOŠ</p>
            </div>
            <h6 class="text-center">popis praxe</h6>
            <div class="p-2">
                <p class="text-praxe">Popis dané praxe</p>
            </div>
        </div> --->
        <?php }?>
    </div>
</div>
<?= $this->endSection() ?>