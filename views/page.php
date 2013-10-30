<html>
<head>
<title>PHP - URL Builder Form</title>
<style>
body,form,ul,li,label,input {
	margin: 0;
	padding: 0;
}

body {
	font-family: Ubuntu, Tahoma, sans-serif;
}

h1 {
	text-align: center;
}

#wrapper {
	width: 95%;
	margin: 0 auto;
}

form {
}

form label {
	display: block;
	float: left;
	text-align: left;
	width: 125px;
}

form input {
	display: block;
	font: inherit;
	padding: 3px;
	width: 250px;
}

#btnBuildUrl, #btnSubmitUrl {
	margin: 20px 0 5px 0;
	width: 100px;
	
}

ul {
	list-style-type: none;
	padding: 0 0 0 50px;
}

ul li {
	padding: 3px 0;
}
</style>
</head>
<body>
	<div id="wrapper">
		<h1>PHP - URL Builder Form</h1>
        <?php echo UrlBuilder::Create()->processRequest('showform')?>
        <?php if(UrlBuilder::Create()->getDefaultUrl()){ ?>
            <hr />
            Final Url:<br />
            <a target="blank" href="<?php echo UrlBuilder::Create()->getDefaultUrl(); ?>">
            	<?php echo UrlBuilder::Create()->getDefaultUrl(); ?>
            </a>
        <?php } ?>
    </div>
</body>
</html>