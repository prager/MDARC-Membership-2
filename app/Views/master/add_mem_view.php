<section id="learn" class="p-5">
  <div class="container">
    <form action="<?php echo base_url() . '/index.php/edit-mem'; ?>" method="post">
      <div class="row px-5 py-3">
        <div class="col-lg p-2">
          <h5>Add MDARC Member</h5>
        </div>
      </div>
    <div class="row px-5">
      <div class="col-lg p-2">
        <label for="fname">First Name</label>
        <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name">
      </div>
      <div class="col-lg p-2">
          <label for="lname">Last Name</label>
          <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
      </div>
      <div class="col-lg p-2">
          <label for="callsign">Callsign</label>
          <input type="text" class="form-control" id="callsign" name="callsign" placeholder="Callsign">
      </div>
    </div>
    <div class="row px-5">
      <div class="col-lg-4 p-2">
        <label for="sel_lic">License Type</label>
        <select class="form-select" name="sel_lic">
          <?php
            foreach($lic as $license) {
              if($license == 'Technician') { ?>
                <option value="<?php echo $license; ?>" selected><?php echo $license; ?></option>
          <?php    }
              else { ?>
                <option value="<?php echo $license; ?>"><?php echo $license; ?></option>
          <?php }
            }
          ?>
        </select>
      </div>
      <div class="col-lg-4 p-2">
        <label for="sel_lic">Member Type</label>
        <select class="form-select" name="mem_types">
          <?php
            foreach($mem_types as $type) {
              if($type['id'] == 1) {?>
                <option value="<?php echo $type['id']; ?>" selected><?php echo $type['description']; ?></option>
              <?php }
              elseif($type['id'] == 5) { ?>
                <option value="<?php echo $type['id']; ?>"><?php echo $type['description']; ?></option>
          <?php  }
            }
          ?>
        </select>
      </div>
    </div>
    <div class="row px-5">
      <div class="col-lg p-2">
        <label for="w_phone">Cell Phone</label>
        <input type="text" class="form-control" id="w_phone" name="w_phone" placeholder="Cell Phone">
      </div>
      <div class="col-lg p-2">
        <label for="h_phone">Home Phone</label>
        <input type="text" class="form-control" id="h_phone" name="h_phone" placeholder="Home Phone">
      </div>
      <div class="col-lg p-2">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
      </div>
    </div>
    <div class="row px-5">
      <div class="col-lg p-2">
        <div class="form-check">
          <label class="form-check-label" for="arrl"> ARRL Member </label>
          <input class="form-check-input" type="checkbox" name="arrl" />
        </div>
      </div>
      <div class="col-lg p-2">
        <div class="form-check">
          <label class="form-check-label" for="carrier"> Carrier Copy </label>
          <input class="form-check-input" type="checkbox" name="hard_news" />
        </div>
      </div>
      <div class="col-lg p-2">
        <div class="form-check">
          <label class="form-check-label" for="dir"> Directory Copy </label>
          <input class="form-check-input" type="checkbox" name="dir" />
        </div>
      </div>
      <div class="col-lg p-2">
        <div class="form-check">
          <label class="form-check-label" for="mem_card"> Member Card </label>
          <input class="form-check-input" type="checkbox" name="mem_card" />
        </div>
      </div>
    </div>
    <div class="row px-5">
      <div class="col-lg-3 py-2">
        <label for="pay_date">Payment Date</label>
        <input type="date" class="form-control" id="pay_date" name="pay_date">
      </div>
    </div>
    <div class="row px-5">
      <div class="col-lg-6 p-2">
        <label for="address">Street</label>
        <input type="text" class="form-control" name="address">
      </div>
    </div>
    <div class="row px-5">
      <div class="col-lg p-2">
        <label for="city">City</label>
        <input type="text" class="form-control" id="city" name="city" placeholder="City">
      </div>
      <div class="col-lg p-2">
        <label for="callsign">State</label>
        <select class="form-select" name="state" aria-label="Default select example">
          <?php
            foreach($states as $state) {
              if($state == 'California') {?>
              <option selected value="<?php echo key($states); ?>"><?php echo $state; ?></option>
            <?php }
              else { ?>
              <option value="<?php echo key($states); ?>"><?php echo $state; ?></option>
            <?php
                }
            next($states);
              }?>
        </select>
      </div>
      <div class="col-lg p-2">
        <label for="zip">Zip</label>
        <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip">
      </div>
    </div>
    <div class="row px-5">
      <div class="col p-2">
          <label for="comment">Comments</label>
          <textarea
          class="form-control" id="comment" name="comment" rows="7"></textarea>
      </div>
    </div>
    <div class="row px-5">
      <div class="col p-2">
          <button type="submit" class="btn btn-primary">Add MDARC Member</button>
      </div>
    </div>
  </form>
  </div>
</section>
