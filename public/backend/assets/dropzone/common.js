'use strict';

/*
---------------------------------------
Common Functions
---------------------------------------
*/

// Disable auto detect
Dropzone.autoDiscover = false;

$(document).ready(function () {
    // 画像管理
    var images = [];
    var imgSize = {
        el: null,
        margin: 80,
        padding: 10,
        originalWidth: 0,
        originalHeight: 0,
        width: 0,
        height: 0,
        returnWidth: 0,
        returnHeight: 0
    };

    // load
    function preloadImage(src) {
        var image = new Image();
        image.src = src;
        images.push(image);

        image.onload = function (ev) {
            imgSize.el = this;
        };
    }

    function setElement(info) {
        preloadImage(info.src);
    }

    // adjust image size to window
    function setImageSize() {
        imgSize.originalWidth = imgSize.el.width;
        imgSize.originalHeight = imgSize.el.height;

        imgSize.width = imgSize.el.width;
        imgSize.height = imgSize.el.height;

        if (imgSize.width === 0 && imgSize.height === 0) {
            // get alternative size
            // ex) in the case of firefox + svg
            var html = [];
            html.push('<div class="check-size" style="position:absolute;height:auto;left:-1000px">');
            html.push('<img src="' + imgSize.el.src + '" width="200">');
            html.push('</div>');

            $('body').append(html.join(''));
            var checker = $('.check-size');

            imgSize.width = $(checker).width();
            imgSize.height = $(checker).height();
            $(checker).remove();
        }

        if (imgSize.width > getWinWidth() - imgSize.padding) {
            imgSize.width = getWinWidth() - imgSize.padding;
            imgSize.height = imgSize.width * imgSize.originalHeight / imgSize.originalWidth;
        }

        if (imgSize.height > getWinHeight() - imgSize.padding) {
            imgSize.height = getWinHeight() - imgSize.padding;
            imgSize.width = imgSize.height * imgSize.originalWidth / imgSize.originalHeight;
        }

        // resize if picture size hang over close button
        if (imgSize.width > getWinWidth() - imgSize.margin - imgSize.padding &&
            imgSize.height > getWinHeight() - imgSize.margin - imgSize.padding) {

            if (imgSize.originalWidth >= imgSize.originalHeight) {
                imgSize.width = getWinWidth() - imgSize.margin - imgSize.padding;
                imgSize.height = imgSize.width * imgSize.originalHeight / imgSize.originalWidth;
            } else {
                imgSize.height = getWinHeight() - imgSize.margin - imgSize.padding;
                imgSize.width = imgSize.height * imgSize.originalWidth / imgSize.originalHeight;
            }
        }
    }

    function resetImageSize() {
        imgSize.el = null;
        imgSize.originalWidth = 0;
        imgSize.originalHeight = 0;
        imgSize.width = 0;
        imgSize.height = 0;
        imgSize.returnWidth = 0;
        imgSize.returnHeight = 0;
    }


    // image expand on click thumbnails
    /**
     * showExpandedImage
     * @param {Object} info
     * @param {Boolean} isFirst
     */
    function showExpandedImage(info, isFirstTime) {
        $('.bg-image').removeClass('hide').addClass('show');

        if (isFirstTime) {
            setElement(info);
        }

        if (imgSize.el) {
            setImageSize();

            // expand and show
            var thumbnail = info.thumbnail;
            var target = $('.expanded-image');

            $(target).find('img')
                .attr('src', info.src)
                .css({
                    'width': $(thumbnail).width() + 'px',
                    'height': $(thumbnail).height() + 'px'
                })
                .animate({
                    'width': imgSize.width + 'px',
                    'height': imgSize.height + 'px'
                }, 300);

            $(target).removeClass('hide').addClass('show');

            // for return
            imgSize.returnWidth = $(thumbnail).width();
            imgSize.returnHeight = $(thumbnail).height();
        } else {
            // wait until be set image
            setTimeout(function () {
                showExpandedImage(info, false);
            }, 50);
        }
    }

    // hide expanded image
    $('.bg-image').on('click', function () {
        var target = $('.expanded-image');
        $(target).removeClass('show');
        $(target).find('img')
            .animate({
                'width': imgSize.returnWidth + 'px',
                'height': imgSize.returnHeight + 'px'
            }, 300);

        $(this)
            .removeClass('show')
            .on('transitionend', function () {
                if (!$(this).hasClass('show')) {
                    $(this).addClass('hide');
                    $(target).addClass('hide');
                    resetImageSize();
                }
            });
    });

    // resize
    function adjustExpandedImage() {
        setImageSize();

        var target = $('.expanded-image');
        $(target).find('img').css({
            'width': imgSize.width + 'px',
            'height': imgSize.height + 'px'
        });
    }

    $(window).on('resize', function () {
        if ($('.expanded-image.show').length) {
            adjustExpandedImage();
        }
    });

    function adjustWrapper() {
        if (!pc) return;

        var sidebar = $('.main-sidebar');
        var content = $('.content-wrapper');
        var footer = $('.main-footer');

        if ($(sidebar).length && $(content).length) {
            if ($(window).outerWidth() > 991) {
                $(content).removeAttr('style');

                if ($(sidebar).outerHeight(true) >= $(content).outerHeight(true) + $(footer).outerHeight(true)) {
                    var margin = $(content).outerHeight(true) - $(content).height();
                    var height = $(sidebar).outerHeight(true) - $(footer).outerHeight(true) - margin;
                    $(content).css('min-height', height + 'px');
                }

            } else {
                $(sidebar).removeAttr('style');
                $(content).removeAttr('style');
            }
        }
    }

    /* 求人情報管理 */
    // Dropzone各種設定
    // TODO: This function has to be separated each page or be standardized
    // $(function () {
    //     var images = [];
    //
    //     for (var i = 1; i <= 2; i++) {
    //         var dzName = 'jsFileDropzone';
    //         configDropzone(dzName, i);
    //     }
    //
    //     function configDropzone(target, num) {
    //
    //         var targetId = '#' + target + num.toString().padStart(2, '0');
    //         var previewsId = '#' + target + 'Previews' + num.toString().padStart(2, '0');
    //
    //         // https://www.dropzonejs.com/
    //         // https://pgmemo.tokyo/data/archives/982.html 参考
    //         $(targetId).dropzone({
    //             url: '#',
    //             paramName: 'file[]',
    //             acceptedFiles: 'image/*',
    //             maxFilesize: 10, // MB
    //             addRemoveLinks: true,
    //             previewsContainer: previewsId,
    //             thumbnailWidth: 120,
    //             thumbnailHeight: 120,
    //             dictCancelUpload: 'キャンセル',
    //             dictCancelUploadConfirmation: 'アップロードをキャンセルします。よろしいですか？',
    //             // dictRemoveFileConfirmation: 'ファイルを削除します。よろしいですか？',
    //
    //             addedfile: function (file) {
    //                 // call super (prototype)
    //                 var _addedfile = Dropzone.prototype.defaultOptions.addedfile;
    //                 _addedfile.call(this, file);
    //                 images.push(file);
    //
    //                 // TODO: 不要なら削除
    //                 // add expand button
    //                 // var expandButton = Dropzone.createElement('<a class="dz-expand">Expand Image</a>');
    //                 // file.previewElement.appendChild(expandButton);
    //             },
    //             uploadprogress: function (file, progress, size) {
    //                 file.previewElement.querySelector('[data-dz-uploadprogress]').style.width = '' + progress + '%';
    //                 // images.push(file);
    //             },
    //             success: function (file, rt, xml) {
    //                 file.previewElement.classList.add('dz-success');
    //                 $(file.previewElement).find('.dz-success-mark').show();
    //             },
    //             processing: function () {
    //                 // TODO: ファイルアップロード中の処理
    //             },
    //             queuecomplete: function () {
    //                 // TODO: 全てのファイルアップロードが完了した時の処理
    //                 $(targetId).removeClass('dz-drag-hover');
    //             },
    //             dragover: function (e) {
    //                 $(targetId).addClass('dz-drag-hover');
    //             },
    //             dragleave: function (e) {
    //                 $(targetId).removeClass('dz-drag-hover');
    //             },
    //             drop: function (e) {
    //                 $(targetId).removeClass('dz-drag-hover');
    //             },
    //             error: function (file, _error_msg) {
    //                 // TODO: エラー処理
    //             },
    //             removedfile: function (file) {
    //                 // TODO: ファイル削除処理
    //                 file.previewElement.remove();
    //             },
    //             canceled: function () {
    //                 // 必要なら処理を記述
    //             }
    //         });
    //     }
    //
    //     // display expanded image on click
    //     // May be it can use only registration
    //     var image = null;
    //
    //     function preloadImageModal(src) {   // local method
    //         var preImage = new Image();
    //         preImage.src = src;
    //         preImage.onload = function (ev) {
    //             image = preImage;
    //         };
    //     }
    //
    //     function showExpandedImageModal(info, isFirstTime) {    // local method
    //         if (isFirstTime) {
    //             preloadImageModal(info.dataURL);
    //         }
    //
    //         if (image) {
    //             var target = $('.modal.image');
    //
    //             $(target).find('.modal-title').text(info.name);
    //             $(target).find('.image').attr('src', info.dataURL).attr('alt', info.name);
    //
    //             $(target)
    //                 .on('hidden.bs.modal', function () {
    //                     $(target).find('.modal-title').text('');
    //                     $(target).find('.image').attr('src', 'images/img_dummy.png').attr('alt', '');
    //                     image = null;
    //                 })
    //                 .modal('show');
    //         } else {
    //             setTimeout(function () {
    //                 showExpandedImageModal(info, false);
    //             }, 50);
    //         }
    //     }
    //
    //     if ($('.modal.image').length) {
    //         // expand on click
    //         $(document).on('click', '.dz-preview', function () {
    //             var fileName = $(this).find('.dz-details').find('.dz-filename span').text();
    //             var target = {};
    //
    //             for (var i = 0; i < images.length; i++) {
    //                 if (images[i].name === fileName) {
    //                     target = images[i];
    //                     break;
    //                 }
    //             }
    //
    //             showExpandedImageModal(target, true);
    //         });
    //     }
    // });




    /*
    ---------------------------------------
    コンテンツ管理
    ---------------------------------------
    */

    /* 画像管理 */
    // layout pictures
    $(function () {
        var setImageSize = function () {
            // fit outer grid (hide image and set as div bg)
            $('.grid-item').each(function () {
                // original image size
                var image = new Image();
                image.src = $(this).find('img').attr('src');

                var img = {
                    'el': $(this).find('img'),
                    'src': $(this).find('img').attr('src'),
                    'originalWidth': image.width,
                    'originalHeight': image.height
                };

                var div = {
                    'el': $(this),
                    'width': $(this).width(),
                    'height': $(this).height(),
                    'bgWidth': Math.ceil($(this).width()),
                    'maxWidth': (sp) ? 250 : 450
                };

                $(div.el).find('a').css({
                    'background-image': 'url(' + img.src + ')',
                    'background-repeat': 'no-repeat',
                    'background-size': div.bgWidth + 'px auto',
                    'background-position': 'center center'
                });

                // for last row
                if (div.bgWidth === div.maxWidth) {
                    var wRatio = img.originalWidth / img.originalHeight;
                    var hRatio = img.originalHeight / img.originalWidth;

                    var tmpWidth = Math.ceil(div.height * wRatio);
                    var tmpHeight = tmpWidth * hRatio;

                    if (tmpHeight > div.height) {
                        $(this).css({
                            'max-width': tmpWidth + 'px',
                            'background-size': tmpWidth + 'px auto'
                        });
                    }
                }


                // show background image of a on load complete
                var loader = $(div.el).find('.loader');
                image.onload = function (ev) {
                    $(img.el).addClass('hide');
                    $(loader).addClass('hide');
                };

                $(loader).on('transitionend', function () {
                    if ($(this).hasClass('hide')) {
                        $(this).remove();
                    }
                });
            });
        };

        if ($('.grid-item').length) {
            setImageSize();

            $(window).on('load resize', function () {
                setImageSize();
            });

            $('.images-management').on('transitionend', function () {
                setImageSize();
            });
        }


        // 画像情報 - image detail show on click images
        $(document).on('click', '.grid-item a', function () {
            var img = $(this).find('img');
            var modal = $('.detail-image');

            $(modal).find('.img-area img').attr('src', $(img).attr('src'));
            $(modal).modal();
        });


        // 拡大画像 - expand on click image of detail modal
        // show detail modal
        $('a.expand').on('click', function () {
            var info = {
                thumbnail: $(this).find('img'),
                src: $(this).find('img').attr('src')
            };
            showExpandedImage(info, true);
        });
    });




    // 画像アップロード - upload images (register) modal
    $(function () {
        var images = [];
        var targetId = '#jsFileDropzoneModal';
        var previewsId = '#jsFileDropzonePreviewsModal';

        // https://www.dropzonejs.com/
        // Especially mobile safari needs to create and destroy this instance every time.
        // To only initialize (contain "removeAllFiles" method) doesn't work upload images
        // when modal displayed after the second time.

        $('.register-images').on('show.bs.modal', function () {

            $(targetId).dropzone({
                url: '#',
                paramName: 'file[]',
                acceptedFiles: 'image/*',
                maxFilesize: 10,    // MB
                addRemoveLinks: true,
                previewsContainer: previewsId,
                thumbnailWidth: 120,
                thumbnailHeight: 120,
                dictCancelUpload: 'キャンセル',
                dictCancelUploadConfirmation: 'アップロードをキャンセルします。よろしいですか？',
                // dictRemoveFileConfirmation: 'ファイルを削除します。よろしいですか？',

                addedfile: function (file) {
                    // call super (prototype)
                    var _addedfile = Dropzone.prototype.defaultOptions.addedfile;
                    _addedfile.call(this, file);
                    adjustDropzoneArea();
                    images.push(file);
                },
                uploadprogress: function (file, progress, size) {
                    file.previewElement.querySelector('[data-dz-uploadprogress]').style.width = '' + progress + '%';
                    // images.push(file);
                },
                success: function (file, rt, xml) {
                    file.previewElement.classList.add('dz-success');
                    $(file.previewElement).find('.dz-success-mark').show();
                },
                processing: function () {
                    // TODO: ファイルアップロード中の処理
                },
                queuecomplete: function () {
                    // TODO: 全てのファイルアップロードが完了した時の処理
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
                    // TODO: エラー処理
                },
                removedfile: function (file) {
                    // TODO: ファイル削除処理
                    file.previewElement.remove();

                    adjustDropzoneArea();
                },
                canceled: function () {
                    // 必要なら処理を記述
                }
            });
        });

        $('.register-images').on('hide.bs.modal', function () {
            $(targetId)[0].dropzone.destroy();
            images = [];
            adjustDropzoneArea();
        });


        // adjust the dropzone area inside of the .register-images
        function adjustDropzoneArea() {
            var border = 2;
            var defaultHeight = $(targetId).closest('.modal-body').height() - border;
            var minHeight = (sp) ? 165 : 150;

            var dzHeight = defaultHeight - $(previewsId).height();
            if (dzHeight < minHeight) {
                dzHeight = minHeight;
            }

            $(targetId).outerHeight(dzHeight);
            $('.dz-wrapper').height(dzHeight + $(previewsId).height());
        }



        $(window).on('resize', function () {
            if ($('.register-images.show').length) {
                adjustDropzoneArea();
            }
        });

        // display expanded image on thumbnail click
        if ($(targetId).length) {
            $(document).on('click', '.dz-preview', function () {
                var fileName = $(this).find('.dz-filename span').text();
                var target = {};

                for (var i = 0; i < images.length; i++) {
                    if (images[i].name === fileName) {
                        target = images[i];
                        break;
                    }
                }

                var info = {
                    thumbnail: $(this).find('.dz-image img'),
                    src: target.dataURL
                };

                showExpandedImage(info, true);
            });
        }
    });

});
