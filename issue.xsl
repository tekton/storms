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
	<xsl:include href="./xsl/nl2br.xsl"/>
	<xsl:include href="./xsl/users.xsl"/>
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

	<xsl:template match="/root/issue" name="issue">
		
		<xsl:variable name="id">
			<xsl:value-of select="@id"/>
		</xsl:variable>
		
		<div class="information">
			<div class="information_top">information</div>
			<div class="information_bottom">
				
				<div class="cBoth">
					<div class="cLeft">type</div>
					<div class="cRight"><xsl:value-of select="type"/></div>
				</div>
				
				<div class="cBoth">
					<div class="cLeft">flagged</div>
					<div class="cRight"><xsl:value-of select="flagged"/></div>
				</div>
				
				<div class="cBoth">
					<div class="cLeft">in build</div>
					<div class="cRight"><xsl:value-of select="inBuild"/></div>
				</div>
				
				<div class="cBoth">
					<div class="cLeft">updated in</div>
					<div class="cRight"><xsl:value-of select="resolved"/></div>
				</div>
				
				<div class="cBoth">
					<div class="cLeft">milestone</div>
					<div class="cRight"><xsl:value-of select="milestone"/></div>
				</div>
				
				<div class="cBoth">
					<div class="cLeft">pertains to</div>
					<div class="cRight"><xsl:value-of select="pertains"/></div>
				</div>
				
				<div class="cBoth">
					<div class="cLeft">entered by</div>
					<div class="cRight"><xsl:value-of select="by"/></div>
				</div>	
				
				<div class="cBoth">
					<div class="cLeft">project</div>
					<div class="cRight"><xsl:value-of select="project"/></div>
				</div>

				<div clas="cBoth">&#160;</div>
			</div>
			<div id="history_top">history</div>
			<div id="history">
				<!-- for each of history list-->
				<xsl:for-each select="histories/history">
					<xsl:variable name="h_id">
						<xsl:value-of select="id"/>
					</xsl:variable>
					<div><a href="?history_id={$h_id}"><xsl:value-of select="posted"/> by <xsl:value-of select="user"/></a></div>
				</xsl:for-each>
			</div>
		</div>
		
		<div class="issue">
			<div class="issue_top">
				<a href="?edit={$id}"><xsl:value-of select="name"/></a>
			</div>
			<div class="issue_content">
				<xsl:for-each select="desc">
					<xsl:call-template name="nl2br">
	                        <xsl:with-param name="string" select="./text()" />
	                </xsl:call-template>
				</xsl:for-each>
				<!--><xsl:value-of select="desc"/>-->
			</div>
		</div>
	</xsl:template>
	
	<xsl:template match="/root/comments" name="comments">
		<xsl:for-each select="comment">
			<div class="comment_top">
				<xsl:value-of select="title"/> by <xsl:value-of select="by"/> on <xsl:value-of select="time"/>
			</div>
			<div class="comment_data">
				<xsl:for-each select="data">
					<xsl:call-template name="nl2br">
						<xsl:with-param name="string" select="./text()" />
	                </xsl:call-template>
				</xsl:for-each>
			</div>
		</xsl:for-each>
	</xsl:template>
	
	<xsl:template match="/root/commentInput" name="commentsIn">
		<xsl:variable name="id">
			<xsl:value-of select="@id"/>
		</xsl:variable>
		
		<form action="index.php?id={$id}" method="POST">
		<div class="comment_top"><input type="text" id="comment_title" name="comment_title" /></div>
		<div class="comment_data">
			<textarea name="comment_text" rows="5" cols="60"></textarea>
		</div>
		<input type="hidden" name="id" id="id" value="{$id}" />
		<input type="hidden" name="newComment" id="newComment" value="true" />
		<input type="submit" />
		</form>
		
	</xsl:template>
	
</xsl:transform>