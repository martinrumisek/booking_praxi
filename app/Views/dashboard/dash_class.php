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
    select{
        border: none;
      height: 40px;
      padding: 8px;
      border-radius: 10px;
      background-color: white;
      box-shadow: 0px 3px 6px #00000029; 
    }
    select:focus{
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
    .page-class{
        box-shadow: 0px 1px 1px #00000029;
        background: #f0f0f0 0% 0% no-repeat padding-box;
        padding: 10px;
    }
    .add-new-class:hover{
        color: #006DBC;
    }
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
    -moz-appearance: textfield;
    }

</style>
<div class="container page-class mt-2">
    <h2 class="text-center">Přehled tříd</h2>
    <div class="mt-1 d-flex justify-content-end">
        <a class="all-user mt-2" href="#modalLoadAllUser" data-bs-toggle="modal" data-bs-target="#modalAddType"><i class="fa-solid fa-plus"></i> Typ školy</a>
        <a class="all-user mt-2" href="#modalLoadAllUser" data-bs-toggle="modal" data-bs-target="#modalAddField"><i class="fa-solid fa-plus"></i> Obor školy</a>
        <a class="all-user mt-2" href="#modalLoadAllUser" data-bs-toggle="modal" data-bs-target="#modalOpenExport"><i class="fa-solid fa-file-export"></i> Export</a>
    </div>
    <?php foreach($typeSchools as $type){?> 
        <div class="d-flex">
        <h4><?= $type['type_name'] . ' (' . $type['type_shortcut'] . ')' ?></h4>
        <a class="p-1" href="#"  data-bs-toggle="modal" data-bs-target="#modalEditType" data-typeId-typeSchool="<?= $type['type_id'] ?>" data-typeName-typeSchool="<?= $type['type_name'] ?>" data-typeShortcut-typeSchool="<?= $type['type_shortcut'] ?>" data-typeDescription-typeSchool="<?= $type['type_description'] ?>"><i class="fa-solid fa-pencil"></i></a>
        <a class="p-1" href="<?= base_url('/delete-type-school/'.$type['type_id']) ?>"><i class="fa-solid fa-trash"></i></a>
        </div>
        <?php if(!empty($type['fields'])){ foreach($type['fields'] as $field){ ?>
        <div class="d-flex align-items-center">
        <p class="h6 m-0">Obor: <?= $field['field_name'] . ' ('. $field['field_shortcut'] . ')' ?></p>
        <a class="p-1" href="#" data-bs-toggle="modal" data-bs-target="#modalEditField" data-fieldId-fieldStudy="<?= $field['field_id'] ?>" data-fieldName-fieldStudy="<?= $field['field_name'] ?>" data-fieldShortcut-fieldStudy="<?= $field['field_shortcut'] ?>"><i class="fa-solid fa-pencil"></i></a>
        <a class="p-1" href="<?= base_url('/delete-field-study/'.$field['field_id']) ?>"><i class="fa-solid fa-trash"></i></a>
        </div>
        <ul>
            <?php if(!empty($field['classes'])){ foreach($field['classes'] as $class){ ?>
                <div class="d-flex align-items-center">
                <li><?= $class['class_class'] . '.' . $class['class_letter_class'] . '  (' . $class['class_year_graduation'] . ')'?></li>
                <a class="p-1" href="#" data-bs-toggle="modal" data-bs-target="#modalEditClass" data-classId-class="<?= $class['class_id'] ?>" data-classNumber-class="<?= $class['class_class'] ?>" data-classLetter-class="<?= $class['class_letter_class'] ?>" data-classGraduation-class="<?= $class['class_year_graduation'] ?>"><i class="fa-solid fa-pencil"></i></a>
                <a class="p-1" href="<?= base_url('/delete-class/'.$class['class_id']) ?>"><i class="fa-solid fa-trash"></i></a>
                </div>
            <?php }} ?>
            <li><a class="add-new-class" href="#" data-bs-toggle="modal" data-bs-target="#modalAddClass" data-fieldId-field="<?= $field['field_id'] ?>"><i class="fa-solid fa-plus"></i> Třídu</a></li>
        </ul>
    <?php }}} ?>
