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
                        <td>fce</td>
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
                        <td>fce</td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>