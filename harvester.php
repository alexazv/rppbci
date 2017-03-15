<?php 

include('inc/config.php');             
include('inc/functions.php');

//$oaiUrl   = 'http://openscholarship.wustl.edu/do/oai/';
//$oaiUrl   = 'http://www.seer.ufal.br/index.php/cir/oai';
$oaiUrl = $_GET["oai"];
$client_harvester = new \Phpoaipmh\Client(''.$oaiUrl.'');
$myEndpoint = new \Phpoaipmh\Endpoint($client_harvester);


// Result will be a SimpleXMLElement object
$identify = $myEndpoint->identify();
echo '<pre>';
print_r($identify);

// Results will be iterator of SimpleXMLElement objects
$results = $myEndpoint->listMetadataFormats();
$metadata_formats = [];
foreach($results as $item) {
    $metadata_formats[] = $item->{"metadataPrefix"};
}

if (in_array("nlm", $metadata_formats)) { 
    $recs = $myEndpoint->listRecords('nlm');
    foreach($recs as $rec) {
        
        //print_r($rec);

        if ($rec->{'header'}->attributes()->{'status'} != "deleted"){
        
            $sha256 = hash('sha256', ''.$rec->{'header'}->{'identifier'}.'');

            
            $query["doc"]["source"] = (string)$rec->{'metadata'}->{'article'}->{'front'}->{'journal-meta'}->{'journal-title'};
            $query["doc"]["harvester_id"] = (string)$rec->{'header'}->{'identifier'};
            if (isset($_GET["tag"])) {
                $query["doc"]["tag"] = $_GET["tag"];
            }            
            $query["doc"]["tipo"] = (string)$rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'article-categories'}->{'subj-group'}->{'subject'};
            $query["doc"]["titulo"] = str_replace('"','',(string)$rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'title-group'}->{'article-title'});
            $query["doc"]["ano"] = (string)$rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'pub-date'}[0]->{'year'};
            $query["doc"]["doi"] = (string)$rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'article-id'}[1];
            $query["doc"]["resumo"] = str_replace('"','',(string)$rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'abstract'}->{'p'});
            
            // Palavras-chave 
            foreach ($rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'kwd-group'}[0]->{'kwd'} as $palavra_chave) {
                $palavraschave_array = explode(".", (string)$palavra_chave);
                foreach ($palavraschave_array  as $pc) {
                    $query["doc"]["palavras_chave"][] = trim($pc);
                }
                        
            }
            
            $i = 0;
            foreach ($rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'contrib-group'}->{'contrib'} as $autores) {

                if ($autores->attributes()->{'contrib-type'} == "author"){

                    $query["doc"]["autores"][$i]["nomeCompletoDoAutor"] = (string)$autores->{'name'}->{'given-names'}.' '.$autores->{'name'}->{'surname'};
                    $query["doc"]["autores"][$i]["nomeParaCitacao"] = (string)$autores->{'name'}->{'surname'}.', '.$autores->{'name'}->{'given-names'};

                    if(isset($autores->{'aff'})) {
                        $query["doc"]["autores"][$i]["afiliacao"] = (string)$autores->{'aff'};
                    }              
                    if(isset($autores->{'uri'})) {
                        $query["doc"]["autores"][$i]["nroIdCnpq"] = (string)$autores->{'uri'};
                    }  
                    $i++;
                }
            }             
            
            $query["doc"]["artigoPublicado"]["tituloDoPeriodicoOuRevista"] = str_replace('"','',(string)$rec->{'metadata'}->{'article'}->{'front'}->{'journal-meta'}->{'journal-title'});
            $query["doc"]["artigoPublicado"]["nomeDaEditora"] = (string)$rec->{'metadata'}->{'article'}->{'front'}->{'journal-meta'}->{'publisher'}->{'publisher-name'};
            $query["doc"]["artigoPublicado"]["issn"] = (string)$rec->{'metadata'}->{'article'}->{'front'}->{'journal-meta'}->{'issn'};
            $query["doc"]["artigoPublicado"]["volume"] = (string)$rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'volume'};
            $query["doc"]["artigoPublicado"]["fasciculo"] = (string)$rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'issue'};
            $query["doc"]["artigoPublicado"]["paginaInicial"] = (string)$rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'issue-id'};
            $query["doc"]["artigoPublicado"]["serie"] = (string)$rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'issue-title'};
            $query["doc"]["url_principal"] = (string)$rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'self-uri'}->attributes('http://www.w3.org/1999/xlink');
            
            $query["doc_as_upsert"] = true;
            
            
            foreach ($rec->{'metadata'}->{'article'}->{'front'}->{'article-meta'}->{'self-uri'} as $self_uri) {
                $query["doc"]["relation"][]=(string)$self_uri->attributes('http://www.w3.org/1999/xlink');
            }
              
            //print_r($query);

            $resultado = elasticsearch::elastic_update($sha256,$type,$query);
            print_r($resultado);
            
            unset($query);
            flush();

        }
    }    

    
    
} elseif (in_array("oai_dc", $metadata_formats))  {
    echo "Tem oai_dc";
    $recs = $myEndpoint->listRecords('oai_dc');    
    foreach($recs as $rec) {
        if ($rec->{'header'}->attributes()->{'status'} != "deleted"){
            print_r($rec->{'metadata'});
        }
    }
    
} else {
    echo "Este repositório não possui um formato compatível";
}

?>