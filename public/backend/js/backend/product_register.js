const btnAddProduct = $('#btnAddProduct, #btnUpdateProduct');
// const btnUpdateProduct = $('#btnUpdateProduct');
const formId = '#createProduct';
const url = $(formId).attr('action');
const summerNoteId = '#descriptionProduct, #contentProduct';
const chosenId = '.jsSelectCategory, .jsSelectProductCategory, .jsSelectProductType';
const arrayName = ['category_id', 'product_category_id', 'product_type_id', 'product_name', 'product_image', 'product_description', 'product_content', 'product_price', 'product_promotional'];

let productRegisterJs = (function ($) {
    let modules = {};

    modules.createProduct = function(data) {
        $.ajax({
            url : 'admin/product/add',
            dataType : 'JSON',
            type : 'POST',
            data: data,
            success : function (data) {
                btnAddProduct.prop('disabled', true);
                // location.reload();
            },
            error : function (data) {
                let error = (typeof data['responseJSON'] !== 'undefined') ? data['responseJSON'].errors : [];
                if (!error.length) {
                    $('input[name=submit]').val(SUBMIT);
                }

                Commons.loadMessageValidation(error, arrayName);
            }
        });
    };

    modules.textareaDisplay = function () {
        $('#descriptionProduct').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                // ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['height', ['height']]
            ],
        });
        $('#contentProduct').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['height', ['height']]
            ],
        });

        $('.jsSelectCategory, .jsSelectProductCategory, .jsSelectProductType').chosen({
            width: "100%"
        });

        $('.jsRadio').iCheck({
            radioClass: 'iradio_square-green',
        });
    };


    return modules;
})(window.jQuery, window, document);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {

    Dropzone.autoDiscover = false;

    $(function () {
        let images = [];

        for (let i = 1; i <= 2; i++) {
            let dzName = 'jsProductImage';
            configUPloadImage(dzName, i);
        }

        function configUPloadImage(target, num) {

            let maxSizeFileImage = 1024 * 25;
            let targetId = '#' + target + num.toString().padStart(2, '0');
            let previewsId = '#' + target + 'Previews' + num.toString().padStart(2, '0');
            let imageType = num.toString().padStart(1, '0');

            $(targetId).dropzone({
                url: '/admin/product/uploadImages',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                params: {
                    type: imageType
                },
                paramName: 'file',
                acceptedFiles: 'image/*',
                maxFilesize: 25, // MB
                maxFiles: 1,
                addRemoveLinks: true,
                previewsContainer: previewsId,
                thumbnailWidth: 120,
                thumbnailHeight: 120,
                // dictCancelUpload: 'Cancel',
                // dictCancelUploadConfirmation: 'Cancel upload. Is it OK?',
                // dictRemoveFileConfirmation: 'Delete the file. Is it OK?',
                init: function() {
                    let dropzone = this;
                    if (dropzone.element.classList.contains('dropzone-disabled')) {
                        dropzone.removeEventListeners();
                    }
                    // $.ajax({
                    //     url: '/admin/product/getImages',
                    //     data: {
                    //         type: imageType,
                    //     },
                    //     success: function (res) {
                    //         if (res.images.length) {
                    //             $('.input').val(1);
                    //         }
                    //         res.images.forEach(function (image) {
                    //             let mockFile = {name: image.name, size: image.size, dataURL: image.url};
                    //             images.push(mockFile);
                    //             dropzone.options.addedfile.call(dropzone, mockFile);
                    //             dropzone.options.thumbnail.call(dropzone, mockFile, image.url);
                    //             mockFile.previewElement.classList.add('dz-success');
                    //             mockFile.previewElement.classList.add('dz-complete');
                    //             mockFile.previewElement.querySelector("[data-dz-size]").innerHTML = image.size;
                    //             $(mockFile.previewElement).find('img').attr('data-image', image.name    );
                    //             $(mockFile.previewElement).append('<input type="hidden" name="product_image" value="' + image.name + '" class="dropzone-input-hidden" id="input">');
                    //
                    //             let file = new File([''], mockFile.name);
                    //             file.accepted = true;
                    //             file.previewElement = mockFile.previewElement;
                    //             file.previewTemplate = mockFile.previewElement;
                    //             dropzone.files.push(file);
                    //             Commons.adjustWrapper();
                    //         });
                    //     }
                    // });

                    if ($('#dataImage01').val()) {
                        let dataImage = JSON.parse($('#dataImage01').val());

                        dataImage.images.forEach(function (image) {
                            let mockFile = {name: image.name, size: image.size, dataURL: image.url};
                            images.push(mockFile);
                            dropzone.options.addedfile.call(dropzone, mockFile);
                            dropzone.options.thumbnail.call(dropzone, mockFile, image.url);
                            mockFile.previewElement.classList.add('dz-success');
                            mockFile.previewElement.classList.add('dz-complete');
                            mockFile.previewElement.querySelector("[data-dz-size]").innerHTML = image.size;
                            $(mockFile.previewElement).find('img').attr('data-image', image.name    );
                            $(mockFile.previewElement).append('<input type="hidden" name="product_image" value="' + image.name + '" class="dropzone-input-hidden" id="input1">');

                            let file = new File([''], mockFile.name);
                            file.accepted = true;
                            file.previewElement = mockFile.previewElement;
                            file.previewTemplate = mockFile.previewElement;
                            dropzone.files.push(file);
                            Commons.adjustWrapper();
                        });
                    }

                    this.on('addedfile', function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                    });

                    this.on("thumbnail", function (file) {
                        $('.error_product_image').addClass('hidden').text('');
                        if (file.status == 'added') {
                            if (file.size < maxSizeFileImage) {
                                file.acceptDimensions();
                            }

                            this.on("error", function (file) {
                                if (!file.accepted) {
                                    this.removeFile(file);
                                }
                            });
                        }else if(file.status == 'error'){
                            $('.error_product_image').removeClass('hidden').text('');
                        }
                    })
                },
                accept: function(file, done) {
                    file.rejectDimensions = function() {
                        done("Please make sure the image width and height are not larger than 2500px.");
                    };
                    file.acceptDimensions = done;
                },

                addedfile: function (file) {
                    // call super (prototype)
                    let _addedfile = Dropzone.prototype.defaultOptions.addedfile;
                    _addedfile.call(this, file);
                    images.push(file);
                },
                uploadprogress: function (file, progress, size) {
                    file.previewElement.querySelector('[data-dz-uploadprogress]').style.width = '' + progress + '%';
                    Commons.adjustWrapper();
                    // images.push(file);
                },
                success: function (file, rt, xml) {
                    $('.error_product_image').addClass('hidden').text('');
                    file.previewElement.querySelector("[data-dz-name]").innerHTML = rt.name;
                    file.previewElement.querySelector("[data-dz-size]").innerHTML = rt.size;
                    let mockFile = {name: rt.name, size: rt.size, dataURL: rt.url};
                    images.push(mockFile);
                    $(file.previewElement).find('img').attr('data-image', rt.name);
                    $(file.previewElement).append('<input type="hidden" name="product_image" value="' + rt.name + '" class="dropzone-input-hidden" id="input">');
                    file.previewElement.classList.add('dz-success');
                    $(file.previewElement).find('.dz-success-mark').show();
                    $.enableButtonSubmitWhenUploadedImage();
                    Commons.adjustWrapper();
                },
                processing: function () {
                    $.disableButtonSubmitWhenUploadingImage();
                },
                queuecomplete: function () {
                    $(targetId).removeClass('dz-drag-hover');
                },
                dragover: function (e) {
                    $(targetId).addClass('dz-drag-hover');
                },
                dragleave: function (e) {
                    $(targetId).removeClass('dz-drag-hover');
                },
                drop: function (e) {
                    $(targetId).removeClass('dz-drag-hover');
                },
                error: function (file, _error_msg) {
                    let ref;
                    (ref = file.previewElement) !== null ? ref.parentNode.removeChild(file.previewElement) : void 0;

                    $('.error_product_image').removeClass('hidden').text('Please select a photo less than 25 MB.');
                },
                removedfile: function (file) {
                    let fileName = $(file.previewElement).find('img').attr("data-image");
                    if (fileName)  {
                        $.ajax({
                            url: "/admin/product/deleteImages",
                            type: "post",
                            data: {
                                fileName: fileName,
                                type: num.toString().padStart(1, '0'),
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {
                                let isMessengerError =  $("#uploadProductImage").find("div.error_product_image").hasClass('hidden');
                                console.log(isMessengerError);
                                if (isMessengerError) {
                                    $('.error_product_image').removeClass('hidden').text('Product image cannot be left blank.');
                                }
                            }
                        });
                    }
                    file.previewElement.remove();
                    Commons.adjustWrapper();
                },
                canceled: function () {
                    $.enableButtonSubmitWhenUploadedImage();
                },
                maxfilesexceeded: function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                }
            });

            $(targetId)
                .on('mouseover', function () {
                    $(this).addClass('dz-drag-hover');
                })
                .on('mouseout', function () {
                    $(this).removeClass('dz-drag-hover');
                })
                .on('touchstart', function () {
                    $(this).addClass('dz-drag-hover');
                })
                .on('touchend', function () {
                    $(this).removeClass('dz-drag-hover');
                });

            // $("#type_modal").change(function (file) {
            //     $.ajax({
            //         url: "/admin/banners/ajaxDeleteImage",
            //         type: "post",
            //         data: {
            //         },
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function (data) {
            //         }
            //     });
            //     Dropzone.forElement("#jsFileImageDropzone01").removeAllFiles(true);
            // });
            //
            // $("#type_top").change(function (file) {
            //     $.ajax({
            //         url: "/admin/banners/ajaxDeleteImage",
            //         type: "post",
            //         data: {
            //         },
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function (data) {
            //         }
            //     });
            //     Dropzone.forElement("#jsFileImageDropzone01").removeAllFiles(true);
            // });
        }

        // display expanded image on click
        // May be it can use only registration

        let image = null;
        function preloadImageModal(src) {   // local method
            let preImage = new Image();
            preImage.src = src;
            preImage.onload = function (ev) {
                image = preImage;
            };
        }

        function showExpandedImageModal(info, isFirstTime) {    // local method
            if (isFirstTime) {
                preloadImageModal(info.dataURL);
            }

            if (image) {
                let target = $('.modal.image');

                $(target).find('.modal-title').text(info.name);
                $(target).find('.image').attr('src', info.dataURL).attr('alt', info.name);
                $(target)
                    .on('hidden.bs.modal', function () {
                        $(target).find('.modal-title').text('');
                        $(target).find('.image').attr('src', 'images/img_dummy.png').attr('alt', '');
                        image = null;
                    })
                    .modal('show');
            } else {
                setTimeout(function () {
                    showExpandedImageModal(info, false);
                }, 50);
            }
        }

        if ($('.modal.image').length) {
            $(document).on('click', '.dz-image, .dz-details, .dz-progress, .dz-error-message, .dz-success-mark, .dz-error-mark', function () {
                let fileName = $(this).find('.dz-filename span').text();
                let target = {};

                for(let i = 0; i < images.length; i++) {
                    if (images[i].name === fileName) {
                        target = images[i];
                        break;
                    }
                }

                showExpandedImageModal(target, true);
            });
        }
    });

    Commons.formValidation(url, formId, summerNoteId);

    productRegisterJs.textareaDisplay();
    // Commons.getImages('.jsUploadFile');
    // Commons.getImages('.jsUploadFileMultiple');

    btnAddProduct.on('click', function () {
        $(this).button('Loading');

        $('input[name=submit]').val(SUBMIT);
    });
});

