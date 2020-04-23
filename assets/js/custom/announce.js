
function selectCategoryPrimary(code, secondary, custom_fields) {
    var boxReturn = $("#ai-f-c-sub");

    $("#ai-category").val("");

    boxReturn.html("<i class='fa fa-fw fa-spin fa-cog'></i>");

    $.post(base_url + '/announce/categories', {category: code}, function(data, textStatus, xhr) {
        /* nothing */
    }).done(function(data) {
        boxReturn.html(data);

        if (secondary) {
            setTimeout(function() {
                $("#ai-f-c-sub li[data-id='" + secondary + "']").addClass('active');

                selectCategorySecondary(secondary, custom_fields);
            }, 500);
        }
    }).error(function() {
        boxReturn.html("");
        $("#ai-f-c-parent li").removeClass('active');
    }).always(function() {
        console.clear();
    });
}

function selectCategorySecondary(code, custom_fields) {
    customFields(code, custom_fields);

    $("#ai-category").val(code);
}

function settingPrice(obj, type) {
    if (type == 'service') {
        if (obj.is(':checked')) {
            $("#ai-price").attr('disabled', 'disabled');
            $("#ai-yes-trade").attr('checked', false);
        } else {
            $("#ai-price").removeAttr('disabled');
        }
    }

    if (type == 'trade') {
        if (obj.is(':checked')) {
            $("#ai-no-price").attr('checked', false);
            $("#ai-price").removeAttr('disabled');
        }
    }
}

function settingAddress(obj) {
    if (obj.is(':checked')) {
        $("#ai-cep, #ai-address, #ai-neighborhood, #ai-region, #ai-city, #ai-state").attr('disabled', 'disabled');
    } else {
        $("#ai-cep, #ai-address, #ai-neighborhood, #ai-region, #ai-city, #ai-state").removeAttr('disabled');
    }
}

function customFields(code, custom_fields) {
    var boxReturn = $("#ai-custom-fields");

    boxReturn.html("<div class='row'><div class='small-3 medium-2 columns'>&nbsp;</div><div class='small-9 medium-10 columns'><i class='fa fa-fw fa-spin fa-cog'></i><br><br></div></div>");

    $.ajax({
        url: base_url + '/main/category_fields',
        type: 'POST',
        data: {category: code, ads_fields: custom_fields},
    })
            .done(function(data) {
                if (data) {
                    boxReturn.html(data);
                } else {
                    boxReturn.html('');
                }
            })
            .fail(function() {
                console.log("custom fields: error");

                boxReturn.html('');
            })
            .always(function() {
                // console.log("custom fields: complete");
            });
}

function sliderControls() {
    var sliderHeight = $("#ap-i-slider").height();
    var controls = $(".ap-images .ap-i-controls");

    controls.css('margin-bottom', '-' + sliderHeight + 'px');
    controls.children('.ap-ic-btn').height(sliderHeight);
}

