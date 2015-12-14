<?php
 
  $enddate= date('Y-m-d', strtotime('+8 week'));

 $dt=explode('-',$enddate); $x=1;
                  $s=$dt[1]-$x;
                  $edate=$dt[0].",".$s.",".$dt[2];

?>
<script type="text/javascript">
   $(document).ready(function() {
          var austDay = new Date(<?php echo $edate; ?>); 
          $('#week8load').countdown({until:austDay});
    
   });
</script>

     <div id="week8load" class="snapshot-time-count"></div>
