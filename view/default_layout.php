<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
        <h1>Teste parapanta</h1>
        <div class="header">
            <div class="menu">
                <a href="/">Pagina de index</a>
            </div>
            <div class="menu">
                <a href="/clasament">Clasament</a>
            </div>
        </div>
        <br />
        <p class="<?=$this->setErrorClass()?>"><?=$this->getError()?>&nbsp;</p>
        <? $this->loadPage()?>
	</body>
</html>