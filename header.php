<?php
$link = mysqli_connect("localhost", "root", "", "cinemablit");
if (mysqli_connect_errno()) {
    exit("خطا: " . mysqli_connect_error());
}
if (!isset($_SESSION['loginstate'])) {
    $_SESSION['loginstate'] = false;
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>سینمابلیط</title>
    <link href="style.css" rel="stylesheet">
    <link rel="icon" href="pics/logo.png">
    
</head>
<body>
    <table id="header">
        <tr>
            <td align="right" style="white-space:nowrap;">
                <img src="pics/cinemalogo.jpg" alt="لوگو" width="52" height="52"
                style="border-radius:12px;vertical-align:middle;margin-left:10px;">
                <span style="font-size:1.25rem;font-weight:800;color:var(--gold-soft);vertical-align:middle;">سینما بلیط</span>
            </td>
            <td align="left">
                <button id="btn" style="cursor: pointer;" onclick="window.location.href='main-cinemablit.php'">صفحه اصلی</button>
                <?php if (isset($_SESSION['loginstate']) && $_SESSION['loginstate'] === true): ?>
                    <button id="btn" style="cursor: pointer;" onclick="window.location.href='logout.php'">خروج از حساب</button>
                    <?php if ($_SESSION['usertype'] == "admin"): ?>
                    <button id="btn" style="cursor: pointer;" onclick="window.location.href='personal.php'">پنل مدیریت</button>
                    <?php  else : ?>
                        <button id="btn" style="cursor: pointer;" onclick="window.location.href='personal.php'">مشخصات من</button>
                        <?php endif; ?>
                    <?php if ($_SESSION['usertype'] == "normaluser"): ?>
                        <button id="btn" style="cursor: pointer;" onclick="window.location.href='tickcart.php'">سبد خرید</button>
                    <?php endif; ?>
                <?php else: ?>
                    <button id="btn" style="cursor: pointer;" onclick="window.location.href='login.php'">ورود</button>
                    <button id="btn" style="cursor: pointer;" onclick="window.location.href='register.php'">ثبت‌نام</button>
                <?php endif; ?>
                </td>
                <td align="left">
                <form action="search.php" method="POST" style="margin-bottom:13px;">
                    <input id="srchbar" name="movname" type="text" placeholder="...جستجوی فیلم" />
                    <button id="btn">جستجو</button>
                </form>
            </td>
        </tr>
    </table>
