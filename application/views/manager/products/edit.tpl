{if $error}
    {sb_error text=$errors}
{/if}
{include file='products/inc/tabs.tpl'}
<div class="manager-content">
    <div class="manager-header">
        <img src="/images/admin/icons/settings.png" alt="" />
        <span>{if !$request->product_id}Добавление{else}Редактирование{/if} товара</span>
        <div class="manager-add">
            <a href="/manager/products/list/id/{$request->category_id}">
                <img src="/images/admin/back.png" alt="" />
                <span>Назад</span>
            </a>
        </div>
    </div>
    <form action="/manager/products/save/" method="post" class="form" enctype="multipart/form-data">
        {if $request->product_id}
            <input name="id" value="{$request->product_id|escape:'html'}" type="hidden" />
        {/if}
        <input name="category_id" value="{$request->category_id|escape:'html'}" type="hidden" />

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
                    <input type="text" id="title" name="title[ru]" value="{$request->title.ru|stripslashes|escape:'html'}" />
                </div>
                <div class="form-item">
                    <label>Кратное описание:</label>
                    <textarea type="text" name="description[ru]">{$request->description.ru|escape:'html'}</textarea>
                </div>
                <div class="form-item">
                    <label>Описание:</label>
                    <textarea type="text" id="product_description_ru" name="full_description[ru]">{$request->full_description.ru|stripslashes|escape:'html'}</textarea>
                </div>
                <div class="form-item">
                    <label>Meta тег:</label>
                    <input type="text" id="meta" name="meta[ru]" value="{$request->meta.ru|stripslashes|escape:'html'}" />
                </div>
                <div class="form-item">
                    <label>Ключевые слова:</label>
                    <input type="text" id="keywords" name="keywords[ru]" value="{$request->keywords.ru|stripslashes|escape:'html'}" />
                </div>
            </div>
            <div id="tabs-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                <div class="form-item">
                    <label>Название:</label>
                    <input type="text" id="title" name="title[en]" value="{$request->title.en|stripslashes|escape:'html'}" />
                </div>
                <div class="form-item">
                    <label>Кратное описание:</label>
                    <textarea type="text" name="description[en]">{$request->description.en|stripslashes|escape:'html'}</textarea>
                </div>
                <div class="form-item">
                    <label>Описание:</label>
                    <textarea type="text" id="product_description_en" name="full_description[en]">{$request->full_description.en|escape:'html'}</textarea>
                </div>|stripslashes
                <div class="form-item">
                    <label>Meta тег:</label>
                    <input type="text" id="meta" name="meta[en]" value="{$request->meta.en|stripslashes|escape:'html'}" />
                </div>
                <div class="form-item">
                    <label>Ключевые слова:</label>
                    <input type="text" id="keywords" name="keywords[en]" value="{$request->keywords.en|stripslashes|escape:'html'}" />
                </div>
            </div>
            <div id="tabs-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                <div class="form-item">
                    <label>Название:</label>
                    <input type="text" id="title" name="title[ua]" value="{$request->title.ua|stripslashes|escape:'html'}" />
                </div>
                <div class="form-item">
                    <label>Кратное описание:</label>
                    <textarea type="text" name="description[ua]">{$request->description.ua|stripslashes|escape:'html'}</textarea>
                </div>
                <div class="form-item">
                    <label>Описание:</label>
                    <textarea type="text" id="product_description_ua" name="full_description[ua]">{$request->full_description.ua|stripslashes|escape:'html'}</textarea>
                </div>
                <div class="form-item">
                    <label>Meta тег:</label>
                    <input type="text" id="meta" name="meta[ua]" value="{$request->meta.ua|stripslashes|escape:'html'}" />
                </div>
                <div class="form-item">
                    <label>Ключевые слова:</label>
                    <input type="text" id="keywords" name="keywords[ua]" value="{$request->keywords.ua|stripslashes|escape:'html'}" />
                </div>
            </div>

            <div class="form-item">
                <label>Цена:</label>
                <input type="text" id="title" name="price" value="{$request->price|stripslashes|escape:'html'}" />
            </div>
            <div class="form-item">
                <label>Категория:</label>
                <select name="category_id">
                    {foreach from=$categories item=cat}
                        <option value="{$cat->category_id}" {if $request->category_id == $cat->category_id}selected{/if} >{$cat->name_ru}</option>
                    {/foreach}
                </select>
            </div>
            <div class="form-item">
                <label>Изображения:</label>
                <input type="file" name="image"  />
                <input type="file" name="image_1"  />
                <input type="file" name="image_2"  />
            </div>
            {if $request->image != ''}
                <div class="form-item"  data-url="/manager/products/remove-image/id/{$request->product_id}"  data-key="image">
                    <img width="150" src="/images/products/{$request->image}" />
                    <button class="remove-image">Удалить</button>
                </div>
            {/if}

            {if $request->image_1 != ''}
                <div class="form-item" data-url="/manager/products/remove-image/id/{$request->product_id}"  data-key="image_1">
                    <img width="150" src="/images/products/{$request->image_1}" />
                    <button class="remove-image">Удалить</button>
                </div>
            {/if}
            {if $request->image_2 != ''}
                <div class="form-item" data-url="/manager/products/remove-image/id/{$request->product_id}"  data-key="image_2">
                    <img width="150" src="/images/products/{$request->image_2}" />
                    <button class="remove-image">Удалить</button>
                </div>
            {/if}
            <div>
                <input type="submit" value="Сохранить" />
            </div>
        </div>
    </form>
</div>
<script src="/js/manage/editProduct.js"></script>
<script>
    var editProduct = new EditProduct('.manager-content');
</script>