<?php
session_start();
include("header.php");
if (isset($_SESSION['error'])){ ?>
    <p align="center" dir="rtl" id="btn"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php }
if(isset($_SESSION['ok'])){ ?>
    <p align="center" id="ok"><?php echo $_SESSION['ok']; unset($_SESSION['ok']);?></p>
<?php } ?>
<table align="center" width="100%" class="layout-row">
    <tr>
        <td>
    <?php
    $query = "SELECT * FROM movies";
    $result = mysqli_query($link,$query);
    ?>
    <table id="admin" dir="rtl" border="1px" style=" border-collapse: separate;overflow: hidden;">
        <tr>
            <td align="center"><label id="lbl">کدفیلم</label></td>
            <td align="center"><label id="lbl">نام فیلم</label></td>
            <td align="center"><label id="lbl">کارگردان</label></td>
            <td align="center"><label id="lbl">تاریخ پخش</label></td>
            <td align="center"><label id="lbl">سانس</label></td>
            <td align="center"><label id="lbl">قیمت بلیط</label></td>
            <td align="center"><label id="lbl">تعداد بلیط</label></td>
            <td align="center"><label id="lbl">توضیحات</label></td>
            <td align="center"><label id="lbl">تصویر</label></td>
            <td align="center"><label id="lbl">ابزار</label></td>
        </tr>
        <?php
        while($row = mysqli_fetch_array($result)){
        ?>
        <tr>
            <td align="center"><label id="lbl"><?php echo($row['movid']) ?></label></td>
            <td align="center"><label id="lbl"><?php echo($row['movname']) ?></label></td>
            <td align="center"><label id="lbl"><?php echo($row['movdirector']) ?></label></td>
            <td align="center"><label id="lbl"><?php echo($row['movdate']) ?></label></td>
            <td align="center"><label id="lbl"><?php echo($row['movshowtime']) ?></label></td>
            <td align="center"><label id="lbl"><?php echo($row['movprice']) ?></label></td>
            <td align="center"><label id="lbl"><?php echo($row['tickets']) ?></label></td>
            <td align="center"><label id="lbl"><?php echo substr($row['movabout'], 0, 50) . '...'; ?></label></td>
            <td align="center"><img src="./pics/<?php echo $row['movpicture']; ?>" width="80px" style="padding-left:10px" /></td>
            <td align="center">
                <a id="lbl" href="adminact.php?action=delete&id=<?php echo $row['movid']; ?>">حذف</a>
                <br/>&nbsp;
                <a id="lbl" href="editmov.php?id=<?php echo $row['movid']; ?>">ویرایش</a>
            </td>
        </tr>
        <?php } ?>
    </table>
        </td>
            <?php
            if ($_SESSION['usertype'] == "admin") {
                include("adminSidebar.html");
            }
            ?>
    </tr>
</table>
<?php
include("footer.php");
?>
