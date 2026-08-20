<?php 
session_start();
include("header.php");
if (isset($_GET['movid'])){
    $movid = $_GET['movid'];
}
else{
    $_SESSION['error'] = "خطایی در تشخیص فیلم پیش آمده! لطفا دوباره تلاش کنید";
    header("Location: main-cinemablit.php");
    exit;
}
$query = "SELECT * FROM movies WHERE movid = $movid";
$result = mysqli_query($link,$query);
$row = mysqli_fetch_array($result);
$id = $_SESSION['id'];
$query2 = "SELECT * FROM users WHERE id = $id";
$result2 = mysqli_query($link,$query2);
$row2 = mysqli_fetch_array($result2);

$seatquery = "SELECT * FROM seats WHERE movid = $movid ORDER BY seatrow, seatnum";
$seatresult = mysqli_query($link, $seatquery);

include("errorOKhandle.php");
?>
    <form action="buyact.php?id=<?php echo($row2['id'] . '&movid=' . $row['movid']);?>"
     method="POST">
<table id="movbuy" align="center" dir="rtl" style="margin-bottom:40px;">
    <tr>
        <td style="padding-top:20px">
        <img id="movieab" src="./pics/<?php echo($row['movpicture']); ?>" width="300px"
        alt="<?php echo($row['movname']);?>" /> 
        </td>
        <td style="padding-top:20px;">
            <label id="titr">نام فیلم: <?php echo($row['movname']); ?></label><br/><br/>
            <label id="titr">تاریخ پخش: <?php echo($row['movdate']); ?></label><br/><br/>
            <label id="titr">سانس: <?php echo($row['movshowtime']); ?></label><br/><br/>
            <label id="titr">قیمت بلیط: <?php echo($row['movprice']); ?> تومان</label><br/><br/>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top:50px;">
            <label id="titr">خریدار: <?php echo($row2['namefamily']); ?></label><br/><br/>
            <label id="titr">شماره موبایل : <?php echo($row2['phone']); ?></label><br/><br/>
            <label id="titr">ایمیل: <?php echo($row2['email']); ?></label><br/><br/>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top:30px;">
            <p align="center" id="lbl" style="margin-bottom:1rem;">
                <span style="display:inline-block;width:12px;height:12px;border-radius:4px;background:rgba(45,212,167,.35);margin-left:6px;vertical-align:middle;"></span>خالی
                &nbsp;&nbsp;&nbsp;
                <span style="display:inline-block;width:12px;height:12px;border-radius:4px;background:rgba(230,57,80,.35);margin-left:6px;vertical-align:middle;"></span>رزرو شده
            </p>
            <table id="seat" align="center" border="1" style="border-collapse: separate;overflow: hidden;margin-bottom:20px">
                <?php
                $current_row = null;
                while ($srow = mysqli_fetch_array($seatresult)) {
                    $seat = $srow['seatrow'] . $srow['seatnum'];
                    $reserved = $srow['reserved'];
                    $row_letter = $srow['seatrow'];

                    if ($row_letter != $current_row) {
                        if ($current_row !== null) {
                            echo '</tr>';
                        }
                        echo '<tr><th align="center">' . $row_letter . '</th>';
                        $current_row = $row_letter;
                    }
                    if ($reserved) {
                        echo '<td align="center" style="background-color: red; text-align: center;">' . $seat . '</td>';
                    } else {
                        echo '<td align="center" style="background-color: green; text-align: center;">' . $seat .
                             ' <input type="checkbox" name="seats[]" value="' . $srow['seatid'] . '" /></td>';
                    }
                }
                ?>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top:30px;padding-bottom:100px">
            <button id="btn" style="cursor: pointer;">ثبت خرید</button>
        </td>
    </tr>
</table>
</form>
<?php
include("footer.php");
?>