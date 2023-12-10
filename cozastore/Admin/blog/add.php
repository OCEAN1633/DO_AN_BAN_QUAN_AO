<?php
include('../head.php');
include('../config.php');

if (isset($_POST['submit'])) {
    $blogcat_id = $_POST['blogcat_id'];
    $title = $_POST['title'];
    $summary = $_POST['summary'];
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $status = ($_POST['status'] == 'option1') ? 1 : 2;

    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_temp, "upload/$image");

    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    $insertQuery = "INSERT INTO blog (blogcat_id, title, image, summary, content, status, created_at, updated_at) VALUES ('$blogcat_id', '$title','$image', '$summary', '$content', $status, '$created_at', '$updated_at')";
    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        header("Location: index.php?success=1");
        exit;
    } else {
        echo '<div class="alert alert-danger">Lỗi: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<link href="node_modules/froala-editor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css">

<body class="animsition">
    <div class="page-wrapper">
        <?php include('../sidebar.php'); ?>
        <div class="page-container">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Thêm mới</strong> Bài viết
                                </div>
                                <div class="card-body card-block">
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" onsubmit="return confirmSave();">

                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="title" class="form-control-label">Tiêu đề</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="text" id="title" name="title" class="form-control">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="file-input" class="form-control-label">Ảnh</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="file" id="file-input" name="image" class="form-control-file">
                                                </div>
                                            </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="category" class="form-control-label">Thể loại</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <select name="blogcat_id" id="category" class="form-control">
                                                    <?php
                                                    $category_query = "SELECT blogcat_id, blogcat_name FROM blog_cat";
                                                    $category_result = mysqli_query($conn, $category_query);
                                                    while ($cat_row = mysqli_fetch_assoc($category_result)) {
                                                        echo "<option value='" . $cat_row['blogcat_id'] . "'>" . $cat_row['blogcat_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="summary" class="form-control-label">Tóm tắt</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <textarea name="summary" id="summary" rows="4" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="textarea-input" class="form-control-label">Nội dung</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <div id="froala"></div>
                                                <textarea name="content" id="content" style="display: none"></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label class="form-control-label">Trạng thái</label>
                                            </div>
                                            <div class="col col-md-9">
                                                <div class="form-check-inline form-check">
                                                    <label for="status1" class="form-check-label">
                                                        <input type="radio" id="status1" name="status" value="option1" class="form-check-input" checked> Hiện
                                                    </label>
                                                    <label for="status2" class="form-check-label">
                                                        <input type="radio" id="status2" name="status" value="option2" class="form-check-input"> Ẩn
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary btn-sm">
                                                <i class="fa fa-dot-circle-o"></i> Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</body>

<script>
    function confirmSave() {
        return confirm("Bạn có chắc chắn muốn lưu thay đổi?");
    }
</script>

<script type="text/javascript" src="node_modules/froala-editor/js/froala_editor.pkgd.min.js"></script>
<script>
    var editor = new FroalaEditor('#froala', {
        events: {
            'contentChanged': function () {
                var content = editor.html.get();
                document.getElementById('content').value = content;
            }
        }
    });
</script>


