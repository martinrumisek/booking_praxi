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
    tr{
        white-space: nowrap;
    }
</style>
<div class="container-fluid">
    <h2>Přehled termínů pro praxe</h2>
    <div class="d-flex m-3">
        <input class="search-input p-2 form-control" type="text" placeholder="Vyhledat">
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modalAddCategory">Přidat kategorii</button>
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modalAddSkill">Přidat dovednost</button>
    </div>
    <div class="container-fluid">
        <div class="table-responsive">
            <!-- Zde by měla být tabulka, která bude zobrazovat tabulku kategorií dovenosti a daný řádek půjde rozkliknout a pod tím se zobrazí dovenosti pro danou kategorii 
                
            JE POTŘEBA DODĚLAT (ZATÍM JENOM LEHKÉ ZOBRAZENÍ)
            -->
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col" class="nowrap">ID</th>
                        <th scope="col">Název</th>
                        <th scope="col">Přídáno</th>
                        <th scope="col">Upraveno</th>
                        <th scope="col">Akce</th>
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
                    <tr>
                        <th class="nowrap" scope="row"><?= $category['id']?></th>
                        <td><?= $category['name']?></td>
                        <td><?= $category['create_time']?></td>
                        <td><?= $category['edit_time']?></td>
                        <td><a href="<?=base_url('/delete-category-skill/'.$category['id'])?>">DEL</a></td>
                    </tr>
                    <?php
                    if(empty($category['skill'])){ ?>
                        <tr>
                        <td colspan="5" class="text-center">Zatím nebyli přidané žádné dovednosti do dané kategorie</td>
                    </tr>
                    <?php } 
                    foreach($category['skill'] as $skill){ ?>
                        <tr>
                        <th class="nowrap" scope="row"><?= $skill['id']?></th>
                        <td><?= $skill['name']?></td>
                        <td><?= $skill['create_time']?></td>
                        <td><?= $skill['edit_time']?></td>
                        <td><a href="<?=base_url('/delete-skill/'.$skill['id'])?>">DEL</a></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal" id="modalAddCategory">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Přidat novou kategorii</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="<?= base_url('/add-new-category')?>" method="POST">
            <input type="text" name="name" placeholder="Název kategorie">
            <textarea name="description" id=""></textarea>
            <input type="submit" placeholder="Odeslat">
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<div class="modal" id="modalAddSkill">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Přidat novou dovednost</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="<?= base_url('/add-new-skill')?>" method="POST">
            <input type="text" name="name" placeholder="Název dovednosti">
            <textarea name="description" id=""></textarea>
            <select class="form-select" name="category_id">
                <option>Vyberte možnost</option>
                <?php foreach($categoryes as $category){ ?>
                    <option value="<?= $category['id']?>"><?=$category['name']?></option>
                <?php } ?>
            </select>
            <input type="submit" placeholder="Odeslat">
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<?= $this->endSection() ?>