<?= $this->extend('layout/layout_nav') ?>

<?= $this->section('content') ?>
<style>
    .container-profil{
        width: 100%;
        height: 550px;
        background: #006DBC 0% 0% no-repeat padding-box;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 0px 279px 246px 0px;
        opacity: 1;
    }
    .profile-icon{
        width: 200px;
        height: 200px;
        border-radius: 200px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        margin-right: 20%;
        margin-top: 15px;
    }
    .profile-name{
        margin-right: 20%;
    }
    .soc-icon{
        height: 27%;
        margin-right: 20%;
    }
    .circle-icon{
        width: 50px;
        height: 50px;
        border-radius: 50px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .custom-line{
        height: 7px;
        width: 100%;
        border: none;
        background-color: #006DBC;
        opacity: 1;
        margin-top: 0;
    }
    .card{
        border: none;
        height: 350px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .profile-text{
        width: 100%;
        height: auto;
        padding: 30px;
        border: none;
        border-radius: 30px;
        background-color: white;
        box-shadow:0px 3px 6px #00000029;
    }
    .btn-repair{
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        padding: 14px;
    }
    .btn-repair:hover{
        color:white;
        background-color: #006DBC;
    }
</style>
<?php 
 $role = session()->get('role');
 $userSession = session()->get('user');
 $companySession = session()->get('companyUser');
 $isStudent = in_array('student', $role);
 $isCompany = in_array('company', $role);
 $isAdmin = in_array('admin', $role);
 $isSpravce = in_array('spravce', $role);
 if($isStudent){
     $userId = $userSession['id'];

 }
 if($isCompany){
     $companyId = $companySession['id'];
 }
?>
<div class="container-fluid row p-0 m-0">
    <div class="col-12 col-lg-5 p-0">
        <div class="container-profil">
            <div class="d-flex justify-content-center">
                <div class="profile-icon d-flex justify-content-center align-items-center"><i class="fa-solid fa-user h1"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-3 profile-name"><h2 class="text-white"><?= $user['name'] . ' ' . $user['surname'] ?></h2></div>
            <div class="d-flex justify-content-center mt-3 profile-name"><h3 class="text-white"><?= $class['class'] . '.' . $class['letter_class'] ?></h3></div>
            <div class="d-flex flex-wrap justify-content-center soc-icon align-items-end">
                <div class="circle-icon d-flex justify-content-center align-items-center m-2"><i class="fa-solid fa-globe h3 p-0 m-0"></i></div>
                <div class="circle-icon d-flex justify-content-center align-items-center m-2"><i class="fa-solid fa-globe h3 p-0 m-0"></i></div>
                <div class="circle-icon d-flex justify-content-center align-items-center m-2"><i class="fa-solid fa-globe h3 p-0 m-0"></i></div>
                <div class="circle-icon d-flex justify-content-center align-items-center m-2"><i class="fa-solid fa-globe h3 p-0 m-0"></i></div>
                <div class="circle-icon d-flex justify-content-center align-items-center m-2"><i class="fa-solid fa-globe h3 p-0 m-0"></i></div>
                <div class="circle-icon d-flex justify-content-center align-items-center m-2"><i class="fa-solid fa-globe h3 p-0 m-0"></i></div>
                <div class="circle-icon d-flex justify-content-center align-items-center m-2"><i class="fa-solid fa-globe h3 p-0 m-0"></i></div>
                <div class="circle-icon d-flex justify-content-center align-items-center m-2"><i class="fa-solid fa-globe h3 p-0 m-0"></i></div>
                <div class="circle-icon d-flex justify-content-center align-items-center m-2"><i class="fa-solid fa-globe h3 p-0 m-0"></i></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-7 d-flex justify-conentent-center align-items-center p-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 p-2">
                    <h5>Obor</h5>
                    <p><?php if(empty($fieldStudy['name'])){echo 'Není uvedeno';}else{echo $fieldStudy['name'];} ?></p>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <h5>Telefonní číslo</h5>
                    <p><?php if(empty($user['phone'])){echo 'Není uvedeno';}else{echo $user['phone'];} ?></p>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <h5>Datum narození</h5>
                    <p><?php if(empty($user['date_birthday'])){echo 'Není uvedeno';}else{echo $user['date_birthday'];} ?></p>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <h5>E-mail</h5>
                    <p> <?= $user['mail'] ?></p>
                </div>
                <?php if($isAdmin || $isSpravce || $userId == $user['id']){ ?>
                <div class="col-12 mt-5 d-flex justify-content-center"><a class="btn-repair d-flex justify-conentent-center align-items-center h5" href="##zkouška"><i class="fa-solid fa-gear p-2"></i>Upravit profil</a></div>
                <?php } ?> 
            </div>
        </div>
    </div>
</div>
<div class="m-4 d-flex justify-content-center"><h2>Dovednosti</h2></div>
<div class="container">
    <div class="row">
        <?php foreach($categoryes as $category){ if(!empty($category['skill'])){ ?>
            <div class="col-12 col-md-6 col-lg-4 mt-2 d-flex justify-content-center">
            <div class="card" style="width: 20rem;">
                <div class="card-top d-flex justify-content-center align-items-center">
                    <div class="card-title p-2 h4"><?= $category['name'] ?></div>
                </div>
                <hr class="custom-line">
                <div class="card-body">
                    <?php foreach($category['skill'] as $skill){ ?>
                        <ul>
                            <li><?= $skill['name'] ?></li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php }} ?>
    </div>
</div>
<?php if(empty($user['description'])){echo '<br>';} ?>
<?php if(!empty($user['description'])){ ?>
<div class="m-4 d-flex justify-content-center"><h2>O mně</h2></div>
<div class="container profile-text">
    <div><?= $user['description'] ?></div>
</div>
<?php } ?>
<?= $this->endSection() ?>