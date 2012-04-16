<?xml version="1.0" encoding="UTF-8" ?>
<!--
	project_list.xsl
	Created by Tyler Agee on 2009-02-13.
	Copyright (c) 2009 Tyler Agee. All rights reserved.
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

	<xsl:template match="/root/projects" name="issue">
		<!-- for each input, throw an input here -->
		<div class="projects">
			<xsl:for-each select="project">
				<xsl:variable name="link">
					<xsl:value-of select="@id"/>
				</xsl:variable>
				<xsl:variable name="projectName" select="position() mod 2"/>
				<div class="project project{$projectName}">
					<h4><a href="?pm_edit={$link}"><xsl:value-of select="title"/></a></h4>
					<xsl:value-of select="philosophy"/>
				</div>
			</xsl:for-each>
		</div>
	</xsl:template>
	
</xsl:transform>
