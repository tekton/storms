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

<xsl:transform version="1.1" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/1999/xhtml">
	<xsl:output method="html" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/>
	<xsl:include href="nl2br.xsl"/> 
	<xsl:include href="top.xsl"/> 
	<xsl:template match="/">
		<html>
			<head>
				<title>Base Overview</title>
				<link rel="stylesheet" type="text/css" href="main.css" media="screen" />
				
			</head>
			<body>
				<xsl:call-template name="top"/>
				<xsl:apply-templates/> 
			</body>
		</html>
	</xsl:template>

	<xsl:template match="/root" name="results">		
		<table class='results sortable' width='100%'>
			<tr>
				<th>Name</th>
				<th>Date of Birth</th>
				<th>Birth Location</th>
				<th>Hometown</th>
				<!--<th width='10%'>Entered</th>-->
				<!--<th width='10%'>Modified</th>-->
				<!--<th>Flagged</th>-->
				<th>Race</th>
				<!--<th>Issue</th>-->
			</tr>
			
		<xsl:for-each select="character">
			<xsl:variable name="link">
				<xsl:value-of select="id"/>
			</xsl:variable>
			
			<tr id="{$link}">
				<td class="fpType_table"><a href="?character=view&amp;cid={$link}"><xsl:value-of select="name"/></a></td>
				<td class="fpMilestones_table"><xsl:value-of select="dob"/></td>
				<td class="fpBuild_table"><xsl:value-of select="birth_loc"/></td>
				<td class="fpDate_table"><xsl:value-of select="hometown"/></td>
				<td class="fpDate_table"><xsl:value-of select="race"/></td>
			</tr>
		</xsl:for-each>
		</table>
	</xsl:template>
</xsl:transform>