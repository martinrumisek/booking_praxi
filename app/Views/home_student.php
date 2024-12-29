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
</style>
<?php 
$role = session()->get('role');
if(in_array('admin', $role)){
    $viewRole = "admin";
}else if(in_array('spravce', $role)){
    $viewrole = "správce";
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-6 p-0">
            <div class="container-user">
                <div class="p-5 container">
                    <div class="d-md-flex d-block">
                        <div class="d-flex justify-content-center align-items-center"><div class="icon-user d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h1"></i></div></div>
                        <div class="d-flex justify-content-center align-items-center p-0 m-4"><div><div class="h3"><?= $user['name'] . ' ' . $user['surname']. ', ' . $class['class'] . '.' . $class['letter_class'] ?></div><div><span class="text-wrap">Žák<?php if(!empty($viewRole)){ echo ' , ' . $viewRole;} ?></span></div></div></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-md-6"><div class="h5 mt-2">Obor</div><div class=""><?= $fieldStudy['name'] ?></div></div>
                        <div class="col-12 col-md-6"><div class="h5 mt-2">Telefonní číslo</div><div class=""><?php if(empty($user['phone'])){echo "Není uvedeno";}else{echo $user['phone'];} ?></div></div>
                        <div class="col-12 col-md-6"><div class="h5 mt-2">E-mail</div><div class=""><?= $user['mail'] ?></div></div>
                    </div>
                    <div class="d-flex justify-content-center aling-items-center p-3"><div><a href="#"><div>Zobrazit více</div><div class="d-flex justify-content-center"><i class="fa-solid fa-chevron-down"></i></div></a></div></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
                <div class="container-company">
                    <div class="p-5 container">
                        <?php foreach($practise as $practiss){ if(!empty($practis) || $practiss['accepted'] == 1){ ?>
                        <div class="d-md-flex d-block">
                            <div class="d-flex justify-content-center align-items-center"><div class="icon-company d-flex align-items-center justify-content-center"><i class="fa-solid fa-building h1"></i></div></div>
                             <div class="d-flex justify-content-center align-items-center p-0 m-4"><div><div class="h4">Název firmy/instituce</div><span>Indorama Ventures Company Moravia a.s.</span><br><span class="fw-bold">IČO: </span><span>234324533</span></div></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6"><div class="h5 mt-2">Telefon</div><div class="">+420 222 333 444</div></div>
                            <div class="col-12 col-md-6"><div class="h5 mt-2">E-mail</div><div class="">jakub.sleskv@cz.indorama.net</div></div>
                            <div class="col-12 col-md-6"><div class="h5 mt-2">Vedoucí praxe</div><div class="">Jakub Sleskv</div></div>
                            <div class="col-12 col-md-6"><div class="h5 mt-2">E-mail na vedoucí</div><div class="">jakub.sleskv@cz.indorama.net</div></div>
                            <div class="col-12 col-md-6"><div class="h5 mt-2">Termín 1</div><div class="">12.04 - 30.4.2024</div></div>
                            <div class="col-12 col-md-6"><div class="h5 mt-2">Termín 2</div><div class="">02.06 - 10.06.2024</div></div>
                        </div>
                        <?php }}?>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="btn-container d-flex justify-content-center align-items-center"><a href="" class="btn-document-export d-flex justify-content-center align-items-center p-2"><i class="fa-solid fa-file p-2"></i> Smlouva k praxi</a></div>
<div class="d-flex justify-content-center mt-2"><h3>Oblíbené nabídky</h3></div>
<div class="d-flex align-items-center container d-none">
    <!-- Tlačítko pro předchozí kartu -->
    <a href="#">
        <div class="next-previously d-flex align-items-center justify-content-center"><i class="fa-solid fa-chevron-left"></i></div>
    </a>
    <div class="d-flex flex-row">
        <!-- Začátek první karty -->
        <div class="card-offer m-3">
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
        </div>
        <!-- Konec prnví karty a začátek druhé karty -->
        <div class="card-offer m-3">
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
        </div>
        <!-- Konec druhé karty a začátek třetí karty -->
        <div class="card-offer m-3">
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
        </div>
        <!-- Konec třetí karty -->
    </div>
    <!-- Tlačítko pro další kartu -->
    <a href="#">
        <div class="next-previously d-flex align-items-center justify-content-center"><i class="fa-solid fa-chevron-right"></i></div>
    </a>
</div>

<?= $this->endSection() ?>