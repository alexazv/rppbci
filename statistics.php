<html>
    <head>
        <?php 
            require 'inc/config.php'; 
            require 'inc/functions.php';
            require 'inc/meta-header.php';
        ?>
        <title>Estatísticas</title>
    </head>    
    <body>
        <div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">
            <?php require 'inc/navbar.php' ?>
            
            <h1>Estatísticas</h1>
            
            <h2>Facebook</h2>
			<iframe src="http://localhost:5601/app/kibana#/visualize/edit/e2880240-a4aa-11e8-88d1-e17015bd586e?embed=true&_g=()" height="600" width="800"></iframe>
            
			<h2>Publicações por periódico e por ano de publicação</h2>
            <iframe src="http://localhost:5601/app/kibana#/visualize/edit/280c4860-b20e-11e8-a201-cbaac03a30d4?embed=true&_g=()&_a=(filters:!(),linked:!f,query:(language:lucene,query:''),uiState:(),vis:(aggs:!((enabled:!t,id:'1',params:(),schema:metric,type:count),(enabled:!t,id:'2',params:(field:source.keyword,missingBucket:!f,missingBucketLabel:Missing,order:desc,orderBy:'1',otherBucket:!f,otherBucketLabel:Other,size:1000),schema:segment,type:terms),(enabled:!t,id:'3',params:(field:ano.keyword,size:100),schema:segment,type:significant_terms)),params:(addLegend:!t,addTooltip:!t,isDonut:!t,labels:(last_level:!t,show:!f,truncate:100,values:!t),legendPosition:right,type:pie),title:Source%2Fyear,type:pie))" height="600" width="800"></iframe>
            
            <h2>Métricas por artigo</h2>
            <iframe src="http://localhost:5601/app/kibana#/visualize/edit/54232b10-c67e-11e8-a072-172e053d621f?embed=true&_g=(refreshInterval%3A('%24%24hashKey'%3A'object%3A1232'%2Cdisplay%3AOff%2Cpause%3A!f%2Csection%3A0%2Cvalue%3A0)%2Ctime%3A(from%3Anow%2Fy%2Cmode%3Aquick%2Cto%3Anow%2Fy))" height="600" width="800"></iframe>
			
			<h2>Twitter</h2>
			<iframe src="http://localhost:5601/app/kibana#/visualize/create?embed=true&type=pie&indexPattern=1038db30-a4a9-11e8-88d1-e17015bd586e&_g=()&_a=(filters:!(),linked:!f,query:(language:lucene,query:''),uiState:(),vis:(aggs:!((enabled:!t,id:'1',params:(),schema:metric,type:count),(enabled:!t,id:'2',params:(extended_bounds:(),field:twitter.tweet_count,interval:0,min_doc_count:!t),schema:segment,type:histogram)),params:(addLegend:!t,addTooltip:!t,isDonut:!t,labels:(last_level:!t,show:!f,truncate:100,values:!t),legendPosition:right,type:pie),title:'New+Visualization',type:pie))" height="600" width="800"></iframe>
			
			<h2>Youtube</h2>
			<iframe src="http://localhost:5601/app/kibana#/visualize/edit/0ec04240-b20d-11e8-a201-cbaac03a30d4?embed=true&_g=(refreshInterval%3A('%24%24hashKey'%3A'object%3A1232'%2Cdisplay%3AOff%2Cpause%3A!f%2Csection%3A0%2Cvalue%3A0)%2Ctime%3A(from%3Anow%2Fy%2Cmode%3Aquick%2Cto%3Anow%2Fy))" height="600" width="800"></iframe>
			
			<h2>G+</h2>
			<iframe src="http://localhost:5601/app/kibana#/visualize/create?embed=true&type=pie&indexPattern=1038db30-a4a9-11e8-88d1-e17015bd586e&_g=()&_a=(filters:!(),linked:!f,query:(language:lucene,query:''),uiState:(),vis:(aggs:!((enabled:!t,id:'1',params:(),schema:metric,type:count),(enabled:!t,id:'2',params:(extended_bounds:(),field:google_plus.activities,interval:0,min_doc_count:!t),schema:segment,type:histogram)),params:(addLegend:!t,addTooltip:!t,isDonut:!t,labels:(last_level:!t,show:!f,truncate:100,values:!t),legendPosition:right,type:pie),title:'New+Visualization',type:pie))" height="600" width="800"></iframe>
			
			<h2>Métricas de divulgação científica por periódico</h2>
            <iframe src="http://localhost:5601/app/kibana#/visualize/edit/4491f3b0-c5ad-11e8-a072-172e053d621f?embed=true&_g=(refreshInterval%3A('%24%24hashKey'%3A'object%3A1232'%2Cdisplay%3AOff%2Cpause%3A!f%2Csection%3A0%2Cvalue%3A0)%2Ctime%3A(from%3Anow%2Fy%2Cmode%3Aquick%2Cto%3Anow%2Fy))" height="600" width="800"></iframe>
			
            <h2>Top 20 autores/perióricos com mais altmetrics</h2>
            
            <iframe src="http://localhost:5601/app/kibana#/visualize/create?embed=true&type=histogram&indexPattern=<?php echo $index; ?>&_g=()&_a=(filters:!(),linked:!f,query:(query_string:(analyze_wildcard:!t,query:'*')),uiState:(),vis:(aggs:!((enabled:!t,id:'1',params:(field:facebook.facebook_total),schema:metric,type:sum),(enabled:!t,id:'2',params:(field:autores.nomeCompletoDoAutor.keyword,order:desc,orderBy:'1',size:20),schema:segment,type:terms),(enabled:!t,id:'3',params:(field:source.keyword,order:desc,orderBy:'1',size:50),schema:group,type:terms)),listeners:(),params:(addLegend:!t,addTimeMarker:!f,addTooltip:!t,defaultYExtents:!f,legendPosition:right,mode:stacked,scale:linear,setYExtents:!f,times:!()),title:'New+Visualization',type:histogram))" height="600" width="1125" scrolling="no" frameborder="0" seamless="seamless"></iframe>
            
            <h2>10 Artigos por altmetrics e ano</h2>
            <iframe src="http://localhost:5601/app/kibana#/visualize/create?embed=true&type=table&indexPattern=<?php echo $index; ?>&_g=()&_a=(filters:!(),linked:!f,query:(query_string:(analyze_wildcard:!t,query:'*')),uiState:(vis:(params:(sort:(columnIndex:!n,direction:!n)))),vis:(aggs:!((enabled:!t,id:'1',params:(customLabel:'',field:facebook.facebook_total),schema:metric,type:sum),(enabled:!t,id:'2',params:(customLabel:Ano,field:ano.keyword,order:desc,orderBy:_term,row:!t,size:5),schema:split,type:terms),(enabled:!t,id:'3',params:(customLabel:T%C3%ADtulo,field:titulo.keyword,order:desc,orderBy:'1',size:10),schema:bucket,type:terms)),listeners:(),params:(perPage:10,showMeticsAtAllLevels:!f,showPartialRows:!f,showTotal:!f,sort:(columnIndex:!n,direction:!n),totalFunc:sum),title:'New+Visualization',type:table))" height="600" width="1125" scrolling="no" frameborder="0" seamless="seamless"></iframe>
            
            <h2>Palavras-chave por ano</h2>
            <iframe src="http://bdpife2.sibi.usp.br:5601/app/kibana#/visualize/create?embed=true&type=histogram&indexPattern=<?php echo $index; ?>&_g=()&_a=(filters:!(('$$hashKey':'object:2017','$state':(store:appState),meta:(alias:!n,disabled:!f,index:rppbci2,key:palavras_chave.keyword,negate:!t,value:''),query:(match:(palavras_chave.keyword:(query:'',type:phrase))))),linked:!f,query:(query_string:(analyze_wildcard:!t,query:'*')),uiState:(),vis:(aggs:!((enabled:!t,id:'1',params:(),schema:metric,type:count),(enabled:!t,id:'2',params:(field:palavras_chave.keyword,order:desc,orderBy:'1',size:30),schema:segment,type:terms),(enabled:!t,id:'3',params:(field:ano.keyword,order:desc,orderBy:_term,size:200),schema:group,type:terms)),listeners:(),params:(addLegend:!t,addTimeMarker:!f,addTooltip:!t,defaultYExtents:!f,legendPosition:right,mode:stacked,scale:linear,setYExtents:!f,times:!()),title:'New+Visualization',type:histogram))" height="600" width="1125" scrolling="no" frameborder="0" seamless="seamless"></iframe>
            
            <h2>Artigos com altmetrics por revista</h2>
            <iframe src="http://bdpife2.sibi.usp.br:5601/app/kibana#/visualize/create?embed=true&type=histogram&indexPattern=<?php echo $index; ?>&_g=()&_a=(filters:!(),linked:!f,query:(query_string:(analyze_wildcard:!t,query:'*')),uiState:(),vis:(aggs:!((enabled:!t,id:'1',params:(),schema:metric,type:count),(enabled:!t,id:'2',params:(field:source.keyword,order:desc,orderBy:'1',size:200),schema:segment,type:terms),(enabled:!t,id:'3',params:(field:facebook.facebook_total,ranges:!((from:0,to:1),(from:1,to:10000))),schema:group,type:range)),listeners:(),params:(addLegend:!t,addTimeMarker:!f,addTooltip:!t,defaultYExtents:!f,legendPosition:right,mode:stacked,scale:linear,setYExtents:!f,times:!()),title:'New+Visualization',type:histogram))" height="600" width="1125" scrolling="no" frameborder="0" seamless="seamless"></iframe>
            
            <h2>Por tipo de interação no facebook</h2>
            <iframe src="http://bdpife2.sibi.usp.br:5601/app/kibana#/visualize/create?embed=true&type=histogram&indexPattern=<?php echo $index; ?>&_g=()&_a=(filters:!(),linked:!f,query:(query_string:(analyze_wildcard:!t,query:'*')),uiState:(),vis:(aggs:!((enabled:!t,id:'2',params:(customLabel:Coment%C3%A1rios,field:facebook.comment_count),schema:metric,type:sum),(enabled:!t,id:'3',params:(customLabel:comment_plugin,field:facebook.comment_plugin_count),schema:metric,type:sum),(enabled:!t,id:'4',params:(customLabel:Reactions,field:facebook.reaction_count),schema:metric,type:sum),(enabled:!t,id:'5',params:(customLabel:Compartilhamentos,field:facebook.share_count),schema:metric,type:sum)),listeners:(),params:(addLegend:!t,addTimeMarker:!f,addTooltip:!t,defaultYExtents:!f,legendPosition:right,mode:stacked,scale:linear,setYExtents:!f,times:!()),title:'New+Visualization',type:histogram))" height="600" width="1125" scrolling="no" frameborder="0" seamless="seamless"></iframe>
            
            <h2>Interações por posição de link</h2>
            <iframe src="http://bdpife2.sibi.usp.br:5601/app/kibana#/visualize/create?embed=true&type=histogram&indexPattern=<?php echo $index; ?>&_g=()&_a=(filters:!(),linked:!f,query:(query_string:(analyze_wildcard:!t,query:'*')),uiState:(),vis:(aggs:!((enabled:!t,id:'2',params:(customLabel:'Link+0',field:facebook.fb0),schema:metric,type:sum),(enabled:!t,id:'3',params:(customLabel:'Link+1',field:facebook.fb1),schema:metric,type:sum),(enabled:!t,id:'4',params:(customLabel:'Link+2',field:facebook.fb2),schema:metric,type:sum),(enabled:!t,id:'5',params:(customLabel:'Link+3',field:facebook.fb3),schema:metric,type:sum),(enabled:!t,id:'6',params:(customLabel:'Link+4',field:facebook.fb4),schema:metric,type:sum),(enabled:!t,id:'7',params:(customLabel:'Link+5',field:facebook.fb5),schema:metric,type:sum),(enabled:!t,id:'8',params:(customLabel:'Link+6',field:facebook.fb6),schema:metric,type:sum),(enabled:!t,id:'9',params:(customLabel:'Link+7',field:facebook.fb7),schema:metric,type:sum)),listeners:(),params:(addLegend:!t,addTimeMarker:!f,addTooltip:!t,defaultYExtents:!f,legendPosition:right,mode:grouped,orderBucketsBySum:!f,scale:linear,setYExtents:!f,times:!()),title:'New+Visualization',type:histogram))" height="600" width="1125" scrolling="no" frameborder="0" seamless="seamless"></iframe>
            
            <h2>Interações por Qualis 2015</h2>
            <iframe src="http://bdpife2.sibi.usp.br:5601/app/kibana#/visualize/create?embed=true&type=histogram&indexPattern=<?php echo $index; ?>&_g=()&_a=(filters:!(),linked:!f,query:(query_string:(analyze_wildcard:!t,query:'*')),uiState:(),vis:(aggs:!((enabled:!t,id:'1',params:(customLabel:'Intera%C3%A7%C3%B5es+no+Facebook',field:facebook.facebook_total),schema:metric,type:sum),(enabled:!t,id:'2',params:(field:qualis2015.keyword,order:desc,orderBy:'1',size:50),schema:segment,type:terms)),listeners:(),params:(addLegend:!t,addTimeMarker:!f,addTooltip:!t,defaultYExtents:!f,legendPosition:right,mode:stacked,scale:linear,setYExtents:!f,times:!()),title:'New+Visualization',type:histogram))" height="600" width="1125" scrolling="no" frameborder="0" seamless="seamless"></iframe>
                                  
            <h2>Quantidade de artigos por autor</h2>
            <iframe src="http://localhost:5601/app/kibana#/visualize/edit/cb374ae0-c5ae-11e8-a072-172e053d621f?embed=true&_g=(refreshInterval%3A('%24%24hashKey'%3A'object%3A1232'%2Cdisplay%3AOff%2Cpause%3A!f%2Csection%3A0%2Cvalue%3A0)%2Ctime%3A(from%3Anow%2Fy%2Cmode%3Aquick%2Cto%3Anow%2Fy))" height="600" width="800"></iframe>
            
			<h2>Altmetrics por Instituição e Periódico</h2>
            <iframe src="http://bdpife2.sibi.usp.br:5601/app/kibana#/visualize/create?embed=true&type=histogram&indexPattern=<?php echo $index; ?>&_g=()&_a=(filters:!(),linked:!f,query:(query_string:(analyze_wildcard:!t,query:'*')),uiState:(),vis:(aggs:!((enabled:!t,id:'1',params:(field:facebook.facebook_total),schema:metric,type:sum),(enabled:!t,id:'2',params:(field:autores.afiliacao.keyword,order:desc,orderBy:'1',size:30),schema:segment,type:terms),(enabled:!t,id:'3',params:(field:source.keyword,order:desc,orderBy:'1',size:200),schema:group,type:terms)),listeners:(),params:(addLegend:!t,addTimeMarker:!f,addTooltip:!t,defaultYExtents:!f,legendPosition:right,mode:stacked,scale:linear,setYExtents:!f,times:!()),title:'New+Visualization',type:histogram))" height="600" width="1125" scrolling="no" frameborder="0" seamless="seamless"></iframe>
            
            <h2>Altmetrics por Palavra-Chave e por Ano</h2>
            <iframe src="http://bdpife2.sibi.usp.br:5601/app/kibana#/visualize/create?embed=true&type=histogram&indexPattern=<?php echo $index; ?>&_g=()&_a=(filters:!(('$$hashKey':'object:1742','$state':(store:appState),meta:(alias:!n,apply:!t,disabled:!f,index:rppbci3,key:palavras_chave.keyword,negate:!t,value:''),query:(match:(palavras_chave.keyword:(query:'',type:phrase))))),linked:!f,query:(query_string:(analyze_wildcard:!t,query:'*')),uiState:(),vis:(aggs:!((enabled:!t,id:'1',params:(field:facebook.facebook_total),schema:metric,type:sum),(enabled:!t,id:'2',params:(field:palavras_chave.keyword,order:desc,orderBy:'1',size:50),schema:segment,type:terms),(enabled:!t,id:'3',params:(field:ano.keyword,order:desc,orderBy:'1',size:200),schema:group,type:terms)),listeners:(),params:(addLegend:!t,addTimeMarker:!f,addTooltip:!t,defaultYExtents:!f,legendPosition:right,mode:stacked,scale:linear,setYExtents:!f,times:!()),title:'New+Visualization',type:histogram))" height="600" width="1125" scrolling="no" frameborder="0" seamless="seamless"></iframe>
            
            <h2>Nota no altmetric.com por revista</h2>
            <iframe src="http://bdpife2.sibi.usp.br:5601/app/kibana#/visualize/create?embed=true&type=histogram&indexPattern=<?php echo $index; ?>&_g=()&_a=(filters:!(),linked:!f,query:(query_string:(analyze_wildcard:!t,query:'*')),uiState:(),vis:(aggs:!((enabled:!t,id:'1',params:(),schema:metric,type:count),(enabled:!t,id:'2',params:(field:altmetric_com.score,order:desc,orderBy:'1',size:100),schema:segment,type:terms),(enabled:!t,id:'3',params:(field:source.keyword,order:desc,orderBy:'1',size:200),schema:group,type:terms)),listeners:(),params:(addLegend:!t,addTimeMarker:!f,addTooltip:!t,defaultYExtents:!f,legendPosition:right,mode:stacked,scale:linear,setYExtents:!f,times:!()),title:'New+Visualization',type:histogram))" height="600" width="1125" scrolling="no" frameborder="0" seamless="seamless"></iframe>
            
            <h2>Leitores no Mendeley (altmetric.com)</h2>
            <iframe src="http://bdpife2.sibi.usp.br:5601/app/kibana#/visualize/create?embed=true&type=histogram&indexPattern=<?php echo $index; ?>&_g=()&_a=(filters:!(),linked:!f,query:(query_string:(analyze_wildcard:!t,query:'*')),uiState:(),vis:(aggs:!((enabled:!t,id:'1',params:(),schema:metric,type:count),(enabled:!t,id:'2',params:(field:altmetric_com.readers.mendeley,order:desc,orderBy:'1',size:100),schema:segment,type:terms),(enabled:!t,id:'3',params:(field:source.keyword,order:desc,orderBy:'1',size:200),schema:group,type:terms)),listeners:(),params:(addLegend:!t,addTimeMarker:!f,addTooltip:!t,defaultYExtents:!f,legendPosition:right,mode:stacked,scale:linear,setYExtents:!f,times:!()),title:'New+Visualization',type:histogram))" height="600" width="1125" scrolling="no" frameborder="0" seamless="seamless"></iframe>
            
            
            <?php require 'inc/offcanvas.php' ?>
        </div>    
    </body>
</html>