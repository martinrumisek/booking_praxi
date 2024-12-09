<?= $this->extend('layout/layout_dashboard_nav') ?>

<?= $this->section('content') ?>
<style>

</style>
<div class="container">
    <h3 class="text-center">Přidání nového termínu pro praxi</h3>
    <form action="<?= base_url('/sent-date-practise')?>" method="POST">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="d-flex flex-column gap-2">
                    <input type="text" name="name" id="name">
                    <textarea name="description" id="description"></textarea>
                    <input type="date" name="end-new-offer" id="end-new-offer">
                    <input type="text" name="contract-file" id="contract-file">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="d-flex flex-column gap-2">
                    <div class="date-container" id="date-container">
                        <div class="date" id="date-row-1">
                            <input type="date" name="dates[1][date-from]" id="date-from-1">
                            <input type="date" name="dates[1][date-to]" id="date-to-1">
                        </div>
                    </div>
                    <button type="button" class="btn" id="next-date">Přidat další termín</button>
                    <div class="d-flex">
                        <?php foreach($class as $classes){ ?>
                            <div class="d-flex">
                                <input type="checkbox" name="classes[]" value="<?= $classes['id']?>">
                                <p class="m-0"><?= $classes['class'].'.'.$classes['letter_class']?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <input type="submit">
    </form>
</div>
<script>
    let dateCount = 1;

    document.getElementById('next-date').addEventListener('click', function() {
        dateCount++;

        // Vytvoří nový blok pro termín
        const newDateRow = document.createElement('div');
        newDateRow.classList.add('date');
        newDateRow.id = 'date-row-' + dateCount;

        newDateRow.innerHTML = `
            <input type="date" name="dates[${dateCount}][date-from]" id="date-from-${dateCount}">
            
            <input type="date" name="dates[${dateCount}][date-to]" id="date-to-${dateCount}">
        `;
        
        // Přidá nový blok do kontejneru
        document.getElementById('date-container').appendChild(newDateRow);
    });
</script>
<?= $this->endSection() ?>