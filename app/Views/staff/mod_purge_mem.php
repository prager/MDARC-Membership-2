<div class="modal fade" id="purgeMem<?php echo $mem['id']; ?>" tabindex="-1" aria-labelledby="purgeMemLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="purgeMem<?php echo $mem['id']; ?>Label" class="modal-title">Permanent Purging Member out of DB!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Purge this Member Out of DB: <strong><?php echo $mem['fname'] . ' ' . $mem['lname'] . ' ' . $mem['callsign']; ?> (?)</strong></p>
        <a href="<?php echo base_url() . '/index.php/purge-mem/'. $mem['id']; ?>" class="btn btn-danger"> Purge Member! </a>
        <br>
      </div>
      <div class="modal-footer">&nbsp;
      </div>
    </div>
  </div>
</div>
