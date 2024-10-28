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
    .card-offer{
        width: 320px;
        height: 340px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .card-offer:hover{
        border: 0.5px solid #006DBC;
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
<div class="container-fluid">
    <div class="d-flex m-3">
        <input class="search-input p-2 form-control" type="text" placeholder="Vyhledat">
    </div>
    <div class="d-flex flex-wrap justify-content-center">
        <?php for ($i=0; $i < 20; $i++) { ?>
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
        <?php }?>
    </div>
</div>
<?= $this->endSection() ?>