<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "cinemablit");
if (mysqli_connect_errno()) {
    exit("خطا در اتصال به پایگاه داده: " . mysqli_connect_error());
}
$id = $_SESSION['id'];
if(isset($_GET['movid'])){
    $movid = $_GET['movid']; 

    if (isset($_POST['seats']) && is_array($_POST['seats'])) {
        $reserved_seats = [];

        foreach ($_POST['seats'] as $seatid) {
                $reserved_seats[] = $seatid;
        }
            $_SESSION['ok'] = "صندلی‌ها با موفقیت انتخاب شدند";
            $seat_count = count($reserved_seats);
            $_SESSION['seat_count'] = $seat_count;
            $_SESSION['reserved_seats'] = $reserved_seats;
            header("Location: buy.php?movid=$movid&id=$id&seatscount=$seat_count");
            exit();
    } else {
        $_SESSION['error'] = "هیچ صندلی‌ای انتخاب نشده است";
        header("Location: seats.php?movid=$movid");
        exit();
    }
} else {
     $_SESSION['error'] = "خطایی در دریافت آیدی فیلم رخ داد";
     header("Location: seats.php");
     exit();
}
?>
