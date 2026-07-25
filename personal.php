<?php
session_start();
include("header.php");
if (isset($_SESSION['error'])){ ?>
    <p align="center" id="btn"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php }
if (isset($_SESSION['ok'])) { ?>
    <p align="center" id="ok"><?php echo $_SESSION['ok']; unset($_SESSION['ok']); ?></p>
<?php } ?>
<table align="center" width="100%" class="layout-row">
    <tr>
        <td>
<form action="editpersonal.php" method="POST">
 <table id="user" align="center" style="margin-bottom:30px">
    <tr>
        <td>
        <input id="inform" name="id" type="text" value="<?php echo $_SESSION['id']?>" readonly
        style="color:lightgray;"/>
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:30px;">:آیدی</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="namefamily" type="text" value="<?php echo $_SESSION['namefamily']?>"/>
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:30px;">:نام و نام خانوادگی</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="username" type="text" value="<?php echo $_SESSION['username']?>"/>
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">:نام کاربری</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="pass" type="text" value="<?php echo $_SESSION['pass']?>"/>
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">:رمزعبور</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="email"  type="email" value="<?php echo $_SESSION['email']?>"/>
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">:ایمیل</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="phone" type="text" value="<?php echo $_SESSION['phone']?>"/>
        </td>
        <td style="padding-top:15px">
        <label id="titr" style="padding-right:40px">:شماره موبایل</label>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center" style="padding-top:20px;padding-bottom:10px">
            <button style="cursor: pointer;" id="btn">ثبت تغییرات</button>
        </td>
    </tr>
</table>
</form>
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
