<?= $this->extend('layout/layout_nav') ?>

<?= $this->section('content') ?>
<style>
.card-class{
    width: 18rem;
    height: 200px;
    border-radius: 10px;
    box-shadow: 0px 3px 6px #00000029;
}
.btn-show-people-practise{
    padding: 5px;
    background-color: white;
    border: 1px solid #006DBC;
    border-radius: 15px;
}
.btn-show-people-practise:hover{
    background-color: #006DBC;
    color: white;
}
.practise-actual{
    border: 1px solid green;
}
</style>
<?php 
$today = date('Y-m-d');
?>
<div class="d-flex align-items-center justify-content-center flex-column" style="min-height: 95vh;">
    <h3>Praxe tříd</h3>
    <div class="d-flex flex-wrap">
    <?php if(empty($practiseClasses)){echo 'Není žádná třída zahrnuta v praxi';} ?>
    <?php foreach($practiseClasses as $practiseClass){ ?>
        <div class="card-class d-flex flex-column justify-content-center <?php foreach($practiseClass['dates'] as $date){if($date['date_date_from'] <=  $today && $today <= $date['date_date_to']){echo 'practise-actual';}} ?> align-items-center m-1">
            <div><i class="fa-solid fa-users h2 mt-2"></i></div>
            <h5><?= $practiseClass['class_class'] . '.' . $practiseClass['class_letter_class'] ?></h5>
            <p class="m-0"><?php $count = count($practiseClass['dates']); foreach($practiseClass['dates'] as $date){echo date('d.m.Y', strtotime($date['date_date_from'])) . ' - ' . date('d.m.Y', strtotime($date['date_date_to'])); if($count > 1){echo '<br>'; $count--;}} ?></p>
            <a class="mt-auto btn-show-people-practise m-2" href="<?= base_url('/people-on-practise/'.$practiseClass['class_id']) ?>">Zobrazit žáky</a>
        </div>
    <?php } ?>    
    </div>
    
</div>

<?= $this->endSection() ?>