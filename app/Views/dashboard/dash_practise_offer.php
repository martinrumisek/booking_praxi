<?= $this->extend('layout/layout_dashboard_nav') ?>

<?= $this->section('content') ?>
<style>
.icon-edit{
    margin-left: 2px;
    margin-right: 2px;
}
.icon-delete:hover{
    color: red;
}
.icon-repair:hover{
    color: gray;
}
.icon-show:hover{
    color: gray;
}
.btn-table-remove-user{
    margin-left: 5px;
    color: white;
    padding-left: 3px;
    padding-right: 3px;
    background-color: #006DBC;
    box-shadow: 0px 3px 6px #00000029;
    border-radius: 5px;
}
.btn-table-remove-user:hover{
    background-color: red;
    color: white;
}
.btn-add-practise{
    box-shadow: 0px 3px 6px #00000029;
    background-color: white;
    padding: 8px;
    border-radius: 8px; 
    color: black;
}
.btn-add-practise:hover{
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
    .btn-create:hover{
        background-color: #006DBC;
        color: white;
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
    .btn-export{
        height: 40px;
        margin-left: 5px;
        margin-right: 5px;
        padding: 10px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 30px;
    }
    .btn-export:hover{
        color:white;
        background-color: #006DBC;
    }
    .icon-export{
        padding-right: 5px;
    }
</style>
<div class="d-flex flex-wrap justify-content-between align-items-center">
  <div class="m-4 d-flex flex-wrap align-items-center"><h5 class="m-1"><?php echo $practise['practise_name'];?></h5><p class="m-1"><?php echo '(';  $count = count($dates); foreach($dates as $date){echo date('d.m.Y', strtotime($date['date_date_from'])) . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])); if($count > 1){echo ' / '; $count--;}} echo ')';?></p></div>
  <div class="m-4 d-flex align-items-center justify-content-center flex-wrap">
  <a class="btn-add-practise m-1" href="<?= base_url('/export-practise/'. $practise['practise_id']) ?>"><div class="d-flex justify-content-center align-items-center"><i class="fa-solid fa-file-excel icon-export"></i>Export</div></a>
  <a class="btn-add-practise m-1" data-bs-toggle="modal" data-bs-target="#modalAddCompanyNewOffer" data-id-practise-for-company=<?=$practise['practise_id']?> href="">Přidat praxi</a></div>
</div>
<div class="d-flex justify-content-between flex-wrap">
    <!--- Zde bude hledání -->
</div>
<div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">Název praxe</th>
                        <th scope="col">Vedoucí praxe</th>
                        <th scope="col">E-mail vedoucího</th>
                        <th scope="col">Tel. vedoucího</th>
                        <th scope="col">Firma  (ičo)</th>
                        <th scope="col">Přijmutý žák</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php 
                    if(empty($offers)){?>
                        <tr>
                            <td colspan="7" class="text-center">Není přidaná žádná praxe pro daný termín</td>
                        </tr>
                    <?php
                    }
                    foreach($offers as $offer){
                    ?>
                      <tr>
                        <td>
                            <?= $offer['offer_name']?>
                        </td>
                        <td><?php if(!empty($offer['manager_degree_before'])){echo $offer['manager_degree_before'] . ' ';} echo $offer['manager_name'] . ' ' . $offer['manager_surname']; if(!empty($offer['manager_degree_after'])){echo ' ' . $offer['manager_degree_after'] ;}?></td>
                        <td><?= $offer['manager_mail'] ?></td>
                        <td><?= $offer['manager_phone'] ?></td>
                        <td><?= $offer['company_name'] . ' (' . $offer['company_ico'] . ')'?></td>
                        <td><?php if(!empty($offer['user_name'])){echo $offer['user_name'] . ' ' . $offer['user_surname'] . ' (' . $offer['class_class'] . '.' . $offer['class_letter_class'] . ', ' . $offer['field_shortcut'] . ')'; echo '<a href="" data-bs-toggle="modal" data-bs-target="#modalRemoveUserOnPractise" data-id-student='. $offer['user_id'] .' data-id-offer='. $offer['offer_id'] .' class="btn-table-remove-user">Zrušit</a>';}else{echo '<i class="fa-solid fa-xmark"></i>' . ' ' . '<a data-bs-toggle="modal" data-bs-target="#modalAddUserOnPractise" data-id-offer-chooser='. $offer['offer_id'] . ' href="#">Přiřadit</a>';} ?></td>
                        <td><div class="d-flex justify-content-center align-items-center"><a class="icon-edit icon-show" href="<?=base_url('/practise-offer-view/'. $offer['offer_id'])?>"><i class="fa-solid fa-eye"></i></a><a class="icon-edit icon-repair" href="<?= base_url('/edit-practise-offer-view/'.$offer['offer_id']) ?>"><i class="fa-solid fa-pencil"></i></a><a class="icon-edit icon-delete" href="<?= base_url('/delete-practise-offer/'.$offer['offer_id']) ?>"><i class="fa-solid fa-trash"></i></a></div></td>
                    </tr>  
                    <?php }?>
                </tbody>
            </table>
        </div>
        <!----<div class="d-flex justify-content-center"><?=''// $pager->links() ?></div>--->
    </div>
  <!------ modal ---->
