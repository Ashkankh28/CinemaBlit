<?php
session_start();
 include("header.php");
include("errorOKhandle.php");
?>
<form action="regact.php" method="POST">
<table id="user" align="center" style="margin-bottom:30px">
    <tr>
        <td>
        <input id="inform" name="namefamily" type="text" />
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:30px;">:نام و نام خانوادگی</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="username" type="text" />
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">:نام کاربری</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="pass" type="password" />
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">:رمزعبور</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="email"  type="email" />
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">:ایمیل</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="phone" type="text" />
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">:شماره موبایل</label>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center" style="padding-top:25px;padding-bottom:15px">
            <button style="cursor: pointer;" id="btn">ثبت</button>
        </td>
    </tr>
        <tr>
            <td colspan="2" align="center" style="padding-bottom:20px">
                <label id="titr">از قبل اکانت دارید؟</label><a href="login.php"><label id="titr" style="color:lightblue">
                    ورود</label></a>
            </td>
        </tr>
</table>
</form>
<?php
include("footer.php");
?>