/* Form Js */
<script>
$('#timer').stopwatch().click(function() {
    $(this).stopwatch('reset');
}).stopwatch('start');
	var total_list = $('#progressbar li').length;
	var total_active = $('#progressbar li.active').length;
	var percentage_total = (total_active * 100) / total_list;
	var round_per = Math.round(percentage_total);
	jQuery('span#progress_bar span').html(round_per + '%');
	var percent_total = "0";
	jQuery('span#progress_bar').css('width', percentage_total + '%');
	jQuery('div#gradient_bar').css('width', percentage_total + '%');
	jQuery('#gradient_bar li').appendTo('#progressbar');
	jQuery('li.active').appendTo('#gradient_bar');
	if (jQuery('#progress_bar').find('span').html() == "0%") {
		jQuery('#progress_bar').css('width', '1.8%');
	}

jQuery(function() {
    jQuery("#business_type").autocomplete({
        source: '<?php echo BASE_URL; ?>/assessment/backend-script.php'
    });
    jQuery('.ui-autocomplete').on('click', '.ui-menu-item', function() {
        jQuery('#business_type').trigger('blur');
    });
});

$('#business_type').on('blur', function(e) {

    jQuery('#business_type').parents('fieldset').find('.no_result').hide();
    jQuery('#business_type').parents('fieldset').find('#note').hide();
    answer = $(this).val();
    if (answer.length > 1) {
        $.post("<?php echo BASE_URL; ?>/assessment/show_note.php", {
            answer: answer
        }, function(data) {
            var data = JSON.parse(data);
            if (data.statusCode == '200') {
                jQuery('#business_type').parents('fieldset').find('#note').empty();
                jQuery('#business_type').parents('fieldset').find('#note').append('<p>Please note, given the nature of service-based businesses, the tool will provide a more limited set of recommendations.</p>');
                jQuery('#business_type').parents('fieldset').find('#note').hide();
            } else if (data.statusCode == '201') {
                jQuery('#business_type').parents('fieldset').find('#note').empty()
                jQuery('#business_type').parents('fieldset').find('#note').hide();
            } else if (data.statusCode == '404') {
                jQuery('#business_type').parents('fieldset').find('#note').empty();
                jQuery('#business_type').parents('fieldset').find('#note').append('<p>No result found.</p>');
                jQuery('#business_type').parents('fieldset').find('#note').show();
                jQuery('#business_type').parents('fieldset').find('.no_result').show();
            } else if (data.statusCode == '202') {
                jQuery('#business_type').parents('fieldset').find('#note').empty();
                jQuery('#business_type').parents('fieldset').find('#note').append('<p>success</p>');
                jQuery('#business_type').parents('fieldset').find('#note').hide();
            } else if (data.statusCode == '203') {
                jQuery('#business_type').parents('fieldset').find('#note').empty();
                jQuery('#business_type').parents('fieldset').find('#note').hide();
            }
        });
    }
});


