<!DOCTYPE html>
<html lang="cs">
<?= $this->include('layout/head')?>
<body>
    <style>
    .main-content {
            min-height: 200vh;
            margin-left: 90px; 
            transition: margin-left 0.3s ease;
        }
        .nav-text {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .nav-container {
            width: 82px;
            position: fixed; 
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 999;
            background-color: white;
            transition: width 0.3s ease;
        }
        .nav-item{
            transition: width 0.3s ease;
        }
        a.nav-icon{
            text-decoration: none;
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
        .nav-profile-container{
            width: 350px;
            height: 120px;
            background: #FFFFFF 0% 0% no-repeat padding-box;
            border: 1px solid #707070;
            border-radius: 53px;
            opacity: 1;
            margin-top: 60px;
        }
        #profile-icon{
            box-shadow: 0px 3px 6px #00000029;
            border-radius: 100%;
            width:50px;
            height: 50px
        }
    </style>
    <div class="nav-profile-icon fixed-top d-flex justify-content-end m-3 p-2 ">
        <!---Kontejner pro profil---->
        <div class="nav-profile-container" style="display: none;">
            <!-- <div class="d-flex justify-content-center align-items-center">
                <a id="" class="nav-profile bg-white p-3 shadow-xl rounded-pill h3" href="#"><i class="fa-solid fa-user d-flex justify-content-center align-items-center"></i></a>
                <div><p>Martin Rumíšek</p><br><span>Uživatel</span></div>
            </div> -->
        </div>
        <!---profil--->
        <a id="profile-icon" class="nav-profile bg-white p-3 shadow-xl rounded-pill h3" href="javascript:void(0)"><i class="fa-solid fa-user d-flex justify-content-center align-items-center"></i></a>
    </div>
    <div class="d-flex">
        <!----Navigační panel----->
        <div class="d-block">
            <div class="d-block nav-container d-flex sticky-top flex-column">
                <div class="d-flex align-items-center">
                <a href="#"><h1 alt="Booking praxí"><img src="<?=base_url('assets/img/logo/logo_oauh_modra.svg')?>" class="nav-logo" alt="Logo - OAUH"></h1></a>
                <p class="nav-text m-0 p-2 bold h5">BOOKING PRAXÍ</p>
                </div>
                <div class="nav-items">
                    <a class="nav-icon" href="#1"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-house nav-icon h2 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Domů</p></div></div></a>
                    <a class="nav-icon" href="#1"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-list-ul nav-icon h2 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Nabídky praxe</p></div></div></a>
                    <a class="nav-icon" href="#1"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-user-group nav-icon h2 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Lidé</p></div></div></a>
                    <a class="nav-icon" href="#1"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-building nav-icon h2 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Firmy</p></div></div></a>
                    <a class="nav-icon" href="#1"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-circle-info nav-icon h2 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Informace</p></div></div></a>
                    <a class="nav-icon" href="#1"><div class="nav-item d-flex justify-content-center align-items-center"><div class="nav-item-icon  d-flex justify-content-center aling-items-center"><i class="fa-solid fa-gear nav-icon h2 m-0"></i></div><div class="nav-item-text d-flex aling-items-center"><p class="nav-text m-0 h6 text-bold">Nastavení</p></div></div></a>
                </div>
                <div class=" d-flex align-content-end justify-content-center mt-auto">
                    <div class="nav-soc-items rounded-pill mb-3">
                        <a style="text-decoration: none;" class="nav-soc rounded-pill h5 my-3 mx-3 d-flex justify-content-center align-items-center" href="#"><i class="fa-solid fa-globe"></i></a>
                        <a style="text-decoration: none;" class="nav-soc rounded-pill h5 my-3 mx-3 d-flex justify-content-center align-items-center" href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a style="text-decoration: none;" class="nav-soc rounded-pill h5 my-2 mx-3 d-flex justify-content-center align-items-center" href="#"><i class="fa-brands fa-facebook"></i></a>
                    </div>
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