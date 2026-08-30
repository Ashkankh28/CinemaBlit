<?php
session_start();
if (isset($_GET['notice']) && $_GET['notice'] === 'buy') {
    $_SESSION['error'] = "برای خرید بلیط ابتدا وارد شوید";
}
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
            <td style="position:relative;">
            <input id="inform" name="pass" type="password"/>
            <button type="button" onclick="
                var inp = this.previousElementSibling;
                if (inp.type === 'password') {
                    inp.type = 'text';
                    this.textContent = '🙈';
                } else {
                    inp.type = 'password';
                    this.textContent = '👁️';
                }
            " style="cursor:pointer;background:none;border:none;position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:16px;">👁️</button>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" style="padding-top:20px;">
                <button style="cursor: pointer;" id="btn">ورود</button>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" style="padding-top:20px">
                <label id="titr">اکانت ندارید؟</label><a href="register.php"><label id="titr" style="color:lightblue">
                    ثبت‌نام</label></a>
            </td>
        </tr>
    </table>
</form>
<?php include("footer.php"); ?>
