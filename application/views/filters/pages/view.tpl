<h1>{$page->title}</h1>
{$page->body|stripslashes}
{if $indexPage == 1}
{include file='layout/inc/features.tpl'}
{/if}