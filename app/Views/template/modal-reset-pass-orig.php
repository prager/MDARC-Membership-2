<div class="modal fade" id="reset" tabindex="-1" aria-labelledby="resetLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reset Your Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      <form action="<?php echo base_url() . '/index.php/load-pass' ?>" method="post">
        <div class="modal-body">
            <p class="lead">Enter your Username and Password</p>
                <div class="mb-3">
                    <label for="username" class="col-form-label">
                        Username
                    </label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username"/>
                </div>
                <div class="mb-3">
                    <label for="pass" class="col-form-label">
                        Password
                    </label>
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Enter Password"/>
                </div>
                <div class="mb-3">
                    <label for="pass2" class="col-form-label">
                        Re-enter Password
                    </label>
                    <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Enter Password"/>
                </div>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary"> Submit </button>
      </form>
        </div>
    </div>
    </div>
</div>
