<form id="php-urlbuilder-form" name="php-urlbuilder-form" method="post"	action="">
    <?php echo UrlBuilder::Create()->printForm(); ?>
    <input type="submit" name="btnBuildUrl" id="btnBuildUrl" value="Build Url" />
</form>