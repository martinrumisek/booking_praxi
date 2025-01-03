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
</style>
<div class="container-fluid">
    <h2>Historie aktivity uživatelů</h2>
    <form action="" method="POST">
    <div class="d-flex flex-wrap justify-content-between m-3">
            <div class="d-flex">
                <input class="search-input p-2 mt-2" id="search-input" type="text" placeholder="Vyhledat uživatele">
                <button class="btn btn-search mt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div>
                <select class="search-input mt-2" id="">
                    <option selected disabled>Seřadit podle</option>
                    <option value="1">Od přihlášení po odhlášení</option>
                    <option value="2">Od odhlášení po přihlášení</option>
                    <option value="3">Datum sestupně</option>
                    <option value="4">Datum vzestupně</option>
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
                    </tr>
                </thead>
                <tbody class="table-group-divider" id="log-table">
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
                            <?= date('d.m.Y H:i:s', strtotime($log['create_time'])) ?>
                        </td>
                        <td><?= $log['user']['name'] . ' ' . $log['user']['surname']?></td>
                    </tr>  
                    <?php }?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center"><?= $pager->links() ?></div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const rows = document.querySelectorAll('#log-table tr');
    const storedValue = localStorage.getItem('searchValue');
    if (storedValue) {
        searchInput.value = storedValue;
        filterRows(storedValue);
    }
    searchInput.addEventListener('keyup', function () {
        const searchValue = this.value.toLowerCase();
        localStorage.setItem('searchValue', searchValue);
        filterRows(searchValue);
    });
    function filterRows(searchValue) {
        rows.forEach(row => {
            const nameCell = row.querySelector('td:nth-child(4)');
            if (nameCell) {
                const name = nameCell.textContent.toLowerCase();
                if (name.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }
});
</script>
<?= $this->endSection() ?>