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
                        <th scope="col" class="nowrap">Název praxe</th>
                        <th scope="col">Termín/y</th>
                        <th scope="col">Pro třídy</th>
                        <th scope="col">Nabídky do</th>
                        <th scope="col">Smlouva</th>
                        <th scope="col">Vytvořeno/upraveno</th>
                        <th scope="col">Upravit</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php 
                    if(empty($practises)){?>
                        <tr>
                            <td colspan="7" class="text-center">Nejsou zadané žádné termíny pro praxe.</td>
                        </tr>
                    <?php
                    }
                    foreach($practises as $practise){
                    ?>
                      <tr>
                        <th class="nowrap" scope="row"><?= $practise['name']?></th>
                        <td>
                            <?php $countDate = count($practise['dates']); foreach($practise['dates'] as $date){ 
                                echo date('d.m.Y', strtotime($date['date_from'])).' - '.date('d.m.Y', strtotime($date['date_to']));
                                $countDate = $countDate - 1;
                                if($countDate > 0){
                                    echo '/';
                                }
                            }?>
                        </td>
                        <td>
                            <?php $countClass = count($practise['class']); foreach($practise['class'] as $class){
                                echo $class['class'].'.'.$class['letter_class'];
                                $countClass = $countClass - 1;
                                if($countClass > 0){
                                    echo ',';
                                }
                            } ?>
                        </td>
                        <td><?= date('d.m.Y', strtotime($practise['end_new_offer']))?></td>
                        <?php if(empty($practise['contract_file'])){ ?>
                            <td><i class="fa-solid fa-circle-xmark"></i></td>
                        <?php }else{ ?>
                            <td><i class="fa-regular fa-circle-check"></i></td>
                        <?php } ?>

                        <td><?= date('d.m.Y H:i', strtotime($practise['edit_time']))?></td>
                        <td>
                            <div class="d-flex">
                                <a href="#"><i class="fa-solid fa-pencil"></i></a>
                                <a href="#"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>  
                    <?php }?>
                    <tr>
                        <td colspan="7" ><a href="#"><i class="fa-solid fa-plus"></i> Přidat nový termín pro praxi</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>