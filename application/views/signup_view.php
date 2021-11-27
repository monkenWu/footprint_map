<?php  $this->load->view("basic/top");  ?>

<!--頁面CSS-->
<script src='https://www.google.com/recaptcha/api.js'></script>
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/separate/pages/login.css'); ?>">
<style type="text/css" media="screen">
    body{
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
                <form class="sign-box" id="form-signup_v1" name="form-signup_v1">
                    <div class="sign-avatar">
                        <img src="<?php echo base_url('dist/img/system/loginLogo.png'); ?>" alt="">
                    </div>
                    <header class="sign-title">會員註冊</header>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input placeholder="帳號"
                                   id="account"
                                   class="form-control"
                                   name="account"
                                   type="text" data-validation="[L>=6, L<=18, MIXED]"
                                   data-validation-message="帳號必須介於6到18個字符之間。不允許特殊字符。"
                                   >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input placeholder="密碼"
                                   id="password"
                                   class="form-control"
                                   name="password"
                                   type="password" data-validation="[L>=6, L<=20, MIXED]"
                                   data-validation-message="密碼必須介於6到20個字符之間。不允許特殊字符。">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input placeholder="重複密碼"
                                   id="password-confirm"
                                   class="form-control"
                                   name="password-confirm"
                                   type="password" data-validation="[V==password]"
                                   data-validation-message="必須與密碼相符">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input placeholder="信箱"
                                   id="email"
                                   class="form-control"
                                   name="email"
                                   type="text" data-validation="[EMAIL]"
                                   data-validation-message="請輸入正確的信箱">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input placeholder="暱稱"
                                   id="username"
                                   class="form-control"
                                   name="username"
                                   type="text"
                                   data-validation-regex="/^[\w\s\u4e00-\u9fa5]{2,10}$/"
                                   data-validation-regex-message="暱稱必須介於2到10個字符之間。不允許特殊字符。">
                        </div>
                    </div>
                    <div class="form-group form-group-radios">
                        <label class="form-label" id="signup_v2-gender">
                            性別 <span class="color-red">*</span>
                        </label>
                        <div class="radio">
                            <input id="male"
                                   name="gender"
                                   data-validation="[NOTEMPTY]"
                                   data-validation-group="gender"
                                   data-validation-message="請選擇一種性別"
                                   type="radio"
                                   value="1">
                            <label for="male">男</label>
                            <input id="female"
                                   name="gender"
                                   data-validation-group="gender"
                                   type="radio"
                                   value="0">
                            <label for="female">女</label>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="g-recaptcha" data-sitekey="6Ldx9lIUAAAAAJYF5TjpaB5DdAPrUlrTPfVNkeQA"></div>
                    </div>
                    <button type="submit" class="btn btn-rounded">註冊</button>
                </form>
            </div>
        </div>
    </div><!--.page-center-->
    <script src="<?php echo base_url('dist/build/js/lib/html5-form-validation/jquery.validation.min.js'); ?>
"></script>
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

        //初始化驗證
        $('#form-signup_v1').validate({
            submit: {
                settings: {
                    inputContainer: '.form-group',
                    errorListClass: 'form-tooltip-error'
                },
                callback: {
                    onSubmit : function (node, formData) {
                        submitRecaptcha(node, formData);
                    }
                }    
            }
        });

        //送出動作
        function submitRecaptcha(node, formData){
            if($("#g-recaptcha-response").val()==''){
                swal({
                    title: "注意",
                    text: "請點擊「我不是機器人」按鈕",
                    icon: "warning",
                    animation: "slide-from-top"
                });
            }else{
                 $.ajax({
                    url: '<?php  echo base_url('signup/add') ?>',
                    dataType: 'text',
                    type:'post',
                    data: {account : $('#account').val(),
                           password : $('#password').val(),
                           username : $('#username').val(),
                           email : $('#email').val(),
                           sex : $('input[name=gender]:checked').val(),
                           token : '<?php echo $signupToken ?>'},
                    error:function(){
                        swal("錯誤", "連線失敗，請重新送出", "error");
                    },
                    success: function(data){
                        if(data == '0'){
                            swal("錯誤", "資料有誤，請重新再試", "error");
                        }else if (data == '1'){
                            swal("註冊成功", "即將轉跳登入頁面", "success").then((value) => {
                              document.location.href='<?php  echo base_url('login') ?>';
                            });
                        }else if (data == '2'){
                            swal("錯誤", "已有相同帳號，請重新輸入", "error");
                        }else if (data == '3'){
                            swal("錯誤", "此信箱已使用過", "error");
                        }
                    }
                });
            }
          }
        
    </script>
</body>
</html>