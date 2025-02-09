<style>
  .errModal-header{
      background-color:rgb(188, 0, 0);
      color: white;
      box-shadow: 0px 3px 6px #00000029;
    }
    .btn-close-errModal{
      background-color:rgb(188, 0, 0);
      color: white;
      border: none;
      border-radius: 100%;
    }
    .btn-close-errModal:hover{
      color: black;
    }
</style>
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header errModal-header d-flex justify-content-between">
        <h4 class="modal-title fw-bold">CHYBA!</h4>
        <button type="button" class="btn btn-close-errModal d-flex" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark h3 m-0"></i></button>
      </div>
      <div class="modal-body">
        <p id="errorMessage"></p>
      </div>
    </div>
  </div>
</div>