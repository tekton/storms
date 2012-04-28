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
	<xsl:include href="./nl2br.xsl"/>
	<xsl:template match="/">
		<html>
                <head>
						<xsl:call-template name="scripts"/>
                        <title>Entry</title>
                </head>
                <body>
					<div id="container">
                        <xsl:call-template name="tags"/>
						<xsl:call-template name="body"/>
						<xsl:call-template name="comments"/>
						<xsl:call-template name="histories"/>
					</div>
                </body>
        </html>
	</xsl:template>
	
	<xsl:template name="body">
		<div>
			<div class="issue_top">(<xsl:value-of select="/entry/id"/>) <xsl:value-of select="/entry/title"/></div>
			<div id="body" class="issue">
				<xsl:call-template name="nl2br">
                        <xsl:with-param name="string" select="/entry/body/text()" />
                </xsl:call-template>
			</div>
		</div>
	</xsl:template>
	
	<xsl:template name="tags">
		<xsl:variable name="url">
			<xsl:value-of select="/entries/urlBase/text()" />
		</xsl:variable>
		<div id="tags" class="information">
			<div class="information_top">Tags</div>
			<div id="tags_list">
				<xsl:for-each select="/entry/tags/tag">
					<div><xsl:value-of select="@name"/> :: <xsl:value-of select="@value"/></div>
				</xsl:for-each>
			</div>
			<xsl:variable name="id">
				<xsl:value-of select="/entry/id" />
			</xsl:variable>	
			<div id="tag-dialog-form">
				<form method="post" action="{$url}/tags/new/{$id}">
					<input type="hidden" id="id" value="{$id}" name="id" />
					<table>
					<tr><td>Name</td><td><input type="text" name="name" id="name"/></td></tr>
					<tr><td>Value</td><td><input type="text" name="value" id="value"/></td></tr>
					</table>
				</form>
			</div>
			<button id="add-tag" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Add Tag</button>
		</div>
	</xsl:template>
	
</xsl:stylesheet>
