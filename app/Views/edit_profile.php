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
    input.checkbox{
      background-color: transparent;
      box-shadow: none;
      height: auto;
      cursor:pointer;
    }
    input{
      border: none;
      height: 40px;
      padding: 8px;
      border-radius: 10px;
      background-color: white;
      box-shadow: 0px 3px 6px #00000029;
    }
    input:focus{
        border:1px solid #006DBC;
        outline: none;
    }
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
    -moz-appearance: textfield;
    }
    textarea{
      height: 250px;
      width: 100%;
      resize: none;
      overflow: auto;
      border-radius: 10px;
      background-color: white;
      border: none;
      box-shadow: 0px 3px 6px #00000029;
      padding: 8px;
    }
    textarea:focus{
        border:1px solid #006DBC;
        outline: none;
    }
    .btn-right-display-submit{
        position: fixed;
        bottom: 55px;
        right: 20px;
        z-index: 1;
        padding: 10px 20px;
        background-color: white; 
        box-shadow: 0px 3px 6px #00000029;
        color: black;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 16px;
    }
    .btn-right-display-submit:hover{
        background-color: #006DBC;
        color: white;
    }
    .reset-btn-date{
        cursor: pointer;
    }
    .reset-btn-date:hover{
        color:red;
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
?>
<form action="<?= base_url('/edit-profile') ?>" method="POST" id="form">
<div class="container-fluid row p-0 m-0">
    <div class="col-12 col-lg-5 p-0">
        <div class="container-profil">
            <div class="d-flex justify-content-center">
                <div class="profile-icon d-flex justify-content-center align-items-center"><i class="fa-solid fa-user h1"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-3 profile-name"><h2 class="text-white"><?= $user['user_name'] . ' ' . $user['user_surname'] ?></h2></div>
            <div class="d-flex justify-content-center mt-3 profile-name"><h3 class="text-white"><?= $user['class_class'] . '.' . $user['class_letter_class'] ?></h3></div>
            <div class="d-flex flex-wrap justify-content-center soc-icon align-items-end">
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
                    <input name="phone" type="tel" id="phone" style="width: 50%;" <?php if(!empty($user['user_phone'])){?> value="<?= $user['user_phone'] ?>"  <?php } ?> oninput="checkPhone()">
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <h5>Datum narození</h5>
                    <div class="d-flex">
                    <input name="birthday" type="date" style="width: 50%;" id="birthdayDay" <?php if(!empty($user['user_date_birthday'])){?> value="<?= $user['user_date_birthday'] ?>"  <?php } ?>>
                    <div class="m-2 d-flex align-items-center h4 p-0"><a class="reset-btn-date" onclick="resetDate(event)"><i class="fa-regular fa-circle-xmark"></i></a></div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <h5>E-mail</h5>
                    <p> <?= $user['user_mail'] ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-2 d-flex flex-wrap">
    <?php foreach($socialLinks as $link){ ?>
        <div class="d-flex">
        <div class="d-flex">
                <div class="circle-icon d-flex justify-content-center align-items-center m-2 h3"><?= $link['social_icon'] ?></div>
                <div class="d-flex align-items-center"><?= $link['social_name'] ?></div>
            </div>
            <div class="d-flex align-items-center m-2"><input style="width: 300px;" <?php if(!empty($link['user_social_url'])){ ?> value="<?= $link['user_social_url'] ?>" <?php }?> name="socialLinks[<?= $link['social_id'] ?>]" placeholder="URL" type="text"></div>
            
        </div>  
        <?php } ?>
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
                        <div class="d-flex flex-column">
                            <div class="d-flex">
                                <input name="skills[]" class="checkbox m-1" <?php if($skill['check_user_skill'] == 1){ ?> checked  <?php } ?> type="checkbox" value="<?= $skill['skill_id'] ?>">
                                <div class="m-1"><?= $skill['skill_name'] ?></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php }} ?>
    </div>
</div>
<div class="m-4 d-flex justify-content-center"><h2>O mně</h2></div>
<div class="container profile-text">
    <textarea name="description"><?= $user['user_description'] ?></textarea>
</div>
<input type="hidden" name="idUser" value="<?= $user['user_id'] ?>">
<input type="submit" class="btn-right-display-submit" value="Upravit">
</form>
<script>
    const phoneInput = document.getElementById('phone');
    function resetDate(){
        document.getElementById('birthdayDay').value = '';
    }
    const checkPhone = () => {
        const phoneInput = document.getElementById('phone');
        let value = phoneInput.value.replace(/[^+\d]/g, '');
        if (value.startsWith('420') || value.startsWith('421')) {
            value = '+' + value;
        }
        if (value.startsWith('+420') || value.startsWith('+421')) {
            value = value.slice(0, 4) + ' ' + value.slice(4, 7) + ' ' + value.slice(7, 10) + ' ' + value.slice(10, 13);
        } else {
            value = value.slice(0, 3) + ' ' + value.slice(3, 6) + ' ' + value.slice(6, 9);
        }
        phoneInput.value = value.trim();
        const phonePattern = /^(?:\+420|\+421)? ?\d{3} ?\d{3} ?\d{3}$/;
    };
    document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('form');
            form.addEventListener('submit', (event) => {
                let isValid = true;
                checkPhone();
                if(mobileInput.classList.contains('invalid-input')){
                    isValid = false;
                }
                if (!isValid){
                    event.preventDefault();
                    return false;
                }
            });
        });
</script>
<?= $this->endSection() ?>