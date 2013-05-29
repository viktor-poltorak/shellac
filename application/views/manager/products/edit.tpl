{if $error}
{sb_error text=$errors}
{/if}
{include file='products/inc/tabs.tpl'}
<div class="manager-content">
    <div class="manager-header">
        <img src="/images/admin/icons/settings.png" alt="" />
        <span>{if !$request->product_id}Добавление{else}Редактирование{/if} товара</span>
        <div class="manager-add">
            <a href="/manager/categories">
                <img src="/images/admin/back.png" alt="" />
                <span>Вернуться к меню</span>
            </a>
        </div>
    </div>
    <form action="/manager/products/save/" method="post" class="form" enctype="multipart/form-data">
		{if $request->product_id}
        <input name="id" value="{$request->product_id}" type="hidden" />
		{/if}

        <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
                    <a href="#tabs-1">English</a>
                </li>
                <li class="ui-state-default ui-corner-top">
                    <a href="#tabs-2">Russian</a>
                </li>
                <li class="ui-state-default ui-corner-top">
                    <a href="#tabs-3">Ukrain</a>
                </li>
            </ul>
            <div id="tabs-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                <div class="form-item">
                    <label>Название:</label>
                    <input type="text" id="title" name="title[en]" value="{$request->title.en}" />
                </div>
                <div class="form-item">
                    <label>Описание:</label>
                    <textarea type="text" id="product_description_en" name="description[en]">{$request->description.en}</textarea>
                </div>
                <div class="form-item">
                    <label>Meta тег:</label>
                    <input type="text" id="meta" name="meta[en]" value="{$request->meta.en}" />
                </div>
                <div class="form-item">
                    <label>Ключевые слова:</label>
                    <input type="text" id="keywords" name="keywords[en]" value="{$request->keywords.en}" />
                </div>
            </div>
            <div id="tabs-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
                <div class="form-item">
                    <label>Название:</label>
                    <input type="text" id="title" name="title[ru]" value="{$request->title.ru}" />
                </div>
                <div class="form-item">
                    <label>Описание:</label>
                    <textarea type="text" id="product_description_ru" name="description[ru]">{$request->description.ru}</textarea>
                </div>
                <div class="form-item">
                    <label>Meta тег:</label>
                    <input type="text" id="meta" name="meta[ru]" value="{$request->meta.ru}" />
                </div>
                <div class="form-item">
                    <label>Ключевые слова:</label>
                    <input type="text" id="keywords" name="keywords[ru]" value="{$request->keywords.ru}" />
                </div>
            </div>
            <div id="tabs-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
                <div class="form-item">
                    <label>Название:</label>
                    <input type="text" id="title" name="title[ua]" value="{$request->title.ua}" />
                </div>
                <div class="form-item">
                    <label>Описание:</label>
                    <textarea type="text" id="product_description_ua" name="description[ua]">{$request->description.ua}</textarea>
                </div>
                <div class="form-item">
                    <label>Meta тег:</label>
                    <input type="text" id="meta" name="meta[ua]" value="{$request->meta.ua}" />
                </div>
                <div class="form-item">
                    <label>Ключевые слова:</label>
                    <input type="text" id="keywords" name="keywords[ua]" value="{$request->keywords.ua}" />
                </div>
            </div>


            <div class="form-item">
                <label>Категория:</label>
                <select name="category_id">
                    {foreach from=$categories item=cat}
                    <option value="{$cat->category_id}" {if $request->category_id == $cat->category_id}selected{/if} >{$cat->name}</option>
                    {/foreach}
                </select>
            </div>
            <div class="form-item">
                <label>Изображение:</label>
                <input type="file" name="image"  />
            </div>
            {if $request->image != ''}
            <div class="form-item">
                <img src="/images/products/{$request->image}" />
            </div>
            {/if}

            <div>
                <input type="submit" value="Сохранить" />
            </div>
        </div>
    </form>
</div>