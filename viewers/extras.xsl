<?xml version="1.0" encoding="UTF-8" ?>
<!--
	head
	Created by TAgee on 2012-06-04.
	Copyright (c) 2012 Tyler Agee. All rights reserved.
-->

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
<xsl:include href="./ga/ga_extras.xsl"/>

<xsl:output encoding="UTF-8" indent="yes" method="html" media-type="application/xhtml+xml" />

<xsl:template name="extras_right">
    <xsl:variable name="extras_template">
        <xsl:value-of select="/root/extras/side/template/text()" />
    </xsl:variable>
    
    <xsl:if test="$extras_template = 'ga_entry_extras_right'">
        <!--ga_entry_extras_right-->
        <xsl:call-template name="ga_entry_extras_right"/>
    </xsl:if>
    
</xsl:template>

</xsl:stylesheet>