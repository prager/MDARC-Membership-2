<div class="modal fade" id="login" tabindex="-1" aria-labelledby="loginLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      <form action="<?php echo base_url() . '/index.php/login' ?>" method="post">
        <div class="modal-body">
            <p class="lead">Enter your Username and Password</p>
                <div class="mb-3">
                    <label for="user" class="col-form-label">
                        Username
                    </label>
                    <input type="text" class="form-control" id="user" name="user" placeholder="Enter Username"/>
                </div>
                <div class="mb-3">
                    <label for="pass" class="col-form-label">
                        Password
                    </label>
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Enter Password"/>
                </div>
                <div class="mb-3">
                  <p><small>Lost password? Click <a href="#" data-bs-toggle="modal" data-bs-target="#reset">here</a>
                </div>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary"> Submit </button>
        </form>
        </div>
    </div>
    </div>
</div>
