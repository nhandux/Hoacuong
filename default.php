<?
header('Content-Type: text/html; charset=utf-8');
$host = $_SERVER['HTTP_HOST'];
setlocale(LC_TIME, "vn_VN");
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Chào mừng tới <? print $host; ?>! Hostinger Hosting miễn phí với PHP và MySQL.</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="http://www.main-hosting.com/hostinger/welcome/css/site.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="main">
    <div id="content">
        <div class="header">
            <a id="logo" href="http://www.hostinger.vn/"><img src="http://www.hostinger.vn/images/logo-vn.png" alt="Web hosting" /></a>
        </div>
        <div class="content">
            <h1>Tài khoản của bạn đã được tạo </h1>
            <p>Website <b><? print $host; ?></b> đã được cài đặt thành công trên server! Hãy xóa file <b>default.php</b> từ thư mục <b>public_html</b> rồi upload website của bạn lên bằng FTP hoặc trình Quản lý file.</p>
        <div class="footer"></div>
        <div class="clear"></div>
    </div>
    <div id="footer">
        <div class="links">
            <a href="http://www.hostinger.vn/web-hosting" target="_blank">Web Hosting</a>
            <span class="pipe">|</span>
            <a href="http://www.hostinger.vn/free-hosting" target="_blank">Hosting miễn phí</a>
            <span class="pipe">|</span>
            <a href="http://www.hostinger.vn/forum" target="_blank">Forum</a>
            <span class="pipe">|</span>
            <a href="http://cpanel.hostinger.vn/" target="_blank">Login</a>
        </div>
        <div class="copyright">Hostinger Việt Nam &copy; <? print date('Y'); ?>. All rights reserved</div>
        <div class="social-icons">
            <a href="http://www.facebook.com/Hostinger.vn"><img src="http://www.main-hosting.com/hostinger/welcome/images/fb.gif" /></a>
            <a href="https://twitter.com/HostingerCOM"><img src="http://www.main-hosting.com/hostinger/welcome/images/twitter.gif" /></a>
        </div>
    </div>
</div>
</body>
</html>