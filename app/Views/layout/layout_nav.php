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
            padding-left: 60px; 
            width: 100%;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        .nav-text {
            opacity: 0;
            transition: opacity 0.5s ease;
            text-wrap: nowrap;
            overflow: hidden;
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
            transition: width 0.5s ease;
            background-color: #FFFFFF 0% 0% no-repeat padding-box;
            box-shadow: 0px 3px 6px #00000029;
            opacity: 1;
        }
        .nav-items{
            margin-top: 43px;
        }
        a{
            text-decoration: none;
            color: black;
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
            transition: width 0.5s ease;
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
            transition: width 0.5s ease;
        }
        .nav-item-text{
            width: 0.1%;
            opacity: 0;
            transition: width 0.5s ease;
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
            padding-left: 90px;
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
        .nav-mobile{
            display: block;
            background-color: #006DBC;
        }
        .nav-icon-mobile{
            width: 50px;
            height: 50px;
            margin-left: 2.5px;
            margin-right: 2.5px;
            margin-top: 2px;
            margin-bottom: 2px;
            background-color: white;
            box-shadow: 0px 3px 6px #00000029;
            border-radius: 7px;
        }
        .nav-icon-canvas{
            width: 80%;
            background-color: white;
            box-shadow: 0px 3px 6px #00000029;
            padding: 10px;
            border-radius: 15px;
            margin-top: 15px;
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
        @media (min-height: 700px){
            .button-for-nav{
               display: none; 
            }
            .nav-mobile{
                display:none
            }
        }
        @media (max-height: 700px){
            .block-nav{
                visibility: hidden;
            }
            .button-for-nav{
                display: block;
            }
            .nav-mobile{
                display:block;
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
                padding-left: 0;
                margin-bottom: 55px;
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
        .nav-mobile{
            display:block
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
            padding-left: 0;
            margin-bottom: 55px;
        }
    }
    </style>
<?php
    $role = session()->get('role');
    $isStudent = in_array('student', $role);
    $isTeacher = in_array('teacher', $role);
    $isCompany = in_array('company', $role);
    $isAdmin = in_array('admin', $role);
    $isSpravce = in_array('spravce', $role);
    if($isStudent){
        $home = base_url('/home-student');
        $listPractise = base_url('/practise-offer');
        $people = base_url('/people');
        $company = base_url('/company');
        $info = base_url('/info');
        $dashboard =  base_url('/dashboard-home');
        $profile = base_url('/profile');

        $logOut = base_url('/logout'); // #student
    }
    if($isTeacher){
        $home = base_url('home-teacher');
        $listPractise = base_url('class-on-practise');
        $people = base_url('/people');
        $company = base_url('/company');
        $info = base_url('/info');
        $dashboard = base_url('/dashboard-home');
        //$profile = '#teacher'; //base_url('#'); //! Učitel nebude mít žádný profil, není potřeba mít profil.

        $logOut = base_url('/logout'); // #teacher
    }
    if($isCompany){
        $home = base_url('home-company');
        $listPractise = base_url('company-offer-practises');
        $people = base_url('/people');
        $company = '#company'; //base_url('#');
        $info = base_url('/info');
        $profile = base_url('company-profil');
        $addPractise = base_url('/company-add-offer-practise');
        $logOut = base_url('/logOutCompany'); // #company
    }
?>
<?= view('layout/errModal') ?>
    <div class="d-flex">
        <!----Navigační panel pro pc----->
        <div class="d-block block-nav">
            <div class="d-block nav-container d-flex sticky-top flex-column">
                <div class="d-flex align-items-center">
                <a href="<?= $home?>"><h1 alt="Booking praxí"><img src="<?=base_url('assets/img/logo/logo_oauh_modra.svg')?>" class="nav-logo" alt="Logo - OAUH"></h1></a>
                <p class="nav-text m-0 p-2 bold h5">BOOKING PRAXÍ</p>
                </div>
                <div class="nav-items">
                    <a class="nav-icon" href="<?= $home?>"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-house nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Domů</p></div></div></a>
                    <?php if($isCompany){ ?> <a class="nav-icon" href="<?= $listPractise?>"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-list-ul nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Naše nabídky</p></div></div></a><?php } ?>
                    <?php if($isStudent){ ?><a class="nav-icon" href="<?= $listPractise?>"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-list-ul nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Nabídky praxe</p></div></div></a><?php } ?>
                    <?php if($isTeacher){ ?><a class="nav-icon" href="<?= $listPractise?>"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-list-ul nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Praxe</p></div></div></a><?php } ?>
                    <a class="nav-icon" href="<?= $people?>"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-user-group nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Lidé</p></div></div></a>
                    <?php if($isTeacher || $isStudent){ ?><a class="nav-icon" href="<?= $company?>"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-building nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Firmy</p></div></div></a><?php } ?>
                    <a class="nav-icon" href="<?= $info?>"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-circle-info nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Informace</p></div></div></a>
                    <?php if($isCompany){ ?><a class="nav-icon" href="<?= $addPractise?>"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-file-circle-plus nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Přidat praxi</p></div></div></a><?php } ?>
                    <?php if($isAdmin || $isSpravce){ ?><a class="nav-icon" href="<?= $dashboard?>"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-gear nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Nastavení</p></div></div></a> <?php } ?>
                </div>
                <div class=" mt-auto">
                    <?php if($isStudent || $isCompany){ ?><a class="nav-icon" href="<?= $profile?>"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-user nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Profil</p></div></div></a><?php }?>
                    <a class="nav-icon" href="<?= $logOut?>"><div class="nav-item nav-item-logout d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-right-from-bracket nav-icon h4 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Odhlásit se</p></div></div></a>
                </div>
            </div>
        </div>
        <!-----Konec navigačního panelu a začátek hlavního obsahu stránky--------->
        <div class="main-content"><?= $this->renderSection('content')?></div>
        <!-- Navigační panel pro mobil -->
        <nav class="navbar navbar-expand-sm fixed-bottom nav-mobile p-0">
            <div class="container-fluid p-0">
                <div class="d-flex justify-content-center" style="width:100%">
                    <a class="nav-icon-mobile d-flex align-items-center justify-content-center" href="<?= $home?>"><div class="d-flex flex-column align-items-center justify-content-center"><i class="fa-solid fa-house nav-icon h4 m-0"></i><span class="mt-auto p-0" style="font-size: 9px;">Domů</span></div></a>
                    <?php if($isStudent || $isCompany){ ?><a class="nav-icon-mobile d-flex align-items-center justify-content-center" href="<?= $listPractise?>"><div class="d-flex flex-column align-items-center justify-content-center"><i class="fa-solid fa-list-ul nav-icon h4 m-0"></i><span class="mt-auto p-0" style="font-size: 9px;">Nabídky</span></div></a> <?php } ?>
                    <?php if($isTeacher){ ?><a class="nav-icon-mobile d-flex align-items-center justify-content-center" href="<?= $listPractise?>"><div class="d-flex flex-column align-items-center justify-content-center"><i class="fa-solid fa-list-ul nav-icon h4 m-0"></i><span class="mt-auto p-0" style="font-size: 9px;">Praxe</span></div></a> <?php } ?>
                    <?php if($isStudent || $isTeacher){ ?><a class="nav-icon-mobile d-flex align-items-center justify-content-center" href="<?= $company?>"><div class="d-flex flex-column align-items-center justify-content-center"><i class="fa-solid fa-building nav-icon h4 m-0"></i><span class="mt-auto p-0" style="font-size: 9px;">Firmy</span></div></a> <?php }?>
                    <?php if($isCompany){ ?><a class="nav-icon-mobile d-flex align-items-center justify-content-center" href="<?= $addPractise?>"><div class="d-flex flex-column align-items-center justify-content-center"><i class="fa-solid fa-file-circle-plus nav-icon h4 m-0"></i><span class="mt-auto p-0" style="font-size: 9px;">Přidat</span></div></a><?php } ?>
                    <?php if($isStudent || $isCompany){ ?><a class="nav-icon-mobile d-flex align-items-center justify-content-center" href="<?= $profile?>"><div class="d-flex flex-column align-items-center justify-content-center"><i class="fa-solid fa-user nav-icon h4 m-0"></i><span class="mt-auto p-0" style="font-size: 9px;">Profil</span></div></a><?php } ?>
                    <a class="nav-icon-mobile d-flex align-items-center justify-content-center" href="#nav-mobile"  data-bs-toggle="offcanvas" data-bs-target="#nav-mobile"><div class="d-flex flex-column align-items-center justify-content-center"><i class="fa-solid fa-ellipsis-vertical nav-icon h4 m-0"></i><span class="mt-auto p-0" style="font-size: 9px;">Více</span></div></a>
                </div>
            </div>
        </nav>
        <div class="offcanvas offcanvas-start" id="nav-mobile" style="width:100%">
                <div class="offcanvas-header">
                    <div class="d-flex align-items-center">
                        <a href="#" class="d-flex align-items-center"><h1 alt="Booking praxí"><img src="<?=base_url('assets/img/logo/logo_oauh_modra.svg')?>" class="nav-logo-mobile" alt="Logo - OAUH"></h1></a>
                        <p class="nav-text-mobile m-0 p-2 bold h5">BOOKING PRAXÍ</p>
                    </div>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body container d-flex flex-column align-items-center">
                    <a class="nav-icon-canvas d-flex align-items-center" href="<?= $home?>"><div class="flex-shrink-0"><i class="fa-solid fa-house nav-icon h4 m-0"></i></div><div class="flex-grow-1 ms-3 h6 text-bold">Domů</div></a>
                    <?php if($isStudent){ ?><a class="nav-icon-canvas d-flex align-items-center" href="<?= $listPractise?>"><div class="flex-shrink-0"><i class="fa-solid fa-list-ul nav-icon h4 m-0"></i></div><div class="flex-grow-1 ms-3 h6 text-bold">Nabídka praxe</div></a><?php }?>
                    <?php if($isCompany){ ?><a class="nav-icon-canvas d-flex align-items-center" href="<?= $listPractise?>"><div class="flex-shrink-0"><i class="fa-solid fa-list-ul nav-icon h4 m-0"></i></div><div class="flex-grow-1 ms-3 h6 text-bold">Naše nabídky</div></a><?php }?>
                    <?php if($isTeacher){ ?><a class="nav-icon-canvas d-flex align-items-center" href="<?= $listPractise?>"><div class="flex-shrink-0"><i class="fa-solid fa-list-ul nav-icon h4 m-0"></i></div><div class="flex-grow-1 ms-3 h6 text-bold">Praxe</div></a><?php }?>
                    <?php if($isCompany){ ?><a class="nav-icon-canvas d-flex align-items-center" href="<?= $addPractise?>"><div class="flex-shrink-0"><i class="fa-solid fa-file-circle-plus nav-icon h4 m-0"></i></div><div class="flex-grow-1 ms-3 h6 text-bold">Přidat nabídku</div></a><?php }?>
                    <a class="nav-icon-canvas d-flex align-items-center" href="<?= $people?>"><div class="flex-shrink-0"><i class="fa-solid fa-user-group nav-icon h4 m-0"></i></div><div class="flex-grow-1 ms-3 h6 text-bold">Lidé</div></a>
                    <?php if($isStudent || $isCompany){ ?><a class="nav-icon-canvas d-flex align-items-center" href="<?= $company?>"><div class="flex-shrink-0"><i class="fa-solid fa-building nav-icon h4 m-0"></i></div><div class="flex-grow-1 ms-3 h6 text-bold">Firmy</div></a><?php } ?>
                    <a class="nav-icon-canvas d-flex align-items-center" href="<?= $info?>"><div class="flex-shrink-0"><i class="fa-solid fa-circle-info nav-icon h4 m-0"></i></div><div class="flex-grow-1 ms-3 h6 text-bold">Informace</div></a>
                    <?php if($isAdmin || $isSpravce){ ?><a class="nav-icon-canvas d-flex align-items-center" href="<?= $dashboard?>"><div class="flex-shrink-0"><i class="fa-solid fa-gear nav-icon h4 m-0"></i></div><div class="flex-grow-1 ms-3 h6 text-bold">Nastavení</div></a><?php } ?>
                    <?php if($isStudent || $isCompany){ ?><a class="nav-icon-canvas d-flex align-items-center" href="<?= $profile?>"><div class="flex-shrink-0"><i class="fa-solid fa-user nav-icon h4 m-0"></i></div><div class="flex-grow-1 ms-3 h6 text-bold">Profil</div></a> <?php }?>
                    <a class="nav-icon-canvas d-flex align-items-center" href="<?= $logOut?>"><div class="flex-shrink-0"><i class="fa-solid fa-right-from-bracket nav-icon h4 m-0"></i></div><div class="flex-grow-1 ms-3 h6 text-bold">Odhlásit se</div></a>
                </div>
            </div>
    </div>
<script>
tinymce.init({
  selector: 'textarea.editor-mce',
  license_key: 'gpl'
});
</script>
<?php if ($error = session()->getFlashdata('err_message')){ ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var errorMessage = "<?= esc($error); ?>"; 
            document.getElementById('errorMessage').textContent = errorMessage;
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        });
    </script>
<?php }?>    
</body>
</html>