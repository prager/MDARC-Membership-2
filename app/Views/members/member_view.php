  <!--Learn Sections-->
        <section id="learn" class="p-5">
            <div class="container">
              <div class="row pt-5">
                <div class="col-lg-5 offset-lg-2">
                  <p class="lead fw-bold text-warning">MDARC Member Data For:</p>
                </div>
              </div>
              <div class="row">
                  <div class="col-lg offset-lg-2">
                      <h2><?php echo $primary['fname'] . ' ' . $primary['lname']; ?></h2>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 offset-lg-2">
                    <?php if($msg != NULL) {?>
                    <p><?php echo $msg; ?></p>
                  <?php }?>
                    <p class="lead">Callsign: <?php echo $primary['callsign'] . ' / ' . 'Member ID: ' . $primary['id_members']; ?></p>
                  </div>
                </div>                
                <div class="row">
                  <div class="col-lg-5 offset-lg-2">
                    <p class="lead">Membership Type: <?php echo $primary['mem_type']; ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-5 offset-lg-2">
                    <?php if($primary['cur_year'] < date('Y', time())) {?>
                      <p class="lead text-danger fw-bold">Current Year: <?php echo $primary['cur_year']; ?> --> Not Current!</p>
                    <?php }
                    else { ?>
                      <p class="lead">Current Year: <?php echo $primary['cur_year']; ?></p>
                    <?php }?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-5 offset-lg-2">
                    <?php if($primary['cur_year'] < date('Y', time())) {?>
                      <p class="lead text-danger fw-bold">Last Payment: <?php echo $primary['pay_date']; ?> --> Payment Overdue!</p>
                      <p>Click on <a href="https://events.r20.constantcontact.com/register/eventReg?oeidk=a07eixcb3jrd9626c70&oseq=&c=&ch=" target="_blank" class="text-decoration-none">Membership Renewal</a> link to renew your membership.</p>
                    <?php }
                    else { ?>
                      <p class="lead">Last Payment: <?php echo $primary['pay_date']; ?></p>
                    <?php }?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-5 offset-lg-2">
                    <p class="lead">ARRL Member:
                      <?php if(strtoupper($primary['arrl']) == 'TRUE') {?>
                        <label class="lead">YES &nbsp; </label>
                        <input class="form-check-input" type="checkbox" name="arrl" checked disabled>
                      <?php }
                            else { ?>
                        <label class="lead">NO &nbsp; </label>
                        <input class="form-check-input" type="checkbox" name="arrl" disabled>
                      <?php } ?>
                    </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-5 offset-lg-2">
                    <p class="lead">Directory Listing:
                      <?php if(strtoupper($primary['dir_ok']) == 'TRUE') {?>
                        <label class="lead">YES &nbsp; </label>
                        <input class="form-check-input" type="checkbox" name="arrl" checked disabled>
                      <?php }
                            else { ?>
                        <label class="lead">NO &nbsp; </label>
                        <input class="form-check-input" type="checkbox" name="arrl" disabled>
                      <?php } ?>
                    </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-5 offset-lg-2">
                    <p class="lead">Email: <?php echo $primary['email']; ?></p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-8 offset-lg-2">
                    <p class="lead">Cell Phone: <?php echo $primary['w_phone'] . ' / Other Phone: ' . $primary['h_phone']; ?></p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-5 offset-lg-2">
                    <p class="lead">Address:<br> <?php echo $primary['address'] . ', ' . $primary['city'] . ', ' . $primary['state'] . ' ' . $primary['zip']; ?></p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-5 offset-lg-2">
                    <p class="lead"></p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-5 offset-lg-2">

                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-5 offset-lg-2">
                    <?php if($fam_arr['fam_flag']) {?>
                          <p>Family Members:</p>
                          <span >  <?php
                              foreach($fam_arr['fam_mems'] as $mem) {
                                echo $mem['mem_type'] . ': ' . $mem['fname'] . ' ' . $mem['lname'] . '<br>';
                            }?>
                          </span>
                        <?php } ?>
                        </p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-5 offset-lg-2">
                    <a href="<?php echo base_url() . '/index.php/pers-data'; ?>" class="btn btn-light my-3"><i class="bi bi-chevron-right"></i> Edit Your Member Data </a>
                  </div>
                </div>

              </div>
        </section>
