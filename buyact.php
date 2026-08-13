<?php
session_start();

require_once "config.php";

if(isset($_GET['id']) && isset($_GET['movid'])){
    $id = $_GET['id'];
    $movid = $_GET['movid'];
    if(!isset($_SESSION['seat_count'])){
        $_SESSION['error'] = "صندلی انتخاب نشده";
        unset($_SESSION['seat_count']);
        unset($_SESSION['reserved_seats']);
        header("Location: buy.php?movid=$movid&id=$id");
        exit();
}else{
    $seat_count = $_SESSION['seat_count'];
if (isset($_POST['tick']) && !empty($_POST['tick'])) {
    $tickcount = (int)$_POST['tick'];
    $seats = $_SESSION['reserved_seats'];

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

    if($tickcount == $seat_count){
    if ($tickets >= $tickcount) {
        $upquery = "UPDATE movies SET tickets = tickets-$tickcount WHERE movid = $movid";
        $inquery = "INSERT INTO ticket (userid, movid, tickcount, showdate, showtime, tickprice, created)
                    VALUES ($id, $movid, $tickcount, '$date', '$showtime', $price, '$datenow')";
        
        if (mysqli_query($link, $upquery) && mysqli_query($link, $inquery)) {
            $_SESSION['ok'] = "خرید با موفقیت ثبت شد";
            $tickid = mysqli_insert_id($link); 
                foreach($seats as $seat){
                    $query3="UPDATE seats SET reserved = 1 , tickid = $tickid 
                             WHERE seatid = $seat AND movid = $movid";
                    mysqli_query($link, $query3);
        }
     } else {
            $_SESSION['error'] = "خطایی در فرایند ثبت خرید رخ داد";
        }
    } else {
        $_SESSION['error'] = "تعداد بلیط درخواستی بیشتر از بلیط موجود است";
    }
    }else{
        $_SESSION['error'] = "تعداد صندلی انتخاب شده با تعداد بلیط درخواستی برابر نیست";
        unset($_SESSION['seat_count']);
        unset($_SESSION['reserved_seats']);
         header("Location: buy.php?movid=$movid&id=$id");
         exit();
    }
        unset($_SESSION['seat_count']);
        unset($_SESSION['reserved_seats']);
        header("Location: tickcart.php");
        exit();
} else {
    $_SESSION['error'] = "لطفا تعداد بلیط مورد نظر را وارد کنید";
    unset($_SESSION['seat_count']);
    unset($_SESSION['reserved_seats']);
    header("Location: buy.php?movid=$movid&id=$id");
    exit();
}
}
}else{
    $_SESSION['error'] = "آیدی کاربر یا فیلم دریافت نشده";
    unset($_SESSION['seat_count']);
    unset($_SESSION['reserved_seats']);
    header("Location: buy.php?movid=$movid&id=$id");
    exit();
}
?>
