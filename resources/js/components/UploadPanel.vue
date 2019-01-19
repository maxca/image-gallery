<template>
    <div class="uploader"
         @dragenter="OnDragEnter"
         @dragleave="OnDragLeave"
         @dragover.prevent
         @drop="onDrop"
         :class="{ dragging: isDragging }">

        <div class="upload-control" v-show="images.length">
            <label for="file">Select a file</label>
            <button @click="processFiles">Upload</button>
        </div>


        <div v-show="!images.length">
            <i class="fa fa-cloud-upload"></i>
            <p>Drag your images here</p>
            <div>OR</div>
            <div class="file-input">
                <label for="file">Select a file</label>
                <input type="file" id="file" @change="onInputChange" multiple>
            </div>
        </div>

        <div class="images-preview">
            <div class="img-wrapper img-thumbnail" v-for="image in items">
                <div class="details">
                    <div class="container " v-show="items.length" @mouseenter="showDelBtn=true;"
                         @mouseleave="showDelBtn=false;">
                        <img src="" :src="image.full_path" :alt="image.name">
                        <div class="container-btn">
                            <div class="container-btn-relative ">
                                <button class="btn btn-info btn-sm"
                                        @click="showImageModal(image.full_path)">View
                                </button>
                                <button class="btn btn-danger btn-sm"
                                        @click="deleteImage(image.id)">Delete
                                </button>
                            </div>
                        </div>
                        <div class="container-btn">
                            <div v-bind:class="{'progressbar' : image.isShowProgress}">
                                <img src="/image/loading.gif" v-if="image.isShowProgress"/>
                                {{image.uploadPercentage}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="imageModal" class="modal fade">
            <img class="modal-dialog" id="imgModal">
            <span class="close" data-dismiss="modal">&times;</span>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getImages();
        },
        data: () => ({
            isDragging: false,
            uploadPercentage: 0,
            dragCount: 0,
            files: [],
            images: [],
            items: [],
            showDelBtn: false,
            showImage: false,
        }),
        methods: {
            OnDragEnter(e) {
                e.preventDefault();
                this.dragCount++;
                this.isDragging = true;
                return false;
            },
            OnDragLeave(e) {
                e.preventDefault();
                this.dragCount--;
                if (this.dragCount <= 0)
                    this.isDragging = false;
            },
            onInputChange(e) {
                const files = e.target.files;
                this.processFiles(files);
            },
            onDrop(e) {
                e.preventDefault();
                e.stopPropagation();
                this.isDragging = false;
                const files = e.dataTransfer.files;
                this.processFiles(files);
            },
            processFiles(files) {
                Array.from(files).forEach(function (file) {

                    if (!file.type.match('image.*')) {
                        return;
                    }

                    const formData = new FormData();
                    formData.append('images[]', file, file.name);

                    axios.post('/images', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                        onUploadProgress: function (progressEvent) {
                            this.uploadPercentage = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total));
                            console.log(this.uploadPercentage)
                        }
                    }).then(response => {
                        console.log('response::,', response)
                        this.getImages()
                    }).catch(error => {
                        alert(error.response.data.message)
                    })
                }.bind(this));
            },

            getImages() {
                axios.get('/images').then(response => {
                    console.log('get image', response.data.data)
                    this.items = response.data.data
                }).catch(e => {
                    console.log(e)
                })
            },
            deleteImage: function deleteImage(id) {
                if(!confirm('do you want to delete this image')) return false
                axios.delete('images/' + id).then(response => {
                    console.log('deleteImage response', response)
                    this.getImages()
                }).catch(e => {
                    console.log('deleteImage error', e)
                })
            },
            showImageModal: function (url) {
                $('#imageModal').modal('show');
                $('#imgModal').attr('src', url);
            },
        }
    }
</script>

<style lang="scss" scoped>
    .container {
        position: relative;
        width: 250px;
        height: 250px;
        padding-left: 0px;
        padding-right: 0px;
    }

    .container img {
        width: 250px;
        height: 250px;
    }

    .container-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 12px 24px;
        border: none;
        border-radius: 5px;
        /*visibility: hidden;*/
    }

    .container-btn-relative {
        position: relative;
        /*visibility: hidden;*/
    }

    .container-btn-relative .btn {
        color: white;
    }

    .progressbar {
        position: absolute;
        width: 200px;
        height: 200px;
    }

    .uploader {
        width: 100%;
        /*background: #2196F3;*/
        color: black;
        padding: 40px 15px;
        text-align: center;
        border-radius: 3px;
        border: 2px solid;
        border-color: darkgrey;
        font-size: 20px;
        position: relative;

        &.dragging {
            background: #fff;
            color: #2196F3;
            border: 3px dashed #2196F3;

            .file-input label {
                background: #2196F3;
                color: #fff;
            }
        }

        i {
            font-size: 85px;
        }

        .file-input {
            width: 200px;
            margin: auto;
            height: 68px;
            position: relative;

            label,
            input {
                background: #fff;
                color: #2196F3;
                width: 100%;
                position: absolute;
                left: 0;
                top: 0;
                padding: 10px;
                border-radius: 4px;
                margin-top: 7px;
                cursor: pointer;
            }

            input {
                opacity: 0;
                z-index: -2;
            }
        }

        .images-preview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;

            .img-wrapper {
                width: 250px;
                display: flex;
                flex-direction: column;
                margin: 10px;
                height: 250px;
                justify-content: space-between;
                background: #fff;
                /*box-shadow: 5px 5px 20px #3e3737;*/

                img {
                    height: 100%;
                    width: 100%;
                }
            }

            .details {
                font-size: 12px;
                background: #fff;
                color: #000;
                display: flex;
                flex-direction: column;
                align-items: self-start;
                /*padding: 3px 6px;*/
                .name {
                    overflow: hidden;
                    height: 18px;
                }
            }
        }

        .upload-control {
            position: absolute;
            width: 100%;
            background: #fff;
            top: 0;
            left: 0;
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            padding: 10px;
            padding-bottom: 4px;
            text-align: right;

            button, label {
                /*background: #2196F3;*/
                border: 2px solid #03A9F4;
                border-radius: 3px;
                color: #fff;
                font-size: 15px;
                cursor: pointer;
            }

            label {
                padding: 2px 5px;
                margin-right: 10px;
            }
        }
    }
</style>