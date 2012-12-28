<!DOCTYPE html> 
<html> 
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
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
    <script src="chart/js/highcharts.js"></script>
    <script src="chart/js/highcharts-more.js"></script>
    <script src="chart/js/modules/exporting.js"></script>
        
    <!-- [executing common scripts] -->     
        
</head>
	
<body>

	<?php 
		
			$user= $_GET['user'];
			$network= $_GET['network'];
			$where="";
			if ($network == 'facebook') $where = "and tu_posts.network='facebook'";
			$conexion = mysql_connect("ec2-54-247-9-188.eu-west-1.compute.amazonaws.com", "edugasser", "010203");
			mysql_select_db("thinkupdb", $conexion);
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
					<p align="right" style="margin-top:40px; margin-right:30px"><a href="perfil.php?user=<?php echo $_GET['user'];?>&network=<?php echo $_GET['network'];?>"><img width="60" src="img/<?php echo $_GET['user'];?>.jpg"><a/></p>
               </div>
                        
               <div id="header_right">
                    <a href="javascript:history.back()"><img src="img/icons/back2.png"></a>
               </div>
                        
                </div>
                        
            </section><!-- [header end] --> 	
                    
            <section id="content">
                
                <article>
                    <div class="article_wrapper">
                 
                        <a class="article_title"><h2>Estadisticas</h2></a>
                        <p class="prologue">Sobre el tiempo de respuesta de publicaciones</p>
                       
                        <hr />
						<?php $var = MAX($de_noche,$de_maniana,$de_tarde); ?>
						<h4 style="margin:20px;">Franja horaria donde hacen más comentarios: <span style="font-size:17pt;color:#366297"><?php echo $resultado[$var]; ?></span></h4> 
						
						<div id="container" style="min-width: 400px; height: 400px;" ></div>
						
						 
						
                  
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
	    <!-- otra grafica -->
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
