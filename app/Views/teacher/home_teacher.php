<?= $this->extend('layout/layout_nav') ?>

<?= $this->section('content') ?>
<style>
.container-user{
    width: 100%;
    min-height: 45vh;
    background-color: #006DBC;
}
.icon-user-teacher{
    padding: 35px;
    border-radius: 100%;
    box-shadow: 0px 3px 6px #00000029;
    background-color: white;
}
.card-chosse-teacher{
    width: 17rem;
    height: 220px;
    box-shadow: 0px 3px 6px #00000029;
    border-radius: 12px;
}
.btn-show-page{
    padding: 8px;
    border-radius: 7px;
    border: 1px solid #006DBC;
}
.btn-show-page:hover{
    background-color: #006DBC;
    color: white;
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
<div class="container-fluid container-user">
    <div class="d-flex pt-3 flex-column justify-content-center align-items-center" style="min-height: 40vh;">
        <h2 class="text-white">Přihlášený uživatel</h2>
        <div class="icon-user-teacher"><i class="fa-solid fa-chalkboard-user h1"></i></div>
        <h3 class="text-white"><?= $user['user_name'] . ' ' . $user['user_surname'] ?></h3>
        <p class="text-white"><?= $user['user_mail'] ?></p>
        <span class="text-white">Učitel <?php if(!empty($viewRole)){echo ', ' . $viewRole;} ?></span>
    </div>
</div>
<div class="container mt-2" style="min-height:50vh;">
    <div class="d-flex flex-wrap justify-content-center align-items-center mt-2" style="min-height: 49vh;">
        <div class="card-chosse-teacher d-flex flex-column m-1">
            <div class="m-4 text-center"><i class="icon-card-teacher fa-solid fa-list-ul h2 m-0"></i></div>
            <h4 class="text-center">Praxe</h4>
            <div class="d-flex justify-content-center m-2 mt-auto"><a class="btn-show-page" href="<?= base_url('/class-on-practise') ?>">Zobrazit</a></div>
        </div>
        <div class="card-chosse-teacher d-flex flex-column m-1">
            <div class=" m-4 text-center"><i class="icon-card-teacher fa-solid fa-user-group h2 m-0"></i></div>
            <h4 class="text-center">Lidé</h4>
            <div class="d-flex justify-content-center m-2 mt-auto"><a class="btn-show-page" href="<?= base_url('/people') ?>">Zobrazit</a></div>
        </div>
        <div class="card-chosse-teacher d-flex flex-column m-1">
            <div class=" m-4 text-center"><i class=" icon-card-teacher fa-solid fa-building h2 m-0"></i></div>
            <h4 class="text-center">Firmy</h4>
            <div class="d-flex justify-content-center m-2 mt-auto"><a class="btn-show-page" href="<?= base_url('/company') ?>">Zobrazit</a></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>