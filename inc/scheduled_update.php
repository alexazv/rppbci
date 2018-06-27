<?php

include 'config.php'
include 'functions_additional.php'
include 'functions.php'

static function update_metrics() 
    {
        global $index;
        global $type;
        global $client;
        $query = '{
                    "query": {
                        "match_all": {}
                     },                
                    "sort" : [
                        {"facebook.date" : {"order" : "asc"}}
                        ]
                    }';
        
        $params = [];
        $params["index"] = $index;
        $params["type"] = $type;
        $params["size"] = 50; //change
        $params["body"] = $query;        
        
        $data = $client->search($params);  
        //print_r($data);
        foreach ($data["hits"]["hits"] as $r) 
{            if (!empty($r["_source"]['doi'])){
            	altmetric_com::get_altmetrics($r["_source"]['doi'], $r["_id"]);
             	
            	$dois[] = $r["_source"]['doi'];
            	Facebook::facebook_doi($dois, $r["_id"]);
            	unset($dois);
			}

            Twitter_API::twitter_search($r["_source"]['relation'],$r["_id"]);
            Google::youtube_search($r["_source"]['relation'],$r["_id"]);?
            Google::google_plus_search($r["_source"]['relation'],$r["_id"]);
              
            Facebook::facebook_data($r["_source"]['relation'],$r["_id"]);
                      
            if(isset($r["_source"]['div_cientifica'])){
            	foreach ($r["_source"]['div_cientifica'] as $div_source) {
            		$url_array[] = $div_source['url'];
            	}
            }
                          
        	Facebook::facebook_divulgacao($url_array,$r["_id"]);                              
        }     
    }

static function update_twitter() 
    {
        global $index;
        global $type;
        global $client;
        $query = '{
                    "query": {
                        "match_all": {}
                     },                
                    "sort" : [
                        {"twitter.date" : {"order" : "asc"}}
                        ]
                    }';
        
        $params = [];
        $params["index"] = $index;
        $params["type"] = $type;
        $params["size"] = 7; //change
        $params["body"] = $query;        
        
        $data = $client->search($params);  
        //print_r($data);
        foreach ($data["hits"]["hits"] as $r) {            
            Twitter_API::twitter_search($r["_source"]['relation'],$r["_id"]);                 
        }     
    }