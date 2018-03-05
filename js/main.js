var temp;
  $(document).ready(function(){
    // infinite scroll
    
    if ($('.model_slider_default').length != 0){
      $('.model_slider_default').photobox('a',{ time:0 }); 
    }
    if ($('.main_slider').length == 1){
        var pause = $('.main_slider').data('pause');
        var speed = $('.main_slider').data('speed');
        $('.main_slider .block_content').slick({
            arrows: false,
            dots: true,
            fade: true,
             autoplay: true,
            // autoplaySpeed: speed,
            // speed: pause,
        });
    }
    if ($('.top_text').text().length < 2 ){
      $('.top_text').remove();
    }
    if ($('.first_paragraph').text().length < 2 ){
      $('.first_paragraph').remove();
    }
    console.log($('.top_text').length);
    console.log($('.first_paragraph').length);
    $('#userinfo-categoryslug').livequery('change', function(){
        var category = $(this).val();
        var old = '';
        var url = '/';
        
        if((old = location.href.match(/(\/\w+)?(\/register)(.*)/)) !== null){
            if(category == 'directors'){
                url = (old[1] == undefined) ? ('/' + category) : (old[1] + '/' + category);
            }else{
               if(old[3] == ''){
                   if(old[3] == 'directors'){
                        url = (old[1] == undefined) ? ('/' + category) : (old[1] +'/register' + category);
                   }else{
                       url = old[0] + category;
                   }
                }else{
                    url = old[0].replace(old[3], category);
                } 
            }
        }else if((old = location.href.match(/(\/\w+)?(\/directors)(.*)/)) !== null){
            url = (old[1] == undefined) ? ('/register' + category) : (old[1] +'/register' + category);
        };
        location.href = url;
    });
    
    if ($('.services_block .block_content').length == 1){
        $('.services_block .block_content').slick({
            arrows: false,
            dots: true,
            adaptiveHeight: true,
        });
    }   
    if ($('.model_slider').length != 0){
        $('.model_slider .block_content').slick({
            arrows: true,
            slidesToShow: 5,
              slidesToScroll: 1,
              responsive: [
                {
                  breakpoint: 2000,
                  settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1,
                  }
                },
                {
                  breakpoint: 1500,
                  settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                  }
                },
                {
                  breakpoint: 991,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                  }
                },
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    adaptiveHeight: true
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    adaptiveHeight: true
                  }
                }
            ]
        });
    }   

    if ($('.checkbox').length != 0){
      $('.checkbox').livequery(function(){
        var checkbox = $(this).find('input');
        checkbox.click(function(){
          if ($(this).prop('checked') == true){
            $(this).parents('.checkbox').find('label').addClass('active');
          } else{
            $(this).parents('.checkbox').find('label').removeClass('active');
          }
        });
      });
    }

    if ($('.model_slider2').length != 0){
      $(window).on('load', function () {
        setTimeout(function(){
            $('.model_slider2 .ajax-progress').remove();
        }, 500);
      });
        $('.model_slider2 .row').slick({
            arrows: true,
            slidesToShow: 3,
              slidesToScroll: 1,
              responsive: [
                {
                  breakpoint: 991,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                  }
                },
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    adaptiveHeight: true
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    adaptiveHeight: true
                  }
                }
            ]
        });
    }   
    if ($('.view_training').length != 0){
        $('.view_training .view_header').slick({
            arrows: true,
            slidesToShow: 4,
              slidesToScroll: 1,
              variableWidth: true,
              responsive: [
                {
                  breakpoint: 991,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                  }
                },
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }
            ]
        });
    }   
    if ($('.view_office').length != 0){
        $('.view_office .view_content').slick({
          slidesToShow: 3,
          centerMode: true,
          infinite: true,
        });
    }
    $('input[type="tel"]').livequery('keypress', function(key){
      if((key.charCode < 48 || key.charCode > 57) && key.charCode != 45 && key.charCode != 40 && key.charCode != 41){
        return false;
      } 
    })
    $('.model_slider_default .slide_prev').on('mousedown', function(){
        $(this).parents('.model_slider_default').find('.slick-prev').click();
    });
    $('.model_slider_default .slide_next').on('mousedown', function(){
        $(this).parents('.model_slider_default').find('.slick-next').click();
    });
    $('.page_office .page_arrows_wrap .prev_arr').on('mousedown', function(){
        $(this).parents('.page_office').find('.slick-prev').click();
    });
    $('.page_office .page_arrows_wrap .next_arr').on('mousedown', function(){
        $(this).parents('.page_office').find('.slick-next').click();
    });
    $('.header .header_content .menu_btn').click(function(){
        $(this).next().toggleClass('active');
        $(this).toggleClass('active');
        $('.popup').addClass('active');
    });
    $('.header .header_content .search_block .search_btn').click(function(){
        $('body').addClass('active');
    });
    $('.popup').click(function(){
        $('body, .header .header_content .menu_btn, .header .header_content .menu_show, .popup').removeClass('active');
    });
    $('.filter_wrapper .parameters_wrap .parameters_btn').click(function(){
        $(this).next().toggleClass('active');
        $('.wrapper').toggleClass('index');
    });
    $('.filter_wrapper .form_actions .close_form').click(function(e){
        $('.all_parameters').removeClass('active');
        $('.wrapper').removeClass('index');
        e.preventDefault();
    });
    if ($(window).width() > 1200){
        $(window).mousemove(function(e) {
           var change; 
           var xpos=e.clientX;
           var ypos=e.clientY;
           var left= change*20;
           $('.main_slider img').css('top',((0+(ypos/60) * -1)+"px"));
           $('.main_slider img').css('right',(( 0+(xpos/90 * -1))+"px"));             
         }); 
    }
    $('#map').each(function() {
        var coordinate = $(this).data('coordinate');
        var map_wrap_id = $(this).attr('id');
        var mapCenter = coordinate.split(',');
        var markerPosition = new google.maps.LatLng(parseFloat(mapCenter[0]), parseFloat(mapCenter[1]));
        var my_style = new Array()
        var mapCenter_ = coordinate.split(',');
        var myOptions = {
            zoom: 12,
            center: new google.maps.LatLng(parseFloat(mapCenter_[0]), parseFloat(mapCenter_[1])),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: my_style,
            scrollwheel: !1
        };
        var map = new google.maps.Map(document.getElementById(map_wrap_id), myOptions);
        var marker = new google.maps.Marker({
            position: markerPosition,
            map: map,
            optimized: !1,
            title: 'Diva Modelling and Events FZ LLC. Office 1912, <br /> Grosvenor House Business Tower, Tecom'
        });
        var infoWnd = new google.maps.InfoWindow({
            content: 'Diva Modelling and Events FZ LLC. Office 1912, <br /> Grosvenor House Business Tower, Tecom',
            position: markerPosition,
        });
        infoWnd.open(map, marker)
    });
    
    // photo model click
    $('.node_model .thumb_photos .photo a').livequery('click', function(e){
      var mainSrc = $('.main_photos img').attr('src');
      var mainDataSrc = $('.main_photos img').data('src');
      var thumbSrc = $(this).find('img').attr('src');
      var thumbDataSrc = $(this).find('img').data('src');
      $('.main_photos img').attr('src', thumbDataSrc)
      $('.main_photos img').data('src', thumbSrc)
      $(this).find('img').attr('src', mainDataSrc);
      $(this).find('img').data('src', mainSrc);
      // console.log(thumbDataSrc);
      // console.log(thumbSrc);
      // console.log(mainDataSrc);
      // console.log(mainSrc);
      $('.node_model .action_wrap .item_download').attr('data-params', '{"main":"'+thumbDataSrc+'"}');
      e.preventDefault();
    });
    console.log($(".field_birth input").length);
    if($(".field_birth input").length == 1){
        $(function(){
            $(".field_birth input").datepicker();
        });
    }

    // slyle input file and add image from url
    $('.add_image').on('click', function(){
        var fileInput = $('.photo_upload.base_field .fl_upld').html();
        var num = $('#group_parent > .row .col').children().length;
        $('<div class="form-group photo_upload"><label class="main_label col-sm-4">Image '+num+' </label><div class="fl_upld field"><div class="field_text"></div><label for="file_'+num+'">Select</label><input class="form-control" type="file" id="file_'+num+'"  name="file_'+num+'" onchange="previewFile(this)"></div></div>').insertBefore($(this));
    });

    // casting form
    $('.view_casting .btn, .view_training .btn').livequery('click',function(){
      var dataId = $(this).data('id');
      $('.hide_input').val(dataId);
    });
    
    // add class to body
    var pageChecker = function(element, className){
        var element;
        var className;
        if ($(element).length == 1){
            $('body').addClass(className);
        }
    }
    pageChecker('#form_login','page_login');
    pageChecker('.node_model','page_model');
    pageChecker('.view_services','page_services');
    pageChecker('.book_form','page_book_form');
    pageChecker('.view_about','page_about');
    pageChecker('.view_training','page_training');
    pageChecker('.view_public','page_public');
    pageChecker('.view_disclaimer','page_disclaimer');

    
    // size of image
    if($('.view_about').length != 0){
        var sizeArr = [];
        $('.view_directors:not(.view_directors-inner) .col:first-child .video_youtube img').livequery(function(e){
            var imgH = $(this).height();
            var imgW = $(this).width();
            sizeArr.push(imgH);
            sizeArr.push(imgW);
        });
    }
    if($('.model_slider_default').length != 0){
        var sizeArr = [];
        $('.model_slider_default .col:first-child .video_youtube img').livequery(function(e){
            var imgH = $(this).height();
            var imgW = $(this).width();
            // sizeArr.push(imgH);
            // sizeArr.push(imgW);
            // console.log(sizeArr);
        });
    }

    // video play
    if($('.video_youtube:not(.video_youtube-inner)').length != 0){
        $('.video_youtube:not(.video_youtube-inner)').livequery('click', function(e){
            var vid = $(this).attr('data-video');
            $(this).removeClass('pause');
            $(this).find('iframe').remove();
            $(this).text('');
            // $(this).height(sizeArr[0]);
            // $(this).width(sizeArr[1]);
            $(this).append('<iframe src="https://www.youtube.com/embed/'+vid+'?autoplay=1&rel=0" frameborder="0" allowfullscreen></iframe>');
        });
    }
    if($('.video_vimeo').length != 0){
        $('.video_vimeo').livequery('click', function(e){
            vid = $(this).attr('data-video');
            $(this).removeClass('pause');
            $(this).find('iframe').remove();
            $(this).text('');
            $(this).height(sizeArr[0]);
            $(this).width(sizeArr[1]);
            $(this).append('<iframe src="https://player.vimeo.com/video/'+vid+'?autoplay=1" width="'+sizeArr[1]+'" height="'+sizeArr[0]+'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
        });
    }

    if($('.main-video').length != 0){
        $('.main-video').livequery('click', function(e){
            var vid = $(this).attr('data-id');
            $(this).removeClass('pause');
            $(this).find('iframe').remove();
            $(this).find('img').remove();
            $(this).text('');
            // $(this).height(sizeArr[0]);
            // $(this).width(sizeArr[1]);
            $(this).append('<iframe src="https://www.youtube.com/embed/'+vid+'?autoplay=1&rel=0" frameborder="0" allowfullscreen></iframe>');
        });
    }

    // masonry
    var $container = document.querySelector('.view_infinite');
    if ($container != null){   
      window.onresize = function() {
       msnry.layout();
      };    
      var msnry = new Masonry( $container, {
        itemSelector: '.col',
        percentPosition: true
      });
      imagesLoaded( $container ).on( 'progress', function() {
        msnry.layout();
      }); 
      // var infScroll = new InfiniteScroll( $container, {
      //   path: '.pagination__next',
      //   append: '.col',
      //   history: false,
      //   outlayer: msnry,
      // }, msnry.layout());
      // $('<div class="ajax-progress"><div class="throbber"></div></div>').insertAfter('.footer');
       //  $(window).scroll(function() {   
       //    if($(window).scrollTop() + $(window).height() > $(document).height() - 10) {
       //       $('<div class="ajax-progress"><div class="throbber"></div></div>').insertAfter('.footer');
       //    }
       // });
        var infScroll = new InfiniteScroll( $container, {
          path: '.pagination__next',
          append: '.col',
          history: false,
          outlayer: msnry,
          status: '.page-load-status',
          // append: '<div class="ajax-progress"><div class="throbber"></div></div>',
          onInit: function() {

              // this.on( 'append', function() {
              //     $('.ajax-progress').remove();
              // })
            }
        }, function() {
          
          var msnry = new Masonry( $container, {
            itemSelector: '.col',
            percentPosition: true
          });
          imagesLoaded( $container ).on( 'progress', function() {
            msnry.layout();
          });
        });
    }
    
    // adaptive scripts
    if ($(window).width() < 991){
        // table adaptive
        var tableAdaptive = function(table){
            var table;
            var headArr = [];
            $(table +' '+ 'th').each(function(){
                var headText = $(this).text();
                headArr.push(headText);
                $(this).remove();
            });
            for (var i = 0; i <= headArr.length-1; i++) {
                var count = i + 1;
                $(table +' '+ 'td:nth-child('+count+')').prepend('<div class="th_label">'+headArr[i]+'</div>');
            }
        }
        tableAdaptive('.profile_table table');
    }

    // mousemove signing
    if ($('.view_signing').length != 0){
      var canvas = document.querySelector(".view_signing canvas");
      var wrapper = document.getElementById("signature-pad");
      // var clearButton = wrapper.querySelector("[data-action=clear]");
      // var undoButton = wrapper.querySelector("[data-action=undo]");
      var savePNGButton = document.querySelector("#signature-btn");
      var canvas = wrapper.querySelector("canvas");
      var signaturePad = new SignaturePad(canvas, {
        // It's Necessary to use an opaque color when saving image as JPEG;
        // this option can be omitted if only saving as PNG or SVG
        backgroundColor: 'rgb(255, 255, 255)',
        function(){
          console.log('true');
        }
      });
      $('#signature-pad canvas').livequery('mousedown', function(){
        $('#signature-pad .text').fadeOut();
      });

      // Adjust canvas coordinate space taking into account pixel ratio,
      // to make it look crisp on mobile devices.
      // This also causes canvas to be cleared.
      function resizeCanvas() {
        // When zoomed out to less than 100%, for some very strange reason,
        // some browsers report devicePixelRatio as less than 1
        // and only part of the canvas is cleared then.
        var ratio =  Math.max(window.devicePixelRatio || 1, 1);

        // This part causes the canvas to be cleared
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);

        // This library does not listen for canvas changes, so after the canvas is automatically
        // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
        // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
        // that the state of this library is consistent with visual state of the canvas, you
        // have to clear it manually.
        signaturePad.clear();
      }

      // On mobile devices it might make more sense to listen to orientation change,
      // rather than window resize events.
      window.onresize = resizeCanvas;
      resizeCanvas();

      function download(dataURL, filename) {
        var blob = dataURLToBlob(dataURL);
        var url = window.URL.createObjectURL(blob);

        var a = document.createElement("a");
        a.style = "display: none";
        a.href = url;
        a.download = filename;

        document.body.appendChild(a);
        a.click();

        window.URL.revokeObjectURL(url);
      }

      // One could simply use Canvas#toBlob method instead, but it's just to show
      // that it can be done using result of SignaturePad#toDataURL.
      function dataURLToBlob(dataURL) {
        // Code taken from https://github.com/ebidel/filer.js
        var parts = dataURL.split(';base64,');
        var contentType = parts[0].split(":")[1];
        var raw = window.atob(parts[1]);
        var rawLength = raw.length;
        var uInt8Array = new Uint8Array(rawLength);

        for (var i = 0; i < rawLength; ++i) {
          uInt8Array[i] = raw.charCodeAt(i);
        }

        return new Blob([uInt8Array], { type: contentType });
      }

      // clearButton.addEventListener("click", function (event) {
      //   signaturePad.clear();
      // });

      // undoButton.addEventListener("click", function (event) {
      //   var data = signaturePad.toData();

      //   if (data) {
      //     data.pop(); // remove the last dot or line
      //     signaturePad.fromData(data);
      //   }
      // });
      $('form').on('beforeSubmit', function(e) {
        savePNGButton.addEventListener("click", function (event) {
          if (signaturePad.isEmpty()) {
            alert("Please provide a signature first.");
          } else {
            var dataURL = signaturePad.toDataURL();
            var blob = dataURItoBlob(dataURL);
            var imgdata = dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
            var form = $('#signature-btn').parents('form');
            var formSerialize = form.serialize();
            var formData = new FormData();
            formData.append('canvasImage', blob);
            formData.append('form', formSerialize);
            var url = $('#signature-btn').data('url');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                success: function (res) {
                    console.log(res);
                    if (res.status === true){
                      $.jGrowl(
                        res.message,
                        {
                          theme:"bg-green"
                        }
                      );  
                      setTimeout(function(){
                        location.href = '/';
                      }, 3000);
                    }
                    return res;
                },
                cache: false,
                contentType: false,
                processData: false
            });
            e.preventDefault();
          }
        });    
      }).on('submit', function(e){
          e.preventDefault();
      });
    }  

    // // camera photo
    // References to all the element we will need.
    // var video = document.querySelector('#camera-stream'),
    //     image = document.querySelector('#snap'),
    //     start_camera = document.querySelector('#start-camera'),
    //     controls = document.querySelector('.controls'),
    //     take_photo_btn = document.querySelector('#take-photo'),
    //     delete_photo_btn = document.querySelector('#delete-photo'),
    //     download_photo_btn = document.querySelector('#download-photo'),
    //     error_message = document.querySelector('#error-message');


    // // The getUserMedia interface is used for handling camera input.
    // // Some browsers need a prefix so here we're covering all the options
    // navigator.getMedia = ( navigator.getUserMedia ||
    //                       navigator.webkitGetUserMedia ||
    //                       navigator.mozGetUserMedia ||
    //                       navigator.msGetUserMedia);


    // if(!navigator.getMedia){
    //   displayErrorMessage("Your browser doesn't have support for the navigator.getUserMedia interface.");
    // }
    // else{

    //   // Request the camera.
    //   navigator.getMedia(
    //     {
    //       video: true
    //     },
    //     // Success Callback
    //     function(stream){

    //       // Create an object URL for the video stream and
    //       // set it as src of our HTLM video element.
    //       video.src = window.URL.createObjectURL(stream);

    //       // Play the video element to start the stream.
    //       video.play();
    //       video.onplay = function() {
    //         showVideo();
    //       };

    //     },
    //     // Error Callback
    //     function(err){
    //       displayErrorMessage("There was an error with accessing the camera stream: " + err.name, err);
    //     }
    //   );

    // }


    
    // // Mobile browsers cannot play video without user input,
    // // so here we're using a button to start it manually.
    // start_camera.addEventListener("click", function(e){

    //   e.preventDefault();

    //   // Start video playback manually.
    //   video.play();
    //   showVideo();

    // });


    // take_photo_btn.addEventListener("click", function(e){

    //   e.preventDefault();

    //   var snap = takeSnapshot();

    //   // Show image. 
    //   image.setAttribute('src', snap);
    //   image.classList.add("visible");

    //   // Enable delete and save buttons
    //   delete_photo_btn.classList.remove("disabled");
    //   download_photo_btn.classList.remove("disabled");

    //   // Set the href attribute of the download button to the snap url.
    //   download_photo_btn.href = snap;

    //   // Pause video playback of stream.
    //   video.pause();

    // });


    // delete_photo_btn.addEventListener("click", function(e){

    //   e.preventDefault();

    //   // Hide image.
    //   image.setAttribute('src', "");
    //   image.classList.remove("visible");

    //   // Disable delete and save buttons
    //   delete_photo_btn.classList.add("disabled");
    //   download_photo_btn.classList.add("disabled");

    //   // Resume playback of stream.
    //   video.play();

    // });



    // function showVideo(){
    //   // Display the video stream and the controls.

    //   hideUI();
    //   video.classList.add("visible");
    //   controls.classList.add("visible");
    // }


    // function takeSnapshot(){
    //   // Here we're using a trick that involves a hidden canvas element.  

    //   var hidden_canvas = document.querySelector('canvas'),
    //       context = hidden_canvas.getContext('2d');

    //   var width = video.videoWidth,
    //       height = video.videoHeight;

    //   if (width && height) {

    //     // Setup a canvas with the same dimensions as the video.
    //     hidden_canvas.width = width;
    //     hidden_canvas.height = height;

    //     // Make a copy of the current frame in the video on the canvas.
    //     context.drawImage(video, 0, 0, width, height);

    //     // Turn the canvas image into a dataURL that can be used as a src for our photo.
    //     return hidden_canvas.toDataURL('image/png');
    //   }
    // }


    // function displayErrorMessage(error_msg, error){
    //   error = error || "";
    //   if(error){
    //     console.log(error);
    //   }

    //   error_message.innerText = error_msg;

    //   hideUI();
    //   error_message.classList.add("visible");
    // }


    // function hideUI(){
    //   // Helper function for clearing the app UI.

    //   controls.classList.remove("visible");
    //   start_camera.classList.remove("visible");
    //   video.classList.remove("visible");
    //   snap.classList.remove("visible");
    //   error_message.classList.remove("visible");
    // }

    // upload file
    var fileupload = $('.view_signing #image');
    fileupload.livequery('change', function(){
      var filename = $(this).val().replace(/.*\\/, "");
      var fileUrl = '/images/' + filename;
      $('.form_wrap .image_wrap').prepend('<img src="'+fileUrl+'" alt="" class="image_preview">');
    });
    $('.close_icon').livequery('click', function(){
        $('.crop_popup').fadeOut();
        setTimeout(function(){
            $('.crop_popup .image_crop img').remove();
            $('.crop_popup .cropper-container').remove();
        }, 500);
        setTimeout(function(){
            $('input[data-name="'+arrId[0]+'"]').prop('value', null);
        },100);
    });
    if ($('.page_register').length != 0){
      jQuery.validator.addMethod("domain", function(value, element) {
        return this.optional(element) || /^https:\/\/www.youtube.com/.test(value) || /^https:\/\/vimeo.com/.test(value) || /^https:\/\/youtube.com/.test(value);
      }, "You can add only youtube/ vimeo video");
      // jQuery.validator.setDefaults({
      //     success:  "valid"
      // });
      var form = $(".page_register form");
      $(form).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
      form.validate({
          rules: {
            'UserMedia[src][catwalk][1]': {
                url: true,
                domain: true
              },
              'UserMedia[src][catwalk][1]': {
                url: true,
                domain: true
              },
              'UserMedia[src][catwalk][2]': {
                url: true,
                domain: true
              },
              'UserMedia[src][catwalk][3]': {
                url: true,
                domain: true
              },
              'UserMedia[src][catwalk][4]': {
                url: true,
                domain: true
              },
              'UserMedia[src][catwalk][5]': {
                url: true,
                domain: true
              },
              'UserMedia[src][showreel][1]': {
                url: true,
                domain: true
              },
              'UserMedia[src][showreel][2]': {
                url: true,
                domain: true
              },
              'UserMedia[src][showreel][3]': {
                url: true,
                domain: true
              },
              'UserMedia[src][showreel][4]': {
                url: true,
                domain: true
              },
              'UserMedia[src][showreel][5]': {
                url: true,
                domain: true
              },
            },
            // success: function() {
            //   $('.photo_upload.base_field input[type="file"]').livequery(function(){
            //     $(this).remove();
            //     console.log('true');
            //   });
            // }
      });
    }

    $('.photo_upload:not(.base_field) input').livequery('change', function(){
        var filename = $(this).val().replace(/.*\\/, "");
        $(this).parents('.fl_upld').find('.field_text').html(filename);
    });
    $('.polaroid_upload input').livequery('change', function(){
      $('<div class="ajax-progress"><div class="throbber"></div></div>').insertAfter('.footer');
      var inputName = $(this).attr('name');
      console.log($(this)[0].files[0])
      var formData = new FormData();
      formData.append('image', $(this)[0].files[0]); 
      setTimeout(function(){
        $.ajax({
            url: '/ajax/upload-polaroid',
            type: 'POST',
            data: formData,
            async: false,
            success: function (res) {
                if (res.status === true){
                   var fileName = res.name;
                   $('input[name="'+inputName+'"]').parents('.polaroid_upload').find('.image-name').val(fileName);
                   $('input.form-control[name="'+inputName+'"]').remove();
                   $('<input class="form-control" type="file" name='+inputName+'" accept="image/*">').insertBefore($('input.image-name[name="'+inputName+'"]'));
                 }
                 $('.ajax-progress').remove();
                return res;
            },
            cache: false,
            processData: false,
            contentType: false
        });
      }, 100);
    });
    $('.add-favorite-casting').livequery('click',function(){
      var url = $(this).data('url');
      $.ajax({
          url: url,
          type: 'POST',
          async: false,
          success: function (res) {
              // console.log(res);
              if (res.status === true){
                $.jGrowl(res.message,
                  {
                    theme:"bg-green"
                  }
                );  
              } else {
                $.jGrowl(
                  res.message,
                  {
                    theme:"bg-orange"
                  }
                );  
              }
              return res;
          },
          cache: false,
          processData: false,
          contentType: false
      });
    });
    var linkId = [];
    $('.view_app .delete_btn').livequery('click',function(e){
      var url = $(this).attr('href');
      linkId.push($(this).data('id'));
      $.ajax({
          url: url,
          type: 'POST',
          async: false,
          success: function (res) {
              console.log(res);
              if (res.status == 1){
                // console.log(linkId[0]);
                $('.view_row[data-id="'+linkId[0]+'"').fadeOut();
                $.jGrowl(res.message,
                  {
                    theme:"bg-green"
                  }
                );  
              }
              return res;
          },
          cache: false,
          processData: false,
          contentType: false
      });
      e.preventDefault();
    });
    function dataURItoBlob(dataURI) {
        // convert base64/URLEncoded data component to raw binary data held in a string
        var byteString;
        if (dataURI.split(',')[0].indexOf('base64') >= 0)
            byteString = atob(dataURI.split(',')[1]);
        else
            byteString = unescape(dataURI.split(',')[1]);

        // separate out the mime component
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

        // write the bytes of the string to a typed array
        var ia = new Uint8Array(byteString.length);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        return new Blob([ia], {type:mimeString});
    }
    $('#crop').livequery('click',function(e){
          $('<div class="ajax-progress"><div class="throbber"></div></div>').insertAfter('.footer');
          setTimeout(function(){
            var canvas = canvasArr[0].getCroppedCanvas();
            $('.crop_popup').fadeOut();
            setTimeout(function(){
                $('.crop_popup .image_crop img').remove();
                $('.crop_popup .cropper-container').remove();
            }, 500);
            var imagedata = canvas.toDataURL('image/png');
            var blob = dataURItoBlob(imagedata);
            var imgdata = imagedata.replace(/^data:image\/(png|jpg);base64,/, "");
            var inputVal = $('input[data-name="'+arrId[0]+'"]').attr('src');
            var formData = new FormData();
            formData.append('canvasImage', blob);
            $.ajax({
                url: '/ajax/upload-image',
                type: 'POST',
                data: formData,
                async: false,
                success: function (res) {
                    formData.delete(inputVal);
                    if (res.status === true){
                      var fileName = res.name;
                      // console.log(res);  
                      $('.image_in[data-name="'+arrId[0]+'"] img').remove();
                      // $('.image_in[data-name="'+arrId[0]+'"] canvas').remove();
                      $('.image_in[data-name="'+arrId[0]+'"]').append('<img src="/images/user-media/'+fileName+'" alt="" />');
                      $('input[data-name="'+arrId[0]+'"]').parents('.fl_upld').find('.image-name').val(fileName);
                      var filename = $('input[data-name="'+arrId[0]+'"]').val().replace(/.*\\/, "");
                      $('input[data-name="'+arrId[0]+'"]').parents('.fl_upld').find('.field_text').html(filename);
                      setTimeout(function(){
                          $('input[data-name="'+arrId[0]+'"]').prop('value', null);
                      },500);
                    } else {
                      $.jGrowl(
                        res.message,
                        {
                          theme:"bg-orange"
                        }
                      );  
                    }
                    $('.ajax-progress').remove();
                    return res;
                },
                cache: false,
                contentType: false,
                processData: false
            });
          }, 100);
          e.preventDefault();
      });

    $('.view_directors').livequery(function(){
      setTimeout(function(){
        $('.ajax-progress').remove();
      }, 500);
    });

    $('.view_directors-inner .col .popup_click').livequery('click', function(){
      // alert();
      var videoId = $(this).parents('.col').find('.video_youtube-inner').data('video');
      $('.director_iframe_content iframe').remove();
      $('.director_iframe_content').append('<iframe src="https://www.youtube.com/embed/'+videoId+'?autoplay=1&rel=0" frameborder="0" allowfullscreen></iframe>');
      $('.director_popup').addClass('active');
    });
    $('.director_popup .close').livequery('click', function(){
      $('.director_popup').removeClass('active');
      $('.director_iframe_content iframe').remove();
    });

      // send to email
