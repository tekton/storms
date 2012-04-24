<?xml version="1.0" encoding="UTF-8" ?>
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
				<div id="container2">
					<xsl:apply-templates/>
				</div>
			</body>
		</html>
	</xsl:template>
	
	<xsl:template match="/root/report/bugs">
		<xsl:if test="child::bug">
			<h3>Bugs</h3>
				<!-- with passed custom sorting? -->
			<table class='results sortable' width='100%'>
				<tr>
					<th>Issue In</th>
					<th>Updated In</th>
					<th>Pertains</th>
					<th>Entered</th>
					<th>Flagged</th>
					<th>Project</th>
					<th width="40%">Description</th>
				</tr>
				<xsl:for-each select="bug">
					
					<xsl:variable name="link">
						<xsl:value-of select="id"/>
					</xsl:variable>
									
				<tr>
						<td><xsl:value-of select="issueInBuild"/></td>
						<td><xsl:value-of select="resolvedInBuild"/></td>
						<td><xsl:value-of select="pertainsTo"/></td>
						<td><xsl:value-of select="dateEntered"/></td>
						<td><xsl:value-of select="flagged"/></td>
						<td><xsl:value-of select="project"/></td>
						<td><a href="?id={$link}"><xsl:value-of select="description"/></a></td>
					</tr>
				</xsl:for-each>
			</table>
		</xsl:if>
		
		<xsl:if test="child::feature">
			<h3>Features</h3>
				<!-- with passed custom sorting? -->
				<table class='results sortable' width='100%'>
					<tr>
						<th>Issue In</th>
						<th>Updated In</th>
						<th>Pertains</th>
						<th>Entered</th>
						<th>Flagged</th>
						<th>Project</th>
						<th  width="40%">Description</th>
					</tr>
				<xsl:for-each select="bug">
					
					<xsl:variable name="link">
						<xsl:value-of select="id"/>
					</xsl:variable>
					
					<tr>
						<td><xsl:value-of select="issueInBuild"/></td>
						<td><xsl:value-of select="resolvedInBuild"/></td>
						<td><xsl:value-of select="pertainsTo"/></td>
						<td><xsl:value-of select="dateEntered"/></td>
						<td><xsl:value-of select="flagged"/></td>
						<td><xsl:value-of select="project"/></td>
						<td><a href="?id={$link}"><xsl:value-of select="description"/></a></td>
					</tr>
				</xsl:for-each>
			</table>
		</xsl:if>
	</xsl:template>
</xsl:transform>