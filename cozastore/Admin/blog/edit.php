<?php
include('../head.php');
include('../config.php');

if (isset($_GET['blog_id'])) {
    $blog_id = $_GET['blog_id'];

    // Truy vấn cơ sở dữ liệu để lấy thông tin bài viết theo $blog_id
    $query = "SELECT b.blog_id, b.title, b.image, b.blogcat_id, b.summary, b.content, b.created_at, b.updated_at, b.status, bc.blogcat_name 
    FROM blog AS b 
    LEFT JOIN blog_cat AS bc ON b.blogcat_id = bc.blogcat_id 
    WHERE b.blog_id = $blog_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
    } else {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }
}

if (isset($_POST['submit'])) {
    $blog_id = $_POST['blog_id'];
    $blogcat_id = $_POST['blogcat_id'];
    $title = $_POST['title'];
    $summary = $_POST['summary'];
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $status = ($_POST['status'] == 'option1') ? 1 : 2;

    $newImage = $row['image']; // Giả định sử dụng ảnh cũ

    // Kiểm tra xem người dùng đã chọn ảnh mới hay không
    if (!empty($_FILES['image']['name'])) {
        // Xử lý ảnh mới
        $newImage = $_FILES['image']['name'];
        $newImage_temp = $_FILES['image']['tmp_name'];
        move_uploaded_file($newImage_temp, "upload/$newImage");
    }

    $updated_at = date('Y-m-d H:i:s');

    $updateQuery = "UPDATE blog SET title='$title', image='$newImage', blogcat_id=$blogcat_id, summary='$summary', content='$content', status=$status, updated_at='$updated_at' WHERE blog_id=$blog_id";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
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
                                    <strong>Sửa</strong> Bài viết
                                </div>
                                <div class="card-body card-block">
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" onsubmit="return confirmSave();">
                                        <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">

                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="title" class="form-control-label">Tiêu đề</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="text" id="title" name="title" class="form-control" value="<?php echo $row['title']; ?>">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="image" class="form-control-label">Ảnh</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="file" id="image" name="image" class="form-control-file" onchange="showImagePreview(this);">
                                                <img id="image-preview" style="width: auto; height: 140px; margin-top: 15px;" src="images/<?php echo $row['image']; ?>" alt="Ảnh Blog">
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
                                                        $selected = ($cat_row['blogcat_id'] == $row['blogcat_id']) ? "selected" : "";
                                                        echo "<option value='" . $cat_row['blogcat_id'] . "' $selected>" . $cat_row['blogcat_name'] . "</option>";
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
                                                <textarea name="summary" id="summary" rows="4" class="form-control"><?php echo $row['summary']; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="textarea-input" class="form-control-label">Nội dung</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <div id="froala"><?php echo $row['content']; ?></div>
                                                <textarea name="content" id="content" style="display: none;"><?php echo $row['content']; ?></textarea>
                                                <!-- Trường ẩn để lưu nội dung từ Froala Editor -->
                                                <input type="hidden" name="froala_content" id="froala_content">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label class="form-control-label">Trạng thái</label>
                                            </div>
                                            <div class="col col-md-9">
                                                <div class="form-check-inline form-check">
                                                    <label for="status1" class="form-check-label">
                                                        <input type="radio" id="status1" name="status" value="option1" class="form-check-input" <?php if ($row['status'] == 1) echo 'checked'; ?>> Hiện
                                                    </label>
                                                    <label for="status2" class="form-check-label">
                                                        <input type="radio" id="status2" name="status" value="option2" class="form-check-input" <?php if ($row['status'] == 2) echo 'checked'; ?>> Ẩn
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
            'contentChanged': function() {
                var content = editor.html.get();
                document.getElementById('content').value = content;
            }
        }
    });
</script>
<script>function showImagePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById('image-preview').src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>