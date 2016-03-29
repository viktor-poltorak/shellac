<ul class="manager-tabs">
    <li {if $tab == 'index'} class="tab-selected" {/if}><a href="/manager/products/list/id/{$request->category_id}">Все товары</a></li>
    <li {if $tab == 'add'} class="tab-selected"{/if}><a href="/manager/products/add/category_id/{$request->category_id}">Добавить товар</a></li>
</ul>