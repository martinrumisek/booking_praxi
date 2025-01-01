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
    .btn-create:hover{
        background-color: #006DBC;
        color: white;
    }
</style>
<div class="container-fluid">
    <h2 class="mt-2">Přehled firem</h2>
    <div class="d-flex flex-wrap justify-content-between m-3">
        <form action="" method="POST">
            <div class="d-flex">
                <input class="search-input p-2 mt-2" id="search-input" type="text" placeholder="Vyhledat uživatele">
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
                        <tr class="cursor-pointer" data-bs-toggle="collapse" data-bs-target="#company-<?= $company['id'] ?>">
                            <td><i class="fa-solid fa-building"></i> Firma</td>
                            <td class="name"><?= $company['name']?></td>
                            <td><?= $company['ico']?></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td><?= date('d.m.Y H:i:s', strtotime($company['create_time'])) ?></td>
                            <td><div class="d-flex"><a class="icon-edit" href="#modalEditCompany" data-bs-toggle="modal" data-bs-target="#modalEditCompany"><i class="fa-solid fa-pencil"></i></a><a class="icon-edit" href="#"><i class="fa-solid fa-eye"></i></a><a class="icon-edit" href="#"><i class="fa-solid fa-trash"></i></a></div></td>
                        </tr>
                        <?php foreach($company['representative'] as $representativeCompany){?>
                            <!-- Zde je potřeba přidat barvu, pro každé zastápce firmy, bude jiná barva řádku, firma = bíla, všechny zástupci firmy budou pod ní a budou mít světle šedou -->
                            <tr id="company-<?= $company['id'] ?>" class="collapse">
                                <td class="users"><i class="fa-solid fa-building-user"></i> Zást.</td>
                                <td class="users"><?php if(!empty($representativeCompany['degree_before'])){echo $representativeCompany['degree_before'] . ' ';}  echo $representativeCompany['name'] . ' ' . $representativeCompany['surname']; if(!empty($representativeCompany['degree_after'])){echo ' ' . $representativeCompany['degree_after'];} ?></td>
                                <td class="text-center users"></td>
                                <td class="users"><?= $representativeCompany['mail']?></td>
                                <td class="users"><?= $representativeCompany['phone']?></td>
                                <td class="users"><?= $representativeCompany['function']?></td>
                                <td class="users"><?= date('d.m.Y H:i:s', strtotime($representativeCompany['create_time'])) ?></td>
                                <td class="users"><div class="d-flex"><a class="icon-edit text-white" href="#modalEditRepresentativeCompany" data-bs-toggle="modal" data-bs-target="#modalEditRepresentativeCompany"><i class="fa-solid fa-pencil"></i></a><a class="icon-edit text-white" href="#"><i class="fa-solid fa-key"></i></a><a class="icon-edit text-white" href="#"><i class="fa-solid fa-trash"></i></a></div></td>
                            </tr>
                        <?php }?>
                        <?php if(empty($company['practiseManager'])){?>
                            <tr id="company-<?= $company['id'] ?>" class="collapse"><td class="practise-manager text-center" colspan="8">Žádný vedoucí pro praxe</td></tr>
                        <?php } ?>
                        <?php foreach($company['practiseManager'] as $practiseManager){ ?>
                            <tr id="company-<?= $company['id'] ?>" class="collapse">
                                <td class="practise-manager"><i class="fa-solid fa-user-tie"></i> Ved. praxe</td>
                                <td class="practise-manager"><?php if(!empty($practiseManager['degree_before'])){echo $practiseManager['degree_before'] . ' ';}  echo $practiseManager['name'] . ' ' . $practiseManager['surname']; if(!empty($practiseManager['degree_after'])){echo ' ' . $practiseManager['degree_after'];} ?></td>
                                <td class="practise-manager"></td>
                                <td class="practise-manager"><?= $practiseManager['mail'] ?></td>
                                <td class="practise-manager"><?= $practiseManager['phone'] ?></td>
                                <td class="practise-manager"><?= $practiseManager['position_works'] ?></td>
                                <td class="practise-manager"><?= date('d.m.Y H:i:s', strtotime($practiseManager['create_time'])) ?></td>
                                <td class="practise-manager"><div class="d-flex"><a class="icon-edit text-white" href="#modalEditPractiseManager" data-bs-toggle="modal" data-bs-target="#modalEditPractiseManager" data-id-practiseManager="<?= $practiseManager['id'] ?>" data-degreeBefore-practiseManager="<?= $practiseManager['degree_before'] ?>" data-name-practiseManager="<?= $practiseManager['name'] ?>" data-surname-practiseManager="<?= $practiseManager['surname'] ?>" data-degreeAfter-practiseManager="<?= $practiseManager['degree_after'] ?>" data-phone-practiseManager="<?= $practiseManager['phone'] ?>" data-mail-practiseManager="<?= $practiseManager['mail'] ?>" data-positionWorks-practiseManager="<?= $practiseManager['position_works'] ?>" data-companyId-practiseManager="<?= $practiseManager['Company_id'] ?>"><i class="fa-solid fa-pencil"></i></a><a class="icon-edit text-white" href="#"><i class="fa-solid fa-trash"></i></a></div></td>
                            </tr>
                        <?php } ?>
                            <tr id="company-<?= $company['id'] ?>" class="collapse">
                                <td colspan="8" class="add-user"><div class="d-flex justify-content-center flex-row flex-wrap"><a href="#modalAddPractiseManager" class="btn-add-user" data-bs-toggle="modal" data-bs-target="#modalAddPractiseManager" data-companyId-practiseManager="<?= $company['id'] ?>"><i class="fa-solid fa-user-plus"></i> Přidat vedoucího</a><a href="#modalAddRepresentativeCompany" class="btn-add-user" data-bs-toggle="modal" data-bs-target="#modalAddRepresentativeCompany"><i class="fa-solid fa-user-plus"></i> Přidat zástupce</a></div></td>
                            </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modaly pro editaci a přidávání -->
