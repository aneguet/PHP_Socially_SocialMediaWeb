<?php require_once('../bootstrapping.php');

if (isset($_POST["option"])) {
    $option = $_POST["option"];

    switch ($option) {
        case "admin-dashboard":
            $a = new AdminController();
            $data=$a->adminPostCategoriesChartData();
            echo json_encode($data);
            break;
        case "adminEditUser":
            $a = new AdminController();
            $result = $a->validateForm($_POST);
            echo json_encode($result);
            break;
        case "adminEditUserRedirect":
            $redirect = new Redirector('../admin/user/'.$_POST['userid']);
            return $redirect;
            break;
        case "adminBanUser":
            $a = new AdminController();
            $result = $a->banUser($_POST['userid'], $_POST['banned']);
            echo json_encode($result);
            break;
        case "adminDeleteUser":
            $a = new AdminController();
            $result = $a->deleteUser($_POST['userid']);
            echo $result;
            break;
        case "adminDeletePost":
            $a = new AdminController();
            $result = $a->deletePost($_POST['postId']);
            echo json_encode($result);
            break;
        case "adminDeleteComment":
            $a = new AdminController();
            $result = $a->deleteComment($_POST['commentId']);
            echo json_encode($result);
            break;
    }

}

?>