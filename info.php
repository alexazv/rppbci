<?php

require 'inc/config.php'; 
require 'inc/functions.php';
require 'inc/functions_additional.php';

$result_get = get::analisa_get($_GET);
//echo var_dump($result_get);

$query = $result_get['query'];
//echo var_dump($query);

$params = [];
$params["index"] = $index;
$params["body"] = $query;

$cursor = $client->search($params);

//echo var_dump($cursor);

foreach ($cursor["hits"]["hits"] as $r) {
	//Facebook::facebook_data($r["_source"]['relation'],$r["_id"]);
	//Facebook::facebook_divulgacao($url_array,$r["_id"]);
	altmetric_com::get_altmetrics($r["_source"]['doi'], $r["_id"]);
	$dois[] = $r["_source"]['doi'];
	Facebook::facebook_doi($dois, $r["_id"]);
	unset($dois);
	Twitter_API::twitter_search($r["_source"]['relation'],$r["_id"]);
	Google::youtube_search($r["_source"]['relation'],$r["_id"]);
	Facebook::facebook_data($r["_source"]['relation'],$r["_id"]);                                      
}


?>