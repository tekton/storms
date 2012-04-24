<?xml version="1.0" encoding="UTF-8" ?>
<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/1999/xhtml">
	<xsl:template name="nl2br">
		<xsl:param name="string"/>

                <xsl:choose>
                <xsl:when test="contains($string,'&#xa;')">
                    <div><xsl:value-of select="substring-before($string,'&#xa;')"/>&#160;</div>
                    
                    <xsl:call-template name="nl2br">
                        <xsl:with-param name="string" 
                            select="substring-after($string,'&#xa;')"/>
                    </xsl:call-template>
                </xsl:when>
                <xsl:otherwise>
                    <div><xsl:value-of select="$string"/></div>
                </xsl:otherwise>
                </xsl:choose>
	</xsl:template>
	
	<xsl:template name="commentInput">
		<xsl:for-each select="commentInput">
			<form action="index.php?id={$id}" method="POST">
			<div class="comment_top"><input type="text" id="comment_title" name="comment_title" /></div>
			<div class="comment_data">
				<textarea name="comment_text" rows="5" cols="60"></textarea>
			</div>
			<input type="hidden" name="id" id="id" value="{$id}" />
			<input type="hidden" name="newComment" id="newComment" value="true" />
			<input type="submit" />
			</form>
		</xsl:for-each>
	</xsl:template>
</xsl:transform>