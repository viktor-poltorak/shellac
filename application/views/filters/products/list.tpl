{foreach from=$products item=item}
<div class="product-block">
    <h1><a href="/product/{$item->product_id}" target="_blank">{$item->title|stripslashes|escape:'html'}</a></h1>
    {if $item->image != ''}
    <div class="product-image">
        <a href="/product/{$item->product_id}" target="_blank">
            <img src="/images/products/{$item->image}" alt="{$item->title|stripslashes|escape:'html'}" />
        </a>
    </div>
    {/if}
    {if $item->price}
    <p class="price-block">{$item->price}</p>
    {/if}
    <p>{$item->description|stripslashes}</p>
</div>
<div style="clear: both;"></div>
{/foreach}