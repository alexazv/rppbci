<!DOCTYPE html>
<?php

require 'inc/config.php'; 
require 'inc/functions.php';
require 'inc/functions_additional.php';

if (!empty($_POST)) {
    Admin::addDivulgacao($_POST["titulo"],$_POST["url"],$_POST["id"]);
}

$result_get = get::analisa_get($_GET);


$query = $result_get['query'];

$params = [];
$params["index"] = $index;
$params["body"] = $query;

$cursor = $client->search($params);

$total = $cursor["hits"]["total"];

/* Citeproc-PHP*/
require 'inc/citeproc-php/CiteProc.php';
$csl_abnt = file_get_contents('inc/citeproc-php/style/abnt.csl');
$csl_apa = file_get_contents('inc/citeproc-php/style/apa.csl');
$csl_nlm = file_get_contents('inc/citeproc-php/style/nlm.csl');
$csl_vancouver = file_get_contents('inc/citeproc-php/style/vancouver.csl');
$lang = "br";
$citeproc_abnt = new citeproc($csl_abnt, $lang);
$mode = "reference";

?>
<html>
    <head>
        <?php require 'inc/meta-header.php' ?>
        <title>Métricas do Artigo</title>
        
        <!-- D3.js Libraries and CSS -->
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/d3/3.2.2/d3.v3.min.js"></script>

        <!-- UV Charts -->
        <script type="text/javascript" src=inc/uvcharts/uvcharts.full.min.js></script>
        
        <!-- Altmetric Script -->
        <script type='text/javascript' src='https://d1bxh8uas1mnw7.cloudfront.net/assets/embed.js'></script>
        
        <!-- PlumX Script -->
        <script type="text/javascript" src="//d39af2mgp1pqhg.cloudfront.net/widget-popup.js"></script>

        
    </head>
    <body>

        <?php
        if (file_exists("inc/analyticstracking.php")) {
            include_once "inc/analyticstracking.php";
        }
        ?> 

        <div class="uk-container">

            <?php require 'inc/navbar.php' ?>
            <br/><br/><br/> 

            <div class="uk-width-1-1@s uk-width-1-1@m">


            <nav class="uk-navbar-container uk-margin" uk-navbar>
                <div class="nav-overlay uk-navbar-left">
                    <a class="uk-navbar-item uk-logo" uk-toggle="target: .nav-overlay; animation: uk-animation-fade" href="#">Clique para uma nova pesquisa</a>
                </div>
                <div class="nav-overlay uk-navbar-right">
                    <a class="uk-navbar-toggle" uk-search-icon uk-toggle="target: .nav-overlay; animation: uk-animation-fade" href="#"></a>
                </div>
                <div class="nav-overlay uk-navbar-left uk-flex-1" hidden>

                <div class="uk-navbar-item uk-width-expand">
                    <form class="uk-search uk-search-navbar uk-width-1-1">
                    <input type="hidden" name="fields[]" value="name">
                    <input type="hidden" name="fields[]" value="author.person.name">
                    <input type="hidden" name="fields[]" value="authorUSP.name">
                    <input type="hidden" name="fields[]" value="about">
                    <input type="hidden" name="fields[]" value="description">       
                    <input class="uk-search-input" type="search" name="search[]" placeholder="Nova pesquisa..." autofocus>
                    </form>
                </div>

                <a class="uk-navbar-toggle" uk-close uk-toggle="target: .nav-overlay; animation: uk-animation-fade" href="#"></a>

                </div>

            </nav>            
        
            </div>
       
            <div class="uk-width-1-1@s uk-width-1-1@m">
        
                <?php if (!empty($_SERVER["QUERY_STRING"])) : ?>                                    
                    <p class="uk-margin-top" uk-margin>
                        <a class="uk-button uk-button-default uk-button-small" href="index.php"><?php echo $t->gettext('Começar novamente'); ?></a> 
                        <?php 
                        
                            
            
                        ?>
                        
                    </p>
                <?php endif;?>      
        
            </div>       


            <div class="uk-width-3-4@s uk-width-4-6@m">               

                    
                    <hr class="uk-grid-divider">

                    <!-- Resultados -->
                    <div class="uk-width-1-1 uk-margin-top uk-description-list-line">                        
                        <ul class="uk-list uk-list-divider">   
                        <?php $conta_cit = 1; ?>    
                        <?php foreach ($cursor["hits"]["hits"] as $r) : ?>
                        
                        <li> 

                        <?php //echo var_dump($r); ?>
                    
                        <div class="uk-grid-divider uk-padding-small" uk-grid>
                            <div class="uk-width-1-5@m">
                                <a href="result.php?search[]=source.keyword:&quot;<?php echo $r["_source"]['source'];?>&quot;"><?php echo $r["_source"]['source'];?></a>                                 
                            </div>
                            <div class="uk-width-4-5@m">
                                <article class="uk-article">
                                <p class="uk-text-lead uk-margin-remove" style="font-size:115%"><a href="<?php echo $r['_source']['url_principal'];?>"><?php echo $r["_source"]['titulo'];?><?php if (!empty($r["_source"]['ano'])) { echo ' ('.$r["_source"]['ano'].')'; } ?></a></p>
                                    
                                    <ul class="uk-list uk-margin-top">
                                        <p class="uk-margin-remove">
                                            Autores:
                                            <?php if (!empty($r["_source"]['autores'])) : ?>
                                                <?php foreach ($r["_source"]['autores'] as $autores) {
                                                    $authors_array[]='<a href="result.php?search[]=autores.nomeCompletoDoAutor.keyword:&quot;'.$autores["nomeCompletoDoAutor"].'&quot;">'.$autores["nomeCompletoDoAutor"].'</a>';
                                                } 
                                                $array_aut = implode(", ",$authors_array);
                                                unset($authors_array);
                                                print_r($array_aut);
                                                ?>
                                            <?php endif; ?>                           
                                        </p>
                                        <p class="uk-margin-remove">
                                            Assuntos:
                                            <?php if (!empty($r["_source"]['palavras_chave'])) : ?>
                                            <?php foreach ($r["_source"]['palavras_chave'] as $assunto) : ?>
                                                <a href="result.php?search[]=palavras_chave.keyword:&quot;<?php echo $assunto;?>&quot;"><?php echo $assunto;?></a>
                                            <?php endforeach;?>
                                            <?php endif; ?>
                                        </p>
                                        <p class="uk-margin-remove">
                                            <?php if (!empty($r["_source"]['url_principal'])||!empty($r["_source"]['doi'])) : ?>
                                            <div class="uk-button-group" style="padding:15px 15px 15px 0;">     
                                                <?php if (!empty($r["_source"]['url_principal'])) : ?>
                                                <a class="uk-button-small uk-button-primary" href="<?php echo $r["_source"]['url_principal'];?>" target="_blank">Acesso online à fonte</a>
                                                <?php endif; ?>
                                                <?php if (!empty($r["_source"]['doi'])) : ?>
                                                <a class="uk-button-small uk-button-primary" href="http://dx.doi.org/<?php echo $r["_source"]['doi'];?>" target="_blank">Resolver DOI</a>
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                        </p>
                                        <?php if (isset($_GET["papel"])) : ?>
                                            <?php if ($_GET["papel"] == "admin") : ?>
                                                <form class="uk-form uk-form-stacked" action="result.php?search[]=" method="POST">

                                                    <fieldset data-uk-margin>
                                                        <legend>Inserir URL de divulgação científica</legend>
                                                        <div class="uk-form-row">
                                                            <label class="uk-form-label" for="">Título</label>
                                                            <div class="uk-form-controls"><input type="text" placeholder="" name="titulo" class="uk-width-1-1"></div>
                                                        </div>
                                                        <div class="uk-form-row">
                                                            <label class="uk-form-label" for="">URL</label>
                                                            <div class="uk-form-controls"><input type="text" placeholder="" name="url" class="uk-width-1-1"></div>
                                                        </div>
                                                        <input type="hidden" name="id" value="<?php echo $r['_id']; ?>">
                                                        <button class="uk-button">Enviar</button>
                                                    </fieldset>

                                                </form>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <li class="uk-h6 uk-margin-top">
                                            <p>Métricas:</p>
                                             <?php if (!empty($r["_source"]['doi'])) : ?>
                                            <ul>
                                                <li>
                                                    <div data-badge-popover="right" data-badge-type="1" data-doi="<?php echo $r["_source"]['doi'];?>" data-hide-no-mentions="true" class="altmetric-embed"></div>
                                                </li>
                                                <li>
                                                    <a href="https://plu.mx/plum/a/?doi=<?php echo $r["_source"]['doi'];?>" class="plumx-plum-print-popup" data-hide-when-empty="true" data-badge="true"></a>
                                                </li>
                                                <li>
                                                    <?php altmetric_com::get_altmetrics($r["_source"]['doi'], $r["_id"]); ?>
                                                </li>
                                                <li>
                                                    <?php $dois[] = $r["_source"]['doi']; ?>
                                                     <?php Facebook::facebook_doi($dois, $r["_id"]); ?>
                                                     <?php unset($dois); ?>
                                                </li>
                                            </ul>
                                            <?php endif; ?>

                                            <?php /*Twitter_API::twitter_search($r["_source"]['relation'],$r["_id"], True);*/

                                            echo '<table class="uk-table"><caption>Twitter Response </caption>';        
                                            echo '<thead>
                                                    <tr>                
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>';


                                                    echo '<tbody>
                                                        <tr>
                                                            <td>.'.$r['_source']['twitter']['tweet_count'].' Pessoas Tweetaram sobre</td>

                                                      </tbody>';

                                                     
                                                      echo '<tbody>
                                                        <tr>
                                                            <td>.'.$r['_source']['twitter']['retweet_count'].' Retweets no Total</td>

                                                      </tbody>';

                                                      echo '<tbody>
                                                        <tr>
                                                            <td>.'.$r['_source']['twitter']['favorite_count'].' Curtidas no Total</td>

                                                      </tbody>';
                                                      

                                                echo '<thead>
                                                    <tr>                
                                                        <th> </th>
                                                    </tr>
                                                </thead>';


                                            ?>
                                            <?php /*Google::youtube_search($r["_source"]['relation'],$r["_id"], True);*/
                                                 echo '<table class="uk-table"><caption>Vídeos no Youtube</caption>';        
                                                    echo '<thead>
                                                            <tr>                
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>';
                                                    echo '<tbody>
                                                            <tr>
                                                                <td>'.$r['_source']['youtube']['video_count'].'</td>

                                                          </tbody>';   
                                                    echo '</table><br/>';
                                            ?>
                                            <?php /*Google::google_plus_search($r["_source"]['relation'],$r["_id"], True);*/
                                            echo '<table class="uk-table"><caption>Atividades no Google+</caption>';        
                                            echo '<thead>
                                                    <tr>                
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>';
                                            echo '<tbody>
                                                    <tr>
                                                        <td>'.$r['_source']['google_plus']['activities_count'].'</td>

                                                  </tbody>';   
                                            echo '</table><br/>';


                                            ?>
                                            <ul>
                                                <li>
                                                
                                                    <?php Facebook::facebook_data($r["_source"]['relation'],$r["_id"]);?>
                                                    <!--
                                                    < ?php
                                                        if (!empty($r["_source"]['relation'])){
                                                            facebook::facebook_api_reactions($r["_source"]['relation'],$fb,$server,$r['_id']);
                                                            unset($facebook_url_array);
                                                        }
                                                    ?>
                                                    -->
                                                </li>
                                                <li>
                                                    <?php if(isset($r["_source"]['div_cientifica'])): ?>
                                                        <?php foreach ($r["_source"]['div_cientifica'] as $div_source) :?>
                                                        <?php $url_array[] = $div_source['url']; ?>
                                                        <?php endforeach; ?>
                                                        
                                                        <?php Facebook::facebook_divulgacao($url_array,$r["_id"]);?>
                                                        
                                                        <?php unset($url_array);?>
                                                    <?php endif; ?>
                                                </li>
                                                <?php if(isset($r["_source"]["aminer"]["num_citation"])): ?>
                                                        <li>
                                                            <h4>Dados da API do AMiner:</h4>
                                                            <p>Título: <a href="https://aminer.org/archive/<?php echo $r["_source"]["aminer"]["id"];?>"><?php echo $r["_source"]["aminer"]["title"]; ?></a></p>
                                                            <p>Número de citações no AMiner: <?php echo $r["_source"]["aminer"]["num_citation"]; ?></p>
                                                            <p>
                                                            <?php 
                                                            
                                                            if (!empty($r["_source"]["aminer"]["doi"])) {
                                                                echo 'DOI: '.$r["_source"]["aminer"]["doi"].'<br/>';
                                                            }                                           
                                                            if (!empty($r["_source"]["aminer"]["venue"]["name"])) {
                                                                echo 'Título do periódico: '.$r["_source"]["aminer"]["venue"]["name"].'<br/>';
                                                            }
                                                            if (!empty($r["_source"]["aminer"]["venue"]["volume"])) {
                                                                echo 'Volume: '.$r["_source"]["aminer"]["venue"]["volume"].'<br/>';
                                                            }                                        
                                                            if (!empty($r["_source"]["aminer"]["venue"]["issue"])) {
                                                                echo 'Fascículo: '.$r["_source"]["aminer"]["venue"]["issue"].'<br/>';
                                                            }                                                              
                                                            ?>
                                                            </p>
                                                        </li>
                                                        
                                                <?php endif; ?>
                                            </ul>
                                        </li>
                                        <a class="uk-button uk-button-text" href="#" uk-toggle="target: #citacao<?php echo $conta_cit;?>; animation: uk-animation-fade"><?php echo $t->gettext('Como citar'); ?></a>
                                        <a class="uk-button uk-button-text" href="#" uk-toggle="target: #ref<?php echo $conta_cit;?>; animation: uk-animation-fade"><?php echo $t->gettext('Referências'); ?></a>
                                        <div id="citacao<?php echo $conta_cit;?>" hidden="hidden">
                                        <li class="uk-h6 uk-margin-top">
                                            <div class="uk-alert uk-alert-danger">A citação é gerada automaticamente e pode não estar totalmente de acordo com as normas</div>
                                            <ul>
                                                <li class="uk-margin-top">
                                                    <p><strong>ABNT</strong></p>
                                                    <?php
                                                                    $r["_source"]['name'] = $r["_source"]["titulo"];
                                                                    $r["_source"]['type'] = $r["_source"]["tipo"];
                                                                    $data = citation::citation_query($r["_source"]);
                                                                    print_r($citeproc_abnt->render($data, $mode));
                                                    ?>
                                                </li>                                               
                                            </ul>                                              
                                        </li>
                                        </div>
                                        <div id="ref<?php echo $conta_cit;?>" hidden="hidden">
                                        <li class="uk-h6 uk-margin-top">
                                            <div class="uk-alert uk-alert-danger">As referencias são coletadas automaticamente e pode não estar totalmente corretas</div>
                                            <?php if (isset($r["_source"]["references"])) {
                                                echo '<ol>';
                                                foreach ($r["_source"]["references"] as $reference_grobid) {
                                                    echo '<li class="uk-margin-top">';
                                                    echo '<ul>';
                                                    if (!empty($reference_grobid["monogrTitle"])) {
                                                        echo '<li>Título da obra no todo: '.(string)$reference_grobid["monogrTitle"].'</li>';
                                                    }
                                                    if (!empty($reference_grobid["analyticTitle"])) {
                                                        echo '<li>Título da analítica: '.(string)$reference_grobid["analyticTitle"].'</li>';
                                                    }
                                                    if (!empty($reference_grobid["authors"])) {
                                                        echo '<li>Autores: '. implode(" ;", $reference_grobid["authors"]) .'</li>';
                                                    }
                                                    if (!empty($reference_grobid["meeting"])) {
                                                        echo '<li>Nome do evento: '.(string)$reference_grobid["meeting"].'</li>';
                                                    }
                                                    if (!empty($reference_grobid["publisher"])) {
                                                        echo '<li>Editora: '.(string)$reference_grobid["publisher"].'</li>';
                                                    }
                                                    if (!empty($reference_grobid["pubPlace"])) {
                                                        echo '<li>Local de publicação: '.(string)$reference_grobid["pubPlace"].'</li>';
                                                    }
                                                    if (!empty($reference_grobid["datePublished"])) {
                                                        echo '<li>Data de publicação: '.(string)$reference_grobid["datePublished"].'</li>';
                                                    }
                                                    if (!empty($reference_grobid["link"])) {
                                                        echo '<li>Link: '.(string)$reference_grobid["link"].'</li>';
                                                    } 
                                                    if (!empty($reference_grobid["doi"])) {
                                                        echo '<li>DOI: '.(string)$reference_grobid["doi"].'</li>';
                                                    }                                                                                                                                                                  
                                                    //print_r($reference_grobid);
                                                    echo '</ul>';
                                                    echo '</li>';
                                                }
                                                echo '</ol>';
                                            } ?>
                                            <ul>
                                                <li class="uk-margin-top">
                                                            
                                                </li>                                               
                                            </ul>                                              
                                        </li>
                                        </div>  
                                        <?php $conta_cit++; ?>                                      
                                    </ul>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                    </div>
                    <hr class="uk-grid-divider">
                                   
                </div>
            </div>
            <hr class="uk-grid-divider">
<!-- < ?php include('inc/footer.php'); ?> -->         
        </div>
                


        <script>
        $('[data-uk-pagination]').on('select.uk.pagination', function(e, pageIndex){
            var url = window.location.href.split('&page')[0];
            window.location=url +'&page='+ (pageIndex+1);
        });
        </script>    

<?php require 'inc/offcanvas.php'; ?>         
        
    </body>
</html>

