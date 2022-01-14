<section id="learn" class="p-5">
  <div class="container">
    <div class="row pt-5 px-5">
      <div class="col-lg p-2">
        <h5>Set Your Password</h5>
      </div>
    </div>
    <?php if($msg != '') {?>
      <div class="row p-2">
        <div class="col-lg-8 py-3">
          <p><?php echo $msg; ?></p>
        </div>
      </div>
    <?php }?>
    <form action="<?php echo base_url() . '/index.php/change-user-pass/'. $email_key; ?>" method="post">
    <div class="row px-5">
      <div class="col-lg-4">
        <label for="lname">Enter Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Your Username">
      </div>
    </div>
    <div class="row px-5 pt-3">
      <div class="col-lg-4">
        <label for="lname">Set Your Password</label>
        <input type="password" class="form-control" id="pass" name="pass" placeholder="Enter Password">
      </div>
    </div>
    <div class="row px-5 pt-3">
      <div class="col-lg-4">
        <label for="lname">Re-Enter Password</label>
        <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Re-Enter Password">
      </div>
    </div>
    <div class="row px-5">
      <div class='col-lg px-3 pt-4'>
        <input class="btn btn-primary" type="submit" value=" Set Your Password ">
      </div>
    </div>
    </form>
    </div>
</section>
