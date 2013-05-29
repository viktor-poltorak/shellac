<h1>{t text="Feedback"}</h1>
{foreach from=$posts item=item name=items}
<div class="product-block">
    <h3><div class="feedback-sign">{t text="Name"}:</div> {$item->username|stripslashes}</h3>
    <div>{t text='Message'}:</div>
    <div>
        <p>
        {$item->text|stripslashes}
        </p>
    </div>
</div>
{if !$smarty.foreach.items.last}
<hr />
{/if}
<div style="clear: both;"></div>
{foreachelse}
<div class="product-block">
    <h3>{t text="No posts"}</h3>
</div>
{/foreach}
{if $successMessage}
<div class="successMessage">{$successMessage}</div>
{/if}
<div class="feedback">
    <img alt="" src="/images/feedback-top-w.png" />
    <div class="feedback-content">
        <form method="POST" action="/feedback/post">
            <p>
                {t text='Name'}:
                <div>
                    <input type="text" name="username" size="50" value="{$request->username}"/>
                    {if $feedback_name_error}
                        <div class="error-message">{$feedback_name_error}</div>
                    {/if}
                </div>
                <div style="clear: both;"></div>
                {t text='E-mail'}:
                <div>
                    <input type="text" name="email" size="50" value="{$request->email}" />
                    {if $feedback_email_error}
                        <div class="error-message">{$feedback_email_error}</div>
                    {/if}
                </div>
                <div style="clear: both;"></div>
                {t text='Message'}:
                {if $feedback_text_error}
                &nbsp;&nbsp;&nbsp;<span class="error-message">{$feedback_text_error}</span>
                {/if}
                <div>
                    <textarea name="text">{$request->text}</textarea>
                </div>
                <input type="submit" value="{t text='Send'}"/>
            </p>
        </form>
    </div>
    <img alt="" src="/images/feedback-bottom-w.png" />
</div>