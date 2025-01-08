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
    .btn-search{
        margin-left: 10px;
        border-radius: 100%;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .btn-add-skill{
        margin-left: 10px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        border: none;
        padding: 10px;
    }
    .btn-add-categorySkill{
        margin-left: 10px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        border: none;
        padding: 10px;
    }
    .btn-add-skill:hover{
        background-color: #006DBC;
        color: white;
    }
    .btn-add-categorySkill:hover{
        background-color: #006DBC;
        color: white;
    }
    .btn-search:hover{
        background-color: #006DBC;
        color: white;
    }
    td.skill{
        background-color: #006DBC;
        color: white;
    }
    th.skill{
        background-color: #006DBC;
        color: white;
        padding-left: 10px;
    }
    tr{
        white-space: nowrap;
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
    .del-icon-category{
      color: black;
    }
    .del-icon-skill{
      color: white;
    }
    .del-icon-category:hover{
      color: red;
    }
    .del-icon-skill:hover{
      color: red;
    }
    .edit-icon-category{
      color: black;
      margin-left: 8px;
    }
    .edit-icon-skill{
      color:white;
      margin-left: 8px;
    }
    .edit-icon-category:hover{
      color: gray;
    }
    .edit-icon-skill:hover{
      color: gray;
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
</style>
<div class="container-fluid">
    <h2 class="mt-2">Přehled dovedností</h2>
    <div class="d-flex flex-wrap justify-content-between m-3">
    <form action="" method="get">    
    <div class="d-flex">
          <input class="search-input p-2 mt-2" type="text" name="search" placeholder="Vyhledat" <?php if(!empty($search)){?> value="<?= $search ?>" <?php } ?>>
          <button class="btn btn-search mt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        </form>
        <div class="d-flex">
          <button type="button" class="btn-add-skill mt-2" data-bs-toggle="modal" data-bs-target="#modalAddCategory">Přidat kategorii</button>
          <button type="button" class="btn-add-categorySkill mt-2" data-bs-toggle="modal" data-bs-target="#modalAddSkill">Přidat dovednost</button>
        </div>
    </div>
    <div class="container-fluid">
        <div class="table-responsive">
            <!-- Zde by měla být tabulka, která bude zobrazovat tabulku kategorií dovenosti a daný řádek půjde rozkliknout a pod tím se zobrazí dovenosti pro danou kategorii 
                
            JE POTŘEBA DODĚLAT (ZATÍM JENOM LEHKÉ ZOBRAZENÍ)
            -->
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col" class="nowrap"></th>
                        <th scope="col">Název</th>
                        <th scope="col">Přídáno</th>
                        <th scope="col">Upraveno</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php 
                    if(empty($categoryes)){?>
                        <tr>
                            <td colspan="5" class="text-center">Zatím nejsou přidané žádné kategorie pro dovednosti</td>
                        </tr>
                    <?php
                    }
                    foreach($categoryes as $category){
                    ?>
                    <tr <?php if(!empty($category['description'])){ ?> data-bs-toggle="tooltip" title="<?= $category['description'] ?>" <?php } ?>>
                        <th class="nowrap" scope="row"><i class="fa-solid fa-folder-closed"></i></th>
                        <td><?= $category['name']?></td>
                        <td><?= date('d.m.Y H:i:s', strtotime($category['create_time'])) ?></td>
                        <td><?= date('d.m.Y H:i:s', strtotime($category['edit_time'])) ?></td>
                        <td><a href="<?=base_url('/delete-category-skill/'.$category['id'])?>"><i class="fa-solid fa-trash del-icon-category"></i></a><a href="#modalEditCategory"  data-bs-toggle="modal" data-bs-target="#modalEditCategory" data-id-category="<?= $category['id']?>" data-name-category="<?= $category['name']?>" data-description-category="<?= $category['description']?>"><i class="fa-solid fa-pencil edit-icon-category"></i></a></td>
                    </tr>
                    <?php
                    if(empty($category['skill'])){ ?>
                        <tr>
                        <td colspan="5" class="text-center skill">Zatím nebyli přidané žádné dovednosti do dané kategorie</td>
                    </tr>
                    <?php } 
                    foreach($category['skill'] as $skill){ ?>
                        <tr <?php if(!empty($skill['description'])){ ?> data-bs-toggle="tooltip" title="<?= $skill['description'] ?>" <?php } ?>>
                        <th class="nowrap skill" scope="row"><i class="fa-regular fa-file"></i></th>
                        <td class="skill"><?= $skill['name']?></td>
                        <td class="skill"><?= date('d.m.Y H:i:s', strtotime($skill['create_time'])) ?></td>
                        <td class="skill"><?= date('d.m.Y H:i:s', strtotime($skill['edit_time'])) ?></td>
                        <td class="skill"><a href="<?=base_url('/delete-skill/'.$skill['id'])?>"><i class="fa-solid fa-trash del-icon-skill"></i></a><a href="#modalEditSkill"  data-bs-toggle="modal" data-bs-target="#modalEditSkill" data-id-skill="<?= $skill['id']?>" data-name-skill="<?= $skill['name']?>" data-description-skill="<?= $skill['description']?>" data-categoryId-skill="<?= $skill['Category_skill_id'] ?>"><i class="fa-solid fa-pencil edit-icon-skill"></i></a></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center"><?= $pager->links() ?></div>
    </div>
</div>
<!-- Modal pro přidávání kategorií dovedností -->
<div class="modal" id="modalAddCategory">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Přidat novou kategorii</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/add-new-category')?>" method="POST">
            <div class="container d-flex flex-column">
              <input type="text" name="name" placeholder="Název kategorie">
              <br>
              <textarea name="description" placeholder="Poznámka" id=""></textarea>
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-add-skill" type="submit" placeholder="Uložit" value="Uložit">
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal pro přidávání dovedností -->
<div class="modal" id="modalAddSkill">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Přidat novou dovednost</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/add-new-skill')?>" method="POST">
            <div class="container d-flex flex-column">
              <input type="text" name="name" placeholder="Název dovednosti">
              <br>
              <textarea name="description" placeholder="Poznámky" id=""></textarea>
              <br>
              <select class="form-select" name="category_id">
                  <option>Vyberte možnost</option>
                  <?php foreach($categoryes as $category){ ?>
                      <option value="<?= $category['id']?>"><?=$category['name']?></option>
                  <?php } ?>
              </select>
            </div>
      </div>
      <div class="modal-footer">
      <input class="btn-add-skill" type="submit" placeholder="Uložit" value="Uložit">
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal pro editaci kategorií dovedností -->
<div class="modal" id="modalEditCategory">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Přidat novou kategorii</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/edit-category')?>" method="POST">
            <div class="container d-flex flex-column">
              <input type="hidden" name="id" id="edit-category-id">
              <input type="text" id="edit-category-name" name="name" placeholder="Název kategorie">
              <br>
              <textarea name="description" id="edit-category-description" placeholder="Poznámka" id=""></textarea>
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-add-skill" type="submit" placeholder="Upravit" value="Upravit">
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal pro editaci dovedností -->
<div class="modal" id="modalEditSkill">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Přidat novou dovednost</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/edit-skill')?>" method="POST">
            <div class="container d-flex flex-column">
              <input type="hidden" name="id" id="edit-skill-id">
              <input type="text" id="edit-skill-name" name="name" placeholder="Název dovednosti">
              <br>
              <textarea name="description" id="edit-skill-description" placeholder="Poznámky" id=""></textarea>
              <br>
              <select class="form-select" id="edit-skill-categoryId" name="category_id">
                  <option>Vyberte možnost</option>
                  <?php foreach($categoryes as $category){ ?>
                      <option value="<?= $category['id']?>"><?=$category['name']?></option>
                  <?php } ?>
              </select>
            </div>
      </div>
      <div class="modal-footer">
      <input class="btn-add-skill" type="submit" placeholder="Upravit" value="Upravit">
      </div>
      </form>
    </div>
  </div>
</div>
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
});

document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalEditCategory');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const categoryId = button.getAttribute('data-id-category') || '';
        const categoryName = button.getAttribute('data-name-category') || '';
        const categoryDescription = button.getAttribute('data-description-category') || '';
        document.getElementById('edit-category-id').value = categoryId;
        document.getElementById('edit-category-name').value = categoryName;
        document.getElementById('edit-category-description').value = categoryDescription;
      }
    });
  }
});
document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalEditSkill');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const skillId = button.getAttribute('data-id-skill') || '';
        const skillName = button.getAttribute('data-name-skill') || '';
        const skillDescription = button.getAttribute('data-description-skill') || '';
        const skillCategoryId = button.getAttribute('data-categoryId-skill') || '';
        document.getElementById('edit-skill-id').value = skillId;
        document.getElementById('edit-skill-name').value = skillName;
        document.getElementById('edit-skill-description').value = skillDescription;
        document.getElementById('edit-skill-categoryId').value = skillCategoryId;
      }
    });
  }
});

</script>
<?= $this->endSection() ?>