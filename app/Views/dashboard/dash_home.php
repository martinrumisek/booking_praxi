<?= $this->extend('layout/layout_dashboard_nav') ?>
<?= $this->section('content') ?>
<?php 
$role = session()->get('role');
$isStudent = in_array('student', $role);
$isTeacher = in_array('teacher', $role);
$isAdmin = in_array('admin', $role);
$isSpravce = in_array('spravce', $role);
?>
<style>
.card-main-admin{
    width: 280px;
    height: 180px;
    background-color: white;
    box-shadow: 0px 3px 6px #00000029;
    border-radius: 15px;
}
.nav-icon-main-admin{
    margin: 8px;
    padding: 15px;
    background-color: white;
    border-radius: 100%;
}
.btn-show{
    margin-top: 5px;
    padding: 8px;
    background-color: #006DBC;
    color: white;
    box-shadow: 0px 3px 6px #00000029;
    border-radius: 8px;
    border: 1px solid #006DBC;
}
.btn-show:hover{
    background-color: white;
    color: black;
    border: 1px solid #006DBC;
}
.btn-back-app{
    margin-top: 5px;
    padding: 8px;
    background-color: white;
    color: black;
    box-shadow: 0px 3px 6px #00000029;
    border-radius: 8px;
    border: 1px solid #006DBC;
}
.btn-back-app:hover{
    background-color: #006DBC;
    color: white;
    border: 1px solid #006DBC;
}
</style>
<div class="d-flex justify-content-center align-items-center flex-column" style="min-height: 95vh;">
    <h2 class="m-3">ADMINISTRACE SYSTÉMU</h2>
    <div class="d-flex flex-wrap container justify-content-center">
        <div class="card-main-admin d-flex flex-column align-items-center justify-content-center m-2">
            <i class="fa-solid fa-list-ul nav-icon-main-admin h2 m-0"></i>
            <h3>Nabídka praxe</h3>
            <a class="btn-show" href="<?= base_url('/dashboard-date-practise-offer')?>">Zobrazit</a>
        </div>
        <div class="card-main-admin d-flex flex-column align-items-center justify-content-center m-2">
            <i class="fa-solid fa-user-group nav-icon-main-admin h2 m-0"></i>
            <h3>Lidé</h3>
            <a class="btn-show" href="<?= base_url('/dashboard-people')?>">Zobrazit</a>
        </div>
        <div class="card-main-admin d-flex flex-column align-items-center justify-content-center m-2">
            <i class="fa-solid fa-building nav-icon-main-admin h2 m-0"></i>
            <h3>Firmy</h3>
            <a class="btn-show" href="<?= base_url('/dashboard-company')?>">Zobrazit</a>
        </div>
        <div class="card-main-admin d-flex flex-column align-items-center justify-content-center m-2">
            <i class="fa-solid fa-calendar nav-icon-main-admin h2 m-0"></i>
            <h3>Termíny praxí</h3>
            <a class="btn-show" href="<?= base_url('/dashboard-calendar')?>">Zobrazit</a>
        </div>
        <div class="card-main-admin d-flex flex-column align-items-center justify-content-center m-2">
            <i class="fa-solid fa-head-side-virus nav-icon-main-admin h2 m-0"></i>
            <h3>Dovednosti</h3>
            <a class="btn-show" href="<?= base_url('/dashboard-skill')?>">Zobrazit</a>
        </div>
        <?php if($isAdmin){ ?>
        <div class="card-main-admin d-flex flex-column align-items-center justify-content-center m-2">
            <i class="fa-solid fa-chart-column nav-icon-main-admin h2 m-0"></i>
            <h3>Log uživatelů</h3>
            <a class="btn-show" href="<?= base_url('/dashboard-log')?>">Zobrazit</a>
        </div>
        <div class="card-main-admin d-flex flex-column align-items-center justify-content-center m-2">
            <i class="fa-solid fa-chart-column nav-icon-main-admin h2 m-0"></i>
            <h3>Log firem</h3>
            <a class="btn-show" href="<?= base_url('/dashboard-log-company')?>">Zobrazit</a>
        </div>
        <?php } ?>
    </div>
    <div class="m-4"><a class="btn-back-app" href="<?= base_url('/home-student')?>">Zpět do aplikace</a></div>
</div>
<?= $this->endSection() ?>