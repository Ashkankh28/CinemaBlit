<?php
session_start();
require_once "config.php";

if(isset($_GET['id']) && isset($_GET['movid'])){
    $id = $_GET['id'];
    $movid = $_GET['movid'];

    if (!isset($_POST['seats']) || !is_array($_POST['seats']) || count($_POST['seats']) == 0) {
        $_SESSION['error'] = "هیچ صندلی‌ای انتخاب نشده است";
        header("Location: buy.php?movid=$movid&id=$id");
        exit();
    }

    $seats = array_map('intval', $_POST['seats']);
    $tickcount = count($seats);

    // اعتبارسنجی: صندلی‌های ارسالی واقعاً متعلق به این فیلم و آزاد باشند
    $seat_ids_str = implode(',', $seats);
    $checkquery = "SELECT seatid FROM seats WHERE seatid IN ($seat_ids_str) AND movid = $movid AND reserved = 0";
    $checkresult = mysqli_query($link, $checkquery);
    $valid_count = mysqli_num_rows($checkresult);

    if ($valid_count != $tickcount) {
        $_SESSION['error'] = "برخی از صندلی‌های انتخابی معتبر نیستند یا قبلاً رزرو شده‌اند";
        header("Location: buy.php?movid=$movid&id=$id");
        exit();
    }

    $query = "SELECT * FROM movies WHERE movid=$movid";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);
    $movid = $row['movid'];

    $date = $row['movdate'];
    $showtime = $row['movshowtime'];
    $price = (int)$row['movprice'];
    $tickets = $row['tickets'];
    $datenow = date('Y-m-d');

    $query2 = "SELECT * FROM users WHERE id = $id";
    $result2 = mysqli_query($link, $query2);
    $row2 = mysqli_fetch_array($result2);
    $id = $row2['id'];

    if ($tickets >= $tickcount) {
        $upquery = "UPDATE movies SET tickets = tickets-$tickcount WHERE movid = $movid";
        $inquery = "INSERT INTO ticket (userid, movid, tickcount, showdate, showtime, tickprice, created)
                    VALUES ($id, $movid, $tickcount, '$date', '$showtime', $price, '$datenow')";

        if (mysqli_query($link, $upquery) && mysqli_query($link, $inquery)) {
            $_SESSION['ok'] = "خرید با موفقیت ثبت شد";
            $tickid = mysqli_insert_id($link);
            foreach ($seats as $seat) {
                $query3 = "UPDATE seats SET reserved = 1, tickid = $tickid
                           WHERE seatid = $seat AND movid = $movid";
                mysqli_query($link, $query3);
            }
        } else {
            $_SESSION['error'] = "خطایی در فرایند ثبت خرید رخ داد";
            header("Location: buy.php?movid=$movid&id=$id");
            exit();
        }
    } else {
        $_SESSION['error'] = "تعداد بلیط درخواستی بیشتر از بلیط موجود است";
        header("Location: buy.php?movid=$movid&id=$id");
        exit();
    }

    header("Location: tickcart.php");
    exit();
} else {
    $_SESSION['error'] = "آیدی کاربر یا فیلم دریافت نشده";
    header("Location: buy.php?movid=$movid&id=$id");
    exit();
}
?>