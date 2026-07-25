<?php 
session_start();
include("header.php");
$movid = $_GET['movid'];
$query = "SELECT * FROM movies WHERE movid = $movid";
$result = mysqli_query($link,$query);
$row = mysqli_fetch_array($result);
$id = $_SESSION['id'];
$query2 = "SELECT * FROM users WHERE id = $id";
$result2 = mysqli_query($link,$query2);
$row2 = mysqli_fetch_array($result2);
if (isset($_SESSION['error'])){ ?>
    <p align="center" id="btn"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php }
if(isset($_SESSION['ok'])){ ?>
    <p align="center" id="ok"><?php echo $_SESSION['ok']; unset($_SESSION['ok']);?></p>
<?php } ?>
    <form action="buyact.php?id=<?php echo($row2['id'] . '&movid=' . $row['movid']);?>"
     method="POST">
<table id="movbuy" align="center" dir="rtl" style="margin-bottom:40px;">
    <tr>
        <td style="padding-top:20px">
        <img id="movieab" src="./pics/<?php echo($row['movpicture']); ?>" width="300px"
        alt="<?php echo($row['movname']);?>" /> 
        </td>
        <td style="padding-top:20px;">
            <label id="titr">نام فیلم: <?php echo($row['movname']); ?></label><br/><br/>
            <label id="titr">تاریخ پخش: <?php echo($row['movdate']); ?></label><br/><br/>
            <label id="titr">سانس: <?php echo($row['movshowtime']); ?></label><br/><br/>
            <label id="titr">قیمت بلیط: <?php echo($row['movprice']); ?> تومان</label><br/><br/>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top:50px;">
            <label id="titr">خریدار: <?php echo($row2['namefamily']); ?></label><br/><br/>
            <label id="titr">شماره موبایل : <?php echo($row2['phone']); ?></label><br/><br/>
            <label id="titr">ایمیل: <?php echo($row2['email']); ?></label><br/><br/>
            <a id="Abtn" href="seats.php?movid=<?php echo($movid . "&id=" . $id);
             ?>">رزرو صندلی</a>
            <input id="srchbar" name="seat" type="text" placeholder="<?php
            if(isset($_GET['seatscount']) && !empty($_GET['seatscount'])){
                 echo('صندلی های انتخاب شده:' . $_GET['seatscount']);} else{
                    echo("صندلی انتخاب نشده");} ?>" readonly />
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top:50px;">
            <label id="titr">تعداد بلیط درخواستی :</label>&nbsp;&nbsp;
            <input id="informbuy" name="tick" type="text" />
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top:50px;padding-bottom:100px">
            <button id="btn" style="cursor: pointer;">ثبت خرید</button>
        </td>
    </tr>
</table>
</form>
<?php
include("footer.php");
?>