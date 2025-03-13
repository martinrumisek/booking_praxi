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
    tr{
        white-space: nowrap;
    }
    body .table{
        background-color: black !important;
    }
    .btn-search{
        margin-left: 10px;
        border-radius: 100%;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .btn-search:hover{
        background-color: #006DBC;
        color: white;
    }
    td.name{
        min-width: 80px;
        max-width: 150px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
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
<div class="container-fluid">
    <h2>Historie aktivity uživatelů</h2>
    <form action="" method="GET" id="formSearch">
    <div class="d-flex flex-wrap justify-content-between m-3">
            <div class="d-flex">
                <input class="search-input p-2 mt-2" id="search-input" type="text" name="search" placeholder="Vyhledat uživatele" <?php if(!empty($search)){?> value="<?= $search ?>" <?php } ?>>
                <button class="btn btn-search mt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="d-flex align-items-center justify-content-center flex-wrap">
            <a class="mt-2 btn-export" href="<?= base_url('/export-log-company') ?>"><div class="d-flex justify-content-center align-items-center"><i class="fa-solid fa-file-excel icon-export"></i>Export</div></a>
                <select class="search-input mt-2" id="orderSelect" name="order">
                    <option <?php if(empty($order)){?> selected <?php } ?> disabled>Seřadit podle</option>
                    <option <?php if(!empty($order) && $order == 1){?> selected <?php } ?> value="1">Datum sestupně</option>
                    <option <?php if(!empty($order) && $order == 2){?> selected <?php } ?> value="2">Datum vzestupně</option>
                    <option <?php if(!empty($order) && $order == 3){?> selected <?php } ?> value="3">Od přihlášení po odhlášení</option>
                    <option <?php if(!empty($order) && $order == 4){?> selected <?php } ?> value="4">Od odhlášení po přihlášení</option>
                </select>
            </div>
    </div>
    </form>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class=" table table-sm table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="nowrap">Akce</th>
                        <th scope="col">IP</th>
                        <th scope="col">Provedeno</th>
                        <th scope="col">Uživatel</th>
                        <th scope="col">Firma</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider" id="log-table">
                    <?php 
                    if(empty($logs)){?>
                        <tr>
                            <td colspan="5" class="text-center">Nikdo nebyl v aplikaci ještě přihlášen</td>
                        </tr>
                    <?php
                    }
                    foreach($logs as $log){
                    ?>
                      <tr>
                        <th class="nowrap" scope="row"><?php if($log['log_company_name'] == 'Přihlášení'){echo '<i class="fa-solid fa-key"></i>  ';}else{echo '<i class="fa-solid fa-right-to-bracket"></i>  ';} ?><?= $log['log_company_name']?></th>
                        <td>
                            <?= $log['log_company_ip_adrese'] ?>
                        </td>
                        <td>
                            <?= date('d.m.Y H:i:s', strtotime($log['log_company_create_time'])) ?>
                        </td>
                        <td><?= $log['representative_name'] . ' ' . $log['representative_surname']?></td>
                        <td class="name"><?= $log['company_name']?></td>
                    </tr>  
                    <?php }?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center"><?= $pager->links() ?></div>
    </div>
</div>
<script>
document.getElementById('orderSelect').addEventListener('change', function () {
        document.getElementById('formSearch').submit();
    });
</script>
<?= $this->endSection() ?>