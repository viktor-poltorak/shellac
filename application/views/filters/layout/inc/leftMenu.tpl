<div class="left-menu">
    <ul>
        {foreach from=$categories item=item}
        <li><a href="/category/{$item->category_id}">{$item->name|stripslashes}</a></li>
        {/foreach}
    </ul>
</div>