<div>
    <!-- přidání firmy -->
<div class="modal" id="modalAddCompany">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Přidat novou firmu</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('')?>" method="POST">
            <div class="container d-flex flex-column">
                
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
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Upravit firmu</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('')?>" method="POST">
            <div class="container d-flex flex-column">
                
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
            <div class="d-flex"><input class="m-1" type="text" name="degree_before" style="width: 20%;" placeholder="Titul před."><input class="m-1" type="text" name="name" style="width: 80%;" id="" placeholder="Jméno"></div>
            <div class="d-flex"><input type="text" class="m-1" name="surname" style="width: 80%;" placeholder="Příjmení"><input class="m-1" type="text" name="degree_after" style="width: 20%;" placeholder="Titul za"></div>
            <input type="mail" class="m-1" name="mail" placeholder="E-mail">
            <input class="m-1" placeholder="Tel. č" name="phone" type="tel">
            <input class="m-1" placeholder="Pracovní pozice" name="position_work" type="text">
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
                <div class="d-flex"><input id="edit-practiseManager-degreeBefore" class="m-1" type="text" name="degree_before" style="width: 20%;" placeholder="Titul před."><input class="m-1" type="text" name="name" style="width: 80%;" id="edit-practiseManager-name" placeholder="Jméno"></div>
                <div class="d-flex"><input type="text" class="m-1" name="surname" style="width: 80%;" placeholder="Příjmení" id="edit-practiseManager-surname"><input class="m-1" type="text" name="degree_after" style="width: 20%;" placeholder="Titul za" id="edit-practiseManager-degreeAfter"></div>
                <input type="mail" class="m-1" name="mail" placeholder="E-mail" id="edit-practiseManager-mail">
                <input class="m-1" placeholder="Tel. č" name="phone" type="tel" id="edit-practiseManager-phone">
                <input class="m-1" placeholder="Pracovní pozice" name="position_work" type="text" id="edit-practiseManager-positionWorks">
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
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Vytvořit zástupce pro firmu</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('')?>" method="POST">
            <div class="container d-flex flex-column">
                
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Uložit" value="Vytvořit">
      </div>
      </form>
    </div>
  </div>
</div>
    <!-- editace zást. pro firmu -->
<div class="modal" id="modalEditRepresentativeCompany">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Upravit zástupce firmy</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('')?>" method="POST">
            <div class="container d-flex flex-column">
                
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
<script>
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
</script>
<?= $this->endSection() ?>