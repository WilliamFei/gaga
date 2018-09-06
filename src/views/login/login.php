<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DuckChat</title>
    <script src="../../public/js/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body>

<script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>

<script src="../../public/js/im/zalyKey.js"></script>
<script src="../../public/js/im/zalyAction.js"></script>
<script src="../../public/js/im/zalyClient.js"></script>
<script src="../../public/js/im/zalyBaseWs.js"></script>

<script type="text/javascript">

    requestSiteConfig(handleLoginSiteConfig);

    function handleLoginSiteConfig(params)
    {
        ZalyIm(params);
        var pluginLoginProfileJsonStr = localStorage.getItem(siteLoginPluginKey);
        var pluginLoginProfile = JSON.parse(pluginLoginProfileJsonStr);
        var landingPageUrl = pluginLoginProfile.landingPageUrl;

        localStorage.clear();
        window.location.href = landingPageUrl;
    }

</script>
</body>
</html>

