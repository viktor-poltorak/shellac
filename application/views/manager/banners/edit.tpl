{if $error}
    {sb_error text=$errors}
{/if}
{include file='banners/inc/tabs.tpl'}
<div class="manager-content">
    <div class="manager-header">
        <img src="/images/admin/icons/settings.png" alt="" />
        <span>Добавление категории</span>
        <div class="manager-add">
            <a href="/manager/banners">
                <img src="/images/admin/back.png" alt="" />
                <span>Вернуться к меню</span>
            </a>
        </div>
    </div>
    <form action="/manager/banners/save/" method="post" class="form" enctype="multipart/form-data">
        {if $request->id}
            <input name="id" value="{$request->id}" type="hidden" />
        {/if}
        <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
                    <a href="#tabs-1">Russian</a>
                </li>
                <li class="ui-state-default ui-corner-top">
                    <a href="#tabs-2">English</a>
                </li>
                <li class="ui-state-default ui-corner-top">
                    <a href="#tabs-3">Ukrain</a>
                </li>
            </ul>
            <div id="tabs-1" class="ui-tabs-panel ui-widget-contrut ui-corner-bottom">
                <div class="form-item">
                    <label>{t text="Заголовок"}</label>
                    <input type="text"  name="title[ru]" value="{$request->title.ru}" />
                </div>
                <div class="form-item">
                    <label>{t text="Текст"}:</label>
                    <input type="text"  name="text[ru]" value="{$request->text.ru}" />
                </div>
            </div>
            <div id="tabs-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
                <div class="form-item">
                    <label>{t text="Заголовок"}</label>
                    <input type="text"  name="title[en]" value="{$request->title.en}" />
                </div>
                <div class="form-item">
                    <label>{t text="Текст"}:</label>
                    <input type="text"  name="text[en]" value="{$request->text.en}" />
                </div>
            </div>
            <div id="tabs-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
                <div class="form-item">
                    <label>{t text="Заголовок"}</label>
                    <input type="text"  name="title[ua]" value="{$request->title.ua}" />
                </div>
                <div class="form-item">
                    <label>{t text="Текст"}:</label>
                    <input type="text"  name="text[ua]" value="{$request->text.ua}" />
                </div>
            </div>

            <div class="form-item">
                <label>Изображение:</label>
                <input type="file" name="image"  />
            </div>
            {if $request->image != ''}
                <div class="form-item">
                    <img src="/images/banners/{$request->image}" />
                </div>
            {/if}

            <div>
                <input type="submit" value="Сохранить" />
            </div>
        </div>
    </form>
</div>