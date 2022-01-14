        <!--Staff Section-->
        <section id="learn" class="p-5">
            <div class="container">
                <div class="row">&nbsp;</div>
                <div class="row align-items-center justify-content-between">
                    <div class="col-md">
                        <img src="/img/dev.svg" class="img-fluid w-75" alt="">
                    </div>
                    <div class="col-md p-5">
                        <h2>Membership Report</h2>
                        <div class="table-responsive">
          <table id="staff_rep" class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Report Parameters<a href="#" data-bs-toggle="modal" data-bs-target="#setDates"> (Set Dates)</a></th>
                <?php include 'mod_dates_period.php'; ?>
                <th scope="col">Parameter Values</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Paying Members</td>
                <td><?php echo $cnt_cur; ?></td>
              </tr>
              <tr>
                <td>All Members (incl. family members)</td>
                <td><?php echo $dir_cnt; ?></td>
              </tr>
              <tr>
                <td>New Members For The Year</td>
                <td><?php echo $new_mems_period; ?></td>
              </tr>
              <tr>
                <td>Renewals This Year</td>
                <td><?php echo $cnt_renew; ?></td>
              </tr>
              <tr>
                <td>Renewals from <?php echo $date_start . ' to ' .  $date_stop; ?></td>
                <td><?php echo $renewals_period; ?></td>
              </tr>
              <tr>
                <td>Past Due Members</td>
                <td><?php echo $cnt_pay; ?></td>
              </tr><tr>
                <td>Honorary Members</td>
                <td><?php echo $cnt_hons; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
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
