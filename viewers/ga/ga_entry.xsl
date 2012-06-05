<?xml version="1.0" encoding="UTF-8" ?>
<!--
	entry
	Created by TAgee on 2012-04-27.
	Copyright (c) 2012 Tyler Agee. All rights reserved.
-->

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output encoding="UTF-8" indent="yes" method="html" />
	<xsl:include href="../head.xsl"/>
	<xsl:include href="../nl2br.xsl"/>
	<xsl:template match="/">
		<html>
                <head>
                    <title>graphe|arithmos</title>
                    <xsl:variable name="url">
                        <xsl:value-of select="/root/urlBase/text()" />
                    </xsl:variable>

                    <link rel="stylesheet" href="{$url}/assets/css/start/jquery-ui-1.8.18.custom.css" type="text/css" media="all" />
                    <link rel="stylesheet" href="{$url}/assets/css/ga.css" type="text/css" media="all" />

                    <script type="text/javascript">
                        var url_base = "<xsl:value-of select="$url"/>";
                    </script>

                    <script src="{$url}/assets/js/jquery-1.7.1.min.js" type="text/javascript"></script>
                    
                    <script src="{$url}/assets/js/ga/verses.js" type="text/javascript"></script>
                    <script src="{$url}/assets/js/books.js" type="text/javascript"></script>
                </head>
                <body>
                    <div id="logo">
                        <a>
                            <xsl:attribute name="href"><xsl:value-of select="/root/urlBase/text()" />/ga/</xsl:attribute> 
                            graphe<b>arithmos</b>
                        </a>
                    </div>
                    <div id="container" class="ui-widget ui-widget-content">
                        <xsl:call-template name="verses"/>
                        <xsl:call-template name="body"/>
                    </div>
                </body>
        </html>
	</xsl:template>
	
	<xsl:template name="body">
            <div id="content" class="ui-widget">
                <div id="entry_container">
                    <div id="title_head" class="ui-widget-header p5"><!--<span id="post_title" class="ui-icon ui-icon-wrench"></span>-->
                    <span id="title"><xsl:value-of select="/root/entry/title"/></span></div>
                    <div id="body_container" class="ui-widget-content p5">
                        <!--<span id="post_body" class="ui-icon ui-icon-wrench"></span>-->
                        <span id="body"><xsl:call-template name="nl2br">
                            <xsl:with-param name="string" select="/root/entry/body/text()" />
                        </xsl:call-template></span>
                    </div>
                </div>
            </div>
	</xsl:template>
	
	<xsl:template name="tags">
		<xsl:variable name="url">
			<xsl:value-of select="/root/urlBase/text()" />
		</xsl:variable>
		<div id="tags" class="information ui-widget ui-widget-content">
			<div class="information_top">Tags</div>
			<div id="tags_list">
				<table id="tags_list_table">
					<xsl:for-each select="/root/entry/tags/tag">
						<tr class='tag'>
							<td class='tag'><xsl:value-of select="@name"/></td>
							<td class='tag'><xsl:value-of select="@value"/></td>
						</tr>
					</xsl:for-each>
				</table>
			</div>
			<xsl:variable name="id">
				<xsl:value-of select="/root/entry/id" />
			</xsl:variable>	
			<div id="tag-dialog-form" title="Add a tag">
				<form method="post" action="{$url}/tags/new/{$id}">
					<input type="hidden" id="id" value="{$id}" name="id" />
					<table>
					<tr><td>Name</td><td><input type="text" name="name" id="name"/></td></tr>
					<tr><td>Value</td><td><input type="text" name="value" id="value"/></td></tr>
					</table>
				</form>
			</div>
			<button id="add-tag" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Add Tag</button>
		</div>
                
	</xsl:template>
	
        <xsl:template name="verses">
                        <xsl:variable name="id">
                            <xsl:value-of select="/root/entry/id" />
			</xsl:variable>	
                        <input type="hidden" id="id" value="{$id}" name="id" />
            <div id="verses" class="ui-widget">
                <div class="ui-widget-header p5">Verses</div>
                <div id="verses_linked" class="ui-widget-content p5"></div>
                <!--<div class="aRight"><button id="add-verse"
                        class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Add Reference </button></div>
                <div id="verse-dialog-form" title="Verse Reference">
                    <p class="validateTips"></p>
                    <form>
                        <fieldset>
                            <table id="verses_table" class="ui-widget ui-widget-content">
                                <thead>
                                    <tr>
                                        <th>Book</th>
                                        <th>Chapter</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </fieldset>
                    </form>
                </div>-->

            </div>
        </xsl:template>
        
</xsl:stylesheet>
