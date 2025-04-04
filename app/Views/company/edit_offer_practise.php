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
    .btn-right-display-submit{
        position: fixed;
        bottom: 55px;
        right: 20px;
        z-index: 1;
        padding: 10px 20px;
        background-color: #006DBC; 
        box-shadow: 0px 3px 6px #00000029;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 16px;
    }
    .btn-right-display-submit:hover{
        color: #006DBC;
        background-color: white;
        border: 1px solid #006DBC;
    }
    .invalid-input{
      border: 1px solid red;
    }
</style>
<form action="<?= base_url('/edit-practise-offer') ?>" method="POST">
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-6 p-0">
            <div class="container-user">
                <div class="p-5 container">
                    <div class="d-md-flex d-block">
                        <div class="d-flex justify-content-center align-items-center"><div class="icon-user d-flex align-items-center justify-content-center"><i class="fa-solid fa-briefcase h1"></i></div></div>
                        <div class="d-flex justify-content-center flex-column align-items-center p-0 m-4" style="width: 100%;"><span>Název praxe</span><textarea onkeydown="return event.key !== 'Enter';" name="name_offer_practise" class="name-practise-offer empty-input" id=""><?= $offer['offer_name'] ?></textarea></div>
                    </div>
                    <div class="container mt-3 d-flex flex-column">
                        <span>Krátky popis praxe</span>
                        <textarea onkeydown="return event.key !== 'Enter';" name="short_description_offer_practise" class="short-description-offer" id=""><?= $offer['offer_requirements'] ?></textarea>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
                <div class="container-company">
                    <div class="p-5 container">
                        <div class="d-md-flex d-block">
                            <div class="d-flex justify-content-center align-items-center"><div class="icon-company d-flex align-items-center justify-content-center"><i class="fa-solid fa-building h1"></i></div></div>
                             <div class="d-flex justify-content-center align-items-center p-0 m-4"><div><div class="h4">Název firmy/instituce</div><span><?= $offer['company_name'] ?></span><br><span class="fw-bold">IČO: </span><span><?= $offer['company_ico'] ?></span></div></div>
                        </div>
                        <div class="container d-flex flex-column">
                            <h5>Lokace praxe</h5>
                            <span>Město/vesnice</span>
                            <input type="text" name="city_practise" class="empty-input" value="<?= $offer['offer_city'] ?>">
                            <span>Ulice</span>
                            <input type="text" name="street_practise" class="empty-input" value="<?= $offer['offer_street'] ?>">
                            <span>PSČ</span>
                            <input type="text" name="post_code_practise" class="empty-input" value="<?= $offer['offer_post_code'] ?>">
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="btn-container d-flex flex-wrap justify-content-center align-items-center">
<div class="d-flex">
            <label class="d-flex align-items-center p-2 text-white" for="copy_next_year">Kopírovat praxi pro další termíny</label>
            <input type="checkbox" id="copy_next_year" class="checkbox" name="copy_next_year" <?php if($offer['offer_copy_next_year'] == 1){?>checked <?php } ?> value="1">
</div>
</div>
<div class="container-fluid mt-2">
<div class="row">
    <div class="col-12 col-md-4">
        <h4 class="text-center">Termíny praxí</h4>
        <div class="m-2">
        <div class="d-flex">
            <div class="d-flex align-items-center"><p class="fw-bold">Název termínu: </p><p class="p-2"><?= $offer['practise_name'] ?></p></div>
        </div>
        
        <div>
             <?php $countDate = 1; foreach($dates as $date){echo '<span class="fw-bold">Termín ' . $countDate . ': </span>' .  date('d.m.Y', strtotime($date['date_date_from']))  . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])) . '<br>'; $countDate++;} ?>
        </div>
        <div class="m-2"><a target="_blank" class="view-contract-file" href="<?= base_url('assets/document/'.$offer['practise_contract_file']) ?>"><i class="fa-solid fa-file-pdf"></i> Smlouva pro praxi</a></div>
        </div>
        <div class="blue-line"></div>
        <h4 class="text-center mt-2">Dovednosti pro praxi</h4>
        <?php foreach($skills as $category){ ?>
        <div class="h5 fw-bold"><?= $category['category_name'] ?></div>
        <div class="m-2">
            <?php foreach($category['skills'] as $skill){ ?>
            <div class="d-flex">
                <input <?php if(in_array($skill['skill_id'], array_column($offerSkill, 'Skill_skill_id'))){?> checked <?php } ?> type="checkbox" class="checkbox" name="skills[]" value="<?= $skill['skill_id'] ?>">
                <div class="d-flex align-items-center p-2"><?= $skill['skill_name'] ?></div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
        <h4 class="text-center">Vedoucí pro praxi</h4>
        <div class="d-flex flex-wrap">
            <div class="d-flex align-items-center p-2"><i class="fa-solid fa-clipboard-user h3 m-0"></i></div>
            <select name="practise_manager" id="practise_manager">
                <option disabled value="">Vyberte vedoucího praxe</option>
                <?php if(empty($managers)){ ?>
                    <div class="container bg-white p-3 text-center shadow">Nemáté žádného vedoucího</div>
                <?php } ?>
                <?php foreach($managers as $manager){ ?>
                    <option <?php if($manager['manager_id'] == $offer['manager_id']){ ?> selected <?php } ?> value="<?= $manager['manager_id'] ?>"><?php if(!empty($manager['manager_degree_before'])){echo $manager['manager_degree_before'] . ' ';} echo $manager['manager_name'] . ' ' . $manager['manager_surname']; if(!empty($manager['manager_degree_after'])){echo ' '. $manager['manager_degree_after'];} ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-12 col-md-8">
        <h4>Popis praxe</h4>
        <div class="container" style="height: 100%;">
            <textarea name="full_description" class="full-description editor-mce"><?= $offer['offer_description'] ?></textarea>
        </div>
    </div>
</div>
</div>
<input type="hidden" value="<?= $offer['offer_id'] ?>" name="offer_id">
<input type="hidden" value="<?= $offer['company_id'] ?>" name="company_id">
<input type="submit" class="btn-right-display-submit" value="Upravit">
</form>
<script src="<?= base_url('assets/js/validate-empty-input.js') ?>"></script>
<?= $this->endSection() ?>