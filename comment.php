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
			$id = $_GET['id'];
			$where="";
			if ($network == 'facebook') $where = "and tu_posts.network='facebook'";
			$conexion = mysql_connect("ec2-54-247-9-188.eu-west-1.compute.amazonaws.com", "edugasser", "010203");
			mysql_select_db("thinkupdb", $conexion);
			$queEmp = "
			SELECT 	* FROM tu_posts	WHERE post_id = '$id'";
			$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
			$totEmp = mysql_num_rows($resEmp);
		 	
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
                 <?php
                 if ($totEmp> 0) {
	             while ($rowEmp = mysql_fetch_assoc($resEmp)) {
	             ?>
                        <a class="article_title"><h2>Comentario</h2></a>
                        <hr />
						<p style="margin:20px;">@<?php echo $rowEmp['author_username'];?> | Fecha comentario: <?php echo $rowEmp['pub_date'];?></p>
						<h4 style="margin:20px;"><?php echo $rowEmp['post_text'];?></h4> 
						 
				<?php }} ?>
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
