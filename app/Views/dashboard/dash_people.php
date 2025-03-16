<?= $this->extend('layout/layout_dashboard_nav') ?>

<?= $this->section('content') ?>
<style>
    .search-input{
        width: 280px;
        height: 40px;
        border: none;
        border-radius: 30px;
        background-color: white;
        color: black;
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
        width: 40px;
        height: 40px;
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
        height: 40px;
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
    input{
      border: none;
      height: 40px;
      padding: 8px;
      border-radius: 10px;
      background-color: white;
      box-shadow: 0px 3px 6px #00000029;
    }
    input:focus{
        border:1px solid #006DBC;
        outline: none;
    }
    input:disabled{
      box-shadow: 0px 1px 1px #00000029;
      color: #006DBC;
    }
    input.checkbox{
      background-color: transparent;
      box-shadow: none;
      height: auto;
      cursor:pointer;
    }
    input.checkbox:hover{
        border: 1px solid #006DBC;
    }
    .btn-create:hover{
        background-color: #006DBC;
        color: white;
    }
    .circle-icon{
        width: 50px;
        height: 50px;
        border-radius: 50px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .circle-icon:hover{
        border: 1px solid red;
    }
    .icon-link{
        color: #006DBC;
        text-decoration: underline ;
    }
    .invalid-input{
      border: 1px solid red;
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
    <h2>Přehled termínů pro praxe</h2>
    <form action="" id="formSearch" method="GET">
    <div class="d-flex flex-wrap justify-content-between m-3">
            <div class="d-flex">
                <input class="search-input p-2 mt-2" name="search" id="search-input" type="text" placeholder="Vyhledat uživatele" <?php if(!empty($search)){?> value="<?= $search ?>" <?php } ?>>
                <button class="btn btn-search mt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="d-flex flex-wrap align-items-center justify-content-center">
                <select class="search-input mt-2" id="orderSelect" name="oder">
                    <option <?php if(empty($oder)){?> selected <?php } ?> disabled value="">Seřadit podle</option>
                    <option <?php if(!empty($oder) && $oder == 1){?> selected <?php } ?> value="1">Seřadit podle A-Z</option>
                    <option <?php if(!empty($oder) && $oder == 2){?> selected <?php } ?> value="2">Seřadit podle Z-A</option>
                    <option <?php if(!empty($oder) && $oder == 3){?> selected <?php } ?> value="3">Seřadit podle třídy (sestupně)</option>
                    <option <?php if(!empty($oder) && $oder == 4){?> selected <?php } ?> value="4">Seřadit podle třídy (vzestupně)</option>
                    <option <?php if(!empty($oder) && $oder == 5){?> selected <?php } ?> value="5">Zobrazit první admin a správce</option>
                </select>
                </form>
                <a class="mt-2 btn-export" href="<?= base_url('/export-user') ?>"><div class="d-flex justify-content-center align-items-center"><i class="fa-solid fa-file-excel icon-export"></i>Export</div></a>
                <?php $role = session()->get('role'); if (!empty($role) && in_array('admin', $role)){ ?>
                <a class="all-user mt-2" href="#modalLoadAllUser" data-bs-toggle="modal" data-bs-target="#modalLoadAllUser"><i class="fa-solid fa-spinner"></i> Načíst uživatele</a>
                <?php } ?>
                <a class="all-user mt-2" href="#modalSocialLink" data-bs-toggle="modal" data-bs-target="#modalSocialLink"><i class="fa-solid fa-icons"></i> Sociální sítě</a>
                <?php $role = session()->get('role'); if (!empty($role) && in_array('admin', $role)){ ?>
                <a class="all-user mt-2" href="<?= base_url('/dashboard-class') ?>"><i class="fa-solid fa-people-roof"></i> Upravit třídy</a>
                <?php } ?>
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
                        <?php $role = session()->get('role'); if (!empty($role) && in_array('admin', $role)){ ?>
                        <th scope="col">A</th>
                        <th scope="col">S</th>
                        <?php } ?>
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
                        <th class="nowrap" scope="row"><?php if(!empty($user['class_year_graduation'])){echo '<i class="fa-solid fa-user-graduate"></i>';}else{echo '<i class="fa-solid fa-chalkboard-user"></i>';} ?></th>
                        <td>
                            <?= ($user['user_name'] ?? '') . ' ' . ($user['user_surname'] ?? '') ?>
                        </td>
                        <td><?= $user['class_year_graduation']?? '' ?></td>
                        <td><?php if(!empty($user['class_class'])){ ?><?= ($user['class_class']??''). '.' .($user['class_letter_class']??''); }?></td>

                        <td><?= $user['field_shortcut'] ?? ''?></td>
                        <?php $role = session()->get('role'); if (!empty($role) && in_array('admin', $role)){ ?>
                        <td>
                            <input type="checkbox" class="role-checkbox checkbox" data-role="admin" data-user-id="<?= $user['user_id']?>" <?php if($user['user_admin'] == 1){echo 'checked';}?> <?php if($user['user_admin'] == 1){if($countAdmin <= 1){echo 'disabled';}}?> />
                        </td>
                        <td>
                            <input type="checkbox" class="role-checkbox checkbox" data-role="spravce" data-user-id="<?= $user['user_id']?>" <?= $user['user_spravce'] ? 'checked' : '' ?> />
                        </td>
                        <?php } ?>
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
<!-- Modal pro úpravu sociálních sítí -->
<div class="modal" id="modalSocialLink">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Správa sociálních sítích</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
      <form action="<?= base_url('/new-social-link') ?>" method="POST">
            <div class="container d-flex flex-column">
                <div class="d-flex justify-content-end">Počet linků: <?= $countLinks ?>/8</div>
                <label class="mt-1" for="name">Název sociální sítě</label>
                <input <?php if($countLinks == 8){ ?> disabled <?php } ?> class="m-1" type="text" id="edit-SocialLink-name" name="name" placeholder="Např.: Instagram">
                <label class="mt-1" for="name">Ikonka * (nutné vyplnit)</label>
                <input <?php if($countLinks == 8){ ?> disabled <?php } ?> class="m-1 empty-input" type="text" id="edit-SocialLink-name" name="icon_name" placeholder="Např.: <i class=''fa-brands fa-instagram''></i>">
                <div><p>Ikonku, kterou je potřeba použít naleznete <a class="icon-link" target="_blank" href="https://fontawesome.com/v6/search?o=r&m=free">zde</a></p></div>
                <div class="d-flex justify-content-end mt-2"><input class="btn-create" type="submit" placeholder="Uložit" value="Vytvořit"></div>
            </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center align-items-center flex-wrap">
        <?php if(empty($links)){?> <div class="d-flex justify-content-center align-items-center text-black"><p>Nejsou žádné sociální sítě přidané</p></div>  <?php }else{ foreach($links as $link){ ?>
                <div class="d-flex align-items-center">
                    <a href="<?= base_url('/delete-social-link/'.$link['social_id']) ?>"><div class="circle-icon d-flex justify-content-center align-items-center m-2 text-black h4"><?= $link['social_icon'] ?></div></a>
                </div>
            <?php }} ?>
      </div>
    </div>
  </div>
</div>
</div>
<script src="<?= base_url('assets/js/validate-empty-input.js') ?>"></script>
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