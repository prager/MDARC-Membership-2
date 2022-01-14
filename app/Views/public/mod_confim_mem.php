<!-- Modal -->
<div class="modal fade" id="confirmMem" tabindex="-1" aria-labelledby="confirmMemLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    </form>
    <form action="<?php echo base_url() . '/index.php/register' ?>" class="g-3 needs-validation">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmMemLabel">Set Silent Key?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <label for="email" class="col-form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="email">
            <div class="valid-tooltip">Looks good!</div>
            <div class="invalid-tooltip">Please enter your MDARC email.</div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit Email</button>
      </div>
    </form>
    </div>
  </div>
</div>
