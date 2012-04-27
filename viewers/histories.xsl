<?xml version="1.0" encoding="UTF-8" ?>
<!--
	histories
	Created by TAgee on 2012-04-27.
	Copyright (c) 2012 Tyler Agee. All rights reserved.
-->

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output encoding="UTF-8" indent="yes" method="html" />

	<xsl:template name="histories">
		<div></div>
		
		<p>
			<xsl:for-each select="/entry/history/history">
				<div>
					<div><xsl:value-of select="body" /></div>
					<div><span><xsl:value-of select="@id" /></span> :: <xsl:value-of select="posted" /> :: <xsl:value-of select="user" /></div>
				</div>
			</xsl:for-each>
		</p>		
	</xsl:template>
</xsl:stylesheet>
