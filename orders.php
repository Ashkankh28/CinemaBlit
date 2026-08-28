<?php

session_start();

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != "admin") {
    header("Location: 404page.php");
    exit();
}

include("header.php");
include("errorOKhandle.php");

$tickStmt = mysqli_prepare($link,
    "SELECT 
        t.tickid,
        t.movid,
        t.userid,
        t.tickcount,
        t.showdate,
        t.showtime,
        t.tickprice,
        t.created,
        m.movname,
        m.movpicture,
        u.namefamily
    FROM ticket t
    INNER JOIN movies m ON t.movid = m.movid
    INNER JOIN users u ON t.userid = u.id"
    );

mysqli_stmt_execute($tickStmt);

$tickResult = mysqli_stmt_get_result($tickStmt);

?>

<table align="center" width="100%" class="layout-row">

    <tr>

        <td>

            <table id="admin" align="center" border="1px"
                   style="border-collapse: separate;overflow: hidden;margin-bottom:20px"
                   dir="rtl">

                <tr>

                    <td align="center">
                        <label id="lbl">نام فیلم</label>
                    </td>

                    <td align="center">
                        <label id="lbl">نام خریدار</label>
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

                    <td align="center">
                        <label id="lbl">ابزار</label>
                    </td>

                </tr>

                <?php

                while ($tickrow = mysqli_fetch_assoc($tickResult)) {

                    $tickid = $tickrow['tickid'];

                    $seatStmt = mysqli_prepare($link, "
                        SELECT seatrow, seatnum
                        FROM seats
                        WHERE tickid = ?
                    ");

                    mysqli_stmt_bind_param($seatStmt, "i", $tickid);
                    mysqli_stmt_execute($seatStmt);

                    $seatResult = mysqli_stmt_get_result($seatStmt);

                    $seat_list = [];

                    while ($seatRow = mysqli_fetch_assoc($seatResult)) {

                        $seat_list[] = $seatRow['seatrow'] . $seatRow['seatnum'];

                    }

                    mysqli_stmt_close($seatStmt);

                    $seat_display = implode(", ", $seat_list);

                ?>

                    <tr>

                        <td align="center">
                            <label id="lbl">
                                <?php echo $tickrow['movname']; ?>
                            </label>
                        </td>

                        <td align="center">
                            <label id="lbl">
                                <?php echo $tickrow['namefamily']; ?>
                            </label>
                        </td>

                        <td align="center">
                            <label id="lbl">
                                <?php echo $tickrow['showdate']; ?>
                            </label>
                        </td>

                        <td align="center">
                            <label id="lbl">
                                <?php echo $tickrow['showtime']; ?>
                            </label>
                        </td>

                        <td align="center">
                            <label id="lbl">
                                <?php echo $tickrow['tickcount']; ?>
                            </label>
                        </td>

                        <td align="center">
                            <label id="lbl">
                                <?php echo $tickrow['tickprice']; ?>
                            </label>
                        </td>

                        <td align="center">
                            <label id="lbl">
                                <?php echo $seat_display; ?>
                            </label>
                        </td>

                        <td align="center">

                            <img src="./pics/<?php echo $tickrow['movpicture']; ?>"
                                 width="80px"
                                 alt="<?php echo $tickrow['movname']; ?>" />

                        </td>

                        <td align="center">
                            <label id="lbl">
                                <?php echo $tickrow['created']; ?>
                            </label>
                        </td>

                        <td align="center">

                            <a href="delorder.php?tickid=<?php echo $tickrow['tickid']; ?>">
                                <label id="lbl">حذف</label>
                            </a>

                        </td>

                    </tr>

                <?php

                }

                mysqli_stmt_close($tickStmt);

                ?>

            </table>

        </td>

        <td>

            <?php
            include("adminSidebar.html");
            ?>

        </td>

    </tr>

</table>

<?php
include("footer.php");
?>