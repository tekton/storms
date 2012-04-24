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
				<link rel="stylesheet" type="text/css" href="main.css" media="screen"/>
			</head>
			<body>
				<div id="container">
					<!--<xsl:call-template name="user_a">-->
					<xsl:apply-templates/>
				</div>
			</body>
		</html>
	</xsl:template>

	<xsl:template match="/root/issue" name="issue">
		
		<xsl:variable name="id">
			<xsl:value-of select="@id"/>
		</xsl:variable>
		
		<xsl:variable name="name">
			<xsl:value-of select="name"/>
		</xsl:variable>
		
		<xsl:variable name="type"><xsl:value-of select="type"/></xsl:variable>
		<xsl:variable name="inBuild"><xsl:value-of select="inBuild"/></xsl:variable>
		<xsl:variable name="resolved"><xsl:value-of select="resolved"/></xsl:variable>
		<xsl:variable name="pertains"><xsl:value-of select="pertains"/></xsl:variable>
		<!--<xsl:variable name="by"><xsl:value-of select="by"/></xsl:variable>-->
		<xsl:variable name="parent"><xsl:value-of select="parent"/></xsl:variable>
		<xsl:variable name="project"><xsl:value-of select="project"/></xsl:variable>
		<xsl:variable name="visible"><xsl:value-of select="visible"/></xsl:variable>
		<xsl:variable name="flagged"><xsl:value-of select="flagged"/></xsl:variable>
		<xsl:variable name="milestone"><xsl:value-of select="milestone"/></xsl:variable>

		
	<form action="index.php?id={$id}" method="POST">
		<div class="information">
			<div class="information_top">information</div>
			<div class="information_bottom">
				
				<div class="cBoth">
					<div class="cLeft">type</div>
					<div class="cRight"><input type="text" id="type" name="type" size="10" value="{$type}"/></div>
				</div>

				<div class="cBoth">
					<div class="cLeft">in build</div>
					<div class="cRight"><input type="text" id="in_build" name="in_build" size="10" value="{$inBuild}"/></div>
				</div>

				<div class="cBoth">
					<div class="cLeft">updated in</div>
					<div class="cRight"><input type="text" id="resolved_in" name="resolved_in" size="10" value="{$resolved}"/></div>
				</div>

				<div class="cBoth">
					<div class="cLeft">milestone</div>
					<div class="cRight"><input type="text" id="milestone" name="milestone" size="10" value="{$milestone}"/></div>
				</div>

				<div class="cBoth">
					<div class="cLeft">pertains to</div>
					<div class="cRight"><input type="text" id="pertains_to" name="pertains_to" size="10" value="{$pertains}"/></div>
				</div>

				<div class="cBoth">
					<div class="cLeft">parent issue</div>
					<div class="cRight"><input type="text" id="parent_issue" name="parent_issue" size="10" value="{$parent}"/></div>
				</div>
				
				<div class="cBoth">
					<div class="cLeft">flagged</div>
					<div class="cRight"><input type="text" id="flagged" name="flagged" size="10" value="{$flagged}"/></div>
				</div>
				
				<div class="cBoth">
					<div class="cLeft">entered by</div>
					<div class="cRight"><xsl:value-of select="by"/></div>
				</div>
				
				<div class="cBoth">
					<div class="cLeft">project</div>
					<div class="cRight"><input type="text" id="project" name="project" size="10" value="{$project}"/></div>
				</div>
				
				<div class="cBoth">
					<div class="cLeft">visible</div>
					<div class="cRight"><input type="text" id="visible" name="visible" size="10" value="{$visible}"/></div>
					<div clas="cBoth">&#160;</div>
				</div>
				
				<div clas="cBoth">&#160;</div>
			</div>
		</div>
		
		<div class="issue">
			<div class="issue_top">
				<input type="text" id="issue_title" value="{$name}" name="issue_title"/>
			</div>
			<div class="issue_content">
				<textarea name="issue_text" rows="10" cols="60">
					<xsl:value-of select="desc"/>
				</textarea>
			</div>
		</div>
		<input type="hidden" name="edit" id="edit" value="edit"/>
		<input type="hidden" name="id" id="id" value="{$id}"/>
		<input type="submit"/>
	</form>
	</xsl:template>
	
	<xsl:template match="/root/comments" name="comments">
		<xsl:for-each select="comment">
			<div class="comment_top">
				<xsl:value-of select="title"/> by <xsl:value-of select="by"/> on <xsl:value-of select="time"/>
			</div>
			<div class="comment_data">
				<xsl:for-each select="data">
					<xsl:call-template name="nl2br">
						<xsl:with-param name="string" select="./text()"/>
	                </xsl:call-template>
				</xsl:for-each>
			</div>
		</xsl:for-each>
	</xsl:template>
	
	<xsl:template match="/root/commentInput" name="commentsIn">
		<!--
		<xsl:variable name="id">
			<xsl:value-of select="@id"/>
		</xsl:variable>
		
		<form action="index.php?id={$id}" method="POST">
		<div class="comment_top"><input type="text" id="comment_title" name="comment_title"/></div>
		<div class="comment_data">
			<textarea name="comment_text" rows="5" cols="60"></textarea>
		</div>
		<input type="hidden" name="id" id="id" value="{$id}"/>
		<input type="hidden" name="newComment" id="newComment" value="true"/>
		<input type="submit"/>
		</form>
		-->
	</xsl:template>
	
</xsl:transform>