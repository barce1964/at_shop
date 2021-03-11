<div class="page-buffer"></div>
</div>

<footer id="footer" class="page-footer"><!--Footer-->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2021</p>
                <p class="pull-right">Александр Тараев</p>
            </div>
        </div>
    </div>
</footer><!--/Footer-->



<script src="/template/js/jquery.js"></script>
<script src="/template/js/jquery.cycle2.min.js"></script>
<script src="/template/js/jquery.cycle2.carousel.min.js"></script>
<script src="/template/js/bootstrap.min.js"></script>
<script src="/template/js/jquery.scrollUp.min.js"></script>
<script src="/template/js/price-range.js"></script>
<script src="/template/js/jquery.prettyPhoto.js"></script>
<script src="/template/js/main.js"></script>

<!-- <script>
    $(document).ready(function(){
        $(".add-to-cart").click(function () {
            var id = $(this).attr("data-id");
            $.post("/cart/addAjax/"+id, {}, function (data) {
                $("#cart-count").html(data);
            });
            return false;
        });
    });
</script> -->

<!-- <script>
    // function subm() {
    //     console.log('test');
    //     function sendData(f) {
    //         const XHR = new XMLHttpRequest();

    //         // Bind the FormData object and the form element
    //         const FD = new FormData( f );

    //         // Define what happens on successful data submission
    //         XHR.addEventListener( "load", function(event) {
    //             alert( event.target.responseText );
    //         } );

    //         // Define what happens in case of error
    //         XHR.addEventListener( "error", function( event ) {
    //             alert( 'Oops! Something went wrong.' );
    //         } );

    //         // Set up our request
    //         XHR.open( "POST", "#" );
    //         console.log(FD);
    //         // The data sent is what the user provided in the form
    //         //XHR.send( FD );
    //     }

    //     // Access the form element...
    //     const form = document.getElementById( "cat" );
    //     //console.log(form.selcat.value);
    //     // ...and take over its submit event.
    //     // form.addEventListener( "submit", function ( event ) {
    //     //     event.preventDefault();

    //         sendData(form);
    //     //} );
    // }
    let sel = document.getElementById('catselect');
    sel.addEventListener('change', function(event) {
        let selcat = sel.value;
        
        let formData = new FormData();
        formData.set('selcat', selcat);

        let promise = fetch('../../controllers/AdminProductController.php', {
		    method: 'POST',
		    body: formData,
	    });
        
        const XHR = new XMLHttpRequest();
        XHR.open( "POST", "../../controllers/AdminProductController.php" );
        XHR.addEventListener( "error", function( event ) {
            alert( 'Oops! Something went wrong.' );
        });
        
        XHR.send(formData);
        // promise.then(
    	// 	response => {
	    // 		return response.text();
		//     }
    	// ).then(
	    // 	text => {
	    // 		alert(selcat); // результат выведем алертом на экран
		//     }
	    // );
        console.log(selcat);
        event.preventDefault();
    })
</script> -->

</body>
</html>