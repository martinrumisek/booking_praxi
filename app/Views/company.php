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
    .card-company{
        width: 320px;
        height: 320px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .card-icon-company{
        width: 70px;
        height: 70px;
        border-radius: 70px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .btn-show-company{
        width: 70%;
        height: 40px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 20px;
        color: black;
        text-decoration: none;
    }
    .btn-show-company:hover{
        border: 0.5px solid #006DBC;
    }
    .card-company-name{
        min-height: 20%;
        max-height: 20%;
    }
    .company-name{
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        -webkit-line-clamp: 2;
    }
    .company-text{
        min-height: 18%;
        max-height: 18%;
        font-size: 13px;
    }
</style>
<div class="container-fluid">
    <div class="d-flex m-3">
        <input class="search-input p-2 form-control" type="text" placeholder="Vyhledat">
    </div>
    <div class="d-flex flex-wrap justify-content-center">
        <!-- Začátek karty -->
        <div class="card-company m-4">
            <div class="d-flex mt-2 justify-content-center">
                <div class="card-icon-company d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h4"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-1 card-company-name"><p class="fw-bold text-center m-2 company-name">Obchodní akademie, Vyšší odborná škola a Jazyková škola s právem státní jazykové zkoušky Uherské Hradiště</p></div>
            <div class="d-flex justify-content-center"><i class="fa-solid fa-location-dot p-2 h5"></i></div>
            <p class="text-center company-text">Nádražní 22, 686 01 Uherské Hradiště</p>
            <div class="d-flex justify-content-center mt-2 text-center"><a class="d-flex justify-content-center align-items-center btn-show-company" href="#company">Zobrazit</a></div>
        </div>
        <!-- Konec karty -->
        <?php for ($i=0; $i < 20; $i++) { ?>
            <div class="card-company m-4">
            <div class="d-flex mt-2 justify-content-center">
                <div class="card-icon-company d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h4"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-1 card-company-name"><p class="fw-bold text-center m-2 company-name">Obchodní akademie, Vyšší odborná škola a Jazyková škola s právem státní jazykové zkoušky Uherské Hradiště</p></div>
            <div class="d-flex justify-content-center"><i class="fa-solid fa-location-dot p-2 h5"></i></div>
            <p class="text-center company-text">Nádražní 22, 686 01 Uherské Hradiště</p>
            <div class="d-flex justify-content-center mt-2 text-center"><a class="d-flex justify-content-center align-items-center btn-show-company" href="#company">Zobrazit</a></div>
        </div>
        <?php }?>
    </div>
</div>
<?= $this->endSection() ?>