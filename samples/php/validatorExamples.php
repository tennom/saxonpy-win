<!DOCTYPE html SYSTEM "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Saxon/C API design use cases</title>
    </head>
    <body>
        <?php 
            
           
            function exampleSimple1($proc, $validator){
		echo '<b>exampleSimple1:</b><br/>';	
                $validator->registerSchemaFromString("<xs:schema xmlns:xs='http://www.w3.org/2001/XMLSchema' elementFormDefault='qualified' attributeFormDefault='unqualified'><xs:element name='request'><xs:complexType><xs:sequence><xs:element name='a' type='xs:string'/><xs:element name='b' type='xs:string'/></xs:sequence><xs:assert test='count(child::node()) = 3'/></xs:complexType></xs:element></xs:schema>");

                $xml = $proc->parseXmlFromString("<Family xmlns='http://myexample/family'><Parent>John</Parent><Child>Alice</Child></Family>");
		$validator->setSourceNode($xml);
  	        $validator->setProperty('report-node', 'true');      
                $validator->validate();  
		$node = $validator->getValidationReport();
		echo 'Validation Report:'.$node->getStringValue().'<br/>';             
		if($validator->exceptionOccurred()) {
		   echo "Doc is not valid!";
			$errCount = $validator->getExceptionCount();
			if($errCount > 0 ){ 
				        for($i = 0; $i < $errCount; $i++) {
					       $errCode = $validator->getErrorCode(intval($i));
					       $errMessage = $validator->getErrorMessage(intval($i));
					       echo 'Expected error: Code='.$errCode.' Message='.$errMessage;
					   }
						$validator->exceptionClear();	
			}
			    
	        } else {
			echo "Doc is valid";
		}
		$validator->clearParameters();
		$validator->clearProperties();            
            }
            
          
            function exampleSimple2($proc, $validator){
		echo '<b>exampleSimple2:</b><br/>';	
                $validator->registerSchemaFromString("<?xml version='1.0' encoding='UTF-8'?><schema targetNamespace='http://myexample/family' xmlns:fam='http://myexample/family' xmlns='http://www.w3.org/2001/XMLSchema'><element name='FamilyMember' type='string' /><element name='Parent' type='string' substitutionGroup='fam:FamilyMember'/><element name='Child' type='string' substitutionGroup='fam:FamilyMember'/><element name='Family'><complexType><sequence><element ref='fam:FamilyMember' maxOccurs='unbounded'/></sequence></complexType></element>  </schema>");

                
  	        //$proc->setProperty('base', '/');
		$validator->setProperty('report-node', 'true');      
                $validator->registerSchemaFromFile("xsd/family-ext.xsd");  
		        
                $validator->validate("xml/family.xml");              
		if($validator->exceptionOccurred()) {
		   echo "Doc is not valid!";
		   $node = $validator->getValidationReport();
		   echo 'Validation Report:'.$node->getStringValue().'<br/>';
	        } else {
			echo "Doc family.xml is valid!";
		}
		$validator->clearParameters();
		$validator->clearProperties();            
            }

 function exampleSimple3($proc, $validator){
		echo '<b>exampleSimple3:</b><br/>';	
                $validator->registerSchemaFromFile("xsd/family-ext.xsd");
		$validator->registerSchemaFromFile("xsd/family.xsd");

		
  	        $validator->setProperty('report-node', 'true');       
                $validator->validate("xml/family.xml");              
		if($validator->exceptionOccurred()) {
		   echo "Error: Doc is not valid!";
		   $node = $validator->getValidationReport();
		   echo 'Validation Report:'.$node->getStringValue().'<br/>';
	        } else {
			echo "Doc is valid!";
		}
		$validator->clearParameters();
		$validator->clearProperties();            
            }
		
	   $var ='/usr/lib' ;
            putenv("SAXONC_HOME=$var"); 
            
            $books_xml = "query/books.xml";
            $books_to_html_xq = "query/books-to-html.xq";
            $baz_xml = "xml/baz.xml";
            $cities_xml = "xml/cities.xml";
            $embedded_xml = "xml/embedded.xml";
            // current directory

            $proc = new Saxon\SaxonProcessor(true);
	    $validator = $proc->newSchemaValidator();
		
            $version = $proc->version();
   	    echo '<b>PHP Schema Validation in Saxon/C examples</b><br/>';
            echo 'Saxon Processor version: '.$version;
            echo '<br/>';        
            exampleSimple1($proc, $validator);

            echo '<br/>';               
	    exampleSimple2($proc, $validator);
	    echo '<br/>';
	    exampleSimple3($proc, $validator);

	    unset($validator);            
            unset($proc);
	
        
        ?>
    </body>
</html>
