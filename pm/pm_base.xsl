<?xml version="1.0" encoding="UTF-8" ?>
<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/1999/xhtml">
	<xsl:output method="html" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/>
	
	<xsl:include href="../xsl/nl2br.xsl"/>
	<xsl:include href="../xsl/users.xsl"/>
	
	<xsl:template match="/">
		<html>
			<head>
				<title>issues test</title>
				<link rel="stylesheet" type="text/css" href="./pm/pm.css" media="screen" />
			</head>
			<body>
				<div id="left_section">
					<div class="logo">
						<xsl:variable name="imgURL" select="root/navigation/logo/@src"/>
						<img src="{$imgURL}" />
					</div>
					<div id="sections">
						<xsl:apply-templates select="root/navigation" />
					</div>
					<div id="meta">
						<div class="meta_section">Other</div>
						<div class="meta_section">Feed Link</div>
						<div class="meta_section">Login</div>
					</div>
				</div>
				<div id="right_section">
					<div class="title">
						<xsl:value-of select="root/title" />
					</div>
					
					<div class="description">
						<xsl:call-template name="nl2br">
		                        <xsl:with-param name="string" select="root/description" />
		                </xsl:call-template>
					</div>
					
					<xsl:apply-templates select="root/section" />
				</div>
			</body>
		</html>
	</xsl:template>
	
	<xsl:template name="a" match="root/navigation">
		<xsl:for-each select="section">
			<div class="{@class}">
				<a href="{@link}"><xsl:value-of select="@disp" /></a>
			</div>
		</xsl:for-each>
	</xsl:template>
	
	<xsl:template name="right" match="root/section">
		<xsl:for-each select="tag">
			<div class="tag">
				<div class="tag_title"><xsl:value-of select="title" /></div>
				<div class="tag_time">Created: <xsl:value-of select="created" /> | Modified: <xsl:value-of select="modified" /></div>
				<div class="tag_text">

						<xsl:call-template name="nl2br">
		                        <xsl:with-param name="string" select="text" />
		                </xsl:call-template>

				</div>
			</div>
		</xsl:for-each>
	</xsl:template>
	
</xsl:transform>