<html>
	<head>
        <title>Teste parapanta - wingover.ro</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
        <h1>Teste parapanta</h1>
        <div class="header">
            <div class="menu">
                <a href="http://wingover.ro">Acasa</a>
            </div>
            <div class="menu">
                <a href="/">Teste parapanta</a>
            </div>
            <div class="menu">
                <a href="/clasament">Clasament</a>
            </div>
        </div>
        <br />
        <p class="<?=$this->setErrorClass()?>"><?=$this->getError()?>&nbsp;</p>
        <? $this->loadPage()?>

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-68693047-1', 'auto');
            ga('send', 'pageview');

        </script>
	</body>
</html>