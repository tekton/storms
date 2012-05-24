<?xml version="1.0" encoding="UTF-8" ?>
<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/1999/xhtml">
	<xsl:template name="nl2br">
		<xsl:param name="string"/>
		<xsl:choose>
		<xsl:when test="contains($string,'&#10;')">
			<xsl:value-of select="substring-before($string,'&#10;')" disable-output-escaping="yes"/>
			<br />
			<xsl:call-template name="nl2br">
				<xsl:with-param name="string" select="substring-after($string,'&#10;')"/>
			</xsl:call-template>
		</xsl:when>
		<xsl:otherwise>
			<xsl:value-of select="$string" disable-output-escaping="yes"/>
		</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:transform>