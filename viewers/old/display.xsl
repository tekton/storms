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
    <xsl:include href="./xsl/nl2br.xsl"/> 
    <xsl:include href="./xsl/top.xsl"/> 
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
                            <th>Type</th>
                            <th>Build In/Mod</th>
                            <th>Milestones</th>
                            <!--<th>Updated In</th>-->
                            <th>Pertains To</th>
                            <th width='10%'>Entered</th>
                            <!--<th width='10%'>Modified</th>-->
                            <th>Flagged</th>
                            <th>Project</th>
                            <th>Issue</th>
                    </tr>

            <xsl:for-each select="result">
                    <xsl:variable name="link">
                            <xsl:value-of select="id"/>
                    </xsl:variable>

                    <tr id="{$link}">
                            <td class="fpType_table"><xsl:value-of select="type"/></td>
                            <td class="fpBuild_table" style="text-align: center;"><xsl:value-of select="inBuild"/> / <xsl:value-of select="resolved"/></td>
                            <td class="fpMilestones_table"><xsl:value-of select="milestones"/></td>
                            <td class="fpBuild_table"><xsl:value-of select="pertains"/></td>
                            <td class="fpDate_table"><xsl:value-of select="entered"/></td>
                            <!--<td class="fpDate_table"><xsl:value-of select="modified"/></td>-->
                            <td class="fpDate_table"><xsl:value-of select="flagged"/></td>
                            <td class="fpDate_table"><xsl:value-of select="project"/></td>
                            <td class="fpTitle_table"><a href="?id={$link}"><xsl:value-of select="name"/></a></td>
                    </tr>
            </xsl:for-each>
            </table>
    </xsl:template>
</xsl:transform>