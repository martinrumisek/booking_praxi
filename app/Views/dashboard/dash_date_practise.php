<?= $this->extend('layout/layout_dashboard_nav') ?>

<?= $this->section('content') ?>
<style>
.practise-card{
    width: 20rem;
    height: 140px;
    background-color: white;
    border-radius: 20px;
    box-shadow: 0px 3px 6px #00000029;
}
.btn-all-offer{
    padding: 8px;
    background-color: white;
    color: #006DBC;
    border: 1px solid #006DBC ;
    border-radius: 10px;
    box-shadow: 0px 3px 6px #00000029;
}
.btn-all-offer:hover{
    background-color: #006DBC;
    color: white;
}
.container-no-practise{
    padding: 8px;
    border-radius: 8px;
    box-shadow: 0px 3px 6px #00000029;
    background-color: white;
}
</style>
<div class="d-flex flex-column container justify-content-center align-items-center" style="height: 100%;">
    <h2>Správa praxí</h2>
<div class="d-flex flex-wrap container justify-content-center align-items-center">
<?php if(empty($practises)){ ?>
<div class="d-flex align-items-center justify-content-center container-no-practise mt-2">Nejsou žádné termíny</div>        
<?php }?>
<?php foreach($practises as $practise){ ?>
    <div class="m-2 practise-card d-flex flex-column align-items-center justify-content-center" >
        <div class="text-center fw-bold"><?= $practise['practise_name'] ?></div>
        <div class="d-flex">
        <i class="fa-solid fa-calendar-days p-1 d-flex align-items-center"></i>
        <div class="p-1 d-flex align-items-center"><?php $count = count($practise['dates']); foreach($practise['dates'] as $date){echo date('d.m.Y', strtotime($date['date_date_from'])) . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])); if($count > 1){echo ' / '; $count--;}} ?></div>
        </div>
        <div class="d-flex justify-content-center"><a class="btn-all-offer" href="<?= base_url('dashboard-offer-view/' . $practise['practise_id']) ?>">Zobrazit</a></div>
    </div>
<?php } ?>
</div>
</div>
<?= $this->endSection() ?>