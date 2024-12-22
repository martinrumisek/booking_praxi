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
    <h2>Historie přihlášených uživatelů</h2>
    <div class="d-flex m-3">
        <input class="search-input p-2 form-control" type="text" placeholder="Vyhledat">
    </div>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col" class="nowrap">Akce</th>
                        <th scope="col">IP</th>
                        <th scope="col">Provedeno</th>
                        <th scope="col">Uživatel</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php 
                    if(empty($logs)){?>
                        <tr>
                            <td colspan="7" class="text-center">Nikdo nebyl v aplikaci ještě přihlášen</td>
                        </tr>
                    <?php
                    }
                    foreach($logs as $log){
                    ?>
                      <tr>
                        <th class="nowrap" scope="row"><?php if($log['name'] == 'Přihlášení'){echo '<i class="fa-solid fa-key"></i>  ';}else{echo '<i class="fa-solid fa-right-to-bracket"></i>  ';} ?><?= $log['name']?></th>
                        <td>
                            <?= $log['ip_adrese'] ?>
                        </td>
                        <td>
                            <?= date('d.m.Y H:m:s', strtotime($log['create_time'])) ?>
                        </td>
                        <td><?= $log['user']['name'] . ' ' . $log['user']['surname']?><?php if(!empty($log['user']['Company_id'])){echo ' (firma)';} ?></td>
                    </tr>  
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>