var current_fs, next_fs, previous_fs;
var left, opacity, scale;
var animating;
$(".steps").validate({
    errorClass: 'invalid',
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.insertAfter(element.next('span').children());
    },
    highlight: function(element) {
        $(element).next('span').show();
    },
    unhighlight: function(element) {
        $(element).next('span').hide();
    }
});   
    
	  
// form next question 
$(".next").click(function(e) {
    e.preventDefault();
    $(".steps").validate({
        errorClass: 'invalid',
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parents('fieldset').find('span').children());
        },
        highlight: function(element) {
            $(element).parents('fieldset').find('span').show();
        },
        unhighlight: function(element) {
            $(element).parents('fieldset').find('span').hide();
        }
    });
    if (animating) return false;
    animating = true;
    type = $(this).parents('fieldset').find('input').attr('type');
    business_id = $(this).parents('fieldset').find('input').attr('id');
    if (type == "range") {
        range_value = $(this).parents('fieldset').find('input').val();
        answer = $(this).parents('fieldset').find('.range_value').eq(range_value).find('span').html();
    } else if (type == "radio") {
        answer = $(this).parents('fieldset').find('span.checked input').val();

    } else if (type == "email") {
        var emailaddress = $(this).parents('fieldset').find('input').val();
        if (!validateEmail(emailaddress)) {
            jQuery(this).parents('fieldset').find('span.error1 span').remove();
            var error_message = 'Please enter a valid email';
            jQuery(this).parents('fieldset').find('span.error1').append('<span>' + error_message + '</span>').show();
            var answer = "";
        } else {
            jQuery(this).parents('fieldset').find('span.error1').hide();
            answer = $(this).parents('fieldset').find('input').val();
        }
    } else if (type == "url") {
        var url = $(this).parents('fieldset').find('input').val();
        var url_validate = /https?:\/\/w{0,3}\w*?\.(\w*?\.)?\w{2,3}\S*|www\.(\w*?\.)?\w*?\.\w{2,3}\S*|(\w*?\.)?\w*?\.\w{2,3}[\/\?]\S*/;
        if (!url_validate.test(url)) {
            jQuery(this).parents('fieldset').find('span.error1 span').remove();
            var error_message = 'Please enter a valid url';
            jQuery(this).parents('fieldset').find('span.error1').append('<span>' + error_message + '</span>').show();
            answer = "";
        } else {
            jQuery(this).parents('fieldset').find('span.error1').hide();
            answer = $(this).parents('fieldset').find('input').val();
        }
    } else if (business_id == 'business_type') {
        valid = $(this).parents('fieldset').find('#note p').html();
        if (valid == 'No result found.' || valid == undefined) {
            answer = "";
        } else if (valid == 'success' || valid == 'Please note, given the nature of service-based businesses, the tool will provide a more limited set of recommendations.') {
            answer = $(this).parents('fieldset').find('input').val();
        }
    } else if (business_id == 'business_launch') {
        valid_min = $(this).parents('fieldset').find('input').attr('min');
        valid_max = $(this).parents('fieldset').find('input').attr('max');
        answer_valid = $(this).parents('fieldset').find('input').val();
        if (valid_min <= answer_valid && valid_max >= answer_valid) {
            answer = $(this).parents('fieldset').find('input').val();
        } else {
            jQuery(this).parents('fieldset').find('span.error1 span').remove();
            var error_message = 'Please enter a year between ' + valid_min + ' and ' + valid_max;
            jQuery(this).parents('fieldset').find('span.error1').append('<span>' + error_message + '</span>').show();
            answer = "";
        }
    } else {
        answer = $(this).parents('fieldset').find('input').val();
    }
    answer_select = $(this).parents('fieldset').find(":selected").map(function() {
        return this.text
    }).get().join(',');
    name = $(this).parents('fieldset').find('input').attr('name');
    name_select = $(this).parents('fieldset').find('select').attr('name');
    next_question_id = $(this).parents('fieldset').next().find('p.question_id').html();
    question_order = $(this).parents('fieldset').find('p.question_order').html();
    current_question_id = $(this).parents('fieldset').find('p.question_id').html();
    var time = jQuery('#timer').html();
    jQuery('#timer').trigger('click');
    var id = "<?php echo $id;?>";
    if (answer_select == "Please select a choice") {
        answer_select = "";
    }
    if (typeof answer == "undefined" || answer == "") {
        if (jQuery(this).parents('fieldset').find('span.error1 span').length) {
            jQuery(this).parents('fieldset').find('span.error1').eq(0).show();
        } else {
            var question_text = jQuery(this).parents('fieldset').find('.fs-title').html();
            var error_message = 'Please give an answer';
            jQuery(this).parents('fieldset').find('span.error1').append('<span>' + error_message + '</span>').show();
        }
        current_fs = $(this).parents('fieldset');
        next_fs = $(this).parents('fieldset');
        current_fs.animate({}, {
            step: function(now, mx) {
                scale = 1 - (1 - now) * 0.2;
                left = (now * 50) + "%";
                opacity = 1 - now;
                next_fs.css({
                    'left': left,
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function() {
                animating = false;
            },
            easing: 'easeInOutExpo'
        });
    } else if (answer == "Previous Question" && answer_select == "") {
        if (jQuery(this).parents('fieldset').find('span.error1 span').length) {
            jQuery(this).parents('fieldset').find('span.error1').show();
        } else {
            jQuery(this).parents('fieldset').find('span.error1').hide();
            var question_text = jQuery(this).parents('fieldset').find('.fs-title').html();
            var error_message = 'Please give an answer';
            jQuery(this).parents('fieldset').find('span.error1').append('<span>' + error_message + '</span>').show();
        }
        current_fs = $(this).parents('fieldset');
        next_fs = $(this).parents('fieldset');
        current_fs.animate({

        }, {
            step: function(now, mx) {
                scale = 1 - (1 - now) * 0.2;
                left = (now * 50) + "%";
                opacity = 1 - now;
                next_fs.css({
                    'left': left,
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function() {
                animating = false;
            },
            easing: 'easeInOutExpo'
        });
    } else {
        var button = $(this);
        var submit = $(this).attr('value');
        var prev_buton = $(this).parents('fieldset').find('.previous');
        button.val('Loading...');
        button.css('pointer-events', 'none');
        prev_buton.css('pointer-events', 'none');
        if (submit == "View Your Result") {
            var city = "<?php echo $ip_city;?>",
                region = "<?php echo $ip_region;?>",
                zip = "<?php echo $ip_zip;?>",
                ipaddress = "<?php echo $ip_address;?>";
            reference = "<?php echo $reference;?>";
            mailchimp = jQuery('.mailchimp_inner').eq(0).find('input.custom_check').val();
            sharing_business = jQuery('.mailchimp_inner').eq(1).find('input.custom_check').val();
            var img = jQuery('#drop-area img').attr('src');
            if (mailchimp == undefined) {
                mailchimp = "No";
            }
            if (sharing_business == undefined) {
                sharing_business = "No";
                img = "";
            } else {
                if (img == undefined) {
                    img = "";
                }
            }
            if (jQuery('.mailchimp_inner.business_share').css('display') == 'none') {
                sharing_business = "No";
                img = "";
            }
            $.post("<?php echo BASE_URL; ?>/assessment/ip_data.php", {
                city,
                region,
                zip,
                ipaddress,
                id,
                reference,
                mailchimp,
                sharing_business,
                img
            }, function(data) {
                location.reload();
            });
        } else {
            next_fs_skip = $(this).parents('fieldset').next().next();
            current_fs = $(this).parents('fieldset');
            current_fs_bar = $(this).parents('fieldset').next();
            next_fs = $(this).parents('fieldset').next();
            var share_opt = $(this).parents('fieldset').next().find('.next').val();
            if (share_opt == 'View Your Result') {
                $.post("<?php echo BASE_URL; ?>/assessment/opt_business_ajax.php", {
                    id
                }, function(data) {
                    var data = JSON.parse(data);
                    if (data.statusCode == '200') {
                        jQuery('div#wrapper').hide();
                        jQuery('.mailchimp_inner.business_share').hide();
                    } else if (data.statusCode == '201') {
                        jQuery('div#wrapper').show();
                        jQuery('.mailchimp_inner.business_share').show();
                    }
                });
            }
            var it_works = 'false';
            $.post("<?php echo BASE_URL; ?>/assessment/sqldata.php", {
                answer,
                answer_select,
                name,
                name_select,
                id,
                time,
                current_question_id,
                next_question_id,
                question_order
            }, function(data) {
                var array = data;
                array = array.replace("[", "");
                array = array.replace("]", "");
                array = array.replaceAll('"', '');
                var substr = array.split(',');
                jQuery("fieldset").removeClass("dep_hide");
                for (var i = 0; i < substr.length; i++) {
                    var hid = substr[i] - 1;
                    jQuery("fieldset").eq(hid).addClass("dep_hide");
                }
                jQuery(current_fs).hide();
                for (var i = 0; i < 50; i++) {
                    if (jQuery(current_fs).next().hasClass("dep_hide")) {
                        $("#progressbar li").eq($("fieldset").index(current_fs)).addClass("active");
                        next_fs = jQuery(current_fs).next().next();
                        current_fs = jQuery(current_fs).next();
                    }
                }
                $("#progressbar li").eq($("fieldset").index(current_fs)).addClass("active");
                next_fs_skip.hide();
                var total_list = $('#progressbar li').length;
                var total_active = $('#progressbar li.active').length;
                var percentage_total = (total_active * 100) / total_list;
                var round_per = Math.round(percentage_total);
                jQuery('span#progress_bar span').html(round_per + '%');
                var percent_total = "0";
                jQuery('span#progress_bar').css('width', percentage_total + '%');
                jQuery('div#gradient_bar').css('width', percentage_total + '%');
                jQuery('#gradient_bar li').appendTo('#progressbar');
                jQuery('li.active').appendTo('#gradient_bar');
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now, mx) {
                        scale = 1 - (1 - now) * 0.2;
                        left = (now * 50) + "%";
                        opacity = 1 - now;
                        current_fs.css({
                            'transform': 'scale(' + scale + ')'
                        });
                        next_fs.css({
                            'left': '0',
                            'opacity': '1',
                            'transform': 'unset'
                        });
                    },
                    duration: 800,
                    complete: function() {
                        current_fs.hide();
                        next_fs.show();
                        button.val('Next');
                        button.css('pointer-events', 'unset');
                        prev_buton.css('pointer-events', 'unset');
                        animating = false;
                    },
                    easing: 'easeInOutExpo'
                });
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            });
        }
    }
});  

// form submit
	
    $(".submit").click(function() {
    $(".steps").validate({
        errorClass: 'invalid',
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.insertAfter(element.next('span').children());
        },
        highlight: function(element) {
            $(element).next('span').show();
        },
        unhighlight: function(element) {
            $(element).next('span').hide();
        }
    });
    if ((!$('.steps').valid())) {
        return false;
    }
    if (animating) return false;
    animating = true;
    current_fs = $(this).parents('fieldset');
    next_fs = $(this).parents('fieldset').next();
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
    next_fs.show();
    current_fs.animate({
        opacity: 0
    }, {
        step: function(now, mx) {
            scale = 1 - (1 - now) * 0.2;
            left = (now * 50) + "%";
            opacity = 1 - now;
            current_fs.css({
                'transform': 'scale(' + scale + ')'
            });
            next_fs.css({
                'left': left,
                'opacity': opacity
            });
        },
        duration: 800,
        complete: function() {
            current_fs.hide();
            animating = false;
        },
        easing: 'easeInOutExpo'
    });
});
	
