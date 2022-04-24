<?php
$data = $a->getPostsData();
?>
<div class="d-flex justify-content-between flex-wrap align-items-center">
    <h1>Admin Dashboard</h1>
</div>
<!-- Tables section  -->
<div class="row">
    <div class="my-3">
        <section id="postsSection">
            <h4 class="text-muted secondary-header-margin">Posts</h4>
            <table id="display_table" class="table table-striped table-bordered table-hover table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Id</th>
                        <th class="th-sm">Title</th>
                        <th class="th-sm">Original poster</th>
                        <th class="th-sm">Category</th>
                        <th class="th-sm">Up votes</th>
                        <th class="th-sm">Down votes</th>
                        <th class="th-sm">Total comments</th>
                        <th class="th-sm">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $post) {
                        echo '<tr>';
                        echo '<td> ' . $post['post_id'] . '</td>';
                        echo '<td> ' . $post['title'] . '</td>';
                        echo '<td> ' . $post['username'] . '</td>';
                        echo '<td> ' . $post['category_name'] . '</td>';
                        echo '<td> ' . $post['up_votes'] . '</td>';
                        echo '<td> ' . $post['down_votes'] . '</td>';
                        echo '<td> ' . $post['total_comments'] . '</td>';
                        echo '<td>';
                        echo '<button type="button" class="btn btn-danger btn-sm"  id="deletePostBtn"
                                        onclick="return adminDeletePost(this.value);"
                                        value=' . $post['post_id'] . '><i class="fas fa-trash"></i></button>';
                        echo '</td>';
                        echo '</tr>';
                    } ?>
                </tbody>
            </table>
        </section>
    </div>
</div>

<script src="../views/admin/js/data-table.js"></script>
<?php echo '<script src="' . PATH . 'views/admin/js/admin-dashboard.js"></script>'; ?>