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
<table align="center" width="100%" class="layout-row">
    <tr>
        <td>
    <table id="admin" align="center" dir="rtl" border="1px" style="border-collapse: separate;overflow: hidden;margin-bottom:20px">
        <tr>
            <td align="center"><label id="lbl">آیدی</label></td>
            <td align="center"><label id="lbl">نام و نام خانوادگی</label></td>
            <td align="center"><label id="lbl">نام کاربری</label></td>
            <td align="center"><label id="lbl">رمزعبور</label></td>
            <td align="center"><label id="lbl">ایمیل</label></td>
            <td align="center"><label id="lbl">شماره موبایل</label></td>
            <td align="center"><label id="lbl">دسترسی</label></td>
            <td align="center"><label id="lbl">ابزار</label></td>
        </tr>
        <?php
        $query = "SELECT * FROM users";
        $result = mysqli_query($link,$query);
        while($row = mysqli_fetch_array($result)){?>
        <tr>
            <td align="center"><label id="lbl"><?php echo $row['id']; ?></label></td>
            <td align="center"><label id="lbl"><?php echo $row['namefamily']; ?></label></td>
            <td align="center"><label id="lbl"><?php echo $row['username']; ?></label></td>
            <td align="center"><label id="lbl"><?php echo $row['pass']; ?></label></td>
            <td align="center"><label id="lbl"><?php echo $row['email']; ?></label></td>
            <td align="center"><label id="lbl"><?php echo $row['phone']; ?></label></td>
            <td align="center"><label id="lbl"><?php if($row['mtype']==1){echo("مدیر");} else{echo("کاربر عادی");}?></label></td>
            <td align="center"><label id="lbl"><a href="deluser.php?id=<?php echo($row['id']);?>">حذف</a></label></td>
        </tr>
        <?php } ?>
    </table>
        </td>
        <?php if($_SESSION['usertype'] == "admin"): ?>
        <td>
        <table align="right" id="sidebar">
            <tr>
                <td>
                    <button id="btn" style="cursor: pointer;"
                    onclick="window.location.href='adminuser.php'">مدیریت کاربران</button>
                </td>
            </tr>
            <tr>
                <td>
                    <button id="btn" style="cursor: pointer;"
                    onclick="window.location.href='addmov.php'">افزودن فیلم</button>
                </td>
            </tr>
            <tr>
                <td>
                    <button id="btn" style="cursor: pointer;"
                    onclick="window.location.href='admin.php'">مدیریت فیلم ها</button>
                </td>
            </tr>
            <tr>
                <td>
                    <button id="btn" style="cursor: pointer;"
                    onclick="window.location.href='orders.php'">مدیریت سفارشات</button>
                </td>
            </tr>
        </table>
        </td>
        <?php endif; ?>
    </tr>
    </table>
<?php
include("footer.php");
?>
