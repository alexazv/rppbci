<?php
//include 'functions.php';
include  'config.php';


/**
*@author Alexandre Azevedo
**/
class Google
{
		
	static function youtube_search($urls, $id, $verbose){
		global $youtube;
		$video_count = 0;

		foreach ((array)$urls as $url) {
	            $url_limpa = str_replace("http://", "", $url);
	            $url_limpa = str_replace("https://", "", $url_limpa);

	            

	            //try{
					$searchResponse = $youtube->search->listSearch('snippet', 
																	array(
		      														'q' => $url_limpa,
		      														'maxResults' => 10,
		      														'order' => 'date',
		      														'publishedAfter' => '2015-01-01T00:00:00Z',
		      														'type' => 'video'
		      														));

					
					//echo var_dump($searchResponse);

					//$response_array = json_decode($searchResponse);

					$video_count += $searchResponse["pageInfo"]["totalResults"];//$response_array->{"pageinfo"}->{"totalResults"};

					      //$videos .= sprintf('<li>%s (%s)</li>',
					      //$searchResult['snippet']['title'], $searchResult['id']['videoId']);      
					
				


			if($verbose == True){
				echo '<table class="uk-table"><caption>Vídeos no Youtube</caption>';        
	            echo '<thead>
	                    <tr>                
	                        <th>Total</th>
	                    </tr>
	                </thead>';
	            echo '<tbody>
	                    <tr>
	                        <td>'.$video_count.'</td>

	                  </tbody>';   
	            echo '</table><br/>';


					//TODO: Make errors specific
					/*}catch (Google_Service_Exception $e) {
					    echo 'Google Service Exception';
					  } catch (Google_Exception $e) {
					    echo 'exception';
					  }*/
			}
		}

		$body["doc"]["youtube"]["video_count"] = $video_count;
		$body["doc"]["youtube"]["date"] = date("Y-m-d");
		$body["doc_as_upsert"] = true;
				  
		elasticsearch::elastic_update($id, "journals", $body);
	}

	static function google_plus_search($urls, $id, $verbose){
				global $plus;
				$totalActivities = 0;
				foreach ((array)$urls as $url) {
			            $url_limpa = str_replace("http://", "", $url);
			            $url_limpa = str_replace("https://", "", $url_limpa);

			            $params = array(
			              'query' => $url_limpa,
			              'orderBy' => 'recent',
			              'maxResults' => '20'
			            );
			            $activities = 0;
			            $results = $plus->activities->search($params);

			            
			            $activities += count($results["items"]);

			            //echo var_dump($results);

			            while(count($results["items"]) > 0){
			            	$params['pageToken'] = $results["nextPageToken"];
			            	$results = $plus->activities->search($params);

			            	$activities += count($results["items"]);
			            	if($activities >= 100){
			            		break;
			            	}
			            }

			            /*foreach($results['items'] as $result) {
			              print "Result: {$result['object']['content']}\n";
			            }*/

			            if($verbose == True){
						 echo '<table class="uk-table"><caption>Atividades no Google+</caption>';        
		            echo '<thead>
		                    <tr>                
		                        <th>Total</th>
		                    </tr>
		                </thead>';
		            echo '<tbody>
		                    <tr>
		                        <td>'.$activities.'</td>

		                  </tbody>';   
		            echo '</table><br/>';


					}
				$totalActivities += $activities;
		}

		$body["doc"]["google_plus"]["activities"] = $totalActivities;
				  elasticsearch::elastic_update($id, "journals", $body);
	}	
}

class Twitter_API{

	static function twitter_search($urls, $id, $verbose){
		global $twitter;

		$totalRetweet_count = 0;
		$totalFavorite_count = 0;
		$totalTweet_count = 0;

		foreach ((array)$urls as $url) {
	            $url_limpa = str_replace("http://", "", $url);
	            $url_limpa = str_replace("https://", "", $url_limpa);
	            //$url_limpa = '"https://www.omgvip.com/jc-caylen/" -filter:retweets'
	            //$query = '"' .$url. '" "'.$url_limpa.'""  -filter:retweets';

	            $query = $url_limpa.' -filter:retweets';
								
	            //try{
					$searchResponse = $twitter->search(['q' => $query,
														'count' => 100]);

					$retweet_count = 0;
					$favorite_count = 0;
					$tweet_count = count($searchResponse);

					
					foreach ($searchResponse as $status) {
					
						$retweet_count+=$status->retweet_count;
						$favorite_count+=$status->favorite_count;
					}    
							
				if($verbose == True){
				 echo '<table class="uk-table"><caption>Twitter Response for '.$query.'</caption>';        
            echo '<thead>
                    <tr>                
                        <th>Total</th>
                    </tr>
                </thead>';


                	echo '<tbody>
                        <tr>
                            <td>.'.$tweet_count.' Pessoas Tweetaram sobre</td>

                      </tbody>';

                     
                      echo '<tbody>
                        <tr>
                            <td>.'.$retweet_count.' Retweets no Total</td>

                      </tbody>';

                      echo '<tbody>
                        <tr>
                            <td>.'.$favorite_count.' Curtidas no Total</td>

                      </tbody>';
                }
                      

                echo '<thead>
                    <tr>                
                        <th> </th>
                    </tr>
                </thead>';




				//TODO: Make errors specific
				/*}catch (Google_Service_Exception $e) {
				    echo 'Google Service Exception';
				  } catch (Google_Exception $e) {
				    echo 'exception';
				  }*/


		$totalRetweet_count += $retweet_count;
		$totalFavorite_count += $favorite_count;
		$totalTweet_count += $totalTweet_count;
		}
		$body["doc"]["twitter"]["tweet_count"] = $totalTweet_count;
			      $body["doc"]["twitter"]["retweet_count"] = $totalRetweet_count;
			      $body["doc"]["twitter"]["favorite_count"] = $totalFavorite_count;
			      $body["doc"]["twitter"]["date"] = date("Y-m-d");
			      $body["doc_as_upsert"] = true;
			      
			      elasticsearch::elastic_update($id, "journals", $body);

	}

}
?>