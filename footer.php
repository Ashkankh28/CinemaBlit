<table id="footer">
                <tr>
                    <td align="center">
                            <label id="titr"><a href="aboutus.php">درباره ما</a></label>
                    </td>
                    <td align="center">
                    <label id="titr"><a href="rules.php">قوانین و مقررات</a></label>
                    </td>
                    <td align="center">
                    <label id="titr"><a href="contactus.php">ارتباط با ما</a></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center" style="padding-top:0.5rem;">
                        <label id="lbl" style="opacity:.7;">© <?php echo date("Y"); ?> سینما بلیط — تمامی حقوق محفوظ است</label>
                    </td>
                </tr>
            </table>
        </body>
</html>
<?php
mysqli_close($link);
?>