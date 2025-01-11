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
<form action="" method="GET">
    <div class="d-flex flex-wrap justify-content-between m-3">
            <div class="d-flex">
                <input class="search-input p-2 mt-2" name="search" id="search-input" type="text" placeholder="Vyhledat uživatele" <?php if(!empty($search)){?> value="<?= $search ?>" <?php } ?>>
                <button class="btn btn-search mt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>
    <div class="d-flex flex-wrap justify-content-center">
        <!-- Začátek karty -->
         <?php foreach($users as $user){ ?>
            <div class="card-people m-4">
            <div class="d-flex mt-2 justify-content-center">
                <div class="card-icon-people d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h4"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-1"><p class="fw-bold h5"><?= $user['user_name'] . ' ' . $user['user_surname'] ?></p></div>
            <div class="d-flex m-2 justify-content-between p-2">
                <div class="d-flex">
                    <p class="fw-bold p-2">Třída:</p>
                    <p class="p-2"><?= $user['class_class'] . '.' . $user['class_letter_class'] ?></p>
                </div>
                <div class="d-flex">
                    <p class="fw-bold p-2">Obor:</p>
                    <p class="p-2"><?= $user['field_shortcut'] ?></p>
                </div>
            </div>
          <div class="d-flex justify-content-center mt-2 text-center"><a class="d-flex justify-content-center align-items-center btn-show-profile" href="<?= base_url('/profile/'.$user['user_id']) ?>">Zobrazit</a></div>
        </div>
        <?php } ?>
       
        <!-- Konec karty -->
    </div>
    <div class="d-flex justify-content-center"><?= $pager->links() ?></div>
</div>
<?= $this->endSection() ?>