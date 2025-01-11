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
</style>
<div class="container-fluid">
    <h2>Přehled termínů pro praxe</h2>
    <div class="d-flex flex-wrap justify-content-between m-3">
        <form action="" method="POST">
            <div class="d-flex">
                <input class="search-input p-2 mt-2" id="search-input" type="text" placeholder="Vyhledat uživatele">
                <button class="btn btn-search mt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
            <div class="d-flex">
                <button class="btn btn-add-date mt-2"  data-bs-toggle="modal" data-bs-target="#modalAddNewPractiseDate"><i class="fa-solid fa-circle-plus"></i> Přidat datum praxe</button>
            </div>
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
                        <th class="nowrap" scope="row"><?= $practise['practise_name']?></th>
                        <td>
                            <?php $countDate = count($practise['dates']); foreach($practise['dates'] as $date){ 
                                echo date('d.m.Y', strtotime($date['date_date_from'])).' - '.date('d.m.Y', strtotime($date['date_date_to']));
                                $countDate = $countDate - 1;
                                if($countDate > 0){
                                    echo '/';
                                }
                            }?>
                        </td>
                        <td>
                            <?php $countClass = count($practise['class']); foreach($practise['class'] as $class){
                                echo $class['class_class'].'.'.$class['class_letter_class'];
                                $countClass = $countClass - 1;
                                if($countClass > 0){
                                    echo ',';
                                }
                            } ?>
                        </td>
                        <td><?= date('d.m.Y', strtotime($practise['practise_end_new_offer']))?></td>
                        <?php if(empty($practise['practise_contract_file'])){ ?>
                            <td><i class="fa-solid fa-circle-xmark"></i></td>
                        <?php }else{ ?>
                            <td><i class="fa-regular fa-circle-check"></i></td>
                        <?php } ?>

                        <td><?= date('d.m.Y H:i', strtotime($practise['practise_edit_time']))?></td>
                        <td>
                            <div class="d-flex">
                                <?php $countDateAtribut = count($practise['dates']) ?>
                                <a href="#modalAddNewPractiseDate" data-bs-toggle="modal" data-bs-target="#modalEditPractiseDate" data-id-datePractise="<?= $practise['practise_id'] ?>" data-name-datePractise="<?= $practise['practise_name'] ?>" data-dates-datePractise="<?= htmlspecialchars(json_encode($practise['dates'])) ?>" data-class-datePractise="<?= htmlspecialchars(json_encode($practise['class'])) ?>" data-endOffer-datePractise="<?= $practise['practise_end_new_offer'] ?>" data-file-datePractise="<?= $practise['practise_contract_file'] ?>" data-description-datePractise="<?= $practise['practise_description'] ?>" data-countDate-datePractise="<?= $countDateAtribut ?>"><i class="fa-solid fa-pencil"></i></a>
                                <a href="#"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>  
                    <?php }?>
                    <tr>
                        <td colspan="7" ><a class="text-add-date" href="#modalAddNewPractiseDate" data-bs-toggle="modal" data-bs-target="#modalAddNewPractiseDate"><i class="fa-solid fa-plus"></i> Přidat nový termín pro praxi</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal" id="modalAddNewPractiseDate">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Vytvořit nový termín pro praxe</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/sent-date-practise')?>" method="POST" enctype="multipart/form-data" id="editPractiseForm">
            <div class="container d-flex flex-column">
                <label class="mt-1" for="name">Název pro praxi</label>
                <input class="m-1" type="text" name="name">
                <label class="mt-1" for="end-new-offer">Ukončení nových nabídek</label>
                <input class="m-1" type="date" name="end-new-offer" placeholder="Ukončení nových nabídek">
                <label class="mt-1" for="contract-file">Smlouva pro praxi</label>
                <label for="file-upload" class="custom-file-label">Nahrajte smlouvu (PDF)</label>
                <input type="file" name="contract-file" id="file-upload" class="custom-file-input" accept=".pdf" value="smlouva.pdf">
                <label class="mt-1" for="date">Datum praxe od - do</label>
                <div class="d-flex flex-column">
                    <div class="date-container" id="date-container">
                        <div class="date d-flex" id="date-row-1">
                            <input class="m-1" type="date" name="dates[1][date-from]" id="date-from-1" style="width: 50%">
                            <input class="m-1" type="date" name="dates[1][date-to]" id="date-to-1" style="width: 50%">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center"><button type="button" class="btn btn-add-date" id="next-date">Přidat další termín</button></div>
                <label class="mt-1" for="class">Praxe pro třídy:</label>
                <div class="d-flex flex-wrap">
                    <?php foreach($schoolClass as $classes){ ?>
                            <div class="d-flex align-items-center p-1">
                                <input type="checkbox" class="checkbox p-1" name="classes[]" value="<?= $classes['class_id']?>">
                                <p class="m-0 p-1"><?= $classes['class_class'].'.'.$classes['class_letter_class']?></p>
                            </div>
                        <?php } ?>
                </div>
                <label class="mt-1" for="description">Popis praxe</label>
                <textarea name="description" class="m-1"></textarea>
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Uložit" value="Vytvořit">
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal" id="modalEditPractiseDate">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Upravit termín pro praxe</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/edit-date-practise')?>" method="POST" enctype="multipart/form-data">
            <div class="container d-flex flex-column">
                <label class="mt-1" for="name">Název pro praxi</label>
                <input class="m-1" type="text" id="edit-practiseDate-name" name="name">
                <label class="mt-1" for="end-new-offer">Ukončení nových nabídek</label>
                <input class="m-1" type="date" name="end-new-offer" id="edit-practiseDate-endNewOffer" placeholder="Ukončení nových nabídek">
                <label class="mt-1" for="contract-file">Smlouva pro praxi</label>
                <label for="file-upload" class="custom-file-label" id="edit-file-text"></label>
                <input type="file" name="contract-file" id="file-upload" class="custom-file-input" accept=".pdf" value="smlouva.pdf">
                <label class="mt-1" for="date">Datum praxe od - do</label>
                <div class="d-flex flex-column" id="edit-date-container">
                    
                </div>
                <div class="d-flex justify-content-center"><button type="button" class="btn btn-add-date" id="edit-next-date">Přidat další termín</button></div>
                <label class="mt-1" for="class">Praxe pro třídy:</label>
                <div class="d-flex flex-wrap">
                <?php foreach($schoolClass as $classes){ ?>
                            <div class="d-flex align-items-center p-1">
                                <input type="checkbox" class="checkbox p-1" name="classes[]" value="<?= $classes['class_id']?>" id="class-<?= $classes['class_id']?>">
                                <p class="m-0 p-1"><?= $classes['class_class'].'.'.$classes['class_letter_class']?></p>
                            </div>
                        <?php } ?>
                </div>
                <label class="mt-1" for="description">Popis praxe</label>
                <textarea name="description" id="edit-practiseDate-description" class="m-1"></textarea>
            </div>
      </div>
      <div class="modal-footer">
        <input class="btn-create" type="submit" placeholder="Uložit" value="Vytvořit">
      </div>
      </form>
    </div>
  </div>
