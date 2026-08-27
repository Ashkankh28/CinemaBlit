<?php
session_start();
include("header.php");
if (isset($_SESSION['error'])){ ?>
    <p align="center" dir="rtl" id="btn"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php }
if(isset($_SESSION['ok'])){ ?>
    <p align="center" id="ok"><?php echo $_SESSION['ok']; unset($_SESSION['ok']);?></p>
<?php }
if (isset($_GET['movid'])) {
    $movid = $_GET['movid'];
    $query = "SELECT * FROM seats WHERE movid = $movid ORDER BY seatrow, seatnum";
    $result = mysqli_query($link, $query);
    ?>
    <p align="center" id="lbl" style="margin-bottom:1rem;">
        <span style="display:inline-block;width:12px;height:12px;border-radius:4px;background:rgba(45,212,167,.35);margin-left:6px;vertical-align:middle;"></span>خالی
        &nbsp;&nbsp;&nbsp;
        <span style="display:inline-block;width:12px;height:12px;border-radius:4px;background:rgba(230,57,80,.35);margin-left:6px;vertical-align:middle;"></span>رزرو شده
    </p>
    <form action="reserv.php?movid=<?php echo($movid); ?>" method="POST">
    <table id="seat" align="center" border="1" style=
    "border-collapse: separate;overflow: hidden;margin-bottom:20px">
    <?php
    $current_row = null;
    while ($row = mysqli_fetch_array($result)) {
        $seat = $row['seatrow'] . $row['seatnum'];
        $reserved = $row['reserved'];
        $row_letter = $row['seatrow'];

        if ($row_letter != $current_row) {
            if ($current_row !== null) {
                ?></tr>
            <?php } ?>
            <tr><th align="center"><?php echo($row_letter); ?></th>
            <?php $current_row = $row_letter;
        }
        if ($reserved) { ?>
            <td align="center" style="background-color: red; text-align: center;"><?php echo($seat); ?></td>
        <?php } else { ?>
            <td align="center" style="background-color: green; text-align: center;"><?php echo($seat); ?>
            <input type="checkbox" name="seats[]" value="<?php echo($row['seatid']);?>" /> </td>
       <?php }
    } ?>
     </tr>   
    </table>
            <p align="center"><button id="btn" style="cursor: pointer;" >ثبت صندلی</button></p>
        </form>
<?php }
include("footer.php");
?>