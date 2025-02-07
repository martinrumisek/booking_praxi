<div class="<?php if(session()->getFlashdata('err_message')){echo 'd-block';}else{echo 'd-none';} ?>">
<div class="modal fade<?php if(session()->getFlashdata('err_message')){echo 'show d-block';}?>" id="errModalMessage"  tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="errModal-header d-flex justify-content-between">
        <h4 class="modal-title">Chybová hláška</h4>
        <button type="button" class="btn btn-close-errModal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <div><?= session()->getFlashdata('err_message') ?></div>
      </div>
      <div class="errModal-footer">
        <input class="btn-create" type="submit" placeholder="Obnovit" value="Obnovit">
      </div>
    </div>
  </div>
</div>
</div>