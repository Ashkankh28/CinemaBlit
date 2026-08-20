<?php
session_start();
include("header.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM movies WHERE movid = $id";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {
    $id = $_POST['movid'];
    $name = $_POST['movname'];
    $director = $_POST['movdirector'];
    $date = $_POST['movdate'];
    $showtime = $_POST['movshowtime'];
    $price = $_POST['movprice'];
    $tickets = $_POST['tickets'];
    $about = $_POST['movabout'];

    $oldImage = $_POST['oldpicture'];
    if (!empty($_FILES['movpicture']['name'])) {
        $image = $_FILES['movpicture']['name'];
        $tmp = $_FILES['movpicture']['tmp_name'];
        move_uploaded_file($tmp, "./pics/$image");
    } else {
        $image = $oldImage;
    }

    $query = "UPDATE movies SET movname = '$name', movdirector = '$director', movdate = '$date',
              movshowtime = '$showtime', tickets = '$tickets', movprice = '$price',
              movpicture = '$image', movabout = '$about' WHERE movid = $id";

    if (mysqli_query($link, $query)) {
        $_SESSION['ok'] = "فیلم با موفقیت ویرایش شد";
        header("Location: admin.php");
        exit;
    } else {
        $_SESSION['error'] = "خطا در ویرایش فیلم";
    }
}
?>
<table align="center" width="100%" class="layout-row">
    <tr>
        <td>
<form action="editmov.php?id=<?php echo $row['movid']; ?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="movid" value="<?php echo $row['movid']; ?>">
<table id="user" align="center" style="margin-bottom:20px;">
    <tr>
        <td><input id="inform" name="movname" type="text" value="<?php echo $row['movname']; ?>" /></td>
        <td><label id="titr" style="padding-right:40px;">:نام فیلم</label></td>
    </tr>
    <tr>
        <td><input id="inform" name="movdirector" type="text" value="<?php echo $row['movdirector']; ?>" /></td>
        <td><label id="titr" style="padding-right:40px">:کارگردان فیلم</label></td>
    </tr>
    <tr>
        <td><input id="inform" name="movdate" type="text" value="<?php echo $row['movdate']; ?>" /></td>
        <td><label id="titr" style="padding-right:40px">:تاریخ پخش</label></td>
    </tr>
    <tr>
        <td><input id="inform" name="movshowtime" type="text" value="<?php echo $row['movshowtime']; ?>" /></td>
        <td><label id="titr" style="padding-right:40px">:سانس</label></td>
    </tr>
    <tr>
        <td><input id="inform" name="movprice" type="text" value="<?php echo $row['movprice']; ?>" /></td>
        <td><label id="titr" style="padding-right:40px">:قیمت بلیط</label></td>
    </tr>
    <tr>
        <td><input id="inform" name="tickets" type="text" value="<?php echo $row['tickets']; ?>" /></td>
        <td><label id="titr" style="padding-right:40px">:تعداد بلیط</label></td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="hidden" name="oldpicture" value="<?php echo $row['movpicture']; ?>">
            <input name="movpicture" type="file" />
            <label id="titr" style="padding-right:15px">:تصویر جدید</label>
        </td>
    </tr>
    <tr>
        <td>
            <textarea id="inform" name="movabout" cols="22" rows="5"><?php echo $row['movabout']; ?></textarea>
        </td>
        <td><label id="titr" style="padding-right:40px">:درباره فیلم</label></td>
    </tr>
    <tr>
        <td colspan="2" align="center" style="padding-top:20px;padding-bottom:10px">
            <button id="btn" name="submit" style="cursor: pointer;" >ثبت تغییرات</button>
        </td>
    </tr>
</table>
</form>
        </td>
            <?php
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == "admin") {
                include("adminSidebar.html");
            }
            ?>
    </tr>
</table>
<?php include("footer.php"); ?>
