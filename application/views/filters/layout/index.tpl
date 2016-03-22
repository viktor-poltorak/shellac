<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
            <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
            <title>{$pageTitle}</title>
            <meta name="keywords" content="{$keywords}" />
            <meta name="description" content="{$description}" />
            <link rel="shortcut icon" href="/favicon.ico" />
            <link rel="stylesheet" href="/css/main.css" type="text/css" />
            <script src="/js/libs/jquery.js"></script>
            <script src="/js/main.js"></script>
    </head>
    <body>
        <div class="body">
            <div class="header">
                <div class="header-left">
                    <div class="logo">
                        <a href="/">
                            <img src="/images/logo.png" width="130" height="130" alt="{$siteName}" />
                        </a>
                    </div>
                </div>
                <div class="header-center">
                    <div class="site-title">
                        <div class="text-logo">{$textLogo}</div>
                        <div class="site-text">{$siteText}</div>
                        <div class="banner" id="mainBanner"><!-- ---></div>
                    </div>
                </div>
                <div class="header-right">
                    <div class="navigation-bar">
                        <a href="?lang=en"><img src="/images/flags/gb.png"/></a>
                        <a href="?lang=ru"><img src="/images/flags/ru.png"/></a>
                        <a href="?lang=ua"><img src="/images/flags/ua.png"/></a>
                    </div>
                </div>
                <div class="head-line">
                    <div class="block">
                        <div id="for_healh" class="quality-block white-text">
                            <div>{$leftOrange}</div>
                        </div>
                    </div>
                    <div class="block">
                        <div id="for_office" class="banner-text white-text"><div>{$leftBlue}</div></div>
                    </div>
                    <div class="block last">
                        <div class="info-block">
                            <div class="info-block-text">
                                <div class="info-title">{t text="HAVE A QUESTION? CALL"}!</div>
                                <div class="info-text">{$contactPhone}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page">
                <div class="left-col">
                    {include file='layout/inc/leftMenu.tpl'}
                </div>
                <div class="content">
                    {include file=`$template`}
                </div>
                <div class="right-col">
                    <div class="right-banner">
                        <img alt="" src="/images/banner-top.png" />
                        <div class="banner-content">
                            <img alt="" src="/images/presentation-ico.png" />
                            <p id="order_first">{t text="Order a consultation"}</p>
                            <p id="order_second">{t text="Phone"} {$orderPhone}</p>
                        </div>
                        <div class="banner-content">
                            <img alt="" src="/images/partners-ico.png" />
                            <p><a href="/content/Regional.html">{t text="Regional representatives"}</a></p>
                        </div>
                        <div class="banner-content">
                            <img alt="" src="/images/feedback-icon.jpg" />
                            <p><a href="/feedback">{t text="Feedback"}</a></p>
                        </div>
                        <img alt="" src="/images/banner-bottom.png" />
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="footer">
                <a href="/">
                    <img class="logo-bottom" src="/images/footer-logo.png" alt="" />
                </a>
                <div class="counter" style="display: none">
                    <!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t29.6;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано количество просмотров и"+
" посетителей' "+
"border='0' width='88' height='120'><\/a>")
//--></script><!--/LiveInternet-->
                </div>
            </div>
        </div>
    </body>
</html>
