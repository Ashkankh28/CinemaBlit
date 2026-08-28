<?php
session_start();

if(!isset($_SESSION['usertype']) || ($_SESSION['usertype'] != "admin")){
    header("Location: 404page.php");
    exit();
}

require_once "config.php";

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

$stmt = mysqli_prepare($link,"SELECT movpicture FROM movies WHERE movid = ?");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$picRow = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

$picPath = "./pics/" . $picRow['movpicture'];

if (file_exists($picPath)) {
    unlink($picPath);
}

$seatStmt = mysqli_prepare($link, "DELETE FROM seats WHERE movid = ?");
mysqli_stmt_bind_param($seatStmt, "i", $id);

$seatResult = mysqli_stmt_execute($seatStmt);

mysqli_stmt_close($seatStmt);

$movieStmt = mysqli_prepare($link, "DELETE FROM movies WHERE movid = ?");
mysqli_stmt_bind_param($movieStmt, "i", $id);

$movieResult = mysqli_stmt_execute($movieStmt);

mysqli_stmt_close($movieStmt);


if ($movieResult && $seatResult) {
    $_SESSION['ok'] = "فیلم با موفقیت حذف شد";
} else {
    $_SESSION['error'] = "خطا در حذف فیلم!";
}
    

    header("Location: admin.php");
    exit;
}

if (
    isset($_POST['movname'], $_POST['movdirector'], $_POST['movdate'],
        $_POST['movshowtime'], $_POST['movprice'], $_POST['movabout'], $_POST['tickets']) &&
    isset($_FILES['movpicture']) && $_FILES['movpicture']['error'] === 0
) {

    $movname = $_POST['movname'];
    $movdirector = $_POST['movdirector'];
    $movdate = $_POST['movdate'];
    $movshowtime = $_POST['movshowtime'];
    $tickets = $_POST['tickets'];
    $movprice = $_POST['movprice'];
    $movabout = $_POST['movabout'];

    $checkStmt = mysqli_prepare($link,"SELECT 1 FROM movies WHERE movname = ? AND movdirector = ? LIMIT 1");

    mysqli_stmt_bind_param($checkStmt, "ss", $movname, $movdirector);

    mysqli_stmt_execute($checkStmt);

    $checkResult = mysqli_stmt_get_result($checkStmt);

    if (mysqli_num_rows($checkResult) > 0) {
        mysqli_stmt_close($checkStmt);

        $_SESSION['error'] = "این فیلم قبلاً ثبت شده است";
        header("Location: admin.php");
        exit();
    }

    mysqli_stmt_close($checkStmt);

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

$insertStmt = mysqli_prepare(
    $link,
    "INSERT INTO movies
    (movname, movdirector, movdate, movshowtime, movprice, movpicture, movabout, tickets)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
    $insertStmt,
    "sssssssi",
    $movname,
    $movdirector,
    $movdate,
    $movshowtime,
    $movprice,
    $movpicture,
    $movabout,
    $tickets
);

if (mysqli_stmt_execute($insertStmt)) {

    $movid = mysqli_insert_id($link);

    mysqli_stmt_close($insertStmt);

    $_SESSION['ok'] = "فیلم با موفقیت اضافه شد";

    $rows = ['A', 'B', 'C', 'D', 'E'];
    $seats_per_row = 10;

    $seatStmt = mysqli_prepare(
        $link,
        "INSERT INTO seats (movid, seatrow, seatnum) VALUES (?, ?, ?)"
    );

    foreach ($rows as $row) {
        for ($i = 1; $i <= $seats_per_row; $i++) {

            mysqli_stmt_bind_param(
                $seatStmt,
                "isi",
                $movid,
                $row,
                $i
            );

            mysqli_stmt_execute($seatStmt);
        }
    }

    mysqli_stmt_close($seatStmt);

    header("Location: admin.php");
    exit();

} else {

    mysqli_stmt_close($insertStmt);

    $_SESSION['error'] = "خطا در ثبت فیلم در پایگاه داده";
}
} else {
    $_SESSION['error'] = "لطفاً تمام فیلدها را به‌درستی پر کنید و یک تصویر انتخاب نمایید";
    header("Location: admin.php");
    exit();
}
?>
