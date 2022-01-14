
        <!--Learn Sections-->
        <section id="learn" class="p-5">
            <div class="container">
                <div class="row p-5">
                    <div class="col text-center">
                      <h4>Edit Users</h4>
                      <?php
                        if($msg != "") {
                          echo '<p>' . $msg . '</p>';
                        }
                       ?>
                    </div>
                </div>
                <div class="row px-5">
                    <div class="col">
                      <table class="table table-striped table-bordered text-left">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>User Type</th>
                            <th>Activate/Deactivate</th>
                            <th>Authorize/Unauthorize</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($users as $user) {?>
                          <tr>
                             <td><a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#editUser<?php echo $user['id']; ?>"><?php echo $user['fname'] . ' ' . $user['lname']; ?></a>
                                       <?php include 'modal_update_user.php'; ?></td>
                             <td><a href="#"class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#resetUsr<?php echo $user['id']; ?>"><?php echo $user['username']; ?></a>
                                      <?php include 'mod_reset_user.php'; ?></td>
                             <td><?php echo $user['type_desc']; ?></td>
                             <td><?php if($user['active'] == 1) {
                               echo anchor('deactivate/' . $user['id'], 'Deactivate');
                             }
                             else {
                               echo anchor('activate/' . $user['id'], 'Activate');
                             } ?></td>
                             <td><?php if($user['authorized'] == 1) {
                               echo anchor('unauthorize/' . $user['id'], 'Unauthorize');
                             }
                             else {
                               echo anchor('authorize/' . $user['id'], 'Authorize');
                             } ?></td>
                              <td class="text-center">
                                <a href="#" data-toggle="modal" data-target="#delUsr<?php echo $user['id']; ?>"><i class="bi bi-trash"></i></a>
                                <?php include 'mod_del_user.php'; ?>
                              </td>
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
