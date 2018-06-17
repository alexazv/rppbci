<?php
//include 'functions.php';
include  'config.php';


/**
*@author Alexandre Azevedo
**/
class Google
{
		
	static function youtube_search($urls, $id){
		global $youtube;

		foreach ($urls as $url) {
	            $url_limpa = str_replace("http://", "", $url);
	            $url_limpa = str_replace("https://", "", $url_limpa);

	            $video_count = 0;

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


			      //$body["doc"]["youtube"]["fb".0] = ${"fb" . 0};
				  $body["doc"]["youtube"]["reaction_count"] = $video_count;
				  $body["doc"]["youtube"]["date"] = date("Y-m-d");
				  $body["doc_as_upsert"] = true;
				  
				  elasticsearch::elastic_update($id, "journals", $body);

		}
	}
}

class Twitter_API{

	static function twitter_search($urls, $id){
		global $twitter;


		foreach ($urls as $url) {
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

					
					foreach ($searchResponse as $status) {
					
						$retweet_count+=$status->retweet_count;
						$favorite_count+=$status->favorite_count;
					}

					//$response_array = json_decode($searchResponse);

					//$video_count += $searchResponse["pageinfo"]["totalResults"];//$response_array->{"pageinfo"}->{"totalResults"};

					      //$videos .= sprintf('<li>%s (%s)</li>',
					      //$searchResult['snippet']['title'], $searchResult['id']['videoId']);      
					
				

				 echo '<table class="uk-table"><caption>Twitter Response for '.$query.'</caption>';        
            echo '<thead>
                    <tr>                
                        <th>Total</th>
                    </tr>
                </thead>';


                	echo '<tbody>
                        <tr>
                            <td>.'.count($searchResponse).' Pessoas Tweetaram sobre</td>

                      </tbody>';

                      /*echo '<tbody>
                        <tr>
                            <td>.'.var_dump($searchResponse).' Retweets no Total</td>

                      </tbody>';*/

                      echo '<tbody>
                        <tr>
                            <td>.'.$retweet_count.' Retweets no Total</td>

                      </tbody>';

                      echo '<tbody>
                        <tr>
                            <td>.'.$favorite_count.' Curtidas no Total</td>

                      </tbody>';

                      

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


			      //$body["doc"]["youtube"]["fb".0] = ${"fb" . 0};
				  /*$body["doc"]["youtube"]["reaction_count"] = $video_count;
				  $body["doc"]["youtube"]["date"] = date("Y-m-d");
				  $body["doc_as_upsert"] = true;
				  
				  elasticsearch::elastic_update($id, "journals", $body);
				  */

		}
	}

}


?>