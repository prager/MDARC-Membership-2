<!-- Footer -->
       <footer class="p-5 bg-dark text-white text-center position-relative">
           <div class="container">
               <p class="lead">Copyright &copy; <a href="http://mdarc.org" class="text-decoration-none" target="_blank"><span class="link-warning">1947 - <script type="text/javascript">
        var today = new Date();
        document.write(today.getFullYear() );
     </script> MDARC</span></a></p>
               <a href="#" class="position-absolute bottom-0 end-0 p-5">
                   <i class="bi bi-arrow-up-circle h1"></i>
               </a>
           </div>
       </footer>

       <!-- Modals -->
       <?php include 'modal-login.php'; ?>
       <?php include 'modal-tech.php'; ?>
       <?php include 'modal-reset-pass.php'; ?>
       <?php include 'mod-confim-mem.php'; ?>

       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
       <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
       <script>
           mapboxgl.accessToken = 'pk.eyJ1IjoibGVob3MyNCIsImEiOiJja3ZxM29qMDBlbzRmMnBtbmRsNTg4cHY3In0.aRRDqiYJVURWAR3hfX0-1g';
           var map = new mapboxgl.Map({
           container: 'map',
           style: 'mapbox://styles/mapbox/streets-v11',
           center: [-122.021819, 37.987936],
           zoom: 12,
           });
       </script>
   </body>
</html>
