<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="html"/>

  <xsl:param name='sortColumn'>id</xsl:param>
  <xsl:param name='sortOrder'>ascending</xsl:param>
  <xsl:param name='sortType'>text</xsl:param>

  <xsl:template match="/">
    <xsl:apply-templates/>
  </xsl:template>

  <xsl:template match="datos">
    <xsl:apply-templates/>
  </xsl:template>

  <xsl:template match="sorttable">
    <p>Pulsando sobre la cabecera de una columna, se ordenan los datos por dicha columna o se cambia el criterio del orden, entre ascendente y descendente.</p>
    <table>
      <xsl:if test="@name">
        <caption><xsl:value-of select="@name"/></caption>
      </xsl:if>
      <xsl:apply-templates/>
    </table>
  </xsl:template>

  <xsl:template match="rowname">
    <thead>
      <xsl:apply-templates/>
    </thead>
  </xsl:template>

  <xsl:template match="rowset">
    <tbody>
      <xsl:choose>
        <xsl:when test="$sortType='date'">
          <xsl:for-each select="row">
            <xsl:sort select="concat(substring(*[name()=$sortColumn], 7, 4), substring(*[name()=$sortColumn], 4, 2), substring(*[name()=$sortColumn], 1, 2))" order="{$sortOrder}"/>
            <tr class="filaimpar">
              <xsl:if test="(position() mod 2) = 0">
                <xsl:attribute name="class">filapar</xsl:attribute>
              </xsl:if>
              <xsl:apply-templates/>
            </tr>
          </xsl:for-each>
        </xsl:when>
        <xsl:when test="$sortType='reg'">
          <xsl:for-each select="row">
            <xsl:sort select="concat(substring-after(*[name()=$sortColumn], '/'), substring-before(*[name()=$sortColumn], '/'))" order="{$sortOrder}"/>
            <tr class="filaimpar">
              <xsl:if test="(position() mod 2) = 0">
                <xsl:attribute name="class">filapar</xsl:attribute>
              </xsl:if>
              <xsl:apply-templates/>
            </tr>
          </xsl:for-each>
        </xsl:when>
        <xsl:when test="$sortType='number'">
          <xsl:for-each select="row">
            <xsl:sort select="translate(translate(*[name()=$sortColumn], '.', ''), ',', '.')" order="{$sortOrder}" data-type="{$sortType}" lang="es"/>
            <tr class="filaimpar">
              <xsl:if test="(position() mod 2) = 0">
                <xsl:attribute name="class">filapar</xsl:attribute>
              </xsl:if>
              <xsl:apply-templates/>
            </tr>
          </xsl:for-each>
        </xsl:when>
        <xsl:otherwise>
          <xsl:for-each select="row">
            <xsl:sort select="*[name()=$sortColumn]" order="{$sortOrder}" data-type="text" lang="es"/>
            <tr class="filaimpar">
              <xsl:if test="(position() mod 2) = 0">
                <xsl:attribute name="class">filapar</xsl:attribute>
              </xsl:if>
              <xsl:apply-templates/>
            </tr>
          </xsl:for-each>
        </xsl:otherwise>
      </xsl:choose>
    </tbody>
  </xsl:template>

  <xsl:template match="rowfooter">
    <tfoot>
      <xsl:apply-templates/>
    </tfoot>
  </xsl:template>

  <xsl:template match="rowname/row">
    <tr>
      <xsl:apply-templates/>
    </tr>
  </xsl:template>

  <xsl:template match="rowset/row">
    <xsl:apply-templates/>
  </xsl:template>

  <xsl:template match="rowfooter/row">
    <tr class="footTabla">
      <xsl:apply-templates/>
    </tr>
  </xsl:template>

  <xsl:template match="rowname/row/*">
    <xsl:variable name="direction">
      <xsl:if test="$sortOrder = 'ascending'">tableSortDown</xsl:if>
      <xsl:if test="$sortOrder = 'descending'">tableSortUp</xsl:if>
    </xsl:variable>
    <th columnName="{name()}" columnType="{@type}" class="tableColumn">
      <xsl:if test="$sortColumn = name()">
        <xsl:attribute name="class">tableColumn <xsl:value-of select="$direction" /></xsl:attribute>
      </xsl:if>
	  <xsl:apply-templates/>
    </th>
  </xsl:template>

  <xsl:template match="rowset/row/* | rowfooter/row/*">
    <td>
      <xsl:copy-of select="@*"/>
      <xsl:apply-templates/>
    </td>
  </xsl:template>

  <xsl:template match="a | b | i | u | pre | hr | table | th | td | tr">
    <xsl:copy>
      <xsl:copy-of select="@*"/>
      <xsl:apply-templates/>
    </xsl:copy>
  </xsl:template>

</xsl:stylesheet>