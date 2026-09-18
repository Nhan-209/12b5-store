<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Lỗi Hệ Thống | 12B5 Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .error-card {
            background: #ffffff;
            border-radius: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05), 0 8px 10px -6px rgba(0,0,0,0.05);
            border: 1px solid rgba(226, 232, 240, 0.8);
            max-width: 580px;
            width: 100%;
            padding: 3rem 2rem;
            text-align: center;
        }
        .error-code {
            font-size: 5rem;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }
        .btn-rose {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            color: #ffffff;
            border: none;
            padding: 0.75rem 1.75rem;
            border-radius: 9999px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: opacity 0.2s ease;
        }
        .btn-rose:hover {
            opacity: 0.92;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-code">500</div>
        <h3 class="fw-bold mb-3 text-dark">Đã xảy ra sự cố hệ thống</h3>
        <p class="text-muted mb-4">
            <?= htmlspecialchars($errorMessage ?? 'Hệ thống đang gặp sự cố kết nối tạm thời. Đội ngũ kỹ thuật 12B5 Store đã được thông báo để xử lý.') ?>
        </p>
        <div>
            <a href="/" class="btn-rose shadow-sm">
                <i class="bi bi-house-door"></i> Về Trang Chủ
            </a>
        </div>
    </div>
</body>
</html>
