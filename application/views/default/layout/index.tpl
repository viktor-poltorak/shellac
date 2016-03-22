<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- Alex Oleshkevich, 2009 -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Eve platform</title>
        <link href="/css/default.css" rel="stylesheet" type="text/css" />
        <link rel="icon" href="/favicon-eve.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="/favicon-eve.ico" type="image/x-icon" />
    </head>
    <body>
        <div class="maintenance">
            Что-то стремное случилось с этой страницей....
        </div>
        <div class="content">
            {if defined('DEBUG')}
                {if $template}
                    {include file="`$template`"}
                {/if}
            {/if}
        </div>
        <div class="footer">
            <a href="/">на главную</a>
        </div>

    </body>
</html>