<?= $this->extend('layout/layout_nav') ?>

<?= $this->section('content') ?>
<style>
.no-user-practise{
    border-bottom: 0.5px solid red;
}
.user-has-practise{
    border-bottom: 0.5px solid green;
}
</style>
<h3 class="m-3">Žáci na praxi (<?= $class['class_class'] . '.' . $class['class_letter_class'] ?>)</h3>
<div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col" class="nowrap"></th>
                        <th scope="col">Jméno a příjmení</th>
                        <th scope="col">Název praxe</th>
                        <th scope="col">Vedoucí praxe</th>
                        <th scope="col">E-mail vedoucího</th>
                        <th scope="col">Tel. vedoucího</th>
                        <th scope="col">Firma (ičo)</th>
                        <th scope="col">Místo konání</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php 
                    if(empty($users)){?>
                        <tr>
                            <td colspan="8" class="text-center">Nejsou načteni žádní uživatelé</td>
                        </tr>
                    <?php
                    }
                    foreach($users as $user){
                    ?>
                      <tr>
                        <th class="nowrap" scope="row"><i class="fa-solid fa-user-graduate"></i></th>
                        <td class="fw-bold">
                            <?= ($user['user_name'] ?? '') . ' ' . ($user['user_surname'] ?? '') ?>
                        </td>
                        <?php if(empty($user['user_offer_accepted']) || $user['user_offer_accepted'] == null){ ?>
                        <td class="text-center no-user-practise fw-bold" colspan="6">Žák nemá ještě potvrzenou praxi</td>
                        <?php }else{ ?>
                        <td class="user-has-practise"><?= $user['offer_name'] ?></td>
                        <td class="user-has-practise"><?php if(!empty($user['manager_degree_before'])){echo $user['manager_degree_before'] . ' ';} echo $user['manager_name'] . ' ' . $user['manager_surname']; if(!empty($user['manager_degree_after'])){echo $user['manager_degree_after'];} ?></td>
                        <td class="user-has-practise"><?= $user['manager_mail'] ?></td>
                        <td class="user-has-practise"><?= $user['manager_phone'] ?></td>
                        <td class="user-has-practise"><?= $user['company_name'] . ' (' . $user['company_ico'] . ')' ?></td>
                        <td class="user-has-practise"><?= $user['offer_post_code'] . '  ' . $user['offer_city'] . ', ' . $user['offer_street'] ?></td>
                        <?php } ?>
                    </tr>  
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>