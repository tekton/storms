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

	<xsl:template match="/root/character" name="issue">
		
		<xsl:variable name="id"><xsl:value-of select="id"/></xsl:variable>
		<xsl:variable name="name"><xsl:value-of select="name"/></xsl:variable>
		<xsl:variable name="parent1"><xsl:value-of select="parent1"/></xsl:variable>
		<xsl:variable name="parent2"><xsl:value-of select="parent2"/></xsl:variable>
		<xsl:variable name="dob"><xsl:value-of select="dob"/></xsl:variable>
		<xsl:variable name="birth_loc"><xsl:value-of select="birth_loc"/></xsl:variable>
		<xsl:variable name="hometown"><xsl:value-of select="hometown"/></xsl:variable>
		<xsl:variable name="race"><xsl:value-of select="race"/></xsl:variable>
		<xsl:variable name="hair"><xsl:value-of select="hair"/></xsl:variable>
		<xsl:variable name="eyes"><xsl:value-of select="eyes"/></xsl:variable>
		<xsl:variable name="max_height"><xsl:value-of select="max_height"/></xsl:variable>
		<xsl:variable name="demeanor"><xsl:value-of select="demeanor"/></xsl:variable>
		<xsl:variable name="significant_other"><xsl:value-of select="significant_other"/></xsl:variable>
		<xsl:variable name="marital_status"><xsl:value-of select="marital_status"/></xsl:variable>
		<xsl:variable name="bio"><xsl:value-of select="bio"/></xsl:variable>
		<xsl:variable name="user"><xsl:value-of select="user"/></xsl:variable>

		
	<form action="index.php?id={$id}" method="POST">
		<div class="information">
			<div class="information_top">information</div>
			<div class="information_bottom">
				<!--
				<div class="cBoth">
					<div class="cLeft">parent1</div>
					<div class="cRight"><input type="text" id="parent1" name="parent1" size="10" value="{$parent1}"/></div>
				</div>
				<div class="cBoth">
					<div class="cLeft">parent2</div>
					<div class="cRight"><input type="text" id="parent2" name="parent2" size="10" value="{$parent2}"/></div>
				</div>
				-->
				<div class="cBoth">
					<div class="cLeft">dob</div>
					<div class="cRight"><input type="text" id="dob" name="dob" size="10" value="{$dob}"/></div>
				</div>
				<div class="cBoth">
					<div class="cLeft">birth_loc</div>
					<div class="cRight"><input type="text" id="birth_loc" name="birth_loc" size="10" value="{$birth_loc}"/></div>
				</div>
				<div class="cBoth">
					<div class="cLeft">hometown</div>
					<div class="cRight"><input type="text" id="hometown" name="hometown" size="10" value="{$hometown}"/></div>
				</div>
				<div class="cBoth">
					<div class="cLeft">race</div>
					<div class="cRight"><input type="text" id="race" name="race" size="10" value="{$race}"/></div>
				</div>
				<div class="cBoth">
					<div class="cLeft">hair</div>
					<div class="cRight"><input type="text" id="hair" name="hair" size="10" value="{$hair}"/></div>
				</div>
				<div class="cBoth">
					<div class="cLeft">eyes</div>
					<div class="cRight"><input type="text" id="eyes" name="eyes" size="10" value="{$eyes}"/></div>
				</div>
				<div class="cBoth">
					<div class="cLeft">max_height</div>
					<div class="cRight"><input type="text" id="max_height" name="max_height" size="10" value="{$max_height}"/></div>
				</div>
				<div class="cBoth">
					<div class="cLeft">demeanor</div>
					<div class="cRight"><input type="text" id="demeanor" name="demeanor" size="10" value="{$demeanor}"/></div>
				</div>

				<!--
				<div class="cBoth">
					<div class="cLeft">marital_status</div>
					<div class="cRight"><input type="text" id="marital_status" name="marital_status" size="10" value="{$marital_status}"/></div>
				</div>
				-->
				
				<div class="cBoth">
					<div class="cLeft">user</div>
					<div class="cRight"><xsl:value-of select="user"/></div>
				</div>
				
				<div clas="cBoth">&#160;</div>
			</div>
		</div>
		
		<div class="issue">
			<div class="issue_top">
				<input type="text" id="name" value="{$name}" name="name"/>
			</div>
			<div class="issue_content">
				<textarea name="bio" rows="10" cols="60">
					<xsl:value-of select="bio"/>
				</textarea>
			</div>
		</div>
		<input type="hidden" name="character_edit" id="character_edit" value="edit"/>
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