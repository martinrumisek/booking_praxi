<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>
<style>
    body html{
        background-image: url(<?=base_url('assets/img/background_image/login_background.svg')?>);
        width: 100%;
        min-height: 100%;
    }
    .login-container{
        width: 100%;
        min-height: 100vh;
        max-height: auto;
        background-image: url(<?=base_url('assets/img/background_image/login_background.svg')?>);
    }
    .full-screen{
        width: 100%;
        height: 100vh;
    }
    .loginForCompany{
        min-height: 800px;
        width: 100%;
        background: #F5F5F5 0% 0% no-repeat padding-box;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 0px 0px 212px 0px;
        opacity: 1;
    }
    .title-login{
        margin-top:40px;
    }
    .soc-icon{
        width: 50px;
        height: 50px;
        border-radius: 30px;
    }
    .soc-icon:hover{
        border: 0.5px solid gray;
    }
    a{   
        color: black;
    }
    .soc-icon:hover .fa-facebook{
        color: #3b5998;
    }
    .soc-icon:hover .fa-instagram{
        color:  #C96868;
    }
    .login-input{
        height: 60px;
        background-color: white;
        border: none;
        border-radius:20px;
    }
    .input-text{
        margin-left: 25px;
    }
    .form-button{
        background-color: white;
        color:black;
        font-size: 20px;
        border-radius: 20px;
    }
    .form-button:hover{
        background-color: white;
        color: black;
        box-shadow: 0px 3px 6px #00000029;
    }
    .registration-btn{
        color: gray;
        margin-bottom: 30px;
    }
    .registration-btn:hover{
        color: black;
    }
    .circle-logo{
        width: 200px;
        height: 200px;
        border-radius: 200px;
        background: #FFFFFF 0% 0% no-repeat padding-box;
        box-shadow: 0px 3px 6px #00000029;
        opacity: 1;
        margin-top: 10%;
    }
    .login-logo{
        width: 120px;
        height: 120px;
    }
    .login-oauh{
        background-color: #00a1f1;
        padding: 20px;
        border: none;
        border-radius: 25px;
        color: white;
        text-decoration: none;
    }
    .login-oauh:hover{
        border: 1px solid white;
    }
    .login-oauh-block-company{
        display: none;
    }
    .container-rounded-icon{
        width: 80px;
        height: 80px;
        border-radius: 80px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    input::placeholder{
        font-size: 20px;
    }
    /*oddělání šípek v inputu type number, tak aby nešlo zvětšovat a zmenšovat číslo o jedna*/
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
    -moz-appearance: textfield;
    }
    @media (max-width: 990px){
        .loginForCompany{
            width: 100%;
            min-height: 900px;
        }
    }
