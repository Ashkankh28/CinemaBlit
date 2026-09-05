<?php
session_start();

if(!isset($_SESSION['usertype']) || ($_SESSION['usertype'] != "admin")){
    header("Location: 404page.php");
    exit();
}

include("header.php");
include("errorOKhandle.php");
?>
<table align="center" width="100%" class="layout-row">
    <tr>
        <td>    
            <table id="admin" align="center" dir="rtl" border="1px" style="border-collapse: separate;overflow: hidden;margin-bottom:20px">
                <tr>
                    <td align="center"><label id="lbl">آیدی</label></td>
                    <td align="center"><label id="lbl">نام و نام خانوادگی</label></td>
                    <td align="center"><label id="lbl">نام کاربری</label></td>
                    <td align="center"><label id="lbl">ایمیل</label></td>
                    <td align="center"><label id="lbl">شماره موبایل</label></td>
                    <td align="center"><label id="lbl">دسترسی</label></td>
                    <td align="center"><label id="lbl">ابزار</label></td>
                    <td align="center"><label id="lbl">ادمین</label></td>
                </tr>
                <?php
                $query = "SELECT * FROM users";
                $result = mysqli_query($link,$query);
                while($row = mysqli_fetch_array($result)){?>
                <tr>
                    <td align="center"><label id="lbl"><?php echo $row['id']; ?></label></td>
                    <td align="center"><label id="lbl"><?php echo $row['namefamily']; ?></label></td>
                    <td align="center"><label id="lbl"><?php echo $row['username']; ?></label></td>
                    <td align="center"><label id="lbl"><?php echo $row['email']; ?></label></td>
                    <td align="center"><label id="lbl"><?php echo $row['phone']; ?></label></td>
                    <td align="center"><label id="lbl"><?php if($row['mtype']==1){echo("مدیر");} else{echo("کاربر عادی");}?></label></td>
                    <td align="center"><label id="lbl"><a href="deluser.php?id=<?php echo($row['id']);?>">حذف</a></label></td>
                    <td align="center">
                    <input type="checkbox"class="admin-checkbox"
                            data-user-id="<?php echo $row['id']; ?>"
                            <?php echo ($row['mtype'] == 1) ? 'checked' : ''; ?>>
                    </td>

                </tr>
                <?php } ?>
            </table>
        </td>
            <?php
            include("adminSidebar.html");
            ?>
    </tr>
    </table>

    <script>    
        document.querySelectorAll('.admin-checkbox').forEach(function(checkbox) {

            checkbox.addEventListener('change', function() {

                let userId = this.dataset.userId;
                let mtype = this.checked ? 1 : 0;

                fetch('adminupdate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + encodeURIComponent(userId) +
                        '&mtype=' + encodeURIComponent(mtype)
                })
                .then(response => response.text())
                .then(data => {

                    if (data.trim() === 'success') {
                        console.log('وضعیت کاربر با موفقیت تغییر کرد');
                    } else {
                        alert('خطا در تغییر وضعیت کاربر');
                    }

                })
                .catch(error => {
                    console.error(error);
                    alert('خطا در ارتباط با سرور');
                });

            });

        });
    </script>

<?php
include("footer.php");
?>
