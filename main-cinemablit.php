<?php
session_start();
include("header.php");
include("errorOKhandle.php");

$query = "SELECT * FROM movies";
$result = mysqli_query($link, $query);

?>
<table id="body" align="center" cellspacing="0">
<tr>
<?php
$counter = 0;
while($row = mysqli_fetch_array($result)) {
    if ($counter > 0 && $counter % 3 == 0) {
        echo '</tr><tr>';
    }
    ?>
    <td align="center" width="33%">
        <a style="display: inline-block;position: relative;width:100%;"
        href="moviep.php?movid=<?php echo($row['movid']);?>">
    <img id="movie" src="pics/<?php echo $row['movpicture']; ?>" 
     alt="<?php echo $row['movname']; ?>">
     <span id="overlay">:کارگردان<br/><?php echo($row['movdirector']);?></span></a><br>
        <p id="titr" style="font-size:1.05rem;font-weight:700;margin-top:.3rem;"><?php echo $row['movname'] ?></p>
        <p id="lbl" style="color:var(--gold-soft);font-weight:600;"><?php echo number_format($row['movprice']); ?> تومان</p>
    </td>
    <?php
    $counter++;
}?>
</tr>
</table>
<?php
include("footer.php");
?>
