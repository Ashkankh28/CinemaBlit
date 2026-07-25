<?php
session_start();
include("header.php");
if (isset($_SESSION['error'])){ ?>
    <p align="center" dir="rtl" id="btn"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php }
if(isset($_SESSION['ok'])){ ?>
    <p align="center" id="ok"><?php echo $_SESSION['ok']; unset($_SESSION['ok']);?></p>
<?php } 
?>
    <table id="admin" align="center" border="1px" style=
    " border-collapse: separate;overflow: hidden;margin-bottom:20px" dir="rtl">
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
                <label id="lbl">تعداد بلیط </label>
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
        $userid = $_SESSION['id'];
        $tickquery = "SELECT * FROM ticket WHERE userid = $userid ORDER BY created DESC";
        $tickresult = mysqli_query($link, $tickquery);

while ($tickrow = mysqli_fetch_array($tickresult)) {
    $movid = $tickrow['movid'];
    $tickid = $tickrow['tickid'];
    $tickcount = $tickrow['tickcount'];
    $tickprice = $tickrow['tickprice'];
    $showdate = $tickrow['showdate'];
    $showtime = $tickrow['showtime'];
    $created = $tickrow['created'];

    $movquery = "SELECT * FROM movies WHERE movid = $movid";
    $movresult = mysqli_query($link, $movquery);
    $movrow = mysqli_fetch_array($movresult);
    $movname = $movrow['movname'];
    $movpicture = $movrow['movpicture'];

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
        <td align="center"><label id="lbl"><?php echo($showdate); ?></label></td>
        <td align="center"><label id="lbl"><?php echo($showtime); ?></label></td>
        <td align="center"><label id="lbl"><?php echo($tickcount); ?></label></td>
        <td align="center"><label id="lbl"><?php echo($tickprice); ?></label></td>
        <td align="center"><label id="lbl"><?php echo($seat_display); ?></label></td>
        <td align="center"><img src="./pics/<?php echo($movpicture); ?>"
        width="80px" alt="<?php echo($movname);?>" /></td>
        <td align="center"><label id="lbl"><?php echo($created); ?></label></td>
    </tr>
    <?php } ?>

    </table>

<?php 
include("footer.php");
?>