</div>

<script>
    let dateCount = 1;

    document.getElementById('next-date').addEventListener('click', function() {
        dateCount++;

        // Vytvoří nový blok pro termín
        const newDateRow = document.createElement('div');
        newDateRow.classList.add('date');
        newDateRow.classList.add('d-flex');
        newDateRow.id = 'date-row-' + dateCount;

        newDateRow.innerHTML = `
            <input class="m-1" type="date" name="dates[${dateCount}][date-from]" id="date-from-${dateCount}" style="width: 50%">
            
            <input class="m-1" type="date" name="dates[${dateCount}][date-to]" id="date-to-${dateCount}" style="width: 50%">
        `;
        
        // Přidá nový blok do kontejneru
        document.getElementById('date-container').appendChild(newDateRow);
    });
    document.querySelector('#file-upload').addEventListener('change', function () {
    const fileName = this.files[0] ? this.files[0].name : 'Vyberte soubor';
    document.querySelector('.custom-file-label').textContent = fileName;
});

document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalEditPractiseDate');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const name = button.getAttribute('data-name-datePractise') || '';
        const file = button.getAttribute('data-file-datePractise') || '';
        const endNewOffer = button.getAttribute('data-endOffer-datePractise') || '';
        const description = button.getAttribute('data-description-datePractise') || '';
        let countDate = button.getAttribute('data-countDate-datePractise') || '';
        document.getElementById('edit-practiseDate-name').value = name;
        const labelFile = document.getElementById('edit-file-text');
        labelFile.textContent = file;
        document.getElementById('edit-practiseDate-endNewOffer').value = endNewOffer;
        document.getElementById('edit-practiseDate-description').value = description; 


        const dates = JSON.parse(button.getAttribute('data-dates-datePractise') || '[]');
        const classes = JSON.parse(button.getAttribute('data-class-datePractise') || '[]');

        // Zpracování dat - datumy
        const addDateButton = document.getElementById('edit-next-date');
        const dateContainer = document.getElementById('edit-date-container');
        dateContainer.innerHTML = ''; // Vyčištění existujících datumů

        dates.forEach((date, index) => {
        const rowId = `date-row-${index + 1}`;
        const dateFromId = `date-from-${index + 1}`;
        const dateToId = `date-to-${index + 1}`;

        const dateRow = document.createElement('div');
        dateRow.className = 'date';
        dateRow.className = 'd-flex';
        dateRow.id = rowId;

        dateRow.innerHTML = `
            <input class="m-1" type="date" name="dates[${index + 1}][date-from]" id="${dateFromId}" style="width: 50%" value="${date.date_from || ''}">
            <input class="m-1" type="date" name="dates[${index + 1}][date-to]" id="${dateToId}" style="width: 50%" value="${date.date_to || ''}">
            <input class="m-1" type="hidden" name="dates[${index + 1}][id]" id="${dateToId}" style="width: 50%" value="${date.id || ''}">
        `;

        dateContainer.appendChild(dateRow);
        });
        if (addDateButton) {
            addDateButton.addEventListener('click', function () {
            // Získáme počet aktivních řádků (které mají třídu 'date-row')
            const rowCount = dateContainer.querySelectorAll('.date-row').length;
            
            // Vytvoříme nový div pro nový termín
            const dateRow = document.createElement('div');
            dateRow.classList.add('date-row', 'd-flex'); // Přidáme třídy pro řádek
            dateRow.id = `date-row-${rowCount + 1}`; // Unikátní ID pro každý řádek

            // HTML pro nové inputy pro datumy
            dateRow.innerHTML = `
                <input class="m-1" type="date" name="dates[${rowCount + 1}][date-from]" id="date-from-${rowCount + 1}" style="width: 50%">
                <input class="m-1" type="date" name="dates[${rowCount + 1}][date-to]" id="date-to-${rowCount + 1}" style="width: 50%">
            `;

            // Přidáme nový řádek do kontejneru
            dateContainer.appendChild(dateRow);
            });
        }

        // Zpracování dat - třídy
        const classesData = JSON.parse(button.getAttribute('data-class-datePractise') || '[]');
        classesData.forEach(classId => {
        const checkbox = document.getElementById(`class-${classId.id}`);
        if (checkbox) {
            checkbox.checked = true;
        }
        });

      }
    });
  }
  
});
</script>
<?= $this->endSection() ?>