//      $('.node_model .action_wrap .item_email').livequery('click', function(e){
//        var url = $(this).data('url');
//        var email = $(this).data('email');
//        $('<div class="ajax-progress"><div class="throbber"></div></div>').insertAfter('.footer');
//        $.ajax({
//            url: url,
//            type: 'POST',
//            data: {email:email},
//            async: false,
//            success: function (res) {
//                console.log(res);
//                $('.ajax-progress').remove();
//                if (res.status === true){
//                  $.jGrowl(res.message,
//                    {
//                      theme:"bg-green"
//                    }
//                  );  
//                }
//                return res;
//            },
//            cache: false,
//        });
//        e.preventDefault();
//      });
      
        
      $('.profile_table .delete_profile').livequery('click', function(e){
        var url = $(this).data('url');
        var id = $(this).data('id');
        // $('<div class="ajax-progress"><div class="throbber"></div></div>').insertAfter('.footer');
        $('.btn_delete').click(function(){
          $.ajax({
              url: url,
              type: 'GET',
              async: false,
              success: function (res) {
                  console.log(res);
                  $('.ajax-progress').remove();
                  if (res.status === true){
                    $.jGrowl(res.message,
                      {
                        theme:"bg-green"
                      }
                    );  
                    $('.profile_table table').find('tr[data-id='+id+']').hide(300);
                    $('#profileModal').modal('hide');
                  }else{
                      $('#profileModal .form_title').text(res.message);
                  }
                  return res;
              },
              cache: false,
          });
        });
        e.preventDefault();
      });
      $('.profile_table .delte-all').livequery('click', function(e){
        var url = $(this).data('url');
        // $('<div class="ajax-progress"><div class="throbber"></div></div>').insertAfter('.footer');
        $('.btn_delete').click(function(){
          $.ajax({
              url: url,
              type: 'GET',
              async: false,
              success: function (res) {
                  console.log(res);
                  $('.ajax-progress').remove();
                  if (res.status === true){
                    $.jGrowl(res.message,
                      {
                        theme:"bg-green"
                      }
                    );  
                    $('.profile_table table tbody').hide(300);
                    $('#profileModal').modal('hide');
                  }else{
                      $('#profileModal .form_title').text(res.message);
                  }
                  return res;
              },
              cache: false,
          });
        });
        e.preventDefault();
      });
      // $('.delte-all').livequery('click', function (e) {
      //       e.preventDefault();
      //       var url = $(this).data('url');
      //       $.ajax({
      //           url: url,
      //           type: 'GET',
      //           async: false,
      //           success: function (res) {
      //               console.log(res);
      //               $('.ajax-progress').remove();
      //               if (res.status === true) {
      //                   $.jGrowl(res.message,{theme: 'bg-green'});
      //                   $('.profile_table table tbody tr').hide(300);
      //                   $('#profileModal').modal('hide');
      //               } else {
      //                   $('#profileModal .form_title').text(res.message);
      //               }
      //               return res;
      //           },
      //           cache: false
      //       });
      //   });
      // $('.profile_table .delte-all').livequery('click', function(e){
      //   var url = $(this).data('url');
      //   // $('<div class="ajax-progress"><div class="throbber"></div></div>').insertAfter('.footer');
      //   $('.btn_delete').click(function(){
      //     $.ajax({
      //         url: url,
      //         type: 'GET',
      //         async: false,
      //         success: function (res) {
      //             console.log(res);
      //             $('.ajax-progress').remove();
      //             if (res.status === 1){
      //               $.jGrowl(res.message,
      //                 {
      //                   theme:"bg-green"
      //                 }
      //               );  
      //               $('.profile_table table').hide(300);
      //               $('#profileModal').modal('hide');
      //             }else{
      //                 $('#profileModal .form_title').text(res.message);
      //             }
      //             return res;
      //         },
      //         cache: false,
      //     });
      //   });
      //   e.preventDefault();
      // });
      
      $('.node_model .action_wrap .item_cart').livequery('click', function(e){
        var url = $(this).data('url');
        // var email = $(this).data('email');
        $('<div class="ajax-progress"><div class="throbber"></div></div>').insertAfter('.footer');
        $.ajax({
            url: url,
            type: 'GET',
            // data: email,
            async: false,
            success: function (res) {
                // console.log(res);
                $('.ajax-progress').remove();
                if (res.status === true){
                  $.jGrowl(res.message,
                    {
                      theme:"bg-green"
                    }
                  );  
                }
                return res;
            },
            cache: false,
            contentType: false,
            processData: false
        });
        e.preventDefault();
      });
      $('.register_wrap .form_actions .btn').click(function(){
        if(form.valid() == true ) {
          $('.photo_upload.base_field input[type="file"]').livequery(function(){
            $(this).remove();
            $('<div class="ajax-progress"><div class="throbber"></div></div>').insertAfter('.footer');
            // console.log('true');
          });
        } else {
          // console.log('false');
        }
      });
      
      
    $('#download-favorite').livequery('click',function(){
      var url = $(this).data('url');
      $.ajax({
          url: url,
          type: 'POST',
          async: false,
          cache: false,
          processData: false,
          contentType: false
      });
    });
    setTimeout(function(){
      var photoWidth = $('.node_model .photo_wrapper').width();
      $('.node_model .photo_wrapper').width(photoWidth);
      $('.node_model .model_info').width(photoWidth);
      if (typeof orientation !== "undefined" && orientation.horizontal == true){
        $('.images_wrap').addClass('horizontal');
      }
    }, 1000);
    // setTimeout(function(){
    //   var photoWidth = $('.view_infinite').width();
    //   $('.view_infinite').width(photoWidth);
    // }, 1000);

});
var urlArr = [];
var arrId = [];
var imageArr = [];
var canvasArr = [];
function previewFile(current) {
  var file    = current.files[0];
  var reader  = new FileReader();
  if (file.length !=0){
    $('<div class="ajax-progress"><div class="throbber"></div></div>').insertAfter('.footer');
  }
  reader.addEventListener("load", function () {
    urlArr = [];
    urlArr.push(reader.result);
    var image = document.createElement('img');
    image.src = reader.result;
    image.addEventListener('load', function() {
      if (image.width >= 480 && image.height >=480){
        var photoOrient;
        var widthPhoto = 4 / 3;
        var heightPhoto = 3 / 4;
        var allPhoto = false;
        if (orientation.horizontal == true && orientation.vertical == true){
          photoOrient = allPhoto;
        } else if (orientation.horizontal == true && orientation.vertical == false){
          photoOrient = widthPhoto;
        } else if (orientation.horizontal == false && orientation.vertical == true){
            photoOrient = heightPhoto;
        }
        // console.log(photoOrient);
        // console.log(image.width);
        // console.log(image.height);
        var nameAttr = $(current).data('name');
        
        // $(current).parents('.form_content').find('div[data-name='+nameAttr+'] img').remove();
        // $(current).parents('.form_content').find('div[data-name='+nameAttr+']').append('<img src="'+urlArr[0]+'" alt="">');
        $(current).parents('.form_content').find('div[data-name='+nameAttr+']').addClass('image_in');
        var imgId = '';
        var imgSrc = '';
        var imgId = $(current).parents('.form_content').find('div[data-name='+nameAttr+']').data('name');
        arrId = [];
        arrId.push(imgId);
        $('.crop_popup .image_crop img').remove();
        $('.crop_popup .image_crop').append('<img src="'+urlArr[0]+'" alt="" id="target">');
        $('.crop_popup').fadeIn();
        $('.ajax-progress').remove();
        setTimeout(function(){
          var image = document.getElementById('target');
          var cropper= '';
          var cropper = new Cropper(image, {
            minCropBoxWidth: 240,
            minCropBoxHeight: 320,
            zoom: 0.2,
            // zoomable: false,
            aspectRatio: photoOrient,
          });
          setTimeout(function(){
            cropper.zoom(0.1);
          }, 100);
          canvasArr = [];
          canvasArr.push(cropper);
        },200);
      } else {
        $.jGrowl('Your image is too small!',
          {
            theme:"bg-orange"
          }
        );  
        $('.ajax-progress').remove();
      }
    });
    
  }, false);
  if (file) {
    reader.readAsDataURL(file);
  }
}