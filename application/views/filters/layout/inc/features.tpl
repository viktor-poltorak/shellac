{if $banners}
<div class="features">
    <h2>{t text="Why us?"}</h2>
    <div class="features-box">
        {foreach from=$banners item=item name=banners}
        <div class="feature {if $smarty.foreach.banners.last}last{/if}">
            <div class="feature-box">
                <img src="{if $item->image}/images/banners/{$item->image}{else}/images/feature-1.png{/if}">
                <div class="feature-title">{$item->title}</div>
                <div class="feature-text">{$item->text}</div>
            </div>
        </div>
        {/foreach}
    </div>
</div>
{/if}