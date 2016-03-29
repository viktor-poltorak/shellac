<div class="product">
    <div class="product-block">
        <h1>{$product->title|stripslashes}</h1>
        {if $product->image != ''}
            <div class="product-image">
                <img src="/images/products/{$product->image}" alt="{$product->title|stripslashes}" />
            </div>
        {/if}
        {if $product->price}
            <p>{$product->price}</p>
        {/if}
        <p>{$product->description|stripslashes}</p>
    </div>
    <div style="clear: both;"></div>
    <div class="product-description">
        {$product->full_description}
    </div>
    <div style="clear: both;"></div>
    {if $product->image_1 != ''}
        <div class="addition-image">
            <img src="/images/products/{$product->image_1}" alt="{$product->title|stripslashes}" />
        </div>
    {/if}
    {if $product->image_2 != ''}
        <div class="addition-image">
            <img src="/images/products/{$product->image_2}" alt="{$product->title|stripslashes}" />
        </div>
    {/if}
</div>
