<style>
.list_item {
	padding: 10px;
	font-size: 14px;
	border-bottom: 1px solid #fafafa;
}	
.list_item__link {
	font-family: Helvetica;
	color: #555555;
}
.list_item__link:hover {
	color: #222;
}
</style>	


<?
foreach($records as $record) {
	echo '<div class="list_item">' .$this->Html->link($record->className . ' - ' .$record->title, '/settings/view/' .$record->className. '/', ['class' => 'list_item__link']). '</div>';
}	
?>