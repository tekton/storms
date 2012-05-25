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
                                    <div id="main-page-top">
                                        <!-- TODO add login check -->
                                        <xsl:variable name="url">
                                                <xsl:value-of select="/root/urlBase/text()" />
                                        </xsl:variable>
                                        <div id="tags" class="information ui-widget ui-widget-content">
                                                <span id="login-btn" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Login</span>
                                                <span id="NewEntryButton" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">New Entry</span>
                                        </div>
                                        <div id="login-dialog-form" title="Login">
                                                <form method="post" action="{$url}/json/login">
                                                        <table>
                                                            <tr><td>User</td><td><input type="text" name="user" id="user"/></td></tr>
                                                            <tr><td>Pass</td><td><input type="password" name="pass" id="pass"/></td></tr>
                                                        </table>
                                                </form>
                                        </div>
                                    </div>
                                    
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
