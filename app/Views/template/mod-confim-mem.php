<!-- Modal -->
<div class="modal fade" id="confirmMem" tabindex="-1" aria-labelledby="confirmMemLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmMemLabel">Confirm Your MDARC Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php echo base_url() . '/index.php/register' ?>" method="post">
        <div class="modal-body">
            <p class="lead">Enter your Email</p>
                <div class="mb-3">
                    <label for="email" class="col-form-label">Enter your Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email"/>
                </div>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary"> Submit </button>
        </form>
        </div>
    </form>
    </div>
  </div>
</div>
