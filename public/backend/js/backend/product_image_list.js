$(document).ready(function () {

    Dropzone.autoDiscover = false;

    $(function () {
        let images = [];

        for (let i = 1; i <= 2; i++) {
            let dzName = 'jsImageList';
            configUPloadImage(dzName, i);
        }

        function configUPloadImage(target, num) {

            let maxSizeFileImage = 1024 * 1024 * 25;
            let targetId = '#' + target + num.toString().padStart(2, '0');
            let previewsId = '#' + target + 'Previews' + num.toString().padStart(2, '0');
            let imageType = num.toString().padStart(1, '0');
            $(targetId).dropzone({
                url: '/admin/product/product_image/uploadImageList',
                paramName: 'file',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                params: {
                    type: imageType
                },
                acceptedFiles: 'image/*',
                autoProcessQueue: true,
                maxFilesize: 25, // MB
                parallelUploads: 1,
                addRemoveLinks: true,
                previewsContainer: previewsId,
                thumbnailWidth: 120,
                thumbnailHeight: 120,
                dictCancelUpload: 'Cancel',
                dictCancelUploadConfirmation: 'Cancel upload. Is it OK ?',
                // dictRemoveFileConfirmation: 'ファイルを削除します。よろしいですか？',

                init: function() {
                    let dropzone = this;
                    if (dropzone.element.classList.contains('dropzone-disabled')) {
                        dropzone.removeEventListeners();
                    }
                    // $.ajax({
                    //     url: '/admin/product/product_image/getImageList',
                    //     data: {
                    //         type: imageType,
                    //     },
                    //     success: function (res) {
                    //
                    //         res.images.forEach(function (image) {
                    //             let mockFile = {name: image.name, size: image.size, dataURL: image.url};
                    //             images.push(mockFile);
                    //             dropzone.options.addedfile.call(dropzone, mockFile);
                    //             dropzone.options.thumbnail.call(dropzone, mockFile, image.url);
                    //             mockFile.previewElement.classList.add('dz-success');
                    //             mockFile.previewElement.classList.add('dz-complete');
                    //             mockFile.previewElement.querySelector("[data-dz-size]").innerHTML = image.size;
                    //             $(mockFile.previewElement).find('img').attr('data-image', image.name    );
                    //             $(mockFile.previewElement).append('<input type="hidden" name="image_list' + '[]" value="' + image.name + '" class="dropzone-input-hidden">');
                    //             Commons.adjustWrapper();
                    //         });
                    //     }
                    // });

                    if ($('#dataImage02').val()) {
                        let dataImage = JSON.parse($('#dataImage02').val());

                        dataImage.images.forEach(function (image) {
                            let mockFile = {name: image.name, size: image.size, dataURL: image.url};
                            images.push(mockFile);
                            dropzone.options.addedfile.call(dropzone, mockFile);
                            dropzone.options.thumbnail.call(dropzone, mockFile, image.url);
                            mockFile.previewElement.classList.add('dz-success');
                            mockFile.previewElement.classList.add('dz-complete');
                            mockFile.previewElement.querySelector("[data-dz-size]").innerHTML = image.size;
                            $(mockFile.previewElement).find('img').attr('data-image', image.name    );
                            $(mockFile.previewElement).append('<input type="hidden" name="image_list' + '[]" value="' + image.name + '" class="dropzone-input-hidden" id="input2">');

                            let file = new File([''], mockFile.name);
                            file.accepted = true;
                            file.previewElement = mockFile.previewElement;
                            file.previewTemplate = mockFile.previewElement;
                            dropzone.files.push(file);
                            Commons.adjustWrapper();
                        });
                    }

                    this.on("thumbnail", function (file) {
                        $('.error_product_image_list').addClass('hidden').text('');

                        if (file.status == 'added') {
                            if (file.size < maxSizeFileImage) {
                                file.acceptDimensions();
                            }
                            if (file.size > maxSizeFileImage) {
                                file.rejectDimensions();
                            }
                        }else if(file.status == 'error'){
                            $('.error_product_image_list').removeClass('hidden').text('');
                        }

                        this.on("error", function (file) {
                            if (!file.accepted)  {
                                this.removeFile(file);
                            }
                        });
                    })
                },
                accept: function(file, done) {
                    file.rejectDimensions = function() {
                        done("Please make sure the image are not larger than 2500px.");
                    };
                    file.acceptDimensions = done;
                },
                uploadprogress: function (file, progress, size) {
                    file.previewElement.querySelector('[data-dz-uploadprogress]').style.width = '' + progress + '%';
                    Commons.adjustWrapper();
                },
                success: function (file, rt, xml) {
                    $('.error_product_image_list').addClass('hidden').text('');
                    file.previewElement.querySelector("[data-dz-name]").innerHTML = rt.name;
                    file.previewElement.querySelector("[data-dz-size]").innerHTML = rt.size;
                    let mockFile = {name: rt.name, size: rt.size, dataURL: rt.url};
                    images.push(mockFile);
                    $(file.previewElement).find('img').attr('data-image', rt.name);
                    $(file.previewElement).append('<input type="hidden" name="image_list' + '[]" value="' + rt.name + '" class="dropzone-input-hidden">');
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

                    $('.error_product_image_list').removeClass('hidden').text('Please select a photo less than 25 MB.');
                },
                removedfile: function(file, e) {
                    let fileName = $(file.previewElement).find('img').attr("data-image");
                    $.ajax({
                        url: '/admin/product/product_image/deleteImageList',
                        type: "post",
                        data: {
                            fileName: fileName,
                            type: imageType,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {}
                    });

                    $(document).find(file.previewElement).remove();
                    Commons.adjustWrapper();
                },
                canceled: function () {
                    // 必要なら処理を記述
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
});