</style>
<div class="login-container d-flex align-items-center">
    <div class="container">
        <div class="d-flex justify-content-center"><h1 class="mt-5">BOOKING PRAXÍ</h1></div>
        <div class="d-flex justify-content-center align-items-center mt-4">
            <div class="loginForCompany">
                <div class="d-flex justify-content-center title-login "><h2>Dokončení registrace</h2></div>
                <!--<div class="d-flex justify-content-center"><p>pro firmy</p></div>-->
                <div class="mt-3 container d-flex justify-content-center">
                    <form action="" style="width: 100%;">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="d-flex justify-content-center"><div class="container-rounded-icon d-flex justify-content-center align-items-center"><i class="fa-solid fa-building h3 m-0"></i></div></div><!-- div pro ikonku firmy -->
                                <p class="text-center h5">Firma</p><!-- div pro text, napsané malým "firma" -->
                                <div class="m-3 form-floating">
                                    <!-- Název firmy/instituce-->
                                    <input type="text" class="form-control text-center login-input shadow" placeholder="Název firmy/instituce" id="name_company" name="name_company" value="<?=$name_company?>" disabled >
                                    <label for="name_company" class="h5 input-text">Název firmy/instituce</label>
                                </div>
                                <div class="m-3 form-floating">
                                    <!-- IČO-->
                                    <input type="number" class="form-control text-center login-input shadow" placeholder="IČO" id="ico" name="ico" value="<?=$ico?>" disabled>
                                    <label for="ico" class="h5 input-text">IČO</label>
                                </div>
                                <div class="m-3 form-floating">
                                    <!-- Město/vesnice - sídlo firmy-->
                                    <input type="text" class="form-control text-center login-input shadow" placeholder="Město/vesnice" id="place_company" name="place_company" value="<?=$town?>">
                                    <label for="place_company" class="h5 input-text">Město/vesnice</label>
                                </div>
                                <div class="m-3 form-floating">
                                    <!-- Ulice firmy daného města-->
                                    <input type="text" class="form-control text-center login-input shadow" placeholder="Ulice" id="street_company" name="street_company" value="<?=$street?>">
                                    <label for="street_company" class="h5 input-text">Ulice</label>
                                </div>
                                <div class="m-3 form-floating">
                                    <!-- PSČ daného města-->
                                    <input type="number" class="form-control text-center login-input shadow" placeholder="PSČ" id="post_code_company" name="post_code_company" value="<?=$postCode?>">
                                    <label for="post_code_company" class="h5 input-text">PSČ</label>
                                </div>
                                <div class="m-3 form-floating">
                                    <!---- (((JE potřeba dodělat, zde bude na výběr))) Subject firmy 'právnická' / 'fyzická osoba'-->
                                    <select class="form-control text-center login-input shadow" name="select_subject" id="select_subject">
                                        <option value="0"></option>
                                        <option value="1">Fyzická osoba</option>
                                        <option value="2">Právnická osoba</option>
                                    </select>
                                    <label for="select_subject" class="h5 input-text">Subject</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="d-flex justify-content-center"><div class="container-rounded-icon d-flex justify-content-center align-items-center"><i class="fa-solid fa-user h3 m-0"></i></div></div><!-- div pro ikonku zástupce osob -->
                                <p class="text-center h5">Zástupce firmy</p><!-- div pro text, napsané malým "firma" -->
                                <div class="m-3 form-floating">
                                    <!-- <label for="email" class="form-label h5 input-text">E-mail</label>-->
                                    <input type="text" class="form-control text-center login-input shadow" placeholder="Jméno" id="name" name="name" >
                                    <label for="name" class="h5 input-text">Jméno</label>
                                </div>
                                <div class="m-3 form-floating">
                                    <!-- <label for="email" class="form-label h5 input-text">E-mail</label>-->
                                    <input type="text" class="form-control text-center login-input shadow" placeholder="Přijmení" id="surname" name="surname" >
                                    <label for="surname" class="h5 input-text">Přijmení</label>
                                </div>
                                <div class="m-3 form-floating">
                                    <!-- <label for="email" class="form-label h5 input-text">E-mail</label>-->
                                    <input type="tel" class="form-control text-center login-input shadow" placeholder="Mobilní číslo" id="phone" name="phone" >
                                    <label for="phone" class="h5 input-text">Mobilní číslo</label>
                                </div>
                                <div class="m-3 form-floating">
                                    <!-- <label for="email" class="form-label h5 input-text">E-mail</label>-->
                                    <input type="text" class="form-control text-center login-input shadow" placeholder="Pozice ve firmě" id="function" name="function" >
                                    <label for="function" class="h5 input-text">Pozice ve firmě</label>
                                </div>
                                <div class="m-3 form-floating">
                                    <!-- <label for="email" class="form-label h5 input-text">E-mail</label>-->
                                    <input type="email" class="form-control text-center login-input shadow" placeholder="E-mail" id="mail" name="mail" value="<?=$mail?>" >
                                    <label for="mail" class="h5 input-text">E-mail</label>
                                </div>
                                <div class="m-3 form-floating">
                                    <!-- <label for="email" class="form-label h5 input-text">E-mail</label>-->
                                    <input type="text" class="form-control text-center login-input shadow" placeholder="Heslo" id="passwd1" name="passwd1" value="Heslo bylo vytvořeno!" disabled>
                                    <label for="passwd1" class="h5 input-text">Heslo</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="myCheck" name="remember" required>
                                    <label class="form-check-label" for="myCheck">Souhlas se zpracováním osobních údajů</label>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Check this checkbox to continue.</div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4"><div class="d-flex justify-content-center justify-content-lg-end"><button type="submit" class="btn form-button mt-3 mr-3 px-5">Registrovat se</button></div></div>
                        </div>
                    </form>
                </div>
                <div class="d-flex justify-content-center mt-5"><a class="registration-btn" href="">registrovat znovu</a></div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center mt-4">
            <div class=" d-flex align-items-center justify-content-center m-2 h2 bg-white shadow soc-icon"><a href="https://www.facebook.com/oauh.cz/" aria-label="Facebook - OAUH"><i class="fa-brands fa-facebook"></i></a></div>
            <div class=" d-flex align-items-center justify-content-center m-2 h2 bg-white shadow soc-icon"><a href="https://www.instagram.com/oauh.cz/" aria-label="Instagram - OAUH"><i class="fa-brands fa-instagram"></i></a></div>
            <div class=" d-flex align-items-center justify-content-center m-2 h2 bg-white shadow soc-icon"><a href="https://www.oauh.cz/" aria-label="Webová stránka - OAUH"><i class="fa-solid fa-globe"></i></a></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>