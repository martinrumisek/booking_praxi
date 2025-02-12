<?= $this->extend('layout/layout_nav') ?>

<?= $this->section('content') ?>
<style>
    .icon-practise{
        background-color: #006DBC;
        color: white;
        padding: 15px;
        margin: 5px;
        border-radius: 100%;
        box-shadow: 0px 3px 6px #00000029;
    }
    .container-practise{
        box-shadow: 0px 3px 6px #00000029;
    }
    .practise-break{
        height: 2px;
        background-color: #006DBC;
    }
    .card-people-offer-practise{
        width: 20rem;
        height: 100px;
        box-shadow: 0px 1px 3px #00000029;
        border-radius: 10px;
    }
    .text-user-practise{
        font-size: 12px;
    }
</style>
<div class="container-fluid">
    <h2>Přehled naších nabídek praxí</h2>
    <div class="row">
    <?php foreach($offerPractises as $offer){ ?>
        <div class="col-12 col-lg-4 d-flex align-items-center mt-2 container-practise">
            <div class="container">
            <div class="d-flex justify-content-center">
                <div><i class="fa-solid fa-briefcase h1 icon-practise"></i></div>
            </div>
            <div class="d-flex"><div class="p-1 fw-bold">Název praxe: </div><div class="p-1"> <?= $offer['offer_name'] ?> </div></div>
            <?php $count = 1; foreach($offer['dates'] as $date){ ?>
                <div class="d-flex"><div class="p-1 fw-bold">Termín <?= $count  . ':'?></div><div class="p-1"> <?=  date('d.m.Y', strtotime($date['date_date_from'])) . ' - ' . date('d.m.Y', strtotime($date['date_date_from'])) ?> </div></div>
            <?php $count++; }  ?>
            <div class="container d-flex justify-content-end flex-wrap">
                <a class="m-1" href="<?= base_url('practise-offer-view/'.$offer['offer_id']) ?>"><i class="fa-solid fa-eye p-1"></i>Zobrazit</a>
                <?php if(empty($offer['users']) || isset($offer['users']['']) && is_null($offer['users']['']['user_id'])){ ?><a class="m-1" href=""><i class="fa-solid fa-pencil p-1"></i>Upravit</a><?php } ?>
                <?php  ?><a class="m-1" href=""><i class="fa-solid fa-trash p-1"></i>Smazat</a><?php  ?>
            </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 mt-2 d-flex flex-wrap">
           <?php foreach($offer['users'] as $user){ ?>
            <?php if($user['user_offer_id'] == null){ ?>
                <div class="d-flex justify-content-center align-items-center" style="width: 100%">Praxi si nikdo nevybral</div>
            <?php }else{ ?>
                <div class="card-people-offer-practise d-flex flex-column m-1">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                        <i class="fa-solid fa-user p-2 h5 m-0"></i>
                        <p class=" m-0 h6"><?= $user['user_name'] . ' ' . $user['user_surname'] ?></p>
                        </div>
                        <a href="<?= base_url('profile/'.$user['user_id']) ?>"><i class="fa-solid fa-eye p-1"></i></a>
                    </div>
                    <div class="d-flex">
                        <p class="m-0 text-user-practise p-1">Třida: <?= $user['class_class'] . '.' . $user['class_letter_class'] ?></p>
                        <p class="m-0 text-user-practise p-1">Obor: <?= $user['field_name'] ?></p>
                    </div>
                    <div class="d-flex justify-content-end">
                        <form id="not-accepted-user-<?= $user['user_id'] ?>" action="<?= base_url('/not-accepted-user-practise') ?>" method="POST">
                            <input type="hidden" name="offer_id" value="<?= $offer['offer_id'] ?>">
                            <input type="hidden" name="user_offer_id" value="<?= $user['user_offer_id'] ?>">
                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                            <input type="hidden" name="manager_id" value="<?= $offer['manager_id'] ?>">
                        </form>
                        <a class="m-2" onclick="document.getElementById('not-accepted-user-<?= $user['user_id']?>').submit(); return false;" href="#"><i class="fa-solid fa-xmark"></i></a>
                        <form id="accepted-user-<?= $user['user_id']?>" action="<?= base_url('/accepted-user-practise') ?>" method="POST">
                            <input type="hidden" name="offer_id" value="<?= $offer['offer_id'] ?>">
                            <input type="hidden" name="user_offer_id" value="<?= $user['user_offer_id'] ?>">
                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                            <input type="hidden" name="manager_id" value="<?= $offer['manager_id'] ?>">
                        </form>
                        <a class="m-2" href="#" onclick="document.getElementById('accepted-user-<?= $user['user_id']?>').submit(); return false;"><i class="fa-solid fa-check"></i></a>
                    </div>
                </div>
           <?php }}  ?>
        </div>
        <div class="col-12 mt-2 practise-break"></div>
    <?php } ?>
    </div>
</div>
<?= $this->endSection() ?>