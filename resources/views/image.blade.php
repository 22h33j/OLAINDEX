@extends('layouts.main')
@section('title','图床')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@5/dist/min/dropzone.min.css">
    <style>
        .dropzone {
            border: 2px dashed #ccc;
            border-radius: 10px;
            background: white;
        }

        .link-container {
            margin-top: 20px;
            padding: 10px;
            border: solid 1px #dadada;
            overflow-wrap: break-word;
            background-color: #f7f7f7;
        }
    </style>
@stop
@section('content')
    <div class="card border-light mb-3">
        <div class="card-body">
            <div class="page-container">
                <h4>图床</h4>
                <p>您可以尝试文件拖拽或者点击虚线框进行文件上传，单张图片最大支持4MB.</p>
                <form class="dropzone" id="image-dropzone">
                </form>
            </div>
        </div>
    </div>
    <div id="showUrl" class="invisible">
        <ul id="navTab" class="nav nav-tabs">
            <li class="nav-item active">
                <a class="nav-link" data-toggle="tab" href="#urlPanel">URL</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#htmlPanel">HTML</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#bbPanel">bbCode</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#markdownPanel">Markdown</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#markdownLinkPanel">Markdown with Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#deletePanel">Delete Link</a>
            </li>
        </ul>
        <div id="navTabContent" class="tab-content">
            <div class="tab-pane fade in active show" id="urlPanel">
                <div class="link-container"><a href="javascript:void(0)" style="text-decoration: none"
                                               data-toggle="tooltip"
                                               data-placement="left" data-clipboard-target="#urlCode"
                                               class="clipboard"><i class="fa fa-copy"></i> 复制</a>&nbsp;&nbsp; <span
                        id="urlCode"></span></div>
            </div>
            <div class="tab-pane fade" id="htmlPanel">
                <div class="link-container"><a href="javascript:void(0)" style="text-decoration: none"
                                               data-toggle="tooltip"
                                               data-placement="left" data-clipboard-target="#htmlCode"
                                               class="clipboard"><i class="fa fa-copy"></i> 复制</a>&nbsp;&nbsp; <span
                        id="htmlCode"></span></div>
            </div>
            <div class="tab-pane fade" id="bbPanel">
                <div class="link-container"><a href="javascript:void(0)" style="text-decoration: none"
                                               data-toggle="tooltip"
                                               data-placement="left" data-clipboard-target="#bbCode"
                                               class="clipboard"><i class="fa fa-copy"></i> 复制</a>&nbsp;&nbsp; <span
                        id="bbCode"></span></div>
            </div>
            <div class="tab-pane fade" id="markdownPanel">
                <div class="link-container"><a href="javascript:void(0)" style="text-decoration: none"
                                               data-toggle="tooltip"
                                               data-placement="left" data-clipboard-target="#markdown"
                                               class="clipboard"><i class="fa fa-copy"></i> 复制</a>&nbsp;&nbsp; <span
                        id="markdown"></span></div>
            </div>
            <div class="tab-pane fade" id="markdownLinkPanel">
                <div class="link-container"><a href="javascript:void(0)" style="text-decoration: none"
                                               data-toggle="tooltip"
                                               data-placement="left" data-clipboard-target="#markdownLinks"
                                               class="clipboard"><i class="fa fa-copy"></i> 复制</a>&nbsp;&nbsp; <span
                        id="markdownLinks"></span></div>
            </div>
            <div class="tab-pane fade" id="deletePanel">
                <div class="link-container"><a href="javascript:void(0)" style="text-decoration: none"
                                               data-toggle="tooltip"
                                               data-placement="left" data-clipboard-target="#deleteCode"
                                               class="clipboard"><i class="fa fa-copy"></i> 复制</a>&nbsp;&nbsp; <span
                        id="deleteCode"></span></div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.options.imageDropzone = {
            url: Config.routes.upload_image,
            method: 'post',
            maxFilesize: 4,
            paramName: 'olaindex_img',
            maxFiles: 10,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            init: function () {
                this.on('sending', function (file, xhr, formData) {
                    formData.append('_token', Config._token);
                });
                this.on('success', function (file, response) {
                    $('#showUrl').removeClass('invisible');
                    $('#urlCode').append(response.data.url + '\n');
                    $('#htmlCode').append('&lt;img src=\'' + response.data.url + '\' alt=\'' + response.data.filename + '\' title=\'' + response.data.filename + '\' /&gt;' + '\n');
                    $('#bbCode').append('[img]' + response.data.url + '[/img]' + '\n');
                    $('#markdown').append('![' + response.data.filename + '](' + response.data.url + ')' + '\n');
                    $('#markdownLinks').append('[![' + response.data.filename + '](' + response.data.url + ')]' + '(' + response.data.url + ')' + '\n');
                    $('#deleteCode').append(response.data.delete + '\n')
                });
            },

            dictDefaultMessage: '拖拽文件至此上传',
            dictFallbackMessage: '浏览器不支持拖拽上传',
            dictFileTooBig: '文件过大(@{{filesize}}MiB)，请重试',
            dictInvalidFileType: '文件类型不支持',
            dictResponseError: '上传错误 @{{statusCode}}',
            dictCancelUpload: '取消上传',
            dictUploadCanceled: '上传已取消',
            dictCancelUploadConfirmation: '确定取消上传吗?',
            dictRemoveFile: '移除此文件',
            dictRemoveFileConfirmation: '确定移除此文件吗',
            dictMaxFilesExceeded: '已达到最大上传数.',
        };
    </script>
@stop
