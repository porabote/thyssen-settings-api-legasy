<style>

h3 {
	font-family: Helvetica;
	color: #555555;
	font-size: 21px;
}

.list_item {
	padding: 14px;
	font-size: 14px;
	border-bottom: 1px solid #fafafa;
}	
.list_item__link {
	display: block;
	font-family: Helvetica;
	color: #555555;
	text-decoration: none;
}
.list_item__link:hover {
	color: #222;
	text-decoration: underline;
}
</style>	

<h3>
	<?=$record->className . ' - ' . $record->title?>
</h3>


<?

	echo '<div class="list_item">
	    ' .$this->Html->link('Обновить <b>Все данные</b>', '/settings/update/' .$record->className. '/', ['escape' => false, 'class' => 'list_item__link']). 
	'</div>';

	echo '<div class="list_item">
	    ' .$this->Html->link('Обновить <b>Ссылки</b>', '/settings/updateLinks/' .$record->className. '/', ['escape' => false, 'class' => 'list_item__link']). 
	'</div>';

?>