{if $error}
{sb_error text=$errors}
{/if}
{literal}
<script>
    $(document).ready(function() {
        $('#contentPages').bind('change', function(){           
            $('#link').val($('#contentPages').val());            
            $('#title').val($('#contentPages > option[selected]').text());
        });
    });
</script>
{/literal}

{include file='menus/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/menu.png" alt="" />
		<span>Редактирование пункта меню</span>
			<div class="manager-add">
				<a href="/manager/menus/items/id/{$item->menu_id}/">
					<img src="/images/admin/back.png" alt="" />
					<span>Вернуться к меню</span>
				</a>
			</div>
	</div>

	<form action="/manager/menus/update-item/id/{$item->menu_item_id}/" method="post" class="form" enctype="multipart/form-data">
		<div class="form-item">
			<label>Выберите в какое меню перенести пункт:</label>
			<select name="menu_id">
				{foreach from=$menus item=menu}
				<option value="{$menu->menu_id}" {if $menu->menu_id == $item->menu_id}selected{/if}>{$menu->name}</option>
				{/foreach}
			</select>
		</div>

        <div class="form-item">
            <label>Язык:</label>
            <select name="language">
                {foreach from=$languages item=lang}
                <option value="{$lang->id}" {if $currentLang==$lang->id}selected{/if}>{$lang->id}</option>
                {/foreach}
            </select>
        </div>
		<div class="form-item">
			<label>Название:</label>
			<input type="text" name="name" id="title" value="{$item->name}" />
		</div>
		<div class="form-item">
			<label>Описание:</label>
			<input type="text" name="description" value="{$item->description}" />
		</div>
        <div class="form-item">
			<label>Ссылка на контент:</label>
            <select id="contentPages" name="contentPage">
                <option>Выбрать</option>
                <option value="/" {if $item->link=="/"}selected{/if}>Главная</option>
                {foreach from=$contentPages item=page}
                <option value="/content/{$page->link}" {if $page->link == $item->link}selected{/if}>{$page->title}</option>
                {/foreach}
            </select>
		</div>
		<div class="form-item">
			<label>Ссылка:</label>
			<input type="text" name="link" id="link" value="{$item->link}" />
		</div>
		<div class="form-cols gray-bg">
			<div class="form-item">
				<label>Включить?</label>
				<select name="enabled">
					<option value="1" {if $item->enabled}selected{/if}>да</option>
					<option value="0" {if !$item->enabled}selected{/if}>нет</option>
				</select>
			</div>
			<div class="form-item">
				<label>В новом окне?</label>
				<select name="in_new_tab">
					<option value="0" {if !$item->in_new_tab}selected{/if}>нет</option>
					<option value="1"{if $item->in_new_tab}selected{/if}>да</option>
				</select>
			</div>
		</div>
		<div class="form-item">
			<label>Иконка:</label>
			<input type="file" name="icon" />
		</div>
		<div>
			<input type="submit" value="Обновить" />
		</div>
	</form>
</div>