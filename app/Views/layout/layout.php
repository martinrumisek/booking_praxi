<!DOCTYPE html>
<html lang="cs">
<?= $this->include('layout/head')?>
<body>
<?= $this->renderSection('content')?>
<?= view('layout/errModal') ?>
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