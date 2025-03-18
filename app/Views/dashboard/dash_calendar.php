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
    .btn-search:hover{
        background-color: #006DBC;
        color: white;
    }
    .btn-search{
        margin-left: 10px;
        border-radius: 100%;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    tr{
        white-space: nowrap;
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
    }
    .btn-add-date{
        margin-left: 10px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .btn-add-date:hover{
        background-color:#006DBC;
        color: white;
    }
    textarea{
      height: 200px;
      resize: none;
      overflow: auto;
      border-radius: 10px;
      background-color: white;
      border: none;
      box-shadow: 0px 3px 6px #00000029;
      padding: 8px;
    }
    textarea:focus{
        border:1px solid #006DBC;
        outline: none;
    }
    .btn-create:hover{
        background-color: #006DBC;
        color: white;
    }
    .text-add-date:hover{
     color: #006DBC;   
    }
    input.checkbox{
      background-color: transparent;
      box-shadow: none;
      height: auto;
    }
    input#file-upload-button{
        background-color: white;
    }

    .custom-file-input {
    opacity: 0; /* Skryje skutečný vstup */
    position: absolute;
    z-index: -1;
}

.custom-file-label {
    display: inline-block;
    height: 40px;
    padding: 10px 20px;
    background-color: white;
    color: black;
    border-radius: 10px;
    cursor: pointer;
    border: none;
    box-shadow: 0px 3px 6px #00000029;
}

.custom-file-label:hover {
    color:#006DBC;
    border: 1px solid #006DBC;
}
td.date{
    background-color: #006DBC;
    color: white;
}
th.date{
    background-color: #006DBC;
    color: white;
}
.view-document{
    padding: 2px;
    border-radius: 8px;
    box-shadow: 0px 3px 6px #00000029;
}
.view-document:hover{
    background-color: #006DBC;
    color:white;
}
.btn-remove-date{
    color: red;
    background-color: white;
    border: none;
}
.icon-del{
    padding-left: 3px;
    padding-right: 3px;
}
.icon-edit{
    padding-left: 3px;
    padding-right: 3px;
}
.icon-edit:hover{
    color: gray;
}
.icon-del:hover{
    color:red;
}
.add-next-date{
    border: 1px solid #006DBC;
    border-radius: 10px;
    padding-left: 6px;
    padding-right: 6px;
}
.add-next-date:hover{
    background-color: #006DBC;
    color: white;
}
.invalid-input{
      border: 1px solid red;
    }
</style>
<div class="container-fluid">
    <h2>Přehled termínů pro praxe</h2>
    <div class="d-flex flex-wrap justify-content-between m-3">
        <form action="" method="GET">
            <div class="d-flex">
                <input class="search-input p-2 mt-2" id="search-input" name="search" type="text" placeholder="Vyhledat termín" <?php if(!empty($search)){?> value="<?= $search ?>" <?php } ?>>
                <button class="btn btn-search mt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
            <div class="d-flex">
                <button class="btn btn-add-date mt-2"  data-bs-toggle="modal" data-bs-target="#modalAddNewPractiseDate"><i class="fa-solid fa-circle-plus"></i> Přidat datum praxe</button>
            </div>
    </div>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col" class="nowrap">Název praxe</th>
                        <th scope="col"></th>
                        <th scope="col">Pro třídy</th>
                        <th scope="col">Nabídky do</th>
                        <th scope="col">Smlouva</th>
                        <th scope="col">Vytvořeno/upraveno</th>
                        <th scope="col"></th>
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
                        <th class="nowrap" scope="row"><?= $practise['practise_name']?></th>
                        <td></td>
                        <td>
                            <?php $countClass = count($practise['class']); foreach($practise['class'] as $class){
                                echo $class['class_class'].'.'.$class['class_letter_class'];
                                $countClass = $countClass - 1;
                                if($countClass > 0){
                                    echo ', ';
                                }
                            } ?>
                        </td>
                        <td><?= date('d.m.Y', strtotime($practise['practise_end_new_offer']))?></td>
                        <?php if(empty($practise['practise_contract_file'])){ ?>
                            <td><i class="fa-solid fa-circle-xmark"></i></td>
                        <?php }else{ ?>
                            <td><i class="fa-regular fa-circle-check"></i> <a class="view-document" target="_blank" href="<?= base_url('assets/document/'.$practise['practise_contract_file']) ?>">zobrazit</a></td>
                        <?php } ?>

                        <td><?= date('d.m.Y H:i', strtotime($practise['practise_edit_time']))?></td>
                        <td>
                            <div class="d-flex">
                                <?php $countDateAtribut = count($practise['dates']) ?>
                                <a class="icon-edit" href="#modalAddNewPractiseDate" data-bs-toggle="modal" data-bs-target="#modalEditPractiseDate" data-id-datePractise="<?= $practise['practise_id'] ?>" data-name-datePractise="<?= $practise['practise_name'] ?>" data-class-datePractise="<?= htmlspecialchars(json_encode($practise['class'])) ?>" data-endOffer-datePractise="<?= $practise['practise_end_new_offer'] ?>" data-file-datePractise="<?= $practise['practise_contract_file'] ?>" data-description-datePractise="<?= $practise['practise_description'] ?>" ><i class="fa-solid fa-pencil"></i></a>
                                <a class="icon-del" href="<?= base_url('/delete-practise/'.$practise['practise_id']) ?>"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr> 
                    <?php $countDate = 1; foreach($practise['dates'] as $date){?>
                        <tr>
                        <th class="nowprap date"><i class="fa-solid fa-calendar-day"></i> Termín <?= $countDate  ?></th>
                        <td class="date" colspan="4"><?= date('d.m.Y', strtotime($date['date_date_from'])).' - '.date('d.m.Y', strtotime($date['date_date_to']))?></td>
                        <td class="date"><?= date('d.m.Y H:i:s', strtotime($date['date_edit_time']))?></td>
                        <td class="date">
                            <div class="d-flex">
                                <a class="icon-edit" href="#modalEditDate" data-bs-toggle="modal" data-bs-target="#modalEditDate" data-id-date="<?= $date['date_id'] ?>" data-dateFrom-date="<?= $date['date_date_from'] ?>" data-dateTo-date="<?= $date['date_date_to'] ?>" ><i class="fa-solid fa-pencil"></i></a>
                                <a class="icon-del" href="<?= base_url('/delete-date-practise/'.$date['date_id']) ?>"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                        </tr>
                    <?php $countDate++; } ?>
                        <tr>
                            <td colspan="7"><div class="d-flex justify-content-start"><a class="add-next-date" href="#" data-bs-toggle="modal" data-bs-target="#modalAddNewDate" data-practiseId-newDate="<?= $practise['practise_id'] ?>"><i class="fa-solid fa-calendar-plus"></i> Přidat další termín</a></div></td>
                        </tr>
                    <?php }?>
                    <tr>
                        <td colspan="7" ><a class="text-add-date" href="#modalAddNewPractiseDate" data-bs-toggle="modal" data-bs-target="#modalAddNewPractiseDate"><i class="fa-solid fa-plus"></i> Přidat novou praxi</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
      $excludedClassIds = array_unique(array_column(array_merge(...array_column($practises, 'class')), 'class_id'));
