<?xml version="1.0" encoding="UTF-8" ?>
<!--
	entries_all
	Created by TAgee on 2012-04-26.
	Copyright (c) 2012 Tyler Agee. All rights reserved.
-->

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/>

	<xsl:template match="/">
		<html>
			<div id="container">
				<xsl:apply-templates/>
			</div>
		</html>
	</xsl:template>
	
	<xsl:template match="/entries/entry" name="entries">
		<div>
			[<a href="../entry/show/{id}">S</a>]
			[<a href="../entry/migrate/{id}">M</a>]
			[<a href="../entry/edit/{id}">E</a>]
			<xsl:value-of select="name" />
		</div>
	</xsl:template>
	
</xsl:stylesheet>
