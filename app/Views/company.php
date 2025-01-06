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
<form action="" method="GET">
    <div class="d-flex flex-wrap justify-content-between m-3">
            <div class="d-flex">
                <input class="search-input p-2 mt-2" name="search" id="search-input" type="text" placeholder="Vyhledat uživatele">
                <button class="btn btn-search mt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>
    <div class="d-flex flex-wrap justify-content-center">
        <?php foreach($companyes as $company){ ?>
            <div class="card-company m-4">
            <div class="d-flex mt-2 justify-content-center">
                <div class="card-icon-company d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h4"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-1 card-company-name"><p class="fw-bold text-center m-2 company-name"><?= $company['name'] ?></p></div>
            <div class="d-flex justify-content-center"><i class="fa-solid fa-location-dot p-2 h5"></i></div>
            <p class="text-center company-text"><?= $company['street'] . ', ' . $company['post_code'] . ' ' . $company['city'] ?></p>
            <div class="d-flex justify-content-center mt-2 text-center"><a class="d-flex justify-content-center align-items-center btn-show-company" href="#company">Zobrazit</a></div>
        </div>
        <?php }?>
    </div>
    <div class="d-flex justify-content-center"><?= $pager->links() ?></div>
</div>
<?= $this->endSection() ?>