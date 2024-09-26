<div class="footer">
	<div class="wrapper">
		<div class="section group">
			<div class="col_1_of_4 span_1_of_4">
				<h4>Thông tin</h4>
				<ul>
					<li><a href="#">Về chúng tôi</a></li>
					<li><a href="#">Dịch vụ khách hàng</a></li>
					<li><a href="#"><span>Tìm kiếm nâng cao</span></a></li>
					<li><a href="#">Đơn đặt hàng và trả lại</a></li>
					<li><a href="#"><span>Liên hệ với chúng tôi</span></a></li>
				</ul>
			</div>
			<div class="col_1_of_4 span_1_of_4">
				<h4>Mua đồ từ chúng tôi</h4>
				<ul>
					<li><a href="about.php">Về chúng tôi</a></li>
					<li><a href="faq.php">Dịch vụ khách hàng</a></li>
					<li><a href="#">Điều khoản cá nhân</a></li>
					<li><a href="contact.php"><span>Bản đồ cửa hàng</span></a></li>
					<li><a href="details.php"><span>Tìm kiếm điều khoản</span></a></li>
				</ul>
			</div>
			<div class="col_1_of_4 span_1_of_4">
				<h4>Tài khoản của bạn</h4>
				<ul>
					<li><a href="contact.php">Đăng nhập</a></li>
					<li><a href="index.php">Xem giỏ hàng</a></li>
					<li><a href="#">Mong ước của bạn</a></li>
					<li><a href="#">Theo dõi đơn hàng</a></li>
					<li><a href="faq.php">Giúp đỡ</a></li>
				</ul>
			</div>
			<div class="col_1_of_4 span_1_of_4">
				<h4>Liên hệ</h4>
				<ul>
					<li><span>+84-0123456789</span></li>
					<li><span>+84-0987654321</span></li>
				</ul>
				<div class="social-icons">
					<h4>Theo dõi chúng tôi</h4>
					<ul>
						<li class="facebook"><a href="#" target="_blank"> </a></li>
						<li class="twitter"><a href="#" target="_blank"> </a></li>
						<li class="googleplus"><a href="#" target="_blank"> </a></li>
						<li class="contact"><a href="#" target="_blank"> </a></li>
						<div class="clear"></div>
					</ul>
				</div>
			</div>
		</div>
		<div class="copy_right">
			<p>Store DB © 2024 </p>
		</div>
	</div>
</div>
<!-- Chatbot -->
<div class="chat-container" id="chat-container">
    <div id="chat-history"></div>
    <form id="chat-form">
        <input type="text" id="user-input" autocomplete="off" placeholder="Type your message...">
        <button type="submit">Send</button>
    </form>
</div>

<div class="chat-icon" id="chat-icon">
    <button><img src="../images/chat-bot-icon.svg" ></button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#chat-icon').click(function () {
            $('#chat-container').toggleClass('show');
        });

        $('#chat-form').submit(function (e) {
            e.preventDefault();
            var message = $('#user-input').val().trim();
            if (message !== '') {
                $('#chat-history').append('<div class="user-message">' + message + '</div>');
                $('#user-input').val('');
                $.ajax({
                    url: 'http://127.0.0.1:8000/get_response',  // Đường dẫn API của Flask
                    method: 'POST',
                    data: {message: message},
                    success: function (data) {
                        $('#chat-history').append('<div class="bot-message">' + data.response + '</div>');
                    }
                });
            }
        });
    });
</script>


<!-- <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<df-messenger
  intent="WELCOME"
  chat-title="TE-AI-Test"
  agent-id="99bb348f-793b-4051-9a60-b604d5bc9f97"
  language-code="en">
</df-messenger> -->

<script type="text/javascript">
	$(document).ready(function() {
		/*
		var defaults = {
				containerID: 'toTop', // fading element id
			containerHoverID: 'toTopHover', // fading element hover id
			scrollSpeed: 1200,
			easingType: 'linear' 
			};
		*/

		$().UItoTop({
			easingType: 'easeOutQuart'
		});

	});
</script>
<a href="#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>
<link href="css/flexslider.css" rel='stylesheet' type='text/css' />
<script defer src="js/jquery.flexslider.js"></script>
<script type="text/javascript">
	$(function() {
		SyntaxHighlighter.all();
	});
	$(window).load(function() {
		$('.flexslider').flexslider({
			animation: "slide",
			start: function(slider) {
				$('body').removeClass('loading');
			}
		});
	});
