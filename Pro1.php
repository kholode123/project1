<?php
// التحقق من تسجيل الدخول ونوع المستخدم
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'pharmacist') {
    header("Location: login.php");
    exit();
}

// اتصال بقاعدة البيانات
require_once 'config.php';

// جلب بيانات الصيدلية
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT p.*, u.email FROM pharmacies p JOIN users u ON p.user_id = u.id WHERE u.id = ?");
$stmt->execute([$user_id]);
$pharmacy = $stmt->fetch();

if(!$pharmacy) {
    $_SESSION['error_message'] = "لم يتم العثور على بيانات الصيدلية";
    header("Location: pharmacist.php");
    exit();
}

// معالجة تحديث البيانات
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // جمع البيانات من النموذج مع التطهير
        $name = htmlspecialchars(trim($_POST['name']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $address = htmlspecialchars(trim($_POST['address']));
        $city = htmlspecialchars(trim($_POST['city']));
        $phone = htmlspecialchars(trim($_POST['phone']));
        $license_number = htmlspecialchars(trim($_POST['license_number']));
        
        // التحقق من صحة البيانات
        if(empty($name) || empty($email) || empty($address) || empty($city) || empty($phone) || empty($license_number)) {
            throw new Exception("جميع الحقول مطلوبة");
        }
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("البريد الإلكتروني غير صالح");
        }
        
        // تحديث بيانات المستخدم (البريد الإلكتروني)
        $update_user = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
        $update_user->execute([$email, $user_id]);
        
        // تحديث بيانات الصيدلية
        $update_pharmacy = $pdo->prepare("UPDATE pharmacies SET name = ?, address = ?, city = ?, phone = ?, license_number = ? WHERE user_id = ?");
        $update_pharmacy->execute([$name, $address, $city, $phone, $license_number, $user_id]);
        
        // معالجة صورة الصيدلية إذا تم رفعها
        if (!empty($_FILES['image']['name'])) {
            $target_dir = "uploads/";
            
            // التحقق من أن المجلد موجود أو إنشائه
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            
            // التحقق من أن الملف صورة
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check === false) {
                throw new Exception("الملف المرفوع ليس صورة");
            }
            
            // التحقق من حجم الصورة (2MB كحد أقصى)
            if ($_FILES["image"]["size"] > 2000000) {
                throw new Exception("حجم الصورة يجب أن يكون أقل من 2MB");
            }
            
            // التحقق من نوع الصورة
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowed_types)) {
                throw new Exception("نوع الصورة غير مسموح به. المسموح به: JPG, JPEG, PNG, GIF");
            }
            
            // إنشاء اسم فريد للصورة
            $new_filename = uniqid() . '.' . $imageFileType;
            $target_path = $target_dir . $new_filename;
            
            // محاولة رفع الصورة
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
                // حذف الصورة القديمة إذا كانت موجودة
                if (!empty($pharmacy['image']) && file_exists($pharmacy['image'])) {
                    unlink($pharmacy['image']);
                }
                
                // تحديث مسار الصورة في قاعدة البيانات
                $update_image = $pdo->prepare("UPDATE pharmacies SET image = ? WHERE user_id = ?");
                $update_image->execute([$target_path, $user_id]);
                
                // تحديث صورة الجلسة
                $_SESSION['user_image'] = $target_path;
            } else {
                throw new Exception("حدث خطأ أثناء رفع الصورة");
            }
        }
        
        $_SESSION['success_message'] = "تم تحديث الملف الشخصي بنجاح";
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
    
    header("Location: edit_profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الملف الشخصي - نظام الأدوية النادرة</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* CSS styles remain the same as in the original code */
        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .success-message {
            color: #28a745;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- الشريط الجانبي -->
        <div class="sidebar">
            <div class="logo">
                <i class="fas fa-pills"></i>
                <span>نظام الأدوية النادرة</span>
            </div>
            <ul class="menu">
                <li><a href="pharmacist.php"><i class="fas fa-tachometer-alt"></i> لوحة التحكم</a></li>
                <li><a href="#"><i class="fas fa-pills"></i> إدارة الأدوية</a></li>
                <li><a href="#"><i class="fas fa-search"></i> البحث عن أدوية</a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> التقارير</a></li>
                <li class="active"><a href="edit_profile.php"><i class="fas fa-store"></i> معلومات الصيدلية</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> الإعدادات</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a></li>
            </ul>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="main-content">
            <!-- شريط العنوان -->
            <div class="top-bar">
                <div class="search">
                    <input type="text" placeholder="ابحث عن دواء...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="user-info">
                    <img src="<?php echo $_SESSION['user_image'] ?: 'https://via.placeholder.com/40'; ?>" alt="صورة المستخدم">
                    <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
            </div>

            <!-- محتوى صفحة التعديل -->
            <div class="profile-container">
                <div class="profile-header">
                    <h2>تعديل الملف الشخصي للصيدلية</h2>
                    <p>قم بتحديث معلومات الصيدلية الخاصة بك</p>
                </div>
                
                <?php if(isset($_SESSION['error_message'])): ?>
                    <div class="error-message"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['success_message'])): ?>
                    <div class="success-message"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="edit_profile.php" enctype="multipart/form-data">
                    <div class="profile-image-container">
                        <img src="<?php echo !empty($pharmacy['image']) ? htmlspecialchars($pharmacy['image']) : 'https://via.placeholder.com/150'; ?>" alt="صورة الصيدلية" class="profile-image" id="profileImagePreview">
                        <label for="profileImage" class="change-image-btn">
                            <i class="fas fa-camera"></i>
                            <input type="file" id="profileImage" name="image" accept="image/*" style="display: none;">
                        </label>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">اسم الصيدلية</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($pharmacy['name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($pharmacy['email']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">عنوان الصيدلية</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($pharmacy['address']); ?>" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">المدينة</label>
                            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($pharmacy['city']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">رقم الهاتف</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($pharmacy['phone']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="license_number">رقم الرخصة</label>
                        <input type="text" id="license_number" name="license_number" value="<?php echo htmlspecialchars($pharmacy['license_number']); ?>" required>
                    </div>
                    
                    <div class="form-actions">
                        <a href="pharmacist.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> رجوع</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // عرض معاينة الصورة عند اختيارها
        document.getElementById('profileImage').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImagePreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
