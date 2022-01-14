<div class="modal fade" id="fMems<?php echo $mem['id']; ?>" tabindex="-1" aria-labelledby="addFamMemLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFamMemLabel">Add / Edit a Family Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    </form>
      <div class="modal-body">
      <section class="px-2">
        <div class="row pt-2">
          <div class="col p-3">
            <div class="accordion" id="accFamMems">
              <?php
                foreach($mem['fam_mems'] as $fam_mem) { ?>
                  <form action="<?php echo base_url() . '/index.php/edit-fam/'. $fam_mem['id_members']; ?>" method="post">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="flushHeading<?php echo $fam_mem['id_members']; ?>">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flushCollapse<?php echo $fam_mem['id_members']; ?>" aria-expanded="false" aria-controls="flushCollapse<?php echo $fam_mem['id_members']; ?>">
                        <?php echo $fam_mem['fname'] . ' ' . $fam_mem['lname']; ?>
                      </button>
                    </h2>
                    <div id="flushCollapse<?php echo $fam_mem['id_members']; ?>" class="accordion-collapse collapse" aria-labelledby="flushHeading<?php echo $fam_mem['id_members']; ?>" data-bs-parent="#accordionFlushExample">
                      <div class="accordion-body">
                        <form action="<?php echo base_url() . '/index.php/edit-fam/'. $fam_mem['id_members']; ?>" method="post">
                        <div class="row pt-2">
                          <div class="col-lg-3 p-3">
                            <div class="form-check">
                              <label class="form-check-label" for="arrl"> ARRL Member </label>
                              <?php if(strtoupper($fam_mem['arrl']) == 'TRUE') {?>
                                <input class="form-check-input" type="checkbox" name="arrl" checked>
                              <?php }
                                    else { ?>
                                <input class="form-check-input" type="checkbox" name="arrl">
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg py-2">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fam_mem['fname']; ?>">
                          </div>
                          <div class="col-lg py-2">
                              <label for="lname">Last Name</label>
                              <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $fam_mem['lname']; ?>">
                          </div>
                          <div class="col-lg py-2">
                              <label for="callsign">Callsign</label>
                              <input type="text" class="form-control" id="callsign" name="callsign" value="<?php echo $fam_mem['callsign']; ?>">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6 py-2">
                            <label for="sel_lic">License Type</label>
                            <select class="form-select" name="sel_lic">
                              <?php
                              foreach($lic as $license) {
                                if($license == $fam_mem['license']) { ?>
                                  <option value="<?php echo $fam_mem['license']; ?>" selected><?php echo $fam_mem['license']; ?></option>
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
                                foreach($mem_types as $key => $type) {
                                  if($key == 4) {?>
                                    <option value="<?php echo $key; ?>" selected><?php echo $type; ?></option>
                                  <?php }
                                  elseif($key == 3) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $type; ?></option>
                              <?php  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg py-2">
                            <label for="w_phone">Cell Phone</label>
                            <input type="text" class="form-control" id="w_phone" name="w_phone" value="<?php echo $fam_mem['w_phone']; ?>">
                          </div>
                          <div class="col-lg py-2">
                            <label for="h_phone">Home Phone</label>
                            <input type="text" class="form-control" id="h_phone" name="h_phone" value="<?php echo $fam_mem['h_phone']; ?>">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6 py-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $fam_mem['email']; ?>">
                          </div>
                        </div>
                        <div class="row mb-1">
                          <div class="col py-2">
                              <label for="comment">Comments</label>
                              <textarea
                              class="form-control" id="comment" name="comment" rows="5" placeholder="Any Comment"><?php echo $fam_mem['comment']; ?></textarea>
                          </div>
                        </div>
                        <div class="row mb-1">
                          <div class="col py-2">
                            <button type="submit" class="btn btn-primary">Save changes</button> <a href="<?php echo base_url() . '/index.php/delete-fam/'. $fam_mem['id_members']; ?>" class="btn btn-danger"> Delete <i class="bi bi-trash"></i></a>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </form>
                  </div>
              <?php } ?>
              <div class="accordion-item">
                <form action="<?php echo base_url() . '/index.php/add-fam/'. $mem['id']; ?>" method="post">
                <h2 class="accordion-header" id="headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Add a Family Member
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
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
                            foreach($mem_types as $key => $type) {
                              if($key == 4) {?>
                                <option value="<?php echo $key; ?>" selected><?php echo $type; ?></option>
                              <?php }
                              elseif($key == 3) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $type; ?></option>
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
                    </div>
                    <div class="row">
                      <div class="col-lg-6 py-2">
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
                    <div class="row mb-1">
                      <div class="col py-2">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              </div>

            </div>
          </div>
        </div>
      </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>