<div class="modal" id="modalRemoveUserOnPractise">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Zrušení praxe</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <p>Opravdu si přejete zrušit studentovi již domluvenou praxi?</p>
        <form action="<?= base_url('/remove-student-on-practise')?>" method="POST">
            <input type="hidden" name="offer_id" id="offer_id">
            <input type="hidden" name="student_id" id="student_id">
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Zrušit" value="ANO">
      </div>
      </form>
    </div>
  </div>
</div>
<!--- Modal --->
<div class="modal" id="modalAddUserOnPractise">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Vybrat praxi žákovi</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/add-user-accepted-offer-admin')?>" method="POST">
            <div class="container d-flex flex-column">
            <input type="hidden" name="offer_id" id="offer_id_chooser">
            <p>Vyberte žáka, kterému chcete přiřadit danou praxi.</p>
            <select name="user_id">
                <option value="" disabled selected>Vyberte žáka</option>
                <?php foreach($users as $user){ ?>
                    <option <?php if(!empty($user['user_offer_accepted'])){echo 'disabled';} ?> value="<?= $user['user_id'] ?>"><?= $user['user_name'] . ' ' . $user['user_surname']  . ' (' . $user['class_class'] . '.' . $user['class_letter_class'] . ') '?><?php if(!empty($user['user_offer_accepted'])){echo '- Žák praxi již má';}?></option>
                <?php } ?>
            </select>
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Vybrat" value="Vybrat">
      </div>
      </form>
    </div>
  </div>
</div>
<!--- Modal --->
<div class="modal" id="modalAddCompanyNewOffer">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Výběr firmy</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/add-offer-practise-admin')?>" method="POST">
            <div class="container d-flex flex-column">
            <input type="hidden" name="practise_id" id="practise_id_for_company">
            <p>Vyberte firmu, kde chcete přidat novou nabídku pro praxi</p>
            <select name="company_id">
                <option value="" disabled selected>Vyberte firmu</option>
                <?php foreach($companyes as $company){ ?>
                    <option value="<?= $company['company_id'] ?>"><?= $company['company_name'] . ' (' . $company['company_ico']  . ')' ?></option>
                <?php } ?>
            </select>
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Vybrat" value="Vybrat">
      </div>
      </form>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalAddCompanyNewOffer');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const offerId = button.getAttribute('data-id-practise-for-company') || '';
        document.getElementById('practise_id_for_company').value = offerId;
      }
    });
  }
});
    document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalRemoveUserOnPractise');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const userId = button.getAttribute('data-id-student') || '';
        const offerId = button.getAttribute('data-id-offer') || '';
        document.getElementById('student_id').value = userId;
        document.getElementById('offer_id').value = offerId;
      }
    });
  }
});
document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalAddUserOnPractise');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const offerId = button.getAttribute('data-id-offer-chooser') || '';
        document.getElementById('offer_id_chooser').value = offerId;
      }
    });
  }
});
</script>
<?= $this->endSection() ?>