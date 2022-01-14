  <!--Learn Sections-->
<section id="learn" class="p-5">
    <div class="container">
              <div class="row pt-5">
                <div class="col offset-lg-1">
                  <h2>Edit Data for: <?php echo $mem['fname'] . ' ' . $mem['lname']; ?></h2>
                  <?php
                    if($msg != "") {
                      echo '<p class="text-danger">' . $msg . '</p>';
                    }
                   ?>
                </div>
              </div>
              <form action="<?php echo base_url() . '/index.php/update-mem/'. $mem['id_members']; ?>" method="post">
              <div class="row pt-2">
                <div class="col-lg-3 offset-lg-1 pt-1">
                  <div class="form-check">
                    <label class="form-check-label" for="arrl"> Listing in Directory OK </label>
                    <?php if(strtoupper($mem['dir_ok']) == 'TRUE') {?>
                      <input class="form-check-input" type="checkbox" name="dir_ok" checked>
                    <?php }
                          else { ?>
                      <input class="form-check-input" type="checkbox" name="dir_ok">
                    <?php } ?>
                  </div>
                </div>
                <div class="col-lg-3 offset-lg-1 pt-1">
                  <div class="form-check">
                    <label class="form-check-label" for="arrl"> ARRL Member </label>
                    <?php if(strtoupper($mem['arrl']) == 'TRUE') {?>
                      <input class="form-check-input" type="checkbox" name="arrl" checked>
                    <?php }
                          else { ?>
                      <input class="form-check-input" type="checkbox" name="arrl">
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="row pt-2">
                <div class="col-lg-4 offset-lg-1 pt-1">
                  <label for="fname">First Name</label>
                  <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $mem['fname']; ?>">
                </div>
              <div class="col-lg-4 pt-1">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $mem['lname']; ?>">
              </div>
            </div>
            <div class="row pt-2">
              <div class="col-lg-4 offset-lg-1 pt-1">
                <label for="sel_lic">License Type</label>
                <select class="form-select" name="sel_lic">
                  <?php
                    foreach($lic as $license) {
                      if($license == $mem['license']) { ?>
                        <option value="<?php echo $mem['license']; ?>" selected><?php echo $mem['license']; ?></option>
                  <?php    }
                      else { ?>
                        <option value="<?php echo $license; ?>"><?php echo $license; ?></option>
                  <?php }
                    }
                  ?>
                </select>
              </div>
              <div class="col-lg-4 pt-1">
                <label for="callsign">Callsign</label>
                <input type="text" class="form-control" id="callsign" name="callsign" value="<?php echo $mem['callsign']; ?>">
              </div>
            </div>
            <div class="row pt-2">
              <div class="col-lg-4 offset-lg-1 pt-1">
                <label for="w_phone">Cell Phone</label>
                <input type="text" class="form-control" id="w_phone" name="w_phone" value="<?php echo $mem['w_phone']; ?>">
              </div>
              <div class="col-lg-4 pt-1">
                <label for="h_phone">Other Phone</label>
                <input type="text" class="form-control" id="h_phone" name="h_phone" value="<?php echo $mem['h_phone']; ?>">
              </div>
            </div>
            <div class="row pt-2">
              <div class="col-lg-4 offset-lg-1 pt-1">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $mem['email']; ?>">
              </div>
              <div class="col-lg-4 pt-4">
                <div class="form-check">
                  <label class="form-check-label" for="arrl"> ARRL Member </label>
                  <?php if(strtoupper($mem['arrl']) == 'TRUE') {?>
                    <input class="form-check-input" type="checkbox" name="arrl" checked>
                  <?php }
                        else { ?>
                    <input class="form-check-input" type="checkbox" name="arrl">
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="row pt-2">
              <div class="col-lg-4 offset-lg-1 pt-1">
                <label for="address">Street</label>
                <input type="text" class="form-control" name="address" value="<?php echo $mem['address']; ?>">
              </div>
            </div>
            <div class="row pt-2">
              <div class="col-lg-4 offset-lg-1 pt-1">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" value="<?php echo $mem['city']; ?>">
              </div>
              <div class="col-lg-2 pt-1">
                <label for="callsign">State</label>
                <select class="form-select" name="state" aria-label="Default select example">
                  <?php
                    foreach($states as $state) {
                      if($state == $states[$mem['state']]) {?>
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
              <div class="col-lg-2 pt-1">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="zip" name="zip" value="<?php echo $mem['zip']; ?>">
              </div>
            </div>
            <?php if($fam_arr['fam_flag']) {?>
              <div class="row pt-3">
                <div class="col-lg-5 offset-lg-1">
                  <table class="table">
                    <thead>
                      <th scope="col" colspan="2">Family Members</th>
                      <th scope="col">Delete</th>
                    </thead>
                    <tbody>
                      <?php
                        foreach($fam_arr['fam_mems'] as $fam_mem) { ?>
                      <tr>
                        <td><?php echo $fam_mem['mem_type']; ?></td>
                        <td><a href="#" class="text-decoration-none" data-bs-toggle="modal"
                            data-bs-target="#editFaMem<?php echo $fam_mem['id_members']; ?>"><?php echo $fam_mem['fname'] . ' ' . $fam_mem['lname']; ?></a></td>

                          <!--    Edit Family Member modal -->
                            <div class="modal fade" id="editFaMem<?php echo $fam_mem['id_members']; ?>" tabindex="-1" aria-labelledby="editFamMemLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="editFamMemLabel">Edit Family Member</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                </form>
                                  <form action="<?php echo base_url() . '/index.php/edit-fam-mem/'. $fam_mem['id_members']; ?>" method="post">
                                  <div class="modal-body">
                                  <section class="px-2">
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
                                        <input type="text" class="form-control" id="w_phone" name="w_phone" value="<?php echo $fam_mem['w_phone']; ?>">
                                      </div>
                                      <div class="col-lg py-2">
                                        <label for="h_phone">Home Phone</label>
                                        <input type="text" class="form-control" id="h_phone" name="h_phone" value="<?php echo $fam_mem['h_phone']; ?>">
                                      </div>
                                      <div class="col-lg py-2">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $fam_mem['email']; ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-1">
                                      <div class="col py-2">
                                          <label for="comment">Comments</label>
                                          <textarea
                                          class="form-control" id="comment" name="comment" rows="5"><?php echo $fam_mem['comment']; ?></textarea>
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
                    <!--    End of Edit Family Member modal -->

                        <td><a href="#" class="text-decoration-none" data-bs-toggle="modal"
                            data-bs-target="#delFaMem<?php echo $fam_mem['id_members']; ?>"><i class="bi bi-trash"></i></a></td>

                   <!-- Delete Family Member modal -->
                            <div class="modal fade" id="delFaMem<?php echo $fam_mem['id_members']; ?>" tabindex="-1" aria-labelledby="delFamMemLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 id="delFamMem<?php echo $fam_mem['id_members']; ?>Label" class="modal-title">Deleting Family Member!</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <p>Delete Family Member <strong><?php echo $fam_mem['fname'] . ' ' . $fam_mem['lname'] . ' ' . $fam_mem['callsign']; ?>?</strong></p>
                                    <a href="<?php echo base_url() . '/index.php/delete-fam-mem/'. $fam_mem['id_members']; ?>" class="btn btn-danger"> Delete </a>
                                    <br>
                                  </div>
                                  <div class="modal-footer">&nbsp;
                                  </div>
                                </div>
                              </div>
                            </div>
                      <!-- End of delete Family Member modal -->

                      </tr>
                        <?php  }?>
                    </tbody>
                  </table>
                  <?php include 'mod_del_famem.php'; ?>
                </div>
              </div>
            <?php } ?>
              <div class="row pt-1">
                <div class="col-lg-5 offset-lg-1">

              </div>
            </div>
            <div class="row pt-3">
              <div class="col-lg-4 offset-lg-1">
                <p><a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addFamMem">Add Family Member</a></p>
                <?php include 'modal_update_mem.php'; ?>
                <button type="submit" class="btn btn-primary">Save changes</button> &nbsp;
                <a href="<?php echo base_url(); ?>" class="btn btn-secondary text-decoration-none">Cancel</a>
              </div>
            </div>
            </form>
    </div>
</section>

<section id="learn" class="p-5 bg-light text-light">
    <div class="container">

    </div>
</section>
