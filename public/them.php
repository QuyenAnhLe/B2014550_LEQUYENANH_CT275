<?php
require_once '../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
	session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
  }

  
use CT275\Labs\loai_dien_thoai;
use CT275\Labs\dien_thoai;

$loai_dien_thoai = new loai_dien_thoai($PDO);
$loai_dien_thoais = $loai_dien_thoai->all();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$dien_thoai = new dien_thoai($PDO);
	$dien_thoai->fill($_POST, $_FILES); // $_FILE lấy hình ảnh.
	if ($dien_thoai->validate()) {
		$dien_thoai->save() && redirect('admin.php');
	}
	$errors = $dien_thoai->getValidationErrors();
}

include '../partials/header.php';

$pageTitle = "Thêm sản phẩm";

?>

<style>
.nav--product h7 {
    font-size: 18px;
    margin: 0;
}
.nav--product a {
    text-decoration: none;
    color: black;
    font-weight: bold;
    font-size: 18px;
}
.nav--product a.text-secondary {
    color: #6c757d;
    font-weight: normal;
}
.nav--product i {
    margin: 0;
    font-size: 28px;
}
.nav--product a:hover {
    color: #007bff;
}
.nav--product h5 {
    font-size: 28px;
}
</style>

<title><?php echo $pageTitle; ?></title>

<main class="container">
    <section class="nav--product row ">
        <div class="col-7 mt-4 mb-4">
            <h7>
                <a href="index.php">Trang chủ <span class="text-muted">&#x002F;</span></a>
                <i class="bi bi-chevron-right "></i>
                <a href="admin.php">Admin <span class="text-muted">&#x002F;</span></a>
                <i class="bi bi-chevron-right"></i>
                <a class="text-secondary" href="">Thêm sản phẩm</a>
            </h7>
        </div>
        <div class="col-12">
            <h5 class="text-center mt-4 display-6 font-weight-bold">
                <div class="text-black" href="">Thêm sản phẩm</div>
            </h5>
        </div>
    </section>
    <section class="row pb-5">
        <div class="col-3"></div>

        <form name="frm" id="frm" action="" method="post" class="col-md-6 col-md-offset-3 was-validated"
            enctype="multipart/form-data">
            <!-- Name -->
            <div class="form-group">
                <label class="form-label display-7 font-weight-bold " for="ten_dien_thoai">Tên sản phẩm</label>
                <input type="text" name="ten" class="form-control is-invalid" maxlen="255" id="ten"
                    placeholder="Nhập tên sản phẩm..."
                    value="<?= isset($_POST['ten']) ? htmlspecialchars($_POST['ten']) : '' ?>" required>
                <?php if (isset($errors['ten'])) : ?>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($errors['ten']) ?>
                </div>
                <?php endif ?>
            </div>

            <div class="form-group">
                <label class="form-label display-7 font-weight-bold " for="gia">Giá sản phẩm</label>
                <input type="number" min="0" name="gia" class="form-control is-invalid" maxlen="255" id="phone"
                    placeholder="Nhập giá sản phẩm..."
                    value="<?= isset($_POST['gia']) ? htmlspecialchars($_POST['gia']) : '' ?>" required>

                <?php if (isset($errors['gia'])) : ?>
                <div class="invalid-feedback">
                    <strong><?= htmlspecialchars($errors['gia']) ?></strong>
                </div>
                <?php endif ?>
            </div>
            <div class="form-group">
                <label class="form-label display-7 font-weight-bold " for="ten">Hình ảnh</label>
                <input type="file" name="hinh" class="form-control is-invalid" maxlen="255" id="name"
                    placeholder="Nhập hình ảnh sản phẩm..." value="" required>

                <?php if (isset($errors['hinh'])) : ?>
                <div class="invalid-feedback">
                    <strong><?= htmlspecialchars($errors['hinh']) ?></strong>
                </div>
                <?php endif ?>
            </div>

            <div class="form-group">
                <label class="form-label display-7 font-weight-bold " for="loai_dien_thoai">Loại sản phẩm</label>
                <select name="id_loai" class="form-control">
                    <?php foreach ($loai_dien_thoais as $loai_dien_thoai) : ?>
                    <option value=" <?= $loai_dien_thoai->id_loai ?>"> <?= $loai_dien_thoai->ten_loai ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label display-7 font-weight-bold " for="so_luong">Số lượng</label>

                <input type="number" min="1" name="so_luong" class="form-control is-invalid" maxlen="255" id="phone"
                    placeholder="Nhập số lượng sản phẩm... "
                    value="<?= isset($_POST['so_luong']) ? htmlspecialchars($_POST['so_luong']) : '' ?>" required>
                <?php if (isset($errors['so_luong'])) : ?>
                <div class="invalid-feedback">
                    <strong><?= htmlspecialchars($errors['so_luong']) ?></strong>
                </div>
                <?php endif ?>
            </div>

            <!-- Submit -->
            <br>
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Lưu sản phẩm</button>
        </form>
    </section>
</main>