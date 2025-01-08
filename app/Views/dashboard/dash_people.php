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
    .modal-header{
      background-color: #006DBC;
      color: white;
      box-shadow: 0px 3px 6px #00000029;
    }
    .modal-footer{
      background-color: white;
      color: white;
      box-shadow: 0px 3px 6px #00000029;
      border-top: 1px solid #006DBC;
    }
    .btn-close-modal{
      background-color: #006DBC;
      color: white;
      border: none;
      border-radius: 100%;
    }
    .btn-close-modal:hover{
      color: red;
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
    <form action="" id="formSearch" method="GET">
    <div class="d-flex flex-wrap justify-content-between m-3">
            <div class="d-flex">
                <input class="search-input p-2 mt-2" name="search" id="search-input" type="text" placeholder="Vyhledat uživatele" <?php if(!empty($search)){?> value="<?= $search ?>" <?php } ?>>
                <button class="btn btn-search mt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="flex">
                <select class="search-input mt-2" id="orderSelect" name="oder">
                    <option <?php if(empty($oder)){?> selected <?php } ?> value="">Seřadit podle</option>
                    <option <?php if(!empty($oder) && $oder == 1){?> selected <?php } ?> value="1">Seřadit podle A-Z</option>
                    <option <?php if(!empty($oder) && $oder == 2){?> selected <?php } ?> value="2">Seřadit podle Z-A</option>
                    <option <?php if(!empty($oder) && $oder == 3){?> selected <?php } ?> value="3">Seřadit podle třídy (sestupně)</option>
                    <option <?php if(!empty($oder) && $oder == 4){?> selected <?php } ?> value="4">Seřadit podle třídy (vzestupně)</option>
                </select>
                </form>
                <a class="all-user" href="#modalLoadAllUser" data-bs-toggle="modal" data-bs-target="#modalLoadAllUser">Načíst uživatele</a>
            </div>
    </div>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col" class="nowrap"></th>
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
                        <th class="nowrap" scope="row"><?php if(!empty($user['class']['year_graduation'])){echo '<i class="fa-solid fa-user-graduate"></i>';}else{echo '<i class="fa-solid fa-chalkboard-user"></i>';} ?></th>
                        <td>
                            <?= ($user['name'] ?? '') . ' ' . ($user['surname'] ?? '') ?>
                        </td>
                        <td><?= $user['class']['year_graduation']?? '' ?></td>
                        <td><?php if(!empty($user['class']['class'])){ ?><?= ($user['class']['class']??''). '.' .($user['class']['letter_class']??''); }?></td>

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
<div class="modal" id="confirmModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Potvrzení změny</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
            <div class="container">
               <p>Opravdu chcete změnit práva tohoto uživatele?</p>
            </div>
      </div>
      <div class="modal-footer">
      <a class="all-user" href="#confirmModal" id="confirmChange">ANO</a>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal" id="modalLoadAllUser">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Načíst všechny uživatele z AZURE</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
            <div class="container">
               <p>Spustíte proces aktualizace uživatelů. Tento proces porovná aktuální data s novými informacemi a provede potřebné změny ve vaší databázi. Pokud dojde k nějakým změnám, budou uživatelské účty aktualizovány, přidány nové záznamy nebo odstraněni ti, kteří již nejsou relevantní. Tento proces může chvíli trvat v závislosti na počtu uživatelů.</p>
               <br>
               <p>Pokud chcete pokračovat, klikněte na „Aktualizovat“.</p>
            </div>
      </div>
      <div class="modal-footer">
      <a class="all-user" href="<?= base_url('azure-users') ?>">Aktualizovat</a>
      </div>
    </div>
  </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let userId, role, isChecked, checkboxToChange, otherCheckbox;

    document.querySelectorAll('.role-checkbox').forEach(checkbox => {
        checkbox.addEventListener('click', function (event) {
            userId = this.getAttribute('data-user-id');
            role = this.getAttribute('data-role');
            isChecked = this.checked;
            checkboxToChange = this; // Uchováme checkbox, který se změní.

            // Zabráníme okamžité změně stavu checkboxu.
            event.preventDefault();

            // Uložíme, jaký role checkbox byl vybrán a zda byl zaškrtnutý nebo ne
            let changes = {
                userId: userId,
                role: role,
                isChecked: isChecked
            };

            // Před zobrazením modalu ověříme, zda je třeba upravit druhý checkbox, ale ještě to neprovede
            if (role === 'admin' && isChecked) {
                // Pokud zaškrtneme admin, odškrtneme správce
                otherCheckbox = document.querySelector(`.role-checkbox[data-role="spravce"][data-user-id="${userId}"]`);
                if (otherCheckbox && otherCheckbox.checked) {
                    // Uložíme tuto změnu pro pozdější potvrzení
                    changes.otherCheckbox = otherCheckbox;
                }
            } else if (role === 'spravce' && isChecked) {
                // Pokud zaškrtneme správce, odškrtneme admin
                otherCheckbox = document.querySelector(`.role-checkbox[data-role="admin"][data-user-id="${userId}"]`);
                if (otherCheckbox && otherCheckbox.checked) {
                    // Uložíme tuto změnu pro pozdější potvrzení
                    changes.otherCheckbox = otherCheckbox;
                }
            }

            // Zobrazíme modal pro potvrzení změny
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            confirmModal.show();

            // Předání změn pro potvrzení
            document.getElementById('confirmChange').addEventListener('click', function () {
                // Zavřeme modal
                const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
                confirmModal.hide();

                // Po potvrzení změny provedeme změny
                // Nejprve provedeme změnu pro checkbox, na který klikl uživatel
                checkboxToChange.checked = changes.isChecked;

                // Pokud byly uloženy změny pro jiný checkbox, upravíme ho
                if (changes.otherCheckbox) {
                    changes.otherCheckbox.checked = false; // Změníme stav na odškrtnutý
                }

                // Odeslání požadavku na server pro změnu role
                fetch('<?=base_url('/sent-new-role-user')?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        user_id: changes.userId,
                        role: changes.role,
                        value: changes.isChecked ? 1 : 0
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Změna proběhla úspěšně.');
                        } else {
                            alert(data.error);
                            // Pokud došlo k chybě, vrátili bychom checkbox do původního stavu.
                            checkboxToChange.checked = !changes.isChecked;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });
});
document.getElementById('orderSelect').addEventListener('change', function () {
        document.getElementById('formSearch').submit();
    });
</script>
<?= $this->endSection() ?>