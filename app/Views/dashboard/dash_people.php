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
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col" class="nowrap">ID</th>
                        <th scope="col">Jméno a příjmení</th>
                        <th scope="col">Rok ukončení studia</th>
                        <th scope="col">Třída</th>
                        <th scope="col">Obor</th>
                        <th scope="col">A</th>
                        <th scope="col">S</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php 
                    if(empty($users)){?>
                        <tr>
                            <td colspan="7" class="text-center">Nejsou načteni žádní uživatelé</td>
                        </tr>
                    <?php
                    }
                    foreach($users as $user){
                    ?>
                      <tr>
                        <th class="nowrap" scope="row"><?=$user['id'] ?></th>
                        <td>
                            <?= ($user['name'] ?? '') . ' ' . ($user['surname'] ?? '') ?>
                        </td>
                        <td><?= $user['class']['year_graduation']?? '' ?></td>
                        <td><?= ($user['class']['class']??''). '.' .($user['class']['letter_class']??''); ?></td>

                        <td><?= $user['field']['shortcut'] ?? ''?></td>
                        <td>
                            <input type="checkbox" name="admin[<?= $user['id'] ?>]" value="1" <?= $user['admin'] ? 'checked' : '' ?> />
                        </td>
                        <td>
                            <input type="checkbox" name="spravce[<?= $user['id'] ?>]" value="1" <?= $user['spravce'] ? 'checked' : '' ?> />
                        </td>
                    </tr>  
                    <?php }?>
                </tbody>
            </table>
            <?= $pager->links() ?>
        </div>
    </div>
</div>
<?php 
/*foreach($users as $user){
    echo (($user['name']??'') . ' -  ' . ($user['surname']??''));
    echo '<br>';
    echo $user['mail']??'';
    echo '<br>';
    echo 'admin' . $user['admin']??'';
    echo '<br>';
    if(!empty($user['class'])){
        echo (($user['class']['class']??''). '.' .($user['class']['letter_class']??''));
    echo '<br>';
    echo $user['field']['name']??'';
    echo '<br>';
    }
}*/
?>
<?= $this->endSection() ?>