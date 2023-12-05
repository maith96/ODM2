<?php
include "topheader.php";
?>
		<!-- /BREADCRUMB -->
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
				});
			});
</script>
		<script>
    
    (function (global) {
	if(typeof (global) === "undefined")
	{
		throw new Error("window is undefined");
	}
    var _hash = "!";
    var noBackPlease = function () {
        global.location.href += "#";
		// making sure we have the fruit available for juice....
		// 50 milliseconds for just once do not cost much (^__^)
        global.setTimeout(function () {
            global.location.href += "!";
        }, 50);
    };	
	// Earlier we had setInerval here....
    global.onhashchange = function () {
        if (global.location.hash !== _hash) {
            global.location.hash = _hash;
        }
    };
    global.onload = function () {        
		noBackPlease();
		// disables backspace on page except on input fields and textarea..
		document.body.onkeydown = function (e) {
            var elm = e.target.nodeName.toLowerCase();
            if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                e.preventDefault();
            }
            // stopping event bubbling up the DOM tree..
            e.stopPropagation();
        };		
    };
})(window);
</script>

		<!-- SECTION -->
		<div class="section main main-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- Product main img -->
					
					<?php 
								include 'db.php';
								$product_id = $_GET['p'];
								
								$sql = " SELECT * FROM products ";
								$sql = "DELETE FROM products WHERE product_id = $product_id";
								if (!$con) {
									die("Connection failed: " . mysqli_connect_error());
								}
                                                             else
                                                                   {

								$result = mysqli_query($con, $sql);
                                                               
                                                                         }
								
?>
					<!-- product -->
					
					<!-- /product -->

				</div>
				<!-- /row -->
                
			</div>
			<!-- /container -->
		</div>
		<!-- /Section -->

		<!-- NEWSLETTER -->
		
		<!-- /NEWSLETTER -->

		<!-- FOOTER -->
<?php

include "footer.php";

?>
