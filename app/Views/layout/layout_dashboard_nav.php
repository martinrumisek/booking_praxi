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
        .button-for-nav {
            display: block;
            position: fixed; 
            top: 0px;
            left: 0px;
            width: 50px;
            height: 50px;
            z-index: 9999;
            background-color: none;
            border-radius: 0px 0px 30px 0px;
            }
        .mobile-btn-nav{
            display: block;
            background-color: white;
            box-shadow: 0px 3px 6px #00000029;
            z-index: 9999;
            width: 50px;
            height: 50px;
            border-radius: 0px 0px 30px 0px;
        }
        .nav-logo-mobile{
            width: 50px;
            height: 50px;
        }
        @media (min-height: 800px){
            .button-for-nav{
               display: none; 
            }
        }
        @media (max-height: 800px){
            .block-nav{
                visibility: hidden;
            }
            .button-for-nav{
                display: block;
            }
            .nav-container{
                display: none;
            }
            .nav-item{
                width: 0px;
                height: 0px;
            }
            .nav-logo{
                width: 0px;
            }
            .main-content{
                margin-left: 0;
            }
        }
        @media (min-witdh: 800px){
            
        }
        @media (max-width: 800px){
        .block-nav{
            visibility: hidden;
        }
        .button-for-nav{
            display: block;
        }
            .nav-container{
            width: 0px;
        }
        .nav-item{
            width: 0px;
            height: 0px;
        }
        .nav-logo{
            width: 0px;
        }
        .main-content{
            margin-left: 0;
        }
    }
    </style>
    <div class="d-flex">
        <!-- Navigační panel pro mobilní zobrazení -->
        <div class="button-for-nav">
            <a class="mobile-btn-nav d-flex justify-content-center align-items-center" href="" data-bs-toggle="offcanvas" data-bs-target="#demo"><i class="fa-solid fa-bars"></i></a>
            <!-- offcanvas - který se otvírá pomocí tlačítka výšše, ale jenom pro mobilní zařízení -->
            <div class="offcanvas offcanvas-start" id="demo">
                <div class="offcanvas-header">
                    <div class="d-flex align-items-center">
                        <a href="#" class="d-flex align-items-center"><h1 alt="Booking praxí"><img src="<?=base_url('assets/img/logo/logo_oauh_modra.svg')?>" class="nav-logo-mobile" alt="Logo - OAUH"></h1></a>
                        <p class="nav-text-mobile m-0 p-2 bold h5">BOOKING PRAXÍ</p>
                    </div>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <!-- Hlavní pole v canvas -->
                </div>
            </div>
        </div>
        <!----Navigační panel pro pc----->
        <div class="d-block block-nav">
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
                    <a class="nav-icon" href="#info"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-calendar-days nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Termíny praxí</p></div></div></a>
                    <a class="nav-icon" href="#setting"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-head-side-virus nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Dovednosti</p></div></div></a>
                </div>
                <div class=" mt-auto">
                    <a class="nav-icon" href="#profile"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-user nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Profil</p></div></div></a>
                    <a class="nav-icon" href="<?=base_url('/logout')?>"><div class="nav-item nav-item-logout d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-right-from-bracket nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Odhlásit se</p></div></div></a>
                </div>
            </div>
        </div>
        <!-----Konec navigačního panelu a začátek hlavního obsahu stránky--------->
        <div class="main-content"><?= $this->renderSection('content')?></div>
    </div>
</body>
</html>