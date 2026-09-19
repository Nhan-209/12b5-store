<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : '' ?>12B5 Store | Siêu Thị Thiết Bị Điện Tử & Công Nghệ Cao</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <!-- CSRF Token Meta for AJAX Requests -->
    <meta name="csrf-token" content="<?= \App\Core\Csrf::token() ?>">
    <!-- BASE_URL for JavaScript -->
    <script>
        const BASE_URL = "<?= BASE_URL ?>";
        console.log('BASE_URL set to:', BASE_URL);
    </script>
</head>
<body>
<?php require __DIR__ . '/navbar.php'; ?>

<!-- Flash Message Notices -->
<?php if (!empty($_SESSION['flash_success'])): ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert" style="background: rgba(236, 253, 245, 0.9); border: 1px solid #a7f3d0; color: #065f46;">
            <i class="bi bi-check-circle-fill me-2 text-success"></i> <?= htmlspecialchars($_SESSION['flash_success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['flash_error'])): ?>
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert" style="background: rgba(255, 241, 242, 0.9); border: 1px solid #fecdd3; color: #9f1239;">
            <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i> <?= htmlspecialchars($_SESSION['flash_error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>

<main class="py-4">
