<?php
session_start();
include("header.php");
include("errorOKhandle.php"); 
?>
<table align="center" width="100%" class="layout-row">
    <tr>
        <td>
<form action="editpersonal.php" method="POST">
 <table id="user" align="center" style="margin-bottom:30px">
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
            <?php
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == "admin") {
                include("adminSidebar.html");
            }
            ?>
    </tr>
 </table>
<?php
include("footer.php");
?>
