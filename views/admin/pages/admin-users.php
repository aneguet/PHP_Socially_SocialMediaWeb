<?php
$data = $a->getUsersData();
?>


<div class="d-flex justify-content-between flex-wrap align-items-center">
    <h1>Admin Dashboard</h1>
</div>
<!-- Tables section  -->
<div class="row">
    <div class="my-3">
        <section id="newUsers">
            <h4 class="text-muted secondary-header-margin">Users</h4>
            <table id="display_table" class="table table-striped table-bordered table-hover table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Id</th>
                        <th class="th-sm">Username</th>
                        <th class="th-sm">Email</th>
                        <th class="th-sm">Rank</th>
                        <th class="th-sm">Permission</th>
                        <th class="th-sm">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $user) {
                        echo '<tr>';
                        echo '<td> ' . $user['user_id'] . '</td>';
                        echo '<td> ' . $user['username'] . '</td>';
                        echo '<td> ' . $user['email'] . '</td>';
                        echo '<td> ' . $user['rank'] . '</td>';
                        echo '<td> ' . $user['role_name'] . '</td>';
                        echo '<td>';

                        echo '<button type="button" class="btn btn-info btn-sm"  id="editUserBtn"
                                onclick="adminEditUserRedirect(this.value);"
                                value=' . $user['user_id'] . '><i class="fas fa-pen"></i></button>';
                        echo '<button type="button" class="btn btn-danger btn-sm"  id="deleteUserBtn"
                                onclick="return adminDeleteUser(this.value);"
                                value=' . $user['user_id'] . '><i class="fas fa-trash"></i></button>';
                        echo '<button type="button" class="btn btn-warning btn-sm"  id="banUserBtn"
                                onclick="return adminBanUser(this.value, ' . $user['banned'] . ');"
                                value=' . $user['user_id'] . '>';
                        if ($user['banned']) {
                            echo '<i class="fas fa-check"></i>';
                        } else {
                            echo '<i class="fas fa-ban"></i>';
                        }
                        echo '</button>';
                        echo '</td>';
                        echo '</tr>';
                    } ?>
                </tbody>
            </table>
        </section>
    </div>
</div>

<script src="../views/admin/js/data-table.js"></script>