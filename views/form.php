<form id="php-urlbuilder-form" name="php-urlbuilder-form" method="get"	action="">
    <?php echo UrlBuilder::Create()->printForm(); ?>
    <input type="submit" name="btnBuildUrl" id="btnBuildUrl" value="Build Url" />
</form>