?>
<div class="modal modal-lg" id="modalAddNewPractiseDate">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Vytvořit nový termín pro praxe</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/sent-date-practise')?>" method="POST" enctype="multipart/form-data" id="editPractiseForm">
            <div class="container d-flex flex-column">
                <label class="mt-1" for="name">Název pro praxi *</label>
                <input class="m-1 empty-input" type="text" name="name">
                <label class="mt-1" for="end-new-offer">Ukončení nových nabídek *</label>
                <input class="m-1 empty-input" type="date" name="end-new-offer" min="<?= date('Y-m-d') ?>" placeholder="Ukončení nových nabídek">
                <label class="mt-1" for="contract-file">Smlouva pro praxi *</label>
                <label for="file-upload" class="custom-file-label" id="file-label">Nahrajte smlouvu (PDF)</label>
                <input type="file" name="contract-file" id="file-upload" class="custom-file-input empty-input" accept=".pdf" value="smlouva.pdf">
                <label class="mt-1" for="date">Datum praxe od - do *</label>
                <div class="d-flex flex-column">
                    <div class="date-container" id="date-container">
                        <div class="date d-flex" id="date-row-1">
                            <input class="m-1 empty-input" type="date" min="<?= date('Y-m-d') ?>" name="dates[1][date-from]" id="date-from-1" style="width: 50%">
                            <input class="m-1 empty-input" type="date" min="<?= date('Y-m-d') ?>" name="dates[1][date-to]" id="date-to-1" style="width: 50%">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center"><button type="button" class="btn btn-add-date" id="next-date">Přidat další termín</button></div>
                <label class="mt-1" for="class">Praxe pro třídy: *</label>
                <div class="d-flex flex-wrap">
                    <?php foreach($schoolClass as $classes){ ?>
                            <div class="d-flex align-items-center p-1">
                                <input type="checkbox" class="checkbox p-1 select-class" name="classes[]" <?= in_array($classes['class_id'], $excludedClassIds) ? 'disabled' : ''   ?> value="<?= $classes['class_id']?>">
                                <p class="m-0 p-1"><?= $classes['class_class'].'.'.$classes['class_letter_class']?></p>
                            </div>
                        <?php } ?>
                </div>
                <label class="mt-1" for="description">Popis praxe</label>
                <textarea name="description" class="m-1 editor-mce"></textarea>
                <p>( * povinná pole)</p>
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Uložit" value="Vytvořit">
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal modal-lg" id="modalEditPractiseDate">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Upravit termín pro praxe</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/edit-practise')?>" method="POST" enctype="multipart/form-data">
            <div class="container d-flex flex-column">
                <input type="hidden" name="id" id="edit-practise-id">
                <label class="mt-1" for="name">Název pro praxi *</label>
                <input class="m-1 empty-input" type="text" id="edit-practise-name" name="name">
                <label class="mt-1" for="end-new-offer">Ukončení nových nabídek *</label>
                <input class="m-1 empty-input" type="date" name="end-new-offer" id="edit-practise-endOffer" placeholder="Ukončení nových nabídek">
                <label class="mt-1" for="contract-file" >Smlouva pro praxi *</label>
                <label for="edit-file-upload" class="custom-file-label" id="edit-practise-fileLabel">Nahrajte smlouvu (PDF)</label>
                <input type="file" name="contract-file" id="edit-file-upload" class="custom-file-input" accept=".pdf" value="smlouva.pdf">
                <label class="mt-1" for="class">Praxe pro třídy: *</label>
                <div class="d-flex flex-wrap">
                <?php foreach($schoolClass as $classes){ ?>
                            <div class="d-flex align-items-center p-1">
                                <input type="checkbox" class="checkbox p-1 select-class" name="classes[]" value="<?= $classes['class_id']?>" <?= in_array($classes['class_id'], $excludedClassIds) ? 'disabled' : ''   ?> id="class-<?= $classes['class_id']?>">
                                <p class="m-0 p-1"><?= $classes['class_class'].'.'.$classes['class_letter_class']?></p>
                            </div>
                        <?php } ?>
                </div>
                <label class="mt-1" for="description">Popis praxe</label>
                <textarea name="description" id="edit-practise-description" class="m-1 editor-mce"></textarea>
                <p>( * povinná pole)</p>
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Uložit" value="Upravit">
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal" id="modalEditDate">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Upravit termín praxe</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/edit-date-practise')?>" method="POST" enctype="multipart/form-data" id="editPractiseForm">
            <div class="container d-flex flex-column">
                <input type="hidden" id="edit-date-id" name="id">
                <label class="mt-1" for="date">Datum praxe od - do *</label>
                <div class="d-flex flex-column">
                    <div class="container">
                        <div class="d-flex">
                            <input class="m-1 empty-input" type="date" min="<?= date('Y-m-d') ?>" name="dateFrom" id="edit-date-dateFrom" style="width: 50%">
                            <input class="m-1 empty-input" type="date" min="<?= date('Y-m-d') ?>" name="dateTo" id="edit-date-dateTo" style="width: 50%">
                        </div>
                    </div>
                </div>
                <p>( * povinná pole)</p>
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Uložit" value="Upravit">
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal" id="modalAddNewDate">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Nový termín pro praxi</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/add-next-date')?>" method="POST" enctype="multipart/form-data" id="editPractiseForm">
            <div class="container d-flex flex-column">
                <input type="hidden" id="data-id-newDate" name="id">
                <label class="mt-1" for="date">Datum praxe od - do *</label>
                <div class="d-flex flex-column">
                    <div class="container">
                        <div class="d-flex">
                            <input class="m-1 empty-input" type="date" min="<?= date('Y-m-d') ?>" name="dateFrom" id="edit-date-dateFrom" style="width: 50%">
                            <input class="m-1 empty-input" type="date" min="<?= date('Y-m-d') ?>" name="dateTo" id="edit-date-dateTo" style="width: 50%">
                        </div>
                    </div>
                </div>
                <p>( * povinná pole)</p>
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Uložit" value="Vytvořit">
      </div>
      </form>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/js/validate-empty-input.js') ?>"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let dateCounter = 1; // Počáteční index pro datumy
    const dateContainer = document.getElementById("date-container"); // Kontejner pro datumy
    const addDateButton = document.getElementById("next-date"); // Tlačítko pro přidání dalšího termínu

    // Událost pro přidání dalšího termínu
    addDateButton.addEventListener("click", function () {
        dateCounter++; // Zvýšení počitadla

        // Vytvoření nového řádku s daty
        const dateRow = document.createElement("div");
        dateRow.className = "date d-flex";
        dateRow.id = `date-row-${dateCounter}`;
        dateRow.innerHTML = `
            <input class="m-1" type="date" min="<?= date('Y-m-d') ?>" name="dates[${dateCounter}][date-from]" id="date-from-${dateCounter}" style="width: 50%">
            <input class="m-1" type="date" min="<?= date('Y-m-d') ?>" name="dates[${dateCounter}][date-to]" id="date-to-${dateCounter}" style="width: 50%">
            <button type="button" class=" btn-remove-date m-1" data-row-id="${dateCounter}"><i class="fa-solid fa-xmark"></i></button>
        `;

        // Přidání nového řádku do kontejneru
        dateContainer.appendChild(dateRow);

        // Přidání funkce na odstranění tohoto řádku
        dateRow.querySelector(".btn-remove-date").addEventListener("click", function () {
            const rowId = this.getAttribute("data-row-id");
            const rowToRemove = document.getElementById(`date-row-${rowId}`);
            if (rowToRemove) {
                dateContainer.removeChild(rowToRemove); // Odstranění řádku
            }
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("file-upload");
    const fileLabel = document.getElementById("file-label");

    fileInput.addEventListener("change", function () {
        if (fileInput.files.length > 0) {
            // Získejte název nahraného souboru
            const fileName = fileInput.files[0].name;
            // Aktualizujte text v labelu
            fileLabel.textContent = fileName;
        } else {
            // Resetování labelu, pokud byl soubor odstraněn
            fileLabel.textContent = "Nahrajte smlouvu (PDF)";
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalEditPractiseDate');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
        document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.checked = false;
        });
      if (button) {
        const editPractiseId = button.getAttribute('data-id-datePractise') || '';
        const editPractiseName = button.getAttribute('data-name-datePractise') || '';
        const editPractiseEndOffer = button.getAttribute('data-endOffer-datePractise') || '';
        const editPractiseFile = button.getAttribute('data-file-datePractise') || '';
        const editPractiseDescription = button.getAttribute('data-description-datePractise') || '';
        document.getElementById('edit-practise-id').value = editPractiseId;
        document.getElementById('edit-practise-name').value = editPractiseName;
        document.getElementById('edit-practise-endOffer').value = editPractiseEndOffer;
        document.getElementById('edit-practise-fileLabel').textContent = editPractiseFile;
        //document.getElementById('edit-practise-description').value = editPractiseDescription;
        tinymce.get('edit-practise-description').setContent(editPractiseDescription);
        const classesData = JSON.parse(button.getAttribute('data-class-datePractise') || '[]');
        classesData.forEach((classId) => {
          const checkbox = document.getElementById(`class-${classId.class_id}`);
          if (checkbox) {
            checkbox.checked = true;
            checkbox.disabled = false;
          }
        });
      }
    });
  }
});
document.addEventListener("DOMContentLoaded", function () {
    const fileInputEdit = document.getElementById("edit-file-upload");
    const fileLabelEdit = document.getElementById("edit-practise-fileLabel");

    fileInputEdit.addEventListener("change", function () {
        if (fileInputEdit.files.length > 0) {
            const fileName = fileInputEdit.files[0].name;
            fileLabelEdit.textContent = fileName;
        } else {
            fileLabelEdit.textContent = "Nahrajte smlouvu (PDF)";
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalEditDate');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const dateId = button.getAttribute('data-id-date') || '';
        const dateFrom = button.getAttribute('data-dateFrom-date') || '';
        const dateTo = button.getAttribute('data-dateTo-date') || '';
        document.getElementById('edit-date-id').value = dateId;
        document.getElementById('edit-date-dateFrom').value = dateFrom;
        document.getElementById('edit-date-dateTo').value = dateTo;
      }
    });
  }
});
document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalAddNewDate');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const datePractiseId = button.getAttribute('data-practiseId-newDate') || '';
        document.getElementById('data-id-newDate').value = datePractiseId;
      }
    });
  }
});
</script>
<?= $this->endSection() ?>