<?xml version="1.0" encoding="UTF-8" ?>
<!--
	comments
	Created by TAgee on 2012-04-27.
	Copyright (c) 2012 Tyler Agee. All rights reserved.
-->

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output encoding="UTF-8" indent="yes" method="html" />

	<xsl:template name="comments">
		<div>
			
		</div>
		
		<div id="comments_tabs">
			<ul>
				<li><a href="#comments">Comments</a></li>
				<li><a href="#SystemMessages">System Messages</a></li>
				<li><a href="#Combined">Combined</a></li>
			</ul>
			<div id="comments">
				<xsl:for-each select="/root/entry/comments/comment">
					<div>
						<div class="comment_top"><span class="comment_top_data">(<xsl:value-of select="id" /> :
						<xsl:value-of select="pertainsTo" />)
						<xsl:value-of select="title" /></span></div>
						<div class="comment_data">
							<xsl:call-template name="nl2br">
			                        <xsl:with-param name="string" select="description/text()" />
			                </xsl:call-template>
						</div>
					</div>
				</xsl:for-each>
			</div>
			<div id="SystemMessages"> </div>
			<div id="Combined"> </div>
		</div>
		
		<script>
			$(function() {
					$( "#comments_tabs" ).tabs();
				});
		</script>
		
	</xsl:template>
</xsl:stylesheet>
