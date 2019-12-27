<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>สูตรเฮียบอล</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style_main.css">
</head>
<body>
    <div class="container">
        <div class="wrapper" style="height: 500px">
            <div class="panel_promotion">
                <p>Promotion</p>
            </div>

            <?php
            if(isset($_SESSION['bacara_logined_user'])) { 
                $loginedUser = $_SESSION['bacara_logined_user'];
                $userId = $loginedUser['user_id'];
                $fullName = $loginedUser['full_name'];
            ?>
                <div id="panel_logined">
                    <div class="input">
                        <span><?=$fullName?></span>
                    </div>
                    <div class="input">
                        <span class="credit_num">
                            <?php if(isset($_SESSION['bacara_user_credit'])) { 
                                $userCredit = $_SESSION['bacara_user_credit']; ?>
                                <?=$userCredit['credit']?>
                            <?php } else { ?>
                                0
                            <?php } ?>
                        </span>
                    </div>
                    <div class="buttons">
                        <div class="button register">
                            <input name="logout" id="logout" type="button" 
                            onclick="window.location='logout.php'" value="ออกจากระบบ" />
                        </div>
                    </div>
                    <?php if(isset($_SESSION['bacara_user_credit'])) { 
                        $userCredit = $_SESSION['bacara_user_credit']; ?>
                        <input type="hidden" id="credit" value="<?=$userCredit['credit']?>" />
                    <?php } else { ?>
                        <input type="hidden" id="credit" value="0" />
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div id="panel_login">
                    <form name="form1" id="form1" method="post" action="" onsubmit="return onSubmit()">
                        <div class="input">
                            <input name="username" id="username" type="text" placeholder="UserName" required/>
                        </div>
                        <div class="input">
                            <input name="password" id="password" type="password" placeholder="Password" required/>
                        </div>
                        <div class="buttons">
                            <div class="button register">
                                <input name="register" id="register" type="button" onclick="window.location='register.php'" value="สมัครสมาชิก" />
                            </div>
                            <div class="button login">
                                <input name="login" id="login" type="submit" value="เข้าสู่ระบบ" />
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>

            <?php if(isset($_SESSION['bacara_logined_user'])) { ?>
                <div class="resultChipPanel">
                    <div id="main_body_col1_player"></div>
                    <div id="main_body_col1_tie"></div>
                    <div id="main_body_col1_banker"></div>
                    <div id="result_player"></div>
                    <div id="result_banker"></div>
                    <span>&nbsp;</span>
                </div>

                <div id="panel_table">
                    <div class="panel_table_in">
                        <table cellspacing="0" border="0" cellpadding="0">
                            <tbody>
                            <?php 
                                for($row=0;$row<10;$row++) { ?>
                                    <tr>
                                    <?php for($col=0;$col<16;$col++) { ?>
                                        <td id="<?=$row+1?>-<?=$col+1?>"></td>
                                    <?php } ?>
                                    </tr>
                                <?php }
                            ?>
                        </tbody></table>
                    </div>

                    <div class="btn_back" onclick="location.reload();"></div>
                    <div class="panel_control">
                        <div class="btn_player" id="clkPlayer"></div>
                        <div class="btn_tie" id="clkTie"></div>
                        <div class="btn_banker" id="clkBanker"></div>
                    </div>
                    <div class="btn_clear" onclick="location.reload();"></div>
                </div>
            <?php }  ?>
        </div>
    </div>

    <div id="lds-spinner-template" style="display: none;">
        <div class="lds-spinner" style="width:100%;height:100%">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script defer src="/assets/js/ui_script.js"></script>
    <script defer src="/assets/js/control.js"></script>
    <script>
        function onSubmit() {
            var username = document.getElementById('username');
            var password = document.getElementById('password');
            if (username.value == "") {
                alert("กรุณากรอก Username");
                return false;
            }
            if (password.value == "") {
                alert("กรุณากรอก Password");
                return false;
            }

            $.post("./portal.php?login",
            $("#form1").serialize(),
            function(data){
                console.log(data);
                if(data==1){
                    window.location = "/";
                } else {
                    alert("Username หรือ Password ไม่ถูกต้อง");
                    username.value = "";
                    password.value = "";
                    username.focus();
                }
            });

            return false;
        }
    </script>
</body>

</html>