<?php

session_start();

include("header.php");
include("errorOKhandle.php");

$userid = $_SESSION['id'];

$tickStmt = mysqli_prepare($link, "
    SELECT
        t.tickid,
        t.tickcount,
        t.tickprice,
        t.showdate,
        t.showtime,
        t.created,
        m.movname,
        m.movpicture,
        s.seatrow,
        s.seatnum
    FROM ticket t
    INNER JOIN movies m ON t.movid = m.movid
    LEFT JOIN seats s ON t.tickid = s.tickid
    WHERE t.userid = ?
    ORDER BY t.created DESC
");

mysqli_stmt_bind_param($tickStmt, "i", $userid);
mysqli_stmt_execute($tickStmt);

$tickResult = mysqli_stmt_get_result($tickStmt);

?>

<table id="admin" align="center" border="1px"
       style="border-collapse: separate;overflow: hidden;margin-bottom:20px"
       dir="rtl">

    <tr>
        <td align="center">
            <label id="lbl">نام فیلم</label>
        </td>

        <td align="center">
            <label id="lbl">تاریخ پخش</label>
        </td>

        <td align="center">
            <label id="lbl">سانس</label>
        </td>

        <td align="center">
            <label id="lbl">تعداد بلیط</label>
        </td>

        <td align="center">
            <label id="lbl">قیمت هر بلیط</label>
        </td>

        <td align="center">
            <label id="lbl">صندلی ها</label>
        </td>

        <td align="center">
            <label id="lbl">تصویر</label>
        </td>

        <td align="center">
            <label id="lbl">تاریخ ثبت خرید</label>
        </td>
    </tr>

<?php

$currentTickid = null;
$seat_list = [];

while ($tickRow = mysqli_fetch_assoc($tickResult)) {

    if ($currentTickid !== null && $currentTickid != $tickRow['tickid']) {

?>

    <tr>

        <td align="center">
            <label id="lbl"><?php echo $movname; ?></label>
        </td>

        <td align="center">
            <label id="lbl"><?php echo $showdate; ?></label>
        </td>

        <td align="center">
            <label id="lbl"><?php echo $showtime; ?></label>
        </td>

        <td align="center">
            <label id="lbl"><?php echo $tickcount; ?></label>
        </td>

        <td align="center">
            <label id="lbl"><?php echo $tickprice; ?></label>
        </td>

        <td align="center">
            <label id="lbl"><?php echo implode(", ", $seat_list); ?></label>
        </td>

        <td align="center">
            <img src="./pics/<?php echo $movpicture; ?>"
                 width="80px"
                 alt="<?php echo $movname; ?>" />
        </td>

        <td align="center">
            <label id="lbl"><?php echo $created; ?></label>
        </td>

    </tr>

<?php

        $seat_list = [];
    }

    if ($currentTickid === null || $currentTickid != $tickRow['tickid']) {

        $currentTickid = $tickRow['tickid'];

        $movname = $tickRow['movname'];
        $movpicture = $tickRow['movpicture'];
        $tickcount = $tickRow['tickcount'];
        $tickprice = $tickRow['tickprice'];
        $showdate = $tickRow['showdate'];
        $showtime = $tickRow['showtime'];
        $created = $tickRow['created'];
    }

    if ($tickRow['seatrow'] !== null && $tickRow['seatnum'] !== null) {
        $seat_list[] = $tickRow['seatrow'] . $tickRow['seatnum'];
    }
}

if ($currentTickid !== null) {

?>

    <tr>

        <td align="center">
            <label id="lbl"><?php echo $movname; ?></label>
        </td>

        <td align="center">
            <label id="lbl"><?php echo $showdate; ?></label>
        </td>

        <td align="center">
            <label id="lbl"><?php echo $showtime; ?></label>
        </td>

        <td align="center">
            <label id="lbl"><?php echo $tickcount; ?></label>
        </td>

        <td align="center">
            <label id="lbl"><?php echo $tickprice; ?></label>
        </td>

        <td align="center">
            <label id="lbl"><?php echo implode(", ", $seat_list); ?></label>
        </td>

        <td align="center">
            <img src="./pics/<?php echo $movpicture; ?>"
                 width="80px"
                 alt="<?php echo $movname; ?>" />
        </td>

        <td align="center">
            <label id="lbl"><?php echo $created; ?></label>
        </td>

    </tr>

<?php
}

mysqli_stmt_close($tickStmt);

?>

</table>

<?php
include("footer.php");
?>