// form prev button click 
	
$(".previous").click(function() {
	var submit = $(this).attr('value');
	var button = $(this);
	var prev_buton = $(this).parents('fieldset').find('.next');
	button.val('Loading...');
	button.css('pointer-events', 'none');
	prev_buton.css('pointer-events', 'none');
	if (animating) return false;
	animating = true;
	next_fs_skip = $(this).parents('fieldset').prev().prev();
	current_fs = $(this).parents('fieldset');
	current_fs_bar = $(this).parents('fieldset').prev();
	next_fs = $(this).parents('fieldset').prev();
	next_question_id = $(this).parents('fieldset').prev().find('p.question_id').html();
	question_order = $(this).parents('fieldset').find('p.question_order').html();
	var id = "<?php echo $id;?>";
	var it_works = 'false';
	$.post("<?php echo BASE_URL; ?>/assessment/ques_dependency.php", {
    id,
    next_question_id,
    question_order
	}, function(data) {
		var array = data;
		array = array.replace("[", "");
		array = array.replace("]", "");
		array = array.replaceAll('"', '');
		var substr = array.split(',');
		jQuery("fieldset").removeClass("dep_hide");
		for (var i = 0; i < substr.length; i++) {
			var hid = substr[i] - 1;
			jQuery("fieldset").eq(hid).addClass("dep_hide");
		}
		jQuery(current_fs).hide();
		for (var i = 0; i < 50; i++) {
			if (jQuery(current_fs).prev().hasClass("dep_hide")) {
				$("#gradient_bar li.active").eq($("fieldset").index(current_fs)).removeClass("active");
				$("#gradient_bar li.active").eq($("fieldset").index(current_fs_bar)).removeClass("active");
				$("#gradient_bar li.active").eq($("fieldset").index(next_fs_skip)).removeClass("active");
				next_fs = jQuery(next_fs).prev();
				current_fs = jQuery(current_fs).prev();
				current_fs_bar = jQuery(current_fs_bar).prev();
				next_fs_skip = jQuery(next_fs_skip).prev();
			}
		}
		$("#gradient_bar li.active").eq($("fieldset").index(current_fs_bar)).removeClass("active");
		var total_list = $('#progressbar li').length;
		var total_active = $('#progressbar li.active').length;
		var percentage_total = (total_active * 100) / total_list;
		var round_per = Math.round(percentage_total);
		jQuery('span#progress_bar span').html(round_per + '%');
		var percent_total = "0";
		jQuery('span#progress_bar').css('width', percentage_total + '%');
		jQuery('div#gradient_bar').css('width', percentage_total + '%');
		jQuery('#gradient_bar li').appendTo('#progressbar');
		jQuery('li.active').appendTo('#gradient_bar');
		if (jQuery('#progress_bar').find('span').html() == "0%") {
			jQuery('#progress_bar').css('width', '1.8%');
		}
		current_fs.animate({
			opacity: 0
		}, {
			step: function(now, mx) {
				scale = 1 - (1 - now) * 0.2;
				left = (now * 50) + "%";
				opacity = 1 - now;
				current_fs.css({
					'transform': 'scale(' + scale + ')'
				});
				next_fs.css({
					'left': '0',
					'opacity': '1',
					'transform': 'unset'
				});
			},
			duration: 800,
			complete: function() {
				current_fs.hide();
				next_fs.show();
				button.val('Previous Question');
				button.css('pointer-events', 'unset');
				prev_buton.css('pointer-events', 'unset');
				animating = false;
			},
			easing: 'easeInOutExpo'
		});
		document.body.scrollTop = 0; // For Safari
		document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera	   	
	});
});

