<!-- Start Footer -->
		<footer class="container py-5 border-top">
	    <p class="float-right"><a href="#">Back to top</a></p>
	    <p>&copy; <?php echo date("Y") ?> <a href="http://gamier-lester.github.io/portfolio/" target="_blank"> Lester Jan A. Gamier </a></p>
	    <div>Icons made by <a href="https://www.freepik.com/" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" 			    title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" 			    title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
	  </footer>
		<!-- End Footer -->
	</main>
	<!-- End Main -->

	<!-- Jquery -->
	<script
  	src="https://code.jquery.com/jquery-3.3.1.min.js"
  	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  	crossorigin="anonymous"></script>
  <!-- <script type="text/javascript" src="<?php // get_url() ?>/assets/js/bootstrap/jquery-3.3.1.min.js"></script> -->
	<!-- Popper JS for Popovers -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <!-- <script type="text/javascript" src="<?php // get_url() ?>/assets/js/bootstrap/popper.min.js"></script> -->
	<!-- Bootstrap JS -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <!-- <script type="text/javascript" src="<?php // get_url() ?>/assets/js/bootstrap/bootstrap.min.js"></script> -->

	<!-- <script type="text/javascript" src="<?php //get_url() ?>/assets/js/script.js"></script> -->
	<!-- <script type="text/javascript" src="<?php //get_url() ?>/assets/js/ajax.js"></script> -->
	<?php if (isset($use_firebase)): ?>
	<!-- firebase -->
	<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/6.3.0/firebase-app.js"></script>

  <!-- Add Firebase products that you want to use -->
  <!-- <script src="https://www.gstatic.com/firebasejs/6.3.0/firebase-auth.js"></script> -->
  <!-- <script src="https://www.gstatic.com/firebasejs/6.3.0/firebase-firestore.js"></script> -->
  <script src="https://www.gstatic.com/firebasejs/5.9.1/firebase-storage.js"></script>
  <script>
    // TODO: Replace the following with your app's Firebase project configuration
    var firebaseConfig = {
		  apiKey: "AIzaSyBdk9I4E7wKCnYYMVwpzRxYneyWrM5jcW4",
		  authDomain: "ez-shopping-11c7a.firebaseapp.com",
		  databaseURL: "https://ez-shopping-11c7a.firebaseio.com",
		  projectId: "ez-shopping-11c7a",
		  storageBucket: "ez-shopping-11c7a.appspot.com",
		  messagingSenderId: "78410641074",
		  appId: "1:78410641074:web:ab3b63d1e1ddec8d"
		};

    // Initialize Firebase
    var firebase = firebase.initializeApp(firebaseConfig);
  </script>
	<!-- end firebase -->
	<?php endif; ?>
	<script type="text/javascript" src="<?php get_url() ?>/assets/js/script.js"></script>
	<!-- custome page js -->
	<?php global $page_js; ?>
	<script type="module" src="<?php get_url(); echo $page_js; ?>"></script>
</body>
</html>