</div>
<div class="modal" id="modalAddType">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Přidat typ školy</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <form action="<?= base_url('/new-type-school') ?>" method="POST">
      <div class="modal-body">
            <div class="container d-flex flex-column">
               <label for="name_type">Název typu školy *</label>
               <input type="text" name="name" id="name_type">
               <label for="shortcut_type">Zkratka typu školy *</label>
               <input type="text" name="shortcut" id="shortcut_type">
               <label for="description_type">Popis</label>
               <textarea name="description" id="description_type"></textarea>
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
</div>
<div class="modal" id="modalAddField">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Přidat obor školy</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <form action="<?= base_url('/new-field-school') ?>" method="POST">
      <div class="modal-body">
            <div class="container d-flex flex-column">
                <label for="name_field">Název oboru *</label>
               <input type="text" name="name" id="name_field">
               <label for="shortcut_type">Zkratka oboru *</label>
               <input type="text" name="shortcut" id="shortcut_field">
               <label for="select_type">Pro typ školy *</label>
               <select name="type_school" id="select_type">
                <option disabled selected value="">Vyberte možnost</option>
                    <?php foreach($typeSchools as $type){?>
                        <option value="<?= $type['type_id'] ?>"><?= $type['type_name'] . '  (' . $type['type_shortcut'] . ')' ?></option>
                    <?php }?>
               </select>
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
</div>
<div class="modal" id="modalAddClass">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Přidat třídu</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <form action="<?= base_url('/new-class-school') ?>" method="POST">
      <div class="modal-body">
            <div class="container d-flex flex-column">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-column">
                        <label for="number_class">Číslo třídy *</label>
                        <input type="number" name="class" id="number_class">
                    </div>
                    <div class="d-flex jusify-content-center align-items-end">.</div>
                    <div class="d-flex flex-column">
                        <label for="letter_class">Písmeno třídy *</label>
                        <input type="text" name="letter" id="letter_class">
                    </div>
                </div>
                <label for="year_graduation">Rok maturity *</label>
               <input type="number" name="year_graduation" id="year_graduation">
               <input type="hidden" name="fieldId" id="data-field-id">
               <p>( * povinná pole)</p>
               <p>POZOR! (Je potřeba všechno dodržet. Podle písmena a roku maturity se žáci přiřazují do tříd)</p>
            </div>
      </div>
      <div class="modal-footer">
      <input class="btn-create" type="submit" placeholder="Uložit" value="Vytvořit">
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<div class="modal" id="modalEditType">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Přidat typ školy</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <form action="<?= base_url('/edit-type-school') ?>" method="POST">
      <div class="modal-body">
            <div class="container d-flex flex-column">
               <label for="data-typeSchool-name">Název typu školy *</label>
               <input type="text" name="name" id="data-typeSchool-name">
               <label for="data-typeSchool-shortcut">Zkratka typu školy *</label>
               <input type="text" name="shortcut" id="data-typeSchool-shortcut">
               <label for="data-typeSchool-description">Popis</label>
               <textarea name="description" id="data-typeSchool-description"></textarea>
               <input type="hidden" id="data-typeSchool-id" name="id">
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
</div>
<div class="modal" id="modalEditField">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Editace oboru školy</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <form action="<?= base_url('/edit-field-school') ?>" method="POST">
      <div class="modal-body">
            <div class="container d-flex flex-column">
                <label for="data-fieldStudy-name">Název oboru *</label>
               <input type="text" name="name" id="data-fieldStudy-name">
               <label for="data-fieldStudy-shortcut">Zkratka oboru *</label>
               <input type="text" name="shortcut" id="data-fieldStudy-shortcut">
               <input type="hidden" id="data-fieldStudy-id" name="id">
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
</div>
<div class="modal" id="modalEditClass">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Editace třídy</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <form action="<?= base_url('/edit-class-school') ?>" method="POST">
      <div class="modal-body">
            <div class="container d-flex flex-column">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-column">
                        <label for="data-class-number">Číslo třídy *</label>
                        <input type="number" name="class" id="data-class-number">
                    </div>
                    <div class="d-flex jusify-content-center align-items-end">.</div>
                    <div class="d-flex flex-column">
                        <label for="data-class-letter">Písmeno třídy *</label>
                        <input type="text" name="letter" id="data-class-letter">
                    </div>
                </div>
                <label for="data-class-graduation">Rok maturity *</label>
               <input type="number" name="year_graduation" id="data-class-graduation">
               <input type="hidden" name="id" id="data-class-id">
               <p>( * povinná pole)</p>
               <p>POZOR! (Je potřeba všechno dodržet. Podle písmena a roku maturity se žáci přiřazují do tříd)</p>
            </div>
      </div>
      <div class="modal-footer">
      <input class="btn-create" type="submit" placeholder="Uložit" value="Upravit">
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<div class="modal" id="modalOpenExport">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h4 class="modal-title">Export tříd</h4>
        <button type="button" class="btn btn-close-modal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
            <div class="container">
                
            </div>
      </div>
      <div class="modal-footer">
      <input class="btn-create" type="submit" placeholder="Uložit" value="Upravit">
      </div>
    </div>
  </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalAddClass');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const fieldId = button.getAttribute('data-fieldId-field') || '';
        document.getElementById('data-field-id').value = fieldId;
      }
    });
  }
});
document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalEditField');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const fieldStudyId = button.getAttribute('data-fieldId-fieldStudy') || '';
        const fieldName = button.getAttribute('data-fieldName-fieldStudy') || '';
        const fieldShortcut = button.getAttribute('data-fieldShortcut-fieldStudy') || '';
        document.getElementById('data-fieldStudy-id').value = fieldStudyId;
        document.getElementById('data-fieldStudy-name').value = fieldName;
        document.getElementById('data-fieldStudy-shortcut').value = fieldShortcut;
      }
    });
  }
});
document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalEditType');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const typeSchoolId = button.getAttribute('data-typeId-typeSchool') || '';
        const typeSchoolName = button.getAttribute('data-typeName-typeSchool') || '';
        const typeSchoolShortcut = button.getAttribute('data-typeShortcut-typeSchool') || '';
        const typeSchoolDescription = button.getAttribute('data-typeDescription-typeSchool') || '';
        document.getElementById('data-typeSchool-id').value = typeSchoolId;
        document.getElementById('data-typeSchool-name').value = typeSchoolName;
        document.getElementById('data-typeSchool-shortcut').value = typeSchoolShortcut;
        document.getElementById('data-typeSchool-description').value = typeSchoolDescription;
      }
    });
  }
});
document.addEventListener('DOMContentLoaded', function () {
  const modalEditCategory = document.getElementById('modalEditClass');
  if (modalEditCategory) {
    modalEditCategory.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (button) {
        const classId= button.getAttribute('data-classId-class') || '';
        const classNumber = button.getAttribute('data-classNumber-class') || '';
        const classLetter = button.getAttribute('data-classLetter-class') || '';
        const classGraduation = button.getAttribute('data-classGraduation-class') || '';
        document.getElementById('data-class-id').value = classId;
        document.getElementById('data-class-number').value = classNumber;
        document.getElementById('data-class-letter').value = classLetter;
        document.getElementById('data-class-graduation').value = classGraduation;
      }
    });
  }
});

</script>
<?= $this->endSection() ?>