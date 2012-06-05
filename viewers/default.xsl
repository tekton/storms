<?xml version="1.0" encoding="UTF-8" ?>
<!--
	entries_all
	Created by TAgee on 2012-04-26.
	Copyright (c) 2012 Tyler Agee. All rights reserved.
-->

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/>
	<xsl:include href="./head.xsl"/>
	<xsl:include href="./nl2br.xsl"/>
	<xsl:template match="/">
		<html>
			<head>
				<title>storms - all entries</title>
				<xsl:call-template name="scripts"/>
			</head>
			<body>       
                            <div class="bodytext">
                                    <div class="default-text"><span class="pyroturtle"><span class="pt_red">pyro</span><span class="pt_green">turtle</span>.com</span></div>
                                    <div id="pt_stuff"><a href="ga">graphearithmos</a> | <a href="blog">blog</a></div>
                                    <div id="dt"><a href="http://darrgotek.com/">darrgotek.com</a> |
                                    <span class="tektonsnow"><a href="http://tektonsnow.com/">TektonSnow.com</a></span></div>
                                    <div id="projects">
                                            <span><a href="http://darrgotek.com/h1r0">H1R0</a></span> |
                                            <span><a href="http://darrgotek.com/ComicRate">ComicRate</a></span> |
                                            <span><a href="http://tektonsnow.com/storms">Storms</a></span>
                                    </div>
                                    <div id="resumes">
                                            <span><a href="resumes/TAGEE - Resume - Hybrid.pdf">PDF</a> | <a href="resumes/TAGEE - Resume - Hybrid.doc">Word</a></span>
                                    </div>
                                    <div id="social_links">
                                            <span><a href="http://linkedin.com/in/tyleragee">LinkedIn</a> | <a href="http://github.com/tekton">github</a></span>
                                    </div>
                                    <div id="random_info">
                                            edited with <span class="strike">pico</span> nano
                                    </div>
                            </div>
			</body>
		</html>
	</xsl:template>
	
	<xsl:template name="entries">
		<xsl:variable name="url">
			<xsl:value-of select="/root/urlBase/text()" />
		</xsl:variable>
		<xsl:for-each select="/root/entries/entry">
			<tr>
				<td><a href="{$url}/entry/show/{id}"><span class="ui-icon ui-icon-search">S</span></a></td>
				<td><a href="{$url}/entry/migrate/{id}"><span class="ui-icon ui-icon-gear">M</span></a></td>
				<td><a href="{$url}/entry/edit/{id}"><span class="ui-icon ui-icon-wrench">E</span></a></td>
				<td><xsl:value-of select="name" /></td>
			</tr>
		</xsl:for-each>
	</xsl:template>
	
</xsl:stylesheet>