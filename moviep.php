<?php
session_start();
include("header.php");
$movid = $_GET['movid'];
$query = "SELECT * FROM movies WHERE movid = $movid ";
$result = mysqli_query($link,$query);
$row = mysqli_fetch_array($result);
?>

<table id="moviep" align="center">
    <tr>
        <td dir="rtl" style="padding-top:20px;vertical-align:top;">
            <label id="titr" style="font-size:1.5rem;font-weight:800;color:var(--gold-soft);">فیلم <?php echo($row['movname']);?></label><br/><br/>
            <label id="titr">🎬 کارگردان: <?php echo($row['movdirector']);?></label><br/><br/>
            <label id="titr">
                درباره فیلم:<br/><?php echo($row['movabout'] . "...");?></label><br/><br/>
            <label id="titr" style="font-weight:700;">💳 قیمت بلیط: <?php echo number_format($row['movprice']);?> تومان</label><br/><br/>
        </td>
        <td style="vertical-align:top;">
            <img id="movieab" src="./pics/<?php echo($row['movpicture']); ?>" width="300px"
            alt="<?php echo($row['movname']);?>" />
        </td>
    </tr>
    <tr>
        <td dir="rtl" style="padding-bottom:20px" colspan="2" >
            <table id="box" dir="rtl" width="100%" style="margin-right:0;">
              <hd style="margin-right:0;">📅 لیست برنامه‌ها</hd>
                <tr>
                    <td align="right">
            <label id="lbl"><?php echo($row['movdate']);?> &nbsp;|&nbsp;
                <?php echo($row['movshowtime']);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;تعداد بلیط باقی‌مانده:
                    <?php echo($row['tickets']); ?></label>
                    </td>
                    <td align="left">
                    <?php if($_SESSION['loginstate']==true && $_SESSION['usertype']=="admin"){
                        $disabled = ($_SESSION['usertype'] == "admin") ? 'disabled' : '';
                        $disabledlook = ($_SESSION['usertype'] == "admin") ? 
                        "cursor: default;color:lightgray;" : '';
                    ?>
                        <button id="btn" style="cursor: pointer;
                        <?= $disabledlook ?>" <?= $disabled ?>>خرید</button><?php } 
                        elseif($_SESSION['loginstate']==true){ ?>
                        <button id="btn" onclick="location.href='buy.php?movid=<?php
                        echo($row['movid']); ?>'" style="cursor: pointer;">
                            خرید</button> 
                        <?php } 
                        else{ ?>
                            <button id="btn" onclick="location.href='login.php'" 
                            style="cursor: pointer;">خرید</button>
                            <?php $_SESSION['error'] = "برای خرید بلیط ابتدا وارد شوید"; } ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php
include("footer.php");
?>
