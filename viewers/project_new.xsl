<?xml version="1.0" encoding="UTF-8" ?>
<!--
	display.xsl
	Created by Tyler Agee on 2009-02-13.
	Copyright (c) 2009 Tyler Agee. All rights reserved.
-->

<!--
	require head
	
	get information for the side (as it's float right)
	Get base info
	foreach comments
	
	comment input
-->

<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/1999/xhtml">
	<xsl:output method="html" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/>
	<xsl:include href="nl2br.xsl"/>
	<xsl:include href="users.xsl"/>
	<xsl:template match="/">
		<html>
			<head>
				<title>issues test</title>
				<link rel="stylesheet" type="text/css" href="main.css" media="screen" />
			</head>
			<body>
				<div id="container">
					<xsl:apply-templates/>
				</div>
			</body>
		</html>
	</xsl:template>

	<!--<xsl:template match="/root/right" name="information"></xsl:template>-->

	<xsl:template match="/root/center" name="issue">
		<form action="index.php" method="POST">
		
		<!-- for each input, throw an input here -->
		<div class="information">
			<div class="information_top">information</div>
			<table>
			<xsl:for-each select="r_input">
				<tr><td><xsl:value-of select="@display"/></td><td><input type="text" name="@name"/></td></tr>
			</xsl:for-each>
			</table>
		</div>
		
		<!-- for each input, throw an input here -->
		<div class="issue pm_new_issue">
			<table width="100%">
			<xsl:for-each select="input">
				<xsl:variable name="name">
					<xsl:value-of select="@name"/>
				</xsl:variable>
				
				<xsl:variable name="type">
					<xsl:value-of select="@type"/>
				</xsl:variable>
				
				<xsl:variable name="value">
					<xsl:value-of select="@value"/>
				</xsl:variable>
				
				<div>
					<tr>
						<td width="25%"><xsl:value-of select="@display"/></td>
						<td>
							<!-- check type! Textareas have a very different syntax -->
							<!--<input type="@type" name="@name"/>-->
							<xsl:choose>
								<xsl:when test="@type='textarea'">
									<textarea name="{$name}" rows="5">
										<xsl:value-of select="text()"/>
									</textarea>
								</xsl:when>
								<xsl:otherwise>
									<input type="{$type}" name="{$name}" value="{$value}"/>
								</xsl:otherwise>
							</xsl:choose>
						</td>
					</tr>
				</div>
			</xsl:for-each>
			</table>
			<input type="Submit"/>
			<xsl:for-each select="f_type">
				
				<xsl:variable name="name">
					<xsl:value-of select="@name"/>
				</xsl:variable>
				
				<xsl:variable name="value">
					<xsl:value-of select="@value"/>
				</xsl:variable>
				
				<input type="hidden" name="{$name}" value="{$value}"/>
			</xsl:for-each>
		</div>
		
		</form>
	</xsl:template>
	
</xsl:transform>