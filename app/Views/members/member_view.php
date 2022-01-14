  <!--Learn Sections-->
        <section id="learn" class="p-5">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md py-5">
                        <img src="/img/control.svg" class="img-fluid w-75 d-none d-sm-block" alt="">
                    </div>
                    <div class="col-md p-5">
                        <h2>Welcome Member: <?php echo $primary['fname'] . ' ' . $primary['lname']; ?></h2>
                        <p class="lead">Callsign: <?php echo $primary['callsign']; ?></p>
                        <p>License Type: <?php echo $primary['license']; ?><br>
                        ARRL Member: <?php if(strtoupper($primary['arrl']) == 'TRUE') {?>
                          <input class="form-check-input" type="checkbox" name="arrl" checked disabled>
                        <?php }
                              else { ?>
                          <input class="form-check-input" type="checkbox" name="arrl" disabled>
                        <?php } ?><br>
                        Last Payment: <?php echo $primary['pay_date']; ?><br>
                        Current Year: <?php echo $primary['cur_year']; ?><br>
                        Email: <?php echo $primary['email']; ?><br>
                        Cell Phone: <?php echo $primary['w_phone'] . ' / Other Phone: ' . $primary['h_phone']; ?><br>
                        Address:<br> <?php echo $primary['address']; ?><br>
                        <?php echo $primary['city'] . ', ' . $primary['state'] . ' ' . $primary['zip']; ?>
                        </p>
                        <?php if($fam_arr['fam_flag']) {?>
                          <p class="lh-1">Family Members:<br><br>
                          <span >  <?php
                              foreach($fam_arr['fam_mems'] as $mem) {
                                echo $mem['mem_type'] . ': ' . $mem['fname'] . ' ' . $mem['lname'] . '<br>';
                            }?>
                          </span>
                        <?php } ?>
                        </p>
                        <a href="<?php echo base_url() . '/index.php/pers-data'; ?>" class="btn btn-light my-3"><i class="bi bi-chevron-right"></i> Edit Your Data </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="learn" class="p-5 bg-light text-light">
            <div class="container">
                <div class="row align-items-center justify-content-between">

                </div>
            </div>
        </section>
