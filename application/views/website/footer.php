
		<!-- jQuery -->
		<script src="<?= base_url('assets/lawmaker/') ?>js/jquery.min.js"></script>
		<!-- jQuery Easing -->
		<script src="<?= base_url('assets/lawmaker/') ?>js/jquery.easing.1.3.js"></script>
		<!-- Bootstrap -->
		<script src="<?= base_url('assets/lawmaker/') ?>js/bootstrap.min.js"></script>
		<!-- Waypoints -->
		<script src="<?= base_url('assets/lawmaker/') ?>js/jquery.waypoints.min.js"></script>
		<!-- Stellar Parallax -->
		<script src="<?= base_url('assets/lawmaker/') ?>js/jquery.stellar.min.js"></script>
		<!-- Carousel -->
		<script src="<?= base_url('assets/lawmaker/') ?>js/owl.carousel.min.js"></script>
		<!-- Flexslider -->
		<script src="<?= base_url('assets/lawmaker/') ?>js/jquery.flexslider-min.js"></script>
		<!-- countTo -->
		<script src="<?= base_url('assets/lawmaker/') ?>js/jquery.countTo.js"></script>
		<!-- Magnific Popup -->
		<script src="<?= base_url('assets/lawmaker/') ?>js/jquery.magnific-popup.min.js"></script>
		<script src="<?= base_url('assets/lawmaker/') ?>js/magnific-popup-options.js"></script>
		<!-- Main -->
		<script src="<?= base_url('assets/lawmaker/') ?>js/main.js"></script>
		<script src="<?= base_url('assets/lawmaker/') ?>wa/floating-wpp.min.js"></script>

		<script>
			$(function() {
				$('#tombol_wa').floatingWhatsApp({
					phone: '628123456789',
					popupMessage: 'Selamat datang di website IEA Banjarbaru tulis pertanyaan anda pada kolom chat dibawah ini',
					message: "Permisi, saya mau tanya tentang ....",
					showPopup: true,
					showOnIE: false,
					headerTitle: '<b>Admin IEA Banjarbaru</b>',
					headerColor: '#25D366',
					backgroundColor: '#25D366',
					buttonImage: '<img src="<?= base_url('assets/lawmaker/') ?>wa/whatsapp.svg" />'
				});
			});
		</script>

		</body>

		</html>