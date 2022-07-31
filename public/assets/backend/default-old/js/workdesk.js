$.fn.toggleAttr = function(attr, attr1, attr2) {
    return this.each(function() {
        var self = $(this);
        if (self.attr(attr) == attr1) self.attr(attr, attr2);
        else self.attr(attr, attr1);
    });
};
(function($) {
    // USE STRICT
    "use strict";
    WORKDESK.data.csrf = $('meta[name="csrf-token"]').attr("content");
    WORKDESK.aizUploader = {
        data: {
            selectedFiles: [],
            allFiles: [],
            multiple: false,
            type: 'all'
        },
        removeInputValue: function(id, array, elem) {
            var selected = array.filter(function(item) {
                return item !== id;
            });
            if (selected.length > 0) {
                $(elem)
                    .find(".file-amount")
                    .html(WORKDESK.aizUploader.updateFileHtml(selected));
            } else {
                elem.find(".file-amount").html("Choose File");
            }
            $(elem)
                .find(".selected-files")
                .val(selected);
        },
        removeAttachment: function() {
            $(".remove-attachment").each(function() {
                $(this).on("click", function() {
                    var value = $(this)
                        .closest(".file-preview-item")
                        .data("id");
                    var selected = $(this)
                        .closest(".file-preview")
                        .prev('[data-toggle="aizuploader"]')
                        .find(".selected-files")
                        .val()
                        .split(",")
                        .map(Number);

                    WORKDESK.aizUploader.removeInputValue(
                        value,
                        selected,
                        $(this)
                            .closest(".file-preview")
                            .prev('[data-toggle="aizuploader"]')
                    );
                    $(this)
                        .closest(".file-preview-item")
                        .remove();
                });
            });
        },
        deleteUploaderFile: function() {
            $(".aiz-uploader-delete").each(function() {
                $(this).on("click", function(e) {
                    e.preventDefault();
                    var id = $(this).data("id");
                    $.ajax({
                        url:
                            WORKDESK.data.appUrl +
                            "/aiz-uploader/destroy/" +
                            id,
                        type: "DELETE",
                        dataType: "JSON",
                        data: {
                            id: id,
                            _method: "DELETE",
                            _token: WORKDESK.data.csrf
                        },
                        success: function() {
                            WORKDESK.aizUploader.data.selectedFiles = WORKDESK.aizUploader.data.selectedFiles.filter(
                                function(item) {
                                    return item !== id;
                                }
                            );
                            WORKDESK.aizUploader.updateUploaderSelected();
                            WORKDESK.aizUploader.getAllUploads();
                        }
                    });
                });
            });
        },
        uploadSelect: function() {
            $(".aiz-uploader-select").each(function() {
                var elem = $(this);
                elem.on("click", function(e) {
                    var value = $(this).data("value");

                    elem.closest(".aiz-file-box-wrap").toggleAttr(
                        "data-selected",
                        "true",
                        "false"
                    );
                    if (!WORKDESK.aizUploader.data.multiple) {
                        elem.closest(".aiz-file-box-wrap")
                            .siblings()
                            .attr("data-selected", "false");
                    }
                    if (
                        !WORKDESK.aizUploader.data.selectedFiles.includes(value)
                    ) {
                        if (!WORKDESK.aizUploader.data.multiple) {
                            WORKDESK.aizUploader.data.selectedFiles = [];
                        }
                        WORKDESK.aizUploader.data.selectedFiles.push(value);
                    } else {
                        WORKDESK.aizUploader.data.selectedFiles = WORKDESK.aizUploader.data.selectedFiles.filter(
                            function(item) {
                                return item !== value;
                            }
                        );
                    }
                    WORKDESK.aizUploader.addSelectedValue();
                    WORKDESK.aizUploader.updateUploaderSelected();
                });
            });
        },
        updateFileHtml: function(array) {
            var fileText = "";
            if (array.length > 1) {
                var fileText = "Files";
            } else {
                var fileText = "File";
            }
            return array.length + " " + fileText + " " + "selected";
        },
        updateUploaderSelected: function() {
            $(".aiz-uploader-selected").html(
                WORKDESK.aizUploader.updateFileHtml(
                    WORKDESK.aizUploader.data.selectedFiles
                )
            );
        },
        clearUploaderSelected: function() {
            $(".aiz-uploader-selected-clear").on("click", function() {
                WORKDESK.aizUploader.data.selectedFiles = [];
                WORKDESK.aizUploader.addSelectedValue();
                WORKDESK.aizUploader.addHiddenValue();
                WORKDESK.aizUploader.resetFilter();
                WORKDESK.aizUploader.updateUploaderSelected();
                WORKDESK.aizUploader.updateUploaderFiles();
            });
        },
        resetFilter: function() {
            $('[name="aiz-uploader-search"]').val("");
            $('[name="aiz-show-selected"]').prop("checked", false);
            $('[name="aiz-uploader-sort"] option[value=newest]').prop(
                "selected",
                true
            );
        },
        getAllUploads: function() {
            $(".aiz-uploader-all").html(
                '<div class="align-items-center d-flex h-100 justify-content-center w-100"><div class="spinner-border" role="status"></div></div>'
            );
            $.get(
                WORKDESK.data.appUrl + "/aiz-uploader/get_uploaded_files",
                {},
                function(data, status) {
                    WORKDESK.aizUploader.data.allFiles = data;
                    WORKDESK.aizUploader.allowedFileType();
                    WORKDESK.aizUploader.addSelectedValue();
                    WORKDESK.aizUploader.addHiddenValue();
                    WORKDESK.aizUploader.resetFilter();
                    WORKDESK.aizUploader.updateUploaderFiles();
                }
            );
        },
        showSelectedFiles: function() {
            $('[name="aiz-show-selected"]').on("change", function() {
                if ($(this).is(":checked")) {
                    for (
                        var i = 0;
                        i < WORKDESK.aizUploader.data.allFiles.length;
                        i++
                    ) {
                        if (WORKDESK.aizUploader.data.allFiles[i].selected) {
                            WORKDESK.aizUploader.data.allFiles[
                                i
                            ].aria_hidden = false;
                        } else {
                            WORKDESK.aizUploader.data.allFiles[
                                i
                            ].aria_hidden = true;
                        }
                    }
                } else {
                    for (
                        var i = 0;
                        i < WORKDESK.aizUploader.data.allFiles.length;
                        i++
                    ) {
                        WORKDESK.aizUploader.data.allFiles[
                            i
                        ].aria_hidden = false;
                    }
                }
                WORKDESK.aizUploader.updateUploaderFiles();
            });
        },
        searchUploaderFiles: function() {
            $('[name="aiz-uploader-search"]').on("keyup", function() {
                var value = $(this)
                    .val()
                    .toUpperCase();
                if (WORKDESK.aizUploader.data.allFiles.length > 0) {
                    for (
                        var i = 0;
                        i < WORKDESK.aizUploader.data.allFiles.length;
                        i++
                    ) {
                        if (
                            WORKDESK.aizUploader.data.allFiles[
                                i
                            ].file_original_name
                                .toUpperCase()
                                .indexOf(value) > -1
                        ) {
                            WORKDESK.aizUploader.data.allFiles[
                                i
                            ].aria_hidden = false;
                        } else {
                            WORKDESK.aizUploader.data.allFiles[
                                i
                            ].aria_hidden = true;
                        }
                    }
                }
                WORKDESK.aizUploader.updateUploaderFiles();
            });
        },
        sortUploaderFiles: function() {
            $('[name="aiz-uploader-sort"]').on("change", function() {
                var value = $(this).val();
                if (value === "oldest") {
                    WORKDESK.aizUploader.data.allFiles = WORKDESK.aizUploader.data.allFiles.sort(
                        function(a, b) {
                            return (
                                new Date(a.created_at) - new Date(b.created_at)
                            );
                        }
                    );
                } else if (value === "smallest") {
                    WORKDESK.aizUploader.data.allFiles = WORKDESK.aizUploader.data.allFiles.sort(
                        function(a, b) {
                            return a.file_size - b.file_size;
                        }
                    );
                } else if (value === "largest") {
                    WORKDESK.aizUploader.data.allFiles = WORKDESK.aizUploader.data.allFiles.sort(
                        function(a, b) {
                            return b.file_size - a.file_size;
                        }
                    );
                } else {
                    WORKDESK.aizUploader.data.allFiles = WORKDESK.aizUploader.data.allFiles.sort(
                        function(a, b) {
                            a = new Date(a.created_at);
                            b = new Date(b.created_at);
                            return a > b ? -1 : a < b ? 1 : 0;
                        }
                    );
                }
                WORKDESK.aizUploader.updateUploaderFiles();
            });
        },
        addSelectedValue: function() {
            for (
                var i = 0;
                i < WORKDESK.aizUploader.data.allFiles.length;
                i++
            ) {
                if (
                    !WORKDESK.aizUploader.data.selectedFiles.includes(
                        WORKDESK.aizUploader.data.allFiles[i].id
                    )
                ) {
                    WORKDESK.aizUploader.data.allFiles[i].selected = false;
                } else {
                    WORKDESK.aizUploader.data.allFiles[i].selected = true;
                }
            }
        },
        addHiddenValue: function() {
            for (
                var i = 0;
                i < WORKDESK.aizUploader.data.allFiles.length;
                i++
            ) {
                WORKDESK.aizUploader.data.allFiles[i].aria_hidden = false;
            }
        },
        allowedFileType:function() {
            if (WORKDESK.aizUploader.data.type !== 'all') {
                WORKDESK.aizUploader.data.allFiles = WORKDESK.aizUploader.data.allFiles.filter(
                    function(item) {
                        return item.type === WORKDESK.aizUploader.data.type;
                    }
                );
            }

        },
        updateUploaderFiles: function() {
            $(".aiz-uploader-all").html(
                '<div class="align-items-center d-flex h-100 justify-content-center w-100"><div class="spinner-border" role="status"></div></div>'
            );

            var data = WORKDESK.aizUploader.data.allFiles;

            setTimeout(function() {
                $(".aiz-uploader-all").html(null);

                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        var thumb = "";
                        var hidden = "";
                        if (data[i].type === "image") {
                            thumb =
                                '<img src="' +
                                WORKDESK.data.appUrl +
                                "/" +
                                data[i].file_name +
                                '" class="img-fit">';
                        } else {
                            thumb = '<i class="la la-file-text"></i>';
                        }
                        var html =
                            '<div class="aiz-file-box-wrap" aria-hidden="' +
                            data[i].aria_hidden +
                            '" data-selected="' +
                            data[i].selected +
                            '">' +
                            '<div class="aiz-file-box">' +
                            '<div class="dropdown-file">' +
                            '<a class="dropdown-link" data-toggle="dropdown">' +
                            '<i class="la la-ellipsis-v"></i>' +
                            "</a>" +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a href="' +
                            WORKDESK.data.appUrl +
                            "/" +
                            data[i].file_name +
                            '" target="_blank" download="' +
                            data[i].file_original_name +
                            "." +
                            data[i].extension +
                            '" class="dropdown-item"><i class="la la-download"></i>Download</a>' +
                            '<a href="#" class="dropdown-item aiz-uploader-delete" data-id="' +
                            data[i].id +
                            '"><i class="la la-trash"></i>Delete</a>' +
                            "</div>" +
                            "</div>" +
                            '<div class="card card-file aiz-uploader-select" title="' +
                            data[i].file_original_name +
                            "." +
                            data[i].extension +
                            '" data-value="' +
                            data[i].id +
                            '">' +
                            '<div class="card-file-thumb">' +
                            thumb +
                            "</div>" +
                            '<div class="card-body">' +
                            '<h6 class="d-flex">' +
                            '<span class="text-truncate title">' +
                            data[i].file_original_name +
                            "</span>" +
                            '<span class="ext">.' +
                            data[i].extension +
                            "</span>" +
                            "</h6>" +
                            "<p>" +
                            WORKDESK.utility.bytesToSize(data[i].file_size) +
                            "</p>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>";

                        $(".aiz-uploader-all").append(html);
                    }
                } else {
                    $(".aiz-uploader-all").html(
                        '<div class="align-items-center d-flex h-100 justify-content-center w-100 nav-tabs"><div class="text-center"><h3>No files found</h3></div></div>'
                    );
                }
                WORKDESK.aizUploader.uploadSelect();
                WORKDESK.aizUploader.deleteUploaderFile();
            }, 300);
        },
        init: function() {
            $('[data-toggle="aizuploader"]').on("click", function() {
                var elem = $(this);
                var multiple = elem.data("multiple");
                var type = elem.data("type");
                var oldSelectedFiles = elem.find(".selected-files").val();
                if (oldSelectedFiles !== "") {
                    WORKDESK.aizUploader.data.selectedFiles = oldSelectedFiles
                        .split(",")
                        .map(Number);
                } else {
                    WORKDESK.aizUploader.data.selectedFiles = [];
                }

                if (('undefined' !== typeof type) && (type.length > 0)) {
                    WORKDESK.aizUploader.data.type = type;
                }

                if (multiple) {
                    WORKDESK.aizUploader.data.multiple = multiple;
                }

                $.post(
                    WORKDESK.data.appUrl + "/aiz-uploader",
                    { _token: WORKDESK.data.csrf },
                    function(data) {
                        $("#ajax-modal").html(data);
                        $("#aizUploaderModal").modal("show");
                        WORKDESK.plugins.aizUppy();
                        WORKDESK.aizUploader.getAllUploads();
                        WORKDESK.aizUploader.updateUploaderSelected();
                        WORKDESK.aizUploader.clearUploaderSelected();
                        WORKDESK.aizUploader.sortUploaderFiles();
                        WORKDESK.aizUploader.searchUploaderFiles();
                        WORKDESK.aizUploader.showSelectedFiles();

                        $(".aiz-uploader-search i").on("click", function() {
                            $(this)
                                .parent()
                                .toggleClass("open");
                        });
                        $('[data-toggle="aizUploaderAddSelected"]').on(
                            "click",
                            function() {
                                $("#aizUploaderModal").modal("hide");
                                elem.find(".selected-files").val(
                                    WORKDESK.aizUploader.data.selectedFiles
                                );
                                elem.next(".file-preview").html(null);
                                if (
                                    WORKDESK.aizUploader.data.selectedFiles
                                        .length > 0
                                ) {
                                    elem.find(".file-amount").html(
                                        WORKDESK.aizUploader.updateFileHtml(
                                            WORKDESK.aizUploader.data
                                                .selectedFiles
                                        )
                                    );
                                    for (
                                        var i = 0;
                                        i <
                                        WORKDESK.aizUploader.data.selectedFiles
                                            .length;
                                        i++
                                    ) {
                                        var index = WORKDESK.aizUploader.data.allFiles.findIndex(
                                            x =>
                                                x.id ===
                                                WORKDESK.aizUploader.data
                                                    .selectedFiles[i]
                                        );
                                        var thumb = "";
                                        if (
                                            WORKDESK.aizUploader.data.allFiles[
                                                index
                                            ].type === "image"
                                        ) {
                                            thumb =
                                                '<img src="' +
                                                WORKDESK.data.appUrl +
                                                "/" +
                                                WORKDESK.aizUploader.data
                                                    .allFiles[index].file_name +
                                                '" class="img-fit">';
                                        } else {
                                            thumb =
                                                '<i class="la la-file-text"></i>';
                                        }
                                        var html =
                                            '<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="' +
                                            WORKDESK.aizUploader.data.allFiles[
                                                index
                                            ].id +
                                            '" title="' +
                                            WORKDESK.aizUploader.data.allFiles[
                                                index
                                            ].file_original_name +
                                            "." +
                                            WORKDESK.aizUploader.data.allFiles[
                                                index
                                            ].extension +
                                            '">' +
                                            '<div class="align-items-center align-self-stretch d-flex justify-content-center thumb">' +
                                            thumb +
                                            "</div>" +
                                            '<div class="col body">' +
                                            '<h6 class="d-flex">' +
                                            '<span class="text-truncate title">' +
                                            WORKDESK.aizUploader.data.allFiles[
                                                index
                                            ].file_original_name +
                                            "</span>" +
                                            '<span class="ext">.' +
                                            WORKDESK.aizUploader.data.allFiles[
                                                index
                                            ].extension +
                                            "</span>" +
                                            "</h6>" +
                                            "<p>" +
                                            WORKDESK.utility.bytesToSize(
                                                WORKDESK.aizUploader.data
                                                    .allFiles[index].file_size
                                            ) +
                                            "</p>" +
                                            "</div>" +
                                            '<div class="remove">' +
                                            '<button class="btn btn-sm btn-link remove-attachment" type="button">' +
                                            '<i class="la la-close"></i>' +
                                            "</button>" +
                                            "</div>" +
                                            "</div>";

                                        elem.next(".file-preview").append(html);
                                    }
                                } else {
                                    elem.find(".file-amount").html(
                                        "Choose File"
                                    );
                                }

                                WORKDESK.aizUploader.removeAttachment();
                            }
                        );
                    }
                );
            });
        }
    };
    WORKDESK.plugins = {
        showAlert: function(type, message) {
            var options = {
                text: message,
                position: "bottom-right",
                icon: type
            };
            $.toast().reset("all");
            $.toast(options);
        },
        rowClickable: function() {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        },
        rowClickableDropdown: function() {
            $(".clickable-row")
                .find('[data-toggle="dropdown"]')
                .click(function(e) {
                    e.stopPropagation();
                    $(this)
                        .next(".dropdown-menu")
                        .toggle();
                });
        },
        textEditor: function() {
            $(".editor").each(function(el) {
                var $this = $(this);
                var buttons = $this.data("buttons");
                buttons = !buttons
                    ? "bold,underline,italic,hr,|,ul,ol,|,align,paragraph,|,image,table,link,undo,redo"
                    : buttons;

                var editor = new Jodit(this, {
                    uploader: {
                        insertImageAsBase64URI: true
                    },
                    toolbarAdaptive: false,
                    defaultMode: "1",
                    toolbarSticky: false,
                    showXPathInStatusbar: false,
                    buttons: buttons
                });
            });
        },
        fileUploader: function() {
            $(".file-upload").each(function() {
                var $this = $(this);

                var fileMultiple = $this.data("file-multiple");
                var containerDiv = $this.data("container");
                var statusbarClass = $this.data("statusbar-class");

                fileMultiple = !fileMultiple ? false : fileMultiple;
                containerDiv = !containerDiv ? false : containerDiv;
                statusbarClass = !statusbarClass ? "" : statusbarClass;

                $this.uploadFile({
                    url: "YOUR_FILE_UPLOAD_URL",
                    fileName: "myfile",
                    multiple: fileMultiple,
                    uploadStr: "browse",
                    abortStr: "Cancel",
                    deleteStr: "Remove",
                    maxFileCount: 1,
                    showQueueDiv: containerDiv,
                    dragDropStr: "<span>Drag & drop files or</span>",
                    customProgressBar: function(obj, s) {
                        this.statusbar = $(
                            "<div class='ajax-file-upload-statusbar " +
                                statusbarClass +
                                "'></div>"
                        );
                        this.filename = $(
                            "<div class='ajax-file-upload-filename'></div>"
                        ).appendTo(this.statusbar);
                        this.progressDiv = $(
                            "<div class='ajax-file-upload-progress bg-soft-dark'>"
                        )
                            .appendTo(this.statusbar)
                            .hide();
                        this.progressbar = $(
                            "<div class='ajax-file-upload-bar bg-primary'></div>"
                        ).appendTo(this.progressDiv);
                        this.abort = $("<div>" + s.abortStr + "</div>")
                            .appendTo(this.statusbar)
                            .hide();
                        this.cancel = $("<div>" + s.cancelStr + "</div>")
                            .appendTo(this.statusbar)
                            .hide();
                        this.done = $("<div>" + s.doneStr + "</div>")
                            .appendTo(this.statusbar)
                            .hide();
                        this.download = $("<div>" + s.downloadStr + "</div>")
                            .appendTo(this.statusbar)
                            .hide();
                        this.del = $("<div>" + s.deleteStr + "</div>")
                            .appendTo(this.statusbar)
                            .hide();

                        this.abort.addClass(
                            "btn btn-sm p-0 btn-danger position-absolute"
                        );
                        this.done.addClass("btn btn-sm p-0 btn-success");
                        this.download.addClass("btn btn-sm p-0 btn-success");
                        this.cancel.addClass("btn btn-sm p-0 btn-danger");
                        this.del.addClass(
                            "btn btn-sm p-0 btn-danger position-absolute"
                        );
                    }
                });
            });
        },
        aizUppy: function() {
            if ($("#aiz-upload-files").length > 0) {
                var uppy = Uppy.Core({
                    autoProceed: true
                });
                uppy.use(Uppy.Dashboard, {
                    target: "#aiz-upload-files",
                    inline: true,
                    showLinkToFileUploadResult: false,
                    showProgressDetails: true,
                    hideCancelButton: true,
                    hidePauseResumeButton: true,
                    hideUploadButton: true,
                    proudlyDisplayPoweredByUppy: false
                });
                uppy.use(Uppy.XHRUpload, {
                    endpoint: WORKDESK.data.appUrl + "/aiz-uploader/upload",
                    fieldName: "aiz_file"
                    // headers: {
                    //     '_token': WORKDESK.data.csrf
                    // }
                });
                uppy.on("upload-success", function() {
                    WORKDESK.aizUploader.getAllUploads();
                });
            }
        }
    };

    WORKDESK.utility = {
        bytesToSize: function bytesToSize(bytes) {
            var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
            if (bytes == 0) return "0 Byte";
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
        },
        removeParent: function(em, parent) {
            $(em)
                .closest("." + parent)
                .remove();
        },
        deleteConfirm: function() {
            $(".confirm-delete").click(function(e) {
                e.stopPropagation();
                var url = $(this).data("href");
                $("#delete-modal").modal("show");
                $("#delete-link").attr("href", url);
            });
        },
        addMore: function() {
            $(".add-more").each(function() {
                var $this = $(this);
                var target = $this.data("target");
                var source = $this.data("source");
                var elem = $("." + source).html();

                $this.on("click", function() {
                    $("." + target).append(elem);
                    WORKDESK.plugins.appendSelect2();
                });
            });
        },
        selectHideShow: function() {
            $('[data-show="selectShow"]').each(function() {
                var target = $(this).data("target");
                $(this).on("change", function() {
                    var value = $(this).val();
                    $(target)
                        .children()
                        .not("." + value)
                        .addClass("d-none");
                    $(target)
                        .find("." + value)
                        .removeClass("d-none");
                });
            });
        }
    };
})(jQuery);

(function($) {
    "use strict";

    WORKDESK.utility.deleteConfirm();

    // initialization of fileuploader
    WORKDESK.plugins.fileUploader();

    WORKDESK.utility.selectHideShow();

    // initialization of clickable row
    WORKDESK.plugins.rowClickable();
    WORKDESK.plugins.rowClickableDropdown();

    WORKDESK.plugins.textEditor();

    // initialization of aiz uploader
    WORKDESK.aizUploader.init();
    WORKDESK.aizUploader.removeAttachment();
})(window.jQuery);
