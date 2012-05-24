<?xml version="1.0" encoding="UTF-8" ?>
<!--
	head
	Created by TAgee on 2012-04-27.
	Copyright (c) 2012 Tyler Agee. All rights reserved.
-->

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output encoding="UTF-8" indent="yes" method="html" />

	<xsl:template name="scripts">
            <xsl:variable name="url">
                    <xsl:value-of select="/root/urlBase/text()" />
            </xsl:variable>
            
            <link rel="stylesheet" href="{$url}/assets/css/start/jquery-ui-1.8.18.custom.css" type="text/css" media="all" />
            <link rel="stylesheet" href="{$url}/assets/css/main.css" type="text/css" media="all" />
            
            <script src="{$url}/assets/js/jquery-1.7.1.min.js" type="text/javascript"></script>
            <script type="text/javascript">
                var url_base = "<xsl:value-of select="$url"/>";
            </script>
            <script src="{$url}/assets/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
            <script src="{$url}/assets/js/test_scripts.js" type="text/javascript"></script>
	</xsl:template>
</xsl:stylesheet>
