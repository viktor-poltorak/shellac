{include file='pricelist/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/pricelist.png" alt="" />
		<span>Прайслист</span>
	</div>
	<form action="/manager/pricelist/save/" method="post" class="form" enctype="multipart/form-data">
		<div class="form-item">
			<label>Прайслист:</label>
			<input type="file" name="pricelist"  />
		</div>
		<div>
			<input type="submit" value="Сохранить" />
		</div>
	</form>
</div>