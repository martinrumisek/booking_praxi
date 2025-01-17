<?= $this->extend('layout/layout_nav') ?>

<?= $this->section('content') ?>
<style>
    .container-user{
        width: 100%;
        min-height: 500px;
        background: #f0f0f0 0% 0% no-repeat padding-box;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 0px 0px 70px 0px;
        opacity: 1;
    }
    .icon-user{
        width: 150px;
        height: 150px;
        border-radius: 150px;
        background-color: #FFFFFFD6;
        box-shadow: 0px 3px 6px #00000029;
    }

    .btn-container{
        width: 100%;
        min-height: 70px;
        background: #006DBC 0% 0% no-repeat padding-box;
        opacity: 1;
    }
    a{
        text-decoration: none;
        color: black;
    }
    .icon-company{
        width: 150px;
        height: 150px;
        border-radius: 150px;
        background-color: #FFFFFFD6;
        box-shadow: 0px 3px 6px #00000029;
    }
    .btn-document-export{
        background-color: white;
        width: 200px;
        height: 55px;
        border-radius: 20px;
    }
    .next-previously{
        width: 70px;
        height: 70px;
        border-radius: 70px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .card-offer{
        width: 320px;
        height: 340px;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .card-icon-company{
        width: 50px;
        height: 50px;
        border-radius: 50px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    .card-title{
        width: 70%;
        margin-left: 10px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        -webkit-line-clamp: 2;
    }
    .card-star{
        color: yellow;
    }
    .card-text{
        font-size: 13px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        -webkit-line-clamp: 2;
    }
    .text-praxe{
        font-size: 13px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        -webkit-line-clamp: 5;
    }
    input.checkbox{
      background-color: transparent;
      box-shadow: none;
      height: auto;
      cursor:pointer;
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
        border:none;
        max-width: 250px;
        height: 40px;
        padding: 8px;
        border-radius: 10px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    select:focus{
        border: 1px solid #006DBC;
        outline: none;
    }
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
    -moz-appearance: textfield;
    }
    textarea{
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
    textarea.name-practise-offer{
        width: 80%;
        height: 100px
    }
    textarea.short-description-offer{
        width: 100%;
        height: 200px;
    }
    textarea.full-description{
        width: 100%;
        min-height: 100%;
    }
    input.checkbox{
      background-color: transparent;
      box-shadow: none;
      height: auto;
    }
    .blue-line{
        width: 100%;
        height: 2px;
        background-color: #006DBC
    }
    .view-contract-file{
        padding: 4px;
        box-shadow: 0px 3px 6px #00000029;
        background-color: white;
        border-radius: 10px;
    }
    .view-contract-file:hover{
        background-color: #006DBC;
        color: white;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-6 p-0">
            <div class="container-user">
                <div class="p-5 container">
                    <div class="d-md-flex d-block">
                        <div class="d-flex justify-content-center align-items-center"><div class="icon-user d-flex align-items-center justify-content-center"><i class="fa-solid fa-briefcase h1"></i></div></div>
                        <div class="d-flex justify-content-center flex-column align-items-center p-0 m-4" style="width: 100%;"><span>Název praxe</span><textarea name="name_offer_practise" class="name-practise-offer" id=""></textarea></div>
                    </div>
                    <div class="container mt-3 d-flex flex-column">
                        <span>Krátky popis praxe</span>
                        <textarea name="short_description_offer_practise" class="short-description-offer" id=""></textarea>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
                <div class="container-company">
                    <div class="p-5 container">
                        <div class="d-md-flex d-block">
                            <div class="d-flex justify-content-center align-items-center"><div class="icon-company d-flex align-items-center justify-content-center"><i class="fa-solid fa-building h1"></i></div></div>
                             <div class="d-flex justify-content-center align-items-center p-0 m-4"><div><div class="h4">Název firmy/instituce</div><span><?= $company['company_name'] ?></span><br><span class="fw-bold">IČO: </span><span><?= $company['company_ico'] ?></span></div></div>
                        </div>
                        <div class="container d-flex flex-column">
                            <h5>Lokace praxe</h5>
                            <span>Město/vesnice</span>
                            <input type="text">
                            <span>Ulice</span>
                            <input type="text">
                            <span>PSČ</span>
                            <input type="text">
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="btn-container d-flex flex-wrap justify-content-center align-items-center">

</div>
<div class="container-fluid mt-2">
<div class="row">
    <div class="col-12 col-md-4">
        <h4 class="text-center">Termíny praxí</h4>
        <p>Zde jsou všechny volitelné termíny pro praxe. Prosím vyberte pouze jeden termín. Vybraní termínu je nutné.</p>
        <?php foreach($practises as $practise){ ?>
        <div class="m-2">
        <div class="d-flex">
            <input type="checkbox" class="checkbox select-practise" name="select_practises[]" value="<?= $practise['practise_id'] ?>">
            <div class="d-flex align-items-center p-2 fw-bold"><?= $practise['practise_name'] ?></div>
        </div>
        <div>
            <span class="fw-bold">Pro třídy:</span> <?php foreach($practise['classes'] as $class){ echo $class['class_class'] . '.' . $class['class_letter_class'] . ' (' . $class['field_shortcut'] . '), '; } ?>
        </div>
        <div>
            <span class="fw-bold">Termín/y:</span> <?php $countDate = count($practise['dates']); foreach($practise['dates'] as $date){echo date('d.m.Y', strtotime($date['date_date_from']))  . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])); if($countDate > 1){echo ' / ';}} ?>
        </div>
        <div class="m-2"><a target="_blank" class="view-contract-file" href="<?= base_url('assets/document/'.$practise['practise_contract_file']) ?>"><i class="fa-solid fa-file-pdf"></i> Smlouva pro praxi</a></div>
        </div>
        <div class="blue-line"></div>
        <?php } ?>
        <h4 class="text-center mt-2">Dovednosti pro praxi</h4>
        <?php foreach($categoryes as $category){ ?>
        <div class="h5 fw-bold"><?= $category['category_name'] ?></div>
        <div class="m-2">
            <?php foreach($category['skills'] as $skill){ ?>
            <div class="d-flex">
                <input type="checkbox" class="checkbox" name="skills[]" value="<?= $skill['skill_id'] ?>">
                <div class="d-flex align-items-center p-2"><?= $skill['skill_name'] ?></div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
        <h4 class="text-center">Vedoucí pro praxi</h4>
    </div>
    <div class="col-12 col-md-8">
        <h4>Popis praxe</h4>
        <div class="container" style="height: 100%;">
            <textarea name="" class="full-description" id=""></textarea>
        </div>
    </div>
</div>
</div>
<script>
    document.querySelectorAll('.select-practise').forEach((checkbox) => {
    checkbox.addEventListener('change', (e) => {
        document.querySelectorAll('.select-practise').forEach((box) => {
            if (box !== e.target) {
                box.checked = false;
            }
        });
    });
});
</script>
<?= $this->endSection() ?>