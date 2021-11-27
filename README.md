# Footprint 服務足跡，台灣中小學圖鑑系統

以 CodeIgniter3 開發之台灣中小學圖鑑系統。

[立即使用](https://footprint.monken.tw/)

## 簡介

「Footprint－服務足跡」主要利用教育部Open Data作為核心資料，並結合衛服部與內政部之Open Data，開發交流、評分、社群等加值應用並建立起以中小學查詢為主要目的之資訊平台。透過 Footprit 服務足跡，使用者可以快速地搜尋與了解中小學校。

## 系統需求

1. PHP 5.6↑
2. Mysql 5.6

## 啟動

1. 於專案根目錄中執行以下指令
```
docker-compose up
```

2. 將專案根目錄中的 ``footprint.sql`` 匯入至資料庫

3. 專案預設連接埠為 `8080` 
    * `localhost:8080`

4. 將 Google Map Token 置入於 `application\views\home\map.php`
    ```javascript=15
    $.fn.tinyMapConfigure({
		"key": "",
		'libraries': 'places'
	});
    ```

5. 將 Google 我不是機器人認證資訊寫入
    * `application\views\login_view.php`
        ```html=33
        <div class="form-group ">
            <div class="g-recaptcha" data-sitekey="置入這裡"></div>
        </div>
        ```
    * `application\controllers\Login.php`
        ```php=29
        $Response=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret={key}&response='.$ReCaptchaResponse."&remoteip=".$_SERVER['REMOTE_ADDR']);
        ```
