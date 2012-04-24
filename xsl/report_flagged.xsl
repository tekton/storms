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
		<h3>Entered</h3>
			<!-- with passed custom sorting? -->
		<table class='results sortable' width='100%'>
			<xsl:for-each select="entered">
				<tr>
					<td><xsl:value-of select="type"/></td>
					<td><xsl:value-of select="issueInBuild"/></td>
					<td><xsl:value-of select="resolvedInBuild"/></td>
					<td><xsl:value-of select="pertainsTo"/></td>
					<td><xsl:value-of select="dateEntered"/></td>
					<td><xsl:value-of select="project"/></td>
					<td><xsl:value-of select="description"/></td>
				</tr>
			</xsl:for-each>
		</table>		
	</xsl:template>
</xsl:transform>