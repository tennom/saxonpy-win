from tempfile import mkstemp
import pytest
from saxonc import *
import os


@pytest.fixture
def saxonproc2():
    return PySaxonProcessor(license=True)


def testValidator2(saxonproc2):
    saxonproc2.set_cwd('.')
    saxonproc2.set_configuration_property("xsdversion", "1.1")
    val = saxonproc2.new_schema_validator()
    assert val is not None
    print(type(val))
    print(val.exception_occurred())
    invalid_xml = "<?xml version='1.0'?><request><a/><!--comment--></request>"
    sch1 = "<xs:schema xmlns:xs='http://www.w3.org/2001/XMLSchema' elementFormDefault='qualified' attributeFormDefault='unqualified'><xs:element name='request'><xs:complexType><xs:sequence><xs:element name='a' type='xs:string'/><xs:element name='b' type='xs:string'/></xs:sequence><xs:assert test='count(child::node()) = 3'/></xs:complexType></xs:element></xs:schema>"
    input_ = saxonproc2.parse_xml(xml_text=invalid_xml)
    assert input_ is not None
    print(type(input_))
    val.set_source_node(input_)
    val.register_schema(xsd_text=sch1)
    val.validate()
    assert val.exception_occurred()


def testValdiator3(saxonproc2):
    saxonproc2.set_configuration_property("xsdversion", "1.1")
    val = saxonproc2.new_schema_validator()
    
    val.register_schema(xsd_file="family-ext.xsd")

    val.register_schema(xsd_file="family.xsd")
    val.validate(file_name="family.xml")
    nodea = val.validation_report

    assert val.exception_occurred()
    assert nodea is None

def release(saxonproc):
   saxonproc.release()
