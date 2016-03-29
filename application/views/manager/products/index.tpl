{include file='products/inc/tabs.tpl'}
<div class="manager-content" data-category-id="{$category->category_id}">
    <div class="manager-header">
        <img src="/images/admin/icons/settings.png" alt="" />
        <span>Категория - {$category->name_ru}</span>
        <div class="manager-add">
            <a href="/manager/catalog">
                <img src="/images/admin/back.png" alt="" />
                <span>Вернуться к категориям</span>
            </a>
        </div>
    </div>
    <div class="sort-products">
        {foreach from=$products item=item}
            <div class="manager-list{cycle values=', gray-bg'}"  data-id="{$item->product_id}">
                <div class="manager-list-image">
                    <img src="/images/admin/star.png" alt="" />
                </div>
                <div class="manager-list-content">
                    <a href="/manager/products/edit/id/{$item->product_id}/">{$item->title}</a>&nbsp;&nbsp;&nbsp;
                </div>
                <div class="manager-list-controls">
                    <a href="/manager/products/edit/id/{$item->product_id}">
                        <img src="/images/admin/edit.png" alt="Редактировать" />
                    </a>
                    <a href="/manager/products/delete/id/{$item->product_id}">
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
                    Никаких продуктов нет.
                </div>
            </div>
        {/foreach}
    </div>
</div>
<script src="/js/manage/products.js"></script>

<script>
    var products = new Products('.manager-content');
</script>