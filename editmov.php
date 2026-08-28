<?php
session_start();

if(!isset($_SESSION['usertype']) || ($_SESSION['usertype'] != "admin")){
    header("Location: 404page.php");
    exit();
}

include("header.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($link, "SELECT * FROM movies WHERE movid = ?");

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

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

        $targetdir = "./pics/";
        $targetfile = $targetdir . basename($image);
        $uploadOK = true;
        $picturetype = strtolower(pathinfo($targetfile, PATHINFO_EXTENSION));

        $check = getimagesize($tmp);
        if ($check === false) {
            $_SESSION['error'] = "پرونده انتخاب شده عکس نیست";
            $uploadOK = false;
        }

        if (file_exists($targetfile)) {
            $_SESSION['error'] = "پرونده‌ای با همین نام وجود دارد";
            $uploadOK = false;
        }

        if ($_FILES['movpicture']['size'] > 500 * 1024) {
            $_SESSION['error'] = "حجم فایل بیش از ۵۰۰ کیلوبایت است";
            $uploadOK = false;
        }

        if (!in_array($picturetype, ['jpg', 'jpeg', 'png'])) {
            $_SESSION['error'] = "فقط پسوندهای JPG, JPEG, PNG مجاز هستند";
            $uploadOK = false;
        }

        if (!$uploadOK) {
            header("Location: admin.php");
            exit();
        }

        if (!move_uploaded_file($tmp, $targetfile)) {
            $_SESSION['error'] = "آپلود فایل انجام نشد";
            header("Location: admin.php");
            exit();
        }
    } else {
        $image = $oldImage;
    }

    $stmt = mysqli_prepare($link, "UPDATE movies SET movname = ?, movdirector = ?, movdate = ?,
              movshowtime = ?, tickets = ?, movprice = ?,
              movpicture = ?, movabout = ? WHERE movid = ?");

    mysqli_stmt_bind_param($stmt, "ssssisssi", $name, $director, $date, $showtime, $tickets, $price, $image, $about, $id);
    
    $updateResult = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    if ($updateResult) {

        if (!empty($_FILES['movpicture']['name']) &&
            $oldImage !== $image &&
            file_exists("./pics/" . $oldImage)) {

            unlink("./pics/" . $oldImage);
        }

        $_SESSION['ok'] = "فیلم با موفقیت ویرایش شد";
        header("Location: admin.php");
        exit;

    } else {

        if (!empty($_FILES['movpicture']['name']) &&
            file_exists($targetfile)) {

            unlink($targetfile);
        }

        $_SESSION['error'] = "خطا در ویرایش فیلم";
        header("Location: admin.php");
        exit;
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
                include("adminSidebar.html");
            ?>
    </tr>
</table>
<?php include("footer.php"); ?>
