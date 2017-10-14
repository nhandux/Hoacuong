<style>
.popup {
	display: block;
	max-width: 520px;
	width: 90%;
	margin: 0;
	line-height: 0;
}
.popup a.close {
	position: absolute;
	display: block;
	right: -15px;
	top: -15px;
	line-height: 0;
}
</style>
<div id="new-year" class="popup">
	<a href="" class="close bClose">
    	<img src="/popup/btn_close.png" alt="Close"/>
    </a>
	<div class="website-new-year">
		<a target="_blank" href="http://danaweb.vn/">
			<img src="/popup/new_year.jpg" alt="Website under construction.">
		</a>
	</div>
</div>
<script type="text/javascript" src="/popup/jquery.bpopup.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#new-year').bPopup({
		easing: 'easeOutBack',
		speed: 1689
	});
});
</script>