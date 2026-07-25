<?php
session_start();
include("header.php");
?>
<table align="center" width="100%" class="layout-row">
    <tr>
        <td>
<form action="adminact.php" method="post" enctype="multipart/form-data" >
<table id="user" align="center" style="margin-bottom:20px;">
    <tr>
        <td>
        <input id="inform" name="movname" type="text" />
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px;">:نام فیلم</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="movdirector" type="text" />
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">:کارگردان فیلم</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="movdate"  type="text" />
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">:تاریخ پخش</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="movshowtime" type="text" />
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">:سانس پخش فیلم</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="tickets" type="text" />
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">: تعداد بلیط</label>
        </td>
    </tr>
    <tr>
        <td>
        <input id="inform" name="movprice" type="text" />
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">:قیمت بلیط فیلم</label>
        </td>
    </tr>
    <tr>
    <td colspan="2">
        <input name="movpicture" type="file" />
        <label id="titr" style="padding-right:15px">:تصویر فیلم</label>
        </td>
    </tr>
    <tr>
        <td>
        <textarea id="inform" name="movabout" cols="22" rows="5"></textarea>
        </td>
        <td style="padding-top:15px;">
        <label id="titr" style="padding-right:40px">:درباره فیلم</label>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center" style="padding-top:20px;padding-bottom:10px">
            <button style="cursor: pointer;" id="btn">ثبت</button>
        </td>
    </tr>
</table>
</form>
        </td>
        <?php if($_SESSION['usertype'] == "admin"): ?>
        <td>
        <table id="sidebar" align="right">
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
