<?php
session_start();
include("header.php");
include("errorOKhandle.php");
 ?>
<form id="frm" action="logact.php" method="POST" dir="rtl">
    <p id="titr" style="text-align:center;font-size:1.4rem;font-weight:800;color:var(--gold-soft);margin-bottom:1.4rem;">🎟️ ورود به حساب کاربری</p>
    <table align="center">
        <tr>
            <td style="padding-top:16px"><label id="titr">نام کاربری:</label></td>
            <td><input id="inform" name="username" type="text" required></td>
        </tr>
        <tr>
            <td style="padding-top:16px"><label id="titr">رمزعبور:</label></td>
            <td><input id="inform" name="pass" type="password" required></td>
        </tr>
        <tr>
            <td colspan="2" align="center" style="padding-top:20px">
                <button style="cursor: pointer;" id="btn">ورود</button>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" style="padding-top:20px">
                <label id="titr">اکانت ندارید؟</label><a href="register.php"><label id="titr">
                    ثبت‌نام</label></a>
            </td>
        </tr>
    </table>
</form>
<?php include("footer.php"); ?>
