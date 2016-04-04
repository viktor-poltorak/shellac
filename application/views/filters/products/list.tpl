{foreach from=$products item=item}
    <div class="product-block">
        <h1><a href="/product/{$item->product_id}" target="_blank">{$item->title|stripslashes}</a></h1>
        {if $item->image != ''}
            <div class="product-image">
                <img src="/images/products/{$item->image}" alt="{$item->title|stripslashes}" />
            </div>
        {/if}
        {if $item->price}
            <p>{$item->price}</p>
        {/if}
        <p>{$item->description|stripslashes}</p>
    </div>
    <div style="clear: both;"></div>
{/foreach}