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
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-6 p-0">
            <div class="container-user">
                <div class="p-5 container">
                    <div class="d-md-flex d-block">
                        <div class="d-flex justify-content-center align-items-center"><div class="icon-user d-flex align-items-center justify-content-center"><i class="fa-regular fa-user h1"></i></div></div>
                        <div class="d-flex justify-content-center align-items-center p-0 m-4"><div><div class="h3"><?php if(!empty($user['representative_degree_before'])){echo $user['representative_degree_before'];} echo ' '; echo $user['representative_name'] . ' ' . $user['representative_surname']; if(!empty($user['representative_degree_after'])){echo $user['representative_degree_after'];}  ?></div><div><span class="text-wrap">Firma</span></div></div></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-md-6"><div class="h5 mt-2">E-mail</div><div class=""></div><?= $user['representative_mail'] ?></div>
                        <div class="col-12 col-md-6"><div class="h5 mt-2">Telefonní číslo</div><div class=""><?= $user['representative_phone'] ?></div></div>
                        <div class="col-12 col-md-6"><div class="h5 mt-2">Funkce</div><div class=""><?= $user['representative_function'] ?></div></div>
                    </div>
                    <div class="d-flex justify-content-center aling-items-center p-3"><div><a href="<?= base_url('/company-profil') ?>"><div>Zobrazit více</div><div class="d-flex justify-content-center"><i class="fa-solid fa-chevron-down"></i></div></a></div></div>
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
                        <div class="row">
                            <div class="col-12"><div class="h5 mt-2">Lokalita</div><div class=""><?= $company['company_post_code'] . ' ' . $company['company_city'] . ', ' . $company['company_street'] ?></div></div>
                            <div class="col-12"><div class="h5 mt-2">Právní forma</div><div class=""><?php if($company['company_subject'] == 1){echo 'Fyzická osoba';} if($company['company_subject'] == 2){echo 'Pravnická osoba';} ?></div></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="btn-container d-flex flex-wrap justify-content-center align-items-center"><div class="btn-document-export d-flex flex-column justify-content-center align-items-center p-2 m-1"><div class="fw-bold">Počet žáků</div><div><?= $count['userStudent'] ?></div></div><div class="btn-document-export d-flex flex-column justify-content-center align-items-center p-2 m-1"><div class="fw-bold">Počet termínů praxí</div><div><?= $count['practise'] ?></div></div><div class="btn-document-export d-flex flex-column justify-content-center align-items-center p-2 m-1"><div class="fw-bold">Registrované firmy</div><div><?= $count['companyCount'] ?></div></div></div>
<div class="d-flex justify-content-center mt-2"><h3>Žádosti žáků</h3></div>

<div class="d-flex justify-content-center mt-2"><h3>Probíhající praxe</h3></div>

<div class="d-flex justify-content-center mt-2"><h3>Nové termíny praxí</h3></div>
<?= $this->endSection() ?>