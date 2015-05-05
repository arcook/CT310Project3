		</main>     
		<footer class='footer'>
            <div>
			<p>Modified by Andrew Cook, Brad Alberts, & Travis Menghini
            <?php
                $timeDiff =  time() - $_SESSION['time'];
                echo "<br/>Session started $timeDiff seconds ago.</p>"; 
            ?>
            </div>
		</footer>
		<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php
   //<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    //<script src="https://www.cs.colostate.edu/~ct310/yr2015sp/bootstrap/js/bootstrap.min.js"></script>

    ?>
</body>
</html>