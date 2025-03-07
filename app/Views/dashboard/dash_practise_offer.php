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
</style>
<div class="d-flex flex-wrap justify-content-between align-items-center">
<div class="m-4 d-flex flex-wrap align-items-center"><h5 class="m-1"><?php echo $practise['practise_name'];?></h5><p class="m-1"><?php echo '(';  $count = count($dates); foreach($dates as $date){echo date('d.m.Y', strtotime($date['date_date_from'])) . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])); if($count > 1){echo ' / '; $count--;}} echo ')';?></p></div>
<div class="m-4"><a class="btn-add-practise" href="">Přidat praxi</a></div>
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
                        <td><?php if(!empty($offer['user_name'])){echo $offer['user_name'] . ' ' . $offer['user_surname'] . ' (' . $offer['class_class'] . '.' . $offer['class_letter_class'] . ', ' . $offer['field_shortcut'] . ')'; echo '<a href="" class="btn-table-remove-user">Zrušit</a>';}else{echo '<i class="fa-solid fa-xmark"></i>' . ' ' . '<a href="#">Přiřadit</a>';} ?></td>
                        <td><div class="d-flex justify-content-center align-items-center"><a class="icon-edit icon-show" href="<?=base_url('/practise-offer-view/'. $offer['offer_id'])?>"><i class="fa-solid fa-eye"></i></a><a class="icon-edit icon-repair" href="<?= base_url('/edit-practise-offer-view/'.$offer['offer_id']) ?>"><i class="fa-solid fa-pencil"></i></a><a class="icon-edit icon-delete" href="<?= base_url('/delete-practise-offer/'.$offer['offer_id']) ?>"><i class="fa-solid fa-trash"></i></a></div></td>
                    </tr>  
                    <?php }?>
                </tbody>
            </table>
        </div>
        <!----<div class="d-flex justify-content-center"><?=''// $pager->links() ?></div>--->
    </div>
<?= $this->endSection() ?>