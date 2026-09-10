<?php
session_start();
include("header.php");
if(isset($_GET['movid'])){
    $movid = $_GET['movid'];
}
else{
    $_SESSION['error'] = "خطایی در تشخیص فیلم پیش آمده! لطفا دوباره تلاش کنید";
    header("Location: main-cinemablit.php");
    exit;
}

$stmt = mysqli_prepare($link, "SELECT * FROM movies WHERE movid = ?");

mysqli_stmt_bind_param($stmt, "i", $movid);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);
?>

<table id="moviep" align="center">
    <tr>
        <td dir="rtl" style="padding-top:20px;vertical-align:top;">
            <label id="titr" style="font-size:1.5rem;font-weight:800;color:var(--gold-soft);">فیلم <?= e($row['movname']) ?></label><br/><br/>
            <label id="titr">🎬 کارگردان: <?= e($row['movdirector']) ?></label><br/><br/>
            <label id="titr">
                درباره فیلم:<br/><?= e($row['movabout'] . "...") ?></label><br/><br/>
            <label id="titr" style="font-weight:700;">💳 قیمت بلیط: <?= e(number_format($row['movprice'])) ?> تومان</label><br/><br/>
        </td>
        <td style="vertical-align:top;">
            <img id="movieab" src="./pics/<?= e($row['movpicture']) ?>" width="300px"
            alt="<?= e($row['movname']) ?>" />
        </td>
    </tr>
    <tr>
        <td dir="rtl" style="padding-bottom:20px" colspan="2" >
            <table id="box" dir="rtl" width="100%" style="margin-right:0;">
              <hd style="margin-right:0;">📅 لیست برنامه‌ها</hd>
                <tr>
                    <td align="right">
            <label id="lbl"><?= e($row['movdate']) ?> &nbsp;|&nbsp;
                <?= e($row['movshowtime']) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;تعداد بلیط باقی‌مانده:
                    <?= e($row['tickets']) ?></label>
                    </td>
                    <td align="left">
                    <?php if($_SESSION['loginstate']==true){ ?>
                        <button id="btn" onclick="location.href='buy.php?movid=<?=
                        e($row['movid']); ?>'" style="cursor: pointer;">
                            خرید</button> 
                        <?php 
                        }
                        else{ ?>
                            <button id="btn" onclick="location.href='login.php?notice=buy'" 
                            style="cursor: pointer;">خرید</button>
                            <?php } ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php
include("footer.php");
?>
