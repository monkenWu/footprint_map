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
    <script src="<?php echo base_url('dist/build/js/lib/html5-form-validation/jquery.validation.min.js'); ?>
"></script>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form class="sign-box" id="form-recover_v1" name="form-recover_v1">
                    <div class="sign-avatar">
                        <img src="<?php echo base_url('dist/img/system/loginLogo.jpg'); ?>" alt="">
                    </div>
                    <header class="sign-title">忘記密碼</header>
                    <header class="sign-title"><h6>吼，忘記密碼了齁</h6></header>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input placeholder="輸入註冊時的信箱"
                                   id="email"
                                   class="form-control"
                                   name="email"
                                   type="text" data-validation="[EMAIL]"
                                   data-validation-message="請輸入正確的信箱">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="g-recaptcha" data-sitekey="6Ldx9lIUAAAAAJYF5TjpaB5DdAPrUlrTPfVNkeQA"></div>
                    </div>
                    <button type="submit" class="btn btn-rounded" id="submitMail">確定</button>
                    <div id="loadingButton" style="display:none"><img style="margin:auto;display:block"  src="<?php echo base_url('dist/img/system/button-loader.gif') ?>"  height="50"></div>
                </form>
                <?php  $this->load->view("basic/recover/number");  ?>
                <?php  $this->load->view("basic/recover/password");  ?>
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
                    alert('發生未預期的錯誤！請再試一次！');
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
        $('#form-recover_v1').validate({
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
                $('#submitMail').hide();
                $('#loadingButton').show();
                 $.ajax({
                    url: '<?php  echo base_url('recover/email') ?>',
                    dataType: 'text',
                    type:'post',
                    data: {email : $('#email').val(),
                            type : 0},
                    error:function(){
                        swal("錯誤", "連線失敗，請重新送出", "error");
                        $('#submitMail').show();
                        $('#loadingButton').hide();
                    },
                    success: function(data){
                        if(data == '0'){
                            swal({
                              title: "提示",
                              text: "已發出過請求，是否直接輸入驗證碼？否則開始新的尋回密碼動作。",
                              icon: "warning",
                              buttons: true,
                              buttons: ["NO", "OK"],
                              dangerMode: true,
                            })
                            .then((thisSwal) => {
                              if (thisSwal) {
                                $.ajax({
                                    url: '<?php  echo base_url('recover/email') ?>',
                                    dataType: 'text',
                                    type:'post',
                                    data: {email : $('#email').val(),
                                            type : 1},
                                    error:function(){
                                        swal("錯誤", "連線失敗，請重新送出", "error");
                                    },
                                    success: function(data){
                                        $('#submitMail').show();
                                        $('#loadingButton').hide();
                                        if(data == 0){
                                            swal("錯誤", "資料有誤，請重新送出", "error");
                                        }else if (data == 1){
                                            swal("發送成功", "請前往信箱收信，再將認證碼填進輸入框中", "success").then((value) => {
                                                $('#form-recover_v1').hide();
                                                $('#form-recover_v2').show();
                                            });
                                        }else if(data ==3){
                                            swal("錯誤", "這個email不存在，請確認是否輸入正確", "error");
                                        }
                                    }
                                });
                              } else {
                                    $('#form-recover_v1').hide();
                                    $('#form-recover_v2').show();
                              }
                            });
                        }else if (data == 1){
                            $('#submitMail').show();
                            $('#loadingButton').hide();
                            swal("發送成功", "請前往信箱收信，再將認證碼填進輸入框中", "success").then((value) => {
                                $('#form-recover_v1').hide();
                                $('#form-recover_v2').show();
                            });
                        }else if (data == 2){
                            swal("發送失敗", "請確認您的信箱號碼重新再發送一次", "error");
                        }else if(data ==3){
                            swal("錯誤", "這個email不存在，請確認是否輸入正確", "error");
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>