$(document).ready(function() {
    $("#ai-city, #ai-state, #ai-region").change(function() {
        $("#box-neighborhood").hide();
        $("#box-address").hide();
    });

    $("#ai-state").change(function() {
        var state_code = $(this).val();

        $.getJSON(base_url + '/address/getbycep/' + state_code + '/regions', function(data) {

            if (data.regions != null) {
                $("#ai-region").empty();
                $('#ai-region').append('<option>Região da Cidade</option>');
                $.each(data.regions, function(index, value) {
                    if (value.region_id == data.region_id) {
                        $('#ai-region').append('<option value="' + value.region_id + '" selected="selected">' + value.name + '</option>');
                    } else {
                        $('#ai-region').append('<option value="' + value.region_id + '">' + value.name + '</option>');
                    }
                });
            }
        });

    });

    $("#ai-region").change(function() {
        var state_code = $(this).val();

        $.getJSON(base_url + '/address/getbycep/' + state_code + '/city', function(data) {

            if (data.cities != null) {
                $("#ai-city").empty();
                $('#ai-city').append('<option>Selecione um município</option>');
                $.each(data.cities, function(index, value) {
                    if (value.city_id == data.city_id) {
                        $('#ai-city').append('<option value="' + value.city_id + '" selected="selected">' + value.name + '</option>');
                    } else {
                        $('#ai-city').append('<option value="' + value.city_id + '">' + value.name + '</option>');
                    }
                });
            }
        });

    });

    $("#ai-cep").keyup(function() {
        var cep_code = $(this).val();
        if (cep_code.length == 9) {
            $.getJSON(base_url + '/address/getbycep/' + cep_code, function(data) {
                ;

                if (data.states != null) {
                    $("#ai-state").empty()
                    $('#ai-state').append('<option>Selecione seu Estado</option>');
                    $.each(data.states, function(index, value) {
                        if (value.state_id == data.state_id) {
                            $('#ai-state').append('<option value="' + value.state_id + '" selected="selected">' + value.name + '</option>');
                        } else {
                            $('#ai-state').append('<option value="' + value.state_id + '">' + value.name + '</option>');
                        }
                    });
                }

                if (data.cities != null) {
                    $("#ai-city").empty();
                    $('#ai-city').append('<option>Selecione um município</option>');
                    $.each(data.cities, function(index, value) {
                        if (value.city_id == data.city_id) {
                            $('#ai-city').append('<option value="' + value.city_id + '" selected="selected">' + value.name + '</option>');
                        } else {
                            $('#ai-city').append('<option value="' + value.city_id + '">' + value.name + '</option>');
                        }
                    });
                }

                if (data.neighborhoods != null) {
                    $.each(data.neighborhoods, function(index, value) {
                        if (value.neighborhood_id == data.neighborhood_id) {
                            $("#box-neighborhood").show();
                            $('#label-neighborhood').html('<b>Bairro:</b><br>' + value.name);
                            $('#ai-neighborhood').val(value.name);
                        }
                    });
                }

                if (data.regions != null) {
                    $("#ai-region").empty();
                    $('#ai-region').append('<option>Região da Cidade</option>');
                    $.each(data.regions, function(index, value) {
                        if (value.region_id == data.region_id) {
                            $('#ai-region').append('<option value="' + value.region_id + '" selected="selected">' + value.name + '</option>');
                        } else {
                            $('#ai-region').append('<option value="' + value.region_id + '">' + value.name + '</option>');
                        }
                    });
                }

                if (data.addressText != null) {
                    $("#box-address").show();
                    $("#label-address").html('<b>Endereço:</b><br>' + data.addressText);
                    $("#ai-address").val(data.addressText);
                }




            });
        }
    });

    /* categories - begin */
    $("#ai-f-c-parent").on('click', 'li', function(event) {
        var btn = $(this);
        var code = btn.attr('data-id');
        event.preventDefault();

        $("#ai-f-c-parent li").removeClass('active');
        btn.addClass('active');

        selectCategoryPrimary(code, false);
    });

    $("#ai-f-c-sub").on('click', 'li', function(event) {
        var btn = $(this);
        var code = btn.attr('data-id');

        event.preventDefault();

        $("#ai-f-c-sub li").removeClass('active');
        btn.addClass('active');

        selectCategorySecondary(code);
    });
    /* categories - end */

    /* price - begin */
    $("#ai-no-price").on('change', function(event) {
        var obj = $(this);

        event.preventDefault();

        settingPrice(obj, 'service');
    });

    $("#ai-yes-trade").on('change', function(event) {
        var obj = $(this);

        event.preventDefault();

        settingPrice(obj, 'trade');
    });
    /* price - end */

    /* images upload - begin */
    $("#ai-f-images-input").on('change', function(event) {
        var obj = $(this)[0];
        var files = obj.files;
        var files_qty = files.length;
        var box = $('#ai-f-images-box');

        /* config */
        var max_size = 1024 * 90; // 4 MB: 1048576 * 4
        var count = 0;

        box.html('');

        while (count <= (files_qty - 1)) {
            var file = files[count];
            var file_name = file.name;

            console.log(file);

            if (file.size >= max_size) {
                console.log("A imagem " + file.name + " está acima do tamanho máximo!");
            }

            var test = 300 * (count + 1);

            setTimeout(function() {
                var img = new Image;
                img.src = URL.createObjectURL(file);

                img.onload = function() {
                    var picWidth = this.width;
                    var picHeight = this.height;
                    var wdthHghtRatio = picHeight / picWidth;

                    if (Number(picWidth) > 150) {
                        var newHeight = Math.round(Number(150) * wdthHghtRatio);
                    } else {
                        return false;
                    }
                    ;

                    var cnvs_html = '<canvas id="cnvs_' + count + '" width="150" height="150"></canvas>';

                    box.prepend('<div class="item">' + cnvs_html + '</div>');

                    var cnvs = document.getElementById("cnvs_" + count);
                    var ctx = cnvs.getContext("2d");

                    ctx.drawImage(img, 0, ((150 / 2) - (newHeight / 2)), 150, newHeight);
                };
            }, test);

            count++;
        }

        $("#ai-f-images-count").html(files_qty + " imagem(s) selecionada(s)")
    });
    /* images upload - end */

    /* address - begin */
    $("#ai-use-info").on('change', function(event) {
        var obj = $(this);

        event.preventDefault();

        settingAddress(obj);
    });
    /* address - end */

    /* submit - begin */
    $("#ai-form").on('click', "button[type='submit']", function(event) {
        $("#ai-f-category-required").hide();

        if ($("#ai-form")[0].checkValidity() === false) {
            return true;
        }

        event.preventDefault();

        var category = $("#ai-category").val();

        if (category) {
            $("#ai-form").submit();
        } else {
            $("html, body").animate({scrollTop: 0}, "slow");

            $("#ai-f-category-required").show();

            return false;
        }
    });
    /* submit - end */



    /* preview - begin */
    $("#preview-button").on('click', function() {
        var category_1 = $(".announce-insert .ai-form .ai-f-categories > #ai-f-c-parent ul > li.active").attr('data-name');
        var category_2 = $(".announce-insert .ai-form .ai-f-categories > #ai-f-c-sub ul > li.active").html();
        var title = $("#ai-title").val();
        var desc = $("#ai-desc").val();
        var total = $('.dz-image').length;

        var images = false;

        var price = $("#ai-price").val();
        var service = false;

        if ($("#ai-no-price:checked").length > 0) {
            price = "Serviço";
            var service = true;
        }

        if (category_1 && category_2 && title && desc && price) {
            var hash = $("#ai-hash").val();

            $.ajax({
                url: base_url + '/announce/preview_images',
                type: 'POST',
                data: {hash: hash},
            })
                    .done(function(data) {
                        $("#preview-images").html(data);

                        console.clear();

                        setTimeout(function() {
                            /* images slider - begin */
                            var sliderImages = $("#ap-i-slider");

                            sliderImages.owlCarousel({
                                autoPlay: 7000,
                                items: 4,
                                itemsDesktopSmall: [979, 4],
                                itemsTablet: [768, 3],
                                itemsMobile: [479, 2],
                                afterInit: function() {
                                    sliderControls();
                                },
                                afterUpdate: function() {
                                    sliderControls();
                                }
                            });

                            $(".ap-images").on('click', '#ap-ic-prev', function(event) {
                                sliderImages.data('owlCarousel').prev();
                            });

                            $(".ap-images").on('click', '#ap-ic-next', function(event) {
                                sliderImages.data('owlCarousel').next();
                            });
                            /* images slider - end */

                            /* gallery - begin */
                            $("#ap-i-slider").on('click', '.item', function(event) {
                                var image = $(this).attr('data-image');

                                $(".ap-images .ap-i-master img").removeClass('active');
                                $(".ap-images .ap-i-master img[data-image='" + image + "']").addClass('active');
                            });
                            /* gallery - end */

                            setTimeout(function() {
                                sliderControls();
                            }, 1500);
                        }, 1000);
                    })
                    .fail(function() {
                        console.log("preview images: error");
                    })

            $("#preview-title").html(title);
            $("#preview-desc").html(desc);

            $("#preview-cat-1").html(category_1);
            $("#preview-cat-2").html(category_2);

            $("#preview-price").html(price);

            if ($("#ai-yes-trade:checked").length > 0) {
                $("#preview-trade").show();
            }
            if (service) {
                $("#preview-trade").hide();
            }

            $("#announce-insert").hide();
            $("#announce-preview").show();
        } else if (total == 1) {
            $("#preview-alert-img").show();
            setTimeout(function() {
                $("#preview-alert-img").hide();
            }, 5000);
        } else {
            $("#preview-alert").show();

            setTimeout(function() {
                $("#preview-alert").hide();
            }, 5000);
        }
    });

    $("#back-preview-button").on('click', function() {
        $("#announce-insert").show();
        $("#announce-preview").hide();
    });

    $("#publish-preview-button").on('click', function(event) {
        $("#publish-button").click();
    });
    /* preview - end */


    /* image upload */
    var hash = $("#ai-hash").val();
    var previewTemplate = document.getElementById("image-preview-template").innerHTML;

    var myDropzone = new Dropzone("div#images-upload", {
        url: base_url + "/announce/images_upload/" + hash,
        method: 'POST',
        maxFiles: 10,
        maxFilesize: 10,
        acceptedFiles: "image/jpeg,image/png,image",
        clickable: "#images-upload-button",
        previewTemplate: previewTemplate
    });

    myDropzone.on('addedfile', function(event) {
        $(".dz-message").remove();
    });

    myDropzone.on("success", function(file) {
        var box = file.previewElement;
        var response = file.xhr.response;
        $('#msgImg').hide();
        if (response == 'error') {
            myDropzone.removeFile(file);
            $('#msgImg').show();
            setTimeout(function() {
               $('#msgImg').hide();
            }, 5000);
        } else {
            $('#publish-button').prop('disabled', false);
            box.id = "i" + response;
            setTimeout(function() {
                $("#i" + response).children('.dz-remove-file').show();
            }, 500);
        }
        
        //console.log(response);


    });

    myDropzone.on("complete", function(file) {
        var status = file.status;

        if (status == "error") {
            var timer = (Math.floor((Math.random() * 10) + 1)) * 500;

            setTimeout(function() {
                myDropzone.removeFile(file);
            }, timer);
        }
    });

    myDropzone.on('removedfile', function(file) {
       
        if (file.status == "success") {
            var response = file.xhr.response;
            
            $.ajax({
                url: base_url + '/announce/images_remove',
                type: 'POST',
                data: {image: response},
            }).done(function() {
                        if($('.dz-image').length == 1){
                            $('#publish-button').prop('disabled', true); 
                        }
                        console.clear();
                    }).fail(function() {
                        console.log("image delete: error");
                    });
             
        }
    });


});