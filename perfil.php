<!DOCTYPE html> 
<html> 
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <!-- [portable options] -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0; user-scalable=0;" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    
	<title>Social App SM</title>
    
    <!-- [loading stylesheets] -->    
    <link type="text/css" rel="stylesheet" href="css/style.css" />
        
    <!-- [loading fonts] -->     
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,700,300,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,300,200' rel='stylesheet' type='text/css'>
    <link  href="http://fonts.googleapis.com/css?family=Arimo:regular,italic,bold,bolditalic" rel="stylesheet" type="text/css" >
    <script src="js/istok-web.js"></script>
		
    <!-- [loading scripts] -->     
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript" src="js/iscroll.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    
    <!-- CHART -->
    <!-- 
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="chart/js/highcharts.js"></script>
    <script src="chart/js/highcharts-more.js"></script>
    <script src="chart/js/modules/exporting.js"></script>
    -->

    <!-- [executing common scripts] -->  
 <style type="text/css">	
        .button {
	font-size: 12px;
	font-weight:bold;
	padding: 7px 12px;
	cursor:pointer;	
	line-height:16px;
	display:inline-block;
	margin:0 15px 30px 15px;	
	border-radius: 2px;
	-moz-border-radius: 2px;/*gecko - mozilla*/ 
	-webkit-border-radius: 2px; /*new webkit - Chrome and Safari*/	
	box-shadow: #e3e3e3 0 1px 1px;	
	-moz-box-shadow:
		0px 1px 1px rgba(000,000,000,0.1),
		inset 0px 1px 1px rgba(255,255,255,0.7);/*gecko - mozilla*/ 
	-webkit-box-shadow:
		0px 1px 1px rgba(000,000,000,0.1),
		inset 0px 1px 1px rgba(000,000,000,0.7);/*new webkit - Chrome and Safari*/		
	behavior:url(PIE.htc);				
}
.orange {
	text-shadow: 1px 1px 0px #ffe8b2;
	color: #7c5d1b;
	border: 1px solid #d6a437;	
    background: #febd4b; /*fallback for non-CSS3 browsers*/
    background: -webkit-gradient(linear, 0 0, 0 100%, from(#fed970) to(#febd4b)); /*old webkit*/
    background: -webkit-linear-gradient(#fed970, #febd4b); /*new webkit*/
    background: -moz-linear-gradient(#fed970, #febd4b); /*gecko*/
    background: -ms-linear-gradient(#fed970, #febd4b); /*IE10*/
    background: -o-linear-gradient(#fed970, #febd4b); /*opera 11.10+*/
    background: linear-gradient(#fed970, #febd4b); /*future CSS3 browsers*/
    -pie-background: linear-gradient(#fed970, #febd4b); /*PIE*/
	
}
</style>
</head>
	
<body>

	<?php 
		
			$user= $_GET['user'];
			$network= $_GET['network'];
			$where="";
			if ($network == 'facebook') $where = "and tu_posts.network='facebook'";
			$conexion = mysql_connect("ec2-54-247-9-188.eu-west-1.compute.amazonaws.com", "edugasser", "010203");
			mysql_select_db("thinkupdb", $conexion);
			$queEmp = "
			SELECT 
			tu_posts.post_text as comment_original,
			GROUP_CONCAT(contestacion.post_text, ' ', contestacion.pub_date SEPARATOR '<br>') as comment_alguien,
			tu_posts.post_id as original_id, 
			contestacion.post_id AS alguien_id,
			tu_posts.pub_date AS data_original, 
			contestacion.pub_date AS data_alguien,
			MAX(contestacion.pub_date) AS ultimo_comment,
			MIN(contestacion.pub_date) AS first_comment
			FROM tu_posts 
			JOIN tu_posts AS contestacion ON contestacion.in_reply_to_post_id=tu_posts.post_id  
			WHERE tu_posts.author_user_id='$user' $where
			GROUP BY original_id HAVING tu_posts.pub_date <= first_comment
			ORDER BY contestacion.pub_date DESC ";
			$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
			$totEmp = mysql_num_rows($resEmp);
			// id vicens 414977772
			$media_first_comment = 0;
			$media_last_comment = 0;
			$contador_comment = 1;
			$array = array();
			$array_last = array();
			if ($totEmp> 0) {
			   while ($rowEmp = mysql_fetch_assoc($resEmp)) {
				//DIFERENCIA ENTRE LA PUBLICACION Y EL PRIMER COMENTARIO
			    $data_original = $rowEmp['data_original'];
				$data_alguien = $rowEmp['first_comment'];
	
				$s = strtotime($data_alguien)-strtotime($data_original); 
				$d = intval($s/86400); 
				$s -= $d*86400; 
				$h_f = intval($s/3600); 
				$s -= $h_f*3600; 
				$m_f = intval($s/60); 
				$s -= $m_f*60; 
				$dif_first= (($d*24)+$h_f)." ".$m_f."min"; 
				//$dif2= $d." ".$h_f." ".$m_f."min"; 
				$min_first = ($h_f*60)+$m_f;
		
				//DIFERENCIA ENTRE LA PUBLICACION Y EL ULTIMO COMENTARIO
			    $data_original = $rowEmp['data_original'];
				$data_alguien = $rowEmp['ultimo_comment'];
	
				$s = strtotime($data_alguien)-strtotime($data_original); 
				$d = intval($s/86400); 
				$s -= $d*86400; 
				$h = intval($s/3600); 
				$s -= $h*3600; 
				$m = intval($s/60); 
				$s -= $m*60; 
				$dif_last= (($d*24)+$h)." ".$m."min"; 
				//$dif2= $d." ".$h." ".$m."min"; 
				 $min_last = ($h*60)+$m;
				$media_first_comment += $min_first;
				$media_last_comment += $min_last;
				$array[$contador_comment] = $min_first;
				$array_last[$contador_comment] = $min_last;
				$contador_comment += 1;
 
			   }
			}
			
			//6 - 13:00
			//14 - 19
			//20 - 5
			
			 $media_minutos = ($media_first_comment/$contador_comment);
			 $horas_first = intval($media_minutos/60);
			 $minutos_first = intval((($media_minutos/60) - $horas_first)*60);
			 $tiempo_medio_first = $horas_first."h ".$minutos_first;
			 
			 $media_minutos = ($media_last_comment/$contador_comment);
			 $horas_first = intval($media_minutos/60);
			 $minutos_first = intval((($media_minutos/60) - $horas_first)*60);
			 $tiempo_medio_last = $horas_first."h ".$minutos_first;
			 /*----------franja horaria de 6 a 13-------------*/
			$queEmp = "
			SELECT DISTINCT *,tu_posts.post_id as original_id,COUNT(*) AS por_maniana,DATE_FORMAT(tu_posts.pub_date, '%H') as hora
			FROM tu_posts 
			JOIN tu_posts AS contestacion ON contestacion.in_reply_to_post_id=tu_posts.post_id  
			WHERE tu_posts.author_user_id='$user' $where
			GROUP BY contestacion.post_id  HAVING hora <= 13 AND hora >= 6
			ORDER BY contestacion.post_id  DESC	";
			$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
			 $de_maniana = mysql_num_rows($resEmp);
			 /*----------franja horaria de 13 a 19-------------*/
			$queEmp = "
			SELECT DISTINCT *,tu_posts.post_id as original_id,COUNT(*) AS por_maniana,DATE_FORMAT(tu_posts.pub_date, '%H') as hora
			FROM tu_posts 
			JOIN tu_posts AS contestacion ON contestacion.in_reply_to_post_id=tu_posts.post_id  
			WHERE tu_posts.author_user_id='$user' $where
			GROUP BY contestacion.post_id  HAVING hora <= 19 AND hora > 13
			ORDER BY contestacion.post_id  DESC	";
			$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
			 $de_tarde = mysql_num_rows($resEmp);
			 /*----------franja horaria de 20 a 6-------------*/
			$queEmp = "
			SELECT DISTINCT *,tu_posts.post_id as original_id,COUNT(*) AS por_maniana,DATE_FORMAT(tu_posts.pub_date, '%H') as hora
			FROM tu_posts 
			JOIN tu_posts AS contestacion ON contestacion.in_reply_to_post_id=tu_posts.post_id  
			WHERE tu_posts.author_user_id='$user' $where
			GROUP BY contestacion.post_id  HAVING hora > 19
			ORDER BY contestacion.post_id  DESC	";
			$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
			 $de_noche = mysql_num_rows($resEmp);
			$resultado = array($de_noche => 'de noche', $de_maniana => 'de mañana',$de_tarde => 'de tarde');
			
		
		?>

    <section id="page-wrapper">	
    
    	<section id="menu">
        	<div>
        		<h4>Usuarios</h4>
                <ul>
                	<li class="item"><a href="perfil.php?user=1148381712&network=facebook"><img src="img/1148381712.jpg" alt="" /><span>Eduardo Gasser</span></a></li>
    				<li class="item"><a href="perfil.php?user=414977772&network=twitter"> <img src="img/414977772.jpg" alt="" /><span>Vicenç Juan Tomàs Montserrat</span></a></li>
    				<li class="item"><a href="perfil.php?user=1132115210&network=facebook"><img src="img/1132115210.jpg" alt="" /><span>Matías Bandi</span></a></li>
                </ul>
    		</div>
    	</section><!-- [menu end] --> 

    	<section id="content-wrapper">	
        
            <section id="header">
                    
               <div id="header_left">
					<a href="index.html"><img src="img/icons/icon_home.png" alt="" /></a>
               </div>
             
                        
               <div id="header_title">
                    <h1>Social App SM</h1>
					<p align="right" style="margin-top:40px; margin-right:30px"><a href="perfil.php?user=<?php echo $_GET['user'];?>&network=<?php echo $_GET['network'];?>"><img width="60" src="img/<?php echo $_GET['user'];?>.jpg"></a></p>
               </div>
                        
               <div id="header_right">
                     <a href="javascript:history.back();"><img src="img/icons/back2.png"></a>
               </div>
                        
                </div>
                        
            </section><!-- [header end] --> 	
              
            <section id="content">
                
                <article>
                    <div class="article_wrapper">
                 
                        <a class="article_title"><h2>Estadísticas</h2></a>
                        <p class="prologue">Sobre el tiempo de respuesta de publicaciones</p>
                        <hr />
						<?php $var = MAX($de_noche,$de_maniana,$de_tarde); ?>
						<h4 style="margin:20px;">Franja horaria donde hacen más comentarios: <span style="font-size:17pt;color:#366297"><?php echo $resultado[$var]; ?></span></h4> 
						<a href="tarta.php?gf=first&user=<?php echo $_GET['user'];?>&network=<?php echo $_GET['network'];?>" target="_parent" class="button orange"  style="margin-left:20px;"  >Ver gráfica</a>
						 
						<h4 style="margin:20px;">El tiempo medio de respuesta de una publicación es de : <span style="font-size:17pt;color:#366297"><?php echo $tiempo_medio_first;?> min.</span></h4>
						<a href="grafica.php?gf=first&user=<?php echo $_GET['user'];?>&network=<?php echo $_GET['network'];?>" target="_parent" class="button orange"  style="margin-left:20px;"  >Ver gráfica</a>
						 
						<h4 style="margin:20px;">El tiempo medio de vida de una publicación es de : <span style="font-size:17pt;color:#366297"><?php echo $tiempo_medio_last;?> min.</span></h4>
						<a href="grafica.php?gf=last&user=<?php echo $_GET['user'];?>&network=<?php echo $_GET['network'];?>" class="button orange"  style="margin-left:20px;" data-router="section">Ver gráfica</a>
						 

                    </div>
					
                </article><!-- [article end] --> 
                       
            </section><!-- [content end] --> 	
                    
             <section id="footer">
                <div id="footer_content">
                    <div class="widget">
                        <h4>Social App SM</h4>
                        <p>Esta aplicación realiza estadísticas sobre el tiempo de los comentarios realizados en las redes sociales Facebook y Twitter.</p>
                    </div>
                    <div class="widget">
                        <ul class="social">
                            <li><a href="#"><img src="img/social/twitter.png" alt="" /></a></li>

                            <li><a href="#"><img src="img/social/facebook.png" alt="" /></a></li>
  
                        </ul>
                    </div>
           
                </div><!-- [footer content end] --> 	
            </section><!-- [footer end] --> 
     	</section><!-- [content-wrapper end] -->    	
	</section><!-- [page-wrapper end] --> 
	<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
    	
    	// Radialize the colors
		Highcharts.getOptions().colors = $.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
		        ]
		    };
		});
		
		// Build the chart
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Franjas horarias'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
			 plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            
            series: [{
                type: 'pie',
                name: 'Porcentaje',
                data: [
                    ['De mañana',   <?php echo $de_maniana;?>],
                    ['De tarde',       <?php echo $de_tarde;?>],
                   
                    ['De noche',    <?php echo $de_noche;?>]
               
                ]
            }]
        });
    });
    
});
		</script>
</body>
</html>
