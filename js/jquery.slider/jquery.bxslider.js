jQuery(document).ready(function ($) {
	var _SlideshowTransitions = [
		{$Duration:1000,$Delay:200,$Opacity:2}
	];
	var options = {
		$AutoPlay: true,
		$AutoPlaySteps: 1,
		$AutoPlayInterval: 2000,
		$PauseOnHover: 0,
		$ArrowKeyNavigation: true,
		$SlideDuration: 500,
		$MinDragOffsetToSlide: 20,
		//$SlideWidth: 981,
		//$SlideHeight: 594,
		$SlideSpacing: 0,
		$DisplayPieces: 1,
		$ParkingPosition: 0,
		$UISearchMode: 1,
		$PlayOrientation: 1,
		$DragOrientation: 3,

		$SlideshowOptions: {
			$Class: $JssorSlideshowRunner$,
			$Transitions: _SlideshowTransitions,
			$TransitionsOrder: 1,
			$ShowLink: true
		}
	};

	var jssor_slider = new $JssorSlider$("_slider", options);
	function ScaleSlider() {
		var parentWidth = $('#_slider').parent().width();
		if (parentWidth)
			jssor_slider.$ScaleWidth(parentWidth);
		else
			window.setTimeout(ScaleSlider, 30);
	}
	ScaleSlider();
	if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
		$(window).bind('resize', ScaleSlider);
	}
	if (navigator.userAgent.match(/(iPhone|iPod|iPad)/)) {
	    $(window).bind("orientationchange", ScaleSlider);
	}
	$Jssor$.$AddEvent(window, "load", ScaleSlider);
	$Jssor$.$AddEvent(window, "resize", $Jssor$.$WindowResizeFilter(window, ScaleSlider));
	$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);

});