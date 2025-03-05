<?= $this->extend('layout/layout_dashboard_nav') ?>

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
    tr{
        white-space: nowrap;
    }
    td.name{
        min-width: 80px;
        max-width: 150px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    td.users{
        background-color:#006DBC;
        color: white;
    }
    td.practise-manager{
      background-color: gray;
      color: white;
    }
    .btn-search{
        margin-left: 10px;
        border-radius: 100%;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .btn-add-company{
        margin-left: 10px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .btn-add-user{
        margin-left: 5px;
        margin-right: 5px;
        padding: 5px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 8px;
    }
    .btn-add-user:hover{
        background-color: #006DBC;
        color: white;
    }
    .btn-add-company:hover{
        background-color:#006DBC;
        color: white;
    }
    .btn-search:hover{
        background-color: #006DBC;
        color: white;
    }
    .icon-edit{
        margin-left: 2px;
        margin-right: 2px;
    }
    .add-user-text:hover{
        color:white;
    }
    .cursor-pointer{
        cursor:pointer;
    }
    tr.cursor-pointer:hover{
        border: 0.5px solid #006DBC;
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
    textarea{
      height: 80px;
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
    p.text-checkbox{
      margin-left: 5px;
      padding-left: 10px;
    }
    .btn-create:hover{
        background-color: #006DBC;
        color: white;
    }
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
    -moz-appearance: textfield;
    }
    select{
      border: none;
      height: 40px;
      padding: 8px;
      border-radius: 10px;
      background-color: white;
      box-shadow: 0px 3px 6px #00000029;
    }
    select:focus{
       border:1px solid #006DBC;
        outline: none;
    }
    .invalid-input{
      border: 1px solid red;
    }
    .del-icon:hover{
      color:red;
    }
    .edite-icon:hover{
      color:gray;
    }
</style>
<div class="container-fluid">
    <h2 class="mt-2">Přehled firem</h2>
    <div class="d-flex flex-wrap justify-content-between m-3">
        <form action="" method="GET">
            <div class="d-flex">
                <input class="search-input p-2 mt-2" id="search-input" name="search" type="text" placeholder="Vyhledat uživatele" <?php if(!empty($search)){?> value="<?= $search ?>" <?php } ?>>
                <button class="btn btn-search mt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
            <div class="d-flex">
                <button class="btn btn-add-company mt-2"  data-bs-toggle="modal" data-bs-target="#modalAddCompany"><i class="fa-solid fa-circle-plus"></i> Přidat firmu</button>
            </div>
    </div>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col" class="nowrap"></th>
                        <th scope="col">Jméno</th>
                        <th scope="col">IČO</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Telefonní č.</th>
                        <th scope="col">Funkce</th>
                        <th scope="col">Vytvořeno</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                   <?php foreach($companyes as $company){ ?>
                        <tr class="cursor-pointer" data-bs-toggle="collapse" data-bs-target="#company-<?= $company['company_id'] ?>">
                            <td><i class="fa-solid fa-building"></i> Firma</td>
                            <td class="name"><?= $company['company_name']?></td>
                            <td><?= $company['company_ico']?></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td><?= date('d.m.Y H:i:s', strtotime($company['company_create_time'])) ?></td>
                            <td><div class="d-flex"><a class="icon-edit" href="#modalEditCompany" data-bs-toggle="modal" data-bs-target="#modalEditCompany" data-id-company="<?= $company['company_id'] ?>" data-name-company="<?= $company['company_name'] ?>"><i class="fa-solid fa-pencil edite-icon"></i></a><a class="icon-edit" href="<?= base_url('/company-profil/'.$company['company_id']) ?>"><i class="fa-solid fa-eye edite-icon"></i></a><a class="icon-edit" href="<?= base_url('/delete-company/'.$company['company_id']) ?>"><i class="fa-solid fa-trash del-icon"></i></a></div></td>
                        </tr>
                        <?php foreach($company['representative'] as $representativeCompany){?>
                            <!-- Zde je potřeba přidat barvu, pro každé zastápce firmy, bude jiná barva řádku, firma = bíla, všechny zástupci firmy budou pod ní a budou mít světle šedou -->
                            <tr id="company-<?= $company['company_id'] ?>" class="collapse">
                                <td class="users"><i class="fa-solid fa-building-user"></i> Zást.</td>
                                <td class="users"><?php if(!empty($representativeCompany['representative_degree_before'])){echo $representativeCompany['representative_degree_before'] . ' ';}  echo $representativeCompany['representative_name'] . ' ' . $representativeCompany['representative_surname']; if(!empty($representativeCompany['representative_degree_after'])){echo ' ' . $representativeCompany['representative_degree_after'];} ?></td>
                                <td class="text-center users"></td>
                                <td class="users"><?= $representativeCompany['representative_mail']?></td>
                                <td class="users"><?= $representativeCompany['representative_phone']?></td>
                                <td class="users"><?= $representativeCompany['representative_function']?></td>
                                <td class="users"><?= date('d.m.Y H:i:s', strtotime($representativeCompany['representative_create_time'])) ?></td>
                                <td class="users"><div class="d-flex"><a class="icon-edit text-white" href="#modalEditRepresentativeCompany" data-bs-toggle="modal" data-bs-target="#modalEditRepresentativeCompany" data-id-representativeCompany="<?= $representativeCompany['representative_id'] ?>" data-degreeBefore-representativeCompany="<?= $representativeCompany['representative_degree_before'] ?>" data-name-representativeCompany="<?= $representativeCompany['representative_name'] ?>" data-surname-representativeCompany="<?= $representativeCompany['representative_surname'] ?>" data-degreeAfter-representativeCompany="<?= $representativeCompany['representative_degree_after'] ?>" data-mail-representativeCompany="<?= $representativeCompany['representative_mail'] ?>" data-phone-representativeCompany="<?= $representativeCompany['representative_phone'] ?>"data-positionWorks-representativeCompany="<?= $representativeCompany['representative_function'] ?>"><i class="fa-solid fa-pencil edite-icon"></i></a><a class="icon-edit text-white" href="#" data-bs-toggle="modal" data-bs-target="#modalEditPasswordUser" data-id-passwordUser="<?= $representativeCompany['representative_id'] ?>"><i class="fa-solid fa-key edite-icon"></i></a><a class="icon-edit text-white" href="<?= base_url('/delete-representativeCompany/'.$representativeCompany['representative_id']) ?>"><i class="fa-solid fa-trash del-icon"></i></a></div></td>
                            </tr>
                        <?php }?>
                        <?php if(empty($company['practiseManager'])){?>
                            <tr id="company-<?= $company['company_id'] ?>" class="collapse"><td class="practise-manager text-center" colspan="8">Žádný vedoucí pro praxe</td></tr>
                        <?php } ?>
                        <?php foreach($company['practiseManager'] as $practiseManager){ ?>
                            <tr id="company-<?= $company['company_id'] ?>" class="collapse">
                                <td class="practise-manager"><i class="fa-solid fa-user-tie"></i> Ved. praxe</td>
                                <td class="practise-manager"><?php if(!empty($practiseManager['manager_degree_before'])){echo $practiseManager['manager_degree_before'] . ' ';}  echo $practiseManager['manager_name'] . ' ' . $practiseManager['manager_surname']; if(!empty($practiseManager['manager_degree_after'])){echo ' ' . $practiseManager['manager_degree_after'];} ?></td>
                                <td class="practise-manager"></td>
                                <td class="practise-manager"><?= $practiseManager['manager_mail'] ?></td>
                                <td class="practise-manager"><?= $practiseManager['manager_phone'] ?></td>
                                <td class="practise-manager"><?= $practiseManager['manager_position_works'] ?></td>
                                <td class="practise-manager"><?= date('d.m.Y H:i:s', strtotime($practiseManager['manager_create_time'])) ?></td>
                                <td class="practise-manager"><div class="d-flex"><a class="icon-edit text-white" href="#modalEditPractiseManager" data-bs-toggle="modal" data-bs-target="#modalEditPractiseManager" data-id-practiseManager="<?= $practiseManager['manager_id'] ?>" data-degreeBefore-practiseManager="<?= $practiseManager['manager_degree_before'] ?>" data-name-practiseManager="<?= $practiseManager['manager_name'] ?>" data-surname-practiseManager="<?= $practiseManager['manager_surname'] ?>" data-degreeAfter-practiseManager="<?= $practiseManager['manager_degree_after'] ?>" data-phone-practiseManager="<?= $practiseManager['manager_phone'] ?>" data-mail-practiseManager="<?= $practiseManager['manager_mail'] ?>" data-positionWorks-practiseManager="<?= $practiseManager['manager_position_works'] ?>" data-companyId-practiseManager="<?= $practiseManager['Company_company_id'] ?>"><i class="fa-solid fa-pencil edite-icon"></i></a><a class="icon-edit text-white" href="<?= base_url('/delete-practiseManager/'.$practiseManager['manager_id']) ?>"><i class="fa-solid fa-trash del-icon"></i></a></div></td>
                            </tr>
                        <?php } ?>
                            <tr id="company-<?= $company['company_id'] ?>" class="collapse">
                                <td colspan="8" class="add-user"><div class="d-flex justify-content-center flex-row flex-wrap"><a href="#modalAddPractiseManager" class="btn-add-user" data-bs-toggle="modal" data-bs-target="#modalAddPractiseManager" data-companyId-practiseManager="<?= $company['company_id'] ?>"><i class="fa-solid fa-user-plus"></i> Přidat vedoucího</a><a href="#modalAddRepresentativeCompany" class="btn-add-user" data-bs-toggle="modal" data-bs-target="#modalAddRepresentativeCompany" data-companyId-representativeCompany="<?= $company['company_id'] ?>"><i class="fa-solid fa-user-plus"></i> Přidat zástupce</a></div></td>
                            </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center"><?= $pager->links() ?></div>
    </div>
</div>
<!-- Modaly pro editaci a přidávání -->
<div>
    <!-- přidání firmy -->
<div class="modal" id="modalAddCompany">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Přidat novou firmu</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('add-new-company')?>" method="POST">
            <div class="container d-flex flex-column">
              <textarea name="nameCompany" class="m-1" placeholder="Název firmy (není povinné)"></textarea>
              <input class="m-1 empty-input ico" placeholder="IČO" name="ico" type="number">
              <select class="m-1 empty-input" id="edit-skill-categoryId" name="category_id" placeholder="Vyberte možnost" value="Vyberte možnost">
                <option disabled selected value="">Vyberte možnost</option>
                <option value="1">Fyzická osoba</option>
                <option value="2">Pravnická osoba</option>
              </select>
              <div class="d-flex"><input class="m-1" type="text" name="degree_before" style="width: 20%;" placeholder="Titul před."><input class="m-1 empty-input" type="text" name="name" style="width: 80%;" id="" placeholder="Jméno zást."></div>
              <div class="d-flex"><input type="text" class="m-1 empty-input" name="surname" style="width: 80%;" placeholder="Příjmení zást."><input class="m-1" type="text" name="degree_after" style="width: 20%;" placeholder="Titul za"></div>
              <input type="mail" class="m-1 empty-input mail" name="mail" placeholder="E-mail zást.">
              <input class="m-1 phone-input empty-input" placeholder="Tel. č. zást." name="phone" type="tel">
              <input class="m-1 empty-input" placeholder="Pracovní pozice zást." name="position_work" type="text">
              <input class="m-1 empty-input" placeholder="Heslo" name="passwd1" type="password" id="passwd1">
              <input class="m-1 empty-input" placeholder="Potvrzení hesla" name="passwd2" type="password" id="passwd2">
              <div class="d-flex aling-items-center"><input class="checkbox" type="checkbox" value="1" name="checkbox" id="checkbox-passwd-hidden"><p class="m-0 text-checkbox">Heslo si vytvoří uživatel</p></div>
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Uložit" value="Vytvořit">
      </div>
      </form>
    </div>
  </div>
</div>
    <!-- editace firmy -->
<div class="modal" id="modalEditCompany">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Upravit firmu</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/edit-company')?>" method="POST">
            <div class="container d-flex flex-column">
              <textarea name="name" class="m-1 empty-input" placeholder="Název firmy" id="edit-company-name"></textarea>
              <input class="m-1" placeholder="id - firma" name="id" type="hidden" id="edit-company-id">
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Upravit" value="Upravit">
      </div>
      </form>
    </div>
  </div>
</div>
    <!-- přidání vedoucího pro praxe -->
<div class="modal" id="modalAddPractiseManager">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Vytvořit nového vedoucího praxe</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/add-practiseManager')?>" method="POST">
            <div class="container d-flex flex-column">
            <div class="d-flex"><input class="m-1" type="text" name="degree_before" style="width: 20%;" placeholder="Titul před."><input class="m-1 empty-input" type="text" name="name" style="width: 80%;" id="" placeholder="Jméno"></div>
            <div class="d-flex"><input type="text" class="m-1 empty-input" name="surname" style="width: 80%;" placeholder="Příjmení"><input class="m-1" type="text" name="degree_after" style="width: 20%;" placeholder="Titul za"></div>
            <input type="mail" class="m-1 empty-input" name="mail" placeholder="E-mail">
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
    <!-- editace vedoucího pro praxe -->
<div class="modal" id="modalEditPractiseManager">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Upravit vedoucího praxe</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('edit-practiseManager')?>" method="POST">
            <div class="container d-flex flex-column">
                <div class="d-flex"><input id="edit-practiseManager-degreeBefore" class="m-1" type="text" name="degree_before" style="width: 20%;" placeholder="Titul před."><input class="m-1 empty-input" type="text" name="name" style="width: 80%;" id="edit-practiseManager-name" placeholder="Jméno"></div>
                <div class="d-flex"><input type="text" class="m-1 empty-input" name="surname" style="width: 80%;" placeholder="Příjmení" id="edit-practiseManager-surname"><input class="m-1" type="text" name="degree_after" style="width: 20%;" placeholder="Titul za" id="edit-practiseManager-degreeAfter"></div>
                <input type="mail" class="m-1 empty-input" name="mail" placeholder="E-mail" id="edit-practiseManager-mail">
                <input class="m-1 phone-input empty-input" placeholder="Tel. č" name="phone" type="tel" id="edit-practiseManager-phone">
                <input class="m-1 empty-input" placeholder="Pracovní pozice" name="position_work" type="text" id="edit-practiseManager-positionWorks">
                <input class="m-1" id="edit-practiseManager-companyId" name="companyId" type="hidden">
                <input class="m-1" id="edit-practiseManager-id" name="id" type="hidden">
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Upravit" value="Upravit">
      </div>
      </form>
    </div>
  </div>
</div>
    <!-- přidání zást. pro firmu -->
<div class="modal" id="modalAddRepresentativeCompany">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Vytvořit zástupce pro firmu</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/add-representativeCompany')?>" method="POST">
            <div class="container d-flex flex-column">
              <div class="d-flex"><input class="m-1" type="text" name="degree_before" style="width: 20%;" placeholder="Titul před."><input class="m-1 empty-input" type="text" name="name" style="width: 80%;" id="" placeholder="Jméno"></div>
              <div class="d-flex"><input type="text" class="m-1 empty-input" name="surname" style="width: 80%;" placeholder="Příjmení"><input class="m-1" type="text" name="degree_after" style="width: 20%;" placeholder="Titul za"></div>
              <input type="mail" class="m-1 empty-input" name="mail" placeholder="E-mail">
              <input class="m-1 phone-input empty-input" placeholder="Tel. č" name="phone" type="tel">
              <input class="m-1 empty-input" placeholder="Pracovní pozice" name="position_work" type="text">
              <input class="m-1 empty-input" placeholder="Heslo" name="passwd1" type="password" id="passwd1AddPass">
              <input class="m-1 empty-input" placeholder="Potvrzení hesla" name="passwd2" type="password" id="passwd2AddPass">
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
<!-- editace hesla pro uživatele -->
<div class="modal" id="modalEditPasswordUser">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Změna hesla uživatele</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/edit-user-password')?>" method="POST">
            <div class="container d-flex flex-column">
              <input class="m-1 empty-input" placeholder="Nové heslo" name="passwd1" type="password" id="passwd1EditPass">
              <input class="m-1 empty-input" placeholder="Potvrzení hesla" name="passwd2" type="password" id="passwd2EditPass">
              <div class="d-flex aling-items-center"><input class="checkbox" type="checkbox" value="1" name="checkbox" id="checkboxEditPass"><p class="m-0 text-checkbox">Heslo si vytvoří uživatel</p></div>
              <input class="m-1" name="id" id="edit-passwordUser-id" type="hidden">
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Obnovit" value="Obnovit">
      </div>
      </form>
    </div>
  </div>
</div>
    <!-- editace zást. pro firmu -->
<div class="modal" id="modalEditRepresentativeCompany">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Upravit zástupce firmy</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/edit-representativeCompany')?>" method="POST">
            <div class="container d-flex flex-column">
                <div class="d-flex"><input id="edit-representativeCompany-degreeBefore" class="m-1" type="text" name="degree_before" style="width: 20%;" placeholder="Titul před."><input class="m-1 empty-input" type="text" name="name" style="width: 80%;" id="edit-representativeCompany-name" placeholder="Jméno"></div>
                <div class="d-flex"><input type="text" class="m-1 empty-input" name="surname" style="width: 80%;" placeholder="Příjmení" id="edit-representativeCompany-surname"><input class="m-1" type="text" name="degree_after" style="width: 20%;" placeholder="Titul za" id="edit-representativeCompany-degreeAfter"></div>
                <input type="mail" class="m-1 empty-input" name="mail" placeholder="E-mail" id="edit-representativeCompany-mail">
                <input class="m-1 phone-input empty-input" placeholder="Tel. č" name="phone" type="tel" id="edit-representativeCompany-phone">
                <input class="m-1 empty-input" placeholder="Pracovní pozice" name="position_work" type="text" id="edit-representativeCompany-positionWorks">
                <input class="m-1" id="edit-representativeCompany-id" name="id" type="hidden">
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Upravit" value="Upravit">
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<script src="<?= base_url('assets/js/validate-phone-input.js') ?>"></script>
<script src="<?= base_url('assets/js/validate-empty-input.js') ?>"></script>
<script src="<?= base_url('assets/js/validate-mail-input.js') ?>"></script>
<script src="<?= base_url('assets/js/validate-ico-input.js') ?>"></script>
<script>
const checkboxPasswdHidden = document.getElementById('checkbox-passwd-hidden');
const passwd1 = document.getElementById('passwd1');
const passwd2 = document.getElementById('passwd2');
checkboxPasswdHidden.addEventListener('change', function(){
  if(this.checked){
    passwd1.setAttribute('disabled', 'true');
    passwd2.setAttribute('disabled', 'true');
    passwd1.value = 'Heslo nezadáváte!'
    passwd2.value = 'Heslo nezadáváte!'
    passwd1.type = 'text';
    passwd2.type = 'text';
  }else{
    passwd1.removeAttribute('disabled');
    passwd2.removeAttribute('disabled');
    passwd1.value = ''
    passwd2.value = ''
    passwd1.type = 'password';
    passwd2.type = 'password';
  }
});
//editPassword
const checkboxEditPass = document.getElementById('checkboxEditPass');
const passwd1EditPass = document.getElementById('passwd1EditPass');
const passwd2EditPass = document.getElementById('passwd2EditPass');
checkboxEditPass.addEventListener('change', function(){
  if(this.checked){
    passwd1EditPass.setAttribute('disabled', 'true');
    passwd2EditPass.setAttribute('disabled', 'true');
    passwd1EditPass.value = 'Heslo nezadáváte!'
    passwd2EditPass.value = 'Heslo nezadáváte!'
    passwd1EditPass.type = 'text';
    passwd2EditPass.type = 'text';
  }else{
    passwd1EditPass.removeAttribute('disabled');
    passwd2EditPass.removeAttribute('disabled');
    passwd1EditPass.value = ''
    passwd2EditPass.value = ''
    passwd1EditPass.type = 'password';
    passwd2EditPass.type = 'password';
  }
});
//addRepresentativeCompany
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
document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalAddPractiseManager');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const companyId = button.getAttribute('data-companyId-practiseManager') || '';
        document.getElementById('add-practiseManager-companyId').value = companyId;
      }
    });
  }
});
document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalEditPasswordUser');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const id = button.getAttribute('data-id-passwordUser') || '';
        document.getElementById('edit-passwordUser-id').value = id;
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
        const companyId = button.getAttribute('data-companyId-representativeCompany') || '';
        document.getElementById('add-representativeCompany-companyId').value = companyId;
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
        const companyId = button.getAttribute('data-companyId-practiseManager') || '';
        document.getElementById('edit-practiseManager-id').value = id;
        document.getElementById('edit-practiseManager-degreeBefore').value = degreeBefore;
        document.getElementById('edit-practiseManager-name').value = name;
        document.getElementById('edit-practiseManager-surname').value = surname;
        document.getElementById('edit-practiseManager-degreeAfter').value = degreeAfter;
        document.getElementById('edit-practiseManager-mail').value = mail;
        document.getElementById('edit-practiseManager-phone').value = phone;
        document.getElementById('edit-practiseManager-positionWorks').value = positionWorks;
        document.getElementById('edit-practiseManager-companyId').value = companyId;
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
        const id = button.getAttribute('data-id-representativeCompany') || '';
        const degreeBefore = button.getAttribute('data-degreeBefore-representativeCompany') || '';
        const name = button.getAttribute('data-name-representativeCompany') || '';
        const surname = button.getAttribute('data-surname-representativeCompany') || '';
        const degreeAfter = button.getAttribute('data-degreeAfter-representativeCompany') || '';
        const mail = button.getAttribute('data-mail-representativeCompany') || '';
        const phone = button.getAttribute('data-phone-representativeCompany') || '';
        const positionWorks = button.getAttribute('data-positionWorks-representativeCompany') || '';
        document.getElementById('edit-representativeCompany-id').value = id;
        document.getElementById('edit-representativeCompany-degreeBefore').value = degreeBefore;
        document.getElementById('edit-representativeCompany-name').value = name;
        document.getElementById('edit-representativeCompany-surname').value = surname;
        document.getElementById('edit-representativeCompany-degreeAfter').value = degreeAfter;
        document.getElementById('edit-representativeCompany-mail').value = mail;
        document.getElementById('edit-representativeCompany-phone').value = phone;
        document.getElementById('edit-representativeCompany-positionWorks').value = positionWorks;
      }
    });
  }
});
document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalEditCompany');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const id = button.getAttribute('data-id-company') || '';
        const name = button.getAttribute('data-name-company') || '';
        document.getElementById('edit-company-id').value = id;
        document.getElementById('edit-company-name').value = name;
      }
    });
  }
});
</script>
<?= $this->endSection() ?>