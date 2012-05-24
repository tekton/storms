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
		<div id="entry" class="ui-widget ui-widget-content ui-corner-all">
                        <div class="issue_top">
                            <div class=".cBoth">
                                <span id="title_edit" class="ui-icon ui-icon-wrench" style="float: left;">E</span>
                                <span id="title_input_span" style="display:none;">
                                    <input type="text" name="title_input" id="title_input" style="width: 80%;" />
                                </span>
                                <span id="entry_title_dialog">&#160;</span>
                                <span id="entry_title"><xsl:value-of select="/root/entry/title"/></span>
                            </div>
                        </div>
                        
                        <div id="body" class="issue">
                                <span id="entry_body_edit" class="ui-icon ui-icon-wrench"/>
				<span id="entry_body">
                                    <xsl:call-template name="nl2br">
                                        <xsl:with-param name="string" select="/root/entry/body/text()" />
                                    </xsl:call-template>
                                </span>
                                <span id="entry_body_dialog">&#160;</span>
                                <span id="entry_body_input_span" style="display:none;">
                                    <textarea id="entry_body_input" style="width: 80%;"></textarea>
                                </span>
			</div>
		</div>
	</xsl:template>
	
	<xsl:template name="tags">
		<xsl:variable name="url">
			<xsl:value-of select="/root/urlBase/text()" />
		</xsl:variable>
		<div id="tags" class="information ui-widget ui-widget-content">
			<div class="information_top">Tags</div>
			<div id="tags_list">
				<table id="tags_list_table">
					<xsl:for-each select="/root/entry/tags/tag">
						<tr class='tag'>
							<td class='tag'><xsl:value-of select="@name"/></td>
							<td class='tag'><xsl:value-of select="@value"/></td>
						</tr>
					</xsl:for-each>
				</table>
			</div>
			<xsl:variable name="id">
				<xsl:value-of select="/root/entry/id" />
			</xsl:variable>	
			<div id="tag-dialog-form" title="Add a tag">
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
                <div id="login-dialog-form" title="Login">
                        <form method="post" action="{$url}/json/login">
                                <table>
                                <tr><td>User</td><td><input type="text" name="user" id="user"/></td></tr>
                                <tr><td>Pass</td><td><input type="text" name="pass" id="pass"/></td></tr>
                                </table>
                        </form>
                </div>
                <button id="login-btn" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Login</button>
	</xsl:template>
	
</xsl:stylesheet>
