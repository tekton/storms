<?xml version="1.0" encoding="UTF-8" ?>
<!--
	entry
	Created by TAgee on 2012-04-27.
	Copyright (c) 2012 Tyler Agee. All rights reserved.
-->

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output encoding="UTF-8" indent="yes" method="html" />
	<xsl:include href="./comments.xsl"/>
	<xsl:include href="./histories.xsl"/>
	<xsl:include href="./head.xsl"/>
	<xsl:template match="/">
		<html>
                <head>
						<xsl:call-template name="scripts"/>
                        <title>Entry</title>
                </head>
                <body>
                        <xsl:call-template name="tags"/>
						<xsl:call-template name="body"/>
						<xsl:call-template name="comments"/>
						<xsl:call-template name="histories"/>
                </body>
        </html>
	</xsl:template>
	
	<xsl:template name="body">
		<div>
			<div class="issue_top">(<xsl:value-of select="/entry/id"/>) <xsl:value-of select="/entry/title"/></div>
			<div id="body" class="issue">
				<xsl:value-of select="/entry/body"/>
			</div>
		</div>
	</xsl:template>
	
	<xsl:template name="tags">
		<div id="tags" class="information">
			<div class="information_top">Tags</div>
			<xsl:for-each select="/entry/tags/tag">
				<div><xsl:value-of select="@name"/> :: <xsl:value-of select="@value"/></div>
			</xsl:for-each>
		</div>
	</xsl:template>
	
</xsl:stylesheet>
