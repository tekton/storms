<?xml version="1.0" encoding="UTF-8" ?>
<!--
	head
	Created by TAgee on 2012-04-27.
	Copyright (c) 2012 Tyler Agee. All rights reserved.
-->

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">

	<xsl:output encoding="UTF-8" indent="yes" method="html" media-type="application/xhtml+xml" />

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
            
            <script src="{$url}/assets/js/entry_manipulation.js" type="text/javascript"></script>
            <script src="{$url}/assets/js/login.js" type="text/javascript"></script>
	</xsl:template>
        
        <xsl:template name="top-bar">
            <div id="main-page-top">
                <!-- TODO add login check -->
                <xsl:variable name="url">
                        <xsl:value-of select="/root/urlBase/text()" />
                </xsl:variable>
                        <span id="home" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Home</span>
                        <span id="login-btn" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Login</span>
                        <span id="NewEntryButton" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">New Entry</span>

                <div id="login-dialog-form" title="Login">
                        <form method="post" action="{$url}/json/login">
                                <table>
                                    <tr><td>User</td><td><input type="text" name="user" id="user"/></td></tr>
                                    <tr><td>Pass</td><td><input type="password" name="pass" id="pass"/></td></tr>
                                </table>
                        </form>
                </div>
            </div>
        </xsl:template>
        
</xsl:stylesheet>
