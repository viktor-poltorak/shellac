<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/settings.png" alt="" />
		<span>Отзывы</span>
	</div>
	{foreach from=$posts item=item}
	<div class="manager-list{cycle values=', gray-bg'}">
		<div class="manager-list-image">
			<img src="/images/admin/star.png" alt="" />
		</div>
		<div class="manager-list-content">
            <a href="javascript:">Имя пользователя: {$item->username}&nbsp;&nbsp; Email: {$item->email} </a>&nbsp;&nbsp;&nbsp;
            <div class="feedbackMessage">
                {$item->text}
            </div>
		</div>
        <div class="manager-list-controls">
            <div class="manager-list-image">
                <a href="/manager/feedback/visible/id/{$item->id}">
                    <img src="/images/admin/star{if $item->visible == 0}-off{/if}.png" alt="" />
                </a>
            </div>
			<a href="/manager/feedback/delete/id/{$item->id}">
				<img src="/images/admin/delete.png" alt="Удалить" />
			</a>
		</div>
	</div>
	{foreachelse}
	<div class="manager-list">
		<div class="manager-list-image">
			<img src="/images/admin/star-off.png" alt="" />
		</div>
		<div class="manager-list-content">
				Пока нет никаких отзывов
		</div>
	</div>
	{/foreach}
</div>