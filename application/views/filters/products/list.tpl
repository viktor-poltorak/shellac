{foreach from=$products item=item}
<div class="product-block">
    <h1>{$item->title|stripslashes}</h1>
    {if $item->image != ''}
    <div class="product-image">
        <img src="/images/products/{$item->image}" alt="{$item->title|stripslashes}" />
    </div>
    {/if}
    <p>
        {$item->description|stripslashes}
    </p>    
</div>
<div style="clear: both;"></div>
{/foreach}