</script>

<script>
	$('.buy_checked').change(function() {
		var id_cart = $(this).val();
		// alert(id_cart)

		if ($(this).is(':checked')) {
			var cart_status = 1;
			$.ajax({
				url: 'ajax/stick_buy.php',
				data: {
					id_cart: id_cart,
					cart_status: cart_status
				},
				type: 'post',
				success: function() {
					alert('Check mua hàng thành công');
				}

			});
		} else {
			var cart_status = 0;
			$.ajax({
				url: 'ajax/stick_buy.php',
				data: {
					id_cart: id_cart,
					cart_status: cart_status
				},
				type: 'post',
				success: function() {
					alert('Check bỏ mua hàng thành công');
				}
			});
		}
	})
</script>

<script>
	function remove_background(product_id) {
		for (var count = 1; count <= 5; count++) {
			$('#' + product_id + '-' + count).css('color', '#ccc');
		}
	}
	//hover chuột đánh giá sao
	$(document).on('mouseenter', '.rating', function() {
		var index = $(this).data("index"); //3
		var product_id = $(this).data('product_id'); //13

		// alert(index);
		// alert(product_id);
		remove_background(product_id);
		for (var count = 1; count <= index; count++) {
			$('#' + product_id + '-' + count).css('color', '#ffcc00');
		}
	});
	//nhả chuột ko đánh giá
	$(document).on('mouseleave', '.rating', function() {
		var index = $(this).data("index");
		var product_id = $(this).data('product_id');
		var rating = $(this).data("rating");
		remove_background(product_id);
		//alert(rating);
		for (var count = 1; count <= rating; count++) {
			$('#' + product_id + '-' + count).css('color', '#ffcc00');
		}
	});
</script>
<script>
	$('.rating').click(function() {
		var index = $(this).data("index"); //3
		var product_id = $(this).data('product_id');
		var user_id = $(this).data('user_id');
		$.ajax({
			url: 'ajax/rating.php',
			data: {
				index: index,
				product_id: product_id,
				user_id: user_id
			},
			type: 'POST',
			success: function(data) {
				alert('Đánh giá ' + index + ' sao thành công');
				// Reload the page after successful rating
				location.reload();
			}
		});
	})
	$(document).on('click', '.rating_login', function() {
		alert('Làm ơn đăng nhập để đánh giá sao.');
	})
</script>

<script>
	$('.price_from').val(<?php echo $min_price ?>);
	$('.price_to').val(<?php echo $max_price/2 ?>);
	$(function () {
		var priceFrom = <?php echo isset($price_from) ? $price_from : $min_price; ?>;
		var priceTo = <?php echo isset($price_to) ? $price_to : $max_price; ?>;

		$("#slider-range").slider({
			range: true,
			min: <?php echo $min_price; ?>,
			max: <?php echo $max_price; ?>,
			values: [priceFrom, priceTo],
			slide: function (event, ui) {
				$("#amount").val(ui.values[0] + " VND - " + ui.values[1] + " VND");
				$("#price_from").val(ui.values[0]);
				$("#price_to").val(ui.values[1]);
				localStorage.setItem("sliderValues", JSON.stringify(ui.values)); // Store values in localStorage
			}
		});

		var storedSliderValues = localStorage.getItem("sliderValues");
		if (storedSliderValues) {
			var parsedValues = JSON.parse(storedSliderValues);
			$("#slider-range").slider("values", parsedValues);
			$("#amount").val(parsedValues[0] + " VND - " + parsedValues[1] + " VND");
			$("#price_from").val(parsedValues[0]);
			$("#price_to").val(parsedValues[1]);
		} else {
			$("#amount").val(priceFrom + " VND - " + priceTo + " VND");
			$("#price_from").val(priceFrom);
			$("#price_to").val(priceTo);
		}
	});
	function addPlus(nStr)
			{
				nStr += '';
				x = nStr.split('.');
				x1 = x[0];
				x2 = x.length > 1 ? '.' + x[1] : '';
				var rgx = /(\d+)(\d{3})/;
				while (rgx.test(x1)) {
					x1 = x1.replace(rgx, '$1' + '.' + '$2');
				}
				return x1 + x2;
			}
  </script>
  <script>
	function myFunction() {
		var x = document.getElementById("myTopnav");
		if (x.className === "topnav") {
			x.className += " responsive";
		} else {
			x.className = "topnav";
		}
	}
</script>
</body>

</html>