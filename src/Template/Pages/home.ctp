<?$this->layout = false;?>
<html>

<head>
    <title>Porabote Api</title>
<style>
body	{
	background: #F7F7F7;
	color: #2F2F2F;
	margin: 0;
	padding: 0;
	background: #000;
	font-family: Helvetica, Sans-Serif;
}
div::after {
  content: "";
  background-image: url('/img/moscow_bg.JPG');
	
	background-size: cover;
	background-position: 50%;
  opacity: 0.4;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  position: absolute;
  z-index: -1;   
}


.error_code {
	border: 0px solid black;
	height: 98vh;
	display: flex;
	flex-flow: column nowrap;
	align-content: center;
	align-items: center;
	justify-content: center;
}
.error_code__number {
	font-size: 30px;
	padding: 10px 30px 10px 30px;
	color: #fff;
	border: 0px solid white;
	#background: #fff;
}
.error_code__message__link {
	color: #2F2F2F;
}

</style>	
	
</head>	
	
<body>

<div class="error_code">
	<div class="error_code__number">Porabote API</div>	
<!--
	<div class="error_code__message">Извините, страница, которую вы ищете, не существует или была перемещена.</div>
	<div class="error_code__message">Вернуться на <a href="/" class="error_code__message__link">Главную</a>.</div>
-->
</div>	
	
</body>		
</html>	