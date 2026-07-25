<?php
session_start();
include("header.php");
if(isset($_POST['movname']) && !empty($_POST['movname'])){
$movname = $_POST['movname'];
$query = "SELECT * FROM movies WHERE movname = '$movname'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result);
if($row){
?>
<table id="body" align="center" cellspacing="0">
<tr>
    <td align="center" width="33%">
        <a style="display: inline-block;position: relative;width:100%;"
        href="moviep.php?movid=<?php echo($row['movid']);?>">
    <img id="movie" src="pics/<?php echo $row['movpicture']; ?>" 
     alt="<?php echo $row['movname']; ?>">
     <span id="overlay">:کارگردان<br/><?php echo($row['movdirector']);?></span></a><br>
        <p id="titr" style="font-size:1.05rem;font-weight:700;margin-top:.3rem;"><?php echo $row['movname'] ?></p>
        <p id="lbl" style="color:var(--gold-soft);font-weight:600;"><?php echo number_format($row['movprice']); ?> تومان</p>
    </td>
</tr>
</table>
<?php }
else{
    $_SESSION['error'] = "فیلمی با این نام وجود ندارد";
    header("location: main-cinemablit.php");
    exit();
}
}
else{
    $_SESSION['error'] = "نام یک فیلم را وارد کنید";
    header("location: main-cinemablit.php");
    exit();
}
?>
<?php
include("footer.php");
?>