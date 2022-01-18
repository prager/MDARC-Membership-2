<div class="modal fade" id="unDelMem<?php echo $mem['id']; ?>" tabindex="-1" aria-labelledby="unDelMemLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="unDelMem<?php echo $mem['id']; ?>Label" class="modal-title">Member Activation!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Activate Member <strong><?php echo $mem['fname'] . ' ' . $mem['lname'] . ' ' . $mem['callsign']; ?>?</strong></p>
        <a href="<?php echo base_url() . '/index.php/un-delete-mem/'. $mem['id']; ?>" class="btn btn-primary"> Activate </a>
        <br>
      </div>
      <div class="modal-footer">&nbsp;
      </div>
    </div>
  </div>
</div>
