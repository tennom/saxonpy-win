from saxonc import *

with PySaxonProcessor(license=False) as proc:

    print("Test Python")
    print(proc.version)
    #print(dir(proc))
    xdmAtomicval = proc.make_boolean_value(False)

    xsltproc = proc.new_xslt_processor()
    outputi = xsltproc.transform_to_string(source_file="cat.xml", stylesheet_file="test.xsl")
    print("Test1 =",outputi)
    document = proc.parse_xml(xml_text="<out><person>text1</person><person>text2</person><person>text3</person></out>")
    xsltproc.set_source(xdm_node=document)
    xsltproc.compile_stylesheet(stylesheet_text="<xsl:stylesheet xmlns:xsl='http://www.w3.org/1999/XSL/Transform' version='2.0'> <xsl:param name='values' select='(2,3,4)' /><xsl:output method='xml' indent='yes' /><xsl:template match='*'><output><xsl:value-of select='//person[1]'/><xsl:for-each select='$values' ><out><xsl:value-of select='. * 3'/></out></xsl:for-each></output></xsl:template></xsl:stylesheet>")
    xsltproc.setJustInTimeCompilation(True) #Available in Saxon 9.9 library

    output2 = xsltproc.transform_to_string()
    print(output2)
    proc.release()

