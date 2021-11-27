<!DOCTYPE html>
<html>
<head>
    <title>Footprint-服務足跡</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="服務足跡,footprint,服務地圖">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,700,600,800,400'
        rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo base_url('dist/intro/') ?>css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url('dist/intro/') ?>css/style.css">
    <link href="<?php echo base_url('dist/img/system/loginLogo.png'); ?>" rel="apple-touch-icon" type="image/png" sizes="144x144">
    <link href="<?php echo base_url('dist/img/system/loginLogo.png'); ?>" rel="apple-touch-icon" type="image/png" sizes="114x114">
    <link href="<?php echo base_url('dist/img/system/loginLogo.png'); ?>" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="<?php echo base_url('dist/img/system/loginLogo.png'); ?>" rel="apple-touch-icon" type="image/png">
    <link href="<?php echo base_url('dist/img/system/loginLogo.png'); ?>" rel="icon" type="image/png">
    <link href="<?php echo base_url('dist/img/system/loginLogo.png'); ?>" rel="shortcut icon">

</head>
<body id="overflow" class="overflow">
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/zh_TW/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <!-- Your customer chat code -->
    <div class="fb-customerchat"
      attribution=setup_tool
      page_id="2133175466755213"
      theme_color="#67b868"
      logged_in_greeting="使用上遇到了困難嗎？"
      logged_out_greeting="使用上遇到了困難嗎？">
    </div>

    <div class="loader">
        <div class="load">
            <img src="<?php echo base_url('dist/img/system/loginLogo.png'); ?>" width="40" alt="load" />
            <div class="load-animation">
                <span class="load-item">
                    <img src="<?php echo base_url('dist/intro/') ?>img/load.png" alt="load" /></span> <span class="load-item load-item-revers">
                        <img src="<?php echo base_url('dist/intro/') ?>img/load.png" alt="load" /></span> <span class="load-item delay-200">
                            <img src="<?php echo base_url('dist/intro/') ?>img/load.png" alt="load" /></span>
            </div>
        </div>
    </div>
    <div class="overlay-nav">
        <header class="header clearfix">
            <div class="container">
                <a class="logo" href="#">
                    <img src="<?php echo base_url('dist/img/system/logo.png') ?>" width="200" alt="logo"/>
                </a>
                <nav class="nav clearfix">
                    <ul class="clearfix">
                        <li class="active"><a href="#">介紹</a></li>
                        <li><a href="<?php echo base_url('dist/firstFootprint.pdf')?>" target="_blank">使用說明</li>
                        <li><a href="<?php echo base_url('home') ?>" target="_blank">使用系統</a></li>
                    </ul>
                </nav>
                <div class="menu-button">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </header>
    </div>

    <div class="header-container-home header-home">
        <div class="swiper-container slider-home">
            <div class="swiper-wrapper">
                <div class="swiper-slide slide-home">
                    <img class="slide-img" src="<?php echo base_url('dist/intro/img/top1.jpg') ?> " alt="promo" />
                    <div class="container">
                        <div class="title-block title-block-home">
                            <h1 class="title">
                                是時候以 <span>更聰明的方法</span> 進行下一場服務！</h1>
                            <p class="sub-title">
                                Footprint-服務足跡，提供多樣化的檢索、交流與詳細的校園資訊供服務團隊使用！</p>
                        </div>
                        <img class="hidden-xs" src="<?php echo base_url('dist/intro/img/view1.png') ?>" width="900" alt="webapp" />
                    </div>
                </div>
                <div class="swiper-slide slide-home">
                    <img class="slide-img" src="<?php echo base_url('dist/intro/img/top2.jpg') ?>" alt="promo" />
                    <div class="container">
                        <div class="title-block title-block-home">
                            <h1 class="title">
                                不只桌面 <span>行動版本</span> 也幫你準備好了!</h1>
                            <p class="sub-title">
                                出門在外忘記帶電腦？打開手機，一樣可以迅速搜索、了解、比較欲服務地點的詳細資訊！</p>
                        </div>
                        <img class="hidden-xs" src="<?php echo base_url('dist/intro/img/view2.png') ?>" width="900" alt="webapp" />
                    </div>
                </div>
            </div>
        </div>
        <div class="pagination pagination-home">
        </div>
        <div class="container slider-menu-container">
            <div class="slider-menu">
                <a class="slider-menu-item active" href="#">桌面</a>
                <a class="slider-menu-item" href="#">行動</a>
            </div>
        </div>
    </div>

    <section class="section powerfull-section">
            <div class="container">
                <h2 class="section-title animate-fade">
                    創新的 <span>校園圖鑑</span>
                </h2>
                <p class="main-text animate-fade" style="padding-bottom: 1em">
                    使用政府OpenData建構出完整的校園資訊、學生資訊，服務團隊可以利用本服務搜索到符合條件的學校，讓服務資源可以精準的投注在中小學中。
                </p>
             </div>
             <div class="container">
                <div class="row">
                    <div class="col-sm-5 col-sm-offset-1">
                         <img class="img-fluid phone-white animate-left delay-400" style="width:100%" src="<?php echo base_url('dist/intro/img/product1.jpg') ?>" alt="white Responsive image"/>
                    </div>
                    <div class="col-sm-6">
                        <div class="powerfull-info">
                            <h3 class="animate-top">
                            你的服務專案與中小學的距離將不再遙遠。
                            </h3>

                            <p class="powerfull-info-text animate-top">
                            本系統提供
                            </p>
                            <ul class="list-info animate-top">
                                <li><span>免費 </span> 提供全國中小學的地圖檢索服務。</li>
                                <li><span>最新資訊 </span> 掌握最新的國中、小學校園資訊。</li>
                                <li><span>服務足跡 </span> 每次完成服務，都可以留下你的心得。</li>
                                <li><span>團體管理</span> 創建團隊、加入團隊，立刻開始你的服務歷程！</li>
                            </ul>
                        </div>
                     </div>
                </div>
            </div>
        </section>


    <section class="section section-offers">
        <div class="container">
            <h2 class="section-title animate-fade">
                擁有滿滿  <span>優點</span>
            </h2>
            <p class="main-text animate-fade">不管在任何裝置上都可以瀏覽使用。查閱學生訊息、校園周邊資訊，或者是服務團隊間的交流、服務評價，建立個人的服務足跡——Footprint都能做到。</p>
            <div class="row row-benefits">
                <div class="col-md-3 col-sm-6 col-benefits bounce-in delay-200">
                    <div class="benefits-icon"><i class="fas fa-search fa-9x" style="color:#56cc91"></i></div>
                    <h3 class="benefits-title">多樣搜索</h3>
                    <p class="benefits-text">擁有地區、關鍵字，屬性等搜索方式，依照不同的方案需求，找到符合條件的中小學！</p>
                </div>
                <div class="col-md-3 col-sm-6 col-benefits bounce-in delay-400">
                    <div class="benefits-icon"><i class="fas fa-sort-numeric-up fa-9x" style="color:#56cc91"></i></div>
                    <h3 class="benefits-title">比較學校</h3>
                    <p class="benefits-text">支援二到四所的校園進行同時比對，快速地找出最需要投注資源的中小學！</p>
                </div>
                <div class="col-md-3 col-sm-6 col-benefits bounce-in delay-600">
                    <div class="benefits-icon"><i class="fas fa-shoe-prints fa-7x" style="color:#56cc91"></i></div>
                    <h3 class="benefits-title">服務足跡</h3>
                    <p class="benefits-text">每次服務過後都可以留下評分、心得與記錄，供下一個團隊進行參考！</p>
                </div>
                <div class="col-md-3  col-sm-6 col-benefits bounce-in delay-800">
                    <div class="benefits-icon"><i class="fas fa-comments fa-7x" style="color:#56cc91"></i></div>
                    <h3 class="benefits-title">團隊交流</h3>
                    <p class="benefits-text">建立團隊、加入團隊，於每個服務足跡留下想法，參與不同服務的討論！</p>
                </div>
            </div>
            
        </div>
    </section>

    <section class="section benefits-section">
        <div class="container">
            <h2 class="section-title animate-fade">
                便利的 <span>行動介面</span>
            </h2>
            <p class="main-text animate-fade">
                Footprint-服務足跡採用流行的響應式網頁技術，不管於手機、平板、筆電，桌上電腦，都可以用不同的裝置顯示一樣的資訊，延續相同的使用體驗。
            </p>
            <div class="row benefits-row">
                <div class="col-sm-12 col-md-3">
                    <div class="benefits-list benefits-customization animate-left delay-400 benefits-list-left">
                        <h3 class="benefits-title">
                            多樣屬性
                        </h3>
                        <p class="benefits-text">
                            在校園搜索中，可以利用新住民數、原住民數，甚至是建物數量、校園坪數等等的方式量化搜索學校。
                        </p>
                    </div>
                    <div class="benefits-list benefits-drive animate-left delay-400 benefits-list-left">
                        <h3 class="benefits-title">
                            釘選學校
                        </h3>
                        <p class="benefits-text">
                            最多可同時釘選四所中意的校園，在系統中快速地切換查閱不同的校園資訊。
                        </p>
                    </div>
                </div>
                <div class="col-sm-6 text-center">
                    <img class="benefits-device-1 animate-left delay-400" style="width:60%" src="<?php echo base_url('dist/intro/img/product2.jpg') ?>" alt="device"/>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="benefits-list benefits-update animate-right delay-400 benefits-list-right">
                        <h3 class="benefits-title">
                            校園圖像
                        </h3>
                        <p class="benefits-text">
                            使用GoogleMapsAPI，提供豐富的圖資以及校園目前的影像資訊。 
                        </p>
                    </div>
                    <div class="benefits-list benefits-hosting animate-right delay-400 benefits-list-right">
                        <h3 class="benefits-title">
                            會員功能
                        </h3>
                        <p class="benefits-text">
                            會員擁有專屬的主頁，並且能夠使用足跡、討論、服務計數、評論計數......等等功能！
                        </p>
                    </div>
                </div>
            </div>

            <div class="btn-box btn-box_more">
                <a href="<?php echo base_url('home') ?>" target="_blank" class="button animate-top">立刻開始嶄新體驗</a>
            </div>

        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row row-ftr">
                <div class="col-sm-4 ftr-list-box  col-xs-6">
                    <h3 class="ftr-title">
                        合作單位
                    </h3>
                    <ul class="ftr-list">
                        <li><a href="http://activity.sao.stu.edu.tw/main.php" target="_blank">樹德科技大學課外活動暨服務學習組</a></li>
                    </ul>
                </div>
               <div class="col-sm-3 ftr-list-box col-xs-6">
                    <h3 class="ftr-title">
                        支援
                    </h3>
                    <ul class="ftr-list">
                        <li><a href="<?php echo base_url('dist/firstFootprint.pdf')?>" target="_blank">簡易使用說明</a>
                        <li><a href="<?php echo base_url('dist/useAPI.pdf')?>" target="_blank">API再開放</a></li>
                        <li><a href="<?php echo base_url('dist/privacyAndTermsOfUse.pdf')?>" target="_blank">隱私權與使用條款</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 col-xs-6 col-contact">
                    <div class="contact-container">
                        <h3 class="ftr-title">
                            聯絡我們
                        </h3>
                        <div class="ftr-contact contact-address">
                            <address>
                                樹德科技大學-資訊工程系大型資料計算實驗室(L0726)
                            </address>
                        </div>
                        <div class="ftr-contact contact-mail">
                            <a href="mailto:support@website.com">s15115127@stu.edu.tw</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1 col-xs-6 col-contact">
                    <a  href="https://www.facebook.com/footprintMap" target="_blank"><i class="fab fa-facebook fa-7x" style="color:#56cc91"></i></a>
                </div>
            </div>
            <div>
                <img src="<?php echo base_url('dist/img/system/logo.png') ?>" width="200" alt="logo"/>
            </div>

            <div class="copy clearfix">
                <div class="copy-right"><span>Copyright 2018 Footprint-服務足跡.</span> 版權所有.</div>
            </div>
        </div>
    </footer>

    <script src="<?php echo base_url('dist/intro/') ?>js/jquery-1.11.1.min.js"></script>

    <script src="<?php echo base_url('dist/intro/') ?>js/bootstrap.min.js"></script>

    <script src="<?php echo base_url('dist/intro/') ?>js/jquery.bxslider.min.js"></script>

    <script src="<?php echo base_url('dist/intro/') ?>js/swiper.min.js"></script>

    <script src="<?php echo base_url('dist/intro/') ?>js/ScrollToPlugin.min.js"></script>

    <script src="<?php echo base_url('dist/intro/') ?>js/main.js"></script>

</body>
</html>
