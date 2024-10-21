<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>
<style>
    body html{
        background-image: url(<?=base_url('assets/img/background_image/login_background.svg')?>);
    }
    .login-container{
        width: 100%;
        min-height: 100vh;
        max-height: 200vh;
        background-image: url(<?=base_url('assets/img/background_image/login_background.svg')?>);
    }
    .full-screen{
        width: 100%;
        height: 100vh;
    }
    .registrationForCompany{
        height: 650px;
        width: 45%;
        background: #F5F5F5 0% 0% no-repeat padding-box;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 2px 182px;
        opacity: 1;
    }
    .loginForSchool{
        height: 650px;
        width: 45%;
        background: #006DBC 0% 0% no-repeat padding-box;
        box-shadow: 0px 3px 6px #00000029;
        border-radius: 0px 0px 212px 0px;
        opacity: 1;
    }
    .title-registration{
        margin-top:40px;
    }
    .soc-icon{
        width: 50px;
        height: 50px;
        border-radius: 30px;
    }
    a{
        text-decoration: none;
        color: black;
    }
    .registration-input{
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
    .registration-btn{
        color: gray;
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
    }
    .login-oauh-block-company{
        display: none;
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
        .loginForSchool{
            display:none;
        }
        .registrationForCompany{
            width: 100%;
            height: 690px;
        }
        .login-oauh-block-company{
            display:flex;
        }
    }
</style>
<div class="login-container d-flex align-items-center">
    <div class="container">
        <div class="d-flex justify-content-center"><h1 class="mt-2">BOOKING PRAXÍ</h1></div>
        <div class="d-flex justify-content-center align-items-center mt-4">
            <div class="loginForSchool">
            <div class="d-flex justify-content-center mt-3"><div class="circle-logo d-flex justify-content-center align-items-center"><img class="login-logo" src="<?=base_url('assets/img/logo/logo_oauh_modra.svg')?>" alt=""></div></div>
                <div class="d-flex justify-content-center mt-5"><h2>Jsem z OAUH</h2></div>
                <div class="d-flex justify-content-center mt-2"><a class="login-oauh h5" href="" alt="Přihlášení pro OAUH"><i class="fa-brands fa-microsoft"></i> Přihlásit se jako OAUH</a></div>
            </div>
            <div class="registrationForCompany">
            <div class="d-flex justify-content-center title-registration "><h2>Registrace</h2></div>
                <!--<div class="d-flex justify-content-center"><p>pro firmy</p></div>-->
                <div class="mt-1 container d-flex justify-content-center">
                    <form action="" style="width: 80%;">
                        <div class="mb-3 mt-2">
                            <input type="text" class="form-control text-center registration-input shadow" placeholder="Název firmy/instituce" name="nameCompany" >
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control text-center registration-input shadow" placeholder="IČO" name="ico">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control text-center registration-input shadow" placeholder="E-mail" name="email">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control text-center registration-input shadow" placeholder="Heslo" name="password">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control text-center registration-input shadow" placeholder="Ověření hesla" name="password">
                        </div>
                        <div class="d-flex justify-content-end"><button type="submit" class="btn form-button mt-3 px-5">Registrovat se</button></div>
                    </form>
                </div>
                <div class="d-flex justify-content-center mt-4"><a class="registration-btn" href="">Přihlásit se</a></div>
                <div class=" justify-content-center mt-3 login-oauh-block-company"><a class="login-oauh h5" href="" alt="Přihlášení pro OAUH"><i class="fa-brands fa-microsoft"></i> Přihlásit se jako OAUH</a></div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center mt-4">
            <div class=" d-flex align-items-center justify-content-center m-2 h2 bg-white shadow soc-icon"><a href="#"><i class="fa-brands fa-facebook"></i></a></div>
            <div class=" d-flex align-items-center justify-content-center m-2 h2 bg-white shadow soc-icon"><a href="#"><i class="fa-brands fa-instagram"></i></a></div>
            <div class=" d-flex align-items-center justify-content-center m-2 h2 bg-white shadow soc-icon"><a href="#"><i class="fa-solid fa-globe"></i></a></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>