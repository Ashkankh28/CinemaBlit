<?php
session_start();

if(!isset($_SESSION['usertype']) || ($_SESSION['usertype'] != "admin")){
    header("Location: 404page.php");
    exit();
}

require_once "config.php";

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

$getPic = mysqli_query($link, "SELECT movpicture FROM movies WHERE movid = $id");
$picRow = mysqli_fetch_assoc($getPic);
$picPath = "./pics/" . $picRow['movpicture'];
if (file_exists($picPath)) {
    unlink($picPath);
}

    $query = "DELETE FROM movies WHERE movid = $id";
    $seatquery = "DELETE FROM seats WHERE movid = $id";
    if (mysqli_query($link, $query) && mysqli_query($link, $seatquery)) {
        $_SESSION['ok'] = "فیلم با موفقیت حذف شد";
    } else {
        $_SESSION['error'] = "خطا در حذف فیلم!";
    }
    

    header("Location: admin.php");
    exit;
}

if (
    isset($_POST['movname'], $_POST['movdirector'], $_POST['movdate'],
        $_POST['movshowtime'], $_POST['movprice'], $_POST['movabout']) &&
    isset($_FILES['movpicture']) && $_FILES['movpicture']['error'] === 0
) {

    $movname = $_POST['movname'];
    $movdirector = $_POST['movdirector'];
    $movdate = $_POST['movdate'];
    $movshowtime = $_POST['movshowtime'];
    $tickets = $_POST['tickets'];
    $movprice = $_POST['movprice'];
    $movabout = $_POST['movabout'];

    $check_query = "SELECT * FROM movies WHERE movname = '$movname' AND movdirector = '$movdirector'";
    $check_result = mysqli_query($link, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['error'] = "این فیلم قبلاً ثبت شده است";
        header("Location: admin.php");
        exit();
    }

    $movpicture = $_FILES['movpicture']['name'];
    $tmp_name = $_FILES['movpicture']['tmp_name'];
    $targetdir = "./pics/";
    $targetfile = $targetdir . basename($movpicture);
    $uploadOK = true;
    $picturetype = strtolower(pathinfo($targetfile, PATHINFO_EXTENSION));

    $check = getimagesize($tmp_name);
    if ($check === false) {
        $_SESSION['error'] = "پرونده انتخاب شده عکس نیست";
        $uploadOK = false;
    }

    if (file_exists($targetfile)) {
        $_SESSION['error'] = "پرونده‌ای با همین نام وجود دارد";
        $uploadOK = false;
    }

    if ($_FILES['movpicture']['size'] > 500 * 1024) {
        $_SESSION['error'] = "حجم فایل بیش از ۵۰۰ کیلوبایت است";
        $uploadOK = false;
    }

    if (!in_array($picturetype, ['jpg', 'jpeg', 'png'])) {
        $_SESSION['error'] = "فقط پسوندهای JPG, JPEG, PNG مجاز هستند";
        $uploadOK = false;
    }

    if (!$uploadOK) {
        header("Location: admin.php");
        exit();
    }

    if (!move_uploaded_file($tmp_name, $targetfile)) {
        $_SESSION['error'] = "آپلود فایل انجام نشد";
        header("Location: admin.php");
        exit();
    }


$insert_query = "INSERT INTO movies (movname, movdirector, movdate, movshowtime, movprice,
                 movpicture, movabout , tickets)
     VALUES ('$movname', '$movdirector', '$movdate', '$movshowtime', '$movprice', '$movpicture',
             '$movabout' , '$tickets')";

    if (mysqli_query($link, $insert_query)) {
        $_SESSION['ok'] = "فیلم با موفقیت اضافه شد";
        $movid = mysqli_insert_id($link);
        $rows = ['A', 'B', 'C', 'D', 'E'];
        $seats_per_row = 10;

        foreach ($rows as $row) {
            for ($i = 1; $i <= $seats_per_row; $i++) {
                $query = "INSERT INTO seats (movid, seatrow, seatnum) VALUES ($movid, '$row', $i)";
                mysqli_query($link, $query);
            }
        }
            header("Location: admin.php");
            exit();
        
    } else {
        $_SESSION['error'] = "خطا در ثبت فیلم در پایگاه داده";
    }
} else {
    $_SESSION['error'] = "لطفاً تمام فیلدها را به‌درستی پر کنید و یک تصویر انتخاب نمایید";
    header("Location: admin.php");
    exit();
}
?>
