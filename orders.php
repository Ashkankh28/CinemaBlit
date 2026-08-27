<?php
session_start();

if(!isset($_SESSION['usertype']) || ($_SESSION['usertype'] != "admin")){
    header("Location: 404page.php");
    exit();
}

include("header.php");
include("errorOKhandle.php");
 ?>
<table align="center" width="100%" class="layout-row">
    <tr>
        <td>
    <table id="admin" align="center" border="1px" style="border-collapse: separate;overflow: hidden;margin-bottom:20px" dir="rtl">
        <tr>
            <td align="center"><label id="lbl">نام فیلم</label></td>
            <td align="center"><label id="lbl">نام خریدار</label></td>
            <td align="center"><label id="lbl">تاریخ پخش</label></td>
            <td align="center"><label id="lbl">سانس</label></td>
            <td align="center"><label id="lbl">تعداد بلیط </label></td>
            <td align="center"><label id="lbl">قیمت هر بلیط</label></td>
            <td align="center"><label id="lbl">صندلی ها</label></td>
            <td align="center"><label id="lbl">تصویر</label></td>
            <td align="center"><label id="lbl">تاریخ ثبت خرید</label></td>
            <td align="center"><label id="lbl">ابزار</label></td>
        </tr>
        <?php
        $tickquery = "SELECT * FROM ticket";
        $tickresult = mysqli_query($link, $tickquery);

while ($tickrow = mysqli_fetch_array($tickresult)) {
    $movid = $tickrow['movid'];
    $tickid = $tickrow['tickid'];
    $tickcount = $tickrow['tickcount'];
    $tickprice = $tickrow['tickprice'];
    $showdate = $tickrow['showdate'];
    $showtime = $tickrow['showtime'];
    $created = $tickrow['created'];
    $userid = $tickrow['userid'];

    $movquery = "SELECT * FROM movies WHERE movid = $movid";
    $movresult = mysqli_query($link, $movquery);
    $movrow = mysqli_fetch_array($movresult);
    $movname = $movrow['movname'];
    $movpicture = $movrow['movpicture'];

    $userquery = "SELECT * FROM users WHERE id=$userid";
    $userresult = mysqli_query($link,$userquery);
    $userrow = mysqli_fetch_array($userresult);

    $seatsquery = "SELECT * FROM seats WHERE tickid = $tickid";
    $seatsresult = mysqli_query($link, $seatsquery);
    $seat_list = [];
    while ($seatsrow = mysqli_fetch_array($seatsresult)) {
        $seat_list[] = $seatsrow['seatrow'] . $seatsrow['seatnum'];
    }
    $seat_display = implode(", ", $seat_list);
    ?>
    <tr>
        <td align="center"><label id="lbl"><?php echo($movname); ?></label></td>
        <td align="center"><label id="lbl"><?php echo($userrow['namefamily']); ?></label></td>
        <td align="center"><label id="lbl"><?php echo($showdate); ?></label></td>
        <td align="center"><label id="lbl"><?php echo($showtime); ?></label></td>
        <td align="center"><label id="lbl"><?php echo($tickcount); ?></label></td>
        <td align="center"><label id="lbl"><?php echo($tickprice); ?></label></td>
        <td align="center"><label id="lbl"><?php echo($seat_display); ?></label></td>
        <td align="center"><img src="./pics/<?php echo($movpicture); ?>"
        width="80px" alt="<?php echo($movname);?>" /></td>
        <td align="center"><label id="lbl"><?php echo($created); ?></label></td>
        <td align="center"><a href="delorder.php?tickid=<?php echo($tickrow['tickid']); ?>">
            <label id="lbl">حذف</label></a></td>
    </tr>
    <?php } ?>
    </table>
        </td>
        <td>
            <?php
                include("adminSidebar.html");
            ?>
    </tr>
</table>
<?php
include("footer.php");
?>
