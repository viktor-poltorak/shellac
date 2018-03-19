{include file='catalog/inc/tabs.tpl'}
<div class="manager-content">
    <div class="manager-header">
        <img src="/images/admin/icons/settings.png" alt="" />
        <span>Каталог товаров</span>
    </div>
    <div class="sort-categories">
        {foreach from=$categories item=item}
        <div class="manager-list{cycle values=', gray-bg'}" data-id="{$item->category_id}">
            <div class="manager-list-image">
                <a href="javascript:" class="toggle-category" data-id="{$item->category_id}">
                    {if $item->visible}
                    <img src="/images/admin/star.png" alt="" />
                    {else}
                    <img src="/images/admin/star-off.png" alt="" />
                    {/if}
                </a>
            </div>
            <div class="manager-list-content">
                <a href="/manager/catalog/edit/id/{$item->category_id}/">{$item->name}</a>&nbsp;&nbsp;&nbsp;
            </div>
            <div class="manager-list-controls">
                <a href="/manager/products/list/id/{$item->category_id}">
                    <img src="/images/admin/edit.png" alt="Продукты" />
                </a>
                <a href="javascript:" class="remove-category" data-href="/manager/catalog/delete/id/{$item->category_id}">
                    <img src="/images/admin/delete.png" alt="Удалить" />
                </a>
            </div>
        </div>
        {foreachelse}
        <div class="manager-list">
            <div class="manager-list-image">
                <img src="/images/admin/star-off.png" alt="" />
            </div>
            <div class="manager-list-content">
                Никаких категорий нет.
            </div>
        </div>
        {/foreach}
    </div>
</div>
<script src="/js/manage/catalog.js"></script>

<script>
    var catalog = new Catalog('.manager-content');
</script>