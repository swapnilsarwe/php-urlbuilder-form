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
	font-size: 13px;
}

h1 {
	text-align: center;
}

#wrapper {
	width: 80%;
	margin: 0 auto;
}

form {
	width: 60%;
}

form label {
	display: block;
	float: left;
	text-align: left;
	width: 75px;
}

form input {
	display: block;
	width: 250px;
}

#btnBuildUrl {
	width: 100px;
}

ul {
	list-style-type: none;
	padding: 0 0 0 50px;
}

ul li {
	font-weight: bold;
	padding: 3px 0;
}
</style>
</head>
<body>
	<div id="wrapper">
		<h1>PHP - URL Builder Form</h1>
        <?php echo UrlBuilder::Create()->processRequest('showform')?>
        <?php if(UrlBuilder::Create()->getFinalUrl()){ ?>
            <hr />
            Final Url:<br />
            <a target="blank" href="<?php echo UrlBuilder::Create()->getFinalUrl(); ?>"><?php echo UrlBuilder::Create()->getFinalUrl(); ?></a>
        <?php } ?>
    </div>
</body>
</html>