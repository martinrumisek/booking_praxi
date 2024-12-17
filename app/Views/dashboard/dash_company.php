<?= $this->extend('layout/layout_dashboard_nav') ?>

<?= $this->section('content') ?>
<style>
    .search-input{
        width: 280px;
        height: 40px;
        border: none;
        border-radius: 30px;
        background-color: white;
        box-shadow: 0px 3px 6px #00000029;
    }
    tr{
        white-space: nowrap;
    }
</style>
<div class="container-fluid">
    <h2>Přehled termínů pro praxe</h2>
    <div class="d-flex m-3">
        <input class="search-input p-2 form-control" type="text" placeholder="Vyhledat">
    </div>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col" class="nowrap">ID/LOGO</th>
                        <th scope="col">Jméno firmy/zást.</th>
                        <th scope="col">IČO</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Telefonní č.</th>
                        <th scope="col">Funkce</th>
                        <th scope="col">Vytvořeno</th>
                        <th scope="col">fce/edit/view..</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                   <?php foreach($companyes as $company){ ?>
                        <tr>
                            <td><?= $company['id']?></td>
                            <td><?= $company['name']?></td>
                            <td><?= $company['ico']?></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td><?= $company['create_time']?></td>
                            <td>fce <!-- Přidat zde tři šipky, které budou rozevírat dropdown-bottom a zde budou věci na výběr --></td>
                        </tr>
                        <?php foreach($company['representative'] as $representativeCompany){?>
                            <!-- Zde je potřeba přidat barvu, pro každé zastápce firmy, bude jiná barva řádku, firma = bíla, všechny zástupci firmy budou pod ní a budou mít světle šedou -->
                            <tr>
                                <td><?= $representativeCompany['id']?></td>
                                <td><?php if(!empty($representativeCompany['degree_before'])){echo $representativeCompany['degree_before'] . ' ';}  echo $representativeCompany['name'] . ' ' . $representativeCompany['surname']; if(!empty($representativeCompany['degree_after'])){echo ' ' . $representativeCompany['degree_after'];} ?></td>
                                <td class="text-center"></td>
                                <td><?= $representativeCompany['mail']?></td>
                                <td><?= $representativeCompany['phone']?></td>
                                <td><?= $representativeCompany['function']?></td>
                                <td><?= $representativeCompany['create_time']?></td>
                                <td>fce <!-- Přidat zde tři šipky, které budou rozevírat dropdown-bottom a zde budou věci na výběr --></td>
                            </tr>
                        <?php }?>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>