from saxonc import *

with PySaxonProcessor(license=False) as saxonproc2:
    trans = saxonproc2.new_xslt30_processor()

    source = "<?xml version='1.0'?>  <xsl:stylesheet xmlns:xsl='http://www.w3.org/1999/XSL/Transform'  xmlns:xs='http://www.w3.org/2001/XMLSchema'  version='3.0'>  <xsl:template match='*'>     <xsl:param name='a' as='xs:double'/>     <xsl:param name='b' as='xs:float'/>     <xsl:sequence select='., $a + $b'/>  </xsl:template>  </xsl:stylesheet>"

    trans.compile_stylesheet(stylesheet_text=source)
    node = saxonproc2.parse_xml(xml_text="<e/>")

    trans.set_result_as_raw_value(True)
    trans.set_initial_template_parameters(False, {"a":saxonproc2.make_integer_value(12), "b":saxonproc2.make_integer_value(5)})
    trans.set_initial_match_selection(xdm_value=node)
    result = trans.apply_templates_returning_string()
    print(result)
    

