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
    .edit-profil-company{
        padding: 8px;
        color: white;
        border: 1px solid white;
        border-radius: 10px;
    }
    .edit-profil-company:hover{
        background-color: white;
        color: #006DBC;
        box-shadow: 0px 3px 6px #00000029;
    }
    .card-people{
        width: 280px;
        height: 280px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        border: 1px solid #006DBC;
    }
    .card-icon-people{
        width: 70px;
        height: 70px;
        border-radius: 70px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .add-new-people{
        padding: 15px;
        background-color: #006DBC;
        color: white;
        border-radius: 15px;
        box-shadow: 0px 3px 6px #00000029;
    }
    .add-new-people:hover{
        background-color: white;
        color: #006DBC;
        border: 1px solid #006DBC;
    }
    textarea.description-company{
      height: 180px;
      width: 100%;
      resize: none;
      overflow: auto;
      border-radius: 10px;
      background-color: white;
      border: none;
      box-shadow: 0px 3px 6px #00000029;
      padding: 8px;
    }
    textarea.name-company{
      height: 150px;
      width: 70%;
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
    .modal-header{
      background-color: #006DBC;
      color: white;
      box-shadow: 0px 3px 6px #00000029;
    }
    .modal-footer{
      background-color: white;
      color: white;
      box-shadow: 0px 3px 6px #00000029;
      border-top: 1px solid #006DBC;
    }
    .btn-close-modal{
      background-color: #006DBC;
      color: white;
      border: none;
      border-radius: 100%;
    }
    .btn-close-modal:hover{
      color: red;
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
    input:disabled{
      box-shadow: 0px 1px 1px #00000029;
      color: #006DBC;
    }
    input.checkbox{
      background-color: transparent;
      box-shadow: none;
      height: auto;
    }
    .invalid-input{
      border: 1px solid red;
    }
    .icon-edit-people{
        padding-left: 10px;
        padding-right: 10px;
    }
    .edit-del:hover{
        color: red;
    }
    .edit-repair:hover{
        color: gray;
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
     $userId = $companySession['idCompany'];
 }
?>
<form action="<?= base_url('/edit-company-profile') ?>" method="POST">
<div class="container-fluid row p-0 m-0">
    <div class="col-12 col-lg-5 p-0">
        <div class="container-profil">
            <div class="d-flex justify-content-center">
                <div class="profile-icon d-flex justify-content-center align-items-center m-0 mt-3"><i class="fa-solid fa-building h1"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-3 profile-name m-3"><textarea name="nameCompany" class="name-company" id=""><?= $company['company_name'] ?></textarea></div>
            <div class="d-flex justify-content-center mt-3 profile-name"><h3 class="text-white"></h3></div>
        </div>
    </div>
    <div class="col-12 col-lg-7 d-flex align-items-center p-5">
        <div class="d-flex align-items-center">
            <div class="container">
                <div class="h2">Kontaktní údaje</div>
                <div class="d-flex align-items-center h5">
                    <i class="fa-solid fa-user p-3"></i>
                    <div class="p-3 d-flex align-items-center"><?= $contact['representative_degree_before'] . ' ' . $contact['representative_name'] . ' ' . $contact['representative_surname'] . ' ' . $contact['representative_degree_after'] ?></div>
                </div>
                <div class="d-flex align-items-center h5">
                <div class="p-3 d-flex align-items-center">Funkce: </div>
                    <div class="p-3 d-flex align-items-center"><?= $contact['representative_function'] ?></div>
                </div>
                <div class="d-flex align-items-center h5">
                    <i class="fa-solid fa-envelope p-3"></i>
                    <div class="p-3 d-flex align-items-center"><?= $contact['representative_mail'] ?></div>
                </div>
                <div class="d-flex align-items-center h5">
                <i class="fa-solid fa-phone p-3"></i>
                    <div class="p-3 d-flex align-items-center"><?= $contact['representative_phone'] ?></div>
                </div>
                <div class="d-flex align-items-center h5">
                    <div class="p-3 d-flex align-items-center">IČO: </div>
                    <div class="p-3 d-flex align-items-center"><?= $company['company_ico'] ?></div>
                </div>
                <div class="d-flex align-items-center h5">
                    <i class=" p-3 fa-solid fa-location-dot"></i>
                    <div class="p-3 d-flex align-items-center"><?= $company['company_post_code'] . '  ' . $company['company_city']. ', ' . $company['company_street'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="m-4 d-flex justify-content-center"><h2>O nás</h2></div>
<div class="container profile-text">
    <textarea name="description_company" class="description-company" id="editor"><?= $company['company_description'] ?></textarea>
</div>
<input type="hidden" name="idCompany" value="<?= $company['company_id'] ?>">
<input type="submit" class="btn-right-display-submit" value="Upravit">
</form>
<div class="m-4 d-flex justify-content-center"><h2>Zástupci firmy</h2></div>
<div class="d-flex flex-wrap justify-content-center">
        <div class="card-people m-4">
            <div class="d-flex mt-2 justify-content-center">
                <div class="card-icon-people d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h4"></i></div>
            </div>
            <div class="d-flex justify-content-center align-items-center" style="height: 75%;">
                <a class="add-new-people" href="#modal" data-bs-toggle="modal" data-bs-target="#modalAddRepresentativeCompany" data-idCompany-representative="<?= $company['company_id'] ?>" ><i class="fa-solid fa-plus"></i> Přidat zástupce</a>
            </div>
        </div>
        <!-- Začátek karty -->
         <?php $countRepresentative = count($representatives); foreach($representatives as $user){ ?>
            <div class="card-people m-4">
            <div class="d-flex mt-2 justify-content-center">
                <div class="card-icon-people d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h4"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-1"><p class="fw-bold h5"> <?= $user['representative_degree_before'] . ' ' . $user['representative_name'] . ' ' . $user['representative_surname'] . ' ' . $user['representative_degree_after'] ?> </p></div>
            <div class="d-flex flex-column m-0 p-2">
                <div class="d-flex flex-column">
                    <p class="fw-bold m-0">E-mail:</p>
                    <p class="p-1 m-0"> <?= $user['representative_mail'] ?> </p>
                </div>
                <div class="d-flex flex-column">
                    <p class="fw-bold m-0">Tel. číslo:</p>
                    <p class="p-1 m-0"> <?= $user['representative_phone'] ?> </p>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <a class="icon-edit-people edit-repair" data-bs-toggle="modal" data-bs-target="#modalEditRepresentativeCompany" data-companyId-representative="<?= $user['Company_company_id'] ?>" data-representativeId-representative="<?= $user['representative_id'] ?>" data-degreeBefore-representative="<?= $user['representative_degree_before'] ?>" data-name-representative="<?= $user['representative_name'] ?>" data-surname-representative="<?= $user['representative_surname'] ?>" data-degreeAfter-representative="<?= $user['representative_degree_after'] ?>" data-mail-representative="<?= $user['representative_mail'] ?>" data-phone-representative="<?= $user['representative_phone'] ?>" data-position-representative="<?= $user['representative_function'] ?>" href=""><i class="fa-solid fa-pencil"></i></a>
               <?php if($countRepresentative > 1){ ?>  <a class="icon-edit-people edit-del" href="<?= base_url('/delete-representative-company-profil/'.$user['representative_id']) ?>"><i class="fa-solid fa-trash"></i></a> <?php } ?>
            </div>
        </div>
        <?php } ?>
        <!-- Konec karty -->
</div>
<div class="m-4 d-flex justify-content-center"><h2>Vedoucí praxí</h2></div>
<div class="d-flex flex-wrap justify-content-center">
        <!-- Začátek karty -->
         <?php if(empty($managers)){ ?>
        <div class="card-people m-4">
            <div class="d-flex justify-content-center align-items-center">
                <div class="fw-bold">ŽÁDNÝ VEDOUCÍ PRAXE</div>
            </div>    
        </div>
         <?php } ?>
         <div class="card-people m-4">
            <div class="d-flex mt-2 justify-content-center">
                <div class="card-icon-people d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h4"></i></div>
            </div>
            <div class="d-flex justify-content-center align-items-center" style="height: 75%;">
                <a class="add-new-people" href="#" data-bs-toggle="modal" data-bs-target="#modalAddPractiseManager" data-idCompany-practiseManager="<?= $company['company_id'] ?>"><i class="fa-solid fa-plus"></i> Přidat vedoucího</a>
            </div>
        </div>
         <?php foreach($managers as $user){ ?>
            <div class="card-people m-4">
            <div class="d-flex mt-2 justify-content-center">
                <div class="card-icon-people d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h4"></i></div>
            </div>
            <div class="d-flex justify-content-center mt-1"><p class="fw-bold h5"> <?= $user['manager_degree_before'] . ' ' . $user['manager_name'] . ' ' . $user['manager_surname'] . ' ' . $user['manager_degree_after'] ?> </p></div>
            <div class="d-flex flex-column m-0 p-2">
                <div class="d-flex flex-column">
                    <p class="fw-bold m-0">E-mail:</p>
                    <p class="p-1 m-0"> <?= $user['manager_mail'] ?> </p>
                </div>
                <div class="d-flex flex-column">
                    <p class="fw-bold m-0">Tel. číslo:</p>
                    <p class="p-1 m-0"> <?= $user['manager_phone'] ?> </p>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <a class="icon-edit-people edit-repair" href="#modal" data-bs-toggle="modal" data-bs-target="#modalEditPractiseManager" data-id-practiseManager="<?= $user['manager_id'] ?>" data-degreeBefore-practiseManager="<?= $user['manager_degree_before'] ?>" data-name-practiseManager="<?= $user['manager_name'] ?>" data-surname-practiseManager="<?= $user['manager_surname'] ?>" data-degreeAfter-practiseManager="<?= $user['manager_degree_after'] ?>" data-mail-practiseManager="<?= $user['manager_mail'] ?>" data-phone-practiseManager="<?= $user['manager_phone'] ?>" data-positionWorks-practiseManager="<?= $user['manager_position_works'] ?>"><i class="fa-solid fa-pencil"></i></a>
                <a class="icon-edit-people edit-del" href="<?= base_url('/profilDelete-practiseManager/'.$user['manager_id']) ?>"><i class="fa-solid fa-trash"></i></a>
            </div>
        </div>
        <?php } ?>
       <!-- Konec karty -->
</div>

<div class="modal" id="modalAddPractiseManager">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Vytvořit nového vedoucího praxe</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/profilAdd-practiseManager')?>" method="POST">
            <div class="container d-flex flex-column">
            <div class="d-flex"><input class="m-1" type="text" name="degree_before" style="width: 20%;" placeholder="Titul před."><input class="m-1 empty-input" type="text" name="name" style="width: 80%;" id="" placeholder="Jméno"></div>
            <div class="d-flex"><input type="text" class="m-1 empty-input" name="surname" style="width: 80%;" placeholder="Příjmení"><input class="m-1" type="text" name="degree_after" style="width: 20%;" placeholder="Titul za"></div>
            <input type="mail" class="m-1 empty-input mail" name="mail" placeholder="E-mail">
            <input class="m-1 phone-input empty-input" placeholder="Tel. č" name="phone" type="tel">
            <input class="m-1 empty-input" placeholder="Pracovní pozice" name="position_work" type="text">
            <input class="m-1" id="add-practiseManager-companyId" name="companyId" type="hidden">
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Uložit" value="Vytvořit">
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="modalEditPractiseManager">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Upravit vedoucího praxe</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/profilEdit-practiseManager')?>" method="POST">
            <div class="container d-flex flex-column">
            <div class="d-flex"><input class="m-1" type="text" name="degree_before" id="edit-practiseManager-degreeBefore" style="width: 20%;" placeholder="Titul před."><input class="m-1 empty-input" type="text" id="edit-practiseManager-name" name="name" style="width: 80%;" id="" placeholder="Jméno"></div>
            <div class="d-flex"><input type="text" class="m-1 empty-input" id="edit-practiseManager-surname" name="surname" style="width: 80%;" placeholder="Příjmení"><input class="m-1" type="text" name="degree_after" id="edit-practiseManager-degreeAfter" style="width: 20%;" placeholder="Titul za"></div>
            <input type="mail" class="m-1 empty-input mail" name="mail" id="edit-practiseManager-mail" placeholder="E-mail">
            <input class="m-1 phone-input empty-input" placeholder="Tel. č" id="edit-practiseManager-phone" name="phone" type="tel">
            <input class="m-1 empty-input" placeholder="Pracovní pozice" id="edit-practiseManager-positionWorks" name="position_work" type="text">
            <input class="m-1" id="edit-practiseManager-id" name="id" type="hidden">
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Uložit" value="Upravit">
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="modalAddRepresentativeCompany">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Vytvořit zástupce pro firmu</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/add-representative-company-profil')?>" method="POST">
            <div class="container d-flex flex-column">
              <div class="d-flex"><input class="m-1" type="text" name="degree_before" style="width: 20%;" placeholder="Titul před."><input class="m-1 empty-input" type="text" name="name" style="width: 80%;" id="" placeholder="Jméno"></div>
              <div class="d-flex"><input type="text" class="m-1 empty-input" name="surname" style="width: 80%;" placeholder="Příjmení"><input class="m-1" type="text" name="degree_after" style="width: 20%;" placeholder="Titul za"></div>
              <input type="mail" class="m-1 empty-input mail" name="mail" placeholder="E-mail">
              <input class="m-1 phone-input empty-input" placeholder="Tel. č" name="phone" type="tel">
              <input class="m-1 empty-input" placeholder="Pracovní pozice" name="position_work" type="text">
              <input class="m-1" placeholder="Heslo" name="passwd1" type="password" id="passwd1AddPass">
              <input class="m-1" placeholder="Potvrzení hesla" name="passwd2" type="password" id="passwd2AddPass">
              <div class="d-flex aling-items-center"><input class="checkbox" type="checkbox" value="1" name="checkbox" id="checkboxAddPass"><p class="m-0 text-checkbox">Heslo si vytvoří uživatel</p></div>
              <input class="m-1" id="add-representativeCompany-companyId" name="companyId" type="hidden">
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Uložit" value="Vytvořit">
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal" id="modalEditRepresentativeCompany">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Upravit zástupce pro firmu</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/edit-representative-company-profil')?>" method="POST">
            <div class="container d-flex flex-column">
              <div class="d-flex"><input class="m-1" type="text" name="degree_before" style="width: 20%;" placeholder="Titul před." id="representative-edit-degreeBefore"><input class="m-1 empty-input" type="text" name="name" style="width: 80%;" placeholder="Jméno" id="representative-edit-name"></div>
              <div class="d-flex"><input type="text" class="m-1 empty-input" name="surname" style="width: 80%;" placeholder="Příjmení" id="representative-edit-surname"><input class="m-1" type="text" name="degree_after" style="width: 20%;" placeholder="Titul za" id="representative-edit-degreeAfter"></div>
              <input type="mail" class="m-1 empty-input mail" name="mail" placeholder="E-mail" id="representative-edit-mail">
              <input class="m-1 phone-input empty-input" placeholder="Tel. č" name="phone" type="tel" id="representative-edit-phone">
              <input class="m-1 empty-input" placeholder="Pracovní pozice" name="position_work" type="text" id="representative-edit-position">
              <input class="m-1 empty-input" id="representative-edit-companyId" name="companyId" type="hidden">
              <input type="hidden" id="representative-edit-representativeId" name="id">
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Upravit" value="Upravit">
      </div>
      </form>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/js/validate-phone-input.js') ?>"></script>
<script src="<?= base_url('assets/js/validate-empty-input.js') ?>"></script>
<script src="<?= base_url('assets/js/validate-mail-input.js') ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalAddPractiseManager');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const companyId = button.getAttribute('data-idCompany-practiseManager') || '';
        document.getElementById('add-practiseManager-companyId').value = companyId;
      }
    });
  }
});
document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalAddRepresentativeCompany');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const companyId = button.getAttribute('data-idCompany-representative') || '';
        document.getElementById('add-representativeCompany-companyId').value = companyId;
      }
    });
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalEditRepresentativeCompany');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const companyId = button.getAttribute('data-companyId-representative') || '';
        const representativeId = button.getAttribute('data-representativeId-representative') || '';
        const degreeBefore = button.getAttribute('data-degreeBefore-representative') || '';
        const name = button.getAttribute('data-name-representative') || '';
        const surname = button.getAttribute('data-surname-representative') || '';
        const degreeAfter = button.getAttribute('data-degreeAfter-representative') || '';
        const mail = button.getAttribute('data-mail-representative') || '';
        const phone = button.getAttribute('data-phone-representative') || '';
        const positionWork = button.getAttribute('data-position-representative') || '';
        document.getElementById('representative-edit-companyId').value = companyId;
        document.getElementById('representative-edit-representativeId').value = representativeId;
        document.getElementById('representative-edit-degreeBefore').value = degreeBefore;
        document.getElementById('representative-edit-name').value = name;
        document.getElementById('representative-edit-surname').value = surname;
        document.getElementById('representative-edit-degreeAfter').value = degreeAfter;
        document.getElementById('representative-edit-mail').value = mail;
        document.getElementById('representative-edit-phone').value = phone;
        document.getElementById('representative-edit-position').value = positionWork;
      }
    });
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalEditPractiseManager');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const id = button.getAttribute('data-id-practiseManager') || '';
        const degreeBefore = button.getAttribute('data-degreeBefore-practiseManager') || '';
        const name = button.getAttribute('data-name-practiseManager') || '';
        const surname = button.getAttribute('data-surname-practiseManager') || '';
        const degreeAfter = button.getAttribute('data-degreeAfter-practiseManager') || '';
        const mail = button.getAttribute('data-mail-practiseManager') || '';
        const phone = button.getAttribute('data-phone-practiseManager') || '';
        const positionWorks = button.getAttribute('data-positionWorks-practiseManager') || '';
        document.getElementById('edit-practiseManager-id').value = id;
        document.getElementById('edit-practiseManager-degreeBefore').value = degreeBefore;
        document.getElementById('edit-practiseManager-name').value = name;
        document.getElementById('edit-practiseManager-surname').value = surname;
        document.getElementById('edit-practiseManager-degreeAfter').value = degreeAfter;
        document.getElementById('edit-practiseManager-mail').value = mail;
        document.getElementById('edit-practiseManager-phone').value = phone;
        document.getElementById('edit-practiseManager-positionWorks').value = positionWorks;
      }
    });
  }
});
const checkboxAddPass = document.getElementById('checkboxAddPass');
const passwd1AddPass = document.getElementById('passwd1AddPass');
const passwd2AddPass = document.getElementById('passwd2AddPass');
checkboxAddPass.addEventListener('change', function(){
  if(this.checked){
    passwd1AddPass.setAttribute('disabled', 'true');
    passwd2AddPass.setAttribute('disabled', 'true');
    passwd1AddPass.value = 'Heslo nezadáváte!'
    passwd2AddPass.value = 'Heslo nezadáváte!'
    passwd1AddPass.type = 'text';
    passwd2AddPass.type = 'text';
  }else{
    passwd1AddPass.removeAttribute('disabled');
    passwd2AddPass.removeAttribute('disabled');
    passwd1AddPass.value = ''
    passwd2AddPass.value = ''
    passwd1AddPass.type = 'password';
    passwd2AddPass.type = 'password';
  }
});
</script>
<?= $this->endSection() ?>