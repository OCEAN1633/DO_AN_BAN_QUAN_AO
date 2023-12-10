<?php
include('../config.php');
include('../head.php');

$errorMessage = "";
$successMessage = "";

if (isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $prod_id = $_POST['prod_id'];
    $size_id = $_POST['size_id'];
    $number = $_POST['number'];

    // Kiểm tra số lượng không âm
    if ($number < 0) {
        $errorMessage = "Số lượng không được âm.";
    } else {
        // Truy vấn để kiểm tra sự tồn tại của kết hợp prod_id và size_id
        $checkQuery = "SELECT * FROM prod_detail WHERE prod_id = '$prod_id' AND size_id = '$size_id'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Nếu đã tồn tại kết hợp prod_id và size_id, thông báo lỗi
            $errorMessage = "Size sản phẩm này đã có trong kho.";
        } else {
            // Nếu chưa tồn tại, thực hiện câu truy vấn để chèn dữ liệu vào bảng prod_detail
            $insertQuery = "INSERT INTO prod_detail (prod_id, size_id, number) VALUES ('$prod_id', '$size_id', '$number')";

            if (mysqli_query($conn, $insertQuery)) {
                // Nếu chèn thành công, hiển thị thông báo thành công
                $successMessage = "Thêm chi tiết sản phẩm thành công.";
                header("Location: index.php?success=1");
            } else {
                // Nếu chèn thất bại, hiển thị thông báo lỗi
                $errorMessage = "Lỗi: " . $insertQuery . "<br>" . mysqli_error($conn);
            }
        }
    }
}
?>

<body class="animsition">
    <div class="page-wrapper">
        <?php include('../sidebar.php'); ?>
        <div class="page-container">
        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Thêm</strong> Chi Tiết Sản Phẩm
                                </div>
                                <div class="card-body card-block">
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="card-body card-block">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="prod_id" class="form-control-label">Tên sản phẩm</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="prod_id" id="prod_id" class="form-control" onchange="displayProductImage()">
                                                        <option value="">Chọn sản phẩm</option>
                                                        <?php
                                                        // Truy vấn cơ sở dữ liệu để lấy danh sách sản phẩm và cột prod_image
                                                        $product_query = "SELECT prod_id, prod_name, prod_image FROM product";
                                                        $product_result = mysqli_query($conn, $product_query);
                                                        while ($row = mysqli_fetch_assoc($product_result)) {
                                                            echo "<option value='" . $row['prod_id'] . "' data-image='../img/" . $row['prod_image'] . "'>" . $row['prod_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="size_id" class="form-control-label">Kích Cỡ</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="size_id" id="size_id" class="form-control">
                                                        <option value="">Chọn kích cỡ</option>
                                                        <?php
                                                        // Truy vấn cơ sở dữ liệu để lấy danh sách kích cỡ
                                                        $size_query = "SELECT size_id, size_name FROM size";
                                                        $size_result = mysqli_query($conn, $size_query);
                                                        while ($row = mysqli_fetch_assoc($size_result)) {
                                                            echo "<option value='" . $row['size_id'] . "'>" . $row['size_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="number" class="form-control-label">Số Lượng</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="number" id="number" name="number" placeholder="Số lượng" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="productImage" class="form-control-label">Ảnh Sản Phẩm</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <img id="productImage" src="" alt="Ảnh sản phẩm" style="max-width: 200px;">
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <?php if (!empty($errorMessage)) : ?>
                                                    <div class="alert alert-danger" role="alert">
                                                        <?php echo $errorMessage; ?>
                                                    </div>
                                                <?php elseif (!empty($successMessage)) : ?>
                                                    <div class="alert alert-success" role="alert">
                                                        <?php echo $successMessage; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <button type="submit" name="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-dot-circle-o"></i> Submit
                                                </button>
                                                <button type="reset" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-ban"></i> Reset
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
function displayProductImage() {
    var selectedProduct = document.getElementById('prod_id');
    var productImage = document.getElementById('productImage');

    if (selectedProduct.value !== "") {
        var prodImage = selectedProduct.options[selectedProduct.selectedIndex].getAttribute('data-image');
        productImage.src = prodImage;
    } else {
        productImage.src = ''; // Xóa ảnh nếu không có sản phẩm nào được chọn
    }
}
</script>
