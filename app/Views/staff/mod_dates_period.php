<!-- Modal -->
<div class="modal fade" id="setDates" tabindex="-1" aria-labelledby="setDatesLabel" aria-hidden="true">
  <form action="<?php echo base_url() . '/index.php/staff-report/period'; ?>" method="post">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="setDatesLabel">Set Dates</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
              <label for="date_start">Date Start</label>
              <input type="date" class="form-control" id="date_start" name="date_start" value="<?php echo date('Y-m-d', (time() - (60 * 60 * 24 * 90))); ?>">
            </div>
        </div>
          <div class="row py-3">
            <div class="col">
              <label for="date_start">Date Stop</label>
              <input type="date" class="form-control" id="date_stop" name="date_stop" value="<?php echo date('Y-m-d', time()); ?>">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </form>
  </div>
</div>
