<?php  $this->load->view("basic/top");  ?>

<!--頁面CSS-->
<script src='https://www.google.com/recaptcha/api.js'></script>
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/separate/pages/login.css'); ?>">
<style type="text/css" media="screen">
    body{
        font-family:Microsoft JhengHei;
    }
    option{
        font-family:Microsoft JhengHei;
    }
</style>
<!--頁面CSS-->

</head>
<body class="with-side-menu" style="height: 100%;">
    <?php  $this->load->view("basic/jsLoad");  ?>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form class="sign-box" id="login">
                    <div class="sign-avatar">
                        <img src="<?php echo base_url('dist/img/system/loginLogo.png'); ?>" alt="">
                    </div>
                    <header class="sign-title">登入系統</header>
                    <div class="form-group">
                        <input type="text" class="form-control" id="account" placeholder="帳號"/>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" placeholder="密碼"/>
                    </div>
                    <div class="form-group ">
                        <div class="g-recaptcha" data-sitekey=""></div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox float-left">
                            <input type="checkbox" value="1" id="signed-in" name="signed-in"/>
                            <label for="signed-in">保持登入狀態</label>
                        </div>
                        <div class="float-right reset">
                            <a href="recover">忘記密碼？</a>
                        </div>
                    </div>
                    <button class="btn btn-rounded">登入</button>
                    <p class="sign-note">沒有帳號？ <a href="signup">註冊</a></p>
                    <!--<button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>-->
                </form>
            </div>
        </div>
    </div><!--.page-center-->


    <script>

        //我不是機器人認證ajax傳送呼叫
        function VerifyReCaptcha(GResponse)
        {
            $.ajax(
            {
                url:<?php echo "\"".base_url('login/recaptcha')."\""; ?>,
                type : "POST",
                dataType: 'html',
                async: true,
                data:
                {
                    reCaptchaResponse: GResponse
                },
                success:function(msg)
                {
                    switch(msg)
                    {
                        case 'OK':
                            //在這裡輸入驗證成功後要呼叫的函數
                            break;
                        case 'ERROR':
                            //alert('驗證失敗！請再試一次！');
                            break;
                        break;
                    }
                },
                error:function(xhr){
                    //alert('發生未預期的錯誤！請再試一次！');
                },
            }
            );
        }

        //每秒確認是否加載成功
        $(document).ready(function(){   
            var IntervalID = setInterval(function(){
                if($("#g-recaptcha-response").val()!='')
                {
                    VerifyReCaptcha($("#g-recaptcha-response").val());
                    clearInterval(IntervalID);
                }
            },1000);//end setInterval
        });     

        //點下登入實行檢查
        $("#login").submit(function(e){
            if($("#account").val() == '' || $("#password").val() == ''){
                e.preventDefault();
                swal({
                    title: "注意",
                    text: "請輸入帳號及密碼",
                    icon: "warning",
                    animation: "slide-from-top"
                });
            }else if($("#g-recaptcha-response").val()==''){
                e.preventDefault();
                swal({
                    title: "注意",
                    text: "請點擊「我不是機器人」按鈕",
                    icon: "warning",
                    animation: "slide-from-top"
                });
            }else{
                e.preventDefault();
                login = $('input[name=signed-in]:checked').val() == null? 0:1;
                $.ajax({
                    url: '<?php  echo base_url('login/signin') ?>',
                    dataType: 'text',
                    type:'post',
                    data: {account : $('#account').val(),
                           password : $('#password').val(),
                           login :login,
                           token : '<?php echo $loginToken ?>'},
                    error:function(){
                        swal("錯誤", "連線失敗，請重新送出", "error");
                    },
                    success: function(data){
                        if(data == 0){
                            swal("錯誤", "帳號或密碼錯誤", "error");
                        }else if (data == 1){
                            document.location.href='<?php  echo base_url('home') ?>';
                        }else if (data == 2){
                            swal("帳號鎖定", "請聯絡系統管理員", "error");
                        }
                    }
                });
            }
        });



        //頁面排版
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function(){
                setTimeout(function(){
                    $('.page-center').matchHeight({ remove: true });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                },100);
            });
        });
    </script>
</body>
</html>