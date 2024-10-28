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
    .card-people{
        width: 280px;
        height: 280px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .card-icon-people{
        width: 70px;
        height: 70px;
        border-radius: 70px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .btn-show-profile{
        width: 70%;
        height: 40px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 20px;
        color: black;
        text-decoration: none;
    }
    .btn-show-profile:hover{
        border: 0.5px solid #006DBC;
    }
</style>
<div class="container-fluid">
    <div class="d-flex m-3">
        <input class="search-input p-2 form-control" type="text" placeholder="Vyhledat">
    </div>
    <div class="d-flex flex-wrap justify-content-center">
        <!-- Začátek karty -->
        <div class="card-people m-4">
            <div class="d-flex mt-2 justify-content-center">
                <div class="card-icon-people d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h4"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-1"><p class="fw-bold h5">Martin Rumíšek</p></div>
            <div class="d-flex m-2 justify-content-between p-2">
                <div class="d-flex">
                    <p class="fw-bold p-2">Třída:</p>
                    <p class="p-2">4.B</p>
                </div>
                <div class="d-flex">
                    <p class="fw-bold p-2">Obor:</p>
                    <p class="p-2">IT</p>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-2 text-center"><a class="d-flex justify-content-center align-items-center btn-show-profile" href="#profile_rumisek">Zobrazit</a></div>
        </div>
        <!-- Konec karty -->
        <?php for ($i=0; $i < 20; $i++) { ?>
            <div class="card-people m-4">
            <div class="d-flex mt-2 justify-content-center">
                <div class="card-icon-people d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h4"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-1"><p class="fw-bold h5">Martin Rumíšek</p></div>
            <div class="d-flex m-2 justify-content-between p-2">
                <div class="d-flex">
                    <p class="fw-bold p-2">Třída:</p>
                    <p class="p-2">4.B</p>
                </div>
                <div class="d-flex">
                    <p class="fw-bold p-2">Obor:</p>
                    <p class="p-2">IT</p>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-2 text-center"><a class="d-flex justify-content-center align-items-center btn-show-profile" href="#profile_rumisek">Zobrazit</a></div>
        </div>
        <?php }?>
    </div>
</div>
<?= $this->endSection() ?>