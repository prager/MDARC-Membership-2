<div class="modal fade" id="editFamMem<?php echo $mem['id_members']; ?>" tabindex="-1" aria-labelledby="editFamMemLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editFamMemLabel">Edit Family Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    </form>
      <form action="<?php echo base_url() . '/index.php/edit-fam-mem/'. $mem['id_members']; ?>" method="post">
      <div class="modal-body">
      <section class="px-2">
        <div class="row pt-2">
          <div class="col-lg-3 p-3">
            <div class="form-check">
              <label class="form-check-label" for="arrl"> ARRL Member </label>
              <input class="form-check-input" type="checkbox" name="arrl" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg py-2">
            <label for="fname">First Name</label>
            <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name">
          </div>
          <div class="col-lg py-2">
              <label for="lname">Last Name</label>
              <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name">
          </div>
          <div class="col-lg py-2">
              <label for="callsign">Callsign</label>
              <input type="text" class="form-control" id="callsign" name="callsign" placeholder="Enter Callsign">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 py-2">
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
          <div class="col-lg-6 py-2">
            <label for="sel_lic">Member Type</label>
            <select class="form-select" name="mem_types">
              <?php
                foreach($member_types as $type) {
                  if($type['id'] == 4) {?>
                    <option value="<?php echo $type['id']; ?>" selected><?php echo $type['description']; ?></option>
                  <?php }
                  elseif($type['id'] == 3) { ?>
                    <option value="<?php echo $type['id']; ?>"><?php echo $type['description']; ?></option>
              <?php  }
                }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg py-2">
            <label for="w_phone">Cell Phone</label>
            <input type="text" class="form-control" id="w_phone" name="w_phone" placeholder="000-000-0000">
          </div>
          <div class="col-lg py-2">
            <label for="h_phone">Home Phone</label>
            <input type="text" class="form-control" id="h_phone" name="h_phone" placeholder="000-000-0000">
          </div>
          <div class="col-lg py-2">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="you@email.com">
          </div>
        </div>
        <div class="row mb-1">
          <div class="col py-2">
              <label for="comment">Comments</label>
              <textarea
              class="form-control" id="comment" name="comment" rows="7" placeholder="Any Comment"></textarea>
          </div>
        </div>
      </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
