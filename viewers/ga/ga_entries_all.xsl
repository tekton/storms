<?xml version="1.0" encoding="UTF-8" ?>
<!--
	entries_all
	Created by TAgee on 2012-04-26.
	Copyright (c) 2012 Tyler Agee. All rights reserved.
-->

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/>
	<xsl:include href="../head.xsl"/>
	<xsl:include href="../nl2br.xsl"/>
	<xsl:template match="/">
		<html>
			<head>
				<title>graphe|arithmos - all entries</title>
                                <xsl:variable name="url">
                                    <xsl:value-of select="/root/urlBase/text()" />
                                </xsl:variable>

                                <link rel="stylesheet" href="{$url}/assets/css/start/jquery-ui-1.8.18.custom.css" type="text/css" media="all" />
                                <link rel="stylesheet" href="{$url}/assets/css/ga.css" type="text/css" media="all" />
                                
                                <script src="{$url}/assets/js/test_scripts.js" type="text/javascript"></script>
                                <script src="{$url}/assets/js/entry_manipulation.js" type="text/javascript"></script>
			</head>
			<body>
                                <div id="logo"> 
                                    <a>
                                        <xsl:attribute name="href"><xsl:value-of select="/root/urlBase/text()" />/ga/</xsl:attribute> 
                                        graphe<b>arithmos</b>
                                    </a>
                                    [alpha]
                                </div>
				<div id="container" class="ui-widget ui-widget-content">
                                    <table id="main-page-table">
                                            <xsl:call-template name="entries"/>
                                    </table>
				</div>
			</body>
		</html>
	</xsl:template>
	
	<xsl:template name="entries">
		<xsl:variable name="url">
			<xsl:value-of select="/root/urlBase/text()" />
		</xsl:variable>
		<xsl:for-each select="/root/entries/entry">
			<tr>
				<td><a href="{$url}/ga/show/{id}"><span class="ui-icon ui-icon-search">S</span></a></td>
				<td><xsl:value-of select="name" /></td>
			</tr>
		</xsl:for-each>
	</xsl:template>
	
</xsl:stylesheet>
