<?php
require_once '../includes/session.php';
require_once '../config/db.php';
require_once '../includes/functions.php';
set_base_depth(1);
require_role(['seller']);

$uid   = current_user()['id'];
$editId = (int)($_GET['edit'] ?? 0);
$product = null;

if ($editId) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=? AND seller_id=?");
    $stmt->execute([$editId, $uid]);
    $product = $stmt->fetch();
    if (!$product) redirect('dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $desc  = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);

    if ($name === '' || $price <= 0) {
        $error = 'Product name and a valid price are required.';
    } else {
        // Image upload
        $uploadDir   = dirname(__DIR__) . '/uploads/products';
        $imgResult   = handle_upload('image', $uploadDir, 'uploads/products', ['jpg','jpeg','png','webp'], 5*1024*1024);
        if ($imgResult['error']) { $error = $imgResult['error']; }

        if (!$error) {
            if ($editId && $product) {
                $imgPath = $imgResult['ok'] ? $imgResult['path'] : $product['image_path'];
                $pdo->prepare("UPDATE products SET name=?, description=?, price=?, image_path=? WHERE id=?")
                    ->execute([$name, $desc, $price, $imgPath, $editId]);
                $savedId = $editId;
            } else {
                $imgPath = $imgResult['ok'] ? $imgResult['path'] : null;
                $ins = $pdo->prepare("INSERT INTO products (seller_id, name, description, price, image_path) VALUES (?,?,?,?,?)");
                $ins->execute([$uid, $name, $desc, $price, $imgPath]);
                $savedId = $pdo->lastInsertId();
            }

            // Document upload (multiple allowed)
            $docDir = dirname(__DIR__) . '/uploads/documents';
            if (!empty($_FILES['documents']['name'][0])) {
                $files = $_FILES['documents'];
                $count = count($files['name']);
                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;
                    $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                    if (!in_array($ext, ['pdf','doc','docx','txt'], true)) continue;
                    if ($files['size'][$i] > 10*1024*1024) continue;
                    if (!is_dir($docDir)) mkdir($docDir, 0775, true);
                    $safe = uniqid('doc_',true).'.'.$ext;
                    if (move_uploaded_file($files['tmp_name'][$i], $docDir.'/'.$safe)) {
                        $pdo->prepare("INSERT INTO product_documents (product_id, file_name, file_path) VALUES (?,?,?)")
                            ->execute([$savedId, $files['name'][$i], 'uploads/documents/'.$safe]);
                    }
                }
            }

            set_flash('success', $editId ? 'Product updated!' : 'Product uploaded! It will appear after admin approval.');
            redirect('dashboard.php');
        }
    }
}

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $editId ? 'Edit' : 'Upload' ?> Product – AccessTech</title>
  <link rel="stylesheet" href="../assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>
<?php require '../includes/navbar.php'; ?>

<section class="section" style="min-height:80vh;">
  <div class="section-header">
    <h2><?= $editId ? 'Edit Product' : 'Upload New Product' ?></h2>
    <p><?= $editId ? 'Update your product details below.' : 'Fill in the details below. Your product will be reviewed by an admin before going live.' ?></p>
  </div>

  <?php if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>" style="max-width:600px;margin:0 auto 20px;"><?= e($flash['message']) ?></div>
  <?php endif; ?>
  <?php if ($error): ?>
    <div class="flash error" style="max-width:600px;margin:0 auto 20px;"><?= e($error) ?></div>
  <?php endif; ?>

  <div class="form-card" style="max-width:600px; margin:0 auto;">
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>Product Name *</label>
        <input name="name" type="text" class="form-input" placeholder="e.g. Wireless Headphones Pro" value="<?= e($product['name'] ?? '') ?>" required/>
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-input" rows="5" placeholder="Describe the product features, condition, specs..."><?= e($product['description'] ?? '') ?></textarea>
      </div>
      <div class="form-group">
        <label>Price (frw) *</label>
        <input name="price" type="number" step="0.01" min="1" class="form-input" placeholder="50000" value="<?= e($product['price'] ?? '') ?>" required/>
      </div>
      <div class="form-group">
        <label>Product Image <?= $editId ? '(leave blank to keep current)' : '' ?></label>
        <?php if ($editId && $product['image_path']): ?>
          <img src="../<?= e($product['image_path']) ?>" alt="" style="width:120px;height:80px;object-fit:cover;border-radius:6px;display:block;margin-bottom:8px;"/>
        <?php endif; ?>
        <input name="image" type="file" class="form-input" accept="image/jpeg,image/png,image/webp"/>
        <p class="form-help">JPG, PNG or WEBP · Max 5 MB</p>
      </div>
      <div class="form-group">
        <label>Product Documents (PDFs, manuals — optional)</label>
        <input name="documents[]" type="file" class="form-input" accept=".pdf,.doc,.docx,.txt" multiple/>
        <p class="form-help">PDF, DOC, DOCX or TXT · Max 10 MB each · You can select multiple files</p>
      </div>
      <button type="submit" class="btn-submit btn-full"><?= $editId ? 'Save Changes' : 'Upload Product' ?></button>
      <a href="dashboard.php" style="display:block; text-align:center; margin-top:14px; color:#9db4d4; font-size:.9rem;">← Back to Dashboard</a>
    </form>
  </div>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech. All rights reserved.</footer>
</body>
</html>