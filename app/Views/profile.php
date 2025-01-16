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
    .circle-icon:hover{
        border: 1px solid black;
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
            <div class="d-flex justify-content-center mt-3 profile-name"><h2 class="text-white"><?= $user['user_name'] . ' ' . $user['user_surname'] ?></h2></div>
            <div class="d-flex justify-content-center mt-3 profile-name"><h3 class="text-white"><?= $user['class_class'] . '.' . $user['class_letter_class'] ?></h3></div>
            <div class="d-flex flex-wrap justify-content-center soc-icon align-items-end">
                <?php if(!empty($socialLinks)){ foreach($socialLinks as $link){ ?>
                    <a target="_blank" href="<?= $link['user_social_url'] ?>"><div class="circle-icon d-flex justify-content-center align-items-center m-2 h3"><?= $link['social_icon'] ?></div></a>
                <?php }} ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-7 d-flex justify-conentent-center align-items-center p-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 p-2">
                    <h5>Obor</h5>
                    <p><?php if(empty($user['field_name'])){echo 'Není uvedeno';}else{echo $user['field_name'];} ?></p>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <h5>Telefonní číslo</h5>
                    <p><?php if(empty($user['user_phone'])){echo 'Není uvedeno';}else{echo $user['user_phone'];} ?></p>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <h5>Datum narození</h5>
                    <p><?php if(empty($user['user_date_birthday'])){echo 'Není uvedeno';}else{echo $user['user_date_birthday'];} ?></p>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <h5>E-mail</h5>
                    <p> <?= $user['user_mail'] ?></p>
                </div>
                <?php if($isAdmin || $isSpravce || $userId == $user['user_id']){ ?>
                <div class="col-12 mt-5 d-flex justify-content-center"><a class="btn-repair d-flex justify-conentent-center align-items-center h5" href="<?= base_url('/edit-profile/'.$user['user_id']) ?>"><i class="fa-solid fa-gear p-2"></i>Upravit profil</a></div>
                <?php } ?> 
            </div>
        </div>
    </div>
</div>
<div class="m-4 d-flex justify-content-center"><h2>Dovednosti</h2></div>
<div class="container">
    <div class="row">
        <?php foreach($categoryes as $category){ if(!empty($category['skills'])){ ?>
            <div class="col-12 col-md-6 col-lg-4 mt-2 d-flex justify-content-center">
            <div class="card" style="width: 20rem;">
                <div class="card-top d-flex justify-content-center align-items-center">
                    <div class="card-title p-2 h4"><?= $category['category_name'] ?></div>
                </div>
                <hr class="custom-line">
                <div class="card-body">
                    <?php foreach($category['skills'] as $skill){ ?>
                        <ul>
                            <li><?= $skill['skill_name'] ?></li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php }} ?>
    </div>
</div>
<?php if(empty($user['user_description'])){echo '<br>';} ?>
<?php if(!empty($user['user_description'])){ ?>
<div class="m-4 d-flex justify-content-center"><h2>O mně</h2></div>
<div class="container profile-text">
    <div><?= $user['user_description'] ?></div>
</div>
<?php } ?>
<?= $this->endSection() ?>