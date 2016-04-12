{if $error}
    {sb_error text=$errors}
{/if}
{include file='catalog/inc/tabs.tpl'}
<div class="manager-content">
    <div class="manager-header">
        <img src="/images/admin/icons/settings.png" alt="" />
        <span>Добавление категории</span>
        <div class="manager-add">
            <a href="/manager/catalog">
                <img src="/images/admin/back.png" alt="" />
                <span>Назад</span>
            </a>
        </div>
    </div>
    <form action="/manager/catalog/{if $request->category_id}save{else}create-item{/if}/" method="post" class="form" enctype="multipart/form-data">
        {if $request->category_id}
            <input name="id" value="{$request->category_id}" type="hidden" />
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
            <div id="tabs-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                <div class="form-item">
                    <label>Название:</label>
                    <input type="text" id="title" name="name_ru" value="{$request->name_ru}" />
                    <label>Page description:</label>
                    <textarea class="page-description"  name="description_ru">{$request->description_ru}</textarea>
                </div>
            </div>
            <div id="tabs-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                <div class="form-item">
                    <label>Название:</label>
                    <input type="text" id="title" name="name" value="{$request->name}" />
                    <label>Page description:</label>
                    <textarea class="page-description"  name="description">{$request->description}</textarea>
                </div>
            </div>
            <div id="tabs-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                <div class="form-item">
                    <label>Название:</label>
                    <input type="text" id="title" name="name_ua" value="{$request->name_ua}" />
                    <label>Page description:</label>
                    <textarea class="page-description" name="description_ua">{$request->description_ua}</textarea>
                </div>
            </div>
        </div>
        <div>
            <input type="submit" value="Сохранить" />
        </div>
    </form>
</div>