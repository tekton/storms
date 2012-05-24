<?xml version="1.0" encoding="UTF-8" ?>
<!--
	entries_all
	Created by TAgee on 2012-04-26.
	Copyright (c) 2012 Tyler Agee. All rights reserved.
-->

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/>
	<xsl:include href="./head.xsl"/>
	<xsl:include href="./nl2br.xsl"/>
	<xsl:template match="/">
		<html>
			<head>
				<title>storms - all entries</title>
				<xsl:call-template name="scripts"/>
			</head>
			<body>
				<div id="container">
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
				<td><a href="{$url}/entry/show/{id}"><span class="ui-icon ui-icon-search">S</span></a></td>
				<td><a href="{$url}/entry/migrate/{id}"><span class="ui-icon ui-icon-gear">M</span></a></td>
				<td><a href="{$url}/entry/edit/{id}"><span class="ui-icon ui-icon-wrench">E</span></a></td>
				<td><xsl:value-of select="name" /></td>
			</tr>
		</xsl:for-each>
	</xsl:template>
	
</xsl:stylesheet>