/*Drag And Drop Table Js */
$(function() {
	$("#sortable tbody").sortable({
		cursor: "move",
		placeholder: "sortable-placeholder",
		helper: function(e, tr) {
			var $originals = tr.children();
			var $helper = tr.clone();
			var $order_one = tr.children().eq(5).html();

			$helper.children().each(function(index) {
				$(this).width($originals.eq(index).width());
			});
			return $helper;
		},
		start: function(event, ui) {
			var currPos1 = ui.item.index();
		},
		update: function(event, ui) {
			var inc = 1;
			var currPos = ui.item.index();
			var currPos = currPos + inc;
			var prevPos = ui.item.children().eq(1).html();
			$.post("alert_order.php", {
				prev: prevPos,
				curr: currPos
			}, function(data) {
				if (data > 0) {
					if (confirm("Dependency is going to be removed!\nAre you sure you want to re-order this?")) {
						$.post("question_order.php", {
							prev: prevPos,
							curr: currPos
						}, function(data) {
							var data = JSON.parse(data);
							if (data.statusCode == 200) {
								location.reload();
							}
						});
					} else {
						location.reload();
					}
				} else {
					$.post("question_order.php", {
						prev: prevPos,
						curr: currPos
					}, function(data) {
						var data = JSON.parse(data);
						if (data.statusCode == 200) {
							location.reload();
						}
					});
				}
			});
		}
	}).disableSelection();
});
</script>