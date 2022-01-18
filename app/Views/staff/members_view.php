      <section id="learn" class="p-5">
            <div class="container">
                <div class="row">&nbsp;</div>
                <div class="row text-centerm">
                  <div class="col-lg-12">
                  <h4>MDARC Members Listing</h4>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-light btn-sm"><?php echo anchor('staff/download_cur_emails', 'Current Emails', 'class="text-decoration-none text-dark"')?></button>
                          <button type="button" class="btn btn-light btn-sm"><?php echo anchor('staff/download_all_mems', 'All Members', 'class="text-decoration-none text-dark"')?></button>
                          <button type="button" class="btn btn-light btn-sm"><?php echo anchor('staff/download_cur_mems', 'Current Members', 'class="text-decoration-none text-dark"')?></button>
                          <button type="button" class="btn btn-light btn-sm"><?php echo anchor('staff/download_pay_next_mems', 'Emails Next Yr Dues', 'class="text-decoration-none text-dark"')?></button>
                          <button type="button" class="btn btn-light btn-sm"><?php echo anchor('staff/download_pay_due', 'Dues not Paid', 'class="text-decoration-none text-dark"')?></button>
                          <button type="button" class="btn btn-light btn-sm"><?php echo anchor('staff/download_due_emails', 'Emails not Paid', 'class="text-decoration-none text-dark"')?></button>
                        </div>
                  </div>
                </div>
                <div class="row align-items-center justify-content-between">
                  <ul class="nav nav-pills m-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#cur_mems" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Current Paying Members</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#carrier" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Carrier Copy</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pay_due" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Pay Due</button>
                    </li>

                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#inactives" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Inactive Members</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#silents" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Silent Keys</button>
                    </li>
                  </ul>
                <div class="tab-content m-1" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="cur_mems" role="tabpanel" aria-labelledby="pills-home-tab">
                    <table class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Current Year</th>
                          <th>Mem Type</th>
                          <th>Callsign</th>
                          <th>License</th>
                          <th>Pay Date</th>
                          <th>Mem Since</th>
                          <th>Email</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($cur_members as $mem) {?>
                        <tr>
                          <td><a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#showMem<?php echo $mem['id']; ?>"><?php echo $mem['lname'] . ', ' . $mem['fname']; ?></a></td>
                          <?php include 'modal_show_mem.php'; ?>
                          <td><?php echo $mem['cur_year']; ?></td>
                           <td>
                             <?php echo $mem['mem_type']; ?>
                             <!-- Add modal call with family members -->
                           </td>
                           <td><?php echo $mem['callsign']; ?></td>
                           <td><?php echo $mem['license']; ?></td>
                           <td><?php echo $mem['pay_date']; ?></td>
                           <td><?php echo $mem['mem_since']; ?></td>
                           <td><?php
                           if(strlen($mem['email']) > 30) {
                             echo substr($mem['email'], 0, 30) . '...';
                           }
                           else {
                             echo $mem['email'];
                           }?>
                         </td>
                        </tr>
                      <?php }?>
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane fade" id="carrier" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <table class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Callsign</th>
                          <th>Address</th>
                          <th>City</th>
                          <th>State</th>
                          <th>Zip</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($carrier as $mem) {?>
                        <tr>
                         <td><?php echo $mem['lname'] . ', ' . $mem['fname']; ?></td>
                         <td><?php echo $mem['callsign']; ?></td>
                         <td><?php echo $mem['address']; ?></td>
                         <td><?php echo $mem['city']; ?></td>
                         <td><?php echo $mem['state']; ?></td>
                         <td><?php echo $mem['zip']; ?></td>
                        </tr>
                      <?php }?>
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane fade" id="pay_due" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <table class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Cur Yr</th>
                          <th>Mem Type</th>
                          <th>Callsign</th>
                          <th>Lic</th>
                          <th>Pay Dt</th>
                          <th>Mem Since</th>
                          <th>Email</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($pay_due as $mem) {?>
                        <tr>
                          <td><a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#showMem<?php echo $mem['id']; ?>"><?php echo $mem['lname'] . ', ' . $mem['fname']; ?></a></td>
                          <?php include 'modal_show_mem.php'; ?>
                          <td><?php echo $mem['cur_year']; ?></td>
                           <td><?php echo $mem['mem_type']; ?></td>
                           <td><?php echo $mem['callsign']; ?></td>
                           <td><?php echo $mem['license']; ?></td>
                           <td><?php echo $mem['pay_date']; ?></td>
                           <td><?php echo $mem['mem_since']; ?></td>
                           <td><?php
                           if(strlen($mem['email']) > 30) {
                             echo substr($mem['email'], 0, 30) . '...';
                           }
                           else {
                             echo $mem['email'];
                           }?>
                         </td>
                        </tr>
                      <?php }?>
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane fade" id="inactives" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <table class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Callsign</th>
                          <th>Lic</th>
                          <th>Pay Dt</th>
                          <th>Mem Since</th>
                          <th>Email</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($del_mems as $mem) {?>
                        <tr>
                          <td><?php echo $mem['lname'] . ', ' . $mem['fname']; ?></td>
                           <td><?php echo $mem['callsign']; ?></td>
                           <td><?php echo $mem['license']; ?></td>
                           <td><?php echo $mem['pay_date']; ?></td>
                           <td><?php echo $mem['mem_since']; ?></td>
                           <td><?php
                           if(strlen($mem['email']) > 30) {
                             echo substr($mem['email'], 0, 30) . '...';
                           }
                           else {
                             echo $mem['email'];
                           }?>
                         </td>
                        </tr>
                      <?php }?>
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane fade" id="silents" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <table class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Callsign</th>
                          <th>Date of Passing</th>
                          <th>Year of Passing</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($silent_keys as $mem) {?>
                        <tr>
                         <td><?php echo $mem['lname'] . ', ' . $mem['fname']; ?></td>
                         <td><?php echo $mem['callsign']; ?></td>
                         <td><?php echo $mem['silent_date']; ?></td>
                         <td><?php echo $mem['silent_year']; ?></td>
                        </tr>
                      <?php }?>
                      </tbody>
                    </table>
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
