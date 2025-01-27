<?= $this->extend('layout/layout_nav') ?>

<?= $this->section('content') ?>
<style>

</style>
<?php 
foreach($offerPractises as $offer){
    echo $offer['manager_name'] . '   ' . $offer['offer_name'] . '    ' . $offer['practise_name'];
    foreach($offer['dates'] as $date){
        echo $date['date_date_from'];
    }
    echo '<br>';
}
?>
<?= $this->endSection() ?>