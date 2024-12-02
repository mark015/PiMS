 </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
       <?php include 'incl/footer.php';?>
        <!-- /footer content -->
      </div>
    </div>
	<?php include 'incl/script.php';?>
  <?php
    if($link == "dashboard"){
      include 'script/dashboard.php'; 
    }else if($link == "encoded"){
      include 'script/encoded.php'; 

    }else if($link == "withdrawal"){
      include 'script/withdrawal.php'; 

    }else if($link == "school"){
      include 'script/school.php'; 

    }
  ?>
  </body>
</html>