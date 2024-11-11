<!DOCTYPE html>
<html lang="cs">
<?= $this->include('layout/head')?>
<body>
    <style>
        /* Webkit Browsers (Chrome, Safari, Edge) */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f5f5f5;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #006DBC ;
            border-radius: 50px;
            border: 3px solid #f5f5f5;
        }
    .main-content {
            min-height: 200vh;
            margin-left: 60px; 
            width: 100%;
            transition: margin-left 0.3s ease;
        }
        .nav-text {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .nav-logo{
            margin-top: 16px;
            margin-left: 14px;
            padding-right: 4px;
            width: 45px;
            height: auto;
            opacity: 1;
        }
        .nav-container {
            width: 60px;
            position: fixed; 
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 999;
            background-color: white;
            transition: width 0.3s ease;
            background-color: #FFFFFF 0% 0% no-repeat padding-box;
            box-shadow: 0px 3px 6px #00000029;
            opacity: 1;
        }
        .nav-items{
            margin-top: 43px;
        }
        .nav-item{
            width: 60px;
            height: 60px;
            background-color: #FFFFFF 0 0 no-repeat padding-box;
            box-shadow: 0px 3px 6px #00000029;
            border: 1px solid #FFFFFF;
            opacity: 1;
            text-decoration: none;
            position: relative;
            z-index: 999;
            transition: width 0.3s ease;
        }
        .nav-item:hover{
            background-color: #006DBC;
            border: 1px solid #006DBC;
        }
        .nav-item-logout:hover{
            background-color: red;
            border: 1px solid red;
        }
        .nav-item:hover .nav-text{
            color: white;
        }
        .nav-item:hover .nav-icon{
            color: white;
        }
        a.nav-icon{
            color: black;
            text-decoration: none;
            border: none;
        }
        .nav-item-icon{
            width: 100%;
            transition: width 0.3s ease;
        }
        .nav-item-text{
            width: 0.1%;
            opacity: 0;
            transition: width 0.3s ease;
        }
        .nav-container:hover {
            width: 250px;
        }
        .nav-container:hover .nav-text {
            opacity: 1;
        }
        .nav-container:hover .nav-item {
            width: 250px;
        }
        .nav-container:hover .nav-item-icon{
            opacity: 1;
            width: 30%;
        }
        .nav-container:hover .nav-item-text{
            width: 70%;
            opacity: 1;
        }
        .nav-container:hover ~ .main-content {
            margin-left: 90px;
        }
        @media (max-height: 800px){
            .nav-container{
                width: 50px;
            }
            .nav-item{
                width: 50px;
                height: 50px;
            }
            .nav-logo{
                width: 25px;
            }
            .main-content{
                margin-left: 50px;
            }
        }
        @media (max-width: 800px){
        .nav-container{
            width: 50px;
        }
        .nav-item{
            width: 50px;
            height: 50px;
        }
        .nav-logo{
            width: 25px;
        }
        .main-content{
                margin-left: 50px;
            }
    }
    @media (max-height: 620px){
            .nav-container{
                width: 40px;
            }
            .nav-item{
                width: 40px;
                height: 40px;
            }
            .nav-logo{
                width: 19px;
            }
            .main-content{
                margin-left: 40px;
            }
        }
    </style>
    <div class="d-flex">
        <!----Navigační panel----->
        <div class="d-block">
            <div class="d-block nav-container d-flex sticky-top flex-column">
                <div class="d-flex align-items-center">
                <a href="#"><h1 alt="Booking praxí"><img src="<?=base_url('assets/img/logo/logo_oauh_modra.svg')?>" class="nav-logo" alt="Logo - OAUH"></h1></a>
                <p class="nav-text m-0 p-2 bold h5">BOOKING PRAXÍ</p>
                </div>
                <div class="nav-items">
                    <a class="nav-icon" href="#home"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-house nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Domů</p></div></div></a>
                    <a class="nav-icon" href="#list_praxe"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-list-ul nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Nabídky praxe</p></div></div></a>
                    <a class="nav-icon" href="#people"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-user-group nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Lidé</p></div></div></a>
                    <a class="nav-icon" href="#company"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-building nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Firmy</p></div></div></a>
                    <a class="nav-icon" href="#info"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-circle-info nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Informace</p></div></div></a>
                    <a class="nav-icon" href="#setting"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-gear nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Nastavení</p></div></div></a>
                </div>
                <div class=" mt-auto">
                    <a class="nav-icon" href="#profile"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-user nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Profil</p></div></div></a>
                    <a class="nav-icon" href="#logout"><div class="nav-item nav-item-logout d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-right-from-bracket nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Odhlásit se</p></div></div></a>
                </div>
            </div>
        </div>
        <!-----Konec navigačního panelu a začátek hlavního obsahu stránky--------->
        <div class="main-content"><?= $this->renderSection('content')?></div>
    </div>
    <script>
        // Práce s profilovým kontejnerem
        const profileIcon = document.getElementById('profile-icon');
        const profileContainer = document.querySelector('.nav-profile-container');

        profileIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            const isVisible = profileContainer.style.display === 'block';
            profileContainer.style.display = isVisible ? 'none' : 'block';

            // Zavření po 5s
            if (!isVisible) {
                setTimeout(() => {
                    profileContainer.style.display = 'none';
                }, 5000); 
            }
        });
        //Zavření kontejneru po kliknutí na stránku, kromě samotného kontejneru.
        document.addEventListener('click', function(e) {
            if (!profileContainer.contains(e.target) && !profileIcon.contains(e.target)) {
                profileContainer.style.display = 'none';
            }
        });
    </script>
</body>
</html>