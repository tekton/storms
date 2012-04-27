<?xml version="1.0" encoding="UTF-8" ?>
<!--
	untitled
	Created by Tyler Agee on 2009-02-15.
	Copyright (c) 2009 Tyler Agee. All rights reserved.
-->
<ParameterBinding Name="url_PATH_INFO" Location="ServerVariable(PATH_INFO)" DefaultValue=""/>
<ParameterBinding Name="url_HTTP_HOST" Location="ServerVariable(HTTP_HOST)" DefaultValue=""/>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output encoding="UTF-8" indent="yes" method="xml" />

	<xsl:param name="url_PATH_INFO" />
	<xsl:param name="url_HTTP_HOST" />
	<xsl:variable name="CurrentPageUrl" select="concat('http://',$url_HTTP_HOST,$url_PATH_INFO)" />

	<xsl:template match="/">
		<xsl:value-of select="{$CurrentPageUrl}"/>
	</xsl:template>
</xsl:stylesheet>
