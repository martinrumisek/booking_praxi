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
    .all-user{
        margin-left: 5px;
        margin-right: 5px;
        padding: 10px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 30px;
    }
    .all-user:hover{
        color:white;
        background-color: #006DBC;
    }
</style>
<div class="container-fluid">
    <h2>Přehled termínů pro praxe</h2>
    <form action="" method="POST">
    <div class="d-flex flex-wrap justify-content-between m-3">
            <div class="d-flex">
                <input class="search-input p-2 mt-2" id="search-input" type="text" placeholder="Vyhledat uživatele">
                <button class="btn btn-search mt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="flex">
                <select class="search-input mt-2" id="">
                    <option selected disabled>Seřadit podle</option>
                    <option value="1">Od přihlášení po odhlášení</option>
                    <option value="2">Od odhlášení po přihlášení</option>
                    <option value="3">Datum sestupně</option>
                    <option value="4">Datum vzestupně</option>
                </select>
                </form>
                <a class="all-user" href="<?= base_url('/azure-users') ?>">Načíst uživatele</a>
            </div>
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
                        <?php // if (!empty(session()->get('role')) && in_array('admin', session()->get('role'))): ?>
                        <th scope="col">A</th>
                        <th scope="col">S</th>
                        <?php // endif; ?>
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
                        <?php // $role = session()->get('role'); if (!empty($role) && in_array('admin', $role)): ?>
                        <td>
                            <input type="checkbox" class="role-checkbox" data-role="admin" data-user-id="<?= $user['id']?>" <?= $user['admin'] ? 'checked' : '' ?> />
                        </td>
                        <td>
                            <input type="checkbox" class="role-checkbox" data-role="spravce" data-user-id="<?= $user['id']?>" <?= $user['spravce'] ? 'checked' : '' ?> />
                        </td>
                        <?php // endif;?>
                    </tr>  
                    <?php }?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center"><?= $pager->links() ?></div>
    </div>
</div>
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Potvrzení změny</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
            </div>
            <div class="modal-body">
                Opravdu chcete změnit práva tohoto uživatele?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelChange">Ne</button>
                <button type="button" id="confirmChange" class="btn btn-primary">Ano</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    let userId, role, isChecked;
    document.querySelectorAll('.role-checkbox').forEach(checkbox => {
        checkbox.addEventListener('click', function () {
            userId = this.getAttribute('data-user-id');
            role = this.getAttribute('data-role');
            isChecked = this.checked;
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            confirmModal.show();
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                if (role === 'admin') {
                    const spravceCheckbox = document.querySelector(`.role-checkbox[data-role="spravce"][data-user-id="${userId}"]`);
                    if (spravceCheckbox) {
                        spravceCheckbox.checked = false;
                    }
                } else if (role === 'spravce') {
                    const adminCheckbox = document.querySelector(`.role-checkbox[data-role="admin"][data-user-id="${userId}"]`);
                    if (adminCheckbox) {
                        adminCheckbox.checked = false;
                    }
                }
            }
            });
        });
    });
    document.getElementById('confirmChange').addEventListener('click', function () {
        const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        confirmModal.hide();
        fetch('<?=base_url('/sent-new-role-user')?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
                user_id: userId,
                role: role,
                value: isChecked ? 1 : 0
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Změna proběhla úspěšně.');
                } else {
                    alert(data.error);
                    document.querySelector(`.role-checkbox[data-user-id="${userId}"][data-role="${role}"]`).checked = !isChecked;
                }
            })
            .catch(error => console.error('Error:', error));
    });
});
</script>
<?= $this->endSection() ?>