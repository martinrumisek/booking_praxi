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
    .form-button:hover{
        background-color: white;
        color: black;
        box-shadow: 0px 3px 6px #00000029;
    }
    .registration-btn{
        color: gray;
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
    .toggle-pass1, .toggle-pass2 {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      font-size: 18px;
    }
    .invalid-input {
      border: 0.5px solid red !important;
    }
    .requirement {
      color: red;
    }
    .requirement.valid {
      color: green !important;
    }
    .tooltip-inner {
      max-width: none !important;
      width: auto;  
      background-color: white;
      color: red;            
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
                <div class="d-flex justify-content-center mt-5 text-white"><h2>Jsem z OAUH</h2></div>
                <div class="d-flex justify-content-center mt-2"><a class="login-oauh h5" href="<?=base_url('/logAD')?>" alt="Přihlášení pro OAUH"><i class="fa-brands fa-microsoft"></i> Přihlásit se jako OAUH</a></div>
            </div>
            <div class="registrationForCompany">
            <div class="d-flex justify-content-center title-registration "><h2>Nové heslo</h2></div>
                <!--<div class="d-flex justify-content-center"><p>pro firmy</p></div>-->
                <div class="mt-1 container d-flex justify-content-center">
                    <form action="<?=base_url('/new-password')?>" method="POST" style="width: 80%;" id="form" novalidate>
                        <div class="mb-3 form-floating">
                            <input type="password" id="passw1" class="form-control text-center registration-input shadow" placeholder="Nové heslo" name="passwd1" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <label for="passw1" class="h6">Nové heslo</label>
                            <button type="button" class="toggle-pass1"><i class="fa-regular fa-eye" id="toggle-icon1"></i></button>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="password" id="passw2" class="form-control text-center registration-input shadow" placeholder="Potvrzení hesla" name="passwd2" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <label for="passw2" class="h6">Potvrzení hesla</label>
                            <button type="button" class="toggle-pass2"><i class="fa-regular fa-eye" id="toggle-icon2"></i></button>
                        </div>
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <div class="d-flex justify-content-end"><button type="submit" id="submit" class="btn form-button mt-3 px-5">Uložit nové heslo</button></div>
                    </form>
                </div>
                <div class="d-flex justify-content-center mt-4"><a class="registration-btn" href="<?=base_url('/login')?>">Přihlásit se</a></div>
                <div class=" justify-content-center mt-3 login-oauh-block-company"><a class="login-oauh h5" href="<?=base_url('/logAD')?>" alt="Přihlášení pro OAUH"><i class="fa-brands fa-microsoft"></i> Přihlásit se jako OAUH</a></div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center mt-4">
            <div class=" d-flex align-items-center justify-content-center m-2 h2 bg-white shadow soc-icon"><a href="https://www.facebook.com/oauh.cz/" aria-label="Facebook - OAUH"><i class="fa-brands fa-facebook"></i></a></div>
            <div class=" d-flex align-items-center justify-content-center m-2 h2 bg-white shadow soc-icon"><a href="https://www.instagram.com/oauh.cz/" aria-label="Instagram - OAUH"><i class="fa-brands fa-instagram"></i></a></div>
            <div class=" d-flex align-items-center justify-content-center m-2 h2 bg-white shadow soc-icon"><a href="https://www.oauh.cz/" aria-label="Webová stránka - OAUH"><i class="fa-solid fa-globe"></i></a></div>
        </div>
    </div>
</div>
<script>
    //nastavení bodů, které heslo musí obsahovat.
    const requirements = {
        length: /.{8,}/,
        uppercase: /[A-Ž]/,
        lowercase: /[a-ž]/,
        number: /\d/,
        special: /[!\"#$%&'()*+,\-./:;<=>?@\[\\\]^_`{|}~]/,
    };
    const createTooltipContent = (password) => {
        let content = '<ul id="requirements">';
        for (const [key, regex] of Object.entries(requirements)) {
            const isValid = regex.test(password) ? 'valid' : '';
            content += `<li class="requirement ${isValid}" id="${key}">` +
                        (key === 'length' ? 'Heslo musí obsahovat min. 8 znaků.' :
                        key === 'uppercase' ? 'Heslo musí obsahovat min. jedno velké písmeno.' :
                        key === 'lowercase' ? 'Heslo musí obsahovat min. jedno malé písmeno. ' :
                        key === 'number' ? 'Heslo musí obsahovat min. jedno číslo.' :
                        'Heslo musí obsahovat min. jeden speciální znak.') +
                        `</li>`;
        }
        content += '</ul>';
        return content;
    };
    const password1Input = document.getElementById('passw1');
    const password2Input = document.getElementById('passw2');

    const tooltipPassword = new bootstrap.Tooltip(password1Input, {
        html: true,
        title: () => createTooltipContent(password1Input.value),
        trigger: 'auto',
    });
    
    const validatePassword = () => {
        const password = password1Input.value;
        const allValid = Object.values(requirements).every((regex) => regex.test(password));
        if(password === ''){
            password1Input.classList.add('invalid-input');
            return;
        }
        if (password && !allValid) {
            password1Input.classList.add('invalid-input');
        } else {
            password1Input.classList.remove('invalid-input');
        }
        tooltipPassword.setContent({'.tooltip-inner': createTooltipContent(password),});
    };
    
    password1Input.addEventListener('input', validatePassword);
    password1Input.addEventListener('focus', validatePassword);
    password1Input.addEventListener('blur', validatePassword);

    const tooltipPasswordMatch = new bootstrap.Tooltip(password2Input, {
        html: true,
        title: "Hesla se neshodují",
        trigger: "auto" // 
    });

    // Kontrola hesel, jestli se shodují
    const checkPasswordsMatch = () => {
        const password1 = password1Input.value;
        const password2 = password2Input.value;
    
        if (password1 && password2 && password1 !== password2) {
            tooltipPasswordMatch.show();
            password2Input.classList.add('invalid-input');
        } else {
            tooltipPasswordMatch.hide();
            password2Input.classList.remove('invalid-input');
        }
    };
    password1Input.addEventListener('input', checkPasswordsMatch);
    password2Input.addEventListener('input', checkPasswordsMatch);

    document.querySelector('form').addEventListener('submit', (event) => {
        let isValid = true;

        validatePassword();
        if (password1Input.classList.contains('invalid-input')) {
            isValid = false;
        }
        checkPasswordsMatch();
        if (password2Input.classList.contains('invalid-input')) {
            isValid = false;
        }
        if (!isValid) {
            event.preventDefault();
        }
    });  

    //Zobrazení hesla pomocí ikonky a zároveň měnění ikonky podle situace.
    const togglePassword1Button = document.querySelector('.toggle-pass1');
    const togglePassword2Button = document.querySelector('.toggle-pass2');
    const toggleIcon1 = document.getElementById('toggle-icon1');
    const toggleIcon2 = document.getElementById('toggle-icon2');
    togglePassword1Button.addEventListener('click', () => {
        if (password1Input.type === 'password') {
        password1Input.type = 'text';
        toggleIcon1.classList.remove('fa-eye');
        toggleIcon1.classList.add('fa-eye-slash');
        } else {
        password1Input.type = 'password';
        toggleIcon1.classList.remove('fa-eye-slash');
        toggleIcon1.classList.add('fa-eye');
        }
    });
    togglePassword2Button.addEventListener('click', () => {
        if (password2Input.type === 'password') {
        password2Input.type = 'text';
        toggleIcon2.classList.remove('fa-eye');
        toggleIcon2.classList.add('fa-eye-slash');
        } else {
        password2Input.type = 'password';
        toggleIcon2.classList.remove('fa-eye-slash');
        toggleIcon2.classList.add('fa-eye');
        }
    });
</script>
<?= $this->endSection() ?>