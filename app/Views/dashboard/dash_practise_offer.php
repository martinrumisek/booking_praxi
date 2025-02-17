<?= $this->extend('layout/layout_dashboard_nav') ?>

<?= $this->section('content') ?>
<style>

</style>
<div class="d-flex flex-wrap justify-content-between">
<div class="m-4 d-flex flex-wrap align-items-center"><h5 class="m-1"><?php echo $practise['practise_name'];?></h5><p class="m-1"><?php echo '(';  $count = count($dates); foreach($dates as $date){echo date('d.m.Y', strtotime($date['date_date_from'])) . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])); if($count > 1){echo ' / '; $count--;}} echo ')';?></p></div>
<div class="m-4"><a href="">Přidat praxi</a></div>
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
                        <td><?php if(!empty($offer['user_name'])){echo $offer['user_name'] . ' ' . $offer['user_surname'] . ' (' . $offer['class_class'] . '.' . $offer['class_letter_class'] . ', ' . $offer['field_shortcut'] . ')';}else{echo '<i class="fa-solid fa-xmark"></i>' . ' ' . '<a href="#">Přiřadit</a>';} ?></td>
                        <td><div class="d-flex justify-content-center align-items-center"><a class="" href=""><i class="fa-solid fa-eye"></i></a><a class="" href=""><i class="fa-solid fa-pencil"></i></a><a class="" href=""><i class="fa-solid fa-trash"></i></a></div></td>
                    </tr>  
                    <?php }?>
                </tbody>
            </table>
        </div>
        <!----<div class="d-flex justify-content-center"><?=''// $pager->links() ?></div>--->
    </div>
<?= $this->endSection() ?>