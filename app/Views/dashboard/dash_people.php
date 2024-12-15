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
                        <th scope="col" class="nowrap">ID</th>
                        <th scope="col">Jméno a příjmení</th>
                        <th scope="col">Rok ukončení studia</th>
                        <th scope="col">Třída</th>
                        <th scope="col">Obor</th>
                        <th scope="col">A</th>
                        <th scope="col">S</th>
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
                        <td>
                            <input type="checkbox" class="role-checkbox" data-role="admin" data-user-id="<?= $user['id']?>" <?= $user['admin'] ? 'checked' : '' ?> />
                        </td>
                        <td>
                            <input type="checkbox" class="role-checkbox" data-role="spravce" data-user-id="<?= $user['id']?>" <?= $user['spravce'] ? 'checked' : '' ?> />
                        </td>
                    </tr>  
                    <?php }?>
                </tbody>
            </table>
            <?= $pager->links() ?>
        </div>
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

    // Uloží data z kliknutého checkboxu
    document.querySelectorAll('.role-checkbox').forEach(checkbox => {
        checkbox.addEventListener('click', function () {
            userId = this.getAttribute('data-user-id');
            role = this.getAttribute('data-role');
            isChecked = this.checked;

            // Zobrazí modal pro potvrzení
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            confirmModal.show();
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                // Pokud je checkbox pro admin zaškrtnutý, automaticky odškrtneme správce a naopak
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
                    // Vrátí checkbox do původního stavu
                    document.querySelector(`.role-checkbox[data-user-id="${userId}"][data-role="${role}"]`).checked = !isChecked;
                }
            })
            .catch(error => console.error('Error:', error));
    });
});
</script>
<?= $this->endSection() ?>