<!-- Modal -->
<div class="modal fade" id="silentDate<?php echo $mem['id']; ?>" tabindex="-1" aria-labelledby="silentDate<?php echo $mem['id']; ?>Label" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="silentDate<?php echo $mem['id']; ?>Label">Set Silent Key?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <p>Set date of Passing for Silent Key <strong>
              <?php echo $mem['fname'] . ' ' . $mem['lname'] . ' ' . $mem['callsign']; ?>?</strong></p><br><br>
          </div>
        </div>
          <div class="row">
            <div class="col">
              <label for="fname">Silent Key Date</label>
              <?php
              $mem['silent_date'] == "No Date" ? $silent = date('Y-m-d', time()) : $silent = $mem['silent_date'];
              ?>
              <input type="date" class="form-control" id="silent_date" name="silent_date" value="<?php echo $silent; ?>">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
